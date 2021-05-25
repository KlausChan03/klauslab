// Gulp.js config file

'use strict';
const env = process.env.NODE_ENV
const dir = {
        // 源文件和构建目录
        src: 'src',
        dist: 'dist/',
        srcRouter: './src/',
        distRouter: './dist/',
        // 注意：这里的路径需要根据自己的 wordpress 安装路径进行修改
        build: env === 'dev' 
            ? 'C:/Tools/xampp/htdocs/dashboard/klausLab/wp-content/themes/KlausLab/' // 'C:/xampp/htdocs/dashboard/klausLab/wp-content/themes/klausLab/'
            : '/var/www/html/wordpress/wp-content/themes/KlausLab/'
    },

    // Gulp 和 插件
    gulp = require('gulp'),
    gutil = require('gulp-util'),
    newer = require('gulp-newer'),
    imagemin = require('gulp-imagemin'),
    minifycss = require('gulp-minify-css'),
    uglify = require('gulp-uglify'),
    sourcemaps = require('gulp-sourcemaps'),
    rename = require('gulp-rename'),
    browserify = require('browserify'),
    source = require('vinyl-source-stream'),
    buffer = require('vinyl-buffer'),
    babel = require('gulp-babel'),
    promiseddel = require('promised-del'),
    sass = require('gulp-sass'),
    postcss = require('gulp-postcss'),
    babelify = require('babelify'),
    deporder = require('gulp-deporder'),
    removeUseStrict = require("gulp-remove-use-strict"),
    stripdebug = require('gulp-strip-debug'),
    concat = require('gulp-concat'),
    rev = require('gulp-rev'),
    revCollector = require('gulp-rev-collector'),
    preprocess = require('gulp-preprocess'),
    minimist = require('minimist');

// let FILTERJS = [dir.src + '/js/*.js', '!' + dir.src + '/js/*.min.js', '!' + dir.src + '/js/**/canvas.js', '!' + dir.src + '/js/**/fixed-plugins.js'];
let HEADERJS = [dir.src + '/js/options.js'];
let FOOTERJS = [ dir.src + '/js/common.js', dir.src + '/js/utils.js' ];
let COPYJS = [dir.src + '/js/**/*.min.js',dir.src + '/js/page/*.js',dir.src + '/js/plugin/*.js',dir.src + '/js/component/*.js', dir.src + '/js/**/canvas.js', dir.src + '/js/**/fixed-plugins.js', dir.src + '/js/flexible.js', dir.src+ '/js/login.js'];
let FILTERCSS = [dir.src + '/css/*.css', '!' + dir.src + '/css/*.min.css' ]
let FILTERSCSS = [dir.src + '/css/*.scss']
let FILTERTEMPCSS = [dir.dist + 'css/*.css']
let COPYCSS = [dir.src + '/css/login.css'];
let COPYOTHERS = [dir.src + '/theme/*', dir.src + '/css/**/*.min.css', dir.src + '/emoji/**/*', dir.src + '/fonts/**/*',  dir.src + '/img/**/*',dir.src + '/json/**/*', dir.src + '/css/lib/*'];

//默认development环境
var knowOptions = {
    string: 'env',
    default: {
        env: process.env.NODE_ENV || 'dev'
    }
};

// PHP
// const php = {
//     src: dir.src + '/functions/**/*.php',
//     build: dir.build + 'functions'
// };

// // 复制 PHP 文件
// gulp.task('php', () => {
//     return gulp.src(php.src)
//         .pipe(preprocess({
//             context:{
//                 NODE_ENV: process.env.NODE_ENV || 'prod'
//             }
//         }))
//         .pipe(newer(php.build))
//         .pipe(gulp.dest(php.build));
// });

// 图像处理
const images = {
    src: dir.src + '/img/**/*',
    build: dir.build + dir.dist + 'img/'
};

gulp.task('images', () => {
    return gulp.src(images.src)
        .pipe(newer(images.build))
        .pipe(imagemin())
        .pipe(gulp.dest(images.build));
});

var scss = {
    build: dir.build + dir.dist + 'scss/',
}

// Sass 编译
var css = {
    src: dir.src + 'scss/style.scss',
    watch: dir.src + 'scss/**/*',
    build: dir.build + dir.dist + 'css/',
    sassOpts: {
        outputStyle: 'nested',
        imagePath: images.build,
        precision: 3,
        errLogToConsole: true
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
        .pipe(concat('main.css'))
        .pipe(minifycss({
            keepSpecialComments: 1,
            processImport: true
        }))
        .pipe(gulp.dest(css.build))
});

gulp.task('scss', function () {
    return gulp.src(FILTERSCSS)
        .pipe(concat('style.css'))
        .pipe(sourcemaps.init())
        .pipe(sass({outputStyle: 'expanded'}).on('error', sass.logError))
        .pipe(rename({           
            extname: '.css'
        }))
        .pipe(gulp.dest(dir.build))
});

// Javascript 的处理
const js = {
    src: dir.src + 'js/**/*',
    build: dir.build + dir.dist + 'js/',
    filename: 'scripts.js'
};

gulp.task('headerJs', function () {
    return gulp.src(HEADERJS)
        .pipe(babel({
            presets: [
                ['es2015', {
                    strict: false,
                    loose: true
                }]
            ],
        }))
        // 压缩不美化
        .pipe(uglify({
            compress: true
        }))
        .pipe(concat('options.js'))
        .pipe(gulp.dest(js.build))
});

gulp.task('footerJs', function () {
    return gulp.src(FOOTERJS)
        .pipe(babel({
            presets: [
                ['es2015', {
                    strict: false,
                    loose: true
                }]
            ],
        }))
        // 压缩不美化
        .pipe(uglify({
            compress: true
        }))
        .pipe(concat('app.js'))
        .pipe(gulp.dest(js.build))
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
    return gulp.src(COPYJS.concat(COPYCSS).concat(COPYOTHERS), {
            base: dir.srcRouter
        })
        .pipe(gulp.dest(dir.distRouter));
});

var options = minimist(process.argv.slice(2), knowOptions);

//生成filename文件，存入string内容
function string_src(filename, string) {
    var src = require('stream').Readable({
        objectMode: true
    })
    src._read = function () {
        this.push(new gutil.File({
            cwd: "",
            base: "",
            path: filename,
            contents: Buffer.from(string)
        }))
        this.push(null)
    }
    return src
}

gulp.task('constants', function () {
    //读入config.json文件
    var myConfig = require('./config.json');
    //取出对应的配置信息
    var envConfig = myConfig[options.env];
    var conConfig = 'GLOBAL = ' + JSON.stringify(envConfig);
    //生成config.js文件
    return string_src("config.js", conConfig)
        .pipe(gulp.dest(js.build))
});

gulp.task('default', gulp.series('clean', 'headerJs','footerJs', 'css', 'scss','copy'));
 