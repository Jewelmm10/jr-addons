<?php
namespace JR_Addons\Elementor\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;

class Accordion extends Widget_Base {

	public function get_name() {
		return 'jr_accordion';
	}

	public function get_title() {
		return esc_html__( 'JR Accordion', 'jr-addons' );
	}

	public function get_icon() {
        return 'jr-get-icon';
    }

	public function get_categories() {
		return [ 'jr-addons' ];
	}

	public function get_keywords() {
		return [ 'accordion', 'faq' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'accordion',
			[
				'label' => esc_html__( 'Accordion List', 'jr-addons' ),
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'selected_icon',
			[
				'label' => esc_html__( 'Accordion', 'jr-addons' ),
				'type'  => Controls_Manager::ICONS,
				'default' => [
					'value'   => 'fas fa-star',
					'library' => 'fa-solid',
				],
			]
		);

		$repeater->add_control(
			'quetion',
			[
				'label'       => esc_html__( 'Quetion', 'jr-addons' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'default'     => esc_html__( 'This is the heading', 'jr-addons' ),
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'answer',
			[
				'label'       => esc_html__( 'Answer', 'jr-addons' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'default'     => esc_html__( 'This is the heading', 'jr-addons' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'link',
			[
				'label'     => esc_html__( 'Link', 'jr-addons' ),
				'type'      => Controls_Manager::URL,
				'dynamic'   => [ 'active' => true ],
				'placeholder' => esc_html__( 'https://your-link.com', 'jr-addons' ),
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		?>
        
		<div class="grid lg:grid-cols-12 gap-16 items-start">
                        <!-- LEFT: ACCORDION COLUMN -->
                        <div class="lg:col-span-7 space-y-12">
                            
                            <!-- CORE PROGRAMS GROUP -->
                            <div class="space-y-4">
                                <h3 class="font-garet text-xs font-black uppercase tracking-[0.4em] text-[#8B837C] mb-10 pl-8">Core Programs</h3>
                                <div class="program-accordion flex flex-col">
                                    <!-- PHP -->
                                    <div class="group border-b border-black/5 hover:bg-[#FDF7F1] transition-all duration-500 rounded-3xl overflow-hidden">
                                        <button class="accordion-trigger w-full text-left p-8 md:p-10 flex justify-between items-center transition-all" data-program="php" data-image="https://vgbujcuwptvheqijyjbe.supabase.co/storage/v1/object/public/hmac-uploads/uploads/de7478e2-268a-4dd4-8634-6470d711cc10/1773095113018-b389ebe9/Impact_Minds_Asset_ClinicMood__2_.jpeg">
                                            <span class="text-2xl md:text-3xl font-black tracking-tighter">Partial Hospitalization Program (PHP)</span>
                                            <iconify-icon icon="lucide:chevron-down" class="text-2xl transform transition-transform duration-500 group-[.active]:rotate-180 opacity-40"></iconify-icon>
                                        </button>
                                        <div class="accordion-content max-h-0 transition-all duration-500 ease-in-out opacity-0 group-[.active]:max-h-[300px] group-[.active]:opacity-100">
                                            <div class="px-8 md:px-10 pb-10">
                                                <p class="text-lg font-light text-[#3A3A3A] leading-relaxed mb-6">A higher level of structure designed to slow things down, restore stability, and support a system reset.</p>
                                                <a href="/programs/php" id="acc-php-link" class="inline-flex items-center gap-2 font-garet text-[10px] font-black uppercase tracking-widest text-[#8B837C] hover:text-black transition-colors">
                                                    Learn More <iconify-icon icon="lucide:arrow-right"></iconify-icon>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- ADVANCED MODALITIES GROUP -->
                            <div class="space-y-4 pt-10">
                                <h3 class="font-garet text-xs font-black uppercase tracking-[0.4em] text-[#8B837C] mb-10 pl-8">Advanced Modalities</h3>
                                <div class="program-accordion flex flex-col">
                                    
                                    <!-- TMS -->
                                    <div class="group border-b border-black/5 hover:bg-[#FDF7F1] transition-all duration-500 rounded-3xl overflow-hidden">
                                        <button class="accordion-trigger w-full text-left p-8 md:p-10 flex justify-between items-center transition-all" data-program="tms" data-image="https://vgbujcuwptvheqijyjbe.supabase.co/storage/v1/object/public/hmac-uploads/uploads/de7478e2-268a-4dd4-8634-6470d711cc10/1773095115675-3c099789/Impact_Minds_Asset_TMS__3_.jpeg">
                                            <span class="text-2xl md:text-3xl font-black tracking-tighter">Transcranial Magnetic Stimulation (TMS)</span>
                                            <iconify-icon icon="lucide:chevron-down" class="text-2xl transform transition-transform duration-500 group-[.active]:rotate-180 opacity-40"></iconify-icon>
                                        </button>
                                        <div class="accordion-content max-h-0 transition-all duration-500 ease-in-out opacity-0 group-[.active]:max-h-[300px] group-[.active]:opacity-100">
                                            <div class="px-8 md:px-10 pb-10">
                                                <p class="text-lg font-light text-[#3A3A3A] leading-relaxed mb-6">A non-invasive, FDA-approved tool that uses targeted magnetic stimulation to support areas of the brain involved in mood, motivation, and regulation.</p>
                                                <a href="/modalities/tms" id="acc-tms-link" class="inline-flex items-center gap-2 font-garet text-[10px] font-black uppercase tracking-widest text-[#8B837C] hover:text-black transition-colors">
                                                    Learn More <iconify-icon icon="lucide:arrow-right"></iconify-icon>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- ACADEMY -->
                                    <div class="group border-b border-black/5 hover:bg-[#FDF7F1] transition-all duration-500 rounded-3xl overflow-hidden">
                                        <button class="accordion-trigger w-full text-left p-8 md:p-10 flex justify-between items-center transition-all" data-program="academy" data-image="https://vgbujcuwptvheqijyjbe.supabase.co/storage/v1/object/public/hmac-uploads/uploads/de7478e2-268a-4dd4-8634-6470d711cc10/1773254988818-8748da84/Graphic_Growth__4_.jpeg">
                                            <span class="text-2xl md:text-3xl font-black tracking-tighter">Resilience and Leadership Academy</span>
                                            <iconify-icon icon="lucide:chevron-down" class="text-2xl transform transition-transform duration-500 group-[.active]:rotate-180 opacity-40"></iconify-icon>
                                        </button>
                                        <div class="accordion-content max-h-0 transition-all duration-500 ease-in-out opacity-0 group-[.active]:max-h-[300px] group-[.active]:opacity-100">
                                            <div class="px-8 md:px-10 pb-10">
                                                <p class="text-lg font-light text-[#3A3A3A] leading-relaxed mb-6">Practical tools for clear thinking, purposeful action, recovery from setbacks, and long-term habit building.</p>
                                                <a href="/academy" id="acc-academy-link" class="inline-flex items-center gap-2 font-garet text-[10px] font-black uppercase tracking-widest text-[#8B837C] hover:text-black transition-colors">
                                                    Learn More <iconify-icon icon="lucide:arrow-right"></iconify-icon>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- SENSORY -->
                                    <div class="group border-b border-black/5 hover:bg-[#FDF7F1] transition-all duration-500 rounded-3xl overflow-hidden">
                                        <button class="accordion-trigger w-full text-left p-8 md:p-10 flex justify-between items-center transition-all" data-program="sensory" data-image="https://vgbujcuwptvheqijyjbe.supabase.co/storage/v1/object/public/hmac-uploads/uploads/de7478e2-268a-4dd4-8634-6470d711cc10/1773095114368-e0f14bf5/Impact_Minds_Asset_Sensory_Immersion_Room__9_.jpeg">
                                            <span class="text-2xl md:text-3xl font-black tracking-tighter">Immersive Sensory Rooms</span>
                                            <iconify-icon icon="lucide:chevron-down" class="text-2xl transform transition-transform duration-500 group-[.active]:rotate-180 opacity-40"></iconify-icon>
                                        </button>
                                        <div class="accordion-content max-h-0 transition-all duration-500 ease-in-out opacity-0 group-[.active]:max-h-[300px] group-[.active]:opacity-100">
                                            <div class="px-8 md:px-10 pb-10">
                                                <p class="text-lg font-light text-[#3A3A3A] leading-relaxed mb-6">Intentionally designed environments to control mood and support nervous system regulation through light, sound, and spatial design.</p>
                                                <a href="/modalities/sensory-rooms" id="acc-sensory-link" class="inline-flex items-center gap-2 font-garet text-[10px] font-black uppercase tracking-widest text-[#8B837C] hover:text-black transition-colors">
                                                    Learn More <iconify-icon icon="lucide:arrow-right"></iconify-icon>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- MOVEMENT -->
                                    <div class="group border-b border-black/5 hover:bg-[#FDF7F1] transition-all duration-500 rounded-3xl overflow-hidden">
                                        <button class="accordion-trigger w-full text-left p-8 md:p-10 flex justify-between items-center transition-all" data-program="movement" data-image="https://vgbujcuwptvheqijyjbe.supabase.co/storage/v1/object/public/hmac-uploads/uploads/de7478e2-268a-4dd4-8634-6470d711cc10/1773095114047-64043419/Impact_Minds_Asset_Sensory_Immersion_Room__6_.jpeg">
                                            <span class="text-2xl md:text-3xl font-black tracking-tighter">Movement Lab</span>
                                            <iconify-icon icon="lucide:chevron-down" class="text-2xl transform transition-transform duration-500 group-[.active]:rotate-180 opacity-40"></iconify-icon>
                                        </button>
                                        <div class="accordion-content max-h-0 transition-all duration-500 ease-in-out opacity-0 group-[.active]:max-h-[300px] group-[.active]:opacity-100">
                                            <div class="px-8 md:px-10 pb-10">
                                                <p class="text-lg font-light text-[#3A3A3A] leading-relaxed mb-6">Intentional movement experiences that build capacity, regulation, and body-based awareness.</p>
                                                <a href="/modalities/movement-lab" id="acc-movement-link" class="inline-flex items-center gap-2 font-garet text-[10px] font-black uppercase tracking-widest text-[#8B837C] hover:text-black transition-colors">
                                                    Learn More <iconify-icon icon="lucide:arrow-right"></iconify-icon>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- MEDICAL -->
                                    <div class="group border-b border-black/5 hover:bg-[#FDF7F1] transition-all duration-500 rounded-3xl overflow-hidden">
                                        <button class="accordion-trigger w-full text-left p-8 md:p-10 flex justify-between items-center transition-all" data-program="medical" data-image="https://vgbujcuwptvheqijyjbe.supabase.co/storage/v1/object/public/hmac-uploads/uploads/de7478e2-268a-4dd4-8634-6470d711cc10/1773095112280-6718cfbb/Impact_Minds_Asset__Neurons__1_.jpeg">
                                            <span class="text-2xl md:text-3xl font-black tracking-tighter">Integrated Primary Care &amp; Psychiatry</span>
                                            <iconify-icon icon="lucide:chevron-down" class="text-2xl transform transition-transform duration-500 group-[.active]:rotate-180 opacity-40"></iconify-icon>
                                        </button>
                                        <div class="accordion-content max-h-0 transition-all duration-500 ease-in-out opacity-0 group-[.active]:max-h-[300px] group-[.active]:opacity-100">
                                            <div class="px-8 md:px-10 pb-10">
                                                <p class="text-lg font-light text-[#3A3A3A] leading-relaxed mb-6">Medical and psychiatric support coordinated within the care team to reduce fragmentation.</p>
                                                <a href="/modalities/medical" id="acc-medical-link" class="inline-flex items-center gap-2 font-garet text-[10px] font-black uppercase tracking-widest text-[#8B837C] hover:text-black transition-colors">
                                                    Learn More <iconify-icon icon="lucide:arrow-right"></iconify-icon>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- INDIVIDUAL -->
                                    <div class="group border-b border-black/5 hover:bg-[#FDF7F1] transition-all duration-500 rounded-3xl overflow-hidden">
                                        <button class="accordion-trigger w-full text-left p-8 md:p-10 flex justify-between items-center transition-all" data-program="individual" data-image="https://vgbujcuwptvheqijyjbe.supabase.co/storage/v1/object/public/hmac-uploads/uploads/de7478e2-268a-4dd4-8634-6470d711cc10/1773095115092-f8744a04/Impact_Minds_Asset_Therapy__1_.jpeg">
                                            <span class="text-2xl md:text-3xl font-black tracking-tighter">Individual Therapy</span>
                                            <iconify-icon icon="lucide:chevron-down" class="text-2xl transform transition-transform duration-500 group-[.active]:rotate-180 opacity-40"></iconify-icon>
                                        </button>
                                        <div class="accordion-content max-h-0 transition-all duration-500 ease-in-out opacity-0 group-[.active]:max-h-[300px] group-[.active]:opacity-100">
                                            <div class="px-8 md:px-10 pb-10">
                                                <p class="text-lg font-light text-[#3A3A3A] leading-relaxed mb-6">One-on-one therapeutic work focused on skill development, insight, and real-world application.</p>
                                                <a href="/modalities/individual-therapy" id="acc-individual-link" class="inline-flex items-center gap-2 font-garet text-[10px] font-black uppercase tracking-widest text-[#8B837C] hover:text-black transition-colors">
                                                    Learn More <iconify-icon icon="lucide:arrow-right"></iconify-icon>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- GROUP -->
                                    <div class="group border-b border-black/5 hover:bg-[#FDF7F1] transition-all duration-500 rounded-3xl overflow-hidden">
                                        <button class="accordion-trigger w-full text-left p-8 md:p-10 flex justify-between items-center transition-all" data-program="group" data-image="https://vgbujcuwptvheqijyjbe.supabase.co/storage/v1/object/public/hmac-uploads/uploads/de7478e2-268a-4dd4-8634-6470d711cc10/1773095112636-917add28/Impact_Minds_Asset_GroupTherapy__1_.jpeg">
                                            <span class="text-2xl md:text-3xl font-black tracking-tighter">Group Therapy</span>
                                            <iconify-icon icon="lucide:chevron-down" class="text-2xl transform transition-transform duration-500 group-[.active]:rotate-180 opacity-40"></iconify-icon>
                                        </button>
                                        <div class="accordion-content max-h-0 transition-all duration-500 ease-in-out opacity-0 group-[.active]:max-h-[300px] group-[.active]:opacity-100">
                                            <div class="px-8 md:px-10 pb-10">
                                                <p class="text-lg font-light text-[#3A3A3A] leading-relaxed mb-6">Structured group support that provides connection, normalization, and shared learning.</p>
                                                <a href="/modalities/group-therapy" id="acc-group-link" class="inline-flex items-center gap-2 font-garet text-[10px] font-black uppercase tracking-widest text-[#8B837C] hover:text-black transition-colors">
                                                    Learn More <iconify-icon icon="lucide:arrow-right"></iconify-icon>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- FAMILY -->
                                    <div class="group border-b border-black/5 hover:bg-[#FDF7F1] transition-all duration-500 rounded-3xl overflow-hidden">
                                        <button class="accordion-trigger w-full text-left p-8 md:p-10 flex justify-between items-center transition-all" data-program="family" data-image="https://vgbujcuwptvheqijyjbe.supabase.co/storage/v1/object/public/hmac-uploads/uploads/de7478e2-268a-4dd4-8634-6470d711cc10/1773095112636-917add28/Impact_Minds_Asset_GroupTherapy__1_.jpeg">
                                            <span class="text-2xl md:text-3xl font-black tracking-tighter">Family Therapy</span>
                                            <iconify-icon icon="lucide:chevron-down" class="text-2xl transform transition-transform duration-500 group-[.active]:rotate-180 opacity-40"></iconify-icon>
                                        </button>
                                        <div class="accordion-content max-h-0 transition-all duration-500 ease-in-out opacity-0 group-[.active]:max-h-[300px] group-[.active]:opacity-100">
                                            <div class="px-8 md:px-10 pb-10">
                                                <p class="text-lg font-light text-[#3A3A3A] leading-relaxed mb-6">Structured support that helps families strengthen communication, consistency, and shared understanding.</p>
                                                <a href="/modalities/family-therapy" id="acc-family-link" class="inline-flex items-center gap-2 font-garet text-[10px] font-black uppercase tracking-widest text-[#8B837C] hover:text-black transition-colors">
                                                    Learn More <iconify-icon icon="lucide:arrow-right"></iconify-icon>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- EXPLORE ALL BUTTON -->
                            <div class="mt-20 flex flex-col items-start">
                                <div class="w-32 border-t-4 border-[#8B837C] mb-12"></div>
                                <a href="/programs" id="all-programs-view-btn" class="btn-luxury bg-[#1a1a1a] text-white px-12 py-8 rounded-full text-[13px] font-black uppercase tracking-[0.2em] shadow-2xl inline-flex items-center gap-4 group">
                                    Explore All Programs and Services
                                    <iconify-icon icon="lucide:arrow-right" class="text-2xl transition-transform group-hover:translate-x-2"></iconify-icon>
                                </a>
                            </div>
                        </div>

                        <!-- RIGHT: DYNAMIC PHOTO COLUMN -->
                        <div class="lg:col-span-5 sticky top-48">
                            <div class="relative h-[600px] md:h-[700px] rounded-[4rem] overflow-hidden shadow-2xl group border-8 border-white">
                                <img id="program-preview-image" src="https://vgbujcuwptvheqijyjbe.supabase.co/storage/v1/object/public/hmac-uploads/uploads/de7478e2-268a-4dd4-8634-6470d711cc10/1773095112357-1a75110e/Impact_Minds_Asset__Neurons__2_.jpeg" class="absolute inset-0 w-full h-full object-cover transition-all duration-700 ease-in-out transform scale-105" alt="Program Preview" onerror="this.onerror=null;this.src='https://placehold.co/600x400/1a1a1a/888?text=Image';" style="opacity: 1; transform: scale(1.05);">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                            </div>
                            <div class="mt-8 text-center">
                                <p class="font-garet text-[11px] font-bold uppercase tracking-[0.4em] text-[#8B837C] opacity-60">
                                    Select a program to view details
                                </p>
                            </div>
                        </div>
                    </div>
		<?php
	}
}