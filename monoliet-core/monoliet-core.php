<?php
/**
 * Plugin Name: Monoliet Core
 * Plugin URI: https://monoliet.cloud
 * Description: Essential utilities for Monoliet-managed WordPress sites.
 * Version: 1.0.0
 * Author: Monoliet.cloud
 * Author URI: https://monoliet.cloud
 * Text Domain: monoliet-core
 *
 * @package MonolietCore
 */

if (!defined('ABSPATH')) {
    exit;
}

define('MONOLIET_CORE_VERSION', '1.0.0');
define('MONOLIET_CORE_DIR', plugin_dir_path(__FILE__));
define('MONOLIET_CORE_URL', plugin_dir_url(__FILE__));

require_once MONOLIET_CORE_DIR . 'inc/booking-shortcode.php';
require_once MONOLIET_CORE_DIR . 'inc/reviews-shortcode.php';
require_once MONOLIET_CORE_DIR . 'inc/hours-shortcode.php';
require_once MONOLIET_CORE_DIR . 'inc/maintenance-api.php';
require_once MONOLIET_CORE_DIR . 'inc/admin-branding.php';

/**
 * Enqueue admin styles.
 */
function monoliet_core_admin_styles() {
    wp_enqueue_style(
        'monoliet-core-admin',
        MONOLIET_CORE_URL . 'assets/admin.css',
        array(),
        MONOLIET_CORE_VERSION
    );
}
add_action('admin_enqueue_scripts', 'monoliet_core_admin_styles');
