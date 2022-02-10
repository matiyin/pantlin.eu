<?php

/**
 * @package WordPress
 * @subpackage pantlineu
 */

get_header(); ?>

<main>

  <a class="c-nav-parent" href="<?= get_bloginfo('url') ?>" title="&laquo; Home">
    <span class="icon-home"></span>
  </a>

  <div class="l-main-grid">

    <div class="l-side">
      <div class="c-side-title"><h1><? the_archive_title(); ?></h1></div>
    </div>

    <div class="l-main-content">
      <article class="c-intro l-reading-plane">
        <? the_archive_description(); ?>
      </article>
    </div>

  </div>

<? if ( have_posts() ) { ?>
  <div class="c-posts">

<? while ( have_posts() ) {
  the_post();
  get_template_part( 'template-parts/blog-content/content' );
}

// Previous/next page navigation.
// parker_the_posts_navigation();
if (  $wp_query->max_num_pages > 1 )
	echo '<div class="c-load-more js-load-more">Read more stories...';
} else {

  echo '<h1>'.__('No posts found.',INI_TEXTDOMAIN).'</h1>';

}
?>

<? get_footer(); ?>
