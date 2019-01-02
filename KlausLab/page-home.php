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
        <div class="p-20"><h2>{{content}}</h2></div>
        <div class="p-20"><img v-bind:src='picture' alt=""></div>
    </section>
  </main>
  <!-- #main --> 
</div>
<script>
    var vm = new Vue({
        el:"#app",
        data:{
            content:"这是新的首页",
            picture:"https://www.klauslaura.com/wp-content/uploads/2019/01/5f9a28eb0b877dd805224243ef377ec7.jpg"
        }
    })
</script>
<!-- #primary -->
<?php 
    get_footer(); 
?>