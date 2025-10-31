<?php

/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package wpac
 */

get_header();
?>

<main id="primary" class="site-main">
	<section class="relative bg-pattern-lines text-white py-16 overflow-hidden">
		<div class="absolute inset-0 bg-gradient-to-r from-primary-blue to-secondary-burgundy opacity-95"></div>
		<div class="container mx-auto px-4 relative z-10">
			<div class="max-w-3xl mx-auto">
				<?php while (have_posts()) : the_post(); ?>
					<h1 class="text-4xl md:text-5xl font-bold mb-6 font-heading text-primary-ochre"><?php the_title(); ?></h1>
					<div class="text-xl mb-4 text-white/90">
						<?php
						$categories = get_the_category();
						if ($categories) {
							echo '<span class="inline-block bg-primary-terracotta px-4 py-1 rounded-full text-sm font-medium">';
							echo esc_html($categories[0]->name);
							echo '</span>';
						}
						?>
					</div>
				<?php endwhile;
				rewind_posts(); ?>
			</div>
		</div>
		<div class="hidden lg:block absolute -right-16 -top-16 w-64 h-64 rounded-full bg-primary-terracotta opacity-20"></div>
	</section>

	<section class="py-10 bg-secondary-sand">
		<div class="container mx-auto px-4">
			<?php
			$sidebar_layout = get_theme_mod('page_sidebar_layout', 'right-sidebar');
			$wrapper_class = '';
			$content_class = 'w-full';

			if ($sidebar_layout !== 'no-sidebar' && is_active_sidebar('sidebar-1')) {
				$content_class = 'w-full lg:w-2/3';
				$wrapper_class = 'flex flex-wrap ' . ($sidebar_layout === 'left-sidebar' ? 'flex-row-reverse' : '');
			}
			?>
			<div class="<?php echo esc_attr($wrapper_class); ?>">
				<div class="<?php echo esc_attr($content_class); ?>">
					<?php
					while (have_posts()) :
						the_post();
						get_template_part('template-parts/content', get_post_type());

						$prev_post = get_previous_post();
						$next_post = get_next_post();

						if ($prev_post || $next_post) :
							echo '<div class="mt-8 pt-8 border-t border-gray-200 flex flex-wrap justify-between gap-4">';

							if ($prev_post) :
								echo '<a href="' . esc_url(get_permalink($prev_post)) . '" class="btn-blue btn-small">';
								echo '<svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>';
								echo esc_html($prev_post->post_title);
								echo '</a>';
							endif;

							if ($next_post) :
								echo '<a href="' . esc_url(get_permalink($next_post)) . '" class="btn-blue btn-small">';
								echo esc_html($next_post->post_title);
								echo '<svg class="w-4 h-4 ml-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>';
								echo '</a>';
							endif;

							echo '</div>';
						endif;

						// If comments are open or we have at least one comment, load up the comment template.
						if (comments_open() || get_comments_number()) :
							comments_template();
						endif;

					endwhile; // End of the loop.
					?>
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
</main><!-- #main -->

<?php
get_footer();
