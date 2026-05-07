<?php
/**
 * Utilities: time parsing/formatting.
 *
 * @package BABYGYM
 */

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Normalizza un orario in formato HH:MM.
 */
function babygym_sanitize_time_value(string $value, string $fallback): string
{
    $value = trim($value);
    if (preg_match('/^([01]\d|2[0-3]):([0-5]\d)$/', $value) === 1) {
        return $value;
    }
    if (preg_match('/^([01]\d|2[0-3])\.([0-5]\d)$/', $value) === 1) {
        return str_replace('.', ':', $value);
    }

    return $fallback;
}

/**
 * Formatta un orario da HH:MM a HH.MM per il frontend.
 */
function babygym_time_to_label(string $value): string
{
    return str_replace(':', '.', $value);
}

