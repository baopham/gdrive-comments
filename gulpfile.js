var elixir = require('laravel-elixir'),
    gulp = require('gulp');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.sass('app.scss')
});

elixir(function(mix) {
    mix.scripts(['laravel.js', 'app.js'], 'public/js/main.js');
});

gulp.task('copyFonts', function () {
    gulp.src('node_modules/bootstrap-sass/assets/fonts/*/*.*')
        .pipe(gulp.dest('public/fonts'));
});

