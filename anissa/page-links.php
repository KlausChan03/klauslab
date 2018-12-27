<?php 
/**
 *
 * @package WordPress
 * @Theme K&L
 *
 * @author xing930629@163.com
 * @link https://www.klauslaura.com
 * Template Name: 链集
 * Template Post Type: page
 */
get_header();
setPostViews(get_the_ID()); ?>
<div id="primary" class="main-area w-1">
  <main id="main" class="main-content" role="main">
    <?php if (have_posts()) : the_post(); ?>    
      <article class="post-<?php the_ID(); ?> page-main style-18">
        <div class="entry-header flex-hc-vc">
          <?php the_title( '<h1 class="entry-title flex-hc-vc col-fff">', '</h1>' ); ?>     
          <?php if ( is_single() || is_page() && has_post_thumbnail() ) : ?>
            <div id="banner-bg" class="featured-header-image">
                <?php the_post_thumbnail( 'anissa-home' ); ?>
            </div><!-- .featured-header-image -->
          <?php endif; ?> 
        </div><!-- .entry-header --> 
        <div class="entry-content page-content">
          <div class="entry-content-list"><?php echo (get_link_items());  ?></div>
        </div> 
        <?php edit_post_link( esc_html__( 'Edit', 'anissa' ), '<footer class="entry-footer clear"><span class="edit-link">', '</span></footer><!-- .entry-footer -->' ); ?>                          
      </article>
    <?php endif; ?>
  </main>
</div>
<?php get_footer();