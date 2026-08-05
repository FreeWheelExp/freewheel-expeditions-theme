<?php
/**
 * FreeWheel Expeditions — Remaining subscriber + campaign REST endpoints: manual subscriber add, subscriber list, the main send-campaign endpoint, the public unsubscribe handler, and WhatsApp number export.
 *
 * Split out of fw-includes/community-features.php on 2026-08-05 for maintainability.
 * All REST routes are still registered centrally in functions.php; this file only
 * holds the callback functions / helpers. See git history for the pre-split version
 * if anything needs to be cross-referenced.
 */
if ( ! defined( 'ABSPATH' ) ) exit; // no direct access

/* ══════════════════════════════════════════════════════════════════════
   REST ENDPOINTS
   ══════════════════════════════════════════════════════════════════════ */

/* ── POST /admin/subscriber-add — admin/moderator manual subscriber entry ── */
function fw_admin_add_subscriber( $request ) {
    $user = fw_admin_auth( $request );
    if ( is_wp_error( $user ) ) return $user;

    $p      = $request->get_json_params() ?: array();
    $email  = isset( $p['email'] )  ? sanitize_email( $p['email'] )              : '';
    $mobile = isset( $p['mobile'] ) ? sanitize_text_field( $p['mobile'] )        : '';
    $name   = isset( $p['name'] )   ? sanitize_text_field( $p['name'] )          : '';
    $city   = isset( $p['city'] )   ? sanitize_text_field( $p['city'] )          : '';

    $source_label = in_array( $user['role'], array( 'super_admin', 'admin' ), true ) ? 'admin_manual' : 'moderator_manual';
    $result = fw_insert_manual_subscriber( $email, $mobile, $name, $city, $source_label );

    if ( is_wp_error( $result ) ) return $result;
    if ( ! $result['success'] ) return rest_ensure_response( $result );

    fw_log_admin_action( $user['id'], 'subscriber_add', null, 'Added subscriber: ' . ( $email ?: $mobile ) );
    return rest_ensure_response( $result );
}

/* ── Shared helper: insert/reactivate a manually-entered subscriber ──
   Used by both the frontend REST endpoint (fw_admin_add_subscriber) and
   the WP Admin AJAX handler, so the dedup/reactivation logic lives in one place. */
function fw_insert_manual_subscriber( $email, $mobile, $name, $city, $source_label ) {
    if ( ! $email && ! $mobile ) {
        return new WP_Error( 'missing', 'Email or mobile number is required.', array( 'status' => 400 ) );
    }
    if ( $email && ! is_email( $email ) ) {
        return new WP_Error( 'invalid_email', 'Invalid email address.', array( 'status' => 400 ) );
    }

    $h_svc = array( 'apikey' => FW_SUPABASE_SERVICE, 'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE );

    // Check duplicates — email collision
    if ( $email ) {
        $chk = json_decode( wp_remote_retrieve_body( wp_remote_get(
            FW_SUPABASE_URL . '/rest/v1/fw_subscribers?email=eq.' . rawurlencode( strtolower( $email ) ) . '&select=id,is_subscribed',
            array( 'headers' => $h_svc, 'timeout' => 8 )
        )), true );
        if ( ! empty( $chk[0]['id'] ) ) {
            if ( empty( $chk[0]['is_subscribed'] ) ) {
                wp_remote_request( FW_SUPABASE_URL . '/rest/v1/fw_subscribers?id=eq.' . rawurlencode( $chk[0]['id'] ), array(
                    'method'      => 'PATCH',
                    'headers'     => array_merge( $h_svc, array( 'Content-Type' => 'application/json', 'Prefer' => 'return=minimal' ) ),
                    'body'        => wp_json_encode( array( 'is_subscribed' => true ) ),
                    'timeout'     => 8,
                    'data_format' => 'body',
                ));
                return array( 'success' => true, 'message' => 'Previously unsubscribed — reactivated.' );
            }
            return array( 'success' => false, 'message' => 'This email is already in the subscriber list.' );
        }
    }

    // Check duplicates — mobile collision
    if ( $mobile ) {
        $chk_m = json_decode( wp_remote_retrieve_body( wp_remote_get(
            FW_SUPABASE_URL . '/rest/v1/fw_subscribers?mobile=eq.' . rawurlencode( $mobile ) . '&select=id',
            array( 'headers' => $h_svc, 'timeout' => 8 )
        )), true );
        if ( ! empty( $chk_m[0]['id'] ) ) {
            return array( 'success' => false, 'message' => 'This WhatsApp number is already in the subscriber list.' );
        }
    }

    $token = bin2hex( random_bytes( 32 ) );
    $row = array(
        'email'             => $email ? strtolower( $email ) : null,
        'mobile'            => $mobile ?: null,
        'name'              => $name ?: null,
        'city'              => $city ?: null,
        'is_subscribed'     => true,
        'source'            => $source_label,
        'unsubscribe_token' => $token,
        'email_verified'    => (bool) $email,
    );

    $insert = wp_remote_post( FW_SUPABASE_URL . '/rest/v1/fw_subscribers', array(
        'headers'     => array_merge( $h_svc, array( 'Content-Type' => 'application/json', 'Prefer' => 'return=minimal' ) ),
        'body'        => wp_json_encode( $row ),
        'timeout'     => 10,
        'data_format' => 'body',
    ));

    if ( is_wp_error( $insert ) || wp_remote_retrieve_response_code( $insert ) >= 300 ) {
        error_log( '[FW] fw_insert_manual_subscriber failed: ' . wp_remote_retrieve_body( $insert ) );
        return new WP_Error( 'db_fail', 'Failed to add subscriber.', array( 'status' => 500 ) );
    }

    return array( 'success' => true, 'message' => 'Subscriber added successfully.' );
}

/* ── GET /admin/subscribers — list all subscribers ── */
function fw_admin_get_subscribers( $request ) {
    $user = fw_admin_auth( $request );
    if ( is_wp_error( $user ) ) return $user;

    $resp = wp_remote_get(
        FW_SUPABASE_URL . '/rest/v1/fw_subscribers?order=created_at.desc&select=id,name,email,mobile,city,is_subscribed,source,email_verified,created_at',
        array(
            'headers' => array( 'apikey' => FW_SUPABASE_SERVICE, 'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE ),
            'timeout' => 15,
        )
    );
    $rows = json_decode( wp_remote_retrieve_body( $resp ), true ) ?: array();
    return rest_ensure_response( array( 'success' => true, 'subscribers' => $rows, 'total' => count( $rows ) ) );
}

/* ── POST /admin/send-campaign — send bulk email + log it ── */
function fw_admin_send_campaign( $request ) {
    $user = fw_admin_auth( $request );
    if ( is_wp_error( $user ) ) return $user;

    $p               = $request->get_json_params() ?: array();
    $subject         = sanitize_text_field( $p['subject']          ?? '' );
    $body_text       = sanitize_textarea_field( $p['body']         ?? '' );
    $expedition_ids  = array_map( 'intval', (array) ( $p['expedition_ids'] ?? array() ) );

    if ( ! $subject || ! $body_text ) {
        return new WP_Error( 'missing', 'Subject and body are required.', array( 'status' => 400 ) );
    }

    // Resolve expedition titles from WP post IDs
    $expedition_titles = array();
    foreach ( $expedition_ids as $pid ) {
        $post = get_post( $pid );
        if ( $post ) $expedition_titles[] = get_the_title( $post );
    }

    $h_svc = array( 'apikey' => FW_SUPABASE_SERVICE, 'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE );

    // Fetch all active email subscribers
    $resp = wp_remote_get(
        FW_SUPABASE_URL . '/rest/v1/fw_subscribers?is_subscribed=eq.true&email=not.is.null&email_verified=eq.true&select=email,name,unsubscribe_token',
        array( 'headers' => $h_svc, 'timeout' => 15 )
    );
    $subscribers = json_decode( wp_remote_retrieve_body( $resp ), true ) ?: array();

    if ( empty( $subscribers ) ) {
        return rest_ensure_response( array( 'success' => false, 'message' => 'No active email subscribers to send to.' ) );
    }

    $sent  = 0;
    $fails = 0;
    $site_url = trailingslashit( get_site_url() );

    foreach ( $subscribers as $sub ) {
        $unsub_url = $site_url . 'wp-json/freewheel/v1/unsubscribe?token=' . rawurlencode( $sub['unsubscribe_token'] );
        $html      = fw_build_campaign_html( $body_text, $expedition_titles, $unsub_url );
        $ok        = fw_send_campaign_email( $sub['email'], $sub['name'] ?? '', $subject, $html );
        $ok ? $sent++ : $fails++;
    }

    // Log to fw_notification_log
    wp_remote_post( FW_SUPABASE_URL . '/rest/v1/fw_notification_log', array(
        'headers'     => array_merge( $h_svc, array( 'Content-Type' => 'application/json', 'Prefer' => 'return=minimal' ) ),
        'body'        => wp_json_encode( array(
            'expedition_ids'  => implode( ',', $expedition_ids ),
            'subject'         => $subject,
            'body_html'       => $body_text,
            'recipient_count' => $sent,
            'sent_by'         => $user['email'],
        )),
        'timeout'     => 10,
        'data_format' => 'body',
    ));

    fw_log_admin_action( $user['id'], 'campaign_sent', null, 'Campaign "' . $subject . '" sent to ' . $sent . ' subscribers.' );

    return rest_ensure_response( array(
        'success'  => true,
        'sent'     => $sent,
        'failed'   => $fails,
        'message'  => 'Campaign sent to ' . $sent . ' subscriber' . ( $sent !== 1 ? 's' : '' ) . '.' . ( $fails ? ' ' . $fails . ' failed.' : '' ),
    ));
}

/* ── GET /unsubscribe?token=xxx — public no-auth unsubscribe link ── */
function fw_handle_unsubscribe( $request ) {
    $token = sanitize_text_field( $request->get_param( 'token' ) );

    if ( ! $token ) {
        return new WP_Error( 'missing_token', 'Invalid unsubscribe link.', array( 'status' => 400 ) );
    }

    $h_svc = array( 'apikey' => FW_SUPABASE_SERVICE, 'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE );

    $check = json_decode( wp_remote_retrieve_body( wp_remote_get(
        FW_SUPABASE_URL . '/rest/v1/fw_subscribers?unsubscribe_token=eq.' . rawurlencode( $token ) . '&select=id,is_subscribed',
        array( 'headers' => $h_svc, 'timeout' => 8 )
    )), true );

    if ( empty( $check[0]['id'] ) ) {
        return new WP_Error( 'not_found', 'Unsubscribe link is invalid or already used.', array( 'status' => 404 ) );
    }

    if ( empty( $check[0]['is_subscribed'] ) ) {
        // Already unsubscribed — no-op, but show success to avoid leaking state
        return rest_ensure_response( array( 'success' => true, 'message' => 'You are already unsubscribed.' ) );
    }

    wp_remote_request( FW_SUPABASE_URL . '/rest/v1/fw_subscribers?id=eq.' . rawurlencode( $check[0]['id'] ), array(
        'method'      => 'PATCH',
        'headers'     => array_merge( $h_svc, array( 'Content-Type' => 'application/json', 'Prefer' => 'return=minimal' ) ),
        'body'        => wp_json_encode( array( 'is_subscribed' => false ) ),
        'timeout'     => 10,
        'data_format' => 'body',
    ));

    // Redirect to a friendly confirmation page rather than returning raw JSON
    wp_redirect( home_url( '/?fw_unsub=1' ) );
    exit;
}

/* ── GET /admin/whatsapp-export — copy/export mobile numbers ── */
function fw_admin_whatsapp_export( $request ) {
    $user = fw_admin_auth( $request );
    if ( is_wp_error( $user ) ) return $user;

    $resp = wp_remote_get(
        FW_SUPABASE_URL . '/rest/v1/fw_subscribers?is_subscribed=eq.true&mobile=not.is.null&select=name,mobile',
        array( 'headers' => array( 'apikey' => FW_SUPABASE_SERVICE, 'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE ), 'timeout' => 10 )
    );
    $rows    = json_decode( wp_remote_retrieve_body( $resp ), true ) ?: array();
    $numbers = array_column( $rows, 'mobile' );

    return rest_ensure_response( array(
        'success' => true,
        'count'   => count( $numbers ),
        'numbers' => $numbers,
        'csv'     => implode( "\n", $numbers ), // paste-ready for WhatsApp broadcast
    ));
}
