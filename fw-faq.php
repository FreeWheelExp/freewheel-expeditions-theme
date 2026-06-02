<?php
/**
 * FreeWheel Expeditions — FAQ Section
 * Drop this anywhere inside a trip page: <?php include get_template_directory().'/fw-faq.php'; ?>
 * OR use the shortcode: [fw_faq expedition="nepal"]
 *
 * TO EDIT FAQs: scroll to the $FW_FAQS array below.
 * Add/remove questions freely. No code knowledge needed.
 */

/* ═══════════════════════════════════════════════════════════
   FAQ DATA — Edit freely. Add questions, remove, reorder.
   Format: array('q' => 'Question', 'a' => 'Answer')
═══════════════════════════════════════════════════════════ */
$FW_FAQS = array(

  /* ── COMMON TO ALL TRIPS (shown on every expedition page) ── */
  'common' => array(
    array(
      'q' => 'Do I need a 4x4 vehicle for FreeWheel expeditions?',
      'a' => 'It depends on the expedition. High-altitude routes like Spiti, Leh Ladakh, and Upper Mustang require a 4x4 or high ground-clearance vehicle. Destinations like Nepal\'s lower circuits can be done in standard SUVs. Each expedition listing clearly states vehicle requirements.'
    ),
    array(
      'q' => 'Do I drive alone or with a convoy?',
      'a' => 'You drive your own vehicle but as part of a convoy. You are never alone — there\'s a lead vehicle, a sweep vehicle (at the back), and a dedicated WhatsApp group for the convoy. You maintain your independence while having full safety backup.'
    ),
    array(
      'q' => 'What if my vehicle breaks down on the route?',
      'a' => 'Every FreeWheel expedition has a mechanic/support vehicle in the convoy. For major breakdowns, we arrange local help and if needed, vehicle recovery. This is why we vet all vehicles before departure — we share a pre-expedition checklist so you arrive prepared.'
    ),
    array(
      'q' => 'Can I join without prior expedition experience?',
      'a' => 'Yes, but comfort with driving on mountain roads is essential. We recommend starting with a moderate route (Spiti or Adi Kailash) if it\'s your first high-altitude self-drive. Our team guides you throughout.'
    ),
    array(
      'q' => 'What is included in the expedition price?',
      'a' => 'Inclusions vary per expedition and are listed on each trip page. Typically included: accommodation (as per itinerary), selected meals, convoy support, mechanic backup, route guidance, permits assistance, and a dedicated trip captain. Fuel, personal expenses, and flights are excluded.'
    ),
    array(
      'q' => 'How do I book? Is there a booking form?',
      'a' => 'Booking is done via WhatsApp — click the "Book via WhatsApp" button on any expedition page. Our team will share the booking form, slot confirmation, and payment details. We keep it personal and direct.'
    ),
    array(
      'q' => 'What is the cancellation policy?',
      'a' => 'Cancellation more than 30 days before: 80% refund. 15–30 days: 50% refund. Less than 15 days: no refund. Force majeure situations (road closures, natural disasters) are handled on a case-by-case basis. We always try to offer a slot transfer first.'
    ),
    array(
      'q' => 'Is travel insurance mandatory?',
      'a' => 'Strongly recommended and effectively mandatory for international routes (Nepal, etc.). For domestic expeditions, personal accident insurance is advised. We share a checklist before departure including recommended insurance providers.'
    ),
  ),

  /* ── NEPAL / UPPER MUSTANG SPECIFIC ── */
  'nepal' => array(
    array(
      'q' => 'Do I need a special permit for Upper Mustang?',
      'a' => 'Yes. Upper Mustang is a Restricted Area — you need a Restricted Area Permit (RAP) which costs approx. NPR 500/day. Our team handles all permit documentation as part of the expedition. You just need your passport.'
    ),
    array(
      'q' => 'What documents do I need to drive in Nepal?',
      'a' => 'Indian driving licence is valid in Nepal. You\'ll also need your vehicle\'s original RC (Registration Certificate), insurance papers, and a passport. We share a full documents checklist before departure.'
    ),
    array(
      'q' => 'Can I cross into Nepal in my own Indian-registered vehicle?',
      'a' => 'Yes. Indian vehicles can enter Nepal at designated border crossings. The most common for Mustang routes is Sunauli (UP border) or Raxaul (Bihar). We coordinate the border crossing as a convoy.'
    ),
    array(
      'q' => 'Is the Upper Mustang route suitable for non-4x4 vehicles?',
      'a' => 'No. Upper Mustang (Lo Manthang and beyond) is strictly 4x4 only. Roads are jeep tracks with river crossings and loose gravel. Minimum: high ground clearance 4WD with low-range gearbox. Diesel SUVs are preferred.'
    ),
    array(
      'q' => 'What is the best time to drive to Upper Mustang?',
      'a' => 'April–June and September–November. The route is in a rain shadow region so it\'s drivable even during monsoon (July–August), but river crossings get tricky. Our May expedition catches the Lo-Manthang festival season — a rare experience.'
    ),
    array(
      'q' => 'What altitude will we reach on the Nepal expedition?',
      'a' => 'Kagbeni sits at ~2,800m and Lo Manthang at ~3,800m. Some passes on the jeep track cross 4,000m+. Acclimatisation days are built into the itinerary. Carry altitude sickness medication (Diamox) as a precaution.'
    ),
    array(
      'q' => 'Are there fuel stations on the Upper Mustang route?',
      'a' => 'Limited. Last reliable fuel station is Jomsom. Beyond that, fuel is available but expensive and sometimes unavailable. We advise carrying 20–30 litres of extra fuel in a jerry can from Pokhara or Jomsom.'
    ),
  ),

  /* ── LEH LADAKH SPECIFIC ── */
  'leh' => array(
    array(
      'q' => 'When does the Leh Ladakh route open?',
      'a' => 'Manali-Leh Highway typically opens in late May / early June. Srinagar-Leh opens slightly earlier (April–May). Our August expedition is peak season — both highways are open and weather is stable.'
    ),
    array(
      'q' => 'What altitude will we drive at in Ladakh?',
      'a' => 'Leh city is at 3,500m. Khardung La (one of the world\'s highest motorable passes) is ~5,359m. We spend 2-3 days in Leh for acclimatisation before going higher. Altitude sickness prevention is covered in our pre-trip briefing.'
    ),
    array(
      'q' => 'Do I need permits for Ladakh?',
      'a' => 'Yes for certain areas — Inner Line Permits (ILP) for Nubra, Pangong, and Tso Moriri. We arrange these as part of the expedition logistics. Indian nationals can apply online or we handle it in Leh.'
    ),
    array(
      'q' => 'Is Ladakh accessible in a petrol SUV?',
      'a' => 'Yes for most routes. Diesel is preferred (better torque at altitude) but petrol SUVs like Fortuner, Thar, or XUV700 handle Ladakh well. Avoid small hatchbacks or city cars. High ground clearance essential.'
    ),
    array(
      'q' => 'What are road conditions like in August?',
      'a' => 'Generally good in August. Manali-Leh has some rocky sections near Baralacha La. River crossings can be swollen in August due to glacial melt — we time crossings in the morning when water levels are lower. Our recce team checks conditions before each convoy.'
    ),
  ),

  /* ── SPITI VALLEY SPECIFIC ── */
  'spiti' => array(
    array(
      'q' => 'Can Spiti Valley be done in a standard car?',
      'a' => 'Technically some parts of Spiti (Kaza, Tabo, Dhankar) are accessible in a regular car via Shimla-Reckong Peo. But the Kunzum Pass section (entering from Manali) requires high ground clearance. Our expedition uses the full circuit — a high-clearance 4x4 is strongly recommended.'
    ),
    array(
      'q' => 'When does Kunzum Pass open?',
      'a' => 'Kunzum Pass (4,590m) typically opens in late May / early June and closes by October-November. Our expedition is timed for when the pass is fully accessible and snowmelt has stabilised.'
    ),
    array(
      'q' => 'Is there network connectivity in Spiti?',
      'a' => 'BSNL/Jio have patchy coverage in Kaza and some major villages. Expect large stretches with zero connectivity. This is part of the experience — our convoy stays connected via walkie-talkies and we have satellite communication for emergencies.'
    ),
    array(
      'q' => 'What is the iconic highlight of Spiti?',
      'a' => 'Chandratal Lake (Moon Lake) at 4,300m is the crown jewel — a turquoise glacial lake at high altitude. Key Monastery, Dhankar Monastery hanging off a cliff, and the barren moonscape of the Pin Valley are equally unforgettable.'
    ),
  ),

  /* ── ADI KAILASH / OM PARVAT SPECIFIC ── */
  'adikailash' => array(
    array(
      'q' => 'Is Adi Kailash the same as Mount Kailash in Tibet?',
      'a' => 'No, but closely linked spiritually. Adi Kailash is in Uttarakhand, India, near the Tibet border. It is considered the Indian equivalent of Mount Kailash and is far less crowded. Om Parvat (where natural snow forms the "OM" symbol) is visited on the same route.'
    ),
    array(
      'q' => 'Do I need special permits for Adi Kailash?',
      'a' => 'Yes. It is an Inner Line Permit (ILP) zone near the China border. Indian nationals must register. Our team handles all paperwork. Foreign nationals require additional clearance and should enquire separately.'
    ),
    array(
      'q' => 'What is the road like to Adi Kailash?',
      'a' => 'The route via Pithoragarh and Dharchula has stretches of narrow mountain roads, river crossings, and some landslide-prone sections. High ground clearance mandatory. The final stretch to Jolingkong (Adi Kailash base) is a trek — vehicles stop at Gunji.'
    ),
    array(
      'q' => 'Is this a religious trip or adventure trip?',
      'a' => 'Both. It attracts spiritual seekers (pilgrims, yogis) and adventure drivers equally. The natural spectacle of Om Parvat\'s snow "OM" and the raw Himalayan landscape make it meaningful regardless of religious beliefs.'
    ),
    array(
      'q' => 'What is the distance and driving duration from Delhi?',
      'a' => 'Approximately 600–650km from Delhi to Dharchula. We typically drive in 2 stages: Delhi → Almora/Pithoragarh (Day 1), Pithoragarh → Dharchula → further (Day 2+). Total expedition is 4 Nights / 5 Days.'
    ),
  ),

);

/* ════════════════════════════════════════════════════════════
   GETTER — returns the full FAQ data array
════════════════════════════════════════════════════════════ */
function fw_get_faqs() {
    global $FW_FAQS;
    return $FW_FAQS;
}

/* ════════════════════════════════════════════════════════════
   SHORTCODE — [fw_faq expedition="nepal"]
   Auto-detects current expedition if not specified.
════════════════════════════════════════════════════════════ */
function fw_render_faq($atts = array()) {
    global $FW_FAQS;

    $atts = shortcode_atts(array('expedition' => 'auto'), $atts);
    $exp  = $atts['expedition'];

    // Auto-detect from current post slug
    if ($exp === 'auto') {
        $slug = get_post_field('post_name', get_the_ID());
        if (!$slug) {
            // Try from URL
            $slug = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
        }
        // Map slug to expedition key
        $slug_map = array(
            'nepal'       => 'nepal',
            'leh'         => 'leh',
            'ladakh'      => 'leh',
            'spiti'       => 'spiti',
            'adikailash'  => 'adikailash',
            'adi-kailash' => 'adikailash',
        );
        $exp = isset($slug_map[$slug]) ? $slug_map[$slug] : 'common';
    }

    // Merge common FAQs + expedition-specific
    $faqs = isset($FW_FAQS['common']) ? $FW_FAQS['common'] : array();
    if ($exp !== 'common' && isset($FW_FAQS[$exp])) {
        // Put expedition-specific first
        $faqs = array_merge($FW_FAQS[$exp], $faqs);
    }

    if (empty($faqs)) return '';

    ob_start();
    fw_faq_output($faqs, $exp);
    return ob_get_clean();
}
add_shortcode('fw_faq', 'fw_render_faq');

/* ════════════════════════════════════════════════════════════
   DIRECT INCLUDE — called from expedition page templates
   Usage: fw_faq_section('nepal');  or  fw_faq_section();
════════════════════════════════════════════════════════════ */
function fw_faq_section($expedition = 'common') {
    global $FW_FAQS;
    $faqs = isset($FW_FAQS['common']) ? $FW_FAQS['common'] : array();
    if ($expedition !== 'common' && isset($FW_FAQS[$expedition])) {
        $faqs = array_merge($FW_FAQS[$expedition], $faqs);
    }
    if (!empty($faqs)) fw_faq_output($faqs, $expedition);
}

/* ════════════════════════════════════════════════════════════
   HTML OUTPUT
════════════════════════════════════════════════════════════ */
function fw_faq_output($faqs, $expedition = '') {
    ?>
    <section class="fw-faq-section" id="faq" aria-label="Frequently Asked Questions">
        <style>
        /* ── FW FAQ SECTION ── */
        .fw-faq-section {
            background: #0a0805;
            padding: 72px 5vw 80px;
            position: relative;
            overflow: hidden;
        }
        .fw-faq-section::before {
            content: 'FAQ';
            position: absolute;
            top: -20px;
            right: 5vw;
            font-family: 'Bebas Neue', sans-serif;
            font-size: clamp(100px, 18vw, 200px);
            color: rgba(193,68,14,.04);
            line-height: 1;
            pointer-events: none;
            user-select: none;
            letter-spacing: 4px;
        }
        .fw-faq-inner {
            max-width: 860px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }
        .fw-faq-header {
            margin-bottom: 48px;
        }
        .fw-faq-eyebrow {
            font-size: 10px;
            letter-spacing: 4px;
            text-transform: uppercase;
            color: var(--amber, #e8a020);
            font-family: 'Barlow', sans-serif;
            font-weight: 500;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .fw-faq-eyebrow::after {
            content: '';
            display: block;
            height: 1px;
            width: 40px;
            background: var(--amber, #e8a020);
            opacity: .5;
        }
        .fw-faq-title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: clamp(36px, 6vw, 56px);
            color: #fff;
            letter-spacing: 2px;
            line-height: .95;
            margin: 0;
        }
        .fw-faq-title span {
            color: var(--rust, #c1440e);
        }
        .fw-faq-subtitle {
            font-size: 14px;
            color: rgba(255,255,255,.4);
            font-weight: 300;
            margin-top: 12px;
            line-height: 1.6;
            font-family: 'Barlow', sans-serif;
        }
        /* Accordion */
        .fw-faq-list {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }
        .fw-faq-item {
            border: 1px solid rgba(255,255,255,.06);
            background: rgba(255,255,255,.02);
            transition: background .2s, border-color .2s;
            position: relative;
        }
        .fw-faq-item.open {
            background: rgba(193,68,14,.07);
            border-color: rgba(193,68,14,.3);
        }
        .fw-faq-item.open .fw-faq-icon {
            transform: rotate(45deg);
            color: var(--rust, #c1440e);
        }
        .fw-faq-item.open .fw-faq-q {
            color: #fff;
        }
        .fw-faq-btn {
            width: 100%;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
            padding: 20px 22px;
            background: none;
            border: none;
            cursor: pointer;
            text-align: left;
            font-family: 'Barlow', sans-serif;
            -webkit-tap-highlight-color: transparent;
        }
        .fw-faq-q {
            font-size: 15px;
            font-weight: 500;
            color: rgba(255,255,255,.8);
            line-height: 1.5;
            transition: color .2s;
            flex: 1;
        }
        .fw-faq-icon {
            flex-shrink: 0;
            width: 22px;
            height: 22px;
            border: 1px solid rgba(255,255,255,.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            color: rgba(255,255,255,.4);
            transition: transform .3s cubic-bezier(.34,1.56,.64,1), color .2s, border-color .2s;
            margin-top: 2px;
        }
        .fw-faq-item.open .fw-faq-icon {
            border-color: rgba(193,68,14,.5);
        }
        .fw-faq-body {
            display: none;
            padding: 0 22px 20px 22px;
            font-size: 14px;
            line-height: 1.8;
            color: rgba(255,255,255,.55);
            font-weight: 300;
            font-family: 'Barlow', sans-serif;
            border-top: 1px solid rgba(255,255,255,.05);
            animation: faqIn .25s ease;
        }
        .fw-faq-body p { margin: 12px 0 0; }
        .fw-faq-body p:first-child { margin-top: 12px; }
        @keyframes faqIn {
            from { opacity: 0; transform: translateY(-6px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        /* Count badge */
        .fw-faq-count {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 14px;
            background: rgba(193,68,14,.12);
            border: 1px solid rgba(193,68,14,.2);
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--amber, #e8a020);
            font-family: 'Barlow', sans-serif;
            margin-top: 16px;
            display: inline-block;
        }
        /* Category divider */
        .fw-faq-divider {
            font-size: 9px;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: rgba(255,255,255,.2);
            padding: 16px 4px 8px;
            font-family: 'Barlow', sans-serif;
        }
        @media (max-width: 600px) {
            .fw-faq-section { padding: 52px 5vw 60px; }
            .fw-faq-q { font-size: 14px; }
            .fw-faq-btn { padding: 16px 16px; }
            .fw-faq-body { padding: 0 16px 16px; }
        }
        </style>

        <div class="fw-faq-inner">
            <div class="fw-faq-header">
                <div class="fw-faq-eyebrow">Got Questions</div>
                <h2 class="fw-faq-title">
                    Frequently <span>Asked</span><br>Questions
                </h2>
                <p class="fw-faq-subtitle">
                    Everything you need to know before hitting the road with us.
                </p>
                <div class="fw-faq-count"><?php echo count($faqs); ?> Questions Answered</div>
            </div>

            <div class="fw-faq-list" id="fwFaqList">
                <?php foreach ($faqs as $i => $faq): ?>
                <div class="fw-faq-item" id="faq-<?php echo $i; ?>">
                    <button class="fw-faq-btn"
                            onclick="fwToggleFaq(<?php echo $i; ?>)"
                            aria-expanded="false"
                            aria-controls="faq-body-<?php echo $i; ?>">
                        <span class="fw-faq-q"><?php echo esc_html($faq['q']); ?></span>
                        <span class="fw-faq-icon" aria-hidden="true">+</span>
                    </button>
                    <div class="fw-faq-body" id="faq-body-<?php echo $i; ?>" role="region">
                        <p><?php echo nl2br(esc_html($faq['a'])); ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Still have questions CTA -->
            <div style="margin-top:40px;padding:24px;background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.07);display:flex;align-items:center;justify-content:space-between;gap:20px;flex-wrap:wrap">
                <div>
                    <div style="font-family:'Bebas Neue',sans-serif;font-size:22px;letter-spacing:2px;color:#fff">Still have a question?</div>
                    <div style="font-size:13px;color:rgba(255,255,255,.4);font-weight:300;margin-top:4px;font-family:'Barlow',sans-serif">Our team replies on WhatsApp within 2 hours</div>
                </div>
                <a href="https://wa.me/917817838060?text=<?php echo urlencode('Hi FreeWheel! I have a question about the expedition.'); ?>"
                   target="_blank"
                   style="display:inline-flex;align-items:center;gap:10px;padding:12px 24px;background:var(--rust,#c1440e);color:#fff;font-family:'Bebas Neue',sans-serif;font-size:18px;letter-spacing:2px;text-decoration:none;flex-shrink:0;transition:background .2s"
                   onmouseover="this.style.background='#a03a0c'"
                   onmouseout="this.style.background='var(--rust,#c1440e)'">
                    📲 Ask on WhatsApp
                </a>
            </div>

        </div><!-- /fw-faq-inner -->

        <script>
        function fwToggleFaq(idx) {
            var item = document.getElementById('faq-' + idx);
            var body = document.getElementById('faq-body-' + idx);
            var btn  = item.querySelector('.fw-faq-btn');
            var isOpen = item.classList.contains('open');

            // Close all others
            document.querySelectorAll('.fw-faq-item.open').forEach(function(el) {
                el.classList.remove('open');
                el.querySelector('.fw-faq-body').style.display = 'none';
                el.querySelector('.fw-faq-btn').setAttribute('aria-expanded', 'false');
            });

            // Toggle this one
            if (!isOpen) {
                item.classList.add('open');
                body.style.display = 'block';
                btn.setAttribute('aria-expanded', 'true');
                // Smooth scroll into view on mobile
                if (window.innerWidth < 700) {
                    setTimeout(function() {
                        item.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                    }, 50);
                }
            }
        }

        // Do NOT auto-open first FAQ — it triggers scrollIntoView and jumps to FAQ section on page load
        </script>

    </section>
    <?php
}

/* ════════════════════════════════════════════════════════════
   AUTO-INJECT into single expedition posts
   Adds FAQ automatically before footer on all fw_expedition posts
════════════════════════════════════════════════════════════ */
function fw_auto_inject_faq() {
    if (!is_singular('fw_expedition')) return;
    $slug = get_post_field('post_name', get_the_ID());
    $map  = array('nepal'=>'nepal','leh'=>'leh','spiti'=>'spiti','adikailash'=>'adikailash');
    $exp  = isset($map[$slug]) ? $map[$slug] : 'common';
    fw_faq_section($exp);
}
add_action('fw_before_footer', 'fw_auto_inject_faq');
