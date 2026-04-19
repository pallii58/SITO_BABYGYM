<?php
/**
 * Main template file.
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
    <style>
        body {
            margin: 0;
            min-height: 100vh;
            background: #f6f8fb;
            color: #1e293b;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, "Helvetica Neue", Arial, sans-serif;
            text-align: center;
        }
        .babygym-page {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .maintenance-box {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            max-width: 760px;
            width: 100%;
            margin: 0 auto;
            padding: 2rem 1.25rem;
            box-sizing: border-box;
        }
        .maintenance-box img {
            max-width: 100%;
            height: auto;
            margin-bottom: 1.5rem;
        }
        .maintenance-title {
            margin: 0 0 .75rem;
            font-size: clamp(1.6rem, 3vw, 2.3rem);
            font-weight: 700;
        }
        .maintenance-text {
            margin: 0;
            line-height: 1.6;
            font-size: 1.05rem;
        }
        .phone {
            display: inline-block;
            margin-top: .35rem;
            font-weight: 700;
            color: #0f172a;
            text-decoration: none;
        }
        .phone:hover {
            text-decoration: underline;
        }
        .site-footer {
            width: 100%;
            margin-top: auto;
            padding: 2rem 1.25rem 2.5rem;
            border-top: 1px solid #e2e8f0;
            background: #eef2f7;
            color: #334155;
            font-size: .95rem;
            line-height: 1.55;
            box-sizing: border-box;
        }
        .site-footer__inner {
            max-width: 640px;
            margin: 0 auto;
        }
        .site-footer__company {
            margin: 0 0 .5rem;
            font-weight: 700;
            color: #0f172a;
            font-size: 1rem;
        }
        .site-footer__social-title {
            margin: 1rem 0 .35rem;
            font-size: .9rem;
            font-weight: 600;
            color: #475569;
        }
        .site-footer__social {
            list-style: none;
            margin: 0 0 1rem;
            padding: 0;
            display: flex;
            flex-wrap: wrap;
            gap: .5rem 1rem;
            justify-content: center;
        }
        .site-footer__social a {
            color: #0f766e;
            font-weight: 600;
            text-decoration: none;
        }
        .site-footer__social a:hover {
            text-decoration: underline;
        }
        .site-footer__contact {
            margin: 0 0 .75rem;
        }
        .site-footer__contact a {
            color: #0f172a;
            font-weight: 600;
            text-decoration: none;
        }
        .site-footer__contact a:hover {
            text-decoration: underline;
        }
        .site-footer__address {
            margin: 0 0 1rem;
        }
        .site-footer__tag {
            margin: 0 0 .35rem;
            font-weight: 600;
            color: #0f172a;
        }
        .site-footer__tagline {
            margin: 0 0 .5rem;
            font-size: .98rem;
        }
        .site-footer__sub {
            margin: 0 0 1rem;
            font-size: .9rem;
            color: #475569;
        }
        .site-footer__copy {
            margin: 0;
            font-size: .82rem;
            color: #64748b;
        }
    </style>
</head>
<body <?php body_class('babygym-maintenance'); ?>>
<?php wp_body_open(); ?>
<div class="babygym-page">
<main class="maintenance-box">
    <img
        src="https://www.babygym-to.com/wp-content/uploads/2026/04/5ef292c267414b69a24cf2da48825ce76ed7a515.gif"
        alt="Logo BABYGYM"
        loading="eager"
    >
    <h1 class="maintenance-title">Sito in manutenzione</h1>
    <p class="maintenance-text">
        Per qualsiasi informazione puoi scriverci su WhatsApp:<br>
        <a class="phone" href="https://wa.me/393473038255" target="_blank" rel="noopener noreferrer">347 30 38 255</a>
    </p>
</main>
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
</div>
<?php wp_footer(); ?>
</body>
</html>
