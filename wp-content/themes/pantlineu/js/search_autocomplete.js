jQuery( function ($) {

  // create an jq-ui autocomplete on your selected element
  $( '.c-filter-search__input' ).autocomplete( {
     minLength: '3',
    //appendTo: '.c-filter-search',  optional, the place where the autocomplete pulldown is placed
    // use a function for its source, which will return ajax response
    source: function(request, response){

      // well use opts.ajax_url which we enqueued with WP
      $.post( opts.url, {
            action: 'search_autocomplete',            // our action is called search
            term: request.term,           // and we get the term com jq-ui
            posttype: $('#ac_posttype').val() // create a hidden field where to define the posttype
        }, function(data) {
          // when we get data from ajax, we pass it onto jq-ui autocomplete
          //response(data);
            response($.map(data, function(item) {
                return $('<span></span>').html(item.label).text();
            }));
        }, 'json'
      );
    },
    // next, is the select behaviour
    // on select do your action
    select: function(evt, ui) {
      //evt.preventDefault();

      // here you can call another AJAX action to save the option
      // or whatever

    },
  } );
} ( jQuery ) );