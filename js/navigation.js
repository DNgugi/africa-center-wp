/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */
(function () {
  const siteNavigation = document.getElementById("site-navigation");
  const menuToggle = document.querySelector(".menu-toggle");
  const header = document.querySelector(".site-header");
  const isMobile = () => window.innerWidth < 1024; // Match with Tailwind's lg breakpoint

  // Return early if we have no navigation elements at all
  if (!siteNavigation && !menuToggle) {
    console.log("Navigation script: No navigation elements found");
    return;
  }

  const button =
    menuToggle || siteNavigation?.getElementsByTagName("button")[0];

  // Return early if the button doesn't exist.
  if (!button) {
    console.log("Navigation script: No button found");
    console.log("menuToggle:", menuToggle);
    console.log("siteNavigation:", siteNavigation);
    return;
  }

  console.log("Navigation script: Button found:", button);

  const menu =
    document.querySelector(".menu") ||
    siteNavigation?.getElementsByTagName("ul")[0];

  console.log("Navigation script: Menu element found:", menu);

  // Hide menu toggle button if menu is empty and return early.
  if (!menu) {
    console.log("Navigation script: No menu found, hiding toggle button");
    button.style.display = "none";
    return;
  }

  console.log("Navigation script: Setup complete, all elements found");
  if (!menu) {
    button.style.display = "none";
    return;
  }

  if (!menu.classList.contains("nav-menu")) {
    menu.classList.add("nav-menu");
  }

  // Scroll-based header animations
  let lastScrollY = window.scrollY;

  function handleScroll() {
    const currentScrollY = window.scrollY;
    const isAdminBar = document.body.classList.contains("admin-bar");

    if (header) {
      if (currentScrollY > 50) {
        header.classList.add("header-scrolled");

        // Handle WordPress admin bar on small screens
        if (isAdminBar && window.innerWidth <= 600 && currentScrollY > 46) {
          document.body.classList.add("mobile-scrolled");
        }
      } else {
        header.classList.remove("header-scrolled");

        // Remove mobile scrolled class when back at the top
        if (isAdminBar) {
          document.body.classList.remove("mobile-scrolled");
        }
      }
    }

    lastScrollY = currentScrollY;
  }

  // Add scroll listener
  window.addEventListener("scroll", handleScroll, { passive: true });
  handleScroll();

  // Intelligent layout switching for desktop
  function checkNavigationLayout() {
    if (isMobile()) return;

    const headerContainer = document.querySelector(".header-container");
    const siteBranding = document.querySelector(".site-branding");
    const mainNavigation = document.querySelector(".main-navigation");
    const siteHeader = document.querySelector(".site-header");
    const pageElement = document.getElementById("page");

    if (!headerContainer || !siteBranding || !mainNavigation || !siteHeader)
      return;

    const headerWidth = headerContainer.offsetWidth;
    const brandingWidth = siteBranding.offsetWidth;
    const navigationWidth = mainNavigation.offsetWidth;
    const totalNeeded = brandingWidth + navigationWidth + 64;

    if (totalNeeded > headerWidth) {
      if (!headerContainer.classList.contains("two-line-layout")) {
        headerContainer.classList.add("two-line-layout");
        // Use CSS variable instead of direct style manipulation
        document.documentElement.style.setProperty("--header-height", "130px");
        if (pageElement)
          document.documentElement.style.setProperty(
            "--page-padding-top",
            "130px"
          );
      }
    } else {
      if (headerContainer.classList.contains("two-line-layout")) {
        headerContainer.classList.remove("two-line-layout");
        // Use CSS variable instead of direct style manipulation
        document.documentElement.style.setProperty("--header-height", "80px");
        if (pageElement)
          document.documentElement.style.setProperty(
            "--page-padding-top",
            "80px"
          );
      }
    }
  }

  window.addEventListener("resize", checkNavigationLayout);
  setTimeout(checkNavigationLayout, 100);

  // Remove complex layout observer and simplify
  function setupLayoutObserver() {
    // No longer needed with simplified approach
  }

  // Position a submenu based on its parent and viewport
  function positionSubmenu(menuItem, submenu) {
    const submenuRect = submenu.getBoundingClientRect();
    const viewportWidth = window.innerWidth;
    const isNested = menuItem.closest(".sub-menu") !== null;

    // Reset any previous positioning to defaults
    submenu.style.left = "";
    submenu.style.right = "";
    submenu.style.top = "";

    // For nested submenus, ensure they open to the side and not over parent
    if (isNested) {
      const parentMenuItem = menuItem.closest(".menu-item-has-children");
      const parentRect = parentMenuItem.getBoundingClientRect();

      // Check if submenu would go off right edge of viewport
      if (parentRect.right + submenuRect.width > viewportWidth - 20) {
        // Open to the left of the parent
        submenu.style.left = "auto";
        submenu.style.right = "100%";
        submenu.style.marginRight = "5px"; // Small gap between menus
      } else {
        // Default: open to the right of parent with small offset to avoid overlap
        submenu.style.left = "100%";
        submenu.style.marginLeft = "5px"; // Small gap between menus
      }

      // Always position aligned to top of parent item
      submenu.style.top = "0";
    }
    // Top-level submenu positioning (vertical dropdown)
    else {
      if (submenuRect.right > viewportWidth - 20) {
        // Submenu goes off right edge, position to the left
        submenu.style.left = "auto";
        submenu.style.right = "0";
      }
    }
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

        // Make menu appearance nearly immediate
        menuItem.classList.add("hover");
        submenu.classList.add("show");

        // Smart positioning to prevent submenu from going off-screen
        positionSubmenu(menuItem, submenu);

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
        // Add a moderate delay before hiding to allow users to move mouse to submenu
        hideTimeout = setTimeout(() => {
          // Don't hide immediately if the menu has focus
          if (!menuItem.contains(document.activeElement)) {
            menuItem.classList.remove("hover");
            submenu.classList.remove("show");

            // Clean up any orphaned hover states that aren't in the active path
            const allHovered = menuItem.querySelectorAll(".hover");
            allHovered.forEach((el) => {
              el.classList.remove("hover");
              el.querySelector(".sub-menu")?.classList.remove("show");
            });
          }
        }, 150); // 150ms delay - fast enough to feel responsive but still allow movement
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

        // Ensure parent stays in hover state
        menuItem.classList.add("hover");
        submenu.classList.add("show");

        // Make sure submenu is correctly positioned - necessary for dynamic content
        positionSubmenu(menuItem, submenu);

        // Keep parent menus open
        let parent = menuItem.parentElement.closest(".menu-item-has-children");
        while (parent) {
          parent.classList.add("hover");
          parent.querySelector(".sub-menu").classList.add("show");
          parent = parent.parentElement.closest(".menu-item-has-children");
        }
      }
    });

    submenu.addEventListener("mouseleave", () => {
      if (!isMobile()) {
        // Add a minimal delay before hiding to allow for mouse movement between elements
        hideTimeout = setTimeout(() => {
          // Check if the mouse has moved to the parent or another related element
          const relatedTarget = event.relatedTarget;
          if (
            !menuItem.contains(relatedTarget) &&
            !submenu.contains(relatedTarget)
          ) {
            menuItem.classList.remove("hover");
            submenu.classList.remove("show");
          }
        }, 100); // Minimal delay for responsive nested navigation
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
  button.addEventListener("click", function (e) {
    e.preventDefault();
    console.log("Mobile menu button clicked!");

    // For mobile, we need to toggle on the body or a parent container
    const body = document.body;

    body.classList.toggle("mobile-menu-open");
    console.log("Body classes after toggle:", body.className);

    // Toggle icons
    const hamburgerIcon = button.querySelector(".hamburger-icon");
    const closeIcon = button.querySelector(".close-icon");
    console.log("Hamburger icon:", hamburgerIcon);
    console.log("Close icon:", closeIcon);

    if (body.classList.contains("mobile-menu-open")) {
      hamburgerIcon?.classList.add("hidden");
      closeIcon?.classList.remove("hidden");
      button.setAttribute("aria-expanded", "true");
      console.log("Menu opened - switched to close icon");
    } else {
      hamburgerIcon?.classList.remove("hidden");
      closeIcon?.classList.add("hidden");
      button.setAttribute("aria-expanded", "false");
      console.log("Menu closed - switched to hamburger icon");
    }
  });

  // Remove the .toggled class and set aria-expanded to false when the user clicks outside the navigation.
  document.addEventListener("click", function (event) {
    const body = document.body;
    const mobileControls = document.querySelector(".mobile-controls");
    const navContainer = document.querySelector(".nav-menu-container");

    const isClickInsideNav =
      navContainer && navContainer.contains(event.target);
    const isClickInsideMobileControls =
      mobileControls && mobileControls.contains(event.target);
    const isClickInside = isClickInsideNav || isClickInsideMobileControls;

    if (
      !isClickInside &&
      !button.contains(event.target) &&
      body.classList.contains("mobile-menu-open")
    ) {
      body.classList.remove("mobile-menu-open");

      // Reset button icons
      const hamburgerIcon = button.querySelector(".hamburger-icon");
      const closeIcon = button.querySelector(".close-icon");
      if (hamburgerIcon && closeIcon) {
        hamburgerIcon.classList.remove("hidden");
        closeIcon.classList.add("hidden");
      }

      button.setAttribute("aria-expanded", "false");
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

  // Smooth scroll and focus functionality for newsletter signup
  document.addEventListener("DOMContentLoaded", function () {
    // Add smooth scrolling to all anchor links that start with #
    document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
      anchor.addEventListener("click", function (e) {
        const targetId = this.getAttribute("href").substring(1);
        const targetElement = document.getElementById(targetId);

        if (targetElement) {
          e.preventDefault();

          // Smooth scroll to the target element
          targetElement.scrollIntoView({
            behavior: "smooth",
            block: "center",
          });

          // If targeting the newsletter section, focus on the email input after scrolling
          if (targetId === "newsletter") {
            setTimeout(() => {
              const emailInput = document.getElementById("newsletter-email");
              if (emailInput) {
                emailInput.focus();
                // Add a subtle highlight effect
                emailInput.style.transition = "box-shadow 0.3s ease";
                emailInput.style.boxShadow =
                  "0 0 0 3px rgba(251, 191, 36, 0.3)";

                // Remove highlight after a moment
                setTimeout(() => {
                  emailInput.style.boxShadow = "";
                }, 2000);
              }
            }, 500); // Wait for scroll to complete
          }
        }
      });
    });

    // Back to top functionality
    const backToTopButton = document.getElementById("back-to-top");
    if (backToTopButton) {
      backToTopButton.addEventListener("click", function (e) {
        e.preventDefault();

        // Smooth scroll to top
        window.scrollTo({
          top: 0,
          behavior: "smooth",
        });

        // Add a subtle scale effect on click
        this.style.transform = "scale(0.95)";
        setTimeout(() => {
          this.style.transform = "";
        }, 150);
      });
    }
  });
})();
