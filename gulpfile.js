// grab our gulp packages
var gulp  = require('gulp'),
    gutil = require('gulp-util'),
    jshint = require('gulp-jshint'),
    uglify = require('gulp-uglify'),
    sass = require('gulp-sass');

var paths = {
    scripts: {
        src:  'src/coffee/**/*.coffee',
        dest: 'public/javascripts'
    },
    styles: {
        src:  'httpdocs/assets/scss/*.scss',
        dest: 'httpdocs/assets/css'
    }
};
// create a default task and just log a message

gulp.task('default', ['watch']);

// configure the jshint task
gulp.task('jshint', function() {
  return gulp.src(['httpdocs/assets/js/app.js', 'httpdocs/assets/js/ads.js'])
    .pipe(jshint())
    .pipe(jshint.reporter('jshint-stylish'));
});

gulp.task('compress', function() {
  return gulp.src('httpdocs/assets/js/app.js')
    .pipe(uglify())
    .pipe(gulp.dest('httpdocs/assets/js/min/'));
});

 gulp.task('sass', function () {
   return gulp.src(paths.styles.src)
        .pipe(sass({errLogToConsole: true}))
        .pipe(gulp.dest(paths.styles.dest));
});

// configure which files to watch and what tasks to use on file changes
gulp.task('watch', function() {
  gulp.watch(['httpdocs/assets/js/app.js', 'httpdocs/assets/js/ads.js'], ['jshint']);
});