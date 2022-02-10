<?php

/**
 * @package WordPress
 * @subpackage pantlineu
 * Template Name: Wide with Excerpt Intro
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
      <div class="c-intro l-reading-plane">
        <? the_excerpt(); ?>
      </div>
    </div>

  </div>
  
  <div class="l-wide-content">
    <div class="l-wide-content__wrapper">
      <? the_content(); ?>
    </div>
  </div>

<?php get_footer(); ?>