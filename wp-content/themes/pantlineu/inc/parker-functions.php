<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package WordPress
 * @subpackage emptynest
 * @since 2.1.0
 */

 /**
 *
 * Parker Images
 *
 * Retrieve img tag with alt, title and description, with optional lazy load with mobile formats
 * Uses placeholder img from ACF is no image found: get_field('placeholder_image','options')
 *
 * Examples:
 * <?= park_return_img(1,'medium') ?> returns a simple inline <img> with size medium
 * <div <?= park_return_img(1,'medium',true) ?>></div> returns a background image on the div
 * <?= park_return_img(1,'medium',false,true) ?> returns a lazy loaded inline <img> with its own mobile size (defaults to medium)
 * <div <?= park_return_img(1,'medium',true, true, 'thumbnail') ?>></div> returns a lazy background image with own mobile size
 */

// Retrieve img tag with alt, title and description, optional lazy load with mobile formats
function park_return_img($id,$size,$bgimage=false,$lazy=false,$size_mob='medium',$textonly=false) {
  if(get_post_type($id) != 'attachment'){
  // IF image is an attachement get its ID
    $attachmentid = get_post_thumbnail_id($id);
  } else {
    // ELSE get featured image ID
    $attachmentid = $id;
  }
  if (!$attachmentid) $attachmentid = get_field('placeholder_image','options');

  $img = "";
  if($attachmentid) {
    // get image array for sizes
    $img_src   = wp_get_attachment_image_src($attachmentid,$size);
    if(isset($img_src)) {
      // get mobile image src
      $img_src_mob  = wp_get_attachment_image_src($attachmentid,$size_mob);
      $img_title    = get_the_title($attachmentid);
      $img_alt      = get_post_meta( $attachmentid, '_wp_attachment_image_alt', true);
      $img_alt      = $img_alt ? $img_alt : $img_title;
      $img_caption  = get_post_field('post_excerpt', $attachmentid); 

      if($textonly) {
        // IF textonly flag = true, output alt, caption or title depending on the value
        if($textonly == 'alt') {
          return $img_alt;
        } else if($textonly == 'caption'){
          return $img_caption;
        } else {
          return $img_title;
        }
      } else if($bgimage && !$lazy) {
        // ELSE IF background image flag = true, output background-image
        $img = ' style="background-image:url(\''.$img_src[0].'\')" data-item-alt="'.$img_alt.'" data-item-title="'.$img_title.'" data-item-caption="'.$img_caption.'" ';
      } else if($bgimage && $lazy) {
        // ELSE IF background image flag = true and lazy flag = true output background-image data-lazyparker-bg and data-lazyparker-bg-mob for js lazy loading with mobile formats
        $img = ' data-lazyparker-bg="'.$img_src[0].'" data-lazyparker-bg-mob="'.$img_src_mob[0].'" ';
      } else if(!$bgimage && $lazy) {
        // ELSE IF output img tag with lazy load
        $img = '<img data-lazyparker-bg="'.$img_src[0].'" data-lazyparker-bg-mob="'.$img_src_mob[0].'" alt="'.$img_alt.'" title="'.$img_title.'" />';
      } else {
        // ELSE output img tag
        $img = '<img src="'.$img_src[0].'" alt="'.$img_alt.'" title="'.$img_title.'" data-item-caption="'.$img_caption.'" />';
      }
    }
  }
  return $img;
}
/*------------------------------------*\
:   Prev/Next navigation on single posts
:   Usage: <? post_nav_loop($post_type,$curr_post_id) ?>
\*------------------------------------*/

// custom prev/next post links with infinite loop
function post_nav_loop($post_type,$curr_post_id) {
    $get_posts = get_posts('post_type='.$post_type.'&posts_per_page=-1&suppress_filters=0&post_status=publish');
    $posts = array();
    foreach ($get_posts as $i) {
        $posts[] = $i->ID;
    }
    $thisindex = array_search($curr_post_id, $posts);
    $size = count($posts);
    if ($thisindex == 0) {
        $prev_id = $posts[$thisindex+$size-1];
    } else {
        $prev_id = $posts[$thisindex-1];
    };
    if ($thisindex == $size-1) {
        $next_id = $posts[0];
    } else {
        $next_id = $posts[$thisindex+1];
    };
    if ( !empty($prev_id) ) {
        echo '<li><a class="nav_prev" rel="prev" title="'.get_the_title($prev_id).'" href="'.get_permalink($prev_id).'"><i class="icon-arrow-left-circle"></i></a></li>';
    }
    if ( !empty($next_id) ) {
        echo '<li><a class="nav_next" rel="next" title="'.get_the_title($next_id).'" href="'.get_permalink($next_id).'"><i class="icon-arrow-right-circle"></i></a></li>';
    }  
}

/*------------------------------------*\
:   AJAX Load More
\*------------------------------------*/

// load script
function parkers_load_more_scripts() {
	global $wp_query; 
	// register our main script but do not enqueue it yet
	wp_register_script( 'parkers_loadmore', get_stylesheet_directory_uri() . '/js/load-more.js', array('jquery') );
	wp_localize_script( 'parkers_loadmore', 'parkers_loadmore_params', array(
		'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php', // WordPress AJAX
		'posts' => json_encode( $wp_query->query_vars ), // everything about your loop is here
		'current_page' => get_query_var( 'paged' ) ? get_query_var('paged') : 1,
		'max_page' => $wp_query->max_num_pages
	) );
 	wp_enqueue_script( 'parkers_loadmore' );
}
add_action( 'wp_enqueue_scripts', 'parkers_load_more_scripts' );


function parkers_loadmore_ajax_handler(){
 
	// prepare our arguments for the query
	$args = json_decode( stripslashes( $_POST['query'] ), true );
	$args['paged'] = $_POST['page'] + 1; // we need next page to be loaded
	$args['post_status'] = 'publish';
 
	// it is always better to use WP_Query but not here
	query_posts( $args );
 
	if( have_posts() ) :
		while( have_posts() ): the_post();
			get_template_part( 'template-parts/blog-content/content');
		endwhile;
	endif;
	die;
}
add_action('wp_ajax_loadmore', 'parkers_loadmore_ajax_handler'); // wp_ajax_{action}
add_action('wp_ajax_nopriv_loadmore', 'parkers_loadmore_ajax_handler'); // wp_ajax_nopriv_{action}


/*------------------------------------*\
:   AJAX autocomplete
\*------------------------------------*/

/**
* custom autocomplete for a Custom post type
* Code from: https://wordpress.stackexchange.com/questions/253449/populating-autocomplete-field-with-custom-post-type
*/


function search_autocomplete() {
    // we send ajax request to ajax_url
    // check for term, if doesnt exist die
    if ( empty( $_REQUEST['term']) && empty( $_REQUEST['posttype'] ) ) {
        wp_die();
    }

    // WP Query arguments
    // we get the 'term' from the ajax call, clean it and make a search
    $args = array(
      's'         => trim( esc_attr( strip_tags( $_REQUEST['term'] ) ) ),
      'post_type' => array($_REQUEST['posttype'])
    );

    // array to keep results
    $results = array();

    // make a query
    $query = new WP_Query( $args );



    // save results
    // formatted with the title as 'label' for the autocomplete script
    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
          $query->the_post();
          $results[] = array(
              'label'     =>  get_the_title()     // title
              //'link'      => get_permalink(),                // link
              //'id'        => get_the_ID(),                   // id
               // and whatever eles you want to send to the front end
          );
        }
    }

    // echo results
    echo json_encode($results);

    // kill process
    // all ajax actions in WP need to die when they are done!
    wp_die();
  }

// add_action( 'wp_ajax_search_autocomplete', 'search_autocomplete' );
// add_action( 'wp_ajax_nopriv_search_autocomplete', 'search_autocomplete' );



function search_autocomplete_js() {
  global $wp_query;
  $args = array(
    'url'   => admin_url( 'admin-ajax.php' ),
    'query' => $wp_query->query,
  );

  wp_enqueue_script( 'autocomplete',  TEMPLATE_PATH  . '/js/search_autocomplete.js', array( 'jquery-ui-autocomplete' ), 'true', true );
  wp_localize_script( 'autocomplete', 'opts', $args  );

}
// add_action( 'wp_enqueue_scripts', 'search_autocomplete_js' );


/*=============================================
=           CUSTOM BREADCRUMBS               =
=============================================*/

//  by Parkers, based on YOAST seo syntax
function single_breadcrumb($postid,$parentpageId,$taxonomy=false,$ancestorpageid=false) {
  $pagetitle        = get_the_title( $postid );
  if($taxonomy)  $categories  = get_the_terms($postid,$taxonomy);
  //print_r($categories);
  $parentpageTitle  = get_the_title($parentpageId);
  $parentpageLink   = get_the_permalink($parentpageId);
  $ancestorpageTitle  = get_the_title($ancestorpageid);
  $ancestorpageLink   = get_the_permalink($ancestorpageid);
  $sep = ' > ';

  // create the breadcrumb
  $breadCrumb  = '<p class="c-breadcrumb" id="breadcrumbs">';
  $breadCrumb .= '<span xmlns:v="http://rdf.data-vocabulary.org/#"><span typeof="v:Breadcrumb">';
  if($ancestorpageid) $breadCrumb .= '<a href="'.$ancestorpageLink.'" rel="v:url" property="v:title">'.$ancestorpageTitle.'</a>' .$sep;
  $breadCrumb .= '<a href="'.$parentpageLink.'" rel="v:url" property="v:title">'.$parentpageTitle.'</a>';
  if($taxonomy)  $breadCrumb .=  $sep. '<a href="'.$parentpageLink.$categories[0]->slug .'" rel="v:url" property="v:title">'.$categories[0]->name.'</a>';
    $breadCrumb .= $sep.'<span class="breadcrumb_last">'. $pagetitle .'</span></span></span>';
  $breadCrumb .= '</p>';

  echo $breadCrumb;
}


/*------------------------------------*\
:    Add wrapper around submenus
\*------------------------------------*/

class subNavWrap extends Walker_Nav_Menu
{
  function start_lvl(&$output, $depth = 0, $args = array())
  {
    $indent = str_repeat("\t", $depth);
    $output .= "\n$indent<div class=\"c-sub-menu\"><div class=\"c-sub-menu__inner\"><ul class=\"sub\">\n";
  }
  function end_lvl(&$output, $depth = 0, $args = array())
  {
    $indent = str_repeat("\t", $depth);
    $output .= "$indent</ul></div></div>\n";
  }
}

// add button class to home menu
function wpdocs_channel_nav_class( $classes, $item, $args ) {
 
    if ( 'home' === $args->theme_location || 'footer' === $args->theme_location ) {
        $classes[] = "c-button";
    }
 
    return $classes;
}
add_filter( 'nav_menu_css_class' , 'wpdocs_channel_nav_class' , 10, 4 );

// add_filter( 'wp_nav_menu_items', 'addSearch', 10, 2 );

function addSearch($items, $args) {
  $items .= '<li class="menu-item menu-item-type-search"><div class="c-search-button js-toggle-search"><span class="icon-search"></span></div><form class="c-search-form" action="'.get_site_url().'"><input type="search" name="s" placeholder="zoek..." /></form>';
  return $items;
}

/*-----------------------------------------------------------------*\
:   Parkers Multicolor SVG | Include svg multi color (icomoon) icons for css colored variations
:   Usage: <? icon('[$name]','[$variation]') ?>,
:   save svg files in /img/svg/inline/inline-[$variation].svg.php
\*-----------------------------------------------------------------*/

function icon($name,$variation) {
    echo '<span class="h-icon h-icon--'.$name.' h-icon--'.$variation.' h-img-container">';
      get_template_part('img/svg/inline', $name.'.svg');
    echo '</span>';
}

/*------------------------------------*\
:    Miscellaneous
\*------------------------------------*/

// Responsive oEmbed videos
add_filter( 'embed_oembed_html', 'custom_oembed_filter', 10, 4 ) ;
function custom_oembed_filter($html, $url, $attr, $post_ID) {
  // Exlcude twitter cards
  if (preg_match_all("/twitter/", $url, $matches, PREG_SET_ORDER)) {
    return $html;
  } else {
    $return = '<div class="video-container">'.$html.'</div>';
    return $return;
  }
}


// get page depth, used for creating submenu's on deeper depths
function get_page_depth($post) {
  $parent_id  = $post->post_parent;
  $depth = 0;
  while ($parent_id > 0) {
    $page = get_page($parent_id);
    $parent_id = $page->post_parent;
    $depth++;
  }

  return $depth;
}

// trim string eg. trimText("string",100)
function trimText($s,$max_length=100) {
  if (strlen($s) > $max_length) {
    $offset = ($max_length - 2);
    $s = substr($s, 0, $offset) . '<span>...</span>';
  }
  return $s;
}



/*------------------------------------*\
:    Add bidirectional functionality to realtionship fields, ideal for Themegroup <> fellows
\*------------------------------------*/

function bidirectional_acf_update_value( $value, $post_id, $field  ) {
   // vars
  $field_name = $field['name'];
  $field_key = $field['key'];
  $global_name = 'is_updating_' . $field_name;

  // bail early if this filter was triggered from the update_field() function called within the loop below
  // - this prevents an inifinte loop
  if( !empty($GLOBALS[ $global_name ]) ) return $value;

  // set global variable to avoid inifite loop
  // - could also remove_filter() then add_filter() again, but this is simpler
  $GLOBALS[ $global_name ] = 1;

  // loop over selected posts and add this $post_id
  if( is_array($value) ) {
      foreach( $value as $post_id2 ) {

      // load existing related posts
      $value2 = get_field($field_name, $post_id2, false);

      // allow for selected posts to not contain a value
      if( empty($value2) ) {
        $value2 = array();
      }

      // bail early if the current $post_id is already found in selected post's $value2
      if( in_array($post_id, $value2) ) continue;

      // append the current $post_id to the selected post's 'related_posts' value
      $value2[] = $post_id;

      // update the selected post's value (use field's key for performance)
      update_field($field_key, $value2, $post_id2);
    }
  }

  // find posts which have been removed
  $old_value = get_field($field_name, $post_id, false);

  if( is_array($old_value) ) {

    foreach( $old_value as $post_id2 ) {
      // bail early if this value has not been removed
      if( is_array($value) && in_array($post_id2, $value) ) continue;

      // load existing related posts
      $value2 = get_field($field_name, $post_id2, false);

      // bail early if no value
      if( empty($value2) ) continue;

      // find the position of $post_id within $value2 so we can remove it
      $pos = array_search($post_id, $value2);

      // remove
      unset( $value2[ $pos] );

      // update the un-selected post's value (use field's key for performance)
      update_field($field_key, $value2, $post_id2);
    }
  }
  // reset global varibale to allow this filter to function as per normal
  $GLOBALS[ $global_name ] = 0;

  // return
    return $value;
}

// here we set to wich ACF fields this will apply, fields should be defined two sided
//add_filter('acf/update_value/name=themegroup_participants', 'bidirectional_acf_update_value', 10, 3);
//add_filter('acf/update_value/name=project_authors', 'bidirectional_acf_update_value', 10, 3);

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function parker_body_classes( $classes ) {

	if ( is_singular() ) {
		// Adds `singular` to singular pages.
		$classes[] = 'singular';
	} else {
		// Adds `hfeed` to non singular pages.
		$classes[] = 'hfeed';
	}

	// Adds a class if image filters are enabled.
	if ( parker_image_filters_enabled() ) {
		$classes[] = 'image-filters-enabled';
	}

	return $classes;
}
add_filter( 'body_class', 'parker_body_classes' );

/**
 * Adds custom class to the array of posts classes.
 */
function parker_post_classes( $classes, $class, $post_id ) {
	$classes[] = 'entry';

	return $classes;
}
add_filter( 'post_class', 'parker_post_classes', 10, 3 );


/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function parker_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'parker_pingback_header' );

/**
 * Changes comment form default fields.
 */
function parker_comment_form_defaults( $defaults ) {
	$comment_field = $defaults['comment_field'];

	// Adjust height of comment form.
	$defaults['comment_field'] = preg_replace( '/rows="\d+"/', 'rows="5"', $comment_field );

	return $defaults;
}
add_filter( 'comment_form_defaults', 'parker_comment_form_defaults' );

/**
 * Filters the default archive titles.
 */
function parker_get_the_archive_title() {
	if ( is_category() ) {
		$title = single_term_title( '', false );
	} elseif ( is_tag() ) {
		$title = __( 'Tag Archives: ', 'parker' ) . '<span class="page-description">' . single_term_title( '', false ) . '</span>';
	} elseif ( is_author() ) {
		$title = __( 'Author Archives: ', 'parker' ) . '<span class="page-description">' . get_the_author_meta( 'display_name' ) . '</span>';
	} elseif ( is_year() ) {
		$title = __( 'Yearly Archives: ', 'parker' ) . '<span class="page-description">' . get_the_date( _x( 'Y', 'yearly archives date format', 'parker' ) ) . '</span>';
	} elseif ( is_month() ) {
		$title = __( 'Monthly Archives: ', 'parker' ) . '<span class="page-description">' . get_the_date( _x( 'F Y', 'monthly archives date format', 'parker' ) ) . '</span>';
	} elseif ( is_day() ) {
		$title = __( 'Daily Archives: ', 'parker' ) . '<span class="page-description">' . get_the_date() . '</span>';
	} elseif ( is_post_type_archive() ) {
		$title = __( 'Post Type Archives: ', 'parker' ) . '<span class="page-description">' . post_type_archive_title( '', false ) . '</span>';
	} elseif ( is_tax() ) {
		$tax = get_taxonomy( get_queried_object()->taxonomy );
		/* translators: %s: Taxonomy singular name */
		$title = sprintf( esc_html__( '%s Archives:', 'parker' ), $tax->labels->singular_name );
	} else {
		$title = __( 'Archives:', 'parker' );
	}
	return $title;
}
add_filter( 'get_the_archive_title', 'parker_get_the_archive_title' );

/**
 * Determines if post thumbnail can be displayed.
 */
function parker_can_show_post_thumbnail() {
	return apply_filters( 'parker_can_show_post_thumbnail', ! post_password_required() && ! is_attachment() && has_post_thumbnail() );
}

/**
 * Returns true if image filters are enabled on the theme options.
 */
function parker_image_filters_enabled() {
	if ( get_theme_mod( 'image_filter', 1 ) ) {
		return true;
	}
	return false;
}

/**
 * Add custom sizes attribute to responsive image functionality for post thumbnails.
 *
 * @origin Twenty Nineteen 1.0
 *
 * @param array $attr  Attributes for the image markup.
 * @return string Value for use in post thumbnail 'sizes' attribute.
 */
function parker_post_thumbnail_sizes_attr( $attr ) {

	if ( is_admin() ) {
		return $attr;
	}

	if ( ! is_singular() ) {
		$attr['sizes'] = '(max-width: 34.9rem) calc(100vw - 2rem), (max-width: 53rem) calc(8 * (100vw / 12)), (min-width: 53rem) calc(6 * (100vw / 12)), 100vw';
	}

	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'parker_post_thumbnail_sizes_attr', 10, 1 );

/**
 * Returns the size for avatars used in the theme.
 */
function parker_get_avatar_size() {
	return 60;
}

/**
 * Returns true if comment is by author of the post.
 *
 * @see get_comment_class()
 */
function parker_is_comment_by_post_author( $comment = null ) {
	if ( is_object( $comment ) && $comment->user_id > 0 ) {
		$user = get_userdata( $comment->user_id );
		$post = get_post( $comment->comment_post_ID );
		if ( ! empty( $user ) && ! empty( $post ) ) {
			return $comment->user_id === $post->post_author;
		}
	}
	return false;
}

/**
 * Returns information about the current post's discussion, with cache support.
 */
function parker_get_discussion_data() {
	static $discussion, $post_id;

	$current_post_id = get_the_ID();
	if ( $current_post_id === $post_id ) {
		return $discussion; /* If we have discussion information for post ID, return cached object */
	} else {
		$post_id = $current_post_id;
	}

	$comments = get_comments(
		array(
			'post_id' => $current_post_id,
			'orderby' => 'comment_date_gmt',
			'order'   => get_option( 'comment_order', 'asc' ), /* Respect comment order from Settings » Discussion. */
			'status'  => 'approve',
			'number'  => 20, /* Only retrieve the last 20 comments, as the end goal is just 6 unique authors */
		)
	);

	$authors = array();
	foreach ( $comments as $comment ) {
		$authors[] = ( (int) $comment->user_id > 0 ) ? (int) $comment->user_id : $comment->comment_author_email;
	}

	$authors    = array_unique( $authors );
	$discussion = (object) array(
		'authors'   => array_slice( $authors, 0, 6 ),           /* Six unique authors commenting on the post. */
		'responses' => get_comments_number( $current_post_id ), /* Number of responses. */
	);

	return $discussion;
}

/**
 * Add an extra menu to our nav for our priority+ navigation to use
 *
 * @param object $nav_menu  Nav menu.
 * @param object $args      Nav menu args.
 * @return string More link for hidden menu items.
 */
function parker_add_ellipses_to_nav( $nav_menu, $args ) {

	if ( 'menu-1' === $args->theme_location ) :

		$nav_menu .= '<div class="main-menu-more">';
		$nav_menu .= '<ul class="main-menu" tabindex="0">';
		$nav_menu .= '<li class="menu-item menu-item-has-children">';
		$nav_menu .= '<a href="#" class="screen-reader-text" aria-label="More" aria-haspopup="true" aria-expanded="false">' . esc_html__( 'More', 'parker' ) . '</a>';
		$nav_menu .= '<span class="submenu-expand main-menu-more-toggle is-empty" tabindex="-1">';
		$nav_menu .= parker_get_icon_svg( 'arrow_drop_down_ellipsis' );
		$nav_menu .= '</span>';
		$nav_menu .= '<ul class="sub-menu hidden-links">';
		$nav_menu .= '<li id="menu-item--1" class="mobile-parent-nav-menu-item menu-item--1">';
		$nav_menu .= '<span class="menu-item-link-return">';
		$nav_menu .= parker_get_icon_svg( 'chevron_left' );
		$nav_menu .= esc_html__( 'Back', 'parker' );
		$nav_menu .= '</span>';
		$nav_menu .= '</li>';
		$nav_menu .= '</ul>';
		$nav_menu .= '</li>';
		$nav_menu .= '</ul>';
		$nav_menu .= '</div>';

	endif;

	return $nav_menu;
}
add_filter( 'wp_nav_menu', 'parker_add_ellipses_to_nav', 10, 2 );

/**
 * WCAG 2.0 Attributes for Dropdown Menus
 *
 * Adjustments to menu attributes tot support WCAG 2.0 recommendations
 * for flyout and dropdown menus.
 *
 * @ref https://www.w3.org/WAI/tutorials/menus/flyout/
 */
function parker_nav_menu_link_attributes( $atts, $item, $args, $depth ) {

	// Add [aria-haspopup] and [aria-expanded] to menu items that have children
	$item_has_children = in_array( 'menu-item-has-children', $item->classes );
	if ( $item_has_children ) {
		$atts['aria-haspopup'] = 'true';
		$atts['aria-expanded'] = 'false';
	}

	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'parker_nav_menu_link_attributes', 10, 4 );

/**
 * Add a dropdown icon to top-level menu items.
 *
 * @param string $output Nav menu item start element.
 * @param object $item   Nav menu item.
 * @param int    $depth  Depth.
 * @param object $args   Nav menu args.
 * @return string Nav menu item start element.
 * Add a dropdown icon to top-level menu items
 */
function parker_add_dropdown_icons( $output, $item, $depth, $args ) {

	// Only add class to 'top level' items on the 'primary' menu.
	if ( ! isset( $args->theme_location ) || 'menu-1' !== $args->theme_location ) {
		return $output;
	}

	if ( in_array( 'mobile-parent-nav-menu-item', $item->classes, true ) && isset( $item->original_id ) ) {
		// Inject the keyboard_arrow_left SVG inside the parent nav menu item, and let the item link to the parent item.
		// @todo Only do this for nested submenus? If on a first-level submenu, then really the link could be "#" since the desire is to remove the target entirely.
		$link = sprintf(
			'<span class="menu-item-link-return" tabindex="-1">%s',
			parker_get_icon_svg( 'chevron_left', 24 )
		);

		// replace opening <a> with <span>
		$output = preg_replace(
			'/<a\s.*?>/',
			$link,
			$output,
			1 // Limit.
		);

		// replace closing </a> with </span>
		$output = preg_replace(
			'#</a>#i',
			'</span>',
			$output,
			1 // Limit.
		);

	} elseif ( in_array( 'menu-item-has-children', $item->classes, true ) ) {

		// Add SVG icon to parent items.
		$icon = parker_get_icon_svg( 'keyboard_arrow_down', 24 );

		$output .= sprintf(
			'<span class="submenu-expand" tabindex="-1">%s</span>',
			$icon
		);
	}

	return $output;
}
add_filter( 'walker_nav_menu_start_el', 'parker_add_dropdown_icons', 10, 4 );

/**
 * Create a nav menu item to be displayed on mobile to navigate from submenu back to the parent.
 *
 * This duplicates each parent nav menu item and makes it the first child of itself.
 *
 * @param array  $sorted_menu_items Sorted nav menu items.
 * @param object $args              Nav menu args.
 * @return array Amended nav menu items.
 */
function parker_add_mobile_parent_nav_menu_items( $sorted_menu_items, $args ) {
	static $pseudo_id = 0;
	if ( ! isset( $args->theme_location ) || 'menu-1' !== $args->theme_location ) {
		return $sorted_menu_items;
	}

	$amended_menu_items = array();
	foreach ( $sorted_menu_items as $nav_menu_item ) {
		$amended_menu_items[] = $nav_menu_item;
		if ( in_array( 'menu-item-has-children', $nav_menu_item->classes, true ) ) {
			$parent_menu_item                   = clone $nav_menu_item;
			$parent_menu_item->original_id      = $nav_menu_item->ID;
			$parent_menu_item->ID               = --$pseudo_id;
			$parent_menu_item->db_id            = $parent_menu_item->ID;
			$parent_menu_item->object_id        = $parent_menu_item->ID;
			$parent_menu_item->classes          = array( 'mobile-parent-nav-menu-item' );
			$parent_menu_item->menu_item_parent = $nav_menu_item->ID;

			$amended_menu_items[] = $parent_menu_item;
		}
	}

	return $amended_menu_items;
}
add_filter( 'wp_nav_menu_objects', 'parker_add_mobile_parent_nav_menu_items', 10, 2 );

/**
 * Convert HSL to HEX colors
 */
function parker_hsl_hex( $h, $s, $l, $to_hex = true ) {

	$h /= 360;
	$s /= 100;
	$l /= 100;

	$r = $l;
	$g = $l;
	$b = $l;
	$v = ( $l <= 0.5 ) ? ( $l * ( 1.0 + $s ) ) : ( $l + $s - $l * $s );
	if ( $v > 0 ) {
		$m;
		$sv;
		$sextant;
		$fract;
		$vsf;
		$mid1;
		$mid2;

		$m = $l + $l - $v;
		$sv = ( $v - $m ) / $v;
		$h *= 6.0;
		$sextant = floor( $h );
		$fract = $h - $sextant;
		$vsf = $v * $sv * $fract;
		$mid1 = $m + $vsf;
		$mid2 = $v - $vsf;

		switch ( $sextant ) {
			case 0:
				$r = $v;
				$g = $mid1;
				$b = $m;
				break;
			case 1:
				$r = $mid2;
				$g = $v;
				$b = $m;
				break;
			case 2:
				$r = $m;
				$g = $v;
				$b = $mid1;
				break;
			case 3:
				$r = $m;
				$g = $mid2;
				$b = $v;
				break;
			case 4:
				$r = $mid1;
				$g = $m;
				$b = $v;
				break;
			case 5:
				$r = $v;
				$g = $m;
				$b = $mid2;
				break;
		}
	}
	$r = round( $r * 255, 0 );
	$g = round( $g * 255, 0 );
	$b = round( $b * 255, 0 );

	if ( $to_hex ) {

		$r = ( $r < 15 ) ? '0' . dechex( $r ) : dechex( $r );
		$g = ( $g < 15 ) ? '0' . dechex( $g ) : dechex( $g );
		$b = ( $b < 15 ) ? '0' . dechex( $b ) : dechex( $b );

		return "#$r$g$b";

	} else {

		return "rgb($r, $g, $b)";
	}
}
