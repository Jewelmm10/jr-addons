<?php
namespace JR_Addons\Elementor\Widgets;

if (!defined('ABSPATH')) {
    exit;
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Repeater;

class Insurance extends Widget_Base {

    public function get_name() {
        return 'jr_insurance';
    }

    public function get_title() {
        return esc_html__('JR Insurance', 'jr-addons');
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

    protected function register_controls() {

        

        // --- Content Section ---
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__('Main Content', 'jr-addons'),
            ]
        );

        $this->add_control(
            'title_part_1',
            [
                'label' => esc_html__('Title (Regular)', 'jr-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => 'A New Era of',
            ]
        );
        $this->add_control(
            'title_part_2',
            [
                'label' => esc_html__('Title (Italic)', 'jr-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => 'Mental Healthcare',
            ]
        );
        $this->end_controls_section();

      

        // --- Credibility Repeater ---
        $this->start_controls_section(
            'section_credibility',
            [
                'label' => esc_html__('Credibility Strip (Bottom)', 'jr-addons'),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'item_icon',
            [
                'label' => esc_html__('Icon', 'jr-addons'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-award',
                    'library' => 'solid',
                ],
            ]
        );

        $repeater->add_control(
            'item_text',
            [
                'label' => esc_html__('Label', 'jr-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => 'Licensed Clinical Leadership',
            ]
        );

        $this->add_control(
            'credibility_list',
            [
                'label' => esc_html__('Items', 'jr-addons'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    ['item_text' => 'Licensed Clinical Leadership'],
                    ['item_text' => 'LeadAZ Methodology'],
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>


<div class="max-w-7xl mx-auto glass-panel p-10 md:p-16 rounded-[3.5rem] shadow-2xl border border-white/50 flex flex-col md:flex-row items-center justify-between gap-12 scroll-reveal stagger-2 visible" style="height: 349px;">
                    <div class="space-y-6 max-w-3xl">
                        <h1 class="text-5xl md:text-7xl font-black tracking-tighter text-[#1a1a1a] mb-8">Insurance</h1>
                        <h2 class="text-3xl md:text-4xl font-black tracking-tighter text-[#1a1a1a]">We accept hundreds of insurance plans across the U.S.</h2>
                        <p class="text-[18px] md:text-[22px] font-light text-[#1a1a1a]/80 leading-relaxed">
                            We work with most insurance providers. Contact us, and we’ll help you find an insurance option that works for your family.
                        </p>
                        <div class="flex flex-wrap gap-10 opacity-40 pt-4">
                            <iconify-icon icon="logos:aetna" class="h-6"></iconify-icon>
                            <iconify-icon icon="logos:cigna" class="h-6 grayscale"></iconify-icon>
                            <iconify-icon icon="logos:unitedhealthcare" class="h-8 grayscale"></iconify-icon>
                            <iconify-icon icon="logos:humana" class="h-8 grayscale"></iconify-icon>
                        </div>
                    </div>
                    <a href="#" id="insurance-cta-btn" class="wiggle-trigger bg-black text-white px-12 py-6 rounded-full font-garet text-[12px] font-black uppercase tracking-widest shadow-xl magnetic-btn flex items-center gap-4 whitespace-nowrap">
                        Contact us today <iconify-icon icon="lucide:arrow-right" class="text-lg wiggle-arrow"></iconify-icon>
                    </a>
                </div>
        <?php
    }
}