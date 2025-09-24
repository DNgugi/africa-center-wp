<?php

/**
 * The template for displaying single events
 *
 * @package Headless
 */

get_header();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('container mx-auto px-4 py-8'); ?>>
    <?php if (have_posts()) : while (have_posts()) : the_post();
            $event_date = get_post_meta(get_the_ID(), '_event_date', true);
            $event_time_start = get_post_meta(get_the_ID(), '_event_time_start', true);
            $event_time_end = get_post_meta(get_the_ID(), '_event_time_end', true);
            $event_location = get_post_meta(get_the_ID(), '_event_location', true);
            $event_timezone = get_post_meta(get_the_ID(), '_event_timezone', true);

            // Format the date for display
            $formatted_date = date('F j, Y', strtotime($event_date));
    ?>
            <header class="mb-8">
                <div class="text-sm text-gray-600 mb-2">
                    <?php echo esc_html($formatted_date); ?>
                </div>
                <h1 class="text-4xl font-bold mb-4"><?php the_title(); ?></h1>

                <div class="flex flex-wrap gap-6 text-gray-600 text-sm mb-6">
                    <div>
                        <span class="inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                            </svg>
                            <?php
                            echo esc_html(date('g:i A', strtotime($event_time_start)));
                            if ($event_time_end) {
                                echo ' - ' . esc_html(date('g:i A', strtotime($event_time_end)));
                            }
                            if ($event_timezone) {
                                echo ' ' . esc_html($event_timezone);
                            }
                            ?>
                        </span>
                    </div>
                    <?php if ($event_location) : ?>
                        <div>
                            <span class="inline-block">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                </svg>
                                <?php echo nl2br(esc_html($event_location)); ?>
                            </span>
                        </div>
                    <?php endif; ?>
                </div>
            </header>

            <?php if (has_post_thumbnail()) : ?>
                <div class="mb-8">
                    <?php the_post_thumbnail('large', array('class' => 'w-full h-auto rounded-lg')); ?>
                </div>
            <?php endif; ?>

            <div class="prose max-w-none">
                <?php the_content(); ?>
            </div>

    <?php endwhile;
    endif; ?>

    <div class="mt-8 border-t pt-6">
        <a href="<?php echo esc_url(home_url('/events/')); ?>" class="inline-flex items-center text-blue-600 hover:text-blue-800">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            <?php _e('Back to Events', 'headless'); ?>
        </a>
    </div>
</article>

<?php get_footer(); ?>