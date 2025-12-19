# KlausLab 主题 - 快速开始指南

欢迎使用 KlausLab WordPress 主题！本指南将帮助您快速上手。

## 📚 文档导航

- **[STRUCTURE.md](./STRUCTURE.md)** - 完整的项目组织结构说明
- **[MIGRATION.md](./MIGRATION.md)** - 从 Gulp 迁移到 Vite 的详细指南
- **[VITE_GUIDE.md](./VITE_GUIDE.md)** - Vite 配置详细说明
- **[README.md](./README.md)** - 项目介绍和使用说明

---

## 🚀 快速开始（5 分钟）

### 前置要求

- **Node.js**: >= 16.0.0
- **NPM**: >= 7.0.0
- **PHP**: >= 7.0
- **WordPress**: >= 5.0

### 第一步：克隆项目

```bash
cd /path/to/wordpress/wp-content/themes/
git clone https://github.com/KlausChan03/klauslab.git
cd klauslab
```

### 第二步：安装依赖

```bash
npm install
```

### 第三步：配置路径

编辑 `config.js` 文件（如果不存在则创建）：

```javascript
module.exports = {
  local: '/path/to/wordpress/wp-content/themes/klauslab/',
  production: '/path/to/production/wp-content/themes/klauslab/'
}
```

> **提示**: 如果只是本地开发，`production` 可以留空。

### 第四步：构建主题

```bash
# 开发环境（保留 source map，方便调试）
npm run dev

# 生产环境（代码压缩优化）
npm run build
```

### 第五步：激活主题

1. 登录 WordPress 后台
2. 进入 **外观 > 主题**
3. 找到 **KlausLab** 主题并激活

---

## 🛠️ 开发工作流

### 日常开发

```bash
# 1. 修改源代码
# 编辑 src/ 目录下的文件

# 2. 重新构建
npm run dev

# 3. 刷新浏览器查看效果
```

### 使用开发服务器（可选）

```bash
# 启动 Vite 开发服务器（支持热更新）
npm run serve

# 访问 http://localhost:3000
```

> **注意**: 开发服务器主要用于调试前端资源，WordPress 仍需单独运行。

### 生产部署

```bash
# 1. 构建生产版本
npm run build

# 2. 上传整个主题目录到服务器
# 或使用 Git 部署

# 3. 在服务器上激活主题
```

---

## 📁 项目结构速览

```
klauslab/
├── src/                   # 源代码目录
│   ├── js/                # JavaScript 源文件
│   │   ├── common.js      # 主入口文件
│   │   ├── page/          # 页面级 JS
│   │   ├── component/     # Vue 组件
│   │   └── ...
│   ├── css/               # 样式源文件
│   │   ├── app.scss       # 主样式入口
│   │   └── ...
│   ├── img/               # 图片资源
│   ├── fonts/             # 字体文件
│   └── emoji/             # 表情包
│
├── dist/                  # 构建输出目录（自动生成）
│   ├── js/                # 编译后的 JS
│   ├── css/               # 编译后的 CSS
│   └── ...
│
├── part-function/         # PHP 功能模块
├── part-page/             # 页面模板
├── part-template/         # 内容模板
├── part-widget/           # 小工具
├── cs-framework/          # 后台配置框架
├── inc/                   # 扩展功能
│
├── functions.php          # 主题核心功能
├── index.php              # 首页模板
├── single.php             # 单篇文章模板
├── page.php               # 页面模板
├── header.php             # 头部模板
├── footer.php             # 底部模板
├── sidebar.php            # 侧边栏模板
│
├── vite.config.js         # Vite 配置（新）
├── gulpfile.js            # Gulp 配置（已废弃）
├── package.json           # NPM 依赖配置
└── config.js              # 构建路径配置
```

---

## 💡 常用命令

### NPM 脚本

| 命令 | 说明 |
|------|------|
| `npm install` | 安装依赖 |
| `npm run dev` | 开发环境构建 |
| `npm run build` | 生产环境构建 |
| `npm run prod` | 生产环境构建（同 build） |
| `npm run serve` | 启动开发服务器 |
| `npm run preview` | 预览生产构建 |

### Git 命令

```bash
# 查看状态
git status

# 提交更改
git add .
git commit -m "描述您的更改"

# 推送到远程
git push origin main
```

---

## 🎨 定制主题

### 修改样式

1. 编辑 `src/css/` 目录下的 SCSS 文件
2. 运行 `npm run dev` 重新构建
3. 刷新浏览器查看效果

```scss
// src/css/app.scss
.my-custom-class {
  color: #ff0000;
  font-size: 16px;
}
```

### 添加新页面

1. 在 `part-page/` 创建新模板：

```php
<?php
/*
Template Name: 我的自定义页面
*/
get_header();
?>

<div class="custom-page">
  <h1>自定义页面</h1>
  <!-- 您的内容 -->
</div>

<?php get_footer(); ?>
```

2. 在 WordPress 后台创建新页面
3. 选择 "我的自定义页面" 模板

### 添加新功能

在 `part-function/` 目录创建新的 PHP 文件，会自动加载：

```php
<?php
// part-function/my-custom-function.php

function my_custom_function() {
  // 您的代码
}
add_action('wp_footer', 'my_custom_function');
```

---

## 🐛 常见问题

### Q1: 安装依赖时出错？

**解决方案**:
```bash
# 清除缓存
npm cache clean --force

# 删除 node_modules
rm -rf node_modules package-lock.json

# 重新安装
npm install
```

### Q2: 构建后样式没有生效？

**检查清单**:
- ✅ 是否运行了构建命令？
- ✅ 是否清除了浏览器缓存？
- ✅ `config.js` 路径是否正确？
- ✅ WordPress 是否正确加载了 CSS 文件？

### Q3: JavaScript 报错？

**调试步骤**:
1. 打开浏览器开发者工具（F12）
2. 查看 Console 标签页的错误信息
3. 使用 `npm run dev` 生成 source map
4. 根据错误信息定位问题

### Q4: 图片不显示？

**解决方案**:
- 检查图片路径是否正确
- 确保图片文件存在于 `src/img/` 目录
- 运行构建命令复制图片到 `dist/img/`

### Q5: 主题后台配置不显示？

**解决方案**:
- 确保 `cs-framework/` 目录完整
- 检查 `functions.php` 是否正确引入框架

---

## 📖 深入学习

### 推荐阅读顺序

1. **新手**: README.md → QUICKSTART.md（本文档）
2. **开发者**: STRUCTURE.md → VITE_GUIDE.md
3. **迁移者**: MIGRATION.md

### 学习资源

#### WordPress 开发

- [WordPress 官方文档](https://developer.wordpress.org/)
- [WordPress 主题开发手册](https://developer.wordpress.org/themes/)
- [WordPress 模板层次](https://developer.wordpress.org/themes/basics/template-hierarchy/)

#### 前端技术

- [Vue.js 2.x 文档](https://v2.vuejs.org/)
- [Element UI 文档](https://element.eleme.io/)
- [SCSS/Sass 文档](https://sass-lang.com/)
- [Vite 官方文档](https://vitejs.dev/)

#### 构建工具

- [Vite 中文文档](https://cn.vitejs.dev/)
- [Rollup 文档](https://rollupjs.org/)
- [PostCSS 插件](https://github.com/postcss/postcss)

---

## 🤝 获取帮助

### 遇到问题？

1. **查看文档**: 先查阅相关文档，大部分问题都有答案
2. **搜索 Issues**: 在 GitHub 仓库搜索类似问题
3. **提交 Issue**: 如果是新问题，提交详细的 Issue
4. **联系作者**: 访问[作者博客](https://klauslaura.cn)留言

### 提交 Issue 的最佳实践

提供以下信息：
- **环境信息**: Node.js 版本、NPM 版本、操作系统
- **问题描述**: 详细描述问题和预期行为
- **复现步骤**: 如何重现问题
- **错误信息**: 完整的错误日志
- **相关代码**: 有问题的代码片段

---

## 🌟 贡献代码

欢迎贡献代码！请遵循以下步骤：

### 贡献流程

1. **Fork 仓库**
   ```bash
   # 在 GitHub 上点击 Fork 按钮
   ```

2. **克隆您的 Fork**
   ```bash
   git clone https://github.com/your-username/klauslab.git
   cd klauslab
   ```

3. **创建特性分支**
   ```bash
   git checkout -b feature/amazing-feature
   ```

4. **开发和测试**
   ```bash
   # 修改代码
   npm run dev
   # 测试功能
   ```

5. **提交更改**
   ```bash
   git add .
   git commit -m "Add: 新增某某功能"
   ```

6. **推送到您的 Fork**
   ```bash
   git push origin feature/amazing-feature
   ```

7. **创建 Pull Request**
   - 在 GitHub 上打开您的 Fork
   - 点击 "New Pull Request"
   - 描述您的更改

### 提交信息规范

```
类型: 简短描述

详细说明（可选）

相关 Issue: #123
```

**类型**:
- `Add`: 新增功能
- `Fix`: 修复 Bug
- `Update`: 更新功能
- `Refactor`: 重构代码
- `Style`: 样式调整
- `Docs`: 文档更新
- `Chore`: 构建/工具更新

### 代码规范

- **JavaScript**: 使用 ES6+ 语法
- **CSS**: 使用 SCSS，遵循 BEM 命名
- **PHP**: 遵循 WordPress 编码规范
- **注释**: 为复杂逻辑添加注释

---

## 📝 版本历史

查看 [CHANGELOG.md](./CHANGELOG.md) 了解版本更新历史。

**当前版本**: 2.3.5 beta

---

## 📄 许可证

MIT License © [KlausChan](https://klauslaura.cn)

---

## 🔗 相关链接

- **GitHub 仓库**: https://github.com/KlausChan03/klauslab
- **作者博客**: https://klauslaura.cn
- **在线演示**: https://klauslaura.cn

---

## 💬 社区

- **GitHub Discussions**: 讨论功能和想法
- **GitHub Issues**: 报告 Bug 和请求功能
- **作者博客**: 留言交流

---

**开始构建您的精彩主题吧！** 🎉

如有任何问题，随时查阅文档或联系作者。祝您开发愉快！

---

**最后更新**: 2025-10-09

