<?php
/* Template Name: Login */
get_header();
?>
<style>
.login-wrap{min-height:100vh;background:var(--ink);display:flex;align-items:center;justify-content:center;padding:80px 20px 60px}
.login-card{width:100%;max-width:420px}
.login-logo{text-align:center;margin-bottom:32px}
.login-logo a{font-family:var(--headline);font-size:28px;color:var(--rust);letter-spacing:3px;text-decoration:none}
.login-logo p{font-size:11px;color:rgba(255,255,255,.35);letter-spacing:2px;margin-top:4px}
.login-box{background:#0f0d0b;border:1px solid rgba(193,68,14,.25);border-radius:4px;padding:36px 32px}
.login-tag{font-size:10px;letter-spacing:3px;text-transform:uppercase;color:var(--rust);margin-bottom:8px}
.login-title{font-family:var(--headline);font-size:28px;color:#fff;letter-spacing:1px;margin-bottom:6px}
.login-sub{font-size:13px;color:rgba(255,255,255,.4);line-height:1.6;margin-bottom:28px}
.login-field{margin-bottom:16px}
.login-field label{display:block;font-size:10px;letter-spacing:2px;text-transform:uppercase;color:rgba(255,255,255,.4);margin-bottom:6px}
.login-field input{width:100%;box-sizing:border-box;padding:12px 14px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.12);color:#fff;font-family:var(--body);font-size:14px;border-radius:2px;outline:none;transition:border-color .2s}
.login-field input:focus{border-color:rgba(193,68,14,.6)}
.login-field input::placeholder{color:rgba(255,255,255,.2)}
.login-btn{width:100%;padding:14px;background:var(--rust);border:none;color:#fff;font-family:var(--headline);font-size:18px;letter-spacing:2px;cursor:pointer;border-radius:2px;transition:background .2s;margin-top:8px}
.login-btn:hover:not(:disabled){background:#a03508}
.login-btn:disabled{opacity:.55;cursor:not-allowed}
.login-msg{font-size:12px;margin-top:12px;text-align:center;min-height:18px}
.login-msg.error{color:#f87171}
.login-msg.success{color:#4ade80}
.login-link{text-align:center;margin-top:20px;font-size:13px;color:rgba(255,255,255,.35)}
.login-link a{color:var(--rust);text-decoration:none}
.pw-wrap{position:relative}
.pw-wrap input{padding-right:44px}
.pw-toggle{position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;color:rgba(255,255,255,.35);cursor:pointer;font-size:16px;padding:4px}
@media(max-width:480px){.login-box{padding:28px 20px}}
</style>

<div class="login-wrap">
  <div class="login-card">

    <div class="login-logo">
      <a href="<?php echo esc_url(home_url('/')); ?>">FREEWHEEL</a>
      <p>EXPEDITIONS</p>
    </div>

    <div class="login-box">
      <div class="login-tag">Member Login</div>
      <div class="login-title">Welcome Back 🏔️</div>
      <p class="login-sub">Enter your email and password to access your dashboard.</p>

      <div class="login-field">
        <label>Email Address <span style="color:var(--rust)">*</span></label>
        <input type="email" id="loginEmail" placeholder="rahul@gmail.com" autocomplete="email">
      </div>

      <div class="login-field">
        <label>Password <span style="color:var(--rust)">*</span></label>
        <div class="pw-wrap">
          <input type="password" id="loginPassword" placeholder="Your password" autocomplete="current-password">
          <button type="button" class="pw-toggle" onclick="togglePw()">👁</button>
        </div>
      </div>

      <div style="text-align:right;margin-top:-8px;margin-bottom:16px">
        <a href="<?php echo esc_url(home_url('/reset-password/')); ?>" style="font-size:12px;color:rgba(255,255,255,.35);text-decoration:none">Forgot password?</a>
      </div>

      <button class="login-btn" id="loginBtn" onclick="doLogin()">LOG IN →</button>
      <div class="login-msg" id="loginMsg"></div>
    </div>

    <div class="login-link" style="margin-top:20px">Don't have an account? <a href="<?php echo esc_url(home_url('/register/')); ?>">Register free</a></div>

  </div>
</div>

<script>
/* ── Redirect if already logged in ── */
(function(){
  try {
    var s = JSON.parse(localStorage.getItem('fw_session') || 'null');
    if (s && s.access_token && s.expires_at > Date.now()) {
      window.location.href = '<?php echo esc_js(home_url('/dashboard/')); ?>';
    }
  } catch(e){}
})();

var _sb = null;
document.addEventListener('DOMContentLoaded', function() {
  if (window.supabase && window.FW_AUTH) {
    _sb = supabase.createClient(FW_AUTH.supabase_url, FW_AUTH.supabase_key);
  }
  ['loginEmail','loginPassword'].forEach(function(id){
    var el = document.getElementById(id);
    if (el) el.addEventListener('keydown', function(e){ if(e.key==='Enter') doLogin(); });
  });
});

function togglePw() {
  var el = document.getElementById('loginPassword');
  var btn = document.querySelector('.pw-toggle');
  if (!el) return;
  el.type = el.type === 'password' ? 'text' : 'password';
  btn.textContent = el.type === 'password' ? '👁' : '🙈';
}

async function doLogin() {
  var btn = document.getElementById('loginBtn');
  var msg = document.getElementById('loginMsg');
  msg.textContent = ''; msg.className = 'login-msg';

  var email    = document.getElementById('loginEmail').value.trim().toLowerCase();
  var password = document.getElementById('loginPassword').value;

  if (!email || !email.includes('@')) { msg.textContent = 'Please enter your email.'; msg.className = 'login-msg error'; document.getElementById('loginEmail').focus(); return; }
  if (!password) { msg.textContent = 'Please enter your password.'; msg.className = 'login-msg error'; document.getElementById('loginPassword').focus(); return; }
  if (!_sb) { msg.textContent = 'Connection error. Please refresh.'; msg.className = 'login-msg error'; return; }

  btn.disabled = true; btn.textContent = 'Logging in…';

  try {
    var result = await _sb.auth.signInWithPassword({ email: email, password: password });
    if (result.error) throw result.error;

    var session = result.data.session;
    if (!session) throw new Error('Login failed. Please try again.');

    /* Get name from metadata immediately */
    var meta = result.data.user.user_metadata || {};
    var firstName = meta.first_name || '';
    var avatarUrl = '';
    var role = '';

    /* Single profile fetch */
    try {
      var profR = await fetch(FW_AUTH.rest_url + '/fw-get-profile', {
        headers: { 'Authorization': 'Bearer ' + session.access_token }
      });
      if (profR.ok) {
        var profD = await profR.json();
        if (profD.profile) {
          firstName = profD.profile.first_name || firstName;
          avatarUrl = profD.profile.avatar_url || '';
          role      = profD.profile.role || '';
        }
      }
    } catch(e) {}

    localStorage.setItem('fw_session', JSON.stringify({
      access_token:  session.access_token,
      refresh_token: session.refresh_token,
      user_id:       session.user.id,
      email:         session.user.email,
      first_name:    firstName,
      avatar_url:    avatarUrl,
      role:          role,
      expires_at:    Date.now() + (session.expires_in * 1000),
    }));

    /* Redirect based on role */
    var urlRedirect = new URLSearchParams(window.location.search).get('redirect');
    if (urlRedirect) { window.location.href = urlRedirect; return; }

    var adminRoles = ['admin', 'super_admin', 'moderator'];
    if (adminRoles.indexOf(role) !== -1) {
      window.location.href = '<?php echo esc_js(home_url('/admin-dashboard/')); ?>';
    } else {
      window.location.href = FW_AUTH.dashboard_url;
    }

  } catch(err) {
    var errMsg = err.message || 'Login failed.';
    if (errMsg.toLowerCase().includes('invalid') || errMsg.toLowerCase().includes('credentials')) {
      errMsg = 'Incorrect email or password.';
    }
    if (errMsg.toLowerCase().includes('email not confirmed')) {
      errMsg = 'Please confirm your email first. Check your inbox for the verification link.';
    }
    msg.textContent = errMsg; msg.className = 'login-msg error';
  } finally {
    btn.disabled = false; btn.textContent = 'LOG IN →';
  }
}
</script>

<?php get_footer(); ?>

