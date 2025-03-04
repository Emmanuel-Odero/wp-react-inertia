<?php
function get_content_data() {
    $post = get_queried_object();
    return [
        'title' => get_the_title($post),
        'content' => apply_filters('the_content', $post->post_content),
        'slug' => $post->post_name,
        'type' => $post->post_type,
    ];
}

function get_main_menu() {
    $menu_name = 'primary';
    $locations = get_nav_menu_locations();
    if (!isset($locations[$menu_name])) {
        return [];
    }

    $menu_items = wp_get_nav_menu_items($locations[$menu_name]) ?: [];
    return array_map(function ($item) {
        return [
            'title' => $item->title,
            'url' => $item->url,
            'slug' => basename($item->url),
        ];
    }, $menu_items);
}
