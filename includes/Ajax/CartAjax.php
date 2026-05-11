<?php
namespace JR_Addons\Ajax;

if (!defined('ABSPATH')) exit;

use JR_Addons\Tools\MiniCart;

class CartAjax {

    public static function init() {
        add_action('wp_ajax_jr_update_cart_count', [__CLASS__, 'update_cart_count']);
        add_action('wp_ajax_nopriv_jr_update_cart_count', [__CLASS__, 'update_cart_count']);
        
        add_action('wp_ajax_jr_update_cart_qty', [__CLASS__, 'update_cart_qty']);
        add_action('wp_ajax_nopriv_jr_update_cart_qty', [__CLASS__, 'update_cart_qty']);
        
        add_action('wp_ajax_jr_remove_cart_item', [__CLASS__, 'remove_cart_item']);
        add_action('wp_ajax_nopriv_jr_remove_cart_item', [__CLASS__, 'remove_cart_item']);
    }

    public static function update_cart_count() {
        while (ob_get_level()) ob_end_clean();
        check_ajax_referer('jr_search_nonce', 'nonce');

        if (!class_exists('WooCommerce') || !WC()->cart) {
            wp_send_json_error(['message' => 'WooCommerce not active']);
        }

        wp_send_json_success(self::get_cart_data());
    }

    public static function update_cart_qty() {
        while (ob_get_level()) ob_end_clean();
        check_ajax_referer('jr_search_nonce', 'nonce');

        if (!class_exists('WooCommerce') || !WC()->cart) {
            wp_send_json_error(['message' => 'WooCommerce not active']);
        }

        $cart_key = isset($_POST['cart_key']) ? sanitize_text_field(wp_unslash($_POST['cart_key'])) : '';
        $quantity = isset($_POST['quantity']) ? (int) $_POST['quantity'] : 1;

        if (empty($cart_key)) {
            wp_send_json_error(['message' => 'Invalid cart key']);
        }

        $cart_item = WC()->cart->get_cart_item($cart_key);
        if (!$cart_item) {
            wp_send_json_error(['message' => 'Cart item not found']);
        }

        // ✅ Update quantity and recalculate
        WC()->cart->set_quantity($cart_key, max(1, $quantity), true);
        WC()->cart->calculate_totals();

        wp_send_json_success(self::get_cart_data());
    }

    public static function remove_cart_item() {
        while (ob_get_level()) ob_end_clean();
        check_ajax_referer('jr_search_nonce', 'nonce');

        if (!class_exists('WooCommerce') || !WC()->cart) {
            wp_send_json_error(['message' => 'WooCommerce not active']);
        }

        $cart_key = isset($_POST['cart_key']) ? sanitize_text_field(wp_unslash($_POST['cart_key'])) : '';

        if (empty($cart_key)) {
            wp_send_json_error(['message' => 'Invalid cart key']);
        }

        WC()->cart->remove_cart_item($cart_key);
        WC()->cart->calculate_totals();

        wp_send_json_success(self::get_cart_data());
    }

    /**
     * ✅ Get all cart data including fragments
     */
    private static function get_cart_data() {
        ob_start();
        MiniCart::render();
        $html = ob_get_clean();

        return [
            'count'     => WC()->cart->get_cart_contents_count(),
            'total'     => WC()->cart->get_cart_subtotal(),
            'html'      => $html,
            'fragments' => apply_filters('woocommerce_add_to_cart_fragments', []),
        ];
    }
}