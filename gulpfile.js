// Gulp.js config file

'use strict';
const env = process.env.NODE_ENV
const dir = {
        // 源文件和构建目录
        src:    'src/',
        dist: 'dist/',
        srcRouter: './src/',
        distRouter: './dist/',
        // 注意：这里的路径需要根据自己的 wordpress 安装路径进行修改
        build:  env === 'dev' ? 'C:/Tools/xampp/htdocs/dashboard/klausLab/wp-content/themes/KlausLab/' : '/var/www/html/wordpress/wp-content/themes/KlausLab/'
    },    

    // Gulp 和 插件
    gulp        = require('gulp'),
    gutil       = require('gulp-util'),
    newer       = require('gulp-newer'),
    imagemin    = require('gulp-imagemin'),
    minifycss = require('gulp-minify-css'),
    uglify      = require('gulp-uglify'),
    sourcemaps  = require('gulp-sourcemaps'),
    browserify  = require('browserify'),
    source      = require('vinyl-source-stream'),
    buffer      = require('vinyl-buffer'),
    babel = require('gulp-babel'),
    promiseddel = require('promised-del'),
    sass        = require('gulp-sass'),
    postcss     = require('gulp-postcss'),
    babelify    = require('babelify'),
    deporder    = require('gulp-deporder'),
    removeUseStrict = require("gulp-remove-use-strict"),
    stripdebug  = require('gulp-strip-debug');

let FILTERJS = [dir.src + '/js/**/*.js',  '!' + dir.src + '/js/**/*.min.js',  '!' + dir.src + '/js/**/canvas.js',  '!' + dir.src + '/js/**/fixed-plugins.js'];
let COPYJS = [dir.src + '/js/**/*.min.js',  dir.src + '/js/**/canvas.js',  dir.src + '/js/**/fixed-plugins.js'];
let FILTERCSS =  [dir.src + '/css/**/*.css']
let COPYCSS = [];
let COPYEMOJI = [dir.src + '/emoji/**/*.json',];
let COPYFONT = [dir.src + '/fonts/**/*',];




// PHP
const php = {
    src:    dir.src + 'template-parts/**/*.php',
    build:  dir.build + 'template-parts'
};

// 复制 PHP 文件
gulp.task('php', () => {
    return gulp.src(php.src)
        .pipe(newer(php.build))
        .pipe(gulp.dest(php.build));
});

// 图像处理
const images = {
    src:    dir.src + 'img/**/*',
    build:  dir.build + dir.distRouter +'img/'
};

gulp.task('images', () => {
    return gulp.src(images.src)
        .pipe(newer(images.build))
        .pipe(imagemin())
        .pipe(gulp.dest(images.build));
});

// Sass 编译
var css = {
    src:    dir.src + 'scss/style.scss',
    watch:  dir.src + 'scss/**/*',
    build:  dir.build + dir.distRouter +'css/',
    sassOpts: {
        outputStyle     : 'nested',
        imagePath       : images.build,
        precision       : 3,
        errLogToConsole : true
    },
    processors: [
        require('postcss-assets')({
            loadPaths: ['images/'],
            basePath: dir.build,
            baseUrl: '/wp-content/themes/KlausLab/'
        }),
        require('autoprefixer')({
            browsers: ['last 2 versions', '> 2%']
        }),
        require('css-mqpacker'),
        require('cssnano')
    ]
};

gulp.task('css', function () {
    return gulp.src(FILTERCSS)
        // 这会输出一个未压缩过的版本 
        // .pipe(gulp.dest(DEST + '/src/css/'))
        // 这会输出一个压缩过的并且重命名未 foo.min.css 的文件
        .pipe(minifycss({
            keepSpecialComments: 1,
            processImport: true
        }))
        // .pipe(rev()) //- 文件名加MD5后缀
        .pipe(gulp.dest(css.build))
        // .pipe(rev.manifest()) //- 生成一个rev-manifest.json
        // .pipe(gulp.dest(DEST + '/rev/css')); //- 将 rev-manifest.json 保存到 rev 目录内
});

// Javascript 的处理
const js = {
    src:        dir.src + 'js/**/*',
    build:      dir.build + dir.distRouter +'js/',
    filename:   'scripts.js'
};


gulp.task('js', function () {
    return gulp.src(FILTERJS)
        .pipe(babel({
            presets: [
                ['es2015', { strict: false, loose: true }]
            ],
            // minified: true
        }))
        // 压缩不美化
        .pipe(uglify({
            compress: false
        }))
        // 判断环境
        // .pipe(preprocess({
        //     context: {
        //       // 此处可接受来自调用命令的 NODE_ENV 参数，默认为 dev 开发测试环境
        //       NODE_ENV: process.env.NODE_ENV || 'dev',
        //     },
        // }))
        // .pipe(rev()) //- 文件名加MD5后缀
        .pipe(gulp.dest(js.build))
        // .pipe(rev.manifest()) //- 生成一个rev-manifest.json
        // .pipe(gulp.dest(js.build + '/rev/js')); //- 将 rev-manifest.json 保存到 rev 目录内
});


// gulp.task('browserify', () => {
//     return browserify({
//         entries: js.entry,
//         debug: true
//     })
//     .transform("babelify", {presets: ["es2015"]}).on('error', (error) => {
//         gutil.log(gutil.colors.red('[Error]'), err.toString());
//     })
//     .bundle()
//     .pipe(source(js.filename))
//     .pipe(buffer())
//     .pipe(sourcemaps.init({loadMaps: true}))
//     .pipe(sourcemaps.write('.'))
//     .pipe(gulp.dest(js.build))
// });


gulp.task('clean', function () {
    return promiseddel(['dist']);
});

gulp.task('copy', () => {
    return gulp.src(COPYJS.concat(COPYCSS).concat(COPYEMOJI).concat(COPYFONT), {
        base: dir.srcRouter
    })
        .pipe(gulp.dest(dir.distRouter));
});

// 监视
// gulp.task('watch', gulp.parallel('browsersync', () => {
//     console.log('watch......');
//     // 页面改变
//     gulp.watch(php.src, gulp.parallel('php')).on('change', () => {
//         browsersync ? browsersync.reload : {};
//     });

//     // 图像改变
//     gulp.watch(images.src, gulp.parallel('images')).on('change', browsersync ? browsersync.reload : gutil.noop);

//     // css 改变
//     gulp.watch(css.watch, gulp.parallel('css'));

//     // js 改变
//     gulp.watch(js.src, gulp.parallel('js')).on('change', browsersync ? browsersync.reload : gutil.noop);
// }));

gulp.task('default', gulp.series( 'clean','php',  'js', 'css', 'images','copy'));

// default task
// gulp.task('default', gulp.series('build', 'watch'));