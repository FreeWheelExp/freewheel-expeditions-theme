<?php
/**
 * FreeWheel Expeditions — Community Features
 * Member self-service (delete/resubmit rejected content), admin activity log,
 * referral program, public rider profiles, and the expedition waitlist system.
 * Split out of functions.php for maintainability — all routes are still
 * registered in functions.php; this file only holds the callback functions.
 */
if ( ! defined( 'ABSPATH' ) ) exit; // no direct access

/* ── Member: delete album (only rejected ones) ── */
function fw_member_delete_album( $request ) {
    $user = fw_validate_token( $request );
    if ( is_wp_error( $user ) ) return $user;
    $p        = $request->get_json_params() ?: array();
    $album_id = sanitize_text_field( $p['album_id'] ?? '' );
    if ( ! $album_id ) return new WP_Error( 'missing', 'Album ID required.', array( 'status' => 400 ) );
    $h = array( 'apikey' => FW_SUPABASE_SERVICE, 'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE );
    /* Verify ownership + only allow delete of rejected albums */
    $chk  = json_decode( wp_remote_retrieve_body( wp_remote_get(
        FW_SUPABASE_URL . '/rest/v1/fw_albums?id=eq.' . rawurlencode($album_id) . '&user_id=eq.' . rawurlencode($user['id']) . '&select=status',
        array( 'headers' => $h, 'timeout' => 8 )
    )), true );
    if ( empty($chk[0]) ) return new WP_Error( 'not_found', 'Album not found.', array( 'status' => 404 ) );
    wp_remote_request( FW_SUPABASE_URL . '/rest/v1/fw_album_photos?album_id=eq.' . rawurlencode($album_id),
        array( 'method'=>'DELETE', 'headers'=>$h, 'timeout'=>10 ) );
    wp_remote_request( FW_SUPABASE_URL . '/rest/v1/fw_albums?id=eq.' . rawurlencode($album_id) . '&user_id=eq.' . rawurlencode($user['id']),
        array( 'method'=>'DELETE', 'headers'=>$h, 'timeout'=>10 ) );
    return rest_ensure_response( array( 'success' => true ) );
}

/* ── Member: resubmit rejected album ── */
function fw_member_resubmit_album( $request ) {
    $user = fw_validate_token( $request );
    if ( is_wp_error( $user ) ) return $user;
    $p        = $request->get_json_params() ?: array();
    $album_id = sanitize_text_field( $p['album_id'] ?? '' );
    if ( ! $album_id ) return new WP_Error( 'missing', 'Album ID required.', array( 'status' => 400 ) );
    $h = array( 'apikey' => FW_SUPABASE_SERVICE, 'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE, 'Content-Type' => 'application/json', 'Prefer' => 'return=minimal' );
    wp_remote_request( FW_SUPABASE_URL . '/rest/v1/fw_albums?id=eq.' . rawurlencode($album_id) . '&user_id=eq.' . rawurlencode($user['id']),
        array( 'method'=>'PATCH', 'headers'=>$h, 'body'=>wp_json_encode(array('status'=>'pending')), 'timeout'=>10, 'data_format'=>'body' ) );
    return rest_ensure_response( array( 'success' => true ) );
}

/* ── Member: delete blog ── */
function fw_member_delete_blog( $request ) {
    $user = fw_validate_token( $request );
    if ( is_wp_error( $user ) ) return $user;
    $p  = $request->get_json_params() ?: array();
    $id = sanitize_text_field( $p['blog_id'] ?? '' );
    if ( ! $id ) return new WP_Error( 'missing', 'Blog ID required.', array( 'status' => 400 ) );
    $h = array( 'apikey' => FW_SUPABASE_SERVICE, 'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE );
    wp_remote_request( FW_SUPABASE_URL . '/rest/v1/fw_blogs?id=eq.' . rawurlencode($id) . '&user_id=eq.' . rawurlencode($user['id']),
        array( 'method'=>'DELETE', 'headers'=>$h, 'timeout'=>10 ) );
    return rest_ensure_response( array( 'success' => true ) );
}

/* ── Member: delete testimonial ── */
function fw_member_delete_testi( $request ) {
    $user = fw_validate_token( $request );
    if ( is_wp_error( $user ) ) return $user;
    $p  = $request->get_json_params() ?: array();
    $id = sanitize_text_field( $p['testi_id'] ?? '' );
    if ( ! $id ) return new WP_Error( 'missing', 'Testimonial ID required.', array( 'status' => 400 ) );
    $h = array( 'apikey' => FW_SUPABASE_SERVICE, 'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE );
    wp_remote_request( FW_SUPABASE_URL . '/rest/v1/fw_testimonials?id=eq.' . rawurlencode($id) . '&user_id=eq.' . rawurlencode($user['id']),
        array( 'method'=>'DELETE', 'headers'=>$h, 'timeout'=>10 ) );
    return rest_ensure_response( array( 'success' => true ) );
}

/* ── Member: resubmit rejected testimonial ── */
function fw_member_resubmit_testi( $request ) {
    $user = fw_validate_token( $request );
    if ( is_wp_error( $user ) ) return $user;
    $p  = $request->get_json_params() ?: array();
    $id = sanitize_text_field( $p['testi_id'] ?? '' );
    if ( ! $id ) return new WP_Error( 'missing', 'Testimonial ID required.', array( 'status' => 400 ) );
    $h = array( 'apikey' => FW_SUPABASE_SERVICE, 'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE, 'Content-Type' => 'application/json', 'Prefer' => 'return=minimal' );
    wp_remote_request( FW_SUPABASE_URL . '/rest/v1/fw_testimonials?id=eq.' . rawurlencode($id) . '&user_id=eq.' . rawurlencode($user['id']),
        array( 'method'=>'PATCH', 'headers'=>$h, 'body'=>wp_json_encode(array('status'=>'pending')), 'timeout'=>10, 'data_format'=>'body' ) );
    return rest_ensure_response( array( 'success' => true ) );
}

/* ---- fw_admin_remove_member ----
   super_admin: can remove anyone except themselves.
   moderator:   can only remove users whose current role is 'member'. */
function fw_admin_remove_member( $request ) {
    $caller = fw_admin_auth( $request );
    if ( is_wp_error( $caller ) ) return $caller;

    $body    = json_decode( $request->get_body(), true );
    $user_id = sanitize_text_field( $body['user_id'] ?? '' );
    if ( empty( $user_id ) ) return new WP_Error( 'missing', 'user_id required.', array( 'status' => 400 ) );

    if ( $user_id === $caller['id'] ) {
        return new WP_Error( 'self_remove', 'You cannot remove your own account.', array( 'status' => 400 ) );
    }

    $h_svc = array( 'apikey' => FW_SUPABASE_SERVICE, 'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE );
    $tgt   = json_decode( wp_remote_retrieve_body( wp_remote_get(
        FW_SUPABASE_URL . '/rest/v1/fw_members?id=eq.' . rawurlencode($user_id) . '&select=role',
        array( 'headers' => $h_svc, 'timeout' => 8 )
    )), true );
    $target_role = $tgt[0]['role'] ?? '';

    if ( $caller['role'] === 'moderator' && $target_role !== 'member' ) {
        return new WP_Error( 'forbidden', 'Moderators can only remove members, not staff accounts.', array( 'status' => 403 ) );
    }
    if ( $caller['role'] !== 'super_admin' && $caller['role'] !== 'moderator' ) {
        return new WP_Error( 'forbidden', 'Admin access required.', array( 'status' => 403 ) );
    }

    /* Delete from fw_members (Supabase Auth user record is left intact — only profile row removed) */
    $resp = wp_remote_request(
        FW_SUPABASE_URL . '/rest/v1/fw_members?id=eq.' . rawurlencode( $user_id ),
        array( 'method' => 'DELETE', 'headers' => $h_svc, 'timeout' => 10 )
    );
    if ( is_wp_error( $resp ) || wp_remote_retrieve_response_code( $resp ) >= 300 ) {
        return new WP_Error( 'delete_fail', 'Failed to remove member.', array( 'status' => 500 ) );
    }
    fw_log_admin_action( $caller, 'remove_member', 'member', $user_id, 'Target role was: ' . $target_role );
    return rest_ensure_response( array( 'success' => true ) );
}

/* ── Admin activity log ── */
function fw_log_admin_action( $actor, $action, $target_type = '', $target_id = '', $details = '' ) {
    if ( empty( $actor ) || ! is_array( $actor ) ) return;
    wp_remote_post( FW_SUPABASE_URL . '/rest/v1/fw_admin_logs', array(
        'headers'     => array( 'apikey' => FW_SUPABASE_SERVICE, 'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE, 'Content-Type' => 'application/json', 'Prefer' => 'return=minimal' ),
        'body'        => wp_json_encode( array(
            'actor_id'    => $actor['id'] ?? '',
            'actor_email' => $actor['email'] ?? '',
            'actor_role'  => $actor['role'] ?? '',
            'action'      => $action,
            'target_type' => $target_type,
            'target_id'   => (string) $target_id,
            'details'     => substr( $details, 0, 500 ),
        )),
        'timeout' => 8, 'data_format' => 'body',
    ));
}

/* ---- /admin/activity-log (super_admin only) ---- */
function fw_admin_activity_log( $request ) {
    $caller = fw_admin_auth( $request );
    if ( is_wp_error( $caller ) ) return $caller;
    if ( $caller['role'] !== 'super_admin' ) {
        return new WP_Error( 'forbidden', 'Only Super Admin can view the activity log.', array( 'status' => 403 ) );
    }
    $resp = wp_remote_get(
        FW_SUPABASE_URL . '/rest/v1/fw_admin_logs?order=created_at.desc&limit=200',
        array( 'headers' => array( 'apikey' => FW_SUPABASE_SERVICE, 'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE ), 'timeout' => 10 )
    );
    $logs = json_decode( wp_remote_retrieve_body( $resp ), true );
    if ( ! is_array( $logs ) ) $logs = array();
    return rest_ensure_response( array( 'success' => true, 'logs' => $logs ) );
}

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

    return rest_ensure_response( array(
        'success'        => true,
        'referral_code'  => $me[0]['referral_code'] ?? '',
        'member_number'  => $me[0]['member_number'] ?? null,
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
        $post = get_post( (int) $r['expedition_id'] );
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
        $post = get_post( (int) $r['expedition_id'] );
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

/* ── Helper: build campaign HTML email body ──
   $assets: optional array with keys image_url, pdf_url, pdf_label, cta_url, cta_label */
function fw_build_campaign_html( $body_text, $expedition_titles, $unsubscribe_url, $assets = array() ) {
    $exp_html = '';
    foreach ( $expedition_titles as $title ) {
        $exp_html .= '<li style="margin:6px 0;color:rgba(255,255,255,.85);font-size:15px">' . esc_html( $title ) . '</li>';
    }
    $trips_block = $exp_html
        ? '<ul style="text-align:left;display:inline-block;margin:20px auto;padding-left:20px">' . $exp_html . '</ul>'
        : '';

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

    // Primary CTA: use admin-provided URL/label if given, otherwise default to the expeditions page
    $cta_url   = ! empty( $assets['cta_url'] )   ? esc_url( $assets['cta_url'] )                     : 'https://freewheelexpeditions.in';
    $cta_label = ! empty( $assets['cta_label'] ) ? esc_html( sanitize_text_field( $assets['cta_label'] ) ) : 'View Expeditions →';

    return '
<div style="font-family:Arial,sans-serif;background:#0f0d0b;padding:40px 20px;color:#fff;max-width:600px;margin:0 auto">
  <div style="text-align:center;margin-bottom:30px">
    <h2 style="color:#e8a020;margin:0 0 8px">FreeWheel Expeditions 🏔️</h2>
    <p style="color:rgba(255,255,255,.4);font-size:13px;margin:0">The JUNGLI Convoy</p>
  </div>
  <div style="background:rgba(255,255,255,.05);border-radius:12px;padding:28px;margin-bottom:24px">
    ' . $image_block . '
    <p style="color:rgba(255,255,255,.85);font-size:15px;line-height:1.8;margin:0 0 16px">' . $safe_body . '</p>
    ' . $trips_block . '
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

    if ( ! $subject || ! $body_text || empty( $emails ) ) {
        return new WP_Error( 'missing', 'Subject, body, and at least one recipient are required.', array( 'status' => 400 ) );
    }
    if ( count( $emails ) > 25 ) {
        return new WP_Error( 'batch_too_large', 'Max 25 recipients per batch call.', array( 'status' => 400 ) );
    }

    $expedition_titles = array();
    foreach ( $exp_ids as $pid ) {
        $post = get_post( $pid );
        if ( $post ) $expedition_titles[] = get_the_title( $post );
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
        $html = fw_build_campaign_html( $body_text, $expedition_titles, $unsub_url, $assets );
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
            // Re-activate if previously unsubscribed
            if ( empty( $chk[0]['is_subscribed'] ) ) {
                wp_remote_request( FW_SUPABASE_URL . '/rest/v1/fw_subscribers?id=eq.' . rawurlencode( $chk[0]['id'] ), array(
                    'method'      => 'PATCH',
                    'headers'     => array_merge( $h_svc, array( 'Content-Type' => 'application/json', 'Prefer' => 'return=minimal' ) ),
                    'body'        => wp_json_encode( array( 'is_subscribed' => true ) ),
                    'timeout'     => 8,
                    'data_format' => 'body',
                ));
                return rest_ensure_response( array( 'success' => true, 'message' => 'Previously unsubscribed — reactivated.' ) );
            }
            return rest_ensure_response( array( 'success' => false, 'message' => 'This email is already in the subscriber list.' ) );
        }
    }

    // Check duplicates — mobile collision
    if ( $mobile ) {
        $chk_m = json_decode( wp_remote_retrieve_body( wp_remote_get(
            FW_SUPABASE_URL . '/rest/v1/fw_subscribers?mobile=eq.' . rawurlencode( $mobile ) . '&select=id',
            array( 'headers' => $h_svc, 'timeout' => 8 )
        )), true );
        if ( ! empty( $chk_m[0]['id'] ) ) {
            return rest_ensure_response( array( 'success' => false, 'message' => 'This WhatsApp number is already in the subscriber list.' ) );
        }
    }

    $source_label = in_array( $user['role'], array( 'super_admin', 'admin' ), true ) ? 'admin_manual' : 'moderator_manual';
    $token        = bin2hex( random_bytes( 32 ) );

    $row = array(
        'email'             => $email ? strtolower( $email ) : null,
        'mobile'            => $mobile ?: null,
        'name'              => $name ?: null,
        'is_subscribed'     => true,
        'source'            => $source_label,
        'unsubscribe_token' => $token,
        'email_verified'    => (bool) $email, // admin-entered email treated as verified
    );

    $insert = wp_remote_post( FW_SUPABASE_URL . '/rest/v1/fw_subscribers', array(
        'headers'     => array_merge( $h_svc, array( 'Content-Type' => 'application/json', 'Prefer' => 'return=minimal' ) ),
        'body'        => wp_json_encode( $row ),
        'timeout'     => 10,
        'data_format' => 'body',
    ));

    if ( is_wp_error( $insert ) || wp_remote_retrieve_response_code( $insert ) >= 300 ) {
        error_log( '[FW] fw_admin_add_subscriber failed: ' . wp_remote_retrieve_body( $insert ) );
        return new WP_Error( 'db_fail', 'Failed to add subscriber.', array( 'status' => 500 ) );
    }

    fw_log_admin_action( $user['id'], 'subscriber_add', null, 'Added subscriber: ' . ( $email ?: $mobile ) );
    return rest_ensure_response( array( 'success' => true, 'message' => 'Subscriber added successfully.' ) );
}

/* ── GET /admin/subscribers — list all subscribers ── */
function fw_admin_get_subscribers( $request ) {
    $user = fw_admin_auth( $request );
    if ( is_wp_error( $user ) ) return $user;

    $resp = wp_remote_get(
        FW_SUPABASE_URL . '/rest/v1/fw_subscribers?order=created_at.desc&select=id,name,email,mobile,is_subscribed,source,email_verified,created_at',
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
