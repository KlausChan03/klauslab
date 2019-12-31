<?php

/**
 *  @package KlausLab
 *  Template Name: 首页
 *  author: Klaus
 */
get_header();
?>

<div id="primary" class="main-area w-1">
    <main id="main" class="main-content" role="main">
        <section id="page-home" class="flex-hc-vc flex-v p-20">
            <div class="row w-1">
                <div class="col-md-7 col-sm-12 p-20">
                    <img class="img-shadow" :src="tempImgSrc" alt="">
                </div>
                <div class="col-md-5 col-sm-12 p-20">
                    <a :href="shopSiteHref" target="_blank"> <button class="kl-btn kl-btn-primary kl-btn-lg w-1"> 个人商城[探索中] </button> </a>
                </div>
            </div>

        </section>
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