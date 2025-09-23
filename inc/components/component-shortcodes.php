<?php

/**
 * Component Shortcodes
 *
 * @package headless
 */

if (!defined('ABSPATH')) {
    exit;
}

class Headless_Component_Shortcodes
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
        $this->register_shortcodes();
    }

    private function register_shortcodes()
    {
        add_shortcode('team_members', array($this, 'render_team_members'));
        add_shortcode('events', array($this, 'render_events'));
        add_shortcode('cultural_items', array($this, 'render_cultural_items'));
        add_shortcode('news_grid', array($this, 'render_news_grid'));
    }

    public function render_team_members($atts)
    {
        $defaults = array(
            'layout_style' => 'grid',
            'columns' => 3,
            'show_social' => true,
            'category' => '',
            'limit' => -1
        );

        $atts = shortcode_atts($defaults, $atts, 'team_members');

        // Get team members
        $args = array(
            'post_type' => 'team_member',
            'posts_per_page' => $atts['limit'],
            'orderby' => 'menu_order',
            'order' => 'ASC'
        );

        if (!empty($atts['category'])) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'team_category',
                    'field' => 'slug',
                    'terms' => explode(',', $atts['category'])
                )
            );
        }

        $team_members = get_posts($args);

        if (empty($team_members)) {
            return '';
        }

        $members_data = array();
        foreach ($team_members as $member) {
            $members_data[] = array(
                'image' => get_post_thumbnail_id($member->ID),
                'name' => get_the_title($member->ID),
                'position' => get_post_meta($member->ID, '_team_position', true),
                'bio' => get_post_meta($member->ID, '_team_bio', true),
                'social_links' => get_post_meta($member->ID, '_team_social_links', true)
            );
        }

        $settings = array(
            'layout_style' => $atts['layout_style'],
            'columns' => $atts['columns'],
            'team_members' => $members_data,
            'show_social' => $atts['show_social']
        );

        ob_start();
        headless_component_renderer()->render_component('team-members', $settings);
        return ob_get_clean();
    }

    public function render_events($atts)
    {
        $defaults = array(
            'layout_style' => 'grid',
            'show_filters' => true,
            'category' => '',
            'limit' => -1,
            'orderby' => 'event_date',
            'order' => 'ASC'
        );

        $atts = shortcode_atts($defaults, $atts, 'events');

        $args = array(
            'post_type' => 'event',
            'posts_per_page' => $atts['limit'],
            'meta_key' => '_event_date',
            'orderby' => $atts['orderby'],
            'order' => $atts['order']
        );

        if (!empty($atts['category'])) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'event_category',
                    'field' => 'slug',
                    'terms' => explode(',', $atts['category'])
                )
            );
        }

        $events = get_posts($args);

        if (empty($events)) {
            return '';
        }

        $events_data = array();
        foreach ($events as $event) {
            $events_data[] = array(
                'image' => get_post_thumbnail_id($event->ID),
                'title' => get_the_title($event->ID),
                'date' => get_post_meta($event->ID, '_event_date', true),
                'time' => get_post_meta($event->ID, '_event_time', true),
                'location' => get_post_meta($event->ID, '_event_location', true),
                'description' => get_post_meta($event->ID, '_event_description', true),
                'button_url' => get_permalink($event->ID),
                'button_text' => __('Learn More', 'headless'),
                'category' => wp_get_post_terms($event->ID, 'event_category', array('fields' => 'names'))[0] ?? ''
            );
        }

        $settings = array(
            'layout_style' => $atts['layout_style'],
            'show_filters' => $atts['show_filters'],
            'events' => $events_data
        );

        ob_start();
        headless_component_renderer()->render_component('events', $settings);
        return ob_get_clean();
    }

    public function render_cultural_items($atts)
    {
        $defaults = array(
            'layout_style' => 'grid',
            'show_filters' => true,
            'masonry' => false,
            'category' => '',
            'limit' => -1
        );

        $atts = shortcode_atts($defaults, $atts, 'cultural_items');

        $args = array(
            'post_type' => 'cultural_item',
            'posts_per_page' => $atts['limit'],
            'orderby' => 'menu_order',
            'order' => 'ASC'
        );

        if (!empty($atts['category'])) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'item_category',
                    'field' => 'slug',
                    'terms' => explode(',', $atts['category'])
                )
            );
        }

        $items = get_posts($args);

        if (empty($items)) {
            return '';
        }

        $items_data = array();
        foreach ($items as $item) {
            $items_data[] = array(
                'image' => get_post_thumbnail_id($item->ID),
                'title' => get_the_title($item->ID),
                'description' => get_post_meta($item->ID, '_item_description', true),
                'origin' => get_post_meta($item->ID, '_item_origin', true),
                'attributes' => get_post_meta($item->ID, '_item_attributes', true),
                'button_url' => get_permalink($item->ID),
                'category' => wp_get_post_terms($item->ID, 'item_category', array('fields' => 'names'))[0] ?? ''
            );
        }

        $settings = array(
            'layout_style' => $atts['layout_style'],
            'show_filters' => $atts['show_filters'],
            'masonry' => $atts['masonry'],
            'items' => $items_data
        );

        ob_start();
        headless_component_renderer()->render_component('cultural-items', $settings);
        return ob_get_clean();
    }

    public function render_news_grid($atts)
    {
        $defaults = array(
            'layout_style' => 'grid',
            'show_filters' => true,
            'show_categories' => true,
            'show_excerpt' => true,
            'excerpt_length' => 20,
            'category' => '',
            'limit' => 9
        );

        $atts = shortcode_atts($defaults, $atts, 'news_grid');

        $args = array(
            'post_type' => 'post',
            'posts_per_page' => $atts['limit'],
            'orderby' => 'date',
            'order' => 'DESC'
        );

        if (!empty($atts['category'])) {
            $args['category_name'] = $atts['category'];
        }

        $posts = get_posts($args);

        if (empty($posts)) {
            return '';
        }

        $posts_data = array();
        foreach ($posts as $post) {
            $categories = get_the_category($post->ID);
            $category_names = array_map(function ($cat) {
                return $cat->name;
            }, $categories);

            $posts_data[] = array(
                'image' => get_post_thumbnail_id($post->ID),
                'title' => get_the_title($post->ID),
                'excerpt' => get_the_excerpt($post),
                'date' => get_the_date('Y-m-d', $post->ID),
                'url' => get_permalink($post->ID),
                'author' => get_the_author_meta('display_name', $post->post_author),
                'author_avatar' => get_avatar_url($post->post_author),
                'categories' => $category_names
            );
        }

        $settings = array(
            'layout_style' => $atts['layout_style'],
            'show_filters' => $atts['show_filters'],
            'show_categories' => $atts['show_categories'],
            'show_excerpt' => $atts['show_excerpt'],
            'excerpt_length' => $atts['excerpt_length'],
            'posts' => $posts_data
        );

        ob_start();
        headless_component_renderer()->render_component('news-grid', $settings);
        return ob_get_clean();
    }
}

// Initialize the shortcodes
function headless_component_shortcodes()
{
    return Headless_Component_Shortcodes::get_instance();
}
headless_component_shortcodes();
