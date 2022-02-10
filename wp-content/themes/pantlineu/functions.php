<?php

/**
 * @package Wordpress
 * @subpackage Emptynest
 */


/*------------------------------------*\
:    Theme Configuration
\*------------------------------------*/

// variables are set in external file
$config = parse_ini_file("inc/theme-config.ini");
// define them so they can be used in WP environment, eg. INI_TEXTDOMAIN is the get_text translation domain
foreach ($config as $key => $value)
  define('INI_'.$key, $value);

/*------------------------------------*\
:    Theme GLOBALS
\*------------------------------------*/

// define paths
define('TEMPLATE_PATH', get_bloginfo('template_url'));
define('TEMPLATE_DIR', get_template_directory());
define( 'IMAGE_PATH', TEMPLATE_PATH.'/img/' );
// get current version, set in style.css in template root
define( 'REL_VERSION', wp_get_theme()->get('Version'));

/*------------------------------------------------*\
:   SET UP common theme defaults and registers
:   support for various WordPress features.
\*------------------------------------------------*/
function parker_setup() {

  /*
    * Make theme available for translation.
    * Translations can be filed in the /languages/ directory.
    * Textdomain is defined in inc/theme-config.ini
    */
  load_theme_textdomain( INI_TEXTDOMAIN, TEMPLATE_DIR. '/languages' );

  // Add default posts and comments RSS feed links to head.
  add_theme_support( 'automatic-feed-links' );

  // Let WordPress manage the document title.
  add_theme_support( 'title-tag' );

  // Enable support for Post Thumbnails on posts and pages.
  add_theme_support( 'post-thumbnails' );
  // set_post_thumbnail_size( 1568, 9999 );
  // set_post_thumbnail_size(50, 50, array('center', 'center'));

  // add custom image sizes
  add_image_size( 'post-thumb', 600, 600, true );
  //add_image_size( 'fullscreen', 1920, 1080, true );

  // Register menus
  register_nav_menus(
    array(
      'primary' => __( 'Hoofdmenu', 'theme_admin' ),
      'home' => __( 'Home menu', 'theme_admin' ),
      'footer' => __( 'Footer menu', 'theme_admin' )
    )
  );
  
  // Switch default core markup for search form, comment form, and comments to output valid HTML5.
  add_theme_support(
    'html5',
    array('search-form','comment-form','comment-list','gallery','caption','shortcodes')
  );

  /**
   * Add support for core custom logo.
   *
   * @link https://codex.wordpress.org/Theme_Logo
   */
  add_theme_support(
    'custom-logo',
    array(
      'height'      => INI_LOGO_HEIGHT,
      'width'       => INI_LOGO_WIDTH,
      'flex-width'  => true, // set to true to skip cropping and allow for SVG
      'flex-height' => true
    )
  );

  // Add theme support for selective refresh for widgets.
  add_theme_support( 'customize-selective-refresh-widgets' );

  // Add support for Gutenberg Block Styles.
  add_theme_support( 'wp-block-styles' );

  // Add support for Gutenberg full and wide align images.
  add_theme_support( 'align-wide' );

  // Add support for editor styles.
  add_theme_support( 'editor-styles' );

  // Enqueue editor styles.
  add_editor_style( '/css/editor_style.css' );

  // disable custom editor font sizes.
  add_theme_support('disable-custom-font-sizes');

  // Add custom editor font sizes.
  add_theme_support(
    'editor-font-sizes',
    array(
      array(
        'name'      => __( 'Small', 'parker' ),
        'shortName' => __( 'S', 'parker' ),
        'size'      => 19.5,
        'slug'      => 'small',
      ),
      array(
        'name'      => __( 'Normal', 'parker' ),
        'shortName' => __( 'M', 'parker' ),
        'size'      => 22,
        'slug'      => 'normal',
      ),
      array(
        'name'      => __( 'Large', 'parker' ),
        'shortName' => __( 'L', 'parker' ),
        'size'      => 36.5,
        'slug'      => 'large',
      ),
      // array(
      //   'name'      => __( 'Huge', 'parker' ),
      //   'shortName' => __( 'XL', 'parker' ),
      //   'size'      => 49.5,
      //   'slug'      => 'huge',
      // ),
    )
  );

  // disable editor color palette
  add_theme_support('disable-custom-colors');

  // Editor color palette.
  // add_theme_support(
  //   'editor-color-palette',
  //   array(
  //     array(
  //       'name'  => __( 'Primary', 'parker' ),
  //       'slug'  => 'primary',
  //       'color' => parker_hsl_hex( 'default' === get_theme_mod( 'primary_color' ) ? 199 : get_theme_mod( 'primary_color_hue', 199 ), 100, 33 ),
  //     ),
  //     array(
  //       'name'  => __( 'Secondary', 'parker' ),
  //       'slug'  => 'secondary',
  //       'color' => parker_hsl_hex( 'default' === get_theme_mod( 'primary_color' ) ? 199 : get_theme_mod( 'primary_color_hue', 199 ), 100, 23 ),
  //     ),
  //     array(
  //       'name'  => __( 'Dark Gray', 'parker' ),
  //       'slug'  => 'dark-gray',
  //       'color' => '#111',
  //     ),
  //     array(
  //       'name'  => __( 'Light Gray', 'parker' ),
  //       'slug'  => 'light-gray',
  //       'color' => '#767676',
  //     ),
  //     array(
  //       'name'  => __( 'White', 'parker' ),
  //       'slug'  => 'white',
  //       'color' => '#FFF',
  //     ),
  //   )
  // );

  // Add support for responsive embedded content.
  add_theme_support( 'responsive-embeds' );

  // no admin bar on front
  if (INI_WP_HIDE_ADMIN_BAR) add_filter('show_admin_bar', '__return_false');


}
add_action( 'after_setup_theme', 'parker_setup' );

/*------------------------------------*\
:    Load theme scripts in footer
\*------------------------------------*/

function _load_scripts() {
  if (!is_admin()) {

    // jquery
    if (INI_USE_JQUERY) {
      wp_enqueue_script( 'jquery' );
    }
    // define js modules, set in inc/theme-config.ini
    if (INI_USE_SWIPER)
      wp_enqueue_script('swiper', TEMPLATE_PATH.'/js/vendor/swiper.min.js', array(), '4.2.2', true);
    if (INI_USE_ISOTOPE)
      wp_enqueue_script('isotope', TEMPLATE_PATH.'/js/vendor/isotope.min.js', array(), '3.0.6', true);
    if (INI_USE_FANCYBOX)
      wp_enqueue_script('fancybox', TEMPLATE_PATH.'/js/vendor/jquery.fancybox.min.js', array(), '3.3.5', true);
    if (INI_USE_JQUERYUI)
      wp_enqueue_script('jqueryUI', TEMPLATE_PATH.'/js/vendor/jquery-ui.min.js', array(), '1.12.1', true); 

    // wp native comments js
    if (INI_USE_COMMENTS && is_singular() && comments_open() && get_option( 'thread_comments' ))
		  wp_enqueue_script( 'comment-reply' );

    // custom parkers js
    if (!SITE_LIVE) {
      // common shared handy js functions and features, remove what you don't need
      wp_enqueue_script('parker', TEMPLATE_PATH.'/dev/js/parker.js', array(), microtime(), true);
      // add your own custom js code here
      wp_enqueue_script('general', TEMPLATE_PATH.'/dev/js/general.js', array(), microtime(), true);
    } else {
      // concatenated version of general.js and parker.js, generated with '/dev/grunt build'
      wp_enqueue_script('scripts', TEMPLATE_PATH.'/js/scripts.min.js', array(), REL_VERSION, true);
    }

    // if comments are open and threaded, include this wp core script to expand to load the ajax reply form
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) { 
        wp_enqueue_script( 'comment-reply' ); 
    }
  }
}
add_action('wp_enqueue_scripts', '_load_scripts');


/*------------------------------------*\
:    Load minified theme styles for LIVE
\*------------------------------------*/

function _load_styles() {
  if(SITE_LIVE)
    wp_enqueue_style('baseCSS', TEMPLATE_PATH . '/css/dist/style.css?', array(), REL_VERSION, 'all'); // Base stylesheet
}
add_action('wp_enqueue_scripts', '_load_styles');


/*------------------------------------*\
:    Parkers Gutenberg setup:
:    - Allowed core blocks
:    - Custom blocks
:    - Custom block styling
\*------------------------------------*/

// Enqueue block styles on in editor (optional)
function parker_block_styles() {
   wp_enqueue_style( 'parker-blocks', get_stylesheet_directory_uri() . '/css/dist/editor.css' );
  //  wp_enqueue_style( 'parker-blocks', 'https://i.icomoon.io/public/82bf3ccaa0/EmptynestDEV/style.css' );
}
add_action( 'enqueue_block_editor_assets', 'parker_block_styles' );

// Adds new block categories to Gutenberg Block selection UI
function parker_block_categories( $categories, $post ) {
    return array_merge(
        $categories,
        array(
            array(
                'slug' => 'custom',
                'title' => __( 'Parker Blocks', 'emptynest' ),
                'icon'  => '<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path fill="none" d="M0 0h24v24H0V0z" /><path d="M19 13H5v-2h14v2z" /></svg>',
            ),
        )
    );
}
add_filter( 'block_categories', 'parker_block_categories', 10, 2 );

// define which core blocks should be visible in the editor
function allowed_core_gutenberg_blocks() {
  return array(
    // [COMMON]
    'core/heading',
    'core/paragraph',
    'core/image',
    'core/gallery',
    'core/audio',
    'core/list',
    'core/quote', // <blockquote> style
    'core/file',
    'core/video', // for uploaded videos
    // 'core/cover-image', // image bg with title

    // [FORMATTING]
    'core/table',
    // 'core/verse', // Insert poetry. Use special spacing formats. Or quote song lyrics (alternative/additional block quote style)
    // 'core/code', // code snippets that respect your spacing and tabs
    // 'core/freeform', // WP Classic Editor
    'core/html', //Custom HTML
    // 'core/preformatted', // text that respects your spacing and tabs, and also allows styling
    // 'core/pullquote', // special visual emphasis for a quote.

    // [LAYOUT]
    'core/separator', // horizontal separator between blocks - Short Line, Wide Line, Dots
    'core/spacer', // to create an extra padding between blocks
    'core/text-columns', // css columns (2-6) that can hold text or other blocks
    'core/button', // button with text, link and custom styling
    // 'core/media-text', // media and words side-by-side 
    // 'core/more', // Mark the excerpt of this content. Content before this block will be shown in the excerpt on your archives page
    // 'core/nextpage', // Separate your content into a multi-page experience

    // [WIDGETS]
    'core/shortcode', // enable if you plan to use custom shortcodes
    // 'core/archives', // wp native widget
    // 'core/categories', // wp native widget
    // 'core/latest-comments', // wp native widget
    // 'core/latest-posts' // wp native widget

    // [EMBEDS]
    // most used
    // 'core/embed',
    'core-embed/twitter',
    'core-embed/youtube',
    'core-embed/facebook',
    'core-embed/instagram',
    // 'core-embed/wordpress',
    'core-embed/soundcloud',
    // 'core-embed/spotify',
    'core-embed/flickr',
    'core-embed/vimeo',
    // 'core-embed/animoto',
    // 'core-embed/cloudup',
    // 'core-embed/collegehumor',
    // 'core-embed/dailymotion',
    // 'core-embed/funnyordie',
    // 'core-embed/hulu',
    // 'core-embed/imgur',
    // 'core-embed/issuu',
    // 'core-embed/kickstarter',
    // 'core-embed/meetup-com',
    // 'core-embed/mixcloud',
    // 'core-embed/photobucket',
    'core-embed/polldaddy',
    // 'core-embed/reddit',
    // 'core-embed/reverbnation',
    // 'core-embed/screencast',
    // 'core-embed/scribd',
    'core-embed/slideshare',
    // 'core-embed/smugmug',
    // 'core-embed/speaker',
    'core-embed/ted',
    // 'core-embed/tumblr',
    // 'core-embed/videopress',
    // 'core-embed/wordpress-tv',
  );
}
// add_filter( 'allowed_block_types', 'allowed_core_gutenberg_blocks' );

function my_gutenberg_blocks() {
  return array(
    'acf/navheader',
    'acf/accordion',
    'acf/logoslider',
    'acf/slideshow',
    'acf/video-header',
    'acf/form',
    'acf/video-embed',
  );
}
//add_filter( 'allowed_block_types', 'my_gutenberg_blocks' );

/*------------------------------------*\
:    Extra WordPress Features
\*------------------------------------*/

// Add excerpt support to pages, set in inc/theme-config.ini
function add_excerpt_pages() {
  add_post_type_support( 'page', 'excerpt' );
}
if (INI_WP_PAGE_EXCERPTS) add_action('init', 'add_excerpt_pages');

// Allow SVG upload, set in inc/theme-config.ini
function cc_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
if (INI_WP_ALLOW_SVG_UPLOAD) add_filter('upload_mimes', 'cc_mime_types');


/*------------------------------------*\
:    WordPress Cleanup
\*------------------------------------*/

// Remove jquery migrate from WP
add_filter( 'wp_default_scripts', 'dequeue_jquery_migrate' );
function dequeue_jquery_migrate( &$scripts){
    if(!is_admin()){
        $scripts->remove( 'jquery');
        $scripts->add( 'jquery', false, array( 'jquery-core' ));
    }
}

// Remove WP Emoji
remove_action( 'wp_head', 'print_emoji_detection_script', 7);
remove_action( 'wp_print_styles', 'print_emoji_styles');
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

// Remove Wp Embed (not oEmbed!) JS https://make.wordpress.org/core/2015/10/28/new-embeds-feature-in-wordpress-4-4/
function remove_wp_embed_js(){
  wp_deregister_script( 'wp-embed' );
}
add_action( 'wp_footer', 'remove_wp_embed_js' );

// Cleanup WordPress head
remove_action( 'wp_head', 'wp_generator');
remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );
remove_action( 'wp_head', 'wlwmanifest_link');
remove_action( 'wp_head', 'rsd_link');


/*------------------------------------*\
:   Additional plugin functions
\*------------------------------------*/

// Prio Yoast meta box
add_filter( 'wpseo_metabox_prio', function() { return 'low';});

/** override yoast og:image full size **/
// function sc_opengraph_image_size() {
//     return "bg_img_mob";
// }
// add_filter('wpseo_opengraph_image_size','sc_opengraph_image_size',10,1);

// ACF Options
if( function_exists('acf_add_options_page') ) {
    acf_add_options_page('Options');
}

// Googlemaps API key for CMS, set in inc/theme-config.ini
function my_acf_init() {
  acf_update_setting('google_api_key', INI_GOOGLEMAP_API_KEY);
}
if (INI_GOOGLEMAP_API_KEY) add_action('acf/init', 'my_acf_init');

/**
 * Theme Customizer to set basic theme options (Appearance > Themes > Customize)
 * @supports:
 * - Site Identity: Logo, Title, Tagline, Site Icon (favicon)
 */
require TEMPLATE_DIR. '/inc/customizer.php';

/**
 * Shortcodes and widget definitions
 */
require TEMPLATE_DIR. '/inc/shortcodes-widgets.php';

/**
 * Set of our most used template functions, remove what you don't need
 */
require TEMPLATE_DIR. '/inc/parker-functions.php';

/**
 * SVG Icons class.
 */
if (INI_ENABLE_BLOG_PARTS) require TEMPLATE_DIR. '/classes/class-parker-svg-icons.php';

/**
 * Custom Comment Walker template.
 */
if (INI_ENABLE_BLOG_PARTS) require TEMPLATE_DIR. '/classes/class-parker-walker-comment.php';

/**
 * Functions for default blog functionality with posts, authors, comments, etc
 */
if (INI_ENABLE_BLOG_PARTS) require TEMPLATE_DIR. '/inc/parker-blog-functions.php';

/**
 * Add your own new custom template functions to this file
 */
require TEMPLATE_DIR. '/inc/custom-functions.php';
