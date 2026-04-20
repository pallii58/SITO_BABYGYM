<?php
/**
 * Pagina dedicata "Le Feste".
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
                <h1 class="feste-title"><?php echo esc_html__('Le feste al Baby Gym', 'babygym'); ?></h1>
                <p class="feste-lead"><?php echo esc_html__('Siete stanchi di gonfiabili e noiosi animatori? Le feste Baby Gym sono esperienze piene di movimento, giochi, musica e divertimento vero.', 'babygym'); ?></p>
                <div class="feste-actions">
                    <a class="feste-btn feste-btn--primary" href="tel:+39011503484"><?php echo esc_html__('Chiama 011/503484', 'babygym'); ?></a>
                    <a class="feste-btn feste-btn--secondary" href="tel:+393473038255"><?php echo esc_html__('Chiama 347/3038255', 'babygym'); ?></a>
                </div>
            </div>
        </section>

        <section class="feste-section feste-section--intro">
            <div class="feste-grid feste-grid--2">
                <div class="feste-card">
                    <h2><?php echo esc_html__('Come sono le nostre feste', 'babygym'); ?></h2>
                    <p><?php echo esc_html__('Le feste si svolgono nella palestra attrezzata di Via Vespucci 36, ma possiamo organizzarle anche fuori sede (scuole, oratori, saloni, giardini privati e altri spazi).', 'babygym'); ?></p>
                    <p><?php echo esc_html__('Tra materassoni colorati, percorsi ginnici, carrucola, musica, inglese e giochi di movimento, i bambini sono sempre coinvolti e protagonisti.', 'babygym'); ?></p>
                </div>
                <div class="feste-card">
                    <h2><?php echo esc_html__('Festa su misura', 'babygym'); ?></h2>
                    <p><?php echo esc_html__('I festeggiati personalizzano la festa insieme agli istruttori scegliendo giochi e sfide: Pirati, Isola del tesoro, Mr. Snake, Crazy Wizard, Paracadute e tanti altri.', 'babygym'); ?></p>
                    <p><?php echo esc_html__('Puoi anche condividere la festa con compagni/amichetti che compiono gli anni nello stesso periodo per dividere i costi.', 'babygym'); ?></p>
                </div>
            </div>
        </section>

        <section class="feste-section">
            <h2 class="feste-section__title"><?php echo esc_html__('Orari disponibili', 'babygym'); ?></h2>
            <div class="feste-grid feste-grid--3">
                <div class="feste-card feste-card--time">
                    <h3><?php echo esc_html__('Weekend', 'babygym'); ?></h3>
                    <ul>
                        <li><?php echo esc_html__('Venerdi sera: 19:00 - 21:30', 'babygym'); ?></li>
                        <li><?php echo esc_html__('Sabato pomeriggio: 15:30 - 18:00', 'babygym'); ?></li>
                        <li><?php echo esc_html__('Sabato sera: 19:00 - 21:30 (anche pigiama party)', 'babygym'); ?></li>
                        <li><?php echo esc_html__('Domenica mattina: 10:00 - 12:30', 'babygym'); ?></li>
                        <li><?php echo esc_html__('Domenica pomeriggio: 17:00 - 19:30', 'babygym'); ?></li>
                    </ul>
                </div>
                <div class="feste-card feste-card--time">
                    <h3><?php echo esc_html__('In settimana', 'babygym'); ?></h3>
                    <ul>
                        <li><?php echo esc_html__('Lunedi, martedi, mercoledi e venerdi', 'babygym'); ?></li>
                        <li><?php echo esc_html__('Fascia indicativa: 13:00 - 15:30', 'babygym'); ?></li>
                        <li><?php echo esc_html__('Ideale per bimbi che non fanno il pomeriggio a scuola', 'babygym'); ?></li>
                    </ul>
                </div>
                <div class="feste-card feste-card--contact">
                    <h3><?php echo esc_html__('Info e prenotazioni', 'babygym'); ?></h3>
                    <p><?php echo esc_html__('Per dettagli e date disponibili, consigliamo il contatto telefonico.', 'babygym'); ?></p>
                    <p><a href="tel:+39011503484">011/503484</a><br><a href="tel:+393473038255">347/3038255</a></p>
                    <p><?php echo esc_html__('Orario consigliato: 9:00 - 12:30', 'babygym'); ?></p>
                </div>
            </div>
        </section>

        <section class="feste-section">
            <h2 class="feste-section__title"><?php echo esc_html__('Costi', 'babygym'); ?></h2>
            <div class="feste-grid feste-grid--2">
                <div class="feste-card feste-card--price">
                    <h3><?php echo esc_html__('Non iscritti ai corsi', 'babygym'); ?></h3>
                    <p class="feste-price"><?php echo esc_html__('EUR 310 fino a 15 bimbi', 'babygym'); ?></p>
                    <ul>
                        <li><?php echo esc_html__('EUR 290 + EUR 20 quota iscrizione', 'babygym'); ?></li>
                        <li><?php echo esc_html__('La quota viene stornata solo in caso di iscrizione ai corsi', 'babygym'); ?></li>
                        <li><?php echo esc_html__('Dal 16esimo bimbo: EUR 5 a partecipante', 'babygym'); ?></li>
                    </ul>
                </div>
                <div class="feste-card feste-card--price">
                    <h3><?php echo esc_html__('Iscritti Baby Gym', 'babygym'); ?></h3>
                    <p class="feste-price"><?php echo esc_html__('EUR 290 fino a 15 bimbi', 'babygym'); ?></p>
                    <ul>
                        <li><?php echo esc_html__('Quota associativa in corso di validita', 'babygym'); ?></li>
                        <li><?php echo esc_html__('Dal 16esimo bimbo: EUR 5 a partecipante', 'babygym'); ?></li>
                        <li><?php echo esc_html__('Formula senza attrezzature ginniche: costo fisso EUR 250', 'babygym'); ?></li>
                    </ul>
                </div>
            </div>
            <div class="feste-note">
                <p><?php echo esc_html__('Il costo include sala in uso esclusivo, attrezzature ginniche, carrucola, musica, personaggi, due animatori qualificati e pulizie prima/dopo.', 'babygym'); ?></p>
                <p><?php echo esc_html__('Per feste fuori Torino e previsto EUR 10 per il trasporto.', 'babygym'); ?></p>
            </div>
        </section>

        <section class="feste-section feste-section--cta">
            <h2><?php echo esc_html__('Vuoi organizzare la tua festa?', 'babygym'); ?></h2>
            <p><?php echo esc_html__('Passa a trovarci in Via Vespucci 36 oppure contattaci telefonicamente per trovare la data perfetta.', 'babygym'); ?></p>
            <div class="feste-actions feste-actions--center">
                <a class="feste-btn feste-btn--primary" href="tel:+39011503484"><?php echo esc_html__('011/503484', 'babygym'); ?></a>
                <a class="feste-btn feste-btn--secondary" href="tel:+393473038255"><?php echo esc_html__('347/3038255', 'babygym'); ?></a>
            </div>
        </section>
    </article>
</main>
<?php
get_footer();
