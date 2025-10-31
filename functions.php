<?php

/**
 * wpac functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package wpac
 */

if (! defined('_S_VERSION')) {
	// Replace the version number of the theme on each release.
	define('_S_VERSION', '1.0.1');
}


/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function wpac_setup()
{
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on wpac, use a find and replace
		* to change 'wpac' to the name of your theme in all the template files.
		*/
	load_theme_textdomain('wpac', get_template_directory() . '/languages');

	// Add default posts and comments RSS feed links to head.
	add_theme_support('automatic-feed-links');

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support('title-tag');

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support('post-thumbnails');

	// Add support for Yoast SEO breadcrumbs
	add_theme_support('yoast-seo-breadcrumbs');





	// Load admin files
	require_once get_template_directory() . '/inc/admin/theme-options.php';
	require_once get_template_directory() . '/inc/admin/page-options.php';
	require_once get_template_directory() . '/inc/front-page-options.php';

	// Add support for breadcrumbs
	add_theme_support('yoast-seo-breadcrumbs');

	/**
	 * Display breadcrumbs
	 */
	function wpac_breadcrumbs()
	{
		if (function_exists('yoast_breadcrumb')) {
			yoast_breadcrumb('<nav class="breadcrumbs py-3 text-sm text-gray-600">', '</nav>');
		}
	}

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__('Primary', 'wpac'),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'wpac_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support('customize-selective-refresh-widgets');

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action('after_setup_theme', 'wpac_setup');



/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function wpac_content_width()
{
	$GLOBALS['content_width'] = apply_filters('wpac_content_width', 640);
}
add_action('after_setup_theme', 'wpac_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function wpac_widgets_init()
{
	register_sidebar(
		array(
			'name'          => esc_html__('Main Sidebar', 'wpac'),
			'id'            => 'sidebar-1',
			'description'   => esc_html__('Add widgets here.', 'wpac'),
			'before_widget' => '<section id="%1$s" class="widget %2$s p-4 bg-white rounded-lg shadow-sm mb-6">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title text-lg font-semibold mb-4 pb-2 border-b border-primary-terracotta text-primary-terracotta">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__('Footer Widgets', 'wpac'),
			'id'            => 'footer-widgets',
			'description'   => esc_html__('Add widgets here.', 'wpac'),
			'before_widget' => '<section id="%1$s" class="widget %2$s p-4 bg-primary-blue text-gray-300 rounded-lg shadow-sm mb-6">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title text-lg font-semibold mb-4 pb-2 border-b border-primary-ochre text-primary-ochre">',
			'after_title'   => '</h2>',
		)
	);
}
add_action('widgets_init', 'wpac_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function wpac_scripts()
{
	// Google Fonts
	wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap', array(), null);

	// Font Awesome for icons
	wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', array(), '6.4.0');

	wp_enqueue_style('wpac-style', get_stylesheet_uri(), array(), _S_VERSION);
	wp_enqueue_style('tailwind-style', get_template_directory_uri() . '/final.css', array(), filemtime(get_template_directory() . '/final.css'));

	wp_style_add_data('wpac-style', 'rtl', 'replace');

	wp_enqueue_script('wpac-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true);

	// GLightbox scripts and styles for gallery and image lightbox
	wp_enqueue_style('glightbox-css', get_template_directory_uri() . '/js/vendor/glightbox/dist/css/glightbox.min.css', array(), '3.2.0');
	wp_enqueue_script('glightbox-js', get_template_directory_uri() . '/js/vendor/glightbox/dist/js/glightbox.min.js', array(), '3.2.0', true);
	wp_enqueue_script('wpac-gallery-init', get_template_directory_uri() . '/js/gallery-init.js', array('glightbox-js'), _S_VERSION, true);

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}

	wp_enqueue_script('mc-validate', '//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js', array(), null, true);
	wp_enqueue_script('wpac-mailchimp-embed', get_template_directory_uri() . '/js/mailchimp-embed.js', array('jquery', 'mc-validate'), filemtime(get_template_directory() . '/js/mailchimp-embed.js'), true);
}
add_action('wp_enqueue_scripts', 'wpac_scripts');

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Gallery and lightbox functionality.
 */
require get_template_directory() . '/inc/gallery-functions.php';

/**
 * Custom event post type meta.
 */
require_once get_template_directory() . '/inc/events.php';


/**
 * Enqueue block editor assets
 */
function wpac_enqueue_block_editor_assets()
{
	wp_enqueue_script(
		'wpac-gallery-editor',
		get_template_directory_uri() . '/js/gallery-block-editor.js',
		array('wp-blocks', 'wp-dom-ready', 'wp-edit-post', 'wp-element', 'wp-hooks', 'wp-components', 'wp-data'),
		_S_VERSION,
		true
	);
}
add_action('enqueue_block_editor_assets', 'wpac_enqueue_block_editor_assets');

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Enhanced Search Functionality
 */

// Modify search query to handle filters
function wpac_modify_search_query($query)
{
	if (!is_admin() && $query->is_main_query() && is_search()) {
		// Category filter
		if (isset($_GET['category']) && !empty($_GET['category'])) {
			$query->set('category_name', sanitize_text_field($_GET['category']));
		}

		// Post type filter
		if (isset($_GET['post_type']) && !empty($_GET['post_type'])) {
			$post_type = sanitize_text_field($_GET['post_type']);
			$query->set('post_type', $post_type);
		}

		// Date filter
		if (isset($_GET['date']) && !empty($_GET['date'])) {
			$date_filter = sanitize_text_field($_GET['date']);
			$date_query = array();

			switch ($date_filter) {
				case 'week':
					$date_query['after'] = '1 week ago';
					break;
				case 'month':
					$date_query['after'] = '1 month ago';
					break;
				case 'year':
					$date_query['after'] = '1 year ago';
					break;
			}

			if (!empty($date_query)) {
				$query->set('date_query', array($date_query));
			}
		}

		// Increase posts per page for search
		$query->set('posts_per_page', 10);
	}
}
add_action('pre_get_posts', 'wpac_modify_search_query');



// Highlight search terms in content
function wpac_highlight_search_terms($content)
{
	if (is_search() && !is_admin() && get_search_query()) {
		$search_term = get_search_query();
		$highlighted_content = preg_replace(
			'/(' . preg_quote($search_term, '/') . ')/i',
			'<mark class="bg-yellow-200">$1</mark>',
			$content
		);
		return $highlighted_content;
	}
	return $content;
}
add_filter('the_content', 'wpac_highlight_search_terms');
add_filter('the_excerpt', 'wpac_highlight_search_terms');

/**
 * Register Event Custom Post Type
 */
function wpac_register_event_post_type()
{
	$labels = array(
		'name'               => 'Events',
		'singular_name'      => 'Event',
		'menu_name'          => 'Events',
		'name_admin_bar'     => 'Event',
		'add_new'            => 'Add New',
		'add_new_item'       => 'Add New Event',
		'new_item'           => 'New Event',
		'edit_item'          => 'Edit Event',
		'view_item'          => 'View Event',
		'all_items'          => 'All Events',
		'search_items'       => 'Search Events',
		'parent_item_colon'  => 'Parent Events:',
		'not_found'          => 'No events found.',
		'not_found_in_trash' => 'No events found in Trash.'
	);

	$args = array(
		'labels'             => $labels,
		'description'        => 'Events for the website.',
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array('slug' => 'event', 'with_front' => false),
		'capability_type'    => 'post',
		'has_archive'        => 'events', // This sets the archive slug to 'events'
		'hierarchical'       => false,
		'menu_position'      => 5,
		'menu_icon'          => 'dashicons-calendar',
		'supports'           => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields')
	);

	register_post_type('event', $args);
}
add_action('init', 'wpac_register_event_post_type');

/**
 * Flush rewrite rules on theme activation to ensure event permalinks work
 */
function wpac_rewrite_flush()
{
	// First, we need to ensure our custom post type is registered
	wpac_register_event_post_type();

	// Then flush rewrite rules
	flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'wpac_rewrite_flush');
