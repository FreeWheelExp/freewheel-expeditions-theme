<?php
/**
 * FreeWheel Expeditions — One-Click Setup
 * 
 * HOW TO USE:
 * 1. Upload this theme and activate it
 * 2. Visit: https://yoursite.com/?fw_setup=1
 * 3. This will auto-create all required pages with correct slugs & templates
 * 4. Done! Delete this file or it self-disables after running.
 *
 * This file is safe — it only runs when ?fw_setup=1 is in the URL
 * and only when you're logged in as admin.
 */

function fw_auto_setup() {
    if (!isset($_GET['fw_setup']) || $_GET['fw_setup'] !== '1') return;
    if (!current_user_can('manage_options')) return;

    $pages = array(
        array(
            'title'    => 'Home',
            'slug'     => 'home',
            'template' => '',
            'status'   => 'publish',
        ),
        array(
            'title'    => 'Expeditions',
            'slug'     => 'expeditions',
            'template' => 'page-expeditions.php',
            'status'   => 'publish',
        ),
        array(
            'title'    => 'Community',
            'slug'     => 'community',
            'template' => 'page-community.php',
            'status'   => 'publish',
        ),
        array(
            'title'    => 'Merchandise',
            'slug'     => 'merchandise',
            'template' => 'page-merchandise.php',
            'status'   => 'publish',
        ),
        array(
            'title'    => 'My Dashboard',
            'slug'     => 'dashboard',
            'template' => 'page-dashboard.php',
            'status'   => 'publish',
        ),
        array(
            'title'    => 'Register',
            'slug'     => 'register',
            'template' => 'page-register.php',
            'status'   => 'publish',
        ),
        array(
            'title'    => 'Login',
            'slug'     => 'login',
            'template' => 'page-login.php',
            'status'   => 'publish',
        ),
        array(
            'title'    => 'Admin Dashboard',
            'slug'     => 'admin-dashboard',
            'template' => 'page-fw-admin.php',
            'status'   => 'publish',
        ),
        array(
            'title'    => 'Nepal Expedition',
            'slug'     => 'nepal',
            'template' => 'page-nepal.php',
            'status'   => 'publish',
        ),
        array(
            'title'    => 'Leh Ladakh',
            'slug'     => 'leh',
            'template' => 'page-leh.php',
            'status'   => 'publish',
        ),
        array(
            'title'    => 'Spiti Valley',
            'slug'     => 'spiti',
            'template' => 'page-spiti.php',
            'status'   => 'publish',
        ),
        array(
            'title'    => 'Adi Kailash',
            'slug'     => 'adikailash',
            'template' => 'page-adikailash.php',
            'status'   => 'publish',
        ),
    );

    $created = array();
    $existing = array();

    foreach ($pages as $page_data) {
        // Check if page already exists
        $existing_page = get_page_by_path($page_data['slug']);
        if ($existing_page) {
            // Update template if needed
            if ($page_data['template']) {
                update_post_meta($existing_page->ID, '_wp_page_template', $page_data['template']);
            }
            $existing[] = $page_data['title'];
            continue;
        }

        // Create page
        $page_id = wp_insert_post(array(
            'post_title'   => $page_data['title'],
            'post_name'    => $page_data['slug'],
            'post_status'  => $page_data['status'],
            'post_type'    => 'page',
            'post_content' => '',
        ));

        if ($page_id && !is_wp_error($page_id)) {
            if ($page_data['template']) {
                update_post_meta($page_id, '_wp_page_template', $page_data['template']);
            }
            $created[] = $page_data['title'] . ' (/' . $page_data['slug'] . '/)';
        }
    }

    // Set homepage if not already set
    $homepage = get_page_by_path('home');
    if ($homepage && get_option('page_on_front') != $homepage->ID) {
        update_option('show_on_front', 'page');
        update_option('page_on_front', $homepage->ID);
    }

    // Flush rewrite rules
    flush_rewrite_rules();

    // Show result
    echo '<!DOCTYPE html><html><head><title>FreeWheel Setup</title>';
    echo '<style>body{font-family:sans-serif;max-width:600px;margin:60px auto;padding:20px;background:#0f0d0b;color:#fff}';
    echo '.ok{color:#27ae60}.done{background:#1a1410;padding:20px;border-left:4px solid #c1440e;margin:10px 0}';
    echo 'a{color:#c1440e}h1{color:#c1440e}ul{line-height:2}</style></head><body>';
    echo '<h1>🏔️ FreeWheel Setup Complete!</h1>';
    if (!empty($created)) {
        echo '<div class="done"><strong class="ok">✅ Pages Created:</strong><ul>';
        foreach ($created as $p) echo '<li>' . esc_html($p) . '</li>';
        echo '</ul></div>';
    }
    if (!empty($existing)) {
        echo '<div class="done"><strong style="color:#e8a020">⚡ Already existed (template updated):</strong><ul>';
        foreach ($existing as $p) echo '<li>' . esc_html($p) . '</li>';
        echo '</ul></div>';
    }
    echo '<p>Next steps:</p><ul>';
    echo '<li>Go to <a href="' . admin_url('options-reading.php') . '">Settings → Reading</a> → set Homepage</li>';
    echo '<li>Go to <a href="' . admin_url('options-permalink.php') . '">Settings → Permalinks</a> → Save Changes</li>';
    echo '<li>Visit <a href="' . home_url('/merchandise/') . '">/merchandise/</a> and <a href="' . home_url('/community/') . '">/community/</a> to confirm they work</li>';
    echo '</ul>';
    echo '<p style="color:#888;font-size:12px">This setup page only runs when you visit ?fw_setup=1 while logged in as admin.</p>';
    echo '</body></html>';
    exit;
}
add_action('template_redirect', 'fw_auto_setup');
