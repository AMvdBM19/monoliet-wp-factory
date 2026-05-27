<?php
/**
 * Theme helper functions.
 *
 * @package MonolietStarter
 */

/**
 * Render star icons for a given rating.
 */
function monoliet_render_stars($rating, $max = 5) {
    $rating = intval($rating);
    $output = '<div class="stars">';
    for ($i = 1; $i <= $max; $i++) {
        $class = $i <= $rating ? 'stars__icon' : 'stars__icon stars__icon--empty';
        $output .= '<svg class="' . esc_attr($class) . '" viewBox="0 0 20 20" aria-hidden="true"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>';
    }
    $output .= '</div>';
    return $output;
}

/**
 * Get a formatted phone link.
 */
function monoliet_phone_link($phone) {
    return 'tel:' . preg_replace('/[^+0-9]/', '', $phone);
}

/**
 * Check if ACF is active.
 */
function monoliet_has_acf() {
    return function_exists('get_field');
}

/**
 * Truncate text to a given length, preserving whole words.
 */
function monoliet_truncate($text, $length = 150) {
    $text = strip_tags($text);
    if (strlen($text) <= $length) {
        return $text;
    }
    $truncated = substr($text, 0, $length);
    $last_space = strrpos($truncated, ' ');
    if ($last_space !== false) {
        $truncated = substr($truncated, 0, $last_space);
    }
    return $truncated . '…';
}

/**
 * Format a date for display.
 */
function monoliet_format_date($date_string, $format = '') {
    if (empty($date_string)) {
        return '';
    }
    if (empty($format)) {
        $format = get_option('date_format');
    }
    $timestamp = strtotime($date_string);
    return $timestamp ? date_i18n($format, $timestamp) : '';
}
