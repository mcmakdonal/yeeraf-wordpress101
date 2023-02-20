<?php
/*
Plugin Name:  Wordpress 101 Plugin Tutorial
Description:  A short little description of the plugin. It will be displayed on the Plugins page in WordPress admin area. 
Version:      1.0
Author:       Mc 
License:      GPL2
Text Domain:  wordpress101
Domain Path:  /languages
*/

function action_callback() {
    $value = apply_filters( 'example_filter', 'Yeeraf', time(), Date('Y-m-d') );

    echo "<h1 class='yeeraf'>". $value  ."</h1>";
}
add_action( 'admin_footer', 'action_callback' );


function filter_callback( $string, $arg1, $arg2 ) {
    $string = "Fareey";
    return $string;
}
add_filter( 'example_filter', 'filter_callback', 10, 3 );


function yeeraf_custom_post_type() {
	register_post_type('yeeraf',
		array(
			'labels'      => array(
				'name'          => __('Yeeraf', 'wordpress101'),
				'singular_name' => __('Yeeraf', 'wordpress101'),
			),
				'public'      => true,
				'has_archive' => true,
		)
	);
}
add_action('init', 'yeeraf_custom_post_type');


/**
 * Register a custom menu page.
 */
function yeeraf_register_my_custom_menu_page() {
	add_menu_page( 
		__( 'Yeeraf Custom Menu', 'wordpress101' ),
		__( 'Yeeraf Custom Menu', 'wordpress101' ),
		'manage_options',
		'yeeraf',
		'yeeraf_page',
	); 
}
add_action( 'admin_menu', 'yeeraf_register_my_custom_menu_page' );

/**
 * Display a custom menu page
 */
function yeeraf_page() {
	esc_html_e( 'Admin Page Test', 'wordpress101' );	
}


function add_script_to_admin_area() {
    // CSS
    wp_enqueue_style( 'yeeraf-backend-css',plugin_dir_url( __FILE__ ) . '/assets/yeeraf-backend.css' );

    // JS
    wp_enqueue_script( 'yeeraf-backend-js', plugin_dir_url( __FILE__ ) . '/assets/yeeraf-backend.js', ['jquery'], time(), true );
}
add_action( 'admin_enqueue_scripts', 'add_script_to_admin_area' );


function add_script_to_customer_area() {
    // CSS
    wp_enqueue_style( 'yeeraf-frontend-css',plugin_dir_url( __FILE__ ) . '/assets/yeeraf-frontend.css' );

    // JS
    wp_enqueue_script( 'yeeraf-frontend-js', plugin_dir_url( __FILE__ ) . '/assets/yeeraf-frontend.js', ['jquery'], time(), true );


    wp_localize_script( 'yeeraf-frontend-js', 'frontend_ajax_object',
        [
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
            'data_var_1' => 'value 1',
            'data_var_2' => 'value 2',
        ]
    );
}
add_action( 'wp_enqueue_scripts', 'add_script_to_customer_area' );



add_shortcode( 'yeeraf_shortcode', 'yeeraf_shortcode_func' );
function yeeraf_shortcode_func( $attributes ) {
	$attributes = shortcode_atts( array(
		'param1' => 'Yee',
		'param2' => 'raf',
        'param3' => ''
	), $attributes, 'yeeraf_shortcode' );

	return "<h1> " . $attributes['param1'] . $attributes['param2']  . " " . $attributes['param3'] . " </h1>";
}


add_action( 'wp_ajax_hello_yeeraf', 'my_ajax_hello_yeeraf' );
function my_ajax_hello_yeeraf() {
    wp_send_json([
        'message' => 'Hello Yeeraf'
    ]);
    wp_die();
}


add_action( 'rest_api_init', function () {
    register_rest_route( 'yeeraf/v1', '/employee', array(
      'methods' => 'GET',
      'callback' => 'get_yeeraf_emp',
    ) );
});


function get_yeeraf_emp( WP_REST_Request $request ) {
    $emp = [
       [
        'id' => 1,
        'name' => 'Yeeraf',
       ],[
        'id' => 2,
        'name' => 'Mc'
       ]
    ];

    return ['data' => $emp, 'request' => $request->get_params() ];
}