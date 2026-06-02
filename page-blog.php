<?php
/**
 * Template Name: Blog
 * Template Post Type: page
 */
get_header(); ?>
<style>
html,body,body.page,#page,#content,#primary,#main,.site,.site-content,.entry-content,.wp-site-blocks,main,article{background:#0f0d0b!important;background-color:#0f0d0b!important;color:#fff!important}
.entry-content,.page-content,#primary,#main,main{padding:0!important;margin:0!important;max-width:100%!important;width:100%!important}
.site-header,.wp-block-template-part[class*="header"]{display:none!important}
a{color:inherit;text-decoration:none}
:root{--rust:#c44b19;--ink:#0f0d0b;--headline:'Bebas Neue',Impact,sans-serif}

/* HERO */
.bl-hero{background:linear-gradient(135deg,#0a0805 0%,#1a0f0a 100%);padding:100px 5vw 64px;text-align:center;position:relative;overflow:hidden}
.bl-hero::before{content:'';position:absolute;inset:0;background:radial-gradient(ellipse at 50% 0%,rgba(196,75,25,.12) 0%,transparent 65%);pointer-events:none}
.bl-hero-tag{font-size:11px;letter-spacing:4px;text-transform:uppercase;color:var(--rust);margin-bottom:16px;display:flex;align-items:center;gap:10px;justify-content:center}
.bl-hero-tag span{display:inline-block;width:32px;height:1px;background:var(--rust)}
.bl-hero h1{font-family:var(--headline);font-size:clamp(48px,8vw,96px);color:#fff;letter-spacing:2px;margin:0 0 16px;line-height:1}
.bl-hero-sub{font-size:16px;font-weight:300;color:rgba(255,255,255,.45);max-width:500px;margin:0 auto}

/* GRID */
.bl-wrap{max-width:1200px;margin:0 auto;padding:60px 24px 80px}
.bl-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:28px}
@media(max-width:900px){.bl-grid{grid-template-columns:repeat(2,1fr)}}
@media(max-width:580px){.bl-grid{grid-template-columns:1fr}}

/* CARD */
.bl-card{background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.07);border-radius:4px;overflow:hidden;display:flex;flex-direction:column;transition:border-color .2s,transform .2s;cursor:pointer}
.bl-card:hover{border-color:rgba(196,75,25,.4);transform:translateY(-4px)}
.bl-card-img{width:100%;aspect-ratio:16/9;object-fit:cover;object-position:center;display:block;background:#1a1410}
.bl-card-img-placeholder{width:100%;aspect-ratio:16/9;background:linear-gradient(135deg,#1a1410,#0f0d0b);display:flex;align-items:center;justify-content:center;font-size:40px}
.bl-card-body{padding:22px 20px;flex:1;display:flex;flex-direction:column;gap:8px}
.bl-card-tags{display:flex;gap:6px;flex-wrap:wrap;align-items:center;min-height:22px}
.bl-card-tag{font-size:10px;letter-spacing:1.5px;text-transform:uppercase;color:var(--rust);background:rgba(196,75,25,.1);padding:3px 8px;border-radius:2px}
.bl-card-title{font-family:var(--headline);font-size:24px;color:#fff;letter-spacing:.5px;line-height:1.2;word-break:break-word}
.bl-card-subtitle{font-size:13px;font-weight:300;color:rgba(255,255,255,.45);line-height:1.6}
.bl-card-meta{display:flex;align-items:center;gap:12px;margin-top:auto;padding-top:14px;border-top:1px solid rgba(255,255,255,.06);font-size:11px;color:rgba(255,255,255,.35);letter-spacing:.5px}
.bl-card-author-dot{width:6px;height:6px;border-radius:50%;background:var(--rust);flex-shrink:0}
.bl-read-more{display:inline-block;margin-top:12px;font-size:12px;letter-spacing:2px;text-transform:uppercase;color:var(--rust)}
.bl-empty{text-align:center;padding:80px 24px;color:rgba(255,255,255,.3);font-size:14px;letter-spacing:2px;text-transform:uppercase}
</style>

<div class="bl-hero">
  <div class="bl-hero-tag"><span></span> Field Notes <span></span></div>
  <h1>THE FREEWHEEL BLOG</h1>
  <p class="bl-hero-sub">Stories from the road. Tips for the trail. Dispatches from high altitude.</p>
</div>

<div class="bl-wrap">
<?php
$posts = get_posts(array(
    'post_type'      => 'fw_blog',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'orderby'        => 'date',
    'order'          => 'DESC',
));
if(empty($posts)):
?>
  <div class="bl-empty">No posts yet — check back soon.</div>
<?php else: ?>
  <div class="bl-grid">
  <?php foreach($posts as $p):
    $pid      = $p->ID;
    $title    = get_the_title($pid);
    $author   = get_post_meta($pid,'fw_blog_author',true) ?: 'FreeWheel Team';
    $subtitle = get_post_meta($pid,'fw_blog_subtitle',true);
    $tags_raw = get_post_meta($pid,'fw_blog_tags',true);
    $tags     = $tags_raw ? array_slice(array_map('trim',explode(',',$tags_raw)),0,3) : array();
    $read_time= get_post_meta($pid,'fw_blog_read_time',true);
    $thumb    = get_the_post_thumbnail_url($pid,'medium_large');
    $date     = get_the_date('M j, Y',$pid);
    $link     = get_permalink($pid);
  ?>
  <a href="<?php echo esc_url($link); ?>" class="bl-card">
    <?php if($thumb): ?>
    <img class="bl-card-img" src="<?php echo esc_url($thumb); ?>" alt="<?php echo esc_attr($title); ?>">
    <?php else: ?>
    <div class="bl-card-img-placeholder">🏔️</div>
    <?php endif; ?>
    <div class="bl-card-body">
      <?php if(!empty($tags)): ?>
      <div class="bl-card-tags">
        <?php foreach($tags as $tag): ?>
        <span class="bl-card-tag"><?php echo esc_html($tag); ?></span>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>
      <div class="bl-card-title"><?php echo esc_html($title); ?></div>
      <?php if($subtitle): ?>
      <div class="bl-card-subtitle"><?php echo esc_html($subtitle); ?></div>
      <?php endif; ?>
      <div class="bl-card-meta">
        <span class="bl-card-author-dot"></span>
        <span><?php echo esc_html($author); ?></span>
        <span>·</span>
        <span><?php echo esc_html($date); ?></span>
        <?php if($read_time): ?><span>·</span><span><?php echo esc_html($read_time); ?></span><?php endif; ?>
      </div>
      <span class="bl-read-more">Read More →</span>
    </div>
  </a>
  <?php endforeach; ?>
  </div>
<?php endif; ?>
</div>

<?php get_footer(); ?>
