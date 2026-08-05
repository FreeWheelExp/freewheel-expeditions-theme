<?php
/**
 * FreeWheel Expeditions — Referral bonus program, public rider profiles, and the expedition waitlist system (join/leave/admin view/admin action/slot-open email).
 *
 * Split out of fw-includes/community-features.php on 2026-08-05 for maintainability.
 * All REST routes are still registered centrally in functions.php; this file only
 * holds the callback functions / helpers. See git history for the pre-split version
 * if anything needs to be cross-referenced.
 */
if ( ! defined( 'ABSPATH' ) ) exit; // no direct access

/* ── Referral bonus — fires once, when a referred member completes their first trip ── */
function fw_maybe_award_referral_bonus( $referee_id ) {
    $h = array( 'apikey' => FW_SUPABASE_SERVICE, 'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE );

    $m = json_decode( wp_remote_retrieve_body( wp_remote_get(
        FW_SUPABASE_URL . '/rest/v1/fw_members?id=eq.' . rawurlencode( $referee_id ) . '&select=referred_by,referral_bonus_given,first_name',
        array( 'headers' => $h, 'timeout' => 8 )
    )), true );

    $referred_by = $m[0]['referred_by'] ?? null;
    $already     = $m[0]['referral_bonus_given'] ?? false;
    $referee_name = $m[0]['first_name'] ?? 'Your friend';

    if ( ! $referred_by || $already ) return; /* not referred, or already paid out */

    fw_give_credits( $referred_by, 100, 'referral_bonus', $referee_id, 'member', $referee_name . ' completed their first trip' );
    fw_give_credits( $referee_id, 100, 'referral_bonus', $referred_by, 'member', 'Referral bonus — first trip completed' );

    wp_remote_request( FW_SUPABASE_URL . '/rest/v1/fw_members?id=eq.' . rawurlencode( $referee_id ), array(
        'method'  => 'PATCH',
        'headers' => array_merge( $h, array( 'Content-Type' => 'application/json', 'Prefer' => 'return=minimal' ) ),
        'body'    => wp_json_encode( array( 'referral_bonus_given' => true ) ),
        'timeout' => 8,
    ));
}

/* ── GET /fw-referral-stats — member's own referral code + who they referred ── */
function fw_referral_stats( $request ) {
    $user = fw_validate_token( $request );
    if ( is_wp_error( $user ) ) return $user;
    $h = array( 'apikey' => FW_SUPABASE_SERVICE, 'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE );

    $me = json_decode( wp_remote_retrieve_body( wp_remote_get(
        FW_SUPABASE_URL . '/rest/v1/fw_members?id=eq.' . rawurlencode($user['id']) . '&select=referral_code,member_number',
        array( 'headers' => $h, 'timeout' => 8 )
    )), true );

    $referrals = json_decode( wp_remote_retrieve_body( wp_remote_get(
        FW_SUPABASE_URL . '/rest/v1/fw_members?referred_by=eq.' . rawurlencode($user['id']) . '&select=first_name,referral_bonus_given,created_at&order=created_at.desc',
        array( 'headers' => $h, 'timeout' => 8 )
    )), true );
    if ( ! is_array( $referrals ) ) $referrals = array();

    $credited = 0;
    foreach ( $referrals as $r ) { if ( ! empty( $r['referral_bonus_given'] ) ) $credited++; }

    /* Derive the code from member_number rather than trusting the stored referral_code
       column — that column is written by a fire-and-forget PATCH at registration time
       (see fw_register_member) with no failure handling, so it can end up empty even
       for a fully-registered member. member_number always exists, so compute from it. */
    $member_number = $me[0]['member_number'] ?? null;
    $referral_code = $member_number ? ( 'FW' . str_pad( $member_number, 4, '0', STR_PAD_LEFT ) ) : ( $me[0]['referral_code'] ?? '' );

    return rest_ensure_response( array(
        'success'        => true,
        'referral_code'  => $referral_code,
        'member_number'  => $member_number,
        'total_referred' => count( $referrals ),
        'credited_count' => $credited,
        'referrals'      => $referrals,
    ));
}

/* ── GET /fw-public-profile?n=42 — public rider profile by member_number ── */
function fw_public_profile( $request ) {
    $num = absint( $request->get_param('n') );
    if ( ! $num ) return new WP_Error( 'missing', 'Member number required.', array( 'status' => 400 ) );

    $h = array( 'apikey' => FW_SUPABASE_SERVICE, 'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE );

    $m = json_decode( wp_remote_retrieve_body( wp_remote_get(
        FW_SUPABASE_URL . '/rest/v1/fw_members?member_number=eq.' . $num . '&select=id,first_name,city,state,instagram,avatar_url,trips_completed,member_number,created_at',
        array( 'headers' => $h, 'timeout' => 10 )
    )), true );

    if ( empty( $m[0] ) ) return new WP_Error( 'not_found', 'Rider not found.', array( 'status' => 404 ) );
    $profile = $m[0];
    $user_id = $profile['id'];
    $tier    = fw_loyalty_tier( $profile['trips_completed'] ?? 0 );

    /* Public, published albums only */
    $albums = json_decode( wp_remote_retrieve_body( wp_remote_get(
        FW_SUPABASE_URL . '/rest/v1/fw_albums?user_id=eq.' . rawurlencode($user_id) . '&status=eq.published&order=created_at.desc&select=id,title,trip_name,created_at',
        array( 'headers' => $h, 'timeout' => 10 )
    )), true ) ?: array();
    foreach ( $albums as &$a ) {
        $photos = json_decode( wp_remote_retrieve_body( wp_remote_get(
            FW_SUPABASE_URL . '/rest/v1/fw_album_photos?album_id=eq.' . rawurlencode($a['id']) . '&order=sort_order.asc&select=url',
            array( 'headers' => $h, 'timeout' => 8 )
        )), true ) ?: array();
        $a['photos'] = $photos;
    }
    unset( $a );

    /* Published blogs only */
    $blogs = json_decode( wp_remote_retrieve_body( wp_remote_get(
        FW_SUPABASE_URL . '/rest/v1/fw_blogs?user_id=eq.' . rawurlencode($user_id) . '&status=eq.published&order=created_at.desc&select=id,title,cover_image,created_at',
        array( 'headers' => $h, 'timeout' => 10 )
    )), true ) ?: array();

    /* Remove internal id from response */
    unset( $profile['id'] );

    return rest_ensure_response( array(
        'success' => true,
        'profile' => $profile,
        'tier'    => $tier,
        'albums'  => $albums,
        'blogs'   => $blogs,
    ));
}

/* ── Waitlist: member joins ── */
function fw_join_waitlist( $request ) {
    $user = fw_validate_token( $request );
    if ( is_wp_error( $user ) ) return $user;

    $p     = $request->get_json_params() ?: array();
    $exp_id = absint( $p['expedition_id'] ?? 0 );
    $seats  = max( 1, intval( $p['seats_wanted'] ?? 1 ) );
    if ( ! $exp_id || ! get_post( $exp_id ) ) return new WP_Error( 'invalid', 'Expedition not found.', array( 'status' => 400 ) );

    $h = array( 'apikey' => FW_SUPABASE_SERVICE, 'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE );

    /* Don't double-join — check for an existing active entry */
    $existing = json_decode( wp_remote_retrieve_body( wp_remote_get(
        FW_SUPABASE_URL . '/rest/v1/fw_waitlist?expedition_id=eq.' . $exp_id . '&user_id=eq.' . rawurlencode($user['id']) . '&status=in.(waiting,notified)&select=id',
        array( 'headers' => $h, 'timeout' => 8 )
    )), true );
    if ( ! empty( $existing ) ) {
        return rest_ensure_response( array( 'success' => true, 'message' => 'You are already on the waitlist for this trip.' ) );
    }

    $resp = wp_remote_post( FW_SUPABASE_URL . '/rest/v1/fw_waitlist', array(
        'headers'     => array_merge( $h, array( 'Content-Type' => 'application/json', 'Prefer' => 'return=minimal' ) ),
        'body'        => wp_json_encode( array(
            'expedition_id' => $exp_id,
            'user_id'       => $user['id'],
            'seats_wanted'  => $seats,
            'status'        => 'waiting',
        )),
        'timeout'     => 10, 'data_format' => 'body',
    ));
    if ( is_wp_error( $resp ) || wp_remote_retrieve_response_code( $resp ) >= 300 ) {
        return new WP_Error( 'fail', 'Could not join waitlist.', array( 'status' => 500 ) );
    }
    return rest_ensure_response( array( 'success' => true ) );
}

/* ── Waitlist: member's own entries ── */
function fw_my_waitlist( $request ) {
    $user = fw_validate_token( $request );
    if ( is_wp_error( $user ) ) return $user;
    $h = array( 'apikey' => FW_SUPABASE_SERVICE, 'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE );
    $rows = json_decode( wp_remote_retrieve_body( wp_remote_get(
        FW_SUPABASE_URL . '/rest/v1/fw_waitlist?user_id=eq.' . rawurlencode($user['id']) . '&status=in.(waiting,notified)&order=created_at.desc',
        array( 'headers' => $h, 'timeout' => 10 )
    )), true );
    if ( ! is_array( $rows ) ) $rows = array();
    foreach ( $rows as &$r ) {
        if ( ! is_array( $r ) ) { $r = array(); continue; }
        $post = get_post( (int) ( $r['expedition_id'] ?? 0 ) );
        $r['expedition_title'] = $post ? html_entity_decode( get_the_title( $post ) ) : 'Unknown trip';
    }
    unset( $r );
    return rest_ensure_response( array( 'success' => true, 'waitlist' => $rows ) );
}

/* ── Waitlist: member leaves ── */
function fw_leave_waitlist( $request ) {
    $user = fw_validate_token( $request );
    if ( is_wp_error( $user ) ) return $user;
    $p  = $request->get_json_params() ?: array();
    $id = sanitize_text_field( $p['id'] ?? '' );
    if ( ! $id ) return new WP_Error( 'missing', 'Waitlist entry ID required.', array( 'status' => 400 ) );
    $h = array( 'apikey' => FW_SUPABASE_SERVICE, 'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE );
    wp_remote_request( FW_SUPABASE_URL . '/rest/v1/fw_waitlist?id=eq.' . rawurlencode($id) . '&user_id=eq.' . rawurlencode($user['id']),
        array( 'method' => 'DELETE', 'headers' => $h, 'timeout' => 10 ) );
    return rest_ensure_response( array( 'success' => true ) );
}

/* ── Admin/Moderator: view waitlist (grouped by expedition) ── */
function fw_admin_get_waitlist( $request ) {
    $caller = fw_admin_auth( $request );
    if ( is_wp_error( $caller ) ) return $caller;
    $h = array( 'apikey' => FW_SUPABASE_SERVICE, 'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE );

    $rows = json_decode( wp_remote_retrieve_body( wp_remote_get(
        FW_SUPABASE_URL . '/rest/v1/fw_waitlist?status=in.(waiting,notified)&order=created_at.asc',
        array( 'headers' => $h, 'timeout' => 10 )
    )), true );
    if ( ! is_array( $rows ) ) $rows = array();

    $user_ids = array_unique( array_column( $rows, 'user_id' ) );
    $members  = array();
    if ( $user_ids ) {
        $filter = implode( ',', array_map( 'rawurlencode', $user_ids ) );
        $m_rows = json_decode( wp_remote_retrieve_body( wp_remote_get(
            FW_SUPABASE_URL . '/rest/v1/fw_members?id=in.(' . $filter . ')&select=id,first_name,last_name,email,phone',
            array( 'headers' => $h, 'timeout' => 10 )
        )), true );
        if ( is_array( $m_rows ) ) foreach ( $m_rows as $m ) { $members[ $m['id'] ] = $m; }
    }

    foreach ( $rows as &$r ) {
        if ( ! is_array( $r ) ) { $r = array(); continue; }
        $post = get_post( (int) ( $r['expedition_id'] ?? 0 ) );
        $r['expedition_title'] = $post ? html_entity_decode( get_the_title( $post ) ) : 'Unknown trip';
        $mem = $members[ $r['user_id'] ] ?? array();
        $r['member_name']  = trim( ( $mem['first_name'] ?? '' ) . ' ' . ( $mem['last_name'] ?? '' ) ) ?: 'Unknown';
        $r['member_email'] = $mem['email'] ?? '';
        $r['member_phone'] = $mem['phone'] ?? '';
    }
    unset( $r );

    return rest_ensure_response( array( 'success' => true, 'waitlist' => $rows ) );
}

/* ── Admin/Moderator: notify / convert / remove a waitlist entry ── */
function fw_admin_waitlist_action( $request ) {
    $caller = fw_admin_auth( $request );
    if ( is_wp_error( $caller ) ) return $caller;
    $p      = $request->get_json_params() ?: array();
    $id     = sanitize_text_field( $p['id'] ?? '' );
    $action = sanitize_text_field( $p['action'] ?? '' );
    if ( ! $id || ! in_array( $action, array( 'notify', 'convert', 'remove' ), true ) ) {
        return new WP_Error( 'invalid', 'Valid id and action required.', array( 'status' => 400 ) );
    }
    $h = array( 'apikey' => FW_SUPABASE_SERVICE, 'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE );

    $row = json_decode( wp_remote_retrieve_body( wp_remote_get(
        FW_SUPABASE_URL . '/rest/v1/fw_waitlist?id=eq.' . rawurlencode($id) . '&select=*',
        array( 'headers' => $h, 'timeout' => 8 )
    )), true );
    if ( empty( $row[0] ) ) return new WP_Error( 'not_found', 'Waitlist entry not found.', array( 'status' => 404 ) );
    $entry = $row[0];

    if ( $action === 'remove' || $action === 'convert' ) {
        $new_status = $action === 'convert' ? 'converted' : 'removed';
        wp_remote_request( FW_SUPABASE_URL . '/rest/v1/fw_waitlist?id=eq.' . rawurlencode($id), array(
            'method' => 'PATCH', 'headers' => array_merge( $h, array( 'Content-Type' => 'application/json', 'Prefer' => 'return=minimal' ) ),
            'body' => wp_json_encode( array( 'status' => $new_status ) ), 'timeout' => 8,
        ));
        fw_log_admin_action( $caller, 'waitlist_' . $new_status, 'waitlist', $id, '' );
        return rest_ensure_response( array( 'success' => true ) );
    }

    /* Notify — email the member that a slot has opened up */
    $post  = get_post( (int) $entry['expedition_id'] );
    $title = $post ? html_entity_decode( get_the_title( $post ) ) : 'your trip';
    $mem = json_decode( wp_remote_retrieve_body( wp_remote_get(
        FW_SUPABASE_URL . '/rest/v1/fw_members?id=eq.' . rawurlencode($entry['user_id']) . '&select=email,first_name',
        array( 'headers' => $h, 'timeout' => 8 )
    )), true );
    if ( ! empty( $mem[0]['email'] ) ) {
        fw_send_waitlist_slot_email( $mem[0]['email'], $mem[0]['first_name'] ?? 'there', $title );
    }
    wp_remote_request( FW_SUPABASE_URL . '/rest/v1/fw_waitlist?id=eq.' . rawurlencode($id), array(
        'method' => 'PATCH', 'headers' => array_merge( $h, array( 'Content-Type' => 'application/json', 'Prefer' => 'return=minimal' ) ),
        'body' => wp_json_encode( array( 'status' => 'notified', 'notified_at' => date('c') ) ), 'timeout' => 8,
    ));
    fw_log_admin_action( $caller, 'waitlist_notified', 'waitlist', $id, $title );
    return rest_ensure_response( array( 'success' => true ) );
}

/* ── Waitlist slot-open email ── */
function fw_send_waitlist_slot_email( $email, $first_name, $trip_title ) {
    $brevo_api_key = defined('FW_BREVO_API_KEY') ? FW_BREVO_API_KEY : '';
    if ( ! $brevo_api_key ) return;
    $html = '<div style="font-family:Arial,sans-serif;background:#0f0d0b;padding:40px;color:#fff;text-align:center"><h2 style="color:#e8a020">A Slot Just Opened, ' . esc_html($first_name) . '!</h2><p style="color:rgba(255,255,255,.7);font-size:15px;line-height:1.7">A seat has opened up on <strong>' . esc_html($trip_title) . '</strong> — you were next on the waitlist. Reply to this email or message us on WhatsApp to grab it before it\'s gone.</p><p style="margin-top:30px;color:rgba(255,255,255,.4);font-size:12px">FreeWheel Expeditions</p></div>';
    wp_remote_post( 'https://api.brevo.com/v3/smtp/email', array(
        'headers' => array( 'api-key' => $brevo_api_key, 'Content-Type' => 'application/json', 'Accept' => 'application/json' ),
        'body' => wp_json_encode( array(
            'sender'      => array( 'name' => 'FreeWheel Expeditions', 'email' => 'hello@freewheelexpeditions.in' ),
            'to'          => array( array( 'email' => $email, 'name' => $first_name ) ),
            'subject'     => 'A slot just opened on ' . $trip_title . ' 🏔️',
            'htmlContent' => $html,
        )),
        'timeout' => 15, 'data_format' => 'body',
    ));
}

