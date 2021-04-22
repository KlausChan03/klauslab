<?php

/**
 *  @package KlausLab
 *  Template Name: 链集
 *  author: Klaus
 */
get_header();
setPostViews(get_the_ID()); ?>
<div id="primary" class="main-area w-1">
  <main id="main" class="main-content" role="main">
    <?php if (have_posts()) : the_post(); ?>
      <article id="link-main" class="post-<?php the_ID(); ?> page-main style-18">
        <el-card>
          <h2 class="entry-title bor-b-1">
            <svg class="icon icon-title mr-5" aria-hidden="true">
              <use xlink:href="#lalaksks21-browsers-1"></use>
            </svg>
            <?php the_title(); ?>
          </h2>
          <div class="entry-content page-content">
            <template v-if="true">
              <div class="entry-content-list"><?php echo (get_link_items());  ?></div>
            </template>
            <template v-else>
              <kl-empty description="暂无数据"></kl-empty>
            </template>
            
          </div>
          <!-- <?php edit_post_link(esc_html__('Edit', 'KlausLab'), '<footer class="entry-footer clear"><span class="edit-link">', '</span></footer>.entry-footer'); ?> -->
        </el-card>
      </article>

      <?php
      // If comments are open or we have at least one comment, load up the comment template.
      if (comments_open() || get_comments_number()) :
        comments_template();
      endif;
      ?>
    <?php endif; ?>
  </main>
</div>

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
<script>
  let archiveFilter = new Vue({
    el: '#link-main',
    data: {
      listContent: '',
      ifGetList: false
    },
    mounted() {},
    methods: {

    }

  })
</script>
<?php get_footer();
