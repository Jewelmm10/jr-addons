<?php

namespace JR_Addons\Elementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

if (!defined('ABSPATH')) exit;

class Section_Title extends Widget_Base {

    public function get_name() {
        return 'jr_section_title';
    }

    public function get_title() {
        return __('Section Title', 'spater-core');
    }

    public function get_icon() {
        return 'jr-get-icon';
    }

    public function get_categories() {
        return ['jr-addons'];
    }

    protected function register_controls() {

        /*
        |--------------------------------------------------------------------------
        | CONTENT
        |--------------------------------------------------------------------------
        */

        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'spater-core'),
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __('Title', 'spater-core'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Organic Certified', 'spater-core'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'link_text',
            [
                'label' => __('Link Text', 'spater-core'),
                'type' => Controls_Manager::TEXT,
                'default' => __('VIEW ALL ITEMS', 'spater-core'),
            ]
        );

        $this->add_control(
            'link_url',
            [
                'label' => __('Link URL', 'spater-core'),
                'type' => Controls_Manager::URL,
                'default' => [
                    'url' => '#',
                ],
                'show_external' => true,
            ]
        );

        $this->end_controls_section();

        /*
        |--------------------------------------------------------------------------
        | SECTION STYLE
        |--------------------------------------------------------------------------
        */

        $this->start_controls_section(
            'section_style',
            [
                'label' => __('Section', 'spater-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'section_alignment',
            [
                'label' => __('Alignment', 'spater-core'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => __('Left', 'spater-core'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'spater-core'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'space-between' => [
                        'title' => __('Between', 'spater-core'),
                        'icon' => 'eicon-h-align-stretch',
                    ],
                ],
                'default' => 'space-between',
                'selectors' => [
                    '{{WRAPPER}} .jr-section-header' => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'section_bg',
            [
                'label' => __('Background', 'spater-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .jr-section-header' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'section_padding',
            [
                'label' => __('Padding', 'spater-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .jr-section-header' =>
                        'padding: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                ],
            ]
        );

        $this->add_responsive_control(
            'section_margin',
            [
                'label' => __('Margin', 'spater-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .jr-section-header' =>
                        'margin: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'section_border',
                'selector' => '{{WRAPPER}} .jr-section-header',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'section_shadow',
                'selector' => '{{WRAPPER}} .jr-section-header',
            ]
        );

        $this->end_controls_section();

        /*
        |--------------------------------------------------------------------------
        | TITLE STYLE
        |--------------------------------------------------------------------------
        */

        $this->start_controls_section(
            'title_style',
            [
                'label' => __('Title', 'spater-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __('Color', 'spater-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .jr-section-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .jr-section-title',
            ]
        );

        $this->add_responsive_control(
            'title_spacing',
            [
                'label' => __('Bottom Space', 'spater-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .jr-section-title' =>
                        'margin-bottom: {{SIZE}}px;',
                ],
            ]
        );

        $this->end_controls_section();

        /*
        |--------------------------------------------------------------------------
        | LINK STYLE
        |--------------------------------------------------------------------------
        */

        $this->start_controls_section(
            'link_style',
            [
                'label' => __('Link', 'spater-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('link_tabs');

        // Normal Tab
        $this->start_controls_tab(
            'link_normal',
            [
                'label' => __('Normal', 'spater-core'),
            ]
        );

        $this->add_control(
            'link_color',
            [
                'label' => __('Color', 'spater-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .jr-section-link' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        // Hover Tab
        $this->start_controls_tab(
            'link_hover',
            [
                'label' => __('Hover', 'spater-core'),
            ]
        );

        $this->add_control(
            'link_hover_color',
            [
                'label' => __('Hover Color', 'spater-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .jr-section-link:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'link_typography',
                'selector' => '{{WRAPPER}} .jr-section-link',
            ]
        );

        $this->add_responsive_control(
            'link_gap',
            [
                'label' => __('Gap', 'spater-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .jr-section-link' =>
                        'gap: {{SIZE}}px;',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label' => __('Icon Size', 'spater-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 8,
                        'max' => 50,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .jr-section-link svg' =>
                        'width: {{SIZE}}px; height: {{SIZE}}px;',
                ],
            ]
        );

        $this->end_controls_section();

        /*
        |--------------------------------------------------------------------------
        | LINE STYLE
        |--------------------------------------------------------------------------
        */

        $this->start_controls_section(
            'line_style',
            [
                'label' => __('Shape Line', 'spater-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'line_color',
            [
                'label' => __('Color', 'spater-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '#f97316',
                'selectors' => [
                    '{{WRAPPER}} .jr-title-shape' =>
                        'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'line_width',
            [
                'label' => __('Width', 'spater-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 300,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .jr-title-shape' =>
                        'width: {{SIZE}}px;',
                ],
            ]
        );

        $this->add_responsive_control(
            'line_height',
            [
                'label' => __('Height', 'spater-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 20,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .jr-title-shape' =>
                        'height: {{SIZE}}px;',
                ],
            ]
        );

        $this->add_responsive_control(
            'line_radius',
            [
                'label' => __('Border Radius', 'spater-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .jr-title-shape' =>
                        'border-radius: {{SIZE}}px;',
                ],
            ]
        );

        $this->add_responsive_control(
            'line_margin',
            [
                'label' => __('Margin', 'spater-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .jr-title-shape' =>
                        'margin: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {

        $settings = $this->get_settings_for_display();

        $target = $settings['link_url']['is_external'] ? ' target="_blank"' : '';
        $nofollow = $settings['link_url']['nofollow'] ? ' rel="nofollow"' : '';

        ?>

        <div class="jr-section-header">

            <div class="jr-section-left">

                <h2 class="jr-section-title">
                    <?php echo esc_html($settings['title']); ?>
                </h2>

                <span class="jr-title-shape"></span>

            </div>

            <?php if (!empty($settings['link_text'])) : ?>

                <a 
                    href="<?php echo esc_url($settings['link_url']['url']); ?>"
                    class="jr-section-link"
                    <?php echo $target . $nofollow; ?>
                >

                    <span>
                        <?php echo esc_html($settings['link_text']); ?>
                    </span>

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="16"
                        height="16"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                        <polyline points="12 5 19 12 12 19"></polyline>
                    </svg>

                </a>

            <?php endif; ?>

        </div>

        <?php
    }
}