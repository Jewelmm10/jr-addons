<?php
namespace JR_Addons\Elementor\Widgets;

if (!defined('ABSPATH')) exit;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;

class Cart extends Widget_Base {

    public function get_name() { return 'jr-addons_cart'; }
    public function get_title() { return esc_html__('JR Pro Cart', 'jr-addons'); }
    public function get_icon() { return 'jr-get-icon'; }
    public function get_categories() { return ['jr-addons']; }

    protected function register_controls() {
        // --- Content Section ---
        $this->start_controls_section('content_section', [
            'label' => __('Content', 'jr-addons'),
        ]);

        $this->add_control('cart_icon', [
            'label' => __('Cart Icon', 'jr-addons'),
            'type' => Controls_Manager::ICONS,
            'default' => [
                'value' => 'fas fa-shopping-cart',
                'library' => 'fa-solid',
            ],
        ]);

        $this->end_controls_section();

        // --- Style Section: Main Icon ---
        $this->start_controls_section('style_main_icon', [
            'label' => __('Header Cart Icon', 'jr-addons'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_responsive_control('icon_size', [
            'label' => __('Icon Size', 'jr-addons'),
            'type' => Controls_Manager::SLIDER,
            'default' => ['size' => 25],
            'selectors' => [ '{{WRAPPER}} .jr-cart-icon i' => 'font-size: {{SIZE}}{{UNIT}};', '{{WRAPPER}} .jr-cart-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: auto;' ],
        ]);

        $this->add_control('icon_color', [
            'label' => __('Icon Color', 'jr-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .jr-cart-icon i' => 'color: {{VALUE}};', '{{WRAPPER}} .jr-cart-icon svg' => 'fill: {{VALUE}};' ],
        ]);

        $this->add_control('badge_bg', [
            'label' => __('Badge Background', 'jr-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .jr-cart-count' => 'background-color: {{VALUE}};' ],
        ]);

        $this->end_controls_section();

        // --- Style Section: Mini Cart Items ---
        $this->start_controls_section('style_mini_cart', [
            'label' => __('Mini Cart Dropdown', 'jr-addons'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('dropdown_bg', [
            'label' => __('Dropdown Background', 'jr-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .jr-mini-cart' => 'background-color: {{VALUE}};' ],
        ]);

        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name' => 'dropdown_shadow',
            'selector' => '{{WRAPPER}} .jr-mini-cart',
        ]);

        $this->add_control('item_title_color', [
            'label' => __('Item Title Color', 'jr-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .woocommerce-mini-cart-item a' => 'color: {{VALUE}} !important;' ],
        ]);

        $this->end_controls_section();

        // --- Style Section: Buttons ---
        $this->start_controls_section('style_buttons', [
            'label' => __('Checkout Buttons', 'jr-addons'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('btn_bg_color', [
            'label' => __('Button Background', 'jr-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .woocommerce-mini-cart__buttons a' => 'background-color: {{VALUE}};' ],
        ]);

        $this->add_control('btn_text_color', [
            'label' => __('Button Text Color', 'jr-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .woocommerce-mini-cart__buttons a' => 'color: {{VALUE}};' ],
        ]);

        $this->add_control('btn_hover_bg', [
            'label' => __('Button Hover Background', 'jr-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .woocommerce-mini-cart__buttons a:hover' => 'background-color: {{VALUE}};' ],
        ]);

        $this->end_controls_section();
    }

    protected function render() {
        if (!class_exists('WooCommerce')) return;
        
        $settings = $this->get_settings_for_display();
        $cart_count = (WC()->cart) ? WC()->cart->get_cart_contents_count() : 0;
        ?>

        <div class="jr-cart-wrapper">
            <a href="<?php echo wc_get_cart_url(); ?>" class="jr-cart-icon">
                <?php Icons_Manager::render_icon($settings['cart_icon'], ['aria-hidden' => 'true']); ?>
                <span class="jr-cart-count"><?php echo esc_html($cart_count); ?></span>
            </a>

            <div class="jr-mini-cart">
                <div class="widget_shopping_cart_content">
                    <?php woocommerce_mini_cart(); ?>
                </div>
            </div>
        </div>
        <?php
    }
}