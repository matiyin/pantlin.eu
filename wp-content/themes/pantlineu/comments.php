<?
/**
 * Displays the area of the page that contains both the current comments and the comment form.
 *
 * @package WordPress
 * @subpackage emptynest
 * @since 2.1.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
*/
if ( post_password_required() ) {
	return;
}

$discussion = parker_get_discussion_data();
?>

<div id="comments" class="<? echo comments_open() ? 'comments-area' : 'comments-area comments-closed'; ?>">
	<div class="<? echo $discussion->responses > 0 ? 'comments-title-wrap' : 'comments-title-wrap no-responses'; ?>">
		<h2 class="comments-title">
		<?
		if ( comments_open() ) {
			if ( have_comments() ) {
				_e( 'Join the Conversation', INI_TEXTDOMAIN );
			} else {
				_e( 'Leave a comment', INI_TEXTDOMAIN );
			}
		} else {
			if ( '1' == $discussion->responses ) {
				/* translators: %s: post title */
				printf( _x( 'One reply on &ldquo;%s&rdquo;', 'comments title', INI_TEXTDOMAIN ), get_the_title() );
			} else {
				printf(
					/* translators: 1: number of comments, 2: post title */
					_nx(
						'%1$s reply on &ldquo;%2$s&rdquo;',
						'%1$s replies on &ldquo;%2$s&rdquo;',
						$discussion->responses,
						'comments title',
						INI_TEXTDOMAIN
					),
					number_format_i18n( $discussion->responses ),
					get_the_title()
				);
			}
		}
		?>
		</h2><!-- .comments-title -->
		<?
			// Only show discussion meta information when comments are open and available.
		if ( have_comments() && comments_open() ) {
			get_template_part( 'template-parts/blog-post/discussion', 'meta' );
		}
		?>
	</div><!-- .comments-title-flex -->
	<?
	if ( have_comments() ) :

		// Show comment form at top if showing newest comments at the top.
		if ( comments_open() ) {
			parker_comment_form( 'desc' );
		}

		?>
		<ol class="comment-list">
			<?
			wp_list_comments(
				array(
					'walker'      => new Parker_Walker_Comment(),
					'avatar_size' => parker_get_avatar_size(),
					'short_ping'  => true,
					'style'       => 'ol',
				)
			);
			?>
		</ol><!-- .comment-list -->
		<?

		// Show comment navigation
		if ( have_comments() ) :
			$prev_icon     = parker_get_icon_svg( 'chevron_left', 22 );
			$next_icon     = parker_get_icon_svg( 'chevron_right', 22 );
			$comments_text = __( 'Comments', INI_TEXTDOMAIN );
			the_comments_navigation(
				array(
					'prev_text' => sprintf( '%s <span class="nav-prev-text"><span class="primary-text">%s</span> <span class="secondary-text">%s</span></span>', $prev_icon, __( 'Previous', INI_TEXTDOMAIN ), __( 'Comments', INI_TEXTDOMAIN ) ),
					'next_text' => sprintf( '<span class="nav-next-text"><span class="primary-text">%s</span> <span class="secondary-text">%s</span></span> %s', __( 'Next', INI_TEXTDOMAIN ), __( 'Comments', INI_TEXTDOMAIN ), $next_icon ),
				)
			);
		endif;

		// Show comment form at bottom if showing newest comments at the bottom.
		if ( comments_open() && 'asc' === strtolower( get_option( 'comment_order', 'asc' ) ) ) :
			?>
			<div class="comment-form-flex">
				<span class="screen-reader-text"><? _e( 'Leave a comment', INI_TEXTDOMAIN ); ?></span>
				<? parker_comment_form( 'asc' ); ?>
				<h2 class="comments-title" aria-hidden="true"><? _e( 'Leave a comment', INI_TEXTDOMAIN ); ?></h2>
			</div>
			<?
		endif;

		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() ) :
			?>
			<p class="no-comments">
				<? _e( 'Comments are closed.', INI_TEXTDOMAIN ); ?>
			</p>
			<?
		endif;

	else :

		// Show comment form.
		parker_comment_form( true );

	endif; // if have_comments();
	?>
</div><!-- #comments -->
