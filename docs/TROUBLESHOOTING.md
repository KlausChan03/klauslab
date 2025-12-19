# KlausLab Vite 构建 - 故障排除指南

本文档记录了从 Gulp 迁移到 Vite 过程中遇到的问题和解决方案，帮助您快速解决类似问题。

---

## 🐛 已解决的问题

### 问题 1: 缺少 vue-template-compiler

**错误信息**:
```
Error: Cannot find module 'vue-template-compiler'
```

**原因**: `vite-plugin-vue2` 需要 `vue` 和 `vue-template-compiler` 作为对等依赖。

**解决方案**:
在 `package.json` 的 `devDependencies` 中添加：
```json
{
  "vue": "^2.7.16",
  "vue-template-compiler": "^2.7.16"
}
```

---

### 问题 2: Vite 版本不兼容

**错误信息**:
```
peer vite@"^2.0.0 || ^3.0.0 || ^4.0.0" from vite-plugin-vue2@2.0.3
```

**原因**: `vite-plugin-vue2@2.0.3` 只支持 Vite 2.x-4.x，不支持 Vite 5.x。

**解决方案**:
使用 Vite 4.x 版本：
```json
{
  "vite": "^4.5.5",
  "@vitejs/plugin-legacy": "^4.1.1"
}
```

---

### 问题 3: 插件版本冲突

**错误信息**:
```
peer vite@"^5.0.0" from vite-plugin-static-copy@1.0.6
```

**原因**: `vite-plugin-static-copy@1.0.6` 需要 Vite 5.x，但我们使用的是 4.x。

**解决方案**:
降级到兼容版本：
```json
{
  "vite-plugin-static-copy": "^0.17.1"
}
```

---

### 问题 4: css-mqpacker 版本不存在

**错误信息**:
```
notarget No matching version found for css-mqpacker@^10.0.0
```

**原因**: `css-mqpacker` 最高版本是 7.0.0，不存在 10.0.0。

**解决方案**:
使用正确的版本号：
```json
{
  "css-mqpacker": "^7.0.0",
  "cssnano": "^6.1.2"
}
```

---

### 问题 5: CommonJS 与 ES 模块冲突

**错误信息**:
```
The CommonJS "module" variable is treated as a global variable in an ECMAScript module
```

**原因**: `package.json` 中设置了 `"type": "module"`，导致 `config.js` 中的 `module.exports` 语法冲突。

**解决方案**:
移除 `package.json` 中的 `"type": "module"`：
```json
{
  "name": "klauslab",
  "version": "1.0.0",
  "description": "a klaus and laura's blog",
  "scripts": { ... }
}
```

---

### 问题 6: canvas.js 严格模式错误

**错误信息**:
```
RollupError: Deleting local variable in strict mode
file: D:/code/myself/klauslab/src/js/canvas.js:2969:75
```

**原因**: `canvas.js` 中包含不兼容严格模式的代码（`delete b;` 试图删除局部变量）。

**解决方案**:
将 `canvas.js` 从构建入口移除，直接复制到输出目录：

**1. 从 input 中移除**:
```javascript
rollupOptions: {
  input: {
    // 移除 canvas: resolve(__dirname, 'src/js/canvas.js'),
  }
}
```

**2. 添加到静态复制**:
```javascript
viteStaticCopy({
  targets: [
    {
      src: 'src/js/canvas.js',
      dest: 'js'
    }
  ]
})
```

---

### 问题 7: SCSS import 路径错误

**错误信息**:
```
[sass] Can't find stylesheet to import.
@import "D:\code\myself\klauslab\src\css\grid.scss";
```

**原因**: Vite 配置中的 `additionalData` 使用了绝对路径，在实际编译时找不到文件。

**解决方案**:
移除 `additionalData` 配置：
```javascript
css: {
  preprocessorOptions: {
    scss: {
      // 移除 additionalData
      charset: false,
    }
  }
}
```

如果需要全局导入 SCSS，在每个需要的文件中手动导入。

---

## ✅ 最终配置

### package.json (devDependencies)

```json
{
  "devDependencies": {
    "@vitejs/plugin-legacy": "^4.1.1",
    "autoprefixer": "^10.4.20",
    "css-mqpacker": "^7.0.0",
    "cssnano": "^6.1.2",
    "sass": "^1.79.4",
    "terser": "^5.34.1",
    "vite": "^4.5.5",
    "vite-plugin-static-copy": "^0.17.1",
    "vite-plugin-vue2": "^2.0.3",
    "vue": "^2.7.16",
    "vue-template-compiler": "^2.7.16"
  }
}
```

### vite.config.js 关键配置

```javascript
export default defineConfig(({ mode }) => {
  return {
    build: {
      rollupOptions: {
        input: {
          // 不包含 canvas.js
          app: resolve(__dirname, 'src/js/common.js'),
          // ... 其他入口
        }
      }
    },
    
    css: {
      preprocessorOptions: {
        scss: {
          charset: false
          // 不使用 additionalData
        }
      }
    },
    
    plugins: [
      viteStaticCopy({
        targets: [
          {
            src: 'src/js/canvas.js',
            dest: 'js'
          }
          // ... 其他静态文件
        ]
      })
    ]
  }
})
```

---

## 🔍 诊断步骤

遇到构建问题时，按以下步骤诊断：

### 1. 检查依赖版本

```bash
npm ls vite
npm ls vite-plugin-vue2
npm ls vue
npm ls vue-template-compiler
```

### 2. 清理并重新安装

```bash
rm -rf node_modules package-lock.json
npm cache clean --force
npm install
```

### 3. 查看详细错误

```bash
npm run dev -- --debug
```

### 4. 检查配置文件

- ✅ `vite.config.js` 语法正确
- ✅ `config.js` 存在且格式正确
- ✅ `package.json` 没有 `"type": "module"`

### 5. 验证源文件

- ✅ 所有入口文件存在
- ✅ SCSS 文件路径正确
- ✅ 没有语法错误

---

## ⚠️ 常见警告

### 警告 1: Sass Legacy API

```
Deprecation Warning [legacy-js-api]: The legacy JS API is deprecated
```

**说明**: Sass 正在废弃旧的 JS API，将来会使用新的 API。

**影响**: 目前不影响使用，但将来需要更新。

**解决**: 暂时可以忽略，等待 `sass` 包更新。

---

### 警告 2: Sass @import

```
Deprecation Warning [import]: Sass @import rules are deprecated
```

**说明**: Sass 推荐使用 `@use` 和 `@forward` 替代 `@import`。

**影响**: 目前不影响使用。

**解决**: 
```scss
// 旧写法
@import "grid";

// 新写法
@use "grid";
```

---

### 警告 3: Terser 配置

```
build.terserOptions is specified but build.minify is not set to use Terser
```

**说明**: Vite 默认使用 esbuild 压缩，但配置了 terserOptions。

**影响**: terserOptions 不会生效。

**解决**: 
```javascript
build: {
  minify: 'terser',  // 显式指定使用 terser
  terserOptions: { ... }
}
```

---

### 警告 4: 旧的 Flexbox 语法

```
You should write display: flex by final spec instead of display: box
```

**说明**: 使用了旧的 flexbox 语法（为了兼容旧浏览器）。

**影响**: 不影响功能，只是建议更新语法。

**解决**: 如果不需要兼容很旧的浏览器，可以只使用现代语法：
```css
/* 旧语法 */
display: box;
display: -webkit-box;

/* 现代语法 */
display: flex;
```

---

## 🛠️ 调试技巧

### 1. 使用开发模式

```bash
npm run dev
```

开发模式会：
- 生成 source map
- 不压缩代码
- 输出详细日志

### 2. 查看构建产物

```bash
# 查看文件列表
ls -la dist/js/

# 查看文件内容
cat dist/js/app.js
```

### 3. 测试特定文件

临时修改 `vite.config.js`，只构建一个文件：
```javascript
input: {
  app: resolve(__dirname, 'src/js/common.js')
}
```

### 4. 使用浏览器调试

```bash
npm run serve
# 访问 http://localhost:3000
# 打开浏览器开发者工具
```

---

## 📝 预防措施

### 1. 版本锁定

在 `package.json` 中使用精确版本：
```json
{
  "vite": "4.5.5",  // 而不是 ^4.5.5
}
```

### 2. 定期更新

```bash
npm outdated
npm update
```

### 3. 使用 .nvmrc

创建 `.nvmrc` 锁定 Node.js 版本：
```
16.20.0
```

### 4. CI/CD 测试

在推送代码前，确保构建成功：
```bash
npm run dev
npm run build
```

---

## 🆘 获取帮助

如果以上方法都无法解决问题：

### 1. 检查 Issue

- [Vite Issues](https://github.com/vitejs/vite/issues)
- [vite-plugin-vue2 Issues](https://github.com/underfin/vite-plugin-vue2/issues)

### 2. 查看日志

```bash
npm run dev > build.log 2>&1
```

### 3. 提交 Issue

提供以下信息：
- Node.js 版本：`node --version`
- NPM 版本：`npm --version`
- 操作系统
- 完整错误日志
- `package.json` 内容
- `vite.config.js` 内容

### 4. 联系作者

访问 [作者博客](https://klauslaura.cn) 留言求助。

---

## 📚 相关资源

- [Vite 官方文档](https://vitejs.dev/)
- [Vite 故障排除](https://vitejs.dev/guide/troubleshooting.html)
- [vite-plugin-vue2 文档](https://github.com/underfin/vite-plugin-vue2)
- [Rollup 文档](https://rollupjs.org/)

---

**最后更新**: 2025-10-09  
**Vite 版本**: 4.5.5  
**项目版本**: 2.3.5 beta

---

MIT License © [KlausChan](https://klauslaura.cn)

