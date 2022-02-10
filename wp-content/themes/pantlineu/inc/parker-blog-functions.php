<?php
/**
 * Custom template tags for this theme
 *
 * @package WordPress
 * @subpackage emptynest
 * @since 1.0.0
 */

if ( ! function_exists( 'parker_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function parker_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		// if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		// 	$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		// }

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		printf(
			'<span class="posted-on">%1$s %2$s</span>',
			'<span class="icon-calendar1"></span>',
			$time_string
		);
	}
endif;

/**
 * Gets the SVG code for a given icon.
 */
function parker_get_icon_svg( $icon, $size = 24 ) {
	return TwentyNineteen_SVG_Icons::get_svg( 'ui', $icon, $size );
}


if ( ! function_exists( 'parker_posted_by' ) ) :
	/**
	 * Prints HTML with meta information about theme author.
	 */
	function parker_posted_by() {
		printf(
			'<span class="byline">%1$s<span class="screen-reader-text">%2$s</span><span class="author vcard"><a class="url fn n" href="%3$s">%4$s</a></span></span>',
			/* translators: 1: SVG icon. 2: post author, only visible to screen readers. 3: author link. */
			parker_get_icon_svg( 'person', 16 ),
			__( 'Posted by', INI_TEXTDOMAIN ),
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_html( get_the_author() )
		);
	}
endif;

if ( ! function_exists( 'parker_comment_count' ) ) :
	/**
	 * Prints HTML with the comment count for the current post.
	 */
	function parker_comment_count() {
		if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			echo '<span class="icon-message-square"></span>';

			/* translators: %s: Name of current post. Only visible to screen readers. */
			comments_popup_link( sprintf( __( 'Leave a comment<span class="screen-reader-text"> on %s</span>', INI_TEXTDOMAIN ), get_the_title() ) );

			echo '</span>';
		}
	}
endif;

if ( ! function_exists( 'parker_post_categories' ) ) :
	/**
	 * Prints a comma seperated list of attached categories
	 */
	function parker_post_categories() {

    $categories_list = get_the_category_list(', ');
    if ( $categories_list ) {
      /* translators: 1: SVG icon. 2: posted in label, only visible to screen readers. 3: list of categories. */
      printf(
        '<span class="cat-links">%1$s<span class="screen-reader-text">%2$s</span>%3$s</span>',
        '<span class="icon-folder"></span>',
        __( 'Posted in', INI_TEXTDOMAIN ),
        $categories_list
      ); // WPCS: XSS OK.
    }
  }

endif;

if ( ! function_exists( 'parker_post_tags' ) ) :
	/**
	 * Prints a comma seperated list of attached tags
	 */
	function parker_post_tags() {

    $tags_list = get_the_tag_list( '', __( ', ', INI_TEXTDOMAIN ) );
    if ( $tags_list ) {
      /* translators: 1: SVG icon. 2: posted in label, only visible to screen readers. 3: list of tags. */
      printf(
        '<span class="tags-links">%1$s<span class="screen-reader-text">%2$s </span>%3$s</span>',
        parker_get_icon_svg( 'tag', 16 ),
        __( 'Tags:', INI_TEXTDOMAIN ),
        $tags_list
      ); // WPCS: XSS OK.
    }
	}
endif;

if ( ! function_exists( 'parker_comment_avatar' ) ) :
	/**
	 * Returns the HTML markup to generate a user avatar.
	 */
	function parker_get_user_avatar_markup( $id_or_email = null ) {

		if ( ! isset( $id_or_email ) ) {
			$id_or_email = get_current_user_id();
		}

		return sprintf( '<div class="comment-user-avatar comment-author vcard">%s</div>', get_avatar( $id_or_email, parker_get_avatar_size() ) );
	}
endif;

if ( ! function_exists( 'parker_discussion_avatars_list' ) ) :
	/**
	 * Displays a list of avatars involved in a discussion for a given post.
	 */
	function parker_discussion_avatars_list( $comment_authors ) {
		if ( empty( $comment_authors ) ) {
			return;
		}
		echo '<ol class="discussion-avatar-list">', "\n";
		foreach ( $comment_authors as $id_or_email ) {
			printf(
				"<li>%s</li>\n",
				parker_get_user_avatar_markup( $id_or_email )
			);
		}
		echo '</ol><!-- .discussion-avatar-list -->', "\n";
	}
endif;

if ( ! function_exists( 'parker_comment_form' ) ) :
	/**
	 * Documentation for function.
	 */
	function parker_comment_form( $order ) {
		if ( true === $order || strtolower( $order ) === strtolower( get_option( 'comment_order', 'asc' ) ) ) {

			comment_form(
				array(
					'logged_in_as'  => null,
          'title_reply'   => null,
          'submit_button' => '<input name="%1$s" type="submit" id="%2$s" class="c-button" value="%4$s" />'
				)
			);
		}
	}
endif;

if ( ! function_exists( 'parker_reading_time' ) ) :
	/**
	 * Documentation for function.
	 */
	function parker_reading_time() {

    $reading_time = do_shortcode('[rt_reading_time]');
    if ( $reading_time ) {
      printf(
        '<span class="tags-links">%1$s<span class="screen-reader-text">%2$s </span>%3$s %4$s</span>',
        '<span class="icon-clock1"></span>',
        __( 'Reading time:', INI_TEXTDOMAIN ),
        $reading_time,
        'min'
      );
    }
	}
endif;

if ( ! function_exists( 'parker_the_posts_navigation' ) ) :
	/**
	 * Documentation for function.
	 */
	function parker_the_posts_navigation() {
		$prev_icon = parker_get_icon_svg( 'chevron_left', 22 );
		$next_icon = parker_get_icon_svg( 'chevron_right', 22 );
		the_posts_pagination(
			array(
				'mid_size'  => 2,
				'prev_text' => sprintf( '%s <span class="nav-prev-text">%s</span>', $prev_icon, __( 'Newer posts', INI_TEXTDOMAIN ) ),
				'next_text' => sprintf( '<span class="nav-next-text">%s</span> %s', __( 'Older posts', INI_TEXTDOMAIN ), $next_icon ),
			)
		);
	}
endif;

/**
 * Adds sticky posts to your category archive
 * pages.
 *
 * Works in exactly the same way as sticky posts work 
 * on the homepage, including all the negatives like
 * breaking the posts_per_page and only showing
 * them on page 1 etc.
 * 
 * @param array $posts
 * @param object $wp_query
 * @author Tom Willmot - http://github.com/willmot/
 * @return array $posts
 */
function yell_category_sticky_posts( $posts, $wp_query ) {

	global $wp_the_query;
	
	// Don't continue if this isn't a category query, we're not in the main query or we're in the admin
	if ( ! $wp_query->is_category || $wp_query !== $wp_the_query || is_admin() )
		return $posts;

	global $wpdb;
	
	$q = $wp_query->query_vars;
	
	$page = absint( $q['paged'] );
	
	if ( empty( $page ) )
		$page = 1;
		
	$post_type = $q['post_type'];
	
	$sticky_posts = get_option( 'sticky_posts' );
	
	if ( $wp_query->is_category && $page <= 1 && is_array( $sticky_posts ) && !empty( $sticky_posts ) && ! $q['ignore_sticky_posts'] ) {
	   	
		$num_posts = count( $posts );
	   
	    $sticky_offset = 0;
	  
	    // Loop over posts and relocate stickies to the front.
	    for ( $i = 0; $i < $num_posts; $i++ ) {
	    	
	    	if ( in_array( $posts[$i]->ID, $sticky_posts ) ) {
	    	
	    		$sticky_post = $posts[$i];
	    	
	    		// Remove sticky from current position
	    		array_splice( $posts, $i, 1 );
	    	
	    		// Move to front, after other stickies
	    		array_splice( $posts, $sticky_offset, 0, array( $sticky_post ) );
	    	
	    		// Increment the sticky offset.  The next sticky will be placed at this offset.
	    		$sticky_offset++;
	    	
	    		// Remove post from sticky posts array
	    		$offset = array_search( $sticky_post->ID, $sticky_posts );
	    		unset( $sticky_posts[$offset] );
	    	
	    	}

	    }
	    
	    // If any posts have been excluded specifically, Ignore those that are sticky.
	    if ( !empty( $sticky_posts ) && !empty( $q['post__not_in'] ) )
	    	$sticky_posts = array_diff( $sticky_posts, $q['post__not_in'] );

	    // Fetch sticky posts that weren't in the query results
	    if ( !empty( $sticky_posts ) ) {
	    	
	    	$stickies__in = implode( ',', array_map( 'absint', $sticky_posts ));
	    	
	    	// honor post type(s) if not set to any
	    	$stickies_where = '';
	    	
	    	if ( 'any' != $post_type && '' != $post_type ) {
	    	
	    		if ( is_array( $post_type ) )
	    			$post_types = join( "', '", $post_type );
	    		
	    		else
	    			$post_types = $post_type;

	    		$stickies_where = "AND $wpdb->posts.post_type IN ('" . $post_types . "')";
	    	}

	    	// $stickies = $wpdb->get_results( "SELECT pan_posts.* FROM $wpdb->posts INNER JOIN pan_term_relationships ON (wp_posts.ID = wp_term_relationships.object_id) WHERE 1=1  AND ( wp_term_relationships.term_taxonomy_id IN (" . get_term( $wp_query->query_vars['cat'], 'category' )->term_taxonomy_id . ") ) AND $wpdb->posts.ID IN ($stickies__in) $stickies_where" );
        $stickies = get_posts( array(
                'post__in' => $stickies_where,
                'post_type' => $wp_query->query_vars['post_type'],
                'post_status' => 'publish',
                'nopaging' => true
            ) );
            
	    	foreach ( $stickies as $sticky_post ) {
	    	
	    		// Ignore sticky posts are not published.
	    		if ( 'publish' != $sticky_post->post_status )
	    			continue;
	    	
	    		array_splice( $posts, $sticky_offset, 0, array( $sticky_post ) );
	    	
	    		$sticky_offset++;
	    	
	    	}
	    }
	}
	
	return $posts;

}
// add_filter( 'the_posts', 'yell_category_sticky_posts', 10, 2 );