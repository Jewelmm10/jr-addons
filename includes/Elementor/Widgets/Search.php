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

class Search extends Widget_Base {

    public function get_name() { return 'jr-addons_search'; }
    public function get_title() { return esc_html__('JR Search', 'jr-addons'); }
    public function get_icon() { return 'jr-get-icon'; }
    public function get_categories() { return ['jr-addons']; }
    public function get_keywords() { return ['search', 'product', 'ajax', 'woocommerce']; }

    protected function register_controls() {

        /* ========== CONTENT TAB ========== */
        $this->start_controls_section('content_section', [
            'label' => esc_html__('Content', 'jr-addons'),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('placeholder', [
            'label'   => esc_html__('Placeholder', 'jr-addons'),
            'type'    => Controls_Manager::TEXT,
            'default' => esc_html__('Search products...', 'jr-addons'),
        ]);

        $this->add_control('button_text', [
            'label'   => esc_html__('Button Text', 'jr-addons'),
            'type'    => Controls_Manager::TEXT,
            'default' => esc_html__('Search', 'jr-addons'),
        ]);

        $this->add_control('button_icon', [
            'label'            => esc_html__('Button Icon', 'jr-addons'),
            'type'             => Controls_Manager::ICONS,
            'fa4compatibility' => 'icon',
            'default'          => [
                'value'   => 'fas fa-search',
                'library' => 'fa-solid',
            ],
        ]);

        $this->add_control('icon_position', [
            'label'   => esc_html__('Icon Position', 'jr-addons'),
            'type'    => Controls_Manager::SELECT,
            'default' => 'before',
            'options' => [
                'before' => esc_html__('Before Text', 'jr-addons'),
                'after'  => esc_html__('After Text', 'jr-addons'),
            ],
            'condition' => ['button_icon[value]!' => ''],
        ]);

        $this->add_control('show_category', [
            'label'   => esc_html__('Show Category Dropdown', 'jr-addons'),
            'type'    => Controls_Manager::SWITCHER,
            'default' => 'yes',
        ]);

        $this->add_control('enable_ajax', [
            'label'   => esc_html__('Enable Live AJAX Search', 'jr-addons'),
            'type'    => Controls_Manager::SWITCHER,
            'default' => 'yes',
        ]);

        $this->add_control('results_limit', [
            'label'     => esc_html__('Results Limit', 'jr-addons'),
            'type'      => Controls_Manager::NUMBER,
            'default'   => 6,
            'min'       => 1,
            'max'       => 20,
            'condition' => ['enable_ajax' => 'yes'],
        ]);

        $this->add_control('show_price', [
            'label'     => esc_html__('Show Price in Results', 'jr-addons'),
            'type'      => Controls_Manager::SWITCHER,
            'default'   => 'yes',
            'condition' => ['enable_ajax' => 'yes'],
        ]);

        $this->add_control('show_image', [
            'label'     => esc_html__('Show Image in Results', 'jr-addons'),
            'type'      => Controls_Manager::SWITCHER,
            'default'   => 'yes',
            'condition' => ['enable_ajax' => 'yes'],
        ]);

        $this->end_controls_section();


        /* ========== STYLE: WRAPPER ========== */
        $this->start_controls_section('style_wrapper', [
            'label' => esc_html__('Wrapper', 'jr-addons'),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_responsive_control('wrapper_max_width', [
            'label'      => esc_html__('Max Width', 'jr-addons'),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['px', '%'],
            'range'      => ['px' => ['min' => 200, 'max' => 1200]],
            'default'    => ['unit' => 'px', 'size' => 700],
            'selectors'  => ['{{WRAPPER}} .jr-search-wrapper' => 'max-width: {{SIZE}}{{UNIT}};'],
        ]);

        $this->add_responsive_control('wrapper_align', [
            'label'   => esc_html__('Alignment', 'jr-addons'),
            'type'    => Controls_Manager::CHOOSE,
            'options' => [
                'flex-start' => ['title' => 'Left',   'icon' => 'eicon-text-align-left'],
                'center'     => ['title' => 'Center', 'icon' => 'eicon-text-align-center'],
                'flex-end'   => ['title' => 'Right',  'icon' => 'eicon-text-align-right'],
            ],
            'default'   => 'center',
            'selectors' => ['{{WRAPPER}} .jr-search-outer' => 'display:flex; justify-content: {{VALUE}};'],
        ]);

        $this->add_group_control(Group_Control_Background::get_type(), [
            'name'     => 'form_bg',
            'types'    => ['classic', 'gradient'],
            'selector' => '{{WRAPPER}} .jr-search-form',
        ]);

        $this->add_group_control(Group_Control_Border::get_type(), [
            'name'     => 'form_border',
            'selector' => '{{WRAPPER}} .jr-search-form',
        ]);

        $this->add_responsive_control('form_radius', [
            'label'      => esc_html__('Border Radius', 'jr-addons'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'default'    => ['top'=>'50','right'=>'50','bottom'=>'50','left'=>'50','unit'=>'px'],
            'selectors'  => ['{{WRAPPER}} .jr-search-form' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow:hidden;'],
        ]);

        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name'     => 'form_shadow',
            'selector' => '{{WRAPPER}} .jr-search-form',
        ]);

        $this->end_controls_section();


        /* ========== STYLE: INPUT ========== */
        $this->start_controls_section('style_input', [
            'label' => esc_html__('Input', 'jr-addons'),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name'     => 'input_typo',
            'selector' => '{{WRAPPER}} .jr-search-input',
        ]);

        $this->add_control('input_color', [
            'label'     => esc_html__('Text Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#111827',
            'selectors' => ['{{WRAPPER}} .jr-search-input' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('placeholder_color', [
            'label'     => esc_html__('Placeholder Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#9ca3af',
            'selectors' => ['{{WRAPPER}} .jr-search-input::placeholder' => 'color: {{VALUE}};'],
        ]);

        $this->add_responsive_control('input_padding', [
            'label'      => esc_html__('Padding', 'jr-addons'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px','em'],
            'default'    => ['top'=>'14','right'=>'20','bottom'=>'14','left'=>'20','unit'=>'px'],
            'selectors'  => ['{{WRAPPER}} .jr-search-input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
        ]);

        $this->end_controls_section();


        /* ========== STYLE: CATEGORY ========== */
        $this->start_controls_section('style_category', [
            'label'     => esc_html__('Category Dropdown', 'jr-addons'),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => ['show_category' => 'yes'],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name'     => 'cat_typo',
            'selector' => '{{WRAPPER}} .jr-category',
        ]);

        $this->add_control('cat_color', [
            'label'     => esc_html__('Text Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#374151',
            'selectors' => ['{{WRAPPER}} .jr-category, {{WRAPPER}} .jr-category-arrow' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('cat_bg', [
            'label'     => esc_html__('Background', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#f9fafb',
            'selectors' => ['{{WRAPPER}} .jr-category-wrapper' => 'background: {{VALUE}};'],
        ]);

        $this->add_control('cat_border_color', [
            'label'     => esc_html__('Divider Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#e5e7eb',
            'selectors' => ['{{WRAPPER}} .jr-category-wrapper' => 'border-right: 1px solid {{VALUE}};'],
        ]);

        $this->add_responsive_control('cat_min_width', [
            'label'     => esc_html__('Min Width', 'jr-addons'),
            'type'      => Controls_Manager::SLIDER,
            'range'     => ['px' => ['min' => 100, 'max' => 300]],
            'default'   => ['unit' => 'px', 'size' => 160],
            'selectors' => ['{{WRAPPER}} .jr-category-wrapper' => 'min-width: {{SIZE}}{{UNIT}};'],
        ]);

        $this->end_controls_section();


        /* ========== STYLE: BUTTON ========== */
        $this->start_controls_section('style_button', [
            'label' => esc_html__('Button', 'jr-addons'),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name'     => 'btn_typo',
            'selector' => '{{WRAPPER}} .jr-search-btn',
        ]);

        $this->start_controls_tabs('btn_tabs');

        $this->start_controls_tab('btn_normal', ['label' => esc_html__('Normal', 'jr-addons')]);
        $this->add_control('btn_color', [
            'label'     => esc_html__('Text Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => ['{{WRAPPER}} .jr-search-btn, {{WRAPPER}} .jr-search-btn i, {{WRAPPER}} .jr-search-btn svg' => 'color: {{VALUE}}; fill: {{VALUE}};'],
        ]);
        $this->add_group_control(Group_Control_Background::get_type(), [
            'name'     => 'btn_bg',
            'types'    => ['classic', 'gradient'],
            'selector' => '{{WRAPPER}} .jr-search-btn',
        ]);
        $this->end_controls_tab();

        $this->start_controls_tab('btn_hover', ['label' => esc_html__('Hover', 'jr-addons')]);
        $this->add_control('btn_hover_color', [
            'label'     => esc_html__('Text Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => ['{{WRAPPER}} .jr-search-btn:hover, {{WRAPPER}} .jr-search-btn:hover i, {{WRAPPER}} .jr-search-btn:hover svg' => 'color: {{VALUE}}; fill: {{VALUE}};'],
        ]);
        $this->add_group_control(Group_Control_Background::get_type(), [
            'name'     => 'btn_bg_hover',
            'types'    => ['classic', 'gradient'],
            'selector' => '{{WRAPPER}} .jr-search-btn:hover',
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control('btn_padding', [
            'label'      => esc_html__('Padding', 'jr-addons'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px','em'],
            'default'    => ['top'=>'0','right'=>'28','bottom'=>'0','left'=>'28','unit'=>'px'],
            'selectors'  => ['{{WRAPPER}} .jr-search-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
        ]);

        $this->add_control('btn_icon_size', [
            'label'     => esc_html__('Icon Size', 'jr-addons'),
            'type'      => Controls_Manager::SLIDER,
            'range'     => ['px' => ['min' => 10, 'max' => 40]],
            'default'   => ['unit' => 'px', 'size' => 18],
            'selectors' => [
                '{{WRAPPER}} .jr-search-btn svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .jr-search-btn i'   => 'font-size: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_control('btn_icon_gap', [
            'label'     => esc_html__('Icon Gap', 'jr-addons'),
            'type'      => Controls_Manager::SLIDER,
            'range'     => ['px' => ['min' => 0, 'max' => 30]],
            'default'   => ['unit' => 'px', 'size' => 8],
            'selectors' => ['{{WRAPPER}} .jr-search-btn' => 'gap: {{SIZE}}{{UNIT}};'],
        ]);

        $this->end_controls_section();


        /* ========== STYLE: LIVE RESULTS ========== */
        $this->start_controls_section('style_results', [
            'label'     => esc_html__('Live Results', 'jr-addons'),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => ['enable_ajax' => 'yes'],
        ]);

        $this->add_control('results_bg', [
            'label'     => esc_html__('Background', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => ['{{WRAPPER}} .jr-live-results' => 'background: {{VALUE}};'],
        ]);

        $this->add_control('results_text_color', [
            'label'     => esc_html__('Title Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#111827',
            'selectors' => ['{{WRAPPER}} .jr-result-title' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('results_price_color', [
            'label'     => esc_html__('Price Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#2563eb',
            'selectors' => ['{{WRAPPER}} .jr-result-price' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('results_hover_bg', [
            'label'     => esc_html__('Hover Background', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#f9fafb',
            'selectors' => ['{{WRAPPER}} .jr-result-item:hover' => 'background: {{VALUE}};'],
        ]);

        $this->add_responsive_control('results_radius', [
            'label'      => esc_html__('Border Radius', 'jr-addons'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px'],
            'default'    => ['top'=>'12','right'=>'12','bottom'=>'12','left'=>'12','unit'=>'px'],
            'selectors'  => ['{{WRAPPER}} .jr-live-results' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
        ]);

        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name'     => 'results_shadow',
            'selector' => '{{WRAPPER}} .jr-live-results',
        ]);

        $this->end_controls_section();
    }


    protected function render() {
        $settings  = $this->get_settings_for_display();
        $widget_id = $this->get_id();
        $ajax      = $settings['enable_ajax'] === 'yes' ? 'true' : 'false';
        $limit     = !empty($settings['results_limit']) ? (int) $settings['results_limit'] : 6;
        $show_img  = $settings['show_image'] === 'yes' ? 'true' : 'false';
        $show_prc  = $settings['show_price'] === 'yes' ? 'true' : 'false';
        $icon_pos  = $settings['icon_position'] ?? 'before';
        ?>
        <style>
            .jr-search-wrapper{position:relative;width:100%;margin:0 auto;font-family:inherit}
            .jr-search-form{display:flex;align-items:stretch;transition:all .3s ease}
            .jr-search-form:focus-within{box-shadow:0 4px 20px rgba(37,99,235,.15)}
            .jr-category-wrapper{position:relative;display:flex;align-items:center}
            .jr-category{appearance:none;-webkit-appearance:none;border:none;background:transparent;padding:14px 36px 14px 20px;cursor:pointer;width:100%;outline:none;font-weight:500}
            .jr-category-arrow{position:absolute;right:14px;top:50%;transform:translateY(-50%);pointer-events:none;display:flex}
            .jr-input-wrapper{position:relative;flex:1;display:flex;align-items:center}
            .jr-search-input{width:100%;border:none;background:transparent;outline:none}
            .jr-search-loader{position:absolute;right:15px;display:none}
            .jr-search-loader.active{display:flex}
            .jr-spinner{width:18px;height:18px;border:2px solid #e5e7eb;border-top-color:#2563eb;border-radius:50%;animation:jr-spin .7s linear infinite}
            @keyframes jr-spin{to{transform:rotate(360deg)}}
            .jr-search-btn{display:flex;align-items:center;justify-content:center;border:none;cursor:pointer;transition:all .3s ease;text-transform:uppercase;letter-spacing:.5px;font-weight:600;white-space:nowrap}
            .jr-search-btn:active{transform:scale(.98)}
            .jr-search-btn i,.jr-search-btn svg{display:inline-flex;line-height:1}
            .jr-live-results{position:absolute;top:calc(100% + 10px);left:0;right:0;z-index:9999;display:none;max-height:450px;overflow-y:auto;border:1px solid #f3f4f6}
            .jr-live-results.active{display:block;animation:jr-fadeIn .2s ease}
            @keyframes jr-fadeIn{from{opacity:0;transform:translateY(-8px)}to{opacity:1;transform:translateY(0)}}
            .jr-live-results::-webkit-scrollbar{width:6px}
            .jr-live-results::-webkit-scrollbar-thumb{background:#d1d5db;border-radius:10px}
            .jr-result-item{display:flex;align-items:center;gap:12px;padding:12px 16px;border-bottom:1px solid #f3f4f6;text-decoration:none;transition:background .2s ease}
            .jr-result-item:last-child{border-bottom:none}
            .jr-result-item img{width:50px;height:50px;object-fit:cover;border-radius:6px;flex-shrink:0}
            .jr-result-info{flex:1;min-width:0}
            .jr-result-title{font-size:14px;font-weight:500;margin:0 0 4px;line-height:1.3}
            .jr-result-price{font-size:13px;font-weight:600}
            .jr-result-price del{opacity:.5;font-weight:400;margin-right:6px}
            .jr-no-results,.jr-loading-text{padding:30px 20px;text-align:center;color:#6b7280;font-size:14px}
            @media(max-width:768px){.jr-btn-text{display:none}.jr-search-btn{padding:0 20px!important}}
            @media(max-width:480px){.jr-category-wrapper{display:none}}
        </style>

        <div class="jr-search-outer">
            <div class="jr-search-wrapper" 
                 data-ajax="<?php echo esc_attr($ajax); ?>"
                 data-limit="<?php echo esc_attr($limit); ?>"
                 data-show-image="<?php echo esc_attr($show_img); ?>"
                 data-show-price="<?php echo esc_attr($show_prc); ?>">
                
                <form class="jr-search-form" action="<?php echo esc_url(home_url('/')); ?>" method="get" role="search">

                    <?php if ($settings['show_category'] === 'yes' && taxonomy_exists('product_cat')): ?>
                        <div class="jr-category-wrapper">
                            <select name="product_cat" class="jr-category" aria-label="<?php esc_attr_e('Select Category', 'jr-addons'); ?>">
                                <option value=""><?php esc_html_e('All Categories', 'jr-addons'); ?></option>
                                <?php
                                $terms = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => true]);
                                if (!is_wp_error($terms)) {
                                    foreach ($terms as $term) {
                                        printf('<option value="%s">%s</option>', esc_attr($term->slug), esc_html($term->name));
                                    }
                                }
                                ?>
                            </select>
                            <span class="jr-category-arrow">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg>
                            </span>
                        </div>
                    <?php endif; ?>

                    <div class="jr-input-wrapper">
                        <input type="search"
                               name="s"
                               placeholder="<?php echo esc_attr($settings['placeholder']); ?>"
                               class="jr-search-input"
                               autocomplete="off"
                               aria-label="<?php esc_attr_e('Search Products', 'jr-addons'); ?>" />
                        <span class="jr-search-loader" aria-hidden="true">
                            <span class="jr-spinner"></span>
                        </span>
                    </div>

                    <input type="hidden" name="post_type" value="product">

                    <button type="submit" class="jr-search-btn" aria-label="<?php esc_attr_e('Search', 'jr-addons'); ?>">
                        <?php
                        $has_icon = !empty($settings['button_icon']['value']);
                        $has_text = !empty($settings['button_text']);
                        
                        if ($has_icon && $icon_pos === 'before') {
                            Icons_Manager::render_icon($settings['button_icon'], ['aria-hidden' => 'true']);
                        }
                        if ($has_text) {
                            echo '<span class="jr-btn-text">' . esc_html($settings['button_text']) . '</span>';
                        }
                        if ($has_icon && $icon_pos === 'after') {
                            Icons_Manager::render_icon($settings['button_icon'], ['aria-hidden' => 'true']);
                        }
                        ?>
                    </button>
                </form>

                <?php if ($settings['enable_ajax'] === 'yes'): ?>
                    <div class="jr-live-results" role="region" aria-live="polite"></div>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }
}