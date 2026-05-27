<?php
/**
 * Monoliet Starter — Theme Functions
 *
 * @package MonolietStarter
 */

define('MONOLIET_THEME_VERSION', '1.0.0');
define('MONOLIET_THEME_DIR', get_template_directory());
define('MONOLIET_THEME_URI', get_template_directory_uri());

require_once MONOLIET_THEME_DIR . '/inc/acf-fields.php';
require_once MONOLIET_THEME_DIR . '/inc/custom-post-types.php';
require_once MONOLIET_THEME_DIR . '/inc/shortcodes.php';
require_once MONOLIET_THEME_DIR . '/inc/rest-api.php';
require_once MONOLIET_THEME_DIR . '/inc/helpers.php';

/**
 * Theme setup.
 */
function monoliet_setup() {
    load_theme_textdomain('monoliet-starter', MONOLIET_THEME_DIR . '/languages');

    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo', array(
        'height'      => 80,
        'width'       => 250,
        'flex-height' => true,
        'flex-width'  => true,
    ));
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));

    register_nav_menus(array(
        'primary' => __('Primary Menu', 'monoliet-starter'),
        'footer'  => __('Footer Menu', 'monoliet-starter'),
    ));
}
add_action('after_setup_theme', 'monoliet_setup');

/**
 * Enqueue styles and scripts.
 */
function monoliet_scripts() {
    $google_fonts_url = 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap';
    wp_enqueue_style('monoliet-google-fonts', $google_fonts_url, array(), null);

    wp_enqueue_style('monoliet-base', MONOLIET_THEME_URI . '/assets/css/base.css', array('monoliet-google-fonts'), MONOLIET_THEME_VERSION);
    wp_enqueue_style('monoliet-components', MONOLIET_THEME_URI . '/assets/css/components.css', array('monoliet-base'), MONOLIET_THEME_VERSION);
    wp_enqueue_style('monoliet-client', MONOLIET_THEME_URI . '/assets/css/client.css', array('monoliet-components'), MONOLIET_THEME_VERSION);
    wp_enqueue_style('monoliet-style', get_stylesheet_uri(), array('monoliet-client'), MONOLIET_THEME_VERSION);

    wp_enqueue_script('monoliet-main', MONOLIET_THEME_URI . '/assets/js/main.js', array(), MONOLIET_THEME_VERSION, true);
}
add_action('wp_enqueue_scripts', 'monoliet_scripts');

/**
 * Register the Site Settings page template.
 */
function monoliet_add_page_templates($templates) {
    $templates['page-site-settings.php'] = __('Site Settings', 'monoliet-starter');
    return $templates;
}
add_filter('theme_page_templates', 'monoliet_add_page_templates');

/**
 * Get the Site Settings page ID.
 */
function monoliet_get_settings_page_id() {
    $pages = get_pages(array(
        'meta_key'   => '_wp_page_template',
        'meta_value' => 'page-site-settings.php',
        'number'     => 1,
    ));

    if (!empty($pages)) {
        return $pages[0]->ID;
    }

    return 0;
}

/**
 * Get a Site Settings field value.
 */
function monoliet_get_setting($field_name) {
    $page_id = monoliet_get_settings_page_id();

    if ($page_id && function_exists('get_field')) {
        return get_field($field_name, $page_id);
    }

    return '';
}

/**
 * Disable the Gutenberg editor for the Site Settings template.
 */
function monoliet_disable_gutenberg_for_settings($use_block_editor, $post) {
    if (!empty($post->ID)) {
        $template = get_post_meta($post->ID, '_wp_page_template', true);
        if ($template === 'page-site-settings.php') {
            return false;
        }
    }
    return $use_block_editor;
}
add_filter('use_block_editor_for_post', 'monoliet_disable_gutenberg_for_settings', 10, 2);
