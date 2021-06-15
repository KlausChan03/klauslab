<?php

/**
 *  @package KlausLab
 *  Template Name: 关于
 *  author: Klaus
 */
get_header();
// setPostViews(get_the_ID()); ?>
<script>
    window.post_id = '<?php echo get_the_ID(); ?>';
</script>
<div id="primary" class="main-area w-1">
    <main id="main" class="main-content" role="main">
        <div id="about-main" :calss="'post-' + window.post_id" class="page-main style-18 about-main" v-block>
            <el-card shadow="hover">
                <div class="entry-title flex-hl-vc bor-b-1">
                    <svg class="icon icon-title mr-10" aria-hidden="true">
                        <use xlink:href="#lalaksks21-stats"></use>
                    </svg>
                    <h2>{{pageInfo.title.rendered}}</h2>
                </div>
                <div class="entry-content page-content" v-loading="!ifShowAll" style="min-height: 300px">
                    <template v-if="info">
                        <el-collapse v-model="activeNames" @change="handleChange" class="info-main" v-for="(item,index) in info" :key="item.name">
                            <el-collapse-item :name="index">
                                <template slot="title">
                                    <h3>{{item.name}}</h3>
                                </template>
                                <template v-if="item.value && item.value.length > 0">
                                    <template v-if="item.type === 'simple'">
                                        <template v-for="(sonItem,sonIndex) in item.value" :key="sonIndex">
                                            <span v-html="sonItem"> </span>
                                            <span class="m-lr-5" style="font-weight: bold" v-if="(sonIndex < item.value.length - 1) && (sonItem.indexOf('br') < 0)">|</span>
                                        </template>
                                    </template>

                                    <template v-else-if="item.type === 'complexList'">
                                        <ul>
                                            <li v-for="(sonItem,sonIndex) in item.value" class="flex-hl-vc flex-hw">
                                                <span :title="sonItem.tips">{{sonItem.item}}<label class="ml-10">{{sonItem.params}}</label></span>
                                                <el-rate v-model="sonItem.rate" disabled show-score text-color="#ff9900" score-template="{value}"></el-rate>
                                            </li>
                                        </ul>
                                    </template>
                                    <template v-else-if="item.type === 'list'">
                                        <ul>
                                            <li v-for="(sonItem,sonIndex) in item.value" v-html="sonItem"></li>
                                        </ul>
                                    </template>
                                    <template v-else-if="item.type === 'introduction'">
                                        <p v-for="(sonItem,sonIndex) in item.value" :key="sonIndex" v-html="sonItem"></p>
                                    </template>
                                    <template v-else-if="item.type === 'version-timeline'">
                                        <el-timeline>
                                            <template v-for="(sonItem,sonIndex) in item.value" :key="sonIndex">
                                                <el-timeline-item :timestamp="dayjs(new Date(sonItem.date)).format('YYYY-MM-DD')" placement="top">
                                                    <el-card shadow="hover">
                                                        <h4>{{sonItem.version}}{{sonItem.versionName}}</h4>
                                                        <p>{{sonItem.description}}</p>
                                                        <p v-if="sonItem.author && sonItem.date">{{sonItem.author}} 提交于 {{dayjs(new Date(sonItem.date)).format('YYYY-MM-DD hh:mm:ss')}}</p>
                                                    </el-card>
                                            </template>
                                        </el-timeline>
                                    </template>
                                    <template v-else-if="item.type === 'project'">
                                        <div class="flex-hl-vc block" v-for="(sonItem,sonIndex) in item.value" :key="sonIndex">
                                            <div class="flex-hc-vc flex-v">
                                                <el-image style="width: 100px; height: 100px" :src="sonItem.url" fit="cover"></el-image>
                                                <span class="mt-5">{{ sonItem.item }}</span>
                                            </div>
                                        </div>
                                    </template>
                                    <template v-else-if="item.type === 'resume'">
                                        <template v-if="Array.isArray(item.value) && item.value.length > 0">
                                            <ul>
                                                <li v-for="(sonItem,sonIndex) in item.value" v-html="sonItem"></li>
                                            </ul>
                                        </template>
                                        <template v-else>
                                            <p>{{item.value}}</p>
                                        </template>
                                    </template>
                                </template>
                                <template v-else>
                                    <kl-empty description="暂无数据"></kl-empty>
                                </template>
                            </el-collapse-item>
                        </el-collapse>
                        <!-- <div class="info-main" v-for="(item,index) in info" :key="item.name">
                            <h3>{{item.name}}</h3>
                            <template v-if="item.value && item.value.length > 0">
                                <template v-if="item.type === 'simple'">
                                    <template v-for="(sonItem,sonIndex) in item.value" :key="sonIndex">
                                        <span v-html="sonItem"> </span>
                                        <span class="m-lr-5" style="font-weight: bold" v-if="(sonIndex < item.value.length - 1) && (sonItem.indexOf('br') < 0)">|</span>
                                    </template>
                                </template>
                                <template v-else-if="item.type === 'list'">
                                    <ul>
                                        <li v-for="(sonItem,sonIndex) in item.value" v-html="sonItem"></li>
                                    </ul>
                                </template>
                                <template v-else-if="item.type === 'complexList'">
                                    <ul>
                                        <li v-for="(sonItem,sonIndex) in item.value" class="flex-hl-vc flex-hw">
                                            <span :title="sonItem.tips">{{sonItem.item}}<label class="ml-10">{{sonItem.params}}</label></span>
                                            <el-rate v-model="sonItem.rate" disabled show-score text-color="#ff9900" score-template="{value}"></el-rate>
                                        </li>
                                    </ul>
                                </template>
                                <template v-else-if="item.type === 'text'">
                                    <p v-for="(sonItem,sonIndex) in item.value" :key="sonIndex">{{sonItem}}</p>
                                </template>
                                <template v-else-if="item.type === 'version-timeline'">
                                    <el-timeline>
                                        <template v-for="(sonItem,sonIndex) in item.value" :key="sonIndex">
                                            <el-timeline-item :timestamp="dayjs(new Date(sonItem.date)).format('YYYY-MM-DD')" placement="top">
                                                <el-card shadow="hover">
                                                    <h4>{{sonItem.version}}{{sonItem.versionName}}</h4>
                                                    <p>{{sonItem.description}}</p>
                                                    <p v-if="sonItem.author && sonItem.date">{{sonItem.author}} 提交于 {{dayjs(new Date(sonItem.date)).format('YYYY-MM-DD hh:mm:ss')}}</p>
                                                </el-card>
                                        </template>
                                    </el-timeline>
                                </template>
                            </template>
                            <template v-else>
                                <kl-empty description="暂无数据"></kl-empty>
                            </template>
                        </div> -->
                    </template>
                    <template v-else>
                        <kl-empty description="暂无数据"></kl-empty>
                    </template>
                </div>
                <div class="entry-footer flex-hc-vc">
                    <template v-if="pageInfo.post_metas.reward === '0' ? false : true">
                        <kl-reward></kl-reward>
                    </template>
                </div>
            </el-card>
            <!-- <kl-skeleton v-if="!listOfComment" class="article-skeleton mt-10" type="comment"></kl-skeleton> -->
            <aside id="comment-part" class="comment-container mt-10">
                <template v-if="pageInfo.comment_status === 'open'">
                    <h3 class="tips-header flex-hl-vc"><i class="el-icon-chat-line-round fs-24 mr-10"></i>评论区</h3>
                    <quick-comment :post-data="pageInfo"></quick-comment>
                </template>
            </aside>
        </div>
    </main>
</div>
<style>
    .info-main h3 {
        color: #333333;
        font-weight: 600;
        font-size: 20px;
        padding: 1.5rem 0;
        line-height: 2;
    }

    .info-main li,
    .info-main span,
    .info-main p {
        color: #666666;
        line-height: 1.8;
        font-size: 16px;
    }

    .info-main label {
        color: #999999;
        font-size: 12px;
    }

    .info-main .el-rate {
        height: 24px;
        line-height: 1;
        margin-left: 10px;
    }
</style>

<script type="text/javascript" src="<?php echo KL_THEME_URI; ?>/js/component/skeleton.js"></script>
<script type="text/javascript" src="<?php echo KL_THEME_URI; ?>/js/component/reward.js"></script>
<script type="text/javascript" src="<?php echo KL_THEME_URI; ?>/js/mixin/pageMixin.js"></script>

<script type="text/javascript" src="<?php echo KL_THEME_URI; ?>/js/component/quickCommentItem.js" defer></script>
<script type="text/javascript" src="<?php echo KL_THEME_URI; ?>/js/component/quickComment.js" defer></script>

<script>
    new Vue({
        el: '#about-main',
        mixins:[pageMixin],
        data() {
            return {
                listContent: '',
                ifGetList: false,
                info: {},
                ifShowAll: false,
                ifShowPayImage: true,
                commentPage: 1,
                
                activeNames: [0, 1, 2, 3],
                fits: ['fill', 'contain', 'cover', 'none', 'scale-down'],

            }
        },
        mounted() {
            this.getInfo()
            // this.getPage()
        },
        methods: {
            goToPage(route, params = false) {
                if (params) {
                    window.location.href = `${window.home_url}/${route}`

                } else {
                    window.location.href = route
                }
            },
           
            getInfo() {
                let self = this
                self.ifShowAll = false
                axios.get(`${window.ajaxSourceUrl}/about/aboutme.json`).then(res => {
                    self.info = res.data ? res.data : ''
                    self.ifShowAll = true
                })
            },
            changeChoose() {
                this.ifShowPayImage = !this.ifShowPayImage
            },
            handleChange() {

            },
        }

    })
</script>
<?php get_footer();
