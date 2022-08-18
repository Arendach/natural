const mix = require('laravel-mix')
const path = require("path")

mix

  .alias({
    '@': path.join(__dirname, 'resources/assets')
  })

  .webpackConfig({
    stats: {
      children: true,
    }
  })

  .js('resources/assets/pages/index/app.js', 'public/js/index.js')
  .js('resources/assets/pages/category/app.js', 'public/js/category.js')
  .js('resources/assets/pages/product/app.js', 'public/js/product.js')
  .js('resources/assets/pages/thank/app.js', 'public/js/thank.js')
  .sass('resources/sass/app.scss', 'public/css')
  .version()
  .vue()
  .sourceMaps()
