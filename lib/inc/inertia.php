<?php

require_once __DIR__ . '/../inertia/Inertia.php';

use Inertia\Inertia;

function inertia_setup() {
    if (!is_admin()) {
        Inertia::share([
            'site' => [
                'name' => get_bloginfo('name'),
                'description' => get_bloginfo('description'),
            ],
            'menu' => get_main_menu(),
        ]);
        Inertia::render('index', get_content_data());
    }
}
add_action('template_redirect', 'inertia_setup');


// Determine the React component based on WordPress template
function get_inertia_component() {
    if (is_home() || is_front_page()) {
        return 'Home';  // Loads `Home.jsx`
    } elseif (is_page()) {
        return 'Page';  // Loads `Page.jsx`
    } elseif (is_single()) {
        return 'Single';  // Loads `Single.jsx`
    } elseif (is_archive()) {
        return 'Archive';  // Loads `Archive.jsx`
    } elseif (is_search()) {
        return 'Search';  // Loads `Search.jsx`
    } elseif (is_404()) {
        return 'NotFound';  // Loads `NotFound.jsx`
    }

    return 'Default'; // Fallback component
}