<?php

/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package KlausLab
 */

get_header(); ?>
<script>
  window.post_id = <?php echo get_the_ID(); ?>;
</script>
<div id="primary" class="main-area">
  <main id="main" class="main-content" role="main">
    <div id="page-main">
      <?php while (have_posts()) : the_post(); ?>

        <?php get_template_part('template-parts/content', 'page'); ?>
        <?php
        // If comments are open or we have at least one comment, load up the comment template.
        // if ( comments_open() || get_comments_number() ) :
        // 	comments_template();
        // endif;
        ?>
      <?php endwhile; // End of the loop. 
      ?>
      <aside class="comment-container mt-10" v-if="posts.comment_status === 'open'">
      <h3 class="tips-header flex-hl-vc"><i class="el-icon-chat-line-round fs-24 mr-10"></i>评论区</h3>
        <quick-comment :post-data="posts"></quick-comment>
      </aside>
    </div>

  </main>

  <!-- #main -->
</div>
<!-- #primary -->

<script type="text/javascript" src="<?php echo KL_THEME_URI; ?>/js/component/quickCommentItem.js" defer></script>
<script type="text/javascript" src="<?php echo KL_THEME_URI; ?>/js/component/quickComment.js" defer></script>

<script>
  new Vue({
    el: "#page-main",
    data() {
      return {
        posts: {
          id: window.post_id,
          comment_status: 'open'
        }
      }
    },
  })
</script>
<?php get_sidebar(); ?>
<?php get_footer(); ?>