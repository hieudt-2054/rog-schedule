const mix = require('laravel-mix');

mix.webpackConfig({
  resolve: {
    extensions: ['.js', '.vue', '.json'],
    alias: {
      '@': path.resolve('resources/assets/js'),
      'scss@': path.resolve('resources/assets/sass'),
      'public' : path.resolve('public'),
    },
  },
})

mix.copyDirectory('resources/assets/img', 'public/img');

mix.js('resources/js/app.js', 'public/build/js');

mix.sass('resources/assets/sass/app.scss', 'public/build/css');
mix.styles(['public/build/css/vendor.css', 'public/build/css/app.css'], 'public/css/app.css');
mix.scripts(['public/build/js/app.js', 'public/build/js/vendor.js'], 'public/js/app.js');
mix.version();
