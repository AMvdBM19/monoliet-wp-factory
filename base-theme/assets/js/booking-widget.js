/**
 * Monoliet Starter — Booking Widget (Velours integration)
 *
 * Loaded by the [monoliet_booking] shortcode.
 * Expects data attributes on the container element:
 *   data-agency, data-color, data-position, data-label
 */

(function () {
    'use strict';

    var containers = document.querySelectorAll('.monoliet-booking-widget');

    for (var i = 0; i < containers.length; i++) {
        var el = containers[i];
        var agency = el.getAttribute('data-agency');

        if (!agency) continue;

        var color = el.getAttribute('data-color') || '#2563eb';
        var position = el.getAttribute('data-position') || 'bottom-right';
        var label = el.getAttribute('data-label') || 'Book Now';

        var script = document.createElement('script');
        script.src = 'https://embed.velours.io/embed.js';
        script.setAttribute('data-agency', agency);
        script.setAttribute('data-color', color);
        script.setAttribute('data-position', position);
        script.setAttribute('data-label', label);
        script.async = true;

        el.appendChild(script);
    }
})();
