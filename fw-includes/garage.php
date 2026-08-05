<?php
/**
 * FreeWheel Expeditions — The Garage
 *
 * Member vehicle profiles ("garage"). Feeds the public rider profile
 * (fw_public_profile in referrals-waitlist.php) and the member dashboard.
 * New feature — not wired into functions.php yet, pending review.
 */
if ( ! defined( 'ABSPATH' ) ) exit; // no direct access

/* ── GET /my-vehicles — member's own vehicle list (dashboard, edit view) ── */
function fw_my_vehicles( $request ) {
    $user = fw_validate_token( $request );
    if ( is_wp_error( $user ) ) return $user;

    $h = array( 'apikey' => FW_SUPABASE_SERVICE, 'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE );
    $resp = wp_remote_get(
        FW_SUPABASE_URL . '/rest/v1/fw_vehicles?user_id=eq.' . rawurlencode( $user['id'] ) . '&order=created_at.desc',
        array( 'headers' => $h, 'timeout' => 10 )
    );
    $vehicles = json_decode( wp_remote_retrieve_body( $resp ), true );
    if ( ! is_array( $vehicles ) ) $vehicles = array();

    return rest_ensure_response( array( 'success' => true, 'vehicles' => $vehicles ) );
}

/* ── POST /vehicle-add — add a vehicle to the member's garage ── */
function fw_vehicle_add( $request ) {
    $user = fw_validate_token( $request );
    if ( is_wp_error( $user ) ) return $user;

    $p      = $request->get_json_params() ?: array();
    $make   = sanitize_text_field( $p['make']  ?? '' );
    $model  = sanitize_text_field( $p['model'] ?? '' );
    $year   = ! empty( $p['year'] ) ? absint( $p['year'] ) : null;
    $nick   = sanitize_text_field( $p['nickname'] ?? '' );
    $mods   = sanitize_textarea_field( $p['mods'] ?? '' );
    $photo  = esc_url_raw( $p['photo_url'] ?? '' );
    $public = array_key_exists( 'is_public', $p ) ? (bool) $p['is_public'] : true;

    if ( ! $make || ! $model ) {
        return new WP_Error( 'missing', 'Make and model are required.', array( 'status' => 400 ) );
    }

    $body = array(
        'user_id'   => $user['id'],
        'make'      => $make,
        'model'     => $model,
        'year'      => $year,
        'nickname'  => $nick,
        'mods'      => $mods,
        'photo_url' => $photo,
        'is_public' => $public,
    );

    $resp = wp_remote_post( FW_SUPABASE_URL . '/rest/v1/fw_vehicles', array(
        'headers' => array(
            'apikey'        => FW_SUPABASE_SERVICE,
            'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE,
            'Content-Type'  => 'application/json',
            'Prefer'        => 'return=representation',
        ),
        'body'        => wp_json_encode( $body ),
        'timeout'     => 10, 'data_format' => 'body',
    ));
    $data = json_decode( wp_remote_retrieve_body( $resp ), true );
    if ( empty( $data[0] ) ) return new WP_Error( 'db_fail', 'Failed to add vehicle.', array( 'status' => 500 ) );

    return rest_ensure_response( array( 'success' => true, 'vehicle' => $data[0] ) );
}

/* ── DELETE /vehicle-delete — member removes their own vehicle ── */
function fw_vehicle_delete( $request ) {
    $user = fw_validate_token( $request );
    if ( is_wp_error( $user ) ) return $user;

    $p           = $request->get_json_params() ?: array();
    $vehicle_id  = sanitize_text_field( $p['id'] ?? '' );
    if ( ! $vehicle_id ) return new WP_Error( 'missing', 'Vehicle id required.', array( 'status' => 400 ) );

    $h = array( 'apikey' => FW_SUPABASE_SERVICE, 'Authorization' => 'Bearer ' . FW_SUPABASE_SERVICE );

    /* Ownership check — never trust the client-supplied id alone */
    $check = json_decode( wp_remote_retrieve_body( wp_remote_get(
        FW_SUPABASE_URL . '/rest/v1/fw_vehicles?id=eq.' . rawurlencode( $vehicle_id ) . '&select=user_id',
        array( 'headers' => $h, 'timeout' => 8 )
    )), true );
    if ( empty( $check[0]['user_id'] ) || $check[0]['user_id'] !== $user['id'] ) {
        return new WP_Error( 'forbidden', 'Not your vehicle.', array( 'status' => 403 ) );
    }

    wp_remote_request( FW_SUPABASE_URL . '/rest/v1/fw_vehicles?id=eq.' . rawurlencode( $vehicle_id ), array(
        'method'  => 'DELETE',
        'headers' => $h,
        'timeout' => 10,
    ));

    return rest_ensure_response( array( 'success' => true ) );
}
