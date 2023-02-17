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

mix.js('resources/js/app.js', 'public/js')
    .vue()
    .sass('resources/sass/app.scss', 'public/css')
    .sourceMaps();

mix.combine([
    'public/css/nucleo-icons.css',
    'public/css/nucleo-svg.css',
], 'public/css/nucleo-icons.css');

mix.combine('public/css/material-dashboard.css', 'public/css/reader/material-dashboard.css');
mix.combine('public/css/vue-multiselect.css', 'public/css/reader/vue-multiselect.css');

mix.combine('public/js/core/bootstrap.min.js', 'public/js/bootstrap.js');
mix.combine('public/js/core/popper.min.js', 'public/js/pooper.js');

mix.combine('public/js/plugins/perfect-scrollbar.min.js', 'public/js/perfect-scrollbar.js');
mix.combine('public/js/plugins/smooth-scrollbar.min.js', 'public/js/smooth-scrollbar.js');
mix.combine('public/js/plugins/chartjs.min.js', 'public/js/chartjs.js');

mix.combine('public/js/material/material-dashboard.js','public/js/material-dashboard.js');
