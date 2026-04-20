<?php
/**
 * Pagina "Lo Staff".
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
            <h1 class="feste-hero__title"><?php echo esc_html__('Lo staff', 'babygym'); ?></h1>
            <p class="filosofia-lead"><span class="feste-key"><?php echo esc_html__('I fondatori', 'babygym'); ?></span></p>
        </section>

        <section class="filosofia-section card card--centered">
            <h2 class="section-title text-center"><?php echo esc_html__('Lo staff', 'babygym'); ?></h2>
            <p class="filosofia-lead"><?php echo esc_html__('Vuoi lavorare con noi? Contattaci!', 'babygym'); ?> <a class="feste-key" href="<?php echo esc_url(home_url('/contatti')); ?>">/contatti</a></p>
            <p><?php echo esc_html__('Tutti gli istruttori Baby Gym sono', 'babygym'); ?> <span class="feste-key"><?php echo esc_html__('qualificati', 'babygym'); ?></span> <?php echo esc_html__('grazie a', 'babygym'); ?> <span class="feste-key"><?php echo esc_html__('corsi e tirocini', 'babygym'); ?></span> <?php echo esc_html__('fatti presso la nostra sede.', 'babygym'); ?></p>
            <p><?php echo esc_html__('Ognuno di loro ha un personale curriculum formativo e, nella maggior parte dei casi,', 'babygym'); ?> <span class="feste-key"><?php echo esc_html__('diploma o laurea in scienze motorie', 'babygym'); ?></span>.</p>
        </section>
    </article>
</main>
<?php
get_footer();
