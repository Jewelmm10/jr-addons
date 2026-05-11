<?php
namespace JR_Addons\Elementor\Widgets;

if (!defined('ABSPATH')) exit;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Icons_Manager;

class HeaderIcons extends Widget_Base {

    public function get_name() { return 'jr_header_icons'; }
    public function get_title() { return esc_html__('JR Header Icons', 'jr-addons'); }
    public function get_icon() { return 'jr-get-icon'; }
    public function get_categories() { return ['jr-wc']; }
    public function get_keywords() { return ['cart', 'wishlist', 'account', 'tracking', 'header', 'icons']; }

    protected function register_controls() {

        /* ============================================================
         * SECTION: GENERAL
         * ============================================================ */
        $this->start_controls_section('section_general', [
            'label' => esc_html__('General', 'jr-addons'),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('show_labels', [
            'label'   => esc_html__('Show Labels', 'jr-addons'),
            'type'    => Controls_Manager::SWITCHER,
            'default' => 'no',
        ]);

        $this->end_controls_section();


        /* ============================================================
         * SECTION: ACCOUNT
         * ============================================================ */
        $this->start_controls_section('section_account', [
            'label' => esc_html__('👤 Account', 'jr-addons'),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('enable_account', [
            'label'        => esc_html__('Enable Account', 'jr-addons'),
            'type'         => Controls_Manager::SWITCHER,
            'default'      => 'yes',
        ]);

        $this->add_control('account_icon', [
            'label'     => esc_html__('Icon', 'jr-addons'),
            'type'      => Controls_Manager::ICONS,
            'default'   => ['value' => 'fas fa-user', 'library' => 'fa-solid'],
            'condition' => ['enable_account' => 'yes'],
        ]);

        $this->add_control('account_label', [
            'label'     => esc_html__('Label', 'jr-addons'),
            'type'      => Controls_Manager::TEXT,
            'default'   => esc_html__('Account', 'jr-addons'),
            'condition' => ['enable_account' => 'yes'],
        ]);

        $this->add_control('account_url', [
            'label'     => esc_html__('Custom URL', 'jr-addons'),
            'type'      => Controls_Manager::URL,
            'placeholder' => esc_html__('Leave empty for default My Account', 'jr-addons'),
            'condition' => ['enable_account' => 'yes'],
        ]);

        $this->end_controls_section();


        /* ============================================================
         * SECTION: WISHLIST
         * ============================================================ */
        $this->start_controls_section('section_wishlist', [
            'label' => esc_html__('❤️ Wishlist', 'jr-addons'),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('enable_wishlist', [
            'label'   => esc_html__('Enable Wishlist', 'jr-addons'),
            'type'    => Controls_Manager::SWITCHER,
            'default' => 'yes',
        ]);

        $this->add_control('wishlist_icon', [
            'label'     => esc_html__('Icon', 'jr-addons'),
            'type'      => Controls_Manager::ICONS,
            'default'   => ['value' => 'far fa-heart', 'library' => 'fa-regular'],
            'condition' => ['enable_wishlist' => 'yes'],
        ]);

        $this->add_control('wishlist_label', [
            'label'     => esc_html__('Label', 'jr-addons'),
            'type'      => Controls_Manager::TEXT,
            'default'   => esc_html__('Wishlist', 'jr-addons'),
            'condition' => ['enable_wishlist' => 'yes'],
        ]);

        $this->add_control('wishlist_url', [
            'label'     => esc_html__('Wishlist URL', 'jr-addons'),
            'type'      => Controls_Manager::URL,
            'default'   => ['url' => '/wishlist'],
            'condition' => ['enable_wishlist' => 'yes'],
        ]);

        $this->add_control('show_wishlist_count', [
            'label'     => esc_html__('Show Count Badge', 'jr-addons'),
            'type'      => Controls_Manager::SWITCHER,
            'default'   => 'yes',
            'condition' => ['enable_wishlist' => 'yes'],
        ]);

        $this->end_controls_section();


        /* ============================================================
         * SECTION: TRACKING
         * ============================================================ */
        $this->start_controls_section('section_tracking', [
            'label' => esc_html__('📦 Track Order', 'jr-addons'),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('enable_tracking', [
            'label'   => esc_html__('Enable Tracking', 'jr-addons'),
            'type'    => Controls_Manager::SWITCHER,
            'default' => 'yes',
        ]);

        $this->add_control('tracking_icon', [
            'label'     => esc_html__('Icon', 'jr-addons'),
            'type'      => Controls_Manager::ICONS,
            'default'   => ['value' => 'fas fa-truck', 'library' => 'fa-solid'],
            'condition' => ['enable_tracking' => 'yes'],
        ]);

        $this->add_control('tracking_label', [
            'label'     => esc_html__('Label', 'jr-addons'),
            'type'      => Controls_Manager::TEXT,
            'default'   => esc_html__('Track Order', 'jr-addons'),
            'condition' => ['enable_tracking' => 'yes'],
        ]);

        $this->add_control('tracking_url', [
            'label'     => esc_html__('Tracking URL', 'jr-addons'),
            'type'      => Controls_Manager::URL,
            'default'   => ['url' => '/order-tracking'],
            'condition' => ['enable_tracking' => 'yes'],
        ]);

        $this->end_controls_section();


        /* ============================================================
         * SECTION: COMPARE
         * ============================================================ */
        $this->start_controls_section('section_compare', [
            'label' => esc_html__('🔄 Compare', 'jr-addons'),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('enable_compare', [
            'label'   => esc_html__('Enable Compare', 'jr-addons'),
            'type'    => Controls_Manager::SWITCHER,
            'default' => 'no',
        ]);

        $this->add_control('compare_icon', [
            'label'     => esc_html__('Icon', 'jr-addons'),
            'type'      => Controls_Manager::ICONS,
            'default'   => ['value' => 'fas fa-exchange-alt', 'library' => 'fa-solid'],
            'condition' => ['enable_compare' => 'yes'],
        ]);

        $this->add_control('compare_label', [
            'label'     => esc_html__('Label', 'jr-addons'),
            'type'      => Controls_Manager::TEXT,
            'default'   => esc_html__('Compare', 'jr-addons'),
            'condition' => ['enable_compare' => 'yes'],
        ]);

        $this->add_control('compare_url', [
            'label'     => esc_html__('Compare URL', 'jr-addons'),
            'type'      => Controls_Manager::URL,
            'default'   => ['url' => '/compare'],
            'condition' => ['enable_compare' => 'yes'],
        ]);

        $this->end_controls_section();


        /* ============================================================
         * SECTION: CART
         * ============================================================ */
        $this->start_controls_section('section_cart', [
            'label' => esc_html__('🛒 Cart', 'jr-addons'),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('enable_cart', [
            'label'   => esc_html__('Enable Cart', 'jr-addons'),
            'type'    => Controls_Manager::SWITCHER,
            'default' => 'yes',
        ]);

        $this->add_control('cart_icon', [
            'label'     => esc_html__('Icon', 'jr-addons'),
            'type'      => Controls_Manager::ICONS,
            'default'   => ['value' => 'fas fa-shopping-bag', 'library' => 'fa-solid'],
            'condition' => ['enable_cart' => 'yes'],
        ]);

        $this->add_control('cart_label', [
            'label'     => esc_html__('Label', 'jr-addons'),
            'type'      => Controls_Manager::TEXT,
            'default'   => esc_html__('Cart', 'jr-addons'),
            'condition' => ['enable_cart' => 'yes'],
        ]);

        $this->add_control('cart_mode', [
            'label'   => esc_html__('Cart Display Mode', 'jr-addons'),
            'type'    => Controls_Manager::SELECT,
            'default' => 'drawer',
            'options' => [
                'hover'  => esc_html__('Hover Mini Cart (Dropdown)', 'jr-addons'),
                'drawer' => esc_html__('Side Drawer (Slide from Right)', 'jr-addons'),
                'both'   => esc_html__('Hover + Click Drawer', 'jr-addons'),
                'link'   => esc_html__('Direct Link to Cart Page', 'jr-addons'),
            ],
            'condition' => ['enable_cart' => 'yes'],
        ]);

        $this->add_control('drawer_position', [
            'label'   => esc_html__('Drawer Position', 'jr-addons'),
            'type'    => Controls_Manager::SELECT,
            'default' => 'right',
            'options' => [
                'right' => esc_html__('Right Side', 'jr-addons'),
                'left'  => esc_html__('Left Side', 'jr-addons'),
            ],
            'condition' => ['cart_mode' => ['drawer', 'both']],
        ]);

        $this->add_control('show_cart_total', [
            'label'     => esc_html__('Show Cart Total', 'jr-addons'),
            'type'      => Controls_Manager::SWITCHER,
            'default'   => 'no',
            'condition' => ['enable_cart' => 'yes'],
        ]);

        $this->end_controls_section();


        /* ============================================================
         * STYLE: ICONS
         * ============================================================ */
        $this->start_controls_section('style_icons', [
            'label' => esc_html__('Icons', 'jr-addons'),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_responsive_control('icons_gap', [
            'label'     => esc_html__('Gap Between Icons', 'jr-addons'),
            'type'      => Controls_Manager::SLIDER,
            'range'     => ['px' => ['min' => 0, 'max' => 60]],
            'default'   => ['unit' => 'px', 'size' => 20],
            'selectors' => ['{{WRAPPER}} .jr-header-icons' => 'gap: {{SIZE}}{{UNIT}};'],
        ]);

        $this->add_responsive_control('icons_align', [
            'label'   => esc_html__('Alignment', 'jr-addons'),
            'type'    => Controls_Manager::CHOOSE,
            'options' => [
                'flex-start' => ['title' => 'Left',   'icon' => 'eicon-text-align-left'],
                'center'     => ['title' => 'Center', 'icon' => 'eicon-text-align-center'],
                'flex-end'   => ['title' => 'Right',  'icon' => 'eicon-text-align-right'],
            ],
            'default'   => 'flex-end',
            'selectors' => ['{{WRAPPER}} .jr-header-icons' => 'justify-content: {{VALUE}};'],
        ]);

        $this->add_responsive_control('icon_size', [
            'label'     => esc_html__('Icon Size', 'jr-addons'),
            'type'      => Controls_Manager::SLIDER,
            'range'     => ['px' => ['min' => 12, 'max' => 50]],
            'default'   => ['unit' => 'px', 'size' => 22],
            'selectors' => [
                '{{WRAPPER}} .jr-icon-item svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .jr-icon-item i'   => 'font-size: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_responsive_control('icon_box_size', [
            'label'     => esc_html__('Box Size', 'jr-addons'),
            'type'      => Controls_Manager::SLIDER,
            'range'     => ['px' => ['min' => 30, 'max' => 80]],
            'default'   => ['unit' => 'px', 'size' => 42],
            'selectors' => [
                '{{WRAPPER}} .jr-icon-link' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->start_controls_tabs('icon_color_tabs');

        $this->start_controls_tab('icon_normal', ['label' => 'Normal']);
        $this->add_control('icon_color', [
            'label'     => esc_html__('Icon Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#111827',
            'selectors' => [
                '{{WRAPPER}} .jr-icon-link svg' => 'fill: {{VALUE}}; color: {{VALUE}};',
                '{{WRAPPER}} .jr-icon-link i, {{WRAPPER}} .jr-icon-label' => 'color: {{VALUE}};',
            ],
        ]);
        $this->add_control('icon_bg', [
            'label'     => esc_html__('Background', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .jr-icon-link' => 'background: {{VALUE}};'],
        ]);
        $this->end_controls_tab();

        $this->start_controls_tab('icon_hover', ['label' => 'Hover']);
        $this->add_control('icon_hover_color', [
            'label'     => esc_html__('Icon Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#2563eb',
            'selectors' => [
                '{{WRAPPER}} .jr-icon-link:hover svg' => 'fill: {{VALUE}}; color: {{VALUE}};',
                '{{WRAPPER}} .jr-icon-link:hover i, {{WRAPPER}} .jr-icon-link:hover .jr-icon-label' => 'color: {{VALUE}};',
            ],
        ]);
        $this->add_control('icon_hover_bg', [
            'label'     => esc_html__('Background', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .jr-icon-link:hover' => 'background: {{VALUE}};'],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control('icon_radius', [
            'label'      => esc_html__('Border Radius', 'jr-addons'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'default'    => ['top' => '50', 'right' => '50', 'bottom' => '50', 'left' => '50', 'unit' => '%'],
            'selectors'  => ['{{WRAPPER}} .jr-icon-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
        ]);

        $this->add_group_control(Group_Control_Border::get_type(), [
            'name'     => 'icon_border',
            'selector' => '{{WRAPPER}} .jr-icon-link',
        ]);

        $this->end_controls_section();


        /* ============================================================
         * STYLE: LABEL
         * ============================================================ */
        $this->start_controls_section('style_label', [
            'label'     => esc_html__('Label', 'jr-addons'),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => ['show_labels' => 'yes'],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name'     => 'label_typo',
            'selector' => '{{WRAPPER}} .jr-icon-label',
        ]);

        $this->add_responsive_control('label_gap', [
            'label'     => esc_html__('Gap from Icon', 'jr-addons'),
            'type'      => Controls_Manager::SLIDER,
            'range'     => ['px' => ['min' => 0, 'max' => 20]],
            'default'   => ['unit' => 'px', 'size' => 4],
            'selectors' => ['{{WRAPPER}} .jr-icon-link' => 'gap: {{SIZE}}{{UNIT}};'],
        ]);

        $this->end_controls_section();


        /* ============================================================
         * STYLE: BADGE (Count)
         * ============================================================ */
        $this->start_controls_section('style_badge', [
            'label' => esc_html__('Count Badge', 'jr-addons'),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('badge_color', [
            'label'     => esc_html__('Text Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => ['{{WRAPPER}} .jr-count-badge' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('badge_bg', [
            'label'     => esc_html__('Background', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#ef4444',
            'selectors' => ['{{WRAPPER}} .jr-count-badge' => 'background: {{VALUE}};'],
        ]);

        $this->add_responsive_control('badge_size', [
            'label'     => esc_html__('Size', 'jr-addons'),
            'type'      => Controls_Manager::SLIDER,
            'range'     => ['px' => ['min' => 14, 'max' => 30]],
            'default'   => ['unit' => 'px', 'size' => 18],
            'selectors' => [
                '{{WRAPPER}} .jr-count-badge' => 'min-width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_control('badge_font_size', [
            'label'     => esc_html__('Font Size', 'jr-addons'),
            'type'      => Controls_Manager::SLIDER,
            'range'     => ['px' => ['min' => 8, 'max' => 16]],
            'default'   => ['unit' => 'px', 'size' => 11],
            'selectors' => ['{{WRAPPER}} .jr-count-badge' => 'font-size: {{SIZE}}{{UNIT}};'],
        ]);

        $this->add_responsive_control('badge_position_top', [
            'label'     => esc_html__('Top Offset', 'jr-addons'),
            'type'      => Controls_Manager::SLIDER,
            'range'     => ['px' => ['min' => -10, 'max' => 20]],
            'default'   => ['unit' => 'px', 'size' => -2],
            'selectors' => ['{{WRAPPER}} .jr-count-badge' => 'top: {{SIZE}}{{UNIT}};'],
        ]);

        $this->add_responsive_control('badge_position_right', [
            'label'     => esc_html__('Right Offset', 'jr-addons'),
            'type'      => Controls_Manager::SLIDER,
            'range'     => ['px' => ['min' => -10, 'max' => 20]],
            'default'   => ['unit' => 'px', 'size' => -2],
            'selectors' => ['{{WRAPPER}} .jr-count-badge' => 'right: {{SIZE}}{{UNIT}};'],
        ]);

        $this->end_controls_section();


        /* ============================================================
         * STYLE: MINI CART (Hover)
         * ============================================================ */
        $this->start_controls_section('style_minicart', [
            'label'     => esc_html__('Mini Cart (Hover)', 'jr-addons'),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => ['cart_mode' => ['hover', 'both']],
        ]);

        $this->add_responsive_control('minicart_width', [
            'label'     => esc_html__('Width', 'jr-addons'),
            'type'      => Controls_Manager::SLIDER,
            'range'     => ['px' => ['min' => 250, 'max' => 500]],
            'default'   => ['unit' => 'px', 'size' => 340],
            'selectors' => ['{{WRAPPER}} .jr-minicart' => 'width: {{SIZE}}{{UNIT}};'],
        ]);

        $this->add_control('minicart_bg', [
            'label'     => esc_html__('Background', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => ['{{WRAPPER}} .jr-minicart' => 'background: {{VALUE}};'],
        ]);

        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name'     => 'minicart_shadow',
            'selector' => '{{WRAPPER}} .jr-minicart',
        ]);

        $this->end_controls_section();


        /* ============================================================
         * STYLE: SIDE DRAWER
         * ============================================================ */
        $this->start_controls_section('style_drawer', [
            'label'     => esc_html__('Side Drawer Cart', 'jr-addons'),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => ['cart_mode' => ['drawer', 'both']],
        ]);

        $this->add_responsive_control('drawer_width', [
            'label'     => esc_html__('Drawer Width', 'jr-addons'),
            'type'      => Controls_Manager::SLIDER,
            'range'     => ['px' => ['min' => 300, 'max' => 600]],
            'default'   => ['unit' => 'px', 'size' => 420],
            'selectors' => ['{{WRAPPER}} .jr-cart-drawer' => 'width: {{SIZE}}{{UNIT}};'],
        ]);

        $this->add_control('drawer_bg', [
            'label'     => esc_html__('Background', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => ['{{WRAPPER}} .jr-cart-drawer' => 'background: {{VALUE}};'],
        ]);

        $this->add_control('drawer_header_bg', [
            'label'     => esc_html__('Header Background', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#f9fafb',
            'selectors' => ['{{WRAPPER}} .jr-drawer-header' => 'background: {{VALUE}};'],
        ]);

        $this->add_control('drawer_header_text', [
            'label'     => esc_html__('Header Text Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#111827',
            'selectors' => ['{{WRAPPER}} .jr-drawer-header h3, {{WRAPPER}} .jr-drawer-close' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('overlay_color', [
            'label'     => esc_html__('Overlay Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => 'rgba(0,0,0,0.5)',
            'selectors' => ['{{WRAPPER}} .jr-drawer-overlay' => 'background: {{VALUE}};'],
        ]);

        $this->end_controls_section();

        /* ============================================================
        * STYLE: MINI CART ITEMS
        * ============================================================ */
        $this->start_controls_section('style_minicart_items', [
            'label'     => esc_html__('Mini Cart Items', 'jr-addons'),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => ['enable_cart' => 'yes'],
        ]);

        // Item Image
        $this->add_responsive_control('item_img_size', [
            'label'     => esc_html__('Image Size', 'jr-addons'),
            'type'      => Controls_Manager::SLIDER,
            'range'     => ['px' => ['min' => 50, 'max' => 120]],
            'default'   => ['unit' => 'px', 'size' => 70],
            'selectors' => [
                '{{WRAPPER}} .jr-cart-item-thumb' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_responsive_control('item_img_radius', [
            'label'      => esc_html__('Image Radius', 'jr-addons'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'default'    => ['top'=>'8','right'=>'8','bottom'=>'8','left'=>'8','unit'=>'px'],
            'selectors'  => [
                '{{WRAPPER}} .jr-cart-item-thumb' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_control('item_divider_1', ['type' => Controls_Manager::DIVIDER]);

        // Product Name
        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name'     => 'item_name_typo',
            'label'    => esc_html__('Name Typography', 'jr-addons'),
            'selector' => '{{WRAPPER}} .jr-cart-item-name',
        ]);

        $this->add_control('item_name_color', [
            'label'     => esc_html__('Name Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#111827',
            'selectors' => ['{{WRAPPER}} .jr-cart-item-name' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('item_name_hover_color', [
            'label'     => esc_html__('Name Hover Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#2563eb',
            'selectors' => ['{{WRAPPER}} .jr-cart-item-name:hover' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('item_divider_2', ['type' => Controls_Manager::DIVIDER]);

        // Price
        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name'     => 'item_price_typo',
            'label'    => esc_html__('Price Typography', 'jr-addons'),
            'selector' => '{{WRAPPER}} .jr-cart-item-price',
        ]);

        $this->add_control('item_price_color', [
            'label'     => esc_html__('Price Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#2563eb',
            'selectors' => ['{{WRAPPER}} .jr-cart-item-price' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('item_divider_3', ['type' => Controls_Manager::DIVIDER]);

        // Quantity Box
        $this->add_control('qty_btn_color', [
            'label'     => esc_html__('Qty Button Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#374151',
            'selectors' => ['{{WRAPPER}} .jr-qty-btn' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('qty_btn_bg', [
            'label'     => esc_html__('Qty Button Background', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#f9fafb',
            'selectors' => ['{{WRAPPER}} .jr-qty-btn' => 'background: {{VALUE}};'],
        ]);

        $this->add_control('qty_btn_hover_color', [
            'label'     => esc_html__('Qty Button Hover Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => ['{{WRAPPER}} .jr-qty-btn:hover' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('qty_btn_hover_bg', [
            'label'     => esc_html__('Qty Button Hover Background', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#2563eb',
            'selectors' => ['{{WRAPPER}} .jr-qty-btn:hover' => 'background: {{VALUE}};'],
        ]);

        $this->add_control('item_divider_4', ['type' => Controls_Manager::DIVIDER]);

        // Remove Button
        $this->add_control('remove_color', [
            'label'     => esc_html__('Remove Icon Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#9ca3af',
            'selectors' => ['{{WRAPPER}} .jr-cart-remove' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('remove_hover_color', [
            'label'     => esc_html__('Remove Hover Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#ef4444',
            'selectors' => ['{{WRAPPER}} .jr-cart-remove:hover' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('remove_hover_bg', [
            'label'     => esc_html__('Remove Hover Background', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#fef2f2',
            'selectors' => ['{{WRAPPER}} .jr-cart-remove:hover' => 'background: {{VALUE}};'],
        ]);

        $this->end_controls_section();


        /* ============================================================
        * STYLE: MINI CART FOOTER (Subtotal + Buttons)
        * ============================================================ */
        $this->start_controls_section('style_minicart_footer', [
            'label'     => esc_html__('Mini Cart Footer', 'jr-addons'),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => ['enable_cart' => 'yes'],
        ]);

        // Subtotal
        $this->add_control('subtotal_label_color', [
            'label'     => esc_html__('Subtotal Label Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#6b7280',
            'selectors' => ['{{WRAPPER}} .jr-subtotal-label' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('subtotal_amount_color', [
            'label'     => esc_html__('Subtotal Amount Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#111827',
            'selectors' => ['{{WRAPPER}} .jr-subtotal-amount' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('subtotal_size', [
            'label'     => esc_html__('Subtotal Font Size', 'jr-addons'),
            'type'      => Controls_Manager::SLIDER,
            'range'     => ['px' => ['min' => 14, 'max' => 28]],
            'default'   => ['unit' => 'px', 'size' => 18],
            'selectors' => ['{{WRAPPER}} .jr-subtotal-amount' => 'font-size: {{SIZE}}{{UNIT}};'],
        ]);

        $this->add_control('footer_divider_1', ['type' => Controls_Manager::DIVIDER]);

        // View Cart Button
        $this->add_control('btn_cart_heading', [
            'label' => esc_html__('View Cart Button', 'jr-addons'),
            'type'  => Controls_Manager::HEADING,
        ]);

        $this->start_controls_tabs('btn_cart_tabs');

        $this->start_controls_tab('btn_cart_normal', ['label' => 'Normal']);
        $this->add_control('btn_cart_color', [
            'label'     => esc_html__('Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#374151',
            'selectors' => ['{{WRAPPER}} .jr-btn-cart' => 'color: {{VALUE}};'],
        ]);
        $this->add_control('btn_cart_bg', [
            'label'     => esc_html__('Background', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#f3f4f6',
            'selectors' => ['{{WRAPPER}} .jr-btn-cart' => 'background: {{VALUE}};'],
        ]);
        $this->end_controls_tab();

        $this->start_controls_tab('btn_cart_hover', ['label' => 'Hover']);
        $this->add_control('btn_cart_hover_color', [
            'label'     => esc_html__('Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#111827',
            'selectors' => ['{{WRAPPER}} .jr-btn-cart:hover' => 'color: {{VALUE}};'],
        ]);
        $this->add_control('btn_cart_hover_bg', [
            'label'     => esc_html__('Background', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#e5e7eb',
            'selectors' => ['{{WRAPPER}} .jr-btn-cart:hover' => 'background: {{VALUE}};'],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control('footer_divider_2', ['type' => Controls_Manager::DIVIDER]);

        // Checkout Button
        $this->add_control('btn_checkout_heading', [
            'label' => esc_html__('Checkout Button', 'jr-addons'),
            'type'  => Controls_Manager::HEADING,
        ]);

        $this->start_controls_tabs('btn_checkout_tabs');

        $this->start_controls_tab('btn_checkout_normal', ['label' => 'Normal']);
        $this->add_control('btn_checkout_color', [
            'label'     => esc_html__('Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => [
                '{{WRAPPER}} .jr-btn-checkout, {{WRAPPER}} .jr-btn-checkout svg' => 'color: {{VALUE}}; stroke: {{VALUE}};',
            ],
        ]);
        $this->add_control('btn_checkout_bg', [
            'label'     => esc_html__('Background', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#2563eb',
            'selectors' => ['{{WRAPPER}} .jr-btn-checkout' => 'background: {{VALUE}};'],
        ]);
        $this->end_controls_tab();

        $this->start_controls_tab('btn_checkout_hover', ['label' => 'Hover']);
        $this->add_control('btn_checkout_hover_color', [
            'label'     => esc_html__('Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => [
                '{{WRAPPER}} .jr-btn-checkout:hover, {{WRAPPER}} .jr-btn-checkout:hover svg' => 'color: {{VALUE}}; stroke: {{VALUE}};',
            ],
        ]);
        $this->add_control('btn_checkout_hover_bg', [
            'label'     => esc_html__('Background', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#1d4ed8',
            'selectors' => ['{{WRAPPER}} .jr-btn-checkout:hover' => 'background: {{VALUE}};'],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control('btn_padding', [
            'label'      => esc_html__('Buttons Padding', 'jr-addons'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'default'    => ['top'=>'12','right'=>'16','bottom'=>'12','left'=>'16','unit'=>'px'],
            'selectors'  => ['{{WRAPPER}} .jr-cart-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
        ]);

        $this->add_responsive_control('btn_radius', [
            'label'      => esc_html__('Buttons Radius', 'jr-addons'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'default'    => ['top'=>'8','right'=>'8','bottom'=>'8','left'=>'8','unit'=>'px'],
            'selectors'  => ['{{WRAPPER}} .jr-cart-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
        ]);

        $this->end_controls_section();
    }


    protected function render() {
        $settings = $this->get_settings_for_display();
        $widget_id = $this->get_id();
        $show_labels = $settings['show_labels'] === 'yes';

        // WooCommerce data
        $cart_count = (class_exists('WooCommerce') && WC()->cart) ? WC()->cart->get_cart_contents_count() : 0;
        $cart_total = (class_exists('WooCommerce') && WC()->cart) ? WC()->cart->get_cart_subtotal() : '';
        $wishlist_count = $this->get_wishlist_count();
        $cart_mode = $settings['cart_mode'] ?? 'drawer';
        $drawer_pos = $settings['drawer_position'] ?? 'right';
        ?>

        <style>
            /* Wrapper */
            .jr-header-icons{display:flex;align-items:center;flex-wrap:wrap}
            
            /* Icon Item */
            .jr-icon-item{position:relative;display:flex;align-items:center}
            .jr-icon-link{display:flex;align-items:center;justify-content:center;text-decoration:none;position:relative;transition:all .3s ease;flex-shrink:0}
            .jr-icon-link svg,.jr-icon-link i{transition:all .3s ease;line-height:1}
            .jr-icon-label{font-weight:500;white-space:nowrap}
            
            /* Count Badge */
            .jr-count-badge{position:absolute;display:flex;align-items:center;justify-content:center;border-radius:50%;font-weight:600;padding:0 5px;line-height:1;z-index:2}
            
            /* Mini Cart (Hover Dropdown) */
            .jr-cart-wrapper{position:relative}
            .jr-minicart{position:absolute;top:calc(100% + 15px);right:0;background:#fff;border-radius:8px;box-shadow:0 10px 40px rgba(0,0,0,.12);opacity:0;visibility:hidden;transform:translateY(10px);transition:all .3s ease;z-index:9999;padding:20px}
            .jr-cart-wrapper:hover .jr-minicart{opacity:1;visibility:visible;transform:translateY(0)}
            .jr-minicart:before{content:'';position:absolute;top:-20px;left:0;right:0;height:20px}
            
            /* Side Drawer */
            .jr-drawer-overlay{position:fixed;inset:0;background:rgba(0,0,0,.5);opacity:0;visibility:hidden;transition:all .3s ease;z-index:99998}
            .jr-drawer-overlay.active{opacity:1;visibility:visible}
            
            .jr-cart-drawer{position:fixed;top:0;height:100vh;background:#fff;box-shadow:0 0 30px rgba(0,0,0,.2);z-index:99999;display:flex;flex-direction:column;transition:transform .35s cubic-bezier(.4,0,.2,1)}
            .jr-cart-drawer.from-right{right:0;transform:translateX(100%)}
            .jr-cart-drawer.from-left{left:0;transform:translateX(-100%)}
            .jr-cart-drawer.active{transform:translateX(0)}
            
            .jr-drawer-header{display:flex;align-items:center;justify-content:space-between;padding:20px 25px;border-bottom:1px solid #e5e7eb;background:#f9fafb}
            .jr-drawer-header h3{margin:0;font-size:18px;font-weight:600}
            .jr-drawer-close{background:transparent;border:none;cursor:pointer;font-size:24px;line-height:1;padding:0;color:#111827;transition:transform .2s ease}
            .jr-drawer-close:hover{transform:rotate(90deg)}
            
            .jr-drawer-body{flex:1;overflow-y:auto;padding:20px 25px}
            .jr-drawer-body::-webkit-scrollbar{width:6px}
            .jr-drawer-body::-webkit-scrollbar-thumb{background:#d1d5db;border-radius:10px}
            
            .jr-drawer-body .woocommerce-mini-cart{margin:0;padding:0;list-style:none}
            .jr-drawer-body .woocommerce-mini-cart__buttons{display:flex;gap:10px;flex-wrap:wrap;margin-top:20px}
            .jr-drawer-body .woocommerce-mini-cart__buttons .button{flex:1;text-align:center;padding:12px 20px;border-radius:6px;font-weight:600}
            
            /* Cart Total in Icon */
            .jr-cart-total{font-size:13px;font-weight:600;margin-left:6px}
            
            /* Empty Cart */
            .jr-empty-cart{text-align:center;padding:40px 20px;color:#6b7280}
            
            /* Mobile */
            @media(max-width:768px){
                .jr-cart-drawer{width:100%!important;max-width:400px}
                .jr-icon-label{display:none}
            }
            /* ============================================================
            * MINI CART CUSTOM DESIGN
            * ============================================================ */
            .jr-mini-cart-content{font-family:inherit}

            /* Empty State */
            .jr-cart-empty{text-align:center;padding:40px 20px}
            .jr-empty-icon{color:#d1d5db;margin-bottom:15px;display:flex;justify-content:center}
            .jr-cart-empty h4{font-size:16px;font-weight:600;color:#111827;margin:0 0 8px}
            .jr-cart-empty p{font-size:13px;color:#6b7280;margin:0 0 20px}
            .jr-cart-shop-btn{display:inline-block;padding:10px 24px;background:#2563eb;color:#fff;text-decoration:none;border-radius:6px;font-weight:600;font-size:14px;transition:all .3s ease}
            .jr-cart-shop-btn:hover{background:#1d4ed8;color:#fff;transform:translateY(-1px)}

            /* Cart Items List */
            .jr-cart-items{list-style:none;padding:0;margin:0 0 15px}

            /* Single Item */
            .jr-cart-item{display:flex;gap:12px;padding:15px 0;border-bottom:1px solid #f3f4f6;position:relative;transition:opacity .3s ease}
            .jr-cart-item:last-child{border-bottom:none}
            .jr-cart-item.jr-removing{opacity:.4;pointer-events:none}

            /* Item Image */
            .jr-cart-item-thumb{flex-shrink:0;width:70px;height:70px;border-radius:8px;overflow:hidden;background:#f9fafb;display:block}
            .jr-cart-item-thumb img,
            .jr-cart-item-img{width:100%!important;height:100%!important;object-fit:cover;display:block}

            /* Item Details */
            .jr-cart-item-details{flex:1;min-width:0;display:flex;flex-direction:column;gap:6px}
            .jr-cart-item-name{font-size:14px;font-weight:600;color:#111827;text-decoration:none;line-height:1.4;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;transition:color .2s ease}
            .jr-cart-item-name:hover{color:#2563eb}
            .jr-cart-item-price{font-size:13px;font-weight:600;color:#2563eb}
            .jr-cart-item-price .quantity{display:none}

            /* Item Actions */
            .jr-cart-item-actions{display:flex;align-items:center;justify-content:space-between;margin-top:6px;gap:10px}

            /* Quantity Controls */
            /* Quantity Controls - Mini Cart Specific */
.jr-cart-qty{
    display:flex;
    align-items:center;
    border:1px solid #e5e7eb;
    border-radius:6px;
    overflow:hidden;
    background:#fff
}
.jr-mini-qty-btn{
    width:28px;
    height:28px;
    border:none;
    background:#f9fafb;
    cursor:pointer;
    font-size:16px;
    font-weight:600;
    color:#374151;
    display:flex;
    align-items:center;
    justify-content:center;
    transition:all .2s ease;
    line-height:1
}
.jr-mini-qty-btn:hover{
    background:#2563eb;
    color:#fff
}
.jr-mini-qty-btn:disabled{
    opacity:.5;
    cursor:not-allowed
}
.jr-mini-qty-input{
    width:36px;
    height:28px;
    border:none;
    text-align:center;
    font-size:13px;
    font-weight:600;
    color:#111827;
    background:#fff;
    -moz-appearance:textfield
}
.jr-mini-qty-input::-webkit-outer-spin-button,
.jr-mini-qty-input::-webkit-inner-spin-button{
    -webkit-appearance:none;
    margin:0
}

            /* Remove Button */
            .jr-cart-remove{width:28px;height:28px;border:none;background:transparent;cursor:pointer;color:#9ca3af;display:flex;align-items:center;justify-content:center;border-radius:6px;transition:all .2s ease;padding:0}
            .jr-cart-remove:hover{background:#fef2f2;color:#ef4444}

            /* Footer */
            .jr-cart-footer{border-top:2px solid #f3f4f6;padding-top:15px;margin-top:10px}
            .jr-cart-subtotal,.jr-cart-shipping{display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;font-size:14px}
            .jr-subtotal-label{color:#6b7280;font-weight:500}
            .jr-subtotal-amount{color:#111827;font-weight:700;font-size:18px}
            .jr-cart-shipping{font-size:13px;color:#6b7280}

            /* Buttons */
            .jr-cart-buttons{display:flex;gap:10px;margin-top:15px}
            .jr-cart-btn{flex:1;display:flex;align-items:center;justify-content:center;gap:6px;padding:12px 16px;border-radius:8px;font-size:14px;font-weight:600;text-decoration:none;text-align:center;transition:all .3s ease;cursor:pointer;border:none}
            .jr-btn-cart{background:#f3f4f6;color:#374151}
            .jr-btn-cart:hover{background:#e5e7eb;color:#111827}
            .jr-btn-checkout{background:#2563eb;color:#fff}
            .jr-btn-checkout:hover{background:#1d4ed8;color:#fff;transform:translateY(-2px);box-shadow:0 4px 12px rgba(37,99,235,.3)}

            /* Loading State */
            .jr-cart-loading{position:relative;pointer-events:none;opacity:.6}
            .jr-cart-loading:after{content:'';position:absolute;top:50%;left:50%;width:30px;height:30px;margin:-15px 0 0 -15px;border:3px solid #e5e7eb;border-top-color:#2563eb;border-radius:50%;animation:jr-spin .8s linear infinite}

            /* Hide default WC mini cart styles */
            .widget_shopping_cart .product_list_widget,
            .widget_shopping_cart_content > .woocommerce-mini-cart{margin:0;padding:0}
        </style>

        <div class="jr-header-icons" data-widget-id="<?php echo esc_attr($widget_id); ?>">

            <?php /* ============= ACCOUNT ============= */ ?>
            <?php if ($settings['enable_account'] === 'yes'): 
                $account_url = !empty($settings['account_url']['url']) 
                    ? $settings['account_url']['url'] 
                    : (function_exists('wc_get_account_endpoint_url') ? wc_get_account_endpoint_url('dashboard') : '#');
            ?>
                <div class="jr-icon-item jr-account-item">
                    <a href="<?php echo esc_url($account_url); ?>" class="jr-icon-link" aria-label="<?php echo esc_attr($settings['account_label']); ?>">
                        <?php Icons_Manager::render_icon($settings['account_icon'], ['aria-hidden' => 'true']); ?>
                        <?php if ($show_labels): ?>
                            <span class="jr-icon-label"><?php echo esc_html($settings['account_label']); ?></span>
                        <?php endif; ?>
                    </a>
                </div>
            <?php endif; ?>

            <?php /* ============= WISHLIST ============= */ ?>
            <?php if ($settings['enable_wishlist'] === 'yes'): ?>
                <div class="jr-icon-item jr-wishlist-item">
                    <a href="<?php echo esc_url($settings['wishlist_url']['url']); ?>" class="jr-icon-link" aria-label="<?php echo esc_attr($settings['wishlist_label']); ?>">
                        <?php Icons_Manager::render_icon($settings['wishlist_icon'], ['aria-hidden' => 'true']); ?>
                        <?php if ($show_labels): ?>
                            <span class="jr-icon-label"><?php echo esc_html($settings['wishlist_label']); ?></span>
                        <?php endif; ?>
                        <?php if ($settings['show_wishlist_count'] === 'yes'): ?>
                            <span class="jr-count-badge jr-wishlist-count"><?php echo esc_html($wishlist_count); ?></span>
                        <?php endif; ?>
                    </a>
                </div>
            <?php endif; ?>

            <?php /* ============= COMPARE ============= */ ?>
            <?php if ($settings['enable_compare'] === 'yes'): ?>
                <div class="jr-icon-item jr-compare-item">
                    <a href="<?php echo esc_url($settings['compare_url']['url']); ?>" class="jr-icon-link" aria-label="<?php echo esc_attr($settings['compare_label']); ?>">
                        <?php Icons_Manager::render_icon($settings['compare_icon'], ['aria-hidden' => 'true']); ?>
                        <?php if ($show_labels): ?>
                            <span class="jr-icon-label"><?php echo esc_html($settings['compare_label']); ?></span>
                        <?php endif; ?>
                    </a>
                </div>
            <?php endif; ?>

            <?php /* ============= TRACKING ============= */ ?>
            <?php if ($settings['enable_tracking'] === 'yes'): ?>
                <div class="jr-icon-item jr-tracking-item">
                    <a href="<?php echo esc_url($settings['tracking_url']['url']); ?>" class="jr-icon-link" aria-label="<?php echo esc_attr($settings['tracking_label']); ?>">
                        <?php Icons_Manager::render_icon($settings['tracking_icon'], ['aria-hidden' => 'true']); ?>
                        <?php if ($show_labels): ?>
                            <span class="jr-icon-label"><?php echo esc_html($settings['tracking_label']); ?></span>
                        <?php endif; ?>
                    </a>
                </div>
            <?php endif; ?>

            <?php /* ============= CART ============= */ ?>
            <?php if ($settings['enable_cart'] === 'yes' && class_exists('WooCommerce')): ?>
                <div class="jr-icon-item jr-cart-wrapper" data-mode="<?php echo esc_attr($cart_mode); ?>">
                    
                    <?php
                    $cart_url = wc_get_cart_url();
                    $is_drawer = in_array($cart_mode, ['drawer', 'both']);
                    $tag = ($cart_mode === 'link') ? 'a' : 'a';
                    ?>
                    
                    <a href="<?php echo esc_url($cart_url); ?>" 
                       class="jr-icon-link jr-cart-trigger" 
                       data-cart-mode="<?php echo esc_attr($cart_mode); ?>"
                       aria-label="<?php echo esc_attr($settings['cart_label']); ?>">
                        
                        <?php Icons_Manager::render_icon($settings['cart_icon'], ['aria-hidden' => 'true']); ?>
                        
                        <?php if ($show_labels): ?>
                            <span class="jr-icon-label"><?php echo esc_html($settings['cart_label']); ?></span>
                        <?php endif; ?>
                        
                        <?php if ($settings['show_cart_total'] === 'yes' && $cart_total): ?>
                            <span class="jr-cart-total"><?php echo wp_kses_post($cart_total); ?></span>
                        <?php endif; ?>
                        
                        <span class="jr-count-badge jr-cart-count"><?php echo esc_html($cart_count); ?></span>
                    </a>

                    <?php if (in_array($cart_mode, ['hover', 'both'])): ?>
                        <div class="jr-minicart">
                            <div class="widget_shopping_cart_content">
                                <?php \JR_Addons\Tools\MiniCart::render(); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

        </div>

        <?php /* ============= SIDE DRAWER (Outside main wrapper) ============= */ ?>
        <?php if ($settings['enable_cart'] === 'yes' && in_array($cart_mode, ['drawer', 'both']) && class_exists('WooCommerce')): ?>
            <div class="jr-drawer-overlay"></div>
            <div class="jr-cart-drawer from-<?php echo esc_attr($drawer_pos); ?>">
                <div class="jr-drawer-header">
                    <h3>🛒 <?php esc_html_e('Your Cart', 'jr-addons'); ?> (<span class="jr-drawer-count"><?php echo esc_html($cart_count); ?></span>)</h3>
                    <button class="jr-drawer-close" aria-label="Close">×</button>
                </div>
                <div class="jr-drawer-body">
                    <div class="widget_shopping_cart_content">
                        <?php \JR_Addons\Tools\MiniCart::render(); ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php
    }


    /**
     * Get wishlist count - supports popular plugins
     */
    private function get_wishlist_count() {
        // YITH Wishlist
        if (function_exists('yith_wcwl_count_all_products')) {
            return yith_wcwl_count_all_products();
        }
        // TI Wishlist
        if (function_exists('tinv_wishlist_get')) {
            $wishlist = tinv_wishlist_get();
            return $wishlist ? count($wishlist) : 0;
        }
        // Cookie based fallback
        if (isset($_COOKIE['jr_wishlist'])) {
            $items = explode(',', $_COOKIE['jr_wishlist']);
            return count(array_filter($items));
        }
        return 0;
    }
}