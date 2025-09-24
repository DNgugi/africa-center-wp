<?php

/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
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
				<?php if (is_home() && ! is_front_page()) : ?>
					<h1 class="text-4xl md:text-5xl font-bold mb-6 font-heading text-primary-ochre"><?php single_post_title(); ?></h1>
				<?php endif; ?>
			</div>
		</div>
		<div class="hidden lg:block absolute -right-16 -top-16 w-64 h-64 rounded-full bg-primary-terracotta opacity-20"></div>
	</section>

	<section class="py-10 bg-secondary-sand">
		<div class="container mx-auto px-4">
			<?php
			if (have_posts()) :

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

				// Custom posts navigation
				$prev_link = get_previous_posts_link(__('Newer Posts', 'headless'));
				$next_link = get_next_posts_link(__('Older Posts', 'headless'));

				if ($prev_link || $next_link) :
					echo '<div class="mt-8 pt-8 border-t border-gray-200 flex flex-wrap justify-between gap-4">';
					if ($prev_link) :
						echo str_replace('<a', '<a class="btn-blue btn-small"', $prev_link);
					endif;
					if ($next_link) :
						echo str_replace('<a', '<a class="btn-blue btn-small"', $next_link);
					endif;
					echo '</div>';
				endif;

			else :

				get_template_part('template-parts/content', 'none');

			endif;
			?>

</main><!-- #main -->

<?php
get_sidebar();
get_footer();
