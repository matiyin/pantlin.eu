
    <div class="c-header-slider swiper-container">
      <ul class="swiper-wrapper">
      <? // Carousel 
      while (have_rows('h_carousel') ) : the_row();

       $car_postid        = get_sub_field('carousel_item');
       $car_postid        = $car_postid[0];
       $car_subtitle      = get_sub_field('alt_subtitle');
       $car_title         = get_sub_field('alt_title');
       $car_text          = get_sub_field('alt_description');
       $car_image         = get_sub_field('alt_image');
       $car_video         = get_field('f_trailer_id', $car_postid, false, false);

       $car_title         = $car_title ? $car_title : get_the_title($car_postid);
       $car_text          = $car_text ? $car_text : get_the_excerpt($car_postid);
       $car_image         = $car_image ? $car_image : $car_postid;
       $car_url           = get_permalink($car_postid);
       $car_url_external  = ""; // not used
       ?>
       <li class="swiper-slide has-caption" <?=park_return_img($car_image,'large_header',true)?>>
        <? if( $car_url  ) : ?><a href="<?=$car_url  ?>" class="c-masthead__block" <? if( $car_url_external ) : ?> target="_blank"<? endif ?>><? endif ?>
          <div class="c-slide__content">
            <?if($car_subtitle) : ?><h3 class="c-slide__subtitle"><?=$car_subtitle ?></h3><? endif ?>
            <h2 class="c-slide__title">
              <?=$car_title ?>
              <? if($car_video) : ?>
                <span class="c-playbutton js-play-trailer" data-fancybox href="<?=$car_video?>"><span class="icon-play"></span></span>
              <? endif ?>
            </h2>
            <?if($car_text) :?><p class="c-slide__text"><?=$car_text ?></p><? endif; ?>
          </div>
          <? if( $car_url  ) : ?></a><? endif; ?>
        </li>
      <? endwhile; ?>
    </ul>
    <!-- <div class="swiper-button-prev"></div> -->
    <!-- <div class="swiper-button-next"></div> -->
    <div class="swiper-pagination"></div>
  </div>