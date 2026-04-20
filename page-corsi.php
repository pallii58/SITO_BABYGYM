<?php
/**
 * Pagina "Corsi".
 *
 * @package BABYGYM
 */

if (! defined('ABSPATH')) {
    exit;
}

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

        <section class="corsi-section card">
            <p><span class="feste-key"><?php echo esc_html__('Programmi NON COMPETITIVI', 'babygym'); ?></span><?php echo esc_html__(', specifici per le diverse fasce d’età dei bambini, studiati da pediatri e psicologi, valorizzano la', 'babygym'); ?> <span class="feste-key"><?php echo esc_html__('socializzazione', 'babygym'); ?></span> <?php echo esc_html__('e la', 'babygym'); ?> <span class="feste-key"><?php echo esc_html__('cooperazione', 'babygym'); ?></span> <?php echo esc_html__('all’interno del gruppo e fanno sì che i bambini imparino che non è indispensabile essere sempre i migliori: l’importante è fare del proprio meglio!', 'babygym'); ?></p>
            <p><?php echo esc_html__('I bambini, con il supporto di', 'babygym'); ?> <span class="feste-key"><?php echo esc_html__('istruttori qualificati', 'babygym'); ?></span><?php echo esc_html__(', vengono incoraggiati ad affrontare piccoli rischi e provare esercizi sempre nuovi, vincendo così le proprie paure ed acquisendo maggior sicurezza in se stessi.', 'babygym'); ?></p>
            <p><?php echo esc_html__('Inoltre, come precedentemente accennato, le direttive dell’istruttore e le canzoni utilizzate in diversi momenti della lezione sono in', 'babygym'); ?> <span class="feste-key"><?php echo esc_html__('inglese', 'babygym'); ?></span> <?php echo esc_html__('affinché i bambini imparino anche questa lingua straniera.', 'babygym'); ?></p>
            <p><?php echo esc_html__('I programmi sono strutturati in', 'babygym'); ?> <span class="feste-key"><?php echo esc_html__('lezioni settimanali', 'babygym'); ?></span> <?php echo esc_html__('svolte seguendo uno specifico “piano di lezione” e ambientate, ogni settimana, in un diverso "tema di lezione".', 'babygym'); ?></p>
            <p><span class="feste-key"><?php echo esc_html__('Il Piano di Lezione', 'babygym'); ?></span> <?php echo esc_html__('è uno schema che descrive le abilità che vengono sviluppate durante la lezione.', 'babygym'); ?></p>
            <p><span class="feste-key"><?php echo esc_html__('Il Tema di Lezione', 'babygym'); ?></span> <?php echo esc_html__('è l\'ambientazione delle attività: lo spazio, le olimpiadi, salviamo gli oceani, la sicurezza, il paese al contrario. Giocare ogni volta in un ambiente diverso stimola la fantasia e consente di insegnare ai bimbi cose nuove e sensibilizzarli su temi importanti.', 'babygym'); ?></p>
        </section>

        <section class="corsi-section corsi-grid-2">
            <div class="card">
                <h2><?php echo esc_html__('Abilità sviluppate', 'babygym'); ?></h2>
                <ul class="corsi-list">
                    <li><?php echo esc_html__('ruota / rondata', 'babygym'); ?></li>
                    <li><?php echo esc_html__('verticale e varianti (con capovolta, alle parallele, al muro con camminata laterale)', 'babygym'); ?></li>
                    <li><?php echo esc_html__('capovolte avanti, indietro, indietro alla verticale, tuffate', 'babygym'); ?></li>
                    <li><?php echo esc_html__('giri addominali alla sbarra (in avanti e indietro)', 'babygym'); ?></li>
                    <li><?php echo esc_html__('flick-flack indietro e ribaltata avanti', 'babygym'); ?></li>
                    <li><?php echo esc_html__('tecniche di atterraggio', 'babygym'); ?></li>
                    <li><?php echo esc_html__('abilità sulla trave di equilibrio', 'babygym'); ?></li>
                    <li><?php echo esc_html__('utilizzo della pedana elastica per salti e volteggi', 'babygym'); ?></li>
                    <li><?php echo esc_html__('giochi e sport di squadra', 'babygym'); ?></li>
                </ul>
            </div>
            <div class="card card--soft">
                <h2><?php echo esc_html__('Attrezzature utilizzate', 'babygym'); ?></h2>
                <ul class="corsi-list">
                    <li><?php echo esc_html__('travi di equilibrio', 'babygym'); ?></li>
                    <li><?php echo esc_html__('parallele', 'babygym'); ?></li>
                    <li><?php echo esc_html__('sbarre', 'babygym'); ?></li>
                    <li><?php echo esc_html__('pedana elastica', 'babygym'); ?></li>
                    <li><?php echo esc_html__('grandi materassoni colorati in materiale espanso', 'babygym'); ?></li>
                    <li><?php echo esc_html__('corda elastica, paracadute, hula hoop, corde, palloni, foulard, sacchetti motori, strumenti musicali e altro', 'babygym'); ?></li>
                </ul>
            </div>
        </section>

        <section class="corsi-section">
            <h2 class="section-title text-center"><?php echo esc_html__('Orario Baby Gym di Via Vespucci 36, Torino', 'babygym'); ?></h2>
            <div class="corsi-schedule-grid">
                <div class="card">
                    <h3><?php echo esc_html__('BUGS (4-10 mesi)', 'babygym'); ?></h3>
                    <ul class="corsi-list">
                        <li><?php echo esc_html__('Giovedì: 9.00 - 10.00', 'babygym'); ?></li>
                        <li><?php echo esc_html__('Mercoledì: 15.20 - 16.20', 'babygym'); ?></li>
                    </ul>
                </div>

                <div class="card">
                    <h3><?php echo esc_html__('BIRDS (10-19 mesi)', 'babygym'); ?></h3>
                    <ul class="corsi-list">
                        <li><?php echo esc_html__('Mercoledì: 10.00 - 11.00 (da attivare)', 'babygym'); ?></li>
                        <li><?php echo esc_html__('Giovedì: 10.00 - 11.00, 15.30 - 16.30', 'babygym'); ?></li>
                    </ul>
                </div>

                <div class="card">
                    <h3><?php echo esc_html__('BEASTS (19 mesi - 3 anni)', 'babygym'); ?></h3>
                    <ul class="corsi-list">
                        <li><?php echo esc_html__('Lunedì: 16.30 - 17.30', 'babygym'); ?></li>
                        <li><?php echo esc_html__('Martedì: 10.00 - 11.00, 11.00 - 12.00, 16.20 - 17.20, 18.20 - 19.20', 'babygym'); ?></li>
                        <li><?php echo esc_html__('Mercoledì: 11.00 - 12.00 (da attivare), 18.20 - 19.20', 'babygym'); ?></li>
                        <li><?php echo esc_html__('Giovedì: 11.00 - 12.00, 15.30 - 16.30', 'babygym'); ?></li>
                        <li><?php echo esc_html__('Sabato: 10.00 - 11.00', 'babygym'); ?></li>
                    </ul>
                </div>

                <div class="card">
                    <h3><?php echo esc_html__('FUNNY BUGS (3-4 anni)', 'babygym'); ?></h3>
                    <ul class="corsi-list">
                        <li><?php echo esc_html__('Lunedì: 17.30 - 18.30', 'babygym'); ?></li>
                        <li><?php echo esc_html__('Mercoledì: 17.20 - 18.20', 'babygym'); ?></li>
                        <li><?php echo esc_html__('Giovedì: 18.30 - 19.30', 'babygym'); ?></li>
                        <li><?php echo esc_html__('Venerdì: 16.30 - 17.30', 'babygym'); ?></li>
                        <li><?php echo esc_html__('Sabato: 9.00 - 10.00', 'babygym'); ?></li>
                    </ul>
                </div>

                <div class="card">
                    <h3><?php echo esc_html__('GOOD FRIENDS (4-6 anni)', 'babygym'); ?></h3>
                    <ul class="corsi-list">
                        <li><?php echo esc_html__('Martedì: 17.20 - 18.20', 'babygym'); ?></li>
                        <li><?php echo esc_html__('Mercoledì: 16.20 - 17.20', 'babygym'); ?></li>
                        <li><?php echo esc_html__('Giovedì: 16.30 - 17.30, 18.30 - 19.30', 'babygym'); ?></li>
                        <li><?php echo esc_html__('Venerdì: 17.30 - 18.30', 'babygym'); ?></li>
                        <li><?php echo esc_html__('Sabato: 9.00 - 10.00, 11.00 - 12.00', 'babygym'); ?></li>
                    </ul>
                </div>

                <div class="card">
                    <h3><?php echo esc_html__('FLIPS (6-9 anni)', 'babygym'); ?></h3>
                    <ul class="corsi-list">
                        <li><?php echo esc_html__('Lunedì: 18.30 - 19.30', 'babygym'); ?></li>
                        <li><?php echo esc_html__('Giovedì: 17.30 - 18.30', 'babygym'); ?></li>
                        <li><?php echo esc_html__('Sabato: 12.00 - 13.00', 'babygym'); ?></li>
                    </ul>
                </div>
            </div>
        </section>

        <section class="corsi-section card card--centered">
            <h2><?php echo esc_html__('Corsi Baby Gym nelle scuole', 'babygym'); ?></h2>
            <p><?php echo esc_html__('Con il progetto', 'babygym'); ?> <span class="feste-key"><?php echo esc_html__('On Wheels', 'babygym'); ?></span> <?php echo esc_html__('riusciamo ad utilizzare i nostri programmi Baby Gym negli asili nido, scuole materne e scuole elementari.', 'babygym'); ?></p>
            <p><?php echo esc_html__('Grazie al', 'babygym'); ?> <span class="feste-key"><?php echo esc_html__('furgone Baby Gym', 'babygym'); ?></span> <?php echo esc_html__('portiamo il set di attrezzature che ci permette di montare un percorso ginnico direttamente nei locali dedicati della scuola.', 'babygym'); ?></p>
            <p><?php echo esc_html__('In questo modo la lezione sarà dedicata all\'intero gruppo classe oppure a diversi gruppi di pari età provenienti da classi diverse.', 'babygym'); ?></p>
            <p><?php echo esc_html__('Per maggiori informazioni contattaci!', 'babygym'); ?></p>
            <h3><?php echo esc_html__('Asili nido e scuole materne', 'babygym'); ?></h3>
            <ul class="corsi-list corsi-list--centered">
                <li><?php echo esc_html__('Andersen', 'babygym'); ?></li>
                <li><?php echo esc_html__('Scuola materna Via d\'Arborea', 'babygym'); ?></li>
                <li><?php echo esc_html__('Scuola Materna Berta', 'babygym'); ?></li>
                <li><?php echo esc_html__('Nido di Peo e Pea', 'babygym'); ?></li>
                <li><?php echo esc_html__('Il pulcino ballerino', 'babygym'); ?></li>
                <li><?php echo esc_html__('Thaon di Revel - V Lombardore', 'babygym'); ?></li>
            </ul>
        </section>
    </article>
</main>
<?php
get_footer();
