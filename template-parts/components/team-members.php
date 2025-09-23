<?php

/**
 * Team Members Component
 *
 * @package headless
 */

if (!isset($settings)) {
    return;
}

$classes = headless_component_renderer()->get_component_classes($settings);
$style = headless_component_renderer()->get_style_output($settings);

$team_members = isset($settings['team_members']) ? $settings['team_members'] : array();
$layout = isset($settings['layout_style']) ? $settings['layout_style'] : 'grid';
$columns = isset($settings['columns']) ? $settings['columns'] : 3;

$grid_classes = array(
    1 => '',
    2 => 'md:grid-cols-2',
    3 => 'md:grid-cols-2 lg:grid-cols-3',
    4 => 'md:grid-cols-2 lg:grid-cols-4',
);

$layout_classes = array(
    'grid' => 'grid gap-8 ' . ($grid_classes[$columns] ?? 'md:grid-cols-3'),
    'list' => 'space-y-8',
    'cards' => 'grid gap-8 ' . ($grid_classes[$columns] ?? 'md:grid-cols-3'),
);
?>

<section class="team-members <?php echo esc_attr($classes); ?>" <?php echo $style; ?>>
    <div class="container mx-auto px-4">
        <?php if (!empty($settings['title'])) : ?>
            <h2 class="text-3xl md:text-4xl font-bold text-center mb-12">
                <?php echo esc_html($settings['title']); ?>
            </h2>
        <?php endif; ?>

        <?php if (!empty($settings['description'])) : ?>
            <div class="max-w-3xl mx-auto text-center text-lg mb-12">
                <?php echo wp_kses_post($settings['description']); ?>
            </div>
        <?php endif; ?>

        <div class="<?php echo esc_attr($layout_classes[$layout]); ?>">
            <?php foreach ($team_members as $member) : ?>
                <?php
                $member_classes = array(
                    'grid' => 'text-center',
                    'list' => 'flex items-center gap-8',
                    'cards' => 'bg-white rounded-lg shadow-lg overflow-hidden',
                )[$layout] ?? '';
                ?>
                <div class="team-member <?php echo esc_attr($member_classes); ?>">
                    <?php if ($layout === 'list') : ?>
                        <div class="flex-shrink-0 w-32 h-32">
                        <?php endif; ?>

                        <?php if (!empty($member['image'])) : ?>
                            <div class="<?php echo $layout === 'list' ? 'w-full h-full' : 'aspect-square'; ?> relative overflow-hidden <?php echo $layout !== 'list' ? 'mb-6' : ''; ?>">
                                <?php echo wp_get_attachment_image($member['image'], 'medium', false, array(
                                    'class' => 'w-full h-full object-cover',
                                )); ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($layout === 'list') : ?>
                        </div>
                        <div class="flex-grow">
                        <?php endif; ?>

                        <?php if ($layout === 'cards') : ?>
                            <div class="p-6">
                            <?php endif; ?>

                            <h3 class="text-xl font-bold mb-2"><?php echo esc_html($member['name']); ?></h3>

                            <?php if (!empty($member['position'])) : ?>
                                <p class="text-primary-600 mb-4"><?php echo esc_html($member['position']); ?></p>
                            <?php endif; ?>

                            <?php if (!empty($member['bio'])) : ?>
                                <div class="text-gray-600 mb-4">
                                    <?php echo wp_kses_post($member['bio']); ?>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($member['social_links'])) : ?>
                                <div class="flex justify-<?php echo $layout === 'list' ? 'start' : 'center'; ?> gap-4">
                                    <?php foreach ($member['social_links'] as $platform => $url) : ?>
                                        <a href="<?php echo esc_url($url); ?>"
                                            class="text-gray-400 hover:text-primary-600 transition-colors"
                                            target="_blank" rel="noopener noreferrer">
                                            <i class="fab fa-<?php echo esc_attr($platform); ?>"></i>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                            <?php if ($layout === 'cards') : ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($layout === 'list') : ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>