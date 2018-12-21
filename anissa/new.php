<?php
    get_header(); 
?>

<div id="primary" class="main-area">
  <main id="main" class="main-content" role="main">
  <?php if (have_posts()) : the_post(); update_post_caches($posts); ?>    
      <article class="post-<?php the_ID(); ?> page-main style-18">
          <div class="entry-header">
            <?php the_title( '<h1 class="entry-title flex-hc-vc col-fff">', '</h1>' ); ?>     
            <?php if ( is_single() || is_page() && has_post_thumbnail() ) : ?>
              <div id="banner-bg" class="featured-header-image">
                  <?php the_post_thumbnail( 'anissa-home' ); ?>
              </div><!-- .featured-header-image -->
            <?php endif; ?> 
          </div><!-- .entry-header --> 
          <div class="entry-content page-content">
            <div class="entry-content-list"><?php archives_list(); the_content(); ?></div>
          </div> 
          <?php edit_post_link( esc_html__( 'Edit', 'anissa' ), '<footer class="entry-footer clear"><span class="edit-link">', '</span></footer><!-- .entry-footer -->' ); ?>                          
      </article>
    <?php endif; ?>
  </main>
  <!-- #main --> 
</div>
<script>
    var vm = new Vue({
        el:"#app",
        data:{
            content:"这是新的首页"
        }
    })
</script>
<!-- #primary -->
<?php 
    get_footer(); 
?>