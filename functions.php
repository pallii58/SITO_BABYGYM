<?php
/**
 * BABYGYM theme setup.
 *
 * @package BABYGYM
 */

if (! defined('ABSPATH')) {
    exit;
}

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style(
        'babygym-style',
        get_stylesheet_uri(),
        [],
        wp_get_theme()->get('Version')
    );
});

add_action('wp_head', function () {
    $favicon_url = 'https://www.babygym-to.com/wp-content/uploads/2026/04/FAVICON.png';
    $favicon_url = esc_url($favicon_url);
    echo '<link rel="icon" href="' . $favicon_url . '" type="image/png">' . "\n";
    echo '<link rel="shortcut icon" href="' . $favicon_url . '" type="image/png">' . "\n";
    echo '<link rel="apple-touch-icon" href="' . $favicon_url . '">' . "\n";
});

add_action('admin_footer', function () {
    echo '<div id="babygym-admin-center-square" aria-hidden="true"></div>' . "\n";
    echo '<style>#babygym-admin-center-square{position:fixed;top:50%;left:50%;width:64px;height:64px;margin:0;padding:0;background:red;transform:translate(-50%,-50%);z-index:100000;pointer-events:none;box-shadow:0 0 0 1px rgba(0,0,0,.15) inset;}</style>' . "\n";
});
