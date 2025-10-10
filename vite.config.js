import { defineConfig, loadEnv } from 'vite'
import { resolve } from 'path'
import { createVuePlugin } from 'vite-plugin-vue2'
import legacy from '@vitejs/plugin-legacy'
import { viteStaticCopy } from 'vite-plugin-static-copy'

export default defineConfig(({ mode }) => {
  const env = loadEnv(mode, process.cwd(), '')
  const isDev = mode === 'development'

  // 读取 config.js 中的路径配置
  const config = require('./config.js')
  const buildPath = isDev ? config.local : config.production

  return {
    // 基础路径配置
    base: '/wp-content/themes/klauslab/dist/',

    // 构建配置
    build: {
      outDir: 'dist',
      assetsDir: '.',
      emptyOutDir: true,
      
      rollupOptions: {
        input: {
          // 主要入口文件
          app: resolve(__dirname, 'src/js/common.js'),
          // 页面级 JS
          index: resolve(__dirname, 'src/js/page/index.js'),
          post: resolve(__dirname, 'src/js/page/post.js'),
          single: resolve(__dirname, 'src/js/page/single.js'),
          sideBar: resolve(__dirname, 'src/js/page/sideBar.js'),
          // 其他独立文件
          login: resolve(__dirname, 'src/js/login.js'),
          utils: resolve(__dirname, 'src/js/utils.js'),
          flexible: resolve(__dirname, 'src/js/flexible.js'),
          // CSS 文件
          main: resolve(__dirname, 'src/css/app.scss'),
          style: resolve(__dirname, 'src/css/style.scss'),
        },
        output: {
          // JS 文件输出到 js 目录
          entryFileNames: (chunkInfo) => {
            const jsFiles = ['app', 'index', 'post', 'single', 'sideBar', 'login', 'utils', 'flexible']
            if (jsFiles.includes(chunkInfo.name)) {
              return 'js/[name].js'
            }
            return 'assets/[name]-[hash].js'
          },
          // Chunk 文件
          chunkFileNames: 'js/chunks/[name]-[hash].js',
          // CSS 文件输出到 css 目录
          assetFileNames: (assetInfo) => {
            const info = assetInfo.name.split('.')
            const ext = info[info.length - 1]
            
            if (ext === 'css') {
              // CSS 文件输出到 css 或 scss 目录
              if (assetInfo.name.includes('style')) {
                return 'scss/[name][extname]'
              }
              return 'css/[name][extname]'
            }
            
            // 图片文件
            if (/png|jpe?g|svg|gif|tiff|bmp|ico/i.test(ext)) {
              return 'img/[name][extname]'
            }
            
            // 字体文件
            if (/woff2?|eot|ttf|otf/i.test(ext)) {
              return 'fonts/[name][extname]'
            }
            
            return 'assets/[name]-[hash][extname]'
          },
        },
      },
      
      // 压缩配置
      minify: isDev ? false : 'terser',
      terserOptions: {
        compress: {
          drop_console: !isDev,
          drop_debugger: !isDev,
        },
      },
      
      // Source map
      sourcemap: isDev,
      
      // 资源内联限制
      assetsInlineLimit: 4096,
    },

    // CSS 配置
    css: {
      preprocessorOptions: {
        scss: {
          charset: false,
        },
      },
      postcss: {
        plugins: [
          require('autoprefixer')({
            overrideBrowserslist: ['last 2 versions', '> 2%'],
          }),
          require('css-mqpacker'),
          ...(isDev ? [] : [require('cssnano')({
            preset: ['default', {
              discardComments: {
                removeAll: true,
              },
            }],
          })]),
        ],
      },
    },

    // 插件配置
    plugins: [
      // Vue 2 支持
      createVuePlugin(),
      
      // 浏览器兼容性
      legacy({
        targets: ['last 2 versions', '> 2%'],
        additionalLegacyPolyfills: ['regenerator-runtime/runtime'],
      }),
      
      // 静态资源复制
      viteStaticCopy({
        targets: [
          // 复制特殊 JS 文件（不编译）
          {
            src: 'src/js/canvas.js',
            dest: 'js'
          },
          // 复制 JS 库文件
          {
            src: 'src/js/lib/*',
            dest: 'js/lib'
          },
          // 复制 JS 组件
          {
            src: 'src/js/component/*',
            dest: 'js/component'
          },
          // 复制 JS 插件
          {
            src: 'src/js/plugin/*',
            dest: 'js/plugin'
          },
          // 复制 JS mixins
          {
            src: 'src/js/mixin/*',
            dest: 'js/mixin'
          },
          // 复制 CSS 文件
          {
            src: 'src/css/page/*',
            dest: 'css/page'
          },
          {
            src: 'src/css/*.min.css',
            dest: 'css'
          },
          // 复制表情包
          {
            src: 'src/emoji/**/*',
            dest: 'emoji'
          },
          // 复制字体文件
          {
            src: 'src/fonts/*',
            dest: 'fonts'
          },
          // 复制图片（如果不需要优化的话）
          {
            src: 'src/img/*',
            dest: 'img'
          },
          // 复制 JSON 文件
          {
            src: 'src/json/*',
            dest: 'json'
          },
        ],
      }),
    ],

    // 开发服务器配置
    server: {
      host: '0.0.0.0',
      port: 3000,
      open: false,
      cors: true,
      // 如果需要代理到 WordPress 本地服务器
      proxy: {
        '/wp-admin': {
          target: 'http://localhost:8080',
          changeOrigin: true,
        },
        '/wp-json': {
          target: 'http://localhost:8080',
          changeOrigin: true,
        },
      },
    },

    // 依赖优化
    optimizeDeps: {
      include: ['vue', 'axios', 'dayjs', 'lodash'],
    },

    // 解析配置
    resolve: {
      alias: {
        '@': resolve(__dirname, 'src'),
        '@js': resolve(__dirname, 'src/js'),
        '@css': resolve(__dirname, 'src/css'),
        '@img': resolve(__dirname, 'src/img'),
        '@components': resolve(__dirname, 'src/js/component'),
        // Vue 2 兼容
        'vue': 'vue/dist/vue.esm.js',
      },
      extensions: ['.js', '.json', '.jsx', '.mjs', '.ts', '.tsx', '.vue'],
    },

    // 定义全局常量
    define: {
      'process.env.NODE_ENV': JSON.stringify(mode),
    },
  }
})

