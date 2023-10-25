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
    .js('resources/js/logic/users-edit-table.js', 'public/js')//aplicado user-form-show.blade
    .js('resources/js/logic/control-form-dynamic-crud.js', 'public/js')//aplicado a:
    //hour-blocks
    //course
    //user type
    //availability type
    //ufcd
    //specialization area
    //course class
    //pedagogical group
    //hour block course class
    .js('resources/js/logic/update-scheduler-availabilities.js', 'public/js')//aplicado teacher-availabilities
    .js('resources/js/components/build-scheduler.js', 'public/js')//aplicado a:
    //teacher-availabilities  
    .js('resources/js/logic/availabilities-day-group-list.js', 'public/js')//aplicado a:
    //teacher-availabilities  
    .js('resources/js/logic/availabilities-form-dynamic-crud.js', 'public/js')//aplicado a:
    //teacher-availabilities  




