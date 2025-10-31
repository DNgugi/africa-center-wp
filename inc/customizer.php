<?php

/**
 * Africa Center WP Theme Customizer
 *
 * @package wpac
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function wpac_customize_register($wp_customize)
{
	$wp_customize->get_setting('blogname')->transport         = 'postMessage';
	$wp_customize->get_setting('blogdescription')->transport  = 'postMessage';
	$wp_customize->get_setting('header_textcolor')->transport = 'postMessage';

	// Add Page Layout section
	$wp_customize->add_section('page_layout_section', array(
		'title'    => __('Page Layout', 'wpac'),
		'priority' => 30,
	));

	// Add sidebar layout setting
	$wp_customize->add_setting('page_sidebar_layout', array(
		'default'           => 'no-sidebar',
		'sanitize_callback' => 'wpac_sanitize_select',
	));

	// Add sidebar layout control
	$wp_customize->add_control('page_sidebar_layout', array(
		'label'    => __('Default Page Sidebar Layout', 'wpac'),
		'section'  => 'page_layout_section',
		'type'     => 'select',
		'choices'  => array(
			'no-sidebar'    => __('No Sidebar', 'wpac'),
			'right-sidebar' => __('Right Sidebar', 'wpac'),
			'left-sidebar'  => __('Left Sidebar', 'wpac'),
		),
	));

	// Add page header style setting
	$wp_customize->add_setting('page_header_style', array(
		'default'           => 'default',
		'sanitize_callback' => 'wpac_sanitize_select',
	));

	// Add page header style control
	$wp_customize->add_control('page_header_style', array(
		'label'    => __('Page Header Style', 'wpac'),
		'section'  => 'page_layout_section',
		'type'     => 'select',
		'choices'  => array(
			'default'    => __('Default', 'wpac'),
			'full-width' => __('Full Width', 'wpac'),
			'parallax'   => __('Parallax', 'wpac'),
			'minimal'    => __('Minimal', 'wpac'),
		),
	));

	// Add content width setting
	$wp_customize->add_setting('content_width', array(
		'default'           => 'standard',
		'sanitize_callback' => 'wpac_sanitize_select',
	));

	// Add content width control
	$wp_customize->add_control('content_width', array(
		'label'    => __('Content Width', 'wpac'),
		'section'  => 'page_layout_section',
		'type'     => 'select',
		'choices'  => array(
			'narrow'    => __('Narrow', 'wpac'),
			'standard'  => __('Standard', 'wpac'),
			'wide'      => __('Wide', 'wpac'),
			'full'      => __('Full Width', 'wpac'),
		),
	));

	// Add Call to Action section
	$wp_customize->add_section('page_cta_section', array(
		'title'    => __('Page Call to Action', 'wpac'),
		'priority' => 35,
	));

	// Add CTA enable setting
	$wp_customize->add_setting('page_cta_enabled', array(
		'default'           => false,
		'sanitize_callback' => 'wpac_sanitize_checkbox',
	));

	// Add CTA enable control
	$wp_customize->add_control('page_cta_enabled', array(
		'label'    => __('Enable Call to Action', 'wpac'),
		'section'  => 'page_cta_section',
		'type'     => 'checkbox',
	));

	// Add CTA text setting
	$wp_customize->add_setting('page_cta_text', array(
		'default'           => __('Ready to get started?', 'wpac'),
		'sanitize_callback' => 'sanitize_text_field',
	));

	// Add CTA text control
	$wp_customize->add_control('page_cta_text', array(
		'label'    => __('CTA Text', 'wpac'),
		'section'  => 'page_cta_section',
		'type'     => 'text',
	));

	// Add CTA button text setting
	$wp_customize->add_setting('page_cta_button_text', array(
		'default'           => __('Contact Us', 'wpac'),
		'sanitize_callback' => 'sanitize_text_field',
	));

	// Add CTA button text control
	$wp_customize->add_control('page_cta_button_text', array(
		'label'    => __('Button Text', 'wpac'),
		'section'  => 'page_cta_section',
		'type'     => 'text',
	));

	// Add CTA button URL setting
	$wp_customize->add_setting('page_cta_button_url', array(
		'default'           => '#',
		'sanitize_callback' => 'esc_url_raw',
	));

	// Add CTA button URL control
	$wp_customize->add_control('page_cta_button_url', array(
		'label'    => __('Button URL', 'wpac'),
		'section'  => 'page_cta_section',
		'type'     => 'url',
	));

	if (isset($wp_customize->selective_refresh)) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'wpac_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'wpac_customize_partial_blogdescription',
			)
		);
	}
}
add_action('customize_register', 'wpac_customize_register');

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function wpac_customize_partial_blogname()
{
	bloginfo('name');
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function wpac_customize_partial_blogdescription()
{
	bloginfo('description');
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function wpac_customize_preview_js()
{
	wp_enqueue_script('wpac-customizer', get_template_directory_uri() . '/js/customizer.js', array('customize-preview'), _S_VERSION, true);
}
// Sanitize select
function wpac_sanitize_select($input, $setting)
{
	// Get list of choices from the control
	$choices = $setting->manager->get_control($setting->id)->choices;

	// Return input if valid or return default if not
	return (array_key_exists($input, $choices) ? $input : $setting->default);
}

add_action('customize_preview_init', 'wpac_customize_preview_js');
