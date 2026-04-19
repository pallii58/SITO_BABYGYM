<?php
/**
 * BABYGYM theme setup.
 *
 * @package BABYGYM
 */

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Chi non è in manutenzione (amministratori loggati, cron, bacheca, ecc.).
 */
function babygym_bypass_maintenance(): bool
{
    if (wp_doing_cron()) {
        return true;
    }

    if (is_admin() && ! wp_doing_ajax()) {
        return true;
    }

    return is_user_logged_in() && current_user_can('manage_options');
}

/**
 * Richiesta front-end che deve mostrare solo la schermata di manutenzione (HTML).
 */
function babygym_is_public_maintenance(): bool
{
    if (wp_doing_cron()) {
        return false;
    }

    if (is_admin() && ! wp_doing_ajax()) {
        return false;
    }

    if (is_feed() || is_embed() || is_trackback()) {
        return false;
    }

    if (defined('REST_REQUEST') && REST_REQUEST) {
        return false;
    }

    if (function_exists('wp_is_json_request') && wp_is_json_request()) {
        return false;
    }

    return ! babygym_bypass_maintenance();
}

add_filter('template_include', function ($template) {
    if (! babygym_is_public_maintenance()) {
        return $template;
    }

    $maintenance = get_theme_file_path('templates/maintenance.php');

    return is_readable($maintenance) ? $maintenance : $template;
}, 99);

add_action('wp_enqueue_scripts', function () {
    if (babygym_is_public_maintenance()) {
        return;
    }

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
