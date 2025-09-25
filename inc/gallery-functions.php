<?php

/**
 * Gallery Block Enhancements
 * 
 * Custom functionality for enhancing the WordPress core Gallery block.
 */

/**
 * Register custom block styles for the gallery block.
 */
function headless_register_gallery_block_styles()
{
    // Make sure the function exists (WordPress 5.8+)
    if (function_exists('register_block_style')) {
        // Only register slideshow block style
        register_block_style(
            'core/gallery',
            array(
                'name'         => 'headless-slideshow',
                'label'        => __('Slideshow', 'headless'),
                'style_handle' => 'headless-gallery-styles',
            )
        );
    }
}
// Use after_setup_theme hook with priority 11 to ensure it runs after theme setup
add_action('after_setup_theme', 'headless_register_gallery_block_styles', 11);

/**
 * Add custom CSS for gallery styles.
 */
function headless_gallery_styles()
{
    // First, register a stylesheet handle for our gallery styles
    wp_register_style(
        'headless-gallery-styles',
        false, // No actual file, we'll use inline styles
        array(),
        _S_VERSION
    );

    // Now add our inline styles
    $css = '
        /* Native WordPress Gallery Styling for Brand Consistency */
        .wp-block-gallery {
            margin-bottom: 1.5rem;
        }
        
        /* Add subtle styling to gallery items */
        .wp-block-gallery .wp-block-image,
        .wp-block-gallery .blocks-gallery-item {
            overflow: hidden;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        
        .wp-block-gallery .wp-block-image:hover,
        .wp-block-gallery .blocks-gallery-item:hover {
            transform: translateY(-3px);
        }
        
        /* Style gallery images */
        .wp-block-gallery img {
            transition: transform 0.3s ease;
        }
        
        .wp-block-gallery a:hover img {
            transform: scale(1.05);
        }
        
        /* Ensure captions look good */
        .wp-block-gallery figcaption {
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 8px;
            font-size: 0.85rem;
        }
        
        /* Responsive adjustments using CSS variables */
        @media (max-width: 1024px) {
            /* Large tablet - max 4 columns */
            .wp-block-gallery.is-style-headless-grid.columns-5,
            .wp-block-gallery.is-style-headless-grid.columns-6,
            .wp-block-gallery.is-style-headless-grid.columns-7,
            .wp-block-gallery.is-style-headless-grid.columns-8,
            .wp-block-gallery.is-style-headless-grid.columns-9,
            .wp-block-gallery.is-style-headless-grid.columns-10,
            .wp-block-gallery.is-style-headless-grid.columns-11,
            .wp-block-gallery.is-style-headless-grid.columns-12 {
                --wp-gallery-columns: 4;
            }
        }
        
        @media (max-width: 768px) {
            /* Tablet - max 3 columns */
            .wp-block-gallery.is-style-headless-grid.columns-4,
            .wp-block-gallery.is-style-headless-grid.columns-5,
            .wp-block-gallery.is-style-headless-grid.columns-6,
            .wp-block-gallery.is-style-headless-grid.columns-7,
            .wp-block-gallery.is-style-headless-grid.columns-8,
            .wp-block-gallery.is-style-headless-grid.columns-9,
            .wp-block-gallery.is-style-headless-grid.columns-10,
            .wp-block-gallery.is-style-headless-grid.columns-11,
            .wp-block-gallery.is-style-headless-grid.columns-12 {
                --wp-gallery-columns: 3;
            }
        }
        
        @media (max-width: 600px) {
            /* Small tablet - max 2 columns */
            .wp-block-gallery.is-style-headless-grid.columns-3,
            .wp-block-gallery.is-style-headless-grid.columns-4,
            .wp-block-gallery.is-style-headless-grid.columns-5,
            .wp-block-gallery.is-style-headless-grid.columns-6,
            .wp-block-gallery.is-style-headless-grid.columns-7,
            .wp-block-gallery.is-style-headless-grid.columns-8,
            .wp-block-gallery.is-style-headless-grid.columns-9,
            .wp-block-gallery.is-style-headless-grid.columns-10,
            .wp-block-gallery.is-style-headless-grid.columns-11,
            .wp-block-gallery.is-style-headless-grid.columns-12 {
                --wp-gallery-columns: 2;
            }
        }
        
        @media (max-width: 480px) {
            /* Phone - always 1 column */
            .wp-block-gallery.is-style-headless-grid {
                --wp-gallery-columns: 1;
            }
        }

        /* Slideshow Gallery Styles */
        .wp-block-gallery.is-style-headless-slideshow {
            position: relative;
            height: 400px; /* Fixed height */
            width: 100%;
            overflow: hidden;
            margin-bottom: 1rem; /* Add space below the slideshow */
            box-shadow: 0 3px 10px rgba(0,0,0,0.1); /* Add shadow for depth */
            border-radius: 4px; /* Add rounded corners */
        }

        /* Reset any block gallery grid styles that might interfere */
        .wp-block-gallery.is-style-headless-slideshow .blocks-gallery-grid {
            width: 100%;
            height: 400px;
            position: relative;
            display: block !important; /* Force block display */
            margin: 0 !important; /* Reset margins */
            padding: 0 !important; /* Reset padding */
        }

        /* Reset WordPress core gallery styles */
        .wp-block-gallery.is-style-headless-slideshow ul,
        .wp-block-gallery.is-style-headless-slideshow ul.wp-block-gallery {
            display: block !important;
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
            height: 100% !important;
        }

        .wp-block-gallery.is-style-headless-slideshow figure {
            margin: 0;
            height: 400px; /* Fixed height for uniform presentation */
            width: 100%;
            cursor: pointer; /* Add pointer cursor to indicate clickable */
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        .wp-block-gallery.is-style-headless-slideshow img {
            width: 100%;
            height: 100%;
            object-fit: cover; /* Keep aspect ratio and fill container */
            border-radius: 4px;
            display: block; /* Remove inline behavior */
        }

        .wp-block-gallery.is-style-headless-slideshow .slideshow-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            display: flex;
            justify-content: space-between;
            width: 100%;
            z-index: 10;
            padding: 0 15px;
        }

        .wp-block-gallery.is-style-headless-slideshow .slideshow-nav button {
            background-color: rgba(102, 102, 102, 0.7);
            color: #eee;
            border: 2px solid #666;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 24px;
            line-height: 0; /* Fix vertical centering */
            transition: all 0.3s ease;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
            padding: 0; /* Remove padding that might affect roundness */
            overflow: hidden; /* Ensure content does not overflow circle */
        }
        
        .wp-block-gallery.is-style-headless-slideshow .slideshow-nav button:hover {
            background-color: #f7a833; /* Primary ochre color to match back-to-top button hover */
            color: white;
            border-color: #f7a833;
            transform: scale(1.1);
        }

        /* Reposition the slideshow dots to bottom center */
        .wp-block-gallery.is-style-headless-slideshow .slideshow-dots {
            position: absolute;
            bottom: 15px; /* Position closer to bottom */
            left: 0;
            right: 0;
            display: flex;
            flex-direction: row;
            justify-content: center;
            gap: 8px;
            margin: 0;
            z-index: 10;
        }

        .wp-block-gallery.is-style-headless-slideshow .slideshow-dots button {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            border: 2px solid #fff;
            background: rgba(102, 102, 102, 0.8);
            padding: 0;
            cursor: pointer;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
        }

        .wp-block-gallery.is-style-headless-slideshow .slideshow-dots button.active {
            background: #f7a833; /* Primary ochre color to match back-to-top button hover */
            transform: scale(1.2);
            border-color: #f7a833;
        }
        
        /* Make space for captions */
        .wp-block-gallery.is-style-headless-slideshow figure figcaption {
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 10px;
            margin-top: 0;
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 5;
        }
        
        /* Proper positioning for slide items - critical fix */
        .wp-block-gallery.is-style-headless-slideshow .wp-block-image,
        .wp-block-gallery.is-style-headless-slideshow .blocks-gallery-item {
            transition: opacity 0.5s ease-in-out;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            display: none; /* Hide by default */
            opacity: 0;
            margin: 0 !important; /* Reset margins */
            padding: 0 !important; /* Reset padding */
        }
        
        /* Show the active slide */
        .wp-block-gallery.is-style-headless-slideshow .wp-block-image.active,
        .wp-block-gallery.is-style-headless-slideshow .blocks-gallery-item.active {
            display: block !important; /* Force display */
            opacity: 1;
        }
        
        /* Ensure proper sizing for slideshow images */
        .wp-block-gallery.is-style-headless-slideshow .wp-block-image img,
        .wp-block-gallery.is-style-headless-slideshow .blocks-gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        
        /* Make sure linked images work properly with lightbox */
        .wp-block-gallery.is-style-headless-slideshow a,
        .wp-block-gallery.is-style-headless-grid a {
            display: block;
            width: 100%;
            height: 100%;
            position: relative;
            z-index: 5;
            cursor: pointer;
        }
        
        /* Additional styles for gallery lightbox items */
        a.gallery-lightbox-item {
            cursor: zoom-in;
            transition: opacity 0.3s ease;
        }
        
        a.gallery-lightbox-item:hover {
            opacity: 0.9;
        }

        /* Lightbox Customizations */
        .glightbox-container {
            width: 100%;
            height: 100%;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 999999 !important;
        }
        
        /* Ensure gallery items are clickable */
        .wp-block-gallery .wp-block-image,
        .wp-block-gallery .blocks-gallery-item {
            cursor: pointer;
        }
    ';

    // Add styles for both front-end and editor
    wp_add_inline_style('headless-gallery-styles', $css);

    // Add styles to the lightbox as well for front-end
    wp_add_inline_style('glightbox-css', $css);
}

// Enqueue our styles for both front-end and editor
add_action('wp_enqueue_scripts', 'headless_gallery_styles');
add_action('enqueue_block_editor_assets', 'headless_gallery_styles');

/**
 * Register custom block patterns for galleries.
 */
function headless_register_gallery_block_patterns()
{
    if (!function_exists('register_block_pattern')) {
        return;
    }

    // Register pattern category for galleries
    register_block_pattern_category(
        'headless-galleries',
        array('label' => __('Headless Galleries', 'headless'))
    );

    // No grid pattern - we're using native WordPress gallery instead

    // Register a slideshow gallery pattern
    register_block_pattern(
        'headless/gallery-slideshow',
        array(
            'title'       => __('Gallery Slideshow', 'headless'),
            'description' => __('A slideshow layout for image galleries', 'headless'),
            'categories'  => array('headless-galleries'),
            'content'     => '<!-- wp:gallery {"linkTo":"media","className":"is-style-headless-slideshow"} --><figure class="wp-block-gallery has-nested-images columns-1 is-cropped is-style-headless-slideshow"><!-- wp:image {"sizeSlug":"large","linkDestination":"media"} --><figure class="wp-block-image size-large"><img src="' . get_template_directory_uri() . '/images/placeholder-1.jpg" alt="Gallery Image 1"/><figcaption class="wp-element-caption">Image caption</figcaption></figure><!-- /wp:image --><!-- wp:image {"sizeSlug":"large","linkDestination":"media"} --><figure class="wp-block-image size-large"><img src="' . get_template_directory_uri() . '/images/placeholder-2.jpg" alt="Gallery Image 2"/></figure><!-- /wp:image --><!-- wp:image {"sizeSlug":"large","linkDestination":"media"} --><figure class="wp-block-image size-large"><img src="' . get_template_directory_uri() . '/images/placeholder-3.jpg" alt="Gallery Image 3"/></figure><!-- /wp:image --></figure><!-- /wp:gallery -->',
        )
    );
}
