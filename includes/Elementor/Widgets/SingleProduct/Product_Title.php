<?php
namespace JR_Addons\Elementor\Widgets\SingleProduct;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if (!defined('ABSPATH')) exit;

class Product_Title extends Widget_Base {

    public function get_name() {
        return 'jr-product-title';
    }

    public function get_title() {
        return __('Product Title', 'jr-addons');
    }

    public function get_icon() {
        return 'jr-get-icon';
    }

    public function get_categories() {
        return ['jr-wc'];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'section_style',
            [
                'label' => __('Title Style', 'jr-addons'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __('Text Color', 'jr-addons'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .jr-product-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .jr-product-title',
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label' => __('Margin', 'jr-addons'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .jr-product-title' =>
                        'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {

        $product = $this->get_product();

        if (!$product) return;

        echo '<h1 class="jr-product-title">';
        echo esc_html($product->get_name());
        echo '</h1>';
    }

    private function get_product() {

        global $product;

        // Real product page
        if (is_product() && $product) {
            return $product;
        }

        // Elementor editor mode
        if (\Elementor\Plugin::$instance->editor->is_edit_mode()) {

            $args = [
                'post_type'      => 'product',
                'posts_per_page' => 1,
                'post_status'    => 'publish'
            ];

            $products = get_posts($args);

            if (!empty($products)) {
                return wc_get_product($products[0]->ID);
            }
        }

        return null;
    }
}