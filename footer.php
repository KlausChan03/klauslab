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
    <p><span>Theme KlausLab By Klaus | All Rights Reserved</span></p>
    <p>版权所有 © 2016-<span id="thisYear"></span>
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
  <div class="fp-items" v-if="ifShowTChangeMode">
    <a title="浅色模式" class="fp-day"><i class="lalaksks lalaksks-ic-day"></i></a>    
    <a title="浅色模式" class="fp-night hide"><i class="lalaksks lalaksks-ic-night"></i></a>    
  </div>
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
  <!-- <div class="fp-items fp-change-lang">
    <a id="fp-change-lang" title="繁简切换" href="javascript:StranBody()" title="繁體"><i>繁</i></a>
  </div> -->
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
wp_footer();
?>
<script>
  let fixedPlugins = new Vue({
    el:"#fixed-plugins",
    data(){
      return {
        ifShowTChangeMode: false,
      }
    }
  })
  let mainContent  = new Vue({
    el:"#main",
    data(){
      return {
        ifShowPost: false,
      }
    }
  })
  let mainPage = new Vue({
    el: '#app',
    created() {
      // 活动,设置cookie存储时间
      // this.getTimeSetCookieFun()
    },
    data() {
      return {
        ifShowOurMemory: false,
        ourDate:[]
      }
    },
    methods: {
      getTimeSetCookieFun() {
        let day = this.getCookieFun('day') ? this.getCookieFun('day') : ''; //cookie记录日期
        let newTime = new Date().getDate(); //今天日期
        console.log(day,newTime)
        // 判断是否有cookie记录日期
        if (!day) {
          this.setcookieTimeFun('day', newTime, 1)
          this.$notify({ message: '游客，欢迎到此一游。' });
        } else {
          if (newTime > day) {
            this.setcookieTimeFun('day', newTime, 1)
          }
        }
      },

      // 设置cookie时间
      setcookieTimeFun(name, value, Days) {
        value = new Date().getDate();
        var exp = new Date();
        exp.setTime(exp.getTime() + Days * 24 * 60 * 60 * 1000);
        document.cookie = name + "=" + value + ";expires=" + exp.toGMTString();
      },

      // 取出设置的cookie时间,存在就返回获取到的值,不存在返回''
      getCookieFun(c_name) {
        if (document.cookie.length > 0) {
          let c_start = document.cookie.indexOf(c_name + "=");
          if (c_start != -1) {
            c_start = c_start + c_name.length + 1;
            let c_end = document.cookie.indexOf(";", c_start)
            if (c_end == -1) {
              c_end = document.cookie.length;
            }
            return decodeURIComponent(document.cookie.substring(c_start, c_end));
          }
        }
        return "";
      },

      //移除某一个cookie
      delTimeCookie(name) {
        var exp = new Date();
        exp.setTime(exp.getTime() - 1);
        var cval = this.getCookieFun(name);
        if (cval != null)
          document.cookie = name + "=" + cval + ";expires=" + exp.toGMTString();
      }
    }

  });

  let secondary = new Vue({
    element: '.author-info',
  })
</script>
</body>

</html>