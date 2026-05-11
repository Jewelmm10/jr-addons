<?php
namespace JR_Addons\Elementor\Widgets;

if (!defined('ABSPATH')) exit;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

class Cf7 extends Widget_Base {

    public function get_name() {
        return 'jr_cf7';
    }

    public function get_title() {
        return esc_html__('JR CF7', 'jr-addons');
    }

    public function get_icon() {
        return 'jr-get-icon';
    }

    public function get_categories() {
        return ['jr-addons'];
    }

    public function get_style_depends() {
        return [ 'jr-addons-style' ]; 
    }
    public function get_keywords() { 
        return ['contact', 'form', 'cf7', 'contact form 7']; 
    }

    protected function register_controls() {

        // === Select Form ===
        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Contact Form', 'spater'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $cf7_forms = $this->get_cf7_forms();
        $this->add_control(
            'form_id',
            [
                'label'       => __('Select Contact Form', 'spater'),
                'type'        => Controls_Manager::SELECT,
                'options'     => $cf7_forms,
                'default'     => $cf7_forms ? key($cf7_forms) : '',
                'description' => empty($cf7_forms) ? __('No Contact Form 7 forms found. Please create one first.', 'spater') : '',
            ]
        );

        $this->end_controls_section();

        // === Input & Textarea Style ===
        $this->start_controls_section(
            'section_input_style',
            [
                'label' => __('Input & Textarea Fields', 'spater'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        // Field Margin (gap between fields)
        $this->add_responsive_control(
            'input_margin',
            [
                'label'      => __('Field Margin', 'spater'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default'    => [
                    'top'    => 0,
                    'right'  => 0,
                    'bottom' => 20,
                    'left'   => 0,
                    'unit'   => 'px',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .wpcf7-form-control-wrap' => 'display: block; margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Input Width & Height
        $this->add_responsive_control('input_width', [
            'label'      => __('Input Width', 'spater'),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['px', '%'],
            'range'      => ['px' => ['min' => 0, 'max' => 1000], '%' => ['min' => 0, 'max' => 100]],
            'default'    => ['unit' => '%', 'size' => 100],
            'selectors'  => ['{{WRAPPER}} .wpcf7-text, {{WRAPPER}} .wpcf7-email, {{WRAPPER}} .wpcf7-number, {{WRAPPER}} .wpcf7-date, {{WRAPPER}} .wpcf7-select, {{WRAPPER}} .wpcf7-quiz' => 'width: {{SIZE}}{{UNIT}};'],
        ]);

        $this->add_responsive_control('input_height', [
            'label'      => __('Input Height', 'spater'),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range'      => ['px' => ['min' => 30, 'max' => 200]],
            'default'    => ['size' => 50],
            'selectors'  => ['{{WRAPPER}} .wpcf7-text, {{WRAPPER}} .wpcf7-email, {{WRAPPER}} .wpcf7-number, {{WRAPPER}} .wpcf7-date, {{WRAPPER}} .wpcf7-select' => 'height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};'],
        ]);

        // Textarea Width & Height
        $this->add_responsive_control('textarea_width', [
            'label'      => __('Textarea Width', 'spater'),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['px', '%'],
            'range'      => ['px' => ['min' => 0, 'max' => 1000], '%' => ['min' => 0, 'max' => 100]],
            'default'    => ['unit' => '%', 'size' => 100],
            'selectors'  => ['{{WRAPPER}} .wpcf7-textarea' => 'width: {{SIZE}}{{UNIT}};'],
        ]);

        $this->add_responsive_control('textarea_height', [
            'label'      => __('Textarea Height', 'spater'),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range'      => ['px' => ['min' => 80, 'max' => 500]],
            'default'    => ['size' => 150],
            'selectors'  => ['{{WRAPPER}} .wpcf7-textarea' => 'height: {{SIZE}}{{UNIT}};'],
        ]);

        $this->start_controls_tabs('tabs_input_style');

        // Normal
        $this->start_controls_tab('tab_input_normal', ['label' => __('Normal', 'spater')]);
        $this->add_group_control(Group_Control_Background::get_type(), ['name' => 'input_bg', 'selector' => '{{WRAPPER}} .wpcf7-form-control:not(.wpcf7-submit)']);
        $this->add_control('input_color', ['label' => __('Text Color', 'spater'), 'type' => Controls_Manager::COLOR, 'selectors' => ['{{WRAPPER}} .wpcf7-form-control:not(.wpcf7-submit)' => 'color: {{VALUE}};']]);
        $this->add_group_control(Group_Control_Typography::get_type(), ['name' => 'input_typo', 'selector' => '{{WRAPPER}} .wpcf7-form-control:not(.wpcf7-submit)']);
        $this->add_control('placeholder_color', ['label' => __('Placeholder Color', 'spater'), 'type' => Controls_Manager::COLOR, 'selectors' => ['{{WRAPPER}} ::placeholder' => 'color: {{VALUE}} !important;']]);
        $this->add_responsive_control('input_padding', ['label' => __('Padding', 'spater'), 'type' => Controls_Manager::DIMENSIONS, 'selectors' => ['{{WRAPPER}} .wpcf7-form-control:not(.wpcf7-submit):not(.wpcf7-textarea)' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};']]);
        $this->add_group_control(Group_Control_Border::get_type(), ['name' => 'input_border', 'selector' => '{{WRAPPER}} .wpcf7-form-control:not(.wpcf7-submit)']);
        $this->add_control('input_border_radius', ['label' => __('Border Radius', 'spater'), 'type' => Controls_Manager::DIMENSIONS, 'selectors' => ['{{WRAPPER}} .wpcf7-form-control:not(.wpcf7-submit)' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};']]);
        $this->add_group_control(Group_Control_Box_Shadow::get_type(), ['name' => 'input_shadow', 'selector' => '{{WRAPPER}} .wpcf7-form-control:not(.wpcf7-submit)']);
        $this->end_controls_tab();

        // Hover
        $this->start_controls_tab('tab_input_hover', ['label' => __('Hover', 'spater')]);
        $this->add_group_control(Group_Control_Background::get_type(), ['name' => 'input_bg_hover', 'selector' => '{{WRAPPER}} .wpcf7-form-control:not(.wpcf7-submit):hover']);
        $this->add_control('input_color_hover', ['label' => __('Text Color', 'spater'), 'type' => Controls_Manager::COLOR, 'selectors' => ['{{WRAPPER}} .wpcf7-form-control:not(.wpcf7-submit):hover' => 'color: {{VALUE}};']]);
        $this->add_group_control(Group_Control_Border::get_type(), ['name' => 'input_border_hover', 'selector' => '{{WRAPPER}} .wpcf7-form-control:not(.wpcf7-submit):hover']);
        $this->end_controls_tab();

        // Focus
        $this->start_controls_tab('tab_input_focus', ['label' => __('Focus', 'spater')]);
        $this->add_group_control(Group_Control_Background::get_type(), ['name' => 'input_bg_focus', 'selector' => '{{WRAPPER}} .wpcf7-form-control:not(.wpcf7-submit):focus']);
        $this->add_control('input_color_focus', ['label' => __('Text Color', 'spater'), 'type' => Controls_Manager::COLOR, 'selectors' => ['{{WRAPPER}} .wpcf7-form-control:not(.wpcf7-submit):focus' => 'color: {{VALUE}};']]);
        $this->add_group_control(Group_Control_Border::get_type(), ['name' => 'input_border_focus', 'selector' => '{{WRAPPER}} .wpcf7-form-control:not(.wpcf7-submit):focus']);
        $this->add_group_control(Group_Control_Box_Shadow::get_type(), ['name' => 'input_shadow_focus', 'selector' => '{{WRAPPER}} .wpcf7-form-control:not(.wpcf7-submit):focus']);
        $this->add_control('input_focus_outline', [
            'label'        => __('Remove Focus Outline', 'spater'),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => __('Yes', 'spater'),
            'label_off'    => __('No', 'spater'),
            'return_value' => 'none',
            'default'      => 'none',
            'selectors'    => ['{{WRAPPER}} .wpcf7-form-control:not(.wpcf7-submit):focus' => 'outline: {{VALUE}} !important;'],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();

        // === Submit Button Style (Full Complete) ===
        $this->start_controls_section(
            'section_button_style',
            [
                'label' => __('Submit Button', 'spater'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control('button_margin', [
            'label'      => __('Margin', 'spater'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'default'    => ['top' => 25, 'unit' => 'px'],
            'selectors'  => ['{{WRAPPER}} .wpcf7-submit' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
        ]);

        $this->add_responsive_control('button_width', [
            'label'      => __('Width', 'spater'),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['px', '%'],
            'range'      => ['px' => ['min' => 0, 'max' => 500], '%' => ['min' => 0, 'max' => 100]],
            'default'    => ['unit' => '%', 'size' => 100],
            'selectors'  => ['{{WRAPPER}} .wpcf7-submit' => 'width: {{SIZE}}{{UNIT}};'],
        ]);

        $this->start_controls_tabs('tabs_button_style');

        // Normal State
        $this->start_controls_tab('tab_button_normal', ['label' => __('Normal', 'spater')]);

        $this->add_group_control(Group_Control_Typography::get_type(), ['name' => 'button_typo', 'selector' => '{{WRAPPER}} .wpcf7-submit']);
        $this->add_control('button_color', ['label' => __('Text Color', 'spater'), 'type' => Controls_Manager::COLOR, 'default' => '#ffffff', 'selectors' => ['{{WRAPPER}} .wpcf7-submit' => 'color: {{VALUE}};']]);
        $this->add_group_control(Group_Control_Background::get_type(), ['name' => 'button_bg', 'selector' => '{{WRAPPER}} .wpcf7-submit', 'default' => ['background' => '#0073aa']]);
        $this->add_responsive_control('button_padding', ['label' => __('Padding', 'spater'), 'type' => Controls_Manager::DIMENSIONS, 'default' => ['top' => 15, 'bottom' => 15, 'left' => 30, 'right' => 30, 'unit' => 'px'], 'selectors' => ['{{WRAPPER}} .wpcf7-submit' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};']]);
        $this->add_group_control(Group_Control_Border::get_type(), ['name' => 'button_border', 'selector' => '{{WRAPPER}} .wpcf7-submit']);
        $this->add_control('button_border_radius', ['label' => __('Border Radius', 'spater'), 'type' => Controls_Manager::DIMENSIONS, 'default' => ['top' => 5, 'right' => 5, 'bottom' => 5, 'left' => 5, 'unit' => 'px'], 'selectors' => ['{{WRAPPER}} .wpcf7-submit' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};']]);
        $this->add_group_control(Group_Control_Box_Shadow::get_type(), ['name' => 'button_shadow', 'selector' => '{{WRAPPER}} .wpcf7-submit']);

        $this->add_control('button_cursor', [
            'label'   => __('Cursor', 'spater'),
            'type'    => Controls_Manager::SELECT,
            'options' => ['pointer' => 'Pointer', 'default' => 'Default'],
            'default' => 'pointer',
            'selectors' => ['{{WRAPPER}} .wpcf7-submit' => 'cursor: {{VALUE}};'],
        ]);

        $this->end_controls_tab();

        // Hover State
        $this->start_controls_tab('tab_button_hover', ['label' => __('Hover', 'spater')]);

        $this->add_control('button_color_hover', ['label' => __('Text Color', 'spater'), 'type' => Controls_Manager::COLOR, 'default' => '#ffffff', 'selectors' => ['{{WRAPPER}} .wpcf7-submit:hover' => 'color: {{VALUE}};']]);
        $this->add_group_control(Group_Control_Background::get_type(), ['name' => 'button_bg_hover', 'selector' => '{{WRAPPER}} .wpcf7-submit:hover']);
        $this->add_group_control(Group_Control_Border::get_type(), ['name' => 'button_border_hover', 'selector' => '{{WRAPPER}} .wpcf7-submit:hover']);
        $this->add_group_control(Group_Control_Box_Shadow::get_type(), ['name' => 'button_shadow_hover', 'selector' => '{{WRAPPER}} .wpcf7-submit:hover']);

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

    }

    private function get_cf7_forms() {
        $forms = ['' => __('Select Form', 'spater')];
        $args = ['post_type' => 'wpcf7_contact_form', 'posts_per_page' => -1];
        $cf7posts = get_posts($args);
        foreach ($cf7posts as $post) {
            $forms[$post->ID] = $post->post_title;
        }
        return $forms;
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        if (!empty($settings['form_id'])) {
            echo '<div class="icon-cf7-wrapper">';
            echo do_shortcode('[contact-form-7 id="' . esc_attr($settings['form_id']) . '"]');
            echo '</div>';
        } else {
            echo '<div class="elementor-alert elementor-alert-warning">' . __('Please select a Contact Form 7 form.', 'spater') . '</div>';
        }
    }
}