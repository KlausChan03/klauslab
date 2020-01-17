<?php

/**
 *  @package KlausLab
 *  Template Name: 电影
 *  author: Klaus
 */
get_header();
?>

<div id="primary" class="main-area w-1">
    <main id="main" class="main-content" role="main">
        <h1 style="text-align: center;">我看过的电影</h1>
        <script type="text/javascript">
            var head = document.getElementsByTagName('head')[0];
            var link = document.createElement('link');
            link.type = 'text/css';
            link.rel = 'stylesheet';
            link.href = './wp-content/themes/KlausLab/css/douban.css';
            head.appendChild(link);
        </script>
        <script>
            var DoubanPageSize = 20;
        </script>
        <script type="text/javascript" src="./wp-content/themes/KlausLab/js/douban.js"></script>
        <div id="douban-movie-list" class="doubanboard-list" style="margin-top: -70px;"></div>
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