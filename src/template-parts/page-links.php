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
      <article class="post-<?php the_ID(); ?> page-main style-18">
        <div class="entry-header flex-hc-vc">
          <?php the_title( '<h3 class="entry-title">', '</h3>' ); ?>     
          <?php if ( is_single() || is_page() && has_post_thumbnail() ) : ?>
            <div id="banner-bg" class="featured-header-image">
                <?php the_post_thumbnail( 'KlausLab-home' ); ?>
            </div><!-- .featured-header-image -->
          <?php endif; ?> 
        </div><!-- .entry-header --> 
        <div class="entry-content page-content">
          <div class="entry-content-list"><?php echo (get_link_items());  ?></div>
        </div> 
        <?php edit_post_link( esc_html__( 'Edit', 'KlausLab' ), '<footer class="entry-footer clear"><span class="edit-link">', '</span></footer><!-- .entry-footer -->' ); ?>                          
      </article>
    <?php endif; ?>
  </main>
</div>
<?php get_footer();