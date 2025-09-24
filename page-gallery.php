<?php

/**
 * Template Name: Gallery Page
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
                <h1 class="text-4xl md:text-5xl font-bold mb-6 font-heading text-primary-ochre"><?php the_title(); ?></h1>
                <?php if (get_the_content()) : ?>
                    <div class="text-xl mb-8 text-white/90">
                        <?php the_content(); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="hidden lg:block absolute -right-16 -top-16 w-64 h-64 rounded-full bg-primary-terracotta opacity-20"></div>
    </section>

    <section class="py-10 bg-secondary-sand">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <?php
                get_template_part('template-parts/component', 'gallery', array(
                    'show_all' => true
                ));
                ?>
            </div>
        </div>
    </section>
</main>

<?php
get_footer();
?>