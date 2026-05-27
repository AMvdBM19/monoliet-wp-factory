<?php
/**
 * Template part: Services section.
 *
 * Renders the content of the "Services" page as a section on the front page.
 *
 * @package MonolietStarter
 */

$services_page = get_page_by_path('services');

if (!$services_page) {
    return;
}
?>

<section id="section-services" class="section section--alt">
    <div class="container">
        <div class="section__header">
            <h2 class="section__title"><?php echo esc_html($services_page->post_title); ?></h2>
            <?php if ($services_page->post_excerpt) : ?>
                <p class="section__subtitle"><?php echo esc_html($services_page->post_excerpt); ?></p>
            <?php endif; ?>
        </div>

        <div class="entry-content">
            <?php echo apply_filters('the_content', $services_page->post_content); ?>
        </div>
    </div>
</section>
