<?php
/**
 * Pagina "Contatti".
 *
 * @package BABYGYM
 */

if (! defined('ABSPATH')) {
    exit;
}

get_header();
?>
<main id="primary" class="site-main site-main--wide">
    <article class="contatti-page">
        <section class="contatti-hero card card--centered">
            <p class="feste-eyebrow"><?php echo esc_html__('Baby Gym Torino', 'babygym'); ?></p>
            <h1 class="feste-hero__title"><?php echo esc_html__('Contatti', 'babygym'); ?></h1>
        </section>

        <section class="contatti-section contatti-grid">
            <div class="card">
                <h2><?php echo esc_html__('Contatti Baby Gym', 'babygym'); ?></h2>
                <p><span class="feste-key"><?php echo esc_html__('Telefono fisso:', 'babygym'); ?></span> <a href="tel:+39011503484">011 / 503484</a></p>
                <p><span class="feste-key"><?php echo esc_html__('Cellulare:', 'babygym'); ?></span> <a href="tel:+393473038255">347 / 3038255</a></p>
                <p><span class="feste-key"><?php echo esc_html__('Email:', 'babygym'); ?></span> <a href="mailto:babygym.to@gmail.com">babygym.to@gmail.com</a></p>
                <p><span class="feste-key"><?php echo esc_html__('Indirizzo:', 'babygym'); ?></span> Via Vespucci 36 - 10129 Torino</p>
            </div>

            <div class="card card--soft">
                <h2><?php echo esc_html__('Social', 'babygym'); ?></h2>
                <ul class="contatti-social">
                    <li><a href="<?php echo esc_url('https://www.linkedin.com/in/pierluigi-begni-76258779/'); ?>" target="_blank" rel="noopener noreferrer">LinkedIn</a></li>
                    <li><a href="<?php echo esc_url('https://www.instagram.com/babygym_torino/'); ?>" target="_blank" rel="noopener noreferrer">Instagram</a></li>
                    <li><a href="<?php echo esc_url('https://www.facebook.com/babygymtorino'); ?>" target="_blank" rel="noopener noreferrer">Facebook</a></li>
                </ul>
            </div>
        </section>

        <section class="contatti-section">
            <div class="card">
                <h2 class="text-center"><?php echo esc_html__('Mappa', 'babygym'); ?></h2>
                <div class="contatti-map">
                    <iframe
                        title="<?php echo esc_attr__('Mappa Baby Gym Torino', 'babygym'); ?>"
                        src="https://maps.google.com/maps?q=Via%20Vespucci%2036%2C%20Torino&t=&z=15&ie=UTF8&iwloc=&output=embed"
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                    ></iframe>
                </div>
            </div>
        </section>

        <section class="contatti-section">
            <div class="card">
                <h2 class="text-center"><?php echo esc_html__('Scrivici', 'babygym'); ?></h2>
                <p class="text-center"><?php echo esc_html__('Per informazioni inserisci il tuo indirizzo di posta elettronica, lasciaci un messaggio e premi Invia! Risponderemo al più presto!', 'babygym'); ?></p>
                <form class="contatti-form" action="mailto:babygym.to@gmail.com" method="post" enctype="text/plain">
                    <label for="contatti-email"><?php echo esc_html__('La tua email:', 'babygym'); ?></label>
                    <input type="email" id="contatti-email" name="email" placeholder="nome@email.com" required>

                    <label for="contatti-message"><?php echo esc_html__('Messaggio:', 'babygym'); ?></label>
                    <textarea id="contatti-message" name="messaggio" rows="6" required></textarea>

                    <button type="submit" class="btn-primary"><?php echo esc_html__('Invia', 'babygym'); ?></button>
                </form>
            </div>
        </section>
    </article>
</main>
<?php
get_footer();
