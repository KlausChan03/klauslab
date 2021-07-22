<?php

/**
 *  @package KlausLab
 *  Template Name: 快捷发布
 *  Template Post Type: page
 *  author: Klaus
 */
get_header();
?>
<style>
    .post-main {
        position: relative;
    }

    .upload-button {
        /* width: 60px; */
        height: 50px;
        font-size: 18px;

    }

    .commit-button {
        /* width: 112px; */
        height: 50px;
        font-size: 18px;
        /* letter-spacing: 10px; */
    }

    .commit-type {
        height: 60px;
    }
</style>

<div class="post-main" id="post-page" v-block>
    <el-form>
        <div class="post-header flex-hb-vc flex-hw">
            <div class="post-header-left">
                <el-popover placement="bottom" width="400" trigger="click" v-if="format === false">
                    <el-upload ref="upload" class="upload" list-type="picture-card" :limit="1" :on-exceed="handleExceed" :action=`${window.site_url}/wp-json/wp/v2/media` :on-progress="handleUploadBegin" :on-success="handleUploadSuccess" :headers="{'X-WP-Nonce': window._nonce}" multiple>

                        <i slot="default" class="el-icon-plus"></i>
                        <div slot="tip" class="el-upload__tip">文章的背景</em></div>
                        <div slot="file" slot-scope="{file}">
                            <img class="el-upload-list__item-thumbnail" :src="file.url" alt="">
                            <span class="el-upload-list__item-actions">
                                <span class="el-upload-list__item-preview" @click="handlePictureCardPreview(file)">
                                    <i class="el-icon-zoom-in"></i>
                                </span>
                                <span v-if="!disabled" class="el-upload-list__item-delete" @click="handleDownload(file)">
                                    <i class="el-icon-download"></i>
                                </span>
                                <span v-if="!disabled" class="el-upload-list__item-delete" @click="handleRemove(file)">
                                    <i class="el-icon-delete"></i>
                                </span>
                            </span>
                        </div>
                    </el-upload>
                    <el-button class="upload-button mr-10" size="small" slot="reference"><i class="fs-20 el-icon-picture-outline fs-20 mr-10"></i>背景</el-button>
                </el-popover>
                <el-popover placement="bottom" width="400" trigger="click" v-if="format === true">
                    <el-upload ref="upload" class="upload" list-type="picture-card" :limit="9" :on-exceed="handleExceed" :action=`${window.site_url}/wp-json/wp/v2/media` :on-progress="handleUploadBegin" :on-success="handleUploadSuccess" :headers="{'X-WP-Nonce': window._nonce}" multiple>
                        <i slot="default" class="el-icon-plus"></i>
                        <div slot="tip" class="el-upload__tip">瞬间的印象，支持最多九张图</em></div>
                        <div slot="file" slot-scope="{file}">
                            <img class="el-upload-list__item-thumbnail" :src="file.url" alt="">
                            <span class="el-upload-list__item-actions">
                                <span class="el-upload-list__item-preview" @click="handlePictureCardPreview(file)">
                                    <i class="el-icon-zoom-in"></i>
                                </span>
                                <span v-if="!disabled" class="el-upload-list__item-delete" @click="handleDownload(file)">
                                    <i class="el-icon-download"></i>
                                </span>
                                <span v-if="!disabled" class="el-upload-list__item-delete" @click="handleRemove(file)">
                                    <i class="el-icon-delete"></i>
                                </span>
                            </span>
                        </div>
                    </el-upload>
                    <el-button class="upload-button mr-10" size="small" slot="reference"><i class="el-icon-picture-outline fs-20 mr-10"></i>印象</el-button>
                </el-popover>
                <el-tag class="mr-10" size="small" v-for="(item,index) in tagNameList"> {{item}} </el-tag>
                <el-tag type="warning" class="mr-10" size="small" v-for="(item,index) in categoryNameList"> {{item}} </el-tag>
            </div>
            <div class="post-header-right flex-hb-vc">
                <div class="commit-type flex-v flex-ha-vc m-lr-15">
                    <el-switch v-model="format" active-text="瞬间" inactive-text="文章" active-color="#13ce66" @change="changePostType"> </el-switch>
                    <el-switch v-model="status" active-text="正式" inactive-text="草稿" active-color="#13ce66"> </el-switch>
                </div>
                <el-button class="commit-button" size="small" type="primary" @click="commitPost()" :loading="hasCommitFinish">发布</el-button>
            </div>
        </div>
        <el-card class="mt-10" shadow="hover">
            <el-form-item>
                <el-input v-model="posts.title" :placeholder="format === true ? '#话题#' : '标题'"></el-input>
            </el-form-item>
            <!-- <editor :api-key="tinyKey" cloud-channel="5" :disabled=false id="uuid" :setting="{inline: false}" :init="{ height: 360, menubar: true, paste_data_images: true, language: 'zh_CN', file_picker_types: 'file image media' ,images_upload_credentials: true, branding: true, statusbar: true,  }" initial-value="" :inline=false model-events="" 
            plugins="codesample,advlist autolink lists link image charmap print preview anchor, searchreplace visualblocks  fullscreen, insertdatetime media table paste  help wordcount,  code emoticons" tag-name="div" toolbar=" undo redo | formatselect | image media table | emoticons | help " v-model="posts.content" />
            </editor> -->
            <el-form-item v-loading="editorLoading" style="height: 360px">
                <textarea id="editor" v-model="posts.content"></textarea>
            </el-form-item>
        </el-card>
        <el-card class="mt-10" shadow="hover">
            <el-collapse accordion>
                <el-collapse-item>
                    <template slot="title">
                        <span>更多选项</span>
                        <el-tooltip class="item" effect="dark" content="此处为发布的更多非必填选项" placement="top-start">
                            <i class="header-icon el-icon-info ml-5"></i>
                        </el-tooltip>
                    </template>
                    <el-form-item label="置顶">
                        <el-switch v-model="posts.sticky" active-text="是" inactive-text="否"> </el-switch>
                    </el-form-item>
                    <el-form-item label="打赏">
                        <el-switch v-model="posts.post_metas.reward" active-text="是" inactive-text="否"> </el-switch>
                    </el-form-item>
                    <el-form-item label="标签" v-show="!format">
                        <el-select v-model="posts.tags" multiple filterable allow-create default-first-option placeholder="请选择文章标签">
                            <el-option v-for="item in tagList" :key="item.id" :label="item.name" :value="item.id">
                            </el-option>
                        </el-select>
                    </el-form-item>
                    <el-form-item label="分类" v-show="!format">
                        <!-- <el-select v-model="posts.categories" multiple filterable allow-create default-first-option placeholder="请选择文章分类">
                            <el-option v-for="item in categoryList" :key="item.id" :label="item.name" :value="item.id">
                            </el-option>
                        </el-select> -->
                        <el-tree :data="categoryList" show-checkbox check-strictly="true" default-expand-all node-key="id" ref="categoryTree" highlight-current @check-change="handleCheckChange" :props="defaultProps" style="margin-left: 30px">
                        </el-tree>
                    </el-form-item>
                </el-collapse-item>
            </el-collapse>
        </el-card>
        <el-dialog :visible.sync="dialogVisible">
            <img width="100%" :src="dialogImageUrl" alt="">
        </el-dialog>
    </el-form>
</div>
<script src="https://cdn.tiny.cloud/1/7b4pdrcfzcszmsf2gjor1x94mha4srj4jalmdpq94fgpaa6j/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

<script>
    new Vue({
        el: '#post-page',
        components: {
            'editor': Editor, // <- Important part
        },
        computed: {
            tagNameList() {
                let tagNameList = [];
                for (let i = 0; i < this.tagList.length; i++) {
                    for (let j = 0; j < this.posts.tags.length; j++) {
                        if (this.posts.tags[j] === this.tagList[i].id) {
                            tagNameList.push(this.tagList[i].name)
                        }

                    }
                }
                return tagNameList
            },
            categoryNameList() {
                let categoryNameList = [];
                for (let i = 0; i < this.categoryListOrigin.length; i++) {
                    for (let j = 0; j < this.posts.categories.length; j++) {
                        if (this.posts.categories[j] === this.categoryListOrigin[i].id) {
                            categoryNameList.push(this.categoryListOrigin[i].name)
                        }

                    }
                }
                return categoryNameList
            }
        },
        data() {
            const ide = Date.now()
            return {
                // tinyKey: '7b4pdrcfzcszmsf2gjor1x94mha4srj4jalmdpq94fgpaa6j',
                post_id: '',
                editorLoading: false,
                status: true,
                type: 'create',
                format: true,
                posts: {
                    type: 'moments',
                    title: '',
                    content: '',
                    status: 'publish',
                    tags: [],
                    categories: [],
                    post_metas: {
                        reward: true,
                    }

                },
                pictureList: [],
                tagList: [],
                categoryList: [],
                categoryListOrigin: [],
                defaultProps: {
                    children: 'children',
                    label: 'name'
                },
                hasCommitFinish: false,
                dialogImageUrl: '',
                dialogVisible: false,
                disabled: false,
                toolbar_simple: ['undo redo | emoticons'],
                toolbar_default: ['bold italic underline strikethrough blockquote|forecolor backcolor|formatselect | fontsizeselect  | alignleft aligncenter alignright alignjustify | outdent indent |codeformat blockformats| removeformat undo redo bullist numlist toc pastetext | codesample charmap  hr insertdatetime | lists image media table link unlink | emoticons |code searchreplace fullscreen help '],
                defaultInit: {
                    language: "zh_CN", //语言设置
                    height: 360, //高度
                    menubar: false, // 隐藏最上方menu菜单
                    toolbar: true, //false禁用工具栏（隐藏工具栏）
                    browser_spellcheck: true, // 拼写检查
                    branding: false, // 去水印
                    statusbar: false, // 隐藏编辑器底部的状态栏
                    elementpath: false, //禁用下角的当前标签路径
                    paste_data_images: true, // 允许粘贴图像
                    toolbar: ['undo redo | emoticons'],
                    // toolbar:  ['bold italic underline strikethrough blockquote|forecolor backcolor|formatselect | fontsizeselect  | alignleft aligncenter alignright alignjustify | outdent indent |codeformat blockformats| removeformat undo redo bullist numlist toc pastetext | codesample charmap  hr insertdatetime | lists image media table link unlink | emoticons |code searchreplace fullscreen help ' ],
                    plugins: 'emoticons lists image media table wordcount code fullscreen help codesample toc insertdatetime  searchreplace  link charmap paste hr',
                }

            }
        },
        mounted() {
            let urlParams = this.urlToObj(window.location.href)
            if (urlParams.id) {
                this.post_id = urlParams.id
                this.getArticleContent()
                this.type = "update"
            }
            this.getTags()
            this.getCategories()
            this.init()
        },
        methods: {
            getArticleContent() {
                let params = {};
                return axios.get(`${window.site_url}/wp-json/wp/v2/posts/${this.post_id}`, {
                    params: params
                }).then(res => {
                    this.$nextTick(() => {
                        let posts = JSON.parse(JSON.stringify(res.data));
                        for (const key in posts) {
                            if (posts.hasOwnProperty(key)) {
                                const element = posts[key];
                                for (const self in element) {
                                    if (self === 'rendered') {
                                        posts[key] = element[self]
                                    }
                                }                                
                            }
                        }
                        posts.type = posts.type.indexOf('moment') > -1 ? "moments" : "posts"
                        this.format = !!(this.posts.type === "moments" ? false : true)
                        // this.changePostType()
                        this.posts = posts
                        this.posts.categories = posts.categories
                        this.$refs.categoryTree.setCheckedKeys(this.posts.categories)                                
                        this.posts.tags = posts.tags
                        window.tinymce.get('editor').setContent(this.posts.content) 
                    })
                })
            },
            init() {
                const self = this
                self.editorLoading = true
                window.tinymce.init({
                    // 默认配置
                    ...this.defaultInit,
                    // 初始化完成
                    init_instance_callback: function(editor) {
                        self.editorLoading = false
                    },
                    // 图片上传
                    images_upload_handler: function(blobInfo, success, failure) {
                        let formData = new FormData()
                        formData.append('file', blobInfo.blob())
                        axios.post(`${window.site_url}/wp-json/wp/v2/media`, formData, {
                                headers: {
                                    'X-WP-Nonce': window._nonce
                                }
                            })
                            .then(response => {
                                if (response.status == 201) {
                                    success(response.data['source_url'])
                                } else {
                                    failure('上传失败！')
                                }
                            })
                    },
                    // 挂载的DOM对象
                    selector: `#editor`,
                })
            },

            changePostType() {
                window.tinymce.remove()
                this.posts.type = this.format === true ? "moments" : "posts" 
                this.defaultInit.toolbar = this.format ? this.toolbar_simple : this.toolbar_default
                this.init()
            },


            getTags() {
                axios.get(`${window.site_url}/wp-json/wp/v2/tags`).then(res => {
                    this.tagList = res.data
                })
            },
            getCategories() {
                axios.get(`${window.site_url}/wp-json/wp/v2/categories`).then(res => {
                    this.categoryListOrigin = res.data
                    this.categoryList = transData(res.data, 'id', 'parent', 'children')
                })
            },
            handleExceed(files, fileList) {
                this.$message.warning(`当前限制选择 1 个特色图像，本次选择了 ${files.length} 个文件`);
            },
            handleUploadBegin() {
                this.hasCommitFinish = true
            },
            handleUploadSuccess(res, file) {
                if (this.posts.type === "moments") {
                    this.pictureList.push({
                        id: res.id,
                        dom: res.description.rendered
                    })
                } else {
                    this.posts.featured_media = res.id

                }
                this.hasCommitFinish = false
            },
            handleCheckChange(data, checked, indeterminate) {
                this.posts.categories = this.$refs.categoryTree.getCheckedKeys()
            },
            handleRemove(file, fileList) {
                this.$refs.upload.handleRemove(file)
                if (this.posts.type === "posts") {
                    for (let index = 0; index < this.pictureList.length; index++) {
                        const element = array[index];
                        if (Number(element.id) === Number(file.response.id)) {
                            this.pictureList = this.pictureList.splice(index, 1)
                        }
                    }
                } else {
                    this.posts.featured_media = ''

                }
            },
            handlePictureCardPreview(file) {
                this.dialogImageUrl = file.url;
                this.dialogVisible = true;
            },
            handleDownload(file) {},

            urlToObj(str) {
                var obj = {};
                var arr1 = str.split("?");
                var arr2 = arr1[1].split("&");
                for (var i = 0; i < arr2.length; i++) {
                    var res = arr2[i].split("=");
                    obj[res[0]] = res[1];
                }
                return obj;
            },

            commitPost() {
                this.hasCommitFinish = true
                this.posts.status = this.status === true ? 'publish' : 'draft'
                this.posts.content = window.tinymce.get('editor').getContent()
                this.posts.post_metas = []
                for (const key in this.posts.post_metas) {
                    if (this.posts.post_metas.hasOwnProperty(key)) {
                        const element = this.posts.post_metas[key];
                        this.posts.post_metas.push({
                            'key': key,
                            'value': element === true ? '1' : '0'
                        })
                    }
                }
                if (this.posts.type === 'moments') {
                    let imgDom = ''
                    for (let index = 0; index < this.pictureList.length; index++) {
                        const element = this.pictureList[index];
                        imgDom += element.dom
                    }
                    this.posts.content += `<div class="moment-gallery flex-hb-vc flex-hw">${imgDom}</div>`
                }
                let type = this.type
                let format = this.posts.type
                let params = this.posts
                if (!params.title && format === "posts") {
                    this.$message({
                        message: "标题不能为空！",
                        type: 'warning'
                    })
                    this.hasCommitFinish = false
                    return false;
                }
                if (!params.content) {
                    this.$message({
                        message: "内容不能为空！",
                        type: 'warning'
                    })
                    this.hasCommitFinish = false
                    return false;
                }

                axios.post(`${window.site_url}/wp-json/wp/v2/${format}${type === 'update' ? '/' + this.post_id : ''}`, params, {
                    headers: {
                        'X-WP-Nonce': window._nonce
                    }
                }).then(res => {
                    if (res.data) {
                        this.$message({
                            message: "发布成功",
                            type: "success"
                        })
                        setTimeout(() => {
                            this.hasCommitFinish = false
                            window.location.href = window.site_url
                        }, 1500);
                    }

                }).catch(err => {
                    if (err && err.response) {
                        let error = err.response.data
                        this.hasCommitFinish = false
                        this.$message({
                            message: error.message,
                            type: "error"
                        })
                    }
                })
            }
        },
    })
</script>
<?php
get_footer();
?>