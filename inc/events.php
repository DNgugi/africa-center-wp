<?php

/**
 * Event meta, admin UX, REST exposure and JSON-LD output
 * Place this file in inc/events.php and include it from functions.php:
 * require_once get_template_directory() . '/inc/events.php';
 */

/* Register event meta and add actions */
add_action('init', 'wpac_register_event_meta');
function wpac_register_event_meta()
{
    register_meta('post', 'event_start_date', array(
        'show_in_rest' => true,
        'single' => true,
        'type' => 'string',
    ));
    register_meta('post', 'event_end_date', array(
        'show_in_rest' => true,
        'single' => true,
        'type' => 'string',
    ));
    register_meta('post', 'event_start_time', array(
        'show_in_rest' => true,
        'single' => true,
        'type' => 'string',
    ));
    register_meta('post', 'event_end_time', array(
        'show_in_rest' => true,
        'single' => true,
        'type' => 'string',
    ));
    register_meta('post', 'event_timezone', array(
        'show_in_rest' => true,
        'single' => true,
        'type' => 'string',
    ));
    register_meta('post', 'event_location', array(
        'show_in_rest' => true,
        'single' => true,
        'type' => 'string',
    ));
    register_meta('post', 'event_location_address', array(
        'show_in_rest' => true,
        'single' => true,
        'type' => 'string',
    ));
}

/* Admin: Add meta box */
add_action('add_meta_boxes', 'wpac_add_event_metabox');
function wpac_add_event_metabox()
{
    add_meta_box('wpac-event-meta', 'Event details', 'wpac_event_meta_cb', 'event', 'side', 'high');
}

function wpac_event_meta_cb($post)
{
    wp_nonce_field('wpac_save_event_meta', 'wpac_event_meta_nonce');

    $start_date = get_post_meta($post->ID, '_event_start_date', true);
    $end_date = get_post_meta($post->ID, '_event_end_date', true);
    $start_time = get_post_meta($post->ID, '_event_start_time', true);
    $end_time = get_post_meta($post->ID, '_event_end_time', true);
    $timezone = get_post_meta($post->ID, '_event_timezone', true);
    $location = get_post_meta($post->ID, '_event_location', true);
    $location_address = get_post_meta($post->ID, '_event_location_address', true);

    echo '<div style="margin-bottom: 20px;">';
    echo '<h4 style="margin-bottom: 10px;">Date & Time</h4>';
    echo '<p><label for="wpac_event_start_date">Start Date</label><br />';
    echo '<input type="text" id="wpac_event_start_date" name="wpac_event_start_date" class="widefat wpac-date" value="' . esc_attr($start_date) . '" placeholder="YYYY-MM-DD"></p>';

    echo '<p><label for="wpac_event_end_date">End Date (optional)</label><br />';
    echo '<input type="text" id="wpac_event_end_date" name="wpac_event_end_date" class="widefat wpac-date" value="' . esc_attr($end_date) . '" placeholder="YYYY-MM-DD"></p>';

    echo '<p><label for="wpac_event_start_time">Start Time</label><br />';
    echo '<input type="text" id="wpac_event_start_time" name="wpac_event_start_time" class="widefat wpac-time" value="' . esc_attr($start_time) . '" placeholder="HH:MM"></p>';

    echo '<p><label for="wpac_event_end_time">End Time</label><br />';
    echo '<input type="text" id="wpac_event_end_time" name="wpac_event_end_time" class="widefat wpac-time" value="' . esc_attr($end_time) . '" placeholder="HH:MM"></p>';

    // Function to format timezone for display
    function format_timezone_name($tz)
    {
        return str_replace('_', ' ', $tz);
    }

    echo '<p><label for="wpac_event_timezone">Timezone</label><br />';
    echo '<select id="wpac_event_timezone" name="wpac_event_timezone" class="widefat">';
    $timezones = DateTimeZone::listIdentifiers();
    $default_timezone = 'Asia/Hong_Kong';
    echo '<option value="">Select timezone</option>';
    foreach ($timezones as $tz) {
        $selected = '';
        if (!$timezone && $tz === $default_timezone) {
            $selected = ' selected';
        } elseif ($timezone && $tz === $timezone) {
            $selected = ' selected';
        }
        echo '<option value="' . esc_attr($tz) . '"' . $selected . '>' . esc_html(format_timezone_name($tz)) . '</option>';
    }
    echo '</select></p>';
    echo '</div>';

    echo '<div style="margin-bottom: 20px;">';
    echo '<h4 style="margin-bottom: 10px;">Location Details</h4>';
    echo '<p><label for="wpac_event_location">Venue Name</label><br />';
    echo '<input type="text" id="wpac_event_location" name="wpac_event_location" class="widefat" value="' . esc_attr($location) . '" placeholder="e.g., Conference Center"></p>';

    echo '<p><label for="wpac_event_location_address">Address</label><br />';
    echo '<textarea id="wpac_event_location_address" name="wpac_event_location_address" class="widefat" rows="3" placeholder="Full address">' . esc_textarea($location_address) . '</textarea></p>';
    echo '</div>';
}

/* Save meta */
add_action('save_post', 'wpac_save_event_meta');
function wpac_save_event_meta($post_id)
{
    if (get_post_type($post_id) !== 'event') return;
    if (!isset($_POST['wpac_event_meta_nonce']) || !wp_verify_nonce($_POST['wpac_event_meta_nonce'], 'wpac_save_event_meta')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    $fields = array(
        'start_date' => array('_event_start_date', '/^\d{4}-\d{2}-\d{2}$/'),
        'end_date' => array('_event_end_date', '/^\d{4}-\d{2}-\d{2}$/'),
        'start_time' => array('_event_start_time', '/^\d{1,2}:\d{2}$/'),
        'end_time' => array('_event_end_time', '/^\d{1,2}:\d{2}$/'),
    );

    foreach ($fields as $field => $meta) {
        $field_name = 'wpac_event_' . $field;
        $meta_key = $meta[0];
        $pattern = $meta[1];

        if (isset($_POST[$field_name])) {
            $value = sanitize_text_field($_POST[$field_name]);
            if (preg_match($pattern, $value)) {
                if (strpos($field, 'time') !== false) {
                    // Normalize time to HH:MM format
                    $parts = explode(':', $value);
                    $value = str_pad($parts[0], 2, '0', STR_PAD_LEFT) . ':' . $parts[1];
                }
                update_post_meta($post_id, $meta_key, $value);
            } else {
                delete_post_meta($post_id, $meta_key);
            }
        }
    }

    // Save timezone
    if (isset($_POST['wpac_event_timezone'])) {
        $timezone = sanitize_text_field($_POST['wpac_event_timezone']);
        if (in_array($timezone, DateTimeZone::listIdentifiers())) {
            update_post_meta($post_id, '_event_timezone', $timezone);
        } else {
            update_post_meta($post_id, '_event_timezone', 'Asia/Hong_Kong');
        }
    } else {
        update_post_meta($post_id, '_event_timezone', 'Asia/Hong_Kong');
    }

    // Save location details
    if (isset($_POST['wpac_event_location'])) {
        $location = sanitize_text_field($_POST['wpac_event_location']);
        update_post_meta($post_id, '_event_location', $location);
    }

    if (isset($_POST['wpac_event_location_address'])) {
        $address = sanitize_textarea_field($_POST['wpac_event_location_address']);
        update_post_meta($post_id, '_event_location_address', $address);
    }
}

/* Enqueue admin scripts (flatpickr) */
add_action('admin_enqueue_scripts', 'wpac_enqueue_event_admin_assets');
function wpac_enqueue_event_admin_assets($hook)
{
    global $post;
    if ($hook !== 'post-new.php' && $hook !== 'post.php') return;
    if (empty($post) || $post->post_type !== 'event') return;

    // Flatpickr from CDN (you can vendor it in your theme instead)
    wp_enqueue_style('flatpickr-css', 'https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css', array(), '4.6.13');
    wp_enqueue_script('flatpickr-js', 'https://cdn.jsdelivr.net/npm/flatpickr', array(), '4.6.13', true);

    $init = <<<JS
document.addEventListener('DOMContentLoaded', function() {
  if (typeof flatpickr !== 'undefined') {
    // Add CSS for better styling
    const style = document.createElement('style');
    style.textContent = `
      .event-meta-section { margin-bottom: 20px; }
      .event-meta-section h4 { margin-bottom: 10px; font-size: 14px; }
      .flatpickr-input { border: 1px solid #ddd; }
      .wpac-time, .wpac-date { margin-bottom: 8px; }
      .wpac-meta-label { display: block; margin-bottom: 5px; font-weight: 500; }
    `;
    document.head.appendChild(style);

    // Initialize date pickers
    flatpickr('.wpac-date', { 
      dateFormat: 'Y-m-d',
      allowInput: true,
      disableMobile: true 
    });

    // Initialize time pickers
    flatpickr('.wpac-time', {
      enableTime: true,
      noCalendar: true,
      dateFormat: 'H:i',
      time_24hr: true,
      allowInput: true,
      disableMobile: true,
      minuteIncrement: 15
    });

    // Add date validation
    const startDate = document.getElementById('wpac_event_start_date');
    const endDate = document.getElementById('wpac_event_end_date');
    
    if (startDate && endDate) {
      endDate.addEventListener('change', function() {
        if (startDate.value && this.value && this.value < startDate.value) {
          alert('End date cannot be before start date');
          this.value = '';
        }
      });
    }
  }
});
JS;
    wp_add_inline_script('flatpickr-js', $init);
}

/* Admin columns for event date */
add_filter('manage_event_posts_columns', 'wpac_event_columns');
function wpac_event_columns($columns)
{
    $new = array();
    foreach ($columns as $key => $title) {
        if ($key === 'date') {
            $new['event_date'] = 'Event Date';
        }
        $new[$key] = $title;
    }
    return $new;
}

add_action('manage_event_posts_custom_column', 'wpac_event_column_content', 10, 2);
function wpac_event_column_content($column, $post_id)
{
    if ($column === 'event_date') {
        $date = get_post_meta($post_id, '_event_date', true);
        $time = get_post_meta($post_id, '_event_time', true);
        if ($date) {
            $out = esc_html($date);
            if ($time) $out .= ' ' . esc_html($time);
            echo $out;
        } else {
            echo '—';
        }
    }
}

/* Make event_date sortable */
add_filter('manage_edit-event_sortable_columns', 'wpac_event_sortable_columns');
function wpac_event_sortable_columns($cols)
{
    $cols['event_date'] = 'event_date';
    return $cols;
}

add_action('pre_get_posts', 'wpac_event_orderby');
function wpac_event_orderby($query)
{
    if (!is_admin()) return;
    $orderby = $query->get('orderby');
    if ($orderby === 'event_date') {
        $query->set('meta_key', '_event_date');
        $query->set('orderby', 'meta_value');
        $query->set('order', 'ASC');
    }
}

/* JSON-LD for single event pages */
add_action('wp_head', 'wpac_event_json_ld');
function wpac_event_json_ld()
{
    if (!is_singular('event')) return;

    global $post;
    $title = get_the_title($post);
    $description = wp_strip_all_tags(get_the_excerpt($post) ?: wp_trim_words(get_the_content($post), 55));
    $url = get_permalink($post);
    $image = get_the_post_thumbnail_url($post, 'full');

    // Get all event meta
    $start_date = get_post_meta($post->ID, '_event_start_date', true);
    $end_date = get_post_meta($post->ID, '_event_end_date', true);
    $start_time = get_post_meta($post->ID, '_event_start_time', true) ?: '00:00';
    $end_time = get_post_meta($post->ID, '_event_end_time', true);
    $timezone = get_post_meta($post->ID, '_event_timezone', true) ?: wp_timezone()->getName();
    $location = get_post_meta($post->ID, '_event_location', true);
    $location_address = get_post_meta($post->ID, '_event_location_address', true);

    // Build ISO 8601 dates
    $start_iso = '';
    $end_iso = '';

    try {
        if ($start_date) {
            $start_dt = new DateTime("{$start_date} {$start_time}", new DateTimeZone($timezone));
            $start_iso = $start_dt->format(DateTime::ATOM);
        }

        if ($end_date && $end_time) {
            $end_dt = new DateTime("{$end_date} {$end_time}", new DateTimeZone($timezone));
            $end_iso = $end_dt->format(DateTime::ATOM);
        } elseif ($start_date && $end_time) {
            // Single day event with end time
            $end_dt = new DateTime("{$start_date} {$end_time}", new DateTimeZone($timezone));
            $end_iso = $end_dt->format(DateTime::ATOM);
        }
    } catch (Exception $e) {
        // Fallback to simple date format if DateTime fails
        $start_iso = $start_date;
        $end_iso = $end_date;
    }

    $data = array(
        '@context' => 'https://schema.org',
        '@type' => 'Event',
        'name' => $title,
        'startDate' => $start_iso ?: $start_date,
        'description' => $description,
        'url' => $url,
    );

    // Add end date if available
    if ($end_iso || $end_date) {
        $data['endDate'] = $end_iso ?: $end_date;
    }

    if ($image) $data['image'] = esc_url($image);

    if ($location || $location_address) {
        $place = array(
            '@type' => 'Place'
        );

        if ($location) {
            $place['name'] = $location;
        }

        if ($location_address) {
            $place['address'] = array(
                '@type' => 'PostalAddress',
                'streetAddress' => $location_address
            );
        }

        $data['location'] = $place;
    }

    echo "\n<script type=\"application/ld+json\">\n" . wp_json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . "\n</script>\n";
}
