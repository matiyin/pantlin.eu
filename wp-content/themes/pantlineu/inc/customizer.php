<?php
/**
 * Emptynest: Customizer
 *
 * @package WordPress
 * @subpackage emptynest
 * @since 1.0.0
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function parker_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
  $wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
  
  // remove favicon generator feature
  $wp_customize->remove_control('site_icon');

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'parker_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'parker_customize_partial_blogdescription',
			)
		);
	}
}

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function parker_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function parker_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Bind JS handlers to instantly live-preview changes.
 */
function parker_customize_preview_js() {
	wp_enqueue_script( 'parker-customize-preview', get_theme_file_uri( '/js/customize-preview.js' ), array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'parker_customize_preview_js' );

/**
 * Load dynamic logic for the customizer controls area.
 */
function parker_panels_js() {
	wp_enqueue_script( 'parker-customize-controls', get_theme_file_uri( '/js/customize-controls.js' ), array(), '1.0', true );
}
add_action( 'customize_controls_enqueue_scripts', 'parker_panels_js' );