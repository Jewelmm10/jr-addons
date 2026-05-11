<?php
namespace JR_Addons\Elementor\Widgets;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class Counting extends Widget_Base {

    public function get_name() {
        return 'jr_counting';
    }

    public function get_title() {
        return esc_html__('JR Counting', 'jr-addons');
    }

    public function get_icon() {
        return 'jr-get-icon';
    }

    public function get_categories() {
        return ['jr-addons'];
    }

    public function get_style_depends() {
        return ['jr-addons-style'];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__('Content', 'jr-addons'),
            ]
        );

        $this->add_control(
            'event_date',
            [
                'label'       => esc_html__('Event Date & Time', 'jr-addons'),
                'type'        => Controls_Manager::DATE_TIME,
                'default'     => '2026-05-28 14:00',
                'description' => 'May 28, 2026, 2:00 PM',
            ]
        );

        $this->add_control(
            'rsvp_link',
            [
                'label'       => esc_html__('RSVP Link', 'jr-addons'),
                'type'        => Controls_Manager::URL,
                'placeholder' => 'https://your-site.com/rsvp',
                'default'     => ['url' => '#'],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings   = $this->get_settings_for_display();
        $target_date = !empty($settings['event_date']) ? $settings['event_date'] : '2026-05-28 14:00';
        $rsvp_url   = !empty($settings['rsvp_link']['url']) ? esc_url($settings['rsvp_link']['url']) : '#';
        ?>

        <div id="go-countdown-banner" class="fixed left-0 right-0 z-[45] bg-[#DDD9CF]/50 backdrop-blur-xl border-b border-black/5 opacity-0 invisible translate-y-[-20px] transition-all duration-500 ease-out" style="top: 204px;">
            <div class="max-w-7xl mx-auto px-6 md:px-12 py-4 md:py-6 flex flex-col md:flex-row items-center justify-between gap-6 relative">

                <!-- Close Button -->
                <button id="close-go-banner" class="absolute top-3 right-6 text-[#3A3632]/50 hover:text-[#3A3632] transition-colors" aria-label="Close">
                    <span class="text-2xl">
						<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 6L6 18M6 6l12 12"></path></svg>
					</span>
                </button>

                <!-- Left: Event Info -->
                <div class="flex flex-col items-center md:items-start text-center md:text-left">
                    <span class="font-garet text-[9px] md:text-[10px] uppercase tracking-[0.3em] text-[#3A3632]/60 font-bold mb-1">UPCOMING EVENT</span>
                    <h4 class="font-roboto text-lg md:text-2xl font-black text-[#3A3632] leading-tight">Impact Minds Grand Opening</h4>
                    <p class="font-garet text-[10px] text-[#3A3632]/70 uppercase tracking-widest mt-1">
                        Scottsdale Campus • May 28, 2026 • 2:00 PM - 6:00 PM
                    </p>
                    <p class="font-garet text-[11px] md:text-[12px] text-[#3A3632] font-bold mt-2">
                        RSVP to receive a complimentary swag bag upon arrival.
                    </p>
                </div>

                <!-- Center: Live Countdown -->
                <div id="go-timer-container" class="flex items-center justify-center font-roboto text-[#3A3632]">
                    <div id="go-live-timer" class="flex items-center gap-3 md:gap-6">
                        <!-- Days, Hours, Minutes, Seconds boxes (একই রাখা হয়েছে) -->
                        <div class="flex flex-col items-center">
                            <div class="flex items-center text-xl md:text-3xl font-black tabular-nums">
                                <span class="timer-bracket opacity-20">[</span>
                                <span id="go-days">00</span>
                                <span class="timer-bracket opacity-20">]</span>
                            </div>
                            <span class="font-garet text-[8px] md:text-[9px] uppercase tracking-widest font-bold opacity-50 mt-1">DAYS</span>
                        </div>
                        <span class="text-xl md:text-3xl opacity-20 font-light">:</span>

                        <div class="flex flex-col items-center">
                            <div class="flex items-center text-xl md:text-3xl font-black tabular-nums">
                                <span class="timer-bracket opacity-20">[</span>
                                <span id="go-hours">00</span>
                                <span class="timer-bracket opacity-20">]</span>
                            </div>
                            <span class="font-garet text-[8px] md:text-[9px] uppercase tracking-widest font-bold opacity-50 mt-1">HOURS</span>
                        </div>
                        <span class="text-xl md:text-3xl opacity-20 font-light">:</span>

                        <div class="flex flex-col items-center">
                            <div class="flex items-center text-xl md:text-3xl font-black tabular-nums">
                                <span class="timer-bracket opacity-20">[</span>
                                <span id="go-minutes">00</span>
                                <span class="timer-bracket opacity-20">]</span>
                            </div>
                            <span class="font-garet text-[8px] md:text-[9px] uppercase tracking-widest font-bold opacity-50 mt-1">MINUTES</span>
                        </div>
                        <span class="text-xl md:text-3xl opacity-20 font-light">:</span>

                        <div class="flex flex-col items-center">
                            <div class="flex items-center text-xl md:text-3xl font-black tabular-nums">
                                <span class="timer-bracket opacity-20">[</span>
                                <span id="go-seconds">00</span>
                                <span class="timer-bracket opacity-20">]</span>
                            </div>
                            <span class="font-garet text-[8px] md:text-[9px] uppercase tracking-widest font-bold opacity-50 mt-1">SECONDS</span>
                        </div>
                    </div>
                </div>

                <!-- Right: RSVP Button -->
                <div class="w-full md:w-auto flex justify-center">
                    <a href="<?php echo $rsvp_url; ?>" class="bg-[#2D362D] text-[#FDF7F1] px-7 py-3 rounded-full text-xs font-bold uppercase tracking-widest hover:bg-[#3D473D] transition-all duration-300 font-garet">
                        RSVP
                    </a>
                </div>

            </div>
        </div>

        <script>
        jQuery(function($) {
            var $banner     = $('#go-countdown-banner');
            var $closeBtn   = $('#close-go-banner');
            var targetDate  = new Date("<?php echo esc_js($target_date); ?>").getTime();

            // ৩ সেকেন্ড পর banner দেখাও
            setTimeout(function() {
                $banner.removeClass('invisible opacity-0 translate-y-[-20px]')
                       .addClass('opacity-100 translate-y-0');
            }, 3000);

            // Close button
            $closeBtn.on('click', function() {
                $banner.css({
                    'transition': 'all 0.4s ease',
                    'opacity': '0',
                    'transform': 'translateY(-20px)'
                });

                setTimeout(function() {
                    $banner.hide();
                }, 400);
            });

            // Live Countdown
            function updateCountdown() {
                var now = new Date().getTime();
                var distance = targetDate - now;

                if (distance < 0) {
                    $('#go-days, #go-hours, #go-minutes, #go-seconds').text('00');
                    return;
                }

                var days    = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours   = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                $('#go-days').text(String(days).padStart(2, '0'));
                $('#go-hours').text(String(hours).padStart(2, '0'));
                $('#go-minutes').text(String(minutes).padStart(2, '0'));
                $('#go-seconds').text(String(seconds).padStart(2, '0'));
            }

            updateCountdown();
            setInterval(updateCountdown, 1000);
        });
        </script>

        <?php
    }
}