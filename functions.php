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
        'friday_evening'        => 'Sera: 19.00 - 21.30',
        'saturday_afternoon'    => 'Pomeriggio: 15.30 - 18.00',
        'saturday_evening'      => 'Sera: 19.00 - 21.30',
        'saturday_evening_note' => '(anche pigiama party)',
        'sunday_morning'        => 'Mattina: 10.00 - 12.30',
        'sunday_afternoon'      => 'Pomeriggio: 17.00 - 19.30',
        'weekday_note'          => 'In settimana sono disponibili slot 13.00 - 15.30 per bambini che non hanno il pomeriggio scolastico (lunedi, martedi, mercoledi e venerdi).',
        'non_members_price'     => 'Fino a 15 bimbi: EUR 310',
        'non_members_note'      => '(EUR 290 + EUR 20 quota di iscrizione, stornata solo in caso di successiva iscrizione ai corsi)',
        'members_price'         => 'Fino a 15 bimbi: EUR 290',
        'members_note'          => '(quota associativa in corso di validita)',
        'extra_child_price'     => '+ EUR 5 per partecipante',
        'offsite_transport'     => '+ EUR 10 trasporto',
        'no_equipment_price'    => 'costo fisso EUR 250',
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

    return array_merge($defaults, array_intersect_key($saved, $defaults));
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

        $sanitized[$key] = sanitize_text_field($value);
    }

    return $sanitized;
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
    $options = babygym_get_feste_options();
    ?>
    <div class="wrap">
        <h1>Impostazioni Feste</h1>
        <form method="post" action="options.php">
            <?php settings_fields('babygym_feste_settings'); ?>

            <h2>Carosello foto</h2>
            <p>Carica immagini solo da Media Library. Il campo sottostante e in sola lettura.</p>
            <textarea name="babygym_feste_options[carousel_images]" id="babygym-carousel-images" rows="8" class="large-text code" readonly><?php echo esc_textarea($options['carousel_images']); ?></textarea>
            <p>
                <button type="button" class="button" id="babygym-add-carousel-image">Aggiungi da Media Library</button>
                <button type="button" class="button" id="babygym-clear-carousel-image">Svuota elenco</button>
            </p>

            <h2>Orari</h2>
            <table class="form-table" role="presentation">
                <?php babygym_render_setting_row('Venerdi sera', 'friday_evening', $options); ?>
                <?php babygym_render_setting_row('Sabato pomeriggio', 'saturday_afternoon', $options); ?>
                <?php babygym_render_setting_row('Sabato sera', 'saturday_evening', $options); ?>
                <?php babygym_render_setting_row('Nota sabato sera', 'saturday_evening_note', $options); ?>
                <?php babygym_render_setting_row('Domenica mattina', 'sunday_morning', $options); ?>
                <?php babygym_render_setting_row('Domenica pomeriggio', 'sunday_afternoon', $options); ?>
                <?php babygym_render_setting_row('Nota in settimana', 'weekday_note', $options); ?>
            </table>

            <h2>Prezzi</h2>
            <table class="form-table" role="presentation">
                <?php babygym_render_setting_row('Prezzo non iscritti', 'non_members_price', $options); ?>
                <?php babygym_render_setting_row('Nota non iscritti', 'non_members_note', $options); ?>
                <?php babygym_render_setting_row('Prezzo iscritti', 'members_price', $options); ?>
                <?php babygym_render_setting_row('Nota iscritti', 'members_note', $options); ?>
                <?php babygym_render_setting_row('Supplemento dal 16° bimbo', 'extra_child_price', $options); ?>
                <?php babygym_render_setting_row('Fuori Torino', 'offsite_transport', $options); ?>
                <?php babygym_render_setting_row('Formula senza attrezzature', 'no_equipment_price', $options); ?>
            </table>

            <?php submit_button('Salva impostazioni Feste'); ?>
        </form>
    </div>
    <script>
        (function () {
            const btn = document.getElementById('babygym-add-carousel-image');
            const clearBtn = document.getElementById('babygym-clear-carousel-image');
            const textarea = document.getElementById('babygym-carousel-images');
            if (!btn || !textarea || !window.wp || !window.wp.media) {
                return;
            }

            btn.addEventListener('click', function () {
                const frame = window.wp.media({
                    title: 'Seleziona foto per carosello',
                    button: { text: 'Usa questa foto' },
                    multiple: true
                });

                frame.on('select', function () {
                    const selection = frame.state().get('selection').toJSON();
                    const existing = textarea.value
                        .split(/\r?\n/)
                        .map((line) => line.trim())
                        .filter(Boolean);
                    selection.forEach((media) => {
                        if (media.url && !existing.includes(media.url)) {
                            existing.push(media.url);
                        }
                    });
                    textarea.value = existing.join("\n");
                });

                frame.open();
            });

            if (clearBtn) {
                clearBtn.addEventListener('click', function () {
                    textarea.value = '';
                });
            }
        })();
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

add_action('admin_enqueue_scripts', function ($hook): void {
    if ('toplevel_page_babygym-feste' !== $hook) {
        return;
    }
    wp_enqueue_media();
});
