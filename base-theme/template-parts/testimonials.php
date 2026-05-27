<?php
/**
 * Template part: Testimonials section.
 *
 * @package MonolietStarter
 */

$testimonials = new WP_Query(array(
    'post_type'      => 'testimonial',
    'posts_per_page' => 6,
    'orderby'        => 'date',
    'order'          => 'DESC',
));

if (!$testimonials->have_posts()) {
    return;
}
?>

<section id="section-testimonials" class="section section--alt">
    <div class="container">
        <div class="section__header">
            <h2 class="section__title"><?php esc_html_e('What Our Clients Say', 'monoliet-starter'); ?></h2>
        </div>

        <div class="grid grid--3">
            <?php while ($testimonials->have_posts()) : $testimonials->the_post(); ?>
                <?php
                $rating = function_exists('get_field') ? get_field('testimonial_rating') : 0;
                $source = function_exists('get_field') ? get_field('testimonial_source') : '';
                $date   = function_exists('get_field') ? get_field('testimonial_date') : '';
                ?>
                <div class="card testimonial-card">
                    <?php if ($rating) : ?>
                        <?php echo monoliet_render_stars($rating); ?>
                    <?php endif; ?>

                    <p class="testimonial-card__text">
                        &ldquo;<?php echo esc_html(monoliet_truncate(get_the_content(), 250)); ?>&rdquo;
                    </p>

                    <p class="testimonial-card__author"><?php the_title(); ?></p>

                    <?php if ($source || $date) : ?>
                        <p class="testimonial-card__source">
                            <?php
                            $parts = array();
                            if ($source) $parts[] = esc_html($source);
                            if ($date) $parts[] = esc_html(monoliet_format_date($date));
                            echo implode(' &middot; ', $parts);
                            ?>
                        </p>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>

<?php wp_reset_postdata(); ?>
