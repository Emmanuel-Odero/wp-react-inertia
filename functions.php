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
// Handle routing
add_action('template_redirect', function () {
    if (!is_admin()) {
        $menu_data = get_main_menu();
        Inertia::share([
            'site' => [
                'name' => get_bloginfo('name'),
                'description' => get_bloginfo('description'),
            ],
            'menu' => $menu_data,
        ]);

        // Always load Index.jsx as the main page
        Inertia::render('index', get_content_data());
    }
});

// Enqueue frontend assets
add_action('wp_enqueue_scripts', function () {
    $is_development = !file_exists(__DIR__ . '/assets/build/.vite/manifest.json');
    
    if ($is_development) {
        // Development mode
        add_action('wp_head', function () {
            echo '
            <script type="module">
                import RefreshRuntime from "http://localhost:5174/@react-refresh"
                RefreshRuntime.injectIntoGlobalHook(window)
                window.$RefreshReg$ = () => {}
                window.$RefreshSig$ = () => (type) => type
                window.__vite_plugin_react_preamble_installed__ = true
            </script>';
        }, 1);
        
        add_action('wp_footer', function () {
            echo '<script type="module" src="http://localhost:5174/@vite/client"></script>';
            echo '<script type="module" src="http://localhost:5174/assets/src/app.jsx"></script>';
        }, 1);
    } else {
        // Production mode
        $manifest_path = __DIR__ . '/assets/build/.vite/manifest.json';
        if (file_exists($manifest_path)) {
            // Production mode
            $manifest = json_decode(file_get_contents($manifest_path), true);
            $js_file = $manifest['assets/src/app.jsx']['file'] ?? null;
            $css_file = $manifest['assets/src/app.jsx']['css'][0] ?? null;

            if ($js_file) {
                wp_enqueue_script('inertia-react', get_template_directory_uri() . '/assets/build/' . $js_file, [], null, true);
            }
            if ($css_file) {
                wp_enqueue_style('inertia-react', get_template_directory_uri() . '/assets/build/' . $css_file, [], null);
            }
        }
    }
});

// Helper: Get current page/post data
function get_content_data() {
    $post = get_queried_object();

    // Return safe defaults when no queried object (prevents "Attempt to read property on null")
    if (!$post || !is_object($post) || !isset($post->post_title)) {
        return [
            'title'   => get_bloginfo('name'),
            'content' => '',
            'slug'    => '',
            'type'    => '',
        ];
    }

    return [
        'title'   => $post->post_title,
        'content' => apply_filters('the_content', $post->post_content),
        'slug'    => $post->post_name,
        'type'    => $post->post_type,
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