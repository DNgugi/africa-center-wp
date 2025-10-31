<?php

/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package wpac
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('bg-neutral-lightest rounded-lg shadow-lg p-8 mb-8 border border-neutral-light'); ?>>
	<?php if (!is_singular()) : ?>
		<header class="entry-header mb-6">
			<?php
			the_title(
				'<h2 class="text-2xl md:text-3xl font-bold mb-4 font-heading text-primary-blue hover:text-primary-light-blue transition-colors duration-200"><a href="' . esc_url(get_permalink()) . '" rel="bookmark" class="no-underline">',
				'</a></h2>'
			);

			if ('post' === get_post_type()) :
			?>
				<div class="flex items-center gap-4 text-sm text-neutral-medium">
					<?php
					wpac_posted_on();
					wpac_posted_by();
					?>
				</div>
			<?php endif; ?>
		</header>
	<?php endif; ?>

	<?php wpac_post_thumbnail(); ?>

	<div class="entry-content max-w-none text-neutral-darkest font-body leading-relaxed"><?php
																							the_content(
																								sprintf(
																									wp_kses(
																										/* translators: %s: Name of current post. Only visible to screen readers */
																										__('Continue reading<span class="screen-reader-text"> "%s"</span>', 'wpac'),
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
																									'before' => '<div class="page-links mt-6 pt-6 border-t border-neutral-light text-neutral-medium">' . esc_html__('Pages:', 'wpac'),
																									'after'  => '</div>',
																								)
																							);
																							?>
	</div><!-- .entry-content -->

	<footer class="entry-footer mt-6 pt-6 border-t border-neutral-light">
		<?php wpac_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->