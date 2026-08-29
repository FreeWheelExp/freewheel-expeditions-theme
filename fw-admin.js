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
  loadSubscriberCount();
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
      '<div style="margin-bottom:4px">' + stars(t.rating) + ' <span style="font-size:12px;color:rgba(255,255,255,.5)">' + (t.trip_name||'') + '</span></div>' +
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
      (a.trip_name ? ' <span style="font-size:12px;color:rgba(255,255,255,.5)">' + a.trip_name + '</span>' : '') +
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
          '<div style="font-size:15px;color:#fff;margin-bottom:4px">'+b.trip_title+' <span style="font-size:12px;color:rgba(255,255,255,.5)">'+b.trip_dates+'</span></div>'+
          '<div class="adm-meta">'+
            (b.contact_name||b.user_id||'Unlinked')+' &middot; '+(b.contact_phone||'—')+' &middot; '+fmtDate(b.created_at)+
            (b.amount_total ? ' &middot; &#8377;'+b.amount_total.toLocaleString('en-IN') : '')+
            (b.payment_ref ? ' &middot; UTR: '+b.payment_ref : '')+
          '</div>'+
          (b.notes ? '<div style="font-size:12px;color:rgba(255,255,255,.5);margin-top:4px">'+b.notes+'</div>' : '')+
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
        '<div style="font-size:11px;color:rgba(255,255,255,.45);margin-top:2px">'+u.trips_completed+' trips &middot; Member since '+fmtDate(u.created_at)+'</div>'+
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
  if (id === 'campaigns') loadCampaignsTab();
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
            '<div style="font-size:12px;color:rgba(255,255,255,.7)">'+(log.actor_email||'unknown')+' <span style="color:rgba(255,255,255,.45)">('+(log.actor_role||'?')+')</span>' +
            (log.target_type ? ' &middot; <span style="color:rgba(255,255,255,.5)">'+log.target_type+(log.target_id ? ' #'+String(log.target_id).substring(0,8) : '')+'</span>' : '') + '</div>' +
            (log.details ? '<div style="font-size:11px;color:rgba(255,255,255,.5);margin-top:3px">'+log.details+'</div>' : '') +
          '</div>' +
          '<span style="font-size:10px;color:rgba(255,255,255,.45);white-space:nowrap;flex-shrink:0">'+fmtDate(log.created_at)+'</span>' +
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

function loadSubscriberCount() {
  fetch(_admRest + '/admin/subscribers', {headers: h()})
    .then(function(r){ return r.json(); })
    .then(function(d) {
      var statSubs = document.getElementById('admStatSubscribers');
      if (statSubs) statSubs.textContent = (typeof d.total === 'number') ? d.total : (d.subscribers || []).length;
    })
    .catch(function(){
      var statSubs = document.getElementById('admStatSubscribers');
      if (statSubs) statSubs.textContent = '?';
    });
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

    var isStaff = m.role === 'moderator' || m.role === 'admin' || m.role === 'super_admin';
    /* Moderators cannot act on staff accounts at all — render as read-only */
    if ( !isSuperAdmin && isStaff ) {
      return '<div class="adm-card" style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;opacity:.55">'+av+'<div style="flex:1;min-width:160px"><div style="font-size:14px;color:#fff">'+(m.first_name||'')+' '+(m.last_name||'')+'</div><div style="font-size:11px;color:rgba(255,255,255,.5);margin-top:2px">'+m.email+'</div></div><div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap">'+sb+rb+'<span style="font-size:10px;color:rgba(255,255,255,.45)">Staff account — Super Admin only</span></div></div>';
    }

    var bb = m.is_suspended
      ? '<button class="adm-btn btn-approve" data-uid="'+m.id+'" data-block="0" onclick="toggleBlock(this.dataset.uid,false)">Unblock</button>'
      : '<button class="adm-btn btn-reject" data-uid="'+m.id+'" data-block="1" onclick="toggleBlock(this.dataset.uid,true)">Block</button>';

    /* Role dropdown — Super Admin only */
    var rs = isSuperAdmin
      ? '<select data-uid="'+m.id+'" onchange="changeMemberRole(this.dataset.uid,this.value)" style="padding:5px 8px;background:#0f0d0b;border:1px solid rgba(255,255,255,.12);color:#fff;font-size:11px;border-radius:2px;cursor:pointer"><option value="">Change role...</option><option value="member">Member</option><option value="moderator">Moderator</option><option value="super_admin">Super Admin</option></select>'
      : '';

    var removeBtn = '<button data-uid="'+m.id+'" data-name="'+((m.first_name||'')+' '+(m.last_name||'')).trim().replace(/"/g,'')+'" onclick="removeMember(this.dataset.uid,this.dataset.name)" style="padding:6px 12px;background:rgba(248,113,113,.08);border:1px solid rgba(248,113,113,.25);color:#f87171;font-size:11px;cursor:pointer;border-radius:2px">Remove</button>';

    return '<div class="adm-card" style="display:flex;align-items:center;gap:12px;flex-wrap:wrap">'+av+'<div style="flex:1;min-width:160px"><div style="font-size:14px;color:#fff">'+(m.first_name||'')+' '+(m.last_name||'')+'</div><div style="font-size:11px;color:rgba(255,255,255,.5);margin-top:2px">'+m.email+'</div><div style="font-size:11px;color:rgba(255,255,255,.45)">'+(m.phone||'')+(m.city?' - '+m.city:'')+'</div></div><div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap">'+sb+rb+rs+bb+removeBtn+'</div></div>';
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
        html += '<div style="margin-bottom:24px"><div style="font-family:var(--headline);font-size:16px;color:#fff;letter-spacing:.5px;margin-bottom:10px">' + tripName + ' <span style="font-size:12px;color:rgba(255,255,255,.5);font-family:var(--body)">(' + entries.length + ' waiting)</span></div>';
        entries.forEach(function(w) {
          var statusColor = w.status === 'notified' ? '#e8a020' : '#4ade80';
          var statusLabel = w.status === 'notified' ? 'Notified' : 'Waiting';
          html += '<div class="adm-card" style="display:flex;align-items:center;gap:14px;flex-wrap:wrap;margin-bottom:6px">' +
            '<div style="flex:1;min-width:160px"><div style="font-size:13px;color:#fff">' + w.member_name + '</div><div style="font-size:11px;color:rgba(255,255,255,.5);margin-top:2px">' + (w.member_email||'') + (w.member_phone?' · '+w.member_phone:'') + '</div></div>' +
            '<div style="font-size:12px;color:rgba(255,255,255,.5)">' + w.seats_wanted + ' seat(s)</div>' +
            '<span class="adm-badge" style="background:'+statusColor+'18;color:'+statusColor+';border:1px solid '+statusColor+'40">' + statusLabel + '</span>' +
            '<div style="display:flex;gap:6px">' +
              (w.status === 'waiting' ? '<button class="adm-btn btn-approve" data-id="'+w.id+'" onclick="waitlistAction(this.dataset.id,\'notify\')">Notify</button>' : '') +
              '<button class="adm-btn btn-approve" data-id="'+w.id+'" onclick="waitlistAction(this.dataset.id,\'convert\')">Mark Booked</button>' +
              '<button class="adm-btn btn-reject" data-id="'+w.id+'" onclick="waitlistAction(this.dataset.id,\'remove\')">Remove</button>' +
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
  var sectionMap = { blog:'createBlogSection', album:'createAlbumSection', expedition:'createExpeditionSection', product:'createProductSection' };
  var btnMap     = { blog:'createTabBlog', album:'createTabAlbum', expedition:'createTabExpedition', product:'createTabProduct' };
  Object.keys(sectionMap).forEach(function(t){
    var active = (t === tab);
    document.getElementById(sectionMap[t]).style.display = active ? '' : 'none';
    var btn = document.getElementById(btnMap[t]);
    btn.style.background = active ? 'var(--rust)' : 'rgba(255,255,255,.08)';
    btn.style.border     = active ? 'none' : '1px solid rgba(255,255,255,.12)';
    btn.style.color      = active ? '#fff' : 'rgba(255,255,255,.6)';
  });
  if (tab === 'blog') adminLoadBlogs();
  else if (tab === 'album') adminLoadAlbums();
  else if (tab === 'expedition') adminLoadExpeditions();
  else if (tab === 'product') adminLoadProducts();
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
          + '<div style="font-size:11px;color:rgba(255,255,255,.5);margin-top:2px">' + fmtDate(b.created_at) + ' ' + statusBadge(b.status) + '</div></div>'
          + '<div style="display:flex;gap:6px;flex-shrink:0">'
          + '<button class="fw-blog-edit" style="padding:6px 14px;font-size:11px;letter-spacing:1px;text-transform:uppercase;font-family:var(--body);cursor:pointer;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.12);color:rgba(255,255,255,.6);border-radius:2px">Edit</button>'
          + '<button class="fw-blog-del" style="padding:6px 14px;font-size:11px;letter-spacing:1px;text-transform:uppercase;font-family:var(--body);cursor:pointer;background:rgba(231,76,60,.15);border:1px solid rgba(231,76,60,.4);color:#e74c3c;border-radius:2px">Delete</button>'
          + '</div>';
        row.querySelector('.fw-blog-edit').addEventListener('click', (function(blog){ return function(){ adminEditBlog(blog); }; })(b));
        row.querySelector('.fw-blog-del').addEventListener('click', (function(blog){ return function(){ adminDeleteBlog(blog.id); }; })(b));
        el.appendChild(row);
      });
    })
    .catch(function(e){ console.error('[FW Admin] get-blogs:', e); el.innerHTML = '<div class="adm-empty">Failed to load.</div>'; });
}

function adminDeleteBlog(id) {
  if (!confirm('Delete this blog post? This cannot be undone.')) return;
  fetch(_admRest + '/admin/delete-blog', {
    method: 'POST',
    headers: { 'Authorization': 'Bearer ' + _admToken, 'Content-Type': 'application/json' },
    body: JSON.stringify({ id: id })
  })
    .then(function(r){ return r.json(); })
    .then(function(d){ if (d.success) adminLoadBlogs(); else alert(d.message || 'Could not delete blog.'); })
    .catch(function(){ alert('Error deleting blog.'); });
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
          '<div style="font-size:11px;color:rgba(255,255,255,.5);margin-top:2px">' + albumTitle + ' · max 6 photos · auto-compressed</div>' +
        '</div>' +
        '<button id="fw-panel-close" style="background:none;border:none;color:rgba(255,255,255,.5);font-size:22px;cursor:pointer;padding:0;line-height:1">&times;</button>' +
      '</div>' +
      '<label id="fw-drop-zone" style="display:flex;flex-direction:column;align-items:center;justify-content:center;gap:10px;border:2px dashed rgba(255,255,255,.15);border-radius:4px;padding:32px 20px;cursor:pointer;transition:border-color .2s;margin-bottom:16px">' +
        '<div style="font-size:32px">📷</div>' +
        '<div style="font-size:13px;color:rgba(255,255,255,.5)">Click to select photos</div>' +
        '<div style="font-size:11px;color:rgba(255,255,255,.45)">JPG, PNG, HEIC — any size, auto-compressed</div>' +
        '<input id="fw-file-input" type="file" accept="image/*" multiple style="display:none">' +
      '</label>' +
      '<div id="fw-preview-grid" style="display:grid;grid-template-columns:repeat(3,1fr);gap:8px;margin-bottom:16px"></div>' +
      '<div id="fw-upload-status" style="font-size:12px;color:rgba(255,255,255,.5);margin-bottom:12px;min-height:18px"></div>' +
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
      thumb.innerHTML = '<div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;font-size:11px;color:rgba(255,255,255,.45)">Loading...</div>';
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
          + '<div style="font-size:11px;color:rgba(255,255,255,.5);margin-top:3px">'
          + (a.trip_name ? a.trip_name + ' &middot; ' : '') + fmtDate(a.created_at)
          + ' &middot; ' + photoCount + '/6 photos &middot; ' + statusBadge(a.status) + '</div>';

        var addBtn = document.createElement('button');
        addBtn.textContent = '+ Add Photos';
        addBtn.style.cssText = 'padding:6px 14px;font-size:11px;letter-spacing:1px;text-transform:uppercase;font-family:var(--body);cursor:pointer;background:rgba(193,68,14,.2);border:1px solid rgba(193,68,14,.4);color:var(--rust);border-radius:2px;white-space:nowrap';

        var delBtn = document.createElement('button');
        delBtn.textContent = 'Delete';
        delBtn.style.cssText = 'padding:6px 14px;font-size:11px;letter-spacing:1px;text-transform:uppercase;font-family:var(--body);cursor:pointer;background:rgba(248,113,113,.08);border:1px solid rgba(248,113,113,.25);color:#f87171;border-radius:2px;white-space:nowrap';

        var hint = document.createElement('div');
        hint.style.cssText = 'font-size:10px;color:rgba(255,255,255,.45);margin-top:3px;text-align:right';
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
          empty.style.cssText = 'color:rgba(255,255,255,.45);font-size:12px;grid-column:1/-1;padding:10px 0';
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

/* ══════════════════════════════════════════════════════════════════════
   EXPEDITIONS — writes directly to WP fw_expedition posts, same postmeta
   keys the native WP Admin editor uses, so content shows up live.
   ══════════════════════════════════════════════════════════════════════ */
var _expGallery = [];

function adminLoadExpeditions() {
  var el = document.getElementById('adminExpeditionList');
  el.innerHTML = '<div class="adm-spinner">Loading...</div>';
  fetch(_admRest + '/admin/list-expeditions', { headers: { 'Authorization': 'Bearer ' + _admToken } })
    .then(function(r){ return r.json(); })
    .then(function(d){
      if (!d.success || !d.expeditions || !d.expeditions.length) { el.innerHTML = '<div class="adm-empty">No expeditions yet.</div>'; return; }
      el.innerHTML = '';
      d.expeditions.forEach(function(x) {
        var row = document.createElement('div');
        row.style.cssText = 'display:flex;align-items:center;justify-content:space-between;padding:12px 16px;background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.07);border-radius:2px;margin-bottom:8px;gap:12px';
        var thumb = x.thumbnail ? '<img src="' + x.thumbnail + '" style="width:44px;height:32px;object-fit:cover;border-radius:2px;flex-shrink:0">' : '<div style="width:44px;height:32px;background:#1a1410;border-radius:2px;flex-shrink:0"></div>';
        row.innerHTML = '<div style="display:flex;align-items:center;gap:12px;flex:1;min-width:0">' + thumb
          + '<div style="min-width:0"><div style="font-size:14px;color:#fff;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">' + (x.title || 'Untitled') + '</div>'
          + '<div style="font-size:11px;color:rgba(255,255,255,.5);margin-top:2px">' + (x.destination || '') + (x.dates ? ' · ' + x.dates : '') + (x.status === 'draft' ? ' · <span style="color:#e8a020">DRAFT</span>' : '') + '</div></div></div>'
          + '<div style="display:flex;gap:6px;flex-shrink:0">'
          + '<button class="fw-exp-edit" style="padding:6px 14px;font-size:11px;letter-spacing:1px;text-transform:uppercase;font-family:var(--body);cursor:pointer;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.12);color:rgba(255,255,255,.6);border-radius:2px">Edit</button>'
          + '<button class="fw-exp-del" style="padding:6px 14px;font-size:11px;letter-spacing:1px;text-transform:uppercase;font-family:var(--body);cursor:pointer;background:rgba(231,76,60,.15);border:1px solid rgba(231,76,60,.4);color:#e74c3c;border-radius:2px">Delete</button>'
          + '</div>';
        row.querySelector('.fw-exp-edit').addEventListener('click', (function(id){ return function(){ adminShowExpeditionEditor(id); }; })(x.id));
        row.querySelector('.fw-exp-del').addEventListener('click', (function(id,title){ return function(){ adminDeleteExpedition(id,title); }; })(x.id, x.title));
        el.appendChild(row);
      });
    })
    .catch(function(e){ console.error('[FW Admin] list-expeditions:', e); el.innerHTML = '<div class="adm-empty">Failed to load.</div>'; });
}

function expResetForm() {
  ['expId','expDestination','expDates','expMonth','expDuration','expRegion','expSubtitle','expOverview','expHighlights','expBadge','expBadgeUntil','expWhatsapp','expQrImage','expCancellation','expThingsCarry','expInclusions','expExclusions','expThumbId'].forEach(function(id){ document.getElementById(id).value = ''; });
  document.getElementById('expTitle').value = '';
  document.getElementById('expStatus').value = 'upcoming';
  document.getElementById('expDifficulty').value = 'Moderate';
  document.getElementById('expEmoji').value = '🏔️';
  document.getElementById('expPriceUnit').value = 'per person';
  document.getElementById('expWaitlist').value = '';
  document.getElementById('expPrice').value = '';
  document.getElementById('expCouplePrice').value = '';
  document.getElementById('expSeatPrice').value = '';
  document.getElementById('expOverlandPrice').value = '';
  document.getElementById('expOrder').value = '0';
  document.getElementById('expPostStatus').value = 'publish';
  document.getElementById('expItinRows').innerHTML = '';
  document.getElementById('expFaqRows').innerHTML = '';
  document.getElementById('expThumbPreview').style.display = 'none';
  document.getElementById('expThumbName').textContent = '';
  document.getElementById('adminExpeditionMsg').textContent = '';
  _expGallery = [];
  expRenderGallery();
  expAddDay(); expAddDay();
  expAddFaq(); expAddFaq();
}

function adminShowExpeditionEditor(id) {
  expResetForm();
  document.getElementById('adminExpeditionEditor').style.display = 'block';
  document.getElementById('adminExpeditionEditor').scrollIntoView({ behavior: 'smooth', block: 'start' });
  if (!id) return;

  document.getElementById('adminExpeditionMsg').textContent = 'Loading expedition...';
  fetch(_admRest + '/admin/get-expedition?id=' + id, { headers: { 'Authorization': 'Bearer ' + _admToken } })
    .then(function(r){ return r.json(); })
    .then(function(d){
      document.getElementById('adminExpeditionMsg').textContent = '';
      if (!d.success) { alert(d.message || 'Could not load expedition.'); return; }
      var e = d.expedition;
      document.getElementById('expId').value = e.id;
      document.getElementById('expTitle').value = e.title || '';
      document.getElementById('expStatus').value = e.fw_status || 'upcoming';
      document.getElementById('expDestination').value = e.fw_destination || '';
      document.getElementById('expDates').value = e.fw_dates || '';
      document.getElementById('expMonth').value = e.fw_month || '';
      document.getElementById('expDuration').value = e.fw_duration || '';
      document.getElementById('expRegion').value = e.fw_region || '';
      document.getElementById('expDifficulty').value = e.fw_difficulty || 'Moderate';
      document.getElementById('expEmoji').value = e.fw_hero_emoji || '🏔️';
      document.getElementById('expSubtitle').value = e.fw_subtitle || '';
      document.getElementById('expOverview').value = e.fw_overview || '';
      document.getElementById('expHighlights').value = e.fw_highlights || '';
      document.getElementById('expPrice').value = e.fw_price || '';
      document.getElementById('expPriceUnit').value = e.fw_price_unit || 'per person';
      document.getElementById('expBadge').value = e.fw_badge || '';
      document.getElementById('expBadgeUntil').value = e.fw_badge_until || '';
      document.getElementById('expCouplePrice').value = e.fw_couple_price || '';
      document.getElementById('expSeatPrice').value = e.fw_seat_price || '';
      document.getElementById('expOverlandPrice').value = e.fw_overland_price || '';
      document.getElementById('expOrder').value = e.fw_order || '0';
      document.getElementById('expWaitlist').value = e.fw_waitlist_mode || '';
      document.getElementById('expWhatsapp').value = e.fw_whatsapp || '';
      document.getElementById('expQrImage').value = e.fw_qr_image || '';
      document.getElementById('expCancellation').value = e.fw_cancellation || '';
      document.getElementById('expThingsCarry').value = e.fw_things_carry || '';
      document.getElementById('expInclusions').value = e.fw_inclusions || '';
      document.getElementById('expExclusions').value = e.fw_exclusions || '';
      document.getElementById('expPostStatus').value = e.post_status === 'draft' ? 'draft' : 'publish';

      document.getElementById('expItinRows').innerHTML = '';
      (e.itinerary && e.itinerary.length ? e.itinerary : [{title:'',description:''}]).forEach(function(day){ expAddDay(day); });

      document.getElementById('expFaqRows').innerHTML = '';
      (e.faqs && e.faqs.length ? e.faqs : [{q:'',a:''}]).forEach(function(faq){ expAddFaq(faq); });

      _expGallery = e.gallery || [];
      expRenderGallery();

      if (e.thumbnail_id) {
        document.getElementById('expThumbId').value = e.thumbnail_id;
        document.getElementById('expThumbPreview').src = e.thumbnail_url;
        document.getElementById('expThumbPreview').style.display = 'block';
        document.getElementById('expThumbName').textContent = 'Current image';
      }
    })
    .catch(function(){ document.getElementById('adminExpeditionMsg').textContent = 'Failed to load expedition.'; document.getElementById('adminExpeditionMsg').style.color = '#f87171'; });
}

/* ---- Itinerary day builder ---- */
function expAddDay(day) {
  day = day || { title: '', description: '' };
  var rows = document.getElementById('expItinRows');
  var num = rows.querySelectorAll('.exp-itin-row').length + 1;
  var div = document.createElement('div');
  div.className = 'exp-itin-row';
  div.style.cssText = 'display:grid;grid-template-columns:220px 1fr 34px;gap:10px;margin-bottom:8px;align-items:start';
  div.innerHTML = '<input type="text" class="adm-input exp-day-title" placeholder="Day ' + num + ': Title">'
    + '<textarea class="adm-input exp-day-desc" rows="2" placeholder="What happens this day..."></textarea>'
    + '<button type="button" style="background:#e74c3c;color:#fff;border:none;border-radius:2px;width:34px;height:34px;cursor:pointer;font-size:14px">×</button>';
  div.querySelector('.exp-day-title').value = day.title || '';
  div.querySelector('.exp-day-desc').value = day.description || '';
  div.querySelector('button').addEventListener('click', function(){ div.remove(); });
  rows.appendChild(div);
}

/* ---- FAQ builder ---- */
function expAddFaq(faq) {
  faq = faq || { q: '', a: '' };
  var rows = document.getElementById('expFaqRows');
  var div = document.createElement('div');
  div.className = 'exp-faq-row';
  div.style.cssText = 'background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.08);border-radius:2px;padding:12px;margin-bottom:10px;position:relative';
  div.innerHTML = '<button type="button" style="position:absolute;top:8px;right:8px;background:#e74c3c;color:#fff;border:none;border-radius:2px;padding:2px 8px;cursor:pointer;font-size:11px">✕</button>'
    + '<label class="adm-label">Question</label><input type="text" class="adm-input exp-faq-q" placeholder="e.g. What permits do I need?" style="margin-bottom:8px">'
    + '<label class="adm-label">Answer</label><textarea class="adm-input exp-faq-a" rows="2"></textarea>';
  div.querySelector('.exp-faq-q').value = faq.q || '';
  div.querySelector('.exp-faq-a').value = faq.a || '';
  div.querySelector('button').addEventListener('click', function(){ div.remove(); });
  rows.appendChild(div);
}

/* ---- Gallery (multi-image) ---- */
function expRenderGallery() {
  var el = document.getElementById('expGalPreview');
  el.innerHTML = '';
  _expGallery.forEach(function(img){
    var d = document.createElement('div');
    d.style.cssText = 'position:relative;width:100px;height:70px;border-radius:2px;overflow:hidden;background:#1a1410';
    d.innerHTML = '<img src="' + img.url + '" style="width:100%;height:100%;object-fit:cover">'
      + '<button type="button" style="position:absolute;top:2px;right:2px;background:rgba(231,76,60,.9);color:#fff;border:none;border-radius:2px;padding:1px 5px;cursor:pointer;font-size:11px">✕</button>';
    d.querySelector('button').addEventListener('click', function(){ _expGallery = _expGallery.filter(function(x){ return x.id !== img.id; }); expRenderGallery(); });
    el.appendChild(d);
  });
}

function expUploadGallery(input) {
  if (!input.files || !input.files.length) return;
  var files = Array.prototype.slice.call(input.files);
  files.forEach(function(file){
    var fd = new FormData();
    fd.append('photo', file);
    fetch(_admRest + '/admin/upload-content-image', { method: 'POST', headers: { 'Authorization': 'Bearer ' + _admToken }, body: fd })
      .then(function(r){ return r.json(); })
      .then(function(d){ if (d.success) { _expGallery.push({ id: d.id, url: d.url }); expRenderGallery(); } })
      .catch(function(){ console.error('[FW Admin] gallery upload failed'); });
  });
  input.value = '';
}

function expUploadThumb(input) {
  if (!input.files[0]) return;
  var fd = new FormData();
  fd.append('photo', input.files[0]);
  fetch(_admRest + '/admin/upload-content-image', { method: 'POST', headers: { 'Authorization': 'Bearer ' + _admToken }, body: fd })
    .then(function(r){ return r.json(); })
    .then(function(d){
      if (d.success) {
        document.getElementById('expThumbId').value = d.id;
        document.getElementById('expThumbPreview').src = d.url;
        document.getElementById('expThumbPreview').style.display = 'block';
        document.getElementById('expThumbName').textContent = '✓ Uploaded';
        document.getElementById('expThumbName').style.color = '#4ade80';
      }
    });
}

function adminSaveExpedition() {
  var title = document.getElementById('expTitle').value.trim();
  var msg = document.getElementById('adminExpeditionMsg');
  if (!title) { msg.textContent = 'Title is required.'; msg.style.color = '#f87171'; return; }

  var itinerary = [];
  document.querySelectorAll('#expItinRows .exp-itin-row').forEach(function(row){
    itinerary.push({ title: row.querySelector('.exp-day-title').value, description: row.querySelector('.exp-day-desc').value });
  });
  var faqs = [];
  document.querySelectorAll('#expFaqRows .exp-faq-row').forEach(function(row){
    faqs.push({ q: row.querySelector('.exp-faq-q').value, a: row.querySelector('.exp-faq-a').value });
  });

  var payload = {
    id: document.getElementById('expId').value,
    title: title,
    post_status: document.getElementById('expPostStatus').value,
    fw_status: document.getElementById('expStatus').value,
    fw_destination: document.getElementById('expDestination').value,
    fw_dates: document.getElementById('expDates').value,
    fw_month: document.getElementById('expMonth').value,
    fw_duration: document.getElementById('expDuration').value,
    fw_region: document.getElementById('expRegion').value,
    fw_difficulty: document.getElementById('expDifficulty').value,
    fw_hero_emoji: document.getElementById('expEmoji').value,
    fw_subtitle: document.getElementById('expSubtitle').value,
    fw_overview: document.getElementById('expOverview').value,
    fw_highlights: document.getElementById('expHighlights').value,
    fw_price: document.getElementById('expPrice').value,
    fw_price_unit: document.getElementById('expPriceUnit').value,
    fw_badge: document.getElementById('expBadge').value,
    fw_badge_until: document.getElementById('expBadgeUntil').value,
    fw_couple_price: document.getElementById('expCouplePrice').value,
    fw_seat_price: document.getElementById('expSeatPrice').value,
    fw_overland_price: document.getElementById('expOverlandPrice').value,
    fw_order: document.getElementById('expOrder').value,
    fw_waitlist_mode: document.getElementById('expWaitlist').value,
    fw_whatsapp: document.getElementById('expWhatsapp').value,
    fw_qr_image: document.getElementById('expQrImage').value,
    fw_cancellation: document.getElementById('expCancellation').value,
    fw_things_carry: document.getElementById('expThingsCarry').value,
    fw_inclusions: document.getElementById('expInclusions').value,
    fw_exclusions: document.getElementById('expExclusions').value,
    itinerary: itinerary,
    faqs: faqs,
    gallery: _expGallery,
    thumbnail_id: document.getElementById('expThumbId').value
  };

  msg.textContent = 'Saving...'; msg.style.color = 'rgba(255,255,255,.4)';
  fetch(_admRest + '/admin/save-expedition', {
    method: 'POST',
    headers: { 'Authorization': 'Bearer ' + _admToken, 'Content-Type': 'application/json' },
    body: JSON.stringify(payload)
  })
    .then(function(r){
      if (!r.ok) return r.text().then(function(t){ throw new Error(r.status + ': ' + t); });
      return r.json();
    })
    .then(function(d){
      if (d.success) {
        msg.textContent = 'Expedition saved!'; msg.style.color = '#4ade80';
        setTimeout(function(){ document.getElementById('adminExpeditionEditor').style.display = 'none'; adminLoadExpeditions(); }, 1000);
      } else { msg.textContent = d.message || 'Error saving expedition.'; msg.style.color = '#f87171'; }
    })
    .catch(function(e){ msg.textContent = 'Error: ' + e.message; msg.style.color = '#f87171'; });
}

function adminDeleteExpedition(id, title) {
  if (!confirm('Delete "' + (title || 'this expedition') + '"? This moves it to trash and it will disappear from the live site.')) return;
  fetch(_admRest + '/admin/delete-expedition', {
    method: 'POST',
    headers: { 'Authorization': 'Bearer ' + _admToken, 'Content-Type': 'application/json' },
    body: JSON.stringify({ id: id })
  })
    .then(function(r){ return r.json(); })
    .then(function(d){ if (d.success) adminLoadExpeditions(); else alert(d.message || 'Could not delete.'); })
    .catch(function(){ alert('Error deleting expedition.'); });
}

/* ══════════════════════════════════════════════════════════════════════
   MERCHANDISE — writes directly to WP fw_product posts.
   ══════════════════════════════════════════════════════════════════════ */
function adminLoadProducts() {
  var el = document.getElementById('adminProductList');
  el.innerHTML = '<div class="adm-spinner">Loading...</div>';
  fetch(_admRest + '/admin/list-products', { headers: { 'Authorization': 'Bearer ' + _admToken } })
    .then(function(r){ return r.json(); })
    .then(function(d){
      if (!d.success || !d.products || !d.products.length) { el.innerHTML = '<div class="adm-empty">No products yet.</div>'; return; }
      el.innerHTML = '';
      d.products.forEach(function(x) {
        var row = document.createElement('div');
        row.style.cssText = 'display:flex;align-items:center;justify-content:space-between;padding:12px 16px;background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.07);border-radius:2px;margin-bottom:8px;gap:12px';
        var thumb = x.thumbnail ? '<img src="' + x.thumbnail + '" style="width:40px;height:40px;object-fit:cover;border-radius:2px;flex-shrink:0">' : '<div style="width:40px;height:40px;background:#1a1410;border-radius:2px;flex-shrink:0"></div>';
        row.innerHTML = '<div style="display:flex;align-items:center;gap:12px;flex:1;min-width:0">' + thumb
          + '<div style="min-width:0"><div style="font-size:14px;color:#fff;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">' + (x.title || 'Untitled') + '</div>'
          + '<div style="font-size:11px;color:rgba(255,255,255,.5);margin-top:2px">' + (x.category || '') + (x.price ? ' · ₹' + x.price : '') + ' · ' + (x.stock || 'in-stock') + (x.status === 'draft' ? ' · <span style="color:#e8a020">DRAFT</span>' : '') + '</div></div></div>'
          + '<div style="display:flex;gap:6px;flex-shrink:0">'
          + '<button class="fw-prod-edit" style="padding:6px 14px;font-size:11px;letter-spacing:1px;text-transform:uppercase;font-family:var(--body);cursor:pointer;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.12);color:rgba(255,255,255,.6);border-radius:2px">Edit</button>'
          + '<button class="fw-prod-del" style="padding:6px 14px;font-size:11px;letter-spacing:1px;text-transform:uppercase;font-family:var(--body);cursor:pointer;background:rgba(231,76,60,.15);border:1px solid rgba(231,76,60,.4);color:#e74c3c;border-radius:2px">Delete</button>'
          + '</div>';
        row.querySelector('.fw-prod-edit').addEventListener('click', (function(id){ return function(){ adminShowProductEditor(id); }; })(x.id));
        row.querySelector('.fw-prod-del').addEventListener('click', (function(id,title){ return function(){ adminDeleteProduct(id,title); }; })(x.id, x.title));
        el.appendChild(row);
      });
    })
    .catch(function(e){ console.error('[FW Admin] list-products:', e); el.innerHTML = '<div class="adm-empty">Failed to load.</div>'; });
}

function prodResetForm() {
  ['prodId','prodCategory','prodFeature','prodDesc','prodWaMsg','prodColors','prodSizes','prodThumbId'].forEach(function(id){ document.getElementById(id).value = ''; });
  document.getElementById('prodTitle').value = '';
  document.getElementById('prodPrice').value = '';
  document.getElementById('prodOrigPrice').value = '';
  document.getElementById('prodStock').value = 'in-stock';
  document.getElementById('prodOrder').value = '0';
  document.getElementById('prodPostStatus').value = 'publish';
  document.getElementById('prodThumbPreview').style.display = 'none';
  document.getElementById('prodThumbName').textContent = '';
  document.getElementById('adminProductMsg').textContent = '';
}

function adminShowProductEditor(id) {
  prodResetForm();
  document.getElementById('adminProductEditor').style.display = 'block';
  document.getElementById('adminProductEditor').scrollIntoView({ behavior: 'smooth', block: 'start' });
  if (!id) return;

  document.getElementById('adminProductMsg').textContent = 'Loading product...';
  fetch(_admRest + '/admin/get-product?id=' + id, { headers: { 'Authorization': 'Bearer ' + _admToken } })
    .then(function(r){ return r.json(); })
    .then(function(d){
      document.getElementById('adminProductMsg').textContent = '';
      if (!d.success) { alert(d.message || 'Could not load product.'); return; }
      var p = d.product;
      document.getElementById('prodId').value = p.id;
      document.getElementById('prodTitle').value = p.title || '';
      document.getElementById('prodPrice').value = p.fw_prod_price || '';
      document.getElementById('prodOrigPrice').value = p.fw_prod_orig_price || '';
      document.getElementById('prodCategory').value = p.fw_prod_category || '';
      document.getElementById('prodStock').value = p.fw_prod_stock || 'in-stock';
      document.getElementById('prodOrder').value = p.fw_prod_order || '0';
      document.getElementById('prodFeature').value = p.fw_prod_feature || '';
      document.getElementById('prodDesc').value = p.fw_prod_desc || '';
      document.getElementById('prodWaMsg').value = p.fw_prod_wa_msg || '';
      document.getElementById('prodColors').value = p.fw_prod_colors || '';
      document.getElementById('prodSizes').value = p.fw_prod_sizes || '';
      document.getElementById('prodPostStatus').value = p.post_status === 'draft' ? 'draft' : 'publish';
      if (p.thumbnail_id) {
        document.getElementById('prodThumbId').value = p.thumbnail_id;
        document.getElementById('prodThumbPreview').src = p.thumbnail_url;
        document.getElementById('prodThumbPreview').style.display = 'block';
        document.getElementById('prodThumbName').textContent = 'Current image';
      }
    })
    .catch(function(){ document.getElementById('adminProductMsg').textContent = 'Failed to load product.'; document.getElementById('adminProductMsg').style.color = '#f87171'; });
}

function prodUploadThumb(input) {
  if (!input.files[0]) return;
  var fd = new FormData();
  fd.append('photo', input.files[0]);
  fetch(_admRest + '/admin/upload-content-image', { method: 'POST', headers: { 'Authorization': 'Bearer ' + _admToken }, body: fd })
    .then(function(r){ return r.json(); })
    .then(function(d){
      if (d.success) {
        document.getElementById('prodThumbId').value = d.id;
        document.getElementById('prodThumbPreview').src = d.url;
        document.getElementById('prodThumbPreview').style.display = 'block';
        document.getElementById('prodThumbName').textContent = '✓ Uploaded';
        document.getElementById('prodThumbName').style.color = '#4ade80';
      }
    });
}

function adminSaveProduct() {
  var title = document.getElementById('prodTitle').value.trim();
  var msg = document.getElementById('adminProductMsg');
  if (!title) { msg.textContent = 'Title is required.'; msg.style.color = '#f87171'; return; }

  var payload = {
    id: document.getElementById('prodId').value,
    title: title,
    post_status: document.getElementById('prodPostStatus').value,
    fw_prod_price: document.getElementById('prodPrice').value,
    fw_prod_orig_price: document.getElementById('prodOrigPrice').value,
    fw_prod_category: document.getElementById('prodCategory').value,
    fw_prod_stock: document.getElementById('prodStock').value,
    fw_prod_order: document.getElementById('prodOrder').value,
    fw_prod_feature: document.getElementById('prodFeature').value,
    fw_prod_desc: document.getElementById('prodDesc').value,
    fw_prod_wa_msg: document.getElementById('prodWaMsg').value,
    fw_prod_colors: document.getElementById('prodColors').value,
    fw_prod_sizes: document.getElementById('prodSizes').value,
    thumbnail_id: document.getElementById('prodThumbId').value
  };

  msg.textContent = 'Saving...'; msg.style.color = 'rgba(255,255,255,.4)';
  fetch(_admRest + '/admin/save-product', {
    method: 'POST',
    headers: { 'Authorization': 'Bearer ' + _admToken, 'Content-Type': 'application/json' },
    body: JSON.stringify(payload)
  })
    .then(function(r){
      if (!r.ok) return r.text().then(function(t){ throw new Error(r.status + ': ' + t); });
      return r.json();
    })
    .then(function(d){
      if (d.success) {
        msg.textContent = 'Product saved!'; msg.style.color = '#4ade80';
        setTimeout(function(){ document.getElementById('adminProductEditor').style.display = 'none'; adminLoadProducts(); }, 1000);
      } else { msg.textContent = d.message || 'Error saving product.'; msg.style.color = '#f87171'; }
    })
    .catch(function(e){ msg.textContent = 'Error: ' + e.message; msg.style.color = '#f87171'; });
}

function adminDeleteProduct(id, title) {
  if (!confirm('Delete "' + (title || 'this product') + '"? This moves it to trash and it will disappear from the live site.')) return;
  fetch(_admRest + '/admin/delete-product', {
    method: 'POST',
    headers: { 'Authorization': 'Bearer ' + _admToken, 'Content-Type': 'application/json' },
    body: JSON.stringify({ id: id })
  })
    .then(function(r){ return r.json(); })
    .then(function(d){ if (d.success) adminLoadProducts(); else alert(d.message || 'Could not delete.'); })
    .catch(function(){ alert('Error deleting product.'); });
}

/* ══════════════════════════════════════════════════════════════════════
   NOTIFICATIONS / CAMPAIGNS
   ══════════════════════════════════════════════════════════════════════ */
var _campLoaded = false;
var _campAudience = [];
var _campTripData = {};
var _campSending = false;

function loadCampaignsTab() {
  if (_campLoaded) return;
  _campLoaded = true;

  fetch(_admRest + '/admin/campaign-audience', { headers: h() })
    .then(function(r){ return r.json(); })
    .then(function(d){
      if (d.success) {
        _campAudience = d.audience || [];
        document.getElementById('campAudienceCount').textContent = d.count;
      } else {
        document.getElementById('campAudienceCount').textContent = '0';
      }
    })
    .catch(function(){ document.getElementById('campAudienceCount').textContent = '?'; });

  fetch(_admRest + '/admin/campaign-trip-picker', { headers: h() })
    .then(function(r){ return r.json(); })
    .then(function(d){
      var wrap = document.getElementById('campTripPicker');
      if (!d.success || !d.expeditions || !d.expeditions.length) {
        wrap.innerHTML = '<span style="font-size:12px;color:rgba(255,255,255,.4)">No published expeditions found.</span>';
        return;
      }
      _campTripData = {};
      wrap.innerHTML = '';
      d.expeditions.forEach(function(e) {
        _campTripData[e.id] = e;
        var row = document.createElement('div');
        row.style.cssText = 'background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.1);border-radius:8px;padding:10px 14px;margin-bottom:8px';
        var priceStr = e.price ? ('₹' + e.price + ' ' + (e.price_unit || 'per person')) : 'no price set';
        row.innerHTML = '<label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:13px;color:#fff">'
          + '<input type="checkbox" class="campTripCheck" value="' + e.id + '" style="accent-color:var(--rust)">'
          + '<span style="flex:1">' + String(e.title).replace(/</g,'&lt;') + '</span>'
          + '<span style="font-size:11px;color:rgba(255,255,255,.4)">' + (e.dates || '') + (e.dates && priceStr ? ' · ' : '') + priceStr + '</span>'
          + '</label>'
          + '<input type="text" class="campTripBadges" data-id="' + e.id + '" placeholder="Extra badge, e.g. 4x4 Required (comma separated for more)" class="adm-input" style="margin-top:8px;display:none;font-size:12px;padding:6px 10px">';
        var cb = row.querySelector('.campTripCheck');
        var badgeInput = row.querySelector('.campTripBadges');
        badgeInput.className = 'adm-input campTripBadges';
        cb.addEventListener('change', function(){ badgeInput.style.display = cb.checked ? 'block' : 'none'; });
        wrap.appendChild(row);
      });
    })
    .catch(function(){
      document.getElementById('campTripPicker').innerHTML = '<span style="font-size:12px;color:#f87171">Failed to load expeditions.</span>';
    });
}

function campCollectTripSelection() {
  var ids = [];
  var meta = {};
  document.querySelectorAll('.campTripCheck:checked').forEach(function(cb){
    var id = cb.value;
    ids.push(parseInt(id, 10));
    var badgeInput = document.querySelector('.campTripBadges[data-id="' + id + '"]');
    var badges = badgeInput && badgeInput.value.trim() ? badgeInput.value.split(',').map(function(s){ return s.trim(); }).filter(Boolean) : [];
    meta[id] = { blurb: '', badges: badges };
  });
  return { ids: ids, meta: meta };
}

function campPreviewCards() {
  var sel = campCollectTripSelection();
  var el = document.getElementById('campCardPreview');
  if (!sel.ids.length) { el.innerHTML = '<div style="font-size:12px;color:rgba(255,255,255,.4)">Select at least one expedition above to preview its card.</div>'; return; }

  el.innerHTML = '<div style="background:#0f0d0b;border-radius:12px;padding:20px">' + sel.ids.map(function(id){
    var e = _campTripData[id];
    if (!e) return '';
    var meta = sel.meta[id] || { badges: [] };
    var badges = ['Self Drive'].concat(e.max_slots_badge ? [e.max_slots_badge] : []).concat(meta.badges);
    var badgesHtml = badges.map(function(b){ return '<span style="display:inline-block;background:rgba(232,160,32,.15);border:1px solid rgba(232,160,32,.4);color:#e8a020;font-size:10px;font-weight:bold;letter-spacing:.4px;text-transform:uppercase;padding:3px 8px;border-radius:20px;margin:0 5px 5px 0">' + b + '</span>'; }).join('');
    var priceRows = ['Self Drive:price', 'Couple Discount:couple_price', 'Seat Sharing:seat_price'].map(function(pair){
      var parts = pair.split(':'); var label = parts[0]; var key = parts[1];
      if (!e[key]) return '';
      return '<tr><td style="padding:4px 0;color:rgba(255,255,255,.7);font-size:12px">' + label + '</td><td style="padding:4px 0;text-align:right;color:#fff;font-size:13px;font-weight:bold">₹' + e[key] + '</td></tr>';
    }).join('');
    return '<div style="background:rgba(232,160,32,.06);border:1px solid rgba(232,160,32,.3);border-radius:12px;padding:16px;margin-bottom:12px">'
      + '<div>' + badgesHtml + '</div>'
      + '<div style="color:#fff;font-size:16px;font-weight:bold;margin:8px 0 2px">' + e.title + '</div>'
      + (e.dates ? '<div style="color:#e8a020;font-size:12px;font-weight:600;margin-bottom:10px">' + e.dates + '</div>' : '')
      + (priceRows ? '<table style="width:100%;background:rgba(0,0,0,.25);border-radius:8px;padding:8px 12px">' + priceRows + '</table>' : '')
      + '</div>';
  }).join('') + '</div>';
}

function campUploadAsset(input, kind) {
  if (!input.files || !input.files[0]) return;
  var fd = new FormData();
  fd.append('file', input.files[0]);
  var previewEl = document.getElementById(kind === 'image' ? 'campImagePreview' : 'campPdfPreview');
  previewEl.textContent = 'Uploading...';

  var headers = {};
  if (_admToken) headers['Authorization'] = 'Bearer ' + _admToken;

  fetch(_admRest + '/admin/campaign-upload', { method: 'POST', headers: headers, body: fd })
    .then(function(r){
      if (!r.ok) return r.text().then(function(t){ throw new Error(r.status + ': ' + t); });
      return r.json();
    })
    .then(function(d){
      if (!d.success) { previewEl.textContent = d.message || 'Upload failed.'; previewEl.style.color = '#f87171'; return; }
      if (kind === 'image') {
        document.getElementById('campImageUrl').value = d.url;
        previewEl.innerHTML = '<img src="' + d.url + '" style="max-width:100%;max-height:80px;border-radius:4px;display:block;margin-top:4px">';
      } else {
        document.getElementById('campPdfUrl').value = d.url;
        previewEl.textContent = 'Uploaded: ' + d.url.split('/').pop();
        previewEl.style.color = '#4ade80';
        document.getElementById('campPdfLabel').style.display = 'block';
      }
    })
    .catch(function(e){ previewEl.textContent = 'Error: ' + e.message; previewEl.style.color = '#f87171'; });
}

function campExportWhatsapp() {
  var msg = document.getElementById('campMsg');
  msg.textContent = 'Loading...'; msg.style.color = 'rgba(255,255,255,.6)';
  fetch(_admRest + '/admin/whatsapp-export', { headers: h() })
    .then(function(r){ return r.json(); })
    .then(function(d){
      if (!d.success) { msg.textContent = 'Failed to export.'; msg.style.color = '#f87171'; return; }
      if (!d.count) { msg.textContent = 'No WhatsApp numbers on file.'; msg.style.color = 'rgba(255,255,255,.5)'; return; }
      navigator.clipboard.writeText(d.csv).then(function(){
        msg.textContent = 'Copied ' + d.count + ' WhatsApp numbers to clipboard.'; msg.style.color = '#4ade80';
      }).catch(function(){
        msg.textContent = d.count + ' numbers: ' + d.csv; msg.style.color = 'rgba(255,255,255,.7)';
      });
    })
    .catch(function(){ msg.textContent = 'Error exporting.'; msg.style.color = '#f87171'; });
}

function campSendTest() {
  var testEmail = document.getElementById('campTestEmail').value.trim();
  var msg = document.getElementById('campTestMsg');
  if (!testEmail) { msg.textContent = 'Enter an email address first.'; msg.style.color = '#f87171'; return; }

  var subject = document.getElementById('campSubject').value.trim();
  var body = document.getElementById('campBody').value.trim();
  if (!subject || !body) { msg.textContent = 'Subject and message are required.'; msg.style.color = '#f87171'; return; }

  var sel = campCollectTripSelection();
  var payload = {
    test_email: testEmail,
    subject: subject,
    body: body,
    expedition_ids: sel.ids,
    trip_meta: sel.meta,
    image_url: document.getElementById('campImageUrl').value,
    pdf_url: document.getElementById('campPdfUrl').value,
    pdf_label: document.getElementById('campPdfLabel').value,
    cta_url: document.getElementById('campCtaUrl').value,
    cta_label: document.getElementById('campCtaLabel').value
  };

  var btn = document.getElementById('campTestBtn');
  btn.disabled = true;
  msg.textContent = 'Sending test...'; msg.style.color = 'rgba(255,255,255,.5)';

  fetch(_admRest + '/admin/send-test-campaign', {
    method: 'POST',
    headers: { 'Authorization': 'Bearer ' + _admToken, 'Content-Type': 'application/json' },
    body: JSON.stringify(payload)
  })
    .then(function(r){
      if (!r.ok) return r.json().then(function(d){ throw new Error(d.message || ('HTTP ' + r.status)); });
      return r.json();
    })
    .then(function(d){
      btn.disabled = false;
      if (d.success) { msg.textContent = 'Test sent to ' + testEmail + '. Check the inbox (and spam folder).'; msg.style.color = '#4ade80'; }
      else { msg.textContent = d.message || 'Could not send test.'; msg.style.color = '#f87171'; }
    })
    .catch(function(e){ btn.disabled = false; msg.textContent = 'Error: ' + e.message; msg.style.color = '#f87171'; });
}

function campSend() {
  if (_campSending) return;

  var subject = document.getElementById('campSubject').value.trim();
  var body    = document.getElementById('campBody').value.trim();
  var msg     = document.getElementById('campMsg');
  var progressEl = document.getElementById('campProgress');

  if (!subject || !body) { msg.textContent = 'Subject and message are required.'; msg.style.color = '#f87171'; return; }
  if (!_campAudience.length) { msg.textContent = 'No recipients to send to.'; msg.style.color = '#f87171'; return; }

  var sel = campCollectTripSelection();
  var payloadExtra = {
    expedition_ids: sel.ids,
    trip_meta:  sel.meta,
    image_url:  document.getElementById('campImageUrl').value,
    pdf_url:    document.getElementById('campPdfUrl').value,
    pdf_label:  document.getElementById('campPdfLabel').value,
    cta_url:    document.getElementById('campCtaUrl').value,
    cta_label:  document.getElementById('campCtaLabel').value,
  };

  if (!confirm('Send this notification to ' + _campAudience.length + ' recipients? This cannot be undone.')) return;

  _campSending = true;
  document.getElementById('campSendBtn').disabled = true;
  document.getElementById('campSendBtn').style.opacity = '0.5';
  msg.textContent = ''; msg.style.color = '';

  var BATCH = 20;
  var batches = [];
  for (var i = 0; i < _campAudience.length; i += BATCH) batches.push(_campAudience.slice(i, i + BATCH));

  var totalSent = 0, totalFailed = 0, idx = 0;

  function sendNext() {
    if (idx >= batches.length) {
      // All done — log the campaign
      fetch(_admRest + '/admin/log-campaign', {
        method: 'POST', headers: h(),
        body: JSON.stringify({ subject: subject, body: body, sent: totalSent, failed: totalFailed, expedition_ids: sel.ids })
      }).finally(function(){
        _campSending = false;
        document.getElementById('campSendBtn').disabled = false;
        document.getElementById('campSendBtn').style.opacity = '1';
        progressEl.textContent = '';
        msg.textContent = 'Done — sent to ' + totalSent + ' recipient' + (totalSent !== 1 ? 's' : '') + (totalFailed ? ', ' + totalFailed + ' failed' : '') + '.';
        msg.style.color = totalFailed ? '#e8a020' : '#4ade80';
      });
      return;
    }

    progressEl.textContent = 'Sending batch ' + (idx + 1) + ' of ' + batches.length + ' (' + totalSent + ' sent so far)...';

    var body_payload = Object.assign({ emails: batches[idx], subject: subject, body: body }, payloadExtra);

    fetch(_admRest + '/admin/send-campaign-batch', { method: 'POST', headers: h(), body: JSON.stringify(body_payload) })
      .then(function(r){ return r.json(); })
      .then(function(d){
        if (d.success) { totalSent += d.sent; totalFailed += d.failed; }
        else { totalFailed += batches[idx].length; }
        idx++;
        sendNext();
      })
      .catch(function(){
        totalFailed += batches[idx].length;
        idx++;
        sendNext();
      });
  }

  sendNext();
}

/* ── Manual subscriber add (WhatsApp/in-person contacts) ── */
function subAddSubmit() {
  var name   = document.getElementById('subAddName').value.trim();
  var city   = document.getElementById('subAddCity').value.trim();
  var email  = document.getElementById('subAddEmail').value.trim();
  var mobile = document.getElementById('subAddMobile').value.trim();
  var msg    = document.getElementById('subAddMsg');

  if (!email && !mobile) { msg.textContent = 'Enter an email or phone number.'; msg.style.color = '#f87171'; return; }

  msg.textContent = 'Adding...'; msg.style.color = 'rgba(255,255,255,.6)';

  fetch(_admRest + '/admin/subscriber-add', {
    method: 'POST', headers: h(),
    body: JSON.stringify({ name: name, city: city, email: email, mobile: mobile })
  })
    .then(function(r){ return r.json(); })
    .then(function(d){
      if (d.success) {
        msg.textContent = d.message || 'Added.'; msg.style.color = '#4ade80';
        document.getElementById('subAddName').value = '';
        document.getElementById('subAddCity').value = '';
        document.getElementById('subAddEmail').value = '';
        document.getElementById('subAddMobile').value = '';
        _campLoaded = false; /* force recipient count to refresh next time tab is viewed */
      } else {
        msg.textContent = d.message || 'Could not add subscriber.'; msg.style.color = '#f87171';
      }
    })
    .catch(function(){ msg.textContent = 'Error adding subscriber.'; msg.style.color = '#f87171'; });
}
