<?php
/*
 * ── FreeWheel Expeditions — Theme Functions ──
 * Sucuri WAF: allow our REST endpoints to receive raw POST bodies
 */
// Prevent Sucuri from blocking/stripping POST body on our REST endpoints
add_filter( 'sucuriscan_event_ignore_list', function( $list ) {
    $list[] = 'freewheel/v1/subscribe';
    $list[] = 'freewheel/v1/send-welcome';
    return $list;
} );

// Ensure WP REST API reads raw body for our endpoints (Sucuri compat)
add_filter( 'rest_pre_dispatch', function( $result, $server, $request ) {
    $route = $request->get_route();
    if ( strpos( $route, '/freewheel/v1/' ) !== false ) {
        // Force WP to re-read body from php://input if get_json_params is empty
        if ( empty( $request->get_json_params() ) && empty( $request->get_body_params() ) ) {
            $raw = file_get_contents( 'php://input' );
            if ( $raw ) {
                // Try JSON first
                $decoded = json_decode( $raw, true );
                if ( json_last_error() === JSON_ERROR_NONE && is_array( $decoded ) ) {
                    foreach ( $decoded as $k => $v ) {
                        $request->set_param( $k, $v );
                    }
                } else {
                    // Try form-encoded
                    parse_str( $raw, $parsed );
                    foreach ( $parsed as $k => $v ) {
                        $request->set_param( $k, $v );
                    }
                }
            }
        }
    }
    return $result;
}, 10, 3 );

/**
 * FreeWheel Expeditions — functions.php v3.0
 * Full admin-editable theme: Expeditions, Albums, Products
 */

/* ═══════════════════════════════════
   1. THEME SETUP & ASSETS
═══════════════════════════════════ */
function freewheel_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('wp-body-open');
    add_image_size('expedition-thumb', 800, 500, true);
    add_image_size('product-square',    800, 800, true);
}
add_action('after_setup_theme', 'freewheel_setup');

/* =============================================
   FREEWHEEL - Supabase + SMS Config
   ============================================= */
// Supabase keys — define in wp-config.php for security.
// Fallbacks here prevent fatal errors if wp-config.php not yet updated.
// ── Credentials MUST be defined in wp-config.php. Never hardcode here. ──
// Add these lines to wp-config.php (above "That's all, stop editing!"):
//   define( 'FW_SUPABASE_URL',     'https://YOUR_PROJECT.supabase.co' );
//   define( 'FW_SUPABASE_ANON',    'YOUR_ANON_PUBLIC_KEY' );
//   define( 'FW_SUPABASE_SERVICE', 'YOUR_SERVICE_ROLE_KEY' );
//   define( 'FW_FAST2SMS_KEY',     'YOUR_FAST2SMS_API_KEY' );
if ( ! defined( 'FW_SUPABASE_URL' ) )     define( 'FW_SUPABASE_URL',     '' );
if ( ! defined( 'FW_SUPABASE_ANON' ) )    define( 'FW_SUPABASE_ANON',    '' );
if ( ! defined( 'FW_SUPABASE_SERVICE' ) ) define( 'FW_SUPABASE_SERVICE', '' );
if ( ! defined( 'FW_FAST2SMS_KEY' ) )     define( 'FW_FAST2SMS_KEY',     '' );

/* Output config to frontend — Supabase keys are NOT passed to the browser */
add_action( 'wp_head', function() {
    $j = admin_url( 'admin-ajax.php' );
    $r = untrailingslashit( rest_url( 'freewheel/v1' ) );
    $n = wp_create_nonce( 'wp_rest' );
    $theme_url = get_template_directory_uri();
    // NOTE: FW_SUPABASE_URL and FW_SUPABASE_ANON are intentionally NOT exposed here.
    // All Supabase calls go through server-side PHP REST endpoints.
    echo '<script>window.FW_AJAX_URL="' . esc_js($j) . '";window.FW_REST_URL="' . esc_js($r) . '";window.FW_REST_NONCE="' . esc_js($n) . '";window.FW_THEME_URL="' . esc_js($theme_url) . '";</script>' . "\n";
}, 1 );

/* REST endpoints */
add_action( 'rest_api_init', function() {
    /* /send-otp, /verify-otp, /create-user, /save-profile — removed; registration system reserved */
    register_rest_route( 'freewheel/v1', '/subscribe', array(
        'methods' => 'POST', 'callback' => 'fw_rest_subscribe', 'permission_callback' => '__return_true',
    ) );
    register_rest_route( 'freewheel/v1', '/send-welcome', array(
        'methods' => 'POST', 'callback' => 'fw_rest_send_welcome', 'permission_callback' => '__return_true',
    ) );
} );

/* ── fw_rest_subscribe: validate → stash data → trigger Supabase Auth OTP ── */
function fw_rest_subscribe( $req ) {

    // ── Read params — support both JSON body and form-encoded ──
    $json = $req->get_json_params();
    if ( ! empty( $json ) ) {
        $name   = sanitize_text_field( isset($json['name'])   ? $json['name']   : '' );
        $email  = sanitize_email(      isset($json['email'])  ? $json['email']  : '' );
        $phone  = sanitize_text_field( isset($json['phone'])  ? $json['phone']  : '' );
        $source = sanitize_text_field( isset($json['source']) ? $json['source'] : 'website' );
    } else {
        $name   = sanitize_text_field( $req->get_param('name') );
        $email  = sanitize_email(      $req->get_param('email') );
        $phone  = sanitize_text_field( $req->get_param('phone') );
        $source = sanitize_text_field( $req->get_param('source') ?: 'website' );
    }

    if ( ! $name )            return new WP_Error( 'missing_name',  'Please enter your name.',    array( 'status' => 400 ) );
    if ( ! is_email($email) ) return new WP_Error( 'invalid_email', 'Please enter a valid email.', array( 'status' => 400 ) );

    // Stash meta for /send-welcome
    set_transient( 'fw_sub_meta_' . md5($email), array( 'name' => $name, 'phone' => $phone, 'source' => $source ), 600 );

    // ── Call Supabase via cURL (bypasses WP HTTP API entirely) ──
    $sb_url  = FW_SUPABASE_URL;
    $sb_anon = FW_SUPABASE_ANON;

    if ( empty($sb_url) || empty($sb_anon) ) {
        return new WP_Error( 'config_missing', 'Supabase credentials not configured in wp-config.php.', array( 'status' => 500 ) );
    }

    $payload = json_encode( array(
        'email'       => $email,
        'create_user' => true,
        'options'     => array( 'shouldCreateUser' => true ),
    ) );

    $ch = curl_init( $sb_url . '/auth/v1/otp' );
    curl_setopt_array( $ch, array(
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => $payload,
        CURLOPT_HTTPHEADER     => array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($payload),
            'apikey: '         . $sb_anon,
            'Authorization: Bearer ' . $sb_anon,
        ),
        CURLOPT_TIMEOUT        => 15,
        CURLOPT_SSL_VERIFYPEER => true,
    ) );

    $curl_body = curl_exec($ch);
    $curl_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curl_err  = curl_error($ch);
    curl_close($ch);

    if ( $curl_err ) {
        return new WP_Error( 'curl_fail', 'Could not reach verification service: ' . $curl_err, array( 'status' => 500 ) );
    }

    if ( $curl_code >= 400 ) {
        $body = json_decode( $curl_body, true );
        $msg  = isset($body['msg'])     ? $body['msg']
              : ( isset($body['message']) ? $body['message']
              : ( isset($body['error_description']) ? $body['error_description']
              : 'Could not send code (HTTP ' . $curl_code . ').' ) );
        return new WP_Error( 'sb_error', $msg, array( 'status' => 500 ) );
    }

    return rest_ensure_response( array( 'success' => true, 'message' => 'Verification code sent to ' . $email ) );
}

/* ── fw_rest_send_welcome: verify Supabase OTP → store subscriber (new schema) ── */
function fw_rest_send_welcome( $req ) {
    $jwelcome = $req->get_json_params();
    $email = sanitize_email(      isset($jwelcome['email']) ? $jwelcome['email'] : $req->get_param('email') );
    $otp   = sanitize_text_field( isset($jwelcome['otp'])   ? $jwelcome['otp']   : $req->get_param('otp') );

    if ( ! is_email($email) ) return new WP_Error( 'invalid', 'Invalid email.', array( 'status' => 400 ) );
    if ( ! $otp )             return new WP_Error( 'missing', 'Please enter the verification code.', array( 'status' => 400 ) );

    // Retrieve stashed subscriber meta (set by fw_rest_subscribe)
    $meta   = get_transient( 'fw_sub_meta_' . md5($email) );
    $name   = $meta ? $meta['name']   : '';
    $mobile = $meta ? $meta['phone']  : '';  // stored as 'phone' key in transient
    $source = $meta ? $meta['source'] : 'website';

    // ── Verify OTP via Supabase Auth (server-side only — no key exposed to browser) ──
    $sb_url  = FW_SUPABASE_URL;
    $sb_anon = FW_SUPABASE_ANON;

    if ( ! $sb_url || ! $sb_anon ) {
        return new WP_Error( 'config_missing', 'Server not configured. Please contact the administrator.', array( 'status' => 500 ) );
    }

    // ── Verify OTP via cURL (bypasses WP HTTP API) ──
    $vpayload = json_encode( array( 'email' => $email, 'token' => $otp, 'type' => 'magiclink' ) );
    $vch = curl_init( $sb_url . '/auth/v1/verify' );
    curl_setopt_array( $vch, array(
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => $vpayload,
        CURLOPT_HTTPHEADER     => array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($vpayload),
            'apikey: '         . $sb_anon,
            'Authorization: Bearer ' . $sb_anon,
        ),
        CURLOPT_TIMEOUT        => 15,
        CURLOPT_SSL_VERIFYPEER => true,
    ) );
    $vbody     = curl_exec($vch);
    $vcode     = curl_getinfo($vch, CURLINFO_HTTP_CODE);
    $verr      = curl_error($vch);
    curl_close($vch);

    if ( $verr )    return new WP_Error( 'curl_fail',   'Verification service unreachable: ' . $verr, array( 'status' => 500 ) );
    if ( $vcode >= 400 ) return new WP_Error( 'invalid_otp', 'Incorrect code. Please try again.', array( 'status' => 400 ) );

    // OTP verified — clear stashed meta
    delete_transient( 'fw_sub_meta_' . md5($email) );

    // ── Upsert into Supabase fw_subscribers using new schema ──
    // TABLE SCHEMA (run once in Supabase SQL Editor):
    //
    //   CREATE TABLE IF NOT EXISTS fw_subscribers (
    //     id             uuid DEFAULT gen_random_uuid() PRIMARY KEY,
    //     name           text NOT NULL,
    //     mobile         text,
    //     email          text UNIQUE NOT NULL,
    //     email_verified boolean DEFAULT false,
    //     subscribed_at  timestamptz DEFAULT now()
    //   );
    //   ALTER TABLE fw_subscribers ENABLE ROW LEVEL SECURITY;
    //   CREATE POLICY "service_insert" ON fw_subscribers FOR INSERT WITH CHECK (true);
    //   CREATE POLICY "service_select" ON fw_subscribers FOR SELECT USING (true);
    //
    // NOTE: service role key is used server-side only — never exposed to browser.

    $sb_service = FW_SUPABASE_SERVICE;
    $already    = false;

    // Check for existing subscriber first (prevent duplicate insert error)
    $cch = curl_init( $sb_url . '/rest/v1/fw_subscribers?email=eq.' . rawurlencode($email) . '&select=id' );
    curl_setopt_array( $cch, array(
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER     => array(
            'Content-Type: application/json',
            'apikey: '         . $sb_service,
            'Authorization: Bearer ' . $sb_service,
        ),
        CURLOPT_TIMEOUT        => 10,
        CURLOPT_SSL_VERIFYPEER => true,
    ) );
    $cbody = curl_exec($cch);
    curl_close($cch);
    $check_body = json_decode( $cbody, true );
    if ( is_array($check_body) && count($check_body) > 0 ) {
        $already = true;
    }

    if ( ! $already ) {
        $ipayload = json_encode( array(
            'name'           => $name,
            'mobile'         => $mobile ?: null,
            'email'          => $email,
            'email_verified' => true,
            'subscribed_at'  => date('c'),
        ) );
        $ich = curl_init( $sb_url . '/rest/v1/fw_subscribers' );
        curl_setopt_array( $ich, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $ipayload,
            CURLOPT_HTTPHEADER     => array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($ipayload),
                'apikey: '         . $sb_service,
                'Authorization: Bearer ' . $sb_service,
                'Prefer: return=minimal',
            ),
            CURLOPT_TIMEOUT        => 15,
            CURLOPT_SSL_VERIFYPEER => true,
        ) );
        $ibody = curl_exec($ich);
        $icode = curl_getinfo($ich, CURLINFO_HTTP_CODE);
        $ierr  = curl_error($ich);
        curl_close($ich);

        if ( $ierr ) {
            error_log( '[FW] fw_subscribers curl error: ' . $ierr );
            return new WP_Error( 'db_fail', 'Database error saving subscriber. Please try again.', array( 'status' => 500 ) );
        }
        if ( $icode === 409 ) {
            $already = true;
        } elseif ( $icode >= 400 ) {
            $ierr_body = json_decode( $ibody, true );
            $imsg = isset($ierr_body['message']) ? $ierr_body['message'] : ( isset($ierr_body['msg']) ? $ierr_body['msg'] : 'Unknown error' );
            error_log( '[FW] fw_subscribers insert failed ' . $icode . ': ' . $imsg );
            return new WP_Error( 'db_fail', 'Database error saving subscriber: ' . $imsg, array( 'status' => 500 ) );
        }
    }

    // ── Backup list in WP options (offline safety net) ──
    $subs = get_option( 'fw_subscribers_v2', array() );
    $exists_local = false;
    foreach ( $subs as $s ) { if ( $s['email'] === $email ) { $exists_local = true; break; } }
    if ( ! $exists_local ) {
        $subs[] = array(
            'name'           => $name,
            'email'          => $email,
            'mobile'         => $mobile,
            'email_verified' => true,
            'subscribed_at'  => date('Y-m-d H:i:s'),
            'source'         => $source,
        );
        update_option( 'fw_subscribers_v2', $subs );
        // Admin notification
        wp_mail(
            'freewheelexpeditions@gmail.com',
            'New Subscriber: ' . $name,
            "New verified subscriber on FreeWheel Expeditions.\n\nName   : {$name}\nEmail  : {$email}\nMobile : {$mobile}\nSource : {$source}"
        );
    }

    // ── Welcome email placeholder (content to be updated) ──
    // TO_BE_UPDATED: Replace the body below with final welcome email content.
    if ( ! $already ) {
        $welcome_subject = 'You just joined the FreeWheel Expeditions tribe.';
        $welcome_body = '<!DOCTYPE html><html><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"></head><body style="margin:0;padding:0;background:#0f0d0b;font-family:Georgia,serif"><table width="100%" cellpadding="0" cellspacing="0" style="background:#0f0d0b;padding:40px 20px"><tr><td align="center"><table width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%"><tr><td style="background:#c1440e;padding:32px 40px;text-align:center"><div style="font-family:Impact,Arial Black,sans-serif;font-size:28px;letter-spacing:4px;color:#fff;text-transform:uppercase">FreeWheel Expeditions</div><div style="font-size:12px;letter-spacing:3px;color:rgba(255,255,255,0.7);margin-top:6px;text-transform:uppercase">The Road Awaits</div></td></tr><tr><td style="background:#1a1410;padding:48px 40px;text-align:center;border-left:1px solid #2a2420;border-right:1px solid #2a2420"><div style="font-size:48px;margin-bottom:20px">&#x1F3D4;</div><div style="font-family:Impact,Arial Black,sans-serif;font-size:32px;letter-spacing:3px;color:#fff;text-transform:uppercase;margin-bottom:8px">Hey ' . $name . ',</div><div style="font-family:Impact,Arial Black,sans-serif;font-size:22px;letter-spacing:2px;color:#c1440e;text-transform:uppercase;margin-bottom:32px">You\'re In.</div><div style="font-size:15px;color:rgba(255,255,255,0.75);line-height:1.9;margin-bottom:32px;text-align:left">FreeWheel Expeditions is where the restless find their tribe. We don\'t do tours. We do raw, unfiltered road journeys across India.<br><br>Mountain passes. Desert highways. Coastal runs. Jungle tracks. If it demands grit and rewards with something unforgettable — <strong style="color:#e8a020">we\'re already planning it.</strong><br><br>You\'ll hear from us when the next ride drops. Keep your bags half-packed.</div><a href="https://freewheelexpeditions.in" style="display:inline-block;background:#c1440e;color:#fff;font-family:Impact,Arial Black,sans-serif;font-size:18px;letter-spacing:3px;text-transform:uppercase;padding:16px 40px;text-decoration:none;border-radius:2px">BLAZE THE TRAIL &#8594;</a></td></tr><tr><td style="background:#0f0d0b;padding:24px 40px;text-align:center;border:1px solid #2a2420;border-top:none"><div style="font-size:12px;color:rgba(255,255,255,0.3);letter-spacing:1px">Stay Untamed &nbsp;&middot;&nbsp; FreeWheel Expeditions &nbsp;&middot;&nbsp; freewheelexpeditions.in</div></td></tr></table></td></tr></table></body></html>';
        $welcome_headers = array('Content-Type: text/html; charset=UTF-8');
        wp_mail( $email, $welcome_subject, $welcome_body, $welcome_headers );
    }

    return rest_ensure_response( array( 'success' => true, 'already' => $already ) );
}


/* fw_create_supabase_user() — removed; registration system reserved */

/* fw_save_profile() — removed; registration system reserved */

function freewheel_enqueue_assets() {
    wp_enqueue_style('freewheel-fonts',
        'https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Barlow:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400&display=swap', array(), null);
    wp_enqueue_style('freewheel-main', get_template_directory_uri().'/fw-styles.css', array(), '5.1');
    // Supabase JS: must load in HEAD because page-dashboard.php and page-register.php
    // call supabase.createClient() in inline <script> blocks within the page body.
    // Moving this to footer (true) would break auth — keep as false (head).
    wp_enqueue_script('supabase-js', 'https://cdn.jsdelivr.net/npm/@supabase/supabase-js@2', array(), null, false);
    wp_enqueue_script('razorpay-checkout', get_template_directory_uri() . '/checkout.js', array(), null, false);

/* Force Razorpay script in head as fallback */
add_action( 'wp_head', function() {
    echo '<script src="https://freewheelexpeditions.in/wp-content/themes/freewheel-expeditions-theme/checkout.js"></script>' . "\n";
    echo '<script>if(typeof Razorpay==="undefined"){document.write(\'<script src="https://checkout.razorpay.com/v1/checkout.js"><\/script>\');}</script>' . "\n";
}, 2 );

/* Allow Razorpay in Content Security Policy */
add_filter( 'wp_headers', function( $headers ) {
    if ( isset( $headers['Content-Security-Policy'] ) ) {
        $headers['Content-Security-Policy'] = str_replace(
            "script-src",
            "script-src https://checkout.razorpay.com https://api.razorpay.com",
            $headers['Content-Security-Policy']
        );
    }
    return $headers;
} );
    wp_enqueue_script('fw-data', get_template_directory_uri().'/fw-data.js', array(), '5.1', true);
    wp_enqueue_script('fw-scripts', get_template_directory_uri().'/fw-scripts.js', array('fw-data'), '5.1', true);
    wp_localize_script('fw-scripts', 'FW_AUTH', array(
        'rest_url'      => esc_url_raw( rest_url('freewheel/v1') ),
        'supabase_url'  => FW_SUPABASE_URL,
        'supabase_key'  => FW_SUPABASE_ANON,
        'dashboard_url' => esc_url( home_url('/dashboard/') ),
        'login_url'     => esc_url( home_url('/login/') ),
        'register_url'  => esc_url( home_url('/register/') ),
        'home_url'      => esc_url( home_url('/') ),
    ));
}
add_action('wp_enqueue_scripts', 'freewheel_enqueue_assets');

add_filter('elementor/theme/get_location', '__return_false', 999);
add_filter('elementor_pro/theme_builder/conditions/get_location_for_template', '__return_false', 999);
add_action('elementor/theme/register_locations', function($manager) {}, 999);
add_filter('woocommerce_show_page_title', '__return_false');
add_filter('sidebars_widgets', '__return_empty_array');
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('wp_head', 'wp_generator');


/* ═══════════════════════════════════════════════════════════
   REGISTRATION & AUTH SYSTEM — Phase 2
   Endpoints: /fw-register /fw-get-profile /fw-update-profile /fw-credit-history
═══════════════════════════════════════════════════════════ */

add_action( 'rest_api_init', function() {
    register_rest_route( 'freewheel/v1', '/fw-register', array(
        'methods' => 'POST', 'callback' => 'fw_register_member', 'permission_callback' => '__return_true',
    ));
    register_rest_route( 'freewheel/v1', '/fw-get-profile', array(
        'methods' => 'GET', 'callback' => 'fw_get_member_profile', 'permission_callback' => '__return_true',
    ));
    register_rest_route( 'freewheel/v1', '/fw-update-profile', array(
        'methods' => 'POST', 'callback' => 'fw_update_member_profile', 'permission_callback' => '__return_true',
    ));
    register_rest_route( 'freewheel/v1', '/fw-credit-history', array(
        'methods' => 'GET', 'callback' => 'fw_get_credit_history', 'permission_callback' => '__return_true',
    ));
});

/* ── Helper: validate Supabase JWT, return user array or WP_Error ── */
function fw_validate_token( $request ) {
    $auth = $request->get_header( 'authorization' );
    if ( ! $auth || strpos( $auth, 'Bearer ' ) !== 0 ) {
        return new WP_Error( 'unauthorized', 'Missing authorization header.', array( 'status' => 401 ) );
    }
    $token = substr( $auth, 7 );
    $resp  = wp_remote_get( FW_SUPABASE_URL . '/auth/v1/user', array(
        'headers' => array(
            'apikey'        => FW_SUPABASE_ANON,
            'Authorization' => 'Bearer ' . $token,
        ),
        'timeout' => 10,
    ));
    if ( is_wp_error( $resp ) ) {
        return new WP_Error( 'auth_fail', 'Authentication service unavailable.', array( 'status' => 503 ) );
    }
    $body = json_decode( wp_remote_retrieve_body( $resp ), true );
    if ( empty( $body['id'] ) ) {
        return new WP_Error( 'unauthorized', 'Invalid or expired session. Please log in again.', array( 'status' => 401 ) );
    }
    return $body;
}

/* ── Helper: award credits (always via service role) ── */
function fw_give_credits( $user_id, $amount, $reason, $ref_id = '', $ref_type = '', $note = '' ) {
    $payload = array(
        'user_id'        => $user_id,
        'amount'         => (int) $amount,
        'reason'         => $reason,
        'reference_id'   => $ref_id,
        'reference_type' => $ref_type,
        'note'           => $note,
        'expires_at'     => $amount > 0 ? date( 'c', strtotime( '+12 months' ) ) : null,
        'created_by'     => 'system',
    );
    $resp = wp_remote_post( FW_SUPABASE_URL . '/rest/v1/fw_credits', array(
        'headers'     => array(
            'apikey'        => FW_SUPABASE_SERVICE,
            'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE,
            'Content-Type'  => 'application/json',
            'Prefer'        => 'return=minimal',
        ),
        'body'        => wp_json_encode( $payload ),
        'timeout'     => 10,
        'data_format' => 'body',
    ));
    return ! is_wp_error( $resp ) && wp_remote_retrieve_response_code( $resp ) < 300;
}

/* ── Helper: get credit balance for a user (excludes expired) ── */
function fw_credit_balance( $user_id ) {
    $resp = wp_remote_get(
        FW_SUPABASE_URL . '/rest/v1/fw_credits?user_id=eq.' . rawurlencode( $user_id ) . '&select=amount,expires_at',
        array(
            'headers' => array(
                'apikey'        => FW_SUPABASE_SERVICE,
                'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE,
            ),
            'timeout' => 10,
        )
    );
    $credits = json_decode( wp_remote_retrieve_body( $resp ), true );
    if ( ! is_array( $credits ) ) $credits = array();
    $balance = 0;
    $now = time();
    foreach ( $credits as $c ) {
        if ( ! is_array( $c ) ) continue;
        if ( is_null( $c['expires_at'] ) || strtotime( $c['expires_at'] ) > $now ) {
            $balance += (int) $c['amount'];
        }
    }
    return max( 0, $balance );
}

/* ── Helper: get loyalty tier from trips_completed count ── */
function fw_loyalty_tier( $trips ) {
    $trips = (int) $trips;
    if ( $trips >= 6 ) return array( 'name' => 'Legend',      'discount' => 10, 'label' => '10% OFF on every trip', 'next' => null );
    if ( $trips >= 3 ) return array( 'name' => 'Pioneer',     'discount' => 8,  'label' => '8% OFF on every trip',  'next' => 'Legend at 6 trips' );
    if ( $trips >= 1 ) return array( 'name' => 'Road Warrior','discount' => 5,  'label' => '5% OFF on every trip',  'next' => 'Pioneer at 3 trips' );
    return array( 'name' => 'Explorer', 'discount' => 0, 'label' => 'Complete your first trip', 'next' => 'Road Warrior after trip 1' );
}

/* ── fw_register_member — POST /fw-register ── */
function fw_register_member( $request ) {
    $user = fw_validate_token( $request );
    if ( is_wp_error( $user ) ) return $user;

    $user_id = $user['id'];
    $email   = $user['email'];

    // Check if already registered
    $check = wp_remote_get(
        FW_SUPABASE_URL . '/rest/v1/fw_members?id=eq.' . rawurlencode( $user_id ) . '&select=id,first_name',
        array(
            'headers' => array(
                'apikey'        => FW_SUPABASE_SERVICE,
                'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE,
            ),
            'timeout' => 10,
        )
    );
    $existing = json_decode( wp_remote_retrieve_body( $check ), true );
    if ( ! empty( $existing[0]['id'] ) ) {
        return rest_ensure_response( array( 'success' => true, 'existing' => true, 'name' => $existing[0]['first_name'] ) );
    }

    $p          = $request->get_json_params() ?: array();
    $first_name = sanitize_text_field( $p['first_name'] ?? '' );
    $last_name  = sanitize_text_field( $p['last_name']  ?? '' );
    $phone      = sanitize_text_field( $p['phone']      ?? '' );
    $city       = sanitize_text_field( $p['city']       ?? '' );
    $state      = sanitize_text_field( $p['state']      ?? '' );
    $country    = sanitize_text_field( $p['country']    ?? 'India' );

    if ( ! $first_name ) {
        return new WP_Error( 'missing', 'First name is required.', array( 'status' => 400 ) );
    }

    // Create fw_members row
    $member_resp = wp_remote_post( FW_SUPABASE_URL . '/rest/v1/fw_members', array(
        'headers'     => array(
            'apikey'        => FW_SUPABASE_SERVICE,
            'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE,
            'Content-Type'  => 'application/json',
            'Prefer'        => 'return=minimal',
        ),
        'body'        => wp_json_encode( array(
            'id'         => $user_id,
            'first_name' => $first_name,
            'last_name'  => $last_name,
            'email'      => $email,
            'phone'      => $phone,
            'city'       => $city,
            'state'      => $state,
            'country'    => $country,
        )),
        'timeout'     => 15,
        'data_format' => 'body',
    ));

    if ( is_wp_error( $member_resp ) || wp_remote_retrieve_response_code( $member_resp ) >= 300 ) {
        $err_body = wp_remote_retrieve_body( $member_resp );
        $err_code = wp_remote_retrieve_response_code( $member_resp );
        $err_detail = is_wp_error( $member_resp ) ? $member_resp->get_error_message() : $err_body;
        error_log( '[FW] fw_members insert failed ' . $err_code . ': ' . $err_detail );
        return new WP_Error( 'db_fail', 'Database error saving new user: ' . $err_code . ' - ' . $err_detail, array( 'status' => 500 ) );
    }

    // Award 50 registration credits
    fw_give_credits( $user_id, 50, 'registration', $user_id, 'member', 'Welcome bonus — registration' );

    // Send welcome email via Brevo
    fw_send_welcome_email( $email, $first_name );

    return rest_ensure_response( array(
        'success'         => true,
        'existing'        => false,
        'credits_awarded' => 50,
        'name'            => $first_name,
    ));
}

/* ── fw_send_welcome_email — Send branded welcome email via Brevo API ── */
function fw_send_welcome_email( $email, $first_name ) {
    $brevo_api_key = defined('FW_BREVO_API_KEY') ? FW_BREVO_API_KEY : '';
    if ( ! $brevo_api_key ) {
        error_log('[FW] Welcome email skipped: FW_BREVO_API_KEY not defined.');
        return;
    }

    $html_content = '<!DOCTYPE html><html><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"></head><body style="margin:0;padding:0;background:#0a0806;font-family:Georgia,serif;"><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#0a0806;min-height:100vh;"><tr><td align="center" style="padding:40px 20px;"><table width="600" cellpadding="0" cellspacing="0" border="0" style="max-width:600px;width:100%;"><tr><td style="background:#c1440e;padding:36px 48px;text-align:center;"><h1 style="margin:0 0 6px;font-size:22px;color:#ffffff;font-family:Arial,sans-serif;font-weight:bold;letter-spacing:4px;text-transform:uppercase;">FREEWHEEL EXPEDITIONS</h1><p style="margin:0;font-size:10px;letter-spacing:3px;text-transform:uppercase;color:rgba(255,255,255,0.7);font-family:Arial,sans-serif;">THE ROAD AWAITS</p></td></tr><tr><td style="background:#0f0d0b;padding:48px 48px 16px;text-align:center;"><p style="margin:0 0 24px;font-size:32px;">&#9968;&#65039;</p><h2 style="margin:0 0 8px;font-size:28px;color:#ffffff;font-family:Arial,sans-serif;font-weight:bold;letter-spacing:2px;text-transform:uppercase;">HEY ' . esc_html( strtoupper($first_name) ) . ',</h2><p style="margin:0 0 32px;font-size:16px;color:#c1440e;font-family:Arial,sans-serif;font-weight:bold;letter-spacing:2px;text-transform:uppercase;">YOU\'RE IN.</p><p style="margin:0 0 20px;font-size:14px;color:rgba(255,255,255,0.6);line-height:1.8;font-family:Arial,sans-serif;text-align:left;">FreeWheel Expeditions is where the restless find their tribe. We don\'t do tours. We do raw, unfiltered road journeys across India.</p><p style="margin:0 0 32px;font-size:14px;color:rgba(255,255,255,0.6);line-height:1.8;font-family:Arial,sans-serif;text-align:left;">Mountain passes. Desert highways. Coastal runs. Jungle tracks. If it demands grit and rewards with something unforgettable — <a href="https://freewheelexpeditions.in/expeditions/" style="color:#c1440e;text-decoration:none;font-weight:bold;">we\'re already planning it.</a></p><p style="margin:0 0 40px;font-size:14px;color:rgba(255,255,255,0.6);line-height:1.8;font-family:Arial,sans-serif;text-align:left;">You\'ll hear from us when the next ride drops. Keep your bags half-packed.</p><table cellpadding="0" cellspacing="0" border="0" style="margin:0 auto 40px;"><tr><td style="background:#c1440e;border-radius:2px;"><a href="https://freewheelexpeditions.in/expeditions/" style="display:inline-block;padding:16px 36px;font-size:13px;font-weight:bold;letter-spacing:3px;text-transform:uppercase;color:#ffffff;text-decoration:none;font-family:Arial,sans-serif;">BLAZE THE TRAIL &#8594;</a></td></tr></table></td></tr><tr><td style="background:#0a0806;border-top:1px solid rgba(255,255,255,0.06);padding:24px 48px;text-align:center;"><p style="margin:0;font-size:12px;color:rgba(255,255,255,0.25);font-family:Arial,sans-serif;line-height:1.8;">Stay Untamed &nbsp;&middot;&nbsp; FreeWheel Expeditions &nbsp;&middot;&nbsp; <a href="https://freewheelexpeditions.in" style="color:#c1440e;text-decoration:none;">freewheelexpeditions.in</a></p></td></tr></table></td></tr></table></body></html>';

    $response = wp_remote_post( 'https://api.brevo.com/v3/smtp/email', array(
        'headers' => array(
            'api-key'      => $brevo_api_key,
            'Content-Type' => 'application/json',
            'Accept'       => 'application/json',
        ),
        'body' => wp_json_encode( array(
            'sender'      => array( 'name' => 'FreeWheel Expeditions', 'email' => 'hello@freewheelexpeditions.in' ),
            'to'          => array( array( 'email' => $email, 'name' => $first_name ) ),
            'subject'     => 'Hey ' . $first_name . ', You\'re In. 🏔️',
            'htmlContent' => $html_content,
        )),
        'timeout'     => 15,
        'data_format' => 'body',
    ));

    $code = wp_remote_retrieve_response_code( $response );
    $body = wp_remote_retrieve_body( $response );
    if ( is_wp_error( $response ) ) {
        error_log( '[FW] Welcome email WP_Error: ' . $response->get_error_message() );
    } elseif ( $code >= 300 ) {
        error_log( '[FW] Welcome email HTTP ' . $code . ': ' . $body );
    } else {
        error_log( '[FW] Welcome email sent OK to ' . $email . ' HTTP ' . $code );
    }
}

/* ── fw_get_member_profile — GET /fw-get-profile ── */
function fw_get_member_profile( $request ) {
    $user = fw_validate_token( $request );
    if ( is_wp_error( $user ) ) return $user;

    $user_id = $user['id'];

    $resp = wp_remote_get(
        FW_SUPABASE_URL . '/rest/v1/fw_members?id=eq.' . rawurlencode( $user_id ),
        array(
            'headers' => array(
                'apikey'        => FW_SUPABASE_SERVICE,
                'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE,
            ),
            'timeout' => 10,
        )
    );

    $profiles = json_decode( wp_remote_retrieve_body( $resp ), true );
    if ( empty( $profiles[0] ) ) {
        return new WP_Error( 'not_found', 'Profile not found. Please register first.', array( 'status' => 404 ) );
    }
    $profile = $profiles[0];
    $balance = fw_credit_balance( $user_id );
    $tier    = fw_loyalty_tier( $profile['trips_completed'] );

    return rest_ensure_response( array(
        'success'        => true,
        'profile'        => $profile,
        'credit_balance' => $balance,
        'credit_value'   => round( $balance * 0.25, 2 ),
        'can_redeem'     => $balance >= 400,
        'tier'           => $tier,
    ));
}

/* ── fw_update_member_profile — POST /fw-update-profile ── */
function fw_update_member_profile( $request ) {
    $user = fw_validate_token( $request );
    if ( is_wp_error( $user ) ) return $user;

    $user_id = $user['id'];
    $p       = $request->get_json_params() ?: array();

    $allowed = array( 'first_name', 'last_name', 'phone', 'city', 'state', 'country', 'instagram', 'bio', 'avatar_url' );
    $update  = array( 'updated_at' => date( 'c' ) );
    foreach ( $allowed as $field ) {
        if ( isset( $p[ $field ] ) ) {
            $update[ $field ] = sanitize_text_field( $p[ $field ] );
        }
    }

    $resp = wp_remote_request(
        FW_SUPABASE_URL . '/rest/v1/fw_members?id=eq.' . rawurlencode( $user_id ),
        array(
            'method'      => 'PATCH',
            'headers'     => array(
                'apikey'        => FW_SUPABASE_SERVICE,
                'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE,
                'Content-Type'  => 'application/json',
                'Prefer'        => 'return=minimal',
            ),
            'body'        => wp_json_encode( $update ),
            'timeout'     => 15,
        )
    );

    if ( is_wp_error( $resp ) || wp_remote_retrieve_response_code( $resp ) >= 300 ) {
        return new WP_Error( 'db_fail', 'Profile update failed.', array( 'status' => 500 ) );
    }

    return rest_ensure_response( array( 'success' => true ) );
}

/* ── fw_get_credit_history — GET /fw-credit-history ── */
function fw_get_credit_history( $request ) {
    $user = fw_validate_token( $request );
    if ( is_wp_error( $user ) ) return $user;

    $user_id = $user['id'];
    $balance = fw_credit_balance( $user_id );

    $resp = wp_remote_get(
        FW_SUPABASE_URL . '/rest/v1/fw_credits?user_id=eq.' . rawurlencode( $user_id ) . '&order=created_at.desc&limit=50',
        array(
            'headers' => array(
                'apikey'        => FW_SUPABASE_SERVICE,
                'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE,
            ),
            'timeout' => 10,
        )
    );

    $history = json_decode( wp_remote_retrieve_body( $resp ), true ) ?: array();

    return rest_ensure_response( array(
        'success'        => true,
        'balance'        => $balance,
        'credit_value'   => round( $balance * 0.25, 2 ),
        'can_redeem'     => $balance >= 400,
        'history'        => $history,
    ));
}


add_action( 'rest_api_init', function() {
    register_rest_route( 'freewheel/v1', '/fw-get-bookings', array(
        'methods' => 'GET', 'callback' => 'fw_get_bookings', 'permission_callback' => '__return_true',
    ));
    register_rest_route( 'freewheel/v1', '/fw-get-orders', array(
        'methods' => 'GET', 'callback' => 'fw_get_orders', 'permission_callback' => '__return_true',
    ));
    register_rest_route( 'freewheel/v1', '/fw-upload-avatar', array(
        'methods' => 'POST', 'callback' => 'fw_upload_avatar', 'permission_callback' => '__return_true',
    ));
});

/* ── fw_get_bookings ── */
function fw_get_bookings( $request ) {
    $user = fw_validate_token( $request );
    if ( is_wp_error( $user ) ) return $user;

    $resp = wp_remote_get(
        FW_SUPABASE_URL . '/rest/v1/fw_bookings?user_id=eq.' . rawurlencode( $user['id'] ) . '&order=created_at.desc',
        array( 'headers' => array( 'apikey' => FW_SUPABASE_SERVICE, 'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE ), 'timeout' => 10 )
    );
    $bookings = json_decode( wp_remote_retrieve_body( $resp ), true ) ?: array();
    return rest_ensure_response( array( 'success' => true, 'bookings' => $bookings ) );
}

/* ── fw_get_orders ── */
function fw_get_orders( $request ) {
    $user = fw_validate_token( $request );
    if ( is_wp_error( $user ) ) return $user;

    $resp = wp_remote_get(
        FW_SUPABASE_URL . '/rest/v1/fw_orders?user_id=eq.' . rawurlencode( $user['id'] ) . '&order=created_at.desc',
        array( 'headers' => array( 'apikey' => FW_SUPABASE_SERVICE, 'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE ), 'timeout' => 10 )
    );
    $orders = json_decode( wp_remote_retrieve_body( $resp ), true ) ?: array();
    return rest_ensure_response( array( 'success' => true, 'orders' => $orders ) );
}

/* ── fw_upload_avatar ── */
function fw_upload_avatar( $request ) {
    $user = fw_validate_token( $request );
    if ( is_wp_error( $user ) ) return $user;

    if ( empty( $_FILES['avatar'] ) || $_FILES['avatar']['error'] !== UPLOAD_ERR_OK ) {
        return new WP_Error( 'no_file', 'No file uploaded.', array( 'status' => 400 ) );
    }

    $path = 'avatars/' . $user['id'] . '/' . time() . '_' . mt_rand(100,999);
    $url  = fw_upload_image( $_FILES['avatar'], $path );
    if ( is_wp_error( $url ) ) return $url;

    wp_remote_request(
        FW_SUPABASE_URL . '/rest/v1/fw_members?id=eq.' . rawurlencode( $user['id'] ),
        array(
            'method'  => 'PATCH',
            'headers' => array( 'apikey' => FW_SUPABASE_SERVICE, 'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE, 'Content-Type' => 'application/json', 'Prefer' => 'return=minimal' ),
            'body'    => wp_json_encode( array( 'avatar_url' => $url, 'updated_at' => date('c') ) ),
            'timeout' => 10,
        )
    );

    return rest_ensure_response( array( 'success' => true, 'url' => $url ) );
}


add_action( 'rest_api_init', function() {
    register_rest_route( 'freewheel/v1', '/fw-upload-trip-photo', array(
        'methods' => 'POST', 'callback' => 'fw_upload_trip_photo', 'permission_callback' => '__return_true',
    ));
});

function fw_upload_trip_photo( $request ) {
    $user = fw_validate_token( $request );
    if ( is_wp_error( $user ) ) return $user;

    if ( empty( $_FILES['photo'] ) || $_FILES['photo']['error'] !== UPLOAD_ERR_OK ) {
        return new WP_Error( 'no_file', 'No file uploaded.', array( 'status' => 400 ) );
    }

    $file       = $_FILES['photo'];
    $booking_id = sanitize_text_field( $_POST['booking_id'] ?? '' );
    $finfo      = finfo_open( FILEINFO_MIME_TYPE );
    $mimetype   = finfo_file( $finfo, $file['tmp_name'] );
    finfo_close( $finfo );

    $allowed = array( 'image/jpeg', 'image/png', 'image/webp' );
    if ( ! in_array( $mimetype, $allowed ) ) {
        return new WP_Error( 'invalid_type', 'Only JPG, PNG and WEBP allowed.', array( 'status' => 400 ) );
    }
    if ( $file['size'] > 5 * 1024 * 1024 ) {
        return new WP_Error( 'too_large', 'Max 5MB per photo.', array( 'status' => 400 ) );
    }

    // Check existing photo count for this booking
    $check = wp_remote_get(
        FW_SUPABASE_URL . '/rest/v1/fw_album_photos?album_id=eq.' . rawurlencode( $booking_id ) . '&select=id',
        array( 'headers' => array( 'apikey' => FW_SUPABASE_SERVICE, 'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE ), 'timeout' => 10 )
    );
    $existing = json_decode( wp_remote_retrieve_body( $check ), true ) ?: array();
    if ( count( $existing ) >= 6 ) {
        return new WP_Error( 'max_photos', 'Maximum 6 photos already uploaded for this trip.', array( 'status' => 400 ) );
    }

    $ext  = array( 'image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp' )[ $mimetype ];
    $path = 'trip-photos/' . $user['id'] . '/' . $booking_id . '/' . time() . '.' . $ext;

    $upload = wp_remote_request( FW_SUPABASE_URL . '/storage/v1/object/trip-photos/' . $path, array(
        'method'  => 'POST',
        'headers' => array(
            'apikey'        => FW_SUPABASE_SERVICE,
            'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE,
            'Content-Type'  => $mimetype,
            'x-upsert'      => 'true',
        ),
        'body'    => file_get_contents( $file['tmp_name'] ),
        'timeout' => 30,
    ));

    if ( is_wp_error( $upload ) || wp_remote_retrieve_response_code( $upload ) >= 300 ) {
        return new WP_Error( 'upload_fail', 'Storage upload failed.', array( 'status' => 500 ) );
    }

    $url = FW_SUPABASE_URL . '/storage/v1/object/public/trip-photos/' . $path;

    wp_remote_post( FW_SUPABASE_URL . '/rest/v1/fw_album_photos', array(
        'headers'     => array(
            'apikey'        => FW_SUPABASE_SERVICE,
            'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE,
            'Content-Type'  => 'application/json',
            'Prefer'        => 'return=minimal',
        ),
        'body'        => wp_json_encode( array( 'album_id' => $booking_id, 'photo_url' => $url, 'sort_order' => count($existing) ) ),
        'timeout'     => 10,
        'data_format' => 'body',
    ));

    return rest_ensure_response( array( 'success' => true, 'url' => $url ) );
}


/* ═══════════════════════════════════════════════════════════
   PHASE 2B — Albums, Blogs, Testimonials + WebP Compression
═══════════════════════════════════════════════════════════ */

add_action( 'rest_api_init', function() {
    register_rest_route( 'freewheel/v1', '/fw-get-albums',        array( 'methods' => 'GET',  'callback' => 'fw_get_albums',         'permission_callback' => '__return_true' ));
    register_rest_route( 'freewheel/v1', '/fw-create-album',      array( 'methods' => 'POST', 'callback' => 'fw_create_album',        'permission_callback' => '__return_true' ));
    register_rest_route( 'freewheel/v1', '/fw-upload-album-photo',array( 'methods' => 'POST', 'callback' => 'fw_upload_album_photo',  'permission_callback' => '__return_true' ));
    register_rest_route( 'freewheel/v1', '/fw-get-blogs',         array( 'methods' => 'GET',  'callback' => 'fw_get_blogs',           'permission_callback' => '__return_true' ));
    register_rest_route( 'freewheel/v1', '/fw-save-blog',         array( 'methods' => 'POST', 'callback' => 'fw_save_blog',           'permission_callback' => '__return_true' ));
    register_rest_route( 'freewheel/v1', '/fw-upload-blog-cover', array( 'methods' => 'POST', 'callback' => 'fw_upload_blog_cover',   'permission_callback' => '__return_true' ));
    register_rest_route( 'freewheel/v1', '/fw-get-testimonials',  array( 'methods' => 'GET',  'callback' => 'fw_get_testimonials',    'permission_callback' => '__return_true' ));
    register_rest_route( 'freewheel/v1', '/fw-create-testimonial',array( 'methods' => 'POST', 'callback' => 'fw_create_testimonial',  'permission_callback' => '__return_true' ));
});

/* ── Helper: compress image to WebP, max 1920px, return temp path ── */
function fw_compress_to_webp( $tmp_path, $mime ) {
    if ( ! function_exists( 'imagecreatefromjpeg' ) ) return $tmp_path; // GD not available

    switch ( $mime ) {
        case 'image/jpeg': $src = imagecreatefromjpeg( $tmp_path ); break;
        case 'image/png':  $src = imagecreatefrompng( $tmp_path );  break;
        case 'image/webp': $src = imagecreatefromwebp( $tmp_path ); break;
        default: return $tmp_path;
    }
    if ( ! $src ) return $tmp_path;

    $orig_w = imagesx( $src );
    $orig_h = imagesy( $src );
    $max    = 1920;

    if ( $orig_w > $max || $orig_h > $max ) {
        $ratio = min( $max / $orig_w, $max / $orig_h );
        $new_w = (int) round( $orig_w * $ratio );
        $new_h = (int) round( $orig_h * $ratio );
        $dst   = imagecreatetruecolor( $new_w, $new_h );
        // Preserve transparency for PNG
        imagealphablending( $dst, false );
        imagesavealpha( $dst, true );
        imagecopyresampled( $dst, $src, 0, 0, 0, 0, $new_w, $new_h, $orig_w, $orig_h );
        imagedestroy( $src );
        $src = $dst;
    }

    $out = $tmp_path . '_compressed.webp';
    imagewebp( $src, $out, 82 ); // quality 82 — good balance size/quality
    imagedestroy( $src );
    return $out;
}

/* ── Helper: upload image file to Supabase storage with WebP compression ── */
function fw_upload_image( $file, $storage_path ) {
    $allowed  = array( 'image/jpeg', 'image/png', 'image/webp' );
    $finfo    = finfo_open( FILEINFO_MIME_TYPE );
    $mimetype = finfo_file( $finfo, $file['tmp_name'] );
    finfo_close( $finfo );

    if ( ! in_array( $mimetype, $allowed ) ) {
        return new WP_Error( 'invalid_type', 'Only JPG, PNG and WEBP allowed.', array( 'status' => 400 ) );
    }
    if ( $file['size'] > 15 * 1024 * 1024 ) {
        return new WP_Error( 'too_large', 'Max 15MB per image.', array( 'status' => 400 ) );
    }

    // Compress to WebP
    $compressed = fw_compress_to_webp( $file['tmp_name'], $mimetype );
    $final_path = $storage_path . '.webp';
    $final_mime = 'image/webp';

    $upload = wp_remote_request( FW_SUPABASE_URL . '/storage/v1/object/avatars/' . $final_path, array(
        'method'  => 'POST',
        'headers' => array(
            'apikey'        => FW_SUPABASE_SERVICE,
            'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE,
            'Content-Type'  => $final_mime,
            'x-upsert'      => 'true',
        ),
        'body'    => file_get_contents( $compressed ),
        'timeout' => 30,
    ));

    // Clean up compressed temp file
    if ( $compressed !== $file['tmp_name'] && file_exists( $compressed ) ) {
        @unlink( $compressed );
    }

    if ( is_wp_error( $upload ) || wp_remote_retrieve_response_code( $upload ) >= 300 ) {
        return new WP_Error( 'upload_fail', 'Storage upload failed.', array( 'status' => 500 ) );
    }

    return FW_SUPABASE_URL . '/storage/v1/object/public/avatars/' . $final_path;
}

/* ── fw_get_albums ── */
function fw_get_albums( $request ) {
    $user = fw_validate_token( $request );
    if ( is_wp_error( $user ) ) return $user;

    $resp = wp_remote_get(
        FW_SUPABASE_URL . '/rest/v1/fw_albums?user_id=eq.' . rawurlencode( $user['id'] ) . '&order=created_at.desc',
        array( 'headers' => array( 'apikey' => FW_SUPABASE_SERVICE, 'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE ), 'timeout' => 10 )
    );
    $albums = json_decode( wp_remote_retrieve_body( $resp ), true ) ?: array();

    /* Include photos so user can see them regardless of approval status */
    foreach ( $albums as &$album ) {
        $photos = json_decode( wp_remote_retrieve_body( wp_remote_get(
            FW_SUPABASE_URL . '/rest/v1/fw_album_photos?album_id=eq.' . rawurlencode( $album['id'] ) . '&order=sort_order.asc&select=photo_url,caption',
            array( 'headers' => array( 'apikey' => FW_SUPABASE_SERVICE, 'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE ), 'timeout' => 8 )
        )), true ) ?: array();
        $album['photos'] = $photos;
    }
    unset( $album );

    return rest_ensure_response( array( 'success' => true, 'albums' => $albums ) );
}

/* ── fw_create_album ── */
function fw_create_album( $request ) {
    $user = fw_validate_token( $request );
    if ( is_wp_error( $user ) ) return $user;

    $p     = $request->get_json_params() ?: array();
    $title = sanitize_text_field( $p['title'] ?? '' );
    $trip  = sanitize_text_field( $p['trip_name'] ?? '' );

    if ( ! $title ) return new WP_Error( 'missing', 'Title required.', array( 'status' => 400 ) );

    $resp = wp_remote_post( FW_SUPABASE_URL . '/rest/v1/fw_albums', array(
        'headers'     => array( 'apikey' => FW_SUPABASE_SERVICE, 'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE, 'Content-Type' => 'application/json', 'Prefer' => 'return=representation' ),
        'body'        => wp_json_encode( array(
            'user_id'   => $user['id'],
            'title'     => $title,
            'trip_name' => $trip,
            'is_public' => ! empty( $p['is_public'] ) && $p['is_public'] === true,
        ) ),
        'timeout'     => 10, 'data_format' => 'body',
    ));

    $data = json_decode( wp_remote_retrieve_body( $resp ), true );
    if ( wp_remote_retrieve_response_code( $resp ) >= 300 ) {
        return new WP_Error( 'db_fail', 'Failed to create album.', array( 'status' => 500 ) );
    }
    return rest_ensure_response( array( 'success' => true, 'album' => $data[0] ?? array() ) );
}

/* ── fw_upload_album_photo ── */
function fw_upload_album_photo( $request ) {
    $user = fw_validate_token( $request );
    if ( is_wp_error( $user ) ) return $user;

    if ( empty( $_FILES['photo'] ) || $_FILES['photo']['error'] !== UPLOAD_ERR_OK ) {
        return new WP_Error( 'no_file', 'No file uploaded.', array( 'status' => 400 ) );
    }

    $album_id = sanitize_text_field( $_POST['album_id'] ?? '' );
    if ( ! $album_id ) return new WP_Error( 'missing', 'Album ID required.', array( 'status' => 400 ) );

    // Verify album belongs to user
    $chk = wp_remote_get( FW_SUPABASE_URL . '/rest/v1/fw_albums?id=eq.' . rawurlencode( $album_id ) . '&user_id=eq.' . rawurlencode( $user['id'] ) . '&select=id',
        array( 'headers' => array( 'apikey' => FW_SUPABASE_SERVICE, 'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE ), 'timeout' => 10 ) );
    $album = json_decode( wp_remote_retrieve_body( $chk ), true );
    if ( empty( $album[0] ) ) return new WP_Error( 'forbidden', 'Album not found.', array( 'status' => 403 ) );

    // Check photo count
    $photos_chk = wp_remote_get( FW_SUPABASE_URL . '/rest/v1/fw_album_photos?album_id=eq.' . rawurlencode( $album_id ) . '&select=id',
        array( 'headers' => array( 'apikey' => FW_SUPABASE_SERVICE, 'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE ), 'timeout' => 10 ) );
    $existing = json_decode( wp_remote_retrieve_body( $photos_chk ), true ) ?: array();
    if ( count( $existing ) >= 6 ) return new WP_Error( 'max_photos', 'Max 6 photos per album.', array( 'status' => 400 ) );

    $path   = 'albums/' . $user['id'] . '/' . $album_id . '/' . time() . '_' . mt_rand(100,999);
    $url    = fw_upload_image( $_FILES['photo'], $path );
    if ( is_wp_error( $url ) ) return $url;

    $caption = sanitize_text_field( $_POST['caption'] ?? '' );
    wp_remote_post( FW_SUPABASE_URL . '/rest/v1/fw_album_photos', array(
        'headers'     => array( 'apikey' => FW_SUPABASE_SERVICE, 'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE, 'Content-Type' => 'application/json', 'Prefer' => 'return=minimal' ),
        'body'        => wp_json_encode( array( 'album_id' => $album_id, 'photo_url' => $url, 'sort_order' => count( $existing ), 'caption' => $caption ) ),
        'timeout'     => 10, 'data_format' => 'body',
    ));

    return rest_ensure_response( array( 'success' => true, 'url' => $url ) );
}

/* ── fw_get_blogs ── */
function fw_get_blogs( $request ) {
    $user = fw_validate_token( $request );
    if ( is_wp_error( $user ) ) return $user;

    $resp = wp_remote_get(
        FW_SUPABASE_URL . '/rest/v1/fw_blogs?user_id=eq.' . rawurlencode( $user['id'] ) . '&order=created_at.desc&select=id,title,status,rejection_note,created_at',
        array( 'headers' => array( 'apikey' => FW_SUPABASE_SERVICE, 'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE ), 'timeout' => 10 )
    );
    $blogs = json_decode( wp_remote_retrieve_body( $resp ), true ) ?: array();
    return rest_ensure_response( array( 'success' => true, 'blogs' => $blogs ) );
}

/* ── fw_save_blog ── */
function fw_save_blog( $request ) {
    $user = fw_validate_token( $request );
    if ( is_wp_error( $user ) ) return $user;

    $p      = $request->get_json_params() ?: array();
    $id     = sanitize_text_field( $p['id'] ?? '' );
    $title  = sanitize_text_field( $p['title'] ?? '' );
    $body   = wp_kses_post( $p['body'] ?? '' );
    $cover  = esc_url_raw( $p['cover_image'] ?? '' );
    $status = in_array( $p['status'] ?? '', array( 'draft', 'pending' ) ) ? $p['status'] : 'draft';

    if ( ! $title || ! $body ) return new WP_Error( 'missing', 'Title and body required.', array( 'status' => 400 ) );

    $payload = array( 'title' => $title, 'body' => $body, 'cover_image' => $cover, 'status' => $status, 'updated_at' => date('c') );

    if ( $id ) {
        // Update — verify ownership first
        $chk = wp_remote_get( FW_SUPABASE_URL . '/rest/v1/fw_blogs?id=eq.' . rawurlencode($id) . '&user_id=eq.' . rawurlencode($user['id']) . '&select=id,status',
            array( 'headers' => array( 'apikey' => FW_SUPABASE_SERVICE, 'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE ), 'timeout' => 10 ) );
        $existing = json_decode( wp_remote_retrieve_body( $chk ), true );
        if ( empty( $existing[0] ) ) return new WP_Error( 'forbidden', 'Blog not found.', array( 'status' => 403 ) );

        wp_remote_request( FW_SUPABASE_URL . '/rest/v1/fw_blogs?id=eq.' . rawurlencode($id), array(
            'method' => 'PATCH', 'headers' => array( 'apikey' => FW_SUPABASE_SERVICE, 'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE, 'Content-Type' => 'application/json', 'Prefer' => 'return=minimal' ),
            'body' => wp_json_encode( $payload ), 'timeout' => 10,
        ));
    } else {
        $payload['user_id'] = $user['id'];
        wp_remote_post( FW_SUPABASE_URL . '/rest/v1/fw_blogs', array(
            'headers' => array( 'apikey' => FW_SUPABASE_SERVICE, 'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE, 'Content-Type' => 'application/json', 'Prefer' => 'return=minimal' ),
            'body' => wp_json_encode( $payload ), 'timeout' => 10, 'data_format' => 'body',
        ));
    }

    return rest_ensure_response( array( 'success' => true ) );
}

/* ── fw_upload_blog_cover ── */
function fw_upload_blog_cover( $request ) {
    $user = fw_validate_token( $request );
    if ( is_wp_error( $user ) ) return $user;

    if ( empty( $_FILES['photo'] ) || $_FILES['photo']['error'] !== UPLOAD_ERR_OK ) {
        return new WP_Error( 'no_file', 'No file uploaded.', array( 'status' => 400 ) );
    }

    $path = 'blog-covers/' . $user['id'] . '/' . time() . '_' . mt_rand(100,999);
    $url  = fw_upload_image( $_FILES['photo'], $path );
    if ( is_wp_error( $url ) ) return $url;

    return rest_ensure_response( array( 'success' => true, 'url' => $url ) );
}

/* ── fw_get_testimonials ── */
function fw_get_testimonials( $request ) {
    $user = fw_validate_token( $request );
    if ( is_wp_error( $user ) ) return $user;

    $resp = wp_remote_get(
        FW_SUPABASE_URL . '/rest/v1/fw_testimonials?user_id=eq.' . rawurlencode( $user['id'] ) . '&order=created_at.desc',
        array( 'headers' => array( 'apikey' => FW_SUPABASE_SERVICE, 'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE ), 'timeout' => 10 )
    );
    $testis = json_decode( wp_remote_retrieve_body( $resp ), true ) ?: array();
    return rest_ensure_response( array( 'success' => true, 'testimonials' => $testis ) );
}

/* ── fw_create_testimonial ── */
function fw_create_testimonial( $request ) {
    $user = fw_validate_token( $request );
    if ( is_wp_error( $user ) ) return $user;

    $p      = $request->get_json_params() ?: array();
    $body   = sanitize_textarea_field( $p['body'] ?? '' );
    $trip   = sanitize_text_field( $p['trip_name'] ?? '' );
    $rating = max( 1, min( 5, intval( $p['rating'] ?? 5 ) ) );

    if ( ! $body ) return new WP_Error( 'missing', 'Testimonial body required.', array( 'status' => 400 ) );

    $resp = wp_remote_post( FW_SUPABASE_URL . '/rest/v1/fw_testimonials', array(
        'headers'     => array( 'apikey' => FW_SUPABASE_SERVICE, 'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE, 'Content-Type' => 'application/json', 'Prefer' => 'return=minimal' ),
        'body'        => wp_json_encode( array( 'user_id' => $user['id'], 'body' => $body, 'trip_name' => $trip, 'rating' => $rating ) ),
        'timeout'     => 10, 'data_format' => 'body',
    ));

    if ( wp_remote_retrieve_response_code( $resp ) >= 300 ) {
        return new WP_Error( 'db_fail', 'Failed to save testimonial.', array( 'status' => 500 ) );
    }

    return rest_ensure_response( array( 'success' => true ) );
}


add_action( 'rest_api_init', function() {
    register_rest_route( 'freewheel/v1', '/fw-get-blog-content', array( 'methods' => 'GET', 'callback' => 'fw_get_blog_content', 'permission_callback' => '__return_true' ));
});

function fw_get_blog_content( $request ) {
    $user = fw_validate_token( $request );
    if ( is_wp_error( $user ) ) return $user;

    $id = sanitize_text_field( $request->get_param('id') );
    if ( ! $id ) return new WP_Error( 'missing', 'ID required.', array( 'status' => 400 ) );

    $resp = wp_remote_get(
        FW_SUPABASE_URL . '/rest/v1/fw_blogs?id=eq.' . rawurlencode($id) . '&user_id=eq.' . rawurlencode($user['id']) . '&select=id,title,body,cover_image,status',
        array( 'headers' => array( 'apikey' => FW_SUPABASE_SERVICE, 'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE ), 'timeout' => 10 )
    );
    $blogs = json_decode( wp_remote_retrieve_body( $resp ), true );
    if ( empty( $blogs[0] ) ) return new WP_Error( 'not_found', 'Blog not found.', array( 'status' => 404 ) );
    return rest_ensure_response( array( 'success' => true, 'blog' => $blogs[0] ) );
}


/* ═══════════════════════════════════════════════════════════════
   PHASE 3 — ADMIN DASHBOARD ENDPOINTS
   All require WordPress admin OR fw_members role='admin'
═══════════════════════════════════════════════════════════════ */

add_action( 'rest_api_init', function() {
    register_rest_route( 'freewheel/v1', '/admin/check',           array( 'methods'=>'GET',  'callback'=>'fw_admin_check',           'permission_callback'=>'__return_true' ));
    register_rest_route( 'freewheel/v1', '/admin/pending-content', array( 'methods'=>'GET',  'callback'=>'fw_admin_pending_content',  'permission_callback'=>'__return_true' ));
    register_rest_route( 'freewheel/v1', '/admin/approve-content', array( 'methods'=>'POST', 'callback'=>'fw_admin_approve_content',  'permission_callback'=>'__return_true' ));
    register_rest_route( 'freewheel/v1', '/admin/users',           array( 'methods'=>'GET',  'callback'=>'fw_admin_users',           'permission_callback'=>'__return_true' ));
    register_rest_route( 'freewheel/v1', '/admin/bookings',        array( 'methods'=>'GET',  'callback'=>'fw_admin_bookings',        'permission_callback'=>'__return_true' ));
    register_rest_route( 'freewheel/v1', '/admin/save-booking',    array( 'methods'=>'POST', 'callback'=>'fw_admin_save_booking',    'permission_callback'=>'__return_true' ));
    register_rest_route( 'freewheel/v1', '/admin/orders',          array( 'methods'=>'GET',  'callback'=>'fw_admin_orders',          'permission_callback'=>'__return_true' ));
    register_rest_route( 'freewheel/v1', '/admin/update-order',    array( 'methods'=>'POST', 'callback'=>'fw_admin_update_order',    'permission_callback'=>'__return_true' ));
    register_rest_route( 'freewheel/v1', '/admin/adjust-credits',  array( 'methods'=>'POST', 'callback'=>'fw_admin_adjust_credits',  'permission_callback'=>'__return_true' ));
    register_rest_route( 'freewheel/v1', '/admin/link-booking',    array( 'methods'=>'POST', 'callback'=>'fw_admin_link_booking',    'permission_callback'=>'__return_true' ));
    register_rest_route( 'freewheel/v1', '/admin/members',         array( 'methods'=>'GET',  'callback'=>'fw_admin_get_members',      'permission_callback'=>'__return_true' ));
    register_rest_route( 'freewheel/v1', '/admin/update-member',   array( 'methods'=>'POST', 'callback'=>'fw_admin_update_member',    'permission_callback'=>'__return_true' ));
    register_rest_route( 'freewheel/v1', '/admin/site-stats',      array( 'methods'=>'GET',  'callback'=>'fw_admin_site_stats',       'permission_callback'=>'__return_true' ));
});

/* ── Admin auth: WP admin OR fw_members role=admin ── */
function fw_is_admin( $request ) {
    // Check WordPress session
    if ( is_user_logged_in() && current_user_can( 'manage_options' ) ) return true;

    // Check Supabase JWT
    $auth = $request->get_header( 'authorization' );
    if ( ! $auth || strpos( $auth, 'Bearer ' ) !== 0 ) return false;
    $token = substr( $auth, 7 );

    // Verify token with Supabase Auth
    $resp = wp_remote_get( FW_SUPABASE_URL . '/auth/v1/user', array(
        'headers' => array(
            'apikey'        => FW_SUPABASE_ANON,
            'Authorization' => 'Bearer ' . $token,
        ),
        'timeout' => 10,
    ));
    if ( is_wp_error( $resp ) ) return false;

    $code = wp_remote_retrieve_response_code( $resp );
    if ( $code !== 200 ) return false;

    $user = json_decode( wp_remote_retrieve_body( $resp ), true );
    if ( empty( $user['id'] ) ) return false;

    // Check fw_members role using service role (bypasses RLS)
    $member_resp = wp_remote_get(
        FW_SUPABASE_URL . '/rest/v1/fw_members?id=eq.' . rawurlencode( $user['id'] ) . '&select=role',
        array(
            'headers' => array(
                'apikey'        => FW_SUPABASE_SERVICE,
                'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE,
                'Accept'        => 'application/json',
            ),
            'timeout' => 10,
        )
    );
    if ( is_wp_error( $member_resp ) ) return false;

    $rows = json_decode( wp_remote_retrieve_body( $member_resp ), true );
    if ( ! is_array( $rows ) || empty( $rows[0]['role'] ) ) return false;

    return in_array($rows[0]['role'], array('admin', 'super_admin', 'moderator'));
}

function fw_admin_deny() {
    return new WP_Error( 'forbidden', 'Admin access required.', array( 'status' => 403 ) );
}

/* ── Helper: log status change ── */
function fw_log_status( $type, $record_id, $from, $to, $note = '' ) {
    wp_remote_post( FW_SUPABASE_URL . '/rest/v1/fw_status_history', array(
        'headers'     => array( 'apikey' => FW_SUPABASE_SERVICE, 'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE, 'Content-Type' => 'application/json', 'Prefer' => 'return=minimal' ),
        'body'        => wp_json_encode( array( 'record_type' => $type, 'record_id' => $record_id, 'from_status' => $from, 'to_status' => $to, 'changed_by' => 'admin', 'note' => $note ) ),
        'timeout'     => 8, 'data_format' => 'body',
    ));
}

/* ── fw_admin_check ── */
function fw_admin_check( $request ) {
    if ( is_user_logged_in() && current_user_can( 'manage_options' ) ) {
        return rest_ensure_response( array( 'success' => true, 'is_admin' => true, 'method' => 'wp' ) );
    }
    $auth = $request->get_header( 'authorization' );
    if ( ! $auth || strpos( $auth, 'Bearer ' ) !== 0 ) {
        return rest_ensure_response( array( 'success' => false, 'is_admin' => false, 'reason' => 'no_token' ) );
    }
    $token = substr( $auth, 7 );
    $resp = wp_remote_get( FW_SUPABASE_URL . '/auth/v1/user', array(
        'headers' => array( 'apikey' => FW_SUPABASE_ANON, 'Authorization' => 'Bearer ' . $token ),
        'timeout' => 10,
    ));
    if ( is_wp_error( $resp ) ) {
        return rest_ensure_response( array( 'success' => false, 'is_admin' => false, 'reason' => 'supabase_error' ) );
    }
    $code = wp_remote_retrieve_response_code( $resp );
    $user = json_decode( wp_remote_retrieve_body( $resp ), true );
    if ( $code !== 200 || empty( $user['id'] ) ) {
        return rest_ensure_response( array( 'success' => false, 'is_admin' => false, 'reason' => 'invalid_token', 'code' => $code ) );
    }
    $mresp = wp_remote_get(
        FW_SUPABASE_URL . '/rest/v1/fw_members?id=eq.' . rawurlencode( $user['id'] ) . '&select=role',
        array( 'headers' => array( 'apikey' => FW_SUPABASE_SERVICE, 'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE, 'Accept' => 'application/json' ), 'timeout' => 10 )
    );
    $rows = json_decode( wp_remote_retrieve_body( $mresp ), true );
    if ( empty( $rows[0]['role'] ) ) {
        return rest_ensure_response( array( 'success' => false, 'is_admin' => false, 'reason' => 'no_member', 'uid' => $user['id'] ) );
    }
    $admin_roles = array( 'admin', 'super_admin', 'moderator' );
    if ( ! in_array( $rows[0]['role'], $admin_roles ) ) {
        return rest_ensure_response( array( 'success' => false, 'is_admin' => false, 'reason' => 'role_is_'.$rows[0]['role'] ) );
    }
    return rest_ensure_response( array( 'success' => true, 'is_admin' => true, 'method' => 'supabase', 'role' => $rows[0]['role'] ) );
}

/* ── fw_admin_pending_content ── */
function fw_admin_pending_content( $request ) {
    if ( ! fw_is_admin( $request ) ) return fw_admin_deny();

    $h = array( 'apikey' => FW_SUPABASE_SERVICE, 'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE );

    $blogs = json_decode( wp_remote_retrieve_body( wp_remote_get(
        FW_SUPABASE_URL . '/rest/v1/fw_blogs?status=in.(pending,published,rejected)&order=created_at.desc&limit=50&select=id,title,status,created_at,user_id,cover_image,rejection_note',
        array( 'headers' => $h, 'timeout' => 10 )
    )), true ) ?: array();

    $testis = json_decode( wp_remote_retrieve_body( wp_remote_get(
        FW_SUPABASE_URL . '/rest/v1/fw_testimonials?status=in.(pending,approved,rejected)&order=created_at.desc&limit=50&select=id,body,trip_name,rating,status,created_at,user_id,rejection_note',
        array( 'headers' => $h, 'timeout' => 10 )
    )), true ) ?: array();

    $albums = json_decode( wp_remote_retrieve_body( wp_remote_get(
        FW_SUPABASE_URL . '/rest/v1/fw_albums?status=in.(pending,published,rejected)&order=created_at.desc&limit=50&select=id,title,trip_name,status,created_at,user_id,is_public',
        array( 'headers' => $h, 'timeout' => 10 )
    )), true ) ?: array();

    /* Fetch photos for each album */
    $h = array( 'apikey' => FW_SUPABASE_SERVICE, 'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE );
    foreach ( $albums as &$album ) {
        $photos = json_decode( wp_remote_retrieve_body( wp_remote_get(
            FW_SUPABASE_URL . '/rest/v1/fw_album_photos?album_id=eq.' . rawurlencode( $album['id'] ) . '&order=sort_order.asc&select=photo_url,caption',
            array( 'headers' => $h, 'timeout' => 8 )
        )), true ) ?: array();
        $album['photos'] = $photos;
    }
    unset( $album );

    return rest_ensure_response( array( 'success'=>true, 'blogs'=>$blogs, 'testimonials'=>$testis, 'albums'=>$albums ) );
}

/* ── fw_admin_approve_content ── */
function fw_admin_approve_content( $request ) {
    if ( ! fw_is_admin( $request ) ) return fw_admin_deny();

    $p      = $request->get_json_params() ?: array();
    $type   = sanitize_text_field( $p['type']   ?? '' ); // blog|testimonial|album
    $id     = sanitize_text_field( $p['id']     ?? '' );
    $action = sanitize_text_field( $p['action'] ?? '' ); // approve|reject
    $note   = sanitize_text_field( $p['note']   ?? '' );

    if ( ! $type || ! $id || ! in_array( $action, array('approve','reject') ) ) {
        return new WP_Error( 'invalid', 'Missing parameters.', array( 'status' => 400 ) );
    }

    $table_map  = array( 'blog'=>'fw_blogs', 'testimonial'=>'fw_testimonials', 'album'=>'fw_albums' );
    $status_map = array( 'blog'=>array('approve'=>'published','reject'=>'rejected'),
                         'testimonial'=>array('approve'=>'approved','reject'=>'rejected'),
                         'album'=>array('approve'=>'published','reject'=>'rejected') );

    $table      = $table_map[ $type ] ?? null;
    $new_status = $status_map[ $type ][ $action ] ?? null;
    if ( ! $table || ! $new_status ) return new WP_Error( 'invalid', 'Invalid type.', array( 'status' => 400 ) );

    // Get current status + user_id
    $cur = json_decode( wp_remote_retrieve_body( wp_remote_get(
        FW_SUPABASE_URL . '/rest/v1/' . $table . '?id=eq.' . rawurlencode($id) . '&select=status,user_id,credits_awarded',
        array( 'headers' => array( 'apikey' => FW_SUPABASE_SERVICE, 'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE ), 'timeout' => 8 )
    )), true );
    $old_status = $cur[0]['status'] ?? '';
    $user_id    = $cur[0]['user_id'] ?? '';
    $credited   = $cur[0]['credits_awarded'] ?? false;

    // Update status
    $update = array( 'status' => $new_status );
    if ( $action === 'reject' && $note ) $update['rejection_note'] = $note;
    if ( $action === 'approve' )         $update['rejection_note'] = '';
    if ( $type === 'blog' && $action === 'approve' ) $update['published_at'] = date('c');

    $patch_resp = wp_remote_request(
        FW_SUPABASE_URL . '/rest/v1/' . $table . '?id=eq.' . rawurlencode($id),
        array( 'method'=>'PATCH', 'headers'=>array('apikey'=>FW_SUPABASE_SERVICE,'Authorization'=>'Bearer '.FW_SUPABASE_SERVICE,'Content-Type'=>'application/json','Prefer'=>'return=minimal'),
               'body'=>wp_json_encode($update), 'timeout'=>10 )
    );
    if ( is_wp_error( $patch_resp ) || wp_remote_retrieve_response_code( $patch_resp ) >= 300 ) {
        $err = is_wp_error($patch_resp) ? $patch_resp->get_error_message() : wp_remote_retrieve_body($patch_resp);
        return new WP_Error( 'update_fail', 'Status update failed: ' . $err, array( 'status' => 500 ) );
    }

    // Award credits on approval (only once)
    if ( $action === 'approve' && $user_id && ! $credited ) {
        $credit_map = array( 'blog'=>100, 'testimonial'=>75, 'album'=>50 );
        $amount = $credit_map[ $type ] ?? 0;
        if ( $amount ) {
            fw_give_credits( $user_id, $amount, $type . '_' . ( $type==='testimonial' ? 'approved' : 'published' ), $id, $type, 'Approved by admin' );
            wp_remote_request(
                FW_SUPABASE_URL . '/rest/v1/' . $table . '?id=eq.' . rawurlencode($id),
                array( 'method'=>'PATCH', 'headers'=>array('apikey'=>FW_SUPABASE_SERVICE,'Authorization'=>'Bearer '.FW_SUPABASE_SERVICE,'Content-Type'=>'application/json','Prefer'=>'return=minimal'),
                       'body'=>wp_json_encode(array('credits_awarded'=>true)), 'timeout'=>8 )
            );
        }
    }

    /* Status logged for audit - skipping fw_log_status as it's for bookings/orders only */

    return rest_ensure_response( array( 'success'=>true, 'new_status'=>$new_status ) );
}

/* ── fw_admin_users ── */
function fw_admin_users( $request ) {
    if ( ! fw_is_admin( $request ) ) return fw_admin_deny();
    $q = sanitize_text_field( $request->get_param('q') ?? '' );

    $filter = $q
        ? '?or=(email.ilike.*' . rawurlencode($q) . '*,first_name.ilike.*' . rawurlencode($q) . '*,phone.ilike.*' . rawurlencode($q) . '*)&limit=30'
        : '?order=created_at.desc&limit=50';

    $rows = json_decode( wp_remote_retrieve_body( wp_remote_get(
        FW_SUPABASE_URL . '/rest/v1/fw_members' . $filter . '&select=id,first_name,last_name,email,phone,city,state,role,trips_completed,created_at',
        array( 'headers' => array( 'apikey' => FW_SUPABASE_SERVICE, 'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE ), 'timeout' => 10 )
    )), true ) ?: array();

    return rest_ensure_response( array( 'success'=>true, 'users'=>$rows ) );
}

/* ── fw_admin_bookings ── */
function fw_admin_bookings( $request ) {
    if ( ! fw_is_admin( $request ) ) return fw_admin_deny();
    $status = sanitize_text_field( $request->get_param('status') ?? '' );
    $filter = $status ? '?status=eq.' . rawurlencode($status) . '&order=created_at.desc&limit=60'
                      : '?order=created_at.desc&limit=60';

    $rows = json_decode( wp_remote_retrieve_body( wp_remote_get(
        FW_SUPABASE_URL . '/rest/v1/fw_bookings' . $filter,
        array( 'headers' => array( 'apikey' => FW_SUPABASE_SERVICE, 'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE ), 'timeout' => 10 )
    )), true ) ?: array();

    return rest_ensure_response( array( 'success'=>true, 'bookings'=>$rows ) );
}

/* ── fw_admin_save_booking ── */
function fw_admin_save_booking( $request ) {
    if ( ! fw_is_admin( $request ) ) return fw_admin_deny();
    $p = $request->get_json_params() ?: array();

    $allowed = array( 'trip_id','trip_title','trip_dates','status','amount_total','amount_paid',
                      'payment_mode','payment_ref','seats','whatsapp_ref','discount_pct',
                      'notes','contact_name','contact_email','contact_phone','user_id' );
    $data = array( 'updated_at' => date('c') );
    foreach ( $allowed as $k ) {
        if ( isset($p[$k]) ) $data[$k] = is_string($p[$k]) ? sanitize_text_field($p[$k]) : $p[$k];
    }

    $id = sanitize_text_field( $p['id'] ?? '' );

    if ( $id ) {
        // Get old status for log
        $cur = json_decode( wp_remote_retrieve_body( wp_remote_get(
            FW_SUPABASE_URL . '/rest/v1/fw_bookings?id=eq.' . rawurlencode($id) . '&select=status',
            array( 'headers' => array( 'apikey' => FW_SUPABASE_SERVICE, 'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE ), 'timeout' => 8 )
        )), true );
        $old = $cur[0]['status'] ?? '';

        wp_remote_request( FW_SUPABASE_URL . '/rest/v1/fw_bookings?id=eq.' . rawurlencode($id),
            array( 'method'=>'PATCH', 'headers'=>array('apikey'=>FW_SUPABASE_SERVICE,'Authorization'=>'Bearer '.FW_SUPABASE_SERVICE,'Content-Type'=>'application/json','Prefer'=>'return=minimal'),
                   'body'=>wp_json_encode($data), 'timeout'=>10 ) );

        if ( ! empty($p['status']) && $p['status'] !== $old ) {
            fw_log_status( 'booking', $id, $old, $p['status'], $p['notes'] ?? '' );

            // Award 500 credits when marked completed
            if ( $p['status'] === 'completed' && ! empty($p['user_id']) ) {
                $chk = json_decode( wp_remote_retrieve_body( wp_remote_get(
                    FW_SUPABASE_URL . '/rest/v1/fw_bookings?id=eq.' . rawurlencode($id) . '&select=credits_awarded,user_id',
                    array( 'headers' => array( 'apikey' => FW_SUPABASE_SERVICE, 'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE ), 'timeout' => 8 )
                )), true );
                if ( empty($chk[0]['credits_awarded']) ) {
                    fw_give_credits( $p['user_id'], 500, 'trip_completed', $id, 'booking', 'Trip completed' );
                    // Increment trips_completed
                    $m = json_decode( wp_remote_retrieve_body( wp_remote_get(
                        FW_SUPABASE_URL . '/rest/v1/fw_members?id=eq.' . rawurlencode($p['user_id']) . '&select=trips_completed',
                        array( 'headers' => array( 'apikey' => FW_SUPABASE_SERVICE, 'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE ), 'timeout' => 8 )
                    )), true );
                    $tc = ( $m[0]['trips_completed'] ?? 0 ) + 1;
                    wp_remote_request( FW_SUPABASE_URL . '/rest/v1/fw_members?id=eq.' . rawurlencode($p['user_id']),
                        array( 'method'=>'PATCH', 'headers'=>array('apikey'=>FW_SUPABASE_SERVICE,'Authorization'=>'Bearer '.FW_SUPABASE_SERVICE,'Content-Type'=>'application/json','Prefer'=>'return=minimal'),
                               'body'=>wp_json_encode(array('trips_completed'=>$tc,'updated_at'=>date('c'))), 'timeout'=>8 ) );
                    wp_remote_request( FW_SUPABASE_URL . '/rest/v1/fw_bookings?id=eq.' . rawurlencode($id),
                        array( 'method'=>'PATCH', 'headers'=>array('apikey'=>FW_SUPABASE_SERVICE,'Authorization'=>'Bearer '.FW_SUPABASE_SERVICE,'Content-Type'=>'application/json','Prefer'=>'return=minimal'),
                               'body'=>wp_json_encode(array('credits_awarded'=>true)), 'timeout'=>8 ) );
                }
            }
        }
    } else {
        // Create new booking
        $resp = wp_remote_post( FW_SUPABASE_URL . '/rest/v1/fw_bookings',
            array( 'headers'=>array('apikey'=>FW_SUPABASE_SERVICE,'Authorization'=>'Bearer '.FW_SUPABASE_SERVICE,'Content-Type'=>'application/json','Prefer'=>'return=representation'),
                   'body'=>wp_json_encode($data), 'timeout'=>10, 'data_format'=>'body' ) );
        $new = json_decode( wp_remote_retrieve_body($resp), true );
        $id  = $new[0]['id'] ?? '';
    }

    return rest_ensure_response( array( 'success'=>true, 'id'=>$id ) );
}

/* ── fw_admin_orders ── */
function fw_admin_orders( $request ) {
    if ( ! fw_is_admin( $request ) ) return fw_admin_deny();
    $rows = json_decode( wp_remote_retrieve_body( wp_remote_get(
        FW_SUPABASE_URL . '/rest/v1/fw_orders?order=created_at.desc&limit=60',
        array( 'headers' => array( 'apikey' => FW_SUPABASE_SERVICE, 'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE ), 'timeout' => 10 )
    )), true ) ?: array();
    return rest_ensure_response( array( 'success'=>true, 'orders'=>$rows ) );
}

/* ── fw_admin_update_order ── */
function fw_admin_update_order( $request ) {
    if ( ! fw_is_admin( $request ) ) return fw_admin_deny();
    $p  = $request->get_json_params() ?: array();
    $id = sanitize_text_field( $p['id'] ?? '' );
    if ( ! $id ) return new WP_Error( 'missing', 'Order ID required.', array( 'status'=>400 ) );

    $allowed = array('status','tracking_number','dispatch_date','payment_ref','payment_mode','notes');
    $data = array( 'updated_at' => date('c') );
    foreach ( $allowed as $k ) { if ( isset($p[$k]) ) $data[$k] = sanitize_text_field($p[$k]); }

    $cur = json_decode( wp_remote_retrieve_body( wp_remote_get(
        FW_SUPABASE_URL . '/rest/v1/fw_orders?id=eq.' . rawurlencode($id) . '&select=status',
        array( 'headers' => array( 'apikey' => FW_SUPABASE_SERVICE, 'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE ), 'timeout' => 8 )
    )), true );
    $old = $cur[0]['status'] ?? '';

    wp_remote_request( FW_SUPABASE_URL . '/rest/v1/fw_orders?id=eq.' . rawurlencode($id),
        array( 'method'=>'PATCH', 'headers'=>array('apikey'=>FW_SUPABASE_SERVICE,'Authorization'=>'Bearer '.FW_SUPABASE_SERVICE,'Content-Type'=>'application/json','Prefer'=>'return=minimal'),
               'body'=>wp_json_encode($data), 'timeout'=>10 ) );

    if ( ! empty($p['status']) && $p['status'] !== $old )
        fw_log_status( 'order', $id, $old, $p['status'], $p['notes'] ?? '' );

    return rest_ensure_response( array( 'success'=>true ) );
}

/* ── fw_admin_adjust_credits ── */
function fw_admin_adjust_credits( $request ) {
    if ( ! fw_is_admin( $request ) ) return fw_admin_deny();
    $p       = $request->get_json_params() ?: array();
    $user_id = sanitize_text_field( $p['user_id'] ?? '' );
    $amount  = intval( $p['amount'] ?? 0 );
    $note    = sanitize_text_field( $p['note'] ?? 'Admin adjustment' );

    if ( ! $user_id || $amount === 0 ) return new WP_Error( 'missing', 'user_id and amount required.', array( 'status'=>400 ) );

    fw_give_credits( $user_id, $amount, 'admin_adjustment', '', '', $note );
    return rest_ensure_response( array( 'success'=>true, 'new_balance'=>fw_credit_balance($user_id) ) );
}

/* ── fw_admin_link_booking ── */
function fw_admin_link_booking( $request ) {
    if ( ! fw_is_admin( $request ) ) return fw_admin_deny();
    $p          = $request->get_json_params() ?: array();
    $booking_id = sanitize_text_field( $p['booking_id'] ?? '' );
    $user_id    = sanitize_text_field( $p['user_id']    ?? '' );

    if ( ! $booking_id || ! $user_id ) return new WP_Error( 'missing', 'booking_id and user_id required.', array( 'status'=>400 ) );

    wp_remote_request( FW_SUPABASE_URL . '/rest/v1/fw_bookings?id=eq.' . rawurlencode($booking_id),
        array( 'method'=>'PATCH', 'headers'=>array('apikey'=>FW_SUPABASE_SERVICE,'Authorization'=>'Bearer '.FW_SUPABASE_SERVICE,'Content-Type'=>'application/json','Prefer'=>'return=minimal'),
               'body'=>wp_json_encode(array('user_id'=>$user_id,'updated_at'=>date('c'))), 'timeout'=>10 ) );

    return rest_ensure_response( array( 'success'=>true ) );
}


/* ── Public Albums Carousel endpoint (no auth needed) ── */
add_action( 'rest_api_init', function() {
    register_rest_route( 'freewheel/v1', '/fw-public-albums', array(
        'methods'             => 'GET',
        'callback'            => 'fw_get_public_albums',
        'permission_callback' => '__return_true',
    ));
});

function fw_get_public_albums( $request ) {
    $limit = min( absint( $request->get_param('limit') ?? 5 ), 10 );

    /* Fetch latest public approved albums */
    $albums = json_decode( wp_remote_retrieve_body( wp_remote_get(
        FW_SUPABASE_URL . '/rest/v1/fw_albums?status=eq.published&is_public=eq.true&order=created_at.desc&limit=' . $limit . '&select=id,title,trip_name,user_id,created_at',
        array( 'headers' => array( 'apikey' => FW_SUPABASE_SERVICE, 'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE ), 'timeout' => 10 )
    )), true ) ?: array();

    if ( empty( $albums ) ) {
        return rest_ensure_response( array( 'success' => true, 'albums' => array() ) );
    }

    /* Fetch photos + member name for each album */
    foreach ( $albums as &$album ) {
        $photos = json_decode( wp_remote_retrieve_body( wp_remote_get(
            FW_SUPABASE_URL . '/rest/v1/fw_album_photos?album_id=eq.' . rawurlencode( $album['id'] ) . '&order=sort_order.asc&limit=6&select=photo_url,caption',
            array( 'headers' => array( 'apikey' => FW_SUPABASE_SERVICE, 'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE ), 'timeout' => 8 )
        )), true ) ?: array();
        $album['photos'] = $photos;

        /* Get member first name only (privacy) */
        $member = json_decode( wp_remote_retrieve_body( wp_remote_get(
            FW_SUPABASE_URL . '/rest/v1/fw_members?id=eq.' . rawurlencode( $album['user_id'] ) . '&select=first_name,city,instagram,profile_photo',
            array( 'headers' => array( 'apikey' => FW_SUPABASE_SERVICE, 'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE ), 'timeout' => 8 )
        )), true );
        $album['member_name']     = $member[0]['first_name'] ?? 'Explorer';
        $album['member_city']     = $member[0]['city'] ?? '';
        $album['member_instagram'] = $member[0]['instagram'] ?? '';
        $album['member_photo']     = $member[0]['profile_photo'] ?? '';
        unset( $album['user_id'] ); /* Don't expose user ID publicly */
    }

    return rest_ensure_response( array( 'success' => true, 'albums' => $albums ) );
}

/* ── Update fw_create_album to support is_public ── */
/* (Override existing function to add is_public field) */

/* ═══════════════════════════════════
   2. CUSTOM POST TYPES
═══════════════════════════════════ */
function freewheel_register_cpts() {

    register_post_type('fw_blog', array(
        'labels'        => array(
            'name'          => 'Blog Posts',
            'singular_name' => 'Blog Post',
            'add_new_item'  => 'Add New Blog Post',
            'edit_item'     => 'Edit Blog Post',
        ),
        'public'        => true,
        'show_ui'       => true,
        'show_in_menu'  => true,
        'menu_icon'     => 'dashicons-edit-page',
        'supports'      => array('title','thumbnail','comments'),
        'rewrite'       => array('slug'=>'blog'),
        'has_archive'   => true,
        'menu_position' => 5,
    ));

    register_post_type('fw_expedition', array(
        'labels' => array(
            'name'          => 'Expeditions',
            'singular_name' => 'Expedition',
            'add_new'       => 'Add New Expedition',
            'add_new_item'  => 'Add New Expedition',
            'edit_item'     => 'Edit Expedition',
            'menu_name'     => '🏔️ Expeditions',
        ),
        'public'        => true,
        'show_in_menu'  => true,
        'menu_icon'     => 'dashicons-location-alt',
        'menu_position' => 5,
        'supports'      => array('title', 'thumbnail'),
        'has_archive'   => false,
        'rewrite'       => array('slug' => 'expedition'),
        'show_in_rest'  => false,
    ));

    register_post_type('fw_album', array(
        'labels' => array(
            'name'          => 'Past Albums',
            'singular_name' => 'Album',
            'add_new'       => 'Add New Album',
            'edit_item'     => 'Edit Album',
            'menu_name'     => '📸 Past Albums',
        ),
        'public'        => true,
        'show_in_menu'  => true,
        'menu_icon'     => 'dashicons-format-gallery',
        'menu_position' => 6,
        'supports'      => array('title', 'thumbnail'),
        'has_archive'   => false,
        'rewrite'       => array('slug' => 'album'),
        'show_in_rest'  => false,
    ));

    register_post_type('fw_testimonial', array(
        'labels'        => array('name'=>'Testimonials','singular_name'=>'Testimonial','add_new_item'=>'Add New Testimonial','edit_item'=>'Edit Testimonial'),
        'public'        => false,
        'show_ui'       => true,
        'show_in_menu'  => true,
        'menu_icon'     => 'dashicons-format-quote',
        'supports'      => array('title','thumbnail'),
        'menu_position' => 6,
    ));
    register_post_type('fw_product', array(
        'labels' => array(
            'name'          => 'Merchandise',
            'singular_name' => 'Product',
            'add_new'       => 'Add New Product',
            'edit_item'     => 'Edit Product',
            'menu_name'     => '🛍️ Merchandise',
        ),
        'public'        => true,
        'show_in_menu'  => true,
        'menu_icon'     => 'dashicons-cart',
        'menu_position' => 7,
        'supports'      => array('title', 'thumbnail'),
        'has_archive'   => false,
        'rewrite'       => array('slug' => 'product'),
        'show_in_rest'  => false,
    ));
}
add_action('init', 'freewheel_register_cpts');

/* ═══════════════════════════════════
   3. ADMIN STYLES (shared)
═══════════════════════════════════ */
function fw_admin_styles() {
    echo '<style>
    .fw-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:12px}
    .fw-grid.g3{grid-template-columns:1fr 1fr 1fr}
    .fw-grid.g4{grid-template-columns:1fr 1fr 1fr 1fr}
    .fw-f label{display:block;font-weight:600;font-size:11px;text-transform:uppercase;letter-spacing:1px;color:#555;margin-bottom:4px}
    .fw-f input,.fw-f select,.fw-f textarea{width:100%;padding:8px 10px;border:1px solid #ddd;border-radius:4px;font-size:13px;background:#fafafa;box-sizing:border-box}
    .fw-f textarea{min-height:80px;resize:vertical}
    .fw-f{margin-bottom:10px}
    .fw-tip{font-size:11px;color:#999;margin-top:3px;font-style:italic}
    .fw-badge{display:inline-block;padding:3px 10px;border-radius:3px;font-size:11px;font-weight:700;color:#fff}
    </style>';
}
add_action('admin_head', 'fw_admin_styles');

/* ═══════════════════════════════════
   4. EXPEDITION META BOXES
═══════════════════════════════════ */
function freewheel_expedition_meta_boxes() {
    add_meta_box('fw_exp_main',      '📋 Basic Details',           'fw_exp_main_cb',      'fw_expedition', 'normal', 'high');
    add_meta_box('fw_exp_slots',     '🎟️ Slots & Pricing',         'fw_exp_slots_cb',     'fw_expedition', 'normal', 'high');
    add_meta_box('fw_exp_itinerary', '🗺️ Day-by-Day Itinerary',    'fw_exp_itin_cb',      'fw_expedition', 'normal', 'default');
    add_meta_box('fw_exp_details',   '✅ Inclusions & Exclusions', 'fw_exp_details_cb',   'fw_expedition', 'normal', 'default');
    add_meta_box('fw_exp_gallery',   '🖼️ Photo Gallery (carousel)','fw_exp_gallery_cb',   'fw_expedition', 'normal', 'default');
    add_meta_box('fw_exp_faq',       '❓ FAQs (expedition-specific)', 'fw_exp_faq_cb',   'fw_expedition', 'normal', 'default');
    add_meta_box('fw_exp_side',      '⚙️ Card Settings',           'fw_exp_side_cb',      'fw_expedition', 'side',   'default');
}
add_action('add_meta_boxes', 'freewheel_blog_meta_boxes');
function freewheel_blog_meta_boxes(){
    add_meta_box('fw_blog_main','✍️ Blog Details','fw_blog_meta_cb','fw_blog','normal','high');
}
function fw_blog_meta_cb($post){
    wp_nonce_field('fw_save_blog','fw_blog_nonce');
    $author   = get_post_meta($post->ID,'fw_blog_author',true);
    $subtitle = get_post_meta($post->ID,'fw_blog_subtitle',true);
    $content  = get_post_meta($post->ID,'fw_blog_content',true);
    $tags     = get_post_meta($post->ID,'fw_blog_tags',true);
    $seo_desc = get_post_meta($post->ID,'fw_blog_seo_desc',true);
    $read_time= get_post_meta($post->ID,'fw_blog_read_time',true);
    echo '<style>
    .fw-blog-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px;padding:8px 0}
    .fw-blog-grid label{font-weight:600;display:block;margin-bottom:4px;font-size:13px}
    .fw-blog-grid input,.fw-blog-grid textarea{width:100%;padding:8px;border:1px solid #ddd;border-radius:4px;font-size:13px;box-sizing:border-box}
    .fw-blog-grid textarea{resize:vertical}
    .fw-blog-full{grid-column:1/-1}
    .fw-blog-tip{font-size:11px;color:#888;margin-top:3px}
    </style>';
    echo '<div class="fw-blog-grid">';
    echo '<div><label>Author Name *</label><input type="text" name="fw_blog_author" value="'.esc_attr($author).'" placeholder="e.g. Rahul Sharma"></div>';
    echo '<div><label>Estimated Read Time</label><input type="text" name="fw_blog_read_time" value="'.esc_attr($read_time).'" placeholder="e.g. 5 min read"></div>';
    echo '<div class="fw-blog-full"><label>Subtitle / Tagline</label><input type="text" name="fw_blog_subtitle" value="'.esc_attr($subtitle).'" placeholder="A short hook line shown below the title"></div>';
    // ── Rich text editor (TinyMCE + Media Library) ──
    echo '<div class="fw-blog-full">';
    echo '<label style="font-weight:600;display:block;margin-bottom:6px;font-size:13px">Blog Content *</label>';
    wp_editor(
        $content,
        'fw_blog_content',
        array(
            'textarea_name' => 'fw_blog_content',
            'media_buttons' => true,          // "Add Media" button — inserts photos at cursor
            'textarea_rows' => 24,
            'editor_class'  => 'fw-blog-editor',
            'tinymce'       => array(
                'toolbar1'     => 'formatselect bold italic underline strikethrough | bullist numlist blockquote | link unlink | alignleft aligncenter | undo redo',
                'toolbar2'     => '',
                'block_formats'=> 'Paragraph=p;Heading 2=h2;Heading 3=h3;Blockquote=blockquote',
                'content_css'  => false,
            ),
            'quicktags'     => array(
                'buttons' => 'strong,em,ul,ol,li,link,img,close',
            ),
        )
    );
    echo '<div class="fw-blog-tip" style="margin-top:6px">Use <strong>Add Media</strong> above to insert photos directly at cursor position from your WordPress media library. Bold, italic, headings and bullet lists available in the toolbar.</div>';
    echo '</div>';
    echo '<div class="fw-blog-full"><label>Tags (comma separated)</label><input type="text" name="fw_blog_tags" value="'.esc_attr($tags).'" placeholder="e.g. Spiti, Winter Drive, Himalaya, Off-road"><div class="fw-blog-tip">Shown on card and post. Helps with SEO.</div></div>';
    echo '<div class="fw-blog-full"><label>SEO Meta Description (for Google)</label><textarea name="fw_blog_seo_desc" rows="2" placeholder="150-160 chars shown in Google search results. Describe what this post is about.">'.esc_textarea($seo_desc).'</textarea></div>';
    echo '</div>';
    echo '<p style="font-size:12px;color:#888;border-top:1px solid #eee;padding-top:10px;margin-top:4px"><strong>Post Title</strong> = Blog headline &nbsp;|&nbsp; <strong>Featured Image</strong> = Cover photo (1200×630px recommended) &nbsp;|&nbsp; <strong>Comments</strong> = enabled via Discussion box below</p>';
}

add_action('add_meta_boxes', 'freewheel_expedition_meta_boxes');
add_action('add_meta_boxes', function(){
    add_meta_box('fw_testi_main', 'Testimonial Details', 'fw_testi_meta_cb', 'fw_testimonial', 'normal', 'high');
});
function fw_testi_meta_cb($post){
    wp_nonce_field('fw_save_testi','fw_testi_nonce');
    $review = get_post_meta($post->ID,'fw_testi_review',true);
    $rating = get_post_meta($post->ID,'fw_testi_rating',true); if(!$rating) $rating='5';
    $trip   = get_post_meta($post->ID,'fw_testi_trip',true);
    $order  = get_post_meta($post->ID,'fw_testi_order',true); if(!$order) $order='0';
    echo '<style>.fw-tmb{display:grid;grid-template-columns:1fr 1fr;gap:16px;padding:8px 0}.fw-tmb label{font-weight:600;display:block;margin-bottom:4px;font-size:13px}.fw-tmb input,.fw-tmb select,.fw-tmb textarea{width:100%;padding:8px;border:1px solid #ddd;border-radius:4px;font-size:13px;box-sizing:border-box}.fw-tmb textarea{min-height:100px;resize:vertical}.fw-tmb-full{grid-column:1/-1}.fw-tmb-tip{font-size:11px;color:#999;margin-top:3px}</style>';
    echo '<div class="fw-tmb">';
    echo '<div class="fw-tmb-full"><label>Review / Testimonial *</label><textarea name="fw_testi_review" placeholder="What did this traveller say...">' . esc_textarea($review) . '</textarea></div>';
    echo '<div><label>Star Rating *</label><select name="fw_testi_rating">';
    foreach(array('5'=>'5 Stars','4'=>'4 Stars','3'=>'3 Stars') as $v=>$l){
        echo '<option value="'.esc_attr($v).'"'.selected($rating,$v,false).'>'.esc_html($l).'</option>';
    }
    echo '</select></div>';
    echo '<div><label>Trip Done *</label><input type="text" name="fw_testi_trip" value="'.esc_attr($trip).'" placeholder="e.g. Winter Spiti 2026"></div>';
    echo '<div><label>Display Order</label><input type="number" name="fw_testi_order" value="'.esc_attr($order).'" min="0"><div class="fw-tmb-tip">Lower = shown first</div></div>';
    echo '<div><label>Traveller Photo</label><div class="fw-tmb-tip">Set via Featured Image panel on the right</div></div>';
    echo '</div>';
    echo '<p style="font-size:12px;color:#888;border-top:1px solid #eee;padding-top:10px;margin-top:4px">Post Title = Traveller name &nbsp;|&nbsp; Featured Image = their photo (optional)</p>';
}

function fw_exp_main_cb($post) {
    wp_nonce_field('fw_save_exp','fw_exp_nonce');
    $m = function($k) use ($post){ return get_post_meta($post->ID,$k,true); };
    ?>
    <div class="fw-grid">
        <div class="fw-f">
            <label>Status</label>
            <select name="fw_status">
                <option value="upcoming" <?php selected($m('fw_status'),'upcoming'); ?>>⬆️ Upcoming</option>
                <option value="past"     <?php selected($m('fw_status'),'past');     ?>>✅ Past / Completed</option>
            </select>
        </div>
        <div class="fw-f">
            <label>Destination</label>
            <input type="text" name="fw_destination" value="<?php echo esc_attr($m('fw_destination')); ?>" placeholder="e.g. Nepal (Mustang)">
        </div>
    </div>
    <div class="fw-grid">
        <div class="fw-f">
            <label>Dates (display text)</label>
            <input type="text" name="fw_dates" value="<?php echo esc_attr($m('fw_dates')); ?>" placeholder="e.g. 23rd May – 30th May 2026">
        </div>
    </div>
    <div class="fw-grid g3">
        <div class="fw-f">
            <label>Duration</label>
            <input type="text" name="fw_duration" value="<?php echo esc_attr($m('fw_duration')); ?>" placeholder="8 Nights / 9 Days">
        </div>
        <div class="fw-f">
            <label>Region</label>
            <input type="text" name="fw_region" value="<?php echo esc_attr($m('fw_region')); ?>" placeholder="International / Himachal etc.">
        </div>
        <div class="fw-f">
            <label>Difficulty</label>
            <select name="fw_difficulty">
                <?php foreach(['Easy','Moderate','Challenging','Extreme'] as $d): ?>
                <option value="<?php echo $d; ?>" <?php selected($m('fw_difficulty'),$d); ?>><?php echo $d; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="fw-f">
        <label>Short Subtitle (e.g. 4x4 Only · Mustang Valley · Nepal)</label>
        <input type="text" name="fw_subtitle" value="<?php echo esc_attr($m('fw_subtitle')); ?>">
    </div>
    <div class="fw-f">
        <label>Overview / About This Trip</label>
        <textarea name="fw_overview"><?php echo esc_textarea($m('fw_overview')); ?></textarea>
        <p class="fw-tip">Write 2–3 paragraphs. Press Enter for line breaks.</p>
    </div>
    <div class="fw-f">
        <label>Highlights (one per line)</label>
        <textarea name="fw_highlights" style="min-height:70px"><?php echo esc_textarea($m('fw_highlights')); ?></textarea>
        <p class="fw-tip">e.g. Mustang Valley ↵ Lo Manthang ↵ Kagbeni</p>
    </div>
    <?php
}

function fw_exp_slots_cb($post) {
    $m = function($k) use ($post){ return get_post_meta($post->ID,$k,true); };
    $max    = (int)($m('fw_max_slots') ?: 20);
    $filled = (int)($m('fw_filled_slots') ?: 0);
    $left   = max(0, $max - $filled);
    $pct    = $max > 0 ? round($filled/$max*100) : 0;
    $color  = $left <= 3 ? '#e74c3c' : ($left <= 8 ? '#e8a020' : '#27ae60');
    ?>
    <div class="fw-grid g4">
        <div class="fw-f">
            <label>Self Drive Price (₹)</label>
            <input type="number" name="fw_price" value="<?php echo esc_attr($m('fw_price')); ?>" placeholder="29999">
        </div>
        <div class="fw-f">
            <label>Price Unit</label>
            <select name="fw_price_unit">
                <option value="per person" <?php selected($m('fw_price_unit'),'per person'); ?>>per person</option>
                <option value="per car"    <?php selected($m('fw_price_unit'),'per car');    ?>>per car</option>
                <option value="per couple" <?php selected($m('fw_price_unit'),'per couple'); ?>>per couple</option>
            </select>
        </div>
        <div class="fw-f">
            <label>Couple Discount Price (₹)</label>
            <input type="number" name="fw_couple_price" value="<?php echo esc_attr($m('fw_couple_price')); ?>" placeholder="24999">
        </div>
        <div class="fw-f">
            <label>Seat Sharing Price (₹)</label>
            <input type="number" name="fw_seat_price" value="<?php echo esc_attr($m('fw_seat_price')); ?>" placeholder="34999">
        </div>
        <div class="fw-f">
            <label>Total Slots</label>
            <input type="number" name="fw_max_slots" value="<?php echo esc_attr($max); ?>">
        </div>
        <div class="fw-f">
            <label>Slots Filled</label>
            <input type="number" name="fw_filled_slots" value="<?php echo esc_attr($filled); ?>">
        </div>
    </div>
    <div class="fw-f" style="margin-top:10px">
        <label>Cancellation Policy (one point per line)</label>
        <textarea name="fw_cancellation" rows="4" placeholder="50% charged if cancelled 10+ days before&#10;100% charged if cancelled within 10 days"><?php echo esc_textarea($m('fw_cancellation')); ?></textarea>
    </div>
    <div class="fw-f" style="margin-top:10px">
        <label>Things to Carry (one item per line)</label>
        <textarea name="fw_things_carry" rows="6" placeholder="All required Vehicle documents (RC, PUC, Insurance)&#10;Toilet Paper &amp; Wipes&#10;Eatables &amp; Water bottles"><?php echo esc_textarea($m('fw_things_carry')); ?></textarea>
    </div>
    <div class="fw-grid">
        <div class="fw-f">
            <label>Card Badge (e.g. Selling Fast / Limited Slots)</label>
            <input type="text" name="fw_badge" value="<?php echo esc_attr($m('fw_badge')); ?>" placeholder="Leave blank for none">
        </div>
        <div class="fw-f">
            <label>Booking WhatsApp Number (with country code)</label>
            <input type="text" name="fw_whatsapp" value="<?php echo esc_attr($m('fw_whatsapp') ?: '917817838060'); ?>">
        </div>
        <div class="fw-f">
            <label>UPI QR Code Image URL</label>
            <div style="display:flex;gap:8px;align-items:center">
                <input type="text" name="fw_qr_image" id="fw_qr_image" value="<?php echo esc_attr($m('fw_qr_image')); ?>" placeholder="Paste image URL or use button to upload" style="flex:1">
                <button type="button" style="padding:6px 12px;background:#555;color:#fff;border:none;cursor:pointer;font-size:12px;border-radius:2px" onclick="(function(){var f=wp.media({title:'Select QR Code Image',button:{text:'Use this image'},multiple:false});f.on('select',function(){var a=f.state().get('selection').first().toJSON();document.getElementById('fw_qr_image').value=a.url;document.getElementById('fw_qr_preview').src=a.url;document.getElementById('fw_qr_preview').style.display='block';});f.open();})()">Upload / Select</button>
            </div>
            <?php $qr=$m('fw_qr_image'); ?>
            <img id="fw_qr_preview" src="<?php echo esc_url($qr); ?>" style="margin-top:8px;max-width:120px;<?php echo $qr?'':'display:none'; ?>">
        </div>
    </div>

    <?php
}

function fw_exp_itin_cb($post) {
    $m    = function($k) use ($post){ return get_post_meta($post->ID,$k,true); };
    $days = $m('fw_itinerary') ? json_decode($m('fw_itinerary'), true) : array();
    if (empty($days)) $days = array(array('title'=>'','description'=>''));
    ?>
    <p style="color:#888;font-size:12px;margin-bottom:10px">Add one row per day. Example: "Day 1: Delhi to Shimla"</p>
    <input type="hidden" name="fw_itinerary_json" id="fw_itinerary_json" value="<?php echo esc_attr(json_encode($days)); ?>">
    <div id="fw-itin-rows">
    <?php foreach ($days as $i => $day): ?>
    <div class="fw-itin-row" style="display:grid;grid-template-columns:220px 1fr 34px;gap:10px;margin-bottom:8px;align-items:start">
        <input type="text" class="fw-day-title" value="<?php echo esc_attr($day['title']); ?>" placeholder="Day <?php echo $i+1; ?>: Title" style="padding:8px;border:1px solid #ddd;border-radius:4px;font-size:13px;width:100%">
        <textarea class="fw-day-desc" style="padding:8px;border:1px solid #ddd;border-radius:4px;font-size:13px;width:100%;min-height:55px;resize:vertical" placeholder="What happens this day..."><?php echo esc_textarea($day['description']); ?></textarea>
        <button type="button" onclick="fwRemoveDay(this)" style="background:#e74c3c;color:#fff;border:none;border-radius:4px;width:34px;height:34px;cursor:pointer;font-size:16px">x</button>
    </div>
    <?php endforeach; ?>
    </div>
    <button type="button" onclick="fwAddDay()" style="background:#2a7a6e;color:#fff;border:none;border-radius:4px;padding:9px 18px;cursor:pointer;font-size:13px">+ Add Day</button>
    <script>
    function fwRemoveDay(btn){ btn.closest('.fw-itin-row').remove(); fwSyncItin(); }
    function fwAddDay(){
        var rows = document.getElementById('fw-itin-rows');
        var num  = rows.querySelectorAll('.fw-itin-row').length + 1;
        var r    = document.createElement('div');
        r.className = 'fw-itin-row';
        r.style = 'display:grid;grid-template-columns:220px 1fr 34px;gap:10px;margin-bottom:8px;align-items:start';
        r.innerHTML = '<input type="text" class="fw-day-title" placeholder="Day '+num+': Title" style="padding:8px;border:1px solid #ddd;border-radius:4px;font-size:13px;width:100%">'
            +'<textarea class="fw-day-desc" style="padding:8px;border:1px solid #ddd;border-radius:4px;font-size:13px;width:100%;min-height:55px;resize:vertical" placeholder="Description..."></textarea>'
            +'<button type="button" onclick="fwRemoveDay(this)" style="background:#e74c3c;color:#fff;border:none;border-radius:4px;width:34px;height:34px;cursor:pointer;font-size:16px">x</button>';
        rows.appendChild(r);
        fwSyncItin();
    }
    function fwSyncItin(){
        var days=[];
        document.querySelectorAll('#fw-itin-rows .fw-itin-row').forEach(function(row){
            days.push({title:row.querySelector('.fw-day-title').value,description:row.querySelector('.fw-day-desc').value});
        });
        document.getElementById('fw_itinerary_json').value=JSON.stringify(days);
    }
    var fwForm=document.getElementById('post');
    if(fwForm) fwForm.addEventListener('submit',fwSyncItin);
    document.getElementById('fw-itin-rows').addEventListener('input',fwSyncItin);
    </script>
    <?php
}
function fw_exp_details_cb($post) {
    $m = function($k) use ($post){ return get_post_meta($post->ID,$k,true); };
    ?>
    <div class="fw-grid">
        <div class="fw-f">
            <label>Inclusions ✅ (one per line)</label>
            <textarea name="fw_inclusions" style="min-height:130px" placeholder="Accommodation&#10;Meals (as per itinerary)&#10;Mechanic support&#10;Convoy lead vehicle"><?php echo esc_textarea($m('fw_inclusions')); ?></textarea>
        </div>
        <div class="fw-f">
            <label>Exclusions ❌ (one per line)</label>
            <textarea name="fw_exclusions" style="min-height:130px" placeholder="Flights&#10;Fuel&#10;Personal expenses&#10;Travel insurance"><?php echo esc_textarea($m('fw_exclusions')); ?></textarea>
        </div>
    </div>
    <?php
}

function fw_exp_gallery_cb($post) {
    $m       = function($k) use ($post){ return get_post_meta($post->ID,$k,true); };
    $gal_raw = $m('fw_gallery');
    $gallery = $gal_raw ? json_decode($gal_raw, true) : array();
    if (!is_array($gallery)) $gallery = array();
    ?>
    <input type="hidden" name="fw_gallery_data" id="fw_gallery_data" value="<?php echo esc_attr($gal_raw); ?>">
    <p style="color:#888;font-size:12px;margin-bottom:10px">These photos appear in the carousel on the expedition page. Recommended: 1200×800px. Upload as many as you want.</p>
    <div id="fw-gal-preview" style="display:flex;flex-wrap:wrap;gap:8px;margin-bottom:12px">
    <?php foreach ($gallery as $img): if (empty($img['url'])) continue; ?>
        <div class="fw-gi" style="position:relative;width:110px;height:72px;border-radius:4px;overflow:hidden;background:#eee">
            <img src="<?php echo esc_url($img['url']); ?>" style="width:100%;height:100%;object-fit:cover">
            <button type="button" onclick="fwRmGal(this,'<?php echo esc_js($img['id']); ?>')"
                style="position:absolute;top:2px;right:2px;background:rgba(231,76,60,.9);color:#fff;border:none;border-radius:2px;padding:1px 5px;cursor:pointer;font-size:11px">✕</button>
        </div>
    <?php endforeach; ?>
    </div>
    <button type="button" id="fw-open-gal" class="button button-primary">📷 Upload / Select Photos</button>
    <span id="fw-gal-count" style="color:#888;font-size:12px;margin-left:10px"><?php echo count($gallery); ?> photo(s)</span>
    <script>
    var fwGD = <?php echo $gal_raw && !empty($gallery) ? $gal_raw : '[]'; ?>;
    function fwSyncGal(){ document.getElementById('fw_gallery_data').value=JSON.stringify(fwGD); document.getElementById('fw-gal-count').textContent=fwGD.length+' photo(s)'; }
    function fwRmGal(btn,id){ fwGD=fwGD.filter(function(x){return String(x.id)!==String(id);}); fwSyncGal(); btn.closest('.fw-gi').remove(); }
    document.getElementById('fw-open-gal').addEventListener('click',function(){
        var f=wp.media({title:'Select Expedition Photos',button:{text:'Add to Gallery'},multiple:true});
        f.on('select',function(){
            f.state().get('selection').each(function(a){
                var d=a.toJSON();
                if(fwGD.find(function(x){return x.id===d.id;}))return;
                fwGD.push({id:d.id,url:d.url});
                var el=document.createElement('div');
                el.className='fw-gi';el.style='position:relative;width:110px;height:72px;border-radius:4px;overflow:hidden;background:#eee';
                el.innerHTML='<img src="'+d.url+'" style="width:100%;height:100%;object-fit:cover"><button type="button" onclick="fwRmGal(this,\''+d.id+'\')" style="position:absolute;top:2px;right:2px;background:rgba(231,76,60,.9);color:#fff;border:none;border-radius:2px;padding:1px 5px;cursor:pointer;font-size:11px">✕</button>';
                document.getElementById('fw-gal-preview').appendChild(el);
            });
            fwSyncGal();
        });
        f.open();
    });
    </script>
    <?php
}

function fw_exp_faq_cb($post) {
    $m    = function($k) use ($post){ return get_post_meta($post->ID,$k,true); };
    $faqs_raw = $m('fw_exp_faqs');
    $faqs = $faqs_raw ? json_decode($faqs_raw, true) : array();
    if (!is_array($faqs)) $faqs = array();
    // Ensure at least 3 empty rows
    while (count($faqs) < 3) $faqs[] = array('q'=>'','a'=>'');
    ?>
    <div id="fw-faq-builder" style="display:flex;flex-direction:column;gap:10px">
        <?php foreach ($faqs as $i => $faq): ?>
        <div class="fw-faq-row" style="background:#f9f9f9;border:1px solid #e0e0e0;border-radius:4px;padding:12px;position:relative">
            <div style="position:absolute;top:8px;right:8px">
                <button type="button" onclick="fwRemoveFaq(this)" style="background:#c0392b;color:#fff;border:none;border-radius:2px;padding:2px 8px;cursor:pointer;font-size:11px">✕ Remove</button>
            </div>
            <label style="display:block;font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:1px;color:#555;margin-bottom:4px">Question</label>
            <input type="text" name="fw_faq_q[]" value="<?php echo esc_attr($faq['q']); ?>" placeholder="e.g. What permits do I need for this expedition?" style="width:100%;box-sizing:border-box;margin-bottom:8px;padding:8px;border:1px solid #ddd;border-radius:2px;font-size:13px">
            <label style="display:block;font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:1px;color:#555;margin-bottom:4px">Answer</label>
            <textarea name="fw_faq_a[]" rows="3" placeholder="Write a clear, helpful answer..." style="width:100%;box-sizing:border-box;padding:8px;border:1px solid #ddd;border-radius:2px;font-size:13px;resize:vertical"><?php echo esc_textarea($faq['a']); ?></textarea>
        </div>
        <?php endforeach; ?>
    </div>
    <button type="button" onclick="fwAddFaq()" style="margin-top:10px;padding:8px 18px;background:#2271b1;color:#fff;border:none;border-radius:2px;cursor:pointer;font-size:13px">+ Add FAQ</button>
    <p style="margin-top:8px;color:#888;font-size:12px">These FAQs are specific to this expedition and appear on the expedition page. Leave questions blank to skip them.</p>
    <script>
    function fwAddFaq() {
        var container = document.getElementById('fw-faq-builder');
        var div = document.createElement('div');
        div.className = 'fw-faq-row';
        div.style.cssText = 'background:#f9f9f9;border:1px solid #e0e0e0;border-radius:4px;padding:12px;position:relative;margin-top:10px';
        div.innerHTML = '<div style="position:absolute;top:8px;right:8px"><button type="button" onclick="fwRemoveFaq(this)" style="background:#c0392b;color:#fff;border:none;border-radius:2px;padding:2px 8px;cursor:pointer;font-size:11px">✕ Remove</button></div>'
            + '<label style="display:block;font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:1px;color:#555;margin-bottom:4px">Question</label>'
            + '<input type="text" name="fw_faq_q[]" placeholder="e.g. What permits do I need?" style="width:100%;box-sizing:border-box;margin-bottom:8px;padding:8px;border:1px solid #ddd;border-radius:2px;font-size:13px">'
            + '<label style="display:block;font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:1px;color:#555;margin-bottom:4px">Answer</label>'
            + '<textarea name="fw_faq_a[]" rows="3" placeholder="Write a clear, helpful answer..." style="width:100%;box-sizing:border-box;padding:8px;border:1px solid #ddd;border-radius:2px;font-size:13px;resize:vertical"></textarea>';
        container.appendChild(div);
    }
    function fwRemoveFaq(btn) {
        btn.closest('.fw-faq-row').remove();
    }
    </script>
    <?php
}

function fw_exp_side_cb($post) {
    $m = function($k) use ($post){ return get_post_meta($post->ID,$k,true); };
    ?>
    <div class="fw-f">
        <label>Card Emoji (if no photo set)</label>
        <input type="text" name="fw_hero_emoji" value="<?php echo esc_attr($m('fw_hero_emoji') ?: '🏔️'); ?>">
    </div>
    <div class="fw-f">
        <label>Display Order (lower = first)</label>
        <input type="number" name="fw_order" value="<?php echo esc_attr($m('fw_order') ?: 0); ?>">
    </div>
    <hr style="margin:12px 0">
    <p style="font-size:11px;color:#666"><strong>Featured Image</strong> = thumbnail shown on the card and at top of trip page.</p>
    <?php
}

/* ═══════════════════════════════════
   5. ALBUM META BOXES
═══════════════════════════════════ */
function freewheel_album_meta_boxes() {
    add_meta_box('fw_alb_main',   '📸 Album Details',          'fw_alb_main_cb',   'fw_album', 'normal', 'high');
    add_meta_box('fw_alb_photos', '🖼️ Album Photos (gallery)', 'fw_alb_photos_cb', 'fw_album', 'normal', 'default');
}
add_action('add_meta_boxes', 'freewheel_album_meta_boxes');

function fw_alb_main_cb($post) {
    wp_nonce_field('fw_save_alb','fw_alb_nonce');
    $m = function($k) use ($post){ return get_post_meta($post->ID,$k,true); };
    ?>
    <div class="fw-grid g3">
        <div class="fw-f"><label>Date</label><input type="text" name="fw_alb_date" value="<?php echo esc_attr($m('fw_alb_date')); ?>" placeholder="February 2026"></div>
        <div class="fw-f"><label>Duration</label><input type="text" name="fw_alb_duration" value="<?php echo esc_attr($m('fw_alb_duration')); ?>" placeholder="10N / 11D"></div>
        <div class="fw-f"><label>Travellers</label><input type="number" name="fw_alb_travellers" value="<?php echo esc_attr($m('fw_alb_travellers')); ?>" placeholder="22"></div>
    </div>
    <div class="fw-grid">
        <div class="fw-f"><label>Location / State</label><input type="text" name="fw_alb_location" value="<?php echo esc_attr($m('fw_alb_location')); ?>" placeholder="Himachal Pradesh"></div>
        <div class="fw-f"><label>Display Order (lower = top)</label><input type="number" name="fw_alb_order" value="<?php echo esc_attr($m('fw_alb_order') ?: 0); ?>"></div>
    </div>
    <div class="fw-f">
        <label>Trip Highlight Quote</label>
        <input type="text" name="fw_alb_highlight" value="<?php echo esc_attr($m('fw_alb_highlight')); ?>" placeholder="Chandrataal frozen lake & Key Monastery under snow">
    </div>
    <p style="font-size:11px;color:#888;margin-top:8px"><strong>Featured Image</strong> = album cover / hero photo (large image at top of album).</p>
    <?php
}

function fw_alb_photos_cb($post) {
    $m       = function($k) use ($post){ return get_post_meta($post->ID,$k,true); };
    $raw     = $m('fw_album_photos');
    $photos  = $raw ? json_decode($raw, true) : array();
    if (!is_array($photos)) $photos = array();
    ?>
    <input type="hidden" name="fw_album_photos_data" id="fw_album_photos_data" value="<?php echo esc_attr($raw); ?>">
    <p style="color:#888;font-size:12px;margin-bottom:10px">Upload expedition photos. Recommended: 1200×800px landscape. No limit on number of photos.</p>
    <div id="fw-alb-preview" style="display:grid;grid-template-columns:repeat(6,1fr);gap:8px;margin-bottom:12px">
    <?php foreach ($photos as $img): if (empty($img['url'])) continue; ?>
        <div class="fw-ai" style="position:relative;aspect-ratio:16/9;border-radius:4px;overflow:hidden;background:#eee">
            <img src="<?php echo esc_url($img['url']); ?>" style="width:100%;height:100%;object-fit:cover">
            <button type="button" onclick="fwRmAlb(this,'<?php echo esc_js($img['id']); ?>')"
                style="position:absolute;top:2px;right:2px;background:rgba(231,76,60,.9);color:#fff;border:none;border-radius:2px;padding:1px 5px;cursor:pointer;font-size:11px">✕</button>
        </div>
    <?php endforeach; ?>
    </div>
    <button type="button" id="fw-open-alb" class="button button-primary">📷 Add Photos</button>
    <span id="fw-alb-count" style="color:#888;font-size:12px;margin-left:10px"><?php echo count($photos); ?> photo(s)</span>
    <script>
    var fwAP = <?php echo $raw && !empty($photos) ? $raw : '[]'; ?>;
    function fwSyncAlb(){ document.getElementById('fw_album_photos_data').value=JSON.stringify(fwAP); document.getElementById('fw-alb-count').textContent=fwAP.length+' photo(s)'; }
    function fwRmAlb(btn,id){ fwAP=fwAP.filter(function(x){return String(x.id)!==String(id);}); fwSyncAlb(); btn.closest('.fw-ai').remove(); }
    document.getElementById('fw-open-alb').addEventListener('click',function(){
        var f=wp.media({title:'Select Album Photos',button:{text:'Add Photos'},multiple:true});
        f.on('select',function(){
            f.state().get('selection').each(function(a){
                var d=a.toJSON();
                if(fwAP.find(function(x){return x.id===d.id;}))return;
                fwAP.push({id:d.id,url:d.url});
                var el=document.createElement('div');
                el.className='fw-ai';el.style='position:relative;aspect-ratio:16/9;border-radius:4px;overflow:hidden;background:#eee';
                el.innerHTML='<img src="'+d.url+'" style="width:100%;height:100%;object-fit:cover"><button type="button" onclick="fwRmAlb(this,\''+d.id+'\')" style="position:absolute;top:2px;right:2px;background:rgba(231,76,60,.9);color:#fff;border:none;border-radius:2px;padding:1px 5px;cursor:pointer;font-size:11px">✕</button>';
                document.getElementById('fw-alb-preview').appendChild(el);
            });
            fwSyncAlb();
        });
        f.open();
    });
    </script>
    <?php
}

/* ═══════════════════════════════════
   6. PRODUCT META BOXES
═══════════════════════════════════ */
function freewheel_product_meta_boxes() {
    add_meta_box('fw_prod_main', '🛍️ Product Details', 'fw_prod_main_cb', 'fw_product', 'normal', 'high');
}
add_action('add_meta_boxes', 'freewheel_product_meta_boxes');

function fw_prod_main_cb($post) {
    wp_nonce_field('fw_save_prod','fw_prod_nonce');
    $m = function($k) use ($post){ return get_post_meta($post->ID,$k,true); };
    $stock = $m('fw_prod_stock') ?: 'in-stock';
    $stock_labels = array('in-stock'=>'✅ In Stock','new-arrival'=>'🆕 New Arrival','limited-stock'=>'⚡ Limited Stock','out-of-stock'=>'❌ Out of Stock');
    ?>
    <div style="background:<?php echo $stock==='out-of-stock'?'#fef2f0':($stock==='limited-stock'?'#fffbf0':($stock==='new-arrival'?'#f0f7ff':'#f0fff4')); ?>;border-radius:6px;padding:12px 16px;margin-bottom:16px;font-size:14px;font-weight:600">
        Current Status: <?php echo $stock_labels[$stock] ?? $stock; ?>
    </div>
    <div class="fw-grid g3">
        <div class="fw-f">
            <label>Price (₹)</label>
            <input type="number" name="fw_prod_price" value="<?php echo esc_attr($m('fw_prod_price')); ?>" placeholder="799">
        </div>
        <div class="fw-f">
            <label>Original Price (₹ strikethrough)</label>
            <input type="number" name="fw_prod_orig_price" value="<?php echo esc_attr($m('fw_prod_orig_price')); ?>" placeholder="Leave blank if no discount">
        </div>
        <div class="fw-f">
            <label>Category</label>
            <input type="text" name="fw_prod_category" value="<?php echo esc_attr($m('fw_prod_category')); ?>" placeholder="T-Shirts / Caps / Mugs">
        </div>
    </div>
    <div class="fw-grid">
        <div class="fw-f">
            <label>🚦 Stock Status (updates LIVE on site)</label>
            <select name="fw_prod_stock" style="font-size:14px;font-weight:600">
                <option value="in-stock"      <?php selected($stock,'in-stock');      ?>>✅ In Stock</option>
                <option value="new-arrival"   <?php selected($stock,'new-arrival');   ?>>🆕 New Arrival</option>
                <option value="limited-stock" <?php selected($stock,'limited-stock'); ?>>⚡ Limited Stock</option>
                <option value="out-of-stock"  <?php selected($stock,'out-of-stock');  ?>>❌ Out of Stock</option>
            </select>
            <p class="fw-tip">Change this and save — instantly updates the website badge.</p>
        </div>
        <div class="fw-f">
            <label>Display Order (lower = first)</label>
            <input type="number" name="fw_prod_order" value="<?php echo esc_attr($m('fw_prod_order') ?: 0); ?>">
        </div>
    </div>
    <div class="fw-f">
        <label>Special Feature / Material (shown on card — e.g. "Ceramic", "100% Cotton", "Stainless Steel")</label>
        <input type="text" name="fw_prod_feature" value="<?php echo esc_attr($m('fw_prod_feature')); ?>" placeholder="e.g. Ceramic / 100% Cotton / Stainless Steel">
    </div>
    <div class="fw-f">
        <label>Short Description (shown on card)</label>
        <textarea name="fw_prod_desc" style="min-height:70px"><?php echo esc_textarea($m('fw_prod_desc')); ?></textarea>
    </div>
    <div class="fw-f">
        <label>WhatsApp Order Message (pre-filled)</label>
        <input type="text" name="fw_prod_wa_msg" value="<?php echo esc_attr($m('fw_prod_wa_msg') ?: 'Hi! I want to order: '.get_the_title($post->ID)); ?>">
    </div>
    <div class="fw-grid" style="grid-template-columns:1fr 1fr;gap:16px;margin-top:12px">
        <div class="fw-f">
            <label>Available Colors (comma separated)</label>
            <input type="text" name="fw_prod_colors" value="<?php echo esc_attr($m('fw_prod_colors')); ?>" placeholder="White,Black,Olive Green">
            <p class="fw-tip">Exact names used in WhatsApp message. E.g: White, Black, Olive Green</p>
        </div>
        <div class="fw-f">
            <label>Available Sizes (comma separated)</label>
            <input type="text" name="fw_prod_sizes" value="<?php echo esc_attr($m('fw_prod_sizes')); ?>" placeholder="M (36),L (38),XL (40),XXL (42),XXXL (44)">
            <p class="fw-tip">Leave blank to hide size selector. Default T-shirt sizes pre-filled above.</p>
        </div>
    </div>
    <p style="font-size:11px;color:#888;margin-top:10px"><strong>Featured Image</strong> = product photo shown on the card. Recommended: 600×600px square.</p>
    <?php
}

/* ═══════════════════════════════════
   7. SAVE ALL META
═══════════════════════════════════ */
function freewheel_save_all_meta($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;
    $type = get_post_type($post_id);

    if ($type === 'fw_blog' && isset($_POST['fw_blog_nonce']) && wp_verify_nonce($_POST['fw_blog_nonce'],'fw_save_blog')) {
        $tf = array('fw_blog_author','fw_blog_subtitle','fw_blog_tags','fw_blog_seo_desc','fw_blog_read_time');
        foreach ($tf as $f) { if (isset($_POST[$f])) update_post_meta($post_id,$f,sanitize_text_field($_POST[$f])); }
        if (isset($_POST['fw_blog_content'])) update_post_meta($post_id,'fw_blog_content',wp_kses_post($_POST['fw_blog_content']));
    }

    if ($type === 'fw_expedition' && isset($_POST['fw_exp_nonce']) && wp_verify_nonce($_POST['fw_exp_nonce'],'fw_save_exp')) {
        $tf = array('fw_status','fw_destination','fw_dates','fw_month','fw_duration','fw_region','fw_difficulty','fw_subtitle','fw_overview','fw_highlights','fw_badge','fw_hero_emoji','fw_inclusions','fw_exclusions','fw_cancellation','fw_things_carry','fw_whatsapp','fw_price_unit','fw_qr_image');
        $nf = array('fw_price','fw_couple_price','fw_seat_price','fw_max_slots','fw_filled_slots','fw_order');
        foreach ($tf as $f) { if (isset($_POST[$f])) update_post_meta($post_id,$f,sanitize_textarea_field($_POST[$f])); }
        foreach ($nf as $f) { if (isset($_POST[$f])) update_post_meta($post_id,$f,intval($_POST[$f])); }
        if (isset($_POST['fw_itinerary_json']) && !empty($_POST['fw_itinerary_json'])) {
            $raw  = stripslashes($_POST['fw_itinerary_json']);
            $days = json_decode($raw, true);
            if (is_array($days)) {
                $clean = array();
                foreach ($days as $d) {
                    $clean[] = array(
                        'title'       => sanitize_text_field($d['title'] ?? ''),
                        'description' => sanitize_textarea_field($d['description'] ?? ''),
                    );
                }
                update_post_meta($post_id, 'fw_itinerary', json_encode($clean));
            }
        } elseif (isset($_POST['fw_day_title'])) {
            $titles = array_map('sanitize_text_field',$_POST['fw_day_title']);
            $descs  = isset($_POST['fw_day_desc']) ? array_map('sanitize_textarea_field',$_POST['fw_day_desc']) : array();
            $days=array();
            foreach($titles as $i=>$t){ if(trim($t)||!empty($descs[$i])){ $days[]=array('title'=>$t,'description'=>isset($descs[$i])?$descs[$i]:''); } }
            update_post_meta($post_id,'fw_itinerary',json_encode($days));
        }
        if (isset($_POST['fw_gallery_data'])) update_post_meta($post_id,'fw_gallery',sanitize_text_field($_POST['fw_gallery_data']));
    }

    // save expedition FAQs (piggybacked on main expedition save)
    if ($type === 'fw_expedition' && isset($_POST['fw_exp_nonce']) && wp_verify_nonce($_POST['fw_exp_nonce'],'fw_save_exp')) {
        $qs = isset($_POST['fw_faq_q']) ? (array)$_POST['fw_faq_q'] : array();
        $as = isset($_POST['fw_faq_a']) ? (array)$_POST['fw_faq_a'] : array();
        $faqs = array();
        foreach ($qs as $i => $q) {
            $q = sanitize_text_field($q);
            $a = sanitize_textarea_field(isset($as[$i]) ? $as[$i] : '');
            if ($q !== '') $faqs[] = array('q' => $q, 'a' => $a);
        }
        update_post_meta($post_id, 'fw_exp_faqs', json_encode($faqs, JSON_UNESCAPED_UNICODE));
    }

        if ($type === 'fw_album' && isset($_POST['fw_alb_nonce']) && wp_verify_nonce($_POST['fw_alb_nonce'],'fw_save_alb')) {
        $tf = array('fw_alb_date','fw_alb_duration','fw_alb_location','fw_alb_highlight');
        foreach ($tf as $f) { if (isset($_POST[$f])) update_post_meta($post_id,$f,sanitize_text_field($_POST[$f])); }
        if (isset($_POST['fw_alb_travellers'])) update_post_meta($post_id,'fw_alb_travellers',intval($_POST['fw_alb_travellers']));
        if (isset($_POST['fw_alb_order']))      update_post_meta($post_id,'fw_alb_order',intval($_POST['fw_alb_order']));
        if (isset($_POST['fw_album_photos_data'])) update_post_meta($post_id,'fw_album_photos',sanitize_text_field($_POST['fw_album_photos_data']));
    }

    if ($type === 'fw_product' && isset($_POST['fw_prod_nonce']) && wp_verify_nonce($_POST['fw_prod_nonce'],'fw_save_prod')) {
        $tf = array('fw_prod_category','fw_prod_stock','fw_prod_desc','fw_prod_wa_msg','fw_prod_feature','fw_prod_colors','fw_prod_sizes');
        foreach ($tf as $f) { if (isset($_POST[$f])) update_post_meta($post_id,$f,sanitize_textarea_field($_POST[$f])); }
        $nf = array('fw_prod_price','fw_prod_orig_price','fw_prod_order');
        foreach ($nf as $f) { if (isset($_POST[$f])) update_post_meta($post_id,$f,intval($_POST[$f])); }
    }
}
add_action('save_post','freewheel_save_all_meta');

add_action('save_post', function($post_id){
    if (!isset($_POST['fw_testi_nonce']) || !wp_verify_nonce($_POST['fw_testi_nonce'],'fw_save_testi')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (get_post_type($post_id) !== 'fw_testimonial') return;
    if (isset($_POST['fw_testi_review'])) update_post_meta($post_id,'fw_testi_review',sanitize_textarea_field($_POST['fw_testi_review']));
    if (isset($_POST['fw_testi_trip']))   update_post_meta($post_id,'fw_testi_trip',sanitize_text_field($_POST['fw_testi_trip']));
    if (isset($_POST['fw_testi_rating'])) update_post_meta($post_id,'fw_testi_rating',sanitize_text_field($_POST['fw_testi_rating']));
    if (isset($_POST['fw_testi_order']))  update_post_meta($post_id,'fw_testi_order',sanitize_text_field($_POST['fw_testi_order']));
});

// Render blog content — converts [photo]URL[/photo] into styled inline images
function fw_render_blog_content($raw){
    $html = wp_kses_post($raw);
    $html = preg_replace_callback(
        '/\[photo\](.*?)\[\/photo\]/s',
        function($m){
            $url = esc_url(trim($m[1]));
            if(!$url) return '';
            return '<figure class="sp-inline-photo"><img src="'.$url.'" alt="" loading="lazy"></figure>';
        },
        $html
    );
    return $html;
}

// Booking confirmation email handler
add_action('wp_ajax_fw_confirm_booking',        'fw_handle_confirm_booking');
add_action('wp_ajax_nopriv_fw_confirm_booking', 'fw_handle_confirm_booking');
function fw_handle_confirm_booking(){
    if(!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'],'fw_booking_nonce')){
        wp_send_json(array('success'=>false));
    }
    $exp   = sanitize_text_field($_POST['exp_title']  ?? '');
    $dates = sanitize_text_field($_POST['exp_dates']  ?? '');
    $name  = sanitize_text_field($_POST['user_name']  ?? '');
    $email = sanitize_email($_POST['user_email']      ?? '');
    $phone = sanitize_text_field($_POST['user_phone'] ?? '');

    $subject = 'New Booking Confirmation — ' . $exp;
    $body  = "New booking received on FreeWheel Expeditions.\n\n";
    $body .= "Expedition : " . $exp   . "\n";
    $body .= "Dates      : " . $dates . "\n\n";
    $body .= "--- TRAVELLER DETAILS ---\n";
    $body .= "Name       : " . $name  . "\n";
    $body .= "Email      : " . $email . "\n";
    $body .= "Phone      : " . $phone . "\n\n";
    $body .= "The traveller has confirmed payment. Please verify and confirm their slot.\n";

    $headers = array('Content-Type: text/plain; charset=UTF-8');

    // Email to admin
    wp_mail('freewheelexpeditions@gmail.com', $subject, $body, $headers);

    // SMS notification via Fast2SMS (key stored in wp-config.php as FW_FAST2SMS_KEY)
    if ( FW_FAST2SMS_KEY ) {
        $sms_msg = 'New booking: '.$name.' ('.$phone.') confirmed payment for '.$exp.'. Login to FreeWheel admin to verify.';
        wp_remote_get( 'https://www.fast2sms.com/dev/bulkV2?authorization=' . rawurlencode(FW_FAST2SMS_KEY) . '&route=q&message=' . urlencode($sms_msg) . '&language=english&flash=0&numbers=7817838060' );
    }

    wp_send_json(array('success'=>true));
}

// NOTE: Old fw_subscribe AJAX handler removed (was email-only, no OTP, used fw_subscribers option).
// New subscribe system uses REST endpoints /subscribe and /send-welcome in fw_rest_subscribe/fw_rest_send_welcome above.

// Blog comment AJAX handler
add_action('wp_ajax_fw_post_comment',        'fw_handle_blog_comment');
add_action('wp_ajax_nopriv_fw_post_comment', 'fw_handle_blog_comment');
function fw_handle_blog_comment(){
    if(!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'],'fw_comment_nonce')){
        wp_send_json(array('success'=>false,'message'=>'Security check failed.'));
    }
    $post_id = intval($_POST['post_id'] ?? 0);
    $author  = sanitize_text_field($_POST['author'] ?? '');
    $email   = sanitize_email($_POST['email'] ?? '');
    $comment = sanitize_textarea_field($_POST['comment'] ?? '');
    if(!$post_id || !$author || !$comment){
        wp_send_json(array('success'=>false,'message'=>'Missing required fields.'));
    }
    $result = wp_insert_comment(array(
        'comment_post_ID'      => $post_id,
        'comment_author'       => $author,
        'comment_author_email' => $email,
        'comment_content'      => $comment,
        'comment_approved'     => 0, // pending review
        'comment_type'         => '',
    ));
    if($result){
        wp_send_json(array('success'=>true));
    } else {
        wp_send_json(array('success'=>false,'message'=>'Could not save comment.'));
    }
}

add_filter('manage_fw_blog_posts_columns', function($c){
    return array('cb'=>$c['cb'],'title'=>'Title','fw_blog_author'=>'Author','fw_blog_tags'=>'Tags','fw_blog_read_time'=>'Read Time','date'=>'Published');
});
add_action('manage_fw_blog_posts_custom_column',function($col,$pid){
    if($col==='fw_blog_author')    echo esc_html(get_post_meta($pid,'fw_blog_author',true));
    if($col==='fw_blog_tags')      echo esc_html(get_post_meta($pid,'fw_blog_tags',true));
    if($col==='fw_blog_read_time') echo esc_html(get_post_meta($pid,'fw_blog_read_time',true));
},10,2);

// SEO meta description for blog posts
add_action('wp_head',function(){
    if(is_singular('fw_blog')){
        global $post;
        $desc = get_post_meta($post->ID,'fw_blog_seo_desc',true);
        if(!$desc) $desc = wp_strip_all_tags(substr(get_post_meta($post->ID,'fw_blog_content',true),0,160));
        $thumb = get_the_post_thumbnail_url($post->ID,'large') ?: '';
        $title = get_the_title($post->ID);
        echo '<meta name="description" content="'.esc_attr($desc).'">'."\n";
        echo '<meta property="og:title" content="'.esc_attr($title).' | FreeWheel Expeditions">'."\n";
        echo '<meta property="og:description" content="'.esc_attr($desc).'">'."\n";
        if($thumb) echo '<meta property="og:image" content="'.esc_url($thumb).'">'."\n";
        echo '<meta property="og:type" content="article">'."\n";
        echo '<meta property="og:url" content="'.esc_url(get_permalink($post->ID)).'">'."\n";
    }
});

add_filter('manage_fw_testimonial_posts_columns', function($c){
    return array('cb'=>$c['cb'],'title'=>'Traveller Name','fw_t_trip'=>'Trip Done','fw_t_rating'=>'Rating','fw_t_order'=>'Order','date'=>'Added');
});
add_action('manage_fw_testimonial_posts_custom_column', function($col,$pid){
    if ($col==='fw_t_trip')   echo esc_html(get_post_meta($pid,'fw_testi_trip',true));
    if ($col==='fw_t_rating') echo str_repeat('*', intval(get_post_meta($pid,'fw_testi_rating',true) ?: 5)) . ' (' . get_post_meta($pid,'fw_testi_rating',true) . ')';
    if ($col==='fw_t_order')  echo esc_html(get_post_meta($pid,'fw_testi_order',true) ?: '0');
}, 10, 2);

function fw_testimonials(){
    return get_posts(array(
        'post_type'      => 'fw_testimonial',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'meta_key'       => 'fw_testi_order',
        'orderby'        => 'meta_value_num',
        'order'          => 'ASC',
    ));
}

/* ═══════════════════════════════════
   8. ADMIN LIST COLUMNS
═══════════════════════════════════ */
add_filter('manage_fw_expedition_posts_columns', function($c){
    return array('cb'=>$c['cb'],'title'=>'Expedition','fw_stat'=>'Status','fw_dt'=>'Dates','fw_pr'=>'Price','fw_sl'=>'Slots Left','fw_th'=>'Photo','date'=>'Added');
});
add_action('manage_fw_expedition_posts_custom_column',function($col,$pid){
    $m=function($k)use($pid){return get_post_meta($pid,$k,true);};
    if($col==='fw_stat'){ $s=$m('fw_status')?:'upcoming'; echo $s==='upcoming'?'<span style="color:green;font-weight:700">⬆️ Upcoming</span>':'<span style="color:#888">✅ Past</span>'; }
    if($col==='fw_dt')  echo esc_html($m('fw_dates'));
    if($col==='fw_pr')  echo $m('fw_price')?'₹'.number_format((int)$m('fw_price')).' '.$m('fw_price_unit'):'—';
    if($col==='fw_sl'){
        $mx=(int)$m('fw_max_slots'); $fl=(int)$m('fw_filled_slots'); $lt=max(0,$mx-$fl);
        $cl=$lt<=3?'#e74c3c':($lt<=8?'#e8a020':'#27ae60');
        echo "<strong style='color:{$cl}'>{$lt}</strong>/{$mx}";
    }
    if($col==='fw_th') echo get_the_post_thumbnail($pid,array(60,40))?:'<span style="color:#ccc;font-size:11px">No photo</span>';
},10,2);

add_filter('manage_fw_product_posts_columns',function($c){
    return array('cb'=>$c['cb'],'title'=>'Product','fw_pc'=>'Category','fw_ps'=>'🚦 Stock','fw_pp'=>'Price','fw_pt'=>'Photo','date'=>'Added');
});
add_action('manage_fw_product_posts_custom_column',function($col,$pid){
    $m=function($k)use($pid){return get_post_meta($pid,$k,true);};
    if($col==='fw_pc') echo esc_html($m('fw_prod_category'));
    if($col==='fw_pp') echo $m('fw_prod_price')?'₹'.number_format((int)$m('fw_prod_price')):'—';
    if($col==='fw_ps'){
        $map=array('in-stock'=>'<span style="background:#27ae60;color:#fff;padding:2px 8px;border-radius:3px;font-size:11px">✅ In Stock</span>','new-arrival'=>'<span style="background:#2980b9;color:#fff;padding:2px 8px;border-radius:3px;font-size:11px">🆕 New</span>','limited-stock'=>'<span style="background:#e8a020;color:#fff;padding:2px 8px;border-radius:3px;font-size:11px">⚡ Limited</span>','out-of-stock'=>'<span style="background:#e74c3c;color:#fff;padding:2px 8px;border-radius:3px;font-size:11px">❌ Out of Stock</span>');
        $s=$m('fw_prod_stock')?:'in-stock'; echo isset($map[$s])?$map[$s]:$s;
    }
    if($col==='fw_pt') echo get_the_post_thumbnail($pid,array(60,60))?:'<span style="color:#ccc;font-size:11px">No photo</span>';
},10,2);

/* ═══════════════════════════════════
   9. TEMPLATE HELPERS
═══════════════════════════════════ */
function fw_upcoming_expeditions(){
    return get_posts(array('post_type'=>'fw_expedition','post_status'=>'publish','posts_per_page'=>-1,
        'meta_query'=>array(array('key'=>'fw_status','value'=>'upcoming')),
        'meta_key'=>'fw_order','orderby'=>'meta_value_num','order'=>'ASC'));
}
function fw_past_albums(){
    return get_posts(array('post_type'=>'fw_album','post_status'=>'publish','posts_per_page'=>-1,
        'meta_key'=>'fw_alb_order','orderby'=>'meta_value_num','order'=>'ASC'));
}
function fw_products(){
    return get_posts(array('post_type'=>'fw_product','post_status'=>'publish','posts_per_page'=>-1,
        'meta_key'=>'fw_prod_order','orderby'=>'meta_value_num','order'=>'ASC'));
}

function fw_expedition_card($pid){
    $m=function($k)use($pid){return get_post_meta($pid,$k,true);};
    $title   = get_the_title($pid);
    $thumb   = get_the_post_thumbnail_url($pid,'expedition-thumb');
    $link    = get_permalink($pid);
    $month   = $m('fw_month')?:$m('fw_dates');
    $dur     = $m('fw_duration');
    $dest    = $m('fw_destination');
    $price   = (int)$m('fw_price');
    $unit    = $m('fw_price_unit')?:'per person';
    $max     = (int)($m('fw_max_slots')?:20);
    $filled  = (int)$m('fw_filled_slots');
    $left    = max(0,$max-$filled);
    $pct     = $max>0?round($filled/$max*100):0;
    $badge   = $m('fw_badge');
    $emoji   = $m('fw_hero_emoji')?:'🏔️';
    $grad    = 'linear-gradient(145deg,#1a1208,#0f0d0b)';
    $badge_h = $badge?'<div style="position:absolute;top:12px;left:12px;background:#c1440e;color:#fff;font-size:9px;letter-spacing:2px;text-transform:uppercase;padding:4px 10px;z-index:5;font-family:var(--body);font-weight:500">'.esc_html($badge).'</div>':'';
    $photo_h = $thumb?'<img src="'.esc_url($thumb).'" alt="'.esc_attr($title).'" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;z-index:1">':'';
    return '<div class="trip-card">
        <div class="tc-top" style="background:'.$grad.'">
          '.$photo_h.'
          <div class="tc-art" style="position:relative;z-index:2">'.esc_html($emoji).'</div>
          <div class="tc-grad" style="position:relative;z-index:3"></div>
          '.$badge_h.'
        </div>
        <div class="tc-body">
          <div class="tc-title">'.esc_html($title).'</div>
          <div class="tc-dur" style="color:var(--amber);font-size:13px;font-weight:500;margin:4px 0 4px">'.esc_html($dur).'</div>
          '.($m('fw_dates')?'<div style="font-size:12px;color:rgba(255,255,255,.5);margin-bottom:10px;letter-spacing:.5px">📅 '.esc_html($m('fw_dates')).'</div>':'').'
          <div class="tc-dets"><div class="tc-det">📍 '.esc_html($dest).'</div><div class="tc-det">🚙 Self Drive</div></div>
          <div class="tc-price"><span class="p-from">from</span><span class="p-num">₹'.number_format($price).'</span><span class="p-note">/ '.esc_html($unit).'</span></div>
          <div class="tc-btns"><a href="'.esc_url($link).'" class="det-btn">More Details</a><a href="https://wa.me/917817838060?text='.rawurlencode('Hi! I want to enquire about the '.$title.' expedition.').'" target="_blank" style="display:flex;align-items:center;justify-content:center;gap:6px;padding:10px 16px;background:#25D366;color:#fff;text-decoration:none;border-radius:2px;font-size:13px;font-weight:600;letter-spacing:1px;margin-top:8px">💬 WhatsApp Enquiry</a></div>
        </div>
      </div>';
}

/* ═══════════════════════════════════
   10. ADMIN WELCOME NOTICE
═══════════════════════════════════ */
function fw_admin_notice(){
    $s=get_current_screen();
    if($s&&in_array($s->id,array('dashboard','fw_expedition','edit-fw_expedition','fw_album','edit-fw_album','fw_product','edit-fw_product'))){
        echo '<div class="notice notice-info is-dismissible" style="border-left:4px solid #c1440e;padding:10px 14px">
        <strong style="color:#c1440e">🏔️ FreeWheel Expeditions</strong> — 
        <a href="'.admin_url('edit.php?post_type=fw_expedition').'">All Expeditions</a> · 
        <a href="'.admin_url('post-new.php?post_type=fw_expedition').'">+ New Expedition</a> · 
        <a href="'.admin_url('edit.php?post_type=fw_album').'">Past Albums</a> · 
        <a href="'.admin_url('post-new.php?post_type=fw_album').'">+ New Album</a> · 
        <a href="'.admin_url('edit.php?post_type=fw_product').'">Merchandise</a> · 
        <a href="'.admin_url('post-new.php?post_type=fw_product').'">+ New Product</a>
        </div>';
    }
}
add_action('admin_notices','fw_admin_notice');

/* ── Prevent WP login redirect to admin — always send to /dashboard/ ── */
add_filter('login_redirect', function($redirect, $request, $user){
    return home_url('/dashboard/');
}, 10, 3);

/* ── Disable WP redirect_to_admin for all front-end pages ── */
add_filter('wp_redirect', function($location, $status){
    // Block WP from redirecting /dashboard/ to /wp-admin/
    if ( strpos($location, 'wp-admin') !== false && strpos($_SERVER['REQUEST_URI'], 'dashboard') !== false ) {
        return false;
    }
    return $location;
}, 10, 2);

/* ── Auto Setup Helper ── */
require_once get_template_directory() . '/fw-setup.php';

/* ── FAQ System ── */
require_once get_template_directory() . '/fw-faq.php';

/* ── SEO, Schema & Performance Suite ── */
require_once get_template_directory() . '/fw-seo.php';


// ── Security headers ─────────────────────────────────────────────
add_action('send_headers', 'fw_add_security_headers');
function fw_add_security_headers() {
    header('X-Frame-Options: SAMEORIGIN');
    header('X-Content-Type-Options: nosniff');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
    header('Permissions-Policy: camera=(), microphone=(), geolocation=()');
    header('X-XSS-Protection: 1; mode=block');
}

// ── Hide WordPress version from all outputs ───────────────────────
remove_action('wp_head', 'wp_generator');
add_filter('the_generator', '__return_empty_string');

// ── Remove WordPress version from script/style query strings ─────
add_filter('style_loader_src',  'fw_remove_ver_query', 9999);
add_filter('script_loader_src', 'fw_remove_ver_query', 9999);
function fw_remove_ver_query($src) {
    if (strpos($src, 'ver=')) {
        $src = remove_query_arg('ver', $src);
    }
    return $src;
}

// ── Secure payment details via AJAX ──────────────────────────────
add_action('wp_ajax_fw_get_payment',        'fw_get_payment_details');
add_action('wp_ajax_nopriv_fw_get_payment', 'fw_get_payment_details');

function fw_get_payment_details() {
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'fw_payment_nonce')) {
        wp_send_json_error('Invalid request', 403);
        exit;
    }
    if (empty($_POST['has_items'])) {
        wp_send_json_error('No items', 400);
        exit;
    }
    wp_send_json_success(array(
        'upi'      => 'freewheelexpeditions@okicici',
        'acc_num'  => '0501001000000499',
        'ifsc'     => 'NTBL0HAL050',
        'bank'     => 'Nainital Bank, Haldwani',
        'qr_image' => get_option('fw_upi_qr_image', 'https://freewheelexpeditions.in/wp-content/uploads/2026/04/QR.jpeg'),
    ));
    exit;
}

/* ═══════════════════════════════════════════════════════════
   RAZORPAY INTEGRATION
   Keys defined in wp-config.php:
     define( 'FW_RAZORPAY_KEY_ID',     'rzp_test_...' );
     define( 'FW_RAZORPAY_KEY_SECRET', '...' );
═══════════════════════════════════════════════════════════ */
if ( ! defined( 'FW_RAZORPAY_KEY_ID' ) )     define( 'FW_RAZORPAY_KEY_ID',     '' );
if ( ! defined( 'FW_RAZORPAY_KEY_SECRET' ) ) define( 'FW_RAZORPAY_KEY_SECRET', '' );

/* Expose Razorpay key ID (public) to frontend */
add_action( 'wp_head', function() {
    if ( FW_RAZORPAY_KEY_ID ) {
        echo '<script>window.FW_RZP_KEY=' . json_encode( FW_RAZORPAY_KEY_ID ) . ';</script>' . "\n";
    }
}, 5 );

/* ── REST: Create Razorpay Order ── */
add_action( 'rest_api_init', function() {
    register_rest_route( 'freewheel/v1', '/rzp-create-order', array(
        'methods'             => 'POST',
        'callback'            => 'fw_rzp_create_order',
        'permission_callback' => '__return_true',
    ));
    register_rest_route( 'freewheel/v1', '/rzp-verify-payment', array(
        'methods'             => 'POST',
        'callback'            => 'fw_rzp_verify_payment',
        'permission_callback' => '__return_true',
    ));
});

function fw_rzp_create_order( $req ) {
    /* Auth check */
    $user = fw_validate_token( $req );
    if ( is_wp_error( $user ) ) return $user;

    $p       = $req->get_json_params() ?: array();
    $amount  = intval( $p['amount'] ?? 0 );   /* in paise */
    $type    = sanitize_text_field( $p['type'] ?? '' );   /* expedition | merchandise */
    $ref_id  = sanitize_text_field( $p['ref_id'] ?? '' ); /* expedition post ID or product ID */
    $note    = sanitize_text_field( $p['note'] ?? '' );

    if ( $amount < 100 ) {
        return new WP_Error( 'invalid_amount', 'Amount must be at least ₹1.', array( 'status' => 400 ) );
    }
    if ( ! in_array( $type, array( 'expedition', 'merchandise' ), true ) ) {
        return new WP_Error( 'invalid_type', 'type must be expedition or merchandise.', array( 'status' => 400 ) );
    }
    if ( ! FW_RAZORPAY_KEY_ID || ! FW_RAZORPAY_KEY_SECRET ) {
        return new WP_Error( 'rzp_config', 'Payment gateway not configured.', array( 'status' => 503 ) );
    }

    $receipt = 'fw_' . $type[0] . '_' . time() . '_' . substr( $user['id'], 0, 8 );

    $body = wp_json_encode( array(
        'amount'          => $amount,
        'currency'        => 'INR',
        'receipt'         => $receipt,
        'notes'           => array(
            'user_id'  => $user['id'],
            'user_email' => $user['email'],
            'type'     => $type,
            'ref_id'   => $ref_id,
            'note'     => $note,
        ),
    ));

    $response = wp_remote_post( 'https://api.razorpay.com/v1/orders', array(
        'headers' => array(
            'Content-Type'  => 'application/json',
            'Authorization' => 'Basic ' . base64_encode( FW_RAZORPAY_KEY_ID . ':' . FW_RAZORPAY_KEY_SECRET ),
        ),
        'body'    => $body,
        'timeout' => 15,
    ));

    if ( is_wp_error( $response ) ) {
        return new WP_Error( 'rzp_network', 'Could not reach payment gateway.', array( 'status' => 502 ) );
    }

    $data = json_decode( wp_remote_retrieve_body( $response ), true );
    $code = wp_remote_retrieve_response_code( $response );

    if ( $code !== 200 || empty( $data['id'] ) ) {
        return new WP_Error( 'rzp_error', $data['error']['description'] ?? 'Payment order creation failed.', array( 'status' => 502 ) );
    }

    return rest_ensure_response( array(
        'success'  => true,
        'order_id' => $data['id'],
        'amount'   => $data['amount'],
        'currency' => $data['currency'],
        'receipt'  => $receipt,
    ));
}

function fw_rzp_verify_payment( $req ) {
    /* Auth check */
    $user = fw_validate_token( $req );
    if ( is_wp_error( $user ) ) return $user;

    $p                  = $req->get_json_params() ?: array();
    $razorpay_order_id  = sanitize_text_field( $p['razorpay_order_id']   ?? '' );
    $razorpay_payment_id= sanitize_text_field( $p['razorpay_payment_id'] ?? '' );
    $razorpay_signature = sanitize_text_field( $p['razorpay_signature']  ?? '' );
    $type               = sanitize_text_field( $p['type']    ?? '' );
    $ref_id             = sanitize_text_field( $p['ref_id']  ?? '' );
    $amount             = intval( $p['amount'] ?? 0 );
    $seats              = intval( $p['seats']  ?? 1 );
    $note               = sanitize_text_field( $p['note']    ?? '' );

    if ( ! $razorpay_order_id || ! $razorpay_payment_id || ! $razorpay_signature ) {
        return new WP_Error( 'missing_params', 'Payment verification data incomplete.', array( 'status' => 400 ) );
    }

    /* Verify signature */
    $expected = hash_hmac( 'sha256', $razorpay_order_id . '|' . $razorpay_payment_id, FW_RAZORPAY_KEY_SECRET );
    if ( ! hash_equals( $expected, $razorpay_signature ) ) {
        return new WP_Error( 'sig_mismatch', 'Payment verification failed. Please contact support.', array( 'status' => 400 ) );
    }

    /* Payment verified — record in Supabase */
    if ( $type === 'expedition' ) {
        /* Get expedition title from WP */
        $trip_title = '';
        $trip_dates = '';
        if ( $ref_id ) {
            $post = get_post( intval( $ref_id ) );
            if ( $post ) {
                $trip_title = $post->post_title;
                $trip_dates = get_post_meta( $post->ID, 'fw_dates', true );
            }
        }

        $booking = array(
            'user_id'       => $user['id'],
            'trip_id'       => $ref_id,
            'trip_title'    => $trip_title,
            'trip_dates'    => $trip_dates,
            'seats'         => $seats,
            'amount_total'  => $amount,
            'amount_paid'   => $amount,
            'payment_mode'  => 'razorpay',
            'payment_ref'   => $razorpay_payment_id,
            'status'        => 'confirmed',
            'notes'         => $note,
        );

        $sb_resp = wp_remote_post( FW_SUPABASE_URL . '/rest/v1/fw_bookings', array(
            'headers' => array(
                'apikey'        => FW_SUPABASE_SERVICE,
                'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE,
                'Content-Type'  => 'application/json',
                'Prefer'        => 'return=representation',
            ),
            'body'    => wp_json_encode( $booking ),
            'timeout' => 10,
        ));

        $sb_code = wp_remote_retrieve_response_code( $sb_resp );
        if ( $sb_code !== 201 ) {
            /* Payment succeeded but DB failed — log and alert */
            error_log( 'FW RZP: Booking DB insert failed for payment ' . $razorpay_payment_id );
        }

        /* Send admin notification email */
        $member_name = $user['email'];
        wp_mail(
            get_option('admin_email'),
            'New Booking Confirmed — ' . $trip_title,
            "Payment confirmed via Razorpay.\n\nPayment ID: {$razorpay_payment_id}\nUser: {$member_name}\nTrip: {$trip_title}\nSeats: {$seats}\nAmount: ₹" . number_format($amount/100) . "\n\nLogin to admin panel to view details.",
            array('Content-Type: text/plain; charset=UTF-8')
        );

        return rest_ensure_response( array(
            'success' => true,
            'type'    => 'expedition',
            'message' => 'Booking confirmed! We\'ll send details on WhatsApp.',
        ));
    }

    if ( $type === 'merchandise' ) {
        $product_name = sanitize_text_field( $p['product_name'] ?? '' );
        $size         = sanitize_text_field( $p['size'] ?? '' );

        $order = array(
            'user_id'      => $user['id'],
            'product_id'   => $ref_id,
            'product_name' => $product_name,
            'size'         => $size,
            'amount'       => $amount,
            'payment_mode' => 'razorpay',
            'payment_ref'  => $razorpay_payment_id,
            'status'       => 'paid',
            'notes'        => $note,
        );

        $sb_resp = wp_remote_post( FW_SUPABASE_URL . '/rest/v1/fw_orders', array(
            'headers' => array(
                'apikey'        => FW_SUPABASE_SERVICE,
                'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE,
                'Content-Type'  => 'application/json',
                'Prefer'        => 'return=representation',
            ),
            'body'    => wp_json_encode( $order ),
            'timeout' => 10,
        ));

        $sb_code = wp_remote_retrieve_response_code( $sb_resp );
        if ( $sb_code !== 201 ) {
            error_log( 'FW RZP: Order DB insert failed for payment ' . $razorpay_payment_id );
        }

        /* Admin notification */
        wp_mail(
            get_option('admin_email'),
            'New Merchandise Order — ' . $product_name,
            "Payment confirmed via Razorpay.\n\nPayment ID: {$razorpay_payment_id}\nUser: {$user['email']}\nProduct: {$product_name}\nSize: {$size}\nAmount: ₹" . number_format($amount/100) . "\n\nLogin to admin panel to process.",
            array('Content-Type: text/plain; charset=UTF-8')
        );

        return rest_ensure_response( array(
            'success' => true,
            'type'    => 'merchandise',
            'message' => 'Order placed! We\'ll ship within 3–5 days.',
        ));
    }

    return new WP_Error( 'invalid_type', 'Unknown payment type.', array( 'status' => 400 ) );
}

/* ---- fw_admin_get_members ---- */
function fw_admin_get_members( $request ) {
    if ( ! fw_is_admin( $request ) ) return fw_admin_deny();
    $resp = wp_remote_get(
        FW_SUPABASE_URL . '/rest/v1/fw_members?select=id,email,first_name,last_name,phone,city,state,avatar_url,role,is_suspended,created_at&order=created_at.desc',
        array( 'headers' => array( 'apikey' => FW_SUPABASE_SERVICE, 'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE ), 'timeout' => 15 )
    );
    $members = json_decode( wp_remote_retrieve_body( $resp ), true );
    if ( ! is_array( $members ) ) $members = array();
    return rest_ensure_response( array( 'success' => true, 'members' => $members ) );
}

/* ---- fw_admin_update_member ---- */
function fw_admin_update_member( $request ) {
    if ( ! fw_is_admin( $request ) ) return fw_admin_deny();
    $body    = json_decode( $request->get_body(), true );
    $user_id = sanitize_text_field( $body['user_id'] ?? '' );
    if ( empty( $user_id ) ) return new WP_Error( 'missing', 'user_id required.', array( 'status' => 400 ) );
    $allowed = array( 'role', 'is_suspended' );
    $update  = array( 'updated_at' => date('c') );
    foreach ( $allowed as $f ) {
        if ( isset( $body[$f] ) ) $update[$f] = $body[$f];
    }
    if ( isset( $update['role'] ) ) {
        $valid_roles = array( 'member', 'moderator', 'super_admin' );
        if ( ! in_array( $update['role'], $valid_roles ) ) {
            return new WP_Error( 'invalid_role', 'Invalid role.', array( 'status' => 400 ) );
        }
    }
    $resp = wp_remote_request(
        FW_SUPABASE_URL . '/rest/v1/fw_members?id=eq.' . rawurlencode( $user_id ),
        array( 'method' => 'PATCH', 'headers' => array( 'apikey' => FW_SUPABASE_SERVICE, 'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE, 'Content-Type' => 'application/json', 'Prefer' => 'return=minimal' ), 'body' => wp_json_encode( $update ), 'timeout' => 10 )
    );
    if ( is_wp_error( $resp ) || wp_remote_retrieve_response_code( $resp ) >= 300 ) {
        return new WP_Error( 'update_fail', 'Update failed.', array( 'status' => 500 ) );
    }
    return rest_ensure_response( array( 'success' => true ) );
}

/* ---- fw_count_rows helper ---- */
function fw_count_rows( $url ) {
    $resp = wp_remote_get( $url, array(
        'headers' => array(
            'apikey'        => FW_SUPABASE_SERVICE,
            'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE,
            'Prefer'        => 'count=exact',
            'Range'         => '0-0',
        ),
        'timeout' => 10,
    ));
    $cr = wp_remote_retrieve_header( $resp, 'content-range' );
    if ( preg_match( '/\/(\d+)$/', $cr, $m ) ) return (int) $m[1];
    return 0;
}

/* ---- fw_admin_site_stats ---- */
function fw_admin_site_stats( $request ) {
    if ( ! fw_is_admin( $request ) ) return fw_admin_deny();
    $base = FW_SUPABASE_URL . '/rest/v1/';
    $total_members   = fw_count_rows( $base . 'fw_members?select=id' );
    $blocked_members = fw_count_rows( $base . 'fw_members?select=id&is_suspended=eq.true' );
    $total_bookings  = fw_count_rows( $base . 'fw_bookings?select=id' );
    $total_orders    = fw_count_rows( $base . 'fw_orders?select=id' );
    $published_blogs = fw_count_rows( $base . 'fw_blogs?select=id&status=eq.published' );
    $published_albums= fw_count_rows( $base . 'fw_albums?select=id&status=eq.published' );
    $approved_testis = fw_count_rows( $base . 'fw_testimonials?select=id&status=eq.approved' );
    /* Role distribution */
    $roles_resp = wp_remote_get( $base . 'fw_members?select=role', array( 'headers' => array( 'apikey' => FW_SUPABASE_SERVICE, 'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE ), 'timeout' => 10 ) );
    $roles_raw  = json_decode( wp_remote_retrieve_body( $roles_resp ), true );
    if ( ! is_array( $roles_raw ) ) $roles_raw = array();
    $role_map = array();
    foreach ( $roles_raw as $r ) {
        $role = $r['role'] ?? 'member';
        $role_map[$role] = ( $role_map[$role] ?? 0 ) + 1;
    }
    $roles = array();
    foreach ( $role_map as $role => $cnt ) { $roles[] = array( 'role' => $role, 'count' => $cnt ); }
    /* Merchandise breakdown */
    $orders_resp = wp_remote_get( $base . 'fw_orders?select=items', array( 'headers' => array( 'apikey' => FW_SUPABASE_SERVICE, 'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE ), 'timeout' => 10 ) );
    $orders_raw  = json_decode( wp_remote_retrieve_body( $orders_resp ), true );
    if ( ! is_array( $orders_raw ) ) $orders_raw = array();
    $merch_map = array();
    foreach ( $orders_raw as $order ) {
        $items = $order['items'] ?? array();
        if ( is_string( $items ) ) $items = json_decode( $items, true ) ?: array();
        if ( ! is_array( $items ) ) continue;
        foreach ( $items as $item ) {
            $name = $item['name'] ?? $item['product_name'] ?? 'Unknown';
            $qty  = (int) ( $item['quantity'] ?? $item['qty'] ?? 1 );
            $merch_map[$name] = ( $merch_map[$name] ?? 0 ) + $qty;
        }
    }
    $merchandise = array();
    foreach ( $merch_map as $name => $cnt ) { $merchandise[] = array( 'product_name' => $name, 'count' => $cnt ); }
    usort( $merchandise, function( $a, $b ) { return $b['count'] - $a['count']; } );
    /* Expeditions breakdown */
    $book_resp = wp_remote_get( $base . 'fw_bookings?select=trip_name', array( 'headers' => array( 'apikey' => FW_SUPABASE_SERVICE, 'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE ), 'timeout' => 10 ) );
    $book_raw  = json_decode( wp_remote_retrieve_body( $book_resp ), true );
    if ( ! is_array( $book_raw ) ) $book_raw = array();
    $exp_map = array();
    foreach ( $book_raw as $b ) {
        $name = $b['trip_name'] ?? 'Unknown';
        $exp_map[$name] = ( $exp_map[$name] ?? 0 ) + 1;
    }
    $expeditions = array();
    foreach ( $exp_map as $name => $cnt ) { $expeditions[] = array( 'trip_name' => $name, 'count' => $cnt ); }
    usort( $expeditions, function( $a, $b ) { return $b['count'] - $a['count']; } );
    return rest_ensure_response( array(
        'success' => true,
        'stats'   => array(
            'total_members'         => $total_members,
            'active_members'        => $total_members - $blocked_members,
            'blocked_members'       => $blocked_members,
            'total_bookings'        => $total_bookings,
            'total_orders'          => $total_orders,
            'published_blogs'       => $published_blogs,
            'published_albums'      => $published_albums,
            'approved_testimonials' => $approved_testis,
            'roles'                 => $roles,
            'merchandise'           => $merchandise,
            'expeditions'           => $expeditions,
        ),
    ));
}

