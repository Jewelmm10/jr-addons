(function($) {
    'use strict';

    $(document).on('keyup change', '.jr-search-input, .jr-category', debounce(function() {
        const $input    = $(this).closest('.jr-search-wrapper').find('.jr-search-input');
        const $wrapper  = $(this).closest('.jr-search-wrapper');
        const $results  = $wrapper.find('.jr-live-results');
        const $loader   = $wrapper.find('.jr-search-loader');
        const $category = $wrapper.find('.jr-category');

        // Check AJAX enabled
        if ($wrapper.data('ajax') !== true) return;

        const keyword = $input.val().trim();
        const category = $category.length ? $category.val() : '';

        if (keyword.length < 2) {
            $results.removeClass('active').empty();
            return;
        }

        $loader.addClass('active');

        $.ajax({
            url: jrSearch.ajax_url,
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'jr_live_search',
                nonce: jrSearch.nonce,
                keyword: keyword,
                category: category,
                limit: $wrapper.data('limit') || 6,
                show_image: $wrapper.data('show-image'),
                show_price: $wrapper.data('show-price')
            },
            success: function(res) {
                $loader.removeClass('active');
                if (res.success) {
                    $results.html(res.data.html).addClass('active');
                } else {
                    $results.html(res.data.html || '<div class="jr-no-results">No results</div>').addClass('active');
                }
            },
            error: function() {
                $loader.removeClass('active');
                $results.html('<div class="jr-no-results">⚠️ Something went wrong</div>').addClass('active');
            }
        });
    }, 350));

    // Close on outside click
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.jr-search-wrapper').length) {
            $('.jr-live-results').removeClass('active');
        }
    });

    // Reopen on focus if has content
    $(document).on('focus', '.jr-search-input', function() {
        const $results = $(this).closest('.jr-search-wrapper').find('.jr-live-results');
        if ($results.children().length > 0) {
            $results.addClass('active');
        }
    });

    // Debounce helper
    function debounce(fn, delay) {
        let timer;
        return function() {
            const ctx = this, args = arguments;
            clearTimeout(timer);
            timer = setTimeout(() => fn.apply(ctx, args), delay);
        };
    }

})(jQuery);