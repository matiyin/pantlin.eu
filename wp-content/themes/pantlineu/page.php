<?php

/**
 * @package WordPress
 * @subpackage pantlineu
 */

get_header();
the_post();

$title        = get_the_title();
$featured_img = park_return_img($post->ID,'large');
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
      <article class="l-reading-plane">
        
        <? if($featured_img) : ?>
        <div class="h-img-container">
          <?=$featured_img?>
        </div>
        <? endif; ?>
        <? the_content() ?>
      </article>
    </div>
  </div>

<?php get_footer(); ?>