<?php
/**
 * Admin: pagina impostazioni "Galleria".
 *
 * @package BABYGYM
 */

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Default opzioni pagina "Galleria".
 *
 * @return array<string, string>
 */
function babygym_galleria_defaults(): array
{
    return [
        'gallery_images' => '',
    ];
}

/**
 * @return array<string, string>
 */
function babygym_get_galleria_options(): array
{
    $defaults = babygym_galleria_defaults();
    $saved    = get_option('babygym_galleria_options', []);
    if (! is_array($saved)) {
        return $defaults;
    }
    return array_merge($defaults, array_intersect_key($saved, $defaults));
}

/**
 * @param mixed $input
 * @return array<string, string>
 */
function babygym_sanitize_galleria_options($input): array
{
    $defaults  = babygym_galleria_defaults();
    $sanitized = [];

    foreach ($defaults as $key => $default_value) {
        $value = isset($input[$key]) ? $input[$key] : $default_value;
        if (! is_string($value)) {
            $value = (string) $value;
        }

        if ('gallery_images' === $key) {
            $lines = preg_split('/\r\n|\r|\n/', $value) ?: [];
            $urls  = [];
            foreach ($lines as $line) {
                $line = trim($line);
                if ('' === $line) {
                    continue;
                }
                $url = esc_url_raw($line);
                if ('' !== $url) {
                    $urls[] = $url;
                }
            }
            $sanitized[$key] = implode("\n", array_unique($urls));
            continue;
        }

        $sanitized[$key] = sanitize_text_field($value);
    }

    return $sanitized;
}

add_action('admin_init', function () {
    register_setting(
        'babygym_galleria_settings',
        'babygym_galleria_options',
        [
            'type'              => 'array',
            'sanitize_callback' => 'babygym_sanitize_galleria_options',
            'default'           => babygym_galleria_defaults(),
        ]
    );
});

add_action('admin_menu', function () {
    add_menu_page(
        'Galleria',
        'Galleria',
        'manage_options',
        'babygym-galleria',
        'babygym_render_galleria_admin_page',
        'dashicons-format-image',
        33
    );
});

function babygym_render_galleria_admin_page(): void
{
    $options = babygym_get_galleria_options();
    $gallery_lines = preg_split('/\r\n|\r|\n/', (string) $options['gallery_images']) ?: [];
    $gallery_urls  = array_values(array_filter(array_map('trim', $gallery_lines)));
    require get_theme_file_path('inc/admin-tabs/galleria.php');
}

