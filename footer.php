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

<div class="overlay" id="bookingOverlay" onclick="closeIfOutside(event,'bookingOverlay')">
  <div class="modal" id="bookingModal" onclick="event.stopPropagation()">
    <button class="modal-close" onclick="closeModal('bookingOverlay')">✕</button>
    <div class="modal-head">
      <span class="modal-trip-tag" id="bTag">Book Expedition</span>
      <div class="modal-title" id="bName">–</div>
      <div class="modal-sub" id="bMeta">–</div>
    </div>
    <div class="modal-body">
      <div class="step-tabs"><div class="stab active" id="st1">01 Details</div><div class="stab" id="st2">02 Payment</div><div class="stab" id="st3">03 Done</div></div>
      <div class="step-panel visible" id="sp1">
        <div class="fg-row"><div class="fg"><label>First Name</label><input type="text" id="bFirst" placeholder="Rahul"></div><div class="fg"><label>Last Name</label><input type="text" id="bLast" placeholder="Sharma"></div></div>
        <div class="fg"><label>Email</label><input type="email" id="bEmail" placeholder="rahul@email.com"></div>
        <div class="fg"><label>Phone</label><input type="tel" id="bPhone" placeholder="+91 98765 43210"></div>
        <div class="fg"><label>Number of Travellers</label><select id="bTrav"><option>1 Person</option><option>2 Persons</option><option>3 Persons</option><option>4 Persons</option></select></div>
        <div class="fg"><label>Vehicle Type</label><select id="bVeh"><option>Self Drive – Own SUV</option><option>Self Drive – Own Sedan/Hatchback</option><option>Seat Sharing (with vehicle)</option></select></div>
        <button class="m-btn" onclick="goStep(2)">Continue to Payment →</button>
        <p class="m-note">100% refund available up to 30 days before departure. By proceeding you agree to our booking terms.</p>
      </div>
      <div class="step-panel" id="sp2">
        <div class="trip-price-summary"><div><div class="tps-label">Amount Due</div><div style="font-size:11px;color:#8a7052;font-weight:300;margin-top:2px" id="bPayNote">–</div></div><div class="tps-amount" id="bPayAmt">–</div></div>
        <p style="font-size:12px;letter-spacing:2px;text-transform:uppercase;color:#8a7052;font-weight:600;margin-bottom:10px">Choose Payment Option</p>
        <div class="payment-opts">
          <div class="pay-opt selected" id="pFull" onclick="selPay('full')"><div class="pay-opt-pct">100%</div><div class="pay-opt-label">Full Payment</div><div class="pay-opt-note">Pay everything now</div></div>
          <div class="pay-opt" id="pPart" onclick="selPay('partial')"><div class="pay-opt-pct">50%</div><div class="pay-opt-label">Partial Payment</div><div class="pay-opt-note">Rest due 30 days before trip</div></div>
        </div>
        <div class="upi-box">
          <div class="upi-label">UPI ID</div>
          <span class="upi-id">freewheel@ybl</span>
          <table class="bank-table"><tr><td>Account Name</td><td>FreeWheel Expeditions</td></tr><tr><td>Account No.</td><td>XXXX XXXX 1234</td></tr><tr><td>IFSC Code</td><td>HDFC0001234</td></tr><tr><td>Bank</td><td>HDFC Bank</td></tr></table>
          <div class="qr-box"><div class="qr-ico">⬛</div><div class="qr-txt">Scan to Pay</div></div>
        </div>
        <div class="fg"><label>UTR / Transaction Reference</label><input type="text" id="bUTR" placeholder="Enter after making payment"></div>
        <button class="m-btn" onclick="goStep(3)">Confirm Booking →</button>
        <p class="m-note">Enter the UTR number after payment. We verify within 4 hours and send confirmation by email.</p>
      </div>
      <div class="step-panel" id="sp3">
        <div class="success-box">
          <span class="success-ico">🎉</span>
          <div class="success-h">Booking Received!</div>
          <p class="success-p">Thank you! We've received your booking request for <strong id="bConfTrip">–</strong>.<br><br>Our team will verify your payment and send a confirmation email within 4 hours.<br><br>Questions? WhatsApp us at <strong>+91 78178 38060</strong></p>
        </div>
        <button class="m-btn" onclick="closeModal('bookingOverlay')">Close</button>
      </div>
    </div>
  </div>
</div>

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

<?php wp_footer(); ?>
</body>
</html>
