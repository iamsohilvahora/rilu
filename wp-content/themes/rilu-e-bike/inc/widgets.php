<?php
/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function rilu_e_bike_widgets_init(){
    register_sidebar(
        array(
            'name'          => esc_html__( 'Sidebar', 'rilu-e-bike' ),
            'id'            => 'sidebar-1',
            'description'   => esc_html__( 'Add widgets here.', 'rilu-e-bike' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        )
    );
    // Register Footer 1 widgets
    register_sidebar(
        array(
            'name'          => esc_html__( 'Footer 1', 'rilu-e-bike' ),
            'id'            => 'footer-1',
            'description'   => esc_html__( 'Add widgets here.', 'rilu-e-bike' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        )
    );
    // Register Footer 2 widgets
    register_sidebar(
        array(
            'name'          => esc_html__( 'Footer 2', 'rilu-e-bike' ),
            'id'            => 'footer-2',
            'description'   => esc_html__( 'Add widgets here.', 'rilu-e-bike' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        )
    );
    // Register Footer 3 widgets
    register_sidebar(
        array(
            'name'          => esc_html__( 'Footer 3', 'rilu-e-bike' ),
            'id'            => 'footer-3',
            'description'   => esc_html__( 'Add widgets here.', 'rilu-e-bike' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        )
    );
    // Register Footer 4 widgets
    register_sidebar(
        array(
            'name'          => esc_html__( 'Footer 4', 'rilu-e-bike' ),
            'id'            => 'footer-4',
            'description'   => esc_html__( 'Add widgets here.', 'rilu-e-bike' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        )
    );
    // Register Footer 5 widgets
    register_sidebar(
        array(
            'name'          => esc_html__( 'Footer 5', 'rilu-e-bike' ),
            'id'            => 'footer-5',
            'description'   => esc_html__( 'Add widgets here.', 'rilu-e-bike' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        )
    );
    // Register Footer 6 widgets
    register_sidebar(
        array(
            'name'          => esc_html__( 'Footer 6', 'rilu-e-bike' ),
            'id'            => 'footer-6',
            'description'   => esc_html__( 'Add widgets here.', 'rilu-e-bike' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        )
    );
}
add_action('widgets_init', 'rilu_e_bike_widgets_init');
?>