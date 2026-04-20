<?php
/**
 * Pagina "Le Feste".
 *
 * @package BABYGYM
 */

if (! defined('ABSPATH')) {
    exit;
}

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
                    <h2><?php echo esc_html__('Perche piace ai bambini', 'babygym'); ?></h2>
                    <div class="feste-bento">
                        <div class="feste-bento__item">
                            <span class="feste-bento__icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" role="img" focusable="false">
                                    <path d="M7 9h10a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-2a2 2 0 0 1 2-2Zm-3 1h2v4H4a1 1 0 0 1-1-1v-2a1 1 0 0 1 1-1Zm16 0h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-2v-4Z"/>
                                </svg>
                            </span>
                            <p><?php echo esc_html__('Percorsi ginnici colorati e attivita guidate', 'babygym'); ?></p>
                        </div>
                        <div class="feste-bento__item">
                            <span class="feste-bento__icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" role="img" focusable="false">
                                    <path d="M15 4v10.2a3.2 3.2 0 1 1-1.4-2.65V6.3l7-1.6v8.5a3.2 3.2 0 1 1-1.4-2.65V6.55L15 7.5V4Z"/>
                                </svg>
                            </span>
                            <p><?php echo esc_html__('Musica, inglese e giochi a tema', 'babygym'); ?></p>
                        </div>
                        <div class="feste-bento__item">
                            <span class="feste-bento__icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" role="img" focusable="false">
                                    <path d="M12 3a1 1 0 0 1 1 1v8.6l2.4-2.4a1 1 0 1 1 1.4 1.4l-4.1 4.1a1 1 0 0 1-1.4 0l-4.1-4.1a1 1 0 0 1 1.4-1.4L11 12.6V4a1 1 0 0 1 1-1Zm-6 14h12a1 1 0 1 1 0 2H6a1 1 0 1 1 0-2Z"/>
                                </svg>
                            </span>
                            <p><?php echo esc_html__('Carrucola per "volare" in palestra', 'babygym'); ?></p>
                        </div>
                        <div class="feste-bento__item">
                            <span class="feste-bento__icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" role="img" focusable="false">
                                    <path d="M8 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6Zm8 0a3 3 0 1 1 0-6 3 3 0 0 1 0 6ZM4.5 19a3.5 3.5 0 0 1 7 0v1h-7v-1Zm8.5 1v-1a4.5 4.5 0 0 1 9 0v1h-9Z"/>
                                </svg>
                            </span>
                            <p><?php echo esc_html__('Due animatori qualificati inclusi', 'babygym'); ?></p>
                        </div>
                        <div class="feste-bento__item feste-bento__item--full">
                            <span class="feste-bento__icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" role="img" focusable="false">
                                    <path d="M14.7 3.4a8.3 8.3 0 1 0 5.9 14.2A7.3 7.3 0 1 1 14.7 3.4ZM9 8l1 2.1L12.3 11 10 12l-1 2.1L8 12l-2.3-0.9L8 10.1 9 8Z"/>
                                </svg>
                            </span>
                            <p><?php echo esc_html__('Possibilita pigiama party serale', 'babygym'); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="feste-section">
            <h2 class="section-title"><?php echo esc_html__('Orari disponibili', 'babygym'); ?></h2>
            <div class="feste-grid feste-grid--3">
                <div class="card">
                    <h3><?php echo esc_html__('Venerdi', 'babygym'); ?></h3>
                    <p><?php echo esc_html__('Sera: 19.00 - 21.30', 'babygym'); ?></p>
                </div>
                <div class="card">
                    <h3><?php echo esc_html__('Sabato', 'babygym'); ?></h3>
                    <p><?php echo esc_html__('Pomeriggio: 15.30 - 18.00', 'babygym'); ?></p>
                    <p>
                        <?php echo esc_html__('Sera: 19.00 - 21.30', 'babygym'); ?><br>
                        <span class="feste-note-accent"><?php echo esc_html__('(anche pigiama party)', 'babygym'); ?></span>
                    </p>
                </div>
                <div class="card">
                    <h3><?php echo esc_html__('Domenica', 'babygym'); ?></h3>
                    <p><?php echo esc_html__('Mattina: 10.00 - 12.30', 'babygym'); ?></p>
                    <p><?php echo esc_html__('Pomeriggio: 17.00 - 19.30', 'babygym'); ?></p>
                </div>
            </div>
            <p class="feste-note"><?php echo esc_html__('In settimana sono disponibili slot 13.00 - 15.30 per bambini che non hanno il pomeriggio scolastico (lunedi, martedi, mercoledi e venerdi).', 'babygym'); ?></p>
        </section>

        <section class="feste-section">
            <h2 class="section-title"><?php echo esc_html__('Costi e formula', 'babygym'); ?></h2>
            <div class="feste-grid feste-grid--2">
                <div class="card">
                    <h3><?php echo esc_html__('Non iscritti ai corsi', 'babygym'); ?></h3>
                    <p><strong><span class="feste-key"><?php echo esc_html__('Fino a 15 bimbi: EUR 310', 'babygym'); ?></span></strong></p>
                    <p><?php echo esc_html__('(EUR 290 + EUR 20 quota di iscrizione, stornata solo in caso di successiva iscrizione ai corsi)', 'babygym'); ?></p>
                    <p><?php echo esc_html__('Dal 16° bimbo in poi:', 'babygym'); ?> <span class="feste-key"><?php echo esc_html__('+ EUR 5 per partecipante', 'babygym'); ?></span></p>
                </div>
                <div class="card">
                    <h3><?php echo esc_html__('Iscritti Baby Gym', 'babygym'); ?></h3>
                    <p><strong><span class="feste-key"><?php echo esc_html__('Fino a 15 bimbi: EUR 290', 'babygym'); ?></span></strong></p>
                    <p><?php echo esc_html__('(quota associativa in corso di validita)', 'babygym'); ?></p>
                    <p><?php echo esc_html__('Dal 16° bimbo in poi:', 'babygym'); ?> <span class="feste-key"><?php echo esc_html__('+ EUR 5 per partecipante', 'babygym'); ?></span></p>
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
                <p><?php echo esc_html__('I costi sono gli stessi della festa in sede. Se fuori Torino:', 'babygym'); ?> <span class="feste-key"><?php echo esc_html__('+ EUR 10 trasporto', 'babygym'); ?></span>.</p>
                <p><?php echo esc_html__('Formula senza attrezzature ginniche:', 'babygym'); ?> <span class="feste-key"><?php echo esc_html__('costo fisso EUR 250', 'babygym'); ?></span>.</p>
                <p><?php echo esc_html__('Consiglio Baby Gym: condividere la festa con amici che compiono gli anni nello stesso periodo per dividere i costi.', 'babygym'); ?></p>
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
</main>
<?php
get_footer();
