/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./*.php", // Includes PHP files in the root of your theme
    "./**/*.php", // Includes PHP files in all subdirectories
    "./template-parts/**/*.php", // Specifically targets template parts
    "./*.css",
  ],
  theme: {
    extend: {
      colors: {
        // Primary colors
        "primary-blue": "#1E5091",
        "primary-light-blue": "#3A7CC9",
        "primary-terracotta": "#C75D32",
        "primary-ochre": "#D9A23B",
        "primary-green": "#4D7F41",
        // Secondary colors
        "secondary-sand": "#E6D2B2",
        "secondary-clay": "#9E6B52",
        "secondary-burgundy": "#772F35",
        "secondary-forest": "#2D5C3E",
        "secondary-gold": "#F2C14E",
        // Neutral colors
        "neutral-darkest": "#2C2927",
        "neutral-dark": "#4A4744",
        "neutral-medium": "#7D7770",
        "neutral-light": "#D6D1CA",
        "neutral-lightest": "#F9F6F2",
      },
      fontFamily: {
        heading: ["Montserrat", "sans-serif"],
        body: ["Open Sans", "sans-serif"],
      },
      backgroundImage: {
        "pattern-dots":
          "url(\"data:image/svg+xml,%3Csvg width='20' height='20' viewBox='0 0 20 20' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23D9A23B' fill-opacity='0.2' fill-rule='evenodd'%3E%3Ccircle cx='3' cy='3' r='3'/%3E%3Ccircle cx='13' cy='13' r='3'/%3E%3C/g%3E%3C/svg%3E\")",
        "pattern-lines":
          "url(\"data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23C75D32' fill-opacity='0.1' fill-rule='evenodd'%3E%3Cpath d='M0 40L40 0H20L0 20M40 40V20L20 40'/%3E%3C/g%3E%3C/svg%3E\")",
      },
      typography: {
        DEFAULT: {
          css: {
            maxWidth: "100%",
            color: "#2C2927",
            h1: {
              color: "#1E5091",
              fontFamily: "Montserrat, sans-serif",
            },
            h2: {
              color: "#1E5091",
              fontFamily: "Montserrat, sans-serif",
            },
            h3: {
              color: "#C75D32",
              fontFamily: "Montserrat, sans-serif",
            },
            a: {
              color: "#3A7CC9",
              "&:hover": {
                color: "#1E5091",
              },
            },
          },
        },
      },
    },
  },
  plugins: [require("@tailwindcss/typography")],
};
