(function($) {
    'use strict';

    $(document).on('click', '.jr-acc-btn.jr-add-to-cart', function(e) {
        e.preventDefault();

        var $btn = $(this);
        if ($btn.hasClass('loading') || $btn.hasClass('added')) return;

        var productId = $btn.data('product-id');
        var defaultText = $btn.data('default-text');
        var addedText = $btn.data('added-text');

        $btn.addClass('loading');
        $btn.find('.jr-btn-text').html('<span class="jr-spinner"></span>');

        $.ajax({
            url: jrAddons.ajax_url,
            type: 'POST',
            data: {
                action: 'jr_acc_add_to_cart',
                nonce: jrAddons.nonces.form,
                product_id: productId,
                quantity: 1
            },
            success: function(res) {
                $btn.removeClass('loading');

                if (res.success) {
                    $btn.addClass('added');
                    $btn.find('.jr-btn-text').text(addedText);

                    // Trigger WooCommerce events for mini cart update
                    $(document.body).trigger('added_to_cart', [
                        res.data.fragments || {},
                        res.data.cart_hash || '',
                        $btn
                    ]);

                    $(document.body).trigger('wc_fragment_refresh');

                    // Reset after 2.5s
                    setTimeout(function() {
                        $btn.removeClass('added');
                        $btn.find('.jr-btn-text').text(defaultText);
                    }, 2500);
                } else {
                    $btn.find('.jr-btn-text').text(defaultText);
                    alert(res.data && res.data.message ? res.data.message : 'Failed to add to cart.');
                }
            },
            error: function() {
                $btn.removeClass('loading');
                $btn.find('.jr-btn-text').text(defaultText);
                alert('Something went wrong. Please try again.');
            }
        });
    });

})(jQuery);