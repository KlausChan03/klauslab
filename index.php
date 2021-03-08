<?php

/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package KlausLab
 */



get_header();
setPostViews(get_the_ID()); ?>
<style>
  .article-list .entry-action > div {
    position: relative;
    min-width: 100px;

  }

  /* .article-list .entry-action > div::after{
    position: absolute;
    content: '';
    width: 2px;
    height: 16px;
    background-color: #ddd;
    left: 50%;
  } */

  .article-list .entry-action .entry-author{
    min-width: 180px;
  }

  .article-list .entry-main.has-image .entry-summary {
    margin: 0;
    min-height: 120px;
    margin-left: 200px;
    /* margin-top: -5px; */
  }

  .article-list .entry-main .featured-image {
    position: absolute;
  }
</style>
<div id="primary" class="w-1 main-area">
  <main id="main" class="main-content" role="main">

    <!-- 文章列表 -->
    <div class="main-container" v-block>
      <el-tabs @tab-click="changeType">
        <!-- 存在Bug -->
        <el-tab-pane label="all" v-if="false">
          <span slot="label">全部</span>
          <kl-skeleton v-if="ifShowPost"></kl-skeleton>
          <div class="article-list" v-if="!ifShowPost">
            <article class="article-item hentry" v-for="(item,index) in listOfAll" :key="index">
              <template v-if="item.type==='post'">
                <div class="entry-header">
                  <h5 class="entry-title">
                    <a :href="item.link"> {{item.title.rendered}} </a>
                  </h5>
                </div>
                <div class="entry-main flex-hl-vl flex-hw">
                  <div class="featured-image" v-if="item._embedded['wp:featuredmedia']">
                    <img :src="item._embedded['wp:featuredmedia']['0'].source_url" alt="">
                  </div>
                  <p class="entry-summary" v-html="item.excerpt.rendered" :id="item.id"></p>
                </div>
              </template>
              <template v-if="item.type==='shuoshuo'">
                <div class="entry-header">
                  <h5 class="entry-title">
                    <a :href="item.link"> {{item.title.rendered}} </a>
                  </h5>
                </div>
                <div class="entry-main flex-hl-vl flex-hw">
                  <div class="featured-image" v-if="item._embedded['wp:featuredmedia']">
                    <img :src="item._embedded['wp:featuredmedia']['0'].source_url" alt="">
                  </div>
                  <p class="entry-summary" v-html="item.content.rendered" :id="item.id"></p>
                </div>
              </template>
            </article>
          </div>
        </el-tab-pane>
        <!-- 开发ing -->
        <el-tab-pane label="recommend" v-if="false">
          <span slot="label">推荐</span>
          <kl-skeleton v-if="ifShowAll"></kl-skeleton>
          <div class="article-list" v-if="!ifShowAll">
            <article class="article-item hentry" v-for="(item,index) in listOfRecommend" :key="index">
              <template v-if="item.type==='post'">
                <div class="entry-header">
                  <h5 class="entry-title">
                    <a :href="item.link"> {{item.title.rendered}} </a>
                  </h5>
                </div>
                <div class="entry-main flex-hl-vl flex-hw">
                  <div class="featured-image" v-if="item._embedded['wp:featuredmedia']">
                    <img :src="item._embedded['wp:featuredmedia']['0'].source_url" alt="">
                  </div>
                  <p class="entry-summary" v-html="item.excerpt.rendered" :id="item.id"></p>
                </div>
              </template>
              <template v-if="item.type==='shuoshuo'">
                <div class="entry-header">
                  <h5 class="entry-title">
                    <a :href="item.link"> {{item.title.rendered}} </a>
                  </h5>
                </div>
                <div class="entry-main flex-hl-vl flex-hw">
                  <!-- <div class="featured-image" v-if="item._embedded['wp:featuredmedia']">
                    <img :src="item._embedded['wp:featuredmedia']['0'].source_url" alt="">
                  </div> -->
                  <p class="entry-summary" v-html="item.content.rendered" :id="item.id"></p>
                </div>
              </template>
            </article>
          </div>
        </el-tab-pane>
        <el-tab-pane label="article">
          <span slot="label">文章</span>
          <kl-skeleton v-if="ifShowPost"></kl-skeleton>
          <div class="article-list" v-if="!ifShowPost">
            <article class="article-item hentry" v-for="(item,index) in listOfArticle" :key="index">
              <!-- <div class="entry-header">
                <h5 class="entry-title">
                  <a :href="item.link"> {{item.title.rendered}} </a>
                </h5>
              </div>
              <div class="entry-main flex-hl-vl flex-hw" :class={"has-image":item._embedded['wp:featuredmedia']}>
                <div class="featured-image" v-if="item._embedded['wp:featuredmedia']">
                  <img :src="item._embedded['wp:featuredmedia']['0'].source_url" alt="">
                </div>
                <p class="entry-summary" v-html="item.excerpt.rendered" :id="item.id"></p>
              </div>
              <div class="entry-footer flex-hb-vc flex-hw">
                <div class="entry-action flex-hb-vc flex-hw">
                  <div class="entry-author  fs-16 flex-hl-vc">
                    <img :src="item._embedded.author[0].avatar_urls[48]" alt="" class="mr-5" style="width:32px;height:32px;">
                    <div class="flex-v flex-hc-vt">
                      <span class="fs-12">{{item._embedded.author[0].name}}</span>
                      <span class="fs-12">{{item.date | formateDate}}</span>
                    </div>
                  </div>
                  <div class="entry-view ">
                    <i class="lalaksks lalaksks-ic-view mr-5"></i><span>{{item.post_metas.views}}</span>
                  </div>
                  <div class="entry-comment flex-hl-vc">
                    <i class="lalaksks lalaksks-ic-reply mr-5 pt-5" :style='{color:item.post_metas.comments_num > 0 ? "#4488EE":"inhert"}'></i>
                    <span :style='{color:item.post_metas.comments_num > 0 ? "#4488EE":"inhert"}'>{{item.post_metas.comments_num > 0 ? item.post_metas.comments_num : ''}}</span>
                  </div>
                  <div class="entry-zan flex-hl-vc" style="cursor:not-allowed">
                    <el-tooltip content="开发中" effect="dark" placement="top">
                      <div>
                        <i class="lalaksks lalaksks-ic-zan fs-16 mr-5" :style='{color:item.post_metas.zan_num > 0 ? "#FFB11B":"inhert"}'></i>
                        <span :style='{color:item.post_metas.zan_num > 0 ? "#FFB11B":"inhert"}'>{{item.post_metas.zan_num}}</span>
                      </div>

                    </el-tooltip>
                  </div>
                </div>
                <div class="entry-extra">
                  <button data-action="expand" data-id="<?php the_ID(); ?>" class="expand-btn kl-btn kl-btn-sm gradient-blue-red border-n show">预览全文</button>
                  <button data-action="collapse" data-id="<?php the_ID(); ?>" class="collapse-btn kl-btn kl-btn-sm gradient-red-blue border-n hide">收起全文</button>
                </div>
              </div> -->
              
              <article-item :post-data="item"></article-item>
            </article>
          </div>
        </el-tab-pane>
        <el-tab-pane label="chat">
          <span slot="label">说说</span>
          <kl-skeleton v-if="ifShowChat"></kl-skeleton>
          <div class="article-list" v-if="!ifShowChat">
            <article class="article-item hentry" v-for="(item,index) in listOfChat" :key="index">
              <chat-item :post-data="item"></chat-item>
              
            </article>
          </div>
        </el-tab-pane>
      </el-tabs>
      <!-- 加载按钮 -->
      <!-- <el-button @click="new_page" id="scoll_new_list" style="opacity:0"></button> -->
      <!-- 加载按钮 -->
      <el-card class="flex-hc-vc">
        <el-pagination layout="prev, pager, next, jumper" background :page-size="per_page" :current-page.sync="page" :total="getTotal" :hide-on-single-page="judgeCount" @current-change="handleCurrentChange">
        </el-pagination>
      </el-card>

    </div>
    <!-- <div class="page-navi m-tb-10 flex-hc-vc"><?php wp_pagenavi(); ?></div> -->

  </main>
  <!-- #main -->
</div>
<!-- #primary -->
<script>
  window.post_count = <?php $count_posts = wp_count_posts();
  echo $published_posts = $count_posts->publish; ?>
</script>
<script type="text/javascript" src="<?php echo KL_THEME_URI; ?>/js/component/skeleton.js"></script>
<script type="text/javascript" src="<?php echo KL_THEME_URI; ?>/js/component/articleItem.js"></script>
<script type="text/javascript" src="<?php echo KL_THEME_URI; ?>/js/component/chatItem.js"></script>
<script type="text/javascript" src="<?php echo KL_THEME_URI; ?>/js/page/index.js"></script>
<?php
// get_sidebar(); 
?>
<?php get_footer(); ?>