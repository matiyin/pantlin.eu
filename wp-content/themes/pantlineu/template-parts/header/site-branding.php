<?php
/**
 * Displays header site branding
 * logo with home link, title, tagline, mainmenu
 *
 * @package WordPress
 * @subpackage pantlineu
 * @since 2.1.0
 */
?>

    <div class="c-site-nav-button js-site-nav-toggle">
        <span class="c-site-nav-button__line c-site-nav-button__line--1"></span>
        <span class="c-site-nav-button__line c-site-nav-button__line--2"></span>
        <span class="c-site-nav-button__line c-site-nav-button__line--3"></span>
    </div>
      
    
      <header class="c-site-header">
      <div class="c-site-header__inner">
        <div class="l-content-container">

          <? // site logo, upload in Theme Customizer, SVG/PNG, set site in inc/theme-config.ini
          if (has_custom_logo()) :
            the_custom_logo(); 
          else :
            $blog_info = get_bloginfo( 'name' ); // site title
            if ( ! empty( $blog_info ) ) :
              if ( is_front_page() && is_home() ) : ?>
                <h1 class="site-title"><a href="<?= esc_url( home_url( '/' ) ); ?>" rel="home"><? bloginfo( 'name' ); ?></a></h1>
              <? else : ?>
                <p class="site-title"><a href="<?= esc_url( home_url( '/' ) ); ?>" rel="home"><? bloginfo( 'name' ); ?></a></p>
              <? endif; ?>
            <? endif;
          endif  ?>

          <? if ( has_nav_menu( 'primary' ) ) : // primary menu ?>
            <nav class="c-site-nav" aria-label="<? esc_attr_e( 'Main Menu', 'emptynest' ); ?>">
              <? wp_nav_menu( array( 
                'theme_location' => 'primary',
                'walker'         => new subNavWrap
              ) ); ?>
            </nav>
          <? endif; ?>
        </div>
      </div>

    </header>