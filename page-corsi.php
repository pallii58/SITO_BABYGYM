<?php
/**
 * Pagina "Corsi".
 *
 * @package BABYGYM
 */

if (! defined('ABSPATH')) {
    exit;
}

$corsi_options      = babygym_get_corsi_options();
$carousel_lines     = preg_split('/\r\n|\r|\n/', (string) $corsi_options['carousel_images']) ?: [];
$carousel_urls      = array_values(array_filter(array_map('trim', $carousel_lines)));
$skills_items       = [
    'ruota / rondata',
    'verticale e varianti (con capovolta, alle parallele, al muro con camminata laterale)',
    'capovolte avanti, indietro, indietro alla verticale, tuffate',
    'giri addominali alla sbarra (in avanti e indietro)',
    'flick-flack indietro e ribaltata avanti',
    'tecniche di atterraggio',
    'abilità sulla trave di equilibrio',
    'utilizzo della pedana elastica per salti e volteggi',
    'giochi e sport di squadra',
];
$equipment_items    = [
    'travi di equilibrio',
    'parallele',
    'sbarre',
    'pedana elastica',
    'grandi materassoni colorati in materiale espanso',
    'corda elastica, paracadute, hula hoop, corde, palloni, foulard, sacchetti motori, strumenti musicali e altro',
];
$schedule_sections  = babygym_get_corsi_schedule_sections((string) $corsi_options['schedule_rows']);

get_header();
?>
<main id="primary" class="site-main site-main--wide">
    <article class="corsi-page">
        <section class="corsi-hero card card--centered">
            <p class="feste-eyebrow"><?php echo esc_html__('Baby Gym Torino', 'babygym'); ?></p>
            <h1 class="feste-hero__title"><?php echo esc_html__('I corsi al Baby Gym', 'babygym'); ?></h1>
            <p class="corsi-lead">
                <?php echo esc_html__('I corsi Baby Gym si propongono di avvicinare anche i più piccoli alla', 'babygym'); ?>
                <span class="feste-key"><?php echo esc_html__('pratica dello sport', 'babygym'); ?></span>,
                <?php echo esc_html__('e, attraverso questo, alle prime parole d’', 'babygym'); ?><span class="feste-key"><?php echo esc_html__('inglese', 'babygym'); ?></span>!
            </p>
        </section>

        <section class="corsi-section">
            <div class="card corsi-intro-card">
                <p><span class="feste-key"><?php echo esc_html__('Programmi NON COMPETITIVI', 'babygym'); ?></span><?php echo esc_html__(', specifici per le diverse fasce d’età dei bambini, studiati da pediatri e psicologi, valorizzano la', 'babygym'); ?> <span class="feste-key"><?php echo esc_html__('socializzazione', 'babygym'); ?></span> <?php echo esc_html__('e la', 'babygym'); ?> <span class="feste-key"><?php echo esc_html__('cooperazione', 'babygym'); ?></span> <?php echo esc_html__('all’interno del gruppo e fanno sì che i bambini imparino che non è indispensabile essere sempre i migliori: l’importante è fare del proprio meglio!', 'babygym'); ?></p>
            </div>
            <div class="corsi-grid-2">
                <div class="card">
                    <h3><?php echo esc_html__('Come si svolge la lezione', 'babygym'); ?></h3>
                    <ul class="corsi-list">
                        <li><?php echo esc_html__('I bambini, con il supporto di istruttori qualificati, vengono incoraggiati ad affrontare piccoli rischi e provare esercizi sempre nuovi, vincendo così le proprie paure ed acquisendo maggior sicurezza in se stessi.', 'babygym'); ?></li>
                        <li><?php echo esc_html__('Le direttive dell’istruttore e le canzoni utilizzate in diversi momenti della lezione sono in inglese affinché i bambini imparino anche questa lingua straniera.', 'babygym'); ?></li>
                        <li><?php echo esc_html__('I programmi sono strutturati in lezioni settimanali svolte seguendo uno specifico “piano di lezione” e ambientate, ogni settimana, in un diverso "tema di lezione".', 'babygym'); ?></li>
                    </ul>
                </div>
                <div class="card card--soft">
                    <h3><?php echo esc_html__('Piano e tema di lezione', 'babygym'); ?></h3>
                    <p><span class="feste-key"><?php echo esc_html__('Il Piano di Lezione', 'babygym'); ?></span> <?php echo esc_html__('è uno schema che descrive le abilità che vengono sviluppate durante la lezione.', 'babygym'); ?></p>
                    <p><span class="feste-key"><?php echo esc_html__('Il Tema di Lezione', 'babygym'); ?></span> <?php echo esc_html__('è l\'ambientazione delle attività: lo spazio, le olimpiadi, salviamo gli oceani, la sicurezza, il paese al contrario. Giocare ogni volta in un ambiente diverso stimola la fantasia e consente di insegnare ai bimbi cose nuove e sensibilizzarli su temi importanti.', 'babygym'); ?></p>
                </div>
            </div>
        </section>

        <?php if ([] !== $carousel_urls) : ?>
        <section class="corsi-section">
            <h2 class="section-title text-center"><?php echo esc_html__('Galleria corsi', 'babygym'); ?></h2>
            <div class="feste-carousel" data-corsi-carousel data-carousel-min-items="3">
                <button type="button" class="feste-carousel__nav feste-carousel__nav--prev" aria-label="<?php echo esc_attr__('Foto precedente', 'babygym'); ?>">
                    <span aria-hidden="true">&lsaquo;</span>
                </button>
                <div class="feste-carousel__track" data-corsi-carousel-track>
                    <?php foreach ($carousel_urls as $index => $image_url) : ?>
                        <figure class="feste-carousel__slide">
                            <img
                                src="<?php echo esc_url($image_url); ?>"
                                alt="<?php echo esc_attr(sprintf(__('Foto corso %d', 'babygym'), $index + 1)); ?>"
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

        <section class="corsi-section corsi-grid-2">
            <div class="card">
                <h2><?php echo esc_html__('Abilità sviluppate', 'babygym'); ?></h2>
                <ul class="corsi-list">
                    <?php foreach ($skills_items as $item) : ?>
                        <li><?php echo esc_html($item); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="card card--soft">
                <h2><?php echo esc_html__('Attrezzature utilizzate', 'babygym'); ?></h2>
                <ul class="corsi-list">
                    <?php foreach ($equipment_items as $item) : ?>
                        <li><?php echo esc_html($item); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </section>

        <?php if (count($schedule_sections) > 1) : ?>
            <section class="corsi-section">
                <div class="card card--centered">
                    <h2 class="section-title"><?php echo esc_html__('Scegli la sede', 'babygym'); ?></h2>
                    <div class="corsi-location-pills" role="tablist" aria-label="<?php echo esc_attr__('Selezione sede corsi', 'babygym'); ?>">
                        <?php foreach ($schedule_sections as $index => $section) : ?>
                            <button
                                type="button"
                                class="corsi-location-pill<?php echo 0 === $index ? ' is-active' : ''; ?>"
                                data-corsi-location-pill="<?php echo esc_attr((string) $index); ?>"
                                role="tab"
                                aria-selected="<?php echo 0 === $index ? 'true' : 'false'; ?>"
                            >
                                <?php echo esc_html($section['location']); ?>
                            </button>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <?php foreach ($schedule_sections as $index => $section) : ?>
            <section class="corsi-section<?php echo 0 === $index ? '' : ' non-visibile'; ?>" data-corsi-location-section="<?php echo esc_attr((string) $index); ?>">
                <h2 class="section-title text-center"><?php echo esc_html__('Orario Baby Gym di', 'babygym'); ?> <?php echo esc_html($section['location']); ?></h2>
                <div class="text-center">
                    <button type="button" class="btn-secondary corsi-table-trigger" data-corsi-open-table="<?php echo esc_attr((string) $index); ?>">
                        <?php echo esc_html__('Vista a tabella', 'babygym'); ?>
                    </button>
                </div>
                <div class="corsi-schedule-grid">
                    <?php foreach ($section['courses'] as $course_name => $items) : ?>
                        <div class="card">
                            <h3><?php echo esc_html($course_name); ?></h3>
                            <ul class="corsi-list">
                                <?php foreach ($items as $line) : ?>
                                    <li><?php echo esc_html($line); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>

            <div class="corsi-modal" data-corsi-modal="<?php echo esc_attr((string) $index); ?>" hidden>
                <div class="corsi-modal__backdrop" data-corsi-close-table="<?php echo esc_attr((string) $index); ?>"></div>
                <div class="corsi-modal__dialog" role="dialog" aria-modal="true" aria-label="<?php echo esc_attr__('Orari corsi in tabella', 'babygym'); ?>">
                    <div class="corsi-modal__head">
                        <h3><?php echo esc_html__('Orari corsi - Vista a tabella', 'babygym'); ?> (<?php echo esc_html($section['location']); ?>)</h3>
                        <button type="button" class="corsi-modal__close" aria-label="<?php echo esc_attr__('Chiudi', 'babygym'); ?>" data-corsi-close-table="<?php echo esc_attr((string) $index); ?>">&times;</button>
                    </div>
                    <div class="corsi-modal__body">
                        <div class="corsi-table-wrap">
                            <table class="corsi-table">
                                <thead>
                                    <tr>
                                        <th><?php echo esc_html__('Corso', 'babygym'); ?></th>
                                        <?php foreach ($section['days'] as $day_label) : ?>
                                            <th><?php echo esc_html($day_label); ?></th>
                                        <?php endforeach; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($section['table'] as $course_name => $day_map) : ?>
                                        <tr>
                                            <th><?php echo esc_html($course_name); ?></th>
                                            <?php foreach ($section['days'] as $day_label) : ?>
                                                <td>
                                                    <?php
                                                    $slot_values = $day_map[$day_label] ?? [];
                                                    if ([] === $slot_values) {
                                                        echo '-';
                                                    } else {
                                                        echo wp_kses_post(implode('<br>', array_map('esc_html', $slot_values)));
                                                    }
                                                    ?>
                                                </td>
                                            <?php endforeach; ?>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        <section class="corsi-section card corsi-schools">
            <h2 class="text-center"><?php echo esc_html__('Corsi Baby Gym nelle scuole', 'babygym'); ?></h2>
            <div class="corsi-schools__grid">
                <div class="corsi-schools__content">
                    <p><?php echo esc_html__('Con il progetto', 'babygym'); ?> <span class="feste-key"><?php echo esc_html__('On Wheels', 'babygym'); ?></span> <?php echo esc_html__('riusciamo ad utilizzare i nostri programmi Baby Gym negli asili nido, scuole materne e scuole elementari.', 'babygym'); ?></p>
                    <p><?php echo esc_html__('Grazie al', 'babygym'); ?> <span class="feste-key"><?php echo esc_html__('furgone Baby Gym', 'babygym'); ?></span> <?php echo esc_html__('portiamo il set di attrezzature che ci permette di montare un percorso ginnico direttamente nei locali dedicati della scuola.', 'babygym'); ?></p>
                    <p><?php echo esc_html__('In questo modo la lezione sarà dedicata all\'intero gruppo classe oppure a diversi gruppi di pari età provenienti da classi diverse.', 'babygym'); ?></p>
                    <p class="corsi-schools__cta"><?php echo esc_html__('Per maggiori informazioni contattaci!', 'babygym'); ?></p>
                </div>
                <div class="card card--soft corsi-schools__list-wrap">
                    <h3><?php echo esc_html__('Asili nido e scuole materne', 'babygym'); ?></h3>
                    <ul class="corsi-schools__list">
                        <li><?php echo esc_html__('Andersen', 'babygym'); ?></li>
                        <li><?php echo esc_html__('Scuola materna Via d\'Arborea', 'babygym'); ?></li>
                        <li><?php echo esc_html__('Scuola Materna Berta', 'babygym'); ?></li>
                        <li><?php echo esc_html__('Nido di Peo e Pea', 'babygym'); ?></li>
                        <li><?php echo esc_html__('Il pulcino ballerino', 'babygym'); ?></li>
                        <li><?php echo esc_html__('Thaon di Revel - V Lombardore', 'babygym'); ?></li>
                    </ul>
                </div>
            </div>
        </section>
    </article>
</main>
<script>
    (function () {
        const carousel = document.querySelector('[data-corsi-carousel]');
        if (carousel) {
            const track = carousel.querySelector('[data-corsi-carousel-track]');
            const prev = carousel.querySelector('.feste-carousel__nav--prev');
            const next = carousel.querySelector('.feste-carousel__nav--next');
            if (track && prev && next) {
                const minItems = Number(carousel.getAttribute('data-carousel-min-items') || '3');
                const totalItems = track.children.length;
                const showNav = totalItems > minItems;
                prev.style.display = showNav ? '' : 'none';
                next.style.display = showNav ? '' : 'none';
                if (!showNav) {
                    return;
                }
                const step = () => Math.max(320, track.clientWidth * 0.85);
                prev.addEventListener('click', () => track.scrollBy({ left: -step(), behavior: 'smooth' }));
                next.addEventListener('click', () => track.scrollBy({ left: step(), behavior: 'smooth' }));
            }
        }

        const openButtons = document.querySelectorAll('[data-corsi-open-table]');
        const modals = document.querySelectorAll('[data-corsi-modal]');
        const locationSections = document.querySelectorAll('[data-corsi-location-section]');
        const locationPills = document.querySelectorAll('[data-corsi-location-pill]');
        const closeModal = (modal) => {
            modal.hidden = true;
            if ([...modals].every((item) => item.hidden)) {
                document.body.classList.remove('corsi-modal-open');
            }
        };
        const openModal = (modal) => {
            modal.hidden = false;
            document.body.classList.add('corsi-modal-open');
        };
        openButtons.forEach((button) => {
            button.addEventListener('click', () => {
                const key = button.getAttribute('data-corsi-open-table');
                const modal = document.querySelector(`[data-corsi-modal="${key}"]`);
                if (modal) {
                    openModal(modal);
                }
            });
        });
        modals.forEach((modal) => {
            modal.querySelectorAll('[data-corsi-close-table]').forEach((el) => {
                el.addEventListener('click', () => closeModal(modal));
            });
        });

        if (locationSections.length > 0 && locationPills.length > 0) {
            const renderLocationSection = (activeKey) => {
                locationSections.forEach((section) => {
                    const isActive = section.getAttribute('data-corsi-location-section') === activeKey;
                    section.classList.toggle('non-visibile', !isActive);
                });
                locationPills.forEach((pill) => {
                    const isActive = pill.getAttribute('data-corsi-location-pill') === activeKey;
                    pill.classList.toggle('is-active', isActive);
                    pill.setAttribute('aria-selected', isActive ? 'true' : 'false');
                });
            };
            const initialKey = locationPills[0].getAttribute('data-corsi-location-pill') || '0';
            renderLocationSection(initialKey);
            locationPills.forEach((pill) => {
                pill.addEventListener('click', () => {
                    const key = pill.getAttribute('data-corsi-location-pill') || '0';
                    renderLocationSection(key);
                });
            });
        }

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                modals.forEach((modal) => {
                    if (!modal.hidden) {
                        closeModal(modal);
                    }
                });
            }
        });
    })();
</script>
<?php
get_footer();
