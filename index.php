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
        <el-tab-pane label="recommend">
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
                  <div class="featured-image" v-if="item._embedded['wp:featuredmedia']">
                    <img :src="item._embedded['wp:featuredmedia']['0'].source_url" alt="">
                  </div>
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
            </article>
          </div>
        </el-tab-pane>
        <el-tab-pane label="chat">
          <span slot="label">说说</span>
          <kl-skeleton v-if="ifShowChat"></kl-skeleton>
          <div class="article-list" v-if="!ifShowChat">
            <article class="article-item hentry" v-for="(item,index) in listOfChat" :key="index">
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
  window.post_count = <?php $count_posts = wp_count_posts(); echo $published_posts =$count_posts->publish; ?>
</script>
<script type="text/javascript" src="<?php echo KL_THEME_URI; ?>/js/component/skeleton.js"></script>
<script type="text/javascript" src="<?php echo KL_THEME_URI; ?>/js/page/index.js"></script>
<?php
// get_sidebar(); 
?>
<?php get_footer(); ?>