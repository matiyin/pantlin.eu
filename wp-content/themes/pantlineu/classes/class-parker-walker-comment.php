<?
/**
 * Custom comment walker for this theme
 *
 * @package WordPress
 * @subpackage emptynest
 * @since 2.1.0
 */

/**
 * This class outputs custom comment walker for HTML5 friendly WordPress comment and threaded replies.
 *
 * @since 1.0.0
 */
class Parker_Walker_Comment extends Walker_Comment {

	/**
	 * Outputs a comment in the HTML5 format.
	 *
	 * @see wp_list_comments()
	 *
	 * @param WP_Comment $comment Comment to display.
	 * @param int        $depth   Depth of the current comment.
	 * @param array      $args    An array of arguments.
	 */
	protected function html5_comment( $comment, $depth, $args ) {

		$tag = ( 'div' === $args['style'] ) ? 'div' : 'li';

		?>
		<<? echo $tag; ?> id="comment-<? comment_ID(); ?>" <? comment_class( $this->has_children ? 'parent' : '', $comment ); ?>>
			<article id="div-comment-<? comment_ID(); ?>" class="comment-body">
				<footer class="comment-meta">
					<div class="comment-author vcard">
						<?
						$comment_author_link = get_comment_author_link( $comment );
						$comment_author_url  = get_comment_author_url( $comment );
						$comment_author      = get_comment_author( $comment );
						$avatar              = get_avatar( $comment, $args['avatar_size'] );
						if ( 0 != $args['avatar_size'] ) {
							if ( empty( $comment_author_url ) ) {
								echo $avatar;
							} else {
								printf( '<a href="%s" rel="external nofollow" class="url">', $comment_author_url );
								echo $avatar;
							}
						}
						/*
						 * Using the `check` icon instead of `check_circle`, since we can't add a
						 * fill color to the inner check shape when in circle form.
						 */
						if ( parker_is_comment_by_post_author( $comment ) ) {
							printf( '<span class="post-author-badge" aria-hidden="true">%s</span>', parker_get_icon_svg( 'check', 24 ) );
						}

						printf(
							/* translators: %s: comment author link */
							wp_kses(
								__( '%s <span class="screen-reader-text says">says:</span>', INI_TEXTDOMAIN ),
								array(
									'span' => array(
										'class' => array(),
									),
								)
							),
							'<b class="fn">' . get_comment_author_link( $comment ) . '</b>'
						);

						if ( ! empty( $comment_author_url ) ) {
							echo '</a>';
						}
						?>
					</div><!-- .comment-author -->

					<div class="comment-metadata">
						<a href="<? echo esc_url( get_comment_link( $comment, $args ) ); ?>">
							<?
								/* translators: 1: comment date, 2: comment time */
								$comment_timestamp = sprintf( __( '%1$s at %2$s', INI_TEXTDOMAIN ), get_comment_date( '', $comment ), get_comment_time() );
							?>
							<time datetime="<? comment_time( 'c' ); ?>" title="<? echo $comment_timestamp; ?>">
								<? echo $comment_timestamp; ?>
							</time>
						</a>
						<?
							$edit_comment_icon = parker_get_icon_svg( 'edit', 16 );
							edit_comment_link( __( 'Edit', INI_TEXTDOMAIN ), '<span class="edit-link-sep">&mdash;</span> <span class="edit-link">' . $edit_comment_icon, '</span>' );
						?>
					</div><!-- .comment-metadata -->

					<? if ( '0' == $comment->comment_approved ) : ?>
					<p class="comment-awaiting-moderation"><? _e( 'Your comment is awaiting moderation.', INI_TEXTDOMAIN ); ?></p>
					<? endif; ?>
				</footer><!-- .comment-meta -->

				<div class="comment-content">
					<? comment_text(); ?>
				</div><!-- .comment-content -->

			</article><!-- .comment-body -->

			<?
			comment_reply_link(
				array_merge(
					$args,
					array(
						'add_below' => 'div-comment',
						'depth'     => $depth,
						'max_depth' => $args['max_depth'],
						'before'    => '<div class="comment-reply">',
						'after'     => '</div>',
					)
				)
			);
			?>
		<?
	}
}
