<?php

/**
 * Component Renderer
 *
 * @package headless
 */

if (!defined('ABSPATH')) {
    exit;
}

class Headless_Component_Renderer
{
    private static $instance = null;

    public static function get_instance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function render_component($type, $settings = array())
    {
        $defaults = headless_component_system()->get_component_settings($type);
        $settings = wp_parse_args($settings, $defaults);

        // Get component classes based on settings
        $classes = $this->get_component_classes($settings);

        // Start output buffering
        ob_start();

        // Get the component template
        $template = $this->get_component_template($type);

        if ($template) {
            include $template;
        }

        return ob_get_clean();
    }

    private function get_component_classes($settings)
    {
        $classes = array();

        // Container width
        switch ($settings['layout']['width']) {
            case 'container':
                $classes[] = 'container mx-auto px-4';
                break;
            case 'full-width':
                $classes[] = 'w-full';
                break;
            case 'narrow':
                $classes[] = 'container mx-auto px-4 max-w-3xl';
                break;
        }

        // Padding
        switch ($settings['layout']['padding']) {
            case 'none':
                break;
            case 'small':
                $classes[] = 'py-4';
                break;
            case 'medium':
                $classes[] = 'py-8';
                break;
            case 'large':
                $classes[] = 'py-16';
                break;
        }

        // Text alignment
        $classes[] = 'text-' . $settings['typography']['text_alignment'];

        // Animation
        if ($settings['animation']['entrance'] !== 'none') {
            $classes[] = 'animate-' . $settings['animation']['entrance'];
        }

        return implode(' ', $classes);
    }

    private function get_component_template($type)
    {
        $template_path = get_template_directory() . '/template-parts/components/' . $type . '.php';

        if (file_exists($template_path)) {
            return $template_path;
        }

        return false;
    }

    public function get_style_output($settings)
    {
        $styles = array();

        if (!empty($settings['colors']['background'])) {
            $styles[] = 'background-color: ' . esc_attr($settings['colors']['background']);
        }

        if (!empty($settings['colors']['text'])) {
            $styles[] = 'color: ' . esc_attr($settings['colors']['text']);
        }

        return !empty($styles) ? ' style="' . implode('; ', $styles) . '"' : '';
    }
}

// Initialize the component renderer
function headless_component_renderer()
{
    return Headless_Component_Renderer::get_instance();
}
headless_component_renderer();
