<?php
namespace JR_Addons\Elementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;

if (!defined('ABSPATH')) exit;

class ProductAccessories extends Widget_Base {

    public function get_name() {
        return 'jr_product_accessories';
    }

    public function get_title() {
        return __('Product Accessories', 'jr-addons');
    }

    public function get_icon() {
        return 'jr-get-icon';
    }

    public function get_categories() {
        return ['jr-wc'];
    }

    public function get_keywords() {
        return ['accessories', 'cross-sell', 'upsell', 'related', 'product'];
    }

    public function get_script_depends() {
        return ['jr-product-accessories'];
    }

    protected function register_controls() {

        // ===== CONTENT =====
        $this->start_controls_section('section_content', [
            'label' => __('Content', 'jr-addons'),
        ]);

        $this->add_control('show_title', [
            'label' => __('Show Title', 'jr-addons'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
        ]);

        $this->add_control('section_title', [
            'label' => __('Title', 'jr-addons'),
            'type' => Controls_Manager::TEXT,
            'default' => "Don't Miss Top Accessories",
            'condition' => ['show_title' => 'yes'],
        ]);

        $this->add_control('source', [
            'label' => __('Source', 'jr-addons'),
            'type' => Controls_Manager::SELECT,
            'options' => [
                'cross_sells' => __('Cross-sells', 'jr-addons'),
                'upsells' => __('Upsells', 'jr-addons'),
                'related' => __('Related Products', 'jr-addons'),
                'manual' => __('Manual Selection', 'jr-addons'),
                'recent' => __('Recent Products', 'jr-addons'),
                'best_selling' => __('Best Selling', 'jr-addons'),
            ],
            'default' => 'cross_sells',
        ]);

        $this->add_control('manual_products', [
            'label' => __('Select Products', 'jr-addons'),
            'type' => Controls_Manager::SELECT2,
            'multiple' => true,
            'options' => $this->get_products_list(),
            'condition' => ['source' => 'manual'],
        ]);

        $this->add_control('limit', [
            'label' => __('Number of Products', 'jr-addons'),
            'type' => Controls_Manager::NUMBER,
            'default' => 4,
            'min' => 1,
            'max' => 20,
        ]);

        $this->add_control('orderby', [
            'label' => __('Order By', 'jr-addons'),
            'type' => Controls_Manager::SELECT,
            'options' => [
                'date' => __('Date', 'jr-addons'),
                'price' => __('Price', 'jr-addons'),
                'popularity' => __('Popularity', 'jr-addons'),
                'rand' => __('Random', 'jr-addons'),
                'menu_order' => __('Menu Order', 'jr-addons'),
            ],
            'default' => 'date',
            'condition' => ['source!' => 'manual'],
        ]);

        $this->add_control('order', [
            'label' => __('Order', 'jr-addons'),
            'type' => Controls_Manager::SELECT,
            'options' => [
                'ASC' => __('Ascending', 'jr-addons'),
                'DESC' => __('Descending', 'jr-addons'),
            ],
            'default' => 'DESC',
            'condition' => ['source!' => 'manual'],
        ]);

        $this->add_control('show_price', [
            'label' => __('Show Price', 'jr-addons'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
        ]);

        $this->add_control('show_button', [
            'label' => __('Show Add to Cart', 'jr-addons'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
        ]);

        $this->add_control('button_text', [
            'label' => __('Button Text', 'jr-addons'),
            'type' => Controls_Manager::TEXT,
            'default' => 'Add To Cart',
            'condition' => ['show_button' => 'yes'],
        ]);

        $this->add_control('added_text', [
            'label' => __('Added Text', 'jr-addons'),
            'type' => Controls_Manager::TEXT,
            'default' => '✓ Added',
            'condition' => ['show_button' => 'yes'],
        ]);

        $this->end_controls_section();

        // ===== STYLE: BOX =====
        $this->start_controls_section('style_box', [
            'label' => __('Container', 'jr-addons'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('box_bg', [
            'label' => __('Background', 'jr-addons'),
            'type' => Controls_Manager::COLOR,
            'default' => '#f5f5f5',
            'selectors' => [
                '{{WRAPPER}} .jr-acc-wrapper' => 'background: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'box_border',
            'selector' => '{{WRAPPER}} .jr-acc-wrapper',
        ]);

        $this->add_control('box_radius', [
            'label' => __('Border Radius', 'jr-addons'),
            'type' => Controls_Manager::SLIDER,
            'range' => ['px' => ['min' => 0, 'max' => 50]],
            'default' => ['size' => 12],
            'selectors' => [
                '{{WRAPPER}} .jr-acc-wrapper' => 'border-radius: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_control('box_padding', [
            'label' => __('Padding', 'jr-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'default' => ['top' => 20, 'right' => 20, 'bottom' => 20, 'left' => 20, 'unit' => 'px'],
            'selectors' => [
                '{{WRAPPER}} .jr-acc-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_control('items_gap', [
            'label' => __('Items Gap', 'jr-addons'),
            'type' => Controls_Manager::SLIDER,
            'range' => ['px' => ['min' => 0, 'max' => 40]],
            'default' => ['size' => 12],
            'selectors' => [
                '{{WRAPPER}} .jr-acc-list' => 'gap: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();

        // ===== STYLE: TITLE =====
        $this->start_controls_section('style_title', [
            'label' => __('Title', 'jr-addons'),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => ['show_title' => 'yes'],
        ]);

        $this->add_control('title_color', [
            'label' => __('Color', 'jr-addons'),
            'type' => Controls_Manager::COLOR,
            'default' => '#1a1a1a',
            'selectors' => [
                '{{WRAPPER}} .jr-acc-title' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'title_typo',
            'selector' => '{{WRAPPER}} .jr-acc-title',
        ]);

        $this->end_controls_section();

        // ===== STYLE: ITEM =====
        $this->start_controls_section('style_item', [
            'label' => __('Item', 'jr-addons'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('item_bg', [
            'label' => __('Background', 'jr-addons'),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'selectors' => [
                '{{WRAPPER}} .jr-acc-item' => 'background: {{VALUE}};',
            ],
        ]);

        $this->add_control('item_radius', [
            'label' => __('Border Radius', 'jr-addons'),
            'type' => Controls_Manager::SLIDER,
            'range' => ['px' => ['min' => 0, 'max' => 30]],
            'default' => ['size' => 10],
            'selectors' => [
                '{{WRAPPER}} .jr-acc-item' => 'border-radius: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_control('item_padding', [
            'label' => __('Padding', 'jr-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'default' => ['top' => 12, 'right' => 14, 'bottom' => 12, 'left' => 14, 'unit' => 'px'],
            'selectors' => [
                '{{WRAPPER}} .jr-acc-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_control('image_size', [
            'label' => __('Image Size', 'jr-addons'),
            'type' => Controls_Manager::SLIDER,
            'range' => ['px' => ['min' => 30, 'max' => 120]],
            'default' => ['size' => 50],
            'selectors' => [
                '{{WRAPPER}} .jr-acc-thumb' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_control('image_radius', [
            'label' => __('Image Radius', 'jr-addons'),
            'type' => Controls_Manager::SLIDER,
            'range' => ['px' => ['min' => 0, 'max' => 50]],
            'default' => ['size' => 6],
            'selectors' => [
                '{{WRAPPER}} .jr-acc-thumb' => 'border-radius: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_control('product_title_color', [
            'label' => __('Product Title Color', 'jr-addons'),
            'type' => Controls_Manager::COLOR,
            'default' => '#1a1a1a',
            'selectors' => [
                '{{WRAPPER}} .jr-acc-name' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'product_title_typo',
            'label' => __('Product Title Typography', 'jr-addons'),
            'selector' => '{{WRAPPER}} .jr-acc-name',
        ]);

        $this->add_control('price_color', [
            'label' => __('Price Color', 'jr-addons'),
            'type' => Controls_Manager::COLOR,
            'default' => '#FF8C00',
            'selectors' => [
                '{{WRAPPER}} .jr-acc-price' => 'color: {{VALUE}};',
                '{{WRAPPER}} .jr-acc-price .amount' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'price_typo',
            'label' => __('Price Typography', 'jr-addons'),
            'selector' => '{{WRAPPER}} .jr-acc-price',
        ]);

        $this->end_controls_section();

        // ===== STYLE: BUTTON =====
        $this->start_controls_section('style_button', [
            'label' => __('Button', 'jr-addons'),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => ['show_button' => 'yes'],
        ]);

        $this->start_controls_tabs('button_tabs');

        $this->start_controls_tab('btn_normal', ['label' => __('Normal', 'jr-addons')]);

        $this->add_control('btn_color', [
            'label' => __('Color', 'jr-addons'),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'selectors' => [
                '{{WRAPPER}} .jr-acc-btn' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('btn_bg', [
            'label' => __('Background', 'jr-addons'),
            'type' => Controls_Manager::COLOR,
            'default' => '#FF8C00',
            'selectors' => [
                '{{WRAPPER}} .jr-acc-btn' => 'background: {{VALUE}};',
            ],
        ]);

        $this->end_controls_tab();

        $this->start_controls_tab('btn_hover', ['label' => __('Hover', 'jr-addons')]);

        $this->add_control('btn_color_hover', [
            'label' => __('Color', 'jr-addons'),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'selectors' => [
                '{{WRAPPER}} .jr-acc-btn:hover' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('btn_bg_hover', [
            'label' => __('Background', 'jr-addons'),
            'type' => Controls_Manager::COLOR,
            'default' => '#1a1a1a',
            'selectors' => [
                '{{WRAPPER}} .jr-acc-btn:hover' => 'background: {{VALUE}};',
            ],
        ]);

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control('btn_radius', [
            'label' => __('Border Radius', 'jr-addons'),
            'type' => Controls_Manager::SLIDER,
            'range' => ['px' => ['min' => 0, 'max' => 50]],
            'default' => ['size' => 30],
            'selectors' => [
                '{{WRAPPER}} .jr-acc-btn' => 'border-radius: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_control('btn_padding', [
            'label' => __('Padding', 'jr-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'default' => ['top' => 8, 'right' => 18, 'bottom' => 8, 'left' => 18, 'unit' => 'px'],
            'selectors' => [
                '{{WRAPPER}} .jr-acc-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'btn_typo',
            'selector' => '{{WRAPPER}} .jr-acc-btn',
        ]);

        $this->end_controls_section();
    }

    private function get_products_list() {
        $options = [];
        $products = wc_get_products(['limit' => -1, 'status' => 'publish']);
        foreach ($products as $product) {
            $options[$product->get_id()] = $product->get_name();
        }
        return $options;
    }

    private function get_products($settings) {
        global $product;

        if (!$product instanceof \WC_Product) {
            $product = wc_get_product(get_the_ID());
        }

        $current_id = $product ? $product->get_id() : 0;
        $limit = !empty($settings['limit']) ? intval($settings['limit']) : 4;
        $ids = [];

        switch ($settings['source']) {
            case 'cross_sells':
                if ($product) $ids = $product->get_cross_sell_ids();
                break;

            case 'upsells':
                if ($product) $ids = $product->get_upsell_ids();
                break;

            case 'related':
                if ($product) $ids = wc_get_related_products($current_id, $limit);
                break;

            case 'manual':
                $ids = !empty($settings['manual_products']) ? $settings['manual_products'] : [];
                break;

            case 'recent':
                $ids = wc_get_products([
                    'limit' => $limit,
                    'status' => 'publish',
                    'orderby' => 'date',
                    'order' => 'DESC',
                    'exclude' => [$current_id],
                    'return' => 'ids',
                ]);
                break;

            case 'best_selling':
                $ids = wc_get_products([
                    'limit' => $limit,
                    'status' => 'publish',
                    'meta_key' => 'total_sales',
                    'orderby' => 'meta_value_num',
                    'order' => 'DESC',
                    'exclude' => [$current_id],
                    'return' => 'ids',
                ]);
                break;
        }

        if (empty($ids)) return [];

        $ids = array_slice((array)$ids, 0, $limit);

        $args = [
            'include' => $ids,
            'limit' => $limit,
            'status' => 'publish',
        ];

        if ($settings['source'] !== 'manual' && !in_array($settings['source'], ['recent', 'best_selling'])) {
            $args['orderby'] = !empty($settings['orderby']) ? $settings['orderby'] : 'date';
            $args['order'] = !empty($settings['order']) ? $settings['order'] : 'DESC';
        }

        return wc_get_products($args);
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $products = $this->get_products($settings);

        if (empty($products)) {
            if (\Elementor\Plugin::$instance->editor->is_edit_mode()) {
                echo '<p>' . __('No products found for this source.', 'jr-addons') . '</p>';
            }
            return;
        }
        ?>
        <div class="jr-acc-wrapper">
            <?php if ($settings['show_title'] === 'yes' && !empty($settings['section_title'])) : ?>
                <h3 class="jr-acc-title"><?php echo esc_html($settings['section_title']); ?></h3>
            <?php endif; ?>

            <div class="jr-acc-list">
                <?php foreach ($products as $p) :
                    if (!$p instanceof \WC_Product) continue;
                    $img = $p->get_image_id() ? wp_get_attachment_image_url($p->get_image_id(), 'thumbnail') : wc_placeholder_img_src('thumbnail');
                    ?>
                    <div class="jr-acc-item" data-product-id="<?php echo esc_attr($p->get_id()); ?>">
                        <a href="<?php echo esc_url($p->get_permalink()); ?>" class="jr-acc-thumb-link">
                            <img src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr($p->get_name()); ?>" class="jr-acc-thumb">
                        </a>
                        <div class="jr-acc-info">
                            <a href="<?php echo esc_url($p->get_permalink()); ?>" class="jr-acc-name">
                                <?php echo esc_html($p->get_name()); ?>
                            </a>
                            <?php if ($settings['show_price'] === 'yes') : ?>
                                <div class="jr-acc-price"><?php echo $p->get_price_html(); ?></div>
                            <?php endif; ?>
                        </div>
                        <?php if ($settings['show_button'] === 'yes') : ?>
                            <?php if ($p->is_type('simple') && $p->is_purchasable() && $p->is_in_stock()) : ?>
                                <button type="button"
                                        class="jr-acc-btn jr-add-to-cart"
                                        data-product-id="<?php echo esc_attr($p->get_id()); ?>"
                                        data-default-text="<?php echo esc_attr($settings['button_text']); ?>"
                                        data-added-text="<?php echo esc_attr($settings['added_text']); ?>">
                                    <span class="jr-btn-text"><?php echo esc_html($settings['button_text']); ?></span>
                                </button>
                            <?php else : ?>
                                <a href="<?php echo esc_url($p->get_permalink()); ?>" class="jr-acc-btn">
                                    <?php _e('View', 'jr-addons'); ?>
                                </a>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
    }
}