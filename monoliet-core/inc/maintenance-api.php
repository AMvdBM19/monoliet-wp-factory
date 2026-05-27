<?php
/**
 * Maintenance REST API endpoints.
 *
 * @package MonolietCore
 */

/**
 * Register maintenance API routes.
 */
function monoliet_core_register_api() {
    register_rest_route('monoliet/v1', '/health', array(
        'methods'             => 'GET',
        'callback'            => 'monoliet_core_health_check',
        'permission_callback' => '__return_true',
    ));

    register_rest_route('monoliet/v1', '/reviews', array(
        'methods'             => 'POST',
        'callback'            => 'monoliet_core_store_reviews',
        'permission_callback' => 'monoliet_core_verify_api_key',
    ));
}
add_action('rest_api_init', 'monoliet_core_register_api');

/**
 * GET /monoliet/v1/health — Public health check.
 */
function monoliet_core_health_check() {
    $active_plugins = array();
    foreach (get_option('active_plugins', array()) as $plugin_file) {
        $plugin_data = get_plugin_data(WP_PLUGIN_DIR . '/' . $plugin_file, false, false);
        $active_plugins[] = array(
            'name'    => $plugin_data['Name'],
            'version' => $plugin_data['Version'],
        );
    }

    $theme = wp_get_theme();

    $upload_dir = wp_upload_dir();
    $disk_usage = 0;
    $upload_path = $upload_dir['basedir'];
    if (is_dir($upload_path)) {
        $output = array();
        @exec("du -sm " . escapeshellarg($upload_path) . " 2>/dev/null", $output);
        if (!empty($output[0])) {
            $disk_usage = intval($output[0]);
        }
    }

    return new WP_REST_Response(array(
        'wp_version'     => get_bloginfo('version'),
        'php_version'    => phpversion(),
        'active_plugins' => $active_plugins,
        'theme'          => $theme->get('Name') . ' ' . $theme->get('Version'),
        'disk_usage_mb'  => $disk_usage,
        'uptime_seconds' => time() - intval(get_option('monoliet_boot_time', time())),
        'site_url'       => get_site_url(),
    ), 200);
}

/**
 * POST /monoliet/v1/reviews — Store Google reviews in transient.
 */
function monoliet_core_store_reviews($request) {
    $body = $request->get_json_params();

    if (!is_array($body)) {
        return new WP_REST_Response(array('error' => 'Invalid JSON body'), 400);
    }

    $reviews = array();
    foreach ($body as $item) {
        $reviews[] = array(
            'name'   => sanitize_text_field($item['name'] ?? ''),
            'rating' => intval($item['rating'] ?? 0),
            'text'   => sanitize_textarea_field($item['text'] ?? ''),
            'date'   => sanitize_text_field($item['date'] ?? ''),
            'source' => sanitize_text_field($item['source'] ?? 'Google'),
        );
    }

    set_transient('monoliet_reviews_cache', $reviews, 30 * DAY_IN_SECONDS);

    return new WP_REST_Response(array(
        'stored' => count($reviews),
        'expiry' => '30 days',
    ), 200);
}

/**
 * Verify X-API-Key header against stored key.
 */
function monoliet_core_verify_api_key($request) {
    $provided = $request->get_header('X-API-Key');
    $stored   = defined('MONOLIET_API_KEY') ? MONOLIET_API_KEY : get_option('monoliet_api_key', '');

    if (empty($stored) || empty($provided)) {
        return false;
    }

    return hash_equals($stored, $provided);
}

/**
 * Track boot time for uptime calculation.
 */
function monoliet_core_track_boot() {
    if (!get_option('monoliet_boot_time')) {
        update_option('monoliet_boot_time', time(), false);
    }
}
add_action('init', 'monoliet_core_track_boot');
