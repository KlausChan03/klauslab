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

<script>
  window.start_time = new Date("<?php echo cs_get_option('klausLab_start_time'); ?>").getFullYear();
</script>

<!-- .wrap  -->
<footer id="colophon" class="site-footer flex-hc-vc" role="contentinfo">
  <div class="site-info">
    <p><span>Theme KlausLab By Klaus | All Rights Reserved</span></p>
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
      <el-tooltip content="登出" effect="dark" placement="bottom">
        <div class="fp-items fp-logout">
          <a href="<?php echo wp_logout_url() ?>" class="logout-btn"><i class="lalaksks lalaksks-ic-logout"></i></a>
        </div>
      </el-tooltip>
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
<script>
  let footerPart = new Vue({
    el: '#colophon',
    mounted: function() {
      let blog_create_time, our_love_time, our_info, photo_container = document.querySelector('.photo-container');
      let _this = this
      const h = this.$createElement;
      let params = new FormData;
      params.append('action', 'love_time');
      axios.post(`${GLOBAL.homeUrl}/wp-admin/admin-ajax.php`, params).then((res) => {
        blog_create_time = res.data[0].user_registered; // 博客建立时间（根据第一个用户诞生时间）
        our_love_time = `2015-05-23 20:00:00`; // 恋爱时间
        our_info = [res.data[1].nickname, res.data[1].img, res.data[2].nickname, res.data[2].img];
        if (photo_container) {
          photo_container.innerHTML = ` <span class="m-lr-10"><img src="https://${our_info[1]}"></span> <i class="lalaksks lalaksks-ic-heart-2 throb"></i> <span class="m-lr-10"><img src="https://${our_info[3]}"></span> `;
        }
        if (document.getElementById("createtime")) {
          window.showCreateTime = setInterval(() => {
            _this.kl_count(blog_create_time, '#createtime', '它已经运作了')
          }, 1000);
        }
        if (document.getElementById("lovetime")) {
          window.showLoveTime = setInterval(() => {
            _this.kl_count(our_love_time, '#lovetime', '他与她相恋了')
          }, 1000);
        }
        if (document.querySelector("#thisYear")) {
          const thisYear = document.querySelector("#thisYear");
          thisYear.innerHTML = new Date().getFullYear();
        }
      })
    },
    methods: {
      kl_count(_time, _dom, _content) {
        if (_time) {
          _time = _time.replace(/-/g, "/");
          // 计算出相差毫秒
          var create_time = new Date(_time);
          var now_time = new Date();
          var count_time = now_time.getTime() - create_time.getTime()

          //计算出相差天数
          var days = Math.floor(count_time / (24 * 3600 * 1000))

          //计算出相差小时数
          var leave = count_time % (24 * 3600 * 1000)
          var hours = Math.floor(leave / (3600 * 1000))
          hours = hours >= 10 ? hours : "0" + hours

          //计算相差分钟数
          var leave = leave % (3600 * 1000)
          var minutes = Math.floor(leave / (60 * 1000))
          minutes = minutes >= 10 ? minutes : "0" + minutes


          //计算相差秒数
          var leave = leave % (60 * 1000)
          var seconds = Math.round(leave / 1000)
          seconds = seconds >= 10 ? seconds : "0" + seconds

          var _time = days + " 天 " + hours + " 时 " + minutes + " 分 " + seconds + " 秒 ";
          var _final = _content + _time;
          document.querySelector(_dom).innerHTML = _final;
        }
      }
    },
  })
</script>
</body>

</html>