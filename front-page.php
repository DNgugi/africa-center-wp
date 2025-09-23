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

require_once get_template_directory() . '/inc/components/component-system.php';
require_once get_template_directory() . '/inc/template-functions.php';
require_once get_template_directory() . '/inc/template-tags.php';

get_header();
?><main id="primary" class="site-main">

	<!-- Hero Section -->
	<section class="relative bg-pattern-lines text-white py-20 lg:py-28 overflow-hidden">
		<div class="absolute inset-0 bg-gradient-to-r from-primary-blue to-secondary-burgundy opacity-95"></div>
		<div class="container mx-auto px-4 relative z-10">
			<div class="max-w-3xl mx-auto lg:mx-0">
				<div class="inline-block bg-primary-terracotta px-4 py-1 rounded-full text-sm font-medium mb-6">
					Welcome to Africa Center Hong Kong
				</div>
				<h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 font-heading">
					Rebranding <span class="text-primary-ochre">Blackness</span> in Asia
				</h1>
				<p class="text-xl mb-8 text-white/90">
					We are a platform & creative hub that fosters value-creating
					interactions between African and non-African communities in Asia
				</p>
				<div class="flex flex-wrap gap-4">
					<a href="/programs" class="btn btn-ochre btn-large shadow-lg">
						Explore Programs
					</a>
					<a href="#newsletter" class="btn btn-outline btn-large border-white text-white hover:bg-white/10">
						Join Our Newsletter
					</a>
				</div>
			</div>
		</div>
		<!-- Decorative elements -->
		<div class="hidden lg:block absolute -right-16 -top-16 w-64 h-64 rounded-full bg-primary-terracotta opacity-20"></div>
		<div class="hidden lg:block absolute right-1/4 bottom-0 w-32 h-32 rounded-full bg-primary-ochre opacity-20"></div>
	</section>

	<!-- Tagline Section -->
	<section class="py-10 bg-secondary-sand">
		<div class="container mx-auto px-4 text-center">
			<h2 class="text-2xl md:text-3xl font-bold text-primary-blue">
				African Solutions for Glocal Issues
			</h2>
		</div>
	</section>

	<!-- Featured Programs -->
	<?php
	$featured_programs = array(
		array(
			'title' => 'We have Moved',
			'image' => 'https://www.africacenterhk.com/wp-content/uploads/we-moved-1024x576.png',
			'url' => '/directions',
			'badge' => 'New Location'
		),
		array(
			'title' => 'Christmas Camp Open for Sign-up!',
			'image' => 'https://www.africacenterhk.com/wp-content/uploads/Afro-multi-activity-camp-summer-christmas-easter-1-1024x576.jpg',
			'url' => '/afro-multi-activity-christmas-camp-2025',
			'badge' => 'For Kids'
		),
		array(
			'title' => 'Newly Added Event for Art Lovers!',
			'image' => 'https://www.africacenterhk.com/wp-content/uploads/Cool-Africa-Craft-Crunch-1024x576.png',
			'url' => '/events',
			'badge' => 'Art & Culture'
		),
		array(
			'title' => 'Kids\' Afterschool Activities',
			'image' => 'https://www.africacenterhk.com/wp-content/uploads/ACHK-Banner-Cool-Africa-Tots-Art-Playgroup-Junior-Art-Class.png',
			'url' => '/cool-africa-programs',
			'description' => 'Creative and educational activities for children'
		),
		array(
			'title' => 'Diversity, Equity & Inclusion Workshops',
			'image' => 'https://www.africacenterhk.com/wp-content/uploads/Team-Building-1-1-1-1024x688.jpeg',
			'url' => '/diversity-equity-inclusion-workshop',
			'description' => 'Team building activities for organizations'
		),
		array(
			'title' => 'Injera Night! Ethiopian Culinary Experience',
			'image' => 'https://www.africacenterhk.com/wp-content/uploads/1-33-1024x512.png',
			'url' => '/ethiopian-eritrean-private-dinner',
			'badge' => 'Food & Culture'
		)
	);
	?>
	<section class="py-16 bg-neutral-lightest">
		<div class="container mx-auto px-4">
			<div class="flex flex-col md:flex-row justify-between items-center mb-12">
				<div>
					<div class="inline-block bg-secondary-sand px-3 py-1 rounded-full text-sm font-medium text-primary-terracotta mb-2">
						Discover
					</div>
					<h2 class="text-3xl font-bold text-primary-blue">
						Featured Programs
					</h2>
				</div>
				<a href="/programs" class="btn btn-terracotta mt-4 md:mt-0">
					View All Programs
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
								Learn More
								<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20" fill="currentColor">
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
	$mission_items = array(
		array(
			'title' => 'Rebranding Blackness',
			'description' => 'Blackness is often associated with danger and/or vulnerability, we challenge this perception and offer an opportunity to appreciate and benefit from accurate representations of blackness.',
			'icon' => 'refresh',
			'url' => 'https://themilsource.com/2021/12/03/how-africa-center-hong-kong-founder-and-ceo-innocent-mutanga-is-rebranding-africa/'
		),
		array(
			'title' => 'Connecting Communities',
			'description' => 'We aim to become the biggest uniquely African platform in Asia to connect and build communities across ethnic groups, gender, socio-economic status, etc., and facilitate value-exchange between these communities.',
			'icon' => 'users',
			'url' => 'https://www.africacenterhk.com/2022/04/26/connecting-communities-april-2022%ef%bc%89/'
		),
		array(
			'title' => 'Black Consciousness',
			'description' => 'We champion an African perspective, especially the need for consciousness of the power dynamics rooted in colonialism and the need for self-love. We emphasize the value and need of an African perspective in today\'s uncertain world.',
			'icon' => 'brain',
			'url' => 'https://www.africacenterhk.com/2021/10/19/our-hairstory-oct-2021/'
		)
	);
	?>
	<section class="py-16 bg-pattern-dots">
		<div class="container mx-auto px-4">
			<div class="text-center mb-12">
				<div class="inline-block bg-white px-3 py-1 rounded-full text-sm font-medium text-primary-terracotta mb-2">
					Our Purpose
				</div>
				<h2 class="text-3xl font-bold mb-2 text-primary-blue">
					We work for a future where Africa has an equal footing
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
							Learn More
							<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20" fill="currentColor">
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
	$values = array(
		array(
			'title' => 'Diversity',
			'description' => 'We welcome and appreciate different perspectives',
			'icon' => 'users'
		),
		array(
			'title' => 'Curiosity',
			'description' => 'We value curiosity and continuous learning',
			'icon' => 'eye'
		),
		array(
			'title' => 'Empathy',
			'description' => 'We encourage stepping into other\'s shoes and seeing the world through their eyes',
			'icon' => 'heart'
		),
		array(
			'title' => 'Dignity',
			'description' => 'We prioritize dignity in all our interactions',
			'icon' => 'hand'
		)
	);
	?>
	<section class="py-16 bg-white">
		<div class="container mx-auto px-4">
			<div class="text-center mb-12">
				<div class="inline-block bg-secondary-sand px-3 py-1 rounded-full text-sm font-medium text-primary-terracotta mb-2">
					What Guides Us
				</div>
				<h2 class="text-3xl font-bold text-primary-blue">Our Values</h2>
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
	$gallery_items = array(
		array(
			'image' => get_template_directory_uri() . '/assets/gallery-1.jpg',
			'title' => 'Cultural Exhibition',
			'description' => 'A display of traditional African art.'
		),
		array(
			'image' => get_template_directory_uri() . '/assets/gallery-2.jpg',
			'title' => 'Youth Workshop',
			'description' => 'Engaging young people in cultural learning.'
		),
		array(
			'image' => get_template_directory_uri() . '/assets/gallery-3.jpg',
			'title' => 'Dance Performance',
			'description' => 'Traditional African dance showcase.'
		),
		array(
			'image' => get_template_directory_uri() . '/assets/gallery-4.jpg',
			'title' => 'Community Gathering',
			'description' => 'Bringing together diverse communities.'
		)
	);
	?>
	<section class="py-16 bg-neutral-light">
		<div class="container mx-auto px-4">
			<div class="text-center mb-12">
				<div class="inline-block bg-secondary-sand px-3 py-1 rounded-full text-sm font-medium text-primary-terracotta mb-2">
					Our Latest Events
				</div>
				<h2 class="text-3xl font-bold text-primary-blue">Photo Gallery</h2>
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
	$testimonials = array(
		array(
			'name' => 'Laura Akech',
			'title' => 'English Teacher',
			'quote' => 'It is a fun and family-friendly space to find heartwarming African food and direct connection to the local African community. The center is for everyone, where they can freely express themselves and their ideas.',
			'image' => 'https://www.africacenterhk.com/wp-content/uploads/cropped-Screenshot-2023-01-05-at-11.41.18.png'
		),
		array(
			'name' => 'Felix',
			'title' => 'Researcher',
			'quote' => 'The Africa Center is a turning point for the African communities within Hong Kong, and for those who wish to learn and integrate with the community not just within the city, but through out the African diaspora.',
			'image' => 'https://www.africacenterhk.com/wp-content/uploads/cropped-Screenshot-2023-01-05-at-11.41.23.png'
		),
		array(
			'name' => 'Daniela Lusan',
			'title' => 'Radio Show Host',
			'quote' => 'I value the \'African Literature Book Club\' as I value Women\'s Day and Black History Month because African literature deserves a spotlight.',
			'image' => 'https://www.africacenterhk.com/wp-content/uploads/2020/09/Daniela.png'
		)
	);
	?>
	<section class="py-16 bg-pattern-lines relative overflow-hidden">
		<div class="absolute inset-0 bg-gradient-to-b from-primary-blue to-secondary-burgundy opacity-90"></div>
		<div class="container mx-auto px-4 relative z-10">
			<div class="max-w-3xl mx-auto text-center mb-12">
				<div class="inline-block bg-white/90 px-3 py-1 rounded-full text-sm font-medium text-primary-terracotta mb-2">
					What People Say
				</div>
				<h2 class="text-3xl font-bold text-primary-ochre">Community Voices</h2>
			</div>
			<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
				<?php foreach ($testimonials as $testimonial) : ?>
					<div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow">
						<div class="p-6">
							<div class="flex flex-col items-center text-center">
								<div class="mb-6 relative">
									<div class="absolute -left-4 -top-4 w-8 h-8 text-primary-terracotta">
										<svg viewBox="0 0 24 24" fill="currentColor">
											<path d="M4.583 17.321C3.553 16.227 3 15 3 13.011c0-3.5 2.457-6.637 6.03-8.188l.893 1.378c-3.335 1.804-3.987 4.145-4.247 5.621.537-.278 1.24-.375 1.929-.311 1.804.167 3.226 1.648 3.226 3.489a3.5 3.5 0 01-3.5 3.5c-1.073 0-2.099-.49-2.748-1.179zm10 0C13.553 16.227 13 15 13 13.011c0-3.5 2.457-6.637 6.03-8.188l.893 1.378c-3.335 1.804-3.987 4.145-4.247 5.621.537-.278 1.24-.375 1.929-.311 1.804.167 3.226 1.648 3.226 3.489a3.5 3.5 0 01-3.5 3.5c-1.073 0-2.099-.49-2.748-1.179z" />
										</svg>
									</div>
									<div class="w-20 h-20 mx-auto relative rounded-full border-4 border-secondary-sand overflow-hidden">
										<img
											src="<?php echo esc_url($testimonial['image']); ?>"
											alt="<?php echo esc_attr($testimonial['name']); ?>"
											class="w-full h-full object-cover"
											loading="lazy" />
									</div>
									<div class="absolute -right-4 -bottom-4 w-8 h-8 text-primary-terracotta rotate-180">
										<svg viewBox="0 0 24 24" fill="currentColor">
											<path d="M4.583 17.321C3.553 16.227 3 15 3 13.011c0-3.5 2.457-6.637 6.03-8.188l.893 1.378c-3.335 1.804-3.987 4.145-4.247 5.621.537-.278 1.24-.375 1.929-.311 1.804.167 3.226 1.648 3.226 3.489a3.5 3.5 0 01-3.5 3.5c-1.073 0-2.099-.49-2.748-1.179zm10 0C13.553 16.227 13 15 13 13.011c0-3.5 2.457-6.637 6.03-8.188l.893 1.378c-3.335 1.804-3.987 4.145-4.247 5.621.537-.278 1.24-.375 1.929-.311 1.804.167 3.226 1.648 3.226 3.489a3.5 3.5 0 01-3.5 3.5c-1.073 0-2.099-.49-2.748-1.179z" />
										</svg>
									</div>
								</div>
								<blockquote class="text-neutral-dark italic mb-6">
									"<?php echo esc_html($testimonial['quote']); ?>"
								</blockquote>
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
	// Query for upcoming events
	$events = array(
		array(
			'title' => 'African Literature Book Club',
			'date' => '2025-10-15',
			'time' => '19:00',
			'location' => 'Africa Center HK',
			'image' => 'https://www.africacenterhk.com/wp-content/uploads/Book-club-1024x576.jpg',
			'url' => '/events/african-literature-book-club'
		),
		array(
			'title' => 'Ethiopian Coffee Ceremony',
			'date' => '2025-10-20',
			'time' => '14:30',
			'location' => 'Africa Center HK',
			'image' => 'https://www.africacenterhk.com/wp-content/uploads/Coffee-ceremony-1024x576.jpg',
			'url' => '/events/ethiopian-coffee-ceremony'
		),
		array(
			'title' => 'African Dance Workshop',
			'date' => '2025-10-25',
			'time' => '16:00',
			'location' => 'Africa Center HK',
			'image' => 'https://www.africacenterhk.com/wp-content/uploads/Dance-workshop-1024x576.jpg',
			'url' => '/events/african-dance-workshop'
		)
	);
	?>
	<section class="py-16 bg-white">
		<div class="container mx-auto px-4">
			<div class="flex flex-col md:flex-row justify-between items-center mb-12">
				<div>
					<div class="inline-block bg-secondary-sand px-3 py-1 rounded-full text-sm font-medium text-primary-terracotta mb-2">
						Join Us
					</div>
					<h2 class="text-3xl font-bold text-primary-blue">
						Upcoming Events
					</h2>
				</div>
				<a href="/events" class="btn btn-terracotta mt-4 md:mt-0">
					All Events
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
							<div class="flex items-center gap-2 mb-3 text-sm text-neutral-dark">
								<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
									<path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
								</svg>
								<?php
								$date = new DateTime($event['date']);
								echo esc_html($date->format('F j, Y'));
								?>
								<span class="mx-2">|</span>
								<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
									<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
								</svg>
								<?php echo esc_html($event['time']); ?>
							</div>
							<h3 class="text-xl font-bold mb-2 text-primary-blue">
								<?php echo esc_html($event['title']); ?>
							</h3>
							<div class="flex items-center gap-2 text-sm text-neutral-dark mb-4">
								<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
									<path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
								</svg>
								<?php echo esc_html($event['location']); ?>
							</div>
							<a href="<?php echo esc_url($event['url']); ?>"
								class="inline-flex items-center text-primary-terracotta font-medium hover:text-primary-ochre transition-colors">
								Learn More
								<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20" fill="currentColor">
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