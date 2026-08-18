<?php
/**
 * Template Name: Adi Kailash Om Parvat
 * Template Post Type: page
 *
 * FreeWheel Expeditions — Adi Kailash — Om Parvat
 * Template: page-adikailash
 */
get_header(); ?>
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
body{font-family:var(--body);background:var(--paper);color:var(--ink);overflow-x:hidden}
nav{position:fixed;top:0;left:0;right:0;z-index:900;display:flex;align-items:center;justify-content:space-between;padding:0 5vw;height:64px;background:rgba(15,13,11,0.96);border-bottom:2px solid var(--rust)}
.nav-logo{display:flex;align-items:center;gap:10px;text-decoration:none}
.nav-logo img{height:40px;width:40px;object-fit:contain;border-radius:50%;border:2px solid var(--amber)}
.nav-brand{font-family:var(--headline);font-size:20px;color:#fff;letter-spacing:2px;line-height:1}
.nav-brand span{display:block;font-family:var(--body);font-size:9px;font-weight:300;letter-spacing:4px;text-transform:uppercase;color:var(--amber)}
.nav-links{display:flex;gap:24px;list-style:none;align-items:center}
.nav-links a{text-decoration:none;font-size:12px;font-weight:500;letter-spacing:2px;text-transform:uppercase;color:rgba(255,255,255,.65);transition:color .2s}
.nav-links a:hover{color:var(--amber)}
.nav-cta{padding:8px 18px;background:var(--rust) !important;color:#fff !important;border-radius:2px}
.nav-cta:hover{background:#a03508 !important}
.btn-solid{display:inline-block;padding:13px 34px;background:var(--rust);color:#fff;text-decoration:none;font-family:var(--headline);font-size:18px;letter-spacing:2px;border:none;cursor:pointer;transition:background .2s,transform .15s;border-radius:2px}
.btn-solid:hover{background:#a03508;transform:translateY(-2px)}
.btn-ghost{display:inline-block;padding:12px 34px;border:2px solid rgba(255,255,255,.3);color:#fff;text-decoration:none;font-family:var(--headline);font-size:18px;letter-spacing:2px;cursor:pointer;transition:border-color .2s,transform .15s;background:transparent;border-radius:2px}
.btn-ghost:hover{border-color:var(--amber);color:var(--amber);transform:translateY(-2px)}
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
.step-tabs{display:flex;gap:1px;background:var(--sand);margin-bottom:24px}
.stab{flex:1;padding:10px 8px;text-align:center;font-size:10px;letter-spacing:2px;text-transform:uppercase;font-weight:600;background:var(--smoke);color:rgba(0,0,0,.35);cursor:default;transition:all .2s}
.stab.active{background:var(--rust);color:#fff}
.stab.done{background:var(--teal);color:#fff}
.step-panel{display:none}
.step-panel.visible{display:block}
.fg{display:flex;flex-direction:column;gap:5px;margin-bottom:14px}
.fg label{font-size:10px;letter-spacing:2px;text-transform:uppercase;color:#8a7052;font-weight:600}
.fg input,.fg select,.fg textarea{padding:12px 14px;border:1px solid rgba(0,0,0,.15);background:#fff;font-family:var(--body);font-size:14px;color:var(--ink);outline:none;transition:border-color .2s;font-weight:300;border-radius:2px}
.fg input:focus,.fg select:focus{border-color:var(--rust)}
.fg-row{display:grid;grid-template-columns:1fr 1fr;gap:12px}
.payment-opts{display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:20px}
.pay-opt{border:2px solid var(--smoke);padding:18px 16px;cursor:pointer;text-align:center;transition:border-color .2s,background .2s;border-radius:2px}
.pay-opt:hover,.pay-opt.selected{border-color:var(--rust);background:rgba(193,68,14,.04)}
.pay-opt-pct{font-family:var(--headline);font-size:30px;color:var(--rust)}
.pay-opt-label{font-size:11px;color:#8a7052;font-weight:500;letter-spacing:1px;text-transform:uppercase}
.pay-opt-note{font-size:11px;color:var(--ink);margin-top:4px;font-weight:300}
.upi-box{background:#fff;border:1px solid var(--smoke);padding:20px;margin-bottom:16px;border-radius:2px}
.upi-label{font-size:10px;letter-spacing:2px;text-transform:uppercase;color:#8a7052;font-weight:600;margin-bottom:8px}
.upi-id{font-family:monospace;font-size:17px;font-weight:700;color:var(--rust);background:rgba(193,68,14,.08);padding:10px 14px;display:block;border-left:3px solid var(--rust);word-break:break-all;margin-bottom:12px}
.bank-table{width:100%;font-size:13px;border-collapse:collapse}
.bank-table td{padding:6px 0;border-bottom:1px solid var(--smoke)}
.bank-table td:first-child{color:#8a7052;font-weight:400;width:130px}
.qr-box{width:120px;height:120px;margin:14px auto 0;border:2px dashed var(--sand);display:flex;flex-direction:column;align-items:center;justify-content:center;gap:4px}
.qr-ico{font-size:44px;opacity:.3}
.qr-txt{font-size:9px;letter-spacing:2px;text-transform:uppercase;color:#bba880}
.m-btn{width:100%;padding:14px;background:var(--rust);color:#fff;border:none;font-family:var(--headline);font-size:18px;letter-spacing:2px;cursor:pointer;transition:background .2s;margin-top:6px;border-radius:2px}
.m-btn:hover{background:#a03508}
.m-note{font-size:12px;color:#8a7052;font-weight:300;line-height:1.7;margin-top:10px}
.success-box{text-align:center;padding:20px 0}
.success-ico{font-size:60px;margin-bottom:14px;display:block}
.success-h{font-family:var(--headline);font-size:26px;color:var(--ink);letter-spacing:1px;margin-bottom:8px}
.success-p{font-size:14px;color:#6a5a3a;font-weight:300;line-height:1.7}
.trip-price-summary{background:var(--smoke);padding:14px 16px;margin-bottom:18px;display:flex;justify-content:space-between;align-items:center;border-radius:2px}
.tps-label{font-size:11px;letter-spacing:2px;text-transform:uppercase;color:#8a7052;font-weight:600}
.tps-amount{font-family:var(--headline);font-size:24px;color:var(--rust)}
@media(max-width:680px){.nav-links{display:none}}

.trip-hero{min-height:72vh;background:linear-gradient(145deg, #0a1020 0%, #0f1a10 50%, #1a1008 100%);display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;padding:100px 5vw 60px;position:relative;overflow:hidden}
.trip-hero::before{content:'';position:absolute;inset:0;background:rgba(8,5,3,.55)}
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
/* sidebar */
.sidebar{position:sticky;top:80px}
.price-card{background:var(--ink);padding:28px;margin-bottom:20px;border-top:4px solid var(--rust)}
.pc-label{font-size:10px;letter-spacing:3px;text-transform:uppercase;color:rgba(255,255,255,.4);margin-bottom:6px}
.pc-price{font-family:var(--headline);font-size:44px;color:#fff;letter-spacing:1px;line-height:1;margin-bottom:4px}
.pc-type{font-size:12px;color:rgba(255,255,255,.4);font-weight:300;margin-bottom:16px}
.pc-alt{background:rgba(255,255,255,.06);padding:10px 14px;margin-bottom:10px;display:flex;justify-content:space-between;align-items:center}
.pc-alt-label{font-size:11px;color:rgba(255,255,255,.5);font-weight:300}.pc-alt-price{font-family:var(--headline);font-size:18px;color:var(--amber)}
.book-big{width:100%;padding:16px;background:var(--rust);color:#fff;border:none;font-family:var(--headline);font-size:22px;letter-spacing:2px;cursor:pointer;transition:background .2s;margin-top:8px;border-radius:2px}
.book-big:hover{background:#a03508}
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
.cancel-section{background:var(--smoke);padding:40px 5vw}
.cancel-inner{max-width:1100px;margin:0 auto}
.cancel-grid{display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-top:20px}
.cancel-card{background:var(--paper);padding:20px;border-left:3px solid var(--rust)}
.cancel-title{font-family:var(--headline);font-size:16px;color:var(--ink);letter-spacing:1px;margin-bottom:6px}
.cancel-text{font-size:13px;font-weight:300;color:#6a5a3a;line-height:1.6}

/* ── HAMBURGER ── */
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
/* ── MOBILE RESPONSIVE ── */
@media(max-width:680px){
  .nav-links{display:none}
  .hamburger{display:flex}
  .trip-hero{min-height:50vh;padding:80px 5vw 40px}
  .trip-hero-emoji{font-size:48px}
  .trip-h1{font-size:clamp(40px,10vw,72px)}
  .trip-quick{gap:18px}
  .tq-val{font-size:16px}
  .trip-grid{grid-template-columns:1fr}
  .sidebar{position:static}
  .cancel-grid{grid-template-columns:1fr}
  .ie-tabs{flex-wrap:wrap}
  .ie-tab{font-size:10px;padding:10px 6px}
  .carry-grid{grid-template-columns:1fr}
  .price-card{padding:18px}
  .pc-price{font-size:36px}
  footer{flex-direction:column;text-align:center;gap:16px}
  .foot-links{justify-content:center}
  .modal-body{padding:20px 18px}
  .fg-row{grid-template-columns:1fr}
  .payment-opts{grid-template-columns:1fr}
}
@media(max-width:800px){
  .trip-grid{grid-template-columns:1fr}
  .sidebar{position:static}
  .cancel-grid{grid-template-columns:1fr}
}


/* ── PAYMENT PANEL ── */
.pay-panel{background:var(--ink);border-top:4px solid var(--rust);margin-bottom:20px;overflow:hidden}
.pay-header{padding:22px 24px 16px;border-bottom:1px solid rgba(255,255,255,.08)}
.pay-title{font-family:var(--headline);font-size:28px;color:#fff;letter-spacing:1px;margin-bottom:2px}
.pay-sub{font-size:11px;color:rgba(255,255,255,.35);letter-spacing:2px;text-transform:uppercase}
.price-strip{display:flex;flex-wrap:wrap;gap:1px;background:rgba(255,255,255,.07);margin:0}
.ps-item{flex:1;min-width:120px;padding:14px 18px;background:#0f0d0b}
.ps-label{font-size:9px;letter-spacing:3px;text-transform:uppercase;color:rgba(255,255,255,.3);margin-bottom:4px}
.ps-val{font-family:var(--headline);font-size:22px;color:#fff;letter-spacing:1px}
.ps-note{font-size:10px;color:rgba(255,255,255,.25);font-weight:300;margin-top:2px}

/* ── PAYMENT METHODS TABS ── */
.pay-tabs{display:flex;gap:1px;background:rgba(255,255,255,.07)}
.ptab{flex:1;padding:13px 10px;text-align:center;font-size:11px;font-weight:600;letter-spacing:2px;text-transform:uppercase;background:#0a0805;color:rgba(255,255,255,.35);cursor:pointer;transition:all .2s;border:none}
.ptab.active{background:var(--rust);color:#fff}
.pay-body{padding:20px 24px}
.pmethod{display:none}
.pmethod.visible{display:block}

/* ── UPI SECTION ── */
.upi-block{background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.08);border-left:3px solid var(--amber);padding:18px;margin-bottom:14px}
.upi-row{display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap}
.upi-info .upi-label{font-size:9px;letter-spacing:3px;text-transform:uppercase;color:rgba(255,255,255,.3);margin-bottom:6px}
.upi-id-display{font-family:monospace;font-size:20px;font-weight:700;color:var(--amber);letter-spacing:1px}
.upi-name{font-size:12px;color:rgba(255,255,255,.5);font-weight:300;margin-top:4px}
.copy-btn{padding:8px 18px;background:rgba(232,160,32,.15);border:1px solid rgba(232,160,32,.4);color:var(--amber);font-size:11px;font-weight:600;letter-spacing:2px;text-transform:uppercase;cursor:pointer;border-radius:2px;white-space:nowrap;transition:all .2s}
.copy-btn:hover{background:var(--amber);color:var(--ink)}
.copy-btn.copied{background:var(--teal);border-color:var(--teal);color:#fff}

/* QR placeholder */
.qr-placeholder{width:130px;height:130px;border:2px dashed rgba(255,255,255,.12);display:flex;flex-direction:column;align-items:center;justify-content:center;gap:6px;margin:14px auto 0;border-radius:4px}
.qr-icon{font-size:48px;opacity:.2}
.qr-caption{font-size:9px;letter-spacing:2px;text-transform:uppercase;color:rgba(255,255,255,.2);text-align:center}

/* ── BANK SECTION ── */
.bank-block{background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.08);border-left:3px solid var(--teal);padding:18px;margin-bottom:14px}
.bank-row{display:flex;justify-content:space-between;align-items:center;padding:9px 0;border-bottom:1px solid rgba(255,255,255,.06)}
.bank-row:last-child{border-bottom:none}
.bk-label{font-size:10px;letter-spacing:2px;text-transform:uppercase;color:rgba(255,255,255,.3)}
.bk-val{font-size:14px;font-weight:500;color:#fff;text-align:right}
.bk-val.mono{font-family:monospace;font-size:15px;color:var(--teal);letter-spacing:1px}

/* ── CONFIRM NOTE ── */
.pay-confirm-note{background:rgba(42,122,110,.12);border:1px solid rgba(42,122,110,.3);padding:14px 18px;margin-top:16px;display:flex;gap:12px;align-items:flex-start}
.pcn-icon{font-size:20px;flex-shrink:0;margin-top:1px}
.pcn-text{font-size:13px;font-weight:300;color:rgba(255,255,255,.65);line-height:1.7}
.pcn-text strong{color:#fff;font-weight:500}
.wa-confirm-btn{display:flex;align-items:center;justify-content:center;gap:8px;width:100%;margin-top:14px;padding:14px;background:#25d366;color:#fff;border:none;font-family:var(--headline);font-size:18px;letter-spacing:2px;cursor:pointer;transition:background .2s;border-radius:2px;text-decoration:none}
.wa-confirm-btn:hover{background:#1da851}



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


/* ── TRIP PHOTO CAROUSEL ── */
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
@media(max-width:680px){.tg-slide{flex:0 0 85vw}}
/* Lightbox */
.tg-lightbox{position:fixed;inset:0;z-index:2000;background:rgba(0,0,0,.94);display:none;align-items:center;justify-content:center;backdrop-filter:blur(6px)}
.tg-lightbox.open{display:flex}
.tg-lb-img{max-width:90vw;max-height:85vh;object-fit:contain;border-radius:2px}
.tg-lb-close{position:absolute;top:20px;right:24px;background:none;border:none;color:#fff;font-size:28px;cursor:pointer;opacity:.7}
.tg-lb-close:hover{opacity:1}
.tg-lb-prev,.tg-lb-next{position:absolute;top:50%;transform:translateY(-50%);background:rgba(255,255,255,.1);border:none;color:#fff;font-size:24px;cursor:pointer;width:48px;height:48px;display:flex;align-items:center;justify-content:center;border-radius:2px;transition:background .2s}
.tg-lb-prev{left:16px}.tg-lb-next{right:16px}
.tg-lb-prev:hover,.tg-lb-next:hover{background:var(--rust)}
.tg-lb-counter{position:absolute;bottom:20px;left:50%;transform:translateX(-50%);font-size:12px;letter-spacing:2px;color:rgba(255,255,255,.5);text-transform:uppercase}

/* ── SUBSCRIBE POPUP (from homepage) ── */
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
@media(max-width:500px){.sub-modal{padding:28px 20px}}

</style>

<section class="trip-hero">
  <!-- PHOTO SLOT: Hero banner (16:9, min 1920×1080px recommended) -->
<img id="tripHeroImg" src="" alt="Adi Kailash Om Parvat Self Drive Expedition 2026" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;object-position:center;display:none;opacity:0.4;z-index:0">
<div class="trip-hero-content" style="position:relative;z-index:1">
    <span class="trip-hero-emoji">🕉️</span>
    <div class="trip-eyebrow">Self Drive Expedition</div>
    <h1 class="trip-h1">Adi Kailash Om Parvat Self Drive Expedition 2026</h1>
    <p class="trip-sub">Where devotion meets adventure and every turn brings you closer to divinity</p>
    <div class="trip-quick">
      <div class="tq-item"><div class="tq-label">Duration</div><div class="tq-val">4 Nights / 5 Days</div></div>
      <div class="tq-item"><div class="tq-label">Upcoming Dates</div><div class="tq-val">June 2026</div></div>
      <div class="tq-item"><div class="tq-label">Starting From</div><div class="tq-val">₹14,999/person</div></div>
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
        <p class="overview-p">Adi Kailash and Om Parvat are not merely destinations — they are sacred realms where faith, mythology, and untamed wilderness converge. Often called 'Chhota Kailash', Adi Kailash stands as a revered symbol of Lord Shiva's abode, surrounded by pristine landscapes and glacial rivers.</p><p class="overview-p">Om Parvat is nothing short of miraculous. Etched naturally in snow across the face of the mountain, the sacred 'Om' symbol appears as if carved by the universe itself. Witnessing it in person is not just visual awe — it is a deeply spiritual experience that words often fail to describe.</p><p class="overview-p">The journey is an adventure through dramatic Himalayan terrain — narrow mountain roads, roaring Kali River valleys, remote border villages, and landscapes that shift from dense forests to stark high-altitude beauty. Adi Kailash and Om Parvat do not just give you memories — they leave you transformed.</p>

        <div class="itinerary">
          <div class="sec-tag" style="margin-top:40px">Day by Day</div>
          <h2 class="sec-h">Full Itinerary</h2>
          
        <div class="day-item">
          <div class="day-num">Day 1</div>
          <div class="day-content">
            <div class="day-title">Delhi to Pithoragarh (500 km / ~11 hrs)</div>
            <div class="day-text">From Delhi's skyline the open highway leads toward the Himalayas. Plains transform into winding mountain roads, pine-covered hills, and valley views. Arrive in Pithoragarh — the gateway to Adi Kailash.</div>
          </div>
        </div>
        <div class="day-item">
          <div class="day-num">Day 2</div>
          <div class="day-content">
            <div class="day-title">Pithoragarh to Dharchula (100 km / ~3 hrs)</div>
            <div class="day-text">Drive deeper into the Kumaon Himalayas along dramatic valleys, dense forests, and the powerful Kali River. Arrive in Dharchula — a quaint border town where the spiritual journey truly begins.</div>
          </div>
        </div>
        <div class="day-item">
          <div class="day-num">Day 3</div>
          <div class="day-content">
            <div class="day-title">Dharchula to Gunji → Om Parvat & Lipulekh Pass (100 km / ~5 hrs)</div>
            <div class="day-text">The road climbs into raw Himalayan terrain. Reach Gunji, the last major settlement before the frontier. Then witness Om Parvat — the divine 'Om' naturally formed in snow. Stand at Lipulekh Pass, the historic gateway to Tibet.</div>
          </div>
        </div>
        <div class="day-item">
          <div class="day-num">Day 4</div>
          <div class="day-content">
            <div class="day-title">Gunji to Adi Kailash</div>
            <div class="day-text">Journey toward Adi Kailash through glacial streams, vast meadows, and towering peaks. At the base lies the serene Parvati Sarovar reflecting the sacred peak. Time slows. The wind feels different. The silence speaks.</div>
          </div>
        </div>
        <div class="day-item">
          <div class="day-num">Day 5</div>
          <div class="day-content">
            <div class="day-title">Gunji to Jim Corbett / Delhi (700 km / ~15 hrs)</div>
            <div class="day-text">Bid farewell to the Himalayas. Descend through Kali River valleys as peaks fade in the mirror. The highways feel calmer, more meaningful. You're not just returning — you're coming back transformed.</div>
          </div>
        </div>
        </div>
      </div>


<!-- PHOTO GALLERY -->
<section class="trip-gallery" id="gallery-adikailash">
  <div class="trip-gallery-heading">Photo Gallery</div>
  <div class="trip-gallery-sub">Moments from the road</div>
  <div class="tg-track" id="tgTrack-adikailash">
      <div class="tg-slide" onclick="tgOpenLB('adikailash',0)">
        <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=1200&q=80" alt="Om Parvat sacred mountain" loading="lazy">
        <div class="tg-slide-overlay">🔍</div>
      </div>
      <div class="tg-slide" onclick="tgOpenLB('adikailash',1)">
        <img src="https://images.unsplash.com/photo-1587474260584-136574528ed5?w=1200&q=80" alt="Adi Kailash pilgrimage" loading="lazy">
        <div class="tg-slide-overlay">🔍</div>
      </div>
      <div class="tg-slide" onclick="tgOpenLB('adikailash',2)">
        <img src="https://images.unsplash.com/photo-1544735716-392fe2489ffa?w=1200&q=80" alt="Uttarakhand Himalaya" loading="lazy">
        <div class="tg-slide-overlay">🔍</div>
      </div>
      <div class="tg-slide" onclick="tgOpenLB('adikailash',3)">
        <img src="https://images.unsplash.com/photo-1458442310124-dde6edb43d10?w=1200&q=80" alt="Mountain forest trail" loading="lazy">
        <div class="tg-slide-overlay">🔍</div>
      </div>
      <div class="tg-slide" onclick="tgOpenLB('adikailash',4)">
        <img src="https://images.unsplash.com/photo-1469474968028-56623f02e42e?w=1200&q=80" alt="River valley Uttarakhand" loading="lazy">
        <div class="tg-slide-overlay">🔍</div>
      </div>
      <div class="tg-slide" onclick="tgOpenLB('adikailash',5)">
        <img src="https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=1200&q=80" alt="High altitude pass" loading="lazy">
        <div class="tg-slide-overlay">🔍</div>
      </div>
  </div>
  <div class="tg-controls">
    <button class="tg-btn" onclick="tgScroll('adikailash',-1)">&#8592;</button>
    <button class="tg-btn" onclick="tgScroll('adikailash',1)">&#8594;</button>
  </div>
</section>
<script>
var tgData = tgData || {};
tgData['adikailash'] = [
        {src:"https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=1200&q=80",cap:"Om Parvat sacred mountain"},
        {src:"https://images.unsplash.com/photo-1587474260584-136574528ed5?w=1200&q=80",cap:"Adi Kailash pilgrimage"},
        {src:"https://images.unsplash.com/photo-1544735716-392fe2489ffa?w=1200&q=80",cap:"Uttarakhand Himalaya"},
        {src:"https://images.unsplash.com/photo-1458442310124-dde6edb43d10?w=1200&q=80",cap:"Mountain forest trail"},
        {src:"https://images.unsplash.com/photo-1469474968028-56623f02e42e?w=1200&q=80",cap:"River valley Uttarakhand"},
        {src:"https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=1200&q=80",cap:"High altitude pass"}
];
function tgScroll(id, dir) {
  var t = document.getElementById('tgTrack-'+id);
  t.scrollBy({left: dir * t.offsetWidth * 0.6, behavior:'smooth'});
}
var tgCurrentLB = 0, tgCurrentTrip = '';
function tgOpenLB(trip, idx) {
  tgCurrentTrip = trip; tgCurrentLB = idx;
  var d = tgData[trip][idx];
  document.getElementById('tgLBImg').src = d.src;
  document.getElementById('tgLBCap').textContent = (idx+1)+' / '+tgData[trip].length+' — '+d.cap;
  document.getElementById('tgLightbox').classList.add('open');
  document.body.style.overflow='hidden';
}
function tgCloseLB() {
  document.getElementById('tgLightbox').classList.remove('open');
  document.body.style.overflow='';
}
function tgNavLB(dir) {
  var arr = tgData[tgCurrentTrip];
  tgCurrentLB = (tgCurrentLB + dir + arr.length) % arr.length;
  document.getElementById('tgLBImg').src = arr[tgCurrentLB].src;
  document.getElementById('tgLBCap').textContent = (tgCurrentLB+1)+' / '+arr.length+' — '+arr[tgCurrentLB].cap;
}
</script>

      <!-- RIGHT: sidebar -->
      <div class="sidebar">
        <div class="pay-panel">
          <div class="pay-header">
            <div class="pay-title">Book This Expedition</div>
            <div class="pay-sub">Pay directly — no gateway fees</div>
          </div>

          <!-- Price strip -->
          <div class="price-strip">
            <div class="ps-item"><div class="ps-label">Self Drive</div><div class="ps-val">₹14,999</div><div class="ps-note">per person · twin sharing</div></div>
            <div class="ps-item"><div class="ps-label">Couple Discount</div><div class="ps-val">₹11,999</div><div class="ps-note">per person</div></div>
            <div class="ps-item"><div class="ps-label">Seat Sharing</div><div class="ps-val">₹19,999</div><div class="ps-note">per person</div></div>
          </div>

          <!-- Method tabs -->
          <div class="pay-tabs">
            <button class="ptab active" onclick="switchPay(this,'upi')">📱 UPI</button>
            <button class="ptab" onclick="switchPay(this,'bank')">🏦 Bank Transfer</button>
          </div>

          <div class="pay-body">

            <!-- UPI METHOD -->
            <div class="pmethod visible" id="pay-upi">
              <div class="upi-block">
                <div class="upi-row">
                  <div class="upi-info">
                    <div class="upi-label">UPI ID</div>
                    <div class="upi-id-display" id="upiIdText">7817838060@upi</div>
                    <div class="upi-name">FreeWheel Expeditions</div>
                  </div>
                  <button class="copy-btn" id="upiCopyBtn" onclick="copyUPI()">Copy ID</button>
                </div>
              </div>
              <div class="qr-placeholder">
                <!-- PHOTO SLOT: Replace this with your actual UPI QR code image -->
                <!-- <img src="upi-qr.png" style="width:100%;height:100%;object-fit:contain"> -->
                <div class="qr-icon">⬛</div>
                <div class="qr-caption">Scan to Pay<br>UPI QR Code</div>
              </div>
            </div>

            <!-- BANK METHOD -->
            <div class="pmethod" id="pay-bank">
              <div class="bank-block">
                <div class="bank-row"><span class="bk-label">Account Name</span><span class="bk-val">FreeWheel Expeditions</span></div>
                <div class="bank-row"><span class="bk-label">Account Number</span><span class="bk-val mono" id="accNum">0501001000000499</span></div>
                <div class="bank-row"><span class="bk-label">IFSC Code</span><span class="bk-val mono">NTBL0HAL050</span></div>
                <div class="bank-row"><span class="bk-label">Account Type</span><span class="bk-val">Current Account</span></div>
                <div class="bank-row"><span class="bk-label">Bank</span><span class="bk-val">Nainital Bank</span></div>
              </div>
              <button class="copy-btn" style="width:100%;justify-content:center;display:flex" onclick="copyAcc()">Copy Account Number</button>
            </div>

            <!-- CONFIRM NOTE -->
            <div class="pay-confirm-note">
              <span class="pcn-icon">✅</span>
              <div class="pcn-text">
                After payment, <strong>WhatsApp us your screenshot</strong> with your name and selected expedition. We confirm your booking within 4 hours.<br>
                <span style="font-size:11px;color:rgba(255,255,255,.35);margin-top:4px;display:block">+91 78178 38060 · +91 78382 95852</span>
              </div>
            </div>
            <a href="https://wa.me/917817838060?text=Hi%21%20I%20want%20to%20book%20the%20Adi%20Kailash%20%E2%80%94%20Om%20Parvat%20expedition.%20Please%20confirm%20my%20payment." target="_blank" class="wa-confirm-btn">💬 Send Payment Screenshot</a>
          </div>
        </div>

        <div class="dates-card">
          <div class="dc-label">Upcoming Dates</div>
          <div class="dc-date">June 2026</div>
          <div class="dc-note">DM or WhatsApp for exact dates &amp; availability</div>
          <div style="margin-top:14px">
            <a href="https://wa.me/917817838060?text=Hi! I am interested in Adi Kailash — Om Parvat" target="_blank" style="display:flex;align-items:center;justify-content:center;gap:8px;padding:11px;background:#25d366;color:#fff;text-decoration:none;font-family:var(--headline);font-size:15px;letter-spacing:1px;border-radius:2px">💬 WhatsApp Us</a>
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

        <div id="sidebarSub" style="background:linear-gradient(135deg,var(--teal),#1a5a50);padding:20px">
          <div style="font-size:10px;letter-spacing:3px;text-transform:uppercase;color:rgba(255,255,255,.6);margin-bottom:6px">Member Perk</div>
          <div style="font-family:var(--headline);font-size:26px;color:var(--amber);margin-bottom:4px">5% OFF</div>
          <div style="font-size:12px;color:rgba(255,255,255,.7);font-weight:300;line-height:1.5;margin-bottom:14px">Subscribe for exclusive discounts, priority slots &amp; road dispatches — we'll reach you on email or WhatsApp.</div>
          <button onclick="fwSubOpen()" style="width:100%;display:flex;align-items:center;justify-content:center;gap:10px;padding:12px;background:var(--rust);border:none;color:#fff;font-family:var(--headline);font-size:15px;letter-spacing:2px;cursor:pointer;border-radius:2px;transition:background .2s" onmouseover="this.style.background='#a03508'" onmouseout="this.style.background='var(--rust)'">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,12 2,6"/></svg>
            SUBSCRIBE &amp; UNLOCK
          </button>
        </div>
      </div>
    </div>

    <!-- INCLUSIONS / EXCLUSIONS -->
    <div class="inc-exc">
      <div class="sec-tag" style="margin-bottom:20px">Expedition Package</div>
      <div class="ie-tabs">
        <div class="ie-tab active" onclick="showTab('inc',this)">Inclusions</div>
        <div class="ie-tab" onclick="showTab('exc',this)">Exclusions</div>
        <div class="ie-tab" onclick="showTab('can',this)">Cancellation</div>
      </div>
      <div class="ie-content" id="tab-inc">
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
      <div class="ie-content" id="tab-exc" style="display:none">
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
      <div class="ie-content" id="tab-can" style="display:none">
        <ul class="ie-list">
          <li>50% of amount charged as Cancellation Fee if cancelled anytime prior to 10 days of Departure</li>
          <li>100% of amount charged as Cancellation Fee if cancelled within 10 days of Departure Date</li>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- OVERLANDING -->
<section style="background:rgba(42,122,110,.08);border-top:1px solid rgba(42,122,110,.25);border-bottom:1px solid rgba(42,122,110,.25);padding:60px 5vw">
  <div style="max-width:760px;margin:0 auto;text-align:center">
    <div class="sec-tag" style="color:var(--teal)">Want To Overland?</div>
    <h2 style="font-family:var(--headline);font-size:clamp(28px,3.5vw,42px);color:#fff;letter-spacing:1px;margin-bottom:16px">We're Game For This</h2>
    <p style="font-size:15px;font-weight:300;color:rgba(255,255,255,.75);line-height:1.8;margin-bottom:8px">Prefer to camp instead of hotel stays? Some of our travellers do — inside their car, a roof-top tent, or a ground tent, making their own arrangements for stay and cooking.</p>
    <p style="font-size:15px;font-weight:300;color:rgba(255,255,255,.75);line-height:1.8;margin-bottom:24px">The overlanding fee doesn't cover accommodation — it covers what we still provide on the road: convoy building, expedition accessories, and our support team enroute. It's charged per car, split however your group likes, and camping costs are yours to arrange and share.</p>
    <div style="text-align:left;margin-bottom:28px">
      <div style="font-size:10px;letter-spacing:3px;text-transform:uppercase;color:rgba(255,255,255,.5);margin-bottom:10px">You're Still Part Of The Convoy — Never On Your Own</div>
      <ul class="ie-list">
        <li>Full breakdown &amp; roadside support, same as every other participant</li>
        <li>If plans change, we'll do our best to help you find a place to stay nearby</li>
        <li>Radio sets for convoy coordination, same as the rest of the group</li>
        <li>Candid photographs &amp; videos from the expedition team</li>
        <li>Trip merchandise, same as everyone else on the expedition</li>
      </ul>
    </div>
    <div style="display:inline-block;background:var(--ink);border:1px solid rgba(193,68,14,.35);padding:20px 40px;margin-bottom:24px">
      <div style="font-size:10px;letter-spacing:3px;text-transform:uppercase;color:rgba(255,255,255,.5);margin-bottom:6px">Overlanding Fee</div>
      <div style="font-family:var(--headline);font-size:32px;color:#fff;letter-spacing:1px">₹5,000 <span style="font-size:16px;color:rgba(255,255,255,.6)">per car</span></div>
    </div>
    <div>
      <a href="https://wa.me/917817838060?text=Hi%20FreeWheel!%20I'm%20interested%20in%20Overlanding%20for%20the%20Adi%20Kailash%20expedition." target="_blank" class="btn-ghost" style="border-color:var(--rust);color:var(--rust)">Still want to ask anything? 💬 WhatsApp</a>
    </div>
  </div>
</section>

<!-- WHAT TO CARRY -->
<section class="carry-section">
  <div class="carry-inner">
    <div class="sec-tag" style="color:var(--amber)">Be Prepared</div>
    <h2 style="font-family:var(--headline);font-size:clamp(32px,4vw,50px);color:#fff;letter-spacing:1px;margin-bottom:0">Things To Carry</h2>
    <div class="carry-grid">
      <li><div class='carry-item'>All required Vehicle documents (RC, PUC, Insurance) & Individual (DL, ID proof, Personal Insurance)</div></li><li><div class='carry-item'>Toilet Paper & Wipes</div></li><li><div class='carry-item'>Eatables & Water bottles (for any emergency)</div></li><li><div class='carry-item'>Mosquito & Insect repellent</div></li><li><div class='carry-item'>Sufficient clothes as per trip days</div></li><li><div class='carry-item'>Energy & Excitement</div></li><li><div class='carry-item'>Helping hands — not just yours!</div></li><li><div class='carry-item'>Leave your worries at home. CARRY YOUR SMILE.</div></li><li><div class='carry-item'>MINIMUM 2 Jerry Cans of 20L each — fuel stations are limited at high altitudes</div></li>
    </div>
  </div>
</section>

<!-- CONTACT CTA -->
<section style="background:var(--rust);padding:60px 5vw;text-align:center">
  <h2 style="font-family:var(--headline);font-size:clamp(30px,4vw,52px);color:#fff;letter-spacing:2px;margin-bottom:16px">Ready to Drive?</h2>
  <p style="font-size:15px;font-weight:300;color:rgba(255,255,255,.8);margin-bottom:32px">Contact us to confirm availability and secure your seat</p>
  <div style="display:flex;gap:16px;justify-content:center;flex-wrap:wrap">
    <a href="#" onclick="window.scrollTo({top:0,behavior:'smooth'});return false;" class="btn-solid" style="background:#fff;color:var(--rust)">Book Now ↑</a>
    <a href="https://wa.me/917817838060" target="_blank" class="btn-ghost" style="border-color:rgba(255,255,255,.5);color:#fff">💬 WhatsApp</a>
    <a href="/cdn-cgi/l/email-protection#432b262f2f2c0325312626342b26262f263b3326272a372a2c2d306d2a2d" class="btn-ghost" style="border-color:rgba(255,255,255,.5);color:#fff">✉ Email Us</a>
  </div>
  <p style="margin-top:20px;font-size:13px;color:rgba(255,255,255,.7);font-weight:300"><a href="/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="2e464b4242416e485c4b4b59464b4b424b565e4b4a475a4741405d004740">[email&#160;protected]</a> · +91 78178 38060 · +91 78382 95852</p>
</section>

<?php fw_faq_section("adikailash"); ?>

<?php get_footer(); ?>
