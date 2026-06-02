<?php
/**
 * Template Name: Self Drive Darma Valley
 * Template Post Type: page
 *
 * FreeWheel Expeditions — Self Drive Darma Valley Destination Guide
 */
get_header(); ?>
<style>
html,body,body.page,#page,#content,#primary,#main,.site,.site-content,.entry-content,.wp-site-blocks,main,article{background:#0f0d0b!important;background-color:#0f0d0b!important}
:root{--ink:#0f0d0b;--paper:#faf6f0;--sand:#e8dcc8;--smoke:#f2ece2;--rust:#c1440e;--amber:#e8a020;--teal:#2a7a6e;--headline:'Barlow Condensed',sans-serif}
*{box-sizing:border-box;margin:0;padding:0}
body{background:var(--ink);color:#fff;font-family:'Inter',sans-serif;font-size:16px;line-height:1.7}
a{color:inherit;text-decoration:none}
img{max-width:100%;height:auto}
.dest-hero{min-height:70vh;background:linear-gradient(to bottom,rgba(15,13,11,.4) 0%,rgba(15,13,11,.85) 100%),url('https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=1920&q=80') center/cover no-repeat;display:flex;align-items:flex-end;padding:60px 5vw}
.dest-hero-inner{max-width:900px}
.dest-eyebrow{font-size:11px;letter-spacing:4px;text-transform:uppercase;color:var(--amber);margin-bottom:16px}
.dest-h1{font-family:var(--headline);font-size:clamp(48px,8vw,90px);line-height:.92;letter-spacing:2px;color:#fff;margin-bottom:20px}
.dest-h1 span{color:var(--rust)}
.dest-hero-sub{font-size:18px;color:rgba(255,255,255,.7);max-width:600px;line-height:1.7;margin-bottom:32px}
.btn-solid{display:inline-block;padding:14px 32px;background:var(--rust);color:#fff;font-family:var(--headline);font-size:16px;letter-spacing:2px;text-transform:uppercase;border-radius:2px;transition:background .2s}
.btn-solid:hover{background:#a33a0c}
.btn-ghost{display:inline-block;padding:14px 32px;border:2px solid rgba(255,255,255,.4);color:#fff;font-family:var(--headline);font-size:16px;letter-spacing:2px;text-transform:uppercase;border-radius:2px;margin-left:12px;transition:border-color .2s}
.btn-ghost:hover{border-color:#fff}
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
  ["q"=>"What is the Darma Valley expedition?","a"=>"The Darma Valley expedition is an off-road self-drive journey through the remote Kumaon Himalayas in Uttarakhand. The route covers Rimkhim Pass, Lapthal Valley, and the Darma Valley — areas rarely visited by tourists, with views of Panchachuli peaks and ancient Bhotiya villages."],
  ["q"=>"How difficult is the Darma Valley self drive route?","a"=>"It is a challenging expedition. The roads are rough, unmaintained tracks with river crossings, steep ascents, and loose gravel. A 4x4 vehicle is strongly recommended. FreeWheel provides route support and emergency assistance throughout."],
  ["q"=>"What is the best time to visit Darma Valley?","a"=>"June to September is the ideal window. The valley is inaccessible in winter due to heavy snowfall. September offers the clearest skies and best photography conditions with Panchachuli peaks fully visible."],
  ["q"=>"Which vehicle is best for the Darma Valley expedition?","a"=>"A 4x4 SUV with good ground clearance is ideal — Thar, Jimny, Fortuner, or equivalent. Modified vehicles with a snorkel are an advantage for river crossings. Standard hatchbacks are not recommended for this route."],
  ["q"=>"What permits are required for Darma Valley?","a"=>"Darma Valley falls in a restricted zone near the Indo-China border. An Inner Line Permit (ILP) is mandatory for all visitors and must be obtained from the SDM office in Dharchula before entering the valley."],
  ["q"=>"How far is Darma Valley from Delhi?","a"=>"Darma Valley is approximately 600-650 km from Delhi via Haldwani, Almora, and Pithoragarh. The FreeWheel expedition typically starts from Haldwani or Pithoragarh, covering the full circuit over 8-10 days."],
  ["q"=>"What makes Rimkhim Pass special?","a"=>"Rimkhim Pass sits at over 3,500 metres and offers sweeping views of the Panchachuli range — five snow-capped peaks sacred in Hindu mythology. It is one of the least-visited high passes in Kumaon, making it a genuine off-the-beaten-path experience."],
  ["q"=>"Is the Darma Valley expedition suitable for solo drivers?","a"=>"Not recommended solo due to the remoteness and difficulty of the route. FreeWheel's convoy format is ideal — you drive your own vehicle with the safety of a group, route lead, and on-ground support team."],
];
echo '<script type="application/ld+json">' . json_encode([
  "@context"=>"https://schema.org","@type"=>"FAQPage",
  "mainEntity"=>array_map(fn($f)=>["@type"=>"Question","name"=>$f['q'],"acceptedAnswer"=>["@type"=>"Answer","text"=>$f['a']]],$faqs)
],JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) . '</script>';
echo '<script type="application/ld+json">' . json_encode([
  "@context"=>"https://schema.org","@type"=>"BreadcrumbList",
  "itemListElement"=>[
    ["@type"=>"ListItem","position"=>1,"name"=>"Home","item"=>"https://freewheelexpeditions.in/"],
    ["@type"=>"ListItem","position"=>2,"name"=>"Self Drive Darma Valley","item"=>"https://freewheelexpeditions.in/self-drive-darma-valley/"]
  ]
],JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) . '</script>';
?>

<section class="dest-hero">
  <div class="dest-hero-inner">
    <div class="dest-eyebrow">Destination Guide</div>
    <h1 class="dest-h1">Self Drive<br><span>Darma Valley</span></h1>
    <p class="dest-hero-sub">Rimkhim Pass. Lapthal Valley. Panchachuli views. One of Kumaon's most remote and rewarding off-road expeditions — driven your way.</p>
    <a href="/expedition/rimkhim-pass-lapthal-darma-valley-expedition/" class="btn-solid">View Our Darma Expedition</a>
    <a href="https://wa.me/917817838060?text=Hi%21%20I%20want%20to%20know%20more%20about%20the%20Darma%20Valley%20self%20drive%20expedition." class="btn-ghost" target="_blank">💬 WhatsApp Us</a>
  </div>
</section>

<div class="facts-bar">
  <div class="fact"><span class="fact-label">Best Season</span><span class="fact-val">June – September</span></div>
  <div class="fact"><span class="fact-label">Region</span><span class="fact-val">Kumaon, Uttarakhand</span></div>
  <div class="fact"><span class="fact-label">Max Altitude</span><span class="fact-val">~3,600 m</span></div>
  <div class="fact"><span class="fact-label">Duration</span><span class="fact-val">8–10 Days</span></div>
  <div class="fact"><span class="fact-label">Difficulty</span><span class="fact-val">Very Challenging</span></div>
  <div class="fact"><span class="fact-label">Vehicle</span><span class="fact-val">4x4 Required</span></div>
</div>

<section class="dest-section">
  <div class="sec-tag">About The Destination</div>
  <h2 class="sec-h2">Kumaon's most <em>remote</em> off-road valley</h2>
  <p class="body-text">Darma Valley sits in the far eastern corner of Uttarakhand, tucked against the Tibetan plateau and guarded by the five Panchachuli peaks. Most people have never heard of it. That's exactly what makes it extraordinary.</p>
  <p class="body-text">The route through Rimkhim Pass and Lapthal Valley is not a road trip — it's a proper off-road expedition. River crossings, broken tracks, altitude shifts, and ancient Bhotiya villages that have barely changed in centuries. The kind of place that reminds you why you started driving in the first place.</p>
  <p class="body-text"><strong>FreeWheel Expeditions</strong> runs one of the only guided self-drive convoys to Darma Valley. Our route covers the full Kumaon circuit from Haldwani — including Rimkhim Pass, Lapthal, Darma Valley, and the Panchachuli base viewpoints. You drive. We handle permits, logistics, and emergency support.</p>
</section>

<section class="dest-section dark">
  <div class="inner">
    <div class="sec-tag">The Route</div>
    <h2 class="sec-h2">Key stretches of the<br><em>Darma Valley</em> circuit</h2>
    <div class="route-grid">
      <div class="route-card">
        <div class="route-name">Haldwani to Pithoragarh</div>
        <div class="route-dist">~220 km · 1 day</div>
        <div class="route-desc">The gateway to Kumaon's high valleys. The road climbs through Almora and Bageshwar, with Himalayan views opening up progressively.</div>
      </div>
      <div class="route-card">
        <div class="route-name">Pithoragarh to Dharchula</div>
        <div class="route-dist">~90 km · Half day</div>
        <div class="route-desc">Following the Kali River along the Indo-Nepal border. Dharchula is the last major town before entering restricted territory.</div>
      </div>
      <div class="route-card">
        <div class="route-name">Dharchula to Darma Valley</div>
        <div class="route-dist">~60 km · Full day</div>
        <div class="route-desc">The toughest stretch. Rough tracks, river crossings, and the final climb into the valley. 4x4 essential. Rewards with complete isolation.</div>
      </div>
      <div class="route-card">
        <div class="route-name">Rimkhim Pass</div>
        <div class="route-dist">~3,500 m altitude</div>
        <div class="route-desc">The high point of the expedition. Panoramic views of the Panchachuli range — five sacred peaks rising above 6,000 metres.</div>
      </div>
      <div class="route-card">
        <div class="route-name">Lapthal Valley</div>
        <div class="route-dist">Off-road traverse</div>
        <div class="route-desc">A hidden valley connecting Rimkhim to Darma. Ancient shepherd trails, alpine meadows, and zero mobile signal.</div>
      </div>
      <div class="route-card">
        <div class="route-name">Return via Munsiyari</div>
        <div class="route-dist">~150 km · 1 day</div>
        <div class="route-desc">The scenic return through Munsiyari — another Kumaon gem — with Panchachuli views before dropping back to Pithoragarh.</div>
      </div>
    </div>
  </div>
</section>

<section class="dest-section">
  <div class="sec-tag">Preparation</div>
  <h2 class="sec-h2">What you need before<br><em>you drive</em></h2>
  <div class="checklist">
    <div class="check-item"><span class="check-ico">✓</span><span class="check-text"><strong>4x4 vehicle mandatory</strong> — river crossings and loose tracks make this inaccessible for standard cars.</span></div>
    <div class="check-item"><span class="check-ico">✓</span><span class="check-text"><strong>Inner Line Permit</strong> — apply at SDM office, Dharchula. FreeWheel assists with permit logistics.</span></div>
    <div class="check-item"><span class="check-ico">✓</span><span class="check-text"><strong>Full fuel before Dharchula</strong> — no petrol stations beyond this point. Carry a jerry can.</span></div>
    <div class="check-item"><span class="check-ico">✓</span><span class="check-text"><strong>Offline maps downloaded</strong> — zero connectivity in the valley. Maps.me with offline Uttarakhand pack.</span></div>
    <div class="check-item"><span class="check-ico">✓</span><span class="check-text"><strong>Recovery gear</strong> — tow rope, high lift jack, shovel. River crossings can get vehicles stuck.</span></div>
    <div class="check-item"><span class="check-ico">✓</span><span class="check-text"><strong>Warm layers</strong> — nights drop sharply at altitude even in summer. Carry thermals and a down jacket.</span></div>
    <div class="check-item"><span class="check-ico">✓</span><span class="check-text"><strong>Cash only</strong> — no ATMs beyond Pithoragarh. Carry enough for the full duration.</span></div>
    <div class="check-item"><span class="check-ico">✓</span><span class="check-text"><strong>First aid kit</strong> — remoteness means no hospitals. FreeWheel carries a team kit but personal basics are essential.</span></div>
  </div>
</section>

<section class="dest-section dark">
  <div class="inner">
    <div class="sec-tag">Common Questions</div>
    <h2 class="sec-h2">Darma Valley Self Drive<br><em>FAQ</em></h2>
    <div class="faq-list">
      <?php foreach($faqs as $f): ?>
      <div class="faq-item">
        <div class="faq-q"><?php echo esc_html($f['q']); ?></div>
        <div class="faq-a"><?php echo esc_html($f['a']); ?></div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="cta-band">
  <h2>Ready to Drive Darma?</h2>
  <p>Join FreeWheel's guided off-road convoy into one of Kumaon's most remote valleys.</p>
  <div class="cta-btns">
    <a href="/expedition/rimkhim-pass-lapthal-darma-valley-expedition/" class="btn-white">View Expedition Details</a>
    <a href="https://wa.me/917817838060?text=Hi%21%20I%20want%20to%20join%20the%20Darma%20Valley%20self%20drive%20expedition." class="btn-wa" target="_blank">
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
