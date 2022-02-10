<?php
/**
 * @package WordPress
 * @subpackage pantlin.eu
 */

$copyright_text = get_field('copyright_text','options');
?>
	<div class="footer-push"></div>
  </main>

   <footer class="c-site-footer">
      <div class="l-content-container">
        
        <div class="c-site-footer__inner">
          <nav class="c-footer-nav" aria-label="<? esc_attr_e( 'Footer Menu', 'pantlin' ); ?>">
            <? wp_nav_menu( array( 'theme_location' => 'footer') ); ?>
          </nav>
          <img src="<?= IMAGE_PATH ?>/My-Family-Tree_300.png" />
          <p>&copy; <?= date('Y') ?> <? if (isset($copyright_text) && !empty($copyright_text)) { echo $copyright_text; } else { bloginfo('name'); } ?></p>
        </div>
      </div>
    </div>
  </footer>

	</div>

	<div class="c-fade-filter"></div>

  <?php wp_footer(); ?>
</body>
</html>
