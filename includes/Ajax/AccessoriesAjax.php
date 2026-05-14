<?php
namespace JR_Addons\Ajax;

if (!defined('ABSPATH')) exit;

class AccessoriesAjax {

    public static function init() {
        add_action('wp_ajax_jr_acc_add_to_cart', [__CLASS__, 'add_to_cart']);
        add_action('wp_ajax_nopriv_jr_acc_add_to_cart', [__CLASS__, 'add_to_cart']);
    }

    public static function add_to_cart() {
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'jr_form_nonce')) {
            wp_send_json_error(['message' => __('Security check failed.', 'jr-addons')]);
        }

        $product_id = isset($_POST['product_id']) ? absint($_POST['product_id']) : 0;
        $quantity = isset($_POST['quantity']) ? absint($_POST['quantity']) : 1;

        if (!$product_id) {
            wp_send_json_error(['message' => __('Invalid product.', 'jr-addons')]);
        }

        $product = wc_get_product($product_id);
        if (!$product || !$product->is_purchasable() || !$product->is_in_stock()) {
            wp_send_json_error(['message' => __('Product not available.', 'jr-addons')]);
        }

        $added = WC()->cart->add_to_cart($product_id, $quantity);

        if (!$added) {
            wp_send_json_error(['message' => __('Could not add to cart.', 'jr-addons')]);
        }

        // Get fragments for mini cart update
        WC_AJAX::get_refreshed_fragments();
    }
}