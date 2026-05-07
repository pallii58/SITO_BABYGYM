<?php
/**
 * Customizer: canale YouTube per la galleria /video + utility parse URL vide esterni.
 *
 * @package BABYGYM
 */

if (! defined('ABSPATH')) {
    exit;
}

add_action('customize_register', function (\WP_Customize_Manager $wp_customize): void {
    $wp_customize->add_section('babygym_video_section', [
        'title'       => __('Pagina Video (YouTube)', 'babygym'),
        'description' => __('Legge gli upload pubblici del canale: con la chiave Data API hai l’elenco completo aggiornato; senza chiave si usa il feed RSS pubblico (a volte più corto). Crea anche una pagina con permalink «video».', 'babygym'),
        'priority'    => 85,
    ]);

    $wp_customize->add_setting('babygym_youtube_channel_handle', [
        'type'              => 'theme_mod',
        'sanitize_callback' => 'babygym_sanitize_youtube_channel_handle',
        'default'           => 'babygym5384',
    ]);

    $wp_customize->add_control('babygym_youtube_channel_handle_control', [
        'label'       => __('Handle del canale', 'babygym'),
        /* translators: %s: placeholder example */
        'description' => sprintf(__('Solo nome handle, senza @ (es.: %s).', 'babygym'), 'babygym5384'),
        'section'     => 'babygym_video_section',
        'settings'    => 'babygym_youtube_channel_handle',
        'type'        => 'text',
        'input_attrs' => [
            'placeholder' => 'babygym5384',
        ],
    ]);

    $wp_customize->add_setting('babygym_youtube_api_key', [
        'type'              => 'theme_mod',
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => '',
    ]);

    $wp_customize->add_control('babygym_youtube_api_key_control', [
        'label'       => __('Chiave YouTube Data API (opzionale)', 'babygym'),
        'description' => __('Ottieni una chiave dalla Google Cloud Console (YouTube Data API v3 attiva). Lascia vuota per usare solo il feed pubblico dell’RSS.', 'babygym'),
        'section'     => 'babygym_video_section',
        'settings'    => 'babygym_youtube_api_key',
        'type'        => 'text',
        'input_attrs' => [
            'autocomplete' => 'off',
            'placeholder' => 'AIzaSy…',
            'class'       => 'code',
        ],
    ]);
});

/**
 * @param mixed $value
 */
function babygym_sanitize_youtube_channel_handle($value): string
{
    $v = strtolower(trim(ltrim((string) $value, '@')));
    $v = preg_replace('/[^a-zA-Z0-9_.-]/', '', $v);

    return '' !== $v ? $v : 'babygym5384';
}

/**
 * @return non-empty-string|null
 */
function babygym_parse_video_embed_src(string $raw): ?string
{
    $raw = trim($raw);
    if ('' === $raw) {
        return null;
    }

    if (preg_match('~(?:www\.)?youtube\.com/embed/([a-zA-Z0-9_-]{11})~', $raw, $m)) {
        return 'https://www.youtube.com/embed/' . $m[1];
    }
    if (preg_match('~[\?&#]v=([a-zA-Z0-9_-]{11})~', $raw, $m)) {
        return 'https://www.youtube.com/embed/' . $m[1];
    }
    if (preg_match('~youtu\.be/([a-zA-Z0-9_-]{11})~', $raw, $m)) {
        return 'https://www.youtube.com/embed/' . $m[1];
    }
    if (preg_match('~player\.vimeo\.com/video/(\d+)~', $raw, $m)) {
        return 'https://player.vimeo.com/video/' . $m[1];
    }
    if (preg_match('~(?:www\.)?vimeo\.com/(?:video/)?(\d+)~', $raw, $m)) {
        return 'https://player.vimeo.com/video/' . $m[1];
    }

    return null;
}
