<?php
/* Template Name: Reset Password */
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

    <!-- Step 1: Request reset link -->
    <div class="login-box" id="rpRequestBox">
      <div class="login-tag">Reset Password</div>
      <div class="login-title">Forgot Password? 🔑</div>
      <p class="login-sub">Enter your email and we'll send you a link to set a new password.</p>

      <div class="login-field">
        <label>Email Address <span style="color:var(--rust)">*</span></label>
        <input type="email" id="rpEmail" placeholder="rahul@gmail.com" autocomplete="email">
      </div>

      <button class="login-btn" id="rpRequestBtn" onclick="rpSendReset()">SEND RESET LINK →</button>
      <div class="login-msg" id="rpRequestMsg"></div>
    </div>

    <!-- Step 2: Set new password (shown only when arriving from the email link) -->
    <div class="login-box" id="rpNewPasswordBox" style="display:none">
      <div class="login-tag">Reset Password</div>
      <div class="login-title">Set New Password 🔒</div>
      <p class="login-sub">Choose a new password for your account.</p>

      <div class="login-field">
        <label>New Password <span style="color:var(--rust)">*</span></label>
        <div class="pw-wrap">
          <input type="password" id="rpNewPw" placeholder="At least 6 characters" autocomplete="new-password">
          <button type="button" class="pw-toggle" onclick="rpTogglePw('rpNewPw')">👁</button>
        </div>
      </div>

      <div class="login-field">
        <label>Confirm Password <span style="color:var(--rust)">*</span></label>
        <div class="pw-wrap">
          <input type="password" id="rpConfirmPw" placeholder="Re-enter password" autocomplete="new-password">
          <button type="button" class="pw-toggle" onclick="rpTogglePw('rpConfirmPw')">👁</button>
        </div>
      </div>

      <button class="login-btn" id="rpSaveBtn" onclick="rpSavePassword()">SAVE NEW PASSWORD →</button>
      <div class="login-msg" id="rpSaveMsg"></div>
    </div>

    <!-- Success screen -->
    <div class="login-box" id="rpSuccessBox" style="display:none;text-align:center">
      <div style="font-size:48px;margin-bottom:12px">✅</div>
      <div class="login-title">Password Updated!</div>
      <p class="login-sub">You can now log in with your new password.</p>
      <a href="<?php echo esc_url(home_url('/login/')); ?>" class="login-btn" style="display:block;text-decoration:none;box-sizing:border-box;text-align:center">GO TO LOGIN →</a>
    </div>

    <div class="login-link" style="margin-top:20px">Remembered your password? <a href="<?php echo esc_url(home_url('/login/')); ?>">Log in</a></div>

  </div>
</div>

<script>
var _sb = null;

function rpTogglePw(id) {
  var el = document.getElementById(id);
  el.type = el.type === 'password' ? 'text' : 'password';
}

function rpShowOnly(id) {
  ['rpRequestBox','rpNewPasswordBox','rpSuccessBox'].forEach(function(b){
    document.getElementById(b).style.display = (b === id) ? 'block' : 'none';
  });
}

window.rpSendReset = async function() {
  var email = (document.getElementById('rpEmail').value || '').trim();
  var msg = document.getElementById('rpRequestMsg');
  var btn = document.getElementById('rpRequestBtn');
  if (!email) { msg.textContent = 'Please enter your email.'; msg.className = 'login-msg error'; return; }
  if (!_sb) { msg.textContent = 'Service unavailable. Please refresh and try again.'; msg.className = 'login-msg error'; return; }

  btn.disabled = true; btn.textContent = 'Sending…';
  try {
    var redirectTo = '<?php echo esc_js(home_url('/reset-password/')); ?>';
    var result = await _sb.auth.resetPasswordForEmail(email, { redirectTo: redirectTo });
    if (result.error) throw result.error;
    msg.textContent = "Check your email — we've sent you a reset link.";
    msg.className = 'login-msg success';
    btn.textContent = 'LINK SENT ✓';
  } catch (err) {
    msg.textContent = err.message || 'Could not send reset link. Try again.';
    msg.className = 'login-msg error';
    btn.disabled = false; btn.textContent = 'SEND RESET LINK →';
  }
};

window.rpSavePassword = async function() {
  var pw1 = document.getElementById('rpNewPw').value;
  var pw2 = document.getElementById('rpConfirmPw').value;
  var msg = document.getElementById('rpSaveMsg');
  var btn = document.getElementById('rpSaveBtn');

  if (!pw1 || pw1.length < 6) { msg.textContent = 'Password must be at least 6 characters.'; msg.className = 'login-msg error'; return; }
  if (pw1 !== pw2) { msg.textContent = 'Passwords do not match.'; msg.className = 'login-msg error'; return; }
  if (!_sb) { msg.textContent = 'Service unavailable. Please refresh and try again.'; msg.className = 'login-msg error'; return; }

  btn.disabled = true; btn.textContent = 'Saving…';
  try {
    var result = await _sb.auth.updateUser({ password: pw1 });
    if (result.error) throw result.error;
    localStorage.removeItem('fw_session');
    rpShowOnly('rpSuccessBox');
  } catch (err) {
    msg.textContent = err.message || 'Could not update password. Request a new link and try again.';
    msg.className = 'login-msg error';
    btn.disabled = false; btn.textContent = 'SAVE NEW PASSWORD →';
  }
};

document.addEventListener('DOMContentLoaded', function() {
  if (window.supabase && window.FW_AUTH) {
    _sb = supabase.createClient(FW_AUTH.supabase_url, FW_AUTH.supabase_key);
  }

  /* Supabase sends the user back here with a recovery token in the URL hash
     (#access_token=...&type=recovery) — detect that and show the "set new
     password" form instead of the "request a link" form. */
  var hash = window.location.hash || '';
  if (hash.indexOf('type=recovery') !== -1) {
    rpShowOnly('rpNewPasswordBox');
  } else {
    rpShowOnly('rpRequestBox');
  }

  document.getElementById('rpEmail').addEventListener('keydown', function(e){ if (e.key === 'Enter') rpSendReset(); });
  document.getElementById('rpConfirmPw').addEventListener('keydown', function(e){ if (e.key === 'Enter') rpSavePassword(); });
});
</script>

<?php get_footer(); ?>
