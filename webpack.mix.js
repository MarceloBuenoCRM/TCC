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


mix.js('resources/assets/js/modulos/sistema/app.js', 'public/js/sistema.js')
    .js('resources/assets/js/modulos/principal/app.js', 'public/js/principal.js')
    .js('resources/assets/js/modulos/clinica/app.js', 'public/js/clinica.js')
    .vue()
    .sass('resources/assets/sass/app.scss', 'public/css');
