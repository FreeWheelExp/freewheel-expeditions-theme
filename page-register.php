<?php
/* Template Name: Register */
get_header();
?>
<style>
.reg-wrap{min-height:100vh;background:var(--ink);display:flex;align-items:center;justify-content:center;padding:80px 20px 60px}
.reg-card{width:100%;max-width:480px}
.reg-logo{text-align:center;margin-bottom:32px}
.reg-logo a{font-family:var(--headline);font-size:28px;color:var(--rust);letter-spacing:3px;text-decoration:none}
.reg-logo p{font-size:11px;color:rgba(255,255,255,.35);letter-spacing:2px;margin-top:4px}
.reg-box{background:#0f0d0b;border:1px solid rgba(193,68,14,.25);border-radius:4px;padding:36px 32px}
.reg-tag{font-size:10px;letter-spacing:3px;text-transform:uppercase;color:var(--rust);margin-bottom:8px}
.reg-title{font-family:var(--headline);font-size:28px;color:#fff;letter-spacing:1px;margin-bottom:6px}
.reg-sub{font-size:13px;color:rgba(255,255,255,.4);line-height:1.6;margin-bottom:28px}
.reg-field{margin-bottom:16px}
.reg-field label{display:block;font-size:10px;letter-spacing:2px;text-transform:uppercase;color:rgba(255,255,255,.4);margin-bottom:6px}
.reg-field input,.reg-field select{width:100%;box-sizing:border-box;padding:12px 14px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.12);color:#fff;font-family:var(--body);font-size:14px;border-radius:2px;outline:none;transition:border-color .2s}
.reg-field input:focus,.reg-field select:focus{border-color:rgba(193,68,14,.6)}
.reg-field input::placeholder{color:rgba(255,255,255,.2)}
.reg-field select option{background:#1a1410;color:#fff}
.reg-row{display:grid;grid-template-columns:1fr 1fr;gap:12px}
.reg-btn{width:100%;padding:14px;background:var(--rust);border:none;color:#fff;font-family:var(--headline);font-size:18px;letter-spacing:2px;cursor:pointer;border-radius:2px;transition:background .2s;margin-top:8px}
.reg-btn:hover:not(:disabled){background:#a03508}
.reg-btn:disabled{opacity:.55;cursor:not-allowed}
.reg-msg{font-size:12px;margin-top:12px;text-align:center;min-height:18px}
.reg-msg.error{color:#f87171}
.reg-msg.success{color:#4ade80}
.reg-step{display:none}
.reg-step.active{display:block}
.otp-row{display:flex;gap:10px;justify-content:center;margin:20px 0}
.otp-box{width:48px;height:56px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.15);border-radius:2px;color:#fff;font-size:24px;font-family:var(--headline);text-align:center;outline:none;transition:border-color .2s}
.otp-box:focus{border-color:var(--rust)}
.reg-link{text-align:center;margin-top:20px;font-size:13px;color:rgba(255,255,255,.35)}
.reg-link a{color:var(--rust);text-decoration:none}
.reg-progress{display:flex;gap:8px;margin-bottom:24px}
.reg-progress span{height:3px;border-radius:2px;flex:1;background:rgba(255,255,255,.1);transition:background .3s}
.reg-progress span.done{background:var(--rust)}
.reg-resend{background:none;border:none;color:rgba(255,255,255,.4);font-size:12px;cursor:pointer;padding:0;margin-top:8px;text-decoration:underline}
.reg-resend:disabled{color:rgba(255,255,255,.2);cursor:not-allowed;text-decoration:none}
.reg-success-icon{font-size:56px;text-align:center;margin-bottom:16px}
@media(max-width:520px){.reg-box{padding:28px 20px}.reg-row{grid-template-columns:1fr}.otp-box{width:40px;height:50px;font-size:20px}}
</style>

<div class="reg-wrap">
  <div class="reg-card">

    <div class="reg-logo">
      <a href="<?php echo esc_url(home_url('/')); ?>">FREEWHEEL</a>
      <p>EXPEDITIONS</p>
    </div>

    <!-- STEP 1: Personal Details -->
    <div id="regStep1" class="reg-step active">
      <div class="reg-box">
        <div class="reg-progress"><span class="done"></span><span></span></div>
        <div class="reg-tag">Join the Community</div>
        <div class="reg-title">Create Account</div>
        <p class="reg-sub">Fill in your details below to join the FreeWheel community.</p>

        <div class="reg-row">
          <div class="reg-field">
            <label>First Name <span style="color:var(--rust)">*</span></label>
            <input type="text" id="regFirstName" placeholder="Rahul" autocomplete="given-name">
          </div>
          <div class="reg-field">
            <label>Last Name</label>
            <input type="text" id="regLastName" placeholder="Sharma" autocomplete="family-name">
          </div>
        </div>

        <div class="reg-field">
          <label>Email Address <span style="color:var(--rust)">*</span></label>
          <input type="email" id="regEmail" placeholder="rahul@gmail.com" autocomplete="email">
        </div>

        <div class="reg-field">
          <label>Phone Number</label>
          <input type="tel" id="regPhone" placeholder="9876543210" autocomplete="tel" inputmode="numeric">
        </div>

        <div class="reg-row">
          <div class="reg-field">
            <label>City</label>
            <input type="text" id="regCity" placeholder="Delhi" autocomplete="address-level2">
          </div>
          <div class="reg-field">
            <label>State</label>
            <input type="text" id="regState" placeholder="Delhi" autocomplete="address-level1">
          </div>
        </div>

        <div class="reg-field">
          <label>Country</label>
          <select id="regCountry">
            <option value="India" selected>India</option>
            <option value="Nepal">Nepal</option>
            <option value="Bhutan">Bhutan</option>
            <option value="Sri Lanka">Sri Lanka</option>
            <option value="Other">Other</option>
          </select>
        </div>

        <button class="reg-btn" id="regBtn1" onclick="regSubmitDetails()">CONTINUE →</button>
        <div class="reg-msg" id="regMsg1"></div>
      </div>
      <!-- Login CTA -->
      <div style="margin-top:16px;background:#0f0d0b;border:1px solid rgba(255,255,255,.12);border-radius:4px;padding:20px;display:flex;align-items:center;justify-content:space-between;gap:12px">
        <div>
          <div style="font-size:13px;color:rgba(255,255,255,.6)">Already have an account?</div>
          <div style="font-size:12px;color:rgba(255,255,255,.35);margin-top:2px">Log in to access your dashboard</div>
        </div>
        <a href="<?php echo esc_url(home_url('/login/')); ?>" style="display:inline-block;padding:11px 22px;background:transparent;border:1px solid var(--rust);color:var(--rust);font-family:var(--headline);font-size:14px;letter-spacing:2px;text-decoration:none;border-radius:2px;white-space:nowrap;transition:background .2s" onmouseover="this.style.background='rgba(193,68,14,.15)'" onmouseout="this.style.background='transparent'">LOG IN →</a>
      </div>
      <div class="reg-link" style="margin-top:14px">By registering you agree to our <a href="<?php echo esc_url(home_url('/')); ?>">terms of use</a></div>
    </div>

    <!-- STEP 2: OTP Verification -->
    <div id="regStep2" class="reg-step">
      <div class="reg-box">
        <div class="reg-progress"><span class="done"></span><span class="done"></span></div>
        <div class="reg-tag">Verify Your Email</div>
        <div class="reg-title">Enter OTP</div>
        <p class="reg-sub" id="regOtpSub">We sent a 6-digit code to your email.</p>

        <div class="otp-row">
          <input class="otp-box" id="ro0" maxlength="1" inputmode="numeric" pattern="[0-9]">
          <input class="otp-box" id="ro1" maxlength="1" inputmode="numeric" pattern="[0-9]">
          <input class="otp-box" id="ro2" maxlength="1" inputmode="numeric" pattern="[0-9]">
          <input class="otp-box" id="ro3" maxlength="1" inputmode="numeric" pattern="[0-9]">
          <input class="otp-box" id="ro4" maxlength="1" inputmode="numeric" pattern="[0-9]">
          <input class="otp-box" id="ro5" maxlength="1" inputmode="numeric" pattern="[0-9]">
        </div>

        <button class="reg-btn" id="regBtn2" onclick="regVerifyOtp()">VERIFY & CREATE ACCOUNT</button>
        <div class="reg-msg" id="regMsg2"></div>
        <div style="text-align:center;margin-top:14px">
          <button class="reg-resend" id="regResendBtn" onclick="regResendOtp()" disabled>Resend code in <span id="regTimer">30</span>s</button>
        </div>
        <div style="text-align:center;margin-top:16px">
          <button onclick="regGoBack()" style="background:none;border:none;color:rgba(255,255,255,.35);font-size:12px;cursor:pointer">← Back</button>
        </div>
      </div>
    </div>

    <!-- STEP 3: Success -->
    <div id="regStep3" class="reg-step">
      <div class="reg-box" style="text-align:center">
        <div class="reg-success-icon">🏔️</div>
        <div class="reg-tag" style="text-align:center">Welcome to FreeWheel</div>
        <div class="reg-title" id="regWelcomeName" style="text-align:center">You're in!</div>
        <p class="reg-sub" style="text-align:center;margin-bottom:24px">Your account is ready. We've added <strong style="color:var(--amber)">50 welcome credits</strong> to your account — enough for ₹12.50 off your first merchandise order.</p>
        <a href="<?php echo esc_url(home_url('/dashboard/')); ?>" class="reg-btn" style="display:block;text-decoration:none;text-align:center;line-height:1">GO TO MY DASHBOARD →</a>
        <div style="margin-top:16px"><a href="<?php echo esc_url(home_url('/')); ?>" style="color:rgba(255,255,255,.3);font-size:12px;text-decoration:none">Back to home</a></div>
      </div>
    </div>

  </div>
</div>

<script>
/* ── Session check — redirect if already logged in ── */
(function(){
  try {
    var s = JSON.parse(localStorage.getItem('fw_session') || 'null');
    if (s && s.access_token && s.expires_at > Date.now()) {
      window.location.href = '<?php echo esc_js(home_url('/dashboard/')); ?>';
    }
  } catch(e){}
})();

/* ── Supabase client init ── */
var _sb = null;
document.addEventListener('DOMContentLoaded', function() {
  if (window.supabase && window.FW_AUTH) {
    _sb = supabase.createClient(FW_AUTH.supabase_url, FW_AUTH.supabase_key);
  }
  initOtpBoxes();
});

/* ── Pending registration data ── */
var _reg = {};
var _regTimerInterval = null;

/* ── Step 1: Collect & send OTP ── */
async function regSubmitDetails() {
  var btn = document.getElementById('regBtn1');
  var msg = document.getElementById('regMsg1');
  msg.textContent = ''; msg.className = 'reg-msg';

  var firstName = document.getElementById('regFirstName').value.trim();
  var lastName  = document.getElementById('regLastName').value.trim();
  var email     = document.getElementById('regEmail').value.trim().toLowerCase();
  var phone     = document.getElementById('regPhone').value.trim();
  var city      = document.getElementById('regCity').value.trim();
  var state     = document.getElementById('regState').value.trim();
  var country   = document.getElementById('regCountry').value;

  if (!firstName) { showMsg('regMsg1', 'First name is required.', 'error'); document.getElementById('regFirstName').focus(); return; }
  if (!email || !email.includes('@') || !email.includes('.')) { showMsg('regMsg1', 'Please enter a valid email address.', 'error'); document.getElementById('regEmail').focus(); return; }

  if (!_sb) { showMsg('regMsg1', 'Connection error. Please refresh and try again.', 'error'); return; }

  _reg = { firstName, lastName, email, phone, city, state, country };

  btn.disabled = true; btn.textContent = 'Sending code…';

  try {
    var result = await _sb.auth.signInWithOtp({
      email: email,
      options: { shouldCreateUser: true }
    });
    if (result.error) throw result.error;

    document.getElementById('regOtpSub').textContent = 'We sent a 6-digit code to ' + email;
    showStep(2);
    startResendTimer();
    setTimeout(function(){ document.getElementById('ro0').focus(); }, 300);

  } catch(err) {
    showMsg('regMsg1', err.message || 'Failed to send verification code. Please try again.', 'error');
  } finally {
    btn.disabled = false; btn.textContent = 'CONTINUE →';
  }
}

/* ── Step 2: Verify OTP → create account → save session ── */
async function regVerifyOtp() {
  var btn = document.getElementById('regBtn2');
  var msg = document.getElementById('regMsg2');
  msg.textContent = ''; msg.className = 'reg-msg';

  var token = ['ro0','ro1','ro2','ro3','ro4','ro5'].map(function(id){ return document.getElementById(id).value; }).join('');
  if (token.length !== 6 || !/^\d{6}$/.test(token)) {
    showMsg('regMsg2', 'Please enter the complete 6-digit code.', 'error');
    document.getElementById('ro0').focus(); return;
  }

  if (!_sb) { showMsg('regMsg2', 'Connection error. Please refresh.', 'error'); return; }

  btn.disabled = true; btn.textContent = 'Verifying…';

  try {
    var result = await _sb.auth.verifyOtp({ email: _reg.email, token: token, type: 'email' });
    if (result.error) throw result.error;

    var session = result.data.session;
    if (!session) throw new Error('Verification failed. Please try again.');

    /* Store session */
    localStorage.setItem('fw_session', JSON.stringify({
      access_token:  session.access_token,
      refresh_token: session.refresh_token,
      user_id:       session.user.id,
      email:         session.user.email,
      expires_at:    Date.now() + (session.expires_in * 1000),
    }));

    /* Call PHP to create fw_members row + award credits */
    btn.textContent = 'Creating account…';
    var regResp = await fetch(FW_AUTH.rest_url + '/fw-register', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Authorization': 'Bearer ' + session.access_token,
      },
      body: JSON.stringify({
        first_name: _reg.firstName,
        last_name:  _reg.lastName,
        phone:      _reg.phone,
        city:       _reg.city,
        state:      _reg.state,
        country:    _reg.country,
      }),
    });

    var regData = await regResp.json();
    if (!regResp.ok) throw new Error(regData.message || 'Account setup failed.');

    /* Update stored session with name */
    var stored = JSON.parse(localStorage.getItem('fw_session'));
    stored.first_name = _reg.firstName;
    localStorage.setItem('fw_session', JSON.stringify(stored));

    /* Check admin role */
    var isAdmin = false;
    try {
      var ac = await fetch(FW_AUTH.rest_url + '/admin/check', { headers: { 'Authorization': 'Bearer ' + session.access_token } });
      var ad = await ac.json();
      isAdmin = ad.success && ad.is_admin;
    } catch(e){}

    /* Show success */
    var isNew = !regData.existing;
    document.getElementById('regWelcomeName').textContent = 'Welcome, ' + _reg.firstName + '!';
    if (!isNew) {
      document.querySelector('#regStep3 .reg-sub').innerHTML = 'You already have an account. You\'re now logged in.';
    }
    /* Update dashboard link if admin */
    if (isAdmin) {
      var dashBtn = document.querySelector('#regStep3 a.reg-btn');
      if (dashBtn) { dashBtn.href = '<?php echo esc_js(home_url('/admin-dashboard/')); ?>'; dashBtn.textContent = 'GO TO ADMIN DASHBOARD →'; }
    }
    showStep(3);

  } catch(err) {
    var errMsg = err.message || 'Verification failed.';
    if (errMsg.includes('expired') || errMsg.includes('invalid')) errMsg = 'Code is incorrect or expired. Please try again or request a new code.';
    showMsg('regMsg2', errMsg, 'error');
    ['ro0','ro1','ro2','ro3','ro4','ro5'].forEach(function(id){ document.getElementById(id).value=''; });
    document.getElementById('ro0').focus();
  } finally {
    btn.disabled = false; btn.textContent = 'VERIFY & CREATE ACCOUNT';
  }
}

/* ── Resend OTP ── */
async function regResendOtp() {
  var btn = document.getElementById('regResendBtn');
  btn.disabled = true;
  try {
    await _sb.auth.signInWithOtp({ email: _reg.email, options: { shouldCreateUser: true } });
    showMsg('regMsg2', 'New code sent to ' + _reg.email, 'success');
    startResendTimer();
    ['ro0','ro1','ro2','ro3','ro4','ro5'].forEach(function(id){ document.getElementById(id).value=''; });
    document.getElementById('ro0').focus();
  } catch(e) {
    showMsg('regMsg2', 'Failed to resend. Please wait a moment and try again.', 'error');
    btn.disabled = false;
    btn.textContent = 'Resend code';
  }
}

function regGoBack() {
  clearInterval(_regTimerInterval);
  showStep(1);
  document.getElementById('regMsg2').textContent = '';
}

/* ── Helpers ── */
function showStep(n) {
  document.getElementById('regStep1').classList.remove('active');
  document.getElementById('regStep2').classList.remove('active');
  document.getElementById('regStep3').classList.remove('active');
  document.getElementById('regStep' + n).classList.add('active');
}

function showMsg(id, text, type) {
  var el = document.getElementById(id);
  el.textContent = text;
  el.className = 'reg-msg ' + type;
}

function startResendTimer() {
  clearInterval(_regTimerInterval);
  var secs = 30;
  var timerEl = document.getElementById('regTimer');
  var resendBtn = document.getElementById('regResendBtn');
  resendBtn.disabled = true;
  resendBtn.textContent = 'Resend code in ' + secs + 's';
  _regTimerInterval = setInterval(function() {
    secs--;
    if (secs <= 0) {
      clearInterval(_regTimerInterval);
      resendBtn.disabled = false;
      resendBtn.textContent = 'Resend code';
    } else {
      resendBtn.textContent = 'Resend code in ' + secs + 's';
    }
  }, 1000);
}

function initOtpBoxes() {
  var boxes = ['ro0','ro1','ro2','ro3','ro4','ro5'];
  boxes.forEach(function(id, idx) {
    var box = document.getElementById(id);
    if (!box) return;
    box.addEventListener('input', function() {
      this.value = this.value.replace(/\D/g,'').slice(-1);
      if (this.value && idx < 5) document.getElementById(boxes[idx+1]).focus();
    });
    box.addEventListener('keydown', function(e) {
      if (e.key === 'Backspace' && !this.value && idx > 0) document.getElementById(boxes[idx-1]).focus();
      if (e.key === 'Enter') regVerifyOtp();
    });
    box.addEventListener('paste', function(e) {
      e.preventDefault();
      var pasted = (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g,'').slice(0,6);
      pasted.split('').forEach(function(ch, i) {
        if (boxes[i]) document.getElementById(boxes[i]).value = ch;
      });
      var last = Math.min(pasted.length, 5);
      document.getElementById(boxes[last]).focus();
    });
  });
}

/* Enter key on Step 1 fields */
['regFirstName','regLastName','regEmail','regPhone','regCity','regState'].forEach(function(id){
  var el = document.getElementById(id);
  if (el) el.addEventListener('keydown', function(e){ if(e.key==='Enter') regSubmitDetails(); });
});
</script>

<?php get_footer(); ?>
