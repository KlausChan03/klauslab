# Vite 构建配置详细指南

本文档详细说明 KlausLab 主题的 Vite 配置，帮助开发者理解和自定义构建过程。

## 目录

- [配置文件概览](#配置文件概览)
- [入口文件配置](#入口文件配置)
- [输出文件配置](#输出文件配置)
- [CSS 处理](#css-处理)
- [静态资源处理](#静态资源处理)
- [插件系统](#插件系统)
- [开发服务器](#开发服务器)
- [环境变量](#环境变量)
- [自定义配置](#自定义配置)

---

## 配置文件概览

### vite.config.js 基本结构

```javascript
import { defineConfig, loadEnv } from 'vite'
import { resolve } from 'path'

export default defineConfig(({ mode }) => {
  const isDev = mode === 'development'
  
  return {
    base: '/wp-content/themes/klauslab/dist/',
    build: { ... },
    css: { ... },
    plugins: [ ... ],
    server: { ... },
    resolve: { ... },
    define: { ... }
  }
})
```

### 配置项说明

| 配置项 | 类型 | 说明 |
|--------|------|------|
| `base` | string | 公共基础路径 |
| `build` | object | 构建选项 |
| `css` | object | CSS 处理选项 |
| `plugins` | array | Vite 插件列表 |
| `server` | object | 开发服务器配置 |
| `resolve` | object | 模块解析配置 |
| `define` | object | 全局常量定义 |

---

## 入口文件配置

### 多入口配置

Vite 支持多个入口文件，每个入口会生成独立的 bundle：

```javascript
build: {
  rollupOptions: {
    input: {
      // 主应用文件
      app: resolve(__dirname, 'src/js/common.js'),
      
      // 页面级文件
      index: resolve(__dirname, 'src/js/page/index.js'),
      post: resolve(__dirname, 'src/js/page/post.js'),
      single: resolve(__dirname, 'src/js/page/single.js'),
      sideBar: resolve(__dirname, 'src/js/page/sideBar.js'),
      
      // 功能模块
      login: resolve(__dirname, 'src/js/login.js'),
      canvas: resolve(__dirname, 'src/js/canvas.js'),
      utils: resolve(__dirname, 'src/js/utils.js'),
      flexible: resolve(__dirname, 'src/js/flexible.js'),
      
      // 样式文件
      main: resolve(__dirname, 'src/css/app.scss'),
      style: resolve(__dirname, 'src/css/style.scss'),
    }
  }
}
```

### 入口文件说明

#### JavaScript 入口

| 入口名 | 源文件 | 输出文件 | 用途 |
|--------|--------|----------|------|
| `app` | `src/js/common.js` | `dist/js/app.js` | 全局公共代码 |
| `index` | `src/js/page/index.js` | `dist/js/index.js` | 首页逻辑 |
| `post` | `src/js/page/post.js` | `dist/js/post.js` | 文章列表页 |
| `single` | `src/js/page/single.js` | `dist/js/single.js` | 文章详情页 |
| `sideBar` | `src/js/page/sideBar.js` | `dist/js/sideBar.js` | 侧边栏 |
| `login` | `src/js/login.js` | `dist/js/login.js` | 登录页面 |
| `canvas` | `src/js/canvas.js` | `dist/js/canvas.js` | Canvas 特效 |
| `utils` | `src/js/utils.js` | `dist/js/utils.js` | 工具函数 |
| `flexible` | `src/js/flexible.js` | `dist/js/flexible.js` | 移动端适配 |

#### CSS 入口

| 入口名 | 源文件 | 输出文件 | 用途 |
|--------|--------|----------|------|
| `main` | `src/css/app.scss` | `dist/css/main.css` | 主样式文件 |
| `style` | `src/css/style.scss` | `dist/scss/style.css` | 主题样式 |

### 添加新的入口文件

如果需要添加新的入口文件：

```javascript
input: {
  // ... 现有配置
  
  // 新增入口
  newPage: resolve(__dirname, 'src/js/page/newPage.js'),
  newStyle: resolve(__dirname, 'src/css/newStyle.scss'),
}
```

---

## 输出文件配置

### 输出规则

```javascript
output: {
  // 入口文件命名规则
  entryFileNames: (chunkInfo) => {
    const jsFiles = ['app', 'index', 'post', 'single', ...]
    if (jsFiles.includes(chunkInfo.name)) {
      return 'js/[name].js'
    }
    return 'assets/[name]-[hash].js'
  },
  
  // 代码分割文件命名规则
  chunkFileNames: 'js/chunks/[name]-[hash].js',
  
  // 资源文件命名规则
  assetFileNames: (assetInfo) => {
    // 根据文件类型决定输出路径
    const ext = assetInfo.name.split('.').pop()
    
    if (ext === 'css') {
      return assetInfo.name.includes('style') 
        ? 'scss/[name][extname]' 
        : 'css/[name][extname]'
    }
    
    if (/png|jpe?g|svg|gif|tiff|bmp|ico/i.test(ext)) {
      return 'img/[name][extname]'
    }
    
    if (/woff2?|eot|ttf|otf/i.test(ext)) {
      return 'fonts/[name][extname]'
    }
    
    return 'assets/[name]-[hash][extname]'
  }
}
```

### 输出目录结构

```
dist/
├── js/
│   ├── app.js              # 主应用
│   ├── index.js            # 首页
│   ├── post.js             # 文章列表
│   ├── single.js           # 文章详情
│   ├── sideBar.js          # 侧边栏
│   ├── login.js            # 登录
│   ├── canvas.js           # Canvas
│   ├── utils.js            # 工具
│   ├── flexible.js         # 移动端适配
│   └── chunks/             # 代码分割文件
│       └── vendor-*.js
│
├── css/
│   ├── main.css            # 主样式
│   └── page/               # 页面样式（复制）
│
├── scss/
│   └── style.css           # 主题样式
│
├── img/                    # 图片资源
├── fonts/                  # 字体文件
├── emoji/                  # 表情包
└── json/                   # JSON 数据
```

### 文件名模板变量

| 变量 | 说明 | 示例 |
|------|------|------|
| `[name]` | 文件原始名称 | `app` |
| `[hash]` | 文件内容哈希 | `a3f5b8c9` |
| `[extname]` | 文件扩展名（含点） | `.js` |
| `[ext]` | 文件扩展名（不含点） | `js` |

---

## CSS 处理

### SCSS 预处理

```javascript
css: {
  preprocessorOptions: {
    scss: {
      // 自动导入全局 SCSS
      additionalData: `@import "${resolve(__dirname, 'src/css/grid.scss')}";`,
      // 字符集
      charset: false,
    }
  }
}
```

### PostCSS 插件

```javascript
css: {
  postcss: {
    plugins: [
      // 自动添加浏览器前缀
      require('autoprefixer')({
        overrideBrowserslist: ['last 2 versions', '> 2%']
      }),
      
      // 合并媒体查询
      require('css-mqpacker'),
      
      // CSS 压缩（仅生产环境）
      ...(isDev ? [] : [
        require('cssnano')({
          preset: ['default', {
            discardComments: { removeAll: true }
          }]
        })
      ])
    ]
  }
}
```

### 支持的 CSS 功能

- ✅ SCSS/Sass 语法
- ✅ CSS 模块化
- ✅ PostCSS 插件
- ✅ CSS 代码分割
- ✅ 自动添加前缀
- ✅ 媒体查询优化
- ✅ 代码压缩和优化

---

## 静态资源处理

### 静态文件复制

使用 `vite-plugin-static-copy` 插件复制不需要处理的静态资源：

```javascript
viteStaticCopy({
  targets: [
    // JS 库文件
    {
      src: 'src/js/lib/*',
      dest: 'js/lib'
    },
    
    // Vue 组件
    {
      src: 'src/js/component/*',
      dest: 'js/component'
    },
    
    // 插件
    {
      src: 'src/js/plugin/*',
      dest: 'js/plugin'
    },
    
    // Mixins
    {
      src: 'src/js/mixin/*',
      dest: 'js/mixin'
    },
    
    // CSS 文件
    {
      src: 'src/css/page/*',
      dest: 'css/page'
    },
    {
      src: 'src/css/*.min.css',
      dest: 'css'
    },
    
    // 表情包
    {
      src: 'src/emoji/**/*',
      dest: 'emoji'
    },
    
    // 字体文件
    {
      src: 'src/fonts/*',
      dest: 'fonts'
    },
    
    // 图片资源
    {
      src: 'src/img/*',
      dest: 'img'
    },
    
    // JSON 数据
    {
      src: 'src/json/*',
      dest: 'json'
    }
  ]
})
```

### 资源内联

```javascript
build: {
  // 小于 4KB 的资源将被内联为 base64
  assetsInlineLimit: 4096
}
```

---

## 插件系统

### 已配置的插件

#### 1. Vue 2 支持

```javascript
import { createVuePlugin } from 'vite-plugin-vue2'

plugins: [
  createVuePlugin()
]
```

#### 2. 浏览器兼容性

```javascript
import legacy from '@vitejs/plugin-legacy'

plugins: [
  legacy({
    targets: ['last 2 versions', '> 2%'],
    additionalLegacyPolyfills: ['regenerator-runtime/runtime']
  })
]
```

功能：
- 为旧浏览器生成兼容代码
- 自动注入 polyfills
- 支持 ES5 语法转换

#### 3. 静态资源复制

```javascript
import { viteStaticCopy } from 'vite-plugin-static-copy'

plugins: [
  viteStaticCopy({
    targets: [ ... ]
  })
]
```

### 添加新插件

示例：添加图片压缩插件

```bash
npm install -D vite-plugin-imagemin
```

```javascript
import viteImagemin from 'vite-plugin-imagemin'

plugins: [
  // ... 现有插件
  
  viteImagemin({
    gifsicle: { optimizationLevel: 7 },
    optipng: { optimizationLevel: 7 },
    mozjpeg: { quality: 80 }
  })
]
```

### 常用插件推荐

| 插件名 | 功能 | 安装命令 |
|--------|------|----------|
| `vite-plugin-imagemin` | 图片压缩 | `npm i -D vite-plugin-imagemin` |
| `vite-plugin-compression` | Gzip/Brotli 压缩 | `npm i -D vite-plugin-compression` |
| `vite-plugin-html` | HTML 模板处理 | `npm i -D vite-plugin-html` |
| `rollup-plugin-visualizer` | 打包分析 | `npm i -D rollup-plugin-visualizer` |

---

## 开发服务器

### 服务器配置

```javascript
server: {
  host: '0.0.0.0',        // 监听所有地址
  port: 3000,             // 端口号
  open: false,            // 不自动打开浏览器
  cors: true,             // 启用 CORS
  
  // 代理配置（可选）
  proxy: {
    '/wp-admin': {
      target: 'http://localhost:8080',
      changeOrigin: true
    },
    '/wp-json': {
      target: 'http://localhost:8080',
      changeOrigin: true
    }
  }
}
```

### 开发服务器特性

- **热模块替换 (HMR)**: 毫秒级的代码热更新
- **按需编译**: 只编译当前使用的模块
- **原生 ES 模块**: 利用浏览器原生支持
- **错误覆盖层**: 清晰的错误提示

### 使用开发服务器

```bash
# 启动开发服务器
npm run serve

# 访问
http://localhost:3000
```

---

## 环境变量

### 模式和环境

Vite 支持三种模式：

1. **development** - 开发模式
2. **production** - 生产模式
3. **test** - 测试模式（自定义）

### 配置环境变量

创建 `.env` 文件：

```bash
# .env.development
NODE_ENV=development
VITE_API_URL=http://localhost:8080/wp-json

# .env.production
NODE_ENV=production
VITE_API_URL=https://your-site.com/wp-json
```

### 在代码中使用

```javascript
// vite.config.js
export default defineConfig(({ mode }) => {
  const env = loadEnv(mode, process.cwd(), '')
  
  return {
    define: {
      'process.env.NODE_ENV': JSON.stringify(mode),
      'import.meta.env.VITE_API_URL': JSON.stringify(env.VITE_API_URL)
    }
  }
})
```

```javascript
// 在应用代码中
console.log(import.meta.env.MODE)           // 'development' 或 'production'
console.log(import.meta.env.VITE_API_URL)   // API URL
```

---

## 自定义配置

### 路径别名

```javascript
resolve: {
  alias: {
    '@': resolve(__dirname, 'src'),
    '@js': resolve(__dirname, 'src/js'),
    '@css': resolve(__dirname, 'src/css'),
    '@img': resolve(__dirname, 'src/img'),
    '@components': resolve(__dirname, 'src/js/component'),
    'vue': 'vue/dist/vue.esm.js'
  }
}
```

使用示例：

```javascript
// 使用别名前
import utils from '../../js/utils.js'
import Button from '../../js/component/Button.js'

// 使用别名后
import utils from '@js/utils.js'
import Button from '@components/Button.js'
```

### 依赖优化

```javascript
optimizeDeps: {
  include: ['vue', 'axios', 'dayjs', 'lodash']
}
```

预构建指定的依赖，提升开发服务器启动速度。

### 构建优化

```javascript
build: {
  // 启用代码压缩
  minify: 'terser',
  
  // Terser 配置
  terserOptions: {
    compress: {
      drop_console: true,      // 删除 console
      drop_debugger: true      // 删除 debugger
    }
  },
  
  // 代码分割策略
  rollupOptions: {
    output: {
      manualChunks: {
        'vue-vendor': ['vue', 'axios'],
        'ui-vendor': ['element-ui']
      }
    }
  },
  
  // Chunk 大小警告限制
  chunkSizeWarningLimit: 1000
}
```

---

## 调试技巧

### 1. 查看构建产物

```bash
# 构建后查看文件
npm run build

# 查看 dist 目录
ls -la dist/
```

### 2. 分析打包体积

安装分析工具：

```bash
npm install -D rollup-plugin-visualizer
```

配置：

```javascript
import { visualizer } from 'rollup-plugin-visualizer'

plugins: [
  visualizer({
    filename: 'stats.html',
    open: true
  })
]
```

### 3. 启用 Source Map

```javascript
build: {
  sourcemap: true  // 开发环境自动启用
}
```

### 4. 查看详细构建信息

```bash
# 使用 --debug 标志
npm run build -- --debug
```

---

## 性能优化建议

### 1. 按需加载

```javascript
// 动态导入
const component = () => import('@components/heavy-component.js')
```

### 2. 外部化大型依赖

如果某些库已通过 CDN 引入：

```javascript
build: {
  rollupOptions: {
    external: ['vue', 'element-ui']
  }
}
```

### 3. 图片优化

- 使用 WebP 格式
- 使用图片压缩插件
- 启用懒加载

### 4. CSS 优化

- 移除未使用的 CSS（PurgeCSS）
- 合并媒体查询
- 启用 CSS 压缩

---

## 常见配置场景

### 场景 1: 多页面应用

```javascript
input: {
  main: resolve(__dirname, 'index.html'),
  about: resolve(__dirname, 'about.html'),
  contact: resolve(__dirname, 'contact.html')
}
```

### 场景 2: 库模式构建

```javascript
build: {
  lib: {
    entry: resolve(__dirname, 'src/main.js'),
    name: 'KlausLab',
    fileName: (format) => `klauslab.${format}.js`
  }
}
```

### 场景 3: SSR 支持

```javascript
ssr: {
  noExternal: ['element-ui']
}
```

---

## 参考资源

- [Vite 官方文档](https://vitejs.dev/)
- [Rollup 配置](https://rollupjs.org/guide/en/)
- [PostCSS 插件](https://github.com/postcss/postcss/blob/main/docs/plugins.md)
- [Vite 插件列表](https://github.com/vitejs/awesome-vite#plugins)

---

**最后更新**: 2025-10-09

