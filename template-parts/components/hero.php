<?php

/**
 * Hero Component
 *
 * @package headless
 */

if (!isset($settings)) {
    return;
}

$classes = headless_component_renderer()->get_component_classes($settings);
$style = headless_component_renderer()->get_style_output($settings);
?>

<section class="relative bg-pattern-lines text-white py-20 lg:py-28 overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-r from-primary-blue to-secondary-burgundy opacity-95"></div>
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-3xl mx-auto lg:mx-0">
            <?php if (!empty($args['subtitle'])) : ?>
                <div class="inline-block bg-primary-terracotta px-4 py-1 rounded-full text-sm font-medium mb-6">
                    <?php echo esc_html($args['subtitle']); ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($args['title'])) : ?>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 font-heading">
                    <?php echo wp_kses_post($args['title']); ?>
                </h1>
            <?php endif; ?>

            <?php if (!empty($args['description'])) : ?>
                <p class="text-xl mb-8 text-white/90">
                    <?php echo esc_html($args['description']); ?>
                </p>
            <?php endif; ?>

            <div class="flex flex-wrap gap-4">
                <?php if (!empty($args['cta_primary'])) : ?>
                    <a href="<?php echo esc_url($args['cta_primary']['url']); ?>"
                        class="<?php echo esc_attr($args['cta_primary']['class']); ?>">
                        <?php echo esc_html($args['cta_primary']['text']); ?>
                    </a>
                <?php endif; ?>

                <?php if (!empty($args['cta_secondary'])) : ?>
                    <a href="<?php echo esc_url($args['cta_secondary']['url']); ?>"
                        class="<?php echo esc_attr($args['cta_secondary']['class']); ?>">
                        <?php echo esc_html($args['cta_secondary']['text']); ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Decorative elements -->
    <div class="hidden lg:block absolute -right-16 -top-16 w-64 h-64 rounded-full bg-primary-terracotta opacity-20"></div>
    <div class="hidden lg:block absolute right-1/4 bottom-0 w-32 h-32 rounded-full bg-primary-ochre opacity-20"></div>
</section>