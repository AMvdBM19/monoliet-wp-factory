<?php
/**
 * Admin branding and cleanup.
 *
 * @package MonolietCore
 */

/**
 * Custom login page styling.
 */
function monoliet_core_login_styles() {
    ?>
    <style>
        body.login {
            background: #0f172a;
        }
        #login h1 a {
            background-image: none;
            font-size: 28px;
            color: #fff;
            font-weight: 700;
            text-indent: 0;
            width: auto;
            height: auto;
            text-decoration: none;
        }
        #login h1 a::after {
            content: 'Monoliet.cloud';
        }
        .login form {
            border-radius: 8px;
            border: 1px solid #1e293b;
            background: #1e293b;
        }
        .login form label,
        .login form .user-pass-wrap label {
            color: #cbd5e1;
        }
        .login form input[type="text"],
        .login form input[type="password"] {
            background: #0f172a;
            border-color: #334155;
            color: #f1f5f9;
        }
        .wp-core-ui .button-primary {
            background: #2563eb;
            border-color: #2563eb;
        }
        .wp-core-ui .button-primary:hover {
            background: #1d4ed8;
            border-color: #1d4ed8;
        }
        .login #backtoblog a,
        .login #nav a {
            color: #94a3b8;
        }
        .login #backtoblog a:hover,
        .login #nav a:hover {
            color: #fff;
        }
        .login .message,
        .login .success {
            border-left-color: #2563eb;
        }
    </style>
    <?php
}
add_action('login_enqueue_scripts', 'monoliet_core_login_styles');

/**
 * Change login logo URL to site home.
 */
function monoliet_core_login_url() {
    return home_url('/');
}
add_filter('login_headerurl', 'monoliet_core_login_url');

/**
 * Custom admin footer text.
 */
function monoliet_core_admin_footer($text) {
    return '<span id="footer-thankyou">' . esc_html__('Managed by', 'monoliet-core') . ' <a href="https://monoliet.cloud" target="_blank">Monoliet.cloud</a></span>';
}
add_filter('admin_footer_text', 'monoliet_core_admin_footer');

/**
 * Remove unnecessary dashboard widgets for non-admins.
 */
function monoliet_core_remove_dashboard_widgets() {
    if (current_user_can('manage_options')) {
        return;
    }

    remove_meta_box('dashboard_primary', 'dashboard', 'side');
    remove_meta_box('dashboard_secondary', 'dashboard', 'side');
    remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
    remove_meta_box('dashboard_right_now', 'dashboard', 'normal');
    remove_meta_box('dashboard_activity', 'dashboard', 'normal');
    remove_meta_box('dashboard_site_health', 'dashboard', 'normal');
}
add_action('wp_dashboard_setup', 'monoliet_core_remove_dashboard_widgets');

/**
 * Remove Yoast SEO nag notices.
 */
function monoliet_core_remove_yoast_nags() {
    if (class_exists('Yoast_Notification_Center')) {
        $center = Yoast_Notification_Center::get();
        if (method_exists($center, 'remove_notification_by_id')) {
            remove_action('admin_notices', array($center, 'display_notifications'));
            remove_action('all_admin_notices', array($center, 'display_notifications'));
        }
    }

    // Also suppress the specific Yoast admin notice classes
    add_filter('wpseo_enable_notification_post_trash', '__return_false');
    add_filter('wpseo_enable_notification_post_slug_change', '__return_false');
    add_filter('wpseo_enable_notification_term_delete', '__return_false');
    add_filter('wpseo_enable_notification_term_slug_change', '__return_false');
}
add_action('admin_init', 'monoliet_core_remove_yoast_nags', 99);

/**
 * Disable admin email verification prompt.
 */
add_filter('admin_email_check_interval', '__return_false');
