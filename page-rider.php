<?php
/**
 * Template Name: Rider Profile
 * Template Post Type: page
 */
get_header(); ?>
<style>
html,body,body.page,#page,#content,#primary,#main,.site,.site-content,.entry-content,.wp-site-blocks,main,article{background:#0a0805!important;background-color:#0a0805!important;color:#fff!important}
.entry-content,.page-content,#primary,#main,main{padding:0!important;margin:0!important;max-width:100%!important;width:100%!important}
.site-header,.wp-block-template-part[class*="header"]{display:none!important}

.rider-wrap{max-width:900px;margin:0 auto;padding:60px 5vw 80px}
.rider-loading{text-align:center;padding:120px 0;color:rgba(255,255,255,.35);font-size:14px}
.rider-head{display:flex;align-items:center;gap:22px;flex-wrap:wrap;padding-bottom:28px;border-bottom:1px solid rgba(255,255,255,.08);margin-bottom:32px}
.rider-avatar{width:88px;height:88px;border-radius:50%;object-fit:cover;border:3px solid rgba(193,68,14,.4);flex-shrink:0}
.rider-avatar-fallback{width:88px;height:88px;border-radius:50%;background:rgba(193,68,14,.18);border:3px solid rgba(193,68,14,.4);display:flex;align-items:center;justify-content:center;font-family:var(--headline);font-size:34px;color:var(--rust);flex-shrink:0}
.rider-name{font-family:var(--headline);font-size:30px;color:#fff;letter-spacing:1px;line-height:1.1}
.rider-number{font-size:12px;letter-spacing:2px;color:var(--rust);margin-top:4px}
.rider-meta{display:flex;gap:14px;flex-wrap:wrap;margin-top:8px;font-size:13px;color:rgba(255,255,255,.4)}
.rider-badge{display:inline-block;margin-top:10px;padding:5px 14px;background:rgba(232,160,32,.12);border:1px solid rgba(232,160,32,.35);color:var(--amber);font-family:var(--headline);font-size:13px;letter-spacing:1.5px;border-radius:2px}
.rider-insta{display:inline-flex;align-items:center;gap:5px;color:#c13584;text-decoration:none;font-size:13px;margin-top:10px}
.rider-section-title{font-family:var(--headline);font-size:18px;color:#fff;letter-spacing:1px;margin:0 0 16px;display:flex;align-items:center;gap:10px}
.rider-section-title span{font-size:11px;color:rgba(255,255,255,.3);font-family:var(--body);letter-spacing:0;font-weight:400}
.rider-albums-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:16px;margin-bottom:48px}
.rider-album-card{background:#0f0d0b;border:1px solid rgba(255,255,255,.08);border-radius:3px;overflow:hidden}
.rider-album-photos{display:grid;grid-template-columns:repeat(3,1fr);gap:2px}
.rider-album-photos img{width:100%;aspect-ratio:1;object-fit:cover;display:block}
.rider-album-title{padding:12px 14px;font-size:13px;color:#fff}
.rider-blog-row{display:flex;align-items:center;gap:14px;padding:14px;background:#0f0d0b;border:1px solid rgba(255,255,255,.08);border-radius:3px;margin-bottom:10px}
.rider-blog-cover{width:56px;height:56px;border-radius:2px;object-fit:cover;flex-shrink:0;background:rgba(255,255,255,.05)}
.rider-empty{color:rgba(255,255,255,.3);font-size:13px;padding:20px 0}
.rider-not-found{text-align:center;padding:120px 20px}
.rider-not-found h2{font-family:var(--headline);color:#fff;font-size:24px;margin-bottom:10px}
.rider-not-found p{color:rgba(255,255,255,.4);font-size:14px}
</style>

<div class="rider-wrap">
  <div id="riderLoading" class="rider-loading">Loading rider profile…</div>
  <div id="riderContent" style="display:none">
    <div class="rider-head">
      <div id="riderAvatarWrap"></div>
      <div>
        <div class="rider-name" id="riderName">—</div>
        <div class="rider-number" id="riderNumber"></div>
        <div class="rider-meta" id="riderMeta"></div>
        <div id="riderBadgeWrap"></div>
        <div id="riderInstaWrap"></div>
      </div>
    </div>

    <div class="rider-section-title">Trip Albums <span id="riderAlbumCount"></span></div>
    <div id="riderAlbums" class="rider-albums-grid"></div>

    <div class="rider-section-title">Road Stories <span id="riderBlogCount"></span></div>
    <div id="riderBlogs"></div>
  </div>
  <div id="riderNotFound" class="rider-not-found" style="display:none">
    <h2>Rider Not Found</h2>
    <p>This member profile doesn't exist or hasn't completed registration yet.</p>
  </div>
</div>

<script>
(function() {
  var REST = (window.FW_AUTH && FW_AUTH.rest_url) || '/wp-json/freewheel/v1';
  var params = new URLSearchParams(window.location.search);
  var num = params.get('n');

  if (!num) {
    document.getElementById('riderLoading').style.display = 'none';
    document.getElementById('riderNotFound').style.display = 'block';
    return;
  }

  fetch(REST + '/fw-public-profile?n=' + encodeURIComponent(num))
    .then(function(r) { if (!r.ok) throw new Error('not found'); return r.json(); })
    .then(function(d) {
      if (!d.success) throw new Error('not found');
      render(d);
    })
    .catch(function() {
      document.getElementById('riderLoading').style.display = 'none';
      document.getElementById('riderNotFound').style.display = 'block';
    });

  function render(d) {
    var p = d.profile || {};
    var tier = d.tier || { name: 'Explorer' };
    var firstName = (p.first_name || 'Rider').toUpperCase();

    document.title = firstName + ' — WHEELER #' + String(p.member_number).padStart(4,'0') + ' | FreeWheel Expeditions';

    document.getElementById('riderName').textContent = firstName;
    document.getElementById('riderNumber').textContent = 'WHEELER #' + String(p.member_number||0).padStart(4,'0');

    var avWrap = document.getElementById('riderAvatarWrap');
    avWrap.innerHTML = p.avatar_url
      ? '<img class="rider-avatar" src="' + p.avatar_url + '">'
      : '<div class="rider-avatar-fallback">' + firstName.charAt(0) + '</div>';

    var metaParts = [];
    if (p.city) metaParts.push(p.city + (p.state ? ', ' + p.state : ''));
    if (p.created_at) metaParts.push('Riding since ' + new Date(p.created_at).toLocaleDateString('en-IN', {month:'long', year:'numeric'}));
    metaParts.push((p.trips_completed||0) + ' trip' + ((p.trips_completed||0)===1?'':'s') + ' completed');
    document.getElementById('riderMeta').textContent = metaParts.join(' · ');

    document.getElementById('riderBadgeWrap').innerHTML = '<span class="rider-badge">' + (tier.name||'Explorer').toUpperCase() + '</span>';

    if (p.instagram) {
      document.getElementById('riderInstaWrap').innerHTML = '<br><a class="rider-insta" href="https://instagram.com/' + p.instagram.replace(/^@/,'') + '" target="_blank" rel="noopener">&#128247; ' + p.instagram + '</a>';
    }

    /* Albums */
    var albums = d.albums || [];
    document.getElementById('riderAlbumCount').textContent = albums.length ? '(' + albums.length + ')' : '';
    var albEl = document.getElementById('riderAlbums');
    if (!albums.length) {
      albEl.innerHTML = '<div class="rider-empty">No public albums yet.</div>';
    } else {
      albEl.innerHTML = albums.map(function(a) {
        var photos = (a.photos || []).slice(0, 3);
        var photoHtml = photos.map(function(p){ return '<img src="' + p.url + '">'; }).join('');
        return '<div class="rider-album-card"><div class="rider-album-photos">' + photoHtml + '</div><div class="rider-album-title">' + a.title + '</div></div>';
      }).join('');
    }

    /* Blogs */
    var blogs = d.blogs || [];
    document.getElementById('riderBlogCount').textContent = blogs.length ? '(' + blogs.length + ')' : '';
    var blogEl = document.getElementById('riderBlogs');
    if (!blogs.length) {
      blogEl.innerHTML = '<div class="rider-empty">No published stories yet.</div>';
    } else {
      blogEl.innerHTML = blogs.map(function(b) {
        var cover = b.cover_image ? '<img class="rider-blog-cover" src="' + b.cover_image + '">' : '<div class="rider-blog-cover"></div>';
        return '<div class="rider-blog-row">' + cover + '<div><div style="color:#fff;font-size:14px">' + b.title + '</div><div style="color:rgba(255,255,255,.35);font-size:11px;margin-top:3px">' + new Date(b.created_at).toLocaleDateString('en-IN',{day:'numeric',month:'short',year:'numeric'}) + '</div></div></div>';
      }).join('');
    }

    document.getElementById('riderLoading').style.display = 'none';
    document.getElementById('riderContent').style.display = 'block';
  }
})();
</script>

<?php get_footer(); ?>
