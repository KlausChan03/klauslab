<?php

/**
 *  @package KlausLab
 *  Template Name: 观影记录
 *  author: Klaus
 */
get_header();
?>


<div id="primary" class="main-area w-1">
    <main id="main" class="main-content" role="main">
        <?php if (have_posts()) : the_post(); ?>

            <article id="movie-main" class="post-<?php the_ID(); ?> page-main style-18">
                <el-card>
                    <h2 class="entry-title bor-b-1">
                        <svg class="icon icon-title mr-5" aria-hidden="true">
                            <use xlink:href="#lalaksks21-views"></use>
                        </svg>
                        <?php the_title(); ?>
                    </h2>
                    <div class="tips mt-15" v-if="count">
                        <span>记录阅片数量：{{count}}</span>
                    </div>
                    <div id="douban-movie-list" class="doubanboard-list" v-loading="loadingAll">
                        <template v-if="count">
                            <el-row v-bind:gutter="20">
                                <el-col :span="6" :xs="24" :sm="12" :md="6" :lg="4" v-for="(item,index) in list" v-bind:key="item.url" v-bind:class="'doubanboard-item'" v-if="item.url">
                                    <rotate-card trigger="hover" direction="row">
                                        <div slot="cz" v-if="item.url" v-bind:class="'doubanboard-thumb'" v-bind:style="{backgroundImage : 'url(' + item.img +')'}">
                                            <div>
                                                <div class="doubanboard-title flex-hb-vc">
                                                    <a class="movie-title w-06" v-bind:href="item.url" v-bind:title="item.name" target="_blank">{{item.name}}</a>
                                                    <div class="movie-mark flex-hr-vc w-04">
                                                        <span class="flex-hr-vc mr-5"><i class="lalaksks lalaksks-ic-tag"></i> {{item.mark_myself}}</span>
                                                        <span class="flex-hr-vc"><i class="lalaksks lalaksks-ic-douban"></i> {{item.mark_douban}}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div slot="cf" v-bind:class="'inner'">
                                            <h3>{{item.name}}</h3>
                                            <p class="mt-10 item-content" v-bind:title=item.remark>{{item.remark}}</p>
                                            <p>{{item.date}}</p>
                                        </div>
                                    </rotate-card>
                                </el-col>
                            </el-row>
                            <div class="flex-hc-vc">
                                <el-button ref="getMoreButton" v-if="ifShowMore" id="loadMoreMovies" @click="loadMovies();">加载更多</el-button>
                            </div>
                        </template>
                        <template v-else>
                            <kl-empty description="暂无数据"></kl-empty>
                        </template>
                    </div>

                </el-card>
            </article>

    </main>
<?php endif; ?>

<!-- #main -->
</div>
<!-- #primary -->

<script>
    let app = new Vue({
        el: "#movie-main",
        data: {
            curBooks_read: 0,
            curBooks_reading: 0,
            curBooks_wish: 0,
            curMovies: 0,
            list: [],
            count: 0,
            pageSize: 20,
            loadingAll: true,
            ifShowMore: false
        },
        created: function() {
            this.loadMovies();
        },
        methods: {

            currDevice() {
                var u = navigator.userAgent;
                var app = navigator.appVersion; // appVersion 可返回浏览器的平台和版本信息。该属性是一个只读的字符串。
                var browserLang = (navigator.browserLanguage || navigator.language).toLowerCase(); //获取浏览器语言

                var deviceBrowser = function() {
                    return {
                        trident: u.indexOf('Trident') > -1, //IE内核
                        presto: u.indexOf('Presto') > -1, //opera内核
                        webKit: u.indexOf('AppleWebKit') > -1, //苹果、谷歌内核
                        gecko: u.indexOf('Gecko') > -1 && u.indexOf('KHTML') == -1, //火狐内核
                        mobile: !!u.match(/AppleWebKit.*Mobile.*/), //是否为移动终端
                        ios: !!u.match(/\(i[^;]+;( U;)? CPU.Mac OS X/), //ios终端
                        android: u.indexOf('Android') > -1 || u.indexOf('Linux') > -1, //android终端或者uc浏览器
                        iPhone: u.indexOf('iPhone') > -1, //是否为iPhone或者QQHD浏览器
                        iPad: u.indexOf('iPad') > -1, //是否iPad
                        webApp: u.indexOf('Safari') == -1, //是否web应用程序，没有头部和底部
                        weixin: u.indexOf('MicroMessenger') > -1, //是否微信
                        qq: u.match(/\sQQ/i) == " qq", //是否QQ
                    }
                }();

                return deviceBrowser
            },

            loadMovies: function() {
                debugger
                this.loadingAll = true;
                if ($("#douban-movie-list").length < 1) return;
                axios.post(GLOBAL.ajaxSourceUrl + "/douban/douban.php?type=movie&from=" + String(this.curMovies)).then(result => {
                    if (result.data.data.length < this.pageSize) {
                        // this.$refs.getMoreButton.$el.setAttribute("disabled",true)
                        // this.$refs.getMoreButton.$el.innerHTML = "已加载完毕"  
                        this.ifShowMore = false
                    } else {
                        this.ifShowMore = true
                    }
                    this.list = this.list.concat(result.data.data);
                    if (this.currDevice().mobile === true) {
                        this.list.forEach(item => {
                            item.img = item.img.replace(/s_ratio_poster/g, 'm_ratio_poster')
                        });
                    }
                    this.count = result.data.total;
                    if (this.list[0].name === '') {
                        this.count = 0
                    }
                    this.curMovies += this.pageSize;
                    setTimeout(() => {
                        this.loadingAll = false;
                    }, 1000);
                });
            }
        },
    })
    Vue.component('rotate-card', {
        template: `
        <div class="card-3d" @click="eve_cardres_click">
            <div class="card card-z" ref="cardz">
                <slot name="cz"></slot>
            </div>
            <div :class="['card card-f',direction=='row'?'card-f-y':'card-f-x']" ref="cardf">
                <slot name="cf"></slot>
            </div>
        </div>
        `,
        props: {
            trigger: { //触发方式 hover click custom
                type: String,
                default: 'click' //默认点击触发
            },
            value: { //正反面
                type: Boolean,
                default: true
            },
            direction: { //方向 row col
                type: String,
                default: 'row'
            }
        },
        data() {
            return {
                surface: true
            }
        },
        watch: {
            value(bool) { //自定义触发方式
                if (this.trigger == 'custom') this.fn_reserve_action(bool)
            }
        },
        methods: {
            fn_reserve_action(bool) {
                var arr = this.direction == 'row' ? ['rotateY(180deg)', 'rotateY(0deg)'] : ['rotateX(-180deg)', 'rotateX(0deg)']
                this.$refs.cardz.style.transform = bool ? arr[0] : arr[1]
                this.$refs.cardf.style.transform = !bool ? arr[0] : arr[1]
            },
            eve_cardres_click() {
                // if (this.trigger == 'click') {
                this.fn_reserve_action(this.surface)
                this.surface = !this.surface
                // }
            },
            eve_cardres_msover() {
                if (this.trigger == 'hover') this.fn_reserve_action(true)
            },
            eve_cardres_msout() {
                if (this.trigger == 'hover') this.fn_reserve_action(false)
            }
        }
    })
</script>
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
<style>
    .doubanboard-list {
        padding: 10px 0;
        overflow: hidden;
        min-height: 100px;
    }

    .doubanboard-item {
        position: relative;
        overflow: hidden;
        margin-bottom: 15px;
        border-radius: 4px;
    }

    .doubanboard-thumb {
        box-shadow: 0 0 4px rgba(0, 0, 0, 0.3);
        background: #f7fbf7;
        width: 100%;
        /* customize this for diffrent style */
        padding-top: 141%;
        background-repeat: no-repeat;
        background-size: cover;
        border-radius: 4px;
        transition: ease all 0.3s;
    }

    .doubanboard-thumb:hover {
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
    }

    .doubanboard-title {
        background: #000;
        opacity: .8;
        padding: 8px;
        border-radius: 4px;
    }

    .doubanboard-title .movie-title {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        color: #fff;
        font-size: 14px;
        cursor: pointer;
    }

    .doubanboard-title .movie-title:hover {
        color: #ddd;
    }

    .doubanboard-title .movie-mark * {
        font-size: 12px;
        color: #ff9900
    }


    .s-tooltip {
        min-width: 25%;
        max-width: 80%;
    }

    .card-3d {
        transition: all .2s;
        perspective: 1500px;
        background-color: transparent;
        cursor: pointer;
    }

    .card-3d .card {
        background-size: cover;
        background-position: center;
        -webkit-transition: -webkit-transform .7s cubic-bezier(0.4, 0.2, 0.2, 1);
        transition: -webkit-transform .7s cubic-bezier(0.4, 0.2, 0.2, 1);
        -o-transition: transform .7s cubic-bezier(0.4, 0.2, 0.2, 1);
        transition: transform .7s cubic-bezier(0.4, 0.2, 0.2, 1);
        transition: transform .7s cubic-bezier(0.4, 0.2, 0.2, 1), -webkit-transform .7s cubic-bezier(0.4, 0.2, 0.2, 1);
        -webkit-backface-visibility: hidden;
        backface-visibility: hidden;
        min-height: 280px;
        height: 100%;
        border-radius: 4px;
        overflow: hidden !important;
    }

    .card-3d .card:hover {
        box-shadow: 0 1px 6px rgba(0, 0, 0, .2);
        border-color: #eee;
    }

    .card-z {
        background-color: rgb(64, 158, 255);
    }

    .card-f {
        background-color: #48e;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
    }

    .card-f .inner {
        /* transform: translateY(-50%) translateZ(60px) scale(0.94);
        top: 50%; */
        /* position: absolute;
        left: 0; */
        width: 100%;
        padding: .5rem;
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
        outline: 1px solid transparent;
        -webkit-perspective: inherit;
        perspective: inherit;
        z-index: 2;
        height: -webkit-fill-available;
    }

    .card-f .inner h3,
    .card-f .inner p {
        color: #fff
    }


    .card-f-y {
        transform: rotateY(-180deg);
    }

    .card-f-x {
        transform: rotateX(-180deg);
    }

    .item-content {
        text-overflow: -o-ellipsis-lastline;
        overflow-y: auto;
        text-overflow: ellipsis;
        display: -webkit-box;
        /* -webkit-line-clamp: 10; */
        -webkit-box-orient: vertical;
        line-height: 1.5;
        height: calc(100% - 55px);
    }
</style>

<?php
get_footer();
?>