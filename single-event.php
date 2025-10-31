<?php

/**
 * The template for displaying single events
 *
 * @package wpac
 */

get_header();
?>

<div class="container mx-auto px-4 py-8">
    <article id="post-<?php the_ID(); ?>" <?php post_class('max-w-3xl mx-auto'); ?>>
        <?php if (have_posts()) : while (have_posts()) : the_post();
                $start_date = get_post_meta(get_the_ID(), '_event_start_date', true);
                $end_date = get_post_meta(get_the_ID(), '_event_end_date', true);
                $start_time = get_post_meta(get_the_ID(), '_event_start_time', true);
                $end_time = get_post_meta(get_the_ID(), '_event_end_time', true);
                $timezone = get_post_meta(get_the_ID(), '_event_timezone', true);
                $location = get_post_meta(get_the_ID(), '_event_location', true);
                $location_address = get_post_meta(get_the_ID(), '_event_location_address', true);

                // Format the dates for display
                $formatted_start_date = date('F j, Y', strtotime($start_date));
                $formatted_end_date = $end_date ? date('F j, Y', strtotime($end_date)) : '';
        ?>
                <header class="mb-8">
                    <div class="text-sm text-gray-600 mb-2">
                        <?php
                        if ($end_date && $end_date !== $start_date) {
                            echo esc_html($formatted_start_date . ' - ' . $formatted_end_date);
                        } else {
                            echo esc_html($formatted_start_date);
                        }
                        ?>
                    </div>
                    <h1 class="text-4xl font-bold mb-4"><?php the_title(); ?></h1>

                    <div class="flex flex-wrap gap-6 text-gray-600 text-sm mb-6">
                        <div>
                            <span class="inline-block">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                </svg>
                                <?php
                                if ($start_time) {
                                    echo esc_html(date('g:i A', strtotime($start_time)));
                                    if ($end_time) {
                                        echo ' - ' . esc_html(date('g:i A', strtotime($end_time)));
                                    }
                                    if ($timezone) {
                                        echo ' (' . esc_html(str_replace('_', ' ', $timezone)) . ')';
                                    } else {
                                        echo ' (Hong Kong Time)';
                                    }
                                }
                                ?>
                            </span>
                        </div>
                        <?php if ($location || $location_address) : ?>
                            <div>
                                <span class="inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                    </svg>
                                    <div class="inline-block">
                                        <?php
                                        if ($location) {
                                            echo '<div class="font-medium">' . esc_html($location) . '</div>';
                                        }
                                        if ($location_address) {
                                            echo '<div class="text-xs mt-1">' . nl2br(esc_html($location_address)) . '</div>';
                                        }
                                        ?>
                                    </div>
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

                <div class="prose prose-lg mx-auto">
                    <?php the_content(); ?>
                </div>

        <?php endwhile;
        endif; ?>

        <div class="mt-8 border-t pt-6">
            <a href="<?php echo get_post_type_archive_link('event'); ?>" class="inline-flex items-center text-blue-600 hover:text-blue-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Back to Events
            </a>
        </div>
    </article>
</div>

<?php get_footer(); ?>