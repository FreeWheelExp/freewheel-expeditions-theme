<?php
/* Template Name: Edit Profile */
get_header();
?>
<style>
.ep-wrap{min-height:100vh;background:var(--ink);padding:100px 20px 60px}
.ep-inner{max-width:600px;margin:0 auto}
.ep-back{display:inline-block;margin-bottom:24px;font-size:12px;color:rgba(255,255,255,.4);text-decoration:none;letter-spacing:1px;text-transform:uppercase}
.ep-back:hover{color:var(--rust)}
.ep-title{font-family:var(--headline);font-size:32px;color:#fff;letter-spacing:1px;margin-bottom:4px}
.ep-sub{font-size:13px;color:rgba(255,255,255,.4);margin-bottom:32px}
.ep-section{background:#0f0d0b;border:1px solid rgba(193,68,14,.2);border-radius:4px;padding:28px;margin-bottom:20px}
.ep-section-title{font-size:10px;letter-spacing:3px;text-transform:uppercase;color:var(--rust);margin-bottom:20px}
.ep-field{margin-bottom:16px}
.ep-field label{display:block;font-size:10px;letter-spacing:2px;text-transform:uppercase;color:rgba(255,255,255,.4);margin-bottom:6px}
.ep-field input,.ep-field select,.ep-field textarea{width:100%;box-sizing:border-box;padding:12px 14px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.12);color:#fff;font-family:var(--body);font-size:14px;border-radius:2px;outline:none;transition:border-color .2s}
.ep-field input:focus,.ep-field select:focus,.ep-field textarea:focus{border-color:rgba(193,68,14,.6)}
.ep-field input::placeholder,.ep-field textarea::placeholder{color:rgba(255,255,255,.2)}
.ep-field input:disabled{opacity:.4;cursor:not-allowed}
.ep-row{display:grid;grid-template-columns:1fr 1fr;gap:12px}
.ep-btn{padding:12px 24px;background:var(--rust);border:none;color:#fff;font-family:var(--headline);font-size:16px;letter-spacing:2px;cursor:pointer;border-radius:2px;transition:background .2s}
.ep-btn:hover:not(:disabled){background:#a03508}
.ep-btn:disabled{opacity:.55;cursor:not-allowed}
.ep-btn-outline{padding:12px 24px;background:transparent;border:1px solid rgba(255,255,255,.2);color:rgba(255,255,255,.6);font-family:var(--headline);font-size:14px;letter-spacing:2px;cursor:pointer;border-radius:2px}
.ep-msg{font-size:12px;margin-top:10px;min-height:16px}
.ep-msg.error{color:#f87171}
.ep-msg.success{color:#4ade80}
/* Avatar */
.ep-avatar-wrap{display:flex;align-items:center;gap:20px;margin-bottom:20px}
.ep-avatar{width:80px;height:80px;border-radius:50%;border:2px solid rgba(193,68,14,.4);background:rgba(193,68,14,.15);display:flex;align-items:center;justify-content:center;font-family:var(--headline);font-size:28px;color:var(--rust);overflow:hidden;flex-shrink:0}
.ep-avatar img{width:100%;height:100%;object-fit:cover}
.ep-avatar-actions{display:flex;flex-direction:column;gap:8px}
.ep-upload-btn{padding:8px 16px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.12);color:rgba(255,255,255,.7);font-size:12px;letter-spacing:1px;cursor:pointer;border-radius:2px;text-align:center}
.ep-upload-btn:hover{border-color:rgba(193,68,14,.4);color:#fff}
.ep-upload-note{font-size:11px;color:rgba(255,255,255,.3)}
/* OTP */
.ep-otp-wrap{display:none;margin-top:12px}
.ep-otp-input{width:100%;box-sizing:border-box;padding:12px 14px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.12);color:#fff;font-size:18px;letter-spacing:8px;text-align:center;border-radius:2px;outline:none}
.ep-otp-input:focus{border-color:rgba(193,68,14,.6)}
/* Password strength */
.pw-wrap{position:relative}
.pw-wrap input{padding-right:44px}
.pw-toggle{position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;color:rgba(255,255,255,.35);cursor:pointer;font-size:16px;padding:4px}
.pw-strength{height:3px;border-radius:2px;margin-top:6px;background:rgba(255,255,255,.08);overflow:hidden}
.pw-strength-bar{height:100%;border-radius:2px;transition:width .3s,background .3s;width:0}
@media(max-width:520px){.ep-section{padding:20px 16px}.ep-row{grid-template-columns:1fr}.ep-avatar-wrap{flex-direction:column;align-items:flex-start}}
</style>

<div class="ep-wrap">
  <div class="ep-inner">
    <a href="<?php echo esc_url(home_url('/dashboard/')); ?>" class="ep-back">← Back to Dashboard</a>
    <div class="ep-title">Edit Profile</div>
    <p class="ep-sub">Manage your account settings and personal information.</p>

    <!-- Profile Photo -->
    <div class="ep-section">
      <div class="ep-section-title">Profile Photo</div>
      <div class="ep-avatar-wrap">
        <div class="ep-avatar" id="epAvatarPreview"><span id="epAvatarInitial">M</span></div>
        <div class="ep-avatar-actions">
          <label class="ep-upload-btn" for="epAvatarInput">Upload Photo</label>
          <input type="file" id="epAvatarInput" accept="image/*" style="display:none" onchange="handleAvatarUpload(this)">
          <div class="ep-upload-note">Max 2MB. JPG, PNG, WEBP accepted.</div>
          <button class="ep-upload-note" id="epRemoveAvatar" onclick="removeAvatar()" style="background:none;border:none;color:#f87171;cursor:pointer;text-align:left;padding:0;display:none">Remove photo</button>
        </div>
      </div>
      <div class="ep-msg" id="epAvatarMsg"></div>
    </div>

    <!-- Personal Info -->
    <div class="ep-section">
      <div class="ep-section-title">Personal Information</div>
      <div class="ep-row">
        <div class="ep-field">
          <label>First Name</label>
          <input type="text" id="epFirstName" placeholder="Rahul" disabled>
        </div>
        <div class="ep-field">
          <label>Last Name</label>
          <input type="text" id="epLastName" placeholder="Sharma" disabled>
        </div>
      </div>
      <div style="font-size:11px;color:rgba(255,255,255,.3);margin-top:-8px;margin-bottom:16px">Name cannot be changed. Contact support if needed.</div>
      <div class="ep-field">
        <label>Bio</label>
        <textarea id="epBio" placeholder="Tell the community about yourself..." rows="3" style="resize:vertical"></textarea>
      </div>
      <div class="ep-field">
        <label>Instagram Handle</label>
        <input type="text" id="epInstagram" placeholder="@yourhandle">
      </div>
      <div class="ep-row">
        <div class="ep-field">
          <label>City</label>
          <input type="text" id="epCity" placeholder="Haldwani">
        </div>
        <div class="ep-field">
          <label>State</label>
          <input type="text" id="epState" placeholder="Uttarakhand">
        </div>
      </div>
      <div class="ep-field">
        <label>Country</label>
        <input type="text" id="epCountry" placeholder="India">
      </div>
      <button class="ep-btn" id="epInfoBtn" onclick="saveInfo()">SAVE CHANGES</button>
      <div class="ep-msg" id="epInfoMsg"></div>
    </div>

    <!-- Phone -->
    <div class="ep-section">
      <div class="ep-section-title">Phone Number</div>
      <div class="ep-field">
        <label>Phone</label>
        <div style="display:flex;gap:8px">
          <select id="epDialCode" style="width:120px;flex-shrink:0;padding:12px 8px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.12);color:#fff;font-size:13px;border-radius:2px;outline:none">
            <option value="+91">IN +91</option>
            <option value="+1">US +1</option>
            <option value="+44">GB +44</option>
            <option value="+61">AU +61</option>
            <option value="+977">NP +977</option>
            <option value="+94">LK +94</option>
            <option value="+975">BT +975</option>
            <option value="+880">BD +880</option>
            <option value="+971">AE +971</option>
            <option value="+65">SG +65</option>
          </select>
          <input type="tel" id="epPhone" placeholder="9876543210" inputmode="numeric" style="flex:1">
        </div>
      </div>
      <button class="ep-btn" id="epPhoneBtn" onclick="savePhone()">UPDATE PHONE</button>
      <div class="ep-msg" id="epPhoneMsg"></div>
    </div>

    <!-- Email -->
    <div class="ep-section">
      <div class="ep-section-title">Email Address</div>
      <div class="ep-field">
        <label>Current Email</label>
        <input type="email" id="epCurrentEmail" disabled style="opacity:.5">
      </div>
      <div class="ep-field">
        <label>New Email</label>
        <input type="email" id="epNewEmail" placeholder="newemail@gmail.com">
      </div>
      <div class="ep-otp-wrap" id="epEmailOtpWrap">
        <div class="ep-field">
          <label>Verification Code (sent to new email)</label>
          <input type="text" class="ep-otp-input" id="epEmailOtp" placeholder="000000" maxlength="6" inputmode="numeric">
        </div>
        <button class="ep-btn" id="epEmailVerifyBtn" onclick="verifyEmailOtp()">VERIFY & UPDATE</button>
      </div>
      <button class="ep-btn" id="epEmailBtn" onclick="requestEmailChange()">SEND VERIFICATION CODE</button>
      <div class="ep-msg" id="epEmailMsg"></div>
    </div>

    <!-- Password -->
    <div class="ep-section">
      <div class="ep-section-title">Change Password</div>
      <div class="ep-field">
        <label>New Password</label>
        <div class="pw-wrap">
          <input type="password" id="epNewPw" placeholder="Min. 8 characters" autocomplete="new-password">
          <button type="button" class="pw-toggle" onclick="togglePw('epNewPw',this)">👁</button>
        </div>
        <div class="pw-strength"><div class="pw-strength-bar" id="pwBar"></div></div>
      </div>
      <div class="ep-field">
        <label>Confirm New Password</label>
        <div class="pw-wrap">
          <input type="password" id="epNewPw2" placeholder="Repeat password" autocomplete="new-password">
          <button type="button" class="pw-toggle" onclick="togglePw('epNewPw2',this)">👁</button>
        </div>
      </div>
      <button class="ep-btn" id="epPwBtn" onclick="changePassword()">UPDATE PASSWORD</button>
      <div class="ep-msg" id="epPwMsg"></div>
    </div>

  </div>
</div>

<script>
var _sb = null;
var _session = null;
var _token = null;
var _currentAvatarUrl = '';

/* ── Init ── */
(function(){
  try { _session = JSON.parse(localStorage.getItem('fw_session')||'null'); } catch(e){}
  if (!_session || !_session.access_token || _session.expires_at < Date.now()) {
    window.location.href = '<?php echo esc_js(home_url('/login/')); ?>?redirect=/edit-profile/';
    return;
  }
  _token = _session.access_token;
  if (window.supabase && window.FW_AUTH) {
    _sb = supabase.createClient(FW_AUTH.supabase_url, FW_AUTH.supabase_key);
  }
})();

document.addEventListener('DOMContentLoaded', function() {
  document.getElementById('epNewPw').addEventListener('input', function(){ updatePwStrength(this.value); });
  loadProfile();
});

function loadProfile() {
  fetch(FW_AUTH.rest_url + '/fw-get-profile', {
    headers: { 'Authorization': 'Bearer ' + _token }
  }).then(function(r){ return r.json(); })
  .then(function(d) {
    if (!d.profile) return;
    var p = d.profile;
    document.getElementById('epFirstName').value  = p.first_name || '';
    document.getElementById('epLastName').value   = p.last_name  || '';
    document.getElementById('epBio').value        = p.bio        || '';
    document.getElementById('epInstagram').value  = p.instagram  || '';
    document.getElementById('epCity').value       = p.city       || '';
    document.getElementById('epState').value      = p.state      || '';
    document.getElementById('epCountry').value    = p.country    || '';
    document.getElementById('epCurrentEmail').value = p.email    || '';
    /* Phone - split dial code */
    var phone = p.phone || '';
    var dialCode = '+91';
    var number = phone;
    ['+91','+1','+44','+61','+977','+94','+975','+880','+971','+65'].forEach(function(d){
      if (phone.startsWith(d)) { dialCode = d; number = phone.slice(d.length); }
    });
    document.getElementById('epDialCode').value = dialCode;
    document.getElementById('epPhone').value = number;
    /* Avatar */
    var initial = (p.first_name || p.email || 'U')[0].toUpperCase();
    document.getElementById('epAvatarInitial').textContent = initial;
    if (p.avatar_url) {
      _currentAvatarUrl = p.avatar_url;
      var img = document.createElement('img');
      img.src = p.avatar_url;
      var av = document.getElementById('epAvatarPreview');
      av.innerHTML = '';
      av.appendChild(img);
      document.getElementById('epRemoveAvatar').style.display = 'block';
    }
  }).catch(function(){});
}

/* ── Avatar upload ── */
function handleAvatarUpload(input) {
  var file = input.files[0];
  if (!file) return;
  var msg = document.getElementById('epAvatarMsg');
  if (file.size > 2 * 1024 * 1024) {
    msg.textContent = 'File too large. Max 2MB.'; msg.className = 'ep-msg error'; return;
  }
  if (!file.type.match(/image\/(jpeg|jpg|png|webp)/)) {
    msg.textContent = 'Only JPG, PNG, WEBP accepted.'; msg.className = 'ep-msg error'; return;
  }
  msg.textContent = 'Compressing and uploading...'; msg.className = 'ep-msg';
  /* Compress via canvas */
  var reader = new FileReader();
  reader.onload = function(e) {
    var img = new Image();
    img.onload = function() {
      var canvas = document.createElement('canvas');
      var MAX = 400;
      var w = img.width, h = img.height;
      if (w > h) { if (w > MAX) { h = h * MAX / w; w = MAX; } }
      else { if (h > MAX) { w = w * MAX / h; h = MAX; } }
      canvas.width = w; canvas.height = h;
      canvas.getContext('2d').drawImage(img, 0, 0, w, h);
      canvas.toBlob(function(blob) {
        var fd = new FormData();
        fd.append('avatar', blob, 'avatar.jpg');
        fetch(FW_AUTH.rest_url + '/fw-upload-avatar', {
          method: 'POST',
          headers: { 'Authorization': 'Bearer ' + _token },
          body: fd
        }).then(function(r){ return r.json(); })
        .then(function(d) {
          if (d.url) {
            var av = document.getElementById('epAvatarPreview');
            av.innerHTML = '<img src="' + d.url + '?t=' + Date.now() + '" style="width:100%;height:100%;object-fit:cover">';
            document.getElementById('epRemoveAvatar').style.display = 'block';
            msg.textContent = 'Photo updated!'; msg.className = 'ep-msg success';
          } else {
            msg.textContent = d.message || 'Upload failed.'; msg.className = 'ep-msg error';
          }
        }).catch(function(){ msg.textContent = 'Upload failed.'; msg.className = 'ep-msg error'; });
      }, 'image/jpeg', 0.85);
    };
    img.src = e.target.result;
  };
  reader.readAsDataURL(file);
}

function removeAvatar() {
  if (!confirm('Remove your profile photo?')) return;
  fetch(FW_AUTH.rest_url + '/fw-update-profile', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'Authorization': 'Bearer ' + _token },
    body: JSON.stringify({ avatar_url: '' })
  }).then(function(r){ return r.json(); })
  .then(function(d) {
    if (d.success) {
      var av = document.getElementById('epAvatarPreview');
      var initial = document.getElementById('epFirstName').value[0] || 'U';
      av.innerHTML = '<span>' + initial.toUpperCase() + '</span>';
      document.getElementById('epRemoveAvatar').style.display = 'none';
      document.getElementById('epAvatarMsg').textContent = 'Photo removed.';
      document.getElementById('epAvatarMsg').className = 'ep-msg success';
    }
  });
}

/* ── Save personal info ── */
async function saveInfo() {
  var btn = document.getElementById('epInfoBtn');
  var msg = document.getElementById('epInfoMsg');
  msg.textContent = ''; msg.className = 'ep-msg';
  btn.disabled = true; btn.textContent = 'Saving…';
  try {
    var r = await fetch(FW_AUTH.rest_url + '/fw-update-profile', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json', 'Authorization': 'Bearer ' + _token },
      body: JSON.stringify({
        bio:       document.getElementById('epBio').value.trim(),
        instagram: document.getElementById('epInstagram').value.trim(),
        city:      document.getElementById('epCity').value.trim(),
        state:     document.getElementById('epState').value.trim(),
        country:   document.getElementById('epCountry').value.trim(),
      })
    });
    var d = await r.json();
    if (d.success) { msg.textContent = 'Profile updated!'; msg.className = 'ep-msg success'; }
    else { msg.textContent = d.message || 'Update failed.'; msg.className = 'ep-msg error'; }
  } catch(e) { msg.textContent = 'Error. Please try again.'; msg.className = 'ep-msg error'; }
  finally { btn.disabled = false; btn.textContent = 'SAVE CHANGES'; }
}

/* ── Save phone ── */
async function savePhone() {
  var btn = document.getElementById('epPhoneBtn');
  var msg = document.getElementById('epPhoneMsg');
  msg.textContent = ''; msg.className = 'ep-msg';
  var dial = document.getElementById('epDialCode').value;
  var num  = document.getElementById('epPhone').value.trim();
  if (!num) { msg.textContent = 'Please enter a phone number.'; msg.className = 'ep-msg error'; return; }
  btn.disabled = true; btn.textContent = 'Saving…';
  try {
    var r = await fetch(FW_AUTH.rest_url + '/fw-update-profile', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json', 'Authorization': 'Bearer ' + _token },
      body: JSON.stringify({ phone: dial + num })
    });
    var d = await r.json();
    if (d.success) { msg.textContent = 'Phone updated!'; msg.className = 'ep-msg success'; }
    else { msg.textContent = d.message || 'Update failed.'; msg.className = 'ep-msg error'; }
  } catch(e) { msg.textContent = 'Error. Please try again.'; msg.className = 'ep-msg error'; }
  finally { btn.disabled = false; btn.textContent = 'UPDATE PHONE'; }
}

/* ── Email change ── */
async function requestEmailChange() {
  var btn = document.getElementById('epEmailBtn');
  var msg = document.getElementById('epEmailMsg');
  msg.textContent = ''; msg.className = 'ep-msg';
  var newEmail = document.getElementById('epNewEmail').value.trim().toLowerCase();
  if (!newEmail || !newEmail.includes('@')) { msg.textContent = 'Enter a valid email.'; msg.className = 'ep-msg error'; return; }
  if (!_sb) { msg.textContent = 'Connection error.'; msg.className = 'ep-msg error'; return; }
  btn.disabled = true; btn.textContent = 'Sending…';
  try {
    var result = await _sb.auth.updateUser({ email: newEmail });
    if (result.error) throw result.error;
    document.getElementById('epEmailOtpWrap').style.display = 'block';
    document.getElementById('epEmailBtn').style.display = 'none';
    msg.textContent = 'Verification code sent to ' + newEmail + '. Check your inbox.';
    msg.className = 'ep-msg success';
  } catch(e) {
    msg.textContent = e.message || 'Failed to send verification.'; msg.className = 'ep-msg error';
    btn.disabled = false; btn.textContent = 'SEND VERIFICATION CODE';
  }
}

async function verifyEmailOtp() {
  var btn = document.getElementById('epEmailVerifyBtn');
  var msg = document.getElementById('epEmailMsg');
  var otp = document.getElementById('epEmailOtp').value.trim();
  var newEmail = document.getElementById('epNewEmail').value.trim().toLowerCase();
  if (!otp || otp.length < 6) { msg.textContent = 'Enter the 6-digit code.'; msg.className = 'ep-msg error'; return; }
  if (!_sb) return;
  btn.disabled = true; btn.textContent = 'Verifying…';
  try {
    var result = await _sb.auth.verifyOtp({ email: newEmail, token: otp, type: 'email_change' });
    if (result.error) throw result.error;
    document.getElementById('epCurrentEmail').value = newEmail;
    document.getElementById('epNewEmail').value = '';
    document.getElementById('epEmailOtpWrap').style.display = 'none';
    document.getElementById('epEmailBtn').style.display = 'inline-block';
    msg.textContent = 'Email updated successfully!'; msg.className = 'ep-msg success';
    /* Update session */
    _session.email = newEmail;
    localStorage.setItem('fw_session', JSON.stringify(_session));
  } catch(e) {
    msg.textContent = e.message || 'Invalid code.'; msg.className = 'ep-msg error';
    btn.disabled = false; btn.textContent = 'VERIFY & UPDATE';
  }
}

/* ── Password change ── */
async function changePassword() {
  var btn = document.getElementById('epPwBtn');
  var msg = document.getElementById('epPwMsg');
  msg.textContent = ''; msg.className = 'ep-msg';
  var pw  = document.getElementById('epNewPw').value;
  var pw2 = document.getElementById('epNewPw2').value;
  if (!pw || pw.length < 8) { msg.textContent = 'Password must be at least 8 characters.'; msg.className = 'ep-msg error'; return; }
  if (pw !== pw2) { msg.textContent = 'Passwords do not match.'; msg.className = 'ep-msg error'; return; }
  if (!_sb) { msg.textContent = 'Connection error.'; msg.className = 'ep-msg error'; return; }
  btn.disabled = true; btn.textContent = 'Updating…';
  try {
    var result = await _sb.auth.updateUser({ password: pw });
    if (result.error) throw result.error;
    document.getElementById('epNewPw').value = '';
    document.getElementById('epNewPw2').value = '';
    document.getElementById('pwBar').style.width = '0';
    msg.textContent = 'Password updated successfully!'; msg.className = 'ep-msg success';
  } catch(e) {
    msg.textContent = e.message || 'Failed to update password.'; msg.className = 'ep-msg error';
  } finally { btn.disabled = false; btn.textContent = 'UPDATE PASSWORD'; }
}

/* ── Helpers ── */
function togglePw(id, btn) {
  var el = document.getElementById(id);
  el.type = el.type === 'password' ? 'text' : 'password';
  btn.textContent = el.type === 'password' ? '👁' : '🙈';
}

function updatePwStrength(pw) {
  var bar = document.getElementById('pwBar');
  var score = 0;
  if (pw.length >= 8) score++;
  if (/[A-Z]/.test(pw)) score++;
  if (/[0-9]/.test(pw)) score++;
  if (/[^A-Za-z0-9]/.test(pw)) score++;
  var colors = ['#f87171','#fb923c','#facc15','#4ade80'];
  bar.style.width = (score * 25) + '%';
  bar.style.background = colors[score-1] || 'transparent';
}
</script>

<?php get_footer(); ?>
