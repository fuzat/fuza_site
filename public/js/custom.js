$(document).ready(function () {
    $('.dropdown-sub').on("click", function (e) {
        $(this).next('ul').toggle();
        e.stopPropagation();
        e.preventDefault();
    });
});
$(document).ready(function () {
    function bannerfull() {
        var owl = $('.bannerfull');
        owl.owlCarousel({
            margin: 0,
            loop: true,
            autoplay: true,
            nav: true,
            dots: true,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1,
                    nav: false,
                },
                767: {
                    items: 1,
                    nav: false,
                },
                1000: {
                    items: 1
                },
            }
        });
    }
    bannerfull();
});
$(document).ready(function () {
    function bannerpost() {
        var owl = $('.bannerpost');
        owl.owlCarousel({
            margin: 0,
            loop: true,
            autoplay: true,
            nav: true,
            dots: true,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1,
                    nav: false,
                },
                767: {
                    items: 1,
                    nav: false,
                },
                1000: {
                    items: 1
                },
            }
        });
    }
    bannerpost();
});
$(document).ready(function () {
    $(".thumbnails-list").owlCarousel({
        margin: 0,
        loop: true,
        items: 5,
        dots: false,
        mouseDrag: true,
        touchDrag: true,
        pullDrag: false,
        rewind: true,
        autoplay: false,
        nav: true,
        navText: [
            '<span aria-label="' + 'Previous' + '" class="' + 'ic_main' + '">&#xe02a;</span>',
            '<span aria-label="' + 'Next' + '"  class="' + 'ic_main' + '">&#xe02b;</span>'
        ]
    });
});
$(document).ready(function () {
    function banner_cus() {
        var owl = $('.banner-cus');
        owl.owlCarousel({
            margin: 20,
            loop: true,
            autoplay: false,
            nav: true,
            dots: false,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 2,
                },
                767: {
                    items: 2,
                },
				768: {
                    items: 4,
                },
                1000: {
                    items: 5, 
                },
            }
        });
    }
    banner_cus(); 
});
$(document).ready(function () {
    function slide_footer() {
        var owl = $('.slide_footer');
        owl.owlCarousel({
			center:true,
            margin: 15,
            loop: true,
            autoplay: true,
            nav: false,
            dots: false,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 2.5,
                    nav: false,
                },
                767: {
                    items: 2.5,
                    nav: false,
                },
				768: {
                    items: 3.5,
                    nav: false,
                },
                1000: {
                    items: 4.5, 
                },
            }
        });
    }
    slide_footer(); 
});
$(document).ready(function () {
    function slide_about() {
        var owl = $('.slide_about');
        owl.owlCarousel({
            margin: 15,
            loop: false,
            autoplay: true,
            nav: false,
            dots: true,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 2,
                    nav: false,
                },
                767: {
                    items: 2,
                    nav: false,
                },
				768: {
                    items: 2,
                    nav: false,
                },
                1000: {
                    items: 3, 
                },
            }
        });
    }
    slide_about(); 
});
$(document).ready(function () {
    function slide_news() {
        var owl = $('.slide_news');
        owl.owlCarousel({
            margin: 0,
            loop: true,
            autoplay: true,
            nav: true,
            dots: true,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1,
                    nav: false,
                },
                767: {
                    items: 1,
                    nav: false,
                },
                1000: {
                    items: 1
                },
            }
        });
    }
    slide_news();
});

$(".btn_search").click(function () {
    $(".btn_search").css("display", "none");
    $(".search_box").css("display", "block");
    $(".btn_close").css("display", "inline-block");
});
$(".btn_close").click(function () {
    $(".btn_search").css("display", "inline-block");
    $(".search_box").css("display", "none");
    $(".btn_close").css("display", "none");
});

$('.tabs .tab-button-outer a').click(function (e) { e.preventDefault(); });
$('.tabs .tab-button-outer li').click(function () {
    $('.tabs .tab-button-outer li').removeClass('is-active');
    $('.tabs .tab-contents').hide();
    $(this).addClass('is-active');
    $('.tabs ' + $(this).find('a').attr('href')).show();
    $('.tabs .tab-button-outer li.is-active:first').click();


});



// tab
/*

$(function() {
    var $tabButtonItem = $('#tab-button li'),
        $tabSelect = $('#tab-select'),
        $tabContents = $('.tab-contents'),
        activeClass = 'is-active';

    $tabButtonItem.first().addClass(activeClass);
    $tabContents.not(':first').hide();

    $tabButtonItem.find('a').on('click', function(e) {
        var target = $(this).attr('href');

        $tabButtonItem.removeClass(activeClass);
        $(this).parent().addClass(activeClass);
        $tabSelect.val(target);
        $tabContents.hide();
        $(target).show();
        e.preventDefault();
    });

    $tabSelect.on('change', function() {
        var target = $(this).val(),
            targetSelectNum = $(this).prop('selectedIndex');

        $tabButtonItem.removeClass(activeClass);
        $tabButtonItem.eq(targetSelectNum).addClass(activeClass);
        $tabContents.hide();
        $(target).show();
    });
});*/

// select all thumbnails
const galleryThumbnail = document.querySelectorAll(".thumbnails-list li");
// select featured
const galleryFeatured = document.querySelector(".product-gallery-featured img");

// loop all items
galleryThumbnail.forEach((item) => {
    item.addEventListener("mouseover", function () {
        let image = item.children[0].src;
        galleryFeatured.src = image;
    });
});

$(".main-questions").popover('show');
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
    $('.index_header').addClass('header_color');
	  
  } else { 
    $('.index_header').removeClass('header_color');
  }
}
$(document).ready(function(){

$(function(){
 
    $(document).on( 'scroll', function(){
 
    	if ($(window).scrollTop() > 100) {
			$('.scroll-top-wrapper').addClass('show');
		} else {
			$('.scroll-top-wrapper').removeClass('show');
		}
	});
 
	$('.scroll-top-wrapper').on('click', scrollToTop);
});
 
function scrollToTop() {
	verticalOffset = typeof(verticalOffset) != 'undefined' ? verticalOffset : 0;
	element = $('body');
	offset = element.offset();
	offsetTop = offset.top;
	$('html, body').animate({scrollTop: offsetTop}, 500, 'linear');
}

});