<?php
/**
 * Template Name: Refund Policy
 * Template Post Type: page
 */
get_header(); ?>
<style>
html,body,body.page,#page,#content,#primary,#main,.site,.site-content,.entry-content,.wp-site-blocks,main,article{background:#0f0d0b!important;color:#fff!important}
.entry-content,.page-content,#primary,#main,main{padding:0!important;margin:0!important;max-width:100%!important;width:100%!important}
.site-header,.wp-block-template-part[class*="header"]{display:none!important}
a{color:inherit}
:root{--rust:#c1440e;--amber:#e8a020;--teal:#2a7a6e;--headline:'Bebas Neue',Impact,sans-serif;--body:'Barlow',sans-serif}

.pol-hero{background:linear-gradient(160deg,#0a0805 0%,#1a0c07 60%,#0f0d0b 100%);padding:100px 5vw 56px;border-bottom:1px solid rgba(193,68,14,.2);position:relative;overflow:hidden;text-align:center}
.pol-hero::before{content:'';position:absolute;top:-80px;right:-80px;width:400px;height:400px;border-radius:50%;background:radial-gradient(circle,rgba(193,68,14,.08) 0%,transparent 70%);pointer-events:none}
.pol-eyebrow{font-size:11px;letter-spacing:4px;text-transform:uppercase;color:var(--rust);margin-bottom:14px;display:flex;align-items:center;gap:10px;justify-content:center}
.pol-eyebrow span{display:inline-block;width:28px;height:1px;background:var(--rust)}
.pol-hero h1{font-family:var(--headline);font-size:clamp(44px,7vw,80px);color:#fff;letter-spacing:2px;line-height:1;margin:0 0 14px}
.pol-hero-sub{font-size:14px;color:rgba(255,255,255,.4);font-weight:300;letter-spacing:.5px}

.pol-wrap{max-width:820px;margin:0 auto;padding:56px 24px 96px}

.ref-grid{display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:48px}
@media(max-width:600px){.ref-grid{grid-template-columns:1fr}}
.ref-card{padding:28px 24px;border:1px solid rgba(255,255,255,.08);border-radius:2px;position:relative;overflow:hidden}
.ref-card.green{border-color:rgba(42,122,110,.4);background:rgba(42,122,110,.06)}
.ref-card.red{border-color:rgba(193,68,14,.3);background:rgba(193,68,14,.05)}
.ref-card-label{font-size:10px;letter-spacing:3px;text-transform:uppercase;margin-bottom:12px;font-weight:600}
.ref-card.green .ref-card-label{color:#4ade80}
.ref-card.red .ref-card-label{color:var(--rust)}
.ref-card-title{font-family:var(--headline);font-size:clamp(28px,4vw,42px);line-height:1;margin-bottom:8px}
.ref-card.green .ref-card-title{color:#4ade80}
.ref-card.red .ref-card-title{color:var(--rust)}
.ref-card-desc{font-size:14px;color:rgba(255,255,255,.55);font-weight:300;line-height:1.6}

.pol-section{margin-bottom:48px;padding-bottom:48px;border-bottom:1px solid rgba(255,255,255,.06)}
.pol-section:last-child{border-bottom:none}
.pol-section-num{font-size:10px;letter-spacing:3px;text-transform:uppercase;color:var(--rust);margin-bottom:8px;display:block}
.pol-section h2{font-family:var(--headline);font-size:clamp(26px,4vw,36px);color:#fff;letter-spacing:1px;margin:0 0 20px;line-height:1.1}
.pol-section p{font-size:15px;line-height:1.85;color:rgba(255,255,255,.7);margin:0 0 16px;font-weight:300}
.pol-section p:last-child{margin-bottom:0}
.pol-section ul,.pol-section ol{padding-left:20px;margin:0 0 16px}
.pol-section li{font-size:15px;line-height:1.8;color:rgba(255,255,255,.7);margin-bottom:8px;font-weight:300}
.pol-section strong{color:#fff;font-weight:600}

.pol-warning{background:rgba(193,68,14,.08);border:1px solid rgba(193,68,14,.3);border-left:4px solid var(--rust);padding:20px 24px;margin:24px 0;border-radius:0 2px 2px 0}
.pol-warning p{color:rgba(255,255,255,.85)!important;margin:0!important;font-size:14px!important}

.ref-timeline{display:flex;flex-direction:column;gap:0;margin:24px 0}
.ref-tl-item{display:flex;gap:20px;padding-bottom:28px;position:relative}
.ref-tl-item:last-child{padding-bottom:0}
.ref-tl-item:not(:last-child)::before{content:'';position:absolute;left:19px;top:40px;bottom:0;width:1px;background:rgba(255,255,255,.1)}
.ref-tl-dot{width:40px;height:40px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:16px;flex-shrink:0;border:1px solid}
.ref-tl-dot.ok{background:rgba(42,122,110,.15);border-color:rgba(42,122,110,.4)}
.ref-tl-dot.no{background:rgba(193,68,14,.12);border-color:rgba(193,68,14,.35)}
.ref-tl-dot.maybe{background:rgba(232,160,32,.1);border-color:rgba(232,160,32,.35)}
.ref-tl-content{padding-top:8px}
.ref-tl-label{font-size:11px;letter-spacing:2px;text-transform:uppercase;margin-bottom:4px;font-weight:600}
.ref-tl-label.ok{color:#4ade80}
.ref-tl-label.no{color:var(--rust)}
.ref-tl-label.maybe{color:var(--amber)}
.ref-tl-text{font-size:14px;color:rgba(255,255,255,.6);font-weight:300;line-height:1.6}

.pol-updated{text-align:center;padding:32px 24px;border-top:1px solid rgba(255,255,255,.06);font-size:12px;color:rgba(255,255,255,.2);letter-spacing:1px;text-transform:uppercase}
</style>

<div class="pol-hero">
  <div class="pol-eyebrow"><span></span> Legal <span></span></div>
  <h1>Refund<br>Policy</h1>
  <p class="pol-hero-sub">Last updated: <?php echo date('F Y'); ?> &nbsp;·&nbsp; Read alongside our Terms & Conditions</p>
</div>

<div class="pol-wrap">

  <div class="ref-grid">
    <div class="ref-card green">
      <div class="ref-card-label">Full Refund</div>
      <div class="ref-card-title">30+ Days</div>
      <div class="ref-card-desc">Cancel more than 30 days before departure — 100% of amount paid is refunded</div>
    </div>
    <div class="ref-card red">
      <div class="ref-card-label">No Refund</div>
      <div class="ref-card-title">&lt; 30 Days</div>
      <div class="ref-card-desc">Cancel within 30 days of departure — no refund for any reason</div>
    </div>
  </div>

  <div class="pol-section">
    <span class="pol-section-num">01</span>
    <h2>Cancellation Timeline</h2>
    <div class="ref-timeline">
      <div class="ref-tl-item">
        <div class="ref-tl-dot ok">✓</div>
        <div class="ref-tl-content">
          <div class="ref-tl-label ok">More than 30 days before departure — Full Refund</div>
          <div class="ref-tl-text">100% of the amount paid is refunded to the original payment method. Processing takes 7–10 business days from the date FreeWheel confirms the cancellation in writing.</div>
        </div>
      </div>
      <div class="ref-tl-item">
        <div class="ref-tl-dot no">✕</div>
        <div class="ref-tl-content">
          <div class="ref-tl-label no">30 days or fewer before departure — No Refund</div>
          <div class="ref-tl-text">No refund is payable regardless of the reason — including personal illness, family emergency, vehicle breakdown, inability to travel, or change of plans. FreeWheel strongly recommends trip cancellation insurance to cover this eventuality.</div>
        </div>
      </div>
      <div class="ref-tl-item">
        <div class="ref-tl-dot no">✕</div>
        <div class="ref-tl-content">
          <div class="ref-tl-label no">No-show — No Refund</div>
          <div class="ref-tl-text">Failure to appear at the expedition starting point on the scheduled date without prior written cancellation is treated as a no-show. No refund is payable.</div>
        </div>
      </div>
      <div class="ref-tl-item">
        <div class="ref-tl-dot maybe">↺</div>
        <div class="ref-tl-content">
          <div class="ref-tl-label maybe">Mid-expedition exit — No Refund</div>
          <div class="ref-tl-text">If you leave an expedition early for any reason — including health, personal choice, vehicle issues, or removal due to conduct — no refund is payable for the unused portion of the expedition. Return travel costs are your own responsibility.</div>
        </div>
      </div>
    </div>
  </div>

  <div class="pol-section">
    <span class="pol-section-num">02</span>
    <h2>Partial Payment Bookings</h2>
    <p>Where you have paid a deposit (partial payment), the same 30-day rule applies to the total booking value:</p>
    <ul>
      <li><strong>Cancel more than 30 days before departure:</strong> Your deposit is refunded in full</li>
      <li><strong>Cancel 30 days or fewer before departure:</strong> Your deposit is forfeited. If the balance has also been paid, the entire amount is forfeited.</li>
      <li><strong>Balance not paid by 30 days before departure:</strong> FreeWheel may treat this as a cancellation at its discretion, with the deposit forfeited</li>
    </ul>
  </div>

  <div class="pol-section">
    <span class="pol-section-num">03</span>
    <h2>Cancellation by FreeWheel</h2>
    <p>If FreeWheel cancels an expedition for reasons within its control (insufficient participants, operational issues):</p>
    <ul>
      <li>Participants will first be offered transfer to another available expedition date</li>
      <li>If no alternative is acceptable, a <strong>full refund</strong> of amount paid will be processed within 10 business days</li>
    </ul>
    <p>If FreeWheel cancels due to <strong>force majeure</strong> — including natural disasters, government orders, road closures, extreme weather, civil unrest, or any event beyond FreeWheel's reasonable control — participants will be offered a credit note or a rescheduled expedition date. A cash refund is not guaranteed in force majeure situations.</p>
    <div class="pol-warning">
      <p>FreeWheel is <strong>not liable for any consequential costs</strong> you may have incurred in preparation for the expedition — including flights, accommodation bookings, equipment purchased, leave taken, or any other expenses — in the event of a cancellation for any reason.</p>
    </div>
  </div>

  <div class="pol-section">
    <span class="pol-section-num">04</span>
    <h2>How to Request a Refund</h2>
    <p>All cancellation and refund requests must be submitted in writing. Verbal requests are not accepted.</p>
    <ol>
      <li>Email <strong>hello@freewheelexpeditions.in</strong> with the subject line: <em>"Cancellation Request — [Your Name] — [Expedition Name] — [Date]"</em></li>
      <li>Or message <strong>+91 78178 38060</strong> via WhatsApp with the same details</li>
      <li>FreeWheel will acknowledge your request within 2 business days</li>
      <li>If eligible, the refund will be processed to the original payment source within 7–10 business days of acknowledgement</li>
    </ol>
    <p>The cancellation date is the date on which FreeWheel receives and acknowledges your written request — not the date you attempt to contact us.</p>
  </div>

  <div class="pol-section">
    <span class="pol-section-num">05</span>
    <h2>Transfers & Rescheduling</h2>
    <p>Transferring your booking to a different expedition date or to another person may be considered at FreeWheel's discretion, subject to availability and a transfer fee if applicable. This is not a right and FreeWheel is not obligated to accommodate such requests.</p>
    <p>All transfer requests must be made in writing at least 30 days before the original departure date.</p>
  </div>

  <div class="pol-section">
    <span class="pol-section-num">06</span>
    <h2>Payment Method & Currency</h2>
    <p>All payments are in Indian Rupees (INR) and processed via Razorpay. Approved refunds are issued back to the original payment method (card, UPI, or bank account) through Razorpay automatically — we never handle your payment details directly. FreeWheel is not responsible for delays caused by your bank or card issuer once a refund has been initiated.</p>
    <p>For international participants, currency conversion differences are not refunded. Refunds are made in INR only.</p>
  </div>

</div>

<div class="pol-updated">© <?php echo date('Y'); ?> FreeWheel Expeditions · All Rights Reserved · Haldwani, Uttarakhand, India</div>

<?php get_footer(); ?>
