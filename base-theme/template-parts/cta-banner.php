<?php
/**
 * Template part: CTA Banner.
 *
 * @package MonolietStarter
 */

$heading     = get_field('cta_heading');
$subtext     = get_field('cta_subtext');
$button_text = get_field('cta_button_text');
$button_url  = get_field('cta_button_url');

if (!$heading) {
    return;
}
?>

<section id="section-cta" class="section section--dark">
    <div class="container" style="text-align: center; max-width: 700px;">
        <h2 style="color: var(--color-text-inverse);"><?php echo esc_html($heading); ?></h2>

        <?php if ($subtext) : ?>
            <p class="mt-md mb-xl" style="font-size: var(--font-size-lg); opacity: 0.9;">
                <?php echo esc_html($subtext); ?>
            </p>
        <?php endif; ?>

        <?php if ($button_text && $button_url) : ?>
            <a href="<?php echo esc_url($button_url); ?>" class="btn btn--accent btn--lg">
                <?php echo esc_html($button_text); ?>
            </a>
        <?php endif; ?>
    </div>
</section>
