<?php
/**
 * FreeWheel Expeditions — SEO & Schema Suite (fw-seo.php v1.0)
 *
 * Covers:
 *  - Document title optimisation per page
 *  - Meta description  (homepage + expedition pages + blog)
 *  - Canonical URL tags
 *  - OpenGraph (og:) tags  — full suite
 *  - Twitter Card tags
 *  - JSON-LD: Organization, WebSite (with SearchAction), TouristTrip, BreadcrumbList
 *  - Google Fonts preconnect
 *  - Robots.txt dynamic output
 *  - Auto lazy-loading on WP content images
 *  - Sticky "Book Now" CTA bar
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/* ═══════════════════════════════════════════════════════════════
   1.  PAGE-LEVEL SEO DATA MAP
   ═══════════════════════════════════════════════════════════════ */
function fw_get_page_seo() {
    $home = home_url('/');

    $map = [
        // slug => [ title, description, canonical-path, og_image ]
        ''  => [   // Homepage (front page)
            'title'       => 'FreeWheel Expeditions | Self Drive Road Trips India – Leh, Spiti, Nepal',
            'desc'        => 'Self-drive road trip expeditions across Ladakh, Spiti Valley, Adi Kailash and Nepal. Convoy-based Himalayan adventures for car enthusiasts. Join India\'s premier overlanding community.',
            'url'         => $home,
            'og_image'    => get_template_directory_uri() . '/images/front-page-1.png',
            'og_type'     => 'website',
        ],
        'leh' => [
            'title'       => 'Leh Ladakh Self Drive Expedition 2026 | Delhi to Ladakh Road Trip | FreeWheel',
            'desc'        => 'Join our 15-night Leh Ladakh self drive expedition from Delhi. Convoy-based road trip across Khardung La, Pangong Tso & Nubra Valley. Starting ₹34,999/person.',
            'url'         => $home . 'leh/',
            'og_image'    => get_template_directory_uri() . '/images/fw-data-1.jpg',
            'og_type'     => 'article',
        ],
        'spiti' => [
            'title'       => 'Spiti Valley Self Drive Expedition 2026 | Spiti Road Trip Package | FreeWheel',
            'desc'        => 'Drive through the Middle Land on our 10-night Spiti Valley self drive expedition. Key Monastery, Chandratal Lake & Pin Valley. Starting ₹24,999/person.',
            'url'         => $home . 'spiti/',
            'og_image'    => get_template_directory_uri() . '/images/fw-data-2.jpg',
            'og_type'     => 'article',
        ],
        'adikailash' => [
            'title'       => 'Adi Kailash Om Parvat Self Drive Expedition 2026 | FreeWheel Expeditions',
            'desc'        => '5-day self drive pilgrimage to Adi Kailash and Om Parvat in Uttarakhand. Sacred Himalayan road trip with FreeWheel convoy support. Starting ₹14,999/person.',
            'url'         => $home . 'adikailash/',
            'og_image'    => get_template_directory_uri() . '/images/fw-data-3.jpg',
            'og_type'     => 'article',
        ],
        'nepal-mustang' => [
            'title'       => 'Mustang Nepal Self Drive Expedition 2026 | Nepal Overland Road Trip | FreeWheel',
            'desc'        => '9-day overland self drive expedition to the Forbidden Kingdom of Mustang, Nepal. Scenic Himalayan convoy road trip from India. Starting ₹5,000/car.',
            'url'         => $home . 'nepal/',
            'og_image'    => get_template_directory_uri() . '/images/fw-data-4.jpg',
            'og_type'     => 'article',
        ],
        'expeditions' => [
            'title'       => 'All Expeditions 2026 | Himalayan Self Drive Road Trips | FreeWheel Expeditions',
            'desc'        => 'Browse all upcoming FreeWheel self drive expeditions to Leh Ladakh, Spiti Valley, Adi Kailash and Nepal. Convoy road trips across the Himalayas.',
            'url'         => $home . 'expeditions/',
            'og_image'    => get_template_directory_uri() . '/images/front-page-1.png',
            'og_type'     => 'website',
        ],
        'blog' => [
            'title'       => 'Road Trip Blog | Himalayan Travel Guides & Overlanding Tips | FreeWheel',
            'desc'        => 'Road trip guides, vehicle prep tips, route breakdowns and expedition reports from FreeWheel Expeditions. India\'s Himalayan self drive overlanding blog.',
            'url'         => $home . 'blog/',
            'og_image'    => get_template_directory_uri() . '/images/front-page-1.png',
            'og_type'     => 'website',
        ],
        'community' => [
            'title'       => 'Overlanding Community India | Road Warriors | FreeWheel Expeditions',
            'desc'        => 'Join the FreeWheel overlanding community. Connect with self drive road trip enthusiasts across India. Member perks, early access, loyalty discounts.',
            'url'         => $home . 'community/',
            'og_image'    => get_template_directory_uri() . '/images/front-page-1.png',
            'og_type'     => 'website',
        ],
        'merchandise' => [
            'title'       => 'Overlanding Merchandise | FreeWheel Expeditions Official Store',
            'desc'        => 'Official FreeWheel Expeditions merchandise — overlanding gear, apparel and accessories for road trip enthusiasts. Shop the FreeWheel road warrior collection.',
            'url'         => $home . 'merchandise/',
            'og_image'    => get_template_directory_uri() . '/images/front-page-1.png',
            'og_type'     => 'website',
        ],
        'connect' => [
            'title'       => 'Contact FreeWheel Expeditions | Book a Self Drive Road Trip',
            'desc'        => 'Get in touch with FreeWheel Expeditions. Enquire about Leh Ladakh, Spiti Valley, Adi Kailash or Nepal self drive road trip expeditions.',
            'url'         => $home . 'connect/',
            'og_image'    => get_template_directory_uri() . '/images/front-page-1.png',
            'og_type'     => 'website',
        ],
        'all-expeditions' => [
            'title'       => 'Browse All Expeditions | Filter by Destination, Date & Budget | FreeWheel',
            'desc'        => 'Search every upcoming FreeWheel self drive expedition by destination, month, or budget. Find your next Himalayan road trip — Leh Ladakh, Spiti, Adi Kailash, Nepal and more.',
            'url'         => $home . 'all-expeditions/',
            'og_image'    => get_template_directory_uri() . '/images/front-page-1.png',
            'og_type'     => 'website',
        ],
        'rider' => [
            'title'       => 'JUNGLI Member Profile | FreeWheel Expeditions Community',
            'desc'        => 'A FreeWheel JUNGLI rider profile — trip albums, road stories and the loyalty badge earned through real Himalayan self drive expeditions.',
            'url'         => $home . 'rider/',
            'og_image'    => get_template_directory_uri() . '/images/front-page-1.png',
            'og_type'     => 'profile',
        ],
    ];
    return $map;
}

/* Resolve which SEO data to use for the current page */
function fw_current_seo() {
    $map  = fw_get_page_seo();
    $slug = get_post_field( 'post_name', get_the_ID() );

    /* Template-based detection for expedition pages */
    $template = get_page_template_slug();
    $tpl_map  = [
        'page-leh.php'             => 'leh',
        'page-spiti.php'           => 'spiti',
        'page-adikailash.php'      => 'adikailash',
        'page-nepal.php'           => 'nepal-mustang',
        'page-all-expeditions.php' => 'all-expeditions',
        'page-rider.php'           => 'rider',
    ];
    if ( isset( $tpl_map[ $template ] ) ) {
        $key = $tpl_map[ $template ];
        if ( isset( $map[ $key ] ) ) return $map[ $key ];
    }

    /* Blog posts get their own dynamic meta (already in functions.php) */
    if ( is_singular('fw_blog') ) return null;

    /* Slug / page-name match */
    $slug_map = [
        'expeditions'  => 'expeditions',
        'blog'         => 'blog',
        'community'    => 'community',
        'merchandise'  => 'merchandise',
        'connect'      => 'connect',
    ];
    if ( isset( $slug_map[ $slug ] ) && isset( $map[ $slug_map[ $slug ] ] ) ) {
        return $map[ $slug_map[ $slug ] ];
    }

    /* Homepage / front page */
    if ( is_front_page() || is_home() ) return $map[''];

    return null; // Fall through to WP defaults
}


/* ═══════════════════════════════════════════════════════════════
   2.  DOCUMENT TITLE
   ═══════════════════════════════════════════════════════════════ */
add_filter( 'document_title_parts', function( $parts ) {
    $seo = fw_current_seo();
    if ( $seo ) {
        $parts['title'] = $seo['title'];
        unset( $parts['site'] ); // title already contains site name
    }
    return $parts;
}, 20 );


/* ═══════════════════════════════════════════════════════════════
   3.  META DESCRIPTION + CANONICAL + OG + TWITTER CARD
   ═══════════════════════════════════════════════════════════════ */
add_action( 'wp_head', function() {
    $seo = fw_current_seo();
    if ( ! $seo ) return; // Blog posts handled elsewhere in functions.php

    $title    = esc_attr( $seo['title'] );
    $desc     = esc_attr( $seo['desc'] );
    $url      = esc_url( $seo['url'] );
    $image    = esc_url( $seo['og_image'] );
    $og_type  = esc_attr( $seo['og_type'] );
    $site_name = 'FreeWheel Expeditions';

    echo "\n<!-- FW SEO Meta -->\n";
    echo "<meta name=\"description\" content=\"{$desc}\">\n";
    echo "<link rel=\"canonical\" href=\"{$url}\">\n";

    /* OpenGraph */
    echo "<meta property=\"og:type\"        content=\"{$og_type}\">\n";
    echo "<meta property=\"og:url\"         content=\"{$url}\">\n";
    echo "<meta property=\"og:title\"       content=\"{$title}\">\n";
    echo "<meta property=\"og:description\" content=\"{$desc}\">\n";
    echo "<meta property=\"og:image\"       content=\"{$image}\">\n";
    echo "<meta property=\"og:image:width\"  content=\"1200\">\n";
    echo "<meta property=\"og:image:height\" content=\"630\">\n";
    echo "<meta property=\"og:site_name\"   content=\"" . esc_attr($site_name) . "\">\n";
    echo "<meta property=\"og:locale\"      content=\"en_IN\">\n";

    /* Twitter Card */
    echo "<meta name=\"twitter:card\"        content=\"summary_large_image\">\n";
    echo "<meta name=\"twitter:site\"        content=\"@freewheelexp\">\n";
    echo "<meta name=\"twitter:title\"       content=\"{$title}\">\n";
    echo "<meta name=\"twitter:description\" content=\"{$desc}\">\n";
    echo "<meta name=\"twitter:image\"       content=\"{$image}\">\n";

    /* Robots — private/app pages should never be indexed.
       Matched by template FILE, not slug guess: these pages use custom
       "Template Name" assignments in WP Admin, so their actual URL slug
       could be anything — slug-matching silently misses pages if the
       slug differs from what was guessed here. */
    $private_templates = array(
        'page-login.php', 'page-register.php', 'page-dashboard.php',
        'page-edit-profile.php', 'page-fw-admin.php',
    );
    if ( is_page_template( $private_templates ) ) {
        echo "<meta name=\"robots\" content=\"noindex, nofollow\">\n";
    } else {
        echo "<meta name=\"robots\" content=\"index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1\">\n";
    }
    echo "<!-- /FW SEO Meta -->\n\n";
}, 5 );


/* ═══════════════════════════════════════════════════════════════
   4.  JSON-LD SCHEMA — Organisation + WebSite
   ═══════════════════════════════════════════════════════════════ */
add_action( 'wp_head', function() {
    $home = home_url('/');
    $logo = get_template_directory_uri() . '/images/header-1.jpg';
    ?>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "Organization",
      "@id": "<?php echo esc_url($home); ?>#organization",
      "name": "FreeWheel Expeditions",
      "url": "<?php echo esc_url($home); ?>",
      "logo": {
        "@type": "ImageObject",
        "url": "<?php echo esc_url($logo); ?>"
      },
      "description": "India's premier self-drive and overlanding expedition company. Convoy-based Himalayan road trips to Leh Ladakh, Spiti Valley, Adi Kailash and Nepal.",
      "address": {
        "@type": "PostalAddress",
        "addressCountry": "IN"
      },
      "contactPoint": {
        "@type": "ContactPoint",
        "telephone": "+91-78178-38060",
        "contactType": "customer service",
        "availableLanguage": ["English", "Hindi"]
      },
      "sameAs": [
        "https://instagram.com/freewheelexpeditions",
        "https://www.facebook.com/groups/freewheelexpeditions"
      ]
    },
    {
      "@type": "WebSite",
      "@id": "<?php echo esc_url($home); ?>#website",
      "url": "<?php echo esc_url($home); ?>",
      "name": "FreeWheel Expeditions",
      "description": "Self-drive road trip expeditions across Ladakh, Spiti, Nepal and India",
      "publisher": {"@id": "<?php echo esc_url($home); ?>#organization"},
      "potentialAction": {
        "@type": "SearchAction",
        "target": {
          "@type": "EntryPoint",
          "urlTemplate": "<?php echo esc_url($home); ?>?s={search_term_string}"
        },
        "query-input": "required name=search_term_string"
      }
    }
  ]
}
</script>
    <?php
}, 8 );


/* ═══════════════════════════════════════════════════════════════
   5.  JSON-LD SCHEMA — TouristTrip (Expedition pages)
   ═══════════════════════════════════════════════════════════════ */
add_action( 'wp_head', function() {
    $template = get_page_template_slug();
    $home     = home_url('/');

    $trips = [
        'page-leh.php' => [
            'name'         => 'Leh Ladakh Self Drive Expedition 2026',
            'description'  => 'A 15-night self-drive convoy expedition across Ladakh — covering Khardung La, Pangong Tso, Nubra Valley and more. Ideal for car enthusiasts and adventure seekers.',
            'url'          => $home . 'leh/',
            'image'        => get_template_directory_uri() . '/images/fw-data-1.jpg',
            'duration'     => 'P16D',
            'price'        => '34999',
            'dest'         => 'Leh Ladakh, Jammu & Kashmir, India',
            'touristType'  => 'Road trip enthusiasts, Car enthusiasts, Adventure travelers',
        ],
        'page-spiti.php' => [
            'name'         => 'Spiti Valley Self Drive Expedition 2026',
            'description'  => 'A 10-night self-drive convoy expedition through Spiti Valley — Key Monastery, Chandratal Lake, Pin Valley and remote Himalayan villages.',
            'url'          => $home . 'spiti/',
            'image'        => get_template_directory_uri() . '/images/fw-data-2.jpg',
            'duration'     => 'P11D',
            'price'        => '24999',
            'dest'         => 'Spiti Valley, Himachal Pradesh, India',
            'touristType'  => 'Road trip enthusiasts, Adventure travelers, Photography',
        ],
        'page-adikailash.php' => [
            'name'         => 'Adi Kailash Om Parvat Self Drive Expedition 2026',
            'description'  => 'A 5-day sacred self-drive pilgrimage to Adi Kailash and Om Parvat in Uttarakhand — where spirituality meets Himalayan adventure.',
            'url'          => $home . 'adikailash/',
            'image'        => get_template_directory_uri() . '/images/fw-data-3.jpg',
            'duration'     => 'P5D',
            'price'        => '14999',
            'dest'         => 'Adi Kailash, Pithoragarh, Uttarakhand, India',
            'touristType'  => 'Pilgrimage, Road trip enthusiasts, Adventure travelers',
        ],
        'page-nepal.php' => [
            'name'         => 'Mustang Nepal Self Drive Expedition 2026',
            'description'  => 'A 9-day overland self-drive expedition to the Forbidden Kingdom of Mustang, Nepal — ancient landscapes, Buddhist monasteries and dramatic Himalayan terrain.',
            'url'          => $home . 'nepal/',
            'image'        => get_template_directory_uri() . '/images/fw-data-4.jpg',
            'duration'     => 'P9D',
            'price'        => '5000',
            'dest'         => 'Mustang, Gandaki Province, Nepal',
            'touristType'  => 'Road trip enthusiasts, Overlanding, International adventure',
        ],
    ];

    if ( ! isset( $trips[ $template ] ) ) return;
    $t = $trips[ $template ];
    ?>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "TouristTrip",
  "name": <?php echo json_encode($t['name']); ?>,
  "description": <?php echo json_encode($t['description']); ?>,
  "url": "<?php echo esc_url($t['url']); ?>",
  "image": "<?php echo esc_url($t['image']); ?>",
  "provider": {
    "@type": "Organization",
    "@id": "<?php echo esc_url($home); ?>#organization",
    "name": "FreeWheel Expeditions"
  },
  "touristType": <?php echo json_encode($t['touristType']); ?>,
  "itinerary": {
    "@type": "ItemList",
    "name": "Expedition Route"
  },
  "offers": {
    "@type": "Offer",
    "priceCurrency": "INR",
    "price": "<?php echo esc_attr($t['price']); ?>",
    "availability": "https://schema.org/InStock",
    "validFrom": "<?php echo date('Y-m-d'); ?>"
  },
  "duration": "<?php echo esc_attr($t['duration']); ?>",
  "touristDestination": {
    "@type": "TouristDestination",
    "name": <?php echo json_encode($t['dest']); ?>,
    "includesAttraction": {
      "@type": "TouristAttraction",
      "name": <?php echo json_encode($t['dest']); ?>
    }
  }
}
</script>
    <?php

    /* BreadcrumbList for expedition pages */
    ?>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    {
      "@type": "ListItem",
      "position": 1,
      "name": "Home",
      "item": "<?php echo esc_url($home); ?>"
    },
    {
      "@type": "ListItem",
      "position": 2,
      "name": "Expeditions",
      "item": "<?php echo esc_url($home . 'expeditions/'); ?>"
    },
    {
      "@type": "ListItem",
      "position": 3,
      "name": <?php echo json_encode($t['name']); ?>,
      "item": "<?php echo esc_url($t['url']); ?>"
    }
  ]
}
</script>
    <?php
}, 9 );


/* ═══════════════════════════════════════════════════════════════
   6.  GOOGLE FONTS — PRECONNECT (performance)
       Outputs before fonts link; avoids extra DNS round-trip
   ═══════════════════════════════════════════════════════════════ */
add_action( 'wp_head', function() {
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
    echo '<link rel="dns-prefetch" href="https://cdn.jsdelivr.net">' . "\n";
}, 1 );  // priority 1 — before everything else


/* ═══════════════════════════════════════════════════════════════
   7.  ROBOTS.TXT — Dynamic (via WordPress)
   ═══════════════════════════════════════════════════════════════ */
add_filter( 'robots_txt', function( $output, $public ) {
    $home = home_url('/');
    $sitemap_url = $home . 'wp-sitemap.xml';

    $output  = "User-agent: *\n";
    $output .= "Allow: /\n";
    $output .= "Disallow: /wp-admin/\n";
    $output .= "Disallow: /wp-login.php\n";
    $output .= "Disallow: /dashboard/\n";
    $output .= "Disallow: /my-account/\n";
    $output .= "Disallow: /register/\n";
    $output .= "Disallow: /login/\n";
    $output .= "Disallow: /admin-dashboard/\n";
    $output .= "\n";
    $output .= "Sitemap: {$sitemap_url}\n";

    return $output;
}, 10, 2 );


/* ═══════════════════════════════════════════════════════════════
   8.  IMAGE LAZY LOADING — auto-add loading="lazy" to WP content
   ═══════════════════════════════════════════════════════════════ */
add_filter( 'the_content', function( $content ) {
    // Add loading="lazy" to any img that doesn't already have it
    return preg_replace(
        '/<img(?![^>]*loading=)([^>]*)>/i',
        '<img loading="lazy"$1>',
        $content
    );
} );

// Also add to post thumbnails / featured images
add_filter( 'post_thumbnail_html', function( $html ) {
    return preg_replace(
        '/<img(?![^>]*loading=)([^>]*)>/i',
        '<img loading="lazy"$1>',
        $html
    );
} );


/* ═══════════════════════════════════════════════════════════════
   9.  STICKY "BOOK NOW" CTA BAR
       Appears after user scrolls 500px. Hides on login/dashboard.
   ═══════════════════════════════════════════════════════════════ */
add_action( 'wp_footer', function() {
    // Only on expedition pages
    $template = get_page_template_slug();
    $expedition_templates = ['page-leh.php','page-spiti.php','page-adikailash.php','page-nepal.php'];
    if ( ! in_array( $template, $expedition_templates ) ) return;
    ?>
<style>
#fw-sticky-cta{
  position:fixed;bottom:0;left:0;right:0;z-index:800;
  background:rgba(15,13,11,.97);border-top:2px solid var(--rust);
  padding:14px 5vw;display:flex;align-items:center;justify-content:space-between;
  gap:16px;transform:translateY(100%);transition:transform .35s ease;
  backdrop-filter:blur(6px);
}
#fw-sticky-cta.visible{transform:translateY(0)}
.fw-sticky-info{display:flex;flex-direction:column}
.fw-sticky-label{font-size:10px;letter-spacing:3px;text-transform:uppercase;color:var(--amber);font-weight:600}
.fw-sticky-title{font-family:var(--headline);font-size:20px;color:#fff;letter-spacing:1px}
.fw-sticky-price{font-size:13px;color:rgba(255,255,255,.5);font-weight:300}
.fw-sticky-btn{
  padding:12px 28px;background:var(--rust);color:#fff;border:none;
  font-family:var(--headline);font-size:18px;letter-spacing:2px;cursor:pointer;
  border-radius:2px;white-space:nowrap;transition:background .2s;flex-shrink:0;
}
.fw-sticky-btn:hover{background:#a03508}
@media(max-width:480px){
  #fw-sticky-cta{flex-direction:column;padding:12px 20px}
  .fw-sticky-btn{width:100%;text-align:center}
}
</style>
<div id="fw-sticky-cta">
  <div class="fw-sticky-info">
    <span class="fw-sticky-label">Expedition Available</span>
    <span class="fw-sticky-title" id="fwStickyTitle">Book Your Seat</span>
    <span class="fw-sticky-price" id="fwStickyPrice"></span>
  </div>
  <button class="fw-sticky-btn" onclick="fwOpenBookingFromSticky()">BOOK NOW →</button>
</div>
<script>
(function(){
  var bar = document.getElementById('fw-sticky-cta');
  if(!bar) return;
  /* Populate title from page H1 */
  var h1 = document.querySelector('.trip-h1');
  if(h1){
    var t = document.getElementById('fwStickyTitle');
    if(t) t.textContent = h1.textContent.trim();
  }
  /* Populate price from .tq-val (3rd item = price) */
  var priceEl = document.querySelectorAll('.tq-val')[2];
  if(priceEl){
    var p = document.getElementById('fwStickyPrice');
    if(p) p.textContent = 'Starting ' + priceEl.textContent.trim();
  }
  /* Show after 500px scroll */
  var shown = false;
  window.addEventListener('scroll', function(){
    if(!shown && window.scrollY > 500){
      bar.classList.add('visible'); shown = true;
    } else if(shown && window.scrollY < 200){
      bar.classList.remove('visible'); shown = false;
    }
  }, {passive:true});
})();
function fwOpenBookingFromSticky(){
  /* Try to find and click the existing Book button on the page */
  var btn = document.querySelector('[onclick*="openBook"], [onclick*="openTrip"], .book-btn, [data-action="book"]');
  if(btn){ btn.click(); return; }
  /* Fallback — scroll to booking section */
  var bookSec = document.querySelector('#book, .book-section, .cta-section');
  if(bookSec){ bookSec.scrollIntoView({behavior:'smooth',block:'center'}); }
}
</script>
    <?php
}, 20 );


/* ═══════════════════════════════════════════════════════════════
   10. INTERNAL LINKING — breadcrumb nav on expedition pages
       (Adds visible "Home › Expeditions › [Trip]" above hero)
   ═══════════════════════════════════════════════════════════════ */
add_action( 'wp_body_open', function() {
    $template = get_page_template_slug();
    $expedition_templates = ['page-leh.php','page-spiti.php','page-adikailash.php','page-nepal.php'];
    if ( ! in_array( $template, $expedition_templates ) ) return;

    $names = [
        'page-leh.php'        => 'Leh Ladakh Expedition',
        'page-spiti.php'      => 'Spiti Valley Expedition',
        'page-adikailash.php' => 'Adi Kailash Expedition',
        'page-nepal.php'      => 'Mustang Nepal Expedition',
    ];
    $current = $names[ $template ] ?? get_the_title();
    $home = home_url('/');
    ?>
<nav aria-label="Breadcrumb" style="position:relative;z-index:901;background:rgba(15,13,11,.7);padding:6px 5vw;margin-top:64px">
  <ol itemscope itemtype="https://schema.org/BreadcrumbList"
      style="list-style:none;display:flex;gap:6px;align-items:center;font-size:11px;letter-spacing:1px;text-transform:uppercase;color:rgba(255,255,255,.4)">
    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
      <a itemprop="item" href="<?php echo esc_url($home); ?>" style="color:rgba(255,255,255,.4);text-decoration:none">
        <span itemprop="name">Home</span></a>
      <meta itemprop="position" content="1">
    </li>
    <li aria-hidden="true">›</li>
    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
      <a itemprop="item" href="<?php echo esc_url($home . 'expeditions/'); ?>" style="color:rgba(255,255,255,.4);text-decoration:none">
        <span itemprop="name">Expeditions</span></a>
      <meta itemprop="position" content="2">
    </li>
    <li aria-hidden="true">›</li>
    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
      <span itemprop="name" style="color:rgba(255,255,255,.65)"><?php echo esc_html($current); ?></span>
      <meta itemprop="position" content="3">
    </li>
  </ol>
</nav>
    <?php
} );


/* ═══════════════════════════════════════════════════════════════
   11. ENHANCED SECURITY HEADERS — add CSP to existing headers
   ═══════════════════════════════════════════════════════════════ */
add_action( 'send_headers', function() {
    // Content-Security-Policy — tightened but allows needed CDNs
    $csp = implode('; ', [
        "default-src 'self'",
        "script-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://www.google.com https://www.gstatic.com https://www.googletagmanager.com",
        "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com",
        "font-src 'self' https://fonts.gstatic.com data:",
        "img-src 'self' data: blob: https:",
        "connect-src 'self' https://*.supabase.co https://www.google-analytics.com",
        "frame-src 'self' https://www.google.com https://www.youtube.com",
        "media-src 'self' blob: https:",
        "object-src 'none'",
        "base-uri 'self'",
        "form-action 'self'",
        "upgrade-insecure-requests",
    ]);
    if ( ! headers_sent() ) {
        header( "Content-Security-Policy: {$csp}" );
    }
}, 20 );  // after fw_add_security_headers (priority 10)

