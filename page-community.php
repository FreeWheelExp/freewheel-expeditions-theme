<?php
/**
 * FreeWheel Expeditions — Community Page
 * Template Name: Community
 * Template Post Type: page
 */
get_header();
// ── Schema: BreadcrumbList ────────────────────────────────────────
$bc_schema = [
    "@context"        => "https://schema.org",
    "@type"           => "BreadcrumbList",
    "itemListElement" => [
        ["@type" => "ListItem", "position" => 1, "name" => "Home",        "item" => home_url('/')],
        ["@type" => "ListItem", "position" => 2, "name" => "Community", "item" => get_permalink()]
    ]
];
echo '<script type="application/ld+json">' . json_encode($bc_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
 ?>
<style>


*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{--ink:#0f0d0b;--paper:#f7f3ec;--rust:#c1440e;--amber:#e8a020;--teal:#2a7a6e;--sand:#d4b896;--smoke:#e8e2d8;--headline:'Bebas Neue',sans-serif;--body:'Barlow',sans-serif}
html{scroll-behavior:smooth}
body{font-family:var(--body);background:var(--ink);color:#fff;overflow-x:hidden}
nav{position:fixed;top:0;left:0;right:0;z-index:900;display:flex;align-items:center;justify-content:space-between;padding:0 5vw;height:64px;background:rgba(15,13,11,.97);border-bottom:2px solid var(--rust)}
.nav-logo{display:flex;align-items:center;gap:10px;text-decoration:none}
.nav-logo img{height:40px;width:40px;object-fit:contain;border-radius:50%;border:2px solid var(--amber)}
.nav-brand{font-family:var(--headline);font-size:20px;color:#fff;letter-spacing:2px;line-height:1}
.nav-brand span{display:block;font-family:var(--body);font-size:9px;font-weight:300;letter-spacing:4px;text-transform:uppercase;color:var(--amber)}
.nav-links{display:flex;gap:22px;list-style:none;align-items:center}
.nav-links a{text-decoration:none;font-size:11px;font-weight:500;letter-spacing:2px;text-transform:uppercase;color:rgba(255,255,255,.6);transition:color .2s}
.nav-links a:hover,.nav-active{color:var(--amber)!important}
.nav-cta{padding:8px 18px;background:var(--rust)!important;color:#fff!important;border-radius:2px}
.nav-cta:hover{background:#a03508!important}
.hamburger{display:none;flex-direction:column;gap:5px;cursor:pointer;padding:8px;background:none;border:none}
.hamburger span{display:block;width:24px;height:2px;background:#fff;transition:all .3s}
.hamburger.open span:nth-child(1){transform:rotate(45deg) translate(5px,5px)}
.hamburger.open span:nth-child(2){opacity:0}
.hamburger.open span:nth-child(3){transform:rotate(-45deg) translate(5px,-5px)}
.mobile-menu{display:none;position:fixed;top:64px;left:0;right:0;background:#0f0d0b;border-top:2px solid var(--rust);z-index:850;padding:16px 0;flex-direction:column}
.mobile-menu.open{display:flex}
.mobile-menu a{display:block;padding:14px 24px;font-size:12px;font-weight:500;letter-spacing:2px;text-transform:uppercase;color:rgba(255,255,255,.7);text-decoration:none;border-bottom:1px solid rgba(255,255,255,.06)}
.mobile-menu .mob-cta{background:var(--rust);color:#fff!important;text-align:center;margin:10px 16px;border-radius:2px}
footer{background:#070503;padding:28px 5vw;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;border-top:1px solid rgba(193,68,14,.3)}
.foot-logo{display:flex;align-items:center;gap:8px}
.foot-logo img{height:30px;border-radius:50%;border:1px solid rgba(255,255,255,.2)}
.foot-brand{font-family:var(--headline);font-size:15px;color:#fff;letter-spacing:2px}
.foot-copy{font-size:11px;color:rgba(255,255,255,.22)}
.foot-links{display:flex;gap:20px}
.foot-links a{font-size:11px;color:rgba(255,255,255,.3);text-decoration:none;letter-spacing:1px;text-transform:uppercase;transition:color .2s}
.foot-links a:hover{color:var(--amber)}
.btn-solid{display:inline-block;padding:14px 36px;background:var(--rust);color:#fff;text-decoration:none;font-family:var(--headline);font-size:20px;letter-spacing:2px;border:none;cursor:pointer;transition:background .2s,transform .15s;border-radius:2px}
.btn-solid:hover{background:#a03508;transform:translateY(-2px)}
@media(max-width:700px){.nav-links{display:none}.hamburger{display:flex}footer{flex-direction:column;text-align:center}.foot-links{justify-content:center}}


/* ── HERO ── */
.comm-hero{min-height:60vh;display:flex;align-items:center;justify-content:center;text-align:center;padding:100px 5vw 60px;position:relative;overflow:hidden}
.ch-bg{position:absolute;inset:0;background:radial-gradient(ellipse at 30% 40%,rgba(193,68,14,.2) 0%,transparent 55%),radial-gradient(ellipse at 75% 70%,rgba(42,122,110,.15) 0%,transparent 50%),linear-gradient(180deg,var(--ink) 0%,#0a0805 100%)}
.ch-grid{position:absolute;inset:0;background-image:linear-gradient(rgba(255,255,255,.03) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.03) 1px,transparent 1px);background-size:60px 60px}
.ch-content{position:relative;z-index:1;max-width:720px}
.ch-eyebrow{font-size:11px;font-weight:500;letter-spacing:5px;text-transform:uppercase;color:var(--amber);margin-bottom:18px;display:flex;align-items:center;justify-content:center;gap:12px}
.ch-eyebrow::before,.ch-eyebrow::after{content:'';width:36px;height:1px;background:var(--amber)}
.ch-h1{font-family:var(--headline);font-size:clamp(54px,9vw,110px);color:#fff;line-height:.9;letter-spacing:2px;margin-bottom:20px}
.ch-h1 span{color:var(--rust)}
.ch-sub{font-size:17px;font-weight:300;color:rgba(255,255,255,.5);line-height:1.8;margin-bottom:40px}

/* ── JOIN CARD ── */
.join-card{background:linear-gradient(135deg,#1a1a0a,#0a1a12);border:1px solid rgba(255,255,255,.1);border-top:3px solid #25d366;padding:40px;max-width:520px;margin:0 auto 0;text-align:center;position:relative}
.join-card::before{content:'';position:absolute;inset:0;background:radial-gradient(circle at 50% 0%,rgba(37,211,102,.08) 0%,transparent 60%);pointer-events:none}
.join-wa-icon{font-size:56px;margin-bottom:16px;display:block}
.join-h{font-family:var(--headline);font-size:30px;color:#fff;letter-spacing:1px;margin-bottom:8px}
.join-p{font-size:14px;font-weight:300;color:rgba(255,255,255,.5);line-height:1.7;margin-bottom:28px}
.wa-join-btn{display:inline-flex;align-items:center;gap:10px;padding:16px 40px;background:#25d366;color:#fff;text-decoration:none;font-family:var(--headline);font-size:22px;letter-spacing:2px;border-radius:2px;transition:background .2s,transform .15s}
.wa-join-btn:hover{background:#1da851;transform:translateY(-2px)}
.join-note{font-size:11px;color:rgba(255,255,255,.25);margin-top:16px;letter-spacing:1px}

/* ── WHAT IS COMMUNITY ── */
.what-section{padding:96px 5vw;background:#080604}
.what-inner{max-width:1100px;margin:0 auto;display:grid;grid-template-columns:1fr 1fr;gap:80px;align-items:center}
.what-text .sec-tag{font-size:11px;font-weight:600;letter-spacing:4px;text-transform:uppercase;color:var(--rust);margin-bottom:14px}
.what-text h2{font-family:var(--headline);font-size:clamp(38px,5vw,64px);color:#fff;line-height:.95;letter-spacing:1px;margin-bottom:22px}
.what-text h2 em{color:var(--amber);font-style:normal}
.what-text p{font-size:15px;font-weight:300;color:rgba(255,255,255,.55);line-height:1.9;margin-bottom:14px}
.what-vis{position:relative}
.comm-stats{display:grid;grid-template-columns:1fr 1fr;gap:2px;background:rgba(255,255,255,.06)}
.cstat{background:#0a0805;padding:28px 22px;text-align:center}
.cstat-n{font-family:var(--headline);font-size:52px;color:var(--amber);line-height:1;margin-bottom:6px}
.cstat-l{font-size:11px;letter-spacing:3px;text-transform:uppercase;color:rgba(255,255,255,.35)}

/* ── PERKS ── */
.perks-section{padding:80px 5vw;background:var(--ink)}
.perks-inner{max-width:1100px;margin:0 auto}
.perks-heading{text-align:center;margin-bottom:52px}
.perks-heading .sec-tag{font-size:11px;font-weight:600;letter-spacing:4px;text-transform:uppercase;color:var(--amber);margin-bottom:12px}
.perks-heading h2{font-family:var(--headline);font-size:clamp(36px,5vw,62px);color:#fff;letter-spacing:1px}
.perks-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:2px;background:rgba(255,255,255,.06)}
.perk{background:#0a0805;padding:32px 26px;transition:background .2s}
.perk:hover{background:#111}
.perk-icon{font-size:38px;margin-bottom:16px;display:block}
.perk-title{font-family:var(--headline);font-size:22px;color:#fff;letter-spacing:1px;margin-bottom:8px}
.perk-desc{font-size:13px;font-weight:300;color:rgba(255,255,255,.45);line-height:1.7}

/* ── TESTIMONIALS ── */
.testi-section{padding:80px 5vw;background:#060402}
.testi-inner{max-width:1100px;margin:0 auto}
.testi-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:2px;margin-top:48px;background:rgba(255,255,255,.05)}
.testi-card{background:#0a0805;padding:28px;border-top:2px solid transparent;transition:border-color .3s}
.testi-card:hover{border-top-color:var(--rust)}
.testi-quote{font-size:15px;font-weight:300;font-style:italic;color:rgba(255,255,255,.6);line-height:1.8;margin-bottom:20px}
.testi-quote::before{content:'"';font-family:var(--headline);font-size:48px;color:rgba(193,68,14,.3);line-height:0;vertical-align:-.4em;margin-right:4px}
.testi-name{font-size:12px;font-weight:600;letter-spacing:2px;text-transform:uppercase;color:rgba(255,255,255,.35)}
.testi-trip{font-size:11px;letter-spacing:1px;text-transform:uppercase;color:var(--rust);margin-top:3px}

/* ── BOTTOM CTA ── */
.comm-cta{background:linear-gradient(135deg,var(--teal),#1a5a50);padding:80px 5vw;text-align:center}
.comm-cta h2{font-family:var(--headline);font-size:clamp(36px,5vw,68px);color:#fff;letter-spacing:2px;margin-bottom:14px}
.comm-cta p{font-size:16px;font-weight:300;color:rgba(255,255,255,.7);margin-bottom:36px;max-width:500px;margin-left:auto;margin-right:auto}

@media(max-width:800px){.what-inner{grid-template-columns:1fr}.perks-grid,.testi-grid{grid-template-columns:1fr 1fr}}
@media(max-width:500px){.perks-grid,.testi-grid,.comm-stats{grid-template-columns:1fr}}

</style>

<!-- HERO -->
<section class="comm-hero">
  <div class="ch-bg"></div>
  <div class="ch-grid"></div>
  <div class="ch-content">
    <div class="ch-eyebrow">500+ Members & Growing</div>
    <h1 class="ch-h1">The Free<span>Wheel</span><br>Community</h1>
    <p class="ch-sub">A tribe of self-drive adventurers who live for open roads, mountain passes, and connections that last long after the journey ends. This is not just a travel group — it is a family.</p>


  <!-- ── MEMBER ALBUMS CAROUSEL ── -->
  <section style="padding:72px 0;background:#0a0805;overflow:hidden">
    <div style="max-width:1200px;margin:0 auto;padding:0 16px;margin-bottom:24px">
      <div style="display:flex;align-items:flex-end;justify-content:space-between;flex-wrap:wrap;gap:12px">
        <div>
          <div style="font-size:10px;letter-spacing:3px;text-transform:uppercase;color:var(--rust);margin-bottom:8px">Member Albums</div>
          <div style="font-family:var(--headline);font-size:clamp(22px,5vw,36px);color:#fff;letter-spacing:1px;line-height:1.1;word-break:break-word">Roads Travelled <span style="color:var(--amber)">by Our Riders</span></div>
          <div style="font-size:14px;color:rgba(255,255,255,.45);margin-top:10px;font-weight:300">Real trips. Real roads. Shared by the FreeWheel community.</div>
        </div>
        <a href="<?php echo esc_url(home_url('/register/')); ?>" style="display:inline-flex;align-items:center;gap:8px;padding:11px 22px;background:transparent;border:1px solid rgba(193,68,14,.5);color:var(--rust);text-decoration:none;font-family:var(--headline);font-size:13px;letter-spacing:1.5px;border-radius:2px;white-space:nowrap;transition:all .2s" onmouseover="this.style.background='rgba(193,68,14,.1)'" onmouseout="this.style.background='transparent'">JOIN &amp; SHARE YOURS →</a>
      </div>
    </div>

    <!-- Loading state -->
    <div id="albumCarouselWrap" style="position:relative">
      <div id="albumCarouselLoading" style="text-align:center;padding:40px;color:rgba(255,255,255,.3);font-size:12px;letter-spacing:2px;text-transform:uppercase">Loading albums...</div>

      <!-- Marquee track (populated by JS) -->
      <div id="albumMarquee" style="display:none;overflow:hidden;cursor:grab;user-select:none">
        <div id="albumMarqueeTrack" style="display:flex;gap:16px;width:max-content;will-change:transform"></div>
      </div>

      <!-- Fade edges -->
      <div style="position:absolute;top:0;left:0;width:80px;height:100%;background:linear-gradient(to right,#0a0805,transparent);pointer-events:none;z-index:2"></div>
      <div style="position:absolute;top:0;right:0;width:80px;height:100%;background:linear-gradient(to left,#0a0805,transparent);pointer-events:none;z-index:2"></div>
    </div>

    <div id="albumCarouselEmpty" style="display:none;text-align:center;padding:40px 24px">
      <div style="font-size:32px;margin-bottom:12px">📷</div>
      <div style="font-size:14px;color:rgba(255,255,255,.35);margin-bottom:8px">No public albums yet — be the first to share yours!</div>
      <div style="font-size:12px;color:rgba(255,255,255,.2)">Register, upload your trip album and tick 'Share publicly' to appear here.</div>
      <a href="<?php echo esc_url(home_url('/register/')); ?>" style="display:inline-block;margin-top:16px;padding:10px 22px;background:var(--rust);color:#fff;text-decoration:none;font-family:var(--headline);font-size:14px;letter-spacing:1px;border-radius:2px">Register &amp; Share</a>
    </div>
  </section>

  <style>
  #albumMarqueeTrack .alb-card{width:240px;flex-shrink:0;background:#0f0d0b;border:1px solid rgba(255,255,255,.08);border-radius:4px;overflow:hidden;transition:transform .3s ease,box-shadow .3s ease}
  #albumMarqueeTrack .alb-card:hover{transform:translateY(-4px);box-shadow:0 16px 40px rgba(0,0,0,.5)}
  #albumMarqueeTrack .alb-photos{display:grid;grid-template-columns:1fr 1fr 1fr;gap:2px;height:180px}
  #albumMarqueeTrack .alb-photos img{width:100%;height:100%;object-fit:cover;display:block}
  #albumMarqueeTrack .alb-photos .alb-photo-empty{background:rgba(255,255,255,.04)}
  #albumMarqueeTrack .alb-info{padding:14px 16px}
  #albumMarqueeTrack .alb-title{font-family:var(--headline);font-size:16px;color:#fff;letter-spacing:.5px;margin-bottom:4px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
  #albumMarqueeTrack .alb-meta{font-size:11px;color:rgba(255,255,255,.4);letter-spacing:.5px}
  </style>

  <script>
  (function() {
    var REST = (window.FW_AUTH && FW_AUTH.rest_url) || '/wp-json/freewheel/v1';
    var track, animId, paused = false, offset = 0, speed = 0.6;

    fetch(REST + '/fw-public-albums?limit=5')
      .then(function(r){ return r.json(); })
      .then(function(d){
        document.getElementById('albumCarouselLoading').style.display = 'none';
        if (!d.albums || !d.albums.length) {
          document.getElementById('albumCarouselEmpty').style.display = 'block';
          return;
        }
        buildCarousel(d.albums);
      })
      .catch(function(){
        document.getElementById('albumCarouselLoading').style.display = 'none';
        document.getElementById('albumCarouselEmpty').style.display = 'block';
      });

    function buildCarousel(albums) {
      track = document.getElementById('albumMarqueeTrack');
      var marquee = document.getElementById('albumMarquee');

      /* Build cards and duplicate for infinite loop */
      var cards = albums.map(makeCard).join('');
      track.innerHTML = cards + cards + cards; /* triple for seamless loop */

      marquee.style.display = 'block';

      /* Drag to pause */
      marquee.addEventListener('mouseenter', function(){ paused = true; });
      marquee.addEventListener('mouseleave', function(){ paused = false; });
      marquee.addEventListener('touchstart',  function(){ paused = true;  }, {passive:true});
      marquee.addEventListener('touchend',    function(){ paused = false; }, {passive:true});

      animate();
    }

    function makeCard(album) {
      var photos = album.photos || [];
      var photoSlots = '';
      for (var i = 0; i < 6; i++) {
        if (photos[i] && photos[i].photo_url) {
          photoSlots += '<img src="' + photos[i].photo_url + '" alt="' + (photos[i].caption||album.title) + '" loading="lazy">';
        } else {
          photoSlots += '<div class="alb-photo-empty"></div>';
        }
      }
      var firstName = (album.member_name || 'Explorer').split(' ')[0];
      var albumJson = encodeURIComponent(JSON.stringify({
        title: album.title,
        trip: album.trip_name || '',
        city: album.member_city || '',
        member: firstName,
        badge: album.member_badge || 'Explorer',
        instagram: album.member_instagram || '',
        photo: album.member_photo || '',
        photos: photos
      }));
      var avatarHtml = album.member_photo
        ? '<img src="' + album.member_photo + '" style="width:32px;height:32px;border-radius:50%;object-fit:cover;border:1.5px solid rgba(193,68,14,.5);display:block;flex-shrink:0">'
        : '<div style="width:32px;height:32px;border-radius:50%;background:rgba(193,68,14,.2);border:1.5px solid rgba(193,68,14,.4);display:flex;align-items:center;justify-content:center;font-size:13px;color:var(--rust);font-family:var(--headline);font-weight:700;flex-shrink:0">' + firstName.charAt(0).toUpperCase() + '</div>';
      return '<div class="alb-card" onclick="openAlbumLightbox(this)" data-album="' + albumJson + '" style="cursor:pointer">' +
        '<div class="alb-photos">' + photoSlots + '</div>' +
        '<div class="alb-info">' +
          '<div class="alb-title">' + album.title + '</div>' +
          '<div style="display:flex;align-items:flex-start;gap:10px;margin-top:10px">' +
            avatarHtml +
            '<div style="min-width:0;line-height:1.4">' +
              '<div style="display:flex;align-items:center;gap:6px;flex-wrap:wrap">' +
                '<span style="font-size:14px;color:#fff;font-weight:600">' + firstName + '</span>' +
                '<span style="font-size:9px;letter-spacing:1.5px;text-transform:uppercase;color:var(--amber)">' + (album.member_badge||'Explorer') + '</span>' +
              '</div>' +
              (album.member_city ? '<div style="font-size:11px;color:rgba(255,255,255,.4);margin-top:1px">' + album.member_city + '</div>' : '') +
              (album.member_instagram ? '<div style="margin-top:5px"><a href="https://instagram.com/' + album.member_instagram.replace(/^@/,'') + '" target="_blank" rel="noopener" onclick="event.stopPropagation()" style="font-size:13px;color:#c13584;text-decoration:none">&#128247; ' + album.member_instagram + '</a></div>' : '') +
            '</div>' +
          '</div>' +
        '</div>' +
      '</div>';
    }

    /* ── Album Lightbox ── */
    window.openAlbumLightbox = function(card) {
      var data = JSON.parse(decodeURIComponent(card.dataset.album));
      var overlay = document.getElementById('albumLightbox');
      if (!overlay) {
        overlay = document.createElement('div');
        overlay.id = 'albumLightbox';
        overlay.style.cssText = 'position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,.96);display:flex;flex-direction:column;align-items:center;justify-content:center;padding:20px;backdrop-filter:blur(8px)';
        overlay.onclick = function(e){ if(e.target===overlay) closeAlbumLightbox(); };
        document.body.appendChild(overlay);
      }

      var photos = data.photos.filter(function(p){ return p && p.photo_url; });
      var currentIdx = 0;

      function render() {
        var p = photos[currentIdx];
        overlay.innerHTML =
          '<button onclick="closeAlbumLightbox()" style="position:fixed;top:20px;right:20px;background:rgba(255,255,255,.1);border:none;color:#fff;width:40px;height:40px;border-radius:50%;font-size:20px;cursor:pointer;z-index:1">&#10005;</button>' +
          '<div style="max-width:900px;width:100%;text-align:center">' +
            '<div style="font-family:var(--headline);font-size:22px;color:#fff;margin-bottom:6px">' + data.title + '</div>' +
            '<div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;flex-wrap:wrap">' +
              (data.photo ? '<img src="' + data.photo + '" style="width:36px;height:36px;border-radius:50%;object-fit:cover;border:2px solid rgba(193,68,14,.4)">' : '<div style="width:36px;height:36px;border-radius:50%;background:rgba(193,68,14,.2);border:2px solid rgba(193,68,14,.4);display:flex;align-items:center;justify-content:center;font-size:14px;color:var(--rust);font-family:var(--headline);font-weight:700">' + (data.member||'?').charAt(0).toUpperCase() + '</div>') +
              '<div>' +
                '<div style="display:flex;align-items:center;gap:6px;flex-wrap:wrap">' +
                  '<span style="font-size:14px;color:#fff;font-weight:600">' + (data.member||'Explorer') + '</span>' +
                  '<span style="font-size:9px;letter-spacing:1.5px;text-transform:uppercase;color:var(--amber)">' + (data.badge||'Explorer') + '</span>' +
                '</div>' +
                '<div style="font-size:12px;color:rgba(255,255,255,.45);margin-top:2px">' + (data.city||'') + (data.city && data.trip ? ' · ' : '') + (data.trip ? '<span style="color:var(--rust)">' + data.trip + '</span>' : '') + '</div>' +
                (data.instagram ? '<div style="margin-top:4px"><a href="https://instagram.com/' + data.instagram.replace(/^@/,'') + '" target="_blank" rel="noopener" style="font-size:13px;color:#c13584;text-decoration:none">&#128247; ' + data.instagram + '</a></div>' : '') +
              '</div>' +
            '</div>' +
            '<div style="position:relative;display:inline-block;max-width:100%">' +
              (photos.length > 1 ? '<button onclick="lbPrev()" style="position:absolute;left:-50px;top:50%;transform:translateY(-50%);background:rgba(255,255,255,.1);border:none;color:#fff;width:40px;height:40px;border-radius:50%;font-size:20px;cursor:pointer">&#8249;</button>' : '') +
              '<img id="lbImg" src="' + p.photo_url + '" style="max-width:100%;max-height:70vh;object-fit:contain;border-radius:4px;display:block">' +
              (photos.length > 1 ? '<button onclick="lbNext()" style="position:absolute;right:-50px;top:50%;transform:translateY(-50%);background:rgba(255,255,255,.1);border:none;color:#fff;width:40px;height:40px;border-radius:50%;font-size:20px;cursor:pointer">&#8250;</button>' : '') +
            '</div>' +
            (p.caption ? '<div style="font-size:13px;color:rgba(255,255,255,.6);margin-top:12px">' + p.caption + '</div>' : '') +
            '<div style="font-size:11px;color:rgba(255,255,255,.3);margin-top:8px">' + (currentIdx+1) + ' / ' + photos.length + '</div>' +
            (photos.length > 1 ? '<div style="display:flex;gap:6px;justify-content:center;margin-top:16px">' +
              photos.map(function(ph,i){ return '<div onclick="lbGoto('+i+')" style="width:48px;height:48px;border-radius:2px;overflow:hidden;cursor:pointer;opacity:'+(i===currentIdx?'1':'.4')+';border:2px solid '+(i===currentIdx?'var(--rust)':'transparent')+'"><img src="'+ph.photo_url+'" style="width:100%;height:100%;object-fit:cover"></div>'; }).join('') +
            '</div>' : '') +
          '</div>';

        window.lbPrev = function(){ currentIdx = (currentIdx-1+photos.length)%photos.length; render(); };
        window.lbNext = function(){ currentIdx = (currentIdx+1)%photos.length; render(); };
        window.lbGoto = function(i){ currentIdx=i; render(); };
      }

      render();
      overlay.style.display = 'flex';
      document.body.style.overflow = 'hidden';
    };

    window.closeAlbumLightbox = function() {
      var ov = document.getElementById('albumLightbox');
      if (ov) { ov.style.display = 'none'; document.body.style.overflow = ''; }
    };
    document.addEventListener('keydown', function(e){
      if (e.key==='Escape') closeAlbumLightbox();
      if (e.key==='ArrowLeft' && window.lbPrev) lbPrev();
      if (e.key==='ArrowRight' && window.lbNext) lbNext();
    });

    function animate() {
      if (!paused) {
        offset += speed;
        /* Reset when first set of cards scrolled out */
        var singleSetWidth = track.scrollWidth / 3;
        if (offset >= singleSetWidth) offset = 0;
        track.style.transform = 'translateX(-' + offset + 'px)';
      }
      animId = requestAnimationFrame(animate);
    }
  })();
  </script>

    <!-- DUAL CTA CARDS -->
    <div style="display:flex;justify-content:center;gap:16px;max-width:700px;margin:0 auto;flex-wrap:wrap;padding:0 16px;box-sizing:border-box">

      <!-- Card 1: Subscribe -->
      <div style="flex:1;min-width:240px;background:linear-gradient(160deg,#1a0e08,#0f0d0b);padding:32px 28px;text-align:center;border-top:3px solid var(--rust)">
        <div style="font-size:42px;margin-bottom:12px">✉️</div>
        <div style="font-family:var(--headline);font-size:20px;color:#fff;letter-spacing:1px;margin-bottom:8px">Road Dispatch</div>
        <div style="font-size:12px;color:rgba(255,255,255,.45);font-weight:300;line-height:1.6;margin-bottom:20px">New routes, surprise slots & 5% member discount — delivered first</div>
        <button onclick="openSubModal()"
          style="display:block;width:100%;padding:13px 20px;background:var(--rust);color:#fff;border:none;font-family:var(--headline);font-size:17px;letter-spacing:1.5px;border-radius:2px;box-sizing:border-box;cursor:pointer;transition:background .2s"
          onmouseover="this.style.background='#a03508'" onmouseout="this.style.background='var(--rust)'">
          Subscribe & Unlock →
        </button>
        <div style="font-size:10px;color:rgba(255,255,255,.5);margin-top:10px;letter-spacing:1px">Free · 5% off from trip 2+</div>
      </div>

      <!-- Card 2: WhatsApp -->
      <div style="flex:1;min-width:240px;background:linear-gradient(160deg,#0a1a12,#0a0d0b);padding:32px 28px;text-align:center;border-top:3px solid #25d366">
        <div style="font-size:42px;margin-bottom:12px">💬</div>
        <div style="font-family:var(--headline);font-size:20px;color:#fff;letter-spacing:1px;margin-bottom:8px">Join WhatsApp</div>
        <div style="font-size:12px;color:rgba(255,255,255,.45);font-weight:300;line-height:1.6;margin-bottom:20px">Real-time updates, convoy support, road tips & fellow travellers</div>
        <a href="https://chat.whatsapp.com/IpVFxgBi7GG00yTmPhT6iP" target="_blank"
          style="display:block;width:100%;padding:13px 20px;background:#25d366;color:#fff;text-decoration:none;font-family:var(--headline);font-size:17px;letter-spacing:1.5px;border-radius:2px;box-sizing:border-box;transition:background .2s">
          Join Community →
        </a>
        <div style="font-size:10px;color:rgba(255,255,255,.5);margin-top:10px;letter-spacing:1px">Free · Open for all adventurers</div>
      </div>

    </div>


    <div style="font-size:12px;color:rgba(255,255,255,.5);margin-top:20px;letter-spacing:1px">Do both for the full experience</div>
  </div>
</section>

<!-- WHAT IS THE COMMUNITY -->
<section class="what-section">
  <div class="what-inner">
    <div class="what-text">
      <div class="sec-tag">What We Are</div>
      <h2>More Than a<br><em>Travel Group</em></h2>
      <p>FreeWheel Community is India's most active self-drive road trip tribe. Born on the mountain passes of Ladakh and Spiti, we are a group of real travellers who believe the road is best shared.</p>
      <p>Whether you are planning your first road trip or your fifteenth expedition, you will find experienced co-pilots, route advice, real emergency support, and lifelong friendships inside this community.</p>
      <p>Our WhatsApp group is where convoy announcements happen first, route updates get shared in real time, and every new member is welcomed like family.</p>
    </div>
    <div class="what-vis">
      <div class="comm-stats">
        <div class="cstat"><div class="cstat-n">500+</div><div class="cstat-l">Members</div></div>
        <div class="cstat"><div class="cstat-n">25+</div><div class="cstat-l">Expeditions</div></div>
        <div class="cstat"><div class="cstat-n">6</div><div class="cstat-l">States Covered</div></div>
        <div class="cstat"><div class="cstat-n">3L+</div><div class="cstat-l">Kms Driven</div></div>
      </div>
      <div style="margin-top:2px;background:#0a0805;padding:24px;border-left:3px solid var(--teal)">
        <div style="font-size:10px;letter-spacing:3px;text-transform:uppercase;color:rgba(255,255,255,.3);margin-bottom:8px">Active On</div>
        <div style="display:flex;gap:16px;flex-wrap:wrap">
          <a href="https://wa.me/917817838060" style="display:inline-flex;align-items:center;gap:6px;font-size:12px;letter-spacing:2px;text-transform:uppercase;color:#25d366;text-decoration:none" target="_blank">💬 WhatsApp</a>
          <a href="https://instagram.com/freewheelexpeditions" style="display:inline-flex;align-items:center;gap:6px;font-size:12px;letter-spacing:2px;text-transform:uppercase;color:#c13584;text-decoration:none" target="_blank">📸 Instagram</a>
          <a href="https://www.facebook.com/groups/freewheelexpeditions" style="display:inline-flex;align-items:center;gap:6px;font-size:12px;letter-spacing:2px;text-transform:uppercase;color:#1877f2;text-decoration:none" target="_blank">👥 Facebook</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- PERKS -->
<section class="perks-section">
  <div class="perks-inner">
    <div class="perks-heading">
      <div class="sec-tag">Why Join</div>
      <h2>Community Perks</h2>
    </div>
    <div class="perks-grid">
      <div class="perk"><span class="perk-icon">⚡</span><div class="perk-title">Early Access</div><div class="perk-desc">Community members get first-dibs on new expedition slots, often 7–14 days before public release.</div></div>
      <div class="perk"><span class="perk-icon">🗺️</span><div class="perk-title">Live Route Updates</div><div class="perk-desc">Real-time road conditions, weather alerts, and pass closure updates shared directly by our convoy leaders.</div></div>
      <div class="perk"><span class="perk-icon">🚨</span><div class="perk-title">Emergency Support</div><div class="perk-desc">Breakdown on a mountain pass? Your convoy and community have your back with on-ground support network.</div></div>
      <div class="perk"><span class="perk-icon">🤝</span><div class="perk-title">Find Co-Drivers</div><div class="perk-desc">Looking for a road buddy? The community is full of solo travellers who want to convoy together.</div></div>
      <div class="perk"><span class="perk-icon">🏷️</span><div class="perk-title">Member Discounts</div><div class="perk-desc">5% off from your second expedition onwards. Registered members also get exclusive merchandise pricing.</div></div>
      <div class="perk"><span class="perk-icon">📸</span><div class="perk-title">Photo & Memories</div><div class="perk-desc">Candid photos and drone footage from every expedition shared exclusively with community members first.</div></div>
    </div>
  </div>
</section>

<!-- TESTIMONIALS -->
<section class="testi-section">
  <div class="testi-inner">
    <div style="text-align:center;margin-bottom:0">
      <div style="font-size:11px;font-weight:600;letter-spacing:4px;text-transform:uppercase;color:var(--rust);margin-bottom:12px">Voices from the Road</div>
      <h2 style="font-family:var(--headline);font-size:clamp(34px,4vw,56px);color:#fff;letter-spacing:1px">What Members Say</h2>
    </div>
    <div class="testi-grid">
      <div class="testi-card">
        <div class="testi-quote">Joining the FreeWheel community was the best decision I made before my first solo road trip. The convoy system gave me confidence I'd never have had alone.</div>
        <div class="testi-name">Priya S.</div><div class="testi-trip">Winter Spiti 2026</div>
      </div>
      <div class="testi-card">
        <div class="testi-quote">The WhatsApp group is genuinely helpful — not just spam. Real updates, real people. Got breakdown help within 20 minutes at 14,000 feet.</div>
        <div class="testi-name">Rohit M.</div><div class="testi-trip">Dream Leh Ladakh 2025</div>
      </div>
      <div class="testi-card">
        <div class="testi-quote">I've done 4 trips with FreeWheel. The community is what keeps me coming back. These are my people — they understand why we drive.</div>
        <div class="testi-name">Ananya K.</div><div class="testi-trip">Nepal Odyssey 2026</div>
      </div>
    </div>
  </div>
</section>

<!-- BOTTOM CTA -->
<section class="comm-cta">
  <h2>Ready to Join the Tribe?</h2>
  <p>Over 500 road warriors are already inside. Your next expedition buddy might be one message away.</p>
  <div style="display:flex;gap:16px;justify-content:center;flex-wrap:wrap">
    <a href="https://chat.whatsapp.com/IpVFxgBi7GG00yTmPhT6iP" target="_blank"
      style="display:inline-flex;align-items:center;gap:10px;padding:16px 36px;background:#25d366;color:#fff;text-decoration:none;font-family:var(--headline);font-size:20px;letter-spacing:2px;border-radius:2px;transition:background .2s">
      💬 Join on WhatsApp
    </a>
    <button onclick="openSubModal()"
      style="display:inline-flex;align-items:center;gap:10px;padding:16px 36px;background:var(--rust);color:#fff;border:none;font-family:var(--headline);font-size:20px;letter-spacing:2px;border-radius:2px;cursor:pointer;transition:background .2s,transform .15s"
      onmouseover="this.style.background='#a03508';this.style.transform='translateY(-2px)'" onmouseout="this.style.background='var(--rust)';this.style.transform='none'">
      ✉️ Subscribe &amp; Unlock
    </button>
  </div>
  <div style="font-size:12px;color:rgba(255,255,255,.3);margin-top:20px;letter-spacing:1px">Both are free · No spam, ever</div>
</section>

<style>
@media(max-width:700px){
  /* Hero text */
  .ch-hero-content{padding:0 16px 40px!important}
  .ch-hero-content h1{font-size:clamp(32px,8vw,56px)!important;word-break:break-word}
  /* Album section heading */
  section div[style*="font-size:36px"]{font-size:24px!important}
  section div[style*="max-width:1200px"]{padding:0 16px!important}
  /* Dual CTA - stack vertically */
  div[style*="display:flex;justify-content:center;gap:16px"]{flex-direction:column!important;padding:0 16px!important}
  div[style*="flex:1;min-width:240px"]{min-width:unset!important;width:100%!important}
  /* Album carousel card size */
  #albumMarqueeTrack .alb-card{width:200px!important}
  #albumMarqueeTrack .alb-photos{height:130px!important}
  /* Community stats */
  .comm-stats{grid-template-columns:1fr 1fr!important}
  /* General overflow fix */
  .ch-content{overflow-x:hidden!important}
  /* Perks and testimonials */
  .perks-grid,.testi-grid{grid-template-columns:1fr!important}
}
@media(max-width:540px){
  .ch-content > div[style*="grid-template-columns:1fr 1fr"]{grid-template-columns:1fr!important}
  .comm-cta > div[style*="flex"]{flex-direction:column;align-items:center}
}
</style>


<script>
function toggleMenu(){var m=document.getElementById('mobileMenu'),b=document.getElementById('hbBtn');m.classList.toggle('open');b.classList.toggle('open');document.body.style.overflow=m.classList.contains('open')?'hidden':'';}
function closeMenu(){var m=document.getElementById('mobileMenu');if(m)m.classList.remove('open');document.body.style.overflow='';}
</script>


<!-- SUBSCRIPTION MODAL -->
<div id="subOverlay" onclick="if(event.target===this)closeSubModal()" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.75);z-index:9999;align-items:center;justify-content:center;padding:20px;box-sizing:border-box">
  <div style="background:#1a1208;border:1px solid rgba(255,255,255,.12);border-top:3px solid var(--rust,#c1440e);border-radius:4px;width:100%;max-width:440px;padding:36px 32px;position:relative">
    <button onclick="closeSubModal()" style="position:absolute;top:14px;right:16px;background:none;border:none;color:rgba(255,255,255,.4);font-size:22px;cursor:pointer;line-height:1">×</button>
    <div style="font-size:32px;margin-bottom:10px;text-align:center">🏔️</div>
    <h3 style="font-family:var(--headline,'sans-serif');font-size:22px;color:#fff;letter-spacing:1.5px;text-align:center;margin:0 0 6px">MEMBERSHIP PERKS</h3>
    <p style="font-size:12px;color:rgba(255,255,255,.45);text-align:center;margin:0 0 24px;line-height:1.6">Subscribe for exclusive discounts, early access & road dispatches. We'll verify your email with a quick OTP.</p>
    <div style="display:flex;flex-direction:column;gap:12px">
      <input id="subName" type="text" placeholder="Your Name" style="padding:12px 14px;background:rgba(0,0,0,.4);border:1px solid rgba(255,255,255,.18);color:#fff;font-size:14px;border-radius:2px;outline:none;font-family:inherit;transition:border-color .2s" onfocus="this.style.borderColor='rgba(193,68,14,.7)'" onblur="this.style.borderColor='rgba(255,255,255,.18)'">
      <input id="subPhone" type="tel" placeholder="Mobile Number" style="padding:12px 14px;background:rgba(0,0,0,.4);border:1px solid rgba(255,255,255,.18);color:#fff;font-size:14px;border-radius:2px;outline:none;font-family:inherit;transition:border-color .2s" onfocus="this.style.borderColor='rgba(193,68,14,.7)'" onblur="this.style.borderColor='rgba(255,255,255,.18)'">
      <input id="subEmail" type="email" placeholder="Email Address" style="padding:12px 14px;background:rgba(0,0,0,.4);border:1px solid rgba(255,255,255,.18);color:#fff;font-size:14px;border-radius:2px;outline:none;font-family:inherit;transition:border-color .2s" onfocus="this.style.borderColor='rgba(193,68,14,.7)'" onblur="this.style.borderColor='rgba(255,255,255,.18)'">
    </div>
    <div id="subMsg" style="font-size:12px;margin-top:10px;padding:8px 12px;border-radius:2px;display:none"></div>
    <button id="subBtn" onclick="handleCommunitySubscribe()" style="width:100%;margin-top:18px;padding:14px;background:var(--rust,#c1440e);border:none;color:#fff;font-family:var(--headline,'sans-serif');font-size:18px;letter-spacing:2px;cursor:pointer;border-radius:2px;transition:background .2s">
      SUBSCRIBE NOW →
    </button>
    <p style="font-size:10px;color:rgba(255,255,255,.5);text-align:center;margin:12px 0 0;letter-spacing:1px">No spam · Unsubscribe anytime · Email OTP verification</p>
  </div>
</div>

<script>
function openSubModal(){
  var o=document.getElementById('subOverlay');
  var msg=document.getElementById('subMsg');
  var btn=document.getElementById('subBtn');
  if(msg){msg.style.display='none';msg.textContent='';}
  if(btn){btn.disabled=false;btn.textContent='SUBSCRIBE NOW \u2192';}
  o.style.display='flex';
  document.body.style.overflow='hidden';
}
function closeSubModal(){
  document.getElementById('subOverlay').style.display='none';
  document.body.style.overflow='';
}
async function handleCommunitySubscribe(){
  var name  = (document.getElementById('subName')||{}).value||'';
  var phone = (document.getElementById('subPhone')||{}).value||'';
  var email = (document.getElementById('subEmail')||{}).value||'';
  var msg   = document.getElementById('subMsg');
  var btn   = document.getElementById('subBtn');
  /* Community requires a valid phone number */
  if(!phone.trim()||phone.replace(/\D/g,'').length<10){
    if(msg){msg.textContent='Please enter a valid 10-digit mobile number.';msg.style.color='#f87171';msg.style.background='rgba(255,0,0,.1)';msg.style.display='block';}
    return;
  }
  if(msg){msg.style.display='none';msg.textContent='';}
  closeSubModal();
  /* Delegate all further logic (name/email validation, fetch, _fwSubPending,
     fwOtpOpen) to the shared fwSendOtp() defined in fw-scripts.js */
  if(typeof fwSendOtp==='function'){
    await fwSendOtp(name, email, phone, 'community', msg, btn);
    if(msg&&msg.textContent)msg.style.display='block';
  }
}
document.addEventListener('keydown',function(e){if(e.key==='Escape')closeSubModal();});
</script>

<?php get_footer(); ?>
