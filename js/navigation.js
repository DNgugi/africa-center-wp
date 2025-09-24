/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */
(function () {
  const siteNavigation = document.getElementById("site-navigation");
  const isMobile = () => window.innerWidth < 1024; // Match with Tailwind's lg breakpoint

  // Return early if the navigation doesn't exist.
  if (!siteNavigation) {
    return;
  }

  const button = siteNavigation.getElementsByTagName("button")[0];

  // Return early if the button doesn't exist.
  if ("undefined" === typeof button) {
    return;
  }

  const menu = siteNavigation.getElementsByTagName("ul")[0];

  // Hide menu toggle button if menu is empty and return early.
  if ("undefined" === typeof menu) {
    button.style.display = "none";
    return;
  }

  if (!menu.classList.contains("nav-menu")) {
    menu.classList.add("nav-menu");
  }

  // Setup dropdown functionality for all levels
  function setupDropdownMenu(menuItem) {
    const link = menuItem.querySelector("a");
    const submenu = menuItem.querySelector(".sub-menu");
    let hideTimeout;

    if (!submenu) return;

    // Handle mouse interactions for desktop
    menuItem.addEventListener("mouseenter", () => {
      if (!isMobile()) {
        // Clear any pending hide timeout
        if (hideTimeout) {
          clearTimeout(hideTimeout);
          hideTimeout = null;
        }

        menuItem.classList.add("hover");
        submenu.classList.add("show");

        // Dynamically adjust submenu position for wrapped menus
        setTimeout(() => {
          const menuItemRect = menuItem.getBoundingClientRect();
          const menuRect = menuItem.closest(".menu").getBoundingClientRect();

          // If menu item is on a lower row (wrapped), adjust submenu position
          if (menuItemRect.top > menuRect.top + 10) {
            // 10px tolerance
            submenu.style.marginTop = "0.5rem"; // Push submenu down a bit more
          } else {
            submenu.style.marginTop = "-0.5rem"; // Default overlap
          }
        }, 10); // Small delay to ensure layout is settled

        // Keep parent menus open when hovering nested items
        let parent = menuItem.parentElement.closest(".menu-item-has-children");
        while (parent) {
          parent.classList.add("hover");
          parent.querySelector(".sub-menu").classList.add("show");
          parent = parent.parentElement.closest(".menu-item-has-children");
        }
      }
    });

    menuItem.addEventListener("mouseleave", () => {
      if (!isMobile()) {
        // Add a delay before hiding to allow users to move mouse to submenu
        hideTimeout = setTimeout(() => {
          menuItem.classList.remove("hover");
          submenu.classList.remove("show");

          // Clean up any orphaned hover states
          const allHovered = menuItem.querySelectorAll(".hover");
          allHovered.forEach((el) => {
            el.classList.remove("hover");
            el.querySelector(".sub-menu")?.classList.remove("show");
          });
        }, 300); // 300ms delay - enough time for mouse movement
      }
    });

    // Also add mouseenter/mouseleave to the submenu itself
    submenu.addEventListener("mouseenter", () => {
      if (!isMobile()) {
        // Clear hide timeout when mouse enters submenu
        if (hideTimeout) {
          clearTimeout(hideTimeout);
          hideTimeout = null;
        }
      }
    });

    submenu.addEventListener("mouseleave", () => {
      if (!isMobile()) {
        // Hide immediately when leaving submenu
        menuItem.classList.remove("hover");
        submenu.classList.remove("show");

        // Clean up any orphaned hover states
        const allHovered = menuItem.querySelectorAll(".hover");
        allHovered.forEach((el) => {
          el.classList.remove("hover");
          el.querySelector(".sub-menu")?.classList.remove("show");
        });
      }
    });

    // Handle click events (especially for mobile)
    link.addEventListener("click", (e) => {
      if (isMobile()) {
        e.preventDefault();

        // If clicking an already active item that has active children,
        // close the children first
        if (menuItem.classList.contains("active")) {
          const activeChildren = menuItem.querySelectorAll(".active");
          activeChildren.forEach((child) => {
            child.classList.remove("active");
            const childSubmenu = child.querySelector(".sub-menu");
            if (childSubmenu) childSubmenu.classList.remove("show");
          });
        }

        // Toggle the clicked item
        menuItem.classList.toggle("active");
        submenu.classList.toggle("show");

        // Close sibling menus
        const siblings = menuItem.parentElement.children;
        Array.from(siblings).forEach((sibling) => {
          if (
            sibling !== menuItem &&
            sibling.classList.contains("menu-item-has-children")
          ) {
            sibling.classList.remove("active");
            const siblingSubmenu = sibling.querySelector(".sub-menu");
            if (siblingSubmenu) {
              siblingSubmenu.classList.remove("show");
              // Also close all nested submenus in siblings
              const nestedActives = siblingSubmenu.querySelectorAll(".active");
              nestedActives.forEach((nested) => {
                nested.classList.remove("active");
                const nestedSubmenu = nested.querySelector(".sub-menu");
                if (nestedSubmenu) nestedSubmenu.classList.remove("show");
              });
            }
          }
        });
      }
    });

    // No need for recursive setup anymore since we're initializing all dropdowns at once
  }

  // Initialize all dropdown menus at all levels
  const allDropdownMenus = siteNavigation.querySelectorAll(
    ".menu-item-has-children"
  );
  allDropdownMenus.forEach(setupDropdownMenu);

  // Toggle the .toggled class and the aria-expanded value each time the button is clicked.
  button.addEventListener("click", function () {
    siteNavigation.classList.toggle("toggled");

    // Toggle icons
    const hamburgerIcon = button.querySelector(".hamburger-icon");
    const closeIcon = button.querySelector(".close-icon");

    if (siteNavigation.classList.contains("toggled")) {
      hamburgerIcon.classList.add("hidden");
      closeIcon.classList.remove("hidden");
    } else {
      hamburgerIcon.classList.remove("hidden");
      closeIcon.classList.add("hidden");
    }

    if (button.getAttribute("aria-expanded") === "true") {
      button.setAttribute("aria-expanded", "false");
    } else {
      button.setAttribute("aria-expanded", "true");
    }
  });

  // Remove the .toggled class and set aria-expanded to false when the user clicks outside the navigation.
  document.addEventListener("click", function (event) {
    const isClickInside = siteNavigation.contains(event.target);

    if (!isClickInside) {
      siteNavigation.classList.remove("toggled");
      button.setAttribute("aria-expanded", "false");

      // Reset icons to hamburger when menu is closed
      const hamburgerIcon = button.querySelector(".hamburger-icon");
      const closeIcon = button.querySelector(".close-icon");

      if (hamburgerIcon && closeIcon) {
        hamburgerIcon.classList.remove("hidden");
        closeIcon.classList.add("hidden");
      }
    }
  });

  // Get all the link elements within the menu.
  const links = menu.getElementsByTagName("a");

  // Get all the link elements with children within the menu.
  const linksWithChildren = menu.querySelectorAll(
    ".menu-item-has-children > a, .page_item_has_children > a"
  );

  // Toggle focus each time a menu link is focused or blurred.
  for (const link of links) {
    link.addEventListener("focus", toggleFocus, true);
    link.addEventListener("blur", toggleFocus, true);
  }

  // Toggle focus each time a menu link with children receive a touch event.
  for (const link of linksWithChildren) {
    link.addEventListener("touchstart", toggleFocus, false);
  }

  /**
   * Sets or removes .focus class on an element.
   */
  function toggleFocus() {
    if (event.type === "focus" || event.type === "blur") {
      let self = this;
      // Move up through the ancestors of the current link until we hit .nav-menu.
      while (!self.classList.contains("nav-menu")) {
        // On li elements toggle the class .focus.
        if ("li" === self.tagName.toLowerCase()) {
          self.classList.toggle("focus");
        }
        self = self.parentNode;
      }
    }

    if (event.type === "touchstart") {
      const menuItem = this.parentNode;
      event.preventDefault();
      for (const link of menuItem.parentNode.children) {
        if (menuItem !== link) {
          link.classList.remove("focus");
        }
      }
      menuItem.classList.toggle("focus");
    }
  }
})();
