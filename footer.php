<?php
/**
 * Footer globale (tutte le pagine tranne la manutenzione pubblica).
 *
 * @package BABYGYM
 */

if (! defined('ABSPATH')) {
    exit;
}

$babygym_logo = 'https://www.babygym-to.com/wp-content/uploads/2026/04/5ef292c267414b69a24cf2da48825ce76ed7a515.gif';

$babygym_url_regolamento = 'https://bgmsweb.azurewebsites.net/TermsCond/ShowRegolamento';
$babygym_url_privacy    = 'https://bgmsweb.azurewebsites.net/TermsCond/ShowPrivacy';
?>
    <footer class="site-footer">
        <div class="site-footer__grid">
            <div class="site-footer__col site-footer__col--left">
                <p class="site-footer__heading"><?php echo esc_html__('Contatti e social', 'babygym'); ?></p>
                <p class="site-footer__social-title"><?php echo esc_html__('Seguici sui social network', 'babygym'); ?></p>
                <ul class="site-footer__social">
                    <li><a href="<?php echo esc_url('https://www.linkedin.com/in/pierluigi-begni-76258779/'); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html__('LinkedIn', 'babygym'); ?></a></li>
                    <li><a href="<?php echo esc_url('https://www.instagram.com/babygym_torino/'); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html__('Instagram', 'babygym'); ?></a></li>
                    <li><a href="<?php echo esc_url('https://www.facebook.com/babygymtorino'); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html__('Facebook', 'babygym'); ?></a></li>
                </ul>
                <p class="site-footer__contact">
                    <a href="tel:+39011503484">011 / 503484</a><br>
                    <a href="tel:+393473038255">347 / 3038255</a>
                </p>
                <p class="site-footer__contact">
                    <a href="mailto:babygym.to@gmail.com">babygym.to@gmail.com</a>
                </p>
                <p class="site-footer__address"><?php echo esc_html__('Via Vespucci 36 - 10129 Torino', 'babygym'); ?></p>
            </div>

            <div class="site-footer__col site-footer__col--center">
                <a class="site-footer__logo-link" href="<?php echo esc_url(home_url('/')); ?>">
                    <img
                        class="site-footer__logo"
                        src="<?php echo esc_url($babygym_logo); ?>"
                        alt="<?php echo esc_attr__('Baby Gym', 'babygym'); ?>"
                        width="200"
                        height="200"
                        loading="lazy"
                        decoding="async"
                    >
                </a>
                <p class="site-footer__tag"><?php echo esc_html__('Fitness English & Fun', 'babygym'); ?></p>
                <p class="site-footer__tagline"><?php echo esc_html__('Baby Gym - Fitness, English & Fun!', 'babygym'); ?></p>
                <p class="site-footer__sub"><?php echo esc_html__('La prima palestra per bambini da 4 mesi a 10 anni', 'babygym'); ?></p>
            </div>

            <div class="site-footer__col site-footer__col--right">
                <p class="site-footer__heading"><?php echo esc_html__('Informazioni legali', 'babygym'); ?></p>
                <p class="site-footer__legal-name"><?php echo esc_html__('Baby Gym s.r.l. S.S.D.', 'babygym'); ?></p>
                <nav class="site-footer__legal-nav" aria-label="<?php echo esc_attr__('Documenti legali', 'babygym'); ?>">
                    <ul class="site-footer__legal-links">
                        <li>
                            <a href="<?php echo esc_url($babygym_url_regolamento); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html__('Regolamento Baby Gym', 'babygym'); ?></a>
                        </li>
                        <li>
                            <a href="<?php echo esc_url($babygym_url_privacy); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html__('Informativa sulla Privacy', 'babygym'); ?></a>
                        </li>
                    </ul>
                </nav>
                <p class="site-footer__copy"><?php echo esc_html__('Tutti i diritti riservati a Baby Gym s.r.l. S.S.D.', 'babygym'); ?></p>
            </div>
        </div>
    </footer>
</div><!-- #page -->
<?php wp_footer(); ?>
</body>
</html>
