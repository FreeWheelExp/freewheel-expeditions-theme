<?php
/**
 * Template Name: Past Expeditions
 * Template Post Type: page
 *
 * FreeWheel Expeditions — Past Expeditions
 * Template: page-expeditions
 */
get_header();
// ── Schema: BreadcrumbList ────────────────────────────────────────
$bc_schema = [
    "@context"        => "https://schema.org",
    "@type"           => "BreadcrumbList",
    "itemListElement" => [
        ["@type" => "ListItem", "position" => 1, "name" => "Home",        "item" => home_url('/')],
        ["@type" => "ListItem", "position" => 2, "name" => "Expeditions", "item" => get_permalink()]
    ]
];
echo '<script type="application/ld+json">' . json_encode($bc_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
 ?>
<style>

/* ═══ FORCE DARK THEME — Override WordPress/GoDaddy default styles ═══ */
html, body, body.page, #page, #content, #primary, #main,
.site, .site-content, .entry-content, .wp-site-blocks, main, article {
    background: #0f0d0b !important;
    background-color: #0f0d0b !important;
    color: #ffffff !important;
}
.entry-content, .page-content, #primary, #main, main {
    padding: 0 !important;
    margin: 0 !important;
    max-width: 100% !important;
    width: 100% !important;
}
a { color: inherit; }
.site-header, .wp-block-template-part[class*="header"] { display: none !important; }
/* ═══════════════════════════════════════════════════════════════ */




*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{--ink:#0f0d0b;--paper:#f7f3ec;--rust:#c1440e;--amber:#e8a020;--teal:#2a7a6e;--sand:#d4b896;--smoke:#e8e2d8;--headline:'Bebas Neue',sans-serif;--body:'Barlow',sans-serif}
html{scroll-behavior:smooth}
body{font-family:var(--body);background:var(--ink);color:#fff;overflow-x:hidden}
nav{position:fixed;top:0;left:0;right:0;z-index:900;display:flex;align-items:center;justify-content:space-between;padding:0 5vw;height:64px;background:rgba(15,13,11,0.97);border-bottom:2px solid var(--rust)}
.nav-logo{display:flex;align-items:center;gap:10px;text-decoration:none}
.nav-logo img{height:40px;width:40px;object-fit:contain;border-radius:50%;border:2px solid var(--amber)}
.nav-brand{font-family:var(--headline);font-size:20px;color:#fff;letter-spacing:2px;line-height:1}
.nav-brand span{display:block;font-family:var(--body);font-size:9px;font-weight:300;letter-spacing:4px;text-transform:uppercase;color:var(--amber)}
.nav-links{display:flex;gap:24px;list-style:none;align-items:center}
.nav-links a{text-decoration:none;font-size:12px;font-weight:500;letter-spacing:2px;text-transform:uppercase;color:rgba(255,255,255,.65);transition:color .2s}
.nav-links a:hover{color:var(--amber)}
.nav-cta{padding:8px 18px;background:var(--rust) !important;color:#fff !important;border-radius:2px}
.nav-cta:hover{background:#a03508 !important}
.nav-dropdown{position:relative}
.nav-dropdown:hover .nav-drop-menu{display:block}
.nav-drop-menu{display:none;position:absolute;top:100%;left:0;background:#1a1410;border:1px solid rgba(255,255,255,.1);border-top:2px solid var(--rust);min-width:200px;z-index:999;margin-top:8px}
.nav-drop-menu li{list-style:none}
.nav-drop-menu a{display:block;padding:12px 18px;font-size:11px;letter-spacing:2px;text-transform:uppercase;color:rgba(255,255,255,.65);text-decoration:none;white-space:nowrap;transition:background .2s,color .2s}
.nav-drop-menu a:hover{background:rgba(193,68,14,.15);color:var(--amber)}
.hamburger{display:none;flex-direction:column;gap:5px;cursor:pointer;padding:8px;background:none;border:none}
.hamburger span{display:block;width:24px;height:2px;background:#fff;transition:all .3s}
.hamburger.open span:nth-child(1){transform:rotate(45deg) translate(5px,5px)}
.hamburger.open span:nth-child(2){opacity:0}
.hamburger.open span:nth-child(3){transform:rotate(-45deg) translate(5px,-5px)}
.mobile-menu{display:none;position:fixed;top:64px;left:0;right:0;background:#0f0d0b;border-top:2px solid var(--rust);z-index:850;padding:16px 0;flex-direction:column}
.mobile-menu.open{display:flex}
.mobile-menu a{display:block;padding:14px 24px;font-size:13px;font-weight:500;letter-spacing:2px;text-transform:uppercase;color:rgba(255,255,255,.7);text-decoration:none;border-bottom:1px solid rgba(255,255,255,.06)}
.mobile-menu a:hover{color:var(--amber);background:rgba(255,255,255,.03)}
.mobile-menu .mob-cta{background:var(--rust);color:#fff !important;text-align:center;margin:10px 16px;border-radius:2px;border:none}
footer{background:#070503;padding:28px 5vw;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;border-top:1px solid rgba(193,68,14,.3)}
.foot-logo{display:flex;align-items:center;gap:8px}
.foot-logo img{height:30px;border-radius:50%;border:1px solid rgba(255,255,255,.2)}
.foot-brand{font-family:var(--headline);font-size:15px;color:#fff;letter-spacing:2px}
.foot-copy{font-size:11px;color:rgba(255,255,255,.22);font-weight:300}
.foot-links{display:flex;gap:20px}
.foot-links a{font-size:11px;color:rgba(255,255,255,.3);text-decoration:none;letter-spacing:1px;text-transform:uppercase;transition:color .2s}
.foot-links a:hover{color:var(--amber)}
.overlay{position:fixed;inset:0;z-index:1000;background:rgba(8,5,3,.92);display:none;align-items:flex-start;justify-content:center;padding:48px 20px;overflow-y:auto;backdrop-filter:blur(4px)}
.overlay.open{display:flex}
.modal{background:var(--paper);width:100%;max-width:540px;position:relative;animation:slideIn .3s ease}
@keyframes slideIn{from{opacity:0;transform:translateY(30px)}to{opacity:1;transform:translateY(0)}}
.modal-head{background:linear-gradient(135deg,var(--ink),#1e1208);padding:28px 32px 22px;border-bottom:3px solid var(--rust)}
.modal-trip-tag{font-size:10px;letter-spacing:3px;text-transform:uppercase;color:var(--amber);margin-bottom:6px;display:block}
.modal-title{font-family:var(--headline);font-size:26px;color:#fff;letter-spacing:1px;margin-bottom:4px}
.modal-sub{font-size:13px;color:rgba(255,255,255,.45);font-weight:300}
.modal-close{position:absolute;top:16px;right:16px;width:32px;height:32px;background:rgba(255,255,255,.08);border:none;color:#fff;cursor:pointer;font-size:18px;display:flex;align-items:center;justify-content:center;transition:background .2s}
.modal-close:hover{background:var(--rust)}
.modal-body{padding:28px 32px}
.fg{display:flex;flex-direction:column;gap:5px;margin-bottom:14px}
.fg label{font-size:10px;letter-spacing:2px;text-transform:uppercase;color:#8a7052;font-weight:600}
.fg input{padding:12px 14px;border:1px solid rgba(0,0,0,.15);background:#fff;font-family:var(--body);font-size:14px;color:var(--ink);outline:none;transition:border-color .2s;border-radius:2px}
.fg input:focus{border-color:var(--rust)}
.fg-row{display:grid;grid-template-columns:1fr 1fr;gap:12px}
.m-btn{width:100%;padding:14px;background:var(--rust);color:#fff;border:none;font-family:var(--headline);font-size:18px;letter-spacing:2px;cursor:pointer;transition:background .2s;margin-top:6px;border-radius:2px}
.m-btn:hover{background:#a03508}
.m-note{font-size:12px;color:#8a7052;font-weight:300;line-height:1.7;margin-top:10px}
@media(max-width:680px){
  .nav-links{display:none}.hamburger{display:flex}
  footer{flex-direction:column;text-align:center;gap:16px}
  .foot-links{justify-content:center}
  .fg-row{grid-template-columns:1fr}
}


/* ── PAGE HERO ── */
.page-hero{min-height:52vh;background:var(--ink);display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;padding:100px 5vw 60px;position:relative;overflow:hidden;border-bottom:1px solid rgba(255,255,255,.07)}
.page-hero::before{content:'';position:absolute;inset:0;background:radial-gradient(ellipse at center top,rgba(193,68,14,.15) 0%,transparent 60%),radial-gradient(circle at 80% 80%,rgba(232,160,32,.08) 0%,transparent 40%)}
.page-hero-grid{position:absolute;inset:0;background-image:linear-gradient(rgba(255,255,255,.03) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.03) 1px,transparent 1px);background-size:60px 60px}
.page-hero-content{position:relative;z-index:1}
.page-eyebrow{font-size:11px;font-weight:500;letter-spacing:5px;text-transform:uppercase;color:var(--amber);margin-bottom:18px;display:flex;align-items:center;justify-content:center;gap:12px}
.page-eyebrow::before,.page-eyebrow::after{content:'';width:40px;height:1px;background:var(--amber)}
.page-h1{font-family:var(--headline);font-size:clamp(52px,9vw,110px);color:#fff;line-height:.9;letter-spacing:2px;margin-bottom:18px}
.page-h1 span{color:var(--rust)}
.page-desc{font-size:16px;font-weight:300;color:rgba(255,255,255,.45);max-width:520px;margin:0 auto 40px;line-height:1.8}
.page-hero-stats{display:flex;gap:48px;justify-content:center;flex-wrap:wrap;padding-top:32px;border-top:1px solid rgba(255,255,255,.1)}
.pstat{text-align:center}
.pstat-n{font-family:var(--headline);font-size:48px;color:var(--amber);line-height:1;margin-bottom:4px}
.pstat-l{font-size:11px;letter-spacing:3px;text-transform:uppercase;color:rgba(255,255,255,.35)}

/* ── LAYOUT ── */
.exp-layout{display:grid;grid-template-columns:260px 1fr;min-height:100vh;max-width:1400px;margin:0 auto}
.exp-sidebar{position:sticky;top:64px;height:calc(100vh - 64px);overflow-y:auto;background:#0a0805;border-right:1px solid rgba(255,255,255,.06);padding:32px 0;display:flex;flex-direction:column}
.sidebar-heading{font-size:10px;letter-spacing:4px;text-transform:uppercase;color:rgba(255,255,255,.3);padding:0 24px;margin-bottom:16px}
.sidebar-link{display:grid;grid-template-columns:28px 1fr;grid-template-rows:auto auto;align-items:center;gap:0 8px;padding:14px 24px;text-decoration:none;border-left:2px solid transparent;transition:all .2s}
.sidebar-link:hover,.sidebar-link.active{background:rgba(255,255,255,.04);border-left-color:var(--rust)}
.sl-num{font-family:var(--headline);font-size:20px;color:rgba(193,68,14,.4);grid-row:1/3;line-height:1}
.sidebar-link:hover .sl-num,.sidebar-link.active .sl-num{color:var(--rust)}
.sl-name{font-size:13px;font-weight:500;letter-spacing:1px;color:rgba(255,255,255,.6);transition:color .2s}
.sidebar-link:hover .sl-name,.sidebar-link.active .sl-name{color:#fff}
.sl-date{font-size:10px;letter-spacing:2px;text-transform:uppercase;color:rgba(255,255,255,.25)}
.sidebar-cta{margin:auto 16px 0;padding:14px 16px;background:var(--rust);color:#fff;text-align:center;text-decoration:none;font-family:var(--headline);font-size:16px;letter-spacing:2px;border-radius:2px;transition:background .2s}
.sidebar-cta:hover{background:#a03508}
.exp-content{padding:0}

/* ── ALBUM BLOCK ── */
.album-block{scroll-margin-top:70px}
.album-hero{position:relative;height:70vh;min-height:420px;overflow:hidden;display:flex;align-items:flex-end}
.album-hero-bg{position:absolute;inset:0}
.album-hero-grid{position:absolute;inset:0;background-image:linear-gradient(rgba(255,255,255,.02) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.02) 1px,transparent 1px);background-size:40px 40px}
.album-hero::after{content:'';position:absolute;bottom:0;left:0;right:0;height:60%;background:linear-gradient(to top,rgba(8,5,3,1) 0%,transparent 100%);z-index:1}
.album-hero-content{position:relative;z-index:2;padding:40px 48px;width:100%}
.album-eyebrow{display:flex;align-items:center;gap:12px;margin-bottom:12px}
.album-num{font-family:var(--headline);font-size:13px;color:var(--rust);letter-spacing:3px}
.album-divider{width:32px;height:1px;background:rgba(255,255,255,.3)}
.album-date-tag{font-size:11px;letter-spacing:3px;text-transform:uppercase;color:rgba(255,255,255,.4)}
.album-title{font-family:var(--headline);font-size:clamp(48px,6vw,80px);color:#fff;line-height:.9;letter-spacing:2px;margin-bottom:10px}
.album-sub{font-size:15px;font-weight:300;font-style:italic;color:rgba(255,255,255,.5);margin-bottom:22px;max-width:600px;line-height:1.6}
.album-meta{display:flex;gap:10px;flex-wrap:wrap;margin-bottom:16px}
.meta-pill{font-size:12px;font-weight:500;letter-spacing:1px;padding:6px 14px;background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.15);color:rgba(255,255,255,.7);backdrop-filter:blur(4px)}
.album-highlight{display:inline-flex;align-items:baseline;gap:8px;background:rgba(193,68,14,.15);border-left:3px solid var(--rust);padding:10px 16px}
.highlight-label{font-size:9px;letter-spacing:3px;text-transform:uppercase;color:var(--rust);font-weight:600;white-space:nowrap}
.highlight-text{font-size:13px;font-weight:300;font-style:italic;color:rgba(255,255,255,.7);line-height:1.5}

/* ── ALBUM BODY ── */
.album-body{background:#0a0805;padding:32px 48px 48px}
.album-body-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;padding-bottom:14px;border-bottom:1px solid rgba(255,255,255,.07)}
.sec-eyebrow{font-size:10px;letter-spacing:4px;text-transform:uppercase;color:var(--amber);font-weight:600}
.photo-count{font-size:11px;letter-spacing:2px;text-transform:uppercase;color:rgba(255,255,255,.3)}

/* ── PHOTO GRID ── */
.album-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:3px}
.album-thumb{position:relative;aspect-ratio:16/9;overflow:hidden;cursor:pointer;background:#1a1410}
.album-thumb.empty-slot{background:linear-gradient(135deg,#1a1410,#0f0d0b);border:1px dashed rgba(255,255,255,.08)}
.album-thumb img{transition:transform .4s ease}
.album-thumb:hover img{transform:scale(1.05)}
.thumb-overlay{position:absolute;inset:0;background:rgba(0,0,0,0);display:flex;align-items:center;justify-content:center;font-size:28px;opacity:0;transition:all .3s}
.album-thumb:hover .thumb-overlay{background:rgba(193,68,14,.35);opacity:1}
.thumb-num{position:absolute;bottom:8px;right:10px;font-size:9px;letter-spacing:2px;text-transform:uppercase;color:rgba(255,255,255,.3);background:rgba(0,0,0,.4);padding:3px 8px;opacity:0;transition:opacity .3s}
.album-thumb.empty-slot .thumb-num{opacity:1;font-size:10px;top:50%;left:50%;transform:translate(-50%,-50%);bottom:auto;right:auto;background:none;color:rgba(255,255,255,.2);text-align:center;letter-spacing:3px}
.album-thumb:hover .thumb-num{opacity:1}

/* ── ALBUM FOOTER ── */
.album-footer-bar{display:flex;gap:12px;margin-top:20px;flex-wrap:wrap}
.album-ig-btn,.album-wa-btn{flex:1;min-width:160px;padding:14px 20px;text-align:center;text-decoration:none;font-family:var(--headline);font-size:16px;letter-spacing:2px;transition:all .2s;border-radius:2px}
.album-ig-btn{background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.15);color:rgba(255,255,255,.7)}
.album-ig-btn:hover{background:rgba(255,255,255,.1);color:#fff}
.album-wa-btn{background:#25d366;color:#fff}
.album-wa-btn:hover{background:#1da851}

/* ── SEPARATOR ── */
.album-separator{height:1px;background:linear-gradient(to right,transparent,rgba(255,255,255,.08) 20%,rgba(255,255,255,.08) 80%,transparent);margin:0 48px}

/* ── LIGHTBOX ── */
.lightbox{position:fixed;inset:0;z-index:2000;background:rgba(0,0,0,.97);display:none;align-items:center;justify-content:center;padding:20px}
.lightbox.open{display:flex}
.lb-inner{position:relative;width:100%;max-width:1100px}
.lb-img-wrap{position:relative;width:100%;aspect-ratio:16/9;background:#111;overflow:hidden}
.lb-img-wrap img{width:100%;height:100%;object-fit:contain}
.lb-placeholder{position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:10px}
.lb-placeholder .ph-ico{font-size:56px;opacity:.2}
.lb-placeholder .ph-txt{font-size:11px;letter-spacing:3px;text-transform:uppercase;color:rgba(255,255,255,.25)}
.lb-placeholder .ph-sub{font-size:12px;color:rgba(255,255,255,.15);font-weight:300}
.lb-close{position:absolute;top:-44px;right:0;background:none;border:none;color:rgba(255,255,255,.5);font-size:28px;cursor:pointer;transition:color .2s;padding:4px 8px}
.lb-close:hover{color:#fff}
.lb-nav{display:flex;justify-content:space-between;align-items:center;margin-top:14px}
.lb-btn{background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.15);color:#fff;padding:10px 22px;cursor:pointer;font-family:var(--headline);font-size:18px;letter-spacing:1px;transition:background .2s;border-radius:2px}
.lb-btn:hover{background:var(--rust);border-color:var(--rust)}
.lb-counter{font-size:12px;letter-spacing:3px;text-transform:uppercase;color:rgba(255,255,255,.4)}

/* ── MOBILE ── */
@media(max-width:900px){
  .exp-layout{grid-template-columns:1fr}
  .exp-sidebar{display:none}
  .album-hero{height:52vh;min-height:320px}
  .album-hero-content{padding:24px 20px}
  .album-title{font-size:clamp(38px,8vw,60px)}
  .album-body{padding:20px 16px 32px}
  .album-grid{grid-template-columns:repeat(2,1fr)}
  .album-footer-bar{flex-direction:column}
  .album-ig-btn,.album-wa-btn{min-width:0}
  .page-hero-stats{gap:24px}
  .pstat-n{font-size:36px}
}
@media(max-width:480px){
  .album-grid{grid-template-columns:1fr}
}


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

</style>

<!-- PAGE HERO -->
<section class="page-hero">
  <div class="page-hero-grid"></div>
  <div class="page-hero-content">
    <div class="page-eyebrow">Every Road Tells a Story</div>
    <h1 class="page-h1">Past<br><span>Expeditions</span></h1>
    <p class="page-desc">Every journey we've completed lives here — raw, real, and unforgettable. Browse the albums, relive the roads.</p>
    <div class="page-hero-stats">
      <div class="pstat"><div class="pstat-n">6</div><div class="pstat-l">Expeditions Done</div></div>
      <div class="pstat"><div class="pstat-n">118+</div><div class="pstat-l">Travellers</div></div>
      <div class="pstat"><div class="pstat-n">6</div><div class="pstat-l">States Covered</div></div>
      <div class="pstat"><div class="pstat-n">3,00,000+</div><div class="pstat-l">Kms Driven</div></div>
    </div>
  </div>
</section>

<!-- MAIN LAYOUT -->
<div class="exp-layout">

  <!-- SIDEBAR NAV -->
  <aside class="exp-sidebar">
    <div class="sidebar-heading">Jump to Album</div>
    <a href="#winter-spiti-2026" class="sidebar-link"><span class="sl-num">01</span><span class="sl-name">Winter Spiti</span><span class="sl-date">February 2026</span></a>
<a href="#nature-retreat-2026" class="sidebar-link"><span class="sl-num">02</span><span class="sl-name">Nature Retreat</span><span class="sl-date">January 2026</span></a>
<a href="#darma-valley-2025" class="sidebar-link"><span class="sl-num">03</span><span class="sl-name">Darma Valley</span><span class="sl-date">December 2025</span></a>
<a href="#spiti-summer-2025" class="sidebar-link"><span class="sl-num">04</span><span class="sl-name">Spiti Summer Drive</span><span class="sl-date">July 2025</span></a>
<a href="#leh-winter-2025" class="sidebar-link"><span class="sl-num">05</span><span class="sl-name">Leh Winter Circuit</span><span class="sl-date">February 2025</span></a>
<a href="#kumaon-explorer-2024" class="sidebar-link"><span class="sl-num">06</span><span class="sl-name">Kumaon Explorer</span><span class="sl-date">October 2024</span></a>

    <a href="<?php echo home_url('/'); ?>#upcoming" class="sidebar-cta">View Upcoming →</a>
  </aside>

  <!-- ALBUMS -->
  <main class="exp-content">
    
  <!-- ════ ALBUM: Winter Spiti ════ -->
  <article class="album-block" id="winter-spiti-2026">
    <div class="album-hero">
      <!-- COVER PHOTO: 16:9, min 1920×1080px. Add src="your-cover.jpg" to the img below -->
      <img class="album-cover" src="https://images.unsplash.com/photo-1605649487212-47bdab064df7?w=1920&q=85" alt="Winter Spiti cover"
           onerror="this.style.display='none'"
           style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;object-position:center;opacity:0.55">
      <div class="album-hero-bg" style="background:linear-gradient(145deg,#0a1820,#0f0d0b 60%)"></div>
      <div class="album-hero-grid"></div>
      <div class="album-hero-content">
        <div class="album-eyebrow">
          <span class="album-num">01</span>
          <span class="album-divider">——</span>
          <span class="album-date-tag">February 2026</span>
        </div>
        <h2 class="album-title">Winter Spiti</h2>
        <p class="album-sub">Frozen in time — snowbound monasteries and subzero passes</p>
        <div class="album-meta">
          <div class="meta-pill">⏱ 10N / 11D</div>
          <div class="meta-pill">👥 22 Travellers</div>
          <div class="meta-pill">📍 Himachal Pradesh</div>
        </div>
        <div class="album-highlight">
          <span class="highlight-label">Trip Highlight</span>
          <span class="highlight-text">"Chandrataal frozen lake & Key Monastery under snow"</span>
        </div>
      </div>
    </div>

    <div class="album-body">
      <div class="album-body-header">
        <div class="sec-eyebrow">Photo Gallery</div>
        <div class="photo-count">12 Photos</div>
      </div>
      <div class="album-grid">
        <div class="album-thumb" onclick="openLightbox('winter-spiti-2026',0)">
          <img src="https://images.unsplash.com/photo-1605649487212-47bdab064df7?w=800&q=80" alt="Spiti Valley winter road" data-album="winter-spiti-2026" data-idx="0"
               onerror="this.parentElement.classList.add('empty-slot')"
               style="width:100%;height:100%;object-fit:cover;object-position:center">
          <div class="thumb-overlay"><span>🔍</span></div>
          <div class="thumb-num">Photo 1</div>
        </div>
        <div class="album-thumb" onclick="openLightbox('winter-spiti-2026',1)">
          <img src="https://images.unsplash.com/photo-1587474260584-136574528ed5?w=800&q=80" alt="Himalayan monastery snow" data-album="winter-spiti-2026" data-idx="1"
               onerror="this.parentElement.classList.add('empty-slot')"
               style="width:100%;height:100%;object-fit:cover;object-position:center">
          <div class="thumb-overlay"><span>🔍</span></div>
          <div class="thumb-num">Photo 2</div>
        </div>
        <div class="album-thumb" onclick="openLightbox('winter-spiti-2026',2)">
          <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=800&q=80" alt="Frozen mountain pass" data-album="winter-spiti-2026" data-idx="2"
               onerror="this.parentElement.classList.add('empty-slot')"
               style="width:100%;height:100%;object-fit:cover;object-position:center">
          <div class="thumb-overlay"><span>🔍</span></div>
          <div class="thumb-num">Photo 3</div>
        </div>
        <div class="album-thumb" onclick="openLightbox('winter-spiti-2026',3)">
          <img src="https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=800&q=80" alt="Snow covered peaks" data-album="winter-spiti-2026" data-idx="3"
               onerror="this.parentElement.classList.add('empty-slot')"
               style="width:100%;height:100%;object-fit:cover;object-position:center">
          <div class="thumb-overlay"><span>🔍</span></div>
          <div class="thumb-num">Photo 4</div>
        </div>
        <div class="album-thumb" onclick="openLightbox('winter-spiti-2026',4)">
          <img src="https://images.unsplash.com/photo-1531366936337-7c912a4589a7?w=800&q=80" alt="Mountain landscape" data-album="winter-spiti-2026" data-idx="4"
               onerror="this.parentElement.classList.add('empty-slot')"
               style="width:100%;height:100%;object-fit:cover;object-position:center">
          <div class="thumb-overlay"><span>🔍</span></div>
          <div class="thumb-num">Photo 5</div>
        </div>
        <div class="album-thumb" onclick="openLightbox('winter-spiti-2026',5)">
          <img src="https://images.unsplash.com/photo-1486870591958-9b9d0d1dda99?w=800&q=80" alt="Road trip mountains" data-album="winter-spiti-2026" data-idx="5"
               onerror="this.parentElement.classList.add('empty-slot')"
               style="width:100%;height:100%;object-fit:cover;object-position:center">
          <div class="thumb-overlay"><span>🔍</span></div>
          <div class="thumb-num">Photo 6</div>
        </div>
        <div class="album-thumb" onclick="openLightbox('winter-spiti-2026',6)">
          <img src="https://images.unsplash.com/photo-1519681393784-d120267933ba?w=800&q=80" alt="Starry night mountains" data-album="winter-spiti-2026" data-idx="6"
               onerror="this.parentElement.classList.add('empty-slot')"
               style="width:100%;height:100%;object-fit:cover;object-position:center">
          <div class="thumb-overlay"><span>🔍</span></div>
          <div class="thumb-num">Photo 7</div>
        </div>
        <div class="album-thumb" onclick="openLightbox('winter-spiti-2026',7)">
          <img src="https://images.unsplash.com/photo-1597240814775-a0e09ceee438?w=800&q=80" alt="Barren mountain terrain" data-album="winter-spiti-2026" data-idx="7"
               onerror="this.parentElement.classList.add('empty-slot')"
               style="width:100%;height:100%;object-fit:cover;object-position:center">
          <div class="thumb-overlay"><span>🔍</span></div>
          <div class="thumb-num">Photo 8</div>
        </div>
        <div class="album-thumb" onclick="openLightbox('winter-spiti-2026',8)">
          <img src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800&q=80" alt="High altitude lake" data-album="winter-spiti-2026" data-idx="8"
               onerror="this.parentElement.classList.add('empty-slot')"
               style="width:100%;height:100%;object-fit:cover;object-position:center">
          <div class="thumb-overlay"><span>🔍</span></div>
          <div class="thumb-num">Photo 9</div>
        </div>
        <div class="album-thumb" onclick="openLightbox('winter-spiti-2026',9)">
          <img src="https://images.unsplash.com/photo-1544735716-392fe2489ffa?w=800&q=80" alt="Himalayan valley" data-album="winter-spiti-2026" data-idx="9"
               onerror="this.parentElement.classList.add('empty-slot')"
               style="width:100%;height:100%;object-fit:cover;object-position:center">
          <div class="thumb-overlay"><span>🔍</span></div>
          <div class="thumb-num">Photo 10</div>
        </div>
        <div class="album-thumb" onclick="openLightbox('winter-spiti-2026',10)">
          <img src="https://images.unsplash.com/photo-1469474968028-56623f02e42e?w=800&q=80" alt="Mountain river valley" data-album="winter-spiti-2026" data-idx="10"
               onerror="this.parentElement.classList.add('empty-slot')"
               style="width:100%;height:100%;object-fit:cover;object-position:center">
          <div class="thumb-overlay"><span>🔍</span></div>
          <div class="thumb-num">Photo 11</div>
        </div>
        <div class="album-thumb" onclick="openLightbox('winter-spiti-2026',11)">
          <img src="https://images.unsplash.com/photo-1448375240586-882707db888b?w=800&q=80" alt="Forest mountain trail" data-album="winter-spiti-2026" data-idx="11"
               onerror="this.parentElement.classList.add('empty-slot')"
               style="width:100%;height:100%;object-fit:cover;object-position:center">
          <div class="thumb-overlay"><span>🔍</span></div>
          <div class="thumb-num">Photo 12</div>
        </div>
        </div>
      <div class="album-footer-bar">
        <a href="https://instagram.com/freewheelexpeditions" target="_blank" class="album-ig-btn">📸 More on Instagram</a>
        <a href="https://wa.me/917817838060?text=Hi%21%20Tell%20me%20more%20about%20Winter%20Spiti" target="_blank" class="album-wa-btn">💬 Ask About This Trip</a>
      </div>
    </div>
  </article>
  <div class="album-separator"></div>
  <!-- ════ ALBUM: Nature Retreat ════ -->
  <article class="album-block" id="nature-retreat-2026">
    <div class="album-hero">
      <!-- COVER PHOTO: 16:9, min 1920×1080px. Add src="your-cover.jpg" to the img below -->
      <img class="album-cover" src="https://images.unsplash.com/photo-1448375240586-882707db888b?w=1920&q=85" alt="Nature Retreat cover"
           onerror="this.style.display='none'"
           style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;object-position:center;opacity:0.55">
      <div class="album-hero-bg" style="background:linear-gradient(145deg,#0a1a0a,#0f0d0b 60%)"></div>
      <div class="album-hero-grid"></div>
      <div class="album-hero-content">
        <div class="album-eyebrow">
          <span class="album-num">02</span>
          <span class="album-divider">——</span>
          <span class="album-date-tag">January 2026</span>
        </div>
        <h2 class="album-title">Nature Retreat</h2>
        <p class="album-sub">Unplugged in the Kumaon hills — waterfalls, pine forests, silence</p>
        <div class="album-meta">
          <div class="meta-pill">⏱ 5N / 6D</div>
          <div class="meta-pill">👥 14 Travellers</div>
          <div class="meta-pill">📍 Uttarakhand</div>
        </div>
        <div class="album-highlight">
          <span class="highlight-label">Trip Highlight</span>
          <span class="highlight-text">"Munsiyari sunrise over Panchachuli peaks"</span>
        </div>
      </div>
    </div>

    <div class="album-body">
      <div class="album-body-header">
        <div class="sec-eyebrow">Photo Gallery</div>
        <div class="photo-count">12 Photos</div>
      </div>
      <div class="album-grid">
        <div class="album-thumb" onclick="openLightbox('nature-retreat-2026',0)">
          <img src="https://images.unsplash.com/photo-1448375240586-882707db888b?w=800&q=80" alt="Forest nature retreat" data-album="nature-retreat-2026" data-idx="0"
               onerror="this.parentElement.classList.add('empty-slot')"
               style="width:100%;height:100%;object-fit:cover;object-position:center">
          <div class="thumb-overlay"><span>🔍</span></div>
          <div class="thumb-num">Photo 1</div>
        </div>
        <div class="album-thumb" onclick="openLightbox('nature-retreat-2026',1)">
          <img src="https://images.unsplash.com/photo-1501854140801-50d01698950b?w=800&q=80" alt="Green valleys" data-album="nature-retreat-2026" data-idx="1"
               onerror="this.parentElement.classList.add('empty-slot')"
               style="width:100%;height:100%;object-fit:cover;object-position:center">
          <div class="thumb-overlay"><span>🔍</span></div>
          <div class="thumb-num">Photo 2</div>
        </div>
        <div class="album-thumb" onclick="openLightbox('nature-retreat-2026',2)">
          <img src="https://images.unsplash.com/photo-1511497584788-876760111969?w=800&q=80" alt="Mountain forest" data-album="nature-retreat-2026" data-idx="2"
               onerror="this.parentElement.classList.add('empty-slot')"
               style="width:100%;height:100%;object-fit:cover;object-position:center">
          <div class="thumb-overlay"><span>🔍</span></div>
          <div class="thumb-num">Photo 3</div>
        </div>
        <div class="album-thumb" onclick="openLightbox('nature-retreat-2026',3)">
          <img src="https://images.unsplash.com/photo-1470071459604-3b5ec3a7fe05?w=800&q=80" alt="Misty mountains" data-album="nature-retreat-2026" data-idx="3"
               onerror="this.parentElement.classList.add('empty-slot')"
               style="width:100%;height:100%;object-fit:cover;object-position:center">
          <div class="thumb-overlay"><span>🔍</span></div>
          <div class="thumb-num">Photo 4</div>
        </div>
        <div class="album-thumb" onclick="openLightbox('nature-retreat-2026',4)">
          <img src="https://images.unsplash.com/photo-1540390769625-2fc3f8b1d50c?w=800&q=80" alt="Jungle stream" data-album="nature-retreat-2026" data-idx="4"
               onerror="this.parentElement.classList.add('empty-slot')"
               style="width:100%;height:100%;object-fit:cover;object-position:center">
          <div class="thumb-overlay"><span>🔍</span></div>
          <div class="thumb-num">Photo 5</div>
        </div>
        <div class="album-thumb" onclick="openLightbox('nature-retreat-2026',5)">
          <img src="https://images.unsplash.com/photo-1500534314209-a25ddb2bd429?w=800&q=80" alt="Camping in nature" data-album="nature-retreat-2026" data-idx="5"
               onerror="this.parentElement.classList.add('empty-slot')"
               style="width:100%;height:100%;object-fit:cover;object-position:center">
          <div class="thumb-overlay"><span>🔍</span></div>
          <div class="thumb-num">Photo 6</div>
        </div>
        <div class="album-thumb" onclick="openLightbox('nature-retreat-2026',6)">
          <img src="https://images.unsplash.com/photo-1469474968028-56623f02e42e?w=800&q=80" alt="Valley view" data-album="nature-retreat-2026" data-idx="6"
               onerror="this.parentElement.classList.add('empty-slot')"
               style="width:100%;height:100%;object-fit:cover;object-position:center">
          <div class="thumb-overlay"><span>🔍</span></div>
          <div class="thumb-num">Photo 7</div>
        </div>
        <div class="album-thumb" onclick="openLightbox('nature-retreat-2026',7)">
          <img src="https://images.unsplash.com/photo-1458442310124-dde6edb43d10?w=800&q=80" alt="Trek through forest" data-album="nature-retreat-2026" data-idx="7"
               onerror="this.parentElement.classList.add('empty-slot')"
               style="width:100%;height:100%;object-fit:cover;object-position:center">
          <div class="thumb-overlay"><span>🔍</span></div>
          <div class="thumb-num">Photo 8</div>
        </div>
        <div class="album-thumb" onclick="openLightbox('nature-retreat-2026',8)">
          <img src="https://images.unsplash.com/photo-1519681393784-d120267933ba?w=800&q=80" alt="Alpine meadows" data-album="nature-retreat-2026" data-idx="8"
               onerror="this.parentElement.classList.add('empty-slot')"
               style="width:100%;height:100%;object-fit:cover;object-position:center">
          <div class="thumb-overlay"><span>🔍</span></div>
          <div class="thumb-num">Photo 9</div>
        </div>
        <div class="album-thumb" onclick="openLightbox('nature-retreat-2026',9)">
          <img src="https://images.unsplash.com/photo-1531366936337-7c912a4589a7?w=800&q=80" alt="Mountain peaks" data-album="nature-retreat-2026" data-idx="9"
               onerror="this.parentElement.classList.add('empty-slot')"
               style="width:100%;height:100%;object-fit:cover;object-position:center">
          <div class="thumb-overlay"><span>🔍</span></div>
          <div class="thumb-num">Photo 10</div>
        </div>
        <div class="album-thumb" onclick="openLightbox('nature-retreat-2026',10)">
          <img src="https://images.unsplash.com/photo-1486870591958-9b9d0d1dda99?w=800&q=80" alt="Road through jungle" data-album="nature-retreat-2026" data-idx="10"
               onerror="this.parentElement.classList.add('empty-slot')"
               style="width:100%;height:100%;object-fit:cover;object-position:center">
          <div class="thumb-overlay"><span>🔍</span></div>
          <div class="thumb-num">Photo 11</div>
        </div>
        <div class="album-thumb" onclick="openLightbox('nature-retreat-2026',11)">
          <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=800&q=80" alt="Snow peaks panorama" data-album="nature-retreat-2026" data-idx="11"
               onerror="this.parentElement.classList.add('empty-slot')"
               style="width:100%;height:100%;object-fit:cover;object-position:center">
          <div class="thumb-overlay"><span>🔍</span></div>
          <div class="thumb-num">Photo 12</div>
        </div>
        </div>
      <div class="album-footer-bar">
        <a href="https://instagram.com/freewheelexpeditions" target="_blank" class="album-ig-btn">📸 More on Instagram</a>
        <a href="https://wa.me/917817838060?text=Hi%21%20Tell%20me%20more%20about%20Nature%20Retreat" target="_blank" class="album-wa-btn">💬 Ask About This Trip</a>
      </div>
    </div>
  </article>
  <div class="album-separator"></div>
  <!-- ════ ALBUM: Darma Valley ════ -->
  <article class="album-block" id="darma-valley-2025">
    <div class="album-hero">
      <!-- COVER PHOTO: 16:9, min 1920×1080px. Add src="your-cover.jpg" to the img below -->
      <img class="album-cover" src="https://images.unsplash.com/photo-1544735716-392fe2489ffa?w=1920&q=85" alt="Darma Valley cover"
           onerror="this.style.display='none'"
           style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;object-position:center;opacity:0.55">
      <div class="album-hero-bg" style="background:linear-gradient(145deg,#1a0a0a,#0f0d0b 60%)"></div>
      <div class="album-hero-grid"></div>
      <div class="album-hero-content">
        <div class="album-eyebrow">
          <span class="album-num">03</span>
          <span class="album-divider">——</span>
          <span class="album-date-tag">December 2025</span>
        </div>
        <h2 class="album-title">Darma Valley</h2>
        <p class="album-sub">The hidden gem — India's least explored Himalayan valley</p>
        <div class="album-meta">
          <div class="meta-pill">⏱ 7N / 8D</div>
          <div class="meta-pill">👥 18 Travellers</div>
          <div class="meta-pill">📍 Uttarakhand</div>
        </div>
        <div class="album-highlight">
          <span class="highlight-label">Trip Highlight</span>
          <span class="highlight-text">"Sipu Gad river crossing & Duktu village"</span>
        </div>
      </div>
    </div>

    <div class="album-body">
      <div class="album-body-header">
        <div class="sec-eyebrow">Photo Gallery</div>
        <div class="photo-count">12 Photos</div>
      </div>
      <div class="album-grid">
        <div class="album-thumb" onclick="openLightbox('darma-valley-2025',0)">
          <img src="https://images.unsplash.com/photo-1544735716-392fe2489ffa?w=800&q=80" alt="Himalayan valley" data-album="darma-valley-2025" data-idx="0"
               onerror="this.parentElement.classList.add('empty-slot')"
               style="width:100%;height:100%;object-fit:cover;object-position:center">
          <div class="thumb-overlay"><span>🔍</span></div>
          <div class="thumb-num">Photo 1</div>
        </div>
        <div class="album-thumb" onclick="openLightbox('darma-valley-2025',1)">
          <img src="https://images.unsplash.com/photo-1469474968028-56623f02e42e?w=800&q=80" alt="Mountain river valley" data-album="darma-valley-2025" data-idx="1"
               onerror="this.parentElement.classList.add('empty-slot')"
               style="width:100%;height:100%;object-fit:cover;object-position:center">
          <div class="thumb-overlay"><span>🔍</span></div>
          <div class="thumb-num">Photo 2</div>
        </div>
        <div class="album-thumb" onclick="openLightbox('darma-valley-2025',2)">
          <img src="https://images.unsplash.com/photo-1522163182402-834f871fd851?w=800&q=80" alt="Remote mountain village" data-album="darma-valley-2025" data-idx="2"
               onerror="this.parentElement.classList.add('empty-slot')"
               style="width:100%;height:100%;object-fit:cover;object-position:center">
          <div class="thumb-overlay"><span>🔍</span></div>
          <div class="thumb-num">Photo 3</div>
        </div>
        <div class="album-thumb" onclick="openLightbox('darma-valley-2025',3)">
          <img src="https://images.unsplash.com/photo-1458442310124-dde6edb43d10?w=800&q=80" alt="Trek through forest" data-album="darma-valley-2025" data-idx="3"
               onerror="this.parentElement.classList.add('empty-slot')"
               style="width:100%;height:100%;object-fit:cover;object-position:center">
          <div class="thumb-overlay"><span>🔍</span></div>
          <div class="thumb-num">Photo 4</div>
        </div>
        <div class="album-thumb" onclick="openLightbox('darma-valley-2025',4)">
          <img src="https://images.unsplash.com/photo-1519681393784-d120267933ba?w=800&q=80" alt="Alpine meadows" data-album="darma-valley-2025" data-idx="4"
               onerror="this.parentElement.classList.add('empty-slot')"
               style="width:100%;height:100%;object-fit:cover;object-position:center">
          <div class="thumb-overlay"><span>🔍</span></div>
          <div class="thumb-num">Photo 5</div>
        </div>
        <div class="album-thumb" onclick="openLightbox('darma-valley-2025',5)">
          <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=800&q=80" alt="Snow peaks panorama" data-album="darma-valley-2025" data-idx="5"
               onerror="this.parentElement.classList.add('empty-slot')"
               style="width:100%;height:100%;object-fit:cover;object-position:center">
          <div class="thumb-overlay"><span>🔍</span></div>
          <div class="thumb-num">Photo 6</div>
        </div>
        <div class="album-thumb" onclick="openLightbox('darma-valley-2025',6)">
          <img src="https://images.unsplash.com/photo-1605649487212-47bdab064df7?w=800&q=80" alt="Mountain road" data-album="darma-valley-2025" data-idx="6"
               onerror="this.parentElement.classList.add('empty-slot')"
               style="width:100%;height:100%;object-fit:cover;object-position:center">
          <div class="thumb-overlay"><span>🔍</span></div>
          <div class="thumb-num">Photo 7</div>
        </div>
        <div class="album-thumb" onclick="openLightbox('darma-valley-2025',7)">
          <img src="https://images.unsplash.com/photo-1448375240586-882707db888b?w=800&q=80" alt="Forest trail" data-album="darma-valley-2025" data-idx="7"
               onerror="this.parentElement.classList.add('empty-slot')"
               style="width:100%;height:100%;object-fit:cover;object-position:center">
          <div class="thumb-overlay"><span>🔍</span></div>
          <div class="thumb-num">Photo 8</div>
        </div>
        <div class="album-thumb" onclick="openLightbox('darma-valley-2025',8)">
          <img src="https://images.unsplash.com/photo-1501854140801-50d01698950b?w=800&q=80" alt="Green valley" data-album="darma-valley-2025" data-idx="8"
               onerror="this.parentElement.classList.add('empty-slot')"
               style="width:100%;height:100%;object-fit:cover;object-position:center">
          <div class="thumb-overlay"><span>🔍</span></div>
          <div class="thumb-num">Photo 9</div>
        </div>
        <div class="album-thumb" onclick="openLightbox('darma-valley-2025',9)">
          <img src="https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=800&q=80" alt="Mountain pass" data-album="darma-valley-2025" data-idx="9"
               onerror="this.parentElement.classList.add('empty-slot')"
               style="width:100%;height:100%;object-fit:cover;object-position:center">
          <div class="thumb-overlay"><span>🔍</span></div>
          <div class="thumb-num">Photo 10</div>
        </div>
        <div class="album-thumb" onclick="openLightbox('darma-valley-2025',10)">
          <img src="https://images.unsplash.com/photo-1531366936337-7c912a4589a7?w=800&q=80" alt="High altitude terrain" data-album="darma-valley-2025" data-idx="10"
               onerror="this.parentElement.classList.add('empty-slot')"
               style="width:100%;height:100%;object-fit:cover;object-position:center">
          <div class="thumb-overlay"><span>🔍</span></div>
          <div class="thumb-num">Photo 11</div>
        </div>
        <div class="album-thumb" onclick="openLightbox('darma-valley-2025',11)">
          <img src="https://images.unsplash.com/photo-1597240814775-a0e09ceee438?w=800&q=80" alt="Desert terrain" data-album="darma-valley-2025" data-idx="11"
               onerror="this.parentElement.classList.add('empty-slot')"
               style="width:100%;height:100%;object-fit:cover;object-position:center">
          <div class="thumb-overlay"><span>🔍</span></div>
          <div class="thumb-num">Photo 12</div>
        </div>
        </div>
      <div class="album-footer-bar">
        <a href="https://instagram.com/freewheelexpeditions" target="_blank" class="album-ig-btn">📸 More on Instagram</a>
        <a href="https://wa.me/917817838060?text=Hi%21%20Tell%20me%20more%20about%20Darma%20Valley" target="_blank" class="album-wa-btn">💬 Ask About This Trip</a>
      </div>
    </div>
  </article>
  <div class="album-separator"></div>
  <!-- ════ ALBUM: Spiti Summer Drive ════ -->
  <article class="album-block" id="spiti-summer-2025">
    <div class="album-hero">
      <!-- COVER PHOTO: 16:9, min 1920×1080px. Add src="your-cover.jpg" to the img below -->
      <img class="album-cover" src="https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=1920&q=85" alt="Spiti Summer Drive cover"
           onerror="this.style.display='none'"
           style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;object-position:center;opacity:0.55">
      <div class="album-hero-bg" style="background:linear-gradient(145deg,#1a1208,#0f0d0b 60%)"></div>
      <div class="album-hero-grid"></div>
      <div class="album-hero-content">
        <div class="album-eyebrow">
          <span class="album-num">04</span>
          <span class="album-divider">——</span>
          <span class="album-date-tag">July 2025</span>
        </div>
        <h2 class="album-title">Spiti Summer Drive</h2>
        <p class="album-sub">Golden hour over the Middle Land — Spiti in full bloom</p>
        <div class="album-meta">
          <div class="meta-pill">⏱ 10N / 11D</div>
          <div class="meta-pill">👥 28 Travellers</div>
          <div class="meta-pill">📍 Himachal Pradesh</div>
        </div>
        <div class="album-highlight">
          <span class="highlight-label">Trip Highlight</span>
          <span class="highlight-text">"Chicham bridge & Hikkim world's highest post office"</span>
        </div>
      </div>
    </div>

    <div class="album-body">
      <div class="album-body-header">
        <div class="sec-eyebrow">Photo Gallery</div>
        <div class="photo-count">12 Photos</div>
      </div>
      <div class="album-grid">
        <div class="album-thumb" onclick="openLightbox('spiti-summer-2025',0)">
          <img src="https://images.unsplash.com/photo-1605649487212-47bdab064df7?w=800&q=80" alt="Spiti Valley road" data-album="spiti-summer-2025" data-idx="0"
               onerror="this.parentElement.classList.add('empty-slot')"
               style="width:100%;height:100%;object-fit:cover;object-position:center">
          <div class="thumb-overlay"><span>🔍</span></div>
          <div class="thumb-num">Photo 1</div>
        </div>
        <div class="album-thumb" onclick="openLightbox('spiti-summer-2025',1)">
          <img src="https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=800&q=80" alt="Kunzum Pass" data-album="spiti-summer-2025" data-idx="1"
               onerror="this.parentElement.classList.add('empty-slot')"
               style="width:100%;height:100%;object-fit:cover;object-position:center">
          <div class="thumb-overlay"><span>🔍</span></div>
          <div class="thumb-num">Photo 2</div>
        </div>
        <div class="album-thumb" onclick="openLightbox('spiti-summer-2025',2)">
          <img src="https://images.unsplash.com/photo-1597240814775-a0e09ceee438?w=800&q=80" alt="Pin Valley desert" data-album="spiti-summer-2025" data-idx="2"
               onerror="this.parentElement.classList.add('empty-slot')"
               style="width:100%;height:100%;object-fit:cover;object-position:center">
          <div class="thumb-overlay"><span>🔍</span></div>
          <div class="thumb-num">Photo 3</div>
        </div>
        <div class="album-thumb" onclick="openLightbox('spiti-summer-2025',3)">
          <img src="https://images.unsplash.com/photo-1519681393784-d120267933ba?w=800&q=80" alt="Milky Way Spiti" data-album="spiti-summer-2025" data-idx="3"
               onerror="this.parentElement.classList.add('empty-slot')"
               style="width:100%;height:100%;object-fit:cover;object-position:center">
          <div class="thumb-overlay"><span>🔍</span></div>
          <div class="thumb-num">Photo 4</div>
        </div>
        <div class="album-thumb" onclick="openLightbox('spiti-summer-2025',4)">
          <img src="https://images.unsplash.com/photo-1531366936337-7c912a4589a7?w=800&q=80" alt="Key Monastery" data-album="spiti-summer-2025" data-idx="4"
               onerror="this.parentElement.classList.add('empty-slot')"
               style="width:100%;height:100%;object-fit:cover;object-position:center">
          <div class="thumb-overlay"><span>🔍</span></div>
          <div class="thumb-num">Photo 5</div>
        </div>
        <div class="album-thumb" onclick="openLightbox('spiti-summer-2025',5)">
          <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=800&q=80" alt="Snow peaks" data-album="spiti-summer-2025" data-idx="5"
               onerror="this.parentElement.classList.add('empty-slot')"
               style="width:100%;height:100%;object-fit:cover;object-position:center">
          <div class="thumb-overlay"><span>🔍</span></div>
          <div class="thumb-num">Photo 6</div>
        </div>
        <div class="album-thumb" onclick="openLightbox('spiti-summer-2025',6)">
          <img src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800&q=80" alt="Chandratal lake" data-album="spiti-summer-2025" data-idx="6"
               onerror="this.parentElement.classList.add('empty-slot')"
               style="width:100%;height:100%;object-fit:cover;object-position:center">
          <div class="thumb-overlay"><span>🔍</span></div>
          <div class="thumb-num">Photo 7</div>
        </div>
        <div class="album-thumb" onclick="openLightbox('spiti-summer-2025',7)">
          <img src="https://images.unsplash.com/photo-1587474260584-136574528ed5?w=800&q=80" alt="Dhankar monastery" data-album="spiti-summer-2025" data-idx="7"
               onerror="this.parentElement.classList.add('empty-slot')"
               style="width:100%;height:100%;object-fit:cover;object-position:center">
          <div class="thumb-overlay"><span>🔍</span></div>
          <div class="thumb-num">Photo 8</div>
        </div>
        <div class="album-thumb" onclick="openLightbox('spiti-summer-2025',8)">
          <img src="https://images.unsplash.com/photo-1486870591958-9b9d0d1dda99?w=800&q=80" alt="Spiti highway" data-album="spiti-summer-2025" data-idx="8"
               onerror="this.parentElement.classList.add('empty-slot')"
               style="width:100%;height:100%;object-fit:cover;object-position:center">
          <div class="thumb-overlay"><span>🔍</span></div>
          <div class="thumb-num">Photo 9</div>
        </div>
        <div class="album-thumb" onclick="openLightbox('spiti-summer-2025',9)">
          <img src="https://images.unsplash.com/photo-1544735716-392fe2489ffa?w=800&q=80" alt="Himalayan valley summer" data-album="spiti-summer-2025" data-idx="9"
               onerror="this.parentElement.classList.add('empty-slot')"
               style="width:100%;height:100%;object-fit:cover;object-position:center">
          <div class="thumb-overlay"><span>🔍</span></div>
          <div class="thumb-num">Photo 10</div>
        </div>
        <div class="album-thumb" onclick="openLightbox('spiti-summer-2025',10)">
          <img src="https://images.unsplash.com/photo-1469474968028-56623f02e42e?w=800&q=80" alt="River in Spiti" data-album="spiti-summer-2025" data-idx="10"
               onerror="this.parentElement.classList.add('empty-slot')"
               style="width:100%;height:100%;object-fit:cover;object-position:center">
          <div class="thumb-overlay"><span>🔍</span></div>
          <div class="thumb-num">Photo 11</div>
        </div>
        <div class="album-thumb" onclick="openLightbox('spiti-summer-2025',11)">
          <img src="https://images.unsplash.com/photo-1448375240586-882707db888b?w=800&q=80" alt="Alpine forest" data-album="spiti-summer-2025" data-idx="11"
               onerror="this.parentElement.classList.add('empty-slot')"
               style="width:100%;height:100%;object-fit:cover;object-position:center">
          <div class="thumb-overlay"><span>🔍</span></div>
          <div class="thumb-num">Photo 12</div>
        </div>
        </div>
      <div class="album-footer-bar">
        <a href="https://instagram.com/freewheelexpeditions" target="_blank" class="album-ig-btn">📸 More on Instagram</a>
        <a href="https://wa.me/917817838060?text=Hi%21%20Tell%20me%20more%20about%20Spiti%20Summer%20Drive" target="_blank" class="album-wa-btn">💬 Ask About This Trip</a>
      </div>
    </div>
  </article>
  <div class="album-separator"></div>
  <!-- ════ ALBUM: Leh Winter Circuit ════ -->
  <article class="album-block" id="leh-winter-2025">
    <div class="album-hero">
      <!-- COVER PHOTO: 16:9, min 1920×1080px. Add src="your-cover.jpg" to the img below -->
      <img class="album-cover" src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=1920&q=85" alt="Leh Winter Circuit cover"
           onerror="this.style.display='none'"
           style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;object-position:center;opacity:0.55">
      <div class="album-hero-bg" style="background:linear-gradient(145deg,#0a1a15,#0f0d0b 60%)"></div>
      <div class="album-hero-grid"></div>
      <div class="album-hero-content">
        <div class="album-eyebrow">
          <span class="album-num">05</span>
          <span class="album-divider">——</span>
          <span class="album-date-tag">February 2025</span>
        </div>
        <h2 class="album-title">Leh Winter Circuit</h2>
        <p class="album-sub">Ladakh in white — frozen rivers and desolate lunar highways</p>
        <div class="album-meta">
          <div class="meta-pill">⏱ 12N / 13D</div>
          <div class="meta-pill">👥 16 Travellers</div>
          <div class="meta-pill">📍 Ladakh</div>
        </div>
        <div class="album-highlight">
          <span class="highlight-label">Trip Highlight</span>
          <span class="highlight-text">"Magnetic Hill & Nubra Valley sand dunes in snow"</span>
        </div>
      </div>
    </div>

    <div class="album-body">
      <div class="album-body-header">
        <div class="sec-eyebrow">Photo Gallery</div>
        <div class="photo-count">12 Photos</div>
      </div>
      <div class="album-grid">
        <div class="album-thumb" onclick="openLightbox('leh-winter-2025',0)">
          <img src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800&q=80" alt="Pangong Lake winter" data-album="leh-winter-2025" data-idx="0"
               onerror="this.parentElement.classList.add('empty-slot')"
               style="width:100%;height:100%;object-fit:cover;object-position:center">
          <div class="thumb-overlay"><span>🔍</span></div>
          <div class="thumb-num">Photo 1</div>
        </div>
        <div class="album-thumb" onclick="openLightbox('leh-winter-2025',1)">
          <img src="https://images.unsplash.com/photo-1587474260584-136574528ed5?w=800&q=80" alt="Thiksey Monastery" data-album="leh-winter-2025" data-idx="1"
               onerror="this.parentElement.classList.add('empty-slot')"
               style="width:100%;height:100%;object-fit:cover;object-position:center">
          <div class="thumb-overlay"><span>🔍</span></div>
          <div class="thumb-num">Photo 2</div>
        </div>
        <div class="album-thumb" onclick="openLightbox('leh-winter-2025',2)">
          <img src="https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?w=800&q=80" alt="Camping Ladakh" data-album="leh-winter-2025" data-idx="2"
               onerror="this.parentElement.classList.add('empty-slot')"
               style="width:100%;height:100%;object-fit:cover;object-position:center">
          <div class="thumb-overlay"><span>🔍</span></div>
          <div class="thumb-num">Photo 3</div>
        </div>
        <div class="album-thumb" onclick="openLightbox('leh-winter-2025',3)">
          <img src="https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=800&q=80" alt="Khardung La" data-album="leh-winter-2025" data-idx="3"
               onerror="this.parentElement.classList.add('empty-slot')"
               style="width:100%;height:100%;object-fit:cover;object-position:center">
          <div class="thumb-overlay"><span>🔍</span></div>
          <div class="thumb-num">Photo 4</div>
        </div>
        <div class="album-thumb" onclick="openLightbox('leh-winter-2025',4)">
          <img src="https://images.unsplash.com/photo-1486870591958-9b9d0d1dda99?w=800&q=80" alt="Road to Leh" data-album="leh-winter-2025" data-idx="4"
               onerror="this.parentElement.classList.add('empty-slot')"
               style="width:100%;height:100%;object-fit:cover;object-position:center">
          <div class="thumb-overlay"><span>🔍</span></div>
          <div class="thumb-num">Photo 5</div>
        </div>
        <div class="album-thumb" onclick="openLightbox('leh-winter-2025',5)">
          <img src="https://images.unsplash.com/photo-1531366936337-7c912a4589a7?w=800&q=80" alt="Nubra Valley" data-album="leh-winter-2025" data-idx="5"
               onerror="this.parentElement.classList.add('empty-slot')"
               style="width:100%;height:100%;object-fit:cover;object-position:center">
          <div class="thumb-overlay"><span>🔍</span></div>
          <div class="thumb-num">Photo 6</div>
        </div>
        <div class="album-thumb" onclick="openLightbox('leh-winter-2025',6)">
          <img src="https://images.unsplash.com/photo-1519681393784-d120267933ba?w=800&q=80" alt="Starry night Leh" data-album="leh-winter-2025" data-idx="6"
               onerror="this.parentElement.classList.add('empty-slot')"
               style="width:100%;height:100%;object-fit:cover;object-position:center">
          <div class="thumb-overlay"><span>🔍</span></div>
          <div class="thumb-num">Photo 7</div>
        </div>
        <div class="album-thumb" onclick="openLightbox('leh-winter-2025',7)">
          <img src="https://images.unsplash.com/photo-1605649487212-47bdab064df7?w=800&q=80" alt="Mountain road Leh" data-album="leh-winter-2025" data-idx="7"
               onerror="this.parentElement.classList.add('empty-slot')"
               style="width:100%;height:100%;object-fit:cover;object-position:center">
          <div class="thumb-overlay"><span>🔍</span></div>
          <div class="thumb-num">Photo 8</div>
        </div>
        <div class="album-thumb" onclick="openLightbox('leh-winter-2025',8)">
          <img src="https://images.unsplash.com/photo-1597240814775-a0e09ceee438?w=800&q=80" alt="Desert landscape" data-album="leh-winter-2025" data-idx="8"
               onerror="this.parentElement.classList.add('empty-slot')"
               style="width:100%;height:100%;object-fit:cover;object-position:center">
          <div class="thumb-overlay"><span>🔍</span></div>
          <div class="thumb-num">Photo 9</div>
        </div>
        <div class="album-thumb" onclick="openLightbox('leh-winter-2025',9)">
          <img src="https://images.unsplash.com/photo-1544735716-392fe2489ffa?w=800&q=80" alt="Himalayan peaks" data-album="leh-winter-2025" data-idx="9"
               onerror="this.parentElement.classList.add('empty-slot')"
               style="width:100%;height:100%;object-fit:cover;object-position:center">
          <div class="thumb-overlay"><span>🔍</span></div>
          <div class="thumb-num">Photo 10</div>
        </div>
        <div class="album-thumb" onclick="openLightbox('leh-winter-2025',10)">
          <img src="https://images.unsplash.com/photo-1469474968028-56623f02e42e?w=800&q=80" alt="Indus river valley" data-album="leh-winter-2025" data-idx="10"
               onerror="this.parentElement.classList.add('empty-slot')"
               style="width:100%;height:100%;object-fit:cover;object-position:center">
          <div class="thumb-overlay"><span>🔍</span></div>
          <div class="thumb-num">Photo 11</div>
        </div>
        <div class="album-thumb" onclick="openLightbox('leh-winter-2025',11)">
          <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=800&q=80" alt="Snow covered passes" data-album="leh-winter-2025" data-idx="11"
               onerror="this.parentElement.classList.add('empty-slot')"
               style="width:100%;height:100%;object-fit:cover;object-position:center">
          <div class="thumb-overlay"><span>🔍</span></div>
          <div class="thumb-num">Photo 12</div>
        </div>
        </div>
      <div class="album-footer-bar">
        <a href="https://instagram.com/freewheelexpeditions" target="_blank" class="album-ig-btn">📸 More on Instagram</a>
        <a href="https://wa.me/917817838060?text=Hi%21%20Tell%20me%20more%20about%20Leh%20Winter%20Circuit" target="_blank" class="album-wa-btn">💬 Ask About This Trip</a>
      </div>
    </div>
  </article>
  <div class="album-separator"></div>
  <!-- ════ ALBUM: Kumaon Explorer ════ -->
  <article class="album-block" id="kumaon-explorer-2024">
    <div class="album-hero">
      <!-- COVER PHOTO: 16:9, min 1920×1080px. Add src="your-cover.jpg" to the img below -->
      <img class="album-cover" src="https://images.unsplash.com/photo-1501854140801-50d01698950b?w=1920&q=85" alt="Kumaon Explorer cover"
           onerror="this.style.display='none'"
           style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;object-position:center;opacity:0.55">
      <div class="album-hero-bg" style="background:linear-gradient(145deg,#0f1a08,#0f0d0b 60%)"></div>
      <div class="album-hero-grid"></div>
      <div class="album-hero-content">
        <div class="album-eyebrow">
          <span class="album-num">06</span>
          <span class="album-divider">——</span>
          <span class="album-date-tag">October 2024</span>
        </div>
        <h2 class="album-title">Kumaon Explorer</h2>
        <p class="album-sub">Binsar, Munsiyari, Khali Estate — Kumaon's soul on two wheels</p>
        <div class="album-meta">
          <div class="meta-pill">⏱ 8N / 9D</div>
          <div class="meta-pill">👥 20 Travellers</div>
          <div class="meta-pill">📍 Uttarakhand</div>
        </div>
        <div class="album-highlight">
          <span class="highlight-label">Trip Highlight</span>
          <span class="highlight-text">"Jim Corbett night safari & Binsar wildlife sanctuary"</span>
        </div>
      </div>
    </div>

    <div class="album-body">
      <div class="album-body-header">
        <div class="sec-eyebrow">Photo Gallery</div>
        <div class="photo-count">12 Photos</div>
      </div>
      <div class="album-grid">
        <div class="album-thumb" onclick="openLightbox('kumaon-explorer-2024',0)">
          <img src="https://images.unsplash.com/photo-1501854140801-50d01698950b?w=800&q=80" alt="Kumaon hills" data-album="kumaon-explorer-2024" data-idx="0"
               onerror="this.parentElement.classList.add('empty-slot')"
               style="width:100%;height:100%;object-fit:cover;object-position:center">
          <div class="thumb-overlay"><span>🔍</span></div>
          <div class="thumb-num">Photo 1</div>
        </div>
        <div class="album-thumb" onclick="openLightbox('kumaon-explorer-2024',1)">
          <img src="https://images.unsplash.com/photo-1448375240586-882707db888b?w=800&q=80" alt="Kumaon forest" data-album="kumaon-explorer-2024" data-idx="1"
               onerror="this.parentElement.classList.add('empty-slot')"
               style="width:100%;height:100%;object-fit:cover;object-position:center">
          <div class="thumb-overlay"><span>🔍</span></div>
          <div class="thumb-num">Photo 2</div>
        </div>
        <div class="album-thumb" onclick="openLightbox('kumaon-explorer-2024',2)">
          <img src="https://images.unsplash.com/photo-1469474968028-56623f02e42e?w=800&q=80" alt="Valley Kumaon" data-album="kumaon-explorer-2024" data-idx="2"
               onerror="this.parentElement.classList.add('empty-slot')"
               style="width:100%;height:100%;object-fit:cover;object-position:center">
          <div class="thumb-overlay"><span>🔍</span></div>
          <div class="thumb-num">Photo 3</div>
        </div>
        <div class="album-thumb" onclick="openLightbox('kumaon-explorer-2024',3)">
          <img src="https://images.unsplash.com/photo-1522163182402-834f871fd851?w=800&q=80" alt="Himalayan foothills" data-album="kumaon-explorer-2024" data-idx="3"
               onerror="this.parentElement.classList.add('empty-slot')"
               style="width:100%;height:100%;object-fit:cover;object-position:center">
          <div class="thumb-overlay"><span>🔍</span></div>
          <div class="thumb-num">Photo 4</div>
        </div>
        <div class="album-thumb" onclick="openLightbox('kumaon-explorer-2024',4)">
          <img src="https://images.unsplash.com/photo-1470071459604-3b5ec3a7fe05?w=800&q=80" alt="Misty Kumaon hills" data-album="kumaon-explorer-2024" data-idx="4"
               onerror="this.parentElement.classList.add('empty-slot')"
               style="width:100%;height:100%;object-fit:cover;object-position:center">
          <div class="thumb-overlay"><span>🔍</span></div>
          <div class="thumb-num">Photo 5</div>
        </div>
        <div class="album-thumb" onclick="openLightbox('kumaon-explorer-2024',5)">
          <img src="https://images.unsplash.com/photo-1440688807730-73e4e2169fb8?w=800&q=80" alt="Kumaon sunset" data-album="kumaon-explorer-2024" data-idx="5"
               onerror="this.parentElement.classList.add('empty-slot')"
               style="width:100%;height:100%;object-fit:cover;object-position:center">
          <div class="thumb-overlay"><span>🔍</span></div>
          <div class="thumb-num">Photo 6</div>
        </div>
        <div class="album-thumb" onclick="openLightbox('kumaon-explorer-2024',6)">
          <img src="https://images.unsplash.com/photo-1544735716-392fe2489ffa?w=800&q=80" alt="Nanda Devi view" data-album="kumaon-explorer-2024" data-idx="6"
               onerror="this.parentElement.classList.add('empty-slot')"
               style="width:100%;height:100%;object-fit:cover;object-position:center">
          <div class="thumb-overlay"><span>🔍</span></div>
          <div class="thumb-num">Photo 7</div>
        </div>
        <div class="album-thumb" onclick="openLightbox('kumaon-explorer-2024',7)">
          <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=800&q=80" alt="Snow peaks Kumaon" data-album="kumaon-explorer-2024" data-idx="7"
               onerror="this.parentElement.classList.add('empty-slot')"
               style="width:100%;height:100%;object-fit:cover;object-position:center">
          <div class="thumb-overlay"><span>🔍</span></div>
          <div class="thumb-num">Photo 8</div>
        </div>
        <div class="album-thumb" onclick="openLightbox('kumaon-explorer-2024',8)">
          <img src="https://images.unsplash.com/photo-1458442310124-dde6edb43d10?w=800&q=80" alt="Forest road" data-album="kumaon-explorer-2024" data-idx="8"
               onerror="this.parentElement.classList.add('empty-slot')"
               style="width:100%;height:100%;object-fit:cover;object-position:center">
          <div class="thumb-overlay"><span>🔍</span></div>
          <div class="thumb-num">Photo 9</div>
        </div>
        <div class="album-thumb" onclick="openLightbox('kumaon-explorer-2024',9)">
          <img src="https://images.unsplash.com/photo-1500534314209-a25ddb2bd429?w=800&q=80" alt="Campfire Kumaon" data-album="kumaon-explorer-2024" data-idx="9"
               onerror="this.parentElement.classList.add('empty-slot')"
               style="width:100%;height:100%;object-fit:cover;object-position:center">
          <div class="thumb-overlay"><span>🔍</span></div>
          <div class="thumb-num">Photo 10</div>
        </div>
        <div class="album-thumb" onclick="openLightbox('kumaon-explorer-2024',10)">
          <img src="https://images.unsplash.com/photo-1511497584788-876760111969?w=800&q=80" alt="Pines Kumaon" data-album="kumaon-explorer-2024" data-idx="10"
               onerror="this.parentElement.classList.add('empty-slot')"
               style="width:100%;height:100%;object-fit:cover;object-position:center">
          <div class="thumb-overlay"><span>🔍</span></div>
          <div class="thumb-num">Photo 11</div>
        </div>
        <div class="album-thumb" onclick="openLightbox('kumaon-explorer-2024',11)">
          <img src="https://images.unsplash.com/photo-1531366936337-7c912a4589a7?w=800&q=80" alt="Almora landscape" data-album="kumaon-explorer-2024" data-idx="11"
               onerror="this.parentElement.classList.add('empty-slot')"
               style="width:100%;height:100%;object-fit:cover;object-position:center">
          <div class="thumb-overlay"><span>🔍</span></div>
          <div class="thumb-num">Photo 12</div>
        </div>
        </div>
      <div class="album-footer-bar">
        <a href="https://instagram.com/freewheelexpeditions" target="_blank" class="album-ig-btn">📸 More on Instagram</a>
        <a href="https://wa.me/917817838060?text=Hi%21%20Tell%20me%20more%20about%20Kumaon%20Explorer" target="_blank" class="album-wa-btn">💬 Ask About This Trip</a>
      </div>
    </div>
  </article>
  <div class="album-separator"></div>

    <!-- BOTTOM CTA -->
    <div style="background:var(--rust);padding:60px 48px;text-align:center">
      <div style="font-family:var(--headline);font-size:clamp(28px,4vw,52px);color:#fff;letter-spacing:2px;margin-bottom:12px">Ready to Make Your Own Memories?</div>
      <p style="font-size:15px;font-weight:300;color:rgba(255,255,255,.8);margin-bottom:32px">Join us on the next expedition. Slots fill fast.</p>
      <div style="display:flex;gap:16px;justify-content:center;flex-wrap:wrap">
        <a href="<?php echo home_url('/'); ?>#upcoming" style="display:inline-block;padding:14px 36px;background:#fff;color:var(--rust);text-decoration:none;font-family:var(--headline);font-size:20px;letter-spacing:2px;border-radius:2px">View Upcoming</a>
        <a href="https://wa.me/917817838060" target="_blank" style="display:inline-block;padding:14px 36px;border:2px solid rgba(255,255,255,.5);color:#fff;text-decoration:none;font-family:var(--headline);font-size:20px;letter-spacing:2px;border-radius:2px">💬 WhatsApp Us</a>
      </div>
    </div>
  </main>
</div>

<!-- LIGHTBOX -->
<div class="lightbox" id="lightbox" onclick="lbOutside(event)">
  <div class="lb-inner">
    <button class="lb-close" onclick="closeLightbox()">✕</button>
    <div class="lb-img-wrap">
      <img id="lbImg" src="" alt="" style="display:none">
      <div class="lb-placeholder" id="lbPlaceholder">
        <div class="ph-ico">🖼️</div>
        <div class="ph-txt" id="lbAlbumName">Album Name</div>
        <div class="ph-sub" id="lbPhotoNum">Photo 1 of 6</div>
        <div class="ph-sub" style="margin-top:4px">Upload your photo and add src="" to the img tag</div>
      </div>
    </div>
    <div class="lb-nav">
      <button class="lb-btn" onclick="lbStep(-1)">← Prev</button>
      <span class="lb-counter" id="lbCounter">1 / 6</span>
      <button class="lb-btn" onclick="lbStep(1)">Next →</button>
    </div>
  </div>
</div>


<script>
/* Inline album data — ensures lightbox works even if DOM img.src not yet loaded */
window.albumDataOverride = {
  'winter-spiti-2026': [
    'https://images.unsplash.com/photo-1605649487212-47bdab064df7?w=1200&q=85',
    'https://images.unsplash.com/photo-1587474260584-136574528ed5?w=1200&q=85',
    'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=1200&q=85',
    'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=1200&q=85',
    'https://images.unsplash.com/photo-1531366936337-7c912a4589a7?w=1200&q=85',
    'https://images.unsplash.com/photo-1486870591958-9b9d0d1dda99?w=1200&q=85',
    'https://images.unsplash.com/photo-1519681393784-d120267933ba?w=1200&q=85',
    'https://images.unsplash.com/photo-1597240814775-a0e09ceee438?w=1200&q=85',
    'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=1200&q=85',
    'https://images.unsplash.com/photo-1544735716-392fe2489ffa?w=1200&q=85',
    'https://images.unsplash.com/photo-1469474968028-56623f02e42e?w=1200&q=85',
    'https://images.unsplash.com/photo-1448375240586-882707db888b?w=1200&q=85'
  ],
  'nature-retreat-2026': [
    'https://images.unsplash.com/photo-1448375240586-882707db888b?w=1200&q=85',
    'https://images.unsplash.com/photo-1501854140801-50d01698950b?w=1200&q=85',
    'https://images.unsplash.com/photo-1511497584788-876760111969?w=1200&q=85',
    'https://images.unsplash.com/photo-1470071459604-3b5ec3a7fe05?w=1200&q=85',
    'https://images.unsplash.com/photo-1540390769625-2fc3f8b1d50c?w=1200&q=85',
    'https://images.unsplash.com/photo-1500534314209-a25ddb2bd429?w=1200&q=85',
    'https://images.unsplash.com/photo-1469474968028-56623f02e42e?w=1200&q=85',
    'https://images.unsplash.com/photo-1458442310124-dde6edb43d10?w=1200&q=85',
    'https://images.unsplash.com/photo-1519681393784-d120267933ba?w=1200&q=85',
    'https://images.unsplash.com/photo-1531366936337-7c912a4589a7?w=1200&q=85',
    'https://images.unsplash.com/photo-1486870591958-9b9d0d1dda99?w=1200&q=85',
    'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=1200&q=85'
  ],
  'darma-valley-2025': [
    'https://images.unsplash.com/photo-1544735716-392fe2489ffa?w=1200&q=85',
    'https://images.unsplash.com/photo-1469474968028-56623f02e42e?w=1200&q=85',
    'https://images.unsplash.com/photo-1522163182402-834f871fd851?w=1200&q=85',
    'https://images.unsplash.com/photo-1458442310124-dde6edb43d10?w=1200&q=85',
    'https://images.unsplash.com/photo-1519681393784-d120267933ba?w=1200&q=85',
    'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=1200&q=85',
    'https://images.unsplash.com/photo-1605649487212-47bdab064df7?w=1200&q=85',
    'https://images.unsplash.com/photo-1448375240586-882707db888b?w=1200&q=85',
    'https://images.unsplash.com/photo-1501854140801-50d01698950b?w=1200&q=85',
    'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=1200&q=85',
    'https://images.unsplash.com/photo-1531366936337-7c912a4589a7?w=1200&q=85',
    'https://images.unsplash.com/photo-1597240814775-a0e09ceee438?w=1200&q=85'
  ],
  'spiti-summer-2025': [
    'https://images.unsplash.com/photo-1605649487212-47bdab064df7?w=1200&q=85',
    'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=1200&q=85',
    'https://images.unsplash.com/photo-1597240814775-a0e09ceee438?w=1200&q=85',
    'https://images.unsplash.com/photo-1519681393784-d120267933ba?w=1200&q=85',
    'https://images.unsplash.com/photo-1531366936337-7c912a4589a7?w=1200&q=85',
    'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=1200&q=85',
    'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=1200&q=85',
    'https://images.unsplash.com/photo-1587474260584-136574528ed5?w=1200&q=85',
    'https://images.unsplash.com/photo-1486870591958-9b9d0d1dda99?w=1200&q=85',
    'https://images.unsplash.com/photo-1544735716-392fe2489ffa?w=1200&q=85',
    'https://images.unsplash.com/photo-1469474968028-56623f02e42e?w=1200&q=85',
    'https://images.unsplash.com/photo-1448375240586-882707db888b?w=1200&q=85'
  ],
  'leh-winter-2025': [
    'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=1200&q=85',
    'https://images.unsplash.com/photo-1587474260584-136574528ed5?w=1200&q=85',
    'https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?w=1200&q=85',
    'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=1200&q=85',
    'https://images.unsplash.com/photo-1486870591958-9b9d0d1dda99?w=1200&q=85',
    'https://images.unsplash.com/photo-1531366936337-7c912a4589a7?w=1200&q=85',
    'https://images.unsplash.com/photo-1519681393784-d120267933ba?w=1200&q=85',
    'https://images.unsplash.com/photo-1605649487212-47bdab064df7?w=1200&q=85',
    'https://images.unsplash.com/photo-1597240814775-a0e09ceee438?w=1200&q=85',
    'https://images.unsplash.com/photo-1544735716-392fe2489ffa?w=1200&q=85',
    'https://images.unsplash.com/photo-1469474968028-56623f02e42e?w=1200&q=85',
    'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=1200&q=85'
  ],
  'kumaon-explorer-2024': [
    'https://images.unsplash.com/photo-1501854140801-50d01698950b?w=1200&q=85',
    'https://images.unsplash.com/photo-1448375240586-882707db888b?w=1200&q=85',
    'https://images.unsplash.com/photo-1469474968028-56623f02e42e?w=1200&q=85',
    'https://images.unsplash.com/photo-1522163182402-834f871fd851?w=1200&q=85',
    'https://images.unsplash.com/photo-1470071459604-3b5ec3a7fe05?w=1200&q=85',
    'https://images.unsplash.com/photo-1440688807730-73e4e2169fb8?w=1200&q=85',
    'https://images.unsplash.com/photo-1544735716-392fe2489ffa?w=1200&q=85',
    'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=1200&q=85',
    'https://images.unsplash.com/photo-1458442310124-dde6edb43d10?w=1200&q=85',
    'https://images.unsplash.com/photo-1500534314209-a25ddb2bd429?w=1200&q=85',
    'https://images.unsplash.com/photo-1511497584788-876760111969?w=1200&q=85',
    'https://images.unsplash.com/photo-1531366936337-7c912a4589a7?w=1200&q=85'
  ]
};
// Override albumData with inline data immediately
if (typeof albumData !== 'undefined') {
  Object.assign(albumData, window.albumDataOverride);
}
// Also hook into openLightbox to use override if albumData not populated
var _origOpenLb = window.openLightbox;
window.openLightbox = function(albumId, idx) {
  if (typeof albumData === 'undefined') { window.albumData = {}; }
  if (!albumData[albumId] || albumData[albumId].length === 0) {
    albumData[albumId] = window.albumDataOverride[albumId] || [];
  }
  if (typeof _origOpenLb === 'function') {
    _origOpenLb(albumId, idx);
  }
};
</script>

<?php get_footer(); ?>
