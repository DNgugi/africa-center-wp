<?php

/**
 * Template part for displaying gallery grid
 *
 * @package headless
 */

$args = wp_parse_args($args, array(
    'post_type' => 'attachment',
    'post_status' => 'inherit',
    'posts_per_page' => isset($show_all) && $show_all ? -1 : 6,
    'post_mime_type' => 'image',
));

$gallery_query = new WP_Query($args);
?>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php if ($gallery_query->have_posts()) : while ($gallery_query->have_posts()) : $gallery_query->the_post();
            $full_image_url = wp_get_attachment_image_url(get_the_ID(), 'full');
            $image_caption = wp_get_attachment_caption(get_the_ID());
    ?>
            <div class="group relative overflow-hidden rounded-lg aspect-[4/3]">
                <?php echo wp_get_attachment_image(get_the_ID(), 'large', false, array(
                    'class' => 'absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-110',
                )); ?>
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <?php if ($image_caption) : ?>
                        <div class="absolute bottom-0 left-0 right-0 p-4 text-white">
                            <p class="text-sm font-medium"><?php echo esc_html($image_caption); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
                <a href="<?php echo esc_url($full_image_url); ?>" class="absolute inset-0" aria-label="<?php echo esc_attr($image_caption); ?>"></a>
            </div>
    <?php endwhile;
    endif;
    wp_reset_postdata(); ?>
</div>

<?php if (!isset($show_all) || !$show_all) : ?>
    <div class="text-center mt-8">
        <a href="<?php echo esc_url(get_permalink(get_page_by_path('gallery'))); ?>" class="btn-primary">
            <?php esc_html_e('View Full Gallery', 'headless'); ?>
        </a>
    </div>
<?php endif; ?>