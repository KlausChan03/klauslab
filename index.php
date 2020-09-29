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

<div id="primary" class="main-area">
  <main id="main" class="main-content" role="main">
    <?php
    $limit = get_option('posts_per_page');
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    query_posts('post_type=shuoshuo&post_status=publish&showposts=' . $limit = 10 . '&paged=' . $paged);
    ?>
    <?php if (have_posts()) : ?>
      <?php /* Start the Loop */ ?>
      <?php while (have_posts()) : the_post(); ?>
        <?php
        /*
					 * Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
        get_template_part('template-parts/content', get_post_format());
        ?>
      <?php endwhile; ?>     
    <?php else : ?>
      <?php get_template_part('template-parts/content', 'none'); ?>
    <?php endif; ?>
    <?php
      the_posts_pagination(array(
        'prev_text' => '上页',
        'next_text' => '下页',
        'before_page_number' => '<span class="meta-nav screen-reader-text">第 </span>',
        'after_page_number' => '<span class="meta-nav screen-reader-text"> 页</span>',
      ));
    ?>
    <!-- <div class="page-navi m-tb-10 flex-hc-vc"><?php wp_pagenavi(); ?></div> -->

  </main>
  <!-- #main -->
</div>
<!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>