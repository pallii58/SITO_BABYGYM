<?php
/**
 * Theme setup.
 *
 * @package BABYGYM
 */

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Non mostrare errori PHP in output ai visitatori: solo amministratori (capability manage_options).
 */
add_action(
    'init',
    static function (): void {
        if (is_user_logged_in() && current_user_can('manage_options')) {
            return;
        }
        if (function_exists('ini_set')) {
            ini_set('display_errors', '0');
        }
    },
    0
);

add_action('after_setup_theme', function (): void {
    register_nav_menus([
        'primary' => __('Menu principale', 'babygym'),
    ]);
});

