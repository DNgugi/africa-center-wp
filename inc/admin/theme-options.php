<?php

/**
 * Theme Options Customizer
 *
 * @package wpac
 */

if (!defined('ABSPATH')) {
    exit;
}

class WPAC_Theme_Options
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
            'title' => __('Theme Options', 'wpac'),
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
            'title' => __('Typography', 'wpac'),
            'panel' => 'theme_options',
        ));

        $elements = array(
            'body' => __('Body Text', 'wpac'),
            'headings' => __('Headings', 'wpac'),
            'nav' => __('Navigation', 'wpac'),
            'buttons' => __('Buttons', 'wpac'),
        );

        foreach ($elements as $key => $label) {
            // Font Family
            $wp_customize->add_setting("typography_{$key}_font", array(
                'default' => 'default',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control("typography_{$key}_font", array(
                'label' => sprintf(__('%s Font Family', 'wpac'), $label),
                'section' => 'typography_options',
                'type' => 'select',
                'choices' => array(
                    'default' => __('Theme Default', 'wpac'),
                    'sans' => __('Sans Serif', 'wpac'),
                    'serif' => __('Serif', 'wpac'),
                    'display' => __('Display', 'wpac'),
                ),
            ));

            // Font Weight
            $wp_customize->add_setting("typography_{$key}_weight", array(
                'default' => 'normal',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control("typography_{$key}_weight", array(
                'label' => sprintf(__('%s Font Weight', 'wpac'), $label),
                'section' => 'typography_options',
                'type' => 'select',
                'choices' => array(
                    'light' => __('Light', 'wpac'),
                    'normal' => __('Normal', 'wpac'),
                    'medium' => __('Medium', 'wpac'),
                    'semibold' => __('Semibold', 'wpac'),
                    'bold' => __('Bold', 'wpac'),
                ),
            ));

            // Font Size
            $wp_customize->add_setting("typography_{$key}_size", array(
                'default' => 'medium',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control("typography_{$key}_size", array(
                'label' => sprintf(__('%s Font Size', 'wpac'), $label),
                'section' => 'typography_options',
                'type' => 'select',
                'choices' => array(
                    'small' => __('Small', 'wpac'),
                    'medium' => __('Medium', 'wpac'),
                    'large' => __('Large', 'wpac'),
                    'xl' => __('Extra Large', 'wpac'),
                ),
            ));
        }
    }

    private function add_layout_section($wp_customize)
    {
        $wp_customize->add_section('layout_options', array(
            'title' => __('Layout', 'wpac'),
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
            'label' => __('Default Page Sidebar Layout', 'wpac'),
            'section' => 'layout_options',
            'type' => 'select',
            'choices' => array(
                'no-sidebar' => __('No Sidebar', 'wpac'),
                'left-sidebar' => __('Left Sidebar', 'wpac'),
                'right-sidebar' => __('Right Sidebar', 'wpac'),
            ),
            'priority' => 10,
        ));

        // Page Sidebar Layout
        $wp_customize->add_setting('page_sidebar_layout', array(
            'default' => 'right-sidebar',
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control('page_sidebar_layout', array(
            'label' => __('Page Sidebar Layout', 'wpac'),
            'section' => 'layout_options',
            'type' => 'select',
            'choices' => array(
                'no-sidebar' => __('No Sidebar', 'wpac'),
                'left-sidebar' => __('Left Sidebar', 'wpac'),
                'right-sidebar' => __('Right Sidebar', 'wpac'),
            ),
        ));

        // Container Width
        $wp_customize->add_setting('container_width', array(
            'default' => 'standard',
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control('container_width', array(
            'label' => __('Container Width', 'wpac'),
            'section' => 'layout_options',
            'type' => 'select',
            'choices' => array(
                'narrow' => __('Narrow', 'wpac'),
                'standard' => __('Standard', 'wpac'),
                'wide' => __('Wide', 'wpac'),
                'full' => __('Full Width', 'wpac'),
            ),
        ));

        // Spacing Scale
        $wp_customize->add_setting('spacing_scale', array(
            'default' => 'standard',
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control('spacing_scale', array(
            'label' => __('Spacing Scale', 'wpac'),
            'section' => 'layout_options',
            'type' => 'select',
            'choices' => array(
                'compact' => __('Compact', 'wpac'),
                'standard' => __('Standard', 'wpac'),
                'relaxed' => __('Relaxed', 'wpac'),
            ),
        ));
    }

    private function add_colors_section($wp_customize)
    {
        $wp_customize->add_section('colors_options', array(
            'title' => __('Colors', 'wpac'),
            'panel' => 'theme_options',
        ));

        // Primary Color
        $wp_customize->add_setting('primary_color', array(
            'default' => '#0066cc',
            'sanitize_callback' => 'sanitize_hex_color',
        ));

        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'primary_color', array(
            'label' => __('Primary Color', 'wpac'),
            'section' => 'colors_options',
        )));

        // Secondary Color
        $wp_customize->add_setting('secondary_color', array(
            'default' => '#4a5568',
            'sanitize_callback' => 'sanitize_hex_color',
        ));

        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondary_color', array(
            'label' => __('Secondary Color', 'wpac'),
            'section' => 'colors_options',
        )));

        // Accent Color
        $wp_customize->add_setting('accent_color', array(
            'default' => '#ed8936',
            'sanitize_callback' => 'sanitize_hex_color',
        ));

        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'accent_color', array(
            'label' => __('Accent Color', 'wpac'),
            'section' => 'colors_options',
        )));
    }

    private function add_navigation_section($wp_customize)
    {
        $wp_customize->add_section('nav_options', array(
            'title' => __('Navigation', 'wpac'),
            'panel' => 'theme_options',
        ));

        // Navigation Style
        $wp_customize->add_setting('nav_style', array(
            'default' => 'standard',
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control('nav_style', array(
            'label' => __('Navigation Style', 'wpac'),
            'section' => 'nav_options',
            'type' => 'select',
            'choices' => array(
                'standard' => __('Standard', 'wpac'),
                'centered' => __('Centered', 'wpac'),
                'split' => __('Split with Logo', 'wpac'),
                'fullscreen' => __('Full Screen Overlay', 'wpac'),
            ),
        ));

        // Sticky Header
        $wp_customize->add_setting('sticky_header', array(
            'default' => false,
            'sanitize_callback' => 'wpac_sanitize_checkbox',
        ));

        $wp_customize->add_control('sticky_header', array(
            'label' => __('Enable Sticky Header', 'wpac'),
            'section' => 'nav_options',
            'type' => 'checkbox',
        ));
    }

    private function add_performance_section($wp_customize)
    {
        $wp_customize->add_section('performance_options', array(
            'title' => __('Performance', 'wpac'),
            'panel' => 'theme_options',
        ));

        // Lazy Loading
        $wp_customize->add_setting('lazy_load_images', array(
            'default' => true,
            'sanitize_callback' => 'wpac_sanitize_checkbox',
        ));

        $wp_customize->add_control('lazy_load_images', array(
            'label' => __('Enable Lazy Loading for Images', 'wpac'),
            'section' => 'performance_options',
            'type' => 'checkbox',
        ));

        // Image Quality
        $wp_customize->add_setting('image_quality', array(
            'default' => 'balanced',
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control('image_quality', array(
            'label' => __('Image Quality', 'wpac'),
            'section' => 'performance_options',
            'type' => 'select',
            'choices' => array(
                'high' => __('High Quality', 'wpac'),
                'balanced' => __('Balanced', 'wpac'),
                'optimized' => __('Performance Optimized', 'wpac'),
            ),
        ));

        // Critical CSS
        $wp_customize->add_setting('load_critical_css', array(
            'default' => true,
            'sanitize_callback' => 'wpac_sanitize_checkbox',
        ));

        $wp_customize->add_control('load_critical_css', array(
            'label' => __('Load Critical CSS Inline', 'wpac'),
            'section' => 'performance_options',
            'type' => 'checkbox',
        ));
    }
}

// Initialize the theme options
function wpac_theme_options()
{
    return WPAC_Theme_Options::get_instance();
}
wpac_theme_options();
