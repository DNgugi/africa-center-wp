<?php

/**
 * Component System
 *
 * @package headless
 */

if (!defined('ABSPATH')) {
    exit;
}

class Headless_Component_System
{
    private static $instance = null;
    private $components = array();

    public static function get_instance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct()
    {
        $this->register_default_components();
        add_action('init', array($this, 'register_section_post_type'));
        add_action('admin_menu', array($this, 'add_components_page'));
    }

    public function register_default_components()
    {
        $this->components = array(
            'hero' => array(
                'name' => __('Hero Section', 'headless'),
                'description' => __('A prominent header section with various styles', 'headless'),
                'styles' => array('default', 'fullscreen', 'split', 'minimal'),
            ),
            'team-members' => array(
                'name' => __('Team Members', 'headless'),
                'description' => __('Display team members in a grid or list layout', 'headless'),
                'styles' => array('grid', 'list', 'cards'),
            ),
            'events' => array(
                'name' => __('Events', 'headless'),
                'description' => __('Display upcoming events with filtering options', 'headless'),
                'styles' => array('grid', 'list', 'calendar'),
            ),
            'cultural-items' => array(
                'name' => __('Cultural Items', 'headless'),
                'description' => __('Showcase cultural items in a filterable grid', 'headless'),
                'styles' => array('grid', 'masonry', 'carousel'),
            ),
            'news-grid' => array(
                'name' => __('News & Blog', 'headless'),
                'description' => __('Display news and blog posts in a modern grid', 'headless'),
                'styles' => array('grid', 'list', 'magazine'),
            ),
            'content-grid' => array(
                'name' => __('Content Grid', 'headless'),
                'description' => __('Display content in a grid layout', 'headless'),
                'styles' => array('standard', 'masonry', 'cards'),
            ),
            'feature-blocks' => array(
                'name' => __('Feature Blocks', 'headless'),
                'description' => __('Highlight key features or services', 'headless'),
                'styles' => array('standard', 'alternating', 'columns'),
            ),
            'testimonials' => array(
                'name' => __('Testimonials', 'headless'),
                'description' => __('Display customer testimonials', 'headless'),
                'styles' => array('grid', 'slider', 'quotes'),
            ),
            'team-members' => array(
                'name' => __('Team Members', 'headless'),
                'description' => __('Show your team in a grid layout', 'headless'),
                'styles' => array('grid', 'list', 'cards'),
            ),
            'gallery' => array(
                'name' => __('Gallery', 'headless'),
                'description' => __('Display images in various layouts', 'headless'),
                'styles' => array('grid', 'masonry', 'carousel'),
            ),
            'cta' => array(
                'name' => __('Call to Action', 'headless'),
                'description' => __('Promote actions with striking designs', 'headless'),
                'styles' => array('standard', 'fullwidth', 'boxed'),
            ),
        );
    }

    public function register_section_post_type()
    {
        $labels = array(
            'name' => __('Sections', 'headless'),
            'singular_name' => __('Section', 'headless'),
            'add_new' => __('Add New Section', 'headless'),
            'add_new_item' => __('Add New Section', 'headless'),
            'edit_item' => __('Edit Section', 'headless'),
            'new_item' => __('New Section', 'headless'),
            'view_item' => __('View Section', 'headless'),
            'search_items' => __('Search Sections', 'headless'),
            'not_found' => __('No sections found', 'headless'),
            'not_found_in_trash' => __('No sections found in Trash', 'headless'),
        );

        $args = array(
            'labels' => $labels,
            'public' => false,
            'show_ui' => true,
            'show_in_menu' => true,
            'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
            'menu_icon' => 'dashicons-layout',
            'menu_position' => 20,
            'has_archive' => false,
            'show_in_rest' => true,
        );

        register_post_type('headless_section', $args);
    }

    public function add_components_page()
    {
        add_menu_page(
            __('Components', 'headless'),
            __('Components', 'headless'),
            'manage_options',
            'headless-components',
            array($this, 'render_components_page'),
            'dashicons-layout',
            20
        );
    }

    public function render_components_page()
    {
?>
        <div class="wrap">
            <h1><?php echo esc_html__('Components Library', 'headless'); ?></h1>
            <div class="components-grid">
                <?php foreach ($this->components as $key => $component) : ?>
                    <div class="component-card">
                        <h2><?php echo esc_html($component['name']); ?></h2>
                        <p><?php echo esc_html($component['description']); ?></p>
                        <div class="component-styles">
                            <h3><?php echo esc_html__('Available Styles:', 'headless'); ?></h3>
                            <ul>
                                <?php foreach ($component['styles'] as $style) : ?>
                                    <li><?php echo esc_html(ucfirst($style)); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
<?php
    }

    public function get_component_settings($component_type)
    {
        $base_settings = array(
            'layout' => array(
                'width' => 'container',
                'padding' => 'medium',
                'margin' => 'medium',
                'background_style' => 'none',
            ),
            'typography' => array(
                'heading_size' => 'large',
                'text_alignment' => 'left',
                'font_style' => 'default',
            ),
            'colors' => array(
                'background' => '',
                'text' => '',
                'accent' => '',
            ),
            'animation' => array(
                'entrance' => 'none',
                'scroll_effects' => 'none',
            ),
        );

        return apply_filters("headless_component_{$component_type}_settings", $base_settings);
    }
}

// Initialize the component system
function headless_component_system()
{
    return Headless_Component_System::get_instance();
}
headless_component_system();
