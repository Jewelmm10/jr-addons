<?php

namespace JR_Addons\Tools;

if (!defined('ABSPATH')) exit;

class Duplicator {

    public function __construct() {
        add_filter('post_row_actions', [$this, 'add_duplicate_link'], 10, 2);
        add_filter('page_row_actions', [$this, 'add_duplicate_link'], 10, 2);
        add_action('admin_action_jr_duplicate_post', [$this, 'duplicate_post']);
    }

    /**
     * Add Duplicate Link
     */
    public function add_duplicate_link($actions, $post) {

        if (!current_user_can('edit_posts')) {
            return $actions;
        }

        if (in_array($post->post_type, ['post', 'page', 'jr_template'])) {

            $url = wp_nonce_url(
                admin_url('admin.php?action=jr_duplicate_post&post=' . $post->ID),
                'jr_duplicate_nonce_' . $post->ID
            );

            $actions['duplicate'] = '<a href="' . esc_url($url) . '">Duplicate</a>';
        }

        return $actions;
    }

    /**
     * Duplicate Logic
     */
    public function duplicate_post() {

        if (!isset($_GET['post'])) {
            wp_die('No post to duplicate.');
        }

        $post_id = absint($_GET['post']);

        if (!wp_verify_nonce($_GET['_wpnonce'], 'jr_duplicate_nonce_' . $post_id)) {
            wp_die('Security check failed');
        }

        $post = get_post($post_id);

        if (!$post) {
            wp_die('Post not found');
        }

        $new_post = [
            'post_title'   => $post->post_title . ' (Copy)',
            'post_content' => $post->post_content,
            'post_status'  => 'draft',
            'post_type'    => $post->post_type,
            'post_author'  => get_current_user_id(),
        ];

        $new_post_id = wp_insert_post($new_post);

        /**
         * ✅ Copy Meta (including Elementor data)
         */
        $meta = get_post_meta($post_id);

        foreach ($meta as $key => $values) {
            foreach ($values as $value) {
                add_post_meta($new_post_id, $key, maybe_unserialize($value));
            }
        }

        /**
         * ✅ Copy Taxonomies
         */
        $taxonomies = get_object_taxonomies($post->post_type);

        foreach ($taxonomies as $taxonomy) {
            $terms = wp_get_object_terms($post_id, $taxonomy, ['fields' => 'ids']);
            wp_set_object_terms($new_post_id, $terms, $taxonomy);
        }
        wp_redirect(admin_url('edit.php?post_type=' . $post->post_type));
        exit;
    }
}