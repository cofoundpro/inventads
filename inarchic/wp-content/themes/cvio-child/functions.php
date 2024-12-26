<?php
/**
 * cvio-child functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package cvio-child
 */

/**
 * Load the parent style.css and child styles.css file
 */
function cvio_child_stylesheets() {
  // Dynamically get version number of the parent stylesheet
  $parent_style = 'cvio-style';
  $parent_dep = array( 'magnific-popup', 'animate', 'jarallax', 'cvio-swiper', 'cvio-fontawesome' );
  $child_style = 'cvio-child-style';
  $rtl_style = 'cvio-rtl';
  $version = wp_get_theme()->get('Version');

  // Load the main stylesheet
  wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css', $parent_dep );

  if ( is_rtl() ) {
	// Load the rtl stylesheet
	wp_enqueue_style( $rtl_style, get_template_directory_uri() . '/rtl.css', array( $parent_style ), $version );

	// Load the child stylesheet
	wp_enqueue_style( $child_style, get_stylesheet_directory_uri() . '/style.css', array( $parent_style, $rtl_style ), $version );
  } else {
	// Load the child stylesheet
	wp_enqueue_style( $child_style, get_stylesheet_directory_uri() . '/style.css', array( $parent_style ), $version );
  }
}
add_action( 'wp_enqueue_scripts', 'cvio_child_stylesheets' );
