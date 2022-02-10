<?php

/**
 * @package WordPress
 * @subpackage pantlineu
 */

get_header();
the_post();

$postid = $post->ID;
$title        = get_the_title();
$featured_img = park_return_img($postid,  'large', true, false);

$terms = get_the_terms($post, 'category');
$term_id = $terms[0]->term_id;

$back_link = get_term_link($term_id, 'category');
$back_link_name = $terms[0]->name;

?>

<main>

  <a class="c-nav-parent" href="<?= $back_link ?>" title="&laquo; <?= $back_link_name ?>">
    <span class="icon-arrow-left"></span>
  </a>

  <div class="l-main-grid">

    <div class="l-side">
      <? if($featured_img) : ?>
        <div class="c-featured-image h-img-container" <?=$featured_img?>></div>
      <? endif; ?>
    </div>

    <div class="l-main-content">
      <article class="l-reading-plane c-blog-content">


        <h1><?=$title ?></h1>
        <div class="c-post-meta">
          <? // uncomment what you don't need
          parker_reading_time(); // uses Reading Time WP plugin
          // parker_posted_by(); // author name + link
          parker_posted_on(); // post date
          parker_post_categories(); // comma seperated list of post categories
          // parker_post_tags(); // comma seperated list of post tags
          parker_comment_count(); // comment count + anchor link to comments
          ?>
        </div>

        <? the_content() ?>

      </article>

      <? // If comments are open or we have at least one comment, load up the comment template.
      if ( comments_open() || get_comments_number() )  comments_template();
      ?>

    </div>


    <? // other posts
    $recent = new WP_Query(array(
      'post_type' => 'post',
      'posts_per_page' => 3,
      'post__not_in' => array ($postid),
      'tax_query' => array(
        array(
            'taxonomy' => 'category',
            'field'    => 'term_id',
            'terms'    => $term_id,
            ),
        ), 
    ));
    if ($recent->have_posts()) : ?>

    <div class="c-section-title">More stories</div>

    <div class="c-posts">
      <? while ( $recent->have_posts() ) {
        $recent->the_post();
        get_template_part( 'template-parts/blog-content/content' );
      } ?>
    </div>

  </div>



  <? endif ?>

<? get_footer(); ?>