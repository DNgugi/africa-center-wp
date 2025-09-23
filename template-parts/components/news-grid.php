<?php

/**
 * News/Blog Grid Component
 *
 * @package headless
 */

if (!isset($settings)) {
    return;
}

$classes = headless_component_renderer()->get_component_classes($settings);
$style = headless_component_renderer()->get_style_output($settings);

$posts = isset($settings['posts']) ? $settings['posts'] : array();
$layout = isset($settings['layout_style']) ? $settings['layout_style'] : 'grid';
$show_filters = isset($settings['show_filters']) ? $settings['show_filters'] : false;
$show_categories = isset($settings['show_categories']) ? $settings['show_categories'] : true;
$show_excerpt = isset($settings['show_excerpt']) ? $settings['show_excerpt'] : true;
$excerpt_length = isset($settings['excerpt_length']) ? $settings['excerpt_length'] : 20;

// Collect categories for filtering
$categories = array();
if ($show_filters && !empty($posts)) {
    foreach ($posts as $post) {
        if (!empty($post['categories'])) {
            $categories = array_merge($categories, $post['categories']);
        }
    }
    $categories = array_unique($categories);
}
?>

<section class="news-grid-section <?php echo esc_attr($classes); ?>" <?php echo $style; ?>>
    <div class="container mx-auto px-4">
        <?php if (!empty($settings['title'])) : ?>
            <h2 class="text-3xl md:text-4xl font-bold text-center mb-8">
                <?php echo esc_html($settings['title']); ?>
            </h2>
        <?php endif; ?>

        <?php if (!empty($settings['description'])) : ?>
            <div class="max-w-3xl mx-auto text-center text-lg mb-12">
                <?php echo wp_kses_post($settings['description']); ?>
            </div>
        <?php endif; ?>

        <?php if ($show_filters && !empty($categories)) : ?>
            <div class="flex flex-wrap justify-center gap-4 mb-12">
                <button class="filter-button active px-6 py-2 rounded-full bg-primary-600 text-white"
                    data-filter="all">
                    <?php esc_html_e('All Posts', 'headless'); ?>
                </button>
                <?php foreach ($categories as $category) : ?>
                    <button class="filter-button px-6 py-2 rounded-full bg-gray-200 hover:bg-primary-600 hover:text-white transition-colors"
                        data-filter="<?php echo esc_attr($category); ?>">
                        <?php echo esc_html($category); ?>
                    </button>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
            <?php foreach ($posts as $post) : ?>
                <article class="blog-post bg-white rounded-lg shadow-lg overflow-hidden"
                    <?php if (!empty($post['categories'])) : ?>
                    data-categories="<?php echo esc_attr(implode(' ', $post['categories'])); ?>"
                    <?php endif; ?>>
                    <?php if (!empty($post['image'])) : ?>
                        <div class="aspect-video relative overflow-hidden">
                            <a href="<?php echo esc_url($post['url']); ?>" class="block w-full h-full">
                                <?php echo wp_get_attachment_image($post['image'], 'medium_large', false, array(
                                    'class' => 'w-full h-full object-cover transition-transform duration-300 hover:scale-110',
                                )); ?>
                            </a>
                            <?php if ($show_categories && !empty($post['categories'])) : ?>
                                <div class="absolute top-4 right-4 flex flex-wrap gap-2">
                                    <?php foreach ($post['categories'] as $category) : ?>
                                        <span class="bg-primary-600 text-white px-3 py-1 rounded-full text-sm">
                                            <?php echo esc_html($category); ?>
                                        </span>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <div class="p-6">
                        <?php if (!empty($post['date'])) : ?>
                            <div class="text-gray-600 text-sm mb-3">
                                <?php echo esc_html(date_i18n(get_option('date_format'), strtotime($post['date']))); ?>
                            </div>
                        <?php endif; ?>

                        <h3 class="text-xl font-bold mb-4">
                            <a href="<?php echo esc_url($post['url']); ?>"
                                class="hover:text-primary-600 transition-colors">
                                <?php echo esc_html($post['title']); ?>
                            </a>
                        </h3>

                        <?php if ($show_excerpt && !empty($post['excerpt'])) : ?>
                            <div class="text-gray-600 mb-6">
                                <?php echo wp_trim_words($post['excerpt'], $excerpt_length); ?>
                            </div>
                        <?php endif; ?>

                        <div class="flex items-center justify-between">
                            <?php if (!empty($post['author'])) : ?>
                                <div class="flex items-center gap-3">
                                    <?php if (!empty($post['author_avatar'])) : ?>
                                        <div class="w-8 h-8 rounded-full overflow-hidden">
                                            <?php echo wp_get_attachment_image($post['author_avatar'], 'thumbnail', false, array(
                                                'class' => 'w-full h-full object-cover',
                                            )); ?>
                                        </div>
                                    <?php endif; ?>
                                    <span class="text-gray-600 text-sm">
                                        <?php echo esc_html($post['author']); ?>
                                    </span>
                                </div>
                            <?php endif; ?>

                            <a href="<?php echo esc_url($post['url']); ?>"
                                class="text-primary-600 hover:text-primary-700 transition-colors">
                                <?php esc_html_e('Read More', 'headless'); ?>
                                <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>

        <?php if (!empty($settings['show_pagination']) && !empty($settings['pagination'])) : ?>
            <div class="mt-12 flex justify-center">
                <?php echo wp_kses_post($settings['pagination']); ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php if ($show_filters) : ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterButtons = document.querySelectorAll('.filter-button');
            const posts = document.querySelectorAll('.blog-post');

            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const filter = this.dataset.filter;

                    filterButtons.forEach(btn => btn.classList.remove('active', 'bg-primary-600', 'text-white'));
                    this.classList.add('active', 'bg-primary-600', 'text-white');

                    posts.forEach(post => {
                        const categories = post.dataset.categories ? post.dataset.categories.split(' ') : [];
                        if (filter === 'all' || categories.includes(filter)) {
                            post.style.display = 'block';
                        } else {
                            post.style.display = 'none';
                        }
                    });
                });
            });
        });
    </script>
<?php endif; ?>