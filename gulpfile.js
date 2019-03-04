const elixir = require('laravel-elixir');
require('laravel-elixir-vue-2');
require('laravel-elixir-webpack-official');

// elixir.config.assetsPath = './src/'; // As we said above, make sure this points to the directory within your theme that stores your assets. Also be sure to include the trailing slash.

elixir((mix) => {
    /**
     *  Building SASS files
     */
    // mix.sass('./src/scss/styles.scss', 'assets/css/styles.css');

    /**
     *  Concatenating font-awesome styles files in vendor.css
     */
    // mix.styles([
    //     './node_modules/font-awesome/css/font-awesome.css'
    // ], 'assets/css/vendor.css');

    /**
     *  Coping fonts of font-awesome for public/build/fonts path
     */
    mix.copy('./node_modules/font-awesome/fonts', 'assets/fonts/font-awesome');


    /**
     *  Building Javascript files
     */
    // mix.webpack('./src/js/main.js', 'assets/js/app.js');

    elixir(function(mix) {
        mix.webpack('./src/js/main.js', 'assets/js/app.js',{
            module: {
                loaders: [
                    { test: /\.css$/, loader: 'style!css' },
                    { test: /\.scss$/, loader: 'style!scss' },
                ],
            },
        });
    });

    /**
     *  Versioning files
     */
    // mix.version([
    //     'assets/css/vendor.css',
    //     'assets/css/app.css',
    //     'assets/js/app.js',
    // ]);

});