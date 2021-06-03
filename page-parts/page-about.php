<?php

/**
 *  @package KlausLab
 *  Template Name: 关于
 *  author: Klaus
 */
get_header();
setPostViews(get_the_ID()); ?>
<script>
    window.post_id = '<?php echo get_the_ID(); ?>';
</script>
<div id="primary" class="main-area w-1">
    <main id="main" class="main-content" role="main">
        <div id="about-main" class="post-<?php the_ID(); ?> page-main style-18 about-main">
            <el-card shadow="hover">
                <div class="entry-title flex-hl-vc bor-b-1">
                    <svg class="icon icon-title mr-10" aria-hidden="true">
                        <use xlink:href="#lalaksks21-stats"></use>
                    </svg>
                    <h2><?php the_title(); ?></h2>
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
                    <el-popover placement="top" title="请作者喝杯咖啡☕" width="280" trigger="click">
                        <div class="pay-body">
                            <?php
                            $alipay_image_id = cs_get_option('alipay_image');
                            $alipay_attachment = wp_get_attachment_image_src($alipay_image_id, 'full');
                            $wechat_image_id = cs_get_option('wechat_image');
                            $wechat_attachment = wp_get_attachment_image_src($wechat_image_id, 'full');
                            if (cs_get_option('alipay_image') && cs_get_option('wechat_image')) { ?>
                                <h4 class="flex-hc-vc m-tb-10">扫一扫支付</h4>
                                <div class="flex-hc-vc">
                                    <img class="alipay" src="<?php echo $alipay_attachment[0]; ?>" v-show="ifShowPayImage" />
                                    <img class="wechatpay" src="<?php echo $wechat_attachment[0]; ?>" v-show="!ifShowPayImage" />
                                </div>
                                <div class="pay-chose flex-hb-vc mt-15">
                                    <button class="alibutton" :class="{'chosen':ifShowPayImage}" :disabled="ifShowPayImage" ref="alibutton" @click="changeChoose"><img src="<?php echo KL_THEME_URI; ?>/img/alipay.png" /></button>
                                    <button class="wechatbutton" :class="{'chosen':!ifShowPayImage}" :disabled="!ifShowPayImage" ref="wechatbutton" @click="changeChoose"><img src="<?php echo KL_THEME_URI; ?>/img/wechat.png" /></button>
                                </div>
                            <?php } else if (cs_get_option('alipay_image') && !cs_get_option('wechat_image')) { ?>
                                <h4 class="flex-hc-vc m-tb-10">扫一扫支付</h4>
                                <img class="alipay" src="<?php echo $alipay_attachment[0]; ?>" />
                            <?php } else if (!cs_get_option('alipay_image') && cs_get_option('wechat_image')) { ?>
                                <h4 class="flex-hc-vc m-tb-10">扫一扫支付</h4>
                                <img class="wechatpay" src="<?php echo $wechat_attachment[0]; ?>" />
                            <?php } else { ?>
                                <h4 class="flex-hc-vc m-tb-10">作者尚未添加打赏二维码！</h4>
                            <?php } ?>
                        </div>
                        <el-button slot="reference" circle><i class="el-icon-coffee fs-20"></i></el-button>
                    </el-popover>
                </div>
            </el-card>
            <!-- <kl-skeleton v-if="!listOfComment" class="article-skeleton mt-10" type="comment"></kl-skeleton> -->
            <aside id="comment-part" class="comment-container mt-10">
                <template v-if="posts.comment_status === 'open'">
                    <h3 class="tips-header flex-hl-vc"><i class="el-icon-chat-line-round fs-24 mr-10"></i>评论区</h3>
                    <quick-comment :post-data="posts"></quick-comment>
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

    /* a.link{
        font-family: "lalaksks";

    } */
</style>

<script type="text/javascript" src="<?php echo KL_THEME_URI; ?>/js/component/skeleton.js"></script>
<script type="text/javascript" src="<?php echo KL_THEME_URI; ?>/js/component/quickCommentItem.js" defer></script>
<script type="text/javascript" src="<?php echo KL_THEME_URI; ?>/js/component/quickComment.js" defer></script>

<script>
    new Vue({
        el: '#about-main',
        data() {
            return {
                listContent: '',
                ifGetList: false,
                info: {},
                ifShowAll: false,
                ifShowPayImage: true,
                commentPage: 1,
                posts: {
                    id: window.post_id,
                    comment_status: 'open'
                },
                activeNames: [0, 1, 2, 3],
                fits: ['fill', 'contain', 'cover', 'none', 'scale-down'],

            }
        },
        mounted() {
            this.getInfo()
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
