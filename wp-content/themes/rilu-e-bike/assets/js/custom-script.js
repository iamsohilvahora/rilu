/* slick slider */
var $status = jQuery('.pagingInfo');
var $slickElement = jQuery('.slider');

$slickElement.on('init reInit afterChange', function (event, slick, currentSlide, nextSlide) {
  //currentSlide is undefined on init -- set it to 0 in this case (currentSlide is 0 based)
  var i = (currentSlide ? currentSlide : 0) + 1;
  $status.text(i + '/' + slick.slideCount);
});

$slickElement.slick({
    prevArrow: false,
    nextArrow: false,
    dots: true,
    autoplay: true,
    autoplaySpeed: 2000
});

/* sticky header on scroll */
jQuery(window).scroll(function() 
{
 if (jQuery(this).scrollTop() > 1)
 {
  jQuery('.top-line').css('height','0');
  jQuery('#masthead').addClass("fixed-header");
 }
 else
 {
  jQuery('.top-line').css('height','40px');
  jQuery('#masthead').removeClass("fixed-header");
 }
});

/* youtube video play on custom button */
jQuery('#play').on('click', function(e) {
	e.preventDefault();
	jQuery("#player")[0].src += "?autoplay=1";
	jQuery('#player').show();
	jQuery('#video-cover').hide();
	jQuery('#play').hide();
})

/*Search pin dropdown*/
jQuery('.dropdownsearch').on('keyup', function () {
  var value = jQuery(this).val();
  var $parent = jQuery(this).closest('.pincode-dropdown');
  var results = 0;
  jQuery('ul li:not(.searchInput):not(.noresults)', $parent).each(function (index) {
    jQuery(this).hide();
      if (jQuery(this).is(':contains("' + value + '")')) {
          jQuery(this).show();
          results = 1;
      }
  });
  if (results == 0) {
      if (!jQuery('.noresults', $parent).length) {
        jQuery('ul', $parent).append('<li class="noresults">No results found</li>');
      }
  } else {
    jQuery('.noresults', $parent).remove();
  }
});
jQuery('.pincode-dropdown button').on('click', function () {
  jQuery('.pincode-dropdown ul').hide();
  jQuery(this).siblings('ul').show();
  jQuery(this).siblings('ul').children('.searchInput').children('input').focus();
})
jQuery('.pincode-dropdown ul li:not(.searchInput)').on('click', function () {
  var line_text = jQuery(this).text();
  console.log(line_text);
  jQuery(this).parent('ul').siblings('button').text(line_text);
  jQuery(this).parent('ul').hide();
  jQuery(this).sibling('.searchInput').child('.dropdownsearch').val('');
});
// jQuery('html').on('click', function (e) {
//   if (jQuery(e.target).parents('.pincode-dropdown').length == 0 && jQuery(e.target).siblings('.pincode-dropdown').length == 0 && jQuery(e.target).children('.pincode-dropdown').length == 0) {
//     jQuery('.pincode-dropdown ul').hide();
//     jQuery('.dropdownsearch').val('').keyup();
//   }
// });

/* tab responsive */
jQuery(document).on('click', '.product-detail-tab li', function(){
  jQuery('.product-detail-tab li').removeClass('active');
  jQuery('.product-detail-tab').toggleClass('expanded');
  jQuery(this).addClass('active');
  var tab_id = jQuery(this).attr('data-tab');
  jQuery('.tab-content').removeClass('current');
  jQuery(this).addClass('current');
  jQuery('#'+tab_id).addClass('current');
});

/*product sticky tab*/
var el = jQuery('.product-banner');  //this would just be your selector
var bottom = el.height();
jQuery(window).scroll(function(){
    if (jQuery(window).scrollTop() >= (bottom)) {
      jQuery('.tab-line').addClass('fixed-tab');
    }
    else {
      jQuery('.tab-line').removeClass('fixed-tab');
    }
});

/*hide dropdown on mobile*/
jQuery(document).on('click', function (e) {
  if (jQuery(e.target).closest(".product-detail-tab").length === 0) {
    jQuery(".product-detail-tab").removeClass("expanded");
  }
});

/*warranty slider*/
jQuery('.product-detail-tab li[data-tab="warranty"]').click(function(){
  jQuery('.slick-carousel').slick({
    arrows: false,
    centerPadding: "0px",
    dots: true,
    slidesToShow: 1,
    infinite: false
  });
})

/*show-hide popup on click*/
jQuery('.popup-toggle').on('click', function(e) {
  e.preventDefault();
  jQuery('#change-location').toggleClass('is-visible');
});

/*review slider*/
jQuery('.review-slider').slick({
  arrows: false,
  centerPadding: "0px",
  dots: true,
  slidesToShow: 1,
  infinite: false
});

/*category-slider*/
jQuery('.category-slider').slick({
  arrows: false,
  centerPadding: "0px",
  dots: true,
  slidesToShow: 3,
  slidesToScroll: 3,
  responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2,
      }
    },
    {
      breakpoint: 768,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2,
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1,
      }
    }
  ]
});

/*team slider*/
jQuery(document).ready(function() {
  var team_slider = jQuery('.team-slider').slick({
    dots: false,
    slidesToShow: 1,
    slidesToScroll: 1,
    infinite: false,
  });
});

/*scroll to top for sticky tab*/
jQuery('.product-detail-tab li[data-tab]').click(function(){
  jQuery('html, body').animate({
    'scrollTop' : jQuery(".main-content-area").position().top
  },1000);
});

/*faq accordian*/
jQuery('.accordion-list > li > .answer').hide();
jQuery('.accordion-list > li').click(function() {
  if (jQuery(this).hasClass("active")) {
    jQuery(this).removeClass("active").find(".answer").slideUp();
  } else {
    jQuery(".accordion-list > li.active .answer").slideUp();
    jQuery(".accordion-list > li.active").removeClass("active");
    if(jQuery(window).width() <= 767){
      setTimeout(function () {
        var scroll_div = jQuery(".accordion-list > li.active").offset();
        var position = jQuery('.accordion-list').scrollTop() + scroll_div.top
        jQuery('html, body').animate({
          'scrollTop' : position - 100
        });
      },500);
    }
    jQuery(this).addClass("active").find(".answer").slideDown();
  }
  return false;
});
