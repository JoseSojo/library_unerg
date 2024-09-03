var Encore = require('@symfony/webpack-encore');
const webpack = require('webpack');

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .addEntry('app', './assets/app.js')
    .addEntry('login', './assets/js/login.js')
    .addEntry('js/library', './assets/client/main.js')
    .enableStimulusBridge('./assets/controllers.json')
    .splitEntryChunks()

    // REACT
    .enableReactPreset()
    .enablePostCssLoader({
        postcssOptions: {
            path: require('path').resolve(__dirname, './postcss.config.js'),
          },
    })
    
    .enableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())

    .enableVersioning(Encore.isProduction())

    .enableSassLoader()

    .autoProvidejQuery()

    .configureBabel(null, function (babelConfig) {
        babelConfig.plugins = [
          '@babel/plugin-proposal-object-rest-spread',
          '@babel/plugin-proposal-class-properties',
          '@babel/plugin-transform-runtime',
        ]
    })

    .addPlugin(
        new webpack.ProvidePlugin({
            Popper: ['@popperjs/core', 'default'],
        }))
    .autoProvideVariables({
        $: 'jquery',
        jQuery: 'jquery',
        'window.jQuery': 'jquery',
    })

    .enablePostCssLoader()
;

Encore.enableIntegrityHashes();

Encore.configureTerserPlugin((options) => {
    options.cache = true;
    options.terserOptions = {
        output: {
            comments: false,
        },
        mangle: false,
    }
});

module.exports = Encore.getWebpackConfig();