<?php
/**
 * FreeWheel Expeditions — Merchandise / Store Page
 * Template Name: Merchandise
 * Dark-themed cards matching FreeWheel brand + cart with UPI/Bank payment
 */
get_header(); ?>
<style>
/* ── HERO ── */
.merch-hero{position:relative;min-height:280px;display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg,#0f0d0b 0%,#1a0a05 100%);overflow:hidden;text-align:center;padding:70px 5vw 50px}
.merch-hero-grid{position:absolute;inset:0;background-image:linear-gradient(rgba(193,68,14,.06) 1px,transparent 1px),linear-gradient(90deg,rgba(193,68,14,.06) 1px,transparent 1px);background-size:40px 40px;pointer-events:none}
.merch-eyebrow{font-size:11px;font-weight:500;letter-spacing:5px;text-transform:uppercase;color:var(--amber);margin-bottom:14px;display:flex;align-items:center;justify-content:center;gap:10px}
.merch-eyebrow::before,.merch-eyebrow::after{content:'';width:32px;height:1px;background:var(--amber);opacity:.6}
.merch-h1{font-family:var(--headline);font-size:clamp(48px,10vw,100px);color:#fff;line-height:.9;margin-bottom:16px}
.merch-h1 span{color:var(--rust)}
.merch-sub{font-size:14px;color:rgba(255,255,255,.5);font-weight:300;max-width:480px;margin:0 auto;line-height:1.6}

/* ── FILTER ── */
.filter-bar{display:flex;gap:8px;flex-wrap:wrap;justify-content:center;padding:24px 5vw 16px;background:#0a0805}
.filt{padding:7px 18px;border:1px solid rgba(255,255,255,.15);background:transparent;color:rgba(255,255,255,.6);font-size:11px;letter-spacing:2px;text-transform:uppercase;cursor:pointer;font-family:var(--body);transition:all .2s;border-radius:2px}
.filt:hover,.filt.active{background:var(--rust);border-color:var(--rust);color:#fff}

/* ── DARK PRODUCT GRID ── */
.merch-section{background:#0a0805;padding:8px 5vw 60px}
.merch-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:2px}
.merch-card{background:#1a1410;border:1px solid rgba(255,255,255,.07);display:flex;flex-direction:column;transition:border-color .25s,transform .2s;position:relative}
.merch-card:hover{border-color:rgba(193,68,14,.4);transform:translateY(-2px)}
.merch-card.hidden{display:none}

/* ── PRODUCT IMAGE ── */
.mc-img{position:relative;aspect-ratio:4/3;overflow:hidden;background:#111;display:flex;align-items:center;justify-content:center;cursor:zoom-in}
.mc-img img{width:100%;height:100%;object-fit:contain;padding:20px;box-sizing:border-box;transition:transform .4s}
.merch-card:hover .mc-img img{transform:scale(1.05)}
.mc-emoji-ph{font-size:80px;opacity:.12;cursor:default}

/* ── LIGHTBOX ── */
#fw-lb{position:fixed;inset:0;background:rgba(0,0,0,.92);z-index:2000;display:none;align-items:center;justify-content:center;backdrop-filter:blur(6px)}
#fw-lb.open{display:flex}
#fw-lb-img{max-width:90vw;max-height:85vh;object-fit:contain;border-radius:4px;box-shadow:0 20px 60px rgba(0,0,0,.8)}
#fw-lb-close{position:absolute;top:20px;right:28px;color:#fff;font-size:36px;cursor:pointer;background:none;border:none;opacity:.7;transition:opacity .2s;line-height:1}
#fw-lb-close:hover{opacity:1}
#fw-lb-name{position:absolute;bottom:28px;left:50%;transform:translateX(-50%);color:rgba(255,255,255,.7);font-family:var(--headline);font-size:14px;letter-spacing:2px;text-transform:uppercase;white-space:nowrap}
/* Discount badge */
.mc-discount-badge{position:absolute;top:12px;right:12px;background:var(--rust);color:#fff;font-size:10px;font-weight:700;letter-spacing:1.5px;padding:4px 10px;z-index:3;text-transform:uppercase}
/* Stock badges */
.mc-stock-badge{position:absolute;top:12px;left:12px;font-size:9px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;padding:4px 9px;color:#fff;z-index:3}
.badge-new{background:#007185}
.badge-limited{background:#e8a020;color:#000}
/* Soldout overlay */
.mc-soldout-overlay{position:absolute;inset:0;background:rgba(0,0,0,.65);display:flex;align-items:center;justify-content:center;z-index:5}
.mc-soldout-txt{font-family:var(--headline);font-size:22px;letter-spacing:3px;color:rgba(255,255,255,.5)}

/* ── CARD BODY ── */
.mc-body{padding:16px 18px 20px;display:flex;flex-direction:column;gap:0;flex:1}
.mc-name{font-family:var(--headline);font-size:18px;color:#fff;letter-spacing:1px;line-height:1.2;margin-bottom:5px}
.mc-feature{font-size:11px;letter-spacing:2px;text-transform:uppercase;color:rgba(255,255,255,.35);margin-bottom:10px;font-weight:300}

/* ── PRICE BLOCK ── */
.mc-price-block{margin-bottom:10px}
.mc-discount-pct{font-size:12px;font-weight:700;color:var(--rust);letter-spacing:1px;margin-bottom:4px;text-transform:uppercase}
.mc-price-row{display:flex;align-items:baseline;gap:8px;flex-wrap:wrap}
.mc-price{font-family:var(--headline);font-size:26px;color:var(--amber);letter-spacing:1px}
.mc-orig{font-size:13px;color:rgba(255,255,255,.6);text-decoration:line-through;text-decoration-color:rgba(255,100,100,.8);font-family:var(--body)}
.mc-mrp-label{font-size:11px;color:rgba(255,255,255,.6)}

/* ── PERKS ── */
.mc-perks{display:flex;flex-direction:column;gap:4px;margin-bottom:12px}
.mc-perk{font-size:11px;color:rgba(255,255,255,.5);display:flex;align-items:center;gap:5px;line-height:1.4}
.mc-perk.reg-off{color:var(--amber)}

/* ── ADD TO CART ── */
.mc-add-btn{padding:10px 14px;background:var(--rust);border:none;color:#fff;font-family:var(--headline);font-size:14px;letter-spacing:2px;cursor:pointer;transition:all .2s;width:100%;text-align:center;border-radius:2px}
.mc-add-btn:hover{background:#c03508}
.mc-add-btn.in-cart{background:var(--teal);color:#fff}
.mc-variants{margin-bottom:10px}
.mc-var-label{font-size:11px;letter-spacing:1.5px;text-transform:uppercase;color:rgba(255,255,255,.4);margin-bottom:6px}
.mc-var-label span{color:#fff;font-weight:600}
.mc-swatches{display:flex;gap:8px;flex-wrap:wrap}
.mc-swatch{width:26px;height:26px;border-radius:50%;cursor:pointer;position:relative;transition:transform .15s;flex-shrink:0}
.mc-swatch:hover{transform:scale(1.15)}
.mc-swatch.swatch-active{box-shadow:0 0 0 2px var(--rust),0 0 0 4px rgba(196,75,25,.3)}
.swatch-check{position:absolute;inset:0;display:flex;align-items:center;justify-content:center;font-size:12px;color:#fff;text-shadow:0 0 3px rgba(0,0,0,.8)}
.mc-sizes{display:flex;gap:6px;flex-wrap:wrap}
.mc-size-btn{padding:5px 10px;border:1px solid rgba(255,255,255,.2);color:rgba(255,255,255,.6);font-size:11px;letter-spacing:1px;cursor:pointer;border-radius:2px;transition:all .15s;background:transparent;white-space:nowrap}
.mc-size-btn:hover{border-color:rgba(255,255,255,.5);color:#fff}
.mc-size-btn.size-active{border-color:var(--rust);color:#fff;background:rgba(196,75,25,.15)}
.mc-soldout-btn{background:rgba(255,255,255,.08);color:rgba(255,255,255,.3);pointer-events:none;cursor:not-allowed;border-radius:2px}

/* ── CART BUBBLE ── */
#fw-cart-bubble{position:fixed;bottom:28px;right:28px;z-index:1200;background:var(--rust);color:#fff;font-family:var(--headline);font-size:16px;letter-spacing:2px;padding:14px 22px;cursor:pointer;display:none;align-items:center;gap:10px;box-shadow:0 8px 32px rgba(193,68,14,.45);border-radius:3px;transition:transform .2s}
#fw-cart-bubble:hover{transform:scale(1.04)}
#fw-cart-count{background:#fff;color:var(--rust);border-radius:50%;width:22px;height:22px;display:flex;align-items:center;justify-content:center;font-size:13px;font-family:var(--body);font-weight:700}

/* ── CART DRAWER ── */
#fw-cart-drawer{position:fixed;top:0;right:-100%;width:min(460px,100vw);height:100vh;background:#0f0d0b;border-left:2px solid var(--rust);z-index:1300;transition:right .35s cubic-bezier(.4,0,.2,1);overflow-y:auto;display:flex;flex-direction:column}
#fw-cart-drawer.open{right:0}
#fw-cart-overlay{position:fixed;inset:0;background:rgba(0,0,0,.65);z-index:1299;display:none;backdrop-filter:blur(3px)}
#fw-cart-overlay.open{display:block}
.cart-head{padding:20px 24px;border-bottom:1px solid rgba(255,255,255,.08);display:flex;align-items:center;justify-content:space-between;flex-shrink:0}
.cart-head-title{font-family:var(--headline);font-size:24px;letter-spacing:2px;color:#fff}
.cart-close{background:none;border:none;color:rgba(255,255,255,.4);font-size:24px;cursor:pointer;padding:4px 8px;transition:color .2s}
.cart-close:hover{color:#fff}
.cart-items{flex:1;padding:16px 24px;overflow-y:auto}
.cart-item{display:grid;grid-template-columns:60px 1fr auto;gap:12px;align-items:center;padding:12px 0;border-bottom:1px solid rgba(255,255,255,.06)}
.cart-item-img{width:60px;height:60px;object-fit:contain;background:#1a1410;border-radius:3px;padding:4px;box-sizing:border-box}
.cart-item-img-ph{width:60px;height:60px;background:#1a1410;border-radius:3px;display:flex;align-items:center;justify-content:center;font-size:26px}
.cart-item-name{font-size:13px;font-weight:500;color:#fff;margin-bottom:3px;line-height:1.4}
.cart-item-price{font-size:15px;color:var(--amber);font-family:var(--headline)}
.cart-qty{display:flex;align-items:center;gap:6px}
.cart-qty-btn{width:26px;height:26px;border-radius:50%;border:1px solid rgba(255,255,255,.2);background:transparent;color:#fff;cursor:pointer;font-size:14px;display:flex;align-items:center;justify-content:center;transition:all .2s}
.cart-qty-btn:hover{background:var(--rust);border-color:var(--rust)}
.cart-qty-num{font-size:14px;font-weight:600;color:#fff;min-width:20px;text-align:center}
.cart-empty{text-align:center;padding:60px 20px;color:rgba(255,255,255,.25)}

/* ── CART FOOTER / PAYMENT ── */
.cart-footer{padding:18px 24px 24px;border-top:2px solid rgba(255,255,255,.08);flex-shrink:0;background:#0a0805}
.cart-sum-row{display:flex;justify-content:space-between;font-size:13px;color:rgba(255,255,255,.55);margin-bottom:6px;font-family:var(--body)}
.cart-sum-row.total{font-family:var(--headline);font-size:22px;color:#fff;letter-spacing:1px;margin-top:10px;padding-top:10px;border-top:1px solid rgba(255,255,255,.1)}
.cart-discount-note{background:rgba(42,122,110,.15);border:1px solid rgba(42,122,110,.3);color:#4db6ac;font-size:11px;letter-spacing:1.5px;padding:7px 12px;text-align:center;margin:10px 0;font-family:var(--body);border-radius:2px}
/* Pay tabs */
.pay-tabs{display:flex;gap:1px;background:rgba(255,255,255,.07);margin:14px 0 0}
.pay-tab{flex:1;padding:11px 10px;text-align:center;font-size:10px;font-weight:600;letter-spacing:2px;text-transform:uppercase;background:#0a0805;color:rgba(255,255,255,.35);cursor:pointer;transition:all .2s;border:none}
.pay-tab.active{background:var(--rust);color:#fff}
.pay-panel{display:none;padding:14px 0 0}.pay-panel.visible{display:block}
/* UPI block */
.pay-upi-block{background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.08);border-left:3px solid var(--amber);padding:14px;margin-bottom:12px}
.pay-upi-row{display:flex;align-items:center;justify-content:space-between;gap:10px}
.pay-upi-label{font-size:9px;letter-spacing:3px;text-transform:uppercase;color:rgba(255,255,255,.3);margin-bottom:4px}
.pay-upi-id{font-family:monospace;font-size:14px;font-weight:700;color:var(--amber);word-break:break-all}
.pay-upi-name{font-size:11px;color:rgba(255,255,255,.35);margin-top:3px}
.pay-copy-btn{padding:6px 14px;background:rgba(232,160,32,.15);border:1px solid rgba(232,160,32,.4);color:var(--amber);font-size:10px;font-weight:600;letter-spacing:1.5px;text-transform:uppercase;cursor:pointer;border-radius:2px;white-space:nowrap;transition:all .2s;flex-shrink:0}
.pay-copy-btn:hover{background:var(--amber);color:var(--ink)}
.pay-copy-btn.copied{background:var(--teal);border-color:var(--teal);color:#fff}
.pay-qr{width:130px;height:130px;border:2px dashed rgba(255,255,255,.12);display:flex;flex-direction:column;align-items:center;justify-content:center;margin:12px auto 0;border-radius:4px;font-size:11px;letter-spacing:2px;text-transform:uppercase;color:rgba(255,255,255,.2);text-align:center;gap:6px}
/* Bank block */
.pay-bank-block{background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.08);border-left:3px solid var(--teal);padding:14px;margin-bottom:12px}
.pay-bank-row{display:flex;justify-content:space-between;align-items:center;padding:7px 0;border-bottom:1px solid rgba(255,255,255,.06);font-size:12px}
.pay-bank-row:last-child{border-bottom:none}
.pay-bank-label{color:rgba(255,255,255,.3);letter-spacing:1px;font-size:10px;text-transform:uppercase}
.pay-bank-val{color:#fff;font-weight:500;font-size:13px}
.pay-bank-val.mono{font-family:monospace;color:var(--teal)}
.pay-acc-copy{background:rgba(42,122,110,.15);border:1px solid rgba(42,122,110,.4);color:var(--teal);font-size:10px;letter-spacing:1.5px;text-transform:uppercase;padding:6px 12px;cursor:pointer;border-radius:2px;width:100%;margin-top:8px;transition:all .2s}
.pay-acc-copy:hover{background:var(--teal);color:#fff}
/* Confirm note */
.pay-confirm-note{background:rgba(42,122,110,.1);border:1px solid rgba(42,122,110,.25);padding:12px 14px;margin-top:14px;display:flex;gap:10px;align-items:flex-start;border-radius:2px}
.pay-confirm-note-txt{font-size:12px;font-weight:300;color:rgba(255,255,255,.6);line-height:1.7}
.pay-wa-btn{display:flex;align-items:center;justify-content:center;gap:10px;width:100%;padding:14px;background:#25d366;color:#fff;font-family:var(--headline);font-size:18px;letter-spacing:2px;border:none;cursor:pointer;text-decoration:none;border-radius:2px;margin-top:10px;transition:background .2s}
.pay-wa-btn:hover{background:#1da851}

@media(max-width:680px){.merch-grid{grid-template-columns:repeat(2,1fr);gap:1px;padding:0}.merch-section{padding:8px 0 40px}.mc-img{aspect-ratio:1/1}}
@media(max-width:360px){.merch-grid{grid-template-columns:1fr}}
</style>

<!-- HERO -->
<section class="merch-hero">
  <div class="merch-hero-grid"></div>
  <div style="position:relative;z-index:1">
    <div class="merch-eyebrow">Wear the Journey</div>
    <h1 class="merch-h1">Free<span>Wheel</span><br>Store</h1>
    <p class="merch-sub">Expedition-grade gear for those who drive their own story.</p>
  </div>
</section>

<?php
$products = fw_products();
$cats = array();
foreach ($products as $p) {
    $cat = get_post_meta($p->ID, 'fw_prod_category', true);
    if ($cat && !in_array($cat, $cats)) $cats[] = $cat;
}
$wa_num = '917817838060';
/* payment details served via AJAX - not stored here */
?>

<!-- FILTER BAR -->
<?php if (!empty($cats)): ?>
<div class="filter-bar">
  <button class="filt active" onclick="filterMerch(this,'all')">All</button>
  <?php foreach($cats as $cat): ?>
  <button class="filt" onclick="filterMerch(this,'<?php echo esc_js($cat); ?>')"><?php echo esc_html($cat); ?></button>
  <?php endforeach; ?>
</div>
<?php endif; ?>

<!-- PRODUCT GRID -->
<div class="merch-section">
<div class="merch-grid" id="merchGrid">
<?php if (!empty($products)): foreach ($products as $prod):
    $pid      = $prod->ID;
    $pm       = function($k) use ($pid) { return get_post_meta($pid, $k, true); };
    $name     = get_the_title($pid);
    $price    = (int)$pm('fw_prod_price');
    $orig     = (int)$pm('fw_prod_orig_price');
    $category = $pm('fw_prod_category');
    $stock    = $pm('fw_prod_stock') ?: 'in-stock';
    $desc     = $pm('fw_prod_desc');
    $feature  = $pm('fw_prod_feature');
    $wa_msg   = $pm('fw_prod_wa_msg') ?: 'Hi! I want to order: ' . $name;
    $colors_raw = $pm('fw_prod_colors');
    $sizes_raw  = $pm('fw_prod_sizes');
    $colors = $colors_raw ? array_map('trim', explode(',', $colors_raw)) : array();
    $sizes  = $sizes_raw  ? array_map('trim', explode(',', $sizes_raw))  : array();
    $thumb    = get_the_post_thumbnail_url($pid, 'product-square')
               ?: get_the_post_thumbnail_url($pid, 'full')
               ?: get_the_post_thumbnail_url($pid, 'large')
               ?: get_the_post_thumbnail_url($pid);
    $soldout  = ($stock === 'out-of-stock');
    $discount = ($orig > 0 && $price > 0 && $orig > $price) ? round((1 - $price / $orig) * 100) : 0;
?>
<div class="merch-card" data-cat="<?php echo esc_attr($category); ?>" data-pid="<?php echo $pid; ?>">
  <div class="mc-img">
    <?php if ($stock === 'new-arrival'):   ?><div class="mc-stock-badge badge-new">New</div><?php endif; ?>
    <?php if ($stock === 'limited-stock'): ?><div class="mc-stock-badge badge-limited">⚡ Limited</div><?php endif; ?>
    <?php if ($discount > 0): ?><div class="mc-discount-badge">-<?php echo $discount; ?>%</div><?php endif; ?>
    <?php if ($thumb): ?>
      <img src="<?php echo esc_url($thumb); ?>" alt="<?php echo esc_attr($name); ?>"
           onclick="fwOpenLB('<?php echo esc_js($thumb); ?>','<?php echo esc_js($name); ?>')">
    <?php else: ?>
      <div class="mc-emoji-ph">🎽</div>
    <?php endif; ?>
    <?php if ($soldout): ?>
      <div class="mc-soldout-overlay"><div class="mc-soldout-txt">SOLD OUT</div></div>
    <?php endif; ?>
  </div>

  <div class="mc-body">
    <div class="mc-name"><?php echo esc_html($name); ?></div>
    <?php if ($feature): ?><div class="mc-feature"><?php echo esc_html($feature); ?></div><?php endif; ?>

    <div class="mc-price-block">
      <?php if ($discount > 0): ?><div class="mc-discount-pct"><?php echo $discount; ?>% off</div><?php endif; ?>
      <div class="mc-price-row">
        <?php if ($price > 0): ?>
        <span class="mc-price">₹<?php echo number_format($price); ?></span>
        <?php endif; ?>
        <?php if ($orig > 0): ?>
        <span style="font-size:12px;color:rgba(255,255,255,.65)">M.R.P: <span class="mc-orig">₹<?php echo number_format($orig); ?></span></span>
        <?php endif; ?>
      </div>
    </div>

    <div class="mc-perks">
      <div class="mc-perk reg-off">🏷️ 2% additional off for registered users</div>
      <div class="mc-perk">🚚 Free Delivery</div>
    </div>

    <?php if (!$soldout): ?>
    <?php if (!empty($colors)): ?>
    <div class="mc-variants" id="colors-<?php echo $pid; ?>">
      <div class="mc-var-label">Color: <span class="mc-sel-color" id="selcolor-<?php echo $pid; ?>">—</span></div>
      <div class="mc-swatches">
        <?php
        $swatch_map = array(
          'white'       => '#f5f5f5',
          'black'       => '#1a1a1a',
          'olive'       => '#4a5240',
          'olive green' => '#4a5240',
          'army green'  => '#4a5240',
          'military green'=> '#4a5240',
          'green'       => '#4a5240',
          'navy'        => '#1a2744',
          'grey'        => '#6b7280',
          'gray'        => '#6b7280',
          'red'         => '#c0392b',
          'maroon'      => '#6d1a1a',
          'yellow'      => '#f5c518',
          'orange'      => '#c44b19',
          'blue'        => '#1e40af',
        );
        foreach($colors as $ci => $color):
          $key = strtolower(trim($color));
          $hex = isset($swatch_map[$key]) ? $swatch_map[$key] : '#888';
          $border = ($key === 'white') ? '1px solid #ccc' : '1px solid transparent';
        ?>
        <div class="mc-swatch <?php echo $ci===0?'swatch-active':''; ?>"
             style="background:<?php echo $hex; ?>;border:<?php echo $border; ?>"
             data-color="<?php echo esc_attr($color); ?>"
             data-pid="<?php echo $pid; ?>"
             title="<?php echo esc_attr($color); ?>"
             onclick="fwPickColor(this,<?php echo $pid; ?>)">
          <?php if($ci===0): ?><span class="swatch-check">✓</span><?php endif; ?>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endif; ?>

    <?php if (!empty($sizes)): ?>
    <div class="mc-variants" id="sizes-<?php echo $pid; ?>">
      <div class="mc-var-label">Size: <span class="mc-sel-size" id="selsize-<?php echo $pid; ?>">—</span></div>
      <div class="mc-sizes">
        <?php foreach($sizes as $si => $size): ?>
        <div class="mc-size-btn <?php echo $si===0?'size-active':''; ?>"
             data-size="<?php echo esc_attr($size); ?>"
             data-pid="<?php echo $pid; ?>"
             onclick="fwPickSize(this,<?php echo $pid; ?>)">
          <?php echo esc_html($size); ?>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endif; ?>

    <button class="mc-add-btn" id="addbtn-<?php echo $pid; ?>"
        data-colors="<?php echo esc_attr(implode(',',$colors)); ?>"
        data-sizes="<?php echo esc_attr(implode(',',$sizes)); ?>"
        onclick="fwAddToCartVariant(<?php echo $pid; ?>,'<?php echo esc_js($name); ?>',<?php echo $price; ?>,'<?php echo esc_js($thumb ?: ''); ?>')">
      Add to Cart
    </button>
    <?php else: ?>
    <div class="mc-add-btn mc-soldout-btn">Currently Unavailable</div>
    <?php endif; ?>
  </div>
</div>
<?php endforeach; else: ?>
  <div style="grid-column:1/-1;text-align:center;padding:80px 20px;color:rgba(255,255,255,.4);background:#0a0805">
    <div style="font-size:48px;margin-bottom:16px">🛍️</div>
    <div style="font-size:18px;letter-spacing:2px;text-transform:uppercase">Products Coming Soon</div>
    <p style="margin-top:12px;font-size:13px">Add products from WordPress Admin → 🛍️ Merchandise → Add New Product</p>
  </div>
<?php endif; ?>
</div>
</div>

<!-- CART BUBBLE -->
<div id="fw-cart-bubble" onclick="fwOpenCart()">
  🛒 <span id="fw-cart-count">0</span>
  <span style="font-size:14px">View Cart</span>
</div>

<!-- OVERLAY -->
<div id="fw-cart-overlay" onclick="fwCloseCart()"></div>

<!-- CART DRAWER -->
<div id="fw-cart-drawer">
  <div class="cart-head">
    <div class="cart-head-title">🛒 Your Cart</div>
    <button class="cart-close" onclick="fwCloseCart()">✕</button>
  </div>

  <div class="cart-items" id="fw-cart-items">
    <div class="cart-empty">
      <div style="font-size:48px;margin-bottom:12px">🛒</div>
      <div style="font-size:13px;letter-spacing:2px;text-transform:uppercase">Cart is Empty</div>
    </div>
  </div>

  <div class="cart-footer" id="fw-cart-footer" style="display:none">
    <div class="cart-sum-row"><span>Subtotal</span><span id="fw-subtotal">₹0</span></div>
    <div id="fw-discount-row" class="cart-discount-note" style="display:none">🎉 3+ items: <strong>5% OFF</strong> applied!</div>
    <div class="cart-sum-row" id="fw-discount-line" style="display:none"><span>Discount (5%)</span><span id="fw-discount-amt" style="color:var(--teal)"></span></div>
    <div class="cart-sum-row total"><span>Total</span><span id="fw-total" style="color:var(--amber)">₹0</span></div>

    <!-- Payment tabs -->
    <div class="pay-tabs">
      <button class="pay-tab active" onclick="fwPayTab(this,'rzp')">💳 Pay Online</button>
      <button class="pay-tab" onclick="fwPayTab(this,'upi')">📱 UPI</button>
      <button class="pay-tab" onclick="fwPayTab(this,'bank')">🏦 Bank Transfer</button>
    </div>

    <!-- Razorpay (default) -->
    <div class="pay-panel visible" id="pay-panel-rzp">
      <button id="rzpMerchBtn" onclick="fwCartRzpPay()"
        style="width:100%;padding:14px;background:var(--rust);border:none;color:#fff;font-family:var(--headline);font-size:18px;letter-spacing:2px;cursor:pointer;border-radius:2px;margin-top:8px;transition:background .2s">
        PAY NOW
      </button>
      <div id="rzpMerchMsg" style="font-size:12px;text-align:center;margin-top:8px;min-height:16px"></div>
      <div style="text-align:center;font-size:11px;color:rgba(255,255,255,.3);margin-top:6px">UPI · Cards · NetBanking · Secure via Razorpay</div>
    </div>

    <!-- UPI -->
    <div class="pay-panel" id="pay-panel-upi">
      <div style="background:rgba(255,193,14,.06);border:1px solid rgba(255,193,14,.2);border-left:3px solid var(--amber);border-radius:2px;padding:16px;margin-top:8px;text-align:center">
        <div style="font-size:22px;margin-bottom:8px">🔧</div>
        <div style="font-size:13px;font-weight:700;color:var(--amber);letter-spacing:1px;margin-bottom:6px">UPI INTEGRATION COMING SOON</div>
        <div style="font-size:12px;color:rgba(255,255,255,.5);line-height:1.6">We're setting up seamless UPI payments.<br>Meanwhile, please use <strong style="color:#fff">Pay Online</strong> (cards / NetBanking) or <strong style="color:#fff">Bank Transfer</strong>.</div>
      </div>
    </div>

    <!-- Bank -->
    <div class="pay-panel" id="pay-panel-bank">
      <div class="pay-bank-block">
        <div class="pay-bank-row"><span class="pay-bank-label">Account Name</span><span class="pay-bank-val">FreeWheel Expeditions</span></div>
        <div class="pay-bank-row"><span class="pay-bank-label">Account No.</span><span class="pay-bank-val mono" id="fw-acc-num">••••••••••••</span></div>
        <div class="pay-bank-row"><span class="pay-bank-label">IFSC Code</span><span class="pay-bank-val mono" id="fw-acc-ifsc">••••••••</span></div>
        <div class="pay-bank-row"><span class="pay-bank-label">Bank</span><span class="pay-bank-val" id="fw-acc-bank">loading...</span></div>
        <div class="pay-bank-row"><span class="pay-bank-label">Type</span><span class="pay-bank-val">Current Account</span></div>
      </div>
      <button class="pay-acc-copy" id="fw-acc-copy-btn" onclick="fwCopyAcc()">Copy Account Number</button>
    </div>

    <div class="pay-confirm-note">
      <span style="font-size:18px;flex-shrink:0">✅</span>
      <div class="pay-confirm-note-txt">After payment, <strong style="color:#fff">WhatsApp us your receipt</strong> with your name & order. We confirm within 2 hours.<br>
        <span style="font-size:11px;color:rgba(255,255,255,.3)">+91 78178 38060 · +91 78382 95852</span>
      </div>
    </div>
    <a id="fw-wa-confirm" href="#" target="_blank" class="pay-wa-btn">📲 Share Receipt on WhatsApp</a>
  </div>
</div>

<?php wp_nonce_field('fw_payment_nonce', 'fw_pay_nonce'); ?>
<!-- LIGHTBOX -->
<div id="fw-lb" onclick="if(event.target===this)fwCloseLB()">
  <button id="fw-lb-close" onclick="fwCloseLB()">✕</button>
  <img id="fw-lb-img" src="" alt="">
  <div id="fw-lb-name"></div>
</div>

<script>
var FW_CART = {};
var FW_WA   = '<?php echo esc_js($wa_num); ?>';

function fwOpenLB(src,name){
  document.getElementById('fw-lb-img').src=src;
  document.getElementById('fw-lb-name').textContent=name;
  document.getElementById('fw-lb').classList.add('open');
  document.body.style.overflow='hidden';
}
function fwCloseLB(){
  document.getElementById('fw-lb').classList.remove('open');
  document.body.style.overflow='';
}
document.addEventListener('keydown',function(e){if(e.key==='Escape')fwCloseLB();});
document.addEventListener('DOMContentLoaded',function(){
  // Auto-select first color swatch and first size button for each product
  document.querySelectorAll('.mc-swatch:first-child').forEach(function(s){
    var pid = s.getAttribute('data-pid');
    if(pid) fwPickColor(s, pid);
  });
  document.querySelectorAll('.mc-size-btn:first-child').forEach(function(s){
    var pid = s.getAttribute('data-pid');
    if(pid) fwPickSize(s, pid);
  });
});

function fwPickColor(el, pid) {
  var wrap = document.getElementById('colors-' + pid);
  wrap.querySelectorAll('.mc-swatch').forEach(function(s){ s.classList.remove('swatch-active'); s.innerHTML=''; });
  el.classList.add('swatch-active');
  el.innerHTML = '<span class="swatch-check">✓</span>';
  var lbl = document.getElementById('selcolor-' + pid);
  if(lbl) lbl.textContent = el.getAttribute('data-color');
}
function fwPickSize(el, pid) {
  var wrap = document.getElementById('sizes-' + pid);
  wrap.querySelectorAll('.mc-size-btn').forEach(function(s){ s.classList.remove('size-active'); });
  el.classList.add('size-active');
  var lbl = document.getElementById('selsize-' + pid);
  if(lbl) lbl.textContent = el.getAttribute('data-size');
}
function fwAddToCartVariant(pid, name, price, thumb) {
  var colorEl = document.querySelector('#colors-' + pid + ' .swatch-active');
  var sizeEl  = document.querySelector('#sizes-'  + pid + ' .size-active');
  var hasColors = document.getElementById('colors-' + pid);
  var hasSizes  = document.getElementById('sizes-'  + pid);
  var color = colorEl ? colorEl.getAttribute('data-color') : '';
  var size  = sizeEl  ? sizeEl.getAttribute('data-size')   : '';
  if (hasColors && !color) { alert('Please select a color first'); return; }
  if (hasSizes  && !size)  { alert('Please select a size first');  return; }
  fwAddToCart(pid, name, price, thumb, color, size);
}
function fwAddToCart(pid, name, price, thumb, color, size) {
  color = color || ''; size = size || '';
  if (FW_CART[pid]) { FW_CART[pid].qty++; }
  else {
    FW_CART[pid] = {name:name, price:price, qty:1, thumb:thumb, color:color, size:size};
    var btn = document.getElementById('addbtn-'+pid);
    if (btn) { btn.textContent = '✅ Added'; btn.classList.add('in-cart'); }
  }
  fwRenderCart();
  fwShowAddedToast(name);
}

function fwRemove(pid) {
  delete FW_CART[pid];
  var btn = document.getElementById('addbtn-'+pid);
  if (btn) { btn.textContent = 'Add to Cart'; btn.classList.remove('in-cart'); }
  fwRenderCart();
}

function fwQty(pid, d) {
  if (!FW_CART[pid]) return;
  FW_CART[pid].qty += d;
  if (FW_CART[pid].qty <= 0) { fwRemove(pid); return; }
  fwRenderCart();
}

function fwRenderCart() {
  var keys   = Object.keys(FW_CART);
  var bubble = document.getElementById('fw-cart-bubble');
  var itemsEl= document.getElementById('fw-cart-items');
  var footer = document.getElementById('fw-cart-footer');
  var totalQty = keys.reduce(function(s,k){return s+FW_CART[k].qty;},0);
  document.getElementById('fw-cart-count').textContent = totalQty;

  if (!keys.length) {
    bubble.style.display='none';
    itemsEl.innerHTML='<div class="cart-empty"><div style="font-size:48px;margin-bottom:12px">🛒</div><div style="font-size:13px;letter-spacing:2px;text-transform:uppercase">Cart is Empty</div></div>';
    footer.style.display='none';
    return;
  }
  bubble.style.display='flex';
  footer.style.display='block';
  fwLoadPaymentDetails();

  var html='';
  keys.forEach(function(pid){
    var it=FW_CART[pid];
    var img=it.thumb?'<img src="'+it.thumb+'" class="cart-item-img" alt="">':'<div class="cart-item-img-ph">🎽</div>';
    html+='<div class="cart-item">'+img+
      '<div><div class="cart-item-name">'+it.name+'</div><div class="cart-item-price">₹'+(it.price*it.qty).toLocaleString('en-IN')+'</div></div>'+
      '<div class="cart-qty">'+
        '<button class="cart-qty-btn" onclick="fwQty('+pid+',-1)">−</button>'+
        '<div class="cart-qty-num">'+it.qty+'</div>'+
        '<button class="cart-qty-btn" onclick="fwQty('+pid+',1)">+</button>'+
        '<button class="cart-qty-btn" onclick="fwRemove('+pid+')" style="border-color:rgba(231,76,60,.3);color:rgba(231,76,60,.7);margin-left:4px">🗑</button>'+
      '</div></div>';
  });
  itemsEl.innerHTML=html;

  var sub  = keys.reduce(function(s,k){return s+FW_CART[k].price*FW_CART[k].qty;},0);
  var disc = totalQty>=3 ? Math.round(sub*.05) : 0;
  var total= sub-disc;
  document.getElementById('fw-subtotal').textContent='₹'+sub.toLocaleString('en-IN');
  document.getElementById('fw-total').textContent='₹'+total.toLocaleString('en-IN');
  document.getElementById('fw-discount-row').style.display=disc?'block':'none';
  document.getElementById('fw-discount-line').style.display=disc?'flex':'none';
  if(disc) document.getElementById('fw-discount-amt').textContent='−₹'+disc.toLocaleString('en-IN');

  var lines=['Hi FreeWheel! Here is my order:\n'];
  var n=1;
  keys.forEach(function(pid){var it=FW_CART[pid];var v='';if(it.color)v+=' | Color: '+it.color;if(it.size)v+=' | Size: '+it.size;lines.push(n+++'. '+it.name+v+' × '+it.qty+' = ₹'+(it.price*it.qty).toLocaleString('en-IN'));});
  if(disc) lines.push('\n5% discount (3+ items): −₹'+disc.toLocaleString('en-IN'));
  lines.push('\n*Total: ₹'+total.toLocaleString('en-IN')+'*');
  lines.push('\nPayment done. Receipt attached.');
  document.getElementById('fw-wa-confirm').href='https://wa.me/'+FW_WA+'?text='+encodeURIComponent(lines.join('\n'));
}

function fwShowAddedToast(name) {
  var t = document.getElementById('fw-added-toast');
  if (!t) {
    t = document.createElement('div');
    t.id = 'fw-added-toast';
    t.style.cssText = 'position:fixed;bottom:100px;right:28px;z-index:1400;background:#1a3c34;border:1px solid var(--teal,#2a7a6e);color:#fff;font-family:var(--body);font-size:13px;padding:10px 16px;border-radius:3px;box-shadow:0 4px 20px rgba(0,0,0,.4);transition:opacity .3s,transform .3s;opacity:0;transform:translateY(8px);pointer-events:none;max-width:220px;line-height:1.4';
    document.body.appendChild(t);
  }
  var short = name.length > 28 ? name.slice(0, 26) + '…' : name;
  t.textContent = '✅ ' + short + ' added!';
  t.style.opacity = '1'; t.style.transform = 'translateY(0)';
  clearTimeout(t._timer);
  t._timer = setTimeout(function(){ t.style.opacity='0'; t.style.transform='translateY(8px)'; }, 2000);
}

function fwOpenCart(){ document.getElementById('fw-cart-drawer').classList.add('open');document.getElementById('fw-cart-overlay').classList.add('open');document.body.style.overflow='hidden'; }
function fwCloseCart(){ document.getElementById('fw-cart-drawer').classList.remove('open');document.getElementById('fw-cart-overlay').classList.remove('open');document.body.style.overflow=''; }

function fwLoadPaymentDetails(){
  /* Only load payment details for logged-in users */
  var session=null;
  try{session=JSON.parse(localStorage.getItem('fw_session')||'null');}catch(e){}
  if(!session||!session.access_token||session.expires_at<Date.now()){
    /* Show login prompt instead of bank details */
    var panels=['fw-upi-id-txt','fw-acc-num','fw-acc-ifsc','fw-acc-bank'];
    panels.forEach(function(id){var el=document.getElementById(id);if(el)el.textContent='Log in to view';});
    var bankBlock=document.querySelector('#pay-panel-bank .pay-bank-block');
    if(bankBlock){bankBlock.insertAdjacentHTML('beforebegin','<div style="padding:12px;background:rgba(193,68,14,.1);border:1px solid rgba(193,68,14,.3);border-radius:2px;font-size:13px;color:rgba(255,255,255,.7);margin-bottom:12px;text-align:center">Please <a href="'+(window.FW_AUTH?window.FW_AUTH.login_url:'/login/')+'?redirect='+encodeURIComponent(window.location.href)+'" style="color:var(--rust)">log in</a> to view payment details.</div>');}
    return;
  }
  var nonce=document.getElementById('fw_pay_nonce');
  if(!nonce)return;
  fetch(window.FW_AJAX_URL,{
    method:'POST',
    headers:{'Content-Type':'application/x-www-form-urlencoded'},
    body:new URLSearchParams({action:'fw_get_payment',nonce:nonce.value,has_items:'1'})
  })
  .then(function(r){return r.json();})
  .then(function(res){
    if(!res.success)return;
    var d=res.data;
    var upiEl=document.getElementById('fw-upi-id-txt');
    var accEl=document.getElementById('fw-acc-num');
    var ifscEl=document.getElementById('fw-acc-ifsc');
    var bankEl=document.getElementById('fw-acc-bank');
    if(upiEl)upiEl.textContent=d.upi;
    if(accEl)accEl.textContent=d.acc_num;
    if(ifscEl)ifscEl.textContent=d.ifsc;
    if(bankEl)bankEl.textContent=d.bank;
  })
  .catch(function(e){console.warn('Payment load failed',e);});
}
function fwCopyUPI(){
  var txt=document.getElementById('fw-upi-id-txt').textContent;
  if(txt==='loading...'||txt.includes('•'))return;
  navigator.clipboard.writeText(txt);
  var b=document.getElementById('fw-upi-copy-btn');
  b.textContent='Copied!';b.classList.add('copied');
  setTimeout(function(){b.textContent='Copy ID';b.classList.remove('copied');},2000);
}
function fwCopyAcc(){
  var txt=document.getElementById('fw-acc-num').textContent;
  if(txt==='loading...'||txt.includes('•'))return;
  navigator.clipboard.writeText(txt);
  var b=document.getElementById('fw-acc-copy-btn');
  b.textContent='Copied!';
  setTimeout(function(){b.textContent='Copy Account Number';},2000);
}
function fwPayTab(btn,id){
  document.querySelectorAll('.pay-tab').forEach(function(t){t.classList.remove('active');});
  document.querySelectorAll('.pay-panel').forEach(function(p){p.classList.remove('visible');});
  btn.classList.add('active');
  document.getElementById('pay-panel-'+id).classList.add('visible');
}

async function fwCartRzpPay(){
  if(typeof Razorpay === 'undefined'){
    var msg=document.getElementById('rzpMerchMsg');
    if(msg){msg.textContent='Razorpay payment is being integrated. Please use Bank Transfer or UPI for now.';msg.style.color='#f59e0b';}
    return;
  }
  var btn=document.getElementById('rzpMerchBtn');
  var msg=document.getElementById('rzpMerchMsg');
  msg.textContent=''; msg.style.color='#f87171';

  // Build cart total
  var total=0;
  var cartDesc=[];
  Object.values(FW_CART).forEach(function(item){
    total+=item.price*item.qty;
    cartDesc.push(item.name+(item.size?' ('+item.size+')':'')+'×'+item.qty);
  });
  if(total<=0){msg.textContent='Your cart is empty.';return;}

  // Apply 5% discount if 3+ items
  var totalQty=Object.values(FW_CART).reduce(function(s,i){return s+i.qty;},0);
  if(totalQty>=3) total=Math.round(total*0.95);

  // Check login
  var session=null;
  try{session=JSON.parse(localStorage.getItem('fw_session')||'null');}catch(e){}
  if(!session||!session.access_token||session.expires_at<Date.now()){
    msg.textContent='Please log in to purchase.';
    setTimeout(function(){window.location.href=(window.FW_AUTH?window.FW_AUTH.login_url:'/login/')+'?redirect='+encodeURIComponent(window.location.href);},1200);
    return;
  }
  if(!window.FW_RZP_KEY){msg.textContent='Payment gateway not configured.';return;}

  btn.disabled=true; btn.textContent='Creating order…';
  var amountPaise=total*100;
  var descStr=cartDesc.join(', ');
  var firstItem=Object.keys(FW_CART)[0]||'';

  try{
    var or=await fetch((window.FW_AUTH?window.FW_AUTH.rest_url:'/wp-json/freewheel/v1')+'/rzp-create-order',{
      method:'POST',
      headers:{'Content-Type':'application/json','Authorization':'Bearer '+session.access_token},
      body:JSON.stringify({amount:amountPaise,type:'merchandise',ref_id:firstItem,note:descStr})
    });
    var od=await or.json();
    if(!or.ok) throw new Error(od.message||'Order creation failed.');

    var rzp=new Razorpay({
      key:window.FW_RZP_KEY,
      amount:od.amount,
      currency:od.currency,
      name:'FreeWheel Expeditions',
      description:'Merchandise: '+descStr.substring(0,100),
      order_id:od.order_id,
      prefill:{email:session.email,name:session.first_name||''},
      theme:{color:'#c1440e'},
      modal:{ondismiss:function(){btn.disabled=false;btn.textContent='PAY NOW';}},
      handler:async function(r){
        btn.textContent='Verifying…';
        try{
          var vr=await fetch((window.FW_AUTH?window.FW_AUTH.rest_url:'/wp-json/freewheel/v1')+'/rzp-verify-payment',{
            method:'POST',
            headers:{'Content-Type':'application/json','Authorization':'Bearer '+session.access_token},
            body:JSON.stringify({
              razorpay_order_id:r.razorpay_order_id,
              razorpay_payment_id:r.razorpay_payment_id,
              razorpay_signature:r.razorpay_signature,
              type:'merchandise',ref_id:firstItem,
              amount:amountPaise,product_name:descStr,size:''
            })
          });
          var vd=await vr.json();
          if(!vr.ok) throw new Error(vd.message||'Verification failed.');
          btn.style.background='#16a34a'; btn.textContent='✓ ORDER PLACED!';
          msg.textContent=vd.message||'Order placed! We\'ll ship within 3–5 days.'; msg.style.color='#4ade80';
          FW_CART={};fwRenderCart();
          setTimeout(function(){fwCloseCart();},3000);
        }catch(err){
          msg.textContent='Payment received. Contact support with ID: '+r.razorpay_payment_id;
          btn.disabled=false; btn.textContent='PAY NOW';
        }
      }
    });
    rzp.on('payment.failed',function(resp){
      msg.textContent='Payment failed: '+(resp.error.description||'Please try again.');
      btn.disabled=false; btn.textContent='PAY NOW';
    });
    rzp.open();
  }catch(err){
    msg.textContent=err.message||'Something went wrong.';
    btn.disabled=false; btn.textContent='PAY NOW';
  }
}
function filterMerch(btn,cat){
  document.querySelectorAll('.filt').forEach(function(b){b.classList.remove('active');});
  btn.classList.add('active');
  document.querySelectorAll('.merch-card').forEach(function(c){c.classList.toggle('hidden',cat!=='all'&&c.dataset.cat!==cat);});
}
</script>

<?php get_footer(); ?>
