<?php

/**
 *  @package KlausLab
 *  Template Name: 链集
 *  author: Klaus
 */
get_header();
?>

<script>
		window.link_items = `<?php echo get_link_items(); ?>`;
    window.the_titile = "<?php echo the_title() ?>";
    window.the_ID = "<?php echo the_ID() ?>";
</script>

<div id="container" class="page-main main-area w-1 style-18" :class="'post-'+pageID" v-cloak>
  <el-card shadow="hover">
    <div class="entry-title flex-hl-vc bor-b-1" >
      <svg class="icon icon-title mr-10" aria-hidden="true">
        <use xlink:href="#lalaksks21-browsers-1"></use>
      </svg>
      <h2>{{title}}</h2>
    </div>
    <div class="entry-content">
      <template v-if="listContent">
        <div class="entry-content-list" v-html='listContent'></div>
      </template>
      <template v-else>
        <el-empty></el-empty>
      </template>
    </div>
  </el-card>
</div>

<script defer>
  const app = new Vue({
    el: '#container',
    data: {
      title: window.the_titile,
      pageID: window.the_ID,
      listContent: window.link_items,
      ifGetList: false
    }
  })
</script>

<?php get_footer(); ?>
