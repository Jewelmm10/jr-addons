<?php
namespace JR_Addons\Elementor\Widgets;

if (!defined('ABSPATH')) {
    exit;
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Repeater;

class Hero extends Widget_Base {

    public function get_name() {
        return 'jr_hero';
    }

    public function get_title() {
        return esc_html__('JR Hero', 'jr-addons');
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

        // --- Background Section ---
        $this->start_controls_section(
            'section_bg',
            [
                'label' => esc_html__('Background & Media', 'jr-addons'),
            ]
        );

        $this->add_control(
            'hero_image',
            [
                'label' => esc_html__('Choose Hero Image', 'jr-addons'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => 'https://vgbujcuwptvheqijyjbe.supabase.co/storage/v1/object/public/hmac-uploads/uploads/de7478e2-268a-4dd4-8634-6470d711cc10/1773350800488-cce8ab97/Forrest_sillhouette_Woman__2_.png',
                ],
            ]
        );

        $this->add_control(
            'overlay_opacity',
            [
                'label' => esc_html__('Overlay Opacity (%)', 'jr-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => ['min' => 0, 'max' => 100],
                ],
                'default' => ['size' => 10],
                'selectors' => [
                    '{{WRAPPER}} .jr-hero-overlay' => 'opacity: calc({{SIZE}}/100);',
                ],
            ]
        );

        $this->end_controls_section();

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
                'label' => esc_html__('Title (Italic/Light)', 'jr-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => 'Mental Wellness',
            ]
        );

        $this->add_control(
            'box_title',
            [
                'label' => esc_html__('Box Heading', 'jr-addons'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Immersive. Built for real progress that lasts.',
            ]
        );

        $this->add_control(
            'box_desc',
            [
                'label' => esc_html__('Box Description', 'jr-addons'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Impact Minds is a calm, stigma-free environment that blends clinical expertise, cutting-edge neuroscience...',
            ]
        );

        $this->end_controls_section();

        // --- Buttons Section ---
        $this->start_controls_section(
            'section_buttons',
            [
                'label' => esc_html__('Call to Action', 'jr-addons'),
            ]
        );

        $this->add_control('btn_1_text', ['label' => 'Primary Button Text', 'type' => Controls_Manager::TEXT, 'default' => 'Book a Free Consultation']);
        $this->add_control('btn_1_link', ['label' => 'Primary Link', 'type' => Controls_Manager::URL, 'placeholder' => 'https://']);
        
        $this->add_control('btn_2_text', ['label' => 'Secondary Button Text', 'type' => Controls_Manager::TEXT, 'default' => 'Verify Insurance', 'separator' => 'before']);
        $this->add_control('btn_2_link', ['label' => 'Secondary Link', 'type' => Controls_Manager::URL, 'placeholder' => 'https://']);

        $this->add_control(
            'bottom_notice',
            [
                'label' => esc_html__('Bottom Text Line', 'jr-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => 'Licensed clinical care. Most major plans accepted.',
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



<section id="hero-section" class="relative !h-screen w-full flex flex-col overflow-hidden parallax-wrap">
    <div class="absolute inset-0 z-0">
        <img src="https://impactminds.care/wp-content/uploads/2026/03/Impact_Minds_Asset_Sensory_Immersion_Room__6_-1.jpeg"
            alt="Programs Hero" class="parallax-img w-full !h-[120%] object-cover absolute top-[-10%] left-0"
            style="transform: translateY(0px) scale(1.1);">
        <div class="absolute inset-0 bg-gradient-to-r from-[#1A1A1A]/85 via-[#1A1A1A]/60 to-transparent"></div>
    </div>

    <div
        class="relative z-10 max-w-[1440px] mx-auto w-full px-8 md:px-24 flex flex-col h-full pt-[92px] pb-8 justify-center">
        <div class="reveal-on-scroll active max-w-4xl">
            <h1
                class="text-5xl md:text-7xl lg:text-[7rem] leading-[1.05] text-[#FDF7F1] hero-text-shadow font-black tracking-tighter stagger-1">
                One System. Multiple Levels of Care. <span class="font-light italic text-[#DDD9CF]">Clear Direction
                    Forward.</span>
            </h1>

            <div class="mt-10 mb-12 stagger-2">
                <p class="text-lg md:text-xl text-[#FDF7F1] font-light leading-relaxed max-w-2xl">
                    Impact Minds offers medical, clinical, and experiential programs designed to strengthen regulation,
                    restore clarity, and support sustainable momentum — whether someone is navigating a difficult season
                    or simply ready to grow.
                </p>
            </div>

            <div class="flex flex-wrap gap-4 stagger-3 mb-10">
                <a href="#" id="hero-cta-consult"
                    class="btn-luxury bg-[#FDF7F1] text-deep-black px-10 py-4 rounded-full text-[10px] font-bold uppercase tracking-[0.2em] shadow-2xl flex items-center justify-center min-h-[44px]">
                    Book a Free Consultation
                </a>
                <a href="#" id="hero-cta-verify"
                    class="btn-luxury bg-transparent border border-white text-white px-10 py-4 rounded-full text-[10px] font-bold uppercase tracking-[0.2em] backdrop-blur-sm flex items-center justify-center min-h-[44px]">
                    Verify Insurance
                </a>
            </div>

            <div class="flex flex-wrap gap-6 stagger-3 pt-6 border-t border-white/20">
                <div
                    class="flex items-center gap-3 text-[#DDD9CF] font-garet text-[10px] font-bold uppercase tracking-[0.2em]">
                    <span class="text-base"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                            viewBox="0 0 24 24">
                            <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2">
                                <path
                                    d="m15.477 12.89l1.515 8.526a.5.5 0 0 1-.81.47l-3.58-2.687a1 1 0 0 0-1.197 0l-3.586 2.686a.5.5 0 0 1-.81-.469l1.514-8.526">
                                </path>
                                <circle cx="12" cy="8" r="6"></circle>
                            </g>
                        </svg></span>
                    Licensed Clinical Leadership
                </div>
                <div
                    class="flex items-center gap-3 text-[#DDD9CF] font-garet text-[10px] font-bold uppercase tracking-[0.2em]">
                    <span class="text-base"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                            viewBox="0 0 24 24">
                            <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2">
                                <path
                                    d="M2 9.5a5.5 5.5 0 0 1 9.591-3.676a.56.56 0 0 0 .818 0A5.49 5.49 0 0 1 22 9.5c0 2.29-1.5 4-3 5.5l-5.492 5.313a2 2 0 0 1-3 .019L5 15c-1.5-1.5-3-3.2-3-5.5">
                                </path>
                                <path d="M3.22 13H9.5l.5-1l2 4.5l2-7l1.5 3.5h5.27"></path>
                            </g>
                        </svg></span>
                    Integrated Medical Care
                </div>
                <div
                    class="flex items-center gap-3 text-[#DDD9CF] font-garet text-[10px] font-bold uppercase tracking-[0.2em]">
                    <span class="text-base">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                            <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2">
                                <path
                                    d="M11.017 2.814a1 1 0 0 1 1.966 0l1.051 5.558a2 2 0 0 0 1.594 1.594l5.558 1.051a1 1 0 0 1 0 1.966l-5.558 1.051a2 2 0 0 0-1.594 1.594l-1.051 5.558a1 1 0 0 1-1.966 0l-1.051-5.558a2 2 0 0 0-1.594-1.594l-5.558-1.051a1 1 0 0 1 0-1.966l5.558-1.051a2 2 0 0 0 1.594-1.594zM20 2v4m2-2h-4">
                                </path>
                                <circle cx="4" cy="20" r="2"></circle>
                            </g>
                        </svg>
                    </span>
                    Experiential Innovation
                </div>
            </div>
        </div>
    </div>
</section>
<script>
jQuery(document).ready(function($) {
    const $img = $('.parallax-img');
    if ($img.length === 0) return;

    function updateParallax() {
        const scrollY = $(window).scrollTop();
        const translateY = scrollY * 0.45;
        $img.css('transform', `translateY(${translateY}px) scale(1.1)`);
    }

    $(window).on('scroll', function() {
        window.requestAnimationFrame(updateParallax);
    });

    updateParallax();
});
</script>
<?php
    }
}