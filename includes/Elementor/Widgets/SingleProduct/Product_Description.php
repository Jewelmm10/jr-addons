<?php
namespace JR_Addons\Elementor\Widgets\SingleProduct;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;

if ( ! defined( 'ABSPATH' ) ) exit;

class Product_Description extends Widget_Base {

    public function get_name() {
        return 'jr-product-description';
    }

    public function get_title() {
        return __( 'Product Description', 'jr-addons' );
    }

    public function get_icon() {
        return 'jr-get-icon';
    }

    public function get_categories() {
        return [ 'jr-wc' ];
    }

    public function get_keywords() {
        return [ 'product', 'description', 'woocommerce', 'content', 'jr' ];
    }

    protected function register_controls() {

        /* =========================================================
         *  CONTENT TAB
         * ========================================================= */
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Content', 'jr-addons' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'description_type',
            [
                'label'   => __( 'Description Type', 'jr-addons' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'full',
                'options' => [
                    'full'  => __( 'Full Description', 'jr-addons' ),
                    'short' => __( 'Short Description', 'jr-addons' ),
                ],
            ]
        );

        $this->add_control(
            'show_title',
            [
                'label'        => __( 'Show Title', 'jr-addons' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Show', 'jr-addons' ),
                'label_off'    => __( 'Hide', 'jr-addons' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'title_text',
            [
                'label'     => __( 'Title Text', 'jr-addons' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => __( 'Description', 'jr-addons' ),
                'condition' => [ 'show_title' => 'yes' ],
            ]
        );

        $this->add_control(
            'title_tag',
            [
                'label'   => __( 'Title HTML Tag', 'jr-addons' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'h3',
                'options' => [
                    'h1' => 'H1', 'h2' => 'H2', 'h3' => 'H3',
                    'h4' => 'H4', 'h5' => 'H5', 'h6' => 'H6',
                    'div' => 'div', 'p' => 'p',
                ],
                'condition' => [ 'show_title' => 'yes' ],
            ]
        );

        $this->add_control(
            'enable_readmore',
            [
                'label'        => __( 'Enable Read More', 'jr-addons' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Yes', 'jr-addons' ),
                'label_off'    => __( 'No', 'jr-addons' ),
                'return_value' => 'yes',
                'default'      => '',
            ]
        );

        $this->add_control(
            'readmore_height',
            [
                'label'      => __( 'Collapsed Height', 'jr-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [ 'px' => [ 'min' => 50, 'max' => 800 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 150 ],
                'selectors'  => [
                    '{{WRAPPER}} .jr-desc-content.jr-collapsed' => 'max-height: {{SIZE}}{{UNIT}};',
                ],
                'condition'  => [ 'enable_readmore' => 'yes' ],
            ]
        );

        $this->add_control(
            'readmore_text',
            [
                'label'     => __( 'Read More Text', 'jr-addons' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => __( 'Read More', 'jr-addons' ),
                'condition' => [ 'enable_readmore' => 'yes' ],
            ]
        );

        $this->add_control(
            'readless_text',
            [
                'label'     => __( 'Read Less Text', 'jr-addons' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => __( 'Read Less', 'jr-addons' ),
                'condition' => [ 'enable_readmore' => 'yes' ],
            ]
        );

        $this->end_controls_section();


        /* =========================================================
         *  STYLE TAB — WRAPPER
         * ========================================================= */
        $this->start_controls_section(
            'wrapper_style',
            [
                'label' => __( 'Wrapper', 'jr-addons' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'wrapper_align',
            [
                'label'   => __( 'Alignment', 'jr-addons' ),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'left'    => [ 'title' => __( 'Left', 'jr-addons' ),    'icon' => 'eicon-text-align-left' ],
                    'center'  => [ 'title' => __( 'Center', 'jr-addons' ),  'icon' => 'eicon-text-align-center' ],
                    'right'   => [ 'title' => __( 'Right', 'jr-addons' ),   'icon' => 'eicon-text-align-right' ],
                    'justify' => [ 'title' => __( 'Justify', 'jr-addons' ), 'icon' => 'eicon-text-align-justify' ],
                ],
                'default'   => 'left',
                'selectors' => [
                    '{{WRAPPER}} .jr-product-description' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'wrapper_bg',
                'types'    => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .jr-product-description',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'wrapper_border',
                'selector' => '{{WRAPPER}} .jr-product-description',
            ]
        );

        $this->add_control(
            'wrapper_radius',
            [
                'label'      => __( 'Border Radius', 'jr-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .jr-product-description' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'wrapper_shadow',
                'selector' => '{{WRAPPER}} .jr-product-description',
            ]
        );

        $this->add_responsive_control(
            'wrapper_padding',
            [
                'label'      => __( 'Padding', 'jr-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .jr-product-description' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'wrapper_margin',
            [
                'label'      => __( 'Margin', 'jr-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .jr-product-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();


        /* =========================================================
         *  STYLE TAB — TITLE
         * ========================================================= */
        $this->start_controls_section(
            'title_style',
            [
                'label'     => __( 'Title', 'jr-addons' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [ 'show_title' => 'yes' ],
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => __( 'Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#222222',
                'selectors' => [
                    '{{WRAPPER}} .jr-desc-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typo',
                'selector' => '{{WRAPPER}} .jr-desc-title',
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label'      => __( 'Margin', 'jr-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em' ],
                'default'    => [ 'top' => 0, 'right' => 0, 'bottom' => 15, 'left' => 0, 'isLinked' => false ],
                'selectors'  => [
                    '{{WRAPPER}} .jr-desc-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'title_divider',
            [
                'label'        => __( 'Show Bottom Divider', 'jr-addons' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Yes', 'jr-addons' ),
                'label_off'    => __( 'No', 'jr-addons' ),
                'return_value' => 'yes',
                'default'      => '',
            ]
        );

        $this->add_control(
            'divider_color',
            [
                'label'     => __( 'Divider Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#e63946',
                'selectors' => [
                    '{{WRAPPER}} .jr-desc-title.jr-has-divider::after' => 'background-color: {{VALUE}};',
                ],
                'condition' => [ 'title_divider' => 'yes' ],
            ]
        );

        $this->add_control(
            'divider_width',
            [
                'label'      => __( 'Divider Width', 'jr-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range'      => [ 'px' => [ 'min' => 10, 'max' => 300 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 50 ],
                'selectors'  => [
                    '{{WRAPPER}} .jr-desc-title.jr-has-divider::after' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition'  => [ 'title_divider' => 'yes' ],
            ]
        );

        $this->add_control(
            'divider_height',
            [
                'label'      => __( 'Divider Height', 'jr-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [ 'px' => [ 'min' => 1, 'max' => 20 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 3 ],
                'selectors'  => [
                    '{{WRAPPER}} .jr-desc-title.jr-has-divider::after' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'condition'  => [ 'title_divider' => 'yes' ],
            ]
        );

        $this->end_controls_section();


        /* =========================================================
         *  STYLE TAB — CONTENT
         * ========================================================= */
        $this->start_controls_section(
            'content_style',
            [
                'label' => __( 'Content', 'jr-addons' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'content_color',
            [
                'label'     => __( 'Text Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#555555',
                'selectors' => [
                    '{{WRAPPER}} .jr-desc-content, {{WRAPPER}} .jr-desc-content p, {{WRAPPER}} .jr-desc-content li' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'content_typo',
                'selector' => '{{WRAPPER}} .jr-desc-content, {{WRAPPER}} .jr-desc-content p, {{WRAPPER}} .jr-desc-content li',
            ]
        );

        $this->add_control(
            'heading_color',
            [
                'label'     => __( 'Inner Heading Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .jr-desc-content h1,
                     {{WRAPPER}} .jr-desc-content h2,
                     {{WRAPPER}} .jr-desc-content h3,
                     {{WRAPPER}} .jr-desc-content h4,
                     {{WRAPPER}} .jr-desc-content h5,
                     {{WRAPPER}} .jr-desc-content h6' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'link_color',
            [
                'label'     => __( 'Link Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .jr-desc-content a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'link_hover_color',
            [
                'label'     => __( 'Link Hover Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .jr-desc-content a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'list_indent',
            [
                'label'      => __( 'List Indent', 'jr-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em' ],
                'range'      => [ 'px' => [ 'min' => 0, 'max' => 80 ] ],
                'selectors'  => [
                    '{{WRAPPER}} .jr-desc-content ul, {{WRAPPER}} .jr-desc-content ol' => 'padding-inline-start: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'image_radius',
            [
                'label'      => __( 'Image Border Radius', 'jr-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .jr-desc-content img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();


        /* =========================================================
         *  STYLE TAB — READ MORE BUTTON
         * ========================================================= */
        $this->start_controls_section(
            'readmore_style',
            [
                'label'     => __( 'Read More Button', 'jr-addons' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [ 'enable_readmore' => 'yes' ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'readmore_typo',
                'selector' => '{{WRAPPER}} .jr-readmore-btn',
            ]
        );

        $this->start_controls_tabs( 'readmore_tabs' );

        /* Normal */
        $this->start_controls_tab( 'readmore_normal', [ 'label' => __( 'Normal', 'jr-addons' ) ] );

        $this->add_control(
            'readmore_color',
            [
                'label'     => __( 'Text Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .jr-readmore-btn' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'readmore_bg',
            [
                'label'     => __( 'Background', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#1f6feb',
                'selectors' => [
                    '{{WRAPPER}} .jr-readmore-btn' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        /* Hover */
        $this->start_controls_tab( 'readmore_hover', [ 'label' => __( 'Hover', 'jr-addons' ) ] );

        $this->add_control(
            'readmore_hover_color',
            [
                'label'     => __( 'Text Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .jr-readmore-btn:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'readmore_hover_bg',
            [
                'label'     => __( 'Background', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#1652c1',
                'selectors' => [
                    '{{WRAPPER}} .jr-readmore-btn:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'readmore_border',
                'selector' => '{{WRAPPER}} .jr-readmore-btn',
            ]
        );

        $this->add_control(
            'readmore_radius',
            [
                'label'      => __( 'Border Radius', 'jr-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'default'    => [ 'top' => 6, 'right' => 6, 'bottom' => 6, 'left' => 6, 'isLinked' => true ],
                'selectors'  => [
                    '{{WRAPPER}} .jr-readmore-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'readmore_padding',
            [
                'label'      => __( 'Padding', 'jr-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em' ],
                'default'    => [ 'top' => 10, 'right' => 24, 'bottom' => 10, 'left' => 24, 'isLinked' => false ],
                'selectors'  => [
                    '{{WRAPPER}} .jr-readmore-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'readmore_margin',
            [
                'label'      => __( 'Margin Top', 'jr-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [ 'px' => [ 'min' => 0, 'max' => 100 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 15 ],
                'selectors'  => [
                    '{{WRAPPER}} .jr-readmore-btn' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'fade_color',
            [
                'label'     => __( 'Fade Overlay Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .jr-desc-content.jr-collapsed::after' => 'background: linear-gradient(to bottom, transparent, {{VALUE}});',
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

        // Get raw description
        if ( 'short' === $settings['description_type'] ) {
            $description = $product->get_short_description();
        } else {
            $description = $product->get_description();
        }

        // ⭐ SAFE FILTERS ONLY - prevents WooCommerce/theme injection
        $description = wpautop( $description );
        $description = shortcode_unautop( $description );
        $description = do_shortcode( $description );
        $description = convert_smilies( $description );

        if ( empty( trim( wp_strip_all_tags( $description ) ) ) ) {
            if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
                echo '<div class="elementor-alert elementor-alert-info">' . esc_html__( 'No description found for this product.', 'jr-addons' ) . '</div>';
            }
            wp_reset_postdata();
            $post    = $old_post;
            $product = $old_product;
            return;
        }

        $readmore_enabled = ( 'yes' === $settings['enable_readmore'] );
        $unique_id        = 'jr-desc-' . $this->get_id();

        $title_classes = 'jr-desc-title';
        if ( 'yes' === $settings['title_divider'] ) {
            $title_classes .= ' jr-has-divider';
        }
        ?>

        <div class="jr-product-description" id="<?php echo esc_attr( $unique_id ); ?>">

            <?php if ( 'yes' === $settings['show_title'] && ! empty( $settings['title_text'] ) ) :
                $tag = ! empty( $settings['title_tag'] ) ? $settings['title_tag'] : 'h3';
                ?>
                <<?php echo esc_attr( $tag ); ?> class="<?php echo esc_attr( $title_classes ); ?>">
                    <?php echo esc_html( $settings['title_text'] ); ?>
                </<?php echo esc_attr( $tag ); ?>>
            <?php endif; ?>

            <div class="jr-desc-content <?php echo $readmore_enabled ? 'jr-collapsed jr-has-readmore' : ''; ?>">
                <?php echo wp_kses_post( $description ); ?>
            </div>

            <?php if ( $readmore_enabled ) : ?>
                <button type="button"
                        class="jr-readmore-btn"
                        data-target="<?php echo esc_attr( $unique_id ); ?>"
                        data-more="<?php echo esc_attr( $settings['readmore_text'] ); ?>"
                        data-less="<?php echo esc_attr( $settings['readless_text'] ); ?>">
                    <?php echo esc_html( $settings['readmore_text'] ); ?>
                </button>
            <?php endif; ?>
        </div>

        <?php
        wp_reset_postdata();
        $post    = $old_post;
        $product = $old_product;
    }
}