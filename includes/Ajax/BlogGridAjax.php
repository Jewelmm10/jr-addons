<?php
namespace JR_Addons\Ajax;

if (!defined('ABSPATH')) {
    exit;
}

class BlogGridAjax {

    public static function init() {
        add_action('wp_ajax_jr_blog_grid_load_more', [__CLASS__, 'load_more_posts']);
        add_action('wp_ajax_nopriv_jr_blog_grid_load_more', [__CLASS__, 'load_more_posts']);
        add_action('wp_ajax_jr_blog_grid_filter', [__CLASS__, 'filter_posts']);
        add_action('wp_ajax_nopriv_jr_blog_grid_filter', [__CLASS__, 'filter_posts']);
    }

    public static function load_more_posts() {
        if (!check_ajax_referer('jr_blog_grid_nonce', 'nonce', false)) {
            wp_send_json_error(['message' => 'Invalid nonce']);
        }

        self::query_and_respond(
            isset($_POST['page']) ? absint($_POST['page']) : 1
        );
    }

    public static function filter_posts() {
        if (!check_ajax_referer('jr_blog_grid_nonce', 'nonce', false)) {
            wp_send_json_error(['message' => 'Invalid nonce']);
        }

        self::query_and_respond(1);
    }

    private static function query_and_respond($page = 1) {
        $posts_per_page = isset($_POST['posts_per_page']) ? absint($_POST['posts_per_page']) : 3;
        $category       = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '';
        $post_type      = isset($_POST['post_type']) ? sanitize_text_field($_POST['post_type']) : 'post';
        $taxonomy       = isset($_POST['taxonomy']) ? sanitize_text_field($_POST['taxonomy']) : 'category';
        $orderby        = isset($_POST['orderby']) ? sanitize_text_field($_POST['orderby']) : 'date';
        $order          = isset($_POST['order']) ? sanitize_text_field($_POST['order']) : 'DESC';

        $opts = [
            'taxonomy'       => $taxonomy,
            'excerpt_length' => isset($_POST['excerpt_length']) ? absint($_POST['excerpt_length']) : 20,
            'button_text'    => isset($_POST['button_text']) ? sanitize_text_field($_POST['button_text']) : 'READ ARTICLE',
            'show_badge'     => isset($_POST['show_category_badge']) ? sanitize_text_field($_POST['show_category_badge']) : 'yes',
            'show_excerpt'   => isset($_POST['show_excerpt']) ? sanitize_text_field($_POST['show_excerpt']) : 'yes',
            'show_button'    => isset($_POST['show_button']) ? sanitize_text_field($_POST['show_button']) : 'yes',
            'show_image'     => isset($_POST['show_image']) ? sanitize_text_field($_POST['show_image']) : 'yes',
            'image_size'     => isset($_POST['image_size']) ? sanitize_text_field($_POST['image_size']) : 'medium_large',
            'show_date'      => isset($_POST['show_date']) ? sanitize_text_field($_POST['show_date']) : '',
            'show_author'    => isset($_POST['show_author']) ? sanitize_text_field($_POST['show_author']) : '',
        ];

        $args = [
            'post_type'      => $post_type,
            'posts_per_page' => $posts_per_page,
            'paged'          => $page,
            'orderby'        => $orderby,
            'order'          => $order,
            'post_status'    => 'publish',
        ];

        if (!empty($category) && $category !== 'all') {
            $args['tax_query'] = [
                [
                    'taxonomy' => $taxonomy,
                    'field'    => 'slug',
                    'terms'    => $category,
                ],
            ];
        }

        $query = new \WP_Query($args);
        $html  = '';

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $html .= self::render_card($opts);
            }
        }

        wp_reset_postdata();

        wp_send_json_success([
            'html'         => $html,
            'max_pages'    => (int) $query->max_num_pages,
            'current_page' => $page,
            'found_posts'  => (int) $query->found_posts,
        ]);
    }

    private static function render_card($opts) {
        $taxonomy       = $opts['taxonomy'];
        $excerpt_length = $opts['excerpt_length'];
        $button_text    = $opts['button_text'];
        $show_badge     = $opts['show_badge'];
        $show_excerpt   = $opts['show_excerpt'];
        $show_button    = $opts['show_button'];
        $show_image     = $opts['show_image'];
        $image_size     = $opts['image_size'];
        $show_date      = $opts['show_date'];
        $show_author    = $opts['show_author'];

        $categories = get_the_terms(get_the_ID(), $taxonomy);
        $cat_name   = '';
        $cat_slug   = '';
        if ($categories && !is_wp_error($categories)) {
            $cat_name = $categories[0]->name;
            $cat_slug = $categories[0]->slug;
        }

        $excerpt = get_the_excerpt();
        if (empty($excerpt)) {
            $excerpt = wp_trim_words(get_the_content(), $excerpt_length, '...');
        } else {
            $excerpt = wp_trim_words($excerpt, $excerpt_length, '...');
        }

        ob_start();
        ?>
        <div class="jr-bgt-card" data-category="<?php echo esc_attr($cat_slug); ?>">
            <?php if ($show_image === 'yes') : ?>
                <div class="jr-bgt-card-image">
                    <a href="<?php the_permalink(); ?>">
                        <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail($image_size); ?>
                        <?php else : ?>
                            <div class="jr-bgt-no-image">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#bbb" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                            </div>
                        <?php endif; ?>
                    </a>
                </div>
            <?php endif; ?>

            <div class="jr-bgt-card-content">
                <?php if ($show_badge === 'yes' && $cat_name) : ?>
                    <span class="jr-bgt-badge"><?php echo esc_html(strtoupper($cat_name)); ?></span>
                <?php endif; ?>

                <h3 class="jr-bgt-card-title">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h3>

                <?php if ($show_date === 'yes' || $show_author === 'yes') : ?>
                    <div class="jr-bgt-meta">
                        <?php if ($show_date === 'yes') : ?>
                            <span class="jr-bgt-meta-date">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                <?php echo get_the_date(); ?>
                            </span>
                        <?php endif; ?>
                        <?php if ($show_author === 'yes') : ?>
                            <span class="jr-bgt-meta-author">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                <?php the_author(); ?>
                            </span>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <?php if ($show_excerpt === 'yes') : ?>
                    <p class="jr-bgt-card-excerpt"><?php echo esc_html($excerpt); ?></p>
                <?php endif; ?>

                <?php if ($show_button === 'yes') : ?>
                    <a href="<?php the_permalink(); ?>" class="jr-bgt-read-more">
                        <?php echo esc_html($button_text); ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
}