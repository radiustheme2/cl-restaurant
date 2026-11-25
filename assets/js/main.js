(function($) {
    "use strict";

    /* Main Functions */
    var CLRestauran = {
        init: function() {
            this.Basic.init();
        },

        Basic: {
            init: function() {
                this.Preloader();
                this.stickyMenu();
                this.MobileMenu();
                this.elementLoader();
                this.Lightbox1();
                this.Lightbox2();
                this.RangeSlider();
                this.RtGlobalSlider();
                this.CLRestaurantOthers();
            },
            Preloader: function(){
                $('#preloader').fadeOut('slow', function() {
                    $(this).remove();
                });
            },
            stickyMenu: function(){
                // Sticky Menu
                if ($('body').hasClass('sticky-header')) {
                    var stickyPlaceHolder = $("#sticky-placeholder"),
                        menu = $("#masthead"),
                        menuH = menu.outerHeight(),
                        topbarH = $('#topbar-wrap').outerHeight() || 0,
                        targrtScroll = topbarH,
                        header = $("header");
                    if ($(window).scrollTop() > targrtScroll) {
                        header.addClass('rt-sticky-header');
                        stickyPlaceHolder.height(menuH);
                    } else {
                        header.removeClass('rt-sticky-header');
                        stickyPlaceHolder.height(0);
                    }

                    // Sticky mobile header
                    var stickyPlaceHolder = $("#mobile-sticky-placeholder"),
                    menu = $(".rt-mobile-menu"),
                    menuH = menu.outerHeight(),
                    topHeaderH = $('#topbar-wrap').outerHeight() || 0,
                    topAdminH = $('#wpadminbar').outerHeight() || 0,
                    targrtScroll = topHeaderH + topAdminH;
                    if ($(window).scrollTop() > targrtScroll) {
                        menu.addClass('mobile-sticky');
                        stickyPlaceHolder.height(menuH);
                    } else {
                        menu.removeClass('mobile-sticky');
                        stickyPlaceHolder.height(0);
                    }
                }
                if ($(window).scrollTop() >= $("body").offset().top + 50) {
                    $("body").addClass("mn-top");
                } else {
                    $("body").removeClass("mn-top");
                }
            },
            MobileMenu: function (){
                var a = $('.offscreen-navigation .main-menu');
                if (a.length) {
                    $(".menu-item-has-children").append("<span></span>");
                    $(".page_item_has_children").append("<span></span>");

                    a.children("li").addClass("menu-item-parent");

                    $('.menu-item-has-children > span').on('click', function () {
                        var _self = $(this),
                            sub_menu = _self.parent().find('>.sub-menu');
                        if (_self.hasClass('open')) {
                            sub_menu.slideUp();
                            _self.removeClass('open');
                        } else {
                            sub_menu.slideDown();
                            _self.addClass('open');
                        }
                    });
                    $('.page_item_has_children > span').on('click', function () {
                        var _self = $(this),
                            sub_menu = _self.parent().find('>.children');
                        if (_self.hasClass('open')) {
                            sub_menu.slideUp();
                            _self.removeClass('open');
                        } else {
                            sub_menu.slideDown();
                            _self.addClass('open');
                        }
                    });
                }
                $('.mean-bar .sidebarBtn').on('click', function (e) {
                    e.preventDefault();
                    if ($('.rt-slide-nav').is(":visible")) {
                        $('.rt-slide-nav').slideUp();
                        $('body').removeClass('slidemenuon');
                    } else {
                        $('.rt-slide-nav').slideDown();
                        $('body').addClass('slidemenuon');
                    }
                });
            },
            elementLoader: function(){
                $('body').imagesLoaded().done(function(instance) {
                    $('body').addClass('loaded');
                });
                /*-------------------------------------
                Page Preloader
                -------------------------------------*/
                if ($('#pageoverlay').length) {
                    window.onload = function() {
                        document.getElementById('pageoverlay').className = 'pageoverlay';
                        $('#pageoverlay').delay(800).fadeOut();
                    }
                }
            },
            Lightbox1: function() {
                /*-------------------------------------
                    PhotoSwipe Lightbox
                -------------------------------------*/
                // Init empty gallery array
                var container = [];
                $(".photo-swip-gallery-wrap .photoswip-item a").attr( 
                    {width: "1170",  height:"550"}
                );
                // Loop over gallery items and push it to the array
                $('.photo-swip-gallery-wrap').find('.photoswip-item').each(function() {
                    var $link = $(this).find('a'),
                    item = {
                        src: $link.attr('href'),
                        w: $link.attr('width'),
                        h: $link.attr('height')
                    };
                    container.push(item);
                });
        
                // Define click event on gallery item
                $('.photo-swip-gallery-wrap .photoswip-item a').click(function(event) {
        
                    // Prevent location change
                    event.preventDefault();
        
                    // Define object and gallery options
                    var $pswp = $('.pswp')[0],
                    options = {
                        index: $(this).parent('.photoswip-item').index(),
                        bgOpacity: 0.85,
                        showHideOpacity: true
                    };
        
                    // Initialize PhotoSwipe
                    var gallery = new PhotoSwipe($pswp, PhotoSwipeUI_Default, container, options);
                    gallery.init();
                });
            },
            Lightbox2: function() {
                /*-------------------------------------
                    PhotoSwipe Lightbox
                -------------------------------------*/
                // Define click event on gallery item
                $('.rtcl-extra-gallery-trigger').click(function(event) {
                    // Prevent location change
                    event.preventDefault();
                    // Loop over gallery items and push it to the array
                    let container = [];
                    $(this).parent().find('.listing-gallery-item').each(function() {
                        let $link = $(this).find('img'),
                        item = {
                            src: $link.attr('src'),
                            w: $link.attr('width'),
                            h: $link.attr('height')
                        };
                        container.push(item);
                    });
                    // Define object and gallery options
                    let $pswp = $('.pswp')[0],
                    options = {
                        index: $(this).parent('.listing-gallery-item').index(),
                        bgOpacity: 0.8,
                        zoomEl: true,
                        tapToClose: true,
                        fullscreenEl: true,
                        preloaderEl: true,
                        shareEl: true,
                        captionEl: false,
                    };
                    // Initialize PhotoSwipe
                    let gallery = new PhotoSwipe($pswp, PhotoSwipeUI_Default, container, options);
                    gallery.init();
                });
            },
            RangeSlider: function() {
                // Price Filter range slider  
                if ($.fn.ionRangeSlider) {

                    $(".ion-rangeslider").each(function () {
                        var $this = $(this);
                        var rangeType = $this.data('type');
                        $this.ionRangeSlider({
                            type: rangeType || "double",
                            drag_interval: true,
                            min_interval: null,
                            max_interval: null,
                            onChange: function (data) {
                                var $inp = data.input;
                                $inp.parent().find('.min-volumn').val(data.from);
                                $inp.parent().find('.max-volumn').val(data.to);
                            },
                        });
                    });
                    
                    $(".advance-search-form .rtcl-range-slider-input").each(function () {
                        var $this = $(this);
                        var rangeType = $this.data('type');
                        $this.ionRangeSlider({
                            drag_interval: true,
                            min_interval: null,
                            max_interval: null,
                            onChange: function (data) {
                                var $inp = data.input;
                                $inp.parent().find('.min-volumn').val(data.from);
                                $inp.parent().find('.max-volumn').val(data.to);
                            },
                        });
                    });

                }
            },
            RtGlobalSlider: function(){
                $('.rt-global-slider').each(function() {
                    var $this = $(this);
                    $this.fadeIn();
                    var settings = $this.data('slider-options');
                    var autoplayconditon= settings['auto'];
                    var $pagination = $this.find('.swiper-pagination')[0];
                    var $next = $this.find('.swiper-button-next')[0];
                    var $prev = $this.find('.swiper-button-prev')[0];

                    new Swiper( $this[0], {
                            speed:settings['speed'],
                            spaceBetween:  settings['spaceBetween'],
                            slidesPerGroup: settings['slidesPerGroup'] ? settings['slidesPerGroup']:1,
                            autoplay:autoplayconditon ? {delay:settings['autoplay']['delay']}:false,
                            pagination: {
                                el: $pagination,
                                clickable: true,
                                type: 'bullets',
                            },
                            navigation: {
                                nextEl: $next,
                                prevEl: $prev,
                            },
                            breakpoints: {
                                0: {
                                    slidesPerView: settings['breakpoints']['0']['slidesPerView'],
                                },
                                576: {
                                    slidesPerView: settings['breakpoints']['480']['slidesPerView'],
                                },
                                768: {
                                    slidesPerView: settings['breakpoints']['768']['slidesPerView'],
                                },
                                992: {
                                    slidesPerView: settings['breakpoints']['992']['slidesPerView'],
                                },
                                1600: {
                                    slidesPerView: settings['breakpoints']['1600']['slidesPerView'],
                                },
                            },
                    });
        
                });
            },
            CLRestaurantOthers: function(){
                /*- Tooltip
                --------------------------------------------*/
                const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
                const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

                /*- Listing Archive Ordering
                --------------------------------------------*/
                $('.rtcl-ordering').each(function(){
                    $('.orderby').select2({
                        allowClear: true
                    });
                });


                $('#rtcl-ad-category-selection').each(function(){
                    $('.rtcl-select2').select2({
                        allowClear: true
                    });
                });

                if ($('.rtcl-widget-search-form select').length) {
                    $('.rtcl-widget-search-form select').select2({
                        theme: 'classic',
                        dropdownAutoWidth: true,
                        width: '100%',
                    });
                }

            }
        }
    }

    $(window).on('load', function() {
        CLRestauran.Basic.elementLoader();
        // wow.init();
    });
    
    /*- Add class for responsive menu          --------------------------------------------*/
    $(window).on("scroll", function () {
        CLRestauran.Basic.stickyMenu();
    });

    // Window Load+Resize
    $(window).on('load resize', function (){
        // Elementor Frontend Load
        $(window).on('elementor/frontend/init', function () {
            if (elementorFrontend.isEditMode()) {
                elementorFrontend.hooks.addAction('frontend/element_ready/widget', function () {
                    CLRestauran.init();
                    // new WOW().init();
                });
            }
        });
    });

    $( document ).ready( function () {
        CLRestauran.init();
    });

})(jQuery);