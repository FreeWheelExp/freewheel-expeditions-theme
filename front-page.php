<?php
/**
 * Template Name: Home Front Page
 * Template Post Type: page
 *
 * FreeWheel Expeditions — FreeWheel Expeditions — Drive Wild India
 * Template: front-page
 */
get_header();
// ── Schema: TravelAgency + WebSite + Sitelinks Searchbox ─────────
$schema_org = [
    "@context" => "https://schema.org",
    "@graph"   => [
        [
            "@type"       => "TravelAgency",
            "@id"         => home_url('/#organization'),
            "name"        => "FreeWheel Expeditions",
            "url"         => home_url('/'),
            "logo"        => [
                "@type" => "ImageObject",
                "url"   => get_template_directory_uri() . "/images/header-1.jpg"
            ],
            "description" => "Self-drive road trip expeditions across Ladakh, Spiti, Nepal and India. Convoy-based adventure travel for car enthusiasts.",
            "telephone"   => "+91-7817838060",
            "email"       => "hello@freewheelexpeditions.in",
            "address"     => [
                "@type"           => "PostalAddress",
                "addressLocality" => "Haldwani",
                "addressRegion"   => "Uttarakhand",
                "addressCountry"  => "IN"
            ],
            "areaServed"  => "India",
            "sameAs"      => [
                "https://www.facebook.com/FreeWheelExpeditions",
                "https://www.instagram.com/freewheelexpeditions",
                "https://www.youtube.com/@freewheelexpeditions"
            ],
            "priceRange"  => "₹₹₹"
        ],
        [
            "@type"           => "WebSite",
            "@id"             => home_url('/#website'),
            "url"             => home_url('/'),
            "name"            => "FreeWheel Expeditions",
            "description"     => "Self-drive road trip expeditions in India",
            "publisher"       => ["@id" => home_url('/#organization')],
            "potentialAction" => [
                "@type"       => "SearchAction",
                "target"      => [
                    "@type"       => "EntryPoint",
                    "urlTemplate" => home_url('/?s={search_term_string}')
                ],
                "query-input" => "required name=search_term_string"
            ]
        ]
    ]
];
echo '<script type="application/ld+json">' . json_encode($schema_org, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . '</script>' . "
";
?>
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


.hero{min-height:100vh;background:var(--ink);display:flex;flex-direction:column;align-items:center;justify-content:center;position:relative;overflow:hidden;padding:80px 5vw 60px;text-align:center;z-index:0}
.hero-bg{position:absolute;inset:0;background-image:radial-gradient(circle at 20% 50%,rgba(193,68,14,.18) 0%,transparent 50%),radial-gradient(circle at 80% 20%,rgba(42,122,110,.12) 0%,transparent 40%),radial-gradient(circle at 60% 80%,rgba(232,160,32,.1) 0%,transparent 40%);pointer-events:none}
.hero-grid{position:absolute;inset:0;background-image:linear-gradient(rgba(255,255,255,.025) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.025) 1px,transparent 1px);background-size:80px 80px;pointer-events:none}
.hero-eyebrow{display:inline-flex;align-items:center;gap:12px;font-size:11px;font-weight:500;letter-spacing:4px;text-transform:uppercase;color:var(--amber);margin-bottom:20px;animation:fU .8s ease both}
.hero-eyebrow::before,.hero-eyebrow::after{content:'';width:36px;height:1px;background:var(--amber)}
.hero-h1{font-family:var(--headline);font-size:clamp(70px,12vw,150px);line-height:.88;letter-spacing:2px;color:#fff;margin-bottom:8px;animation:fU .8s .1s ease both}
.hero-h1 .r{color:var(--rust)}.hero-h1 .a{color:var(--amber)}
.hero-sub{font-size:clamp(14px,1.8vw,18px);font-weight:300;font-style:italic;color:rgba(255,255,255,.5);max-width:500px;margin:0 auto 44px;line-height:1.7;animation:fU .8s .2s ease both}
.hero-ctas{display:flex;gap:16px;justify-content:center;flex-wrap:wrap;animation:fU .8s .3s ease both;margin-bottom:64px}
.hero-stats{display:flex;gap:48px;justify-content:center;flex-wrap:wrap;padding-top:36px;border-top:1px solid rgba(255,255,255,.1);animation:fU .8s .4s ease both;width:100%;max-width:640px}
.stat{text-align:center}.stat-n{font-family:var(--headline);font-size:50px;color:var(--amber);line-height:1;margin-bottom:4px}.stat-l{font-size:11px;letter-spacing:3px;text-transform:uppercase;color:rgba(255,255,255,.4)}
@keyframes fU{from{opacity:0;transform:translateY(24px)}to{opacity:1;transform:translateY(0)}}
/* ── ABOUT ── */
.about{background:var(--paper);padding:96px 5vw}
.about-inner{max-width:1100px;margin:0 auto;display:grid;grid-template-columns:1fr 1.2fr;gap:80px;align-items:center}
.sec-tag{font-size:11px;font-weight:600;letter-spacing:4px;text-transform:uppercase;color:var(--rust);margin-bottom:14px}
.sec-h2{font-family:var(--headline);font-size:clamp(40px,5vw,66px);color:var(--ink);line-height:.95;letter-spacing:1px;margin-bottom:22px}
.sec-h2 em{color:var(--rust);font-style:normal}
.about-p{font-size:15px;font-weight:300;line-height:1.9;color:#4a3c2a;margin-bottom:14px}
.vals{display:grid;grid-template-columns:1fr 1fr;gap:1px;margin-top:28px;background:var(--sand)}
.val{background:var(--paper);padding:18px}.val-ico{font-size:20px}.val-n{font-family:var(--headline);font-size:15px;letter-spacing:1px;color:var(--ink);margin:6px 0 3px}.val-d{font-size:12px;color:#7a6a52;font-weight:300;line-height:1.5}
.about-vis{position:relative}.about-box{aspect-ratio:3/4;background:linear-gradient(145deg,var(--ink),#2a1a0e);display:flex;align-items:center;justify-content:center;position:relative;overflow:hidden}
.about-box::before{content:'';position:absolute;inset:0;background:radial-gradient(circle at 40% 60%,rgba(193,68,14,.25) 0%,transparent 60%),radial-gradient(circle at 70% 20%,rgba(232,160,32,.15) 0%,transparent 40%)}
.about-truck{font-size:110px;opacity:.12;position:relative;z-index:1}
.about-acc{position:absolute;bottom:-16px;right:-16px;width:120px;height:120px;border:3px solid var(--rust);z-index:-1}
@media(max-width:800px){.about-inner{grid-template-columns:1fr}.about-vis{display:none}}
/* ── UPCOMING ── */
.upcoming{background:var(--ink);padding:80px 0 40px}
.sec-header{text-align:center;margin-bottom:52px;padding:0 5vw}
.sec-h2-light{font-family:var(--headline);font-size:clamp(36px,5vw,64px);letter-spacing:1px;line-height:1;color:#fff}
.sec-sub{font-size:15px;font-weight:300;color:rgba(255,255,255,.4);margin-top:10px}
.carousel-wrap{position:relative;overflow:hidden;padding:0 5vw}
.carousel-track{display:flex;gap:24px;transition:transform .45s cubic-bezier(.22,.9,.36,1)}
.trip-card{flex:0 0 calc(33.333% - 16px);min-width:300px;background:#1a1410;border:1px solid rgba(255,255,255,.07);display:flex;flex-direction:column}
.tc-top{height:210px;position:relative;overflow:hidden;background:#0f0d0b;flex-shrink:0}.tc-photo{transition:opacity .3s}
.tc-art{position:absolute;inset:0;display:flex;align-items:center;justify-content:center;font-size:80px;opacity:.12}
.tc-grad{position:absolute;inset:0;background:linear-gradient(to top,rgba(26,20,16,.85) 0%,rgba(0,0,0,.1) 50%,transparent 100%)}
.tc-badge{position:absolute;top:14px;left:14px;font-size:9px;letter-spacing:3px;font-weight:600;text-transform:uppercase;padding:4px 10px;border:1px solid var(--amber);color:var(--amber);background:rgba(0,0,0,.5)}
.tc-body{padding:22px;display:flex;flex-direction:column;flex:1}
.tc-month{font-size:11px;letter-spacing:3px;text-transform:uppercase;color:rgba(255,255,255,.35);margin-bottom:5px}
.tc-name{font-family:var(--headline);font-size:26px;color:#fff;letter-spacing:1px;line-height:1.1;margin-bottom:5px}
.tc-dur{font-size:13px;color:var(--amber);margin-bottom:14px;font-weight:300}
.tc-dets{display:flex;gap:14px;margin-bottom:18px;flex-wrap:wrap}
.tc-det{font-size:11px;color:rgba(255,255,255,.4);display:flex;align-items:center;gap:4px}
.tc-price{display:flex;align-items:baseline;gap:8px;margin-bottom:18px;padding:10px 12px;background:rgba(255,255,255,.04);border-left:3px solid var(--rust)}
.p-from{font-size:10px;letter-spacing:2px;text-transform:uppercase;color:rgba(255,255,255,.35)}.p-num{font-family:var(--headline);font-size:30px;color:#fff}.p-note{font-size:11px;color:rgba(255,255,255,.3);font-weight:300}
.tc-btns{display:flex;gap:8px;margin-top:auto}
.det-btn{flex:1;padding:11px;background:transparent;border:2px solid rgba(255,255,255,.2);color:rgba(255,255,255,.7);cursor:pointer;font-family:var(--headline);font-size:15px;letter-spacing:1px;transition:border-color .2s,color .2s;text-decoration:none;display:flex;align-items:center;justify-content:center;border-radius:2px}
.det-btn:hover{border-color:var(--amber);color:var(--amber)}
.carousel-controls{display:flex;align-items:center;justify-content:center;gap:16px;margin-top:20px;padding:0 5vw}
.c-btn{width:46px;height:46px;border:2px solid rgba(255,255,255,.2);background:transparent;color:#fff;cursor:pointer;font-size:20px;transition:border-color .2s;display:flex;align-items:center;justify-content:center;border-radius:50%}
.c-btn:hover{border-color:var(--amber)}
.dots{display:flex;gap:8px}
.dot{width:8px;height:8px;border-radius:50%;background:rgba(255,255,255,.2);cursor:pointer;transition:all .2s}
.dot.active{background:var(--amber);width:24px;border-radius:4px}
.past-section{padding-top:48px!important}
/* ── PAST ── */
.past{background:var(--ink);padding:96px 5vw}
.past-inner{max-width:1200px;margin:0 auto}
.past-header{display:flex;justify-content:space-between;align-items:flex-end;margin-bottom:44px;flex-wrap:wrap;gap:20px}
.past-sub{font-size:15px;font-weight:300;color:rgba(255,255,255,.35);margin-top:8px}
.past-all-btn{display:inline-block;font-size:12px;letter-spacing:3px;text-transform:uppercase;color:var(--amber);text-decoration:none;border-bottom:1px solid rgba(232,160,32,.4);padding-bottom:3px;transition:border-color .2s;white-space:nowrap}
.past-all-btn:hover{border-color:var(--amber)}
.past-album-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:3px}
.pac{display:flex;flex-direction:column;text-decoration:none;background:#0a0805;overflow:hidden;transition:transform .25s}
.pac:hover{transform:translateY(-4px)}
.pac-img{position:relative;aspect-ratio:16/9;overflow:hidden;background:#1a1410}
.pac-img img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;transition:transform .4s ease}
.pac:hover .pac-img img{transform:scale(1.06)}
.pac-bg{position:absolute;inset:0;transition:opacity .3s}
.pac:hover .pac-bg{opacity:0.6}
.pac-emoji{position:absolute;bottom:12px;left:14px;font-size:28px;z-index:2;opacity:.5;transition:opacity .3s}
.pac:hover .pac-emoji{opacity:.9}
.pac-num{position:absolute;top:10px;right:12px;font-family:var(--headline);font-size:32px;color:rgba(255,255,255,.12);z-index:2;line-height:1}
.pac-body{padding:18px 18px 20px;flex:1;display:flex;flex-direction:column;border-top:2px solid transparent;transition:border-color .2s}
.pac:hover .pac-body{border-top-color:var(--rust)}
.pac-date{font-size:10px;letter-spacing:3px;text-transform:uppercase;color:rgba(255,255,255,.3);margin-bottom:5px}
.pac-name{font-family:var(--headline);font-size:22px;color:#fff;letter-spacing:1px;margin-bottom:10px;line-height:1.1}
.pac-stats{display:flex;gap:10px;flex-wrap:wrap;margin-bottom:14px}
.pac-stats span{font-size:11px;color:rgba(255,255,255,.35);letter-spacing:.5px}
.pac-cta{display:flex;align-items:center;justify-content:space-between;font-size:11px;letter-spacing:3px;text-transform:uppercase;color:rgba(255,255,255,.25);margin-top:auto;transition:color .2s}
.pac:hover .pac-cta{color:var(--amber)}
@media(max-width:900px){.past-album-grid{grid-template-columns:repeat(2,1fr)}}
@media(max-width:560px){.past-album-grid{grid-template-columns:1fr}.past-header{flex-direction:column;align-items:flex-start}}
/* ── LOYALTY ── */
.loyalty{background:var(--teal);padding:80px 5vw;text-align:center}
.loyalty .sec-tag{color:rgba(255,255,255,.6)}
.benefits{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:1px;max-width:900px;margin:44px auto 0;background:rgba(0,0,0,.15)}
.ben{background:rgba(255,255,255,.06);padding:30px 22px;text-align:center}
.ben-ico{font-size:32px;margin-bottom:14px;display:block}
.ben-n{font-family:var(--headline);font-size:20px;color:#fff;letter-spacing:1px;margin-bottom:6px}
.ben-d{font-size:12px;color:rgba(255,255,255,.55);font-weight:300;line-height:1.6}
.ben.hl{background:rgba(232,160,32,.15);border-top:3px solid var(--amber)}
/* ── SUBSCRIBE ── */
.subscribe{background:var(--ink);padding:96px 5vw;text-align:center;position:relative;overflow:hidden}
.subscribe::before{content:'';position:absolute;inset:0;background:radial-gradient(ellipse 80% 60% at 50% 0%,rgba(193,68,14,.13),transparent);pointer-events:none}
.sub-wrap{max-width:620px;margin:0 auto;position:relative}
.sub-eyebrow{font-size:10px;letter-spacing:4px;text-transform:uppercase;color:var(--rust);margin-bottom:14px;display:flex;align-items:center;justify-content:center;gap:10px}
.sub-eyebrow::before,.sub-eyebrow::after{content:'';width:28px;height:1px;background:var(--rust);opacity:.6}
.sub-h{font-family:var(--headline);font-size:clamp(38px,6vw,68px);color:#fff;letter-spacing:2px;line-height:1;margin-bottom:14px}
.sub-h span{color:var(--amber)}
.sub-p{font-size:14px;color:rgba(255,255,255,.45);line-height:1.8;max-width:460px;margin:0 auto 36px;font-weight:300}
/* subscribe trigger button */
.sub-trigger-btn{display:inline-flex;align-items:center;gap:12px;padding:16px 44px;background:var(--rust);color:#fff;border:none;font-family:var(--headline);font-size:20px;letter-spacing:3px;cursor:pointer;border-radius:2px;transition:background .2s,transform .15s}
.sub-trigger-btn:hover{background:#a03508;transform:translateY(-2px)}
.sub-note{font-size:11px;color:rgba(255,255,255,.22);margin-top:16px;font-weight:300;letter-spacing:.5px}
/* subscribe popup overlay */
#fwSubOverlay{position:fixed;inset:0;z-index:3500;background:rgba(8,5,3,.94);display:none;align-items:center;justify-content:center;padding:16px;backdrop-filter:blur(8px)}
#fwSubOverlay.open{display:flex}
.sub-modal{background:#0f0d0b;border:1px solid rgba(193,68,14,.35);border-radius:4px;padding:38px 32px;max-width:440px;width:100%;position:relative;animation:regIn .3s ease}
.sub-modal-tag{font-size:10px;letter-spacing:3px;text-transform:uppercase;color:var(--rust);margin-bottom:10px}
.sub-modal-h{font-family:var(--headline);font-size:30px;color:#fff;letter-spacing:1px;margin-bottom:6px}
.sub-modal-p{font-size:13px;color:rgba(255,255,255,.45);line-height:1.7;margin-bottom:26px}
.sub-field{margin-bottom:14px}
.sub-field label{display:block;font-size:10px;letter-spacing:2px;text-transform:uppercase;color:rgba(255,255,255,.4);margin-bottom:6px}
.sub-field input{width:100%;box-sizing:border-box;padding:12px 14px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.15);color:#fff;font-family:var(--body);font-size:14px;border-radius:2px;outline:none;transition:border-color .2s}
.sub-field input:focus{border-color:rgba(193,68,14,.6)}
.sub-field input::placeholder{color:rgba(255,255,255,.25)}
.sub-field .sub-optional{font-size:10px;color:rgba(255,255,255,.22);margin-left:6px;letter-spacing:0}
.sub-submit-btn{width:100%;padding:14px;background:var(--rust);border:none;color:#fff;font-family:var(--headline);font-size:19px;letter-spacing:2px;cursor:pointer;border-radius:2px;transition:background .2s;margin-top:4px}
.sub-submit-btn:hover:not(:disabled){background:#a03508}
.sub-submit-btn:disabled{opacity:.6;cursor:not-allowed}
.sub-form-msg{font-size:12px;margin-top:12px;text-align:center;min-height:16px}
.sub-form-msg.error{color:#f87171}
.sub-form-msg.success{color:#4ade80}
@media(max-width:500px){.sub-modal{padding:28px 20px}.sub-h{font-size:38px}}


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


/* About section image */
.about-img-wrap img { transition: transform .5s ease; }
.about-img-wrap:hover img { transform: scale(1.03); }
@media(max-width:800px) { .about-vis { display: block !important; } }
</style>

<!-- HERO -->
<section class="hero" id="heroSection">
  <div class="hero-bg" id="heroBg"></div>
<div class="hero-grid"></div>
<!-- PHOTO SLOT: Hero background (16:9 recommended, min 1920×1080px) -->
<div class="hero-photo-slot" id="heroPhotoSlot" style="position:absolute;inset:0;z-index:0;pointer-events:none;">
  <img id="heroImg" src="" alt="" style="width:100%;height:100%;object-fit:cover;object-position:center;display:none;opacity:0.35">
</div>
  <div class="hero-eyebrow">India's Wildest Self Drive Expeditions</div>
  <h1 class="hero-h1"><span class="r">Free</span>Wheel<br><span class="a">Expeditions</span></h1>
  <p class="hero-sub">Handcrafted road expeditions through the most breathtaking terrains in India. You drive — we handle everything else.</p>
  <div class="hero-ctas">
    <a href="#upcoming" class="btn-solid">View Expeditions</a>
    <a href="#about" class="btn-ghost">Our Story</a>
  </div>
  <div class="hero-stats">
    <div class="stat"><div class="stat-n">25+</div><div class="stat-l">Expeditions Done</div></div>
    <div class="stat"><div class="stat-n">20+</div><div class="stat-l">States Covered</div></div>
    <div class="stat"><div class="stat-n">3,00,000+</div><div class="stat-l">Kms Travelled</div></div>
    <div class="stat"><div class="stat-n">500+</div><div class="stat-l">Friends Made</div></div>
  </div>
</section>

<?php fw_google_rating_section(); ?>

<!-- UPCOMING EXPEDITIONS -->
<section class="upcoming" id="upcoming">
  <div class="sec-header">
    <div class="sec-tag" style="color:var(--amber);justify-content:center;display:flex;align-items:center;gap:10px">On the Horizon</div>
    <h2 class="sec-h2-light">Upcoming Expeditions</h2>
    <p class="sec-sub">Secure your seat — slots fill fast</p>
  </div>

  <style>
  .fw-carousel-outer{max-width:1200px;margin:0 auto;padding:0 24px;box-sizing:border-box}
  .fw-carousel{position:relative;width:100%;overflow:hidden}
  .fw-slides{display:flex;transition:transform 0.5s cubic-bezier(0.25,0.46,0.45,0.94);will-change:transform;user-select:none;-webkit-user-select:none}
  .fw-slide{flex:0 0 33.333%;padding:0 8px;box-sizing:border-box}
  .fw-arrows{display:flex;justify-content:center;align-items:center;gap:20px;margin-top:28px}
  .fw-arrow{width:44px;height:44px;border-radius:50%;border:2px solid rgba(255,255,255,.25);background:transparent;color:#fff;cursor:pointer;font-size:18px;display:flex;align-items:center;justify-content:center;transition:all .25s;-webkit-tap-highlight-color:transparent}
  .fw-arrow:hover,.fw-arrow:active{background:var(--rust);border-color:var(--rust)}
  @media(max-width:900px){.fw-slide{flex:0 0 50%}}
  @media(max-width:600px){.fw-slide{flex:0 0 100%;padding:0 4px}}
  </style>

  <?php
  $upcoming = fw_upcoming_expeditions();
  if (!empty($upcoming)):
  ?>
  <div class="fw-carousel-outer">
  <div class="fw-carousel" id="fwCarousel">
    <div class="fw-slides" id="fwSlides">
      <?php foreach($upcoming as $exp): ?>
      <div class="fw-slide">
        <?php echo fw_expedition_card($exp->ID); ?>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
  </div>

  <div class="fw-arrows">
    <button class="fw-arrow" id="fwPrev" aria-label="Previous">&#8592;</button>
    <button class="fw-arrow" id="fwNext" aria-label="Next">&#8594;</button>
  </div>

  <script>
  (function() {
    var slides=document.getElementById('fwSlides');
    var carousel=document.getElementById('fwCarousel');
    var prevBtn=document.getElementById('fwPrev');
    var nextBtn=document.getElementById('fwNext');
    if(!slides||!carousel)return;

    /* clone all slides and append — enables seamless infinite loop */
    var origSlides=slides.querySelectorAll('.fw-slide');
    var total=origSlides.length;
    origSlides.forEach(function(s){slides.appendChild(s.cloneNode(true));});

    var current=0, autoTimer=null, paused=false, userInteracted=false;

    function getPerPage(){var w=window.innerWidth;return w<=600?1:w<=900?2:3;}

    function goTo(idx,animate){
      if(animate===false)slides.style.transition='none';
      else slides.style.transition='transform 0.5s cubic-bezier(0.25,0.46,0.45,0.94)';
      current=idx;
      slides.style.transform='translateX(-'+(100/getPerPage()*current)+'%)';
    }

    function next(){
      var pp=getPerPage();
      goTo(current+1);
      /* after transition, if we've entered clone territory, silently reset to real */
      setTimeout(function(){
        if(current>=total){goTo(current-total,false);}
      },520);
    }

    function prev(){
      var pp=getPerPage();
      if(current<=0){
        /* jump to clone end silently, then animate back one */
        goTo(total,false);
        setTimeout(function(){goTo(total-1);},20);
      } else {
        goTo(current-1);
      }
    }

    function startAuto(){clearInterval(autoTimer);autoTimer=setInterval(function(){if(!paused&&!userInteracted)next();},5000);}

    if(nextBtn)nextBtn.onclick=function(){userInteracted=true;clearInterval(autoTimer);next();};
    if(prevBtn)prevBtn.onclick=function(){userInteracted=true;clearInterval(autoTimer);prev();};

    carousel.addEventListener('mouseenter',function(){paused=true;});
    carousel.addEventListener('mouseleave',function(){paused=false;});

    /* ── Mouse drag (desktop) ── */
    var isDragging=false, dragStartX=0, dragScrollX=0, dragMoved=false;
    slides.style.cursor='grab';
    carousel.addEventListener('mousedown',function(e){
      isDragging=true; dragMoved=false; paused=true;
      dragStartX=e.pageX;
      dragScrollX=current*(100/getPerPage());
      slides.style.cursor='grabbing';
      slides.style.transition='none';
      e.preventDefault();
    });
    document.addEventListener('mousemove',function(e){
      if(!isDragging)return;
      var dx=e.pageX-dragStartX;
      if(Math.abs(dx)>4)dragMoved=true;
      var pct=dragScrollX-(dx/carousel.offsetWidth)*(100/getPerPage());
      slides.style.transform='translateX(-'+pct+'%)';
    });
    document.addEventListener('mouseup',function(e){
      if(!isDragging)return;
      isDragging=false;
      slides.style.cursor='grab';
      paused=false;
      if(dragMoved){
        var dx=e.pageX-dragStartX;
        userInteracted=true; clearInterval(autoTimer);
        if(dx<-40)next(); else if(dx>40)prev(); else goTo(current);
      }
    });

    var tx=0;
    carousel.addEventListener('touchstart',function(e){tx=e.changedTouches[0].clientX;},{passive:true});
    carousel.addEventListener('touchend',function(e){
      var dx=e.changedTouches[0].clientX-tx;
      if(Math.abs(dx)>40){userInteracted=true;clearInterval(autoTimer);dx<0?next():prev();}
    },{passive:true});

    window.addEventListener('resize',function(){goTo(0,false);});
    goTo(0,false);startAuto();
  })();
  </script>

  <?php else: ?>
  <div style="text-align:center;padding:60px 20px;color:rgba(255,255,255,.4);font-family:var(--body)">
    <div style="font-size:48px;margin-bottom:16px">🏔️</div>
    <div style="font-size:18px;letter-spacing:2px;text-transform:uppercase">New Expeditions Coming Soon</div>
    <p style="margin-top:12px;font-size:14px">Check back soon or follow us on Instagram.</p>
  </div>
  <?php endif; ?>

</section>

<!-- ABOUT -->
<section class="about" id="about">
  <div class="about-inner">
    <div>
      <div class="sec-tag">Who We Are</div>
      <h2 class="sec-h2">We live for the<br><em>open road</em></h2>
      <p class="about-p">We build self-drive expeditions for people who feel alive behind the wheel &#8212; dust, altitude, river crossings, and roads that don&#8217;t behave.</p>
      <p class="about-p">You drive your own machine, alongside a convoy of explorers just like you. No script, no fixed itinerary &#8212; just real roads, real challenges, and a crew that&#8217;s got your back at every turn.</p>
      <p class="about-p" style="font-style:italic;color:var(--amber);font-weight:500">If the road calls you &#8212; you already know where you belong.</p>
      <div class="vals">
        <div class="val"><div class="val-ico">🗺️</div><div class="val-n">Curated Routes</div><div class="val-d">Every road chosen for maximum awe</div></div>
        <div class="val"><div class="val-ico">🚙</div><div class="val-n">Self Drive</div><div class="val-d">Your vehicle, your pace, total freedom</div></div>
        <div class="val"><div class="val-ico">🏕️</div><div class="val-n">Expert Support</div><div class="val-d">24/7 on-ground team throughout</div></div>
        <div class="val"><div class="val-ico">🤝</div><div class="val-n">Community</div><div class="val-d">Bonds that outlast the journey</div></div>
      </div>
      <div style="margin-top:28px">
        <a href="#upcoming" class="btn-solid" style="display:inline-flex;align-items:center;gap:8px">
          View Upcoming Expeditions
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
        </a>
      </div>
    </div>
    <div class="about-vis">
      <!-- ══ ABOUT SECTION IMAGE ══
           To add your own photo:
           1. Upload photo to WordPress Media Library
           2. Copy the URL
           3. Replace the src below with your URL
           Recommended: 800×600px landscape photo of your convoy/team
      ══════════════════════════════ -->
      <div class="about-img-wrap" style="position:relative;border-radius:4px;overflow:hidden;aspect-ratio:4/3;background:#1a1410">
        <img id="aboutPhoto"
             src="<?php echo get_template_directory_uri(); ?>/images/front-page-1.png"
             alt="FreeWheel Expeditions — The Convoy"
             style="width:100%;height:100%;object-fit:cover;object-position:center;display:block">
        <!-- Overlay accent bar -->
        <div style="position:absolute;bottom:0;left:0;right:0;height:4px;background:linear-gradient(90deg,var(--rust),var(--amber))"></div>
        <!-- Floating label -->
        <div style="position:absolute;top:16px;left:16px;background:rgba(0,0,0,.6);padding:6px 14px;border-left:3px solid var(--amber);font-size:10px;letter-spacing:3px;text-transform:uppercase;color:var(--amber);font-family:var(--body);font-weight:500">The Convoy</div>
      </div>
      <div class="about-acc"></div>
    </div>
  </div>
</section>

<!-- PAST EXPEDITIONS -->
<section class="past" id="past">
  <div class="past-inner">
    <div class="past-header">
      <div>
        <div class="sec-tag">Every Road Tells a Story</div>
        <h2 class="sec-h2">Past Expeditions</h2>
      </div>
    </div>

    <?php
    $albums = fw_past_albums();
    if (!empty($albums)):
    ?>
    <div class="exp-layout">
      <aside class="exp-sidebar">
        <div class="sidebar-heading">Jump to Album</div>
        <?php foreach($albums as $i => $alb):
          $date = get_post_meta($alb->ID,'fw_alb_date',true);
          $slug = sanitize_title(get_the_title($alb->ID));
        ?>
        <a href="#album-<?php echo $slug; ?>" class="sidebar-link">
          <span class="sl-num"><?php printf('%02d',$i+1); ?></span>
          <span class="sl-name"><?php echo esc_html(get_the_title($alb->ID)); ?></span>
          <span class="sl-date"><?php echo esc_html($date); ?></span>
        </a>
        <?php endforeach; ?>
      </aside>

      <div class="exp-albums">
        <?php foreach($albums as $alb):
          $id         = $alb->ID;
          $title      = get_the_title($id);
          $slug       = sanitize_title($title);
          $date       = get_post_meta($id,'fw_alb_date',true);
          $dur        = get_post_meta($id,'fw_alb_duration',true);
          $travellers = get_post_meta($id,'fw_alb_travellers',true);
          $location   = get_post_meta($id,'fw_alb_location',true);
          $highlight  = get_post_meta($id,'fw_alb_highlight',true);
          $cover      = get_the_post_thumbnail_url($id,'album-cover');
          $photos_raw = get_post_meta($id,'fw_album_photos',true);
          $photos     = $photos_raw ? json_decode($photos_raw,true) : array();
          if(!is_array($photos)) $photos=array();
          $photo_urls_pre = array(); foreach($photos as $p){ if(!empty($p['url'])) $photo_urls_pre[] = $p['url']; }
          $total_pre = count($photo_urls_pre);
        ?>
        <div class="album-block<?php echo $alb !== $albums[0] ? ' collapsed' : ''; ?>" id="album-<?php echo esc_attr($slug); ?>">
          <!-- collapsed preview bar (visible only when collapsed) -->
          <div class="album-collapsed-bar" onclick="fwExpandAlbum('<?php echo esc_attr($slug); ?>')" onkeydown="if(event.key==='Enter'||event.key===' '){event.preventDefault();fwExpandAlbum('<?php echo esc_attr($slug); ?>');}" role="button" tabindex="0" aria-expanded="<?php echo $alb === $albums[0] ? 'true' : 'false'; ?>" aria-label="<?php echo esc_attr('Toggle album: ' . $title); ?>">
            <div class="album-collapsed-left">
              <div>
                <div style="display:flex;align-items:center;gap:12px">
                  <span class="album-collapsed-num"><?php printf('%02d', array_search($alb,$albums)+1); ?></span>
                  <span class="album-collapsed-title"><?php echo esc_html($title); ?></span>
                </div>
                <div class="album-collapsed-meta"><?php echo esc_html($date); ?><?php if($location): ?> · <?php echo esc_html($location); ?><?php endif; ?><?php if($total_pre): ?> · <?php echo $total_pre; ?> photos<?php endif; ?></div>
              </div>
            </div>
            <div class="album-collapsed-arrow" aria-hidden="true">▼</div>
          </div>
          <div class="album-hero">
            <div class="album-hero-bg" style="background:#1a1410">
              <?php if($cover): ?>
              <img loading="lazy" src="<?php echo esc_url($cover); ?>" alt="<?php echo esc_attr($title); ?>" class="album-cover"
                   style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;object-position:center;opacity:.55">
              <?php endif; ?>
            </div>
            <div class="album-hero-content">
              <div class="album-num"><?php printf('%02d',$albums[0]->ID===$id?1:array_search($alb,$albums)+1); ?> <span class="album-line"></span> <?php echo esc_html(strtoupper($date)); ?></div>
              <h2 class="album-title"><?php echo esc_html($title); ?></h2>
              <p class="album-desc"><?php echo esc_html(get_post_field('post_excerpt',$id)); ?></p>
              <div class="album-tags" style="display:flex;gap:10px;flex-wrap:wrap;margin-top:14px">
                <?php if($dur): ?><span class="album-tag">⏱ <?php echo esc_html($dur); ?></span><?php endif; ?>
                <?php if($travellers): ?><span class="album-tag">👥 <?php echo esc_html($travellers); ?> Travellers</span><?php endif; ?>
                <?php if($location): ?><span class="album-tag">📍 <?php echo esc_html($location); ?></span><?php endif; ?>
              </div>
              <?php if($highlight): ?>
              <div class="album-highlight" style="margin-top:14px;padding:8px 14px;border-left:3px solid var(--amber);font-size:13px;color:rgba(255,255,255,.7);font-style:italic">
                <span style="font-size:10px;letter-spacing:2px;text-transform:uppercase;color:var(--amber);display:block;margin-bottom:4px">TRIP HIGHLIGHT</span>
                "<?php echo esc_html($highlight); ?>"
              </div>
              <?php endif; ?>
            </div>
          </div>

          <?php if(!empty($photos)): 
            $photo_urls = array();
            foreach($photos as $p){ if(!empty($p['url'])) $photo_urls[] = $p['url']; }
            $total = count($photo_urls);
          ?>
          <div style="display:flex;justify-content:space-between;align-items:center;padding:18px 24px 10px">
            <span style="font-size:10px;letter-spacing:3px;text-transform:uppercase;color:rgba(255,255,255,.4)">PHOTO GALLERY</span>
            <span style="font-size:11px;letter-spacing:2px;text-transform:uppercase;color:rgba(255,255,255,.3)"><?php echo $total; ?> PHOTOS</span>
          </div>
          <div class="album-grid" id="grid-<?php echo esc_attr($slug); ?>">
            <?php foreach($photo_urls as $j=>$url): ?>
            <div class="album-thumb" 
                 style="<?php echo $j>=6?'display:none':''; ?>"
                 data-gslug="<?php echo esc_attr($slug); ?>"
                 data-gidx="<?php echo $j; ?>"
                 onclick="fwLbOpen('<?php echo esc_attr($slug); ?>',<?php echo $j; ?>)">
              <img loading="lazy" src="<?php echo esc_url($url); ?>" 
                   alt="<?php echo esc_attr($title); ?> photo <?php echo $j+1; ?>"
                   style="width:100%;height:100%;object-fit:cover;object-position:center">
              <div class="thumb-overlay"><span>🔍</span></div>
            </div>
            <?php endforeach; ?>
          </div>
          <?php if($total > 6): ?>
          <div style="text-align:center;padding:14px 24px 6px">
            <button class="album-show-more" 
                    data-slug="<?php echo esc_attr($slug); ?>"
                    data-total="<?php echo $total; ?>"
                    data-expanded="0"
                    onclick="fwToggle(this)">
              Show All <?php echo $total; ?> Photos ▼
            </button>
          </div>
          <?php endif; ?>
          <script>
          window.fwAlbums = window.fwAlbums || {};
          window.fwAlbums['<?php echo esc_js($slug); ?>'] = [<?php foreach($photo_urls as $url){ echo "'".esc_js($url)."',"; } ?>];
          </script>
          <?php endif; ?>

          <div class="album-footer-bar" style="padding:16px 24px;display:flex;gap:12px">
            <a href="https://instagram.com/freewheelexpeditions" target="_blank" class="album-ig-btn">📸 More on Instagram</a>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>

    <?php else: ?>
    <div style="text-align:center;padding:60px 20px;color:rgba(255,255,255,.4)">
      <div style="font-size:48px;margin-bottom:16px">📸</div>
      <div style="font-size:16px;letter-spacing:2px;text-transform:uppercase">Albums Coming Soon</div>
      <p style="margin-top:12px;font-size:14px">Add past expedition albums from WordPress Admin → Past Albums</p>
    </div>
    <?php endif; ?>

    <div style="text-align:center;margin-top:40px">
      <p style="font-size:16px;color:rgba(255,255,255,.6);margin-bottom:16px;font-style:italic">Loved the journey? Join the next one.</p>
      <a href="#upcoming" class="btn-solid" style="display:inline-flex;align-items:center;gap:8px">
        Book Your Seat
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
      </a>
    </div>

  </div>
</section>



<?php
$_fw_testis = fw_testimonials();
if (!empty($_fw_testis)):
?>
<!-- TESTIMONIALS -->
<section class="fw-testi-section" id="testimonials">
  <div class="fw-testi-inner">
    <div class="fw-testi-header">
      <div class="sec-tag" style="color:var(--rust,#c44b19);display:flex;align-items:center;gap:8px;justify-content:center;margin-bottom:12px">
        <span style="display:inline-block;width:28px;height:2px;background:var(--rust,#c44b19)"></span>
        Real Travellers
        <span style="display:inline-block;width:28px;height:2px;background:var(--rust,#c44b19)"></span>
      </div>
      <h2 class="fw-testi-title">What Our Tribe Says</h2>
      <p class="fw-testi-sub">Every story below was lived on a real road, in real cold, with real people.</p>
    </div>
    <div class="fw-testi-carousel-wrap">
      <div class="fw-testi-track" id="fwTestiTrack">
        <?php foreach($_fw_testis as $_t):
          $_name    = get_the_title($_t->ID);
          $_review  = get_post_meta($_t->ID,'fw_testi_review',true);
          $_rating  = intval(get_post_meta($_t->ID,'fw_testi_rating',true)) ?: 5;
          $_trip    = get_post_meta($_t->ID,'fw_testi_trip',true);
          $_photo   = get_the_post_thumbnail_url($_t->ID,'thumbnail');
          $_words   = array_filter(explode(' ',$_name));
          $_initials= strtoupper(substr(implode('',array_map(function($w){return $w[0];},$_words)),0,2));
        ?>
        <div class="fw-testi-card">
          <div class="fw-testi-card-inner">
            <div class="fw-testi-quote-ico">❝</div>
            <div class="fw-testi-stars">
              <?php for($s=0;$s<5;$s++) echo '<span class="fw-testi-star '.($s<$_rating?'on':'off').'">★</span>'; ?>
            </div>
            <p class="fw-testi-text"><?php echo esc_html($_review); ?></p>
            <div class="fw-testi-author">
              <div class="fw-testi-avatar">
                <?php if($_photo): ?>
                <img loading="lazy" src="<?php echo esc_url($_photo); ?>" alt="<?php echo esc_attr($_name); ?>">
                <?php else: ?>
                <span><?php echo esc_html($_initials); ?></span>
                <?php endif; ?>
              </div>
              <div>
                <div class="fw-testi-name"><?php echo esc_html($_name); ?></div>
                <?php if($_trip): ?><div class="fw-testi-trip">📍 <?php echo esc_html($_trip); ?></div><?php endif; ?>
              </div>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
      <?php if(count($_fw_testis)>1): ?>
      <button class="fw-testi-arrow fw-testi-prev" id="fwTestiPrev" aria-label="Previous">&#8592;</button>
      <button class="fw-testi-arrow fw-testi-next" id="fwTestiNext" aria-label="Next">&#8594;</button>
      <div class="fw-testi-dots" id="fwTestiDots">
        <?php foreach($_fw_testis as $_di=>$_dt): ?>
        <span class="fw-testi-dot<?php echo $_di===0?' active':''; ?>" onclick="fwTGoTo(<?php echo $_di; ?>)"></span>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>
    </div>
    <div style="text-align:center;margin-top:44px">
      <p style="font-size:16px;color:rgba(255,255,255,.6);margin-bottom:16px;font-style:italic">Ready for your own story?</p>
      <a href="#upcoming" class="btn-solid" style="display:inline-flex;align-items:center;gap:8px">
        View Upcoming Expeditions
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
      </a>
    </div>
  </div>
</section>

<style>
.fw-testi-section{background:#0a0805;padding:80px 0 90px;overflow:hidden;position:relative}
.fw-testi-section::before{content:'';position:absolute;inset:0;background:radial-gradient(ellipse at 50% 0%,rgba(196,75,25,.08) 0%,transparent 65%);pointer-events:none}
.fw-testi-inner{max-width:1200px;margin:0 auto;padding:0 24px;position:relative}
.fw-testi-title{font-family:var(--headline,'Impact',sans-serif);font-size:clamp(32px,5vw,56px);color:#fff;letter-spacing:1px;text-align:center;margin:0 0 10px}
.fw-testi-sub{font-size:15px;font-weight:300;color:rgba(255,255,255,.4);text-align:center;margin:0 0 44px}
.fw-testi-carousel-wrap{position:relative;overflow:hidden;padding:0 0 56px}
.fw-testi-track{display:flex;transition:transform .45s cubic-bezier(.4,0,.2,1);will-change:transform;align-items:stretch;user-select:none;-webkit-user-select:none}
.fw-testi-card{min-width:100%;padding:0 8px;box-sizing:border-box;display:flex}
.fw-testi-card-inner{background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.08);border-radius:4px;padding:30px 26px;flex:1;display:flex;flex-direction:column;gap:14px;transition:border-color .25s}
.fw-testi-card:hover .fw-testi-card-inner{border-color:rgba(196,75,25,.4)}
.fw-testi-quote-ico{font-size:34px;color:var(--rust,#c44b19);line-height:1;opacity:.65}
.fw-testi-stars{display:flex;gap:3px}
.fw-testi-star{font-size:16px}
.fw-testi-star.on{color:#f5a623}
.fw-testi-star.off{color:rgba(255,255,255,.15)}
.fw-testi-text{font-size:15px;font-weight:300;color:rgba(255,255,255,.78);line-height:1.75;margin:0;flex:1}
.fw-testi-author{display:flex;align-items:center;gap:13px;margin-top:auto;padding-top:18px;border-top:1px solid rgba(255,255,255,.07)}
.fw-testi-avatar{width:46px;height:46px;border-radius:50%;overflow:hidden;flex-shrink:0;background:var(--rust,#c44b19);display:flex;align-items:center;justify-content:center}
.fw-testi-avatar img{width:100%;height:100%;object-fit:cover;display:block}
.fw-testi-avatar span{color:#fff;font-family:var(--headline,'Impact',sans-serif);font-size:17px;letter-spacing:1px}
.fw-testi-name{font-family:var(--headline,'Impact',sans-serif);font-size:16px;color:#fff;letter-spacing:.5px}
.fw-testi-trip{font-size:11px;color:var(--rust,#c44b19);letter-spacing:1.5px;text-transform:uppercase;margin-top:2px}
.fw-testi-arrow{position:absolute;top:38%;transform:translateY(-50%);background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.13);color:#fff;width:42px;height:42px;border-radius:50%;font-size:17px;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:background .2s,border-color .2s;z-index:10;padding:0}
.fw-testi-arrow:hover{background:var(--rust,#c44b19);border-color:var(--rust,#c44b19)}
.fw-testi-prev{left:0}.fw-testi-next{right:0}
.fw-testi-dots{position:absolute;bottom:16px;left:0;right:0;display:flex;justify-content:center;gap:8px}
.fw-testi-dot{width:8px;height:8px;border-radius:50%;background:rgba(255,255,255,.2);cursor:pointer;transition:background .2s,transform .2s;display:inline-block}
.fw-testi-dot.active{background:var(--rust,#c44b19);transform:scale(1.35)}
@media(min-width:700px){.fw-testi-card{min-width:50%}}
@media(min-width:1024px){.fw-testi-card{min-width:33.333%}}
@media(max-width:699px){.fw-testi-prev{left:-2px}.fw-testi-next{right:-2px}}
</style>

<script>
(function(){
  var track=document.getElementById('fwTestiTrack');
  if(!track)return;
  var cards=track.querySelectorAll('.fw-testi-card');
  var dots=document.querySelectorAll('.fw-testi-dot');
  var total=cards.length, curr=0, timer;

  function perView(){
    return window.innerWidth>=1024?3:window.innerWidth>=700?2:1;
  }
  function goTo(n){
    var pv=perView(), max=Math.max(0,total-pv);
    curr=n<0?max:(n>max?0:n);
    track.style.transform='translateX(-'+(curr*(100/total))+'%)';
    dots.forEach(function(d,i){d.classList.toggle('active',i===curr);});
  }
  function next(){goTo(curr+1);}
  function prev(){goTo(curr-1);}
  function startAuto(){timer=setInterval(next,5000);}
  function stopAuto(){clearInterval(timer);}

  var nb=document.getElementById('fwTestiNext');
  var pb=document.getElementById('fwTestiPrev');
  if(nb)nb.addEventListener('click',function(){stopAuto();next();startAuto();});
  if(pb)pb.addEventListener('click',function(){stopAuto();prev();startAuto();});
  window.fwTGoTo=function(i){stopAuto();goTo(i);startAuto();};

  var sx=0;
  track.addEventListener('touchstart',function(e){sx=e.touches[0].clientX;stopAuto();},{passive:true});
  track.addEventListener('touchend',function(e){
    var dx=sx-e.changedTouches[0].clientX;
    if(Math.abs(dx)>40){dx>0?next():prev();}
    startAuto();
  },{passive:true});

  /* ── Mouse drag (desktop) ── */
  var tIsDragging=false,tDragStartX=0,tDragMoved=false,tDragCurr=0;
  track.style.cursor='grab';
  track.addEventListener('mousedown',function(e){
    tIsDragging=true; tDragMoved=false; tDragCurr=curr;
    tDragStartX=e.pageX; stopAuto();
    track.style.cursor='grabbing';
    track.style.transition='none';
    e.preventDefault();
  });
  document.addEventListener('mousemove',function(e){
    if(!tIsDragging)return;
    var dx=e.pageX-tDragStartX;
    if(Math.abs(dx)>4)tDragMoved=true;
    var pv=perView(), pct=(tDragCurr*(100/total))-(dx/track.parentElement.offsetWidth)*(100/total)*pv;
    track.style.transform='translateX(-'+pct+'%)';
  });
  document.addEventListener('mouseup',function(e){
    if(!tIsDragging)return;
    tIsDragging=false;
    track.style.cursor='grab';
    if(tDragMoved){
      var dx=e.pageX-tDragStartX;
      if(dx<-40)next(); else if(dx>40)prev(); else goTo(tDragCurr);
    }
    startAuto();
  });

  window.addEventListener('resize',function(){goTo(0);});
  goTo(0);startAuto();
})();
</script>
<?php endif; ?>

<!-- LOYALTY -->
<section class="loyalty">
  <div class="sec-tag" style="color:rgba(255,255,255,.6)">Exclusive Members Program</div>
  <h2 style="font-family:var(--headline);font-size:clamp(36px,5vw,60px);color:#fff;letter-spacing:1px;margin-bottom:10px">Why Register?</h2>
  <p style="font-size:15px;color:rgba(255,255,255,.55);font-weight:300;max-width:500px;margin:0 auto;line-height:1.7">Create a free account and unlock perks that grow with every expedition you take.</p>
  <div class="benefits">
    <div class="ben hl"><span class="ben-ico">🏷️</span><div class="ben-n">5% Off Trip 2+</div><div class="ben-d">Every booking after your first earns a guaranteed 5% discount — applied automatically</div></div>
    <div class="ben"><span class="ben-ico">🎽</span><div class="ben-n">Merchandise</div><div class="ben-d">Exclusive FreeWheel gear unlocked at trip milestones</div></div>
    <div class="ben"><span class="ben-ico">⚡</span><div class="ben-n">Early Access</div><div class="ben-d">First dibs on new expedition slots before public release</div></div>
    <div class="ben"><span class="ben-ico">🏆</span><div class="ben-n">Loyalty Tiers</div><div class="ben-d">Explorer → Pioneer → Legend — bigger perks as you rack up expeditions</div></div>
  </div>
  <div style="margin-top:36px;display:flex;flex-direction:column;align-items:center;gap:14px">
    <a href="<?php echo home_url('/community/'); ?>" class="btn-solid" style="font-size:20px;padding:16px 48px;display:inline-flex;align-items:center;gap:10px">
      Join the Community
      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
    </a>
    <div style="font-size:12px;color:rgba(255,255,255,.6);letter-spacing:1px">Free to join · No credit card needed</div>
  </div>
</section>


<!-- LIGHTBOX -->
<div id="fwLb" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,.96);align-items:center;justify-content:center;flex-direction:column" onclick="if(event.target===this)fwLbClose()">
  <button onclick="fwLbClose()" style="position:absolute;top:18px;right:22px;background:none;border:none;color:#fff;font-size:32px;cursor:pointer;line-height:1;z-index:2">✕</button>
  <img loading="lazy" id="fwLbImg" src="" alt="" style="max-width:92vw;max-height:80vh;object-fit:contain;display:block;border-radius:2px">
  <div style="display:flex;align-items:center;gap:24px;margin-top:18px">
    <button onclick="fwLbNav(-1)" style="background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.2);color:#fff;width:44px;height:44px;border-radius:50%;font-size:20px;cursor:pointer">&#8592;</button>
    <span id="fwLbCount" style="color:rgba(255,255,255,.6);font-size:14px;letter-spacing:2px;min-width:60px;text-align:center"></span>
    <button onclick="fwLbNav(1)" style="background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.2);color:#fff;width:44px;height:44px;border-radius:50%;font-size:20px;cursor:pointer">&#8594;</button>
  </div>
</div>

<script>
/* ── Album accordion ── */
function fwExpandAlbum(slug) {
  var target = document.getElementById('album-' + slug);
  if (!target) return;
  var bar = target.querySelector('.album-collapsed-bar');
  var isCollapsed = target.classList.contains('collapsed');
  if (!isCollapsed) {
    /* clicking open album collapses it */
    target.classList.add('collapsed');
    if (bar) bar.setAttribute('aria-expanded', 'false');
    fwUpdateSidebarActive(null);
    return;
  }
  /* collapse all, expand clicked */
  document.querySelectorAll('.album-block').forEach(function(b){
    b.classList.add('collapsed');
    var bBar = b.querySelector('.album-collapsed-bar');
    if (bBar) bBar.setAttribute('aria-expanded', 'false');
  });
  target.classList.remove('collapsed');
  if (bar) bar.setAttribute('aria-expanded', 'true');
  fwUpdateSidebarActive(slug);
  setTimeout(function(){ target.scrollIntoView({behavior:'smooth',block:'start'}); }, 60);
}
function fwUpdateSidebarActive(slug) {
  document.querySelectorAll('.sidebar-link').forEach(function(a){
    var href = a.getAttribute('href') || '';
    a.classList.toggle('active', slug && href === '#album-' + slug);
  });
}
/* wire sidebar links to accordion */
document.addEventListener('DOMContentLoaded', function(){
  document.querySelectorAll('.sidebar-link').forEach(function(a){
    a.addEventListener('click', function(e){
      e.preventDefault();
      var href = a.getAttribute('href') || '';
      var slug = href.replace('#album-','');
      fwExpandAlbum(slug);
    });
  });
  /* first album: update sidebar active on load */
  var first = document.querySelector('.album-block:not(.collapsed)');
  if (first) fwUpdateSidebarActive(first.id.replace('album-',''));
});

/* Self-contained lightbox + show-more. No fw-scripts.js dependency. */
var fwLbSlug='', fwLbIdx=0;

function fwLbOpen(slug, idx){
  var urls = (window.fwAlbums && window.fwAlbums[slug]) || [];
  if(!urls.length) return;
  fwLbSlug = slug; fwLbIdx = idx;
  fwLbShow();
  var lb = document.getElementById('fwLb');
  lb.style.display = 'flex';
  document.body.style.overflow = 'hidden';
}
function fwLbShow(){
  var urls = (window.fwAlbums && window.fwAlbums[fwLbSlug]) || [];
  document.getElementById('fwLbImg').src = urls[fwLbIdx] || '';
  document.getElementById('fwLbCount').textContent = (fwLbIdx+1) + ' / ' + urls.length;
}
function fwLbNav(d){
  var urls = (window.fwAlbums && window.fwAlbums[fwLbSlug]) || [];
  fwLbIdx = (fwLbIdx + d + urls.length) % urls.length;
  fwLbShow();
}
function fwLbClose(){
  document.getElementById('fwLb').style.display = 'none';
  document.body.style.overflow = '';
}
function fwToggle(btn){
  var slug = btn.getAttribute('data-slug');
  var total = parseInt(btn.getAttribute('data-total'));
  var expanded = btn.getAttribute('data-expanded') === '1';
  var grid = document.getElementById('grid-' + slug);
  if(!grid) return;
  var thumbs = grid.querySelectorAll('.album-thumb');
  if(expanded){
    thumbs.forEach(function(t,i){ if(i>=6) t.style.display='none'; });
    btn.textContent = 'Show All ' + total + ' Photos \u25bc';
    btn.setAttribute('data-expanded','0');
    grid.closest('.album-block').scrollIntoView({behavior:'smooth',block:'start'});
  } else {
    thumbs.forEach(function(t){ t.style.display=''; });
    btn.textContent = 'Show Less \u25b2';
    btn.setAttribute('data-expanded','1');
  }
}
document.addEventListener('keydown',function(e){
  if(document.getElementById('fwLb').style.display==='flex'){
    if(e.key==='ArrowLeft') fwLbNav(-1);
    if(e.key==='ArrowRight') fwLbNav(1);
    if(e.key==='Escape') fwLbClose();
  }
});
// Swipe support
(function(){
  var el=document.getElementById('fwLb'), sx=0;
  el.addEventListener('touchstart',function(e){sx=e.touches[0].clientX;},{passive:true});
  el.addEventListener('touchend',function(e){
    var dx=sx-e.changedTouches[0].clientX;
    if(Math.abs(dx)>40) fwLbNav(dx>0?1:-1);
  },{passive:true});
})();
</script>


<!-- ═══════════════════════════════════════════
     NEVER MISS AN EXPEDITION — SUBSCRIBE SECTION
     ═══════════════════════════════════════════ -->
<section class="subscribe" id="subscribe">
  <div class="sub-wrap">
    <div class="sub-eyebrow">Road Dispatch</div>
    <h2 class="sub-h">Never Miss An<br><span>Expedition</span></h2>
    <p class="sub-p">New routes. Surprise slots. First-look invites. Delivered straight to your inbox before we go public.</p>
    <button class="sub-trigger-btn" onclick="fwSubOpen()">
      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,12 2,6"/></svg>
      SUBSCRIBE NOW
    </button>
    <div class="sub-note">No spam. Unsubscribe anytime.</div>
  </div>
</section>

<!-- ── SUBSCRIBE POPUP FORM ── -->
<div id="fwSubOverlay" onclick="if(event.target===this)fwSubClose()">
  <div class="sub-modal">
    <button onclick="fwSubClose()" style="position:absolute;top:14px;right:14px;background:rgba(255,255,255,.08);border:none;color:#fff;width:32px;height:32px;border-radius:2px;cursor:pointer;font-size:16px">&#10005;</button>
    <div class="sub-modal-tag">Join the Road Dispatch</div>
    <div class="sub-modal-h">Stay in the Loop 🏔️</div>
    <p class="sub-modal-p">Get early access to new expeditions, surprise slots, and stories from the road — before anyone else.</p>

    <div class="sub-field">
      <label>Your Name <span style="color:var(--rust)">*</span></label>
      <input type="text" id="fwSubName" placeholder="e.g. Rahul Sharma" autocomplete="name">
    </div>
    <div class="sub-field">
      <label>Mobile Number <span class="sub-optional">(optional)</span></label>
      <input type="tel" id="fwSubMobile" placeholder="e.g. 9876543210" autocomplete="tel" inputmode="numeric">
    </div>
    <div class="sub-field">
      <label>Email Address <span style="color:var(--rust)">*</span></label>
      <input type="email" id="fwSubEmail" placeholder="e.g. rahul@gmail.com" autocomplete="email">
    </div>

    <button class="sub-submit-btn" id="fwSubBtn" onclick="fwSubSubmit()">GET ON THE LIST →</button>
    <div class="sub-form-msg" id="fwSubMsg"></div>
  </div>
</div>

<script>
/* ── Subscribe popup open/close ── */
function fwSubOpen(){
  var ov=document.getElementById('fwSubOverlay');
  if(ov){ov.classList.add('open');document.body.style.overflow='hidden';}
  setTimeout(function(){var n=document.getElementById('fwSubName');if(n)n.focus();},200);
}
function fwSubClose(){
  var ov=document.getElementById('fwSubOverlay');
  if(ov){ov.classList.remove('open');document.body.style.overflow='';}
}
/* ── Subscribe form submit ── */
async function fwSubSubmit(){
  var name   = (document.getElementById('fwSubName')||{}).value||'';
  var mobile = (document.getElementById('fwSubMobile')||{}).value||'';
  var email  = (document.getElementById('fwSubEmail')||{}).value||'';
  var msg    = document.getElementById('fwSubMsg');
  var btn    = document.getElementById('fwSubBtn');

  /* clear previous message */
  if(msg){msg.textContent='';msg.className='sub-form-msg';}

  /* client-side validation */
  if(!name.trim()){
    if(msg){msg.textContent='Please enter your name.';msg.className='sub-form-msg error';}
    document.getElementById('fwSubName').focus(); return;
  }
  if(!email.trim()||!email.includes('@')||!email.includes('.')){
    if(msg){msg.textContent='Please enter a valid email address.';msg.className='sub-form-msg error';}
    document.getElementById('fwSubEmail').focus(); return;
  }

  /* loading state */
  if(btn){btn.disabled=true;btn.textContent='Sending code…';}

  /* call REST /subscribe → triggers Supabase OTP email */
  try{
    var REST=(window.FW_REST_URL||'/wp-json/freewheel/v1').replace(/\/$/,'');
    var payload=new URLSearchParams({name:name.trim(),email:email.trim().toLowerCase(),phone:mobile.trim(),source:'homepage'});
    var r=await fetch(REST+'/subscribe',{
      method:'POST',
      headers:{'Content-Type':'application/x-www-form-urlencoded'},
      body:payload.toString()
    });
    var d=await r.json();
    if(!r.ok) throw new Error(d.message||'Failed to send verification code. Please try again.');

    /* store pending data for OTP overlay to use */
    window._fwSubPending={name:name.trim(),email:email.trim().toLowerCase(),whatsapp:mobile.trim()||null,source:'homepage'};

    /* close subscribe popup, open OTP overlay */
    fwSubClose();
    if(typeof fwOtpOpen==='function') fwOtpOpen(email.trim().toLowerCase());

  }catch(err){
    if(msg){msg.textContent=err.message||'Something went wrong. Please try again.';msg.className='sub-form-msg error';}
  }finally{
    if(btn){btn.disabled=false;btn.textContent='GET ON THE LIST →';}
  }
}
/* ── Allow Enter key to submit ── */
['fwSubName','fwSubMobile','fwSubEmail'].forEach(function(id){
  var el=document.getElementById(id);
  if(el) el.addEventListener('keydown',function(e){ if(e.key==='Enter') fwSubSubmit(); });
});
/* ── Close on Escape ── */
document.addEventListener('keydown',function(e){
  if(e.key==='Escape'){
    var ov=document.getElementById('fwSubOverlay');
    if(ov&&ov.classList.contains('open')) fwSubClose();
  }
});
</script>

<?php get_footer(); ?>

<script>
// Auto-open register modal if redirected from another page
if(window.location.search.includes('register=1') && typeof openRegModal === 'function'){
  window.addEventListener('DOMContentLoaded', function(){
    setTimeout(openRegModal, 500);
  });
}
// Auto-open if Register link clicked from non-homepage pages
document.addEventListener('DOMContentLoaded', function(){
  document.querySelectorAll('[onclick*="openRegModal"]').forEach(function(el){
    el.addEventListener('click', function(e){
      var overlay = document.getElementById('regOverlay');
      if(!overlay){ e.preventDefault(); window.location.href = '<?php echo home_url("/"); ?>?register=1'; }
    });
  });
});
</script>
