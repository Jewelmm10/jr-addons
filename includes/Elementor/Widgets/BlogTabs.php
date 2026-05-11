<?php
namespace JR_Addons\Elementor\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class BlogTabs extends Widget_Base {

    public function get_name() {
        return 'jr_blogtabs';
    }

    public function get_title() {
        return esc_html__( 'JR Blog Tabs', 'jr-addons' );
    }

    public function get_icon() {
        return 'jr-get-icon';
    }

    public function get_categories() {
        return [ 'jr-addons' ];
    }

    public function get_keywords() {
        return [ 'blog', 'posts', 'tabs', 'load more', 'jr' ];
    }

    protected function register_controls() {
        $this->start_controls_section('section_content', [
            'label' => esc_html__('Content Settings', 'jr-addons'),
        ]);

        $this->add_control('posts_per_load', [
            'label'   => 'Posts Per Load',
            'type'    => Controls_Manager::NUMBER,
            'default' => 6,
            'min'     => 1,
            'max'     => 20,
        ]);

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $categories = get_categories(['hide_empty' => true, 'orderby' => 'name']);
        $posts_per_load = absint($settings['posts_per_load'] ?? 6);
        $widget_id = $this->get_id();

        ?>
<div class="blog-wrapper jr-blog-widget" id="jr-blog-widget-<?php echo esc_attr($widget_id); ?>"
    data-widget-id="<?php echo esc_attr($widget_id); ?>" data-posts-per-load="<?php echo esc_attr($posts_per_load); ?>">

    <!-- CATEGORY FILTER BAR -->
    <div class="flex flex-wrap justify-center items-center gap-8 md:gap-12 mb-16 border-b border-[#DDD9CF]/30 pb-6 reveal active"
        style="transition-delay: 0.1s;">
        <button
            class="filter-btn font-garet text-[10px] font-bold uppercase tracking-widest text-[#8B837C] hover:text-[#1A1A1A] transition-all active"
            data-filter="all">All Articles</button>
        <?php foreach ($categories as $cat) : ?>
        <button
            class="filter-btn font-garet text-[10px] font-bold uppercase tracking-widest text-[#8B837C] hover:text-[#1A1A1A] transition-all"
            data-filter="cat-<?php echo esc_attr($cat->slug); ?>">
            <?php echo esc_html($cat->name); ?>
        </button>
        <?php endforeach; ?>
    </div>

    <!-- ARTICLE GRID -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10 reveal active" style="transition-delay: 0.2s;"
        id="jr-insights-grid-<?php echo esc_attr($widget_id); ?>">
        <?php
                $args = [
                    'post_type'      => 'post',
                    'posts_per_page' => $posts_per_load,
                    'orderby'        => 'date',
                    'order'          => 'DESC',
                ];

                $query = new \WP_Query($args);
                if ($query->have_posts()) :
                    while ($query->have_posts()) : $query->the_post();
                        $this->render_blog_card();
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
    </div>

    <!-- LOAD MORE BUTTON -->
    <div class="mt-20 text-center reveal active" id="load-more-wrapper-<?php echo esc_attr($widget_id); ?>">
        <button id="jr-load-more-<?php echo esc_attr($widget_id); ?>"
            class="inline-flex items-center gap-3 border border-[#8B837C] text-[#8B837C] px-10 py-4 rounded-full font-garet text-[10px] font-bold uppercase tracking-widest hover:bg-[#8B837C] hover:text-white transition-all transform hover:scale-105">
            Load More Articles
            <span
                class="loader hidden w-4 h-4 border-2 border-[#8B837C] border-t-transparent rounded-full animate-spin"></span>
            <iconify-icon icon="ph:plus-light" class="text-lg"></iconify-icon>
        </button>
    </div>
</div>

<?php $this->render_blog_js($widget_id, $posts_per_load); ?>
<?php
    }

    private function render_blog_card() {
        $cats = get_the_category();
        $primary_cat = !empty($cats) ? $cats[0] : null;
        $cat_name = $primary_cat ? $primary_cat->name : 'Article';
        $cat_slugs = '';
        foreach ($cats as $c) {
            $cat_slugs .= ' cat-' . $c->slug;
        }
        ?>
<div
    class="article-card bg-white rounded-[2.5rem] overflow-hidden shadow-sm border border-[#DDD9CF]/20 transition-all duration-500 hover:-translate-y-2 hover:shadow-xl <?php echo esc_attr($cat_slugs); ?>">
    <div class="h-60 overflow-hidden">
        <?php if (has_post_thumbnail()) : ?>
        <img src="<?php echo esc_url(get_the_post_thumbnail_url(null, 'medium_large')); ?>"
            alt="<?php echo esc_attr(get_the_title()); ?>"
            class="w-full h-full object-cover transition-transform duration-1000 hover:scale-110"
            onerror="this.onerror=null;this.src='https://placehold.co/600x400/1a1a1a/888?text=Image';">
        <?php else : ?>
        <img src="https://placehold.co/600x400/1a1a1a/888?text=Image" alt="<?php echo esc_attr(get_the_title()); ?>"
            class="w-full h-full object-cover">
        <?php endif; ?>
    </div>
    <div class="p-10">
        <span class="font-garet text-[9px] font-bold uppercase tracking-widest text-warm-green mb-4 block">
            <?php echo esc_html($cat_name); ?>
        </span>
        <h3 class="font-roboto font-semibold text-xl leading-snug mb-4 text-dark">
            <a href="<?php the_permalink(); ?>" class="hover:text-[#D4A373] transition-colors">
                <?php the_title(); ?>
            </a>
        </h3>
        <p class="font-roboto text-[13px] text-[#8B837C] leading-relaxed mb-8 font-light line-clamp-2">
            <?php echo wp_trim_words(get_the_excerpt() ?: get_the_content(), 20); ?>
        </p>
        <a href="<?php the_permalink(); ?>"
            class="inline-flex items-center gap-2 text-[#1A1A1A] font-garet text-[10px] font-bold uppercase tracking-widest group">
            Read Article
            <iconify-icon icon="ph:arrow-right-light" class="text-lg transition-transform arrow-wiggle"></iconify-icon>
        </a>
    </div>
</div>
<?php
    }

    private function render_blog_js($widget_id, $posts_per_load) {
        $ajax_url = admin_url('admin-ajax.php');
        $nonce    = wp_create_nonce('jr_blog_nonce');
        ?>
<script>
(function() {
    const widgetId = '<?php echo esc_js($widget_id); ?>';
    const container = document.getElementById('jr-blog-widget-' + widgetId);
    if (!container) return;

    const grid = document.getElementById('jr-insights-grid-' + widgetId);
    const loadMoreBtn = document.getElementById('jr-load-more-' + widgetId);
    const tabs = container.querySelectorAll('.filter-btn');
    let currentFilter = 'all';
    let currentOffset = <?php echo (int) $posts_per_load; ?>;

    function showLoader() {
        const loader = loadMoreBtn.querySelector('.loader');
        if (loader) loader.classList.remove('hidden');
        loadMoreBtn.disabled = true;
    }

    function hideLoader() {
        const loader = loadMoreBtn.querySelector('.loader');
        if (loader) loader.classList.add('hidden');
        loadMoreBtn.disabled = false;
    }

    function loadPosts(filter, offset, append = false) {
        showLoader();

        const formData = new FormData();
        formData.append('action', 'jr_blog_filter');
        formData.append('filter', filter);
        formData.append('offset', offset);
        formData.append('posts_per_load', <?php echo (int) $posts_per_load; ?>);
        formData.append('nonce', '<?php echo $nonce; ?>');

        fetch('<?php echo esc_url($ajax_url); ?>', {
                method: 'POST',
                body: formData
            })
            .then(res => res.text())
            .then(html => {
                if (!append) {
                    grid.innerHTML = html ||
                        '<p class="col-span-full text-center py-10 text-[#8B837C]">No articles found in this category.</p>';
                } else if (html.trim() !== '') {
                    grid.insertAdjacentHTML('beforeend', html);
                }

                currentOffset = offset + <?php echo (int) $posts_per_load; ?>;

                const returnedCount = (html.match(/class="article-card/g) || []).length;
                if (!append || html.trim() === '' || returnedCount < <?php echo (int) $posts_per_load; ?>) {
                    loadMoreBtn.style.display = 'none';
                } else {
                    loadMoreBtn.style.display = 'inline-flex';
                }

                hideLoader();
            })
            .catch(() => {
                hideLoader();
                if (!append) {
                    grid.innerHTML =
                        '<p class="col-span-full text-center text-red-500">Failed to load articles. Please try again.</p>';
                }
            });
    }

    // Tab Click Handler
    tabs.forEach(btn => {
        btn.addEventListener('click', () => {
            tabs.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            currentFilter = btn.getAttribute('data-filter');
            currentOffset = <?php echo (int) $posts_per_load; ?>;
            loadPosts(currentFilter, 0, false);
        });
    });

    // Load More Handler
    loadMoreBtn.addEventListener('click', () => {
        loadPosts(currentFilter, currentOffset, true);
    });

    // Initial visibility check
    if (grid.children.length < <?php echo (int) $posts_per_load; ?>) {
        loadMoreBtn.style.display = 'none';
    }
})();
</script>

<style>
.filter-btn.active {
    color: #1A1A1A !important;
    position: relative;
}

.filter-btn.active:after {
    content: '';
    position: absolute;
    bottom: -7px;
    left: 50%;
    transform: translateX(-50%);
    width: 6px;
    height: 6px;
    background: #8B837C;
    border-radius: 50%;
}

.article-card:hover .arrow-wiggle {
    transform: translateX(4px);
}
</style>
<?php
    }
}