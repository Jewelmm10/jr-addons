<?php
namespace JR_Addons\Tools;

if ( ! defined( 'ABSPATH' ) ) exit;

class JR_Buy_Now {

    public function __construct() {
        add_action( 'template_redirect', [ $this, 'handle_buy_now' ] );
    }

    public function handle_buy_now() {
        if ( ! isset( $_GET['jr-buy-now'] ) ) return;
        if ( ! function_exists( 'WC' ) ) return;

        $product_id = absint( $_GET['jr-buy-now'] );
        $quantity   = isset( $_GET['jr-qty'] ) ? absint( $_GET['jr-qty'] ) : 1;

        if ( ! $product_id ) return;

        // Empty cart first (direct checkout with this product only)
        WC()->cart->empty_cart();

        // Add the product
        WC()->cart->add_to_cart( $product_id, $quantity );

        // Redirect to checkout (clean URL)
        wp_safe_redirect( wc_get_checkout_url() );
        exit;
    }
    


}

new JR_Buy_Now();