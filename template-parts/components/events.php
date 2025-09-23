<?php

/**
 * Events Component
 *
 * @package headless
 */

if (!isset($settings)) {
    return;
}

$classes = headless_component_renderer()->get_component_classes($settings);
$style = headless_component_renderer()->get_style_output($settings);

$events = isset($settings['events']) ? $settings['events'] : array();
$layout = isset($settings['layout_style']) ? $settings['layout_style'] : 'grid';
$show_filters = isset($settings['show_filters']) ? $settings['show_filters'] : false;

$categories = array();
if ($show_filters && !empty($events)) {
    foreach ($events as $event) {
        if (!empty($event['category'])) {
            $categories[] = $event['category'];
        }
    }
    $categories = array_unique($categories);
}
?>

<section class="events-section <?php echo esc_attr($classes); ?>" <?php echo $style; ?>>
    <div class="container mx-auto px-4">
        <?php if (!empty($settings['title'])) : ?>
            <h2 class="text-3xl md:text-4xl font-bold text-center mb-8">
                <?php echo esc_html($settings['title']); ?>
            </h2>
        <?php endif; ?>

        <?php if ($show_filters && !empty($categories)) : ?>
            <div class="flex flex-wrap justify-center gap-4 mb-12">
                <button class="filter-button active px-6 py-2 rounded-full bg-primary-600 text-white"
                    data-filter="all">
                    <?php esc_html_e('All Events', 'headless'); ?>
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
            <?php foreach ($events as $event) : ?>
                <div class="event-card bg-white rounded-lg shadow-lg overflow-hidden"
                    <?php if (!empty($event['category'])) : ?>
                    data-category="<?php echo esc_attr($event['category']); ?>"
                    <?php endif; ?>>
                    <?php if (!empty($event['image'])) : ?>
                        <div class="aspect-video relative overflow-hidden">
                            <?php echo wp_get_attachment_image($event['image'], 'medium_large', false, array(
                                'class' => 'w-full h-full object-cover',
                            )); ?>
                            <?php if (!empty($event['date'])) : ?>
                                <div class="absolute top-4 right-4 bg-primary-600 text-white px-4 py-2 rounded-lg">
                                    <?php echo esc_html(date_i18n(get_option('date_format'), strtotime($event['date']))); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <div class="p-6">
                        <?php if (!empty($event['category'])) : ?>
                            <div class="text-primary-600 text-sm font-semibold mb-2">
                                <?php echo esc_html($event['category']); ?>
                            </div>
                        <?php endif; ?>

                        <h3 class="text-xl font-bold mb-4">
                            <?php echo esc_html($event['title']); ?>
                        </h3>

                        <?php if (!empty($event['time']) || !empty($event['location'])) : ?>
                            <div class="flex items-center gap-6 text-gray-600 mb-4">
                                <?php if (!empty($event['time'])) : ?>
                                    <div class="flex items-center gap-2">
                                        <i class="far fa-clock"></i>
                                        <span><?php echo esc_html($event['time']); ?></span>
                                    </div>
                                <?php endif; ?>

                                <?php if (!empty($event['location'])) : ?>
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <span><?php echo esc_html($event['location']); ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($event['description'])) : ?>
                            <div class="text-gray-600 mb-6">
                                <?php echo wp_kses_post($event['description']); ?>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($event['button_url'])) : ?>
                            <a href="<?php echo esc_url($event['button_url']); ?>"
                                class="inline-block px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                                <?php echo esc_html($event['button_text'] ?? __('Learn More', 'headless')); ?>
                            </a>
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
            const eventCards = document.querySelectorAll('.event-card');

            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const filter = this.dataset.filter;

                    filterButtons.forEach(btn => btn.classList.remove('active', 'bg-primary-600', 'text-white'));
                    this.classList.add('active', 'bg-primary-600', 'text-white');

                    eventCards.forEach(card => {
                        if (filter === 'all' || card.dataset.category === filter) {
                            card.style.display = 'block';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                });
            });
        });
    </script>
<?php endif; ?>