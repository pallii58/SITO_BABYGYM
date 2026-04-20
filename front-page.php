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
<?php
get_footer();
