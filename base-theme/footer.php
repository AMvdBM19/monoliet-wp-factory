<?php
/**
 * Footer template.
 *
 * @package MonolietStarter
 */

$business_name  = monoliet_get_setting('business_name') ?: get_bloginfo('name');
$business_phone = monoliet_get_setting('business_phone');
$business_email = monoliet_get_setting('business_email');
$business_addr  = monoliet_get_setting('business_address');
$business_city  = monoliet_get_setting('business_city');
$business_zip   = monoliet_get_setting('business_postal_code');
$footer_credit  = monoliet_get_setting('footer_credit') ?: __('Website door Monoliet.cloud', 'monoliet-starter');

$social_ig  = monoliet_get_setting('social_instagram');
$social_fb  = monoliet_get_setting('social_facebook');
$social_tt  = monoliet_get_setting('social_tiktok');
$social_wa  = monoliet_get_setting('social_whatsapp');
?>

<footer class="site-footer" role="contentinfo">
    <div class="container">
        <div class="site-footer__grid">
            <div class="site-footer__col">
                <div class="site-footer__brand">
                    <?php if (has_custom_logo()) : ?>
                        <?php the_custom_logo(); ?>
                    <?php else : ?>
                        <h3 class="site-footer__heading"><?php echo esc_html($business_name); ?></h3>
                    <?php endif; ?>
                </div>
                <?php if ($tagline = monoliet_get_setting('business_tagline')) : ?>
                    <p class="site-footer__brand-text"><?php echo esc_html($tagline); ?></p>
                <?php endif; ?>
                <div class="site-footer__social">
                    <?php if ($social_ig) : ?>
                        <a href="<?php echo esc_url($social_ig); ?>" target="_blank" rel="noopener noreferrer" aria-label="Instagram">IG</a>
                    <?php endif; ?>
                    <?php if ($social_fb) : ?>
                        <a href="<?php echo esc_url($social_fb); ?>" target="_blank" rel="noopener noreferrer" aria-label="Facebook">FB</a>
                    <?php endif; ?>
                    <?php if ($social_tt) : ?>
                        <a href="<?php echo esc_url($social_tt); ?>" target="_blank" rel="noopener noreferrer" aria-label="TikTok">TT</a>
                    <?php endif; ?>
                    <?php if ($social_wa) : ?>
                        <a href="https://wa.me/<?php echo esc_attr(preg_replace('/[^0-9]/', '', $social_wa)); ?>" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp">WA</a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="site-footer__col">
                <h4 class="site-footer__heading"><?php esc_html_e('Quick links', 'monoliet-starter'); ?></h4>
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'footer',
                    'container'      => false,
                    'menu_class'     => 'site-footer__links',
                    'fallback_cb'    => false,
                    'depth'          => 1,
                ));
                ?>
            </div>

            <div class="site-footer__col">
                <h4 class="site-footer__heading"><?php esc_html_e('Contact', 'monoliet-starter'); ?></h4>
                <div class="site-footer__contact">
                    <?php if ($business_addr) : ?>
                        <p><?php echo esc_html($business_addr); ?><?php
                            if ($business_zip || $business_city) {
                                echo '<br>' . esc_html(trim($business_zip . ' ' . $business_city));
                            }
                        ?></p>
                    <?php endif; ?>
                    <?php if ($business_phone) : ?>
                        <p><a href="tel:<?php echo esc_attr(preg_replace('/[^+0-9]/', '', $business_phone)); ?>"><?php echo esc_html($business_phone); ?></a></p>
                    <?php endif; ?>
                    <?php if ($business_email) : ?>
                        <p><a href="mailto:<?php echo esc_attr($business_email); ?>"><?php echo esc_html($business_email); ?></a></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="site-footer__bottom">
            <span>&copy; <?php echo esc_html(date('Y') . ' ' . $business_name); ?></span>
            <span><?php echo esc_html($footer_credit); ?></span>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
