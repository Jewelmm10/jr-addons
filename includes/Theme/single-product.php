<?php
defined( 'ABSPATH' ) || exit;

get_header();

do_action( 'jr_render_header' );

echo '<main class="jr-product-main">';

    while ( have_posts() ) :
        the_post();
        global $product;
        $product = wc_get_product( get_the_ID() );

        do_action( 'jr_single_product_content' );

    endwhile;

echo '</main>';

do_action( 'jr_render_footer' );

get_footer();