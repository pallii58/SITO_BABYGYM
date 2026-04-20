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

$contact_status = isset($_GET['contact_status']) ? sanitize_key(wp_unslash($_GET['contact_status'])) : '';
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
                <p class="contatti-links"><span class="feste-key"><?php echo esc_html__('Telefono fisso:', 'babygym'); ?></span> <a href="tel:+39011503484">011 / 503484</a></p>
                <p class="contatti-links"><span class="feste-key"><?php echo esc_html__('Cellulare:', 'babygym'); ?></span> <a href="tel:+393473038255">347 / 3038255</a></p>
                <p class="contatti-links"><span class="feste-key"><?php echo esc_html__('Email:', 'babygym'); ?></span> <a href="mailto:babygym.to@gmail.com">babygym.to@gmail.com</a></p>
                <p><span class="feste-key"><?php echo esc_html__('Indirizzo:', 'babygym'); ?></span> Via Vespucci 36 - 10129 Torino</p>
            </div>

            <div class="card card--soft">
                <h2><?php echo esc_html__('Social', 'babygym'); ?></h2>
                <ul class="contatti-social">
                    <li><a href="<?php echo esc_url('https://www.linkedin.com/in/pierluigi-begni-76258779/'); ?>" target="_blank" rel="noopener noreferrer"><img src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/icons/linkedin.svg" alt="" aria-hidden="true">LinkedIn</a></li>
                    <li><a href="<?php echo esc_url('https://www.instagram.com/babygym_torino/'); ?>" target="_blank" rel="noopener noreferrer"><img src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/icons/instagram.svg" alt="" aria-hidden="true">Instagram</a></li>
                    <li><a href="<?php echo esc_url('https://www.facebook.com/babygymtorino'); ?>" target="_blank" rel="noopener noreferrer"><img src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/icons/facebook.svg" alt="" aria-hidden="true">Facebook</a></li>
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
                <?php if ('ok' === $contact_status) : ?>
                    <p class="contatti-form__notice contatti-form__notice--ok"><?php echo esc_html__('Messaggio inviato correttamente. Ti risponderemo al più presto!', 'babygym'); ?></p>
                <?php elseif ('invalid' === $contact_status) : ?>
                    <p class="contatti-form__notice contatti-form__notice--error"><?php echo esc_html__('Controlla email e messaggio prima di inviare.', 'babygym'); ?></p>
                <?php elseif ('error' === $contact_status) : ?>
                    <p class="contatti-form__notice contatti-form__notice--error"><?php echo esc_html__('Invio non riuscito. Riprova tra poco.', 'babygym'); ?></p>
                <?php endif; ?>

                <form class="contatti-form" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
                    <input type="hidden" name="action" value="babygym_send_contact">
                    <?php wp_nonce_field('babygym_contact_submit', 'babygym_contact_nonce'); ?>
                    <label for="contatti-email"><?php echo esc_html__('La tua email:', 'babygym'); ?></label>
                    <input type="email" id="contatti-email" name="email" placeholder="nome@email.com" required>

                    <label for="contatti-message"><?php echo esc_html__('Messaggio:', 'babygym'); ?></label>
                    <textarea id="contatti-message" name="messaggio" rows="6" required></textarea>

                    <button type="submit" class="btn-primary"><?php echo esc_html__('Invia', 'babygym'); ?></button>
                </form>
                <div class="contatti-job">
                    <h3><?php echo esc_html__('Diventa istruttore Baby Gym', 'babygym'); ?></h3>
                    <p><?php echo esc_html__('Invia il tuo cv a', 'babygym'); ?> <a class="feste-key" href="mailto:babygym_to@fastwebnet.it">babygym_to@fastwebnet.it</a></p>
                </div>
            </div>
        </section>
    </article>
</main>
<?php
get_footer();
