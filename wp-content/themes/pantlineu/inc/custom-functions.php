<?
/**
 * Add your own new custom template functions to this file
 *
 * @package WordPress
 * @subpackage pantlineu
 * @since 1.0.0
 */

 /* Change Excerpt length */
function custom_excerpt_length( $length ) {
  return 30;
}
add_filter( 'excerpt_length', 'custom_excerpt_length' , 999 );

/*------------------------------------*\
:   WP Mailchimp
\*------------------------------------*/

// add AUTHOR to comment form submission
add_filter( 'mc4wp_integration_data', function( $vars ) {
  $vars['AUTHOR'] = isset( $_POST['author'] ) ? sanitize_text_field($_POST['author']) : array();
  $vars['EMAIL'] = isset( $_POST['email'] ) ? sanitize_email($_POST['email']) : array();
	return $vars;
});
