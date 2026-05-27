<?php
/**
 * 404 template.
 *
 * @package MonolietStarter
 */

get_header();
?>

<main id="main" class="section" role="main">
    <div class="container" style="text-align: center; min-height: 60vh; display: flex; flex-direction: column; align-items: center; justify-content: center;">
        <h1><?php esc_html_e('404', 'monoliet-starter'); ?></h1>
        <p class="text-light mt-md mb-xl" style="font-size: var(--font-size-lg);">
            <?php esc_html_e('Sorry, the page you are looking for could not be found.', 'monoliet-starter'); ?>
        </p>
        <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn--primary">
            <?php esc_html_e('Back to home', 'monoliet-starter'); ?>
        </a>
    </div>
</main>

<?php
get_footer();
