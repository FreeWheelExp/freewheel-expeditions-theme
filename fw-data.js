
/* ═══════════════════════════════════════════════════════════════════
   fw-data.js  —  FreeWheel Expeditions · Central Data Layer v2.0 (cleaned)
   All page content driven from here. Edit this file to update the
   entire website without touching individual HTML pages.
   
   WordPress integration: replace each CONFIG section with a 
   wp_localize_script() call from your theme's functions.php
═══════════════════════════════════════════════════════════════════ */

window.FW = window.FW || {};

/* ─── SITE CONFIG ─────────────────────────────────────────────── */
FW.site = {
  name:      'FreeWheel Expeditions',
  tagline:   "India's Premier Self-Drive Road Trip Community",
  phone1:    '+91 78178 38060',
  phone2:    '+91 78382 95852',
  email:     'hello@freewheelexpeditions.in',
  whatsapp:  '917817838060',
  community: 'https://chat.whatsapp.com/IpVFxgBi7GG00yTmPhT6iP',
  instagram: 'https://instagram.com/freewheelexpeditions',
  facebook:  'https://www.facebook.com/groups/freewheelexpeditions',
  youtube:   'https://youtube.com/@freewheelexpeditions',
};

/* ─── STATS (update after each expedition) ────────────────────── */
FW.stats = {
  expeditions:  25,
  members:      500,
  kms:          300000,
  states:       6,
  convoys:      23,
  satisfaction: 98
};

/* ─── UPCOMING EXPEDITIONS ────────────────────────────────────── */
FW.upcoming = [
  {
    id:          'nepal',
    slug:        '/nepal/',
    title:       'Adventurous Upper Mustang (4X4 only)',
    subtitle:    '4x4 Only · Mustang Valley · Nepal',
    duration:    '8 Nights / 9 Days',
    dates:       '23rd May – 30th May 2026',
    month:       '23 – 30 May 2026',
    price:       5000,
    priceUnit:   'per Car',
    couplePrice: null,
    sharingPrice:null,
    destination: 'Nepal (Mustang)',
    region:      'International',
    difficulty:  'Challenging',
    maxSlots:    20,
    filledSlots: 11,
    slotsLeft:   9,
    highlights:  ['Mustang Valley','Lo Manthang','Kagbeni','Jomsom','Forbidden Kingdom'],
    tags:        ['4x4 Only','International','Forbidden Valley'],
    badge:       '9 Slots Left',
    badgeColor:  '#c1440e',
    heroEmoji:   '🏔️',
    heroGradient:'linear-gradient(145deg,#0a1820,#0f0d0b)',
    photo:       (window.FW_THEME_URL||'') + '/images/fw-data-1.jpg'
  },
  {
    id:          'adikailash',
    slug:        '/adikailash/',
    title:       'Adi Kailash — Om Parvat',
    subtitle:    'The Sacred Himalayan Circuit',
    duration:    '4 Nights / 5 Days',
    dates:       'June 2026',
    month:       'June 2026',
    price:       14999,
    priceUnit:   'per person',
    couplePrice: 11999,
    sharingPrice:19999,
    destination: 'Uttarakhand',
    region:      'Himalaya',
    difficulty:  'Challenging',
    maxSlots:    15,
    filledSlots: 6,
    slotsLeft:   9,
    highlights:  ['Adi Kailash Peak','Om Parvat','Jolinkong Lake','Kalapani','Lipulekh Pass'],
    tags:        ['Spiritual','High Altitude','Challenging'],
    badge:       'Limited Slots',
    badgeColor:  '#e8a020',
    heroEmoji:   '🕉️',
    heroGradient:'linear-gradient(145deg,#0a1020,#0f0d0b)',
    photo:       (window.FW_THEME_URL||'') + '/images/fw-data-2.jpg'
  },
  {
    id:          'leh',
    slug:        '/leh/',
    title:       'Dream Leh Ladakh',
    subtitle:    'The Ultimate Himalayan Self-Drive',
    duration:    '15 Nights / 16 Days',
    dates:       'August 2026',
    month:       'August 2026',
    price:       34999,
    priceUnit:   'per person',
    couplePrice: null,
    sharingPrice:39999,
    destination: 'Leh-Ladakh',
    region:      'Himalaya',
    difficulty:  'Challenging',
    maxSlots:    25,
    filledSlots: 9,
    slotsLeft:   16,
    highlights:  ['Khardung La','Pangong Tso','Nubra Valley','Magnetic Hill','Tso Moriri'],
    tags:        ['Flagship','High Altitude','16 Days'],
    badge:       'Flagship Trip',
    badgeColor:  '#2a7a6e',
    heroEmoji:   '🏜️',
    heroGradient:'linear-gradient(145deg,#1a1208,#0f0d0b)',
    photo:       (window.FW_THEME_URL||'') + '/images/fw-data-3.jpg'
  },
  {
    id:          'spiti',
    slug:        '/spiti/',
    title:       'Magical Spiti Valley',
    subtitle:    'The Land Between Tibet and India',
    duration:    '10 Nights / 11 Days',
    dates:       'October 2026',
    month:       'October 2026',
    price:       24999,
    priceUnit:   'per person',
    couplePrice: null,
    sharingPrice:29999,
    destination: 'Spiti Valley',
    region:      'Himalaya',
    difficulty:  'Moderate–Challenging',
    maxSlots:    20,
    filledSlots: 4,
    slotsLeft:   16,
    highlights:  ['Key Monastery','Chandratal Lake','Kaza','Pin Valley','Dhankar Fort'],
    tags:        ['Autumn Colours','Buddhist','Remote'],
    badge:       'Early Bird',
    badgeColor:  '#e8a020',
    heroEmoji:   '🕌',
    heroGradient:'linear-gradient(145deg,#0a1a0a,#0f0d0b)',
    photo:       (window.FW_THEME_URL||'') + '/images/fw-data-4.jpg'
  }
];

/* ─── PAST EXPEDITIONS / ALBUMS ──────────────────────────────── */
FW.albums = [
  { id:'winter-spiti-26',  title:'Winter Spiti',     date:'February 2026',  members:22, photos:6,  emoji:'❄️', gradient:'linear-gradient(145deg,#0a1820,#0f0d0b)' },
  { id:'nature-retreat-26',title:'Nature Retreat',    date:'January 2026',   members:18, photos:6,  emoji:'🌿', gradient:'linear-gradient(145deg,#0a1a12,#0f0d0b)' },
  { id:'darma-valley-25',  title:'Darma Valley',      date:'December 2025',  members:20, photos:6,  emoji:'🏞️', gradient:'linear-gradient(145deg,#1a1208,#0f0d0b)' },
  { id:'spiti-summer-25',  title:'Spiti Summer',      date:'July 2025',      members:28, photos:6,  emoji:'🌞', gradient:'linear-gradient(145deg,#1a0a08,#0f0d0b)' },
  { id:'leh-winter-25',    title:'Leh Winter',        date:'February 2025',  members:24, photos:6,  emoji:'🏔️', gradient:'linear-gradient(145deg,#0a0f1a,#0f0d0b)' },
  { id:'kumaon-24',        title:'Kumaon Explorer',   date:'October 2024',   members:16, photos:6,  emoji:'🌲', gradient:'linear-gradient(145deg,#0a1a0a,#0f0d0b)' },
];

/* ─── MERCHANDISE ─────────────────────────────────────────────── */
FW.merchandise = [
  { id:'m1', name:'FreeWheel Road Tee',        cat:'T-Shirts',    price:799,  badge:'Bestseller', emoji:'👕', gradient:'linear-gradient(145deg,#1a1208,#0f0d0b)', sizes:['S','M','L','XL','XXL'], desc:'100% cotton, pre-shrunk. Bold FreeWheel logo front, Khardung La coordinates back.' },
  { id:'m2', name:'Convoy Cap',                cat:'Caps',        price:599,  badge:'',           emoji:'🧢', gradient:'linear-gradient(145deg,#0a1a12,#0f0d0b)', sizes:[], desc:'Structured 6-panel cap with FreeWheel embroidery. UV-resistant fabric.' },
  { id:'m3', name:'Adventure Hoodie',          cat:'Hoodies',     price:1499, badge:'New',        emoji:'🧥', gradient:'linear-gradient(145deg,#1a0a0a,#0f0d0b)', sizes:['S','M','L','XL','XXL'], desc:'350 GSM fleece. Perfect for high-altitude camps. FreeWheel patch on left chest.' },
  { id:'m4', name:'Sticker Pack (Set of 10)',  cat:'Stickers',    price:199,  badge:'',           emoji:'🏷️', gradient:'linear-gradient(145deg,#0a0f1a,#0f0d0b)', sizes:[], desc:'Waterproof vinyl stickers. Mountains, passes, convoy emblems.' },
  { id:'m5', name:'Mountain Fleece Jacket',    cat:'Jackets',     price:2299, badge:'Limited',    emoji:'🫎', gradient:'linear-gradient(145deg,#0f1a08,#0f0d0b)', sizes:['S','M','L','XL'], desc:'Wind-resistant outer, warm fleece inner. Built for Himalayan temperatures.' },
  { id:'m6', name:'Expedition Backpack',       cat:'Accessories', price:1899, badge:'',           emoji:'🎒', gradient:'linear-gradient(145deg,#1a1215,#0f0d0b)', sizes:[], desc:'30L daypack with chest strap, rain cover, and hidden passport pocket.' },
  { id:'m7', name:'Ceramic Coffee Mug',        cat:'Accessories', price:349,  badge:'',           emoji:'☕', gradient:'linear-gradient(145deg,#1a1008,#0f0d0b)', sizes:[], desc:'350ml. Mountains illustration. Microwave & dishwasher safe.' },
  { id:'m8', name:'Road-Trip Notebook',        cat:'Accessories', price:299,  badge:'',           emoji:'📓', gradient:'linear-gradient(145deg,#0a1520,#0f0d0b)', sizes:[], desc:'A5 dotted journal with hardcover mountain highway illustration. 200 pages.' },
];





/* ─── TESTIMONIALS ─────────────────────────────────────────────── */
FW.testimonials = [
  { name:'Priya S.',    trip:'Winter Spiti 2026',    quote:'Joining the FreeWheel community was the best decision before my first solo road trip. The convoy system gave me confidence I would never have had alone.' },
  { name:'Rohit M.',    trip:'Dream Leh Ladakh 2025', quote:'The WhatsApp group is genuinely helpful — not spam. Real updates, real people. Got breakdown help within 20 minutes at 14,000 feet.' },
  { name:'Ananya K.',   trip:'Nepal Odyssey 2026',    quote:'4 trips with FreeWheel. The community is what keeps me coming back. These are my people — they understand why we drive.' },
  { name:'Vivek R.',    trip:'Spiti Summer 2025',     quote:'The route planning and briefing sessions are world class. You feel prepared for anything the mountains throw at you.' },
  { name:'Meera D.',    trip:'Kumaon Explorer 2024',  quote:'First trip ever and I was nervous. By Day 2 I had made friends for life. This is not just travel, this is therapy.' },
];

/* ─── HELPERS ──────────────────────────────────────────────────── */
FW.fmt = {
  price:   function(n){ return '₹' + n.toLocaleString('en-IN'); },
  num:     function(n){ return n >= 100000 ? (n/100000).toFixed(1) + 'L+' : n >= 1000 ? Math.round(n/1000) + 'K+' : n + '+'; },
  slugify: function(s){ return s.toLowerCase().replace(/\s+/g,'-').replace(/[^a-z0-9-]/g,''); },
  wa:      function(msg){ return 'https://wa.me/' + FW.site.whatsapp + '?text=' + encodeURIComponent(msg); },
};

FW.getTrip = function(id){ return FW.upcoming.find(function(t){ return t.id === id; }) || null; };
FW.getTier = function(doneCount){ return doneCount >= 3 ? {tier:'Legend',disc:8,label:'8% OFF'} : doneCount >= 1 ? {tier:'Pioneer',disc:5,label:'5% OFF'} : {tier:'Explorer',disc:0,label:'—'}; };

console.log('[FW] Data layer loaded —', FW.upcoming.length, 'trips,', FW.merchandise.length, 'products,', FW.albums.length, 'albums');
