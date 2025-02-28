<?php
require_once __DIR__ . '/lib/inertia/Inertia.php';
use Inertia\Inertia;

$component = 'Content';
$props = get_content_data();
$shared = [
    'site' => [
        'name' => get_bloginfo('name'),
        'description' => get_bloginfo('description'),
    ],
    'menu' => get_main_menu(),
];

if (!is_page() && !is_single() && is_home()) {
    $posts = get_posts(['numberposts' => 1]);
    if (!empty($posts)) {
        global $post;
        $post = $posts[0];
        setup_postdata($post);
        $props = get_content_data();
    }
} elseif (!is_page() && !is_single() && !is_home()) {
    $component = 'Content'; // Could use a NotFound if you add it later
    $props = ['title' => '404', 'content' => 'Not Found'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php bloginfo('name'); ?></title>
    <?php wp_head(); ?>
</head>
<body>
    <div id="app" data-page='<?php echo esc_attr(json_encode([
        "component" => $component,
        "props" => array_merge($shared, $props),
        "url" => $_SERVER["REQUEST_URI"],
        "version" => "1.0"
    ])); ?>'></div>
    <?php wp_footer(); ?>
</body>
</html>