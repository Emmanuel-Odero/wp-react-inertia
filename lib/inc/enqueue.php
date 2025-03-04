<?php
function enqueue_theme_assets() {
    $manifest_path = get_template_directory() . '/assets/build/.vite/manifest.json';

    if (!file_exists($manifest_path)) {
        error_log('Vite manifest not found. Run `npm run build`.');
        return;
    }

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
add_action('wp_enqueue_scripts', 'enqueue_theme_assets');
