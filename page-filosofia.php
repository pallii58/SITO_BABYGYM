<?php
/**
 * Pagina "Filosofia".
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
            <h1 class="feste-hero__title"><?php echo esc_html__('La nostra filosofia', 'babygym'); ?></h1>
            <p class="filosofia-lead"><?php echo esc_html__('L’obiettivo del Baby Gym è di promuovere', 'babygym'); ?> <span class="feste-key"><?php echo esc_html__('allegria', 'babygym'); ?></span>, <span class="feste-key"><?php echo esc_html__('salute', 'babygym'); ?></span> <?php echo esc_html__('e', 'babygym'); ?> <span class="feste-key"><?php echo esc_html__('benessere fisico', 'babygym'); ?></span> <?php echo esc_html__('dei bambini nel mondo!!', 'babygym'); ?></p>
        </section>

        <section class="filosofia-section card">
            <p><?php echo esc_html__('Al Baby Gym i bambini imparano, divertendosi, che non è indispensabile essere sempre i migliori: l’importante è fare sempre del proprio meglio!', 'babygym'); ?></p>
            <p><?php echo esc_html__('In un ambiente', 'babygym'); ?> <span class="feste-key"><?php echo esc_html__('non competitivo', 'babygym'); ?></span> <?php echo esc_html__('in cui viene valorizzata la', 'babygym'); ?> <span class="feste-key"><?php echo esc_html__('socializzazione', 'babygym'); ?></span> <?php echo esc_html__('e la', 'babygym'); ?> <span class="feste-key"><?php echo esc_html__('cooperazione', 'babygym'); ?></span> <?php echo esc_html__('all’interno del gruppo, i bambini, con il supporto di', 'babygym'); ?> <span class="feste-key"><?php echo esc_html__('istruttori qualificati', 'babygym'); ?></span><?php echo esc_html__(', vengono incoraggiati ad affrontare piccoli rischi e a provare esercizi sempre nuovi, vincendo le proprie paure ed acquisendo così maggior sicurezza in se stessi.', 'babygym'); ?></p>
            <p><?php echo esc_html__('Al Baby Gym i bambini imparano ad amare', 'babygym'); ?> <span class="feste-key"><?php echo esc_html__('l’esercizio fisico', 'babygym'); ?></span><?php echo esc_html__(', la', 'babygym'); ?> <span class="feste-key"><?php echo esc_html__('musica', 'babygym'); ?></span> <?php echo esc_html__('ed il gioco e capiscono che', 'babygym'); ?> <span class="feste-key"><?php echo esc_html__('salute e benessere fisico', 'babygym'); ?></span> <?php echo esc_html__('vanno di pari passo con il divertimento!!!', 'babygym'); ?></p>
        </section>

        <section class="filosofia-section card card--soft">
            <h2 class="section-title text-center"><?php echo esc_html__('Grazie a questa filosofia d’insegnamento, al Baby Gym i bambini imparano a:', 'babygym'); ?></h2>
            <ul class="filosofia-list">
                <li><?php echo esc_html__('accettarsi così come sono, per quello che sono;', 'babygym'); ?></li>
                <li><?php echo esc_html__('accrescere la sicurezza e la stima di se stessi;', 'babygym'); ?></li>
                <li><?php echo esc_html__('trattare gli altri come essi stessi vorrebbero essere trattati;', 'babygym'); ?></li>
                <li><?php echo esc_html__('mangiare cibi sani e prendersi cura del proprio benessere fisico;', 'babygym'); ?></li>
                <li><?php echo esc_html__('non vergognarsi di esprimere i propri sentimenti;', 'babygym'); ?></li>
                <li><?php echo esc_html__('migliorare le proprie capacità di socializzazione e cooperazione nel gruppo;', 'babygym'); ?></li>
                <li><?php echo esc_html__('capire che nella vita non si può sempre vincere, bisogna anche saper perdere e sbagliare, ma saper imparare dai propri errori e poi provare e riprovare fino a quando non si riesce nei propri intenti !!', 'babygym'); ?></li>
            </ul>
        </section>
    </article>
</main>
<?php
get_footer();
