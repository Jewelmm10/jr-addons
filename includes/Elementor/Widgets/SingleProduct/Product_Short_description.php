<?php
namespace JR_Addons\Elementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;

if ( ! defined( 'ABSPATH' ) ) exit;

class Product_Short_description extends Widget_Base {

    public function get_name() {
        return 'jr-product-short-description';
    }

    public function get_title() {
        return __( 'Short Description', 'jr-addons' );
    }

    public function get_icon() {
        return 'jr-get-icon';
    }

    public function get_categories() {
        return [ 'jr-wc' ];
    }

    public function get_keywords() {
        return [ 'short', 'description', 'excerpt', 'product', 'woocommerce', 'summary' ];
    }

    public function get_style_depends() {
        return [ 'product-short-description' ];
    }

    public function get_script_depends() {
        return [ 'product-short-description' ];
    }

    /**
     * Register Controls
     */
    protected function register_controls() {

        /* ===========================
         * SECTION: Content Settings
         * =========================== */
        $this->start_controls_section(
            'section_content',
            [
                'label' => __( 'Content', 'jr-addons' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_title',
            [
                'label'        => __( 'Show Title', 'jr-addons' ),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => '',
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'title_text',
            [
                'label'     => __( 'Title Text', 'jr-addons' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => __( 'Product Description', 'jr-addons' ),
                'condition' => [ 'show_title' => 'yes' ],
            ]
        );

        $this->add_control(
            'title_tag',
            [
                'label'     => __( 'Title Tag', 'jr-addons' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'h3',
                'options'   => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                    'div' => 'div',
                    'p'  => 'p',
                ],
                'condition' => [ 'show_title' => 'yes' ],
            ]
        );

        $this->add_control(
            'description_source',
            [
                'label'   => __( 'Source', 'jr-addons' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'short',
                'options' => [
                    'short'    => __( 'Short Description (Excerpt)', 'jr-addons' ),
                    'long'     => __( 'Long Description (Content)', 'jr-addons' ),
                    'auto'     => __( 'Auto (Short → Long fallback)', 'jr-addons' ),
                ],
            ]
        );

        $this->add_control(
            'enable_word_limit',
            [
                'label'        => __( 'Enable Word Limit', 'jr-addons' ),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => '',
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'word_limit',
            [
                'label'     => __( 'Word Limit', 'jr-addons' ),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 30,
                'min'       => 5,
                'max'       => 200,
                'condition' => [ 'enable_word_limit' => 'yes' ],
            ]
        );

        $this->add_control(
            'show_read_more',
            [
                'label'        => __( 'Show "Read More" Toggle', 'jr-addons' ),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => 'yes',
                'return_value' => 'yes',
                'condition'    => [ 'enable_word_limit' => 'yes' ],
            ]
        );

        $this->add_control(
            'read_more_text',
            [
                'label'     => __( '"Read More" Text', 'jr-addons' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => __( 'Read More', 'jr-addons' ),
                'condition' => [ 
                    'enable_word_limit' => 'yes',
                    'show_read_more'    => 'yes',
                ],
            ]
        );

        $this->add_control(
            'read_less_text',
            [
                'label'     => __( '"Read Less" Text', 'jr-addons' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => __( 'Read Less', 'jr-addons' ),
                'condition' => [ 
                    'enable_word_limit' => 'yes',
                    'show_read_more'    => 'yes',
                ],
            ]
        );

        $this->add_control(
            'show_separator',
            [
                'label'        => __( 'Show Top Separator Line', 'jr-addons' ),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => '',
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'show_bottom_separator',
            [
                'label'        => __( 'Show Bottom Separator Line', 'jr-addons' ),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => '',
                'return_value' => 'yes',
            ]
        );

        $this->add_responsive_control(
            'text_alignment',
            [
                'label'   => __( 'Alignment', 'jr-addons' ),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'left'    => [ 'title' => __( 'Left', 'jr-addons' ), 'icon' => 'eicon-text-align-left' ],
                    'center'  => [ 'title' => __( 'Center', 'jr-addons' ), 'icon' => 'eicon-text-align-center' ],
                    'right'   => [ 'title' => __( 'Right', 'jr-addons' ), 'icon' => 'eicon-text-align-right' ],
                    'justify' => [ 'title' => __( 'Justify', 'jr-addons' ), 'icon' => 'eicon-text-align-justify' ],
                ],
                'default'   => 'left',
                'selectors' => [
                    '{{WRAPPER}} .jr-short-desc-wrap' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        /* ===========================
         * STYLE: Wrapper
         * =========================== */
        $this->start_controls_section(
            'style_wrapper',
            [
                'label' => __( 'Wrapper', 'jr-addons' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'wrapper_bg',
                'label'    => __( 'Background', 'jr-addons' ),
                'types'    => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .jr-short-desc-wrap',
            ]
        );

        $this->add_responsive_control(
            'wrapper_padding',
            [
                'label'      => __( 'Padding', 'jr-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em' ],
                'selectors'  => [
                    '{{WRAPPER}} .jr-short-desc-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'wrapper_margin',
            [
                'label'      => __( 'Margin', 'jr-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em' ],
                'selectors'  => [
                    '{{WRAPPER}} .jr-short-desc-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'wrapper_radius',
            [
                'label'      => __( 'Border Radius', 'jr-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors'  => [
                    '{{WRAPPER}} .jr-short-desc-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'wrapper_border',
                'selector' => '{{WRAPPER}} .jr-short-desc-wrap',
            ]
        );

        $this->end_controls_section();

        /* ===========================
         * STYLE: Title
         * =========================== */
        $this->start_controls_section(
            'style_title',
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
                'default'   => '#1a1a1a',
                'selectors' => [ '{{WRAPPER}} .jr-short-desc-title' => 'color: {{VALUE}};' ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'           => 'title_typography',
                'selector'       => '{{WRAPPER}} .jr-short-desc-title',
                'fields_options' => [
                    'font_size'   => [ 'default' => [ 'unit' => 'px', 'size' => 18 ] ],
                    'font_weight' => [ 'default' => '700' ],
                ],
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label'      => __( 'Margin', 'jr-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'default'    => [ 'top' => 0, 'right' => 0, 'bottom' => 12, 'left' => 0, 'unit' => 'px' ],
                'selectors'  => [
                    '{{WRAPPER}} .jr-short-desc-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'title_underline',
            [
                'label'        => __( 'Show Underline', 'jr-addons' ),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => '',
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'title_underline_color',
            [
                'label'     => __( 'Underline Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#FF8C00',
                'selectors' => [ '{{WRAPPER}} .jr-short-desc-title.has-underline::after' => 'background-color: {{VALUE}};' ],
                'condition' => [ 'title_underline' => 'yes' ],
            ]
        );

        $this->add_control(
            'title_underline_width',
            [
                'label'      => __( 'Underline Width', 'jr-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range'      => [
                    'px' => [ 'min' => 20, 'max' => 300 ],
                    '%'  => [ 'min' => 10, 'max' => 100 ],
                ],
                'default'    => [ 'unit' => 'px', 'size' => 50 ],
                'selectors'  => [ '{{WRAPPER}} .jr-short-desc-title.has-underline::after' => 'width: {{SIZE}}{{UNIT}};' ],
                'condition'  => [ 'title_underline' => 'yes' ],
            ]
        );

        $this->end_controls_section();

        /* ===========================
         * STYLE: Description Text
         * =========================== */
        $this->start_controls_section(
            'style_description',
            [
                'label' => __( 'Description Text', 'jr-addons' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'desc_color',
            [
                'label'     => __( 'Text Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#444444',
                'selectors' => [ 
                    '{{WRAPPER}} .jr-short-desc-content'   => 'color: {{VALUE}};',
                    '{{WRAPPER}} .jr-short-desc-content p' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'           => 'desc_typography',
                'selector'       => '{{WRAPPER}} .jr-short-desc-content, {{WRAPPER}} .jr-short-desc-content p',
                'fields_options' => [
                    'font_size'   => [ 'default' => [ 'unit' => 'px', 'size' => 15 ] ],
                    'line_height' => [ 'default' => [ 'unit' => 'em', 'size' => 1.7 ] ],
                ],
            ]
        );

        $this->add_control(
            'list_marker_color',
            [
                'label'     => __( 'List Marker Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#FF8C00',
                'selectors' => [ '{{WRAPPER}} .jr-short-desc-content ul li::marker, {{WRAPPER}} .jr-short-desc-content ol li::marker' => 'color: {{VALUE}};' ],
            ]
        );

        $this->add_control(
            'link_color',
            [
                'label'     => __( 'Link Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#FF8C00',
                'selectors' => [ '{{WRAPPER}} .jr-short-desc-content a' => 'color: {{VALUE}};' ],
            ]
        );

        $this->end_controls_section();

        /* ===========================
         * STYLE: Read More Button
         * =========================== */
        $this->start_controls_section(
            'style_read_more',
            [
                'label'     => __( 'Read More Button', 'jr-addons' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [ 
                    'enable_word_limit' => 'yes',
                    'show_read_more'    => 'yes',
                ],
            ]
        );

        $this->start_controls_tabs( 'read_more_tabs' );

        $this->start_controls_tab( 'rm_normal', [ 'label' => __( 'Normal', 'jr-addons' ) ] );

        $this->add_control(
            'rm_color',
            [
                'label'     => __( 'Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#FF8C00',
                'selectors' => [ '{{WRAPPER}} .jr-read-more-btn' => 'color: {{VALUE}};' ],
            ]
        );

        $this->add_control(
            'rm_bg',
            [
                'label'     => __( 'Background', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => 'transparent',
                'selectors' => [ '{{WRAPPER}} .jr-read-more-btn' => 'background-color: {{VALUE}};' ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab( 'rm_hover', [ 'label' => __( 'Hover', 'jr-addons' ) ] );

        $this->add_control(
            'rm_color_hover',
            [
                'label'     => __( 'Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#fff',
                'selectors' => [ '{{WRAPPER}} .jr-read-more-btn:hover' => 'color: {{VALUE}};' ],
            ]
        );

        $this->add_control(
            'rm_bg_hover',
            [
                'label'     => __( 'Background', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#FF8C00',
                'selectors' => [ '{{WRAPPER}} .jr-read-more-btn:hover' => 'background-color: {{VALUE}};' ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'rm_typography',
                'selector' => '{{WRAPPER}} .jr-read-more-btn',
            ]
        );

        $this->add_responsive_control(
            'rm_padding',
            [
                'label'      => __( 'Padding', 'jr-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'default'    => [ 'top' => 6, 'right' => 14, 'bottom' => 6, 'left' => 14, 'unit' => 'px' ],
                'selectors'  => [
                    '{{WRAPPER}} .jr-read-more-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'rm_radius',
            [
                'label'      => __( 'Border Radius', 'jr-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'default'    => [ 'top' => 4, 'right' => 4, 'bottom' => 4, 'left' => 4, 'unit' => 'px' ],
                'selectors'  => [
                    '{{WRAPPER}} .jr-read-more-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'rm_border',
                'selector' => '{{WRAPPER}} .jr-read-more-btn',
            ]
        );

        $this->end_controls_section();

        /* ===========================
         * STYLE: Separator Lines
         * =========================== */
        $this->start_controls_section(
            'style_separator',
            [
                'label' => __( 'Separator Lines', 'jr-addons' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'separator_color',
            [
                'label'     => __( 'Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ececec',
                'selectors' => [
                    '{{WRAPPER}} .jr-short-desc-separator' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'separator_height',
            [
                'label'     => __( 'Height', 'jr-addons' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [ 'px' => [ 'min' => 1, 'max' => 10 ] ],
                'default'   => [ 'unit' => 'px', 'size' => 1 ],
                'selectors' => [
                    '{{WRAPPER}} .jr-short-desc-separator' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'separator_margin',
            [
                'label'      => __( 'Margin (Top & Bottom)', 'jr-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 15 ],
                'selectors'  => [
                    '{{WRAPPER}} .jr-short-desc-separator' => 'margin-top: {{SIZE}}{{UNIT}}; margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Limit content by word count, preserving HTML structure
     */
    private function jr_limit_words( $content, $limit ) {
        $stripped = wp_strip_all_tags( $content );
        $words    = preg_split( '/\s+/', $stripped );
        
        if ( count( $words ) <= $limit ) {
            return [ 'short' => $content, 'is_limited' => false ];
        }

        $short = implode( ' ', array_slice( $words, 0, $limit ) ) . '...';
        return [ 'short' => wpautop( $short ), 'is_limited' => true ];
    }

    /**
     * Get preview product
     */
    private function jr_get_preview_product() {
        if ( ! function_exists( 'wc_get_products' ) ) return false;
        $products = wc_get_products( [ 'limit' => 1, 'status' => 'publish' ] );
        return ! empty( $products ) ? $products[0] : false;
    }

    /**
     * Render
     */
    protected function render() {
        $settings = $this->get_settings_for_display();

        global $product;
        $is_edit_mode = \Elementor\Plugin::$instance->editor->is_edit_mode();

        if ( ! $product && function_exists( 'wc_get_product' ) ) {
            $product = wc_get_product( get_the_ID() );
        }

        if ( ! $product && $is_edit_mode ) {
            $product = $this->jr_get_preview_product();
        }

        if ( ! $product ) {
            if ( $is_edit_mode ) {
                echo '<div style="padding:20px; background:#fff3cd; border:1px dashed #ffc107; text-align:center; border-radius:6px;">⚠️ Product পাওয়া যায়নি।</div>';
            }
            return;
        }

        // ===== Get Description =====
        $short_desc = $product->get_short_description();
        $long_desc  = $product->get_description();

        switch ( $settings['description_source'] ) {
            case 'long':
                $description = $long_desc;
                break;
            case 'auto':
                $description = ! empty( $short_desc ) ? $short_desc : $long_desc;
                break;
            case 'short':
            default:
                $description = $short_desc;
                break;
        }

        if ( empty( trim( wp_strip_all_tags( $description ) ) ) ) {
            if ( $is_edit_mode ) {
                echo '<div style="padding:20px; background:#fff3cd; border:1px dashed #ffc107; text-align:center; border-radius:6px;">⚠️ এই product এর কোনো description নেই।</div>';
            }
            return;
        }

        // ===== Apply WooCommerce filters =====
        $description = apply_filters( 'woocommerce_short_description', $description );

        // ===== Word Limit =====
        $is_limited = false;
        $full_html  = $description;
        $short_html = $description;

        if ( $settings['enable_word_limit'] === 'yes' ) {
            $limit_data = $this->jr_limit_words( $description, (int) $settings['word_limit'] );
            $short_html = $limit_data['short'];
            $is_limited = $limit_data['is_limited'];
        }

        $tag = in_array( $settings['title_tag'], [ 'h1','h2','h3','h4','h5','h6','div','p' ], true ) ? $settings['title_tag'] : 'h3';
        $title_class = 'jr-short-desc-title' . ( $settings['title_underline'] === 'yes' ? ' has-underline' : '' );
        ?>

        <div class="jr-short-desc-wrap">

            <?php if ( $settings['show_separator'] === 'yes' ) : ?>
                <div class="jr-short-desc-separator"></div>
            <?php endif; ?>

            <?php if ( $settings['show_title'] === 'yes' && ! empty( $settings['title_text'] ) ) : ?>
                <<?php echo esc_attr( $tag ); ?> class="<?php echo esc_attr( $title_class ); ?>">
                    <?php echo esc_html( $settings['title_text'] ); ?>
                </<?php echo esc_attr( $tag ); ?>>
            <?php endif; ?>

            <div class="jr-short-desc-content"
                 data-short="<?php echo esc_attr( $short_html ); ?>"
                 data-full="<?php echo esc_attr( $full_html ); ?>">
                <?php echo wp_kses_post( $is_limited ? $short_html : $full_html ); ?>
            </div>

            <?php if ( $is_limited && $settings['show_read_more'] === 'yes' ) : ?>
                <button type="button" class="jr-read-more-btn"
                        data-more="<?php echo esc_attr( $settings['read_more_text'] ); ?>"
                        data-less="<?php echo esc_attr( $settings['read_less_text'] ); ?>">
                    <span class="jr-rm-text"><?php echo esc_html( $settings['read_more_text'] ); ?></span>
                    <svg class="jr-rm-icon" width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M7.41 8.59L12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"/>
                    </svg>
                </button>
            <?php endif; ?>

            <?php if ( $settings['show_bottom_separator'] === 'yes' ) : ?>
                <div class="jr-short-desc-separator"></div>
            <?php endif; ?>

        </div>
        <?php
    }
}