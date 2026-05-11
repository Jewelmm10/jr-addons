<?php
namespace JR_Addons\Elementor\Widgets\SingleProduct;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;

if ( ! defined( 'ABSPATH' ) ) exit;

class Product_Action_Buttons extends Widget_Base {

    public function get_name() {
        return 'jr-product-action-buttons';
    }

    public function get_title() {
        return __( 'Product Action Buttons', 'jr-addons' );
    }

    public function get_icon() {
        return 'jr-get-icon';
    }

    public function get_categories() {
        return [ 'jr-wc' ];
    }

    public function get_keywords() {
        return [ 'product', 'add to cart', 'buy now', 'whatsapp', 'call', 'woocommerce' ];
    }

    public function get_script_depends() {
        return [ 'jr-product-actions-script' ];
    }

    public function get_style_depends() {
        return [ 'product-actions-btn' ];
    }

    /**
     * Register Controls
     */
    protected function register_controls() {

        /* ===========================
         * SECTION: Layout
         * =========================== */
        $this->start_controls_section(
            'section_layout',
            [
                'label' => __( 'Layout', 'jr-addons' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'layout_style',
            [
                'label'   => __( 'Buttons Layout', 'jr-addons' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'grid-2',
                'options' => [
                    'grid-2'  => __( '2 x 2 Grid', 'jr-addons' ),
                    'inline'  => __( 'Single Row (Inline)', 'jr-addons' ),
                    'stacked' => __( 'Stacked (Full Width)', 'jr-addons' ),
                ],
            ]
        );

        $this->add_control(
            'show_quantity',
            [
                'label'        => __( 'Show Quantity', 'jr-addons' ),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => 'yes',
                'label_on'     => __( 'Show', 'jr-addons' ),
                'label_off'    => __( 'Hide', 'jr-addons' ),
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'quantity_label',
            [
                'label'     => __( 'Quantity Label', 'jr-addons' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => __( 'Quantity:', 'jr-addons' ),
                'condition' => [ 'show_quantity' => 'yes' ],
            ]
        );

        $this->end_controls_section();

        /* ===========================
         * SECTION: Add to Cart
         * =========================== */
        $this->start_controls_section(
            'section_add_to_cart',
            [
                'label' => __( '🛒 Add to Cart Button', 'jr-addons' ),
            ]
        );

        $this->add_control(
            'show_add_to_cart',
            [
                'label'        => __( 'Show Button', 'jr-addons' ),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => 'yes',
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'add_to_cart_text',
            [
                'label'     => __( 'Text', 'jr-addons' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => __( 'Add to Cart', 'jr-addons' ),
                'condition' => [ 'show_add_to_cart' => 'yes' ],
            ]
        );

        $this->add_control(
            'add_to_cart_icon',
            [
                'label'     => __( 'Icon', 'jr-addons' ),
                'type'      => Controls_Manager::ICONS,
                'default'   => [
                    'value'   => 'fas fa-shopping-bag',
                    'library' => 'fa-solid',
                ],
                'condition' => [ 'show_add_to_cart' => 'yes' ],
            ]
        );

        $this->end_controls_section();

        /* ===========================
         * SECTION: Buy Now
         * =========================== */
        $this->start_controls_section(
            'section_buy_now',
            [
                'label' => __( '⚡ Buy Now Button', 'jr-addons' ),
            ]
        );

        $this->add_control(
            'show_buy_now',
            [
                'label'        => __( 'Show Button', 'jr-addons' ),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => 'yes',
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'buy_now_text',
            [
                'label'     => __( 'Text', 'jr-addons' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => __( 'Buy Now', 'jr-addons' ),
                'condition' => [ 'show_buy_now' => 'yes' ],
            ]
        );

        $this->add_control(
            'buy_now_icon',
            [
                'label'     => __( 'Icon', 'jr-addons' ),
                'type'      => Controls_Manager::ICONS,
                'default'   => [
                    'value'   => 'fas fa-bolt',
                    'library' => 'fa-solid',
                ],
                'condition' => [ 'show_buy_now' => 'yes' ],
            ]
        );

        $this->end_controls_section();

        /* ===========================
         * SECTION: WhatsApp
         * =========================== */
        $this->start_controls_section(
            'section_whatsapp',
            [
                'label' => __( '💬 WhatsApp Button', 'jr-addons' ),
            ]
        );

        $this->add_control(
            'show_whatsapp',
            [
                'label'        => __( 'Show Button', 'jr-addons' ),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => 'yes',
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'whatsapp_text',
            [
                'label'     => __( 'Text', 'jr-addons' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => __( 'Order on WhatsApp', 'jr-addons' ),
                'condition' => [ 'show_whatsapp' => 'yes' ],
            ]
        );

        $this->add_control(
            'whatsapp_number',
            [
                'label'       => __( 'WhatsApp Number', 'jr-addons' ),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => '8801XXXXXXXXX',
                'description' => __( 'Country code সহ লিখুন (যেমনঃ 8801712345678)', 'jr-addons' ),
                'condition'   => [ 'show_whatsapp' => 'yes' ],
            ]
        );

        $this->add_control(
            'whatsapp_message',
            [
                'label'       => __( 'Default Message Template', 'jr-addons' ),
                'type'        => Controls_Manager::TEXTAREA,
                'rows'        => 5,
                'default'     => "আসসালামু আলাইকুম,\nআমি অর্ডার করতে চাই:\n\nProduct: {product_name}\nPrice: {product_price}\nQuantity: {quantity}\nLink: {product_url}",
                'description' => __( 'Available tags: {product_name}, {product_price}, {quantity}, {product_url}', 'jr-addons' ),
                'condition'   => [ 'show_whatsapp' => 'yes' ],
            ]
        );

        $this->add_control(
            'whatsapp_icon',
            [
                'label'     => __( 'Icon', 'jr-addons' ),
                'type'      => Controls_Manager::ICONS,
                'default'   => [
                    'value'   => 'fab fa-whatsapp',
                    'library' => 'fa-brands',
                ],
                'condition' => [ 'show_whatsapp' => 'yes' ],
            ]
        );

        $this->end_controls_section();

        /* ===========================
         * SECTION: Call
         * =========================== */
        $this->start_controls_section(
            'section_call',
            [
                'label' => __( '📞 Call Button', 'jr-addons' ),
            ]
        );

        $this->add_control(
            'show_call',
            [
                'label'        => __( 'Show Button', 'jr-addons' ),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => 'yes',
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'call_text',
            [
                'label'     => __( 'Text', 'jr-addons' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => __( 'Call For Order', 'jr-addons' ),
                'condition' => [ 'show_call' => 'yes' ],
            ]
        );

        $this->add_control(
            'call_number',
            [
                'label'       => __( 'Phone Number', 'jr-addons' ),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => '+8801XXXXXXXXX',
                'condition'   => [ 'show_call' => 'yes' ],
            ]
        );

        $this->add_control(
            'call_icon',
            [
                'label'     => __( 'Icon', 'jr-addons' ),
                'type'      => Controls_Manager::ICONS,
                'default'   => [
                    'value'   => 'fas fa-phone-alt',
                    'library' => 'fa-solid',
                ],
                'condition' => [ 'show_call' => 'yes' ],
            ]
        );

        $this->end_controls_section();

        /* ===========================
         * STYLE TAB
         * =========================== */
        $this->register_style_controls();
    }

    /**
     * Style Controls
     */
    protected function register_style_controls() {

        /* ===========================
         * STYLE: General Buttons
         * =========================== */
        $this->start_controls_section(
            'style_general',
            [
                'label' => __( 'General Style', 'jr-addons' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'btn_typography',
                'selector' => '{{WRAPPER}} .jr-pab-btn',
            ]
        );

        $this->add_responsive_control(
            'btn_padding',
            [
                'label'      => __( 'Button Padding', 'jr-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em' ],
                'default'    => [ 'top' => 14, 'right' => 20, 'bottom' => 14, 'left' => 20, 'unit' => 'px' ],
                'selectors'  => [
                    '{{WRAPPER}} .jr-pab-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'btn_radius',
            [
                'label'      => __( 'Border Radius', 'jr-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'default'    => [ 'top' => 6, 'right' => 6, 'bottom' => 6, 'left' => 6, 'unit' => 'px' ],
                'selectors'  => [
                    '{{WRAPPER}} .jr-pab-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'btn_gap',
            [
                'label'      => __( 'Gap Between Buttons', 'jr-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 12 ],
                'selectors'  => [
                    '{{WRAPPER}} .jr-pab-buttons' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'btn_icon_size',
            [
                'label'     => __( 'Icon Size', 'jr-addons' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [ 'px' => [ 'min' => 10, 'max' => 40 ] ],
                'default'   => [ 'unit' => 'px', 'size' => 18 ],
                'selectors' => [
                    '{{WRAPPER}} .jr-pab-btn i, {{WRAPPER}} .jr-pab-btn svg' => 'font-size: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /* Per-button color sections */
        $this->register_button_color_section( 'add_to_cart', '🛒 Add to Cart Colors', '#FF8C00', '#fff', '#e07b00' );
        $this->register_button_color_section( 'buy_now', '⚡ Buy Now Colors', '#1a2b3c', '#fff', '#0d1822' );
        $this->register_button_color_section( 'whatsapp', '💬 WhatsApp Colors', '#25D366', '#fff', '#1da851' );
        $this->register_button_color_section( 'call', '📞 Call Colors', '#1e4ba8', '#fff', '#163a82' );
    }

    /**
     * Helper: Register color section for each button
     */
    private function register_button_color_section( $key, $label, $bg, $text, $hover_bg ) {
        $this->start_controls_section(
            'style_' . $key,
            [
                'label' => __( $label, 'jr-addons' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs( 'tabs_' . $key );

        // ===== Normal Tab =====
        $this->start_controls_tab( 'tab_normal_' . $key, [ 'label' => __( 'Normal', 'jr-addons' ) ] );

        $this->add_control(
            $key . '_bg',
            [
                'label'     => __( 'Background', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => $bg,
                'selectors' => [ '{{WRAPPER}} .jr-pab-' . $key => 'background-color: {{VALUE}};' ],
            ]
        );

        $this->add_control(
            $key . '_color',
            [
                'label'     => __( 'Text Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => $text,
                'selectors' => [ '{{WRAPPER}} .jr-pab-' . $key => 'color: {{VALUE}};' ],
            ]
        );

        // ✅ NEW: Icon Color
        $this->add_control(
            $key . '_icon_color',
            [
                'label'     => __( 'Icon Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => $text,
                'selectors' => [
                    '{{WRAPPER}} .jr-pab-' . $key . ' i'         => 'color: {{VALUE}} !important;',
                    '{{WRAPPER}} .jr-pab-' . $key . ' svg'       => 'fill: {{VALUE}} !important;',
                    '{{WRAPPER}} .jr-pab-' . $key . ' svg path'  => 'fill: {{VALUE}} !important; stroke: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        // ===== Hover Tab =====
        $this->start_controls_tab( 'tab_hover_' . $key, [ 'label' => __( 'Hover', 'jr-addons' ) ] );

        $this->add_control(
            $key . '_bg_hover',
            [
                'label'     => __( 'Background', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => $hover_bg,
                'selectors' => [ '{{WRAPPER}} .jr-pab-' . $key . ':hover' => 'background-color: {{VALUE}};' ],
            ]
        );

        $this->add_control(
            $key . '_color_hover',
            [
                'label'     => __( 'Text Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => $text,
                'selectors' => [ '{{WRAPPER}} .jr-pab-' . $key . ':hover' => 'color: {{VALUE}};' ],
            ]
        );

        // ✅ NEW: Icon Hover Color
        $this->add_control(
            $key . '_icon_color_hover',
            [
                'label'     => __( 'Icon Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => $text,
                'selectors' => [
                    '{{WRAPPER}} .jr-pab-' . $key . ':hover i'        => 'color: {{VALUE}} !important;',
                    '{{WRAPPER}} .jr-pab-' . $key . ':hover svg'      => 'fill: {{VALUE}} !important;',
                    '{{WRAPPER}} .jr-pab-' . $key . ':hover svg path' => 'fill: {{VALUE}} !important; stroke: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();
    }

   
    /**
     * Render Output
     */
    protected function render() {
        $settings = $this->get_settings_for_display();

        // Get current product
        global $product;
        
        $is_edit_mode    = \Elementor\Plugin::$instance->editor->is_edit_mode();
        $is_preview_mode = \Elementor\Plugin::$instance->preview->is_preview_mode();

        if ( ! $product && function_exists( 'wc_get_product' ) ) {
            $product = wc_get_product( get_the_ID() );
        }

        // ===== Editor/Preview Fallback: Load a dummy product =====
        if ( ! $product && ( $is_edit_mode || $is_preview_mode ) ) {
            $product = $this->jr_get_preview_product();
        }

        if ( ! $product ) {
            if ( $is_edit_mode ) {
                echo '<div style="padding:20px; background:#fff3cd; border:1px dashed #ffc107; text-align:center; border-radius:6px;">⚠️ কোনো product পাওয়া যায়নি। অন্তত একটা WooCommerce product create করুন।</div>';
            }
            return;
        }

        $product_id    = $product->get_id();
        $product_name  = $product->get_name();
        $product_price = wp_strip_all_tags( wc_price( $product->get_price() ) );
        $product_url   = get_permalink( $product_id );
        $checkout_url  = function_exists( 'wc_get_checkout_url' ) ? wc_get_checkout_url() : '#';

        // WhatsApp link build
        $whatsapp_link = '#';
        if ( $settings['show_whatsapp'] === 'yes' && ! empty( $settings['whatsapp_number'] ) ) {
            $msg = $settings['whatsapp_message'];
            $msg = str_replace(
                [ '{product_name}', '{product_price}', '{quantity}', '{product_url}' ],
                [ $product_name, $product_price, '1', $product_url ],
                $msg
            );
            $whatsapp_link = 'https://wa.me/' . preg_replace( '/[^0-9]/', '', $settings['whatsapp_number'] ) . '?text=' . rawurlencode( $msg );
        }

        $layout_class = 'jr-pab-layout-' . esc_attr( $settings['layout_style'] );

        // Max quantity safe handling
        $max_qty = method_exists( $product, 'get_max_purchase_quantity' ) ? $product->get_max_purchase_quantity() : -1;
        if ( $max_qty <= 0 ) $max_qty = 9999;

        // Sold individually safe check
        $sold_individually = method_exists( $product, 'is_sold_individually' ) ? $product->is_sold_individually() : false;
        $is_purchasable    = method_exists( $product, 'is_purchasable' ) ? $product->is_purchasable() : true;

        // Data attributes for JS
        $data_attrs = sprintf(
            'data-product-id="%d" data-product-name="%s" data-product-price="%s" data-product-url="%s" data-checkout-url="%s" data-whatsapp-number="%s" data-whatsapp-template="%s"',
            esc_attr( $product_id ),
            esc_attr( $product_name ),
            esc_attr( $product_price ),
            esc_attr( $product_url ),
            esc_attr( $checkout_url ),
            esc_attr( preg_replace( '/[^0-9]/', '', $settings['whatsapp_number'] ?? '' ) ),
            esc_attr( $settings['whatsapp_message'] ?? '' )
        );
        ?>

        <div class="jr-pab-wrapper <?php echo esc_attr( $layout_class ); ?>" <?php echo $data_attrs; ?>>

            <?php if ( $settings['show_quantity'] === 'yes' && $is_purchasable && ! $sold_individually ) : ?>
                <div class="jr-pab-quantity-row">
                    <label class="jr-pab-qty-label"><?php echo esc_html( $settings['quantity_label'] ); ?></label>
                    <div class="jr-pab-qty-box">
                        <button type="button" class="jr-pab-qty-minus">−</button>
                        <input type="number" class="jr-pab-qty-input" value="1" min="1" max="<?php echo esc_attr( $max_qty ); ?>">
                        <button type="button" class="jr-pab-qty-plus">+</button>
                    </div>
                </div>
            <?php endif; ?>

            <div class="jr-pab-buttons">

                <?php if ( $settings['show_add_to_cart'] === 'yes' ) : ?>
                    <button type="button" class="jr-pab-btn jr-pab-add_to_cart" data-action="add_to_cart">
                        <?php \Elementor\Icons_Manager::render_icon( $settings['add_to_cart_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                        <span class="jr-pab-btn-text"><?php echo esc_html( $settings['add_to_cart_text'] ); ?></span>
                    </button>
                <?php endif; ?>

                <?php if ( $settings['show_buy_now'] === 'yes' ) : ?>
                    <button type="button" class="jr-pab-btn jr-pab-buy_now" data-action="buy_now">
                        <?php \Elementor\Icons_Manager::render_icon( $settings['buy_now_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                        <span class="jr-pab-btn-text"><?php echo esc_html( $settings['buy_now_text'] ); ?></span>
                    </button>
                <?php endif; ?>

                <?php if ( $settings['show_whatsapp'] === 'yes' ) : ?>
                    <a href="<?php echo esc_url( $whatsapp_link ); ?>" target="_blank" rel="noopener" class="jr-pab-btn jr-pab-whatsapp" data-action="whatsapp">
                        <?php \Elementor\Icons_Manager::render_icon( $settings['whatsapp_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                        <span class="jr-pab-btn-text"><?php echo esc_html( $settings['whatsapp_text'] ); ?></span>
                    </a>
                <?php endif; ?>

                <?php if ( $settings['show_call'] === 'yes' ) : ?>
                    <a href="tel:<?php echo esc_attr( $settings['call_number'] ); ?>" class="jr-pab-btn jr-pab-call" data-action="call">
                        <?php \Elementor\Icons_Manager::render_icon( $settings['call_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                        <span class="jr-pab-btn-text"><?php echo esc_html( $settings['call_text'] ); ?></span>
                    </a>
                <?php endif; ?>

            </div>
        </div>
        <?php
    }

    /**
     * Get a preview product for Elementor editor mode
     */
    private function jr_get_preview_product() {
        if ( ! function_exists( 'wc_get_product' ) ) return false;

        // Try to get the latest published product
        $args = [
            'limit'   => 1,
            'status'  => 'publish',
            'orderby' => 'date',
            'order'   => 'DESC',
        ];

        $products = wc_get_products( $args );

        if ( ! empty( $products ) ) {
            return $products[0];
        }

        return false;
    }
}