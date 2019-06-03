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
  .js('resources/js/bootstrap.js', 'public/js')
  .js('resources/js/chunks/guest.js', 'public/js/chunks')
  .js('resources/js/chunks/auth.js', 'public/js/chunks')
  .js('resources/js/chunks/customer.js', 'public/js/chunks')
  .js('resources/js/chunks/author.js', 'public/js/chunks')
  .sass('resources/sass/app.scss', 'public/css');