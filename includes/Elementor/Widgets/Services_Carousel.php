<?php
namespace JR_Addons\Elementor\Widgets;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;

class Services_Carousel extends Widget_Base {

    public function get_name() {
        return 'spater_services_carousel';
    }

    public function get_title() {
        return __('SP: Services Carousel', 'spater-core');
    }

    public function get_icon() {
        return '';          
    }
    public function get_script_depends() {
        return [ 'swiper' ];  // Elementor-এর built-in Swiper JS
    }
    public function get_style_depends() {
        return [ 'swiper', 'e-swiper' ];  // Elementor-এর Swiper CSS + extra
    }

    public function get_categories() {
        return ['spater-elements'];       
    }

    protected function register_controls() {

        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Services', 'spater-core'),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'service_name',
            [
                'label'       => __('Service Name', 'spater-core'),
                'type'        => Controls_Manager::TEXT,
                'default'     => 'Partial Hospitalization Program',
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'service_image',
            [
                'label'   => __('Service Image', 'spater-core'),
                'type'    => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'service_link',
            [
                'label'       => __('Service Link (optional)', 'spater-core'),
                'type'        => Controls_Manager::URL,
                'placeholder' => 'https://your-site.com/service',
                'label_block' => true,
            ]
        );

        $this->add_control(
            'services',
            [
                'label'       => __('Services List', 'spater-core'),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [
                        'service_name'  => 'Partial Hospitalization Program',
                        'service_image' => ['url' => Utils::get_placeholder_image_src()],
                    ],
                    [
                        'service_name'  => 'Intensive Outpatient Program',
                        'service_image' => ['url' => Utils::get_placeholder_image_src()],
                    ],
                    [
                        'service_name'  => 'Neurofeedback and Biofeedback',
                        'service_image' => ['url' => Utils::get_placeholder_image_src()],
                    ],
                ],
                'title_field' => '{{{ service_name }}}',
            ]
        );

        $this->end_controls_section();


        // Carousel Settings
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
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                ],
                'default'         => '3',
                'tablet_default'  => '2',
                'mobile_default'  => '1',
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

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $id = 'sp-swiper-' . $this->get_id();

        $slides = [
            'desktop' => (int) ($settings['slides_per_view'] ?? 3),
            'tablet'  => (int) ($settings['slides_per_view_tablet'] ?? 2),
            'mobile'  => (int) ($settings['slides_per_view_mobile'] ?? 1),
        ];

        $config = [
            'slidesPerView' => $slides,
            'spaceBetween'  => (int) $settings['space_between'],
            'loop'          => $settings['loop'] === 'yes',
            'autoplay'      => $settings['autoplay'] === 'yes' ? ['delay' => (int) $settings['autoplay_speed']] : false,
            'navigation'    => $settings['show_navigation'] === 'yes',
            'pagination'    => $settings['show_pagination'] === 'yes' ? ['type' => 'bullets', 'clickable' => true] : false,
            'grabCursor'    => true,
        ];
        ?>

<div class="spater-service-carousel relative">

    <div class="swiper spater-swiper" id="<?= esc_attr($id) ?>"
        data-swiper='<?= wp_json_encode($config, JSON_UNESCAPED_SLASHES) ?>'>

        <div class="swiper-wrapper">

            <?php foreach ($settings['services'] as $item):

                        $has_link = !empty($item['service_link']['url']);
                        $link_attr = $has_link ? 'href="' . esc_url($item['service_link']['url']) . '"' : '';
                        $target = $has_link && $item['service_link']['is_external'] ? ' target="_blank" rel="noopener"' : '';

                    ?>

            <div class="swiper-slide">

                <div class="service-item">

                    <?php if ($has_link): ?>
                    <a <?= $link_attr ?> <?= $target ?> class="service-link-wrapper">
                        <?php endif; ?>

                        <div class="service-image">
                            <img src="<?= esc_url($item['service_image']['url']) ?>"
                                alt="<?= esc_attr($item['service_name']) ?>">
                        </div>

                        <div class="service-title">
                            <?= esc_html($item['service_name']) ?>
                        </div>

                        <?php if ($has_link): ?>
                    </a>
                    <?php endif; ?>

                </div>

            </div>

            <?php endforeach; ?>

        </div>

        <?php if ($settings['show_pagination'] === 'yes'): ?>
        <div class="swiper-pagination"></div>
        <?php endif; ?>

    </div>

    <?php if ($settings['show_navigation'] === 'yes'): ?>
    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>
    <?php endif; ?>

</div>

<?php
    }
} 