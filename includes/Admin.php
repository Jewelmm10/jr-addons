<?php

namespace JR_Addons;

if (!defined('ABSPATH')) exit;

class Admin {

    public function __construct() {
        add_action('admin_menu', [$this, 'menu']);
        add_action('wp_ajax_jr_save_widgets', [$this, 'save_widgets']);
        add_action('admin_init', [$this, 'register_settings']);
    }

    public function menu() {

        add_menu_page(
            'JR Addons',
            'JR Addons',
            'manage_options',
            'jr-addons',
            [$this, 'page'],
            'dashicons-screenoptions',
            20
        );

        // Widgets submenu
        add_submenu_page(
            'jr-addons',
            'Widget Manager',
            'Widgets',
            'manage_options',
            'jr-addons',
            [$this, 'page']
        );

        // Theme Builder submenu
        add_submenu_page(
            'jr-addons',
            'Theme Builder',
            'Theme Builder',
            'manage_options',
            'edit.php?post_type=jr_template'
        );
    }

    public function register_settings() {

        register_setting('general', 'jr_enable_icons');

        add_settings_field(
            'jr_enable_icons',
            'Enable JR Icons',
            [$this, 'icons_field_html'],
            'general'
        );
    }
    public function icons_field_html() {

        $value = get_option('jr_enable_icons', 'yes');
        ?>

        <label>
            <input type="checkbox" 
                name="jr_enable_icons" 
                value="yes" 
                <?php checked($value, 'yes'); ?>>
            Enable Custom Icon Pack
        </label>

        <?php
    }
    public function page() {

        $init     = new \JR_Addons\Elementor\Init();
        $widgets  = $init->get_widgets_list();

        $enabled = is_multisite()
            ? get_site_option('jr_enabled_widgets', [])
            : get_option('jr_enabled_widgets', []);

        $total_widgets = 0;
        foreach ($widgets as $group) {
            $total_widgets += count($group);
        }

        $enabled_count = count($enabled);
        ?>

        <div class="wrap">
            <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-200">

                <!-- Header -->
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-800">
                            JR Addons
                        </h1>
                        <p class="text-sm text-gray-500 mt-1">
                            Control and manage your Elementor widgets.
                        </p>
                    </div>

                    <div class="text-sm text-gray-600 bg-gray-100 px-4 py-2 rounded-lg">
                        <?php echo esc_html($enabled_count); ?> / 
                        <?php echo esc_html($total_widgets); ?> Enabled
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-3 mb-8">
                    <button type="button"
                        class="enable-all cursor-pointer px-4 py-2 text-sm font-medium bg-green-600 hover:bg-green-700 text-white rounded-lg transition">
                        Enable All
                    </button>

                    <button type="button"
                        class="disable-all cursor-pointer px-4 py-2 text-sm font-medium bg-red-600 hover:bg-red-700 text-white rounded-lg transition">
                        Disable All
                    </button>

                    <button type="button"
                        class="save-widgets cursor-pointer px-5 py-2 text-sm font-medium bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition shadow">
                        Save Changes
                    </button>
                </div>

                <!-- Widget Groups -->
                <?php foreach ($widgets as $group_name => $group): ?>

                    <div class="mb-10">

                        <h2 class="text-lg font-semibold text-gray-700 mb-4 border-b border-gray-200 pb-2">
                            <?php echo esc_html($group_name); ?>
                        </h2>

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

                            <?php foreach ($group as $key => $class): ?>

                                <div class="flex items-center justify-between bg-gray-50 px-4 py-3 rounded-lg border border-gray-200 hover:bg-gray-100 transition">

                                    <span class="text-sm font-medium text-gray-700">
                                        <?php echo esc_html(ucfirst($key)); ?>
                                    </span>

                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox"
                                            value="<?php echo esc_attr($key); ?>"
                                            class="sr-only peer"
                                            <?php checked(in_array($key, $enabled)); ?>>

                                        <div class="w-11 h-6 bg-gray-300 rounded-full peer 
                                                    peer-checked:bg-blue-600 
                                                    after:content-[''] after:absolute after:top-0.5 after:left-[2px]
                                                    after:bg-white after:border after:rounded-full after:h-5 after:w-5
                                                    after:transition-all
                                                    peer-checked:after:translate-x-full">
                                        </div>
                                    </label>

                                </div>

                            <?php endforeach; ?>

                        </div>

                    </div>

                <?php endforeach; ?>

            </div>
        </div>

        <?php
    }

    public function save_widgets() {

        check_ajax_referer('jr_admin_nonce', 'nonce');

        $widgets = $_POST['widgets'] ?? [];

        if (is_multisite()) {
            update_site_option('jr_enabled_widgets', $widgets);
        } else {
            update_option('jr_enabled_widgets', $widgets);
        }

        wp_send_json_success([
            'message' => 'Settings Saved Successfully'
        ]);
    }
}