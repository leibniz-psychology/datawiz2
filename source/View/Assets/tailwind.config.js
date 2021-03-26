module.exports = {
  purge: {
    mode: "layers",
    layers: ["components", "utilities"],
    content: ["./source/View/Templates/**/*.html.twig"],
  },
  theme: {
    extend: {},
  },
  variants: {
    extend: {
      margin: ["first"],
    },
  },
  plugins: [],
};
