<?php
// WordPress Inertia React Starter Theme
// Created by Emmanuel Odero emmanuelodero@techmates.team
// Open-source under MIT
require_once __DIR__ . '/lib/inertia/Inertia.php';

use Inertia\Inertia;

// Register menu locations
add_action('after_setup_theme', function () {
    register_nav_menus([
        'primary' => 'Primary Menu', // Name shown in admin
    ]);
});

// Share global data and handle routing
add_action('template_redirect', function () {
    if (!is_admin()) {
        $menu_data = get_main_menu();
        error_log('Menu data: ' . print_r($menu_data, true));
        Inertia::share([
            'site' => [
                'name' => get_bloginfo('name'),
                'description' => get_bloginfo('description'),
            ],
            'menu' => $menu_data,
        ]);

        if (is_page() || is_single()) {
            Inertia::render('Content', get_content_data());
        } elseif (is_home()) {
            $posts = get_posts(['numberposts' => 1]);
            if (!empty($posts)) {
                global $post;
                $post = $posts[0];
                setup_postdata($post);
                Inertia::render('Content', get_content_data());
            }
        } else {
            wp_die('404 - Not Found');
        }
    }
});
// Enqueue frontend assets
add_action('wp_enqueue_scripts', function () {
    $manifest_path = __DIR__ . '/assets/build/.vite/manifest.json';
    if (file_exists($manifest_path)) {
        $manifest = json_decode(file_get_contents($manifest_path), true);
        $js_file = $manifest['assets/src/app.jsx']['file'] ?? null;
        $css_file = $manifest['assets/src/app.jsx']['css'][0] ?? null;

        if ($js_file) {
            wp_enqueue_script('inertia-react', get_template_directory_uri() . '/assets/build/' . $js_file, [], null, true);
        }
        if ($css_file) {
            wp_enqueue_style('inertia-react', get_template_directory_uri() . '/assets/build/' . $css_file, [], null);
        }
    } else {
        error_log('Vite manifest not found. Run `npm run build`.');
    }
});

// Helper: Get current page/post data
function get_content_data() {
    $post = get_queried_object();
    return [
        'title' => $post->post_title,
        'content' => apply_filters('the_content', $post->post_content),
        'slug' => $post->post_name,
        'type' => $post->post_type,
    ];
}

// Helper: Get main menu
function get_main_menu() {
    $menu_name = 'primary';
    $locations = get_nav_menu_locations();
    if (!empty($locations[$menu_name])) {
        $menu_items = wp_get_nav_menu_items($locations[$menu_name]);
        if ($menu_items) {
            return array_map(function ($item) {
                return [
                    'title' => $item->title,
                    'url' => $item->url,
                    'slug' => basename($item->url),
                ];
            }, $menu_items);
        }
    }
    return [];
}