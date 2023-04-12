const mix = require('laravel-mix');

mix.js('resources/js/dev_.js', 'assets/resources/js')
   .sass('resources/sass/app_.scss', 'assets/resources/css');