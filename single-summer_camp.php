<?php
/**
 * Single template Summer Camp.
 *
 * @package BABYGYM
 */

if (! defined('ABSPATH')) {
    exit;
}

get_header();
?>
<main id="primary" class="site-main site-main--wide">
    <article class="filosofia-page summer-camp-single">
        <?php
        while (have_posts()) :
            the_post();
            $post_id       = get_the_ID();
            $locandina_url = (string) get_post_meta($post_id, '_babygym_summer_camp_locandina_url', true);
            $gallery_raw   = (string) get_post_meta($post_id, '_babygym_summer_camp_gallery', true);
            $eta           = (string) get_post_meta($post_id, '_babygym_summer_camp_eta', true);
            $settimane     = (string) get_post_meta($post_id, '_babygym_summer_camp_settimane', true);
            $orario        = (string) get_post_meta($post_id, '_babygym_summer_camp_orario', true);
            $post_orario   = (string) get_post_meta($post_id, '_babygym_summer_camp_post_orario', true);
            $iscrizioni_entro = (string) get_post_meta($post_id, '_babygym_summer_camp_iscrizioni_entro', true);
            $descrizione   = (string) get_post_meta($post_id, '_babygym_summer_camp_descrizione', true);
            $gallery_urls  = array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $gallery_raw) ?: [])));
            ?>
            <section class="filosofia-hero card card--centered">
                <p class="feste-eyebrow"><?php echo esc_html__('Summer Camp', 'babygym'); ?></p>
                <h1 class="feste-hero__title"><?php the_title(); ?></h1>
            </section>

            <section class="card summer-camp-product">
                <div class="summer-camp-product__media">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="summer-camp-single__cover">
                            <?php the_post_thumbnail('large'); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ([] !== $gallery_urls) : ?>
                        <div class="summer-camp-single__gallery">
                            <?php foreach ($gallery_urls as $gallery_url) : ?>
                                <img src="<?php echo esc_url($gallery_url); ?>" alt="">
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                </div>

                <div class="summer-camp-product__info">
                    <?php if ('' !== trim($descrizione)) : ?>
                        <p class="summer-camp-product__lead"><?php echo esc_html($descrizione); ?></p>
                    <?php endif; ?>

                    <div class="summer-camp-single__content">
                        <?php the_content(); ?>
                    </div>

                    <?php if ('' !== trim($eta) || '' !== trim($settimane) || '' !== trim($orario) || '' !== trim($post_orario) || '' !== trim($iscrizioni_entro)) : ?>
                        <div class="summer-camp-single__details">
                            <h2><?php echo esc_html__('Informazioni camp', 'babygym'); ?></h2>
                            <ul class="corsi-list">
                                <?php if ('' !== trim($eta)) : ?>
                                    <li><strong><?php echo esc_html__('ETA\'', 'babygym'); ?>:</strong> <?php echo esc_html($eta); ?></li>
                                <?php endif; ?>
                                <?php if ('' !== trim($settimane)) : ?>
                                    <li><strong><?php echo esc_html__('SETTIMANE', 'babygym'); ?>:</strong> <?php echo esc_html($settimane); ?></li>
                                <?php endif; ?>
                                <?php if ('' !== trim($orario)) : ?>
                                    <li><strong><?php echo esc_html__('ORARIO', 'babygym'); ?>:</strong> <?php echo esc_html($orario); ?></li>
                                <?php endif; ?>
                                <?php if ('' !== trim($post_orario)) : ?>
                                    <li><strong><?php echo esc_html__('POST', 'babygym'); ?>:</strong> <?php echo esc_html($post_orario); ?></li>
                                <?php endif; ?>
                                <?php if ('' !== trim($iscrizioni_entro)) : ?>
                                    <li><strong><?php echo esc_html__('ISCRIZIONI ENTRO', 'babygym'); ?>:</strong> <?php echo esc_html($iscrizioni_entro); ?></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>
            </section>
        <?php endwhile; ?>
    </article>
</main>
<?php
get_footer();
