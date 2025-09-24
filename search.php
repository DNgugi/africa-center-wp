<?php

/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package headless
 */

get_header();

// Get search parameters
$search_query = get_search_query();
$selected_category = isset($_GET['category']) ? sanitize_text_field($_GET['category']) : '';
$selected_post_type = isset($_GET['post_type']) ? sanitize_text_field($_GET['post_type']) : '';
$selected_date = isset($_GET['date']) ? sanitize_text_field($_GET['date']) : '';

?>

<main id="primary" class="site-main">
	<!-- Hero Section -->
	<section class="relative bg-pattern-lines text-white py-16 overflow-hidden">
		<div class="absolute inset-0 bg-gradient-to-r from-primary-blue to-secondary-burgundy opacity-95"></div>
		<div class="container mx-auto px-4 relative z-10">
			<div class="max-w-4xl mx-auto text-center">
				<h1 class="text-4xl md:text-5xl font-bold mb-6 font-heading text-primary-ochre">
					<?php if ($search_query) : ?>
						<?php
						/* translators: %s: search query. */
						printf(
							esc_html__('Search Results for: %s', 'headless'),
							'<span class="text-secondary-gold">"' . esc_html($search_query) . '"</span>'
						);
						?>
					<?php else : ?>
						<?php esc_html_e('Search Our Content', 'headless'); ?>
					<?php endif; ?>
				</h1>

				<!-- Enhanced Search Form -->
				<form role="search" method="get" class="search-form max-w-2xl mx-auto" action="<?php echo esc_url(home_url('/')); ?>">
					<div class="flex">
						<input type="search"
							class="search-field flex-1 px-4 py-3 rounded-l-lg border-0 text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary-ochre"
							placeholder="<?php echo esc_attr_x('Search for content...', 'placeholder', 'headless'); ?>"
							value="<?php echo esc_attr($search_query); ?>"
							name="s" />
						<button type="submit"
							class="search-submit px-6 py-3 bg-primary-ochre text-white rounded-r-lg hover:bg-primary-terracotta transition-colors duration-200">
							<i class="fas fa-search" aria-hidden="true"></i>
							<span class="sr-only"><?php echo esc_html_x('Search', 'submit button', 'headless'); ?></span>
						</button>
					</div>
				</form>
			</div>
		</div>
		<div class="hidden lg:block absolute -right-16 -top-16 w-64 h-64 rounded-full bg-primary-terracotta opacity-20"></div>
	</section>

	<section class="py-10 bg-secondary-sand">
		<div class="container mx-auto px-4">
			<div class="max-w-6xl mx-auto">

				<?php if ($search_query) : ?>
					<!-- Search Filters -->
					<div class="bg-white rounded-lg shadow-sm p-6 mb-8">
						<h3 class="text-lg font-semibold mb-4 text-gray-900"><?php esc_html_e('Refine Your Search', 'headless'); ?></h3>

						<form method="get" action="<?php echo esc_url(home_url('/')); ?>" class="flex flex-wrap gap-4">
							<input type="hidden" name="s" value="<?php echo esc_attr($search_query); ?>">

							<!-- Category Filter -->
							<div class="flex-1 min-w-0">
								<label for="category-filter" class="block text-sm font-medium text-gray-700 mb-1">
									<?php esc_html_e('Category', 'headless'); ?>
								</label>
								<select name="category" id="category-filter" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-ochre">
									<option value=""><?php esc_html_e('All Categories', 'headless'); ?></option>
									<?php
									$categories = get_categories();
									foreach ($categories as $category) :
									?>
										<option value="<?php echo esc_attr($category->slug); ?>" <?php selected($selected_category, $category->slug); ?>>
											<?php echo esc_html($category->name); ?> (<?php echo $category->count; ?>)
										</option>
									<?php endforeach; ?>
								</select>
							</div>

							<!-- Post Type Filter -->
							<div class="flex-1 min-w-0">
								<label for="post-type-filter" class="block text-sm font-medium text-gray-700 mb-1">
									<?php esc_html_e('Content Type', 'headless'); ?>
								</label>
								<select name="post_type" id="post-type-filter" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-ochre">
									<option value=""><?php esc_html_e('All Types', 'headless'); ?></option>
									<option value="post" <?php selected($selected_post_type, 'post'); ?>><?php esc_html_e('Posts', 'headless'); ?></option>
									<option value="page" <?php selected($selected_post_type, 'page'); ?>><?php esc_html_e('Pages', 'headless'); ?></option>
									<option value="event" <?php selected($selected_post_type, 'event'); ?>><?php esc_html_e('Events', 'headless'); ?></option>
								</select>
							</div>

							<!-- Date Filter -->
							<div class="flex-1 min-w-0">
								<label for="date-filter" class="block text-sm font-medium text-gray-700 mb-1">
									<?php esc_html_e('Date Range', 'headless'); ?>
								</label>
								<select name="date" id="date-filter" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-ochre">
									<option value=""><?php esc_html_e('Any Time', 'headless'); ?></option>
									<option value="week" <?php selected($selected_date, 'week'); ?>><?php esc_html_e('Past Week', 'headless'); ?></option>
									<option value="month" <?php selected($selected_date, 'month'); ?>><?php esc_html_e('Past Month', 'headless'); ?></option>
									<option value="year" <?php selected($selected_date, 'year'); ?>><?php esc_html_e('Past Year', 'headless'); ?></option>
								</select>
							</div>

							<div class="flex items-end">
								<button type="submit" class="px-6 py-2 bg-primary-blue text-white rounded-md hover:bg-primary-blue/90 transition-colors duration-200">
									<?php esc_html_e('Filter Results', 'headless'); ?>
								</button>
							</div>
						</form>
					</div>

					<!-- Results Count and Info -->
					<div class="flex justify-between items-center mb-6">
						<div class="text-gray-600">
							<?php
							global $wp_query;
							$total_results = $wp_query->found_posts;
							if ($total_results > 0) {
								printf(
									/* translators: %1$s: number of results, %2$s: search query */
									esc_html(_n(
										'Found %1$s result for "%2$s"',
										'Found %1$s results for "%2$s"',
										$total_results,
										'headless'
									)),
									'<strong>' . number_format_i18n($total_results) . '</strong>',
									'<strong>' . esc_html($search_query) . '</strong>'
								);
							}
							?>
						</div>

						<?php if ($selected_category || $selected_post_type || $selected_date) : ?>
							<div class="text-sm text-gray-500">
								<span><?php esc_html_e('Active filters:', 'headless'); ?></span>
								<?php if ($selected_category) : ?>
									<span class="inline-block bg-primary-ochre/10 text-primary-ochre px-2 py-1 rounded text-xs ml-1">
										<?php echo esc_html(get_category_by_slug($selected_category)->name ?? $selected_category); ?>
									</span>
								<?php endif; ?>
								<?php if ($selected_post_type) : ?>
									<span class="inline-block bg-primary-blue/10 text-primary-blue px-2 py-1 rounded text-xs ml-1">
										<?php echo esc_html(ucfirst($selected_post_type)); ?>
									</span>
								<?php endif; ?>
								<?php if ($selected_date) : ?>
									<span class="inline-block bg-primary-green/10 text-primary-green px-2 py-1 rounded text-xs ml-1">
										<?php echo esc_html(ucfirst($selected_date)); ?>
									</span>
								<?php endif; ?>
							</div>
						<?php endif; ?>
					</div>
				<?php endif; ?>

				<!-- Search Results -->
				<div class="grid gap-8">
					<?php if (have_posts()) : ?>
						<?php while (have_posts()) : the_post(); ?>
							<article class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
								<div class="p-6">
									<div class="flex flex-wrap gap-2 mb-3">
										<!-- Post Type Badge -->
										<span class="inline-block bg-primary-blue text-white px-2 py-1 rounded-full text-xs font-medium uppercase tracking-wide">
											<?php echo esc_html(get_post_type()); ?>
										</span>

										<!-- Category Badges -->
										<?php
										$categories = get_the_category();
										if ($categories) :
											foreach ($categories as $category) :
										?>
												<span class="inline-block bg-primary-ochre/10 text-primary-ochre px-2 py-1 rounded-full text-xs">
													<?php echo esc_html($category->name); ?>
												</span>
										<?php
											endforeach;
										endif;
										?>
									</div>

									<h2 class="text-xl font-bold mb-3 text-gray-900">
										<a href="<?php the_permalink(); ?>" class="hover:text-primary-blue transition-colors duration-200">
											<?php
											$title = get_the_title();
											if ($search_query) {
												$title = str_ireplace($search_query, '<mark class="bg-yellow-200">' . $search_query . '</mark>', $title);
											}
											echo wp_kses_post($title);
											?>
										</a>
									</h2>

									<div class="text-gray-600 text-sm mb-3">
										<time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
											<?php echo esc_html(get_the_date()); ?>
										</time>
										<?php if (get_the_author()) : ?>
											<span class="mx-2">•</span>
											<span><?php esc_html_e('By', 'headless'); ?> <?php the_author(); ?></span>
										<?php endif; ?>
									</div>

									<div class="text-gray-700 mb-4">
										<?php
										$excerpt = get_the_excerpt();
										if ($search_query && $excerpt) {
											$excerpt = str_ireplace($search_query, '<mark class="bg-yellow-200">' . $search_query . '</mark>', $excerpt);
										}
										echo wp_kses_post($excerpt);
										?>
									</div>

									<a href="<?php the_permalink(); ?>" class="inline-flex items-center text-primary-blue hover:text-primary-blue/80 font-medium transition-colors duration-200">
										<?php esc_html_e('Read More', 'headless'); ?>
										<svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
										</svg>
									</a>
								</div>
							</article>
						<?php endwhile; ?>

						<!-- Pagination -->
						<div class="mt-8">
							<?php
							the_posts_pagination(array(
								'prev_text' => '<svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>' . __('Previous', 'headless'),
								'next_text' => __('Next', 'headless') . '<svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>',
								'class' => 'pagination flex justify-center space-x-2',
							));
							?>
						</div>

					<?php else : ?>
						<!-- No Results -->
						<div class="bg-white rounded-lg shadow-sm p-12 text-center">
							<div class="max-w-md mx-auto">
								<div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
									<i class="fas fa-search text-gray-400 text-2xl" aria-hidden="true"></i>
								</div>

								<h3 class="text-xl font-semibold text-gray-900 mb-2">
									<?php esc_html_e('No Results Found', 'headless'); ?>
								</h3>

								<p class="text-gray-600 mb-6">
									<?php
									if ($search_query) {
										printf(
											/* translators: %s: search query */
											esc_html__('Sorry, no results were found for "%s". Try adjusting your search or filters.', 'headless'),
											esc_html($search_query)
										);
									} else {
										esc_html_e('Please enter a search term to find content.', 'headless');
									}
									?>
								</p>

								<div class="space-y-3">
									<p class="text-sm text-gray-500 font-medium"><?php esc_html_e('Suggestions:', 'headless'); ?></p>
									<ul class="text-sm text-gray-600 space-y-1">
										<li><?php esc_html_e('• Check your spelling', 'headless'); ?></li>
										<li><?php esc_html_e('• Try different keywords', 'headless'); ?></li>
										<li><?php esc_html_e('• Use more general terms', 'headless'); ?></li>
										<li><?php esc_html_e('• Remove filters to see more results', 'headless'); ?></li>
									</ul>
								</div>
							</div>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>

</main><!-- #primary -->

<?php
get_footer();
