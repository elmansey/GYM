const mix = require('laravel-mix');
const path = require('path')


mix.js('resources/js/main.js', 'public/js')
    .vue();

    mix.webpackConfig({
      
        plugins: [],
        resolve: {
          alias: {
            '@' : path.join(__dirname, './resources/js'),
              '~' : path.join(__dirname, './public'),

          },
          modules: [
            'node_modules',
          ],
        },
      });

mix.browserSync(process.env.MIX_RUN_URL);





