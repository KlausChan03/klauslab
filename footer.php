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
<footer id="footer" class="site-footer flex-hc-vc" role="contentinfo">
  <div class="site-info">
    <p><span>Theme KlausLab designed by Klaus & Laura | All Rights Reserved</span></p>
    <p>版权所有 © {{window.start_time}}-<span id="thisYear"></span>
      <!-- <a href="http://www.miitbeian.gov.cn/" rel="nofollow noopener noreferrer" target="_blank"> 粤 ICP 备17095567号</a> -->
      <a href="http://beian.miit.gov.cn" rel="nofollow" target="_blank">
        <?php echo get_option('zh_cn_l10n_icp_num'); ?> 号
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
  <el-backtop style="position:static" target=".site" :bottom="220" :right="15">
    <!-- <el-tooltip content="返回顶部" effect="dark" placement="left"> -->
      <div class="fp-items"><i class="lalaksks lalaksks-ic-backtotop"></i></div>
    <!-- </el-tooltip> -->
  </el-backtop>
  <div class="fp-user pos-r" style="margin-top:3px">
    <?php if (is_user_logged_in()) : global $current_user; ?>
      <!-- <el-tooltip content="登出" effect="dark" placement="bottom"> -->
        <div class="fp-items fp-logout">
          <a href="<?php echo wp_logout_url() ?>" class="logout-btn"><i class="lalaksks lalaksks-ic-logout"></i></a>
        </div>
      <!-- </el-tooltip> -->
    <?php else : ?>
      <!-- <el-tooltip content="注册" effect="dark" placement="bottom"> -->
        <div class="fp-items fp-register hide pos-a" style="right: 45px">
          <a href="<?php echo wp_registration_url() ?>" class="register-btn"><i class="lalaksks lalaksks-ic-register"></i></a>
        </div>
      <!-- </el-tooltip> -->
      <!-- <el-tooltip content="登录" effect="dark" placement="bottom"> -->
        <div class="fp-items fp-login">
          <a href="<?php echo wp_login_url() ?>" class="login-btn"><i class="lalaksks lalaksks-ic-login"></i></a>
        </div>
      <!-- </el-tooltip> -->
    <?php endif ?>
  </div>

  <!-- 待开发 -->
  <div class="fp-items" v-if="ifShowChangeMode">
    <a title="浅色模式" class="fp-day"><i class="lalaksks lalaksks-ic-day"></i></a>
    <a title="浅色模式" class="fp-night hide"><i class="lalaksks lalaksks-ic-night"></i></a>
  </div>


  <!-- <el-tooltip content="搜索" effect="dark" placement="top">
    <div class="flex-hl-vc fp-search pos-r">
      <div class="fp-items fp-search-in" @click="showSearchDialog">
        <a class="flex-hc-vc"><i class="lalaksks lalaksks-ic-search"></i></a>
      </div>
    </div>
  </el-tooltip> -->
  <!-- <div class="flex-hl-vc fp-background pos-r">
    <el-tooltip content="切换背景" effect="dark" placement="top">
      <div class="fp-items fp-background-in">
        <a class="flex-hc-vc"><i class="lalaksks lalaksks-ic-background"></i></a>
      </div>
    </el-tooltip>
    <div class="pos-a hide  fp-background-out" style="right:40px;">
      <ul class="flex-hr-vc">
        <li data-type="snow" class="col-fff mr-5">季节</li>
        <li data-type="gravity" class="col-fff mr-5">引力</li>
      </ul>
    </div>
  </div> -->
  <!-- <div class="fp-items fp-gototop">
    <a title="返回顶部"><i class="lalaksks lalaksks-ic-backtotop"></i></a>
  </div> -->
  <!-- <div class="fp-items fp-change-lang">
    <a id="fp-change-lang" title="繁简切换" href="javascript:StranBody()" title="繁體"><i>繁</i></a>
  </div> -->

</div>
<?php
wp_footer();
?>

</body>

</html>