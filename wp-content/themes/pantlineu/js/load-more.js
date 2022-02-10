/*------------------------------------*\
:   Ajax load more
\*------------------------------------*/

jQuery(function ($) {
  $('.js-load-more').click(function () {

    var button = $(this),
      data = {
        'action': 'loadmore',
        'query': parkers_loadmore_params.posts,
        'page': parkers_loadmore_params.current_page
      };

    $.ajax({
      url: parkers_loadmore_params.ajaxurl,
      data: data,
      type: 'POST',
      beforeSend: function (xhr) {
        button.text('Loading...'); // change the button text, you can also add a preloader image
      },
      success: function (data) {
        if (data) {
          button.text('More stories').prev().after(data); // insert new posts
          parkers_loadmore_params.current_page++;

          if (parkers_loadmore_params.current_page == parkers_loadmore_params.max_page)
            button.remove(); // if last page, remove the button

        } else {
          button.remove(); // if no data, remove the button as well
        }
      }
    });
  });
});