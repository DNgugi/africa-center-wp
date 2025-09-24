<?php

/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package headless
 */

get_header();
?>

<main id="primary" class="site-main">
	<?php if (have_posts()) : ?>
		<!-- Hero Section -->
		<section class="relative bg-pattern-dots text-white py-16 overflow-hidden">
			<div class="absolute inset-0 bg-gradient-to-r from-primary-terracotta to-secondary-burgundy opacity-95"></div>
			<div class="container mx-auto px-4 relative z-10">
				<div class="max-w-4xl mx-auto text-center">
					<?php
					$archive_title = get_the_archive_title();
					$archive_description = get_the_archive_description();
					?>
					<h1 class="text-4xl md:text-5xl font-bold mb-6 font-heading text-primary-ochre">
						<?php echo wp_kses_post($archive_title); ?>
					</h1>
					<?php if ($archive_description) : ?>
						<div class="text-xl mb-4 text-white/90 max-w-2xl mx-auto">
							<?php echo wp_kses_post($archive_description); ?>
						</div>
					<?php endif; ?>

					<!-- Archive Meta Info -->
					<div class="flex flex-wrap justify-center gap-4 text-sm">
						<?php if (is_category()) : ?>
							<span class="inline-block bg-primary-green px-4 py-2 rounded-full font-medium">
								<i class="fas fa-folder mr-2"></i>
								Category Archive
							</span>
						<?php elseif (is_tag()) : ?>
							<span class="inline-block bg-primary-blue px-4 py-2 rounded-full font-medium">
								<i class="fas fa-tag mr-2"></i>
								Tag Archive
							</span>
						<?php elseif (is_author()) : ?>
							<span class="inline-block bg-secondary-clay px-4 py-2 rounded-full font-medium">
								<i class="fas fa-user mr-2"></i>
								Author Archive
							</span>
						<?php elseif (is_date()) : ?>
							<span class="inline-block bg-primary-ochre px-4 py-2 rounded-full font-medium">
								<i class="fas fa-calendar mr-2"></i>
								Date Archive
							</span>
						<?php endif; ?>

						<span class="inline-block bg-neutral-medium px-4 py-2 rounded-full font-medium">
							<i class="fas fa-file-alt mr-2"></i>
							<?php echo esc_html(sprintf(_n('%d Post', '%d Posts', $wp_query->found_posts, 'headless'), $wp_query->found_posts)); ?>
						</span>
					</div>
				</div>
			</div>
			<div class="hidden lg:block absolute -right-16 -top-16 w-64 h-64 rounded-full bg-primary-green opacity-20"></div>
			<div class="hidden lg:block absolute -left-16 -bottom-16 w-48 h-48 rounded-full bg-primary-ochre opacity-15"></div>
		</section>

		<!-- Content Section -->
		<section class="py-10 bg-secondary-sand">
			<div class="container mx-auto px-4">
				<?php
				$sidebar_layout = get_theme_mod('archive_sidebar_layout', 'right-sidebar');
				$wrapper_class = '';
				$content_class = 'w-full';

				if ($sidebar_layout !== 'no-sidebar' && is_active_sidebar('sidebar-1')) {
					$content_class = 'w-full lg:w-2/3';
					$wrapper_class = 'flex flex-wrap ' . ($sidebar_layout === 'left-sidebar' ? 'flex-row-reverse' : '');
				}
				?>
				<div class="<?php echo esc_attr($wrapper_class); ?>">
					<div class="<?php echo esc_attr($content_class); ?>">
						<!-- Posts Grid -->
						<div class="space-y-8">
							<?php
							/* Start the Loop */
							while (have_posts()) :
								the_post();

								/*
								 * Include the Post-Type-specific template for the content.
								 * If you want to override this in a child theme, then include a file
								 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
								 */
								get_template_part('template-parts/content', get_post_type());

							endwhile;
							?>
						</div>

						<!-- Pagination -->
						<div class="mt-12 pt-8 border-t border-neutral-light">
							<?php
							the_posts_pagination(array(
								'mid_size' => 2,
								'prev_text' => '<i class="fas fa-chevron-left mr-2"></i>' . __('Previous', 'headless'),
								'next_text' => __('Next', 'headless') . '<i class="fas fa-chevron-right ml-2"></i>',
								'before_page_number' => '<span class="sr-only">' . __('Page', 'headless') . ' </span>',
								'class' => 'pagination flex flex-wrap justify-center items-center gap-2',
							));
							?>
						</div>
					</div><!-- .content-area -->

					<?php if ($sidebar_layout !== 'no-sidebar' && is_active_sidebar('sidebar-1')) : ?>
						<div class="lg:w-1/3 mt-8 lg:mt-0 <?php echo $sidebar_layout === 'left-sidebar' ? 'lg:pr-8' : 'lg:pl-8'; ?>">
							<aside id="secondary" class="widget-area">
								<?php dynamic_sidebar('sidebar-1'); ?>
							</aside>
						</div>
					<?php endif; ?>
				</div><!-- .flex-wrap -->
			</div><!-- .container -->
		</section>

	<?php else : ?>
		<!-- No Posts Found Section -->
		<section class="relative bg-pattern-lines text-white py-16 overflow-hidden">
			<div class="absolute inset-0 bg-gradient-to-r from-neutral-dark to-neutral-medium opacity-95"></div>
			<div class="container mx-auto px-4 relative z-10">
				<div class="max-w-2xl mx-auto text-center">
					<h1 class="text-4xl md:text-5xl font-bold mb-6 font-heading text-primary-ochre">
						<?php esc_html_e('Nothing Found', 'headless'); ?>
					</h1>
					<p class="text-xl text-white/90">
						<?php esc_html_e('It seems we can\'t find what you\'re looking for. Perhaps searching can help.', 'headless'); ?>
					</p>
				</div>
			</div>
		</section>

		<section class="py-10 bg-secondary-sand">
			<div class="container mx-auto px-4">
				<div class="max-w-2xl mx-auto">
					<?php get_template_part('template-parts/content', 'none'); ?>
				</div>
			</div>
		</section>
	<?php endif; ?>
</main><!-- #main -->

<?php
get_footer();
