var gulp = require('gulp');
var concat = require('gulp-concat');
var sass = require('gulp-sass');
var cleanCSS = require('gulp-clean-css');
var uglify = require('gulp-uglify');
var jshint = require('gulp-jshint');
var imagemin = require('gulp-imagemin');
var browserSync = require('browser-sync').create();

var paths = {
  scripts: ['./wp-content/themes/fisherman2/js'],
  scss: './wp-content/themes/fisherman2/scss',
  css: './wp-content/themes/fisherman2/css',
  images:'./wp-content/themes/fisherman2/images',
  theme: './wp-content/themes/fisherman2',
  dist: './wp-content/themes/fisherman2/dist'
};

gulp.task('js', function () {
  gulp.src(paths.scripts + '/*.js')
  .pipe(jshint())
  .pipe(jshint.reporter('fail'));
});

gulp.task('uglify-scripts', function() {
  return gulp.src(paths.scripts + '/*.js')
  .pipe(uglify())
  .pipe(concat('all.min.js'))
  .pipe(gulp.dest(paths.dist));
});

gulp.task('img', function() {
  gulp.src(paths.images + '/*.{png,jpg,gif}')
  .pipe(imagemin({
    optimizationLevel: 7,
    progressive: true
  }))
  .pipe(gulp.dest(paths.dist + '/images'));
});

gulp.task('browser-sync', function() {
  // https://browsersync.io/docs/gulp/
  browserSync.init({
    proxy: "thefishermanofchrist.localhost"
  });
  gulp.watch(paths.theme + '/**/*.{php,js}').on('change', browserSync.reload);
});

gulp.task('minify-css', function() {
  gulp.src(paths.css + '/*.css')
  .pipe(cleanCSS())
  .pipe(concat('all.min.css'))
  .pipe(gulp.dest(paths.dist));
});

// gulp
gulp.task('default', ['browser-sync']);
// gulp dist
gulp.task('dist', ['minify-css','uglify-scripts']);
