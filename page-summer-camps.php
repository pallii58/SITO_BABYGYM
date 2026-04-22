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

        <section class="filosofia-section card">
            <p><?php echo esc_html__('Le attività estive Baby Gym sono pensate per accompagnare ogni bambino nello sviluppo delle capacità fisico-motorie, cognitive e relazionali, in un ambiente sereno e stimolante.', 'babygym'); ?></p>
            <p><?php echo esc_html__('Con ginnastica, giochi e musica, imparare diventa naturale e divertente: tra un\'attività e l\'altra scopriremo anche le prime parole in', 'babygym'); ?> <span class="feste-key"><?php echo esc_html__('Inglese', 'babygym'); ?></span>.</p>
            <p><?php echo esc_html__('Le mattinate insieme saranno piene di energia: tanto', 'babygym'); ?> <span class="feste-key"><?php echo esc_html__('movimento', 'babygym'); ?></span>, <span class="feste-key"><?php echo esc_html__('esercizi', 'babygym'); ?></span>, <?php echo esc_html__('percorsi avventurosi,', 'babygym'); ?> <span class="feste-key"><?php echo esc_html__('giochi di gruppo', 'babygym'); ?></span> <?php echo esc_html__('e attività creative come colorare, ritagliare e incollare.', 'babygym'); ?></p>
            <p><?php echo esc_html__('Ogni proposta aiuta i bambini a migliorare coordinazione e sicurezza, superare piccole paure e rafforzare la fiducia in se stessi. Il tutto in un contesto non competitivo, che valorizza collaborazione, rispetto e voglia di mettersi in gioco.', 'babygym'); ?></p>
            <p><?php echo esc_html__('Ogni settimana vivremo un nuovo', 'babygym'); ?> <span class="feste-key"><?php echo esc_html__('Tema di Lezione', 'babygym'); ?></span> <?php echo esc_html__('(pirati, olimpiadi e tanti altri) per rendere ogni giornata ancora più coinvolgente, curiosa ed emozionante.', 'babygym'); ?></p>
            <p><?php echo esc_html__('Ti aspettiamo per un\'estate piena di sorrisi, scoperte e nuove conquiste insieme!', 'babygym'); ?></p>
        </section>

        <section class="feste-section card">
            <h2 class="section-title text-center"><?php echo esc_html__('I nostri Summer Camp', 'babygym'); ?></h2>
            <?php if ($summer_camp_query->have_posts()) : ?>
                <div class="summer-camp-carousel" data-summer-camp-carousel>
                    <button type="button" class="feste-carousel__nav feste-carousel__nav--prev" data-carousel-prev aria-label="<?php echo esc_attr__('Slide precedente', 'babygym'); ?>">‹</button>
                    <div class="summer-camp-carousel__track" data-carousel-track>
                        <?php
                        while ($summer_camp_query->have_posts()) :
                            $summer_camp_query->the_post();
                            $post_id = get_the_ID();
                            $locandina_url = (string) get_post_meta($post_id, '_babygym_summer_camp_locandina_url', true);
                            $cover_image = get_the_post_thumbnail_url($post_id, 'large');
                            if ('' === $cover_image && '' !== $locandina_url && preg_match('/\.(jpg|jpeg|png|webp|gif)$/i', $locandina_url)) {
                                $cover_image = $locandina_url;
                            }
                            $excerpt = get_the_excerpt();
                            ?>
                            <article class="summer-camp-card">
                                <?php if ('' !== $cover_image) : ?>
                                    <img src="<?php echo esc_url($cover_image); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" class="summer-camp-card__image">
                                <?php endif; ?>
                                <div class="summer-camp-card__body">
                                    <h3><?php the_title(); ?></h3>
                                    <?php if ('' !== $excerpt) : ?>
                                        <p><?php echo esc_html($excerpt); ?></p>
                                    <?php endif; ?>
                                    <a class="btn-primary" href="<?php the_permalink(); ?>"><?php echo esc_html__('Scopri il camp', 'babygym'); ?></a>
                                </div>
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
    </article>
</main>
<script>
    window.addEventListener('load', function () {
        document.querySelectorAll('[data-summer-camp-carousel]').forEach(function (carousel) {
            const track = carousel.querySelector('[data-carousel-track]');
            const prev = carousel.querySelector('[data-carousel-prev]');
            const next = carousel.querySelector('[data-carousel-next]');
            if (!track || !prev || !next) return;

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
