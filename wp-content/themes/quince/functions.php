<?php
/*	
*	---------------------------------------------------------------------
*	MNKY Functions
*	--------------------------------------------------------------------- 
*/

// Define constants
define('MNKY_PATH', get_template_directory());
define('MNKY_URI', get_template_directory_uri());
define('MNKY_INCLUDE', get_template_directory() . '/inc');
define('MNKY_ADMIN', get_template_directory() . '/inc/theme-options');
define('MNKY_ADMIN_EXT', get_template_directory() . '/inc/theme-options-extend');
define('MNKY_PLUGINS', get_template_directory() . '/inc/plugins');


// Theme setup
require_once(MNKY_INCLUDE . '/theme-setup.php');
require_once(MNKY_INCLUDE . '/custom-functions.php');
require_once(MNKY_INCLUDE . '/sidebars.php');
require_once(MNKY_INCLUDE . '/tgm-plugin-activation.php');
require_once(MNKY_INCLUDE . '/tgm-register-plugins.php');

// Plugins
require_once(MNKY_PLUGINS . '/importer/importer.php');
require_once(MNKY_PLUGINS . '/per-page-sidebars.php');
require_once(MNKY_PLUGINS . '/breadcrumbs.php');


// WooCommerce
require_once(MNKY_INCLUDE . '/woocommerce/index.php');

// Theme options
add_filter( 'ot_show_pages', '__return_false' );
add_filter( 'ot_show_new_layout', '__return_false' );
add_filter( 'ot_theme_mode', '__return_true' );
require(MNKY_ADMIN . '/ot-loader.php');
require(MNKY_ADMIN_EXT . '/theme-options.php' );
require(MNKY_ADMIN_EXT . '/config.php');
require(MNKY_ADMIN_EXT . '/typography.php');
require(MNKY_ADMIN_EXT . '/meta-boxes.php');


/*	
*	---------------------------------------------------------------------
*	MNKY Enqueue scripts & styles
*	--------------------------------------------------------------------- 
*/

add_action('wp_enqueue_scripts', 'mnky_scripts');
function mnky_scripts() {
	
	// jQuery
    wp_enqueue_script( 'jquery' );
		
	// Global scripts
	wp_register_script( 'main-js', MNKY_URI . '/js/init.js', array('jquery'), '', false);
	wp_enqueue_script( 'main-js' );	
	
	// Sticky menu
	if (ot_get_option('sticky_header') == 'on'){
		wp_register_script( 'sticky-header-js', MNKY_URI . '/js/sticky-header.js', array('jquery'), '', false);
		wp_enqueue_script( 'sticky-header-js' );
	}
	
	// Menu for small screens
	wp_register_script( 'jquery.mmenu-js', MNKY_URI . '/js/jquery.mmenu.js', array('jquery'), '', true);
	wp_enqueue_script( 'jquery.mmenu-js' );
	wp_register_style( 'jquery.mmenu', MNKY_URI . '/css/jquery.mmenu.css', null, 1.0, 'all' );
	wp_enqueue_style( 'jquery.mmenu' );
	wp_register_style( 'new-restyle', MNKY_URI . '/css/new-restyle.css', null, 1.0, 'all' );
	wp_enqueue_style( 'new-restyle' );
	wp_localize_script( 'jquery.mmenu-js', 'objectL10n', array(
    'title' => __( 'Menu', 'quince' ),
	) );

	// Woocommerce style
	if (class_exists( 'WooCommerce' )){
		wp_register_style( 'my-woocommerce', MNKY_URI . '/inc/woocommerce/woocommerce.css', null, 1.0, 'all' );
		wp_enqueue_style( 'my-woocommerce' );
	}

	// Main stylesheet
	wp_register_style( 'main', get_stylesheet_uri());
	wp_enqueue_style( 'main' );
		
	// Threaded comments (when in use)
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	
}

/* registr side_bar*/
function arphabet_widgets_init() {

	register_sidebar( array(
		'name'          => 'Home right sidebar',
		'id'            => 'home_right_1',
		'before_widget' => '<div>',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="rounded">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name' => __( 'header-cont', 'quince' ),
		'id' => 'sidebar-1',
		'description' => __( 'Widgets in this area will be shown on all posts and pages.', 'quince' ),
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '<p class="widgettitle">',
		'after_title'   => '</p>',
	) );

	register_sidebar( array(
		'name' => __( 'header-cont-email', 'quince' ),
		'id' => 'sidebar-2',
		'description' => __( 'Widgets in this area will be shown on all posts and pages.', 'quince' ),
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '<p class="widgettitle">',
		'after_title'   => '</p>',
	) );

}
add_action( 'widgets_init', 'arphabet_widgets_init' );
/* ./registr side_bar*/
/*registr widget*/


/* ./regist widget*/

//includ nav wolker lib
require_once('libs/wp_bootstrap_navwalker.php');


// Enqueue custom styles from back-end
require_once(MNKY_PATH . '/custom-style.php');


// Custom back-end style
add_action( 'admin_enqueue_scripts', 'mnky_admin_scripts' );
function mnky_admin_scripts() {
	wp_register_style( 'admin_css_extend', MNKY_URI . '/inc/theme-options-extend/assets/theme-options-extend.css', array('ot-admin-css' ), '1.0.0' );
	wp_enqueue_style( 'admin_css_extend' );
}

