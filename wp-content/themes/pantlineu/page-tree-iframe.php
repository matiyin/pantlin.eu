<?php

/**
 * @package WordPress
 * @subpackage pantlineu
 * Template Name: iframe with tree html
 */

get_header();
the_post();

?>

<main>

  <a class="c-nav-parent" href="<?= get_bloginfo('url') ?>" title="&laquo; Home">
    <span class="icon-home"></span>
  </a>

  <div class="l-main-grid">

    <div class="l-side">
      <div class="c-side-title"><h1><? the_title(); ?></h1></div>
    </div>

    <div class="l-main-content">
      <article class="c-intro l-reading-plane">
        <? the_content(); ?>
      </article>
    </div>

  </div>
  
  <div class="c-iframe">
    <iframe src="//pantlin.eu/TREE/4.htm" onload="injectCss()" height="600" width="100%"></iframe>
  </div>

<?php get_footer(); ?>