<?php

namespace JR_Addons\Elementor;

if (!defined('ABSPATH')) {
    exit;
}

class Init {

    public function __construct() {
        add_action('elementor/widgets/register', [$this, 'register_widgets']);
        add_action('elementor/elements/categories_registered', [$this, 'add_category']);
    }

    /**
     *   All Widgets Master List
     */
    public function get_widgets_list() {
        return [

            'General' => [
                'Hero'      => \JR_Addons\Elementor\Widgets\Hero::class,
                'Logo'      => \JR_Addons\Elementor\Widgets\Logo::class,
                'Icon Box'   => \JR_Addons\Elementor\Widgets\IconBox::class,
                'Accordion' => \JR_Addons\Elementor\Widgets\Accordion::class,
                'Slider'    => \JR_Addons\Elementor\Widgets\Slider::class,
                'Section Title' => \JR_Addons\Elementor\Widgets\Section_Title::class,
            ],
            'Header' => [
                'Site Logo' => \JR_Addons\Elementor\Widgets\SiteLogo::class,
                'Nav Menu'  => \JR_Addons\Elementor\Widgets\NavMenu::class,
                'Search' => \JR_Addons\Elementor\Widgets\Search::class,
            ],

            'Blog' => [
                'Blog'     => \JR_Addons\Elementor\Widgets\Blog::class,
                'Blog Tabs' => \JR_Addons\Elementor\Widgets\BlogTabs::class,
            ],

            'Forms' => [
                'CF7'        => \JR_Addons\Elementor\Widgets\Cf7::class,
                'Submit Form' => \JR_Addons\Elementor\Widgets\SubmitForm::class,
            ],
            'WooCommerce' => [
                'Cart'                  => \JR_Addons\Elementor\Widgets\Cart::class,
                'Header Icons'          => \JR_Addons\Elementor\Widgets\HeaderIcons::class,
                'Top Selling'           => \JR_Addons\Elementor\Widgets\TopSelling::class,
                'Product Carousel'      => \JR_Addons\Elementor\Widgets\ProductCarousel::class,
                'Category Carousel'     => \JR_Addons\Elementor\Widgets\Category_Carousel::class,
                'Product Title'         => \JR_Addons\Elementor\Widgets\SingleProduct\Product_Title::class,
                'Product Price'         => \JR_Addons\Elementor\Widgets\SingleProduct\Product_Price::class,
                'Product Image'         => \JR_Addons\Elementor\Widgets\SingleProduct\Product_Image::class,
                'Product Actions'       => \JR_Addons\Elementor\Widgets\SingleProduct\Product_Action_Buttons::class,
                'Add To Cart'           => \JR_Addons\Elementor\Widgets\SingleProduct\Product_Add_To_Cart::class,
                'Product Gallery'       => \JR_Addons\Elementor\Widgets\SingleProduct\Product_Gallery::class,
                'Product Short Description' => \JR_Addons\Elementor\Widgets\SingleProduct\Product_Short_Description::class,
                'Product Description'   => \JR_Addons\Elementor\Widgets\SingleProduct\Product_Description::class,
                'Product Reviews'       => \JR_Addons\Elementor\Widgets\SingleProduct\Product_Reviews::class,
                'Related Products'      => \JR_Addons\Elementor\Widgets\SingleProduct\Product_Related::class,

            ],

            'Advanced' => [
                'Insurance'   => \JR_Addons\Elementor\Widgets\Insurance::class,
                'Counting'    => \JR_Addons\Elementor\Widgets\Counting::class,
                'Accordion'   => \JR_Addons\Elementor\Widgets\AdAccordion::class,
                
            ],
        ];
    }

    /**
     *  Register Only Enabled Widgets
     */
    public function register_widgets($widgets_manager) {

        $enabled = is_multisite()
            ? get_site_option('jr_enabled_widgets', [])
            : get_option('jr_enabled_widgets', []);

        $all = $this->get_widgets_list();

        foreach ($all as $group) {
            foreach ($group as $key => $class) {

                if (!empty($enabled) && !in_array($key, $enabled)) {
                    continue;
                }

                if (class_exists($class)) {
                    $widgets_manager->register(new $class());
                }
            }
        }
    }

    public function add_category($elements_manager) {
        $elements_manager->add_category(
            'jr-addons',
            [
                'title' => esc_html__('JR Addons', 'jr-addons'),
            ]
        );
        $elements_manager->add_category(
            'jr-wc',
            [
                'title' => esc_html__('JR WooCommerce', 'jr-addons'),
            ]
        );
    }
}