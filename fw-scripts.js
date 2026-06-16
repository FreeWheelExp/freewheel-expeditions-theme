/* ---------------------------------------------------------------
   fw-scripts.js  ?  FreeWheel Expeditions ? Clean v2.0
   Dead code removed May 2026. Registration system reserved.
??????????????????????????????????????????????????????????????? */

/* ===== Scripts from index.html ===== */


// -------------------------------------------
// UPCOMING EXPEDITIONS CAROUSEL v4 - Scroll Snap
// Works on ALL devices: mobile swipe + auto + buttons
// -------------------------------------------
var cAutoTimer   = null;
var cPaused      = false;
var cIsDragging  = false;
var cDragStartX  = 0;
var cDragScrollL = 0;

function cGetTrack() { return document.getElementById('cTrack'); }

function cGetCardWidth() {
  var track = cGetTrack();
  var card  = document.querySelector('#cTrack .trip-card');
  if (!card || !track) return 320;
  // Use getBoundingClientRect for accurate width including all sub-pixel values
  var rect = card.getBoundingClientRect();
  var style = window.getComputedStyle(track);
  var gap = parseFloat(style.gap) || 20;
  return rect.width + gap;
}

function cGetVis() {
  return window.innerWidth < 700 ? 1 : window.innerWidth < 1024 ? 2 : 3;
}

/* -- Scroll to a card index -- */
function cGo(idx) {
  var track = cGetTrack();
  if (!track) return;
  var cards = track.querySelectorAll('.trip-card');
  if (!cards.length) return;
  var max = Math.max(0, cards.length - cGetVis());
  idx = Math.max(0, Math.min(idx, max));
  var w = cGetCardWidth();
  track.scrollTo({ left: idx * w, behavior: 'smooth' });
  cUpdateDots(idx);
}

/* -- Move by direction -- */
function cMove(dir) {
  var track = cGetTrack();
  if (!track) return;
  var w = cGetCardWidth();
  var cur = track.scrollLeft;
  var target = cur + dir * w;
  // Clamp to valid range
  var maxScroll = track.scrollWidth - track.clientWidth;
  target = Math.max(0, Math.min(target, maxScroll));
  track.scrollTo({ left: target, behavior: 'smooth' });
  cRestartAuto();
  setTimeout(function() {
    cUpdateDots(Math.round(track.scrollLeft / w));
  }, 500);
}

/* -- Dots -- */
function cBuildDots() {
  var d = document.getElementById('cDots');
  if (!d) return;
  var cards = document.querySelectorAll('#cTrack .trip-card');
  var vis   = cGetVis();
  var pages = Math.max(1, Math.ceil(cards.length / vis));
  d.innerHTML = '';
  for (var i = 0; i < pages; i++) {
    var dot = document.createElement('div');
    dot.className = 'dot' + (i === 0 ? ' active' : '');
    (function(pg) {
      dot.onclick = function() {
        cGo(pg * vis);
        cRestartAuto();
      };
    })(i);
    d.appendChild(dot);
  }
}

function cUpdateDots(cardIdx) {
  var vis = cGetVis();
  var pg  = Math.floor(cardIdx / vis);
  document.querySelectorAll('#cDots .dot').forEach(function(d, i) {
    d.classList.toggle('active', i === pg);
  });
}

/* -- Auto scroll -- */
function cAutoTick() {
  if (cPaused || cIsDragging) return;
  var track = cGetTrack();
  if (!track) return;
  var w        = cGetCardWidth();
  var cards    = track.querySelectorAll('.trip-card');
  var maxScroll = track.scrollWidth - track.clientWidth;
  var atEnd     = track.scrollLeft >= maxScroll - 10;
  if (atEnd) {
    // Loop back to start
    track.scrollTo({ left: 0, behavior: 'smooth' });
    cUpdateDots(0);
  } else {
    var newLeft = track.scrollLeft + w;
    track.scrollTo({ left: newLeft, behavior: 'smooth' });
    setTimeout(function() {
      cUpdateDots(Math.round(track.scrollLeft / w));
    }, 400);
  }
}

function cStartAuto() {
  clearInterval(cAutoTimer);
  cAutoTimer = setInterval(cAutoTick, 3200);
}

function cRestartAuto() {
  clearInterval(cAutoTimer);
  setTimeout(cStartAuto, 800);
}

/* -- Mouse drag (desktop) -- */
function cInitDrag() {
  var track = cGetTrack();
  if (!track) return;
  track.addEventListener('mousedown', function(e) {
    cIsDragging  = true;
    cPaused      = true;
    cDragStartX  = e.pageX;
    cDragScrollL = track.scrollLeft;
    track.style.cursor = 'grabbing';
  });
  document.addEventListener('mousemove', function(e) {
    if (!cIsDragging) return;
    track.scrollLeft = cDragScrollL - (e.pageX - cDragStartX);
  });
  document.addEventListener('mouseup', function() {
    if (!cIsDragging) return;
    cIsDragging = false;
    track.style.cursor = 'grab';
    setTimeout(function() {
      cPaused = false;
      var w = cGetCardWidth();
      cUpdateDots(Math.round(track.scrollLeft / w));
    }, 300);
    cRestartAuto();
  });
}

/* -- Hover pause (desktop) -- */
function cInitHover() {
  var wrap = document.querySelector('.carousel-wrap');
  if (!wrap) return;
  wrap.addEventListener('mouseenter', function() { cPaused = true; });
  wrap.addEventListener('mouseleave', function() {
    if (!cIsDragging) cPaused = false;
  });
}

/* -- Update dots on native scroll (mobile swipe) -- */
function cInitScrollWatch() {
  var track = cGetTrack();
  if (!track) return;
  var scrollTimer;
  track.addEventListener('scroll', function() {
    clearTimeout(scrollTimer);
    cPaused = true;
    scrollTimer = setTimeout(function() {
      var w = cGetCardWidth();
      cUpdateDots(Math.round(track.scrollLeft / w));
      cPaused = false;
    }, 150);
  }, { passive: true });
}

window.addEventListener('resize', function() {
  cBuildDots();
  cUpdateDots(0);
});




/* -- SUBSCRIBE FLOW -- */
/* -- SUBSCRIBE FLOW (OTP modal lives in header.php) ------ */

async function fwSendOtp(name, email, whatsapp, source, msgEl, btnEl){
  if(!name.trim()){if(msgEl){msgEl.textContent='Please enter your name.';msgEl.style.color='#f87171';if(msgEl.style.display!==undefined)msgEl.style.display='block';}return;}
  if(!email.trim()||!email.includes('@')){if(msgEl){msgEl.textContent='Please enter a valid email.';msgEl.style.color='#f87171';if(msgEl.style.display!==undefined)msgEl.style.display='block';}return;}
  var origLabel=btnEl?btnEl.textContent:'Subscribe';
  if(btnEl){btnEl.disabled=true;btnEl.textContent='Sending OTP...';}
  if(msgEl){msgEl.textContent='';msgEl.style.color='';}
  try{
    var REST=(window.FW_REST_URL||'/wp-json/freewheel/v1').replace(/\/$/,'');
    var payload=new URLSearchParams({name:name.trim(),email:email.trim().toLowerCase(),phone:whatsapp?whatsapp.trim():'',source:source});var r=await fetch(REST+'/subscribe',{method:'POST',headers:{'Content-Type':'application/x-www-form-urlencoded'},body:payload.toString()});
    var d=await r.json();
    if(!r.ok) throw new Error(d.message||'Failed to send code. Please try again.');
    window._fwSubPending={name:name.trim(),email:email.trim().toLowerCase(),whatsapp:whatsapp?whatsapp.trim():null,source:source};
    if(typeof fwOtpOpen==='function') fwOtpOpen(email.trim().toLowerCase());
  }catch(err){
    if(msgEl){msgEl.textContent='Error: '+err.message;msgEl.style.color='#f87171';if(msgEl.style.display!==undefined)msgEl.style.display='block';}
  }finally{
    if(btnEl){btnEl.disabled=false;btnEl.textContent=origLabel;}
  }
}

async function handleSub(){
  var name  = (document.getElementById('subName')||{}).value||'';
  var phone = (document.getElementById('subPhone')||{}).value||'';
  var email = (document.getElementById('subEmail')||{}).value||'';
  var msg   = document.getElementById('subMsg');
  var btn   = document.querySelector('.sub-form-wrap button');
  await fwSendOtp(name, email, phone, 'homepage', msg, btn);
}


/* -- BOOKING MODAL -- */
var curTrip='',curPrice=0,payMode='full';
function openBookNow(name,price,month){
  curTrip=name;curPrice=price;
  document.getElementById('bTag').textContent='Book Expedition';
  document.getElementById('bName').textContent=name;
  document.getElementById('bMeta').textContent=month+' ? ?'+price.toLocaleString('en-IN')+' per person';
  document.getElementById('bConfTrip').textContent=name;
  ['sp1','sp2','sp3'].forEach(function(id){document.getElementById(id).classList.remove('visible')});
  document.getElementById('sp1').classList.add('visible');
  ['st1','st2','st3'].forEach(function(id){var el=document.getElementById(id);el.classList.remove('active','done')});
  document.getElementById('st1').classList.add('active');
  payMode='full';
  document.getElementById('pFull').classList.add('selected');
  document.getElementById('pPart').classList.remove('selected');
  updAmt();
  document.getElementById('bookingOverlay').classList.add('open');
  document.body.style.overflow='hidden';
}
function selPay(m){payMode=m;document.getElementById('pFull').classList.toggle('selected',m==='full');document.getElementById('pPart').classList.toggle('selected',m==='partial');updAmt();}
function updAmt(){var a=payMode==='full'?curPrice:Math.round(curPrice*0.5);var n=payMode==='full'?'Full trip amount':'50% deposit ? rest due 30 days before trip';document.getElementById('bPayAmt').textContent='?'+a.toLocaleString('en-IN');document.getElementById('bPayNote').textContent=n;}
function goStep(n){
  if(n===2){if(!document.getElementById('bFirst').value||!document.getElementById('bEmail').value){alert('Please fill your name and email to continue.');return;}updAmt();}
  if(n===3){if(!document.getElementById('bUTR').value){alert('Please enter the UTR / transaction reference after making the payment.');return;}}
  ['sp1','sp2','sp3'].forEach(function(id,i){document.getElementById(id).classList.toggle('visible',i+1===n)});
  ['st1','st2','st3'].forEach(function(id,i){var el=document.getElementById(id);el.classList.remove('active','done');if(i+1<n)el.classList.add('done');else if(i+1===n)el.classList.add('active');});

}
/* -- MODAL & NAV UTILITIES -- */
function closeModal(id){document.getElementById(id).classList.remove('open');document.body.style.overflow='';}
function closeIfOutside(e,id){if(e.target===document.getElementById(id))closeModal(id);}
document.addEventListener('keydown',function(e){if(e.key==='Escape'){document.querySelectorAll('.overlay.open').forEach(function(o){o.classList.remove('open')});document.body.style.overflow='';}});
function toggleMobileMenu(){
  var m=document.getElementById('mobileMenu');
  var b=document.getElementById('hamburgerBtn');
  m.classList.toggle('open');
  b.classList.toggle('open');
  document.body.style.overflow=m.classList.contains('open')?'hidden':'';
}
function closeMobileMenu(){
  document.getElementById('mobileMenu').classList.remove('open');
  document.getElementById('hamburgerBtn').classList.remove('open');
  document.body.style.overflow='';
}


function showTab(id, el) {
  document.getElementById('tab-inc').style.display='none';
  document.getElementById('tab-exc').style.display='none';
  document.getElementById('tab-can').style.display='none';
  document.getElementById('tab-'+id).style.display='block';
  document.querySelectorAll('.ie-tab').forEach(function(t){t.classList.remove('active')});
  el.classList.add('active');
}

function toggleMenu(){var m=document.getElementById('mobileMenu'),b=document.getElementById('hbBtn');m.classList.toggle('open');b.classList.toggle('open');document.body.style.overflow=m.classList.contains('open')?'hidden':'';}
function closeMenu(){document.getElementById('mobileMenu').classList.remove('open');document.getElementById('hbBtn').classList.remove('open');document.body.style.overflow='';}


/* -- HOMEPAGE -- */
document.addEventListener('DOMContentLoaded', function() {

  /* -- 1. INJECT fw-data.js inline if external load fails -- */
  if (typeof FW === 'undefined') { console.warn('[FW] Data layer not loaded'); return; }

  /* -- 2. ANIMATED STATS COUNTER -- */
  function animateCounter(el, target, suffix) {
    var start = 0, duration = 1800, step = duration / 60;
    var timer = setInterval(function() {
      start += target / (duration / step);
      if (start >= target) { start = target; clearInterval(timer); }
      el.textContent = Math.floor(start).toLocaleString('en-IN') + suffix;
    }, step);
  }

  var statsObserver = new IntersectionObserver(function(entries) {
    entries.forEach(function(e) {
      if (!e.isIntersecting) return;
      var stats = document.querySelectorAll('.stat');
      var data = [
        { val: FW.stats.expeditions, suffix: '+' },
        { val: 20, suffix: '+' },
        { val: FW.stats.kms / 1000, suffix: ',000+' },
        { val: FW.stats.members, suffix: '+' },
      ];
      stats.forEach(function(s, i) {
        var numEl = s.querySelector('.stat-n');
        if (numEl && data[i]) animateCounter(numEl, data[i].val, data[i].suffix);
      });
      statsObserver.disconnect();
    });
  }, { threshold: 0.3 });

  var heroStats = document.querySelector('.hero-stats');
  if (heroStats) statsObserver.observe(heroStats);

  /* -- 3. DYNAMIC TRIP CARDS from FW.upcoming -- */
  var track = document.getElementById('cTrack');
  // Cards are now static HTML in front-page.php for reliability
  // JS only handles dots/navigation below
  if (track && track.querySelectorAll('.trip-card').length === 0) {
    track.innerHTML = FW.upcoming.map(function(t) {
      var slots = t.slotsLeft || (t.maxSlots - t.filledSlots);
      var slotPct = Math.round(((t.maxSlots - slots) / t.maxSlots) * 100);
      var priceDisplay = FW.fmt.price(t.price) +
        ' <span style="font-size:13px;font-weight:300;color:rgba(255,255,255,.45)">' +
        (t.priceUnit || 'per person') + '</span>';

      /* Photo layer - real image on top of gradient fallback */
      var photoLayer = t.photo
        ? '<img src="' + t.photo + '" alt="' + t.title + '" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;object-position:center;z-index:1;display:block">'
        : '';
      var gradBg = t.heroGradient || 'linear-gradient(145deg,#1a1208,#0f0d0b)';

      return '<div class="trip-card" onmouseenter="cPause()" onmouseleave="cResume()">' +
        '<div class="tc-top" style="background:' + gradBg + '">' +
          photoLayer +
          '<div class="tc-grad" style="z-index:2"></div>' +
          '<div class="tc-badge" style="z-index:3;border-color:' + t.badgeColor + ';color:' + t.badgeColor + '">' + t.badge + '</div>' +
        '</div>' +
        '<div class="tc-body">' +
          '<div class="tc-month">' + t.month + '</div>' +
          '<div class="tc-name">' + t.title + '</div>' +
          '<div style="font-size:12px;font-weight:300;color:rgba(255,255,255,.4);margin-bottom:10px;font-style:italic">' + t.subtitle + '</div>' +
          '<div class="tc-dur">' + t.duration + '</div>' +
          '<div class="tc-dets">' +
            '<div class="tc-det">? ' + t.destination + '</div>' +
            '<div class="tc-det">? Self Drive</div>' +
            '<div class="tc-det" style="color:' + (slots <= 5 ? 'var(--rust)' : 'inherit') + '">?? ' + slots + ' slots left</div>' +
          '</div>' +
          '<div style="margin:10px 0 14px">' +
            '<div style="height:3px;background:rgba(255,255,255,.08);border-radius:2px;overflow:hidden">' +
              '<div style="height:100%;width:' + slotPct + '%;background:' + (slotPct > 75 ? 'var(--rust)' : 'var(--amber)') + ';border-radius:2px"></div>' +
            '</div>' +
            '<div style="font-size:10px;color:rgba(255,255,255,.3);margin-top:4px">' + slotPct + '% filled ? ' + t.dates + '</div>' +
          '</div>' +
          '<div class="tc-price"><span class="p-from">from</span> <span class="p-num">' + priceDisplay + '</span></div>' +
          '<div class="tc-btns"><a href="' + t.slug + '" class="det-btn">More Details ?</a></div>' +
        '</div>' +
      '</div>'
    }).join('');
    // Init carousel AFTER cards are injected
    setTimeout(function(){
      cBuildDots();
      cGo(0);
      cInitHover();
      cInitDrag();
      cInitScrollWatch();
      cStartAuto();
    }, 120);
  }

  /* -- 4. SUBSCRIBE FORM - handled by handleSub() + fwSendOtp() in OTP flow -- */
  // Old email-only .sub-form listener removed. Subscribe button in homepage section
  // calls handleSub() which triggers the full OTP verification flow.

  /* -- 6. SMOOTH SCROLL for all anchor links -- */
  document.querySelectorAll('a[href^="#"]').forEach(function(a) {
    a.addEventListener('click', function(e) {
      var target = document.querySelector(this.getAttribute('href'));
      if (target) { e.preventDefault(); target.scrollIntoView({ behavior: 'smooth', block: 'start' }); }
    });
  });

  /* -- 7. STICKY NAV - add shadow on scroll -- */
  window.addEventListener('scroll', function() {
    var nav = document.querySelector('nav');
    if (nav) nav.style.boxShadow = window.scrollY > 20 ? '0 4px 24px rgba(0,0,0,.5)' : '';
  });

  /* -- 8. LAZY LOAD images -- */
  if ('IntersectionObserver' in window) {
    var imgObserver = new IntersectionObserver(function(entries) {
      entries.forEach(function(e) {
        if (e.isIntersecting) {
          var img = e.target;
          if (img.dataset.src) { img.src = img.dataset.src; img.removeAttribute('data-src'); }
          imgObserver.unobserve(img);
        }
      });
    }, { rootMargin: '200px' });
    document.querySelectorAll('img[data-src]').forEach(function(img) { imgObserver.observe(img); });
  }

  /* -- 9. SECTION REVEAL ANIMATIONS -- */
  if ('IntersectionObserver' in window) {
    var revealStyle = document.createElement('style');
    revealStyle.textContent = '.reveal{opacity:0;transform:translateY(28px);transition:opacity .6s ease,transform .6s ease}.reveal.visible{opacity:1;transform:none}';
    document.head.appendChild(revealStyle);
    var revealObs = new IntersectionObserver(function(entries) {
      entries.forEach(function(e) { if (e.isIntersecting) { e.target.classList.add('visible'); revealObs.unobserve(e.target); } });
    }, { threshold: 0.12 });
    document.querySelectorAll('.about, .upcoming, .past-section, .subscribe, .loyalty-section').forEach(function(s) {
      s.classList.add('reveal'); revealObs.observe(s);
    });
  }

  /* -- 10. MOBILE TOUCH - carousel swipe -- */
  var carousel = document.querySelector('.carousel-wrap') || document.querySelector('.carousel-track');
  if (carousel) {
    var startX = 0, scrollLeft = 0;
    carousel.addEventListener('touchstart', function(e) { startX = e.touches[0].clientX; scrollLeft = carousel.scrollLeft; }, { passive: true });
    carousel.addEventListener('touchmove', function(e) { carousel.scrollLeft = scrollLeft - (e.touches[0].clientX - startX); }, { passive: true });
  }

});


/* -- NEPAL TRIP PAGE -- */
document.addEventListener('DOMContentLoaded', function() {
  if (typeof FW === 'undefined') return;
  var trip = FW.getTrip('nepal');
  if (!trip) return;

  /* -- UPDATE PRICES from data -- */
  document.querySelectorAll('.pc-price').forEach(function(el) {
    el.textContent = FW.fmt.price(trip.price);
  });
  document.querySelectorAll('.pc-alt-price').forEach(function(el, i) {
    var prices = [trip.couplePrice, trip.sharingPrice].filter(Boolean);
    if (prices[i]) el.textContent = FW.fmt.price(prices[i]) + '/person';
  });

  /* -- UPDATE DATES from data -- */
  document.querySelectorAll('.trip-dates, .tc-badge, [data-dates]').forEach(function(el) {
    el.textContent = trip.dates;
  });

  /* -- INJECT ITINERARY dynamically -- */
  var itinContainer = document.getElementById('itinContainer') || document.querySelector('.itinerary-items');
  if (itinContainer && trip.itinerary) {
    itinContainer.innerHTML = trip.itinerary.map(function(day, i) {
      return '<div class="itin-day" style="display:flex;gap:16px;padding:16px 0;border-bottom:1px solid rgba(255,255,255,.06)">' +
        '<div style="flex-shrink:0;width:44px;height:44px;background:rgba(193,68,14,.12);border:1px solid rgba(193,68,14,.25);display:flex;align-items:center;justify-content:center;border-radius:2px">' +
          '<span style="font-family:var(--headline);font-size:16px;color:var(--rust);letter-spacing:1px">D' + day.day + '</span>' +
        '</div>' +
        '<div>' +
          '<div style="font-weight:600;color:#fff;margin-bottom:4px;font-size:14px">' + day.title + '</div>' +
          '<div style="font-size:13px;font-weight:300;color:rgba(255,255,255,.5);line-height:1.6">' + day.desc + '</div>' +
        '</div>' +
      '</div>';
    }).join('');
  }

  /* -- SLOTS PROGRESS BAR -- */
  var slotBars = document.querySelectorAll('.slots-bar, [data-slots]');
  slotBars.forEach(function(el) {
    var pct = Math.round((trip.filledSlots / trip.maxSlots) * 100);
    el.innerHTML = '<div style="height:3px;background:rgba(255,255,255,.08);border-radius:2px;overflow:hidden;margin-bottom:5px">' +
      '<div style="height:100%;width:' + pct + '%;background:' + (pct > 75 ? 'var(--rust)' : 'var(--amber)') + ';border-radius:2px"></div></div>' +
      '<div style="font-size:11px;color:rgba(255,255,255,.4)">' + (trip.maxSlots - trip.filledSlots) + ' of ' + trip.maxSlots + ' slots remaining</div>';
  });

  /* -- BOTTOM CTA - scroll to payment panel -- */
  document.querySelectorAll('.btn-solid, .bottom-cta-btn, a[href="#"]').forEach(function(btn) {
    if (btn.textContent.includes('Book Now') || btn.textContent.includes('?')) {
      btn.addEventListener('click', function(e) {
        e.preventDefault();
        var panel = document.querySelector('.pay-panel');
        if (panel) panel.scrollIntoView({ behavior: 'smooth', block: 'start' });
      });
    }
  });

  /* -- STICKY NAV scroll shadow -- */
  window.addEventListener('scroll', function() {
    var nav = document.querySelector('nav');
    if (nav) nav.style.boxShadow = window.scrollY > 20 ? '0 4px 24px rgba(0,0,0,.5)' : '';
  });

  /* -- SECTION REVEAL -- */
  if ('IntersectionObserver' in window) {
    var st = document.createElement('style');
    st.textContent = '.reveal{opacity:0;transform:translateY(24px);transition:opacity .6s ease,transform .6s ease}.reveal.visible{opacity:1;transform:none}';
    document.head.appendChild(st);
    var obs = new IntersectionObserver(function(e) {
      e.forEach(function(en) { if(en.isIntersecting) { en.target.classList.add('visible'); obs.unobserve(en.target); } });
    }, {threshold:0.1});
    document.querySelectorAll('section, .itinerary, .sidebar, .cta').forEach(function(s) {
      s.classList.add('reveal'); obs.observe(s);
    });
  }

  /* -- PAYMENT PANEL TABS (already in pages but ensure they work) -- */
  window.switchPay = function(btn, id) {
    document.querySelectorAll('.ptab').forEach(function(t) { t.classList.remove('active'); });
    document.querySelectorAll('.pmethod').forEach(function(m) { m.classList.remove('visible'); });
    btn.classList.add('active');
    var el = document.getElementById('pay-' + id);
    if (el) el.classList.add('visible');
  };

  window.switchPay = function(btn, id) {
    document.querySelectorAll('.ptab').forEach(function(t) { t.classList.remove('active'); });
    document.querySelectorAll('.pmethod').forEach(function(m) { m.classList.remove('visible'); });
    btn.classList.add('active');
    var el = document.getElementById('pay-' + id);
    if (el) el.classList.add('visible');
  };

});


/* -- LEH TRIP PAGE -- */
document.addEventListener('DOMContentLoaded', function() {
  if (typeof FW === 'undefined') return;
  var trip = FW.getTrip('leh');
  if (!trip) return;

  /* -- UPDATE PRICES from data -- */
  document.querySelectorAll('.pc-price').forEach(function(el) {
    el.textContent = FW.fmt.price(trip.price);
  });
  document.querySelectorAll('.pc-alt-price').forEach(function(el, i) {
    var prices = [trip.couplePrice, trip.sharingPrice].filter(Boolean);
    if (prices[i]) el.textContent = FW.fmt.price(prices[i]) + '/person';
  });

  /* -- UPDATE DATES from data -- */
  document.querySelectorAll('.trip-dates, .tc-badge, [data-dates]').forEach(function(el) {
    el.textContent = trip.dates;
  });

  /* -- INJECT ITINERARY dynamically -- */
  var itinContainer = document.getElementById('itinContainer') || document.querySelector('.itinerary-items');
  if (itinContainer && trip.itinerary) {
    itinContainer.innerHTML = trip.itinerary.map(function(day, i) {
      return '<div class="itin-day" style="display:flex;gap:16px;padding:16px 0;border-bottom:1px solid rgba(255,255,255,.06)">' +
        '<div style="flex-shrink:0;width:44px;height:44px;background:rgba(193,68,14,.12);border:1px solid rgba(193,68,14,.25);display:flex;align-items:center;justify-content:center;border-radius:2px">' +
          '<span style="font-family:var(--headline);font-size:16px;color:var(--rust);letter-spacing:1px">D' + day.day + '</span>' +
        '</div>' +
        '<div>' +
          '<div style="font-weight:600;color:#fff;margin-bottom:4px;font-size:14px">' + day.title + '</div>' +
          '<div style="font-size:13px;font-weight:300;color:rgba(255,255,255,.5);line-height:1.6">' + day.desc + '</div>' +
        '</div>' +
      '</div>';
    }).join('');
  }

  /* -- SLOTS PROGRESS BAR -- */
  var slotBars = document.querySelectorAll('.slots-bar, [data-slots]');
  slotBars.forEach(function(el) {
    var pct = Math.round((trip.filledSlots / trip.maxSlots) * 100);
    el.innerHTML = '<div style="height:3px;background:rgba(255,255,255,.08);border-radius:2px;overflow:hidden;margin-bottom:5px">' +
      '<div style="height:100%;width:' + pct + '%;background:' + (pct > 75 ? 'var(--rust)' : 'var(--amber)') + ';border-radius:2px"></div></div>' +
      '<div style="font-size:11px;color:rgba(255,255,255,.4)">' + (trip.maxSlots - trip.filledSlots) + ' of ' + trip.maxSlots + ' slots remaining</div>';
  });

  /* -- BOTTOM CTA - scroll to payment panel -- */
  document.querySelectorAll('.btn-solid, .bottom-cta-btn, a[href="#"]').forEach(function(btn) {
    if (btn.textContent.includes('Book Now') || btn.textContent.includes('?')) {
      btn.addEventListener('click', function(e) {
        e.preventDefault();
        var panel = document.querySelector('.pay-panel');
        if (panel) panel.scrollIntoView({ behavior: 'smooth', block: 'start' });
      });
    }
  });

  /* -- STICKY NAV scroll shadow -- */
  window.addEventListener('scroll', function() {
    var nav = document.querySelector('nav');
    if (nav) nav.style.boxShadow = window.scrollY > 20 ? '0 4px 24px rgba(0,0,0,.5)' : '';
  });

  /* -- SECTION REVEAL -- */
  if ('IntersectionObserver' in window) {
    var st = document.createElement('style');
    st.textContent = '.reveal{opacity:0;transform:translateY(24px);transition:opacity .6s ease,transform .6s ease}.reveal.visible{opacity:1;transform:none}';
    document.head.appendChild(st);
    var obs = new IntersectionObserver(function(e) {
      e.forEach(function(en) { if(en.isIntersecting) { en.target.classList.add('visible'); obs.unobserve(en.target); } });
    }, {threshold:0.1});
    document.querySelectorAll('section, .itinerary, .sidebar, .cta').forEach(function(s) {
      s.classList.add('reveal'); obs.observe(s);
    });
  }

  /* -- PAYMENT PANEL TABS (already in pages but ensure they work) -- */
  window.switchPay = function(btn, id) {
    document.querySelectorAll('.ptab').forEach(function(t) { t.classList.remove('active'); });
    document.querySelectorAll('.pmethod').forEach(function(m) { m.classList.remove('visible'); });
    btn.classList.add('active');
    var el = document.getElementById('pay-' + id);
    if (el) el.classList.add('visible');
  };

  window.switchPay = function(btn, id) {
    document.querySelectorAll('.ptab').forEach(function(t) { t.classList.remove('active'); });
    document.querySelectorAll('.pmethod').forEach(function(m) { m.classList.remove('visible'); });
    btn.classList.add('active');
    var el = document.getElementById('pay-' + id);
    if (el) el.classList.add('visible');
  };

});


/* -- SPITI TRIP PAGE -- */
document.addEventListener('DOMContentLoaded', function() {
  if (typeof FW === 'undefined') return;
  var trip = FW.getTrip('spiti');
  if (!trip) return;

  /* -- UPDATE PRICES from data -- */
  document.querySelectorAll('.pc-price').forEach(function(el) {
    el.textContent = FW.fmt.price(trip.price);
  });
  document.querySelectorAll('.pc-alt-price').forEach(function(el, i) {
    var prices = [trip.couplePrice, trip.sharingPrice].filter(Boolean);
    if (prices[i]) el.textContent = FW.fmt.price(prices[i]) + '/person';
  });

  /* -- UPDATE DATES from data -- */
  document.querySelectorAll('.trip-dates, .tc-badge, [data-dates]').forEach(function(el) {
    el.textContent = trip.dates;
  });

  /* -- INJECT ITINERARY dynamically -- */
  var itinContainer = document.getElementById('itinContainer') || document.querySelector('.itinerary-items');
  if (itinContainer && trip.itinerary) {
    itinContainer.innerHTML = trip.itinerary.map(function(day, i) {
      return '<div class="itin-day" style="display:flex;gap:16px;padding:16px 0;border-bottom:1px solid rgba(255,255,255,.06)">' +
        '<div style="flex-shrink:0;width:44px;height:44px;background:rgba(193,68,14,.12);border:1px solid rgba(193,68,14,.25);display:flex;align-items:center;justify-content:center;border-radius:2px">' +
          '<span style="font-family:var(--headline);font-size:16px;color:var(--rust);letter-spacing:1px">D' + day.day + '</span>' +
        '</div>' +
        '<div>' +
          '<div style="font-weight:600;color:#fff;margin-bottom:4px;font-size:14px">' + day.title + '</div>' +
          '<div style="font-size:13px;font-weight:300;color:rgba(255,255,255,.5);line-height:1.6">' + day.desc + '</div>' +
        '</div>' +
      '</div>';
    }).join('');
  }

  /* -- SLOTS PROGRESS BAR -- */
  var slotBars = document.querySelectorAll('.slots-bar, [data-slots]');
  slotBars.forEach(function(el) {
    var pct = Math.round((trip.filledSlots / trip.maxSlots) * 100);
    el.innerHTML = '<div style="height:3px;background:rgba(255,255,255,.08);border-radius:2px;overflow:hidden;margin-bottom:5px">' +
      '<div style="height:100%;width:' + pct + '%;background:' + (pct > 75 ? 'var(--rust)' : 'var(--amber)') + ';border-radius:2px"></div></div>' +
      '<div style="font-size:11px;color:rgba(255,255,255,.4)">' + (trip.maxSlots - trip.filledSlots) + ' of ' + trip.maxSlots + ' slots remaining</div>';
  });

  /* -- BOTTOM CTA - scroll to payment panel -- */
  document.querySelectorAll('.btn-solid, .bottom-cta-btn, a[href="#"]').forEach(function(btn) {
    if (btn.textContent.includes('Book Now') || btn.textContent.includes('?')) {
      btn.addEventListener('click', function(e) {
        e.preventDefault();
        var panel = document.querySelector('.pay-panel');
        if (panel) panel.scrollIntoView({ behavior: 'smooth', block: 'start' });
      });
    }
  });

  /* -- STICKY NAV scroll shadow -- */
  window.addEventListener('scroll', function() {
    var nav = document.querySelector('nav');
    if (nav) nav.style.boxShadow = window.scrollY > 20 ? '0 4px 24px rgba(0,0,0,.5)' : '';
  });

  /* -- SECTION REVEAL -- */
  if ('IntersectionObserver' in window) {
    var st = document.createElement('style');
    st.textContent = '.reveal{opacity:0;transform:translateY(24px);transition:opacity .6s ease,transform .6s ease}.reveal.visible{opacity:1;transform:none}';
    document.head.appendChild(st);
    var obs = new IntersectionObserver(function(e) {
      e.forEach(function(en) { if(en.isIntersecting) { en.target.classList.add('visible'); obs.unobserve(en.target); } });
    }, {threshold:0.1});
    document.querySelectorAll('section, .itinerary, .sidebar, .cta').forEach(function(s) {
      s.classList.add('reveal'); obs.observe(s);
    });
  }

  /* -- PAYMENT PANEL TABS (already in pages but ensure they work) -- */
  window.switchPay = function(btn, id) {
    document.querySelectorAll('.ptab').forEach(function(t) { t.classList.remove('active'); });
    document.querySelectorAll('.pmethod').forEach(function(m) { m.classList.remove('visible'); });
    btn.classList.add('active');
    var el = document.getElementById('pay-' + id);
    if (el) el.classList.add('visible');
  };

  window.switchPay = function(btn, id) {
    document.querySelectorAll('.ptab').forEach(function(t) { t.classList.remove('active'); });
    document.querySelectorAll('.pmethod').forEach(function(m) { m.classList.remove('visible'); });
    btn.classList.add('active');
    var el = document.getElementById('pay-' + id);
    if (el) el.classList.add('visible');
  };

});


/* -- ADI KAILASH TRIP PAGE -- */
document.addEventListener('DOMContentLoaded', function() {
  if (typeof FW === 'undefined') return;
  var trip = FW.getTrip('adikailash');
  if (!trip) return;

  /* -- UPDATE PRICES from data -- */
  document.querySelectorAll('.pc-price').forEach(function(el) {
    el.textContent = FW.fmt.price(trip.price);
  });
  document.querySelectorAll('.pc-alt-price').forEach(function(el, i) {
    var prices = [trip.couplePrice, trip.sharingPrice].filter(Boolean);
    if (prices[i]) el.textContent = FW.fmt.price(prices[i]) + '/person';
  });

  /* -- UPDATE DATES from data -- */
  document.querySelectorAll('.trip-dates, .tc-badge, [data-dates]').forEach(function(el) {
    el.textContent = trip.dates;
  });

  /* -- INJECT ITINERARY dynamically -- */
  var itinContainer = document.getElementById('itinContainer') || document.querySelector('.itinerary-items');
  if (itinContainer && trip.itinerary) {
    itinContainer.innerHTML = trip.itinerary.map(function(day, i) {
      return '<div class="itin-day" style="display:flex;gap:16px;padding:16px 0;border-bottom:1px solid rgba(255,255,255,.06)">' +
        '<div style="flex-shrink:0;width:44px;height:44px;background:rgba(193,68,14,.12);border:1px solid rgba(193,68,14,.25);display:flex;align-items:center;justify-content:center;border-radius:2px">' +
          '<span style="font-family:var(--headline);font-size:16px;color:var(--rust);letter-spacing:1px">D' + day.day + '</span>' +
        '</div>' +
        '<div>' +
          '<div style="font-weight:600;color:#fff;margin-bottom:4px;font-size:14px">' + day.title + '</div>' +
          '<div style="font-size:13px;font-weight:300;color:rgba(255,255,255,.5);line-height:1.6">' + day.desc + '</div>' +
        '</div>' +
      '</div>';
    }).join('');
  }

  /* -- SLOTS PROGRESS BAR -- */
  var slotBars = document.querySelectorAll('.slots-bar, [data-slots]');
  slotBars.forEach(function(el) {
    var pct = Math.round((trip.filledSlots / trip.maxSlots) * 100);
    el.innerHTML = '<div style="height:3px;background:rgba(255,255,255,.08);border-radius:2px;overflow:hidden;margin-bottom:5px">' +
      '<div style="height:100%;width:' + pct + '%;background:' + (pct > 75 ? 'var(--rust)' : 'var(--amber)') + ';border-radius:2px"></div></div>' +
      '<div style="font-size:11px;color:rgba(255,255,255,.4)">' + (trip.maxSlots - trip.filledSlots) + ' of ' + trip.maxSlots + ' slots remaining</div>';
  });

  /* -- BOTTOM CTA - scroll to payment panel -- */
  document.querySelectorAll('.btn-solid, .bottom-cta-btn, a[href="#"]').forEach(function(btn) {
    if (btn.textContent.includes('Book Now') || btn.textContent.includes('?')) {
      btn.addEventListener('click', function(e) {
        e.preventDefault();
        var panel = document.querySelector('.pay-panel');
        if (panel) panel.scrollIntoView({ behavior: 'smooth', block: 'start' });
      });
    }
  });

  /* -- STICKY NAV scroll shadow -- */
  window.addEventListener('scroll', function() {
    var nav = document.querySelector('nav');
    if (nav) nav.style.boxShadow = window.scrollY > 20 ? '0 4px 24px rgba(0,0,0,.5)' : '';
  });

  /* -- SECTION REVEAL -- */
  if ('IntersectionObserver' in window) {
    var st = document.createElement('style');
    st.textContent = '.reveal{opacity:0;transform:translateY(24px);transition:opacity .6s ease,transform .6s ease}.reveal.visible{opacity:1;transform:none}';
    document.head.appendChild(st);
    var obs = new IntersectionObserver(function(e) {
      e.forEach(function(en) { if(en.isIntersecting) { en.target.classList.add('visible'); obs.unobserve(en.target); } });
    }, {threshold:0.1});
    document.querySelectorAll('section, .itinerary, .sidebar, .cta').forEach(function(s) {
      s.classList.add('reveal'); obs.observe(s);
    });
  }

  /* -- PAYMENT PANEL TABS (already in pages but ensure they work) -- */
  window.switchPay = function(btn, id) {
    document.querySelectorAll('.ptab').forEach(function(t) { t.classList.remove('active'); });
    document.querySelectorAll('.pmethod').forEach(function(m) { m.classList.remove('visible'); });
    btn.classList.add('active');
    var el = document.getElementById('pay-' + id);
    if (el) el.classList.add('visible');
  };

  window.switchPay = function(btn, id) {
    document.querySelectorAll('.ptab').forEach(function(t) { t.classList.remove('active'); });
    document.querySelectorAll('.pmethod').forEach(function(m) { m.classList.remove('visible'); });
    btn.classList.add('active');
    var el = document.getElementById('pay-' + id);
    if (el) el.classList.add('visible');
  };

});


/* -- EXPEDITIONS PAGE - ALBUMS & LIGHTBOX -- */
// -- SIDEBAR ACTIVE STATE --
var albums = document.querySelectorAll('.album-block');
var sideLinks = document.querySelectorAll('.sidebar-link');
function updateSidebar(){
  var scrollY = window.scrollY + 120;
  albums.forEach(function(a,i){
    if(a.offsetTop <= scrollY){
      sideLinks.forEach(function(l){l.classList.remove('active')});
      if(sideLinks[i]) sideLinks[i].classList.add('active');
    }
  });
}
window.addEventListener('scroll', updateSidebar);
updateSidebar();

// -- ALBUM SHOW MORE / COLLAPSE --
function fwToggleAlbum(slug, btn, total){
  var grid = document.getElementById('grid-' + slug);
  if(!grid) return;
  var hidden = grid.querySelectorAll('.album-thumb-hidden');
  var isExpanded = hidden.length === 0;
  if(isExpanded){
    // Collapse back to 6
    var thumbs = grid.querySelectorAll('.album-thumb');
    thumbs.forEach(function(t, i){ if(i >= 6) t.classList.add('album-thumb-hidden'); });
    btn.textContent = 'Show All ' + total + ' Photos \u2193';
    // Scroll back up to this album
    grid.closest('.album-block').scrollIntoView({behavior:'smooth', block:'start'});
  } else {
    // Expand all
    hidden.forEach(function(t){ t.classList.remove('album-thumb-hidden'); });
    btn.textContent = 'Show Less \u2191';
  }
}

// -- LIGHTBOX --
var lbAlbum='', lbIdx=0, lbMax=6;

function openLightbox(albumId, idx){
  lbAlbum = albumId;
  lbIdx   = idx;
  // Use albumDataOverride (baked inline by PHP) as primary source
  // Fall back to reading live img srcs from the grid
  var srcs = _lbSrcs(albumId);
  lbMax = srcs.length || 1;
  showLb();
  document.getElementById('lightbox').classList.add('open');
  document.body.style.overflow='hidden';
}

function _lbSrcs(albumId){
  // Primary: PHP-baked inline script block
  if(window.albumDataOverride && window.albumDataOverride[albumId] && window.albumDataOverride[albumId].length){
    return window.albumDataOverride[albumId];
  }
  // Fallback: read live from DOM grid (works even without data-* attrs)
  var grid = document.getElementById('grid-' + albumId);
  if(grid){
    var srcs = [];
    grid.querySelectorAll('.album-thumb img').forEach(function(img){
      var s = img.currentSrc || img.src || '';
      if(s && s !== window.location.href) srcs.push(s);
    });
    if(srcs.length) return srcs;
  }
  return [];
}

function showLb(){
  var srcs = _lbSrcs(lbAlbum);
  var src  = srcs[lbIdx] || '';
  var img  = document.getElementById('lbImg');
  var ph   = document.getElementById('lbPlaceholder');
  if(src){
    img.src=src; img.style.display='block'; ph.style.display='none';
  }else{
    img.style.display='none'; ph.style.display='flex';
  }
  document.getElementById('lbCounter').textContent = (lbIdx+1) + ' / ' + lbMax;
  document.getElementById('lbPhotoNum').textContent = 'Photo ' + (lbIdx+1) + ' of ' + lbMax;
  var albumEl = document.getElementById('album-' + lbAlbum);
  var nameEl  = document.getElementById('lbAlbumName');
  if(nameEl) nameEl.textContent = albumEl && albumEl.querySelector('.album-title') ? albumEl.querySelector('.album-title').textContent : lbAlbum;
}
function lbStep(d){
  lbIdx = (lbIdx + d + lbMax) % lbMax;
  showLb();
}
function closeLightbox(){
  document.getElementById('lightbox').classList.remove('open');
  document.body.style.overflow='';
}
function lbOutside(e){
  if(e.target===document.getElementById('lightbox')) closeLightbox();
}
document.addEventListener('keydown',function(e){
  var _lb=document.getElementById('lightbox'); if(!_lb||!_lb.classList.contains('open')) return;
  if(e.key==='ArrowLeft') lbStep(-1);
  if(e.key==='ArrowRight') lbStep(1);
  if(e.key==='Escape') closeLightbox();
});



/* -- COMMUNITY PAGE -- */
document.addEventListener('DOMContentLoaded', function() {
  if (typeof FW === 'undefined') return;

  /* -- ANIMATED STAT COUNTERS -- */
  function countUp(el, target, suffix) {
    var s=0, d=1600;
    var t = setInterval(function(){
      s += target/(d/16);
      if(s>=target){s=target;clearInterval(t);}
      el.textContent = Math.floor(s).toLocaleString('en-IN') + suffix;
    },16);
  }
  var obs = new IntersectionObserver(function(entries){
    entries.forEach(function(e){
      if(!e.isIntersecting)return;
      var nums = e.target.querySelectorAll('.cstat-n');
      var data = [
        {val:FW.stats.members,    suffix:'+'},
        {val:FW.stats.expeditions,suffix:'+'},
        {val:FW.stats.states,     suffix:''},
        {val:300,                 suffix:'K+'},
      ];
      nums.forEach(function(n,i){ if(data[i]) countUp(n,data[i].val,data[i].suffix); });
      obs.disconnect();
    });
  },{threshold:0.3});
  var statsBlock = document.querySelector('.comm-stats');
  if(statsBlock) obs.observe(statsBlock);

  /* -- TESTIMONIALS CAROUSEL -- */
  var testiGrid = document.querySelector('.testi-grid');
  if(testiGrid && FW.testimonials) {
    var current = 0;
    setInterval(function(){
      var cards = testiGrid.querySelectorAll('.testi-card');
      cards.forEach(function(c){c.style.opacity='0.3';c.style.transform='scale(.98)';});
      current = (current+1) % cards.length;
      cards[current].style.opacity='1';
      cards[current].style.transform='scale(1)';
    }, 3500);
  }

  /* -- UPDATE WA LINK from FW.site -- */
  document.querySelectorAll('a[href*="chat.whatsapp.com"], a[href*="wa.me"]').forEach(function(a){
    if(a.href.includes('join') || a.href.includes('IpVF')) a.href = FW.site.community;
  });

  /* -- SECTION REVEAL -- */
  if('IntersectionObserver' in window){
    var st=document.createElement('style');
    st.textContent='.reveal{opacity:0;transform:translateY(24px);transition:opacity .6s ease,transform .6s ease}.reveal.visible{opacity:1;transform:none}';
    document.head.appendChild(st);
    var ro=new IntersectionObserver(function(e){e.forEach(function(en){if(en.isIntersecting){en.target.classList.add('visible');ro.unobserve(en.target);}});},{threshold:0.1});
    document.querySelectorAll('.what-section,.perks-section,.testi-section,.perk').forEach(function(s){s.classList.add('reveal');ro.observe(s);});
  }

  /* -- STICKY NAV -- */
  window.addEventListener('scroll',function(){var n=document.querySelector('nav');if(n)n.style.boxShadow=window.scrollY>20?'0 4px 24px rgba(0,0,0,.5)':'';});
});


/* -- MERCHANDISE PAGE -- */
// Filter
function filterMerch(btn, cat){
  document.querySelectorAll('.filt').forEach(function(f){f.classList.remove('active')});
  btn.classList.add('active');
  document.querySelectorAll('.merch-card').forEach(function(c){
    var cardCat = c.querySelector('.mc-cat').textContent;
    c.style.display = (cat==='all' || cardCat===cat) ? 'flex' : 'none';
  });
}

// Size selection
function selectSize(btn){
  var parent = btn.closest('.sz-btns');
  parent.querySelectorAll('.sz-btn').forEach(function(b){b.classList.remove('selected')});
  btn.classList.add('selected');
}

// Buy modal
var curItem='', curPrice=0, curName='';
function openBuy(id, name, price){
  curItem=id; curPrice=price; curName=name;
  document.getElementById('buyTitle').textContent = name;
  document.getElementById('buyPrice').textContent = '₹' + price.toLocaleString('en-IN');
  var waMsg = 'Hi%21%20I%20want%20to%20buy%20' + encodeURIComponent(name) + '%20(%E2%82%B9' + price + ').%20Please%20confirm%20my%20order.';
  var waBtn = document.getElementById('waBtn');
  if(waBtn) waBtn.href = 'https://wa.me/917817838060?text=' + waMsg;
  document.getElementById('buyOverlay').classList.add('open');
  document.body.style.overflow='hidden';
  // Reset state
  var rzpMsg = document.getElementById('rzpMerchMsg');
  if(rzpMsg){ rzpMsg.textContent=''; }
  var rzpBtn = document.getElementById('rzpMerchBtn');
  if(rzpBtn){ rzpBtn.disabled=false; rzpBtn.textContent='PAY NOW — ₹'+price.toLocaleString('en-IN'); }
}
function closeBuy(){var o=document.getElementById('buyOverlay');if(o)o.classList.remove('open');document.body.style.overflow='';}
function closeBuyIfOutside(e){if(e.target===document.getElementById('buyOverlay'))closeBuy();}
function switchPay2(btn, id){
  document.querySelectorAll('.ptab2').forEach(function(t){t.classList.remove('active')});
  document.querySelectorAll('.pmethod2').forEach(function(m){m.classList.remove('visible')});
  btn.classList.add('active');
  document.getElementById('pay-' + id).classList.add('visible');
}
document.addEventListener('keydown',function(e){if(e.key==='Escape')closeBuy();});

async function fwMerchRzpPay(){
  if(typeof Razorpay === 'undefined'){
    var msg=document.getElementById('rzpMerchMsg');
    if(msg){msg.textContent='Razorpay payment is being set up. Please use Bank Transfer or UPI in the meantime.';msg.style.color='#f59e0b';}
    return;
  }
  var btn=document.getElementById('rzpMerchBtn');
  var msg=document.getElementById('rzpMerchMsg');
  if(!btn||!msg) return;
  msg.textContent=''; msg.style.color='#f87171';

  // Get selected size if any
  var sizeEl = document.querySelector('.sz-btn.selected');
  var size = sizeEl ? sizeEl.textContent.trim() : '';

  // Check login
  var session=null;
  try{session=JSON.parse(localStorage.getItem('fw_session')||'null');}catch(e){}
  if(!session||!session.access_token||session.expires_at<Date.now()){
    msg.textContent='Please log in to purchase.';
    setTimeout(function(){window.location.href=(window.FW_AUTH?window.FW_AUTH.login_url:'/login/')+'?redirect='+encodeURIComponent(window.location.href);},1200);
    return;
  }
  if(!window.FW_RZP_KEY){msg.textContent='Payment gateway not configured.';return;}

  btn.disabled=true; btn.textContent='Creating order…';
  var amountPaise = curPrice * 100;

  try{
    var or=await fetch((window.FW_AUTH?window.FW_AUTH.rest_url:'/wp-json/freewheel/v1')+'/rzp-create-order',{
      method:'POST',
      headers:{'Content-Type':'application/json','Authorization':'Bearer '+session.access_token},
      body:JSON.stringify({amount:amountPaise,type:'merchandise',ref_id:curItem,note:curName+(size?' · Size: '+size:'')})
    });
    var od=await or.json();
    if(!or.ok) throw new Error(od.message||'Order creation failed.');

    var rzp=new Razorpay({
      key:window.FW_RZP_KEY,
      amount:od.amount,
      currency:od.currency,
      name:'FreeWheel Expeditions',
      description:curName+(size?' ('+size+')':''),
      order_id:od.order_id,
      prefill:{email:session.email,name:session.first_name||''},
      theme:{color:'#c1440e'},
      modal:{ondismiss:function(){btn.disabled=false;btn.textContent='PAY NOW — ₹'+curPrice.toLocaleString('en-IN');}},
      handler:async function(r){
        btn.textContent='Verifying…';
        try{
          var vr=await fetch((window.FW_AUTH?window.FW_AUTH.rest_url:'/wp-json/freewheel/v1')+'/rzp-verify-payment',{
            method:'POST',
            headers:{'Content-Type':'application/json','Authorization':'Bearer '+session.access_token},
            body:JSON.stringify({
              razorpay_order_id:r.razorpay_order_id,
              razorpay_payment_id:r.razorpay_payment_id,
              razorpay_signature:r.razorpay_signature,
              type:'merchandise',ref_id:curItem,
              amount:amountPaise,product_name:curName,size:size
            })
          });
          var vd=await vr.json();
          if(!vr.ok) throw new Error(vd.message||'Verification failed.');
          btn.style.background='#16a34a'; btn.textContent='✓ ORDER PLACED!';
          msg.textContent=vd.message||'Order placed! We\'ll ship within 3–5 days.'; msg.style.color='#4ade80';
          setTimeout(function(){closeBuy();},3000);
        }catch(err){
          msg.textContent='Payment received. Contact support with ID: '+r.razorpay_payment_id;
          btn.disabled=false; btn.textContent='PAY NOW — ₹'+curPrice.toLocaleString('en-IN');
        }
      }
    });
    rzp.on('payment.failed',function(resp){
      msg.textContent='Payment failed: '+(resp.error.description||'Please try again.');
      btn.disabled=false; btn.textContent='PAY NOW — ₹'+curPrice.toLocaleString('en-IN');
    });
    rzp.open();
  }catch(err){
    msg.textContent=err.message||'Something went wrong. Please try again.';
    btn.disabled=false; btn.textContent='PAY NOW — ₹'+curPrice.toLocaleString('en-IN');
  }
}



document.addEventListener('DOMContentLoaded', function() {
  if (typeof FW === 'undefined') return;

  /* Product grid rendered server-side via PHP */


  /* -- SECTION REVEAL -- */
  if ('IntersectionObserver' in window) {
    var st = document.createElement('style');
    st.textContent = '.merch-card{opacity:0;transform:translateY(20px);transition:opacity .5s ease,transform .5s ease}.merch-card.visible{opacity:1;transform:none}';
    document.head.appendChild(st);
    var obs = new IntersectionObserver(function(e){e.forEach(function(en){if(en.isIntersecting){en.target.classList.add('visible');obs.unobserve(en.target);}});},{threshold:0.1});
    setTimeout(function(){document.querySelectorAll('.merch-card').forEach(function(c){obs.observe(c);});},100);
  }

  /* -- STICKY NAV -- */
  window.addEventListener('scroll',function(){var n=document.querySelector('nav');if(n)n.style.boxShadow=window.scrollY>20?'0 4px 24px rgba(0,0,0,.5)':'';});
});


/* -- STATIC CAROUSEL INIT -- */
/* -- STATIC CARD CAROUSEL INIT (for pages where cards are hardcoded HTML) -- */
document.addEventListener('DOMContentLoaded', function() {
  var track = document.getElementById('cTrack');
  if (track && track.querySelectorAll('.trip-card').length > 0) {
    setTimeout(function() {
      cBuildDots();
      cGo(0);
      cInitHover();
      cInitDrag();
      cInitScrollWatch();
      cStartAuto();
    }, 150);
  }
});

