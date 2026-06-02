<?php
/**
 * Template Name: Self Drive Leh Ladakh
 * Template Post Type: page
 *
 * FreeWheel Expeditions — Self Drive Leh Ladakh Destination Guide
 * Template: page-leh-destination
 */
get_header(); ?>
<style>
html, body, body.page, #page, #content, #primary, #main,
.site, .site-content, .entry-content, .wp-site-blocks, main, article {
    background: #0f0d0b !important;
    background-color: #0f0d0b !important;
}
:root{
  --ink:#0f0d0b;--paper:#faf6f0;--sand:#e8dcc8;--smoke:#f2ece2;
  --rust:#c1440e;--amber:#e8a020;--teal:#2a7a6e;
  --headline:'Barlow Condensed',sans-serif;
}
*{box-sizing:border-box;margin:0;padding:0}
body{background:var(--ink);color:#fff;font-family:'Inter',sans-serif;font-size:16px;line-height:1.7}
a{color:inherit;text-decoration:none}
img{max-width:100%;height:auto}

/* Hero */
.dest-hero{min-height:70vh;background:linear-gradient(to bottom,rgba(15,13,11,.4) 0%,rgba(15,13,11,.85) 100%),url('https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=1920&q=80') center/cover no-repeat;display:flex;align-items:flex-end;padding:60px 5vw}
.dest-hero-inner{max-width:900px}
.dest-eyebrow{font-size:11px;letter-spacing:4px;text-transform:uppercase;color:var(--amber);margin-bottom:16px}
.dest-h1{font-family:var(--headline);font-size:clamp(48px,8vw,90px);line-height:.92;letter-spacing:2px;color:#fff;margin-bottom:20px}
.dest-h1 span{color:var(--rust)}
.dest-hero-sub{font-size:18px;color:rgba(255,255,255,.7);max-width:600px;line-height:1.7;margin-bottom:32px}
.btn-solid{display:inline-block;padding:14px 32px;background:var(--rust);color:#fff;font-family:var(--headline);font-size:16px;letter-spacing:2px;text-transform:uppercase;border-radius:2px;transition:background .2s}
.btn-solid:hover{background:#a33a0c}
.btn-ghost{display:inline-block;padding:14px 32px;border:2px solid rgba(255,255,255,.4);color:#fff;font-family:var(--headline);font-size:16px;letter-spacing:2px;text-transform:uppercase;border-radius:2px;margin-left:12px;transition:border-color .2s}
.btn-ghost:hover{border-color:#fff}

/* Quick facts bar */
.facts-bar{background:#1a1410;border-top:3px solid var(--rust);padding:24px 5vw;display:flex;gap:40px;flex-wrap:wrap}
.fact{display:flex;flex-direction:column;gap:4px}
.fact-label{font-size:10px;letter-spacing:3px;text-transform:uppercase;color:rgba(255,255,255,.4)}
.fact-val{font-family:var(--headline);font-size:20px;color:var(--amber);letter-spacing:1px}

/* Content sections */
.dest-section{padding:80px 5vw;max-width:1100px;margin:0 auto}
.dest-section.dark{background:var(--ink);max-width:100%;padding:80px 5vw}
.dest-section.dark .inner{max-width:1100px;margin:0 auto}
.sec-tag{font-size:10px;letter-spacing:4px;text-transform:uppercase;color:var(--amber);margin-bottom:12px}
.sec-h2{font-family:var(--headline);font-size:clamp(32px,5vw,54px);line-height:1;letter-spacing:1px;color:#fff;margin-bottom:24px}
.sec-h2 em{color:var(--rust);font-style:normal}
.body-text{font-size:16px;color:rgba(255,255,255,.75);line-height:1.8;margin-bottom:20px}
.body-text strong{color:#fff}

/* Route cards */
.route-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:20px;margin-top:32px}
.route-card{background:#1a1410;border:1px solid rgba(255,255,255,.08);padding:24px;border-radius:2px;border-left:3px solid var(--rust)}
.route-name{font-family:var(--headline);font-size:20px;letter-spacing:1px;color:#fff;margin-bottom:8px}
.route-dist{font-size:12px;letter-spacing:2px;color:var(--amber);text-transform:uppercase;margin-bottom:12px}
.route-desc{font-size:14px;color:rgba(255,255,255,.6);line-height:1.6}

/* Month grid */
.month-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:12px;margin-top:28px}
.month-card{padding:16px;background:#1a1410;border:1px solid rgba(255,255,255,.07);text-align:center;border-radius:2px}
.month-name{font-family:var(--headline);font-size:18px;color:#fff;letter-spacing:1px;margin-bottom:6px}
.month-rating{font-size:12px;padding:3px 10px;border-radius:20px;display:inline-block;margin-bottom:8px}
.rating-best{background:rgba(42,122,110,.3);color:#4ecdc4}
.rating-good{background:rgba(232,160,32,.2);color:var(--amber)}
.rating-avoid{background:rgba(193,68,14,.2);color:#ff8a65}
.month-note{font-size:11px;color:rgba(255,255,255,.45);line-height:1.4}

/* Checklist */
.checklist{display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:10px;margin-top:24px}
.check-item{display:flex;align-items:flex-start;gap:12px;padding:14px;background:#1a1410;border:1px solid rgba(255,255,255,.06);border-radius:2px}
.check-ico{color:var(--teal);font-size:16px;flex-shrink:0;margin-top:2px}
.check-text{font-size:14px;color:rgba(255,255,255,.7);line-height:1.5}

/* FAQ */
.faq-list{margin-top:32px;display:flex;flex-direction:column;gap:2px}
.faq-item{background:#1a1410;border:1px solid rgba(255,255,255,.07)}
.faq-q{padding:20px 24px;font-family:var(--headline);font-size:18px;letter-spacing:.5px;color:#fff;cursor:pointer;display:flex;justify-content:space-between;align-items:center;gap:16px}
.faq-q::after{content:'+';font-size:24px;color:var(--amber);flex-shrink:0;transition:transform .3s}
.faq-item.open .faq-q::after{transform:rotate(45deg)}
.faq-a{display:none;padding:0 24px 20px;font-size:15px;color:rgba(255,255,255,.65);line-height:1.8}
.faq-item.open .faq-a{display:block}

/* CTA band */
.cta-band{background:linear-gradient(135deg,var(--rust) 0%,#8b2d09 100%);padding:80px 5vw;text-align:center}
.cta-band h2{font-family:var(--headline);font-size:clamp(36px,6vw,64px);color:#fff;letter-spacing:2px;margin-bottom:16px}
.cta-band p{font-size:18px;color:rgba(255,255,255,.8);margin-bottom:36px;max-width:500px;margin-left:auto;margin-right:auto}
.cta-btns{display:flex;gap:16px;justify-content:center;flex-wrap:wrap}
.btn-white{display:inline-block;padding:16px 36px;background:#fff;color:var(--rust);font-family:var(--headline);font-size:18px;letter-spacing:2px;text-transform:uppercase;border-radius:2px;font-weight:700}
.btn-wa{display:inline-flex;align-items:center;gap:10px;padding:16px 36px;background:#25d366;color:#fff;font-family:var(--headline);font-size:18px;letter-spacing:2px;text-transform:uppercase;border-radius:2px}

/* Responsive */
@media(max-width:768px){
  .facts-bar{gap:24px}
  .btn-ghost{margin-left:0;margin-top:12px}
  .dest-hero-sub{font-size:16px}
}
</style>

<?php
// FAQ Schema
$faqs = [
  ["q"=>"Can I do Leh Ladakh self drive in my own car?","a"=>"Yes, absolutely. Most self-drive expeditions to Leh Ladakh use personal vehicles — SUVs and 4x4s are ideal but well-maintained hatchbacks and sedans also complete the route. The key factors are tyre condition, engine health, and ground clearance for river crossings."],
  ["q"=>"What is the best time to do a self drive trip to Leh Ladakh?","a"=>"June to September is the ideal window. Roads like Rohtang Pass and Baralacha La typically open by mid-June. September offers cleaner skies and thinner crowds. July and August see the Manali-Leh highway at its most accessible but also most trafficked."],
  ["q"=>"How many days are required for a Leh Ladakh self drive expedition?","a"=>"A minimum of 10-12 days is recommended from Delhi — this allows for proper acclimatisation, exploration of Nubra Valley, Pangong Tso, and Hanle without rushing. FreeWheel's expedition is 14 nights / 15 days covering the complete Manali-Leh-Srinagar circuit."],
  ["q"=>"What permits are required for Leh Ladakh self drive?","a"=>"Indian nationals need an Inner Line Permit (ILP) for restricted areas including Nubra Valley, Pangong Tso, Hanle, and Umling La. These can be obtained online via the Ladakh Tourism portal or at the DC office in Leh. Foreign nationals require a Protected Area Permit (PAP)."],
  ["q"=>"What is the cost of a self drive Leh Ladakh trip?","a"=>"FreeWheel Expeditions charges ₹5,000 per vehicle for the convoy and support package — this covers route support, emergency assistance, and guided convoy. Your personal expenses for fuel, accommodation, and food are additional. Total trip cost typically ranges ₹40,000–₹80,000 depending on your vehicle and accommodation choices."],
  ["q"=>"Is Leh Ladakh self drive safe for beginners?","a"=>"With proper preparation and a guided convoy, yes. FreeWheel Expeditions provides an experienced route lead, emergency support, and daily briefings. First-time high-altitude drivers find the convoy format far safer than going solo — you're never alone on the road."],
  ["q"=>"What is the altitude of Leh and how do I handle altitude sickness?","a"=>"Leh is at 3,524 metres (11,562 feet). Umling La, the world's highest motorable pass on this route, reaches 5,798 metres. Acclimatisation is mandatory — spend at least 2 nights in Leh before proceeding to higher altitudes. Diamox (acetazolamide) is commonly used; consult your doctor before the trip."],
  ["q"=>"Which route is better for self drive — Manali to Leh or Srinagar to Leh?","a"=>"Both have merit. Manali-Leh (490 km, 2 days) is more dramatic with passes like Rohtang, Baralacha La, and Tanglang La. Srinagar-Leh (424 km, 1-2 days) via Zoji La is more accessible and opens earlier in the season. FreeWheel does the full circuit — Manali to Leh to Srinagar — covering both."],
];
echo '<script type="application/ld+json">' . json_encode([
  "@context" => "https://schema.org",
  "@type" => "FAQPage",
  "mainEntity" => array_map(fn($f) => [
    "@type" => "Question",
    "name" => $f['q'],
    "acceptedAnswer" => ["@type"=>"Answer","text"=>$f['a']]
  ], $faqs)
], JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) . '</script>';

// BreadcrumbList Schema
echo '<script type="application/ld+json">' . json_encode([
  "@context" => "https://schema.org",
  "@type" => "BreadcrumbList",
  "itemListElement" => [
    ["@type"=>"ListItem","position"=>1,"name"=>"Home","item"=>"https://freewheelexpeditions.in/"],
    ["@type"=>"ListItem","position"=>2,"name"=>"Self Drive Leh Ladakh","item"=>"https://freewheelexpeditions.in/self-drive-leh-ladakh/"]
  ]
], JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) . '</script>';
?>

<!-- HERO -->
<section class="dest-hero">
  <div class="dest-hero-inner">
    <div class="dest-eyebrow">Destination Guide</div>
    <h1 class="dest-h1">Self Drive<br><span>Leh Ladakh</span></h1>
    <p class="dest-hero-sub">The world's highest motorable passes. Pangong Tso at dawn. Nubra Valley's sand dunes. Drive it yourself — with a convoy that's got your back.</p>
    <a href="/expedition/dream-leh-ladakh-self-drive-expedition/" class="btn-solid">View Our Leh Expedition</a>
    <a href="https://wa.me/917817838060?text=Hi%21%20I%20want%20to%20know%20more%20about%20the%20Leh%20Ladakh%20self%20drive%20expedition." class="btn-ghost" target="_blank">💬 WhatsApp Us</a>
  </div>
</section>

<!-- QUICK FACTS -->
<div class="facts-bar">
  <div class="fact"><span class="fact-label">Best Season</span><span class="fact-val">June – September</span></div>
  <div class="fact"><span class="fact-label">Duration</span><span class="fact-val">14N / 15D</span></div>
  <div class="fact"><span class="fact-label">Max Altitude</span><span class="fact-val">5,798 m</span></div>
  <div class="fact"><span class="fact-label">Total Distance</span><span class="fact-val">~3,500 km</span></div>
  <div class="fact"><span class="fact-label">Difficulty</span><span class="fact-val">Challenging</span></div>
  <div class="fact"><span class="fact-label">Starting From</span><span class="fact-val">₹5,000 / vehicle</span></div>
</div>

<!-- INTRO -->
<section class="dest-section">
  <div class="sec-tag">About The Destination</div>
  <h2 class="sec-h2">Why Leh Ladakh is India's<br><em>greatest</em> self drive</h2>
  <p class="body-text">There is no road trip in India quite like Leh Ladakh. The route from Manali climbs through five mountain passes above 4,000 metres, crosses rivers fed by glaciers, and arrives in a high-altitude desert that looks nothing like the rest of the subcontinent. It is physically demanding, technically challenging, and completely unforgettable.</p>
  <p class="body-text">What makes Ladakh exceptional for self-drive is the sheer variety of terrain. Within a single circuit you drive through pine forests, barren moonscapes, turquoise lakes, Buddhist monasteries perched on clifftops, and the sand dunes of Nubra Valley — all connected by roads that push your vehicle and your driving to their limits.</p>
  <p class="body-text"><strong>FreeWheel Expeditions</strong> has run self-drive convoys to Leh Ladakh since the beginning. Our route covers the full Manali–Leh–Nubra–Pangong–Hanle–Umling La–Srinagar circuit — the most complete Ladakh experience available as a guided self-drive. You bring your vehicle. We handle the rest.</p>
</section>

<!-- ROUTES -->
<section class="dest-section dark">
  <div class="inner">
    <div class="sec-tag">The Route</div>
    <h2 class="sec-h2">Key stretches on the<br><em>Leh Ladakh</em> circuit</h2>
    <p class="body-text">The standard FreeWheel circuit runs Delhi → Manali → Leh → Nubra Valley → Pangong Tso → Hanle → Umling La → Leh → Kargil → Srinagar → Delhi. Here are the stretches that define the journey.</p>
    <div class="route-grid">
      <div class="route-card">
        <div class="route-name">Manali to Leh</div>
        <div class="route-dist">490 km · 2 days</div>
        <div class="route-desc">The iconic highway crosses Rohtang Pass, Baralacha La (4,890m), Nakee La, Lachulung La, and Tanglang La (5,328m). One of the most dramatic mountain drives on the planet.</div>
      </div>
      <div class="route-card">
        <div class="route-name">Leh to Nubra Valley</div>
        <div class="route-dist">160 km · 1 day</div>
        <div class="route-desc">Over Khardung La (5,359m), once considered the world's highest motorable pass. The descent into Nubra's sand dunes and Bactrian camels is a complete landscape shift.</div>
      </div>
      <div class="route-card">
        <div class="route-name">Nubra to Pangong Tso</div>
        <div class="route-dist">280 km · 1 day</div>
        <div class="route-desc">A challenging high-altitude traverse via Shyok River valley. The first glimpse of Pangong's impossible blue at 4,350m elevation rewards every difficult kilometre.</div>
      </div>
      <div class="route-card">
        <div class="route-name">Pangong to Umling La</div>
        <div class="route-dist">260 km · 1 day</div>
        <div class="route-desc">Via Hanle village and the world's highest motorable pass at 5,798m. The air is thin, the road is raw, and the achievement is permanent.</div>
      </div>
      <div class="route-card">
        <div class="route-name">Leh to Srinagar</div>
        <div class="route-dist">420 km · 1-2 days</div>
        <div class="route-desc">The Srinagar Highway via Magnetic Hill, Sangam, Lamayuru Monastery, and Zoji La. A fitting end to the circuit — Ladakh fading into Kashmir's green valleys.</div>
      </div>
      <div class="route-card">
        <div class="route-name">Srinagar to Delhi</div>
        <div class="route-dist">870 km · 1-2 days</div>
        <div class="route-desc">Through Banihal Tunnel, Jammu, and the plains. The contrast with where you've been makes the final drive its own kind of experience.</div>
      </div>
    </div>
  </div>
</section>

<!-- BEST TIME -->
<section class="dest-section">
  <div class="sec-tag">When To Go</div>
  <h2 class="sec-h2">Best time for<br><em>Leh Ladakh</em> self drive</h2>
  <p class="body-text">The Manali-Leh highway is seasonal — typically open from mid-June to mid-October. Outside this window, the passes are buried in snow. Here's how each month shapes up for a self-drive expedition.</p>
  <div class="month-grid">
    <div class="month-card">
      <div class="month-name">Jan–Mar</div>
      <span class="month-rating rating-avoid">Road Closed</span>
      <div class="month-note">Manali-Leh highway closed. Extreme cold. Only Srinagar route possible.</div>
    </div>
    <div class="month-card">
      <div class="month-name">April–May</div>
      <span class="month-rating rating-avoid">Risky</span>
      <div class="month-note">Roads opening. Unpredictable passes. Not recommended for first-timers.</div>
    </div>
    <div class="month-card">
      <div class="month-name">June</div>
      <span class="month-rating rating-good">Good</span>
      <div class="month-note">Highway fully open by mid-June. Good weather. Some snow on high passes.</div>
    </div>
    <div class="month-card">
      <div class="month-name">July–Aug</div>
      <span class="month-rating rating-good">Good</span>
      <div class="month-note">Peak season. All roads open. Occasional landslides during heavy rain.</div>
    </div>
    <div class="month-card">
      <div class="month-name">September</div>
      <span class="month-rating rating-best">Best</span>
      <div class="month-note">Clear skies, thin crowds, perfect temperatures. Ideal for photography and driving.</div>
    </div>
    <div class="month-card">
      <div class="month-name">October</div>
      <span class="month-rating rating-good">Good</span>
      <div class="month-note">Early October is excellent. Highway closes mid-month. Cold nights.</div>
    </div>
  </div>
</section>

<!-- CHECKLIST -->
<section class="dest-section dark">
  <div class="inner">
    <div class="sec-tag">Preparation</div>
    <h2 class="sec-h2">What you need before<br><em>you drive</em></h2>
    <p class="body-text">A Leh Ladakh self drive is not a road trip you improvise. Here's the non-negotiable preparation list.</p>
    <div class="checklist">
      <div class="check-item"><span class="check-ico">✓</span><span class="check-text"><strong>Vehicle service done</strong> — brakes, tyres, coolant, engine oil. High altitude is unforgiving of deferred maintenance.</span></div>
      <div class="check-item"><span class="check-ico">✓</span><span class="check-text"><strong>Spare tyre in good condition</strong> — carry two if possible. Tyre punctures are common on mountain gravel.</span></div>
      <div class="check-item"><span class="check-ico">✓</span><span class="check-text"><strong>Inner Line Permits</strong> — required for Nubra, Pangong, Hanle, and Umling La. Apply online before departure.</span></div>
      <div class="check-item"><span class="check-ico">✓</span><span class="check-text"><strong>Altitude medication</strong> — consult your doctor about Diamox. Acclimatise for 2 full days in Leh before ascending further.</span></div>
      <div class="check-item"><span class="check-ico">✓</span><span class="check-text"><strong>Offline maps downloaded</strong> — network is absent on most of the highway. Google Maps offline or Maps.me work well.</span></div>
      <div class="check-item"><span class="check-ico">✓</span><span class="check-text"><strong>Fuel planning</strong> — petrol stations are sparse. Always fill up completely in Manali, Leh, Kargil, and Srinagar.</span></div>
      <div class="check-item"><span class="check-ico">✓</span><span class="check-text"><strong>Layered clothing</strong> — temperatures swing from 25°C in Leh valley to below freezing at high passes, sometimes on the same day.</span></div>
      <div class="check-item"><span class="check-ico">✓</span><span class="check-text"><strong>Cash in hand</strong> — ATMs are unreliable beyond Leh. Carry sufficient cash for fuel, accommodation, and permits.</span></div>
    </div>
  </div>
</section>

<!-- FAQ -->
<section class="dest-section">
  <div class="sec-tag">Common Questions</div>
  <h2 class="sec-h2">Self Drive Leh Ladakh<br><em>FAQ</em></h2>
  <div class="faq-list">
    <?php foreach($faqs as $f): ?>
    <div class="faq-item">
      <div class="faq-q"><?php echo esc_html($f['q']); ?></div>
      <div class="faq-a"><?php echo esc_html($f['a']); ?></div>
    </div>
    <?php endforeach; ?>
  </div>
</section>

<!-- CTA -->
<section class="cta-band">
  <h2>Ready to Drive Leh?</h2>
  <p>Join FreeWheel's guided self-drive convoy — your vehicle, our support, the road of a lifetime.</p>
  <div class="cta-btns">
    <a href="/expedition/dream-leh-ladakh-self-drive-expedition/" class="btn-white">View Expedition Details</a>
    <a href="https://wa.me/917817838060?text=Hi%21%20I%20want%20to%20join%20the%20Leh%20Ladakh%20self%20drive%20expedition." class="btn-wa" target="_blank">
      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.123.554 4.118 1.528 5.85L.057 23.077a.75.75 0 0 0 .943.895l5.344-1.705A11.945 11.945 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.75a9.726 9.726 0 0 1-4.964-1.355l-.355-.212-3.693 1.178 1.131-3.595-.232-.371A9.725 9.725 0 0 1 2.25 12C2.25 6.615 6.615 2.25 12 2.25S21.75 6.615 21.75 12 17.385 21.75 12 21.75z"/></svg>
      WhatsApp Us
    </a>
  </div>
</section>

<script>
// FAQ accordion
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
