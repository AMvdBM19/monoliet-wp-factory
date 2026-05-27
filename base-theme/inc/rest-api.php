<?php
/**
 * Custom REST API endpoints.
 *
 * @package MonolietStarter
 */

/**
 * Register custom REST routes.
 */
function monoliet_register_rest_routes() {
    register_rest_route('monoliet/v1', '/site-info', array(
        'methods'             => 'GET',
        'callback'            => 'monoliet_rest_site_info',
        'permission_callback' => '__return_true',
    ));

    register_rest_route('monoliet/v1', '/team', array(
        'methods'             => 'GET',
        'callback'            => 'monoliet_rest_team',
        'permission_callback' => '__return_true',
    ));

    register_rest_route('monoliet/v1', '/promotions', array(
        'methods'             => 'GET',
        'callback'            => 'monoliet_rest_promotions',
        'permission_callback' => '__return_true',
    ));
}
add_action('rest_api_init', 'monoliet_register_rest_routes');

/**
 * GET /monoliet/v1/site-info — Public site metadata.
 */
function monoliet_rest_site_info() {
    $settings_id = monoliet_get_settings_page_id();
    $data = array(
        'name'    => monoliet_get_setting('business_name') ?: get_bloginfo('name'),
        'tagline' => monoliet_get_setting('business_tagline') ?: get_bloginfo('description'),
        'phone'   => monoliet_get_setting('business_phone'),
        'email'   => monoliet_get_setting('business_email'),
        'address' => monoliet_get_setting('business_address'),
        'city'    => monoliet_get_setting('business_city'),
        'social'  => array(
            'instagram' => monoliet_get_setting('social_instagram'),
            'facebook'  => monoliet_get_setting('social_facebook'),
            'tiktok'    => monoliet_get_setting('social_tiktok'),
            'whatsapp'  => monoliet_get_setting('social_whatsapp'),
        ),
    );

    return new WP_REST_Response($data, 200);
}

/**
 * GET /monoliet/v1/team — Team members.
 */
function monoliet_rest_team() {
    $query = new WP_Query(array(
        'post_type'      => 'team_member',
        'posts_per_page' => -1,
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
    ));

    $members = array();

    while ($query->have_posts()) {
        $query->the_post();
        $id = get_the_ID();
        $members[] = array(
            'id'          => $id,
            'name'        => get_the_title(),
            'role'        => function_exists('get_field') ? get_field('member_role', $id) : '',
            'specialties' => function_exists('get_field') ? get_field('member_specialties', $id) : '',
            'booking_url' => function_exists('get_field') ? get_field('member_booking_url', $id) : '',
            'photo'       => get_the_post_thumbnail_url($id, 'medium_large'),
            'bio'         => get_the_excerpt(),
        );
    }
    wp_reset_postdata();

    return new WP_REST_Response($members, 200);
}

/**
 * GET /monoliet/v1/promotions — Active promotions.
 */
function monoliet_rest_promotions() {
    $today = date('Y-m-d');

    $query = new WP_Query(array(
        'post_type'      => 'promotion',
        'posts_per_page' => -1,
        'meta_query'     => array(
            'relation' => 'OR',
            array(
                'key'     => 'promo_valid_to',
                'value'   => $today,
                'compare' => '>=',
                'type'    => 'DATE',
            ),
            array(
                'key'     => 'promo_valid_to',
                'compare' => 'NOT EXISTS',
            ),
        ),
    ));

    $promos = array();

    while ($query->have_posts()) {
        $query->the_post();
        $id = get_the_ID();
        $promos[] = array(
            'id'         => $id,
            'title'      => get_the_title(),
            'content'    => get_the_content(),
            'price'      => function_exists('get_field') ? get_field('promo_price', $id) : '',
            'valid_from' => function_exists('get_field') ? get_field('promo_valid_from', $id) : '',
            'valid_to'   => function_exists('get_field') ? get_field('promo_valid_to', $id) : '',
            'cta_url'    => function_exists('get_field') ? get_field('promo_cta_url', $id) : '',
            'cta_text'   => function_exists('get_field') ? get_field('promo_cta_text', $id) : '',
            'image'      => get_the_post_thumbnail_url($id, 'medium_large'),
        );
    }
    wp_reset_postdata();

    return new WP_REST_Response($promos, 200);
}
