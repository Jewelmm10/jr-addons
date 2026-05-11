<?php

namespace JR_Addons\Setup;

class Assets {

    public function __construct() {
        add_action( 'wp_enqueue_scripts', [ $this, 'frontend_assets' ], 20 );
        add_action( 'admin_enqueue_scripts', [ $this, 'admin_assets' ] );
        add_action( 'elementor/editor/after_enqueue_styles', [ $this, 'editor_assets' ] );
        add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'preview_assets' ] );
    }

    public function get_scripts() {
        return [
            'jr-frontend-script' => [
                'src'     => JR_ASSETS . 'js/frontend.js',
                'version' => filemtime( JR_PATH . 'assets/js/frontend.js' ),
                'deps'    => [ 'jquery', 'elementor-frontend' ],
            ],
            'jr-admin-script' => [  
                'src'     => JR_ASSETS . 'js/admin.js',
                'version' => filemtime( JR_PATH . 'assets/js/admin.js' ),
                'deps'    => [ 'jquery' ],
            ],
            'jr-search-script' => [
                'src'     => JR_ASSETS . 'js/jr-search.js',
                'version' => filemtime( JR_PATH . 'assets/js/jr-search.js' ),
                'deps'    => [ 'jquery' ],
            ],
            'jr-product-actions-script' => [
                'src'     => JR_ASSETS . 'js/product-action-btn.js',
                'version' => filemtime( JR_PATH . 'assets/js/product-action-btn.js' ),
                'deps'    => [ 'jquery' ],
            ],
            'jr-product-short-description' => [
                'src'     => JR_ASSETS . 'js/product-short-description.js',
                'version' => filemtime( JR_PATH . 'assets/js/product-short-description.js' ),
                'deps'    => [ 'jquery' ],
            ],
            'jr-product-reviews-script' => [
                'src'     => JR_ASSETS . 'js/product-reviews.js',
                'version' => filemtime( JR_PATH . 'assets/js/product-reviews.js' ),
                'deps'    => [ 'jquery', 'jr-frontend-script' ],
            ],
            'jr-header-icons-script' => [
                'src'     => JR_ASSETS . 'js/jr-header-icons.js',
                'version' => filemtime( JR_PATH . 'assets/js/jr-header-icons.js' ),
                'deps'    => [ 'jquery' ],
            ],
        ];
    }

    public function get_styles() {
        return [
            'jr-editor' => [
                'src'     => JR_ASSETS . 'css/editor.css',
                'version' => filemtime( JR_PATH . 'assets/css/editor.css' ),
            ],
            'jr-frontend-style' => [
                'src'     => JR_ASSETS . 'css/frontend.css',
                'version' => filemtime( JR_PATH . 'assets/css/frontend.css' ),
            ],
            'jr-addons-style' => [
                'src'     => JR_ASSETS . 'css/jr-addons.css',
                'version' => filemtime( JR_PATH . 'assets/css/jr-addons.css' ),
                'deps'    => [ 'elementor-frontend' ], 
            ],
            'product-actions-btn' => [
                'src'     => JR_ASSETS . 'css/product-action-btn.css',
                'version' => filemtime( JR_PATH . 'assets/css/product-action-btn.css' ),
            ],
            'jr-product-short-description' => [
                'src'     => JR_ASSETS . 'css/product-short-description.css',
                'version' => filemtime( JR_PATH . 'assets/css/product-short-description.css' ),
            ],
            'jr-product-reviews' => [
                'src'     => JR_ASSETS . 'css/product-reviews.css',
                'version' => filemtime( JR_PATH . 'assets/css/product-reviews.css' ),
            ],
            'jr-admin-style' => [
                'src'     => JR_ASSETS . 'css/admin.css',
                'version' => filemtime( JR_PATH . 'assets/css/admin.css' ),
            ],
        ];
    }

    public function frontend_assets() {
    $this->register_assets();

        // ============================================
        // Styles
        // ============================================
        wp_enqueue_style( 'jr-frontend-style' );
        wp_enqueue_style( 'jr-addons-style' );
        wp_enqueue_style( 'product-actions-btn' );
        wp_enqueue_style( 'jr-product-reviews' );
        wp_enqueue_style( 'jr-product-short-description' );

        // ============================================
        // Scripts
        // ============================================
        wp_enqueue_script( 'jr-frontend-script' );
        wp_enqueue_script( 'jr-search-script' );
        wp_enqueue_script( 'jr-header-icons-script' );
        wp_enqueue_script( 'jr-product-actions-script' );
        wp_enqueue_script( 'jr-product-reviews-script' );
        wp_enqueue_script( 'jr-product-short-description' );

        // ============================================
        // Search Localize
        // ============================================
        wp_localize_script( 'jr-search-script', 'jrSearch', [
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'nonce'    => wp_create_nonce( 'jr_search_nonce' ),
        ]);

        // ============================================
        // Global jrAddons - jr-frontend-script এ attach
        // ============================================
        wp_localize_script( 'jr-frontend-script', 'jrAddons', [
            'ajax_url'     => admin_url( 'admin-ajax.php' ),
            'home_url'     => home_url( '/' ),
            'is_logged_in' => is_user_logged_in(),
            'nonces'       => [
                'review' => wp_create_nonce( 'jr_review_nonce' ),
                'reply'  => wp_create_nonce( 'jr_submit_reply' ),
            ],
        ]);
    }

    public function admin_assets( $hook ) {
        if ( $hook !== 'toplevel_page_jr-addons' ) {
            return;
        }

        $this->register_assets();
        wp_enqueue_style( 'jr-admin-style' );
        wp_enqueue_script( 'jr-admin-script' );
        wp_localize_script('jr-admin-script', 'jrAdmin', [
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce'   => wp_create_nonce('jr_admin_nonce'),
        ]);
    }

    public function editor_assets() {
        $this->register_assets(); 
        wp_enqueue_style( 'jr-editor' );
    }

    public function preview_assets() {
        // Editor preview এ search test করতে চাইলে এটা enable করুন
        $this->register_assets();
        wp_enqueue_script( 'jr-search-script' );
        wp_localize_script( 'jr-search-script', 'jrSearch', [
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'nonce'    => wp_create_nonce( 'jr_search_nonce' ),
        ]);
    }

    public function register_assets() {
        $scripts = $this->get_scripts();
        $styles  = $this->get_styles();

        foreach ( $scripts as $handle => $script ) {
            wp_register_script(
                $handle,
                $script['src'],
                $script['deps'] ?? [],
                $script['version'],
                true
            );
        }

        foreach ( $styles as $handle => $style ) {
            wp_register_style(
                $handle,
                $style['src'],
                $style['deps'] ?? [],
                $style['version']
            );
        }
    }



}
