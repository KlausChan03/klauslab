<?php

/**
 *  @package KlausLab
 *  Template Name: 电影
 *  author: Klaus
 */
get_header();
// wp_enqueue_script( 'doubanjs', get_template_directory_uri() . '/js/douban.js', false, '1.0',array('jquery') );
// wp_enqueue_style( 'doubancss', get_template_directory_uri() . '/css/douban.css', false, '1.0' );
?>

<div id="primary" class="page-movie main-area w-1">
    <main id="main" class="main-content" role="main">
        <div id="douban-movie-list" class="doubanboard-list">
            <el-row v-bind:gutter="20">
                <el-col :xs="24" :sm="12" :md="6" :lg="4" v-for="(item,index) in list" v-bind:key="item.url" v-bind:class="'doubanboard-item'">
                    <el-tooltip class="cur-p"  effect="light" placement="right" popper-class="s-tooltip">
                        <div v-if="item.url" v-bind:class="'doubanboard-thumb'" v-bind:style="{backgroundImage : 'url(' + item.img +')'}">
                            <div class="doubanboard-title flex-hb-vc">
                                <a class="movie-title w-06" v-bind:href="item.url" v-bind:title="item.name" target="_blank">{{item.name}}</a>
                                <div class="movie-mark flex-hr-vc w-04">
                                    <span class="flex-hr-vc mr-5"><i class="lalaksks lalaksks-ic-tag"></i> {{item.mark_myself}}</span>
                                    <span class="flex-hr-vc"><i class="lalaksks lalaksks-ic-douban"></i> {{item.mark_douban}}</span>
                                </div>
                                <!-- <el-rate class="mt-5" v-model="item.mark.replace(/[^0-9]/ig,'')" disabled score-template="{item.mark.replace(/[^0-9]/ig,'')}" ></el-rate>
                                <el-rate class="mt-5" v-model="item.mark_douban" disabled show-score text-color="#ff9900" allow-half="true">
                                    <div slot="score-template">{{Number(item.mark_douban)}}</div>
                                    <div slot="max">10</div>
                                </el-rate> -->
                            </div>                        
                        </div>
                        <div slot="content">
                            <h4>{{item.name}}</h4>
                            <p class="mt-10">{{item.remark}}</p>
                            <p class="mt-10">{{item.date}}</p>
                        </div>
                    </el-tooltip>
                </el-col>
            </el-row>
        </div>
    </main>
    <!-- #main -->
</div>
<!-- #primary -->


<script>
    let DoubanPageSize = 20;
    let app = new Vue({
        el: ".page-movie",
        data: {
            colors: ['#99A9BF', '#F7BA2A', '#FF9900'],
            curBooks_read: 0,
            curBooks_reading: 0,
            curBooks_wish: 0,
            curMovies: 0,
            list: [],
            fullscreenLoading: false,
            loading: '',
        },
        created: function() { 
            this.loading = this.$loading({
                target: document.querySelector("#douban-movie-list")[0],
                lock: true,
                background: 'rgba(0, 0, 0, 0.8)'
            });       
            this.loadMovies();
        },
        methods: {
            loadMovies: function() {
                if ($("#douban-movie-list").length < 1) return;
                axios.post(GLOBAL.homeSourceUrl + "/douban/douban.php?type=movie&from=" + String(this.curMovies)).then(result => {
                    this.list = result.data;
                    setTimeout(() => {
                        this.loading.close();                        
                    }, 2000);
                });
            }
        },
    })
</script>

<style>
    .s-tooltip{
        max-width: 25%
    }
    .doubanboard-list {
        padding: 10px 0;
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

    .doubanboard-title{
        background: #000;
        opacity: .8;
        padding: 8px;
        border-radius: 4px;
    }
    .doubanboard-title a{
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        color: #fff;
        font-size: 0.8rem;
        cursor: pointer; 
    }

    .doubanboard-title a:hover{
        color: #ddd;
    }

    .movie-mark *{
        color:#ff9900
    }
    .doubanboard-title .movie-mark *{
        font-size:.8rem;
    }
</style>

<?php
get_footer();
?>