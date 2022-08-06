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

 mix.js('resources/assets/js/modulos/principal/app.js', 'public/js/principal.js')
    .js('resources/assets/js/modulos/admin/app.js', 'public/js/admin.js')
    .js('resources/assets/js/modulos/professor/app.js', 'public/js/professor.js')
    .js('resources/assets/js/modulos/aluno/app.js', 'public/js/aluno.js')
    .js('resources/assets/js/modulos/404error/app.js', 'public/js/404error.js')
    .vue()
    .sass('resources/assets/sass/app.scss', 'public/css');
