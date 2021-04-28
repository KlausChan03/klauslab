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
</style>
<!-- <p>hello world</p> -->
<div class="post-main" id="post-page">
    <el-form>
        <div class="flex-hb-vc">
            <div>

                <el-popover placement="bottom" width="400" trigger="click">
                    <el-upload class="upload-demo" drag :action=`${GLOBAL.homeUrl}/wp-json/wp/v2/media` :on-success="handleUploadSuccess" :headers="{'X-WP-Nonce': window._nonce}" multiple>
                        <i class="el-icon-upload"></i>
                        <div class="el-upload__text">将文件拖到此处，或<em>点击上传</em></div>
                        <!-- <div class="el-upload__tip" slot="tip">只能上传jpg/png文件，且不超过500kb</div> -->
                    </el-upload>
                    <el-button class="mr-10" size="small" slot="reference"><i class="lalaksks lalaksks-palette"></i></el-button>
                </el-popover>
                <el-tag class="mr-10" size="small" v-for="(item,index) in tagNameList"> {{item}} </el-tag>
                <el-tag type="warning" class="mr-10" size="small" v-for="(item,index) in categoryNameList"> {{item}} </el-tag>
            </div>
            <div>
                <el-switch class="mr-10" v-model="status" active-text="正式" inactive-text="草稿" active-color="#13ce66"> </el-switch>
                <el-button size="small" type="primary" @click="commitPost()">发布</el-button>
            </div>
        </div>
        <el-card class="mt-10">
            <el-form-item>
                <el-input v-model="posts.title" placeholder="标题"></el-input>
            </el-form-item>
            <editor :api-key="tinyKey" cloud-channel="5" :disabled=false id="uuid" :setting="{inline: false}" :init="{
                 height: 360, 
                 menubar: true}" initial-value="" :inline=false model-events="" plugins="image,table,codesample,advlist autolink lists link image charmap print preview anchor, searchreplace visualblocks code fullscreen, insertdatetime media table paste code help wordcount, lists code emoticons" tag-name="div" toolbar=" undo redo | formatselect | media table | emoticons | help " v-model="posts.content" />
            </editor>
        </el-card>
        <el-card class="mt-10">
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
                    <el-form-item label="标签">
                        <el-select v-model="posts.tags" multiple filterable allow-create default-first-option placeholder="请选择文章标签">
                            <el-option v-for="item in tagList" :key="item.id" :label="item.name" :value="item.id">
                            </el-option>
                        </el-select>
                    </el-form-item>
                    <el-form-item label="分类">
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

    </el-form>

</div>
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
            return {
                tinyKey: '7b4pdrcfzcszmsf2gjor1x94mha4srj4jalmdpq94fgpaa6j',
                status: true,
                posts: {
                    title: '',
                    content: '',
                    status: 'publish',
                    tags: [],
                    categories: [],

                },
                tagList: [],
                categoryList: [],
                categoryListOrigin: [],
                defaultProps: {
                    children: 'children',
                    label: 'name'
                },
                hasCommitFinish: true,
            }
        },
        mounted() {
            this.getTags()
            this.getCategories()
        },
        methods: {
            getTags() {
                axios.get(`${GLOBAL.homeUrl}/wp-json/wp/v2/tags`).then(res => {
                    console.log(res)
                    this.tagList = res.data
                })
            },
            getCategories() {
                axios.get(`${GLOBAL.homeUrl}/wp-json/wp/v2/categories`).then(res => {
                    this.categoryListOrigin = res.data

                    this.categoryList = transData(res.data, 'id', 'parent', 'children')
                })
            },

            handleUploadSuccess(res, file) {
                debugger
                this.posts.featured_media = res.id
            },
            handleCheckChange(data, checked, indeterminate) {
                this.posts.categories = this.$refs.categoryTree.getCheckedKeys()
                // console.log(this.posts.categories)
            },

            commitPost() {
                this.hasCommitFinish = true
                this.posts.status = this.status === true ? 'publish' : 'draft'

                let params = this.posts;
                // params.categories = this.$refs.categoryTree.getCheckedKeys()
                axios.post(`${GLOBAL.homeUrl}/wp-json/wp/v2/posts`, params, {
                    headers: {
                        'X-WP-Nonce': window._nonce
                    }
                }).then(res => {
                    if (res.data) {
                        this.$message({
                            message: "发布成功",
                            type: "success"
                        })
                        this.hasCommitFinish = false
                        setTimeout(() => {
                            history.go(-1)
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