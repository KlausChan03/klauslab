<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package anissa
 */

?>
</div>
<!-- #content -->
</div>
<!-- .wrap  -->
<footer id="colophon" class="site-footer flex-hc-vc" role="contentinfo">
    <div class="site-info">
    <p><span>一个秀恩爱的博客，</span><span id="createtime"></span></p>
    <p><a href="http://www.miitbeian.gov.cn/" rel="nofollow noopener noreferrer" target="_blank" class="font-microsoft no-visited hover col-495">版权所有 © 2016-2018 粤&nbsp;ICP&nbsp;备17095567号</a></p>
    </div>
  <!-- .site-info --> 
</footer>
<!-- #colophon -->
</div>
<!-- #page -->
<script>
  <?php $user_first = $wpdb->get_row("SELECT user_nicename,user_registered FROM $wpdb->users WHERE ID=1"); ?>  
  <?php $user_hero = $wpdb->get_row("SELECT nickname,img FROM {$wpdb->prefix}xh_social_channel_wechat WHERE ID=1"); ?>  
  <?php $user_heroine = $wpdb->get_row("SELECT nickname,img FROM {$wpdb->prefix}xh_social_channel_wechat WHERE ID=2"); ?>  

  var blog_create_time = `<?php echo "$user_first->user_registered"; ?>`; // 博客建立时间（根据第一个用户诞生时间）
  var our_love_time = `2015-05-23 20:00:00`; // 恋爱时间
  var our_info = [`<?php echo $user_hero->nickname ?>`, `<?php echo $user_hero->img ?>`,`<?php echo $user_heroine->nickname ?>`,`<?php echo $user_heroine->img ?>`]
  var kl_count = function (create_time,dom,return_html) {
      var create_time = new Date(create_time); //开始时间
      var now_time = new Date();    //结束时间
      var count_time =now_time.getTime()-create_time.getTime()  //时间差的毫秒数   
      //计算出相差天数
      var days=Math.floor(count_time/(24*3600*1000))    
      //计算出小时数
      var leave=count_time%(24*3600*1000)    //计算天数后剩余的毫秒数
      var hours=Math.floor(leave/(3600*1000))
      //计算相差分钟数
      var leave=leave%(3600*1000)        //计算小时数后剩余的毫秒数
      var minutes=Math.floor(leave/(60*1000))
      //计算相差秒数
      var leave=leave%(60*1000)      //计算分钟数后剩余的毫秒数
      var seconds=Math.round(leave/1000)
      document.getElementById(dom).innerHTML = return_html +days+" 天 "+hours+" 时 "+minutes+" 分 "+seconds+" 秒 ";
    }
    setInterval('kl_count(blog_create_time,`createtime`,`它已运作 `)',1000);  
    if(document.getElementById("secondary")){
      setInterval('kl_count(our_love_time,`lovetime`,``)',1000);  
    }
    
    $(".photo-container").append(`
      <span class="m-lr-10"><img src="https://${our_info[1]}"></span>
        <i class="lalaksks lalaksks-ic-heart-2 throb"></i>
      <span class="m-lr-10"><img src="https://${our_info[3]}"></span>
    `)
</script>

<div id="fixed-plugins" class="fixed-plugins flex-v flex-hl-vc">
  <?php  if ( is_user_logged_in() ) : global $current_user; ?>
    <div class="fp-items fp-logout">
      <a title="登出" href="<?php echo wp_logout_url()?>" class="logout-btn"><i class="lalaksks lalaksks-ic-logout"></i></a>
    </div>
  <?php else: ?>  
    <div class="fp-items fp-register hide">
      <a title="注册" href="<?php echo wp_registration_url()?>" class="register-btn"><i class="lalaksks lalaksks-ic-register"></i></a>
    </div>
      <div class="fp-items fp-login">
      <a title="登录" href="<?php echo wp_login_url()?>" class="login-btn"><i class="lalaksks lalaksks-ic-login"></i></a>	 
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
    <a id="fp-change-lang"  title="繁简切换" href="javascript:StranBody()" title="繁體"><i>繁</i></a>
  </div>

  <div class="flex-hl-vc fp-background pos-r">
    <div class="fp-items fp-background-in">
      <a  class="flex-hc-vc" title="切换背景"><i class="lalaksks lalaksks-ic-background"></i></a>
    </div>
    <div class="pos-a hide fp-background-out" style="right:40px;">
      <ul class="flex-hr-vc">
        <li data-type="origin" class="col-fff mr-5">随机</li>
        <li data-type="random" class="col-fff mr-5">原始</li>
      </ul>
    </div>

  </div>

</div>

<?php wp_footer(); ?>
</body></html>