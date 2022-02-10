<?
/**
 * Template part for displaying (blog) posts items in loop
 *
 * @package WordPress
 * @subpackage pantlineu
 * @since 2.1.0
 */

$postid = get_the_id();
$post_class = (is_sticky() ? array('c-post','c-post--sticky') : 'c-post');
$terms = get_the_category($postid);
$term_name = $terms[0]->name;
?>

<article id="post-<?= $postid ?>" <? post_class($post_class) ?>>

  <a href="<? the_permalink() ?>" title="<? _e('Read more', INI_TEXTDOMAIN) ?> &raquo;" rel="bookmark" class="c-post__image">
    <div class="h-img-container" <?= park_return_img($postid,'post-thumb', true) ?>></div>
  </a>

  <div class="c-post__inner l-reading-plane">
    <header class="c-post__header">

      <div class="c-post-meta">
        <?
        parker_reading_time(); // uses Reading Time WP plugin
        if (is_front_page()) parker_post_categories(); // comma seperated list of post categories
        ?>
        <? // if ( is_sticky() && ! is_paged() ) echo 'Featured'; ?>
      </div>

      <h2>
        <a href="<? the_permalink() ?>" title="<? _e('Read more', INI_TEXTDOMAIN) ?> &raquo;" rel="bookmark">
          <? the_title() ?>
        </a>  
      </h2>

    </header><!-- .entry-header -->

    <a href="<? the_permalink() ?>" title="<? _e('Read more', INI_TEXTDOMAIN) ?> &raquo;" rel="bookmark" class="c-post__excerpt">
      <?
      the_excerpt(
        sprintf(
          wp_kses(
            /* translators: %s: Name of current post. Only visible to screen readers */
            __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', INI_TEXTDOMAIN ),
            array(
              'span' => array(
                'class' => array(),
              ),
            )
          ),
          get_the_title()
        )
      );
      ?>
    </a>
    
  </div>
</article>
