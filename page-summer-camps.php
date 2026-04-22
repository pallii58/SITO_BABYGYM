<?php
/**
 * Pagina "Summer Camps".
 *
 * @package BABYGYM
 */

if (! defined('ABSPATH')) {
    exit;
}

get_header();
$summer_camp_query = new WP_Query([
    'post_type' => 'summer_camp',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'orderby' => 'date',
    'order' => 'DESC',
]);
?>
<main id="primary" class="site-main site-main--wide">
    <article class="filosofia-page">
        <section class="filosofia-hero card card--centered">
            <p class="feste-eyebrow"><?php echo esc_html__('Baby Gym Torino', 'babygym'); ?></p>
            <h1 class="feste-hero__title"><?php echo esc_html__('Summer camps - Estate al Baby Gym', 'babygym'); ?></h1>
            <p class="filosofia-lead"><?php echo esc_html__('Attività estive per bambini da 3 a 9 anni', 'babygym'); ?></p>
        </section>

        <section class="feste-section card">
            <h2 class="section-title text-center"><?php echo esc_html__('I nostri Summer Camp', 'babygym'); ?></h2>
            <?php if ($summer_camp_query->have_posts()) : ?>
                <div class="summer-camp-carousel" data-summer-camp-carousel data-carousel-min-items="3">
                    <button type="button" class="feste-carousel__nav feste-carousel__nav--prev" data-carousel-prev aria-label="<?php echo esc_attr__('Slide precedente', 'babygym'); ?>">‹</button>
                    <div class="summer-camp-carousel__track" data-carousel-track>
                        <?php
                        while ($summer_camp_query->have_posts()) :
                            $summer_camp_query->the_post();
                            $post_id = get_the_ID();
                            $locandina_url = (string) get_post_meta($post_id, '_babygym_summer_camp_locandina_url', true);
                            $eta = (string) get_post_meta($post_id, '_babygym_summer_camp_eta', true);
                            $indirizzo = (string) get_post_meta($post_id, '_babygym_summer_camp_indirizzo', true);
                            $gallery_raw = (string) get_post_meta($post_id, '_babygym_summer_camp_gallery', true);
                            $gallery_urls = array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $gallery_raw) ?: [])));
                            $cover_image = (string) get_the_post_thumbnail_url($post_id, 'large');
                            if ('' === $cover_image && '' !== $locandina_url && preg_match('/\.(jpg|jpeg|png|webp|gif)($|\?)/i', $locandina_url)) {
                                $cover_image = $locandina_url;
                            }
                            if ('' === $cover_image && [] !== $gallery_urls) {
                                $cover_image = (string) $gallery_urls[0];
                            }
                            ?>
                            <article class="summer-camp-card">
                                <a class="summer-camp-card__link" href="<?php the_permalink(); ?>">
                                    <?php if ('' !== $cover_image) : ?>
                                        <img src="<?php echo esc_url($cover_image); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" class="summer-camp-card__image">
                                    <?php endif; ?>
                                    <div class="summer-camp-card__body">
                                        <h3><?php the_title(); ?></h3>
                                        <?php if ('' !== trim($eta)) : ?>
                                            <p class="summer-camp-card__meta summer-camp-card__meta--age"><strong><?php echo esc_html__('ETÀ', 'babygym'); ?>:</strong> <?php echo esc_html($eta); ?></p>
                                        <?php endif; ?>
                                        <?php if ('' !== trim($indirizzo)) : ?>
                                            <p class="summer-camp-card__meta summer-camp-card__meta--address"><strong><?php echo esc_html__('INDIRIZZO', 'babygym'); ?>:</strong> <span class="summer-camp-card__meta-address-value"><?php echo esc_html($indirizzo); ?></span></p>
                                        <?php endif; ?>
                                        <span class="btn-primary"><?php echo esc_html__('Scopri il camp', 'babygym'); ?></span>
                                    </div>
                                </a>
                            </article>
                        <?php endwhile; ?>
                    </div>
                    <button type="button" class="feste-carousel__nav feste-carousel__nav--next" data-carousel-next aria-label="<?php echo esc_attr__('Slide successiva', 'babygym'); ?>">›</button>
                </div>
                <?php wp_reset_postdata(); ?>
            <?php else : ?>
                <p class="text-center"><?php echo esc_html__('Nessun Summer Camp disponibile al momento.', 'babygym'); ?></p>
            <?php endif; ?>
        </section>

        <section class="filosofia-section card summer-camp-intro">
            <p class="summer-camp-intro__lead"><?php echo esc_html__('Le attività estive Baby Gym aiutano i bambini a crescere in modo armonioso, sviluppando capacità motorie, cognitive e relazionali in un ambiente sereno e stimolante.', 'babygym'); ?></p>
            <div class="summer-camp-intro__grid">
                <article class="summer-camp-intro__item">
                    <h3><?php echo esc_html__('Imparare divertendosi', 'babygym'); ?></h3>
                    <p><?php echo esc_html__('Con ginnastica, giochi e musica, ogni mattinata diventa un\'occasione per imparare con entusiasmo, includendo anche le prime parole in Inglese.', 'babygym'); ?></p>
                </article>
                <article class="summer-camp-intro__item">
                    <h3><?php echo esc_html__('Attività sempre varie', 'babygym'); ?></h3>
                    <p><?php echo esc_html__('Tanto movimento, esercizi, percorsi avventurosi, giochi di gruppo e attività creative come colorare, ritagliare e incollare.', 'babygym'); ?></p>
                </article>
                <article class="summer-camp-intro__item">
                    <h3><?php echo esc_html__('Crescita e fiducia', 'babygym'); ?></h3>
                    <p><?php echo esc_html__('I bambini migliorano coordinazione e sicurezza, superano piccole paure e rafforzano la fiducia in se stessi in un contesto non competitivo.', 'babygym'); ?></p>
                </article>
                <article class="summer-camp-intro__item">
                    <h3><?php echo esc_html__('Tema di Lezione settimanale', 'babygym'); ?></h3>
                    <p><?php echo esc_html__('Ogni settimana seguiamo un tema diverso (pirati, olimpiadi e tanti altri) per rendere ogni giornata ancora più curiosa, coinvolgente ed emozionante.', 'babygym'); ?></p>
                </article>
            </div>
            <p class="summer-camp-intro__closing"><?php echo esc_html__('Vedrai che divertimento: quante scoperte e quante nuove conquiste faremo insieme!', 'babygym'); ?></p>
        </section>
    </article>
</main>
<script>
    window.addEventListener('load', function () {
        document.querySelectorAll('[data-summer-camp-carousel]').forEach(function (carousel) {
            const track = carousel.querySelector('[data-carousel-track]');
            const prev = carousel.querySelector('[data-carousel-prev]');
            const next = carousel.querySelector('[data-carousel-next]');
            if (!track || !prev || !next) return;
            const minItems = Number(carousel.getAttribute('data-carousel-min-items') || '3');
            const totalItems = track.children.length;
            const showNav = totalItems > minItems;
            prev.style.display = showNav ? '' : 'none';
            next.style.display = showNav ? '' : 'none';
            if (!showNav) return;

            const scrollByCard = () => Math.max(260, Math.round(track.clientWidth * 0.8));
            prev.addEventListener('click', () => {
                track.scrollBy({ left: -scrollByCard(), behavior: 'smooth' });
            });
            next.addEventListener('click', () => {
                track.scrollBy({ left: scrollByCard(), behavior: 'smooth' });
            });
        });
    });
</script>
<?php
get_footer();
