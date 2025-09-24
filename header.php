<?php

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package headless
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	<div id="page" class="site">
		<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('Skip to content', 'headless'); ?></a>

		<?php
		$page_options = headless_get_page_options();

		// Don't show header if it's hidden
		if (!empty($page_options['hide_header'])) {
			return;
		}

		$header_classes = array('site-header');

		// Add header style class
		if (isset($page_options['header_style']) && $page_options['header_style'] !== 'default') {
			$header_classes[] = 'header-style-' . $page_options['header_style'];
		}

		// Add any custom classes
		if (!empty($page_options['custom_classes'])) {
			$header_classes = array_merge($header_classes, explode(' ', $page_options['custom_classes']));
		}

		$header_classes = array_map('sanitize_html_class', $header_classes);
		?>
		<header id="masthead" class="<?php echo esc_attr(implode(' ', $header_classes)); ?> site-header">
			<div class="header-container">
				<div class="site-branding">
					<?php
					the_custom_logo();
					if (is_front_page() && is_home()) :
					?>
						<h1 class="site-title text-xl font-bold"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home" class="text-gray-900 hover:text-gray-600"><?php bloginfo('name'); ?></a></h1>
					<?php
					else :
					?>
						<p class="site-title text-xl font-bold"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home" class="text-gray-900 hover:text-gray-600"><?php bloginfo('name'); ?></a></p>
					<?php
					endif;
					$headless_description = get_bloginfo('description', 'display');
					if ($headless_description || is_customize_preview()) :
					?>
						<p class="site-description ml-4 text-sm text-gray-600"><?php echo $headless_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
																				?></p>
					<?php endif; ?>
				</div><!-- .site-branding -->

				<div class="header-controls">
					<!-- Mobile/Tablet: Search and Toggle grouped together -->
					<div class="mobile-controls lg:hidden flex items-center gap-2">
						<div class="search-toggle">
							<a href="<?php echo esc_url(home_url('/?s=')); ?>"
								class="inline-flex items-center justify-center w-10 h-10 bg-primary-blue text-white rounded-full shadow-lg hover:shadow-xl hover:bg-primary-blue/90 transition-all duration-300"
								aria-label="<?php esc_attr_e('Search', 'headless'); ?>">
								<i class="fas fa-search text-sm" aria-hidden="true"></i>
							</a>
						</div>
						<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
							<span class="hamburger-icon">
								<i class="fas fa-bars" aria-hidden="true"></i>
							</span>
							<span class="close-icon hidden">
								<i class="fas fa-times" aria-hidden="true"></i>
							</span>
							<span class="sr-only"><?php esc_html_e('Menu', 'headless'); ?></span>
						</button>
					</div>

					<!-- Desktop: Navigation with search as last item -->
					<nav id="site-navigation" class="main-navigation hidden lg:flex items-center">
						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'menu-1',
								'menu_id'        => 'primary-menu',
								'container_class' => 'nav-menu-container',
								'menu_class'     => 'menu',
							)
						);
						?>
						<div class="search-toggle ml-6">
							<a href="<?php echo esc_url(home_url('/?s=')); ?>"
								class="inline-flex items-center justify-center w-10 h-10 bg-primary-blue text-white rounded-full shadow-lg hover:shadow-xl hover:bg-primary-blue/90 transition-all duration-300"
								aria-label="<?php esc_attr_e('Search', 'headless'); ?>">
								<i class="fas fa-search text-sm" aria-hidden="true"></i>
							</a>
						</div>
					</nav><!-- #site-navigation -->
				</div>
			</div>
		</header><!-- #masthead -->