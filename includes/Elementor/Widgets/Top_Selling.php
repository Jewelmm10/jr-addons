<?php
namespace JR_Addons\Elementor\Widgets;

if ( ! defined( 'ABSPATH' ) ) exit;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;

class Top_Selling extends Widget_Base {

    public function get_name() {
        return 'jr_top_selling';
    }

    public function get_title() {
        return esc_html__( 'Top Selling Products', 'jr-addons' );
    }

    public function get_icon() {
        return 'jr-get-icon';
    }

    public function get_categories() {
        return [ 'jr-addons' ];
    }

    protected function register_controls() {

        /* -------------------- CONTENT -------------------- */

        $this->start_controls_section(
            'section_content',
            [
                'label' => __( 'Query Settings', 'jr-addons' ),
            ]
        );

        $this->add_control(
            'posts_per_page',
            [
                'label' => __( 'Products Count', 'jr-addons' ),
                'type' => Controls_Manager::NUMBER,
                'default' => 4,
            ]
        );

        $this->end_controls_section();

        /* -------------------- STYLE: CARD -------------------- */

        $this->start_controls_section(
            'section_card_style',
            [
                'label' => __( 'Card', 'jr-addons' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'card_background',
                'selector' => '{{WRAPPER}} .jr-product-card',
            ]
        );

        $this->end_controls_section();

        /* -------------------- STYLE: TITLE -------------------- */

        $this->start_controls_section(
            'section_title_style',
            [
                'label' => __( 'Title', 'jr-addons' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typo',
                'selector' => '{{WRAPPER}} .jr-product-title',
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __( 'Color', 'jr-addons' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .jr-product-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {

        if ( ! class_exists( 'WooCommerce' ) ) {
            echo '<p>WooCommerce not installed</p>';
            return;
        }

        $settings = $this->get_settings_for_display();

        $args = [
            'post_type' => 'product',
            'posts_per_page' => $settings['posts_per_page'],
            'meta_key' => 'total_sales',
            'orderby' => 'meta_value_num',
            'order' => 'DESC',
        ];

        $loop = new \WP_Query( $args );

        if ( $loop->have_posts() ) :

            echo '<div class="grid md:grid-cols-2 gap-6">';

            while ( $loop->have_posts() ) : $loop->the_post();

                global $product;

                $regular_price = $product->get_regular_price();
                $sale_price    = $product->get_sale_price();
                $save_amount   = $regular_price && $sale_price ? $regular_price - $sale_price : 0;

                ?>

                <div class="jr-product-card rounded-xl p-6 flex gap-6 items-center">

                    <!-- Image -->
                    <div class="w-40 shrink-0">
                        <a href="<?php the_permalink(); ?>">
                            <?php echo $product->get_image('medium'); ?>
                        </a>
                    </div>

                    <!-- Content -->
                    <div class="flex-1">

                        <span class="inline-block bg-red-500 text-white text-xs px-3 py-1 rounded-full mb-2">
                            Best Selling
                        </span>

                        <h3 class="jr-product-title text-lg font-semibold mb-2">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_title(); ?>
                            </a>
                        </h3>

                        <div class="mb-2">
                            <?php if ( $sale_price ) : ?>
                                <span class="text-orange-600 font-bold mr-2">
                                    <?php echo wc_price( $sale_price ); ?>
                                </span>
                                <span class="line-through text-gray-400">
                                    <?php echo wc_price( $regular_price ); ?>
                                </span>
                            <?php else : ?>
                                <span class="text-orange-600 font-bold">
                                    <?php echo $product->get_price_html(); ?>
                                </span>
                            <?php endif; ?>
                        </div>

                        <?php if ( $save_amount > 0 ) : ?>
                            <div class="inline-block bg-lime-500 text-black text-xs px-3 py-1 rounded-full mb-3">
                                Save <?php echo wc_price($save_amount); ?>
                            </div>
                        <?php endif; ?>

                        <div class="flex gap-3 mt-3">

                            <?php woocommerce_template_loop_add_to_cart(); ?>

                            <a href="?add-to-cart=<?php echo $product->get_id(); ?>&quantity=1"
                               class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg text-sm">
                                Buy Now
                            </a>

                        </div>

                    </div>
                </div>

                <?php

            endwhile;

            echo '</div>';

            wp_reset_postdata();

        endif;
    }
}