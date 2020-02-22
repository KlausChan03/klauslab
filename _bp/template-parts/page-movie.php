<?php

/**
 *  @package KlausLab
 *  Template Name: 电影
 *  author: Klaus
 */
get_header();
wp_enqueue_script( 'doubanjs', get_template_directory_uri() . '/js/douban.js', false, '1.0',array('jquery') );
wp_enqueue_style( 'doubancss', get_template_directory_uri() . '/css/douban.css', false, '1.0' );
?>

<div id="primary" class="page-movie main-area w-1">
    <main id="main" class="main-content" role="main">        
        <h1 class="flex-hc-vc">我看过的电影</h1>
        <div id="douban-movie-list" class="doubanboard-list">
        </div>
    </main>
    <!-- #main -->
</div>
<!-- #primary -->

<script>
    let DoubanPageSize = 20;
     let app = new Vue({
        el: ".page-movie",
        data: {
            tempImgSrc: '',
            shopSiteHref: '',
        },
        created: function() {
            this.tempImgSrc = this.GLOBAL.tempImgSrc();
            this.shopSiteHref = this.GLOBAL.shopSiteHref;
        },
    })
</script>

<?php
get_footer();
?>