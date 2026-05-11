<?php

namespace JR_Addons\Tools;

if (!defined('ABSPATH')) exit;

class Helpers {

    public function __construct() {
        //add_action( 'woocommerce_add_to_cart_fragments', [ $this, 'cart_count_fragment' ], 10, 1 );

        // Buy Now: Redirect to checkout
        add_filter( 'woocommerce_add_to_cart_redirect', [ $this, 'buy_now_redirect' ], 99 );

        // Buy Now: Clear other cart items (true buy-now experience)
        add_action( 'woocommerce_add_to_cart', [ $this, 'buy_now_clear_cart' ], 10, 6 );
    }

    /**
     * Cart count fragment (for header cart icon)
     */
    public function cart_count_fragment( $fragments ) {
        ob_start();
        ?>
        <span class="jr-cart-count">
            <?php echo WC()->cart->get_cart_contents_count(); ?>
        </span>
        <?php
        $fragments['span.jr-cart-count'] = ob_get_clean();

        return $fragments;
    }

    /**
     * Redirect to checkout if Buy Now
     */
    public function buy_now_redirect( $url ) {
        if ( isset( $_REQUEST['jr_buy_now'] ) && $_REQUEST['jr_buy_now'] == '1' ) {
            return wc_get_checkout_url();
        }
        return $url;
    }

    /**
     * Clear other cart items - keep only this product
     */
    public function buy_now_clear_cart( $cart_item_key, $product_id, $quantity, $variation_id, $variation, $cart_item_data ) {

        if ( isset( $_REQUEST['jr_buy_now'] ) && $_REQUEST['jr_buy_now'] == '1' ) {
            foreach ( WC()->cart->get_cart() as $key => $item ) {
                if ( $key !== $cart_item_key ) {
                    WC()->cart->remove_cart_item( $key );
                }
            }
        }
    }
}


/**
 * Override single product template hooks for Elementor
 */
add_action( 'init', function () {

    add_action( 'template_redirect', function () {

        if ( ! is_singular( 'product' ) ) return;

        $post_id = get_the_ID();

        if ( ! did_action( 'elementor/loaded' ) ) return;

        $document = \Elementor\Plugin::$instance->documents->get( $post_id );

        if ( $document && $document->is_built_with_elementor() ) {

            remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
            remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
            remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
            remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
            remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
            remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
            remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );

            remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
            remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
            remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
            remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
        }
    });
});
