/**
 * Gallery and lightbox initialization script.
 *
 * This file handles the initialization of the GLightbox library
 * for all images across the site and configures special behavior
 * for gallery blocks.
 */
document.addEventListener("DOMContentLoaded", function () {
  // Prepare gallery images to work with GLightbox
  prepareGalleryImages();

  // Initialize lightbox for all content images
  const contentLightbox = GLightbox({
    selector: ".glightbox-link",
    touchNavigation: true,
    loop: true,
    autoplayVideos: true,
    openEffect: "zoom",
    closeEffect: "fade",
    cssEfects: {
      fade: { in: "fadeIn", out: "fadeOut" },
      zoom: { in: "zoomIn", out: "zoomOut" },
    },
    preload: true,
  });

  // Initialize lightbox for gallery blocks
  const galleryLightbox = GLightbox({
    selector: ".gallery-lightbox-item",
    touchNavigation: true,
    loop: true,
    autoplayVideos: true,
    openEffect: "zoom",
    closeEffect: "fade",
    slideshowAuto: false,
    draggable: true,
    zoomable: true,
  });

  // Function to prepare gallery images for lightbox
  function prepareGalleryImages() {
    // Target both native WordPress galleries and our custom slideshow galleries
    const galleryImages = document.querySelectorAll(
      ".wp-block-gallery .wp-block-image img, " +
        ".wp-block-gallery .blocks-gallery-item img, " +
        ".wp-block-gallery.is-style-wpac-slideshow .wp-block-image img, " +
        ".wp-block-gallery.is-style-wpac-slideshow .blocks-gallery-item img"
    );

    galleryImages.forEach(function (img) {
      // Skip if image is already inside a lightbox link
      if (img.parentNode.classList.contains("gallery-lightbox-item")) {
        return;
      }

      // Get the image source (full size if available)
      let imgSrc = img.getAttribute("src");

      // If image is in a link, use that link's href and add lightbox class
      if (img.parentNode.tagName === "A") {
        const parentLink = img.parentNode;
        imgSrc = parentLink.getAttribute("href") || imgSrc;

        // Add lightbox classes and data attributes
        parentLink.classList.add("gallery-lightbox-item");
        parentLink.setAttribute("data-gallery", "gallery");

        // Use alt text as caption if available
        if (img.alt) {
          parentLink.setAttribute("data-caption", img.alt);
        }
      }
      // Otherwise wrap the image in a new link
      else {
        const wrapper = document.createElement("a");
        wrapper.href = imgSrc;
        wrapper.classList.add("gallery-lightbox-item");
        wrapper.setAttribute("data-gallery", "gallery");

        // Use alt text as caption if available
        if (img.alt) {
          wrapper.setAttribute("data-caption", img.alt);
        }

        // Replace image with wrapped version
        img.parentNode.insertBefore(wrapper, img);
        wrapper.appendChild(img);
      }
    });
  }

  // Add lightbox to any image in content that's not already in a gallery
  const contentImages = document.querySelectorAll(
    ".entry-content img:not(.wp-block-gallery img):not(.blocks-gallery-item img)"
  );
  contentImages.forEach(function (image) {
    // Skip images that are already wrapped in links
    if (image.parentNode.tagName === "A") {
      const link = image.parentNode;
      link.classList.add("glightbox-link");
      link.setAttribute("data-gallery", "content-gallery");

      // If the link has no title, use image alt as caption
      if (image.alt && !link.getAttribute("data-caption")) {
        link.setAttribute("data-caption", image.alt);
      }
      return;
    }

    // Create wrapper link for images not already wrapped
    const wrapper = document.createElement("a");
    wrapper.href = image.getAttribute("src");
    wrapper.classList.add("glightbox-link");
    wrapper.setAttribute("data-gallery", "content-gallery");

    // Set caption from alt text if available
    if (image.alt) {
      wrapper.setAttribute("data-caption", image.alt);
    }

    // Replace image with wrapped version
    image.parentNode.insertBefore(wrapper, image);
    wrapper.appendChild(image);
  });

  // Initialize slideshow functionality if present
  const slideshowGalleries = document.querySelectorAll(
    ".is-style-wpac-slideshow"
  );
  if (slideshowGalleries.length) {
    slideshowGalleries.forEach(function (gallery) {
      // Get all slides
      const slides = gallery.querySelectorAll(
        ".wp-block-image, .blocks-gallery-item"
      );
      if (slides.length <= 1) return;

      // Create navigation elements
      const navWrapper = document.createElement("div");
      navWrapper.className = "slideshow-nav";

      const prevButton = document.createElement("button");
      prevButton.innerHTML = "&lsaquo;";
      prevButton.className = "slideshow-prev";
      prevButton.setAttribute("aria-label", "Previous slide");

      const nextButton = document.createElement("button");
      nextButton.innerHTML = "&rsaquo;";
      nextButton.className = "slideshow-next";
      nextButton.setAttribute("aria-label", "Next slide");

      navWrapper.appendChild(prevButton);
      navWrapper.appendChild(nextButton);

      // Create dots container
      const dotsWrapper = document.createElement("div");
      dotsWrapper.className = "slideshow-dots";

      // Add dots for each slide
      slides.forEach(function (_, index) {
        const dot = document.createElement("button");
        dot.setAttribute("aria-label", "Go to slide " + (index + 1));
        dot.dataset.slide = index;
        if (index === 0) dot.classList.add("active");
        dotsWrapper.appendChild(dot);
      });

      // Add navigation and dots to gallery
      gallery.appendChild(navWrapper);
      gallery.appendChild(dotsWrapper);

      // Initialize the first slide
      let currentSlide = 0;

      // Set up autoplay
      let autoplayInterval = null;
      const autoplayDelay = 3000; // 3 seconds between slides (faster)
      const autoplayEnabled = true; // Enable autoplay by default

      // Handle slideshow layout setup
      function ensureSlideshowLayout() {
        // Get the gallery container's width
        const galleryWidth = gallery.clientWidth;

        // Reset any inline styles that might be interfering
        gallery.style.cssText = `
          position: relative;
          width: 100%;
          height: 400px;
          overflow: hidden;
        `;

        // Set up all slides
        slides.forEach(function (slide, index) {
          // Reset any styles that might be causing layout issues
          slide.style.cssText = `
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            transition: opacity 0.5s ease-in-out;
            margin: 0;
            padding: 0;
          `;

          // Hide all slides except the first one
          if (index !== 0) {
            slide.style.display = "none";
            slide.style.opacity = "0";
          } else {
            slide.classList.add("active");
            slide.style.display = "block";
            slide.style.opacity = "1";
          }

          // Set proper image size
          const img = slide.querySelector("img");
          if (img) {
            img.style.cssText = `
              width: 100%;
              height: 100%;
              object-fit: cover;
              display: block;
            `;
          }

          // Make slides clickable to open lightbox
          slide.addEventListener("click", function (event) {
            // Find image link within the slide (should be gallery-lightbox-item)
            const imageLink = slide.querySelector("a.gallery-lightbox-item");

            // Only handle click if it wasn't on a control button
            if (
              imageLink &&
              !event.target.closest(".slideshow-nav") &&
              !event.target.closest(".slideshow-dots")
            ) {
              // Prevent default slideshow click behavior
              event.preventDefault();
              event.stopPropagation();

              // Trigger the lightbox by clicking the link
              imageLink.click();
            }
          });
        });
      }

      // Run the layout setup
      ensureSlideshowLayout();

      // Re-run on window resize for responsive layouts
      window.addEventListener("resize", ensureSlideshowLayout);

      // Show first slide immediately to prevent layout issues
      slides[0].classList.add("active");

      // Function to show a specific slide
      function showSlide(index) {
        // Fade out current slide and fade in next slide
        const currentSlideElement = slides[currentSlide];
        const nextSlideElement = slides[index];

        // Remove active class from current slide
        currentSlideElement.classList.remove("active");

        // Add active class to next slide (which our CSS will display)
        nextSlideElement.classList.add("active");

        // Prepare the next slide for animation
        nextSlideElement.style.display = "block";

        // Short timeout to ensure CSS transition works
        setTimeout(() => {
          // Fade in next slide
          nextSlideElement.style.opacity = "1";

          // Fade out current slide
          currentSlideElement.style.opacity = "0";

          // After animation completes, hide the old slide
          setTimeout(() => {
            // Hide previous slide if it's not the current one
            if (currentSlide !== index) {
              currentSlideElement.style.display = "none";
            }
          }, 500); // Match this to the transition time in CSS
        }, 50);

        // Remove active class from all dots
        dotsWrapper.querySelectorAll("button").forEach(function (dot) {
          dot.classList.remove("active");
        });

        // Add active class to the current dot
        dotsWrapper.querySelectorAll("button")[index].classList.add("active");

        // Update current slide index
        currentSlide = index;

        // Reset autoplay timer when manually changing slides
        if (autoplayEnabled && autoplayInterval) {
          clearInterval(autoplayInterval);
          startAutoplay();
        }
      }

      // Function to start autoplay
      function startAutoplay() {
        if (autoplayEnabled) {
          autoplayInterval = setInterval(function () {
            let index = currentSlide + 1;
            if (index >= slides.length) index = 0;
            showSlide(index);
          }, autoplayDelay);
        }
      }

      // Start autoplay
      startAutoplay();

      // Pause autoplay when hovering over the slideshow
      gallery.addEventListener("mouseenter", function () {
        if (autoplayInterval) {
          clearInterval(autoplayInterval);
        }
      });

      // Resume autoplay when mouse leaves the slideshow
      gallery.addEventListener("mouseleave", function () {
        startAutoplay();
      });

      // Previous button click
      prevButton.addEventListener("click", function (event) {
        event.stopPropagation(); // Prevent triggering slide click event
        let index = currentSlide - 1;
        if (index < 0) index = slides.length - 1;
        showSlide(index);
      });

      // Next button click
      nextButton.addEventListener("click", function (event) {
        event.stopPropagation(); // Prevent triggering slide click event
        let index = currentSlide + 1;
        if (index >= slides.length) index = 0;
        showSlide(index);
      });

      // Dot click
      dotsWrapper.querySelectorAll("button").forEach(function (dot) {
        dot.addEventListener("click", function (event) {
          event.stopPropagation(); // Prevent triggering slide click event
          const index = parseInt(dot.dataset.slide);
          showSlide(index);
        });
      });
    });
  }
});
