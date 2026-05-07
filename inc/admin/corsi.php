<?php
/**
 * Admin: pagina impostazioni "Corsi".
 *
 * @package BABYGYM
 */

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Default opzioni pagina "Corsi".
 *
 * @return array<string, string>
 */
function babygym_corsi_defaults(): array
{
    return [
        'carousel_images' => '',
        'skills_items' => implode("\n", [
            'ruota / rondata',
            'verticale e varianti (con capovolta, alle parallele, al muro con camminata laterale)',
            'capovolte avanti, indietro, indietro alla verticale, tuffate',
            'giri addominali alla sbarra (in avanti e indietro)',
            'flick-flack indietro e ribaltata avanti',
            'tecniche di atterraggio',
            'abilità sulla trave di equilibrio',
            'utilizzo della pedana elastica per salti e volteggi',
            'giochi e sport di squadra',
        ]),
        'equipment_items' => implode("\n", [
            'travi di equilibrio',
            'parallele',
            'sbarre',
            'pedana elastica',
            'grandi materassoni colorati in materiale espanso',
            'corda elastica, paracadute, hula hoop, corde, palloni, foulard, sacchetti motori, strumenti musicali e altro',
        ]),
        // Formato riga: Sede|Corso|Giorno|Orari.
        'schedule_rows' => implode("\n", [
            'Via Vespucci 36, Torino|BUGS (4-10 mesi)|Mercoledì|15.20 - 16.20',
            'Via Vespucci 36, Torino|BUGS (4-10 mesi)|Giovedì|9.00 - 10.00',
            'Via Vespucci 36, Torino|BIRDS (10-19 mesi)|Mercoledì|10.00 - 11.00 (da attivare)',
            'Via Vespucci 36, Torino|BIRDS (10-19 mesi)|Giovedì|10.00 - 11.00, 15.30 - 16.30',
            'Via Vespucci 36, Torino|BEASTS (19 mesi - 3 anni)|Lunedì|16.30 - 17.30',
            'Via Vespucci 36, Torino|BEASTS (19 mesi - 3 anni)|Martedì|10.00 - 11.00, 11.00 - 12.00, 16.20 - 17.20, 18.20 - 19.20',
            'Via Vespucci 36, Torino|BEASTS (19 mesi - 3 anni)|Mercoledì|11.00 - 12.00 (da attivare), 18.20 - 19.20',
            'Via Vespucci 36, Torino|BEASTS (19 mesi - 3 anni)|Giovedì|11.00 - 12.00, 15.30 - 16.30',
            'Via Vespucci 36, Torino|BEASTS (19 mesi - 3 anni)|Venerdì|16.30 - 17.30',
            'Via Vespucci 36, Torino|BEASTS (19 mesi - 3 anni)|Sabato|10.00 - 11.00',
            'Via Vespucci 36, Torino|FUNNY BUGS (3-4 anni)|Lunedì|17.30 - 18.30',
            'Via Vespucci 36, Torino|FUNNY BUGS (3-4 anni)|Mercoledì|17.20 - 18.20',
            'Via Vespucci 36, Torino|FUNNY BUGS (3-4 anni)|Giovedì|16.30 - 17.30',
            'Via Vespucci 36, Torino|FUNNY BUGS (3-4 anni)|Sabato|9.00 - 10.00',
            'Via Vespucci 36, Torino|GOOD FRIENDS (4-6 anni)|Lunedì|18.30 - 19.30',
            'Via Vespucci 36, Torino|GOOD FRIENDS (4-6 anni)|Martedì|17.20 - 18.20',
            'Via Vespucci 36, Torino|GOOD FRIENDS (4-6 anni)|Mercoledì|16.20 - 17.20',
            'Via Vespucci 36, Torino|GOOD FRIENDS (4-6 anni)|Giovedì|18.30 - 19.30',
            'Via Vespucci 36, Torino|GOOD FRIENDS (4-6 anni)|Venerdì|17.30 - 18.30',
            'Via Vespucci 36, Torino|GOOD FRIENDS (4-6 anni)|Sabato|9.00 - 10.00, 11.00 - 12.00',
            'Via Vespucci 36, Torino|FLIPS (6-9 anni)|Giovedì|17.30 - 18.30',
            'Via Vespucci 36, Torino|FLIPS (6-9 anni)|Sabato|12.00 - 13.00',
        ]),
    ];
}

/**
 * @return array<string, string>
 */
function babygym_get_corsi_options(): array
{
    $defaults = babygym_corsi_defaults();
    $saved    = get_option('babygym_corsi_options', []);
    if (! is_array($saved)) {
        return $defaults;
    }
    return array_merge($defaults, array_intersect_key($saved, $defaults));
}

/**
 * @param mixed $input
 * @return array<string, string>
 */
function babygym_sanitize_corsi_options($input): array
{
    $defaults = babygym_corsi_defaults();
    $sanitized = [];

    foreach ($defaults as $key => $default_value) {
        $value = isset($input[$key]) ? $input[$key] : $default_value;
        if (! is_string($value)) {
            $value = (string) $value;
        }
        if ('carousel_images' === $key) {
            $lines = preg_split('/\r\n|\r|\n/', $value) ?: [];
            $urls = [];
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
        if (in_array($key, ['skills_items', 'equipment_items'], true)) {
            $lines = babygym_parse_multiline_text($value);
            $sanitized[$key] = implode("\n", $lines);
            continue;
        }
        if ('schedule_rows' === $key) {
            $rows = babygym_parse_corsi_schedule_rows($value);
            $sanitized[$key] = babygym_serialize_corsi_schedule_rows($rows);
            continue;
        }
        $sanitized[$key] = sanitize_text_field($value);
    }

    return $sanitized;
}

/**
 * @return array<int, string>
 */
function babygym_parse_multiline_text(string $text): array
{
    $lines = preg_split('/\r\n|\r|\n/', $text) ?: [];
    $clean = [];
    foreach ($lines as $line) {
        $line = sanitize_text_field(trim($line));
        if ('' !== $line) {
            $clean[] = $line;
        }
    }
    return $clean;
}

/**
 * @return array<int, array{location:string,course:string,day:string,times:string,status:string}>
 */
function babygym_parse_corsi_schedule_rows(string $raw): array
{
    $lines = preg_split('/\r\n|\r|\n/', $raw) ?: [];
    $rows = [];
    foreach ($lines as $line) {
        $line = trim($line);
        if ('' === $line) {
            continue;
        }
        $parts = array_map('trim', explode('|', $line));
        if (count($parts) < 4) {
            continue;
        }
        $location = sanitize_text_field($parts[0]);
        $course   = sanitize_text_field($parts[1]);
        $day      = sanitize_text_field($parts[2]);
        $times    = sanitize_text_field($parts[3]);
        $status   = isset($parts[4]) ? sanitize_text_field($parts[4]) : 'active';
        if (! in_array($status, ['active', 'inactive'], true)) {
            $status = 'active';
        }
        if ('' === $location || '' === $course || '' === $day || '' === $times) {
            continue;
        }
        $rows[] = [
            'location' => $location,
            'course' => $course,
            'day' => $day,
            'times' => $times,
            'status' => $status,
        ];
    }
    return $rows;
}

/**
 * @param array<int, array{location:string,course:string,day:string,times:string,status?:string}> $rows
 */
function babygym_serialize_corsi_schedule_rows(array $rows): string
{
    $lines = [];
    foreach ($rows as $row) {
        $lines[] = implode('|', [
            trim($row['location']),
            trim($row['course']),
            trim($row['day']),
            trim($row['times']),
            trim((string) ($row['status'] ?? 'active')),
        ]);
    }
    return implode("\n", $lines);
}

/**
 * @return array<int, array{location:string,courses:array<string,array<int,string>>,days:array<int,string>,table:array<string,array<string,array<int,string>>>}>
 */
function babygym_get_corsi_schedule_sections(string $raw_rows): array
{
    $rows = babygym_parse_corsi_schedule_rows($raw_rows);
    if ([] === $rows) {
        return [];
    }

    $sections = [];
    foreach ($rows as $row) {
        if (($row['status'] ?? 'active') !== 'active') {
            continue;
        }
        $location = $row['location'];
        $course   = $row['course'];
        $day      = $row['day'];
        $times    = $row['times'];

        if (! isset($sections[$location])) {
            $sections[$location] = [
                'location' => $location,
                'courses' => [],
                'days' => [],
                'table' => [],
            ];
        }
        if (! isset($sections[$location]['courses'][$course])) {
            $sections[$location]['courses'][$course] = [];
        }
        $sections[$location]['courses'][$course][] = $day . ': ' . $times;

        if (! in_array($day, $sections[$location]['days'], true)) {
            $sections[$location]['days'][] = $day;
        }
        if (! isset($sections[$location]['table'][$course])) {
            $sections[$location]['table'][$course] = [];
        }
        if (! isset($sections[$location]['table'][$course][$day])) {
            $sections[$location]['table'][$course][$day] = [];
        }
        $sections[$location]['table'][$course][$day][] = $times;
    }

    foreach ($sections as &$section) {
        usort($section['days'], 'babygym_compare_week_days');
    }
    unset($section);

    return array_values($sections);
}

function babygym_compare_week_days(string $first, string $second): int
{
    $order = [
        'lunedi' => 1,
        'lunedì' => 1,
        'martedi' => 2,
        'martedì' => 2,
        'mercoledi' => 3,
        'mercoledì' => 3,
        'giovedi' => 4,
        'giovedì' => 4,
        'venerdi' => 5,
        'venerdì' => 5,
        'sabato' => 6,
        'domenica' => 7,
    ];
    $a = strtolower(trim($first));
    $b = strtolower(trim($second));
    $a_rank = $order[$a] ?? 99;
    $b_rank = $order[$b] ?? 99;
    if ($a_rank === $b_rank) {
        return strnatcasecmp($first, $second);
    }
    return $a_rank <=> $b_rank;
}

add_action('admin_init', function () {
    register_setting(
        'babygym_corsi_settings',
        'babygym_corsi_options',
        [
            'type'              => 'array',
            'sanitize_callback' => 'babygym_sanitize_corsi_options',
            'default'           => babygym_corsi_defaults(),
        ]
    );
});

add_action('admin_menu', function () {
    add_menu_page(
        'Corsi',
        'Corsi',
        'manage_options',
        'babygym-corsi',
        'babygym_render_corsi_admin_page',
        'dashicons-welcome-learn-more',
        31
    );
});

function babygym_render_corsi_admin_page(): void
{
    $options = babygym_get_corsi_options();
    $carousel_lines = preg_split('/\r\n|\r|\n/', (string) $options['carousel_images']) ?: [];
    $carousel_urls  = array_values(array_filter(array_map('trim', $carousel_lines)));
    require get_theme_file_path('inc/admin-tabs/corsi.php');
}

