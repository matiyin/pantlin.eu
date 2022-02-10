<?php

/**
 * @package WordPress
 * @subpackage pantlineu
 * Template Name: Homepage
 */

get_header();
the_post();

$title = get_bloginfo('title');
$tagline = get_bloginfo('description');
?>

<main>

  <div class="l-main-grid">

    <div class="l-side">

      <? if (has_custom_logo()) : ?>
        <? 
        $custom_logo_id = get_theme_mod( 'custom_logo' );
        $image = wp_get_attachment_image_src( $custom_logo_id , 'full' );
        ?>
        <div class="c-featured-image h-img-container" style="background-image: url('<?= $image[0] ?>');"></div>       
      <? endif; ?>
    </div>

    <div class="l-main-content">
      <article class="l-reading-plane" role="article">
        <h1><?=$title ?></h1>
        <h2 class="tagline"><?=$tagline ?></h2>
        <? the_content() ?>
        <nav class="c-home-nav" aria-label="<? esc_attr_e( 'Home Menu', 'pantlin' ); ?>">
          <? wp_nav_menu( array('theme_location' => 'home')) ?>
        </nav>
      </article>

    </div>

      <? // recent posts
      $recent = new WP_Query(array(
        'post_type' => 'post',
        'posts_per_page' => 2
      ));
      if ($recent->have_posts()) : ?>

      <div class="c-section-title">Latest stories</div>

      <div class="c-posts">
        <? while ( $recent->have_posts() ) {
          $recent->the_post();
          get_template_part( 'template-parts/blog-content/content' );
        } ?>
      </div>

      <? endif ?>

    </div>

<?php get_footer(); ?>