<?php
namespace JR_Addons\Elementor\Widgets;

if (!defined('ABSPATH')) exit;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Icons_Manager;
use Elementor\Utils;

class Slider extends Widget_Base {

    public function get_name() { return 'jr_slider'; }
    public function get_title() { return esc_html__('JR Slider', 'jr-addons'); }
    public function get_icon() { return 'jr-get-icon'; }
    public function get_categories() { return ['jr-addons']; }
    public function get_keywords() { return ['slider', 'swiper', 'carousel', 'testimonial', 'image']; }

    public function get_script_depends() {
        return ['swiper'];
    }

    public function get_style_depends() {
        return ['swiper', 'e-swiper'];
    }

    protected function register_controls() {

        /* ============================================================
         * SECTION: SLIDER TYPE
         * ============================================================ */
        $this->start_controls_section('section_type', [
            'label' => esc_html__('Slider Type', 'jr-addons'),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('slider_type', [
            'label'   => esc_html__('Slider Style', 'jr-addons'),
            'type'    => Controls_Manager::SELECT,
            'default' => 'image',
            'options' => [
                'image'       => esc_html__('Image / Hero Slider', 'jr-addons'),
                'testimonial' => esc_html__('Testimonial Slider', 'jr-addons'),
            ],
        ]);

        $this->end_controls_section();


        /* ============================================================
         * SECTION: SLIDES (Image Type)
         * ============================================================ */
        $this->start_controls_section('section_slides', [
            'label'     => esc_html__('Image Slides', 'jr-addons'),
            'tab'       => Controls_Manager::TAB_CONTENT,
            'condition' => ['slider_type' => 'image'],
        ]);

        $repeater = new Repeater();

        $repeater->add_control('slide_image', [
            'label'   => esc_html__('Background Image', 'jr-addons'),
            'type'    => Controls_Manager::MEDIA,
            'default' => ['url' => Utils::get_placeholder_image_src()],
        ]);

        $repeater->add_control('title', [
            'label'   => esc_html__('Title', 'jr-addons'),
            'type'    => Controls_Manager::TEXT,
            'default' => esc_html__('Slide Title', 'jr-addons'),
        ]);

        $repeater->add_control('description', [
            'label'   => esc_html__('Description', 'jr-addons'),
            'type'    => Controls_Manager::TEXTAREA,
            'default' => esc_html__('Slide description goes here', 'jr-addons'),
        ]);

        $repeater->add_control('button_text', [
            'label'   => esc_html__('Button Text', 'jr-addons'),
            'type'    => Controls_Manager::TEXT,
            'default' => esc_html__('Shop Now', 'jr-addons'),
        ]);

        $repeater->add_control('button_link', [
            'label'   => esc_html__('Button Link', 'jr-addons'),
            'type'    => Controls_Manager::URL,
            'default' => ['url' => '#'],
        ]);

        $this->add_control('slides', [
            'label'       => esc_html__('Slides', 'jr-addons'),
            'type'        => Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'title_field' => '{{{ title }}}',
            'default'     => [
                ['title' => 'Slide One', 'description' => 'First slide description'],
                ['title' => 'Slide Two', 'description' => 'Second slide description'],
            ],
        ]);

        

        $this->end_controls_section();


        /* ============================================================
         * SECTION: TESTIMONIALS
         * ============================================================ */
        $this->start_controls_section('section_testimonials', [
            'label'     => esc_html__('Testimonials', 'jr-addons'),
            'tab'       => Controls_Manager::TAB_CONTENT,
            'condition' => ['slider_type' => 'testimonial'],
        ]);

        $t_repeater = new Repeater();

        $t_repeater->add_control('review', [
            'label'   => esc_html__('Review Text', 'jr-addons'),
            'type'    => Controls_Manager::TEXTAREA,
            'rows'    => 4,
            'default' => esc_html__('Amazing service! Highly recommended.', 'jr-addons'),
        ]);

        $t_repeater->add_control('avatar', [
            'label'   => esc_html__('Avatar', 'jr-addons'),
            'type'    => Controls_Manager::MEDIA,
            'default' => ['url' => Utils::get_placeholder_image_src()],
        ]);

        $t_repeater->add_control('name', [
            'label'   => esc_html__('Name', 'jr-addons'),
            'type'    => Controls_Manager::TEXT,
            'default' => esc_html__('John Doe', 'jr-addons'),
        ]);

        $t_repeater->add_control('designation', [
            'label'   => esc_html__('Designation', 'jr-addons'),
            'type'    => Controls_Manager::TEXT,
            'default' => esc_html__('Customer', 'jr-addons'),
        ]);

        $t_repeater->add_control('rating', [
            'label'   => esc_html__('Rating (1-5)', 'jr-addons'),
            'type'    => Controls_Manager::NUMBER,
            'min'     => 0,
            'max'     => 5,
            'step'    => 1,
            'default' => 5,
        ]);

        $this->add_control('testimonials', [
            'label'       => esc_html__('Testimonials', 'jr-addons'),
            'type'        => Controls_Manager::REPEATER,
            'fields'      => $t_repeater->get_controls(),
            'title_field' => '{{{ name }}}',
            'default'     => [
                ['name' => 'Ayesha Khan', 'designation' => 'Banker'],
                ['name' => 'Fariha Akter', 'designation' => 'Entrepreneur'],
                ['name' => 'Shahriar Khan', 'designation' => 'Service Holder'],
            ],
        ]);

        $this->end_controls_section();


        /* ============================================================
         * SECTION: SLIDER SETTINGS
         * ============================================================ */
        $this->start_controls_section('section_settings', [
            'label' => esc_html__('Slider Settings', 'jr-addons'),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_responsive_control('slides_per_view', [
            'label'   => esc_html__('Slides Per View', 'jr-addons'),
            'type'    => Controls_Manager::NUMBER,
            'min'     => 1,
            'max'     => 6,
            'default' => 1,
            'tablet_default' => 2,
            'mobile_default' => 1,
        ]);

        $this->add_responsive_control('space_between', [
            'label'   => esc_html__('Space Between Slides', 'jr-addons'),
            'type'    => Controls_Manager::NUMBER,
            'min'     => 0,
            'max'     => 100,
            'default' => 20,
        ]);

        $this->add_control('effect', [
            'label'   => esc_html__('Transition Effect', 'jr-addons'),
            'type'    => Controls_Manager::SELECT,
            'default' => 'slide',
            'options' => [
                'slide'     => 'Slide',
                'fade'      => 'Fade',
                'cube'      => 'Cube',
                'coverflow' => 'Coverflow',
                'flip'      => 'Flip',
            ],
        ]);

        $this->add_control('speed', [
            'label'   => esc_html__('Transition Speed (ms)', 'jr-addons'),
            'type'    => Controls_Manager::NUMBER,
            'default' => 600,
            'min'     => 100,
            'max'     => 5000,
        ]);

        $this->add_control('loop', [
            'label'   => esc_html__('Loop', 'jr-addons'),
            'type'    => Controls_Manager::SWITCHER,
            'default' => 'yes',
        ]);

        $this->add_control('autoplay', [
            'label'   => esc_html__('Autoplay', 'jr-addons'),
            'type'    => Controls_Manager::SWITCHER,
            'default' => 'yes',
        ]);

        $this->add_control('delay', [
            'label'     => esc_html__('Autoplay Delay (ms)', 'jr-addons'),
            'type'      => Controls_Manager::NUMBER,
            'default'   => 4000,
            'condition' => ['autoplay' => 'yes'],
        ]);

        $this->add_control('show_arrows', [
            'label'   => esc_html__('Show Arrows', 'jr-addons'),
            'type'    => Controls_Manager::SWITCHER,
            'default' => 'yes',
        ]);

        $this->add_control('show_pagination', [
            'label'   => esc_html__('Show Pagination', 'jr-addons'),
            'type'    => Controls_Manager::SWITCHER,
            'default' => 'yes',
        ]);

        $this->add_control('pagination_type', [
            'label'     => esc_html__('Pagination Type', 'jr-addons'),
            'type'      => Controls_Manager::SELECT,
            'default'   => 'bullets',
            'options'   => [
                'bullets'     => 'Dots',
                'fraction'    => 'Fraction',
                'progressbar' => 'Progress Bar',
            ],
            'condition' => ['show_pagination' => 'yes'],
        ]);

        // Section: Slider Settings এর ভিতরে add করুন
        $this->add_control('equal_height', [
            'label'   => esc_html__('Equal Height Slides', 'jr-addons'),
            'type'    => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'description' => esc_html__('Make all slides same height for consistent design', 'jr-addons'),
        ]);

        $this->add_responsive_control('min_card_height', [
            'label'     => esc_html__('Minimum Card Height', 'jr-addons'),
            'type'      => Controls_Manager::SLIDER,
            'range'     => ['px' => ['min' => 150, 'max' => 500]],
            'default'   => ['unit' => 'px', 'size' => 220],
            'selectors' => [
                '{{WRAPPER}} .jr-testimonial' => 'min-height: {{SIZE}}{{UNIT}};',
            ],
            'condition' => ['equal_height' => 'yes'],
        ]);

        $this->end_controls_section();


        /* ============================================================
         * SECTION: ARROW ICONS
         * ============================================================ */
        $this->start_controls_section('section_arrow_icons', [
            'label'     => esc_html__('Arrow Icons', 'jr-addons'),
            'tab'       => Controls_Manager::TAB_CONTENT,
            'condition' => ['show_arrows' => 'yes'],
        ]);

        $this->add_control('prev_icon', [
            'label'   => esc_html__('Previous Icon', 'jr-addons'),
            'type'    => Controls_Manager::ICONS,
            'default' => [
                'value'   => 'fas fa-arrow-left',
                'library' => 'fa-solid',
            ],
        ]);

        $this->add_control('next_icon', [
            'label'   => esc_html__('Next Icon', 'jr-addons'),
            'type'    => Controls_Manager::ICONS,
            'default' => [
                'value'   => 'fas fa-arrow-right',
                'library' => 'fa-solid',
            ],
        ]);

        $this->end_controls_section();


        /* ============================================================
         * STYLE: SLIDE WRAPPER
         * ============================================================ */
        $this->start_controls_section('style_wrapper', [
            'label' => esc_html__('Slide Card', 'jr-addons'),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_responsive_control('slide_min_height', [
            'label'      => esc_html__('Min Height', 'jr-addons'),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['px', 'vh'],
            'range'      => ['px' => ['min' => 100, 'max' => 1000]],
            'default'    => ['unit' => 'px', 'size' => 400],
            'selectors'  => ['{{WRAPPER}} .jr-slide' => 'min-height: {{SIZE}}{{UNIT}};'],
            'condition'  => ['slider_type' => 'image'],
        ]);

        $this->add_responsive_control('slide_padding', [
            'label'      => esc_html__('Padding', 'jr-addons'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'default'    => ['top' => '30', 'right' => '30', 'bottom' => '30', 'left' => '30', 'unit' => 'px'],
            'selectors'  => ['{{WRAPPER}} .jr-slide' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
        ]);

        $this->add_group_control(Group_Control_Background::get_type(), [
            'name'      => 'slide_bg',
            'types'     => ['classic', 'gradient'],
            'selector'  => '{{WRAPPER}} .jr-slide',
            'condition' => ['slider_type' => 'testimonial'],
        ]);

        $this->add_group_control(Group_Control_Border::get_type(), [
            'name'     => 'slide_border',
            'selector' => '{{WRAPPER}} .jr-slide',
        ]);

        $this->add_responsive_control('slide_radius', [
            'label'      => esc_html__('Border Radius', 'jr-addons'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'default'    => ['top' => '10', 'right' => '10', 'bottom' => '10', 'left' => '10', 'unit' => 'px'],
            'selectors'  => ['{{WRAPPER}} .jr-slide' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow:hidden;'],
        ]);

        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name'     => 'slide_shadow',
            'selector' => '{{WRAPPER}} .jr-slide',
        ]);

        $this->end_controls_section();


        /* ============================================================
         * STYLE: OVERLAY (Image Slider)
         * ============================================================ */
        $this->start_controls_section('style_overlay', [
            'label'     => esc_html__('Overlay', 'jr-addons'),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => ['slider_type' => 'image'],
        ]);

        $this->add_group_control(Group_Control_Background::get_type(), [
            'name'     => 'overlay_bg',
            'types'    => ['classic', 'gradient'],
            'selector' => '{{WRAPPER}} .jr-overlay',
            'fields_options' => [
                'background' => ['default' => 'classic'],
                'color'      => ['default' => 'rgba(0,0,0,0.4)'],
            ],
        ]);

        $this->add_control('content_align', [
            'label'   => esc_html__('Content Alignment', 'jr-addons'),
            'type'    => Controls_Manager::CHOOSE,
            'options' => [
                'flex-start' => ['title' => 'Left', 'icon' => 'eicon-text-align-left'],
                'center'     => ['title' => 'Center', 'icon' => 'eicon-text-align-center'],
                'flex-end'   => ['title' => 'Right', 'icon' => 'eicon-text-align-right'],
            ],
            'default'   => 'center',
            'selectors' => [
                '{{WRAPPER}} .jr-slide-content' => 'align-items: {{VALUE}}; text-align: {{VALUE}};',
            ],
        ]);

        $this->end_controls_section();
        

        /* ============================================================
         * STYLE: TITLE
         * ============================================================ */
        $this->start_controls_section('style_title', [
            'label'     => esc_html__('Title', 'jr-addons'),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => ['slider_type' => 'image'],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name'     => 'title_typo',
            'selector' => '{{WRAPPER}} .jr-slide-title',
        ]);

        $this->add_control('title_color', [
            'label'     => esc_html__('Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => ['{{WRAPPER}} .jr-slide-title' => 'color: {{VALUE}};'],
        ]);

        $this->add_responsive_control('title_margin', [
            'label'      => esc_html__('Margin Bottom', 'jr-addons'),
            'type'       => Controls_Manager::SLIDER,
            'range'      => ['px' => ['min' => 0, 'max' => 80]],
            'default'    => ['unit' => 'px', 'size' => 16],
            'selectors'  => ['{{WRAPPER}} .jr-slide-title' => 'margin-bottom: {{SIZE}}{{UNIT}};'],
        ]);

        $this->end_controls_section();


        /* ============================================================
         * STYLE: DESCRIPTION
         * ============================================================ */
        $this->start_controls_section('style_desc', [
            'label'     => esc_html__('Description', 'jr-addons'),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => ['slider_type' => 'image'],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name'     => 'desc_typo',
            'selector' => '{{WRAPPER}} .jr-slide-desc',
        ]);

        $this->add_control('desc_color', [
            'label'     => esc_html__('Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#f3f4f6',
            'selectors' => ['{{WRAPPER}} .jr-slide-desc' => 'color: {{VALUE}};'],
        ]);

        $this->add_responsive_control('desc_margin', [
            'label'      => esc_html__('Margin Bottom', 'jr-addons'),
            'type'       => Controls_Manager::SLIDER,
            'range'      => ['px' => ['min' => 0, 'max' => 80]],
            'default'    => ['unit' => 'px', 'size' => 24],
            'selectors'  => ['{{WRAPPER}} .jr-slide-desc' => 'margin-bottom: {{SIZE}}{{UNIT}};'],
        ]);

        $this->end_controls_section();


        /* ============================================================
         * STYLE: BUTTON (Image Slider)
         * ============================================================ */
        $this->start_controls_section('style_button', [
            'label'     => esc_html__('Button', 'jr-addons'),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => ['slider_type' => 'image'],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name'     => 'btn_typo',
            'selector' => '{{WRAPPER}} .jr-slide-btn',
        ]);

        $this->start_controls_tabs('btn_style_tabs');

        $this->start_controls_tab('btn_normal', ['label' => 'Normal']);
        $this->add_control('btn_color', [
            'label'     => esc_html__('Text Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => ['{{WRAPPER}} .jr-slide-btn' => 'color: {{VALUE}};'],
        ]);
        $this->add_group_control(Group_Control_Background::get_type(), [
            'name'     => 'btn_bg',
            'types'    => ['classic', 'gradient'],
            'selector' => '{{WRAPPER}} .jr-slide-btn',
        ]);
        $this->end_controls_tab();

        $this->start_controls_tab('btn_hover', ['label' => 'Hover']);
        $this->add_control('btn_hover_color', [
            'label'     => esc_html__('Text Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .jr-slide-btn:hover' => 'color: {{VALUE}};'],
        ]);
        $this->add_group_control(Group_Control_Background::get_type(), [
            'name'     => 'btn_bg_hover',
            'types'    => ['classic', 'gradient'],
            'selector' => '{{WRAPPER}} .jr-slide-btn:hover',
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control('btn_padding', [
            'label'      => esc_html__('Padding', 'jr-addons'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'default'    => ['top' => '12', 'right' => '28', 'bottom' => '12', 'left' => '28', 'unit' => 'px'],
            'selectors'  => ['{{WRAPPER}} .jr-slide-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
        ]);

        $this->add_responsive_control('btn_radius', [
            'label'      => esc_html__('Border Radius', 'jr-addons'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'default'    => ['top' => '50', 'right' => '50', 'bottom' => '50', 'left' => '50', 'unit' => 'px'],
            'selectors'  => ['{{WRAPPER}} .jr-slide-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
        ]);

        $this->end_controls_section();


        /* ============================================================
         * STYLE: TESTIMONIAL REVIEW
         * ============================================================ */
        $this->start_controls_section('style_review', [
            'label'     => esc_html__('Review Text', 'jr-addons'),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => ['slider_type' => 'testimonial'],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name'     => 'review_typo',
            'selector' => '{{WRAPPER}} .jr-review-text',
        ]);

        $this->add_control('review_color', [
            'label'     => esc_html__('Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#374151',
            'selectors' => ['{{WRAPPER}} .jr-review-text' => 'color: {{VALUE}};'],
        ]);

        $this->add_responsive_control('review_margin', [
            'label'      => esc_html__('Margin Bottom', 'jr-addons'),
            'type'       => Controls_Manager::SLIDER,
            'range'      => ['px' => ['min' => 0, 'max' => 80]],
            'default'    => ['unit' => 'px', 'size' => 20],
            'selectors'  => ['{{WRAPPER}} .jr-review-text' => 'margin-bottom: {{SIZE}}{{UNIT}};'],
        ]);

        $this->end_controls_section();


        /* ============================================================
        * STYLE: TESTIMONIAL AUTHOR
        * ============================================================ */
        $this->start_controls_section('style_author', [
            'label'     => esc_html__('Author Info', 'jr-addons'),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => ['slider_type' => 'testimonial'],
        ]);

        // Author Layout (Horizontal/Vertical)
        $this->add_control('author_layout', [
            'label'   => esc_html__('Layout', 'jr-addons'),
            'type'    => Controls_Manager::CHOOSE,
            'options' => [
                'row'    => [
                    'title' => esc_html__('Horizontal', 'jr-addons'),
                    'icon'  => 'eicon-arrow-right',
                ],
                'column' => [
                    'title' => esc_html__('Vertical', 'jr-addons'),
                    'icon'  => 'eicon-arrow-down',
                ],
            ],
            'default'   => 'row',
            'selectors' => [
                '{{WRAPPER}} .jr-author' => 'flex-direction: {{VALUE}};',
            ],
        ]);

        // Author Alignment (Horizontal)
        $this->add_responsive_control('author_align', [
            'label'   => esc_html__('Alignment', 'jr-addons'),
            'type'    => Controls_Manager::CHOOSE,
            'options' => [
                'flex-start' => [
                    'title' => esc_html__('Left', 'jr-addons'),
                    'icon'  => 'eicon-text-align-left',
                ],
                'center'     => [
                    'title' => esc_html__('Center', 'jr-addons'),
                    'icon'  => 'eicon-text-align-center',
                ],
                'flex-end'   => [
                    'title' => esc_html__('Right', 'jr-addons'),
                    'icon'  => 'eicon-text-align-right',
                ],
            ],
            'default'   => 'flex-start',
            'selectors' => [
                '{{WRAPPER}} .jr-author' => 'justify-content: {{VALUE}};',
            ],
        ]);

        // Vertical Alignment
        $this->add_responsive_control('author_vertical_align', [
            'label'   => esc_html__('Vertical Align', 'jr-addons'),
            'type'    => Controls_Manager::CHOOSE,
            'options' => [
                'flex-start' => [
                    'title' => esc_html__('Top', 'jr-addons'),
                    'icon'  => 'eicon-v-align-top',
                ],
                'center'     => [
                    'title' => esc_html__('Middle', 'jr-addons'),
                    'icon'  => 'eicon-v-align-middle',
                ],
                'flex-end'   => [
                    'title' => esc_html__('Bottom', 'jr-addons'),
                    'icon'  => 'eicon-v-align-bottom',
                ],
            ],
            'default'   => 'center',
            'selectors' => [
                '{{WRAPPER}} .jr-author' => 'align-items: {{VALUE}};',
            ],
        ]);

        // Text Alignment (Name & Designation)
        $this->add_responsive_control('author_text_align', [
            'label'   => esc_html__('Text Alignment', 'jr-addons'),
            'type'    => Controls_Manager::CHOOSE,
            'options' => [
                'left'   => [
                    'title' => esc_html__('Left', 'jr-addons'),
                    'icon'  => 'eicon-text-align-left',
                ],
                'center' => [
                    'title' => esc_html__('Center', 'jr-addons'),
                    'icon'  => 'eicon-text-align-center',
                ],
                'right'  => [
                    'title' => esc_html__('Right', 'jr-addons'),
                    'icon'  => 'eicon-text-align-right',
                ],
            ],
            'default'   => 'left',
            'selectors' => [
                '{{WRAPPER}} .jr-author-info' => 'text-align: {{VALUE}};',
            ],
        ]);

        // Gap Between Avatar and Info
        $this->add_responsive_control('author_gap', [
            'label'     => esc_html__('Gap', 'jr-addons'),
            'type'      => Controls_Manager::SLIDER,
            'range'     => ['px' => ['min' => 0, 'max' => 50]],
            'default'   => ['unit' => 'px', 'size' => 12],
            'selectors' => [
                '{{WRAPPER}} .jr-author' => 'gap: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_control('author_divider', [
            'type' => Controls_Manager::DIVIDER,
        ]);

        // Avatar Size
        $this->add_responsive_control('avatar_size', [
            'label'     => esc_html__('Avatar Size', 'jr-addons'),
            'type'      => Controls_Manager::SLIDER,
            'range'     => ['px' => ['min' => 30, 'max' => 150]],
            'default'   => ['unit' => 'px', 'size' => 50],
            'selectors' => [
                '{{WRAPPER}} .jr-author-avatar' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
            ],
        ]);

        // Avatar Shape (Circle / Square / Rounded)
        $this->add_control('avatar_shape', [
            'label'   => esc_html__('Avatar Shape', 'jr-addons'),
            'type'    => Controls_Manager::SELECT,
            'default' => 'circle',
            'options' => [
                'circle'  => esc_html__('Circle', 'jr-addons'),
                'square'  => esc_html__('Square', 'jr-addons'),
                'rounded' => esc_html__('Rounded', 'jr-addons'),
                'custom'  => esc_html__('Custom', 'jr-addons'),
            ],
            'selectors_dictionary' => [
                'circle'  => 'border-radius: 50%;',
                'square'  => 'border-radius: 0;',
                'rounded' => 'border-radius: 8px;',
                'custom'  => '',
            ],
            'selectors' => [
                '{{WRAPPER}} .jr-author-avatar' => '{{VALUE}}',
            ],
        ]);

        // Custom Border Radius
        $this->add_responsive_control('avatar_custom_radius', [
            'label'      => esc_html__('Custom Radius', 'jr-addons'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors'  => [
                '{{WRAPPER}} .jr-author-avatar' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'condition'  => ['avatar_shape' => 'custom'],
        ]);

        // Avatar Border
        $this->add_group_control(Group_Control_Border::get_type(), [
            'name'     => 'avatar_border',
            'selector' => '{{WRAPPER}} .jr-author-avatar',
        ]);

        // Avatar Box Shadow
        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name'     => 'avatar_shadow',
            'selector' => '{{WRAPPER}} .jr-author-avatar',
        ]);

        $this->add_control('typography_divider', [
            'type' => Controls_Manager::DIVIDER,
        ]);

        // Name Typography
        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name'     => 'name_typo',
            'label'    => esc_html__('Name Typography', 'jr-addons'),
            'selector' => '{{WRAPPER}} .jr-author-name',
        ]);

        $this->add_control('name_color', [
            'label'     => esc_html__('Name Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#111827',
            'selectors' => ['{{WRAPPER}} .jr-author-name' => 'color: {{VALUE}};'],
        ]);

        // Designation Typography
        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name'     => 'designation_typo',
            'label'    => esc_html__('Designation Typography', 'jr-addons'),
            'selector' => '{{WRAPPER}} .jr-author-designation',
        ]);

        $this->add_control('designation_color', [
            'label'     => esc_html__('Designation Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#6b7280',
            'selectors' => ['{{WRAPPER}} .jr-author-designation' => 'color: {{VALUE}};'],
        ]);

        // Rating Star Color
        $this->add_control('rating_color', [
            'label'     => esc_html__('Rating Star Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#fbbf24',
            'selectors' => ['{{WRAPPER}} .jr-rating i.active' => 'color: {{VALUE}};'],
        ]);

        $this->end_controls_section();


        /* ============================================================
         * STYLE: ARROWS
         * ============================================================ */
        $this->start_controls_section('style_arrows', [
            'label'     => esc_html__('Navigation Arrows', 'jr-addons'),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => ['show_arrows' => 'yes'],
        ]);

        $this->add_responsive_control('arrow_size', [
            'label'     => esc_html__('Icon Size', 'jr-addons'),
            'type'      => Controls_Manager::SLIDER,
            'range'     => ['px' => ['min' => 10, 'max' => 50]],
            'default'   => ['unit' => 'px', 'size' => 18],
            'selectors' => [
                '{{WRAPPER}} .jr-slider-arrow svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .jr-slider-arrow i'   => 'font-size: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_responsive_control('arrow_box_size', [
            'label'     => esc_html__('Box Size', 'jr-addons'),
            'type'      => Controls_Manager::SLIDER,
            'range'     => ['px' => ['min' => 30, 'max' => 100]],
            'default'   => ['unit' => 'px', 'size' => 48],
            'selectors' => [
                '{{WRAPPER}} .jr-slider-arrow' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->start_controls_tabs('arrow_tabs');

        $this->start_controls_tab('arrow_normal', ['label' => 'Normal']);
        $this->add_control('arrow_color', [
            'label'     => esc_html__('Icon Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#111827',
            'selectors' => [
                '{{WRAPPER}} .jr-slider-arrow svg' => 'fill: {{VALUE}}; color: {{VALUE}};',
                '{{WRAPPER}} .jr-slider-arrow i'   => 'color: {{VALUE}};',
            ],
        ]);
        $this->add_control('arrow_bg', [
            'label'     => esc_html__('Background', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => ['{{WRAPPER}} .jr-slider-arrow' => 'background: {{VALUE}};'],
        ]);
        $this->end_controls_tab();

        $this->start_controls_tab('arrow_hover', ['label' => 'Hover']);
        $this->add_control('arrow_hover_color', [
            'label'     => esc_html__('Icon Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => [
                '{{WRAPPER}} .jr-slider-arrow:hover svg' => 'fill: {{VALUE}}; color: {{VALUE}};',
                '{{WRAPPER}} .jr-slider-arrow:hover i'   => 'color: {{VALUE}};',
            ],
        ]);
        $this->add_control('arrow_hover_bg', [
            'label'     => esc_html__('Background', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#2563eb',
            'selectors' => ['{{WRAPPER}} .jr-slider-arrow:hover' => 'background: {{VALUE}};'],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control('arrow_radius', [
            'label'      => esc_html__('Border Radius', 'jr-addons'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'default'    => ['top' => '6', 'right' => '6', 'bottom' => '6', 'left' => '6', 'unit' => 'px'],
            'selectors'  => ['{{WRAPPER}} .jr-slider-arrow' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
        ]);

        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name'     => 'arrow_shadow',
            'selector' => '{{WRAPPER}} .jr-slider-arrow',
        ]);

        $this->add_responsive_control('arrow_offset_h', [
            'label'     => esc_html__('Horizontal Offset', 'jr-addons'),
            'type'      => Controls_Manager::SLIDER,
            'range'     => ['px' => ['min' => -100, 'max' => 100]],
            'default'   => ['unit' => 'px', 'size' => 15],
            'selectors' => [
                '{{WRAPPER}} .jr-slider-arrow-prev' => 'left: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .jr-slider-arrow-next' => 'right: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();


        /* ============================================================
         * STYLE: PAGINATION
         * ============================================================ */
        $this->start_controls_section('style_pagination', [
            'label'     => esc_html__('Pagination', 'jr-addons'),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => ['show_pagination' => 'yes'],
        ]);

        $this->add_control('pagination_position', [
            'label'   => esc_html__('Position', 'jr-addons'),
            'type'    => Controls_Manager::SELECT,
            'default' => 'bottom-center',
            'options' => [
                'bottom-left'   => 'Bottom Left',
                'bottom-center' => 'Bottom Center',
                'bottom-right'  => 'Bottom Right',
            ],
            'prefix_class' => 'jr-pagi-pos-',
        ]);

        $this->add_responsive_control('pagination_offset', [
            'label'     => esc_html__('Offset From Bottom', 'jr-addons'),
            'type'      => Controls_Manager::SLIDER,
            'range'     => ['px' => ['min' => -50, 'max' => 100]],
            'default'   => ['unit' => 'px', 'size' => 10],
            'selectors' => ['{{WRAPPER}} .swiper-pagination' => 'bottom: {{SIZE}}{{UNIT}};'],
        ]);

        $this->add_control('dot_color', [
            'label'     => esc_html__('Dot Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#d1d5db',
            'selectors' => ['{{WRAPPER}} .swiper-pagination-bullet' => 'background: {{VALUE}}; opacity: 1;'],
        ]);

        $this->add_control('dot_active_color', [
            'label'     => esc_html__('Active Dot Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#f59e0b',
            'selectors' => ['{{WRAPPER}} .swiper-pagination-bullet-active' => 'background: {{VALUE}};'],
        ]);

        $this->add_responsive_control('dot_size', [
            'label'     => esc_html__('Dot Size', 'jr-addons'),
            'type'      => Controls_Manager::SLIDER,
            'range'     => ['px' => ['min' => 4, 'max' => 30]],
            'default'   => ['unit' => 'px', 'size' => 8],
            'selectors' => [
                '{{WRAPPER}} .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_responsive_control('dot_active_width', [
            'label'     => esc_html__('Active Dot Width', 'jr-addons'),
            'type'      => Controls_Manager::SLIDER,
            'range'     => ['px' => ['min' => 4, 'max' => 60]],
            'default'   => ['unit' => 'px', 'size' => 24],
            'selectors' => ['{{WRAPPER}} .swiper-pagination-bullet-active' => 'width: {{SIZE}}{{UNIT}}; border-radius: 10px;'],
        ]);

        $this->end_controls_section();
    }


    protected function render() {
        $settings  = $this->get_settings_for_display();
        $slider_id = 'jr-slider-' . $this->get_id();
        $type      = $settings['slider_type'];

        // Responsive values properly handle 
        $spv_desktop = !empty($settings['slides_per_view']) ? (int) $settings['slides_per_view'] : 1;
        $spv_tablet  = !empty($settings['slides_per_view_tablet']) ? (int) $settings['slides_per_view_tablet'] : $spv_desktop;
        $spv_mobile  = !empty($settings['slides_per_view_mobile']) ? (int) $settings['slides_per_view_mobile'] : 1;

        $sb_desktop = !empty($settings['space_between']) ? (int) $settings['space_between'] : 20;
        $sb_tablet  = !empty($settings['space_between_tablet']) ? (int) $settings['space_between_tablet'] : $sb_desktop;
        $sb_mobile  = !empty($settings['space_between_mobile']) ? (int) $settings['space_between_mobile'] : 15;
        // CSS conditional class
        $equal_height_class = ($settings['equal_height'] === 'yes') ? 'jr-equal-height' : '';

        $swiper_settings = [
            'loop'           => ($settings['loop'] === 'yes'),
            'effect'         => $settings['effect'],
            'speed'          => (int) $settings['speed'],
            'spaceBetween'   => $sb_mobile,         
            'slidesPerView'  => $spv_mobile,       
            'autoplay'       => ($settings['autoplay'] === 'yes') ? ['delay' => (int) $settings['delay']] : false,
            'pagination'     => ($settings['show_pagination'] === 'yes'),
            'paginationType' => $settings['pagination_type'] ?? 'bullets',
            'navigation'     => ($settings['show_arrows'] === 'yes'),
            'autoHeight'     => false,
            'observer'       => true,
            'breakpoints'    => [
                // Tablet
                768 => [
                    'slidesPerView' => $spv_tablet,
                    'spaceBetween'  => $sb_tablet,
                ],
                // Desktop
                1024 => [
                    'slidesPerView' => $spv_desktop,
                    'spaceBetween'  => $sb_desktop,
                ],
            ],
        ];
        ?>

        <style>
            .jr-slider-wrapper{position:relative;width:100%}
            .jr-slide{position:relative;display:flex;align-items:center;justify-content:center;overflow:hidden;background-size:cover;background-position:center;height:100%}
            .jr-overlay{position:absolute;inset:0;z-index:1}
            .jr-slide-content{position:relative;z-index:2;display:flex;flex-direction:column;width:100%;max-width:800px;padding:0 20px}
            .jr-slide-btn{display:inline-block;text-decoration:none;font-weight:600;transition:all .3s ease;border:none;cursor:pointer;width:fit-content}
            .jr-slide-btn:hover{transform:translateY(-2px)}
            
            /* Testimonial Card */
            .jr-testimonial{display:flex;flex-direction:column;height:100%;width:100%}
            .jr-review-text{line-height:1.6;flex:1}

            /* Updated - width 100% add করুন */
            .jr-author{display:flex;align-items:center;gap:12px;flex-wrap:wrap;width:100%;}
            .jr-author-avatar{object-fit:cover;flex-shrink:0;display:block}
            .jr-author-info{display:flex;flex-direction:column;min-width:0}
            .jr-author-name{margin:0;font-weight:600;line-height:1.3}
            .jr-author-designation{margin:0;font-size:13px;display:block}

            .jr-rating{display:flex;gap:2px;margin-bottom:10px}
            .jr-rating i{color:#d1d5db;font-size:14px}
            .jr-rating i.active{color:#fbbf24}
           
            .jr-slider .swiper-wrapper{align-items:stretch!important;display:flex!important}
            .jr-slider .swiper-slide{height:auto!important;display:flex!important;flex-direction:column}
            .jr-slider .swiper-slide>.jr-slide,.jr-slider .swiper-slide>.jr-testimonial{height:100%;width:100%}
            .jr-testimonial{display:flex;flex-direction:column;height:100%;width:100%;min-height:220px}
            .jr-review-text{line-height:1.6;flex:1 1 auto;margin:0 0 20px}
            .jr-author{display:flex;width:100%;align-items:center;gap:12px;flex-wrap:wrap;margin-top:auto}
            /* Arrows */
            .jr-slider-arrow{position:absolute;top:50%;transform:translateY(-50%);z-index:10;display:flex;align-items:center;justify-content:center;cursor:pointer;background:#fff;border:none;transition:all .3s ease;box-shadow:0 2px 10px rgba(0,0,0,.1)}
            .jr-slider-arrow:hover{transform:translateY(-50%) scale(1.05)}
            .jr-slider-arrow.swiper-button-disabled{opacity:.4;cursor:not-allowed}

            /* Pagination Position */
            .jr-pagi-pos-bottom-left .swiper-pagination{text-align:left;padding-left:20px}
            .jr-pagi-pos-bottom-center .swiper-pagination{text-align:center}
            .jr-pagi-pos-bottom-right .swiper-pagination{text-align:right;padding-right:20px}
            
            .swiper-pagination-bullet{transition:all .3s ease;margin:0 4px!important}

            /* Hide default Swiper arrows */
            .jr-slider .swiper-button-next:after,
            .jr-slider .swiper-button-prev:after{display:none}
        </style>

        <div class="jr-slider-wrapper">
            <div id="<?php echo esc_attr($slider_id); ?>"
                 class="swiper jr-slider <?php echo esc_attr($equal_height_class); ?>"
                 data-settings='<?php echo wp_json_encode($swiper_settings); ?>'>

                <div class="swiper-wrapper">
                    <?php if ($type === 'image' && !empty($settings['slides'])): ?>
                        <?php foreach ($settings['slides'] as $slide): ?>
                            <div class="swiper-slide">
                                <div class="jr-slide" style="background-image:url('<?php echo esc_url($slide['slide_image']['url']); ?>')">
                                    <div class="jr-overlay"></div>
                                    <div class="jr-slide-content">
                                        <?php if (!empty($slide['title'])): ?>
                                            <h2 class="jr-slide-title"><?php echo esc_html($slide['title']); ?></h2>
                                        <?php endif; ?>
                                        <?php if (!empty($slide['description'])): ?>
                                            <div class="jr-slide-desc"><?php echo esc_html($slide['description']); ?></div>
                                        <?php endif; ?>
                                        <?php if (!empty($slide['button_text'])): ?>
                                            <a href="<?php echo esc_url($slide['button_link']['url']); ?>" 
                                               class="jr-slide-btn"
                                               <?php echo !empty($slide['button_link']['is_external']) ? 'target="_blank"' : ''; ?>
                                               <?php echo !empty($slide['button_link']['nofollow']) ? 'rel="nofollow"' : ''; ?>>
                                                <?php echo esc_html($slide['button_text']); ?>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>

                    <?php elseif ($type === 'testimonial' && !empty($settings['testimonials'])): ?>
                        <?php foreach ($settings['testimonials'] as $t): ?>
                            <div class="swiper-slide">
                                <div class="jr-slide jr-testimonial">
                                    <?php if (!empty($t['rating'])): ?>
                                        <div class="jr-rating">
                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                                <i class="fas fa-star <?php echo $i <= (int) $t['rating'] ? 'active' : ''; ?>"></i>
                                            <?php endfor; ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <p class="jr-review-text"><?php echo esc_html($t['review']); ?></p>
                                    
                                    <div class="jr-author">
                                        <?php if (!empty($t['avatar']['url'])): ?>
                                            <img src="<?php echo esc_url($t['avatar']['url']); ?>" 
                                                 alt="<?php echo esc_attr($t['name']); ?>" 
                                                 class="jr-author-avatar">
                                        <?php endif; ?>
                                        <div class="jr-author-info">
                                            <h4 class="jr-author-name"><?php echo esc_html($t['name']); ?></h4>
                                            <?php if (!empty($t['designation'])): ?>
                                                <span class="jr-author-designation"><?php echo esc_html($t['designation']); ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <?php if ($settings['show_pagination'] === 'yes'): ?>
                    <div class="swiper-pagination"></div>
                <?php endif; ?>
            </div>

            <?php if ($settings['show_arrows'] === 'yes'): ?>
                <button class="jr-slider-arrow jr-slider-arrow-prev" type="button" aria-label="Previous">
                    <?php Icons_Manager::render_icon($settings['prev_icon'], ['aria-hidden' => 'true']); ?>
                </button>
                <button class="jr-slider-arrow jr-slider-arrow-next" type="button" aria-label="Next">
                    <?php Icons_Manager::render_icon($settings['next_icon'], ['aria-hidden' => 'true']); ?>
                </button>
            <?php endif; ?>
        </div>
        <?php
    }
}