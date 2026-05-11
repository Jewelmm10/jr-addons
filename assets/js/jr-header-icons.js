(function($) {
    'use strict';

    $(document).ready(function() {
        initHeaderIcons();
        initCartActions();
    });

    $(window).on('elementor/frontend/init', function() {
        if (typeof elementorFrontend !== 'undefined') {
            elementorFrontend.hooks.addAction(
                'frontend/element_ready/jr_header_icons.default',
                function() {
                    initHeaderIcons();
                    initCartActions();
                }
            );
        }
    });

    /* ============= DRAWER OPEN/CLOSE ============= */
    function initHeaderIcons() {
        $(document).off('click.jrcart', '.jr-cart-trigger').on('click.jrcart', '.jr-cart-trigger', function(e) {
            const mode = $(this).data('cart-mode');
            if (mode === 'drawer' || mode === 'both') {
                e.preventDefault();
                openDrawer();
            }
        });

        $(document).off('click.jrcartclose', '.jr-drawer-close, .jr-drawer-overlay')
            .on('click.jrcartclose', '.jr-drawer-close, .jr-drawer-overlay', closeDrawer);

        $(document).off('keydown.jrcart').on('keydown.jrcart', function(e) {
            if (e.key === 'Escape') closeDrawer();
        });
    }

    function openDrawer() {
        $('.jr-drawer-overlay').addClass('active');
        $('.jr-cart-drawer').addClass('active');
        $('body').css('overflow', 'hidden');
    }

    function closeDrawer() {
        $('.jr-drawer-overlay').removeClass('active');
        $('.jr-cart-drawer').removeClass('active');
        $('body').css('overflow', '');
    }

    /* ============= QUANTITY +/- + REMOVE (Event Delegation) ============= */
    function initCartActions() {
        
        // ✅ Plus button - using event delegation on document
        $(document).off('click.jrminiplus', '.jr-mini-qty-plus')
            .on('click.jrminiplus', '.jr-mini-qty-plus', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const $btn = $(this);
                const $input = $btn.siblings('.jr-mini-qty-input');
                const cartKey = $btn.data('key');
                const newQty = parseInt($input.val()) + 1;
                
                $input.val(newQty);
                updateQuantity(cartKey, newQty);
            });

        // ✅ Minus button
        $(document).off('click.jrminiminus', '.jr-mini-qty-minus')
            .on('click.jrminiminus', '.jr-mini-qty-minus', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const $btn = $(this);
                const $input = $btn.siblings('.jr-mini-qty-input');
                const cartKey = $btn.data('key');
                const newQty = Math.max(1, parseInt($input.val()) - 1);
                
                $input.val(newQty);
                updateQuantity(cartKey, newQty);
            });

        // ✅ Remove Item
        $(document).off('click.jrremove', '.jr-cart-remove')
            .on('click.jrremove', '.jr-cart-remove', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const $item = $(this).closest('.jr-cart-item');
                const cartKey = $(this).data('key');
                
                $item.addClass('jr-removing');
                removeCartItem(cartKey);
            });
    }

    /* ============= AJAX: UPDATE QUANTITY ============= */
    let qtyTimer;
    function updateQuantity(cartKey, qty) {
        clearTimeout(qtyTimer);
        
        $('.jr-mini-cart-content').addClass('jr-cart-loading');
        
        qtyTimer = setTimeout(function() {
            $.ajax({
                url: jrSearch.ajax_url,
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'jr_update_cart_qty',
                    nonce: jrSearch.nonce,
                    cart_key: cartKey,
                    quantity: qty
                },
                success: function(res) {
                    console.log('Update Qty Response:', res);
                    
                    if (res.success && res.data) {
                        // ✅ Direct update HTML - more reliable than fragments
                        if (res.data.html) {
                            $('.jr-cart-wrapper .widget_shopping_cart_content').html(res.data.html);
                            $('.jr-cart-drawer .widget_shopping_cart_content').html(res.data.html);
                        }
                        
                        // Update count
                        if (typeof res.data.count !== 'undefined') {
                            $('.jr-cart-count').text(res.data.count);
                            $('.jr-drawer-count').text(res.data.count);
                        }
                        
                        // Trigger WC fragment refresh for other elements
                        $(document.body).trigger('wc_fragment_refresh');
                    }
                },
                error: function(xhr) {
                    console.error('Update Qty Error:', xhr.responseText);
                },
                complete: function() {
                    // ✅ ALWAYS remove loading - even on error
                    $('.jr-mini-cart-content').removeClass('jr-cart-loading');
                }
            });
        }, 250);
    }

    /* ============= AJAX: REMOVE ITEM ============= */
    function removeCartItem(cartKey) {
        $.ajax({
            url: jrSearch.ajax_url,
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'jr_remove_cart_item',
                nonce: jrSearch.nonce,
                cart_key: cartKey
            },
            success: function(res) {
                console.log('Remove Response:', res);
                
                if (res.success && res.data) {
                    // ✅ Direct HTML update
                    if (res.data.html) {
                        $('.jr-cart-wrapper .widget_shopping_cart_content').html(res.data.html);
                        $('.jr-cart-drawer .widget_shopping_cart_content').html(res.data.html);
                    }
                    
                    if (typeof res.data.count !== 'undefined') {
                        $('.jr-cart-count').text(res.data.count);
                        $('.jr-drawer-count').text(res.data.count);
                    }
                    
                    $(document.body).trigger('wc_fragment_refresh');
                }
            },
            error: function(xhr) {
                console.error('Remove Error:', xhr.responseText);
            },
            complete: function() {
                $('.jr-mini-cart-content').removeClass('jr-cart-loading');
            }
        });
    }

    /* ============= ✅ TRIGGER WC FRAGMENT REFRESH ============= */
    function triggerCartRefresh() {
        // This will trigger our cart_fragments filter and update the HTML
        $(document.body).trigger('wc_fragment_refresh');
    }

    /* ============= AUTO OPEN DRAWER on Add to Cart ============= */
    $(document.body).on('added_to_cart', function(event, fragments, cart_hash, $button) {
        const $trigger = $('.jr-cart-trigger');
        const cartMode = $trigger.data('cart-mode');
        
        if (cartMode === 'drawer' || cartMode === 'both') {
            // ✅ Wait for fragments to load first, then open drawer
            setTimeout(function() {
                openDrawer();
            }, 500);
        }
    });

    /* ============= REMOVE LOADING STATE after fragments load ============= */
    $(document.body).on('wc_fragments_loaded wc_fragments_refreshed', function() {
        $('.jr-mini-cart-content').removeClass('jr-cart-loading');
    });

})(jQuery);