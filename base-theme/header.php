<?php
/**
 * Header template.
 *
 * @package MonolietStarter
 */

$cta_text    = monoliet_get_setting('business_phone');
$cta_url     = $cta_text ? 'tel:' . preg_replace('/[^+0-9]/', '', $cta_text) : '';
$lang_switch = monoliet_get_setting('enable_lang_switcher');
$default_lang = monoliet_get_setting('default_language') ?: 'nl';
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header" role="banner">
    <div class="container site-header__inner">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="site-header__logo" rel="home">
            <?php if (has_custom_logo()) : ?>
                <?php the_custom_logo(); ?>
            <?php else : ?>
                <span class="custom-logo-text"><?php bloginfo('name'); ?></span>
            <?php endif; ?>
        </a>

        <nav class="site-header__nav" role="navigation" aria-label="<?php esc_attr_e('Primary Menu', 'monoliet-starter'); ?>">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'container'      => false,
                'fallback_cb'    => false,
            ));
            ?>
        </nav>

        <div class="site-header__actions">
            <?php if ($lang_switch) : ?>
                <div class="lang-switcher">
                    <a href="?lang=nl" class="lang-switcher__link <?php echo ($default_lang === 'nl') ? 'is-active' : ''; ?>">NL</a>
                    <span class="lang-switcher__sep">|</span>
                    <a href="?lang=en" class="lang-switcher__link <?php echo ($default_lang === 'en') ? 'is-active' : ''; ?>">EN</a>
                </div>
            <?php endif; ?>

            <?php if ($cta_text) : ?>
                <a href="<?php echo esc_url($cta_url); ?>" class="btn btn--primary btn--sm site-header__cta">
                    <?php echo esc_html($cta_text); ?>
                </a>
            <?php endif; ?>

            <button class="site-header__hamburger" aria-label="<?php esc_attr_e('Open menu', 'monoliet-starter'); ?>" aria-expanded="false">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </div>
</header>

<div class="mobile-drawer__overlay" aria-hidden="true"></div>
<aside class="mobile-drawer" aria-label="<?php esc_attr_e('Mobile menu', 'monoliet-starter'); ?>">
    <button class="mobile-drawer__close" aria-label="<?php esc_attr_e('Close menu', 'monoliet-starter'); ?>">&times;</button>
    <?php
    wp_nav_menu(array(
        'theme_location' => 'primary',
        'container'      => false,
        'fallback_cb'    => false,
    ));
    ?>
    <?php if ($cta_text) : ?>
        <div class="mobile-drawer__cta">
            <a href="<?php echo esc_url($cta_url); ?>" class="btn btn--primary btn--full">
                <?php echo esc_html($cta_text); ?>
            </a>
        </div>
    <?php endif; ?>
</aside>
