<?php
/**
 * Booking widget shortcode (Velours embed integration).
 *
 * Usage: [monoliet_booking agency="slug" color="#hex" position="bottom-right" label="Book Now"]
 *
 * @package MonolietCore
 */

/**
 * Render the booking widget shortcode.
 */
function monoliet_booking_shortcode($atts) {
    $atts = shortcode_atts(array(
        'agency'   => '',
        'color'    => '#2563eb',
        'position' => 'bottom-right',
        'label'    => __('Book Now', 'monoliet-core'),
    ), $atts, 'monoliet_booking');

    if (empty($atts['agency'])) {
        return '';
    }

    wp_enqueue_script(
        'monoliet-booking-widget',
        get_template_directory_uri() . '/assets/js/booking-widget.js',
        array(),
        MONOLIET_CORE_VERSION,
        true
    );

    return sprintf(
        '<div class="monoliet-booking-widget" data-agency="%s" data-color="%s" data-position="%s" data-label="%s"></div>',
        esc_attr($atts['agency']),
        esc_attr($atts['color']),
        esc_attr($atts['position']),
        esc_attr($atts['label'])
    );
}
add_shortcode('monoliet_booking', 'monoliet_booking_shortcode');
