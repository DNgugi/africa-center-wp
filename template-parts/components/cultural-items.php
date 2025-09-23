<?php

/**
 * Cultural Items Grid Component
 *
 * @package headless
 */

if (!isset($settings)) {
    return;
}

$classes = headless_component_renderer()->get_component_classes($settings);
$style = headless_component_renderer()->get_style_output($settings);

$items = isset($settings['items']) ? $settings['items'] : array();
$layout = isset($settings['layout_style']) ? $settings['layout_style'] : 'grid';
$show_filters = isset($settings['show_filters']) ? $settings['show_filters'] : false;
$masonry = isset($settings['masonry']) ? $settings['masonry'] : false;

// Collect categories for filtering
$categories = array();
if ($show_filters && !empty($items)) {
    foreach ($items as $item) {
        if (!empty($item['category'])) {
            $categories[] = $item['category'];
        }
    }
    $categories = array_unique($categories);
}

$grid_class = $masonry ? 'columns-1 md:columns-2 lg:columns-3 gap-8' : 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8';
?>

<section class="cultural-items-section <?php echo esc_attr($classes); ?>" <?php echo $style; ?>>
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
                    <?php esc_html_e('All Items', 'headless'); ?>
                </button>
                <?php foreach ($categories as $category) : ?>
                    <button class="filter-button px-6 py-2 rounded-full bg-gray-200 hover:bg-primary-600 hover:text-white transition-colors"
                        data-filter="<?php echo esc_attr($category); ?>">
                        <?php echo esc_html($category); ?>
                    </button>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="<?php echo esc_attr($grid_class); ?>">
            <?php foreach ($items as $item) : ?>
                <?php
                $item_classes = array(
                    'cultural-item',
                    'bg-white',
                    'rounded-lg',
                    'overflow-hidden',
                    'shadow-lg',
                    $masonry ? 'mb-8 break-inside-avoid' : '',
                );
                ?>
                <div class="<?php echo esc_attr(implode(' ', array_filter($item_classes))); ?>"
                    <?php if (!empty($item['category'])) : ?>
                    data-category="<?php echo esc_attr($item['category']); ?>"
                    <?php endif; ?>>
                    <?php if (!empty($item['image'])) : ?>
                        <div class="aspect-square relative overflow-hidden">
                            <?php echo wp_get_attachment_image($item['image'], 'large', false, array(
                                'class' => 'w-full h-full object-cover transition-transform duration-300 hover:scale-110',
                            )); ?>
                            <?php if (!empty($item['category'])) : ?>
                                <div class="absolute top-4 right-4 bg-primary-600 text-white px-4 py-2 rounded-lg">
                                    <?php echo esc_html($item['category']); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-4">
                            <?php echo esc_html($item['title']); ?>
                        </h3>

                        <?php if (!empty($item['origin'])) : ?>
                            <div class="flex items-center gap-2 text-gray-600 mb-4">
                                <i class="fas fa-globe-africa"></i>
                                <span><?php echo esc_html($item['origin']); ?></span>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($item['description'])) : ?>
                            <div class="text-gray-600 mb-6">
                                <?php echo wp_kses_post($item['description']); ?>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($item['attributes'])) : ?>
                            <div class="border-t border-gray-200 pt-4 mt-4">
                                <?php foreach ($item['attributes'] as $label => $value) : ?>
                                    <div class="flex justify-between text-sm mb-2">
                                        <span class="text-gray-600"><?php echo esc_html($label); ?>:</span>
                                        <span class="font-medium"><?php echo esc_html($value); ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($item['button_url'])) : ?>
                            <div class="mt-6">
                                <a href="<?php echo esc_url($item['button_url']); ?>"
                                    class="inline-block px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                                    <?php echo esc_html($item['button_text'] ?? __('Learn More', 'headless')); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php if ($show_filters) : ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterButtons = document.querySelectorAll('.filter-button');
            const items = document.querySelectorAll('.cultural-item');

            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const filter = this.dataset.filter;

                    filterButtons.forEach(btn => btn.classList.remove('active', 'bg-primary-600', 'text-white'));
                    this.classList.add('active', 'bg-primary-600', 'text-white');

                    items.forEach(item => {
                        if (filter === 'all' || item.dataset.category === filter) {
                            item.style.display = 'block';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                });
            });
        });
    </script>
<?php endif; ?>