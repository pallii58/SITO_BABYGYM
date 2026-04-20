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
            <nav class="site-header__nav" aria-label="<?php echo esc_attr__('Navigazione principale', 'babygym'); ?>">
                <?php
                wp_nav_menu([
                    'theme_location' => 'primary',
                    'container'      => false,
                    'menu_class'     => 'site-header__menu',
                    'fallback_cb'    => static function (): void {
                        ?>
                        <ul class="site-header__menu">
                            <li><a href="<?php echo esc_url(home_url('/')); ?>"><?php echo esc_html__('Home', 'babygym'); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/corsi')); ?>"><?php echo esc_html__('Corsi', 'babygym'); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/le-feste')); ?>"><?php echo esc_html__('Le Feste', 'babygym'); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/filosofia')); ?>"><?php echo esc_html__('Filosofia', 'babygym'); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/contatti')); ?>"><?php echo esc_html__('Contatti', 'babygym'); ?></a></li>
                        </ul>
                        <?php
                    },
                    'depth'          => 1,
                ]);
                ?>
            </nav>
        </div>
    </header>
