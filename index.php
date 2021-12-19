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

<link rel="stylesheet" href="<?php echo KL_THEME_URI; ?>/css/page/index.css">
<script type="text/javascript">
  window.is_sidebar = "<?php $is_sidebar = boolval(cs_get_option('klausLab_sideBar_switcher'));
                        echo $is_sidebar; ?>";
  window._AMapSecurityConfig = {
    securityJsCode: '63ff502b168849801ec542fe31304563',
  }
</script>

<div id="post-container" class="main-area main-content pos-r" :class="!isSidebar ? 'w-1': ''" role="main" v-cloak>
  <el-tabs @tab-click="changeType">
    <el-tab-pane label="article">
      <span slot="label"><i class="el-icon-tickets mr-5"></i>文章</span>
      <template v-if="ifShowPost">
        <template v-if="listOfArticle.length > 0">
          <!-- 文章列表 -->
          <article class="article-list hentry" v-for="(item,index) in listOfArticle" :key="item.id">
            <article-item clss="article-item" :post-data="item" @change-type="changeItemType" @show-comment="showItemComment"></article-item>
            <quick-comment :ref="'quickComment-'+item.id" callback="true" :comment-data="item.listOfComment" :post-data="item" v-if="item.ifShowComment"></quick-comment>
          </article>
        </template>
        <template v-else>
          <el-empty class="flex-hc-vc flex-v" style="min-height: 300px"></el-empty>
        </template>
      </template>
      <kl-skeleton v-else type="post"></kl-skeleton>
    </el-tab-pane>
    <el-tab-pane label="chat">
      <span slot="label"><i class="el-icon-connection mr-5"></i>瞬间</span>
      <template v-if="ifShowChat">
        <template v-if="listOfChat.length > 0">
          <article class="article-list hentry" v-for="(item,index) in listOfChat" :key="item.id">
            <chat-item clss="article-item" :post-data="item" @show-comment="showItemComment"></chat-item>
            <quick-comment :ref="'quickComment-'+item.id" callback="true" :comment-data="item.listOfComment" :post-data="item" v-if="item.ifShowComment"></quick-comment>
          </article>
        </template>
        <template v-else>
          <el-empty class="flex-hc-vc flex-v" style="min-height: 300px"></el-empty>
        </template>
      </template>
      <kl-skeleton v-else type="post"></kl-skeleton>
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
  <el-card class="flex-hc-vc mt-15" shadow="hover" v-if="per_page[postType]">
    <el-pagination layout="prev, pager, next" background :page-size="per_page[postType]" :current-page.sync="page" :total="getTotal" :hide-on-single-page="judgeCount" @current-change="handleCurrentChange">
    </el-pagination>
  </el-card>
  <div class="image-part" v-if="imageUrl">
    <el-image ref="imageUrl" style="width: 0; height: 0;" :src="imageUrl" :preview-src-list="imageUrls"> </el-image>
  </div>
</div>

<script type="text/javascript" src="https://webapi.amap.com/maps?v=1.4.15&key=7c7a39e2e07d4245fa9c21dece87bf93&plugin=AMap.Geocoder" defer></script>
<script type="text/javascript" src="<?php echo KL_THEME_URI; ?>/js/component/articleItem.js" defer></script>
<script type="text/javascript" src="<?php echo KL_THEME_URI; ?>/js/component/chatItem.js" defer></script>
<script type="text/javascript" src="<?php echo KL_THEME_URI; ?>/js/component/quickCommentItem.js" defer></script>
<script type="text/javascript" src="<?php echo KL_THEME_URI; ?>/js/component/quickComment.js" defer></script>
<script type="text/javascript" src="<?php echo KL_THEME_URI; ?>/js/page/index.js" defer></script>

<?php $is_sidebar ? get_sidebar() : ''; ?>
<?php get_footer(); ?>