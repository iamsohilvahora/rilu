<?php
// Register custom post type - Dealer
function wp_dealer_post_type_func(){
    register_post_type('dealer',
        // CPT Options
        array(
            'labels' => array(
                'name' => __('Dealers'),
                'singular_name' => __('Dealer')
            ),
            'public' => true,
            'has_archive' => true,
            'show_ui' => true,
            'query_var' => true,
            'menu_icon' => 'dashicons-businessperson',
            'show_in_rest' => true,
            'supports' => array('title','editor','excerpt','trackbacks','custom-fields','comments','revisions','thumbnail','author','page-attributes'),
            'show_admin_column' => true,
            'exclude_from_search' => true,
            'show_in_nav_menus'     => true,
            'show_in_admin_bar'     => true,
            'show_in_menu'          => true,
            'can_export' => true,
            'publicly_queryable'    => true,
            'hierarchical' => true,
            'capability_type' => 'post',
            'rewrite' => array('slug' => 'dealers')
        )
    );
}
add_action('init', 'wp_dealer_post_type_func');

// Register custom taxonomy - State
function wp_load_custom_taxonomy_func(){
    $labels = array(
        'name'                       => _x( 'States', 'taxonomy general name' ),
        'singular_name'              => _x( 'State', 'taxonomy singular name' ),
        'menu_name'                  => __( 'States'),
        'all_items'                  => __( 'All Items', 'text_domain' ),
        'parent_item'                => __( 'Parent Item', 'text_domain' ),
        'parent_item_colon'          => __( 'Parent Item:', 'text_domain' ),
        'new_item_name'              => __( 'New Item Name', 'text_domain' ),
        'add_new_item'               => __( 'Add New Item', 'text_domain' ),
        'edit_item'                  => __( 'Edit Item', 'text_domain' ),
        'update_item'                => __( 'Update Item', 'text_domain' ),
        'view_item'                  => __( 'View Item', 'text_domain' ),
        'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
        'add_or_remove_items'        => __( 'Add or remove items', 'text_domain' ),
        'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
        'popular_items'              => __( 'Popular Items', 'text_domain' ),
        'search_items'               => __( 'Search Items', 'text_domain' ),
        'not_found'                  => __( 'Not Found', 'text_domain' ),
        'no_terms'                   => __( 'No items', 'text_domain' ),
        'items_list'                 => __( 'Items list', 'text_domain' ),
        'items_list_navigation'      => __( 'Items list navigation', 'text_domain' ),
    );
    $args = array(
        'labels'                     => $labels,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
        //'query_var'         => true,
        'rewrite' => array('slug' => 'state'),
        'hierarchical' => true,
    );
    register_taxonomy('state', array('dealer'), $args);
}
add_action( 'init', 'wp_load_custom_taxonomy_func');