<?php

/**
 *  @package KlausLab
 *  Template Name: 归档
 *  author: Klaus
 */
get_header();
?>
<div id="primary" class="main-area w-1">
    <main id="main" class="main-content" role="main">
        <?php if (have_posts()) : the_post();
            update_post_caches($posts); ?>
            <article id="archive-main" class="post-<?php the_ID(); ?> page-main style-18" v-block>
                <el-card>
                    <h2 class="entry-title bor-b-1">
                        <!-- <i class="lalaksks21 lalaksks21-worldwide mr-5"></i> -->
                        <svg class="icon icon-title mr-5" aria-hidden="true">
                            <use xlink:href="#lalaksks21-worldwide"></use>
                        </svg>
                        <?php the_title(); ?>
                    </h2>
                    <el-form id="archive-filter" class="archive-filter mt-15">
                        <el-form-item class="filter-author" label="作者">
                            <el-button :class="{active:filterArr[1] === ''}" size="mini" data-author="" @click="choose($event)">全部</el-button>
                            <el-button :class="{active:filterArr[1] === 'Klaus'}" size="mini" data-author="Klaus" @click="choose($event)">Klaus</el-button>
                            <el-button :class="{active:filterArr[1] === 'Laura'}" size="mini" data-author="Laura" @click="choose($event)">Laura</el-button>
                        </el-form-item>
                        <el-form-item class="filter-type" label="类型">
                            <el-button :class="{active:filterArr[0] === ''}" size="mini" data-type="" @click="choose($event)">全部</el-button>
                            <el-button :class="{active:filterArr[0] === 'post'}" size="mini" data-type="post" @click="choose($event)">文章</el-button>
                            <el-button :class="{active:filterArr[0] === 'shuoshuo'}" size="mini" data-type="shuoshuo" @click="choose($event)">说说</el-button>
                        </el-form-item>
                        <el-form-item class="filter-chosed" label="当前选择">
                            <el-tag type="success" v-for="(item,index) in filterName" :key="item" class="mr-5">{{item}}</el-tag>
                        </el-form-item>
                    </el-form>
                </el-card>
                <el-card class="mt-15">
                    <template v-if="archiveContent">
                        <div class="mh-100 entry-content" v-loading="!ifGetList" v-html="archiveContent"> </div>
                    </template>                    
                    <template v-else>
                        <kl-empty description="暂无数据"></kl-empty>
                    </template>
                </el-card>
                <!-- <?php edit_post_link(esc_html__('Edit', 'KlausLab'), '<footer class="entry-footer clear"><span class="edit-link">', '</span></footer>.entry-footer'); ?> -->
            </article>
        <?php endif; ?>
    </main>
</div>

<style>
    .mh-100 {
        min-height: 100px;
    }

    .bor-b-1 {
        border-bottom: 1px solid #ddd;
    }

    .style-18 {
        background-color: transparent;
        box-shadow: none;
    }

    .style-18 .entry-title {
        padding-bottom: 15px;
    }

    .style-18 .el-loading-mask {
        background-color: transparent;
    }

    .style-18 .archive-filter button.active {
        color: #409EFF;
        border-color: #c6e2ff;
        background-color: #ecf5ff;
    }

    .style-18 .el-form-item {
        margin-bottom: 5px;
    }

    .style-18 .entry-content {
        padding: 0;
    }

    .style-18 .entry-content hr {
        margin: 40px auto;
        border-top: 1px solid #ddd;
        width: 50%;
    }

    .style-18 .entry-content hr:first-child {
        display: none;
    }
</style>
<script>
    let archiveFilter = new Vue({
        el: '#archive-main',
        data: {
            archiveContent: '',
            filterArr: ['post', 'Klaus'],
            filterName: ['文章', 'KLAUS'],
            ifGetList: false
        },
        mounted() {
            this.search()
        },
        methods: {
            choose($event) {
                console.log($event.target)
                if ($event.target.attributes['data-type']) {
                    this.filterArr[0] = $event.target.attributes['data-type'].value;
                    this.filterName[0] = $event.target.innerText;
                }
                if ($event.target.attributes['data-author']) {
                    this.filterArr[1] = $event.target.attributes['data-author'].value;
                    this.filterName[1] = $event.target.innerText;
                }
                // this.filterArr[0] = $event.target.attributes['data-type'] ? $event.target.attributes['data-type'].value : '';                
                // this.filterArr[1] = $event.target.attributes['data-author'] ? $event.target.attributes['data-author'].value : '';
                this.search()
            },
            search() {
                let params = new FormData;
                params.append('action', 'filter_archive');
                params.append('filter', this.filterArr);
                console.log(params)
                axios.post(`${GLOBAL.homeUrl}/wp-admin/admin-ajax.php`, params).then((res) => {
                    this.archiveContent = res.data;
                    this.ifGetList = true
                })
            }
        }

    })
</script>
<?php get_footer();
