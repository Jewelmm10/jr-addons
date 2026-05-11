<?php
namespace JR_Addons\Elementor\Widgets\SingleProduct;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Plugin as ElementorPlugin;

if ( ! defined( 'ABSPATH' ) ) exit;

class Product_Gallery extends Widget_Base {

    /**
     * Widget Name
     */
    public function get_name(): string {
        return 'jr-product-gallery';
    }

    /**
     * Widget Title
     */
    public function get_title(): string {
        return esc_html__( 'Product Gallery', 'jr-addons' );
    }

    /**
     * Widget Icon
     */
    public function get_icon(): string {
        return 'jr-get-icon';
    }

    /**
     * Widget Categories
     */
    public function get_categories(): array {
        return [ 'jr-wc' ];
    }

    /**
     * Script Dependencies
     */
    public function get_script_depends(): array {
        return [ 'swiper' ];
    }

    /**
     * Style Dependencies
     */
    public function get_style_depends(): array {
        return [ 'swiper' ];
    }

    /**
     * Register Controls
     */
    protected function register_controls(): void {

        $this->_register_layout_controls();
        $this->_register_image_style_controls();
        $this->_register_thumbnail_style_controls();
    }

    /**
     * Layout Controls
     */
    private function _register_layout_controls(): void {

        $this->start_controls_section(
            'layout_section',
            [
                'label' => esc_html__( 'Layout', 'jr-addons' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'thumb_position',
            [
                'label'   => esc_html__( 'Thumbnail Position', 'jr-addons' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'left',
                'options' => [
                    'left'   => esc_html__( 'Left (Vertical)', 'jr-addons' ),
                    'bottom' => esc_html__( 'Bottom (Horizontal)', 'jr-addons' ),
                ],
            ]
        );

        $this->add_control(
            'thumbs_per_view',
            [
                'label'   => esc_html__( 'Thumbs Per View', 'jr-addons' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => 4,
                'min'     => 1,
                'max'     => 10,
                'step'    => 1,
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Image Style Controls
     */
    private function _register_image_style_controls(): void {

        $this->start_controls_section(
            'image_style_section',
            [
                'label' => esc_html__( 'Main Image', 'jr-addons' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'image_height',
            [
                'label'      => esc_html__( 'Image Height', 'jr-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'vh' ],
                'range'      => [
                    'px' => [ 'min' => 100, 'max' => 800 ],
                    'vh' => [ 'min' => 10,  'max' => 100 ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .jr-main-swiper .swiper-slide img' => 'height: {{SIZE}}{{UNIT}}; object-fit: cover;',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'jr-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .jr-main-swiper .swiper-slide img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'image_border',
                'selector' => '{{WRAPPER}} .jr-main-swiper .swiper-slide img',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'image_shadow',
                'selector' => '{{WRAPPER}} .jr-main-swiper .swiper-slide img',
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Thumbnail Style Controls
     */
    private function _register_thumbnail_style_controls(): void {

        $this->start_controls_section(
            'thumb_style_section',
            [
                'label' => esc_html__( 'Thumbnail', 'jr-addons' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'thumb_size',
            [
                'label'      => esc_html__( 'Thumbnail Height', 'jr-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [
                    'px' => [ 'min' => 40, 'max' => 200 ],
                ],
                'default'    => [ 'size' => 100, 'unit' => 'px' ],
                'selectors'  => [
                    '{{WRAPPER}} .jr-thumb-swiper .swiper-slide' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'thumb_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'jr-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .jr-thumb-swiper .swiper-slide img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'thumb_border',
                'selector' => '{{WRAPPER}} .jr-thumb-swiper .swiper-slide img',
            ]
        );

        $this->add_control(
            'thumb_active_border_color',
            [
                'label'     => esc_html__( 'Active Border Color', 'jr-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .jr-thumb-swiper .swiper-slide-thumb-active img' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'thumb_spacing',
            [
                'label'      => esc_html__( 'Spacing Between Thumbs', 'jr-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [
                    'px' => [ 'min' => 0, 'max' => 50 ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .jr-thumb-swiper .swiper-slide' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Get Current Product
     *
     * @return \WC_Product|null
     */
    private function get_product(): ?\WC_Product {

        global $product;

        if ( is_product() && $product instanceof \WC_Product ) {
            return $product;
        }

        if ( ElementorPlugin::$instance->editor->is_edit_mode() ) {
            return $this->get_demo_product();
        }

        return null;
    }

    /**
     * Get Demo Product for Editor Preview
     *
     * @return \WC_Product|null
     */
    private function get_demo_product(): ?\WC_Product {

        $posts = get_posts( [
            'post_type'      => 'product',
            'posts_per_page' => 1,
            'post_status'    => 'publish',
            'fields'         => 'ids',
        ] );

        if ( empty( $posts ) ) {
            return null;
        }

        $product = wc_get_product( $posts[0] );

        return $product instanceof \WC_Product ? $product : null;
    }

    /**
     * Collect All Product Images
     *
     * @param \WC_Product $product
     * @return array
     */
    private function get_product_images( \WC_Product $product ): array {

        $images = [];

        // Featured Image
        $featured_id = $product->get_image_id();

        if ( $featured_id ) {
            $images[] = $this->prepare_image_data( $featured_id );
        }

        // Gallery Images
        $gallery_ids = $product->get_gallery_image_ids();

        if ( ! empty( $gallery_ids ) ) {
            foreach ( $gallery_ids as $gallery_id ) {
                $images[] = $this->prepare_image_data( $gallery_id );
            }
        }

        return array_filter( $images );
    }

    /**
     * Prepare Image Data Array
     *
     * @param int $attachment_id
     * @return array|null
     */
    private function prepare_image_data( int $attachment_id ): ?array {

        $full_url  = wp_get_attachment_image_url( $attachment_id, 'full' );
        $thumb_url = wp_get_attachment_image_url( $attachment_id, 'thumbnail' );

        if ( ! $full_url ) {
            return null;
        }

        return [
            'full'  => esc_url( $full_url ),
            'thumb' => esc_url( $thumb_url ?: $full_url ),
            'alt'   => esc_attr( get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) ),
        ];
    }

    /**
     * Render Widget Output
     */
    protected function render(): void {

        $product = $this->get_product();

        if ( ! $product ) {
            if ( ElementorPlugin::$instance->editor->is_edit_mode() ) {
                echo '<p style="text-align:center; padding:20px;">' . esc_html__( 'No product found for preview.', 'jr-addons' ) . '</p>';
            }
            return;
        }

        $images = $this->get_product_images( $product );

        if ( empty( $images ) ) {
            return;
        }

        $settings  = $this->get_settings_for_display();
        $position  = $settings['thumb_position'] ?? 'left';
        $thumbs    = absint( $settings['thumbs_per_view'] ?? 4 );
        $direction = ( $position === 'left' ) ? 'vertical' : 'horizontal';

        $this->render_html( $position, $direction, $thumbs, $images );
    }

    /**
     * Render Gallery HTML
     */
    private function render_html( string $position, string $direction, int $thumbs, array $images ): void {
        ?>
        <div class="jr-product-gallery jr-position-<?php echo esc_attr( $position ); ?>"
            data-thumbs="<?php echo esc_attr( $thumbs ); ?>"
            data-direction="<?php echo esc_attr( $direction ); ?>">

            <!-- Main Swiper -->
            <div class="swiper jr-main-swiper">
                <div class="swiper-wrapper">
                    <?php foreach ( $images as $image ) : ?>
                        <div class="swiper-slide">
                            <img 
                                src="<?php echo esc_url( $image['full'] ); ?>" 
                                alt="<?php echo esc_attr( $image['alt'] ); ?>"
                                loading="lazy"
                            >
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Thumbnail Swiper -->
            <div class="swiper jr-thumb-swiper">
                <div class="swiper-wrapper">
                    <?php foreach ( $images as $image ) : ?>
                        <div class="swiper-slide">
                            <img 
                                src="<?php echo esc_url( $image['thumb'] ); ?>" 
                                alt="<?php echo esc_attr( $image['alt'] ); ?>"
                                loading="lazy"
                            >
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>
        <?php
    }

    /**
     * Render Swiper Script
     *
     * @param string $uid
     * @param string $direction
     * @param int    $thumbs
     */
    private function render_script( string $uid, string $direction, int $thumbs ): void {
        ?>
        <script>
        ( function() {

            'use strict';

            function initJRGallery() {

                var wrapper = document.querySelector( '.<?php echo esc_js( $uid ); ?>' );

                if ( ! wrapper ) return;

                var thumbSwiper = new Swiper( '.<?php echo esc_js( $uid ); ?> .jr-thumb-swiper', {
                    spaceBetween    : 10,
                    slidesPerView   : <?php echo absint( $thumbs ); ?>,
                    freeMode        : true,
                    watchSlidesProgress : true,
                    direction       : '<?php echo esc_js( $direction ); ?>',
                } );

                var mainSwiper = new Swiper( '.<?php echo esc_js( $uid ); ?> .jr-main-swiper', {
                    spaceBetween : 10,
                    thumbs       : {
                        swiper : thumbSwiper,
                    },
                } );
            }

            if ( document.readyState === 'loading' ) {
                document.addEventListener( 'DOMContentLoaded', initJRGallery );
            } else {
                initJRGallery();
            }

        } )();
        </script>
        <?php
    }

}