<?php
/**
 * Template Name: Self Drive Adi Kailash
 * Template Post Type: page
 *
 * FreeWheel Expeditions — Self Drive Adi Kailash Destination Guide
 */
get_header(); ?>
<style>
html,body,body.page,#page,#content,#primary,#main,.site,.site-content,.entry-content,.wp-site-blocks,main,article{background:#0f0d0b!important;background-color:#0f0d0b!important}
:root{--ink:#0f0d0b;--paper:#faf6f0;--sand:#e8dcc8;--smoke:#f2ece2;--rust:#c1440e;--amber:#e8a020;--teal:#2a7a6e;--headline:'Barlow Condensed',sans-serif}
*{box-sizing:border-box;margin:0;padding:0}
body{background:var(--ink);color:#fff;font-family:'Inter',sans-serif;font-size:16px;line-height:1.7}
a{color:inherit;text-decoration:none}
img{max-width:100%;height:auto}
.dest-hero{min-height:70vh;background:linear-gradient(to bottom,rgba(15,13,11,.4) 0%,rgba(15,13,11,.85) 100%),url('https://freewheelexpeditions.in/wp-content/uploads/2026/04/6-scaled.webp') center/cover no-repeat;display:flex;align-items:flex-end;padding:60px 5vw}
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
  ["q"=>"What is Adi Kailash and why is it significant?","a"=>"Adi Kailash, also called Chhota Kailash, is a sacred peak in the Kumaon Himalayas believed to be the earthly abode of Lord Shiva. At 6,191 metres, it resembles the famous Mount Kailash in Tibet but is accessible without crossing international borders. Om Parvat, nearby, is famous for the natural snow formation in the shape of 'Om' visible on its face."],
  ["q"=>"Can I do Adi Kailash self drive in my own vehicle?","a"=>"Yes. FreeWheel Expeditions runs a self-drive convoy to Adi Kailash where you drive your own vehicle. The route from Pithoragarh to Gunji (base for Adi Kailash) is motorable for 4x4 vehicles. The final stretch to the Adi Kailash viewpoint involves a short trek."],
  ["q"=>"What is the best time to visit Adi Kailash?","a"=>"May to June and September to October are the best months. The route is open by May after snow clearance and closes around November with winter snowfall. September is ideal for the Om Parvat snow formation to be clearly visible."],
  ["q"=>"What permits are required for Adi Kailash?","a"=>"Adi Kailash lies in a restricted zone near the Indo-Tibet border. An Inner Line Permit (ILP) is mandatory for all visitors. The permit is issued at the SDM office in Pithoragarh or Dharchula. FreeWheel handles the permit coordination for convoy members."],
  ["q"=>"How many days does the Adi Kailash expedition take?","a"=>"FreeWheel's Adi Kailash self-drive expedition is 7-9 days from Pithoragarh, covering the full circuit including Om Parvat viewpoint, Gunji, Kalapani, and Nabhidhang. The route is approximately 400 km round trip from Pithoragarh."],
  ["q"=>"What is the difference between Adi Kailash and Mount Kailash?","a"=>"Mount Kailash is in Tibet and requires international travel permits with limited access. Adi Kailash is in Uttarakhand, India, and is accessible to Indian nationals with an Inner Line Permit. Both are sacred to Hindus and Buddhists. The self-drive to Adi Kailash is one of the most accessible sacred Himalayan journeys you can do."],
  ["q"=>"Is the Adi Kailash route suitable for SUVs or only 4x4s?","a"=>"The route to Gunji is manageable for capable SUVs with decent ground clearance. A true 4x4 with low-range is recommended beyond Gunji. FreeWheel's route briefing covers vehicle requirements in detail before departure."],
  ["q"=>"What is Om Parvat and can it be seen during the expedition?","a"=>"Om Parvat (4,900m) is a peak near Adi Kailash famous for a natural snow formation on its face that resembles the Sanskrit symbol Om. It is visible from Nabhidhang during the expedition. The clarity of the formation depends on snow conditions and is best seen in September-October."],
];
echo '<script type="application/ld+json">' . json_encode([
  "@context"=>"https://schema.org","@type"=>"FAQPage",
  "mainEntity"=>array_map(fn($f)=>["@type"=>"Question","name"=>$f['q'],"acceptedAnswer"=>["@type"=>"Answer","text"=>$f['a']]],$faqs)
],JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) . '</script>';
echo '<script type="application/ld+json">' . json_encode([
  "@context"=>"https://schema.org","@type"=>"BreadcrumbList",
  "itemListElement"=>[
    ["@type"=>"ListItem","position"=>1,"name"=>"Home","item"=>"https://freewheelexpeditions.in/"],
    ["@type"=>"ListItem","position"=>2,"name"=>"Self Drive Adi Kailash","item"=>"https://freewheelexpeditions.in/self-drive-adi-kailash/"]
  ]
],JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) . '</script>';
?>

<section class="dest-hero">
  <div class="dest-hero-inner">
    <div class="dest-eyebrow">Destination Guide</div>
    <h1 class="dest-h1">Self Drive<br><span>Adi Kailash</span></h1>
    <p class="dest-hero-sub">The earthly abode of Shiva. Om Parvat's sacred snow formation. A high-altitude self-drive through Kumaon's most spiritual landscape — no Tibet visa required.</p>
    <a href="/expedition/adi-kailash-om-parvat-self-drive-expedition/" class="btn-solid">View Our Adi Kailash Expedition</a>
    <a href="https://wa.me/917817838060?text=Hi%21%20I%20want%20to%20know%20more%20about%20the%20Adi%20Kailash%20self%20drive%20expedition." class="btn-ghost" target="_blank">💬 WhatsApp Us</a>
  </div>
</section>

<div class="facts-bar">
  <div class="fact"><span class="fact-label">Best Season</span><span class="fact-val">May – Oct</span></div>
  <div class="fact"><span class="fact-label">Region</span><span class="fact-val">Kumaon, Uttarakhand</span></div>
  <div class="fact"><span class="fact-label">Peak Altitude</span><span class="fact-val">4,900 m</span></div>
  <div class="fact"><span class="fact-label">Duration</span><span class="fact-val">7–9 Days</span></div>
  <div class="fact"><span class="fact-label">Difficulty</span><span class="fact-val">Challenging</span></div>
  <div class="fact"><span class="fact-label">Permit</span><span class="fact-val">ILP Required</span></div>
</div>

<section class="dest-section">
  <div class="sec-tag">About The Destination</div>
  <h2 class="sec-h2">India's sacred <em>Himalayan</em> self drive</h2>
  <p class="body-text">Adi Kailash is one of the most spiritually significant destinations in the Himalayas — and one of the least visited. Located in the Pithoragarh district of Uttarakhand, just south of the Tibetan border, it offers what the famous Mount Kailash offers but without international travel complications.</p>
  <p class="body-text">The drive from Pithoragarh follows the Kali River through ancient Bhotiya villages, past the Kalapani sacred springs (origin point of the Kali River), and up to Gunji — the base for the Adi Kailash viewpoint trek. Along the way, Om Parvat reveals its famous natural snow formation, visible from Nabhidhang.</p>
  <p class="body-text"><strong>FreeWheel Expeditions</strong> runs a guided self-drive convoy to Adi Kailash that handles all permit coordination, route planning, and on-ground support. You experience one of India's most remote sacred landscapes — in your own vehicle, at your own pace.</p>
</section>

<section class="dest-section dark">
  <div class="inner">
    <div class="sec-tag">The Route</div>
    <h2 class="sec-h2">Key stops on the<br><em>Adi Kailash</em> circuit</h2>
    <div class="route-grid">
      <div class="route-card">
        <div class="route-name">Pithoragarh to Dharchula</div>
        <div class="route-dist">~90 km · Half day</div>
        <div class="route-desc">Start of the restricted zone. The Kali River runs alongside the entire route, forming the India-Nepal border.</div>
      </div>
      <div class="route-card">
        <div class="route-name">Dharchula to Gunji</div>
        <div class="route-dist">~90 km · Full day</div>
        <div class="route-desc">Through Tawaghat, Narayana Ashram, and Budhi village. The road climbs steeply with river crossings and loose sections.</div>
      </div>
      <div class="route-card">
        <div class="route-name">Kalapani</div>
        <div class="route-dist">Sacred confluence</div>
        <div class="route-desc">The origin of the Kali River, revered as sacred. A small Kali temple sits at the confluence of three streams at 3,600 metres.</div>
      </div>
      <div class="route-card">
        <div class="route-name">Nabhidhang</div>
        <div class="route-dist">Om Parvat viewpoint</div>
        <div class="route-desc">The closest motorable point to Om Parvat (4,900m). The Om snow formation is visible on clear days — September-October is best.</div>
      </div>
      <div class="route-card">
        <div class="route-name">Adi Kailash Viewpoint</div>
        <div class="route-dist">Short trek from Gunji</div>
        <div class="route-desc">A 3-4 hour trek from Gunji leads to the Adi Kailash base camp with direct views of the sacred peak at 6,191 metres.</div>
      </div>
      <div class="route-card">
        <div class="route-name">Return via Munsiyari</div>
        <div class="route-dist">Alternate scenic route</div>
        <div class="route-desc">FreeWheel's return circuit comes via Munsiyari — another stunning Kumaon town with Panchachuli views before the descent.</div>
      </div>
    </div>
  </div>
</section>

<section class="dest-section">
  <div class="sec-tag">Preparation</div>
  <h2 class="sec-h2">What you need before<br><em>you drive</em></h2>
  <div class="checklist">
    <div class="check-item"><span class="check-ico">✓</span><span class="check-text"><strong>Inner Line Permit</strong> — mandatory for the restricted zone. Apply in Pithoragarh or Dharchula. FreeWheel coordinates this.</span></div>
    <div class="check-item"><span class="check-ico">✓</span><span class="check-text"><strong>4x4 or capable SUV</strong> — the Dharchula-Gunji stretch has river crossings and loose mountain tracks.</span></div>
    <div class="check-item"><span class="check-ico">✓</span><span class="check-text"><strong>Trekking shoes</strong> — the final approach to Adi Kailash viewpoint is on foot. Carry proper footwear.</span></div>
    <div class="check-item"><span class="check-ico">✓</span><span class="check-text"><strong>Altitude preparation</strong> — Nabhidhang is at 4,900m. Spend extra time at Gunji to acclimatise before ascending.</span></div>
    <div class="check-item"><span class="check-ico">✓</span><span class="check-text"><strong>Cash only</strong> — no ATMs beyond Pithoragarh. Carry enough for fuel, accommodation, and food for the full duration.</span></div>
    <div class="check-item"><span class="check-ico">✓</span><span class="check-text"><strong>Offline maps</strong> — no network in the restricted zone. Download Maps.me offline pack for Uttarakhand.</span></div>
    <div class="check-item"><span class="check-ico">✓</span><span class="check-text"><strong>Warm layers</strong> — temperatures at Gunji and Nabhidhang drop below 5°C even in summer nights.</span></div>
    <div class="check-item"><span class="check-ico">✓</span><span class="check-text"><strong>Respect local customs</strong> — this is a sacred area. Minimal noise, no alcohol near temples, follow guide instructions.</span></div>
  </div>
</section>

<section class="dest-section dark">
  <div class="inner">
    <div class="sec-tag">Common Questions</div>
    <h2 class="sec-h2">Adi Kailash Self Drive<br><em>FAQ</em></h2>
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
  <h2>Ready to Drive to Adi Kailash?</h2>
  <p>Join FreeWheel's guided self-drive convoy to one of India's most sacred Himalayan destinations.</p>
  <div class="cta-btns">
    <a href="/expedition/adi-kailash-om-parvat-self-drive-expedition/" class="btn-white">View Expedition Details</a>
    <a href="https://wa.me/917817838060?text=Hi%21%20I%20want%20to%20join%20the%20Adi%20Kailash%20self%20drive%20expedition." class="btn-wa" target="_blank">
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
