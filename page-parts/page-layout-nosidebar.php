<?php
/**
*  @package KlausLab
*  Template Name: 无侧边栏
*  author: Klaus
*/

get_header(); ?>

<div id="primary" class="main-area w-1">
  <main id="main" class="main-content" role="main">
    <?php while ( have_posts() ) : the_post(); ?>
    <?php get_template_part( 'template-parts/content', 'page' ); ?>
    <?php
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
				?>
    <?php endwhile; // End of the loop. ?>
  </main>
  <!-- #main --> 
</div>
<!-- #primary -->
<?php get_footer(); ?>
