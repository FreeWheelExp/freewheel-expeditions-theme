<?php
/**
 * FreeWheel Expeditions — Single Expedition Template
 * Dynamically pulls all data from WordPress admin
 */
get_header();

// Start WordPress loop — required for get_the_ID(), get_the_title() etc.
if (have_posts()) { the_post(); }

$id         = get_the_ID();
$title      = html_entity_decode(get_the_title(), ENT_HTML5, 'UTF-8');
$m          = function($k) use ($id) { return get_post_meta($id, $k, true); };
$thumb      = get_the_post_thumbnail_url($id, 'full');
$dates      = $m('fw_dates');
$month      = $m('fw_month') ?: $m('fw_dates');
// Convert display month/date to ISO 8601 for schema — uses 1st of month if no exact date
$start_ts        = strtotime($month);
$start_date_iso  = $start_ts ? date('Y-m-d', $start_ts) : date('Y-m-d');
// Calculate end date from duration (e.g. "15 Nights / 16 Days" → 16 days)
preg_match('/(\d+)\s*Day/i', $duration, $dur_match);
$dur_days        = isset($dur_match[1]) ? (int)$dur_match[1] : 0;
$end_date_iso    = $dur_days ? date('Y-m-d', strtotime("+{$dur_days} days", $start_ts)) : '';
$duration   = $m('fw_duration');
$dest       = $m('fw_destination');
$region     = $m('fw_region');
$difficulty = $m('fw_difficulty');
$subtitle   = $m('fw_subtitle');
$overview   = $m('fw_overview');
$price      = (int)$m('fw_price');
$unit       = $m('fw_price_unit') ?: 'per person';
$cp         = (int)$m('fw_couple_price');
$sp         = (int)$m('fw_seat_price');
$cancellation = array_filter(array_map('trim', explode("\n", $m('fw_cancellation'))));
$things_carry = array_filter(array_map('trim', explode("\n", $m('fw_things_carry'))));
/* slot tracking removed — managed via WhatsApp */
$wa_num_raw  = $m('fw_whatsapp');
$wa_num      = ($wa_num_raw && $wa_num_raw !== '919999999999') ? $wa_num_raw : '917817838060';
$badge      = $m('fw_badge');
$highlights = array_filter(array_map('trim', explode("\n", $m('fw_highlights'))));
$inclusions = array_filter(array_map('trim', explode("\n", $m('fw_inclusions'))));
$exclusions = array_filter(array_map('trim', explode("\n", $m('fw_exclusions'))));
$itinerary  = $m('fw_itinerary') ? json_decode($m('fw_itinerary'), true) : array();
$gallery_raw= $m('fw_gallery');
$gallery    = $gallery_raw ? json_decode($gallery_raw, true) : array();
if (!is_array($gallery)) $gallery = array();
$wa_msg     = urlencode('Hi! I want to book the ' . $title . ' expedition. Dates: ' . $dates);

// ── Schema: Event + TouristTrip ──────────────────────────────────
$schema_exp = [
    "@context" => "https://schema.org",
    "@graph"   => [
        [
            "@type"       => "Event",
            "@id"         => get_permalink() . "#event",
            "name"        => $title,
            "description" => $overview ?: ('Self-drive expedition: ' . $title . '. ' . ($dates ? 'Dates: ' . $dates . '.' : '')),
            "url"         => get_permalink(),
            "image"       => $thumb ?: get_template_directory_uri() . '/images/front-page-1.png',
            "startDate"   => $start_date_iso,
            "endDate"     => $end_date_iso ?: null,
            "performer"   => [
                "@type" => "Organization",
                "name"  => "FreeWheel Expeditions",
                "url"   => home_url('/')
            ],
			            "location"    => [
                "@type"   => "Place",
                "name"    => $dest ?: $region ?: 'India',
                "address" => [
                    "@type"          => "PostalAddress",
                    "addressCountry" => "IN",
                    "addressRegion"  => $region ?: $dest ?: 'Uttarakhand'
                ]
            ],
            "organizer"   => [
                "@type" => "Organization",
                "name"  => "FreeWheel Expeditions",
                "url"   => home_url('/')
            ],
            "offers"      => $price ? [
                "@type"         => "Offer",
                "price"         => $price,
                "priceCurrency" => "INR",
                "availability"  => "https://schema.org/InStock",
                "url"           => get_permalink(),
                "validFrom"     => date('Y-m-d')
            ] : null,
            "eventStatus"         => "https://schema.org/EventScheduled",
            "eventAttendanceMode" => "https://schema.org/OfflineEventAttendanceMode"
        ],
        [
            "@type"       => "Product",
            "@id"         => get_permalink() . "#product",
            "name"        => $title,
            "description" => $overview ?: ('Self-drive expedition: ' . $title),
            "url"         => get_permalink(),
            "image"       => $thumb ?: get_template_directory_uri() . '/images/front-page-1.png',
            "brand"       => ["@type" => "Brand", "name" => "FreeWheel Expeditions"],
            "category"    => "Adventure Travel / Self-Drive Expeditions",
            "offers"      => $price ? [
                "@type"         => "Offer",
                "price"         => $price,
                "priceCurrency" => "INR",
                "availability"  => "https://schema.org/InStock",
                "url"           => get_permalink()
            ] : null
        ]
    ]
];
// Remove null offers
foreach ($schema_exp['@graph'] as &$node) {
    if (isset($node['offers']) && $node['offers'] === null) unset($node['offers']);
}
unset($node);
echo '<script type="application/ld+json">' . json_encode($schema_exp, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . '</script>' . "
";


?>
<style>
/* ── EXPEDITION DETAIL PAGE ── */
.exp-hero{position:relative;height:65vh;min-height:380px;overflow:hidden;display:flex;align-items:flex-end;background:#0f0d0b}
.exp-hero-img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;object-position:center;opacity:.55}
.exp-hero-grad{position:absolute;inset:0;background:linear-gradient(to top,rgba(15,13,11,.95) 0%,rgba(15,13,11,.3) 60%,transparent 100%)}
.exp-hero-content{position:relative;z-index:2;padding:40px 5vw;width:100%}
.exp-eyebrow{font-size:11px;letter-spacing:3px;text-transform:uppercase;color:var(--amber);margin-bottom:10px}
.exp-h1{font-family:var(--headline);font-size:clamp(40px,6vw,72px);color:#fff;line-height:.95;letter-spacing:1px;margin-bottom:14px}
.exp-meta-row{display:flex;gap:16px;flex-wrap:wrap;align-items:center}
.exp-meta-tag{padding:5px 14px;border:1px solid rgba(255,255,255,.2);font-size:11px;letter-spacing:2px;text-transform:uppercase;color:rgba(255,255,255,.7)}
.exp-layout{display:grid;grid-template-columns:1fr 340px;gap:40px;padding:48px 5vw;max-width:1400px;margin:0 auto}
.exp-main{}
.exp-section{margin-bottom:40px}
.exp-section-title{font-family:var(--headline);font-size:26px;letter-spacing:2px;color:#fff;margin-bottom:18px;padding-bottom:8px;border-bottom:2px solid var(--rust)}
.overview-text{font-size:15px;line-height:1.8;color:rgba(255,255,255,.75);font-weight:300}
.highlights-grid{display:flex;flex-direction:column;gap:8px}
.highlight-item{background:rgba(193,68,14,.08);border-left:3px solid var(--rust);padding:12px 16px;font-size:14px;color:rgba(255,255,255,.8);display:flex;align-items:center;gap:10px;font-weight:300;line-height:1.5}
.day-row{display:grid;grid-template-columns:140px 1fr;gap:0;margin-bottom:0}
.day-label{background:rgba(193,68,14,.25);border-left:3px solid var(--rust);padding:16px 18px;font-family:var(--headline);font-size:15px;letter-spacing:1px;color:var(--amber);display:flex;align-items:flex-start}
.day-content{background:rgba(255,255,255,.04);padding:16px 20px;border-bottom:1px solid rgba(255,255,255,.06)}
.day-title{font-size:14px;font-weight:600;color:#fff;margin-bottom:4px}
.day-text{font-size:13px;color:rgba(255,255,255,.65);line-height:1.6;font-weight:300}
.inc-exc-grid{display:grid;grid-template-columns:1fr 1fr;gap:20px}
.inc-list,.exc-list{list-style:none;padding:0;margin:0}
.inc-list li,.exc-list li{padding:8px 0;border-bottom:1px solid rgba(255,255,255,.06);font-size:13px;color:rgba(255,255,255,.7);display:flex;gap:8px}
.inc-list li::before{content:"✅";flex-shrink:0}
.exc-list li::before{content:"❌";flex-shrink:0}
/* Expedition Package tabs */
.pkg-tabs{display:flex;gap:1px;background:rgba(212,184,150,.3);margin-bottom:0}
.ie-tab{flex:1;padding:13px 12px;text-align:center;font-size:11px;letter-spacing:2px;text-transform:uppercase;font-weight:600;background:rgba(212,184,150,.1);color:rgba(255,255,255,.4);cursor:pointer;transition:all .2s;border:none}
.ie-tab.active{background:var(--ink);color:#fff}
.pkg-content{background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.08);padding:24px}
.pkg-panel{display:none}.pkg-panel.visible{display:block}
.ie-list{list-style:none;padding:0;margin:0}
.ie-list li{padding:9px 0;border-bottom:1px solid rgba(255,255,255,.07);font-size:14px;font-weight:300;color:rgba(255,255,255,.75);display:flex;align-items:flex-start;gap:10px;line-height:1.6}
.ie-list li::before{content:'✓';color:var(--teal);font-weight:700;flex-shrink:0}
.ie-list.exc li::before{content:'✗';color:var(--rust)}
.ie-list.can li::before{content:'⚠';color:var(--amber)}
/* Things to carry */
.carry-section{background:var(--ink);padding:60px 5vw}
.carry-inner{max-width:1400px;margin:0 auto}
.carry-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:1px;margin-top:28px;background:rgba(255,255,255,.06)}
.carry-item{background:#1a1410;padding:16px 20px;font-size:14px;font-weight:300;color:rgba(255,255,255,.7);display:flex;align-items:flex-start;gap:10px;line-height:1.6}
.carry-item::before{content:'→';color:var(--amber);flex-shrink:0;font-weight:600}
/* Ready to Drive */
.rtd-section{background:var(--rust);padding:70px 5vw;text-align:center}
.rtd-h{font-family:var(--headline);font-size:clamp(32px,4vw,56px);color:#fff;letter-spacing:2px;margin-bottom:16px}
.rtd-sub{font-size:15px;font-weight:300;color:rgba(255,255,255,.8);margin-bottom:32px}
.rtd-btns{display:flex;gap:16px;justify-content:center;flex-wrap:wrap}
.rtd-contact{margin-top:20px;font-size:13px;color:rgba(255,255,255,.7);font-weight:300}
.btn-solid{display:inline-block;padding:13px 34px;background:var(--rust);color:#fff;text-decoration:none;font-family:var(--headline);font-size:18px;letter-spacing:2px;border:none;cursor:pointer;transition:background .2s,transform .15s;border-radius:2px}
.btn-solid:hover{background:#a03508;transform:translateY(-2px)}
.btn-ghost{display:inline-block;padding:12px 34px;border:2px solid rgba(255,255,255,.3);color:#fff;text-decoration:none;font-family:var(--headline);font-size:18px;letter-spacing:2px;cursor:pointer;transition:border-color .2s,transform .15s;background:transparent;border-radius:2px}
.btn-ghost:hover{border-color:var(--amber);color:var(--amber);transform:translateY(-2px)}
/* Sidebar */
.exp-sidebar{align-self:start}
.pay-panel{background:var(--ink);border-top:4px solid var(--rust);margin-bottom:0}
.pay-header{padding:22px 24px 16px;border-bottom:1px solid rgba(255,255,255,.08)}
.pay-header-title{font-family:var(--headline);font-size:28px;color:#fff;letter-spacing:1px;margin-bottom:2px}
.pay-header-dates{font-size:11px;color:rgba(255,255,255,.35);letter-spacing:2px;text-transform:uppercase}
.price-strip{display:flex;flex-wrap:wrap;gap:1px;background:rgba(255,255,255,.07);margin:0}
.ps-item{flex:1;min-width:100px;padding:14px 18px;background:#0f0d0b}
.ps-label{font-size:9px;letter-spacing:3px;text-transform:uppercase;color:rgba(255,255,255,.3);margin-bottom:4px}
.ps-val{font-family:var(--headline);font-size:20px;color:#fff;letter-spacing:1px}
.ps-note{font-size:10px;color:rgba(255,255,255,.25);font-weight:300;margin-top:2px}
.pay-tabs{display:flex;gap:1px;background:rgba(255,255,255,.07)}
.ptab{flex:1;padding:13px 10px;text-align:center;font-size:11px;font-weight:600;letter-spacing:2px;text-transform:uppercase;background:#0a0805;color:rgba(255,255,255,.35);cursor:pointer;transition:all .2s;border:none}
.ptab.active{background:var(--rust);color:#fff}
.pay-body{padding:20px 24px 24px}
.pmethod{display:none}.pmethod.visible{display:block}
.upi-block{background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.08);border-left:3px solid var(--amber);padding:18px;margin-bottom:14px}
.upi-row{display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap}
.upi-info .upi-label{font-size:9px;letter-spacing:3px;text-transform:uppercase;color:rgba(255,255,255,.3);margin-bottom:6px}
.upi-id-display{font-family:monospace;font-size:14px;font-weight:700;color:var(--amber);letter-spacing:0px;word-break:break-all;line-height:1.4}
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
.wa-confirm-btn{display:flex;align-items:center;justify-content:center;gap:8px;width:100%;margin-top:14px;margin-bottom:4px;padding:14px;background:#25d366;color:#fff;border:none;font-family:var(--headline);font-size:18px;letter-spacing:2px;cursor:pointer;transition:background .2s;border-radius:2px;text-decoration:none}
.wa-confirm-btn:hover{background:#1da851}

.book-btn{display:block;width:100%;padding:16px;background:var(--rust);color:#fff;font-family:var(--headline);font-size:20px;letter-spacing:2px;text-align:center;text-decoration:none;border:none;cursor:pointer;transition:background .2s;margin-top:16px}
.book-btn:hover{background:#a03a0c}
.book-btn.soldout{background:#555;pointer-events:none}
/* Gallery */
.exp-gallery{padding:48px 5vw;background:rgba(0,0,0,.3)}
.exp-gal-title{font-family:var(--headline);font-size:32px;color:#fff;letter-spacing:2px;margin-bottom:6px}
.exp-gal-sub{font-size:12px;color:rgba(255,255,255,.4);letter-spacing:2px;text-transform:uppercase;margin-bottom:20px}
.exp-gal-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:8px}
.exp-gal-item{position:relative;aspect-ratio:16/9;overflow:hidden;cursor:pointer;background:#1a1410}
.exp-gal-item img{width:100%;height:100%;object-fit:cover;transition:transform .4s}
.exp-gal-item:hover img{transform:scale(1.05)}
.exp-gal-item-overlay{position:absolute;inset:0;background:rgba(193,68,14,0);display:flex;align-items:center;justify-content:center;font-size:24px;opacity:0;transition:all .3s}
.exp-gal-item:hover .exp-gal-item-overlay{background:rgba(193,68,14,.3);opacity:1}
/* Lightbox */
.exp-lightbox{position:fixed;inset:0;z-index:2000;background:rgba(0,0,0,.95);display:none;align-items:center;justify-content:center}
.exp-lightbox.open{display:flex}
.exp-lb-img{max-width:90vw;max-height:85vh;object-fit:contain}
.exp-lb-close{position:absolute;top:20px;right:24px;background:none;border:none;color:#fff;font-size:32px;cursor:pointer;opacity:.7}
.exp-lb-close:hover{opacity:1}
.exp-lb-prev,.exp-lb-next{position:absolute;top:50%;transform:translateY(-50%);background:rgba(255,255,255,.1);border:none;color:#fff;font-size:24px;cursor:pointer;width:50px;height:50px;display:flex;align-items:center;justify-content:center;transition:background .2s}
.exp-lb-prev{left:16px}.exp-lb-next{right:16px}
.exp-lb-prev:hover,.exp-lb-next:hover{background:var(--rust)}
.exp-lb-counter{position:absolute;bottom:20px;left:50%;transform:translateX(-50%);font-size:12px;letter-spacing:2px;color:rgba(255,255,255,.5);text-transform:uppercase}
@media(max-width:900px){
  .exp-layout{grid-template-columns:1fr;padding:32px 5vw}
  .pay-panel{position:static}
  .exp-gal-grid{grid-template-columns:repeat(2,1fr)}
  .day-row{grid-template-columns:1fr}
  .inc-exc-grid{grid-template-columns:1fr}
  /* Sidebar stacks below main on mobile — add bottom padding so sticky bar doesn't cover it */
  .exp-sidebar{padding-bottom:90px}
}
@media(max-width:600px){.exp-gal-grid{grid-template-columns:1fr}}

/* ── MOBILE STICKY BOOKING BAR ── */
/* Only the Book/WhatsApp actions — subscribe form stays in the sidebar below */
.mob-book-bar{
  display:none;
  position:fixed;bottom:0;left:0;right:0;z-index:999;
  background:rgba(15,13,11,.97);border-top:3px solid var(--rust);
  padding:10px 16px 12px;
  flex-direction:row;gap:8px;
  backdrop-filter:blur(6px);
}
.mob-book-bar a{
  flex:1;display:flex;align-items:center;justify-content:center;gap:6px;
  padding:13px 10px;text-decoration:none;
  font-family:var(--headline);font-size:13px;letter-spacing:1.5px;text-transform:uppercase;
  border-radius:2px;
}
@media(max-width:900px){.mob-book-bar{display:flex}}

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

<!-- HERO -->
<div class="exp-hero">
  <?php if($thumb): ?>
  <img src="<?php echo esc_url($thumb); ?>" alt="<?php echo esc_attr($title); ?>" class="exp-hero-img">
  <?php endif; ?>
  <div class="exp-hero-grad"></div>
  <div class="exp-hero-content">
    <div class="exp-eyebrow"><?php echo esc_html($dates); ?></div>
    <h1 class="exp-h1"><?php echo esc_html($title); ?></h1>
    <div class="exp-meta-row">
      <?php if($duration): ?><span class="exp-meta-tag">⏱ <?php echo esc_html($duration); ?></span><?php endif; ?>
      <?php if($dest):     ?><span class="exp-meta-tag">📍 <?php echo esc_html($dest); ?></span><?php endif; ?>
      <span class="exp-meta-tag">🚙 Self Drive</span>
      <?php if($difficulty): ?><span class="exp-meta-tag">⚡ <?php echo esc_html($difficulty); ?></span><?php endif; ?>
      <?php if($badge): ?><span class="exp-meta-tag" style="background:var(--rust);border-color:var(--rust);color:#fff"><?php echo esc_html($badge); ?></span><?php endif; ?>
    </div>
  </div>
</div>

<!-- MAIN LAYOUT -->
<div class="exp-layout">

  <!-- LEFT: Content -->
  <div class="exp-main">

    <!-- Overview -->
    <?php if($overview): ?>
    <div class="exp-section">
      <div class="exp-section-title">About This Expedition</div>
      <div class="overview-text">
        <?php echo nl2br(esc_html($overview)); ?>
      </div>
    </div>
    <?php endif; ?>

    <?php if($dates): ?>
    <div class="exp-section" style="background:rgba(196,75,25,.08);border:1px solid rgba(196,75,25,.25);border-radius:3px;padding:16px 20px;margin-bottom:0">
      <div style="font-size:10px;letter-spacing:3px;text-transform:uppercase;color:var(--rust);margin-bottom:6px">Expedition Dates</div>
      <div style="font-family:var(--headline);font-size:26px;color:#fff;letter-spacing:.5px">📅 <?php echo esc_html($dates); ?></div>
    </div>
    <?php endif; ?>

    <!-- Highlights -->
    <?php if(!empty($highlights)): ?>
    <div class="exp-section">
      <div class="exp-section-title">Expedition Highlights</div>
      <div class="highlights-grid">
        <?php foreach($highlights as $h): ?>
        <div class="highlight-item">⭐ <?php echo esc_html($h); ?></div>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endif; ?>

    <!-- Itinerary -->
    <?php if(!empty($itinerary)): ?>
    <div class="exp-section">
      <div class="exp-section-title">Day-by-Day Itinerary</div>
      <?php foreach($itinerary as $i => $day): ?>
      <div class="day-row">
        <div class="day-label">Day <?php echo $i+1; ?></div>
        <div class="day-content">
          <?php if(!empty($day['title'])): ?>
          <div class="day-title"><?php echo esc_html($day['title']); ?></div>
          <?php endif; ?>
          <?php if(!empty($day['description'])): ?>
          <div class="day-text"><?php echo nl2br(esc_html($day['description'])); ?></div>
          <?php endif; ?>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <!-- Expedition Package -->
    <?php if(!empty($inclusions) || !empty($exclusions) || !empty($cancellation)): ?>
    <div class="exp-section" style="margin-top:48px">
      <div style="font-size:11px;font-weight:600;letter-spacing:4px;text-transform:uppercase;color:var(--rust);margin-bottom:20px">Expedition Package</div>
      <div class="pkg-tabs">
        <button class="ie-tab active" onclick="showPkg('inc',this)">Inclusions</button>
        <button class="ie-tab" onclick="showPkg('exc',this)">Exclusions</button>
        <button class="ie-tab" onclick="showPkg('can',this)">Cancellation</button>
      </div>
      <div class="pkg-content">
        <div class="pkg-panel visible" id="pkg-inc">
          <?php if(!empty($inclusions)): ?>
          <ul class="ie-list">
            <?php foreach($inclusions as $item): ?><li><?php echo esc_html($item); ?></li><?php endforeach; ?>
          </ul>
          <?php else: ?><p style="color:#8a7052;font-size:14px;font-weight:300">No inclusions added yet.</p><?php endif; ?>
        </div>
        <div class="pkg-panel" id="pkg-exc">
          <?php if(!empty($exclusions)): ?>
          <ul class="ie-list exc">
            <?php foreach($exclusions as $item): ?><li><?php echo esc_html($item); ?></li><?php endforeach; ?>
          </ul>
          <?php else: ?><p style="color:#8a7052;font-size:14px;font-weight:300">No exclusions added yet.</p><?php endif; ?>
        </div>
        <div class="pkg-panel" id="pkg-can">
          <?php if(!empty($cancellation)): ?>
          <ul class="ie-list can">
            <?php foreach($cancellation as $item): ?><li><?php echo esc_html($item); ?></li><?php endforeach; ?>
          </ul>
          <?php else: ?><p style="color:#8a7052;font-size:14px;font-weight:300">No cancellation policy added yet.</p><?php endif; ?>
        </div>
      </div>
    </div>
    <?php endif; ?>

  </div><!-- /exp-main -->

  <!-- RIGHT: Sidebar -->
  <div class="exp-sidebar">
    <div class="pay-panel">
      <div class="pay-header">
        <div class="pay-header-title">Book This Expedition</div>
        <div class="pay-header-dates">Pay directly — no gateway fees</div>
      </div>

      <!-- Price strip -->
      <div class="price-strip">
        <div class="ps-item">
          <div class="ps-label">Self Drive</div>
          <div class="ps-val">₹<?php echo number_format($price); ?></div>
          <div class="ps-note"><?php echo esc_html($unit); ?></div>
        </div>
        <?php if($cp > 0): ?>
        <div class="ps-item">
          <div class="ps-label">Couple Discount</div>
          <div class="ps-val">₹<?php echo number_format($cp); ?></div>
          <div class="ps-note">per person</div>
        </div>
        <?php endif; ?>
        <?php if($sp > 0): ?>
        <div class="ps-item" style="flex-basis:100%;border-top:1px solid rgba(255,255,255,.07)">
          <div class="ps-label">Seat Sharing</div>
          <div class="ps-val">₹<?php echo number_format($sp); ?></div>
          <div class="ps-note">per person</div>
        </div>
        <?php endif; ?>
      </div>



      <!-- BOOK NOW — Razorpay + WhatsApp -->
      <div style="padding:20px 24px 24px">
        <?php
          $wa_num_book  = $wa_num;
          $wa_text_book = 'Hi FreeWheel! 👋 I want to book the *' . $title . '* expedition.' . ($dates ? ' Dates: ' . $dates . '.' : '') . ' Please share booking details.';
          $exp_post_id  = get_the_ID();
        ?>

        <!-- Seats selector -->
        <div style="margin-bottom:14px">
          <label style="font-size:10px;letter-spacing:2px;text-transform:uppercase;color:rgba(255,255,255,.45);display:block;margin-bottom:6px">Number of Seats</label>
          <div style="display:flex;align-items:center;gap:10px">
            <button onclick="fwExpSeatChange(-1)" style="width:36px;height:36px;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.15);color:#fff;font-size:18px;cursor:pointer;border-radius:2px">−</button>
            <span id="expSeatCount" style="font-family:var(--headline);font-size:28px;color:#fff;min-width:30px;text-align:center">1</span>
            <button onclick="fwExpSeatChange(1)" style="width:36px;height:36px;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.15);color:#fff;font-size:18px;cursor:pointer;border-radius:2px">+</button>
            <span style="font-size:13px;color:rgba(255,255,255,.4)">× ₹<?php echo number_format($price); ?></span>
          </div>
          <div style="margin-top:8px;font-size:13px;color:rgba(255,255,255,.6)">Total: <strong id="expTotalAmt" style="color:var(--amber)">₹<?php echo number_format($price); ?></strong></div>
        </div>

        <!-- Payment Options - shown only when logged in -->
        <div id="expPayGate" style="display:none;padding:12px;background:rgba(193,68,14,.1);border:1px solid rgba(193,68,14,.3);border-radius:2px;font-size:13px;color:rgba(255,255,255,.7);margin-bottom:12px;text-align:center">
          Please <a id="expLoginLink" href="/login/" style="color:var(--rust)">log in</a> to book this expedition.
        </div>

        <div id="expPayOptions" style="display:none">
          <!-- Pay tabs -->
          <div style="display:flex;gap:6px;margin-bottom:14px">
            <button onclick="expSelPay('online',this)" id="expTabOnline"
              style="flex:1;padding:10px 6px;background:var(--rust);border:none;color:#fff;font-family:var(--headline);font-size:12px;letter-spacing:1px;cursor:pointer;border-radius:2px">PAY ONLINE</button>
            <button onclick="expSelPay('upi',this)" id="expTabUpi"
              style="flex:1;padding:10px 6px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.12);color:rgba(255,255,255,.7);font-family:var(--headline);font-size:12px;letter-spacing:1px;cursor:pointer;border-radius:2px">UPI</button>
            <button onclick="expSelPay('bank',this)" id="expTabBank"
              style="flex:1;padding:10px 6px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.12);color:rgba(255,255,255,.7);font-family:var(--headline);font-size:12px;letter-spacing:1px;cursor:pointer;border-radius:2px">BANK TRANSFER</button>
          </div>

          <!-- Pay Online Panel -->
          <div id="expPanelOnline">
            <button id="rzpExpBtn" onclick="fwExpRzpPay()"
              style="width:100%;padding:14px;background:var(--rust);border:none;color:#fff;font-family:var(--headline);font-size:18px;letter-spacing:2px;cursor:pointer;border-radius:2px;margin-bottom:8px">
              PAY &amp; BOOK NOW
            </button>
            <div id="rzpExpMsg" style="font-size:12px;text-align:center;min-height:16px;margin-bottom:8px"></div>
          </div>

          <!-- UPI Panel -->
          <div id="expPanelUpi" style="display:none">
            <div style="text-align:center;padding:16px 0">
              <div id="expUpiQrWrap" style="width:160px;height:160px;border:2px solid rgba(255,193,14,.3);border-radius:4px;margin:0 auto 12px;display:flex;align-items:center;justify-content:center;background:rgba(255,255,255,.03);overflow:hidden">
                <div style="font-size:11px;color:rgba(255,255,255,.3);letter-spacing:1px">LOADING QR...</div>
              </div>
              <div style="font-size:11px;color:rgba(255,255,255,.35);letter-spacing:2px;text-transform:uppercase;margin-bottom:6px">UPI ID</div>
              <div id="expUpiId" style="font-family:monospace;font-size:15px;font-weight:700;color:var(--amber)">Loading...</div>
              <button onclick="expCopyUpi()" style="margin-top:10px;padding:6px 16px;background:rgba(255,193,14,.1);border:1px solid rgba(255,193,14,.3);color:var(--amber);font-size:11px;letter-spacing:1.5px;text-transform:uppercase;cursor:pointer;border-radius:2px">Copy UPI ID</button>
            </div>
            <div style="font-size:11px;color:rgba(255,255,255,.4);text-align:center">After payment, WhatsApp your screenshot to confirm booking.<br><strong style="color:rgba(255,255,255,.6)">+91 78178 38060</strong></div>
          </div>

          <!-- Bank Transfer Panel -->
          <div id="expPanelBank" style="display:none">
            <div style="background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.08);border-left:3px solid var(--teal);padding:14px;border-radius:2px;margin-bottom:12px">
              <div style="display:flex;justify-content:space-between;padding:6px 0;border-bottom:1px solid rgba(255,255,255,.06);font-size:12px"><span style="color:rgba(255,255,255,.4);font-size:10px;text-transform:uppercase;letter-spacing:1px">Account Name</span><span style="color:#fff;font-weight:500">FreeWheel Expeditions</span></div>
              <div style="display:flex;justify-content:space-between;padding:6px 0;border-bottom:1px solid rgba(255,255,255,.06);font-size:12px"><span style="color:rgba(255,255,255,.4);font-size:10px;text-transform:uppercase;letter-spacing:1px">Account No.</span><span id="expAccNum" style="color:var(--teal);font-family:monospace;font-weight:500">Loading...</span></div>
              <div style="display:flex;justify-content:space-between;padding:6px 0;border-bottom:1px solid rgba(255,255,255,.06);font-size:12px"><span style="color:rgba(255,255,255,.4);font-size:10px;text-transform:uppercase;letter-spacing:1px">IFSC Code</span><span id="expAccIfsc" style="color:var(--teal);font-family:monospace;font-weight:500">Loading...</span></div>
              <div style="display:flex;justify-content:space-between;padding:6px 0;border-bottom:1px solid rgba(255,255,255,.06);font-size:12px"><span style="color:rgba(255,255,255,.4);font-size:10px;text-transform:uppercase;letter-spacing:1px">Bank</span><span id="expAccBank" style="color:#fff;font-weight:500">Loading...</span></div>
              <div style="display:flex;justify-content:space-between;padding:6px 0;font-size:12px"><span style="color:rgba(255,255,255,.4);font-size:10px;text-transform:uppercase;letter-spacing:1px">Type</span><span style="color:#fff;font-weight:500">Current Account</span></div>
            </div>
            <div style="font-size:11px;color:rgba(255,255,255,.4);text-align:center;line-height:1.6">After transfer, WhatsApp your receipt to confirm booking.<br>
              <strong style="color:rgba(255,255,255,.6)">+91 78178 38060</strong>
            </div>
          </div>
        </div>

        <a href="https://wa.me/<?php echo $wa_num_book; ?>?text=<?php echo urlencode($wa_text_book); ?>"
           target="_blank"
           style="display:flex;align-items:center;justify-content:center;gap:8px;padding:12px;background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.12);color:rgba(255,255,255,.6);font-size:12px;letter-spacing:1px;text-decoration:none;border-radius:2px;transition:background .2s"
           onmouseover="this.style.background='rgba(255,255,255,.1)'" onmouseout="this.style.background='rgba(255,255,255,.05)'">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.123.554 4.118 1.528 5.85L.057 23.077a.75.75 0 0 0 .943.895l5.344-1.705A11.945 11.945 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.75a9.726 9.726 0 0 1-4.964-1.355l-.355-.212-3.693 1.178 1.131-3.595-.232-.371A9.725 9.725 0 0 1 2.25 12C2.25 6.615 6.615 2.25 12 2.25S21.75 6.615 21.75 12 17.385 21.75 12 21.75z"/></svg>
          OR ENQUIRE ON WHATSAPP
        </a>
        <div style="text-align:center;font-size:11px;color:rgba(255,255,255,.25);margin-top:10px">Secure payment · UPI / Cards / NetBanking via Razorpay</div>

      </div>
    </div><!-- /pay-panel -->

      <script>
      var _expSeats=1, _expPrice=<?php echo intval($price); ?>, _expPostId='<?php echo esc_js(get_the_ID()); ?>', _expTitle='<?php echo esc_js($title); ?>', _expDates='<?php echo esc_js($dates); ?>';
      function fwExpSeatChange(d){_expSeats=Math.max(1,Math.min(10,_expSeats+d));document.getElementById('expSeatCount').textContent=_expSeats;document.getElementById('expTotalAmt').textContent='₹'+(_expSeats*_expPrice).toLocaleString('en-IN');}
      async /* ── Expedition payment panel init ── */
function expInitPayment(){
  var session=null;
  try{session=JSON.parse(localStorage.getItem('fw_session')||'null');}catch(e){}
  var gate=document.getElementById('expPayGate');
  var opts=document.getElementById('expPayOptions');
  var link=document.getElementById('expLoginLink');
  var isLoggedIn = session && session.access_token && (!session.expires_at || session.expires_at > Date.now());
  if(!isLoggedIn){
    if(gate){gate.style.display='block';}
    if(link){link.href=(window.FW_AUTH?window.FW_AUTH.login_url:'/login/')+'?redirect='+encodeURIComponent(window.location.href);}
  } else {
    if(opts){opts.style.display='block';}
    expLoadBankDetails(session.access_token);
  }
}

function expSelPay(mode,btn){
  ['online','upi','bank'].forEach(function(m){
    var panel=document.getElementById('expPanel'+m.charAt(0).toUpperCase()+m.slice(1));
    var tab=document.getElementById('expTab'+m.charAt(0).toUpperCase()+m.slice(1));
    if(panel) panel.style.display=m===mode?'block':'none';
    if(tab){ tab.style.background=m===mode?'var(--rust)':'rgba(255,255,255,.06)'; tab.style.color=m===mode?'#fff':'rgba(255,255,255,.7)'; }
  });
}

function expCopyUpi(){
  var el=document.getElementById('expUpiId');
  if(!el||el.textContent==='Loading...')return;
  navigator.clipboard.writeText(el.textContent).then(function(){
    var btn=event.target; btn.textContent='Copied!';
    setTimeout(function(){btn.textContent='Copy UPI ID';},2000);
  });
}

function expLoadBankDetails(token){
  var nonce=document.getElementById('fw_pay_nonce');
  if(!nonce)return;
  fetch(window.FW_AJAX_URL,{
    method:'POST',
    headers:{'Content-Type':'application/x-www-form-urlencoded'},
    body:new URLSearchParams({action:'fw_get_payment',nonce:nonce.value,has_items:'1'})
  }).then(function(r){return r.json();})
  .then(function(res){
    if(!res.success)return;
    var d=res.data;
    var n=document.getElementById('expAccNum');
    var i=document.getElementById('expAccIfsc');
    var b=document.getElementById('expAccBank');
    var u=document.getElementById('expUpiId');
    if(n)n.textContent=d.acc_num;
    if(i)i.textContent=d.ifsc;
    if(b)b.textContent=d.bank;
    if(u)u.textContent=d.upi;
    if(d.qr_image){
      var qrWrap=document.getElementById('expUpiQrWrap');
      if(qrWrap)qrWrap.innerHTML='<img src="'+d.qr_image+'" style="width:100%;height:100%;object-fit:contain">';
    } else {
      var qrLoad=document.querySelector('#expUpiQrWrap div');
      if(qrLoad)qrLoad.textContent='Scan via any UPI app';
    }
  }).catch(function(){});
}

/* Run on page load */
document.addEventListener('DOMContentLoaded', function(){
  expInitPayment();
});

function fwExpRzpPay(){
        var btn=document.getElementById('rzpExpBtn'),msg=document.getElementById('rzpExpMsg');
        msg.textContent='';msg.style.color='#f87171';
        if(typeof Razorpay==='undefined'){msg.textContent='Razorpay payment is being set up. Please use Bank Transfer for now.';msg.style.color='#f59e0b';return;}
        var session=null;try{session=JSON.parse(localStorage.getItem('fw_session')||'null');}catch(e){}
        if(!session||!session.access_token||session.expires_at<Date.now()){msg.textContent='Please log in to book.';setTimeout(function(){window.location.href=window.FW_AUTH.login_url+'?redirect='+encodeURIComponent(window.location.href);},1200);return;}
        if(!window.FW_RZP_KEY){msg.textContent='Payment gateway not configured.';return;}
        btn.disabled=true;btn.textContent='Creating order…';
        var amountPaise=_expSeats*_expPrice*100;
        try{
          var or=await fetch(window.FW_AUTH.rest_url+'/rzp-create-order',{method:'POST',headers:{'Content-Type':'application/json','Authorization':'Bearer '+session.access_token},body:JSON.stringify({amount:amountPaise,type:'expedition',ref_id:_expPostId,note:_expTitle+' · '+_expDates+' · '+_expSeats+' seat(s)'})});
          var od=await or.json();if(!or.ok)throw new Error(od.message||'Order creation failed.');
          var rzp=new Razorpay({key:window.FW_RZP_KEY,amount:od.amount,currency:od.currency,name:'FreeWheel Expeditions',description:_expTitle+(_expDates?' · '+_expDates:'')+' · '+_expSeats+' seat(s)',order_id:od.order_id,prefill:{email:session.email,name:session.first_name||''},theme:{color:'#c1440e'},
            modal:{ondismiss:function(){btn.disabled=false;btn.textContent='PAY & BOOK NOW';}},
            handler:async function(r){
              btn.textContent='Verifying…';
              try{
                var vr=await fetch(window.FW_AUTH.rest_url+'/rzp-verify-payment',{method:'POST',headers:{'Content-Type':'application/json','Authorization':'Bearer '+session.access_token},body:JSON.stringify({razorpay_order_id:r.razorpay_order_id,razorpay_payment_id:r.razorpay_payment_id,razorpay_signature:r.razorpay_signature,type:'expedition',ref_id:_expPostId,amount:amountPaise,seats:_expSeats,note:_expTitle+' · '+_expDates})});
                var vd=await vr.json();if(!vr.ok)throw new Error(vd.message||'Verification failed.');
                btn.style.background='#16a34a';btn.textContent='✓ BOOKING CONFIRMED!';
                msg.textContent=vd.message||'Booking confirmed!';msg.style.color='#4ade80';
              }catch(err){msg.textContent='Payment received. Contact support with ID: '+r.razorpay_payment_id;btn.disabled=false;btn.textContent='PAY & BOOK NOW';}
            }
          });
          rzp.on('payment.failed',function(resp){msg.textContent='Payment failed: '+(resp.error.description||'Try again.');btn.disabled=false;btn.textContent='PAY & BOOK NOW';});
          rzp.open();
        }catch(err){msg.textContent=err.message||'Something went wrong.';btn.disabled=false;btn.textContent='PAY & BOOK NOW';}
      }
      </script>

    <div id="sidebarSub" style="background:linear-gradient(135deg,var(--teal),#1a5a50);padding:20px">
      <div style="font-size:10px;letter-spacing:3px;text-transform:uppercase;color:rgba(255,255,255,.6);margin-bottom:6px">Member Perk</div>
      <div style="font-family:var(--headline);font-size:26px;color:var(--amber);margin-bottom:4px">5% OFF</div>
      <div style="font-size:12px;color:rgba(255,255,255,.7);font-weight:300;line-height:1.5;margin-bottom:14px">Subscribe for exclusive discounts, priority slots &amp; road dispatches — we'll reach you on email or WhatsApp.</div>
      <button onclick="fwSubOpen()" style="width:100%;display:flex;align-items:center;justify-content:center;gap:10px;padding:12px;background:var(--rust);border:none;color:#fff;font-family:var(--headline);font-size:15px;letter-spacing:2px;cursor:pointer;border-radius:2px;transition:background .2s" onmouseover="this.style.background='#a03508'" onmouseout="this.style.background='var(--rust)'">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,12 2,6"/></svg>
        SUBSCRIBE &amp; UNLOCK
      </button>
    </div>

  </div><!-- /exp-sidebar -->

</div><!-- /exp-layout -->

<script>
/* payment tab functions removed — using WhatsApp booking */
function showPkg(id, btn) {
  document.querySelectorAll('.pkg-panel').forEach(function(p){p.classList.remove('visible');});
  document.querySelectorAll('.ie-tab').forEach(function(t){t.classList.remove('active');});
  document.getElementById('pkg-' + id).classList.add('visible');
  btn.classList.add('active');
}
</script>

<!-- THINGS TO CARRY -->
<?php
$default_carry = array(
  'All required Vehicle documents (RC, PUC, Insurance) & Individual (DL, ID proof, Personal Insurance)',
  'Toilet Paper & Wipes',
  'Eatables & Water bottles (for any emergency)',
  'Mosquito & Insect repellent',
  'Sufficient clothes as per trip days',
  'Energy & Excitement',
  'Helping hands — not just yours!',
  'Leave your worries at home. CARRY YOUR SMILE.',
  'MINIMUM 2 Jerry Cans of 20L each — fuel stations are limited at high altitudes'
);
$carry_items = !empty($things_carry) ? $things_carry : $default_carry;
?>
<section class="carry-section">
  <div class="carry-inner">
    <div style="font-size:11px;font-weight:600;letter-spacing:4px;text-transform:uppercase;color:var(--amber);margin-bottom:8px">Be Prepared</div>
    <h2 style="font-family:var(--headline);font-size:clamp(32px,4vw,50px);color:#fff;letter-spacing:1px;margin-bottom:0">Things To Carry</h2>
    <div class="carry-grid">
      <?php foreach($carry_items as $item): ?>
      <div class="carry-item"><?php echo esc_html($item); ?></div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- WHY FREEWHEEL — Trust signals replacing the redundant CTA -->
<section style="background:var(--ink);padding:60px 5vw;border-top:1px solid rgba(255,255,255,.06)">
  <div style="max-width:1100px;margin:0 auto;text-align:center">
    <div style="font-size:11px;letter-spacing:3px;text-transform:uppercase;color:var(--amber);margin-bottom:10px">Why Adventure Lovers Choose Us</div>
    <h2 style="font-family:var(--headline);font-size:clamp(28px,4vw,46px);color:#fff;margin-bottom:40px;line-height:1">Built for the Road, For Everyone On It</h2>
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:1px;background:rgba(255,255,255,.07)">
      <div style="background:#0f0d0b;padding:28px 24px">
        <div style="font-size:32px;margin-bottom:10px">🛣️</div>
        <div style="font-family:var(--headline);font-size:18px;color:#fff;margin-bottom:6px">Self-Drive Only</div>
        <div style="font-size:13px;color:rgba(255,255,255,.55);line-height:1.6;font-weight:300">No tour buses. Whether you're on two wheels or four, you drive your own machine, your own way.</div>
      </div>
      <div style="background:#0f0d0b;padding:28px 24px">
        <div style="font-size:32px;margin-bottom:10px">📞</div>
        <div style="font-family:var(--headline);font-size:18px;color:#fff;margin-bottom:6px">Direct Booking</div>
        <div style="font-size:13px;color:rgba(255,255,255,.55);line-height:1.6;font-weight:300">No middlemen, no gateway fees. Book straight on WhatsApp — instant reply.</div>
      </div>
      <div style="background:#0f0d0b;padding:28px 24px">
        <div style="font-size:32px;margin-bottom:10px">🏔️</div>
        <div style="font-family:var(--headline);font-size:18px;color:#fff;margin-bottom:6px">Expert-Scouted Routes</div>
        <div style="font-size:13px;color:rgba(255,255,255,.55);line-height:1.6;font-weight:300">Every route ground-tested by our team. Every stop, altitude, and fuel point mapped before you leave.</div>
      </div>
      <div style="background:#0f0d0b;padding:28px 24px">
        <div style="font-size:32px;margin-bottom:10px">🤝</div>
        <div style="font-family:var(--headline);font-size:18px;color:#fff;margin-bottom:6px">Real Community</div>
        <div style="font-size:13px;color:rgba(255,255,255,.55);line-height:1.6;font-weight:300">Intentionally small groups. Cars, bikes, and people who actually want to be there — not just a convoy.</div>
      </div>
    </div>
  </div>
</section>

<!-- PHOTO GALLERY -->
<?php if(!empty($gallery)): ?>
<div class="exp-gallery">
  <div class="exp-gal-title">Photo Gallery</div>
  <div class="exp-gal-sub">Moments from the road</div>
  <div class="exp-gal-grid">
    <?php foreach($gallery as $i => $photo): if(empty($photo['url'])) continue; ?>
    <div class="exp-gal-item" onclick="expOpenLB(<?php echo $i; ?>)">
      <img src="<?php echo esc_url($photo['url']); ?>" alt="Gallery photo <?php echo $i+1; ?>" loading="lazy">
      <div class="exp-gal-item-overlay">🔍</div>
    </div>
    <?php endforeach; ?>
  </div>
</div>

<!-- Lightbox -->
<div id="expLightbox" class="exp-lightbox" onclick="if(event.target===this)expCloseLB()">
  <button class="exp-lb-close" onclick="expCloseLB()">✕</button>
  <button class="exp-lb-prev" onclick="expNavLB(-1)">&#8592;</button>
  <img id="expLBImg" class="exp-lb-img" src="" alt="">
  <button class="exp-lb-next" onclick="expNavLB(1)">&#8594;</button>
  <div id="expLBCounter" class="exp-lb-counter"></div>
</div>
<script>
var expPhotos = [
  <?php foreach($gallery as $photo): if(empty($photo['url'])) continue; ?>
  '<?php echo esc_js($photo['url']); ?>',
  <?php endforeach; ?>
];
var expCurr = 0;
function expOpenLB(i){
  expCurr=i;
  document.getElementById('expLBImg').src=expPhotos[i];
  document.getElementById('expLBCounter').textContent=(i+1)+' / '+expPhotos.length;
  document.getElementById('expLightbox').classList.add('open');
  document.body.style.overflow='hidden';
}
function expCloseLB(){
  document.getElementById('expLightbox').classList.remove('open');
  document.body.style.overflow='';
}
function expNavLB(dir){
  expCurr=(expCurr+dir+expPhotos.length)%expPhotos.length;
  document.getElementById('expLBImg').src=expPhotos[expCurr];
  document.getElementById('expLBCounter').textContent=(expCurr+1)+' / '+expPhotos.length;
}
document.addEventListener('keydown',function(e){
  if(e.key==='ArrowLeft')expNavLB(-1);
  if(e.key==='ArrowRight')expNavLB(1);
  if(e.key==='Escape')expCloseLB();
});
</script>
<?php endif; ?>

<?php
// FAQs: get post ID reliably from URL slug as ultimate fallback
$faq_post_id = $id ? $id : get_the_ID();
// Debug — remove after fix
if (!$faq_post_id) {
    $faq_slug    = get_query_var('fw_expedition') ?: basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    $faq_post    = get_page_by_path($faq_slug, OBJECT, 'fw_expedition');
    $faq_post_id = $faq_post ? $faq_post->ID : 0;
}

// Direct database query — bypass all caching
global $wpdb;
$faq_post_id  = absint($faq_post_id);
$exp_faqs_raw = '';
if ($faq_post_id > 0) {
    $exp_faqs_raw = $wpdb->get_var(
        "SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = {$faq_post_id} AND meta_key = 'fw_exp_faqs' LIMIT 1"
    );
}

$exp_faqs = $exp_faqs_raw ? json_decode($exp_faqs_raw, true) : array();
if (!is_array($exp_faqs)) $exp_faqs = array();

// Filter out blank entries
$exp_faqs = array_values(array_filter($exp_faqs, function($f){ return !empty(trim($f['q'])); }));

// Get common FAQs via getter function
$all_fw_faqs = fw_get_faqs();
$common_faqs = array();

// Expedition-specific first, then common
$all_faqs = array_merge($exp_faqs, $common_faqs);

if (!empty($all_faqs)) fw_faq_output($all_faqs, 'custom');
?>

<!-- MOBILE STICKY BOOKING BAR (hidden on desktop via CSS) -->
<?php
  $mob_wa_num  = '917817838060';
  $mob_wa_text = urlencode('Hi FreeWheel! 👋 I want to book the *' . $title . '* expedition.' . ($dates ? ' Dates: ' . $dates . '.' : '') . ' Please share booking details.');
?>
<div class="mob-book-bar" id="mobBookBar">
  <a href="https://wa.me/<?php echo $mob_wa_num; ?>?text=<?php echo $mob_wa_text; ?>"
     target="_blank"
     style="background:var(--rust);color:#fff">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.123.554 4.118 1.528 5.85L.057 23.077a.75.75 0 0 0 .943.895l5.344-1.705A11.945 11.945 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.75a9.726 9.726 0 0 1-4.964-1.355l-.355-.212-3.693 1.178 1.131-3.595-.232-.371A9.725 9.725 0 0 1 2.25 12C2.25 6.615 6.615 2.25 12 2.25S21.75 6.615 21.75 12 17.385 21.75 12 21.75z"/></svg>
    Book Now
  </a>
  <a href="#sidebarSub" onclick="document.getElementById('sidebarSub').scrollIntoView({behavior:'smooth',block:'center'});return false;"
     style="background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.2);color:rgba(255,255,255,.8)">
    ✉️ Get 5% Off
  </a>
</div>


<!-- ── SUBSCRIBE POPUP FORM (copied from homepage) ── -->
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
function fwSubOpen(){
  var ov=document.getElementById('fwSubOverlay');
  if(ov){ov.classList.add('open');document.body.style.overflow='hidden';}
  setTimeout(function(){var n=document.getElementById('fwSubName');if(n)n.focus();},200);
}
function fwSubClose(){
  var ov=document.getElementById('fwSubOverlay');
  if(ov){ov.classList.remove('open');document.body.style.overflow='';}
}
async function fwSubSubmit(){
  var name   = (document.getElementById('fwSubName')||{}).value||'';
  var mobile = (document.getElementById('fwSubMobile')||{}).value||'';
  var email  = (document.getElementById('fwSubEmail')||{}).value||'';
  var msg    = document.getElementById('fwSubMsg');
  var btn    = document.getElementById('fwSubBtn');
  if(msg){msg.textContent='';msg.className='sub-form-msg';}
  if(!name.trim()){
    if(msg){msg.textContent='Please enter your name.';msg.className='sub-form-msg error';}
    document.getElementById('fwSubName').focus(); return;
  }
  if(!email.trim()||!email.includes('@')||!email.includes('.')){
    if(msg){msg.textContent='Please enter a valid email address.';msg.className='sub-form-msg error';}
    document.getElementById('fwSubEmail').focus(); return;
  }
  if(btn){btn.disabled=true;btn.textContent='Sending code…';}
  try{
    var REST=(window.FW_REST_URL||'/wp-json/freewheel/v1').replace(/\/$/,'');
    var payload=new URLSearchParams({name:name.trim(),email:email.trim().toLowerCase(),phone:mobile.trim(),source:'trip-page'});
    var r=await fetch(REST+'/subscribe',{method:'POST',headers:{'Content-Type':'application/x-www-form-urlencoded'},body:payload.toString()});
    var d=await r.json();
    if(!r.ok) throw new Error(d.message||'Failed to send verification code. Please try again.');
    window._fwSubPending={name:name.trim(),email:email.trim().toLowerCase(),whatsapp:mobile.trim()||null,source:'trip-page'};
    fwSubClose();
    if(typeof fwOtpOpen==='function') fwOtpOpen(email.trim().toLowerCase());
  }catch(err){
    if(msg){msg.textContent=err.message||'Something went wrong. Please try again.';msg.className='sub-form-msg error';}
  }finally{
    if(btn){btn.disabled=false;btn.textContent='GET ON THE LIST →';}
  }
}
['fwSubName','fwSubMobile','fwSubEmail'].forEach(function(id){
  var el=document.getElementById(id);
  if(el) el.addEventListener('keydown',function(e){ if(e.key==='Enter') fwSubSubmit(); });
});
document.addEventListener('keydown',function(e){
  if(e.key==='Escape'){
    var ov=document.getElementById('fwSubOverlay');
    if(ov&&ov.classList.contains('open')) fwSubClose();
  }
});
</script>


<!-- WhatsApp Broadcast CTA -->
<section style="background:linear-gradient(135deg,#075e54,#128c7e);padding:48px 5vw;text-align:center">
  <div style="max-width:700px;margin:0 auto">
    <div style="font-size:48px;margin-bottom:12px">📲</div>
    <h3 style="font-family:'Barlow Condensed',sans-serif;font-size:clamp(28px,4vw,42px);color:#fff;letter-spacing:1px;margin-bottom:10px">Get Expedition Updates on WhatsApp</h3>
    <p style="font-size:15px;color:rgba(255,255,255,.8);line-height:1.7;margin-bottom:28px;max-width:500px;margin-left:auto;margin-right:auto">Join our broadcast list — be the first to know about new expeditions, early bird slots, and route updates. No spam, only road stories.</p>
    <a href="https://wa.me/917817838060?text=Hi%21%20Please%20add%20me%20to%20the%20FreeWheel%20Expeditions%20broadcast%20list%20for%20updates." target="_blank" style="display:inline-flex;align-items:center;gap:10px;padding:15px 36px;background:#fff;color:#075e54;font-family:'Barlow Condensed',sans-serif;font-size:20px;letter-spacing:2px;text-transform:uppercase;border-radius:2px;text-decoration:none;font-weight:700">
      <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="#075e54"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.123.554 4.118 1.528 5.85L.057 23.077a.75.75 0 0 0 .943.895l5.344-1.705A11.945 11.945 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.75a9.726 9.726 0 0 1-4.964-1.355l-.355-.212-3.693 1.178 1.131-3.595-.232-.371A9.725 9.725 0 0 1 2.25 12C2.25 6.615 6.615 2.25 12 2.25S21.75 6.615 21.75 12 17.385 21.75 12 21.75z"/></svg>
      Join Broadcast List
    </a>
    <p style="font-size:11px;color:rgba(255,255,255,.5);margin-top:14px;letter-spacing:1px">+91 78178 38060 · We reply within 4 hours</p>
  </div>
</section>

<?php get_footer(); ?>