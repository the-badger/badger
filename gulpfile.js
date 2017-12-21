var gulp = require('gulp');
var less = require('gulp-less');
var path = require('path');
var concat = require('gulp-concat');

// Installation task
gulp.task('install', function() {
    gulp.src([
        './node_modules/autolinker/dist/Autolinker.min.js',
        './node_modules/mustache/mustache.min.js',
        './node_modules/lodash/lodash.min.js',
        './node_modules/selectize/dist/js/standalone/selectize.min.js',
        './node_modules/selectize/dist/css/selectize.css',
        './node_modules/selectize/dist/css/selectize.default.css'
    ]).pipe(gulp.dest('./web/vendor/dist/'));
});

// Compile less
gulp.task('less', function () {
    return gulp.src('./src/**/Resources/public/css/*.less')
        .pipe(less())
        .pipe(concat('badger.css'))
        .pipe(gulp.dest('./web/css'));
});
