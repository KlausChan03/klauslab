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
    <section id="app" class="flex-hc-vc flex-v p-20">
        <div class="row w-1">
            <div class="col-md-8 col-sm-12 p-20">
                <img class="img-shadow" v-bind:src='picture.src' v-bind:width='picture.width' alt="">
            </div>
            <div class="col-md-4 col-sm-12 p-20">
                <!-- <button class="only-her kl-btn kl-btn-pink kl-btn-lg w-1" data-user="<?php $current_user = wp_get_current_user(); echo($current_user->user_login);?>">
                    Laura 专属优惠券
                </button> -->
                <a href="http://shop.klauslaura.com" target="_blank">
                    <button class="kl-btn kl-btn-primary kl-btn-lg w-1" >
                        个人商城[未完成]
                    </button>
                </a>
            </div>
        </div>
       
    </section>
  </main>
  <!-- #main --> 
</div>
<script>
    var vm = new Vue({
        el:"#app",
        data:{
            content:"Home",
            picture:{src:"https://www.klauslaura.com/wp-content/uploads/2019/01/5f9a28eb0b877dd805224243ef377ec7.jpg",width:"100%"}
        }
    })
</script>
<!-- #primary -->
<?php 
    get_footer(); 
?>