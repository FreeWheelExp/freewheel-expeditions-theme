<?php
/**
 * FreeWheel Expeditions — Google Reviews Integration
 * Pulls aggregate rating + review count + up to 5 review snippets from
 * Google's Places API, cached via WP transient (refreshed every 12 hours).
 *
 * Requires FW_GOOGLE_PLACES_KEY to be defined in wp-config.php:
 *   define( 'FW_GOOGLE_PLACES_KEY', 'your-key-here' );
 *
 * The star rating + review count are always live (refresh on next cache
 * expiry). Google's API caps the review TEXT snippets it returns at 5 —
 * that's a Google limitation, not something any integration can get around.
 * We request them sorted "newest" so the 5 shown are the most recent ones
 * Google has indexed, not an arbitrary "relevance" pick.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

define( 'FW_GOOGLE_PLACE_ID', 'ChIJxb4oxX3f9wgRzmX30j5yel8' );

function fw_get_google_reviews() {
    $cached = get_transient( 'fw_google_reviews_cache' );
    if ( $cached !== false ) return $cached;

    if ( ! defined( 'FW_GOOGLE_PLACES_KEY' ) || ! FW_GOOGLE_PLACES_KEY ) {
        return array( 'success' => false, 'message' => 'Google Places API key not configured.' );
    }

    $url = add_query_arg( array(
        'place_id'     => FW_GOOGLE_PLACE_ID,
        'fields'       => 'name,rating,user_ratings_total,reviews,url',
        'reviews_sort' => 'newest',
        'key'          => FW_GOOGLE_PLACES_KEY,
    ), 'https://maps.googleapis.com/maps/api/place/details/json' );

    $resp = wp_remote_get( $url, array( 'timeout' => 10 ) );
    if ( is_wp_error( $resp ) ) {
        $fallback = array( 'success' => false, 'message' => 'Could not reach Google.' );
        set_transient( 'fw_google_reviews_cache', $fallback, 30 * MINUTE_IN_SECONDS ); // short retry window on failure
        return $fallback;
    }

    $data = json_decode( wp_remote_retrieve_body( $resp ), true );
    if ( empty( $data['result'] ) || ( $data['status'] ?? '' ) !== 'OK' ) {
        $fallback = array( 'success' => false, 'message' => $data['status'] ?? 'Unknown error from Google.' );
        set_transient( 'fw_google_reviews_cache', $fallback, 30 * MINUTE_IN_SECONDS );
        return $fallback;
    }

    $reviews = array_map( function( $r ) {
        return array(
            'author'   => $r['author_name'] ?? 'Google User',
            'avatar'   => $r['profile_photo_url'] ?? '',
            'rating'   => $r['rating'] ?? 5,
            'text'     => $r['text'] ?? '',
            'time_ago' => $r['relative_time_description'] ?? '',
        );
    }, $data['result']['reviews'] ?? array() );

    $result = array(
        'success'  => true,
        'rating'   => floatval( $data['result']['rating'] ?? 0 ),
        'total'    => intval( $data['result']['user_ratings_total'] ?? 0 ),
        'maps_url' => $data['result']['url'] ?? ( 'https://search.google.com/local/reviews?placeid=' . FW_GOOGLE_PLACE_ID ),
        'reviews'  => $reviews,
    );

    set_transient( 'fw_google_reviews_cache', $result, 12 * HOUR_IN_SECONDS );
    return $result;
}

/* ── Compact inline badge — for near the booking button on expedition pages ── */
function fw_google_rating_badge() {
    $data = fw_get_google_reviews();
    if ( empty( $data['success'] ) || $data['total'] < 1 ) return '';

    $stars = fw_render_stars( $data['rating'] );
    ob_start();
    ?>
    <a href="<?php echo esc_url( $data['maps_url'] ); ?>" target="_blank" rel="noopener"
       style="display:inline-flex;align-items:center;gap:8px;text-decoration:none;color:rgba(255,255,255,.8);font-size:13px;font-family:var(--body,sans-serif)">
        <span style="color:var(--amber,#e8a020);font-size:14px;letter-spacing:1px"><?php echo $stars; ?></span>
        <strong style="color:#fff"><?php echo number_format( $data['rating'], 1 ); ?></strong>
        <span style="color:rgba(255,255,255,.4)">&middot; <?php echo $data['total']; ?> Google Review<?php echo $data['total'] === 1 ? '' : 's'; ?></span>
    </a>
    <?php
    return ob_get_clean();
}

/* ── Full homepage trust strip — rating + rotating review snippets ──
   Google's API caps the snippets it returns at 5 — we cycle through
   whatever we get back rather than freezing on just the newest one. */
function fw_google_rating_section() {
    $data = fw_get_google_reviews();
    if ( empty( $data['success'] ) || $data['total'] < 1 ) return '';
    $reviews = $data['reviews'];
    ?>
    <section class="fw-google-strip" style="background:#0f0d0b;padding:36px 5vw;border-top:1px solid rgba(255,255,255,.06);border-bottom:1px solid rgba(255,255,255,.06)">
      <div style="max-width:1100px;margin:0 auto;display:flex;align-items:center;justify-content:center;gap:32px;flex-wrap:wrap;text-align:center">
        <a href="<?php echo esc_url( $data['maps_url'] ); ?>" target="_blank" rel="noopener" style="display:flex;align-items:center;gap:14px;text-decoration:none;flex-shrink:0">
          <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
          <div style="text-align:left">
            <div style="display:flex;align-items:center;gap:8px">
              <span style="font-family:var(--headline,sans-serif);font-size:28px;color:#fff"><?php echo number_format( $data['rating'], 1 ); ?></span>
              <span style="color:var(--amber,#e8a020);font-size:18px;letter-spacing:2px"><?php echo fw_render_stars( $data['rating'] ); ?></span>
            </div>
            <div style="font-size:12px;color:rgba(255,255,255,.45);letter-spacing:.5px">Based on <?php echo $data['total']; ?> Google Review<?php echo $data['total'] === 1 ? '' : 's'; ?></div>
          </div>
        </a>

        <?php if ( ! empty( $reviews ) ): ?>
        <div class="fwGrCarousel" style="max-width:440px;text-align:left;border-left:2px solid rgba(232,160,32,.4);padding-left:18px;position:relative;min-height:70px">
          <?php foreach ( $reviews as $i => $r ): ?>
          <div class="fw-gr-slide" data-i="<?php echo $i; ?>" style="<?php echo $i === 0 ? '' : 'display:none;'; ?>">
            <p style="font-size:14px;color:rgba(255,255,255,.7);font-style:italic;line-height:1.6;margin:0 0 6px">&ldquo;<?php echo esc_html( wp_trim_words( $r['text'], 22 ) ); ?>&rdquo;</p>
            <div style="font-size:12px;color:rgba(255,255,255,.4)"><?php echo esc_html( $r['author'] ); ?> &middot; <?php echo esc_html( $r['time_ago'] ); ?></div>
          </div>
          <?php endforeach; ?>
          <?php if ( count( $reviews ) > 1 ): ?>
          <div class="fw-gr-dots" style="display:flex;gap:6px;margin-top:12px">
            <?php foreach ( $reviews as $i => $r ): ?>
            <span class="fw-gr-dot" data-i="<?php echo $i; ?>" style="width:6px;height:6px;border-radius:50%;cursor:pointer;background:<?php echo $i === 0 ? 'var(--amber,#e8a020)' : 'rgba(255,255,255,.2)'; ?>"></span>
            <?php endforeach; ?>
          </div>
          <?php endif; ?>
        </div>
        <?php if ( count( $reviews ) > 1 ): ?>
        <script>
        (function init(){
          if (document.readyState === 'loading') { document.addEventListener('DOMContentLoaded', init); return; }
          var containers = document.querySelectorAll('.fwGrCarousel');
          containers.forEach(function(box){
            var slides = box.querySelectorAll('.fw-gr-slide');
            var dots   = box.querySelectorAll('.fw-gr-dot');
            if (!slides.length) return;
            var cur = 0, total = slides.length, timer = null;

            function goto(i){
              if (!slides[cur] || !slides[i]) return;
              slides[cur].style.display = 'none';
              if (dots[cur]) dots[cur].style.background = 'rgba(255,255,255,.2)';
              cur = i;
              slides[cur].style.display = 'block';
              if (dots[cur]) dots[cur].style.background = 'var(--amber,#e8a020)';
            }
            function next(){ goto( (cur + 1) % total ); }
            function startAuto(){ stopAuto(); timer = setInterval(next, 6000); }
            function stopAuto(){ if (timer) clearInterval(timer); timer = null; }

            dots.forEach(function(dot){
              dot.addEventListener('click', function(){
                var i = parseInt(dot.getAttribute('data-i'), 10);
                if (!isNaN(i)) { goto(i); startAuto(); }
              });
            });
            box.addEventListener('mouseenter', stopAuto);
            box.addEventListener('mouseleave', startAuto);
            startAuto();
          });
        })();
        </script>
        <?php endif; ?>
        <?php endif; ?>
      </div>
    </section>
    <?php
}

/* ── Helper: render ★ characters for a given rating, rounded to nearest whole star.
   (Half-star glyphs don't render reliably across fonts/platforms — the exact
   number is already shown in text right next to these, so rounding is fine.) ── */
function fw_render_stars( $rating ) {
    $full = round( $rating );
    $full = max( 0, min( 5, $full ) );
    return str_repeat( '★', $full ) . str_repeat( '☆', 5 - $full );
}
