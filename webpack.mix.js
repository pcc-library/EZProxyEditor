const mix = require('laravel-mix');

// Compile and bundle JavaScript
mix.js('src/js/app.js', 'assets/js')
    .sass('src/scss/styles.scss', 'assets/css');

// Copy Font Awesome fonts
mix.copy('node_modules/font-awesome/fonts', 'assets/fonts');

// Enable versioning in production
if (mix.inProduction()) {
    mix.version();
}

// Set the public path to 'assets'
mix.setPublicPath('assets');
