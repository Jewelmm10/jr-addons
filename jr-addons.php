<?php
/*
Plugin Name:       JR Addons
Plugin URI:        https://github.com/jewelmm10/jr-addons
Description:       Custom Elementor Widgets & Addons by Jewel Rahman
Version:           1.0.0
Requires PHP:      8.1
Requires at least: 6.5         
Tested up to:      6.9
Author:            Jewel Rahman
Author URI:        https://jewel.edbd-server.com/
Text Domain:       jr-addons
Domain Path:       /languages
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

final class JR_Addons {

    const VERSION = '1.0.0';

    private function __construct() {
        $this->define_constants();
        $this->load_textdomain();

        register_activation_hook( __FILE__, [ $this, 'activate' ] );
        // register_deactivation_hook( __FILE__, [ $this, 'deactivate' ] ); // optional

        add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );
    }

    public static function init() {
        static $instance = null;
        if ( null === $instance ) {
            $instance = new self();
        }
        return $instance;
    }

    private function define_constants() {
        define( 'JR_VERSION', self::VERSION );
        define( 'JR_FILE', __FILE__ );
        define( 'JR_PATH', plugin_dir_path( JR_FILE ) );          
        define( 'JR_URL',  plugin_dir_url( JR_FILE ) );           
        define( 'JR_ASSETS', JR_URL . 'assets/' );               
    }

    private function load_textdomain() {
        load_plugin_textdomain(
            'jr-addons',
            false,
            dirname( plugin_basename( JR_FILE ) ) . '/languages/'
        );
    }

    public function init_plugin() {

        // Elementor check
        if ( ! did_action( 'elementor/loaded' ) ) {
            if ( is_admin() ) {
                add_action( 'admin_notices', function() {
                    echo '<div class="notice notice-warning">
                            <p>JR Addons requires Elementor to be installed and activated.</p>
                        </div>';
                });
            }
            return;
        }

        // Admin
        if ( is_admin() ) {
            new \JR_Addons\Admin();
        }

        // Theme
        new \JR_Addons\Theme\HeaderFooterCPT();
        new \JR_Addons\Theme\HeaderFooterRenderer();
        
        // Tools
        new \JR_Addons\Tools\Duplicator();
        if ( class_exists( '\JR_Addons\Tools\Helpers' ) ) {
            new \JR_Addons\Tools\Helpers();
        }

        // Setup
        new \JR_Addons\Setup\Assets();

        // AJAX Handlers 
        $this->init_ajax_handlers();

        // Elementor widgets
        add_action( 'elementor/init', function() {
            new \JR_Addons\Elementor\Init();
        });
    }
    private function init_ajax_handlers() {
        \JR_Addons\Ajax\SearchAjax::init();
        \JR_Addons\Ajax\CartAjax::init();
        \JR_Addons\Tools\MiniCart::init();
        \JR_Addons\Ajax\ReviewAjax::init();
        

    }

    public function activate() {
        if ( ! get_option( 'jr_installed' ) ) {
            update_option( 'jr_installed', time() );
        }
        update_option( 'jr_version', JR_VERSION );
        flush_rewrite_rules(); 
    }
}

function JR_Addons() {
    return JR_Addons::init();
}

JR_Addons();

