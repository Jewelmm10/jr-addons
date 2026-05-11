<?php

namespace JR_Addons\Theme;

if (!defined('ABSPATH')) exit;

class HeaderFooterRenderer {

    public function __construct() {

        add_action('template_redirect', [$this, 'init']);
        add_action('jr_render_header', [$this, 'render_header']);
        add_action('jr_render_footer', [$this, 'render_footer']);
        add_action('jr_render_single_product', [$this, 'render_single_product']);
    }

    public function init() {

        if (is_admin() || is_preview()) return;

        add_filter('template_include', [$this, 'override_template'], 999);
    }

    public function override_template($template) {

        // Single Product Page
        if (is_product() && $this->has_active_template('single_product')) {
            return plugin_dir_path(__FILE__) . 'template-wrapper.php';
        }

        // Other Pages (Header/Footer only)
        if ($this->has_active_template('header') || $this->has_active_template('footer')) {
            return plugin_dir_path(__FILE__) . 'template-wrapper.php';
        }

        return $template;
    }

    public function render_header() {
        $this->render_type('header');
    }

    public function render_footer() {
        $this->render_type('footer');
    }
    
    public function render_single_product() {
        $this->render_type('single_product');
    }

    private function render_type($type) {

        $templates = get_posts([
            'post_type' => 'jr_template',
            'posts_per_page' => -1,
            'meta_query' => [
                [
                    'key'   => '_jr_template_type',
                    'value' => $type,
                ],
                [
                    'key'   => '_jr_template_active',
                    'value' => 'yes',
                ],
            ],
        ]);

        if (!empty($templates)) {

            foreach ($templates as $template) {

                $condition = get_post_meta($template->ID, '_jr_display_condition', true);

                if ($this->condition_match($condition)) {

                    echo \Elementor\Plugin::instance()
                        ->frontend
                        ->get_builder_content_for_display($template->ID);

                    return; 
                }
            }
        }

        /*
        *  Fallback System (VERY IMPORTANT)
        * 1. If it's a single product page and no active single product template, show default Woo content
        * 2. If it's header/footer and no active template, do nothing (let theme handle it)
        */

        if ($type === 'single_product') {
            the_content();
        }

        if ($type === 'header' || $type === 'footer') {
           
        }
    }

    public function has_active_template($type) {

        return !empty(get_posts([
            'post_type' => 'jr_template',
            'posts_per_page' => 1,
            'meta_query' => [
                [
                    'key' => '_jr_template_type',
                    'value' => $type,
                ],
                [
                    'key' => '_jr_template_active',
                    'value' => 'yes',
                ],
            ],
        ]));
    }

    private function condition_match($condition) {

        switch ($condition) {
            case 'entire_site':
                return true;

            case 'front_page':
                return is_front_page();

            case 'singular':
                return is_singular();

            case 'archive':
                return is_archive();

            case 'single_product':
                return is_product();

            default:
                return false;
        }
    }
}