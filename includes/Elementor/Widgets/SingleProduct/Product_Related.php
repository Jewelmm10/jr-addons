<?php
namespace JR_Addons\Elementor\Widgets\SingleProduct;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;

if ( ! defined( 'ABSPATH' ) ) exit;

class Product_Related extends Widget_Base {

    public function get_name() {
        return 'jr-product-related';
    }

    public function get_title() {
        return __( 'Related Products', 'jr-addons' );
    }

    public function get_icon() {
        return 'jr-get-icon';
    }

    public function get_categories() {
        return [ 'jr-wc' ];
    }

    public function get_keywords() {
        return [ 'related', 'products', 'woocommerce', 'grid', 'list', 'jr' ];
    }

    protected function register_controls() {

        /* =========================================================
         *  CONTENT — GENERAL
         * ========================================================= */
        $this->start_controls_section(
            'general_section',
            [
                'label' => __( 'General', 'jr-addons' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'source',
            [
                'label'   => __( 'Source', 'jr-addons' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'related',
                'options' => [
                    'related'  => __( 'Related Products', 'jr-addons' ),
                    'upsell'   => __( 'Upsells', 'jr-addons' ),
                    'crosssell'=> __( 'Cross-sells', 'jr-addons' ),
                    'category' => __( 'Same Category', 'jr-addons' ),
                    'recent'   => __( 'Recent Products', 'jr-addons' ),
                    'best'     => __( 'Best Selling', 'jr-addons' ),
                    'featured' => __( 'Featured Products', 'jr-addons' ),
                ],
            ]
        );

        $this->add_control(
            'limit',
            [
                'label'   => __( 'Total Products', 'jr-addons' ),
                'type'    => Controls_Manager::NUMBER,
                'min'     => 1,
                'max'     => 50,
                'default' => 8,
            ]
        );

        $this->add_control(
            'orderby',
            [
                'label'   => __( 'Order By', 'jr-addons' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'rand',
                'options' => [
                    'rand'       => __( 'Random', 'jr-addons' ),
                    'date'       => __( 'Date', 'jr-addons' ),
                    'title'      => __( 'Title', 'jr-addons' ),
                    'price'      => __( 'Price', 'jr-addons' ),
                    'popularity' => __( 'Popularity', 'jr-addons' ),
                    'rating'     => __( 'Rating', 'jr-addons' ),
                ],
            ]
        );

        $this->add_control(
            'order',
            [
                'label'   => __( 'Order', 'jr-addons' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'desc',
                'options' => [
                    'asc'  => __( 'ASC', 'jr-addons' ),
                    'desc' => __( 'DESC', 'jr-addons' ),
                ],
            ]
        );

        $this->add_control(
            'show_section_title',
            [
                'label'        => __( 'Show Section Title', 'jr-addons' ),
                'type'         => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'section_title',
            [
                'label'     => __( 'Section Title', 'jr-addons' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => __( 'Related Products', 'jr-addons' ),
                'condition' => [ 'show_section_title' => 'yes' ],
            ]
        );

        $this->add_control(
            'section_title_tag',
            [
                'label'   => __( 'Title Tag', 'jr-addons' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'h3',
                'options' => [
                    'h1' => 'H1', 'h2' => 'H2', 'h3' => 'H3',
                    'h4' => 'H4', 'h5' => 'H5', 'h6' => 'H6',
                ],
                'condition' => [ 'show_section_title' => 'yes' ],
            ]
        );

        $this->end_controls_section();


        /* =========================================================
         *  CONTENT — LAYOUT
         * ========================================================= */
        $this->start_controls_section(
            'grid_section',
            [
                'label' => __( 'Layout Settings', 'jr-addons' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'layout_style',
            [
                'label'       => __( 'Layout Style', 'jr-addons' ),
                'type'        => Controls_Manager::SELECT,
                'default'     => 'grid',
                'options'     => [
                    'grid' => __( 'Grid (Multi Column)', 'jr-addons' ),
                    'list' => __( 'List (One Below Another)', 'jr-addons' ),
                ],
                'description' => __( 'Use "List" for sidebar/narrow areas.', 'jr-addons' ),
            ]
        );

        $this->add_responsive_control(
            'columns',
            [
                'label'           => __( 'Columns', 'jr-addons' ),
                'type'            => Controls_Manager::SELECT,
                'default'         => '4',
                'tablet_default'  => '3',
                'mobile_default'  => '2',
                'options'         => [
                    '1' => '1', '2' => '2', '3' => '3',
                    '4' => '4', '5' => '5', '6' => '6',
                ],
                'selectors' => [
                    '{{WRAPPER}} .jr-related-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
                ],
                'condition' => [ 'layout_style' => 'grid' ],
            ]
        );

        $this->end_controls_section();


        /* =========================================================
         *  CONTENT — CARD ELEMENTS
         * ========================================================= */
        $this->start_controls_section(
            'elements_section',
            [
                'label' => __( 'Card Elements', 'jr-addons' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control( 'show_image',       [ 'label' => __( 'Show Image',             'jr-addons' ), 'type' => Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ] );
        $this->add_control( 'show_sale_badge',  [ 'label' => __( 'Show Sale Badge',        'jr-addons' ), 'type' => Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ] );
        $this->add_control( 'show_discount',    [ 'label' => __( 'Show Discount % Badge',  'jr-addons' ), 'type' => Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ] );
        $this->add_control( 'show_category',    [ 'label' => __( 'Show Category',          'jr-addons' ), 'type' => Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ] );
        $this->add_control( 'show_title',       [ 'label' => __( 'Show Title',             'jr-addons' ), 'type' => Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ] );
        $this->add_control( 'show_rating',      [ 'label' => __( 'Show Rating',            'jr-addons' ), 'type' => Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ] );
        $this->add_control( 'show_short_desc',  [ 'label' => __( 'Show Short Description', 'jr-addons' ), 'type' => Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => '' ] );

        $this->add_control( 'short_desc_words', [
            'label'     => __( 'Description Words', 'jr-addons' ),
            'type'      => Controls_Manager::NUMBER,
            'default'   => 10,
            'min'       => 3,
            'max'       => 50,
            'condition' => [ 'show_short_desc' => 'yes' ],
        ] );

        $this->add_control( 'show_stock', [ 'label' => __( 'Show Stock Status', 'jr-addons' ), 'type' => Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ] );
        $this->add_control( 'show_price', [ 'label' => __( 'Show Price',        'jr-addons' ), 'type' => Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ] );
        $this->add_control( 'show_button', [ 'label' => __( 'Show Cart Icon Button', 'jr-addons' ), 'type' => Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ] );

        $this->end_controls_section();


        /* =========================================================
         *  STYLE — SECTION TITLE
         * ========================================================= */
        $this->start_controls_section(
            'section_title_style',
            [
                'label'     => __( 'Section Title', 'jr-addons' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [ 'show_section_title' => 'yes' ],
            ]
        );

        $this->add_control(
            'section_title_color',
            [
                'label'     => __( 'Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#222',
                'selectors' => [ '{{WRAPPER}} .jr-related-section-title' => 'color: {{VALUE}};' ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'section_title_typo',
                'selector' => '{{WRAPPER}} .jr-related-section-title',
            ]
        );

        $this->add_responsive_control(
            'section_title_align',
            [
                'label'   => __( 'Alignment', 'jr-addons' ),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'left'   => [ 'title' => 'Left',   'icon' => 'eicon-text-align-left' ],
                    'center' => [ 'title' => 'Center', 'icon' => 'eicon-text-align-center' ],
                    'right'  => [ 'title' => 'Right',  'icon' => 'eicon-text-align-right' ],
                ],
                'default'   => 'left',
                'selectors' => [ '{{WRAPPER}} .jr-related-section-title' => 'text-align: {{VALUE}};' ],
            ]
        );

        $this->add_responsive_control(
            'section_title_margin',
            [
                'label'      => __( 'Margin', 'jr-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em' ],
                'default'    => [ 'top' => 0, 'right' => 0, 'bottom' => 25, 'left' => 0, 'isLinked' => false ],
                'selectors'  => [
                    '{{WRAPPER}} .jr-related-section-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();


        /* =========================================================
         *  STYLE — CARD
         * ========================================================= */
        $this->start_controls_section(
            'card_style',
            [
                'label' => __( 'Card', 'jr-addons' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'card_gap',
            [
                'label'      => __( 'Gap Between Cards', 'jr-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 20 ],
                'selectors'  => [
                    '{{WRAPPER}} .jr-related-grid, {{WRAPPER}} .jr-related-list' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'card_bg',
                'types'    => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .jr-related-card',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'card_border',
                'selector' => '{{WRAPPER}} .jr-related-card',
            ]
        );

        $this->add_control(
            'card_radius',
            [
                'label'      => __( 'Border Radius', 'jr-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'default'    => [ 'top' => 8, 'right' => 8, 'bottom' => 8, 'left' => 8, 'isLinked' => true ],
                'selectors'  => [
                    '{{WRAPPER}} .jr-related-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'card_shadow',
                'selector' => '{{WRAPPER}} .jr-related-card',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'card_hover_shadow',
                'label'    => __( 'Hover Shadow', 'jr-addons' ),
                'selector' => '{{WRAPPER}} .jr-related-card:hover',
            ]
        );

        $this->add_responsive_control(
            'card_padding',
            [
                'label'      => __( 'Inner Padding', 'jr-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'default'    => [ 'top' => 12, 'right' => 12, 'bottom' => 0, 'left' => 12, 'isLinked' => false ],
                'selectors'  => [
                    '{{WRAPPER}} .jr-related-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();


        /* =========================================================
         *  STYLE — IMAGE
         * ========================================================= */
        $this->start_controls_section(
            'image_style',
            [
                'label'     => __( 'Image', 'jr-addons' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [ 'show_image' => 'yes' ],
            ]
        );

        $this->add_responsive_control(
            'image_height',
            [
                'label'      => __( 'Image Height', 'jr-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [ 'px' => [ 'min' => 100, 'max' => 600 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 200 ],
                'selectors'  => [ '{{WRAPPER}} .jr-card-img' => 'height: {{SIZE}}{{UNIT}};' ],
            ]
        );

        $this->add_control(
            'image_fit',
            [
                'label'   => __( 'Image Fit', 'jr-addons' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'cover',
                'options' => [
                    'cover'   => 'Cover',
                    'contain' => 'Contain',
                    'fill'    => 'Fill',
                ],
                'selectors' => [ '{{WRAPPER}} .jr-card-img img' => 'object-fit: {{VALUE}};' ],
            ]
        );

        $this->add_control(
            'image_zoom',
            [
                'label'        => __( 'Zoom On Hover', 'jr-addons' ),
                'type'         => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->end_controls_section();


        /* =========================================================
         *  STYLE — LIST LAYOUT
         * ========================================================= */
        $this->start_controls_section(
            'list_style',
            [
                'label'     => __( 'List Layout Settings', 'jr-addons' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [ 'layout_style' => 'list' ],
            ]
        );

        $this->add_responsive_control(
            'list_image_width',
            [
                'label'      => __( 'Image Width', 'jr-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [ 'px' => [ 'min' => 60, 'max' => 250 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 100 ],
                'selectors'  => [
                    '{{WRAPPER}} .jr-related-list .jr-card-img' => 'width: {{SIZE}}{{UNIT}}; flex: 0 0 {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'list_image_height',
            [
                'label'      => __( 'Image Height', 'jr-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [ 'px' => [ 'min' => 60, 'max' => 250 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 100 ],
                'selectors'  => [
                    '{{WRAPPER}} .jr-related-list .jr-card-img' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'list_content_gap',
            [
                'label'      => __( 'Image to Content Gap', 'jr-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [ 'px' => [ 'min' => 0, 'max' => 30 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 12 ],
                'selectors'  => [
                    '{{WRAPPER}} .jr-related-list .jr-related-card' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();


        /* =========================================================
         *  STYLE — SALE BADGE
         * ========================================================= */
        $this->start_controls_section(
            'badge_style',
            [
                'label'     => __( 'Sale Badge', 'jr-addons' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [ 'show_sale_badge' => 'yes' ],
            ]
        );

        $this->add_control(
            'badge_color',
            [
                'label'     => __( 'Text Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#fff',
                'selectors' => [ '{{WRAPPER}} .jr-badge-sale' => 'color: {{VALUE}};' ],
            ]
        );

        $this->add_control(
            'badge_bg',
            [
                'label'     => __( 'Background', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#e63946',
                'selectors' => [ '{{WRAPPER}} .jr-badge-sale' => 'background: {{VALUE}};' ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'badge_typo',
                'selector' => '{{WRAPPER}} .jr-card-badge',
            ]
        );

        $this->end_controls_section();


        /* =========================================================
         *  STYLE — DISCOUNT BADGE
         * ========================================================= */
        $this->start_controls_section(
            'discount_style',
            [
                'label'     => __( 'Discount Badge (%)', 'jr-addons' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [ 'show_discount' => 'yes' ],
            ]
        );

        $this->add_control(
            'discount_color',
            [
                'label'     => __( 'Text Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#fff',
                'selectors' => [ '{{WRAPPER}} .jr-badge-discount' => 'color: {{VALUE}};' ],
            ]
        );

        $this->add_control(
            'discount_bg',
            [
                'label'     => __( 'Background', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#28a745',
                'selectors' => [ '{{WRAPPER}} .jr-badge-discount' => 'background: {{VALUE}};' ],
            ]
        );

        $this->end_controls_section();


        /* =========================================================
         *  STYLE — TITLE
         * ========================================================= */
        $this->start_controls_section(
            'title_style',
            [
                'label'     => __( 'Product Title', 'jr-addons' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [ 'show_title' => 'yes' ],
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => __( 'Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#222',
                'selectors' => [ '{{WRAPPER}} .jr-card-title a' => 'color: {{VALUE}};' ],
            ]
        );

        $this->add_control(
            'title_hover_color',
            [
                'label'     => __( 'Hover Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#1f6feb',
                'selectors' => [ '{{WRAPPER}} .jr-card-title a:hover' => 'color: {{VALUE}};' ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typo',
                'selector' => '{{WRAPPER}} .jr-card-title a',
            ]
        );

        $this->end_controls_section();


        /* =========================================================
         *  STYLE — CATEGORY
         * ========================================================= */
        $this->start_controls_section(
            'category_style',
            [
                'label'     => __( 'Category', 'jr-addons' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [ 'show_category' => 'yes' ],
            ]
        );

        $this->add_control(
            'category_color',
            [
                'label'     => __( 'Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#888',
                'selectors' => [
                    '{{WRAPPER}} .jr-card-category, {{WRAPPER}} .jr-card-category a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'category_typo',
                'selector' => '{{WRAPPER}} .jr-card-category, {{WRAPPER}} .jr-card-category a',
            ]
        );

        $this->end_controls_section();


        /* =========================================================
         *  STYLE — RATING
         * ========================================================= */
        $this->start_controls_section(
            'rating_style',
            [
                'label'     => __( 'Rating', 'jr-addons' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [ 'show_rating' => 'yes' ],
            ]
        );

        $this->add_control(
            'rating_text_color',
            [
                'label'     => __( 'Number Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#222',
                'selectors' => [ '{{WRAPPER}} .jr-rating-num' => 'color: {{VALUE}};' ],
            ]
        );

        $this->add_control(
            'rating_star_color',
            [
                'label'     => __( 'Star Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#f6b800',
                'selectors' => [ '{{WRAPPER}} .jr-rating-star' => 'color: {{VALUE}};' ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'rating_typo',
                'selector' => '{{WRAPPER}} .jr-card-rating-inline',
            ]
        );

        $this->end_controls_section();


        /* =========================================================
         *  STYLE — SHORT DESCRIPTION
         * ========================================================= */
        $this->start_controls_section(
            'desc_style',
            [
                'label'     => __( 'Short Description', 'jr-addons' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [ 'show_short_desc' => 'yes' ],
            ]
        );

        $this->add_control(
            'desc_color',
            [
                'label'     => __( 'Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#666',
                'selectors' => [ '{{WRAPPER}} .jr-card-desc' => 'color: {{VALUE}};' ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'desc_typo',
                'selector' => '{{WRAPPER}} .jr-card-desc',
            ]
        );

        $this->end_controls_section();


        /* =========================================================
         *  STYLE — STOCK STATUS
         * ========================================================= */
        $this->start_controls_section(
            'stock_style',
            [
                'label'     => __( 'Stock Status', 'jr-addons' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [ 'show_stock' => 'yes' ],
            ]
        );

        $this->add_control(
            'stock_in_color',
            [
                'label'     => __( 'In Stock Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#28a745',
                'selectors' => [
                    '{{WRAPPER}} .jr-stock-in'              => 'color: {{VALUE}};',
                    '{{WRAPPER}} .jr-stock-in .jr-stock-dot' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'stock_low_color',
            [
                'label'     => __( 'Low Stock Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#f6b800',
                'selectors' => [
                    '{{WRAPPER}} .jr-stock-low'              => 'color: {{VALUE}};',
                    '{{WRAPPER}} .jr-stock-low .jr-stock-dot' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'stock_out_color',
            [
                'label'     => __( 'Out of Stock Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#e63946',
                'selectors' => [
                    '{{WRAPPER}} .jr-stock-out'              => 'color: {{VALUE}};',
                    '{{WRAPPER}} .jr-stock-out .jr-stock-dot' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'stock_typo',
                'selector' => '{{WRAPPER}} .jr-card-stock',
            ]
        );

        $this->end_controls_section();


        /* =========================================================
         *  STYLE — PRICE
         * ========================================================= */
        $this->start_controls_section(
            'price_style',
            [
                'label'     => __( 'Price', 'jr-addons' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [ 'show_price' => 'yes' ],
            ]
        );

        $this->add_control(
            'price_color',
            [
                'label'     => __( 'Sale Price Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#1f6feb',
                'selectors' => [
                    '{{WRAPPER}} .jr-card-price, {{WRAPPER}} .jr-card-price ins, {{WRAPPER}} .jr-card-price .amount' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'price_old_color',
            [
                'label'     => __( 'Old Price Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#999',
                'selectors' => [
                    '{{WRAPPER}} .jr-card-price del, {{WRAPPER}} .jr-card-price del .amount' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'price_typo',
                'selector' => '{{WRAPPER}} .jr-card-price, {{WRAPPER}} .jr-card-price .amount',
            ]
        );

        $this->end_controls_section();


        /* =========================================================
         *  STYLE — CART ICON BUTTON
         * ========================================================= */
        $this->start_controls_section(
            'button_style',
            [
                'label'     => __( 'Cart Icon Button', 'jr-addons' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [ 'show_button' => 'yes' ],
            ]
        );

        $this->add_control(
            'btn_icon_size',
            [
                'label'      => __( 'Icon Size', 'jr-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [ 'px' => [ 'min' => 14, 'max' => 40 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 20 ],
                'selectors'  => [
                    '{{WRAPPER}} .jr-card-btn-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'btn_tabs' );

        $this->start_controls_tab( 'btn_normal', [ 'label' => __( 'Normal', 'jr-addons' ) ] );

        $this->add_control(
            'btn_color',
            [
                'label'     => __( 'Icon Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#222',
                'selectors' => [ '{{WRAPPER}} .jr-card-btn-icon' => 'color: {{VALUE}};' ],
            ]
        );

        $this->add_control(
            'btn_bg',
            [
                'label'     => __( 'Background', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [ '{{WRAPPER}} .jr-card-btn-icon' => 'background: {{VALUE}};' ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab( 'btn_hover', [ 'label' => __( 'Hover', 'jr-addons' ) ] );

        $this->add_control(
            'btn_hover_color',
            [
                'label'     => __( 'Icon Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#1f6feb',
                'selectors' => [ '{{WRAPPER}} .jr-card-btn-icon:hover' => 'color: {{VALUE}};' ],
            ]
        );

        $this->add_control(
            'btn_hover_bg',
            [
                'label'     => __( 'Background', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [ '{{WRAPPER}} .jr-card-btn-icon:hover' => 'background: {{VALUE}};' ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();


        /* =========================================================
         *  STYLE — FOOTER (Price Bar)
         * ========================================================= */
        $this->start_controls_section(
            'footer_style',
            [
                'label' => __( 'Card Footer (Price Bar)', 'jr-addons' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'footer_divider_color',
            [
                'label'     => __( 'Top Divider Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#f0f0f0',
                'selectors' => [ '{{WRAPPER}} .jr-card-footer' => 'border-top-color: {{VALUE}};' ],
            ]
        );

        $this->add_responsive_control(
            'footer_padding',
            [
                'label'      => __( 'Padding', 'jr-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'default'    => [ 'top' => 12, 'right' => 0, 'bottom' => 12, 'left' => 0, 'isLinked' => false ],
                'selectors'  => [
                    '{{WRAPPER}} .jr-card-footer' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }


    /* =========================================================
     *  GET PRODUCTS
     * ========================================================= */
    private function get_products( $settings ) {
        $current_id = get_the_ID();
        $product    = wc_get_product( $current_id );

        if ( ! $product && \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
            $first = get_posts( [
                'post_type' => 'product', 'posts_per_page' => 1,
                'fields' => 'ids', 'post_status' => 'publish',
            ] );
            if ( ! empty( $first ) ) {
                $product    = wc_get_product( $first[0] );
                $current_id = $first[0];
            }
        }

        $limit   = ! empty( $settings['limit'] ) ? intval( $settings['limit'] ) : 8;
        $orderby = ! empty( $settings['orderby'] ) ? $settings['orderby'] : 'rand';
        $order   = ! empty( $settings['order'] ) ? $settings['order'] : 'desc';
        $source  = ! empty( $settings['source'] ) ? $settings['source'] : 'related';

        $ids = [];

        switch ( $source ) {

            case 'upsell':
                if ( $product ) $ids = $product->get_upsell_ids();
                break;

            case 'crosssell':
                if ( $product ) $ids = $product->get_cross_sell_ids();
                break;

            case 'category':
                if ( $product ) {
                    $cats = wp_get_post_terms( $product->get_id(), 'product_cat', [ 'fields' => 'ids' ] );
                    if ( ! empty( $cats ) ) {
                        $ids = get_posts( [
                            'post_type'      => 'product',
                            'posts_per_page' => $limit,
                            'post__not_in'   => [ $product->get_id() ],
                            'fields'         => 'ids',
                            'orderby'        => $orderby,
                            'order'          => $order,
                            'tax_query'      => [
                                [
                                    'taxonomy' => 'product_cat',
                                    'field'    => 'term_id',
                                    'terms'    => $cats,
                                ],
                            ],
                        ] );
                    }
                }
                break;

            case 'recent':
                $ids = get_posts( [
                    'post_type' => 'product', 'posts_per_page' => $limit,
                    'fields' => 'ids', 'orderby' => 'date', 'order' => 'DESC',
                ] );
                break;

            case 'best':
                $ids = get_posts( [
                    'post_type' => 'product', 'posts_per_page' => $limit,
                    'fields' => 'ids', 'meta_key' => 'total_sales',
                    'orderby' => 'meta_value_num', 'order' => 'DESC',
                ] );
                break;

            case 'featured':
                $ids = wc_get_featured_product_ids();
                break;

            case 'related':
            default:
                if ( $product ) $ids = wc_get_related_products( $product->get_id(), $limit );
                break;
        }

        if ( empty( $ids ) ) return [];

        return array_slice( array_filter( $ids ), 0, $limit );
    }


    /* =========================================================
     *  RENDER
     * ========================================================= */
    protected function render() {
        $settings = $this->get_settings_for_display();
        $ids      = $this->get_products( $settings );

        if ( empty( $ids ) ) {
            if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
                echo '<div class="elementor-alert elementor-alert-info">' . esc_html__( 'No products found.', 'jr-addons' ) . '</div>';
            }
            return;
        }

        $layout_style = ! empty( $settings['layout_style'] ) ? $settings['layout_style'] : 'grid';
        $wrap_class   = ( 'list' === $layout_style ) ? 'jr-related-list' : 'jr-related-grid';
        $zoom_cls     = ( 'yes' === $settings['image_zoom'] ) ? 'jr-zoom-on' : '';
        ?>

        <?php if ( 'yes' === $settings['show_section_title'] && ! empty( $settings['section_title'] ) ) :
            $tag = ! empty( $settings['section_title_tag'] ) ? $settings['section_title_tag'] : 'h3';
            ?>
            <<?php echo esc_attr( $tag ); ?> class="jr-related-section-title">
                <?php echo esc_html( $settings['section_title'] ); ?>
            </<?php echo esc_attr( $tag ); ?>>
        <?php endif; ?>

        <div class="jr-related-products jr-layout-<?php echo esc_attr( $layout_style ); ?> <?php echo esc_attr( $zoom_cls ); ?>">
            <div class="<?php echo esc_attr( $wrap_class ); ?>">
                <?php foreach ( $ids as $pid ) {
                    $this->render_card( $pid, $settings );
                } ?>
            </div>
        </div>

        <?php
    }


    /* =========================================================
     *  RENDER SINGLE CARD
     * ========================================================= */
    private function render_card( $pid, $settings ) {
        $p = wc_get_product( $pid );
        if ( ! $p ) return;

        $link  = get_permalink( $pid );
        $title = get_the_title( $pid );

        // Image
        $image_html = '';
        if ( 'yes' === $settings['show_image'] ) {
            $thumb_id = get_post_thumbnail_id( $pid );
            if ( $thumb_id ) {
                $image_html = wp_get_attachment_image(
                    $thumb_id,
                    'woocommerce_thumbnail',
                    false,
                    [ 'alt' => esc_attr( $title ), 'loading' => 'lazy' ]
                );
            } else {
                $image_html = '<img src="' . esc_url( wc_placeholder_img_src( 'woocommerce_thumbnail' ) ) . '" alt="' . esc_attr( $title ) . '">';
            }
        }

        $avg_rating = $p->get_average_rating();

        // Discount %
        $discount_percent = 0;
        if ( $p->is_on_sale() && ! $p->is_type( 'variable' ) ) {
            $regular = (float) $p->get_regular_price();
            $sale    = (float) $p->get_sale_price();
            if ( $regular > 0 && $sale > 0 && $regular > $sale ) {
                $discount_percent = round( ( ( $regular - $sale ) / $regular ) * 100 );
            }
        }

        // Stock info
        $stock_status   = $p->get_stock_status();
        $stock_quantity = $p->get_stock_quantity();
        ?>
        <div class="jr-related-card">

            <?php if ( 'yes' === $settings['show_image'] ) : ?>
                <a href="<?php echo esc_url( $link ); ?>" class="jr-card-img">
                    <?php echo $image_html; ?>

                    <div class="jr-card-badges">
                        <?php if ( 'yes' === $settings['show_sale_badge'] && $p->is_on_sale() ) : ?>
                            <span class="jr-card-badge jr-badge-sale"><?php esc_html_e( 'Sale', 'jr-addons' ); ?></span>
                        <?php endif; ?>

                        <?php if ( 'yes' === $settings['show_discount'] && $discount_percent > 0 ) : ?>
                            <span class="jr-card-badge jr-badge-discount">-<?php echo esc_html( $discount_percent ); ?>%</span>
                        <?php endif; ?>

                        <?php if ( 'outofstock' === $stock_status ) : ?>
                            <span class="jr-card-badge jr-badge-out"><?php esc_html_e( 'Out of Stock', 'jr-addons' ); ?></span>
                        <?php endif; ?>
                    </div>
                </a>
            <?php endif; ?>

            <div class="jr-card-info">

                <?php if ( 'yes' === $settings['show_category'] || ( 'yes' === $settings['show_rating'] && $avg_rating > 0 ) ) : ?>
                    <div class="jr-card-meta">
                        <?php if ( 'yes' === $settings['show_category'] ) :
                            // Get only first category for clean look
                            $cat_terms = get_the_terms( $pid, 'product_cat' );
                            $cats = '';
                            if ( $cat_terms && ! is_wp_error( $cat_terms ) ) {
                                $first_cat = reset( $cat_terms );
                                $cats = '<a href="' . esc_url( get_term_link( $first_cat ) ) . '">' . esc_html( $first_cat->name ) . '</a>';
                            }
                            if ( $cats ) : ?>
                                <div class="jr-card-category"><?php echo wp_kses_post( $cats ); ?></div>
                            <?php endif;
                        endif; ?>

                        <?php if ( 'yes' === $settings['show_rating'] && $avg_rating > 0 ) : ?>
                            <div class="jr-card-rating-inline">
                                <span class="jr-rating-num"><?php echo esc_html( number_format( (float) $avg_rating, 1 ) ); ?></span>
                                <span class="jr-rating-star">★</span>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <?php if ( 'yes' === $settings['show_title'] ) : ?>
                    <h4 class="jr-card-title">
                        <a href="<?php echo esc_url( $link ); ?>"><?php echo esc_html( $title ); ?></a>
                    </h4>
                <?php endif; ?>

                <?php if ( 'yes' === ( $settings['show_short_desc'] ?? '' ) ) :
                    $short_desc = $p->get_short_description();
                    if ( ! $short_desc ) {
                        $short_desc = wp_strip_all_tags( $p->get_description() );
                    }
                    if ( $short_desc ) :
                        $words = ! empty( $settings['short_desc_words'] ) ? intval( $settings['short_desc_words'] ) : 10;
                        $short_desc = wp_trim_words( wp_strip_all_tags( $short_desc ), $words, '...' );
                        ?>
                        <p class="jr-card-desc"><?php echo esc_html( $short_desc ); ?></p>
                    <?php endif;
                endif; ?>

                <?php if ( 'yes' === ( $settings['show_stock'] ?? '' ) ) :
                    if ( 'instock' === $stock_status ) :
                        if ( $stock_quantity !== null && $stock_quantity > 0 && $stock_quantity <= 10 ) : ?>
                            <div class="jr-card-stock jr-stock-low">
                                <span class="jr-stock-dot"></span>
                                <?php printf( esc_html__( 'Only %d left in stock', 'jr-addons' ), (int) $stock_quantity ); ?>
                            </div>
                        <?php else : ?>
                            <div class="jr-card-stock jr-stock-in">
                                <span class="jr-stock-dot"></span>
                                <?php esc_html_e( 'In Stock', 'jr-addons' ); ?>
                            </div>
                        <?php endif;
                    elseif ( 'outofstock' === $stock_status ) : ?>
                        <div class="jr-card-stock jr-stock-out">
                            <span class="jr-stock-dot"></span>
                            <?php esc_html_e( 'Out of Stock', 'jr-addons' ); ?>
                        </div>
                    <?php elseif ( 'onbackorder' === $stock_status ) : ?>
                        <div class="jr-card-stock jr-stock-back">
                            <span class="jr-stock-dot"></span>
                            <?php esc_html_e( 'On Backorder', 'jr-addons' ); ?>
                        </div>
                    <?php endif;
                endif; ?>

            </div>

            <?php if ( 'yes' === $settings['show_price'] || 'yes' === $settings['show_button'] ) : ?>
                <div class="jr-card-footer">
                    <?php if ( 'yes' === $settings['show_price'] ) : ?>
                        <div class="jr-card-price"><?php echo $p->get_price_html(); ?></div>
                    <?php endif; ?>

                    <?php if ( 'yes' === $settings['show_button'] ) :
                        $btn_url   = $p->add_to_cart_url();
                        $btn_class = 'jr-card-btn-icon';
                        if ( $p->is_purchasable() && $p->is_in_stock() && ! $p->is_type( 'variable' ) ) {
                            $btn_class .= ' ajax_add_to_cart';
                        }
                        ?>
                        <a href="<?php echo esc_url( $btn_url ); ?>"
                           data-quantity="1"
                           data-product_id="<?php echo esc_attr( $pid ); ?>"
                           class="<?php echo esc_attr( $btn_class ); ?>"
                           rel="nofollow"
                           aria-label="<?php esc_attr_e( 'Add to cart', 'jr-addons' ); ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="9" cy="21" r="1"></circle>
                                <circle cx="20" cy="21" r="1"></circle>
                                <path d="M1 1h4l2.7 13.4a2 2 0 0 0 2 1.6h9.7a2 2 0 0 0 2-1.6L23 6H6"></path>
                            </svg>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

        </div>
        <?php
    }
}