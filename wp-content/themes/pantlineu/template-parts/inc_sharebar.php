<br />
<div class="c-sharebar">
	<span class="c-sharebar__label"><?= _e('Delen');?></span>
	<a class="c-sharebar__item c-button js-share-facebook" href="#" target="_blank"><span class="icon-facebook"></span></a>
	<a class="c-sharebar__item c-button js-share-twitter" href="#" target="_blank"><span class="icon-twitter"></span></a>
	<a class="c-sharebar__item c-button js-share-whatsapp" href="#" data-action="share/whatsapp/share" target="_blank"><span class="icon-whatsapp"></span></a>
</div>

  <script>

    var facebookShareUrl = 'https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent(window.location.href);
    document.getElementsByClassName("js-share-facebook")[0].setAttribute("href", facebookShareUrl);

    var twitterShareUrl ='http://twitter.com/share?url='+ encodeURIComponent(window.location.href);
    document.getElementsByClassName("js-share-twitter")[0].setAttribute("href", twitterShareUrl);

    var whatsappShareUrl ='whatsapp://send?text='+ encodeURIComponent(window.location.href);
    document.getElementsByClassName("js-share-whatsapp")[0].setAttribute("href", whatsappShareUrl);

  </script>

  