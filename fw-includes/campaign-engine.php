<?php
/**
 * FreeWheel Expeditions — Campaign/subscriber engine: subscriber auto-upsert, Brevo send helper, test-campaign send, campaign HTML builder, trip-card data builder, audience resolver, and the campaign-picker/audience/upload/batch/log REST endpoints the composer UI calls.
 *
 * Split out of fw-includes/community-features.php on 2026-08-05 for maintainability.
 * All REST routes are still registered centrally in functions.php; this file only
 * holds the callback functions / helpers. See git history for the pre-split version
 * if anything needs to be cross-referenced.
 */
if ( ! defined( 'ABSPATH' ) ) exit; // no direct access

/* ══════════════════════════════════════════════════════════════════════
   SUBSCRIBER / CAMPAIGN NOTIFICATION SYSTEM
   ══════════════════════════════════════════════════════════════════════ */

/* ── Helper: upsert a subscriber row (called from fw_register_member + manual add) ── */
function fw_subscriber_auto_upsert( $email, $mobile = '', $source = 'registration_auto', $consent_text = 'Auto-subscribed at registration' ) {
    if ( ! $email ) return false;

    $h_svc = array(
        'apikey'        => FW_SUPABASE_SERVICE,
        'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE,
        'Content-Type'  => 'application/json',
        'Prefer'        => 'resolution=ignore-duplicates,return=minimal', // safe upsert — skip if email already exists
    );

    // Check if already subscribed (to avoid overwriting real consent with weaker auto-consent)
    $check = wp_remote_get(
        FW_SUPABASE_URL . '/rest/v1/fw_subscribers?email=eq.' . rawurlencode( strtolower( $email ) ) . '&select=id,source',
        array( 'headers' => array( 'apikey' => FW_SUPABASE_SERVICE, 'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE ), 'timeout' => 8 )
    );
    $existing = json_decode( wp_remote_retrieve_body( $check ), true );

    if ( ! empty( $existing[0]['id'] ) ) {
        // Already exists — ensure is_subscribed is true (they may have previously unsubscribed and re-registered)
        // but do NOT overwrite a real consent source (public_form) with a weaker one (registration_auto)
        $existing_source = $existing[0]['source'] ?? 'registration_auto';
        $patch_data = array( 'is_subscribed' => true );
        if ( $existing_source === 'registration_auto' || $existing_source === 'admin_manual' ) {
            $patch_data['source'] = $source;
        }
        wp_remote_request( FW_SUPABASE_URL . '/rest/v1/fw_subscribers?id=eq.' . rawurlencode( $existing[0]['id'] ), array(
            'method'      => 'PATCH',
            'headers'     => array( 'apikey' => FW_SUPABASE_SERVICE, 'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE, 'Content-Type' => 'application/json', 'Prefer' => 'return=minimal' ),
            'body'        => wp_json_encode( $patch_data ),
            'timeout'     => 8,
            'data_format' => 'body',
        ));
        return true;
    }

    $token = bin2hex( random_bytes( 32 ) );
    $row   = array(
        'email'             => strtolower( $email ),
        'mobile'            => $mobile ?: null,
        'is_subscribed'     => true,
        'source'            => $source,
        'unsubscribe_token' => $token,
        'email_verified'    => true, // registration already OTP-verified
    );

    wp_remote_post( FW_SUPABASE_URL . '/rest/v1/fw_subscribers', array(
        'headers'     => $h_svc,
        'body'        => wp_json_encode( $row ),
        'timeout'     => 10,
        'data_format' => 'body',
    ));
    return true;
}

/* ── Helper: generic Brevo campaign email send ── */
function fw_send_campaign_email( $email, $name, $subject, $html_body ) {
    $brevo_api_key = defined( 'FW_BREVO_API_KEY' ) ? FW_BREVO_API_KEY : '';
    if ( ! $brevo_api_key ) {
        error_log( '[FW] fw_send_campaign_email skipped: FW_BREVO_API_KEY not defined.' );
        return false;
    }
    $resp = wp_remote_post( 'https://api.brevo.com/v3/smtp/email', array(
        'headers' => array(
            'api-key'      => $brevo_api_key,
            'Content-Type' => 'application/json',
            'Accept'       => 'application/json',
        ),
        'body' => wp_json_encode( array(
            'sender'      => array( 'name' => 'FreeWheel Expeditions', 'email' => 'hello@freewheelexpeditions.in' ),
            'to'          => array( array( 'email' => $email, 'name' => $name ?: 'Explorer' ) ),
            'subject'     => $subject,
            'htmlContent' => $html_body,
        )),
        'timeout'     => 15,
        'data_format' => 'body',
    ));
    if ( is_wp_error( $resp ) ) {
        error_log( '[FW] Brevo campaign send failed for ' . $email . ': ' . $resp->get_error_message() );
        return false;
    }
    return true;
}

/* ── POST /admin/send-test-campaign — sends the exact HTML a real send would produce,
   to one address only, for checking format/UI before blasting the real subscriber list.
   Deliberately does NOT write to fw_notification_log — this isn't a real campaign. ── */
function fw_admin_send_test_campaign( $request ) {
    $user = fw_admin_auth( $request );
    if ( is_wp_error( $user ) ) return $user;

    $p          = $request->get_json_params() ?: array();
    $test_email = sanitize_email( $p['test_email'] ?? '' );
    $subject    = sanitize_text_field( $p['subject'] ?? '' );
    $body_text  = sanitize_textarea_field( $p['body'] ?? '' );
    $exp_ids    = array_map( 'intval', (array) ( $p['expedition_ids'] ?? array() ) );
    $trip_meta  = is_array( $p['trip_meta'] ?? null ) ? $p['trip_meta'] : array();

    if ( ! is_email( $test_email ) ) return new WP_Error( 'bad_email', 'Enter a valid email address to send the test to.', array( 'status' => 400 ) );
    if ( ! $subject || ! $body_text )  return new WP_Error( 'missing', 'Subject and body are required.', array( 'status' => 400 ) );

    $trip_cards = array();
    foreach ( $exp_ids as $pid ) {
        $meta   = $trip_meta[ (string) $pid ] ?? array();
        $blurb  = sanitize_textarea_field( $meta['blurb'] ?? '' );
        $badges = array_map( 'sanitize_text_field', (array) ( $meta['badges'] ?? array() ) );
        $card   = fw_build_trip_card_data( $pid, $blurb, $badges );
        if ( $card ) $trip_cards[] = $card;
    }

    $assets = array(
        'image_url' => esc_url_raw( $p['image_url'] ?? '' ),
        'pdf_url'   => esc_url_raw( $p['pdf_url'] ?? '' ),
        'pdf_label' => sanitize_text_field( $p['pdf_label'] ?? '' ),
        'cta_url'   => esc_url_raw( $p['cta_url'] ?? '' ),
        'cta_label' => sanitize_text_field( $p['cta_label'] ?? '' ),
    );

    $html = fw_build_campaign_html( $body_text, $trip_cards, '#', $assets );
    $sent = fw_send_campaign_email( $test_email, 'Test', '[TEST] ' . $subject, $html );

    if ( ! $sent ) return new WP_Error( 'send_fail', 'Could not send test email. Check the Brevo API key is configured.', array( 'status' => 500 ) );
    return rest_ensure_response( array( 'success' => true ) );
}

/* ── Helper: build campaign HTML email body ──
   $trip_cards: array of structured expedition data (see fw_build_trip_card_data()) — each
   renders as its own visually distinct card, not a flat bullet list.
   $assets: optional array with keys image_url, pdf_url, pdf_label, cta_url, cta_label */
function fw_build_campaign_html( $body_text, $trip_cards, $unsubscribe_url, $assets = array() ) {
    $cards_html = '';
    foreach ( (array) $trip_cards as $card ) {
        $badges_html = '';
        foreach ( (array) ( $card['badges'] ?? array() ) as $badge ) {
            $badge = trim( (string) $badge );
            if ( $badge === '' ) continue;
            $badges_html .= '<span style="display:inline-block;background:rgba(232,160,32,.15);border:1px solid rgba(232,160,32,.4);color:#e8a020;font-size:11px;font-weight:bold;letter-spacing:.4px;text-transform:uppercase;padding:4px 10px;border-radius:20px;margin:0 6px 6px 0">' . esc_html( $badge ) . '</span>';
        }

        $price_rows = '';
        $tiers = array(
            'Self Drive'       => $card['price'] ?? '',
            'Couple Discount'  => $card['couple_price'] ?? '',
            'Seat Sharing'     => $card['seat_price'] ?? '',
        );
        foreach ( $tiers as $label => $amount ) {
            if ( $amount === '' || $amount === null ) continue;
            $unit = ! empty( $card['price_unit'] ) ? esc_html( $card['price_unit'] ) : 'per person';
            $price_rows .= '<tr>
                <td style="padding:6px 0;color:rgba(255,255,255,.7);font-size:13px">' . esc_html( $label ) . '</td>
                <td style="padding:6px 0;text-align:right;color:#fff;font-size:14px;font-weight:bold">₹' . esc_html( number_format_i18n( (float) $amount ) ) . ' <span style="color:rgba(255,255,255,.4);font-weight:normal;font-size:12px">' . $unit . '</span></td>
            </tr>';
        }
        $price_block = $price_rows
            ? '<div style="background:rgba(0,0,0,.25);border-radius:10px;padding:12px 16px;margin:0 0 18px"><table style="width:100%;border-collapse:collapse">' . $price_rows . '</table></div>'
            : '';

        $blurb_html = ! empty( $card['blurb'] )
            ? '<p style="color:rgba(255,255,255,.65);font-size:14px;line-height:1.6;margin:0 0 16px">' . esc_html( $card['blurb'] ) . '</p>'
            : '';

        $dates_html = ! empty( $card['dates'] )
            ? '<p style="color:#e8a020;font-size:13px;font-weight:600;margin:0 0 14px;letter-spacing:.3px">' . esc_html( $card['dates'] ) . '</p>'
            : '';

        $link = ! empty( $card['permalink'] ) ? esc_url( $card['permalink'] ) : 'https://freewheelexpeditions.in';

        $cards_html .= '
        <div style="background:rgba(232,160,32,.06);border:1px solid rgba(232,160,32,.3);border-radius:14px;padding:22px;margin:0 0 18px">
            <div style="margin:0 0 12px">' . $badges_html . '</div>
            <h3 style="color:#fff;font-size:19px;margin:0 0 4px;line-height:1.3">' . esc_html( $card['title'] ?? '' ) . '</h3>
            ' . $dates_html . '
            ' . $blurb_html . '
            ' . $price_block . '
            <a href="' . $link . '" style="display:block;text-align:center;background:#e8a020;color:#0f0d0b;padding:12px;border-radius:8px;text-decoration:none;font-weight:bold;font-size:14px">View Route &amp; Book →</a>
        </div>';
    }

    $safe_body = nl2br( esc_html( $body_text ) );

    $image_block = '';
    if ( ! empty( $assets['image_url'] ) ) {
        $image_block = '<img src="' . esc_url( $assets['image_url'] ) . '" alt="" style="max-width:100%;border-radius:10px;display:block;margin:0 0 20px">';
    }

    $pdf_block = '';
    if ( ! empty( $assets['pdf_url'] ) ) {
        $pdf_label = ! empty( $assets['pdf_label'] ) ? sanitize_text_field( $assets['pdf_label'] ) : 'Download PDF';
        $pdf_block = '<div style="text-align:center;margin:20px 0"><a href="' . esc_url( $assets['pdf_url'] ) . '" style="background:rgba(232,160,32,.12);border:1px solid #e8a020;color:#e8a020;padding:10px 22px;border-radius:8px;text-decoration:none;font-weight:bold;font-size:14px;display:inline-block">📄 ' . esc_html( $pdf_label ) . '</a></div>';
    }

    // Secondary CTA: use admin-provided URL/label if given, otherwise default to the expeditions page
    $cta_url   = ! empty( $assets['cta_url'] )   ? esc_url( $assets['cta_url'] )                     : 'https://freewheelexpeditions.in';
    $cta_label = ! empty( $assets['cta_label'] ) ? esc_html( sanitize_text_field( $assets['cta_label'] ) ) : 'View All Expeditions →';

    return '
<div style="font-family:Arial,sans-serif;background:#0f0d0b;padding:40px 20px;color:#fff;max-width:600px;margin:0 auto">
  <div style="text-align:center;margin-bottom:30px">
    <h2 style="color:#e8a020;margin:0 0 8px">FreeWheel Expeditions 🏔️</h2>
    <p style="color:rgba(255,255,255,.4);font-size:13px;margin:0">The JUNGLI Convoy</p>
  </div>
  <div style="background:rgba(255,255,255,.05);border-radius:12px;padding:28px;margin-bottom:24px">
    ' . $image_block . '
    <p style="color:rgba(255,255,255,.85);font-size:15px;line-height:1.8;margin:0 0 20px">' . $safe_body . '</p>
    ' . $cards_html . '
    ' . $pdf_block . '
  </div>
  <div style="text-align:center;margin-top:30px">
    <a href="' . $cta_url . '" style="background:#e8a020;color:#0f0d0b;padding:12px 28px;border-radius:8px;text-decoration:none;font-weight:bold;font-size:15px">' . $cta_label . '</a>
  </div>
  <p style="text-align:center;margin-top:30px;color:rgba(255,255,255,.25);font-size:11px">
    You\'re receiving this because you subscribed to FreeWheel Expeditions updates.<br>
    <a href="' . esc_url( $unsubscribe_url ) . '" style="color:rgba(255,255,255,.35)">Unsubscribe</a>
  </p>
</div>';
}

/* ── Helper: pull one expedition's real postmeta into the shape fw_build_campaign_html() expects ── */
function fw_build_trip_card_data( $post_id, $custom_blurb = '', $extra_badges = array() ) {
    $post = get_post( $post_id );
    if ( ! $post || $post->post_type !== 'fw_expedition' ) return null;

    $m = function( $k ) use ( $post_id ) { return get_post_meta( $post_id, $k, true ); };
    $badges = array( 'Self Drive' );
    if ( $m( 'fw_max_slots' ) ) $badges[] = $m( 'fw_max_slots' ) . ' Vehicle Slots';
    foreach ( (array) $extra_badges as $b ) { if ( trim( (string) $b ) !== '' ) $badges[] = trim( (string) $b ); }

    return array(
        'id'           => $post_id,
        'title'        => get_the_title( $post_id ),
        'dates'        => $m( 'fw_dates' ),
        'destination'  => $m( 'fw_destination' ),
        'price'        => $m( 'fw_price' ),
        'couple_price' => $m( 'fw_couple_price' ),
        'seat_price'   => $m( 'fw_seat_price' ),
        'price_unit'   => $m( 'fw_price_unit' ) ?: 'per person',
        'permalink'    => get_permalink( $post_id ),
        'blurb'        => $custom_blurb,
        'badges'       => $badges,
    );
}

/* ── Helper: resolve deduped campaign audience — fw_subscribers ∪ fw_members ──
   Members without a subscriber row are auto-upserted so every recipient has an
   unsubscribe_token (compliance requirement — every campaign email must be able
   to opt out, regardless of which table they originated from). */
function fw_get_campaign_audience() {
    $h_svc = array( 'apikey' => FW_SUPABASE_SERVICE, 'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE );

    // Members with an email, not suspended
    $mem_resp = wp_remote_get(
        FW_SUPABASE_URL . '/rest/v1/fw_members?email=not.is.null&select=email,first_name,is_suspended',
        array( 'headers' => $h_svc, 'timeout' => 15 )
    );
    $members = json_decode( wp_remote_retrieve_body( $mem_resp ), true ) ?: array();

    // Existing subscriber emails (so we don't needlessly re-upsert)
    $sub_resp = wp_remote_get(
        FW_SUPABASE_URL . '/rest/v1/fw_subscribers?select=email',
        array( 'headers' => $h_svc, 'timeout' => 15 )
    );
    $existing_sub_emails = array_map( 'strtolower', array_filter( array_column(
        json_decode( wp_remote_retrieve_body( $sub_resp ), true ) ?: array(), 'email'
    )));
    $existing_sub_emails = array_flip( $existing_sub_emails );

    // Auto-create a subscriber row (with token) for any active member not already tracked
    foreach ( $members as $m ) {
        if ( empty( $m['email'] ) || ! empty( $m['is_suspended'] ) ) continue;
        $email_lc = strtolower( $m['email'] );
        if ( isset( $existing_sub_emails[ $email_lc ] ) ) continue;
        fw_subscriber_auto_upsert( $m['email'], '', 'member_campaign_merge', 'Registered member — auto-included in campaign audience' );
    }

    // Final merged, deduped, active list
    $final_resp = wp_remote_get(
        FW_SUPABASE_URL . '/rest/v1/fw_subscribers?is_subscribed=eq.true&email=not.is.null&select=email,name,unsubscribe_token',
        array( 'headers' => $h_svc, 'timeout' => 15 )
    );
    $rows = json_decode( wp_remote_retrieve_body( $final_resp ), true ) ?: array();

    $seen = array();
    $out  = array();
    foreach ( $rows as $r ) {
        if ( empty( $r['email'] ) ) continue;
        $key = strtolower( trim( $r['email'] ) );
        if ( isset( $seen[ $key ] ) ) continue;
        $seen[ $key ] = true;
        $out[] = array( 'email' => $r['email'], 'name' => $r['name'] ?? '', 'unsubscribe_token' => $r['unsubscribe_token'] ?? '' );
    }
    return $out;
}

/* ── GET /admin/campaign-expeditions — simple list for the campaign composer picker ── */
function fw_admin_campaign_expeditions( $request ) {
    $user = fw_admin_auth( $request );
    if ( is_wp_error( $user ) ) return $user;

    $posts = get_posts( array( 'post_type' => 'fw_expedition', 'post_status' => 'publish', 'posts_per_page' => -1, 'orderby' => 'date', 'order' => 'DESC' ) );
    $out = array();
    foreach ( $posts as $p ) {
        $out[] = array( 'id' => $p->ID, 'title' => get_the_title( $p ) );
    }
    return rest_ensure_response( array( 'success' => true, 'expeditions' => $out ) );
}

/* ── GET /admin/campaign-trip-picker — richer picker for the trip-card composer, returns
   real pricing/dates/destination per expedition so cards render from source data, not
   retyped numbers. New route name deliberately, sidesteps whatever was caching or
   breaking /admin/campaign-expeditions rather than chasing an unreproducible bug. ── */
function fw_admin_campaign_trip_picker( $request ) {
    $user = fw_admin_auth( $request );
    if ( is_wp_error( $user ) ) return $user;

    $posts = get_posts( array( 'post_type' => 'fw_expedition', 'post_status' => 'publish', 'posts_per_page' => -1, 'orderby' => 'date', 'order' => 'DESC' ) );
    $out = array();
    foreach ( $posts as $p ) {
        $card = fw_build_trip_card_data( $p->ID );
        if ( $card ) $out[] = $card;
    }
    return rest_ensure_response( array( 'success' => true, 'expeditions' => $out ) );
}

/* ── GET /admin/campaign-audience — resolve + return recipient count/list ── */
function fw_admin_campaign_audience( $request ) {
    $user = fw_admin_auth( $request );
    if ( is_wp_error( $user ) ) return $user;

    $audience = fw_get_campaign_audience();
    return rest_ensure_response( array( 'success' => true, 'count' => count( $audience ), 'audience' => $audience ) );
}

/* ── POST /admin/campaign-upload — generic asset upload (image or PDF) to WP Media Library ── */
function fw_admin_campaign_upload( $request ) {
    $user = fw_admin_auth( $request );
    if ( is_wp_error( $user ) ) return $user;

    if ( empty( $_FILES['file'] ) || $_FILES['file']['error'] !== UPLOAD_ERR_OK ) {
        return new WP_Error( 'no_file', 'No file uploaded.', array( 'status' => 400 ) );
    }

    $allowed = array( 'image/jpeg', 'image/png', 'image/webp', 'image/gif', 'application/pdf' );
    $type    = $_FILES['file']['type'];
    if ( ! in_array( $type, $allowed, true ) ) {
        return new WP_Error( 'bad_type', 'Only JPG, PNG, WEBP, GIF, or PDF files are allowed.', array( 'status' => 400 ) );
    }
    // 10MB cap — plenty for a campaign image/flyer, keeps Brevo delivery snappy since we link rather than attach
    if ( $_FILES['file']['size'] > 10 * 1024 * 1024 ) {
        return new WP_Error( 'too_large', 'File must be under 10MB.', array( 'status' => 400 ) );
    }

    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/media.php';
    require_once ABSPATH . 'wp-admin/includes/image.php';

    $attachment_id = media_handle_upload( 'file', 0 );
    if ( is_wp_error( $attachment_id ) ) {
        error_log( '[FW] Campaign asset upload failed: ' . $attachment_id->get_error_message() );
        return new WP_Error( 'upload_fail', 'Upload failed.', array( 'status' => 500 ) );
    }

    fw_log_admin_action( $user['id'], 'campaign_asset_upload', 'attachment', $attachment_id, basename( get_attached_file( $attachment_id ) ) );

    return rest_ensure_response( array( 'success' => true, 'url' => wp_get_attachment_url( $attachment_id ) ) );
}

/* ── POST /admin/send-campaign-batch — send ONE small batch (avoids PHP timeout on shared hosting) ──
   Frontend calls this repeatedly with slices of the resolved audience until done. */
function fw_admin_send_campaign_batch( $request ) {
    $user = fw_admin_auth( $request );
    if ( is_wp_error( $user ) ) return $user;

    $p         = $request->get_json_params() ?: array();
    $emails    = is_array( $p['emails'] ?? null ) ? $p['emails'] : array();
    $subject   = sanitize_text_field( $p['subject'] ?? '' );
    $body_text = sanitize_textarea_field( $p['body'] ?? '' );
    $exp_ids   = array_map( 'intval', (array) ( $p['expedition_ids'] ?? array() ) );
    $trip_meta = is_array( $p['trip_meta'] ?? null ) ? $p['trip_meta'] : array(); // { "123": {blurb, badges: []} }

    if ( ! $subject || ! $body_text || empty( $emails ) ) {
        return new WP_Error( 'missing', 'Subject, body, and at least one recipient are required.', array( 'status' => 400 ) );
    }
    if ( count( $emails ) > 25 ) {
        return new WP_Error( 'batch_too_large', 'Max 25 recipients per batch call.', array( 'status' => 400 ) );
    }

    $trip_cards = array();
    foreach ( $exp_ids as $pid ) {
        $meta   = $trip_meta[ (string) $pid ] ?? array();
        $blurb  = sanitize_textarea_field( $meta['blurb'] ?? '' );
        $badges = array_map( 'sanitize_text_field', (array) ( $meta['badges'] ?? array() ) );
        $card   = fw_build_trip_card_data( $pid, $blurb, $badges );
        if ( $card ) $trip_cards[] = $card;
    }

    $assets = array(
        'image_url' => esc_url_raw( $p['image_url'] ?? '' ),
        'pdf_url'   => esc_url_raw( $p['pdf_url']   ?? '' ),
        'pdf_label' => sanitize_text_field( $p['pdf_label'] ?? '' ),
        'cta_url'   => esc_url_raw( $p['cta_url']   ?? '' ),
        'cta_label' => sanitize_text_field( $p['cta_label'] ?? '' ),
    );

    $site_url = trailingslashit( get_site_url() );
    $sent = 0; $failed = 0;

    foreach ( $emails as $recipient ) {
        $email = sanitize_email( $recipient['email'] ?? '' );
        if ( ! $email ) { $failed++; continue; }
        $name  = sanitize_text_field( $recipient['name'] ?? '' );
        $token = sanitize_text_field( $recipient['unsubscribe_token'] ?? '' );
        $unsub_url = $site_url . 'wp-json/freewheel/v1/unsubscribe?token=' . rawurlencode( $token );
        $html = fw_build_campaign_html( $body_text, $trip_cards, $unsub_url, $assets );
        $ok   = fw_send_campaign_email( $email, $name, $subject, $html );
        $ok ? $sent++ : $failed++;
    }

    return rest_ensure_response( array( 'success' => true, 'sent' => $sent, 'failed' => $failed ) );
}

/* ── POST /admin/log-campaign — record a completed campaign run (called once, after all batches finish) ── */
function fw_admin_log_campaign( $request ) {
    $user = fw_admin_auth( $request );
    if ( is_wp_error( $user ) ) return $user;

    $p       = $request->get_json_params() ?: array();
    $subject = sanitize_text_field( $p['subject'] ?? '' );
    $body    = sanitize_textarea_field( $p['body'] ?? '' );
    $sent    = intval( $p['sent'] ?? 0 );
    $failed  = intval( $p['failed'] ?? 0 );
    $exp_ids = array_map( 'intval', (array) ( $p['expedition_ids'] ?? array() ) );

    $h_svc = array( 'apikey' => FW_SUPABASE_SERVICE, 'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE );
    wp_remote_post( FW_SUPABASE_URL . '/rest/v1/fw_notification_log', array(
        'headers'     => array_merge( $h_svc, array( 'Content-Type' => 'application/json', 'Prefer' => 'return=minimal' ) ),
        'body'        => wp_json_encode( array(
            'expedition_ids'  => implode( ',', $exp_ids ),
            'subject'         => $subject,
            'body_html'       => $body,
            'recipient_count' => $sent,
            'sent_by'         => $user['email'],
        )),
        'timeout' => 10, 'data_format' => 'body',
    ));

    fw_log_admin_action( $user['id'], 'campaign_sent', null, 'Campaign "' . $subject . '" — sent ' . $sent . ', failed ' . $failed . '.' );
    return rest_ensure_response( array( 'success' => true ) );
}

