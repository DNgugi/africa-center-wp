/**
 * Debug script to diagnose dropdown styling issues
 */

function debugDropdownStyles() {
  console.log("🔧 Debugging dropdown styles...");

  // Check viewport and media query
  const viewportWidth = window.innerWidth;
  console.log(`📏 Viewport width: ${viewportWidth}px`);

  // Check if desktop media query should apply
  const isDesktop = window.matchMedia("(min-width: 1024px)").matches;
  console.log(`💻 Desktop media query matches: ${isDesktop}`);

  // Find all dropdown elements
  const dropdowns = document.querySelectorAll(".sub-menu");
  console.log(`🔍 Found ${dropdowns.length} dropdown elements`);

  dropdowns.forEach((dropdown, index) => {
    console.log(`\n--- Dropdown ${index + 1} ---`);

    // Get parent menu item
    const parentMenuItem = dropdown.closest(".menu-item-has-children");
    console.log(`Parent menu item found: ${!!parentMenuItem}`);

    // Check computed styles
    const computedStyles = window.getComputedStyle(dropdown);
    console.log(`Position: ${computedStyles.position}`);
    console.log(`Display: ${computedStyles.display}`);
    console.log(`Z-index: ${computedStyles.zIndex}`);
    console.log(`Top: ${computedStyles.top}`);
    console.log(`Left: ${computedStyles.left}`);

    // Check if element is visible
    const rect = dropdown.getBoundingClientRect();
    console.log(`Bounding rect:`, rect);

    // Check CSS rules that apply to this element
    const rules = [];
    for (let sheet of document.styleSheets) {
      try {
        for (let rule of sheet.cssRules || sheet.rules) {
          if (rule.selectorText && dropdown.matches(rule.selectorText)) {
            rules.push({
              selector: rule.selectorText,
              styles: rule.style.cssText,
            });
          }
        }
      } catch (e) {
        // Cross-origin stylesheet, skip
      }
    }
    console.log(`Matching CSS rules:`, rules);
  });

  // Check if CSS file is loaded
  const cssLinks = document.querySelectorAll('link[rel="stylesheet"]');
  console.log(`\n📄 CSS files loaded:`);
  cssLinks.forEach((link) => {
    console.log(`- ${link.href}`);
  });

  // Test if we can manually apply styles
  const testDropdown = document.querySelector(".sub-menu");
  if (testDropdown) {
    console.log("\n🧪 Testing manual style application...");
    const originalPosition = testDropdown.style.position;
    testDropdown.style.position = "absolute";
    testDropdown.style.top = "100%";
    testDropdown.style.left = "0";
    testDropdown.style.zIndex = "150";

    const newComputedStyles = window.getComputedStyle(testDropdown);
    console.log(
      `After manual styling - Position: ${newComputedStyles.position}`
    );

    // Restore original
    testDropdown.style.position = originalPosition;
  }
}

// Export for manual testing
window.debugDropdownStyles = debugDropdownStyles;

// Auto-run on load
document.addEventListener("DOMContentLoaded", () => {
  setTimeout(debugDropdownStyles, 1000);
});
