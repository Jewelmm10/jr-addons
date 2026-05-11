(function($){
    'use strict';

    $(document).ready(function(){

        // ===== Quantity +/- =====
        $(document).on('click', '.jr-pab-qty-plus', function(){
            var $input = $(this).siblings('.jr-pab-qty-input');
            var max = parseInt($input.attr('max')) || 9999;
            var val = parseInt($input.val()) || 1;
            if (val < max) $input.val(val + 1).trigger('change');
        });

        $(document).on('click', '.jr-pab-qty-minus', function(){
            var $input = $(this).siblings('.jr-pab-qty-input');
            var min = parseInt($input.attr('min')) || 1;
            var val = parseInt($input.val()) || 1;
            if (val > min) $input.val(val - 1).trigger('change');
        });

        // ===== Add to Cart =====
        $(document).on('click', '.jr-pab-add_to_cart', function(e){
            e.preventDefault();
            var $btn = $(this);
            var $wrapper = $btn.closest('.jr-pab-wrapper');
            var productId = $wrapper.data('product-id');
            var qty = parseInt($wrapper.find('.jr-pab-qty-input').val()) || 1;

            $btn.addClass('is-loading');

            $.ajax({
                url: (typeof wc_add_to_cart_params !== 'undefined') ? wc_add_to_cart_params.wc_ajax_url.toString().replace('%%endpoint%%', 'add_to_cart') : '/?wc-ajax=add_to_cart',
                type: 'POST',
                data: {
                    product_id: productId,
                    quantity: qty
                },
                success: function(response){
                    $btn.removeClass('is-loading').addClass('is-success');
                    
                    // Trigger WC events
                    $(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, $btn]);
                    
                    // Toast notification (if your existing system exists)
                    if (typeof window.jrShowToast === 'function') {
                        window.jrShowToast('Product added to cart!', 'success');
                    }

                    setTimeout(function(){
                        $btn.removeClass('is-success');
                    }, 1500);
                },
                error: function(){
                    $btn.removeClass('is-loading');
                    alert('Error! Please try again.');
                }
            });
        });

        // ===== Buy Now (Direct Checkout) =====
        $(document).on('click', '.jr-pab-buy_now', function(e){
            e.preventDefault();
            var $btn = $(this);
            var $wrapper = $btn.closest('.jr-pab-wrapper');
            var productId = $wrapper.data('product-id');
            var checkoutUrl = $wrapper.data('checkout-url');
            var qty = parseInt($wrapper.find('.jr-pab-qty-input').val()) || 1;

            $btn.addClass('is-loading');

            // Direct checkout with selected product only
            // append ?add-to-cart with empty cart redirect
            var url = checkoutUrl + (checkoutUrl.indexOf('?') > -1 ? '&' : '?') + 'jr-buy-now=' + productId + '&jr-qty=' + qty;
            window.location.href = url;
        });

        // ===== WhatsApp (Update message with current quantity) =====
        $(document).on('click', '.jr-pab-whatsapp', function(e){
            var $btn = $(this);
            var $wrapper = $btn.closest('.jr-pab-wrapper');
            var qty = parseInt($wrapper.find('.jr-pab-qty-input').val()) || 1;
            var template = $wrapper.data('whatsapp-template') || '';
            var number = $wrapper.data('whatsapp-number') || '';

            if (!number || !template) return; // fallback to default href

            e.preventDefault();

            var message = template
                .replace(/{product_name}/g, $wrapper.data('product-name'))
                .replace(/{product_price}/g, $wrapper.data('product-price'))
                .replace(/{quantity}/g, qty)
                .replace(/{product_url}/g, $wrapper.data('product-url'));

            var url = 'https://wa.me/' + number + '?text=' + encodeURIComponent(message);
            window.open(url, '_blank');
        });

    });

})(jQuery);