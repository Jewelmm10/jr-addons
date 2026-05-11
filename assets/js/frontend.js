jQuery(window).on("elementor/frontend/init", function () {
  elementorFrontend.hooks.addAction("frontend/element_ready/spater_services_carousel.default", function ($scope) {
    const $swiperElement = $scope.find(".spater-swiper");
    if (!$swiperElement.length) return;

    const swiperSettings = $swiperElement.data("settings");

    // Navigation settings fix
    if (swiperSettings.navigation) {
      swiperSettings.navigation = {
        nextEl: $scope.find(".swiper-button-next")[0],
        prevEl: $scope.find(".swiper-button-prev")[0],
      };
    }

    // Pagination settings fix
    if (swiperSettings.pagination) {
      swiperSettings.pagination = {
        el: $scope.find(".swiper-pagination")[0],
        clickable: true,
      };
    }

    // Initialize Swiper
    const swiper = new Swiper($swiperElement[0], swiperSettings);
  });
});

document.addEventListener('DOMContentLoaded', function(){

    // Offcanvas
    const hamburger = document.querySelector('.jr-hamburger');
    const offcanvas = document.querySelector('.jr-offcanvas');
    const closeBtn = document.querySelector('.jr-close');

    if(hamburger && offcanvas){
        hamburger.addEventListener('click', () => {
            offcanvas.classList.add('open');
        });
    }

    if(closeBtn){
        closeBtn.addEventListener('click', () => {
            offcanvas.classList.remove('open');
        });
    }

    // Sticky Shrink + Transparency
    const header = document.querySelector('header');

    if(header){
        window.addEventListener('scroll', function(){

            if(window.scrollY > 50){
                header.classList.add('jr-scrolled');
                header.classList.add('jr-shrink');
            } else {
                header.classList.remove('jr-scrolled');
                header.classList.remove('jr-shrink');
            }

        });
    }

});

// JR Slider Init
jQuery(window).on('elementor/frontend/init', function () {

    elementorFrontend.hooks.addAction(
        'frontend/element_ready/jr_slider.default',
        function ($scope) {

            const $slider = $scope.find('.jr-slider');
            const $wrapper = $scope.find('.jr-slider-wrapper');

            if (!$slider.length) return;

            let settings = $slider.data('settings');
            if (!settings) return;

            if ($slider[0].swiper) {
                $slider[0].swiper.destroy(true, true);
            }

            //  Updated arrow class
            if (settings.navigation) {
                settings.navigation = {
                    nextEl: $wrapper.find('.jr-slider-arrow-next')[0],
                    prevEl: $wrapper.find('.jr-slider-arrow-prev')[0],
                };
            }

            if (settings.pagination) {
                settings.pagination = {
                    el: $scope.find('.swiper-pagination')[0],
                    clickable: true,
                    type: settings.paginationType || 'bullets',
                };
            }

            if (settings.autoplay && typeof settings.autoplay === 'object') {
                settings.autoplay = {
                    delay: settings.autoplay.delay || 4000,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true,
                };
            }

            if (settings.effect === 'fade') {
                settings.fadeEffect = { crossFade: true };
            }

            if (settings.effect === 'coverflow') {
                settings.coverflowEffect = {
                    rotate: 30, stretch: 0, depth: 100, modifier: 1, slideShadows: false
                };
                settings.centeredSlides = true;
            }

            new Swiper($slider[0], settings);
        }
    );
});

// Fallback for non-Elementor pages (theme builder, etc.)
jQuery(document).ready(function ($) {
    if (typeof elementorFrontend === 'undefined') {
        $('.jr-slider').each(function () {
            const $slider = $(this);
            const $wrapper = $slider.closest('.jr-slider-wrapper');
            let settings = $slider.data('settings');

            if (!settings) return;

            if (settings.navigation) {
                settings.navigation = {
                    nextEl: $wrapper.find('.jr-arrow-next')[0],
                    prevEl: $wrapper.find('.jr-arrow-prev')[0],
                };
            }

            if (settings.pagination) {
                settings.pagination = {
                    el: $slider.find('.swiper-pagination')[0],
                    clickable: true,
                    type: settings.paginationType || 'bullets',
                };
            }

            if (settings.autoplay && typeof settings.autoplay === 'object') {
                settings.autoplay = {
                    delay: settings.autoplay.delay || 4000,
                    disableOnInteraction: false,
                };
            }

            new Swiper($slider[0], settings);
        });
    }
});

//Product Carousel
jQuery(window).on('elementor/frontend/init', function () {

    elementorFrontend.hooks.addAction(
        'frontend/element_ready/spater_product_carousel.default',
        function ($scope) {

            const swiperEl = $scope.find('.jr-swiper');

            if (!swiperEl.length) {
                return;
            }

            let settings = swiperEl.data('settings');

            // Destroy old swiper
            if (swiperEl[0].swiper) {
                swiperEl[0].swiper.destroy(true, true);
            }

            // Navigation
            settings.navigation = {
                nextEl: $scope.find('.swiper-button-next')[0],
                prevEl: $scope.find('.swiper-button-prev')[0],
            };

            // Pagination
            settings.pagination = {
                el: $scope.find('.swiper-pagination')[0],
                clickable: true,
            };

            // Init
            new Swiper(swiperEl[0], settings);

        }
    );

});

// Category Carousel
jQuery(window).on('elementor/frontend/init', function () {

    elementorFrontend.hooks.addAction(
        'frontend/element_ready/jr_category_carousel.default',
        function ($scope) {

            const swiperEl = $scope.find('.jr-swiper-cat');

            if (!swiperEl.length) {
                return;
            }

            let settings = swiperEl.data('settings');

            // Destroy old swiper
            if (swiperEl[0].swiper) {
                swiperEl[0].swiper.destroy(true, true);
            }

            // Navigation
            settings.navigation = {
                nextEl: $scope.find('.swiper-button-next')[0],
                prevEl: $scope.find('.swiper-button-prev')[0],
            };

            // Pagination
            settings.pagination = {
                el: $scope.find('.swiper-pagination')[0],
                clickable: true,
            };

            // Init
            new Swiper(swiperEl[0], settings);

        }
    );

});

// Custom quantity buttons
jQuery(function ($) {

    $('.jr-add-to-cart-wrapper .quantity').not('[data-jr-init]').each(function () {

        let $qty   = $(this).attr('data-jr-init', '1'),
            $input = $qty.find('input.qty');

        if (!$input.length) return;

        $input.before('<button type="button" class="jr-qty-btn jr-minus">−</button>');
        $input.after('<button type="button" class="jr-qty-btn jr-plus">+</button>');

        $qty.on('click', '.jr-qty-btn', function () {

            let val = parseInt($input.val()) || 1,
                min = parseInt($input.attr('min')) || 1,
                max = parseInt($input.attr('max')) || 9999;

            $input.val(
                $(this).hasClass('jr-plus')
                    ? Math.min(val + 1, max)
                    : Math.max(val - 1, min)
            ).trigger('change');

        });

    });

});

// Read More / Read Less
jQuery(function ($) {

    $('.jr-readmore-btn').not('[data-jr-init]').attr('data-jr-init', '1').on('click', function () {

        let $btn     = $(this),
            $content = $('#' + $btn.data('target')).find('.jr-desc-content');

        if (!$content.length) return;

        let expanded = $content.toggleClass('jr-collapsed jr-expanded')
                               .hasClass('jr-expanded');

        $btn.text(expanded ? $btn.data('less') || 'Read Less'
                           : $btn.data('more') || 'Read More');

        if (!expanded) {
            $content.closest('[id]')[0]
                .scrollIntoView({ behavior: 'smooth', block: 'start' });
        }

    });

});

( function( $ ) {

    'use strict';

    function initJRProductGallery( $scope ) {

        var $gallery = $scope.find( '.jr-product-gallery' );

        if ( ! $gallery.length ) return;

        $gallery.each( function() {

            var $this     = $( this );
            var thumbsPV  = parseInt( $this.data( 'thumbs' ), 10 ) || 4;
            var direction = $this.data( 'direction' ) || 'horizontal';

            var thumbEl = $this.find( '.jr-thumb-swiper' )[0];
            var mainEl  = $this.find( '.jr-main-swiper' )[0];

            if ( ! thumbEl || ! mainEl ) return;

            var thumbSwiper = new Swiper( thumbEl, {
                spaceBetween        : 10,
                slidesPerView       : thumbsPV,
                freeMode            : true,
                watchSlidesProgress : true,
                direction           : direction,
                observer            : true,
                observeParents      : true,
            } );

            new Swiper( mainEl, {
                spaceBetween   : 10,
                observer       : true,
                observeParents : true,
                thumbs         : {
                    swiper : thumbSwiper,
                },
            } );

        } );
    }

    $( window ).on( 'elementor/frontend/init', function() {

        elementorFrontend.hooks.addAction(
            'frontend/element_ready/jr-product-gallery.default',
            initJRProductGallery
        );
    } );

    $( document ).ready( function() {
        initJRProductGallery( $( document ) );
    } );

} )( jQuery );


( function( $ ) {

    'use strict';

    /**
     * Initialize JR Navigation Menu
     */
    function initJRNavMenu( $scope ) {

        var $wrapper = $scope.find( '.jr-nav-wrapper' );

        if ( ! $wrapper.length ) return;

        $wrapper.each( function() {

            var $nav        = $( this );
            var $hamburger  = $nav.find( '.jr-hamburger' );
            var $close      = $nav.find( '.jr-close' );
            var $overlay    = $nav.find( '.jr-overlay' );
            var $offcanvas  = $nav.find( '.jr-offcanvas' );
            var $mobileMenu = $nav.find( '.jr-mobile-menu' );

            /**
             * Open Offcanvas
             */
            $hamburger.off( 'click.jrnav' ).on( 'click.jrnav', function( e ) {
                e.preventDefault();
                $offcanvas.addClass( 'active' ).attr( 'aria-hidden', 'false' );
                $overlay.addClass( 'active' );
                $( 'body' ).css( 'overflow', 'hidden' );
            } );

            /**
             * Close Offcanvas
             */
            function closeOffcanvas() {
                $offcanvas.removeClass( 'active' ).attr( 'aria-hidden', 'true' );
                $overlay.removeClass( 'active' );
                $( 'body' ).css( 'overflow', '' );
            }

            $close.off( 'click.jrnav' ).on( 'click.jrnav', closeOffcanvas );
            $overlay.off( 'click.jrnav' ).on( 'click.jrnav', closeOffcanvas );

            /**
             * Mobile Menu - Submenu Toggle
             */
            $mobileMenu.find( '.menu-item-has-children > a' ).off( 'click.jrnav' ).on( 'click.jrnav', function( e ) {

                var $link   = $( this );
                var $parent = $link.parent();
                var href    = $link.attr( 'href' );

                if ( $parent.children( 'ul' ).length ) {

                    // If clicked on arrow, just toggle
                    if ( $( e.target ).closest( '.jr-arrow' ).length ) {
                        e.preventDefault();
                        $parent.toggleClass( 'menu-open' );
                        return;
                    }

                    // If no real link, toggle
                    if ( ! href || href === '#' ) {
                        e.preventDefault();
                        $parent.toggleClass( 'menu-open' );
                    }
                    // Otherwise let link work normally
                }
            } );

            /**
             * Vertical Menu - Submenu Toggle
             */
            if ( $nav.hasClass( 'jr-layout-vertical' ) ) {

                $nav.find( '.jr-desktop-menu .menu-item-has-children > a' ).off( 'click.jrnav' ).on( 'click.jrnav', function( e ) {

                    var $link   = $( this );
                    var $parent = $link.parent();
                    var href    = $link.attr( 'href' );

                    if ( $parent.children( 'ul' ).length ) {

                        if ( $( e.target ).closest( '.jr-arrow' ).length ) {
                            e.preventDefault();
                            $parent.toggleClass( 'menu-open' );
                            return;
                        }

                        if ( ! href || href === '#' ) {
                            e.preventDefault();
                            $parent.toggleClass( 'menu-open' );
                        }
                    }
                } );
            }

            /**
             * Close on ESC key
             */
            $( document ).off( 'keydown.jrnav' ).on( 'keydown.jrnav', function( e ) {
                if ( e.key === 'Escape' && $offcanvas.hasClass( 'active' ) ) {
                    closeOffcanvas();
                }
            } );

        } );
    }

    /**
     * Elementor Frontend Hook
     */
    $( window ).on( 'elementor/frontend/init', function() {

        elementorFrontend.hooks.addAction(
            'frontend/element_ready/jr_nav_menu.default',
            initJRNavMenu
        );
    } );

    /**
     * Normal Page Load
     */
    $( document ).ready( function() {
        initJRNavMenu( $( document ) );
    } );

} )( jQuery );

// buy now
(function ($) {
    'use strict';

    $(document).ready(function () {

        $('.jr-add-to-cart-wrapper').each(function () {
            initBuyNow($(this));
        });

        $(document.body).on('jr_init_buynow', function () {
            $('.jr-add-to-cart-wrapper').each(function () {
                initBuyNow($(this));
            });
        });
    });

    function initBuyNow($wrapper) {

        if ($wrapper.data('jr-buynow-init')) return;
        $wrapper.data('jr-buynow-init', '1');

        const buyNowEnabled = $wrapper.attr('data-buy-now') === '1';
        if (!buyNowEnabled) return;

        const $form = $wrapper.find('form.cart');
        if (!$form.length) return;

        if ($form.find('.jr-buy-now').length) return;

        const buyText = $wrapper.attr('data-buy-text') || 'Buy Now';

        const $btn = $('<button>', {
            type:  'button',
            class: 'jr-buy-now',
            text:  buyText
        });

        $form.append($btn);

        $btn.on('click', function (e) {
            e.preventDefault();

            $form.find('input[name="jr_buy_now"]').remove();
            $form.append('<input type="hidden" name="jr_buy_now" value="1" />');

            $btn.prop('disabled', true).addClass('jr-loading').text('Processing...');

            const $cartBtn = $form.find('.single_add_to_cart_button');
            $cartBtn.removeClass('ajax_add_to_cart');

            $form.off('submit.wc-ajax-add-to-cart');

            $form[0].submit();
        });
    }

})(jQuery);