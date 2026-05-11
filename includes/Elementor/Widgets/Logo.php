<?php
namespace JR_Addons\Elementor\Widgets;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;

class Logo extends Widget_Base {

    public function get_name() {
        return 'jr-addons_logo';
    }

    public function get_title() {
        return esc_html__('Logo', 'jr-addons');
    }

    public function get_icon() {
        return 'jr-get-icon';
    }

    public function get_categories() {
        return ['jr-addons']; 
    }

    public function get_keywords() {
        return ['Logo', 'Site', 'sitelogo',];
    }

    protected function register_controls() {

        // --- Background Section ---
        $this->start_controls_section(
            'logo_setting',
            [
                'label' => esc_html__('Settings', 'jr-addons'),
            ]
        );
        $this->add_control(
            'logo_image',
            [
                'label'   => __('Logo', 'spater-core'),
                'type'    => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );
        $this->add_control(
            'title_part_1',
            [
                'label' => esc_html__('Title (Bold)', 'jr-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => 'IMPACT',
            ]
        );
        $this->add_control(
            'title_part_2',
            [
                'label' => esc_html__('Title (Regular)', 'jr-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => 'MINDS',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $image = $settings['logo_image']['url'] ;
        $title1 = $settings['title_part_1'];
        $title2 = $settings['title_part_2'];
    ?>
        <a href="<?php home_url( '/' ); ?>" id="nav-logo-link" class="flex items-center gap-3.5 group">
            <img src="<?= esc_url($image) ?>" alt="Impact Minds Logo" class="w-10 h-10 group-hover:scale-110 transition-transform duration-500" onerror="this.onerror=null;this.src='https://placehold.co/40x40/1a1a1a/888?text=Image';">
            <div class="font-garet text-sm md:text-base tracking-tight text-black flex items-center gap-1.5 uppercase">
                <span class="font-bold"><?php echo $title1; ?></span>
                <span class="font-normal"><?php echo $title2; ?></span>
            </div>
        </a>

    <?php
    }
}