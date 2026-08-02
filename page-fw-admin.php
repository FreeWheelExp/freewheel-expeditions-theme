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
.adm-tab{padding:12px 20px;font-size:11px;letter-spacing:2px;text-transform:uppercase;color:rgba(255,255,255,.5);cursor:pointer;border-bottom:2px solid transparent;white-space:nowrap;transition:all .2s;background:none;border-top:none;border-left:none;border-right:none;font-family:var(--body)}
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
.adm-label{font-size:10px;letter-spacing:1px;text-transform:uppercase;color:rgba(255,255,255,.5);margin-bottom:5px;display:block}
.adm-grid-2{display:grid;grid-template-columns:1fr 1fr;gap:12px}
.adm-grid-3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px}
.adm-meta{font-size:12px;color:rgba(255,255,255,.5);margin-top:6px}
.adm-text{font-size:13px;color:rgba(255,255,255,.7);line-height:1.6}
.adm-section-title{font-family:var(--headline);font-size:18px;color:#fff;letter-spacing:1px;margin-bottom:16px;display:flex;align-items:center;gap:10px}
.adm-count{background:var(--rust);color:#fff;font-size:10px;padding:2px 8px;border-radius:10px;font-family:var(--body)}
.adm-search{display:flex;gap:10px;margin-bottom:20px}
.adm-search input{flex:1}
.adm-stats-row{display:flex;gap:16px;margin-bottom:24px;flex-wrap:wrap}
.adm-stat-box{background:#0f0d0b;border:1px solid rgba(255,255,255,.08);border-radius:3px;padding:18px 22px;flex:1;min-width:120px}
.adm-stat-n{font-family:var(--headline);font-size:36px;color:var(--amber)}
.adm-stat-l{font-size:10px;letter-spacing:2px;text-transform:uppercase;color:rgba(255,255,255,.5);margin-top:4px}
.adm-filter-row{display:flex;gap:8px;margin-bottom:16px;flex-wrap:wrap}
.adm-filter-btn{padding:6px 14px;font-size:10px;letter-spacing:1px;text-transform:uppercase;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.1);color:rgba(255,255,255,.5);cursor:pointer;border-radius:2px;font-family:var(--body)}
.adm-filter-btn.active{background:rgba(193,68,14,.2);border-color:var(--rust);color:#fff}
.adm-reject-row{display:none;margin-top:10px;gap:8px}
.adm-reject-row.open{display:flex}
.adm-empty{color:rgba(255,255,255,.45);font-size:13px;padding:30px;text-align:center}
.adm-booking-form{background:#0f0d0b;border:1px solid rgba(193,68,14,.25);border-radius:3px;padding:24px;margin-bottom:20px;display:none}
.adm-booking-form.open{display:block}
.adm-toast{position:fixed;bottom:24px;right:24px;background:#0f0d0b;border:1px solid rgba(255,255,255,.2);color:#fff;padding:12px 20px;border-radius:3px;font-size:13px;z-index:9999;display:none}
.adm-toast.show{display:block}
.adm-toast.err{border-color:#f87171;color:#f87171}
.adm-user-row{display:flex;align-items:center;gap:12px;padding:14px 0;border-bottom:1px solid rgba(255,255,255,.06)}
.adm-user-avatar{width:38px;height:38px;border-radius:50%;background:rgba(193,68,14,.2);border:2px solid rgba(193,68,14,.4);display:flex;align-items:center;justify-content:center;font-family:var(--headline);font-size:14px;color:var(--rust);flex-shrink:0}
.adm-spinner{text-align:center;padding:40px;color:rgba(255,255,255,.45);font-size:13px;letter-spacing:2px}
@media(max-width:700px){.adm-grid-2,.adm-grid-3{grid-template-columns:1fr}.adm-title{font-size:24px}}
</style>

<!-- Auth gate -->
<div id="admGate" style="min-height:100vh;background:#080705;display:flex;align-items:center;justify-content:center">
  <div style="text-align:center;padding:40px">
    <div style="font-size:48px;margin-bottom:16px">🔒</div>
    <div style="font-family:var(--headline);font-size:24px;color:#fff;margin-bottom:8px">Admin Access Only</div>
    <div style="font-size:13px;color:rgba(255,255,255,.5);margin-bottom:24px">You must be a FreeWheel admin to view this page.</div>
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
          <div class="adm-title" style="margin:0">FW <span id="admRoleLabel">Admin</span></div>
          <div id="admWelcome" style="font-size:11px;color:rgba(255,255,255,.5);margin-top:2px;letter-spacing:1px"></div>
        </div>
      </div>

    </div>

    <!-- Stats -->
    <div class="adm-stats-row">
      <div class="adm-stat-box"><div class="adm-stat-n" id="admStatPending">–</div><div class="adm-stat-l">Pending Approval</div></div>
      <div class="adm-stat-box"><div class="adm-stat-n" id="admStatBookings">–</div><div class="adm-stat-l">Total Bookings</div></div>
      <div class="adm-stat-box"><div class="adm-stat-n" id="admStatOrders">–</div><div class="adm-stat-l">Total Orders</div></div>
      <div class="adm-stat-box"><div class="adm-stat-n" id="admStatUsers">–</div><div class="adm-stat-l">Members</div></div>
      <div class="adm-stat-box"><div class="adm-stat-n" id="admStatBlocked">–</div><div class="adm-stat-l">Blocked</div></div>
      <div class="adm-stat-box"><div class="adm-stat-n" id="admStatSubscribers">–</div><div class="adm-stat-l">Subscribers</div></div>
    </div>

    <!-- Tabs -->
    <div class="adm-tabs">
      <button class="adm-tab active" onclick="admTab('content',this)">Content Approval</button>
      <button class="adm-tab" onclick="admTab('bookings',this)">Bookings</button>
      <button class="adm-tab" onclick="admTab('orders',this)">Orders</button>
      <button class="adm-tab" onclick="admTab('users',this)">Members</button>
      <button class="adm-tab" onclick="admTab('create',this)">Create Content</button>
      <button class="adm-tab" onclick="admTab('campaigns',this)">Notifications</button>
      <button class="adm-tab" id="tabStats" style="display:none" onclick="admTab('stats',this)">Site Stats</button>
      <button class="adm-tab" id="tabWaitlist" style="display:none" onclick="admTab('waitlist',this)">Waitlist</button>
      <button class="adm-tab" id="tabActivityLog" style="display:none" onclick="admTab('activitylog',this)">Activity Log</button>
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
      <div class="adm-section-title">Member Management</div>
      <div class="adm-search">
        <input class="adm-input" id="memberSearch" placeholder="Search by name, email or phone…" oninput="filterMembers(this.value)">
      </div>
      <div style="display:flex;gap:8px;margin-bottom:16px;flex-wrap:wrap">
        <button class="adm-btn btn-secondary" onclick="filterMembersByStatus('all')">All</button>
        <button class="adm-btn btn-secondary" onclick="filterMembersByStatus('active')">Active</button>
        <button class="adm-btn btn-secondary" onclick="filterMembersByStatus('blocked')">Blocked</button>
      </div>
      <div id="membersList"><div class="adm-empty">Loading members…</div></div>
    </div>

    <!-- ── SITE STATS ── -->
    <div id="panel-stats" class="adm-panel">
      <div class="adm-section-title">Site Statistics</div>
      <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:14px;margin-bottom:28px">
        <div class="adm-stat-box" style="border-color:rgba(232,160,32,.35)"><div class="adm-stat-n" id="statRevenue" style="color:var(--amber)">₹0</div><div class="adm-stat-l">Total Revenue</div></div>
        <div class="adm-stat-box" style="border-color:rgba(193,68,14,.3)"><div class="adm-stat-n" id="statTotalMembers" style="color:var(--rust)">-</div><div class="adm-stat-l">Total Members</div></div>
        <div class="adm-stat-box" style="border-color:rgba(74,222,128,.2)"><div class="adm-stat-n" id="statNewMembers30d" style="color:#4ade80">-</div><div class="adm-stat-l">New Members (30d)</div></div>
        <div class="adm-stat-box" style="border-color:rgba(74,222,128,.2)"><div class="adm-stat-n" id="statActiveMembers" style="color:#4ade80">-</div><div class="adm-stat-l">Active Members</div></div>
        <div class="adm-stat-box" style="border-color:rgba(248,113,113,.2)"><div class="adm-stat-n" id="statBlockedMembers" style="color:#f87171">-</div><div class="adm-stat-l">Blocked Members</div></div>
        <div class="adm-stat-box"><div class="adm-stat-n" id="statTotalBookings">-</div><div class="adm-stat-l">Total Bookings</div></div>
        <div class="adm-stat-box"><div class="adm-stat-n" id="statTotalOrders">-</div><div class="adm-stat-l">Merch Orders</div></div>
        <div class="adm-stat-box" style="border-color:rgba(124,58,237,.3)"><div class="adm-stat-n" id="statWaitlistWaiting" style="color:#a78bfa">-</div><div class="adm-stat-l">On Waitlist</div></div>
        <div class="adm-stat-box" style="border-color:rgba(232,160,32,.3)"><div class="adm-stat-n" id="statPendingContent" style="color:var(--amber)">-</div><div class="adm-stat-l">Pending Review</div></div>
        <div class="adm-stat-box"><div class="adm-stat-n" id="statTotalBlogs">-</div><div class="adm-stat-l">Published Blogs</div></div>
        <div class="adm-stat-box"><div class="adm-stat-n" id="statTotalAlbums">-</div><div class="adm-stat-l">Published Albums</div></div>
        <div class="adm-stat-box"><div class="adm-stat-n" id="statTotalTestis">-</div><div class="adm-stat-l">Testimonials</div></div>
        <div class="adm-stat-box"><div class="adm-stat-n" id="statTotalReferred">-</div><div class="adm-stat-l">Total Referrals</div></div>
        <div class="adm-stat-box" style="border-color:rgba(74,222,128,.2)"><div class="adm-stat-n" id="statReferralsCredited" style="color:#4ade80">-</div><div class="adm-stat-l">Referrals Credited</div></div>
      </div>
      <div class="adm-section-title">Merchandise Orders by Product</div>
      <div id="statMerchandise"><div class="adm-empty">Loading...</div></div>
      <div class="adm-section-title" style="margin-top:24px">Bookings by Expedition</div>
      <div id="statExpeditions"><div class="adm-empty">Loading...</div></div>
      <div class="adm-section-title" style="margin-top:24px">Role Distribution</div>
      <div id="statRoles" style="display:flex;gap:12px;flex-wrap:wrap"></div>
    </div>

    <!-- ── WAITLIST ── -->
    <div id="panel-waitlist" class="adm-panel">
      <div class="adm-section-title">Expedition Waitlist</div>
      <div style="font-size:12px;color:rgba(255,255,255,.5);margin-bottom:18px">Mark an expedition "Full — Show Waitlist" in its editor to start collecting names here.</div>
      <div id="waitlistList"><div class="adm-spinner">Loading...</div></div>
    </div>

    <!-- Create Content Panel -->
    <div id="panel-create" class="adm-panel">
      <div style="display:flex;gap:12px;margin-bottom:24px">
        <button id="createTabBlog" onclick="adminCreateTab('blog')" style="padding:9px 20px;font-size:11px;letter-spacing:2px;text-transform:uppercase;font-family:var(--body);cursor:pointer;border-radius:2px;background:var(--rust);border:none;color:#fff">Blog</button>
        <button id="createTabAlbum" onclick="adminCreateTab('album')" style="padding:9px 20px;font-size:11px;letter-spacing:2px;text-transform:uppercase;font-family:var(--body);cursor:pointer;border-radius:2px;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.12);color:rgba(255,255,255,.6)">Album</button>
        <button id="createTabExpedition" onclick="adminCreateTab('expedition')" style="padding:9px 20px;font-size:11px;letter-spacing:2px;text-transform:uppercase;font-family:var(--body);cursor:pointer;border-radius:2px;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.12);color:rgba(255,255,255,.6)">Expeditions</button>
        <button id="createTabProduct" onclick="adminCreateTab('product')" style="padding:9px 20px;font-size:11px;letter-spacing:2px;text-transform:uppercase;font-family:var(--body);cursor:pointer;border-radius:2px;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.12);color:rgba(255,255,255,.6)">Merchandise</button>
      </div>

      <!-- Blog Section -->
      <div id="createBlogSection">
        <div class="adm-section-title">My Blogs <button onclick="adminShowBlogEditor()" style="margin-left:12px;padding:5px 14px;font-size:10px;letter-spacing:1.5px;text-transform:uppercase;font-family:var(--body);cursor:pointer;background:rgba(193,68,14,.2);border:1px solid rgba(193,68,14,.4);color:var(--rust);border-radius:2px">+ New Blog</button></div>
        <div id="adminBlogList"><div class="adm-spinner">Loading...</div></div>

        <div id="adminBlogEditor" style="display:none;margin-top:24px;background:#0f0d0b;border:1px solid rgba(255,255,255,.1);padding:24px;border-radius:2px">
          <input type="hidden" id="adminBlogEditId" value="">
          <div style="margin-bottom:14px">
            <input type="text" id="adminBlogTitle" placeholder="Blog title..." style="width:100%;box-sizing:border-box;padding:11px 14px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.12);color:#fff;font-family:var(--body);font-size:16px;border-radius:2px;outline:none">
          </div>
          <div id="adminBlogToolbar" style="display:flex;flex-wrap:wrap;gap:2px;padding:8px 10px;background:#1a1410;border:1px solid rgba(255,255,255,.12);border-bottom:none;border-radius:2px 2px 0 0;align-items:center">
            <button type="button" onclick="document.execCommand('bold')" title="Bold" style="padding:0 10px;height:28px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.1);color:#fff;font-size:12px;cursor:pointer;border-radius:2px;font-family:var(--body);font-weight:bold">B</button>
            <button type="button" onclick="document.execCommand('italic')" title="Italic" style="padding:0 10px;height:28px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.1);color:#fff;font-size:12px;cursor:pointer;border-radius:2px;font-family:var(--body);font-style:italic">I</button>
            <button type="button" onclick="document.execCommand('formatBlock',false,'H2')" title="Heading 2" style="padding:0 10px;height:28px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.1);color:#fff;font-size:11px;cursor:pointer;border-radius:2px;font-family:var(--body)">H2</button>
            <button type="button" onclick="document.execCommand('formatBlock',false,'H3')" title="Heading 3" style="padding:0 10px;height:28px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.1);color:#fff;font-size:11px;cursor:pointer;border-radius:2px;font-family:var(--body)">H3</button>
            <button type="button" onclick="document.execCommand('insertUnorderedList')" title="Bullet List" style="padding:0 10px;height:28px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.1);color:#fff;font-size:14px;cursor:pointer;border-radius:2px;font-family:var(--body)">&#8226;</button>
            <button type="button" onclick="document.execCommand('formatBlock',false,'blockquote')" title="Blockquote" style="padding:0 10px;height:28px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.1);color:#fff;font-size:14px;cursor:pointer;border-radius:2px;font-family:var(--body)">&ldquo;</button>
            <button type="button" onclick="document.getElementById('adminBlogInlinePhotoInput').click()" style="padding:0 12px;height:28px;background:rgba(193,68,14,.2);border:1px solid rgba(193,68,14,.4);color:var(--rust);font-size:11px;letter-spacing:1px;cursor:pointer;border-radius:2px;font-family:var(--body);margin-left:4px">+ PHOTO</button>
            <input type="file" id="adminBlogInlinePhotoInput" accept="image/*" style="display:none" onchange="adminInsertInlinePhoto(this)">
          </div>
          <div id="adminBlogBody" contenteditable="true" data-placeholder="Write your blog here..."
            style="min-height:260px;padding:16px;background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.12);border-radius:0 0 2px 2px;color:rgba(255,255,255,.85);font-family:var(--body);font-size:15px;line-height:1.7;outline:none">
            <style>
              #adminBlogBody[data-placeholder]:empty:before{content:attr(data-placeholder);color:rgba(255,255,255,.45);pointer-events:none;display:block}
              #adminBlogBody h2{font-family:var(--headline);font-size:26px;color:#fff;letter-spacing:1px;margin:20px 0 8px}
              #adminBlogBody h3{font-family:var(--headline);font-size:20px;color:#fff;letter-spacing:.5px;margin:16px 0 6px}
              #adminBlogBody p{margin:0 0 12px}
              #adminBlogBody ul,#adminBlogBody ol{padding-left:22px;margin:0 0 12px}
              #adminBlogBody blockquote{border-left:3px solid var(--rust);margin:16px 0;padding:10px 16px;background:rgba(193,68,14,.08);font-style:italic;color:rgba(255,255,255,.7)}
              #adminBlogBody img{max-width:100%;border-radius:3px;margin:12px 0;display:block}
            </style>
          </div>
          <div style="margin-top:14px;display:flex;gap:10px;align-items:center;flex-wrap:wrap">
            <input type="file" id="adminBlogCoverInput" accept="image/*" style="display:none" onchange="adminUploadBlogCover(this)">
            <button onclick="document.getElementById('adminBlogCoverInput').click()" style="padding:8px 16px;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.15);color:#fff;font-family:var(--body);font-size:13px;cursor:pointer;border-radius:2px">Upload Cover</button>
            <span id="adminBlogCoverName" style="font-size:12px;color:rgba(255,255,255,.5)"></span>
            <input type="hidden" id="adminBlogCoverUrl" value="">
          </div>
          <div style="margin-top:6px">
            <label style="font-size:12px;color:rgba(255,255,255,.5);letter-spacing:1px">STATUS</label><br>
            <select id="adminBlogStatus" style="margin-top:4px;padding:7px 12px;background:#1a1410;border:1px solid rgba(255,255,255,.15);color:#fff;font-family:var(--body);font-size:13px;border-radius:2px;outline:none">
              <option value="published">Published</option>
              <option value="draft">Draft</option>
            </select>
          </div>
          <div style="margin-top:16px;display:flex;gap:10px">
            <button onclick="adminSaveBlog()" style="padding:10px 24px;background:var(--rust);border:none;color:#fff;font-family:var(--body);font-size:13px;letter-spacing:1px;cursor:pointer;border-radius:2px">Save Blog</button>
            <button onclick="document.getElementById('adminBlogEditor').style.display='none'" style="padding:10px 20px;background:rgba(255,255,255,.06);border:none;color:rgba(255,255,255,.5);font-family:var(--body);font-size:13px;cursor:pointer;border-radius:2px">Cancel</button>
          </div>
          <div id="adminBlogMsg" style="font-size:12px;margin-top:10px"></div>
        </div>
      </div>

      <!-- Album Section -->
      <div id="createAlbumSection" style="display:none">
        <div class="adm-section-title">My Albums <button onclick="document.getElementById('adminAlbumForm').style.display='block'" style="margin-left:12px;padding:5px 14px;font-size:10px;letter-spacing:1.5px;text-transform:uppercase;font-family:var(--body);cursor:pointer;background:rgba(193,68,14,.2);border:1px solid rgba(193,68,14,.4);color:var(--rust);border-radius:2px">+ New Album</button></div>
        <div id="adminAlbumList"><div class="adm-spinner">Loading...</div></div>

        <div id="adminAlbumForm" style="display:none;margin-top:24px;background:#0f0d0b;border:1px solid rgba(255,255,255,.1);padding:24px;border-radius:2px">
          <div style="display:grid;gap:12px;margin-bottom:14px">
            <input type="text" id="adminAlbumTitle" placeholder="Album title (e.g. Winter Spiti 2026)" style="padding:11px 14px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.12);color:#fff;font-family:var(--body);font-size:14px;border-radius:2px;outline:none">
                        <label style="display:flex;align-items:center;gap:10px;cursor:pointer">
              <input type="checkbox" id="adminAlbumIsPublic" style="width:18px;height:18px;accent-color:var(--teal)">
              <span style="font-size:13px;color:rgba(255,255,255,.7)">Show in community carousel</span>
            </label>
          </div>
          <div style="display:flex;gap:10px">
            <button onclick="adminCreateAlbum()" style="padding:10px 24px;background:var(--rust);border:none;color:#fff;font-family:var(--body);font-size:13px;letter-spacing:1px;cursor:pointer;border-radius:2px">Create Album</button>
            <button onclick="document.getElementById('adminAlbumForm').style.display='none'" style="padding:10px 20px;background:rgba(255,255,255,.06);border:none;color:rgba(255,255,255,.5);font-family:var(--body);font-size:13px;cursor:pointer;border-radius:2px">Cancel</button>
          </div>
          <div id="adminAlbumFormMsg" style="font-size:12px;margin-top:10px;color:#f87171"></div>
        </div>
      </div>

      <!-- Expeditions Section -->
      <div id="createExpeditionSection" style="display:none">
        <div class="adm-section-title">Expeditions <button onclick="adminShowExpeditionEditor()" style="margin-left:12px;padding:5px 14px;font-size:10px;letter-spacing:1.5px;text-transform:uppercase;font-family:var(--body);cursor:pointer;background:rgba(193,68,14,.2);border:1px solid rgba(193,68,14,.4);color:var(--rust);border-radius:2px">+ New Expedition</button></div>
        <div id="adminExpeditionList"><div class="adm-spinner">Loading...</div></div>

        <div id="adminExpeditionEditor" style="display:none;margin-top:24px;background:#0f0d0b;border:1px solid rgba(255,255,255,.1);padding:24px;border-radius:2px">
          <input type="hidden" id="expId" value="">

          <div class="adm-label" style="font-size:13px;color:#fff;margin-bottom:10px">Title</div>
          <input type="text" id="expTitle" class="adm-input" placeholder="e.g. Upper Mustang – Muktinath Expedition" style="margin-bottom:18px">

          <div class="adm-section-title" style="font-size:14px">Basic Details</div>
          <div class="adm-grid-2" style="margin-bottom:12px">
            <div><label class="adm-label">Status</label><select id="expStatus" class="adm-select"><option value="upcoming">Upcoming</option><option value="past">Past / Completed</option></select></div>
            <div><label class="adm-label">Destination</label><input type="text" id="expDestination" class="adm-input" placeholder="e.g. Nepal (Mustang)"></div>
          </div>
          <div class="adm-grid-3" style="margin-bottom:12px">
            <div><label class="adm-label">Dates (display text)</label><input type="text" id="expDates" class="adm-input" placeholder="23rd May – 30th May 2026"></div>
            <div><label class="adm-label">Month (used for sorting/display)</label><input type="text" id="expMonth" class="adm-input" placeholder="e.g. September 2026"></div>
            <div><label class="adm-label">Duration</label><input type="text" id="expDuration" class="adm-input" placeholder="8 Nights / 9 Days"></div>
          </div>
          <div class="adm-grid-3" style="margin-bottom:12px">
            <div><label class="adm-label">Region</label><input type="text" id="expRegion" class="adm-input" placeholder="International / Himachal etc."></div>
            <div><label class="adm-label">Difficulty</label><select id="expDifficulty" class="adm-select"><option>Easy</option><option>Moderate</option><option>Challenging</option><option>Extreme</option></select></div>
            <div><label class="adm-label">Card Emoji</label><input type="text" id="expEmoji" class="adm-input" placeholder="🏔️"></div>
          </div>
          <div style="margin-bottom:12px"><label class="adm-label">Short Subtitle</label><input type="text" id="expSubtitle" class="adm-input" placeholder="4x4 Only · Mustang Valley · Nepal"></div>
          <div style="margin-bottom:12px"><label class="adm-label">Overview / About This Trip</label><textarea id="expOverview" class="adm-input" rows="4"></textarea></div>
          <div style="margin-bottom:20px"><label class="adm-label">Highlights (one per line)</label><textarea id="expHighlights" class="adm-input" rows="3" placeholder="Mustang Valley&#10;Lo Manthang&#10;Kagbeni"></textarea></div>

          <div class="adm-section-title" style="font-size:14px">Slots &amp; Pricing</div>
          <div class="adm-grid-3" style="margin-bottom:12px">
            <div><label class="adm-label">Price (₹)</label><input type="number" id="expPrice" class="adm-input" placeholder="29999"></div>
            <div><label class="adm-label">Price Unit</label><select id="expPriceUnit" class="adm-select"><option value="per person">per person</option><option value="per car">per car</option><option value="per couple">per couple</option></select></div>
            <div><label class="adm-label">Card Badge</label><input type="text" id="expBadge" class="adm-input" placeholder="Early Bird Discount"></div>
          </div>
          <div class="adm-grid-3" style="margin-bottom:12px">
            <div><label class="adm-label">Couple Discount Price (₹)</label><input type="number" id="expCouplePrice" class="adm-input"></div>
            <div><label class="adm-label">Seat Sharing Price (₹)</label><input type="number" id="expSeatPrice" class="adm-input"></div>
            <div><label class="adm-label">Display Order (lower = first)</label><input type="number" id="expOrder" class="adm-input" value="0"></div>
          </div>
          <div class="adm-grid-3" style="margin-bottom:12px">
            <div><label class="adm-label">Total Slots</label><input type="number" id="expMaxSlots" class="adm-input" value="20"></div>
            <div><label class="adm-label">Slots Filled</label><input type="number" id="expFilledSlots" class="adm-input" value="0"></div>
            <div><label class="adm-label">Booking Status</label><select id="expWaitlist" class="adm-select"><option value="">Open for Booking</option><option value="1">Full — Show Waitlist</option></select></div>
          </div>
          <div class="adm-grid-2" style="margin-bottom:12px">
            <div><label class="adm-label">Booking WhatsApp Number</label><input type="text" id="expWhatsapp" class="adm-input" placeholder="917817838060"></div>
            <div><label class="adm-label">UPI QR Code Image URL</label><input type="text" id="expQrImage" class="adm-input"></div>
          </div>
          <div style="margin-bottom:12px"><label class="adm-label">Cancellation Policy (one point per line)</label><textarea id="expCancellation" class="adm-input" rows="3"></textarea></div>
          <div style="margin-bottom:20px"><label class="adm-label">Things to Carry (one item per line)</label><textarea id="expThingsCarry" class="adm-input" rows="4"></textarea></div>

          <div class="adm-section-title" style="font-size:14px">Inclusions &amp; Exclusions</div>
          <div class="adm-grid-2" style="margin-bottom:20px">
            <div><label class="adm-label">Inclusions ✅ (one per line)</label><textarea id="expInclusions" class="adm-input" rows="5"></textarea></div>
            <div><label class="adm-label">Exclusions ❌ (one per line)</label><textarea id="expExclusions" class="adm-input" rows="5"></textarea></div>
          </div>

          <div class="adm-section-title" style="font-size:14px">Day-by-Day Itinerary</div>
          <div id="expItinRows" style="margin-bottom:10px"></div>
          <button type="button" onclick="expAddDay()" style="margin-bottom:20px;padding:8px 16px;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.15);color:#fff;font-family:var(--body);font-size:12px;cursor:pointer;border-radius:2px">+ Add Day</button>

          <div class="adm-section-title" style="font-size:14px">Photo Gallery</div>
          <div id="expGalPreview" style="display:flex;flex-wrap:wrap;gap:8px;margin-bottom:12px"></div>
          <input type="file" id="expGalInput" accept="image/*" multiple style="display:none" onchange="expUploadGallery(this)">
          <button type="button" onclick="document.getElementById('expGalInput').click()" style="margin-bottom:20px;padding:8px 16px;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.15);color:#fff;font-family:var(--body);font-size:12px;cursor:pointer;border-radius:2px">Upload Photos</button>

          <div class="adm-section-title" style="font-size:14px">FAQs</div>
          <div id="expFaqRows" style="margin-bottom:10px"></div>
          <button type="button" onclick="expAddFaq()" style="margin-bottom:20px;padding:8px 16px;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.15);color:#fff;font-family:var(--body);font-size:12px;cursor:pointer;border-radius:2px">+ Add FAQ</button>

          <div class="adm-section-title" style="font-size:14px">Featured Image</div>
          <div style="display:flex;gap:12px;align-items:center;margin-bottom:20px">
            <img id="expThumbPreview" src="" style="width:80px;height:56px;object-fit:cover;border-radius:2px;display:none;background:#1a1410">
            <input type="file" id="expThumbInput" accept="image/*" style="display:none" onchange="expUploadThumb(this)">
            <input type="hidden" id="expThumbId" value="">
            <button type="button" onclick="document.getElementById('expThumbInput').click()" style="padding:8px 16px;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.15);color:#fff;font-family:var(--body);font-size:12px;cursor:pointer;border-radius:2px">Upload / Change</button>
            <span id="expThumbName" style="font-size:12px;color:rgba(255,255,255,.5)"></span>
          </div>

          <div style="margin-bottom:6px"><label class="adm-label">Publish Status</label>
            <select id="expPostStatus" class="adm-select" style="max-width:200px"><option value="publish">Published (live on site)</option><option value="draft">Draft (hidden)</option></select>
          </div>
          <div style="margin-top:16px;display:flex;gap:10px">
            <button onclick="adminSaveExpedition()" class="btn-save" style="padding:10px 24px;font-family:var(--body);font-size:13px;letter-spacing:1px;cursor:pointer;border-radius:2px;border:none">Save Expedition</button>
            <button onclick="document.getElementById('adminExpeditionEditor').style.display='none'" class="btn-secondary" style="padding:10px 20px;font-family:var(--body);font-size:13px;cursor:pointer;border-radius:2px">Cancel</button>
          </div>
          <div id="adminExpeditionMsg" style="font-size:12px;margin-top:10px"></div>
        </div>
      </div>

      <!-- Merchandise Section -->
      <div id="createProductSection" style="display:none">
        <div class="adm-section-title">Merchandise <button onclick="adminShowProductEditor()" style="margin-left:12px;padding:5px 14px;font-size:10px;letter-spacing:1.5px;text-transform:uppercase;font-family:var(--body);cursor:pointer;background:rgba(193,68,14,.2);border:1px solid rgba(193,68,14,.4);color:var(--rust);border-radius:2px">+ New Product</button></div>
        <div id="adminProductList"><div class="adm-spinner">Loading...</div></div>

        <div id="adminProductEditor" style="display:none;margin-top:24px;background:#0f0d0b;border:1px solid rgba(255,255,255,.1);padding:24px;border-radius:2px">
          <input type="hidden" id="prodId" value="">

          <div class="adm-label" style="font-size:13px;color:#fff;margin-bottom:10px">Title</div>
          <input type="text" id="prodTitle" class="adm-input" placeholder="e.g. FreeWheel Convoy Cap" style="margin-bottom:18px">

          <div class="adm-grid-3" style="margin-bottom:12px">
            <div><label class="adm-label">Price (₹)</label><input type="number" id="prodPrice" class="adm-input" placeholder="799"></div>
            <div><label class="adm-label">Original Price (₹, optional)</label><input type="number" id="prodOrigPrice" class="adm-input" placeholder="Leave blank if no discount"></div>
            <div><label class="adm-label">Category</label><input type="text" id="prodCategory" class="adm-input" placeholder="T-Shirts / Caps / Mugs"></div>
          </div>
          <div class="adm-grid-2" style="margin-bottom:12px">
            <div><label class="adm-label">Stock Status</label><select id="prodStock" class="adm-select">
              <option value="in-stock">In Stock</option><option value="new-arrival">New Arrival</option><option value="limited-stock">Limited Stock</option><option value="out-of-stock">Out of Stock</option>
            </select></div>
            <div><label class="adm-label">Display Order (lower = first)</label><input type="number" id="prodOrder" class="adm-input" value="0"></div>
          </div>
          <div style="margin-bottom:12px"><label class="adm-label">Special Feature / Material</label><input type="text" id="prodFeature" class="adm-input" placeholder="e.g. Ceramic / 100% Cotton / Stainless Steel"></div>
          <div style="margin-bottom:12px"><label class="adm-label">Short Description</label><textarea id="prodDesc" class="adm-input" rows="3"></textarea></div>
          <div style="margin-bottom:12px"><label class="adm-label">WhatsApp Order Message (pre-filled)</label><input type="text" id="prodWaMsg" class="adm-input" placeholder="Hi! I want to order: ..."></div>
          <div class="adm-grid-2" style="margin-bottom:20px">
            <div><label class="adm-label">Available Colors (comma separated)</label><input type="text" id="prodColors" class="adm-input" placeholder="White,Black,Olive Green"></div>
            <div><label class="adm-label">Available Sizes (comma separated)</label><input type="text" id="prodSizes" class="adm-input" placeholder="M,L,XL,XXL"></div>
          </div>

          <div class="adm-section-title" style="font-size:14px">Product Image</div>
          <div style="display:flex;gap:12px;align-items:center;margin-bottom:20px">
            <img id="prodThumbPreview" src="" style="width:80px;height:80px;object-fit:cover;border-radius:2px;display:none;background:#1a1410">
            <input type="file" id="prodThumbInput" accept="image/*" style="display:none" onchange="prodUploadThumb(this)">
            <input type="hidden" id="prodThumbId" value="">
            <button type="button" onclick="document.getElementById('prodThumbInput').click()" style="padding:8px 16px;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.15);color:#fff;font-family:var(--body);font-size:12px;cursor:pointer;border-radius:2px">Upload / Change</button>
            <span id="prodThumbName" style="font-size:12px;color:rgba(255,255,255,.5)"></span>
          </div>

          <div style="margin-bottom:6px"><label class="adm-label">Publish Status</label>
            <select id="prodPostStatus" class="adm-select" style="max-width:200px"><option value="publish">Published (live on site)</option><option value="draft">Draft (hidden)</option></select>
          </div>
          <div style="margin-top:16px;display:flex;gap:10px">
            <button onclick="adminSaveProduct()" class="btn-save" style="padding:10px 24px;font-family:var(--body);font-size:13px;letter-spacing:1px;cursor:pointer;border-radius:2px;border:none">Save Product</button>
            <button onclick="document.getElementById('adminProductEditor').style.display='none'" class="btn-secondary" style="padding:10px 20px;font-family:var(--body);font-size:13px;cursor:pointer;border-radius:2px">Cancel</button>
          </div>
          <div id="adminProductMsg" style="font-size:12px;margin-top:10px"></div>
        </div>
      </div>
    </div>

    <!-- ── NOTIFICATIONS / CAMPAIGNS ── -->
    <div id="panel-campaigns" class="adm-panel">

      <div class="adm-section-title">Add Subscriber
        <span style="font-size:11px;color:rgba(255,255,255,.4);font-weight:400;text-transform:none;letter-spacing:0">— for people who share contact info via WhatsApp/in person, without creating an account</span>
      </div>
      <div class="adm-card" style="margin-bottom:24px">
        <div class="adm-grid-2" style="margin-bottom:12px">
          <div>
            <label class="adm-label">Name</label>
            <input type="text" id="subAddName" class="adm-input" placeholder="Full name">
          </div>
          <div>
            <label class="adm-label">City</label>
            <input type="text" id="subAddCity" class="adm-input" placeholder="e.g. Haldwani">
          </div>
        </div>
        <div class="adm-grid-2" style="margin-bottom:12px">
          <div>
            <label class="adm-label">Email</label>
            <input type="email" id="subAddEmail" class="adm-input" placeholder="name@example.com">
          </div>
          <div>
            <label class="adm-label">Phone / WhatsApp</label>
            <input type="text" id="subAddMobile" class="adm-input" placeholder="+91...">
          </div>
        </div>
        <button class="adm-btn btn-save" onclick="subAddSubmit()">Add Subscriber</button>
        <div id="subAddMsg" style="font-size:12px;margin-top:8px"></div>
      </div>

      <div class="adm-section-title">Send Notification
        <span class="adm-count" id="campAudienceCount">–</span>
        <span style="font-size:11px;color:rgba(255,255,255,.4);font-weight:400;text-transform:none;letter-spacing:0">recipients (subscribers + members, deduped)</span>
      </div>

      <div class="adm-card">
        <div style="display:grid;gap:14px">
          <div>
            <label class="adm-label">Subject</label>
            <input type="text" id="campSubject" class="adm-input" placeholder="e.g. New expedition open for booking — Winter Spiti 2026">
          </div>

          <div>
            <label class="adm-label">Message</label>
            <textarea id="campBody" class="adm-input" rows="6" placeholder="Write your update here..."></textarea>
          </div>

          <div class="adm-grid-2">
            <div>
              <label class="adm-label">Image (optional)</label>
              <input type="file" id="campImageInput" accept="image/*" style="display:none" onchange="campUploadAsset(this,'image')">
              <button type="button" class="adm-btn btn-secondary" onclick="document.getElementById('campImageInput').click()" style="width:100%">Upload Image</button>
              <div id="campImagePreview" style="margin-top:8px;font-size:12px;color:rgba(255,255,255,.5)"></div>
              <input type="hidden" id="campImageUrl" value="">
            </div>
            <div>
              <label class="adm-label">Attach PDF (optional)</label>
              <input type="file" id="campPdfInput" accept="application/pdf" style="display:none" onchange="campUploadAsset(this,'pdf')">
              <button type="button" class="adm-btn btn-secondary" onclick="document.getElementById('campPdfInput').click()" style="width:100%">Upload PDF</button>
              <div id="campPdfPreview" style="margin-top:8px;font-size:12px;color:rgba(255,255,255,.5)"></div>
              <input type="hidden" id="campPdfUrl" value="">
              <input type="text" id="campPdfLabel" class="adm-input" placeholder="Button label (e.g. Download Itinerary)" style="margin-top:8px;display:none">
            </div>
          </div>

          <div class="adm-grid-2">
            <div>
              <label class="adm-label">Button link (optional — defaults to homepage)</label>
              <input type="text" id="campCtaUrl" class="adm-input" placeholder="https://freewheelexpeditions.in/expedition/...">
            </div>
            <div>
              <label class="adm-label">Button text</label>
              <input type="text" id="campCtaLabel" class="adm-input" placeholder="View Expeditions →">
            </div>
          </div>

          <div>
            <label class="adm-label">Feature trip cards (optional — pulls real dates/pricing, renders as visual cards in the email)</label>
            <div id="campTripPicker" style="margin-top:6px"><span style="font-size:12px;color:rgba(255,255,255,.4)">Loading...</span></div>
          </div>

          <div>
            <button type="button" class="adm-btn btn-secondary" onclick="campPreviewCards()" style="font-size:12px">Preview Selected Cards</button>
            <div id="campCardPreview" style="margin-top:12px"></div>
          </div>

          <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap">
            <button class="adm-btn btn-save" onclick="campSend()" id="campSendBtn">Send Notification</button>
            <button class="adm-btn btn-secondary" onclick="campExportWhatsapp()">Export WhatsApp Numbers</button>
            <span id="campProgress" style="font-size:12px;color:rgba(255,255,255,.6)"></span>
          </div>
          <div id="campMsg" style="font-size:12px"></div>
        </div>
      </div>

    </div>

    <!-- Activity Log Panel (Super Admin only) -->
    <div id="panel-activitylog" class="adm-panel">
      <div class="adm-section-title">Admin Activity Log <span style="font-size:11px;color:rgba(255,255,255,.45);font-weight:400;text-transform:none;letter-spacing:0">— last 200 actions</span></div>
      <div id="activityLogList"><div class="adm-spinner">Loading...</div></div>
    </div>

  </div>
</div>


<script>
/* ── Pre-boot: bypass gate ── */
(function() {
  try {
    var s = JSON.parse(localStorage.getItem('fw_session')||'null');
    if (!s || !s.role) return;
    var roles = ['admin','super_admin','moderator'];
    if (roles.indexOf(s.role) === -1) return;
    document.write('<style>#admGate{display:none!important}#admDash{display:block!important}</style>');
  } catch(e) {}
})();
</script>

<script>
/* PHP vars for admin JS */
var _admIsWPAdmin = <?php echo current_user_can('manage_options') ? 'true' : 'false'; ?>;
var _admUrls = {
  'login': '<?php echo esc_js(home_url("/login/")); ?>',
  'dashboard': '<?php echo esc_js(home_url("/dashboard/")); ?>'
};
</script>
<script src="<?php echo esc_url(get_template_directory_uri()); ?>/fw-admin.js?v=<?php echo time(); ?>"></script>

<?php get_footer(); ?>

