<?php

/**
 * Register our components
 */

if (!defined('ABSPATH')) {
    exit;
}

function headless_register_components()
{
    $component_paths = array(
        'hero' => get_template_directory() . '/template-parts/components/hero.php',
        'team-members' => get_template_directory() . '/template-parts/components/team-members.php',
        'events' => get_template_directory() . '/template-parts/components/events.php',
        'cultural-items' => get_template_directory() . '/template-parts/components/cultural-items.php',
        'news-grid' => get_template_directory() . '/template-parts/components/news-grid.php',
        'cta' => get_template_directory() . '/template-parts/components/cta.php',
        'stats' => get_template_directory() . '/template-parts/components/stats.php',
        'faq' => get_template_directory() . '/template-parts/components/faq.php'
    );

    $component_hooks = array(
        'hero' => array(
            'before' => 'headless_before_hero',
            'after' => 'headless_after_hero'
        ),
        'team-members' => array(
            'before' => 'headless_before_team_members',
            'after' => 'headless_after_team_members'
        ),
        'events' => array(
            'before' => 'headless_before_events',
            'after' => 'headless_after_events'
        ),
        'cultural-items' => array(
            'before' => 'headless_before_cultural_items',
            'after' => 'headless_after_cultural_items'
        ),
        'news-grid' => array(
            'before' => 'headless_before_news_grid',
            'after' => 'headless_after_news_grid'
        ),
        'cta' => array(
            'before' => 'headless_before_cta',
            'after' => 'headless_after_cta'
        ),
        'stats' => array(
            'before' => 'headless_before_stats',
            'after' => 'headless_after_stats'
        ),
        'faq' => array(
            'before' => 'headless_before_faq',
            'after' => 'headless_after_faq'
        )
    );

    return array(
        'paths' => $component_paths,
        'hooks' => $component_hooks
    );
}

function headless_register_component_categories()
{
    if (!function_exists('register_block_type')) {
        return;
    }

    register_block_category('headless-components', array(
        'title' => __('Headless Components', 'headless'),
        'icon' => 'layout'
    ));
}
add_action('init', 'headless_register_component_categories');
