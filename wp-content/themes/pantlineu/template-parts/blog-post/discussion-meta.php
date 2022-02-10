<?php
/**
 * The template for displaying Current Discussion on posts
 *
 * @package WordPress
 * @subpackage emptynest
 * @since 2.1.0
 */

/* Get data from current discussion on post. */
$discussion    = parker_get_discussion_data();
$has_responses = $discussion->responses > 0;

if ( $has_responses ) {
	/* translators: %1(X comments)$s */
	$meta_label = sprintf( _n( '%d Comment', '%d Comments', $discussion->responses, INI_TEXTDOMAIN ), $discussion->responses );
} else {
	$meta_label = __( 'No comments', INI_TEXTDOMAIN );
}

?>

<div class="discussion-meta">
	<?php
	if ( $has_responses ) {
		parker_discussion_avatars_list( $discussion->authors );
	}
	?>
	<p class="discussion-meta-info">
		<span class="icon-message-square"></span>
		<span><?php echo esc_html( $meta_label ); ?></span>
	</p>
</div><!-- .discussion-meta -->
