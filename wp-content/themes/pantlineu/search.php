<?php
/**
 * @package WordPress
 * @subpackage Emptynest
 */
get_header(); ?>

<main class="l-main-content">
  <div class="l-content-container">

   <?php if ( have_posts() ) : ?>
    <header>
      <h1><?_e('Zoekeresultaat','emptynest') ?></h1>
      <h2><?php printf( __( 'Gezocht op: %s', 'emptynest' ), '<span>' . esc_html( get_search_query() ) . '</span>' ); ?></h2>
    </header>
    
    <?php while ( have_posts() ) : the_post(); ?>
      
      <article>
        <ul>
          <li><?=park_return_img($post->ID,'medium')?></li>
          <li>
            <h2><?php the_title(); ?></h2>
            <? the_excerpt(); ?>
            <a href="<? the_permalink() ?>" title="<? _e('Lees verder','emptynest') ?> &raquo;">Lees meer</a>
          </li>
        </ul>
      </article>

    <?php endwhile; ?>


  <?php endif; ?>
  </div>

<?php get_footer(); ?>