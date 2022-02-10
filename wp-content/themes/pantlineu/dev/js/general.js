var $ = jQuery.noConflict();

/*|\/||\/||\/||\/||\/||\/||\/||\/||\/|*\
:
:    VARIABLES & FUNCTIONS
:
\*|/\||/\||/\||/\||/\||/\||/\||/\||/\|*/


/*------------------------------------*\
:    Layout
\*------------------------------------*/

var body = $('body');
var siteWrapper = $('.l-site-wrapper');
var mainContent = $('.l-main-content');
var bodyWrapper = $('.l-body-wrapper');
var fadeFilter = $('.c-fade-filter');



/*------------------------------------*\
:    Header
\*------------------------------------*/

var siteHeader = $('.c-site-header');
var siteHeaderInner = $('.c-site-header__inner');
var siteNav = $('.c-site-nav');
var siteHeaderHeight = $('.c-site-header').outerHeight(true);

// Collapsed Navigation
var siteNavToggle = $('.js-site-nav-toggle');
var subMenus = $('.c-sub-menu');
var navItemHasChilderen = $('.menu-item-has-children');



/*------------------------------------*\
:    Body Scroll Lock
\*------------------------------------*/

// Enable/Disable scrolling the body

var bodyLockPosition;
var isBodyLocked = false;

function bodyScrollLockEnable() {
  bodyLockPosition = $(window).scrollTop();
  body.addClass('no-scroll');
  bodyWrapper.css({
    '-ms-transform': 'translate(0, -' + (bodyLockPosition) + 'px)',
    'transform': 'translate(0, -' + (bodyLockPosition) + 'px)'
  });
}

function bodyScrollLockDisable() {
  body.removeClass('no-scroll');
  // Return to last position in the body
  bodyWrapper.css({
    '-ms-transform': 'translate(0,' + (0) + 'px)',
    'transform': 'translate(0,' + (0) + 'px)'
  });
  body.scrollTop(bodyLockPosition);
  isBodyLocked = true;
  setTimeout(function() {
    isBodyLocked = false;
  }, 400);
}



/*|\/||\/||\/||\/||\/||\/||\/||\/||\/|*\
:
:    UI FUNCTIONS
:
\*|/\||/\||/\||/\||/\||/\||/\||/\||/\|*/


$(document).ready(function() {

  // inject styles into the iframe
  // if ($('.c-iframe')) {
  //   injectCss();
  // }

  // search expand button
  $('.js-toggle-search').on('click', function() {
    if ($(this).hasClass('is-visible')) {
      $(this).removeClass('is-visible');
      $('.c-search-form').removeClass('is-visible');
      $('.c-search-form input').blur();
      fadeFilter.removeClass('is-active');
    } else {
      $(this).addClass('is-visible');
      $('.c-search-form').addClass('is-visible');
      $('.c-search-form input').focus();
      fadeFilter.addClass('is-active');
    }
  });

  // expand sub menu
  if ($(window).width() > 1024) {
    navItemHasChilderen.on({ mouseenter: function() {
          $(this).addClass('is-open');
      }, mouseleave: function() {
          $(this).removeClass('is-open');
      }
    });
  } else {
    navItemHasChilderen.on('click', function(e) {
      $(this).toggleClass('is-open');
    });
  }


  /*------------------------------------*\
  :    Collapsed Navigation Toggle
  \*------------------------------------*/

  siteNavToggle.on('click', function() {
    if ($(this).hasClass('is-active')) {
      // bodyScrollLockDisable();
      siteNavToggle.removeClass('is-active');
      fadeFilter.removeClass('is-active');
      siteNav.removeClass('is-active');
      navItemHasChilderen.removeClass('is-open'); // close submenu

      if (bodyLockPosition > siteHeaderHeight) {
        siteHeader.addClass('scroll-header');
        siteHeader.addClass('is-visible');
      }
      siteHeader.removeClass('has-menu-open');
      // setTimeout(function() {
      //   siteHeader.removeClass('no-transition');
      // }, 400);


    } else {
      // bodyScrollLockEnable();
      siteNavToggle.addClass('is-active');
      fadeFilter.addClass('is-active');
      siteNav.addClass('is-active');
      siteHeader.addClass('has-menu-open');
      // siteHeader.addClass('no-transition');
    }
  });

  /*------------------------------------*\
  :    Fade Filter
  \*------------------------------------*/

  fadeFilter.on('click', function () {
    siteHeader.removeClass('has-menu-open');
    siteNavToggle.removeClass('is-active');
    fadeFilter.removeClass('is-active');
    siteNav.removeClass('is-active');
    body.removeClass('no-scroll');
  });




  /*------------------------------------*\
  :    Video Containers
  \*------------------------------------*/

  $('.js-play-video').on('click', function() {
      var videoButton = $(this);
      var videoContainer = $(this).closest('.h-video-container');
      var videoFrame = $(this).siblings('iframe');
      var videoSrc = videoFrame.attr("data-src");

      videoContainer.addClass('is-active');
      videoFrame.attr('src', videoSrc);
      videoButton.addClass('is-hidden');
  });
});



/*|\/||\/||\/||\/||\/||\/||\/||\/||\/|*\
:
:    ON LOAD FUNCTIONS
:
\*|/\||/\||/\||/\||/\||/\||/\||/\||/\|*/

$(window).one('load', function() {
    body.addClass('has-loaded');
    //siteWrapper.css('padding-top', siteHeaderInner.outerHeight(true));
    //navScreenPosition();
});



/*|\/||\/||\/||\/||\/||\/||\/||\/||\/|*\
:
:    ON RESIZE FUNCTIONS
:
\*|/\||/\||/\||/\||/\||/\||/\||/\||/\|*/

$(window).on('resize', function() {
    //siteWrapper.css('padding-top', siteHeaderInner.outerHeight(true));
    //navScreenPosition();
    siteHeaderHeight = $('.c-site-header').outerHeight(true);
});



/*|\/||\/||\/||\/||\/||\/||\/||\/||\/|*\
:
:    ON SCROLL FUNCTIONS
:
\*|/\||/\||/\||/\||/\||/\||/\||/\||/\|*/

var didScroll;
var lastScrollTop = 0;
var delta = 50;
var scrollInterval = 50;


/*------------------------------------*\
:    Scroll function which only
:    fires within interval
\*------------------------------------*/

function hasScrolled() {

  var st = $(this).scrollTop();

  if (Math.abs(lastScrollTop - st) <= delta) {
    return;
  }


  /*------------------------------------*\
  :    Detect direction
  \*------------------------------------*/
  if (isBodyLocked === false) {

    if (st > siteHeaderHeight) {
      siteHeader.addClass('scroll-header');
      if (st < lastScrollTop) {
        // Scrolling up
        siteHeader.addClass('is-visible');
      } else {
        // Scrolling down
        siteHeader.removeClass('is-visible');
      }
    } else {
      siteHeader.removeClass('is-visible');
      siteHeader.removeClass('scroll-header');
    }
  }

  // Update scrollTop
  lastScrollTop = st;
}

$(window).scroll(function() {
  didScroll = true;
});

setInterval(function() {
  if (didScroll) {
    hasScrolled();
    didScroll = false;
  }
}, scrollInterval);

/*----------------------------------------------------*\
:    Lazy Parker : lazy load & mobile formats in one
\*----------------------------------------------------*/

var lazyParker = {
  isElementInViewport: function(el) {
    var rect = el.getBoundingClientRect();
    var offset = 300; // out of bounds offset
    return (
      rect.top >= -offset &&
      rect.left >= -offset &&
      rect.bottom <= jQuery(window).height() + offset &&
      rect.right <= jQuery(window).width() + offset
    );
  },
  lazyLoadImages: function() {
    // background images
    var images,
      item,
      selector = ($(window).width() < 768 ? 'lazyparker-bg-mob' : 'lazyparker-bg');
      //console.log('lazy load bg images');
      images = document.querySelectorAll("[data-"+selector+"]");
      // load images that have entered the viewport
      [].forEach.call(images, function(item) {
        if (lazyParker.isElementInViewport(item)) {
          var img_source = item.getAttribute("data-"+selector);
          if (item.nodeName == 'IMG') {
            // handle inline images
            item.setAttribute('src', img_source);
          } else {
            // handle background images
            item.style = 'background-image: url('+img_source+');';
          }
          item.removeAttribute("data-lazyparker-bg");
          item.removeAttribute("data-lazyparker-bg-mob");
          lazyParker.fadeImg(item);
        }
      });
    // if all the images are loaded, stop calling the handler
    if (images.length === 0) {
      window.removeEventListener("DOMContentLoaded", this.lazyLoadImages);
      window.removeEventListener("load", this.lazyLoadImages);
      window.removeEventListener("resize", this.lazyLoadImages);
      window.removeEventListener("scroll", this.lazyLoadImages);
    }
  },
  fadeImg: function(el) {
    el.className += " loaded";
  },
  init: function() {
    this.lazyLoadImages();
    //these handlers will be removed once the images have loaded
    window.addEventListener("DOMContentLoaded", this.lazyLoadImages);
    window.addEventListener("load", this.lazyLoadImages);
    window.addEventListener("resize", this.lazyLoadImages);
    window.addEventListener("scroll", this.lazyLoadImages);
  }
};

/* inject css file into iframe */
function injectCss() {
  var iframe = $('.c-iframe iframe'),
    content = iframe.contents(),
    body = iframe.find('body'),
    styleSheet = content.find('head').append('<link></link>').children('link');
  styleSheet.attr('rel', 'stylesheet');
  styleSheet.attr('href', 'https://pantlin.eu/wp-content/themes/pantlineu/css/dist/iframe.css');
}