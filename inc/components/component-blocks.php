<?php

/**
 * Component Blocks Registration
 *
 * @package headless
 */

if (!defined('ABSPATH')) {
    exit;
}

class Headless_Component_Blocks
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
        add_action('init', array($this, 'register_blocks'));
        add_action('enqueue_block_editor_assets', array($this, 'enqueue_block_editor_assets'));
    }

    public function register_blocks()
    {
        // Only register if Gutenberg is available
        if (!function_exists('register_block_type')) {
            return;
        }

        $blocks = array(
            'team-members' => array(
                'render_callback' => array($this, 'render_team_members_block'),
                'attributes' => array(
                    'layout_style' => array('type' => 'string', 'default' => 'grid'),
                    'columns' => array('type' => 'number', 'default' => 3),
                    'show_social' => array('type' => 'boolean', 'default' => true),
                    'category' => array('type' => 'string', 'default' => ''),
                    'limit' => array('type' => 'number', 'default' => -1)
                )
            ),
            'events' => array(
                'render_callback' => array($this, 'render_events_block'),
                'attributes' => array(
                    'layout_style' => array('type' => 'string', 'default' => 'grid'),
                    'show_filters' => array('type' => 'boolean', 'default' => true),
                    'category' => array('type' => 'string', 'default' => ''),
                    'limit' => array('type' => 'number', 'default' => -1),
                    'orderby' => array('type' => 'string', 'default' => 'event_date'),
                    'order' => array('type' => 'string', 'default' => 'ASC')
                )
            ),
            'cultural-items' => array(
                'render_callback' => array($this, 'render_cultural_items_block'),
                'attributes' => array(
                    'layout_style' => array('type' => 'string', 'default' => 'grid'),
                    'show_filters' => array('type' => 'boolean', 'default' => true),
                    'masonry' => array('type' => 'boolean', 'default' => false),
                    'category' => array('type' => 'string', 'default' => ''),
                    'limit' => array('type' => 'number', 'default' => -1)
                )
            ),
            'news-grid' => array(
                'render_callback' => array($this, 'render_news_grid_block'),
                'attributes' => array(
                    'layout_style' => array('type' => 'string', 'default' => 'grid'),
                    'show_filters' => array('type' => 'boolean', 'default' => true),
                    'show_categories' => array('type' => 'boolean', 'default' => true),
                    'show_excerpt' => array('type' => 'boolean', 'default' => true),
                    'excerpt_length' => array('type' => 'number', 'default' => 20),
                    'category' => array('type' => 'string', 'default' => ''),
                    'limit' => array('type' => 'number', 'default' => 9)
                )
            )
        );

        foreach ($blocks as $block_name => $block_config) {
            register_block_type(
                'headless/' . $block_name,
                array_merge(
                    array(
                        'editor_script' => 'headless-blocks',
                        'editor_style' => 'headless-blocks-editor',
                    ),
                    $block_config
                )
            );
        }
    }

    public function enqueue_block_editor_assets()
    {
        // Enqueue block editor script
        wp_enqueue_script(
            'headless-blocks',
            get_template_directory_uri() . '/js/blocks.js',
            array('wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor'),
            filemtime(get_template_directory() . '/js/blocks.js'),
            true
        );

        // Enqueue editor styles
        wp_enqueue_style(
            'headless-blocks-editor',
            get_template_directory_uri() . '/css/blocks-editor.css',
            array('wp-edit-blocks'),
            filemtime(get_template_directory() . '/css/blocks-editor.css')
        );
    }

    public function render_team_members_block($attributes)
    {
        $shortcode_atts = array(
            'layout_style' => $attributes['layout_style'],
            'columns' => $attributes['columns'],
            'show_social' => $attributes['show_social'] ? 'true' : 'false',
            'category' => $attributes['category'],
            'limit' => $attributes['limit']
        );

        return headless_component_shortcodes()->render_team_members($shortcode_atts);
    }

    public function render_events_block($attributes)
    {
        $shortcode_atts = array(
            'layout_style' => $attributes['layout_style'],
            'show_filters' => $attributes['show_filters'] ? 'true' : 'false',
            'category' => $attributes['category'],
            'limit' => $attributes['limit'],
            'orderby' => $attributes['orderby'],
            'order' => $attributes['order']
        );

        return headless_component_shortcodes()->render_events($shortcode_atts);
    }

    public function render_cultural_items_block($attributes)
    {
        $shortcode_atts = array(
            'layout_style' => $attributes['layout_style'],
            'show_filters' => $attributes['show_filters'] ? 'true' : 'false',
            'masonry' => $attributes['masonry'] ? 'true' : 'false',
            'category' => $attributes['category'],
            'limit' => $attributes['limit']
        );

        return headless_component_shortcodes()->render_cultural_items($shortcode_atts);
    }

    public function render_news_grid_block($attributes)
    {
        $shortcode_atts = array(
            'layout_style' => $attributes['layout_style'],
            'show_filters' => $attributes['show_filters'] ? 'true' : 'false',
            'show_categories' => $attributes['show_categories'] ? 'true' : 'false',
            'show_excerpt' => $attributes['show_excerpt'] ? 'true' : 'false',
            'excerpt_length' => $attributes['excerpt_length'],
            'category' => $attributes['category'],
            'limit' => $attributes['limit']
        );

        return headless_component_shortcodes()->render_news_grid($shortcode_atts);
    }
}

// Initialize blocks
function headless_component_blocks()
{
    return Headless_Component_Blocks::get_instance();
}
headless_component_blocks();
