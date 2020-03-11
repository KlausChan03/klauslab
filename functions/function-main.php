<?php

/**
 * KlausLab functions and definitions
 *
 * @package KlausLab
 */

define('KL_THEME_DIR', get_template_directory() . '/dist');
define('KL_DIR', get_template_directory() . '/inc');
define('KL_THEME_URI', get_template_directory_uri() . '/dist');
define('KL_URI', get_template_directory_uri() . '/inc');


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
        add_theme_support('automatic-feed-links');

        /*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
        add_theme_support('title-tag');
        add_theme_support('custom-logo');

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus(array(
            'primary' => esc_html__('Primary Menu', 'KlausLab'),
            'social'  => esc_html__('Social Links', 'KlausLab'),
        ));


        /*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ));
    }
endif; // KlausLab_setup
add_action('after_setup_theme', 'KlausLab_setup');


// function KL_THEME_DIR {
//     $new_router = get_template_directory_uri() . '/dist';
//     return $new_router;
// }
// $new_router = get_template_directory_uri() . '/dist';


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
add_action('after_setup_theme', 'woocommerce_support');
function woocommerce_support()
{
    add_theme_support('woocommerce');
}

if (!function_exists('KlausLab_comments')) :

    /*
 * Custom comments display to move Reply link,
 * used in comments.php
 */


    // 输出评论
    function memory_comment($comment, $args, $depth)
    {
        $GLOBALS['comment'] = $comment;
?>
        <li class="comment-item" id="li-comment-<?php comment_ID(); ?>">
            <div class="commentator-avatar">
                <?php if (function_exists('get_avatar') && get_option('show_avatars')) {
                    if (get_comment_author_url() != null) { ?>
                        <a href="<?php echo get_comment_author_url(); ?>" target="_blank">
                        <?php }
                    echo get_avatar($comment, 48);
                    if (get_comment_author_url() != null) { ?>
                        </a>
                <?php }
                }
                ?>
            </div>
            <div class="commentator-comment" id="comment-<?php comment_ID(); ?>"><span class="commentator-name"><?php printf(__('<span class="author-name">%s</span> '), get_comment_author_link());
                                                                                                                if ($comment->user_id == '1') { ?><i class="memory memory-certify"></i><?php } ?></span> <?php echo get_author_class($comment->comment_author_email, $comment->user_id); ?>
                           <div class="comment-chat">
                    <div class="comment-comment">
                        <?php if ($comment->comment_approved == '0') : ?><p>你的评论正在审核，稍后会显示出来！</p><?php endif; ?>
                        <?php comment_text(); ?>
                        <div class="comment-info">
                            <span class="comment-time"><?php echo human_time_diff(get_comment_date('U', $comment->comment_ID), current_time('timestamp')) . '前'; ?></span>
                            <?php if ($comment->comment_approved == '1') {
                                comment_reply_link(array_merge($args, array('reply_text' => '回复', 'depth' => $depth, 'max_depth' => $args['max_depth'], 'before' => '<span class="reply flex-hr-vc"><i class="lalaksks lalaksks-ic-reply"></i>', 'after' => '</span>')));
                            } ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php }

    function KlausLab_comments($comment, $args, $depth)
    {
        $GLOBALS['comment'] = $comment;

        ?>
        <li id="comment-<?php comment_ID(); ?>" <?php comment_class(empty($args['has_children']) ? '' : 'parent'); ?>>
            <article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
                <div class="comment-meta">
                    <div class="comment-author vcard flex-hl-vc">
                        <?php if (0 != $args['avatar_size']) echo get_avatar($comment, '36'); ?>
                        <div class="comment-metadata flex-hb-vc flex-hw">
                            <div class="flex-v">
                                <!-- 评论者 -->
                                <div>
                                    <b class="fn mr-5">
                                        <?php printf('%s', get_comment_author_link()); ?></b>
                                    <?php if ($comment->user_id == '1') {
                                        echo '<span class="vip level_Max">博主</span>';
                                    } else {
                                        echo get_author_class($comment->comment_author_email, $comment->user_id);
                                    } ?>
                                </div>
                                <!-- 评论时间 -->
                                <div>
                                    <a href="<?php echo esc_url(get_comment_link($comment->comment_ID, $args)); ?>">
                                        <time datetime="<?php comment_time('c'); ?>">
                                            <?php printf(esc_html_x('%1$s at %2$s', '1: date, 2: time', 'KlausLab'), get_comment_date(), get_comment_time()); ?>
                                        </time>
                                    </a>
                                </div>
                            </div>
                            <div class="flex-hc-vc">
                                <!-- 编辑评论 -->
                                <?php
                                if (isAdmin()) {
                                    edit_comment_link(_e('<span class="edit-link flex-hc-vc"><i class="lalaksks lalaksks-ic-edit"></i>', '</span>'));
                                }
                                ?>
                                <!-- 回复评论 -->

                                <?php if ($comment->comment_approved == '1') {
                                    comment_reply_link(array_merge($args, array('reply_text' => '回复', 'depth' => $depth, 'max_depth' => $args['max_depth'],                                'before'    => '<span class="reply flex-hc-vc ml-10"><i class="lalaksks lalaksks-ic-reply"></i>', 'after'     => '</span>')));
                                } ?>

                            </div>
                        </div><!-- .comment-metadata -->
                    </div><!-- .comment-author -->

                    <?php if ('0' == $comment->comment_approved) : ?>
                        <p class="comment-awaiting-moderation">
                            <?php esc_html_e('Your comment is awaiting moderation.', 'KlausLab'); ?>
                        </p>
                    <?php endif; ?>
                </div><!-- .comment-meta -->

                <div class="comment-content">
                    <?php comment_text(); ?>
                </div><!-- .comment-content -->

            </article><!-- .comment-body -->
        <?php
    }

endif;

require KL_DIR . '/ajax-comment/main.php';


/**
 * Custom template tags for this theme.
 */
require KL_DIR . '/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */

require KL_DIR . '/extras.php';

/**
 * Customizer additions.
 */
require KL_DIR . '/customizer.php';

function normal_style_script()
{
    wp_enqueue_script('KlausLab-navigation', KL_THEME_URI . '/js/navigation.js', array(), '20120206', true);
    // 媒体查询样式
    wp_enqueue_style('mediaCss', KL_THEME_URI . '/css/media.css', array(), '1.0', false);
    // 动画库样式
    wp_enqueue_style('animate', KL_THEME_URI . '/css/animate.min.css', array(), '3.5.1', false);
    // 插件样式
    wp_enqueue_style('support', KL_THEME_URI . '/css/support.css', array(), '1.0', false);
    // vue.min.js   
    wp_enqueue_script('vue', KL_THEME_URI . '/js/vue.min.js', array(), '2.6.0', false);
    // axios.min.js
    wp_enqueue_script('axios', KL_THEME_URI . '/js/axios.min.js', array(), '0.19.0', false);
    // katelog.min.js
    wp_enqueue_script('katelog', KL_THEME_URI . '/js/katelog.min.js', array(), '1.0.0', false);
    // 全局变量配置
    wp_enqueue_script('myConfig', KL_THEME_URI . '/js/config.js', array(), '1.0', false);
    // 配置
    wp_enqueue_script('myOptions', KL_THEME_URI . '/js/options.js', array(), '1.0', false);
    // ElementUI
    wp_enqueue_script('element-ui-js', KL_THEME_URI . '/js/element-ui.min.js', array(), '1.0', false);
    wp_enqueue_style('element-ui-css', KL_THEME_URI . '/css/element-ui.min.css', array(), '1.0', false);
}



function footer_script()
{

    // 交互
    wp_enqueue_script('commonFunc', KL_THEME_URI . '/js/common.js', array(), '1.0', false);
    // 支持
    wp_enqueue_script('support', KL_THEME_URI . '/js/support.js', false, '1.0', array('jquery'));
    // 动画
    wp_enqueue_script('canvasFunc', KL_THEME_URI . '/js/canvas.js', array(), '1.0', false);
    // 右下角固定插件
    wp_enqueue_script('fixedPlugins', KL_THEME_URI . '/js/fixed-plugins.js', array(), '1.0', false);
    // 先将ajaxurl变数设定好
    // wp_localize_script('ajax', 'my_ajax_obj', array('ajaxurl' => admin_url('admin-ajax.php')));
    wp_localize_script('fixedPlugins', 'KlausLabConfig', array(
        'siteUrl' => get_stylesheet_directory_uri(),
        'siteStartTime' => cs_get_option('memory_start_time'),
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'commentEditAgain' => cs_get_option('memory_comment_edit'),
        'loadPjax' => cs_get_option('memory_pjax'),
    ));
}

function custom_login()
{
    echo '<link rel="stylesheet" type="text/css" href="' . get_bloginfo('template_directory') . '/css/login.css" />';
}

function is_login()
{
    return in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'));
}


function styles_scripts()
{
    if (!is_admin()) { // 前台加载的脚本与样式表
        // 去除已注册的 jquery 脚本
        wp_deregister_script('jquery');
        // 注册 jquery 脚本
        wp_register_script('jquery', '//code.jquery.com/jquery.min.js', array(), 'lastest', false);
        // 提交加载 jquery 脚本
        wp_enqueue_script('jquery');
        if (is_mobile() === true && is_login() === false) {
            wp_enqueue_script('util', KL_THEME_URI . '/js/util.js', array(), 'lastet', false);
        }
    } else { // 后台加载的脚本与样式表
        // 取消加载 jquery 脚本
        wp_dequeue_script('jquery');
        // 注册并加载 jquery 脚本
        wp_enqueue_script('jquery', '//code.jquery.com/jquery.min.js', array(), 'lastest', false);
    }
}


add_action('init', 'styles_scripts');
add_action('wp_footer', 'footer_script');
add_action('wp_enqueue_scripts', 'normal_style_script');
add_action('login_head', 'custom_login');


//自定义登录页面的LOGO图片
function my_custom_login_logo()
{
    echo '<style type="text/css">
        .login h1 a {
			background-image:url("' . KL_THEME_URI . '/img/bg-test.jpg' . '") !important;
			height: 80px;
			width: 80px;
			border-radius: 50%;
			-webkit-background-size: 160px;
			background-size: 160px;
			background-position: center center;
        }
    </style>';
}
add_action('login_head', 'my_custom_login_logo');



add_action('wp_ajax_list_rec', 'list_rec_callback');
function list_rec_callback()
{
    // 读取POST资料


    global $wpdb; //可以拿POST来的资料作为条件，捞DB的资料来作显示
    echo the_content();
    die(); // this is required to return a proper result
}

function load_post()
{
    // 如果 action ID 是 load_post, 并且传入的必须参数存在, 则执行响应方法 
    if ($_GET['action'] == 'load_post' && $_GET['id'] != '') {
        $id = $_GET["id"];
        $output = '';
        // 获取文章对象 
        global $wpdb, $post;
        $post = $wpdb->get_row(
            $wpdb->prepare("SELECT * FROM $wpdb->posts WHERE ID = %d LIMIT 1", $id)
        );
        // 如果指定 ID 的文章存在, 则对他进行格式化 
        if ($post) {
            $content = $post->post_content;
            $output = balanceTags($content);
            $output = wpautop($output);
        }
        // 打印文章内容并中断后面的处理 
        echo $output;
        die();
    }
}

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


// 评论添加@ 
// add_filter( 'get_comment_text' , 'comment_add_at', 20, 2); // 添加过滤器，加入以下值
// function comment_add_at( $get_comment_text, $comment = '') {
//   if( $comment->comment_parent > 0) {
//     $get_comment_text = '<a class="col-gray at-reply mr-5" href="#comment-' . $comment->comment_parent . '">@'.get_comment_author( $comment->comment_parent ) . '</a>' . $get_comment_text;
//   }
//   return $get_comment_text; // 返回添加@的函数,名称不能自定义
// }

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

function getGravatar($email, $s = 96, $d = 'mp', $r = 'g', $img = false, $atts = array())
{
    $url = '//www.gravatar.com/avatar/';
    $url .= md5(strtolower(trim($email)));
    $url .= "?s=$s&d=$d&r=$r";
    if ($img) {
        $url = '<img src="' . $url . '"';
        foreach ($atts as $key => $val)
            $url .= ' ' . $key . '="' . $val . '"';
        $url .= ' />';
    }
    return $url;
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
    $already_has_thumb = has_post_thumbnail($post->ID);
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
function get_author_class($comment_author_email, $user_id)
{
    global $wpdb;
    $author_count = count($wpdb->get_results(
        "SELECT comment_ID as author_count FROM $wpdb->comments WHERE comment_author_email = '$comment_author_email' "
    ));
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
        echo '<span class="vip level_7">LV.7</span>';
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
    $user_hero = $wpdb->get_row("SELECT nickname,img FROM {$wpdb->prefix}xh_social_channel_wechat WHERE ID=1");
    $user_heroine = $wpdb->get_row("SELECT nickname,img FROM {$wpdb->prefix}xh_social_channel_wechat WHERE ID=2");

    $return_arr = array($user_first, $user_hero, $user_heroine);
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



// 七牛CDN
// if ( !is_admin() ) {
//     add_action('wp_loaded','cdn_ob_start');

//     function cdn_ob_start() {
//         ob_start('qiniu_cdn_replace');
//     }

//     // 修改自七牛镜像存储 WordPress 插件
//     function qiniu_cdn_replace($html){
//         $local_host = 'https://www.klauslaura.cn'; //博客域名
//         $qiniu_host = 'https://cdn.klauslaura.cn'; //七牛域名
//         $cdn_exts   = 'png|jpg|jpeg|gif|ico|webp'; //扩展名（使用|分隔）
//         $cdn_dirs   = 'wp-content|wp-includes'; //目录（使用|分隔）

//         $cdn_dirs   = str_replace('-', '\-', $cdn_dirs);

//         if ($cdn_dirs) {
//             $regex  =  '/' . str_replace('/', '\/', $local_host) . '\/((' . $cdn_dirs . ')\/[^\s\?\\\'\"\;\>\<]{1,}.(' . $cdn_exts . '))([\"\\\'\s\?]{1})/';
//             $html =  preg_replace($regex, $qiniu_host . '/$1$4', $html);
//         } else {
//             $regex  = '/' . str_replace('/', '\/', $local_host) . '\/([^\s\?\\\'\"\;\>\<]{1,}.(' . $cdn_exts . '))([\"\\\'\s\?]{1})/';
//             $html =  preg_replace($regex, $qiniu_host . '/$1$3', $html);
//         }
//         return $html;
//     }
// }


function comment_add_owo($comment_text, $comment = '')
{
    $data_OwO = array(
        '$(便便)' => '<img src="' . get_bloginfo('template_url') . '/emoji/alu/便便@2x.png" alt="便便" class="OwO-img">',
        '$(暗地观察)' => '<img src="' . get_bloginfo('template_url') . '/emoji/alu/暗地观察@2x.png" alt="暗地观察" class="OwO-img">',
        '$(不出所料)' => '<img src="' . get_bloginfo('template_url') . '/emoji/alu/不出所料@2x.png" alt="不出所料" class="OwO-img">',
        '$(不高兴)' => '<img src="' . get_bloginfo('template_url') . '/emoji/alu/不高兴@2x.png" alt="不高兴" class="OwO-img">',
        '$(不说话)' => '<img src="' . get_bloginfo('template_url') . '/emoji/alu/不说话@2x.png" alt="不说话" class="OwO-img">',
        '$(抽烟)' => '<img src="' . get_bloginfo('template_url') . '/emoji/alu/抽烟@2x.png" alt="抽烟" class="OwO-img">',
        '$(呲牙)' => '<img src="' . get_bloginfo('template_url') . '/emoji/alu/呲牙@2x.png" alt="呲牙" class="OwO-img">',
        '$(大囧)' => '<img src="' . get_bloginfo('template_url') . '/emoji/alu/大囧@2x.png" alt="大囧" class="OwO-img">',
        '$(得意)' => '<img src="' . get_bloginfo('template_url') . '/emoji/alu/得意@2x.png" alt="得意" class="OwO-img">',
        '$(愤怒)' => '<img src="' . get_bloginfo('template_url') . '/emoji/alu/愤怒@2x.png" alt="愤怒" class="OwO-img">',
        '$(尴尬)' => '<img src="' . get_bloginfo('template_url') . '/emoji/alu/尴尬@2x.png" alt="尴尬" class="OwO-img">',
        '$(高兴)' => '<img src="' . get_bloginfo('template_url') . '/emoji/alu/高兴@2x.png" alt="高兴" class="OwO-img">',
        '$(鼓掌)' => '<img src="' . get_bloginfo('template_url') . '/emoji/alu/鼓掌@2x.png" alt="鼓掌" class="OwO-img">',
        '$(观察)' => '<img src="' . get_bloginfo('template_url') . '/emoji/alu/观察@2x.png" alt="观察" class="OwO-img">',
        '$(害羞)' => '<img src="' . get_bloginfo('template_url') . '/emoji/alu/害羞@2x.png" alt="害羞" class="OwO-img">',
        '$(汗)' => '<img src="' . get_bloginfo('template_url') . '/emoji/alu/汗@2x.png" alt="汗" class="OwO-img">',
        '$(黑线)' => '<img src="' . get_bloginfo('template_url') . '/emoji/alu/黑线@2x.png" alt="黑线" class="OwO-img">',
        '$(欢呼)' => '<img src="' . get_bloginfo('template_url') . '/emoji/alu/欢呼@2x.png" alt="欢呼" class="OwO-img">',
        '$(击掌)' => '<img src="' . get_bloginfo('template_url') . '/emoji/alu/击掌@2x.png" alt="击掌" class="OwO-img">',
        '$(惊喜)' => '<img src="' . get_bloginfo('template_url') . '/emoji/alu/惊喜@2x.png" alt="惊喜" class="OwO-img">',
        '$(看不见)' => '<img src="' . get_bloginfo('template_url') . '/emoji/alu/看不见@2x.png" alt="看不见" class="OwO-img">',
        '$(看热闹)' => '<img src="' . get_bloginfo('template_url') . '/emoji/alu/看热闹@2x.png" alt="看热闹" class="OwO-img">',
        '$(抠鼻)' => '<img src="' . get_bloginfo('template_url') . '/emoji/alu/抠鼻@2x.png" alt="抠鼻" class="OwO-img">',
        '$(口水)' => '<img src="' . get_bloginfo('template_url') . '/emoji/alu/口水@2x.png" alt="口水" class="OwO-img">',
        '$(哭泣)' => '<img src="' . get_bloginfo('template_url') . '/emoji/alu/哭泣@2x.png" alt="哭泣" class="OwO-img">',
        '$(狂汗)' => '<img src="' . get_bloginfo('template_url') . '/emoji/alu/狂汗@2x.png" alt="狂汗" class="OwO-img">',
        '$(蜡烛)' => '<img src="' . get_bloginfo('template_url') . '/emoji/alu/蜡烛@2x.png" alt="蜡烛" class="OwO-img">',
        '$(脸红)' => '<img src="' . get_bloginfo('template_url') . '/emoji/alu/脸红@2x.png" alt="脸红" class="OwO-img">',
        '$(内伤)' => '<img src="' . get_bloginfo('template_url') . '/emoji/alu/内伤@2x.png" alt="内伤" class="OwO-img">',
        '$(喷水)' => '<img src="' . get_bloginfo('template_url') . '/emoji/alu/喷水@2x.png" alt="喷水" class="OwO-img">',
        '$(喷血)' => '<img src="' . get_bloginfo('template_url') . '/emoji/alu/喷血@2x.png" alt="喷血" class="OwO-img">',
        '$(期待)' => '<img src="' . get_bloginfo('template_url') . '/emoji/alu/期待@2x.png" alt="期待" class="OwO-img">',
        '$(亲亲)' => '<img src="' . get_bloginfo('template_url') . '/emoji/alu/亲亲@2x.png" alt="亲亲" class="OwO-img">',
        '$(傻笑)' => '<img src="' . get_bloginfo('template_url') . '/emoji/alu/傻笑@2x.png" alt="傻笑" class="OwO-img">',
        '$(扇耳光)' => '<img src="' . get_bloginfo('template_url') . '/emoji/alu/扇耳光@2x.png" alt="扇耳光" class="OwO-img">',
        '$(深思)' => '<img src="' . get_bloginfo('template_url') . '/emoji/alu/深思@2x.png" alt="深思" class="OwO-img">',
        '$(锁眉)' => '<img src="' . get_bloginfo('template_url') . '/emoji/alu/锁眉@2x.png" alt="锁眉" class="OwO-img">',
        '$(投降)' => '<img src="' . get_bloginfo('template_url') . '/emoji/alu/投降@2x.png" alt="投降" class="OwO-img">',
        '$(吐)' => '<img src="' . get_bloginfo('template_url') . '/emoji/alu/吐@2x.png" alt="吐" class="OwO-img">',
        '$(吐舌)' => '<img src="' . get_bloginfo('template_url') . '/emoji/alu/吐舌@2x.png" alt="吐舌" class="OwO-img">',
        '$(吐血倒地)' => '<img src="' . get_bloginfo('template_url') . '/emoji/alu/吐血倒地@2x.png" alt="吐血倒地" class="OwO-img">',
        '$(无奈)' => '<img src="' . get_bloginfo('template_url') . '/emoji/alu/无奈@2x.png" alt="无奈" class="OwO-img">',
        '$(无所谓)' => '<img src="' . get_bloginfo('template_url') . '/emoji/alu/无所谓@2x.png" alt="无所谓" class="OwO-img">',
        '$(无语)' => '<img src="' . get_bloginfo('template_url') . '/emoji/alu/无语@2x.png" alt="无语" class="OwO-img">',
        '$(喜极而泣)' => '<img src="' . get_bloginfo('template_url') . '/emoji/alu/喜极而泣@2x.png" alt="喜极而泣" class="OwO-img">',
        '$(献花)' => '<img src="' . get_bloginfo('template_url') . '/emoji/alu/献花@2x.png" alt="献花" class="OwO-img">',
        '$(献黄瓜)' => '<img src="' . get_bloginfo('template_url') . '/emoji/alu/献黄瓜@2x.png" alt="献黄瓜" class="OwO-img">',
        '$(想一想)' => '<img src="' . get_bloginfo('template_url') . '/emoji/alu/想一想@2x.png" alt="想一想" class="OwO-img">',
        '$(小怒)' => '<img src="' . get_bloginfo('template_url') . '/emoji/alu/小怒@2x.png" alt="小怒" class="OwO-img">',
        '$(小眼睛)' => '<img src="' . get_bloginfo('template_url') . '/emoji/alu/小眼睛@2x.png" alt="小眼睛" class="OwO-img">',
        '$(邪恶)' => '<img src="' . get_bloginfo('template_url') . '/emoji/alu/邪恶@2x.png" alt="邪恶" class="OwO-img">',
        '$(咽气)' => '<img src="' . get_bloginfo('template_url') . '/emoji/alu/咽气@2x.png" alt="咽气" class="OwO-img">',
        '$(阴暗)' => '<img src="' . get_bloginfo('template_url') . '/emoji/alu/阴暗@2x.png" alt="阴暗" class="OwO-img">',
        '$(赞一个)' => '<img src="' . get_bloginfo('template_url') . '/emoji/alu/赞一个@2x.png" alt="赞一个" class="OwO-img">',
        '$(长草)' => '<img src="' . get_bloginfo('template_url') . '/emoji/alu/长草@2x.png" alt="长草" class="OwO-img">',
        '$(中刀)' => '<img src="' . get_bloginfo('template_url') . '/emoji/alu/中刀@2x.png" alt="中刀" class="OwO-img">',
        '$(中枪)' => '<img src="' . get_bloginfo('template_url') . '/emoji/alu/中枪@2x.png" alt="中枪" class="OwO-img">',
        '$(中指)' => '<img src="' . get_bloginfo('template_url') . '/emoji/alu/中指@2x.png" alt="中指" class="OwO-img">',
        '$(肿包)' => '<img src="' . get_bloginfo('template_url') . '/emoji/alu/肿包@2x.png" alt="肿包" class="OwO-img">',
        '$(皱眉)' => '<img src="' . get_bloginfo('template_url') . '/emoji/alu/皱眉@2x.png" alt="皱眉" class="OwO-img">',
        '$(装大款)' => '<img src="' . get_bloginfo('template_url') . '/emoji/alu/装大款@2x.png" alt="装大款" class="OwO-img">',
        '$(坐等)' => '<img src="' . get_bloginfo('template_url') . '/emoji/alu/坐等@2x.png" alt="坐等" class="OwO-img">',
        '$[啊]' => '<img src="' . get_bloginfo('template_url') . '/emoji/paopao/啊@2x.png" alt="啊" class="OwO-img">',
        '$[爱心]' => '<img src="' . get_bloginfo('template_url') . '/emoji/paopao/爱心@2x.png" alt="爱心" class="OwO-img">',
        '$[鄙视]' => '<img src="' . get_bloginfo('template_url') . '/emoji/paopao/鄙视@2x.png" alt="鄙视" class="OwO-img">',
        '$[便便]' => '<img src="' . get_bloginfo('template_url') . '/emoji/paopao/便便@2x.png" alt="便便" class="OwO-img">',
        '$[不高兴]' => '<img src="' . get_bloginfo('template_url') . '/emoji/paopao/不高兴@2x.png" alt="不高兴" class="OwO-img">',
        '$[彩虹]' => '<img src="' . get_bloginfo('template_url') . '/emoji/paopao/彩虹@2x.png" alt="彩虹" class="OwO-img">',
        '$[茶杯]' => '<img src="' . get_bloginfo('template_url') . '/emoji/paopao/茶杯@2x.png" alt="茶杯" class="OwO-img">',
        '$[大拇指]' => '<img src="' . get_bloginfo('template_url') . '/emoji/paopao/大拇指@2x.png" alt="大拇指" class="OwO-img">',
        '$[蛋糕]' => '<img src="' . get_bloginfo('template_url') . '/emoji/paopao/蛋糕@2x.png" alt="蛋糕" class="OwO-img">',
        '$[灯泡]' => '<img src="' . get_bloginfo('template_url') . '/emoji/paopao/灯泡@2x.png" alt="灯泡" class="OwO-img">',
        '$[乖]' => '<img src="' . get_bloginfo('template_url') . '/emoji/paopao/乖@2x.png" alt="乖" class="OwO-img">',
        '$[哈哈]' => '<img src="' . get_bloginfo('template_url') . '/emoji/paopao/哈哈@2x.png" alt="哈哈" class="OwO-img">',
        '$[汗]' => '<img src="' . get_bloginfo('template_url') . '/emoji/paopao/汗@2x.png" alt="汗" class="OwO-img">',
        '$[呵呵]' => '<img src="' . get_bloginfo('template_url') . '/emoji/paopao/呵呵@2x.png" alt="呵呵" class="OwO-img">',
        '$[黑线]' => '<img src="' . get_bloginfo('template_url') . '/emoji/paopao/黑线@2x.png" alt="黑线" class="OwO-img">',
        '$[红领巾]' => '<img src="' . get_bloginfo('template_url') . '/emoji/paopao/红领巾@2x.png" alt="红领巾" class="OwO-img">',
        '$[呼]' => '<img src="' . get_bloginfo('template_url') . '/emoji/paopao/呼@2x.png" alt="呼" class="OwO-img">',
        '$[花心]' => '<img src="' . get_bloginfo('template_url') . '/emoji/paopao/花心@2x.png" alt="花心" class="OwO-img">',
        '$[滑稽]' => '<img src="' . get_bloginfo('template_url') . '/emoji/paopao/滑稽@2x.png" alt="滑稽" class="OwO-img">',
        '$[惊哭]' => '<img src="' . get_bloginfo('template_url') . '/emoji/paopao/惊哭@2x.png" alt="惊哭" class="OwO-img">',
        '$[惊讶]' => '<img src="' . get_bloginfo('template_url') . '/emoji/paopao/惊讶@2x.png" alt="惊讶" class="OwO-img">',
        '$[开心]' => '<img src="' . get_bloginfo('template_url') . '/emoji/paopao/开心@2x.png" alt="开心" class="OwO-img">',
        '$[酷]' => '<img src="' . get_bloginfo('template_url') . '/emoji/paopao/酷@2x.png" alt="酷" class="OwO-img">',
        '$[狂汗]' => '<img src="' . get_bloginfo('template_url') . '/emoji/paopao/狂汗@2x.png" alt="狂汗" class="OwO-img">',
        '$[蜡烛]' => '<img src="' . get_bloginfo('template_url') . '/emoji/paopao/蜡烛@2x.png" alt="蜡烛" class="OwO-img">',
        '$[懒得理]' => '<img src="' . get_bloginfo('template_url') . '/emoji/paopao/懒得理@2x.png" alt="懒得理" class="OwO-img">',
        '$[泪]' => '<img src="' . get_bloginfo('template_url') . '/emoji/paopao/泪@2x.png" alt="泪" class="OwO-img">',
        '$[冷]' => '<img src="' . get_bloginfo('template_url') . '/emoji/paopao/冷@2x.png" alt="冷" class="OwO-img">',
        '$[礼物]' => '<img src="' . get_bloginfo('template_url') . '/emoji/paopao/礼物@2x.png" alt="礼物" class="OwO-img">',
        '$[玫瑰]' => '<img src="' . get_bloginfo('template_url') . '/emoji/paopao/玫瑰@2x.png" alt="玫瑰" class="OwO-img">',
        '$[勉强]' => '<img src="' . get_bloginfo('template_url') . '/emoji/paopao/勉强@2x.png" alt="勉强" class="OwO-img">',
        '$[你懂的]' => '<img src="' . get_bloginfo('template_url') . '/emoji/paopao/你懂的@2x.png" alt="你懂的" class="OwO-img">',
        '$[怒]' => '<img src="' . get_bloginfo('template_url') . '/emoji/paopao/怒@2x.png" alt="怒" class="OwO-img">',
        '$[喷]' => '<img src="' . get_bloginfo('template_url') . '/emoji/paopao/喷@2x.png" alt="喷" class="OwO-img">',
        '$[钱]' => '<img src="' . get_bloginfo('template_url') . '/emoji/paopao/钱@2x.png" alt="钱" class="OwO-img">',
        '$[钱币]' => '<img src="' . get_bloginfo('template_url') . '/emoji/paopao/钱币@2x.png" alt="钱币" class="OwO-img">',
        '$[弱]' => '<img src="' . get_bloginfo('template_url') . '/emoji/paopao/弱@2x.png" alt="弱" class="OwO-img">',
        '$[三道杠]' => '<img src="' . get_bloginfo('template_url') . '/emoji/paopao/三道杠@2x.png" alt="三道杠" class="OwO-img">',
        '$[沙发]' => '<img src="' . get_bloginfo('template_url') . '/emoji/paopao/沙发@2x.png" alt="沙发" class="OwO-img">',
        '$[生气]' => '<img src="' . get_bloginfo('template_url') . '/emoji/paopao/生气@2x.png" alt="生气" class="OwO-img">',
        '$[胜利]' => '<img src="' . get_bloginfo('template_url') . '/emoji/paopao/胜利@2x.png" alt="胜利" class="OwO-img">',
        '$[手纸]' => '<img src="' . get_bloginfo('template_url') . '/emoji/paopao/手纸@2x.png" alt="手纸" class="OwO-img">',
        '$[睡觉]' => '<img src="' . get_bloginfo('template_url') . '/emoji/paopao/睡觉@2x.png" alt="睡觉" class="OwO-img">',
        '$[酸爽]' => '<img src="' . get_bloginfo('template_url') . '/emoji/paopao/酸爽@2x.png" alt="酸爽" class="OwO-img">',
        '$[太开心]' => '<img src="' . get_bloginfo('template_url') . '/emoji/paopao/太开心@2x.png" alt="太开心" class="OwO-img">',
        '$[太阳]' => '<img src="' . get_bloginfo('template_url') . '/emoji/paopao/太阳@2x.png" alt="太阳" class="OwO-img">',
        '$[吐]' => '<img src="' . get_bloginfo('template_url') . '/emoji/paopao/吐@2x.png" alt="吐" class="OwO-img">',
        '$[吐舌]' => '<img src="' . get_bloginfo('template_url') . '/emoji/paopao/吐舌@2x.png" alt="吐舌" class="OwO-img">',
        '$[挖鼻]' => '<img src="' . get_bloginfo('template_url') . '/emoji/paopao/挖鼻@2x.png" alt="挖鼻" class="OwO-img">',
        '$[委屈]' => '<img src="' . get_bloginfo('template_url') . '/emoji/paopao/委屈@2x.png" alt="委屈" class="OwO-img">',
        '$[捂嘴笑]' => '<img src="' . get_bloginfo('template_url') . '/emoji/paopao/捂嘴笑@2x.png" alt="捂嘴笑" class="OwO-img">',
        '$[犀利]' => '<img src="' . get_bloginfo('template_url') . '/emoji/paopao/犀利@2x.png" alt="犀利" class="OwO-img">',
        '$[香蕉]' => '<img src="' . get_bloginfo('template_url') . '/emoji/paopao/香蕉@2x.png" alt="香蕉" class="OwO-img">',
        '$[小乖]' => '<img src="' . get_bloginfo('template_url') . '/emoji/paopao/小乖@2x.png" alt="小乖" class="OwO-img">',
        '$[小红脸]' => '<img src="' . get_bloginfo('template_url') . '/emoji/paopao/小红脸@2x.png" alt="小红脸" class="OwO-img">',
        '$[笑尿]' => '<img src="' . get_bloginfo('template_url') . '/emoji/paopao/笑尿@2x.png" alt="笑尿" class="OwO-img">',
        '$[笑眼]' => '<img src="' . get_bloginfo('template_url') . '/emoji/paopao/笑眼@2x.png" alt="笑眼" class="OwO-img">',
        '$[心碎]' => '<img src="' . get_bloginfo('template_url') . '/emoji/paopao/心碎@2x.png" alt="心碎" class="OwO-img">',
        '$[星星月亮]' => '<img src="' . get_bloginfo('template_url') . '/emoji/paopao/星星月亮@2x.png" alt="星星月亮" class="OwO-img">',
        '$[呀咩爹]' => '<img src="' . get_bloginfo('template_url') . '/emoji/paopao/呀咩爹@2x.png" alt="呀咩爹" class="OwO-img">',
        '$[药丸]' => '<img src="' . get_bloginfo('template_url') . '/emoji/paopao/药丸@2x.png" alt="药丸" class="OwO-img">',
        '$[咦]' => '<img src="' . get_bloginfo('template_url') . '/emoji/paopao/咦@2x.png" alt="咦" class="OwO-img">',
        '$[疑问]' => '<img src="' . get_bloginfo('template_url') . '/emoji/paopao/疑问@2x.png" alt="疑问" class="OwO-img">',
        '$[阴险]' => '<img src="' . get_bloginfo('template_url') . '/emoji/paopao/阴险@2x.png" alt="阴险" class="OwO-img">',
        '$[音乐]' => '<img src="' . get_bloginfo('template_url') . '/emoji/paopao/音乐@2x.png" alt="音乐" class="OwO-img">',
        '$[真棒]' => '<img src="' . get_bloginfo('template_url') . '/emoji/paopao/真棒@2x.png" alt="真棒" class="OwO-img">',
        '$[nico]' => '<img src="' . get_bloginfo('template_url') . '/emoji/paopao/nico@2x.png" alt="nico" class="OwO-img">',
        '$[OK]' => '<img src="' . get_bloginfo('template_url') . '/emoji/paopao/OK@2x.png" alt="OK" class="OwO-img">',
        '$[what]' => '<img src="' . get_bloginfo('template_url') . '/emoji/paopao/what@2x.png" alt="what" class="OwO-img">'
    );
    return strtr($comment_text, $data_OwO);
}
function comment_add_at($comment_text, $comment = '')
{
    if ($comment->comment_parent > 0) {
        $comment_text = '<a href="#comment-' . $comment->comment_parent . '" title="' . get_comment_author($comment->comment_parent) . '" class="at"> @ ' . get_comment_author($comment->comment_parent) . '</a> ' . $comment_text;
    }
    return $comment_text;
}
add_filter('comment_text', 'comment_add_owo', 20, 2);
add_filter('comment_text', 'comment_add_at', 20, 2);
add_filter('get_comment_text', 'comment_add_owo', 20, 2);


// 验证码功能
function Memory_protection_math()
{
    //获取两个随机数, 范围0~9
    $num1 = rand(0, 9);
    $num2 = rand(0, 9);
    //最终网页中的具体内容
    echo "<input type='text' name='sum' class='text-input sum' id='comment-validate' value='' placeholder='$num1 + $num2 = ?'>" . "<input type='hidden' name='num1' value='$num1'>" . "<input type='hidden' name='num2' value='$num2'>";
}
function Memory_protection_pre($commentdata)
{
    $sum = $_POST['sum']; //用户提交的计算结果
    switch ($sum) {
            //得到正确的计算结果则直接跳出
        case $_POST['num1'] + $_POST['num2']:
            break;
            //未填写结果时的错误讯息
        case null:
            err('错误: 请输入验证码.');
            break;
            //计算错误时的错误讯息
        default:
            err('错误: 请输入正确的验证码.');
    }
    return $commentdata;
}

// ajax评论
add_action('wp_ajax_nopriv_ajax_comment', 'ajax_comment_callback');
add_action('wp_ajax_ajax_comment', 'ajax_comment_callback');
function ajax_comment_callback()
{
    global $wpdb;
    $comment_post_ID = isset($_POST['comment_post_ID']) ? (int) $_POST['comment_post_ID'] : 0;
    $post = get_post($comment_post_ID);
    $post_author = $post->post_author;
    $sum = $_POST['sum']; //用户提交的计算结果
    switch ($sum) {
            //得到正确的计算结果则直接跳出
        case $_POST['num1'] + $_POST['num2']:
            break;
            //未填写结果时的错误讯息
        case null:
            ajax_comment_err('验证码错误: 请输入验证码！');
            break;
            //计算错误时的错误讯息
        default:
            ajax_comment_err('验证码错误: 请输入正确的验证码！');
    }
    if (empty($post->comment_status)) {
        do_action('comment_id_not_found', $comment_post_ID);
        ajax_comment_err('无效评论！请重新提交！');
    }
    $status = get_post_status($post);
    $status_obj = get_post_status_object($status);
    if (!comments_open($comment_post_ID)) {
        do_action('comment_closed', $comment_post_ID);
        ajax_comment_err('抱歉，此页面评论模块已关闭！');
    } elseif ('trash' == $status) {
        do_action('comment_on_trash', $comment_post_ID);
        ajax_comment_err('无效评论！请重新提交！');
    } elseif (!$status_obj->public && !$status_obj->private) {
        do_action('comment_on_draft', $comment_post_ID);
        ajax_comment_err('无效评论！请重新提交！');
    } elseif (post_password_required($comment_post_ID)) {
        do_action('comment_on_password_protected', $comment_post_ID);
        ajax_comment_err('评论受到密码保护！');
    } else {
        do_action('pre_comment_on_post', $comment_post_ID);
    }
    $comment_author       = (isset($_POST['author']))  ? trim(strip_tags($_POST['author'])) : null;
    $comment_author_email = (isset($_POST['email']))   ? trim($_POST['email']) : null;
    $comment_author_url   = (isset($_POST['url']))     ? trim($_POST['url']) : null;
    $comment_content      = (isset($_POST['comment'])) ? trim($_POST['comment']) : null;
    $edit_id              = (isset($_POST['edit_id'])) ? $_POST['edit_id'] : null; // 提取 edit_id
    $user = wp_get_current_user();
    if ($user->exists()) {
        if (empty($user->display_name))
            $user->display_name = $user->user_login;
        $comment_author       = esc_sql($user->display_name);
        $comment_author_email = esc_sql($user->user_email);
        $comment_author_url   = esc_sql($user->user_url);
        $user_ID              = esc_sql($user->ID);
        if (current_user_can('unfiltered_html')) {
            if (wp_create_nonce('unfiltered-html-comment_' . $comment_post_ID) != $_POST['_wp_unfiltered_html_comment']) {
                kses_remove_filters();
                kses_init_filters();
            }
        }
    } else {
        if (get_option('comment_registration') || 'private' == $status)
            ajax_comment_err('抱歉，你必须登录来发表评论！');
    }
    $comment_type = '';
    if (get_option('require_name_email') && !$user->exists()) {
        if (6 > strlen($comment_author_email) || '' == $comment_author)
            ajax_comment_err('请填好姓名和邮箱再提交评论！');
        elseif (!is_email($comment_author_email))
            ajax_comment_err('请输入合法的邮箱！');
    }
    if ('' == $comment_content)
        ajax_comment_err('请输入评论内容！');
    $dupe = "SELECT comment_ID FROM $wpdb->comments WHERE comment_post_ID = '$comment_post_ID' AND ( comment_author = '$comment_author' ";
    if ($comment_author_email) $dupe .= "OR comment_author_email = '$comment_author_email' ";
    $dupe .= ") AND comment_content = '$comment_content' LIMIT 1";
    if ($wpdb->get_var($dupe)) {
        ajax_comment_err('检测到重复评论！你是不是已经评论了该内容？');
    }
    if ($lasttime = $wpdb->get_var($wpdb->prepare("SELECT comment_date_gmt FROM $wpdb->comments WHERE comment_author = %s ORDER BY comment_date DESC LIMIT 1", $comment_author))) {
        $time_lastcomment = mysql2date('U', $lasttime, false);
        $time_newcomment  = mysql2date('U', current_time('mysql', 1), false);
        $flood_die = apply_filters('comment_flood_filter', false, $time_lastcomment, $time_newcomment);
        if ($flood_die) {
            ajax_comment_err('评论提交过快，请稍后！');
        }
    }
    $comment_parent = isset($_POST['comment_parent']) ? absint($_POST['comment_parent']) : 0;
    $commentdata = compact('comment_post_ID', 'comment_author', 'comment_author_email', 'comment_author_url', 'comment_content', 'comment_type', 'comment_parent', 'user_ID');
    if ($edit_id) {
        $comment_id = $commentdata['comment_ID'] = $edit_id;
        if (ihacklog_user_can_edit_comment($commentdata, $comment_id)) {
            wp_update_comment($commentdata);
        } else {
            ajax_comment_err('请别干坏事哦~');
        }
    } else {
        $comment_id = wp_new_comment($commentdata);
    }
    $comment = get_comment($comment_id);
    do_action('set_comment_cookies', $comment, $user);
    $comment_depth = 1;
    $tmp_c = $comment;
    while ($tmp_c->comment_parent != 0) {
        $comment_depth++;
        $tmp_c = get_comment($tmp_c->comment_parent);
    }
    $GLOBALS['comment'] = $comment;
    //以下修改成你的评论结构，直接复制评论回调函数内的全部内容过来
        ?>
        <li class="comment-item" id="li-comment-<?php comment_ID(); ?>">
            <div class="commentator-avatar">
                <?php if (function_exists('get_avatar') && get_option('show_avatars')) {
                    if (get_comment_author_url() != null) { ?>
                        <a href="<?php echo get_comment_author_url(); ?>" target="_blank">
                        <?php }
                    echo get_avatar($comment, 48);
                    if (get_comment_author_url() != null) { ?>
                        </a>
                <?php }
                }
                ?>
            </div>
            <div class="commentator-comment" id="comment-<?php comment_ID(); ?>"><span class="commentator-name"><?php printf(__('<span class="author-name">%s</span> '), get_comment_author_link());
                                                                                                                if ($comment->user_id == '1') { ?><i class="memory memory-certify"></i><?php } ?></span> <?php echo get_author_class($comment->comment_author_email, $comment->user_id); ?>
                           <div class="comment-chat">
                    <div class="comment-comment">
                        <?php if ($comment->comment_approved == '0') : ?><p>你的评论正在审核，稍后会显示出来！</p><?php endif; ?>
                        <?php comment_text(); ?>
                        <div class="comment-info">
                            <span class="comment-time"><?php echo human_time_diff(get_comment_date('U', $comment->comment_ID), current_time('timestamp')) . '前'; ?></span>
                            <?php if ($comment->comment_approved == '1') {
                                comment_reply_link(array_merge($args, array('reply_text' => '回复', 'depth' => $depth, 'max_depth' => $args['max_depth'])));
                            } ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        // 回调函数结束
        die();
    }
    function ajax_comment_err($a)
    {
        header('HTTP/1.0 500 Internal Server Error');
        header('Content-Type: text/plain;charset=UTF-8');
        echo $a;
        exit;
    }
    function ihacklog_user_can_edit_comment($new_cmt_data, $comment_ID = 0)
    {
        if (current_user_can('edit_comment', $comment_ID)) {
            return true;
        }
        $comment = get_comment($comment_ID);
        $old_timestamp = strtotime($comment->comment_date);
        $new_timestamp = current_time('timestamp');
        // 不用get_comment_author_email($comment_ID) , get_comment_author_IP($comment_ID)
        $rs = $comment->comment_author_email === $new_cmt_data['comment_author_email']
            && $comment->comment_author_IP === $_SERVER['REMOTE_ADDR']
            && $new_timestamp - $old_timestamp < 3600;
        return $rs;
    }

    // 自定义addComment
    function Memory_disable_comment_js()
    {
        wp_deregister_script('comment-reply');
    }
    add_action('init', 'Memory_disable_comment_js');

    function wp_pagenavi()
    {
        global $wp_query, $wp_rewrite;
        $wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;

        $pagination = array(
            'base' => @add_query_arg('paged', '%#%'),
            'format' => '',
            'total' => $wp_query->max_num_pages,
            'current' => $current,
            'show_all' => false,
            'type' => 'plain',
            'end_size' => '1',
            'mid_size' => '3',
            'prev_text' => 'Prev',
            'next_text' => 'Next'
        );

        if ($wp_rewrite->using_permalinks())
            $pagination['base'] = user_trailingslashit(trailingslashit(remove_query_arg('s', get_pagenum_link(1))) . 'page/%#%/', 'paged');
        if (!empty($wp_query->query_vars['s']))
            $pagination['add_args'] = array('s' => get_query_var('s'));
        echo paginate_links($pagination);
    }


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
