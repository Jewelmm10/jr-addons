<?php
namespace JR_Addons\Elementor\Widgets;

if (!defined('ABSPATH')) {
    exit;
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;

class BlogGrid extends Widget_Base {

    public function get_name() {
        return 'blog_grid';
    }

    public function get_title() {
        return esc_html__('Blog Grid Tabs', 'jr-addons');
    }

    public function get_icon() {
        return 'jr-get-icon';
    }

    public function get_categories() {
        return ['jr-addons'];
    }

    public function get_keywords() {
        return ['blog', 'grid', 'tabs', 'posts', 'category', 'load more', 'ajax', 'jr'];
    }

    public function get_style_depends() {
        return ['jr-blog-grid-style'];
    }

    public function get_script_depends() {
        return ['jr-blog-grid-script'];
    }

    /**
     * Get post types
     */
    private function get_post_type_options() {
        $post_types = get_post_types(['public' => true], 'objects');
        $options = [];
        foreach ($post_types as $pt) {
            if ($pt->name === 'attachment') continue;
            $options[$pt->name] = $pt->labels->name;
        }
        return $options;
    }

    /**
     * Get taxonomies
     */
    private function get_taxonomy_options() {
        $taxonomies = get_taxonomies(['public' => true], 'objects');
        $options = [];
        foreach ($taxonomies as $tax) {
            $options[$tax->name] = $tax->labels->name;
        }
        return $options;
    }

    protected function register_controls() {

        /* ============================================
         * CONTENT TAB
         * ============================================ */

        // ──── Section: Query ────
        $this->start_controls_section('jr_bgt_section_query', [
            'label' => esc_html__('Query Settings', 'jr-addons'),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('jr_bgt_post_type', [
            'label'   => esc_html__('Post Type', 'jr-addons'),
            'type'    => Controls_Manager::SELECT,
            'default' => 'post',
            'options' => $this->get_post_type_options(),
        ]);

        $this->add_control('jr_bgt_taxonomy', [
            'label'   => esc_html__('Taxonomy', 'jr-addons'),
            'type'    => Controls_Manager::SELECT,
            'default' => 'category',
            'options' => $this->get_taxonomy_options(),
        ]);

        $this->add_control('jr_bgt_posts_per_page', [
            'label'   => esc_html__('Posts Per Page', 'jr-addons'),
            'type'    => Controls_Manager::NUMBER,
            'default' => 3,
            'min'     => 1,
            'max'     => 50,
        ]);

        $this->add_responsive_control('jr_bgt_columns', [
            'label'   => esc_html__('Columns', 'jr-addons'),
            'type'    => Controls_Manager::SELECT,
            'default' => '3',
            'tablet_default' => '2',
            'mobile_default' => '1',
            'options' => [
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
            ],
            'selectors' => [
                '{{WRAPPER}} .jr-bgt-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
            ],
        ]);

        $this->add_control('jr_bgt_orderby', [
            'label'   => esc_html__('Order By', 'jr-addons'),
            'type'    => Controls_Manager::SELECT,
            'default' => 'date',
            'options' => [
                'date'          => esc_html__('Date', 'jr-addons'),
                'title'         => esc_html__('Title', 'jr-addons'),
                'modified'      => esc_html__('Modified', 'jr-addons'),
                'rand'          => esc_html__('Random', 'jr-addons'),
                'comment_count' => esc_html__('Comment Count', 'jr-addons'),
                'menu_order'    => esc_html__('Menu Order', 'jr-addons'),
            ],
        ]);

        $this->add_control('jr_bgt_order', [
            'label'   => esc_html__('Order', 'jr-addons'),
            'type'    => Controls_Manager::SELECT,
            'default' => 'DESC',
            'options' => [
                'DESC' => esc_html__('Descending', 'jr-addons'),
                'ASC'  => esc_html__('Ascending', 'jr-addons'),
            ],
        ]);

        $this->add_control('jr_bgt_image_size', [
            'label'   => esc_html__('Image Size', 'jr-addons'),
            'type'    => Controls_Manager::SELECT,
            'default' => 'medium_large',
            'options' => [
                'thumbnail'    => esc_html__('Thumbnail', 'jr-addons'),
                'medium'       => esc_html__('Medium', 'jr-addons'),
                'medium_large' => esc_html__('Medium Large', 'jr-addons'),
                'large'        => esc_html__('Large', 'jr-addons'),
                'full'         => esc_html__('Full', 'jr-addons'),
            ],
        ]);

        $this->end_controls_section();

        // ──── Section: Header ────
        $this->start_controls_section('jr_bgt_section_header', [
            'label' => esc_html__('Section Header', 'jr-addons'),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('jr_bgt_show_header', [
            'label'        => esc_html__('Show Header', 'jr-addons'),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => esc_html__('Yes', 'jr-addons'),
            'label_off'    => esc_html__('No', 'jr-addons'),
            'return_value' => 'yes',
            'default'      => 'yes',
        ]);

        $this->add_control('jr_bgt_header_title', [
            'label'     => esc_html__('Title', 'jr-addons'),
            'type'      => Controls_Manager::TEXT,
            'default'   => 'FEATURED ARTICLES',
            'condition' => ['jr_bgt_show_header' => 'yes'],
        ]);

        $this->add_control('jr_bgt_header_title_tag', [
            'label'   => esc_html__('Title HTML Tag', 'jr-addons'),
            'type'    => Controls_Manager::SELECT,
            'default' => 'h2',
            'options' => [
                'h1'   => 'H1',
                'h2'   => 'H2',
                'h3'   => 'H3',
                'h4'   => 'H4',
                'h5'   => 'H5',
                'h6'   => 'H6',
                'div'  => 'div',
                'span' => 'span',
                'p'    => 'p',
            ],
            'condition' => ['jr_bgt_show_header' => 'yes'],
        ]);

        $this->add_control('jr_bgt_header_subtitle', [
            'label'     => esc_html__('Subtitle', 'jr-addons'),
            'type'      => Controls_Manager::TEXTAREA,
            'default'   => 'Explore our latest educational insights on mental wellness, regulation, resilience, and neuroscience.',
            'condition' => ['jr_bgt_show_header' => 'yes'],
        ]);

        $this->end_controls_section();

        // ──── Section: Tabs ────
        $this->start_controls_section('jr_bgt_section_tabs', [
            'label' => esc_html__('Category Tabs', 'jr-addons'),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('jr_bgt_show_tabs', [
            'label'        => esc_html__('Show Tabs', 'jr-addons'),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => esc_html__('Yes', 'jr-addons'),
            'label_off'    => esc_html__('No', 'jr-addons'),
            'return_value' => 'yes',
            'default'      => 'yes',
        ]);

        $this->add_control('jr_bgt_all_tab_text', [
            'label'     => esc_html__('"All" Tab Label', 'jr-addons'),
            'type'      => Controls_Manager::TEXT,
            'default'   => 'ALL ARTICLES',
            'condition' => ['jr_bgt_show_tabs' => 'yes'],
        ]);

        $this->add_control('jr_bgt_tabs_source', [
            'label'   => esc_html__('Source', 'jr-addons'),
            'type'    => Controls_Manager::SELECT,
            'default' => 'auto',
            'options' => [
                'auto'   => esc_html__('Auto (All Categories)', 'jr-addons'),
                'manual' => esc_html__('Manual Selection', 'jr-addons'),
            ],
            'condition' => ['jr_bgt_show_tabs' => 'yes'],
        ]);

        $this->add_control('jr_bgt_manual_cats', [
            'label'       => esc_html__('Category Slugs', 'jr-addons'),
            'type'        => Controls_Manager::TEXT,
            'description' => esc_html__('Comma separated slugs: emotional-regulation, neuroscience', 'jr-addons'),
            'condition'   => [
                'jr_bgt_show_tabs'   => 'yes',
                'jr_bgt_tabs_source' => 'manual',
            ],
        ]);

        $this->add_control('jr_bgt_hide_empty', [
            'label'        => esc_html__('Hide Empty', 'jr-addons'),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => esc_html__('Yes', 'jr-addons'),
            'label_off'    => esc_html__('No', 'jr-addons'),
            'return_value' => 'yes',
            'default'      => 'yes',
            'condition'    => [
                'jr_bgt_show_tabs'   => 'yes',
                'jr_bgt_tabs_source' => 'auto',
            ],
        ]);

        $this->add_control('jr_bgt_tabs_position', [
            'label'   => esc_html__('Tabs Position', 'jr-addons'),
            'type'    => Controls_Manager::SELECT,
            'default' => 'above_header',
            'options' => [
                'above_header' => esc_html__('Above Header', 'jr-addons'),
                'below_header' => esc_html__('Below Header', 'jr-addons'),
            ],
            'condition' => [
                'jr_bgt_show_tabs'   => 'yes',
                'jr_bgt_show_header' => 'yes',
            ],
        ]);

        $this->add_responsive_control('jr_bgt_tabs_align', [
            'label'   => esc_html__('Alignment', 'jr-addons'),
            'type'    => Controls_Manager::CHOOSE,
            'options' => [
                'flex-start' => [
                    'title' => esc_html__('Left', 'jr-addons'),
                    'icon'  => 'eicon-text-align-left',
                ],
                'center' => [
                    'title' => esc_html__('Center', 'jr-addons'),
                    'icon'  => 'eicon-text-align-center',
                ],
                'flex-end' => [
                    'title' => esc_html__('Right', 'jr-addons'),
                    'icon'  => 'eicon-text-align-right',
                ],
            ],
            'default'   => 'center',
            'selectors' => [
                '{{WRAPPER}} .jr-bgt-tabs' => 'justify-content: {{VALUE}};',
            ],
            'condition' => ['jr_bgt_show_tabs' => 'yes'],
        ]);

        $this->end_controls_section();

        // ──── Section: Card Content ────
        $this->start_controls_section('jr_bgt_section_card_content', [
            'label' => esc_html__('Card Content', 'jr-addons'),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('jr_bgt_show_image', [
            'label'        => esc_html__('Show Image', 'jr-addons'),
            'type'         => Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => 'yes',
        ]);

        $this->add_control('jr_bgt_show_badge', [
            'label'        => esc_html__('Show Category Badge', 'jr-addons'),
            'type'         => Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => 'yes',
        ]);

        $this->add_control('jr_bgt_show_date', [
            'label'        => esc_html__('Show Date', 'jr-addons'),
            'type'         => Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => '',
        ]);

        $this->add_control('jr_bgt_show_author', [
            'label'        => esc_html__('Show Author', 'jr-addons'),
            'type'         => Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => '',
        ]);

        $this->add_control('jr_bgt_show_excerpt', [
            'label'        => esc_html__('Show Excerpt', 'jr-addons'),
            'type'         => Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => 'yes',
        ]);

        $this->add_control('jr_bgt_excerpt_length', [
            'label'     => esc_html__('Excerpt Length (words)', 'jr-addons'),
            'type'      => Controls_Manager::NUMBER,
            'default'   => 20,
            'min'       => 5,
            'max'       => 100,
            'condition' => ['jr_bgt_show_excerpt' => 'yes'],
        ]);

        $this->add_control('jr_bgt_show_button', [
            'label'        => esc_html__('Show Read More', 'jr-addons'),
            'type'         => Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => 'yes',
        ]);

        $this->add_control('jr_bgt_button_text', [
            'label'     => esc_html__('Button Text', 'jr-addons'),
            'type'      => Controls_Manager::TEXT,
            'default'   => 'READ ARTICLE',
            'condition' => ['jr_bgt_show_button' => 'yes'],
        ]);

        $this->end_controls_section();

        // ──── Section: Load More ────
        $this->start_controls_section('jr_bgt_section_loadmore', [
            'label' => esc_html__('Load More', 'jr-addons'),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('jr_bgt_show_loadmore', [
            'label'        => esc_html__('Show Load More', 'jr-addons'),
            'type'         => Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => 'yes',
        ]);

        $this->add_control('jr_bgt_loadmore_text', [
            'label'     => esc_html__('Button Text', 'jr-addons'),
            'type'      => Controls_Manager::TEXT,
            'default'   => 'LOAD MORE ARTICLES',
            'condition' => ['jr_bgt_show_loadmore' => 'yes'],
        ]);

        $this->add_control('jr_bgt_loading_text', [
            'label'     => esc_html__('Loading Text', 'jr-addons'),
            'type'      => Controls_Manager::TEXT,
            'default'   => 'LOADING...',
            'condition' => ['jr_bgt_show_loadmore' => 'yes'],
        ]);

        $this->add_control('jr_bgt_nomore_text', [
            'label'     => esc_html__('No More Text', 'jr-addons'),
            'type'      => Controls_Manager::TEXT,
            'default'   => 'NO MORE ARTICLES',
            'condition' => ['jr_bgt_show_loadmore' => 'yes'],
        ]);

        $this->add_responsive_control('jr_bgt_loadmore_align', [
            'label'   => esc_html__('Alignment', 'jr-addons'),
            'type'    => Controls_Manager::CHOOSE,
            'options' => [
                'flex-start' => [
                    'title' => esc_html__('Left', 'jr-addons'),
                    'icon'  => 'eicon-text-align-left',
                ],
                'center' => [
                    'title' => esc_html__('Center', 'jr-addons'),
                    'icon'  => 'eicon-text-align-center',
                ],
                'flex-end' => [
                    'title' => esc_html__('Right', 'jr-addons'),
                    'icon'  => 'eicon-text-align-right',
                ],
            ],
            'default'   => 'center',
            'selectors' => [
                '{{WRAPPER}} .jr-bgt-loadmore-wrap' => 'justify-content: {{VALUE}};',
            ],
            'condition' => ['jr_bgt_show_loadmore' => 'yes'],
        ]);

        $this->end_controls_section();

        /* ============================================
         * STYLE TAB
         * ============================================ */

        // ──── Style: Container ────
        $this->start_controls_section('jr_bgt_style_container', [
            'label' => esc_html__('Container', 'jr-addons'),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_group_control(Group_Control_Background::get_type(), [
            'name'     => 'jr_bgt_container_bg',
            'types'    => ['classic', 'gradient'],
            'selector' => '{{WRAPPER}} .jr-bgt-wrapper',
        ]);

        $this->add_responsive_control('jr_bgt_container_padding', [
            'label'      => esc_html__('Padding', 'jr-addons'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors'  => [
                '{{WRAPPER}} .jr-bgt-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_responsive_control('jr_bgt_grid_gap', [
            'label'      => esc_html__('Grid Gap', 'jr-addons'),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['px', 'em'],
            'range'      => [
                'px' => ['min' => 0, 'max' => 100],
            ],
            'default'   => ['unit' => 'px', 'size' => 30],
            'selectors' => [
                '{{WRAPPER}} .jr-bgt-grid' => 'gap: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();

        // ──── Style: Header ────
        $this->start_controls_section('jr_bgt_style_header', [
            'label'     => esc_html__('Header', 'jr-addons'),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => ['jr_bgt_show_header' => 'yes'],
        ]);

        $this->add_control('jr_bgt_title_color', [
            'label'     => esc_html__('Title Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#8B7D6B',
            'selectors' => [
                '{{WRAPPER}} .jr-bgt-section-title' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name'     => 'jr_bgt_title_typo',
            'selector' => '{{WRAPPER}} .jr-bgt-section-title',
        ]);

        $this->add_responsive_control('jr_bgt_title_spacing', [
            'label'      => esc_html__('Title Bottom Spacing', 'jr-addons'),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range'      => ['px' => ['min' => 0, 'max' => 80]],
            'default'    => ['size' => 15, 'unit' => 'px'],
            'selectors'  => [
                '{{WRAPPER}} .jr-bgt-section-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_control('jr_bgt_subtitle_color', [
            'label'     => esc_html__('Subtitle Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#666666',
            'selectors' => [
                '{{WRAPPER}} .jr-bgt-section-subtitle' => 'color: {{VALUE}};',
            ],
            'separator' => 'before',
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name'     => 'jr_bgt_subtitle_typo',
            'selector' => '{{WRAPPER}} .jr-bgt-section-subtitle',
        ]);

        $this->add_responsive_control('jr_bgt_header_spacing', [
            'label'      => esc_html__('Header Bottom Spacing', 'jr-addons'),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range'      => ['px' => ['min' => 0, 'max' => 100]],
            'default'    => ['size' => 30, 'unit' => 'px'],
            'selectors'  => [
                '{{WRAPPER}} .jr-bgt-header' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_responsive_control('jr_bgt_header_align', [
            'label'   => esc_html__('Alignment', 'jr-addons'),
            'type'    => Controls_Manager::CHOOSE,
            'options' => [
                'left' => [
                    'title' => esc_html__('Left', 'jr-addons'),
                    'icon'  => 'eicon-text-align-left',
                ],
                'center' => [
                    'title' => esc_html__('Center', 'jr-addons'),
                    'icon'  => 'eicon-text-align-center',
                ],
                'right' => [
                    'title' => esc_html__('Right', 'jr-addons'),
                    'icon'  => 'eicon-text-align-right',
                ],
            ],
            'default'   => 'left',
            'selectors' => [
                '{{WRAPPER}} .jr-bgt-header' => 'text-align: {{VALUE}};',
            ],
        ]);

        $this->end_controls_section();

        // ──── Style: Tabs ────
        $this->start_controls_section('jr_bgt_style_tabs', [
            'label'     => esc_html__('Tabs', 'jr-addons'),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => ['jr_bgt_show_tabs' => 'yes'],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name'     => 'jr_bgt_tab_typo',
            'selector' => '{{WRAPPER}} .jr-bgt-tab',
        ]);

        $this->add_responsive_control('jr_bgt_tab_padding', [
            'label'      => esc_html__('Padding', 'jr-addons'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'default'    => [
                'top' => '10', 'right' => '24', 'bottom' => '10', 'left' => '24',
                'unit' => 'px', 'isLinked' => false,
            ],
            'selectors' => [
                '{{WRAPPER}} .jr-bgt-tab' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_responsive_control('jr_bgt_tab_gap', [
            'label'      => esc_html__('Gap', 'jr-addons'),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range'      => ['px' => ['min' => 0, 'max' => 50]],
            'default'    => ['size' => 10, 'unit' => 'px'],
            'selectors'  => [
                '{{WRAPPER}} .jr-bgt-tabs' => 'gap: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_responsive_control('jr_bgt_tab_bottom_spacing', [
            'label'      => esc_html__('Bottom Spacing', 'jr-addons'),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range'      => ['px' => ['min' => 0, 'max' => 100]],
            'default'    => ['size' => 40, 'unit' => 'px'],
            'selectors'  => [
                '{{WRAPPER}} .jr-bgt-tabs' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_control('jr_bgt_tab_radius', [
            'label'      => esc_html__('Border Radius', 'jr-addons'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'default'    => [
                'top' => '30', 'right' => '30', 'bottom' => '30', 'left' => '30',
                'unit' => 'px', 'isLinked' => true,
            ],
            'selectors' => [
                '{{WRAPPER}} .jr-bgt-tab' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        // Tab States
        $this->start_controls_tabs('jr_bgt_tab_states');

        // Normal
        $this->start_controls_tab('jr_bgt_tab_normal', [
            'label' => esc_html__('Normal', 'jr-addons'),
        ]);

        $this->add_control('jr_bgt_tab_color', [
            'label'     => esc_html__('Text Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#666666',
            'selectors' => ['{{WRAPPER}} .jr-bgt-tab' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('jr_bgt_tab_bg', [
            'label'     => esc_html__('Background', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => 'transparent',
            'selectors' => ['{{WRAPPER}} .jr-bgt-tab' => 'background-color: {{VALUE}};'],
        ]);

        $this->add_control('jr_bgt_tab_border_color', [
            'label'     => esc_html__('Border Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#cccccc',
            'selectors' => ['{{WRAPPER}} .jr-bgt-tab' => 'border-color: {{VALUE}};'],
        ]);

        $this->add_control('jr_bgt_tab_border_width', [
            'label'      => esc_html__('Border Width', 'jr-addons'),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range'      => ['px' => ['min' => 0, 'max' => 10]],
            'default'    => ['size' => 1, 'unit' => 'px'],
            'selectors'  => [
                '{{WRAPPER}} .jr-bgt-tab' => 'border-width: {{SIZE}}{{UNIT}}; border-style: solid;',
            ],
        ]);

        $this->end_controls_tab();

        // Active
        $this->start_controls_tab('jr_bgt_tab_active_state', [
            'label' => esc_html__('Active', 'jr-addons'),
        ]);

        $this->add_control('jr_bgt_tab_active_color', [
            'label'     => esc_html__('Text Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#333333',
            'selectors' => ['{{WRAPPER}} .jr-bgt-tab.active, {{WRAPPER}} .jr-bgt-tab:hover' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('jr_bgt_tab_active_bg', [
            'label'     => esc_html__('Background', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#f5f0eb',
            'selectors' => ['{{WRAPPER}} .jr-bgt-tab.active, {{WRAPPER}} .jr-bgt-tab:hover' => 'background-color: {{VALUE}};'],
        ]);

        $this->add_control('jr_bgt_tab_active_border', [
            'label'     => esc_html__('Border Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#8B7D6B',
            'selectors' => ['{{WRAPPER}} .jr-bgt-tab.active, {{WRAPPER}} .jr-bgt-tab:hover' => 'border-color: {{VALUE}};'],
        ]);

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();

        // ──── Style: Card ────
        $this->start_controls_section('jr_bgt_style_card', [
            'label' => esc_html__('Card', 'jr-addons'),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('jr_bgt_card_bg', [
            'label'     => esc_html__('Background', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#f5f0eb',
            'selectors' => ['{{WRAPPER}} .jr-bgt-card' => 'background-color: {{VALUE}};'],
        ]);

        $this->add_responsive_control('jr_bgt_card_padding', [
            'label'      => esc_html__('Padding', 'jr-addons'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'default'    => [
                'top' => '20', 'right' => '20', 'bottom' => '20', 'left' => '20',
                'unit' => 'px', 'isLinked' => true,
            ],
            'selectors' => [
                '{{WRAPPER}} .jr-bgt-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_control('jr_bgt_card_radius', [
            'label'      => esc_html__('Border Radius', 'jr-addons'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'default'    => [
                'top' => '12', 'right' => '12', 'bottom' => '12', 'left' => '12',
                'unit' => 'px', 'isLinked' => true,
            ],
            'selectors' => [
                '{{WRAPPER}} .jr-bgt-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Border::get_type(), [
            'name'     => 'jr_bgt_card_border',
            'selector' => '{{WRAPPER}} .jr-bgt-card',
        ]);

        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name'     => 'jr_bgt_card_shadow',
            'selector' => '{{WRAPPER}} .jr-bgt-card',
        ]);

        $this->add_control('jr_bgt_card_hover_effect', [
            'label'        => esc_html__('Hover Lift Effect', 'jr-addons'),
            'type'         => Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => 'yes',
        ]);

        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name'      => 'jr_bgt_card_hover_shadow',
            'label'     => esc_html__('Hover Shadow', 'jr-addons'),
            'selector'  => '{{WRAPPER}} .jr-bgt-card:hover',
            'condition' => ['jr_bgt_card_hover_effect' => 'yes'],
        ]);

        $this->end_controls_section();

        // ──── Style: Image ────
        $this->start_controls_section('jr_bgt_style_image', [
            'label'     => esc_html__('Image', 'jr-addons'),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => ['jr_bgt_show_image' => 'yes'],
        ]);

        $this->add_responsive_control('jr_bgt_img_height', [
            'label'      => esc_html__('Height', 'jr-addons'),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['px', 'vh'],
            'range'      => [
                'px' => ['min' => 100, 'max' => 600],
                'vh' => ['min' => 10, 'max' => 60],
            ],
            'default'   => ['size' => 250, 'unit' => 'px'],
            'selectors' => [
                '{{WRAPPER}} .jr-bgt-card-image' => 'height: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_control('jr_bgt_img_radius', [
            'label'      => esc_html__('Border Radius', 'jr-addons'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'default'    => [
                'top' => '10', 'right' => '10', 'bottom' => '10', 'left' => '10',
                'unit' => 'px', 'isLinked' => true,
            ],
            'selectors' => [
                '{{WRAPPER}} .jr-bgt-card-image, {{WRAPPER}} .jr-bgt-card-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_responsive_control('jr_bgt_img_spacing', [
            'label'      => esc_html__('Bottom Spacing', 'jr-addons'),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range'      => ['px' => ['min' => 0, 'max' => 50]],
            'default'    => ['size' => 15, 'unit' => 'px'],
            'selectors'  => [
                '{{WRAPPER}} .jr-bgt-card-image' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_control('jr_bgt_img_hover_zoom', [
            'label'        => esc_html__('Hover Zoom', 'jr-addons'),
            'type'         => Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => 'yes',
        ]);

        $this->end_controls_section();

        // ──── Style: Badge ────
        $this->start_controls_section('jr_bgt_style_badge', [
            'label'     => esc_html__('Category Badge', 'jr-addons'),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => ['jr_bgt_show_badge' => 'yes'],
        ]);

        $this->add_control('jr_bgt_badge_color', [
            'label'     => esc_html__('Text Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#8B7D6B',
            'selectors' => ['{{WRAPPER}} .jr-bgt-badge' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('jr_bgt_badge_bg', [
            'label'     => esc_html__('Background', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => 'transparent',
            'selectors' => ['{{WRAPPER}} .jr-bgt-badge' => 'background-color: {{VALUE}};'],
        ]);

        $this->add_control('jr_bgt_badge_border_color', [
            'label'     => esc_html__('Border Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#cccccc',
            'selectors' => ['{{WRAPPER}} .jr-bgt-badge' => 'border-color: {{VALUE}};'],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name'     => 'jr_bgt_badge_typo',
            'selector' => '{{WRAPPER}} .jr-bgt-badge',
        ]);

        $this->add_responsive_control('jr_bgt_badge_padding', [
            'label'      => esc_html__('Padding', 'jr-addons'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'default'    => [
                'top' => '4', 'right' => '14', 'bottom' => '4', 'left' => '14',
                'unit' => 'px', 'isLinked' => false,
            ],
            'selectors' => [
                '{{WRAPPER}} .jr-bgt-badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_control('jr_bgt_badge_radius', [
            'label'      => esc_html__('Border Radius', 'jr-addons'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'default'    => [
                'top' => '20', 'right' => '20', 'bottom' => '20', 'left' => '20',
                'unit' => 'px', 'isLinked' => true,
            ],
            'selectors' => [
                '{{WRAPPER}} .jr-bgt-badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_responsive_control('jr_bgt_badge_spacing', [
            'label'      => esc_html__('Bottom Spacing', 'jr-addons'),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range'      => ['px' => ['min' => 0, 'max' => 30]],
            'default'    => ['size' => 10, 'unit' => 'px'],
            'selectors'  => [
                '{{WRAPPER}} .jr-bgt-badge' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();

        // ──── Style: Post Title ────
        $this->start_controls_section('jr_bgt_style_post_title', [
            'label' => esc_html__('Post Title', 'jr-addons'),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('jr_bgt_post_title_color', [
            'label'     => esc_html__('Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#333333',
            'selectors' => ['{{WRAPPER}} .jr-bgt-card-title a' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('jr_bgt_post_title_hover_color', [
            'label'     => esc_html__('Hover Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#8B7D6B',
            'selectors' => ['{{WRAPPER}} .jr-bgt-card-title a:hover' => 'color: {{VALUE}};'],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name'     => 'jr_bgt_post_title_typo',
            'selector' => '{{WRAPPER}} .jr-bgt-card-title',
        ]);

        $this->add_responsive_control('jr_bgt_post_title_spacing', [
            'label'      => esc_html__('Bottom Spacing', 'jr-addons'),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range'      => ['px' => ['min' => 0, 'max' => 50]],
            'default'    => ['size' => 10, 'unit' => 'px'],
            'selectors'  => [
                '{{WRAPPER}} .jr-bgt-card-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();

        // ──── Style: Meta ────
        $this->start_controls_section('jr_bgt_style_meta', [
            'label' => esc_html__('Meta (Date/Author)', 'jr-addons'),
            'tab'   => Controls_Manager::TAB_STYLE,
            'conditions' => [
                'relation' => 'or',
                'terms'    => [
                    ['name' => 'jr_bgt_show_date', 'operator' => '===', 'value' => 'yes'],
                    ['name' => 'jr_bgt_show_author', 'operator' => '===', 'value' => 'yes'],
                ],
            ],
        ]);

        $this->add_control('jr_bgt_meta_color', [
            'label'     => esc_html__('Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#999999',
            'selectors' => ['{{WRAPPER}} .jr-bgt-meta' => 'color: {{VALUE}};'],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name'     => 'jr_bgt_meta_typo',
            'selector' => '{{WRAPPER}} .jr-bgt-meta',
        ]);

        $this->add_responsive_control('jr_bgt_meta_spacing', [
            'label'      => esc_html__('Bottom Spacing', 'jr-addons'),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range'      => ['px' => ['min' => 0, 'max' => 30]],
            'default'    => ['size' => 10, 'unit' => 'px'],
            'selectors'  => [
                '{{WRAPPER}} .jr-bgt-meta' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();

        // ──── Style: Excerpt ────
        $this->start_controls_section('jr_bgt_style_excerpt', [
            'label'     => esc_html__('Excerpt', 'jr-addons'),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => ['jr_bgt_show_excerpt' => 'yes'],
        ]);

        $this->add_control('jr_bgt_excerpt_color', [
            'label'     => esc_html__('Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#777777',
            'selectors' => ['{{WRAPPER}} .jr-bgt-card-excerpt' => 'color: {{VALUE}};'],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name'     => 'jr_bgt_excerpt_typo',
            'selector' => '{{WRAPPER}} .jr-bgt-card-excerpt',
        ]);

        $this->add_responsive_control('jr_bgt_excerpt_spacing', [
            'label'      => esc_html__('Bottom Spacing', 'jr-addons'),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range'      => ['px' => ['min' => 0, 'max' => 50]],
            'default'    => ['size' => 20, 'unit' => 'px'],
            'selectors'  => [
                '{{WRAPPER}} .jr-bgt-card-excerpt' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();

        // ──── Style: Read More Button ────
        $this->start_controls_section('jr_bgt_style_readmore', [
            'label'     => esc_html__('Read More Button', 'jr-addons'),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => ['jr_bgt_show_button' => 'yes'],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name'     => 'jr_bgt_readmore_typo',
            'selector' => '{{WRAPPER}} .jr-bgt-read-more',
        ]);

        $this->add_responsive_control('jr_bgt_readmore_padding', [
            'label'      => esc_html__('Padding', 'jr-addons'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'default'    => [
                'top' => '14', 'right' => '30', 'bottom' => '14', 'left' => '30',
                'unit' => 'px', 'isLinked' => false,
            ],
            'selectors' => [
                '{{WRAPPER}} .jr-bgt-read-more' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_control('jr_bgt_readmore_radius', [
            'label'      => esc_html__('Border Radius', 'jr-addons'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'default'    => [
                'top' => '6', 'right' => '6', 'bottom' => '6', 'left' => '6',
                'unit' => 'px', 'isLinked' => true,
            ],
            'selectors' => [
                '{{WRAPPER}} .jr-bgt-read-more' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_control('jr_bgt_readmore_fullwidth', [
            'label'        => esc_html__('Full Width', 'jr-addons'),
            'type'         => Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => 'yes',
        ]);

        $this->start_controls_tabs('jr_bgt_readmore_tabs');

        $this->start_controls_tab('jr_bgt_readmore_normal', [
            'label' => esc_html__('Normal', 'jr-addons'),
        ]);

        $this->add_control('jr_bgt_readmore_color', [
            'label'     => esc_html__('Text Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => ['{{WRAPPER}} .jr-bgt-read-more' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('jr_bgt_readmore_bg', [
            'label'     => esc_html__('Background', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#8B7D6B',
            'selectors' => ['{{WRAPPER}} .jr-bgt-read-more' => 'background-color: {{VALUE}};'],
        ]);

        $this->end_controls_tab();

        $this->start_controls_tab('jr_bgt_readmore_hover_tab', [
            'label' => esc_html__('Hover', 'jr-addons'),
        ]);

        $this->add_control('jr_bgt_readmore_hover_color', [
            'label'     => esc_html__('Text Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => ['{{WRAPPER}} .jr-bgt-read-more:hover' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('jr_bgt_readmore_hover_bg', [
            'label'     => esc_html__('Background', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#6b5f4f',
            'selectors' => ['{{WRAPPER}} .jr-bgt-read-more:hover' => 'background-color: {{VALUE}};'],
        ]);

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();

        // ──── Style: Load More ────
        $this->start_controls_section('jr_bgt_style_loadmore', [
            'label'     => esc_html__('Load More Button', 'jr-addons'),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => ['jr_bgt_show_loadmore' => 'yes'],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name'     => 'jr_bgt_loadmore_typo',
            'selector' => '{{WRAPPER}} .jr-bgt-loadmore',
        ]);

        $this->add_responsive_control('jr_bgt_loadmore_padding', [
            'label'      => esc_html__('Padding', 'jr-addons'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'default'    => [
                'top' => '14', 'right' => '40', 'bottom' => '14', 'left' => '40',
                'unit' => 'px', 'isLinked' => false,
            ],
            'selectors' => [
                '{{WRAPPER}} .jr-bgt-loadmore' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_control('jr_bgt_loadmore_radius', [
            'label'      => esc_html__('Border Radius', 'jr-addons'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'default'    => [
                'top' => '6', 'right' => '6', 'bottom' => '6', 'left' => '6',
                'unit' => 'px', 'isLinked' => true,
            ],
            'selectors' => [
                '{{WRAPPER}} .jr-bgt-loadmore' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_responsive_control('jr_bgt_loadmore_top_spacing', [
            'label'      => esc_html__('Top Spacing', 'jr-addons'),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range'      => ['px' => ['min' => 0, 'max' => 100]],
            'default'    => ['size' => 40, 'unit' => 'px'],
            'selectors'  => [
                '{{WRAPPER}} .jr-bgt-loadmore-wrap' => 'margin-top: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->start_controls_tabs('jr_bgt_loadmore_tabs');

        $this->start_controls_tab('jr_bgt_loadmore_normal', [
            'label' => esc_html__('Normal', 'jr-addons'),
        ]);

        $this->add_control('jr_bgt_loadmore_color', [
            'label'     => esc_html__('Text Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#666666',
            'selectors' => ['{{WRAPPER}} .jr-bgt-loadmore' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('jr_bgt_loadmore_bg', [
            'label'     => esc_html__('Background', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#e0d6cc',
            'selectors' => ['{{WRAPPER}} .jr-bgt-loadmore' => 'background-color: {{VALUE}};'],
        ]);

        $this->add_group_control(Group_Control_Border::get_type(), [
            'name'     => 'jr_bgt_loadmore_border',
            'selector' => '{{WRAPPER}} .jr-bgt-loadmore',
        ]);

        $this->end_controls_tab();

        $this->start_controls_tab('jr_bgt_loadmore_hover_tab', [
            'label' => esc_html__('Hover', 'jr-addons'),
        ]);

        $this->add_control('jr_bgt_loadmore_hover_color', [
            'label'     => esc_html__('Text Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => ['{{WRAPPER}} .jr-bgt-loadmore:hover' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('jr_bgt_loadmore_hover_bg', [
            'label'     => esc_html__('Background', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#8B7D6B',
            'selectors' => ['{{WRAPPER}} .jr-bgt-loadmore:hover' => 'background-color: {{VALUE}};'],
        ]);

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();

        // ──── Style: Content Area ────
        $this->start_controls_section('jr_bgt_style_content_area', [
            'label' => esc_html__('Content Area', 'jr-addons'),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_responsive_control('jr_bgt_content_padding', [
            'label'      => esc_html__('Padding', 'jr-addons'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'default'    => [
                'top' => '5', 'right' => '5', 'bottom' => '5', 'left' => '5',
                'unit' => 'px', 'isLinked' => true,
            ],
            'selectors' => [
                '{{WRAPPER}} .jr-bgt-card-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();

        $post_type      = $s['jr_bgt_post_type'];
        $taxonomy       = $s['jr_bgt_taxonomy'];
        $posts_per_page = $s['jr_bgt_posts_per_page'];
        $orderby        = $s['jr_bgt_orderby'];
        $order          = $s['jr_bgt_order'];
        $image_size     = $s['jr_bgt_image_size'];
        $excerpt_length = $s['jr_bgt_excerpt_length'];
        $title_tag      = $s['jr_bgt_header_title_tag'];
        $tabs_position  = $s['jr_bgt_tabs_position'] ?? 'above_header';

        // Get categories for tabs
        $categories = [];
        if ($s['jr_bgt_show_tabs'] === 'yes') {
            if ($s['jr_bgt_tabs_source'] === 'manual' && !empty($s['jr_bgt_manual_cats'])) {
                $slugs = array_map('trim', explode(',', $s['jr_bgt_manual_cats']));
                foreach ($slugs as $slug) {
                    $term = get_term_by('slug', $slug, $taxonomy);
                    if ($term && !is_wp_error($term)) {
                        $categories[] = $term;
                    }
                }
            } else {
                $hide_empty = ($s['jr_bgt_hide_empty'] ?? 'yes') === 'yes';
                $categories = get_terms([
                    'taxonomy'   => $taxonomy,
                    'hide_empty' => $hide_empty,
                    'orderby'    => 'name',
                    'order'      => 'ASC',
                ]);
                if (is_wp_error($categories)) {
                    $categories = [];
                }
            }
        }

        // Query
        $args = [
            'post_type'      => $post_type,
            'posts_per_page' => $posts_per_page,
            'paged'          => 1,
            'orderby'        => $orderby,
            'order'          => $order,
            'post_status'    => 'publish',
        ];
        $query = new \WP_Query($args);

        // Data for JS
        $widget_data = [
            'post_type'           => $post_type,
            'taxonomy'            => $taxonomy,
            'posts_per_page'      => $posts_per_page,
            'orderby'             => $orderby,
            'order'               => $order,
            'excerpt_length'      => $excerpt_length,
            'button_text'         => $s['jr_bgt_button_text'],
            'show_category_badge' => $s['jr_bgt_show_badge'],
            'show_excerpt'        => $s['jr_bgt_show_excerpt'],
            'show_button'         => $s['jr_bgt_show_button'],
            'show_image'          => $s['jr_bgt_show_image'],
            'show_date'           => $s['jr_bgt_show_date'],
            'show_author'         => $s['jr_bgt_show_author'],
            'image_size'          => $image_size,
            'max_pages'           => $query->max_num_pages,
            'loadmore_text'       => $s['jr_bgt_loadmore_text'],
            'loading_text'        => $s['jr_bgt_loading_text'],
            'nomore_text'         => $s['jr_bgt_nomore_text'],
        ];

        $hover_class    = $s['jr_bgt_card_hover_effect'] === 'yes' ? ' jr-bgt-card-hover' : '';
        $zoom_class     = ($s['jr_bgt_img_hover_zoom'] ?? 'yes') === 'yes' ? ' jr-bgt-img-zoom' : '';
        $btn_full_class = ($s['jr_bgt_readmore_fullwidth'] ?? 'yes') === 'yes' ? ' jr-bgt-btn-full' : '';

        ?>
        <div class="jr-bgt-wrapper"
             data-settings='<?php echo esc_attr(wp_json_encode($widget_data)); ?>'
             data-hover-class="<?php echo esc_attr(trim($hover_class)); ?>"
             data-zoom-class="<?php echo esc_attr(trim($zoom_class)); ?>"
             data-btn-class="<?php echo esc_attr(trim($btn_full_class)); ?>">

            <?php
            // Tabs & Header ordering
            $show_tabs   = $s['jr_bgt_show_tabs'] === 'yes' && !empty($categories);
            $show_header = $s['jr_bgt_show_header'] === 'yes';

            if ($tabs_position === 'above_header') {
                if ($show_tabs) $this->render_tabs($s, $categories);
                if ($show_header) $this->render_header($s, $title_tag);
            } else {
                if ($show_header) $this->render_header($s, $title_tag);
                if ($show_tabs) $this->render_tabs($s, $categories);
            }
            ?>

            <div class="jr-bgt-grid">
                <?php if ($query->have_posts()) : ?>
                    <?php while ($query->have_posts()) : $query->the_post(); ?>
                        <?php $this->render_card($s, $taxonomy, $excerpt_length, $image_size, $hover_class, $zoom_class, $btn_full_class); ?>
                    <?php endwhile; ?>
                <?php else : ?>
                    <p class="jr-bgt-no-posts"><?php esc_html_e('No posts found.', 'jr-addons'); ?></p>
                <?php endif; ?>
                <?php wp_reset_postdata(); ?>
            </div>

            <?php if ($s['jr_bgt_show_loadmore'] === 'yes' && $query->max_num_pages > 1) : ?>
                <div class="jr-bgt-loadmore-wrap">
                    <button class="jr-bgt-loadmore" data-page="1">
                        <?php echo esc_html($s['jr_bgt_loadmore_text']); ?>
                    </button>
                </div>
            <?php endif; ?>

        </div>
        <?php
    }

    /**
     * Render tabs
     */
    private function render_tabs($s, $categories) {
        ?>
        <div class="jr-bgt-tabs">
            <button class="jr-bgt-tab active" data-category="all">
                <?php echo esc_html($s['jr_bgt_all_tab_text']); ?>
            </button>
            <?php foreach ($categories as $cat) : ?>
                <button class="jr-bgt-tab" data-category="<?php echo esc_attr($cat->slug); ?>">
                    <?php echo esc_html(strtoupper($cat->name)); ?>
                </button>
            <?php endforeach; ?>
        </div>
        <?php
    }

    /**
     * Render header
     */
    private function render_header($s, $tag) {
        ?>
        <div class="jr-bgt-header">
            <?php if (!empty($s['jr_bgt_header_title'])) : ?>
                <<?php echo esc_html($tag); ?> class="jr-bgt-section-title">
                    <?php echo esc_html($s['jr_bgt_header_title']); ?>
                </<?php echo esc_html($tag); ?>>
            <?php endif; ?>
            <?php if (!empty($s['jr_bgt_header_subtitle'])) : ?>
                <p class="jr-bgt-section-subtitle"><?php echo esc_html($s['jr_bgt_header_subtitle']); ?></p>
            <?php endif; ?>
        </div>
        <?php
    }

    /**
     * Render single card
     */
    private function render_card($s, $taxonomy, $excerpt_length, $image_size, $hover_class, $zoom_class, $btn_full_class) {
        $cats     = get_the_terms(get_the_ID(), $taxonomy);
        $cat_name = '';
        $cat_slug = '';
        if ($cats && !is_wp_error($cats)) {
            $cat_name = $cats[0]->name;
            $cat_slug = $cats[0]->slug;
        }

        $excerpt = get_the_excerpt();
        if (empty($excerpt)) {
            $excerpt = wp_trim_words(get_the_content(), $excerpt_length, '...');
        } else {
            $excerpt = wp_trim_words($excerpt, $excerpt_length, '...');
        }
        ?>
        <div class="jr-bgt-card<?php echo esc_attr($hover_class); ?>" data-category="<?php echo esc_attr($cat_slug); ?>">
            <?php if ($s['jr_bgt_show_image'] === 'yes') : ?>
                <div class="jr-bgt-card-image<?php echo esc_attr($zoom_class); ?>">
                    <a href="<?php the_permalink(); ?>">
                        <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail($image_size); ?>
                        <?php else : ?>
                            <div class="jr-bgt-no-image">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#bbb" stroke-width="1.5">
                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                                    <circle cx="8.5" cy="8.5" r="1.5"/>
                                    <polyline points="21 15 16 10 5 21"/>
                                </svg>
                            </div>
                        <?php endif; ?>
                    </a>
                </div>
            <?php endif; ?>

            <div class="jr-bgt-card-content">
                <?php if ($s['jr_bgt_show_badge'] === 'yes' && $cat_name) : ?>
                    <span class="jr-bgt-badge"><?php echo esc_html(strtoupper($cat_name)); ?></span>
                <?php endif; ?>

                <h3 class="jr-bgt-card-title">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h3>

                <?php if ($s['jr_bgt_show_date'] === 'yes' || $s['jr_bgt_show_author'] === 'yes') : ?>
                    <div class="jr-bgt-meta">
                        <?php if ($s['jr_bgt_show_date'] === 'yes') : ?>
                            <span class="jr-bgt-meta-date">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                <?php echo get_the_date(); ?>
                            </span>
                        <?php endif; ?>
                        <?php if ($s['jr_bgt_show_author'] === 'yes') : ?>
                            <span class="jr-bgt-meta-author">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                <?php the_author(); ?>
                            </span>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <?php if ($s['jr_bgt_show_excerpt'] === 'yes') : ?>
                    <p class="jr-bgt-card-excerpt"><?php echo esc_html($excerpt); ?></p>
                <?php endif; ?>

                <?php if ($s['jr_bgt_show_button'] === 'yes') : ?>
                    <a href="<?php the_permalink(); ?>" class="jr-bgt-read-more<?php echo esc_attr($btn_full_class); ?>">
                        <?php echo esc_html($s['jr_bgt_button_text']); ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }
}