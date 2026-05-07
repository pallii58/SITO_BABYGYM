<?php
/**
 * Admin: enqueue Media Library where needed.
 *
 * @package BABYGYM
 */

if (! defined('ABSPATH')) {
    exit;
}

add_action('admin_enqueue_scripts', function ($hook): void {
    if (in_array($hook, ['toplevel_page_babygym-feste', 'toplevel_page_babygym-corsi', 'toplevel_page_babygym-galleria'], true)) {
        wp_enqueue_media();
        return;
    }

    if (in_array($hook, ['post.php', 'post-new.php'], true)) {
        $screen = get_current_screen();
        if ($screen && 'summer_camp' === $screen->post_type) {
            wp_enqueue_media();
        }
    }
});

