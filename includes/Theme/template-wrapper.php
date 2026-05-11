<?php
defined('ABSPATH') || exit;

get_header();

do_action('jr_render_header');

while (have_posts()) :
    the_post();

    if (is_product()) {
        do_action('jr_render_single_product');
    } else {
        the_content();
    }

endwhile;

do_action('jr_render_footer');

get_footer();