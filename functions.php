<?php
/**
 * BABYGYM theme setup.
 *
 * @package BABYGYM
 */

if (! defined('ABSPATH')) {
    exit;
}

add_action('after_setup_theme', function (): void {
    register_nav_menus([
        'primary' => __('Menu principale', 'babygym'),
    ]);
});

add_action('admin_post_nopriv_babygym_send_contact', 'babygym_handle_contact_form');
add_action('admin_post_babygym_send_contact', 'babygym_handle_contact_form');

/**
 * Gestione invio form contatti.
 */
function babygym_handle_contact_form(): void
{
    if (! isset($_POST['babygym_contact_nonce']) || ! wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['babygym_contact_nonce'])), 'babygym_contact_submit')) {
        wp_safe_redirect(add_query_arg('contact_status', 'invalid', wp_get_referer() ?: home_url('/contatti')));
        exit;
    }

    $email_raw   = isset($_POST['email']) ? wp_unslash($_POST['email']) : '';
    $message_raw = isset($_POST['messaggio']) ? wp_unslash($_POST['messaggio']) : '';

    $email   = sanitize_email($email_raw);
    $message = sanitize_textarea_field($message_raw);

    if ('' === $email || '' === $message || ! is_email($email)) {
        wp_safe_redirect(add_query_arg('contact_status', 'invalid', wp_get_referer() ?: home_url('/contatti')));
        exit;
    }

    $to      = 'babygym.to@gmail.com';
    $subject = 'Nuovo messaggio dal modulo Contatti - Baby Gym';
    $body    = "Email mittente: {$email}\n\nMessaggio:\n{$message}";
    $headers = [
        'Content-Type: text/plain; charset=UTF-8',
        'Reply-To: ' . $email,
        'Cc: gabrieletoma17@gmail.com',
    ];

    $sent = wp_mail($to, $subject, $body, $headers);

    wp_safe_redirect(add_query_arg('contact_status', $sent ? 'ok' : 'error', wp_get_referer() ?: home_url('/contatti')));
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
    return false;

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
 * Normalizza un orario in formato HH:MM.
 */
function babygym_sanitize_time_value(string $value, string $fallback): string
{
    $value = trim($value);
    if (preg_match('/^([01]\d|2[0-3]):([0-5]\d)$/', $value) === 1) {
        return $value;
    }
    if (preg_match('/^([01]\d|2[0-3])\.([0-5]\d)$/', $value) === 1) {
        return str_replace('.', ':', $value);
    }

    return $fallback;
}

/**
 * Formatta un orario da HH:MM a HH.MM per il frontend.
 */
function babygym_time_to_label(string $value): string
{
    return str_replace(':', '.', $value);
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
    $options['extra_child_price'] = sprintf('+ EUR %d per partecipante', $extra_child_fee);
    $options['offsite_transport'] = sprintf('+ EUR %d trasporto', $offsite_fee);
    $options['no_equipment_price'] = sprintf('costo fisso EUR %d', $no_equipment_fee);

    return $options;
}

/**
 * Sanitizzazione opzioni feste.
 *
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
    ?>
    <div class="wrap">
        <h1>Impostazioni Feste</h1>
        <form method="post" action="options.php">
            <?php settings_fields('babygym_feste_settings'); ?>

            <h2>Carosello foto</h2>
            <p>Carica immagini solo da Media Library.</p>
            <input type="hidden" name="babygym_feste_options[carousel_images]" id="babygym-carousel-images" value="<?php echo esc_attr($options['carousel_images']); ?>">
            <p>
                <button type="button" class="button" id="babygym-add-carousel-image">Aggiungi da Media Library</button>
                <button type="button" class="button" id="babygym-clear-carousel-image">Svuota elenco</button>
            </p>
            <div id="babygym-carousel-grid" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(120px,1fr));gap:10px;max-width:860px;margin-bottom:1rem;">
                <?php foreach ($carousel_urls as $url) : ?>
                    <div style="position:relative;border:1px solid #d0d7de;border-radius:8px;padding:4px;background:#fff;">
                        <img src="<?php echo esc_url($url); ?>" alt="" style="display:block;width:100%;height:90px;object-fit:cover;border-radius:6px;">
                    </div>
                <?php endforeach; ?>
            </div>

            <h2>Orari</h2>
            <p>Aggiungi liberamente nuovi giorni e nuove fasce orarie: la pagina pubblica si aggiorna in automatico.</p>
            <input type="hidden" name="babygym_feste_options[schedule_rows]" id="babygym-schedule-rows" value="<?php echo esc_attr($options['schedule_rows'] ?? ''); ?>">
            <table class="widefat striped" style="max-width:980px;margin:0 0 1rem;">
                <thead>
                    <tr>
                        <th>Giorno</th>
                        <th>Da</th>
                        <th>A</th>
                        <th>Nota opzionale</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="babygym-schedule-body"></tbody>
            </table>
            <p>
                <button type="button" class="button button-secondary" id="babygym-add-schedule-row">Aggiungi fascia oraria</button>
            </p>
            <hr>
            <h3>Slot in settimana</h3>
            <table class="form-table" role="presentation">
                <?php babygym_render_time_range_row('Slot in settimana', 'weekday_slot_start', 'weekday_slot_end', $options); ?>
                <?php babygym_render_setting_row('Giorni in settimana (testo)', 'weekday_days', $options); ?>
            </table>

            <h2>Prezzi</h2>
            <p>Inserisci solo importi numerici: i testi prezzo vengono composti in automatico.</p>
            <table class="form-table" role="presentation">
                <?php babygym_render_number_row('Bimbi inclusi', 'included_children', $options, 1); ?>
                <?php babygym_render_number_row('Quota festa non iscritti (EUR)', 'non_members_party_price', $options, 0); ?>
                <?php babygym_render_number_row('Quota festa iscritti (EUR)', 'members_party_price', $options, 0); ?>
                <?php babygym_render_number_row('Quota iscrizione/assicurazione (EUR)', 'insurance_fee', $options, 0); ?>
                <?php babygym_render_setting_row('Nota iscritti', 'members_note', $options); ?>
                <?php babygym_render_number_row('Supplemento dal 16° bimbo (EUR)', 'extra_child_fee', $options, 0); ?>
                <?php babygym_render_number_row('Fuori Torino - trasporto (EUR)', 'offsite_transport_fee', $options, 0); ?>
                <?php babygym_render_number_row('Formula senza attrezzature (EUR)', 'no_equipment_fixed_fee', $options, 0); ?>
            </table>

            <h2>Anteprima testo pubblico</h2>
            <table class="form-table" role="presentation">
                <tr>
                    <th scope="row">Prezzo non iscritti</th>
                    <td><code><?php echo esc_html($options['non_members_price']); ?></code></td>
                </tr>
                <tr>
                    <th scope="row">Nota non iscritti</th>
                    <td><code><?php echo esc_html($options['non_members_note']); ?></code></td>
                </tr>
                <tr>
                    <th scope="row">Prezzo iscritti</th>
                    <td><code><?php echo esc_html($options['members_price']); ?></code></td>
                </tr>
                <tr>
                    <th scope="row">Supplemento</th>
                    <td><code><?php echo esc_html($options['extra_child_price']); ?></code></td>
                </tr>
            </table>

            <?php submit_button('Salva impostazioni Feste'); ?>
        </form>
    </div>
    <script>
        window.addEventListener('load', function () {
            const btn = document.getElementById('babygym-add-carousel-image');
            const clearBtn = document.getElementById('babygym-clear-carousel-image');
            const hiddenInput = document.getElementById('babygym-carousel-images');
            const grid = document.getElementById('babygym-carousel-grid');
            const scheduleHidden = document.getElementById('babygym-schedule-rows');
            const scheduleBody = document.getElementById('babygym-schedule-body');
            const addScheduleBtn = document.getElementById('babygym-add-schedule-row');
            if (!btn || !hiddenInput || !grid) {
                return;
            }

            const parseUrls = () =>
                hiddenInput.value
                    .split(/\r?\n/)
                    .map((line) => line.trim())
                    .filter(Boolean);

            const renderGrid = () => {
                const urls = parseUrls();
                grid.innerHTML = '';
                urls.forEach((url, index) => {
                    const item = document.createElement('div');
                    item.style.cssText = 'position:relative;border:1px solid #d0d7de;border-radius:8px;padding:4px;background:#fff;';

                    const img = document.createElement('img');
                    img.src = url;
                    img.alt = '';
                    img.style.cssText = 'display:block;width:100%;height:90px;object-fit:cover;border-radius:6px;';
                    item.appendChild(img);

                    const remove = document.createElement('button');
                    remove.type = 'button';
                    remove.textContent = '×';
                    remove.setAttribute('aria-label', 'Rimuovi foto');
                    remove.style.cssText = 'position:absolute;top:6px;right:6px;width:22px;height:22px;border:0;border-radius:999px;background:#dc2626;color:#fff;cursor:pointer;font-weight:700;line-height:1;';
                    remove.addEventListener('click', () => {
                        const current = parseUrls();
                        current.splice(index, 1);
                        hiddenInput.value = current.join('\n');
                        renderGrid();
                    });
                    item.appendChild(remove);
                    grid.appendChild(item);
                });
            };

            const openMediaLibrary = () => {
                if (!window.wp || !window.wp.media) {
                    alert('Media Library non disponibile. Ricarica la pagina admin.');
                    return;
                }

                const frame = window.wp.media({
                    title: 'Seleziona foto per carosello',
                    button: { text: 'Usa queste foto' },
                    library: { type: 'image' },
                    multiple: true
                });

                frame.on('select', () => {
                    const selection = frame.state().get('selection').toJSON();
                    const existing = parseUrls();
                    selection.forEach((media) => {
                        if (media.url && !existing.includes(media.url)) {
                            existing.push(media.url);
                        }
                    });
                    hiddenInput.value = existing.join('\n');
                    renderGrid();
                });

                frame.open();
            };

            btn.addEventListener('click', openMediaLibrary);
            if (clearBtn) {
                clearBtn.addEventListener('click', () => {
                    hiddenInput.value = '';
                    renderGrid();
                });
            }
            renderGrid();

            const parseScheduleRows = () => {
                if (!scheduleHidden) return [];
                return scheduleHidden.value
                    .split(/\r?\n/)
                    .map((line) => line.trim())
                    .filter(Boolean)
                    .map((line) => {
                        const parts = line.split('|');
                        return {
                            day: (parts[0] || '').trim(),
                            label: (parts[1] || '').trim(),
                            start: (parts[2] || '').trim(),
                            end: (parts[3] || '').trim(),
                            note: (parts[4] || '').trim(),
                        };
                    });
            };

            const syncScheduleHidden = () => {
                if (!scheduleHidden || !scheduleBody) return;
                const rows = Array.from(scheduleBody.querySelectorAll('tr'));
                const serialized = rows
                    .map((row) => {
                        const getValue = (name) => {
                            const input = row.querySelector(`[data-field="${name}"]`);
                            return input ? input.value.trim() : '';
                        };
                        const day = getValue('day');
                        const label = 'Fascia';
                        const start = getValue('start');
                        const end = getValue('end');
                        const note = getValue('note');
                        if (!day || !label || !start || !end) return '';
                        return [day, label, start, end, note].join('|');
                    })
                    .filter(Boolean);
                scheduleHidden.value = serialized.join('\n');
            };

            const addScheduleRow = (rowData = { day: '', label: '', start: '', end: '', note: '' }) => {
                if (!scheduleBody) return;
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td><input type="text" class="regular-text" data-field="day" value="${rowData.day.replace(/"/g, '&quot;')}" placeholder="Es. Sabato"></td>
                    <td><input type="time" data-field="start" value="${rowData.start.replace(/"/g, '&quot;')}"></td>
                    <td><input type="time" data-field="end" value="${rowData.end.replace(/"/g, '&quot;')}"></td>
                    <td><input type="text" class="regular-text" data-field="note" value="${rowData.note.replace(/"/g, '&quot;')}" placeholder="Opzionale"></td>
                    <td><button type="button" class="button-link-delete" data-action="remove">Rimuovi</button></td>
                `;
                tr.addEventListener('input', syncScheduleHidden);
                const removeBtn = tr.querySelector('[data-action="remove"]');
                if (removeBtn) {
                    removeBtn.addEventListener('click', () => {
                        tr.remove();
                        syncScheduleHidden();
                    });
                }
                scheduleBody.appendChild(tr);
                syncScheduleHidden();
            };

            if (scheduleHidden && scheduleBody) {
                const initialRows = parseScheduleRows();
                if (initialRows.length === 0) {
                    addScheduleRow();
                } else {
                    initialRows.forEach(addScheduleRow);
                }
            }
            if (addScheduleBtn) {
                addScheduleBtn.addEventListener('click', () => addScheduleRow());
            }
        });
    </script>
    <?php
}

/**
 * Stampa una riga impostazione.
 *
 * @param string               $label
 * @param string               $key
 * @param array<string,string> $options
 */
function babygym_render_setting_row(string $label, string $key, array $options): void
{
    ?>
    <tr>
        <th scope="row"><label for="<?php echo esc_attr('babygym-feste-' . $key); ?>"><?php echo esc_html($label); ?></label></th>
        <td>
            <input
                type="text"
                class="regular-text"
                id="<?php echo esc_attr('babygym-feste-' . $key); ?>"
                name="<?php echo esc_attr('babygym_feste_options[' . $key . ']'); ?>"
                value="<?php echo esc_attr($options[$key] ?? ''); ?>"
            >
        </td>
    </tr>
    <?php
}

/**
 * Stampa una riga impostazione numerica.
 *
 * @param string               $label
 * @param string               $key
 * @param array<string,string> $options
 * @param int                  $min
 */
function babygym_render_number_row(string $label, string $key, array $options, int $min = 0): void
{
    ?>
    <tr>
        <th scope="row"><label for="<?php echo esc_attr('babygym-feste-' . $key); ?>"><?php echo esc_html($label); ?></label></th>
        <td>
            <input
                type="number"
                min="<?php echo esc_attr((string) $min); ?>"
                step="1"
                class="small-text"
                id="<?php echo esc_attr('babygym-feste-' . $key); ?>"
                name="<?php echo esc_attr('babygym_feste_options[' . $key . ']'); ?>"
                value="<?php echo esc_attr($options[$key] ?? ''); ?>"
            >
        </td>
    </tr>
    <?php
}

/**
 * Stampa una riga impostazione per fascia oraria.
 *
 * @param array<string,string> $options
 */
function babygym_render_time_range_row(string $label, string $start_key, string $end_key, array $options): void
{
    ?>
    <tr>
        <th scope="row"><?php echo esc_html($label); ?></th>
        <td>
            <label for="<?php echo esc_attr('babygym-feste-' . $start_key); ?>" class="screen-reader-text"><?php echo esc_html($label . ' - da'); ?></label>
            <input
                type="time"
                id="<?php echo esc_attr('babygym-feste-' . $start_key); ?>"
                name="<?php echo esc_attr('babygym_feste_options[' . $start_key . ']'); ?>"
                value="<?php echo esc_attr($options[$start_key] ?? ''); ?>"
            >
            <span style="padding:0 .5rem;">-</span>
            <label for="<?php echo esc_attr('babygym-feste-' . $end_key); ?>" class="screen-reader-text"><?php echo esc_html($label . ' - a'); ?></label>
            <input
                type="time"
                id="<?php echo esc_attr('babygym-feste-' . $end_key); ?>"
                name="<?php echo esc_attr('babygym_feste_options[' . $end_key . ']'); ?>"
                value="<?php echo esc_attr($options[$end_key] ?? ''); ?>"
            >
        </td>
    </tr>
    <?php
}

add_action('admin_enqueue_scripts', function ($hook): void {
    if ('toplevel_page_babygym-feste' !== $hook) {
        return;
    }
    wp_enqueue_media();
});
