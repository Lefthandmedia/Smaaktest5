/**
 * @author Lefthandmedia <ralph@lefthandmedia.com>
 */

var gulp = require('gulp'),
	sass = require('gulp-ruby-sass'),
	autoprefixer = require('gulp-autoprefixer'),
	minifycss = require('gulp-minify-css'),
	jshint = require('gulp-jshint'),
	uglify = require('gulp-uglify'),
	imagemin = require('gulp-imagemin'),
	rename = require('gulp-rename'),
	clean = require('gulp-clean'),
	concat = require('gulp-concat'),
	notify = require('gulp-notify'),
	cache = require('gulp-cache'),
	livereload = require('gulp-livereload'),
	bowerpath = 'bower_components/',
	jsdest = '_js',
	cssdest = '_css';

gulp.task('styles', function() {
	return gulp.src('src/styles/*.scss')
		.pipe(sass({ style: 'expanded' , sourcemap: true}))
		.pipe(autoprefixer('last 2 version', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'))
		//.pipe(gulp.dest(cssdest))
		.pipe(rename({suffix: '.min'}))
		//.pipe(minifycss())
		.pipe(gulp.dest(cssdest))
		//.pipe(notify({ message: 'Styles task complete' }))
		;
});
gulp.task('libs', function() {
	return gulp.src([bowerpath + 'ng-file-upload/angular-file-upload-html5-shim.js',
		             bowerpath + 'jquery/dist/jquery.js',
	                 bowerpath + 'angular/angular.js',
	                 bowerpath + 'angular-route/angular-route.js',
	                 bowerpath + 'ng-file-upload/angular-file-upload.js'
	                ])
		// .pipe(jshint('.jshintrc'))
		// .pipe(jshint.reporter('default'))
		.pipe(concat('libs.js'))
		.pipe(gulp.dest(jsdest))
		.pipe(rename({suffix: '.min'}))
		.pipe(uglify())
		.pipe(gulp.dest(jsdest))
		//.pipe(notify({ message: 'Scripts task complete' }))
        ;
});

gulp.task('scripts', function() {
	return gulp.src('src/scripts/**/*.js')
		//.pipe(jshint('.jshintrc'))
		//.pipe(jshint.reporter('default'))
		.pipe(concat('app.js'))
		.pipe(gulp.dest(jsdest))
		.pipe(rename({suffix: '.min'}))
		.pipe(uglify())
		.pipe(gulp.dest(jsdest))
		//.pipe(notify({ message: 'Scripts task complete' }))
        ;
});

gulp.task('app', function() {
	return gulp.src('src/scripts/app.js', 'src/scripts/controllers/formcontroller.js', 'src/scripts/controllers/quizcontroller.js')
		.pipe(concat('testapp.js'))
		.pipe(gulp.dest(jsdest))
		.pipe(rename({suffix: '.min'}))
		.pipe(uglify())
		.pipe(gulp.dest(jsdest));
});

gulp.task('default', ['clean'], function() {
	gulp.start('libs', 'styles', 'app', 'watch');
});

gulp.task('clean', function() {
	return gulp.src([cssdest + '/*.css' , jsdest + '/*.js'], {read: false})
		.pipe(clean());
});

gulp.task('watch', function() {

	// Watch .scss files
	gulp.watch('src/styles/**/*.scss', ['styles']);

	// Watch .js files
	gulp.watch('src/scripts/**/*.js', ['app']);

	// Create LiveReload server
	var server = livereload();

	// Watch any files in dist/, reload on change
	gulp.watch(['dist/**']).on('change', function(file) {
		server.changed(file.path);
	});

});