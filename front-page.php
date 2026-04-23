<?php
/**
 * Home page template.
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
    <article class="home-page">
        <section class="home-hero card card--centered">
            <p class="feste-eyebrow"><?php echo esc_html__('Fitness English & Fun', 'babygym'); ?></p>
            <h1 class="feste-hero__title"><?php echo esc_html__('Benvenuti al Baby Gym', 'babygym'); ?></h1>
            <p class="home-hero__lead">
                <?php echo esc_html__('La palestra dove i bambini crescono con', 'babygym'); ?>
                <span class="feste-key"><?php echo esc_html__('movimento', 'babygym'); ?></span>,
                <span class="feste-key"><?php echo esc_html__('gioco', 'babygym'); ?></span>,
                <span class="feste-key"><?php echo esc_html__('musica', 'babygym'); ?></span>
                <?php echo esc_html__('e prime parole in', 'babygym'); ?>
                <span class="feste-key"><?php echo esc_html__('inglese', 'babygym'); ?></span>.
            </p>
            <div class="home-hero__actions">
                <a class="btn-primary" href="https://wa.me/393473038255" target="_blank" rel="noopener noreferrer"><?php echo esc_html__('Prenota una prova', 'babygym'); ?></a>
                <a class="btn-secondary" href="<?php echo esc_url(home_url('/corsi')); ?>"><?php echo esc_html__('Scopri i corsi', 'babygym'); ?></a>
            </div>
        </section>

        <section class="home-section">
            <h2 class="section-title text-center"><?php echo esc_html__('Cosa puoi fare al Baby Gym', 'babygym'); ?></h2>
            <div class="home-grid">
                <a class="card home-card-link" href="<?php echo esc_url(home_url('/corsi')); ?>">
                    <h3><?php echo esc_html__('Corsi', 'babygym'); ?></h3>
                    <p><?php echo esc_html__('Programmi per fasce d’età con attività motorie, socializzazione e sviluppo della fiducia in sé.', 'babygym'); ?></p>
                </a>
                <a class="card card--highlight home-card-link" href="<?php echo esc_url(home_url('/le-feste')); ?>">
                    <h3><?php echo esc_html__('Le Feste', 'babygym'); ?></h3>
                    <p><?php echo esc_html__('Feste ginniche piene di percorsi, giochi, musica e animatori qualificati, anche con formula On Wheels.', 'babygym'); ?></p>
                </a>
                <a class="card home-card-link" href="<?php echo esc_url(home_url('/summer-camps')); ?>">
                    <h3><?php echo esc_html__('Summer Camps', 'babygym'); ?></h3>
                    <p><?php echo esc_html__('Mattinate estive per bambini da 3 a 9 anni, con tanto movimento e attività creative.', 'babygym'); ?></p>
                </a>
            </div>
        </section>

        <section class="home-section">
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
        </section>

        <section class="home-section">
            <div class="card card--soft card--centered">
                <h2><?php echo esc_html__('La nostra filosofia', 'babygym'); ?></h2>
                <p><?php echo esc_html__('Al Baby Gym crediamo in un ambiente', 'babygym'); ?> <span class="feste-key"><?php echo esc_html__('non competitivo', 'babygym'); ?></span> <?php echo esc_html__('dove ogni bambino può imparare divertendosi e facendo del proprio meglio.', 'babygym'); ?></p>
                <p><a class="btn-secondary" href="<?php echo esc_url(home_url('/filosofia')); ?>"><?php echo esc_html__('Leggi la filosofia completa', 'babygym'); ?></a></p>
            </div>
        </section>

        <section class="home-section">
            <div class="card card--centered">
                <h2><?php echo esc_html__('Contattaci', 'babygym'); ?></h2>
                <p><span class="feste-key"><?php echo esc_html__('011 / 503484', 'babygym'); ?></span> · <span class="feste-key"><?php echo esc_html__('347 / 3038255', 'babygym'); ?></span></p>
                <p><a class="feste-key" href="mailto:babygym.to@gmail.com">babygym.to@gmail.com</a></p>
                <p><?php echo esc_html__('Via Vespucci 36 - 10129 Torino', 'babygym'); ?></p>
                <p><a class="btn-primary" href="<?php echo esc_url(home_url('/contatti')); ?>"><?php echo esc_html__('Vai alla pagina contatti', 'babygym'); ?></a></p>
            </div>
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
