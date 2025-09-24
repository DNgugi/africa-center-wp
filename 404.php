<?php

/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package headless
 */

get_header();
?>

<main id="primary" class="site-main">
	<!-- Hero Section -->
	<section class="relative bg-pattern-lines text-white py-16 overflow-hidden">
		<div class="absolute inset-0 bg-gradient-to-r from-primary-blue to-secondary-burgundy opacity-95"></div>
		<div class="container mx-auto px-4 relative z-10">
			<div class="max-w-3xl mx-auto">
				<h1 class="text-4xl md:text-5xl font-bold mb-6 font-heading text-primary-ochre">
					<?php esc_html_e('Oops! That page can&rsquo;t be found.', 'headless'); ?>
				</h1>
				<p class="text-xl mb-8 text-white/90">
					<?php esc_html_e('It looks like nothing was found at this location. Maybe try one of the options below?', 'headless'); ?>
				</p>
			</div>
		</div>
		<div class="hidden lg:block absolute -right-16 -top-16 w-64 h-64 rounded-full bg-primary-terracotta opacity-20"></div>
	</section>

	<!-- Content Section -->
	<section class="py-10 bg-secondary-sand">
		<div class="container mx-auto px-4">
			<div class="max-w-4xl mx-auto">
				<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
					<!-- Search Section -->
					<div class="bg-white rounded-lg shadow-lg p-6">
						<h2 class="text-2xl font-bold mb-4 font-heading text-primary-blue">Search Our Site</h2>
						<p class="mb-4 text-neutral-dark">Try searching for what you were looking for:</p>
						<?php get_search_form(); ?>
					</div>

					<!-- Recent Posts -->
					<div class="bg-white rounded-lg shadow-lg p-6">
						<h2 class="text-2xl font-bold mb-4 font-heading text-primary-blue">Recent Posts</h2>
						<?php
						the_widget('WP_Widget_Recent_Posts', array(
							'title' => '',
							'number' => 5,
						), array(
							'before_widget' => '<div class="widget">',
							'after_widget' => '</div>',
							'before_title' => '<h3 class="widget-title">',
							'after_title' => '</h3>',
						));
						?>
					</div>
				</div>

				<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-8">
					<!-- Categories -->
					<div class="bg-white rounded-lg shadow-lg p-6">
						<h2 class="text-2xl font-bold mb-4 font-heading text-primary-blue">Popular Categories</h2>
						<div class="widget widget_categories">
							<ul class="space-y-2">
								<?php
								wp_list_categories(
									array(
										'orderby'    => 'count',
										'order'      => 'DESC',
										'show_count' => 1,
										'title_li'   => '',
										'number'     => 8,
									)
								);
								?>
							</ul>
						</div>
					</div>

					<!-- Archives -->
					<div class="bg-white rounded-lg shadow-lg p-6">
						<h2 class="text-2xl font-bold mb-4 font-heading text-primary-blue">Archives</h2>
						<?php
						$headless_archive_content = '<p class="mb-4 text-neutral-dark">' . sprintf(esc_html__('Browse our monthly archives. %1$s', 'headless'), convert_smilies(':)')) . '</p>';
						the_widget('WP_Widget_Archives', 'dropdown=1', array(
							'before_widget' => '<div class="widget">',
							'after_widget' => '</div>',
							'before_title' => '<h3 class="widget-title sr-only">',
							'after_title' => '</h3>' . $headless_archive_content,
						));
						?>
					</div>
				</div>

				<!-- Call to Action -->
				<div class="bg-white rounded-lg shadow-lg p-8 mt-8 text-center">
					<h2 class="text-2xl font-bold mb-4 font-heading text-primary-blue">Still Can't Find What You're Looking For?</h2>
					<p class="mb-6 text-neutral-dark">Get in touch with us and we'll help you find what you need.</p>
					<div class="flex flex-col sm:flex-row gap-4 justify-center">
						<a href="<?php echo esc_url(home_url('/')); ?>" class="btn-primary">
							Go to Homepage
						</a>
						<a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn-blue">
							Contact Us
						</a>
					</div>
				</div>
			</div>
		</div>
	</section>
</main>

<?php
get_footer();
