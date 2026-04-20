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
?>
<main id="primary" class="site-main site-main--wide">
    <article class="filosofia-page">
        <section class="filosofia-hero card card--centered">
            <p class="feste-eyebrow"><?php echo esc_html__('Baby Gym Torino', 'babygym'); ?></p>
            <h1 class="feste-hero__title"><?php echo esc_html__('Summer camps - Estate al Baby Gym', 'babygym'); ?></h1>
            <p class="filosofia-lead"><?php echo esc_html__('Attività estive per bambini da 3 a 9 anni', 'babygym'); ?></p>
        </section>

        <section class="filosofia-section card">
            <p><?php echo esc_html__('Le attività estive Baby Gym hanno come obiettivo lo sviluppo delle capacità fisico-motorie, intellettuali e di socializzazione dei bambini.', 'babygym'); ?></p>
            <p><?php echo esc_html__('Attraverso la ginnastica, i giochi e la musica, crescere imparando diventerà un divertimento! E divertendoci impareremo anche le prime parole di', 'babygym'); ?> <span class="feste-key"><?php echo esc_html__('Inglese', 'babygym'); ?></span>!</p>
            <p><?php echo esc_html__('Insieme trascorreremo allegre mattinate con tanta', 'babygym'); ?> <span class="feste-key"><?php echo esc_html__('GINNASTICA', 'babygym'); ?></span>, <span class="feste-key"><?php echo esc_html__('ESERCIZI', 'babygym'); ?></span>, <?php echo esc_html__('avventurosi', 'babygym'); ?> <span class="feste-key"><?php echo esc_html__('PERCORSI', 'babygym'); ?></span>, <span class="feste-key"><?php echo esc_html__('GIOCHI DI GRUPPO', 'babygym'); ?></span><?php echo esc_html__('! ed altre attività creative durante le quali potremo colorare, ritagliare, incollare, ecc...', 'babygym'); ?></p>
            <p><?php echo esc_html__('Tutto questo ci aiuterà a raggiungere un corretto sviluppo motorio ed anche a vincere insicurezze e paure ed acquisire maggiore fiducia in noi stessi in un ambiente non competitivo per favorire la cooperazione nel gruppo ed insegnare ai più piccini che non è indispensabile essere sempre i migliori: l\'importante è fare del proprio meglio!', 'babygym'); ?></p>
            <p><?php echo esc_html__('Ogni settimana utilizzeremo un diverso', 'babygym'); ?> <span class="feste-key"><?php echo esc_html__('Tema di Lezione', 'babygym'); ?></span> <?php echo esc_html__('(pirati, olimpiadi, ecc...) per rendere tutto ancora più curioso ed emozionante!!!', 'babygym'); ?></p>
            <p><?php echo esc_html__('Vedrai che divertimento! e quanto impareremo insieme!', 'babygym'); ?></p>
        </section>
    </article>
</main>
<?php
get_footer();
