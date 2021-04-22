<?php

/**
 *  @package KlausLab
 *  Template Name: 首页
 *  author: Klaus
 */
get_header();
?>

<div id="primary" class="page-home main-area w-1">
    <main id="main" class="main-content" role="main">
        <section class="flex-hc-vc flex-v">
            <div class="row w-1 flex-hc-vc">
                <div class="col-md-7 col-sm-12">
                    <img class="img-shadow" :src="tempImgSrc" alt="">
                </div>
                <div class="col-md-5 col-sm-12 hide">
                    <a :href="shopSiteHref" target="_blank"> <button class="track-btn pr tac kl-btn kl-btn-primary kl-btn-lg w-1" @mousemove="move"> 个人商城[探索中] </button> </a>
                </div>
            </div>
        </section>
    </main>
    <!-- #main -->
</div>
<!-- #primary -->

<script>
    let app = new Vue({
        el: ".page-home",
        data: {
            tempImgSrc: '',
            shopSiteHref: '',
        },
        created: function() {
            this.tempImgSrc = this.GLOBAL.tempImgSrc();
            this.shopSiteHref = this.GLOBAL.shopSiteHref;
        },
        methods: {
            move(e) {
                const x = e.pageX - e.target.offsetLeft;
                const y = e.pageY - e.target.offsetTop;
                e.target.style.setProperty("--x", `${x}px`);
                e.target.style.setProperty("--y", `${y}px`);
            }
        }

    })
</script>

<?php
get_footer();
?>