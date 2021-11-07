const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .scripts([
        'resources/js/pace.min.js',
        'resources/js/toastr.min.js',
        'resources/js/waitMe.min.js',
        'resources/js/sweetalert2.all.min.js',
        'resources/js/bootstrap-table.min.js',
    ], 'public/js/admin_library_bundle.js')
    .styles([
        'resources/css/pace-theme-flash.min.css',
        'resources/css/toastr.min.css',
        'resources/css/waitMe.min.css',
        'resources/css/sweetalert2.min.css',
        'resources/css/bootstrap-table.min.css',
    ], 'public/css/admin_library_bundle.css');
