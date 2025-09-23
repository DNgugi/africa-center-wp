<?php

/**
 * Theme Options Customizer
 *
 * @package headless
 */

if (!defined('ABSPATH')) {
    exit;
}

class Headless_Theme_Options
{
    private static $instance = null;

    public static function get_instance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct()
    {
        add_action('customize_register', array($this, 'register_theme_options'));
    }

    public function register_theme_options($wp_customize)
    {
        // Add Theme Options Panel
        $wp_customize->add_panel('theme_options', array(
            'title' => __('Theme Options', 'headless'),
            'priority' => 30,
        ));

        // Typography Section
        $this->add_typography_section($wp_customize);

        // Layout Section
        $this->add_layout_section($wp_customize);

        // Colors Section
        $this->add_colors_section($wp_customize);

        // Navigation Section
        $this->add_navigation_section($wp_customize);

        // Performance Section
        $this->add_performance_section($wp_customize);
    }

    private function add_typography_section($wp_customize)
    {
        $wp_customize->add_section('typography_options', array(
            'title' => __('Typography', 'headless'),
            'panel' => 'theme_options',
        ));

        $elements = array(
            'body' => __('Body Text', 'headless'),
            'headings' => __('Headings', 'headless'),
            'nav' => __('Navigation', 'headless'),
            'buttons' => __('Buttons', 'headless'),
        );

        foreach ($elements as $key => $label) {
            // Font Family
            $wp_customize->add_setting("typography_{$key}_font", array(
                'default' => 'default',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control("typography_{$key}_font", array(
                'label' => sprintf(__('%s Font Family', 'headless'), $label),
                'section' => 'typography_options',
                'type' => 'select',
                'choices' => array(
                    'default' => __('Theme Default', 'headless'),
                    'sans' => __('Sans Serif', 'headless'),
                    'serif' => __('Serif', 'headless'),
                    'display' => __('Display', 'headless'),
                ),
            ));

            // Font Weight
            $wp_customize->add_setting("typography_{$key}_weight", array(
                'default' => 'normal',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control("typography_{$key}_weight", array(
                'label' => sprintf(__('%s Font Weight', 'headless'), $label),
                'section' => 'typography_options',
                'type' => 'select',
                'choices' => array(
                    'light' => __('Light', 'headless'),
                    'normal' => __('Normal', 'headless'),
                    'medium' => __('Medium', 'headless'),
                    'semibold' => __('Semibold', 'headless'),
                    'bold' => __('Bold', 'headless'),
                ),
            ));

            // Font Size
            $wp_customize->add_setting("typography_{$key}_size", array(
                'default' => 'medium',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control("typography_{$key}_size", array(
                'label' => sprintf(__('%s Font Size', 'headless'), $label),
                'section' => 'typography_options',
                'type' => 'select',
                'choices' => array(
                    'small' => __('Small', 'headless'),
                    'medium' => __('Medium', 'headless'),
                    'large' => __('Large', 'headless'),
                    'xl' => __('Extra Large', 'headless'),
                ),
            ));
        }
    }

    private function add_layout_section($wp_customize)
    {
        $wp_customize->add_section('layout_options', array(
            'title' => __('Layout', 'headless'),
            'panel' => 'theme_options',
            'priority' => 30,
        ));

        // Page Sidebar Layout
        $wp_customize->add_setting('page_sidebar_layout', array(
            'default' => 'right-sidebar',
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'refresh',
        ));

        $wp_customize->add_control('page_sidebar_layout', array(
            'label' => __('Default Page Sidebar Layout', 'headless'),
            'section' => 'layout_options',
            'type' => 'select',
            'choices' => array(
                'no-sidebar' => __('No Sidebar', 'headless'),
                'left-sidebar' => __('Left Sidebar', 'headless'),
                'right-sidebar' => __('Right Sidebar', 'headless'),
            ),
            'priority' => 10,
        ));

        // Page Sidebar Layout
        $wp_customize->add_setting('page_sidebar_layout', array(
            'default' => 'right-sidebar',
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control('page_sidebar_layout', array(
            'label' => __('Page Sidebar Layout', 'headless'),
            'section' => 'layout_options',
            'type' => 'select',
            'choices' => array(
                'no-sidebar' => __('No Sidebar', 'headless'),
                'left-sidebar' => __('Left Sidebar', 'headless'),
                'right-sidebar' => __('Right Sidebar', 'headless'),
            ),
        ));

        // Container Width
        $wp_customize->add_setting('container_width', array(
            'default' => 'standard',
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control('container_width', array(
            'label' => __('Container Width', 'headless'),
            'section' => 'layout_options',
            'type' => 'select',
            'choices' => array(
                'narrow' => __('Narrow', 'headless'),
                'standard' => __('Standard', 'headless'),
                'wide' => __('Wide', 'headless'),
                'full' => __('Full Width', 'headless'),
            ),
        ));

        // Spacing Scale
        $wp_customize->add_setting('spacing_scale', array(
            'default' => 'standard',
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control('spacing_scale', array(
            'label' => __('Spacing Scale', 'headless'),
            'section' => 'layout_options',
            'type' => 'select',
            'choices' => array(
                'compact' => __('Compact', 'headless'),
                'standard' => __('Standard', 'headless'),
                'relaxed' => __('Relaxed', 'headless'),
            ),
        ));
    }

    private function add_colors_section($wp_customize)
    {
        $wp_customize->add_section('colors_options', array(
            'title' => __('Colors', 'headless'),
            'panel' => 'theme_options',
        ));

        // Primary Color
        $wp_customize->add_setting('primary_color', array(
            'default' => '#0066cc',
            'sanitize_callback' => 'sanitize_hex_color',
        ));

        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'primary_color', array(
            'label' => __('Primary Color', 'headless'),
            'section' => 'colors_options',
        )));

        // Secondary Color
        $wp_customize->add_setting('secondary_color', array(
            'default' => '#4a5568',
            'sanitize_callback' => 'sanitize_hex_color',
        ));

        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondary_color', array(
            'label' => __('Secondary Color', 'headless'),
            'section' => 'colors_options',
        )));

        // Accent Color
        $wp_customize->add_setting('accent_color', array(
            'default' => '#ed8936',
            'sanitize_callback' => 'sanitize_hex_color',
        ));

        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'accent_color', array(
            'label' => __('Accent Color', 'headless'),
            'section' => 'colors_options',
        )));
    }

    private function add_navigation_section($wp_customize)
    {
        $wp_customize->add_section('nav_options', array(
            'title' => __('Navigation', 'headless'),
            'panel' => 'theme_options',
        ));

        // Navigation Style
        $wp_customize->add_setting('nav_style', array(
            'default' => 'standard',
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control('nav_style', array(
            'label' => __('Navigation Style', 'headless'),
            'section' => 'nav_options',
            'type' => 'select',
            'choices' => array(
                'standard' => __('Standard', 'headless'),
                'centered' => __('Centered', 'headless'),
                'split' => __('Split with Logo', 'headless'),
                'fullscreen' => __('Full Screen Overlay', 'headless'),
            ),
        ));

        // Sticky Header
        $wp_customize->add_setting('sticky_header', array(
            'default' => false,
            'sanitize_callback' => 'headless_sanitize_checkbox',
        ));

        $wp_customize->add_control('sticky_header', array(
            'label' => __('Enable Sticky Header', 'headless'),
            'section' => 'nav_options',
            'type' => 'checkbox',
        ));
    }

    private function add_performance_section($wp_customize)
    {
        $wp_customize->add_section('performance_options', array(
            'title' => __('Performance', 'headless'),
            'panel' => 'theme_options',
        ));

        // Lazy Loading
        $wp_customize->add_setting('lazy_load_images', array(
            'default' => true,
            'sanitize_callback' => 'headless_sanitize_checkbox',
        ));

        $wp_customize->add_control('lazy_load_images', array(
            'label' => __('Enable Lazy Loading for Images', 'headless'),
            'section' => 'performance_options',
            'type' => 'checkbox',
        ));

        // Image Quality
        $wp_customize->add_setting('image_quality', array(
            'default' => 'balanced',
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control('image_quality', array(
            'label' => __('Image Quality', 'headless'),
            'section' => 'performance_options',
            'type' => 'select',
            'choices' => array(
                'high' => __('High Quality', 'headless'),
                'balanced' => __('Balanced', 'headless'),
                'optimized' => __('Performance Optimized', 'headless'),
            ),
        ));

        // Critical CSS
        $wp_customize->add_setting('load_critical_css', array(
            'default' => true,
            'sanitize_callback' => 'headless_sanitize_checkbox',
        ));

        $wp_customize->add_control('load_critical_css', array(
            'label' => __('Load Critical CSS Inline', 'headless'),
            'section' => 'performance_options',
            'type' => 'checkbox',
        ));
    }
}

// Initialize the theme options
function headless_theme_options()
{
    return Headless_Theme_Options::get_instance();
}
headless_theme_options();
