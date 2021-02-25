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
        <el-tab-pane label="chat" >
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
    </div>
    <!-- <div class="page-navi m-tb-10 flex-hc-vc"><?php wp_pagenavi(); ?></div> -->

  </main>
  <!-- #main -->
</div>
<!-- #primary -->
<script type="text/javascript" src="<?php echo KL_THEME_URI; ?>/js/component/skeleton.js"></script>
<script type="text/javascript" src="<?php echo KL_THEME_URI; ?>/js/page/index.js"></script>
<?php
// get_sidebar(); 
?>
<?php get_footer(); ?>