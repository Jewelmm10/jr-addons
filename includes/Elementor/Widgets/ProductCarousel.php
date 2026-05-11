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

class ProductCarousel extends Widget_Base {

    public function get_name() { return 'spater_product_carousel'; }
    public function get_title() { return esc_html__('Product Carousel', 'jr-addons'); }
    public function get_icon() { return 'jr-get-icon'; }
    public function get_categories() { return ['jr-addons']; }
    public function get_keywords() { return ['product', 'carousel', 'slider', 'woocommerce', 'swiper']; }

    public function get_script_depends() { return ['swiper']; }
    public function get_style_depends() { return ['swiper', 'e-swiper']; }

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
            'max'     => 100,
            'default' => 10,
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
                'ASC'  => 'Ascending',
                'DESC' => 'Descending',
            ],
        ]);

        $this->add_control('product_category', [
            'label'       => esc_html__('Category', 'jr-addons'),
            'type'        => Controls_Manager::SELECT2,
            'multiple'    => true,
            'options'     => $this->get_product_categories(),
            'label_block' => true,
        ]);

        $this->add_control('show_only_sale', [
            'label'   => esc_html__('Show Only Sale Products', 'jr-addons'),
            'type'    => Controls_Manager::SWITCHER,
            'default' => 'no',
        ]);

        $this->end_controls_section();


        /* ============================================================
         * SECTION: SLIDER SETTINGS
         * ============================================================ */
        $this->start_controls_section('section_slider', [
            'label' => esc_html__('Slider Settings', 'jr-addons'),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_responsive_control('slides_per_view', [
            'label'          => esc_html__('Slides Per View', 'jr-addons'),
            'type'           => Controls_Manager::NUMBER,
            'min'            => 1,
            'max'            => 8,
            'default'        => 5,
            'tablet_default' => 3,
            'mobile_default' => 2,
        ]);

        $this->add_responsive_control('space_between', [
            'label'          => esc_html__('Space Between', 'jr-addons'),
            'type'           => Controls_Manager::NUMBER,
            'min'            => 0,
            'max'            => 100,
            'default'        => 20,
            'tablet_default' => 15,
            'mobile_default' => 10,
        ]);

        $this->add_control('loop', [
            'label'   => esc_html__('Loop', 'jr-addons'),
            'type'    => Controls_Manager::SWITCHER,
            'default' => 'yes',
        ]);

        $this->add_control('autoplay', [
            'label'   => esc_html__('Autoplay', 'jr-addons'),
            'type'    => Controls_Manager::SWITCHER,
            'default' => 'yes',
        ]);

        $this->add_control('autoplay_speed', [
            'label'     => esc_html__('Autoplay Speed (ms)', 'jr-addons'),
            'type'      => Controls_Manager::NUMBER,
            'default'   => 4000,
            'condition' => ['autoplay' => 'yes'],
        ]);

        $this->add_control('show_arrows', [
            'label'   => esc_html__('Show Arrows', 'jr-addons'),
            'type'    => Controls_Manager::SWITCHER,
            'default' => 'no',
        ]);

        $this->add_control('show_pagination', [
            'label'   => esc_html__('Show Pagination', 'jr-addons'),
            'type'    => Controls_Manager::SWITCHER,
            'default' => 'yes',
        ]);

        $this->end_controls_section();


        /* ============================================================
         * SECTION: ELEMENTS
         * ============================================================ */
        $this->start_controls_section('section_elements', [
            'label' => esc_html__('Elements', 'jr-addons'),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('show_save_badge', [
            'label'   => esc_html__('Show Save % Badge', 'jr-addons'),
            'type'    => Controls_Manager::SWITCHER,
            'default' => 'yes',
        ]);

        $this->add_control('show_rating', [
            'label'   => esc_html__('Show Rating', 'jr-addons'),
            'type'    => Controls_Manager::SWITCHER,
            'default' => 'no',
        ]);

        $this->add_control('show_category', [
            'label'   => esc_html__('Show Category', 'jr-addons'),
            'type'    => Controls_Manager::SWITCHER,
            'default' => 'no',
        ]);

        $this->add_control('show_add_to_cart', [
            'label'   => esc_html__('Show Add to Cart', 'jr-addons'),
            'type'    => Controls_Manager::SWITCHER,
            'default' => 'yes',
        ]);

        $this->add_control('add_cart_text', [
            'label'     => esc_html__('Button Text', 'jr-addons'),
            'type'      => Controls_Manager::TEXT,
            'default'   => esc_html__('Add To Cart', 'jr-addons'),
            'condition' => ['show_add_to_cart' => 'yes'],
        ]);

        $this->add_control('cart_icon', [
            'label'     => esc_html__('Button Icon', 'jr-addons'),
            'type'      => Controls_Manager::ICONS,
            'default'   => ['value' => 'fas fa-shopping-cart', 'library' => 'fa-solid'],
            'condition' => ['show_add_to_cart' => 'yes'],
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
            'selector' => '{{WRAPPER}} .jr-pc-card',
            'fields_options' => [
                'background' => ['default' => 'classic'],
                'color'      => ['default' => '#ffffff'],
            ],
        ]);

        $this->add_responsive_control('card_padding', [
            'label'      => esc_html__('Padding', 'jr-addons'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'default'    => ['top'=>'16','right'=>'16','bottom'=>'16','left'=>'16','unit'=>'px'],
            'selectors'  => ['{{WRAPPER}} .jr-pc-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
        ]);

        $this->add_group_control(Group_Control_Border::get_type(), [
            'name'     => 'card_border',
            'selector' => '{{WRAPPER}} .jr-pc-card',
            'fields_options' => [
                'border' => ['default' => 'solid'],
                'width'  => ['default' => ['top'=>'1','right'=>'1','bottom'=>'1','left'=>'1','unit'=>'px']],
                'color'  => ['default' => '#e5e7eb'],
            ],
        ]);

        $this->add_responsive_control('card_radius', [
            'label'      => esc_html__('Border Radius', 'jr-addons'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'default'    => ['top'=>'10','right'=>'10','bottom'=>'10','left'=>'10','unit'=>'px'],
            'selectors'  => ['{{WRAPPER}} .jr-pc-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow:hidden;'],
        ]);

        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name'     => 'card_shadow',
            'selector' => '{{WRAPPER}} .jr-pc-card',
        ]);

        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name'     => 'card_hover_shadow',
            'label'    => esc_html__('Hover Shadow', 'jr-addons'),
            'selector' => '{{WRAPPER}} .jr-pc-card:hover',
        ]);

        $this->end_controls_section();


        /* ============================================================
         * STYLE: IMAGE
         * ============================================================ */
        $this->start_controls_section('style_image', [
            'label' => esc_html__('Image', 'jr-addons'),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_responsive_control('img_height', [
            'label'     => esc_html__('Height', 'jr-addons'),
            'type'      => Controls_Manager::SLIDER,
            'range'     => ['px' => ['min' => 100, 'max' => 500]],
            'default'   => ['unit' => 'px', 'size' => 220],
            'selectors' => ['{{WRAPPER}} .jr-pc-img' => 'height: {{SIZE}}{{UNIT}};'],
        ]);

        $this->add_responsive_control('img_radius', [
            'label'      => esc_html__('Border Radius', 'jr-addons'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'default'    => ['top'=>'6','right'=>'6','bottom'=>'6','left'=>'6','unit'=>'px'],
            'selectors'  => ['{{WRAPPER}} .jr-pc-img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow:hidden;'],
        ]);

        $this->add_control('img_fit', [
            'label'   => esc_html__('Object Fit', 'jr-addons'),
            'type'    => Controls_Manager::SELECT,
            'default' => 'contain',
            'options' => [
                'contain' => 'Contain',
                'cover'   => 'Cover',
                'fill'    => 'Fill',
            ],
            'selectors' => ['{{WRAPPER}} .jr-pc-img img' => 'object-fit: {{VALUE}};'],
        ]);

        $this->add_responsive_control('img_margin_bottom', [
            'label'     => esc_html__('Margin Bottom', 'jr-addons'),
            'type'      => Controls_Manager::SLIDER,
            'range'     => ['px' => ['min' => 0, 'max' => 50]],
            'default'   => ['unit' => 'px', 'size' => 16],
            'selectors' => ['{{WRAPPER}} .jr-pc-img' => 'margin-bottom: {{SIZE}}{{UNIT}};'],
        ]);

        $this->end_controls_section();


        /* ============================================================
         * STYLE: SAVE BADGE
         * ============================================================ */
        $this->start_controls_section('style_save_badge', [
            'label'     => esc_html__('Save Badge', 'jr-addons'),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => ['show_save_badge' => 'yes'],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name'     => 'badge_typo',
            'selector' => '{{WRAPPER}} .jr-pc-badge',
        ]);

        $this->add_control('badge_color', [
            'label'     => esc_html__('Text Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => ['{{WRAPPER}} .jr-pc-badge' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('badge_bg', [
            'label'     => esc_html__('Background', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#22c55e',
            'selectors' => ['{{WRAPPER}} .jr-pc-badge' => 'background: {{VALUE}};'],
        ]);

        $this->add_responsive_control('badge_padding', [
            'label'      => esc_html__('Padding', 'jr-addons'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'default'    => ['top'=>'4','right'=>'10','bottom'=>'4','left'=>'10','unit'=>'px'],
            'selectors'  => ['{{WRAPPER}} .jr-pc-badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
        ]);

        $this->add_responsive_control('badge_radius', [
            'label'      => esc_html__('Border Radius', 'jr-addons'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'default'    => ['top'=>'0','right'=>'0','bottom'=>'6','left'=>'6','unit'=>'px'],
            'selectors'  => ['{{WRAPPER}} .jr-pc-badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
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
            'selector' => '{{WRAPPER}} .jr-pc-title a',
        ]);

        $this->add_control('title_color', [
            'label'     => esc_html__('Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#111827',
            'selectors' => ['{{WRAPPER}} .jr-pc-title a' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('title_hover_color', [
            'label'     => esc_html__('Hover Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#f97316',
            'selectors' => ['{{WRAPPER}} .jr-pc-title a:hover' => 'color: {{VALUE}};'],
        ]);

        $this->add_responsive_control('title_lines', [
            'label'     => esc_html__('Line Clamp', 'jr-addons'),
            'type'      => Controls_Manager::NUMBER,
            'min'       => 1,
            'max'       => 5,
            'default'   => 2,
            'selectors' => [
                '{{WRAPPER}} .jr-pc-title a' => '-webkit-line-clamp: {{VALUE}};',
            ],
        ]);

        $this->add_responsive_control('title_margin', [
            'label'     => esc_html__('Margin Bottom', 'jr-addons'),
            'type'      => Controls_Manager::SLIDER,
            'range'     => ['px' => ['min' => 0, 'max' => 40]],
            'default'   => ['unit' => 'px', 'size' => 10],
            'selectors' => ['{{WRAPPER}} .jr-pc-title' => 'margin: 0 0 {{SIZE}}{{UNIT}};'],
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
            'name'     => 'sale_price_typo',
            'label'    => 'Sale Price Typography',
            'selector' => '{{WRAPPER}} .jr-pc-sale-price',
        ]);

        $this->add_control('sale_price_color', [
            'label'     => esc_html__('Sale Price Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#f97316',
            'selectors' => ['{{WRAPPER}} .jr-pc-sale-price' => 'color: {{VALUE}};'],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name'     => 'reg_price_typo',
            'label'    => 'Regular Price Typography',
            'selector' => '{{WRAPPER}} .jr-pc-reg-price',
        ]);

        $this->add_control('reg_price_color', [
            'label'     => esc_html__('Regular Price Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#9ca3af',
            'selectors' => ['{{WRAPPER}} .jr-pc-reg-price' => 'color: {{VALUE}};'],
        ]);

        $this->add_responsive_control('price_margin', [
            'label'     => esc_html__('Margin Bottom', 'jr-addons'),
            'type'      => Controls_Manager::SLIDER,
            'range'     => ['px' => ['min' => 0, 'max' => 40]],
            'default'   => ['unit' => 'px', 'size' => 14],
            'selectors' => ['{{WRAPPER}} .jr-pc-price' => 'margin: 0 0 {{SIZE}}{{UNIT}};'],
        ]);

        $this->end_controls_section();


        /* ============================================================
         * STYLE: ADD TO CART BUTTON
         * ============================================================ */
        $this->start_controls_section('style_button', [
            'label'     => esc_html__('Add To Cart Button', 'jr-addons'),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => ['show_add_to_cart' => 'yes'],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name'     => 'btn_typo',
            'selector' => '{{WRAPPER}} .jr-pc-btn',
        ]);

        $this->start_controls_tabs('btn_color_tabs');

        $this->start_controls_tab('btn_normal', ['label' => 'Normal']);
        $this->add_control('btn_color', [
            'label'     => esc_html__('Text Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#f97316',
            'selectors' => [
                '{{WRAPPER}} .jr-pc-btn, {{WRAPPER}} .jr-pc-btn i, {{WRAPPER}} .jr-pc-btn svg' => 'color: {{VALUE}}; fill: {{VALUE}};',
            ],
        ]);
        $this->add_control('btn_bg', [
            'label'     => esc_html__('Background', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => ['{{WRAPPER}} .jr-pc-btn' => 'background: {{VALUE}};'],
        ]);
        $this->add_control('btn_border_color', [
            'label'     => esc_html__('Border Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#f97316',
            'selectors' => ['{{WRAPPER}} .jr-pc-btn' => 'border: 1px solid {{VALUE}};'],
        ]);
        $this->end_controls_tab();

        $this->start_controls_tab('btn_hover', ['label' => 'Hover']);
        $this->add_control('btn_hover_color', [
            'label'     => esc_html__('Text Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => [
                '{{WRAPPER}} .jr-pc-btn:hover, {{WRAPPER}} .jr-pc-btn:hover i, {{WRAPPER}} .jr-pc-btn:hover svg' => 'color: {{VALUE}}; fill: {{VALUE}};',
            ],
        ]);
        $this->add_control('btn_hover_bg', [
            'label'     => esc_html__('Background', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#f97316',
            'selectors' => ['{{WRAPPER}} .jr-pc-btn:hover' => 'background: {{VALUE}};'],
        ]);
        $this->add_control('btn_hover_border_color', [
            'label'     => esc_html__('Border Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#f97316',
            'selectors' => ['{{WRAPPER}} .jr-pc-btn:hover' => 'border-color: {{VALUE}};'],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control('btn_padding', [
            'label'      => esc_html__('Padding', 'jr-addons'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'default'    => ['top'=>'10','right'=>'16','bottom'=>'10','left'=>'16','unit'=>'px'],
            'selectors'  => ['{{WRAPPER}} .jr-pc-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
        ]);

        $this->add_responsive_control('btn_radius', [
            'label'      => esc_html__('Border Radius', 'jr-addons'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'default'    => ['top'=>'8','right'=>'8','bottom'=>'8','left'=>'8','unit'=>'px'],
            'selectors'  => ['{{WRAPPER}} .jr-pc-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
        ]);

        $this->add_responsive_control('btn_icon_size', [
            'label'     => esc_html__('Icon Size', 'jr-addons'),
            'type'      => Controls_Manager::SLIDER,
            'range'     => ['px' => ['min' => 10, 'max' => 30]],
            'default'   => ['unit' => 'px', 'size' => 14],
            'selectors' => [
                '{{WRAPPER}} .jr-pc-btn svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .jr-pc-btn i'   => 'font-size: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();


        /* ============================================================
         * STYLE: PAGINATION
         * ============================================================ */
        $this->start_controls_section('style_pagination', [
            'label'     => esc_html__('Pagination', 'jr-addons'),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => ['show_pagination' => 'yes'],
        ]);

        $this->add_responsive_control('pagination_top', [
            'label'     => esc_html__('Top Margin', 'jr-addons'),
            'type'      => Controls_Manager::SLIDER,
            'range'     => ['px' => ['min' => 0, 'max' => 60]],
            'default'   => ['unit' => 'px', 'size' => 20],
            'selectors' => ['{{WRAPPER}} .swiper-pagination' => 'margin-top: {{SIZE}}{{UNIT}}; position:static; display:flex; justify-content:center;'],
        ]);

        $this->add_control('dot_color', [
            'label'     => esc_html__('Dot Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#d1d5db',
            'selectors' => ['{{WRAPPER}} .swiper-pagination-bullet' => 'background: {{VALUE}}; opacity: 1;'],
        ]);

        $this->add_control('dot_active_color', [
            'label'     => esc_html__('Active Dot Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#f97316',
            'selectors' => ['{{WRAPPER}} .swiper-pagination-bullet-active' => 'background: {{VALUE}};'],
        ]);

        $this->add_responsive_control('dot_size', [
            'label'     => esc_html__('Dot Size', 'jr-addons'),
            'type'      => Controls_Manager::SLIDER,
            'range'     => ['px' => ['min' => 4, 'max' => 20]],
            'default'   => ['unit' => 'px', 'size' => 8],
            'selectors' => [
                '{{WRAPPER}} .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_responsive_control('dot_active_width', [
            'label'     => esc_html__('Active Dot Width', 'jr-addons'),
            'type'      => Controls_Manager::SLIDER,
            'range'     => ['px' => ['min' => 4, 'max' => 50]],
            'default'   => ['unit' => 'px', 'size' => 24],
            'selectors' => ['{{WRAPPER}} .swiper-pagination-bullet-active' => 'width: {{SIZE}}{{UNIT}}; border-radius: 10px;'],
        ]);

        $this->end_controls_section();
    }


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

        $settings  = $this->get_settings_for_display();
        $slider_id = 'jr-pc-' . $this->get_id();

        // Responsive
        $desktop = !empty($settings['slides_per_view']) ? (int) $settings['slides_per_view'] : 5;
        $tablet  = !empty($settings['slides_per_view_tablet']) ? (int) $settings['slides_per_view_tablet'] : 3;
        $mobile  = !empty($settings['slides_per_view_mobile']) ? (int) $settings['slides_per_view_mobile'] : 2;

        $sb_desktop = !empty($settings['space_between']) ? (int) $settings['space_between'] : 20;
        $sb_tablet  = !empty($settings['space_between_tablet']) ? (int) $settings['space_between_tablet'] : 15;
        $sb_mobile  = !empty($settings['space_between_mobile']) ? (int) $settings['space_between_mobile'] : 10;

        // Swiper Config
        $swiper_settings = [
            'loop'      => ($settings['loop'] === 'yes'),
            'grabCursor' => true,
            'autoplay'  => ($settings['autoplay'] === 'yes') ? [
                'delay' => (int) ($settings['autoplay_speed'] ?? 4000),
                'disableOnInteraction' => false,
            ] : false,
            'spaceBetween'  => $sb_mobile,
            'slidesPerView' => $mobile,
            'pagination'    => ($settings['show_pagination'] === 'yes'),
            'navigation'    => ($settings['show_arrows'] === 'yes'),
            'breakpoints'   => [
                768  => ['slidesPerView' => $tablet, 'spaceBetween' => $sb_tablet],
                1024 => ['slidesPerView' => $desktop, 'spaceBetween' => $sb_desktop],
            ],
        ];

        // Query
        $args = [
            'post_type'      => 'product',
            'posts_per_page' => (int) $settings['posts_per_page'],
            'post_status'    => 'publish',
            'order'          => $settings['order'],
        ];

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

        if (!empty($settings['product_category'])) {
            $args['tax_query'] = [[
                'taxonomy' => 'product_cat',
                'field'    => 'slug',
                'terms'    => $settings['product_category'],
            ]];
        }

        if ($settings['show_only_sale'] === 'yes') {
            $args['post__in'] = array_merge([0], wc_get_product_ids_on_sale());
        }

        $loop = new \WP_Query($args);
        ?>

        <style>
            /* Card */
            .jr-pc-card{position:relative;display:flex;flex-direction:column;height:100%;transition:all .3s ease;overflow:hidden}
            .jr-pc-card:hover{transform:translateY(-3px)}

            /* Badge */
            .jr-pc-badge{position:absolute;top:0;right:0;font-weight:700;line-height:1;z-index:2;white-space:nowrap}

            /* Image */
            .jr-pc-img{width:100%;overflow:hidden;display:flex;align-items:center;justify-content:center;background:#fafafa}
            .jr-pc-img img{width:100%;height:100%;display:block;transition:transform .4s ease}
            .jr-pc-card:hover .jr-pc-img img{transform:scale(1.06)}

            /* Content */
            .jr-pc-body{flex:1;display:flex;flex-direction:column;padding-top:12px}

            /* Title */
            .jr-pc-title{margin:0 0 10px}
            .jr-pc-title a{text-decoration:none;display:-webkit-box;-webkit-box-orient:vertical;overflow:hidden;transition:color .2s ease;line-height:1.4}

            /* Price */
            .jr-pc-price{display:flex;align-items:center;gap:8px;flex-wrap:wrap}
            .jr-pc-sale-price{font-weight:700;line-height:1}
            .jr-pc-reg-price{text-decoration:line-through;font-weight:500;line-height:1}

            /* Rating */
            .jr-pc-rating{display:flex;align-items:center;gap:4px;margin-bottom:8px}
            .jr-pc-rating i{color:#fbbf24;font-size:13px}

            /* Category */
            .jr-pc-cat{font-size:12px;color:#6b7280;margin-bottom:6px;display:block}

            /* Button */
            .jr-pc-btn{display:flex;align-items:center;justify-content:center;gap:8px;width:100%;text-decoration:none;font-weight:600;line-height:1;cursor:pointer;transition:all .3s ease;margin-top:auto;border:none;background:transparent}
            .jr-pc-btn:active{transform:scale(.97)}
            .jr-pc-btn i,.jr-pc-btn svg{flex-shrink:0;line-height:1;transition:transform .3s ease}
            .jr-pc-btn:hover i,.jr-pc-btn:hover svg{transform:translateX(2px)}
            .jr-pc-btn.loading{opacity:.7;pointer-events:none}
            .jr-pc-btn.added_to_cart{display:none!important}

            /* Pagination */
            .swiper-pagination-bullet{transition:all .3s ease}

            /* Remove WC added link */
            .jr-product-carousel .added_to_cart{display:none!important}
        </style>

        <div class="jr-product-carousel">
            <div id="<?php echo esc_attr($slider_id); ?>"
                 class="jr-swiper swiper"
                 data-settings='<?php echo wp_json_encode($swiper_settings); ?>'>

                <div class="swiper-wrapper">

                    <?php if ($loop->have_posts()): ?>
                        <?php while ($loop->have_posts()): $loop->the_post();
                            global $product;
                            if (!$product) continue;

                            $regular_price = $product->get_regular_price();
                            $sale_price    = $product->get_sale_price();
                            $save_percent  = ($regular_price && $sale_price && $regular_price > 0)
                                ? round((($regular_price - $sale_price) / $regular_price) * 100)
                                : 0;

                            $avg_rating  = $product->get_average_rating();
                            $categories  = get_the_terms(get_the_ID(), 'product_cat');
                            $cat_name    = (!is_wp_error($categories) && !empty($categories)) ? esc_html($categories[0]->name) : '';
                            ?>

                            <div class="swiper-slide">
                                <div class="jr-pc-card">

                                    <?php /* === SAVE BADGE === */ ?>
                                    <?php if ($settings['show_save_badge'] === 'yes' && $save_percent > 0): ?>
                                        <span class="jr-pc-badge">
                                            <?php echo esc_html__('Save', 'jr-addons') . ' ' . esc_html($save_percent) . '%'; ?>
                                        </span>
                                    <?php endif; ?>

                                    <?php /* === IMAGE === */ ?>
                                    <div class="jr-pc-img">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php echo $product->get_image('woocommerce_thumbnail'); ?>
                                        </a>
                                    </div>

                                    <?php /* === CONTENT === */ ?>
                                    <div class="jr-pc-body">

                                        <?php if ($settings['show_category'] === 'yes' && $cat_name): ?>
                                            <span class="jr-pc-cat"><?php echo $cat_name; ?></span>
                                        <?php endif; ?>

                                        <?php if ($settings['show_rating'] === 'yes' && $avg_rating > 0): ?>
                                            <div class="jr-pc-rating">
                                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                                    <i class="fas fa-star<?php echo $i <= round($avg_rating) ? '' : '-o'; ?>"></i>
                                                <?php endfor; ?>
                                                <span style="font-size:12px;color:#6b7280;">(<?php echo number_format($avg_rating, 1); ?>)</span>
                                            </div>
                                        <?php endif; ?>

                                        <h3 class="jr-pc-title">
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </h3>

                                        <div class="jr-pc-price">
                                            <?php if ($sale_price && $regular_price): ?>
                                                <span class="jr-pc-sale-price"><?php echo wp_kses_post(wc_price($sale_price)); ?></span>
                                                <span class="jr-pc-reg-price"><?php echo wp_kses_post(wc_price($regular_price)); ?></span>
                                            <?php else: ?>
                                                <span class="jr-pc-sale-price"><?php echo wp_kses_post($product->get_price_html()); ?></span>
                                            <?php endif; ?>
                                        </div>

                                        <?php if ($settings['show_add_to_cart'] === 'yes'): ?>
                                            <a href="?add-to-cart=<?php echo esc_attr($product->get_id()); ?>"
                                               class="jr-pc-btn add_to_cart_button ajax_add_to_cart"
                                               data-product_id="<?php echo esc_attr($product->get_id()); ?>"
                                               data-quantity="1"
                                               rel="nofollow">
                                                <?php if (!empty($settings['cart_icon']['value'])): ?>
                                                    <?php Icons_Manager::render_icon($settings['cart_icon'], ['aria-hidden' => 'true']); ?>
                                                <?php endif; ?>
                                                <span><?php echo esc_html($settings['add_cart_text']); ?></span>
                                            </a>
                                        <?php endif; ?>

                                    </div>

                                </div>
                            </div>

                        <?php endwhile; ?>
                        <?php wp_reset_postdata(); ?>
                    <?php else: ?>
                        <div class="swiper-slide">
                            <p style="text-align:center;padding:40px;color:#6b7280;">
                                <?php esc_html_e('No products found.', 'jr-addons'); ?>
                            </p>
                        </div>
                    <?php endif; ?>

                </div>

                <?php if ($settings['show_pagination'] === 'yes'): ?>
                    <div class="swiper-pagination"></div>
                <?php endif; ?>

            </div>

            <?php if ($settings['show_arrows'] === 'yes'): ?>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            <?php endif; ?>
        </div>

        <?php
    }
}