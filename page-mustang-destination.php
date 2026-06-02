<?php
/**
 * Template Name: Self Drive Upper Mustang
 * Template Post Type: page
 *
 * FreeWheel Expeditions — Self Drive Upper Mustang Destination Guide
 */
get_header(); ?>
<style>
html,body,body.page,#page,#content,#primary,#main,.site,.site-content,.entry-content,.wp-site-blocks,main,article{background:#0f0d0b!important;background-color:#0f0d0b!important}
:root{--ink:#0f0d0b;--paper:#faf6f0;--sand:#e8dcc8;--smoke:#f2ece2;--rust:#c1440e;--amber:#e8a020;--teal:#2a7a6e;--headline:'Barlow Condensed',sans-serif}
*{box-sizing:border-box;margin:0;padding:0}
body{background:var(--ink);color:#fff;font-family:'Inter',sans-serif;font-size:16px;line-height:1.7}
a{color:inherit;text-decoration:none}
img{max-width:100%;height:auto}
.dest-hero{min-height:70vh;background:linear-gradient(to bottom,rgba(15,13,11,.4) 0%,rgba(15,13,11,.85) 100%),url('https://images.unsplash.com/photo-1544735716-392fe2489ffa?w=1920&q=80') center/cover no-repeat;display:flex;align-items:flex-end;padding:60px 5vw}
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
  ["q"=>"What is Upper Mustang and why is it called the Forbidden Kingdom?","a"=>"Upper Mustang is a remote region in northern Nepal, bordering Tibet. It was a restricted zone closed to outsiders until 1992 — hence the name Forbidden Kingdom. The landscape is a high-altitude desert of dramatic red and ochre cliffs, ancient cave monasteries, and Tibetan Buddhist culture largely unchanged for centuries. Lo Manthang, the walled capital, is unlike anywhere else on earth."],
  ["q"=>"Can I self drive to Upper Mustang from India?","a"=>"Yes. The FreeWheel Expeditions route drives from India (via Pokhara, Nepal) to Upper Mustang. You cross into Nepal at Sonauli, drive to Pokhara, then north through Jomsom to Lo Manthang. The Muktinath Temple en route is an additional major spiritual landmark."],
  ["q"=>"What permits are required for Upper Mustang?","a"=>"Upper Mustang requires two permits: the Annapurna Conservation Area Permit (ACAP) and the Restricted Area Permit (RAP) for Upper Mustang specifically. The RAP costs USD 500 per person for 10 days. FreeWheel handles all permit coordination for convoy members."],
  ["q"=>"What is the best time to visit Upper Mustang?","a"=>"March to November is the window. Unlike most Himalayan regions, Upper Mustang lies in a rain shadow zone — it receives very little monsoon rainfall, making June-August actually viable when the rest of Nepal is wet. May and October are peak months for clear skies and comfortable temperatures."],
  ["q"=>"How long does the Upper Mustang self drive expedition take?","a"=>"FreeWheel's expedition is 8 nights / 9 days covering the full circuit: India border crossing, Pokhara, Jomsom, Muktinath, Lo Manthang, and return. Total driving distance is approximately 1,800-2,000 km from the India border crossing point."],
  ["q"=>"What vehicle do I need for Upper Mustang?","a"=>"A 4x4 with good ground clearance is essential. The road from Jomsom to Lo Manthang is a rough mountain track alongside the Kali Gandaki gorge — the world's deepest river gorge. Tyre condition and engine health are critical given the remoteness."],
  ["q"=>"What is Muktinath and can it be visited during the expedition?","a"=>"Muktinath Temple (3,710m) is one of the most sacred pilgrimage sites in Hinduism and Buddhism, revered by both religions simultaneously. It is on the FreeWheel route between Jomsom and Lo Manthang and is visited as part of the expedition."],
  ["q"=>"Is Upper Mustang open year-round?","a"=>"The road from Jomsom to Lo Manthang can be accessible most of the year in dry conditions, but winter (December-February) brings heavy snow and extreme cold. November onwards sees the route deteriorating. March to November is the practical window for self-drive access."],
];
echo '<script type="application/ld+json">' . json_encode([
  "@context"=>"https://schema.org","@type"=>"FAQPage",
  "mainEntity"=>array_map(fn($f)=>["@type"=>"Question","name"=>$f['q'],"acceptedAnswer"=>["@type"=>"Answer","text"=>$f['a']]],$faqs)
],JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) . '</script>';
echo '<script type="application/ld+json">' . json_encode([
  "@context"=>"https://schema.org","@type"=>"BreadcrumbList",
  "itemListElement"=>[
    ["@type"=>"ListItem","position"=>1,"name"=>"Home","item"=>"https://freewheelexpeditions.in/"],
    ["@type"=>"ListItem","position"=>2,"name"=>"Self Drive Upper Mustang","item"=>"https://freewheelexpeditions.in/self-drive-upper-mustang/"]
  ]
],JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) . '</script>';
?>

<section class="dest-hero">
  <div class="dest-hero-inner">
    <div class="dest-eyebrow">Destination Guide</div>
    <h1 class="dest-h1">Self Drive<br><span>Upper Mustang</span></h1>
    <p class="dest-hero-sub">The Forbidden Kingdom of Nepal. Ancient cave monasteries. Lo Manthang's walled city. A desert unlike anything in India — drive there yourself.</p>
    <a href="/expedition/upper-mustang-muktinath-expedition/" class="btn-solid">View Our Mustang Expedition</a>
    <a href="https://wa.me/917817838060?text=Hi%21%20I%20want%20to%20know%20more%20about%20the%20Upper%20Mustang%20self%20drive%20expedition." class="btn-ghost" target="_blank">💬 WhatsApp Us</a>
  </div>
</section>

<div class="facts-bar">
  <div class="fact"><span class="fact-label">Best Season</span><span class="fact-val">May – Oct</span></div>
  <div class="fact"><span class="fact-label">Country</span><span class="fact-val">Nepal</span></div>
  <div class="fact"><span class="fact-label">Max Altitude</span><span class="fact-val">3,840 m</span></div>
  <div class="fact"><span class="fact-label">Duration</span><span class="fact-val">8N / 9D</span></div>
  <div class="fact"><span class="fact-label">Permit Cost</span><span class="fact-val">USD 500/person</span></div>
  <div class="fact"><span class="fact-label">Difficulty</span><span class="fact-val">Challenging</span></div>
</div>

<section class="dest-section">
  <div class="sec-tag">About The Destination</div>
  <h2 class="sec-h2">The last <em>Forbidden Kingdom</em></h2>
  <p class="body-text">Upper Mustang is one of the most extraordinary places on earth. A high-altitude desert that sits in the rain shadow of the Himalayas, it receives almost no rainfall — the landscape is a surreal expanse of wind-carved red cliffs, ancient cave dwellings, and Buddhist monasteries that have stood for 500 years.</p>
  <p class="body-text">Lo Manthang, the ancient walled capital, was closed to outsiders until 1992. Even today it requires a special Restricted Area Permit that limits visitor numbers. The culture inside is closer to Tibet than to Nepal — the Loba people, their language, their monasteries, and their festivals are a window into a world that barely exists anywhere else.</p>
  <p class="body-text"><strong>FreeWheel Expeditions</strong> runs India's only guided self-drive convoy to Upper Mustang. The route crosses into Nepal, passes through Pokhara and Muktinath, and winds up the Kali Gandaki gorge to Lo Manthang. You drive your own vehicle into one of the world's most restricted — and most spectacular — landscapes.</p>
</section>

<section class="dest-section dark">
  <div class="inner">
    <div class="sec-tag">The Route</div>
    <h2 class="sec-h2">Key stops on the<br><em>Upper Mustang</em> circuit</h2>
    <div class="route-grid">
      <div class="route-card">
        <div class="route-name">India Border to Pokhara</div>
        <div class="route-dist">~300 km · 1 day</div>
        <div class="route-desc">Cross into Nepal at Sonauli/Belahiya. Drive to Pokhara — Nepal's adventure capital and the launchpad for Upper Mustang.</div>
      </div>
      <div class="route-card">
        <div class="route-name">Pokhara to Jomsom</div>
        <div class="route-dist">~180 km · 1 day</div>
        <div class="route-desc">The approach road climbs through Beni and Tatopani into the Kali Gandaki valley. The landscape shifts from lush green to stark desert as you gain altitude.</div>
      </div>
      <div class="route-card">
        <div class="route-name">Muktinath Temple</div>
        <div class="route-dist">3,710 m altitude</div>
        <div class="route-desc">Sacred to both Hindus and Buddhists. The 108 water spouts and eternal flame make this one of Nepal's most significant pilgrimage sites.</div>
      </div>
      <div class="route-card">
        <div class="route-name">Jomsom to Lo Manthang</div>
        <div class="route-dist">~75 km · Full day</div>
        <div class="route-desc">The iconic Upper Mustang drive. Through Kagbeni, Chele, and Syangboche — red cliffs, ancient villages, and the world's deepest gorge alongside you.</div>
      </div>
      <div class="route-card">
        <div class="route-name">Lo Manthang</div>
        <div class="route-dist">3,840 m altitude</div>
        <div class="route-desc">The walled capital of the former Kingdom of Lo. Ancient monasteries, cave dwellings, and the palace of the King of Mustang. Spend 2 nights to explore.</div>
      </div>
      <div class="route-card">
        <div class="route-name">Return to Pokhara</div>
        <div class="route-dist">Via same route · 2 days</div>
        <div class="route-desc">The return is equally dramatic. Stop at Marpha apple orchards and Tukuche before descending back to Pokhara's lakeside.</div>
      </div>
    </div>
  </div>
</section>

<section class="dest-section">
  <div class="sec-tag">Preparation</div>
  <h2 class="sec-h2">What you need before<br><em>you drive</em></h2>
  <div class="checklist">
    <div class="check-item"><span class="check-ico">✓</span><span class="check-text"><strong>Valid Indian passport</strong> — required for Nepal entry. Aadhaar card also accepted at the Sonauli border crossing.</span></div>
    <div class="check-item"><span class="check-ico">✓</span><span class="check-text"><strong>Upper Mustang RAP permit</strong> — USD 500 per person for 10 days. FreeWheel coordinates this. Apply in advance.</span></div>
    <div class="check-item"><span class="check-ico">✓</span><span class="check-text"><strong>Nepal vehicle permit</strong> — Indian vehicles require a temporary import permit at the border. FreeWheel handles the paperwork.</span></div>
    <div class="check-item"><span class="check-ico">✓</span><span class="check-text"><strong>4x4 with good tyres</strong> — the Lo Manthang road is rough gravel and rock. Tyre condition is critical.</span></div>
    <div class="check-item"><span class="check-ico">✓</span><span class="check-text"><strong>Nepal currency (NPR)</strong> — exchange at the border or in Pokhara. Cards not accepted beyond Jomsom.</span></div>
    <div class="check-item"><span class="check-ico">✓</span><span class="check-text"><strong>Altitude preparation</strong> — spend extra time in Jomsom before ascending. Altitude sickness can occur above 3,500m.</span></div>
    <div class="check-item"><span class="check-ico">✓</span><span class="check-text"><strong>Windproof layers</strong> — Kali Gandaki valley has extreme winds. The gorge funnels air at high speed, especially afternoons.</span></div>
    <div class="check-item"><span class="check-ico">✓</span><span class="check-text"><strong>Spare fuel capacity</strong> — petrol stations are limited beyond Jomsom. FreeWheel coordinates fuel logistics for the convoy.</span></div>
  </div>
</section>

<section class="dest-section dark">
  <div class="inner">
    <div class="sec-tag">Common Questions</div>
    <h2 class="sec-h2">Upper Mustang Self Drive<br><em>FAQ</em></h2>
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
  <h2>Ready to Drive to Mustang?</h2>
  <p>Join FreeWheel's convoy into the Forbidden Kingdom — the only guided Indian self-drive to Lo Manthang.</p>
  <div class="cta-btns">
    <a href="/expedition/upper-mustang-muktinath-expedition/" class="btn-white">View Expedition Details</a>
    <a href="https://wa.me/917817838060?text=Hi%21%20I%20want%20to%20join%20the%20Upper%20Mustang%20self%20drive%20expedition." class="btn-wa" target="_blank">
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
