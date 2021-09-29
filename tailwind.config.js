const colors = require("tailwindcss/colors");

module.exports = {
  mode: "jit",
  purge: {
    mode: "layers",
    layers: ["components", "utilities"],
    content: [
      "./source/View/Templates/**/*.html.twig",
      "./source/Questionnaire/Forms/**/*.php",
      "./source/View/Assets/Scripts/**/*.js",
    ],
  },
  theme: {
    extend: {
      colors: {
        mono: colors.warmGray,
        sky: colors.sky,
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
