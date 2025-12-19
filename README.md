## Wordpress Theme KlausLab

[![Version](https://img.shields.io/badge/version-2.3.5_beta-green.svg?style=flat-square)]()
[![Author](https://img.shields.io/badge/author-KlausChan-blue.svg?style=flat-square)](https://klauslaura.cn)
[![GitHub stars](https://img.shields.io/github/stars/KlausChan03/klauslab.svg?style=social)](https://github.com/KlausChan03/klauslab/stargazers)
[![GitHub forks](https://img.shields.io/github/forks/KlausChan03/klauslab.svg?style=social)](https://github.com/KlausChan03/klauslab/network/members)

# Info

- Theme Name: KlausLab
- Theme URI: [https://github.com/KlausChan03/klauslab](https://github.com/KlausChan03/klauslab)
- Description: Theme KlausLab by KlausChan (the free version)
- Version: 2.3.5_beta
- Author: KlausChan
- Author URI: [https://klauslaura.cn](https://klauslaura.cn)

# Use

## 安装步骤

1. 获取稳定版本分支的代码，放置在 `wordpress` 项目的 `themes` 目录下
2. 安装依赖：
   ```bash
   npm install
   ```
3. 配置构建路径（编辑 `config.js`）：
   ```javascript
   module.exports = {
     local: '/your/local/wordpress/wp-content/themes/klauslab/',
     production: '/your/production/wordpress/wp-content/themes/klauslab/'
   }
   ```

## 构建命令

### Vite 构建方式（推荐）

- **开发环境构建**：
  ```bash
  npm run dev
  ```
  
- **生产环境构建**：
  ```bash
  npm run build
  # 或
  npm run prod
  ```

- **开发服务器**（可选）：
  ```bash
  npm run serve
  ```

- **预览生产构建**：
  ```bash
  npm run preview
  ```

### Gulp 构建方式（已废弃，保留兼容）

如果需要使用旧的 Gulp 构建方式：
```bash
npm run gulp:dev   # 开发环境
npm run gulp:prod  # 生产环境
```

**注意**：Gulp 方式已不再维护，建议迁移到 Vite 构建。

## 说明

- 打包后的 `dist` 目录即为静态资源输出目录
- 开发环境会生成 source map 用于调试
- 生产环境会自动压缩、优化代码
- 项目目前仅为个人开源主题，没有推广或者商用
- 建议使用者最好具备 Node.js 及相关 PHP 知识储备
- 如若遇到问题，建议通过 GitHub 或者[作者博客](https://klauslaura.cn)咨询作者

## 技术栈

- **构建工具**: Vite 5.x
- **前端框架**: Vue 2.x
- **UI 组件库**: Element UI
- **CSS 预处理器**: SCSS/Sass
- **浏览器兼容**: 最新 2 个版本，> 2%

## 详细文档

查看 [STRUCTURE.md](./STRUCTURE.md) 了解完整的项目组织结构说明。

# View

![screenshot](https://github.com/KlausChan03/klauslab/blob/develop/screenshot.png)

# Version

## [2.3.6] - 2021/10/22

#### feat:

- 全局开放loading动画。
- header头像改版。
- 首页列表添加图片懒加载和加载失败显示。
- 更新趋势 - 简化代码，提高速度。

#### fix:

- 修复若干 bug。

## [2.3.5_beta] - 2021/09/03

#### feat:

- 新增文章插入标签功能。

#### fix:

- 修复若干 bug。

## [2.3.4_beta] - 2021/07/22

#### feat:

- 新增文章编辑功能，待海量测试以便后续优化。
- 优化后重新上线博主的社交信息。

#### fix:

- 修复若干 bug。

## [2.3.3_beta] - 2021/06/15

#### feat:

- 新增文章详情页字数统计和阅读时长功能。封装打赏组件。
- 新增图片预览功能。
- 新增评论 placeholder 属性的'一句'。
- 使用 mixin 封装 page 的公共方法。

## [2.3.2_beta] - 2021/06/09

#### feat:

- 继续优化'瞬间'的展示效果，引入'最近访客'小组件"。

## [2.3.1_beta] - 2021/06/03

#### feat:

- 优化'瞬间'发布操作流程及渲染效果，用以简化使用，进行开放测试。
- 新增'关于'页面'主题版本'和'我的项目'模块。

## [2.3.0] - 2021/05/28

#### feat:

- 重构 Header 模块；
- 发布稳定版本。

## [2.2.0] - 2021/05/25

#### feat:

- 完善评论模块，支持未登录用户发布评论；
- 新增详情页和说说列表预览大图。

## [2.1.0] - 2021/05/18

#### feat:

- 新增'关于'页面，优化评论模块，设为全局使用；

#### fix:

- 修复 Gravatar 造成的阻塞，采用替换 Gravatar 头像镜像为国内源。

## [2.0.0] - Sectum sempra 2021-05-11

### 🎉 使用 Vue + Axios + ElementUI，焕然一新。

#### feat:

- 重写首页，合并了说说页和文章列表页；
- 重写文章详情页；
- 新增快捷发布页。

## [1.5.0] - 2021/01/29

### 🔖 稳定版本，蓄势待发。

#### feat:

- 使用 Gulp 及编写脚本实现工程化；
- 新增分页功能；
- 新增个人和用户侧边栏小工具；
- 更新功能页【Watch，Filter】
- 根据个人审美添加和剔除部分交互效果；

#### fix:

- 修复若干基于 Gulp 打包项目的 Bug；
- 修复基于添加交互效果引发的 Bug。

## [1.4.0] - 2020/01/20

### ♻️ 🔖 调整结构，聚焦核心。

#### feat:

- 重构代码结构；
- 引入 Loading 动画（“无穷大”和“太极”）；
- 新增自制归档功能页【Filter】；
- 新增我的豆瓣观影记录列表页【Watch】。

#### fix:

- 修复若干 Bug。

## [1.3.0] - 2018/12/28

### 🔖 正式孵化出个人主题——KlausLab。

#### feat:

- 自制 kl 系列组件，完成 Button 的设计；
- 更新文章列表页和功能页；
- 更新 UI 搭配颜色；

#### fix:

- 修复部分响应式样式 Bug。

## [1.2.0] - 2018/12/21

### 🔖 借鉴 memory 主题，为个人主题铺垫。

##### feat:

- 新增背景切换悬浮插件；
- 新增文章列表页的置顶，转载标识；
- 开始 UI 规范统一，包括全局颜色，组件样式；
- 引入 vue.js，对部分交互迎新辞旧；
- 引入 cs-framework，按页面（page），插件(widget)，主体(main)拆分 function.php；
- 优化各种功能的 content 模块（content-page，content-none，content.search）。

#### fix:

- 清理 anissa 主题遗留无用代码；
- 修复若干 Bug。

## [1.1.0] - 2018/09/27

### 🔖 基于 anissa 主题进行优化。

#### feat: 

- 优化响应式布局及菜单栏；
- 新增评论区 vip 等级制度功能；
- 在插件局部使用 ajax。

#### fix:

- 修复样式 Bug 及若干 Bug。

## [1.0.0] Reparo - 2018/09/18

### 🎉 开始主题产品的迭代！

#### feat:

- 首次提交，基于 anissa 主题进行二次开发。

MIT © [KlausChan](https://klauslaura.cn)
