<?php

/**
 * KlausLab functions and definitions
 *
 * @package KlausLab
 */
if (!function_exists('KlausLab_setup')) :
  function KlausLab_setup()
  {
    /*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on KlausLab, use a find and replace
	 * to change 'KlausLab' to the name of your theme in all the template files
	 */
    // load_theme_textdomain( 'KlausLab', get_template_directory() . '/languages' );
    // Add default posts and comments RSS feed links to head.
    // add_theme_support('automatic-feed-links');
    /*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
    // add_theme_support('title-tag');
    // add_theme_support('custom-logo');
    // This theme uses wp_nav_menu() in one location.
    // register_nav_menus(array(
    //   'primary' => esc_html__('Primary Menu', 'KlausLab'),
    //   'social'  => esc_html__('Social Links', 'KlausLab'),
    // ));
    /*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
    // add_theme_support('html5', array(
    //   'search-form',
    //   'comment-form',
    //   'comment-list',
    //   'gallery',
    //   'caption',
    // ));
  }
endif; // KlausLab_setup
add_action('after_setup_theme', 'KlausLab_setup');
/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function KlausLab_widgets_init()
{
  register_sidebar(array(
    'name'          => esc_html__('Sidebar', 'KlausLab'),
    'id'            => 'sidebar-1',
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget'  => '</aside>',
    'before_title'  => '<h1 class="widget-title">',
    'after_title'   => '</h1>',
  ));
  register_sidebar(array(
    'name'          => esc_html__('Footer Sidebar 1', 'KlausLab'),
    'id'            => 'footer-1',
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget'  => '</aside>',
    'before_title'  => '<h1 class="widget-title">',
    'after_title'   => '</h1>',
  ));
  register_sidebar(array(
    'name'          => esc_html__('Footer Sidebar 2', 'KlausLab'),
    'id'            => 'footer-2',
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget'  => '</aside>',
    'before_title'  => '<h1 class="widget-title">',
    'after_title'   => '</h1>',
  ));
  register_sidebar(array(
    'name'          => esc_html__('Footer Sidebar 3', 'KlausLab'),
    'id'            => 'footer-3',
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget'  => '</aside>',
    'before_title'  => '<h1 class="widget-title">',
    'after_title'   => '</h1>',
  ));
}
add_action('widgets_init', 'KlausLab_widgets_init');
/**
 * Enqueue scripts and styles.
 */
function KlausLab_scripts()
{
  wp_enqueue_style('KlausLab-style', get_stylesheet_uri());
  if (is_singular() && comments_open() && get_option('thread_comments')) {
    wp_enqueue_script('comment-reply');
  }
}
add_action('wp_enqueue_scripts', 'KlausLab_scripts');
// Declare WooCommerce Support
// add_action('after_setup_theme', 'woocommerce_support');
// function woocommerce_support()
// {
//   add_theme_support('woocommerce');
// }
/**
 * Custom template tags for this theme.
 */
// require KL_DIR . '/template-tags.php';
/**
 * Custom functions that act independently of the theme templates.
 */
// require KL_DIR . '/extras.php';
/**
 * Customizer additions.
 */
// require KL_DIR . '/customizer.php';
function normal_style_script()
{
  // jquery.min.js
  wp_enqueue_script('jquery', KL_THEME_URI . '/js/lib/jquery-3.1.1.min.js', array(), '3.1.1', false);
  // 基础方法
  wp_enqueue_script('myUtil', KL_THEME_URI . '/js/utils.js', array(), '1.0', false);
  if (FE_ENV !== "Development") {
    // 除style.css之外的样式
    wp_enqueue_style('main', KL_THEME_URI . '/css/main.css', array(), '1.0', false);
    // vue.min.js   
    wp_enqueue_script('vue', KL_THEME_URI . '/js/lib/vue.min.js', array(), '2.6.0', false);
  } else {
    // 动画库样式
    wp_enqueue_style('animate', KL_THEME_URI . '/css/animate.min.css', array(), '3.5.1', false);
    // 插件样式
    wp_enqueue_style('supportCss', KL_THEME_URI . '/css/support.css', array(), '1.0', false);
    // vue.min.js   
    wp_enqueue_script('vue', KL_THEME_URI . '/js/lib/vue.dev.min.js', array(), '2.6.0', false);
  }
  // axios.min.js
  wp_enqueue_script('axios', KL_THEME_URI . '/js/lib/axios.min.js', array(), '0.19.0', false);
  // ElementUI
  wp_enqueue_script('element-ui-js', KL_THEME_URI . '/js/lib/element-ui.min.js', array(), '1.0', false);
  wp_enqueue_style('element-ui-css', KL_THEME_URI . '/css/element-ui.min.css', array(), '1.0', false);
  // elementUI额外样式
  wp_enqueue_style('icon-font19', '//at.alicdn.com/t/font_765116_by9ipi65sw7.css', array(), '1.0', false);
  wp_enqueue_script('icon-font21', '//at.alicdn.com/t/font_1616851_1gtnw3vh59j.js', array(), '1.0', false);
}
function footer_script()
{
  // lodash.min.js
  wp_enqueue_script('lodash', KL_THEME_URI . '/js/lib/lodash.min.js', array(), '4.17.15', false);
  // dayjs.min.js
  wp_enqueue_script('dayjs', KL_THEME_URI . '/js/lib/dayjs.min.js', array(), '1.10.4', false);
  // dayjs-plugin.js
  wp_enqueue_script('dayjs-relativeTime', KL_THEME_URI . '/js/plugin/relativeTime.js', array(), '1.10.4', false);
  wp_enqueue_script('dayjs-localizedFormat', KL_THEME_URI . '/js/plugin/localizedFormat.js', array(), '1.10.4', false);
  wp_enqueue_script('dayjs-locale', KL_THEME_URI . '/js/plugin/zh-cn.js', array(), '1.10.4', false);
  // tinymce 富文本编辑器
  wp_enqueue_script('tinymce-vue-js', KL_THEME_URI . '/js/lib/tinymce-vue.min.js', array(), '1.0', false);
  // 组件
  wp_enqueue_script('search', KL_THEME_URI . '/js/component/search.js', array(), '1.0', false);
  wp_enqueue_script('skeleton', KL_THEME_URI . '/js/component/skeleton.js', array(), '1.0', false);
  // wp_enqueue_script('empty', KL_THEME_URI . '/js/component/empty.js', array(), '1.0', false);
  wp_enqueue_script('filterMixin', KL_THEME_URI . '/js/mixin/filterMixin.js', array(), '1.0', false);
  // 通用
  if (FE_ENV !== "Development") {
    wp_enqueue_script('app', KL_THEME_URI . '/js/app.js', array(), '1.0', false);
  } else {
    wp_enqueue_script('main', KL_THEME_URI . '/js/common.js', array(), '1.0', false);
  }
  // 动画
  wp_enqueue_script('canvasFunc', KL_THEME_URI . '/js/canvas.js', array(), '1.0', false);
}
function my_custom_login()
{
  wp_enqueue_style('myLogin', KL_THEME_URI . '/css/page/login.css', array(), '1.0', false);
  wp_enqueue_script('myLogin', KL_THEME_URI . '/js/page/login.js', array(), '1.0', false);
}
function styles_scripts()
{
  // 前台加载的脚本与样式表
  if (!is_admin()) {
    // 去除已注册的 jquery 脚本
    wp_deregister_script('jquery');
    // 提交加载 jquery 脚本
    wp_enqueue_script('jquery');
    // }
  } else { // 后台加载的脚本与样式表
    // 取消加载 jquery 脚本
    wp_dequeue_script('jquery');
  }
}
add_action('init', 'styles_scripts');
add_action('wp_footer', 'footer_script');
add_action('wp_enqueue_scripts', 'normal_style_script');
add_action('login_footer', 'my_custom_login');
// 清除无用资源
remove_action('wp_head', 'feed_links_extra', 3); //去除评论feed
remove_action('wp_head', 'feed_links', 2); //去除文章feed
remove_action('wp_head', 'rsd_link'); //针对Blog的远程离线编辑器接口
remove_action('wp_head', 'wlwmanifest_link'); //Windows Live Writer接口
remove_action('wp_head', 'index_rel_link'); //移除当前页面的索引
remove_action('wp_head', 'parent_post_rel_link', 10, 0); //移除后面文章的url
remove_action('wp_head', 'start_post_rel_link', 10, 0); //移除最开始文章的url
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0); //自动生成的短链接
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); ///移除相邻文章的url
remove_action('wp_head', 'wp_generator'); // 移除版本号
unregister_widget('WP_Widget_RSS');
// Remove Open Sans that WP adds from frontend   
if (!function_exists('remove_wp_open_sans')) :
  function remove_wp_open_sans()
  {
    wp_deregister_style('open-sans');
    wp_register_style('open-sans', false);
  }
  // 前台删除Google字体CSS   
  add_action('wp_enqueue_scripts', 'remove_wp_open_sans');
  // 后台删除Google字体CSS   
  add_action('admin_enqueue_scripts', 'remove_wp_open_sans');
endif;
// 判断当前用户是否管理员
function isAdmin()
{
  // wp_get_current_user函数仅限在主题的functions.php中使用
  $currentUser = wp_get_current_user();
  if (!empty($currentUser->roles) && in_array('administrator', $currentUser->roles))
    return 1;  // 是管理员
  else
    return 0;  // 非管理员
}
/// 函数名称：getPostViews & setPostViews
/// 函数作用：获取和反映文章点击数
function getPostViews($postID)
{
  $count_key = 'post_views_count';
  $count = get_post_meta($postID, $count_key, true);
  if ($count == '') {
    delete_post_meta($postID, $count_key);
    add_post_meta($postID, $count_key, '0');
    return "0 View";
  }
  return $count;
}
function setPostViews($postID)
{
  $count_key = 'post_views_count';
  $count = get_post_meta($postID, $count_key, true);
  if ($count == '') {
    $count = 0;
    delete_post_meta($postID, $count_key);
    add_post_meta($postID, $count_key, '0');
  } else {
    if (isAdmin() != 1) {
      $count++;
    }
    update_post_meta($postID, $count_key, $count);
  }
}
/// 函数名称：wpb_new_gravatar
/// 函数作用：设置默认头像
add_filter('avatar_defaults', 'wpb_new_gravatar');
function wpb_new_gravatar($avatar_defaults)
{
  $myavatar = '//en.gravatar.com/userimage/125992477/fcde332c16644204fc0be461a5b36857?size=80';
  $avatar_defaults[$myavatar] = "默认头像";
  return $avatar_defaults;
}
// ajax头像更新
add_action('init', 'ajax_avatar_url');
function ajax_avatar_url()
{
  if (@$_GET['action'] == 'ajax_avatar_get' && 'GET' == $_SERVER['REQUEST_METHOD']) {
    $email = $_GET['email'];
    echo get_avatar_url($email, array('size' => 48)); // size 指定头像大小
    die();
  } else {
    return;
  }
}
// 判断是否移动端
function is_mobile()
{
  $user_agent = $_SERVER['HTTP_USER_AGENT'];
  $mobile_browser = array(
    "mqqbrowser", //手机QQ浏览器
    "opera mobi", //手机opera
    "juc", "iuc", //uc浏览器
    "fennec", "ios", "applewebKit/420", "applewebkit/525", "applewebkit/532", "ipad", "iphone", "ipaq", "ipod",
    "iemobile", "windows ce", //windows phone
    "240x320", "480x640", "acer", "android", "anywhereyougo.com", "asus", "audio", "blackberry", "blazer", "coolpad", "dopod", "etouch", "hitachi", "htc", "huawei", "jbrowser", "lenovo", "lg", "lg-", "lge-", "lge", "mobi", "moto", "nokia", "phone", "samsung", "sony", "symbian", "tablet", "tianyu", "wap", "xda", "xde", "zte"
  );
  $is_mobile = false;
  foreach ($mobile_browser as $device) {
    if (stristr($user_agent, $device)) {
      $is_mobile = true;
      break;
    }
  }
  return $is_mobile;
}
function is_icon($id, $name)
{
  switch ($name) {
    case "date":
      $dom = '<a href="' . esc_url(get_permalink()) . '" rel="bookmark"><i class="lalaksks lalaksks-ic-' . $name . '"></i>' . get_the_time(get_option('date_format')) . '</a>';
      break;
    case "category":
      $dom = '<span><i class="lalaksks lalaksks-ic-' . $name . '"></i>' . get_the_category_list(' ') . ' </span>';
      break;
    case "tag":
      $dom = '<span><i class="lalaksks lalaksks-ic-' . $name . '"></i>' . get_the_tag_list(' ') . ' </span>';
      break;
    case "view":
      $dom = '<span><i class="lalaksks lalaksks-ic-' . $name . '"></i>' . getPostViews(get_the_ID()) . ' </span>';
      break;
    case "reply":
      $dom = '<a href="' . esc_url(get_permalink()) . '#comments" rel="bookmark"><i class="lalaksks lalaksks-ic-' . $name . '"></i>' . get_comments_number() . '</a>';
      break;
    case "author":
      $dom = '<a href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '"><i class="lalaksks lalaksks-ic-' . $name . '"></i>' . esc_html(get_the_author()) . '</a></span>';
      break;
    default:
      echo "No Icon";
  }
  if ($dom != "") {
    echo $dom;
  }
}
// 前台隐藏工具条
if (!is_admin()) {
  add_filter('show_admin_bar', '__return_false');
}
// 开启特色图并设置默认大小
add_theme_support('post-thumbnails');
set_post_thumbnail_size(160);
function autoset_featured()
{
  global $post;
  $already_has_thumb = empty($already_has_thumb) ? has_post_thumbnail($post->ID) : $already_has_thumb;
  if (!$already_has_thumb) {
    $attached_image = get_children("post_parent=$post->ID&post_type=attachment&post_mime_type=image&numberposts=1");
    if ($attached_image) {
      foreach ($attached_image as $attachment_id => $attachment) {
        set_post_thumbnail($post->ID, $attachment_id);
      }
    }
  }
}
add_action('the_post', 'autoset_featured');
add_action('save_post', 'autoset_featured');
add_action('draft_to_publish', 'autoset_featured');
add_action('new_to_publish', 'autoset_featured');
add_action('pending_to_publish', 'autoset_featured');
add_action('future_to_publish', 'autoset_featured');
// 开启用户等级-评论模块
function get_author_class($comment_author_email)
{
  global $wpdb;
  $author_count = count($wpdb->get_results(
    "SELECT comment_ID as author_count FROM $wpdb->comments WHERE comment_author_email = '$comment_author_email' "
  ));
  if (is_user_logged_in()) {
    if ($author_count >= 1 && $author_count <= 10) //数字可自行修改，代表评论次数。
      echo '<span class="vip level_1">LV.1</span>';
    else if ($author_count >= 11 && $author_count <= 20)
      echo '<span class="vip level_2">LV.2</span>';
    else if ($author_count >= 21 && $author_count <= 40)
      echo '<span class="vip level_3">LV.3</span>';
    else if ($author_count >= 41 && $author_count <= 80)
      echo '<span class="vip level_4">LV.4</span>';
    else if ($author_count >= 81 && $author_count <= 160)
      echo '<span class="vip level_5">LV.5</span>';
    else if ($author_count >= 161 && $author_count <= 320)
      echo '<span class="vip level_6">LV.6</span>';
    else if ($author_count >= 321)
      echo '<span class="vip level_Max">LV.7</span>';
  } else {
    echo '<span class="vip level_0">LV.0</span>';
  }
}
// 根据设备类型自定义文章摘要长度
function custom_excerpt_length($length)
{
  if (!is_mobile()) {
    return 120;
  } else if (is_mobile()) {
    return 30;
  }
}
add_filter('excerpt_length', 'custom_excerpt_length');
// // 邮件发送模块
// function mail_smtp( $phpmailer ){
// 	$phpmailer->From = "xing930629@163.com"; //发件人
// 	$phpmailer->FromName = "测试";   //发件人昵称
// 	$phpmailer->Host = "smtp.163.com"; //SMTP服务器地址(比如QQ是smtp.qq.com,腾讯企业邮箱是smtp.exmail.qq.com,阿里云是smtp.域名,其他自行咨询邮件服务商)
// 	$phpmailer->Port = 465;    //SMTP端口，常用的有25、465、587，SSL加密连接端口：465或587,qq是25,qq企业邮箱是465
// 	$phpmailer->SMTPSecure = "SSL"; //SMTP加密方式，常用的有ssl/tls,一般25端口不填，端口465天ssl
// 	$phpmailer->Username = "xing930629@163.com";  //邮箱帐号，一般和发件人相同
// 	$phpmailer->Password = 'xingxing930629';  //邮箱授权码
// 	$phpmailer->IsSMTP(); //使用SMTP发送
// 	$phpmailer->SMTPAuth = true; //启用SMTPAuth服务
// }
// add_action('phpmailer_init','mail_smtp');
/* 删除文章时删除图片附件
/* ------------------------ */
function delete_post_and_attachments($post_ID)
{
  global $wpdb;
  //删除特色图片
  $thumbnails = $wpdb->get_results("SELECT * FROM $wpdb->postmeta WHERE meta_key = '_thumbnail_id' AND post_id = $post_ID");
  foreach ($thumbnails as $thumbnail) {
    wp_delete_attachment($thumbnail->meta_value, true);
  }
  //删除图片附件
  $attachments = $wpdb->get_results("SELECT * FROM $wpdb->posts WHERE post_parent = $post_ID AND post_type = 'attachment'");
  foreach ($attachments as $attachment) {
    wp_delete_attachment($attachment->ID, true);
  }
  $wpdb->query("DELETE FROM $wpdb->postmeta WHERE meta_key = '_thumbnail_id' AND post_id = $post_ID");
}
add_action('before_delete_post', 'delete_post_and_attachments');
//预览全文功能
function preview_post()
{
  global $wpdb, $post;
  $id = $_POST["um_id"];
  $action = $_POST["um_action"];
  // 获取文章对象
  global $wpdb, $post;
  $post = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE ID = %d LIMIT 1", $id));
  // 如果指定 ID 的文章存在, 则对他进行格式化
  if ($post) {
    $content = $post->post_content;
    $output = balanceTags($content);
    $output = wpautop($output);
  }
  // 打印文章内容并中断后面的处理
  echo $output;
  die;
}
add_action('wp_ajax_nopriv_preview_post', 'preview_post');
add_action('wp_ajax_preview_post', 'preview_post');
add_filter('upload_mimes', 'svg_upload_mimes');
function svg_upload_mimes($mimes = array())
{
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
// 查询时间节点
function love_time()
{
  global $wpdb, $post;
  $action = $_POST["action"];
  $user_first = $wpdb->get_row("SELECT user_nicename,user_registered FROM $wpdb->users WHERE ID=1");
  $user_host_name = cs_get_option('klausLab_bloger_host');
  $user_hostess_name = cs_get_option('klausLab_bloger_hostess');
  $user_host = $wpdb->get_row("SELECT display_name,user_email FROM $wpdb->users WHERE user_login='$user_host_name'");
  $user_hostess = $wpdb->get_row("SELECT display_name,user_email FROM $wpdb->users WHERE user_login='$user_hostess_name'");
  $user_host->img = get_avatar($user_host->user_email, '50');
  $user_hostess->img = get_avatar($user_hostess->user_email, '50');
  $return_arr = array($user_first, $user_host, $user_hostess);
  wp_send_json($return_arr);
}
add_action('wp_ajax_nopriv_love_time', 'love_time');
add_action('wp_ajax_love_time', 'love_time');
// 条件查询归档
function filter_archive()
{
  global $wpdb, $post;
  $action = $_POST["action"];
  $filter = $_POST["filter"];
  $return_arr = archives_list($filter);
  wp_send_json($return_arr);
}
add_action('wp_ajax_nopriv_filter_archive', 'filter_archive');
add_action('wp_ajax_filter_archive', 'filter_archive');
$current_user = wp_get_current_user();
// Only Her
function only_her()
{
  global $wpdb, $post;
  $action = $_POST["action"];
  $current_user = wp_get_current_user();
  wp_send_json($current_user->user_login);
  // if ( $current_user->user_login == 'Laura' ) {  
  // 	wp_send_json($current_user->user_login);
  // } else {  
  // 	wp_send_json($current_user->user_login);
  // }  
}
add_action('wp_ajax_nopriv_only_her', 'only_her');
add_action('wp_ajax_only_her', 'only_her');
//点赞功能
function like_post()
{
  global $wpdb, $post;
  $id = $_POST["um_id"];
  $action = $_POST["um_action"];
  if ($action == 'ding') {
    $inlo_raters = get_post_meta($id, 'inlo_ding', true);
    $expire = time() + 99999999;
    $domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false; // make cookies work with localhost
    setcookie('inlo_ding_' . $id, $id, $expire, '/', $domain, false);
    if (!$inlo_raters || !is_numeric($inlo_raters)) {
      update_post_meta($id, 'inlo_ding', 1);
    } else {
      update_post_meta($id, 'inlo_ding', ($inlo_raters + 1));
    }
    echo get_post_meta($id, 'inlo_ding', true);
  }
  die;
}
add_action('wp_ajax_nopriv_like_post', 'like_post');
add_action('wp_ajax_like_post', 'like_post');
//点赞最多文章
function get_like_most($mode = '', $limit = 10, $days = 7, $display = true)
{
  global $wpdb, $post;
  $limit_date = current_time('timestamp') - ($days * 86400);
  $limit_date = date("Y-m-d H:i:s", $limit_date);
  $where = '';
  $temp = '';
  if (!empty($mode) && $mode != 'both') {
    $where = "post_type = '$mode'";
  } else {
    $where = '1=1';
  }
  $most_viewed = $wpdb->get_results("SELECT $wpdb->posts.*, (meta_value+0) AS md_like FROM $wpdb->posts LEFT JOIN $wpdb->postmeta ON $wpdb->postmeta.post_id = $wpdb->posts.ID WHERE post_date < '" . current_time('mysql') . "' AND post_date > '" . $limit_date . "' AND $where AND post_status = 'publish' AND meta_key = 'md_like' AND post_password = '' ORDER  BY md_like DESC LIMIT $limit");
  if ($most_viewed) {
    $i = 1;
    foreach ($most_viewed as $post) {
      $post_title = get_the_title();
      $post_like = intval($post->like);
      $post_like = number_format($post_like);
      $temp .= "<li><span class='li-icon li-icon-$i'>$i</span><a href=\"" . get_permalink() . "\">$post_title</a></li>";
      $i++;
    }
  } else {
    $temp = '<li>暂无文章</li>';
  }
  if ($display) {
    echo $temp;
  } else {
    return $temp;
  }
}
// 经典语句，用于评论输入区域的placeholder
function hitokoto()
{
  $data  = KL_THEME_URI . '/json/one.json';
  $json  = file_get_contents($data);
  $array = json_decode($json, true);
  $count = count($array);
  if ($count != 0) {
    $random = array_rand($array);
    $hitokoto = $array[$random]['hitokoto'];
    $author = $array[$random]['author'];
    $source = $array[$random]['source'];
    if ($hitokoto) {
      // echo (!empty($author) ? ($hitokoto . " —— " . $author) : $hitokoto);
      return $hitokoto
        . (!empty($author) ?  (" —— " . $author) : "")
        . (!empty($source) ? ((!empty($author) ? "," : "——") . $source) : "");
    } else {
      return '彩蛋！你很幸运，刷到一条空白的内容，当前有 ' . (intval(count($array)) - 1) . " 条 '一言'";
    }
  } else {
    return '';
  }
}
// 取消转义
// 取消内容转义 
// remove_filter('the_content', 'wptexturize');
// 取消摘要转义 
// remove_filter('the_excerpt', 'wptexturize');
// 取消评论转义 
remove_filter('comment_text', 'wptexturize');
function my_avatar($avatar)
{
  // $avatar = preg_replace("/http:\/\/(www|\d).gravatar.com/", "https://gravatar.loli.net", $avatar);
  $avatar = str_replace(array("www.gravatar.com", "0.gravatar.com", "1.gravatar.com", "2.gravatar.com", "secure.gravatar.com"), "gravatar.loli.net", $avatar);
  //~ 替换为 https 协议
  $avatar = str_replace("http://", "https://", $avatar);
  return $avatar;
}
add_filter('get_avatar', 'my_avatar');
// 增加个人简介信息
function my_new_contactmethods($contactmethods)
{
  $contactmethods['weibo'] = '微博';
  $contactmethods['zhihu'] = '知乎';
  $contactmethods['github'] = 'Github';
  $contactmethods['douban'] = '豆瓣';
  // $contactmethods['juejin'] = '掘金';
  // $contactmethods['facebook'] = '脸书';
  // $contactmethods['bilibili'] = 'bilibili';
  return $contactmethods;
}
add_filter('user_contactmethods', 'my_new_contactmethods', 10, 1);
// 添加首页支持的文体格式
function themename_custom_post_formats_setup()
{
  // 添加文章形式支持到说说类型 'moments'
  add_post_type_support('moments', 'post-formats');
  // 添加文章形式支持到自定义文章类型 'my_custom_post_type'
  // add_post_type_support( 'my_custom_post_type', 'post-formats' );
}
add_action('init', 'themename_custom_post_formats_setup');
function themename_post_formats_setup()
{
  add_theme_support('post-formats', array('moments'));
}
add_action('after_setup_theme', 'themename_post_formats_setup');
// 2021-02-02
// add_action('admin_init', 'redirect_non_admin_users');
// function redirect_non_admin_users()
// {
//     if (!current_user_can('manage_options') && '/wp-admin/admin-ajax.php' != $_SERVER['PHP_SELF']) {
//         wp_redirect(site_url("/")); #这里的"/me/"是前端用户中心的地址。
//         exit;
//     }
// }
// add_filter('login_redirect', 'new_login_redirect');
// function new_login_redirect()
// {
//     if (!current_user_can('manage_options')){
//         wp_redirect(site_url("/")); #这里的"/me/"是前端用户中心的地址。
//         exit;
//     }
// }
function my_login_redirect($redirect_to, $request)
{
  if (empty($redirect_to) || $redirect_to == "wp-admin/" || $redirect_to == admin_url())
    return home_url("");
  else
    return $redirect_to;
}
add_filter("login_redirect", "my_login_redirect", 10, 3);
// 禁用emoji表情
// function disable_emojis() {
//     remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
//     remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
//     remove_action( 'wp_print_styles', 'print_emoji_styles' );
//     remove_action( 'admin_print_styles', 'print_emoji_styles' );    
//     remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
//     remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );  
//     remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
//     add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
// }
// add_action( 'init', 'disable_emojis' );
// function disable_emojis_tinymce( $plugins ) {
// 	return array_diff( $plugins, array( 'wpemoji' ) );
// }
/**
 * wordpress优化 2020.12.18
 */
//彻底关闭 pingback
add_filter('xmlrpc_methods', function ($methods) {
  $methods['pingback.ping'] = '__return_false';
  $methods['pingback.extensions.getPingbacks'] = '__return_false';
  return $methods;
});
//禁用 pingbacks, enclosures, trackbacks
remove_action('do_pings', 'do_all_pings', 10);
//去掉 _encloseme 和 do_ping 操作。
remove_action('publish_post', '_publish_post_hook', 5);
// 禁用 Emoji 功能
remove_action('admin_print_scripts',    'print_emoji_detection_script');
remove_action('admin_print_styles', 'print_emoji_styles');
remove_action('wp_head',        'print_emoji_detection_script', 7);
remove_action('wp_print_styles',    'print_emoji_styles');
remove_action('embed_head',     'print_emoji_detection_script');
remove_filter('the_content_feed',   'wp_staticize_emoji');
remove_filter('comment_text_rss',   'wp_staticize_emoji');
remove_filter('wp_mail',        'wp_staticize_emoji_for_email');
add_filter('emoji_svg_url',        '__return_false');
// 屏蔽字符转码
add_filter('run_wptexturize', '__return_false');
// 彻底关闭 WordPress 自动更新和后台更新检查
add_filter('automatic_updater_disabled', '__return_true');  // 彻底关闭自动更新
remove_action('init', 'wp_schedule_update_checks'); // 关闭更新检查定时作业
wp_clear_scheduled_hook('wp_version_check');            // 移除已有的版本检查定时作业
wp_clear_scheduled_hook('wp_update_plugins');       // 移除已有的插件更新定时作业
wp_clear_scheduled_hook('wp_update_themes');            // 移除已有的主题更新定时作业
wp_clear_scheduled_hook('wp_maybe_auto_update');        // 移除已有的自动更新定时作业
remove_action('admin_init', '_maybe_update_core');        // 移除后台内核更新检查
remove_action('load-plugins.php', 'wp_update_plugins');   // 移除后台插件更新检查
remove_action('load-update.php', 'wp_update_plugins');
remove_action('load-update-core.php', 'wp_update_plugins');
remove_action('admin_init', '_maybe_update_plugins');
remove_action('load-themes.php', 'wp_update_themes');     // 移除后台主题更新检查
remove_action('load-update.php', 'wp_update_themes');
remove_action('load-update-core.php', 'wp_update_themes');
remove_action('admin_init', '_maybe_update_themes');
// 禁止古腾堡加载 Google 字体
add_action('admin_print_styles', function () {
  wp_deregister_style('wp-editor-font');
  wp_register_style('wp-editor-font', '');
});
// 通过前台不加载语言包来提高博客速度
add_filter('locale', function ($locale) {
  $locale = (is_admin()) ? $locale : 'en_US';
  return $locale;
});
// 移除 wp_head 无用的属性
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'start_post_rel_link');
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'adjacent_posts_rel_link');
// 移除自动修正 WordPress 大小写函数
remove_filter('the_content', 'capital_P_dangit');
remove_filter('the_title', 'capital_P_dangit');
remove_filter('comment_text', 'capital_P_dangit');
// 移除后台界面右上角的帮助
add_action('in_admin_header', function () {
  global $current_screen;
  $current_screen->remove_help_tabs();
});
// 解除 per_page 参数不可以超过100的限制
add_filter('rest_post_collection_params', 'my_prefix_change_post_per_page', 10, 1);
function my_prefix_change_post_per_page($params)
{
  if (isset($params['per_page'])) {
    $count_posts = wp_count_posts();
    $params['per_page']['maximum'] = $count_posts->publish; //增加限制到当前文章总数
  }
  return $params;
}
// Replace the default ellipsis
function trim_excerpt($text)
{
  $text = str_replace('[&hellip;]', '……', $text);
  return $text;
}
add_filter('get_the_excerpt', 'trim_excerpt');
// 激活主题创建页面
// 1、添加页面函数
function init_add_page($title, $slug, $page_template = '', $comment_status = 'closed', $order = 0)
{
  $allPages = get_pages(); //获取所有页面
  $exists = false;
  foreach ($allPages as $page) {
    //通过页面别名来判断页面是否已经存在
    if (strtolower($page->post_name) == strtolower($slug)) {
      $exists = true;
    }
  }
  if ($exists == false) {
    $new_page_id = wp_insert_post(array(
      'post_title' => $title,
      'post_type' => 'page',
      'post_name' => $slug,
      'comment_status' => $comment_status,
      'ping_status' => 'closed',
      'post_content' => '',
      'post_status' => 'publish',
      'post_author' => 1,
      'menu_order' => $order
    ));
    //如果插入成功 且设置了模板
    if ($new_page_id && $page_template != '') {
      //保存页面模板信息
      update_post_meta($new_page_id, '_wp_page_template', $page_template);
    }
  }
}
// 2、通过hook执行创建页面函数
function init_add_pages()
{
  global $pagenow;
  //判断是否为激活主题页面
  if ('themes.php' == $pagenow && isset($_GET['activated'])) {
    // ashu_add_page('登录页面','login','page-login.php');
    // ashu_add_page('注册页面','register','page-register.php');
    // 页面标题,别名,页面模板
    // TODO: 待优化名称
    init_add_page('映象', 'page-movie', page_template_directory . 'page-movie.php');
    init_add_page('链集', 'page-links', page_template_directory . 'page-links.php', 'open');
    init_add_page('归档', 'page-archive', page_template_directory . 'page-archive.php');
    init_add_page('关于', 'page-about', page_template_directory . 'page-about.php');
    init_add_page('快捷发布', 'page-post-simple', page_template_directory . '/page-post-simple.php');
  }
}
add_action('load-themes.php', 'init_add_pages');
function filter_rest_allow_anonymous_comments()
{
  return true;
}
add_filter('rest_allow_anonymous_comments', 'filter_rest_allow_anonymous_comments');
// 移除部分自带小工具
// function remove_some_wp_widgets()
// {
//     $unregister_widgets = array(
//         // 'Tag_Cloud',
//         // 'Recent_Comments',
//         // 'Recent_Posts',
//         'Links',
//         'Search',
//         'Meta',
//         'Categories',
//         'RSS'
//     );
//     foreach ($unregister_widgets as $widget)
//         unregister_widget('WP_Widget_' . $widget);
//     foreach (glob(get_template_directory() . '/widgets/widget-with-settings-*.php') as $file_path)
//         include($file_path);
// }
// add_action('widgets_init', 'remove_some_wp_widgets', 1);
// 允许post类型展示自定义字段
$object_type = 'post';
$meta_args = array( // Validate and sanitize the meta value.
  // Note: currently (4.7) one of 'string', 'boolean', 'integer',
  // 'number' must be used as 'type'. The default is 'string'.
  'type'         => 'string',
  // Shown in the schema for the meta key.
  'description'  => 'A meta key associated with a string meta value.',
  // Return a single value of the type.
  'single'       => true,
  // Show in the WP REST API response. Default: false.
  'show_in_rest' => true,
);
register_meta($object_type, 'my_meta_key', $meta_args);

/**
 * WordPress 后台用户列表添加上次登录时间
 */
// 创建一个新字段存储用户登录时间
function insert_last_login($login)
{
  $user = get_userdatabylogin($login);
  update_user_meta($user->ID, 'last_login', current_time('mysql'));
}
add_action('wp_login', 'insert_last_login');
// 添加一个新栏目“上次登录”
function add_last_login_column($columns)
{
  $columns['last_login'] = '上次登录';
  return $columns;
}
add_filter('manage_users_columns', 'add_last_login_column');
// 显示登录时间到新增栏目
function add_last_login_column_value($value, $column_name, $user_id)
{
  $user = get_userdata($user_id);
  if ('last_login' == $column_name && $user->last_login)
    $value = get_user_meta($user->ID, 'last_login', true);
  else $value = '从未登录';
  return $value;
}
add_action('manage_users_custom_column', 'add_last_login_column_value', 10, 3);

// 2018-8-14 引入
// function translate_chinese_post_title_to_en_for_slug( $title ) {
// 	$translation_render = 'http://fanyi.baidu.com/v2transapi?from=zh&to=en&transtype=realtime&simple_means_flag=3&query='.$title;
// 	$wp_http_get = wp_safe_remote_get( $translation_render );
// 	if ( empty( $wp_http_get->errors ) ) { 
// 		if ( ! empty( $wp_http_get['body'] ) ) {
// 			$trans_result = json_decode( $wp_http_get['body'], true );
// 			$trans_title = $trans_result['trans_result']['data'][0]['dst'];
// 			return $trans_title;
// 		}
// 	}
// 	return $title;
// } 
// add_filter( 'sanitize_title', 'translate_chinese_post_title_to_en_for_slug', 1 );
// add_filter( 'avatar_defaults', 'newgravatar' );   
// function newgravatar ($avatar_defaults) {  
//     $myavatar =  get_bloginfo('template_directory') . '/img/wp-default-gravatar.png';  
//     $avatar_defaults[$myavatar] = "默认头像";  
//     return $avatar_defaults;  
// }
/* 访问计数 */
// function record_visitors()
// {
// 	if (is_singular())
// 	{
// 		global $post;
// 		$post_ID = $post->ID;
// 		if($post_ID)
// 		{
// 			$post_views = (int)get_post_meta($post_ID, 'views', true);
// 			if(!update_post_meta($post_ID, 'views', ($post_views+1)))
// 			{
// 				add_post_meta($post_ID, 'views', 1, true);
// 			}
// 		}
// 	}
// }
// add_action('wp_head', 'record_visitors');
/// 函数名称：post_views
/// 函数作用：取得文章的阅读次数
// function post_views($before = '(点击 ', $after = ' 次)', $echo = 1){
// 	global $post;
// 	$post_ID = $post->ID;
// 	$views = (int)get_post_meta($post_ID, 'views', true);
// 	if ($echo) return $before.number_format($views).$after;
// 	else return $views;
// }
