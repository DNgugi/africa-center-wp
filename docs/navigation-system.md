# WordPress Theme Navigation System Documentation

This document explains the implementation of our responsive, multi-level navigation system that works seamlessly on both mobile and desktop devices.

## Core Features

- Responsive design (mobile-first approach)
- Multi-level dropdown support
- Hover navigation on desktop
- Touch/click navigation on mobile
- Fixed header with always-visible branding and menu toggle
- Overflow protection for edge-case menus
- Smooth transitions and animations
- Keyboard accessibility support

## Structure

### HTML Structure

```html
<header class="site-header">
  <div class="site-branding">
    <!-- Logo/Site Title -->
  </div>
  <nav id="site-navigation" class="main-navigation">
    <button class="menu-toggle">
      <!-- Mobile Menu Toggle -->
    </button>
    <ul class="menu">
      <li class="menu-item">
        <a href="#">Simple Link</a>
      </li>
      <li class="menu-item-has-children">
        <a href="#">Dropdown Parent</a>
        <ul class="sub-menu">
          <li class="menu-item">
            <a href="#">Submenu Item</a>
          </li>
          <li class="menu-item-has-children">
            <a href="#">Nested Dropdown</a>
            <ul class="sub-menu">
              <!-- Additional levels -->
            </ul>
          </li>
        </ul>
      </li>
    </ul>
  </nav>
</header>
```

## Mobile Navigation

### Key Features

1. Fixed header with logo and toggle
2. Full-screen overlay menu
3. Click-to-expand dropdowns
4. Smooth transitions
5. Nested menu support

### Implementation Details

#### Header Behavior

- Header stays fixed at the top
- Logo and menu toggle remain visible
- Content scrolls underneath

```css
.site-header {
  @apply p-4 flex justify-between bg-white md:relative fixed top-0 left-0 right-0 z-[100];
}

.site-branding {
  @apply flex items-center md:static fixed top-4 left-4 z-[101];
}

.menu-toggle {
  @apply md:hidden fixed top-4 right-4 z-[101] bg-transparent;
}
```

#### Mobile Menu

- Appears as full-screen overlay
- Animated with opacity transition
- Scrollable when content exceeds viewport
- Starts below fixed header

```css
@media (max-width: 767px) {
  .menu {
    @apply fixed top-0 left-0 right-0 bottom-0 bg-white pt-16 px-4 
           overflow-y-auto opacity-0 pointer-events-none transition-all duration-200 z-[95];
  }

  .toggled .menu {
    @apply opacity-100 pointer-events-auto;
  }
}
```

## Desktop Navigation

### Key Features

1. Horizontal menu layout
2. Hover-activated dropdowns
3. Multi-level support
4. Overflow protection
5. Hover bridges for easy navigation

### Implementation Details

#### Main Menu

- Horizontal layout
- Dropdown indicators
- Hover activation

```css
@media (min-width: 768px) {
  .menu {
    @apply list-none md:p-2 md:flex md:space-x-2;
  }

  .menu-item-has-children > a::after {
    content: "⌄";
    @apply ml-1 inline-block transition-transform duration-300;
  }
}
```

#### Submenus

- Positioned absolutely
- Different z-index levels for proper stacking
- Right-aligned for last items to prevent overflow

```css
.sub-menu {
  @apply absolute left-0 top-full hidden min-w-[200px] bg-white shadow-lg rounded-md p-2 pt-3;
}

/* Handle last items differently */
.menu > .menu-item-has-children:nth-last-child(-n + 2) > .sub-menu {
  @apply right-0 left-auto;
}
```

## JavaScript Functionality

The JavaScript handles:

1. Mobile menu toggle
2. Click events for mobile dropdowns
3. Hover events for desktop dropdowns
4. Keyboard navigation
5. Outside click detection
6. Device-specific behavior switching

Key functions:

```javascript
// Setup dropdown functionality
function setupDropdownMenu(menuItem) {
  // Handle mouse interactions for desktop
  menuItem.addEventListener("mouseenter", () => {
    if (!isMobile()) {
      // Show dropdown
    }
  });

  // Handle click events for mobile
  link.addEventListener("click", (e) => {
    if (isMobile()) {
      // Toggle dropdown
    }
  });
}
```

## Accessibility Features

1. ARIA attributes for menu state
2. Keyboard navigation support
3. Focus management
4. Screen reader compatibility
5. Touch target sizing

## Browser Support

The navigation system uses modern CSS features including:

- Flexbox for layout
- CSS Grid for some positioning
- CSS Custom Properties
- Transform for animations

Supported in all modern browsers:

- Chrome/Edge (latest)
- Firefox (latest)
- Safari (latest)
- Mobile browsers

## Best Practices for Development

1. Always maintain the HTML structure
2. Use the provided classes
3. Test on both mobile and desktop
4. Verify keyboard navigation
5. Check overflow scenarios
6. Test with screen readers

## Common Customization Points

1. Colors and Typography

```css
.menu-item a {
  /* Customize link styles */
}

.sub-menu {
  /* Customize dropdown background/shadows */
}
```

2. Spacing and Sizing

```css
.menu {
  /* Adjust menu item spacing */
}

.sub-menu {
  /* Adjust dropdown width/padding */
}
```

3. Animations

```css
.sub-menu {
  /* Customize transition timing/effects */
  transition: opacity 200ms ease;
}
```

## Troubleshooting

Common issues and solutions:

1. Mobile menu not showing
   - Check z-index values
   - Verify toggle button functionality

2. Dropdowns not working
   - Check JavaScript initialization
   - Verify class names

3. Overflow issues
   - Check viewport boundaries
   - Verify right-aligned dropdowns

4. Animation glitches
   - Review transition properties
   - Check transform origins

## Performance Considerations

1. Uses CSS transforms for smooth animations
2. Minimal JavaScript overhead
3. No dependencies required
4. Efficient event delegation
5. Smart event throttling
