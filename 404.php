<?php
/**
 * Pagina 404.
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
            <h1 class="feste-hero__title"><?php echo esc_html__('404 - Pagina non trovata', 'babygym'); ?></h1>
            <p class="filosofia-lead"><?php echo esc_html__('La pagina che stai cercando non esiste o è stata spostata.', 'babygym'); ?></p>
        </section>

        <section class="feste-section card card--centered">
            <p><?php echo esc_html__('Puoi tornare alla home oppure visitare una delle pagine principali.', 'babygym'); ?></p>
            <p>
                <a class="btn-primary" href="<?php echo esc_url(home_url('/')); ?>"><?php echo esc_html__('Torna alla Home', 'babygym'); ?></a>
            </p>
            <p>
                <a class="btn-secondary" href="<?php echo esc_url(home_url('/corsi')); ?>"><?php echo esc_html__('Corsi', 'babygym'); ?></a>
                <a class="btn-secondary" href="<?php echo esc_url(home_url('/summer-camps')); ?>"><?php echo esc_html__('Summer Camps', 'babygym'); ?></a>
                <a class="btn-secondary" href="<?php echo esc_url(home_url('/contatti')); ?>"><?php echo esc_html__('Contatti', 'babygym'); ?></a>
            </p>
        </section>
    </article>
</main>
<?php
get_footer();
