<?php
/**
 * Google Reviews shortcode.
 *
 * Renders reviews stored in a WP transient by the maintenance API.
 * Usage: [monoliet_reviews]
 *
 * @package MonolietCore
 */

/**
 * Render cached Google reviews.
 */
function monoliet_reviews_shortcode($atts) {
    $atts = shortcode_atts(array(
        'count' => 6,
    ), $atts, 'monoliet_reviews');

    $reviews = get_transient('monoliet_reviews_cache');

    if (empty($reviews) || !is_array($reviews)) {
        return '';
    }

    $reviews = array_slice($reviews, 0, intval($atts['count']));

    ob_start();
    ?>
    <div class="monoliet-reviews grid grid--3">
        <?php foreach ($reviews as $review) : ?>
            <div class="card testimonial-card">
                <?php if (!empty($review['rating'])) : ?>
                    <div class="stars mb-md">
                        <?php for ($i = 1; $i <= 5; $i++) : ?>
                            <svg class="stars__icon <?php echo $i > intval($review['rating']) ? 'stars__icon--empty' : ''; ?>" viewBox="0 0 20 20" aria-hidden="true"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                        <?php endfor; ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($review['text'])) : ?>
                    <p class="testimonial-card__text">&ldquo;<?php echo esc_html($review['text']); ?>&rdquo;</p>
                <?php endif; ?>

                <?php if (!empty($review['name'])) : ?>
                    <p class="testimonial-card__author"><?php echo esc_html($review['name']); ?></p>
                <?php endif; ?>

                <?php
                $meta_parts = array();
                if (!empty($review['source'])) $meta_parts[] = esc_html($review['source']);
                if (!empty($review['date'])) $meta_parts[] = esc_html($review['date']);
                ?>
                <?php if (!empty($meta_parts)) : ?>
                    <p class="testimonial-card__source"><?php echo implode(' &middot; ', $meta_parts); ?></p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('monoliet_reviews', 'monoliet_reviews_shortcode');
