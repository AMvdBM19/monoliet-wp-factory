<?php
/**
 * Front page template.
 *
 * Assembles template parts conditionally — sections with no content do not render.
 *
 * @package MonolietStarter
 */

get_header();
?>

<main id="main" role="main">
    <?php
    if (function_exists('get_field') && get_field('hero_heading')) {
        get_template_part('template-parts/hero');
    }

    if (function_exists('get_field') && get_field('proof_rating_score')) {
        get_template_part('template-parts/social-proof');
    }

    $team_query = new WP_Query(array('post_type' => 'team_member', 'posts_per_page' => 1));
    if ($team_query->have_posts()) {
        get_template_part('template-parts/team-grid');
    }
    wp_reset_postdata();

    $services_page = get_page_by_path('services');
    if ($services_page) {
        get_template_part('template-parts/services');
    }

    $promo_query = new WP_Query(array('post_type' => 'promotion', 'posts_per_page' => 1));
    if ($promo_query->have_posts()) {
        get_template_part('template-parts/promotions');
    }
    wp_reset_postdata();

    $testimonial_query = new WP_Query(array('post_type' => 'testimonial', 'posts_per_page' => 1));
    if ($testimonial_query->have_posts()) {
        get_template_part('template-parts/testimonials');
    }
    wp_reset_postdata();

    $portfolio_query = new WP_Query(array('post_type' => 'portfolio_item', 'posts_per_page' => 1));
    if ($portfolio_query->have_posts()) {
        get_template_part('template-parts/portfolio-grid');
    }
    wp_reset_postdata();

    get_template_part('template-parts/contact');

    if (function_exists('get_field') && get_field('cta_heading')) {
        get_template_part('template-parts/cta-banner');
    }
    ?>
</main>

<?php
get_footer();
