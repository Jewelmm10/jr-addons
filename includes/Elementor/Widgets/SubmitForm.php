<?php
namespace JR_Addons\Elementor\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class SubmitForm extends Widget_Base {

	public function get_name() {
		return 'jr_submit_form';
	}

	public function get_title() {
		return esc_html__( 'JR Submit Form', 'jr-addons' );
	}

	public function get_icon() {
        return 'jr-get-icon';
    }

	public function get_categories() {
		return [ 'jr-addons' ];
	}

	public function get_keywords() {
		return [ 'form', 'contact', 'jr' ];
	}

    protected function register_controls() {
        $this->start_controls_section('form-content', [
            'label' => esc_html__('Form Settings', 'jr-addons'),
        ]);

        $this->add_control('section_title', [
            'label' => 'Form Title',
            'type' => Controls_Manager::TEXT,
        ]);

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>

<div id="referral-form" class="relative reveal-on-scroll stagger-2 active">
    <!-- Decorative Background Accents -->
    <div class="absolute -top-20 -right-20 w-80 h-80 bg-[#DDD9CF]/30 rounded-full blur-[100px] z-0"></div>
    <div class="absolute -bottom-20 -left-20 w-64 h-64 bg-[#8B837C]/20 rounded-full blur-[80px] z-0"></div>

    <!-- The Interactive Card -->
    <div
        class="floating-card relative z-10 bg-[#DDD9CF] rounded-[3.5rem] p-10 md:p-16 border border-[#C5BDB2]/40 shadow-2xl overflow-hidden group">
        <div class="absolute top-10 right-10 opacity-10 group-hover:opacity-20 transition-opacity">
            <span class="text-6xl text-[#1A1A1A]">
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2">
                        <rect width="8" height="4" x="8" y="2" rx="1" ry="1"></rect>
                        <path
                            d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2m4 7h4m-4 5h4m-8-5h.01M8 16h.01">
                        </path>
                    </g>
                </svg>
            </span>
        </div>

        <h3 class="text-3xl md:text-4xl font-black text-[#1A1A1A] mb-12 pb-8 border-b border-[#D0C9BD] tracking-tight">
            Referral Form <br>
            <span class="text-lg font-light opacity-50">Secure HIPAA Portal Preview</span>
        </h3>

        <div class="space-y-10 max-h-[550px] overflow-y-auto pr-6 custom-scrollbar">
            <!-- Form Sections -->
            <div class="space-y-8">
                <!-- Organization -->
                <div class="grid md:grid-cols-2 gap-8">
                    <div class="space-y-3">
                        <label
                            class="font-garet text-[10px] font-bold uppercase tracking-[0.2em] text-[#8B837C] block">Business
                            / Org Name</label>
                        <div
                            class="w-full h-14 bg-[#FDF7F1] border border-[#D0C9BD] rounded-2xl flex items-center px-6 text-[#999999] text-base">
                            Enter organization</div>
                    </div>
                    <div class="space-y-3">
                        <label
                            class="font-garet text-[10px] font-bold uppercase tracking-[0.2em] text-[#8B837C] block">Current
                            Date</label>
                        <div
                            class="w-full h-14 bg-[#FDF7F1] border border-[#D0C9BD] rounded-2xl flex items-center px-6 text-[#999999] text-base">
                            MM / DD / YYYY</div>
                    </div>
                </div>

                <!-- Referral Professional -->
                <div class="pt-4 space-y-6">
                    <h4
                        class="font-garet text-[11px] font-bold uppercase tracking-[0.3em] text-[#4A4540] flex items-center gap-3">
                        <span><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2">
                                    <path d="m16 11l2 2l4-4m-6 12v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                </g>
                            </svg></span>
                        Referring Professional
                    </h4>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div
                            class="h-14 bg-[#FDF7F1] border border-[#D0C9BD] rounded-2xl px-6 flex items-center text-base text-[#999999]">
                            Full Name</div>
                        <div
                            class="h-14 bg-[#FDF7F1] border border-[#D0C9BD] rounded-2xl px-6 flex items-center text-base text-[#999999]">
                            Title / Credentials</div>
                    </div>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div
                            class="h-14 bg-[#FDF7F1] border border-[#D0C9BD] rounded-2xl px-6 flex items-center text-base text-[#999999]">
                            Email Address</div>
                        <div
                            class="h-14 bg-[#FDF7F1] border border-[#D0C9BD] rounded-2xl px-6 flex items-center text-base text-[#999999]">
                            Office Number</div>
                    </div>
                </div>

                <!-- Patient Info -->
                <div class="pt-4 space-y-6">
                    <h4
                        class="font-garet text-[11px] font-bold uppercase tracking-[0.3em] text-[#4A4540] flex items-center gap-3">
                        <iconify-icon icon="lucide:users" class="text-lg"></iconify-icon>
                        Patient Details
                    </h4>
                    <div class="grid md:grid-cols-3 gap-6">
                        <div
                            class="col-span-2 h-14 bg-[#FDF7F1] border border-[#D0C9BD] rounded-2xl px-6 flex items-center text-base text-[#999999]">
                            Legal Name</div>
                        <div
                            class="h-14 bg-[#FDF7F1] border border-[#D0C9BD] rounded-2xl px-6 flex items-center text-base text-[#999999]">
                            DOB</div>
                    </div>
                </div>

                <!-- Service Need -->
                <div class="space-y-3">
                    <label
                        class="font-garet text-[10px] font-bold uppercase tracking-[0.2em] text-[#8B837C] block">Intended
                        Level of Care</label>
                    <div
                        class="w-full h-14 bg-[#FDF7F1] border border-[#D0C9BD] rounded-2xl flex items-center justify-between px-6 text-[#1A1A1A] font-medium">
                        Select Clinical Program
                        <iconify-icon icon="lucide:chevron-down" class="text-[#8B837C]"></iconify-icon>
                    </div>
                </div>

                <!-- Clinical Context -->
                <div class="space-y-3">
                    <label
                        class="font-garet text-[10px] font-bold uppercase tracking-[0.2em] text-[#8B837C] block">Clinical
                        Context / Referral Notes</label>
                    <div
                        class="w-full h-32 bg-[#FDF7F1] border border-[#D0C9BD] rounded-2xl p-6 text-[#999999] text-base leading-relaxed">
                        Please provide brief context for our intake team...
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Band -->
        <div class="mt-12 pt-10 border-t border-[#D0C9BD] flex items-center justify-between">
            <div class="flex items-center gap-3 text-[#8B837C]">
                <span class="text-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2"
                            d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z">
                        </path>
                    </svg>
                </span>
                <span class="text-[11px] font-bold uppercase tracking-widest">Secure Encryption</span>
            </div>
            <button
                class="bg-white/40 text-[#4A4540] px-10 py-4 rounded-2xl font-black text-sm uppercase tracking-[0.2em] cursor-default border border-[#C5BDB2]/30">
                Preview Mode
            </button>
        </div>
    </div>

    <!-- Trust Badge -->
    <div
        class="absolute -bottom-8 left-1/2 -translate-x-1/2 bg-[#FDF7F1] shadow-2xl border border-[#E8E3D8] px-10 py-3 rounded-full z-20 flex items-center gap-4 reveal-on-scroll stagger-3 active">
        <span class="text-[#4A4540]"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                viewBox="0 0 24 24">
                <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                    <rect width="18" height="11" x="3" y="11" rx="2" ry="2"></rect>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                </g>
            </svg></span>
        <span class="font-garet text-[11px] uppercase tracking-widest font-black text-[#4A4540]">Verified Secure
            Referral Submission</span>
    </div>
</div>



<?php
    }
}