<?php

/**
 * FAQ Component Template
 *
 * @package headless
 */

if (!isset($settings)) {
    return;
}

$defaults = array(
    'title' => '',
    'description' => '',
    'categories' => array(),
    'faqs' => array(),
    'layout' => 'accordion', // accordion, tabs
    'columns' => 1, // 1 or 2
    'show_search' => false,
    'background_color' => 'white' // white, light, dark
);

$settings = wp_parse_args($settings, $defaults);

$background_classes = array(
    'white' => 'bg-white',
    'light' => 'bg-gray-50',
    'dark' => 'bg-gray-900 text-white'
);

$bg_class = isset($background_classes[$settings['background_color']]) ? $background_classes[$settings['background_color']] : $background_classes['white'];

$columns_class = $settings['columns'] === 2 ? 'md:grid-cols-2 gap-8' : 'grid-cols-1';
$has_categories = !empty($settings['categories']);

// Group FAQs by category if categories exist
$grouped_faqs = array();
if ($has_categories) {
    foreach ($settings['faqs'] as $faq) {
        $category = $faq['category'] ?? 'Uncategorized';
        if (!isset($grouped_faqs[$category])) {
            $grouped_faqs[$category] = array();
        }
        $grouped_faqs[$category][] = $faq;
    }
} else {
    $grouped_faqs['all'] = $settings['faqs'];
}
?>

<div class="faq-component <?php echo esc_attr($bg_class); ?> py-16" x-data="{ 
    activeTab: '<?php echo esc_attr(array_key_first($grouped_faqs)); ?>', 
    searchQuery: '', 
    activeAccordion: null,
    filterFaqs(faqs) {
        if (!this.searchQuery) return true;
        const query = this.searchQuery.toLowerCase();
        return faqs.some(faq => 
            faq.question.toLowerCase().includes(query) || 
            faq.answer.toLowerCase().includes(query)
        );
    }
}">
    <div class="container mx-auto px-4">
        <?php if (!empty($settings['title']) || !empty($settings['description'])) : ?>
            <div class="text-center mb-12">
                <?php if (!empty($settings['title'])) : ?>
                    <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold mb-4">
                        <?php echo esc_html($settings['title']); ?>
                    </h2>
                <?php endif; ?>

                <?php if (!empty($settings['description'])) : ?>
                    <div class="text-lg max-w-3xl mx-auto">
                        <?php echo wp_kses_post($settings['description']); ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ($settings['show_search']) : ?>
            <div class="max-w-2xl mx-auto mb-8">
                <div class="relative">
                    <input
                        type="text"
                        x-model="searchQuery"
                        placeholder="Search FAQs..."
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                    <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($settings['layout'] === 'tabs' && $has_categories) : ?>
            <div class="mb-8">
                <div class="border-b border-gray-200">
                    <nav class="-mb-px flex flex-wrap gap-4" aria-label="Tabs">
                        <?php foreach ($grouped_faqs as $category => $faqs) : ?>
                            <button
                                class="px-4 py-2 font-medium text-sm rounded-t-lg"
                                :class="activeTab === '<?php echo esc_attr($category); ?>' ? 
                                    'border-b-2 border-primary-500 text-primary-500' : 
                                    'text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                @click="activeTab = '<?php echo esc_attr($category); ?>'"
                                x-show="filterFaqs(<?php echo htmlspecialchars(json_encode($faqs), ENT_QUOTES, 'UTF-8'); ?>)">
                                <?php echo esc_html($category); ?>
                            </button>
                        <?php endforeach; ?>
                    </nav>
                </div>
            </div>
        <?php endif; ?>

        <div class="grid <?php echo esc_attr($columns_class); ?>">
            <?php foreach ($grouped_faqs as $category => $faqs) : ?>
                <div x-show="<?php echo $settings['layout'] === 'tabs' ? "activeTab === '" . esc_attr($category) . "'" : 'true'; ?> && filterFaqs(<?php echo htmlspecialchars(json_encode($faqs), ENT_QUOTES, 'UTF-8'); ?>)">
                    <?php if ($settings['layout'] === 'accordion') : ?>
                        <?php foreach ($faqs as $index => $faq) : ?>
                            <div class="border-b border-gray-200 last:border-b-0">
                                <button
                                    class="w-full text-left py-4 flex justify-between items-center focus:outline-none"
                                    @click="activeAccordion === <?php echo esc_attr($index); ?> ? activeAccordion = null : activeAccordion = <?php echo esc_attr($index); ?>">
                                    <span class="font-medium text-lg pr-8"><?php echo esc_html($faq['question']); ?></span>
                                    <svg
                                        class="h-6 w-6 transform transition-transform duration-200"
                                        :class="activeAccordion === <?php echo esc_attr($index); ?> ? 'rotate-180' : ''"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                                <div
                                    class="pb-4"
                                    x-show="activeAccordion === <?php echo esc_attr($index); ?>"
                                    x-cloak
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 transform -translate-y-2"
                                    x-transition:enter-end="opacity-100 transform translate-y-0"
                                    x-transition:leave="transition ease-in duration-200"
                                    x-transition:leave-start="opacity-100 transform translate-y-0"
                                    x-transition:leave-end="opacity-0 transform -translate-y-2">
                                    <div class="prose max-w-none">
                                        <?php echo wp_kses_post($faq['answer']); ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <div class="space-y-6">
                            <?php foreach ($faqs as $faq) : ?>
                                <div class="bg-white rounded-lg shadow-sm p-6">
                                    <h3 class="text-lg font-medium mb-2"><?php echo esc_html($faq['question']); ?></h3>
                                    <div class="prose">
                                        <?php echo wp_kses_post($faq['answer']); ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<style>
    [x-cloak] {
        display: none !important;
    }
</style>