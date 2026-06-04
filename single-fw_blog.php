<?php
/**
 * Single Blog Post Template
 */
if(!defined('ABSPATH')) exit;
global $post;
if(!$post || get_post_type($post) !== 'fw_blog'){
    wp_redirect(home_url('/blog/')); exit;
}
$pid      = $post->ID;
$title    = get_the_title($pid);
$author   = get_post_meta($pid,'fw_blog_author',true) ?: 'FreeWheel Team';
$subtitle = get_post_meta($pid,'fw_blog_subtitle',true);
$content  = get_post_meta($pid,'fw_blog_content',true);
$tags_raw = get_post_meta($pid,'fw_blog_tags',true);
$tags     = $tags_raw ? array_map('trim',explode(',',$tags_raw)) : array();
$read_time= get_post_meta($pid,'fw_blog_read_time',true);
$thumb    = get_the_post_thumbnail_url($pid,'full');
$date     = get_the_date('F j, Y',$pid);
get_header();
// ── Schema: BlogPosting ───────────────────────────────────────────
if (have_posts()) {
    $post_obj = get_queried_object();
    $blog_schema = [
        "@context"         => "https://schema.org",
        "@type"            => "BlogPosting",
        "headline"         => html_entity_decode(get_the_title(), ENT_QUOTES, 'UTF-8'),
        "description"      => get_the_excerpt() ?: wp_trim_words(get_the_content(), 30),
        "url"              => get_permalink(),
        "datePublished"    => get_the_date('c'),
        "dateModified"     => get_the_modified_date('c'),
        "image"            => get_the_post_thumbnail_url(null, 'full') ?: get_template_directory_uri() . '/images/front-page-1.png',
        "author"           => ["@type" => "Organization", "name" => "FreeWheel Expeditions"],
        "publisher"        => [
            "@type" => "Organization",
            "name"  => "FreeWheel Expeditions",
            "logo"  => ["@type" => "ImageObject", "url" => get_template_directory_uri() . "/images/header-1.jpg"]
        ],
        "mainEntityOfPage" => ["@type" => "WebPage", "@id" => get_permalink()]
    ];
    echo '<script type="application/ld+json">' . json_encode($blog_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . '</script>' . "
";
}
?>

?>
<style>
html,body,body.single,#page,#content,#primary,#main,.site,.site-content,.entry-content,.wp-site-blocks,main,article{background:#0f0d0b!important;background-color:#0f0d0b!important;color:#fff!important}
.entry-content,.page-content,#primary,#main,main{padding:0!important;margin:0!important;max-width:100%!important;width:100%!important}
.site-header,.wp-block-template-part[class*="header"]{display:none!important}
a{color:inherit}
:root{--rust:#c44b19;--ink:#0f0d0b;--headline:'Bebas Neue',Impact,sans-serif}

/* HERO */
.sp-hero{position:relative;min-height:520px;display:flex;align-items:flex-end;overflow:hidden;background:#0a0805}
.sp-hero-img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;object-position:center;opacity:.35}
.sp-hero-grad{position:absolute;inset:0;background:linear-gradient(to top,#0f0d0b 30%,rgba(0,0,0,.3) 100%)}
.sp-hero-content{position:relative;z-index:2;max-width:860px;margin:0 auto;padding:100px 24px 56px;width:100%;box-sizing:border-box}
.sp-back{display:inline-flex;align-items:center;gap:8px;font-size:12px;letter-spacing:2px;text-transform:uppercase;color:rgba(255,255,255,.4);margin-bottom:24px;text-decoration:none;transition:color .2s}
.sp-back:hover{color:var(--rust);text-decoration:none}
.sp-tags{display:flex;gap:8px;flex-wrap:wrap;margin-bottom:18px;align-items:center}
.sp-tag{font-size:10px;letter-spacing:1.5px;text-transform:uppercase;color:var(--rust);background:rgba(196,75,25,.12);padding:4px 10px;border-radius:2px}
.sp-title{font-family:var(--headline);font-size:clamp(36px,6vw,72px);color:#fff;letter-spacing:1px;line-height:1.05;margin:0 0 14px}
.sp-subtitle{font-size:17px;font-weight:300;color:rgba(255,255,255,.55);margin:0 0 24px;line-height:1.6}
.sp-meta{display:flex;align-items:center;gap:14px;font-size:12px;color:rgba(255,255,255,.35);letter-spacing:.5px;flex-wrap:wrap}
.sp-meta-dot{width:5px;height:5px;border-radius:50%;background:var(--rust)}

/* CONTENT */
.sp-body{max-width:760px;margin:0 auto;padding:48px 24px 80px}
.sp-content{font-size:16px;font-weight:300;color:rgba(255,255,255,.8);line-height:1.85}
.sp-content h2{font-family:var(--headline);font-size:clamp(26px,4vw,38px);color:#fff;letter-spacing:1px;margin:48px 0 16px}
.sp-content h3{font-family:var(--headline);font-size:clamp(20px,3vw,28px);color:#fff;letter-spacing:.5px;margin:36px 0 12px}
.sp-content p{margin:0 0 20px}
.sp-content strong{color:#fff;font-weight:600}
.sp-content em{color:rgba(255,255,255,.6);font-style:italic}
.sp-content blockquote{border-left:3px solid var(--rust);margin:32px 0;padding:16px 24px;background:rgba(196,75,25,.06);font-size:18px;font-style:italic;color:rgba(255,255,255,.7)}
.sp-content ul,.sp-content ol{padding-left:24px;margin:0 0 20px}
.sp-content li{margin-bottom:8px}
.sp-content a{color:var(--rust);text-decoration:underline;text-decoration-color:rgba(196,75,25,.4)}
.sp-content a:hover{text-decoration-color:var(--rust)}
.sp-inline-photo{margin:36px 0;padding:0}
.sp-inline-photo img{width:100%;max-height:600px;object-fit:cover;object-position:center;border-radius:3px;display:block}
@media(max-width:600px){.sp-inline-photo img{max-height:260px}}
.sp-divider{border:none;border-top:1px solid rgba(255,255,255,.08);margin:48px 0}

/* COMMENTS */
.sp-comments{margin-top:60px;padding-top:48px;border-top:1px solid rgba(255,255,255,.08)}
.sp-comments-title{font-family:var(--headline);font-size:32px;color:#fff;letter-spacing:1px;margin:0 0 32px}
.sp-comment{background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.07);border-radius:4px;padding:20px 22px;margin-bottom:16px}
.sp-comment-header{display:flex;align-items:center;gap:12px;margin-bottom:10px}
.sp-comment-avatar{width:36px;height:36px;border-radius:50%;background:var(--rust);display:flex;align-items:center;justify-content:center;font-family:var(--headline);font-size:16px;color:#fff;flex-shrink:0}
.sp-comment-name{font-weight:600;font-size:14px;color:#fff}
.sp-comment-date{font-size:11px;color:rgba(255,255,255,.3);margin-top:2px}
.sp-comment-text{font-size:14px;font-weight:300;color:rgba(255,255,255,.65);line-height:1.7}

/* COMMENT FORM */
.sp-comment-form{margin-top:36px;background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.07);border-radius:4px;padding:28px}
.sp-comment-form h3{font-family:var(--headline);font-size:24px;color:#fff;letter-spacing:1px;margin:0 0 20px}
.sp-form-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:14px}
@media(max-width:540px){.sp-form-grid{grid-template-columns:1fr}}
.sp-form-grid input,.sp-comment-form textarea{width:100%;padding:11px 14px;background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.1);color:#fff;font-size:14px;border-radius:3px;box-sizing:border-box;font-family:inherit;transition:border-color .2s}
.sp-form-grid input:focus,.sp-comment-form textarea:focus{outline:none;border-color:var(--rust)}
.sp-comment-form textarea{min-height:110px;resize:vertical;margin-bottom:14px}
.sp-submit-btn{background:var(--rust);border:none;color:#fff;font-family:var(--headline);font-size:18px;letter-spacing:2px;padding:12px 32px;cursor:pointer;border-radius:2px;transition:background .2s}
.sp-submit-btn:hover{background:#a33d14}
.sp-form-msg{margin-top:12px;font-size:13px;padding:10px 14px;border-radius:3px;display:none}
.sp-form-msg.ok{background:rgba(34,197,94,.1);border:1px solid rgba(34,197,94,.3);color:#4ade80;display:block}
.sp-form-msg.err{background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.3);color:#f87171;display:block}
</style>

<article>
<div class="sp-hero">
  <?php if($thumb): ?>
  <img class="sp-hero-img" src="<?php echo esc_url($thumb); ?>" alt="<?php echo esc_attr($title); ?>">
  <?php endif; ?>
  <div class="sp-hero-grad"></div>
  <div class="sp-hero-content">
    <a href="<?php echo esc_url(home_url('/blog/')); ?>" class="sp-back" style="display:inline-flex">← Back to Blog</a>
    <?php if(!empty($tags)): ?>
    <div class="sp-tags">
      <?php foreach($tags as $tag): ?>
      <span class="sp-tag"><?php echo esc_html($tag); ?></span>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
    <h1 class="sp-title"><?php echo esc_html($title); ?></h1>
    <?php if($subtitle): ?>
    <p class="sp-subtitle"><?php echo esc_html($subtitle); ?></p>
    <?php endif; ?>
    <div class="sp-meta">
      <span class="sp-meta-dot"></span>
      <span><?php echo esc_html($author); ?></span>
      <span>·</span>
      <span><?php echo esc_html($date); ?></span>
      <?php if($read_time): ?><span>·</span><span><?php echo esc_html($read_time); ?></span><?php endif; ?>
    </div>
  </div>
</div>

<div class="sp-body">
  <div class="sp-content">
    <?php echo fw_render_blog_content($content); ?>
  </div>
  <hr class="sp-divider">

  <!-- COMMENTS -->
  <div class="sp-comments">
    <div class="sp-comments-title">Reader Comments</div>
    <?php
    $comments = get_comments(array('post_id'=>$pid,'status'=>'approve','order'=>'ASC'));
    if(empty($comments)){
        echo '<p style="color:rgba(255,255,255,.3);font-size:13px;letter-spacing:1px">No comments yet. Be the first to share your thoughts.</p>';
    } else {
        foreach($comments as $c):
            $initials = strtoupper(substr($c->comment_author,0,1));
    ?>
    <div class="sp-comment">
      <div class="sp-comment-header">
        <div class="sp-comment-avatar"><?php echo esc_html($initials); ?></div>
        <div>
          <div class="sp-comment-name"><?php echo esc_html($c->comment_author); ?></div>
          <div class="sp-comment-date"><?php echo date('M j, Y',strtotime($c->comment_date)); ?></div>
        </div>
      </div>
      <div class="sp-comment-text"><?php echo esc_html($c->comment_content); ?></div>
    </div>
    <?php endforeach; } ?>

    <!-- COMMENT FORM -->
    <div class="sp-comment-form">
      <h3>Leave a Comment</h3>
      <div class="sp-form-grid">
        <input type="text" id="spName" placeholder="Your Name *">
        <input type="email" id="spEmail" placeholder="Email (not published)">
      </div>
      <textarea id="spComment" placeholder="Share your thoughts, questions, or experience..."></textarea>
      <button class="sp-submit-btn" onclick="spSubmitComment(<?php echo $pid; ?>)">Post Comment</button>
      <div class="sp-form-msg" id="spMsg"></div>
    </div>
  </div>
</div>
</article>

<script>
async function spSubmitComment(postId){
  var name    = document.getElementById('spName').value.trim();
  var email   = document.getElementById('spEmail').value.trim();
  var comment = document.getElementById('spComment').value.trim();
  var msg     = document.getElementById('spMsg');
  msg.className='sp-form-msg';
  if(!name){ msg.textContent='Please enter your name.'; msg.className='sp-form-msg err'; return; }
  if(!comment){ msg.textContent='Please write a comment.'; msg.className='sp-form-msg err'; return; }
  var btn = document.querySelector('.sp-submit-btn');
  btn.disabled=true; btn.textContent='Posting...';
  try {
    var fd = new FormData();
    fd.append('action','fw_post_comment');
    fd.append('post_id',postId);
    fd.append('author',name);
    fd.append('email',email);
    fd.append('comment',comment);
    fd.append('nonce','<?php echo wp_create_nonce("fw_comment_nonce"); ?>');
    var res = await fetch('<?php echo esc_url(admin_url("admin-ajax.php")); ?>',{method:'POST',body:fd});
    var data = await res.json();
    if(data.success){
      msg.textContent='Thanks! Your comment has been submitted for review.';
      msg.className='sp-form-msg ok';
      document.getElementById('spName').value='';
      document.getElementById('spEmail').value='';
      document.getElementById('spComment').value='';
    } else {
      msg.textContent = data.message || 'Something went wrong. Please try again.';
      msg.className='sp-form-msg err';
    }
  } catch(e){
    msg.textContent='Network error. Please try again.'; msg.className='sp-form-msg err';
  }
  btn.disabled=false; btn.textContent='Post Comment';
}
</script>


<?php
// Related Expedition CTA — match blog to expedition by tag
$blog_tags = strtolower(get_post_meta($pid, 'fw_blog_tags', true));
$exp_link = $exp_name = $exp_desc = '';

if (strpos($blog_tags, 'umling la') !== false || strpos($blog_tags, 'leh ladakh') !== false) {
    $exp_link = '/expedition/dream-leh-ladakh-expedition/';
    $exp_name = 'Dream Leh Ladakh Expedition';
    $exp_desc = 'Drive Umling La, Pangong Tso, Nubra Valley and more — guided self-drive convoy, Sep 2026';
} elseif (strpos($blog_tags, 'spiti') !== false) {
    $exp_link = '/expedition/magical-spiti-valley-expedition/';
    $exp_name = 'Magical Spiti Valley Expedition';
    $exp_desc = 'Key Monastery, Chandrataal Lake, Hikkim — guided self-drive convoy, Dec 2026';
} elseif (strpos($blog_tags, 'adi kailash') !== false || strpos($blog_tags, 'om parvat') !== false) {
    $exp_link = '/expedition/adi-kailash-om-parvat-self-drive-expedition/';
    $exp_name = 'Adi Kailash Om Parvat Expedition';
    $exp_desc = 'Drive to India's sacred Himalayan peak — guided self-drive convoy, 2026';
} elseif (strpos($blog_tags, 'mustang') !== false || strpos($blog_tags, 'nepal') !== false) {
    $exp_link = '/expedition/upper-mustang-muktinath-expedition/';
    $exp_name = 'Upper Mustang Expedition';
    $exp_desc = 'The Forbidden Kingdom — guided self-drive convoy into Lo Manthang, Nov 2026';
} elseif (strpos($blog_tags, 'darma') !== false || strpos($blog_tags, 'rimkhim') !== false) {
    $exp_link = '/expedition/rimkhim-pass-lapthal-darma-valley-expedition/';
    $exp_name = 'Rimkhim Pass Darma Valley Expedition';
    $exp_desc = 'Kumaon's most remote off-road valley — guided self-drive convoy, 2026';
}

if ($exp_link):
?>
<section style="background:#1a1410;border-top:3px solid #c1440e;padding:52px 5vw;margin-top:0">
  <div style="max-width:800px;margin:0 auto;display:flex;align-items:center;justify-content:space-between;gap:32px;flex-wrap:wrap">
    <div>
      <div style="font-size:10px;letter-spacing:4px;text-transform:uppercase;color:#e8a020;margin-bottom:10px">Related Expedition</div>
      <h3 style="font-family:'Barlow Condensed',sans-serif;font-size:32px;color:#fff;letter-spacing:1px;margin-bottom:8px"><?php echo esc_html($exp_name); ?></h3>
      <p style="font-size:14px;color:rgba(255,255,255,.6);line-height:1.6;max-width:480px"><?php echo esc_html($exp_desc); ?></p>
    </div>
    <a href="<?php echo esc_url($exp_link); ?>" style="display:inline-block;padding:14px 32px;background:#c1440e;color:#fff;font-family:'Barlow Condensed',sans-serif;font-size:18px;letter-spacing:2px;text-transform:uppercase;border-radius:2px;white-space:nowrap;text-decoration:none;flex-shrink:0">View Expedition →</a>
  </div>
</section>
<?php endif; ?>


<!-- WhatsApp Broadcast CTA -->
<section style="background:linear-gradient(135deg,#075e54,#128c7e);padding:48px 5vw;text-align:center">
  <div style="max-width:700px;margin:0 auto">
    <div style="font-size:48px;margin-bottom:12px">📲</div>
    <h3 style="font-family:'Barlow Condensed',sans-serif;font-size:clamp(28px,4vw,42px);color:#fff;letter-spacing:1px;margin-bottom:10px">Never Miss a FreeWheel Expedition</h3>
    <p style="font-size:15px;color:rgba(255,255,255,.8);line-height:1.7;margin-bottom:28px;max-width:500px;margin-left:auto;margin-right:auto">Join our WhatsApp broadcast — early bird slots, new routes, and road stories delivered directly to you. No spam, ever.</p>
    <a href="https://wa.me/917817838060?text=Hi%21%20Please%20add%20me%20to%20the%20FreeWheel%20Expeditions%20broadcast%20list%20for%20updates." target="_blank" style="display:inline-flex;align-items:center;gap:10px;padding:15px 36px;background:#fff;color:#075e54;font-family:'Barlow Condensed',sans-serif;font-size:20px;letter-spacing:2px;text-transform:uppercase;border-radius:2px;text-decoration:none;font-weight:700">
      <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="#075e54"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.123.554 4.118 1.528 5.85L.057 23.077a.75.75 0 0 0 .943.895l5.344-1.705A11.945 11.945 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.75a9.726 9.726 0 0 1-4.964-1.355l-.355-.212-3.693 1.178 1.131-3.595-.232-.371A9.725 9.725 0 0 1 2.25 12C2.25 6.615 6.615 2.25 12 2.25S21.75 6.615 21.75 12 17.385 21.75 12 21.75z"/></svg>
      Join Broadcast List
    </a>
    <p style="font-size:11px;color:rgba(255,255,255,.5);margin-top:14px;letter-spacing:1px">+91 78178 38060 · We reply within 4 hours</p>
  </div>
</section>

<?php get_footer(); ?>
