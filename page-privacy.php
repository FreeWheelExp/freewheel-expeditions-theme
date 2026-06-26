<?php
/**
 * Template Name: Privacy Policy
 * Template Post Type: page
 */
get_header(); ?>
<style>
html,body,body.page,#page,#content,#primary,#main,.site,.site-content,.entry-content,.wp-site-blocks,main,article{background:#0f0d0b!important;color:#fff!important}
.entry-content,.page-content,#primary,#main,main{padding:0!important;margin:0!important;max-width:100%!important;width:100%!important}
.site-header,.wp-block-template-part[class*="header"]{display:none!important}
a{color:inherit}
:root{--rust:#c1440e;--amber:#e8a020;--headline:'Bebas Neue',Impact,sans-serif;--body:'Barlow',sans-serif}

.pol-hero{background:linear-gradient(160deg,#0a0805 0%,#1a0c07 60%,#0f0d0b 100%);padding:100px 5vw 56px;border-bottom:1px solid rgba(193,68,14,.2);position:relative;overflow:hidden;text-align:center}
.pol-hero::before{content:'';position:absolute;top:-80px;right:-80px;width:400px;height:400px;border-radius:50%;background:radial-gradient(circle,rgba(193,68,14,.08) 0%,transparent 70%);pointer-events:none}
.pol-eyebrow{font-size:11px;letter-spacing:4px;text-transform:uppercase;color:var(--rust);margin-bottom:14px;display:flex;align-items:center;gap:10px;justify-content:center}
.pol-eyebrow span{display:inline-block;width:28px;height:1px;background:var(--rust)}
.pol-hero h1{font-family:var(--headline);font-size:clamp(44px,7vw,80px);color:#fff;letter-spacing:2px;line-height:1;margin:0 0 14px}
.pol-hero-sub{font-size:14px;color:rgba(255,255,255,.4);font-weight:300;letter-spacing:.5px}

.pol-wrap{max-width:820px;margin:0 auto;padding:56px 24px 96px}
.pol-section{margin-bottom:48px;padding-bottom:48px;border-bottom:1px solid rgba(255,255,255,.06)}
.pol-section:last-child{border-bottom:none}
.pol-section-num{font-size:10px;letter-spacing:3px;text-transform:uppercase;color:var(--rust);margin-bottom:8px;display:block}
.pol-section h2{font-family:var(--headline);font-size:clamp(26px,4vw,36px);color:#fff;letter-spacing:1px;margin:0 0 20px;line-height:1.1}
.pol-section p{font-size:15px;line-height:1.85;color:rgba(255,255,255,.7);margin:0 0 16px;font-weight:300}
.pol-section p:last-child{margin-bottom:0}
.pol-section ul,.pol-section ol{padding-left:20px;margin:0 0 16px}
.pol-section li{font-size:15px;line-height:1.8;color:rgba(255,255,255,.7);margin-bottom:8px;font-weight:300}
.pol-section strong{color:#fff;font-weight:600}

.priv-table{width:100%;border-collapse:collapse;margin:20px 0;font-size:14px}
.priv-table th{text-align:left;padding:10px 14px;font-size:10px;letter-spacing:2px;text-transform:uppercase;color:var(--rust);font-weight:600;border-bottom:1px solid rgba(193,68,14,.3);font-family:var(--body)}
.priv-table td{padding:12px 14px;border-bottom:1px solid rgba(255,255,255,.05);color:rgba(255,255,255,.65);vertical-align:top;line-height:1.6}
.priv-table tr:last-child td{border-bottom:none}
.priv-table td:first-child{color:#fff;font-weight:500;white-space:nowrap;width:35%}

.pol-updated{text-align:center;padding:32px 24px;border-top:1px solid rgba(255,255,255,.06);font-size:12px;color:rgba(255,255,255,.2);letter-spacing:1px;text-transform:uppercase}
</style>

<div class="pol-hero">
  <div class="pol-eyebrow"><span></span> Legal <span></span></div>
  <h1>Privacy<br>Policy</h1>
  <p class="pol-hero-sub">Last updated: <?php echo date('F Y'); ?> &nbsp;·&nbsp; FreeWheel Expeditions, Haldwani, Uttarakhand</p>
</div>

<div class="pol-wrap">

  <div class="pol-section">
    <span class="pol-section-num">01</span>
    <h2>Who We Are</h2>
    <p><strong>FreeWheel Expeditions</strong> ("FreeWheel", "we", "us", "our") is a proprietorship registered under GST and the applicable Shop and Establishment Act, operating from Haldwani, Uttarakhand, India. We organise self-drive overlanding expeditions and operate the website at <strong>freewheelexpeditions.in</strong>.</p>
    <p>This Privacy Policy explains how we collect, use, store, and protect your personal data when you use our website, register an account, book an expedition, or interact with us in any way. By using our services, you consent to the practices described in this Policy.</p>
    <p>For privacy-related queries, contact us at: <strong>hello@freewheelexpeditions.in</strong></p>
  </div>

  <div class="pol-section">
    <span class="pol-section-num">02</span>
    <h2>Data We Collect</h2>
    <table class="priv-table">
      <thead><tr><th>Data</th><th>How it is collected</th></tr></thead>
      <tbody>
        <tr><td>Full name</td><td>Account registration, booking form, physical participation form</td></tr>
        <tr><td>Email address</td><td>Account registration, newsletter subscription, booking, contact form</td></tr>
        <tr><td>Phone / WhatsApp number</td><td>Account registration, booking form, contact form</td></tr>
        <tr><td>City / location</td><td>Account registration (optional)</td></tr>
        <tr><td>Payment data</td><td>Booking checkout — processed via Razorpay. We receive only the payment confirmation (order ID, payment ID, amount, status); we never see or store your card, UPI, or bank account details — these are handled directly by Razorpay, a PCI-DSS compliant payment gateway</td></tr>
        <tr><td>Vehicle details</td><td>Booking form (type of vehicle, self-drive or seat-sharing)</td></tr>
        <tr><td>Profile photo</td><td>Dashboard — optional, uploaded by you</td></tr>
        <tr><td>Blog content</td><td>Community dashboard — content you voluntarily submit for publication</td></tr>
        <tr><td>Comments</td><td>Blog comment form — name, email, comment text</td></tr>
        <tr><td>Usage data</td><td>Automatically via cookies and server logs — pages visited, time spent, device type, browser, approximate location via IP</td></tr>
        <tr><td>Communications</td><td>Emails and WhatsApp messages you send to us</td></tr>
      </tbody>
    </table>
    <p>We do not collect or store sensitive personal data such as government ID numbers, financial account numbers, passwords (these are managed securely by our authentication system), or health data beyond what you voluntarily share with us in the context of expedition preparation.</p>
  </div>

  <div class="pol-section">
    <span class="pol-section-num">03</span>
    <h2>How We Use Your Data</h2>
    <p>We use the data we collect for the following purposes:</p>
    <ul>
      <li><strong>To process and manage bookings</strong> — confirming participation, payment verification, and expedition logistics</li>
      <li><strong>To operate your account</strong> — authentication, dashboard access, loyalty credits, and booking history</li>
      <li><strong>To communicate with you</strong> — booking confirmations, expedition updates, pre-trip briefings, and post-trip follow-ups via email and WhatsApp</li>
      <li><strong>To send expedition-related updates</strong> — including route changes, weather advisories, and safety information</li>
      <li><strong>To send the FreeWheel newsletter</strong> — if you have subscribed. You may unsubscribe at any time via the link in any newsletter email.</li>
      <li><strong>To publish community content</strong> — blogs you submit (pending admin approval) and comments you post</li>
      <li><strong>To improve our services</strong> — analysing website usage, identifying popular content, and improving the expedition experience</li>
      <li><strong>To comply with legal obligations</strong> — including GST, permit requirements, and any obligations under applicable Indian law</li>
      <li><strong>To protect our rights</strong> — in case of disputes, claims, or legal proceedings</li>
    </ul>
    <p>We do not use your data for automated decision-making or profiling in ways that have a legal or significant effect on you.</p>
  </div>

  <div class="pol-section">
    <span class="pol-section-num">04</span>
    <h2>Data Storage & Third-Party Services</h2>
    <p>Your data is stored and processed using the following third-party services:</p>
    <ul>
      <li><strong>Supabase</strong> (supabase.com) — our primary database and authentication provider. Subscriber data, account data, and booking data is stored on Supabase servers. Supabase is SOC 2 compliant. <a href="https://supabase.com/privacy" target="_blank" rel="noopener noreferrer" style="color:var(--rust)">Supabase Privacy Policy</a></li>
      <li><strong>Razorpay</strong> (razorpay.com) — our payment gateway, used to process all booking and merchandise payments. Razorpay is PCI-DSS compliant and handles your card/UPI/bank details directly — we never receive or store this information. <a href="https://razorpay.com/privacy/" target="_blank" rel="noopener noreferrer" style="color:var(--rust)">Razorpay Privacy Policy</a></li>
      <li><strong>Brevo</strong> (brevo.com) — used to send transactional emails (booking confirmations, OTP verification, welcome emails). Your email address and name are shared with Brevo solely to deliver these emails. <a href="https://www.brevo.com/legal/privacypolicy/" target="_blank" rel="noopener noreferrer" style="color:var(--rust)">Brevo Privacy Policy</a></li>
      <li><strong>WordPress</strong> — our website platform, hosted on a third-party web host. WordPress stores page content, blog posts, comments, and standard WordPress data.</li>
      <li><strong>Fast2SMS</strong> — used to send SMS notifications for booking confirmations. Your phone number may be used to send transaction SMS only.</li>
      <li><strong>Google Analytics</strong> (if active) — anonymous usage analytics. No personally identifiable information is shared with Google Analytics.</li>
      <li><strong>Google Fonts</strong> — fonts are loaded from Google's CDN. Google may log your IP address as part of this request. <a href="https://policies.google.com/privacy" target="_blank" rel="noopener noreferrer" style="color:var(--rust)">Google Privacy Policy</a></li>
    </ul>
    <p>We do not sell, rent, or trade your personal data to any third party for marketing purposes.</p>
  </div>

  <div class="pol-section">
    <span class="pol-section-num">05</span>
    <h2>Cookies</h2>
    <p>Our website uses cookies — small text files stored in your browser — for the following purposes:</p>
    <ul>
      <li><strong>Session management:</strong> Keeping you logged in to your account</li>
      <li><strong>Preferences:</strong> Remembering your settings</li>
      <li><strong>Analytics:</strong> Understanding how the website is used (anonymised)</li>
      <li><strong>WordPress functionality:</strong> Standard WordPress cookies required for the website to function correctly</li>
    </ul>
    <p>You can control cookies through your browser settings. Disabling cookies may affect some website functionality, including account login.</p>
  </div>

  <div class="pol-section">
    <span class="pol-section-num">06</span>
    <h2>Data Retention</h2>
    <p>We retain your personal data for as long as necessary to fulfil the purposes for which it was collected, or as required by applicable law:</p>
    <ul>
      <li><strong>Account data:</strong> Retained while your account is active and for 3 years thereafter</li>
      <li><strong>Booking and payment records:</strong> Retained for 7 years for accounting and legal compliance purposes</li>
      <li><strong>Newsletter subscription data:</strong> Retained until you unsubscribe</li>
      <li><strong>Usage and analytics data:</strong> Retained in anonymised form for up to 24 months</li>
      <li><strong>Communications:</strong> Retained for up to 3 years</li>
    </ul>
    <p>You may request deletion of your account data at any time (see Section 7). However, we may retain certain records as required by law or for the protection of our legal rights.</p>
  </div>

  <div class="pol-section">
    <span class="pol-section-num">07</span>
    <h2>Your Rights</h2>
    <p>Subject to applicable Indian law (including the Digital Personal Data Protection Act, 2023, to the extent applicable), you have the right to:</p>
    <ul>
      <li><strong>Access:</strong> Request a copy of the personal data we hold about you</li>
      <li><strong>Correction:</strong> Request correction of inaccurate or incomplete data</li>
      <li><strong>Deletion:</strong> Request deletion of your personal data, subject to our legal obligations to retain certain records</li>
      <li><strong>Withdraw consent:</strong> Withdraw consent for marketing communications at any time by unsubscribing or contacting us</li>
      <li><strong>Grievance:</strong> Raise a grievance with us regarding the use of your data</li>
    </ul>
    <p>To exercise any of these rights, contact us at <strong>hello@freewheelexpeditions.in</strong>. We will respond within 30 days.</p>
  </div>

  <div class="pol-section">
    <span class="pol-section-num">08</span>
    <h2>Data Security</h2>
    <p>We take reasonable technical and organisational measures to protect your personal data from unauthorised access, loss, misuse, or disclosure. These include:</p>
    <ul>
      <li>HTTPS encryption on all website communications</li>
      <li>Authentication managed by Supabase with industry-standard security</li>
      <li>Sensitive credentials (API keys, database keys) stored server-side only — never in website source code or exposed to browsers</li>
      <li>Access to booking and subscriber data restricted to authorised FreeWheel personnel only</li>
    </ul>
    <p>No method of transmission over the internet is 100% secure. While we take all reasonable steps to protect your data, we cannot guarantee absolute security.</p>
  </div>

  <div class="pol-section">
    <span class="pol-section-num">09</span>
    <h2>Children's Privacy</h2>
    <p>FreeWheel expeditions are restricted to persons aged 18 years and above. We do not knowingly collect personal data from anyone under 18. If you believe a minor has submitted data to us, please contact us immediately at hello@freewheelexpeditions.in and we will delete it.</p>
  </div>

  <div class="pol-section">
    <span class="pol-section-num">10</span>
    <h2>Changes to This Policy</h2>
    <p>We may update this Privacy Policy from time to time. Updates will be published on this page with a revised date. Continued use of our website or services after any change constitutes acceptance of the updated Policy.</p>
  </div>

  <div class="pol-section">
    <span class="pol-section-num">11</span>
    <h2>Contact & Grievance</h2>
    <p>For any questions, requests, or grievances related to this Privacy Policy or the handling of your personal data:</p>
    <ul>
      <li><strong>Email:</strong> hello@freewheelexpeditions.in</li>
      <li><strong>WhatsApp:</strong> +91 78178 38060</li>
      <li><strong>Address:</strong> FreeWheel Expeditions, Haldwani, Uttarakhand, India</li>
    </ul>
    <p>We aim to respond to all privacy-related queries within 30 days.</p>
  </div>

</div>

<div class="pol-updated">© <?php echo date('Y'); ?> FreeWheel Expeditions · All Rights Reserved · Haldwani, Uttarakhand, India</div>

<?php get_footer(); ?>
