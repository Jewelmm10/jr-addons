<?php
namespace JR_Addons\Elementor\Widgets\SingleProduct;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) exit;

class Product_Reviews extends Widget_Base {

    public function get_name() {
        return 'jr-product-reviews';
    }

    public function get_title() {
        return __( 'Product Reviews', 'jr-addons' );
    }

    public function get_icon() {
        return 'jr-get-icon';
    }

    public function get_categories() {
        return [ 'jr-wc' ];
    }

    public function get_keywords() {
        return [ 'review', 'rating', 'star', 'product', 'woocommerce', 'feedback' ];
    }

    public function get_script_depends() {
        return [ 'jr-product-reviews' ];
    }

    public function get_style_depends() {
        return [ 'jr-product-reviews' ];
    }

    /**
     * Register Controls
     */
    protected function register_controls() {

        /* ===========================
         * SECTION: Layout
         * =========================== */
        $this->start_controls_section(
            'section_layout',
            [
                'label' => __( 'Layout', 'jr-addons' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'layout_type',
            [
                'label'   => __( 'Layout', 'jr-addons' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'two-column',
                'options' => [
                    'two-column' => __( '2 Column (Summary + Form)', 'jr-addons' ),
                    'stacked'    => __( 'Stacked (Top Summary, Bottom Form)', 'jr-addons' ),
                ],
            ]
        );

        $this->add_control(
            'show_summary',
            [
                'label'        => __( 'Show Summary Section', 'jr-addons' ),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => 'yes',
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'show_form',
            [
                'label'        => __( 'Show Submit Form', 'jr-addons' ),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => 'yes',
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'show_reviews_list',
            [
                'label'        => __( 'Show Reviews List', 'jr-addons' ),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => '',
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'reviews_per_page',
            [
                'label'     => __( 'Reviews Per Page', 'jr-addons' ),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 5,
                'min'       => 1,
                'max'       => 50,
                'condition' => [ 'show_reviews_list' => 'yes' ],
            ]
        );

        $this->end_controls_section();

        /* ===========================
         * SECTION: Summary Settings
         * =========================== */
        $this->start_controls_section(
            'section_summary',
            [
                'label'     => __( 'Summary Section', 'jr-addons' ),
                'condition' => [ 'show_summary' => 'yes' ],
            ]
        );

        $this->add_control(
            'avg_rating_label',
            [
                'label'   => __( 'Average Rating Label', 'jr-addons' ),
                'type'    => Controls_Manager::TEXT,
                'default' => __( 'Average Rating', 'jr-addons' ),
            ]
        );

        $this->add_control(
            'reviews_text',
            [
                'label'   => __( 'Reviews Text', 'jr-addons' ),
                'type'    => Controls_Manager::TEXT,
                'default' => __( 'Reviews', 'jr-addons' ),
            ]
        );

        $this->add_control(
            'recommended_label',
            [
                'label'   => __( 'Recommended Label', 'jr-addons' ),
                'type'    => Controls_Manager::TEXT,
                'default' => __( 'Recommended', 'jr-addons' ),
            ]
        );

        $this->add_control(
            'show_breakdown',
            [
                'label'        => __( 'Show Star Breakdown Bars', 'jr-addons' ),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => 'yes',
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'show_recommendation',
            [
                'label'        => __( 'Show Recommendation %', 'jr-addons' ),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => 'yes',
                'return_value' => 'yes',
            ]
        );

        $this->end_controls_section();

        /* ===========================
         * SECTION: Form Settings
         * =========================== */
        $this->start_controls_section(
            'section_form',
            [
                'label'     => __( 'Submit Form', 'jr-addons' ),
                'condition' => [ 'show_form' => 'yes' ],
            ]
        );

        $this->add_control(
            'form_title',
            [
                'label'   => __( 'Form Title', 'jr-addons' ),
                'type'    => Controls_Manager::TEXT,
                'default' => __( 'Submit Your Review', 'jr-addons' ),
            ]
        );

        $this->add_control(
            'form_subtitle',
            [
                'label'   => __( 'Form Subtitle', 'jr-addons' ),
                'type'    => Controls_Manager::TEXTAREA,
                'rows'    => 2,
                'default' => __( 'Your email address will not be published. Required fields are marked *', 'jr-addons' ),
            ]
        );

        $this->add_control(
            'review_label',
            [
                'label'   => __( 'Review Field Label', 'jr-addons' ),
                'type'    => Controls_Manager::TEXT,
                'default' => __( 'Write your opinion about the product', 'jr-addons' ),
            ]
        );

        $this->add_control(
            'review_placeholder',
            [
                'label'   => __( 'Review Placeholder', 'jr-addons' ),
                'type'    => Controls_Manager::TEXT,
                'default' => __( 'Write Your Review Here...', 'jr-addons' ),
            ]
        );

        $this->add_control(
            'rating_label',
            [
                'label'   => __( 'Rating Label', 'jr-addons' ),
                'type'    => Controls_Manager::TEXT,
                'default' => __( 'Your Rating:', 'jr-addons' ),
            ]
        );

        $this->add_control(
            'rating_input_type',
            [
                'label'   => __( 'Rating Input Type', 'jr-addons' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'stars',
                'options' => [
                    'stars'  => __( 'Interactive Stars', 'jr-addons' ),
                    'select' => __( 'Dropdown Select', 'jr-addons' ),
                ],
            ]
        );

        $this->add_control(
            'show_recommend_field',
            [
                'label'        => __( 'Show "Recommend?" Field', 'jr-addons' ),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => 'yes',
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'show_name_email',
            [
                'label'        => __( 'Show Name & Email Fields', 'jr-addons' ),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => 'yes',
                'return_value' => 'yes',
                'description'  => __( 'For non-logged in users only', 'jr-addons' ),
            ]
        );

        $this->add_control(
            'submit_button_text',
            [
                'label'   => __( 'Submit Button Text', 'jr-addons' ),
                'type'    => Controls_Manager::TEXT,
                'default' => __( 'SUBMIT REVIEW', 'jr-addons' ),
            ]
        );

        $this->add_control(
            'login_required_text',
            [
                'label'   => __( 'Login Required Message', 'jr-addons' ),
                'type'    => Controls_Manager::TEXTAREA,
                'default' => __( 'You must be logged in to post a review.', 'jr-addons' ),
            ]
        );

        $this->end_controls_section();

        /* ===== STYLE TABS ===== */
        $this->register_style_controls();
    }

    /**
     * Register Style Controls
     */
    protected function register_style_controls() {

        /* ===== Wrapper ===== */
        $this->start_controls_section(
            'style_wrapper',
            [
                'label' => __( 'Wrapper', 'jr-addons' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'wrapper_bg',
            [
                'label'     => __( 'Background', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [ '{{WRAPPER}} .jr-reviews-wrapper' => 'background-color: {{VALUE}};' ],
            ]
        );

        $this->add_responsive_control(
            'wrapper_padding',
            [
                'label'      => __( 'Padding', 'jr-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'default'    => [ 'top' => 30, 'right' => 30, 'bottom' => 30, 'left' => 30, 'unit' => 'px' ],
                'selectors'  => [
                    '{{WRAPPER}} .jr-reviews-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'wrapper_radius',
            [
                'label'      => __( 'Border Radius', 'jr-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'default'    => [ 'top' => 8, 'right' => 8, 'bottom' => 8, 'left' => 8, 'unit' => 'px' ],
                'selectors'  => [
                    '{{WRAPPER}} .jr-reviews-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'wrapper_border',
                'selector' => '{{WRAPPER}} .jr-reviews-wrapper',
            ]
        );

        $this->end_controls_section();

        /* ===== Average Rating Number ===== */
        $this->start_controls_section(
            'style_avg_rating',
            [
                'label' => __( 'Average Rating Number', 'jr-addons' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'avg_number_color',
            [
                'label'     => __( 'Number Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#1a1a1a',
                'selectors' => [ '{{WRAPPER}} .jr-avg-number' => 'color: {{VALUE}};' ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'avg_number_typography',
                'selector' => '{{WRAPPER}} .jr-avg-number',
                'fields_options' => [
                    'font_size'   => [ 'default' => [ 'unit' => 'px', 'size' => 48 ] ],
                    'font_weight' => [ 'default' => '700' ],
                ],
            ]
        );

        $this->add_control(
            'recommend_percent_color',
            [
                'label'     => __( 'Recommended % Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#1a1a1a',
                'selectors' => [ '{{WRAPPER}} .jr-recommend-percent' => 'color: {{VALUE}};' ],
            ]
        );

        $this->add_control(
            'label_color',
            [
                'label'     => __( 'Label Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .jr-avg-label, {{WRAPPER}} .jr-recommend-label' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'reviews_count_color',
            [
                'label'     => __( 'Reviews Count Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#888888',
                'selectors' => [ '{{WRAPPER}} .jr-reviews-count' => 'color: {{VALUE}};' ],
            ]
        );

        $this->end_controls_section();

        /* ===== Stars ===== */
        $this->start_controls_section(
            'style_stars',
            [
                'label' => __( 'Stars Color', 'jr-addons' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'star_active_color',
            [
                'label'     => __( 'Active Star Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#FF8C00',
                'selectors' => [
                    '{{WRAPPER}} .jr-star.is-active'           => 'color: {{VALUE}};',
                    '{{WRAPPER}} .jr-rating-input .jr-star.is-active' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'star_inactive_color',
            [
                'label'     => __( 'Inactive Star Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#dddddd',
                'selectors' => [
                    '{{WRAPPER}} .jr-star' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'star_size',
            [
                'label'     => __( 'Stars Size', 'jr-addons' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [ 'px' => [ 'min' => 10, 'max' => 50 ] ],
                'default'   => [ 'unit' => 'px', 'size' => 16 ],
                'selectors' => [
                    '{{WRAPPER}} .jr-stars' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /* ===== Breakdown Bars ===== */
        $this->start_controls_section(
            'style_bars',
            [
                'label'     => __( 'Breakdown Bars', 'jr-addons' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [ 'show_breakdown' => 'yes' ],
            ]
        );

        $this->add_control(
            'bar_bg',
            [
                'label'     => __( 'Bar Background', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#eeeeee',
                'selectors' => [ '{{WRAPPER}} .jr-bar' => 'background-color: {{VALUE}};' ],
            ]
        );

        $this->add_control(
            'bar_fill',
            [
                'label'     => __( 'Bar Fill Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#FF8C00',
                'selectors' => [ '{{WRAPPER}} .jr-bar-fill' => 'background-color: {{VALUE}};' ],
            ]
        );

        $this->add_control(
            'bar_height',
            [
                'label'     => __( 'Bar Height', 'jr-addons' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [ 'px' => [ 'min' => 4, 'max' => 30 ] ],
                'default'   => [ 'unit' => 'px', 'size' => 8 ],
                'selectors' => [
                    '{{WRAPPER}} .jr-bar' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'bar_percent_color',
            [
                'label'     => __( 'Percent Text Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#888888',
                'selectors' => [ '{{WRAPPER}} .jr-bar-percent' => 'color: {{VALUE}};' ],
            ]
        );

        $this->end_controls_section();

        /* ===== Form Title ===== */
        $this->start_controls_section(
            'style_form_title',
            [
                'label'     => __( 'Form Title', 'jr-addons' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [ 'show_form' => 'yes' ],
            ]
        );

        $this->add_control(
            'form_title_color',
            [
                'label'     => __( 'Title Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#1a1a1a',
                'selectors' => [ '{{WRAPPER}} .jr-form-title' => 'color: {{VALUE}};' ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'form_title_typography',
                'selector' => '{{WRAPPER}} .jr-form-title',
                'fields_options' => [
                    'font_size'   => [ 'default' => [ 'unit' => 'px', 'size' => 18 ] ],
                    'font_weight' => [ 'default' => '700' ],
                ],
            ]
        );

        $this->add_control(
            'form_title_underline_color',
            [
                'label'     => __( 'Underline Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#FF8C00',
                'selectors' => [ '{{WRAPPER}} .jr-form-title::after' => 'background-color: {{VALUE}};' ],
            ]
        );

        $this->add_control(
            'form_subtitle_color',
            [
                'label'     => __( 'Subtitle Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#666666',
                'selectors' => [ '{{WRAPPER}} .jr-form-subtitle' => 'color: {{VALUE}};' ],
            ]
        );

        $this->end_controls_section();

        /* ===== Form Inputs ===== */
        $this->start_controls_section(
            'style_form_inputs',
            [
                'label'     => __( 'Form Inputs', 'jr-addons' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [ 'show_form' => 'yes' ],
            ]
        );

        $this->add_control(
            'input_label_color',
            [
                'label'     => __( 'Label Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#333333',
                'selectors' => [ '{{WRAPPER}} .jr-form-field label' => 'color: {{VALUE}};' ],
            ]
        );

        $this->add_control(
            'input_bg',
            [
                'label'     => __( 'Input Background', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .jr-form-field input[type="text"], {{WRAPPER}} .jr-form-field input[type="email"], {{WRAPPER}} .jr-form-field textarea, {{WRAPPER}} .jr-form-field select' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'input_text_color',
            [
                'label'     => __( 'Input Text Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#1a1a1a',
                'selectors' => [
                    '{{WRAPPER}} .jr-form-field input, {{WRAPPER}} .jr-form-field textarea, {{WRAPPER}} .jr-form-field select' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'input_border_color',
            [
                'label'     => __( 'Input Border Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#dddddd',
                'selectors' => [
                    '{{WRAPPER}} .jr-form-field input, {{WRAPPER}} .jr-form-field textarea, {{WRAPPER}} .jr-form-field select' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        /* ===== Submit Button ===== */
        $this->start_controls_section(
            'style_submit',
            [
                'label'     => __( 'Submit Button', 'jr-addons' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [ 'show_form' => 'yes' ],
            ]
        );

        $this->start_controls_tabs( 'submit_tabs' );

        $this->start_controls_tab( 'submit_normal', [ 'label' => __( 'Normal', 'jr-addons' ) ] );

        $this->add_control(
            'submit_bg',
            [
                'label'     => __( 'Background', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#2c3e50',
                'selectors' => [ '{{WRAPPER}} .jr-submit-btn' => 'background-color: {{VALUE}};' ],
            ]
        );

        $this->add_control(
            'submit_color',
            [
                'label'     => __( 'Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [ '{{WRAPPER}} .jr-submit-btn' => 'color: {{VALUE}};' ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab( 'submit_hover', [ 'label' => __( 'Hover', 'jr-addons' ) ] );

        $this->add_control(
            'submit_bg_hover',
            [
                'label'     => __( 'Background', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#FF8C00',
                'selectors' => [ '{{WRAPPER}} .jr-submit-btn:hover' => 'background-color: {{VALUE}};' ],
            ]
        );

        $this->add_control(
            'submit_color_hover',
            [
                'label'     => __( 'Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [ '{{WRAPPER}} .jr-submit-btn:hover' => 'color: {{VALUE}};' ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'submit_typography',
                'selector' => '{{WRAPPER}} .jr-submit-btn',
            ]
        );

        $this->add_responsive_control(
            'submit_padding',
            [
                'label'      => __( 'Padding', 'jr-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'default'    => [ 'top' => 14, 'right' => 30, 'bottom' => 14, 'left' => 30, 'unit' => 'px' ],
                'selectors'  => [
                    '{{WRAPPER}} .jr-submit-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'submit_radius',
            [
                'label'      => __( 'Border Radius', 'jr-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors'  => [
                    '{{WRAPPER}} .jr-submit-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Get rating breakdown
     */
    private function jr_get_rating_breakdown( $product_id ) {
        global $wpdb;

        $results = $wpdb->get_results( $wpdb->prepare(
            "SELECT cm.meta_value AS rating, COUNT(*) AS count
            FROM {$wpdb->commentmeta} cm
            INNER JOIN {$wpdb->comments} c ON cm.comment_id = c.comment_ID
            WHERE c.comment_post_ID = %d
                AND c.comment_approved = 1
                AND cm.meta_key = 'rating'
            GROUP BY cm.meta_value",
            $product_id
        ) );

        $breakdown = [ 5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0 ];
        $total = 0;

        foreach ( $results as $row ) {
            $rating = (int) $row->rating;
            if ( isset( $breakdown[ $rating ] ) ) {
                $breakdown[ $rating ] = (int) $row->count;
                $total += (int) $row->count;
            }
        }

        return [ 'breakdown' => $breakdown, 'total' => $total ];
    }

    /**
     * Render Stars HTML
     */
    private function jr_render_stars( $rating, $max = 5 ) {
        $rating = (float) $rating;
        $output = '<span class="jr-stars">';
        for ( $i = 1; $i <= $max; $i++ ) {
            $class = $i <= $rating ? 'jr-star is-active' : 'jr-star';
            $output .= '<span class="' . $class . '">★</span>';
        }
        $output .= '</span>';
        return $output;
    }

    /**
     * Get preview product
     */
    private function jr_get_preview_product() {
        if ( ! function_exists( 'wc_get_products' ) ) return false;
        $products = wc_get_products( [ 'limit' => 1, 'status' => 'publish' ] );
        return ! empty( $products ) ? $products[0] : false;
    }

    /**
     * Render Output
     */
    protected function render() {
        $settings = $this->get_settings_for_display();

        global $product;
        $is_edit_mode = \Elementor\Plugin::$instance->editor->is_edit_mode();

        if ( ! $product && function_exists( 'wc_get_product' ) ) {
            $product = wc_get_product( get_the_ID() );
        }

        if ( ! $product && $is_edit_mode ) {
            $product = $this->jr_get_preview_product();
        }

        if ( ! $product ) {
            if ( $is_edit_mode ) {
                echo '<div style="padding:20px; background:#fff3cd; border:1px dashed #ffc107; text-align:center;">⚠️ Product পাওয়া যায়নি।</div>';
            }
            return;
        }

        $product_id    = $product->get_id();
        $avg_rating    = (float) $product->get_average_rating();
        $review_count  = (int) $product->get_review_count();
        $rating_data   = $this->jr_get_rating_breakdown( $product_id );
        $breakdown     = $rating_data['breakdown'];
        $total         = $rating_data['total'];
        $recommend_pct = $total > 0 ? round( ( ( $breakdown[5] + $breakdown[4] ) / $total ) * 100, 2 ) : 0;
        $recommended_count = $breakdown[5] + $breakdown[4];

        $current_user = wp_get_current_user();
        $is_logged_in = is_user_logged_in();

        $layout_class = 'jr-layout-' . esc_attr( $settings['layout_type'] );
        ?>

        <div class="jr-reviews-wrapper <?php echo esc_attr( $layout_class ); ?>" data-product-id="<?php echo esc_attr( $product_id ); ?>">

            <?php if ( $settings['show_summary'] === 'yes' ) : ?>
            <div class="jr-reviews-summary">

                <div class="jr-summary-top">
                    <div class="jr-avg-block">
                        <div class="jr-avg-number"><?php echo esc_html( number_format( $avg_rating, 1 ) ); ?></div>
                        <?php if ( $settings['show_recommendation'] === 'yes' ) : ?>
                            <div class="jr-recommend-percent"><?php echo esc_html( number_format( $recommend_pct, 2 ) ); ?>%</div>
                        <?php endif; ?>
                    </div>

                    <div class="jr-avg-info">
                        <div class="jr-avg-label"><?php echo esc_html( $settings['avg_rating_label'] ); ?></div>
                        <?php echo $this->jr_render_stars( $avg_rating ); ?>
                        <span class="jr-reviews-count">(<?php echo esc_html( $review_count . ' ' . $settings['reviews_text'] ); ?>)</span>

                        <?php if ( $settings['show_recommendation'] === 'yes' ) : ?>
                            <div class="jr-recommend-label">
                                <?php echo esc_html( $settings['recommended_label'] ); ?>
                                <span class="jr-recommend-count">(<?php echo esc_html( $recommended_count . ' of ' . $total ); ?>)</span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if ( $settings['show_breakdown'] === 'yes' ) : ?>
                <div class="jr-rating-breakdown">
                    <?php for ( $i = 5; $i >= 1; $i-- ) :
                        $count = $breakdown[ $i ];
                        $percent = $total > 0 ? round( ( $count / $total ) * 100 ) : 0;
                    ?>
                    <div class="jr-breakdown-row">
                        <?php echo $this->jr_render_stars( $i ); ?>
                        <div class="jr-bar"><div class="jr-bar-fill" style="width: <?php echo esc_attr( $percent ); ?>%"></div></div>
                        <span class="jr-bar-percent"><?php echo esc_html( $percent ); ?>%</span>
                    </div>
                    <?php endfor; ?>
                </div>
                <?php endif; ?>

            </div>
            <?php endif; ?>

            <?php if ( $settings['show_form'] === 'yes' ) : ?>
            <div class="jr-reviews-form-wrap">
                <h3 class="jr-form-title"><?php echo esc_html( $settings['form_title'] ); ?></h3>
                <p class="jr-form-subtitle"><?php echo esc_html( $settings['form_subtitle'] ); ?></p>

                <?php if ( ! $is_logged_in && get_option( 'woocommerce_review_rating_required' ) === 'yes' && ! get_option( 'comment_registration' ) ) : ?>
                    <!-- Allow guest reviews -->
                <?php elseif ( ! $is_logged_in && get_option( 'comment_registration' ) ) : ?>
                    <div class="jr-login-required">
                        <?php echo esc_html( $settings['login_required_text'] ); ?>
                        <a href="<?php echo esc_url( wp_login_url( get_permalink( $product_id ) ) ); ?>"><?php esc_html_e( 'Login here', 'jr-addons' ); ?></a>
                    </div>
                <?php endif; ?>

                <?php if ( $is_logged_in || ! get_option( 'comment_registration' ) ) : ?>
                <form class="jr-review-form" method="post">
                    <?php wp_nonce_field( 'jr_submit_review', 'jr_review_nonce' ); ?>
                    <input type="hidden" name="product_id" value="<?php echo esc_attr( $product_id ); ?>">

                    <div class="jr-form-field">
                        <label><?php echo esc_html( $settings['review_label'] ); ?> <span class="jr-required">*</span></label>
                        <textarea name="review_content" rows="6" placeholder="<?php echo esc_attr( $settings['review_placeholder'] ); ?>" required></textarea>
                    </div>

                    <?php if ( ! $is_logged_in && $settings['show_name_email'] === 'yes' ) : ?>
                    <div class="jr-form-row">
                        <div class="jr-form-field">
                            <label><?php esc_html_e( 'Name', 'jr-addons' ); ?> <span class="jr-required">*</span></label>
                            <input type="text" name="reviewer_name" required>
                        </div>
                        <div class="jr-form-field">
                            <label><?php esc_html_e( 'Email', 'jr-addons' ); ?> <span class="jr-required">*</span></label>
                            <input type="email" name="reviewer_email" required>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="jr-form-bottom">
                        <div class="jr-form-field jr-rating-field">
                            <label><?php echo esc_html( $settings['rating_label'] ); ?> <span class="jr-required">*</span></label>

                            <?php if ( $settings['rating_input_type'] === 'stars' ) : ?>
                                <div class="jr-rating-input">
                                    <?php for ( $i = 1; $i <= 5; $i++ ) : ?>
                                        <span class="jr-star" data-value="<?php echo esc_attr( $i ); ?>">★</span>
                                    <?php endfor; ?>
                                    <input type="hidden" name="rating" value="" required>
                                </div>
                            <?php else : ?>
                                <select name="rating" required>
                                    <option value=""><?php esc_html_e( 'Select One', 'jr-addons' ); ?></option>
                                    <option value="5">★★★★★ (5)</option>
                                    <option value="4">★★★★ (4)</option>
                                    <option value="3">★★★ (3)</option>
                                    <option value="2">★★ (2)</option>
                                    <option value="1">★ (1)</option>
                                </select>
                            <?php endif; ?>
                        </div>

                        <?php if ( $settings['show_recommend_field'] === 'yes' ) : ?>
                        <div class="jr-form-field jr-recommend-field">
                            <label><?php esc_html_e( 'Recommend?', 'jr-addons' ); ?></label>
                            <div class="jr-radio-group">
                                <label><input type="radio" name="recommend" value="yes" checked> <?php esc_html_e( 'Yes', 'jr-addons' ); ?></label>
                                <label><input type="radio" name="recommend" value="no"> <?php esc_html_e( 'No', 'jr-addons' ); ?></label>
                            </div>
                        </div>
                        <?php endif; ?>

                        <button type="submit" class="jr-submit-btn">
                            <span class="jr-btn-text"><?php echo esc_html( $settings['submit_button_text'] ); ?></span>
                        </button>
                    </div>

                    <div class="jr-form-message"></div>
                </form>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <?php if ( $settings['show_reviews_list'] === 'yes' ) :
                $this->jr_render_reviews_list( $product_id, $settings['reviews_per_page'] );
            endif; ?>

        </div>
        <?php
    }

    /**
     * Render Reviews List with Avatar, Replies, Verified Badge
     */
    private function jr_render_reviews_list( $product_id, $per_page = 5 ) {
        $comments = get_comments( [
            'post_id' => $product_id,
            'status'  => 'approve',
            'type'    => 'review',
            'parent'  => 0, // Only top-level reviews
            'number'  => $per_page,
            'orderby' => 'comment_date',
            'order'   => 'DESC',
        ] );

        if ( empty( $comments ) ) {
            echo '<div class="jr-no-reviews">' . esc_html__( 'No reviews yet. Be the first to review!', 'jr-addons' ) . '</div>';
            return;
        }

        echo '<div class="jr-reviews-list-wrapper">';
        echo '<h3 class="jr-reviews-list-title">' . esc_html__( 'Customer Reviews', 'jr-addons' ) . ' <span>(' . count( $comments ) . ')</span></h3>';
        echo '<div class="jr-reviews-list">';
        
        foreach ( $comments as $comment ) {
            $this->jr_render_single_review( $comment, $product_id );
        }
        
        echo '</div>';
        echo '</div>';
    }

    /**
     * Render Single Review with Replies
     */
    private function jr_render_single_review( $comment, $product_id, $is_reply = false ) {
        $rating       = get_comment_meta( $comment->comment_ID, 'rating', true );
        $verified     = get_comment_meta( $comment->comment_ID, 'verified', true );
        $recommend    = get_comment_meta( $comment->comment_ID, 'jr_recommend', true );
        $is_admin     = user_can( $comment->user_id, 'manage_options' );
        $avatar       = get_avatar( $comment->comment_author_email, 60, '', $comment->comment_author, [ 'class' => 'jr-review-avatar' ] );
        $can_reply    = is_user_logged_in() && ! $is_reply; // Only logged-in users can reply, no nested replies
        
        $item_class = 'jr-review-item';
        if ( $is_reply ) $item_class .= ' jr-review-reply';
        if ( $is_admin ) $item_class .= ' jr-review-admin';
        ?>
        <div class="<?php echo esc_attr( $item_class ); ?>" data-comment-id="<?php echo esc_attr( $comment->comment_ID ); ?>">
            
            <div class="jr-review-avatar-wrap">
                <?php echo $avatar; ?>
            </div>

            <div class="jr-review-body">
                
                <div class="jr-review-head">
                    <div class="jr-review-author-info">
                        <strong class="jr-reviewer-name">
                            <?php echo esc_html( $comment->comment_author ); ?>
                            
                            <?php if ( $is_admin ) : ?>
                                <span class="jr-badge jr-badge-admin">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2L4 5v6c0 5.55 3.84 10.74 8 12 4.16-1.26 8-6.45 8-12V5l-8-3z"/></svg>
                                    <?php esc_html_e( 'Admin', 'jr-addons' ); ?>
                                </span>
                            <?php endif; ?>

                            <?php if ( $verified && ! $is_admin ) : ?>
                                <span class="jr-badge jr-badge-verified">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                                    <?php esc_html_e( 'Verified Buyer', 'jr-addons' ); ?>
                                </span>
                            <?php endif; ?>
                        </strong>
                        
                        <span class="jr-review-date">
                            <?php echo esc_html( human_time_diff( strtotime( $comment->comment_date_gmt ), current_time( 'timestamp', 1 ) ) . ' ' . __( 'ago', 'jr-addons' ) ); ?>
                        </span>
                    </div>

                    <?php if ( $rating && ! $is_reply ) : ?>
                        <div class="jr-review-rating">
                            <?php echo $this->jr_render_stars( $rating ); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if ( $recommend === 'yes' && ! $is_reply ) : ?>
                    <div class="jr-review-recommend">
                        👍 <?php esc_html_e( 'Recommends this product', 'jr-addons' ); ?>
                    </div>
                <?php endif; ?>

                <div class="jr-review-content">
                    <?php echo wp_kses_post( wpautop( $comment->comment_content ) ); ?>
                </div>

                <div class="jr-review-actions">
                    <?php if ( $can_reply ) : ?>
                        <button type="button" class="jr-reply-toggle" data-comment-id="<?php echo esc_attr( $comment->comment_ID ); ?>">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M10 9V5l-7 7 7 7v-4.1c5 0 8.5 1.6 11 5.1-1-5-4-10-11-11z"/></svg>
                            <?php esc_html_e( 'Reply', 'jr-addons' ); ?>
                        </button>
                    <?php endif; ?>
                </div>

                <?php if ( $can_reply ) : ?>
                    <div class="jr-reply-form-wrap" data-parent-id="<?php echo esc_attr( $comment->comment_ID ); ?>" style="display:none;">
                        <form class="jr-reply-form">
                            <?php wp_nonce_field( 'jr_submit_reply', 'jr_reply_nonce' ); ?>
                            <input type="hidden" name="product_id" value="<?php echo esc_attr( $product_id ); ?>">
                            <input type="hidden" name="parent_id" value="<?php echo esc_attr( $comment->comment_ID ); ?>">
                            
                            <textarea name="reply_content" rows="3" placeholder="<?php esc_attr_e( 'Write your reply...', 'jr-addons' ); ?>" required></textarea>
                            
                            <div class="jr-reply-form-actions">
                                <button type="button" class="jr-reply-cancel"><?php esc_html_e( 'Cancel', 'jr-addons' ); ?></button>
                                <button type="submit" class="jr-reply-submit"><?php esc_html_e( 'Post Reply', 'jr-addons' ); ?></button>
                            </div>
                            <div class="jr-reply-message"></div>
                        </form>
                    </div>
                <?php endif; ?>

                <?php
                // ============================================
                // Render Replies (Nested)
                // ============================================
                $replies = get_comments( [
                    'parent'  => $comment->comment_ID,
                    'status'  => 'approve',
                    'orderby' => 'comment_date',
                    'order'   => 'ASC',
                ] );

                if ( ! empty( $replies ) ) :
                    echo '<div class="jr-replies-list">';
                    foreach ( $replies as $reply ) {
                        $this->jr_render_single_review( $reply, $product_id, true );
                    }
                    echo '</div>';
                endif;
                ?>

            </div>
        </div>
        <?php
    }
}