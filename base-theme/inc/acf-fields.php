<?php
/**
 * ACF field group registration (ACF Free compatible — no repeater, no options page).
 *
 * @package MonolietStarter
 */

if (!function_exists('acf_add_local_field_group')) {
    return;
}

/**
 * Register all field groups.
 */
function monoliet_register_acf_fields() {
    // ── Homepage Hero ──
    acf_add_local_field_group(array(
        'key'      => 'group_homepage_hero',
        'title'    => __('Homepage Hero', 'monoliet-starter'),
        'fields'   => array(
            array(
                'key'   => 'field_hero_heading',
                'label' => __('Heading', 'monoliet-starter'),
                'name'  => 'hero_heading',
                'type'  => 'text',
            ),
            array(
                'key'   => 'field_hero_subheading',
                'label' => __('Subheading', 'monoliet-starter'),
                'name'  => 'hero_subheading',
                'type'  => 'textarea',
                'rows'  => 3,
            ),
            array(
                'key'   => 'field_hero_cta_text',
                'label' => __('CTA Button Text', 'monoliet-starter'),
                'name'  => 'hero_cta_text',
                'type'  => 'text',
            ),
            array(
                'key'   => 'field_hero_cta_url',
                'label' => __('CTA Button URL', 'monoliet-starter'),
                'name'  => 'hero_cta_url',
                'type'  => 'url',
            ),
            array(
                'key'   => 'field_hero_secondary_cta_text',
                'label' => __('Secondary CTA Text', 'monoliet-starter'),
                'name'  => 'hero_secondary_cta_text',
                'type'  => 'text',
            ),
            array(
                'key'   => 'field_hero_secondary_cta_url',
                'label' => __('Secondary CTA URL', 'monoliet-starter'),
                'name'  => 'hero_secondary_cta_url',
                'type'  => 'url',
            ),
            array(
                'key'           => 'field_hero_background_image',
                'label'         => __('Background Image', 'monoliet-starter'),
                'name'          => 'hero_background_image',
                'type'          => 'image',
                'return_format' => 'url',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param'    => 'page_type',
                    'operator' => '==',
                    'value'    => 'front_page',
                ),
            ),
        ),
        'menu_order' => 0,
    ));

    // ── Social Proof Bar ──
    acf_add_local_field_group(array(
        'key'      => 'group_social_proof',
        'title'    => __('Social Proof Bar', 'monoliet-starter'),
        'fields'   => array(
            array(
                'key'          => 'field_proof_rating_score',
                'label'        => __('Rating Score', 'monoliet-starter'),
                'name'         => 'proof_rating_score',
                'type'         => 'text',
                'placeholder'  => '9.6',
            ),
            array(
                'key'          => 'field_proof_rating_source',
                'label'        => __('Rating Source', 'monoliet-starter'),
                'name'         => 'proof_rating_source',
                'type'         => 'text',
                'placeholder'  => 'Google',
            ),
            array(
                'key'   => 'field_proof_metric_1_value',
                'label' => __('Metric 1 — Value', 'monoliet-starter'),
                'name'  => 'proof_metric_1_value',
                'type'  => 'text',
            ),
            array(
                'key'   => 'field_proof_metric_1_label',
                'label' => __('Metric 1 — Label', 'monoliet-starter'),
                'name'  => 'proof_metric_1_label',
                'type'  => 'text',
            ),
            array(
                'key'   => 'field_proof_metric_2_value',
                'label' => __('Metric 2 — Value', 'monoliet-starter'),
                'name'  => 'proof_metric_2_value',
                'type'  => 'text',
            ),
            array(
                'key'   => 'field_proof_metric_2_label',
                'label' => __('Metric 2 — Label', 'monoliet-starter'),
                'name'  => 'proof_metric_2_label',
                'type'  => 'text',
            ),
            array(
                'key'   => 'field_proof_metric_3_value',
                'label' => __('Metric 3 — Value', 'monoliet-starter'),
                'name'  => 'proof_metric_3_value',
                'type'  => 'text',
            ),
            array(
                'key'   => 'field_proof_metric_3_label',
                'label' => __('Metric 3 — Label', 'monoliet-starter'),
                'name'  => 'proof_metric_3_label',
                'type'  => 'text',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param'    => 'page_type',
                    'operator' => '==',
                    'value'    => 'front_page',
                ),
            ),
        ),
        'menu_order' => 1,
    ));

    // ── CTA Banner ──
    acf_add_local_field_group(array(
        'key'      => 'group_cta_banner',
        'title'    => __('CTA Banner', 'monoliet-starter'),
        'fields'   => array(
            array(
                'key'   => 'field_cta_heading',
                'label' => __('Heading', 'monoliet-starter'),
                'name'  => 'cta_heading',
                'type'  => 'text',
            ),
            array(
                'key'   => 'field_cta_subtext',
                'label' => __('Subtext', 'monoliet-starter'),
                'name'  => 'cta_subtext',
                'type'  => 'textarea',
                'rows'  => 2,
            ),
            array(
                'key'   => 'field_cta_button_text',
                'label' => __('Button Text', 'monoliet-starter'),
                'name'  => 'cta_button_text',
                'type'  => 'text',
            ),
            array(
                'key'   => 'field_cta_button_url',
                'label' => __('Button URL', 'monoliet-starter'),
                'name'  => 'cta_button_url',
                'type'  => 'url',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param'    => 'page_type',
                    'operator' => '==',
                    'value'    => 'front_page',
                ),
            ),
        ),
        'menu_order' => 2,
    ));

    // ── Site Settings (page template) ──
    acf_add_local_field_group(array(
        'key'      => 'group_site_settings',
        'title'    => __('Site Settings', 'monoliet-starter'),
        'fields'   => array(
            // Business Info
            array(
                'key'   => 'field_business_name',
                'label' => __('Business Name', 'monoliet-starter'),
                'name'  => 'business_name',
                'type'  => 'text',
            ),
            array(
                'key'   => 'field_business_tagline',
                'label' => __('Tagline', 'monoliet-starter'),
                'name'  => 'business_tagline',
                'type'  => 'text',
            ),
            array(
                'key'   => 'field_business_phone',
                'label' => __('Phone', 'monoliet-starter'),
                'name'  => 'business_phone',
                'type'  => 'text',
            ),
            array(
                'key'   => 'field_business_email',
                'label' => __('Email', 'monoliet-starter'),
                'name'  => 'business_email',
                'type'  => 'email',
            ),
            array(
                'key'   => 'field_business_address',
                'label' => __('Address', 'monoliet-starter'),
                'name'  => 'business_address',
                'type'  => 'text',
            ),
            array(
                'key'   => 'field_business_city',
                'label' => __('City', 'monoliet-starter'),
                'name'  => 'business_city',
                'type'  => 'text',
            ),
            array(
                'key'   => 'field_business_postal_code',
                'label' => __('Postal Code', 'monoliet-starter'),
                'name'  => 'business_postal_code',
                'type'  => 'text',
            ),
            array(
                'key'          => 'field_business_maps_embed',
                'label'        => __('Google Maps Embed Code', 'monoliet-starter'),
                'name'         => 'business_maps_embed',
                'type'         => 'textarea',
                'rows'         => 3,
                'instructions' => __('Paste the full iframe embed code from Google Maps.', 'monoliet-starter'),
            ),
            // Business Hours
            array(
                'key'         => 'field_hours_monday',
                'label'       => __('Monday', 'monoliet-starter'),
                'name'        => 'hours_monday',
                'type'        => 'text',
                'placeholder' => '09:00 - 18:00',
                'instructions' => __('Format: 09:00 - 18:00 or leave blank for Closed', 'monoliet-starter'),
            ),
            array(
                'key'         => 'field_hours_tuesday',
                'label'       => __('Tuesday', 'monoliet-starter'),
                'name'        => 'hours_tuesday',
                'type'        => 'text',
                'placeholder' => '09:00 - 18:00',
                'instructions' => __('Format: 09:00 - 18:00 or leave blank for Closed', 'monoliet-starter'),
            ),
            array(
                'key'         => 'field_hours_wednesday',
                'label'       => __('Wednesday', 'monoliet-starter'),
                'name'        => 'hours_wednesday',
                'type'        => 'text',
                'placeholder' => '09:00 - 18:00',
                'instructions' => __('Format: 09:00 - 18:00 or leave blank for Closed', 'monoliet-starter'),
            ),
            array(
                'key'         => 'field_hours_thursday',
                'label'       => __('Thursday', 'monoliet-starter'),
                'name'        => 'hours_thursday',
                'type'        => 'text',
                'placeholder' => '09:00 - 18:00',
                'instructions' => __('Format: 09:00 - 18:00 or leave blank for Closed', 'monoliet-starter'),
            ),
            array(
                'key'         => 'field_hours_friday',
                'label'       => __('Friday', 'monoliet-starter'),
                'name'        => 'hours_friday',
                'type'        => 'text',
                'placeholder' => '09:00 - 18:00',
                'instructions' => __('Format: 09:00 - 18:00 or leave blank for Closed', 'monoliet-starter'),
            ),
            array(
                'key'         => 'field_hours_saturday',
                'label'       => __('Saturday', 'monoliet-starter'),
                'name'        => 'hours_saturday',
                'type'        => 'text',
                'placeholder' => '09:00 - 18:00',
                'instructions' => __('Format: 09:00 - 18:00 or leave blank for Closed', 'monoliet-starter'),
            ),
            array(
                'key'         => 'field_hours_sunday',
                'label'       => __('Sunday', 'monoliet-starter'),
                'name'        => 'hours_sunday',
                'type'        => 'text',
                'placeholder' => '09:00 - 18:00',
                'instructions' => __('Format: 09:00 - 18:00 or leave blank for Closed', 'monoliet-starter'),
            ),
            // Social
            array(
                'key'   => 'field_social_instagram',
                'label' => __('Instagram URL', 'monoliet-starter'),
                'name'  => 'social_instagram',
                'type'  => 'url',
            ),
            array(
                'key'   => 'field_social_facebook',
                'label' => __('Facebook URL', 'monoliet-starter'),
                'name'  => 'social_facebook',
                'type'  => 'url',
            ),
            array(
                'key'   => 'field_social_tiktok',
                'label' => __('TikTok URL', 'monoliet-starter'),
                'name'  => 'social_tiktok',
                'type'  => 'url',
            ),
            array(
                'key'   => 'field_social_whatsapp',
                'label' => __('WhatsApp Number', 'monoliet-starter'),
                'name'  => 'social_whatsapp',
                'type'  => 'text',
                'instructions' => __('International format, e.g. 31612345678', 'monoliet-starter'),
            ),
            // Footer / Display
            array(
                'key'           => 'field_footer_credit',
                'label'         => __('Footer Credit', 'monoliet-starter'),
                'name'          => 'footer_credit',
                'type'          => 'text',
                'default_value' => 'Website door Monoliet.cloud',
            ),
            array(
                'key'   => 'field_enable_lang_switcher',
                'label' => __('Enable Language Switcher', 'monoliet-starter'),
                'name'  => 'enable_lang_switcher',
                'type'  => 'true_false',
                'ui'    => 1,
            ),
            array(
                'key'     => 'field_default_language',
                'label'   => __('Default Language', 'monoliet-starter'),
                'name'    => 'default_language',
                'type'    => 'select',
                'choices' => array(
                    'nl' => 'Nederlands',
                    'en' => 'English',
                ),
                'default_value' => 'nl',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param'    => 'page_template',
                    'operator' => '==',
                    'value'    => 'page-site-settings.php',
                ),
            ),
        ),
        'menu_order' => 0,
    ));

    // ── Team Member fields ──
    acf_add_local_field_group(array(
        'key'      => 'group_team_member',
        'title'    => __('Team Member Details', 'monoliet-starter'),
        'fields'   => array(
            array(
                'key'   => 'field_member_role',
                'label' => __('Role / Job Title', 'monoliet-starter'),
                'name'  => 'member_role',
                'type'  => 'text',
            ),
            array(
                'key'   => 'field_member_specialties',
                'label' => __('Specialties', 'monoliet-starter'),
                'name'  => 'member_specialties',
                'type'  => 'text',
                'instructions' => __('Comma-separated list', 'monoliet-starter'),
            ),
            array(
                'key'   => 'field_member_booking_url',
                'label' => __('Booking URL', 'monoliet-starter'),
                'name'  => 'member_booking_url',
                'type'  => 'url',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'team_member',
                ),
            ),
        ),
    ));

    // ── Promotion fields ──
    acf_add_local_field_group(array(
        'key'      => 'group_promotion',
        'title'    => __('Promotion Details', 'monoliet-starter'),
        'fields'   => array(
            array(
                'key'   => 'field_promo_price',
                'label' => __('Price', 'monoliet-starter'),
                'name'  => 'promo_price',
                'type'  => 'text',
            ),
            array(
                'key'            => 'field_promo_valid_from',
                'label'          => __('Valid From', 'monoliet-starter'),
                'name'           => 'promo_valid_from',
                'type'           => 'date_picker',
                'display_format' => 'd/m/Y',
                'return_format'  => 'Y-m-d',
            ),
            array(
                'key'            => 'field_promo_valid_to',
                'label'          => __('Valid Until', 'monoliet-starter'),
                'name'           => 'promo_valid_to',
                'type'           => 'date_picker',
                'display_format' => 'd/m/Y',
                'return_format'  => 'Y-m-d',
            ),
            array(
                'key'   => 'field_promo_cta_url',
                'label' => __('CTA URL', 'monoliet-starter'),
                'name'  => 'promo_cta_url',
                'type'  => 'url',
            ),
            array(
                'key'   => 'field_promo_cta_text',
                'label' => __('CTA Text', 'monoliet-starter'),
                'name'  => 'promo_cta_text',
                'type'  => 'text',
            ),
            array(
                'key'   => 'field_promo_conditions',
                'label' => __('Conditions', 'monoliet-starter'),
                'name'  => 'promo_conditions',
                'type'  => 'textarea',
                'rows'  => 3,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'promotion',
                ),
            ),
        ),
    ));

    // ── Testimonial fields ──
    acf_add_local_field_group(array(
        'key'      => 'group_testimonial',
        'title'    => __('Testimonial Details', 'monoliet-starter'),
        'fields'   => array(
            array(
                'key'   => 'field_testimonial_rating',
                'label' => __('Rating (1–5)', 'monoliet-starter'),
                'name'  => 'testimonial_rating',
                'type'  => 'number',
                'min'   => 1,
                'max'   => 5,
            ),
            array(
                'key'   => 'field_testimonial_source',
                'label' => __('Source', 'monoliet-starter'),
                'name'  => 'testimonial_source',
                'type'  => 'text',
                'placeholder' => 'Google',
            ),
            array(
                'key'            => 'field_testimonial_date',
                'label'          => __('Date', 'monoliet-starter'),
                'name'           => 'testimonial_date',
                'type'           => 'date_picker',
                'display_format' => 'd/m/Y',
                'return_format'  => 'Y-m-d',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'testimonial',
                ),
            ),
        ),
    ));

    // ── Portfolio Item fields ──
    acf_add_local_field_group(array(
        'key'      => 'group_portfolio_item',
        'title'    => __('Portfolio Details', 'monoliet-starter'),
        'fields'   => array(
            array(
                'key'   => 'field_portfolio_description',
                'label' => __('Description', 'monoliet-starter'),
                'name'  => 'portfolio_description',
                'type'  => 'textarea',
                'rows'  => 4,
            ),
            array(
                'key'           => 'field_portfolio_team_member',
                'label'         => __('Team Member', 'monoliet-starter'),
                'name'          => 'portfolio_team_member',
                'type'          => 'post_object',
                'post_type'     => array('team_member'),
                'return_format' => 'id',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'portfolio_item',
                ),
            ),
        ),
    ));
}
add_action('acf/init', 'monoliet_register_acf_fields');
