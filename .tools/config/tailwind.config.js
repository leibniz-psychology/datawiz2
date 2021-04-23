const colors = require("tailwindcss/colors");

module.exports = {
  purge: {
    mode: "layers",
    layers: ["components", "utilities"],
    content: ["./source/View/Templates/**/*.html.twig"],
  },
  theme: {
    extend: {
      colors: {
        mono: colors.warmGray,
      },
      screens: {
        xl: "1440px",
      },
    },
  },
  variants: {
    extend: {
      margin: ["first"],
    },
  },
  plugins: [],
};
