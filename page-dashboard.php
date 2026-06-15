<?php
/**
 * Template Name: My Dashboard
 * Template Post Type: page
 */
get_header(); ?>
<style>
html,body,body.page,#page,#content,#primary,#main,.site,.site-content,.entry-content,.wp-site-blocks,main,article{background:#0a0805!important;background-color:#0a0805!important;color:#fff!important}
.entry-content,.page-content,#primary,#main,main{padding:0!important;margin:0!important;max-width:100%!important;width:100%!important}
.site-header,.wp-block-template-part[class*="header"]{display:none!important}
/* Kill ALL white backgrounds from theme/plugins */
.profile-card,.profile-card *,.pfield,.profile-grid,.profile-card-head,.profile-save-row{background-color:#111008!important;color:#fff!important}
div,section,article,aside,main,header,footer{background-color:transparent}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
/* Force dark everywhere — kill any plugin/theme white bg */
body *:not(img):not(svg):not(path):not(circle):not(input):not(button):not(a){background-color:transparent}
.profile-card{background:#111008!important}
.profile-card-head{background:#1a1610!important;padding:18px 22px;border-bottom:2px solid rgba(255,165,0,.15)}
.pfield{background:#111008!important}
.profile-grid{background:rgba(255,165,0,.08)!important}
:root{--ink:#0a0805;--rust:#c1440e;--amber:#e8a020;--teal:#2a7a6e;--body:'Barlow',sans-serif;--headline:'Bebas Neue',sans-serif}
body{font-family:var(--body);background:#0a0805!important;color:#fff;overflow-x:hidden}

/* AUTH LOADING */
#fwAuthGate{min-height:100vh;display:flex;align-items:center;justify-content:center;background:var(--ink)}
.gate-spinner{width:40px;height:40px;border:3px solid rgba(255,255,255,.1);border-top-color:var(--rust);border-radius:50%;animation:spin .8s linear infinite}
@keyframes spin{to{transform:rotate(360deg)}}

/* DASHBOARD HIDDEN UNTIL AUTH */
#fwDash{display:none;min-height:100vh;padding-top:64px;background:#0a0805}

/* ── BANNER ── */
.dash-banner{background:linear-gradient(135deg,#111008,#1e1610);border-bottom:1px solid rgba(255,255,255,.1);padding:36px 5vw}
.dash-banner-inner{max-width:1200px;margin:0 auto;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:16px}
.dash-user-block{display:flex;align-items:center;gap:20px}

/* Avatar with upload */
.avatar-wrap{position:relative;cursor:pointer;flex-shrink:0}
.user-avatar{width:76px;height:76px;border-radius:50%;object-fit:cover;border:3px solid var(--amber);background:linear-gradient(135deg,var(--rust),var(--amber));display:flex;align-items:center;justify-content:center;font-family:var(--headline);font-size:30px;color:#fff}
.avatar-overlay{position:absolute;inset:0;border-radius:50%;background:rgba(0,0,0,.55);display:flex;align-items:center;justify-content:center;opacity:0;transition:opacity .2s;font-size:20px}
.avatar-wrap:hover .avatar-overlay{opacity:1}
#avatarInput{display:none}

.user-greeting .gtag{font-size:10px;letter-spacing:3px;text-transform:uppercase;color:var(--amber);opacity:.7;margin-bottom:4px}
.user-greeting h1{font-family:var(--headline);font-size:clamp(32px,4vw,52px);color:#fff;letter-spacing:1px;line-height:1}
.user-greeting .usub{font-size:14px;color:rgba(255,255,255,.5);font-weight:300;margin-top:4px}
.logout-btn{padding:9px 22px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.2);color:rgba(255,255,255,.7);font-size:11px;font-weight:600;letter-spacing:2px;text-transform:uppercase;cursor:pointer;border-radius:3px;transition:all .2s}
.logout-btn:hover{background:var(--rust);border-color:var(--rust);color:#fff}

/* ── STATS ── */
.dash-stats{background:#0d0b07;border-bottom:1px solid rgba(255,255,255,.08)}
.dash-stats-inner{max-width:1200px;margin:0 auto;display:flex;flex-wrap:wrap}
.dstat{flex:1;min-width:110px;padding:22px 24px;border-right:1px solid rgba(255,255,255,.07);text-align:center}
.dstat:last-child{border-right:none}
.dstat-n{font-family:var(--headline);font-size:40px;color:var(--amber);line-height:1;margin-bottom:4px}
.dstat-l{font-size:10px;letter-spacing:3px;text-transform:uppercase;color:rgba(255,255,255,.4)}

/* ── LOYALTY ── */
.loyalty-band{background:linear-gradient(135deg,var(--teal),#1a5a50);padding:14px 5vw}
.loyalty-band-inner{max-width:1200px;margin:0 auto;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px}
.lb-badge{font-family:var(--headline);font-size:13px;color:var(--amber);letter-spacing:3px;text-transform:uppercase;background:rgba(0,0,0,.25);padding:6px 14px;border-radius:20px}
.lb-text{font-size:14px;color:rgba(255,255,255,.9);font-weight:300}
.lb-text strong{color:#fff}
.lb-disc{font-family:var(--headline);font-size:26px;color:var(--amber)}

/* ── CONTENT ── */
.dash-content{max-width:1200px;margin:0 auto;padding:24px 5vw}
.dash-section{margin-bottom:40px}
.dash-section-title{font-family:var(--headline);font-size:28px;color:#fff;letter-spacing:1px;margin-bottom:22px;display:flex;align-items:center;gap:14px}
.dash-section-title::after{content:'';flex:1;height:1px;background:rgba(255,255,255,.1)}

/* ── PROFILE CARD ── */
.profile-card{background:#111008;border:1px solid rgba(255,255,255,.1);border-radius:6px;overflow:hidden}
.profile-card-head{padding:18px 22px;border-bottom:1px solid rgba(255,255,255,.08);display:flex;justify-content:space-between;align-items:center;background:#111008}
.profile-card-head span{font-size:11px;letter-spacing:2px;text-transform:uppercase;color:rgba(255,255,255,.5)}
.edit-btn{padding:7px 18px;border:1px solid var(--amber);background:transparent;color:var(--amber);font-size:11px;letter-spacing:2px;text-transform:uppercase;cursor:pointer;border-radius:2px;transition:all .2s}
.edit-btn:hover{background:var(--amber);color:#000}
.profile-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:1px;background:rgba(255,255,255,.08)}
.pfield{background:#111008!important;padding:18px 22px}
.pf-label{font-size:9px;letter-spacing:3px;text-transform:uppercase;color:var(--amber);margin-bottom:6px;opacity:.7}
.pf-val{font-size:15px;color:#fff!important;font-weight:400;line-height:1.4}
.pf-input{width:100%;padding:9px 12px;border:1px solid rgba(255,255,255,.2);background:#1a1610!important;color:#fff!important;font-family:var(--body);font-size:14px;border-radius:3px;outline:none}
.pf-input:focus{border-color:var(--rust)}
.profile-save-row{padding:16px 22px;background:#111008;border-top:1px solid rgba(255,255,255,.08);display:none;gap:12px;align-items:center}
.save-btn{padding:11px 28px;background:var(--rust);color:#fff;border:none;font-family:var(--headline);font-size:18px;letter-spacing:1px;cursor:pointer;border-radius:3px;transition:background .2s}
.save-btn:hover{background:#a03508}
.cancel-btn{padding:11px 20px;background:transparent;border:1px solid rgba(255,255,255,.2);color:rgba(255,255,255,.6);font-size:12px;cursor:pointer;border-radius:3px;transition:all .2s}
.cancel-btn:hover{border-color:#fff;color:#fff}

/* ── TRIP CARDS ── */
.trip-hist-card{background:#0a0805;border:1px solid rgba(255,255,255,.06);border-radius:4px;margin-bottom:10px;overflow:hidden}
.thc-top{display:grid;grid-template-columns:64px 1fr auto;align-items:center}
.thc-num{font-family:var(--headline);font-size:36px;color:rgba(193,68,14,.25);text-align:center;padding:16px;border-right:1px solid rgba(255,255,255,.05);line-height:1}
.thc-body{padding:16px 20px}
.thc-date{font-size:10px;letter-spacing:3px;text-transform:uppercase;color:rgba(255,255,255,.25);margin-bottom:3px}
.thc-name{font-family:var(--headline);font-size:20px;color:#fff;letter-spacing:1px;margin-bottom:6px}
.thc-tags{display:flex;gap:6px;flex-wrap:wrap}
.thc-tag{font-size:10px;padding:3px 9px;background:rgba(255,255,255,.06);color:rgba(255,255,255,.4);border-radius:2px}
.thc-right{padding:16px 18px;text-align:right;display:flex;flex-direction:column;align-items:flex-end;gap:8px}
.thc-status{font-size:10px;letter-spacing:2px;text-transform:uppercase;padding:4px 10px;border-radius:20px;font-weight:600}
.thc-status.done{background:rgba(42,122,110,.2);color:var(--teal);border:1px solid rgba(42,122,110,.3)}
.thc-status.upcoming{background:rgba(193,68,14,.15);color:var(--rust);border:1px solid rgba(193,68,14,.3)}
.album-toggle{font-size:10px;letter-spacing:1px;text-transform:uppercase;color:rgba(255,255,255,.3);cursor:pointer;background:none;border:none;padding:0;transition:color .2s}
.album-toggle:hover{color:var(--amber)}

/* ── TRIP ALBUM ── */
.trip-album{display:none;padding:16px 20px;border-top:1px solid rgba(255,255,255,.06);background:#080604}
.album-label{font-size:10px;letter-spacing:2px;text-transform:uppercase;color:rgba(255,255,255,.25);margin-bottom:12px}
.album-grid{display:grid;grid-template-columns:repeat(6,1fr);gap:6px}
.album-slot{aspect-ratio:1;border-radius:3px;overflow:hidden;position:relative;background:rgba(255,255,255,.04);border:1px dashed rgba(255,255,255,.1);cursor:pointer;transition:border-color .2s}
.album-slot:hover{border-color:var(--amber)}
.album-slot img{width:100%;height:100%;object-fit:cover;display:block}
.album-slot-empty{display:flex;align-items:center;justify-content:center;height:100%;font-size:22px;opacity:.25}
.album-slot-overlay{position:absolute;inset:0;background:rgba(0,0,0,.5);display:flex;align-items:center;justify-content:center;opacity:0;transition:opacity .2s;font-size:16px}
.album-slot:hover .album-slot-overlay{opacity:1}
.album-upload-note{font-size:11px;color:rgba(255,255,255,.2);margin-top:8px;font-weight:300}

/* ── ORDERS ── */
.order-card{background:#0a0805;border:1px solid rgba(255,255,255,.06);border-radius:4px;padding:18px 22px;margin-bottom:8px;display:flex;align-items:center;gap:18px}
.order-icon{font-size:32px;flex-shrink:0}
.order-body{flex:1}
.order-name{font-family:var(--headline);font-size:18px;color:#fff;letter-spacing:.5px;margin-bottom:3px}
.order-meta{font-size:12px;color:rgba(255,255,255,.3);font-weight:300}
.order-price{font-family:var(--headline);font-size:22px;color:var(--amber)}
.empty-state{background:#0a0805;border:1px dashed rgba(255,255,255,.07);border-radius:4px;padding:48px;text-align:center}
.empty-icon{font-size:48px;opacity:.2;display:block;margin-bottom:12px}
.empty-h{font-family:var(--headline);font-size:22px;color:rgba(255,255,255,.3);letter-spacing:1px;margin-bottom:6px}
.empty-p{font-size:13px;color:rgba(255,255,255,.2);font-weight:300}

/* ── TOAST ── */
.fw-toast{position:fixed;bottom:24px;right:24px;background:#1a1208;border-left:3px solid var(--teal);padding:14px 20px;font-size:13px;color:#fff;border-radius:2px;z-index:9999;transform:translateY(80px);opacity:0;transition:all .3s;max-width:280px}
.fw-toast.show{transform:translateY(0);opacity:1}
.fw-toast.err{border-color:var(--rust)}

@media(max-width:800px){.profile-grid{grid-template-columns:repeat(2,1fr)}.thc-top{grid-template-columns:50px 1fr}.thc-right{grid-column:1/-1;flex-direction:row;justify-content:space-between;padding:10px 16px;border-top:1px solid rgba(255,255,255,.05)}.album-grid{grid-template-columns:repeat(3,1fr)}}
@media(max-width:480px){.profile-grid{grid-template-columns:1fr}.dash-stats-inner{flex-wrap:wrap}.dstat{flex:0 0 50%}}

/* ── Titles Track ── */
#titlesTrackBanner{position:relative}
#titlesTrackBanner::before{content:'';position:absolute;top:22px;left:5%;right:5%;height:2px;background:rgba(255,255,255,.08);z-index:0}
.title-node{flex:1;min-width:90px;max-width:130px;display:flex;flex-direction:column;align-items:center;position:relative}
.title-node:not(:last-child)::after{content:'';position:absolute;top:32px;left:calc(50% + 28px);width:calc(100% - 56px);height:2px;background:rgba(255,255,255,.1);z-index:0}
.title-node.earned:not(:last-child)::after{background:var(--rust);opacity:.6}
.title-badge{width:64px;height:64px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:24px;position:relative;z-index:1;border:3px solid;transition:transform .2s}
.title-badge.locked{background:rgba(255,255,255,.04);border-color:rgba(255,255,255,.1);filter:grayscale(1);opacity:.4}
.title-badge.earned{box-shadow:0 0 18px rgba(193,68,14,.5);transform:scale(1.05)}
.title-badge.current{box-shadow:0 0 24px var(--amber);animation:pulse-title 2s ease-in-out infinite;transform:scale(1.12)}
@keyframes pulse-title{0%,100%{box-shadow:0 0 18px var(--amber)}50%{box-shadow:0 0 32px var(--amber),0 0 48px rgba(232,160,32,.4)}}
.title-label{font-size:10px;letter-spacing:1px;text-align:center;margin-top:8px;line-height:1.3;text-transform:uppercase}
.title-trips{font-size:9px;letter-spacing:1px;text-align:center;margin-top:3px;opacity:.5}
</style>

<!-- Auth gate spinner -->
<div id="fwAuthGate"><div class="gate-spinner"></div></div>
<style>
/* Hide login/register from nav when on dashboard */
.nav-login, .nav-cta, .mob-cta { display: none !important; }
</style>

<!-- Dashboard (shown after auth check) -->
<div id="fwDash">

  <!-- Banner -->
  <div class="dash-banner">
    <div class="dash-banner-inner">
      <div class="dash-user-block">
        <div class="avatar-wrap" onclick="document.getElementById('avatarInput').click()">
          <div class="user-avatar" id="userAvatarEl">?</div>
          <div class="avatar-overlay">📷</div>
          <input type="file" id="avatarInput" accept="image/*" onchange="uploadAvatar(this)">
        </div>
        <div class="user-greeting">
          <div class="gtag">Welcome Back</div>
          <h1 id="greetName">—</h1>
          <div class="usub" id="greetSub">—</div>
        </div>
      </div>

    </div>
  </div>

  <!-- Stats -->
  <div class="dash-stats">
    <div class="dash-stats-inner">
      <div class="dstat"><div class="dstat-n" id="statTrips">0</div><div class="dstat-l">Trips Booked</div></div>
      <div class="dstat"><div class="dstat-n" id="statOrders">0</div><div class="dstat-l">Orders</div></div>
      <div class="dstat" style="cursor:default;position:relative" id="creditStatCard">
        <div class="dstat-n" id="statCredits">0</div>
        <div class="dstat-l">Total Credits</div>
        <div id="creditStatDetail" style="display:none;position:absolute;top:100%;left:50%;transform:translateX(-50%);width:280px;background:#0a1a0a;border:1px solid rgba(34,197,94,.4);border-radius:4px;padding:18px;z-index:100;margin-top:8px;text-align:left">
          <div style="font-family:var(--headline);font-size:24px;color:#4ade80;margin-bottom:4px" id="creditValueStat">&#8377;0.00</div>
          <div style="font-size:11px;color:rgba(255,255,255,.4);margin-bottom:12px">Redeemable value</div>
          <div style="font-size:12px;color:rgba(255,255,255,.7);line-height:1.6;margin-bottom:10px" id="creditRedeemNote">Loading...</div>
          <div style="font-size:10px;color:rgba(255,255,255,.3);line-height:1.7">1 credit = &#8377;0.25 &middot; Min. 400 credits to redeem &middot; Credits valid 12 months</div>
        </div>
      </div>
      <div class="dstat"><div class="dstat-n" id="statDisc">—</div><div class="dstat-l">My Discount</div></div>
    </div>
  </div>


  <!-- Titles Track -->
  <div style="padding:16px 0 20px;background:#0a0805;border-top:1px solid rgba(255,255,255,.05);border-bottom:1px solid rgba(255,255,255,.05)">
    <div style="max-width:100%;padding:0 5vw">
      <div style="font-size:10px;letter-spacing:3px;text-transform:uppercase;color:rgba(255,255,255,.3);margin-bottom:14px">Your Expedition Title</div>
      <div id="titlesTrackBanner" style="display:flex;gap:0;width:100%;justify-content:space-between;align-items:flex-start"></div>
    </div>
  </div>


  <!-- Main -->
  <div class="dash-content">

    <!-- Profile Edit Panel (hidden by default, triggered from banner) -->
    <div id="profilePanel" style="display:none" class="dash-section">
      <div style="font-family:var(--headline);font-size:22px;color:#fff;letter-spacing:1px;margin-bottom:20px">Edit Profile</div>
      <div style="background:#0f0d0b;border:1px solid rgba(193,68,14,.3);border-radius:2px;padding:28px">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:14px">
          <div><label style="font-size:10px;letter-spacing:1px;color:rgba(255,255,255,.4);text-transform:uppercase;display:block;margin-bottom:5px">First Name</label><input type="text" id="epFirst" style="width:100%;box-sizing:border-box;padding:11px 13px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.12);color:#fff;font-family:var(--body);font-size:14px;border-radius:2px;outline:none"></div>
          <div><label style="font-size:10px;letter-spacing:1px;color:rgba(255,255,255,.4);text-transform:uppercase;display:block;margin-bottom:5px">Last Name</label><input type="text" id="epLast" style="width:100%;box-sizing:border-box;padding:11px 13px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.12);color:#fff;font-family:var(--body);font-size:14px;border-radius:2px;outline:none"></div>
          <div><label style="font-size:10px;letter-spacing:1px;color:rgba(255,255,255,.4);text-transform:uppercase;display:block;margin-bottom:5px">City</label><input type="text" id="epCity" style="width:100%;box-sizing:border-box;padding:11px 13px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.12);color:#fff;font-family:var(--body);font-size:14px;border-radius:2px;outline:none"></div>
          <div><label style="font-size:10px;letter-spacing:1px;color:rgba(255,255,255,.4);text-transform:uppercase;display:block;margin-bottom:5px">State</label><input type="text" id="epState" style="width:100%;box-sizing:border-box;padding:11px 13px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.12);color:#fff;font-family:var(--body);font-size:14px;border-radius:2px;outline:none"></div>
          <div><label style="font-size:10px;letter-spacing:1px;color:rgba(255,255,255,.4);text-transform:uppercase;display:block;margin-bottom:5px">Country</label><input type="text" id="epCountry" style="width:100%;box-sizing:border-box;padding:11px 13px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.12);color:#fff;font-family:var(--body);font-size:14px;border-radius:2px;outline:none"></div>
          <div style="grid-column:1/-1"><label style="font-size:10px;letter-spacing:1px;color:rgba(255,255,255,.4);text-transform:uppercase;display:block;margin-bottom:5px">Instagram Handle <span style="color:rgba(255,255,255,.25);font-weight:300;font-size:9px">(optional · e.g. @yourusername)</span></label><input type="text" id="epInstagram" placeholder="@yourusername" style="width:100%;box-sizing:border-box;padding:11px 13px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.12);color:#fff;font-family:var(--body);font-size:14px;border-radius:2px;outline:none"></div>
        </div>
        <div style="display:flex;gap:10px;margin-top:8px">
          <button onclick="saveProfile()" style="padding:11px 24px;background:var(--rust);border:none;color:#fff;font-family:var(--headline);font-size:14px;letter-spacing:1px;cursor:pointer;border-radius:2px">SAVE CHANGES</button>
          <button onclick="openEditProfile()" style="padding:11px 18px;background:rgba(255,255,255,.06);border:none;color:rgba(255,255,255,.5);font-family:var(--body);font-size:14px;cursor:pointer;border-radius:2px">Cancel</button>
        </div>
        <div id="profileMsg" style="font-size:12px;margin-top:10px"></div>
      </div>
    </div>

    <!-- Hidden field holders for render ── no visual output -->
    <span id="dpFirst" style="display:none"></span>
    <span id="dpLast" style="display:none"></span>
    <span id="dpEmail" style="display:none"></span>
    <span id="dpPhone" style="display:none"></span>
    <span id="dpCity" style="display:none"></span>
    <span id="dpState" style="display:none"></span>
    <span id="dpCountry" style="display:none"></span>
    <span id="dpSince" style="display:none"></span>
    <span id="creditBalance" style="display:none"></span>
    <span id="creditValue" style="display:none"></span>

    <!-- Trips -->
    <div class="dash-section">
      <div class="dash-section-title">My Expeditions</div>
      <div id="tripHistory"></div>
    </div>

    <!-- Orders -->
    <div class="dash-section">
      <div class="dash-section-title">Merchandise Orders</div>
      <div id="orderHistory"></div>


    <!-- ALBUMS -->
    <div class="dash-section">
      <div class="dash-section-title">My Trip Albums <span style="font-size:13px;color:rgba(255,255,255,.35);font-family:var(--body);letter-spacing:0;font-weight:300">Max 6 photos per album · Earns 50 credits on approval</span></div>
      <div id="albumList"></div>
      <div style="margin-top:20px">
        <button onclick="openNewAlbum()" style="display:inline-flex;align-items:center;gap:8px;padding:11px 22px;background:var(--rust);border:none;color:#fff;font-family:var(--headline);font-size:14px;letter-spacing:1px;cursor:pointer;border-radius:2px">+ CREATE NEW ALBUM</button>
      </div>
      <!-- New Album Form -->
      <div id="newAlbumForm" style="display:none;margin-top:24px;background:#0f0d0b;border:1px solid rgba(255,255,255,.1);padding:24px;border-radius:2px">
        <div style="font-size:12px;letter-spacing:2px;color:var(--rust);text-transform:uppercase;margin-bottom:16px">New Album</div>
        <div style="margin-bottom:14px">
          <input type="text" id="albumTitle" placeholder="Album title (e.g. Winter Spiti 2026)" style="width:100%;box-sizing:border-box;padding:11px 14px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.12);color:#fff;font-family:var(--body);font-size:14px;border-radius:2px;outline:none">
        </div>
        <div style="margin-bottom:14px">
          <input type="text" id="albumTripName" placeholder="Trip name (e.g. Leh Ladakh)" style="width:100%;box-sizing:border-box;padding:11px 14px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.12);color:#fff;font-family:var(--body);font-size:14px;border-radius:2px;outline:none">
        </div>
        <label style="display:flex;align-items:flex-start;gap:12px;margin-bottom:16px;cursor:pointer;padding:14px;background:rgba(42,122,110,.08);border:1px solid rgba(42,122,110,.25);border-radius:2px">
          <input type="checkbox" id="albumIsPublic" style="width:18px;height:18px;margin-top:2px;accent-color:var(--teal);cursor:pointer;flex-shrink:0">
          <div>
            <div style="font-size:13px;color:#fff;font-weight:500">Share publicly on Community page</div>
            <div style="font-size:11px;color:rgba(255,255,255,.45);margin-top:3px;line-height:1.5">Your album will appear in the Community photo carousel visible to all visitors. Only approved albums are shown.</div>
          </div>
        </label>
        <div style="display:flex;gap:10px">
          <button onclick="submitNewAlbum()" style="padding:10px 20px;background:var(--rust);border:none;color:#fff;font-family:var(--headline);font-size:14px;letter-spacing:1px;cursor:pointer;border-radius:2px">CREATE ALBUM</button>
          <button onclick="document.getElementById('newAlbumForm').style.display='none'" style="padding:10px 20px;background:rgba(255,255,255,.08);border:none;color:#fff;font-family:var(--body);font-size:14px;cursor:pointer;border-radius:2px">Cancel</button>
        </div>
        <div id="albumFormMsg" style="font-size:12px;margin-top:10px;color:#f87171"></div>
      </div>
    </div>

    <!-- TESTIMONIALS -->
    <div class="dash-section">
      <div class="dash-section-title">Write a Testimonial <span style="font-size:13px;color:rgba(255,255,255,.35);font-family:var(--body);letter-spacing:0;font-weight:300">Earns 75 credits on approval</span></div>
      <div id="testimonialList"></div>
      <div style="margin-top:20px;background:#0f0d0b;border:1px solid rgba(255,255,255,.1);padding:24px;border-radius:2px">
        <div style="font-size:12px;letter-spacing:2px;color:var(--rust);text-transform:uppercase;margin-bottom:16px">Share Your Experience</div>
        <div style="margin-bottom:14px">
          <input type="text" id="testiTrip" placeholder="Trip name (e.g. Winter Spiti 2026)" style="width:100%;box-sizing:border-box;padding:11px 14px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.12);color:#fff;font-family:var(--body);font-size:14px;border-radius:2px;outline:none">
        </div>
        <div style="margin-bottom:14px">
          <div style="font-size:11px;color:rgba(255,255,255,.4);letter-spacing:1px;margin-bottom:8px">RATING</div>
          <div id="starRating" style="display:flex;gap:6px">
            <?php foreach([1,2,3,4,5] as $s): ?>
            <button onclick="setRating(<?php echo $s; ?>)" class="star-btn" data-star="<?php echo $s; ?>" style="background:none;border:none;font-size:28px;cursor:pointer;color:rgba(255,255,255,.2);padding:0;transition:color .15s">★</button>
            <?php endforeach; ?>
          </div>
          <input type="hidden" id="testiRating" value="5">
        </div>
        <div style="margin-bottom:14px">
          <textarea id="testiBody" placeholder="Tell us about your experience with FreeWheel..." rows="4" style="width:100%;box-sizing:border-box;padding:11px 14px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.12);color:#fff;font-family:var(--body);font-size:14px;border-radius:2px;outline:none;resize:vertical"></textarea>
        </div>
        <button onclick="submitTestimonial()" style="padding:11px 22px;background:var(--rust);border:none;color:#fff;font-family:var(--headline);font-size:14px;letter-spacing:1px;cursor:pointer;border-radius:2px">SUBMIT TESTIMONIAL</button>
        <div id="testiMsg" style="font-size:12px;margin-top:10px"></div>
      </div>
    </div>

    <!-- BLOGS -->
    <div class="dash-section">
      <div class="dash-section-title">My Blogs <span style="font-size:13px;color:rgba(255,255,255,.35);font-family:var(--body);letter-spacing:0;font-weight:300">Earns 100 credits on approval</span></div>
      <div id="blogList"></div>
      <div style="margin-top:20px">
        <button onclick="openBlogEditor()" style="display:inline-flex;align-items:center;gap:8px;padding:11px 22px;background:var(--rust);border:none;color:#fff;font-family:var(--headline);font-size:14px;letter-spacing:1px;cursor:pointer;border-radius:2px">+ WRITE NEW BLOG</button>
      </div>
      <!-- Blog Editor -->
      <div id="blogEditor" style="display:none;margin-top:24px;background:#0f0d0b;border:1px solid rgba(255,255,255,.1);padding:24px;border-radius:2px">
        <div style="font-size:12px;letter-spacing:2px;color:var(--rust);text-transform:uppercase;margin-bottom:16px">Blog Editor</div>
        <input type="hidden" id="blogEditId" value="">
        <div style="margin-bottom:14px">
          <input type="text" id="blogTitle" placeholder="Blog title..." style="width:100%;box-sizing:border-box;padding:11px 14px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.12);color:#fff;font-family:var(--body);font-size:16px;border-radius:2px;outline:none">
        </div>
        <div style="margin-bottom:14px">
          <!-- ── Rich Text Toolbar ── -->
          <div id="blogToolbar" style="display:flex;flex-wrap:wrap;gap:2px;padding:8px 10px;background:#1a1410;border:1px solid rgba(255,255,255,.12);border-bottom:none;border-radius:2px 2px 0 0;align-items:center">
            <button type="button" onmousedown="event.preventDefault();fwFmt('bold')" title="Bold" style="width:32px;height:28px;background:none;border:none;color:#fff;font-weight:700;font-size:14px;cursor:pointer;border-radius:2px;font-family:serif">B</button>
            <button type="button" onmousedown="event.preventDefault();fwFmt('italic')" title="Italic" style="width:32px;height:28px;background:none;border:none;color:#fff;font-weight:400;font-size:14px;font-style:italic;cursor:pointer;border-radius:2px;font-family:serif">I</button>
            <button type="button" onmousedown="event.preventDefault();fwFmt('underline')" title="Underline" style="width:32px;height:28px;background:none;border:none;color:#fff;font-size:14px;cursor:pointer;border-radius:2px;text-decoration:underline;font-family:serif">U</button>
            <div style="width:1px;height:20px;background:rgba(255,255,255,.15);margin:0 4px"></div>
            <button type="button" onmousedown="event.preventDefault();fwFmtBlock('h2')" title="Heading 2" style="padding:0 8px;height:28px;background:none;border:none;color:rgba(255,255,255,.7);font-size:11px;letter-spacing:1px;cursor:pointer;border-radius:2px;font-family:var(--body)">H2</button>
            <button type="button" onmousedown="event.preventDefault();fwFmtBlock('h3')" title="Heading 3" style="padding:0 8px;height:28px;background:none;border:none;color:rgba(255,255,255,.7);font-size:11px;letter-spacing:1px;cursor:pointer;border-radius:2px;font-family:var(--body)">H3</button>
            <div style="width:1px;height:20px;background:rgba(255,255,255,.15);margin:0 4px"></div>
            <button type="button" onmousedown="event.preventDefault();fwFmt('insertUnorderedList')" title="Bullet List" style="padding:0 8px;height:28px;background:none;border:none;color:rgba(255,255,255,.7);font-size:16px;cursor:pointer;border-radius:2px">&#8226;&#8212;</button>
            <button type="button" onmousedown="event.preventDefault();fwFmt('insertOrderedList')" title="Numbered List" style="padding:0 8px;height:28px;background:none;border:none;color:rgba(255,255,255,.7);font-size:11px;letter-spacing:1px;cursor:pointer;border-radius:2px;font-family:var(--body)">1.</button>
            <button type="button" onmousedown="event.preventDefault();fwFmtBlock('blockquote')" title="Blockquote" style="padding:0 8px;height:28px;background:none;border:none;color:rgba(255,255,255,.7);font-size:16px;cursor:pointer;border-radius:2px">&ldquo;</button>
            <div style="width:1px;height:20px;background:rgba(255,255,255,.15);margin:0 4px"></div>
            <button type="button" onmousedown="event.preventDefault();fwInsertLink()" title="Insert Link" style="padding:0 10px;height:28px;background:none;border:none;color:rgba(255,255,255,.7);font-size:11px;letter-spacing:1px;cursor:pointer;border-radius:2px;font-family:var(--body)">LINK</button>
            <button type="button" onclick="document.getElementById('blogInlinePhotoInput').click()" title="Insert Photo at cursor" style="padding:0 12px;height:28px;background:rgba(193,68,14,.2);border:1px solid rgba(193,68,14,.4);color:var(--rust);font-size:11px;letter-spacing:1px;cursor:pointer;border-radius:2px;font-family:var(--body);margin-left:4px">+ PHOTO</button>
            <input type="file" id="blogInlinePhotoInput" accept="image/*" style="display:none" onchange="fwInsertInlinePhoto(this)">
          </div>
          <!-- ── Editable content area ── -->
          <div id="blogBody"
            contenteditable="true"
            data-placeholder="Write your story here..."
            style="width:100%;box-sizing:border-box;min-height:320px;padding:14px 16px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.12);border-top:none;color:#fff;font-family:var(--body);font-size:14px;line-height:1.85;border-radius:0 0 2px 2px;outline:none;overflow-y:auto;word-break:break-word">
          </div>
          <style>
            #blogBody[data-placeholder]:empty:before{content:attr(data-placeholder);color:rgba(255,255,255,.25);pointer-events:none;display:block}
            #blogBody h2{font-family:var(--headline);font-size:26px;color:#fff;letter-spacing:1px;margin:20px 0 8px}
            #blogBody h3{font-family:var(--headline);font-size:20px;color:#fff;letter-spacing:.5px;margin:16px 0 6px}
            #blogBody p{margin:0 0 12px}
            #blogBody ul,#blogBody ol{padding-left:22px;margin:0 0 12px}
            #blogBody li{margin-bottom:4px}
            #blogBody blockquote{border-left:3px solid var(--rust);margin:16px 0;padding:10px 16px;background:rgba(193,68,14,.08);font-style:italic;color:rgba(255,255,255,.7)}
            #blogBody a{color:var(--rust);text-decoration:underline}
            #blogBody img{max-width:100%;border-radius:3px;margin:12px 0;display:block}
            #blogToolbar button:hover{background:rgba(255,255,255,.1)!important}
          </style>
        </div>
        <div style="margin-bottom:16px">
          <div style="font-size:11px;color:rgba(255,255,255,.4);letter-spacing:1px;margin-bottom:8px">COVER IMAGE (optional)</div>
          <input type="file" id="blogCoverInput" accept="image/*" style="display:none" onchange="uploadBlogCover(this)">
          <div id="blogCoverPreview" style="margin-bottom:10px"></div>
          <button onclick="document.getElementById('blogCoverInput').click()" style="padding:8px 16px;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.15);color:#fff;font-family:var(--body);font-size:13px;cursor:pointer;border-radius:2px">Upload Cover Image</button>
          <input type="hidden" id="blogCoverUrl" value="">
        </div>
        <div style="display:flex;gap:10px;flex-wrap:wrap">
          <button onclick="saveBlog('draft')" style="padding:10px 20px;background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.2);color:#fff;font-family:var(--headline);font-size:14px;letter-spacing:1px;cursor:pointer;border-radius:2px">SAVE DRAFT</button>
          <button onclick="saveBlog('pending')" style="padding:10px 20px;background:var(--rust);border:none;color:#fff;font-family:var(--headline);font-size:14px;letter-spacing:1px;cursor:pointer;border-radius:2px">SUBMIT FOR REVIEW</button>
          <button onclick="document.getElementById('blogEditor').style.display='none'" style="padding:10px 20px;background:rgba(255,255,255,.06);border:none;color:rgba(255,255,255,.4);font-family:var(--body);font-size:14px;cursor:pointer;border-radius:2px">Cancel</button>
        </div>
        <div id="blogMsg" style="font-size:12px;margin-top:10px"></div>
      </div>
    </div>

    </div>

  </div>
</div>

<!-- Toast -->
<div class="fw-toast" id="fwToast"></div>

<script>
window.addEventListener('load', function() {

  /* ── Helpers ── */
  function showGateError(msg) {
    document.getElementById('fwAuthGate').innerHTML =
      '<div style="text-align:center;padding:60px 24px">'+
      '<div style="font-size:56px;margin-bottom:16px">🔒</div>'+
      '<div style="font-family:var(--headline);font-size:28px;color:#fff;margin-bottom:10px">'+(msg||'Login Required')+'</div>'+
      '<div style="font-size:14px;color:rgba(255,255,255,.4);margin-bottom:28px">Please log in to view your dashboard.</div>'+
      '<a href="'+(window.FW_AUTH&&FW_AUTH.login_url||'/login/')+'" style="display:inline-block;padding:13px 32px;background:var(--rust);color:#fff;text-decoration:none;font-family:var(--headline);font-size:18px;letter-spacing:1px;border-radius:2px">LOG IN</a>'+
      '</div>';
  }

  function toast(msg, isErr) {
    var t=document.getElementById('fwToast');
    if(!t) return;
    t.textContent=msg; t.className='fw-toast show'+(isErr?' err':'');
    setTimeout(function(){ t.className='fw-toast'; }, 3500);
  }

  function _set(id,val){ try{ var e=document.getElementById(id); if(e) e.textContent=val; }catch(ex){} }
  function _val(id,val){ try{ var e=document.getElementById(id); if(e) e.value=val; }catch(ex){} }

  /* ── Session from localStorage ── */
  var _session = null;
  try { _session = JSON.parse(localStorage.getItem('fw_session') || 'null'); } catch(e){}

  if (!_session || !_session.access_token || _session.expires_at < Date.now()) {
    showGateError('Login Required');
    return;
  }

  /* Admin dashboard accessible at /admin-dashboard/ */

  /* ── Init Supabase + refresh token if needed ── */
  var sb = null;
  var _token = _session.access_token;
  var _rest  = (window.FW_AUTH && FW_AUTH.rest_url) || '/wp-json/freewheel/v1';

  try {
    if (window.supabase && window.FW_AUTH) {
      sb = supabase.createClient(FW_AUTH.supabase_url, FW_AUTH.supabase_key);
      /* Refresh session if expiring within 10 minutes */
      if (_session.expires_at < Date.now() + 600000 && _session.refresh_token) {
        sb.auth.refreshSession({ refresh_token: _session.refresh_token }).then(function(res) {
          if (res.data && res.data.session) {
            var s = res.data.session;
            var updated = {
              access_token:  s.access_token,
              refresh_token: s.refresh_token,
              user_id:       s.user.id,
              email:         s.user.email,
              first_name:    _session.first_name || '',
              expires_at:    Date.now() + (s.expires_in * 1000),
            };
            localStorage.setItem('fw_session', JSON.stringify(updated));
            _token = s.access_token;
          }
        }).catch(function(){});
      }
    }
  } catch(e){}

  /* ── Load all data via PHP endpoints (server-side, secure) ── */
  async function safeFetch(url, opts) {
    try {
      var r = await fetch(url, opts);
      if (!r.ok) { console.warn('API error:', url, r.status); return {}; }
      return await r.json();
    } catch(e) {
      console.warn('Fetch failed:', url, e.message);
      return {};
    }
  }

  async function loadDashboard() {
    var h = { 'Authorization': 'Bearer ' + _token };
    /* Load profile first — required */
    var profData = await safeFetch(_rest + '/fw-get-profile', { headers: h });
    if (!profData.profile) {
      showGateError('Profile not found. Please <a href="' + ((window.FW_AUTH && FW_AUTH.register_url) || '/register/') + '" style="color:var(--rust)">complete registration</a>.');
      return;
    }

    /* Load remaining data in parallel — each failure is isolated */
    var [creditData, bookData, orderData, albumData, blogData, testiData] = await Promise.all([
      safeFetch(_rest + '/fw-credit-history',   { headers: h }),
      safeFetch(_rest + '/fw-get-bookings',     { headers: h }),
      safeFetch(_rest + '/fw-get-orders',       { headers: h }),
      safeFetch(_rest + '/fw-get-albums',       { headers: h }),
      safeFetch(_rest + '/fw-get-blogs',        { headers: h }),
      safeFetch(_rest + '/fw-get-testimonials', { headers: h }),
    ]);

    render(profData, creditData, bookData, orderData, albumData, blogData, testiData);
  }

  /* ── RENDER ── */
  function render(profData, creditData, bookData, orderData, albumData, blogData, testiData) {
    var prof   = profData.profile || {};
    var tier   = profData.tier    || { name:'Explorer', discount:0, label:'Complete your first trip', next:'' };
    var balance= creditData.balance || 0;
    var credVal= creditData.credit_value || 0;
    var canRed = creditData.can_redeem || false;
    var history= creditData.history || [];
    var trips  = bookData.bookings  || [];
    var orders = orderData.orders   || [];

    var fn   = prof.first_name || 'Traveller';
    var ln   = prof.last_name  || '';
    var ph   = prof.phone      || '—';
    var city = prof.city       || '—';
    var st   = prof.state      || '—';
    var co   = prof.country    || 'India';
    var since= prof.created_at ? new Date(prof.created_at).toLocaleDateString('en-IN',{month:'long',year:'numeric'}) : '—';
    var av   = prof.avatar_url || prof.profile_photo || '';
    var tc   = prof.trips_completed || 0;

    _set('greetName', fn);
    _set('greetSub', ph!=='—' ? ph+(city!=='—'?' · '+city:'') : (_session.email||''));

    var avEl = document.getElementById('userAvatarEl');
    if(av) { avEl.innerHTML='<img src="'+av+'" style="width:72px;height:72px;border-radius:50%;object-fit:cover;border:3px solid var(--amber)">'; }
    else   { avEl.textContent=(fn.charAt(0)+(ln?ln.charAt(0):'')).toUpperCase(); }

    /* Stats */
    _set('statTrips',  tc);
    _set('statOrders', orders.length);
    _set('statCredits',balance);
    _set('statDisc',   tier.discount ? tier.discount+'%' : '—');

    /* Loyalty */
    /* loyaltyNext removed */

    /* Credits panel */
    _set('creditBalance', balance);
    _set('creditValue',   '₹'+credVal.toFixed(2));
    _set('creditRedeemNote', canRed ? 'You can redeem credits on your next merchandise order.' : 'Earn '+(400-balance)+' more credits to unlock redemption (₹100 off).');
    renderCreditHistory(history);

    /* Profile */
    _set('dpFirst',fn); _set('dpLast',ln); _set('dpPhone',ph);
    _set('dpEmail', _session.email||'—');
    _set('dpCity',city); _set('dpState',st); _set('dpCountry',co);
    _set('dpSince',since);
    _val('epFirst',fn); _val('epLast',ln); _val('epCity',city);
    _val('epState',st); _val('epCountry',co);
    _val('epInstagram', prof.instagram||'');

    /* Trips */
    renderTrips(trips);

    /* Orders */
    renderOrders(orders);

    window._fw_token = _token;
    window._fw_prof  = prof;

    renderTitles(tc);
    renderTitlesBanner(tc);
    renderAlbums(albumData.albums || []);
    renderBlogs(blogData.blogs || []);
    renderTestimonials(testiData.testimonials || []);

    document.getElementById('fwAuthGate').style.display='none';
    document.getElementById('fwDash').style.display='block';
  }

  function renderCreditHistory(history) {
    var el = document.getElementById('creditHistory');
    if (!el) return;
    if (!history.length) {
      el.innerHTML='<div style="color:rgba(255,255,255,.35);font-size:13px;padding:20px 0">No credit transactions yet.</div>'; return;
    }
    var reasonMap = {
      registration:'Welcome Bonus', trip_completed:'Trip Completed',
      blog_published:'Blog Published', testimonial_approved:'Testimonial Approved',
      album_shared:'Album Shared', merchandise_purchase:'Merchandise Purchase',
      redemption:'Redeemed', reversal:'Reversal', admin_adjustment:'Adjustment', expired:'Expired'
    };
    el.innerHTML = history.map(function(c){
      var isPos = c.amount > 0;
      var date  = new Date(c.created_at).toLocaleDateString('en-IN',{day:'numeric',month:'short',year:'numeric'});
      var expiry= c.expires_at ? ' · Expires '+new Date(c.expires_at).toLocaleDateString('en-IN',{month:'short',year:'numeric'}) : '';
      return '<div style="display:flex;justify-content:space-between;align-items:center;padding:12px 0;border-bottom:1px solid rgba(255,255,255,.06)">'+
        '<div>'+
          '<div style="font-size:13px;color:#fff">'+(reasonMap[c.reason]||c.reason)+(c.note?' — <span style="color:rgba(255,255,255,.4)">'+c.note+'</span>':'')+'</div>'+
          '<div style="font-size:11px;color:rgba(255,255,255,.35);margin-top:2px">'+date+expiry+'</div>'+
        '</div>'+
        '<div style="font-family:var(--headline);font-size:20px;color:'+(isPos?'#4ade80':'#f87171')+'">'+
          (isPos?'+':'')+c.amount+
        '</div>'+
      '</div>';
    }).join('');
  }

  function renderTrips(trips) {
    var tw = document.getElementById('tripHistory');
    if (!trips.length) {
      tw.innerHTML='<div class="empty-state"><span class="empty-icon">🏔️</span><div class="empty-h">No Expeditions Yet</div><div class="empty-p">Your booked trips will appear here once confirmed by our team.</div></div>'; return;
    }
    tw.innerHTML = trips.map(function(t, i) {
      var status = t.status || 'inquiry';
      var date   = t.trip_dates || (t.created_at ? new Date(t.created_at).toLocaleDateString('en-IN',{month:'short',year:'numeric'}) : '—');
      var statusColors = {inquiry:'#e8a020',contacted:'#60a5fa',confirmed:'#a78bfa',deposit_received:'#34d399',fully_paid:'#4ade80',completed:'#4ade80',cancelled:'#f87171'};
      return '<div class="trip-hist-card">'+
        '<div class="thc-top">'+
          '<div class="thc-num">'+(i<9?'0'+(i+1):i+1)+'</div>'+
          '<div class="thc-body">'+
            '<div class="thc-date">'+date+'</div>'+
            '<div class="thc-name">'+(t.trip_title||'Expedition')+'</div>'+
            (t.seats?'<div class="thc-tags"><span class="thc-tag">'+t.seats+' seat'+(t.seats>1?'s':'')+'</span></div>':'')+
          '</div>'+
          '<div class="thc-right">'+
            '<span class="thc-status" style="color:'+(statusColors[status]||'#fff')+';background:rgba(255,255,255,.06);padding:4px 10px;border-radius:12px;font-size:11px;letter-spacing:1px;text-transform:uppercase">'+status.replace('_',' ')+'</span>'+
            (t.amount_total?'<div style="font-size:12px;color:rgba(255,255,255,.4);margin-top:6px">₹'+t.amount_total.toLocaleString('en-IN')+(t.discount_pct?' ('+t.discount_pct+'% off)':'')+'</div>':'')+
          '</div>'+
        '</div>'+
      '</div>';
    }).join('');
  }

  function renderOrders(orders) {
    var ow = document.getElementById('orderHistory');
    if (!orders.length) {
      ow.innerHTML='<div class="empty-state"><span class="empty-icon">🛍️</span><div class="empty-h">No Orders Yet</div><div class="empty-p">Merchandise orders will appear here.</div></div>'; return;
    }
    var statusColors = {inquiry:'#e8a020',confirmed:'#60a5fa',payment_received:'#a78bfa',dispatched:'#34d399',delivered:'#4ade80',cancelled:'#f87171',returned:'#f87171'};
    ow.innerHTML = orders.map(function(o){
      var date  = o.created_at ? new Date(o.created_at).toLocaleDateString('en-IN',{day:'numeric',month:'short',year:'numeric'}) : '—';
      var items = Array.isArray(o.items) ? o.items : [];
      var itemStr = items.map(function(it){ return it.name+(it.size?' ('+it.size+')':'')+(it.qty>1?' x'+it.qty:''); }).join(', ') || 'Order';
      return '<div class="order-card">'+
        '<div class="order-icon">🧢</div>'+
        '<div class="order-body">'+
          '<div class="order-name">'+itemStr+'</div>'+
          '<div class="order-meta">'+date+' · <span style="color:'+(statusColors[o.status]||'#fff')+'">'+o.status.replace('_',' ')+'</span>'+
            (o.credits_used?' · '+o.credits_used+' credits redeemed':'')+
            (o.tracking_number?' · Track: '+o.tracking_number:'')+
          '</div>'+
        '</div>'+
        '<div class="order-price">'+
          (o.amount_final?'₹'+o.amount_final.toLocaleString('en-IN'):o.amount_total?'₹'+o.amount_total.toLocaleString('en-IN'):'—')+
          (o.discount_amount?'<div style="font-size:10px;color:#4ade80">-₹'+o.discount_amount+' credits</div>':'')+
        '</div>'+
      '</div>';
    }).join('');
  }

  loadDashboard();

  window._fw_sb=sb; window._fw_user={id:_session.user_id, email:_session.email};

  /* Safety net — never leave user with infinite spinner */
  setTimeout(function(){
    var gate = document.getElementById('fwAuthGate');
    var dash = document.getElementById('fwDash');
    if(gate && gate.style.display !== 'none' && (!dash || dash.style.display === 'none')){
      showGateError('Loading timed out. Please log in again.');
    }
  }, 8000);


  /* ── ALBUM TOGGLE ── */
  window.toggleAlbum=function(id){var e=document.getElementById(id);if(e)e.style.display=e.style.display==='block'?'none':'block';};

  /* ── TRIP PHOTO UPLOAD ── */
  window.uploadTripPhoto=function(tripId){var e=document.getElementById('pi-'+tripId);if(e)e.click();};
  window.doUploadPhoto=async function(input,tripId){
    var token=window._fw_token;
    if(!token||!input.files[0])return;
    var file=input.files[0];
    if(file.size>5*1024*1024){toast('Max 5MB per photo',true);return;}
    var allowed=['image/jpeg','image/png','image/webp'];
    if(!['image/jpeg','image/png','image/webp','image/jpg'].includes(file.type)){toast('Only JPG, PNG, WEBP allowed',true);return;}
    toast('Uploading photo…');
    var formData=new FormData();
    formData.append('photo',file);
    formData.append('booking_id',tripId);
    try {
      var r=await fetch(FW_AUTH.rest_url+'/fw-upload-trip-photo',{method:'POST',headers:{'Authorization':'Bearer '+token},body:formData});
      var d=await r.json();
      if(!r.ok) throw new Error(d.message||'Upload failed');
      toast('Photo saved ✅');
      setTimeout(function(){location.reload();},900);
    } catch(err){ toast(err.message||'Upload failed',true); }
  };

  /* ── AVATAR ── */
  window.uploadAvatar=async function(input){
    var token=window._fw_token; if(!token||!input.files[0]) return;
    var file=input.files[0];
    if(file.size>3*1024*1024){toast('Max 3MB per photo',true);return;}
    var allowed=['image/jpeg','image/png','image/webp'];
    if(!allowed.includes(file.type)){toast('Only JPG, PNG, WEBP allowed',true);return;}
    toast('Uploading…');
    var formData=new FormData();
    formData.append('avatar',file);
    try {
      var r=await fetch(FW_AUTH.rest_url+'/fw-upload-avatar',{method:'POST',headers:{'Authorization':'Bearer '+token},body:formData});
      var d=await r.json();
      if(!r.ok) throw new Error(d.message||'Upload failed');
      document.getElementById('userAvatarEl').innerHTML='<img src="'+d.url+'" style="width:72px;height:72px;border-radius:50%;object-fit:cover;border:3px solid var(--amber)">';
      toast('Profile photo updated ✅');
    } catch(err){ toast(err.message||'Upload failed',true); }
  };

  /* ── EDIT PROFILE ── */
  window.toggleEditProfile=function(){
    var editing=document.getElementById('epFirst').style.display!=='none';
    ['dpFirst','dpLast','dpCity','dpState','dpCountry'].forEach(function(id){var e=document.getElementById(id);if(e)e.style.display=editing?'block':'none';});
    ['epFirst','epLast','epCity','epState','epCountry'].forEach(function(id){var e=document.getElementById(id);if(e)e.style.display=editing?'none':'block';});
    var sr=document.getElementById('profileSaveRow'); if(sr)sr.style.display=editing?'none':'flex';
    var btn=document.getElementById('editProfileBtn'); if(btn)btn.textContent=editing?'Edit':'Cancel';
  };
  window.saveProfile=async function(){
    var token=window._fw_token; if(!token) return;
    var u={first_name:document.getElementById('epFirst').value.trim(),last_name:document.getElementById('epLast').value.trim(),city:document.getElementById('epCity').value.trim(),state:document.getElementById('epState').value.trim(),country:document.getElementById('epCountry').value.trim()};
    try {
      var r=await fetch(FW_AUTH.rest_url+'/fw-update-profile',{method:'POST',headers:{'Content-Type':'application/json','Authorization':'Bearer '+token},body:JSON.stringify(u)});
      var d=await r.json();
      if(!r.ok) throw new Error(d.message||'Save failed');
      _set('dpFirst',u.first_name);_set('dpLast',u.last_name);_set('dpCity',u.city);
      var stateEl=document.getElementById('dpState'); if(stateEl) stateEl.textContent = u.state ? ', '+u.state : '';
      _set('dpCountry',u.country);_set('greetName',u.first_name);
      var msg=document.getElementById('profileMsg');
      if(msg){msg.textContent='Profile saved!';msg.style.color='#4ade80';}
      setTimeout(function(){ var p=document.getElementById('profilePanel'); if(p) p.style.display='none'; },900);
      toast('Profile saved ✅');
    } catch(err) {
      var msg=document.getElementById('profileMsg');
      if(msg){msg.textContent=err.message||'Save failed';msg.style.color='#f87171';}
      toast(err.message||'Save failed',true);
    }
  };

  /* ── PHOTO LIGHTBOX ── */
  window.openPhoto=function(url){
    var ov=document.createElement('div');
    ov.style.cssText='position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,.93);display:flex;align-items:center;justify-content:center;cursor:pointer';
    ov.innerHTML='<img src="'+url+'" style="max-width:92vw;max-height:92vh;object-fit:contain;border-radius:3px">';
    ov.onclick=function(){document.body.removeChild(ov);};
    document.body.appendChild(ov);
  };

  /* ── LOGOUT ── */
  window.doLogout=async function(){
    try {
      localStorage.removeItem('fw_session');
      if(window._fw_sb) await window._fw_sb.auth.signOut();
    } catch(e){}
    window.location.href=(window.FW_AUTH&&FW_AUTH.home_url)||'/';
  };
  /* ── RENDER ALBUMS ── */
  function renderAlbums(albums) {
    var el = document.getElementById('albumList');
    if (!el) return;
    if (!albums.length) {
      el.innerHTML = '<div style="color:rgba(255,255,255,.35);font-size:13px;padding:10px 0">No albums yet. Create your first trip album below.</div>';
      return;
    }
    var statusColor = {pending:'#e8a020', published:'#4ade80', rejected:'#f87171'};
    var statusLabel = {pending:'Pending Approval', published:'Approved', rejected:'Rejected'};
    el.innerHTML = '';

    albums.forEach(function(a) {
      var photos = a.photos || [];
      var photoCount = photos.length;
      var cover = photos[0] ? photos[0].photo_url : '';
      var panelId = 'alb-panel-' + a.id;

      var card = document.createElement('div');
      card.style.cssText = 'background:#0f0d0b;border:1px solid rgba(255,255,255,.08);border-radius:3px;margin-bottom:12px;overflow:hidden';

      var cells = '';
      for (var i = 0; i < 6; i++) {
        if (photos[i]) {
          cells += '<div style="aspect-ratio:1;overflow:hidden;border-radius:2px"><img src="'+photos[i].photo_url+'" style="width:100%;height:100%;object-fit:cover;display:block" loading="lazy"></div>';
        } else {
          cells += '<div style="aspect-ratio:1;background:rgba(255,255,255,.04);border-radius:2px;display:flex;align-items:center;justify-content:center;font-size:18px;color:rgba(255,255,255,.1)">+</div>';
        }
      }

      var coverHtml = cover
        ? '<img src="'+cover+'" style="width:52px;height:52px;object-fit:cover;border-radius:2px;flex-shrink:0">'
        : '<div style="width:52px;height:52px;background:rgba(255,255,255,.06);border-radius:2px;flex-shrink:0;display:flex;align-items:center;justify-content:center;font-size:20px">&#128247;</div>';

      var addBtn = photoCount < 6
        ? '<button data-aid="'+a.id+'" onclick="event.stopPropagation();openAlbumUploader(this.dataset.aid)" style="padding:6px 12px;background:rgba(193,68,14,.15);border:1px solid rgba(193,68,14,.3);color:var(--rust);font-size:11px;cursor:pointer;border-radius:2px">+ Photo</button>'
        : '<span style="font-size:11px;color:#4ade80">Full &#10003;</span>';

      var rejNote = a.rejection_note
        ? '<div style="padding:10px;font-size:12px;color:#f87171;margin-top:3px">Rejection: '+a.rejection_note+'</div>'
        : '';

      card.innerHTML =
        '<div data-pid="'+panelId+'" onclick="fwToggleAlbum(this.dataset.pid)"'+'style="padding:16px 20px;display:flex;align-items:center;gap:14px;cursor:pointer">'+
          coverHtml+
          '<div style="flex:1;min-width:0">'+
            '<div style="font-size:15px;color:#fff;margin-bottom:3px">'+a.title+'</div>'+
            '<div style="font-size:12px;color:rgba(255,255,255,.4)">'+
              (a.trip_name ? a.trip_name + ' &middot; ' : '')+
              '<span style="color:'+(statusColor[a.status]||'#fff')+';font-weight:500">'+(statusLabel[a.status]||a.status)+'</span>'+
              ' &middot; '+photoCount+'/6 photos'+
            '</div>'+
          '</div>'+
          '<div style="display:flex;align-items:center;gap:8px;flex-shrink:0">'+
            addBtn+
            '<span id="'+panelId+'-arrow" style="color:rgba(255,255,255,.25);font-size:16px">&#9660;</span>'+
          '</div>'+
        '</div>'+
        '<div id="'+panelId+'" style="display:none;border-top:1px solid rgba(255,255,255,.06);padding:4px">'+
          '<div style="display:grid;grid-template-columns:repeat(6,1fr);gap:3px">'+cells+'</div>'+
          rejNote+
        '</div>';

      el.appendChild(card);
    });
  }

  window.fwToggleAlbum = function(id) {
    var p = document.getElementById(id);
    var a = document.getElementById(id+'-arrow');
    if (!p) return;
    var open = p.style.display !== 'none';
    p.style.display = open ? 'none' : 'block';
    if (a) a.innerHTML = open ? '&#9660;' : '&#9650;';
  };

  /* ── TITLES DATA ── */
  var FW_TITLES = [
    { id:'explorer',         label:'Explorer',          emoji:'&#128094;', trips:0,  color:'#9ca3af', glow:'rgba(156,163,175,.5)' },
    { id:'pathfinder',       label:'Pathfinder',         emoji:'&#128506;', trips:1,  color:'#cd7f32', glow:'rgba(205,127,50,.5)'  },
    { id:'road_warrior',     label:'Road Warrior',       emoji:'&#127949;', trips:2,  color:'#c0c0c0', glow:'rgba(192,192,192,.5)' },
    { id:'trail_blazer',     label:'Trail Blazer',       emoji:'&#128293;', trips:3,  color:'#2a7a6e', glow:'rgba(42,122,110,.5)'  },
    { id:'convoy_leader',    label:'Convoy Leader',      emoji:'&#128665;', trips:5,  color:'#c1440e', glow:'rgba(193,68,14,.6)'   },
    { id:'summit_chaser',    label:'Summit Chaser',      emoji:'&#127956;', trips:7,  color:'#7c3aed', glow:'rgba(124,58,237,.5)'  },
    { id:'himalayan_legend', label:'Himalayan Legend',   emoji:'&#11088;',  trips:10, color:'#e8a020', glow:'rgba(232,160,32,.7)'  },
  ];

  function renderTitles(tripsCompleted) {
    var el = document.getElementById('titlesTrack');
    if (!el) return;
    var currentIdx = 0;
    for (var i = FW_TITLES.length - 1; i >= 0; i--) {
      if (tripsCompleted >= FW_TITLES[i].trips) { currentIdx = i; break; }
    }
    el.innerHTML = '';
    FW_TITLES.forEach(function(t, idx) {
      var isEarned  = tripsCompleted >= t.trips;
      var isCurrent = idx === currentIdx;
      var node = document.createElement('div');
      node.className = 'title-node' + (isEarned ? ' earned' : '');
      var badge = document.createElement('div');
      badge.className = 'title-badge ' + (isCurrent ? 'current' : isEarned ? 'earned' : 'locked');
      if (isEarned) {
        badge.style.background = 'linear-gradient(135deg,' + t.color + '33,' + t.color + '11)';
        badge.style.borderColor = t.color;
      }
      badge.innerHTML = '<span style="font-size:26px">' + t.emoji + '</span>';
      var label = document.createElement('div');
      label.className = 'title-label';
      label.style.color = isCurrent ? t.color : isEarned ? 'rgba(255,255,255,.5)' : 'rgba(255,255,255,.2)';
      label.style.fontFamily = 'var(--headline)';
      label.textContent = t.label;
      var trips = document.createElement('div');
      trips.className = 'title-trips';
      trips.style.color = isEarned ? 'rgba(255,255,255,.5)' : 'rgba(255,255,255,.2)';
      trips.textContent = t.trips === 0 ? 'Start' : t.trips + ' trips';
      node.appendChild(badge); node.appendChild(label); node.appendChild(trips);
      el.appendChild(node);
    });
  }

  function renderTitlesBanner(tripsCompleted) {
    var el = document.getElementById('titlesTrackBanner');
    if (!el) return;
    var currentIdx = 0;
    for (var i = FW_TITLES.length - 1; i >= 0; i--) {
      if (tripsCompleted >= FW_TITLES[i].trips) { currentIdx = i; break; }
    }
    el.innerHTML = '';
    FW_TITLES.forEach(function(t, idx) {
      var isEarned  = tripsCompleted >= t.trips;
      var isCurrent = idx === currentIdx;
      var node = document.createElement('div');
      node.style.cssText = 'flex:1;display:flex;flex-direction:column;align-items:center;position:relative;padding:0';
      var badge = document.createElement('div');
      badge.style.cssText = 'width:44px;height:44px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:18px;border:2px solid;position:relative;z-index:1;' +
        (isCurrent ? 'border-color:' + t.color + ';box-shadow:0 0 16px ' + t.glow + ';transform:scale(1.15);background:' + t.color + '22;' :
         isEarned  ? 'border-color:' + t.color + '66;background:' + t.color + '11;' :
                     'border-color:rgba(255,255,255,.1);background:rgba(255,255,255,.03);filter:grayscale(1);opacity:.35;');
      badge.innerHTML = '<span>' + t.emoji + '</span>';
      var lbl = document.createElement('div');
      lbl.style.cssText = 'font-size:9px;letter-spacing:.5px;text-align:center;margin-top:6px;text-transform:uppercase;font-family:var(--headline);white-space:nowrap;color:' +
        (isCurrent ? t.color : isEarned ? 'rgba(255,255,255,.5)' : 'rgba(255,255,255,.2)');
      lbl.textContent = t.label;
      node.appendChild(badge); node.appendChild(lbl);
      el.appendChild(node);
    });
  }


  /* ── RENDER BLOGS ── */
  function renderBlogs(blogs) {
    var el = document.getElementById('blogList');
    if (!el) return;
    if (!blogs.length) {
      el.innerHTML = '<div style="color:rgba(255,255,255,.35);font-size:13px;padding:10px 0">No blogs yet. Share your road story below.</div>';
      return;
    }
    var statusColor = {draft:'rgba(255,255,255,.4)', pending:'#e8a020', published:'#4ade80', rejected:'#f87171'};
    var statusLabel = {draft:'Draft', pending:'Pending Approval', published:'Published', rejected:'Rejected'};
    el.innerHTML = '';
    blogs.forEach(function(b) {
      var canEdit = b.status === 'draft' || b.status === 'rejected';
      var div = document.createElement('div');
      div.style.cssText = 'background:#0f0d0b;border:1px solid rgba(255,255,255,.08);padding:16px 20px;border-radius:2px;margin-bottom:10px;display:flex;align-items:center;justify-content:space-between;gap:12px';
      var inner = '<div style="flex:1"><div style="font-size:15px;color:#fff;margin-bottom:4px">' + b.title + '</div>' +
        '<div style="font-size:12px;color:rgba(255,255,255,.4)"><span style="color:' + (statusColor[b.status]||'#fff') + '">' + (statusLabel[b.status]||b.status) + '</span>' +
        (b.rejection_note ? ' &middot; <span style="color:#f87171">' + b.rejection_note + '</span>' : '') + '</div></div>';
      div.innerHTML = inner;
      if (canEdit) {
        var btn = document.createElement('button');
        btn.textContent = 'Edit';
        btn.style.cssText = 'padding:8px 14px;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.12);color:#fff;font-size:12px;cursor:pointer;border-radius:2px;white-space:nowrap';
        btn.onclick = (function(id, title){ return function(){ editBlog(id, title); }; })(b.id, b.title);
        div.appendChild(btn);
      }
      el.appendChild(div);
    });
  }

  /* ── RENDER TESTIMONIALS ── */
  function renderTestimonials(testis) {
    var el = document.getElementById('testimonialList');
    if (!el) return;
    if (!testis.length) {
      el.innerHTML = '<div style="color:rgba(255,255,255,.35);font-size:13px;padding:10px 0">No testimonials yet.</div>';
      return;
    }
    var statusColor = {pending:'#e8a020', approved:'#4ade80', rejected:'#f87171'};
    el.innerHTML = '';
    testis.forEach(function(t) {
      var stars = '';
      for (var s = 1; s <= 5; s++) stars += '<span style="color:' + (s<=t.rating?'#f59e0b':'rgba(255,255,255,.2)') + '">&#9733;</span>';
      var div = document.createElement('div');
      div.style.cssText = 'background:#0f0d0b;border:1px solid rgba(255,255,255,.08);padding:16px 20px;border-radius:2px;margin-bottom:10px';
      div.innerHTML = '<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px">' +
        '<div>' + stars + '</div>' +
        '<span style="font-size:11px;color:' + (statusColor[t.status]||'#fff') + '">' + t.status + '</span></div>' +
        '<div style="font-size:14px;color:rgba(255,255,255,.8);line-height:1.6">' + t.body + '</div>' +
        (t.trip_name ? '<div style="font-size:12px;color:rgba(255,255,255,.4);margin-top:6px">' + t.trip_name + '</div>' : '');
      el.appendChild(div);
    });
  }


  /* ══════════════════════════════════════════════
     ACTION FUNCTIONS — all window-scoped for onclick
  ══════════════════════════════════════════════ */

  /* ── Edit Profile ── */
  window.openEditProfile = function() {
    var panel = document.getElementById('profilePanel');
    if (!panel) return;
    var open = panel.style.display !== 'none';
    panel.style.display = open ? 'none' : 'block';
    if (!open) setTimeout(function(){ panel.scrollIntoView({behavior:'smooth',block:'start'}); }, 50);
  };

  window.saveProfile = async function() {
    var token = _token; if (!token) return;
    var u = {
      first_name: (document.getElementById('epFirst')||{}).value||'',
      last_name:  (document.getElementById('epLast')||{}).value||'',
      city:       (document.getElementById('epCity')||{}).value||'',
      state:      (document.getElementById('epState')||{}).value||'',
      country:    (document.getElementById('epCountry')||{}).value||'',
      instagram:  (document.getElementById('epInstagram')||{}).value||''
    };
    try {
      var r = await fetch(_rest+'/fw-update-profile',{method:'POST',headers:{'Content-Type':'application/json','Authorization':'Bearer '+token},body:JSON.stringify(u)});
      var d = await r.json();
      if (!r.ok) throw new Error(d.message||'Save failed');
      _set('dpFirst',u.first_name); _set('dpLast',u.last_name);
      _set('dpCity',u.city); _set('dpCountry',u.country);
      _set('greetName',u.first_name);
      var msg = document.getElementById('profileMsg');
      if (msg) { msg.textContent='Saved!'; msg.style.color='#4ade80'; }
      setTimeout(function(){ var p=document.getElementById('profilePanel'); if(p) p.style.display='none'; }, 900);
      toast('Profile saved');
    } catch(e) { toast(e.message||'Save failed', true); }
  };

  /* ── Star Rating ── */
  window.setRating = function(n) {
    document.getElementById('testiRating').value = n;
    document.querySelectorAll('.star-btn').forEach(function(btn) {
      btn.style.color = parseInt(btn.dataset.star) <= n ? '#f59e0b' : 'rgba(255,255,255,.2)';
    });
  };
  /* Init stars to 5 */
  setTimeout(function(){ window.setRating(5); }, 100);

  /* ── Submit Testimonial ── */
  window.submitTestimonial = async function() {
    var trip   = (document.getElementById('testiTrip')||{}).value||'';
    var rating = parseInt((document.getElementById('testiRating')||{}).value)||5;
    var body   = (document.getElementById('testiBody')||{}).value||'';
    var msg    = document.getElementById('testiMsg');
    if (!body.trim()) { if(msg){msg.textContent='Please write your experience.';msg.style.color='#f87171';} return; }
    try {
      var r = await fetch(_rest+'/fw-create-testimonial',{method:'POST',headers:{'Content-Type':'application/json','Authorization':'Bearer '+_token},body:JSON.stringify({trip_name:trip,rating:rating,body:body})});
      var d = await r.json();
      if (!r.ok) throw new Error(d.message||'Failed');
      if(msg){msg.textContent='Submitted for review!';msg.style.color='#4ade80';}
      document.getElementById('testiTrip').value='';
      document.getElementById('testiBody').value='';
      window.setRating(5);
      setTimeout(function(){ location.reload(); }, 1500);
    } catch(e) { if(msg){msg.textContent=e.message;msg.style.color='#f87171';} }
  };

  /* ── New Album ── */
  window.openNewAlbum = function() {
    var f = document.getElementById('newAlbumForm');
    if (f) f.style.display = f.style.display==='none'?'block':'none';
  };

  window.submitNewAlbum = async function() {
    var title = (document.getElementById('albumTitle')||{}).value||'';
    var trip  = (document.getElementById('albumTripName')||{}).value||'';
    var pub   = document.getElementById('albumIsPublic') && document.getElementById('albumIsPublic').checked;
    var msg   = document.getElementById('albumFormMsg');
    if (!title.trim()) { if(msg){msg.textContent='Please enter a title.';} return; }
    try {
      var r = await fetch(_rest+'/fw-create-album',{method:'POST',headers:{'Content-Type':'application/json','Authorization':'Bearer '+_token},body:JSON.stringify({title:title,trip_name:trip,is_public:pub})});
      var d = await r.json();
      if (!r.ok) throw new Error(d.message||'Failed');
      toast('Album created!');
      document.getElementById('newAlbumForm').style.display='none';
      setTimeout(function(){ location.reload(); }, 1000);
    } catch(e) { if(msg){msg.textContent=e.message||'Failed';} }
  };

  /* ── Album Photo Upload ── */
  window.openAlbumUploader = function(albumId) {
    var input = document.createElement('input');
    input.type='file'; input.accept='image/*'; input.multiple=true;
    input.onchange = function() {
      var files = Array.from(input.files).slice(0,6);
      if (!files.length) return;
      uploadWithCaptions(albumId, files, 0);
    };
    input.click();
  };

  function uploadWithCaptions(albumId, files, idx) {
    if (idx >= files.length) {
      toast('Photos uploaded!');
      setTimeout(function(){ location.reload(); }, 1200);
      return;
    }
    var caption = window.prompt('Caption for photo '+(idx+1)+' of '+files.length+' (optional):') || '';
    toast('Uploading '+(idx+1)+'/'+files.length+'...');
    var fd = new FormData();
    fd.append('photo', files[idx]);
    fd.append('album_id', albumId);
    fd.append('caption', caption);
    fetch(_rest+'/fw-upload-album-photo',{method:'POST',headers:{'Authorization':'Bearer '+_token},body:fd})
      .then(function(){ uploadWithCaptions(albumId, files, idx+1); })
      .catch(function(){ toast('Photo '+(idx+1)+' failed', true); uploadWithCaptions(albumId, files, idx+1); });
  }

  /* ── Blog Editor ── */
  window.openBlogEditor = function() {
    document.getElementById('blogEditId').value='';
    document.getElementById('blogTitle').value='';
    document.getElementById('blogBody').innerHTML='';
    document.getElementById('blogCoverUrl').value='';
    document.getElementById('blogCoverPreview').innerHTML='';
    document.getElementById('blogMsg').textContent='';
    document.getElementById('blogEditor').style.display='block';
    document.getElementById('blogTitle').focus();
  };

  window.editBlog = function(id, title) {
    document.getElementById('blogEditId').value=id||'';
    document.getElementById('blogTitle').value=title||'';
    document.getElementById('blogBody').innerHTML='';
    document.getElementById('blogCoverUrl').value='';
    document.getElementById('blogCoverPreview').innerHTML='';
    document.getElementById('blogMsg').textContent='';
    document.getElementById('blogEditor').style.display='block';
    document.getElementById('blogEditor').scrollIntoView({behavior:'smooth'});
    if (id) {
      fetch(_rest+'/fw-get-blog-content?id='+id,{headers:{'Authorization':'Bearer '+_token}})
        .then(function(r){return r.json();})
        .then(function(d){ if(d.blog){ document.getElementById('blogBody').innerHTML=d.blog.body||''; if(d.blog.cover_image){document.getElementById('blogCoverUrl').value=d.blog.cover_image;document.getElementById('blogCoverPreview').innerHTML='<img src="'+d.blog.cover_image+'" style="width:100%;max-height:200px;object-fit:cover;border-radius:2px;margin-bottom:8px">';} } })
        .catch(function(){});
    }
  };

  /* ── Rich Text Editor Helpers ── */
  window.fwFmt = function(cmd) {
    var ed = document.getElementById('blogBody');
    if (ed) ed.focus();
    document.execCommand(cmd, false, null);
  };
  window.fwFmtBlock = function(tag) {
    var ed = document.getElementById('blogBody');
    if (ed) ed.focus();
    document.execCommand('formatBlock', false, tag);
  };
  window.fwInsertLink = function() {
    var ed = document.getElementById('blogBody');
    if (ed) ed.focus();
    var url = prompt('Enter link URL (include https://):');
    if (url && url.trim()) {
      var sel = window.getSelection();
      if (sel && sel.toString().length > 0) {
        document.execCommand('createLink', false, url.trim());
      } else {
        var text = prompt('Link text:') || url;
        document.execCommand('insertHTML', false, '<a href="' + url.trim() + '" target="_blank">' + text + '</a>');
      }
    }
  };
  window.fwInsertInlinePhoto = async function(input) {
    if (!input.files[0]) return;
    var ed = document.getElementById('blogBody');
    /* Save cursor position before async upload */
    var savedSel = null;
    try {
      var sel = window.getSelection();
      if (sel && sel.rangeCount) savedSel = sel.getRangeAt(0).cloneRange();
    } catch(e) {}
    toast('Uploading photo...');
    try {
      var fd = new FormData(); fd.append('photo', input.files[0]);
      var r = await fetch(_rest+'/fw-upload-blog-cover', {method:'POST', headers:{'Authorization':'Bearer '+_token}, body:fd});
      var d = await r.json();
      if (!r.ok) throw new Error(d.message||'Upload failed');
      /* Restore cursor and insert image */
      if (ed) {
        ed.focus();
        try {
          var sel2 = window.getSelection();
          if (savedSel && ed.contains(savedSel.startContainer)) {
            sel2.removeAllRanges(); sel2.addRange(savedSel);
          }
        } catch(e) {}
        document.execCommand('insertHTML', false,
          '<figure style="margin:16px 0;padding:0"><img src="' + d.url + '" style="max-width:100%;border-radius:3px;display:block" alt=""></figure>');
      }
      toast('Photo inserted');
    } catch(e) { toast(e.message||'Upload failed', true); }
    input.value = '';
  };

  window.uploadBlogCover = async function(input) {
    if (!input.files[0]) return;
    toast('Uploading cover...');
    var fd = new FormData(); fd.append('photo', input.files[0]);
    try {
      var r = await fetch(_rest+'/fw-upload-blog-cover',{method:'POST',headers:{'Authorization':'Bearer '+_token},body:fd});
      var d = await r.json();
      if (!r.ok) throw new Error(d.message);
      document.getElementById('blogCoverUrl').value=d.url;
      document.getElementById('blogCoverPreview').innerHTML='<img src="'+d.url+'" style="width:100%;max-height:200px;object-fit:cover;border-radius:2px;margin-bottom:8px">';
      toast('Cover uploaded');
    } catch(e) { toast(e.message||'Failed', true); }
  };

  window.saveBlog = async function(status) {
    var id    = (document.getElementById('blogEditId')||{}).value||'';
    var title = (document.getElementById('blogTitle')||{}).value||'';
    var bodyEl = document.getElementById('blogBody');
    var body  = bodyEl ? bodyEl.innerHTML : '';
    var bodyText = bodyEl ? (bodyEl.innerText||bodyEl.textContent||'') : '';
    var cover = (document.getElementById('blogCoverUrl')||{}).value||'';
    var msg   = document.getElementById('blogMsg');
    if (!title.trim()) { if(msg){msg.textContent='Please enter a title.';msg.style.color='#f87171';} return; }
    if (!bodyText.trim())  { if(msg){msg.textContent='Please write your blog.';msg.style.color='#f87171';} return; }
    try {
      var r = await fetch(_rest+'/fw-save-blog',{method:'POST',headers:{'Content-Type':'application/json','Authorization':'Bearer '+_token},body:JSON.stringify({id:id||null,title:title,body:body,cover_image:cover,status:status})});
      var d = await r.json();
      if (!r.ok) throw new Error(d.message||'Failed');
      if(msg){msg.textContent=status==='pending'?'Submitted! Earn 100 credits on approval.':'Draft saved.';msg.style.color='#4ade80';}
      setTimeout(function(){ location.reload(); }, 1500);
    } catch(e) { if(msg){msg.textContent=e.message;msg.style.color='#f87171';} }
  };

  /* ── Logout ── */
  window.doLogout = async function() {
    try {
      localStorage.removeItem('fw_session');
      if (window._fw_sb) await window._fw_sb.auth.signOut();
    } catch(e) {}
    window.location.href = (window.FW_AUTH&&FW_AUTH.home_url)||'/';
  };

  /* ── Session Timeout: 10 min inactivity ── */
  (function() {
    var TIMEOUT = 10 * 60 * 1000;
    var timer;
    function resetTimer() {
      clearTimeout(timer);
      timer = setTimeout(function() {
        localStorage.removeItem('fw_session');
        toast('Session expired due to inactivity. Redirecting...');
        setTimeout(function(){ window.location.href=(window.FW_AUTH&&FW_AUTH.login_url)||'/login/'; }, 2000);
      }, TIMEOUT);
    }
    ['click','keydown','scroll','mousemove','touchstart'].forEach(function(e) {
      document.addEventListener(e, resetTimer, {passive:true});
    });
    resetTimer();
  })();


});
</script>

<?php get_footer(); ?>
