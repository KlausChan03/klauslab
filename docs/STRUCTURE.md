# KlausLab WordPress 主题 - 组织结构说明文档

## 项目概述

KlausLab 是一个现代化的 WordPress 主题，使用 Vue.js + Element UI 构建前端界面，采用工程化方式管理前端资源。

**版本**: 2.3.5 beta  
**作者**: KlausChan  
**主页**: https://klauslaura.cn

---

## 目录结构

### 一、根目录文件

```
klauslab/
├── index.php              # WordPress 主题主文件（首页模板）
├── functions.php          # WordPress 主题核心功能文件
├── style.css              # WordPress 主题样式定义文件（必需）
├── header.php             # 网站头部模板
├── footer.php             # 网站底部模板
├── sidebar.php            # 侧边栏模板
├── page.php               # 页面模板
├── single.php             # 单篇文章模板
├── 404.php                # 404 错误页面模板
├── screenshot.png         # 主题预览图
├── README.md              # 项目说明文档
├── CHANGELOG.md           # 版本变更日志
├── LICENSE                # 开源协议
├── config.js              # 构建配置文件（本地/生产路径）
├── gulpfile.js            # Gulp 构建配置（旧）
├── package.json           # NPM 依赖配置
└── package-lock.json      # NPM 依赖锁定文件
```

---

## 二、核心目录详解

### 1. `/src/` - 源代码目录

所有前端开发代码的源文件存放位置。

#### 1.1 `/src/js/` - JavaScript 源文件

```
src/js/
├── common.js              # 全局公共 JS 代码（主入口）
├── utils.js               # 工具函数库
├── flexible.js            # 移动端适配方案
├── canvas.js              # Canvas 特效相关
├── login.js               # 登录页面脚本
│
├── component/             # Vue 组件
│   ├── articleItem.js     # 文章列表项组件
│   ├── chatItem.js        # 评论项组件
│   ├── empty.js           # 空状态组件
│   ├── quickComment.js    # 快速评论组件
│   ├── quickCommentItem.js # 评论列表项组件
│   ├── reward.js          # 打赏组件
│   ├── search.js          # 搜索组件
│   └── skeleton.js        # 骨架屏组件
│
├── page/                  # 页面级 JS
│   ├── index.js           # 首页逻辑
│   ├── post.js            # 文章列表页逻辑
│   ├── single.js          # 文章详情页逻辑
│   └── sideBar.js         # 侧边栏逻辑
│
├── mixin/                 # Vue Mixins
│   ├── filterMixin.js     # 筛选功能混入
│   └── pageMixin.js       # 分页功能混入
│
├── plugin/                # 第三方插件扩展
│   ├── catalog.js         # 目录生成插件
│   ├── fileUtil.js        # 文件工具
│   ├── localizedFormat.js # 日期本地化格式
│   ├── relativeTime.js    # 相对时间
│   ├── utc.js             # UTC 时间处理
│   └── zh-cn.js           # 中文语言包
│
└── lib/                   # 第三方库
    ├── vue.min.js         # Vue.js 核心库
    ├── vue.dev.min.js     # Vue.js 开发版
    ├── petite-vue.js      # 轻量级 Vue
    ├── element-ui.min.js  # Element UI 组件库
    ├── axios.min.js       # HTTP 请求库
    ├── jquery-3.1.1.min.js # jQuery 库
    ├── dayjs.min.js       # 日期处理库
    ├── lodash.min.js      # 工具函数库
    ├── tinymce-vue.min.js # TinyMCE 编辑器 Vue 集成
    └── exif.js            # 图片 EXIF 信息读取
```

#### 1.2 `/src/css/` - 样式源文件

```
src/css/
├── app.scss               # 主样式入口文件
├── style.scss             # 主题样式
├── reset.css              # CSS 重置样式
├── main.css               # 主样式文件
├── compoment.scss         # 组件样式
├── grid.scss              # 网格布局系统
├── loading.scss           # 加载动画样式
├── element-ui.min.css     # Element UI 样式
├── element-ui-extra.scss  # Element UI 扩展样式
├── animate.min.css        # 动画库
├── catalog.css            # 目录样式
├── detail.css             # 详情页样式
├── support.css            # 兼容性样式
├── lalaksks21.css         # 特殊样式
│
└── page/                  # 页面样式
    ├── about.css          # 关于页面
    ├── archive.css        # 归档页面
    ├── index.css          # 首页
    ├── login.css          # 登录页
    └── single.css         # 单篇文章页
```

#### 1.3 `/src/img/` - 图片资源

```
src/img/
├── bg-*.jpg/png           # 背景图片（普通、圣诞、登录等）
├── pay_for_me_*.png       # 支付二维码（支付宝、微信）
├── login_*.png            # 登录页表情图标
├── qqmusic.png            # QQ 音乐图标
├── wangyimusic.png        # 网易云音乐图标
├── empty.svg              # 空状态图标
└── ...                    # 其他图片资源
```

#### 1.4 `/src/fonts/` - 字体文件

```
src/fonts/
├── element-icons.*        # Element UI 图标字体
├── fontawesome-webfont.*  # FontAwesome 图标字体
├── FontAwesome.otf        # FontAwesome 字体文件
└── font-awesome.css       # FontAwesome 样式
```

#### 1.5 `/src/emoji/` - 表情包资源

```
src/emoji/
├── OwO.min.json           # 表情配置文件
├── alu/                   # 阿鲁表情包（124 个 PNG）
└── paopao/                # 泡泡表情包（76 个 PNG）
```

#### 1.6 `/src/json/` - JSON 数据文件

```
src/json/
└── one.json               # 一句话配置文件
```

---

### 2. `/dist/` - 构建输出目录

Gulp/Vite 构建后的生产环境文件，**此目录不应提交到版本控制**。

```
dist/
├── js/                    # 编译压缩后的 JS 文件
├── css/                   # 编译压缩后的 CSS 文件
├── scss/                  # 编译后的 SCSS 文件
├── img/                   # 优化后的图片
├── fonts/                 # 字体文件（复制）
├── emoji/                 # 表情文件（复制）
└── json/                  # JSON 文件（复制）
```

---

### 3. `/part-function/` - PHP 功能模块

主题核心 PHP 功能的模块化拆分。

```
part-function/
├── function-main.php      # 主要功能函数
├── function-page.php      # 页面相关功能
├── function-widget.php    # 小工具功能
├── function-api.php       # API 接口功能
└── functions-layout.php   # 布局相关功能
```

**自动加载机制**: `functions.php` 会自动加载此目录下所有 PHP 文件。

---

### 4. `/part-page/` - 页面模板

自定义页面模板文件。

```
part-page/
├── page-about.php         # 关于页面模板
├── page-archive.php       # 归档页面模板
├── page-links.php         # 友链页面模板
├── page-movie.php         # 观影记录页面模板
└── page-post-simple.php   # 简洁文章列表模板
```

**使用方式**: 在 WordPress 后台创建页面时选择相应模板。

---

### 5. `/part-template/` - 内容模板片段

WordPress 内容循环模板。

```
part-template/
├── content.php            # 默认文章内容模板
├── content-single.php     # 单篇文章内容模板
├── content-page.php       # 页面内容模板
├── content-search.php     # 搜索结果内容模板
└── content-none.php       # 无内容时的模板
```

**调用方式**: 通过 `get_template_part()` 函数调用。

---

### 6. `/part-widget/` - WordPress 小工具

自定义侧边栏小工具。

```
part-widget/
├── widget-win-win.js                     # Win-Win 小工具
├── widget-with-settings-posts-list.php   # 文章列表小工具
├── widget-with-settings-recent-comments.php  # 最近评论小工具
├── widget-with-settings-recent-photos.php    # 最近照片小工具
└── widget-with-settings-recent-visitors.php  # 最近访客小工具
```

---

### 7. `/cs-framework/` - Codestar 后台框架

第三方后台配置框架，用于主题选项管理。

```
cs-framework/
├── cs-framework.php       # 框架入口文件
├── cs-framework-path.php  # 路径配置
│
├── classes/               # 核心类
│   ├── framework.class.php    # 框架基类
│   ├── options.class.php      # 选项处理类
│   ├── metabox.class.php      # 元数据盒子类
│   ├── customize.class.php    # 自定义器类
│   ├── taxonomy.class.php     # 分类法类
│   ├── shortcode.class.php    # 短代码类
│   └── abstract.class.php     # 抽象类
│
├── config/                # 配置文件
│   ├── framework.config.php   # 框架配置
│   ├── metabox.config.php     # 元数据盒子配置
│   ├── customize.config.php   # 自定义器配置
│   ├── shortcode.config.php   # 短代码配置
│   └── taxonomy.config.php    # 分类法配置
│
├── fields/                # 表单字段类型
│   ├── text/              # 文本框
│   ├── textarea/          # 文本域
│   ├── checkbox/          # 复选框
│   ├── radio/             # 单选框
│   ├── select/            # 下拉选择
│   ├── color_picker/      # 颜色选择器
│   ├── image/             # 图片上传
│   ├── gallery/           # 图库
│   ├── upload/            # 文件上传
│   ├── wysiwyg/           # 富文本编辑器
│   ├── switcher/          # 开关
│   ├── number/            # 数字输入
│   ├── icon/              # 图标选择
│   ├── typography/        # 字体排版
│   ├── background/        # 背景设置
│   ├── sorter/            # 排序器
│   ├── group/             # 分组
│   ├── fieldset/          # 字段集
│   ├── backup/            # 备份恢复
│   ├── heading/           # 标题
│   ├── subheading/        # 副标题
│   ├── notice/            # 通知
│   ├── content/           # 内容
│   └── image_select/      # 图片选择
│
├── functions/             # 工具函数
│   ├── helpers.php        # 辅助函数
│   ├── actions.php        # 动作钩子
│   ├── sanitize.php       # 数据净化
│   ├── validate.php       # 数据验证
│   ├── enqueue.php        # 资源加载
│   ├── customize.php      # 自定义器函数
│   ├── deprecated.php     # 废弃函数
│   └── fallback.php       # 后备函数
│
├── assets/                # 框架资源
│   ├── css/               # CSS 样式文件
│   ├── js/                # JavaScript 文件
│   ├── images/            # 图片资源
│   ├── fonts/             # 字体文件
│   └── scss/              # SCSS 源文件
│
└── languages/             # 多语言文件
    ├── zh_CN.po/mo        # 简体中文
    ├── fa_IR.po/mo        # 波斯语
    ├── tr_TR.po/mo        # 土耳其语
    ├── ar.po/mo           # 阿拉伯语
    ├── pt_BR.po/mo        # 葡萄牙语（巴西）
    ├── ro_RO.po/mo        # 罗马尼亚语
    ├── bn_BD.po/mo        # 孟加拉语
    └── cs-framework.pot   # 模板文件
```

---

### 8. `/inc/` - 主题扩展功能

```
inc/
├── about/                 # 关于页面数据
│   └── aboutme.json       # 个人信息 JSON
│
└── douban/                # 豆瓣观影记录功能
    ├── douban.php         # 豆瓣功能主文件
    ├── parseDom.php       # DOM 解析
    ├── simple_html_dom.php # HTML DOM 解析库
    └── cache/             # 豆瓣数据缓存目录
```

---

### 9. `/languages/` - 主题多语言

```
languages/
├── en.po                  # 英文翻译
└── en.mo                  # 英文翻译（编译后）
```

---

## 三、技术栈

### 前端技术

| 技术 | 用途 |
|------|------|
| **Vue.js** | 前端框架，负责页面交互 |
| **Element UI** | UI 组件库 |
| **Axios** | HTTP 请求库 |
| **Day.js** | 日期时间处理 |
| **jQuery** | DOM 操作和兼容性处理 |
| **Lodash** | 工具函数库 |
| **SCSS/Sass** | CSS 预处理器 |
| **TinyMCE** | 富文本编辑器（文章编辑） |

### 构建工具

| 工具 | 用途 |
|------|------|
| **Gulp** (当前) | 任务自动化、资源打包 |
| **Vite** (待迁移) | 新一代前端构建工具 |
| **Babel** | ES6+ 转译 |
| **Sass** | SCSS 编译 |
| **PostCSS** | CSS 后处理（自动前缀、压缩） |
| **Imagemin** | 图片优化 |

### 后端技术

| 技术 | 用途 |
|------|------|
| **PHP** | WordPress 主题开发语言 |
| **WordPress** | CMS 内容管理系统 |
| **Codestar Framework** | 主题选项后台框架 |

---

## 四、工作流程

### 开发流程

1. **源代码编辑**: 在 `/src/` 目录下修改 JS、CSS、图片等
2. **构建编译**: 
   - 开发环境: `npm run dev` (使用 `src` 目录)
   - 生产环境: `npm run prod` (使用 `dist` 目录)
3. **自动处理**:
   - SCSS 编译为 CSS
   - ES6+ 转译为 ES5
   - CSS/JS 压缩
   - 图片优化
   - 文件复制

### 目录路径切换

主题通过 `functions.php` 中的环境变量 `FE_ENV` 控制资源路径：

```php
if (FE_ENV !== "Development") {
  define('KL_THEME_DIR', get_template_directory() . '/dist');  // 生产环境
  define('KL_THEME_URI', get_template_directory_uri() . '/dist');
} else {
  define('KL_THEME_DIR', get_template_directory() . '/src');   // 开发环境
  define('KL_THEME_URI', get_template_directory_uri() . '/src');
}
```

---

## 五、关键功能模块

### 1. 首页 (index.php)
- Vue 驱动的文章列表
- 说说（动态）展示
- 瞬间功能
- 文章列表懒加载

### 2. 文章详情 (single.php)
- 文章内容渲染
- 评论系统（支持未登录用户）
- 文章编辑功能
- 图片预览
- 打赏功能
- 目录自动生成
- 字数统计和阅读时长

### 3. 页面模板
- **关于页面**: 个人简介、版本信息、项目展示
- **归档页面**: 文章归档列表
- **友链页面**: 友情链接
- **观影记录**: 豆瓣观影同步

### 4. 侧边栏小工具
- 最近文章
- 最近评论
- 最近照片
- 最近访客

### 5. 评论系统
- 支持表情包（阿鲁、泡泡）
- 支持未登录用户评论
- VIP 等级制度
- 快速评论

### 6. 后台配置
- 基于 Codestar Framework
- 主题选项配置
- 元数据盒子
- 自定义器

---

## 六、部署说明

### 开发环境配置

1. **克隆项目**
   ```bash
   git clone https://github.com/KlausChan03/klauslab.git
   cd klauslab
   ```

2. **安装依赖**
   ```bash
   npm install
   ```

3. **配置路径** (编辑 `config.js`)
   ```javascript
   module.exports = {
     local: '/path/to/wordpress/wp-content/themes/klauslab/',
     production: '/path/to/production/wordpress/wp-content/themes/klauslab/'
   }
   ```

4. **运行构建**
   ```bash
   npm run dev    # 开发环境
   npm run prod   # 生产环境
   ```

### 生产环境部署

1. 执行 `npm run prod` 生成 `dist` 目录
2. 将整个主题目录上传到 WordPress 的 `wp-content/themes/` 目录
3. 在 WordPress 后台激活主题

---

## 七、注意事项

### 文件权限
- 确保 `/inc/douban/cache/` 目录可写（豆瓣缓存）
- 确保 WordPress 上传目录可写

### 依赖要求
- **Node.js**: >= 12.x
- **NPM**: >= 6.x
- **PHP**: >= 7.0
- **WordPress**: >= 5.0

### 浏览器兼容性
- Chrome (最新 2 个版本)
- Firefox (最新 2 个版本)
- Safari (最新 2 个版本)
- Edge (最新 2 个版本)
- IE: 不支持

### 第三方服务
- **Gravatar**: 头像服务（已配置国内镜像）
- **豆瓣**: 观影记录同步（可选）

---

## 八、开发建议

### 代码规范
- **JavaScript**: ES6+ 语法，使用 Babel 转译
- **CSS**: 使用 SCSS，遵循 BEM 命名规范
- **PHP**: 遵循 WordPress 编码规范

### 新增功能
1. **新增页面模板**: 在 `/part-page/` 创建 PHP 文件
2. **新增 JS 功能**: 在 `/src/js/` 相应目录创建文件
3. **新增样式**: 在 `/src/css/` 相应位置创建 SCSS 文件
4. **新增小工具**: 在 `/part-widget/` 创建 PHP 文件

### 调试技巧
- 开启 WordPress 调试模式: `define('WP_DEBUG', true);`
- 使用浏览器开发者工具查看前端错误
- 查看 PHP 错误日志

---

## 九、常见问题

### Q1: 修改了 JS/CSS 为什么没生效？
**A**: 需要运行 `npm run dev` 或 `npm run prod` 重新构建。

### Q2: 图片不显示？
**A**: 检查 `config.js` 中的路径配置是否正确。

### Q3: 样式错乱？
**A**: 清除浏览器缓存，检查是否正确加载了 CSS 文件。

### Q4: 评论表情不显示？
**A**: 确保 `/src/emoji/` 目录及其内容正确复制到 `/dist/` 目录。

---

## 十、贡献指南

如果您想为 KlausLab 主题贡献代码：

1. Fork 本仓库
2. 创建特性分支 (`git checkout -b feature/AmazingFeature`)
3. 提交更改 (`git commit -m 'Add some AmazingFeature'`)
4. 推送到分支 (`git push origin feature/AmazingFeature`)
5. 开启 Pull Request

---

## 十一、许可证

MIT License © [KlausChan](https://klauslaura.cn)

---

## 联系方式

- **作者**: KlausChan
- **博客**: https://klauslaura.cn
- **GitHub**: https://github.com/KlausChan03/klauslab

---

**最后更新**: 2025-10-09

