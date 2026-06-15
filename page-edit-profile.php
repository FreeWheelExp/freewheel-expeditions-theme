<?php
/* Template Name: Edit Profile */
get_header();
?>
<style>
.ep-wrap{min-height:100vh;background:var(--ink);display:flex;align-items:flex-start;justify-content:center;padding:100px 20px 60px}
.ep-card{width:100%;max-width:520px}
.ep-title{font-family:var(--headline);font-size:32px;color:#fff;letter-spacing:1px;margin-bottom:4px}
.ep-sub{font-size:13px;color:rgba(255,255,255,.4);margin-bottom:32px}
.ep-box{background:#0f0d0b;border:1px solid rgba(193,68,14,.25);border-radius:4px;padding:32px}
.ep-field{margin-bottom:18px}
.ep-field label{display:block;font-size:10px;letter-spacing:2px;text-transform:uppercase;color:rgba(255,255,255,.4);margin-bottom:6px}
.ep-field input,.ep-field select{width:100%;box-sizing:border-box;padding:12px 14px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.12);color:#fff;font-family:var(--body);font-size:14px;border-radius:2px;outline:none;transition:border-color .2s}
.ep-field input:focus{border-color:rgba(193,68,14,.6)}
.ep-field input::placeholder{color:rgba(255,255,255,.2)}
.ep-row{display:grid;grid-template-columns:1fr 1fr;gap:12px}
.ep-btn{width:100%;padding:14px;background:var(--rust);border:none;color:#fff;font-family:var(--headline);font-size:18px;letter-spacing:2px;cursor:pointer;border-radius:2px;margin-top:8px}
.ep-btn:disabled{opacity:.55;cursor:not-allowed}
.ep-msg{font-size:12px;margin-top:12px;text-align:center;min-height:18px}
.ep-msg.error{color:#f87171}
.ep-msg.success{color:#4ade80}
.ep-back{display:inline-block;margin-bottom:20px;font-size:12px;color:rgba(255,255,255,.4);text-decoration:none;letter-spacing:1px}
.ep-back:hover{color:var(--rust)}
@media(max-width:520px){.ep-box{padding:24px 16px}.ep-row{grid-template-columns:1fr}}
</style>

<div class="ep-wrap">
  <div class="ep-card">
    <a href="<?php echo esc_url(home_url('/dashboard/')); ?>" class="ep-back">← Back to Dashboard</a>
    <div class="ep-title">Edit Profile</div>
    <p class="ep-sub">Update your personal information.</p>

    <div class="ep-box">
      <div class="ep-row">
        <div class="ep-field">
          <label>First Name</label>
          <input type="text" id="epFirstName" placeholder="Rahul">
        </div>
        <div class="ep-field">
          <label>Last Name</label>
          <input type="text" id="epLastName" placeholder="Sharma">
        </div>
      </div>
      <div class="ep-field">
        <label>Phone</label>
        <input type="tel" id="epPhone" placeholder="+91 9876543210">
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
      <div class="ep-field">
        <label>Instagram Handle</label>
        <input type="text" id="epInstagram" placeholder="@yourhandle">
      </div>
      <button class="ep-btn" id="epBtn" onclick="saveProfile()">SAVE CHANGES</button>
      <div class="ep-msg" id="epMsg"></div>
    </div>
  </div>
</div>

<script>
(function(){
  try {
    var s = JSON.parse(localStorage.getItem('fw_session')||'null');
    if (!s || !s.access_token || s.expires_at < Date.now()) {
      window.location.href = '<?php echo esc_js(home_url('/login/')); ?>?redirect=/edit-profile/';
    }
  } catch(e){ window.location.href = '<?php echo esc_js(home_url('/login/')); ?>'; }
})();

document.addEventListener('DOMContentLoaded', function() {
  var s;
  try { s = JSON.parse(localStorage.getItem('fw_session')||'null'); } catch(e){ return; }
  if (!s) return;

  /* Load current profile */
  fetch(FW_AUTH.rest_url + '/fw-get-profile', {
    headers: { 'Authorization': 'Bearer ' + s.access_token }
  }).then(function(r){ return r.json(); })
  .then(function(d) {
    if (!d.profile) return;
    var p = d.profile;
    document.getElementById('epFirstName').value = p.first_name || '';
    document.getElementById('epLastName').value  = p.last_name  || '';
    document.getElementById('epPhone').value     = p.phone      || '';
    document.getElementById('epCity').value      = p.city       || '';
    document.getElementById('epState').value     = p.state      || '';
    document.getElementById('epCountry').value   = p.country    || '';
    document.getElementById('epInstagram').value = p.instagram  || '';
  }).catch(function(){});
});

async function saveProfile() {
  var s;
  try { s = JSON.parse(localStorage.getItem('fw_session')||'null'); } catch(e){ return; }
  if (!s) return;

  var btn = document.getElementById('epBtn');
  var msg = document.getElementById('epMsg');
  msg.textContent = ''; msg.className = 'ep-msg';
  btn.disabled = true; btn.textContent = 'Saving…';

  var payload = {
    first_name: document.getElementById('epFirstName').value.trim(),
    last_name:  document.getElementById('epLastName').value.trim(),
    phone:      document.getElementById('epPhone').value.trim(),
    city:       document.getElementById('epCity').value.trim(),
    state:      document.getElementById('epState').value.trim(),
    country:    document.getElementById('epCountry').value.trim(),
    instagram:  document.getElementById('epInstagram').value.trim(),
  };

  try {
    var r = await fetch(FW_AUTH.rest_url + '/fw-update-profile', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json', 'Authorization': 'Bearer ' + s.access_token },
      body: JSON.stringify(payload)
    });
    var d = await r.json();
    if (d.success) {
      /* Update session first_name */
      s.first_name = payload.first_name;
      localStorage.setItem('fw_session', JSON.stringify(s));
      msg.textContent = 'Profile updated successfully!';
      msg.className = 'ep-msg success';
    } else {
      msg.textContent = d.message || 'Update failed.';
      msg.className = 'ep-msg error';
    }
  } catch(e) {
    msg.textContent = 'Error saving profile. Please try again.';
    msg.className = 'ep-msg error';
  } finally {
    btn.disabled = false; btn.textContent = 'SAVE CHANGES';
  }
}
</script>

<?php get_footer(); ?>
