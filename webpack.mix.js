const mix = require('laravel-mix');

mix
    .setPublicPath('./')
    .browserSync('localhost');

mix
    .sass('assets/scss/style.scss', 'style.css');

mix
    .js('assets/scripts/script.js', './assets/js');

mix.options({
  processCssUrls: false,
});

mix
    .sourceMaps(false, 'source-map')
    .version();
