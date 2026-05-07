<?php
/**
 * CPT: Summer Camp + metabox + salvataggio metadati.
 *
 * @package BABYGYM
 */

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Registra CPT Summer Camp (gestione tipo prodotti).
 */
add_action('init', function (): void {
    $summer_camp_menu_icon = 'data:image/svg+xml;base64,' . base64_encode('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill="#1d2327" d="M10.4 2.2c1.6 1.2 2.6 2.7 3 4.6 1.2-.6 2.5-.8 4-.5-.7 2.1-2.1 3.6-4.1 4.5.8.5 1.4 1.2 1.9 2.1-1.8.4-3.4.1-4.8-1-.2.8-.6 1.7-1.2 2.5V18h1.7c.3 0 .5.2.5.5s-.2.5-.5.5H6.8c-.3 0-.5-.2-.5-.5s.2-.5.5-.5h1.7v-3.2c-.7-.9-1.1-1.7-1.3-2.6-1.3 1.1-2.9 1.4-4.8 1 .5-.9 1.1-1.6 1.9-2.1-2-.9-3.4-2.4-4.1-4.5 1.5-.3 2.8-.1 4 .5.4-1.9 1.4-3.4 3-4.6.7.6 1.2 1.2 1.6 2 .4-.8.9-1.4 1.6-2z"/></svg>');
    register_post_type('summer_camp', [
        'labels' => [
            'name' => __('Summer Camp', 'babygym'),
            'singular_name' => __('Summer Camp', 'babygym'),
            'menu_name' => __('Summer Camp', 'babygym'),
            'name_admin_bar' => __('Summer Camp', 'babygym'),
            'add_new' => __('Nuovo Summer Camp', 'babygym'),
            'add_new_item' => __('Aggiungi nuovo Summer Camp', 'babygym'),
            'edit_item' => __('Modifica Summer Camp', 'babygym'),
            'new_item' => __('Nuovo Summer Camp', 'babygym'),
            'view_item' => __('Visualizza Summer Camp', 'babygym'),
            'all_items' => __('Tutti i Summer Camp', 'babygym'),
            'search_items' => __('Cerca Summer Camp', 'babygym'),
            'not_found' => __('Nessun Summer Camp trovato', 'babygym'),
        ],
        'public' => true,
        'show_in_menu' => true,
        'menu_position' => 32,
        'menu_icon' => $summer_camp_menu_icon,
        'supports' => ['title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'page-attributes'],
        'has_archive' => false,
        'rewrite' => ['slug' => 'summer-camp'],
        'show_in_rest' => true,
    ]);
});

/**
 * Flush rewrite rules una sola volta dopo aver registrato il CPT Summer Camp.
 */
add_action('init', function (): void {
    $flag_key = 'babygym_summer_camp_rewrite_flushed_v1';
    if ('1' === get_option($flag_key, '0')) {
        return;
    }
    flush_rewrite_rules(false);
    update_option($flag_key, '1');
}, 99);

/**
 * Meta box dettagli Summer Camp.
 */
add_action('add_meta_boxes', function (): void {
    add_meta_box(
        'babygym_summer_camp_details',
        __('Dettagli Summer Camp', 'babygym'),
        'babygym_render_summer_camp_details_metabox',
        'summer_camp',
        'normal',
        'high'
    );
});

function babygym_parse_summer_camp_schedule_rows(string $raw): array
{
    $lines = preg_split('/\r\n|\r|\n/', $raw) ?: [];
    $rows  = [];
    foreach ($lines as $line) {
        $line = trim($line);
        if ('' === $line) {
            continue;
        }
        $parts = array_map('trim', explode('|', $line));
        if (count($parts) < 3) {
            continue;
        }
        // Formato corrente: Giorno|Fascia|HH:MM|HH:MM|Nota
        // Formato legacy: Etichetta|HH:MM|HH:MM|Nota
        if (count($parts) >= 5) {
            $day = sanitize_text_field($parts[0] ?? '');
            $start = babygym_sanitize_time_value((string) ($parts[2] ?? ''), '');
            $end   = babygym_sanitize_time_value((string) ($parts[3] ?? ''), '');
            $note  = sanitize_text_field($parts[4] ?? '');
        } else {
            $day = sanitize_text_field($parts[0] ?? '');
            $start = babygym_sanitize_time_value((string) ($parts[1] ?? ''), '');
            $end   = babygym_sanitize_time_value((string) ($parts[2] ?? ''), '');
            $note  = sanitize_text_field($parts[3] ?? '');
        }
        if ('' === $day || '' === $start || '' === $end) {
            continue;
        }
        $rows[] = [
            'day' => $day,
            'start' => $start,
            'end' => $end,
            'note' => $note,
        ];
    }
    return $rows;
}

function babygym_serialize_summer_camp_schedule_rows(array $rows): string
{
    $lines = [];
    foreach ($rows as $row) {
        $lines[] = implode('|', [
            trim((string) ($row['day'] ?? '')),
            'Fascia',
            trim((string) ($row['start'] ?? '')),
            trim((string) ($row['end'] ?? '')),
            trim((string) ($row['note'] ?? '')),
        ]);
    }
    return implode("\n", $lines);
}

function babygym_parse_summer_camp_week_rows(string $raw): array
{
    $lines = preg_split('/\r\n|\r|\n/', $raw) ?: [];
    $rows  = [];
    foreach ($lines as $line) {
        $line = trim($line);
        if ('' === $line) {
            continue;
        }
        $parts = array_map('trim', explode('|', $line));
        $week  = sanitize_text_field((string) ($parts[0] ?? ''));
        $note  = sanitize_text_field((string) ($parts[1] ?? ''));
        if ('' === $week) {
            continue;
        }
        $rows[] = [
            'week' => $week,
            'note' => $note,
        ];
    }
    return $rows;
}

function babygym_serialize_summer_camp_week_rows(array $rows): string
{
    $lines = [];
    foreach ($rows as $row) {
        $lines[] = implode('|', [
            trim((string) ($row['week'] ?? '')),
            trim((string) ($row['note'] ?? '')),
        ]);
    }
    return implode("\n", $lines);
}

function babygym_parse_summer_camp_post_rows(string $raw): array
{
    $lines = preg_split('/\r\n|\r|\n/', $raw) ?: [];
    $rows  = [];
    foreach ($lines as $line) {
        $line = trim($line);
        if ('' === $line) {
            continue;
        }
        $parts = array_map('trim', explode('|', $line));
        $start = babygym_sanitize_time_value((string) ($parts[0] ?? ''), '');
        $end   = babygym_sanitize_time_value((string) ($parts[1] ?? ''), '');
        $note  = sanitize_text_field((string) ($parts[2] ?? ''));
        if ('' === $start || '' === $end) {
            continue;
        }
        $rows[] = [
            'start' => $start,
            'end' => $end,
            'note' => $note,
        ];
    }
    return $rows;
}

function babygym_serialize_summer_camp_post_rows(array $rows): string
{
    $lines = [];
    foreach ($rows as $row) {
        $lines[] = implode('|', [
            trim((string) ($row['start'] ?? '')),
            trim((string) ($row['end'] ?? '')),
            trim((string) ($row['note'] ?? '')),
        ]);
    }
    return implode("\n", $lines);
}

function babygym_parse_summer_camp_cost_rows(string $raw): array
{
    $lines = preg_split('/\r\n|\r|\n/', $raw) ?: [];
    $rows  = [];
    foreach ($lines as $line) {
        $line = trim($line);
        if ('' === $line) {
            continue;
        }
        $parts = array_map('trim', explode('|', $line));
        $label = sanitize_text_field((string) ($parts[0] ?? ''));
        $value = sanitize_text_field((string) ($parts[1] ?? ''));
        if ('' === $label && '' === $value) {
            continue;
        }
        $rows[] = [
            'label' => $label,
            'value' => $value,
        ];
    }
    return $rows;
}

function babygym_serialize_summer_camp_cost_rows(array $rows): string
{
    $lines = [];
    foreach ($rows as $row) {
        $lines[] = implode('|', [
            trim((string) ($row['label'] ?? '')),
            trim((string) ($row['value'] ?? '')),
        ]);
    }
    return implode("\n", $lines);
}

/**
 * URL file video da allegato Libreria media (solo mime video).
 */
function babygym_summer_camp_get_video_attachment_url(int $attachment_id): string
{
    if ($attachment_id <= 0) {
        return '';
    }
    if (! wp_attachment_is('video', $attachment_id)) {
        return '';
    }
    $url = wp_get_attachment_url($attachment_id);

    return is_string($url) ? $url : '';
}

/**
 * Video promozionali: tutti i sorgenti configurati (embed YouTube/Vimeo se il link è valido + eventuale upload).
 *
 * @return list<array{type: 'iframe', src: string, iframe_title: string}|array{type: 'upload', url: string}>
 */
function babygym_summer_camp_get_promo_videos(int $post_id): array
{
    $videos        = [];
    $url_raw       = trim((string) get_post_meta($post_id, '_babygym_summer_camp_video_url', true));
    $attachment_id = (int) get_post_meta($post_id, '_babygym_summer_camp_video_attachment_id', true);

    if ('' !== $url_raw && function_exists('babygym_parse_video_embed_src')) {
        $embed_src = babygym_parse_video_embed_src($url_raw);
        if (null !== $embed_src && '' !== $embed_src) {
            if (false !== strpos($embed_src, 'youtube.com/embed')) {
                $sep = strpos($embed_src, '?') !== false ? '&' : '?';
                $embed_src .= $sep . 'rel=0';
            }
            /* translators: Summer Camp singolo (titolo iframe) */
            $title      = sprintf('%s — %s', get_the_title($post_id), __('Video Summer Camp', 'babygym'));
            $videos[]   = ['type' => 'iframe', 'src' => $embed_src, 'iframe_title' => $title];
        }
    }

    $file_url = babygym_summer_camp_get_video_attachment_url($attachment_id);
    if ('' !== $file_url) {
        $videos[] = ['type' => 'upload', 'url' => $file_url];
    }

    return $videos;
}

function babygym_render_summer_camp_details_metabox(\WP_Post $post): void
{
    wp_nonce_field('babygym_summer_camp_meta_save', 'babygym_summer_camp_meta_nonce');
    $locandina_url = (string) get_post_meta($post->ID, '_babygym_summer_camp_locandina_url', true);
    $gallery_raw   = (string) get_post_meta($post->ID, '_babygym_summer_camp_gallery', true);
    $descrizione   = (string) get_post_meta($post->ID, '_babygym_summer_camp_descrizione', true);
    $eta           = (string) get_post_meta($post->ID, '_babygym_summer_camp_eta', true);
    $indirizzo     = (string) get_post_meta($post->ID, '_babygym_summer_camp_indirizzo', true);
    $settimane     = (string) get_post_meta($post->ID, '_babygym_summer_camp_settimane', true);
    $orario        = (string) get_post_meta($post->ID, '_babygym_summer_camp_orario', true);
    $post_orario   = (string) get_post_meta($post->ID, '_babygym_summer_camp_post_orario', true);
    $schedule_rows_raw = (string) get_post_meta($post->ID, '_babygym_summer_camp_schedule_rows', true);
    $iscrizioni_entro = (string) get_post_meta($post->ID, '_babygym_summer_camp_iscrizioni_entro', true);
    $note           = (string) get_post_meta($post->ID, '_babygym_summer_camp_note', true);
    $quota_assicurazione = (string) get_post_meta($post->ID, '_babygym_summer_camp_quota_assicurazione_iscrizione', true);
    $week_rows_raw = (string) get_post_meta($post->ID, '_babygym_summer_camp_week_rows', true);
    $post_rows_raw = (string) get_post_meta($post->ID, '_babygym_summer_camp_post_rows', true);
    $cost_rows_raw = (string) get_post_meta($post->ID, '_babygym_summer_camp_cost_rows', true);
    $video_url     = (string) get_post_meta($post->ID, '_babygym_summer_camp_video_url', true);
    $video_attachment_id = (int) get_post_meta($post->ID, '_babygym_summer_camp_video_attachment_id', true);
    $gallery_urls  = array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $gallery_raw) ?: [])));
    $schedule_rows = babygym_parse_summer_camp_schedule_rows($schedule_rows_raw);
    if ([] === $schedule_rows) {
        $legacy_to_row = static function (string $label, string $value): ?array {
            if (preg_match('/^\s*([01]?\d[:\.][0-5]\d)\s*-\s*([01]?\d[:\.][0-5]\d)\s*(.*)$/u', trim($value), $matches) !== 1) {
                return null;
            }
            $start = babygym_sanitize_time_value((string) $matches[1], '');
            $end   = babygym_sanitize_time_value((string) $matches[2], '');
            if ('' === $start || '' === $end) {
                return null;
            }
            return [
                'day' => $label,
                'start' => $start,
                'end' => $end,
                'note' => trim((string) ($matches[3] ?? '')),
            ];
        };
        $orario_row = $legacy_to_row('ORARIO', $orario);
        $post_row   = $legacy_to_row('POST', $post_orario);
        if (null !== $orario_row) {
            $schedule_rows[] = $orario_row;
        }
        if (null !== $post_row) {
            $schedule_rows[] = $post_row;
        }
    }
    $schedule_rows_raw = babygym_serialize_summer_camp_schedule_rows($schedule_rows);
    $week_rows = babygym_parse_summer_camp_week_rows($week_rows_raw);
    if ([] === $week_rows && '' !== trim($settimane)) {
        $week_rows[] = [
            'week' => sanitize_text_field($settimane),
            'note' => '',
        ];
    }
    $week_rows_raw = babygym_serialize_summer_camp_week_rows($week_rows);
    $post_rows = babygym_parse_summer_camp_post_rows($post_rows_raw);
    if ([] === $post_rows && '' !== trim($post_orario)) {
        if (preg_match('/^\s*([01]?\d[:\.][0-5]\d)\s*-\s*([01]?\d[:\.][0-5]\d)\s*(.*)$/u', trim($post_orario), $matches) === 1) {
            $start = babygym_sanitize_time_value((string) $matches[1], '');
            $end   = babygym_sanitize_time_value((string) $matches[2], '');
            if ('' !== $start && '' !== $end) {
                $post_rows[] = [
                    'start' => $start,
                    'end' => $end,
                    'note' => sanitize_text_field(trim((string) ($matches[3] ?? ''))),
                ];
            }
        }
    }
    $post_rows_raw = babygym_serialize_summer_camp_post_rows($post_rows);
    $cost_rows = babygym_parse_summer_camp_cost_rows($cost_rows_raw);
    $cost_rows_raw = babygym_serialize_summer_camp_cost_rows($cost_rows);
    $video_promo_items        = babygym_summer_camp_get_promo_videos((int) $post->ID);
    $video_upload_preview_url = babygym_summer_camp_get_video_attachment_url($video_attachment_id);
    require get_theme_file_path('inc/admin-tabs/summer-camp.php');
}

/**
 * Salva metadati Summer Camp.
 */
add_action('save_post_summer_camp', function (int $post_id): void {
    if (! isset($_POST['babygym_summer_camp_meta_nonce'])) {
        return;
    }
    $nonce = sanitize_text_field(wp_unslash($_POST['babygym_summer_camp_meta_nonce']));
    if (! wp_verify_nonce($nonce, 'babygym_summer_camp_meta_save')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (! current_user_can('edit_post', $post_id)) {
        return;
    }

    $locandina_url = isset($_POST['babygym_summer_camp_locandina_url']) ? esc_url_raw(wp_unslash($_POST['babygym_summer_camp_locandina_url'])) : '';
    $gallery_raw   = isset($_POST['babygym_summer_camp_gallery']) ? wp_unslash($_POST['babygym_summer_camp_gallery']) : '';
    $eta_raw         = isset($_POST['babygym_summer_camp_eta']) ? wp_unslash($_POST['babygym_summer_camp_eta']) : '';
    $indirizzo_raw   = isset($_POST['babygym_summer_camp_indirizzo']) ? wp_unslash($_POST['babygym_summer_camp_indirizzo']) : '';
    $schedule_rows_raw = isset($_POST['babygym_summer_camp_schedule_rows']) ? wp_unslash($_POST['babygym_summer_camp_schedule_rows']) : '';
    $week_rows_raw = isset($_POST['babygym_summer_camp_week_rows']) ? wp_unslash($_POST['babygym_summer_camp_week_rows']) : '';
    $post_rows_raw = isset($_POST['babygym_summer_camp_post_rows']) ? wp_unslash($_POST['babygym_summer_camp_post_rows']) : '';
    $cost_rows_raw = isset($_POST['babygym_summer_camp_cost_rows']) ? wp_unslash($_POST['babygym_summer_camp_cost_rows']) : '';
    $iscrizioni_entro_raw = isset($_POST['babygym_summer_camp_iscrizioni_entro']) ? wp_unslash($_POST['babygym_summer_camp_iscrizioni_entro']) : '';
    $note_raw = isset($_POST['babygym_summer_camp_note']) ? wp_unslash($_POST['babygym_summer_camp_note']) : '';
    $quota_assicurazione_raw = isset($_POST['babygym_summer_camp_quota_assicurazione_iscrizione']) ? wp_unslash($_POST['babygym_summer_camp_quota_assicurazione_iscrizione']) : '';
    $descrizione_raw = isset($_POST['babygym_summer_camp_descrizione']) ? wp_unslash($_POST['babygym_summer_camp_descrizione']) : '';
    $video_url_raw = isset($_POST['babygym_summer_camp_video_url']) ? sanitize_text_field(wp_unslash($_POST['babygym_summer_camp_video_url'])) : '';
    $video_attachment_id = isset($_POST['babygym_summer_camp_video_attachment_id']) ? absint($_POST['babygym_summer_camp_video_attachment_id']) : 0;

    $gallery_lines = preg_split('/\r\n|\r|\n/', (string) $gallery_raw) ?: [];
    $gallery_urls  = [];
    foreach ($gallery_lines as $line) {
        $line = trim($line);
        if ('' === $line) {
            continue;
        }
        $url = esc_url_raw($line);
        if ('' !== $url) {
            $gallery_urls[] = $url;
        }
    }

    $schedule_rows = babygym_parse_summer_camp_schedule_rows((string) $schedule_rows_raw);
    $schedule_rows_serialized = babygym_serialize_summer_camp_schedule_rows($schedule_rows);
    $week_rows = babygym_parse_summer_camp_week_rows((string) $week_rows_raw);
    $week_rows_serialized = babygym_serialize_summer_camp_week_rows($week_rows);
    $post_rows = babygym_parse_summer_camp_post_rows((string) $post_rows_raw);
    $post_rows_serialized = babygym_serialize_summer_camp_post_rows($post_rows);
    $cost_rows = babygym_parse_summer_camp_cost_rows((string) $cost_rows_raw);
    $cost_rows_serialized = babygym_serialize_summer_camp_cost_rows($cost_rows);
    $settimane_label = implode(', ', array_map(
        static fn (array $row): string => trim((string) ($row['week'] ?? '')),
        $week_rows
    ));

    $format_schedule_label = static function (array $row): string {
        $start = str_replace(':', '.', (string) ($row['start'] ?? ''));
        $end   = str_replace(':', '.', (string) ($row['end'] ?? ''));
        $note  = trim((string) ($row['note'] ?? ''));
        $time_label = trim($start . ' - ' . $end);
        return '' !== $note ? ($time_label . ' ' . $note) : $time_label;
    };
    $orario_label = '';
    $post_label = '';
    foreach ($schedule_rows as $row) {
        $day = trim((string) ($row['day'] ?? ''));
        if ('' === $orario_label) {
            $orario_label = $format_schedule_label($row);
            if ('' !== $day) {
                $orario_label = $day . ': ' . $orario_label;
            }
            continue;
        }
        if ('' === $post_label) {
            $post_label = $format_schedule_label($row);
            if ('' !== $day) {
                $post_label = $day . ': ' . $post_label;
            }
            continue;
        }
    }
    if ('' === $orario_label && isset($schedule_rows[0])) {
        $orario_label = $format_schedule_label($schedule_rows[0]);
    }
    if ('' === $post_label && isset($post_rows[0])) {
        $post_label = $format_schedule_label($post_rows[0]);
    }
    if ('' === $post_label && isset($schedule_rows[1])) {
        $post_label = $format_schedule_label($schedule_rows[1]);
    }

    update_post_meta($post_id, '_babygym_summer_camp_locandina_url', $locandina_url);
    update_post_meta($post_id, '_babygym_summer_camp_gallery', implode("\n", array_values(array_unique($gallery_urls))));
    update_post_meta($post_id, '_babygym_summer_camp_eta', sanitize_text_field((string) $eta_raw));
    update_post_meta($post_id, '_babygym_summer_camp_indirizzo', sanitize_text_field((string) $indirizzo_raw));
    update_post_meta($post_id, '_babygym_summer_camp_settimane', sanitize_text_field($settimane_label));
    update_post_meta($post_id, '_babygym_summer_camp_schedule_rows', $schedule_rows_serialized);
    update_post_meta($post_id, '_babygym_summer_camp_week_rows', $week_rows_serialized);
    update_post_meta($post_id, '_babygym_summer_camp_post_rows', $post_rows_serialized);
    update_post_meta($post_id, '_babygym_summer_camp_cost_rows', $cost_rows_serialized);
    update_post_meta($post_id, '_babygym_summer_camp_orario', sanitize_text_field($orario_label));
    update_post_meta($post_id, '_babygym_summer_camp_post_orario', sanitize_text_field($post_label));
    update_post_meta($post_id, '_babygym_summer_camp_iscrizioni_entro', sanitize_text_field((string) $iscrizioni_entro_raw));
    update_post_meta($post_id, '_babygym_summer_camp_note', sanitize_textarea_field((string) $note_raw));
    update_post_meta($post_id, '_babygym_summer_camp_quota_assicurazione_iscrizione', sanitize_text_field((string) $quota_assicurazione_raw));
    update_post_meta($post_id, '_babygym_summer_camp_descrizione', sanitize_textarea_field((string) $descrizione_raw));

    if ('' !== $video_url_raw) {
        update_post_meta($post_id, '_babygym_summer_camp_video_url', $video_url_raw);
    } else {
        delete_post_meta($post_id, '_babygym_summer_camp_video_url');
    }

    if ($video_attachment_id > 0 && wp_attachment_is('video', $video_attachment_id)) {
        update_post_meta($post_id, '_babygym_summer_camp_video_attachment_id', $video_attachment_id);
    } else {
        delete_post_meta($post_id, '_babygym_summer_camp_video_attachment_id');
    }
});

