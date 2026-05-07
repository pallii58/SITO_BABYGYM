<?php
/**
 * Pagina "Galleria".
 *
 * @package BABYGYM
 */

if (! defined('ABSPATH')) {
    exit;
}

get_header();
$galleria_options = function_exists('babygym_get_galleria_options') ? babygym_get_galleria_options() : ['gallery_images' => ''];
$gallery_lines = preg_split('/\r\n|\r|\n/', (string) ($galleria_options['gallery_images'] ?? '')) ?: [];
$gallery_urls = array_values(array_filter(array_map('trim', $gallery_lines)));
?>
<main id="primary" class="site-main site-main--wide">
    <article class="filosofia-page">
        <section class="filosofia-hero card card--centered">
            <p class="feste-eyebrow"><?php echo esc_html__('Baby Gym Torino', 'babygym'); ?></p>
            <h1 class="feste-hero__title"><?php echo esc_html__('Galleria', 'babygym'); ?></h1>
            <p class="filosofia-lead"><?php echo esc_html__('I nostri momenti più belli', 'babygym'); ?></p>
        </section>

        <section class="feste-section card">
            <?php if ([] !== $gallery_urls) : ?>
                <div class="galleria-grid" data-galleria-grid>
                    <?php foreach ($gallery_urls as $index => $url) : ?>
                        <figure class="galleria-grid__item">
                            <button
                                type="button"
                                class="galleria-grid__open"
                                data-galleria-open="<?php echo (int) $index; ?>"
                                aria-haspopup="dialog"
                                aria-controls="babygym-galleria-lightbox"
                                aria-label="<?php echo esc_attr(sprintf(
                                    /* translators: %d: thumbnail number (1-based) */
                                    __('Apri foto %d in ingrandimento', 'babygym'),
                                    (int) $index + 1
                                )); ?>"
                            >
                                <img
                                    src="<?php echo esc_url($url); ?>"
                                    alt=""
                                    loading="lazy"
                                    decoding="async"
                                    draggable="false"
                                >
                            </button>
                        </figure>
                    <?php endforeach; ?>
                </div>

                <dialog class="galleria-lightbox" id="babygym-galleria-lightbox" aria-label="<?php echo esc_attr__('Galleria a schermo intero', 'babygym'); ?>">
                    <button type="button" class="galleria-lightbox__close" data-galleria-close aria-label="<?php echo esc_attr__('Chiudi galleria', 'babygym'); ?>">&times;</button>
                    <button type="button" class="galleria-lightbox__nav galleria-lightbox__nav--prev" data-galleria-prev aria-label="<?php echo esc_attr__('Immagine precedente', 'babygym'); ?>">
                        <span aria-hidden="true">&lsaquo;</span>
                    </button>
                    <div class="galleria-lightbox__stage" data-galleria-stage>
                        <img src="" alt="<?php echo esc_attr__('Foto galleria Baby Gym', 'babygym'); ?>" class="galleria-lightbox__img" data-galleria-img decoding="async" draggable="false">
                        <span class="galleria-lightbox__counter" data-galleria-counter aria-live="polite"></span>
                    </div>
                    <button type="button" class="galleria-lightbox__nav galleria-lightbox__nav--next" data-galleria-next aria-label="<?php echo esc_attr__('Immagine successiva', 'babygym'); ?>">
                        <span aria-hidden="true">&rsaquo;</span>
                    </button>
                </dialog>

                <script type="application/json" id="babygym-galleria-urls-json"><?php echo wp_json_encode($gallery_urls, JSON_HEX_TAG | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE); ?></script>
                <script>
                    (function () {
                        var jsonEl = document.getElementById('babygym-galleria-urls-json');
                        var dialog = document.getElementById('babygym-galleria-lightbox');
                        if (!jsonEl || !dialog || typeof dialog.showModal !== 'function') return;
                        try {
                            var urls = JSON.parse(jsonEl.textContent || '[]');
                        } catch (e) {
                            return;
                        }
                        if (!Array.isArray(urls) || urls.length === 0) return;

                        var img = dialog.querySelector('[data-galleria-img]');
                        var counterEl = dialog.querySelector('[data-galleria-counter]');
                        var stage = dialog.querySelector('[data-galleria-stage]');
                        var i = 0;

                        function clamp(n, len) {
                            var k = Number(n);
                            if (!Number.isFinite(k)) {
                                k = 0;
                            }
                            return ((k % len) + len) % len;
                        }

                        function show(ix) {
                            i = clamp(ix, urls.length);
                            if (img) {
                                img.src = urls[i] || '';
                            }
                            if (counterEl) {
                                counterEl.textContent = (i + 1) + ' / ' + urls.length;
                            }
                        }

                        function openAt(ix) {
                            show(ix);
                            dialog.showModal();
                        }

                        document.querySelectorAll('[data-galleria-open]').forEach(function (btn) {
                            btn.addEventListener('click', function () {
                                var ix = parseInt(btn.getAttribute('data-galleria-open'), 10);
                                openAt(ix);
                            });
                        });

                        dialog.querySelectorAll('[data-galleria-prev]').forEach(function (el) {
                            el.addEventListener('click', function () { show(i - 1); });
                        });
                        dialog.querySelectorAll('[data-galleria-next]').forEach(function (el) {
                            el.addEventListener('click', function () { show(i + 1); });
                        });
                        dialog.querySelectorAll('[data-galleria-close]').forEach(function (el) {
                            el.addEventListener('click', function () { dialog.close(); });
                        });
                        dialog.addEventListener('click', function (e) {
                            if (e.target === dialog) dialog.close();
                        });

                        dialog.addEventListener('keydown', function (e) {
                            if (e.key === 'ArrowRight') {
                                e.preventDefault();
                                show(i + 1);
                            }
                            if (e.key === 'ArrowLeft') {
                                e.preventDefault();
                                show(i - 1);
                            }
                        });

                        if (stage && 'ontouchstart' in window) {
                            var startX = 0;
                            stage.addEventListener('touchstart', function (ev) {
                                startX = ev.changedTouches[0].clientX;
                            }, { passive: true });
                            stage.addEventListener('touchend', function (ev) {
                                var dx = ev.changedTouches[0].clientX - startX;
                                if (Math.abs(dx) < 42) return;
                                if (dx < 0) show(i + 1);
                                else show(i - 1);
                            }, { passive: true });
                        }
                    })();
                </script>
            <?php else : ?>
                <p class="text-center"><?php echo esc_html__('Nessuna foto disponibile al momento.', 'babygym'); ?></p>
            <?php endif; ?>
        </section>
    </article>
</main>
<?php
get_footer();
