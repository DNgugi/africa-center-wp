# Africa Center WordPress Theme

A flexible WordPress theme with a fully customizable front page through the WordPress Customizer.

## Features

- Fully editable front page sections through WordPress Customizer
- Custom Event post type with dedicated archive and single templates
- Responsive design using TailwindCSS
- Gallery support with lightbox functionality
- Enhanced search functionality with filters

## Front Page Customization

The front page is fully customizable through the WordPress Customizer. To edit the front page content:

1. Go to **Appearance > Customize**
2. Navigate to the **Front Page Options** panel
3. You'll find the following sections that can be customized:

### Hero Section

- Heading
- Subheading
- Button Text
- Button URL
- Background Image

### Tagline Section

- Tagline Text

### Featured Programs Section

- Section Badge Text
- Section Heading
- Programs (Each program includes title, description, icon, and link)

### Mission Section

- Section Badge Text
- Section Heading
- Mission Text
- Image
- Button Text
- Button URL

### Values Section

- Section Badge Text
- Section Heading
- Values (Each value includes title and description)

### Gallery Section

- Section Badge Text
- Section Heading
- Section Description
- Gallery Images
- Button Text
- Button URL

### Testimonials Section

- Section Badge Text
- Section Heading
- Background Image
- Testimonials (Each testimonial includes name, title, quote, and image)

### Events Section

- Section Badge Text
- Section Heading
- Button Text
- Button URL

## Events

You can manage events through the Events post type in the WordPress admin. The events will automatically appear on the front page events section and the events archive page.

### Event Shortcode

You can use the shortcode `[events_list]` in any post or page to display the events list. The shortcode accepts the following optional parameters:

- `limit` - Number of events to display (default: -1, shows all events)
- `past` - Whether to show past events (default: false)

Examples:

- `[events_list]` - Shows all upcoming events
- `[events_list limit="5"]` - Shows the next 5 upcoming events
- `[events_list past="true"]` - Shows all events, including past events
- `[events_list limit="10" past="true"]` - Shows the last 10 events, including past events
