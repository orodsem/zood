const mix = require('laravel-mix');

// mix.js('resources/js/app.js', 'web/js')
//     .sass('resources/sass/app.scss', 'web/css');

mix.js('web/js/app.js', 'web/js/app.min.js');
