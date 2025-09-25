# Gallery and Lightbox Implementation Plan

## Overview

This document outlines a comprehensive plan for implementing a dual image management system in the Headless WordPress theme:

1. **Universal Lightbox Integration**: All content images across the site will open in a lightbox viewer when clicked
2. **Native Gutenberg Gallery Block**: For dedicated image collections using WordPress core functionality
3. **Flexible Display Options**: Support for both grid gallery and slideshow views

## Implementation Tasks

### 1. Set Up Required Dependencies

- [ ] Select and install a lightweight, responsive lightbox library (recommended: Glightbox or Fancybox)
- [ ] Ensure all dependencies are properly enqueued in `functions.php`
- [ ] Set up required JavaScript files for gallery enhancements

### 2. Universal Lightbox Configuration

- [ ] Add lightbox initialization to theme JavaScript
- [ ] Configure automatic binding to all content images site-wide
- [ ] Implement responsive image handling with `srcset` attributes
- [ ] Add support for image captions in lightbox display
- [ ] Configure navigation between adjacent images in content

### 3. Native Gallery Block Enhancement

- [ ] Create custom styles for the core Gallery block
- [ ] Register custom block variations for gallery display options
- [ ] Add custom block attributes for slideshow/grid toggle
- [ ] Implement custom gallery rendering functions
- [ ] Create gallery preview functionality with "View All" option

### 4. Gallery Display Templates

- [ ] Create template for grid view display (default)
- [ ] Develop slideshow view template as alternative
- [ ] Create block editor control panel for display options
- [ ] Implement responsive styling for both display options
- [ ] Ensure proper integration with lightbox functionality

### 5. Theme Integration

- [ ] Modify `functions.php` to support the new gallery features
- [ ] Register custom block styles and variations
- [ ] Ensure compatibility with existing page templates
- [ ] Add gallery support to the front-page gallery section
- [ ] Implement connection between gallery previews and full galleries

### 6. User Documentation

- [ ] Create documentation for admin users on using the new gallery features
- [ ] Add inline help text in the WordPress admin
- [ ] Provide examples of different gallery configurations

## Technical Implementation Details

### Functions.php Additions

We'll need to add the following to functions.php:

```php
/**
 * Enqueue lightbox scripts and styles.
 */
function headless_enqueue_gallery_scripts() {
    // Enqueue lightbox library
    wp_enqueue_style('glightbox-css', get_template_directory_uri() . '/js/vendor/glightbox/glightbox.min.css');
    wp_enqueue_script('glightbox-js', get_template_directory_uri() . '/js/vendor/glightbox/glightbox.min.js', array(), '1.0.0', true);

    // Enqueue our custom initialization script
    wp_enqueue_script('headless-gallery-init', get_template_directory_uri() . '/js/gallery-init.js', array('glightbox-js'), '1.0.0', true);

    // Pass settings to our script
    wp_localize_script('headless-gallery-init', 'headlessGallerySettings', array(
        'lightboxCaption' => true,
        'lightboxLoop' => true,
    ));
}
add_action('wp_enqueue_scripts', 'headless_enqueue_gallery_scripts');

/**
 * Add lightbox attributes to all content images.
 */
function headless_add_lightbox_to_content_images($content) {
    // Don't modify admin or feed content
    if (is_admin() || is_feed()) {
        return $content;
    }

    // Use DOMDocument to safely modify image tags
    if (!empty($content)) {
        $document = new DOMDocument();
        libxml_use_internal_errors(true);
        $document->loadHTML(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'));
        libxml_clear_errors();

        $images = $document->getElementsByTagName('img');

        if ($images->length > 0) {
            foreach ($images as $image) {
                // Get parent element
                $parent = $image->parentNode;

                // If the image is already wrapped in a link, modify that link
                if ($parent->tagName == 'a') {
                    $href = $parent->getAttribute('href');
                    $parent->setAttribute('data-gallery', 'content-gallery');
                    $parent->setAttribute('class', 'glightbox-link');

                    // If the link points to an attachment page, change it to the full image URL
                    if (strpos($href, get_site_url()) !== false && !preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $href)) {
                        $attachment_id = url_to_postid($href);
                        if ($attachment_id) {
                            $full_image_url = wp_get_attachment_image_src($attachment_id, 'full')[0];
                            $parent->setAttribute('href', $full_image_url);
                        }
                    }
                }
                // If not, wrap the image in a link
                else {
                    // Get image src
                    $src = $image->getAttribute('src');

                    // Find the full size image if it's a WordPress image
                    $full_size_src = $src;

                    // Check if the image has a srcset attribute
                    $srcset = $image->getAttribute('srcset');
                    if ($srcset) {
                        // Parse the srcset to find the largest image
                        $srcset_parts = explode(',', $srcset);
                        $largest_width = 0;
                        foreach ($srcset_parts as $part) {
                            $part = trim($part);
                            if (preg_match('/(\S+)\s+(\d+)w/', $part, $matches)) {
                                $width = intval($matches[2]);
                                if ($width > $largest_width) {
                                    $largest_width = $width;
                                    $full_size_src = $matches[1];
                                }
                            }
                        }
                    }

                    // Get image alt and title for caption
                    $alt = $image->getAttribute('alt');
                    $title = $image->getAttribute('title') ?: $alt;

                    // Create the new wrapper link
                    $link = $document->createElement('a');
                    $link->setAttribute('href', $full_size_src);
                    $link->setAttribute('class', 'glightbox-link');
                    $link->setAttribute('data-gallery', 'content-gallery');
                    if ($title) {
                        $link->setAttribute('data-caption', $title);
                    }

                    // Replace the image with the link + image
                    $parent->replaceChild($link, $image);
                    $link->appendChild($image);
                }
            }

            // Get the modified HTML
            $content = $document->saveHTML($document->documentElement);

            // Extract just the body content
            $content = preg_replace('/^<!DOCTYPE.+?>/', '', $content);
            $content = str_replace(array('<html>', '</html>', '<body>', '</body>', '<head>', '</head>'), '', $content);
            $content = trim($content);
        }
    }

    return $content;
}
add_filter('the_content', 'headless_add_lightbox_to_content_images', 20);

/**
 * Register custom block styles for the gallery block.
 */
function headless_register_gallery_block_styles() {
    // Register block styles
    register_block_style('core/gallery', [
        'name' => 'headless-grid',
        'label' => __('Grid Gallery', 'headless'),
    ]);

    register_block_style('core/gallery', [
        'name' => 'headless-slideshow',
        'label' => __('Slideshow', 'headless'),
    ]);
}
add_action('init', 'headless_register_gallery_block_styles');

/**
 * Add custom attributes to gallery block.
 */
function headless_gallery_block_attributes($attributes, $block) {
    if ($block->name === 'core/gallery') {
        $attributes['displayType'] = [
            'type' => 'string',
            'default' => 'grid',
        ];
        $attributes['previewCount'] = [
            'type' => 'number',
            'default' => 6,
        ];
        $attributes['isPreview'] = [
            'type' => 'boolean',
            'default' => false,
        ];
    }
    return $attributes;
}
add_filter('blocks.register_block_type_args', 'headless_gallery_block_attributes', 10, 2);

/**
 * Add custom block patterns for galleries.
 */
function headless_register_gallery_block_patterns() {
    register_block_pattern(
        'headless/gallery-grid',
        array(
            'title'       => __('Gallery Grid with Lightbox', 'headless'),
            'description' => __('A grid layout gallery with lightbox support', 'headless'),
            'categories'  => array('gallery'),
            'content'     => '<!-- wp:gallery {"linkTo":"media","className":"is-style-headless-grid"} --><figure class="wp-block-gallery has-nested-images columns-3 is-cropped is-style-headless-grid"><!-- wp:image {"id":123,"sizeSlug":"large","linkDestination":"media"} --><figure class="wp-block-image size-large"><img src="https://example.com/image1.jpg" alt="Gallery Image 1" class="wp-image-123"/><figcaption class="wp-element-caption">Image caption</figcaption></figure><!-- /wp:image --><!-- wp:image {"id":124,"sizeSlug":"large","linkDestination":"media"} --><figure class="wp-block-image size-large"><img src="https://example.com/image2.jpg" alt="Gallery Image 2" class="wp-image-124"/></figure><!-- /wp:image --><!-- wp:image {"id":125,"sizeSlug":"large","linkDestination":"media"} --><figure class="wp-block-image size-large"><img src="https://example.com/image3.jpg" alt="Gallery Image 3" class="wp-image-125"/></figure><!-- /wp:image --></figure><!-- /wp:gallery -->',
        )
    );

    register_block_pattern(
        'headless/gallery-slideshow',
        array(
            'title'       => __('Gallery Slideshow', 'headless'),
            'description' => __('A slideshow layout for image galleries', 'headless'),
            'categories'  => array('gallery'),
            'content'     => '<!-- wp:gallery {"linkTo":"media","className":"is-style-headless-slideshow"} --><figure class="wp-block-gallery has-nested-images columns-1 is-cropped is-style-headless-slideshow"><!-- wp:image {"id":123,"sizeSlug":"large","linkDestination":"media"} --><figure class="wp-block-image size-large"><img src="https://example.com/image1.jpg" alt="Gallery Image 1" class="wp-image-123"/><figcaption class="wp-element-caption">Image caption</figcaption></figure><!-- /wp:image --><!-- wp:image {"id":124,"sizeSlug":"large","linkDestination":"media"} --><figure class="wp-block-image size-large"><img src="https://example.com/image2.jpg" alt="Gallery Image 2" class="wp-image-124"/></figure><!-- /wp:image --><!-- wp:image {"id":125,"sizeSlug":"large","linkDestination":"media"} --><figure class="wp-block-image size-large"><img src="https://example.com/image3.jpg" alt="Gallery Image 3" class="wp-image-125"/></figure><!-- /wp:image --></figure><!-- /wp:gallery -->',
        )
    );
}
add_action('init', 'headless_register_gallery_block_patterns');
```

### JavaScript Initialization (gallery-init.js)

```javascript
document.addEventListener("DOMContentLoaded", function () {
  // Initialize lightbox for all content images
  const contentLightbox = GLightbox({
    selector: ".glightbox-link",
    touchNavigation: true,
    loop: headlessGallerySettings.lightboxLoop,
    autoplayVideos: true,
  });

  // Initialize lightbox for galleries (works with core gallery block)
  const galleryLightbox = GLightbox({
    selector: ".wp-block-gallery .wp-block-image a",
    touchNavigation: true,
    loop: true,
    autoplayVideos: true,
  });

  // Initialize slideshows if they exist
  const slideshows = document.querySelectorAll(".is-style-headless-slideshow");
  if (slideshows.length > 0) {
    slideshows.forEach(function (slideshow) {
      // Initialize slideshow - implementation depends on chosen library
      // This is a placeholder for whatever slideshow library we choose
      new Slideshow(slideshow, {
        autoplay: false,
        arrows: true,
        dots: true,
      });
    });
  }
});
```

### CSS for Gallery Blocks (css/gallery-styles.css)

```css
/* Grid Gallery Styles */
.wp-block-gallery.is-style-headless-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  grid-gap: 1rem;
}

.wp-block-gallery.is-style-headless-grid.columns-2 {
  grid-template-columns: repeat(2, 1fr);
}

.wp-block-gallery.is-style-headless-grid.columns-4 {
  grid-template-columns: repeat(4, 1fr);
}

.wp-block-gallery.is-style-headless-grid figure {
  margin: 0;
  height: 100%;
  transition: transform 0.3s ease;
}

.wp-block-gallery.is-style-headless-grid figure:hover {
  transform: translateY(-5px);
}

.wp-block-gallery.is-style-headless-grid img {
  height: 100%;
  object-fit: cover;
  border-radius: 4px;
}

/* Slideshow Gallery Styles */
.wp-block-gallery.is-style-headless-slideshow {
  position: relative;
}

.wp-block-gallery.is-style-headless-slideshow figure {
  margin: 0;
}

.wp-block-gallery.is-style-headless-slideshow .slideshow-nav {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  display: flex;
  justify-content: space-between;
  width: 100%;
  z-index: 10;
}

.wp-block-gallery.is-style-headless-slideshow .slideshow-nav button {
  background: rgba(0, 0, 0, 0.5);
  color: white;
  border: none;
  border-radius: 50%;
  width: 40px;
  height: 40px;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
}

.wp-block-gallery.is-style-headless-slideshow .slideshow-dots {
  display: flex;
  justify-content: center;
  gap: 10px;
  margin-top: 10px;
}

.wp-block-gallery.is-style-headless-slideshow .slideshow-dots button {
  width: 10px;
  height: 10px;
  border-radius: 50%;
  border: none;
  background: #ccc;
  padding: 0;
  cursor: pointer;
}

.wp-block-gallery.is-style-headless-slideshow .slideshow-dots button.active {
  background: #333;
}

/* Gallery Preview Functionality */
.headless-gallery-preview {
  position: relative;
}

.headless-gallery-preview .gallery-view-all {
  margin-top: 1rem;
  text-align: center;
}

.headless-gallery-preview .gallery-view-all .button {
  display: inline-block;
  padding: 0.5rem 1rem;
  background: #333;
  color: white;
  text-decoration: none;
  border-radius: 4px;
}
```

### JavaScript for Gallery Block Enhancements (js/gallery-block.js)

```javascript
// Register custom gallery block enhancements
(function (blocks, editor, element, components) {
  const { __ } = wp.i18n;
  const { createHigherOrderComponent } = wp.compose;
  const { Fragment } = element;
  const { InspectorControls } = editor;
  const { PanelBody, ToggleControl, RangeControl, SelectControl } = components;

  // Add custom controls to the Gallery block
  const withGalleryControls = createHigherOrderComponent((BlockEdit) => {
    return (props) => {
      // Only add controls to the gallery block
      if (props.name !== "core/gallery") {
        return <BlockEdit {...props} />;
      }

      const { attributes, setAttributes } = props;

      // Get current attributes or set defaults
      const displayType = attributes.displayType || "grid";
      const previewCount = attributes.previewCount || 6;
      const isPreview = attributes.isPreview || false;

      return (
        <Fragment>
          <BlockEdit {...props} />
          <InspectorControls>
            <PanelBody
              title={__("Gallery Display Options", "headless")}
              initialOpen={true}
            >
              <SelectControl
                label={__("Display Type", "headless")}
                value={displayType}
                options={[
                  { label: __("Grid", "headless"), value: "grid" },
                  { label: __("Slideshow", "headless"), value: "slideshow" },
                ]}
                onChange={(value) => {
                  // Set custom attribute
                  setAttributes({ displayType: value });

                  // Update block class
                  const newClassName =
                    value === "slideshow"
                      ? "is-style-headless-slideshow"
                      : "is-style-headless-grid";

                  setAttributes({ className: newClassName });
                }}
              />

              {displayType === "grid" && (
                <SelectControl
                  label={__("Columns", "headless")}
                  value={attributes.columns || 3}
                  options={[
                    { label: "2", value: 2 },
                    { label: "3", value: 3 },
                    { label: "4", value: 4 },
                  ]}
                  onChange={(value) => {
                    setAttributes({ columns: parseInt(value) });
                  }}
                />
              )}

              <ToggleControl
                label={__("Show as Preview", "headless")}
                checked={isPreview}
                onChange={(value) => {
                  setAttributes({ isPreview: value });
                }}
              />

              {isPreview && (
                <RangeControl
                  label={__("Preview Count", "headless")}
                  value={previewCount}
                  onChange={(value) => {
                    setAttributes({ previewCount: value });
                  }}
                  min={1}
                  max={12}
                />
              )}
            </PanelBody>
          </InspectorControls>
        </Fragment>
      );
    };
  }, "withGalleryControls");

  wp.hooks.addFilter(
    "editor.BlockEdit",
    "headless/gallery-controls",
    withGalleryControls
  );
})(
  window.wp.blocks,
  window.wp.blockEditor,
  window.wp.element,
  window.wp.components
);
```

### Gallery Preview Renderer (template-parts/gallery-preview.php)

```php
<?php
/**
 * Renders a gallery with optional preview functionality.
 *
 * This template is used to render a WordPress core gallery block with
 * preview functionality that limits the number of displayed images.
 *
 * @package Headless
 */

// Extract gallery block data (this would come from parsing block content)
function headless_get_gallery_preview($content, $preview_count = 6) {
    // Check if we have gallery blocks
    if (has_block('core/gallery', $content)) {
        $blocks = parse_blocks($content);
        foreach ($blocks as $block) {
            if ($block['blockName'] === 'core/gallery') {
                // Get gallery attributes
                $attrs = $block['attrs'];
                $is_preview = isset($attrs['isPreview']) ? $attrs['isPreview'] : false;
                $display_type = isset($attrs['displayType']) ? $attrs['displayType'] : 'grid';
                $preview_limit = isset($attrs['previewCount']) ? $attrs['previewCount'] : $preview_count;

                // Get all images from inner blocks
                $images = array();
                if (!empty($block['innerBlocks'])) {
                    foreach ($block['innerBlocks'] as $inner_block) {
                        if ($inner_block['blockName'] === 'core/image') {
                            $images[] = $inner_block;
                        }
                    }
                }

                // If preview mode and we have more images than the limit
                if ($is_preview && count($images) > $preview_limit) {
                    $gallery_id = 'gallery-' . uniqid();
                    $limited_markup = render_block($block);

                    // Wrap in preview container with "View All" button
                    return sprintf(
                        '<div class="headless-gallery-preview">%s
                            <div class="gallery-view-all">
                                <a href="#%s" class="button js-open-full-gallery">
                                    View All Images (%d)
                                </a>
                            </div>
                            <div id="%s" class="gallery-full" style="display: none;">%s</div>
                        </div>',
                        $limited_markup,
                        $gallery_id,
                        count($images),
                        $gallery_id,
                        render_block($block)
                    );
                }
            }
        }
    }

    return $content;
}
?>
```

## Usage Examples

### Adding a Gallery to a Page

1. Edit any page or post in the WordPress admin
2. Click the "+" button to add a new block
3. Select the "Gallery" block from the Media category
4. Upload images or select them from the media library
5. In the block sidebar (right panel), find "Gallery Display Options"
6. Choose display type: Grid or Slideshow
7. For Grid view, select number of columns
8. Toggle "Show as Preview" if you want to limit initial display
9. If using preview, set the number of images to show
10. Update/publish the page

### Applying Different Gallery Styles

1. Select an existing gallery block in the editor
2. Click on the block toolbar and find the Styles dropdown
3. Choose between "Default", "Grid Gallery", or "Slideshow"
4. Additional options will appear in the sidebar based on your selection

### Using Gallery Block Patterns

1. Click the "+" button to add a new block
2. Click the "Patterns" tab
3. Find and select either "Gallery Grid with Lightbox" or "Gallery Slideshow" pattern
4. Replace the placeholder images with your own images
5. Customize settings in the sidebar as needed

## Next Steps

After implementing this solution, we'll need to:

1. Test responsiveness on various devices and screen sizes
2. Optimize image loading performance with lazy loading techniques
3. Consider adding more gallery display options and animations
4. Create user documentation and tutorial videos
5. Test browser compatibility, especially for the lightbox features
6. Optimize the slideshow script for performance
7. Add accessibility features to ensure WCAG compliance
