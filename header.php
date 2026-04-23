<?php
/**
 * Header tema (pagine normali, non manutenzione pubblica).
 *
 * @package BABYGYM
 */

if (! defined('ABSPATH')) {
    exit;
}
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
    <header class="site-header">
        <div class="site-header__inner">
            <a class="site-header__brand" href="<?php echo esc_url(home_url('/')); ?>">
                <img
                    src="<?php echo esc_url('https://www.babygym-to.com/wp-content/uploads/2026/04/5ef292c267414b69a24cf2da48825ce76ed7a515.gif'); ?>"
                    alt="<?php echo esc_attr__('Baby Gym', 'babygym'); ?>"
                    width="150"
                    height="56"
                    loading="eager"
                    decoding="async"
                >
            </a>
            <button
                type="button"
                class="site-header__menu-toggle"
                aria-expanded="false"
                aria-controls="site-header-mobile-panel"
                aria-label="<?php echo esc_attr__('Apri menu', 'babygym'); ?>"
            >
                <span></span>
                <span></span>
                <span></span>
            </button>
            <div class="site-header__mobile-panel" id="site-header-mobile-panel">
                <nav class="site-header__nav" aria-label="<?php echo esc_attr__('Navigazione principale', 'babygym'); ?>">
                    <ul class="site-header__menu">
                        <li><a href="<?php echo esc_url(home_url('/')); ?>"><?php echo esc_html__('Home', 'babygym'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/corsi')); ?>"><?php echo esc_html__('Corsi', 'babygym'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/summer-camps')); ?>"><?php echo esc_html__('Summer Camps', 'babygym'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/le-feste')); ?>"><?php echo esc_html__('Le Feste', 'babygym'); ?></a></li>
                        <li class="site-header__menu-item--has-submenu">
                            <a href="#" aria-haspopup="true"><?php echo esc_html__('Chi siamo', 'babygym'); ?></a>
                            <ul class="site-header__submenu">
                                <li><a href="<?php echo esc_url(home_url('/filosofia')); ?>"><?php echo esc_html__('Filosofia', 'babygym'); ?></a></li>
                                <li><a href="<?php echo esc_url(home_url('/galleria')); ?>"><?php echo esc_html__('Galleria', 'babygym'); ?></a></li>
                            </ul>
                        </li>
                        <li><a href="<?php echo esc_url(home_url('/contatti')); ?>"><?php echo esc_html__('Contatti', 'babygym'); ?></a></li>
                    </ul>
                </nav>
                <div class="site-header__auth">
                    <a class="site-header__auth-btn site-header__auth-btn--register" href="<?php echo esc_url('https://bgmsweb.azurewebsites.net/webregistration'); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html__('Registrati', 'babygym'); ?></a>
                    <a class="site-header__auth-btn site-header__auth-btn--login" href="<?php echo esc_url('https://bgmsweb.azurewebsites.net/login'); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html__('Accedi', 'babygym'); ?></a>
                </div>
            </div>
        </div>
    </header>
<script>
    window.addEventListener('load', function () {
        const toggle = document.querySelector('.site-header__menu-toggle');
        const panel = document.getElementById('site-header-mobile-panel');
        if (!toggle || !panel) return;

        const closeMenu = () => {
            document.body.classList.remove('site-header-menu-open');
            toggle.setAttribute('aria-expanded', 'false');
        };
        const openMenu = () => {
            document.body.classList.add('site-header-menu-open');
            toggle.setAttribute('aria-expanded', 'true');
        };

        toggle.addEventListener('click', function () {
            if (document.body.classList.contains('site-header-menu-open')) {
                closeMenu();
                return;
            }
            openMenu();
        });

        panel.querySelectorAll('a').forEach(function (link) {
            link.addEventListener('click', closeMenu);
        });

        window.addEventListener('resize', function () {
            if (window.innerWidth > 768) closeMenu();
        });
    });
</script>
