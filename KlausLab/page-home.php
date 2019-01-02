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
    <section id="app">
        {{content}}
    </section>
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