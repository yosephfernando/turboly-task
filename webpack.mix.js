let mix = require('laravel-mix');

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

mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css');

mix.scripts([
   'public/js/jquery.min.js',
   'public/js/bootstrap.min.js',
   'public/js/jquery.dataTables.min.js',
   'public/js/dataTables.bootstrap.min.js',
   'public/js/bootstrap-datepicker.js'
], 'public/js/app.js');

mix.styles([
   'public/css/bootstrap-theme.min.css',
   'public/css/bootstrap.min.css',
   'public/css/datepicker.css',
   'public/css/jquery.dataTables.min.css'
], 'public/css/app.css');
