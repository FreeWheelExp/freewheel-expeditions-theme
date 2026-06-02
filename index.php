<?php
/**
 * FreeWheel Expeditions — Fallback index template
 */
get_header(); ?>
<div style="padding:120px 5vw;text-align:center;">
    <h2 style="font-family:'Bebas Neue',sans-serif;font-size:40px;color:#c1440e;letter-spacing:2px;">
        FreeWheel Expeditions
    </h2>
    <p style="color:#555;margin-top:16px;font-family:'Barlow',sans-serif;">
        Page not found.
    </p>
    <a href="<?php echo home_url('/'); ?>" style="display:inline-block;margin-top:24px;padding:13px 34px;background:#c1440e;color:#fff;font-family:'Bebas Neue',sans-serif;font-size:18px;letter-spacing:2px;text-decoration:none;border-radius:2px;">
        Go Home
    </a>
</div>
<?php get_footer(); ?>
