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
                <el-button class="commit-button" size="small" type="primary" @click="commitPost()" :loading="hasCommitFinish">{{type === 'update' ? '更新' : '发布'}}</el-button>
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
                        <el-select v-model="posts.tags" multiple filterable allow-create default-first-option placeholder="请选择标签" @change="doTagsChange">
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
<script type="text/javascript" src="<?php echo KL_THEME_URI; ?>/js/page/post.js"></script>
<?php
get_footer();
?>