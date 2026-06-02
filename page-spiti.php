<?php
/**
 * Template Name: Magical Spiti Valley
 * Template Post Type: page
 *
 * FreeWheel Expeditions — Magical Spiti Valley
 * Template: page-spiti
 */
get_header(); ?>
<style>
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

*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{--ink:#0f0d0b;--paper:#f7f3ec;--rust:#c1440e;--amber:#e8a020;--teal:#2a7a6e;--sand:#d4b896;--smoke:#e8e2d8;--headline:'Bebas Neue',sans-serif;--body:'Barlow',sans-serif}
html{scroll-behavior:smooth}
body{font-family:var(--body);background:var(--paper);color:var(--ink);overflow-x:hidden}
.btn-solid{display:inline-block;padding:13px 34px;background:var(--rust);color:#fff;text-decoration:none;font-family:var(--headline);font-size:18px;letter-spacing:2px;border:none;cursor:pointer;transition:background .2s,transform .15s;border-radius:2px}
.btn-solid:hover{background:#a03508;transform:translateY(-2px)}
.btn-ghost{display:inline-block;padding:12px 34px;border:2px solid rgba(255,255,255,.3);color:#fff;text-decoration:none;font-family:var(--headline);font-size:18px;letter-spacing:2px;cursor:pointer;transition:border-color .2s,transform .15s;background:transparent;border-radius:2px}
.btn-ghost:hover{border-color:var(--amber);color:var(--amber);transform:translateY(-2px)}
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
.fg input,.fg select{padding:12px 14px;border:1px solid rgba(0,0,0,.15);background:#fff;font-family:var(--body);font-size:14px;color:var(--ink);outline:none;transition:border-color .2s;font-weight:300;border-radius:2px}
.fg input:focus,.fg select:focus{border-color:var(--rust)}
.fg-row{display:grid;grid-template-columns:1fr 1fr;gap:12px}
.m-btn{width:100%;padding:14px;background:var(--rust);color:#fff;border:none;font-family:var(--headline);font-size:18px;letter-spacing:2px;cursor:pointer;transition:background .2s;margin-top:6px;border-radius:2px}
.m-btn:hover{background:#a03508}
.m-note{font-size:12px;color:#8a7052;font-weight:300;line-height:1.7;margin-top:10px}
.success-box{text-align:center;padding:20px 0}
.success-ico{font-size:60px;margin-bottom:14px;display:block}
.success-h{font-family:var(--headline);font-size:26px;color:var(--ink);letter-spacing:1px;margin-bottom:8px}
.success-p{font-size:14px;color:#6a5a3a;font-weight:300;line-height:1.7}

.trip-hero{min-height:72vh;background:linear-gradient(145deg,#0a1820 0%,#0f1510 50%,#1a1208 100%);display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;padding:100px 5vw 60px;position:relative;overflow:hidden}
.trip-hero::before{content:'';position:absolute;inset:0;background:rgba(8,5,3,.5)}
.trip-hero-content{position:relative;z-index:1}
.trip-hero-emoji{font-size:72px;margin-bottom:16px;display:block;opacity:.5}
.trip-eyebrow{font-size:11px;font-weight:500;letter-spacing:4px;text-transform:uppercase;color:var(--amber);margin-bottom:14px;display:flex;align-items:center;justify-content:center;gap:10px}
.trip-eyebrow::before,.trip-eyebrow::after{content:'';width:32px;height:1px;background:var(--amber)}
.trip-h1{font-family:var(--headline);font-size:clamp(48px,8vw,100px);color:#fff;line-height:.92;letter-spacing:2px;margin-bottom:16px}
.trip-sub{font-size:16px;font-weight:300;font-style:italic;color:rgba(255,255,255,.55);max-width:600px;margin:0 auto 36px;line-height:1.7}
.trip-quick{display:flex;gap:32px;justify-content:center;flex-wrap:wrap;padding-top:28px;border-top:1px solid rgba(255,255,255,.15)}
.tq-item{text-align:center}.tq-label{font-size:10px;letter-spacing:3px;text-transform:uppercase;color:rgba(255,255,255,.4);margin-bottom:4px}.tq-val{font-family:var(--headline);font-size:20px;color:#fff;letter-spacing:1px}
.trip-main{max-width:1100px;margin:0 auto;padding:80px 5vw}
.trip-grid{display:grid;grid-template-columns:2fr 1fr;gap:60px;align-items:start}
.sec-tag{font-size:11px;font-weight:600;letter-spacing:4px;text-transform:uppercase;color:var(--rust);margin-bottom:14px}
.sec-h{font-family:var(--headline);font-size:clamp(32px,4vw,52px);color:var(--ink);line-height:.95;letter-spacing:1px;margin-bottom:20px}
.overview-p{font-size:15px;font-weight:300;line-height:1.9;color:#4a3c2a;margin-bottom:14px}
.itinerary{margin-top:52px}
.day-item{display:grid;grid-template-columns:80px 1fr;gap:24px;padding:24px 0;border-bottom:1px solid var(--smoke);position:relative}
.day-item::before{content:'';position:absolute;left:36px;top:0;bottom:0;width:1px;background:rgba(193,68,14,.15)}
.day-num{font-family:var(--headline);font-size:36px;color:rgba(193,68,14,.25);text-align:center;line-height:1;padding-top:4px;position:relative;z-index:1}
.day-title{font-family:var(--headline);font-size:18px;color:var(--ink);letter-spacing:1px;margin-bottom:8px}
.day-text{font-size:14px;font-weight:300;line-height:1.85;color:#5a4a30}
.sidebar{position:sticky;top:80px}
.dates-card{background:var(--smoke);padding:20px;margin-bottom:20px}
.dc-label{font-size:10px;letter-spacing:3px;text-transform:uppercase;color:#8a7052;margin-bottom:8px;font-weight:600}
.dc-date{font-family:var(--headline);font-size:20px;color:var(--ink);letter-spacing:1px;margin-bottom:4px}
.dc-note{font-size:12px;color:#8a7052;font-weight:300}
.inc-exc{margin-top:52px}
.ie-tabs{display:flex;gap:1px;background:var(--sand);margin-bottom:0}
.ie-tab{flex:1;padding:12px;text-align:center;font-size:11px;letter-spacing:2px;text-transform:uppercase;font-weight:600;background:var(--smoke);color:rgba(0,0,0,.35);cursor:pointer;transition:all .2s}
.ie-tab.active{background:var(--ink);color:#fff}
.ie-content{background:#fff;border:1px solid var(--smoke);padding:24px}
.ie-list{list-style:none;padding:0}
.ie-list li{padding:8px 0;border-bottom:1px solid var(--smoke);font-size:14px;font-weight:300;color:#4a3c2a;display:flex;align-items:flex-start;gap:10px;line-height:1.6}
.ie-list li::before{content:'✓';color:var(--teal);font-weight:600;flex-shrink:0}
.ie-list.exc li::before{content:'✗';color:var(--rust)}
.carry-section{background:var(--ink);padding:52px 5vw;margin-top:0}
.carry-inner{max-width:1100px;margin:0 auto}
.carry-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:1px;margin-top:28px;background:rgba(255,255,255,.06)}
.carry-item{background:#1a1410;padding:16px 20px;font-size:14px;font-weight:300;color:rgba(255,255,255,.7);display:flex;align-items:flex-start;gap:10px;line-height:1.6}
.carry-item::before{content:'→';color:var(--amber);flex-shrink:0;font-weight:600}
.cancel-grid{display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-top:20px}
.cancel-card{background:var(--paper);padding:20px;border-left:3px solid var(--rust)}
.cancel-title{font-family:var(--headline);font-size:16px;color:var(--ink);letter-spacing:1px;margin-bottom:6px}
.cancel-text{font-size:13px;font-weight:300;color:#6a5a3a;line-height:1.6}
.pay-panel{background:var(--ink);border-top:4px solid var(--rust);margin-bottom:20px;overflow:hidden}
.pay-header{padding:22px 24px 16px;border-bottom:1px solid rgba(255,255,255,.08)}
.pay-title{font-family:var(--headline);font-size:28px;color:#fff;letter-spacing:1px;margin-bottom:2px}
.pay-sub{font-size:11px;color:rgba(255,255,255,.35);letter-spacing:2px;text-transform:uppercase}
.price-strip{display:flex;flex-wrap:wrap;gap:1px;background:rgba(255,255,255,.07);margin:0}
.ps-item{flex:1;min-width:120px;padding:14px 18px;background:#0f0d0b}
.ps-label{font-size:9px;letter-spacing:3px;text-transform:uppercase;color:rgba(255,255,255,.3);margin-bottom:4px}
.ps-val{font-family:var(--headline);font-size:22px;color:#fff;letter-spacing:1px}
.ps-note{font-size:10px;color:rgba(255,255,255,.25);font-weight:300;margin-top:2px}
.pay-tabs{display:flex;gap:1px;background:rgba(255,255,255,.07)}
.ptab{flex:1;padding:13px 10px;text-align:center;font-size:11px;font-weight:600;letter-spacing:2px;text-transform:uppercase;background:#0a0805;color:rgba(255,255,255,.35);cursor:pointer;transition:all .2s;border:none}
.ptab.active{background:var(--rust);color:#fff}
.pay-body{padding:20px 24px}
.pmethod{display:none}
.pmethod.visible{display:block}
.upi-block{background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.08);border-left:3px solid var(--amber);padding:18px;margin-bottom:14px}
.upi-row{display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap}
.upi-info .upi-label{font-size:9px;letter-spacing:3px;text-transform:uppercase;color:rgba(255,255,255,.3);margin-bottom:6px}
.upi-id-display{font-family:monospace;font-size:20px;font-weight:700;color:var(--amber);letter-spacing:1px}
.upi-name{font-size:12px;color:rgba(255,255,255,.5);font-weight:300;margin-top:4px}
.copy-btn{padding:8px 18px;background:rgba(232,160,32,.15);border:1px solid rgba(232,160,32,.4);color:var(--amber);font-size:11px;font-weight:600;letter-spacing:2px;text-transform:uppercase;cursor:pointer;border-radius:2px;white-space:nowrap;transition:all .2s}
.copy-btn:hover{background:var(--amber);color:var(--ink)}
.copy-btn.copied{background:var(--teal);border-color:var(--teal);color:#fff}
.qr-placeholder{width:130px;height:130px;border:2px dashed rgba(255,255,255,.12);display:flex;flex-direction:column;align-items:center;justify-content:center;gap:6px;margin:14px auto 0;border-radius:4px}
.qr-icon{font-size:48px;opacity:.2}
.qr-caption{font-size:9px;letter-spacing:2px;text-transform:uppercase;color:rgba(255,255,255,.2);text-align:center}
.bank-block{background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.08);border-left:3px solid var(--teal);padding:18px;margin-bottom:14px}
.bank-row{display:flex;justify-content:space-between;align-items:center;padding:9px 0;border-bottom:1px solid rgba(255,255,255,.06)}
.bank-row:last-child{border-bottom:none}
.bk-label{font-size:10px;letter-spacing:2px;text-transform:uppercase;color:rgba(255,255,255,.3)}
.bk-val{font-size:14px;font-weight:500;color:#fff;text-align:right}
.bk-val.mono{font-family:monospace;font-size:15px;color:var(--teal);letter-spacing:1px}
.pay-confirm-note{background:rgba(42,122,110,.12);border:1px solid rgba(42,122,110,.3);padding:14px 18px;margin-top:16px;display:flex;gap:12px;align-items:flex-start}
.pcn-icon{font-size:20px;flex-shrink:0;margin-top:1px}
.pcn-text{font-size:13px;font-weight:300;color:rgba(255,255,255,.65);line-height:1.7}
.pcn-text strong{color:#fff;font-weight:500}
.wa-confirm-btn{display:flex;align-items:center;justify-content:center;gap:8px;width:100%;margin-top:14px;padding:14px;background:#25d366;color:#fff;border:none;font-family:var(--headline);font-size:18px;letter-spacing:2px;cursor:pointer;transition:background .2s;border-radius:2px;text-decoration:none}
.wa-confirm-btn:hover{background:#1da851}
.trip-gallery{padding:60px 5vw 0;background:var(--ink)}
.trip-gallery-heading{font-family:var(--headline);font-size:32px;color:#fff;letter-spacing:2px;margin-bottom:6px}
.trip-gallery-sub{font-size:13px;color:rgba(255,255,255,.4);font-weight:300;letter-spacing:2px;text-transform:uppercase;margin-bottom:24px}
.tg-track{display:flex;gap:12px;overflow-x:auto;scroll-snap-type:x mandatory;scrollbar-width:none;padding-bottom:8px}
.tg-track::-webkit-scrollbar{display:none}
.tg-slide{flex:0 0 calc(33.33% - 8px);scroll-snap-align:start;position:relative;aspect-ratio:16/9;overflow:hidden;border-radius:2px;cursor:pointer}
.tg-slide img{width:100%;height:100%;object-fit:cover;transition:transform .4s ease}
.tg-slide:hover img{transform:scale(1.06)}
.tg-slide-overlay{position:absolute;inset:0;background:rgba(193,68,14,0);display:flex;align-items:center;justify-content:center;font-size:24px;opacity:0;transition:all .3s}
.tg-slide:hover .tg-slide-overlay{background:rgba(193,68,14,.3);opacity:1}
.tg-controls{display:flex;gap:10px;margin-top:16px;justify-content:flex-start}
.tg-btn{width:40px;height:40px;border-radius:50%;border:1px solid rgba(255,255,255,.2);background:transparent;color:#fff;cursor:pointer;font-size:16px;display:flex;align-items:center;justify-content:center;transition:all .2s}
.tg-btn:hover{background:var(--rust);border-color:var(--rust)}
.tg-lightbox{position:fixed;inset:0;z-index:2000;background:rgba(0,0,0,.94);display:none;align-items:center;justify-content:center;backdrop-filter:blur(6px)}
.tg-lightbox.open{display:flex}
.tg-lb-img{max-width:90vw;max-height:85vh;object-fit:contain;border-radius:2px}
.tg-lb-close{position:absolute;top:20px;right:24px;background:none;border:none;color:#fff;font-size:28px;cursor:pointer;opacity:.7}
.tg-lb-close:hover{opacity:1}
.tg-lb-prev,.tg-lb-next{position:absolute;top:50%;transform:translateY(-50%);background:rgba(255,255,255,.1);border:none;color:#fff;font-size:24px;cursor:pointer;width:48px;height:48px;display:flex;align-items:center;justify-content:center;border-radius:2px;transition:background .2s}
.tg-lb-prev{left:16px}.tg-lb-next{right:16px}
.tg-lb-prev:hover,.tg-lb-next:hover{background:var(--rust)}
.tg-lb-counter{position:absolute;bottom:20px;left:50%;transform:translateX(-50%);font-size:12px;letter-spacing:2px;color:rgba(255,255,255,.5);text-transform:uppercase}
.hamburger{display:none;flex-direction:column;gap:5px;cursor:pointer;padding:8px;background:none;border:none}
.hamburger span{display:block;width:24px;height:2px;background:#fff;transition:all .3s}
.mobile-menu{display:none;position:fixed;top:64px;left:0;right:0;background:#0f0d0b;border-top:2px solid var(--rust);z-index:850;padding:16px 0;flex-direction:column}
.mobile-menu.open{display:flex}
.mobile-menu a{display:block;padding:14px 24px;font-size:13px;font-weight:500;letter-spacing:2px;text-transform:uppercase;color:rgba(255,255,255,.7);text-decoration:none;border-bottom:1px solid rgba(255,255,255,.06)}
.mobile-menu a:hover{color:var(--amber);background:rgba(255,255,255,.03)}
.mobile-menu .mob-cta{background:var(--rust);color:#fff!important;text-align:center;margin:10px 16px;border-radius:2px;border:none}
@media(max-width:680px){
  .trip-hero{min-height:50vh;padding:80px 5vw 40px}
  .trip-hero-emoji{font-size:48px}
  .trip-h1{font-size:clamp(40px,10vw,72px)}
  .trip-quick{gap:18px}
  .tq-val{font-size:16px}
  .trip-grid{grid-template-columns:1fr}
  .sidebar{position:static}
  .cancel-grid{grid-template-columns:1fr}
  .carry-grid{grid-template-columns:1fr}
  .fg-row{grid-template-columns:1fr}
  .price-strip{flex-direction:column}
  .tg-slide{flex:0 0 85vw}
  footer{flex-direction:column;text-align:center;gap:16px}
}
@media(max-width:800px){
  .trip-grid{grid-template-columns:1fr}
  .sidebar{position:static}
  .cancel-grid{grid-template-columns:1fr}
}
</style>

<section class="trip-hero">
  <img id="tripHeroImg" src="https://freewheelexpeditions.in/wp-content/uploads/2026/05/vlcsnap-2026-05-02-21h42m43s99.jpeg" alt="Magical Spiti Valley Self Drive Expedition 2026" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;object-position:center;opacity:0.4;z-index:0">
  <div class="trip-hero-content" style="position:relative;z-index:1">
    <span class="trip-hero-emoji">❄️</span>
    <div class="trip-eyebrow">Self Drive Expedition</div>
    <h1 class="trip-h1">Magical Spiti Valley</h1>
    <p class="trip-sub">The Middle Land — barren mountains, ancient monasteries, and remote villages that cling to time-honoured traditions</p>
    <div class="trip-quick">
      <div class="tq-item"><div class="tq-label">Duration</div><div class="tq-val">10 Nights / 11 Days</div></div>
      <div class="tq-item"><div class="tq-label">Upcoming Dates</div><div class="tq-val">Dec 2026</div></div>
      <div class="tq-item"><div class="tq-label">Starting From</div><div class="tq-val">₹24,999/person</div></div>
      <div class="tq-item"><div class="tq-label">Trip Style</div><div class="tq-val">Self Drive</div></div>
    </div>
  </div>
</section>

<section style="background:var(--paper)">
  <div class="trip-main">
    <div class="trip-grid">
      <!-- LEFT: overview + itinerary -->
      <div>
        <div class="sec-tag">Trip Overview</div>
        <h2 class="sec-h">About This Expedition</h2>
        <p class="overview-p">Spiti Valley, nestled within the rugged embrace of Himachal Pradesh's northern terrain, is a captivating testament to the wonders of nature and human resilience. This high-altitude desert region, aptly named 'The Middle Land' in Tibetan, unfolds its mystique through a tapestry of barren mountains, ancient monasteries, and remote villages.</p>
        <p class="overview-p">Buddhist monasteries perched upon cliffs like silent sentinels stand as symbols of spiritual devotion in this isolated realm. Spiti's cultural fabric — woven with Tibetan influences — reveals warm hospitality, simple living, and vibrant festivals that echo through its valleys.</p>
        <p class="overview-p">Amidst the challenges of altitude and ruggedness, Spiti Valley remains an enchanting sanctuary for those drawn to its raw beauty, tranquil spirituality, and the humbling harmony between humanity and the untamed wilderness.</p>

        <div class="itinerary">
          <div class="sec-tag" style="margin-top:40px">Day by Day</div>
          <h2 class="sec-h">Full Itinerary</h2>

          <div class="day-item">
            <div class="day-num">1</div>
            <div class="day-content">
              <div class="day-title">Delhi to Narkanda (400 km / ~9 hrs)</div>
              <div class="day-text">Depart Delhi and climb into the Himalayan foothills. Winding roads flanked by lush greenery lead to Narkanda — a charming hill station famed for its apple orchards and breathtaking vistas.</div>
            </div>
          </div>
          <div class="day-item">
            <div class="day-num">2</div>
            <div class="day-content">
              <div class="day-title">Narkanda to Raksham via Chitkul (174 km / ~6 hrs)</div>
              <div class="day-text">Through the Kinnaur Valley to Chitkul — the last inhabited village near the Indo-China border. Then onward to Raksham, surrounded by towering pines and rolling meadows.</div>
            </div>
          </div>
          <div class="day-item">
            <div class="day-num">3</div>
            <div class="day-content">
              <div class="day-title">Raksham to Nako (140 km / ~4 hrs)</div>
              <div class="day-text">Ascend higher, crossing passes and traversing dramatic landscapes. Arrive at Nako village at 12,000 feet — with its serene Nako Lake and ancient monastery.</div>
            </div>
          </div>
          <div class="day-item">
            <div class="day-num">4</div>
            <div class="day-content">
              <div class="day-title">Nako to Tabo via Gue Monastery (90 km / ~4 hrs)</div>
              <div class="day-text">Visit Gue Monastery, home to the mummified remains of a Buddhist monk preserved for centuries. Continue to Tabo — site of the UNESCO-listed Tabo Monastery dating back over a millennium.</div>
            </div>
          </div>
          <div class="day-item">
            <div class="day-num">5</div>
            <div class="day-content">
              <div class="day-title">Tabo to Pin Valley via Dhankar Monastery (90 km / ~5 hrs)</div>
              <div class="day-text">Explore Dhankar Monastery perched atop a rugged cliff over the Spiti Valley. Descend into the remote Pin Valley — wild, raw, and untouched Himalayan wilderness.</div>
            </div>
          </div>
          <div class="day-item">
            <div class="day-num">6</div>
            <div class="day-content">
              <div class="day-title">Pin Valley to Kaza via Key Monastery & Chicham Bridge (100 km / ~6 hrs)</div>
              <div class="day-text">Visit Key Monastery on its rocky hilltop, then cross the dramatic Chicham Bridge — one of the highest suspension bridges in Asia. Arrive in Kaza, Spiti's vibrant hub.</div>
            </div>
          </div>
          <div class="day-item">
            <div class="day-num">7</div>
            <div class="day-content">
              <div class="day-title">Kaza to Langza, Hikkim & Komic (70 km / ~5 hrs)</div>
              <div class="day-text">Explore Langza with its fossil deposits, send a postcard from Hikkim — the world's highest post office (14,000 ft), and visit Komic — the highest inhabited village in Asia (15,000 ft).</div>
            </div>
          </div>
          <div class="day-item">
            <div class="day-num">8</div>
            <div class="day-content">
              <div class="day-title">Kaza to Chandrataal Lake (100 km / ~5 hrs)</div>
              <div class="day-text">Drive through dramatic mountain terrain to Chandrataal — the 'Moon Lake', a high-altitude gem of crystalline water. Camp under the Milky Way in one of the world's most pristine skies.</div>
            </div>
          </div>
          <div class="day-item">
            <div class="day-num">9</div>
            <div class="day-content">
              <div class="day-title">Chandrataal to Manali (120 km / ~7 hrs)</div>
              <div class="day-text">Traverse rugged passes toward Manali. Stop at the legendary Chacha Chachi Dhaba for home-cooked food. Arrive in Manali's enchanting Himalayan embrace.</div>
            </div>
          </div>
          <div class="day-item">
            <div class="day-num">10</div>
            <div class="day-content">
              <div class="day-title">Manali Exploration</div>
              <div class="day-text">Visit Hadimba Temple, stroll Manali Mall Road, and optionally try paragliding, river rafting, or trekking. Or unwind at peaceful Vashisht Village and its ancient hot springs.</div>
            </div>
          </div>
          <div class="day-item">
            <div class="day-num">11</div>
            <div class="day-content">
              <div class="day-title">Manali to Delhi (500 km / ~12 hrs)</div>
              <div class="day-text">The final drive — from the Himalayas back to Delhi. Carry with you the indelible memories, lasting friendships, and stories from the roads of Spiti Valley.</div>
            </div>
          </div>
        </div>

        <!-- INCLUSIONS / EXCLUSIONS -->
        <div class="inc-exc">
          <div class="sec-tag" style="margin-bottom:20px">Expedition Package</div>
          <div class="ie-tabs">
            <div class="ie-tab active" onclick="showTab('sinc',this)">Inclusions</div>
            <div class="ie-tab" onclick="showTab('sexc',this)">Exclusions</div>
            <div class="ie-tab" onclick="showTab('scan',this)">Cancellation</div>
          </div>
          <div class="ie-content" id="tab-sinc">
            <ul class="ie-list">
              <li>Accommodations with Breakfast &amp; Dinner at all hotels per itinerary (double/twin sharing)</li>
              <li>Single room on additional charge</li>
              <li>Expedition Specialist with every convoy</li>
              <li>Radio sets for smooth convoy movement (if allowed)</li>
              <li>Prior arrangements of Local Permits (permit charges paid as per actuals)</li>
              <li>Candid photographs &amp; convoy drone shots (if allowed)</li>
              <li>Exciting fun activities throughout the trip</li>
            </ul>
          </div>
          <div class="ie-content" id="tab-sexc" style="display:none">
            <ul class="ie-list exc">
              <li>Additional vehicle or breakdown assistance charges in case of breakdown</li>
              <li>Any personal expenses at various halts &amp; accommodations</li>
              <li>Drinks (alcoholic, mineral, aerated) &amp; Lunch on all days</li>
              <li>Cost due to itinerary change caused by landslides, roadblocks or any factor beyond control</li>
              <li>Paid Parking, Vehicle/Individual Entry Tax, Fuel, Tips, Laundry or personal expenses</li>
              <li>Expenses involved in any Medical Emergency or Mishap</li>
              <li>Any expenses NOT mentioned in Inclusions</li>
            </ul>
          </div>
          <div class="ie-content" id="tab-scan" style="display:none">
            <ul class="ie-list">
              <li>50% of amount charged as Cancellation Fee if cancelled anytime prior to 10 days of Departure</li>
              <li>100% of amount charged as Cancellation Fee if cancelled within 10 days of Departure Date</li>
            </ul>
          </div>
        </div>
      </div>

      <!-- RIGHT: sidebar -->
      <div class="sidebar">
        <div class="pay-panel">
          <div class="pay-header">
            <div class="pay-title">Book This Expedition</div>
            <div class="pay-sub">Pay directly — no gateway fees</div>
          </div>
          <div class="price-strip">
            <div class="ps-item"><div class="ps-label">Self Drive</div><div class="ps-val">₹24,999</div><div class="ps-note">per person · twin sharing</div></div>
            <div class="ps-item"><div class="ps-label">Seat Sharing</div><div class="ps-val">₹29,999</div><div class="ps-note">per person</div></div>
          </div>
          <div class="pay-tabs">
            <button class="ptab active" onclick="switchPaySpiti(this,'upi')">📱 UPI</button>
            <button class="ptab" onclick="switchPaySpiti(this,'bank')">🏦 Bank Transfer</button>
          </div>
          <div class="pay-body">
            <div class="pmethod visible" id="spiti-pay-upi">
              <div class="upi-block">
                <div class="upi-row">
                  <div class="upi-info">
                    <div class="upi-label">UPI ID</div>
                    <div class="upi-id-display" id="spitiUpiId">7817838060@upi</div>
                    <div class="upi-name">FreeWheel Expeditions</div>
                  </div>
                  <button class="copy-btn" id="spitiCopyBtn" onclick="copySpitiUPI()">Copy ID</button>
                </div>
              </div>
              <div class="qr-placeholder">
                <div class="qr-icon">⬛</div>
                <div class="qr-caption">Scan to Pay<br>UPI QR Code</div>
              </div>
            </div>
            <div class="pmethod" id="spiti-pay-bank">
              <div class="bank-block">
                <div class="bank-row"><span class="bk-label">Account Name</span><span class="bk-val">FreeWheel Expeditions</span></div>
                <div class="bank-row"><span class="bk-label">Account Number</span><span class="bk-val mono">0501001000000499</span></div>
                <div class="bank-row"><span class="bk-label">IFSC Code</span><span class="bk-val mono">NTBL0HAL050</span></div>
                <div class="bank-row"><span class="bk-label">Account Type</span><span class="bk-val">Current Account</span></div>
                <div class="bank-row"><span class="bk-label">Bank</span><span class="bk-val">Nainital Bank</span></div>
              </div>
            </div>
            <div class="pay-confirm-note">
              <span class="pcn-icon">✅</span>
              <div class="pcn-text">After payment, <strong>WhatsApp us your screenshot</strong> with your name and selected expedition. We confirm your booking within 4 hours.<br>
                <span style="font-size:11px;color:rgba(255,255,255,.35);margin-top:4px;display:block">+91 78178 38060 · +91 78382 95852</span>
              </div>
            </div>
            <a href="https://wa.me/917817838060?text=Hi%21%20I%20want%20to%20book%20the%20Magical%20Spiti%20Valley%20expedition.%20Please%20confirm%20my%20payment." target="_blank" class="wa-confirm-btn">💬 Send Payment Screenshot</a>
          </div>
        </div>

        <div class="dates-card">
          <div class="dc-label">Upcoming Dates</div>
          <div class="dc-date">Dec 2026</div>
          <div class="dc-note">DM or WhatsApp for exact dates &amp; availability</div>
          <div style="margin-top:14px">
            <a href="https://wa.me/917817838060?text=Hi! I am interested in Magical Spiti Valley" target="_blank" style="display:flex;align-items:center;justify-content:center;gap:8px;padding:11px;background:#25d366;color:#fff;text-decoration:none;font-family:var(--headline);font-size:15px;letter-spacing:1px;border-radius:2px">💬 WhatsApp Us</a>
          </div>
        </div>

        <div style="background:var(--smoke);padding:20px;margin-bottom:20px">
          <div class="dc-label">Activities</div>
          <div style="display:flex;flex-wrap:wrap;gap:6px;margin-top:10px">
            <span style="font-size:11px;padding:4px 10px;background:rgba(193,68,14,.1);color:var(--rust);font-weight:600;letter-spacing:1px;text-transform:uppercase">Offroading</span>
            <span style="font-size:11px;padding:4px 10px;background:rgba(193,68,14,.1);color:var(--rust);font-weight:600;letter-spacing:1px;text-transform:uppercase">Nature Walk</span>
            <span style="font-size:11px;padding:4px 10px;background:rgba(193,68,14,.1);color:var(--rust);font-weight:600;letter-spacing:1px;text-transform:uppercase">Camping</span>
            <span style="font-size:11px;padding:4px 10px;background:rgba(193,68,14,.1);color:var(--rust);font-weight:600;letter-spacing:1px;text-transform:uppercase">Cultural</span>
            <span style="font-size:11px;padding:4px 10px;background:rgba(193,68,14,.1);color:var(--rust);font-weight:600;letter-spacing:1px;text-transform:uppercase">Stargazing</span>
          </div>
        </div>

        <div style="background:linear-gradient(135deg,var(--teal),#1a5a50);padding:20px">
          <div style="font-size:10px;letter-spacing:3px;text-transform:uppercase;color:rgba(255,255,255,.6);margin-bottom:6px">Member Perk</div>
          <div style="font-family:var(--headline);font-size:26px;color:var(--amber);margin-bottom:4px">5% OFF</div>
          <div style="font-size:12px;color:rgba(255,255,255,.7);font-weight:300;line-height:1.5;margin-bottom:14px">Register for free to unlock 5% discount on your 2nd trip and beyond</div>
          <a href="/register/" style="width:100%;display:flex;align-items:center;justify-content:center;padding:12px;background:var(--rust);color:#fff;font-family:var(--headline);font-size:15px;letter-spacing:2px;text-decoration:none;border-radius:2px">Register Free →</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- PHOTO GALLERY -->
<section class="trip-gallery" id="gallery-spiti">
  <div class="trip-gallery-heading">Photo Gallery</div>
  <div class="trip-gallery-sub">Moments from the road</div>
  <div class="tg-track" id="tgTrack-spiti">
    <div class="tg-slide" onclick="tgOpenLB('spiti',0)">
      <img src="https://freewheelexpeditions.in/wp-content/uploads/2026/05/vlcsnap-2026-05-02-21h42m43s99.jpeg" alt="Spiti Valley self drive" loading="lazy">
      <div class="tg-slide-overlay">🔍</div>
    </div>
    <div class="tg-slide" onclick="tgOpenLB('spiti',1)">
      <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=1200&q=80" alt="Key Monastery Spiti" loading="lazy">
      <div class="tg-slide-overlay">🔍</div>
    </div>
    <div class="tg-slide" onclick="tgOpenLB('spiti',2)">
      <img src="https://images.unsplash.com/photo-1544735716-392fe2489ffa?w=1200&q=80" alt="Chandrataal Lake" loading="lazy">
      <div class="tg-slide-overlay">🔍</div>
    </div>
    <div class="tg-slide" onclick="tgOpenLB('spiti',3)">
      <img src="https://images.unsplash.com/photo-1458442310124-dde6edb43d10?w=1200&q=80" alt="Himalayan mountain road" loading="lazy">
      <div class="tg-slide-overlay">🔍</div>
    </div>
    <div class="tg-slide" onclick="tgOpenLB('spiti',4)">
      <img src="https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=1200&q=80" alt="High altitude Spiti pass" loading="lazy">
      <div class="tg-slide-overlay">🔍</div>
    </div>
    <div class="tg-slide" onclick="tgOpenLB('spiti',5)">
      <img src="https://images.unsplash.com/photo-1469474968028-56623f02e42e?w=1200&q=80" alt="Kinnaur valley drive" loading="lazy">
      <div class="tg-slide-overlay">🔍</div>
    </div>
  </div>
  <div class="tg-controls">
    <button class="tg-btn" onclick="tgScroll('spiti',-1)">&#8592;</button>
    <button class="tg-btn" onclick="tgScroll('spiti',1)">&#8594;</button>
  </div>
</section>

<!-- CARRY -->
<section class="carry-section">
  <div class="carry-inner">
    <div class="sec-tag" style="color:var(--amber)">Be Prepared</div>
    <h2 style="font-family:var(--headline);font-size:clamp(32px,4vw,50px);color:#fff;letter-spacing:1px;margin-bottom:0">Things To Carry</h2>
    <div class="carry-grid">
      <div class="carry-item">All required Vehicle documents (RC, PUC, Insurance) &amp; Individual (DL, ID proof, Personal Insurance)</div>
      <div class="carry-item">Toilet Paper &amp; Wipes</div>
      <div class="carry-item">Eatables &amp; Water bottles (for any emergency)</div>
      <div class="carry-item">Mosquito &amp; Insect repellent</div>
      <div class="carry-item">Sufficient clothes as per trip days</div>
      <div class="carry-item">Energy &amp; Excitement</div>
      <div class="carry-item">Helping hands — not just yours!</div>
      <div class="carry-item">Leave your worries at home. CARRY YOUR SMILE.</div>
      <div class="carry-item">MINIMUM 2 Jerry Cans of 20L each — fuel stations are limited at high altitudes</div>
    </div>
  </div>
</section>

<!-- CTA -->
<section style="background:var(--rust);padding:60px 5vw;text-align:center">
  <h2 style="font-family:var(--headline);font-size:clamp(30px,4vw,52px);color:#fff;letter-spacing:2px;margin-bottom:16px">Ready to Drive?</h2>
  <p style="font-size:15px;font-weight:300;color:rgba(255,255,255,.8);margin-bottom:32px">Contact us to confirm availability and secure your seat</p>
  <div style="display:flex;gap:16px;justify-content:center;flex-wrap:wrap">
    <a href="#" onclick="window.scrollTo({top:0,behavior:'smooth'});return false;" class="btn-solid" style="background:#fff;color:var(--rust)">Book Now ↑</a>
    <a href="https://wa.me/917817838060" target="_blank" class="btn-ghost" style="border-color:rgba(255,255,255,.5);color:#fff">💬 WhatsApp</a>
  </div>
</section>

<!-- Lightbox -->
<div class="tg-lightbox" id="tgLightbox">
  <button class="tg-lb-close" onclick="tgCloseLB()">✕</button>
  <button class="tg-lb-prev" onclick="tgNavLB(-1)">&#8592;</button>
  <img class="tg-lb-img" id="tgLBImg" src="" alt="">
  <button class="tg-lb-next" onclick="tgNavLB(1)">&#8594;</button>
  <div class="tg-lb-counter" id="tgLBCap"></div>
</div>

<script>
var tgData = tgData || {};
tgData['spiti'] = [
  {src:"https://freewheelexpeditions.in/wp-content/uploads/2026/05/vlcsnap-2026-05-02-21h42m43s99.jpeg",cap:"Spiti Valley self drive"},
  {src:"https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=1200&q=80",cap:"Key Monastery Spiti"},
  {src:"https://images.unsplash.com/photo-1544735716-392fe2489ffa?w=1200&q=80",cap:"Chandrataal Lake"},
  {src:"https://images.unsplash.com/photo-1458442310124-dde6edb43d10?w=1200&q=80",cap:"Himalayan mountain road"},
  {src:"https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=1200&q=80",cap:"High altitude Spiti pass"},
  {src:"https://images.unsplash.com/photo-1469474968028-56623f02e42e?w=1200&q=80",cap:"Kinnaur valley drive"}
];
function tgScroll(id,dir){var t=document.getElementById('tgTrack-'+id);t.scrollBy({left:dir*t.offsetWidth*0.6,behavior:'smooth'});}
var tgCurrentLB=0,tgCurrentTrip='';
function tgOpenLB(trip,idx){tgCurrentTrip=trip;tgCurrentLB=idx;var d=tgData[trip][idx];document.getElementById('tgLBImg').src=d.src;document.getElementById('tgLBCap').textContent=(idx+1)+' / '+tgData[trip].length+' — '+d.cap;document.getElementById('tgLightbox').classList.add('open');document.body.style.overflow='hidden';}
function tgCloseLB(){document.getElementById('tgLightbox').classList.remove('open');document.body.style.overflow='';}
function tgNavLB(dir){var arr=tgData[tgCurrentTrip];tgCurrentLB=(tgCurrentLB+dir+arr.length)%arr.length;document.getElementById('tgLBImg').src=arr[tgCurrentLB].src;document.getElementById('tgLBCap').textContent=(tgCurrentLB+1)+' / '+arr.length+' — '+arr[tgCurrentLB].cap;}
function showTab(id,el){document.querySelectorAll('[id^="tab-s"]').forEach(function(t){t.style.display='none';});document.getElementById('tab-'+id).style.display='block';document.querySelectorAll('.ie-tab').forEach(function(t){t.classList.remove('active');});el.classList.add('active');}
function switchPaySpiti(el,method){document.querySelectorAll('#spiti-pay-upi,#spiti-pay-bank').forEach(function(p){p.classList.remove('visible');});document.getElementById('spiti-pay-'+method).classList.add('visible');document.querySelectorAll('.ptab').forEach(function(t){t.classList.remove('active');});el.classList.add('active');}
function copySpitiUPI(){var btn=document.getElementById('spitiCopyBtn');navigator.clipboard.writeText('7817838060@upi').then(function(){btn.textContent='Copied!';btn.classList.add('copied');setTimeout(function(){btn.textContent='Copy ID';btn.classList.remove('copied');},2000);});}
</script>

<?php get_footer(); ?>
