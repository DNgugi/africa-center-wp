<?php

/**
 * Stats Component Template
 *
 * @package headless
 */

if (!isset($settings)) {
    return;
}

$defaults = array(
    'title' => '',
    'description' => '',
    'stats' => array(),
    'layout' => 'grid', // grid, columns
    'background_color' => 'white', // white, light, primary, dark
    'animation' => true
);

$settings = wp_parse_args($settings, $defaults);

$background_classes = array(
    'white' => 'bg-white',
    'light' => 'bg-gray-50',
    'primary' => 'bg-primary-500 text-white',
    'dark' => 'bg-gray-900 text-white'
);

$bg_class = isset($background_classes[$settings['background_color']]) ? $background_classes[$settings['background_color']] : $background_classes['white'];

$layout_class = $settings['layout'] === 'columns' ? 'flex-col md:flex-row' : 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8';
?>

<div class="stats-component <?php echo esc_attr($bg_class); ?> py-16">
    <div class="container mx-auto px-4">
        <?php if (!empty($settings['title']) || !empty($settings['description'])) : ?>
            <div class="text-center mb-12">
                <?php if (!empty($settings['title'])) : ?>
                    <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold mb-4">
                        <?php echo esc_html($settings['title']); ?>
                    </h2>
                <?php endif; ?>

                <?php if (!empty($settings['description'])) : ?>
                    <div class="text-lg max-w-3xl mx-auto">
                        <?php echo wp_kses_post($settings['description']); ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($settings['stats'])) : ?>
            <div class="flex <?php echo esc_attr($layout_class); ?> justify-center items-center">
                <?php foreach ($settings['stats'] as $stat) : ?>
                    <div class="text-center p-6">
                        <?php if (!empty($stat['prefix'])) : ?>
                            <span class="text-4xl md:text-5xl font-bold"><?php echo esc_html($stat['prefix']); ?></span>
                        <?php endif; ?>

                        <span class="stats-number text-4xl md:text-5xl font-bold"
                            <?php if ($settings['animation']) : ?>
                            data-value="<?php echo esc_attr($stat['value']); ?>"
                            data-suffix="<?php echo esc_attr($stat['suffix'] ?? ''); ?>"
                            <?php else : ?>>
                            <?php echo esc_html($stat['value'] . ($stat['suffix'] ?? '')); ?>
                        <?php endif; ?></span>

                        <?php if (!empty($stat['label'])) : ?>
                            <p class="text-lg mt-2"><?php echo esc_html($stat['label']); ?></p>
                        <?php endif; ?>

                        <?php if (!empty($stat['description'])) : ?>
                            <p class="text-sm mt-1 opacity-75"><?php echo esc_html($stat['description']); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php if ($settings['animation']) : ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const stats = document.querySelectorAll('.stats-number[data-value]');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const el = entry.target;
                        const value = parseInt(el.dataset.value);
                        const suffix = el.dataset.suffix || '';
                        let current = 0;
                        const increment = value / 50;
                        const duration = 2000;
                        const interval = duration / 50;

                        const counter = setInterval(() => {
                            current += increment;
                            if (current >= value) {
                                el.textContent = value + suffix;
                                clearInterval(counter);
                            } else {
                                el.textContent = Math.floor(current) + suffix;
                            }
                        }, interval);

                        observer.unobserve(el);
                    }
                });
            }, {
                threshold: 0.5
            });

            stats.forEach(stat => observer.observe(stat));
        });
    </script>
<?php endif; ?>