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
.login-step{display:none}
.login-step.active{display:block}
.otp-row{display:flex;gap:10px;justify-content:center;margin:20px 0}
.otp-box{width:48px;height:56px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.15);border-radius:2px;color:#fff;font-size:24px;font-family:var(--headline);text-align:center;outline:none;transition:border-color .2s}
.otp-box:focus{border-color:var(--rust)}
.login-link{text-align:center;margin-top:20px;font-size:13px;color:rgba(255,255,255,.35)}
.login-link a{color:var(--rust);text-decoration:none}
.login-resend{background:none;border:none;color:rgba(255,255,255,.4);font-size:12px;cursor:pointer;padding:0;margin-top:8px;text-decoration:underline}
.login-resend:disabled{color:rgba(255,255,255,.2);cursor:not-allowed;text-decoration:none}
@media(max-width:480px){.login-box{padding:28px 20px}.otp-box{width:40px;height:50px;font-size:20px}}
</style>

<div class="login-wrap">
  <div class="login-card">

    <div class="login-logo">
      <a href="<?php echo esc_url(home_url('/')); ?>">FREEWHEEL</a>
      <p>EXPEDITIONS</p>
    </div>

    <!-- STEP 1: Email Entry -->
    <div id="loginStep1" class="login-step active">
      <div class="login-box">
        <div class="login-tag">Member Login</div>
        <div class="login-title">Welcome Back 🏔️</div>
        <p class="login-sub">Enter your email to receive a one-time login code. No password needed.</p>

        <div class="login-field">
          <label>Email Address <span style="color:var(--rust)">*</span></label>
          <input type="email" id="loginEmail" placeholder="rahul@gmail.com" autocomplete="email">
        </div>

        <button class="login-btn" id="loginBtn1" onclick="loginSendOtp()">SEND LOGIN CODE →</button>
        <div class="login-msg" id="loginMsg1"></div>
      </div>
      <div class="login-link">Don't have an account? <a href="<?php echo esc_url(home_url('/register/')); ?>">Register free</a></div>
    </div>

    <!-- STEP 2: OTP Entry -->
    <div id="loginStep2" class="login-step">
      <div class="login-box">
        <div class="login-tag">Enter Your Code</div>
        <div class="login-title">Check Your Email</div>
        <p class="login-sub" id="loginOtpSub">We sent a 6-digit code to your email.</p>

        <div class="otp-row">
          <input class="otp-box" id="lo0" maxlength="1" inputmode="numeric" pattern="[0-9]">
          <input class="otp-box" id="lo1" maxlength="1" inputmode="numeric" pattern="[0-9]">
          <input class="otp-box" id="lo2" maxlength="1" inputmode="numeric" pattern="[0-9]">
          <input class="otp-box" id="lo3" maxlength="1" inputmode="numeric" pattern="[0-9]">
          <input class="otp-box" id="lo4" maxlength="1" inputmode="numeric" pattern="[0-9]">
          <input class="otp-box" id="lo5" maxlength="1" inputmode="numeric" pattern="[0-9]">
        </div>

        <button class="login-btn" id="loginBtn2" onclick="loginVerifyOtp()">LOG IN →</button>
        <div class="login-msg" id="loginMsg2"></div>

        <div style="text-align:center;margin-top:14px">
          <button class="login-resend" id="loginResendBtn" onclick="loginResendOtp()" disabled>Resend code in <span id="loginTimer">30</span>s</button>
        </div>
        <div style="text-align:center;margin-top:16px">
          <button onclick="loginGoBack()" style="background:none;border:none;color:rgba(255,255,255,.35);font-size:12px;cursor:pointer">← Different email</button>
        </div>
      </div>
    </div>

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
var _loginEmail = '';
var _loginTimerInterval = null;

document.addEventListener('DOMContentLoaded', function() {
  if (window.supabase && window.FW_AUTH) {
    _sb = supabase.createClient(FW_AUTH.supabase_url, FW_AUTH.supabase_key);
  }
  initLoginOtpBoxes();
  var emailEl = document.getElementById('loginEmail');
  if (emailEl) emailEl.addEventListener('keydown', function(e){ if(e.key==='Enter') loginSendOtp(); });
});

/* ── Send OTP ── */
async function loginSendOtp() {
  var btn = document.getElementById('loginBtn1');
  var msg = document.getElementById('loginMsg1');
  msg.textContent = ''; msg.className = 'login-msg';

  var email = document.getElementById('loginEmail').value.trim().toLowerCase();
  if (!email || !email.includes('@') || !email.includes('.')) {
    msg.textContent = 'Please enter a valid email address.';
    msg.className = 'login-msg error';
    document.getElementById('loginEmail').focus(); return;
  }
  if (!_sb) { msg.textContent = 'Connection error. Please refresh.'; msg.className = 'login-msg error'; return; }

  _loginEmail = email;
  btn.disabled = true; btn.textContent = 'Sending code…';

  try {
    var result = await _sb.auth.signInWithOtp({
      email: email,
      options: { shouldCreateUser: false, emailRedirectTo: null }
    });
    if (result.error) throw result.error;

    document.getElementById('loginOtpSub').textContent = 'We sent a 6-digit code to ' + email;
    loginShowStep(2);
    loginStartTimer();
    setTimeout(function(){ document.getElementById('lo0').focus(); }, 300);

  } catch(err) {
    var errMsg = err.message || 'Failed to send code.';
    if (errMsg.toLowerCase().includes('not found') || errMsg.toLowerCase().includes('no user')) {
      errMsg = 'No account found for this email. <a href="' + FW_AUTH.register_url + '" style="color:var(--rust)">Register here</a>';
      msg.innerHTML = errMsg; msg.className = 'login-msg error'; return;
    }
    msg.textContent = errMsg; msg.className = 'login-msg error';
  } finally {
    btn.disabled = false; btn.textContent = 'SEND LOGIN CODE →';
  }
}

/* ── Verify OTP ── */
async function loginVerifyOtp() {
  var btn = document.getElementById('loginBtn2');
  var msg = document.getElementById('loginMsg2');
  msg.textContent = ''; msg.className = 'login-msg';

  var token = ['lo0','lo1','lo2','lo3','lo4','lo5'].map(function(id){ return document.getElementById(id).value; }).join('');
  if (token.length !== 6 || !/^\d{6}$/.test(token)) {
    msg.textContent = 'Please enter the complete 6-digit code.';
    msg.className = 'login-msg error';
    document.getElementById('lo0').focus(); return;
  }
  if (!_sb) { msg.textContent = 'Connection error. Please refresh.'; msg.className = 'login-msg error'; return; }

  btn.disabled = true; btn.textContent = 'Verifying…';

  try {
    var result = await _sb.auth.verifyOtp({ email: _loginEmail, token: token, type: 'email' });
    if (result.error) throw result.error;

    var session = result.data.session;
    if (!session) throw new Error('Login failed. Please try again.');

    /* Fetch member profile to get name */
    var profileResp = await fetch(FW_AUTH.rest_url + '/fw-get-profile', {
      headers: { 'Authorization': 'Bearer ' + session.access_token }
    });
    var profileData = await profileResp.json();

    /* Store session */
    localStorage.setItem('fw_session', JSON.stringify({
      access_token:  session.access_token,
      refresh_token: session.refresh_token,
      user_id:       session.user.id,
      email:         session.user.email,
      first_name:    profileData.profile ? profileData.profile.first_name : '',
      expires_at:    Date.now() + (session.expires_in * 1000),
    }));

    /* If no profile — send to register to complete it */
    if (!profileResp.ok || !profileData.profile) {
      window.location.href = FW_AUTH.register_url + '?complete=1';
      return;
    }

    /* Check if admin, redirect accordingly */
    var urlRedirect = new URLSearchParams(window.location.search).get('redirect');
    if (urlRedirect) {
      window.location.href = urlRedirect;
      return;
    }
    /* Check admin role via API */
    try {
      var adminCheck = await fetch(FW_AUTH.rest_url + '/admin/check', {
        headers: { 'Authorization': 'Bearer ' + session.access_token }
      });
      var adminData = await adminCheck.json();
      if (adminData.success && adminData.is_admin) {
        window.location.href = '<?php echo esc_js(home_url('/admin-dashboard/')); ?>';
      } else {
        window.location.href = FW_AUTH.dashboard_url;
      }
    } catch(e) {
      window.location.href = FW_AUTH.dashboard_url;
    }

  } catch(err) {
    var errMsg = err.message || 'Verification failed.';
    if (errMsg.includes('expired') || errMsg.includes('invalid')) errMsg = 'Code is incorrect or expired. Request a new code below.';
    msg.textContent = errMsg; msg.className = 'login-msg error';
    ['lo0','lo1','lo2','lo3','lo4','lo5'].forEach(function(id){ document.getElementById(id).value=''; });
    document.getElementById('lo0').focus();
  } finally {
    btn.disabled = false; btn.textContent = 'LOG IN →';
  }
}

/* ── Resend ── */
async function loginResendOtp() {
  var btn = document.getElementById('loginResendBtn');
  btn.disabled = true;
  try {
    await _sb.auth.signInWithOtp({ email: _loginEmail, options: { shouldCreateUser: false, emailRedirectTo: null } });
    var msg = document.getElementById('loginMsg2');
    msg.textContent = 'New code sent to ' + _loginEmail; msg.className = 'login-msg success';
    loginStartTimer();
    ['lo0','lo1','lo2','lo3','lo4','lo5'].forEach(function(id){ document.getElementById(id).value=''; });
    document.getElementById('lo0').focus();
  } catch(e) {
    btn.disabled = false; btn.textContent = 'Resend code';
  }
}

function loginGoBack() {
  clearInterval(_loginTimerInterval);
  loginShowStep(1);
  document.getElementById('loginMsg2').textContent = '';
  ['lo0','lo1','lo2','lo3','lo4','lo5'].forEach(function(id){ document.getElementById(id).value=''; });
}

function loginShowStep(n) {
  document.getElementById('loginStep1').classList.remove('active');
  document.getElementById('loginStep2').classList.remove('active');
  document.getElementById('loginStep' + n).classList.add('active');
}

function loginStartTimer() {
  clearInterval(_loginTimerInterval);
  var secs = 30;
  var btn = document.getElementById('loginResendBtn');
  btn.disabled = true;
  btn.textContent = 'Resend code in ' + secs + 's';
  _loginTimerInterval = setInterval(function() {
    secs--;
    if (secs <= 0) {
      clearInterval(_loginTimerInterval);
      btn.disabled = false; btn.textContent = 'Resend code';
    } else {
      btn.textContent = 'Resend code in ' + secs + 's';
    }
  }, 1000);
}

function initLoginOtpBoxes() {
  var boxes = ['lo0','lo1','lo2','lo3','lo4','lo5'];
  boxes.forEach(function(id, idx) {
    var box = document.getElementById(id);
    if (!box) return;
    box.addEventListener('input', function() {
      this.value = this.value.replace(/\D/g,'').slice(-1);
      if (this.value && idx < 5) document.getElementById(boxes[idx+1]).focus();
    });
    box.addEventListener('keydown', function(e) {
      if (e.key === 'Backspace' && !this.value && idx > 0) document.getElementById(boxes[idx-1]).focus();
      if (e.key === 'Enter') loginVerifyOtp();
    });
    box.addEventListener('paste', function(e) {
      e.preventDefault();
      var pasted = (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g,'').slice(0,6);
      pasted.split('').forEach(function(ch, i){ if(boxes[i]) document.getElementById(boxes[i]).value = ch; });
      document.getElementById(boxes[Math.min(pasted.length, 5)]).focus();
    });
  });
}
</script>

<?php get_footer(); ?>
