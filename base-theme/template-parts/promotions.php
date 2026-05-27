<?php
/**
 * Template part: Promotions section.
 *
 * @package MonolietStarter
 */

$today = date('Y-m-d');

$promos = new WP_Query(array(
    'post_type'      => 'promotion',
    'posts_per_page' => 4,
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

if (!$promos->have_posts()) {
    return;
}
?>

<section id="section-promotions" class="section">
    <div class="container">
        <div class="section__header">
            <h2 class="section__title"><?php esc_html_e('Promotions', 'monoliet-starter'); ?></h2>
        </div>

        <div class="grid grid--2">
            <?php while ($promos->have_posts()) : $promos->the_post(); ?>
                <?php
                $price      = function_exists('get_field') ? get_field('promo_price') : '';
                $valid_from = function_exists('get_field') ? get_field('promo_valid_from') : '';
                $valid_to   = function_exists('get_field') ? get_field('promo_valid_to') : '';
                $cta_url    = function_exists('get_field') ? get_field('promo_cta_url') : '';
                $cta_text   = function_exists('get_field') ? get_field('promo_cta_text') : '';
                $conditions = function_exists('get_field') ? get_field('promo_conditions') : '';
                ?>
                <div class="card promo-card">
                    <span class="badge badge--accent promo-card__badge"><?php esc_html_e('Promo', 'monoliet-starter'); ?></span>

                    <?php if (has_post_thumbnail()) : ?>
                        <div class="card__image">
                            <?php the_post_thumbnail('medium_large'); ?>
                        </div>
                    <?php endif; ?>

                    <h3 class="card__title"><?php the_title(); ?></h3>

                    <?php if ($price) : ?>
                        <p class="promo-card__price"><?php echo esc_html($price); ?></p>
                    <?php endif; ?>

                    <div class="card__text">
                        <?php the_content(); ?>
                    </div>

                    <?php if ($valid_from || $valid_to) : ?>
                        <p class="promo-card__validity">
                            <?php
                            if ($valid_from && $valid_to) {
                                printf(
                                    esc_html__('Valid %s – %s', 'monoliet-starter'),
                                    esc_html(monoliet_format_date($valid_from)),
                                    esc_html(monoliet_format_date($valid_to))
                                );
                            } elseif ($valid_to) {
                                printf(esc_html__('Valid until %s', 'monoliet-starter'), esc_html(monoliet_format_date($valid_to)));
                            }
                            ?>
                        </p>
                    <?php endif; ?>

                    <?php if ($conditions) : ?>
                        <p class="text-small text-light mt-sm"><?php echo esc_html($conditions); ?></p>
                    <?php endif; ?>

                    <?php if ($cta_url && $cta_text) : ?>
                        <a href="<?php echo esc_url($cta_url); ?>" class="btn btn--primary mt-lg">
                            <?php echo esc_html($cta_text); ?>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>

<?php wp_reset_postdata(); ?>
