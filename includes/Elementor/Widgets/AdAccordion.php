<?php
namespace JR_Addons\Elementor\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;

class AdAccordion extends Widget_Base {

    public function get_name() {
        return 'ad-accordion';
    }

    public function get_title() {
        return esc_html__( 'JR Ad Accordion', 'jr-addons' );
    }

    public function get_icon() {
        return 'jr-get-icon';
    }

    public function get_categories() {
        return [ 'jr-addons' ];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'accordion_section',
            [
                'label' => esc_html__( 'Accordion Items', 'jr-addons' ),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'title',
            [
                'label'       => esc_html__( 'Title', 'jr-addons' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => 'Partial Hospitalization Program (PHP)',
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'description',
            [
                'label'       => esc_html__( 'Description', 'jr-addons' ),
                'type'        => Controls_Manager::TEXTAREA,
                'default'     => 'A higher level of structure designed to slow things down...',
                'rows'        => 4,
            ]
        );

        $repeater->add_control(
            'link',
            [
                'label'       => esc_html__( 'Learn More URL', 'jr-addons' ),
                'type'        => Controls_Manager::URL,
                'placeholder' => 'https://yoursite.com/programs/php',
            ]
        );

        $repeater->add_control(
            'image',
            [
                'label'   => esc_html__( 'Preview Image', 'jr-addons' ),
                'type'    => Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'items',
            [
                'label'       => esc_html__( 'Add Programs', 'jr-addons' ),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'title_field' => '{{{ title }}}',
                'default'     => [
                    [
                        'title'       => 'Partial Hospitalization Program (PHP)',
                        'description' => 'A higher level of structure designed to slow things down, restore stability, and support a system reset.',
                    ],
                    [
                        'title'       => 'Intensive Outpatient Program (IOP)',
                        'description' => 'Structured support that allows individuals to continue participating in daily life while building regulation and skills.',
                    ],
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $items    = $settings['items'] ?? [];

        if ( empty( $items ) ) return;

        $first_image = ! empty( $items[0]['image']['url'] ) ? $items[0]['image']['url'] : '';
        ?>

        <div class="grid lg:grid-cols-12 gap-12 items-start mb-24">
            
            <!-- Left: Accordion Column -->
            <div class="lg:col-span-5 space-y-8">
                <h3 class="text-xs font-black uppercase tracking-widest text-[#8B837C] mb-6 pl-4">Core Programs</h3>
                
                <div class="program-accordion flex flex-col">
                    <?php 
                    foreach ( $items as $index => $item ) : 
                        $active_class = ($index === 0) ? 'active' : '';
                        $image_url    = ! empty( $item['image']['url'] ) ? esc_url( $item['image']['url'] ) : '';
                    ?>
                        <div class="group border-b border-black/5 hover:bg-[#FDF7F1] transition-all duration-500 rounded-2xl overflow-hidden <?php echo $active_class; ?>">
                            <button class="accordion-trigger cursor-pointer w-full text-left p-4 flex justify-between items-center transition-all" 
                                    data-image="<?php echo $image_url; ?>">
                                <span class="text-xl md:text-2xl font-black tracking-tighter">
                                    <?php echo esc_html( $item['title'] ); ?>
                                </span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6 9l6 6l6-6"></path></svg>
                            </button>
                            
                            <div class="accordion-content max-h-0 transition-all duration-500 ease-in-out opacity-0 overflow-hidden <?php echo $active_class ? 'max-h-[300px] opacity-100' : ''; ?>">
                                <div class="px-6 md:px-8 pb-8">
                                    <p class="text-lg font-light text-gray-600 leading-relaxed mb-4">
                                        <?php echo wp_kses_post( $item['description'] ); ?>
                                    </p>
                                    <?php if ( ! empty( $item['link']['url'] ) ) : ?>
                                        <a href="<?php echo esc_url( $item['link']['url'] ); ?>" 
                                           class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-[#8B837C] hover:text-black transition-colors">
                                            Learn More 
                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7-7l7 7l-7 7"></path></svg>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Explore All Button -->
                <div class="pt-8 pl-4">
                    <a href="/programs" class="bg-black text-white px-10 py-5 rounded-full text-xs font-bold uppercase tracking-widest shadow-xl flex items-center gap-3 w-fit group">
                        Explore All Programs and Services 
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7-7l7 7l-7 7"></path></svg>
                    </a>
                </div>
            </div>

            <!-- Right: Dynamic Image -->
            <div class="hidden lg:block lg:col-span-7 sticky top-48">
                <div class="relative h-[500px] md:h-[600px] rounded-[3rem] overflow-hidden shadow-2xl border border-black/5 bg-[#DDD9CF]">
                    <img id="dynamic-program-img" 
                         src="<?php echo esc_url( $first_image ); ?>" 
                         alt="Program Visual" 
                         class="w-full !h-full object-cover transition-all duration-700"
                         onerror="this.onerror=null;this.src='https://placehold.co/600x400/1a1a1a/888?text=Image';">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                </div>
            </div>
        </div>

        <!-- JavaScript for Accordion + Image Change -->
        <script>
        document.addEventListener('DOMContentLoaded', function () {
        const triggers = document.querySelectorAll('.accordion-trigger');
        const previewImg = document.getElementById('dynamic-program-img');

        triggers.forEach(trigger => {
            trigger.addEventListener('click', function () {
            const parent = this.closest('.group');
            const content = parent.querySelector('.accordion-content');

            const allGroups = document.querySelectorAll('.program-accordion .group');
            const wasActive = parent.classList.contains('active');

            // Close all
            allGroups.forEach(group => {
                group.classList.remove('active');
                const c = group.querySelector('.accordion-content');
                if (c) {
                c.style.maxHeight = '0';
                c.style.opacity = '0';
                }
            });

            // If it was NOT active, open it; if it was active, keep it closed
            if (!wasActive) {
                parent.classList.add('active');
                if (content) {
                content.style.maxHeight = content.scrollHeight + 'px';
                content.style.opacity = '1';
                }
            }

            // Change Image with smooth transition
            const newImage = this.getAttribute('data-image');
            if (newImage && previewImg) {
                previewImg.style.opacity = '0';
                setTimeout(() => {
                previewImg.src = newImage;
                previewImg.style.opacity = '1';
                }, 250);
            }
            });
        });
        });
        </script>

        <?php
    }
}