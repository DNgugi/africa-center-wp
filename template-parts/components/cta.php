<?php

/**
 * Call to Action Component Template
 *
 * @package headless
 */

if (!isset($settings)) {
    return;
}

$defaults = array(
    'style' => 'default', // default, split, banner
    'title' => '',
    'description' => '',
    'primary_button_text' => '',
    'primary_button_url' => '',
    'primary_button_style' => 'solid', // solid, outline
    'secondary_button_text' => '',
    'secondary_button_url' => '',
    'background_color' => 'white', // white, primary, secondary, dark
    'image' => '',
    'image_position' => 'right' // right, left (for split style)
);

$settings = wp_parse_args($settings, $defaults);

$background_classes = array(
    'white' => 'bg-white',
    'primary' => 'bg-primary-500 text-white',
    'secondary' => 'bg-secondary-500 text-white',
    'dark' => 'bg-gray-900 text-white'
);

$bg_class = isset($background_classes[$settings['background_color']]) ? $background_classes[$settings['background_color']] : $background_classes['white'];

$has_image = !empty($settings['image']) && $settings['style'] === 'split';
$image_url = $has_image ? wp_get_attachment_image_url($settings['image'], 'large') : '';
$image_side_class = $settings['image_position'] === 'left' ? 'flex-row-reverse' : 'flex-row';
?>

<div class="cta-component <?php echo esc_attr($bg_class); ?>">
    <?php if ($settings['style'] === 'split' && $has_image) : ?>
        <div class="container mx-auto">
            <div class="flex <?php echo esc_attr($image_side_class); ?> items-center">
                <div class="w-full md:w-1/2 p-8 md:p-12">
                    <?php if (!empty($settings['title'])) : ?>
                        <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold mb-4">
                            <?php echo esc_html($settings['title']); ?>
                        </h2>
                    <?php endif; ?>

                    <?php if (!empty($settings['description'])) : ?>
                        <div class="text-lg mb-6">
                            <?php echo wp_kses_post($settings['description']); ?>
                        </div>
                    <?php endif; ?>

                    <div class="flex flex-wrap gap-4">
                        <?php if (!empty($settings['primary_button_text']) && !empty($settings['primary_button_url'])) : ?>
                            <a href="<?php echo esc_url($settings['primary_button_url']); ?>"
                                class="inline-block <?php echo $settings['primary_button_style'] === 'outline' ? 'border-2 border-current hover:bg-white/10' : 'bg-white text-primary-500 hover:bg-white/90'; ?> font-semibold px-6 py-2 rounded-lg transition-colors duration-200">
                                <?php echo esc_html($settings['primary_button_text']); ?>
                            </a>
                        <?php endif; ?>

                        <?php if (!empty($settings['secondary_button_text']) && !empty($settings['secondary_button_url'])) : ?>
                            <a href="<?php echo esc_url($settings['secondary_button_url']); ?>"
                                class="inline-block border-2 border-current hover:bg-white/10 font-semibold px-6 py-2 rounded-lg transition-colors duration-200">
                                <?php echo esc_html($settings['secondary_button_text']); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="hidden md:block w-1/2">
                    <img src="<?php echo esc_url($image_url); ?>" alt="" class="w-full h-full object-cover rounded-lg">
                </div>
            </div>
        </div>
    <?php else : ?>
        <div class="container mx-auto py-12 px-4">
            <div class="max-w-3xl mx-auto text-center">
                <?php if (!empty($settings['title'])) : ?>
                    <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold mb-4">
                        <?php echo esc_html($settings['title']); ?>
                    </h2>
                <?php endif; ?>

                <?php if (!empty($settings['description'])) : ?>
                    <div class="text-lg mb-6">
                        <?php echo wp_kses_post($settings['description']); ?>
                    </div>
                <?php endif; ?>

                <div class="flex flex-wrap justify-center gap-4">
                    <?php if (!empty($settings['primary_button_text']) && !empty($settings['primary_button_url'])) : ?>
                        <a href="<?php echo esc_url($settings['primary_button_url']); ?>"
                            class="inline-block <?php echo $settings['primary_button_style'] === 'outline' ? 'border-2 border-current hover:bg-white/10' : 'bg-white text-primary-500 hover:bg-white/90'; ?> font-semibold px-6 py-2 rounded-lg transition-colors duration-200">
                            <?php echo esc_html($settings['primary_button_text']); ?>
                        </a>
                    <?php endif; ?>

                    <?php if (!empty($settings['secondary_button_text']) && !empty($settings['secondary_button_url'])) : ?>
                        <a href="<?php echo esc_url($settings['secondary_button_url']); ?>"
                            class="inline-block border-2 border-current hover:bg-white/10 font-semibold px-6 py-2 rounded-lg transition-colors duration-200">
                            <?php echo esc_html($settings['secondary_button_text']); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>