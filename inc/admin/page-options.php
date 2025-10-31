<?php

/**
 * Page Options Meta Box
 *
 * @package wpac
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add the meta box
 */
function wpac_add_page_options_meta_box()
{
    add_meta_box(
        'wpac_page_options',
        __('Page Options', 'wpac'),
        'wpac_render_page_options_meta_box',
        'page',
        'side',
        'high'
    );
}
add_action('add_meta_boxes', 'wpac_add_page_options_meta_box');

/**
 * Render the meta box
 */
function wpac_render_page_options_meta_box($post)
{
    // Add nonce for security
    wp_nonce_field('wpac_page_options_nonce', 'page_options_nonce');

    // Get saved values
    $options = get_post_meta($post->ID, '_wpac_page_options', true);

    if (!is_array($options)) {
        $options = array();
    }

    $options = wp_parse_args($options, array(
        'hide_header' => false,
        'hide_footer' => false,
        'header_style' => 'default',
        'content_width' => 'default',
        'hide_title' => false,
        'disable_sidebar' => false,
        'custom_classes' => '',
    ));

?>
    <p>
        <label>
            <input type="checkbox" name="page_options[hide_header]" value="1" <?php checked($options['hide_header'], 1); ?> />
            <?php _e('Hide Header', 'wpac'); ?>
        </label>
    </p>
    <p>
        <label>
            <input type="checkbox" name="page_options[hide_footer]" value="1" <?php checked($options['hide_footer'], 1); ?> />
            <?php _e('Hide Footer', 'wpac'); ?>
        </label>
    </p>
    <p>
        <label for="header_style"><?php _e('Header Style', 'wpac'); ?></label><br>
        <select name="page_options[header_style]" id="header_style" class="widefat">
            <option value="default" <?php selected($options['header_style'], 'default'); ?>><?php _e('Default', 'wpac'); ?></option>
            <option value="transparent" <?php selected($options['header_style'], 'transparent'); ?>><?php _e('Transparent', 'wpac'); ?></option>
            <option value="white" <?php selected($options['header_style'], 'white'); ?>><?php _e('White', 'wpac'); ?></option>
            <option value="dark" <?php selected($options['header_style'], 'dark'); ?>><?php _e('Dark', 'wpac'); ?></option>
            <option value="minimal" <?php selected($options['header_style'], 'minimal'); ?>><?php _e('Minimal', 'wpac'); ?></option>
        </select>
    </p>
    <p>
        <label for="content_width"><?php _e('Content Width', 'wpac'); ?></label><br>
        <select name="page_options[content_width]" id="content_width" class="widefat">
            <option value="default" <?php selected($options['content_width'], 'default'); ?>><?php _e('Default', 'wpac'); ?></option>
            <option value="narrow" <?php selected($options['content_width'], 'narrow'); ?>><?php _e('Narrow', 'wpac'); ?></option>
            <option value="wide" <?php selected($options['content_width'], 'wide'); ?>><?php _e('Wide', 'wpac'); ?></option>
            <option value="full" <?php selected($options['content_width'], 'full'); ?>><?php _e('Full Width', 'wpac'); ?></option>
        </select>
    </p>
    <p>
        <label>
            <input type="checkbox" name="page_options[hide_title]" value="1" <?php checked($options['hide_title'], true); ?>>
            <?php _e('Hide Page Title', 'wpac'); ?>
        </label>
    </p>
    <p>
        <label>
            <input type="checkbox" name="page_options[disable_sidebar]" value="1" <?php checked($options['disable_sidebar'], true); ?>>
            <?php _e('Disable Sidebar', 'wpac'); ?>
        </label>
    </p>
    <p>
        <label for="custom_classes"><?php _e('Custom CSS Classes', 'wpac'); ?></label>
        <input type="text" name="page_options[custom_classes]" id="custom_classes" class="widefat"
            value="<?php echo esc_attr($options['custom_classes']); ?>"
            placeholder="<?php esc_attr_e('Add custom CSS classes...', 'wpac'); ?>">
    </p>
<?php
}

/**
 * Save the meta box
 */
function wpac_save_page_options_meta_box($post_id)
{
    // Check if our nonce is set
    if (!isset($_POST['page_options_nonce'])) {
        return;
    }

    // Verify that the nonce is valid
    if (!wp_verify_nonce($_POST['page_options_nonce'], 'wpac_page_options_nonce')) {
        return;
    }

    // If this is an autosave, our form has not been submitted
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check the user's permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Make sure the options are set
    if (!isset($_POST['page_options'])) {
        delete_post_meta($post_id, '_wpac_page_options');
        return;
    }

    // Sanitize and save the options
    $options = array(
        'hide_header' => isset($_POST['page_options']['hide_header']),
        'hide_footer' => isset($_POST['page_options']['hide_footer']),
        'header_style' => sanitize_text_field($_POST['page_options']['header_style']),
        'content_width' => sanitize_text_field($_POST['page_options']['content_width']),
        'hide_title' => isset($_POST['page_options']['hide_title']),
        'disable_sidebar' => isset($_POST['page_options']['disable_sidebar']),
        'custom_classes' => sanitize_text_field($_POST['page_options']['custom_classes'])
    );

    update_post_meta($post_id, '_wpac_page_options', $options);
}
add_action('save_post', 'wpac_save_page_options_meta_box');

/**
 * Get the page options
 */
function wpac_get_page_options($post_id = null)
{
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    if (!$post_id) {
        return array();
    }

    $options = get_post_meta($post_id, '_wpac_page_options', true);

    if (!is_array($options)) {
        $options = array();
    }

    return wp_parse_args($options, array(
        'hide_header' => false,
        'hide_footer' => false,
        'header_style' => 'default',
        'content_width' => 'default',
        'hide_title' => false,
        'disable_sidebar' => false,
        'custom_classes' => '',
    ));
}

/**
 * Helper function to get page options from templates
 */
function wpac_page_options()
{
    return wpac_get_page_options();
}
