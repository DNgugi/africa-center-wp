<?php

/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package headless
 */

get_header();
?>

<main id="primary" class="site-main">
	<?php
	$page_options = headless_get_page_options();

	// Set up content width classes
	$content_width_classes = array(
		'default' => 'max-w-6xl mx-auto px-4',
		'narrow' => 'max-w-4xl mx-auto px-4',
		'wide' => 'max-w-7xl mx-auto px-4',
		'full' => 'w-full'
	);

	$content_class = $content_width_classes[$page_options['content_width']] ?? $content_width_classes['default'];

	// Add any custom classes
	if (!empty($page_options['custom_classes'])) {
		$content_class .= ' ' . esc_attr($page_options['custom_classes']);
	}

	// Set up header classes based on style
	$header_style = $page_options['header_style'];
	$header_classes = 'relative py-16';

	if ($header_style === 'transparent') {
		$header_classes .= ' bg-transparent text-white';
	} elseif ($header_style === 'white') {
		$header_classes .= ' bg-white';
	} elseif ($header_style === 'dark') {
		$header_classes .= ' bg-gray-900 text-white';
	} elseif ($header_style === 'minimal') {
		$header_classes .= ' bg-white py-8';
	}
	?>

	<section class="<?php echo esc_attr($header_classes); ?>">
		<?php if ($header_style !== 'minimal') : ?>
			<div class="absolute inset-0 bg-gradient-to-r from-primary-blue to-secondary-burgundy opacity-95"></div>
			<?php if ($header_style === 'parallax' && has_post_thumbnail()) : ?>
				<div class="absolute inset-0 bg-cover bg-center" style="background-image: url('<?php echo get_the_post_thumbnail_url(null, 'full'); ?>');"></div>
			<?php endif; ?>
		<?php endif; ?>

		<div class="container mx-auto px-4 relative z-10">
			<?php headless_breadcrumbs(); ?>
			<div class="max-w-3xl mx-auto">
				<?php while (have_posts()) : the_post(); ?>
					<h1 class="text-4xl md:text-5xl font-bold mb-6 font-heading"><?php the_title(); ?></h1>
				<?php endwhile;
				rewind_posts(); ?>
			</div>
		</div>

		<?php if ($header_style !== 'minimal') : ?>
			<div class="hidden lg:block absolute -right-16 -top-16 w-64 h-64 rounded-full bg-primary-terracotta opacity-20"></div>
		<?php endif; ?>
	</section>

	<section class="py-10 bg-secondary-sand">
		<div class="container mx-auto px-4">
			<?php
			// Get page options
			$page_options = headless_get_page_options();

			// Check if sidebar is disabled for this specific page
			$disable_sidebar = !empty($page_options['disable_sidebar']);

			// Get theme sidebar layout setting
			$sidebar_layout = get_theme_mod('page_sidebar_layout', 'right-sidebar');

			// Set content width
			$content_width = get_theme_mod('content_width', 'standard');

			// Base content class
			$content_class = 'w-full';
			$wrapper_class = '';

			// Only apply sidebar layout if sidebar is not disabled
			if (!$disable_sidebar && $sidebar_layout !== 'no-sidebar' && is_active_sidebar('sidebar-1')) {
				$content_class = 'w-full lg:w-2/3';
				$wrapper_class = 'flex flex-wrap ' . ($sidebar_layout === 'left-sidebar' ? 'flex-row-reverse' : '');
			} else {
				// If no sidebar, use content width settings
				$content_class = match ($content_width) {
					'narrow' => 'max-w-2xl mx-auto',
					'wide' => 'max-w-5xl mx-auto',
					'full' => 'w-full',
					default => 'max-w-3xl mx-auto',
				};
			}
			?>
			<div class="<?php echo esc_attr($wrapper_class); ?>">
				<div class="<?php echo esc_attr($content_class); ?>">
					<?php
					while (have_posts()) :
						the_post();
						get_template_part('template-parts/content', 'page');
					endwhile;

					// If comments are open or we have at least one comment, load up the comment template.
					if (comments_open() || get_comments_number()) :
						comments_template();
					endif;
					?>

				</div>

				<?php if ($sidebar_layout !== 'no-sidebar') : ?>
					<div class="lg:w-1/3 mt-8 lg:mt-0 <?php echo $sidebar_layout === 'left-sidebar' ? 'lg:pr-8' : 'lg:pl-8'; ?>">
						<aside id="secondary" class="widget-area">
							<?php dynamic_sidebar('sidebar-1'); ?>
						</aside>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</section>

	<?php if (get_theme_mod('page_cta_enabled', false)) : ?>
		<section class="py-16 bg-primary-blue text-white">
			<div class="container mx-auto px-4">
				<div class="max-w-3xl mx-auto text-center">
					<h2 class="text-3xl md:text-4xl font-bold mb-6">
						<?php echo esc_html(get_theme_mod('page_cta_text', __('Ready to get started?', 'headless'))); ?>
					</h2>
					<a href="<?php echo esc_url(get_theme_mod('page_cta_button_url', '#')); ?>"
						class="inline-block bg-white text-primary-blue px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
						<?php echo esc_html(get_theme_mod('page_cta_button_text', __('Contact Us', 'headless'))); ?>
					</a>
				</div>
			</div>
		</section>
	<?php endif; ?>

</main><!-- #primary -->

<?php
get_footer();
