<? if( have_rows('ps_content_blocks') ): 
  // Loop through the rows of data
  ?>
  <div class="c-flexible-content-wrapper">
<? while ( have_rows('ps_content_blocks') ) : the_row();
    if( get_row_layout() == 'ps_subtitle' ):
        echo '<div class="l-flexible-content-block"><h2>'.get_sub_field('ps_subtitle_value').'</h2></div>';

    elseif( get_row_layout() == 'ps_subcontent' ): 

        echo '<div class="l-flexible-content-block">'.get_sub_field('ps_subcontent_value').'</div>';

    elseif( get_row_layout() == 'ps_subcontent-border' ): 

        echo '<div class="l-flexible-content-block l-flexible-content-block--border"><span class="lines-1"></span><span class="lines-2"></span>'.get_sub_field('ps_subcontent_block_value').'</div>';

    elseif( get_row_layout() == 'ps_subquote' ): 

        echo '<div class="l-flexible-content-block l-flexible-content-block--small"><div class="c-blockquote heading-04"><q>'.get_sub_field('ps_subquote_value').'</q><div>'.get_sub_field('ps_subquote_author').'</div></div></div>';

    elseif( get_row_layout() == 'ps_subgallery' ): 
        $postows = get_sub_field('ps_subgallery_value');

        if($postows) :
          if(isset($postows[1])) :
            echo '<div class="l-flexible-content-block">';
            echo '<div class="swiper-container">';
            echo '<ul class="swiper-wrapper">';
            foreach($postows as $image) : 
              echo '<li class="swiper-slide h-img-container'.(!empty($image['caption']) ? ' has-caption' : '').'">';
                echo '<img src="' . $image['sizes']['inline'] . '" alt="' . $image['alt'] . '" title="'. $image['caption'] .'"/>';
                if (!empty($image['caption'])) echo '<div class="swiper-caption">'. $image['caption'] .'</div>';
              echo '</li>';
            endforeach;
            echo '</ul>';
            echo '<div class="swiper-button-prev"><</div>';
            echo '<div class="swiper-button-next">></div>';
            echo '<div class="swiper-pagination"></div>';
            echo '</div>';
            echo '</div>';
          else :
            foreach($postows as $image) : 
              echo '<div class="l-flexible-content-block'.(!empty($image['caption']) ? ' has-caption' : '').'">';
                echo '<div class="h-img-container" data-flexible-img>';
                  echo '<img src="' . $image['sizes']['inline'] . '" alt="' . $image['alt'] . '" title="'. $image['caption'] .'"/>';
                  if (!empty($image['caption'])) echo '<div class="swiper-caption">'. $image['caption'] .'</div>';
                echo '</div>';
              echo '</div>';
            endforeach;
          endif;
        endif;


      elseif( get_row_layout() == 'ps_twocolumnlist' ):
        $postrows = get_sub_field('ps_two_column_list_table_row');

        if($postrows) :
         // print_r($postrows);
            echo '<div class="l-flexible-content-block">';
            echo '<table class="l-table-block">';
            echo '<tbody>';
            foreach($postrows as $cell) :
              echo '<tr>';
              echo '<td class="l-table-cell l-table-cell--left">' . $cell['ps_column_left_value'] . '</td>';
              echo '<td class="l-table-cell l-table-cell--right">' . $cell['ps_column_right_value'] . '</td>';
              echo '</tr>';
            endforeach;
            echo '</tbody>';
            echo '</table>';
            echo '</div>';
        endif;


    elseif( get_row_layout() == 'ps_subvideo' ): 

        if(get_sub_field('ps_subvideo_type') == 'youtube') {

        $attachment_id = get_sub_field('ps_subvideo_pframe');
        $size = "large";
        $imageMeta = wp_get_attachment_metadata($attachment_id);
        $image     = wp_get_attachment_image_src( $attachment_id, $size );

          echo '<div class="l-flexible-content-block c-video-container">';
          if( $image ) {
            // With posterframe
            echo '<div class="h-video-container" style="background-image: url('.$image[0].');" title="'.$imageMeta['image_meta']['caption'].'">';
            echo '<iframe data-src="https://www.youtube.com/embed/'.get_sub_field('ps_subvideo_id').'?rel=0&amp;showinfo=0&autoplay=1&iv_load_policy=3" frameborder="0" allowfullscreen ></iframe>';
            echo '<button class="c-playbutton js-play-video"><span class="icon-play"></span></button>';
            echo '</div>';
          } else {
            // without posterframe
            echo '<div class="h-video-container"><iframe src="https://www.youtube.com/embed/'.get_sub_field('ps_subvideo_id').'?rel=0&amp;showinfo=0&autoplay=0&iv_load_policy=3" frameborder="0" allowfullscreen></iframe></div>';
          }
        
          echo '</div>';

        };

        if(get_sub_field('ps_subvideo_type') == 'vimeo') {

        $attachment_id = get_sub_field('ps_subvideo_pframe');
        $size = "large";
        $imageMeta = wp_get_attachment_metadata($attachment_id);
        $image = wp_get_attachment_image_src( $attachment_id, $size );

          echo '<div class="l-flexible-content-block c-video-container">';
          if( $image ) {
            // With posterframe
            echo '<div class="h-video-container" style="background-image: url('.$image[0].');" title="'.$imageMeta['image_meta']['caption'].'">';
            echo '<iframe data-src="https://player.vimeo.com/video/'.get_sub_field('ps_subvideo_id').'?title=0&byline=0&portrait=0&autoplay=1" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
            echo '<button class="c-playbutton js-play-video"><span class="icon-play"></span></button>';
            echo '</div>';
          } else {
            // without posterframe
            echo '<div class="h-video-container"><iframe src="https://player.vimeo.com/video/'.get_sub_field('ps_subvideo_id').'?title=0&byline=0&portrait=0&autoplay=0" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe></div>';
          }
          echo '</div>';

        };

    elseif( get_row_layout() == 'ps_subsoundcloud' ):

          echo '<div class="l-flexible-content-block">';
          echo '<div class="h-sound-container">';
          echo ' <iframe scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/'.get_sub_field('ps_subsoundcloud_value').'&amp;auto_play=false&amp;hide_related=false&amp;show_comments=true&amp;show_user=true&amp;show_reposts=false&amp;visual=true"></iframe>';
          echo '</div>';
          echo '</div>';

    elseif( get_row_layout() == 'ps_sublogos'): 
        
        $postrows = get_sub_field('ps_logos_value');

        if($postrows) :

          echo '<div class="l-flexible-content-block">';
          echo '<ul class="l-logo-list">';
          foreach($postrows as $image) : 
            $url = get_field('ext_url',$image['ID']) ? get_field('ext_url',$image['ID']) : 'javascript:';
            // Logo url is retrieved from image media fields
            echo '<li class="l-logo-list__item">';
            if ($url) {
              echo '<a class="c-logo" href="'.$url.'" target="_blank">';
            }
            echo '<div class="c-logo__img h-img-container">';
            echo '<img src="' . $image['sizes']['medium'] . '" alt="' . $image['alt'] . '" title="'. $image['caption'] .'"/>';
            echo '</div>';
            if ($url) {
              echo '</a>';
            }
            echo '</li>';
          endforeach;

            echo '</ul>';
            echo '</div>';
        endif;

    endif;

endwhile; ?>



</div>
<? endif;?>