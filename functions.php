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
 * Slug della cartella del tema “reale” (quello che gli amministratori vedono in front-end).
 * Imposta in wp-config.php: define('BABYGYM_LIVE_THEME', 'nome-cartella-tema');
 * oppure modifica il valore di default qui sotto (deve essere un tema installato).
 */
if (! defined('BABYGYM_LIVE_THEME')) {
    define('BABYGYM_LIVE_THEME', 'twentytwentyfive');
}

/**
 * Chi deve vedere il sito normale (non la pagina di manutenzione).
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
 * @return array{template: string, stylesheet: string}|false
 */
function babygym_resolve_live_theme()
{
    static $resolved = null;

    if (null !== $resolved) {
        return $resolved;
    }

    $slug = apply_filters('babygym_live_theme_slug', BABYGYM_LIVE_THEME);

    if (! is_string($slug) || '' === $slug) {
        $resolved = false;

        return $resolved;
    }

    $theme = wp_get_theme($slug);

    if (! $theme->exists()) {
        $resolved = false;

        return $resolved;
    }

    $resolved = [
        'template'   => $theme->get_template(),
        'stylesheet' => $theme->get_stylesheet(),
    ];

    return $resolved;
}

add_filter('template', function ($default) {
    if (is_admin() && ! wp_doing_ajax()) {
        return $default;
    }

    if (! babygym_bypass_maintenance()) {
        return $default;
    }

    $live = babygym_resolve_live_theme();

    return $live ? $live['template'] : $default;
}, 10, 1);

add_filter('stylesheet', function ($default) {
    if (is_admin() && ! wp_doing_ajax()) {
        return $default;
    }

    if (! babygym_bypass_maintenance()) {
        return $default;
    }

    $live = babygym_resolve_live_theme();

    return $live ? $live['stylesheet'] : $default;
}, 10, 1);

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
