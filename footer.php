<?php

/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package KlausLab
 */

?>
</div>
<!-- #content -->
</div>
<!-- .wrap  -->
<footer id="colophon" class="site-footer flex-hc-vc" role="contentinfo">
  <div id="created-time">{{content}}</div>
  <div class="site-info">
    <p><span>一个秀恩爱的博客，</span><span id="createtime"></span></p>
    <p><span>Theme KlausLab By Klaus | All Rights Reserved</span></p>
    <p>版权所有 © 2016-<span id="thisYear"></span>
      <!-- <a href="http://www.miitbeian.gov.cn/" rel="nofollow noopener noreferrer" target="_blank"> 粤 ICP 备17095567号</a> -->
      <a href="http://www.miitbeian.gov.cn/" rel="nofollow" target="_blank">
        <?php echo get_option('zh_cn_l10n_icp_num'); ?>
      </a>
    </p>
  </div>
  <!-- .site-info -->
</footer>

<!-- #colophon -->
</div>
<!-- #page -->


<!-- 背景动画DOM -->
<div class="Snow"></div>
<div class="Gravity"></div>

<!-- 固定小工具 -->
<div id="fixed-plugins" class="fixed-plugins flex-v flex-hl-vc">
  <?php if (is_user_logged_in()) : global $current_user; ?>
    <div class="fp-items fp-logout">
      <a title="登出" href="<?php echo wp_logout_url() ?>" class="logout-btn"><i class="lalaksks lalaksks-ic-logout"></i></a>
    </div>
  <?php else : ?>
    <div class="fp-items fp-register hide">
      <a title="注册" href="<?php echo wp_registration_url() ?>" class="register-btn"><i class="lalaksks lalaksks-ic-register"></i></a>
    </div>
    <div class="fp-items fp-login">
      <a title="登录" href="<?php echo wp_login_url() ?>" class="login-btn"><i class="lalaksks lalaksks-ic-login"></i></a>
    </div>

  <?php endif ?>

  <div class="flex-hl-vc fp-search pos-r">
    <div class="fp-items fp-search-in">
      <a class="flex-hc-vc" title="站内搜索"><i class="lalaksks lalaksks-ic-search"></i></a>
    </div>
    <div class="pos-a hide fp-search-out" style="right:40px;">
      <?php get_search_form(); ?>
    </div>
  </div>

  <div class="fp-items fp-gototop">
    <a title="返回顶部"><i class="lalaksks lalaksks-ic-backtotop"></i></a>
  </div>

  <div class="fp-items fp-change-lang">
    <a id="fp-change-lang" title="繁简切换" href="javascript:StranBody()" title="繁體"><i>繁</i></a>
  </div>
  <div class="flex-hl-vc fp-background pos-r">
    <div class="fp-items fp-background-in">
      <a class="flex-hc-vc" title="切换背景"><i class="lalaksks lalaksks-ic-background"></i></a>
    </div>
    <div class="pos-a hide  fp-background-out" style="right:40px;">
      <ul class="flex-hr-vc">
        <li data-type="snow" class="col-fff mr-5">降雪</li>
        <li data-type="gravity" class="col-fff mr-5">引力</li>
      </ul>
    </div>
  </div>
</div>
<?php 
// 支持
// wp_enqueue_script( 'support', get_template_directory_uri() . '/js/support.js', false, '1.0',array('jquery') );
// // 动画
// wp_enqueue_script( 'canvasFunc', get_template_directory_uri() . '/js/canvas.js', array(), '1.0', false );
// // 右下角固定组件
// wp_enqueue_script( 'fixed-plugins', get_template_directory_uri() . '/js/fixed-plugins.js', array(), '1.0', false );
// wp_localize_script( 'fixed-plugins', 'KlausLabConfig', array(
//   'siteUrl' => get_stylesheet_directory_uri(),
//   'siteStartTime' => cs_get_option( 'memory_start_time' ),
//   'ajaxUrl' => admin_url('admin-ajax.php'),
//   'commentEditAgain' => cs_get_option( 'memory_comment_edit' ),
//   'loadPjax' => cs_get_option( 'memory_pjax' ),
// ));
wp_footer();
?>
<?php
wp_footer();
?>
<script>
  // (function() {
  //   var pro = [],
  //     i = 0,
  //     len = pro.length,
  //     load = function(src) {
  //       if (i < len) {
  //         var img_obj = new Image;
  //         img_obj.src = src;
  //         timer = setInterval(() => {
  //           if (img_obj.complete) {
  //             clearInterval(timer);
  //             load(pro[i++])
  //           }
  //         }, 80);
  //       } else {
  //         setTimeout(() => {
  //           option.pageLoadingMask.remove(document);
  //         }, 1500);
  //       }
  //     };
  //   load(pro[i])
  // })()
</script>
</body>

</html>