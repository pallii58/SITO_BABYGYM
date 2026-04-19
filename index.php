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
            display: grid;
            place-items: center;
            background: #f6f8fb;
            color: #1e293b;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, "Helvetica Neue", Arial, sans-serif;
            text-align: center;
        }
        .maintenance-box {
            max-width: 760px;
            padding: 2rem;
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
    </style>
</head>
<body <?php body_class('babygym-maintenance'); ?>>
<?php wp_body_open(); ?>
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
<?php wp_footer(); ?>
</body>
</html>
