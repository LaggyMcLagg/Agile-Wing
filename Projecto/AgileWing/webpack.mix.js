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
    .sass('resources/sass/app.scss', 'public/css')
    .js('resources/js/logic/search-table-function.js', 'public/js')//aplicado à tabel de Users
    .js('resources/js/logic/sort-table-function.js', 'public/js')//aplicado à tabel de Users
    .js('resources/js/logic/double-click-table-function.js', 'public/js')//aplicado à tabel de Users
    .js('resources/js/logic/course_class_table.js', 'public/js')
    //aplicado a:
    //- hour-blocks
    .js('resources/js/logic/control-form-dynamic-crud.js', 'public/js')
