/* eslint-disable import/no-extraneous-dependencies, @typescript-eslint/no-var-requires */
const mix = require('laravel-mix');
const Dotenv = require('dotenv-webpack');

const devMode = !mix.inProduction();
const webpack = require('webpack');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
require('laravel-mix-bundle-analyzer');
require('laravel-mix-polyfill');

mix
    .ts('resources/js/main.ts', 'public/js')
    .ts('resources/js/check-support.ts', 'public/js')
    .vue({
        extractStyles: true,
    })
    .extract()
    .sass('resources/sass/nova.scss', 'public/css/nova.css')
    .sass('resources/sass/app.scss', 'public/css')
    .polyfill({
        enabled: true,
        useBuiltIns: 'entry',
        targets: '> 1%, last 5 versions, not dead, not IE 11, Safari > 10',
        corejs: 3,
    })
    .version()
    .copyDirectory('resources/img', 'public/images')
    .browserSync({
        proxy: '0.0.0.0:8080',
        open: false,
    });

mix.webpackConfig({
    plugins: [
        new webpack.DefinePlugin({
            __VUE_OPTIONS_API__: true,
            __VUE_PROD_DEVTOOLS__: false,
        }),
        new Dotenv(),
        new webpack.ContextReplacementPlugin(
            /moment[\\/\\]locale$/,
            /en|ru/,
        ),
        new CleanWebpackPlugin({
            cleanOnceBeforeBuildPatterns: ['css/*', 'js/*'],
        }),
    ],
    output: {
        chunkFilename: 'js/[name].[contenthash].js',
    },
});

if (devMode) {
    mix.sourceMaps(false, 'source-map');
}

if (process.env.SHOW_STAT === 'true') {
    mix.bundleAnalyzer(
        {
            analyzerHost: '0.0.0.0',
            analyzerPort: '3000',
        },
    );
}
