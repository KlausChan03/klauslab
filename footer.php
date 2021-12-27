<?php

/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package KlausLab
 */

?>
</main>

<footer id="footer" class="site-footer" role="contentinfo" v-cloak>
  <div class="site-info flex-hc-vc flex-v">
    <p class="flex-hc-vc flex-hw"><span>Theme KlausLab designed by Klaus &amp; Laura</span><span v-if="!ifMobileDevice" class="m-lr-5">|</span><span>All Rights Reserved</span></p>
    <p>版权所有 © {{startFullYear}}-{{nowFullYear}}
      <a href="http://beian.miit.gov.cn" rel="nofollow" target="_blank" v-if="icpNum">
        {{icpNum}} 号
      </a>
    </p>
  </div>
</footer>

<!-- background 动画 -->
<div class="Snow"></div>
<div class="Gravity"></div>

<!-- fixed 工具 -->
<div id="fixed-plugins" class="fixed-plugins flex-v flex-hl-vc">
  <el-backtop style="position:static"  :bottom="15" :right="15">
    <div class="fp-items"><i class="lalaksks lalaksks-ic-backtotop"></i></div>
  </el-backtop>
  <!-- <div class="fp-user pos-r" style="margin-top:3px">
    <template v-if="isLogin">
      <div class="fp-items fp-logout">
        <a href="<?php echo wp_logout_url() ?>" class="logout-btn"><i class="lalaksks lalaksks-ic-logout"></i></a>
      </div>
    </template>
    <template v-else>
      <div class="fp-items fp-register hide pos-a" style="right: 45px">
        <a href="<?php echo wp_registration_url() ?>" class="register-btn"><i class="lalaksks lalaksks-ic-register"></i></a>
      </div>
      <div class="fp-items fp-login">
        <a href="<?php echo wp_login_url() ?>" class="login-btn"><i class="lalaksks lalaksks-ic-login"></i></a>
      </div>
    </template> -->
</div>

<!-- 待开发 -->
<!-- <div class="fp-items" v-if="ifShowChangeMode">
    <a title="浅色模式" class="fp-day"><i class="lalaksks lalaksks-ic-day"></i></a>
    <a title="浅色模式" class="fp-night hide"><i class="lalaksks lalaksks-ic-night"></i></a>
  </div> -->


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