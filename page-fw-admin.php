<?php
/* Template Name: FW Admin */
if (!current_user_can('manage_options')) {
    // Will also check via JS with Supabase token
}
get_header();
?>
<style>
*{box-sizing:border-box}
.adm-wrap{min-height:100vh;background:#080705;padding:80px 0 60px}
.adm-inner{max-width:1300px;margin:0 auto;padding:0 24px}
.adm-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:32px;flex-wrap:wrap;gap:12px}
.adm-title{font-family:var(--headline);font-size:32px;color:#fff;letter-spacing:2px}
.adm-title span{color:var(--rust)}
.adm-tabs{display:flex;gap:0;border-bottom:1px solid rgba(255,255,255,.1);margin-bottom:28px;overflow-x:auto}
.adm-tab{padding:12px 20px;font-size:11px;letter-spacing:2px;text-transform:uppercase;color:rgba(255,255,255,.4);cursor:pointer;border-bottom:2px solid transparent;white-space:nowrap;transition:all .2s;background:none;border-top:none;border-left:none;border-right:none;font-family:var(--body)}
.adm-tab.active{color:#fff;border-bottom-color:var(--rust)}
.adm-tab:hover{color:rgba(255,255,255,.8)}
.adm-panel{display:none}
.adm-panel.active{display:block}
.adm-card{background:#0f0d0b;border:1px solid rgba(255,255,255,.08);border-radius:3px;padding:20px;margin-bottom:14px}
.adm-card-head{display:flex;align-items:flex-start;justify-content:space-between;gap:12px;flex-wrap:wrap}
.adm-badge{font-size:10px;letter-spacing:1px;text-transform:uppercase;padding:3px 10px;border-radius:2px;white-space:nowrap}
.badge-pending{background:rgba(232,160,32,.15);color:#e8a020;border:1px solid rgba(232,160,32,.3)}
.badge-approved,.badge-published{background:rgba(74,222,128,.12);color:#4ade80;border:1px solid rgba(74,222,128,.25)}
.badge-rejected{background:rgba(248,113,113,.1);color:#f87171;border:1px solid rgba(248,113,113,.2)}
.adm-btn{padding:7px 14px;font-size:11px;letter-spacing:1px;text-transform:uppercase;border:none;cursor:pointer;border-radius:2px;font-family:var(--body);transition:all .2s}
.btn-approve{background:rgba(74,222,128,.15);color:#4ade80;border:1px solid rgba(74,222,128,.3)}
.btn-approve:hover{background:rgba(74,222,128,.3)}
.btn-reject{background:rgba(248,113,113,.1);color:#f87171;border:1px solid rgba(248,113,113,.2)}
.btn-reject:hover{background:rgba(248,113,113,.2)}
.btn-save{background:var(--rust);color:#fff}
.btn-save:hover{background:#a03508}
.btn-secondary{background:rgba(255,255,255,.08);color:rgba(255,255,255,.7);border:1px solid rgba(255,255,255,.12)}
.btn-secondary:hover{background:rgba(255,255,255,.15)}
.adm-input{width:100%;padding:9px 12px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.12);color:#fff;font-family:var(--body);font-size:13px;border-radius:2px;outline:none}
.adm-input:focus{border-color:rgba(193,68,14,.5)}
.adm-select{width:100%;padding:9px 12px;background:#0f0d0b;border:1px solid rgba(255,255,255,.12);color:#fff;font-family:var(--body);font-size:13px;border-radius:2px;outline:none;cursor:pointer}
.adm-label{font-size:10px;letter-spacing:1px;text-transform:uppercase;color:rgba(255,255,255,.4);margin-bottom:5px;display:block}
.adm-grid-2{display:grid;grid-template-columns:1fr 1fr;gap:12px}
.adm-grid-3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px}
.adm-meta{font-size:12px;color:rgba(255,255,255,.35);margin-top:6px}
.adm-text{font-size:13px;color:rgba(255,255,255,.7);line-height:1.6}
.adm-section-title{font-family:var(--headline);font-size:18px;color:#fff;letter-spacing:1px;margin-bottom:16px;display:flex;align-items:center;gap:10px}
.adm-count{background:var(--rust);color:#fff;font-size:10px;padding:2px 8px;border-radius:10px;font-family:var(--body)}
.adm-search{display:flex;gap:10px;margin-bottom:20px}
.adm-search input{flex:1}
.adm-stats-row{display:flex;gap:16px;margin-bottom:24px;flex-wrap:wrap}
.adm-stat-box{background:#0f0d0b;border:1px solid rgba(255,255,255,.08);border-radius:3px;padding:18px 22px;flex:1;min-width:120px}
.adm-stat-n{font-family:var(--headline);font-size:36px;color:var(--amber)}
.adm-stat-l{font-size:10px;letter-spacing:2px;text-transform:uppercase;color:rgba(255,255,255,.35);margin-top:4px}
.adm-filter-row{display:flex;gap:8px;margin-bottom:16px;flex-wrap:wrap}
.adm-filter-btn{padding:6px 14px;font-size:10px;letter-spacing:1px;text-transform:uppercase;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.1);color:rgba(255,255,255,.5);cursor:pointer;border-radius:2px;font-family:var(--body)}
.adm-filter-btn.active{background:rgba(193,68,14,.2);border-color:var(--rust);color:#fff}
.adm-reject-row{display:none;margin-top:10px;gap:8px}
.adm-reject-row.open{display:flex}
.adm-empty{color:rgba(255,255,255,.3);font-size:13px;padding:30px;text-align:center}
.adm-booking-form{background:#0f0d0b;border:1px solid rgba(193,68,14,.25);border-radius:3px;padding:24px;margin-bottom:20px;display:none}
.adm-booking-form.open{display:block}
.adm-toast{position:fixed;bottom:24px;right:24px;background:#0f0d0b;border:1px solid rgba(255,255,255,.2);color:#fff;padding:12px 20px;border-radius:3px;font-size:13px;z-index:9999;display:none}
.adm-toast.show{display:block}
.adm-toast.err{border-color:#f87171;color:#f87171}
.adm-user-row{display:flex;align-items:center;gap:12px;padding:14px 0;border-bottom:1px solid rgba(255,255,255,.06)}
.adm-user-avatar{width:38px;height:38px;border-radius:50%;background:rgba(193,68,14,.2);border:2px solid rgba(193,68,14,.4);display:flex;align-items:center;justify-content:center;font-family:var(--headline);font-size:14px;color:var(--rust);flex-shrink:0}
.adm-spinner{text-align:center;padding:40px;color:rgba(255,255,255,.3);font-size:13px;letter-spacing:2px}
@media(max-width:700px){.adm-grid-2,.adm-grid-3{grid-template-columns:1fr}.adm-title{font-size:24px}}
</style>

<!-- Auth gate -->
<div id="admGate" style="min-height:100vh;background:#080705;display:flex;align-items:center;justify-content:center">
  <div style="text-align:center;padding:40px">
    <div style="font-size:48px;margin-bottom:16px">🔒</div>
    <div style="font-family:var(--headline);font-size:24px;color:#fff;margin-bottom:8px">Admin Access Only</div>
    <div style="font-size:13px;color:rgba(255,255,255,.4);margin-bottom:24px">You must be a FreeWheel admin to view this page.</div>
    <a href="<?php echo esc_url(home_url('/login/')); ?>" style="display:inline-block;padding:12px 28px;background:var(--rust);color:#fff;text-decoration:none;font-family:var(--headline);font-size:16px;letter-spacing:2px;border-radius:2px">LOG IN</a>
  </div>
</div>

<!-- Admin Dashboard -->
<div id="admDash" style="display:none">
<div class="adm-wrap">
  <div class="adm-inner">

    <div class="adm-header">
      <div style="display:flex;align-items:center;gap:14px">
        <div id="admAvatarWrap" style="width:42px;height:42px;border-radius:50%;border:2px solid rgba(193,68,14,.4);background:rgba(193,68,14,.15);display:flex;align-items:center;justify-content:center;font-family:var(--headline);font-size:18px;color:var(--rust);overflow:hidden;flex-shrink:0">
          <span id="admAvatarInitial">M</span>
        </div>
        <div>
          <div class="adm-title" style="margin:0">FW <span>Admin</span></div>
          <div id="admWelcome" style="font-size:11px;color:rgba(255,255,255,.35);margin-top:2px;letter-spacing:1px"></div>
        </div>
      </div>

    </div>

    <!-- Stats -->
    <div class="adm-stats-row">
      <div class="adm-stat-box"><div class="adm-stat-n" id="admStatPending">–</div><div class="adm-stat-l">Pending Approval</div></div>
      <div class="adm-stat-box"><div class="adm-stat-n" id="admStatBookings">–</div><div class="adm-stat-l">Total Bookings</div></div>
      <div class="adm-stat-box"><div class="adm-stat-n" id="admStatOrders">–</div><div class="adm-stat-l">Total Orders</div></div>
      <div class="adm-stat-box"><div class="adm-stat-n" id="admStatUsers">–</div><div class="adm-stat-l">Members</div></div>
    </div>

    <!-- Tabs -->
    <div class="adm-tabs">
      <button class="adm-tab active" onclick="admTab('content',this)">Content Approval</button>
      <button class="adm-tab" onclick="admTab('bookings',this)">Bookings</button>
      <button class="adm-tab" onclick="admTab('orders',this)">Orders</button>
      <button class="adm-tab" onclick="admTab('users',this)">Members</button>
    </div>

    <!-- ── CONTENT APPROVAL ── -->
    <div id="panel-content" class="adm-panel active">

      <!-- BLOGS -->
      <div class="adm-section-title">Blogs <span class="adm-count" id="blogCount">0</span></div>
      <div class="adm-filter-row">
        <button class="adm-filter-btn active" onclick="filterContent('blogs','pending',this)">Pending</button>
        <button class="adm-filter-btn" onclick="filterContent('blogs','published',this)">Published</button>
        <button class="adm-filter-btn" onclick="filterContent('blogs','rejected',this)">Rejected</button>
      </div>
      <div id="blogList"><div class="adm-spinner">Loading...</div></div>

      <!-- TESTIMONIALS -->
      <div class="adm-section-title" style="margin-top:32px">Testimonials <span class="adm-count" id="testiCount">0</span></div>
      <div class="adm-filter-row">
        <button class="adm-filter-btn active" onclick="filterContent('testis','pending',this)">Pending</button>
        <button class="adm-filter-btn" onclick="filterContent('testis','approved',this)">Approved</button>
        <button class="adm-filter-btn" onclick="filterContent('testis','rejected',this)">Rejected</button>
      </div>
      <div id="testiList"><div class="adm-spinner">Loading...</div></div>

      <!-- ALBUMS -->
      <div class="adm-section-title" style="margin-top:32px">Albums <span class="adm-count" id="albumCount">0</span></div>
      <div class="adm-filter-row">
        <button class="adm-filter-btn active" onclick="filterContent('albums','pending',this)">Pending</button>
        <button class="adm-filter-btn" onclick="filterContent('albums','published',this)">Published</button>
        <button class="adm-filter-btn" onclick="filterContent('albums','rejected',this)">Rejected</button>
      </div>
      <div id="albumList"><div class="adm-spinner">Loading...</div></div>
    </div>

    <!-- ── BOOKINGS ── -->
    <div id="panel-bookings" class="adm-panel">
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;flex-wrap:wrap;gap:10px">
        <div class="adm-section-title" style="margin:0">Bookings</div>
        <button onclick="openNewBooking()" class="adm-btn btn-save">+ New Booking</button>
      </div>
      <div id="newBookingForm" class="adm-booking-form">
        <div style="font-size:11px;letter-spacing:2px;color:var(--rust);text-transform:uppercase;margin-bottom:18px">New Booking</div>
        <input type="hidden" id="bkId" value="">
        <div class="adm-grid-2" style="margin-bottom:12px">
          <div><label class="adm-label">Trip ID</label><input class="adm-input" id="bkTripId" placeholder="nepal / leh / spiti / adikailash"></div>
          <div><label class="adm-label">Trip Title</label><input class="adm-input" id="bkTripTitle" placeholder="Full trip name"></div>
          <div><label class="adm-label">Dates</label><input class="adm-input" id="bkDates" placeholder="23 May – 30 May 2026"></div>
          <div><label class="adm-label">Status</label>
            <select class="adm-select" id="bkStatus">
              <option value="inquiry">Inquiry</option>
              <option value="contacted">Contacted</option>
              <option value="confirmed">Confirmed</option>
              <option value="deposit_received">Deposit Received</option>
              <option value="fully_paid">Fully Paid</option>
              <option value="completed">Completed</option>
              <option value="cancelled">Cancelled</option>
            </select>
          </div>
          <div><label class="adm-label">Contact Name</label><input class="adm-input" id="bkContactName" placeholder="Full name"></div>
          <div><label class="adm-label">Contact Phone</label><input class="adm-input" id="bkContactPhone" placeholder="9876543210"></div>
          <div><label class="adm-label">Contact Email</label><input class="adm-input" id="bkContactEmail" placeholder="email@example.com"></div>
          <div><label class="adm-label">Seats</label><input class="adm-input" id="bkSeats" type="number" value="1" min="1"></div>
          <div><label class="adm-label">Total Amount (₹)</label><input class="adm-input" id="bkTotal" type="number" placeholder="0"></div>
          <div><label class="adm-label">Paid Amount (₹)</label><input class="adm-input" id="bkPaid" type="number" placeholder="0"></div>
          <div><label class="adm-label">Payment Mode</label><input class="adm-input" id="bkPayMode" placeholder="UPI / Cash / Bank Transfer"></div>
          <div><label class="adm-label">Payment Ref / UTR</label><input class="adm-input" id="bkPayRef" placeholder="UTR or receipt no."></div>
          <div><label class="adm-label">Discount %</label><input class="adm-input" id="bkDisc" type="number" placeholder="0"></div>
          <div><label class="adm-label">WhatsApp Ref / Note</label><input class="adm-input" id="bkWA" placeholder="WA thread reference"></div>
        </div>
        <div style="margin-bottom:12px"><label class="adm-label">Link to Member (User ID or search below)</label><input class="adm-input" id="bkUserId" placeholder="Supabase user UUID (optional)"></div>
        <div style="margin-bottom:16px"><label class="adm-label">Notes</label><input class="adm-input" id="bkNotes" placeholder="Internal notes"></div>
        <div style="display:flex;gap:10px;flex-wrap:wrap">
          <button onclick="saveBooking()" class="adm-btn btn-save">SAVE BOOKING</button>
          <button onclick="document.getElementById('newBookingForm').classList.remove('open')" class="adm-btn btn-secondary">Cancel</button>
        </div>
        <div id="bkMsg" style="font-size:12px;margin-top:10px"></div>
      </div>
      <div class="adm-filter-row">
        <button class="adm-filter-btn active" onclick="filterBookings('',this)">All</button>
        <button class="adm-filter-btn" onclick="filterBookings('inquiry',this)">Inquiry</button>
        <button class="adm-filter-btn" onclick="filterBookings('confirmed',this)">Confirmed</button>
        <button class="adm-filter-btn" onclick="filterBookings('fully_paid',this)">Paid</button>
        <button class="adm-filter-btn" onclick="filterBookings('completed',this)">Completed</button>
        <button class="adm-filter-btn" onclick="filterBookings('cancelled',this)">Cancelled</button>
      </div>
      <div id="bookingList"><div class="adm-spinner">Loading...</div></div>
    </div>

    <!-- ── ORDERS ── -->
    <div id="panel-orders" class="adm-panel">
      <div class="adm-section-title">Merchandise Orders</div>
      <div class="adm-filter-row">
        <button class="adm-filter-btn active" onclick="filterOrders('all',this)">All</button>
        <button class="adm-filter-btn" onclick="filterOrders('inquiry',this)">Inquiry</button>
        <button class="adm-filter-btn" onclick="filterOrders('confirmed',this)">Confirmed</button>
        <button class="adm-filter-btn" onclick="filterOrders('dispatched',this)">Dispatched</button>
        <button class="adm-filter-btn" onclick="filterOrders('delivered',this)">Delivered</button>
      </div>
      <div id="orderList"><div class="adm-spinner">Loading...</div></div>
    </div>

    <!-- ── MEMBERS ── -->
    <div id="panel-users" class="adm-panel">
      <div class="adm-section-title">Members</div>
      <div class="adm-search">
        <input class="adm-input" id="userSearch" placeholder="Search by name, email or phone..." onkeydown="if(event.key==='Enter')searchUsers()">
        <button onclick="searchUsers()" class="adm-btn btn-save">Search</button>
        <button onclick="loadUsers()" class="adm-btn btn-secondary">All</button>
      </div>
      <div id="userList"><div class="adm-spinner">Loading...</div></div>

      <!-- Credit adjustment -->
      <div style="margin-top:28px;background:#0f0d0b;border:1px solid rgba(255,255,255,.08);border-radius:3px;padding:20px">
        <div class="adm-section-title" style="margin-bottom:14px">Manual Credit Adjustment</div>
        <div class="adm-grid-3" style="margin-bottom:12px">
          <div><label class="adm-label">User ID</label><input class="adm-input" id="adjUserId" placeholder="Paste from member list"></div>
          <div><label class="adm-label">Amount (+/-)</label><input class="adm-input" id="adjAmount" type="number" placeholder="e.g. 100 or -50"></div>
          <div><label class="adm-label">Reason</label><input class="adm-input" id="adjNote" placeholder="Reason for adjustment"></div>
        </div>
        <button onclick="adjustCredits()" class="adm-btn btn-save">APPLY ADJUSTMENT</button>
        <div id="adjMsg" style="font-size:12px;margin-top:10px"></div>
      </div>
    </div>

  </div>
</div>
</div>

<div class="adm-toast" id="admToast"></div>

<script>
/* ── Boot ── */
var _admToken = null;
var _admRest  = window.FW_AUTH ? FW_AUTH.rest_url : '/wp-json/freewheel/v1';
var _allContent = {blogs:[], testis:[], albums:[], bookings:[], orders:[]};

window.addEventListener('load', function() {
  /* Check WP admin first */
  var isWPAdmin = <?php echo current_user_can('manage_options') ? 'true' : 'false'; ?>;

  /* Also check Supabase session */
  var session = null;
  try { session = JSON.parse(localStorage.getItem('fw_session')||'null'); } catch(e){}

  if (!isWPAdmin && (!session || !session.access_token || session.expires_at < Date.now())) {
    return; /* gate stays visible */
  }

  if (session) _admToken = session.access_token;

  /* Verify admin access via API */
  console.log('[FW Admin] Checking access with token:', _admToken ? _admToken.slice(0,20)+'...' : 'NONE');
  fetch(_admRest + '/admin/check', { headers: _admToken ? {'Authorization':'Bearer '+_admToken} : {} })
    .then(function(r){ return r.json(); })
    .then(function(d){
      console.log('[FW Admin] Check result:', JSON.stringify(d));
      if (d.success && d.is_admin) {
        document.getElementById('admGate').style.display = 'none';
        document.getElementById('admDash').style.display = 'block';
        loadAll();
      } else {
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
  loadUsers();
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

function approveContent(type, id, action, noteId) {
  var note = noteId ? (document.getElementById(noteId)||{}).value||'' : '';
  fetch(_admRest + '/admin/approve-content', {
    method:'POST', headers: h(),
    body: JSON.stringify({type:type, id:id, action:action, note:note})
  }).then(function(r){ return r.json(); })
    .then(function(d){
      if (d.success) {
        var label = action==='approve' ? 'Approved! Credits awarded to user.' : 'Rejected.';
        toast(label);
        /* Remove from local array immediately */
        var key = type==='blog' ? 'blogs' : type==='testimonial' ? 'testis' : 'albums';
        _allContent[key] = _allContent[key].filter(function(item){ return item.id !== id; });
        /* Reload fresh from server */
        loadContent();
        /* Auto-switch filter to pending to see remaining queue */
        setTimeout(function(){
          var pendingBtns = document.querySelectorAll('.adm-filter-row .adm-filter-btn');
          pendingBtns.forEach(function(btn){
            if(btn.textContent.trim()==='Pending') btn.click();
          });
        }, 800);
      }
      else toast(d.message||'Failed', true);
    }).catch(function(){ toast('Error', true); });
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
      ab.onclick = (function(id){ return function(){ approveContent('blog', id, 'approve'); }; })(b.id);
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
    cb.onclick = (function(id, nid){ return function(){ approveContent('blog', id, 'reject', nid); }; })(b.id, 'rn-'+b.id);
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
      ab.onclick = (function(id){ return function(){ approveContent('testimonial', id, 'approve'); }; })(t.id);
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
    cb.onclick = (function(id, nid){ return function(){ approveContent('testimonial', id, 'reject', nid); }; })(t.id, 'rn-'+t.id);
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
      approveBtn.onclick = (function(type, id){ return function(){ approveContent(type, id, 'approve'); }; })('album', a.id);
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
        if (!p.photo_url) return;
        var img = document.createElement('img');
        img.src = p.photo_url;
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
    confirmBtn.onclick = (function(type, id, noteId){ return function(){ approveContent(type, id, 'reject', noteId); }; })('album', a.id, 'rn-' + a.id);
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
  window.location.href = '<?php echo esc_js(home_url("/login/")); ?>';
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
    }
  } catch(e){}
})();
</script>

<?php get_footer(); ?>

