/* ═══════════════════════════════════════════════════════════════
   fw-animate.js — FreeWheel Expeditions · Animation Layer v1.0
   Runs after DOM is ready. Purely additive — no existing JS touched.
═══════════════════════════════════════════════════════════════ */

(function() {
  'use strict';

  /* ── 1. SCROLL PROGRESS BAR ── */
  function initScrollProgress() {
    var bar = document.getElementById('fw-scroll-progress');
    if (!bar) return;
    window.addEventListener('scroll', function() {
      var max  = document.documentElement.scrollHeight - window.innerHeight;
      var pct  = max > 0 ? (window.scrollY / max) * 100 : 0;
      bar.style.width = pct + '%';
    }, { passive: true });
  }

  /* ── 2. CURSOR GLOW ── */
  function initCursorGlow() {
    var glow = document.getElementById('fw-cursor-glow');
    if (!glow || window.matchMedia('(pointer: coarse)').matches) return;
    var tx = 0, ty = 0, cx = 0, cy = 0;
    var raf;
    document.addEventListener('mousemove', function(e) {
      tx = e.clientX; ty = e.clientY;
      glow.style.opacity = '1';
    }, { passive: true });
    document.addEventListener('mouseleave', function() {
      glow.style.opacity = '0';
    });
    function lerp(a, b, t) { return a + (b - a) * t; }
    function animate() {
      cx = lerp(cx, tx, 0.08);
      cy = lerp(cy, ty, 0.08);
      glow.style.left = cx + 'px';
      glow.style.top  = cy + 'px';
      raf = requestAnimationFrame(animate);
    }
    animate();
  }

  /* ── 3. SCROLL REVEAL (IntersectionObserver) ── */
  function initScrollReveal() {
    var selectors = '.fw-reveal, .fw-reveal-left, .fw-reveal-right, .fw-reveal-scale, .fw-stagger, .fw-wipe-wrap';
    var els = document.querySelectorAll(selectors);
    if (!els.length) return;

    var observer = new IntersectionObserver(function(entries) {
      entries.forEach(function(entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('fw-visible');
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

    els.forEach(function(el) { observer.observe(el); });
  }

  /* ── 4. AUTO-TAG ELEMENTS FOR REVEAL ── */
  function autoTagReveal() {
    /* Trip cards */
    document.querySelectorAll('.trip-card, .exp-card').forEach(function(el, i) {
      if (!el.classList.contains('fw-reveal')) {
        el.classList.add('fw-reveal');
        el.style.transitionDelay = Math.min(i * 0.08, 0.4) + 's';
      }
    });
    /* Merch cards */
    document.querySelectorAll('.merch-card, .mc-card').forEach(function(el, i) {
      if (!el.classList.contains('fw-reveal')) {
        el.classList.add('fw-reveal');
        el.style.transitionDelay = Math.min(i * 0.06, 0.36) + 's';
      }
    });
    /* Blog cards */
    document.querySelectorAll('.bl-card').forEach(function(el, i) {
      if (!el.classList.contains('fw-reveal')) {
        el.classList.add('fw-reveal');
        el.style.transitionDelay = Math.min(i * 0.07, 0.35) + 's';
      }
    });
    /* Section titles */
    document.querySelectorAll('.section-title, .sect-title, .dash-section-title').forEach(function(el) {
      if (!el.classList.contains('fw-reveal')) el.classList.add('fw-reveal');
    });
    /* Stat boxes */
    document.querySelectorAll('.stat-item, .stat-card, .dstat').forEach(function(el, i) {
      if (!el.classList.contains('fw-reveal')) {
        el.classList.add('fw-reveal');
        el.style.transitionDelay = Math.min(i * 0.1, 0.4) + 's';
      }
    });
    /* Perks grid items */
    document.querySelectorAll('.perk-item, .perks-grid > div').forEach(function(el, i) {
      if (!el.classList.contains('fw-reveal')) {
        el.classList.add('fw-reveal');
        el.style.transitionDelay = Math.min(i * 0.1, 0.5) + 's';
      }
    });
    /* FAQ items */
    document.querySelectorAll('.faq-item').forEach(function(el, i) {
      if (!el.classList.contains('fw-reveal')) {
        el.classList.add('fw-reveal');
        el.style.transitionDelay = Math.min(i * 0.06, 0.3) + 's';
      }
    });
    /* Add card lift to interactive cards */
    document.querySelectorAll('.trip-card, .merch-card, .mc-card, .bl-card, .exp-card').forEach(function(el) {
      if (!el.classList.contains('fw-card-lift')) el.classList.add('fw-card-lift');
    });
  }

  /* ── 5. PARALLAX HERO ── */
  function initParallax() {
    var heroes = document.querySelectorAll(
      '.hero-section, .fw-hero, .exp-hero, .sp-hero, .pay-hero, [class*="hero"]'
    );
    if (!heroes.length) return;

    heroes.forEach(function(hero) {
      var img = hero.querySelector('img, .hero-bg, .sp-hero-img, .exp-hero-img, .fw-parallax-img');
      if (!img) return;

      var speed = parseFloat(hero.dataset.parallaxSpeed) || 0.35;

      function update() {
        var rect = hero.getBoundingClientRect();
        if (rect.bottom < 0 || rect.top > window.innerHeight) return;
        var progress = (rect.top / window.innerHeight);
        var offset   = progress * hero.offsetHeight * speed;
        img.style.transform = 'translateY(' + offset + 'px) scale(1.08)';
        img.style.willChange = 'transform';
      }

      window.addEventListener('scroll', update, { passive: true });
      update();
    });
  }

  /* ── 6. COUNTER ANIMATION ── */
  function animateCounter(el) {
    var target = parseFloat(el.dataset.count || el.textContent.replace(/[^\d.]/g, ''));
    var suffix = el.dataset.suffix || el.textContent.replace(/[\d.]/g, '');
    var prefix = el.dataset.prefix || '';
    var duration = 1200;
    var start = performance.now();
    var startVal = 0;

    function step(now) {
      var elapsed  = now - start;
      var progress = Math.min(elapsed / duration, 1);
      var ease     = 1 - Math.pow(1 - progress, 3); // cubic ease out
      var current  = Math.round(startVal + (target - startVal) * ease);
      el.textContent = prefix + current.toLocaleString('en-IN') + suffix;
      if (progress < 1) requestAnimationFrame(step);
    }
    requestAnimationFrame(step);
  }

  function initCounters() {
    var counters = document.querySelectorAll('[data-count], .fw-counter');
    if (!counters.length) return;

    var observer = new IntersectionObserver(function(entries) {
      entries.forEach(function(entry) {
        if (entry.isIntersecting) {
          animateCounter(entry.target);
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.5 });

    counters.forEach(function(el) { observer.observe(el); });
  }

  /* ── 7. HERO TEXT WORD-BY-WORD ANIMATION ── */
  function initHeroText() {
    var headings = document.querySelectorAll('.hero-title, .fw-hero-title, .pay-title, [class*="hero"] h1, [class*="hero"] h2');
    headings.forEach(function(el) {
      if (el.dataset.animated) return;
      el.dataset.animated = '1';
      var text  = el.textContent;
      var words = text.split(' ');
      el.innerHTML = words.map(function(word, i) {
        return '<span class="fw-hero-word" style="animation-delay:' + (i * 0.06 + 0.1) + 's">' + word + '&nbsp;</span>';
      }).join('');
    });
  }

  /* ── 8. PAGE TRANSITIONS ── */
  function initPageTransitions() {
    var overlay = document.getElementById('fw-page-overlay');
    if (!overlay) return;

    /* Entry animation */
    overlay.classList.add('fw-entering');
    setTimeout(function() { overlay.classList.remove('fw-entering'); }, 600);

    /* Intercept internal links */
    document.addEventListener('click', function(e) {
      var link = e.target.closest('a');
      if (!link) return;
      var href = link.getAttribute('href');
      if (!href) return;

      /* Skip: external, hash, download, admin, wp-admin, mailto, tel */
      if (href.indexOf('http') === 0 && href.indexOf(window.location.origin) !== 0) return;
      if (href.charAt(0) === '#') return;
      if (link.hasAttribute('download')) return;
      if (href.indexOf('wp-admin') > -1) return;
      if (href.indexOf('mailto:') === 0 || href.indexOf('tel:') === 0) return;
      if (link.getAttribute('target') === '_blank') return;

      e.preventDefault();
      overlay.classList.add('fw-leaving');

      setTimeout(function() {
        window.location.href = href;
      }, 480);
    });
  }

  /* ── 9. NAV TRANSPARENT → SOLID ON SCROLL ── */
  function initNavScroll() {
    var nav = document.querySelector('nav, header nav, .fw-nav, #main-nav');
    if (!nav) return;
    var scrolled = false;
    window.addEventListener('scroll', function() {
      var shouldScroll = window.scrollY > 60;
      if (shouldScroll !== scrolled) {
        scrolled = shouldScroll;
        nav.style.transition = 'background .3s ease, box-shadow .3s ease';
        if (scrolled) {
          nav.style.background = 'rgba(8,5,3,.98)';
          nav.style.backdropFilter = 'blur(12px)';
        } else {
          nav.style.background = '';
          nav.style.backdropFilter = '';
        }
      }
    }, { passive: true });
  }

  /* ── 10. SMOOTH SCROLL FOR ANCHOR LINKS ── */
  function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(function(link) {
      link.addEventListener('click', function(e) {
        var target = document.querySelector(link.getAttribute('href'));
        if (!target) return;
        e.preventDefault();
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      });
    });
  }

  /* ── 11. MAGNETIC BUTTONS ── */
  function initMagneticButtons() {
    if (window.matchMedia('(pointer: coarse)').matches) return;
    document.querySelectorAll('.fw-magnetic, .nav-cta, .book-btn, .cta-btn').forEach(function(btn) {
      btn.addEventListener('mousemove', function(e) {
        var rect   = btn.getBoundingClientRect();
        var cx     = rect.left + rect.width  / 2;
        var cy     = rect.top  + rect.height / 2;
        var dx     = (e.clientX - cx) * 0.25;
        var dy     = (e.clientY - cy) * 0.25;
        btn.style.transform = 'translate(' + dx + 'px,' + dy + 'px)';
      });
      btn.addEventListener('mouseleave', function() {
        btn.style.transform = '';
      });
    });
  }

  /* ── 12. TRIP CARD TILT EFFECT ── */
  function initCardTilt() {
    if (window.matchMedia('(pointer: coarse)').matches) return;
    document.querySelectorAll('.trip-card, .exp-card').forEach(function(card) {
      card.addEventListener('mousemove', function(e) {
        var rect = card.getBoundingClientRect();
        var x    = (e.clientX - rect.left) / rect.width  - 0.5;
        var y    = (e.clientY - rect.top)  / rect.height - 0.5;
        card.style.transform = 'perspective(800px) rotateY(' + (x * 6) + 'deg) rotateX(' + (-y * 4) + 'deg) translateY(-4px) scale(1.01)';
      });
      card.addEventListener('mouseleave', function() {
        card.style.transform = '';
        card.style.transition = 'transform 0.5s cubic-bezier(0.22,1,0.36,1)';
      });
    });
  }

  /* ── 13. STAT COUNTERS ON HOMEPAGE ── */
  function initStatCounters() {
    /* Find stat numbers that look like numbers */
    document.querySelectorAll('.stat-value, .stat-num, [data-stat]').forEach(function(el) {
      var raw = el.textContent.replace(/[^\d]/g, '');
      if (!raw || isNaN(raw)) return;
      var suffix = el.textContent.replace(/[\d]/g, '').trim();
      el.dataset.count   = raw;
      el.dataset.suffix  = suffix;
      el.classList.add('fw-counter');
    });
  }

  /* ── 14. MARQUEE CAROUSEL MOMENTUM ── */
  function initCarouselMomentum() {
    var track = document.getElementById('cTrack');
    if (!track) return;
    track.style.scrollBehavior = 'auto';
    var vel = 0, lastX = 0, isDragging = false;

    track.addEventListener('mousedown', function(e) {
      isDragging = true;
      lastX = e.clientX;
      vel = 0;
    });
    document.addEventListener('mousemove', function(e) {
      if (!isDragging) return;
      var delta = lastX - e.clientX;
      vel = delta;
      track.scrollLeft += delta;
      lastX = e.clientX;
    });
    document.addEventListener('mouseup', function() {
      if (!isDragging) return;
      isDragging = false;
      /* Apply momentum */
      (function coast() {
        if (Math.abs(vel) < 0.5) return;
        track.scrollLeft += vel;
        vel *= 0.92;
        requestAnimationFrame(coast);
      })();
    });
  }

  /* ── 15. SECTION DIVIDER LINES (draw on scroll) ── */
  function initDividers() {
    document.querySelectorAll('hr, .section-divider').forEach(function(el) {
      el.style.transform    = 'scaleX(0)';
      el.style.transformOrigin = 'left';
      el.style.transition   = 'transform 0.8s cubic-bezier(0.22,1,0.36,1)';

      var obs = new IntersectionObserver(function(entries) {
        if (entries[0].isIntersecting) {
          el.style.transform = 'scaleX(1)';
          obs.unobserve(el);
        }
      }, { threshold: 0.5 });
      obs.observe(el);
    });
  }

  /* ── INIT ALL ── */
  function init() {
    initScrollProgress();
    initCursorGlow();
    autoTagReveal();
    initScrollReveal();
    initParallax();
    initCounters();
    initHeroText();
    initPageTransitions();
    initNavScroll();
    initSmoothScroll();
    initMagneticButtons();
    initCardTilt();
    initStatCounters();
    initCarouselMomentum();
    initDividers();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }

})();
