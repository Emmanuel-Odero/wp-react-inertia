<?php
require_once __DIR__ . '/lib/inertia/Inertia.php';
use Inertia\Inertia;

$component = 'index'; // Always load index.jsx
$props = get_content_data();
$shared = [
    'site' => [
        'name' => get_bloginfo('name'),
        'description' => get_bloginfo('description'),
    ],
    'menu' => get_main_menu(),
];

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