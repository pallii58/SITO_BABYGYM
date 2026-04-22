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
            $indirizzo     = (string) get_post_meta($post_id, '_babygym_summer_camp_indirizzo', true);
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
                        <div class="summer-camp-single__gallery-carousel" data-summer-camp-single-carousel>
                            <button type="button" class="feste-carousel__nav feste-carousel__nav--prev" data-single-carousel-prev aria-label="<?php echo esc_attr__('Foto precedente', 'babygym'); ?>">
                                <span aria-hidden="true">&lsaquo;</span>
                            </button>
                            <div class="summer-camp-single__gallery-track" data-single-carousel-track>
                                <?php foreach ($gallery_urls as $gallery_url) : ?>
                                    <figure class="summer-camp-single__gallery-slide">
                                        <img src="<?php echo esc_url($gallery_url); ?>" alt="">
                                    </figure>
                                <?php endforeach; ?>
                            </div>
                            <button type="button" class="feste-carousel__nav feste-carousel__nav--next" data-single-carousel-next aria-label="<?php echo esc_attr__('Foto successiva', 'babygym'); ?>">
                                <span aria-hidden="true">&rsaquo;</span>
                            </button>
                        </div>
                    <?php endif; ?>

                </div>

                <div class="summer-camp-product__info">
                    <?php if ('' !== trim($descrizione)) : ?>
                        <div class="summer-camp-product__lead"><?php echo wp_kses_post(nl2br(esc_html($descrizione))); ?></div>
                    <?php endif; ?>

                    <div class="summer-camp-single__content">
                        <?php the_content(); ?>
                    </div>

                    <?php if ('' !== trim($eta) || '' !== trim($indirizzo) || '' !== trim($settimane) || '' !== trim($orario) || '' !== trim($post_orario) || '' !== trim($iscrizioni_entro)) : ?>
                        <div class="summer-camp-single__details">
                            <h2><?php echo esc_html__('Informazioni camp', 'babygym'); ?></h2>
                            <ul class="corsi-list">
                                <?php if ('' !== trim($eta)) : ?>
                                    <li><strong><?php echo esc_html__('ETA\'', 'babygym'); ?>:</strong> <?php echo esc_html($eta); ?></li>
                                <?php endif; ?>
                                <?php if ('' !== trim($indirizzo)) : ?>
                                    <li><strong><?php echo esc_html__('INDIRIZZO', 'babygym'); ?>:</strong> <?php echo esc_html($indirizzo); ?></li>
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

            <?php if ('' !== trim($indirizzo)) : ?>
                <section class="card">
                    <h2 class="text-center"><?php echo esc_html__('Dove si svolge', 'babygym'); ?></h2>
                    <div class="contatti-map summer-camp-single__map">
                        <iframe
                            src="<?php echo esc_url('https://www.google.com/maps?q=' . rawurlencode($indirizzo) . '&output=embed'); ?>"
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            allowfullscreen
                            title="<?php echo esc_attr__('Mappa Summer Camp', 'babygym'); ?>"
                        ></iframe>
                    </div>
                </section>
            <?php endif; ?>

            <section class="card summer-camp-single__details summer-camp-single__details--centered">
                <h2><?php echo esc_html__('Per iscrizioni ed informazioni', 'babygym'); ?></h2>
                <p><strong><?php echo esc_html__('BABY GYM s.r.l. S.S.D.', 'babygym'); ?></strong></p>
                <p><?php echo esc_html__('Tel. 011/503484 - 347 3038255', 'babygym'); ?></p>
                <p><?php echo esc_html__('e-mail: babygymonlinetorino@gmail.com', 'babygym'); ?></p>
                <p><strong><?php echo esc_html__('ISCRIZIONI APERTE ANCHE AGLI ESTERNI', 'babygym'); ?></strong></p>
            </section>
        <?php endwhile; ?>
    </article>
</main>
<script>
    window.addEventListener('load', function () {
        document.querySelectorAll('[data-summer-camp-single-carousel]').forEach(function (carousel) {
            const track = carousel.querySelector('[data-single-carousel-track]');
            const prev = carousel.querySelector('[data-single-carousel-prev]');
            const next = carousel.querySelector('[data-single-carousel-next]');
            if (!track || !prev || !next) return;

            const step = () => Math.max(320, track.clientWidth);
            prev.addEventListener('click', () => {
                track.scrollBy({ left: -step(), behavior: 'smooth' });
            });
            next.addEventListener('click', () => {
                track.scrollBy({ left: step(), behavior: 'smooth' });
            });
        });
    });
</script>
<?php
get_footer();
