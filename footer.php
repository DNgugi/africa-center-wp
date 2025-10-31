<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package wpac
 */

?>

<footer id="colophon" class="site-footer bg-primary-blue text-white">
	<div class="container mx-auto px-4 py-12">
		<!-- Footer Grid -->
		<div class="relative grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
			<?php
			// if (! is_active_sidebar('footer-widgets')) {
			// 	return;
			// }
			dynamic_sidebar('footer-widgets'); ?>





			<!-- Quick Links -->
			<!-- <div>
				<h3 class="text-xl font-bold mb-4 text-primary-ochre">Quick Links</h3>
	
				// wp_nav_menu(array(
				// 	'theme_location' => 'footer-menu',
				// 	'container' => false,
				// 	'menu_class' => 'space-y-2',
				// 	'fallback_cb' => false,
				// 	'items_wrap' => '<ul class="%2$s">%3$s</ul>',
				// 	'link_class' => 'text-gray-300 hover:text-primary-ochre transition-colors duration-200'
				// ));
				
			</div> -->


			<!-- Newsletter -->
			<!-- <div id="newsletter">
				<p class="text-sm text-gray-300 mb-4">Stay updated with our latest news and events.</p>
				<form class="space-y-4" action="https://list-manage.us6.list-manage.com/subscribe/post?u=b6ea1e261df062e0833e8db59&amp;id=ff2ca589a7&amp;f_id=00ca11e3f0" method="post" target="_blank">
					<div class="mb-3">
						<input type="email"
							id="newsletter-email"
							placeholder="Enter your email"
							class="w-full px-4 py-2 rounded bg-white/10 border border-white/20 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-ochre">
					</div>
					<div class="mb-3">
						<input type="text" name="NAME" id="mce-NAME"
							class="w-full px-4 py-2 rounded bg-white/10 border border-white/20 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-ochre"
							placeholder="Your name (optional)">
					</div>
					<div class="flex items-center justify-between">
						<button type="submit"
							class="inline-block px-6 py-2 bg-primary-ochre text-white rounded hover:bg-primary-terracotta transition-colors duration-200">
							Subscribe
						</button> -->

			<!-- Back to Top Button -->
			<!-- <button id="back-to-top" type="button"
							class="inline-flex items-center justify-center w-12 h-12 bg-gray-700 hover:bg-primary-ochre text-gray-300 hover:text-white rounded-full transition-all duration-300 cursor-pointer border-2 border-gray-600 hover:border-primary-ochre shadow-lg">
							<i class="fas fa-arrow-up text-sm"></i>
						</button>
					</div>
				</form>
			</div> -->



		</div>

		<!-- Bottom Bar -->
		<div class="mt-12 pt-8 border-t border-white/10">
			<div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
				<div class="text-sm text-gray-300">
					All rights reserved © <?php echo date('Y'); ?> <?php echo get_bloginfo('name'); ?>. Theme Design & Development by <a href="https://www.encantador.co" target="_blank" class="hover:text-primary-ochre">Studio Encantador</a>.
				</div>
				<div class="text-sm text-gray-300">
					<a href="<?php echo esc_url(home_url('/privacy-policy')); ?>" class="hover:text-primary-ochre">Privacy Policy</a>
					<span class="mx-2">|</span>
					<a href="<?php echo esc_url(home_url('/terms-of-service')); ?>" class="hover:text-primary-ochre">Terms of Service</a>
				</div>
			</div>
		</div>
	</div>
</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>

</html>