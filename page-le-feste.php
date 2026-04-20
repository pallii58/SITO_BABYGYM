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
                    <?php echo esc_html__('Siete stanchi di gonfiabili e noiosi animatori? Le feste Baby Gym sono attive, coinvolgenti e piene di giochi ginnici, musica, inglese e movimento.', 'babygym'); ?>
                </p>
                <a class="btn-primary" href="tel:+39011503484"><?php echo esc_html__('Prenota ora: 011 / 503484', 'babygym'); ?></a>
            </div>
        </section>

        <section class="feste-section">
            <div class="feste-grid feste-grid--2">
                <div class="card">
                    <h2><?php echo esc_html__('Come funziona la festa', 'babygym'); ?></h2>
                    <p><?php echo esc_html__('Le feste si svolgono nella palestra attrezzata di Via Vespucci 36 oppure fuori sede (scuole, oratori, saloni, giardini e altre location).', 'babygym'); ?></p>
                    <p><?php echo esc_html__('Tra materassoni, percorsi ginnici e giochi di movimento, i bambini vivono una festa dinamica e divertente guidata da istruttori qualificati.', 'babygym'); ?></p>
                    <p><?php echo esc_html__('I festeggiati sono i veri protagonisti: possono personalizzare giochi e sfide con temi sempre diversi.', 'babygym'); ?></p>
                </div>
                <div class="card card--highlight">
                    <h2><?php echo esc_html__('Perche piace ai bambini', 'babygym'); ?></h2>
                    <ul class="check-list">
                        <li><?php echo esc_html__('Percorsi ginnici colorati e attivita guidate', 'babygym'); ?></li>
                        <li><?php echo esc_html__('Musica, inglese e giochi a tema', 'babygym'); ?></li>
                        <li><?php echo esc_html__('Carrucola per "volare" in palestra', 'babygym'); ?></li>
                        <li><?php echo esc_html__('Due animatori qualificati inclusi', 'babygym'); ?></li>
                        <li><?php echo esc_html__('Possibilita pigiama party serale', 'babygym'); ?></li>
                    </ul>
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
                    <p><?php echo esc_html__('Sera: 19.00 - 21.30 (anche pigiama party)', 'babygym'); ?></p>
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
                    <p><strong><?php echo esc_html__('Fino a 15 bimbi: EUR 310', 'babygym'); ?></strong></p>
                    <p><?php echo esc_html__('(EUR 290 + EUR 20 quota di iscrizione, stornata solo in caso di successiva iscrizione ai corsi)', 'babygym'); ?></p>
                    <p><?php echo esc_html__('Dal 16° bimbo in poi: + EUR 5 per partecipante', 'babygym'); ?></p>
                </div>
                <div class="card">
                    <h3><?php echo esc_html__('Iscritti Baby Gym', 'babygym'); ?></h3>
                    <p><strong><?php echo esc_html__('Fino a 15 bimbi: EUR 290', 'babygym'); ?></strong></p>
                    <p><?php echo esc_html__('(quota associativa in corso di validita)', 'babygym'); ?></p>
                    <p><?php echo esc_html__('Dal 16° bimbo in poi: + EUR 5 per partecipante', 'babygym'); ?></p>
                </div>
            </div>
            <div class="card">
                <h3><?php echo esc_html__('Cosa include', 'babygym'); ?></h3>
                <p><?php echo esc_html__('Uso esclusivo sala, attrezzature ginniche, carrucola, giochi, personaggi, musica, luci, due animatori qualificati e pulizia prima/dopo.', 'babygym'); ?></p>
                <p><?php echo esc_html__('Buffet a carico della famiglia.', 'babygym'); ?></p>
            </div>
        </section>

        <section class="feste-section">
            <div class="card card--soft">
                <h2><?php echo esc_html__('Feste fuori sede', 'babygym'); ?></h2>
                <p><?php echo esc_html__('Se avete una location esterna possiamo portare attrezzatura e organizzare una vera palestra mobile.', 'babygym'); ?></p>
                <p><?php echo esc_html__('I costi sono gli stessi della festa in sede. Se fuori Torino: + EUR 10 trasporto.', 'babygym'); ?></p>
                <p><?php echo esc_html__('Formula senza attrezzature ginniche: costo fisso EUR 250.', 'babygym'); ?></p>
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
