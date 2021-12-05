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
        height: 50px;
        font-size: 18px;
        border-radius: 8px;
    }

    .commit-type {
        height: 60px;
    }

    .location-container {
        width: calc(100vw - 40px);
        height: calc(100vh - 90px);
    }

    .location-info {
        padding: 10px;
        border-radius: 4px;
        position: absolute;
        width: 360px;
        left: 15px;
        top: 15px;
        border-width: 0;
        background-color: #fff;
        box-shadow: 0 2px 6px 0 rgb(114 124 245 / 50%);
    }


    .location-info .input-item {
        position: relative;
        display: -ms-flexbox;
        display: flex;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        -ms-flex-align: center;
        align-items: center;
        width: 100%;
        height: 3rem;
    }

    .location-info .input-item>input[type=text] {
        position: relative;
        -ms-flex: 1 1 auto;
        flex: 1 1 auto;
        width: 1%;
        margin-bottom: 0;
        background: #fff;
        padding: 0.2rem 0.75rem;
    }

    .location-info input[type=text] {
        display: inline-block;
        width: 100%;
        padding: 0.375rem 1.75rem 0.375rem 0.75rem;
        line-height: 1.5;
        color: #495057;
        vertical-align: middle;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
    }

    .location-info .input-item>input[type=text]:not(:first-child) {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
    }

    .location-info .input-item-prepend {
        margin-right: -1px;
    }

    .location-info .input-item-text {
        width: 6rem;
        text-align: justify;
        padding: 0.4rem 0.7rem;
        display: inline-block;
        text-justify: distribute-all-lines;
        text-align-last: justify;
        -moz-text-align-last: justify;
        -webkit-text-align-last: justify;
        -ms-flex-align: center;
        align-items: center;
        margin-bottom: 0;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #495057;
        text-align: center;
        white-space: nowrap;
        background-color: #e9ecef;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        border-bottom-right-radius: 0;
        border-top-right-radius: 0;
    }
</style>

<div id="post-page" class="post-main flex1" v-block>
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
                    
                    <el-form-item>
                        <span slot="label">
                            <svg class="icon mr-5" aria-hidden="true">
                                <use xlink:href="#lalaksks21-filter"></use>
                            </svg>
                            置顶
                        </span>                    
                        <el-switch v-model="posts.sticky" active-text="是" inactive-text="否"> </el-switch>
                    </el-form-item>
                    <el-form-item>
                        <span slot="label">
                            <svg class="icon mr-5" aria-hidden="true">
                                <use xlink:href="#lalaksks21-coin"></use>
                            </svg>
                            打赏
                        </span> 
                        <el-switch v-model="posts.post_metas.reward" active-text="是" inactive-text="否"> </el-switch>
                    </el-form-item>
                    <el-form-item v-show="!format">
                        <span slot="label">
                            <svg class="icon mr-5" aria-hidden="true">
                                <use xlink:href="#lalaksks21-tag"></use>
                            </svg>
                            标签
                        </span> 
                        <el-select v-model="posts.tags" multiple filterable allow-create default-first-option placeholder="请选择标签" @change="doTagsChange">
                            <el-option v-for="item in tagList" :key="item.id" :label="item.name" :value="item.id">
                            </el-option>
                        </el-select>
                    </el-form-item>
                    <el-form-item v-show="!format">
                        <span slot="label">
                            <svg class="icon mr-5" aria-hidden="true">
                                <use xlink:href="#lalaksks21-sitemap"></use>
                            </svg>
                            分类
                        </span> 
                        <!-- <el-select v-model="posts.categories" multiple filterable allow-create default-first-option placeholder="请选择文章分类">
                            <el-option v-for="item in categoryList" :key="item.id" :label="item.name" :value="item.id">
                            </el-option>
                        </el-select> -->
                        <el-tree :data="categoryList" show-checkbox check-strictly="true" default-expand-all node-key="id" ref="categoryTree" highlight-current @check-change="handleCheckChange" :props="defaultProps" style="margin-left: 60px">
                        </el-tree>
                    </el-form-item>
                    <el-form-item>
                        <span slot="label">
                            <svg class="icon mr-5" aria-hidden="true">
                                <use xlink:href="#lalaksks21-aim"></use>
                            </svg>
                            定位
                        </span> 
                        <el-switch v-model="posts.post_metas.location" @change="doLocationChange" active-text="是" inactive-text="否"></el-switch>
                    </el-form-item>
                </el-collapse-item>
            </el-collapse>
        </el-card>
        <el-dialog :visible.sync="dialogVisible">
            <img width="100%" :src="dialogImageUrl" alt="">
        </el-dialog>
        <el-dialog :visible.sync="ifShowLocationPopup" fullscreen show-close>
            <div id="location-container" class="location-container"> </div>
            <div class="location-info flex-hc-vc flex-v">
                <!-- <h4 class="location-status mb-5">{{location.status === 1 ? '定位成功' : '定位失败'}}</h4> -->
                <!-- <p id='result'></p> -->
                <div class="input-item mt-10">
                    <div class="input-item-prepend"><span class="input-item-text">经纬度</span></div>
                    <input id='lnglat' type="text" :value="location.simplePosition">
                </div>
                <div class="input-item">
                    <div class="input-item-prepend"><span class="input-item-text">地址</span></div>
                    <input id='address' type="text" disabled :value="location.address">
                </div>
                <el-button class="mt-5" type="primary" size="small" plain @click="saveLocation" >保存定位</el-button>
            </div>
        </el-dialog>
    </el-form>

</div>
<script type="text/javascript" src="https://webapi.amap.com/maps?v=1.4.15&key=7c7a39e2e07d4245fa9c21dece87bf93&plugin=AMap.Geocoder"></script>
<script type="text/javascript" src="https://cdn.tiny.cloud/1/7b4pdrcfzcszmsf2gjor1x94mha4srj4jalmdpq94fgpaa6j/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script type="text/javascript" src="<?php echo KL_THEME_URI; ?>/js/page/post.js"></script>
<?php
get_footer();
?>