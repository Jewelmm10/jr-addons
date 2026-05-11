<?php
namespace JR_Addons\Elementor\Widgets\SingleProduct;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if (!defined('ABSPATH')) exit;

class Product_Add_To_Cart extends Widget_Base {

    public function get_name() {
        return 'jr-product-add-to-cart';
    }

    public function get_title() {
        return __('Add To Cart', 'jr-addons');
    }

    public function get_icon() {
        return 'jr-get-icon';
    }

    public function get_categories() {
        return ['jr-wc'];
    }

    protected function register_controls() {

        /* ---------------- CONTENT ---------------- */
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Settings', 'jr-addons' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_quantity',
            [
                'label'        => __( 'Show Quantity', 'jr-addons' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Yes', 'jr-addons' ),
                'label_off'    => __( 'No', 'jr-addons' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'show_buy_now',
            [
                'label'        => __( 'Show Buy Now Button', 'jr-addons' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Yes', 'jr-addons' ),
                'label_off'    => __( 'No', 'jr-addons' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'buy_now_text',
            [
                'label'     => __( 'Buy Now Text', 'jr-addons' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => __( 'Buy Now', 'jr-addons' ),
                'condition' => [ 'show_buy_now' => 'yes' ],
            ]
        );

        $this->add_responsive_control(
            'gap',
            [
                'label'      => __( 'Gap Between Buttons', 'jr-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 10 ],
                'selectors'  => [
                    '{{WRAPPER}} .jr-add-to-cart-wrapper form.cart' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();


        /* ---------------- QUANTITY STYLE ---------------- */
        $this->start_controls_section(
            'qty_style',
            [
                'label' => __( 'Quantity Box', 'jr-addons' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'qty_text_color',
            [
                'label'     => __( 'Text Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#222222',
                'selectors' => [
                    '{{WRAPPER}} .jr-add-to-cart-wrapper .quantity input.qty' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .jr-add-to-cart-wrapper .quantity .jr-qty-btn' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'qty_btn_color',
            [
                'label'     => __( '+ / − Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#e63946',
                'selectors' => [
                    '{{WRAPPER}} .jr-add-to-cart-wrapper .quantity .jr-qty-btn' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'qty_border_color',
            [
                'label'     => __( 'Border Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#e0e0e0',
                'selectors' => [
                    '{{WRAPPER}} .jr-add-to-cart-wrapper .quantity' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'qty_radius',
            [
                'label'      => __( 'Border Radius', 'jr-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'default'    => [ 'top' => 6, 'right' => 6, 'bottom' => 6, 'left' => 6, 'isLinked' => true ],
                'selectors'  => [
                    '{{WRAPPER}} .jr-add-to-cart-wrapper .quantity' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();


        /* ---------------- ADD TO CART STYLE ---------------- */
        $this->start_controls_section(
            'cart_btn_style',
            [
                'label' => __( 'Add To Cart Button', 'jr-addons' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'cart_typo',
                'selector' => '{{WRAPPER}} .jr-add-to-cart-wrapper .single_add_to_cart_button',
            ]
        );

        $this->add_control(
            'cart_text_color',
            [
                'label'     => __( 'Text Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .jr-add-to-cart-wrapper .single_add_to_cart_button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'cart_bg',
            [
                'label'     => __( 'Background', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#1f6feb',
                'selectors' => [
                    '{{WRAPPER}} .jr-add-to-cart-wrapper .single_add_to_cart_button' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'cart_hover_color',
            [
                'label'     => __( 'Hover Text Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .jr-add-to-cart-wrapper .single_add_to_cart_button:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'cart_hover_bg',
            [
                'label'     => __( 'Hover Background', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#1652c1',
                'selectors' => [
                    '{{WRAPPER}} .jr-add-to-cart-wrapper .single_add_to_cart_button:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'cart_radius',
            [
                'label'      => __( 'Border Radius', 'jr-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'default'    => [ 'top' => 6, 'right' => 6, 'bottom' => 6, 'left' => 6, 'isLinked' => true ],
                'selectors'  => [
                    '{{WRAPPER}} .jr-add-to-cart-wrapper .single_add_to_cart_button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'cart_padding',
            [
                'label'      => __( 'Padding', 'jr-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'default'    => [ 'top' => 14, 'right' => 30, 'bottom' => 14, 'left' => 30, 'isLinked' => false ],
                'selectors'  => [
                    '{{WRAPPER}} .jr-add-to-cart-wrapper .single_add_to_cart_button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();


        /* ---------------- BUY NOW STYLE ---------------- */
        $this->start_controls_section(
            'buy_btn_style',
            [
                'label'     => __( 'Buy Now Button', 'jr-addons' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [ 'show_buy_now' => 'yes' ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'buy_typo',
                'selector' => '{{WRAPPER}} .jr-buy-now',
            ]
        );

        $this->add_control(
            'buy_text_color',
            [
                'label'     => __( 'Text Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .jr-buy-now' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'buy_bg',
            [
                'label'     => __( 'Background', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#5fa823',
                'selectors' => [
                    '{{WRAPPER}} .jr-buy-now' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'buy_hover_color',
            [
                'label'     => __( 'Hover Text Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .jr-buy-now:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'buy_hover_bg',
            [
                'label'     => __( 'Hover Background', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#4a861b',
                'selectors' => [
                    '{{WRAPPER}} .jr-buy-now:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'buy_radius',
            [
                'label'      => __( 'Border Radius', 'jr-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'default'    => [ 'top' => 6, 'right' => 6, 'bottom' => 6, 'left' => 6, 'isLinked' => true ],
                'selectors'  => [
                    '{{WRAPPER}} .jr-buy-now' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'buy_padding',
            [
                'label'      => __( 'Padding', 'jr-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'default'    => [ 'top' => 14, 'right' => 30, 'bottom' => 14, 'left' => 30, 'isLinked' => false ],
                'selectors'  => [
                    '{{WRAPPER}} .jr-buy-now' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        global $product, $post;

        $settings    = $this->get_settings_for_display();
        $old_product = $product;
        $old_post    = $post;

        // Frontend product context
        if ( ! $product instanceof \WC_Product ) {
            $current_id = get_the_ID();
            if ( $current_id && 'product' === get_post_type( $current_id ) ) {
                $product = wc_get_product( $current_id );
            }
        }

        // Editor preview fallback
        if ( ! $product instanceof \WC_Product && \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
            $products = get_posts( [
                'post_type'      => 'product',
                'posts_per_page' => 1,
                'post_status'    => 'publish',
                'fields'         => 'ids',
            ] );
            if ( ! empty( $products ) ) {
                $product = wc_get_product( $products[0] );
            }
        }

        if ( ! $product instanceof \WC_Product ) {
            if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
                echo '<div class="elementor-alert elementor-alert-warning">' . esc_html__( 'No product found.', 'jr-addons' ) . '</div>';
            }
            return;
        }

        $post = get_post( $product->get_id() );
        setup_postdata( $post );
        wc_setup_product_data( $post );

        $hide_qty = ( 'yes' !== $settings['show_quantity'] ) ? 'jr-hide-qty' : '';
        $buy_now  = ( 'yes' === $settings['show_buy_now'] );
        $buy_text = ! empty( $settings['buy_now_text'] ) ? $settings['buy_now_text'] : __( 'Buy Now', 'jr-addons' );
        ?>

        <div class="jr-add-to-cart-wrapper <?php echo esc_attr( $hide_qty ); ?>"
            data-buy-now="<?php echo $buy_now ? '1' : '0'; ?>"
            data-buy-text="<?php echo esc_attr( $buy_text ); ?>">

            <?php woocommerce_template_single_add_to_cart(); ?>

        </div>

        <?php
        wp_reset_postdata();
        $post    = $old_post;
        $product = $old_product;
    }
}