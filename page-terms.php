<?php
/**
 * Template Name: Terms and Conditions
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
.pol-toc{background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.08);border-left:3px solid var(--rust);padding:24px 28px;margin-bottom:48px;border-radius:2px}
.pol-toc-title{font-size:11px;letter-spacing:3px;text-transform:uppercase;color:var(--rust);margin-bottom:14px;font-weight:600}
.pol-toc ol{margin:0;padding-left:18px}
.pol-toc li{margin-bottom:6px}
.pol-toc a{font-size:13px;color:rgba(255,255,255,.55);text-decoration:none;letter-spacing:.5px;transition:color .2s}
.pol-toc a:hover{color:var(--amber)}

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
.pol-warning strong{color:var(--amber)!important}

.pol-updated{text-align:center;padding:32px 24px;border-top:1px solid rgba(255,255,255,.06);font-size:12px;color:rgba(255,255,255,.2);letter-spacing:1px;text-transform:uppercase}
</style>

<div class="pol-hero">
  <div class="pol-eyebrow"><span></span> Legal <span></span></div>
  <h1>Terms &<br>Conditions</h1>
  <p class="pol-hero-sub">Last updated: <?php echo date('F Y'); ?> &nbsp;·&nbsp; Governing jurisdiction: Haldwani, Uttarakhand, India</p>
</div>

<div class="pol-wrap">

  <div class="pol-toc">
    <div class="pol-toc-title">Contents</div>
    <ol>
      <li><a href="#acceptance">Acceptance of Terms</a></li>
      <li><a href="#nature">Nature of Expeditions &amp; Inherent Risks</a></li>
      <li><a href="#eligibility">Participant Eligibility</a></li>
      <li><a href="#assumption">Assumption of Risk</a></li>
      <li><a href="#liability">Limitation of Liability</a></li>
      <li><a href="#insurance">Insurance</a></li>
      <li><a href="#medical">Medical Fitness &amp; Health</a></li>
      <li><a href="#booking">Booking &amp; Payment</a></li>
      <li><a href="#cancellation">Cancellation by Participant</a></li>
      <li><a href="#fw-cancellation">Cancellation or Modification by FreeWheel</a></li>
      <li><a href="#conduct">Participant Conduct</a></li>
      <li><a href="#vehicle">Vehicle Requirements</a></li>
      <li><a href="#indemnity">Indemnification</a></li>
      <li><a href="#force-majeure">Force Majeure</a></li>
      <li><a href="#governing-law">Governing Law &amp; Dispute Resolution</a></li>
      <li><a href="#contact">Contact</a></li>
    </ol>
  </div>

  <div class="pol-section" id="acceptance">
    <span class="pol-section-num">01</span>
    <h2>Acceptance of Terms</h2>
    <p>By registering for, booking, or participating in any expedition, event, convoy, or activity organised by <strong>FreeWheel Expeditions</strong> ("FreeWheel", "we", "us", "our") — a proprietorship registered under GST and the applicable Shop and Establishment Act, operating from Haldwani, Uttarakhand — you ("Participant", "you") unconditionally agree to be bound by these Terms and Conditions in their entirety.</p>
    <p>These Terms apply to all interactions with FreeWheel including but not limited to: website use, booking, payment, expedition participation, community membership, and merchandise purchase. If you do not agree to any part of these Terms, you must not register or participate.</p>
    <p>These Terms are in addition to, and not in substitution of, any physical participation form or waiver you sign prior to an expedition. In the event of a conflict, the signed physical form shall prevail.</p>
  </div>

  <div class="pol-section" id="nature">
    <span class="pol-section-num">02</span>
    <h2>Nature of Expeditions & Inherent Risks</h2>
    <p>FreeWheel organises self-drive overlanding expeditions through some of India's and the Himalayan region's most extreme, remote, and high-altitude terrain — including but not limited to Leh-Ladakh, Spiti Valley, Adi Kailash, Om Parvat, and Mustang (Nepal). These are <strong>adventure activities by nature</strong> and carry risks that cannot be eliminated.</p>
    <p>You expressly acknowledge that the following risks exist and are inherent to these expeditions:</p>
    <ul>
      <li><strong>High-altitude illness:</strong> Acute Mountain Sickness (AMS), High-Altitude Pulmonary Oedema (HAPE), High-Altitude Cerebral Oedema (HACE), and related conditions, which can be life-threatening</li>
      <li><strong>Road and driving hazards:</strong> Extreme mountain roads, black ice, loose gravel, narrow cliff-edge tracks, river crossings, and unmarked drops</li>
      <li><strong>Weather:</strong> Sudden snowfall, blizzards, flash floods, hailstorms, zero-visibility fog, and extreme cold</li>
      <li><strong>Natural disasters:</strong> Avalanches, landslides, cloudbursts, and earthquakes</li>
      <li><strong>Remote location:</strong> Distances far from hospitals, medical facilities, helicopter evacuation points, and reliable mobile connectivity</li>
      <li><strong>Vehicle incidents:</strong> Breakdowns, accidents, rollovers, and mechanical failures on terrain where recovery may take many hours</li>
      <li><strong>International travel risk:</strong> On Nepal expeditions, additional risks related to border crossing, foreign jurisdiction, differing medical infrastructure, and changing visa or permit regulations</li>
      <li><strong>Physical and mental exertion:</strong> Multi-day driving at altitude causing fatigue, disorientation, and impaired judgment</li>
      <li><strong>Injury or death:</strong> Including serious bodily injury, permanent disability, or death</li>
    </ul>
    <div class="pol-warning">
      <p><strong>IMPORTANT:</strong> FreeWheel operates convoy-based self-drive expeditions. You drive your own vehicle. FreeWheel's role is that of an expedition organiser and route leader — not a transport provider, medical service, rescue service, or insurer. FreeWheel does not guarantee your safety or the safety of your vehicle, passengers, or property.</p>
    </div>
  </div>

  <div class="pol-section" id="eligibility">
    <span class="pol-section-num">03</span>
    <h2>Participant Eligibility</h2>
    <p>To participate in any FreeWheel expedition, you must:</p>
    <ul>
      <li>Be <strong>18 years of age or older</strong> at the time of the expedition. No exceptions are made. Participation by persons under 18 is strictly prohibited.</li>
      <li>Hold a <strong>valid motor vehicle driving licence</strong> issued by a competent authority, appropriate for the class of vehicle you intend to drive</li>
      <li>Be in <strong>good physical health</strong> and have no medical condition that would be aggravated by high altitude, strenuous physical activity, or remote environments</li>
      <li>Possess or have access to a <strong>vehicle that meets the requirements</strong> specified for the particular expedition</li>
      <li>Comply with all applicable laws of India and, where relevant, Nepal regarding vehicle operation, permits, and immigration</li>
      <li>Have <strong>signed the FreeWheel physical participation form</strong> before the expedition commences. Failure to sign this form may result in exclusion from the expedition without refund.</li>
    </ul>
    <p>FreeWheel reserves the right to refuse participation to any person who, in our reasonable assessment, does not meet the above criteria or poses a risk to themselves or other participants.</p>
  </div>

  <div class="pol-section" id="assumption">
    <span class="pol-section-num">04</span>
    <h2>Assumption of Risk</h2>
    <p>By participating in any FreeWheel expedition, you <strong>freely, voluntarily, and knowingly assume all risks</strong> — whether known or unknown, foreseen or unforeseen — associated with participation, including all risks described in Section 2 and any other risks that may arise during the course of the expedition.</p>
    <p>You acknowledge that:</p>
    <ul>
      <li>No amount of experience, skill, or preparation eliminates the inherent risks of high-altitude self-drive expeditions</li>
      <li>FreeWheel has made you aware of these risks and you have had the opportunity to seek independent advice</li>
      <li>You participate entirely of your own free will</li>
      <li>You have disclosed all relevant medical conditions to FreeWheel prior to registration</li>
      <li>In the event of injury, illness, or emergency during the expedition, you consent to FreeWheel taking such first-aid or emergency measures as are reasonably available, and you bear all associated costs</li>
    </ul>
    <p>This assumption of risk applies to you, your vehicle, your passengers (if any), and your personal property throughout the duration of the expedition including transit to and from the meeting point.</p>
  </div>

  <div class="pol-section" id="liability">
    <span class="pol-section-num">05</span>
    <h2>Limitation of Liability</h2>
    <p>To the fullest extent permitted by applicable Indian law, <strong>FreeWheel Expeditions and its proprietor, employees, guides, and associates shall not be liable</strong> for any loss, injury, illness, death, property damage, or consequential loss suffered by you or your vehicle passengers arising from:</p>
    <ul>
      <li>Participation in any FreeWheel expedition or activity</li>
      <li>Acts of nature including weather, terrain, altitude, or natural disasters</li>
      <li>Road conditions, accidents, or vehicle incidents</li>
      <li>Failure or breakdown of your vehicle or any third-party vehicle</li>
      <li>Medical emergencies, altitude sickness, or pre-existing health conditions</li>
      <li>Actions of other participants, third parties, or government authorities</li>
      <li>Delays, route changes, or cancellations caused by any factor beyond FreeWheel's reasonable control</li>
      <li>Theft, loss, or damage to personal property</li>
    </ul>
    <p>Where liability cannot be fully excluded under Indian law, FreeWheel's total liability to you for any claim shall be limited to the amount actually paid by you to FreeWheel for the specific expedition in question.</p>
    <div class="pol-warning">
      <p><strong>FreeWheel does not accept liability for injury or death.</strong> These expeditions traverse extreme terrain in remote locations far from medical facilities. You participate with full knowledge and acceptance of this fact.</p>
    </div>
  </div>

  <div class="pol-section" id="insurance">
    <span class="pol-section-num">06</span>
    <h2>Insurance</h2>
    <p><strong>FreeWheel does not provide, arrange, or include any form of insurance</strong> for participants, passengers, vehicles, or personal property. This includes but is not limited to: travel insurance, medical insurance, accident insurance, vehicle insurance, evacuation insurance, and life insurance.</p>
    <p>You are <strong>strongly advised and encouraged</strong> to obtain comprehensive travel and medical insurance that specifically covers:</p>
    <ul>
      <li>High-altitude adventure activities and self-drive expeditions</li>
      <li>Medical evacuation from remote or high-altitude locations</li>
      <li>Emergency hospitalisation and treatment</li>
      <li>Trip cancellation and curtailment</li>
      <li>Personal accident and death</li>
      <li>Vehicle damage and third-party liability (beyond mandatory motor insurance)</li>
      <li>International travel cover for Nepal expeditions</li>
    </ul>
    <p>By booking with FreeWheel, you acknowledge that you have been informed of the absence of insurance cover, that you have had the opportunity to obtain your own insurance, and that FreeWheel bears no financial responsibility for any costs arising from medical treatment, evacuation, repatriation, or loss that would otherwise have been covered by insurance.</p>
  </div>

  <div class="pol-section" id="medical">
    <span class="pol-section-num">07</span>
    <h2>Medical Fitness & Health</h2>
    <p>You warrant that at the time of the expedition you are in good physical health and are not suffering from any medical condition — including but not limited to cardiac conditions, respiratory conditions, uncontrolled hypertension, epilepsy, diabetes, or any condition known to be aggravated by altitude or physical exertion — that would make participation inadvisable.</p>
    <p>You agree to:</p>
    <ul>
      <li>Consult your physician before the expedition, particularly regarding altitude sickness prevention</li>
      <li>Disclose any relevant medical condition to FreeWheel at the time of booking</li>
      <li>Carry any personal medications you require, including medications for altitude sickness</li>
      <li>Immediately inform the expedition leader of any deterioration in your health during the expedition</li>
      <li>Follow the expedition leader's instructions regarding acclimatisation, rest, and descent if symptoms arise</li>
    </ul>
    <p>FreeWheel reserves the right to remove any participant from an expedition at any time if, in the expedition leader's assessment, the participant's health poses a risk to themselves or the group. In such cases, no refund is payable and any costs of evacuation or return are borne by the participant.</p>
  </div>

  <div class="pol-section" id="booking">
    <span class="pol-section-num">08</span>
    <h2>Booking & Payment</h2>
    <p>A booking is confirmed only upon receipt of payment (full or partial deposit) by FreeWheel and confirmation from FreeWheel in writing or via WhatsApp. Submission of a booking form does not constitute a confirmed booking.</p>
    <p>Payment may be made via UPI, bank transfer, or such other methods as FreeWheel makes available. Payments are made in Indian Rupees (INR). For Nepal expeditions, pricing denominated per vehicle follows the rates specified at the time of booking.</p>
    <p>Where a partial payment (deposit) option is offered, the remaining balance must be paid no later than 30 days before the expedition departure date. Failure to pay the balance by this date may result in cancellation of your booking without refund of the deposit.</p>
    <p>Prices are subject to change. Any change in price will be communicated before booking is confirmed and will not apply to confirmed bookings.</p>
  </div>

  <div class="pol-section" id="cancellation">
    <span class="pol-section-num">09</span>
    <h2>Cancellation by Participant</h2>
    <p>All cancellation requests must be made in writing to <strong>hello@freewheelexpeditions.in</strong> or via WhatsApp to +91 78178 38060. Cancellations are effective only upon written acknowledgement by FreeWheel.</p>
    <ul>
      <li><strong>More than 30 days before departure:</strong> Full refund of amount paid, processed within 7–10 business days to the original payment method</li>
      <li><strong>30 days or fewer before departure:</strong> No refund. The full amount paid is forfeited regardless of the reason for cancellation, including illness, injury, personal emergency, or inability to travel</li>
      <li><strong>No-show:</strong> No refund</li>
    </ul>
    <p>FreeWheel strongly recommends that participants obtain trip cancellation insurance to cover the non-refundable portion of their booking in the event of unforeseen circumstances.</p>
    <p>Partial cancellations (e.g., reducing the number of participants in your vehicle) are treated as a cancellation of the affected portion and the same policy applies.</p>
  </div>

  <div class="pol-section" id="fw-cancellation">
    <span class="pol-section-num">10</span>
    <h2>Cancellation or Modification by FreeWheel</h2>
    <p>FreeWheel reserves the right to cancel, postpone, modify, or alter any expedition, route, itinerary, or date at any time and for any reason, including but not limited to: insufficient participant numbers, safety concerns, adverse weather, road closures, permit issues, natural disasters, government restrictions, or force majeure events.</p>
    <p>In the event FreeWheel cancels an expedition for any reason other than force majeure:</p>
    <ul>
      <li>Participants will be offered the option to transfer their booking to another available expedition date</li>
      <li>If no suitable alternative is acceptable, a full refund of amount paid will be issued within 10 business days</li>
    </ul>
    <p>In the event of a force majeure cancellation (see Section 14), FreeWheel's liability is limited to offering a credit or rescheduled expedition. No cash refund is guaranteed in force majeure situations.</p>
    <p>FreeWheel is not liable for any consequential costs you incur as a result of a cancellation or modification, including travel, accommodation, leave, or equipment costs.</p>
  </div>

  <div class="pol-section" id="conduct">
    <span class="pol-section-num">11</span>
    <h2>Participant Conduct</h2>
    <p>All participants are expected to conduct themselves in a manner that is safe, respectful, and conducive to the enjoyment of the expedition by all. You agree to:</p>
    <ul>
      <li>Follow all instructions given by the FreeWheel expedition leader at all times</li>
      <li>Not drive under the influence of alcohol, drugs, or any substance that impairs driving ability</li>
      <li>Not engage in reckless or dangerous driving</li>
      <li>Maintain safe distances and convoy discipline</li>
      <li>Respect local communities, customs, and environments</li>
      <li>Comply with all applicable laws, regulations, and permit conditions</li>
      <li>Not carry or use illegal substances</li>
      <li>Treat fellow participants, FreeWheel staff, and local communities with respect</li>
    </ul>
    <p>FreeWheel reserves the right to remove any participant from the expedition at any time for breach of conduct. Removed participants bear all costs of their own return and no refund is payable.</p>
  </div>

  <div class="pol-section" id="vehicle">
    <span class="pol-section-num">12</span>
    <h2>Vehicle Requirements</h2>
    <p>As a self-drive expedition, you are responsible for ensuring your vehicle is fit for purpose. You agree that your vehicle:</p>
    <ul>
      <li>Is in good mechanical condition prior to departure</li>
      <li>Carries all legally required documentation (RC, insurance, PUC)</li>
      <li>Is covered by valid motor insurance as required under Indian law</li>
      <li>For designated 4x4-only expeditions (e.g., Mustang), meets the specified vehicle type requirement</li>
      <li>Carries a basic toolkit, recovery equipment, and spare tyre as recommended by FreeWheel</li>
    </ul>
    <p>FreeWheel is not responsible for vehicle breakdowns, damage, or recovery costs. Costs of vehicle recovery, towing, or repair during expeditions are entirely the responsibility of the vehicle owner.</p>
  </div>

  <div class="pol-section" id="indemnity">
    <span class="pol-section-num">13</span>
    <h2>Indemnification</h2>
    <p>You agree to <strong>indemnify, defend, and hold harmless</strong> FreeWheel Expeditions, its proprietor, employees, guides, agents, and associates from and against any and all claims, demands, damages, losses, costs, and expenses (including reasonable legal fees) arising from or related to:</p>
    <ul>
      <li>Your participation in any FreeWheel expedition or activity</li>
      <li>Your breach of these Terms and Conditions</li>
      <li>Any negligence, recklessness, or wilful misconduct on your part</li>
      <li>Any claim made by your vehicle passengers or third parties arising from your actions during the expedition</li>
      <li>Any damage caused by you to third-party property or vehicles</li>
    </ul>
  </div>

  <div class="pol-section" id="force-majeure">
    <span class="pol-section-num">14</span>
    <h2>Force Majeure</h2>
    <p>FreeWheel shall not be in breach of these Terms and shall not be liable for any failure or delay in performance of obligations arising from causes beyond its reasonable control, including but not limited to: acts of God, natural disasters (avalanche, flood, earthquake, extreme weather), war, civil unrest, government actions, road closures by authority order, health emergencies or epidemics, failure of third-party suppliers, or any other event beyond FreeWheel's reasonable control.</p>
    <p>In such circumstances, FreeWheel will make reasonable efforts to reschedule or offer credit for affected expeditions but does not guarantee cash refunds.</p>
  </div>

  <div class="pol-section" id="governing-law">
    <span class="pol-section-num">15</span>
    <h2>Governing Law & Dispute Resolution</h2>
    <p>These Terms and Conditions shall be governed by and construed in accordance with the laws of India. Any dispute arising from or in connection with these Terms, your booking, or your participation in any FreeWheel expedition shall be subject to the <strong>exclusive jurisdiction of the courts at Haldwani, Uttarakhand</strong>.</p>
    <p>Before initiating legal proceedings, both parties agree to attempt resolution through good-faith negotiation for a period of 30 days from the date the dispute is first raised in writing.</p>
    <p>FreeWheel reserves the right to amend these Terms and Conditions at any time. Updated Terms will be published on this website. Continued participation in FreeWheel expeditions following any amendment constitutes acceptance of the revised Terms.</p>
  </div>

  <div class="pol-section" id="contact">
    <span class="pol-section-num">16</span>
    <h2>Contact</h2>
    <p>For any questions regarding these Terms and Conditions:</p>
    <ul>
      <li><strong>Email:</strong> hello@freewheelexpeditions.in</li>
      <li><strong>WhatsApp:</strong> +91 78178 38060</li>
      <li><strong>Website:</strong> freewheelexpeditions.in</li>
    </ul>
  </div>

</div>

<div class="pol-updated">© <?php echo date('Y'); ?> FreeWheel Expeditions · All Rights Reserved · Haldwani, Uttarakhand, India</div>

<?php get_footer(); ?>
