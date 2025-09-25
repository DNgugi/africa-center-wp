<?php

/**
 * Front Page Options for the Customizer
 *
 * @package headless
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Front Page Options
 */
function headless_register_front_page_options($wp_customize)
{
    // Add Front Page Options Panel
    $wp_customize->add_panel('front_page_options', array(
        'title' => __('Front Page Options', 'headless'),
        'priority' => 20,
        'description' => __('Customize the front page sections', 'headless'),
    ));

    // Hero Section
    headless_customizer_hero_section($wp_customize);

    // Tagline Section
    headless_customizer_tagline_section($wp_customize);

    // Featured Programs Section
    headless_customizer_featured_programs_section($wp_customize);

    // Mission Section
    headless_customizer_mission_section($wp_customize);

    // Values Section
    headless_customizer_values_section($wp_customize);

    // Gallery Section
    headless_customizer_gallery_section($wp_customize);

    // Testimonials Section
    headless_customizer_testimonials_section($wp_customize);

    // Events Section
    headless_customizer_events_section($wp_customize);
}

/**
 * Hero Section
 */
function headless_customizer_hero_section($wp_customize)
{
    $wp_customize->add_section('hero_section', array(
        'title' => __('Hero Section', 'headless'),
        'panel' => 'front_page_options',
    ));

    // Background Image
    $wp_customize->add_setting('hero_background', array(
        'default' => get_template_directory_uri() . '/images/background-patterns/hero-background.svg',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'hero_background', array(
        'label' => __('Hero Background', 'headless'),
        'section' => 'hero_section',
    )));

    // Badge Text
    $wp_customize->add_setting('hero_badge_text', array(
        'default' => 'Welcome to Africa Center Hong Kong',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('hero_badge_text', array(
        'label' => __('Badge Text', 'headless'),
        'section' => 'hero_section',
        'type' => 'text',
    ));

    // Heading
    $wp_customize->add_setting('hero_heading', array(
        'default' => 'Rebranding <span class="text-secondary-gold">Blackness</span> in Asia',
        'sanitize_callback' => 'wp_kses_post',
    ));

    $wp_customize->add_control('hero_heading', array(
        'label' => __('Heading (HTML allowed for styling)', 'headless'),
        'section' => 'hero_section',
        'type' => 'textarea',
    ));

    // Description
    $wp_customize->add_setting('hero_description', array(
        'default' => 'We are a platform & creative hub that fosters value-creating interactions between African and non-African communities in Asia',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('hero_description', array(
        'label' => __('Description', 'headless'),
        'section' => 'hero_section',
        'type' => 'textarea',
    ));

    // Primary Button Text
    $wp_customize->add_setting('hero_primary_button_text', array(
        'default' => 'Explore Programs',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('hero_primary_button_text', array(
        'label' => __('Primary Button Text', 'headless'),
        'section' => 'hero_section',
        'type' => 'text',
    ));

    // Primary Button URL
    $wp_customize->add_setting('hero_primary_button_url', array(
        'default' => '/programs',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('hero_primary_button_url', array(
        'label' => __('Primary Button URL', 'headless'),
        'section' => 'hero_section',
        'type' => 'url',
    ));

    // Secondary Button Text
    $wp_customize->add_setting('hero_secondary_button_text', array(
        'default' => 'Join Our Newsletter',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('hero_secondary_button_text', array(
        'label' => __('Secondary Button Text', 'headless'),
        'section' => 'hero_section',
        'type' => 'text',
    ));

    // Secondary Button URL
    $wp_customize->add_setting('hero_secondary_button_url', array(
        'default' => '#newsletter',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('hero_secondary_button_url', array(
        'label' => __('Secondary Button URL', 'headless'),
        'section' => 'hero_section',
        'type' => 'url',
    ));
}

/**
 * Tagline Section
 */
function headless_customizer_tagline_section($wp_customize)
{
    $wp_customize->add_section('tagline_section', array(
        'title' => __('Tagline Section', 'headless'),
        'panel' => 'front_page_options',
    ));

    // Tagline Text
    $wp_customize->add_setting('tagline_text', array(
        'default' => 'African Solutions for Glocal Issues',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('tagline_text', array(
        'label' => __('Tagline Text', 'headless'),
        'section' => 'tagline_section',
        'type' => 'text',
    ));
}

/**
 * Featured Programs Section
 */
function headless_customizer_featured_programs_section($wp_customize)
{
    $wp_customize->add_section('featured_programs_section', array(
        'title' => __('Featured Programs Section', 'headless'),
        'panel' => 'front_page_options',
    ));

    // Section Badge
    $wp_customize->add_setting('programs_badge_text', array(
        'default' => 'Discover',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('programs_badge_text', array(
        'label' => __('Badge Text', 'headless'),
        'section' => 'featured_programs_section',
        'type' => 'text',
    ));

    // Section Heading
    $wp_customize->add_setting('programs_heading', array(
        'default' => 'Featured Programs',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('programs_heading', array(
        'label' => __('Heading', 'headless'),
        'section' => 'featured_programs_section',
        'type' => 'text',
    ));

    // Button Text
    $wp_customize->add_setting('programs_button_text', array(
        'default' => 'View All Programs',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('programs_button_text', array(
        'label' => __('Button Text', 'headless'),
        'section' => 'featured_programs_section',
        'type' => 'text',
    ));

    // Button URL
    $wp_customize->add_setting('programs_button_url', array(
        'default' => '/programs',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('programs_button_url', array(
        'label' => __('Button URL', 'headless'),
        'section' => 'featured_programs_section',
        'type' => 'url',
    ));

    // Number of Programs to Display
    $wp_customize->add_setting('programs_count', array(
        'default' => 6,
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control('programs_count', array(
        'label' => __('Number of Programs to Display', 'headless'),
        'section' => 'featured_programs_section',
        'type' => 'number',
        'input_attrs' => array(
            'min' => 1,
            'max' => 12,
            'step' => 1,
        ),
    ));

    // Programs Repeater (6 programs)
    for ($i = 1; $i <= 6; $i++) {
        // Program Title
        $wp_customize->add_setting("program_{$i}_title", array(
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control("program_{$i}_title", array(
            'label' => sprintf(__('Program %d Title', 'headless'), $i),
            'section' => 'featured_programs_section',
            'type' => 'text',
        ));

        // Program Image
        $wp_customize->add_setting("program_{$i}_image", array(
            'sanitize_callback' => 'esc_url_raw',
        ));

        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, "program_{$i}_image", array(
            'label' => sprintf(__('Program %d Image', 'headless'), $i),
            'section' => 'featured_programs_section',
        )));

        // Program URL
        $wp_customize->add_setting("program_{$i}_url", array(
            'sanitize_callback' => 'esc_url_raw',
        ));

        $wp_customize->add_control("program_{$i}_url", array(
            'label' => sprintf(__('Program %d URL', 'headless'), $i),
            'section' => 'featured_programs_section',
            'type' => 'url',
        ));

        // Program Badge
        $wp_customize->add_setting("program_{$i}_badge", array(
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control("program_{$i}_badge", array(
            'label' => sprintf(__('Program %d Badge (optional)', 'headless'), $i),
            'section' => 'featured_programs_section',
            'type' => 'text',
        ));

        // Program Description
        $wp_customize->add_setting("program_{$i}_description", array(
            'sanitize_callback' => 'sanitize_textarea_field',
        ));

        $wp_customize->add_control("program_{$i}_description", array(
            'label' => sprintf(__('Program %d Description (optional)', 'headless'), $i),
            'section' => 'featured_programs_section',
            'type' => 'textarea',
        ));
    }
}

/**
 * Mission Section
 */
function headless_customizer_mission_section($wp_customize)
{
    $wp_customize->add_section('mission_section', array(
        'title' => __('Mission Section', 'headless'),
        'panel' => 'front_page_options',
    ));

    // Background Image
    $wp_customize->add_setting('mission_background', array(
        'default' => get_template_directory_uri() . '/images/background-patterns/our-purpose-background.svg',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'mission_background', array(
        'label' => __('Background Image', 'headless'),
        'section' => 'mission_section',
    )));

    // Badge Text
    $wp_customize->add_setting('mission_badge_text', array(
        'default' => 'Our Purpose',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('mission_badge_text', array(
        'label' => __('Badge Text', 'headless'),
        'section' => 'mission_section',
        'type' => 'text',
    ));

    // Heading
    $wp_customize->add_setting('mission_heading', array(
        'default' => 'We work for a future where Africa has an equal footing',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('mission_heading', array(
        'label' => __('Heading', 'headless'),
        'section' => 'mission_section',
        'type' => 'text',
    ));

    // Mission Items (3 items)
    for ($i = 1; $i <= 3; $i++) {
        // Title
        $wp_customize->add_setting("mission_item_{$i}_title", array(
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control("mission_item_{$i}_title", array(
            'label' => sprintf(__('Mission Item %d Title', 'headless'), $i),
            'section' => 'mission_section',
            'type' => 'text',
        ));

        // Description
        $wp_customize->add_setting("mission_item_{$i}_description", array(
            'sanitize_callback' => 'sanitize_textarea_field',
        ));

        $wp_customize->add_control("mission_item_{$i}_description", array(
            'label' => sprintf(__('Mission Item %d Description', 'headless'), $i),
            'section' => 'mission_section',
            'type' => 'textarea',
        ));

        // Icon (FontAwesome)
        $wp_customize->add_setting("mission_item_{$i}_icon", array(
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control("mission_item_{$i}_icon", array(
            'label' => sprintf(__('Mission Item %d Icon (FontAwesome name without "fa-" prefix)', 'headless'), $i),
            'section' => 'mission_section',
            'type' => 'text',
        ));

        // URL
        $wp_customize->add_setting("mission_item_{$i}_url", array(
            'sanitize_callback' => 'esc_url_raw',
        ));

        $wp_customize->add_control("mission_item_{$i}_url", array(
            'label' => sprintf(__('Mission Item %d URL', 'headless'), $i),
            'section' => 'mission_section',
            'type' => 'url',
        ));
    }
}

/**
 * Values Section
 */
function headless_customizer_values_section($wp_customize)
{
    $wp_customize->add_section('values_section', array(
        'title' => __('Values Section', 'headless'),
        'panel' => 'front_page_options',
    ));

    // Badge Text
    $wp_customize->add_setting('values_badge_text', array(
        'default' => 'What Guides Us',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('values_badge_text', array(
        'label' => __('Badge Text', 'headless'),
        'section' => 'values_section',
        'type' => 'text',
    ));

    // Heading
    $wp_customize->add_setting('values_heading', array(
        'default' => 'Our Values',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('values_heading', array(
        'label' => __('Heading', 'headless'),
        'section' => 'values_section',
        'type' => 'text',
    ));

    // Values Items (4 items)
    for ($i = 1; $i <= 4; $i++) {
        // Title
        $wp_customize->add_setting("values_item_{$i}_title", array(
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control("values_item_{$i}_title", array(
            'label' => sprintf(__('Value %d Title', 'headless'), $i),
            'section' => 'values_section',
            'type' => 'text',
        ));

        // Description
        $wp_customize->add_setting("values_item_{$i}_description", array(
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control("values_item_{$i}_description", array(
            'label' => sprintf(__('Value %d Description', 'headless'), $i),
            'section' => 'values_section',
            'type' => 'text',
        ));

        // Icon
        $wp_customize->add_setting("values_item_{$i}_icon", array(
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control("values_item_{$i}_icon", array(
            'label' => sprintf(__('Value %d Icon (FontAwesome name without "fa-" prefix)', 'headless'), $i),
            'section' => 'values_section',
            'type' => 'text',
        ));
    }
}

/**
 * Gallery Section
 */
function headless_customizer_gallery_section($wp_customize)
{
    $wp_customize->add_section('gallery_section', array(
        'title' => __('Gallery Section', 'headless'),
        'panel' => 'front_page_options',
    ));

    // Badge Text
    $wp_customize->add_setting('gallery_badge_text', array(
        'default' => 'Our Latest Events',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('gallery_badge_text', array(
        'label' => __('Badge Text', 'headless'),
        'section' => 'gallery_section',
        'type' => 'text',
    ));

    // Heading
    $wp_customize->add_setting('gallery_heading', array(
        'default' => 'Photo Gallery',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('gallery_heading', array(
        'label' => __('Heading', 'headless'),
        'section' => 'gallery_section',
        'type' => 'text',
    ));

    // Gallery Items (4 items)
    for ($i = 1; $i <= 4; $i++) {
        // Image
        $wp_customize->add_setting("gallery_item_{$i}_image", array(
            'sanitize_callback' => 'esc_url_raw',
        ));

        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, "gallery_item_{$i}_image", array(
            'label' => sprintf(__('Gallery Item %d Image', 'headless'), $i),
            'section' => 'gallery_section',
        )));

        // Title
        $wp_customize->add_setting("gallery_item_{$i}_title", array(
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control("gallery_item_{$i}_title", array(
            'label' => sprintf(__('Gallery Item %d Title', 'headless'), $i),
            'section' => 'gallery_section',
            'type' => 'text',
        ));

        // Description
        $wp_customize->add_setting("gallery_item_{$i}_description", array(
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control("gallery_item_{$i}_description", array(
            'label' => sprintf(__('Gallery Item %d Description', 'headless'), $i),
            'section' => 'gallery_section',
            'type' => 'text',
        ));
    }
}

/**
 * Testimonials Section
 */
function headless_customizer_testimonials_section($wp_customize)
{
    $wp_customize->add_section('testimonials_section', array(
        'title' => __('Testimonials Section', 'headless'),
        'panel' => 'front_page_options',
    ));

    // Background Image
    $wp_customize->add_setting('testimonials_background', array(
        'default' => get_template_directory_uri() . '/images/background-patterns/community-voices-lines-only.svg',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'testimonials_background', array(
        'label' => __('Background Image', 'headless'),
        'section' => 'testimonials_section',
    )));

    // Badge Text
    $wp_customize->add_setting('testimonials_badge_text', array(
        'default' => 'What People Say',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('testimonials_badge_text', array(
        'label' => __('Badge Text', 'headless'),
        'section' => 'testimonials_section',
        'type' => 'text',
    ));

    // Heading
    $wp_customize->add_setting('testimonials_heading', array(
        'default' => 'Community Voices',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('testimonials_heading', array(
        'label' => __('Heading', 'headless'),
        'section' => 'testimonials_section',
        'type' => 'text',
    ));

    // Testimonial Items (3 items)
    for ($i = 1; $i <= 3; $i++) {
        // Name
        $wp_customize->add_setting("testimonial_{$i}_name", array(
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control("testimonial_{$i}_name", array(
            'label' => sprintf(__('Testimonial %d Name', 'headless'), $i),
            'section' => 'testimonials_section',
            'type' => 'text',
        ));

        // Title/Position
        $wp_customize->add_setting("testimonial_{$i}_title", array(
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control("testimonial_{$i}_title", array(
            'label' => sprintf(__('Testimonial %d Title/Position', 'headless'), $i),
            'section' => 'testimonials_section',
            'type' => 'text',
        ));

        // Quote
        $wp_customize->add_setting("testimonial_{$i}_quote", array(
            'sanitize_callback' => 'sanitize_textarea_field',
        ));

        $wp_customize->add_control("testimonial_{$i}_quote", array(
            'label' => sprintf(__('Testimonial %d Quote', 'headless'), $i),
            'section' => 'testimonials_section',
            'type' => 'textarea',
        ));

        // Image
        $wp_customize->add_setting("testimonial_{$i}_image", array(
            'sanitize_callback' => 'esc_url_raw',
        ));

        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, "testimonial_{$i}_image", array(
            'label' => sprintf(__('Testimonial %d Image', 'headless'), $i),
            'section' => 'testimonials_section',
        )));
    }
}

/**
 * Events Section
 */
function headless_customizer_events_section($wp_customize)
{
    $wp_customize->add_section('events_section', array(
        'title' => __('Events Section', 'headless'),
        'panel' => 'front_page_options',
    ));

    // Badge Text
    $wp_customize->add_setting('events_badge_text', array(
        'default' => 'Join Us',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('events_badge_text', array(
        'label' => __('Badge Text', 'headless'),
        'section' => 'events_section',
        'type' => 'text',
    ));

    // Heading
    $wp_customize->add_setting('events_heading', array(
        'default' => 'Upcoming Events',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('events_heading', array(
        'label' => __('Heading', 'headless'),
        'section' => 'events_section',
        'type' => 'text',
    ));

    // Button Text
    $wp_customize->add_setting('events_button_text', array(
        'default' => 'All Events',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('events_button_text', array(
        'label' => __('Button Text', 'headless'),
        'section' => 'events_section',
        'type' => 'text',
    ));

    // Button URL
    $wp_customize->add_setting('events_button_url', array(
        'default' => '/events',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('events_button_url', array(
        'label' => __('Button URL', 'headless'),
        'section' => 'events_section',
        'type' => 'url',
    ));

    // Events Source
    $wp_customize->add_setting('events_source', array(
        'default' => 'custom',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('events_source', array(
        'label' => __('Events Source', 'headless'),
        'section' => 'events_section',
        'type' => 'radio',
        'choices' => array(
            'custom' => __('Custom Events (defined below)', 'headless'),
            'auto' => __('Automatic (from Events post type)', 'headless'),
        ),
    ));

    // Number of automatic events to display
    $wp_customize->add_setting('events_count', array(
        'default' => 3,
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control('events_count', array(
        'label' => __('Number of Events to Display (when automatic)', 'headless'),
        'section' => 'events_section',
        'type' => 'number',
        'input_attrs' => array(
            'min' => 1,
            'max' => 6,
            'step' => 1,
        ),
    ));

    // Custom Event Items (3 items)
    for ($i = 1; $i <= 3; $i++) {
        // Title
        $wp_customize->add_setting("event_{$i}_title", array(
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control("event_{$i}_title", array(
            'label' => sprintf(__('Event %d Title', 'headless'), $i),
            'section' => 'events_section',
            'type' => 'text',
        ));

        // Date
        $wp_customize->add_setting("event_{$i}_date", array(
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control("event_{$i}_date", array(
            'label' => sprintf(__('Event %d Date (YYYY-MM-DD format)', 'headless'), $i),
            'section' => 'events_section',
            'type' => 'text',
        ));

        // Time
        $wp_customize->add_setting("event_{$i}_time", array(
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control("event_{$i}_time", array(
            'label' => sprintf(__('Event %d Time (HH:MM format)', 'headless'), $i),
            'section' => 'events_section',
            'type' => 'text',
        ));

        // Location
        $wp_customize->add_setting("event_{$i}_location", array(
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control("event_{$i}_location", array(
            'label' => sprintf(__('Event %d Location', 'headless'), $i),
            'section' => 'events_section',
            'type' => 'text',
        ));

        // Image
        $wp_customize->add_setting("event_{$i}_image", array(
            'sanitize_callback' => 'esc_url_raw',
        ));

        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, "event_{$i}_image", array(
            'label' => sprintf(__('Event %d Image', 'headless'), $i),
            'section' => 'events_section',
        )));

        // URL
        $wp_customize->add_setting("event_{$i}_url", array(
            'sanitize_callback' => 'esc_url_raw',
        ));

        $wp_customize->add_control("event_{$i}_url", array(
            'label' => sprintf(__('Event %d URL', 'headless'), $i),
            'section' => 'events_section',
            'type' => 'url',
        ));
    }
}

add_action('customize_register', 'headless_register_front_page_options');

/**
 * Helper Functions to Get Front Page Options
 */

/**
 * Get Hero Section Options
 */
function headless_get_hero_options()
{
    return array(
        'background' => get_theme_mod('hero_background', get_template_directory_uri() . '/images/background-patterns/hero-background.svg'),
        'badge_text' => get_theme_mod('hero_badge_text', 'Welcome to Africa Center Hong Kong'),
        'heading' => get_theme_mod('hero_heading', 'Rebranding <span class="text-secondary-gold">Blackness</span> in Asia'),
        'description' => get_theme_mod('hero_description', 'We are a platform & creative hub that fosters value-creating interactions between African and non-African communities in Asia'),
        'primary_button_text' => get_theme_mod('hero_primary_button_text', 'Explore Programs'),
        'primary_button_url' => get_theme_mod('hero_primary_button_url', '/programs'),
        'secondary_button_text' => get_theme_mod('hero_secondary_button_text', 'Join Our Newsletter'),
        'secondary_button_url' => get_theme_mod('hero_secondary_button_url', '#newsletter'),
    );
}

/**
 * Get Tagline Options
 */
function headless_get_tagline_options()
{
    return array(
        'text' => get_theme_mod('tagline_text', 'African Solutions for Glocal Issues'),
    );
}

/**
 * Get Featured Programs Options
 */
function headless_get_featured_programs()
{
    $programs = array();
    $count = get_theme_mod('programs_count', 6);

    for ($i = 1; $i <= $count; $i++) {
        $title = get_theme_mod("program_{$i}_title", '');
        if (empty($title)) continue;

        $programs[] = array(
            'title' => $title,
            'image' => get_theme_mod("program_{$i}_image", ''),
            'url' => get_theme_mod("program_{$i}_url", ''),
            'badge' => get_theme_mod("program_{$i}_badge", ''),
            'description' => get_theme_mod("program_{$i}_description", ''),
        );
    }

    // If no programs are set, return default array
    if (empty($programs)) {
        $programs = array(
            array(
                'title' => 'We have Moved',
                'image' => 'https://www.africacenterhk.com/wp-content/uploads/we-moved-1024x576.png',
                'url' => '/directions',
                'badge' => 'New Location'
            ),
            array(
                'title' => 'Christmas Camp Open for Sign-up!',
                'image' => 'https://www.africacenterhk.com/wp-content/uploads/Afro-multi-activity-camp-summer-christmas-easter-1-1024x576.jpg',
                'url' => '/afro-multi-activity-christmas-camp-2025',
                'badge' => 'For Kids'
            ),
            array(
                'title' => 'Newly Added Event for Art Lovers!',
                'image' => 'https://www.africacenterhk.com/wp-content/uploads/Cool-Africa-Craft-Crunch-1024x576.png',
                'url' => '/events',
                'badge' => 'Art & Culture'
            ),
        );
    }

    return $programs;
}

/**
 * Get Featured Programs Section Options
 */
function headless_get_programs_section_options()
{
    return array(
        'badge_text' => get_theme_mod('programs_badge_text', 'Discover'),
        'heading' => get_theme_mod('programs_heading', 'Featured Programs'),
        'button_text' => get_theme_mod('programs_button_text', 'View All Programs'),
        'button_url' => get_theme_mod('programs_button_url', '/programs'),
    );
}

/**
 * Get Mission Items
 */
function headless_get_mission_items()
{
    $items = array();

    for ($i = 1; $i <= 3; $i++) {
        $title = get_theme_mod("mission_item_{$i}_title", '');
        if (empty($title)) continue;

        $items[] = array(
            'title' => $title,
            'description' => get_theme_mod("mission_item_{$i}_description", ''),
            'icon' => get_theme_mod("mission_item_{$i}_icon", ''),
            'url' => get_theme_mod("mission_item_{$i}_url", ''),
        );
    }

    // If no items are set, return default array
    if (empty($items)) {
        $items = array(
            array(
                'title' => 'Rebranding Blackness',
                'description' => 'Blackness is often associated with danger and/or vulnerability, we challenge this perception and offer an opportunity to appreciate and benefit from accurate representations of blackness.',
                'icon' => 'refresh',
                'url' => 'https://themilsource.com/2021/12/03/how-africa-center-hong-kong-founder-and-ceo-innocent-mutanga-is-rebranding-africa/'
            ),
            array(
                'title' => 'Connecting Communities',
                'description' => 'We aim to become the biggest uniquely African platform in Asia to connect and build communities across ethnic groups, gender, socio-economic status, etc., and facilitate value-exchange between these communities.',
                'icon' => 'users',
                'url' => 'https://www.africacenterhk.com/2022/04/26/connecting-communities-april-2022%ef%bc%89/'
            ),
            array(
                'title' => 'Black Consciousness',
                'description' => 'We champion an African perspective, especially the need for consciousness of the power dynamics rooted in colonialism and the need for self-love. We emphasize the value and need of an African perspective in today\'s uncertain world.',
                'icon' => 'brain',
                'url' => 'https://www.africacenterhk.com/2021/10/19/our-hairstory-oct-2021/'
            )
        );
    }

    return $items;
}

/**
 * Get Mission Section Options
 */
function headless_get_mission_section_options()
{
    return array(
        'background' => get_theme_mod('mission_background', get_template_directory_uri() . '/images/background-patterns/our-purpose-background.svg'),
        'badge_text' => get_theme_mod('mission_badge_text', 'Our Purpose'),
        'heading' => get_theme_mod('mission_heading', 'We work for a future where Africa has an equal footing'),
    );
}

/**
 * Get Values Items
 */
function headless_get_values()
{
    $values = array();

    for ($i = 1; $i <= 4; $i++) {
        $title = get_theme_mod("values_item_{$i}_title", '');
        if (empty($title)) continue;

        $values[] = array(
            'title' => $title,
            'description' => get_theme_mod("values_item_{$i}_description", ''),
            'icon' => get_theme_mod("values_item_{$i}_icon", ''),
        );
    }

    // If no values are set, return default array
    if (empty($values)) {
        $values = array(
            array(
                'title' => 'Diversity',
                'description' => 'We welcome and appreciate different perspectives',
                'icon' => 'users'
            ),
            array(
                'title' => 'Curiosity',
                'description' => 'We value curiosity and continuous learning',
                'icon' => 'eye'
            ),
            array(
                'title' => 'Empathy',
                'description' => 'We encourage stepping into other\'s shoes and seeing the world through their eyes',
                'icon' => 'heart'
            ),
            array(
                'title' => 'Dignity',
                'description' => 'We prioritize dignity in all our interactions',
                'icon' => 'hand'
            )
        );
    }

    return $values;
}

/**
 * Get Values Section Options
 */
function headless_get_values_section_options()
{
    return array(
        'badge_text' => get_theme_mod('values_badge_text', 'What Guides Us'),
        'heading' => get_theme_mod('values_heading', 'Our Values'),
    );
}

/**
 * Get Gallery Items
 */
function headless_get_gallery_items()
{
    $items = array();

    for ($i = 1; $i <= 4; $i++) {
        $image = get_theme_mod("gallery_item_{$i}_image", '');
        $title = get_theme_mod("gallery_item_{$i}_title", '');

        if (empty($image) && empty($title)) continue;

        $items[] = array(
            'image' => $image,
            'title' => $title,
            'description' => get_theme_mod("gallery_item_{$i}_description", ''),
        );
    }

    // If no items are set, return default array
    if (empty($items)) {
        $items = array(
            array(
                'image' => get_template_directory_uri() . '/images/placeholder-1.jpg',
                'title' => 'Cultural Exhibition',
                'description' => 'A display of traditional African art.'
            ),
            array(
                'image' => get_template_directory_uri() . '/images/placeholder-2.jpg',
                'title' => 'Youth Workshop',
                'description' => 'Engaging young people in cultural learning.'
            ),
            array(
                'image' => get_template_directory_uri() . '/images/placeholder-3.jpg',
                'title' => 'Dance Performance',
                'description' => 'Traditional African dance showcase.'
            ),
            array(
                'image' => get_template_directory_uri() . '/images/placeholder-1.jpg',
                'title' => 'Community Gathering',
                'description' => 'Bringing together diverse communities.'
            )
        );
    }

    return $items;
}

/**
 * Get Gallery Section Options
 */
function headless_get_gallery_section_options()
{
    return array(
        'badge_text' => get_theme_mod('gallery_badge_text', 'Our Latest Events'),
        'heading' => get_theme_mod('gallery_heading', 'Photo Gallery'),
    );
}

/**
 * Get Testimonials
 */
function headless_get_testimonials()
{
    $testimonials = array();

    for ($i = 1; $i <= 3; $i++) {
        $name = get_theme_mod("testimonial_{$i}_name", '');
        if (empty($name)) continue;

        $testimonials[] = array(
            'name' => $name,
            'title' => get_theme_mod("testimonial_{$i}_title", ''),
            'quote' => get_theme_mod("testimonial_{$i}_quote", ''),
            'image' => get_theme_mod("testimonial_{$i}_image", ''),
        );
    }

    // If no testimonials are set, return default array
    if (empty($testimonials)) {
        $testimonials = array(
            array(
                'name' => 'Laura Akech',
                'title' => 'English Teacher',
                'quote' => 'It is a fun and family-friendly space to find heartwarming African food and direct connection to the local African community. The center is for everyone, where they can freely express themselves and their ideas.',
                'image' => 'https://www.africacenterhk.com/wp-content/uploads/cropped-Screenshot-2023-01-05-at-11.41.18.png'
            ),
            array(
                'name' => 'Felix',
                'title' => 'Researcher',
                'quote' => 'The Africa Center is a turning point for the African communities within Hong Kong, and for those who wish to learn and integrate with the community not just within the city, but through out the African diaspora.',
                'image' => 'https://www.africacenterhk.com/wp-content/uploads/cropped-Screenshot-2023-01-05-at-11.41.23.png'
            ),
            array(
                'name' => 'Daniela Lusan',
                'title' => 'Radio Show Host',
                'quote' => 'I value the \'African Literature Book Club\' as I value Women\'s Day and Black History Month because African literature deserves a spotlight.',
                'image' => 'https://www.africacenterhk.com/wp-content/uploads/2020/09/Daniela.png'
            )
        );
    }

    return $testimonials;
}

/**
 * Get Testimonials Section Options
 */
function headless_get_testimonials_section_options()
{
    return array(
        'background' => get_theme_mod('testimonials_background', get_template_directory_uri() . '/images/background-patterns/community-voices-lines-only.svg'),
        'badge_text' => get_theme_mod('testimonials_badge_text', 'What People Say'),
        'heading' => get_theme_mod('testimonials_heading', 'Community Voices'),
    );
}

/**
 * Get Events
 */
function headless_get_events()
{
    $events_source = get_theme_mod('events_source', 'custom');

    if ($events_source === 'auto') {
        // Use events post type
        $events_count = get_theme_mod('events_count', 3);
        $args = array(
            'post_type' => 'event',
            'posts_per_page' => $events_count,
            'meta_key' => '_event_date',  // Assuming events use this meta key for date
            'orderby' => 'meta_value',
            'order' => 'ASC',
            'meta_query' => array(
                array(
                    'key' => '_event_date',
                    'value' => date('Y-m-d'),
                    'compare' => '>=',
                    'type' => 'DATE'
                )
            )
        );

        $query = new WP_Query($args);
        $events = array();

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();

                $events[] = array(
                    'title' => get_the_title(),
                    'date' => get_post_meta(get_the_ID(), '_event_date', true),
                    'time' => get_post_meta(get_the_ID(), '_event_time', true),
                    'location' => get_post_meta(get_the_ID(), '_event_location', true),
                    'image' => get_the_post_thumbnail_url(get_the_ID(), 'large'),
                    'url' => get_permalink(),
                );
            }
            wp_reset_postdata();
        }

        // If no events found from post type, fall back to custom events
        if (empty($events)) {
            $events_source = 'custom';
        } else {
            return $events;
        }
    }

    if ($events_source === 'custom') {
        $events = array();

        for ($i = 1; $i <= 3; $i++) {
            $title = get_theme_mod("event_{$i}_title", '');
            if (empty($title)) continue;

            $events[] = array(
                'title' => $title,
                'date' => get_theme_mod("event_{$i}_date", ''),
                'time' => get_theme_mod("event_{$i}_time", ''),
                'location' => get_theme_mod("event_{$i}_location", ''),
                'image' => get_theme_mod("event_{$i}_image", ''),
                'url' => get_theme_mod("event_{$i}_url", ''),
            );
        }

        // If no events are set, return default array
        if (empty($events)) {
            $events = array(
                array(
                    'title' => 'African Literature Book Club',
                    'date' => '2025-10-15',
                    'time' => '19:00',
                    'location' => 'Africa Center HK',
                    'image' => 'https://www.africacenterhk.com/wp-content/uploads/Book-club-1024x576.jpg',
                    'url' => '/events/african-literature-book-club'
                ),
                array(
                    'title' => 'Ethiopian Coffee Ceremony',
                    'date' => '2025-10-20',
                    'time' => '14:30',
                    'location' => 'Africa Center HK',
                    'image' => 'https://www.africacenterhk.com/wp-content/uploads/Coffee-ceremony-1024x576.jpg',
                    'url' => '/events/ethiopian-coffee-ceremony'
                ),
                array(
                    'title' => 'African Dance Workshop',
                    'date' => '2025-10-25',
                    'time' => '16:00',
                    'location' => 'Africa Center HK',
                    'image' => 'https://www.africacenterhk.com/wp-content/uploads/Dance-workshop-1024x576.jpg',
                    'url' => '/events/african-dance-workshop'
                )
            );
        }
    }

    return $events;
}

/**
 * Get Events Section Options
 */
function headless_get_events_section_options()
{
    return array(
        'badge_text' => get_theme_mod('events_badge_text', 'Join Us'),
        'heading' => get_theme_mod('events_heading', 'Upcoming Events'),
        'button_text' => get_theme_mod('events_button_text', 'All Events'),
        'button_url' => get_theme_mod('events_button_url', '/events'),
    );
}
