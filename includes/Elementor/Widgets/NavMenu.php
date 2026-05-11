<?php
namespace JR_Addons\Elementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Icons_Manager;
use Elementor\Plugin as ElementorPlugin;

if ( ! defined( 'ABSPATH' ) ) exit;

class NavMenu extends Widget_Base {

    /**
     * Store Settings for Filter
     */
    private $arrow_settings = [];

    public function get_name(): string {
        return 'jr_nav_menu';
    }

    public function get_title(): string {
        return esc_html__( 'JR Navigation Menu', 'jr-addons' );
    }

    public function get_icon(): string {
        return 'jr-get-icon';
    }

    public function get_categories(): array {
        return [ 'jr-addons' ];
    }

    public function get_keywords(): array {
        return [ 'menu', 'nav', 'navigation', 'header' ];
    }

    /**
     * Get Available Menus
     */
    private function get_available_menus(): array {

        $menus   = wp_get_nav_menus();
        $options = [];

        if ( ! empty( $menus ) ) {
            foreach ( $menus as $menu ) {
                $options[ $menu->slug ] = $menu->name;
            }
        }

        return $options;
    }

    /**
     * Register Controls
     */
    protected function register_controls(): void {

        $this->_register_content_controls();
        $this->_register_menu_style_controls();
        $this->_register_submenu_style_controls();
        $this->_register_arrow_style_controls();
        $this->_register_hamburger_style_controls();
        $this->_register_offcanvas_style_controls();
    }

    /**
     * Content Controls
     */
    private function _register_content_controls(): void {

        $this->start_controls_section( 'content_section', [
            'label' => esc_html__( 'Menu Settings', 'jr-addons' ),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ] );

        $menus = $this->get_available_menus();

        if ( ! empty( $menus ) ) {

            $this->add_control( 'menu', [
                'label'        => esc_html__( 'Select Menu', 'jr-addons' ),
                'type'         => Controls_Manager::SELECT,
                'options'      => $menus,
                'default'      => array_key_first( $menus ),
                'save_default' => true,
            ] );

        } else {

            $this->add_control( 'menu_warning', [
                'type'            => Controls_Manager::RAW_HTML,
                'raw'             => sprintf(
                    '<strong>%s</strong> %s <a href="%s" target="_blank">%s</a>',
                    esc_html__( 'No menus found.', 'jr-addons' ),
                    esc_html__( 'Please go to', 'jr-addons' ),
                    esc_url( admin_url( 'nav-menus.php' ) ),
                    esc_html__( 'Appearance → Menus', 'jr-addons' )
                ),
                'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
            ] );
        }

        $this->add_control( 'layout', [
            'label'   => esc_html__( 'Layout', 'jr-addons' ),
            'type'    => Controls_Manager::SELECT,
            'default' => 'horizontal',
            'options' => [
                'horizontal' => esc_html__( 'Horizontal', 'jr-addons' ),
                'vertical'   => esc_html__( 'Vertical', 'jr-addons' ),
            ],
        ] );

        $this->add_responsive_control( 'menu_align', [
            'label'     => esc_html__( 'Alignment', 'jr-addons' ),
            'type'      => Controls_Manager::CHOOSE,
            'options'   => [
                'flex-start' => [ 'title' => esc_html__( 'Left', 'jr-addons' ),   'icon' => 'eicon-h-align-left' ],
                'center'     => [ 'title' => esc_html__( 'Center', 'jr-addons' ), 'icon' => 'eicon-h-align-center' ],
                'flex-end'   => [ 'title' => esc_html__( 'Right', 'jr-addons' ),  'icon' => 'eicon-h-align-right' ],
            ],
            'default'   => 'flex-start',
            'selectors' => [
                '{{WRAPPER}} .jr-nav-wrapper' => 'justify-content: {{VALUE}};',
            ],
            'condition' => [ 'layout' => 'horizontal' ],
        ] );

        $this->end_controls_section();
    }

    /**
     * Menu Style Controls
     */
    private function _register_menu_style_controls(): void {

        $this->start_controls_section( 'menu_style', [
            'label' => esc_html__( 'Menu Items', 'jr-addons' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'menu_typography',
            'selector' => '{{WRAPPER}} .jr-menu > li > a',
        ] );

        $this->add_responsive_control( 'menu_item_spacing', [
            'label'      => esc_html__( 'Item Horizontal Padding', 'jr-addons' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
            'selectors'  => [
                '{{WRAPPER}} .jr-menu > li > a' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}};',
            ],
        ] );

        $this->add_responsive_control( 'menu_item_padding_y', [
            'label'      => esc_html__( 'Item Vertical Padding', 'jr-addons' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
            'selectors'  => [
                '{{WRAPPER}} .jr-menu > li > a' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}};',
            ],
        ] );

        $this->start_controls_tabs( 'menu_tabs' );

        // Normal
        $this->start_controls_tab( 'menu_normal_tab', [ 'label' => esc_html__( 'Normal', 'jr-addons' ) ] );

        $this->add_control( 'menu_color', [
            'label'     => esc_html__( 'Text Color', 'jr-addons' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .jr-menu > li > a' => 'color: {{VALUE}};',
            ],
        ] );

        $this->add_control( 'menu_bg', [
            'label'     => esc_html__( 'Background', 'jr-addons' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .jr-menu > li > a' => 'background-color: {{VALUE}};',
            ],
        ] );

        $this->end_controls_tab();

        // Hover
        $this->start_controls_tab( 'menu_hover_tab', [ 'label' => esc_html__( 'Hover', 'jr-addons' ) ] );

        $this->add_control( 'menu_hover_color', [
            'label'     => esc_html__( 'Text Color', 'jr-addons' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .jr-menu > li > a:hover' => 'color: {{VALUE}};',
            ],
        ] );

        $this->add_control( 'menu_hover_bg', [
            'label'     => esc_html__( 'Background', 'jr-addons' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .jr-menu > li > a:hover' => 'background-color: {{VALUE}};',
            ],
        ] );

        $this->end_controls_tab();

        // Active
        $this->start_controls_tab( 'menu_active_tab', [ 'label' => esc_html__( 'Active', 'jr-addons' ) ] );

        $this->add_control( 'menu_active_color', [
            'label'     => esc_html__( 'Text Color', 'jr-addons' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .jr-menu > li.current-menu-item > a, 
                 {{WRAPPER}} .jr-menu > li.current-menu-ancestor > a' => 'color: {{VALUE}};',
            ],
        ] );

        $this->add_control( 'menu_active_bg', [
            'label'     => esc_html__( 'Background', 'jr-addons' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .jr-menu > li.current-menu-item > a,
                 {{WRAPPER}} .jr-menu > li.current-menu-ancestor > a' => 'background-color: {{VALUE}};',
            ],
        ] );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    /**
     * Submenu Style Controls
     */
    private function _register_submenu_style_controls(): void {

        $this->start_controls_section( 'submenu_style', [
            'label' => esc_html__( 'Submenu', 'jr-addons' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'submenu_typography',
            'selector' => '{{WRAPPER}} .jr-menu ul a',
        ] );

        $this->add_responsive_control( 'submenu_width', [
            'label'      => esc_html__( 'Submenu Width', 'jr-addons' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 150, 'max' => 400 ] ],
            'default'    => [ 'size' => 220, 'unit' => 'px' ],
            'selectors'  => [
                '{{WRAPPER}} .jr-menu ul' => 'min-width: {{SIZE}}{{UNIT}};',
            ],
        ] );

        $this->add_responsive_control( 'submenu_padding', [
            'label'      => esc_html__( 'Item Padding', 'jr-addons' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em' ],
            'selectors'  => [
                '{{WRAPPER}} .jr-menu ul a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ] );

        $this->add_control( 'submenu_bg', [
            'label'     => esc_html__( 'Background', 'jr-addons' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => [
                '{{WRAPPER}} .jr-menu ul' => 'background-color: {{VALUE}};',
            ],
        ] );

        $this->start_controls_tabs( 'submenu_tabs' );

        $this->start_controls_tab( 'submenu_normal_tab', [ 'label' => esc_html__( 'Normal', 'jr-addons' ) ] );

        $this->add_control( 'submenu_color', [
            'label'     => esc_html__( 'Text Color', 'jr-addons' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .jr-menu ul a' => 'color: {{VALUE}};',
            ],
        ] );

        $this->end_controls_tab();

        $this->start_controls_tab( 'submenu_hover_tab', [ 'label' => esc_html__( 'Hover', 'jr-addons' ) ] );

        $this->add_control( 'submenu_hover_color', [
            'label'     => esc_html__( 'Text Color', 'jr-addons' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .jr-menu ul a:hover' => 'color: {{VALUE}};',
            ],
        ] );

        $this->add_control( 'submenu_hover_bg', [
            'label'     => esc_html__( 'Background', 'jr-addons' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .jr-menu ul a:hover' => 'background-color: {{VALUE}};',
            ],
        ] );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control( Group_Control_Border::get_type(), [
            'name'     => 'submenu_border',
            'selector' => '{{WRAPPER}} .jr-menu ul',
        ] );

        $this->end_controls_section();
    }

    /**
     * Arrow Style Controls
     */
    private function _register_arrow_style_controls(): void {

        $this->start_controls_section( 'arrow_style', [
            'label' => esc_html__( 'Submenu Arrow', 'jr-addons' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'show_arrow', [
            'label'        => esc_html__( 'Show Arrow', 'jr-addons' ),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => esc_html__( 'Yes', 'jr-addons' ),
            'label_off'    => esc_html__( 'No', 'jr-addons' ),
            'return_value' => 'yes',
            'default'      => 'yes',
        ] );

        $this->add_control( 'arrow_icon', [
            'label'     => esc_html__( 'Arrow Icon (Top Level)', 'jr-addons' ),
            'type'      => Controls_Manager::ICONS,
            'default'   => [
                'value'   => 'fas fa-chevron-down',
                'library' => 'fa-solid',
            ],
            'condition' => [ 'show_arrow' => 'yes' ],
        ] );

        $this->add_control( 'submenu_arrow_icon', [
            'label'     => esc_html__( 'Arrow Icon (Nested)', 'jr-addons' ),
            'type'      => Controls_Manager::ICONS,
            'default'   => [
                'value'   => 'fas fa-chevron-right',
                'library' => 'fa-solid',
            ],
            'condition' => [ 'show_arrow' => 'yes' ],
        ] );

        $this->add_responsive_control( 'arrow_size', [
            'label'      => esc_html__( 'Arrow Size', 'jr-addons' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 8, 'max' => 30 ] ],
            'default'    => [ 'size' => 12, 'unit' => 'px' ],
            'selectors'  => [
                '{{WRAPPER}} .jr-arrow' => 'font-size: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .jr-arrow svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
            ],
            'condition'  => [ 'show_arrow' => 'yes' ],
        ] );

        $this->add_responsive_control( 'arrow_spacing', [
            'label'      => esc_html__( 'Arrow Spacing', 'jr-addons' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 0, 'max' => 30 ] ],
            'default'    => [ 'size' => 6, 'unit' => 'px' ],
            'selectors'  => [
                '{{WRAPPER}} .jr-arrow' => 'margin-left: {{SIZE}}{{UNIT}};',
            ],
            'condition'  => [ 'show_arrow' => 'yes' ],
        ] );

        $this->add_control( 'arrow_color', [
            'label'     => esc_html__( 'Arrow Color', 'jr-addons' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .jr-arrow' => 'color: {{VALUE}};',
                '{{WRAPPER}} .jr-arrow svg' => 'fill: {{VALUE}};',
            ],
            'condition' => [ 'show_arrow' => 'yes' ],
        ] );

        $this->add_control( 'arrow_hover_color', [
            'label'     => esc_html__( 'Arrow Hover Color', 'jr-addons' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .jr-menu li:hover > a .jr-arrow,
                 {{WRAPPER}} .jr-mobile-menu li.menu-open > a .jr-arrow' => 'color: {{VALUE}};',
                '{{WRAPPER}} .jr-menu li:hover > a .jr-arrow svg,
                 {{WRAPPER}} .jr-mobile-menu li.menu-open > a .jr-arrow svg' => 'fill: {{VALUE}};',
            ],
            'condition' => [ 'show_arrow' => 'yes' ],
        ] );

        $this->end_controls_section();
    }

    /**
     * Hamburger Style Controls
     */
    private function _register_hamburger_style_controls(): void {

        $this->start_controls_section( 'hamburger_style', [
            'label'     => esc_html__( 'Hamburger Icon', 'jr-addons' ),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => [ 'layout' => 'horizontal' ],
        ] );

        $this->add_control( 'hamburger_color', [
            'label'     => esc_html__( 'Bar Color', 'jr-addons' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#333333',
            'selectors' => [
                '{{WRAPPER}} .jr-hamburger span' => 'background-color: {{VALUE}};',
            ],
        ] );

        $this->add_responsive_control( 'hamburger_size', [
            'label'      => esc_html__( 'Icon Size', 'jr-addons' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 20, 'max' => 60 ] ],
            'default'    => [ 'size' => 40, 'unit' => 'px' ],
            'selectors'  => [
                '{{WRAPPER}} .jr-hamburger' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
            ],
        ] );

        $this->end_controls_section();
    }

    /**
     * Offcanvas Style Controls
     */
    private function _register_offcanvas_style_controls(): void {

        $this->start_controls_section( 'offcanvas_style', [
            'label'     => esc_html__( 'Offcanvas (Mobile)', 'jr-addons' ),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => [ 'layout' => 'horizontal' ],
        ] );

        $this->add_control( 'offcanvas_bg', [
            'label'     => esc_html__( 'Background', 'jr-addons' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => [
                '{{WRAPPER}} .jr-offcanvas' => 'background-color: {{VALUE}};',
            ],
        ] );

        $this->add_responsive_control( 'offcanvas_width', [
            'label'      => esc_html__( 'Offcanvas Width', 'jr-addons' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', '%' ],
            'range'      => [
                'px' => [ 'min' => 200, 'max' => 600 ],
                '%'  => [ 'min' => 50,  'max' => 100 ],
            ],
            'default'    => [ 'size' => 300, 'unit' => 'px' ],
            'selectors'  => [
                '{{WRAPPER}} .jr-offcanvas' => 'width: {{SIZE}}{{UNIT}};',
            ],
        ] );

        $this->add_control( 'mobile_menu_color', [
            'label'     => esc_html__( 'Menu Text Color', 'jr-addons' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .jr-mobile-menu a' => 'color: {{VALUE}};',
            ],
        ] );

        $this->add_control( 'close_color', [
            'label'     => esc_html__( 'Close Icon Color', 'jr-addons' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#333333',
            'selectors' => [
                '{{WRAPPER}} .jr-close' => 'color: {{VALUE}};',
            ],
        ] );

        $this->end_controls_section();
    }

    /**
     * Get Arrow HTML
     */
    private function get_arrow_html( string $type = 'main' ): string {

        if ( ( $this->arrow_settings['show_arrow'] ?? 'yes' ) !== 'yes' ) {
            return '';
        }

        $icon_key = ( $type === 'sub' ) ? 'submenu_arrow_icon' : 'arrow_icon';
        $icon     = $this->arrow_settings[ $icon_key ] ?? [];

        if ( empty( $icon['value'] ) ) {
            return '';
        }

        ob_start();
        ?>
        <span class="jr-arrow" aria-hidden="true">
            <?php Icons_Manager::render_icon( $icon, [ 'aria-hidden' => 'true' ] ); ?>
        </span>
        <?php
        return ob_get_clean();
    }

    /**
     * Inject Arrow into Menu Items
     */
    public function add_arrow_to_menu( $item_output, $item, $depth, $args ) {

        if ( ! isset( $args->menu_class ) || strpos( $args->menu_class, 'jr-' ) === false ) {
            return $item_output;
        }

        if ( ! in_array( 'menu-item-has-children', (array) $item->classes, true ) ) {
            return $item_output;
        }

        $type  = ( $depth > 0 ) ? 'sub' : 'main';
        $arrow = $this->get_arrow_html( $type );

        if ( empty( $arrow ) ) {
            return $item_output;
        }

        $item_output = preg_replace( '/(<\/a>)/', $arrow . '$1', $item_output, 1 );

        return $item_output;
    }

    /**
     * Render Widget Output
     */
    protected function render(): void {

        $settings = $this->get_settings_for_display();
        $layout   = $settings['layout'] ?? 'horizontal';
        $menu     = $settings['menu'] ?? '';

        if ( empty( $menu ) ) {
            if ( ElementorPlugin::$instance->editor->is_edit_mode() ) {
                echo '<p style="text-align:center; padding:20px; background:#f5f5f5;">' 
                    . esc_html__( 'Please select a menu from settings.', 'jr-addons' ) 
                    . '</p>';
            }
            return;
        }

        $this->arrow_settings = $settings;

        add_filter( 'walker_nav_menu_start_el', [ $this, 'add_arrow_to_menu' ], 10, 4 );
        ?>

        <div class="jr-nav-wrapper jr-layout-<?php echo esc_attr( $layout ); ?>">

            <?php if ( $layout === 'horizontal' ) : ?>
                <button class="jr-hamburger" aria-label="<?php esc_attr_e( 'Open Menu', 'jr-addons' ); ?>">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            <?php endif; ?>

            <nav class="jr-desktop-menu" aria-label="<?php esc_attr_e( 'Main Menu', 'jr-addons' ); ?>">
                <?php
                wp_nav_menu( [
                    'menu'        => $menu,
                    'container'   => false,
                    'menu_class'  => 'jr-menu',
                    'fallback_cb' => false,
                    'depth'       => 3,
                ] );
                ?>
            </nav>

            <?php if ( $layout === 'horizontal' ) : ?>

                <div class="jr-overlay"></div>

                <div class="jr-offcanvas" aria-hidden="true">
                    <div class="jr-offcanvas-inner">

                        <button class="jr-close" aria-label="<?php esc_attr_e( 'Close Menu', 'jr-addons' ); ?>">✕</button>

                        <nav aria-label="<?php esc_attr_e( 'Mobile Menu', 'jr-addons' ); ?>">
                            <?php
                            wp_nav_menu( [
                                'menu'        => $menu,
                                'container'   => false,
                                'menu_class'  => 'jr-mobile-menu',
                                'fallback_cb' => false,
                                'depth'       => 3,
                            ] );
                            ?>
                        </nav>

                    </div>
                </div>

            <?php endif; ?>

        </div>

        <?php
        remove_filter( 'walker_nav_menu_start_el', [ $this, 'add_arrow_to_menu' ], 10 );
    }
}