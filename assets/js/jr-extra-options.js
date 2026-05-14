(function($) {
    'use strict';
    $(document).on('click', '[data-jr-review-scroll]', function(e) {
        e.preventDefault();
        var $target = $('#reviews, #tab-reviews, .woocommerce-Reviews, [id*="reviews"]').first();
        if ($target.length) {
            $('html, body').animate({
                scrollTop: $target.offset().top - 100
            }, 600);
            // Click reviews tab if exists
            $('.wc-tabs li.reviews_tab a, a[href="#tab-reviews"]').trigger('click');
        }
    });
})(jQuery);