<?php

/**
 * The front page template file
 *
 * This is the template that displays the front page of the site.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package headless
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

require_once get_template_directory() . '/inc/template-functions.php';
require_once get_template_directory() . '/inc/template-tags.php';
require_once get_template_directory() . '/inc/front-page-options.php'; // Include front page options

get_header();
?><main id="primary" class="site-main">

	<!-- Hero Section -->
	<?php
	$hero = headless_get_hero_options();
	?>
	<section class="relative text-white py-20 lg:py-28 overflow-hidden" style="background-image: url('<?php echo esc_url($hero['background']); ?>'); background-size: cover;">
		<div class="container mx-auto px-4 relative z-10">
			<div class="max-w-3xl mx-auto lg:mx-0">
				<div class="inline-block bg-primary-terracotta px-4 py-1 rounded-full text-sm font-medium mb-6">
					<?php echo esc_html($hero['badge_text']); ?>
				</div>
				<h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 font-heading text-primary-ochre">
					<?php echo wp_kses_post($hero['heading']); ?>
				</h1>
				<p class="text-xl mb-8 text-white/90">
					<?php echo esc_html($hero['description']); ?>
				</p>
				<div class="flex flex-wrap gap-4">
					<a href="<?php echo esc_url($hero['primary_button_url']); ?>" class="btn btn-ochre btn-large shadow-lg">
						<?php echo esc_html($hero['primary_button_text']); ?>
					</a>
					<a href="<?php echo esc_url($hero['secondary_button_url']); ?>" class="btn btn-outline btn-large border-white text-white hover:bg-white/10">
						<?php echo esc_html($hero['secondary_button_text']); ?>
					</a>
				</div>
			</div>
		</div>
		<!-- Decorative elements -->
		<div class="hidden lg:block absolute -right-16 -top-16 w-64 h-64 rounded-full bg-primary-terracotta opacity-20"></div>
		<div class="hidden lg:block absolute right-1/4 bottom-0 w-32 h-32 rounded-full bg-primary-ochre opacity-20"></div>
	</section>

	<!-- Tagline Section -->
	<?php
	$tagline = headless_get_tagline_options();
	?>
	<section class="py-10 bg-secondary-sand">
		<div class="container mx-auto px-4 text-center">
			<h2 class="text-2xl md:text-3xl font-bold text-primary-blue">
				<?php echo esc_html($tagline['text']); ?>
			</h2>
		</div>
	</section>

	<!-- Featured Programs -->
	<?php
	$programs_section = headless_get_programs_section_options();
	$featured_programs = headless_get_featured_programs();
	?>
	<section class="py-16 bg-neutral-lightest">
		<div class="container mx-auto px-4">
			<div class="flex flex-col md:flex-row justify-between items-center mb-12">
				<div>
					<div class="inline-block bg-secondary-sand px-3 py-1 rounded-full text-sm font-medium text-primary-terracotta mb-2">
						<?php echo esc_html($programs_section['badge_text']); ?>
					</div>
					<h2 class="text-3xl font-bold text-primary-blue">
						<?php echo esc_html($programs_section['heading']); ?>
					</h2>
				</div>
				<a href="<?php echo esc_url($programs_section['button_url']); ?>" class="btn btn-terracotta mt-4 md:mt-0">
					<?php echo esc_html($programs_section['button_text']); ?>
				</a>
			</div>
			<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
				<?php foreach ($featured_programs as $program) : ?>
					<div class="bg-white rounded-lg overflow-hidden shadow-md group hover:shadow-lg transition-shadow">
						<?php if (!empty($program['image'])) : ?>
							<div class="relative h-48">
								<img src="<?php echo esc_url($program['image']); ?>"
									alt="<?php echo esc_attr($program['title']); ?>"
									class="w-full h-full object-cover" />
								<?php if (!empty($program['badge'])) : ?>
									<div class="absolute top-4 right-4 bg-white/90 px-3 py-1 rounded-full text-xs font-medium text-primary-terracotta">
										<?php echo esc_html($program['badge']); ?>
									</div>
								<?php endif; ?>
							</div>
						<?php endif; ?>
						<div class="p-6">
							<h3 class="text-xl font-bold mb-2 text-primary-blue group-hover:text-primary-terracotta transition-colors">
								<?php echo esc_html($program['title']); ?>
							</h3>
							<?php if (!empty($program['description'])) : ?>
								<p class="text-neutral-dark mb-4">
									<?php echo esc_html($program['description']); ?>
								</p>
							<?php endif; ?>
							<a href="<?php echo esc_url($program['url']); ?>" class="inline-flex items-center text-primary-terracotta font-medium">
								<span>Learn More</span>
								<svg class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
									<path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H3a1 1 0 110-2h9.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
								</svg>
							</a>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- Mission Section -->
	<?php
	$mission_section = headless_get_mission_section_options();
	$mission_items = headless_get_mission_items();
	?>
	<section class="py-16" style="background-image: url('<?php echo esc_url($mission_section['background']); ?>'); background-size: cover;">
		<div class="container mx-auto px-4">
			<div class="text-center mb-12">
				<div class="inline-block bg-white px-3 py-1 rounded-full text-sm font-medium text-primary-terracotta mb-2">
					<?php echo esc_html($mission_section['badge_text']); ?>
				</div>
				<h2 class="text-3xl font-bold mb-2 text-primary-blue">
					<?php echo esc_html($mission_section['heading']); ?>
				</h2>
				<div class="w-24 h-1 bg-primary-ochre mx-auto"></div>
			</div>
			<div class="grid grid-cols-1 md:grid-cols-3 gap-8">
				<?php foreach ($mission_items as $item) : ?>
					<div class="bg-white rounded-lg p-6 shadow-md hover:shadow-lg transition-shadow">
						<div class="flex items-center mb-4">
							<span class="text-primary-terracotta">
								<i class="fas fa-<?php echo esc_attr($item['icon']); ?> fa-2x"></i>
							</span>
						</div>
						<h3 class="text-xl font-bold mb-3 text-primary-blue">
							<?php echo esc_html($item['title']); ?>
						</h3>
						<p class="text-neutral-dark mb-4">
							<?php echo esc_html($item['description']); ?>
						</p>
						<a href="<?php echo esc_url($item['url']); ?>"
							class="inline-flex items-center text-primary-terracotta font-medium hover:text-primary-ochre transition-colors">
							<span>Learn More</span>
							<svg class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
								<path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H3a1 1 0 110-2h9.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
							</svg>
						</a>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- Values Section -->
	<?php
	$values_section = headless_get_values_section_options();
	$values = headless_get_values();
	?>
	<section class="py-16 bg-white">
		<div class="container mx-auto px-4">
			<div class="text-center mb-12">
				<div class="inline-block bg-secondary-sand px-3 py-1 rounded-full text-sm font-medium text-primary-terracotta mb-2">
					<?php echo esc_html($values_section['badge_text']); ?>
				</div>
				<h2 class="text-3xl font-bold text-primary-blue"><?php echo esc_html($values_section['heading']); ?></h2>
			</div>
			<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
				<?php foreach ($values as $value) : ?>
					<div class="text-center p-6">
						<div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-secondary-sand text-primary-terracotta mb-4">
							<i class="fas fa-<?php echo esc_attr($value['icon']); ?>"></i>
						</div>
						<h3 class="text-xl font-bold mb-2 text-primary-blue">
							<?php echo esc_html($value['title']); ?>
						</h3>
						<p class="text-neutral-dark">
							<?php echo esc_html($value['description']); ?>
						</p>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- Gallery Section -->
	<?php
	$gallery_section = headless_get_gallery_section_options();
	$gallery_items = headless_get_gallery_items();
	?>
	<section class="py-16 bg-neutral-light">
		<div class="container mx-auto px-4">
			<div class="text-center mb-12">
				<div class="inline-block bg-secondary-sand px-3 py-1 rounded-full text-sm font-medium text-primary-terracotta mb-2">
					<?php echo esc_html($gallery_section['badge_text']); ?>
				</div>
				<h2 class="text-3xl font-bold text-primary-blue"><?php echo esc_html($gallery_section['heading']); ?></h2>
			</div>
			<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
				<?php foreach ($gallery_items as $item) : ?>
					<div class="bg-white rounded-lg overflow-hidden shadow-md">
						<div class="relative h-48">
							<img
								src="<?php echo esc_url($item['image']); ?>"
								alt="<?php echo esc_attr($item['title']); ?>"
								class="w-full h-full object-cover">
						</div>
						<div class="p-4">
							<h3 class="text-lg font-semibold text-primary-blue mb-2">
								<?php echo esc_html($item['title']); ?>
							</h3>
							<p class="text-sm text-neutral-dark">
								<?php echo esc_html($item['description']); ?>
							</p>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- Community Voices Section -->
	<?php
	$testimonials_section = headless_get_testimonials_section_options();
	$testimonials = headless_get_testimonials();
	?>
	<section class="py-16 relative overflow-hidden" style="background-image: url('<?php echo esc_url($testimonials_section['background']); ?>'); background-repeat: repeat;">
		<div class="container mx-auto px-4 relative z-10">
			<div class="max-w-3xl mx-auto text-center mb-12">
				<div class="inline-block bg-white px-3 py-1 rounded-full text-sm font-medium text-primary-terracotta mb-2">
					<?php echo esc_html($testimonials_section['badge_text']); ?>
				</div>
				<h2 class="text-3xl font-bold text-primary-blue"><?php echo esc_html($testimonials_section['heading']); ?></h2>
			</div>
			<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
				<?php foreach ($testimonials as $testimonial) : ?>
					<div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow">
						<div class="p-6">
							<div class="flex flex-col items-center text-center">
								<div class="mb-8">
									<div class="w-20 h-20 mx-auto relative rounded-full border-4 border-secondary-sand overflow-hidden">
										<img
											src="<?php echo esc_url($testimonial['image']); ?>"
											alt="<?php echo esc_attr($testimonial['name']); ?>"
											class="w-full h-full object-cover"
											loading="lazy" />
									</div>
								</div>
								<div class="relative mb-6 mx-3">
									<div class="absolute -left-4 -top-3 w-6 h-6 text-primary-terracotta">
										<img src="<?php echo get_template_directory_uri(); ?>/images/custom-svgs/quote.svg" alt="Quote" class="w-full h-full">
									</div>
									<blockquote class="text-neutral-dark italic px-8 py-3 no-bq-style">
										<?php echo esc_html($testimonial['quote']); ?>
									</blockquote>
									<div class="absolute -right-4 -bottom-3 w-6 h-6 text-primary-terracotta">
										<img src="<?php echo get_template_directory_uri(); ?>/images/custom-svgs/quote-flipped.svg" alt="Quote" class="w-full h-full">
									</div>
								</div>
								<div class="border-t border-neutral-light pt-4">
									<h4 class="font-semibold text-primary-blue">
										<?php echo esc_html($testimonial['name']); ?>
									</h4>
									<p class="text-primary-terracotta text-sm">
										<?php echo esc_html($testimonial['title']); ?>
									</p>
								</div>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		<!-- Decorative elements -->
		<div class="hidden lg:block absolute -right-16 -top-16 w-64 h-64 rounded-full bg-primary-terracotta opacity-20"></div>
		<div class="hidden lg:block absolute left-1/4 bottom-0 w-32 h-32 rounded-full bg-primary-ochre opacity-20"></div>
	</section>

	<!-- Events Section -->
	<?php
	$events_section = headless_get_events_section_options();
	$events = headless_get_events();
	?>
	<section class="py-16 bg-white">
		<div class="container mx-auto px-4">
			<div class="flex flex-col md:flex-row justify-between items-center mb-12">
				<div>
					<div class="inline-block bg-secondary-sand px-3 py-1 rounded-full text-sm font-medium text-primary-terracotta mb-2">
						<?php echo esc_html($events_section['badge_text']); ?>
					</div>
					<h2 class="text-3xl font-bold text-primary-blue">
						<?php echo esc_html($events_section['heading']); ?>
					</h2>
				</div>
				<a href="<?php echo esc_url($events_section['button_url']); ?>" class="btn btn-terracotta mt-4 md:mt-0">
					<?php echo esc_html($events_section['button_text']); ?>
				</a>
			</div>
			<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
				<?php foreach ($events as $event) : ?>
					<div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow">
						<?php if (!empty($event['image'])) : ?>
							<div class="relative h-48">
								<img
									src="<?php echo esc_url($event['image']); ?>"
									alt="<?php echo esc_attr($event['title']); ?>"
									class="w-full h-full object-cover">
							</div>
						<?php endif; ?>
						<div class="p-6">
							<div class="flex items-center gap-3 mb-3 text-sm text-neutral-dark">
								<img src="<?php echo get_template_directory_uri(); ?>/images/custom-svgs/calendar.svg" class="h-5 w-5" alt="Calendar">
								<span>
									<?php
									$date = new DateTime($event['date']);
									echo esc_html($date->format('F j, Y'));
									?>
								</span>
								<span class="mx-2">|</span>
								<img src="<?php echo get_template_directory_uri(); ?>/images/custom-svgs/clock.svg" class="h-5 w-5" alt="Clock">
								<span><?php echo esc_html($event['time']); ?></span>
							</div>
							<h3 class="text-xl font-bold mb-2 text-primary-blue">
								<?php echo esc_html($event['title']); ?>
							</h3>
							<div class="flex items-center gap-3 text-sm text-neutral-dark mb-4">
								<img src="<?php echo get_template_directory_uri(); ?>/images/custom-svgs/location-pin.svg" class="h-5 w-5" alt="Location Pin">
								<span><?php echo esc_html($event['location']); ?></span>
							</div>
							<a href="<?php echo esc_url($event['url']); ?>"
								class="inline-flex items-center text-primary-terracotta font-medium hover:text-primary-ochre transition-colors">
								<span>Learn More</span>
								<svg class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
									<path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H3a1 1 0 110-2h9.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
								</svg>
							</a>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

</main>

<?php
get_footer();
?>