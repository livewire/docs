const mix = require('laravel-mix');
let tailwindcss = require('tailwindcss');
require('laravel-mix-purgecss');

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

mix.js('resources/assets/js/main.js', 'public/js')
    .sourceMaps()
    .sass('resources/assets/sass/main.scss', 'public/css')
    .options({
        processCssUrls: false,
        postCss: [tailwindcss('./resources/assets/sass/tailwind.config.js')],
    })
    .purgeCss({
        extensions: ['html', 'md', 'js', 'php', 'vue', 'blade'],
        folders: ['source'],
        whitelistPatterns: [/language/, /hljs/, /algolia/, /carbon/],
    })
    .version();
