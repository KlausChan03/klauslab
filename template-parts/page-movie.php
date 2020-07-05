<?php

/**
 *  @package KlausLab
 *  Template Name: 观影记录
 *  author: Klaus
 */
get_header();
?>


<div id="primary" class="page-movie main-area w-1">
    <main id="main" class="main-content" role="main">
        <div id="douban-movie-list" class="doubanboard-list"  v-loading="loadingAll">
            <el-row v-bind:gutter="20">
                <el-col :span="6" :xs="24" :sm="12" :md="6" :lg="4" v-for="(item,index) in list" v-bind:key="item.url" v-bind:class="'doubanboard-item'" v-if="item.url">
                    <!-- <el-tooltip class="cur-p" effect="light" placement="right" popper-class="s-tooltip">
                        <div v-if="item.url" v-bind:class="'doubanboard-thumb'" v-bind:style="{backgroundImage : 'url(' + item.img +')'}">
                            <div class="doubanboard-title flex-hb-vc">
                                <a class="movie-title w-06" v-bind:href="item.url" v-bind:title="item.name" target="_blank">{{item.name}}</a>
                                <div class="movie-mark flex-hr-vc w-04">
                                    <span class="flex-hr-vc mr-5"><i class="lalaksks lalaksks-ic-tag"></i> {{item.mark_myself}}</span>
                                    <span class="flex-hr-vc"><i class="lalaksks lalaksks-ic-douban"></i> {{item.mark_douban}}</span>
                                </div>
                            </div>
                        </div>
                        <div slot="content">
                            <h4>{{item.name}}</h4>
                            <p class="mt-10">{{item.remark}}</p>
                            <p class="mt-10">{{item.date}}</p>
                        </div>
                    </el-tooltip> -->
                    <rotate-card trigger="hover" direction="row" >
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
                            <p class="mt-10">{{item.date}}</p>
                        </div>
                    </rotate-card>
                </el-col>
            </el-row>
            <div class="flex-hc-vc">
                <el-button ref="getMoreButton" id="loadMoreMovies" @click="loadMovies();">加载更多</el-button>
            </div>
        </div>
    </main>
    <!-- #main -->
</div>
<!-- #primary -->
<script>
    let app = new Vue({
        el: ".page-movie",
        data: {
            curBooks_read: 0,
            curBooks_reading: 0,
            curBooks_wish: 0,
            curMovies: 0,
            list: [],
            pageSize: 20,
            loadingAll: true,
        },
        created: function() {
            this.loadMovies();
        },
        methods: {
            loadMovies: function() {
                this.loadingAll = true;
                if ($("#douban-movie-list").length < 1) return;
                axios.post(GLOBAL.ajaxSourceUrl + "/douban/douban.php?type=movie&from=" + String(this.curMovies)).then(result => {
                    if(result.data.length < this.pageSize){
                        this.$refs.getMoreButton.$el.setAttribute("disabled",true)
                        this.$refs.getMoreButton.$el.innerHTML = "已加载完毕"                        
                    }
                    console.log(result.data.length,this.pageSize,this.curMovies)
                    this.list = this.list.concat(result.data);
                    this.curMovies+=this.pageSize;
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
        overflow: hidden!important;
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
        -webkit-line-clamp: 10;
        -webkit-box-orient: vertical;
        line-height: 1.5;
    }
</style>

<?php
get_footer();
?>