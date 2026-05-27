<?php
/**
 * Single post template.
 *
 * @package MonolietStarter
 */

get_header();
?>

<main id="main" class="section" role="main">
    <div class="container" style="max-width: 800px;">
        <?php while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="mb-xl">
                    <h1><?php the_title(); ?></h1>
                    <p class="text-light text-small mt-sm">
                        <?php echo esc_html(get_the_date()); ?>
                    </p>
                </header>

                <?php if (has_post_thumbnail()) : ?>
                    <div class="card__image mb-xl">
                        <?php the_post_thumbnail('large'); ?>
                    </div>
                <?php endif; ?>

                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
            </article>
        <?php endwhile; ?>
    </div>
</main>

<?php
get_footer();
