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
                <div class="galleria-grid">
                    <?php foreach ($gallery_urls as $url) : ?>
                        <figure class="galleria-grid__item">
                            <img src="<?php echo esc_url($url); ?>" alt="<?php echo esc_attr__('Foto galleria Baby Gym', 'babygym'); ?>">
                        </figure>
                    <?php endforeach; ?>
                </div>
            <?php else : ?>
                <p class="text-center"><?php echo esc_html__('Nessuna foto disponibile al momento.', 'babygym'); ?></p>
            <?php endif; ?>
        </section>
    </article>
</main>
<?php
get_footer();
