<?php

namespace JR_Addons\Elementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if (!defined('ABSPATH')) exit;

class NavMenu extends Widget_Base {

    public function get_name() { return 'jr_nav_menu'; }
    public function get_title() { return 'JR Navigation Menu'; }
    public function get_icon() { return 'jr-get-icon'; }
    public function get_categories() { return ['jr-addons']; }

    protected function register_controls() {

        /* Content */
        $this->start_controls_section('content_section', [
            'label' => 'Menu Settings'
        ]);

        $menus = wp_get_nav_menus();
        $options = [];
        foreach ($menus as $menu) {
            $options[$menu->slug] = $menu->name;
        }

        $this->add_control('menu', [
            'label'   => 'Select Menu',
            'type'    => Controls_Manager::SELECT,
            'options' => $options,
        ]);

        $this->add_control('layout', [
            'label'   => 'Menu Layout',
            'type'    => Controls_Manager::SELECT,
            'default' => 'horizontal',
            'options' => [
                'horizontal' => 'Horizontal (Header)',
                'vertical'   => 'Vertical (Footer)',
            ],
        ]);

        $this->add_responsive_control('menu_align', [
            'label'     => 'Alignment',
            'type'      => Controls_Manager::CHOOSE,
            'options'   => [
                'flex-start' => ['title' => 'Left', 'icon' => 'eicon-text-align-left'],
                'center'     => ['title' => 'Center', 'icon' => 'eicon-text-align-center'],
                'flex-end'   => ['title' => 'Right', 'icon' => 'eicon-text-align-right'],
            ],
            'selectors' => ['{{WRAPPER}} .jr-menu' => 'justify-content: {{VALUE}};'],
        ]);

        $this->add_responsive_control('item_gap', [
            'label'     => 'Item Gap',
            'type'      => Controls_Manager::SLIDER,
            'range'     => ['px' => ['min' => 0, 'max' => 100]],
            'selectors' => ['{{WRAPPER}} .jr-menu' => 'gap: {{SIZE}}{{UNIT}};'],
        ]);

        $this->end_controls_section();

        /* Menu Style */
        $this->start_controls_section('section_style_menu', [
            'label' => 'Menu Items',
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name'     => 'menu_typography',
            'selector' => '{{WRAPPER}} .jr-menu > li > a',
        ]);

        $this->start_controls_tabs('menu_tabs');
        $this->start_controls_tab('menu_normal', ['label' => 'Normal']);
        $this->add_control('menu_color', ['label' => 'Text Color', 'type' => Controls_Manager::COLOR, 'selectors' => ['{{WRAPPER}} .jr-menu > li > a' => 'color: {{VALUE}};']]);
        $this->end_controls_tab();

        $this->start_controls_tab('menu_hover', ['label' => 'Hover']);
        $this->add_control('menu_hover_color', ['label' => 'Hover Color', 'type' => Controls_Manager::COLOR, 'selectors' => ['{{WRAPPER}} .jr-menu > li > a:hover' => 'color: {{VALUE}};']]);
        $this->end_controls_tab();

        $this->start_controls_tab('menu_active', ['label' => 'Active']);
        $this->add_control('menu_active_color', ['label' => 'Active Color', 'type' => Controls_Manager::COLOR, 'selectors' => ['{{WRAPPER}} .jr-menu > li.current-menu-item > a' => 'color: {{VALUE}};']]);
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_responsive_control('menu_padding', [
            'label'     => 'Padding',
            'type'      => Controls_Manager::DIMENSIONS,
            'selectors' => ['{{WRAPPER}} .jr-menu > li > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
        ]);

        $this->end_controls_section();

        /* Submenu Style */
        $this->start_controls_section('section_style_submenu', [
            'label' => 'Submenu',
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('submenu_bg', [
            'label'     => 'Background Color',
            'type'      => Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => ['{{WRAPPER}} .jr-menu ul' => 'background-color: {{VALUE}};'],
        ]);

        $this->add_control('submenu_color', [
            'label'     => 'Text Color',
            'type'      => Controls_Manager::COLOR,
            'default'   => '#333333',
            'selectors' => ['{{WRAPPER}} .jr-menu ul li a' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('submenu_hover_color', [
            'label'     => 'Hover Color',
            'type'      => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .jr-menu ul li a:hover' => 'color: {{VALUE}};'],
        ]);

        $this->end_controls_section();

        /* Mobile Style */
        $this->start_controls_section('section_style_mobile', [
            'label' => 'Hamburger & Mobile Menu',
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('hamburger_color', [
            'label'     => 'Hamburger Color',
            'type'      => Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => ['{{WRAPPER}} .jr-hamburger' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('mobile_bg', [
            'label'     => 'Mobile Background',
            'type'      => Controls_Manager::COLOR,
            'default'   => '#111111',
            'selectors' => ['{{WRAPPER}} .jr-offcanvas' => 'background-color: {{VALUE}};'],
        ]);

        $this->add_control('mobile_item_color', [
            'label'     => 'Mobile Text Color',
            'type'      => Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => ['{{WRAPPER}} .jr-mobile-menu li a' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('mobile_item_border', [
            'label'     => 'Mobile Border Color',
            'type'      => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .jr-mobile-menu li' => 'border-bottom: 1px solid {{VALUE}};'],
        ]);

        $this->end_controls_section();
    }

        protected function render() {
        $settings = $this->get_settings_for_display();
        if (empty($settings['menu'])) return;

        $layout = $settings['layout'] ?? 'horizontal';
        ?>

        <div class="jr-nav-wrapper jr-layout-<?php echo esc_attr($layout); ?>">

            <?php if ($layout === 'horizontal'): ?>
                <button class="jr-hamburger">☰</button>
            <?php endif; ?>

            <nav class="jr-desktop-menu">
                <?php
                wp_nav_menu([
                    'menu'        => $settings['menu'],
                    'container'   => false,
                    'menu_class'  => 'jr-menu',
                    'fallback_cb' => false,
                    'depth'       => 3,
                ]);
                ?>
            </nav>

            <?php if ($layout === 'horizontal'): ?>
            <div class="jr-overlay"></div>
            <div class="jr-offcanvas">
                <div class="jr-offcanvas-inner">
                    <button class="jr-close">✕</button>
                    <?php
                    wp_nav_menu([
                        'menu'        => $settings['menu'],
                        'container'   => false,
                        'menu_class'  => 'jr-mobile-menu',
                        'depth'       => 3,
                    ]);
                    ?>
                </div>
            </div>
            <?php endif; ?>

        </div>

        <style>
        .jr-menu {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }

        .jr-layout-vertical .jr-menu {
            flex-direction: column;
        }

        .jr-menu li { position: relative; }

        /* Submenu Desktop */
        .jr-menu ul {
            position: absolute;
            top: 100%;
            left: 0;
            display: none;
            min-width: 220px;
            background: #fff;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            z-index: 999;
            padding: 10px 0;
            margin: 0;
        }

        .jr-layout-vertical .jr-menu ul {
            position: static;
            box-shadow: none;
            padding-left: 20px;
            display: none;
        }

        .jr-menu li:hover > ul,
        .jr-menu li.current-menu-ancestor > ul {
            display: block;
        }

        .jr-menu a { 
            text-decoration: none; 
            display: block; 
        }

        /* Arrow - Only Horizontal Header */
        .jr-layout-horizontal .jr-menu li.menu-item-has-children > a::after {
            content: " ▼";
            font-size: 10px;
            margin-left: 5px;
        }

        .jr-layout-vertical .menu-item-has-children > a::after {
            content: none !important;
        }

        /* Mobile Styles */
        @media (max-width: 1024px) {
            .jr-layout-horizontal .jr-desktop-menu { display: none !important; }
        }

        @media (min-width: 1025px) {
            .jr-hamburger, .jr-offcanvas, .jr-overlay { display: none !important; }
        }

        .jr-layout-vertical .jr-hamburger,
        .jr-layout-vertical .jr-offcanvas { display: none !important; }
        </style>

        <?php if ($layout === 'horizontal'): ?>
        <script>
        // Mobile script (same as before)
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".jr-nav-wrapper").forEach(wrapper => {
                const hamburger = wrapper.querySelector(".jr-hamburger");
                const offcanvas = wrapper.querySelector(".jr-offcanvas");
                const overlay = wrapper.querySelector(".jr-overlay");
                const closeBtn = wrapper.querySelector(".jr-close");

                if (hamburger) {
                    hamburger.addEventListener("click", () => {
                        offcanvas.classList.add("active");
                        overlay.classList.add("active");
                        document.body.style.overflow = "hidden";
                    });
                }

                const closeMenu = () => {
                    offcanvas.classList.remove("active");
                    overlay.classList.remove("active");
                    document.body.style.overflow = "";
                };

                if (closeBtn) closeBtn.addEventListener("click", closeMenu);
                if (overlay) overlay.addEventListener("click", closeMenu);

                // Mobile Submenu
                wrapper.querySelectorAll(".jr-mobile-menu .menu-item-has-children > a").forEach(link => {
                    link.addEventListener("click", function(e) {
                        e.preventDefault();
                        const submenu = this.nextElementSibling;
                        if (submenu) {
                            submenu.style.display = (submenu.style.display === "block") ? "none" : "block";
                        }
                    });
                });
            });
        });
        </script>
        <?php endif; ?>
        <?php
    }
}