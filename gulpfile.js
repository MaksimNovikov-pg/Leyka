// Paths for source and bundled parts of app:
let basePaths = {
    src: 'src/',
    dest: 'assets/',
    npm: 'node_modules/',
    root: ''
};

// Require plugins:
let gulp = require('gulp'),
    es = require('event-stream'),
    gutil = require('gulp-util'),
    bourbon = require('node-bourbon'),
    path = require('relative-path'),
    del = require('del');
    jsImport = require('gulp-js-import');

// Plugins - load gulp-* plugins without direct calls:
let plugins = require('gulp-load-plugins')({
    pattern: ['gulp-*', 'gulp.*'],
    replaceString: /\bgulp[\-.]/
});

// Env - call gulp --prod to go into production mode
let sassStyle = 'expanded', // SASS syntax
    sourceMap = true, //wheter to build source maps
    isProduction = false; //mode flag

if(gutil.env.prod === true) {
    isProduction = true;
    sassStyle = 'compressed';
    sourceMap = false;
}

// JS:
gulp.task('build-front-js', async function(){

    let vendorFiles = [basePaths.npm + 'jquery.cookie/jquery.cookie.js'],
        appFiles = [basePaths.src+'js/*.js', basePaths.src+'js/common/*.js', basePaths.src+'js/front/*.js'];

    return await gulp.src(vendorFiles.concat(appFiles))
        .pipe(plugins.concat('public.js'))
        .pipe(isProduction ? plugins.uglify() : gutil.noop()) // Minification
        .pipe(plugins.size()) // Print size for log
        .on('error', console.log)
        .pipe(gulp.dest(basePaths.dest + 'js'));

});

gulp.task('build-admin-js', function(){

    let vendorFiles = [basePaths.npm+'jquery.cookie/jquery.cookie.js'],
        appFiles = [basePaths.src+'js/common/*.js', basePaths.src+'js/admin/common/*.js', basePaths.src+'js/admin/*.js'];

    return gulp.src(vendorFiles.concat(appFiles))
        .pipe(plugins.concat('admin.js'))
        .pipe(isProduction ? plugins.uglify() : gutil.noop()) // Minification
        .pipe(plugins.size())
        .on('error', console.log)
        .pipe(gulp.dest(basePaths.dest + 'js'));

});

gulp.task('build-editor-js', function(){

    let vendorFiles = [/*basePaths.npm+'jquery.cookie/jquery.cookie.js'*/],
        appFiles = [basePaths.src+'js/editor/editor.js']; //our own JS files

    return gulp.src(vendorFiles.concat(appFiles)) //join them
        .pipe(plugins.filter('*.js'))//select only .js ones
        .pipe(plugins.concat('editor.js'))//combine them into bundle.js
        .pipe(isProduction ? plugins.uglify() : gutil.noop()) //minification
        .pipe(plugins.size()) //print size for log
        .on('error', console.log) //log
        .pipe(gulp.dest(basePaths.dest+'js')); //write results into file

});

gulp.task('build-blocks-js', function() {
   let vendorFiles = [/*basePaths.npm+'jquery.cookie/jquery.cookie.js'*/],
        appFiles = [basePaths.src+'js/blocks/*.js']; //our own JS files

    return gulp.src(vendorFiles.concat(appFiles)) //join them
        .pipe(plugins.concat('blocks.js'))//combine them into bundle.js
        .pipe(jsImport({
            hideConsole: false,
            importStack: false
        }))
        .pipe(plugins.size()) //print size for log
        .on('error', console.log) //log
        .pipe(gulp.dest(basePaths.dest+'js')); //write results into file
});

// CSS:
gulp.task('build-front-css', function(){

    let paths = require('node-bourbon').includePaths,
    // vendorFiles = gulp.src([]), //components
        gatewaysFiles = [basePaths.root+'gateways/*/css/*.public.scss'],
        appFiles = gulp.src([basePaths.src+'sass/front-main.scss'].concat(gatewaysFiles)) // our main file with @import-s
            .pipe(isProduction ? gutil.noop() : plugins.sourcemaps.init()) // process the original sources for sourcemap
            .pipe(
                plugins.sass({
                    outputStyle: sassStyle, // SASS syntax
                    includePaths: paths // Add Bourbon
                }).on('error', plugins.sass.logError)
            )
            .pipe(plugins.autoprefixer({
                browsers: ['last 4 versions'],
                cascade: false
            }))
            .pipe(isProduction ? gutil.noop() : plugins.sourcemaps.write()) //add the map to modified source
            .on('error', console.log);

    return es.concat(appFiles /*, vendorFiles*/)
        .pipe(plugins.concat('public.css'))
        .pipe(isProduction ? plugins.cssmin() : gutil.noop()) // Minification on production
        .pipe(plugins.size())
        .pipe(gulp.dest(basePaths.dest + 'css'))
        .on('error', console.log);

});

gulp.task('build-admin-css', function() {

    let paths = require('node-bourbon').includePaths,
		// vendorFiles = gulp.src([]),
        appFiles = gulp.src(basePaths.src+'sass/admin/admin.scss')
        .pipe(isProduction ? gutil.noop() : plugins.sourcemaps.init())  // Process original sources for sourcemap
        .pipe(plugins.sass({
            outputStyle: sassStyle, //SASS syntas
            includePaths: paths //add bourbon + mdl
        }).on('error', plugins.sass.logError))//sass own error log
        .pipe(plugins.autoprefixer({ //autoprefixer
            browsers: ['last 4 versions'],
            cascade: false
        }))
        .pipe(isProduction ? gutil.noop() : plugins.sourcemaps.write()) // Add the map to modified source
        .on('error', console.log); //log

	return es.concat(appFiles /*, vendorFiles*/) //combine vendor CSS files and our files after-SASS
        .pipe(plugins.concat('admin.css')) //combine into file
        .pipe(isProduction ? plugins.cssmin() : gutil.noop()) //minification on production
        .pipe(plugins.size()) //display size
        .pipe(gulp.dest(basePaths.dest+'css')) //write file
        .on('error', console.log); //log

});

gulp.task('build-editor-css', function() {

    let paths = require('node-bourbon').includePaths,
		// vendorFiles = gulp.src([]),
        appFiles = gulp.src(basePaths.src+'sass/admin/editor.scss')
        .pipe(!isProduction ? plugins.sourcemaps.init() : gutil.noop())  //process the original sources for sourcemap
        .pipe(plugins.sass({
                outputStyle: sassStyle, //SASS syntas
                includePaths: paths //add bourbon + mdl
            }).on('error', plugins.sass.logError))//sass own error log
        .pipe(plugins.autoprefixer({ //autoprefixer
                browsers: ['last 4 versions'],
                cascade: false
            }))
        .pipe(!isProduction ? plugins.sourcemaps.write() : gutil.noop()) //add the map to modified source
        .on('error', console.log); //log

	return es.concat(appFiles /*, vendorFiles*/) //combine vendor CSS files and our files after-SASS
        .pipe(plugins.concat('editor.css')) //combine into file
        .pipe(isProduction ? plugins.cssmin() : gutil.noop()) //minification on production
        .pipe(plugins.size()) //display size
        .pipe(gulp.dest(basePaths.dest+'css')) //write file
        .on('error', console.log); //log

});

gulp.task('build-editor-style-css', function() {

    let paths = require('node-bourbon').includePaths,
        // vendorFiles = gulp.src([]),
        appFiles = gulp.src(basePaths.src+'sass/editor-style.scss')
        .pipe(!isProduction ? plugins.sourcemaps.init() : gutil.noop())  //process the original sources for sourcemap
        .pipe(plugins.sass({
                outputStyle: sassStyle, //SASS syntas
                includePaths: paths //add bourbon + mdl
            }).on('error', plugins.sass.logError))//sass own error log
        .pipe(plugins.autoprefixer({ //autoprefixer
                browsers: ['last 4 versions'],
                cascade: false
            }))
        .pipe(!isProduction ? plugins.sourcemaps.write() : gutil.noop()) //add the map to modified source
        .on('error', console.log); //log

    return es.concat(appFiles /*, vendorFiles*/) //combine vendor CSS files and our files after-SASS
        .pipe(plugins.concat('editor-style.css')) //combine into file
        .pipe(isProduction ? plugins.cssmin() : gutil.noop()) //minification on production
        .pipe(plugins.size()) //display size
        .pipe(gulp.dest(basePaths.dest+'css')) //write file
        .on('error', console.log); //log

});

// Builds:
gulp.task('full-build', async function(){
    await gulp.parallel('full-build-css', 'full-build-js', 'svg-opt');
});

gulp.task('full-build-css', async function(){
    await gulp.series('build-front-css', /*'build-admin-common-css',*/ 'build-admin-css', 'build-editor-style-css');
});

gulp.task('full-build-js', async function(){
    await gulp.series('build-front-js', 'build-admin-js');
});

// SVG - combine and clear svg assets:
gulp.task('svg-opt', function(){

    let icons = gulp.src([basePaths.src+'svg/icon-*.svg'])
        .pipe(plugins.svgmin({
            plugins: [{
                removeTitle: true,
                removeDesc: { removeAny: true },
                removeEditorsNSData: true,
                removeComments: true
            }]
        }))
        .pipe(plugins.cheerio({
            run: function ($) { //remove fill from icons
                $('[fill]').removeAttr('fill');
                $('[fill-rule]').removeAttr('fill-rule');
            },
            parserOptions: { xmlMode: true }
        })),
        pics = gulp.src([basePaths.root+'gateways/**/pic-main-*.svg', basePaths.src+'svg/pic-*.svg'])
        .pipe(plugins.svgmin({
            plugins: [{
                removeTitle: true,
                removeDesc: { removeAny: true },
                removeEditorsNSData: true,
                removeComments: true
            }]
        })); // minification

    return es.concat(icons, pics)
        .pipe(plugins.svgstore({ inlineSvg: true })) //combine for inline usage
        .pipe(gulp.dest(basePaths.dest+'svg'));

});

// Watchers
gulp.task('watch', function(done){

    // Frontend:
    gulp.watch([basePaths.src+'sass/*.scss', basePaths.src+'sass/form_templates/*/*.scss', basePaths.root+'gateways/*/css/*.public.scss'], gulp.series('build-front-css'));
    gulp.watch([basePaths.src+'js/*.js', basePaths.src+'js/front/*.js'], gulp.series('build-front-js'));

    // Backend:
    gulp.watch(
        [basePaths.src+'sass/admin/*.scss', basePaths.src+'sass/admin/**/*.scss'],
        gulp.series(/*'build-admin-common-css',*/ 'build-admin-css', 'build-editor-css')
    );

    gulp.watch(
        [basePaths.src+'js/admin/*.js', basePaths.src+'js/admin/**/*.js'],
        gulp.series('build-admin-js')
    );

    gulp.watch(
        [basePaths.src+'js/editor/*.js'],
        gulp.series('build-editor-js')
    );

    done();

});

gulp.task('default', gulp.series('full-build', 'watch'));