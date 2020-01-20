<?php

/**
 *  @package KlausLab
 *  Template Name: 备份
 *  author: Klaus
 */
get_header();
wp_enqueue_script( 'doubanjs', get_template_directory_uri() . '/js/douban.js', false, '1.0',array('jquery') );
wp_enqueue_style( 'doubancss', get_template_directory_uri() . '/css/douban.css', false, '1.0' );
?>

<div id="primary" class="main-area w-1">
    <main id="main" class="main-content" role="main">
        <h1 style="text-align: center;">我看过的电影</h1>
        <script>
            var DoubanPageSize = 20;
        </script>
        <div id="douban-movie-list" class="doubanboard-list"></div>
    </main>
    <!-- #main -->
</div>
<!-- #primary -->

<script>
    let app = new Vue({
        el: "#page-home",
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