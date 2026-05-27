<?php
/**
 * Template part: Contact section.
 *
 * @package MonolietStarter
 */

$phone   = monoliet_get_setting('business_phone');
$email   = monoliet_get_setting('business_email');
$address = monoliet_get_setting('business_address');
$city    = monoliet_get_setting('business_city');
$zip     = monoliet_get_setting('business_postal_code');
$maps    = monoliet_get_setting('business_maps_embed');
$wa      = monoliet_get_setting('social_whatsapp');

$has_info = $phone || $email || $address;
?>

<section id="section-contact" class="section section--alt">
    <div class="container">
        <div class="section__header">
            <h2 class="section__title"><?php esc_html_e('Contact', 'monoliet-starter'); ?></h2>
        </div>

        <div class="grid grid--2">
            <div>
                <?php if ($phone) : ?>
                    <div class="mb-lg">
                        <h4><?php esc_html_e('Phone', 'monoliet-starter'); ?></h4>
                        <p><a href="<?php echo esc_url(monoliet_phone_link($phone)); ?>"><?php echo esc_html($phone); ?></a></p>
                    </div>
                <?php endif; ?>

                <?php if ($email) : ?>
                    <div class="mb-lg">
                        <h4><?php esc_html_e('Email', 'monoliet-starter'); ?></h4>
                        <p><a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a></p>
                    </div>
                <?php endif; ?>

                <?php if ($address) : ?>
                    <div class="mb-lg">
                        <h4><?php esc_html_e('Address', 'monoliet-starter'); ?></h4>
                        <p>
                            <?php echo esc_html($address); ?>
                            <?php if ($zip || $city) : ?>
                                <br><?php echo esc_html(trim($zip . ' ' . $city)); ?>
                            <?php endif; ?>
                        </p>
                    </div>
                <?php endif; ?>

                <?php if ($wa) : ?>
                    <a href="https://wa.me/<?php echo esc_attr(preg_replace('/[^0-9]/', '', $wa)); ?>" class="btn btn--primary" target="_blank" rel="noopener">
                        <?php esc_html_e('WhatsApp', 'monoliet-starter'); ?>
                    </a>
                <?php endif; ?>
            </div>

            <div>
                <?php if ($maps) : ?>
                    <div class="contact-map">
                        <?php echo $maps; ?>
                    </div>
                    <style>
                        .contact-map iframe {
                            width: 100%;
                            height: 350px;
                            border: 0;
                            border-radius: var(--radius-lg);
                        }
                    </style>
                <?php elseif (!$has_info) : ?>
                    <p class="text-light"><?php esc_html_e('Contact information will appear here once configured in Site Settings.', 'monoliet-starter'); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
