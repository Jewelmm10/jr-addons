<?php

namespace JR_Addons\Theme;

if (!defined('ABSPATH')) exit;

class HeaderFooterCPT {

    public function __construct() {
        add_action('init', [$this, 'register_cpt']);
        add_action('add_meta_boxes', [$this, 'add_meta_boxes']);
        add_action('save_post', [$this, 'save_meta']);
    }

    public function register_cpt() {

        register_post_type('jr_template', [
            'labels' => [
                'name' => 'Theme Builder',
                'singular_name' => 'Template'
            ],
            'public'              => true,
            'publicly_queryable'  => true,
            'exclude_from_search' => true,
            'show_in_nav_menus'   => false,
            'has_archive'         => false,
            'rewrite'             => false,
            'show_ui'             => true,
            'menu_icon'           => 'dashicons-layout',
            'supports'            => ['title', 'editor', 'elementor'],
            'show_in_menu'        => false,
        ]);
    }

    public function add_meta_boxes() {

        add_meta_box(
            'jr_template_settings',
            'Template Settings',
            [$this, 'settings_html'],
            'jr_template',
            'side'
        );
    }

    public function settings_html($post) {

        $type       = get_post_meta($post->ID, '_jr_template_type', true);
        $condition  = get_post_meta($post->ID, '_jr_display_condition', true);
        $active     = get_post_meta($post->ID, '_jr_template_active', true);

        wp_nonce_field('jr_template_nonce', 'jr_template_nonce_field');
        ?>

        <p><strong>Template Type</strong></p>
        <select name="jr_template_type" style="width:100%;">
            <option value="header" <?php selected($type, 'header'); ?>>Header</option>
            <option value="footer" <?php selected($type, 'footer'); ?>>Footer</option>
            <option value="single_product" <?php selected($type, 'single_product'); ?>>Single Product</option>
        </select>

        <hr>

        <p><strong>Display On</strong></p>
        <select name="jr_display_condition" style="width:100%;">
            <option value="entire_site" <?php selected($condition, 'entire_site'); ?>>
                Entire Site
            </option>
            <option value="front_page" <?php selected($condition, 'front_page'); ?>>
                Front Page
            </option>
            <option value="singular" <?php selected($condition, 'singular'); ?>>
                All Singular
            </option>
            <option value="archive" <?php selected($condition, 'archive'); ?>>
                All Archive
            </option>
            <option value="single_product" <?php selected($condition, 'single_product'); ?>>
                Single Product
            </option>
        </select>

        <hr>

        <label>
            <input type="checkbox" name="jr_template_active" value="yes"
                <?php checked($active, 'yes'); ?>>
            Active
        </label>

        <?php
    }

    public function save_meta($post_id) {

        if (!isset($_POST['jr_template_nonce_field'])) return;
        if (!wp_verify_nonce($_POST['jr_template_nonce_field'], 'jr_template_nonce')) return;
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

        update_post_meta($post_id, '_jr_template_type', sanitize_text_field($_POST['jr_template_type'] ?? ''));
        update_post_meta($post_id, '_jr_display_condition', sanitize_text_field($_POST['jr_display_condition'] ?? ''));
        update_post_meta($post_id, '_jr_template_active', isset($_POST['jr_template_active']) ? 'yes' : 'no');
    }
}