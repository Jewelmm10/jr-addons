/**
 * JR Blog Grid Tabs
 * Uses global jrAddons object
 */
(function ($) {
    'use strict';

    // ── Tab Click (Event Delegation) ──
    $(document).on('click', '.jr-bgt-tab', function (e) {
        e.preventDefault();

        var $tab     = $(this);
        var $wrapper = $tab.closest('.jr-bgt-wrapper');

        if (!$wrapper.length) return;
        if ($tab.hasClass('active')) return;
        if ($wrapper.data('jr-bgt-loading')) return;

        var $tabs = $wrapper.find('.jr-bgt-tab');
        $tabs.removeClass('active');
        $tab.addClass('active');

        var category = $tab.data('category');
        $wrapper.data('jr-bgt-current-page', 1);
        $wrapper.data('jr-bgt-current-category', category);

        console.log('JR BGT: Tab clicked →', category);

        jrBgtAjax($wrapper, 'jr_blog_grid_filter', 1, true);
    });

    // ── Load More Click ──
    $(document).on('click', '.jr-bgt-loadmore', function (e) {
        e.preventDefault();

        var $btn     = $(this);
        var $wrapper = $btn.closest('.jr-bgt-wrapper');

        if (!$wrapper.length) return;
        if ($btn.hasClass('jr-no-more')) return;
        if ($wrapper.data('jr-bgt-loading')) return;

        var currentPage = parseInt($wrapper.data('jr-bgt-current-page')) || 1;
        currentPage++;
        $wrapper.data('jr-bgt-current-page', currentPage);

        console.log('JR BGT: Load more → page', currentPage);

        jrBgtAjax($wrapper, 'jr_blog_grid_load_more', currentPage, false);
    });

    // ── AJAX Function ──
    function jrBgtAjax($wrapper, action, page, isFilter) {
        var settings = $wrapper.data('settings');
        if (!settings) {
            console.error('JR BGT: No settings on wrapper');
            return;
        }

        // Use global jrAddons
        if (typeof jrAddons === 'undefined') {
            console.error('JR BGT: jrAddons not loaded!');
            return;
        }

        if (!jrAddons.nonces || !jrAddons.nonces.blog_grid) {
            console.error('JR BGT: blog_grid nonce missing in jrAddons.nonces');
            return;
        }

        $wrapper.data('jr-bgt-loading', true);

        var $grid    = $wrapper.find('.jr-bgt-grid');
        var $loadBtn = $wrapper.find('.jr-bgt-loadmore');
        var category = $wrapper.data('jr-bgt-current-category') || 'all';

        if (isFilter) {
            $grid.addClass('jr-bgt-loading');
        } else {
            $loadBtn.addClass('jr-loading').text(settings.loading_text);
        }

        var requestData = {
            action: action,
            nonce: jrAddons.nonces.blog_grid,
            page: page,
            posts_per_page: settings.posts_per_page,
            category: category,
            post_type: settings.post_type,
            taxonomy: settings.taxonomy,
            orderby: settings.orderby,
            order: settings.order,
            excerpt_length: settings.excerpt_length,
            button_text: settings.button_text,
            show_category_badge: settings.show_category_badge,
            show_excerpt: settings.show_excerpt,
            show_button: settings.show_button,
            show_image: settings.show_image,
            show_date: settings.show_date || '',
            show_author: settings.show_author || '',
            image_size: settings.image_size
        };

        console.log('JR BGT: Sending →', requestData);

        $.ajax({
            url: jrAddons.ajax_url,
            type: 'POST',
            dataType: 'json',
            data: requestData,
            success: function (res) {
                console.log('JR BGT: Response →', res);

                if (res && res.success) {
                    if (isFilter) {
                        handleFilterResponse($wrapper, res.data);
                    } else {
                        handleLoadMoreResponse($wrapper, res.data, page);
                    }
                } else {
                    console.error('JR BGT: Server error', res);
                    handleError($wrapper, isFilter, page);
                }
                $wrapper.data('jr-bgt-loading', false);
            },
            error: function (xhr, status, error) {
                console.error('JR BGT: AJAX failed', {
                    status: xhr.status,
                    error: error,
                    response: xhr.responseText
                });
                handleError($wrapper, isFilter, page);
                $wrapper.data('jr-bgt-loading', false);
            }
        });
    }

    function handleFilterResponse($wrapper, data) {
        var $grid     = $wrapper.find('.jr-bgt-grid');
        var $loadWrap = $wrapper.find('.jr-bgt-loadmore-wrap');
        var $loadBtn  = $wrapper.find('.jr-bgt-loadmore');
        var settings  = $wrapper.data('settings');

        var html = data.html || '';
        var $newCards = $($.parseHTML(html));

        applyClasses($wrapper, $newCards);
        $newCards.addClass('jr-bgt-animate');

        if ($newCards.length > 0) {
            $grid.html($newCards);
        } else {
            $grid.html('<p class="jr-bgt-no-posts">No posts found in this category.</p>');
        }

        $grid.removeClass('jr-bgt-loading');

        var maxPages = parseInt(data.max_pages) || 1;
        $wrapper.data('jr-bgt-max-pages', maxPages);

        if (maxPages <= 1) {
            $loadWrap.hide();
        } else {
            $loadWrap.show();
            $loadBtn.text(settings.loadmore_text)
                    .removeClass('jr-no-more jr-loading');
        }

        setTimeout(function () {
            $newCards.removeClass('jr-bgt-animate');
        }, 800);
    }

    function handleLoadMoreResponse($wrapper, data, page) {
        var $grid    = $wrapper.find('.jr-bgt-grid');
        var $loadBtn = $wrapper.find('.jr-bgt-loadmore');
        var settings = $wrapper.data('settings');

        var html = data.html || '';
        var $newCards = $($.parseHTML(html));

        applyClasses($wrapper, $newCards);
        $newCards.addClass('jr-bgt-animate');

        if ($newCards.length > 0) {
            $grid.append($newCards);
        }

        var maxPages = parseInt(data.max_pages) || 1;
        $wrapper.data('jr-bgt-max-pages', maxPages);

        if (page >= maxPages) {
            $loadBtn.text(settings.nomore_text)
                    .addClass('jr-no-more')
                    .removeClass('jr-loading');
        } else {
            $loadBtn.text(settings.loadmore_text)
                    .removeClass('jr-loading jr-no-more');
        }

        setTimeout(function () {
            $newCards.removeClass('jr-bgt-animate');
        }, 800);
    }

    function handleError($wrapper, isFilter, page) {
        var $grid    = $wrapper.find('.jr-bgt-grid');
        var $loadBtn = $wrapper.find('.jr-bgt-loadmore');
        var settings = $wrapper.data('settings');

        if (isFilter) {
            $grid.removeClass('jr-bgt-loading');
        } else {
            $loadBtn.removeClass('jr-loading').text(settings.loadmore_text);
            $wrapper.data('jr-bgt-current-page', page - 1);
        }
    }

    function applyClasses($wrapper, $cards) {
        var hoverClass = $wrapper.data('hover-class') || '';
        var zoomClass  = $wrapper.data('zoom-class') || '';
        var btnClass   = $wrapper.data('btn-class') || '';

        if (hoverClass) {
            $cards.filter('.jr-bgt-card').addClass(hoverClass);
        }
        if (zoomClass) {
            $cards.find('.jr-bgt-card-image').addClass(zoomClass);
        }
        if (btnClass) {
            $cards.find('.jr-bgt-read-more').addClass(btnClass);
        }
    }

    // ── Init Log ──
    $(document).ready(function () {
        var count = $('.jr-bgt-wrapper').length;
        console.log('JR BGT: Ready! Wrappers:', count);

        if (count > 0) {
            if (typeof jrAddons !== 'undefined' && jrAddons.nonces && jrAddons.nonces.blog_grid) {
                console.log('✅ JR BGT: jrAddons loaded with blog_grid nonce');
            } else {
                console.error('JR BGT: jrAddons.nonces.blog_grid missing!');
            }
        }
    });

})(jQuery);