var Encore = require("@symfony/webpack-encore");

// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.Scripts file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
  Encore.configureRuntimeEnvironment(process.env.NODE_ENV || "dev");
}

Encore
  // directory where compiled Assets will be stored
  .setOutputPath("public/build/")
  // public path used by the web server to access the output path
  .setPublicPath("/build")
  // only needed for CDN's or sub-directory deploy
  //.setManifestKeyPrefix('build/')

  /*
   * ENTRY CONFIG
   *
   * Add 1 entry for each "page" of your app
   * (including one that's included on every page - e.g. "app")
   *
   * Each entry will result in one JavaScript file (e.g. app.Scripts)
   * and one CSS file (e.g. app.Style) if your JavaScript imports CSS.
   */
  .addEntry("app", "./source/View/Assets/Scripts/app.js")
  //.addEntry('page1', './source/View/Assets/Scripts/page1.Scripts')
  //.addEntry('page2', './source/View/Assets/Scripts/page2.Scripts')

  // When enabled, Webpack "splits" your files into smaller pieces for greater optimization.
  .splitEntryChunks()

  // will require an extra script tag for runtime.Scripts
  // but, you probably want this, unless you're building a single-page app
  .enableSingleRuntimeChunk()

  /*
   * FEATURE CONFIG
   *
   * Enable & configure other features below. For a full
   * list of features, see:
   * https://symfony.com/doc/current/frontend.html#adding-more-features
   */
  .cleanupOutputBeforeBuild()
  .enableBuildNotifications()
  // .enableSourceMaps(!Encore.isProduction())
  // enables hashed filenames (e.g. app.abc123.Style)
  .enableVersioning(Encore.isProduction())

  // enables @babel/preset-env polyfills
  .configureBabelPresetEnv((config) => {
    config.useBuiltIns = "usage";
    config.corejs = 3;
  })

  // enables Sass/SCSS support
  .enableSassLoader()
  // .enableSassLoader((options) => {
  //   options.sourceMap = true;
  // }, {})

  // enables PostCSS support
  .enablePostCssLoader((options) => {
    options.postcssOptions = {
      plugins: [
        require("tailwindcss")("./source/View/Assets/tailwind.config.js"),
        require("postcss-preset-env")(),
      ],
    };
    // options.sourceMap = true;
  });

// uncomment if you use TypeScript
//.enableTypeScriptLoader()

// uncomment to get integrity="..." attributes on your script & link tags
// requires WebpackEncoreBundle 1.4 or higher
//.enableIntegrityHashes(Encore.isProduction())

// uncomment if you're having problems with a jQuery plugin
//.autoProvidejQuery()

// uncomment if you use API Platform Admin (composer req api-admin)
//.enableReactPreset()
//.addEntry('admin', './Assets/Scripts/admin.Scripts')
module.exports = Encore.getWebpackConfig();
