<?php
namespace JR_Addons\Elementor\Widgets\SingleProduct;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Text_Shadow;

if ( ! defined( 'ABSPATH' ) ) exit;

class Product_Description extends Widget_Base {

    public function get_name() {
        return 'jr_product_description';
    }

    public function get_title() {
        return __( 'Product Description', 'jr-addons' );
    }

    public function get_icon() {
        return 'jr-get-icon';
    }

    public function get_categories() {
        return [ 'jr-wc' ];
    }

    public function get_keywords() {
        return [ 'product', 'description', 'long', 'content', 'jr' ];
    }

    public function get_style_depends() {
        return [ 'jr-product-description' ];
    }

    public function get_script_depends() {
        return [ 'jr-product-description' ];
    }

    protected function register_controls() {

        // ========================================
        // CONTENT TAB - General Settings
        // ========================================
        $this->start_controls_section(
            'section_general',
            [
                'label' => __( 'General Settings', 'jr-addons' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'content_source',
            [
                'label'   => __( 'Content Source', 'jr-addons' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'auto',
                'options' => [
                    'auto'   => __( 'Auto (Product Description)', 'jr-addons' ),
                    'custom' => __( 'Custom Text', 'jr-addons' ),
                ],
            ]
        );

        $this->add_control(
            'custom_description',
            [
                'label'     => __( 'Custom Description', 'jr-addons' ),
                'type'      => Controls_Manager::WYSIWYG,
                'default'   => __( 'Enter your custom product description here...', 'jr-addons' ),
                'condition' => [
                    'content_source' => 'custom',
                ],
            ]
        );

        $this->add_control(
            'fallback_text',
            [
                'label'       => __( 'Fallback Text', 'jr-addons' ),
                'type'        => Controls_Manager::TEXTAREA,
                'default'     => __( 'No description available for this product.', 'jr-addons' ),
                'description' => __( 'Shown when no product description is found.', 'jr-addons' ),
                'condition'   => [
                    'content_source' => 'auto',
                ],
            ]
        );

        $this->add_control(
            'hide_if_empty',
            [
                'label'        => __( 'Hide If Empty', 'jr-addons' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Yes', 'jr-addons' ),
                'label_off'    => __( 'No', 'jr-addons' ),
                'return_value' => 'yes',
                'default'      => '',
                'description'  => __( 'Hide widget entirely if description is empty.', 'jr-addons' ),
                'condition'    => [
                    'content_source' => 'auto',
                ],
            ]
        );

        $this->end_controls_section();

        // ========================================
        // CONTENT TAB - Heading Settings
        // ========================================
        $this->start_controls_section(
            'section_heading',
            [
                'label' => __( 'Section Heading', 'jr-addons' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_heading',
            [
                'label'        => __( 'Show Heading', 'jr-addons' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Show', 'jr-addons' ),
                'label_off'    => __( 'Hide', 'jr-addons' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'heading_text',
            [
                'label'     => __( 'Heading Text', 'jr-addons' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => __( 'Description', 'jr-addons' ),
                'condition' => [
                    'show_heading' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'heading_tag',
            [
                'label'     => __( 'Heading Tag', 'jr-addons' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'h3',
                'options'   => [
                    'h1'   => 'H1',
                    'h2'   => 'H2',
                    'h3'   => 'H3',
                    'h4'   => 'H4',
                    'h5'   => 'H5',
                    'h6'   => 'H6',
                    'div'  => 'DIV',
                    'span' => 'SPAN',
                    'p'    => 'P',
                ],
                'condition' => [
                    'show_heading' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'heading_icon',
            [
                'label'     => __( 'Heading Icon', 'jr-addons' ),
                'type'      => Controls_Manager::ICONS,
                'default'   => [
                    'value'   => '',
                    'library' => '',
                ],
                'condition' => [
                    'show_heading' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'heading_icon_position',
            [
                'label'     => __( 'Icon Position', 'jr-addons' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'before',
                'options'   => [
                    'before' => __( 'Before Text', 'jr-addons' ),
                    'after'  => __( 'After Text', 'jr-addons' ),
                ],
                'condition' => [
                    'show_heading'         => 'yes',
                    'heading_icon[value]!' => '',
                ],
            ]
        );

        $this->end_controls_section();

        // ========================================
        // CONTENT TAB - Read More Settings
        // ========================================
        $this->start_controls_section(
            'section_read_more',
            [
                'label' => __( 'Read More / Collapse', 'jr-addons' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'enable_read_more',
            [
                'label'        => __( 'Enable Read More', 'jr-addons' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Yes', 'jr-addons' ),
                'label_off'    => __( 'No', 'jr-addons' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'word_limit',
            [
                'label'     => __( 'Word Limit', 'jr-addons' ),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 50,
                'min'       => 10,
                'max'       => 1000,
                'step'      => 5,
                'condition' => [
                    'enable_read_more' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'read_more_text',
            [
                'label'     => __( 'Read More Text', 'jr-addons' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => __( 'Read More', 'jr-addons' ),
                'condition' => [
                    'enable_read_more' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'read_less_text',
            [
                'label'     => __( 'Read Less Text', 'jr-addons' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => __( 'Read Less', 'jr-addons' ),
                'condition' => [
                    'enable_read_more' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'read_more_icon',
            [
                'label'     => __( 'Read More Icon', 'jr-addons' ),
                'type'      => Controls_Manager::ICONS,
                'default'   => [
                    'value'   => 'fas fa-chevron-down',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    'enable_read_more' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'read_less_icon',
            [
                'label'     => __( 'Read Less Icon', 'jr-addons' ),
                'type'      => Controls_Manager::ICONS,
                'default'   => [
                    'value'   => 'fas fa-chevron-up',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    'enable_read_more' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'gradient_overlay',
            [
                'label'        => __( 'Fade Gradient Overlay', 'jr-addons' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Yes', 'jr-addons' ),
                'label_off'    => __( 'No', 'jr-addons' ),
                'return_value' => 'yes',
                'default'      => 'yes',
                'description'  => __( 'Show a gradient fade at the bottom when collapsed.', 'jr-addons' ),
                'condition'    => [
                    'enable_read_more' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'animation_speed',
            [
                'label'     => __( 'Animation Speed (ms)', 'jr-addons' ),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 400,
                'min'       => 100,
                'max'       => 2000,
                'step'      => 50,
                'condition' => [
                    'enable_read_more' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        // ========================================
        // CONTENT TAB - Separator Settings
        // ========================================
        $this->start_controls_section(
            'section_separator',
            [
                'label' => __( 'Separator Lines', 'jr-addons' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'separator_position',
            [
                'label'   => __( 'Separator Position', 'jr-addons' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'none',
                'options' => [
                    'none'   => __( 'None', 'jr-addons' ),
                    'top'    => __( 'Top', 'jr-addons' ),
                    'bottom' => __( 'Bottom', 'jr-addons' ),
                    'both'   => __( 'Both', 'jr-addons' ),
                ],
            ]
        );

        $this->end_controls_section();

        // ========================================
        // STYLE TAB - Container Style
        // ========================================
        $this->start_controls_section(
            'section_style_container',
            [
                'label' => __( 'Container', 'jr-addons' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'container_background',
                'label'    => __( 'Background', 'jr-addons' ),
                'types'    => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .jr-long-desc-wrapper',
            ]
        );

        $this->add_responsive_control(
            'container_padding',
            [
                'label'      => __( 'Padding', 'jr-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'default'    => [
                    'top'    => '20',
                    'right'  => '20',
                    'bottom' => '20',
                    'left'   => '20',
                    'unit'   => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .jr-long-desc-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'container_margin',
            [
                'label'      => __( 'Margin', 'jr-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .jr-long-desc-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'container_border',
                'selector' => '{{WRAPPER}} .jr-long-desc-wrapper',
            ]
        );

        $this->add_responsive_control(
            'container_border_radius',
            [
                'label'      => __( 'Border Radius', 'jr-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .jr-long-desc-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'container_box_shadow',
                'selector' => '{{WRAPPER}} .jr-long-desc-wrapper',
            ]
        );

        $this->end_controls_section();

        // ========================================
        // STYLE TAB - Heading Style
        // ========================================
        $this->start_controls_section(
            'section_style_heading',
            [
                'label'     => __( 'Heading', 'jr-addons' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_heading' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'heading_color',
            [
                'label'     => __( 'Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#1a1a1a',
                'selectors' => [
                    '{{WRAPPER}} .jr-long-desc-heading' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'heading_typography',
                'selector' => '{{WRAPPER}} .jr-long-desc-heading',
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'     => 'heading_text_shadow',
                'selector' => '{{WRAPPER}} .jr-long-desc-heading',
            ]
        );

        $this->add_responsive_control(
            'heading_alignment',
            [
                'label'   => __( 'Alignment', 'jr-addons' ),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'left'   => [
                        'title' => __( 'Left', 'jr-addons' ),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'jr-addons' ),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right'  => [
                        'title' => __( 'Right', 'jr-addons' ),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default'   => 'left',
                'selectors' => [
                    '{{WRAPPER}} .jr-long-desc-heading-wrap' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'heading_spacing',
            [
                'label'      => __( 'Bottom Spacing', 'jr-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em' ],
                'range'      => [
                    'px' => [ 'min' => 0, 'max' => 60 ],
                ],
                'default' => [
                    'size' => 15,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .jr-long-desc-heading-wrap' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'heading_icon_color',
            [
                'label'     => __( 'Icon Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#FF8C00',
                'selectors' => [
                    '{{WRAPPER}} .jr-long-desc-heading-icon'     => 'color: {{VALUE}};',
                    '{{WRAPPER}} .jr-long-desc-heading-icon svg' => 'fill: {{VALUE}};',
                ],
                'condition' => [
                    'heading_icon[value]!' => '',
                ],
            ]
        );

        $this->add_responsive_control(
            'heading_icon_size',
            [
                'label'      => __( 'Icon Size', 'jr-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [
                    'px' => [ 'min' => 10, 'max' => 60 ],
                ],
                'default' => [
                    'size' => 20,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .jr-long-desc-heading-icon'     => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .jr-long-desc-heading-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'heading_icon[value]!' => '',
                ],
            ]
        );

        $this->add_responsive_control(
            'heading_icon_gap',
            [
                'label'      => __( 'Icon Gap', 'jr-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [
                    'px' => [ 'min' => 0, 'max' => 30 ],
                ],
                'default' => [
                    'size' => 8,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .jr-long-desc-heading' => 'gap: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'heading_icon[value]!' => '',
                ],
            ]
        );

        $this->add_control(
            'heading_border_bottom',
            [
                'label'        => __( 'Heading Underline', 'jr-addons' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Yes', 'jr-addons' ),
                'label_off'    => __( 'No', 'jr-addons' ),
                'return_value' => 'yes',
                'default'      => '',
            ]
        );

        $this->add_control(
            'heading_underline_color',
            [
                'label'     => __( 'Underline Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#FF8C00',
                'selectors' => [
                    '{{WRAPPER}} .jr-long-desc-heading-wrap.has-underline' => 'border-bottom-color: {{VALUE}};',
                ],
                'condition' => [
                    'heading_border_bottom' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'heading_underline_width',
            [
                'label'      => __( 'Underline Width', 'jr-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [
                    'px' => [ 'min' => 1, 'max' => 5 ],
                ],
                'default' => [
                    'size' => 2,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .jr-long-desc-heading-wrap.has-underline' => 'border-bottom-width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'heading_border_bottom' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'heading_underline_padding',
            [
                'label'      => __( 'Underline Spacing', 'jr-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [
                    'px' => [ 'min' => 0, 'max' => 30 ],
                ],
                'default' => [
                    'size' => 10,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .jr-long-desc-heading-wrap.has-underline' => 'padding-bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'heading_border_bottom' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        // ========================================
        // STYLE TAB - Content Style
        // ========================================
        $this->start_controls_section(
            'section_style_content',
            [
                'label' => __( 'Description Content', 'jr-addons' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'content_color',
            [
                'label'     => __( 'Text Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#444444',
                'selectors' => [
                    '{{WRAPPER}} .jr-long-desc-content'   => 'color: {{VALUE}};',
                    '{{WRAPPER}} .jr-long-desc-content p' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'content_typography',
                'selector' => '{{WRAPPER}} .jr-long-desc-content, {{WRAPPER}} .jr-long-desc-content p',
            ]
        );

        $this->add_responsive_control(
            'content_alignment',
            [
                'label'   => __( 'Text Alignment', 'jr-addons' ),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'left'    => [
                        'title' => __( 'Left', 'jr-addons' ),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center'  => [
                        'title' => __( 'Center', 'jr-addons' ),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right'   => [
                        'title' => __( 'Right', 'jr-addons' ),
                        'icon'  => 'eicon-text-align-right',
                    ],
                    'justify' => [
                        'title' => __( 'Justify', 'jr-addons' ),
                        'icon'  => 'eicon-text-align-justify',
                    ],
                ],
                'default'   => 'left',
                'selectors' => [
                    '{{WRAPPER}} .jr-long-desc-content' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'content_line_height_custom',
            [
                'label'      => __( 'Line Height', 'jr-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em' ],
                'range'      => [
                    'px' => [ 'min' => 10, 'max' => 60 ],
                    'em' => [ 'min' => 1, 'max' => 4, 'step' => 0.1 ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .jr-long-desc-content'   => 'line-height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .jr-long-desc-content p' => 'line-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'content_link_heading',
            [
                'label'     => __( 'Links Inside Content', 'jr-addons' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'content_link_color',
            [
                'label'     => __( 'Link Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#FF8C00',
                'selectors' => [
                    '{{WRAPPER}} .jr-long-desc-content a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'content_link_hover_color',
            [
                'label'     => __( 'Link Hover Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#e07b00',
                'selectors' => [
                    '{{WRAPPER}} .jr-long-desc-content a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'content_inner_heading_divider',
            [
                'label'     => __( 'Headings Inside Content', 'jr-addons' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'content_inner_heading_color',
            [
                'label'     => __( 'Heading Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#1a1a1a',
                'selectors' => [
                    '{{WRAPPER}} .jr-long-desc-content h1,
                     {{WRAPPER}} .jr-long-desc-content h2,
                     {{WRAPPER}} .jr-long-desc-content h3,
                     {{WRAPPER}} .jr-long-desc-content h4,
                     {{WRAPPER}} .jr-long-desc-content h5,
                     {{WRAPPER}} .jr-long-desc-content h6' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'content_list_heading',
            [
                'label'     => __( 'Lists Inside Content', 'jr-addons' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'content_list_color',
            [
                'label'     => __( 'List Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .jr-long-desc-content ul li,
                     {{WRAPPER}} .jr-long-desc-content ol li' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'content_list_spacing',
            [
                'label'      => __( 'List Item Spacing', 'jr-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [
                    'px' => [ 'min' => 0, 'max' => 30 ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .jr-long-desc-content ul li,
                     {{WRAPPER}} .jr-long-desc-content ol li' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'content_images_heading',
            [
                'label'     => __( 'Images Inside Content', 'jr-addons' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'content_img_max_width',
            [
                'label'      => __( 'Image Max Width', 'jr-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ '%', 'px' ],
                'range'      => [
                    '%'  => [ 'min' => 10, 'max' => 100 ],
                    'px' => [ 'min' => 50, 'max' => 1200 ],
                ],
                'default' => [
                    'size' => 100,
                    'unit' => '%',
                ],
                'selectors' => [
                    '{{WRAPPER}} .jr-long-desc-content img' => 'max-width: {{SIZE}}{{UNIT}}; height: auto;',
                ],
            ]
        );

        $this->add_responsive_control(
            'content_img_border_radius',
            [
                'label'      => __( 'Image Border Radius', 'jr-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .jr-long-desc-content img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // ========================================
        // STYLE TAB - Gradient Overlay
        // ========================================
        $this->start_controls_section(
            'section_style_gradient',
            [
                'label'     => __( 'Gradient Overlay', 'jr-addons' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'enable_read_more' => 'yes',
                    'gradient_overlay' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'gradient_height',
            [
                'label'      => __( 'Gradient Height', 'jr-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [
                    'px' => [ 'min' => 20, 'max' => 150 ],
                ],
                'default' => [
                    'size' => 60,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .jr-long-desc-body.is-collapsed .jr-long-desc-gradient' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'gradient_color',
            [
                'label'       => __( 'Gradient Color', 'jr-addons' ),
                'type'        => Controls_Manager::COLOR,
                'default'     => '#ffffff',
                'description' => __( 'Should match your container background color.', 'jr-addons' ),
            ]
        );

        $this->end_controls_section();

        // ========================================
        // STYLE TAB - Read More Button
        // ========================================
        $this->start_controls_section(
            'section_style_read_more',
            [
                'label'     => __( 'Read More Button', 'jr-addons' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'enable_read_more' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'read_more_typography',
                'selector' => '{{WRAPPER}} .jr-long-desc-toggle',
            ]
        );

        $this->add_responsive_control(
            'read_more_alignment',
            [
                'label'   => __( 'Alignment', 'jr-addons' ),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => __( 'Left', 'jr-addons' ),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'jr-addons' ),
                        'icon'  => 'eicon-h-align-center',
                    ],
                    'flex-end' => [
                        'title' => __( 'Right', 'jr-addons' ),
                        'icon'  => 'eicon-h-align-right',
                    ],
                ],
                'default'   => 'flex-start',
                'selectors' => [
                    '{{WRAPPER}} .jr-long-desc-toggle-wrap' => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'read_more_top_spacing',
            [
                'label'      => __( 'Top Spacing', 'jr-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [
                    'px' => [ 'min' => 0, 'max' => 40 ],
                ],
                'default' => [
                    'size' => 12,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .jr-long-desc-toggle-wrap' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'read_more_icon_gap',
            [
                'label'      => __( 'Icon Gap', 'jr-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [
                    'px' => [ 'min' => 0, 'max' => 20 ],
                ],
                'default' => [
                    'size' => 6,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .jr-long-desc-toggle' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'read_more_icon_size',
            [
                'label'      => __( 'Icon Size', 'jr-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [
                    'px' => [ 'min' => 8, 'max' => 30 ],
                ],
                'default' => [
                    'size' => 12,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .jr-long-desc-toggle i'   => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .jr-long-desc-toggle svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'read_more_tabs' );

        $this->start_controls_tab(
            'read_more_tab_normal',
            [ 'label' => __( 'Normal', 'jr-addons' ) ]
        );

        $this->add_control(
            'read_more_color',
            [
                'label'     => __( 'Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#FF8C00',
                'selectors' => [
                    '{{WRAPPER}} .jr-long-desc-toggle'     => 'color: {{VALUE}};',
                    '{{WRAPPER}} .jr-long-desc-toggle svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'read_more_bg_color',
            [
                'label'     => __( 'Background Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => 'transparent',
                'selectors' => [
                    '{{WRAPPER}} .jr-long-desc-toggle' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'read_more_border',
                'selector' => '{{WRAPPER}} .jr-long-desc-toggle',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'read_more_tab_hover',
            [ 'label' => __( 'Hover', 'jr-addons' ) ]
        );

        $this->add_control(
            'read_more_color_hover',
            [
                'label'     => __( 'Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#e07b00',
                'selectors' => [
                    '{{WRAPPER}} .jr-long-desc-toggle:hover'     => 'color: {{VALUE}};',
                    '{{WRAPPER}} .jr-long-desc-toggle:hover svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'read_more_bg_color_hover',
            [
                'label'     => __( 'Background Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .jr-long-desc-toggle:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'read_more_border_color_hover',
            [
                'label'     => __( 'Border Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .jr-long-desc-toggle:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'read_more_padding',
            [
                'label'      => __( 'Padding', 'jr-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em' ],
                'separator'  => 'before',
                'selectors'  => [
                    '{{WRAPPER}} .jr-long-desc-toggle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'read_more_border_radius',
            [
                'label'      => __( 'Border Radius', 'jr-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .jr-long-desc-toggle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // ========================================
        // STYLE TAB - Separator Style
        // ========================================
        $this->start_controls_section(
            'section_style_separator',
            [
                'label'     => __( 'Separator Lines', 'jr-addons' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'separator_position!' => 'none',
                ],
            ]
        );

        $this->add_control(
            'separator_color',
            [
                'label'     => __( 'Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#e5e5e5',
                'selectors' => [
                    '{{WRAPPER}} .jr-long-desc-separator' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'separator_height',
            [
                'label'      => __( 'Height', 'jr-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [
                    'px' => [ 'min' => 1, 'max' => 10 ],
                ],
                'default' => [
                    'size' => 1,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .jr-long-desc-separator' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'separator_width',
            [
                'label'      => __( 'Width', 'jr-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ '%', 'px' ],
                'range'      => [
                    '%' => [ 'min' => 10, 'max' => 100 ],
                ],
                'default' => [
                    'size' => 100,
                    'unit' => '%',
                ],
                'selectors' => [
                    '{{WRAPPER}} .jr-long-desc-separator' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'separator_spacing',
            [
                'label'      => __( 'Spacing', 'jr-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [
                    'px' => [ 'min' => 0, 'max' => 40 ],
                ],
                'default' => [
                    'size' => 15,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .jr-long-desc-separator.sep-top'    => 'margin-bottom: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .jr-long-desc-separator.sep-bottom' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * ✅ SAFE description formatting
     * the_content filter use kori NA - WooCommerce hooks inject kore
     * Instead: wpautop + shortcode + do_blocks safely use kori
     */
    private function jr_safe_format_description( $raw_description ) {
        if ( empty( $raw_description ) ) {
            return '';
        }

        // Step 1: Process shortcodes
        $content = do_shortcode( $raw_description );

        // Step 2: Process Gutenberg blocks (if any)
        if ( function_exists( 'do_blocks' ) ) {
            $content = do_blocks( $content );
        }

        // Step 3: Auto paragraphs
        $content = wpautop( $content );

        // Step 4: Convert smilies
        $content = convert_smilies( $content );

        // Step 5: Fix any broken HTML entity
        $content = str_replace( ']]>', ']]&gt;', $content );

        return $content;
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        // ===========================
        // GET DESCRIPTION - SAFE WAY
        // ===========================
        $description = '';

        if ( 'custom' === $settings['content_source'] ) {
            // Custom text - user input
            $description = $settings['custom_description'];
        } else {
            // Auto - from WooCommerce product
            global $product;

            // Try to get product object
            if ( ! $product || ! is_a( $product, 'WC_Product' ) ) {
                if ( function_exists( 'wc_get_product' ) ) {
                    $product = wc_get_product( get_the_ID() );
                }
            }

            if ( $product && is_a( $product, 'WC_Product' ) ) {
                // ✅ get_description() = ONLY the long description
                // NOT the full page content with tabs/gallery/related
                $description = $product->get_description();
            }

            // Editor preview fallback
            if ( empty( $description ) && \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
                $description = '<p>এটি একটি স্যাম্পল প্রোডাক্ট লং ডেসক্রিপশন। এডিটর প্রিভিউ এর জন্য দেখানো হচ্ছে।</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                <h4>প্রোডাক্ট ফিচার্স</h4>
                <ul>
                    <li>উচ্চমানের ম্যাটেরিয়াল</li>
                    <li>টেকসই ও দীর্ঘস্থায়ী</li>
                    <li>ব্যবহার সহজ</li>
                    <li>একাধিক রঙে পাওয়া যায়</li>
                </ul>
                <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>';
            }
        }

        // Hide if empty
        if ( empty( $description ) && 'yes' === $settings['hide_if_empty'] && 'auto' === $settings['content_source'] ) {
            return;
        }

        // Fallback text
        if ( empty( $description ) && 'auto' === $settings['content_source'] && ! empty( $settings['fallback_text'] ) ) {
            $description = $settings['fallback_text'];
        }

        // ✅ SAFE formatting - NO apply_filters('the_content')
        $description = $this->jr_safe_format_description( $description );

        if ( empty( $description ) ) {
            return;
        }

        // Word limit check
        $enable_read_more = 'yes' === $settings['enable_read_more'];
        $word_limit        = intval( $settings['word_limit'] );
        $needs_toggle      = false;

        if ( $enable_read_more && $word_limit > 0 ) {
            $stripped = wp_strip_all_tags( $description );
            $words    = preg_split( '/\s+/', trim( $stripped ) );
            if ( count( $words ) > $word_limit ) {
                $needs_toggle = true;
            }
        }

        // Settings for JS
        $gradient_color  = ! empty( $settings['gradient_color'] ) ? $settings['gradient_color'] : '#ffffff';
        $animation_speed = ! empty( $settings['animation_speed'] ) ? intval( $settings['animation_speed'] ) : 400;
        $separator_pos   = $settings['separator_position'];

        $widget_data = [
            'wordLimit'      => $word_limit,
            'enableToggle'   => $needs_toggle,
            'animationSpeed' => $animation_speed,
            'readMoreText'   => esc_html( $settings['read_more_text'] ),
            'readLessText'   => esc_html( $settings['read_less_text'] ),
            'gradientColor'  => esc_attr( $gradient_color ),
        ];

        ?>
        <div class="jr-long-desc-wrapper" data-settings='<?php echo esc_attr( wp_json_encode( $widget_data ) ); ?>'>

            <?php if ( in_array( $separator_pos, [ 'top', 'both' ], true ) ) : ?>
                <div class="jr-long-desc-separator sep-top"></div>
            <?php endif; ?>

            <?php if ( 'yes' === $settings['show_heading'] && ! empty( $settings['heading_text'] ) ) :
                $heading_classes = 'jr-long-desc-heading-wrap';
                if ( 'yes' === $settings['heading_border_bottom'] ) {
                    $heading_classes .= ' has-underline';
                }
                $heading_tag = $settings['heading_tag'];
                $has_icon    = ! empty( $settings['heading_icon']['value'] );
                $icon_pos    = $settings['heading_icon_position'];
            ?>
                <div class="<?php echo esc_attr( $heading_classes ); ?>">
                    <<?php echo esc_attr( $heading_tag ); ?> class="jr-long-desc-heading">
                        <?php if ( $has_icon && 'before' === $icon_pos ) : ?>
                            <span class="jr-long-desc-heading-icon">
                                <?php \Elementor\Icons_Manager::render_icon( $settings['heading_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                            </span>
                        <?php endif; ?>

                        <span class="jr-long-desc-heading-text"><?php echo esc_html( $settings['heading_text'] ); ?></span>

                        <?php if ( $has_icon && 'after' === $icon_pos ) : ?>
                            <span class="jr-long-desc-heading-icon">
                                <?php \Elementor\Icons_Manager::render_icon( $settings['heading_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                            </span>
                        <?php endif; ?>
                    </<?php echo esc_attr( $heading_tag ); ?>>
                </div>
            <?php endif; ?>

            <div class="jr-long-desc-body<?php echo $needs_toggle ? ' is-collapsed' : ''; ?>">
                <div class="jr-long-desc-content">
                    <?php echo $description; // Already safely formatted ?>
                </div>

                <?php if ( $needs_toggle && 'yes' === $settings['gradient_overlay'] ) : ?>
                    <div class="jr-long-desc-gradient" style="background: linear-gradient(to bottom, transparent, <?php echo esc_attr( $gradient_color ); ?>);"></div>
                <?php endif; ?>
            </div>

            <?php if ( $needs_toggle ) : ?>
                <div class="jr-long-desc-toggle-wrap">
                    <button type="button" class="jr-long-desc-toggle" aria-expanded="false">
                        <span class="jr-toggle-text"><?php echo esc_html( $settings['read_more_text'] ); ?></span>
                        <?php if ( ! empty( $settings['read_more_icon']['value'] ) ) : ?>
                            <span class="jr-toggle-icon jr-toggle-icon-more">
                                <?php \Elementor\Icons_Manager::render_icon( $settings['read_more_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                            </span>
                        <?php endif; ?>
                        <?php if ( ! empty( $settings['read_less_icon']['value'] ) ) : ?>
                            <span class="jr-toggle-icon jr-toggle-icon-less" style="display:none;">
                                <?php \Elementor\Icons_Manager::render_icon( $settings['read_less_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                            </span>
                        <?php endif; ?>
                    </button>
                </div>
            <?php endif; ?>

            <?php if ( in_array( $separator_pos, [ 'bottom', 'both' ], true ) ) : ?>
                <div class="jr-long-desc-separator sep-bottom"></div>
            <?php endif; ?>

        </div>
        <?php
    }

    protected function content_template() {
        ?>
        <#
        var description = '';
        if ( settings.content_source === 'custom' ) {
            description = settings.custom_description || '';
        } else {
            description = '<p>এটি একটি স্যাম্পল প্রোডাক্ট লং ডেসক্রিপশন।</p><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt.</p><h4>প্রোডাক্ট ফিচার্স</h4><ul><li>উচ্চমানের ম্যাটেরিয়াল</li><li>টেকসই</li><li>ব্যবহার সহজ</li></ul>';
        }

        if ( ! description && settings.hide_if_empty === 'yes' && settings.content_source === 'auto' ) {
            return;
        }

        if ( ! description && settings.content_source === 'auto' && settings.fallback_text ) {
            description = '<p>' + settings.fallback_text + '</p>';
        }

        var separatorPos = settings.separator_position;
        var headingClasses = 'jr-long-desc-heading-wrap';
        if ( settings.heading_border_bottom === 'yes' ) {
            headingClasses += ' has-underline';
        }
        var headingTag = settings.heading_tag || 'h3';
        var hasIcon = settings.heading_icon && settings.heading_icon.value;
        var iconPos = settings.heading_icon_position || 'before';
        #>

        <div class="jr-long-desc-wrapper">

            <# if ( separatorPos === 'top' || separatorPos === 'both' ) { #>
                <div class="jr-long-desc-separator sep-top"></div>
            <# } #>

            <# if ( settings.show_heading === 'yes' && settings.heading_text ) { #>
                <div class="{{ headingClasses }}">
                    <{{{ headingTag }}} class="jr-long-desc-heading">
                        <# if ( hasIcon && iconPos === 'before' ) { #>
                            <span class="jr-long-desc-heading-icon">
                                <i class="{{ settings.heading_icon.value }}"></i>
                            </span>
                        <# } #>
                        <span class="jr-long-desc-heading-text">{{{ settings.heading_text }}}</span>
                        <# if ( hasIcon && iconPos === 'after' ) { #>
                            <span class="jr-long-desc-heading-icon">
                                <i class="{{ settings.heading_icon.value }}"></i>
                            </span>
                        <# } #>
                    </{{{ headingTag }}}>
                </div>
            <# } #>

            <div class="jr-long-desc-body">
                <div class="jr-long-desc-content">
                    {{{ description }}}
                </div>
            </div>

            <# if ( settings.enable_read_more === 'yes' ) { #>
                <div class="jr-long-desc-toggle-wrap">
                    <button type="button" class="jr-long-desc-toggle">
                        <span class="jr-toggle-text">{{{ settings.read_more_text }}}</span>
                        <# if ( settings.read_more_icon && settings.read_more_icon.value ) { #>
                            <span class="jr-toggle-icon jr-toggle-icon-more">
                                <i class="{{ settings.read_more_icon.value }}"></i>
                            </span>
                        <# } #>
                    </button>
                </div>
            <# } #>

            <# if ( separatorPos === 'bottom' || separatorPos === 'both' ) { #>
                <div class="jr-long-desc-separator sep-bottom"></div>
            <# } #>

        </div>
        <?php
    }
}