<?php
/**
 * Template part: Portfolio Grid.
 *
 * @package MonolietStarter
 */

$portfolio = new WP_Query(array(
    'post_type'      => 'portfolio_item',
    'posts_per_page' => 8,
    'orderby'        => 'date',
    'order'          => 'DESC',
));

if (!$portfolio->have_posts()) {
    return;
}
?>

<section id="section-portfolio" class="section">
    <div class="container">
        <div class="section__header">
            <h2 class="section__title"><?php esc_html_e('Portfolio', 'monoliet-starter'); ?></h2>
        </div>

        <div class="grid grid--3">
            <?php while ($portfolio->have_posts()) : $portfolio->the_post(); ?>
                <?php
                $desc        = function_exists('get_field') ? get_field('portfolio_description') : '';
                $team_id     = function_exists('get_field') ? get_field('portfolio_team_member') : 0;
                $categories  = get_the_terms(get_the_ID(), 'portfolio_category');
                ?>
                <div class="card portfolio-card">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="portfolio-card__image">
                            <?php the_post_thumbnail('medium_large'); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($categories && !is_wp_error($categories)) : ?>
                        <div class="mb-sm">
                            <?php foreach ($categories as $cat) : ?>
                                <span class="badge badge--primary"><?php echo esc_html($cat->name); ?></span>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <h3 class="card__title"><?php the_title(); ?></h3>

                    <?php if ($desc) : ?>
                        <p class="card__text"><?php echo esc_html(monoliet_truncate($desc, 120)); ?></p>
                    <?php endif; ?>

                    <?php if ($team_id && $team_name = get_the_title($team_id)) : ?>
                        <p class="card__meta mt-sm">
                            <?php
                            printf(
                                esc_html__('By %s', 'monoliet-starter'),
                                esc_html($team_name)
                            );
                            ?>
                        </p>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>

<?php wp_reset_postdata(); ?>
