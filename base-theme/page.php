<?php
/**
 * Default page template.
 *
 * @package MonolietStarter
 */

get_header();
?>

<main id="main" class="section" role="main">
    <div class="container">
        <?php while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="section__header" style="text-align: left;">
                    <h1 class="section__title"><?php the_title(); ?></h1>
                </header>
                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
            </article>
        <?php endwhile; ?>
    </div>
</main>

<?php
get_footer();
