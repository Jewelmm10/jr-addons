<?php
namespace JR_Addons\Elementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;

if (!defined('ABSPATH')) exit;

class ExtraOptions extends Widget_Base {

    public function get_name() {
        return 'jr_extra_options';
    }

    public function get_title() {
        return __('Extra Options', 'jr-addons');
    }

    public function get_icon() {
        return 'jr-get-icon';
    }

    public function get_categories() {
        return ['jr-wc'];
    }

    public function get_keywords() {
        return ['shipping', 'delivery', 'sku', 'review', 'product'];
    }

    protected function register_controls() {

        // ===== SKU SECTION =====
        $this->start_controls_section('section_sku', [
            'label' => __('SKU & Reviews', 'jr-addons'),
        ]);

        $this->add_control('show_sku', [
            'label' => __('Show SKU', 'jr-addons'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
        ]);

        $this->add_control('sku_label', [
            'label' => __('SKU Label', 'jr-addons'),
            'type' => Controls_Manager::TEXT,
            'default' => 'SKU:',
            'condition' => ['show_sku' => 'yes'],
        ]);

        $this->add_control('show_reviews', [
            'label' => __('Show Reviews', 'jr-addons'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
        ]);

        $this->add_control('review_text_singular', [
            'label' => __('Singular Text', 'jr-addons'),
            'type' => Controls_Manager::TEXT,
            'default' => 'customer review',
            'condition' => ['show_reviews' => 'yes'],
        ]);

        $this->add_control('review_text_plural', [
            'label' => __('Plural Text', 'jr-addons'),
            'type' => Controls_Manager::TEXT,
            'default' => 'customer reviews',
            'condition' => ['show_reviews' => 'yes'],
        ]);

        $this->end_controls_section();

        // ===== SHIPPING METHODS =====
        $this->start_controls_section('section_shipping', [
            'label' => __('Shipping Methods', 'jr-addons'),
        ]);

        $this->add_control('show_shipping_box', [
            'label' => __('Show Shipping Box', 'jr-addons'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
        ]);

        $repeater = new Repeater();

        $repeater->add_control('icon_type', [
            'label' => __('Icon Type', 'jr-addons'),
            'type' => Controls_Manager::SELECT,
            'options' => [
                'icon' => __('Icon', 'jr-addons'),
                'image' => __('Image', 'jr-addons'),
            ],
            'default' => 'icon',
        ]);

        $repeater->add_control('method_icon', [
            'label' => __('Icon', 'jr-addons'),
            'type' => Controls_Manager::ICONS,
            'default' => ['value' => 'fas fa-truck', 'library' => 'fa-solid'],
            'condition' => ['icon_type' => 'icon'],
        ]);

        $repeater->add_control('method_image', [
            'label' => __('Image', 'jr-addons'),
            'type' => Controls_Manager::MEDIA,
            'condition' => ['icon_type' => 'image'],
        ]);

        $repeater->add_control('method_title', [
            'label' => __('Title', 'jr-addons'),
            'type' => Controls_Manager::TEXT,
            'default' => 'Pick up from Store',
            'label_block' => true,
        ]);

        $repeater->add_control('method_description', [
            'label' => __('Description', 'jr-addons'),
            'type' => Controls_Manager::TEXTAREA,
            'default' => 'To pick up today',
            'rows' => 2,
        ]);

        $repeater->add_control('method_time', [
            'label' => __('Delivery Time', 'jr-addons'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'placeholder' => '2-3 Days',
        ]);

        $repeater->add_control('method_price', [
            'label' => __('Price', 'jr-addons'),
            'type' => Controls_Manager::TEXT,
            'default' => 'Free',
        ]);

        $repeater->add_control('price_color', [
            'label' => __('Price Color', 'jr-addons'),
            'type' => Controls_Manager::COLOR,
            'default' => '#FF8C00',
        ]);

        $this->add_control('shipping_methods', [
            'label' => __('Shipping Methods', 'jr-addons'),
            'type' => Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => [
                [
                    'method_title' => 'Pick up from Store',
                    'method_description' => 'To pick up today',
                    'method_price' => 'Free',
                    'price_color' => '#15803d',
                ],
                [
                    'method_title' => 'Courier delivery',
                    'method_description' => 'Our courier will deliver to the specified address',
                    'method_time' => '2-3 Days',
                    'method_price' => 'From $40',
                    'price_color' => '#1a1a1a',
                ],
                [
                    'method_title' => 'DHL Courier delivery',
                    'method_description' => 'DHL courier will deliver to the specified address',
                    'method_time' => '1-2 Days',
                    'method_price' => 'From $40',
                    'price_color' => '#1a1a1a',
                ],
            ],
            'title_field' => '{{{ method_title }}}',
        ]);

        $this->end_controls_section();

        // ===== STYLE: SKU & REVIEWS =====
        $this->start_controls_section('style_sku_reviews', [
            'label' => __('SKU & Reviews Style', 'jr-addons'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('sku_color', [
            'label' => __('SKU Color', 'jr-addons'),
            'type' => Controls_Manager::COLOR,
            'default' => '#1a1a1a',
            'selectors' => [
                '{{WRAPPER}} .jr-sku' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'sku_typography',
            'selector' => '{{WRAPPER}} .jr-sku',
        ]);

        $this->add_control('star_color', [
            'label' => __('Star Color', 'jr-addons'),
            'type' => Controls_Manager::COLOR,
            'default' => '#FF8C00',
            'selectors' => [
                '{{WRAPPER}} .jr-stars-filled' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('review_link_color', [
            'label' => __('Review Link Color', 'jr-addons'),
            'type' => Controls_Manager::COLOR,
            'default' => '#666',
            'selectors' => [
                '{{WRAPPER}} .jr-review-link' => 'color: {{VALUE}};',
            ],
        ]);

        $this->end_controls_section();

        // ===== STYLE: SHIPPING BOX =====
        $this->start_controls_section('style_shipping_box', [
            'label' => __('Shipping Box Style', 'jr-addons'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('box_bg', [
            'label' => __('Background', 'jr-addons'),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'selectors' => [
                '{{WRAPPER}} .jr-shipping-box' => 'background: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'box_border',
            'selector' => '{{WRAPPER}} .jr-shipping-box',
        ]);

        $this->add_control('box_radius', [
            'label' => __('Border Radius', 'jr-addons'),
            'type' => Controls_Manager::SLIDER,
            'range' => ['px' => ['min' => 0, 'max' => 50]],
            'default' => ['size' => 12],
            'selectors' => [
                '{{WRAPPER}} .jr-shipping-box' => 'border-radius: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_control('box_padding', [
            'label' => __('Padding', 'jr-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'selectors' => [
                '{{WRAPPER}} .jr-shipping-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'default' => ['top' => 20, 'right' => 20, 'bottom' => 20, 'left' => 20, 'unit' => 'px'],
        ]);

        $this->add_control('divider_color', [
            'label' => __('Divider Color', 'jr-addons'),
            'type' => Controls_Manager::COLOR,
            'default' => '#eeeeee',
            'selectors' => [
                '{{WRAPPER}} .jr-shipping-method:not(:last-child)' => 'border-bottom-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('icon_size', [
            'label' => __('Icon Size', 'jr-addons'),
            'type' => Controls_Manager::SLIDER,
            'range' => ['px' => ['min' => 16, 'max' => 64]],
            'default' => ['size' => 28],
            'selectors' => [
                '{{WRAPPER}} .jr-method-icon' => 'font-size: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .jr-method-icon img' => 'width: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'method_title_typo',
            'label' => __('Title Typography', 'jr-addons'),
            'selector' => '{{WRAPPER}} .jr-method-title',
        ]);

        $this->add_control('method_title_color', [
            'label' => __('Title Color', 'jr-addons'),
            'type' => Controls_Manager::COLOR,
            'default' => '#1a1a1a',
            'selectors' => [
                '{{WRAPPER}} .jr-method-title' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'method_desc_typo',
            'label' => __('Description Typography', 'jr-addons'),
            'selector' => '{{WRAPPER}} .jr-method-desc',
        ]);

        $this->add_control('method_desc_color', [
            'label' => __('Description Color', 'jr-addons'),
            'type' => Controls_Manager::COLOR,
            'default' => '#777',
            'selectors' => [
                '{{WRAPPER}} .jr-method-desc' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'method_price_typo',
            'label' => __('Price Typography', 'jr-addons'),
            'selector' => '{{WRAPPER}} .jr-method-price',
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'method_time_typo',
            'label' => __('Time Typography', 'jr-addons'),
            'selector' => '{{WRAPPER}} .jr-method-time',
        ]);

        $this->add_control('method_time_color', [
            'label' => __('Time Color', 'jr-addons'),
            'type' => Controls_Manager::COLOR,
            'default' => '#777',
            'selectors' => [
                '{{WRAPPER}} .jr-method-time' => 'color: {{VALUE}};',
            ],
        ]);

        $this->end_controls_section();
    }

    protected function render() {
        global $product;

        if (!$product instanceof \WC_Product) {
            $product = wc_get_product(get_the_ID());
        }

        if (!$product) {
            if (\Elementor\Plugin::$instance->editor->is_edit_mode()) {
                echo '<p>' . __('Product not found. Use this widget on a single product page.', 'jr-addons') . '</p>';
            }
            return;
        }

        $settings = $this->get_settings_for_display();
        ?>
        <div class="jr-shipping-options-wrapper">

            <?php if ($settings['show_sku'] === 'yes' && $product->get_sku()) : ?>
                <div class="jr-sku-wrap">
                    <span class="jr-sku">
                        <strong><?php echo esc_html($settings['sku_label']); ?></strong>
                        <?php echo esc_html($product->get_sku()); ?>
                    </span>
                </div>
            <?php endif; ?>

            <?php if ($settings['show_reviews'] === 'yes' && comments_open($product->get_id())) :
                $rating = $product->get_average_rating();
                $count = $product->get_review_count();
                $text = ($count == 1) ? $settings['review_text_singular'] : $settings['review_text_plural'];
                ?>
                <div class="jr-reviews-wrap">
                    <div class="jr-stars">
                        <span class="jr-stars-empty">★★★★★</span>
                        <span class="jr-stars-filled" style="width: <?php echo esc_attr(($rating / 5) * 100); ?>%">★★★★★</span>
                    </div>
                    <a href="#reviews" class="jr-review-link" data-jr-review-scroll>
                        (<?php echo esc_html($count . ' ' . $text); ?>)
                    </a>
                </div>
            <?php endif; ?>

            <?php if ($settings['show_shipping_box'] === 'yes' && !empty($settings['shipping_methods'])) : ?>
                <div class="jr-shipping-box">
                    <?php foreach ($settings['shipping_methods'] as $method) : ?>
                        <div class="jr-shipping-method">
                            <div class="jr-method-icon">
                                <?php if ($method['icon_type'] === 'image' && !empty($method['method_image']['url'])) : ?>
                                    <img src="<?php echo esc_url($method['method_image']['url']); ?>" alt="">
                                <?php elseif (!empty($method['method_icon']['value'])) : ?>
                                    <?php \Elementor\Icons_Manager::render_icon($method['method_icon'], ['aria-hidden' => 'true']); ?>
                                <?php endif; ?>
                            </div>
                            <div class="jr-method-content">
                                <div class="jr-method-title"><?php echo esc_html($method['method_title']); ?></div>
                                <?php if (!empty($method['method_description'])) : ?>
                                    <div class="jr-method-desc"><?php echo esc_html($method['method_description']); ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="jr-method-meta">
                                <?php if (!empty($method['method_time'])) : ?>
                                    <div class="jr-method-time"><?php echo esc_html($method['method_time']); ?></div>
                                <?php endif; ?>
                                <?php if (!empty($method['method_price'])) : ?>
                                    <div class="jr-method-price" style="color: <?php echo esc_attr($method['price_color']); ?>">
                                        <?php echo esc_html($method['method_price']); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </div>
        <?php
    }
}