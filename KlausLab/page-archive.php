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
                <ul class="flex-hl-vc">
                  <li class="m-tb-5">
                    <button class="kl-btn kl-btn-sm">Klaus</button>                  
                  </li>
                  <li class="m-tb-5">
                    <button class="kl-btn kl-btn-sm">Laura</button>                  
                  </li>
                </ul>
              </div>
              <div class="filter-type flex-hl-vc">
                <label>类型：</label>
                <ul class="flex-hl-vc">
                  <li class="m-tb-5">
                    <button class="kl-btn kl-btn-sm" data-type="post">文章</button>                  
                  </li>
                  <li class="m-tb-5">
                    <button class="kl-btn kl-btn-sm" data-type="shuoshuo">说说</button>                  
                  </li>
                </ul>
              </div>
            </div>          
            <div class="entry-content-list p-lr-01">              
              
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
          this_type = $(this).data("type"),
          content_dom = $(".entry-content-list");
      if(this_type == "post"){
        console.log(this_type)
        content_dom.html(`<?php archives_list("post"); get_the_content(); ?>`)
      }else if(this_type == "shuoshuo"){
        console.log(this_type)
        content_dom.html(`<?php archives_list("shuoshuo"); get_the_content(); ?>`)
      }

      // content_dom.html(`<?php $post_type = ${this_type}; archives_list($post_type); the_content(); ?>`)

      // var req = {
      //     action: "preview_post",
      //     um_id: this_id,
      //     um_action: this_action
      // };
      // $.post("/wp-admin/admin-ajax.php", req, function (res) {
      //     var content = res;
      //     this_dom.removeClass("hide").html(content);
      //     this_dom.siblings().addClass("hide");

      //     this_.siblings().removeClass("hide").addClass("show");
      //     this_.removeClass("show").addClass("hide");

      // });
  })
</script>
<?php get_footer();