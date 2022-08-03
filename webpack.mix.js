const mix = require('laravel-mix')

mix
  .js('resources/assets/pages/index/app.js', 'public/js/index.js')
  .sass('resources/sass/app.scss', 'public/css')
  .version()
  .vue()
  .sourceMaps()
