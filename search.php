<?php

/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package headless
 */

get_header();
?>

<main id="primary" class="site-main">
	<section class="relative bg-pattern-lines text-white py-16 overflow-hidden">
		<div class="absolute inset-0 bg-gradient-to-r from-primary-blue to-secondary-burgundy opacity-95"></div>
		<div class="container mx-auto px-4 relative z-10">
			<div class="max-w-3xl mx-auto">
				<h1 class="text-4xl md:text-5xl font-bold mb-6 font-heading">
					<?php
					/* translators: %s: search query. */
					printf(
						esc_html__('Search Results for: %s', 'headless'),
						'<span class="text-primary-ochre">' . get_search_query() . '</span>'
					);
					?>
				</h1>
			</div>
		</div>
		<div class="hidden lg:block absolute -right-16 -top-16 w-64 h-64 rounded-full bg-primary-terracotta opacity-20"></div>
	</section>

	<section class="py-10 bg-secondary-sand">
		<div class="container mx-auto px-4">
			<div class="max-w-3xl mx-auto">
				<?php if (have_posts()) : ?>
				<?php
					/* Start the Loop */
					while (have_posts()) :
						the_post();

						/**
						 * Run the loop for the search to output the results.
						 * If you want to overload this in a child theme then include a file
						 * called content-search.php and that will be used instead.
						 */
						get_template_part('template-parts/content', 'search');

					endwhile;

					the_posts_navigation();

				else :

					get_template_part('template-parts/content', 'none');

				endif;
				?>

</main><!-- #main -->

<?php
get_sidebar();
get_footer();
