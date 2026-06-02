<?php
/**
 * Template Name: Road Buddies
 * Template Post Type: page
 * 
 * FreeWheel Expeditions — Road Buddies / Connect Page
 * Assign this template to any WordPress page via:
 * Pages → Edit → Page Attributes → Template → "Road Buddies"
 */
get_header(); ?>

<style>

/* ═══ FORCE DARK THEME — Override WordPress/GoDaddy default styles ═══ */
html,
body,
body.page,
body.page-template,
body.page-template-page-connect,
#page,
#content,
#primary,
#main,
.site,
.site-content,
.entry-content,
.wp-site-blocks,
main,
article {
    background: #0f0d0b !important;
    background-color: #0f0d0b !important;
    color: #ffffff !important;
}

/* Remove any WordPress default padding/margin on content wrappers */
.entry-content,
.page-content,
#primary,
#main,
main {
    padding: 0 !important;
    margin: 0 !important;
    max-width: 100% !important;
    width: 100% !important;
}

/* Remove default WordPress link colours */
a { color: inherit; }

/* Remove GoDaddy/theme header if it adds one above ours */
.site-header,
.wp-block-template-part[class*="header"],
header.wp-block-template-part {
    display: none !important;
}

/* Ensure our page starts right after fixed nav */
.connect-hero {
    padding-top: 100px !important;
}
/* ═══════════════════════════════════════════════════════════════ */



/* ═══ GLOBAL MOBILE FIXES ═══ */
html{-webkit-text-size-adjust:100%;text-size-adjust:100%}
img{max-width:100%;height:auto}
*{-webkit-tap-highlight-color:transparent}
button,a{touch-action:manipulation}
input,textarea,select{font-size:16px!important} /* prevent iOS zoom */

/* Touch-friendly tap targets */
nav a,button,.nav-cta{min-height:44px;display:inline-flex;align-items:center;justify-content:center}

/* Smooth scrolling on mobile */
.carousel-track,.carousel-wrap,.filter-bar{-webkit-overflow-scrolling:touch;scroll-snap-type:x mandatory}
.trip-card{scroll-snap-align:start}

/* Prevent horizontal overflow */
body{overflow-x:hidden;max-width:100vw}
section,footer,nav{max-width:100%;overflow-x:hidden}

/* Mobile grid fixes */
@media(max-width:480px){
  .fg-row{grid-template-columns:1fr!important}
  .trips-grid{grid-template-columns:1fr!important}
  .merch-grid{grid-template-columns:1fr 1fr!important}
  .profile-grid{grid-template-columns:1fr!important}
  .quick-grid{grid-template-columns:1fr 1fr!important}
  .steps-grid{grid-template-columns:1fr 1fr!important}
  .perks-grid{grid-template-columns:1fr!important}
  .testi-grid{grid-template-columns:1fr!important}
  .comm-stats{grid-template-columns:1fr 1fr!important}
  .vb-social-grid{grid-template-columns:repeat(2,1fr)!important}
  .mdb-grid{grid-template-columns:1fr!important}
  .pay-tabs,.pay-tabs2{flex-wrap:wrap}
  .price-strip{flex-direction:column}
  .ps-item{min-width:100%}
  .otp-input{width:42px!important;height:50px!important;font-size:22px!important}
  .auth-card{margin:0 0!important;border-radius:0!important}
  .modal,.modal-detail,.modal-post,.modal-join{border-radius:0!important;max-width:100%!important}
  .overlay{padding:0!important;align-items:flex-end!important}
  footer{flex-direction:column;text-align:center;gap:8px}
  .foot-links{justify-content:center}
  h1,.ch-h1,.merch-h1{font-size:clamp(44px,12vw,80px)!important}
}
@media(max-width:360px){
  .merch-grid{grid-template-columns:1fr!important}
  .otp-row{gap:4px!important}
  .otp-input{width:36px!important;height:44px!important}
}

/* Safe area insets for notch phones */
body{padding-bottom:env(safe-area-inset-bottom)}
nav{padding-left:max(5vw,env(safe-area-inset-left));padding-right:max(5vw,env(safe-area-inset-right))}


/* ── Hero stats centered ── */
.hero-stats{display:flex!important;flex-direction:row!important;gap:40px!important;justify-content:center!important;align-items:center!important;text-align:center!important;flex-wrap:wrap!important;width:100%!important;margin:0 auto!important;padding:28px 5vw!important;border-top:1px solid rgba(255,255,255,.08)!important;position:relative!important;z-index:1!important}
.hstat-n{text-align:center!important}
.hstat-l{text-align:center!important}
</style>

VERIFY BANNER -->
<div class="verify-banner" id="verifyBanner" style="margin-top:64px">
  <div class="verify-banner-inner">
    <span class="vb-text"><strong>📱 Verify your account</strong> to post trips and send join requests. Phone OTP + Email OTP required.</span>
    <a href="dashboard.html" class="vb-btn">Verify Now →</a>
  </div>
</div>

<!-- HERO -->
<section class="connect-hero">
  <div class="ch-grid"></div>
  <div class="ch-eyebrow">Road Buddies · Find Your Convoy</div>
  <h1 class="ch-h1">Connect &<br><span>Co-Drive</span></h1>
  <p class="ch-sub">Post your road trip, find travellers along your route within 100 km, and build your convoy. Every great journey is better shared.</p>
  <div class="ch-cta-row">
    <button class="btn-post" onclick="openPostTrip()" title="Login or register to post a trip">+ Post a Trip</button>
    <button class="btn-browse" onclick="document.getElementById('browseSection').scrollIntoView({behavior:'smooth'})">Browse Trips ↓</button>
  </div>
  <div class="hero-stats">
    <div><div class="hstat-n">47</div><div class="hstat-l">Active Trips</div></div>
    <div><div class="hstat-n">500+</div><div class="hstat-l">Members</div></div>
    <div><div class="hstat-n">23</div><div class="hstat-l">Convoys Formed</div></div>
    <div><div class="hstat-n">100km</div><div class="hstat-l">Match Radius</div></div>
  </div>
</section>

<!-- HOW IT WORKS -->
<section class="how-section">
  <div class="how-inner">
    <div class="section-head">
      <div class="sec-tag">How It Works</div>
      <div class="sec-h2">Four Simple Steps</div>
    </div>
    <div class="steps-grid">
      <div class="how-step">
        <div class="how-step-num">01</div>
        <span class="how-step-icon">🔐</span>
        <div class="how-step-title">Verify Account</div>
        <div class="how-step-desc">Complete Phone OTP + Email OTP verification. Connect Facebook or Google for extra trust signals on your profile.</div>
      </div>
      <div class="how-step">
        <div class="how-step-num">02</div>
        <span class="how-step-icon">📍</span>
        <div class="how-step-title">Post Your Trip</div>
        <div class="how-step-desc">Share your route, dates, vehicle, and how many co-passengers you want. Our system finds matches within 100 km of you and along your route.</div>
      </div>
      <div class="how-step">
        <div class="how-step-num">03</div>
        <span class="how-step-icon">🔔</span>
        <div class="how-step-title">Get Notified</div>
        <div class="how-step-desc">Nearby registered members and those on your route receive a notification about your trip. They can view your profile and send a join request.</div>
      </div>
      <div class="how-step">
        <div class="how-step-num">04</div>
        <span class="how-step-icon">🚗</span>
        <div class="how-step-title">Build Your Convoy</div>
        <div class="how-step-desc">Review join requests, accept or decline, coordinate in the FreeWheel community group, and hit the road together.</div>
      </div>
    </div>
  </div>
</section>

<!-- BROWSE TRIPS -->
<section class="browse-section" id="browseSection">
  <div class="browse-inner">
    <div class="section-head" style="text-align:left;margin-bottom:24px">
      <div class="sec-tag">Active Trips</div>
      <div class="sec-h2" style="font-size:clamp(28px,3vw,44px)">Find Your Co-Driver</div>
    </div>

    <!-- FILTERS -->
    <div class="filter-row">
      <label>From</label>
      <input type="text" class="filter-input" id="filterFrom" placeholder="Delhi, Noida…" oninput="filterTrips()">
      <label>To</label>
      <input type="text" class="filter-input" id="filterTo" placeholder="Goa, Manali…" oninput="filterTrips()">
      <label>Sort</label>
      <select class="filter-select" id="filterSort" onchange="filterTrips()">
        <option value="nearest">Nearest First</option>
        <option value="date">Earliest Date</option>
        <option value="seats">Most Seats</option>
      </select>
      <button class="filter-btn" onclick="clearFilters()">Clear</button>
    </div>

    <div class="trips-grid" id="tripsGrid">
      <div class="trip-card" data-id="t1">
      <div class="tc-header">
        <div class="tc-user">
          <div class="tc-avatar" style="background:#c1440e">AM</div>
          <div class="tc-userinfo">
            <div class="tc-name">Arjun Mehta, 28 <span class="tc-city">· Delhi</span></div>
            <div class="tc-badges"><span class="verified-badge" title="Verified User">✓ Verified</span><span class="match-badge">📍 On your route</span></div>
          </div>
        </div>
        <div class="tc-social"><a href="https://facebook.com" target="_blank" class="soc-link soc-fb" title="Facebook"><svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg></a><a href="https://instagram.com" target="_blank" class="soc-link soc-ig" title="Instagram"><svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg></a></div>
      </div>
      <div class="tc-route">
        <div class="tc-from"><span class="route-dot dot-start"></span><span class="route-city">Delhi</span></div>
        <div class="tc-arrow">——→</div>
        <div class="tc-to"><span class="route-dot dot-end"></span><span class="route-city">Goa</span></div>
      </div>
      <div class="tc-via">via Agra · Nagpur · Pune</div>
      <div class="tc-meta">
        <div class="tc-meta-item">📅 15 May 2026</div>
        <div class="tc-meta-item">⏱ 6 Days</div>
        <div class="tc-meta-item">🚗 Mahindra Thar</div>
        <div class="tc-meta-item">👥 2 seats available</div>
        <div class="tc-meta-item">📍 ~42 km away</div>
      </div>
      <div class="tc-tags"><span class="tt">Adventure</span><span class="tt">Road Trip</span><span class="tt">Beach</span></div>
      <div class="tc-footer">
        <button class="tc-view-btn" onclick="openTrip('t1')">View Trip Details</button>
        <button class="tc-join-btn" onclick="openJoinReq('t1','Arjun Mehta')">Request to Join →</button>
      </div>
    </div>
<div class="trip-card" data-id="t2">
      <div class="tc-header">
        <div class="tc-user">
          <div class="tc-avatar" style="background:#2a7a6e">PS</div>
          <div class="tc-userinfo">
            <div class="tc-name">Priya Sharma, 25 <span class="tc-city">· Noida</span></div>
            <div class="tc-badges"><span class="verified-badge" title="Verified User">✓ Verified</span><span class="match-badge">📍 Near your location</span></div>
          </div>
        </div>
        <div class="tc-social"><a href="https://facebook.com" target="_blank" class="soc-link soc-fb" title="Facebook"><svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg></a></div>
      </div>
      <div class="tc-route">
        <div class="tc-from"><span class="route-dot dot-start"></span><span class="route-city">Noida</span></div>
        <div class="tc-arrow">——→</div>
        <div class="tc-to"><span class="route-dot dot-end"></span><span class="route-city">Manali</span></div>
      </div>
      <div class="tc-via">via Chandigarh · Kullu</div>
      <div class="tc-meta">
        <div class="tc-meta-item">📅 20 May 2026</div>
        <div class="tc-meta-item">⏱ 8 Days</div>
        <div class="tc-meta-item">🚗 Toyota Innova</div>
        <div class="tc-meta-item">👥 3 seats available</div>
        <div class="tc-meta-item">📍 ~67 km away</div>
      </div>
      <div class="tc-tags"><span class="tt">Mountains</span><span class="tt">Snow</span><span class="tt">Flexible</span></div>
      <div class="tc-footer">
        <button class="tc-view-btn" onclick="openTrip('t2')">View Trip Details</button>
        <button class="tc-join-btn" onclick="openJoinReq('t2','Priya Sharma')">Request to Join →</button>
      </div>
    </div>
<div class="trip-card" data-id="t3">
      <div class="tc-header">
        <div class="tc-user">
          <div class="tc-avatar" style="background:#e8a020">RV</div>
          <div class="tc-userinfo">
            <div class="tc-name">Rohit Verma, 32 <span class="tc-city">· Gurgaon</span></div>
            <div class="tc-badges"><span class="verified-badge" title="Verified User">✓ Verified</span><span class="match-badge">📍 Nearby</span></div>
          </div>
        </div>
        <div class="tc-social"><a href="https://instagram.com" target="_blank" class="soc-link soc-ig" title="Instagram"><svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg></a></div>
      </div>
      <div class="tc-route">
        <div class="tc-from"><span class="route-dot dot-start"></span><span class="route-city">Gurgaon</span></div>
        <div class="tc-arrow">——→</div>
        <div class="tc-to"><span class="route-dot dot-end"></span><span class="route-city">Leh</span></div>
      </div>
      <div class="tc-via">via Manali Highway</div>
      <div class="tc-meta">
        <div class="tc-meta-item">📅 1 June 2026</div>
        <div class="tc-meta-item">⏱ 14 Days</div>
        <div class="tc-meta-item">🚗 Royal Enfield Himalayan + Support Car</div>
        <div class="tc-meta-item">👥 1 seat available</div>
        <div class="tc-meta-item">📍 ~18 km away</div>
      </div>
      <div class="tc-tags"><span class="tt">Ladakh</span><span class="tt">Bikes Welcome</span><span class="tt">14 Days</span></div>
      <div class="tc-footer">
        <button class="tc-view-btn" onclick="openTrip('t3')">View Trip Details</button>
        <button class="tc-join-btn" onclick="openJoinReq('t3','Rohit Verma')">Request to Join →</button>
      </div>
    </div>
<div class="trip-card" data-id="t4">
      <div class="tc-header">
        <div class="tc-user">
          <div class="tc-avatar" style="background:#7a2a6e">SP</div>
          <div class="tc-userinfo">
            <div class="tc-name">Sneha Patel, 29 <span class="tc-city">· Faridabad</span></div>
            <div class="tc-badges"><span class="match-badge">📍 On your route</span></div>
          </div>
        </div>
        <div class="tc-social"><a href="https://facebook.com" target="_blank" class="soc-link soc-fb" title="Facebook"><svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg></a><a href="https://instagram.com" target="_blank" class="soc-link soc-ig" title="Instagram"><svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg></a></div>
      </div>
      <div class="tc-route">
        <div class="tc-from"><span class="route-dot dot-start"></span><span class="route-city">Faridabad</span></div>
        <div class="tc-arrow">——→</div>
        <div class="tc-to"><span class="route-dot dot-end"></span><span class="route-city">Ranthambore</span></div>
      </div>
      <div class="tc-via">via Agra Bypass</div>
      <div class="tc-meta">
        <div class="tc-meta-item">📅 10 May 2026</div>
        <div class="tc-meta-item">⏱ 3 Days</div>
        <div class="tc-meta-item">🚗 Swift Dzire</div>
        <div class="tc-meta-item">👥 2 seats available</div>
        <div class="tc-meta-item">📍 ~88 km away</div>
      </div>
      <div class="tc-tags"><span class="tt">Wildlife</span><span class="tt">Weekend</span><span class="tt">Safari</span></div>
      <div class="tc-footer">
        <button class="tc-view-btn" onclick="openTrip('t4')">View Trip Details</button>
        <button class="tc-join-btn" onclick="openJoinReq('t4','Sneha Patel')">Request to Join →</button>
      </div>
    </div>
    </div>
  </div>
</section>

<footer>
  <div class="foot-logo">
    <img src="<?php echo get_template_directory_uri(); ?>/images/page-connect-1.jpg" alt="">
    <span class="foot-brand">FREEWHEEL EXPEDITIONS</span>
  </div>
  <span class="foot-copy">© 2026 FreeWheel Expeditions · freewheelexpeditions.in</span>
  <div class="foot-links">
    <a href="https://instagram.com/freewheelexpeditions" target="_blank">Instagram</a>
    <a href="https://www.facebook.com/groups/freewheelexpeditions" target="_blank">Facebook</a>
    <a href="mailto:hello@freewheelexpeditions.in">Email</a>
  </div>
</footer>

<!-- ═══ TRIP DETAIL MODAL ═══ -->
<div class="overlay" id="tripDetailOverlay" onclick="closeIfOut(event,'tripDetailOverlay')">
  <div class="modal-detail">
    <button class="modal-close" onclick="closeModal('tripDetailOverlay')">✕</button>
    <div class="mdh">
      <div class="mdh-user">
        <div class="mdh-avatar" id="mdAvatar">AB</div>
        <div>
          <div class="mdh-name" id="mdName">—</div>
          <div class="mdh-meta" id="mdMeta">—</div>
          <div id="mdVerified" style="margin-top:5px"></div>
        </div>
      </div>
      <div class="mdh-route">
        <span id="mdFrom">—</span>
        <span class="arrow">——→</span>
        <span id="mdTo">—</span>
      </div>
      <div class="mdh-via" id="mdVia">—</div>
    </div>
    <div class="mdb">
      <div class="mdb-grid">
        <div class="mdb-item"><div class="mdb-label">Departure Date</div><div class="mdb-val" id="mdDate">—</div></div>
        <div class="mdb-item"><div class="mdb-label">Trip Duration</div><div class="mdb-val" id="mdDays">—</div></div>
        <div class="mdb-item"><div class="mdb-label">Vehicle</div><div class="mdb-val" id="mdVehicle">—</div></div>
        <div class="mdb-item"><div class="mdb-label">Seats Available</div><div class="mdb-val" id="mdSeats">—</div></div>
        <div class="mdb-item"><div class="mdb-label">Your City</div><div class="mdb-val" id="mdCity">—</div></div>
        <div class="mdb-item"><div class="mdb-label">Distance From You</div><div class="mdb-val" id="mdDist">—</div></div>
      </div>
      <div class="mdb-plan-title">Trip Plan</div>
      <div class="mdb-plan" id="mdPlan">—</div>
      <div class="mdb-social-row" id="mdSocialRow"></div>
      <button class="modal-join-btn" id="mdJoinBtn" onclick="">Request to Join This Trip →</button>
    </div>
  </div>
</div>

<!-- ═══ POST TRIP MODAL ═══ -->
<div class="overlay" id="postTripOverlay" onclick="closeIfOut(event,'postTripOverlay')">
  <div class="modal-post">
    <button class="modal-close" onclick="closeModal('postTripOverlay')">✕</button>
    <div class="mph">
      <div class="mph-title">Post a Trip</div>
      <div class="mph-sub">Your trip will be visible to members within 100 km and along your route</div>
    </div>
    <div class="mpb">
      <div class="wp-note"><strong>WordPress integration:</strong> Posting requires verified account (Phone OTP + Email OTP). Location is detected via browser GPS or entered manually. Notifications sent via Firebase/FCM to nearby users.</div>

      <!-- Verification status -->
      <div class="verify-block" id="verifyBlock">
        <div class="vb-row">
          <div class="vb-step done" id="stepPhone">
            <div class="vb-step-icon">📱</div>
            <div class="vb-step-info">
              <div class="vb-step-title">Phone OTP</div>
              <div class="vb-step-status" id="phoneStatus">Not verified</div>
            </div>
            <button class="vb-btn-sm" id="phoneBtn" onclick="verifyPhone()">Verify</button>
          </div>
          <div class="vb-step" id="stepEmail">
            <div class="vb-step-icon">✉️</div>
            <div class="vb-step-info">
              <div class="vb-step-title">Email OTP</div>
              <div class="vb-step-status" id="emailStatus">Not verified</div>
            </div>
            <button class="vb-btn-sm" id="emailBtn" onclick="verifyEmail()">Verify</button>
          </div>
        </div>
        <div class="vb-social-section">
          <div class="vb-social-label">Connect any 2 social accounts <span class="vb-social-count" id="socialCount">0 / 2 connected</span></div>
          <div class="vb-social-grid">
            <div class="vb-social-item" id="socFB" onclick="toggleSocial('FB')">
              <div class="vsi-icon" style="background:#1877f2">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="#fff"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
              </div>
              <div class="vsi-name">Facebook</div>
              <div class="vsi-status" id="socFBStatus">Connect</div>
            </div>
            <div class="vb-social-item" id="socGoogle" onclick="toggleSocial('Google')">
              <div class="vsi-icon" style="background:#fff;border:1px solid #ddd">
                <svg width="16" height="16" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
              </div>
              <div class="vsi-name">Google</div>
              <div class="vsi-status" id="socGoogleStatus">Connect</div>
            </div>
            <div class="vb-social-item" id="socIG" onclick="toggleSocial('IG')">
              <div class="vsi-icon" style="background:linear-gradient(45deg,#f09433,#e6683c,#dc2743,#cc2366,#bc1888)">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="#fff"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
              </div>
              <div class="vsi-name">Instagram</div>
              <div class="vsi-status" id="socIGStatus">Connect</div>
            </div>
            <div class="vb-social-item" id="socLI" onclick="toggleSocial('LI')">
              <div class="vsi-icon" style="background:#0077b5">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="#fff"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
              </div>
              <div class="vsi-name">LinkedIn</div>
              <div class="vsi-status" id="socLIStatus">Connect</div>
            </div>
          </div>
        </div>
        <div class="vb-progress-bar">
          <div class="vb-progress-fill" id="verifyProgress" style="width:0%"></div>
        </div>
        <div class="vb-progress-label" id="verifyProgressLabel">Complete verification to post trips</div>
      </div>

      <div class="fg-row">
        <div class="fg"><label>From City *</label><input type="text" id="ptFrom" placeholder="Delhi"></div>
        <div class="fg"><label>To City *</label><input type="text" id="ptTo" placeholder="Goa"></div>
      </div>
      <div class="fg"><label>Via (intermediate cities)</label><input type="text" id="ptVia" placeholder="Agra · Nagpur · Pune"></div>
      <div class="fg-row">
        <div class="fg"><label>Departure Date *</label><input type="date" id="ptDate"></div>
        <div class="fg"><label>Trip Duration (days) *</label><input type="number" id="ptDays" placeholder="6" min="1" max="60"></div>
      </div>
      <div class="fg-row">
        <div class="fg"><label>Your Vehicle *</label><input type="text" id="ptVehicle" placeholder="Mahindra Thar, Swift Dzire…"></div>
        <div class="fg"><label>Co-Passengers Wanted *</label><select id="ptSeats"><option value="1">1 person</option><option value="2">2 people</option><option value="3">3 people</option><option value="4">4 people</option></select></div>
      </div>
      <div class="fg"><label>Your Current Location</label>
        <div style="display:flex;gap:8px">
          <input type="text" id="ptLocation" placeholder="Enter city or click detect" style="flex:1">
          <button onclick="detectLocation()" style="padding:12px 14px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.1);color:rgba(255,255,255,.6);cursor:pointer;border-radius:2px;white-space:nowrap;font-size:12px">📍 Detect</button>
        </div>
      </div>
      <div class="fg"><label>Trip Plan / Description *</label><textarea id="ptPlan" rows="4" placeholder="Day 1: Delhi to Agra. Day 2: Agra to Nagpur. Day 3–4: Nagpur to Goa…"></textarea></div>
      <div class="fg-row">
        <div class="fg"><label>Tags (comma separated)</label><input type="text" id="ptTags" placeholder="Adventure, Beach, Flexible"></div>
        <div class="fg"><label>Your Age</label><input type="number" id="ptAge" placeholder="28" min="18" max="80"></div>
      </div>
      <button class="post-btn" onclick="submitTrip()">🚗 Post My Trip</button>
    </div>
  </div>
</div>

<!-- ═══ JOIN REQUEST MODAL ═══ -->
<div class="overlay" id="joinReqOverlay" onclick="closeIfOut(event,'joinReqOverlay')">
  <div class="modal-join">
    <button class="modal-close" onclick="closeModal('joinReqOverlay')">✕</button>
    <div class="mj-title">Send Join Request</div>
    <div class="mj-sub" id="joinSubtext">Request to join Arjun Mehta's trip</div>
    <div class="wp-note" style="margin-bottom:16px"><strong>WordPress:</strong> This sends a notification to the trip poster. They can accept or decline. If accepted, you both get each other's contact details.</div>
    <div class="fg"><label>Your Message</label><textarea id="joinMsg" rows="3" placeholder="Hi! I'm based in Delhi and heading to Goa around the same time. I drive a Maruti Brezza and would love to convoy. Let me know!"></textarea></div>
    <div class="fg"><label>Your Vehicle</label><input type="text" id="joinVehicle" placeholder="Maruti Brezza, Royal Enfield…"></div>
    <div class="fg"><label>Your Location</label><input type="text" id="joinLocation" placeholder="Dwarka, New Delhi"></div>
    <button class="mj-send-btn" onclick="sendJoinRequest()">Send Request →</button>
  </div>
</div>

<!-- TOAST -->
<div class="toast" id="toast"></div>

<script>
/* ── NAV ── */
function toggleMenu(){var m=document.getElementById('mobileMenu'),b=document.getElementById('hbBtn');m.classList.toggle('open');b.classList.toggle('open');document.body.style.overflow=m.classList.contains('open')?'hidden':'';}
function closeMenu(){document.getElementById('mobileMenu').classList.remove('open');document.getElementById('hbBtn').classList.remove('open');document.body.style.overflow='';}

/* ── TRIP DATA ── */
var TRIPS = {
  't1': {name:'Arjun Mehta',age:28,city:'Delhi',avatar:'AM',avatarColor:'#c1440e',from_city:'Delhi',to_city:'Goa',via:'Agra · Nagpur · Pune',date:'15 May 2026',days:6,vehicle:'Mahindra Thar',seats:2,plan:`Day 1: Delhi → Agra. Day 2: Agra → Nagpur. Day 3: Nagpur rest. Day 4–5: Nagpur → Pune → Goa. Day 6: Explore Goa.`,verified:true,distance:'~42 km away',match:'On your route',fb:'https://facebook.com',ig:'https://instagram.com'},
  't2': {name:'Priya Sharma',age:25,city:'Noida',avatar:'PS',avatarColor:'#2a7a6e',from_city:'Noida',to_city:'Manali',via:'Chandigarh · Kullu',date:'20 May 2026',days:8,vehicle:'Toyota Innova',seats:3,plan:`Classic Manali road trip via Chandigarh. Plan to cover Rohtang Pass, Solang Valley, and Old Manali. Flexible on pace.`,verified:true,distance:'~67 km away',match:'Near your location',fb:'https://facebook.com',ig:''},
  't3': {name:'Rohit Verma',age:32,city:'Gurgaon',avatar:'RV',avatarColor:'#e8a020',from_city:'Gurgaon',to_city:'Leh',via:'Manali Highway',date:'1 June 2026',days:14,vehicle:'Royal Enfield Himalayan + Support Car',seats:1,plan:`Full Leh-Ladakh circuit. Manali → Rohtang → Keylong → Jispa → Sarchu → Leh. Return via Srinagar.`,verified:true,distance:'~18 km away',match:'Nearby',fb:'',ig:'https://instagram.com'},
  't4': {name:'Sneha Patel',age:29,city:'Faridabad',avatar:'SP',avatarColor:'#7a2a6e',from_city:'Faridabad',to_city:'Ranthambore',via:'Agra Bypass',date:'10 May 2026',days:3,vehicle:'Swift Dzire',seats:2,plan:`Weekend trip to Ranthambore for tiger safari. 2 safaris booked. Comfortable pace, back by Sunday night.`,verified:false,distance:'~88 km away',match:'On your route',fb:'https://facebook.com',ig:'https://instagram.com'},
};

/* ── MODALS ── */
function openModal(id){document.getElementById(id).classList.add('open');document.body.style.overflow='hidden';}
function closeModal(id){document.getElementById(id).classList.remove('open');document.body.style.overflow='';}
function closeIfOut(e,id){if(e.target===document.getElementById(id))closeModal(id);}
document.addEventListener('keydown',function(e){if(e.key==='Escape')document.querySelectorAll('.overlay.open').forEach(function(o){o.classList.remove('open');});document.body.style.overflow='';  });

/* ── TOAST ── */
function showToast(msg){var t=document.getElementById('toast');t.textContent=msg;t.classList.add('show');setTimeout(function(){t.classList.remove('show');},3500);}

/* ── TRIP DETAIL ── */
var currentTripId='';
function openTrip(id){
  var t=TRIPS[id]; if(!t)return;
  currentTripId=id;
  document.getElementById('mdAvatar').textContent=t.avatar;
  document.getElementById('mdAvatar').style.background=t.avatarColor;
  document.getElementById('mdName').textContent=t.name+', '+t.age;
  document.getElementById('mdMeta').textContent=t.city+' · '+t.distance;
  document.getElementById('mdVerified').innerHTML=t.verified?'<span style="font-size:11px;color:var(--teal);background:rgba(42,122,110,.15);border:1px solid rgba(42,122,110,.3);padding:2px 10px;border-radius:20px;font-weight:600">✓ Verified Member</span>':'';
  document.getElementById('mdFrom').textContent=t.from_city;
  document.getElementById('mdTo').textContent=t.to_city;
  document.getElementById('mdVia').textContent='via '+t.via;
  document.getElementById('mdDate').textContent=t.date;
  document.getElementById('mdDays').textContent=t.days+' Days';
  document.getElementById('mdVehicle').textContent=t.vehicle;
  document.getElementById('mdSeats').textContent=t.seats+' seat'+(t.seats!==1?'s':'')+' available';
  document.getElementById('mdCity').textContent=t.city;
  document.getElementById('mdDist').textContent=t.distance;
  document.getElementById('mdPlan').textContent=t.plan;
  // Social links
  var socRow=document.getElementById('mdSocialRow');
  socRow.innerHTML='<span style="font-size:10px;letter-spacing:3px;text-transform:uppercase;color:rgba(255,255,255,.3);margin-right:8px">Connect on</span>';
  if(t.fb) socRow.innerHTML+='<a href="'+t.fb+'" target="_blank" class="soc-pill fb"><svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg> Facebook</a>';
  if(t.ig) socRow.innerHTML+='<a href="'+t.ig+'" target="_blank" class="soc-pill ig"><svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg> Instagram</a>';
  document.getElementById('mdJoinBtn').onclick=function(){closeModal('tripDetailOverlay');openJoinReq(id,t.name);};
  openModal('tripDetailOverlay');
}

/* ── POST TRIP ── */
function openPostTrip(){
  /* Check if user is logged in via Supabase session */
  /* WordPress: check if wp_get_current_user().ID > 0 */
  var isLoggedIn = (typeof supabase !== 'undefined' && supabase.auth && supabase.auth.getSession) ? false : false;
  // Demo mode: check localStorage for a session token
  var session = localStorage.getItem('fw_user_session') || sessionStorage.getItem('fw_user_session');
  if (session) {
    // User is logged in — open the post trip modal
    openModal('postTripOverlay');
  } else {
    // Not logged in — redirect to dashboard (login/register page)
    if (confirm('You need to be registered and logged in to post a trip.\n\nClick OK to go to the login page, or Cancel to register.')) {
      window.location.href = '<?php echo home_url("/dashboard/"); ?>';
    } else {
      // Open register modal
      if (typeof openRegModal === 'function') openRegModal();
    }
  }
}
/* ── VERIFICATION STATE ── */
var phoneOK=false, emailOK=false;
var socialConnected={FB:false,Google:false,IG:false,LI:false};
var socialCount=0;

function updateProgress(){
  var steps=0;
  if(phoneOK)steps++;
  if(emailOK)steps++;
  steps+=Math.min(socialCount,2);
  var total=4, pct=Math.round((steps/total)*100);
  document.getElementById('verifyProgress').style.width=pct+'%';
  var labels=['Complete verification to post trips','Phone verified — keep going!','Almost there!','One more social account!','✓ Fully verified — you can post trips!'];
  document.getElementById('verifyProgressLabel').textContent=labels[Math.min(steps,4)];
  document.getElementById('socialCount').textContent=Math.min(socialCount,2)+' / 2 connected';
}

function verifyPhone(){
  // In WordPress: POST /wp-json/freewheel/v1/send-otp → show OTP input modal
  if(phoneOK)return;
  alert('In the live site, this sends an SMS OTP to your registered mobile number.');
  setTimeout(function(){
    phoneOK=true;
    var step=document.getElementById('stepPhone');
    step.classList.add('verified');
    document.getElementById('phoneStatus').textContent='✓ Verified';
    document.getElementById('phoneBtn').textContent='✓';
    document.getElementById('phoneBtn').classList.add('done');
    document.getElementById('phoneBtn').onclick=null;
    updateProgress();
  },400);
}

function verifyEmail(){
  // In WordPress: POST /wp-json/freewheel/v1/send-email-otp → show OTP input modal
  if(emailOK)return;
  alert('In the live site, this sends a 6-digit OTP to your registered email address.');
  setTimeout(function(){
    emailOK=true;
    var step=document.getElementById('stepEmail');
    step.classList.add('verified');
    document.getElementById('emailStatus').textContent='✓ Verified';
    document.getElementById('emailBtn').textContent='✓';
    document.getElementById('emailBtn').classList.add('done');
    document.getElementById('emailBtn').onclick=null;
    updateProgress();
  },400);
}

function toggleSocial(platform){
  var el=document.getElementById('soc'+platform);
  var statusEl=document.getElementById('soc'+platform+'Status');
  if(socialConnected[platform]){
    // Disconnect
    socialConnected[platform]=false;
    socialCount--;
    el.classList.remove('connected');
    statusEl.textContent='Connect';
    // Un-grey others
    ['FB','Google','IG','LI'].forEach(function(p){
      if(!socialConnected[p]) document.getElementById('soc'+p).classList.remove('maxed');
    });
  } else {
    if(socialCount>=2){showToast('You have already connected 2 social accounts.');return;}
    // In WordPress: open OAuth flow for this platform
    // Facebook: window.location='/wp-json/freewheel/v1/oauth/facebook'
    // Google:   window.location='/wp-json/freewheel/v1/oauth/google'
    // Instagram: window.location='/wp-json/freewheel/v1/oauth/instagram'
    // LinkedIn:  window.location='/wp-json/freewheel/v1/oauth/linkedin'
    alert('In the live site, this opens '+platform+' OAuth to connect your account to your FreeWheel profile.');
    setTimeout(function(){
      socialConnected[platform]=true;
      socialCount++;
      el.classList.add('connected');
      statusEl.textContent='✓ Connected';
      if(socialCount>=2){
        ['FB','Google','IG','LI'].forEach(function(p){
          if(!socialConnected[p]) document.getElementById('soc'+p).classList.add('maxed');
        });
      }
      updateProgress();
    },400);
  }
}
function detectLocation(){
  if(navigator.geolocation){navigator.geolocation.getCurrentPosition(function(pos){document.getElementById('ptLocation').value='Detected: '+pos.coords.latitude.toFixed(4)+', '+pos.coords.longitude.toFixed(4);},function(){alert('Location access denied. Please enter your city manually.');});}
  else{alert('Geolocation not supported. Please enter your city manually.');};
}
function submitTrip(){
  var from=document.getElementById('ptFrom').value.trim();
  var to=document.getElementById('ptTo').value.trim();
  var date=document.getElementById('ptDate').value;
  var days=document.getElementById('ptDays').value;
  var vehicle=document.getElementById('ptVehicle').value.trim();
  var plan=document.getElementById('ptPlan').value.trim();
  if(!from||!to||!date||!days||!vehicle||!plan){alert('Please fill all required fields (marked with *).'); return;}
  // In WordPress: POST to /wp-json/freewheel/v1/trips with user auth token
  // Then trigger notification to users within 100km via Firebase
  closeModal('postTripOverlay');
  showToast('✅ Trip posted! Members near your route have been notified.');
}

/* ── JOIN REQUEST ── */
function openJoinReq(tripId,posterName){
  document.getElementById('joinSubtext').textContent='Request to join '+posterName+''s trip to '+( TRIPS[tripId] ? TRIPS[tripId].to_city : 'destination');
  openModal('joinReqOverlay');
}
function sendJoinRequest(){
  var msg=document.getElementById('joinMsg').value.trim();
  var veh=document.getElementById('joinVehicle').value.trim();
  if(!msg){alert('Please write a short message to the trip poster.');return;}
  // In WordPress: POST join request → notify poster via FCM/email
  closeModal('joinReqOverlay');
  showToast('✅ Join request sent! You'll be notified when they respond.');
}

/* ── FILTER ── */
function filterTrips(){
  var from=document.getElementById('filterFrom').value.toLowerCase();
  var to=document.getElementById('filterTo').value.toLowerCase();
  var cards=document.querySelectorAll('.trip-card');
  var visible=0;
  cards.forEach(function(card){
    var id=card.dataset.id;
    var t=TRIPS[id];
    if(!t){card.style.display='none';return;}
    var match=(!from||t.from_city.toLowerCase().includes(from))&&(!to||t.to_city.toLowerCase().includes(to));
    card.style.display=match?'flex':'none';
    if(match)visible++;
  });
  var grid=document.getElementById('tripsGrid');
  var empty=document.getElementById('emptyState');
  if(visible===0&&!empty){
    var div=document.createElement('div');div.id='emptyState';div.className='empty-state';
    div.innerHTML='<span class="empty-icon">🔍</span><div class="empty-h">No trips found</div><div class="empty-p">Try different search terms or clear the filters</div>';
    grid.appendChild(div);
  } else if(visible>0&&empty){empty.remove();}
}
function clearFilters(){document.getElementById('filterFrom').value='';document.getElementById('filterTo').value='';filterTrips();}
</script>

<script src="fw-data.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  if (typeof FW === 'undefined') return;

  /* ── RENDER TRIP CARDS from FW.buddyTrips ── */
  var grid = document.getElementById('tripsGrid');
  if(grid) {
    grid.innerHTML = FW.buddyTrips.map(function(t) {
      var socials = '';
      if(t.fb)  socials += '<a href="https://facebook.com" target="_blank" class="soc-link soc-fb" title="Facebook"><svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg></a>';
      if(t.ig)  socials += '<a href="https://instagram.com" target="_blank" class="soc-link soc-ig" title="Instagram"><svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg></a>';
      var verified = t.verified ? '<span class="verified-badge">✓ Verified</span>' : '';
      var tags = (t.tags||[]).map(function(tg){return '<span class="tt">'+tg+'</span>';}).join('');
      return '<div class="trip-card" data-id="'+t.id+'" data-from="'+t.from.toLowerCase()+'" data-to="'+t.to.toLowerCase()+'">' +
        '<div class="tc-header">' +
          '<div class="tc-user"><div class="tc-avatar" style="background:'+t.color+'">'+t.avatar+'</div>' +
          '<div class="tc-userinfo"><div class="tc-name">'+t.name+', '+t.age+' <span class="tc-city">· '+t.city+'</span></div>' +
          '<div class="tc-badges">'+verified+'<span class="match-badge">📍 '+t.match+'</span></div></div></div>' +
          '<div class="tc-social">'+socials+'</div>' +
        '</div>' +
        '<div class="tc-route"><div class="tc-from"><span class="route-dot dot-start"></span><span class="route-city">'+t.from+'</span></div>' +
          '<div class="tc-arrow">——→</div><div class="tc-to"><span class="route-dot dot-end"></span><span class="route-city">'+t.to+'</span></div></div>' +
        '<div class="tc-via">via '+t.via+'</div>' +
        '<div class="tc-meta"><div class="tc-meta-item">📅 '+t.date+'</div><div class="tc-meta-item">⏱ '+t.days+' Days</div>' +
          '<div class="tc-meta-item">🚗 '+t.vehicle+'</div><div class="tc-meta-item">👥 '+t.seats+' seat'+(t.seats!==1?'s':'')+'</div>' +
          '<div class="tc-meta-item">📍 '+t.distance+'</div></div>' +
        '<div class="tc-tags">'+tags+'</div>' +
        '<div class="tc-footer">' +
          '<button class="tc-view-btn" onclick="openTrip(''+t.id+'')">View Details</button>' +
          '<button class="tc-join-btn" onclick="openJoinReq(''+t.id+'',''+t.name+'')">Request to Join →</button>' +
        '</div>' +
      '</div>';
    }).join('');

    // Update TRIPS lookup from FW
    var TRIPS = {};
    FW.buddyTrips.forEach(function(t){TRIPS[t.id]=t;});
    window.TRIPS = TRIPS;
  }

  /* ── LIVE FILTER ── */
  window.filterTrips = function() {
    var from=(document.getElementById('filterFrom')||{}).value.toLowerCase().trim();
    var to=(document.getElementById('filterTo')||{}).value.toLowerCase().trim();
    var visible=0;
    document.querySelectorAll('.trip-card').forEach(function(c){
      var id=c.dataset.id, t=window.TRIPS[id];
      if(!t){c.style.display='none';return;}
      var match=(!from||t.from.toLowerCase().includes(from))&&(!to||t.to.toLowerCase().includes(to));
      c.style.display=match?'':'none';
      if(match)visible++;
    });
    var empty=document.getElementById('emptyState');
    if(visible===0&&!empty){
      var d=document.createElement('div');d.id='emptyState';d.className='empty-state';
      d.innerHTML='<span class="empty-icon">🔍</span><div class="empty-h">No trips found</div><div class="empty-p">Try different search terms</div>';
      document.getElementById('tripsGrid').appendChild(d);
    } else if(visible>0&&empty) empty.remove();
  };
  window.clearFilters=function(){document.getElementById('filterFrom').value='';document.getElementById('filterTo').value='';filterTrips();};

  /* ── STICKY NAV + REVEAL ── */
  window.addEventListener('scroll',function(){var n=document.querySelector('nav');if(n)n.style.boxShadow=window.scrollY>20?'0 4px 24px rgba(0,0,0,.5)':'';});
  if('IntersectionObserver' in window){
    var st=document.createElement('style');st.textContent='.trip-card{opacity:0;transform:translateY(18px);transition:opacity .5s ease,transform .5s ease}.trip-card.visible{opacity:1;transform:none}';document.head.appendChild(st);
    var o=new IntersectionObserver(function(e){e.forEach(function(en){if(en.isIntersecting){en.target.classList.add('visible');o.unobserve(en.target);}});},{threshold:0.08});
    setTimeout(function(){document.querySelectorAll('.trip-card').forEach(function(c){o.observe(c);});},200);
  }
});
</script>

<?php get_footer(); ?>

<!-- ═══ AUTH GATE — OTP VERIFICATION MODAL ═══ -->
<div class="overlay" id="authGateOverlay" onclick="closeIfOut(event,'authGateOverlay')">
  <div class="modal-detail" style="max-width:440px">
    <button class="modal-close" onclick="closeModal('authGateOverlay')">✕</button>

    <!-- STEP 1: Phone Entry -->
    <div id="agStep1">
      <div class="mdh">
        <div class="mdh-name" style="font-size:20px">Sign In to Post a Trip</div>
        <div class="mdh-meta">Enter your registered mobile number</div>
      </div>
      <div class="mdb">
        <div style="display:flex;gap:0;margin-bottom:14px">
          <span style="padding:13px 14px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.1);border-right:none;color:rgba(255,255,255,.5);font-size:14px;border-radius:2px 0 0 2px">🇮🇳 +91</span>
          <input type="tel" id="agPhone" maxlength="10" placeholder="98765 43210" 
            style="flex:1;padding:13px 14px;border:1px solid rgba(255,255,255,.1);background:rgba(255,255,255,.05);font-size:15px;color:#fff;outline:none;border-radius:0 2px 2px 0"
            oninput="this.value=this.value.replace(/\D/g,'')">
        </div>
        <div id="agPhoneErr" style="display:none;background:rgba(193,68,14,.15);border:1px solid rgba(193,68,14,.3);padding:9px 14px;font-size:12px;color:#e07050;border-radius:2px;margin-bottom:12px"></div>
        <button class="modal-join-btn" onclick="agSendOTP()">Send OTP →</button>
        <div style="text-align:center;margin-top:14px;font-size:12px;color:rgba(255,255,255,.3)">
          Not registered? <a href="#" onclick="closeModal('authGateOverlay');openRegModal();return false;" style="color:var(--amber)">Create free account</a>
        </div>
      </div>
    </div>

    <!-- STEP 2: OTP Entry -->
    <div id="agStep2" style="display:none">
      <div class="mdh">
        <div class="mdh-name" style="font-size:20px">Enter OTP</div>
        <div class="mdh-meta" id="agOTPSubtext">OTP sent to +91 XXXXXXXXXX</div>
      </div>
      <div class="mdb">
        <div style="display:flex;gap:8px;justify-content:center;margin-bottom:14px">
          <input type="tel" class="ag-otp-box" maxlength="1" id="ag1" oninput="agOTPMove(this,'ag2')" onkeydown="agBack(event,this,'ag1')">
          <input type="tel" class="ag-otp-box" maxlength="1" id="ag2" oninput="agOTPMove(this,'ag3')" onkeydown="agBack(event,this,'ag1')">
          <input type="tel" class="ag-otp-box" maxlength="1" id="ag3" oninput="agOTPMove(this,'ag4')" onkeydown="agBack(event,this,'ag2')">
          <input type="tel" class="ag-otp-box" maxlength="1" id="ag4" oninput="agOTPMove(this,'ag5')" onkeydown="agBack(event,this,'ag3')">
          <input type="tel" class="ag-otp-box" maxlength="1" id="ag5" oninput="agOTPMove(this,'ag6')" onkeydown="agBack(event,this,'ag4')">
          <input type="tel" class="ag-otp-box" maxlength="1" id="ag6" oninput="agOTPMove(this,null)"  onkeydown="agBack(event,this,'ag5')">
        </div>
        <div style="text-align:center;font-size:12px;color:rgba(255,255,255,.35);margin-bottom:16px">
          <span id="agTimerTxt">Resend in <strong id="agTimer">30s</strong></span>
          <span id="agResend" style="display:none;color:var(--amber);cursor:pointer" onclick="agSendOTP()">Resend OTP</span>
        </div>
        <div id="agOTPErr" style="display:none;background:rgba(193,68,14,.15);border:1px solid rgba(193,68,14,.3);padding:9px 14px;font-size:12px;color:#e07050;border-radius:2px;margin-bottom:12px"></div>
        <button class="modal-join-btn" onclick="agVerifyOTP()" id="agVerifyBtn">Verify & Continue →</button>
        <div style="text-align:center;margin-top:10px"><a href="#" onclick="agBack2Phone();return false;" style="font-size:12px;color:rgba(255,255,255,.35)">← Change number</a></div>
      </div>
    </div>

    <!-- STEP 3: Verification complete -->
    <div id="agStep3" style="display:none">
      <div class="mdb" style="text-align:center;padding:40px 28px">
        <div style="font-size:52px;margin-bottom:16px">✅</div>
        <div style="font-family:var(--headline);font-size:24px;color:#fff;letter-spacing:1px;margin-bottom:8px">Verified!</div>
        <div style="font-size:13px;color:rgba(255,255,255,.5);margin-bottom:24px">Opening Post a Trip form...</div>
      </div>
    </div>
  </div>
</div>

<style>
.ag-otp-box{width:46px;height:54px;text-align:center;font-family:var(--headline);font-size:26px;border:1px solid rgba(255,255,255,.15);background:rgba(255,255,255,.05);color:#fff;outline:none;border-radius:2px;transition:border-color .2s}
.ag-otp-box:focus{border-color:var(--amber);background:rgba(232,160,32,.08)}
.ag-otp-box.filled{border-color:var(--teal)}
@media(max-width:400px){.ag-otp-box{width:38px;height:46px;font-size:20px}}
</style>

<script>
var agPhone='', agOTPCode='123456', agTimer=null; // Demo OTP: 123456

function openPostTrip(){
  var session = localStorage.getItem('fw_user_session');
  if(session){
    try{
      var s=JSON.parse(session);
      if(s.phone && s.phoneVerified){
        openModal('postTripOverlay'); return;
      }
    }catch(e){}
  }
  // Not logged in or not verified — show auth gate
  document.getElementById('agStep1').style.display='block';
  document.getElementById('agStep2').style.display='none';
  document.getElementById('agStep3').style.display='none';
  openModal('authGateOverlay');
}

function agSendOTP(){
  var ph = (document.getElementById('agPhone')||{}).value||'';
  var err = document.getElementById('agPhoneErr');
  ph = ph.replace(/\D/g,'');
  if(!/^[6-9]\d{9}$/.test(ph)){
    err.textContent='Please enter a valid 10-digit mobile number.';
    err.style.display='block'; return;
  }
  err.style.display='none';
  agPhone = ph;
  // WordPress/Supabase: POST send-otp to {phone: ph}
  // Demo mode: OTP is 123456
  agOTPCode = '123456';
  document.getElementById('agOTPSubtext').textContent='OTP sent to +91 '+ph.slice(0,5)+' '+ph.slice(5)+' (Demo: 123456)';
  document.getElementById('agStep1').style.display='none';
  document.getElementById('agStep2').style.display='block';
  ['ag1','ag2','ag3','ag4','ag5','ag6'].forEach(function(id){var el=document.getElementById(id);el.value='';el.classList.remove('filled');});
  document.getElementById('ag1').focus();
  agStartTimer(30);
}
function agOTPMove(el,nextId){
  el.value=el.value.replace(/\D/g,'');
  el.classList.toggle('filled',el.value!=='');
  if(el.value&&nextId)document.getElementById(nextId).focus();
}
function agBack(e,el,prevId){if(e.key==='Backspace'&&!el.value)document.getElementById(prevId).focus();}
function agBack2Phone(){document.getElementById('agStep1').style.display='block';document.getElementById('agStep2').style.display='none';}
function agStartTimer(sec){
  clearInterval(agTimer);
  var s=sec;
  document.getElementById('agTimerTxt').style.display='inline';
  document.getElementById('agResend').style.display='none';
  agTimer=setInterval(function(){
    s--;document.getElementById('agTimer').textContent=s+'s';
    if(s<=0){clearInterval(agTimer);document.getElementById('agTimerTxt').style.display='none';document.getElementById('agResend').style.display='inline';}
  },1000);
}
function agVerifyOTP(){
  var entered=['ag1','ag2','ag3','ag4','ag5','ag6'].map(function(id){return document.getElementById(id).value;}).join('');
  var err=document.getElementById('agOTPErr');
  if(entered.length<6){err.textContent='Please enter the complete 6-digit OTP.';err.style.display='block';return;}
  if(entered!==agOTPCode){
    err.textContent='Incorrect OTP. Please try again.';err.style.display='block';
    ['ag1','ag2','ag3','ag4','ag5','ag6'].forEach(function(id){document.getElementById(id).style.borderColor='var(--rust)';});
    return;
  }
  err.style.display='none';
  // Save verified session
  var session={phone:agPhone,phoneVerified:true,ts:Date.now()};
  try{
    var existing=JSON.parse(localStorage.getItem('fw_user_session')||'{}');
    localStorage.setItem('fw_user_session',JSON.stringify(Object.assign(existing,session)));
  }catch(e){localStorage.setItem('fw_user_session',JSON.stringify(session));}
  // Show success step
  document.getElementById('agStep2').style.display='none';
  document.getElementById('agStep3').style.display='block';
  setTimeout(function(){closeModal('authGateOverlay');openModal('postTripOverlay');},1500);
}
</script>
