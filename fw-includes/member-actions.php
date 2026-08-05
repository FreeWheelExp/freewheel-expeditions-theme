<?php
/**
 * FreeWheel Expeditions — Member self-service (delete/resubmit rejected album/blog/testimonial), admin remove-member action, and the admin activity log.
 *
 * Split out of fw-includes/community-features.php on 2026-08-05 for maintainability.
 * All REST routes are still registered centrally in functions.php; this file only
 * holds the callback functions / helpers. See git history for the pre-split version
 * if anything needs to be cross-referenced.
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

