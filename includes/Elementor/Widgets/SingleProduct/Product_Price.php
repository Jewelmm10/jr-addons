<?php
namespace JR_Addons\Elementor\Widgets\SingleProduct;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) exit;

class Product_Price extends Widget_Base {

    public function get_name() {
        return 'jr-product-price';
    }

    public function get_title() {
        return __( 'JR Product Price', 'jr-addons' );
    }

    public function get_icon() {
        return 'jr-get-icon';
    }

    public function get_categories() {
        return [ 'jr-wc' ];
    }

    public function get_keywords() {
        return [ 'price', 'product', 'sale', 'woocommerce', 'currency', 'taka' ];
    }

    /**
     * Register Controls
     */
    protected function register_controls() {

        /* ===========================
         * SECTION: Content Settings
         * =========================== */
        $this->start_controls_section(
            'section_content',
            [
                'label' => __( 'Price Settings', 'jr-addons' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'price_layout',
            [
                'label'   => __( 'Layout', 'jr-addons' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'inline',
                'options' => [
                    'inline'  => __( 'Inline (Side by Side)', 'jr-addons' ),
                    'stacked' => __( 'Stacked (Top to Bottom)', 'jr-addons' ),
                ],
            ]
        );

        $this->add_control(
            'price_order',
            [
                'label'   => __( 'Price Order', 'jr-addons' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'regular_first',
                'options' => [
                    'regular_first' => __( 'Regular Price → Sale Price', 'jr-addons' ),
                    'sale_first'    => __( 'Sale Price → Regular Price', 'jr-addons' ),
                ],
            ]
        );

        $this->add_control(
            'price_alignment',
            [
                'label'   => __( 'Alignment', 'jr-addons' ),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'left'   => [ 'title' => __( 'Left', 'jr-addons' ), 'icon' => 'eicon-text-align-left' ],
                    'center' => [ 'title' => __( 'Center', 'jr-addons' ), 'icon' => 'eicon-text-align-center' ],
                    'right'  => [ 'title' => __( 'Right', 'jr-addons' ), 'icon' => 'eicon-text-align-right' ],
                ],
                'default'   => 'left',
                'selectors' => [
                    '{{WRAPPER}} .jr-price-wrapper' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        /* ===========================
         * SECTION: Currency Settings
         * =========================== */
        $this->start_controls_section(
            'section_currency',
            [
                'label' => __( 'Currency Settings', 'jr-addons' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'override_currency',
            [
                'label'        => __( 'Override Currency Symbol', 'jr-addons' ),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => '',
                'description'  => __( 'WooCommerce default symbol না দেখিয়ে custom symbol use করুন', 'jr-addons' ),
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'custom_currency_symbol',
            [
                'label'       => __( 'Custom Symbol', 'jr-addons' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => '৳',
                'placeholder' => '৳ / Tk / BDT / $',
                'condition'   => [ 'override_currency' => 'yes' ],
            ]
        );

        $this->add_control(
            'currency_position',
            [
                'label'     => __( 'Symbol Position', 'jr-addons' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'before',
                'options'   => [
                    'before'           => __( 'Before — ৳1,500', 'jr-addons' ),
                    'after'            => __( 'After — 1,500৳', 'jr-addons' ),
                    'before_with_space' => __( 'Before with space — ৳ 1,500', 'jr-addons' ),
                    'after_with_space'  => __( 'After with space — 1,500 ৳', 'jr-addons' ),
                ],
                'condition' => [ 'override_currency' => 'yes' ],
            ]
        );

        $this->end_controls_section();

        /* ===========================
         * SECTION: Sale Badge
         * =========================== */
        $this->start_controls_section(
            'section_sale_badge',
            [
                'label' => __( 'Sale Badge', 'jr-addons' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_sale_badge',
            [
                'label'        => __( 'Show Sale Badge', 'jr-addons' ),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => '',
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'sale_badge_type',
            [
                'label'     => __( 'Badge Type', 'jr-addons' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'percentage',
                'options'   => [
                    'percentage' => __( 'Percentage (-20%)', 'jr-addons' ),
                    'amount'     => __( 'Amount Off (-৳500)', 'jr-addons' ),
                    'text'       => __( 'Custom Text (SALE)', 'jr-addons' ),
                ],
                'condition' => [ 'show_sale_badge' => 'yes' ],
            ]
        );

        $this->add_control(
            'sale_badge_text',
            [
                'label'     => __( 'Custom Text', 'jr-addons' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => __( 'SALE', 'jr-addons' ),
                'condition' => [ 'show_sale_badge' => 'yes', 'sale_badge_type' => 'text' ],
            ]
        );

        $this->add_control(
            'sale_badge_prefix',
            [
                'label'     => __( 'Prefix', 'jr-addons' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => '-',
                'condition' => [ 'show_sale_badge' => 'yes', 'sale_badge_type!' => 'text' ],
            ]
        );

        $this->add_control(
            'sale_badge_suffix',
            [
                'label'     => __( 'Suffix', 'jr-addons' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => __( ' OFF', 'jr-addons' ),
                'condition' => [ 'show_sale_badge' => 'yes' ],
            ]
        );

        $this->end_controls_section();

        /* ===========================
         * STYLE TAB
         * =========================== */
        $this->register_style_controls();
    }

    /**
     * Register Style Controls
     */
    protected function register_style_controls() {

        /* ===========================
         * STYLE: Wrapper
         * =========================== */
        $this->start_controls_section(
            'style_wrapper',
            [
                'label' => __( 'Wrapper', 'jr-addons' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'wrapper_gap',
            [
                'label'      => __( 'Gap Between Prices', 'jr-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 10 ],
                'selectors'  => [
                    '{{WRAPPER}} .jr-price-wrapper' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'wrapper_margin',
            [
                'label'      => __( 'Margin', 'jr-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .jr-price-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /* ===========================
         * STYLE: Regular Price (Normal/Default)
         * =========================== */
        $this->start_controls_section(
            'style_regular_price',
            [
                'label' => __( 'Regular Price', 'jr-addons' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'regular_price_color',
            [
                'label'     => __( 'Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#FF8C00',
                'selectors' => [
                    '{{WRAPPER}} .jr-price-regular'             => 'color: {{VALUE}};',
                    '{{WRAPPER}} .jr-price-regular .jr-currency' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'regular_price_typography',
                'selector' => '{{WRAPPER}} .jr-price-regular',
                'fields_options' => [
                    'font_size' => [
                        'default' => [ 'unit' => 'px', 'size' => 22 ],
                    ],
                    'font_weight' => [
                        'default' => '700',
                    ],
                ],
            ]
        );

        $this->add_control(
            'regular_currency_size',
            [
                'label'     => __( 'Currency Symbol Size', 'jr-addons' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', '%' ],
                'range'     => [ 
                    'px' => [ 'min' => 8, 'max' => 60 ],
                    'em' => [ 'min' => 0.5, 'max' => 3, 'step' => 0.1 ],
                    '%'  => [ 'min' => 50, 'max' => 200 ],
                ],
                'default'   => [ 'unit' => '%', 'size' => 100 ],
                'selectors' => [
                    '{{WRAPPER}} .jr-price-regular .jr-currency' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /* ===========================
         * STYLE: Sale Price (Active Price when on Sale)
         * =========================== */
        $this->start_controls_section(
            'style_sale_price',
            [
                'label' => __( 'Sale Price (Active)', 'jr-addons' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'sale_price_color',
            [
                'label'     => __( 'Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#e63946',
                'selectors' => [
                    '{{WRAPPER}} .jr-price-sale'              => 'color: {{VALUE}};',
                    '{{WRAPPER}} .jr-price-sale .jr-currency' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'sale_price_typography',
                'selector' => '{{WRAPPER}} .jr-price-sale',
                'fields_options' => [
                    'font_size' => [
                        'default' => [ 'unit' => 'px', 'size' => 26 ],
                    ],
                    'font_weight' => [
                        'default' => '700',
                    ],
                ],
            ]
        );

        $this->add_control(
            'sale_currency_size',
            [
                'label'     => __( 'Currency Symbol Size', 'jr-addons' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', '%' ],
                'range'     => [ 
                    'px' => [ 'min' => 8, 'max' => 60 ],
                    'em' => [ 'min' => 0.5, 'max' => 3, 'step' => 0.1 ],
                    '%'  => [ 'min' => 50, 'max' => 200 ],
                ],
                'default'   => [ 'unit' => '%', 'size' => 100 ],
                'selectors' => [
                    '{{WRAPPER}} .jr-price-sale .jr-currency' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /* ===========================
         * STYLE: Old/Strikethrough Price
         * =========================== */
        $this->start_controls_section(
            'style_old_price',
            [
                'label' => __( 'Old Price (Strikethrough)', 'jr-addons' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'old_price_color',
            [
                'label'     => __( 'Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#999999',
                'selectors' => [
                    '{{WRAPPER}} .jr-price-old'              => 'color: {{VALUE}};',
                    '{{WRAPPER}} .jr-price-old .jr-currency' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'old_price_typography',
                'selector' => '{{WRAPPER}} .jr-price-old',
                'fields_options' => [
                    'font_size' => [
                        'default' => [ 'unit' => 'px', 'size' => 18 ],
                    ],
                    'font_weight' => [
                        'default' => '400',
                    ],
                ],
            ]
        );

        $this->add_control(
            'old_price_line_style',
            [
                'label'     => __( 'Line Style', 'jr-addons' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'line-through',
                'options'   => [
                    'line-through' => __( 'Line Through', 'jr-addons' ),
                    'underline'    => __( 'Underline', 'jr-addons' ),
                    'none'         => __( 'None', 'jr-addons' ),
                ],
                'selectors' => [
                    '{{WRAPPER}} .jr-price-old' => 'text-decoration: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'old_currency_size',
            [
                'label'     => __( 'Currency Symbol Size', 'jr-addons' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', '%' ],
                'range'     => [ 
                    'px' => [ 'min' => 8, 'max' => 60 ],
                    'em' => [ 'min' => 0.5, 'max' => 3, 'step' => 0.1 ],
                    '%'  => [ 'min' => 50, 'max' => 200 ],
                ],
                'default'   => [ 'unit' => '%', 'size' => 100 ],
                'selectors' => [
                    '{{WRAPPER}} .jr-price-old .jr-currency' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /* ===========================
         * STYLE: Sale Badge
         * =========================== */
        $this->start_controls_section(
            'style_sale_badge',
            [
                'label'     => __( 'Sale Badge Style', 'jr-addons' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [ 'show_sale_badge' => 'yes' ],
            ]
        );

        $this->add_control(
            'badge_bg',
            [
                'label'     => __( 'Background', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#e63946',
                'selectors' => [ '{{WRAPPER}} .jr-price-badge' => 'background-color: {{VALUE}};' ],
            ]
        );

        $this->add_control(
            'badge_color',
            [
                'label'     => __( 'Text Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [ '{{WRAPPER}} .jr-price-badge' => 'color: {{VALUE}};' ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'badge_typography',
                'selector' => '{{WRAPPER}} .jr-price-badge',
            ]
        );

        $this->add_responsive_control(
            'badge_padding',
            [
                'label'      => __( 'Padding', 'jr-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'default'    => [ 'top' => 4, 'right' => 10, 'bottom' => 4, 'left' => 10, 'unit' => 'px' ],
                'selectors'  => [
                    '{{WRAPPER}} .jr-price-badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'badge_radius',
            [
                'label'      => __( 'Border Radius', 'jr-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'default'    => [ 'top' => 4, 'right' => 4, 'bottom' => 4, 'left' => 4, 'unit' => 'px' ],
                'selectors'  => [
                    '{{WRAPPER}} .jr-price-badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Format price with custom currency
     */
    private function jr_format_price( $price, $settings ) {
        if ( $settings['override_currency'] === 'yes' && ! empty( $settings['custom_currency_symbol'] ) ) {
            $symbol   = $settings['custom_currency_symbol'];
            $position = $settings['currency_position'];
            $amount   = number_format( (float) $price, wc_get_price_decimals(), wc_get_price_decimal_separator(), wc_get_price_thousand_separator() );

            $currency_html = '<span class="jr-currency">' . esc_html( $symbol ) . '</span>';
            $amount_html   = '<span class="jr-amount">' . esc_html( $amount ) . '</span>';

            switch ( $position ) {
                case 'after':
                    return $amount_html . $currency_html;
                case 'before_with_space':
                    return $currency_html . '&nbsp;' . $amount_html;
                case 'after_with_space':
                    return $amount_html . '&nbsp;' . $currency_html;
                case 'before':
                default:
                    return $currency_html . $amount_html;
            }
        }

        // WooCommerce default with wrapping currency in span
        $formatted = wc_price( $price );
        // Wrap currency symbol in our class
        $formatted = preg_replace(
            '/<span class="woocommerce-Price-currencySymbol">(.*?)<\/span>/',
            '<span class="jr-currency">$1</span>',
            $formatted
        );
        return $formatted;
    }

    /**
     * Get a preview product for editor mode
     */
    private function jr_get_preview_product() {
        if ( ! function_exists( 'wc_get_products' ) ) return false;
        
        // Try to get a product on sale first
        $sale_products = wc_get_products( [ 'limit' => 1, 'status' => 'publish', 'on_sale' => true ] );
        if ( ! empty( $sale_products ) ) return $sale_products[0];

        $products = wc_get_products( [ 'limit' => 1, 'status' => 'publish' ] );
        return ! empty( $products ) ? $products[0] : false;
    }

    /**
     * Render
     */
    protected function render() {
        $settings = $this->get_settings_for_display();

        global $product;
        $is_edit_mode = \Elementor\Plugin::$instance->editor->is_edit_mode();

        if ( ! $product && function_exists( 'wc_get_product' ) ) {
            $product = wc_get_product( get_the_ID() );
        }

        // Editor preview fallback
        if ( ! $product && $is_edit_mode ) {
            $product = $this->jr_get_preview_product();
        }

        if ( ! $product ) {
            if ( $is_edit_mode ) {
                echo '<div style="padding:20px; background:#fff3cd; border:1px dashed #ffc107; text-align:center;">⚠️ Product পাওয়া যায়নি।</div>';
            }
            return;
        }

        $is_on_sale    = $product->is_on_sale();
        $regular_price = $product->get_regular_price();
        $sale_price    = $product->get_sale_price();
        $current_price = $product->get_price();

        $layout_class = 'jr-price-layout-' . esc_attr( $settings['price_layout'] );
        ?>

        <div class="jr-price-wrapper <?php echo esc_attr( $layout_class ); ?>">

            <?php if ( $is_on_sale && $regular_price && $sale_price ) : ?>

                <?php if ( $settings['price_order'] === 'sale_first' ) : ?>
                    <span class="jr-price jr-price-sale">
                        <?php echo $this->jr_format_price( $sale_price, $settings ); ?>
                    </span>
                    <span class="jr-price jr-price-old">
                        <?php echo $this->jr_format_price( $regular_price, $settings ); ?>
                    </span>
                <?php else : ?>
                    <span class="jr-price jr-price-old">
                        <?php echo $this->jr_format_price( $regular_price, $settings ); ?>
                    </span>
                    <span class="jr-price jr-price-sale">
                        <?php echo $this->jr_format_price( $sale_price, $settings ); ?>
                    </span>
                <?php endif; ?>

                <?php if ( $settings['show_sale_badge'] === 'yes' ) : ?>
                    <span class="jr-price-badge">
                        <?php echo esc_html( $this->jr_get_badge_text( $product, $settings ) ); ?>
                    </span>
                <?php endif; ?>

            <?php else : ?>

                <span class="jr-price jr-price-regular">
                    <?php echo $this->jr_format_price( $current_price, $settings ); ?>
                </span>

            <?php endif; ?>

        </div>
        <?php
    }

    /**
     * Generate sale badge text
     */
    private function jr_get_badge_text( $product, $settings ) {
        $type   = $settings['sale_badge_type'];
        $prefix = $settings['sale_badge_prefix'] ?? '';
        $suffix = $settings['sale_badge_suffix'] ?? '';

        if ( $type === 'text' ) {
            return $settings['sale_badge_text'];
        }

        $regular = (float) $product->get_regular_price();
        $sale    = (float) $product->get_sale_price();

        if ( $regular <= 0 || $sale <= 0 ) return $settings['sale_badge_text'] ?? 'SALE';

        if ( $type === 'percentage' ) {
            $off = round( ( ( $regular - $sale ) / $regular ) * 100 );
            return $prefix . $off . '%' . $suffix;
        }

        if ( $type === 'amount' ) {
            $off    = $regular - $sale;
            $symbol = ( $settings['override_currency'] === 'yes' ) ? $settings['custom_currency_symbol'] : get_woocommerce_currency_symbol();
            return $prefix . $symbol . number_format( $off, 0 ) . $suffix;
        }

        return 'SALE';
    }
}