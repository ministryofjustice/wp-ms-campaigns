const mix_ = require('laravel-mix');

var _src = './src/';

mix_.setPublicPath('./dist')
    .js(_src + 'js/main.js', 'js/main.min.js')
    .sass(_src + 'scss/main.scss',  'dist/css/main.min.css')
    .copy(_src + 'img/*', 'dist/img/');

if (mix_.inProduction()) {
    mix_.version();
} else {
    mix_.sourceMaps();
}
