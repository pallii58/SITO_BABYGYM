<?php
/**
 * Contact form handler.
 *
 * @package BABYGYM
 */

if (! defined('ABSPATH')) {
    exit;
}

add_action('admin_post_nopriv_babygym_send_contact', 'babygym_handle_contact_form');
add_action('admin_post_babygym_send_contact', 'babygym_handle_contact_form');

/**
 * Gestione invio form contatti.
 */
function babygym_handle_contact_form(): void
{
    if (! isset($_POST['babygym_contact_nonce']) || ! wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['babygym_contact_nonce'])), 'babygym_contact_submit')) {
        wp_safe_redirect(add_query_arg('contact_status', 'invalid', wp_get_referer() ?: home_url('/contatti')));
        exit;
    }

    $email_raw   = isset($_POST['email']) ? wp_unslash($_POST['email']) : '';
    $message_raw = isset($_POST['messaggio']) ? wp_unslash($_POST['messaggio']) : '';

    $email   = sanitize_email($email_raw);
    $message = sanitize_textarea_field($message_raw);

    if ('' === $email || '' === $message || ! is_email($email)) {
        wp_safe_redirect(add_query_arg('contact_status', 'invalid', wp_get_referer() ?: home_url('/contatti')));
        exit;
    }

    $to      = 'babygym.to@gmail.com';
    $subject = 'Nuovo messaggio dal modulo Contatti - Baby Gym';
    $body    = "Email mittente: {$email}\n\nMessaggio:\n{$message}";
    $headers = [
        'Content-Type: text/plain; charset=UTF-8',
        'Reply-To: ' . $email,
        'Cc: gabrieletoma17@gmail.com',
    ];

    $sent = wp_mail($to, $subject, $body, $headers);

    wp_safe_redirect(add_query_arg('contact_status', $sent ? 'ok' : 'error', wp_get_referer() ?: home_url('/contatti')));
    exit;
}

