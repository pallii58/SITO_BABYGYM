<?php
/**
 * Customizer: URL video per pagina /video (una per riga, YouTube o Vimeo).
 *
 * @package BABYGYM
 */

if (! defined('ABSPATH')) {
    exit;
}

add_action('customize_register', function (\WP_Customize_Manager $wp_customize): void {
    $wp_customize->add_section('babygym_video_section', [
        'title'       => __('Pagina Video', 'babygym'),
        'description' => __('Incolla gli URL dei video (YouTube o Vimeo), uno per riga. La pagina deve avere permalink "video".', 'babygym'),
        'priority'    => 85,
    ]);

    $wp_customize->add_setting('babygym_video_urls', [
        'type'              => 'theme_mod',
        'sanitize_callback' => 'babygym_sanitize_video_urls_textarea',
        'default'           => '',
    ]);

    $wp_customize->add_control('babygym_video_urls_control', [
        'label'       => __('URL video', 'babygym'),
        'section'     => 'babygym_video_section',
        'settings'    => 'babygym_video_urls',
        'type'        => 'textarea',
        'input_attrs' => [
            'rows'        => 6,
            'placeholder' => 'https://www.youtube.com/watch?v=...',
        ],
    ]);
});

/**
 * @param mixed $value
 */
function babygym_sanitize_video_urls_textarea($value): string
{
    if (! is_string($value)) {
        return '';
    }
    $lines = preg_split('/\r\n|\r|\n/', $value) ?: [];
    $out   = [];
    foreach ($lines as $line) {
        $line = trim($line);
        if ('' === $line) {
            continue;
        }
        $line = esc_url_raw($line);
        if ('' !== $line && null !== babygym_parse_video_embed_src($line)) {
            $out[] = $line;
        }
    }
    return implode("\n", $out);
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

    if (preg_match('#(?:www\.)?youtube\.com/embed/([a-zA-Z0-9_-]{11})#', $raw, $m)) {
        return 'https://www.youtube.com/embed/' . $m[1];
    }
    if (preg_match('#[\?&#]v=([a-zA-Z0-9_-]{11})#', $raw, $m)) {
        return 'https://www.youtube.com/embed/' . $m[1];
    }
    if (preg_match('#youtu\.be/([a-zA-Z0-9_-]{11})#', $raw, $m)) {
        return 'https://www.youtube.com/embed/' . $m[1];
    }
    if (preg_match('#player\.vimeo\.com/video/(\d+)#', $raw, $m)) {
        return 'https://player.vimeo.com/video/' . $m[1];
    }
    if (preg_match('#(?:www\.)?vimeo\.com/(?:video/)?(\d+)#', $raw, $m)) {
        return 'https://player.vimeo.com/video/' . $m[1];
    }

    return null;
}

/**
 * @return list<string>
 */
function babygym_get_video_embed_src_list(): array
{
    $raw = (string) get_theme_mod('babygym_video_urls', '');
    $lines = preg_split('/\r\n|\r|\n/', $raw) ?: [];
    $srcs  = [];
    foreach ($lines as $line) {
        $line = trim((string) $line);
        if ('' === $line) {
            continue;
        }
        $emb = babygym_parse_video_embed_src($line);
        if (null !== $emb) {
            $srcs[] = $emb;
        }
    }
    return array_values(array_unique($srcs));
}
