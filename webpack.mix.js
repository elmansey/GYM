const mix = require('laravel-mix');
const path = require('path')


mix.js('resources/js/main.js', 'public/js')
    .vue();

    mix.webpackConfig({
        plugins: [],
        resolve: {
          alias: {
            '@' : path.join(__dirname, './resources/js'),
          },
          modules: [
            'node_modules',
          ],
        },
      });

mix.browserSync('http://127.0.0.1:8000');





