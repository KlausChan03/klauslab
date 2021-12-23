<?php

/**
 * The template for displaying 404 pages (not found).
 *
 * @package KlausLab
 */
get_header();
?>

<div id="container" class="page-main main-area w-1 style-18" v-cloak>
  <el-empty description="404"></el-empty>
</div>

<script defer>
  const app = new Vue({
    el: "#container",
  })
</script>
<?php get_footer(); ?>