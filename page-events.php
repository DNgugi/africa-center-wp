<?php

/**
 * Template Name: Events Page
 * 
 * @package Headless
 */

get_header();
?>

<div class="container mx-auto px-4 py-8">
    <!-- Search and filters form -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <form method="get" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                <input type="text" name="search" id="search" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" placeholder="Search events..." value="<?php echo isset($_GET['search']) ? esc_attr($_GET['search']) : ''; ?>">
            </div>
            <div>
                <label for="date_filter" class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                <select name="date_filter" id="date_filter" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <option value="">All dates</option>
                    <option value="upcoming" <?php echo (isset($_GET['date_filter']) && $_GET['date_filter'] == 'upcoming') ? 'selected' : ''; ?>>Upcoming events</option>
                    <option value="past" <?php echo (isset($_GET['date_filter']) && $_GET['date_filter'] == 'past') ? 'selected' : ''; ?>>Past events</option>
                    <option value="today" <?php echo (isset($_GET['date_filter']) && $_GET['date_filter'] == 'today') ? 'selected' : ''; ?>>Today</option>
                    <option value="this_week" <?php echo (isset($_GET['date_filter']) && $_GET['date_filter'] == 'this_week') ? 'selected' : ''; ?>>This week</option>
                    <option value="this_month" <?php echo (isset($_GET['date_filter']) && $_GET['date_filter'] == 'this_month') ? 'selected' : ''; ?>>This month</option>
                </select>
            </div>
            <div class="md:col-span-2 self-end">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md transition-colors">Filter Events</button>
                <?php if (!empty($_GET)) : ?>
                    <a href="<?php echo get_permalink(); ?>" class="ml-2 text-gray-600 hover:text-gray-800">Reset Filters</a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <?php
    // Process search and filters
    $search_query = isset($_GET['search']) ? sanitize_text_field($_GET['search']) : '';
    $date_filter = isset($_GET['date_filter']) ? sanitize_text_field($_GET['date_filter']) : '';

    // Basic query arguments
    $args = array(
        'post_type' => 'event',
        'posts_per_page' => -1,
        's' => $search_query,
        'meta_key' => '_event_date',
    );

    // Get current date
    $today = current_time('Y-m-d');

    // Handle date filtering
    if ($date_filter === 'past') {
        // PAST EVENTS: Show events that happened before today
        $args['meta_query'] = array(
            array(
                'key' => '_event_date',
                'value' => $today,
                'compare' => '<',
                'type' => 'DATE',
            )
        );
        $args['orderby'] = 'meta_value';
        $args['order'] = 'DESC'; // Newest past events first

    } else if ($date_filter === 'upcoming') {
        // UPCOMING EVENTS: Show events from today onwards
        $args['meta_query'] = array(
            array(
                'key' => '_event_date',
                'value' => $today,
                'compare' => '>=',
                'type' => 'DATE',
            )
        );
        $args['orderby'] = 'meta_value';
        $args['order'] = 'ASC'; // Soonest first

    } else if ($date_filter === 'today') {
        // TODAY'S EVENTS: Show only events happening today
        $args['meta_query'] = array(
            array(
                'key' => '_event_date',
                'value' => $today,
                'compare' => '=',
                'type' => 'DATE',
            )
        );
        $args['orderby'] = 'meta_value';
        $args['order'] = 'ASC';
    } else if ($date_filter === 'this_week') {
        // THIS WEEK'S EVENTS: Monday to Sunday
        $week_start = date('Y-m-d', strtotime('monday this week', strtotime($today)));
        $week_end = date('Y-m-d', strtotime('sunday this week', strtotime($today)));
        $args['meta_query'] = array(
            array(
                'key' => '_event_date',
                'value' => array($week_start, $week_end),
                'compare' => 'BETWEEN',
                'type' => 'DATE',
            )
        );
        $args['orderby'] = 'meta_value';
        $args['order'] = 'ASC';
    } else if ($date_filter === 'this_month') {
        // THIS MONTH'S EVENTS: 1st to last day of current month
        $month_start = date('Y-m-01', strtotime($today));
        $month_end = date('Y-m-t', strtotime($today));
        $args['meta_query'] = array(
            array(
                'key' => '_event_date',
                'value' => array($month_start, $month_end),
                'compare' => 'BETWEEN',
                'type' => 'DATE',
            )
        );
        $args['orderby'] = 'meta_value';
        $args['order'] = 'ASC';
    } else {
        // DEFAULT (ALL EVENTS): Show upcoming first, then past events
        // This requires two separate queries that we'll merge

        // 1. Get upcoming events
        $upcoming_query = new WP_Query(array(
            'post_type' => 'event',
            'posts_per_page' => -1,
            's' => $search_query,
            'meta_key' => '_event_date',
            'orderby' => 'meta_value',
            'order' => 'ASC',
            'meta_query' => array(
                array(
                    'key' => '_event_date',
                    'value' => $today,
                    'compare' => '>=',
                    'type' => 'DATE',
                )
            )
        ));

        // 2. Get past events
        $past_query = new WP_Query(array(
            'post_type' => 'event',
            'posts_per_page' => -1,
            's' => $search_query,
            'meta_key' => '_event_date',
            'orderby' => 'meta_value',
            'order' => 'DESC',
            'meta_query' => array(
                array(
                    'key' => '_event_date',
                    'value' => $today,
                    'compare' => '<',
                    'type' => 'DATE',
                )
            )
        ));

        // 3. Merge the results
        $all_ids = array();

        // Add upcoming events IDs first
        foreach ($upcoming_query->posts as $post) {
            $all_ids[] = $post->ID;
        }

        // Then add past events IDs
        foreach ($past_query->posts as $post) {
            $all_ids[] = $post->ID;
        }

        // If we have results, set up the query
        if (!empty($all_ids)) {
            $args['post__in'] = $all_ids;
            $args['orderby'] = 'post__in'; // Maintain our manual order
        } else {
            // No events found
            $args['post__in'] = array(0); // Force no results
        }

        // Reset queries
        wp_reset_postdata();
    }

    $events_query = new WP_Query($args);

    if ($events_query->have_posts()) :
        $current_date = '';
        while ($events_query->have_posts()) : $events_query->the_post();
            $event_date = get_post_meta(get_the_ID(), '_event_date', true);
            $event_time_start = get_post_meta(get_the_ID(), '_event_time_start', true);
            $event_time_end = get_post_meta(get_the_ID(), '_event_time_end', true);
            $event_location = get_post_meta(get_the_ID(), '_event_location', true);
            $event_timezone = get_post_meta(get_the_ID(), '_event_timezone', true);

            // Format the date for display
            $formatted_date = date('F j, Y', strtotime($event_date));

            // Show date header if it's a new date
            if ($formatted_date != $current_date) :
                if ($current_date != '') echo '</div>'; // Close previous date group
                $current_date = $formatted_date;
    ?>
                <div class="mb-8">
                    <h2 class="text-2xl font-bold mb-4"><?php echo esc_html($formatted_date); ?></h2>
                <?php endif; ?>

                <div class="bg-white rounded-lg shadow p-0 mb-6 overflow-hidden">
                    <div class="flex flex-col md:flex-row">
                        <div class="md:w-2/3 p-6 pr-4">
                            <h3 class="text-xl font-semibold mb-1">
                                <a href="<?php the_permalink(); ?>" class="hover:text-blue-600 transition-colors">
                                    <?php the_title(); ?>
                                </a>
                            </h3>
                            <div class="text-gray-700 mb-3 text-base">
                                <?php echo wp_trim_words(get_the_content(), 30, '...'); ?>
                            </div>
                            <div class="text-gray-600 text-sm">
                                <div class="flex items-center mb-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
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
                                </div>
                                <?php if ($event_location) : ?>
                                    <div class="flex items-start">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <span class="text-sm leading-tight"><?php echo nl2br(esc_html($event_location)); ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="md:w-1/3 flex-shrink-0 border-l border-gray-100">
                                <div class="h-full flex items-center justify-center p-3">
                                    <?php the_post_thumbnail('thumbnail', array('class' => 'w-full h-auto object-contain max-h-[120px]')); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

            <?php endwhile;
        echo '</div>'; // Close last date group
        wp_reset_postdata();
    else : ?>
            <p class="text-center text-gray-600">No upcoming events found.</p>
        <?php endif; ?>
                </div>

                <?php get_footer(); ?>