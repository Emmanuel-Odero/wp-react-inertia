<?php
require_once get_template_directory() . '/lib/inc/enqueue.php';
require_once get_template_directory() . '/lib/inc/helpers.php';
require_once get_template_directory() . '/lib/inc/enqueue.php';
require_once get_template_directory() . '/lib/inc/inertia.php';

function theme_setup() {
    register_nav_menus([
        'primary' => __('Primary Menu', 'inertia-react'),
    ]);
}
add_action('after_setup_theme', 'theme_setup');
