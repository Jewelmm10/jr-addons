<?php

namespace JR_Addons\Elementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) exit;

class SiteLogo extends Widget_Base {

    public function get_name() {
        return 'jr_site_logo';
    }

    public function get_title() {
        return 'Site Logo';
    }

    public function get_icon() {
        return 'jr-get-icon';
    }

    public function get_categories() {
        return ['jr-addons'];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label' => 'Logo Settings',
            ]
        );

        $this->add_control(
            'custom_logo',
            [
                'label' => 'Custom Logo',
                'type' => Controls_Manager::MEDIA,
            ]
        );

        $this->add_control(
            'logo_width',
            [
                'label' => 'Width',
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => ['min' => 50, 'max' => 400],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 150,
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {

        $settings = $this->get_settings_for_display();

        $logo_url = '';

        if (!empty($settings['custom_logo']['url'])) {
            $logo_url = $settings['custom_logo']['url'];
        } elseif (has_custom_logo()) {
            $logo_id = get_theme_mod('custom_logo');
            $logo_url = wp_get_attachment_image_url($logo_id, 'full');
        }

        if (!$logo_url) return;

        echo '<a href="' . esc_url(home_url('/')) . '">';
        echo '<img src="' . esc_url($logo_url) . '" 
                    style="width:' . esc_attr($settings['logo_width']['size']) . 'px;" 
                    alt="Logo">';
        echo '</a>';
    }
}