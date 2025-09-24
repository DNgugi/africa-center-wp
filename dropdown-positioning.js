/**
 * Dropdown positioning script to handle fixed positioning
 */

function positionDropdowns() {
  const menuItems = document.querySelectorAll(".menu-item-has-children");

  menuItems.forEach((menuItem) => {
    const dropdown = menuItem.querySelector(".sub-menu");
    if (!dropdown) return;

    // Position dropdown below the menu item
    const menuItemRect = menuItem.getBoundingClientRect();
    const headerHeight =
      document.querySelector(".site-header")?.offsetHeight || 80;

    // Position dropdown at the bottom of the header, aligned with menu item
    dropdown.style.top = `${headerHeight}px`;
    dropdown.style.left = `${menuItemRect.left}px`;

    // Ensure dropdown doesn't go off-screen
    const dropdownWidth = 300; // max-width from CSS
    const viewportWidth = window.innerWidth;

    if (menuItemRect.left + dropdownWidth > viewportWidth) {
      // Position to the left if it would overflow
      dropdown.style.left = `${viewportWidth - dropdownWidth - 20}px`;
    }

    console.log(
      `Positioned dropdown at top: ${headerHeight}px, left: ${menuItemRect.left}px`
    );
  });
}

// Position dropdowns on load and resize
document.addEventListener("DOMContentLoaded", positionDropdowns);
window.addEventListener("resize", positionDropdowns);

// Re-position when dropdowns are shown/hidden
document.addEventListener(
  "mouseenter",
  function (e) {
    if (e.target.closest(".menu-item-has-children")) {
      setTimeout(positionDropdowns, 10);
    }
  },
  true
);
