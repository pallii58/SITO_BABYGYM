<?php
/**
 * Footer globale (tutte le pagine tranne la manutenzione pubblica).
 *
 * @package BABYGYM
 */

if (! defined('ABSPATH')) {
    exit;
}
?>
    <footer class="site-footer">
        <div class="site-footer__inner">
            <p class="site-footer__company"><?php echo esc_html__('Baby Gym s.r.l. S.S.D.', 'babygym'); ?></p>
            <p class="site-footer__social-title"><?php echo esc_html__('Seguici sui social network', 'babygym'); ?></p>
            <ul class="site-footer__social">
                <li><a href="<?php echo esc_url('https://www.linkedin.com/in/pierluigi-begni-76258779/'); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html__('LinkedIn', 'babygym'); ?></a></li>
                <li><a href="<?php echo esc_url('https://www.instagram.com/babygym_torino/'); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html__('Instagram', 'babygym'); ?></a></li>
                <li><a href="<?php echo esc_url('https://www.facebook.com/babygymtorino'); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html__('Facebook', 'babygym'); ?></a></li>
            </ul>
            <p class="site-footer__contact">
                <a href="tel:+39011503484">011 / 503484</a>
                <span aria-hidden="true"> · </span>
                <a href="tel:+393473038255">347 / 3038255</a>
            </p>
            <p class="site-footer__contact">
                <a href="mailto:babygym.to@gmail.com">babygym.to@gmail.com</a>
            </p>
            <p class="site-footer__address"><?php echo esc_html__('Via Vespucci 36 - 10129 Torino', 'babygym'); ?></p>
            <p class="site-footer__tag"><?php echo esc_html__('Fitness English & Fun', 'babygym'); ?></p>
            <p class="site-footer__tagline"><?php echo esc_html__('Baby Gym - Fitness, English & Fun!', 'babygym'); ?></p>
            <p class="site-footer__sub"><?php echo esc_html__('La prima palestra per bambini da 4 mesi a 10 anni', 'babygym'); ?></p>
            <p class="site-footer__copy"><?php echo esc_html__('Tutti i diritti riservati a Baby Gym s.r.l. S.S.D.', 'babygym'); ?></p>
        </div>
    </footer>
</div><!-- #page -->
<?php wp_footer(); ?>
</body>
</html>
