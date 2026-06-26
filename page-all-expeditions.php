<?php
/**
 * Template Name: All Expeditions
 * Template Post Type: page
 */
get_header();

/* Fetch all upcoming, published expeditions with the meta we need for filtering */
$exps = get_posts(array(
    'post_type'      => 'fw_expedition',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'meta_query'      => array(array('key' => 'fw_status', 'value' => 'upcoming')),
    'meta_key'        => 'fw_order',
    'orderby'         => 'meta_value_num',
    'order'           => 'ASC',
));

$destinations = array();
$months       = array();
foreach ($exps as $e) {
    $dest = get_post_meta($e->ID, 'fw_destination', true);
    $mon  = get_post_meta($e->ID, 'fw_month', true) ?: get_post_meta($e->ID, 'fw_dates', true);
    if ($dest) $destinations[$dest] = true;
    if ($mon)  $months[$mon] = true;
}
?>
<style>
html,body,body.page,#page,#content,#primary,#main,.site,.site-content,.entry-content,.wp-site-blocks,main,article{background:#0f0d0b!important;background-color:#0f0d0b!important;color:#fff!important}
.entry-content,.page-content,#primary,#main,main{padding:0!important;margin:0!important;max-width:100%!important;width:100%!important}
.site-header,.wp-block-template-part[class*="header"]{display:none!important}
*,*::before,*::after{box-sizing:border-box}
:root{--ink:#0f0d0b;--rust:#c1440e;--amber:#e8a020;--teal:#2a7a6e;--headline:'Bebas Neue',sans-serif;--body:'Barlow',sans-serif}
body{font-family:var(--body)}

.ae-hero{padding:100px 5vw 36px;text-align:center;background:linear-gradient(180deg,#1a1208,#0f0d0b)}
.ae-hero h1{font-family:var(--headline);font-size:clamp(34px,5vw,56px);letter-spacing:1px;color:#fff}
.ae-hero h1 span{color:var(--rust)}
.ae-hero p{color:rgba(255,255,255,.45);font-size:15px;margin-top:8px}

.ae-filters{max-width:1100px;margin:0 auto 40px;padding:0 5vw;display:flex;gap:12px;flex-wrap:wrap;align-items:center}
.ae-search{flex:1;min-width:220px;padding:13px 16px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.12);color:#fff;font-family:var(--body);font-size:14px;border-radius:2px;outline:none}
.ae-search::placeholder{color:rgba(255,255,255,.45)}
.ae-select{padding:13px 14px;background:#1a1410;border:1px solid rgba(255,255,255,.12);color:#fff;font-family:var(--body);font-size:13px;border-radius:2px;outline:none;cursor:pointer}
.ae-clear{padding:13px 18px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.12);color:rgba(255,255,255,.5);font-size:12px;letter-spacing:1px;text-transform:uppercase;cursor:pointer;border-radius:2px;font-family:var(--body)}
.ae-clear:hover{color:#fff;border-color:rgba(255,255,255,.3)}

.ae-count{max-width:1100px;margin:0 auto 20px;padding:0 5vw;font-size:13px;color:rgba(255,255,255,.5)}

.ae-grid{max-width:1100px;margin:0 auto;padding:0 5vw 80px;display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:24px}
.ae-empty{max-width:1100px;margin:0 auto;padding:60px 5vw;text-align:center;color:rgba(255,255,255,.45);font-size:14px}

/* trip-card styles — reused from fw_expedition_card() markup */
.trip-card{background:#161210;border:1px solid rgba(255,255,255,.08);border-radius:3px;overflow:hidden;transition:transform .2s,border-color .2s}
.trip-card:hover{transform:translateY(-3px);border-color:rgba(193,68,14,.4)}
.tc-top{position:relative;height:180px;display:flex;align-items:center;justify-content:center;overflow:hidden}
.tc-art{font-size:48px;opacity:.5}
.tc-grad{position:absolute;inset:0;background:linear-gradient(180deg,transparent 40%,rgba(15,13,11,.9) 100%)}
.tc-body{padding:18px 20px 20px}
.tc-title{font-family:var(--headline);font-size:20px;color:#fff;letter-spacing:.5px}
.tc-dets{display:flex;gap:14px;font-size:12px;color:rgba(255,255,255,.5);margin-bottom:14px}
.tc-price{display:flex;align-items:baseline;gap:6px;margin-bottom:14px}
.p-from{font-size:11px;color:rgba(255,255,255,.5)}
.p-num{font-family:var(--headline);font-size:24px;color:var(--amber)}
.p-note{font-size:11px;color:rgba(255,255,255,.5)}
.tc-btns{display:flex;flex-direction:column;gap:8px}
.det-btn{display:block;text-align:center;padding:10px 16px;background:var(--rust);color:#fff;text-decoration:none;border-radius:2px;font-size:13px;font-weight:600;letter-spacing:1px}
.det-btn:hover{background:#a03508}

@media(max-width:600px){.ae-filters{flex-direction:column;align-items:stretch}.ae-select{width:100%}}
</style>

<div class="ae-hero">
  <h1>All <span>Expeditions</span></h1>
  <p>Find your next self-drive adventure — filter by destination, month, or budget.</p>
</div>

<div class="ae-filters">
  <input type="text" id="aeSearch" class="ae-search" placeholder="Search by name or destination...">
  <select id="aeDestination" class="ae-select">
    <option value="">All Destinations</option>
    <?php foreach (array_keys($destinations) as $d): ?>
      <option value="<?php echo esc_attr($d); ?>"><?php echo esc_html($d); ?></option>
    <?php endforeach; ?>
  </select>
  <select id="aeMonth" class="ae-select">
    <option value="">Any Month</option>
    <?php foreach (array_keys($months) as $m): ?>
      <option value="<?php echo esc_attr($m); ?>"><?php echo esc_html($m); ?></option>
    <?php endforeach; ?>
  </select>
  <select id="aePrice" class="ae-select">
    <option value="">Any Budget</option>
    <option value="0-10000">Under ₹10,000</option>
    <option value="10000-25000">₹10,000 – ₹25,000</option>
    <option value="25000-50000">₹25,000 – ₹50,000</option>
    <option value="50000-999999">Above ₹50,000</option>
  </select>
  <button class="ae-clear" onclick="aeClearFilters()">Clear</button>
</div>

<div class="ae-count" id="aeCount"></div>

<?php if (empty($exps)): ?>
  <div class="ae-empty">No upcoming expeditions right now. Check back soon!</div>
<?php else: ?>
  <div class="ae-grid" id="aeGrid">
    <?php foreach ($exps as $exp):
      $dest  = get_post_meta($exp->ID, 'fw_destination', true);
      $mon   = get_post_meta($exp->ID, 'fw_month', true) ?: get_post_meta($exp->ID, 'fw_dates', true);
      $price = (int) get_post_meta($exp->ID, 'fw_price', true);
      $title = get_the_title($exp->ID);
    ?>
      <div class="ae-card-wrap"
           data-title="<?php echo esc_attr(strtolower($title)); ?>"
           data-dest="<?php echo esc_attr($dest); ?>"
           data-month="<?php echo esc_attr($mon); ?>"
           data-price="<?php echo esc_attr($price); ?>">
        <?php echo fw_expedition_card($exp->ID); ?>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

<script>
(function() {
  var cards = Array.from(document.querySelectorAll('.ae-card-wrap'));
  var countEl = document.getElementById('aeCount');

  function applyFilters() {
    var q     = document.getElementById('aeSearch').value.toLowerCase().trim();
    var dest  = document.getElementById('aeDestination').value;
    var month = document.getElementById('aeMonth').value;
    var priceRange = document.getElementById('aePrice').value;
    var priceMin = 0, priceMax = Infinity;
    if (priceRange) {
      var parts = priceRange.split('-');
      priceMin = parseInt(parts[0], 10);
      priceMax = parseInt(parts[1], 10);
    }

    var visible = 0;
    cards.forEach(function(card) {
      var title = card.dataset.title || '';
      var cDest = card.dataset.dest || '';
      var cMonth = card.dataset.month || '';
      var cPrice = parseInt(card.dataset.price, 10) || 0;

      var matchQ = !q || title.indexOf(q) !== -1 || cDest.toLowerCase().indexOf(q) !== -1;
      var matchDest = !dest || cDest === dest;
      var matchMonth = !month || cMonth === month;
      var matchPrice = cPrice >= priceMin && cPrice <= priceMax;

      var show = matchQ && matchDest && matchMonth && matchPrice;
      card.style.display = show ? '' : 'none';
      if (show) visible++;
    });

    countEl.textContent = visible + ' expedition' + (visible === 1 ? '' : 's') + ' found';
    var emptyMsg = document.getElementById('aeNoResults');
    if (visible === 0 && !emptyMsg) {
      emptyMsg = document.createElement('div');
      emptyMsg.id = 'aeNoResults';
      emptyMsg.className = 'ae-empty';
      emptyMsg.textContent = 'No expeditions match your filters. Try clearing them.';
      document.getElementById('aeGrid').parentNode.insertBefore(emptyMsg, document.getElementById('aeGrid').nextSibling);
    } else if (visible > 0 && emptyMsg) {
      emptyMsg.remove();
    }
  }

  document.getElementById('aeSearch').addEventListener('input', applyFilters);
  document.getElementById('aeDestination').addEventListener('change', applyFilters);
  document.getElementById('aeMonth').addEventListener('change', applyFilters);
  document.getElementById('aePrice').addEventListener('change', applyFilters);

  window.aeClearFilters = function() {
    document.getElementById('aeSearch').value = '';
    document.getElementById('aeDestination').value = '';
    document.getElementById('aeMonth').value = '';
    document.getElementById('aePrice').value = '';
    applyFilters();
  };

  applyFilters();
})();
</script>

<?php get_footer(); ?>
