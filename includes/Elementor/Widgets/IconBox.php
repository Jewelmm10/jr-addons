<?php
namespace JR_Addons\Elementor\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Icons_Manager;

class IconBox extends Widget_Base {

	public function get_name() {
		return 'jr_iconbox';
	}

	public function get_title() {
		return esc_html__( 'JR IconBox', 'jr-addons' );
	}

	public function get_icon() {
        return 'jr-get-icon';
    }

	public function get_categories() {
		return [ 'jr-addons' ];
	}

	public function get_keywords() {
		return [ 'icon box', 'icon', 'jr' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'iconbox_list_section',
			[
				'label' => esc_html__( 'Icon Box List', 'jr-addons' ),
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'selected_icon',
			[
				'label' => esc_html__( 'Icon', 'jr-addons' ),
				'type'  => Controls_Manager::ICONS,
				'default' => [
					'value'   => 'fas fa-star',
					'library' => 'fa-solid',
				],
			]
		);

		$repeater->add_control(
			'title_text',
			[
				'label'       => esc_html__( 'Title', 'jr-addons' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'default'     => esc_html__( 'This is the heading', 'jr-addons' ),
				'label_block' => true,
			]
		);

		// $repeater->add_control(
		// 	'subtitle_text',
		// 	[
		// 		'label'       => esc_html__( 'SubTitle', 'jr-addons' ),
		// 		'type'        => Controls_Manager::TEXT,
		// 		'dynamic'     => [ 'active' => true ],
		// 		'default'     => esc_html__( 'Step Subtitle', 'jr-addons' ),
		// 		'label_block' => true,
		// 	]
		// );

		$repeater->add_control(
			'description_text',
			[
				'label'   => esc_html__( 'Description', 'jr-addons' ),
				'type'    => Controls_Manager::TEXTAREA,
				'dynamic' => [ 'active' => true ],
				'default' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'jr-addons' ),
				'rows'    => 5,
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

		$this->add_control(
			'iconbox_lists',
			[
				'label'       => esc_html__( 'Items', 'jr-addons' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[ 'title_text' => 'Partial Hospitalization Program' ],
					[ 'title_text' => 'Intensive Outpatient Program' ],
					[ 'title_text' => 'Neurofeedback and Biofeedback' ],
				],
				'title_field' => '{{{ title_text }}}',
			]
		);

		$this->end_controls_section();

		// Grid Layout Section
		$this->start_controls_section(
			'section_layout_grid',
			[
				'label' => esc_html__( 'Grid Layout', 'jr-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label'          => esc_html__( 'Columns', 'jr-addons' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => '3',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'options'        => [
					'1' => '1 Column',
					'2' => '2 Columns',
					'3' => '3 Columns',
					'4' => '4 Columns',
					'5' => '5 Columns',
					'6' => '6 Columns',
				],
				'selectors' => [
					'{{WRAPPER}} .jr-iconbox-grid' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));',
				],
			]
		);

		$this->add_responsive_control(
			'grid_gap',
			[
				'label'      => esc_html__( 'Gap', 'jr-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem' ],
				'range'      => [
					'px' => [ 'min' => 0, 'max' => 100 ],
				],
				'selectors'  => [
					'{{WRAPPER}} .jr-iconbox-grid' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( empty( $settings['iconbox_lists'] ) ) {
			return;
		}

		$columns_desktop = ! empty( $settings['columns'] ) ? $settings['columns'] : '3';
		$columns_tablet  = ! empty( $settings['columns_tablet'] ) ? $settings['columns_tablet'] : $columns_desktop;
		$columns_mobile  = ! empty( $settings['columns_mobile'] ) ? $settings['columns_mobile'] : '1';

		$grid_classes = "grid grid-cols-{$columns_mobile} md:grid-cols-{$columns_tablet} lg:grid-cols-{$columns_desktop}";
		?>

		<div class="jr-iconbox-grid <?php echo esc_attr( $grid_classes ); ?> items-stretch">
			<?php foreach ( $settings['iconbox_lists'] as $index => $item ) : 
				$link_key = 'link_' . $index;
				if ( ! empty( $item['link']['url'] ) ) {
					$this->add_link_attributes( $link_key, $item['link'] );
					$this->add_render_attribute( $link_key, 'class', 'mt-6 font-bold text-[#8B837C] hover:text-black transition-all inline-block' );
				}
			?>

				<div class="floating-card p-8 lg:p-12 bg-white rounded-[3.5rem] border border-black/5 flex flex-col items-center text-center">
					
					<div class="w-20 h-20 rounded-full text-3xl bg-[#FDF7F1] text-[#8b837c] flex items-center justify-center mb-8">
						<?php 
						if ( ! empty( $item['selected_icon']['value'] ) ) {
							Icons_Manager::render_icon( $item['selected_icon'], [ 'aria-hidden' => 'true', 'style' => 'font-size: 30px; color: #8b837c;' ] );
						} 
						?>
					</div>

					<span class="font-garet text-[10px] font-bold uppercase tracking-[0.4em] text-[#8B837C] mb-4">
						Step <?php echo str_pad( $index + 1, 2, '0', STR_PAD_LEFT ); ?>
					</span>

					<h3 class="text-xl font-black tracking-tight mb-4">
						<?php echo esc_html( $item['title_text'] ); ?>
					</h3>

					<p class="text-base font-light opacity-70 leading-relaxed">
						<?php echo wp_kses_post( $item['description_text'] ); ?>
					</p>

					<?php if ( ! empty( $item['link']['url'] ) ) : ?>
						<a <?php echo $this->get_render_attribute_string( $link_key ); ?>>
							Learn More <i class="fas fa-arrow-right ml-2 text-xs"></i>
						</a>
					<?php endif; ?>

				</div>

			<?php endforeach; ?>
		</div>

		<?php
	}
}