const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */
mix.styles([
    'resources/assets/css/jquery.ui.min.css',
    'resources/assets/css/bootstrap.min.css',
    'resources/assets/css/docs.css',
    'resources/assets/css/chacha.css',
    'resources/assets/css/dashboard.css'
], 'public/css/common.css').version();

mix.styles([
    'resources/assets/css/MAP.css'
], 'public/css/map.css').version();

mix.scripts([
    'resources/assets/js/API.js',
], 'public/js/api.js').version();

mix.scripts([
    'resources/assets/js/MAP.js',
], 'public/js/map.js').version();