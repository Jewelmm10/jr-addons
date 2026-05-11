<?php
namespace JR_Addons\Elementor\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class Blog extends Widget_Base {

	public function get_name() {
		return 'jr_blog';
	}

	public function get_title() {
		return esc_html__( 'JR Blog', 'jr-addons' );
	}

	public function get_icon() {
        return 'jr-get-icon';
    }

	public function get_categories() {
		return [ 'jr-addons' ];
	}

	public function get_keywords() {
		return [ 'blog', 'posts', 'jr' ];
	}

    protected function register_controls() {
        $this->start_controls_section('section_content', [
            'label' => esc_html__('Content Settings', 'jr-addons'),
        ]);

        $this->add_control('section_title', [
            'label' => 'Section Title',
            'type' => Controls_Manager::TEXT,
            'default' => 'Latest Insights',
        ]);

        $this->add_control('posts_per_page', [
            'label' => 'Total Posts',
            'type' => Controls_Manager::NUMBER,
            'default' => 6,
        ]);

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $categories = get_categories(['hide_empty' => true]);
        ?>

        <div class="jr-insights-container">
            <div class="flex flex-col md:flex-row justify-between items-baseline mb-12 border-b border-gray-200 pb-4">
                <h2 class="text-5xl font-bold text-[#333] tracking-tight mb-6 md:mb-0">
                    <?php echo esc_html($settings['section_title']); ?>
                </h2>

                <nav class="flex flex-wrap gap-6 text-[11px] font-bold uppercase tracking-[0.2em] text-gray-400">
                    <button class="insight-tab-btn active text-[#333] border-b-2 border-[#de7f2d] pb-1" data-filter="all">All</button>
                    <?php foreach($categories as $cat): ?>
                        <button class="insight-tab-btn hover:text-[#333] transition-colors pb-1" data-filter="cat-<?php echo $cat->slug; ?>">
                            <?php echo esc_html($cat->name); ?>
                        </button>
                    <?php endforeach; ?>
                </nav>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10" id="jr-insights-grid">
                <?php
                $args = [
                    'post_type' => 'post',
                    'posts_per_page' => $settings['posts_per_page'],
                ];
                $query = new \WP_Query($args);

                if ($query->have_posts()) :
                    while ($query->have_posts()) : $query->the_post();
                        $cats = get_the_category();
                        $cat_slugs = '';
                        $cat_name = !empty($cats) ? $cats[0]->name : 'Uncategorized';
                        foreach($cats as $c) { $cat_slugs .= ' cat-' . $c->slug; }
                        ?>
                        
                        <article class="group cursor-pointer reveal-on-scroll <?php echo esc_attr($cat_slugs); ?>">
                            <div class="relative aspect-[4/3] rounded-[2.5rem] overflow-hidden mb-6">
                                <?php if(has_post_thumbnail()): ?>
                                    <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>"  alt="<?php echo esc_attr( get_the_title() ); ?>"
                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                         
                                <?php endif; ?>
                                <span class="absolute top-6 left-6 bg-[#D4A373] text-white text-[9px] font-bold uppercase px-3 py-1 rounded-md tracking-widest">
                                    <?php echo esc_html($cat_name); ?>
                                </span>
                            </div>
                            
                            <h3 class="text-2xl font-bold text-[#333] mb-3 leading-tight hover:text-[#D4A373] transition-colors">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                            <p class="text-gray-500 text-sm leading-relaxed line-clamp-2">
                                <?php echo wp_trim_words(get_the_excerpt(), 15); ?>
                            </p>
                        </article>

                        <?php
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </div>
        </div>

        <script>
        document.querySelectorAll('.insight-tab-btn').forEach(button => {
            button.addEventListener('click', () => {
                const filter = button.getAttribute('data-filter');
                
                // Toggle Active Class
                document.querySelectorAll('.insight-tab-btn').forEach(btn => btn.classList.remove('active', 'text-[#333]', 'border-b-2', 'border-[#D4A373]'));
                button.classList.add('active', 'text-[#333]', 'border-b-2', 'border-[#D4A373]');

                // Filtering Logic
                const cards = document.querySelectorAll('.insight-card');
                cards.forEach(card => {
                    if (filter === 'all' || card.classList.contains(filter)) {
                        card.style.display = 'block';
                        setTimeout(() => card.style.opacity = '1', 10);
                    } else {
                        card.style.opacity = '0';
                        setTimeout(() => card.style.display = 'none', 300);
                    }
                });
            });
        });
        </script>

        <style>
            .insight-card { transition: opacity 0.3s ease, transform 0.3s ease; }
            .insight-tab-btn { cursor: pointer; border-bottom: 2px solid transparent; transition: all 0.3s; }
        </style>

        <?php
    }
}