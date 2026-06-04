<?php
/**
 * FreeWheel Expeditions — header.php v2.0
 * Nav CSS is embedded directly to prevent plugin overrides
 */
?><!DOCTYPE html>
<html lang="en">
<head>
<script>
/* FreeWheel URL Config — PHP outputs URLs safely to JS */
window.FW_HOME      = '<?php echo esc_js(trailingslashit(home_url())); ?>';
window.FW_DASHBOARD = '<?php echo esc_js(home_url("/my-account/")); ?>';
window.FW_REGISTER  = '<?php echo esc_js(home_url("/register/")); ?>';
window.FW_CONNECT   = '<?php echo esc_js(home_url("/connect/")); ?>';
</script>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="theme-color" content="#c1440e">
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="apple-mobile-web-app-title" content="FreeWheel">
<!-- Preconnect hints injected by fw-seo.php via wp_head priority 1 -->
<?php wp_head(); ?>
<script>
window.FW_AUTH = {
  rest_url:      '<?php echo esc_js(rest_url("freewheel/v1")); ?>',
  supabase_url:  '<?php echo esc_js(defined("FW_SUPABASE_URL") ? FW_SUPABASE_URL : ""); ?>',
  /* supabase_key: anon/public key — safe to expose; all sensitive ops use server-side PHP */
  supabase_key:  '<?php echo esc_js(defined("FW_SUPABASE_ANON") ? FW_SUPABASE_ANON : ""); ?>',
  dashboard_url: '<?php echo esc_js(home_url("/dashboard/")); ?>',
  login_url:     '<?php echo esc_js(home_url("/login/")); ?>',
  register_url:  '<?php echo esc_js(home_url("/register/")); ?>',
  home_url:      '<?php echo esc_js(home_url("/")); ?>',
  admin_url:     '<?php echo esc_js(home_url("/admin-dashboard/")); ?>'
};
</script>
<style>
/* ═══════════════════════════════════════════════
   FREEWHEEL NAV — EMBEDDED DIRECT (plugin-proof)
   ═══════════════════════════════════════════════ */

/* Kill ALL other theme headers/footers/bars */
.site-header,
.elementor-location-header,
.elementor-section-wrap > .elementor-section:first-child,
#masthead,
#site-header,
.main-header,
header.header,
.woocommerce-store-notice,
p.woocommerce-store-notice,
.e-page-template,
.woolentor-template,
.elementor-kit-parts-header,
[data-elementor-type="header"] {
  display: none !important;
}

/* Admin bar offset for nav */
body.admin-bar nav { top: 32px !important; }
body.admin-bar .mobile-menu { top: 96px !important; }
@media(max-width:680px) {
  body.admin-bar nav { top: 46px !important; }
  body.admin-bar .mobile-menu { top: 110px !important; }
}



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
.nav-login{padding:8px 16px;border:1px solid rgba(255,255,255,.25);color:rgba(255,255,255,.7) !important;border-radius:2px;transition:all .2s}
.nav-login:hover{border-color:var(--rust);color:#fff !important}
.nav-dropdown{position:relative!important;z-index:901!important}
.nav-dropdown:hover .nav-drop-menu,.nav-dropdown.open .nav-drop-menu{display:block!important;visibility:visible!important;opacity:1!important;pointer-events:all!important}
.nav-drop-toggle{display:flex!important;align-items:center;gap:6px;cursor:pointer;font-size:12px;font-weight:500;letter-spacing:2px;text-transform:uppercase;color:rgba(255,255,255,.65);padding:0;background:none;border:none;min-height:44px}
.nav-drop-toggle:hover{color:var(--amber)!important}
.nav-drop-menu{display:none;position:absolute!important;top:100%!important;left:50%!important;transform:translateX(-50%)!important;background:#1a1410!important;border:1px solid rgba(255,255,255,.15)!important;border-top:3px solid var(--rust)!important;min-width:240px!important;z-index:9999!important;margin-top:0!important;padding:6px 0!important;list-style:none!important;box-shadow:0 16px 40px rgba(0,0,0,.6)!important}
.nav-drop-menu li{list-style:none!important;padding:0!important;margin:0!important}
.nav-drop-menu a{display:block!important;padding:12px 20px!important;font-size:11px!important;letter-spacing:2px!important;text-transform:uppercase!important;color:rgba(255,255,255,.7)!important;text-decoration:none!important;white-space:nowrap!important;transition:background .2s,color .2s!important;border-left:3px solid transparent!important}
.nav-drop-menu a:hover{background:rgba(193,68,14,.15)!important;color:var(--amber)!important;border-left-color:var(--rust)!important}
/* Search bar */
.nav-search-wrap{position:relative;display:flex;align-items:center}
.nav-search-input{width:0;opacity:0;padding:0;border:none;background:rgba(255,255,255,.08);color:#fff;font-size:12px;letter-spacing:1px;border-radius:2px;transition:width .3s,opacity .3s,padding .3s;outline:none}
.nav-search-wrap.active .nav-search-input{width:180px;opacity:1;padding:8px 12px}
.nav-search-btn{background:none;border:none;color:rgba(255,255,255,.6);cursor:pointer;font-size:16px;padding:4px 8px;transition:color .2s;min-height:44px}
.nav-search-btn:hover{color:var(--amber)}
.nav-search-results{display:none;position:absolute;top:calc(100% + 8px);right:0;background:#1a1410;border:1px solid rgba(255,255,255,.15);border-top:3px solid var(--rust);min-width:280px;z-index:9999;box-shadow:0 16px 40px rgba(0,0,0,.6)}
.nav-search-results.visible{display:block}
.nsr-item{display:block;padding:12px 16px;font-size:12px;letter-spacing:1px;color:rgba(255,255,255,.7);text-decoration:none;border-bottom:1px solid rgba(255,255,255,.06);transition:background .2s}
.nsr-item:hover{background:rgba(193,68,14,.15);color:var(--amber)}
.nsr-tag{font-size:9px;letter-spacing:2px;text-transform:uppercase;color:rgba(255,255,255,.3);margin-left:8px}
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

/* ── HAMBURGER MENU ── */
.hamburger{display:none;flex-direction:column;gap:5px;cursor:pointer;padding:8px;background:none;border:none}
.hamburger span{display:block;width:24px;height:2px;background:#fff;transition:all .3s}
.hamburger.open span:nth-child(1){transform:rotate(45deg) translate(5px,5px)}
.hamburger.open span:nth-child(2){opacity:0}
.hamburger.open span:nth-child(3){transform:rotate(-45deg) translate(5px,-5px)}
.mobile-menu{display:none;position:fixed;top:64px;left:0;right:0;background:#0f0d0b;border-top:2px solid var(--rust);z-index:850;padding:16px 0;flex-direction:column}
.mobile-menu.open{display:flex}
.mobile-menu a{display:block;padding:14px 24px;font-size:13px;font-weight:500;letter-spacing:2px;text-transform:uppercase;color:rgba(255,255,255,.7);text-decoration:none;border-bottom:1px solid rgba(255,255,255,.06)}
.mobile-menu a:last-child{border-bottom:none}
.mobile-menu a:hover{color:var(--amber);background:rgba(255,255,255,.03)}
.mobile-menu .mob-cta{background:var(--rust);color:#fff !important;text-align:center;margin:10px 16px;border-radius:2px;border:none}

/* ── MOBILE RESPONSIVE ── */
@media(max-width:680px){
  .nav-links{display:none}
  .hamburger{display:flex}
  .hero-h1{font-size:clamp(56px,14vw,90px);line-height:.9}
  .hero-stats{gap:24px}
  .stat-n{font-size:36px}
  .about-inner{grid-template-columns:1fr}
  .about-vis{display:none}
  .carousel-track{gap:12px}
  .trip-card{min-width:280px;flex:0 0 85vw}
  .past-album-grid{grid-template-columns:1fr}
  .benefits{grid-template-columns:1fr}
  .sub-form{flex-direction:column}
  .sub-form input{width:100%;border-bottom:1px solid rgba(255,255,255,.15)}
  .sub-form button{width:100%;padding:14px}
  footer{flex-direction:column;text-align:center;gap:16px}
  .foot-links{justify-content:center}
  .modal-body{padding:20px 18px}
  .fg-row{grid-template-columns:1fr}
  .payment-opts{grid-template-columns:1fr}
  .hero-ctas{flex-direction:column;align-items:center}
}
@media(max-width:800px){
  .about-inner{grid-template-columns:1fr}
  .about-vis{display:none}
  .trip-grid{grid-template-columns:1fr}
  .sidebar{position:static}
  .cancel-grid{grid-template-columns:1fr}
  .tc-body{padding:16px}
}


/* ── HERO ── */

</style>

<script>
/* ── Persistent login state across all pages ── */
(function() {
  try {
    var s = JSON.parse(localStorage.getItem('fw_session') || 'null');
    if (!s || !s.access_token || s.expires_at < Date.now()) {
      localStorage.removeItem('fw_session');
      return;
    }
    /* User is logged in — update nav */
    document.addEventListener('DOMContentLoaded', function() {
      var name = s.first_name || s.email || 'Account';
      var initials = name.slice(0,1).toUpperCase();

      /* Desktop: replace Register button with user avatar + name */
      var dashUrl = (window.FW_AUTH && FW_AUTH.dashboard_url) || '/dashboard/';

      /* Desktop nav */
      var navCta = document.querySelector('li .nav-cta, li a.nav-cta, li button.nav-cta');
      if (!navCta) navCta = document.querySelector('.nav-cta');
      if (navCta) {
        var li = navCta.closest ? navCta.closest('li') : navCta.parentElement;
        if (li) {
          var userNav = document.createElement('div');
          userNav.style.cssText = 'display:flex;align-items:center;gap:10px';
          userNav.innerHTML =
            '<a href="'+dashUrl+'" style="display:flex;align-items:center;gap:8px;text-decoration:none;color:#fff;font-size:12px;letter-spacing:1px;text-transform:uppercase">'+
              '<div style="width:30px;height:30px;border-radius:50%;background:rgba(193,68,14,.3);border:2px solid var(--rust);display:flex;align-items:center;justify-content:center;font-family:var(--headline);font-size:13px;color:var(--rust);flex-shrink:0">'+initials+'</div>'+
              '<span style="color:rgba(255,255,255,.8)">'+name+'</span>'+
            '</a>';
          li.innerHTML = '';
          li.appendChild(userNav);
        }
      }

      /* Mobile: replace mob-cta */
      try {
        var mobCta = document.querySelector('.mob-cta');
        if (mobCta) {
          mobCta.textContent = 'My Dashboard';
          if (mobCta.tagName === 'A') mobCta.href = dashUrl;
        }
      } catch(me) {}
    });
  } catch(e) {}
})();
</script>
</head>
<body <?php body_class(); ?>>

<?php wp_body_open(); ?>
<script>
/* Inline mobile menu — works before fw-scripts.js loads */
function toggleMobileMenu(){
  var m = document.getElementById('mobileMenu');
  var b = document.getElementById('hamburgerBtn');
  if (!m || !b) return;
  var isOpen = m.classList.contains('open');
  m.classList.toggle('open', !isOpen);
  b.classList.toggle('open', !isOpen);
  document.body.style.overflow = isOpen ? '' : 'hidden';
}
function closeMobileMenu(){
  var m = document.getElementById('mobileMenu');
  var b = document.getElementById('hamburgerBtn');
  if (!m || !b) return;
  m.classList.remove('open');
  b.classList.remove('open');
  document.body.style.overflow = '';
}
function closeModal(id){
  var el = document.getElementById(id);
  if (el) { el.classList.remove('open'); document.body.style.overflow = ''; }
}
</script>


<nav>
  <a href="<?php echo home_url('/'); ?>" class="nav-logo">
    <img src="<?php echo get_template_directory_uri(); ?>/images/header-1.jpg" alt="FreeWheel Expeditions" fetchpriority="high">
    <div class="nav-brand">FreeWheel<span>Expeditions</span></div>
  </a>
  <button class="hamburger" id="hamburgerBtn" onclick="toggleMobileMenu()" aria-label="Menu">
    <span></span><span></span><span></span>
  </button>
  <ul class="nav-links">
    <li><a href="<?php echo home_url('/'); ?>#about">About</a></li>
    <li class="nav-dropdown">
      <button class="nav-drop-toggle" data-dropdown="expeditions">Expeditions ▾</button>
      <ul class="nav-drop-menu">
        <li><a href="<?php echo home_url('/'); ?>#upcoming">Upcoming Expeditions</a></li>
        <li><a href="<?php echo home_url('/'); ?>#past">Past Expeditions</a></li>
        <li style="border-top:1px solid rgba(255,255,255,.08);margin:4px 0"></li>
        <li><a href="<?php echo home_url('/self-drive-leh-ladakh/'); ?>">Self Drive Leh Ladakh</a></li>
        <li><a href="<?php echo home_url('/self-drive-spiti-valley/'); ?>">Self Drive Spiti Valley</a></li>
        <li><a href="<?php echo home_url('/self-drive-adi-kailash/'); ?>">Self Drive Adi Kailash</a></li>
        <li><a href="<?php echo home_url('/self-drive-darma-valley/'); ?>">Self Drive Darma Valley</a></li>
        <li><a href="<?php echo home_url('/self-drive-upper-mustang/'); ?>">Self Drive Upper Mustang</a></li>
      </ul>
    </li>
    <li><a href="<?php echo home_url('/merchandise/'); ?>">Merchandise</a></li>
    <li><a href="<?php echo home_url('/community/'); ?>">Community</a></li>
    <li><a href="<?php echo home_url('/blog/'); ?>">Blog</a></li>
    <li id="navMyAccount" style="display:none"></li>
    <li>
      <div class="nav-search-wrap" id="navSearchWrap">
        <input type="text" class="nav-search-input" id="navSearchInput" placeholder="Search expeditions..." autocomplete="off">
        <button class="nav-search-btn" onclick="toggleNavSearch()" title="Search">🔍</button>
        <div class="nav-search-results" id="navSearchResults"></div>
      </div>
    </li>
    <li><a href="<?php echo esc_url(home_url('/register/')); ?>" class="nav-cta" style="font-size:12px;font-weight:500;letter-spacing:2px;text-transform:uppercase">Register</a></li>
  </ul>
</nav>

<div class="mobile-menu" id="mobileMenu">
  <a href="<?php echo home_url('/'); ?>#about" onclick="closeMobileMenu()">About</a>
  <a href="<?php echo home_url('/'); ?>#upcoming" onclick="closeMobileMenu()">Upcoming Expeditions</a>
  <a href="<?php echo home_url('/'); ?>#past" onclick="closeMobileMenu()">Past Expeditions</a>
  <a href="<?php echo home_url('/merchandise/'); ?>" onclick="closeMobileMenu()">Merchandise</a>
  <a href="<?php echo home_url('/community/'); ?>" onclick="closeMobileMenu()">Community</a>
  <a href="<?php echo home_url('/blog/'); ?>" onclick="closeMobileMenu()">Blog</a>
  <a href="<?php echo home_url('/self-drive-leh-ladakh/'); ?>" onclick="closeMobileMenu()">Leh Ladakh Guide</a>
  <a href="<?php echo home_url('/self-drive-spiti-valley/'); ?>" onclick="closeMobileMenu()">Spiti Valley Guide</a>
  <a href="<?php echo home_url('/self-drive-adi-kailash/'); ?>" onclick="closeMobileMenu()">Adi Kailash Guide</a>
  <a href="<?php echo esc_url(home_url('/register/')); ?>" onclick="closeMobileMenu()" class="mob-cta" style="text-align:center">Register</a>
</div>


<!-- member modal removed — Register now links directly to /community/ -->



<!-- Register links directly to /register/ page -->
<script>
function fwComingSoon(){ window.location.href='/register/'; }
function fwComingSoonClose(){}

// Dropdown toggle via event delegation
document.addEventListener('click', function(e){
  var toggle = e.target.closest('[data-dropdown]');
  if(toggle){
    e.stopPropagation();
    var dropdown = toggle.closest('.nav-dropdown');
    var isOpen = dropdown.classList.contains('open');
    // Close all dropdowns
    document.querySelectorAll('.nav-dropdown.open').forEach(function(d){ d.classList.remove('open'); });
    // Toggle clicked one
    if(!isOpen) dropdown.classList.add('open');
    return;
  }
  // Close all if clicked outside
  document.querySelectorAll('.nav-dropdown.open').forEach(function(d){
    if(!d.contains(e.target)) d.classList.remove('open');
  });
});

// Search functionality
var fwSearchData = [
  {title:"Leh Ladakh Self Drive Expedition", url:"/expedition/dream-leh-ladakh-expedition/", tag:"Expedition"},
  {title:"Spiti Valley Self Drive Expedition", url:"/expedition/magical-spiti-valley-expedition/", tag:"Expedition"},
  {title:"Adi Kailash Om Parvat Expedition", url:"/expedition/adi-kailash-om-parvat-self-drive-expedition/", tag:"Expedition"},
  {title:"Darma Valley Expedition", url:"/expedition/rimkhim-pass-lapthal-darma-valley-expedition/", tag:"Expedition"},
  {title:"Upper Mustang Expedition", url:"/expedition/upper-mustang-muktinath-expedition/", tag:"Expedition"},
  {title:"Self Drive Leh Ladakh Guide", url:"/self-drive-leh-ladakh/", tag:"Guide"},
  {title:"Self Drive Spiti Valley Guide", url:"/self-drive-spiti-valley/", tag:"Guide"},
  {title:"Self Drive Adi Kailash Guide", url:"/self-drive-adi-kailash/", tag:"Guide"},
  {title:"Self Drive Darma Valley Guide", url:"/self-drive-darma-valley/", tag:"Guide"},
  {title:"Self Drive Upper Mustang Guide", url:"/self-drive-upper-mustang/", tag:"Guide"},
  {title:"Umling La — World's Highest Road", url:"/blog/umling-la-worlds-highest-motorable-road-ladakh/", tag:"Blog"},
  {title:"Chitkul to Spiti Valley", url:"/blog/chitkul-to-spiti-valley-kinnaur-route/", tag:"Blog"},
];

function toggleNavSearch(){
  var wrap = document.getElementById('navSearchWrap');
  var input = document.getElementById('navSearchInput');
  wrap.classList.toggle('active');
  if(wrap.classList.contains('active')){ input.focus(); }
  else { input.value=''; document.getElementById('navSearchResults').classList.remove('visible'); }
}

document.addEventListener('DOMContentLoaded', function(){
  var input = document.getElementById('navSearchInput');
  if(!input) return;
  input.addEventListener('input', function(){
    var q = this.value.toLowerCase().trim();
    var res = document.getElementById('navSearchResults');
    if(q.length < 2){ res.classList.remove('visible'); return; }
    var matches = fwSearchData.filter(function(d){ return d.title.toLowerCase().includes(q); }).slice(0,6);
    if(matches.length === 0){ res.innerHTML='<div class="nsr-item" style="color:rgba(255,255,255,.3)">No results found</div>'; }
    else { res.innerHTML = matches.map(function(m){ return '<a class="nsr-item" href="'+m.url+'">'+m.title+'<span class="nsr-tag">'+m.tag+'</span></a>'; }).join(''); }
    res.classList.add('visible');
  });
  document.addEventListener('click', function(e){
    if(!document.getElementById('navSearchWrap').contains(e.target)){
      document.getElementById('navSearchResults').classList.remove('visible');
    }
  });
  input.addEventListener('keydown', function(e){
    if(e.key==='Escape'){ toggleNavSearch(); }
  });
});
</script>

<!-- ── FW SUBSCRIBE OTP MODAL ── -->
<div id="fwOtpOverlay" style="position:fixed;inset:0;z-index:3000;background:rgba(8,5,3,.94);display:none;align-items:center;justify-content:center;padding:16px;backdrop-filter:blur(8px)">
  <div style="background:#0f0d0b;border:1px solid rgba(196,75,25,.35);border-radius:4px;padding:36px 32px;max-width:420px;width:100%;position:relative;animation:regIn .3s ease">
    <button onclick="fwOtpClose()" style="position:absolute;top:14px;right:14px;background:rgba(255,255,255,.08);border:none;color:#fff;width:32px;height:32px;border-radius:2px;cursor:pointer;font-size:16px">&#10005;</button>
    <div style="font-size:10px;letter-spacing:3px;text-transform:uppercase;color:var(--rust,#c44b19);margin-bottom:10px">Verify Email</div>
    <div style="font-family:var(--headline,'Impact',sans-serif);font-size:28px;color:#fff;letter-spacing:1px;margin-bottom:8px">One Last Step &#127956;</div>
    <p style="font-size:13px;color:rgba(255,255,255,.5);line-height:1.7;margin-bottom:24px">We sent a 6-digit code to <strong id="fwOtpEmailDisplay" style="color:rgba(255,255,255,.85)"></strong>. Enter it below to join the road dispatch list.</p>
    <input id="fwOtpInput" type="text" inputmode="numeric" maxlength="6" placeholder="- - - - - -"
      style="width:100%;box-sizing:border-box;padding:13px 16px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.2);color:#fff;font-size:22px;letter-spacing:8px;border-radius:2px;outline:none;font-family:monospace;text-align:center;margin-bottom:12px">
    <button onclick="fwOtpVerify()" id="fwOtpVerifyBtn"
      style="width:100%;padding:14px;background:var(--rust,#c44b19);border:none;color:#fff;font-family:var(--headline,'Impact',sans-serif);font-size:18px;letter-spacing:2px;cursor:pointer;border-radius:2px">
      CONFIRM &amp; SUBSCRIBE
    </button>
    <div id="fwOtpMsg" style="font-size:12px;margin-top:12px;text-align:center;min-height:16px"></div>
    <div style="text-align:center;margin-top:14px">
      <button onclick="fwOtpResend()" style="background:none;border:none;color:rgba(255,255,255,.3);font-size:12px;cursor:pointer;text-decoration:underline">Resend code</button>
    </div>
  </div>
</div>
<script>
var _fwSubPending=null;
function fwOtpOpen(email){
  var ov=document.getElementById('fwOtpOverlay');
  var disp=document.getElementById('fwOtpEmailDisplay');
  var inp=document.getElementById('fwOtpInput');
  var msg=document.getElementById('fwOtpMsg');
  if(disp)disp.textContent=email;
  if(inp)inp.value='';
  if(msg)msg.textContent='';
  if(ov){ov.style.display='flex';document.body.style.overflow='hidden';}
  setTimeout(function(){if(inp)inp.focus();},200);
}
function fwOtpClose(){
  var ov=document.getElementById('fwOtpOverlay');
  if(ov){ov.style.display='none';document.body.style.overflow='';}
}
async function fwOtpResend(){
  if(!_fwSubPending)return;
  var msg=document.getElementById('fwOtpMsg');
  try{
    var REST=(window.FW_REST_URL||'/wp-json/freewheel/v1').replace(/\/$/,'');
    var rp=new URLSearchParams({name:_fwSubPending.name,email:_fwSubPending.email,phone:_fwSubPending.whatsapp||'',source:_fwSubPending.source});var r=await fetch(REST+'/subscribe',{method:'POST',headers:{'Content-Type':'application/x-www-form-urlencoded'},body:rp.toString()});
    if(msg){msg.textContent='New code sent!';msg.style.color='#4ade80';}
  }catch(err){if(msg){msg.textContent='Error: '+err.message;msg.style.color='#f87171';}}
}
async function fwOtpVerify(){
  var otp=(document.getElementById('fwOtpInput')||{}).value||'';
  var msg=document.getElementById('fwOtpMsg');
  var btn=document.getElementById('fwOtpVerifyBtn');
  if(!otp||otp.length<6){if(msg){msg.textContent='Enter the 6-digit code.';msg.style.color='#f87171';}return;}
  if(!_fwSubPending){if(msg){msg.textContent='Session expired. Please start again.';msg.style.color='#f87171';}return;}
  if(btn){btn.disabled=true;btn.textContent='Verifying...';}
  var REST=(window.FW_REST_URL||'/wp-json/freewheel/v1').replace(/\/$/,'');
  try{
    var wp2=new URLSearchParams({email:_fwSubPending.email,otp:otp.trim()});var r=await fetch(REST+'/send-welcome',{method:'POST',headers:{'Content-Type':'application/x-www-form-urlencoded'},body:wp2.toString()});
    var d=await r.json();
    if(!r.ok) throw new Error(d.message||'Invalid code. Please try again.');
    if(d.already){
      if(msg){msg.textContent='Already subscribed! See you on the road.';msg.style.color='#4ade80';}
    }else{
      if(msg){msg.textContent="You're in! Check your inbox for a welcome email.";msg.style.color='#4ade80';}
    }
    _fwSubPending=null;
    setTimeout(function(){ fwOtpClose(); fwShowSuccessPopup(d.already); }, 400);
  }catch(err){
    if(msg){msg.textContent=err.message||'Invalid code. Try again.';msg.style.color='#f87171';}
  }finally{
    if(btn){btn.disabled=false;btn.textContent='CONFIRM & SUBSCRIBE';}
  }
}
document.addEventListener('keydown',function(e){
  if(e.key==='Escape'){
    var ov=document.getElementById('fwOtpOverlay');if(ov&&ov.style.display==='flex')fwOtpClose();
    var sv=document.getElementById('fwSuccessOverlay');if(sv&&sv.style.display==='flex')fwSuccessClose();
  }
});
</script>

<!-- ── FW SUBSCRIBE SUCCESS POPUP ── -->
<div id="fwSuccessOverlay" onclick="if(event.target===this)fwSuccessClose()" style="display:none;position:fixed;inset:0;z-index:4000;background:rgba(8,5,3,.92);align-items:center;justify-content:center;padding:20px;backdrop-filter:blur(8px)">
  <div style="background:#1a1208;border:1px solid rgba(255,255,255,.1);border-radius:4px;padding:40px 32px;max-width:380px;width:100%;text-align:center;position:relative">
    <button onclick="fwSuccessClose()" style="position:absolute;top:14px;right:14px;background:rgba(255,255,255,.08);border:none;color:#fff;width:32px;height:32px;border-radius:2px;cursor:pointer;font-size:16px">&#10005;</button>
    <span id="fwSuccessEmoji" style="font-size:56px;display:block;margin-bottom:16px">🏔️</span>
    <div id="fwSuccessHeading" style="font-family:var(--headline,'Impact',sans-serif);font-size:30px;color:#fff;letter-spacing:1px;margin-bottom:10px">Welcome to the Road!</div>
    <div id="fwSuccessBody" style="font-size:14px;color:rgba(255,255,255,.55);line-height:1.7;margin-bottom:28px">You're on the FreeWheel war path.<br>Expect a welcome drop in your inbox soon.</div>
    <button onclick="fwSuccessClose()" style="padding:13px 32px;background:var(--rust,#c1440e);border:none;color:#fff;font-family:var(--headline,'Impact',sans-serif);font-size:18px;letter-spacing:2px;cursor:pointer;border-radius:2px;transition:background .2s">BLAZE THE TRAIL →</button>
  </div>
</div>
<script>
function fwShowSuccessPopup(already){
  var ov=document.getElementById('fwSuccessOverlay');
  var h=document.getElementById('fwSuccessHeading');
  var b=document.getElementById('fwSuccessBody');
  var em=document.getElementById('fwSuccessEmoji');
  if(already){
    if(em)em.textContent='✅';
    if(h)h.textContent='Already on the list!';
    if(b)b.textContent='Your trail is already marked. Ride on, explorer.';
  }else{
    if(em)em.textContent='🏔️';
    if(h)h.textContent='Welcome to the Road!';
    if(b)b.innerHTML="You're on the FreeWheel war path.<br>Expect a welcome drop in your inbox soon.";
  }
  if(ov){ov.style.display='flex';document.body.style.overflow='hidden';}
}
  setTimeout(function(){ fwSuccessClose(); }, 4500);
function fwSuccessClose(){
  var ov=document.getElementById('fwSuccessOverlay');
  if(ov){ov.style.display='none';document.body.style.overflow='';}
}
</script>

