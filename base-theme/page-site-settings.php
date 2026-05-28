<?php
/**
 * Page Template: Site Settings
 *
 * ACF-only admin page. Content area hidden; all configuration
 * is done via ACF fields rendered below the editor.
 *
 * @package MonolietStarter
 * Template Name: Site Settings
 */

get_header();
?>

<main id="main" class="section" role="main">
    <div class="container">
        <h1><?php esc_html_e('Site Settings', 'monoliet-starter'); ?></h1>
        <p class="text-light"><?php esc_html_e('Use the fields below to configure site-wide settings.', 'monoliet-starter'); ?></p>
    </div>
</main>

<?php
get_footer();
