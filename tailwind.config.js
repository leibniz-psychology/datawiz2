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
    fontFamily: {
      sans: ["Open Sans", ...defaultTheme.fontFamily.sans],
      condensed: ["Open Sans Condensed", ...defaultTheme.fontFamily.sans],
      serif: ["Zilla Slab", ...defaultTheme.fontFamily.serif],
      mono: defaultTheme.fontFamily.mono,
    },
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
