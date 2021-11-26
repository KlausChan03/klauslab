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
?>
<link rel="stylesheet" href="<?php echo KL_THEME_URI; ?>/css/index.css">
<script>
  window.post_count = "<?php wp_count_posts(); ?>";
</script>

<div id="primary" class="main-area <?php $is_show_sidebar = boolval(cs_get_option('klausLab_sideBar_switcher'));
                                    echo ($is_show_sidebar == 1 ? '' : 'w-1'); ?>">
  <main id="main" class="main-content pos-r" role="main" v-block>
    <!-- 文章列表 -->
      <el-tabs @tab-click="changeType">
        <el-tab-pane label="article">
          <span slot="label"><i class="el-icon-tickets mr-5"></i>文章</span>
          <div v-if="!ifShowPost" class="article-list" >
            <article class="article-item hentry" v-for="(item,index) in listOfArticle" :key="index">
              <article-item :post-data="item" @change-type="changeItemType" @show-comment="showItemComment"></article-item>
              <quick-comment :ref="'quickComment-'+item.id" callback="true" :comment-data="item.listOfComment" :post-data="item" v-if="item.ifShowComment"></quick-comment>
            </article>
          </div>
          <kl-skeleton v-if="ifShowPost || totalOfArticle === 0" type="post"></kl-skeleton>
        </el-tab-pane>
        <el-tab-pane label="chat">
          <span slot="label"><i class="el-icon-connection mr-5"></i>瞬间</span>
          <div v-if="!ifShowChat" class="article-list">
            <article class="article-item hentry" v-for="(item,index) in listOfChat" :key="index">
              <chat-item :post-data="item" @show-comment="showItemComment"></chat-item>
              <quick-comment :ref="'quickComment-'+item.id" callback="true" :comment-data="item.listOfComment" :post-data="item" v-if="item.ifShowComment"></quick-comment>
            </article>
          </div>
          <kl-skeleton v-if="ifShowChat || totalOfArticle === 0" type="post"></kl-skeleton>
        </el-tab-pane>
        <!-- 存在Bug -->
        <el-tab-pane label="all" v-if="false">
          <span slot="label">全部</span>
          <kl-skeleton v-if="ifShowPost" type="post"></kl-skeleton>
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
              <template v-if="item.type==='moments'">
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
          <kl-skeleton v-if="ifShowAll" type="post"></kl-skeleton>
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
              <template v-if="item.type==='moments'">
                <div class="entry-header">
                  <h5 class="entry-title">
                    <a :href="item.link"> {{item.title.rendered}} </a>
                  </h5>
                </div>
                <div class="entry-main flex-hl-vl flex-hw">
                  <p class="entry-summary" v-html="item.content.rendered" :id="item.id"></p>
                </div>
              </template>
            </article>
          </div>
        </el-tab-pane>
      </el-tabs>
      <div class="setting-part pos-a">
        <el-dropdown size="mini" trigger="click" split-button type="default" @command="handleCommand">
          <i class="el-icon-sort fs-12"></i><span class="ml-5 fs-12">{{getOrderby}}</span>
          <el-dropdown-menu slot="dropdown">
            <el-dropdown-item :command="item.type" v-for="(item,index) in orderbyList" :key="item.type">{{item.name}}</el-dropdown-item>
          </el-dropdown-menu>
        </el-dropdown>
      </div>
      <el-card class="flex-hc-vc mt-15" shadow="hover">
        <el-pagination layout="prev, pager, next" background :pager-count="getPaperSize" :page-size="per_page" :current-page.sync="page" :total="getTotal" :hide-on-single-page="judgeCount" @current-change="handleCurrentChange">
        </el-pagination>
      </el-card>
      <!-- <el-image v-if="imgList && imgList.length > 0"></el-image> -->
      <div class="image-part" v-if="imageUrl">
        <el-image ref="imageUrl" style="width: 0; height: 0;" :src="imageUrl" :preview-src-list="imageUrls"> </el-image>
      </div>
  </main>
  <!-- #main -->
</div>
<!-- #primary -->
<!-- <script type="text/javascript" src="<?php echo KL_THEME_URI; ?>/js/lib/tinymce-vue.min.js"></script> -->
<script type="text/javascript" src="<?php echo KL_THEME_URI; ?>/js/component/skeleton.js" defer></script>
<script type="text/javascript" src="<?php echo KL_THEME_URI; ?>/js/component/articleItem.js" defer></script>
<script type="text/javascript" src="<?php echo KL_THEME_URI; ?>/js/component/chatItem.js" defer></script>
<script type="text/javascript" src="<?php echo KL_THEME_URI; ?>/js/component/quickCommentItem.js" defer></script>
<script type="text/javascript" src="<?php echo KL_THEME_URI; ?>/js/component/quickComment.js" defer></script>
<script type="text/javascript" src="<?php echo KL_THEME_URI; ?>/js/page/index.js" defer></script>
<?php
$is_show_sidebar == 1 ?  get_sidebar() : ''
?>
<?php get_footer(); ?>