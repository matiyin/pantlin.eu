<? // Default article loop

 $label = ""; 
   if ($post->post_type == 'customPostType') :
      $categories = get_the_terms( $postloop->ID, 'customPostTypeTerms' );
      if($categories) : 
          $arrayCount = sizeof($categories);
          $count = 1;
          foreach($categories as $i) :
            $label = '<span class="">'. ($i->name);
            if($count < $arrayCount): 
              $label .=  ", ";
              $label .='</span>';
              $count++;
            endif;
          endforeach;
        endif;
    elseif ($postloop->post_type == 'customPostType') :
        $label = get_the_date('j F Y',$postloop->ID);
    endif;

   $url           = isset($postloop->url) ? $postloop->url : get_permalink($postloop->ID);
   $subtitle      = isset($postloop->subtitle) ? $postloop->subtitle : get_field('subtitle',$postloop->ID);
   $afbeeldingid  = isset($postloop->afbeeldingid) ? $postloop->afbeeldingid : $postloop->ID;

?>
 <li class="l-block-list__item">
  <article class="c-link-block"> 
      <a href="<?=$url ?>" class="c-link-block__img h-img-container">
        <?=park_return_img($afbeeldingid,'medium') ?>
      </a>
      <div class="c-link-block__description">
        <a href="<?=$url ?>">
          <?if($label) : ?>
            <span class="c-link-block__label"><?= $label; ?></span>
          <? endif; ?>
          <h3 class="c-link-block__title"><?=$postloop->post_title ?></h3>
          <? if($subtitle) :?>
            <h4 class="c-link-block__subtitle"><? echo $subtitle; ?></h4>
          <? endif ?>
        </a>
        <? //the_excerpt() ?>
    </div>
  </article>
</li>
