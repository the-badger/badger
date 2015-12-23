var gulp = require('gulp');

// Installation task
gulp.task('install', function(){
    gulp.src([
        './node_modules/requirejs/require.js',
        './node_modules/jquery/dist/jquery.js',
        './node_modules/bootstrap/dist/css/bootstrap.min.css',
        './node_modules/bootstrap/dist/js/bootstrap.min.js'
    ]).pipe(gulp.dest('./web/vendor/dist/'));
});
