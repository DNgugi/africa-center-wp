/**
 * Verification script for dropdown containment fix
 * This script tests that dropdowns can extend beyond header boundaries
 */

function verifyDropdownContainment() {
  console.log("🔍 Verifying dropdown containment fix...");

  // Check viewport width
  const viewportWidth = window.innerWidth;
  console.log(`📏 Viewport width: ${viewportWidth}px`);

  if (viewportWidth < 1024) {
    console.warn(
      "⚠️  Viewport width is less than 1024px. Desktop styles may not apply."
    );
    console.log("💡 Try resizing the browser window to at least 1024px width.");
  }

  // Check if required CSS classes exist and have correct properties
  const tests = [
    {
      name: "Header Container Overflow",
      selector: ".header-container",
      expectedStyles: {
        "overflow-x": "hidden",
        "overflow-y": "visible",
      },
    },
    {
      name: "Main Navigation Overflow",
      selector: ".main-navigation",
      expectedStyles: {
        overflow: "visible",
      },
    },
    {
      name: "Nav Menu Container Overflow",
      selector: ".nav-menu-container",
      expectedStyles: {
        overflow: "visible",
      },
    },
    {
      name: "Menu Item Positioning",
      selector: ".menu-item-has-children",
      expectedStyles: {
        position: "relative",
        overflow: "visible",
      },
    },
    {
      name: "Dropdown Positioning",
      selector: ".menu > .menu-item-has-children > .sub-menu",
      expectedStyles: {
        position: "absolute",
      },
    },
  ];

  let passedTests = 0;
  let totalTests = tests.length;

  tests.forEach((test) => {
    const element = document.querySelector(test.selector);

    if (!element) {
      console.warn(`❌ ${test.name}: Element ${test.selector} not found`);
      return;
    }

    const computedStyles = window.getComputedStyle(element);
    let testPassed = true;

    Object.entries(test.expectedStyles).forEach(([property, expectedValue]) => {
      const actualValue = computedStyles.getPropertyValue(property);

      if (actualValue !== expectedValue) {
        console.warn(
          `❌ ${test.name}: ${property} expected "${expectedValue}", got "${actualValue}"`
        );
        testPassed = false;
      }
    });

    if (testPassed) {
      console.log(`✅ ${test.name}: All styles correct`);
      passedTests++;
    }
  });

  // Test dropdown positioning relative to header
  const headerHeight =
    document.querySelector(".site-header")?.offsetHeight || 80;
  const dropdown = document.querySelector(".sub-menu");

  if (dropdown) {
    const dropdownRect = dropdown.getBoundingClientRect();
    const headerRect = document
      .querySelector(".site-header")
      ?.getBoundingClientRect();

    if (headerRect && dropdownRect.top >= headerRect.bottom) {
      console.log("✅ Dropdown Position: Dropdown extends below header");
      passedTests++;
      totalTests++;
    } else {
      console.warn(
        "❌ Dropdown Position: Dropdown may be constrained within header"
      );
    }
  }

  console.log(`\n📊 Test Results: ${passedTests}/${totalTests} tests passed`);

  if (passedTests === totalTests) {
    console.log("🎉 All dropdown containment tests passed!");
    return true;
  } else {
    console.log("⚠️  Some tests failed. Check the warnings above.");
    return false;
  }
}

// Auto-run verification when DOM is loaded
if (document.readyState === "loading") {
  document.addEventListener("DOMContentLoaded", verifyDropdownContainment);
} else {
  verifyDropdownContainment();
}

// Export for manual testing
window.verifyDropdownContainment = verifyDropdownContainment;
