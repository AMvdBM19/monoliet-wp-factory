<?php
/**
 * Template part: Hero section.
 *
 * @package MonolietStarter
 */

$heading       = get_field('hero_heading');
$subheading    = get_field('hero_subheading');
$cta_text      = get_field('hero_cta_text');
$cta_url       = get_field('hero_cta_url');
$cta2_text     = get_field('hero_secondary_cta_text');
$cta2_url      = get_field('hero_secondary_cta_url');
$bg_image      = get_field('hero_background_image');

if (!$heading) {
    return;
}

$bg_style = $bg_image ? 'background-image: url(' . esc_url($bg_image) . ');' : '';
?>

<section id="section-hero" class="section-hero" style="<?php echo esc_attr($bg_style); ?>">
    <div class="section-hero__overlay">
        <div class="container section-hero__content">
            <h1 class="section-hero__heading"><?php echo esc_html($heading); ?></h1>

            <?php if ($subheading) : ?>
                <p class="section-hero__subheading"><?php echo esc_html($subheading); ?></p>
            <?php endif; ?>

            <div class="section-hero__actions">
                <?php if ($cta_text && $cta_url) : ?>
                    <a href="<?php echo esc_url($cta_url); ?>" class="btn btn--primary btn--lg">
                        <?php echo esc_html($cta_text); ?>
                    </a>
                <?php endif; ?>

                <?php if ($cta2_text && $cta2_url) : ?>
                    <a href="<?php echo esc_url($cta2_url); ?>" class="btn btn--white btn--lg">
                        <?php echo esc_html($cta2_text); ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<style>
.section-hero {
    position: relative;
    min-height: var(--hero-min-height);
    background-color: var(--hero-bg);
    background-size: cover;
    background-position: center;
    display: flex;
    align-items: center;
}

.section-hero__overlay {
    position: absolute;
    inset: 0;
    background: var(--hero-overlay);
    display: flex;
    align-items: center;
}

.section-hero__content {
    position: relative;
    z-index: 1;
    text-align: center;
    max-width: 800px;
    margin: 0 auto;
}

.section-hero__heading {
    color: var(--hero-text);
    font-size: var(--font-size-5xl);
    margin-bottom: var(--space-lg);
}

.section-hero__subheading {
    color: var(--hero-text);
    opacity: 0.9;
    font-size: var(--font-size-xl);
    line-height: var(--line-height-relaxed);
    margin-bottom: var(--space-2xl);
}

.section-hero__actions {
    display: flex;
    justify-content: center;
    gap: var(--space-md);
    flex-wrap: wrap;
}

@media (max-width: 768px) {
    .section-hero {
        min-height: 70vh;
    }

    .section-hero__heading {
        font-size: var(--font-size-3xl);
    }

    .section-hero__subheading {
        font-size: var(--font-size-lg);
    }
}
</style>
