<?php
namespace JR_Addons\Tools;

if (!defined('ABSPATH')) exit;

class MiniCart {

    /**
     * ✅ Initialize - Hook into WooCommerce fragments
     */
    public static function init() {
        add_filter('woocommerce_add_to_cart_fragments', [__CLASS__, 'cart_fragments']);
    }

    /**
     * ✅ Override WooCommerce fragments - inject our custom HTML
     */
    public static function cart_fragments($fragments) {
    
        if (!class_exists('WooCommerce') || !WC()->cart) {
            return $fragments;
        }

        $count = WC()->cart->get_cart_contents_count();

        // ✅ Use more specific selectors to avoid conflict
        $fragments['.jr-header-icons span.jr-cart-count'] = 
            '<span class="jr-count-badge jr-cart-count">' . esc_html($count) . '</span>';
        
        $fragments['.jr-cart-drawer .jr-drawer-count'] = 
            '<span class="jr-drawer-count">' . esc_html($count) . '</span>';

        // ✅ Update mini cart HTML
        ob_start();
        self::render();
        $mini_cart_html = ob_get_clean();

        $fragments['.jr-cart-wrapper .widget_shopping_cart_content'] = 
            '<div class="widget_shopping_cart_content">' . $mini_cart_html . '</div>';
        
        $fragments['.jr-cart-drawer .widget_shopping_cart_content'] = 
            '<div class="widget_shopping_cart_content">' . $mini_cart_html . '</div>';

        return $fragments;
    }

    /**
     * Render custom mini cart HTML
     */
    public static function render() {
        if (!class_exists('WooCommerce') || !WC()->cart) return;
        
        $cart = WC()->cart;
        $cart_items = $cart->get_cart();
        ?>
        
        <div class="jr-mini-cart-content">
            
            <?php if (empty($cart_items)): ?>
                
                <div class="jr-cart-empty">
                    <div class="jr-empty-icon">
                        <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="9" cy="21" r="1"></circle>
                            <circle cx="20" cy="21" r="1"></circle>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                        </svg>
                    </div>
                    <h4><?php esc_html_e('Your cart is empty', 'jr-addons'); ?></h4>
                    <p><?php esc_html_e('Looks like you have no items added yet.', 'jr-addons'); ?></p>
                    <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="jr-cart-shop-btn">
                        <?php esc_html_e('Continue Shopping', 'jr-addons'); ?>
                    </a>
                </div>
                
            <?php else: ?>
                
                <ul class="jr-cart-items">
                    <?php foreach ($cart_items as $cart_item_key => $cart_item): 
                        $product = $cart_item['data'];
                        
                        if (!$product || !$product->exists() || $cart_item['quantity'] <= 0) continue;
                        
                        $product_link  = $product->get_permalink($cart_item);
                        $thumbnail     = $product->get_image('thumbnail', ['class' => 'jr-cart-item-img']);
                        $product_name  = $product->get_name();
                        $quantity      = $cart_item['quantity'];
                        
                        // ✅ Show item TOTAL price (price × quantity), not unit price
                        $line_total = WC()->cart->get_product_subtotal($product, $quantity);
                        ?>
                        
                        <li class="jr-cart-item" data-key="<?php echo esc_attr($cart_item_key); ?>">
                            
                            <a href="<?php echo esc_url($product_link); ?>" class="jr-cart-item-thumb">
                                <?php echo $thumbnail; ?>
                            </a>
                            
                            <div class="jr-cart-item-details">
                                <a href="<?php echo esc_url($product_link); ?>" class="jr-cart-item-name">
                                    <?php echo esc_html($product_name); ?>
                                </a>
                                
                                <div class="jr-cart-item-price">
                                    <?php echo wp_kses_post($line_total); ?>
                                </div>
                                
                                <div class="jr-cart-item-actions">
                                    <div class="jr-cart-qty">
                                        <button type="button" class="jr-mini-qty-btn jr-mini-qty-minus" data-key="<?php echo esc_attr($cart_item_key); ?>">−</button>
                                        <input type="number" 
                                               class="jr-mini-qty-input" 
                                               value="<?php echo esc_attr($quantity); ?>" 
                                               min="1" 
                                               data-key="<?php echo esc_attr($cart_item_key); ?>" 
                                               readonly>
                                        <button type="button" class="jr-mini-qty-btn jr-mini-qty-plus" data-key="<?php echo esc_attr($cart_item_key); ?>">+</button>
                                    </div>
                                    
                                    <button type="button" class="jr-cart-remove" data-key="<?php echo esc_attr($cart_item_key); ?>" aria-label="Remove">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="3 6 5 6 21 6"></polyline>
                                            <path d="M19 6l-2 14a2 2 0 0 1-2 2H9a2 2 0 0 1-2-2L5 6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            
                        </li>
                        
                    <?php endforeach; ?>
                </ul>
                
                <div class="jr-cart-footer">
                    
                    <div class="jr-cart-subtotal">
                        <span class="jr-subtotal-label"><?php esc_html_e('Subtotal:', 'jr-addons'); ?></span>
                        <span class="jr-subtotal-amount"><?php echo wp_kses_post($cart->get_cart_subtotal()); ?></span>
                    </div>
                    
                    <div class="jr-cart-buttons">
                        <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="jr-cart-btn jr-btn-cart">
                            <?php esc_html_e('View Cart', 'jr-addons'); ?>
                        </a>
                        <a href="<?php echo esc_url(wc_get_checkout_url()); ?>" class="jr-cart-btn jr-btn-checkout">
                            <?php esc_html_e('Checkout', 'jr-addons'); ?>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                <polyline points="12 5 19 12 12 19"></polyline>
                            </svg>
                        </a>
                    </div>
                    
                </div>
                
            <?php endif; ?>
            
        </div>
        
        <?php
    }
}