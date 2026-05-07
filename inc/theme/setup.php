<?php
/**
 * Theme setup.
 *
 * @package BABYGYM
 */

if (! defined('ABSPATH')) {
    exit;
}

add_action('after_setup_theme', function (): void {
    register_nav_menus([
        'primary' => __('Menu principale', 'babygym'),
    ]);
});

