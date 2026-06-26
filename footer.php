<?php
/**
 * FreeWheel Expeditions — footer.php v2.0
 */
?>

<footer>
  <div class="foot-logo">
    <img src="<?php echo get_template_directory_uri(); ?>/images/footer-1.jpg" alt="FreeWheel Expeditions Logo" loading="lazy">
    <span class="foot-brand">FREEWHEEL EXPEDITIONS</span>
  </div>
  <span class="foot-copy">© <?php echo date('Y'); ?> FreeWheel Expeditions · freewheelexpeditions.in</span>
  <div class="foot-links">
    <a href="<?php echo home_url('/expeditions/'); ?>">Expeditions</a>
    <a href="<?php echo home_url('/blog/'); ?>">Blog</a>
    <a href="https://wa.me/917817838060" target="_blank">Contact</a>
    <a href="https://instagram.com/freewheelexpeditions" target="_blank" rel="noopener noreferrer">Instagram</a>
    <a href="https://www.facebook.com/groups/freewheelexpeditions" target="_blank" rel="noopener noreferrer">Facebook</a>
    <a href="<?php echo home_url('/privacy-policy/'); ?>">Privacy Policy</a>
    <a href="<?php echo home_url('/terms-and-conditions/'); ?>">Terms</a>
    <a href="<?php echo home_url('/refund-policy/'); ?>">Refund Policy</a>
  </div>
</footer>


<div class="overlay" id="regOverlay" onclick="closeIfOutside(event,'regOverlay')">
  <div class="modal" style="max-width:560px" onclick="event.stopPropagation()">
    <button class="modal-close" onclick="closeModal('regOverlay')">✕</button>
    <div class="modal-head">
      <span class="modal-trip-tag">Free Membership</span>
      <div class="modal-title">Create Your Account</div>
      <div class="modal-sub">Unlock perks — 5% off from your 2nd trip onwards</div>
    </div>
    <div class="modal-body" id="regModalBody">

      <!-- Success screen (hidden by default) -->
      <div id="regSuccessBox" style="display:none;text-align:center;padding:24px 0">
        <div style="font-size:56px;margin-bottom:12px">🎉</div>
        <div class="success-h">Welcome to FreeWheel!</div>
        <p class="success-p">Your account is created. Check your email for confirmation and member perks.</p>
        <button class="m-btn" style="margin-top:20px" onclick="closeModal('regOverlay')">Let's Go!</button>
      </div>

      <!-- Registration form -->
      <div id="regFormBox">
        <div style="background:linear-gradient(135deg,var(--teal),#1a5a50);padding:14px 18px;display:flex;align-items:center;gap:12px;margin-bottom:20px;border-radius:2px">
          <div style="font-family:var(--headline);font-size:26px;color:var(--amber)">5%</div>
          <div style="font-size:12px;color:rgba(255,255,255,.85);font-weight:300;line-height:1.5">
            <strong style="color:#fff;font-weight:500">Discount on every trip after your first</strong><br>
            Plus merchandise, early access &amp; loyalty tiers
          </div>
        </div>

        <!-- Error message -->
        <div id="regError" style="display:none;background:#fef2f0;border-left:3px solid #c1440e;padding:10px 14px;margin-bottom:16px;font-size:13px;color:#c1440e;border-radius:2px"></div>

        <div class="fg-row">
          <div class="fg"><label>First Name</label><input type="text" id="regFirstName" placeholder="Rahul" required></div>
          <div class="fg"><label>Last Name</label><input type="text" id="regLastName" placeholder="Sharma" required></div>
        </div>
        <div class="fg"><label>Email</label><input type="email" id="regEmail" placeholder="rahul@email.com" required></div>
        <div class="fg"><label>Phone</label><input type="tel" id="regPhone" placeholder="+91 98765 43210" required></div>
        <div class="fg"><label>Password</label><input type="password" id="regPassword" placeholder="Create a password (min 6 chars)" required></div>
        <div class="fg"><label>City</label><input type="text" id="regCity" placeholder="Start typing your city..." autocomplete="off"></div>

        <button class="m-btn" id="regSubmitBtn" onclick="handleRegister()">Create Free Account</button>
        <p class="m-note">Already registered? <a href="#" style="color:var(--rust)" onclick="closeModal('regOverlay');openLoginModal();return false;">Sign in here</a>. Your data is never shared with third parties.</p>
      </div>

    </div>
  </div>
</div>

<!-- LOGIN MODAL -->
<div class="overlay" id="loginOverlay" onclick="closeIfOutside(event,'loginOverlay')">
  <div class="modal" style="max-width:460px" onclick="event.stopPropagation()">
    <button class="modal-close" onclick="closeModal('loginOverlay')">✕</button>
    <div class="modal-head">
      <span class="modal-trip-tag">Member Login</span>
      <div class="modal-title">Welcome Back</div>
      <div class="modal-sub">Sign in to your FreeWheel account</div>
    </div>
    <div class="modal-body">
      <div id="loginError" style="display:none;background:#fef2f0;border-left:3px solid #c1440e;padding:10px 14px;margin-bottom:16px;font-size:13px;color:#c1440e;border-radius:2px"></div>
      <div class="fg"><label>Email</label><input type="email" id="loginEmail" placeholder="rahul@email.com"></div>
      <div class="fg"><label>Password</label><input type="password" id="loginPassword" placeholder="Your password"></div>
      <button class="m-btn" id="loginSubmitBtn" onclick="handleLogin()">Sign In</button>
      <p class="m-note">New here? <a href="#" style="color:var(--rust)" onclick="closeModal('loginOverlay');openRegModal();return false;">Create free account</a>.</p>
    </div>
  </div>
</div>






<!-- ═══ DYNAMIC ENGINE ═══ -->

<!-- ═══ FLOATING WHATSAPP BUTTON — site-wide, bottom-right ═══ -->
<a href="https://wa.me/917817838060?text=<?php echo urlencode('Hi FreeWheel! 👋 I have a question about your expeditions.'); ?>"
   target="_blank" rel="noopener"
   id="fwWaFloat"
   aria-label="Chat with us on WhatsApp"
   style="position:fixed;bottom:22px;right:22px;width:56px;height:56px;background:#25D366;border-radius:50%;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 16px rgba(0,0,0,.35);z-index:998;text-decoration:none;transition:transform .15s">
  <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="#fff"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.123.554 4.118 1.528 5.85L.057 23.077a.75.75 0 0 0 .943.895l5.344-1.705A11.945 11.945 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.75a9.726 9.726 0 0 1-4.964-1.355l-.355-.212-3.693 1.178 1.131-3.595-.232-.371A9.725 9.725 0 0 1 2.25 12C2.25 6.615 6.615 2.25 12 2.25S21.75 6.615 21.75 12 17.385 21.75 12 21.75z"/></svg>
</a>
<style>
#fwWaFloat:hover{transform:scale(1.08)}
/* Keep it clear of the mobile sticky booking bar on expedition pages */
@media(max-width:900px){#fwWaFloat{bottom:90px;width:50px;height:50px}}
</style>

<?php wp_footer(); ?>
</body>
</html>
