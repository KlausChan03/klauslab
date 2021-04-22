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
  .article-list .entry-action .entry-author {
    min-width: 120px;
  }

  .article-list .entry-action .entry-action-main span {
    display: inline-block;
    width: 30px;
    /* text-align: left; */
  }

  .article-list .entry-main.has-image .entry-summary {
    margin: 0;
    min-height: 120px;
    margin-left: 200px;
  }

  .article-list .entry-main .featured-image {
    position: absolute;
  }

  .article-list .entry-action .entry-action-main span {
    text-align: right;
  }

  .article-list .entry-action-main .lalaksks {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background-color: transparent;
    display: flex;
    justify-content: center;
    align-items: center;
    transition: all .2s;
    margin: 0;
  }

  /* .article-list .entry-action-main .lalaksks:hover {
    color: transparent;
  } */
  .article-list .entry-action-main .lalaksks.lalaksks-ic-reply:hover {
    background-color: #A0C4F2;
  }

  .article-list .entry-action-main .lalaksks.lalaksks-ic-zan:hover {
    background-color: #F5B4A7;
  }

  .setting-part {
    top: 10px;
    right: 10px;
  }
  .comment-list,.comment-input{
    position: relative;
  }

  #comments > .comment-list:before{
    position: absolute;
    content: '评论列表';
    background: #42A5F5;
    color: #fff;
    left: calc(-1.6rem - 20px);
    word-wrap: break-word;
    width: 20px;
    text-align: center;
    font-size: 12px;
    border-top-left-radius: 4px;
    border-bottom-left-radius: 4px;
    padding: 4px;
  }

  #comments > .comment-input:before{
    position: absolute;
    content: '评论发布';
    background: #42A5F5;
    color: #fff;
    left: calc(-1.6rem - 20px);
    word-wrap: break-word;
    width: 20px;
    text-align: center;
    font-size: 12px;
    border-top-left-radius: 4px;
    border-bottom-left-radius: 4px;
    padding: 4px;
  }

  @media screen and (max-width: 720px) {
    .article-list .entry-main .featured-image {
      width: 100%;
      position: relative;
      margin: 0;
      height: 200px;
    }

    .article-list .entry-main .featured-image img {
      width: 100%;
      height: 200px;
    }

    .article-list .entry-main.has-image .entry-summary {
      margin: 0;
      margin-top: 1rem;
      width: 100%;
      min-height: auto;
    }

    .article-list .entry-main .entry-summary {
      text-align: justify;
      /* text-align-last: justify; */
    }

  }
</style>
<script>
  window._nonce = "<?php echo wp_create_nonce( 'wp_rest' ); ?>";

  window.ifMobileDevice = document.body.offsetWidth <= 720 ? true : false
  window.post_count = <?php $count_posts = wp_count_posts();
                      echo $published_posts = $count_posts->publish; ?>
</script>

<div id="primary" class="main-area">
  <main id="main" class="main-content" role="main">
    <!-- 文章列表 -->
    <div class="main-container pos-r" v-block>
      <el-tabs @tab-click="changeType">
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
          <kl-skeleton v-if="ifShowPost" type="post"></kl-skeleton>
          <div class="article-list" v-if="!ifShowPost">
            <article class="article-item hentry" v-for="(item,index) in listOfArticle" :key="index">
              <article-item :post-data="item" @change-type="changeItemType" @show-comment="showItemComment" ></article-item>
              <quick-comment :comment-data="item.listOfComment" :post-data="item" :tiny-key="tinyKey" v-if="item.ifShowComment" @change="changeCommentCurrent"></quick-comment>
              
            </article>
          </div>
        </el-tab-pane>
        <el-tab-pane label="chat">
          <span slot="label">说说</span>
          <kl-skeleton v-if="ifShowChat" type="post"></kl-skeleton>
          <div class="article-list" v-if="!ifShowChat">
            <article class="article-item hentry" v-for="(item,index) in listOfChat" :key="index">
              <chat-item :post-data="item" @show-comment="showItemComment"></chat-item>
              <quick-comment :comment-data="item.listOfComment" :post-data="item" :tiny-key="tinyKey" v-if="item.ifShowComment" @change="changeCommentCurrent"></quick-comment>

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

      <el-card class="flex-hc-vc mt-15">
        <el-pagination layout="prev, pager, next, jumper" background :pager-count="getPaperSize" :page-size="per_page" :current-page.sync="page" :total="getTotal" :hide-on-single-page="judgeCount" @current-change="handleCurrentChange">
        </el-pagination>
      </el-card>
    </div>
  </main>
  <!-- #main -->
</div>
<!-- #primary -->
<!-- <script type="text/javascript" src="<?php echo KL_THEME_URI; ?>/js/lib/tinymce-vue.min.js"></script> -->
<script type="text/javascript" src="<?php echo KL_THEME_URI; ?>/js/component/skeleton.js"></script>
<script type="text/javascript" src="<?php echo KL_THEME_URI; ?>/js/component/articleItem.js"></script>
<script type="text/javascript" src="<?php echo KL_THEME_URI; ?>/js/component/chatItem.js"></script>
<script type="text/javascript" src="<?php echo KL_THEME_URI; ?>/js/component/quickCommentItem.js"></script>
<script type="text/javascript" src="<?php echo KL_THEME_URI; ?>/js/component/quickComment.js"></script>
<script type="text/javascript" src="<?php echo KL_THEME_URI; ?>/js/page/index.js"></script>
<?php
get_sidebar();
?>
<?php get_footer(); ?>