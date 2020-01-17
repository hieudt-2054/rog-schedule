const mix = require('laravel-mix');

mix.webpackConfig({
  resolve: {
    extensions: ['.js', '.vue', '.json'],
    alias: {
      '@': path.resolve('resources/js'),
      'scss@': path.resolve('resources/sass'),
      'public' : path.resolve('public'),
    },
  },
  output: { 
    chunkFilename: 'js/chunks/[name].js?id=[chunkhash]',
    publicPath: '/',
  }
})

// mix.copyDirectory('resources/img', 'public/img');

mix.js('resources/js/app.js', 'public/build/js');
mix.copyDirectory('resources/images/', 'public/assets/');
mix.sass('resources/sass/app.scss', 'public/build/css');
mix.styles(['public/build/css/vendor.css', 'public/build/css/app.css'], 'public/css/app.css');
mix.scripts(['public/build/js/app.js', 'public/build/js/vendor.js'], 'public/js/app.js');
mix.version();
