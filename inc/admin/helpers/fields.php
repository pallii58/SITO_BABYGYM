<?php
/**
 * Admin helpers: settings fields render.
 *
 * @package BABYGYM
 */

if (! defined('ABSPATH')) {
    exit;
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

