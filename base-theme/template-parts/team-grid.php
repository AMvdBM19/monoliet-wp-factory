<?php
/**
 * Template part: Team Grid.
 *
 * @package MonolietStarter
 */

$team = new WP_Query(array(
    'post_type'      => 'team_member',
    'posts_per_page' => 12,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
));

if (!$team->have_posts()) {
    return;
}
?>

<section id="section-team" class="section">
    <div class="container">
        <div class="section__header">
            <h2 class="section__title"><?php esc_html_e('Our Team', 'monoliet-starter'); ?></h2>
        </div>

        <div class="grid grid--3">
            <?php while ($team->have_posts()) : $team->the_post(); ?>
                <?php
                $role        = function_exists('get_field') ? get_field('member_role') : '';
                $specialties = function_exists('get_field') ? get_field('member_specialties') : '';
                $booking_url = function_exists('get_field') ? get_field('member_booking_url') : '';
                ?>
                <div class="card team-card">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="team-card__image">
                            <?php the_post_thumbnail('medium_large'); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($role) : ?>
                        <p class="team-card__role"><?php echo esc_html($role); ?></p>
                    <?php endif; ?>

                    <h3 class="team-card__name"><?php the_title(); ?></h3>

                    <?php if ($specialties) : ?>
                        <p class="team-card__specialties"><?php echo esc_html($specialties); ?></p>
                    <?php endif; ?>

                    <?php if ($booking_url) : ?>
                        <a href="<?php echo esc_url($booking_url); ?>" class="btn btn--primary btn--sm mt-md">
                            <?php esc_html_e('Book', 'monoliet-starter'); ?>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>

<?php wp_reset_postdata(); ?>
