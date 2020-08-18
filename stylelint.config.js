module.exports = {
  plugins: ["stylelint-scss"],
  extends: [
    "stylelint-config-idiomatic-order",
    "stylelint-config-standard",
    "stylelint-config-prettier",
  ],
  rules: {
    "at-rule-no-unknown": [
      true,
      {
        ignoreAtRules: [
          "apply",
          "responsive",
          "screen",
          "tailwind",
          "variants",
        ],
      },
    ],
    "comment-empty-line-before": null,
  },
};
