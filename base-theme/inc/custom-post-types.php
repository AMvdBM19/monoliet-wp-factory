<?php
/**
 * Custom Post Types and Taxonomies.
 *
 * @package MonolietStarter
 */

/**
 * Register CPTs and taxonomies.
 */
function monoliet_register_post_types() {
    // ── Team Members ──
    register_post_type('team_member', array(
        'labels' => array(
            'name'               => __('Team Members', 'monoliet-starter'),
            'singular_name'      => __('Team Member', 'monoliet-starter'),
            'add_new'            => __('Add Team Member', 'monoliet-starter'),
            'add_new_item'       => __('Add New Team Member', 'monoliet-starter'),
            'edit_item'          => __('Edit Team Member', 'monoliet-starter'),
            'new_item'           => __('New Team Member', 'monoliet-starter'),
            'view_item'          => __('View Team Member', 'monoliet-starter'),
            'search_items'       => __('Search Team Members', 'monoliet-starter'),
            'not_found'          => __('No team members found.', 'monoliet-starter'),
            'not_found_in_trash' => __('No team members in trash.', 'monoliet-starter'),
        ),
        'public'       => true,
        'has_archive'  => false,
        'menu_icon'    => 'dashicons-groups',
        'supports'     => array('title', 'editor', 'thumbnail'),
        'rewrite'      => array('slug' => 'team'),
        'show_in_rest' => true,
    ));

    register_taxonomy('specialty', 'team_member', array(
        'labels' => array(
            'name'          => __('Specialties', 'monoliet-starter'),
            'singular_name' => __('Specialty', 'monoliet-starter'),
            'add_new_item'  => __('Add Specialty', 'monoliet-starter'),
        ),
        'hierarchical'  => true,
        'public'        => true,
        'show_in_rest'  => true,
        'rewrite'       => array('slug' => 'specialty'),
    ));

    // ── Promotions ──
    register_post_type('promotion', array(
        'labels' => array(
            'name'               => __('Promotions', 'monoliet-starter'),
            'singular_name'      => __('Promotion', 'monoliet-starter'),
            'add_new'            => __('Add Promotion', 'monoliet-starter'),
            'add_new_item'       => __('Add New Promotion', 'monoliet-starter'),
            'edit_item'          => __('Edit Promotion', 'monoliet-starter'),
            'new_item'           => __('New Promotion', 'monoliet-starter'),
            'view_item'          => __('View Promotion', 'monoliet-starter'),
            'search_items'       => __('Search Promotions', 'monoliet-starter'),
            'not_found'          => __('No promotions found.', 'monoliet-starter'),
            'not_found_in_trash' => __('No promotions in trash.', 'monoliet-starter'),
        ),
        'public'       => true,
        'has_archive'  => false,
        'menu_icon'    => 'dashicons-tag',
        'supports'     => array('title', 'editor', 'thumbnail'),
        'rewrite'      => array('slug' => 'promotions'),
        'show_in_rest' => true,
    ));

    // ── Testimonials ──
    register_post_type('testimonial', array(
        'labels' => array(
            'name'               => __('Testimonials', 'monoliet-starter'),
            'singular_name'      => __('Testimonial', 'monoliet-starter'),
            'add_new'            => __('Add Testimonial', 'monoliet-starter'),
            'add_new_item'       => __('Add New Testimonial', 'monoliet-starter'),
            'edit_item'          => __('Edit Testimonial', 'monoliet-starter'),
            'new_item'           => __('New Testimonial', 'monoliet-starter'),
            'view_item'          => __('View Testimonial', 'monoliet-starter'),
            'search_items'       => __('Search Testimonials', 'monoliet-starter'),
            'not_found'          => __('No testimonials found.', 'monoliet-starter'),
            'not_found_in_trash' => __('No testimonials in trash.', 'monoliet-starter'),
        ),
        'public'       => true,
        'has_archive'  => false,
        'menu_icon'    => 'dashicons-format-quote',
        'supports'     => array('title', 'editor'),
        'rewrite'      => array('slug' => 'testimonials'),
        'show_in_rest' => true,
    ));

    // ── Portfolio Items ──
    register_post_type('portfolio_item', array(
        'labels' => array(
            'name'               => __('Portfolio', 'monoliet-starter'),
            'singular_name'      => __('Portfolio Item', 'monoliet-starter'),
            'add_new'            => __('Add Portfolio Item', 'monoliet-starter'),
            'add_new_item'       => __('Add New Portfolio Item', 'monoliet-starter'),
            'edit_item'          => __('Edit Portfolio Item', 'monoliet-starter'),
            'new_item'           => __('New Portfolio Item', 'monoliet-starter'),
            'view_item'          => __('View Portfolio Item', 'monoliet-starter'),
            'search_items'       => __('Search Portfolio', 'monoliet-starter'),
            'not_found'          => __('No portfolio items found.', 'monoliet-starter'),
            'not_found_in_trash' => __('No portfolio items in trash.', 'monoliet-starter'),
        ),
        'public'       => true,
        'has_archive'  => true,
        'menu_icon'    => 'dashicons-portfolio',
        'supports'     => array('title', 'thumbnail'),
        'rewrite'      => array('slug' => 'portfolio'),
        'show_in_rest' => true,
    ));

    register_taxonomy('portfolio_category', 'portfolio_item', array(
        'labels' => array(
            'name'          => __('Portfolio Categories', 'monoliet-starter'),
            'singular_name' => __('Portfolio Category', 'monoliet-starter'),
            'add_new_item'  => __('Add Category', 'monoliet-starter'),
        ),
        'hierarchical'  => true,
        'public'        => true,
        'show_in_rest'  => true,
        'rewrite'       => array('slug' => 'portfolio-category'),
    ));
}
add_action('init', 'monoliet_register_post_types');
