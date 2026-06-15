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
.reg-success-icon{font-size:56px;text-align:center;margin-bottom:16px}
.pw-wrap{position:relative}
.pw-wrap input{padding-right:44px}
.pw-toggle{position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;color:rgba(255,255,255,.35);cursor:pointer;font-size:16px;padding:4px}
.pw-strength{height:3px;border-radius:2px;margin-top:6px;background:rgba(255,255,255,.08);overflow:hidden}
.pw-strength-bar{height:100%;border-radius:2px;transition:width .3s,background .3s;width:0}
@media(max-width:520px){.reg-box{padding:28px 20px}.reg-row{grid-template-columns:1fr}}
</style>

<div class="reg-wrap">
  <div class="reg-card">

    <div class="reg-logo">
      <a href="<?php echo esc_url(home_url('/')); ?>">FREEWHEEL</a>
      <p>EXPEDITIONS</p>
    </div>

    <!-- STEP 1: Personal Details + Password -->
    <div id="regStep1" class="reg-step active">
      <div class="reg-box">
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
          <label>Password <span style="color:var(--rust)">*</span></label>
          <div class="pw-wrap">
            <input type="password" id="regPassword" placeholder="Min. 8 characters" autocomplete="new-password">
            <button type="button" class="pw-toggle" onclick="togglePw('regPassword',this)">👁</button>
          </div>
          <div class="pw-strength"><div class="pw-strength-bar" id="pwBar"></div></div>
        </div>

        <div class="reg-field">
          <label>Confirm Password <span style="color:var(--rust)">*</span></label>
          <div class="pw-wrap">
            <input type="password" id="regPassword2" placeholder="Repeat password" autocomplete="new-password">
            <button type="button" class="pw-toggle" onclick="togglePw('regPassword2',this)">👁</button>
          </div>
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

        <button class="reg-btn" id="regBtn1" onclick="regSubmitDetails()">CREATE ACCOUNT →</button>
        <div class="reg-msg" id="regMsg1"></div>
      </div>
      <div style="margin-top:16px;background:#0f0d0b;border:1px solid rgba(255,255,255,.12);border-radius:4px;padding:20px;display:flex;align-items:center;justify-content:space-between;gap:12px">
        <div>
          <div style="font-size:13px;color:rgba(255,255,255,.6)">Already have an account?</div>
          <div style="font-size:12px;color:rgba(255,255,255,.35);margin-top:2px">Log in to access your dashboard</div>
        </div>
        <a href="<?php echo esc_url(home_url('/login/')); ?>" style="display:inline-block;padding:11px 22px;background:transparent;border:1px solid var(--rust);color:var(--rust);font-family:var(--headline);font-size:14px;letter-spacing:2px;text-decoration:none;border-radius:2px;white-space:nowrap;transition:background .2s" onmouseover="this.style.background='rgba(193,68,14,.15)'" onmouseout="this.style.background='transparent'">LOG IN →</a>
      </div>
      <div class="reg-msg" style="margin-top:14px;color:rgba(255,255,255,.25)">By registering you agree to our <a href="<?php echo esc_url(home_url('/')); ?>" style="color:rgba(193,68,14,.6)">terms of use</a></div>
    </div>

    <!-- STEP 2: Email Verification Notice -->
    <div id="regStep2" class="reg-step">
      <div class="reg-box" style="text-align:center">
        <div style="font-size:48px;margin-bottom:16px">📧</div>
        <div class="reg-tag" style="text-align:center">Almost There</div>
        <div class="reg-title" style="text-align:center">Verify Your Email</div>
        <p class="reg-sub" style="text-align:center" id="regVerifyMsg">We've sent a confirmation link to your email. Click it to activate your account, then log in.</p>
        <a href="<?php echo esc_url(home_url('/login/')); ?>" class="reg-btn" style="display:block;text-decoration:none;text-align:center;line-height:1;margin-top:8px">GO TO LOGIN →</a>
        <div style="margin-top:16px"><a href="<?php echo esc_url(home_url('/')); ?>" style="color:rgba(255,255,255,.3);font-size:12px;text-decoration:none">Back to home</a></div>
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
document.addEventListener('DOMContentLoaded', function() {
  if (window.supabase && window.FW_AUTH) {
    _sb = supabase.createClient(FW_AUTH.supabase_url, FW_AUTH.supabase_key);
  }
  /* Password strength meter */
  var pwEl = document.getElementById('regPassword');
  if (pwEl) pwEl.addEventListener('input', function(){ updatePwStrength(this.value); });
  /* Enter key */
  ['regFirstName','regLastName','regEmail','regPhone','regCity','regState'].forEach(function(id){
    var el = document.getElementById(id);
    if (el) el.addEventListener('keydown', function(e){ if(e.key==='Enter') regSubmitDetails(); });
  });
});

function togglePw(id, btn) {
  var el = document.getElementById(id);
  if (!el) return;
  el.type = el.type === 'password' ? 'text' : 'password';
  btn.textContent = el.type === 'password' ? '👁' : '🙈';
}

function updatePwStrength(pw) {
  var bar = document.getElementById('pwBar');
  if (!bar) return;
  var score = 0;
  if (pw.length >= 8) score++;
  if (/[A-Z]/.test(pw)) score++;
  if (/[0-9]/.test(pw)) score++;
  if (/[^A-Za-z0-9]/.test(pw)) score++;
  var colors = ['#f87171','#fb923c','#facc15','#4ade80'];
  bar.style.width = (score * 25) + '%';
  bar.style.background = colors[score - 1] || 'transparent';
}

async function regSubmitDetails() {
  var btn = document.getElementById('regBtn1');
  var msg = document.getElementById('regMsg1');
  msg.textContent = ''; msg.className = 'reg-msg';

  var firstName = document.getElementById('regFirstName').value.trim();
  var lastName  = document.getElementById('regLastName').value.trim();
  var email     = document.getElementById('regEmail').value.trim().toLowerCase();
  var password  = document.getElementById('regPassword').value;
  var password2 = document.getElementById('regPassword2').value;
  var phone     = document.getElementById('regPhone').value.trim();
  var city      = document.getElementById('regCity').value.trim();
  var state     = document.getElementById('regState').value.trim();
  var country   = document.getElementById('regCountry').value;

  if (!firstName) { showMsg('regMsg1','First name is required.','error'); document.getElementById('regFirstName').focus(); return; }
  if (!email || !email.includes('@') || !email.includes('.')) { showMsg('regMsg1','Please enter a valid email address.','error'); document.getElementById('regEmail').focus(); return; }
  if (!password || password.length < 8) { showMsg('regMsg1','Password must be at least 8 characters.','error'); document.getElementById('regPassword').focus(); return; }
  if (password !== password2) { showMsg('regMsg1','Passwords do not match.','error'); document.getElementById('regPassword2').focus(); return; }
  if (!_sb) { showMsg('regMsg1','Connection error. Please refresh and try again.','error'); return; }

  btn.disabled = true; btn.textContent = 'Creating account…';

  try {
    /* Sign up with password */
    var result = await _sb.auth.signUp({
      email: email,
      password: password,
      options: {
        data: {
          first_name: firstName,
          last_name: lastName,
          phone: phone,
          city: city,
          state: state,
          country: country
        },
        emailRedirectTo: '<?php echo esc_js(home_url('/login/')); ?>'
      }
    });

    if (result.error) throw result.error;

    /* If session returned immediately (email confirm OFF), save and go to dashboard */
    if (result.data.session) {
      var session = result.data.session;
      localStorage.setItem('fw_session', JSON.stringify({
        access_token:  session.access_token,
        refresh_token: session.refresh_token,
        user_id:       session.user.id,
        email:         session.user.email,
        first_name:    firstName,
        expires_at:    Date.now() + (session.expires_in * 1000),
      }));
      /* Call PHP to ensure fw_members row exists */
      await fetch(FW_AUTH.rest_url + '/fw-register', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'Authorization': 'Bearer ' + session.access_token },
        body: JSON.stringify({ first_name: firstName, last_name: lastName, phone: phone, city: city, state: state, country: country })
      });
      window.location.href = '<?php echo esc_js(home_url('/dashboard/')); ?>';
      return;
    }

    /* Email confirmation required — show verify step */
    document.getElementById('regVerifyMsg').textContent = 'We sent a confirmation link to ' + email + '. Click it to activate your account, then log in with your password.';
    showStep(2);

  } catch(err) {
    var errMsg = err.message || 'Registration failed. Please try again.';
    if (errMsg.toLowerCase().includes('already registered') || errMsg.toLowerCase().includes('already exists')) {
      errMsg = 'An account with this email already exists. <a href="<?php echo esc_js(home_url('/login/')); ?>" style="color:var(--rust)">Log in instead</a>';
      msg.innerHTML = errMsg; msg.className = 'reg-msg error'; return;
    }
    showMsg('regMsg1', errMsg, 'error');
  } finally {
    btn.disabled = false; btn.textContent = 'CREATE ACCOUNT →';
  }
}

function showStep(n) {
  document.getElementById('regStep1').classList.remove('active');
  document.getElementById('regStep2').classList.remove('active');
  document.getElementById('regStep' + n).classList.add('active');
}

function showMsg(id, text, type) {
  var el = document.getElementById(id);
  el.textContent = text;
  el.className = 'reg-msg ' + type;
}
</script>

<?php get_footer(); ?>
