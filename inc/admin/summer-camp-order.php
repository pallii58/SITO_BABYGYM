<?php
/**
 * Admin: ordinamento drag & drop per CPT Summer Camp.
 *
 * @package BABYGYM
 */

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Forza l'ordinamento di default per menu_order nella lista admin dei Summer Camp.
 */
add_action('pre_get_posts', function (\WP_Query $query): void {
    if (! is_admin()) {
        return;
    }

    $screen = function_exists('get_current_screen') ? get_current_screen() : null;
    if (! $screen || 'edit-summer_camp' !== $screen->id) {
        return;
    }

    if (! $query->is_main_query()) {
        return;
    }

    if ('summer_camp' !== $query->get('post_type')) {
        return;
    }

    // Se l'utente ha scelto un ordinamento per colonna, non forziamo nulla.
    if (! empty($_GET['orderby'])) {
        return;
    }

    $query->set('orderby', 'menu_order title');
    $query->set('order', 'ASC');
});

/**
 * Aggiunge una colonna "Ordine" (con maniglia drag) nella lista admin dei Summer Camp.
 *
 * @param array<string,string> $columns
 * @return array<string,string>
 */
add_filter('manage_summer_camp_posts_columns', function (array $columns): array {
    $new = [
        'babygym_order_handle' => '<span class="screen-reader-text">' . esc_html__('Ordine', 'babygym') . '</span>',
    ];
    return array_merge($new, $columns);
});

add_action('manage_summer_camp_posts_custom_column', function (string $column, int $post_id): void {
    if ('babygym_order_handle' !== $column) {
        return;
    }
    echo '<span class="babygym-sc-drag-handle" title="' . esc_attr__('Trascina per riordinare', 'babygym') . '" aria-hidden="true">&#x2630;</span>';
}, 10, 2);

/**
 * Enqueue script e stili per il drag & drop nella lista admin Summer Camp.
 */
add_action('admin_enqueue_scripts', function (string $hook): void {
    if ('edit.php' !== $hook) {
        return;
    }

    $screen = get_current_screen();
    if (! $screen || 'edit-summer_camp' !== $screen->id) {
        return;
    }

    wp_enqueue_script('jquery-ui-sortable');

    $inline_css = <<<CSS
        .wp-list-table .column-babygym_order_handle { width: 36px; text-align: center; }
        .wp-list-table .babygym-sc-drag-handle {
            display: inline-block; cursor: move; cursor: grab;
            color: #8c8f94; font-size: 18px; line-height: 1;
            user-select: none; padding: 4px 6px;
        }
        .wp-list-table tr:hover .babygym-sc-drag-handle { color: #2271b1; }
        .wp-list-table tr.babygym-sc-sorting { background: #fff8e5 !important; }
        .wp-list-table tr.ui-sortable-helper { box-shadow: 0 2px 8px rgba(0,0,0,0.15); }
        .wp-list-table tr.ui-sortable-placeholder { visibility: visible !important; background: #f0f6fc !important; height: 48px; }
        .wp-list-table tr.ui-sortable-placeholder td { background: transparent !important; border: 1px dashed #2271b1; }
        .babygym-sc-saving #the-list { opacity: 0.6; pointer-events: none; }
CSS;
    wp_add_inline_style('common', $inline_css);

    $script = <<<'JS'
    (function ($) {
        $(function () {
            var $list = $('table.wp-list-table tbody#the-list');
            if (! $list.length) { return; }

            // Riordino disponibile solo quando la lista è ordinata per
            // menu_order (cioè senza un orderby scelto dall'utente).
            var params = new URLSearchParams(window.location.search);
            if (params.has('orderby')) {
                $list.find('.babygym-sc-drag-handle')
                    .css({ opacity: 0.3, cursor: 'not-allowed' })
                    .attr('title', babygymSCReorder.i18nDisabled || '');
                return;
            }

            $list.sortable({
                items: '> tr',
                handle: '.babygym-sc-drag-handle',
                axis: 'y',
                cursor: 'grabbing',
                placeholder: 'ui-sortable-placeholder',
                helper: function (e, tr) {
                    var $originals = tr.children();
                    var $helper = tr.clone();
                    $helper.children().each(function (i) {
                        $(this).width($originals.eq(i).width());
                    });
                    return $helper;
                },
                start: function (e, ui) { ui.item.addClass('babygym-sc-sorting'); },
                stop: function (e, ui) { ui.item.removeClass('babygym-sc-sorting'); },
                update: function () {
                    var ids = $list.find('> tr').map(function () {
                        var id = $(this).attr('id') || '';
                        var m = id.match(/^post-(\d+)$/);
                        return m ? parseInt(m[1], 10) : null;
                    }).get().filter(function (v) { return !!v; });

                    if (! ids.length) { return; }

                    $('body').addClass('babygym-sc-saving');
                    $.post(babygymSCReorder.ajax_url, {
                        action: babygymSCReorder.action,
                        _ajax_nonce: babygymSCReorder.nonce,
                        order: ids
                    }).always(function () {
                        $('body').removeClass('babygym-sc-saving');
                    }).fail(function () {
                        window.alert(babygymSCReorder.i18nError || 'Errore nel salvataggio dell\'ordine.');
                    });
                }
            }).disableSelection();
        });
    })(jQuery);
JS;

    wp_register_script('babygym-summer-camp-reorder', '', ['jquery', 'jquery-ui-sortable'], null, true);
    wp_localize_script('babygym-summer-camp-reorder', 'babygymSCReorder', [
        'ajax_url'     => admin_url('admin-ajax.php'),
        'nonce'        => wp_create_nonce('babygym_summer_camp_reorder'),
        'action'       => 'babygym_summer_camp_reorder',
        'i18nError'    => __('Errore nel salvataggio dell\'ordine.', 'babygym'),
        'i18nDisabled' => __('Per riordinare rimuovi l\'ordinamento per colonna.', 'babygym'),
    ]);
    wp_enqueue_script('babygym-summer-camp-reorder');
    wp_add_inline_script('babygym-summer-camp-reorder', $script);
});

/**
 * Endpoint AJAX: salva il nuovo menu_order dei Summer Camp.
 */
add_action('wp_ajax_babygym_summer_camp_reorder', function (): void {
    check_ajax_referer('babygym_summer_camp_reorder');

    if (! current_user_can('edit_posts')) {
        wp_send_json_error(['message' => __('Permessi insufficienti.', 'babygym')], 403);
    }

    $order = isset($_POST['order']) && is_array($_POST['order']) ? wp_unslash($_POST['order']) : [];
    $ids   = array_values(array_filter(array_map('absint', $order)));

    if (empty($ids)) {
        wp_send_json_error(['message' => __('Ordine non valido.', 'babygym')], 400);
    }

    $position = 1;
    foreach ($ids as $post_id) {
        $post = get_post($post_id);
        if (! $post || 'summer_camp' !== $post->post_type) {
            continue;
        }
        if (! current_user_can('edit_post', $post_id)) {
            continue;
        }
        wp_update_post([
            'ID'         => $post_id,
            'menu_order' => $position,
        ]);
        $position++;
    }

    wp_send_json_success(['count' => $position - 1]);
});

