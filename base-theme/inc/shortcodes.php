<?php
/**
 * Theme shortcodes.
 *
 * @package MonolietStarter
 */

/**
 * [monoliet_team] — Renders the team grid anywhere.
 */
function monoliet_team_shortcode($atts) {
    $atts = shortcode_atts(array(
        'count'    => -1,
        'columns'  => 3,
        'specialty' => '',
    ), $atts, 'monoliet_team');

    $args = array(
        'post_type'      => 'team_member',
        'posts_per_page' => intval($atts['count']),
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
    );

    if (!empty($atts['specialty'])) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'specialty',
                'field'    => 'slug',
                'terms'    => sanitize_text_field($atts['specialty']),
            ),
        );
    }

    $query = new WP_Query($args);

    if (!$query->have_posts()) {
        return '';
    }

    $cols = intval($atts['columns']);
    $grid_class = 'grid grid--' . min($cols, 4);

    ob_start();
    echo '<div class="' . esc_attr($grid_class) . '">';
    while ($query->have_posts()) {
        $query->the_post();
        get_template_part('template-parts/team-grid', 'card');
    }
    echo '</div>';
    wp_reset_postdata();

    return ob_get_clean();
}
add_shortcode('monoliet_team', 'monoliet_team_shortcode');

/**
 * [monoliet_testimonials] — Renders testimonials grid.
 */
function monoliet_testimonials_shortcode($atts) {
    $atts = shortcode_atts(array(
        'count' => 6,
    ), $atts, 'monoliet_testimonials');

    $query = new WP_Query(array(
        'post_type'      => 'testimonial',
        'posts_per_page' => intval($atts['count']),
        'orderby'        => 'date',
        'order'          => 'DESC',
    ));

    if (!$query->have_posts()) {
        return '';
    }

    ob_start();
    echo '<div class="grid grid--3">';
    while ($query->have_posts()) {
        $query->the_post();
        $rating = function_exists('get_field') ? get_field('testimonial_rating') : 0;
        $source = function_exists('get_field') ? get_field('testimonial_source') : '';
        ?>
        <div class="card testimonial-card">
            <?php if ($rating) : ?>
                <div class="stars mb-md">
                    <?php for ($i = 1; $i <= 5; $i++) : ?>
                        <svg class="stars__icon <?php echo $i > $rating ? 'stars__icon--empty' : ''; ?>" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                    <?php endfor; ?>
                </div>
            <?php endif; ?>
            <p class="testimonial-card__text"><?php the_content(); ?></p>
            <p class="testimonial-card__author"><?php the_title(); ?></p>
            <?php if ($source) : ?>
                <p class="testimonial-card__source"><?php echo esc_html($source); ?></p>
            <?php endif; ?>
        </div>
        <?php
    }
    echo '</div>';
    wp_reset_postdata();

    return ob_get_clean();
}
add_shortcode('monoliet_testimonials', 'monoliet_testimonials_shortcode');

/**
 * [monoliet_portfolio] — Renders portfolio grid.
 */
function monoliet_portfolio_shortcode($atts) {
    $atts = shortcode_atts(array(
        'count'    => 8,
        'category' => '',
    ), $atts, 'monoliet_portfolio');

    $args = array(
        'post_type'      => 'portfolio_item',
        'posts_per_page' => intval($atts['count']),
        'orderby'        => 'date',
        'order'          => 'DESC',
    );

    if (!empty($atts['category'])) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'portfolio_category',
                'field'    => 'slug',
                'terms'    => sanitize_text_field($atts['category']),
            ),
        );
    }

    $query = new WP_Query($args);

    if (!$query->have_posts()) {
        return '';
    }

    ob_start();
    echo '<div class="grid grid--3">';
    while ($query->have_posts()) {
        $query->the_post();
        $desc = function_exists('get_field') ? get_field('portfolio_description') : '';
        ?>
        <div class="card portfolio-card">
            <?php if (has_post_thumbnail()) : ?>
                <div class="portfolio-card__image">
                    <?php the_post_thumbnail('medium_large'); ?>
                </div>
            <?php endif; ?>
            <h3 class="card__title"><?php the_title(); ?></h3>
            <?php if ($desc) : ?>
                <p class="card__text"><?php echo esc_html($desc); ?></p>
            <?php endif; ?>
        </div>
        <?php
    }
    echo '</div>';
    wp_reset_postdata();

    return ob_get_clean();
}
add_shortcode('monoliet_portfolio', 'monoliet_portfolio_shortcode');

/**
 * [monoliet_promotions] — Renders current promotions.
 */
function monoliet_promotions_shortcode($atts) {
    $atts = shortcode_atts(array(
        'count' => 4,
    ), $atts, 'monoliet_promotions');

    $today = date('Y-m-d');

    $query = new WP_Query(array(
        'post_type'      => 'promotion',
        'posts_per_page' => intval($atts['count']),
        'meta_query'     => array(
            'relation' => 'OR',
            array(
                'key'     => 'promo_valid_to',
                'value'   => $today,
                'compare' => '>=',
                'type'    => 'DATE',
            ),
            array(
                'key'     => 'promo_valid_to',
                'compare' => 'NOT EXISTS',
            ),
        ),
    ));

    if (!$query->have_posts()) {
        return '';
    }

    ob_start();
    echo '<div class="grid grid--2">';
    while ($query->have_posts()) {
        $query->the_post();
        get_template_part('template-parts/promotions', 'card');
    }
    echo '</div>';
    wp_reset_postdata();

    return ob_get_clean();
}
add_shortcode('monoliet_promotions', 'monoliet_promotions_shortcode');
