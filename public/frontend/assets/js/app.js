(function($) {
    "use strict";

    /*--------------------------------------------------------------
     [Table of contents]

    Barmagly PRELOADER JS INIT
    Barmagly HEADER SEARCH JS INIT
    Barmagly STICKY MENU JS INIT
    Barmagly MENU SIDEBAR JS INIT
    Barmagly SKILLBAR JS INIT
    Barmagly HERO SLIDER INIT
    Barmagly FOUR COLUMN SLIDER INIT
    Barmagly THREE COLUMN SLIDER INIT
    Barmagly FOUR COLUMN SLIDER TWO INIT
    Barmagly TWO COLUMN SLIDER INIT
    Barmagly ONE COLUMN SLIDER INIT
    Barmagly THREE COLUMN SLIDER TWO INIT
    Barmagly BRAND SLIDER INIT
    Barmagly COUNTER JS INIT
    Barmagly COUNTER JS TWO INIT
    Barmagly MAP JS

    -------------------------------------------------------------------*/

    /*--------------------------------------------------------------
    CUSTOM PRE DEFINE FUNCTION
    ------------------------------------------------------------*/
    /* is_exist() */
    jQuery.fn.is_exist = function() {
        return this.length;
    };
    $(function() {
        /*--------------------------------------------------------------
        Barmagly PRELOADER JS INIT
        --------------------------------------------------------------*/
        // Preloader fadeout moved to window load event in script.blade.php or added below
        // $(".Barmagly-preloader-wrap").fadeOut(500);

        /*--------------------------------------------------------------
        Barmagly HEADER SEARCH JS INIT
        ------------------------------------------------------------*/

        $(".Barmagly-header-search, .Barmagly-header-search-close, .search-overlay").on("click", function(e) {
            $(".Barmagly-header-search-section, .search-overlay").toggleClass("open").css("display", "");
        })

        /*--------------------------------------------------------------
        Barmagly STICKY MENU JS INIT
        --------------------------------------------------------------*/
        $(window).on('scroll', function() {
            if ($(window).scrollTop() > 50) {
                $('#sticky-menu').addClass('sticky-menu');
            } else {
                $('#sticky-menu').removeClass('sticky-menu');
            }
        });

        /*--------------------------------------------------------------
        Barmagly MENU SIDEBAR JS INIT
        --------------------------------------------------------------*/
        $(".Barmagly-header-barger").on("click", function(e) {
            $(".Barmagly-sidemenu-column, .offcanvas-overlay").addClass("active");
            event.preventDefault(e);
        });
        $(".Barmagly-sidemenu-close, .offcanvas-overlay").on("click", function() {
            $(".Barmagly-sidemenu-column, .offcanvas-overlay").removeClass("active");
        });

        /*--------------------------------------------------------------
        Barmagly HERO SLIDER INIT
        --------------------------------------------------------------*/
        /*----------- Global Slider ----------*/
        $(".global-carousel").each(function() {
            var carouselSlide = $(this);

            function d(data) {
                return carouselSlide.data(data);
            }
        });
        /*----------- Custom Animaiton For Slider ----------*/

        $('[data-ani-duration]').each(function() {
            var durationTime = $(this).data('ani-duration');
            $(this).css('animation-duration', durationTime);
        });
        $('[data-ani-delay]').each(function() {
            var delayTime = $(this).data('ani-delay');
            $(this).css('animation-delay', delayTime);
        });
        $('[data-ani]').each(function() {
            var animaionName = $(this).data('ani');
            $(this).addClass(animaionName);
            $('.slick-slide [data-ani]').addClass('slider-animated');
        });
        $('.global-carousel').on('afterChange', function(event, slick, currentSlide, nextSlide) {
            $(slick.$slides).find('[data-ani]').removeClass('slider-animated');
            $(slick.$slides[currentSlide]).find('[data-ani]').addClass('slider-animated');
        });
        var hero_slider = $('.Barmagly-hero-slider');
        if (hero_slider.is_exist()) {
            hero_slider.slick({
                infinite: true,
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: true,
                dots: false,
                autoplay: false,
                speed: 800,
                lazyLoad: 'progressive',
                prevArrow: '<button class="slide-arrow Barmagly-hero-next"><i class="ri-arrow-left-s-line"></i></button>',
                nextArrow: '<button class="slide-arrow Barmagly-hero-prev"><i class="ri-arrow-right-s-line"></i></button>'
            }).slickAnimation();
        }


        $('.js-example-basic-single').select2();


        // range slider----------------------------------------
        var priceslider = function() {
            if ($("#slider-tooltips").length > 0) {
                var tooltipSlider = document.getElementById("slider-tooltips");

                var formatForSlider = {
                    from: function(formattedValue) {
                        return Number(formattedValue);
                    },
                    to: function(numericValue) {
                        return Math.round(numericValue);
                    },
                };

                noUiSlider.create(tooltipSlider, {
                    start: [40, 346],
                    connect: true,
                    format: formatForSlider,
                    range: {
                        min: 10,
                        max: 500,
                    },
                });
                var formatValues = [
                    document.getElementById("slider-margin-value-min"),
                    document.getElementById("slider-margin-value-max"),
                ];
                tooltipSlider.noUiSlider.on(
                    "update",
                    function(values, handle, unencoded) {
                        formatValues[0].innerHTML = "Price: " + "$" + values[0];
                        formatValues[1].innerHTML = "$" + values[1];
                    }
                );
            }
        };
        priceslider();








        /*--------------------------------------------------------------
        Barmagly FOUR COLUMN SLIDER INIT
        --------------------------------------------------------------*/
        var four_column_slider = $('.Barmagly-4column-slider');
        if (four_column_slider.is_exist()) {
            four_column_slider.slick({
                infinite: true,
                slidesToShow: 4,
                slidesToScroll: 1,
                arrows: false,
                dots: true,
                autoplay: false,
                centerMode: true,
                centerPadding: '300px',
                responsive: [{
                    breakpoint: 1600,
                    settings: {
                        slidesToShow: 3,
                        centerPadding: '250px'
                    }
                }, {
                    breakpoint: 1399,
                    settings: {
                        slidesToShow: 3,
                        centerPadding: '150px'
                    }
                }, {
                    breakpoint: 1199,
                    settings: {
                        slidesToShow: 3,
                        centerPadding: '100px'
                    }
                }, {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 2,
                        centerPadding: '100px'
                    }
                }, {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1,
                        centerPadding: '100px'
                    }
                }, {
                    breakpoint: 575,
                    settings: {
                        slidesToShow: 1,
                        centerPadding: '0px'
                    }
                }]
            });
        }

        /*--------------------------------------------------------------
        OLD THREE COLUMN SLIDER REMOVED - Replaced with new projects-showcase-grid
        --------------------------------------------------------------*/

        /*--------------------------------------------------------------
        Barmagly FOUR COLUMN SLIDER TWO INIT
        --------------------------------------------------------------*/
        var four_column_slider2 = $('.Barmagly-4column-slider2');
        if (four_column_slider2.is_exist()) {
            four_column_slider2.slick({
                infinite: true,
                slidesToShow: 4,
                slidesToScroll: 1,
                arrows: false,
                dots: true,
                autoplay: false,
                responsive: [{
                    breakpoint: 1399,
                    settings: {
                        slidesToShow: 3
                    }
                }, {
                    breakpoint: 1199,
                    settings: {
                        slidesToShow: 2
                    }
                }, {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1
                    }
                }]
            });
        }

        /*--------------------------------------------------------------
        Barmagly TWO COLUMN SLIDER INIT
        --------------------------------------------------------------*/
        var two_column_slider = $('.Barmagly-2column-slider');
        if (two_column_slider.is_exist()) {
            two_column_slider.slick({
                infinite: true,
                slidesToShow: 2,
                slidesToScroll: 1,
                arrows: false,
                dots: true,
                autoplay: false,
                responsive: [{
                    breakpoint: 991,
                    settings: {
                        slidesToShow: 1
                    }
                }]
            });
        }

        /*--------------------------------------------------------------
        Barmagly ONE COLUMN SLIDER INIT
        --------------------------------------------------------------*/
        var t_one_column_slider = $('.Barmagly-1column-slider');
        if (t_one_column_slider.is_exist()) {
            t_one_column_slider.slick({
                infinite: true,
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: true,
                dots: false,
                autoplay: false,
                speed: 800,
                prevArrow: '<button class="slide-arrow Barmagly-t-next"><i class="ri-arrow-left-s-line"></i></button>',
                nextArrow: '<button class="slide-arrow Barmagly-t-prev"><i class="ri-arrow-right-s-line"></i></button>'
            });
        }

        /*--------------------------------------------------------------
        Barmagly THREE COLUMN SLIDER TWO INIT
        --------------------------------------------------------------*/
        var three_column_slider2 = $('.Barmagly-3column-slider2');
        if (three_column_slider2.is_exist()) {
            three_column_slider2.slick({
                infinite: true,
                slidesToShow: 3,
                slidesToScroll: 1,
                arrows: false,
                dots: true,
                autoplay: false,
                responsive: [{
                    breakpoint: 1299,
                    settings: {
                        slidesToShow: 2
                    }
                }, {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1
                    }
                }]
            });
        }

        /*--------------------------------------------------------------
        Barmagly BRAND SLIDER INIT
        --------------------------------------------------------------*/
        var Barmagly_brand_slider = $('.Barmagly-brand-slider');
        if (Barmagly_brand_slider.is_exist()) {
            Barmagly_brand_slider.slick({
                infinite: true,
                slidesToShow: 5,
                slidesToScroll: 1,
                arrows: false,
                dots: false,
                autoplay: true,
                autoplaySpeed: 0,
                speed: 6000,
                cssEase: 'linear',
                pauseOnHover: true,
                adaptiveHeight: true,
                responsive: [{
                    breakpoint: 1199,
                    settings: {
                        slidesToShow: 3
                    }
                }, {
                    breakpoint: 767,
                    settings: {
                        slidesToShow: 2
                    }
                }]
            });
        }

        /*--------------------------------------------------------------
        Barmagly COUNTER JS INIT
        --------------------------------------------------------------*/
        var Barmagly_counter = $('#Barmagly-counter');
        if (Barmagly_counter.is_exist()) {
            var a = 0;
            $(window).scroll(function() {
                var oTop = $(Barmagly_counter).offset().top - window.innerHeight;
                if (a == 0 && $(window).scrollTop() > oTop) {
                    $('.Barmagly-counter').each(function() {
                        var $this = $(this),
                            countTo = $this.attr('data-percentage');
                        $({
                            countNum: $this.text()
                        }).animate({
                            countNum: countTo
                        }, {
                            duration: 4000,
                            easing: 'swing',
                            step: function step() {
                                $this.text(Math.floor(this.countNum));
                            },
                            complete: function complete() {
                                $this.text(this.countNum);
                            }
                        });
                    });
                    a = 1;
                }
            });
        }

        /*--------------------------------------------------------------
        Barmagly COUNTER JS TWO INIT
        --------------------------------------------------------------*/
        var Barmagly_counter2 = $('#Barmagly-counter2');
        if (Barmagly_counter2.is_exist()) {
            var a = 0;
            $(window).scroll(function() {
                var oTop = $(Barmagly_counter2).offset().top - window.innerHeight;
                if (a == 0 && $(window).scrollTop() > oTop) {
                    $('.Barmagly-counter2').each(function() {
                        var $this = $(this),
                            countTo = $this.attr('data-percentage');
                        $({
                            countNum: $this.text()
                        }).animate({
                            countNum: countTo
                        }, {
                            duration: 4000,
                            easing: 'swing',
                            step: function step() {
                                $this.text(Math.floor(this.countNum));
                            },
                            complete: function complete() {
                                $this.text(this.countNum);
                            }
                        });
                    });
                    a = 1;
                }
            });
        }
        /*--------------------------------------------------------------
        Barmagly AOS ANIMATION JS INIT
        --------------------------------------------------------------*/

        AOS.init({
            once: true // Ensure animations can trigger multiple times
        });
    }); /*End document ready*/

    /*--------------------------------------------------------------
    Barmagly MAP JS
    ------------------------------------------------------------*/
    var google_map = $('#map');
    if (google_map.is_exist()) {
        var init = function init() {
            var mapOptions = {
                zoom: 11,
                scrollwheel: false,
                navigationControl: false,
                mapTypeControl: false,
                scaleControl: false,
                draggable: true,
                disableDefaultUI: true,
                center: new google.maps.LatLng(40.6700, -73.9400),
                styles: [{
                    "featureType": "landscape.man_made",
                    "elementType": "geometry",
                    "stylers": [{
                        "color": "#f7f1df"
                    }]
                }, {
                    "featureType": "landscape.natural",
                    "elementType": "geometry",
                    "stylers": [{
                        "color": "#d0e3b4"
                    }]
                }, {
                    "featureType": "landscape.natural.terrain",
                    "elementType": "geometry",
                    "stylers": [{
                        "visibility": "off"
                    }]
                }, {
                    "featureType": "poi",
                    "elementType": "labels",
                    "stylers": [{
                        "visibility": "off"
                    }]
                }, {
                    "featureType": "poi.business",
                    "elementType": "all",
                    "stylers": [{
                        "visibility": "off"
                    }]
                }, {
                    "featureType": "poi.medical",
                    "elementType": "geometry",
                    "stylers": [{
                        "color": "#fbd3da"
                    }]
                }, {
                    "featureType": "poi.park",
                    "elementType": "geometry",
                    "stylers": [{
                        "color": "#bde6ab"
                    }]
                }, {
                    "featureType": "road",
                    "elementType": "geometry.stroke",
                    "stylers": [{
                        "visibility": "off"
                    }]
                }, {
                    "featureType": "road",
                    "elementType": "labels",
                    "stylers": [{
                        "visibility": "off"
                    }]
                }, {
                    "featureType": "road.highway",
                    "elementType": "geometry.fill",
                    "stylers": [{
                        "color": "#ffe15f"
                    }]
                }, {
                    "featureType": "road.highway",
                    "elementType": "geometry.stroke",
                    "stylers": [{
                        "color": "#efd151"
                    }]
                }, {
                    "featureType": "road.arterial",
                    "elementType": "geometry.fill",
                    "stylers": [{
                        "color": "#ffffff"
                    }]
                }, {
                    "featureType": "road.local",
                    "elementType": "geometry.fill",
                    "stylers": [{
                        "color": "black"
                    }]
                }, {
                    "featureType": "transit.station.airport",
                    "elementType": "geometry.fill",
                    "stylers": [{
                        "color": "#cfb2db"
                    }]
                }, {
                    "featureType": "water",
                    "elementType": "geometry",
                    "stylers": [{
                        "color": "#a2daf2"
                    }]
                }]
            };
            var mapElement = document.getElementById('map');
            var map = new google.maps.Map(mapElement, mapOptions);
            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(40.6700, -73.9400),
                map: map,
                title: 'Barmagly'
            });
            var contentString = '<div id="content">' + '<div id="tpw">' + '<h3>Barmagly' + '</div>';
            var infowindow = new google.maps.InfoWindow({
                content: contentString,
                maxWidth: 280
            });
            marker.setAnimation(google.maps.Animation.BOUNCE);
            setTimeout(function() {
                marker.setAnimation(null);
            }, 750); //time it takes for one bounce

            google.maps.event.addListener(marker, 'click', function() {
                infowindow.open(map, marker);
            });
        };
        google.maps.event.addDomListener(window, 'load', init);
    }
})(jQuery);







document.addEventListener("DOMContentLoaded", () => {

    const paymentItems = document.querySelectorAll(".payment_select_item");
    const modals = document.querySelectorAll(".payment_select_modal");
    const closeButtons = document.querySelectorAll(".close_modal_btn");

    paymentItems.forEach((item, index) => {
        item.addEventListener("click", (e) => {
            e.preventDefault();
            modals[index].classList.add("active");
        });
    });

    closeButtons.forEach((button, index) => {
        button.addEventListener("click", () => {
            modals[index].classList.remove("active");
        });
    });
});