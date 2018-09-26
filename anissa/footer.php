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

  <?php if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) ) : ?>
  <div class="footer-widgets clear">
  
    <div class="widget-area">
      <?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
      <?php dynamic_sidebar( 'footer-1' ); ?>
      <?php endif; ?>
	  
    </div>
    <!-- .widget-area -->
    
    <div class="widget-area">
      <?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
      <?php dynamic_sidebar( 'footer-2' ); ?>
      <?php endif; ?>
    </div>
    <!-- .widget-area -->
    
    <div class="widget-area">
      <?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
      <?php dynamic_sidebar( 'footer-3' ); ?>
      <?php endif; ?>
    </div>
    <!-- .widget-area --> 
    
  </div>
  <!-- .footer-widgets -->
  
  <?php endif; ?>
  <div class="site-info">
  
	<!--<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'anissa' ) ); ?>"><?php printf( esc_html__( 'Proudly powered by %s', 'anissa' ), 'WordPress' ); ?></a> <span class="sep"> | </span> <?php printf( esc_html__( 'Theme: %1$s by %2$s.', 'anissa' ), 'Anissa', '<a href="https://alienwp.com/" rel="designer">AlienWP</a>' ); ?>  -->
  <!-- <div class="klaus-info flex-ha-vc">
	<div class="flex-v flex-hc-vc"><a href="https://www.zhihu.com/people/klauschan" target="_blank"><p><svg t="1506650890500" class="icon" style="" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="734" xmlns:xlink="http://www.w3.org/1999/xlink" width="27" height="27"><defs><style type="text/css"></style></defs><path d="M 940.35 795.875 c 0 78.652 -63.771 142.422 -142.421 142.422 H 228.226 c -78.655 0 -142.427 -63.772 -142.427 -142.422 v -569.7 c 0 -78.658 63.772 -142.432 142.427 -142.432 H 797.93 c 78.658 0 142.432 63.772 142.432 142.431 l -0.01 569.701 Z M 415.621 543.356 h 125.593 c 0 -29.528 -13.923 -46.824 -13.923 -46.824 H 418.295 c 2.59 -53.493 4.91 -122.15 5.739 -147.65 h 103.677 s -0.561 -43.871 -12.091 -43.871 H 333.378 s 10.971 -57.374 25.594 -82.7 c 0 0 -54.417 -2.938 -72.98 69.622 c -18.562 72.56 -46.404 116.43 -49.356 124.446 c -2.953 8.013 16.031 3.795 24.044 0 c 8.015 -3.797 44.294 -16.876 54.84 -67.496 h 56.35 c 0.76 32.082 2.99 130.397 2.287 147.649 H 258.15 c -16.45 11.81 -21.936 46.824 -21.936 46.824 h 132.592 c -5.53 36.615 -15.239 83.813 -28.817 108.835 c -21.513 39.655 -32.904 75.934 -110.525 138.368 c 0 0 -12.657 9.28 26.576 5.906 c 39.231 -3.372 76.356 -13.498 102.087 -64.963 c 13.378 -26.756 27.213 -60.697 38.006 -95.121 l -0.04 0.12 l 109.26 125.795 s 14.343 -33.747 3.798 -70.87 l -80.994 -90.698 l -27.42 20.279 l -0.031 0.099 c 7.615 -26.7 13.092 -53.095 14.795 -76.061 c 0.042 -0.553 0.084 -1.119 0.121 -1.689 Z M 567.366 295.73 v 435.35 h 45.77 l 18.753 52.405 l 79.328 -52.405 h 99.978 V 295.73 H 567.366 Z M 764.09 684.253 h -51.968 l -64.817 42.817 l -15.319 -42.817 H 615.81 v -339.94 h 148.28 v 339.94 Z m 0 0" fill="#333333" p-id="735"></path></svg></p><p>知乎</p></a></div>
	<div class="flex-v flex-hc-vc"><p><svg t="1506650364041" class="icon" style="" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="1321" xmlns:xlink="http://www.w3.org/1999/xlink" width="25" height="25"><defs><style type="text/css"></style></defs><path d="M433.783191 469.801666c-134.620927 6.20979-243.456736 78.341484-243.456736 168.2889 0 89.816105 108.835809 157.359111 243.456736 151.071573 134.730253-6.162622 243.793708-90.473459 243.793708-180.321342C677.576899 519.127623 568.507048 463.591877 433.783191 469.801666L433.783191 469.801666zM525.511 696.067458c-41.236242 53.201729-122.811734 79.17392-202.017232 36.272008-37.69924-20.441341-36.323373-60.6189-36.323373-60.6189s-15.64899-126.82861 119.758204-142.685459C542.540254 513.308169 566.741845 642.809767 525.511 696.067458L525.511 696.067458zM434.69857 611.121252c-8.67272 6.292933-10.444319 18.294596-5.739509 25.790514 4.536524 7.678594 15.070582 8.56979 23.61299 2.171927 8.39171-6.631904 11.63651-18.133905 7.105582-25.812299C455.14111 605.803857 444.738363 603.652715 434.69857 611.121252L434.69857 611.121252zM370.512089 628.578016c-25.301645 2.620423-43.388383 24.634498-43.388383 45.730994 0 21.128275 20.363793 35.724179 45.643654 32.765785 25.186723-2.886043 45.685225-22.331259 45.685225-43.402573C418.452385 642.523161 399.552999 625.795902 370.512089 628.578016L370.512089 628.578016zM844.505321 33.945177 179.501394 33.945177c-80.39869 0-145.565107 65.155425-145.565107 145.565107l0 664.976546c0 80.408483 65.166417 145.564907 145.565107 145.564907l665.003927 0c80.39869 0 145.555313-65.155425 145.555313-145.564907l0-664.976546C990.060635 99.101801 924.904011 33.945177 844.505321 33.945177L844.505321 33.945177zM797.920106 668.496351C742.384559 786.379027 559.365046 843.752928 423.744597 833.138124c-128.896808-10.142523-294.615651-52.99407-311.743438-208.96732 0 0-9.058658-70.631312 59.442098-162.046333 0 0 98.505213-137.573725 213.222835-176.836905 114.846534-39.047726 128.239454 27.046063 128.239454 66.125567-6.089471 33.15632-17.533512 52.6549 25.566266 39.26218 0 0 112.914044-52.337915 159.337569-5.923184 37.505771 37.505771 6.189004 89.112981 6.189004 89.112981s-15.518878 17.191144 16.470433 23.380148C752.547669 503.66111 853.3869 550.392826 797.920106 668.496351L797.920106 668.496351zM686.610374 342.766396c-12.293665 0-22.159576-9.933665-22.159576-22.150782 0-12.392198 9.865911-22.352045 22.159576-22.352045 0 0 138.397367-25.556473 121.831798 123.128919 0 0.864014-0.109326 1.546352-0.301795 2.333818-1.568337 10.531859-10.82606 18.632567-21.727469 18.632567-12.32984 0-22.353045-9.854918-22.353045-22.175965C764.055267 420.189304 785.979602 320.830869 686.610374 342.766396L686.610374 342.766396zM920.511989 461.675776l-0.166287 0c-3.646128 25.13316-16.132462 27.155389-31.019169 27.155389-17.783743 0-32.19817-11.168428-32.19817-28.988346 0-15.409552 6.391267-31.083725 6.391267-31.083725 1.916101-6.500593 16.956104-46.860828-9.933665-107.194322-49.180456-82.663754-148.300252-83.866738-159.990327-79.127951-11.808194 4.590088-29.239975 6.943692-29.239975 6.943692-17.898665 0-32.249535-14.568523-32.249535-32.286909 0-14.860525 9.933665-27.441994 23.482879-31.295981 0 0 0.302995-0.494265 0.797259-0.599394 0.97334-0.214455 1.968665-1.183398 3.041538-1.260945 13.813834-2.672788 63.005282-12.318848 110.82526-1.125437C855.856225 202.811686 973.348566 285.552987 920.511989 461.675776L920.511989 461.675776z" p-id="1322" fill="#333333"></path></svg></p><p>微博</p></div>
	<div class="flex-hc-vc"></div>
	<div class="flex-v flex-hc-vc"><a href="https://github.com/KlausChan0523" target="_blank"><p><svg t="1506649069284" class="icon" style="" viewBox="0 0 1032 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="6594" xmlns:xlink="http://www.w3.org/1999/xlink" width="25.1953125" height="25"><defs><style type="text/css"></style></defs><path d="M0 515.872C0 741.12 144.352 932.64 345.584 1002.976c27.12 6.896 22.896-12.544 22.896-25.616l0-89.424c-156.464 18.304-162.736-85.28-173.296-102.608-21.312-36.272-71.392-45.488-56.432-62.752 35.696-18.432 71.968 4.608 114 66.784 30.464 45.072 89.664 37.504 119.936 29.936 6.624-27.056 20.704-51.2 39.952-70.08-161.888-28.816-229.552-127.792-229.552-245.44 0-56.944 18.8-109.504 55.808-151.856-23.408-69.888 2.256-129.472 5.616-138.416 66.928-6.08 136.512 47.872 141.872 52.128 38.128-10.192 81.52-15.76 130.064-15.76 48.848 0 92.48 5.632 130.784 15.952 13.072-9.952 77.584-56.192 139.824-50.544 3.312 8.848 28.416 67.168 6.4 136.016 37.376 42.464 56.352 95.264 56.352 152.48 0 117.888-67.952 217.008-230.528 245.6 27.152 26.736 43.984 63.92 43.984 105.04l0 129.712c0.864 10.336 0 20.736 17.36 20.736 204.112-68.752 351.12-261.712 351.12-489.008C1031.744 230.96 800.784 0 515.872 0 230.96 0 0 230.96 0 515.872L0 515.872zM0 515.872" p-id="6595"></path></svg></p><p>Github</p></a></div>
	<div class="flex-v flex-hc-vc"><p><svg t="1506648968081" class="icon" style="" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="4754" xmlns:xlink="http://www.w3.org/1999/xlink" width="25" height="25"><defs><style type="text/css"></style></defs><path d="M290.016 292.992q-18.016 0-31.488 10.496t-13.504 27.008 13.504 27.008 31.488 10.496q16.992 0 27.488-10.496t10.496-27.488-10.496-27.008-27.488-10.016zM600.992 512q-12 0-20.992 9.504t-8.992 20.992 8.992 20.992 20.992 9.504q16 0 27.008-8.992t11.008-20.992-11.008-21.504-27.008-9.504zM1020.992 158.016q0-64-45.504-109.504t-109.504-45.504l-708.992 0q-64 0-109.504 45.504t-45.504 109.504l0 708.992q0 64 45.504 109.504t109.504 45.504l708.992 0q64 0 109.504-45.504t45.504-109.504l0-708.992zM388.992 679.008q-28.992 0-106.016-15.008l-106.016 52.992 30.016-91.008q-120.992-84.992-120.992-204.992 0-107.008 88.512-182.016t214.496-75.008q111.008 0 198.496 60.512t106.496 151.488q-16-0.992-28.992-0.992-107.008 0-182.016 70.016t-75.008 168.992q0 32 8.992 64-16 0.992-28 0.992zM836 784.992l22.016 76-83.008-46.016q-60 16-91.008 16-107.008 0-182.016-64.512t-75.008-155.488 75.008-155.488 182.016-64.512q103.008 0 180.512 64.992t77.504 155.008q0 95.008-106.016 174.016l0 0zM767.008 512q-11.008 0-20.512 9.504t-9.504 20.992 9.504 20.992 20.512 9.504q16.992 0 27.488-8.992t10.496-20.992-10.496-21.504-27.488-9.504zM502.016 368q16.992 0 27.488-10.496t10.496-27.488-10.496-27.008-27.488-10.016q-18.016 0-31.488 10.496t-13.504 27.008 13.504 27.008 31.488 10.496z" p-id="4755"></path></svg></p><p>公众号</p></div>
  </div> -->
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
    <div class="fixed-plugins-items fixed-plugins-logout">
      <a title="登出" href="<?php echo wp_logout_url()?>" class="logout-btn"><i class="lalaksks lalaksks-ic-logout"></i></a>
    </div>
  <?php else: ?>  
    <div class="fixed-plugins-items fixed-plugins-register hide">
      <a title="注册" href="<?php echo wp_registration_url()?>" class="register-btn"><i class="lalaksks lalaksks-ic-register"></i></a>
    </div>
      <div class="fixed-plugins-items fixed-plugins-login">
      <a title="登录" href="<?php echo wp_login_url()?>" class="login-btn"><i class="lalaksks lalaksks-ic-login"></i></a>	 
    </div>

  <?php endif ?>
  <div class="flex-hl-vc fixed-plugins-search pos-r">
    <div class="fixed-plugins-items fixed-plugins-search-in">
      <a class="flex-hc-vc" title="站内搜索"><i class="lalaksks lalaksks-ic-search"></i></a>
    
    </div>
   <div class="pos-a hide fixed-plugins-search-out" style="right:40px;">
      <?php get_search_form(); ?>
    </div>
  </div>
  <div class="fixed-plugins-items fixed-plugins-gototop">
    <a title="返回顶部"><i class="lalaksks lalaksks-ic-backtotop"></i></a>
  </div>
  <div class="fixed-plugins-items fixed-plugins-change-lang">
    <a id="fixed-plugins-change-lang"  title="繁简切换" href="javascript:StranBody()" title="繁體"><i>繁</i></a>
  </div>
  <div class="fixed-plugins-items fixed-plugins-change-background">
    <a id="fixed-plugins-change-background" title="切换背景"><i class="lalaksks lalaksks-ic-background"></i></a>
  </div>
</div>

<?php wp_footer(); ?>
</body></html>