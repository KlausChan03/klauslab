<?php 
/**
*  @package KlausLab
*  Template Name: 归档
*  author: Klaus
*/
get_header();

setPostViews(get_the_ID()); ?>
<div id="primary" class="main-area w-1">
  <main id="main" class="main-content" role="main">
    <?php if (have_posts()) : the_post(); update_post_caches($posts); ?>    
      <article class="post-<?php the_ID(); ?> page-main style-18">
          <div class="entry-header flex-hc-vc">
            <?php the_title( '<h1 class="entry-title flex-hc-vc col-fff">', '</h1>' ); ?>     
            <?php if ( is_single() || is_page() && has_post_thumbnail() ) : ?>
              <div id="banner-bg" class="featured-header-image">
                  <?php the_post_thumbnail( 'KlausLab-home' ); ?>
              </div><!-- .featured-header-image -->
            <?php endif; ?> 
          </div><!-- .entry-header --> 
          <div class="entry-content page-content">  
            <div class="entry-content-filter p-lr-01">
              <div class="filter-author flex-hl-vc">
                <label>作者：</label>
                <div class="kl-btn-container">
                    <button class="kl-btn kl-btn-sm" data-author="Klaus">Klaus</button>                  
                    <button class="kl-btn kl-btn-sm" data-author="Laura">Laura</button>                  
                  </div>
              </div>
              <div class="filter-type flex-hl-vc">
                <label>类型：</label>
                <div class="kl-btn-container">
                    <button class="kl-btn kl-btn-sm" data-type="post">文章</button>                  
                    <button class="kl-btn kl-btn-sm" data-type="shuoshuo">说说</button> 
                </div>                 
              </div>
            </div>          
            <div class="entry-content-list p-lr-01">              
              <?php archives_list("shuoshuo",null); the_content(); ?>
            </div>
          </div> 
          <?php edit_post_link( esc_html__( 'Edit', 'KlausLab' ), '<footer class="entry-footer clear"><span class="edit-link">', '</span></footer><!-- .entry-footer -->' ); ?>                          
      </article>
    <?php endif; ?>
  </main>
</div>
<script>
  $(document).on("click", ".filter-type button", function () {
      var this_ = $(this),
          that_author,
          this_type = $(this).data("type"),
          content_dom = $(".entry-content-list");
      this_.attr("data-active",true);
      this_.siblings().removeAttr("data-active");
      if(this_type == "post"){
        content_dom.html(`<?php archives_list("post",null); the_content(); ?>`)
      }else if(this_type == "shuoshuo"){
        content_dom.html(`<?php archives_list("shuoshuo",null); the_content(); ?>`)
      }
  })
  $(document).on("click", ".filter-author button", function () {
      var this_ = $(this),
          that_type,
          this_author = $(this).data("author"),
          content_dom = $(".entry-content-list");

      this_.attr("data-active",true);
      this_.siblings().removeAttr("data-active");
      console.log(this_author)
      if(this_author == "Klaus"){
        content_dom.html(`<?php archives_list(null,"Klaus"); the_content(); ?>`)
      }else if(this_author == "Laura"){
        content_dom.html(`<?php archives_list(null,"Laura"); the_content(); ?>`)
      }
  })
</script>
<?php get_footer();