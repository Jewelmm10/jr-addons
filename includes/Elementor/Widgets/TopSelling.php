<?php
namespace JR_Addons\Elementor\Widgets;

if (!defined('ABSPATH')) exit;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Icons_Manager;

class TopSelling extends Widget_Base {

    public function get_name() { return 'jr_top_selling'; }
    public function get_title() { return esc_html__('Top Selling Products', 'jr-addons'); }
    public function get_icon() { return 'jr-get-icon'; }
    public function get_categories() { return ['jr-wc']; }
    public function get_keywords() { return ['product', 'top selling', 'best selling', 'woocommerce', 'shop']; }

    protected function register_controls() {

        /* ============================================================
         * SECTION: QUERY
         * ============================================================ */
        $this->start_controls_section('section_query', [
            'label' => esc_html__('Query', 'jr-addons'),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('posts_per_page', [
            'label'   => esc_html__('Number of Products', 'jr-addons'),
            'type'    => Controls_Manager::NUMBER,
            'min'     => 1,
            'max'     => 50,
            'default' => 4,
        ]);

        $this->add_control('order_by', [
            'label'   => esc_html__('Order By', 'jr-addons'),
            'type'    => Controls_Manager::SELECT,
            'default' => 'sales',
            'options' => [
                'sales'  => esc_html__('Total Sales', 'jr-addons'),
                'date'   => esc_html__('Latest', 'jr-addons'),
                'price'  => esc_html__('Price', 'jr-addons'),
                'rand'   => esc_html__('Random', 'jr-addons'),
                'rating' => esc_html__('Rating', 'jr-addons'),
            ],
        ]);

        $this->add_control('order', [
            'label'   => esc_html__('Order', 'jr-addons'),
            'type'    => Controls_Manager::SELECT,
            'default' => 'DESC',
            'options' => [
                'ASC'  => esc_html__('Ascending', 'jr-addons'),
                'DESC' => esc_html__('Descending', 'jr-addons'),
            ],
        ]);

        $this->add_control('product_category', [
            'label'       => esc_html__('Category', 'jr-addons'),
            'type'        => Controls_Manager::SELECT2,
            'multiple'    => true,
            'options'     => $this->get_product_categories(),
            'label_block' => true,
        ]);

        $this->end_controls_section();


        /* ============================================================
         * SECTION: LAYOUT
         * ============================================================ */
        $this->start_controls_section('section_layout', [
            'label' => esc_html__('Layout', 'jr-addons'),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_responsive_control('columns', [
            'label'   => esc_html__('Columns', 'jr-addons'),
            'type'    => Controls_Manager::SELECT,
            'default' => '2',
            'tablet_default' => '2',
            'mobile_default' => '1',
            'options' => [
                '1' => '1 Column',
                '2' => '2 Columns',
                '3' => '3 Columns',
                '4' => '4 Columns',
            ],
            'selectors' => [
                '{{WRAPPER}} .jr-products-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
            ],
        ]);

        $this->add_responsive_control('column_gap', [
            'label'     => esc_html__('Column Gap', 'jr-addons'),
            'type'      => Controls_Manager::SLIDER,
            'range'     => ['px' => ['min' => 0, 'max' => 60]],
            'default'   => ['unit' => 'px', 'size' => 24],
            'selectors' => ['{{WRAPPER}} .jr-products-grid' => 'gap: {{SIZE}}{{UNIT}};'],
        ]);

        $this->add_responsive_control('image_width', [
            'label'     => esc_html__('Image Width', 'jr-addons'),
            'type'      => Controls_Manager::SLIDER,
            'range'     => ['px' => ['min' => 80, 'max' => 300]],
            'default'   => ['unit' => 'px', 'size' => 160],
            'selectors' => ['{{WRAPPER}} .jr-product-image' => 'width: {{SIZE}}{{UNIT}}; flex: 0 0 {{SIZE}}{{UNIT}};'],
        ]);

        $this->end_controls_section();


        /* ============================================================
         * SECTION: BADGES
         * ============================================================ */
        $this->start_controls_section('section_badges', [
            'label' => esc_html__('Badges', 'jr-addons'),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('show_badge', [
            'label'   => esc_html__('Show Top Badge', 'jr-addons'),
            'type'    => Controls_Manager::SWITCHER,
            'default' => 'yes',
        ]);

        $this->add_control('badge_text', [
            'label'     => esc_html__('Badge Text', 'jr-addons'),
            'type'      => Controls_Manager::TEXT,
            'default'   => esc_html__('Best Selling', 'jr-addons'),
            'condition' => ['show_badge' => 'yes'],
        ]);

        $this->add_control('badge_icon', [
            'label'     => esc_html__('Badge Icon', 'jr-addons'),
            'type'      => Controls_Manager::ICONS,
            'default'   => ['value' => 'fas fa-fire', 'library' => 'fa-solid'],
            'condition' => ['show_badge' => 'yes'],
        ]);

        $this->add_control('badge_position', [
            'label'   => esc_html__('Badge Position', 'jr-addons'),
            'type'    => Controls_Manager::SELECT,
            'default' => 'top-right',
            'options' => [
                'top-left'  => 'Top Left',
                'top-right' => 'Top Right',
            ],
            'condition' => ['show_badge' => 'yes'],
            'prefix_class' => 'jr-badge-pos-',
        ]);

        $this->add_control('show_save_badge', [
            'label'   => esc_html__('Show Save Amount Badge', 'jr-addons'),
            'type'    => Controls_Manager::SWITCHER,
            'default' => 'yes',
        ]);

        $this->add_control('save_text', [
            'label'     => esc_html__('Save Text', 'jr-addons'),
            'type'      => Controls_Manager::TEXT,
            'default'   => esc_html__('Save', 'jr-addons'),
            'condition' => ['show_save_badge' => 'yes'],
        ]);

        $this->end_controls_section();


        /* ============================================================
         * SECTION: BUTTONS
         * ============================================================ */
        $this->start_controls_section('section_buttons', [
            'label' => esc_html__('Buttons', 'jr-addons'),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('show_add_to_cart', [
            'label'   => esc_html__('Show Add to Cart', 'jr-addons'),
            'type'    => Controls_Manager::SWITCHER,
            'default' => 'yes',
        ]);

        $this->add_control('add_cart_text', [
            'label'     => esc_html__('Add to Cart Text', 'jr-addons'),
            'type'      => Controls_Manager::TEXT,
            'default'   => esc_html__('Add To Cart', 'jr-addons'),
            'condition' => ['show_add_to_cart' => 'yes'],
        ]);

        $this->add_control('add_cart_icon', [
            'label'     => esc_html__('Add to Cart Icon', 'jr-addons'),
            'type'      => Controls_Manager::ICONS,
            'default'   => ['value' => 'fas fa-shopping-cart', 'library' => 'fa-solid'],
            'condition' => ['show_add_to_cart' => 'yes'],
        ]);

        $this->add_control('show_buy_now', [
            'label'   => esc_html__('Show Buy Now', 'jr-addons'),
            'type'    => Controls_Manager::SWITCHER,
            'default' => 'yes',
        ]);

        $this->add_control('buy_now_text', [
            'label'     => esc_html__('Buy Now Text', 'jr-addons'),
            'type'      => Controls_Manager::TEXT,
            'default'   => esc_html__('Buy now', 'jr-addons'),
            'condition' => ['show_buy_now' => 'yes'],
        ]);

        $this->add_control('buy_now_icon', [
            'label'     => esc_html__('Buy Now Icon', 'jr-addons'),
            'type'      => Controls_Manager::ICONS,
            'default'   => ['value' => 'fas fa-shopping-bag', 'library' => 'fa-solid'],
            'condition' => ['show_buy_now' => 'yes'],
        ]);

        $this->end_controls_section();


        /* ============================================================
         * STYLE: CARD
         * ============================================================ */
        $this->start_controls_section('style_card', [
            'label' => esc_html__('Card', 'jr-addons'),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_group_control(Group_Control_Background::get_type(), [
            'name'     => 'card_bg',
            'types'    => ['classic', 'gradient'],
            'selector' => '{{WRAPPER}} .jr-product-card',
            'fields_options' => [
                'background' => ['default' => 'classic'],
                'color'      => ['default' => '#ffffff'],
            ],
        ]);

        $this->add_responsive_control('card_padding', [
            'label'      => esc_html__('Padding', 'jr-addons'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'default'    => ['top'=>'24','right'=>'24','bottom'=>'24','left'=>'24','unit'=>'px'],
            'selectors'  => ['{{WRAPPER}} .jr-product-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
        ]);

        $this->add_responsive_control('card_gap', [
            'label'     => esc_html__('Image-Content Gap', 'jr-addons'),
            'type'      => Controls_Manager::SLIDER,
            'range'     => ['px' => ['min' => 0, 'max' => 60]],
            'default'   => ['unit' => 'px', 'size' => 24],
            'selectors' => ['{{WRAPPER}} .jr-product-card' => 'gap: {{SIZE}}{{UNIT}};'],
        ]);

        $this->add_group_control(Group_Control_Border::get_type(), [
            'name'     => 'card_border',
            'selector' => '{{WRAPPER}} .jr-product-card',
            'fields_options' => [
                'border' => ['default' => 'solid'],
                'width'  => ['default' => ['top'=>'1','right'=>'1','bottom'=>'1','left'=>'1','unit'=>'px']],
                'color'  => ['default' => '#f0f0f0'],
            ],
        ]);

        $this->add_responsive_control('card_radius', [
            'label'      => esc_html__('Border Radius', 'jr-addons'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'default'    => ['top'=>'12','right'=>'12','bottom'=>'12','left'=>'12','unit'=>'px'],
            'selectors'  => ['{{WRAPPER}} .jr-product-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
        ]);

        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name'     => 'card_shadow',
            'selector' => '{{WRAPPER}} .jr-product-card',
        ]);

        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name'     => 'card_shadow_hover',
            'label'    => esc_html__('Hover Shadow', 'jr-addons'),
            'selector' => '{{WRAPPER}} .jr-product-card:hover',
        ]);

        $this->end_controls_section();


        /* ============================================================
         * STYLE: BADGE (Top)
         * ============================================================ */
        $this->start_controls_section('style_badge', [
            'label'     => esc_html__('Top Badge', 'jr-addons'),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => ['show_badge' => 'yes'],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name'     => 'badge_typo',
            'selector' => '{{WRAPPER}} .jr-badge',
        ]);

        $this->add_control('badge_color', [
            'label'     => esc_html__('Text Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => [
                '{{WRAPPER}} .jr-badge, {{WRAPPER}} .jr-badge i, {{WRAPPER}} .jr-badge svg' => 'color: {{VALUE}}; fill: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Background::get_type(), [
            'name'     => 'badge_bg',
            'types'    => ['classic', 'gradient'],
            'selector' => '{{WRAPPER}} .jr-badge',
            'fields_options' => [
                'background' => ['default' => 'classic'],
                'color'      => ['default' => '#ef4444'],
            ],
        ]);

        $this->add_responsive_control('badge_padding', [
            'label'      => esc_html__('Padding', 'jr-addons'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'default'    => ['top'=>'5','right'=>'12','bottom'=>'5','left'=>'12','unit'=>'px'],
            'selectors'  => ['{{WRAPPER}} .jr-badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
        ]);

        $this->add_responsive_control('badge_radius', [
            'label'      => esc_html__('Border Radius', 'jr-addons'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'default'    => ['top'=>'0','right'=>'8','bottom'=>'0','left'=>'8','unit'=>'px'],
            'selectors'  => ['{{WRAPPER}} .jr-badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
        ]);

        $this->end_controls_section();


        /* ============================================================
         * STYLE: TITLE
         * ============================================================ */
        $this->start_controls_section('style_title', [
            'label' => esc_html__('Title', 'jr-addons'),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name'     => 'title_typo',
            'selector' => '{{WRAPPER}} .jr-product-title a',
        ]);

        $this->add_control('title_color', [
            'label'     => esc_html__('Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#111827',
            'selectors' => ['{{WRAPPER}} .jr-product-title a' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('title_hover_color', [
            'label'     => esc_html__('Hover Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#f97316',
            'selectors' => ['{{WRAPPER}} .jr-product-title a:hover' => 'color: {{VALUE}};'],
        ]);

        $this->add_responsive_control('title_margin', [
            'label'      => esc_html__('Margin Bottom', 'jr-addons'),
            'type'       => Controls_Manager::SLIDER,
            'range'      => ['px' => ['min' => 0, 'max' => 50]],
            'default'    => ['unit' => 'px', 'size' => 12],
            'selectors'  => ['{{WRAPPER}} .jr-product-title' => 'margin: 0 0 {{SIZE}}{{UNIT}};'],
        ]);

        $this->end_controls_section();


        /* ============================================================
         * STYLE: PRICE
         * ============================================================ */
        $this->start_controls_section('style_price', [
            'label' => esc_html__('Price', 'jr-addons'),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name'     => 'price_typo',
            'label'    => esc_html__('Sale Price Typography', 'jr-addons'),
            'selector' => '{{WRAPPER}} .jr-sale-price',
        ]);

        $this->add_control('sale_price_color', [
            'label'     => esc_html__('Sale Price Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#f97316',
            'selectors' => ['{{WRAPPER}} .jr-sale-price' => 'color: {{VALUE}};'],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name'     => 'regular_price_typo',
            'label'    => esc_html__('Regular Price Typography', 'jr-addons'),
            'selector' => '{{WRAPPER}} .jr-regular-price',
        ]);

        $this->add_control('regular_price_color', [
            'label'     => esc_html__('Regular Price Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#9ca3af',
            'selectors' => ['{{WRAPPER}} .jr-regular-price' => 'color: {{VALUE}};'],
        ]);

        $this->add_responsive_control('price_margin', [
            'label'      => esc_html__('Margin Bottom', 'jr-addons'),
            'type'       => Controls_Manager::SLIDER,
            'range'      => ['px' => ['min' => 0, 'max' => 50]],
            'default'    => ['unit' => 'px', 'size' => 12],
            'selectors'  => ['{{WRAPPER}} .jr-product-price' => 'margin: 0 0 {{SIZE}}{{UNIT}};'],
        ]);

        $this->end_controls_section();


        /* ============================================================
         * STYLE: SAVE BADGE
         * ============================================================ */
        $this->start_controls_section('style_save', [
            'label'     => esc_html__('Save Badge', 'jr-addons'),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => ['show_save_badge' => 'yes'],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name'     => 'save_typo',
            'selector' => '{{WRAPPER}} .jr-save-badge',
        ]);

        $this->add_control('save_color', [
            'label'     => esc_html__('Text Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#000000',
            'selectors' => ['{{WRAPPER}} .jr-save-badge' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('save_bg', [
            'label'     => esc_html__('Background', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#84cc16',
            'selectors' => ['{{WRAPPER}} .jr-save-badge' => 'background: {{VALUE}};'],
        ]);

        $this->add_responsive_control('save_padding', [
            'label'      => esc_html__('Padding', 'jr-addons'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'default'    => ['top'=>'4','right'=>'12','bottom'=>'4','left'=>'12','unit'=>'px'],
            'selectors'  => ['{{WRAPPER}} .jr-save-badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
        ]);

        $this->add_responsive_control('save_radius', [
            'label'      => esc_html__('Border Radius', 'jr-addons'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'default'    => ['top'=>'50','right'=>'50','bottom'=>'50','left'=>'50','unit'=>'px'],
            'selectors'  => ['{{WRAPPER}} .jr-save-badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
        ]);

        $this->add_responsive_control('save_margin', [
            'label'      => esc_html__('Margin Bottom', 'jr-addons'),
            'type'       => Controls_Manager::SLIDER,
            'range'      => ['px' => ['min' => 0, 'max' => 50]],
            'default'    => ['unit' => 'px', 'size' => 16],
            'selectors'  => ['{{WRAPPER}} .jr-save-badge' => 'margin-bottom: {{SIZE}}{{UNIT}};'],
        ]);

        $this->end_controls_section();


        /* ============================================================
         * STYLE: BUTTONS
         * ============================================================ */
        $this->start_controls_section('style_buttons', [
            'label' => esc_html__('Buttons', 'jr-addons'),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name'     => 'btn_typo',
            'selector' => '{{WRAPPER}} .jr-btn',
        ]);

        $this->add_responsive_control('btn_gap', [
            'label'     => esc_html__('Buttons Gap', 'jr-addons'),
            'type'      => Controls_Manager::SLIDER,
            'range'     => ['px' => ['min' => 0, 'max' => 30]],
            'default'   => ['unit' => 'px', 'size' => 10],
            'selectors' => ['{{WRAPPER}} .jr-product-actions' => 'gap: {{SIZE}}{{UNIT}};'],
        ]);

        $this->add_responsive_control('btn_padding', [
            'label'      => esc_html__('Padding', 'jr-addons'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'default'    => ['top'=>'10','right'=>'18','bottom'=>'10','left'=>'18','unit'=>'px'],
            'selectors'  => ['{{WRAPPER}} .jr-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
        ]);

        $this->add_responsive_control('btn_radius', [
            'label'      => esc_html__('Border Radius', 'jr-addons'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'default'    => ['top'=>'8','right'=>'8','bottom'=>'8','left'=>'8','unit'=>'px'],
            'selectors'  => ['{{WRAPPER}} .jr-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
        ]);

        $this->add_responsive_control('btn_icon_size', [
            'label'     => esc_html__('Icon Size', 'jr-addons'),
            'type'      => Controls_Manager::SLIDER,
            'range'     => ['px' => ['min' => 10, 'max' => 30]],
            'default'   => ['unit' => 'px', 'size' => 14],
            'selectors' => [
                '{{WRAPPER}} .jr-btn svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .jr-btn i'   => 'font-size: {{SIZE}}{{UNIT}};',
            ],
        ]);

        // Add to Cart Button
        $this->add_control('add_cart_heading', [
            'label'     => esc_html__('Add to Cart Button', 'jr-addons'),
            'type'      => Controls_Manager::HEADING,
            'separator' => 'before',
            'condition' => ['show_add_to_cart' => 'yes'],
        ]);

        $this->start_controls_tabs('add_cart_tabs', ['condition' => ['show_add_to_cart' => 'yes']]);

        $this->start_controls_tab('add_cart_normal', ['label' => 'Normal']);
        $this->add_control('add_cart_color', [
            'label'     => esc_html__('Text Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#f97316',
            'selectors' => [
                '{{WRAPPER}} .jr-btn-cart, {{WRAPPER}} .jr-btn-cart i, {{WRAPPER}} .jr-btn-cart svg' => 'color: {{VALUE}}; fill: {{VALUE}};',
            ],
        ]);
        $this->add_control('add_cart_bg', [
            'label'     => esc_html__('Background', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => ['{{WRAPPER}} .jr-btn-cart' => 'background: {{VALUE}};'],
        ]);
        $this->add_control('add_cart_border_color', [
            'label'     => esc_html__('Border Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#f97316',
            'selectors' => ['{{WRAPPER}} .jr-btn-cart' => 'border: 1px solid {{VALUE}};'],
        ]);
        $this->end_controls_tab();

        $this->start_controls_tab('add_cart_hover', ['label' => 'Hover']);
        $this->add_control('add_cart_hover_color', [
            'label'     => esc_html__('Text Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => [
                '{{WRAPPER}} .jr-btn-cart:hover, {{WRAPPER}} .jr-btn-cart:hover i, {{WRAPPER}} .jr-btn-cart:hover svg' => 'color: {{VALUE}}; fill: {{VALUE}};',
            ],
        ]);
        $this->add_control('add_cart_hover_bg', [
            'label'     => esc_html__('Background', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#f97316',
            'selectors' => ['{{WRAPPER}} .jr-btn-cart:hover' => 'background: {{VALUE}};'],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();

        // Buy Now Button
        $this->add_control('buy_now_heading', [
            'label'     => esc_html__('Buy Now Button', 'jr-addons'),
            'type'      => Controls_Manager::HEADING,
            'separator' => 'before',
            'condition' => ['show_buy_now' => 'yes'],
        ]);

        $this->start_controls_tabs('buy_now_tabs', ['condition' => ['show_buy_now' => 'yes']]);

        $this->start_controls_tab('buy_now_normal', ['label' => 'Normal']);
        $this->add_control('buy_now_color', [
            'label'     => esc_html__('Text Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => [
                '{{WRAPPER}} .jr-btn-buy, {{WRAPPER}} .jr-btn-buy i, {{WRAPPER}} .jr-btn-buy svg' => 'color: {{VALUE}}; fill: {{VALUE}};',
            ],
        ]);
        $this->add_control('buy_now_bg', [
            'label'     => esc_html__('Background', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#f97316',
            'selectors' => ['{{WRAPPER}} .jr-btn-buy' => 'background: {{VALUE}}; border: 1px solid {{VALUE}};'],
        ]);
        $this->end_controls_tab();

        $this->start_controls_tab('buy_now_hover', ['label' => 'Hover']);
        $this->add_control('buy_now_hover_color', [
            'label'     => esc_html__('Text Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => [
                '{{WRAPPER}} .jr-btn-buy:hover, {{WRAPPER}} .jr-btn-buy:hover i, {{WRAPPER}} .jr-btn-buy:hover svg' => 'color: {{VALUE}}; fill: {{VALUE}};',
            ],
        ]);
        $this->add_control('buy_now_hover_bg', [
            'label'     => esc_html__('Background', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#ea580c',
            'selectors' => ['{{WRAPPER}} .jr-btn-buy:hover' => 'background: {{VALUE}}; border-color: {{VALUE}};'],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }


    /**
     * Get all product categories for dropdown
     */
    private function get_product_categories() {
        $options = [];
        if (taxonomy_exists('product_cat')) {
            $terms = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => true]);
            if (!is_wp_error($terms)) {
                foreach ($terms as $term) {
                    $options[$term->slug] = $term->name;
                }
            }
        }
        return $options;
    }


    protected function render() {
        if (!class_exists('WooCommerce')) {
            echo '<p>' . esc_html__('WooCommerce is not installed.', 'jr-addons') . '</p>';
            return;
        }

        $settings = $this->get_settings_for_display();

        // Build query args
        $args = [
            'post_type'      => 'product',
            'posts_per_page' => (int) $settings['posts_per_page'],
            'post_status'    => 'publish',
            'order'          => $settings['order'],
        ];

        // Order by
        switch ($settings['order_by']) {
            case 'sales':
                $args['meta_key'] = 'total_sales';
                $args['orderby']  = 'meta_value_num';
                break;
            case 'price':
                $args['meta_key'] = '_price';
                $args['orderby']  = 'meta_value_num';
                break;
            case 'rating':
                $args['meta_key'] = '_wc_average_rating';
                $args['orderby']  = 'meta_value_num';
                break;
            case 'rand':
                $args['orderby'] = 'rand';
                break;
            default:
                $args['orderby'] = 'date';
        }

        // Category filter
        if (!empty($settings['product_category'])) {
            $args['tax_query'] = [[
                'taxonomy' => 'product_cat',
                'field'    => 'slug',
                'terms'    => $settings['product_category'],
            ]];
        }

        $loop = new \WP_Query($args);
        ?>

        <style>
            .jr-products-grid{display:grid;width:100%}
            
            /* Product Card */
            .jr-product-card{position:relative;display:flex;align-items:center;background:#fff;transition:all .3s ease;overflow:hidden}
            .jr-product-card:hover{transform:translateY(-2px)}
            
            /* Image */
            .jr-product-image{flex-shrink:0}
            .jr-product-image a{display:block;overflow:hidden;border-radius:8px}
            .jr-product-image img{width:100%;height:auto;display:block;transition:transform .4s ease}
            .jr-product-card:hover .jr-product-image img{transform:scale(1.05)}
            
            /* Content */
            .jr-product-content{flex:1;min-width:0}
            
            /* Badge - Top Position */
            .jr-badge{position:absolute;display:inline-flex;align-items:center;gap:5px;font-weight:600;line-height:1;z-index:2;white-space:nowrap}
            .jr-badge i,.jr-badge svg{display:inline-flex}
            .jr-badge-pos-top-left .jr-badge{top:0;left:0;border-radius:0 0 8px 0!important}
            .jr-badge-pos-top-right .jr-badge{top:0;right:0;border-radius:0 0 0 8px!important}
            
            /* Title */
            .jr-product-title{margin:0 0 12px}
            .jr-product-title a{text-decoration:none;display:block;transition:color .2s ease;line-height:1.3}
            
            /* Price */
            .jr-product-price{display:flex;align-items:center;gap:10px;flex-wrap:wrap}
            .jr-sale-price{font-weight:700;line-height:1}
            .jr-regular-price{text-decoration:line-through;line-height:1;font-weight:500}
            .jr-product-price .price{margin:0;font-weight:700}
            .jr-product-price .price del{opacity:.6;margin-right:6px}
            
            /* Save Badge */
            .jr-save-badge{display:inline-block;font-weight:600;line-height:1;width:fit-content}
            
            /* Action Buttons */
            .jr-product-actions{display:flex;align-items:center;flex-wrap:wrap}
            .jr-btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;text-decoration:none;font-weight:600;line-height:1;cursor:pointer;transition:all .3s ease;white-space:nowrap;border:none;background:transparent}
            .jr-btn:active{transform:scale(.97)}
            .jr-btn svg,.jr-btn i{flex-shrink:0;line-height:1}
            
            /* WC default button override */
            .jr-product-actions .jr-btn-cart-wrap{margin:0;padding:0}
            .jr-product-actions .added_to_cart{display:none!important}
            
            /* Responsive */
            @media(max-width:640px){
                .jr-product-card{flex-direction:column;text-align:center}
                .jr-product-image{width:100%!important;flex:0 0 auto!important}
                .jr-product-actions{justify-content:center}
                .jr-product-price{justify-content:center}
            }
        </style>

        <div class="jr-products-grid">

            <?php if ($loop->have_posts()): ?>
                
                <?php while ($loop->have_posts()): $loop->the_post();
                    global $product;
                    if (!$product) continue;

                    $regular_price = $product->get_regular_price();
                    $sale_price    = $product->get_sale_price();
                    $save_amount   = ($regular_price && $sale_price) ? ($regular_price - $sale_price) : 0;
                    ?>

                    <div class="jr-product-card" data-product-id="<?php echo esc_attr($product->get_id()); ?>">

                        <?php /* === BADGE === */ ?>
                        <?php if ($settings['show_badge'] === 'yes'): ?>
                            <span class="jr-badge">
                                <?php if (!empty($settings['badge_icon']['value'])): ?>
                                    <?php Icons_Manager::render_icon($settings['badge_icon'], ['aria-hidden' => 'true']); ?>
                                <?php endif; ?>
                                <?php echo esc_html($settings['badge_text']); ?>
                            </span>
                        <?php endif; ?>

                        <?php /* === IMAGE === */ ?>
                        <div class="jr-product-image">
                            <a href="<?php the_permalink(); ?>">
                                <?php echo $product->get_image('medium'); ?>
                            </a>
                        </div>

                        <?php /* === CONTENT === */ ?>
                        <div class="jr-product-content">

                            <h3 class="jr-product-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>

                            <div class="jr-product-price">
                                <?php if ($sale_price && $regular_price): ?>
                                    <span class="jr-sale-price"><?php echo wp_kses_post(wc_price($sale_price)); ?></span>
                                    <span class="jr-regular-price"><?php echo wp_kses_post(wc_price($regular_price)); ?></span>
                                <?php else: ?>
                                    <span class="jr-sale-price"><?php echo wp_kses_post($product->get_price_html()); ?></span>
                                <?php endif; ?>
                            </div>

                            <?php /* === SAVE BADGE === */ ?>
                            <?php if ($settings['show_save_badge'] === 'yes' && $save_amount > 0): ?>
                                <div class="jr-save-badge">
                                    <?php echo esc_html($settings['save_text']); ?> <?php echo wp_kses_post(wc_price($save_amount)); ?>
                                </div>
                            <?php endif; ?>

                            <?php /* === ACTION BUTTONS === */ ?>
                            <?php if ($settings['show_add_to_cart'] === 'yes' || $settings['show_buy_now'] === 'yes'): ?>
                                <div class="jr-product-actions">

                                    <?php if ($settings['show_add_to_cart'] === 'yes'): ?>
                                        <a href="?add-to-cart=<?php echo esc_attr($product->get_id()); ?>"
                                           class="jr-btn jr-btn-cart add_to_cart_button ajax_add_to_cart"
                                           data-product_id="<?php echo esc_attr($product->get_id()); ?>"
                                           data-quantity="1"
                                           rel="nofollow">
                                            <?php if (!empty($settings['add_cart_icon']['value'])): ?>
                                                <?php Icons_Manager::render_icon($settings['add_cart_icon'], ['aria-hidden' => 'true']); ?>
                                            <?php endif; ?>
                                            <span><?php echo esc_html($settings['add_cart_text']); ?></span>
                                        </a>
                                    <?php endif; ?>

                                    <?php if ($settings['show_buy_now'] === 'yes'): ?>
                                        <a href="<?php echo esc_url(wc_get_checkout_url() . '?add-to-cart=' . $product->get_id()); ?>"
                                           class="jr-btn jr-btn-buy">
                                            <?php if (!empty($settings['buy_now_icon']['value'])): ?>
                                                <?php Icons_Manager::render_icon($settings['buy_now_icon'], ['aria-hidden' => 'true']); ?>
                                            <?php endif; ?>
                                            <span><?php echo esc_html($settings['buy_now_text']); ?></span>
                                        </a>
                                    <?php endif; ?>

                                </div>
                            <?php endif; ?>

                        </div>

                    </div>

                <?php endwhile; ?>
                <?php wp_reset_postdata(); ?>

            <?php else: ?>
                <p style="grid-column:1/-1;text-align:center;padding:40px;color:#6b7280;">
                    <?php esc_html_e('No products found.', 'jr-addons'); ?>
                </p>
            <?php endif; ?>

        </div>
        <?php
    }
}