<?

/**
 * @package WordPress
 * @subpackage pantlin.eu
 */

get_header();
?>

<main class="l-main-content">
  <div class="l-content-container">

		<?
		if ( have_posts() ) { ?>
      <div class="c-posts">

    <?
    while ( have_posts() ) {
      the_post();
      get_template_part( 'template-parts/blog-content/content' );
    }
    
    // Previous/next page navigation.
    parker_the_posts_navigation();

		} else {

			echo '<h1>'.__('No posts found.',INI_TEXTDOMAIN).'</h1>';

		}
		?>
	</div>
</main>

<?
get_footer();