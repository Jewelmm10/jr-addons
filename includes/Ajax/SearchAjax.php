<?php
namespace JR_Addons\Ajax;

if (!defined('ABSPATH')) exit;

class SearchAjax {

    public static function init() {
        add_action('wp_ajax_jr_live_search', [__CLASS__, 'handle']);
        add_action('wp_ajax_nopriv_jr_live_search', [__CLASS__, 'handle']);
    }

    public static function handle() {
    
        if (ob_get_level()) {
            ob_end_clean();
        }
        
        check_ajax_referer('jr_search_nonce', 'nonce');

        $keyword     = isset($_POST['keyword']) ? sanitize_text_field(wp_unslash($_POST['keyword'])) : '';
        $category    = isset($_POST['category']) ? sanitize_text_field(wp_unslash($_POST['category'])) : '';
        $limit       = isset($_POST['limit']) ? (int) $_POST['limit'] : 6;
        $show_image  = isset($_POST['show_image']) && $_POST['show_image'] === 'true';
        $show_price  = isset($_POST['show_price']) && $_POST['show_price'] === 'true';

        if (strlen($keyword) < 2) {
            wp_send_json_error(['message' => 'Type at least 2 characters']);
        }

        $args = [
            'post_type'      => 'product',
            'posts_per_page' => $limit,
            's'              => $keyword,
            'post_status'    => 'publish',
        ];

        if (!empty($category)) {
            $args['tax_query'] = [[
                'taxonomy' => 'product_cat',
                'field'    => 'slug',
                'terms'    => $category,
            ]];
        }

        $query = new \WP_Query($args);
        
        
        ob_start();

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $product = function_exists('wc_get_product') ? wc_get_product(get_the_ID()) : null;
                ?>
                <a href="<?php the_permalink(); ?>" class="jr-result-item">
                    <?php if ($show_image && has_post_thumbnail()): ?>
                        <?php the_post_thumbnail('thumbnail'); ?>
                    <?php endif; ?>
                    <div class="jr-result-info">
                        <h4 class="jr-result-title"><?php the_title(); ?></h4>
                        <?php if ($show_price && $product): ?>
                            <div class="jr-result-price"><?php echo $product->get_price_html(); ?></div>
                        <?php endif; ?>
                    </div>
                </a>
                <?php
            }
            wp_reset_postdata();
            $html = ob_get_clean();
            wp_send_json_success(['html' => $html, 'count' => $query->found_posts]);
        } else {
            ob_end_clean();
            wp_send_json_error([
                'message' => 'No products found',
                'html'    => '<div class="jr-no-results">😕 No products found for "' . esc_html($keyword) . '"</div>'
            ]);
        }
    }
}