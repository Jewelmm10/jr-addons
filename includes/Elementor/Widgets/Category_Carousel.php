<?php
namespace JR_Addons\Elementor\Widgets;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;

if (!defined('ABSPATH')) exit;

class Category_Carousel extends Widget_Base {

    public function get_name() {
        return 'jr_category_carousel';
    }

    public function get_title() {
        return __('Category Carousel', 'jr-addons');
    }

    public function get_icon() {
        return 'jr-get-icon';
    }

    public function get_categories() {
        return ['jr-addons'];
    }

    public function get_script_depends() {
        return ['swiper'];
    }

    public function get_style_depends() {
        return ['swiper'];
    }

    protected function register_controls() {

        /* ======================
           CONTENT SECTION
        =======================*/
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Items', 'jr-addons'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

        // Image/Icon
        $repeater->add_control(
            'item_type',
            [
                'label' => __('Type', 'jr-addons'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'image' => ['title' => 'Image', 'icon' => 'eicon-image-bold'],
                    'icon'  => ['title' => 'Icon', 'icon' => 'eicon-star'],
                ],
                'default' => 'image',
            ]
        );

        $repeater->add_control(
            'item_image',
            [
                'label' => __('Image', 'jr-addons'),
                'type' => Controls_Manager::MEDIA,
                'condition' => [
                    'item_type' => 'image'
                ]
            ]
        );

        $repeater->add_control(
            'item_icon',
            [
                'label' => __('Icon', 'jr-addons'),
                'type' => Controls_Manager::ICONS,
                'condition' => [
                    'item_type' => 'icon'
                ]
            ]
        );

        // Category select
        $repeater->add_control(
            'category_id',
            [
                'label' => __('Select Category', 'jr-addons'),
                'type' => Controls_Manager::SELECT2,
                'options' => $this->get_product_categories(),
                'label_block' => true,
            ]
        );

        // Show product count
        $repeater->add_control(
            'show_count',
            [
                'label' => __('Show Product Count', 'jr-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'items',
            [
                'label' => __('Carousel Items', 'jr-addons'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ category_id }}}',
                'default' => [],
            ]
        );

        $this->end_controls_section();

        // Carousel Settings (same as your previous one)
        $this->start_controls_section(
            'section_carousel',
            [
                'label' => __('Carousel Options', 'spater-core'),
            ]
        );

        $this->add_responsive_control(
            'slides_per_view',
            [
                'label'   => __('Items Visible', 'spater-core'),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    '1'     => '1',
                    '2'     => '2',
                    '3'     => '3',
                    '4'     => '4',
                    '5'     => '5',
                    '6'     => '6',
                    '7'     => '7',
                    '8'     => '8',
                    '9'     => '9',
                    '10'    => '10',
                ],
                'default'            => '5',
                'tablet_default'     => '3',
                'mobile_default'     => '2',
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'space_between',
            [
                'label'   => __('Gap Between Items (px)', 'spater-core'),
                'type'    => Controls_Manager::NUMBER,
                'default' => 20,
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label'   => __('Auto Play', 'spater-core'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'autoplay_speed',
            [
                'label'     => __('Auto Play Speed (ms)', 'spater-core'),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 4000,
                'condition' => ['autoplay' => 'yes'],
            ]
        );

        $this->add_control(
            'loop',
            [
                'label'   => __('Infinite Loop', 'spater-core'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_navigation',
            [
                'label'   => __('Show Arrows', 'spater-core'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_pagination',
            [
                'label'   => __('Show Dots', 'spater-core'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'prev_icon',
            [
                'label' => __('Previous Icon', 'jr-addons'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value'   => 'fas fa-chevron-left',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    'show_navigation' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'next_icon',
            [
                'label' => __('Next Icon', 'jr-addons'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value'   => 'fas fa-chevron-right',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    'show_navigation' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();
        /* ======================
           STYLE SECTION
        =======================*/

        $this->start_controls_section(
            'style_section',
            [
                'label' => __('Style', 'jr-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'card_bg',
            [
                'label' => __('Card Background', 'jr-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .jr-cat-item' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label' => __('Icon/Image Size', 'jr-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 20,
                        'max' => 200,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .jr-cat-item img,
                     {{WRAPPER}} .jr-cat-item i' => 'width: {{SIZE}}px;height: {{SIZE}}px;',
                ],
            ]
        );

        $this->end_controls_section();

        // Navigation Style Section
        $this->start_controls_section(
            'section_style_navigation',
            [
                'label' => __('Navigation', 'jr-addons'),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_navigation' => 'yes',
                ],
            ]
        );

        // Icon Size
        $this->add_responsive_control(
            'nav_icon_size',
            [
                'label' => __('Icon Size', 'jr-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => ['min' => 10, 'max' => 50],
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-button-next i, {{WRAPPER}} .swiper-button-prev i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .swiper-button-next svg, {{WRAPPER}} .swiper-button-prev svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Button Size (Circle width/height)
        $this->add_responsive_control(
            'nav_button_size',
            [
                'label' => __('Button Size', 'jr-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => ['min' => 20, 'max' => 100],
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-button-next, {{WRAPPER}} .swiper-button-prev' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Normal and Hover Tabs
        $this->start_controls_tabs('tabs_nav_style');

        // --- Normal Tab ---
        $this->start_controls_tab(
            'tab_nav_normal',
            ['label' => __('Normal', 'jr-addons')]
        );

        $this->add_control(
            'nav_color',
            [
                'label' => __('Icon Color', 'jr-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .swiper-button-next, {{WRAPPER}} .swiper-button-prev' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .swiper-button-next svg, {{WRAPPER}} .swiper-button-prev svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'nav_bg_color',
            [
                'label' => __('Background Color', 'jr-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .swiper-button-next, {{WRAPPER}} .swiper-button-prev' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'nav_border',
                'selector' => '{{WRAPPER}} .swiper-button-next, {{WRAPPER}} .swiper-button-prev',
            ]
        );

        $this->end_controls_tab();

        // --- Hover Tab ---
        $this->start_controls_tab(
            'tab_nav_hover',
            ['label' => __('Hover', 'jr-addons')]
        );

        $this->add_control(
            'nav_color_hover',
            [
                'label' => __('Icon Color', 'jr-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .swiper-button-next:hover, {{WRAPPER}} .swiper-button-prev:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .swiper-button-next:hover svg, {{WRAPPER}} .swiper-button-prev:hover svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'nav_bg_color_hover',
            [
                'label' => __('Background Color', 'jr-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .swiper-button-next:hover, {{WRAPPER}} .swiper-button-prev:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'nav_border_hover',
            [
                'label' => __('Border Color', 'jr-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .swiper-button-next:hover, {{WRAPPER}} .swiper-button-prev:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control(
            'nav_border_radius',
            [
                'label' => __('Border Radius', 'jr-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .swiper-button-next, {{WRAPPER}} .swiper-button-prev' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->end_controls_section();


    }

    private function get_product_categories() {
        $terms = get_terms([
            'taxonomy' => 'product_cat',
            'hide_empty' => false,
        ]);

        $options = [];
        foreach ($terms as $term) {
            $options[$term->term_id] = $term->name;
        }

        return $options;
    }

    protected function render() {
        $settings  = $this->get_settings_for_display();
        $slider_id = 'jr-category-carousel-' . $this->get_id();

        // Responsive Values
        $desktop = !empty($settings['slides_per_view']) ? (int) $settings['slides_per_view'] : 5;
        $tablet  = !empty($settings['slides_per_view_tablet']) ? (int) $settings['slides_per_view_tablet'] : 3;
        $mobile  = !empty($settings['slides_per_view_mobile']) ? (int) $settings['slides_per_view_mobile'] : 2;

        // Swiper Settings
        $swiper_settings = [
            'loop' => ($settings['loop'] === 'yes'),

            'autoplay' => ($settings['autoplay'] === 'yes') ? [
                'delay' => (int) ($settings['autoplay_speed'] ?? 4000),
                'disableOnInteraction' => false,
            ] : false,

            'spaceBetween' => (int) ($settings['space_between'] ?? 20),

            'slidesPerView' => $desktop,

            'grabCursor' => true,

            'breakpoints' => [
                320 => [
                    'slidesPerView' => $mobile,
                ],
                768 => [
                    'slidesPerView' => $tablet,
                ],
                1024 => [
                    'slidesPerView' => $desktop,
                ],
            ],
        ];
        ?>

         <div class="jr_category_carousel relative">

            <div id="<?php echo esc_attr($slider_id); ?>" class="swiper jr-swiper-cat" data-settings='<?php echo wp_json_encode($swiper_settings); ?>' >
                <div class="swiper-wrapper">

                    <?php foreach ($settings['items'] as $item):

                        $term = get_term($item['category_id']);
                        $count = $term ? $term->count : 0;
                        $link = get_term_link($item['category_id'], 'product_cat');
                    ?>
                    <div class="swiper-slide">
                        <a href="#" class="jr-cat-item">

                            <div class="jr-cat-media">
                                <?php if ($item['item_type'] === 'image' && !empty($item['item_image']['url'])): ?>
                                    <img src="<?php echo esc_url($item['item_image']['url']); ?>">
                                <?php elseif ($item['item_type'] === 'icon' && !empty($item['item_icon']['value'])): ?>
                                    <i class="<?php echo esc_attr($item['item_icon']['value']); ?>"></i>
                                <?php endif; ?>
                            </div>

                            <h4 class="jr-cat-title">
                                <?php echo esc_html($term->name ?? 'Category'); ?>
                            </h4>

                            <?php if (!empty($item['show_count'])): ?>
                                <span class="jr-cat-count">
                                    <?php echo esc_html($count); ?> Products
                                </span>
                            <?php endif; ?>

                        </a>
                    </div>

                    <?php endforeach; ?>

                </div>

                

                <!-- Navigation -->
                <?php if ($settings['show_navigation'] === 'yes') : ?>
                    <div class="swiper-button-prev">
                        <?php \Elementor\Icons_Manager::render_icon( $settings['prev_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                    </div>
                    <div class="swiper-button-next">
                        <?php \Elementor\Icons_Manager::render_icon( $settings['next_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                    </div>
                <?php endif; ?>

            </div>
            <!-- Pagination -->
            <?php if ($settings['show_pagination'] === 'yes') : ?>
                <div class="swiper-pagination !-bottom-6"></div>
            <?php endif; ?>

        </div>

       

        <?php
    }
}