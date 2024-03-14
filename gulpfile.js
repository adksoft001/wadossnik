/* 
 * 23.11.2020
 * File: gulpfile.js
 * Encoding: UTF-8
 * Project: RMS spetial for Quality Motors team
 * 
 * Author: Gafuroff Alexandr 
 * E-mail: gafuroff.al@yandex.ru
 */

"use strict";

var gulp = require('gulp');
var sass = require('gulp-sass')(require('sass'));
var sourcemaps = require('gulp-sourcemaps');
var cleanCSS = require('gulp-clean-css');
var autoprefixer = require('gulp-autoprefixer');
var rename = require("gulp-rename");
var gzip = require('gulp-gzip');
var uglify = require('gulp-uglifyes');
var concat = require('gulp-concat');
var strip = require('gulp-strip-comments');


sass.compiler = require('node-sass');

gulp.task('scss', function () {
    return gulp.src('./public/sass/style.scss')
        .pipe(sourcemaps.init())
        .pipe(sass().on('error', sass.logError))
        .pipe(autoprefixer(['last 15 versions']))
        .pipe(rename({suffix: ".min"}))
        .pipe(cleanCSS({level: {1: {specialComments: 0}}}))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('./public/css'));
});

gulp.task('compress_library_css', function () {
    return gulp.src('./public/css/libs/*.css')
        .pipe(sourcemaps.init())
        .pipe(cleanCSS({level: {1: {specialComments: 0}}}))
        .pipe(gzip({postExtension: 'gz'}))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('./public/css/libs'));
});

gulp.task('compress_css', function () {
    return gulp.src("./public/css/style.min.css")
        .pipe(gzip({postExtension: 'gz'}))
        .pipe(gulp.dest("./public/css"));
});

gulp.task('js', function () {
    return gulp.src([
        "public_html/js/jquery.min.js",
        "public_html/js/slick.min.js",
        "public_html/js/libs/jquery.fancybox.js",
        "public_html/js/script.js",
        "public_html/js/mango.js",
        "public_html/js/libs/jquery.modal.js",
        "public_html/js/libs/lazyload.min.js",
        "public_html/js/seofilter.js"
    ])

        .pipe(sourcemaps.init())
        .pipe(concat('main.js', {newLine: ';'}))
        .pipe(strip())
        .pipe(rename({suffix: ".min"}))
        .pipe(uglify({
            mangle: false,
            ecma: 6
        }))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest("public_html/js"));
});

gulp.task('compress_js', function () {
    return gulp.src([
        "./public_html/js/main.min.js"
    ])
        .pipe(gzip({postExtension: 'gz'}))
        .pipe(gulp.dest("public_html/js"));
});

gulp.task('styles', gulp.series('scss', 'compress_css', 'compress_library_css'));
gulp.task('scripts', gulp.series('js', 'compress_js'));

gulp.task('default', function () {
    gulp.watch('./public/sass/*.scss', ['styles']);
    gulp.watch('./public_html/js/*.js', ['scripts']);
});
