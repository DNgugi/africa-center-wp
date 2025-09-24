# Design Document

## Overview

The desktop dropdown menu overflow issue is caused by CSS containment and positioning constraints that prevent dropdown menus from extending outside the header boundaries. While the header has `overflow-y: visible`, the dropdown menus are still being constrained by parent container properties and z-index stacking contexts.

The solution involves modifying the CSS to ensure dropdown menus can properly escape their container boundaries and render outside the header, similar to how the mobile implementation works correctly.

## Architecture

### Current Implementation Analysis

**Header Structure:**

```
.site-header (fixed, z-[100], height: 80px)
  └── .header-container (flex, overflow-x: hidden, overflow-y: visible)
      └── .header-controls
          └── .main-navigation (flex, items-center)
              └── .nav-menu-container (flex, items-center)
                  └── .menu (flex, items-center)
                      └── .menu-item-has-children (relative)
                          └── .sub-menu (absolute, top-full, z-[150])
```

**Root Cause Identified:**

1. The `.header-container` has `overflow-x: hidden` which may be creating a new stacking context
2. The `.main-navigation` and `.nav-menu-container` containers may be constraining the dropdown positioning
3. The dropdown positioning relies on `position: absolute` with `top: full` but may be getting clipped

### Proposed Solution Architecture

**CSS Containment Strategy:**

1. Ensure dropdown menus can escape header boundaries by using `position: fixed` for dropdowns
2. Calculate dropdown position relative to viewport instead of parent container
3. Maintain existing z-index hierarchy but ensure proper stacking context
4. Preserve all existing functionality and styling

## Components and Interfaces

### Component 1: Header Container Overflow Management

**Purpose:** Ensure header container doesn't clip dropdown menus

**Implementation:**

- Modify `.header-container` overflow properties
- Ensure no new stacking contexts are created that would contain dropdowns
- Maintain horizontal overflow prevention while allowing vertical overflow

**CSS Changes:**

```css
.header-container {
  /* Existing styles preserved */
  overflow-x: hidden; /* Keep horizontal constraint */
  overflow-y: visible; /* Ensure vertical overflow is truly visible */
  /* Remove any properties that create new stacking contexts */
}
```

### Component 2: Navigation Container Positioning

**Purpose:** Ensure navigation containers don't constrain dropdown positioning

**Implementation:**

- Review `.main-navigation` and `.nav-menu-container` for containment issues
- Ensure these containers allow child elements to escape boundaries
- Maintain existing layout while removing positioning constraints

**CSS Changes:**

```css
.main-navigation {
  /* Existing styles preserved */
  /* Ensure no overflow constraints */
  overflow: visible;
}

.nav-menu-container {
  /* Existing styles preserved */
  /* Ensure no overflow constraints */
  overflow: visible;
}
```

### Component 3: Dropdown Menu Positioning Strategy

**Purpose:** Enable dropdowns to render outside header boundaries

**Implementation:**

- Modify dropdown positioning from `position: absolute` to use viewport-relative positioning
- Calculate dropdown position using JavaScript to ensure proper placement
- Maintain existing smart positioning logic for viewport edge detection

**CSS Changes:**

```css
@media (min-width: 1024px) {
  .sub-menu {
    /* Change from absolute to fixed positioning */
    position: fixed;
    /* Remove top-full positioning - will be calculated via JS */
    top: auto;
    left: auto;
    /* Maintain existing styling */
    min-width: 200px;
    background: white;
    shadow: lg;
    border-radius: 0.375rem;
    padding: 0.5rem;
    z-index: 150;
    /* Ensure dropdown can extend beyond header */
    max-height: calc(
      100vh - 100px
    ); /* Prevent dropdown from going off-screen */
    overflow-y: auto; /* Add scroll if content is too long */
  }
}
```

### Component 4: JavaScript Positioning Logic

**Purpose:** Calculate proper dropdown positions relative to viewport

**Implementation:**

- Add JavaScript function to calculate dropdown position
- Position dropdowns below the header boundary
- Maintain existing smart positioning for viewport edges
- Integrate with existing hover/show logic

**JavaScript Addition:**

```javascript
function positionDropdown(menuItem, submenu) {
  const menuItemRect = menuItem.getBoundingClientRect();
  const headerHeight = document.querySelector(".site-header").offsetHeight;

  // Position dropdown below header
  submenu.style.top = `${headerHeight}px`;
  submenu.style.left = `${menuItemRect.left}px`;

  // Existing smart positioning logic for viewport edges
  // (preserve existing logic from navigation.js)
}
```

## Data Models

### Dropdown State Model

**Properties:**

- `isVisible`: Boolean indicating if dropdown is currently shown
- `position`: Object containing calculated x, y coordinates
- `parentMenuItem`: Reference to the menu item that triggered the dropdown
- `level`: Number indicating nesting level (1, 2, 3, etc.)

**Methods:**

- `calculatePosition()`: Determines optimal dropdown position
- `show()`: Makes dropdown visible with proper positioning
- `hide()`: Hides dropdown and cleans up positioning
- `updatePosition()`: Recalculates position on window resize

## Error Handling

### Positioning Fallbacks

**Scenario:** Dropdown position calculation fails
**Handling:** Fall back to original absolute positioning as backup

**Implementation:**

```javascript
try {
  positionDropdown(menuItem, submenu);
} catch (error) {
  console.warn("Dropdown positioning failed, using fallback:", error);
  // Revert to absolute positioning
  submenu.style.position = "absolute";
  submenu.style.top = "100%";
  submenu.style.left = "0";
}
```

### Viewport Boundary Detection

**Scenario:** Dropdown would extend beyond viewport boundaries
**Handling:** Adjust position to keep dropdown visible

**Implementation:**

- Check if dropdown would extend beyond right edge → position to the left
- Check if dropdown would extend beyond bottom edge → position above menu item
- Maintain existing smart positioning logic from current implementation

### Z-Index Conflicts

**Scenario:** Other page elements interfere with dropdown visibility
**Handling:** Ensure dropdown z-index is higher than all page content

**Implementation:**

- Use z-index values higher than typical page content (z-[150]+)
- Create isolated stacking context for dropdowns
- Monitor for conflicts with other fixed/absolute positioned elements

## Testing Strategy

### Unit Tests

**CSS Containment Tests:**

- Verify header container doesn't clip dropdowns
- Test overflow properties work correctly
- Validate z-index stacking order

**JavaScript Positioning Tests:**

- Test dropdown position calculation accuracy
- Verify viewport boundary detection
- Test fallback positioning mechanisms

### Integration Tests

**Cross-Browser Compatibility:**

- Test in Chrome, Firefox, Safari, Edge
- Verify consistent behavior across browsers
- Test on different screen sizes and resolutions

**Responsive Behavior:**

- Ensure mobile/tablet behavior remains unchanged
- Test desktop dropdown behavior at various screen widths
- Verify two-line layout compatibility

### User Experience Tests

**Interaction Testing:**

- Test hover behavior for dropdown activation
- Verify keyboard navigation still works
- Test nested dropdown functionality
- Ensure smooth animations and transitions

**Visual Regression Testing:**

- Compare dropdown appearance before and after fix
- Verify no styling changes to dropdown content
- Test dropdown positioning accuracy

### Performance Tests

**Rendering Performance:**

- Measure dropdown show/hide animation performance
- Test scroll performance with dropdowns open
- Verify no layout thrashing during position calculations

**Memory Usage:**

- Monitor for memory leaks in dropdown positioning logic
- Test cleanup when dropdowns are hidden
- Verify event listener management

## Implementation Phases

### Phase 1: CSS Containment Fix

- Modify header container overflow properties
- Update navigation container constraints
- Test basic dropdown visibility

### Phase 2: Positioning Strategy

- Implement fixed positioning for dropdowns
- Add JavaScript position calculation
- Test dropdown placement accuracy

### Phase 3: Smart Positioning Integration

- Integrate with existing viewport edge detection
- Maintain existing hover/interaction logic
- Test nested dropdown functionality

### Phase 4: Testing and Refinement

- Cross-browser testing
- Performance optimization
- Visual regression testing
- User experience validation

## Compatibility Considerations

### Browser Support

- Modern browsers with CSS Grid and Flexbox support
- JavaScript ES6+ features for positioning calculations
- CSS custom properties for dynamic positioning

### WordPress Integration

- Maintain compatibility with WordPress menu system
- Preserve existing theme customization options
- Ensure no conflicts with WordPress admin bar

### Theme Compatibility

- Preserve existing header styling and animations
- Maintain two-line layout functionality
- Keep mobile/tablet behavior unchanged
- Ensure search icon positioning remains correct
