<?php
/**
 * Pagina "Le Feste".
 *
 * @package BABYGYM
 */

if (! defined('ABSPATH')) {
    exit;
}

$feste_options  = babygym_get_feste_options();
$schedule_groups = babygym_get_feste_schedule_groups($feste_options);
$carousel_lines = preg_split('/\r\n|\r|\n/', (string) $feste_options['carousel_images']) ?: [];
$carousel_urls  = array_values(array_filter(array_map('trim', $carousel_lines)));

get_header();
?>
<main id="primary" class="site-main site-main--wide">
    <article class="feste-page">
        <section class="feste-hero">
            <div class="feste-hero__content">
                <p class="feste-eyebrow"><?php echo esc_html__('Baby Gym Torino', 'babygym'); ?></p>
                <h1 class="feste-hero__title"><?php echo esc_html__('Le feste al Baby Gym', 'babygym'); ?></h1>
                <p class="feste-hero__lead">
                    <?php echo esc_html__('Siete stanchi di gonfiabili e noiosi animatori? Le feste Baby Gym sono attive, coinvolgenti e piene di', 'babygym'); ?>
                    <span class="feste-key"><?php echo esc_html__('giochi ginnici', 'babygym'); ?></span>,
                    <span class="feste-key"><?php echo esc_html__('musica', 'babygym'); ?></span>,
                    <span class="feste-key"><?php echo esc_html__('inglese', 'babygym'); ?></span>
                    <?php echo esc_html__('e movimento.', 'babygym'); ?>
                </p>
                <a class="btn-primary" href="tel:+39011503484"><?php echo esc_html__('Prenota ora: 011 / 503484', 'babygym'); ?></a>
            </div>
        </section>

        <section class="feste-section feste-section--intro">
            <div class="feste-grid feste-grid--2">
                <div class="card card--centered">
                    <h2><?php echo esc_html__('Come funziona la festa', 'babygym'); ?></h2>
                    <p><?php echo esc_html__('Le feste si svolgono nella palestra attrezzata di Via Vespucci 36 oppure fuori sede (scuole, oratori, saloni, giardini e altre location).', 'babygym'); ?></p>
                    <p><?php echo esc_html__('Tra materassoni, percorsi ginnici e giochi di movimento, i bambini vivono una festa dinamica e divertente guidata da', 'babygym'); ?> <span class="feste-key"><?php echo esc_html__('istruttori qualificati', 'babygym'); ?></span>.</p>
                    <p><?php echo esc_html__('I festeggiati sono i veri protagonisti: possono personalizzare giochi e sfide con temi sempre diversi.', 'babygym'); ?></p>
                </div>
                <div class="card card--highlight">
                    <h2 class="text-center"><?php echo esc_html__('Perche piace ai bambini', 'babygym'); ?></h2>
                    <div class="feste-bento">
                        <div class="feste-bento__item">
                            <span class="feste-bento__icon" aria-hidden="true">
                                <img src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/icons/controller.svg" alt="" loading="lazy" decoding="async">
                            </span>
                            <p><?php echo esc_html__('Percorsi ginnici colorati e attivita guidate', 'babygym'); ?></p>
                        </div>
                        <div class="feste-bento__item">
                            <span class="feste-bento__icon" aria-hidden="true">
                                <img src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/icons/music-note-beamed.svg" alt="" loading="lazy" decoding="async">
                            </span>
                            <p><?php echo esc_html__('Musica, inglese e giochi a tema', 'babygym'); ?></p>
                        </div>
                        <div class="feste-bento__item">
                            <span class="feste-bento__icon" aria-hidden="true">
                                <img src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/icons/balloon-heart.svg" alt="" loading="lazy" decoding="async">
                            </span>
                            <p><?php echo esc_html__('Carrucola per "volare" in palestra', 'babygym'); ?></p>
                        </div>
                        <div class="feste-bento__item">
                            <span class="feste-bento__icon" aria-hidden="true">
                                <img src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/icons/people-fill.svg" alt="" loading="lazy" decoding="async">
                            </span>
                            <p><?php echo esc_html__('Due animatori qualificati inclusi', 'babygym'); ?></p>
                        </div>
                        <div class="feste-bento__item feste-bento__item--full">
                            <span class="feste-bento__icon" aria-hidden="true">
                                <img src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/icons/moon-stars-fill.svg" alt="" loading="lazy" decoding="async">
                            </span>
                            <p><?php echo esc_html__('Possibilita pigiama party serale', 'babygym'); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <?php if ([] !== $carousel_urls) : ?>
        <section class="feste-section">
            <h2 class="section-title text-center"><?php echo esc_html__('Galleria feste', 'babygym'); ?></h2>
            <div class="feste-carousel" data-feste-carousel>
                <button type="button" class="feste-carousel__nav feste-carousel__nav--prev" aria-label="<?php echo esc_attr__('Foto precedente', 'babygym'); ?>">
                    <span aria-hidden="true">&lsaquo;</span>
                </button>
                <div class="feste-carousel__track" data-feste-carousel-track>
                    <?php foreach ($carousel_urls as $index => $image_url) : ?>
                        <figure class="feste-carousel__slide">
                            <img
                                src="<?php echo esc_url($image_url); ?>"
                                alt="<?php echo esc_attr(sprintf(__('Foto festa %d', 'babygym'), $index + 1)); ?>"
                                loading="lazy"
                                decoding="async"
                            >
                        </figure>
                    <?php endforeach; ?>
                </div>
                <button type="button" class="feste-carousel__nav feste-carousel__nav--next" aria-label="<?php echo esc_attr__('Foto successiva', 'babygym'); ?>">
                    <span aria-hidden="true">&rsaquo;</span>
                </button>
            </div>
        </section>
        <?php endif; ?>

        <section class="feste-section">
            <h2 class="section-title text-center"><?php echo esc_html__('Orari disponibili', 'babygym'); ?></h2>
            <div class="feste-grid feste-grid--3">
                <?php foreach ($schedule_groups as $day_label => $slots) : ?>
                    <div class="card">
                        <h3><?php echo esc_html($day_label); ?></h3>
                        <?php foreach ($slots as $slot) : ?>
                            <p>
                                <?php echo esc_html($slot['label'] . ': ' . $slot['time']); ?>
                                <?php if ('' !== $slot['note']) : ?>
                                    <br><span class="feste-note-accent"><?php echo esc_html($slot['note']); ?></span>
                                <?php endif; ?>
                            </p>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <p class="feste-note text-center"><?php echo esc_html($feste_options['weekday_note']); ?></p>
        </section>

        <section class="feste-section">
            <h2 class="section-title text-center"><?php echo esc_html__('Costi e formula', 'babygym'); ?></h2>
            <div class="feste-grid feste-grid--2">
                <div class="card">
                    <h3><?php echo esc_html__('Non iscritti ai corsi', 'babygym'); ?></h3>
                    <p><strong><span class="feste-key"><?php echo esc_html($feste_options['non_members_price']); ?></span></strong></p>
                    <p><?php echo esc_html($feste_options['non_members_note']); ?></p>
                    <p><?php echo esc_html__('Dal 16° bimbo in poi:', 'babygym'); ?> <span class="feste-key"><?php echo esc_html($feste_options['extra_child_price']); ?></span></p>
                </div>
                <div class="card">
                    <h3><?php echo esc_html__('Iscritti Baby Gym', 'babygym'); ?></h3>
                    <p><strong><span class="feste-key"><?php echo esc_html($feste_options['members_price']); ?></span></strong></p>
                    <p><?php echo esc_html($feste_options['members_note']); ?></p>
                    <p><?php echo esc_html__('Dal 16° bimbo in poi:', 'babygym'); ?> <span class="feste-key"><?php echo esc_html($feste_options['extra_child_price']); ?></span></p>
                </div>
            </div>
            <div class="card card--centered">
                <h3><?php echo esc_html__('Cosa include', 'babygym'); ?></h3>
                <p><?php echo esc_html__('Uso esclusivo sala, attrezzature ginniche, carrucola, giochi, personaggi, musica, luci, due animatori qualificati e pulizia prima/dopo.', 'babygym'); ?></p>
                <p><?php echo esc_html__('Buffet a carico della famiglia.', 'babygym'); ?></p>
            </div>
        </section>

        <section class="feste-section">
            <div class="card card--soft card--centered">
                <h2><?php echo esc_html__('Feste fuori sede', 'babygym'); ?></h2>
                <p><?php echo esc_html__('Se avete una location esterna possiamo portare attrezzatura e organizzare una vera palestra mobile.', 'babygym'); ?></p>
                <p><?php echo esc_html__('I costi sono gli stessi della festa in sede. Se fuori Torino:', 'babygym'); ?> <span class="feste-key"><?php echo esc_html($feste_options['offsite_transport']); ?></span>.</p>
                <p><?php echo esc_html__('Formula senza attrezzature ginniche:', 'babygym'); ?> <span class="feste-key"><?php echo esc_html($feste_options['no_equipment_price']); ?></span>.</p>
                <p><?php echo esc_html__('Consiglio Baby Gym: condividere la festa con amici che compiono gli anni nello stesso periodo per dividere i costi.', 'babygym'); ?></p>
            </div>
        </section>

        <section class="feste-section">
            <div class="card card--centered">
                <h2><?php echo esc_html__('Le feste Baby Gym On Wheels', 'babygym'); ?></h2>
                <p><?php echo esc_html__('Con il progetto', 'babygym'); ?> <span class="feste-key"><?php echo esc_html__('On Wheels', 'babygym'); ?></span> <?php echo esc_html__('riusciamo a fare le divertenti feste Baby Gym in locali diversi dalla nostra sede: case private, parchi e giardini riuscendo ad organizzare divertenti', 'babygym'); ?> <span class="feste-key"><?php echo esc_html__('cacce al tesoro', 'babygym'); ?></span>.</p>
                <p><?php echo esc_html__('Grazie al', 'babygym'); ?> <span class="feste-key"><?php echo esc_html__('furgone Baby Gym', 'babygym'); ?></span> <?php echo esc_html__('portiamo il set di attrezzature che ci permetterà di montare un percorso ginnico sia', 'babygym'); ?> <span class="feste-key"><?php echo esc_html__('indoor', 'babygym'); ?></span> <?php echo esc_html__('che', 'babygym'); ?> <span class="feste-key"><?php echo esc_html__('outdoor', 'babygym'); ?></span>!!</p>
                <p><?php echo esc_html__('Per informazioni vieni a trovarci, scrivi o chiamaci!', 'babygym'); ?></p>
            </div>
        </section>

        <section class="feste-cta">
            <h2><?php echo esc_html__('Info e prenotazioni', 'babygym'); ?></h2>
            <p><?php echo esc_html__('Per dettagli e disponibilita e consigliato il contatto telefonico (9.00 - 12.30).', 'babygym'); ?></p>
            <div class="feste-cta__actions">
                <a class="btn-primary" href="tel:+39011503484">011 / 503484</a>
                <a class="btn-secondary" href="tel:+393473038255">347 / 3038255</a>
            </div>
        </section>
    </article>
        <script>
    (function () {
        const carousel = document.querySelector('[data-feste-carousel]');
        if (!carousel) return;
        const track = carousel.querySelector('[data-feste-carousel-track]');
        const prev = carousel.querySelector('.feste-carousel__nav--prev');
        const next = carousel.querySelector('.feste-carousel__nav--next');
        if (!track || !prev || !next) return;

        const step = () => Math.max(320, track.clientWidth * 0.85);
        prev.addEventListener('click', () => {
            track.scrollBy({ left: -step(), behavior: 'smooth' });
        });
        next.addEventListener('click', () => {
            track.scrollBy({ left: step(), behavior: 'smooth' });
        });
    })();
</script>
</main>
<?php
get_footer();
