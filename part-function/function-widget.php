<?php


// 新增部分自带小工具
function add_some_wp_widgets()
{
  // $unregister_widgets = array(
  // 	'Tag_Cloud',
  // 	'Recent_Comments',
  // 	'Recent_Posts',
  // 	'Links',
  // 	'Search',
  // 	'Meta',		
  // 	'Categories',
  // 	'RSS'
  // );
  // foreach( $unregister_widgets as $widget )
  // 	unregister_widget( 'WP_Widget_' . $widget );
  foreach (glob(get_template_directory() . '/part-widget/widget-*.php') as $file_path)
    include($file_path);
}
add_action('widgets_init', 'add_some_wp_widgets', 1);


// Style the Tag Cloud
function KlausLab_tag_cloud_widget($args)
{
  $args['largest'] = 12; //largest tag
  $args['smallest'] = 12; //smallest tag
  $args['unit'] = 'px'; //tag font unit
  $args['number'] = '30'; //number of tags
  return $args;
}

add_filter('widget_tag_cloud_args', 'KlausLab_tag_cloud_widget');

add_action('widgets_init', function () {
  register_widget("UserInfo");
});
class UserInfo extends WP_Widget
{

  function __construct()
  {
    $widget_ops = array('description' => '显示当前用户信息');
    parent::__construct('UserInfo', '本站用户', $widget_ops);
  }

  function update($new_instance, $old_instance)
  {
    return $new_instance;
  }

  function widget($args, $instance)
  {
    extract($args);
    echo $before_widget;
    echo widget_userinfo();
    echo $after_widget;
  }
}

function widget_userinfo()
{
  global $current_user;
  $user_name = $current_user->display_name;

?>

  <div class="widget-user-container">
    <div class="user-bg"></div>
    <div class="user-main">
      <?php
      $is_login = is_user_logged_in();
      $the_avatar = get_avatar($current_user->user_email, 64);
      if ($is_login === true) { ?>
        <div class="user-avatar flex-hc-vc">
          <?php echo $the_avatar; ?>
        </div>
        <div class="user-default flex-hl-vc" style="padding-left: 90px; line-height: 32px">
          <span class="fs-16"><?php echo ($user_name ? '@' . $user_name : ''); ?></span>
          <span class="ml-5"><?php echo get_author_class($current_user->user_email); ?></span>
        </div>
      <?php } ?>
      <div class="user-info-main flex-hb-vc">
        <?php global $user_ID;
        if (!$current_user->display_name && $user_ID === 0) : ?>
          <span> <?php echo ('游客，欢迎到此一游。'); ?> </span>
        <?php else : ?>
          <p class="flex-hc-vc flex-v"> <span><?php echo (count_user_posts($user_ID, 'post')); ?> 篇</span><span>文章</span></p>
          <span class="flex-hc-vc col-b2bbbe">/</span>
          <p class="flex-hc-vc flex-v"><span> <?php echo (count_user_posts($user_ID, 'moments')); ?> 篇</span><span>说说</span></p>
          <span class="flex-hc-vc col-b2bbbe">/</span>
          <p class="flex-hc-vc flex-v"><span> <?php echo (get_comments('count=true&user_id=' . $user_ID)); ?> 条</span><span>评论</span></p>
          <?php
          if (in_array('administrator', $current_user->roles)) {
            $movie_data = json_decode(file_get_contents(get_template_directory() . '/inc/douban/cache/movie.json'))->data;
            // 清理空数组
            foreach((array)$movie_data as $index=>$value) {
              if($value->name === '') unset($movie_data[$index]);            
            }
            $movoe_data_lengh = count($movie_data);
            echo ('<span class="flex-hc-vc col-b2bbbe">/</span> <p class="flex-hc-vc flex-v"><span> ' . $movoe_data_lengh . ' 条</span><span>影评</span></p> ');
          }
          ?>
        <?php endif; ?>
      </div>
    </div>
  </div>
<?php
}
?>
<?php
add_action('widgets_init', function () {
  register_widget("NewVersionTips");
});
class NewVersionTips extends WP_Widget
{

  function __construct()
  {
    $widget_ops = array(
      'description' => '版本更新公告',
      'name' => '版本更新公告'
    );
    parent::__construct('NewVersionTips', '版本更新公告', $widget_ops);
  }



  function update($new_instance, $old_instance)
  {
    return $new_instance;
  }

  function form($instance)
  {
    $title = !empty($instance['title']) ? $instance['title'] : "KlausLab v2.0 coming soon!";
?>
    <p>
      <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">标题</label>
      <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
    </p>
    <p>
    <?php
  }

  function widget($args, $instance)
  {
    extract($args);
    // $title = apply_filters('widget_title', $instance['title']);
    // if ($title)
    // 	echo $before_title . $title . $after_title;
    echo $before_widget;
    echo '<h1 class="widget-title">' . $instance['title'] . '</h1>';
    echo widget_newVersionTips();
    echo $after_widget;
  }
}

function widget_newVersionTips()
{
    ?>
    <div id="new_version_tips">
      <img alt="new ersion tips" />
    </div>
    <script>
      let new_version_tips = document.getElementById("new_version_tips");
      let new_version_img = new_version_tips.querySelectorAll('img')[0];
      new_version_img.src = `${window.homeSourceUrl}/img/undraw_Code_thinking_re_gka2.png`
      new_version_img.className = ''
    </script>

  <?php
}



add_action('widgets_init', function () {
  register_widget("AuthorInfo");
});
class AuthorInfo extends WP_Widget
{

  function __construct()
  {
    $widget_ops = array('description' => '显示站长信息');
    parent::__construct('AuthorInfo', '本站站长', $widget_ops);
  }

  function update($new_instance, $old_instance)
  {
    return $new_instance;
  }

  function widget($args, $instance)
  {
    extract($args);
    echo $before_widget;
    echo widget_authorinfo();
    echo $after_widget;
  }
}

function widget_authorinfo()
{
  ?>
    <div class="author-info">
      <div class="author-lover klaus-lover m-tb-10">
        <div class="photo-container flex-hc-vc m-tb-10"> </div>
        <div class="flex-hl-vr hw">
          <p id="lovetime" class="flex-hc-vc mb-5 ml-10"></p>
        </div>
        <div class="flex-hl-vr hw">
          <p id="createtime" class="flex-hc-vc mb-5 ml-10"></p>
        </div>
      </div>
      <div class="author-des m-tb-10">
        <!-- <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')) ?>" target="_blank">(<?php the_author_posts(); ?>篇文章)</a> -->
        <p><?php the_author_meta('description'); ?></p>
      </div>
      <!-- <div class="author-social flex-hb-vc flex-hw mt-15">
				<el-button type="primary" size="small" circle class="swing-button">
					<a href="<?php the_author_meta('user_url'); ?>" title="我的站点" rel="nofollow" target="_blank"><i class="col-fff lalaksks lalaksks-laptop"></i></a>
				</el-button>
				<el-button type="primary" size="small" circle class="swing-button">
					<a href="<?php the_author_meta('weibo'); ?>" title="微博" rel="nofollow" target="_blank"><i class="col-fff lalaksks lalaksks-ic-weibo"></i></a>
				</el-button>
				<el-button type="primary" size="small" circle class="swing-button">
					<a href="<?php the_author_meta('zhihu'); ?>" title="知乎" rel="nofollow" target="_blank"><i class="col-fff lalaksks lalaksks-zhihu"></i></a>
				</el-button>
				<el-button type="primary" size="small" circle class="swing-button">
					<a href="<?php the_author_meta('douban'); ?>" title="豆瓣" rel="nofollow" target="_blank"><i class="col-fff lalaksks lalaksks-ic-douban"></i></a>
				</el-button>
				<el-button type="primary" size="small" circle class="swing-button">
					<a href="<?php the_author_meta('github'); ?>" title="github" rel="nofollow" target="_blank"><i class="col-fff lalaksks lalaksks-ic-github"></i></a>
				</el-button>
				<span class="">
					<a href="<?php the_author_meta('juejin'); ?>" title="掘金" rel="nofollow" target="_blank"><i class="col-fff lalaksks lalaksks-ic-github"></i></a>
				</span>
				<span class="">
					<a href="<?php the_author_meta('facebook'); ?>" title="facebook" rel="nofollow" target="_blank"><i class="col-fff lalaksks lalaksks-ic-github"></i></a>
				</span>
				<span class="">
					<a href="<?php the_author_meta('bilibili'); ?>" title="bilibili" rel="nofollow" target="_blank"><i class="col-fff lalaksks lalaksks-ic-github"></i></a>
				</span>
			</div> -->
    </div>
  <?php
}

function assoc_unique($arr, $key)
{
  $tmp_arr = array();
  foreach ($arr as $k => $v) {
    if (in_array($v[$key], $tmp_arr)) { //搜索$v[$key]是否在$tmp_arr数组中存在，若存在返回true
      unset($arr[$k]);
    } else {
      $tmp_arr[] = $v[$key];
    }
  }
  sort($arr); //sort函数对数组进行排序
  return $arr;
}
// 最近访客
function most_active_friends($friends_num = 10)
{
  global $wpdb;
  $countsOfLogin = $wpdb->get_results("SELECT e.display_name, e.user_url, e.user_email, d.user_id, d.meta_value FROM $wpdb->users AS e, $wpdb->usermeta AS d WHERE d.user_id != '1' AND e.ID = d.user_id AND d.meta_key = 'last_login' AND to_days(now()) - to_days(meta_value) <= 30 LIMIT $friends_num");
  $countsOfComment = $wpdb->get_results("SELECT * FROM (SELECT * FROM $wpdb->comments WHERE user_id != '1' AND comment_approved = '1' ORDER BY comment_date DESC) AS tempcmt GROUP BY comment_author_email ORDER BY comment_date DESC LIMIT $friends_num");
  $countsOfVisitorComment = [];
  $mostactive = '';
  $el_start = ' <el-tooltip class="item" effect="dark"  placement="top">';
  $el_end = '</el-tooltip>';
  $key = 'user_id';

  foreach ($countsOfComment as $count) {
    $count->order_date = $count->comment_date;
    if ($count->user_id === '0') {
      $countsOfVisitorComment[] = $count;
    }
  }
  foreach ($countsOfLogin as $count) {
    $count->order_date = $count->meta_value;
  }
  // 合并去重后的用户评论数组和登录用户数组  
  $counts = array_merge($countsOfComment, $countsOfLogin);
  // 以$key为索引
  $counts = array_column($counts, NULL, $key);
  // 去除关联索引
  $counts = array_values($counts);
  // 合并当前数组和游客评论数组
  $counts = array_merge($counts, $countsOfVisitorComment);
  // 按照sort字段升序  其中SORT_ASC表示升序 SORT_DESC表示降序
  $sort = array_column($counts, 'order_date');
  array_multisort($sort, SORT_DESC, $counts);
  // 截取数组
  $counts = array_slice($counts, 0, $friends_num);
  $c_avatar_default = '<img src=" ' . KL_THEME_URI . '/img/wp-default-gravatar.png"  style="width: 40px; height: 40px; object-fit: cover;"/>';
  foreach ($counts as $count) {
    $c_url = $count->comment_author_url ? $count->comment_author_url : $count->user_url;
    $c_name = $count->comment_author ? $count->comment_author : $count->display_name;
    $c_vip = get_author_class_for_api($count->comment_author_email ? $count->comment_author_email : $count->user_email, $c_name);
    $c_avatar = get_avatar($count->comment_author_email ? $count->comment_author_email : $count->user_email, 40);
    $mostactive .= '<li class="widget-visitor flex" style="flex: 0 1 auto; border: none; margin:0; padding: 5px 8px">' . $el_start . '<div slot="content"><div class="flex-hb-vc" style="line-height:2; min-width:40px">' .  $c_vip . '</div></div><a href="' . ($c_url ?  $c_url : '#') . '" >' . ($c_avatar ? $c_avatar : $c_avatar_default) . '</a>' . $el_end . '</li>';
  }
  return $mostactive;
}

  ?>