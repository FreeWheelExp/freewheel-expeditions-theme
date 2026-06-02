<?php
/**
 * Template Name: Self Drive Spiti Valley
 * Template Post Type: page
 *
 * FreeWheel Expeditions — Self Drive Spiti Valley Destination Guide
 */
get_header(); ?>
<style>
html,body,body.page,#page,#content,#primary,#main,.site,.site-content,.entry-content,.wp-site-blocks,main,article{background:#0f0d0b!important;background-color:#0f0d0b!important}
:root{--ink:#0f0d0b;--paper:#faf6f0;--sand:#e8dcc8;--smoke:#f2ece2;--rust:#c1440e;--amber:#e8a020;--teal:#2a7a6e;--headline:'Barlow Condensed',sans-serif}
*{box-sizing:border-box;margin:0;padding:0}
body{background:var(--ink);color:#fff;font-family:'Inter',sans-serif;font-size:16px;line-height:1.7}
a{color:inherit;text-decoration:none}
img{max-width:100%;height:auto}
.dest-hero{min-height:70vh;background:linear-gradient(to bottom,rgba(15,13,11,.4) 0%,rgba(15,13,11,.85) 100%),url('https://freewheelexpeditions.in/wp-content/uploads/2026/05/vlcsnap-2026-05-02-21h42m43s99.jpeg') center/cover no-repeat;display:flex;align-items:flex-end;padding:60px 5vw}
.dest-hero-inner{max-width:900px}
.dest-eyebrow{font-size:11px;letter-spacing:4px;text-transform:uppercase;color:var(--amber);margin-bottom:16px}
.dest-h1{font-family:var(--headline);font-size:clamp(48px,8vw,90px);line-height:.92;letter-spacing:2px;color:#fff;margin-bottom:20px}
.dest-h1 span{color:var(--rust)}
.dest-hero-sub{font-size:18px;color:rgba(255,255,255,.7);max-width:600px;line-height:1.7;margin-bottom:32px}
.btn-solid{display:inline-block;padding:14px 32px;background:var(--rust);color:#fff;font-family:var(--headline);font-size:16px;letter-spacing:2px;text-transform:uppercase;border-radius:2px}
.btn-ghost{display:inline-block;padding:14px 32px;border:2px solid rgba(255,255,255,.4);color:#fff;font-family:var(--headline);font-size:16px;letter-spacing:2px;text-transform:uppercase;border-radius:2px;margin-left:12px}
.facts-bar{background:#1a1410;border-top:3px solid var(--rust);padding:24px 5vw;display:flex;gap:40px;flex-wrap:wrap}
.fact{display:flex;flex-direction:column;gap:4px}
.fact-label{font-size:10px;letter-spacing:3px;text-transform:uppercase;color:rgba(255,255,255,.4)}
.fact-val{font-family:var(--headline);font-size:20px;color:var(--amber);letter-spacing:1px}
.dest-section{padding:80px 5vw;max-width:1100px;margin:0 auto}
.dest-section.dark{background:var(--ink);max-width:100%;padding:80px 5vw}
.dest-section.dark .inner{max-width:1100px;margin:0 auto}
.sec-tag{font-size:10px;letter-spacing:4px;text-transform:uppercase;color:var(--amber);margin-bottom:12px}
.sec-h2{font-family:var(--headline);font-size:clamp(32px,5vw,54px);line-height:1;letter-spacing:1px;color:#fff;margin-bottom:24px}
.sec-h2 em{color:var(--rust);font-style:normal}
.body-text{font-size:16px;color:rgba(255,255,255,.75);line-height:1.8;margin-bottom:20px}
.body-text strong{color:#fff}
.route-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:20px;margin-top:32px}
.route-card{background:#1a1410;border:1px solid rgba(255,255,255,.08);padding:24px;border-radius:2px;border-left:3px solid var(--rust)}
.route-name{font-family:var(--headline);font-size:20px;letter-spacing:1px;color:#fff;margin-bottom:8px}
.route-dist{font-size:12px;letter-spacing:2px;color:var(--amber);text-transform:uppercase;margin-bottom:12px}
.route-desc{font-size:14px;color:rgba(255,255,255,.6);line-height:1.6}
.month-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:12px;margin-top:28px}
.month-card{padding:16px;background:#1a1410;border:1px solid rgba(255,255,255,.07);text-align:center;border-radius:2px}
.month-name{font-family:var(--headline);font-size:18px;color:#fff;letter-spacing:1px;margin-bottom:6px}
.month-rating{font-size:12px;padding:3px 10px;border-radius:20px;display:inline-block;margin-bottom:8px}
.rating-best{background:rgba(42,122,110,.3);color:#4ecdc4}
.rating-good{background:rgba(232,160,32,.2);color:var(--amber)}
.rating-avoid{background:rgba(193,68,14,.2);color:#ff8a65}
.month-note{font-size:11px;color:rgba(255,255,255,.45);line-height:1.4}
.checklist{display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:10px;margin-top:24px}
.check-item{display:flex;align-items:flex-start;gap:12px;padding:14px;background:#1a1410;border:1px solid rgba(255,255,255,.06);border-radius:2px}
.check-ico{color:var(--teal);font-size:16px;flex-shrink:0;margin-top:2px}
.check-text{font-size:14px;color:rgba(255,255,255,.7);line-height:1.5}
.faq-list{margin-top:32px;display:flex;flex-direction:column;gap:2px}
.faq-item{background:#1a1410;border:1px solid rgba(255,255,255,.07)}
.faq-q{padding:20px 24px;font-family:var(--headline);font-size:18px;letter-spacing:.5px;color:#fff;cursor:pointer;display:flex;justify-content:space-between;align-items:center;gap:16px}
.faq-q::after{content:'+';font-size:24px;color:var(--amber);flex-shrink:0;transition:transform .3s}
.faq-item.open .faq-q::after{transform:rotate(45deg)}
.faq-a{display:none;padding:0 24px 20px;font-size:15px;color:rgba(255,255,255,.65);line-height:1.8}
.faq-item.open .faq-a{display:block}
.cta-band{background:linear-gradient(135deg,var(--rust) 0%,#8b2d09 100%);padding:80px 5vw;text-align:center}
.cta-band h2{font-family:var(--headline);font-size:clamp(36px,6vw,64px);color:#fff;letter-spacing:2px;margin-bottom:16px}
.cta-band p{font-size:18px;color:rgba(255,255,255,.8);margin-bottom:36px;max-width:500px;margin-left:auto;margin-right:auto}
.cta-btns{display:flex;gap:16px;justify-content:center;flex-wrap:wrap}
.btn-white{display:inline-block;padding:16px 36px;background:#fff;color:var(--rust);font-family:var(--headline);font-size:18px;letter-spacing:2px;text-transform:uppercase;border-radius:2px;font-weight:700}
.btn-wa{display:inline-flex;align-items:center;gap:10px;padding:16px 36px;background:#25d366;color:#fff;font-family:var(--headline);font-size:18px;letter-spacing:2px;text-transform:uppercase;border-radius:2px}
@media(max-width:768px){.facts-bar{gap:24px}.btn-ghost{margin-left:0;margin-top:12px}}
</style>

<?php
$faqs = [
  ["q"=>"What is the best time for a Spiti Valley self drive?","a"=>"June to October is the ideal window. The Manali-Spiti road via Rohtang and Kunzum Pass opens around mid-June and closes with the first heavy snowfall in October-November. The Shimla-Spiti route via Kinnaur is open longer — typically April to November — but is narrower and slower."],
  ["q"=>"Which route is better for Spiti — via Manali or via Shimla?","a"=>"Both have merit and FreeWheel's circuit typically covers both. Manali-Spiti via Rohtang and Kunzum Pass is more dramatic with high passes and open landscapes. Shimla-Spiti via Kinnaur follows the Sutlej River through deep gorges with overhanging cliffs. Doing a full circuit — in via Manali, out via Shimla — is the best approach."],
  ["q"=>"What vehicle is best for Spiti Valley self drive?","a"=>"A 4x4 or capable SUV with good ground clearance is recommended. Kunzum Pass (4,590m) and sections of the Manali-Kaza road involve loose gravel and water crossings. Well-maintained hatchbacks can complete the Shimla-Kaza route but struggle on the Manali side. Tyre condition is the most critical factor."],
  ["q"=>"How many days do I need for a Spiti Valley self drive?","a"=>"A minimum of 10-12 days is recommended for a complete circuit from Delhi — this allows for proper acclimatisation in Kaza, day trips to Key Monastery, Chandratal Lake, Dhankar, and Pin Valley, without rushing. FreeWheel's Spiti expedition covers the full circuit over 12-14 days."],
  ["q"=>"What is the altitude of Spiti Valley and how do I handle it?","a"=>"Kaza, the main town in Spiti, sits at 3,800 metres. Kunzum Pass is at 4,590m. Chandratal Lake is at 4,300m. Spend at least one acclimatisation day in Kaza before exploring higher areas. Altitude sickness symptoms — headache, nausea, breathlessness — should be taken seriously. Descend immediately if symptoms worsen."],
  ["q"=>"Is Spiti Valley accessible in winter?","a"=>"The Manali-Spiti road closes in October-November due to snow. The Shimla-Kaza route via Kinnaur stays open longer but can close in heavy snowfall. Winter Spiti (January-March) is accessible only via helicopter or on foot and is not suitable for self-drive. FreeWheel runs summer and autumn expeditions only."],
  ["q"=>"What permits are required for Spiti Valley?","a"=>"Indian nationals do not require any special permits for Spiti Valley itself. However, if your route extends into the Pin Valley National Park interior or certain areas near the Tibetan border, local permissions may be needed. FreeWheel's convoy handles all such logistics."],
  ["q"=>"What are the must-see places in Spiti on a self drive?","a"=>"Key Monastery (4,166m), Chandratal Lake, Dhankar Monastery and Lake, Pin Valley, Hikkim (world's highest post office), Komic (one of the world's highest villages), Langza Buddha statue, and Kibber wildlife sanctuary. FreeWheel's itinerary covers all major highlights with time for exploration at each."],
];
echo '<script type="application/ld+json">' . json_encode([
  "@context"=>"https://schema.org","@type"=>"FAQPage",
  "mainEntity"=>array_map(fn($f)=>["@type"=>"Question","name"=>$f['q'],"acceptedAnswer"=>["@type"=>"Answer","text"=>$f['a']]],$faqs)
],JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) . '</script>';
echo '<script type="application/ld+json">' . json_encode([
  "@context"=>"https://schema.org","@type"=>"BreadcrumbList",
  "itemListElement"=>[
    ["@type"=>"ListItem","position"=>1,"name"=>"Home","item"=>"https://freewheelexpeditions.in/"],
    ["@type"=>"ListItem","position"=>2,"name"=>"Self Drive Spiti Valley","item"=>"https://freewheelexpeditions.in/self-drive-spiti-valley/"]
  ]
],JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) . '</script>';
?>

<section class="dest-hero">
  <div class="dest-hero-inner">
    <div class="dest-eyebrow">Destination Guide</div>
    <h1 class="dest-h1">Self Drive<br><span>Spiti Valley</span></h1>
    <p class="dest-hero-sub">The Middle Land. Key Monastery at dawn. Chandratal's impossible blue. A high-altitude cold desert that rewards every difficult kilometre — driven your way.</p>
    <a href="/expedition/self-drive-spiti-valley-expedition/" class="btn-solid">View Our Spiti Expedition</a>
    <a href="https://wa.me/917817838060?text=Hi%21%20I%20want%20to%20know%20more%20about%20the%20Spiti%20Valley%20self%20drive%20expedition." class="btn-ghost" target="_blank">💬 WhatsApp Us</a>
  </div>
</section>

<div class="facts-bar">
  <div class="fact"><span class="fact-label">Best Season</span><span class="fact-val">June – October</span></div>
  <div class="fact"><span class="fact-label">Region</span><span class="fact-val">Himachal Pradesh</span></div>
  <div class="fact"><span class="fact-label">Max Altitude</span><span class="fact-val">4,590 m</span></div>
  <div class="fact"><span class="fact-label">Duration</span><span class="fact-val">12–14 Days</span></div>
  <div class="fact"><span class="fact-label">Difficulty</span><span class="fact-val">Challenging</span></div>
  <div class="fact"><span class="fact-label">Starting From</span><span class="fact-val">Delhi / Manali</span></div>
</div>

<section class="dest-section">
  <div class="sec-tag">About The Destination</div>
  <h2 class="sec-h2">India's most <em>dramatic</em> cold desert drive</h2>
  <p class="body-text">Spiti means "The Middle Land" — a valley caught between India and Tibet, between barren and breathtaking, between accessible and remote. At an average altitude of 3,800 metres, it is one of the highest inhabited valleys in the world, and one of the most visually arresting places you can drive to in India.</p>
  <p class="body-text">The landscape is unlike anything in the subcontinent — vast brown and grey mountain faces with snow-capped peaks, turquoise rivers cutting through gorges, and centuries-old Buddhist monasteries perched on clifftops that seem to defy gravity. Key Monastery. Dhankar. Tabo. Each one a masterpiece of Himalayan architecture.</p>
  <p class="body-text"><strong>FreeWheel Expeditions</strong> runs guided self-drive convoys to Spiti covering the full Manali-Kaza-Shimla circuit. You experience both entry routes, every major monastery and lake, and the high-altitude villages that feel like the edge of the world — in your own vehicle, with full convoy support.</p>
</section>

<section class="dest-section dark">
  <div class="inner">
    <div class="sec-tag">The Route</div>
    <h2 class="sec-h2">Key stretches of the<br><em>Spiti Valley</em> circuit</h2>
    <div class="route-grid">
      <div class="route-card">
        <div class="route-name">Manali to Kaza</div>
        <div class="route-dist">~200 km · 2 days</div>
        <div class="route-desc">Via Rohtang Pass (3,978m) and Kunzum Pass (4,590m). The road is rough and spectacular — this is the dramatic entry into Spiti's cold desert world.</div>
      </div>
      <div class="route-card">
        <div class="route-name">Chandratal Lake</div>
        <div class="route-dist">4,300 m altitude</div>
        <div class="route-desc">The crescent-shaped "Moon Lake" sits at 4,300m between Kunzum Pass and Kaza. An overnight camp here is one of the expedition's highlights — stars like you've never seen.</div>
      </div>
      <div class="route-card">
        <div class="route-name">Kaza — Base Camp</div>
        <div class="route-dist">3,800 m altitude</div>
        <div class="route-desc">Spiti's main town and acclimatisation base. Spend 2 nights here and day-trip to Key Monastery, Kibber, Hikkim, Komic, and Langza.</div>
      </div>
      <div class="route-card">
        <div class="route-name">Key Monastery</div>
        <div class="route-dist">4,166 m altitude</div>
        <div class="route-desc">The largest monastery in Spiti, perched dramatically above the valley. Founded in the 11th century — the frescoes and thangkas inside are extraordinary.</div>
      </div>
      <div class="route-card">
        <div class="route-name">Pin Valley</div>
        <div class="route-dist">Side valley from Kaza</div>
        <div class="route-desc">A hidden gem even within Spiti. The Pin River valley leads to Mud village and Pin Valley National Park — home to snow leopards and ibex.</div>
      </div>
      <div class="route-card">
        <div class="route-name">Kaza to Shimla via Kinnaur</div>
        <div class="route-dist">~430 km · 2 days</div>
        <div class="route-desc">The return via Tabo, Nako, Kalpa, and the Kinnaur valley follows the Sutlej River through overhanging cliffs. A completely different landscape from the entry.</div>
      </div>
    </div>
  </div>
</section>

<section class="dest-section">
  <div class="sec-tag">When To Go</div>
  <h2 class="sec-h2">Best time for<br><em>Spiti Valley</em> self drive</h2>
  <div class="month-grid">
    <div class="month-card">
      <div class="month-name">Jan–Mar</div>
      <span class="month-rating rating-avoid">Closed</span>
      <div class="month-note">Manali route closed. Extreme cold. Only experienced winter expeditions.</div>
    </div>
    <div class="month-card">
      <div class="month-name">April–May</div>
      <span class="month-rating rating-good">Kinnaur Only</span>
      <div class="month-note">Shimla-Kaza route opens. Manali route still closed. Snow on high passes.</div>
    </div>
    <div class="month-card">
      <div class="month-name">June</div>
      <span class="month-rating rating-good">Good</span>
      <div class="month-note">Both routes open by mid-June. Cool temperatures. Some snow on Kunzum.</div>
    </div>
    <div class="month-card">
      <div class="month-name">July–Aug</div>
      <span class="month-rating rating-good">Good</span>
      <div class="month-note">Peak season. Occasional landslides on Manali side. Spiti itself is dry.</div>
    </div>
    <div class="month-card">
      <div class="month-name">September</div>
      <span class="month-rating rating-best">Best</span>
      <div class="month-note">Clear skies, thin crowds, perfect light for photography. Ideal month.</div>
    </div>
    <div class="month-card">
      <div class="month-name">October</div>
      <span class="month-rating rating-good">Good</span>
      <div class="month-note">Early October excellent. Manali route closes mid-month. Cold nights.</div>
    </div>
  </div>
</section>

<section class="dest-section dark">
  <div class="inner">
    <div class="sec-tag">Preparation</div>
    <h2 class="sec-h2">What you need before<br><em>you drive</em></h2>
    <div class="checklist">
      <div class="check-item"><span class="check-ico">✓</span><span class="check-text"><strong>Vehicle service done</strong> — brakes, tyres, coolant. Kunzum Pass at 4,590m is unforgiving of mechanical issues.</span></div>
      <div class="check-item"><span class="check-ico">✓</span><span class="check-text"><strong>Two spare tyres</strong> — sharp rocks on the Manali-Kaza road cause frequent punctures. One spare is not enough.</span></div>
      <div class="check-item"><span class="check-ico">✓</span><span class="check-text"><strong>Acclimatise in Kaza</strong> — spend 2 nights before visiting Chandratal or higher villages. Altitude sickness is real at 3,800m+.</span></div>
      <div class="check-item"><span class="check-ico">✓</span><span class="check-text"><strong>Fuel in Manali and Kaza</strong> — fill completely at both points. Stations are absent between Gramphoo and Kaza.</span></div>
      <div class="check-item"><span class="check-ico">✓</span><span class="check-text"><strong>Offline maps</strong> — no network on most of the Manali-Kaza road. Download Maps.me Himachal Pradesh offline.</span></div>
      <div class="check-item"><span class="check-ico">✓</span><span class="check-text"><strong>Cash only</strong> — ATMs in Kaza are unreliable. Carry enough from Manali for the full valley stay.</span></div>
      <div class="check-item"><span class="check-ico">✓</span><span class="check-text"><strong>Warm layers</strong> — temperatures drop below 0°C at night even in August at Chandratal and Kunzum.</span></div>
      <div class="check-item"><span class="check-ico">✓</span><span class="check-text"><strong>Sunscreen and sunglasses</strong> — UV radiation at 4,000m+ is intense. More important than most people expect.</span></div>
    </div>
  </div>
</section>

<section class="dest-section">
  <div class="sec-tag">Common Questions</div>
  <h2 class="sec-h2">Self Drive Spiti Valley<br><em>FAQ</em></h2>
  <div class="faq-list">
    <?php foreach($faqs as $f): ?>
    <div class="faq-item">
      <div class="faq-q"><?php echo esc_html($f['q']); ?></div>
      <div class="faq-a"><?php echo esc_html($f['a']); ?></div>
    </div>
    <?php endforeach; ?>
  </div>
</section>

<section class="cta-band">
  <h2>Ready to Drive Spiti?</h2>
  <p>Join FreeWheel's guided self-drive convoy through the Middle Land — Key Monastery, Chandratal, and beyond.</p>
  <div class="cta-btns">
    <a href="/expedition/self-drive-spiti-valley-expedition/" class="btn-white">View Expedition Details</a>
    <a href="https://wa.me/917817838060?text=Hi%21%20I%20want%20to%20join%20the%20Spiti%20Valley%20self%20drive%20expedition." class="btn-wa" target="_blank">
      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.123.554 4.118 1.528 5.85L.057 23.077a.75.75 0 0 0 .943.895l5.344-1.705A11.945 11.945 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.75a9.726 9.726 0 0 1-4.964-1.355l-.355-.212-3.693 1.178 1.131-3.595-.232-.371A9.725 9.725 0 0 1 2.25 12C2.25 6.615 6.615 2.25 12 2.25S21.75 6.615 21.75 12 17.385 21.75 12 21.75z"/></svg>
      WhatsApp Us
    </a>
  </div>
</section>

<script>
document.querySelectorAll('.faq-q').forEach(function(q){
  q.addEventListener('click',function(){
    var item=this.closest('.faq-item');
    var wasOpen=item.classList.contains('open');
    document.querySelectorAll('.faq-item').forEach(function(i){i.classList.remove('open');});
    if(!wasOpen) item.classList.add('open');
  });
});
</script>
<?php get_footer(); ?>
