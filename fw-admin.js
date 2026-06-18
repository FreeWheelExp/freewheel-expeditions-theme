/* FreeWheel Admin Dashboard JS */
/* ── Boot ── */
var _admToken = null;
var _admRest  = '/wp-json/freewheel/v1'; /* will be set properly on load */
var _allContent = {blogs:[], testis:[], albums:[], bookings:[], orders:[]};

window.addEventListener('load', function() {
  /* Check WP admin first */
  var isWPAdmin = window._admIsWPAdmin || false;

  /* Also check Supabase session */
  var session = null;
  try { session = JSON.parse(localStorage.getItem('fw_session')||'null'); } catch(e){}

  if (!isWPAdmin && (!session || !session.access_token)) {
    return; /* no session at all - gate stays */
  }

  if (session) _admToken = session.access_token;
  _admRest = (window.FW_AUTH && FW_AUTH.rest_url) ? FW_AUTH.rest_url : '/wp-json/freewheel/v1';

  /* Check session role immediately - no API needed */
  var adminRoles = ['admin', 'super_admin', 'moderator'];
  if (isWPAdmin || (session && adminRoles.indexOf(session.role) !== -1)) {
    document.getElementById('admGate').style.display = 'none';
    document.getElementById('admDash').style.display = 'block';
    loadAll();
    /* Still verify in background to refresh role if changed */
    fetch(_admRest + '/admin/check', { headers: {'Authorization':'Bearer '+_admToken} })
      .then(function(r){ return r.json(); })
      .then(function(d){
        console.log('[FW Admin] BG check:', JSON.stringify(d));
        if (!d.success || !d.is_admin) {
          /* Role was revoked - force logout */
          localStorage.removeItem('fw_session');
          window.location.href = '/login/';
        }
      }).catch(function(){});
    return;
  }

  /* Session exists but role not in session - verify via API */
  console.log('[FW Admin] Checking access via API...');
  fetch(_admRest + '/admin/check', { headers: {'Authorization':'Bearer '+_admToken} })
    .then(function(r){ return r.json(); })
    .then(function(d){
      console.log('[FW Admin] Check result:', JSON.stringify(d));
      if (d.success && d.is_admin) {
        /* Update session with role */
        try { session.role = d.role || 'admin'; localStorage.setItem('fw_session', JSON.stringify(session)); } catch(e){}
        document.getElementById('admGate').style.display = 'none';
        document.getElementById('admDash').style.display = 'block';
        loadAll();      } else {
        console.log('[FW Admin] Access denied. Reason:', d.reason || 'unknown');
      }
    })
    .catch(function(e){ console.log('[FW Admin] Fetch error:', e); });
});

function h() {
  var headers = {'Content-Type':'application/json'};
  if (_admToken) headers['Authorization'] = 'Bearer ' + _admToken;
  return headers;
}

function toast(msg, err) {
  var t = document.getElementById('admToast');
  t.textContent = msg; t.className = 'adm-toast show' + (err ? ' err' : '');
  setTimeout(function(){ t.className = 'adm-toast'; }, 3000);
}

function fmtDate(s) {
  if (!s) return '—';
  return new Date(s).toLocaleDateString('en-IN', {day:'numeric',month:'short',year:'numeric'});
}

function statusBadge(s) {
  var cls = {pending:'badge-pending',approved:'badge-approved',published:'badge-approved',rejected:'badge-rejected',
             inquiry:'badge-pending',contacted:'badge-pending',confirmed:'badge-approved',
             deposit_received:'badge-approved',fully_paid:'badge-approved',completed:'badge-approved',cancelled:'badge-rejected',
             dispatched:'badge-approved',delivered:'badge-approved',returned:'badge-rejected'};
  return '<span class="adm-badge '+(cls[s]||'badge-pending')+'">'+s.replace(/_/g,' ')+'</span>';
}

/* ── Load All ── */
function loadAll() {
  loadContent();
  loadBookings('');
  loadOrders();
  loadMembers();
  try {
    var _s = JSON.parse(localStorage.getItem('fw_session')||'null');
    var isStaff = _s && (_s.role === 'super_admin' || _s.role === 'moderator' || _s.role === 'admin');
    if (isStaff) {
      var tabEl = document.getElementById('tabStats');
      if (tabEl) { tabEl.style.display = 'block'; loadStats(); }
      var wlTabEl = document.getElementById('tabWaitlist');
      if (wlTabEl) { wlTabEl.style.display = 'block'; loadWaitlist(); }
    }
    if (_s && _s.role === 'super_admin') {
      var logTabEl = document.getElementById('tabActivityLog');
      if (logTabEl) logTabEl.style.display = 'block';
    }
  } catch(e) {}
}

/* ── CONTENT ── */
function loadContent() {
  fetch(_admRest + '/admin/pending-content', {headers: h()})
    .then(function(r){ return r.json(); })
    .then(function(d){
      if (!d.success && d.code === 'forbidden') {
        ['blogList','testiList','albumList'].forEach(function(id){
          document.getElementById(id).innerHTML = '<div class="adm-empty">Access denied.</div>';
        });
        return;
      }
      _allContent.blogs  = d.blogs  || [];
      _allContent.testis = d.testimonials || [];
      _allContent.albums = d.albums || [];
      var pending = _allContent.blogs.filter(function(b){return b.status==='pending';}).length +
                    _allContent.testis.filter(function(t){return t.status==='pending';}).length +
                    _allContent.blogs.filter(function(a){return a.status==='pending';}).length;
      document.getElementById('admStatPending').textContent = pending;
      document.getElementById('blogCount').textContent  = _allContent.blogs.filter(function(b){return b.status==='pending';}).length;
      document.getElementById('testiCount').textContent = _allContent.testis.filter(function(t){return t.status==='pending';}).length;
      document.getElementById('albumCount').textContent = _allContent.albums.filter(function(a){return a.status==='pending';}).length;
      renderBlogs(getFilteredContent(_allContent.blogs, 'pending'));
      renderTestis(getFilteredContent(_allContent.testis, 'pending'));
      renderAlbums(getFilteredContent(_allContent.albums, 'pending'));
    })
    .catch(function(e){
      ['blogList','testiList','albumList'].forEach(function(id){
        document.getElementById(id).innerHTML = '<div class="adm-empty">Error loading content. Please refresh.</div>';
      });
    });
}

function getFilteredContent(list, status) {
  var pending   = list.filter(function(i){ return i.status === 'pending'; });
  var nonPending= list.filter(function(i){ return i.status !== 'pending'; });
  if (status === 'pending') return pending;
  var statusItems = list.filter(function(i){ return i.status === status; }).slice(0, 3);
  return statusItems;
}

function filterContent(type, status, btn) {
  btn.closest('.adm-filter-row').querySelectorAll('.adm-filter-btn').forEach(function(b){ b.classList.remove('active'); });
  btn.classList.add('active');
  var list = type === 'blogs' ? _allContent.blogs : type === 'testis' ? _allContent.testis : _allContent.albums;
  var filtered = getFilteredContent(list, status);
  if (type==='blogs')  renderBlogs(filtered);
  if (type==='testis') renderTestis(filtered);
  if (type==='albums') renderAlbums(filtered);
}

function approveContent(type, id, action, noteId, btnEl) {
  var note = noteId ? (document.getElementById(noteId)||{}).value||'' : '';
  /* Visual feedback on the button */
  if (btnEl) { btnEl.disabled = true; btnEl.textContent = action === 'approve' ? 'Approving...' : 'Rejecting...'; }
  fetch(_admRest + '/admin/approve-content', {
    method:'POST', headers: h(),
    body: JSON.stringify({type:type, id:id, action:action, note:note})
  }).then(function(r){ return r.json().then(function(j){ return {ok:r.ok, body:j}; }); })
    .then(function(result){
      if (result.body && result.body.success) {
        var label = action==='approve' ? '✓ Approved' : '✓ Rejected';
        toast(label);
        /* Remove from local array immediately */
        var key = type==='blog' ? 'blogs' : type==='testimonial' ? 'testis' : 'albums';
        _allContent[key] = _allContent[key].filter(function(item){ return item.id !== id; });
        loadContent();
        setTimeout(function(){
          document.querySelectorAll('.adm-filter-row .adm-filter-btn').forEach(function(btn){
            if (btn.textContent.trim()==='Pending') btn.click();
          });
        }, 800);
      } else {
        var errMsg = (result.body && result.body.message) || 'Failed';
        toast(errMsg, true);
        if (btnEl) { btnEl.disabled = false; btnEl.textContent = 'Confirm Reject'; }
      }
    }).catch(function(e){ toast('Network error: ' + e.message, true); if (btnEl) { btnEl.disabled=false; btnEl.textContent='Confirm Reject'; } });
}

function renderBlogs(blogs) {
  var el = document.getElementById('blogList');
  if (!blogs.length) { el.innerHTML = '<div class="adm-empty">No blogs found.</div>'; return; }
  el.innerHTML = '';
  blogs.forEach(function(b) {
    var rId = 'br-' + b.id;
    var card = document.createElement('div');
    card.className = 'adm-card';

    var head = document.createElement('div');
    head.className = 'adm-card-head';

    var info = document.createElement('div');
    info.style.flex = '1';
    info.innerHTML =
      '<div style="font-size:15px;color:#fff;font-weight:500;margin-bottom:4px">' + b.title + '</div>' +
      '<div class="adm-meta">User: ' + b.user_id.slice(0,8) + '... &middot; ' + fmtDate(b.created_at) + '</div>' +
      (b.rejection_note ? '<div style="font-size:12px;color:#f87171;margin-top:4px">Rejected: ' + b.rejection_note + '</div>' : '');

    var actions = document.createElement('div');
    actions.style.cssText = 'display:flex;gap:8px;align-items:flex-start;flex-wrap:wrap';
    actions.innerHTML = statusBadge(b.status);

    if (b.status !== 'published') {
      var ab = document.createElement('button');
      ab.className = 'adm-btn btn-approve';
      ab.textContent = 'Approve';
      ab.onclick = (function(id, btn){ return function(){ approveContent('blog', id, 'approve', null, btn); }; })(b.id, ab);
      actions.appendChild(ab);
    }
    if (b.status !== 'rejected') {
      var rb = document.createElement('button');
      rb.className = 'adm-btn btn-reject';
      rb.textContent = 'Reject';
      rb.onclick = (function(rid){ return function(){ document.getElementById(rid).classList.toggle('open'); }; })(rId);
      actions.appendChild(rb);
    }

    head.appendChild(info);
    head.appendChild(actions);
    card.appendChild(head);

    var rejectRow = document.createElement('div');
    rejectRow.className = 'adm-reject-row';
    rejectRow.id = rId;
    var ni = document.createElement('input');
    ni.className = 'adm-input'; ni.id = 'rn-'+b.id; ni.placeholder = 'Reason (optional)'; ni.style.flex = '1';
    var cb = document.createElement('button');
    cb.className = 'adm-btn btn-reject'; cb.textContent = 'Confirm Reject';
    cb.onclick = (function(id, nid, btn){ return function(){ approveContent('blog', id, 'reject', nid, btn); }; })(b.id, 'rn-'+b.id, cb);
    rejectRow.appendChild(ni); rejectRow.appendChild(cb);
    card.appendChild(rejectRow);
    el.appendChild(card);
  });
}

function renderTestis(testis) {
  var el = document.getElementById('testiList');
  if (!testis.length) { el.innerHTML = '<div class="adm-empty">No testimonials found.</div>'; return; }
  var stars = function(n){ var s=''; for(var i=1;i<=5;i++) s+='<span style="color:'+(i<=n?'#f59e0b':'rgba(255,255,255,.2)')+'">&#9733;</span>'; return s; };
  el.innerHTML = '';
  testis.forEach(function(t) {
    var rId = 'tr-' + t.id;
    var card = document.createElement('div');
    card.className = 'adm-card';

    var head = document.createElement('div');
    head.className = 'adm-card-head';

    var info = document.createElement('div');
    info.style.flex = '1';
    info.innerHTML =
      '<div style="margin-bottom:4px">' + stars(t.rating) + ' <span style="font-size:12px;color:rgba(255,255,255,.4)">' + (t.trip_name||'') + '</span></div>' +
      '<div class="adm-text" style="margin-bottom:6px">' + t.body + '</div>' +
      '<div class="adm-meta">User: ' + t.user_id.slice(0,8) + '... &middot; ' + fmtDate(t.created_at) + '</div>';

    var actions = document.createElement('div');
    actions.style.cssText = 'display:flex;gap:8px;align-items:flex-start;flex-wrap:wrap';
    actions.innerHTML = statusBadge(t.status);

    if (t.status !== 'approved') {
      var ab = document.createElement('button');
      ab.className = 'adm-btn btn-approve'; ab.textContent = 'Approve';
      ab.onclick = (function(id, btn){ return function(){ approveContent('testimonial', id, 'approve', null, btn); }; })(t.id, ab);
      actions.appendChild(ab);
    }
    if (t.status !== 'rejected') {
      var rb = document.createElement('button');
      rb.className = 'adm-btn btn-reject'; rb.textContent = 'Reject';
      rb.onclick = (function(rid){ return function(){ document.getElementById(rid).classList.toggle('open'); }; })(rId);
      actions.appendChild(rb);
    }

    head.appendChild(info); head.appendChild(actions); card.appendChild(head);

    var rejectRow = document.createElement('div');
    rejectRow.className = 'adm-reject-row'; rejectRow.id = rId;
    var ni = document.createElement('input');
    ni.className = 'adm-input'; ni.id = 'rn-'+t.id; ni.placeholder = 'Reason (optional)'; ni.style.flex = '1';
    var cb = document.createElement('button');
    cb.className = 'adm-btn btn-reject'; cb.textContent = 'Confirm Reject';
    cb.onclick = (function(id, nid, btn){ return function(){ approveContent('testimonial', id, 'reject', nid, btn); }; })(t.id, 'rn-'+t.id, cb);
    rejectRow.appendChild(ni); rejectRow.appendChild(cb);
    card.appendChild(rejectRow);
    el.appendChild(card);
  });
}

function renderAlbums(albums) {
  var el = document.getElementById('albumList');
  if (!albums.length) { el.innerHTML = '<div class="adm-empty">No albums found.</div>'; return; }
  el.innerHTML = '';
  albums.forEach(function(a) {
    var photos = a.photos || [];
    var rId = 'ar-' + a.id;

    var card = document.createElement('div');
    card.className = 'adm-card';

    /* Header */
    var head = document.createElement('div');
    head.className = 'adm-card-head';

    var info = document.createElement('div');
    info.style.flex = '1';
    info.innerHTML =
      '<div style="font-size:15px;color:#fff;margin-bottom:4px">' + a.title +
      (a.trip_name ? ' <span style="font-size:12px;color:rgba(255,255,255,.4)">' + a.trip_name + '</span>' : '') +
      (a.is_public ? ' <span style="font-size:10px;background:rgba(42,122,110,.25);color:#2dd4bf;padding:2px 8px;border-radius:2px">PUBLIC</span>' : '') +
      '</div>' +
      '<div class="adm-meta">User: ' + a.user_id.slice(0,8) + '... &middot; ' + fmtDate(a.created_at) + ' &middot; ' + photos.length + ' photo(s)</div>';

    var actions = document.createElement('div');
    actions.style.cssText = 'display:flex;gap:8px;align-items:flex-start;flex-wrap:wrap';
    actions.innerHTML = statusBadge(a.status);

    if (a.status !== 'published') {
      var approveBtn = document.createElement('button');
      approveBtn.className = 'adm-btn btn-approve';
      approveBtn.textContent = 'Approve';
      approveBtn.onclick = (function(type, id, btn){ return function(){ approveContent(type, id, 'approve', null, btn); }; })('album', a.id, approveBtn);
      actions.appendChild(approveBtn);
    }
    if (a.status !== 'rejected') {
      var rejectBtn = document.createElement('button');
      rejectBtn.className = 'adm-btn btn-reject';
      rejectBtn.textContent = 'Reject';
      rejectBtn.onclick = (function(rid){ return function(){ document.getElementById(rid).classList.toggle('open'); }; })(rId);
      actions.appendChild(rejectBtn);
    }

    head.appendChild(info);
    head.appendChild(actions);
    card.appendChild(head);

    /* Photo strip */
    if (photos.length) {
      var strip = document.createElement('div');
      strip.style.cssText = 'display:flex;gap:6px;flex-wrap:wrap;padding-top:12px;margin-top:10px;border-top:1px solid rgba(255,255,255,.06)';
      photos.forEach(function(p) {
        if (!p.url) return;
        var img = document.createElement('img');
        img.src = p.url;
        img.style.cssText = 'width:80px;height:80px;object-fit:cover;border-radius:2px';
        img.loading = 'lazy';
        strip.appendChild(img);
      });
      card.appendChild(strip);
    }

    /* Reject row */
    var rejectRow = document.createElement('div');
    rejectRow.className = 'adm-reject-row';
    rejectRow.id = rId;
    var noteInput = document.createElement('input');
    noteInput.className = 'adm-input';
    noteInput.id = 'rn-' + a.id;
    noteInput.placeholder = 'Reason (optional)';
    noteInput.style.flex = '1';
    var confirmBtn = document.createElement('button');
    confirmBtn.className = 'adm-btn btn-reject';
    confirmBtn.textContent = 'Confirm Reject';
    confirmBtn.onclick = (function(type, id, noteId, btn){ return function(){ approveContent(type, id, 'reject', noteId, btn); }; })('album', a.id, 'rn-' + a.id, confirmBtn);
    rejectRow.appendChild(noteInput);
    rejectRow.appendChild(confirmBtn);
    card.appendChild(rejectRow);

    el.appendChild(card);
  });
}
/* ── BOOKINGS ── */
function loadBookings(status) {
  fetch(_admRest + '/admin/bookings?status='+encodeURIComponent(status), {headers:h()})
    .then(function(r){ return r.json(); })
    .then(function(d){
      _allContent.bookings = d.bookings || [];
      document.getElementById('admStatBookings').textContent = _allContent.bookings.length;
      renderBookings(_allContent.bookings);
    });
}

function filterBookings(status, btn) {
  btn.closest('.adm-filter-row').querySelectorAll('.adm-filter-btn').forEach(function(b){ b.classList.remove('active'); });
  btn.classList.add('active');
  loadBookings(status);
}

function renderBookings(bookings) {
  var el = document.getElementById('bookingList');
  if (!bookings.length) { el.innerHTML = '<div class="adm-empty">No bookings found.</div>'; return; }
  var sColors = {inquiry:'#e8a020',contacted:'#60a5fa',confirmed:'#a78bfa',deposit_received:'#34d399',fully_paid:'#4ade80',completed:'#4ade80',cancelled:'#f87171'};
  el.innerHTML = bookings.map(function(b) {
    return '<div class="adm-card">'+
      '<div class="adm-card-head">'+
        '<div style="flex:1">'+
          '<div style="font-size:15px;color:#fff;margin-bottom:4px">'+b.trip_title+' <span style="font-size:12px;color:rgba(255,255,255,.4)">'+b.trip_dates+'</span></div>'+
          '<div class="adm-meta">'+
            (b.contact_name||b.user_id||'Unlinked')+' &middot; '+(b.contact_phone||'—')+' &middot; '+fmtDate(b.created_at)+
            (b.amount_total ? ' &middot; &#8377;'+b.amount_total.toLocaleString('en-IN') : '')+
            (b.payment_ref ? ' &middot; UTR: '+b.payment_ref : '')+
          '</div>'+
          (b.notes ? '<div style="font-size:12px;color:rgba(255,255,255,.4);margin-top:4px">'+b.notes+'</div>' : '')+
          (b.user_id ? '' : '<div style="font-size:11px;color:#e8a020;margin-top:4px">&#9888; Not linked to member account</div>')+
        '</div>'+
        '<div style="display:flex;gap:8px;align-items:flex-start;flex-wrap:wrap">'+
          statusBadge(b.status)+
          '<button class="adm-btn btn-secondary" onclick="editBooking('+JSON.stringify(b)+')">Edit</button>'+
        '</div>'+
      '</div>'+
    '</div>';
  }).join('');
}

function openNewBooking() {
  var f = document.getElementById('newBookingForm');
  f.classList.toggle('open');
  document.getElementById('bkId').value = '';
  ['bkTripId','bkTripTitle','bkDates','bkContactName','bkContactPhone','bkContactEmail','bkWA','bkNotes','bkUserId','bkPayRef','bkPayMode'].forEach(function(id){ var el=document.getElementById(id); if(el)el.value=''; });
  ['bkSeats','bkTotal','bkPaid','bkDisc'].forEach(function(id){ var el=document.getElementById(id); if(el)el.value=''; });
  document.getElementById('bkStatus').value = 'inquiry';
}

function editBooking(b) {
  var f = document.getElementById('newBookingForm');
  f.classList.add('open');
  f.scrollIntoView({behavior:'smooth'});
  document.getElementById('bkId').value           = b.id||'';
  document.getElementById('bkTripId').value       = b.trip_id||'';
  document.getElementById('bkTripTitle').value    = b.trip_title||'';
  document.getElementById('bkDates').value        = b.trip_dates||'';
  document.getElementById('bkStatus').value       = b.status||'inquiry';
  document.getElementById('bkContactName').value  = b.contact_name||'';
  document.getElementById('bkContactPhone').value = b.contact_phone||'';
  document.getElementById('bkContactEmail').value = b.contact_email||'';
  document.getElementById('bkSeats').value        = b.seats||1;
  document.getElementById('bkTotal').value        = b.amount_total||'';
  document.getElementById('bkPaid').value         = b.amount_paid||'';
  document.getElementById('bkPayMode').value      = b.payment_mode||'';
  document.getElementById('bkPayRef').value       = b.payment_ref||'';
  document.getElementById('bkDisc').value         = b.discount_pct||'';
  document.getElementById('bkWA').value           = b.whatsapp_ref||'';
  document.getElementById('bkNotes').value        = b.notes||'';
  document.getElementById('bkUserId').value       = b.user_id||'';
}

async function saveBooking() {
  var payload = {
    id:            document.getElementById('bkId').value||null,
    trip_id:       document.getElementById('bkTripId').value,
    trip_title:    document.getElementById('bkTripTitle').value,
    trip_dates:    document.getElementById('bkDates').value,
    status:        document.getElementById('bkStatus').value,
    contact_name:  document.getElementById('bkContactName').value,
    contact_phone: document.getElementById('bkContactPhone').value,
    contact_email: document.getElementById('bkContactEmail').value,
    seats:         parseInt(document.getElementById('bkSeats').value)||1,
    amount_total:  parseInt(document.getElementById('bkTotal').value)||0,
    amount_paid:   parseInt(document.getElementById('bkPaid').value)||0,
    payment_mode:  document.getElementById('bkPayMode').value,
    payment_ref:   document.getElementById('bkPayRef').value,
    discount_pct:  parseInt(document.getElementById('bkDisc').value)||0,
    whatsapp_ref:  document.getElementById('bkWA').value,
    notes:         document.getElementById('bkNotes').value,
    user_id:       document.getElementById('bkUserId').value||null,
  };
  var msg = document.getElementById('bkMsg');
  msg.textContent = 'Saving...'; msg.style.color = 'rgba(255,255,255,.5)';
  try {
    var r = await fetch(_admRest+'/admin/save-booking', {method:'POST',headers:h(),body:JSON.stringify(payload)});
    var d = await r.json();
    if (d.success) { toast('Booking saved!'); document.getElementById('newBookingForm').classList.remove('open'); loadBookings(''); msg.textContent=''; }
    else { msg.textContent = d.message||'Failed'; msg.style.color='#f87171'; }
  } catch(e) { msg.textContent='Error'; msg.style.color='#f87171'; }
}

/* ── ORDERS ── */
function loadOrders() {
  fetch(_admRest+'/admin/orders', {headers:h()})
    .then(function(r){ return r.json(); })
    .then(function(d){
      _allContent.orders = d.orders||[];
      document.getElementById('admStatOrders').textContent = _allContent.orders.length;
      renderOrders(_allContent.orders);
    });
}

function filterOrders(status, btn) {
  btn.closest('.adm-filter-row').querySelectorAll('.adm-filter-btn').forEach(function(b){ b.classList.remove('active'); });
  btn.classList.add('active');
  var list = status==='all' ? _allContent.orders : _allContent.orders.filter(function(o){ return o.status===status; });
  renderOrders(list);
}

function renderOrders(orders) {
  var el = document.getElementById('orderList');
  if (!orders.length) { el.innerHTML = '<div class="adm-empty">No orders found.</div>'; return; }
  el.innerHTML = orders.map(function(o) {
    var items = Array.isArray(o.items) ? o.items.map(function(i){ return i.name+(i.size?' ('+i.size+')':'')+(i.qty>1?' x'+i.qty:''); }).join(', ') : 'Order';
    return '<div class="adm-card">'+
      '<div class="adm-card-head">'+
        '<div style="flex:1">'+
          '<div style="font-size:15px;color:#fff;margin-bottom:4px">'+items+'</div>'+
          '<div class="adm-meta">'+
            (o.contact_name||o.user_id||'Guest')+' &middot; '+fmtDate(o.created_at)+
            (o.amount_final ? ' &middot; &#8377;'+o.amount_final.toLocaleString('en-IN') : o.amount_total ? ' &middot; &#8377;'+o.amount_total.toLocaleString('en-IN') : '')+
            (o.tracking_number ? ' &middot; Track: '+o.tracking_number : '')+
            (o.delivery_address ? ' &middot; '+o.delivery_address : '')+
          '</div>'+
        '</div>'+
        '<div style="display:flex;gap:8px;flex-wrap:wrap;align-items:flex-start">'+
          statusBadge(o.status)+
          '<select class="adm-select" style="width:auto;font-size:11px" onchange="quickUpdateOrder(\''+o.id+'\',this.value)">'+
            ['inquiry','confirmed','payment_received','dispatched','delivered','cancelled','returned'].map(function(s){
              return '<option value="'+s+'"'+(o.status===s?' selected':'')+'>'+s.replace(/_/g,' ')+'</option>';
            }).join('')+
          '</select>'+
        '</div>'+
      '</div>'+
    '</div>';
  }).join('');
}

function quickUpdateOrder(id, status) {
  fetch(_admRest+'/admin/update-order', {method:'POST',headers:h(),body:JSON.stringify({id:id,status:status})})
    .then(function(r){ return r.json(); })
    .then(function(d){ if(d.success) toast('Order updated to: '+status); else toast('Failed',true); });
}

/* ── USERS ── */
function loadUsers() {
  fetch(_admRest+'/admin/users', {headers:h()})
    .then(function(r){ return r.json(); })
    .then(function(d){
      document.getElementById('admStatUsers').textContent = (d.users||[]).length;
      renderUsers(d.users||[]);
    });
}

function searchUsers() {
  var q = document.getElementById('userSearch').value.trim();
  fetch(_admRest+'/admin/users?q='+encodeURIComponent(q), {headers:h()})
    .then(function(r){ return r.json(); })
    .then(function(d){ renderUsers(d.users||[]); });
}

function renderUsers(users) {
  var el = document.getElementById('userList');
  if (!users.length) { el.innerHTML = '<div class="adm-empty">No members found.</div>'; return; }
  el.innerHTML = users.map(function(u) {
    var initials = ((u.first_name||'?')[0]+(u.last_name||'')[0]||'').toUpperCase();
    return '<div class="adm-user-row">'+
      '<div class="adm-user-avatar">'+initials+'</div>'+
      '<div style="flex:1">'+
        '<div style="color:#fff;font-size:14px">'+u.first_name+' '+(u.last_name||'')+'</div>'+
        '<div class="adm-meta">'+u.email+' &middot; '+(u.phone||'—')+' &middot; '+(u.city||'—')+'</div>'+
        '<div style="font-size:11px;color:rgba(255,255,255,.3);margin-top:2px">'+u.trips_completed+' trips &middot; Member since '+fmtDate(u.created_at)+'</div>'+
      '</div>'+
      '<div style="display:flex;gap:8px;align-items:center">'+
        (u.role==='admin' ? '<span class="adm-badge badge-approved">Admin</span>' : '')+
        '<button class="adm-btn btn-secondary" onclick="document.getElementById(\'adjUserId\').value=\''+u.id+'\';document.getElementById(\'adjUserId\').scrollIntoView({behavior:\'smooth\'})">Adjust Credits</button>'+
      '</div>'+
    '</div>';
  }).join('');
}

async function adjustCredits() {
  var userId = document.getElementById('adjUserId').value.trim();
  var amount = parseInt(document.getElementById('adjAmount').value)||0;
  var note   = document.getElementById('adjNote').value.trim()||'Admin adjustment';
  var msg    = document.getElementById('adjMsg');
  if (!userId || !amount) { msg.textContent='User ID and amount required.'; msg.style.color='#f87171'; return; }
  try {
    var r = await fetch(_admRest+'/admin/adjust-credits', {method:'POST',headers:h(),body:JSON.stringify({user_id:userId,amount:amount,note:note})});
    var d = await r.json();
    if (d.success) { msg.textContent='Done! New balance: '+d.new_balance+' credits'; msg.style.color='#4ade80'; document.getElementById('adjAmount').value=''; document.getElementById('adjNote').value=''; }
    else { msg.textContent=d.message||'Failed'; msg.style.color='#f87171'; }
  } catch(e) { msg.textContent='Error'; msg.style.color='#f87171'; }
}

/* ── Tab switching ── */
function admTab(id, btn) {
  document.querySelectorAll('.adm-tab').forEach(function(t){ t.classList.remove('active'); });
  document.querySelectorAll('.adm-panel').forEach(function(p){ p.classList.remove('active'); });
  btn.classList.add('active');
  document.getElementById('panel-'+id).classList.add('active');
  if (id === 'create') adminCreateTab('blog');
  if (id === 'activitylog') loadActivityLog();
  if (id === 'waitlist') loadWaitlist();
}

function loadActivityLog() {
  var el = document.getElementById('activityLogList');
  el.innerHTML = '<div class="adm-spinner">Loading...</div>';
  fetch(_admRest + '/admin/activity-log', { headers: h() })
    .then(function(r){ return r.json(); })
    .then(function(d){
      if (!d.success || !d.logs || !d.logs.length) { el.innerHTML = '<div class="adm-empty">No activity recorded yet.</div>'; return; }
      var actionLabel = {
        role_change: 'Changed role', block_member: 'Blocked', unblock_member: 'Unblocked',
        remove_member: 'Removed member', approve_content: 'Approved', reject_content: 'Rejected',
        credit_adjustment: 'Adjusted credits'
      };
      var actionColor = {
        role_change: '#e8a020', block_member: '#f87171', unblock_member: '#4ade80',
        remove_member: '#f87171', approve_content: '#4ade80', reject_content: '#f87171',
        credit_adjustment: '#7c3aed'
      };
      el.innerHTML = d.logs.map(function(log) {
        var label = actionLabel[log.action] || log.action;
        var color = actionColor[log.action] || 'rgba(255,255,255,.6)';
        return '<div style="display:flex;align-items:flex-start;gap:12px;padding:11px 14px;background:rgba(255,255,255,.025);border:1px solid rgba(255,255,255,.06);border-radius:2px;margin-bottom:6px">' +
          '<span style="font-size:10px;letter-spacing:1px;text-transform:uppercase;color:'+color+';background:'+color+'18;padding:3px 8px;border-radius:2px;white-space:nowrap;flex-shrink:0">'+label+'</span>' +
          '<div style="flex:1;min-width:0">' +
            '<div style="font-size:12px;color:rgba(255,255,255,.7)">'+(log.actor_email||'unknown')+' <span style="color:rgba(255,255,255,.3)">('+(log.actor_role||'?')+')</span>' +
            (log.target_type ? ' &middot; <span style="color:rgba(255,255,255,.4)">'+log.target_type+(log.target_id ? ' #'+String(log.target_id).substring(0,8) : '')+'</span>' : '') + '</div>' +
            (log.details ? '<div style="font-size:11px;color:rgba(255,255,255,.35);margin-top:3px">'+log.details+'</div>' : '') +
          '</div>' +
          '<span style="font-size:10px;color:rgba(255,255,255,.25);white-space:nowrap;flex-shrink:0">'+fmtDate(log.created_at)+'</span>' +
        '</div>';
      }).join('');
    })
    .catch(function(){ el.innerHTML = '<div class="adm-empty">Failed to load.</div>'; });
}

function toggleAdmMenu() {
  var d = document.getElementById('admDropdown');
  d.style.display = d.style.display === 'none' ? 'block' : 'none';
}
document.addEventListener('click', function(e) {
  if (!e.target.closest('#admProfileBtn') && !e.target.closest('#admDropdown')) {
    var d = document.getElementById('admDropdown');
    if (d) d.style.display = 'none';
  }
});
function admLogout() {
  localStorage.removeItem('fw_session');
  window.location.href = (window.FW_AUTH ? FW_AUTH.login_url : '/login/');
}
(function(){
  try {
    var s = JSON.parse(localStorage.getItem('fw_session')||'null');
    if (s) {
      var n = s.first_name || 'Admin';
      var wel = document.getElementById('admWelcome');
      if (wel) wel.textContent = 'Welcome back, ' + n;
      var wrap = document.getElementById('admAvatarWrap');
      if (wrap) {
        if (s.avatar_url) {
          wrap.innerHTML = '<img src="'+s.avatar_url+'" style="width:100%;height:100%;object-fit:cover">';
        } else {
          var init = document.getElementById('admAvatarInitial');
          if (init) init.textContent = n[0].toUpperCase();
        }
      }
      /* Set role label */
      var roleLabel = document.getElementById('admRoleLabel');
      if (roleLabel) {
        var rl = s.role === 'super_admin' ? 'Super Admin'
               : s.role === 'moderator'   ? 'Moderator'
               : 'Admin';
        roleLabel.textContent = rl;
      }
    }
  } catch(e){}
})();
/* ---- Members management ---- */
var _allMembers = [];
function loadMembers() {
  fetch(_admRest + '/admin/members', {headers: h()})
    .then(function(r){ return r.json(); })
    .then(function(d) {
      _allMembers = d.members || [];
      var blocked = _allMembers.filter(function(m){ return m.is_suspended; }).length;
      var total = _allMembers.length;
      var statUsers = document.getElementById('admStatUsers');
      var statBlocked = document.getElementById('admStatBlocked');
      if(statUsers) statUsers.textContent = total;
      if(statBlocked) statBlocked.textContent = blocked;
      renderMembers(_allMembers);
    }).catch(function(){ document.getElementById('membersList').innerHTML = '<div class="adm-empty">Error loading members.</div>'; });
}
function renderMembers(members) {
  var el = document.getElementById('membersList');
  if (!members.length) { el.innerHTML = '<div class="adm-empty">No members found.</div>'; return; }
  var session = null;
  try { session = JSON.parse(localStorage.getItem('fw_session')||'null'); } catch(e){}
  var isSuperAdmin = !!(session && session.role === 'super_admin');

  el.innerHTML = members.map(function(m) {
    var initL = ((m.first_name||'?')[0]).toUpperCase();
    var av = m.avatar_url ? '<img src="'+m.avatar_url+'" style="width:38px;height:38px;border-radius:50%;object-fit:cover;border:2px solid rgba(193,68,14,.3);flex-shrink:0">' : '<div style="width:38px;height:38px;border-radius:50%;background:rgba(193,68,14,.2);display:flex;align-items:center;justify-content:center;font-family:var(--headline);font-size:16px;color:var(--rust);flex-shrink:0">'+initL+'</div>';
    var sb = m.is_suspended ? '<span class="adm-badge badge-rejected">Blocked</span>' : '<span class="adm-badge badge-approved">Active</span>';
    var rb = '<span style="font-size:10px;padding:2px 8px;border-radius:2px;background:rgba(255,255,255,.06);color:rgba(255,255,255,.5);border:1px solid rgba(255,255,255,.1)">'+m.role+'</span>';

    var isStaff = m.role === 'moderator' || m.role === 'super_admin';
    /* Moderators cannot act on staff accounts at all — render as read-only */
    if ( !isSuperAdmin && isStaff ) {
      return '<div class="adm-card" style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;opacity:.55">'+av+'<div style="flex:1;min-width:160px"><div style="font-size:14px;color:#fff">'+(m.first_name||'')+' '+(m.last_name||'')+'</div><div style="font-size:11px;color:rgba(255,255,255,.4);margin-top:2px">'+m.email+'</div></div><div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap">'+sb+rb+'<span style="font-size:10px;color:rgba(255,255,255,.3)">Staff account — Super Admin only</span></div></div>';
    }

    var bb = m.is_suspended
      ? '<button class="adm-btn btn-approve" data-uid="'+m.id+'" data-block="0" onclick="toggleBlock(this.dataset.uid,false)">Unblock</button>'
      : '<button class="adm-btn btn-reject" data-uid="'+m.id+'" data-block="1" onclick="toggleBlock(this.dataset.uid,true)">Block</button>';

    /* Role dropdown — Super Admin only */
    var rs = isSuperAdmin
      ? '<select data-uid="'+m.id+'" onchange="changeMemberRole(this.dataset.uid,this.value)" style="padding:5px 8px;background:#0f0d0b;border:1px solid rgba(255,255,255,.12);color:#fff;font-size:11px;border-radius:2px;cursor:pointer"><option value="">Change role...</option><option value="member">Member</option><option value="moderator">Moderator</option><option value="super_admin">Super Admin</option></select>'
      : '';

    var removeBtn = '<button data-uid="'+m.id+'" data-name="'+((m.first_name||'')+' '+(m.last_name||'')).trim().replace(/"/g,'')+'" onclick="removeMember(this.dataset.uid,this.dataset.name)" style="padding:6px 12px;background:rgba(248,113,113,.08);border:1px solid rgba(248,113,113,.25);color:#f87171;font-size:11px;cursor:pointer;border-radius:2px">Remove</button>';

    return '<div class="adm-card" style="display:flex;align-items:center;gap:12px;flex-wrap:wrap">'+av+'<div style="flex:1;min-width:160px"><div style="font-size:14px;color:#fff">'+(m.first_name||'')+' '+(m.last_name||'')+'</div><div style="font-size:11px;color:rgba(255,255,255,.4);margin-top:2px">'+m.email+'</div><div style="font-size:11px;color:rgba(255,255,255,.3)">'+(m.phone||'')+(m.city?' - '+m.city:'')+'</div></div><div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap">'+sb+rb+rs+bb+removeBtn+'</div></div>';
  }).join('');
}
function filterMembers(q) {
  if (!q) { renderMembers(_allMembers); return; }
  q = q.toLowerCase();
  renderMembers(_allMembers.filter(function(m){ return (m.email||'').toLowerCase().includes(q)||(m.first_name||'').toLowerCase().includes(q)||(m.last_name||'').toLowerCase().includes(q)||(m.phone||'').toLowerCase().includes(q); }));
}
function filterMembersByStatus(s) {
  if (s==='all') { renderMembers(_allMembers); return; }
  renderMembers(_allMembers.filter(function(m){ return s==='blocked'?m.is_suspended:!m.is_suspended; }));
}
async function changeMemberRole(uid, role) {
  if (!role||!confirm('Change role to "'+role+'"?')) return;
  var r=await fetch(_admRest+'/admin/update-member',{method:'POST',headers:Object.assign({'Content-Type':'application/json'},h()),body:JSON.stringify({user_id:uid,role:role})});
  var d=await r.json(); if(d.success) loadMembers(); else alert(d.message||'Failed.');
}
async function toggleBlock(uid, block) {
  if (!confirm('Are you sure?')) return;
  var r=await fetch(_admRest+'/admin/update-member',{method:'POST',headers:Object.assign({'Content-Type':'application/json'},h()),body:JSON.stringify({user_id:uid,is_suspended:block})});
  var d=await r.json(); if(d.success) loadMembers(); else alert(d.message||'Failed.');
}
async function removeMember(uid, name) {
  if (!confirm('Permanently remove '+(name||'this member')+'? This cannot be undone.')) return;
  var r=await fetch(_admRest+'/admin/remove-member',{method:'POST',headers:Object.assign({'Content-Type':'application/json'},h()),body:JSON.stringify({user_id:uid})});
  var d=await r.json(); if(d.success) { toast('Member removed.'); loadMembers(); } else alert(d.message||'Failed.');
}
/* ---- Site stats ---- */
function loadStats() {
  fetch(_admRest+'/admin/site-stats',{headers:h()}).then(function(r){return r.json();}).then(function(d){
    if(!d.success) return; var s=d.stats;
    function ss(id,v){var el=document.getElementById(id);if(el)el.textContent=v||0;}
    ss('statTotalMembers',s.total_members); ss('statActiveMembers',s.active_members); ss('statBlockedMembers',s.blocked_members);
    ss('statTotalBookings',s.total_bookings); ss('statTotalOrders',s.total_orders);
    ss('statTotalBlogs',s.published_blogs); ss('statTotalAlbums',s.published_albums); ss('statTotalTestis',s.approved_testimonials);
    var revEl = document.getElementById('statRevenue'); if (revEl) revEl.textContent = '₹' + (s.total_revenue||0).toLocaleString('en-IN');
    ss('statNewMembers30d', s.new_members_30d);
    ss('statTotalReferred', s.total_referred);
    ss('statReferralsCredited', s.referrals_credited);
    ss('statWaitlistWaiting', s.waitlist_waiting);
    var pendingTotal = (s.pending_blogs||0) + (s.pending_albums||0) + (s.pending_testimonials||0);
    ss('statPendingContent', pendingTotal);
    var merch=s.merchandise||[];
    document.getElementById('statMerchandise').innerHTML=merch.length?'<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:12px">'+merch.map(function(m){return '<div class="adm-stat-box"><div class="adm-stat-n" style="font-size:26px">'+m.count+'</div><div class="adm-stat-l">'+m.product_name+'</div></div>';}).join('')+'</div>':'<div class="adm-empty">No orders yet.</div>';
    var exps=s.expeditions||[];
    document.getElementById('statExpeditions').innerHTML=exps.length?'<div style="display:flex;flex-direction:column;gap:8px">'+exps.map(function(e){return '<div class="adm-card" style="display:flex;justify-content:space-between;align-items:center"><span style="color:rgba(255,255,255,.8);font-size:13px">'+e.trip_name+'</span><span style="font-family:var(--headline);font-size:22px;color:var(--amber)">'+e.count+'</span></div>';}).join('')+'</div>':'<div class="adm-empty">No bookings yet.</div>';
    var roles=s.roles||[];
    document.getElementById('statRoles').innerHTML=roles.map(function(r){return '<div class="adm-stat-box" style="min-width:120px"><div class="adm-stat-n" style="font-size:26px">'+r.count+'</div><div class="adm-stat-l">'+r.role+'</div></div>';}).join('');
  }).catch(function(){});
}

/* ── Waitlist ── */
function loadWaitlist() {
  var el = document.getElementById('waitlistList');
  if (!el) return;
  el.innerHTML = '<div class="adm-spinner">Loading...</div>';
  fetch(_admRest + '/admin/waitlist', { headers: h() })
    .then(function(r){ return r.json(); })
    .then(function(d){
      if (!d.success || !d.waitlist || !d.waitlist.length) { el.innerHTML = '<div class="adm-empty">No one on the waitlist right now.</div>'; return; }
      /* Group by expedition */
      var groups = {};
      d.waitlist.forEach(function(w) {
        var key = w.expedition_title || 'Unknown trip';
        if (!groups[key]) groups[key] = [];
        groups[key].push(w);
      });
      var html = '';
      Object.keys(groups).forEach(function(tripName) {
        var entries = groups[tripName];
        html += '<div style="margin-bottom:24px"><div style="font-family:var(--headline);font-size:16px;color:#fff;letter-spacing:.5px;margin-bottom:10px">' + tripName + ' <span style="font-size:12px;color:rgba(255,255,255,.35);font-family:var(--body)">(' + entries.length + ' waiting)</span></div>';
        entries.forEach(function(w) {
          var statusColor = w.status === 'notified' ? '#e8a020' : '#4ade80';
          var statusLabel = w.status === 'notified' ? 'Notified' : 'Waiting';
          html += '<div class="adm-card" style="display:flex;align-items:center;gap:14px;flex-wrap:wrap;margin-bottom:6px">' +
            '<div style="flex:1;min-width:160px"><div style="font-size:13px;color:#fff">' + w.member_name + '</div><div style="font-size:11px;color:rgba(255,255,255,.4);margin-top:2px">' + (w.member_email||'') + (w.member_phone?' · '+w.member_phone:'') + '</div></div>' +
            '<div style="font-size:12px;color:rgba(255,255,255,.5)">' + w.seats_wanted + ' seat(s)</div>' +
            '<span class="adm-badge" style="background:'+statusColor+'18;color:'+statusColor+';border:1px solid '+statusColor+'40">' + statusLabel + '</span>' +
            '<div style="display:flex;gap:6px">' +
              (w.status === 'waiting' ? '<button class="adm-btn btn-approve" data-id="'+w.id+'" onclick="waitlistAction(this.dataset.id,\\'notify\\')">Notify</button>' : '') +
              '<button class="adm-btn btn-approve" data-id="'+w.id+'" onclick="waitlistAction(this.dataset.id,\\'convert\\')">Mark Booked</button>' +
              '<button class="adm-btn btn-reject" data-id="'+w.id+'" onclick="waitlistAction(this.dataset.id,\\'remove\\')">Remove</button>' +
            '</div>' +
          '</div>';
        });
        html += '</div>';
      });
      el.innerHTML = html;
    })
    .catch(function(){ el.innerHTML = '<div class="adm-empty">Failed to load.</div>'; });
}

function waitlistAction(id, action) {
  var msgs = { notify: 'Send a "slot opened" email to this person?', convert: 'Mark this entry as booked and remove from waitlist?', remove: 'Remove this person from the waitlist?' };
  if (!confirm(msgs[action] || 'Are you sure?')) return;
  fetch(_admRest + '/admin/waitlist-action', { method: 'POST', headers: Object.assign({'Content-Type':'application/json'}, h()), body: JSON.stringify({ id: id, action: action }) })
    .then(function(r){ return r.json(); })
    .then(function(d){ if (d.success) { toast('Done.'); loadWaitlist(); } else alert(d.message || 'Failed.'); })
    .catch(function(){ alert('Network error.'); });
}

/* ── Admin Create Content ── */

var _adminCreateTab = 'blog';

function adminCreateTab(tab) {
  _adminCreateTab = tab;
  var isBlog = tab === 'blog';
  document.getElementById('createBlogSection').style.display  = isBlog ? '' : 'none';
  document.getElementById('createAlbumSection').style.display = isBlog ? 'none' : '';
  var bBtn = document.getElementById('createTabBlog');
  var aBtn = document.getElementById('createTabAlbum');
  bBtn.style.background  = isBlog ? 'var(--rust)' : 'rgba(255,255,255,.08)';
  bBtn.style.border      = isBlog ? 'none' : '1px solid rgba(255,255,255,.12)';
  bBtn.style.color       = isBlog ? '#fff' : 'rgba(255,255,255,.6)';
  aBtn.style.background  = isBlog ? 'rgba(255,255,255,.08)' : 'var(--rust)';
  aBtn.style.border      = isBlog ? '1px solid rgba(255,255,255,.12)' : 'none';
  aBtn.style.color       = isBlog ? 'rgba(255,255,255,.6)' : '#fff';
  if (tab === 'blog') adminLoadBlogs();
  else adminLoadAlbums();
}

/* ---- Blog ---- */
function adminLoadBlogs() {
  var el = document.getElementById('adminBlogList');
  el.innerHTML = '<div class="adm-spinner">Loading...</div>';
  fetch(_admRest + '/admin/get-blogs', { headers: { 'Authorization': 'Bearer ' + _admToken } })
    .then(function(r){ return r.json(); })
    .then(function(d){
      if (!d.success || !d.blogs || !d.blogs.length) { el.innerHTML = '<div class="adm-empty">No blogs yet.</div>'; return; }
      el.innerHTML = '';
      d.blogs.forEach(function(b) {
        var row = document.createElement('div');
        row.style.cssText = 'display:flex;align-items:center;justify-content:space-between;padding:12px 16px;background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.07);border-radius:2px;margin-bottom:8px;gap:12px';
        row.innerHTML = '<div style="flex:1;min-width:0"><div style="font-size:14px;color:#fff;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">' + (b.title || 'Untitled') + '</div>'
          + '<div style="font-size:11px;color:rgba(255,255,255,.35);margin-top:2px">' + fmtDate(b.created_at) + ' ' + statusBadge(b.status) + '</div></div>'
          + '<button style="padding:6px 14px;font-size:11px;letter-spacing:1px;text-transform:uppercase;font-family:var(--body);cursor:pointer;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.12);color:rgba(255,255,255,.6);border-radius:2px">Edit</button>';
        row.querySelector('button').addEventListener('click', (function(blog){ return function(){ adminEditBlog(blog); }; })(b));
        el.appendChild(row);
      });
    })
    .catch(function(e){ console.error('[FW Admin] get-blogs:', e); el.innerHTML = '<div class="adm-empty">Failed to load.</div>'; });
}

function adminShowBlogEditor() {
  document.getElementById('adminBlogEditId').value = '';
  document.getElementById('adminBlogTitle').value = '';
  document.getElementById('adminBlogBody').innerHTML = '';
  document.getElementById('adminBlogCoverUrl').value = '';
  document.getElementById('adminBlogCoverName').textContent = '';
  document.getElementById('adminBlogStatus').value = 'published';
  document.getElementById('adminBlogMsg').textContent = '';
  document.getElementById('adminBlogEditor').style.display = 'block';
  document.getElementById('adminBlogEditor').scrollIntoView({ behavior: 'smooth', block: 'start' });
}

function adminEditBlog(b) {
  document.getElementById('adminBlogEditId').value = b.id;
  document.getElementById('adminBlogTitle').value = b.title || '';
  document.getElementById('adminBlogBody').innerHTML = b.body || '';
  document.getElementById('adminBlogCoverUrl').value = b.cover_image || '';
  document.getElementById('adminBlogCoverName').textContent = b.cover_image ? 'Cover set' : '';
  document.getElementById('adminBlogStatus').value = b.status || 'published';
  document.getElementById('adminBlogMsg').textContent = '';
  document.getElementById('adminBlogEditor').style.display = 'block';
  document.getElementById('adminBlogEditor').scrollIntoView({ behavior: 'smooth', block: 'start' });
}

function adminInsertInlinePhoto(input) {
  if (!input.files[0]) return;
  var fd = new FormData();
  fd.append('photo', input.files[0]);
  fetch(_admRest + '/admin/upload-blog-cover', { method: 'POST', headers: { 'Authorization': 'Bearer ' + _admToken }, body: fd })
    .then(function(r){ return r.json(); })
    .then(function(d){
      if (d.success) {
        document.getElementById('adminBlogBody').focus();
        document.execCommand('insertHTML', false, '<img src="' + d.url + '" style="max-width:100%">');
      }
    });
  input.value = '';
}

function adminUploadBlogCover(input) {
  if (!input.files[0]) return;
  var fd = new FormData();
  fd.append('photo', input.files[0]);
  fetch(_admRest + '/admin/upload-blog-cover', { method: 'POST', headers: { 'Authorization': 'Bearer ' + _admToken }, body: fd })
    .then(function(r){ return r.json(); })
    .then(function(d){
      if (d.success) {
        document.getElementById('adminBlogCoverUrl').value = d.url;
        document.getElementById('adminBlogCoverName').textContent = '✓ Cover uploaded';
        document.getElementById('adminBlogCoverName').style.color = '#4ade80';
      }
    });
}

function adminSaveBlog() {
  var title  = document.getElementById('adminBlogTitle').value.trim();
  var body   = document.getElementById('adminBlogBody').innerHTML.trim();
  var cover  = document.getElementById('adminBlogCoverUrl').value;
  var status = document.getElementById('adminBlogStatus').value;
  var id     = document.getElementById('adminBlogEditId').value;
  var msg    = document.getElementById('adminBlogMsg');
  if (!title || !body) { msg.textContent = 'Title and body are required.'; msg.style.color = '#f87171'; return; }
  msg.textContent = 'Saving...'; msg.style.color = 'rgba(255,255,255,.4)';
  fetch(_admRest + '/admin/save-blog', {
    method: 'POST',
    headers: { 'Authorization': 'Bearer ' + _admToken, 'Content-Type': 'application/json' },
    body: JSON.stringify({ id: id, title: title, body: body, cover_image: cover, status: status })
  })
    .then(function(r){ return r.json(); })
    .then(function(d){
      if (d.success) {
        msg.textContent = 'Blog saved!'; msg.style.color = '#4ade80';
        setTimeout(function(){ document.getElementById('adminBlogEditor').style.display = 'none'; adminLoadBlogs(); }, 1200);
      } else { msg.textContent = d.message || 'Error saving blog.'; msg.style.color = '#f87171'; }
    })
    .catch(function(){ msg.textContent = 'Network error.'; msg.style.color = '#f87171'; });
}

/* ---- Album ---- */
/* Compress image to max 1200px wide, quality 0.82, returns Blob */
/* Compress image client-side before upload */
function adminCompressImage(file, maxPx, quality) {
  return new Promise(function(resolve) {
    var url = URL.createObjectURL(file);
    var img = new Image();
    img.onload = function() {
      URL.revokeObjectURL(url);
      var w = img.naturalWidth, h = img.naturalHeight;
      var scale = Math.min(1, maxPx / Math.max(w, h));
      w = Math.round(w * scale); h = Math.round(h * scale);
      var canvas = document.createElement('canvas');
      canvas.width = w; canvas.height = h;
      canvas.getContext('2d').drawImage(img, 0, 0, w, h);
      canvas.toBlob(function(blob) { resolve(blob || file); }, 'image/jpeg', quality);
    };
    img.onerror = function() { URL.revokeObjectURL(url); resolve(file); };
    img.src = url;
  });
}

/* Show upload panel with preview + Save button */
function adminDoUpload(aid, albumTitle) {
  /* Remove any existing panel */
  var existing = document.getElementById('fw-upload-panel');
  if (existing) existing.remove();

  var panel = document.createElement('div');
  panel.id = 'fw-upload-panel';
  panel.style.cssText = 'position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,.92);display:flex;align-items:center;justify-content:center;padding:20px;backdrop-filter:blur(6px)';

  panel.innerHTML =
    '<div style="background:#0f0d0b;border:1px solid rgba(255,255,255,.1);border-radius:4px;width:100%;max-width:640px;padding:28px">' +
      '<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px">' +
        '<div>' +
          '<div style="font-family:var(--headline);font-size:18px;color:#fff;letter-spacing:1px">Upload Photos</div>' +
          '<div style="font-size:11px;color:rgba(255,255,255,.35);margin-top:2px">' + albumTitle + ' · max 6 photos · auto-compressed</div>' +
        '</div>' +
        '<button id="fw-panel-close" style="background:none;border:none;color:rgba(255,255,255,.4);font-size:22px;cursor:pointer;padding:0;line-height:1">&times;</button>' +
      '</div>' +
      '<label id="fw-drop-zone" style="display:flex;flex-direction:column;align-items:center;justify-content:center;gap:10px;border:2px dashed rgba(255,255,255,.15);border-radius:4px;padding:32px 20px;cursor:pointer;transition:border-color .2s;margin-bottom:16px">' +
        '<div style="font-size:32px">📷</div>' +
        '<div style="font-size:13px;color:rgba(255,255,255,.5)">Click to select photos</div>' +
        '<div style="font-size:11px;color:rgba(255,255,255,.25)">JPG, PNG, HEIC — any size, auto-compressed</div>' +
        '<input id="fw-file-input" type="file" accept="image/*" multiple style="display:none">' +
      '</label>' +
      '<div id="fw-preview-grid" style="display:grid;grid-template-columns:repeat(3,1fr);gap:8px;margin-bottom:16px"></div>' +
      '<div id="fw-upload-status" style="font-size:12px;color:rgba(255,255,255,.4);margin-bottom:12px;min-height:18px"></div>' +
      '<div style="display:flex;gap:10px">' +
        '<button id="fw-save-btn" style="display:none;padding:10px 28px;background:var(--rust);border:none;color:#fff;font-family:var(--body);font-size:13px;letter-spacing:1px;text-transform:uppercase;cursor:pointer;border-radius:2px">Save Photos</button>' +
        '<button id="fw-cancel-btn" style="padding:10px 20px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.1);color:rgba(255,255,255,.5);font-family:var(--body);font-size:13px;cursor:pointer;border-radius:2px">Cancel</button>' +
      '</div>' +
    '</div>';

  document.body.appendChild(panel);

  var fileInput  = panel.querySelector('#fw-file-input');
  var dropZone   = panel.querySelector('#fw-drop-zone');
  var previewGrid= panel.querySelector('#fw-preview-grid');
  var statusEl   = panel.querySelector('#fw-upload-status');
  var saveBtn    = panel.querySelector('#fw-save-btn');
  var cancelBtn  = panel.querySelector('#fw-cancel-btn');
  var closeBtn   = panel.querySelector('#fw-panel-close');
  var selectedFiles = [];

  function closePanel() { panel.remove(); }
  cancelBtn.onclick = closePanel;
  closeBtn.onclick  = closePanel;
  panel.addEventListener('click', function(e) { if (e.target === panel) closePanel(); });

  /* Highlight drop zone */
  dropZone.addEventListener('dragover', function(e) { e.preventDefault(); dropZone.style.borderColor = 'var(--rust)'; });
  dropZone.addEventListener('dragleave', function() { dropZone.style.borderColor = 'rgba(255,255,255,.15)'; });
  dropZone.addEventListener('drop', function(e) {
    e.preventDefault();
    dropZone.style.borderColor = 'rgba(255,255,255,.15)';
    handleFiles(Array.from(e.dataTransfer.files).filter(function(f){ return f.type.startsWith('image/'); }));
  });

  fileInput.addEventListener('change', function() {
    handleFiles(Array.from(fileInput.files || []));
    fileInput.value = '';
  });

  function handleFiles(files) {
    /* Check existing photos already in album */
    var existingCount = 0;
    var albumEl = document.querySelector('[data-album-id="' + aid + '"]');
    if (albumEl) existingCount = albumEl.querySelectorAll('.photo-slot').length;

    var available = 6 - existingCount - selectedFiles.length;
    if (available <= 0) { statusEl.textContent = 'Album is full (max 6 photos).'; statusEl.style.color = '#f87171'; return; }
    if (files.length > available) {
      statusEl.textContent = 'Only ' + available + ' slot(s) left — first ' + available + ' selected.';
      statusEl.style.color = 'rgba(255,255,255,.4)';
      files = files.slice(0, available);
    }

    files.forEach(function(file) {
      selectedFiles.push(file);
      var thumb = document.createElement('div');
      thumb.style.cssText = 'aspect-ratio:1;border-radius:3px;overflow:hidden;position:relative;background:rgba(255,255,255,.05)';
      thumb.innerHTML = '<div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;font-size:11px;color:rgba(255,255,255,.3)">Loading...</div>';
      previewGrid.appendChild(thumb);

      var objUrl = URL.createObjectURL(file);
      var img = document.createElement('img');
      img.onload = function() { URL.revokeObjectURL(objUrl); thumb.innerHTML = ''; thumb.appendChild(img); };
      img.style.cssText = 'width:100%;height:100%;object-fit:cover;display:block';
      img.src = objUrl;
    });

    statusEl.textContent = selectedFiles.length + ' photo(s) selected — click Save to upload.';
    statusEl.style.color = '#4ade80';
    saveBtn.style.display = 'block';
  }

  saveBtn.onclick = function() {
    if (!selectedFiles.length) return;
    saveBtn.disabled = true;
    saveBtn.textContent = 'Uploading...';
    statusEl.style.color = 'rgba(255,255,255,.4)';

    var total = selectedFiles.length;
    var succeeded = 0;
    var errors = [];

    /* Sequential upload — one at a time, no sort_order races */
    function uploadNext(idx) {
      if (idx >= total) {
        if (succeeded === total) {
          statusEl.innerHTML = '<span style="color:#4ade80">&#10003; ' + succeeded + ' photo(s) saved successfully!</span>';
          setTimeout(function() { closePanel(); adminLoadAlbums(); }, 800);
        } else {
          var errHtml = '<span style="color:#f87171">' + succeeded + '/' + total + ' saved.</span>';
          if (errors.length) errHtml += '<br><small style="color:#f87171;font-size:11px">' + errors.join('<br>') + '</small>';
          statusEl.innerHTML = errHtml;
          saveBtn.disabled = false;
          saveBtn.textContent = 'Retry';
        }
        return;
      }

      var file = selectedFiles[idx];
      statusEl.innerHTML = 'Uploading ' + (idx + 1) + ' / ' + total + '...';
      statusEl.style.color = 'rgba(255,255,255,.5)';

      adminCompressImage(file, 1400, 0.85).then(function(blob) {
        var origKB = Math.round(file.size / 1024);
        var compKB = Math.round(blob.size / 1024);
        console.log('[FW] ' + (idx+1) + ': ' + origKB + 'KB → ' + compKB + 'KB');

        var fd = new FormData();
        fd.append('photo', blob, 'photo.jpg');
        fd.append('album_id', aid);
        fd.append('sort_order', String(idx));

        fetch(_admRest + '/admin/upload-album-photo', {
          method: 'POST',
          headers: { 'Authorization': 'Bearer ' + _admToken },
          body: fd
        })
          .then(function(r) {
            /* Always read body — contains error detail even on non-200 */
            return r.json().then(function(j) { return { ok: r.ok, status: r.status, body: j }; })
                   .catch(function() { return r.text().then(function(t) { return { ok: false, status: r.status, body: t }; }); });
          })
          .then(function(result) {
            if (result.ok && result.body && result.body.success) {
              succeeded++;
              console.log('[FW] photo ' + (idx+1) + ' saved:', result.body.url);
            } else {
              var msg = (result.body && result.body.message) ? result.body.message : JSON.stringify(result.body).substring(0, 200);
              var errMsg = 'Photo ' + (idx+1) + ' [' + result.status + ']: ' + msg;
              console.error('[FW]', errMsg);
              errors.push(errMsg);
            }
            uploadNext(idx + 1);
          })
          .catch(function(e) {
            var errMsg = 'Photo ' + (idx+1) + ' network error: ' + e.message;
            console.error('[FW]', errMsg);
            errors.push(errMsg);
            uploadNext(idx + 1);
          });
      });
    }

    uploadNext(0);
  };
}

function adminLoadAlbums() {
  var el = document.getElementById('adminAlbumList');
  el.innerHTML = '<div class="adm-spinner">Loading...</div>';
  fetch(_admRest + '/admin/get-albums', { headers: { 'Authorization': 'Bearer ' + _admToken } })
    .then(function(r){
      if (!r.ok) return r.text().then(function(t){ throw new Error(r.status + ': ' + t); });
      return r.json();
    })
    .then(function(d){
      if (!d.success || !Array.isArray(d.albums) || !d.albums.length) {
        el.innerHTML = '<div class="adm-empty">No albums yet. Create one above.</div>';
        return;
      }
      el.innerHTML = '';
      d.albums.forEach(function(a) {
        var card = document.createElement('div');
        card.style.cssText = 'background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.08);border-radius:2px;margin-bottom:14px;overflow:hidden';
        card.setAttribute('data-album-id', a.id);

        var header = document.createElement('div');
        header.style.cssText = 'display:flex;align-items:center;justify-content:space-between;padding:12px 16px;gap:12px;flex-wrap:wrap';

        var photoCount = Array.isArray(a.photos) ? a.photos.length : 0;

        var meta = document.createElement('div');
        meta.style.cssText = 'flex:1;min-width:0';
        meta.innerHTML = '<div style="font-size:14px;color:#fff;font-weight:500">' + (a.title||'Untitled') + '</div>'
          + '<div style="font-size:11px;color:rgba(255,255,255,.35);margin-top:3px">'
          + (a.trip_name ? a.trip_name + ' &middot; ' : '') + fmtDate(a.created_at)
          + ' &middot; ' + photoCount + '/6 photos &middot; ' + statusBadge(a.status) + '</div>';

        var addBtn = document.createElement('button');
        addBtn.textContent = '+ Add Photos';
        addBtn.style.cssText = 'padding:6px 14px;font-size:11px;letter-spacing:1px;text-transform:uppercase;font-family:var(--body);cursor:pointer;background:rgba(193,68,14,.2);border:1px solid rgba(193,68,14,.4);color:var(--rust);border-radius:2px;white-space:nowrap';

        var delBtn = document.createElement('button');
        delBtn.textContent = 'Delete';
        delBtn.style.cssText = 'padding:6px 14px;font-size:11px;letter-spacing:1px;text-transform:uppercase;font-family:var(--body);cursor:pointer;background:rgba(248,113,113,.08);border:1px solid rgba(248,113,113,.25);color:#f87171;border-radius:2px;white-space:nowrap';

        var hint = document.createElement('div');
        hint.style.cssText = 'font-size:10px;color:rgba(255,255,255,.25);margin-top:3px;text-align:right';
        hint.textContent = 'Max 6 photos · auto-compressed';

        var btnWrap = document.createElement('div');
        btnWrap.style.cssText = 'display:flex;flex-direction:column;align-items:flex-end;gap:6px;flex-shrink:0';
        var btnRow = document.createElement('div');
        btnRow.style.cssText = 'display:flex;gap:6px';
        btnRow.appendChild(addBtn);
        btnRow.appendChild(delBtn);
        btnWrap.appendChild(btnRow);
        btnWrap.appendChild(hint);

        header.appendChild(meta);
        header.appendChild(btnWrap);

        delBtn.addEventListener('click', (function(aid, cardEl){ return function(){
          if (!confirm('Delete this album and all its photos? This cannot be undone.')) return;
          fetch(_admRest + '/admin/delete-album', {
            method: 'POST',
            headers: { 'Authorization': 'Bearer ' + _admToken, 'Content-Type': 'application/json' },
            body: JSON.stringify({ album_id: aid })
          })
            .then(function(r){ return r.json(); })
            .then(function(d){ if (d.success) { cardEl.remove(); toast('Album deleted'); } else toast('Delete failed', true); })
            .catch(function(){ toast('Delete failed', true); });
        }; })(a.id, card));

        var grid = document.createElement('div');
        grid.style.cssText = 'display:grid;grid-template-columns:repeat(auto-fill,minmax(80px,1fr));gap:6px;padding:0 16px 16px';

        (Array.isArray(a.photos) ? a.photos : []).forEach(function(p){
          var slot = document.createElement('div');
          slot.className = 'photo-slot';
          slot.style.cssText = 'aspect-ratio:1;border-radius:3px;overflow:hidden';
          slot.innerHTML = '<img src="' + p.url + '" style="width:100%;height:100%;object-fit:cover;display:block">';
          grid.appendChild(slot);
        });
        if (!(a.photos||[]).length) {
          var empty = document.createElement('div');
          empty.className = 'album-empty-note';
          empty.style.cssText = 'color:rgba(255,255,255,.3);font-size:12px;grid-column:1/-1;padding:10px 0';
          empty.textContent = 'No photos yet.';
          grid.appendChild(empty);
        }

        addBtn.addEventListener('click', (function(aid, t){ return function(){ adminDoUpload(aid, t); }; })(a.id, a.title||'Album'));

        card.appendChild(header);
        card.appendChild(grid);
        el.appendChild(card);
      });
    })
    .catch(function(e){
      console.error('[FW Admin] get-albums error:', e);
      el.innerHTML = '<div class="adm-empty" style="color:#f87171">Load error: ' + e.message + '</div>';
    });
}

function adminCreateAlbum() {
  var title    = document.getElementById('adminAlbumTitle').value.trim();
  var isPublic = document.getElementById('adminAlbumIsPublic').checked;
  var msg      = document.getElementById('adminAlbumFormMsg');
  if (!title) { msg.textContent = 'Album title is required.'; msg.style.color = '#f87171'; return; }
  msg.textContent = 'Creating...'; msg.style.color = 'rgba(255,255,255,.4)';
  fetch(_admRest + '/admin/create-album', {
    method: 'POST',
    headers: { 'Authorization': 'Bearer ' + _admToken, 'Content-Type': 'application/json' },
    body: JSON.stringify({ title: title, is_public: isPublic })
  })
    .then(function(r){
      if (!r.ok) return r.text().then(function(t){ throw new Error(r.status + ': ' + t); });
      return r.json();
    })
    .then(function(d){
      if (d.success) {
        msg.textContent = 'Album created! Loading...'; msg.style.color = '#4ade80';
        document.getElementById('adminAlbumTitle').value = '';

        document.getElementById('adminAlbumIsPublic').checked = false;
        document.getElementById('adminAlbumForm').style.display = 'none';
        adminLoadAlbums();
      } else { msg.textContent = d.message || 'Error creating album.'; msg.style.color = '#f87171'; }
    })
    .catch(function(e){ msg.textContent = 'Error: ' + e.message; msg.style.color = '#f87171'; });
}
