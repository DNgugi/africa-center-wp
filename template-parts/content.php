<?php

/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package headless
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('bg-white rounded-lg shadow-lg p-6 mb-8'); ?>>
	<?php if (!is_singular()) : ?>
		<header class="entry-header mb-6">
			<?php
			the_title(
				'<h2 class="text-2xl md:text-3xl font-bold mb-4 font-heading hover:text-primary-blue"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">',
				'</a></h2>'
			);

			if ('post' === get_post_type()) :
			?>
				<div class="flex items-center gap-4 text-sm text-gray-600">
					<?php
					headless_posted_on();
					headless_posted_by();
					?>
				</div>
			<?php endif; ?>
		</header>
	<?php endif; ?>

	<?php headless_post_thumbnail(); ?>

	<div class="entry-content prose prose-lg max-w-none">
		<?php
		the_content(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__('Continue reading<span class="screen-reader-text"> "%s"</span>', 'headless'),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post(get_the_title())
			)
		);

		wp_link_pages(
			array(
				'before' => '<div class="page-links mt-4 pt-4 border-t border-gray-200">' . esc_html__('Pages:', 'headless'),
				'after'  => '</div>',
			)
		);
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php headless_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->