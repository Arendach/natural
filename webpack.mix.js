const mix = require('laravel-mix')

mix
  .js('resources/assets/pages/index/app.js', 'public/js/index.js')
  .js('resources/assets/pages/thank/app.js', 'public/js/thank.js')
  .sass('resources/sass/app.scss', 'public/css')
  .version()
  .vue()
  .sourceMaps()
