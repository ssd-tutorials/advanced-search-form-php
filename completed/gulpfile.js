var gulp = require('gulp'),
    uglify = require('gulp-uglify'),
    concat = require('gulp-concat'),
    sass = require('gulp-sass'),
    cssMin = require('gulp-css');

gulp.task('sass', function() {

    return gulp.src('./assets/scss/app.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(gulp.dest('./assets/css/src'));

});

gulp.task('css', ['sass'], function() {

    gulp.src([
            './assets/css/src/app.css'
        ])
        .pipe(concat('app.css'))
        .pipe(cssMin())
        .pipe(gulp.dest('./assets/css/dist'));

});

gulp.task('scripts', function() {

    gulp.src([
            './node_modules/jquery/dist/jquery.js',
            './node_modules/ssd-select/src/jquery.ssd-select.js',
            './assets/js/src/app.js'
        ])
        .pipe(concat('app.js'))
        .pipe(uglify())
        .pipe(gulp.dest('./assets/js/dist'));

});

gulp.task('default', ['css', 'scripts']);