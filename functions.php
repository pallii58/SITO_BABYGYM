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
        'supports' => ['title', 'editor', 'thumbnail', 'excerpt', 'revisions'],
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

/**
 * Render metabox dettagli Summer Camp.
 */
function babygym_render_summer_camp_details_metabox(\WP_Post $post): void
{
    wp_nonce_field('babygym_summer_camp_meta_save', 'babygym_summer_camp_meta_nonce');
    $locandina_url = (string) get_post_meta($post->ID, '_babygym_summer_camp_locandina_url', true);
    $gallery_raw   = (string) get_post_meta($post->ID, '_babygym_summer_camp_gallery', true);
    $descrizione   = (string) get_post_meta($post->ID, '_babygym_summer_camp_descrizione', true);
    $eta           = (string) get_post_meta($post->ID, '_babygym_summer_camp_eta', true);
    $settimane     = (string) get_post_meta($post->ID, '_babygym_summer_camp_settimane', true);
    $orario        = (string) get_post_meta($post->ID, '_babygym_summer_camp_orario', true);
    $post_orario   = (string) get_post_meta($post->ID, '_babygym_summer_camp_post_orario', true);
    $iscrizioni_entro = (string) get_post_meta($post->ID, '_babygym_summer_camp_iscrizioni_entro', true);
    $gallery_urls  = array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $gallery_raw) ?: [])));
    ?>
    <table class="form-table" role="presentation">
        <tr>
            <th scope="row"><label for="babygym-summer-camp-locandina-url"><?php esc_html_e('Locandina (immagine o PDF)', 'babygym'); ?></label></th>
            <td>
                <input type="hidden" id="babygym-summer-camp-locandina-url" name="babygym_summer_camp_locandina_url" value="<?php echo esc_attr($locandina_url); ?>">
                <p>
                    <button type="button" class="button button-primary" id="babygym-summer-camp-pick-locandina"><?php esc_html_e('Seleziona locandina', 'babygym'); ?></button>
                    <button type="button" class="button" id="babygym-summer-camp-clear-locandina"><?php esc_html_e('Rimuovi locandina', 'babygym'); ?></button>
                </p>
                <div id="babygym-summer-camp-locandina-preview" style="max-width:420px;">
                    <?php if ('' !== $locandina_url) : ?>
                        <?php if (preg_match('/\.pdf($|\?)/i', $locandina_url)) : ?>
                            <a href="<?php echo esc_url($locandina_url); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html__('Anteprima PDF locandina', 'babygym'); ?></a>
                        <?php else : ?>
                            <img src="<?php echo esc_url($locandina_url); ?>" alt="" style="display:block;width:100%;height:auto;max-height:220px;object-fit:cover;border:1px solid #dcdcde;border-radius:8px;">
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
                <p class="description"><?php esc_html_e('Seleziona un file dalla Media Library (immagine o PDF).', 'babygym'); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="babygym-summer-camp-gallery"><?php esc_html_e('Galleria', 'babygym'); ?></label></th>
            <td>
                <textarea class="large-text" rows="4" id="babygym-summer-camp-gallery" name="babygym_summer_camp_gallery" hidden><?php echo esc_textarea($gallery_raw); ?></textarea>
                <p>
                    <button type="button" class="button button-primary" id="babygym-summer-camp-pick-gallery"><?php esc_html_e('Seleziona immagini', 'babygym'); ?></button>
                    <button type="button" class="button" id="babygym-summer-camp-clear-gallery"><?php esc_html_e('Svuota galleria', 'babygym'); ?></button>
                </p>
                <div id="babygym-summer-camp-gallery-preview" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(90px,1fr));gap:8px;max-width:760px;">
                    <?php foreach ($gallery_urls as $gallery_url) : ?>
                        <img src="<?php echo esc_url($gallery_url); ?>" alt="" style="width:100%;height:90px;object-fit:cover;border:1px solid #dcdcde;border-radius:8px;">
                    <?php endforeach; ?>
                </div>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="babygym-summer-camp-eta"><?php esc_html_e('ETA\'', 'babygym'); ?></label></th>
            <td>
                <input type="text" class="regular-text" id="babygym-summer-camp-eta" name="babygym_summer_camp_eta" value="<?php echo esc_attr($eta); ?>" placeholder="3 - 7 anni">
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="babygym-summer-camp-settimane"><?php esc_html_e('SETTIMANE', 'babygym'); ?></label></th>
            <td>
                <input type="text" class="regular-text" id="babygym-summer-camp-settimane" name="babygym_summer_camp_settimane" value="<?php echo esc_attr($settimane); ?>" placeholder="dal 1 al 31 LUGLIO">
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="babygym-summer-camp-orario"><?php esc_html_e('ORARIO', 'babygym'); ?></label></th>
            <td>
                <input type="text" class="regular-text" id="babygym-summer-camp-orario" name="babygym_summer_camp_orario" value="<?php echo esc_attr($orario); ?>" placeholder="8,00 - 17.00 da LUNEDI a VENERDI">
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="babygym-summer-camp-post-orario"><?php esc_html_e('POST', 'babygym'); ?></label></th>
            <td>
                <input type="text" class="regular-text" id="babygym-summer-camp-post-orario" name="babygym_summer_camp_post_orario" value="<?php echo esc_attr($post_orario); ?>" placeholder="17.00 - 18.30 su Richiesta con supplemento">
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="babygym-summer-camp-iscrizioni-entro"><?php esc_html_e('ISCRIZIONI ENTRO', 'babygym'); ?></label></th>
            <td>
                <input type="text" class="regular-text" id="babygym-summer-camp-iscrizioni-entro" name="babygym_summer_camp_iscrizioni_entro" value="<?php echo esc_attr($iscrizioni_entro); ?>" placeholder="fine maggio">
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="babygym-summer-camp-descrizione"><?php esc_html_e('Descrizione', 'babygym'); ?></label></th>
            <td>
                <textarea class="large-text" rows="4" id="babygym-summer-camp-descrizione" name="babygym_summer_camp_descrizione"><?php echo esc_textarea($descrizione); ?></textarea>
                <p class="description"><?php esc_html_e('Descrizione breve del Summer Camp.', 'babygym'); ?></p>
            </td>
        </tr>
    </table>
    <script>
        window.addEventListener('load', function () {
            if (!window.wp || !window.wp.media) return;
            const locandinaInput = document.getElementById('babygym-summer-camp-locandina-url');
            const locandinaPreview = document.getElementById('babygym-summer-camp-locandina-preview');
            const clearLocandinaBtn = document.getElementById('babygym-summer-camp-clear-locandina');
            const galleryInput = document.getElementById('babygym-summer-camp-gallery');
            const galleryPreview = document.getElementById('babygym-summer-camp-gallery-preview');
            const pickLocandinaBtn = document.getElementById('babygym-summer-camp-pick-locandina');
            const pickGalleryBtn = document.getElementById('babygym-summer-camp-pick-gallery');
            const clearGalleryBtn = document.getElementById('babygym-summer-camp-clear-gallery');

            const renderLocandinaPreview = () => {
                if (!locandinaPreview || !locandinaInput) return;
                const url = (locandinaInput.value || '').trim();
                if (!url) {
                    locandinaPreview.innerHTML = '';
                    return;
                }
                if (/\.pdf($|\?)/i.test(url)) {
                    locandinaPreview.innerHTML = `<a href="${url}" target="_blank" rel="noopener noreferrer">Anteprima PDF locandina</a>`;
                    return;
                }
                locandinaPreview.innerHTML = `<img src="${url}" alt="" style="display:block;width:100%;height:auto;max-height:220px;object-fit:cover;border:1px solid #dcdcde;border-radius:8px;">`;
            };

            const parseGalleryUrls = () => (galleryInput?.value || '')
                .split(/\r?\n/)
                .map((line) => line.trim())
                .filter(Boolean);

            const renderGalleryPreview = () => {
                if (!galleryPreview) return;
                galleryPreview.innerHTML = '';
                parseGalleryUrls().forEach((url) => {
                    const img = document.createElement('img');
                    img.src = url;
                    img.alt = '';
                    img.style.cssText = 'width:100%;height:90px;object-fit:cover;border:1px solid #dcdcde;border-radius:8px;';
                    galleryPreview.appendChild(img);
                });
            };

            if (pickLocandinaBtn && locandinaInput) {
                pickLocandinaBtn.addEventListener('click', () => {
                    const frame = window.wp.media({
                        title: 'Seleziona locandina',
                        button: { text: 'Usa file' },
                        library: { type: ['image', 'application/pdf'] },
                        multiple: false
                    });
                    frame.on('select', () => {
                        const file = frame.state().get('selection').first().toJSON();
                        if (file?.url) {
                            locandinaInput.value = file.url;
                            renderLocandinaPreview();
                        }
                    });
                    frame.open();
                });
            }

            if (clearLocandinaBtn && locandinaInput) {
                clearLocandinaBtn.addEventListener('click', () => {
                    locandinaInput.value = '';
                    renderLocandinaPreview();
                });
            }

            if (pickGalleryBtn && galleryInput) {
                pickGalleryBtn.addEventListener('click', () => {
                    const frame = window.wp.media({
                        title: 'Seleziona immagini galleria',
                        button: { text: 'Aggiungi immagini' },
                        library: { type: 'image' },
                        multiple: true
                    });
                    frame.on('select', () => {
                        const selection = frame.state().get('selection').toJSON();
                        const existing = parseGalleryUrls();
                        selection.forEach((item) => {
                            if (item?.url && !existing.includes(item.url)) {
                                existing.push(item.url);
                            }
                        });
                        galleryInput.value = existing.join('\n');
                        renderGalleryPreview();
                    });
                    frame.open();
                });
            }

            if (clearGalleryBtn && galleryInput) {
                clearGalleryBtn.addEventListener('click', () => {
                    galleryInput.value = '';
                    renderGalleryPreview();
                });
            }

            if (galleryInput) galleryInput.addEventListener('input', renderGalleryPreview);
            renderLocandinaPreview();
            renderGalleryPreview();
        });
    </script>
    <?php
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
    $settimane_raw   = isset($_POST['babygym_summer_camp_settimane']) ? wp_unslash($_POST['babygym_summer_camp_settimane']) : '';
    $orario_raw      = isset($_POST['babygym_summer_camp_orario']) ? wp_unslash($_POST['babygym_summer_camp_orario']) : '';
    $post_orario_raw = isset($_POST['babygym_summer_camp_post_orario']) ? wp_unslash($_POST['babygym_summer_camp_post_orario']) : '';
    $iscrizioni_entro_raw = isset($_POST['babygym_summer_camp_iscrizioni_entro']) ? wp_unslash($_POST['babygym_summer_camp_iscrizioni_entro']) : '';
    $descrizione_raw = isset($_POST['babygym_summer_camp_descrizione']) ? wp_unslash($_POST['babygym_summer_camp_descrizione']) : '';

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

    update_post_meta($post_id, '_babygym_summer_camp_locandina_url', $locandina_url);
    update_post_meta($post_id, '_babygym_summer_camp_gallery', implode("\n", array_values(array_unique($gallery_urls))));
    update_post_meta($post_id, '_babygym_summer_camp_eta', sanitize_text_field((string) $eta_raw));
    update_post_meta($post_id, '_babygym_summer_camp_settimane', sanitize_text_field((string) $settimane_raw));
    update_post_meta($post_id, '_babygym_summer_camp_orario', sanitize_text_field((string) $orario_raw));
    update_post_meta($post_id, '_babygym_summer_camp_post_orario', sanitize_text_field((string) $post_orario_raw));
    update_post_meta($post_id, '_babygym_summer_camp_iscrizioni_entro', sanitize_text_field((string) $iscrizioni_entro_raw));
    update_post_meta($post_id, '_babygym_summer_camp_descrizione', sanitize_textarea_field((string) $descrizione_raw));
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
    require get_theme_file_path('inc/admin-tabs/feste.php');
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
    if (in_array($hook, ['toplevel_page_babygym-feste', 'toplevel_page_babygym-corsi'], true)) {
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

/**
 * @param array<string,string> $options
 */
function babygym_render_textarea_row(string $label, string $key, array $options, int $rows = 6): void
{
    ?>
    <tr>
        <th scope="row"><label for="<?php echo esc_attr('babygym-corsi-' . $key); ?>"><?php echo esc_html($label); ?></label></th>
        <td>
            <textarea
                class="large-text"
                rows="<?php echo esc_attr((string) $rows); ?>"
                id="<?php echo esc_attr('babygym-corsi-' . $key); ?>"
                name="<?php echo esc_attr('babygym_corsi_options[' . $key . ']'); ?>"
            ><?php echo esc_textarea($options[$key] ?? ''); ?></textarea>
        </td>
    </tr>
    <?php
}
