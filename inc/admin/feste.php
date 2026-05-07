<?php
/**
 * Admin: pagina impostazioni "Feste".
 *
 * @package BABYGYM
 */

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Default opzioni pagina "Le Feste".
 *
 * @return array<string, string>
 */
function babygym_feste_defaults(): array
{
    return [
        'carousel_images'       => '',
        'schedule_rows'         => "Venerdi|Sera|19:00|21:30|\nSabato|Pomeriggio|15:30|18:00|\nSabato|Sera|19:00|21:30|(anche pigiama party)\nDomenica|Mattina|10:00|12:30|\nDomenica|Pomeriggio|17:00|19:30|",
        'friday_evening_start'  => '19:00',
        'friday_evening_end'    => '21:30',
        'saturday_afternoon_start' => '15:30',
        'saturday_afternoon_end'   => '18:00',
        'saturday_evening_start'   => '19:00',
        'saturday_evening_end'     => '21:30',
        'saturday_evening_note' => '(anche pigiama party)',
        'sunday_morning_start'  => '10:00',
        'sunday_morning_end'    => '12:30',
        'sunday_afternoon_start' => '17:00',
        'sunday_afternoon_end'   => '19:30',
        'weekday_slot_start'    => '13:00',
        'weekday_slot_end'      => '15:30',
        'weekday_days'          => 'lunedi, martedi, mercoledi e venerdi',
        'included_children'     => '15',
        'non_members_party_price' => '295',
        'members_party_price'   => '295',
        'insurance_fee'         => '20',
        'members_note'          => '(quota associativa in corso di validita)',
        'extra_child_fee'       => '5',
        'offsite_transport_fee' => '10',
        'no_equipment_fixed_fee' => '250',
        // Campi testuali legacy (ora calcolati automaticamente).
        'friday_evening'        => '',
        'saturday_afternoon'    => '',
        'saturday_evening'      => '',
        'sunday_morning'        => '',
        'sunday_afternoon'      => '',
        'weekday_note'          => '',
        'non_members_price'     => '',
        'non_members_note'      => '',
        'members_price'         => '',
        'extra_child_price'     => '',
        'offsite_transport'     => '',
        'no_equipment_price'    => '',
    ];
}

/**
 * Restituisce opzioni feste con fallback default.
 *
 * @return array<string, string>
 */
function babygym_get_feste_options(): array
{
    $defaults = babygym_feste_defaults();
    $saved    = get_option('babygym_feste_options', []);

    if (! is_array($saved)) {
        return $defaults;
    }

    $options = array_merge($defaults, array_intersect_key($saved, $defaults));

    return babygym_build_feste_derived_fields($options);
}

/**
 * Parsing righe orari in formato: Giorno|Etichetta|HH:MM|HH:MM|Nota opzionale.
 *
 * @return array<int, array{day:string,label:string,start:string,end:string,note:string}>
 */
function babygym_parse_schedule_rows(string $raw): array
{
    $lines = preg_split('/\r\n|\r|\n/', $raw) ?: [];
    $rows  = [];
    foreach ($lines as $line) {
        $line = trim($line);
        if ('' === $line) {
            continue;
        }
        $parts = array_map('trim', explode('|', $line));
        if (count($parts) < 4) {
            continue;
        }
        $day   = sanitize_text_field($parts[0]);
        $label = sanitize_text_field($parts[1]);
        $start = babygym_sanitize_time_value($parts[2], '');
        $end   = babygym_sanitize_time_value($parts[3], '');
        $note  = isset($parts[4]) ? sanitize_text_field($parts[4]) : '';
        if ('' === $day || '' === $label || '' === $start || '' === $end) {
            continue;
        }
        $rows[] = [
            'day' => $day,
            'label' => $label,
            'start' => $start,
            'end' => $end,
            'note' => $note,
        ];
    }
    return $rows;
}

/**
 * Serializza righe orari.
 *
 * @param array<int, array{day:string,label:string,start:string,end:string,note:string}> $rows
 */
function babygym_serialize_schedule_rows(array $rows): string
{
    $lines = [];
    foreach ($rows as $row) {
        $lines[] = implode('|', [
            trim($row['day']),
            trim($row['label']),
            trim($row['start']),
            trim($row['end']),
            trim($row['note']),
        ]);
    }
    return implode("\n", $lines);
}

/**
 * Restituisce orari raggruppati per giorno.
 *
 * @param array<string,string> $options
 * @return array<string, array<int, array{label:string,time:string,note:string}>>
 */
function babygym_get_feste_schedule_groups(array $options): array
{
    $rows = babygym_parse_schedule_rows((string) ($options['schedule_rows'] ?? ''));
    $groups = [];
    foreach ($rows as $row) {
        $day = $row['day'];
        if (! isset($groups[$day])) {
            $groups[$day] = [];
        }
        $groups[$day][] = [
            'label' => $row['label'],
            'time' => babygym_time_to_label($row['start']) . ' - ' . babygym_time_to_label($row['end']),
            'note' => $row['note'],
        ];
    }
    return $groups;
}

/**
 * Crea i testi frontend partendo dai campi strutturati.
 *
 * @param array<string, string> $options
 * @return array<string, string>
 */
function babygym_build_feste_derived_fields(array $options): array
{
    $included_children = max(1, (int) ($options['included_children'] ?? 15));
    $non_members_party = max(0, (int) ($options['non_members_party_price'] ?? 295));
    $members_party     = max(0, (int) ($options['members_party_price'] ?? 295));
    $insurance_fee     = max(0, (int) ($options['insurance_fee'] ?? 20));
    $extra_child_fee   = max(0, (int) ($options['extra_child_fee'] ?? 5));
    $offsite_fee       = max(0, (int) ($options['offsite_transport_fee'] ?? 10));
    $no_equipment_fee  = max(0, (int) ($options['no_equipment_fixed_fee'] ?? 250));

    $non_members_total = $non_members_party + $insurance_fee;
    $members_total     = $members_party;

    $schedule_rows = babygym_parse_schedule_rows((string) ($options['schedule_rows'] ?? ''));
    if ([] === $schedule_rows) {
        $schedule_rows = [
            ['day' => 'Venerdi', 'label' => 'Sera', 'start' => $options['friday_evening_start'], 'end' => $options['friday_evening_end'], 'note' => ''],
            ['day' => 'Sabato', 'label' => 'Pomeriggio', 'start' => $options['saturday_afternoon_start'], 'end' => $options['saturday_afternoon_end'], 'note' => ''],
            ['day' => 'Sabato', 'label' => 'Sera', 'start' => $options['saturday_evening_start'], 'end' => $options['saturday_evening_end'], 'note' => $options['saturday_evening_note']],
            ['day' => 'Domenica', 'label' => 'Mattina', 'start' => $options['sunday_morning_start'], 'end' => $options['sunday_morning_end'], 'note' => ''],
            ['day' => 'Domenica', 'label' => 'Pomeriggio', 'start' => $options['sunday_afternoon_start'], 'end' => $options['sunday_afternoon_end'], 'note' => ''],
        ];
    }
    $options['schedule_rows'] = babygym_serialize_schedule_rows($schedule_rows);

    // Legacy campi calcolati per retrocompatibilita.
    $options['friday_evening'] = sprintf('Sera: %s - %s', babygym_time_to_label($options['friday_evening_start']), babygym_time_to_label($options['friday_evening_end']));
    $options['saturday_afternoon'] = sprintf('Pomeriggio: %s - %s', babygym_time_to_label($options['saturday_afternoon_start']), babygym_time_to_label($options['saturday_afternoon_end']));
    $options['saturday_evening'] = sprintf('Sera: %s - %s', babygym_time_to_label($options['saturday_evening_start']), babygym_time_to_label($options['saturday_evening_end']));
    $options['sunday_morning'] = sprintf('Mattina: %s - %s', babygym_time_to_label($options['sunday_morning_start']), babygym_time_to_label($options['sunday_morning_end']));
    $options['sunday_afternoon'] = sprintf('Pomeriggio: %s - %s', babygym_time_to_label($options['sunday_afternoon_start']), babygym_time_to_label($options['sunday_afternoon_end']));
    $options['weekday_note'] = sprintf(
        'In settimana sono disponibili slot %s - %s per bambini che non hanno il pomeriggio scolastico (%s).',
        babygym_time_to_label($options['weekday_slot_start']),
        babygym_time_to_label($options['weekday_slot_end']),
        trim($options['weekday_days'])
    );
    $options['non_members_price'] = sprintf('Fino a %d bimbi: EUR %d', $included_children, $non_members_total);
    $options['non_members_note'] = sprintf(
        '(EUR %d + EUR %d quota di iscrizione, stornata solo in caso di successiva iscrizione ai corsi)',
        $non_members_party,
        $insurance_fee
    );
    $options['members_price'] = sprintf('Fino a %d bimbi: EUR %d', $included_children, $members_total);
    $options['extra_child_price'] = sprintf('+ EUR %d per ogni bimbo in piu', $extra_child_fee);
    $options['offsite_transport'] = sprintf('Trasporto verso parchi (Lancia e Ruffini): + EUR %d', $offsite_fee);
    $options['no_equipment_price'] = sprintf('Senza utilizzo attrezzature: EUR %d', $no_equipment_fee);

    return $options;
}

/**
 * @param mixed $input
 * @return array<string, string>
 */
function babygym_sanitize_feste_options($input): array
{
    $defaults  = babygym_feste_defaults();
    $sanitized = [];

    foreach ($defaults as $key => $default_value) {
        $value = isset($input[$key]) ? $input[$key] : $default_value;
        if (! is_string($value)) {
            $value = (string) $value;
        }

        if ('carousel_images' === $key) {
            $lines     = preg_split('/\r\n|\r|\n/', $value) ?: [];
            $clean_url = [];

            foreach ($lines as $line) {
                $line = trim($line);
                if ('' === $line) {
                    continue;
                }
                $url = esc_url_raw($line);
                if ('' !== $url) {
                    $clean_url[] = $url;
                }
            }

            $sanitized[$key] = implode("\n", array_unique($clean_url));
            continue;
        }
        if ('schedule_rows' === $key) {
            $rows = babygym_parse_schedule_rows($value);
            $sanitized[$key] = babygym_serialize_schedule_rows($rows);
            continue;
        }
        if (in_array($key, [
            'friday_evening_start',
            'friday_evening_end',
            'saturday_afternoon_start',
            'saturday_afternoon_end',
            'saturday_evening_start',
            'saturday_evening_end',
            'sunday_morning_start',
            'sunday_morning_end',
            'sunday_afternoon_start',
            'sunday_afternoon_end',
            'weekday_slot_start',
            'weekday_slot_end',
        ], true)) {
            $sanitized[$key] = babygym_sanitize_time_value($value, $default_value);
            continue;
        }
        if (in_array($key, [
            'included_children',
            'non_members_party_price',
            'members_party_price',
            'insurance_fee',
            'extra_child_fee',
            'offsite_transport_fee',
            'no_equipment_fixed_fee',
        ], true)) {
            $sanitized[$key] = (string) max(0, (int) $value);
            continue;
        }
        if ('weekday_days' === $key) {
            $sanitized[$key] = sanitize_text_field($value);
            continue;
        }
        if ('members_note' === $key || 'saturday_evening_note' === $key) {
            $sanitized[$key] = sanitize_text_field($value);
            continue;
        }
        $sanitized[$key] = sanitize_text_field($default_value);
    }

    return babygym_build_feste_derived_fields($sanitized);
}

add_action('admin_init', function () {
    register_setting(
        'babygym_feste_settings',
        'babygym_feste_options',
        [
            'type'              => 'array',
            'sanitize_callback' => 'babygym_sanitize_feste_options',
            'default'           => babygym_feste_defaults(),
        ]
    );
});

add_action('admin_menu', function () {
    add_menu_page(
        'Feste',
        'Feste',
        'manage_options',
        'babygym-feste',
        'babygym_render_feste_admin_page',
        'dashicons-format-gallery',
        30
    );
});

/**
 * Render admin tab Feste.
 */
function babygym_render_feste_admin_page(): void
{
    $options        = babygym_get_feste_options();
    $carousel_lines = preg_split('/\r\n|\r|\n/', (string) $options['carousel_images']) ?: [];
    $carousel_urls  = array_values(array_filter(array_map('trim', $carousel_lines)));
    require get_theme_file_path('inc/admin-tabs/feste.php');
}

