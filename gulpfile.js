var elixir = require('laravel-elixir'); // Require Elixir

elixir.config.assetsPath = './lib/'; // As we said above, make sure this points to the directory within your theme that stores your assets. Also be sure to include the trailing slash.

var paths = {
    jsPath:   './src/js/',
    scssPath: './src/scss/',
    nodePath: './node_modules/',
    bootstrap: './node_modules/bootstrap/'
};

// Terminal Commands
// To run all tasks one time: gulp
// To have Gulp run when it detects changes in relevant files: gulp watch
// To have Gulp compress/minify your output for production: gulp --production

// Task #1: Using Sass's @import syntax, Elixir will compile your imports into a single file before compress. Don't forget that all paths are relative to your assetsPath configuration above.
elixir(function(mix) {

    mix.sass('./src/scss/styles.scss','./assets/css/');


    // mix.scripts([
    //     paths.bootstrap + '/dist/js/bootstrap.js',
    // ],'./assets/js/bootstrap.min.js')

        // .scripts([
        //     paths.jsPath+'*.js'
        // ],'./assets/js/app.js');


});

elixir(function(mix) {
    mix.webpack(
        paths.jsPath+'*.js',
        './assets/js/app.js'
    );
});