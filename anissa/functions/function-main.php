<?php
/**
 * anissa functions and definitions
 *
 * @package anissa
 */

if ( ! function_exists( 'anissa_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function anissa_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on anissa, use a find and replace
	 * to change 'anissa' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'anissa', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	add_theme_support( 'custom-logo', array(
		'height'      => 300,
		'width'       => 600,
		'flex-height' => true,
		'flex-width'  => true,
		'header-text' => array( 'site-title', 'site-description' ),
		) );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	// add_theme_support( 'post-thumbnails' );
	// add_image_size( 'anissa-home', 900, 450, true );
	// add_image_size( 'anissa-header', 1400, 400, true );
	// add_image_size( 'anissa-carousel-pic', 480, 320, true ); 

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'anissa' ),
		'social'  => esc_html__( 'Social Links', 'anissa' ),
		) );
	
	
	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
		) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'anissa_custom_background_args', array(
		'default-color' => 'ffffff',
		) ) );
	
	
}
endif; // anissa_setup
add_action( 'after_setup_theme', 'anissa_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function anissa_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'anissa_content_width', 900 );
}
add_action( 'after_setup_theme', 'anissa_content_width', 0 );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function anissa_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'anissa' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
		) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Sidebar 1', 'anissa' ),
		'id'            => 'footer-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
		) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Sidebar 2', 'anissa' ),
		'id'            => 'footer-2',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
		) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Sidebar 3', 'anissa' ),
		'id'            => 'footer-3',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
		) );
}
add_action( 'widgets_init', 'anissa_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function anissa_scripts() {
	wp_enqueue_style( 'anissa-style', get_stylesheet_uri() );

	wp_enqueue_style( 'anissa-fonts', anissa_fonts_url(), array(), null );
	wp_enqueue_style( 'anissa-fontawesome', get_template_directory_uri() . '/fonts/font-awesome.css', array(), '4.3.0' );
	

	wp_enqueue_script( 'anissa-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'anissa_scripts' );



function anissa_carousel_scripts() {
//    wp_enqueue_script( 'owl.carousel', get_template_directory_uri() . '/js/owl.carousel.js', array('jquery'), '20120206', true );
    // wp_enqueue_script( 'anissa-effects', get_template_directory_uri() . '/js/effects.js', array('jquery'), '20120206', true );
}
add_action( 'wp_enqueue_scripts', 'anissa_carousel_scripts' );

/**
 * Register Google Fonts
 */
function anissa_fonts_url() {
	$fonts_url = '';

   	/* Translators: If there are characters in your language that are not
	 * supported by Playfair, translate this to 'off'. Do not translate
	 * into your own language.
	 */
   	$playfair = esc_html_x( 'on', 'Playfair font: on or off', 'anissa' );

	/* Translators: If there are characters in your language that are not
	 * supported by Montserrat, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$montserrat = esc_html_x( 'on', 'Montserrat font: on or off', 'anissa' );
	
	 /* Translators: If there are characters in your language that are not
	 * supported by Merriweather, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	 $merriweather = esc_html_x( 'on', 'Merriweather font: on or off', 'anissa' );


	 if ( 'off' !== $playfair && 'off' !== $montserrat && 'off' !== $merriweather ) {
	 	$font_families = array();

	 	if ( 'off' !== $playfair ) {
	 		$font_families[] = 'Playfair Display:400,700';
	 	}

	 	if ( 'off' !== $montserrat ) {
	 		$font_families[] = 'Montserrat:400,700';
	 	}

	 	if ( 'off' !== $merriweather ) {
	 		$font_families[] = 'Merriweather:400,300,700';
	 	}

	 	// $query_args = array(
	 	// 	'family' => urlencode( implode( '|', $font_families ) ),
	 	// 	'subset' => urlencode( 'latin,latin-ext' ),
	 	// 	);

	 	// $fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );
	 }

	 return $fonts_url;

	}

/**
 * Enqueue Google Fonts for custom headers
 */
function anissa_admin_scripts( $hook_suffix ) {

	wp_enqueue_style( 'anissa-fonts', anissa_fonts_url(), array(), null );

}
add_action( 'admin_print_styles-appearance_page_custom-header', 'anissa_admin_scripts' );

// if ( ! function_exists( 'anissa_continue_reading_link' ) ) :
// /**
//  * Returns an ellipsis and "Continue reading" plus off-screen title link for excerpts
//  */
// function anissa_continue_reading_link() {
// 	return '&hellip; <div class="flex-hr-vc"><button class="expand-btn kl-btn kl-btn-primary kl-btn-sm gradient-blue-red" data-link ='. esc_url( get_permalink() ) . '">' . sprintf( __( '展开更多 <span class="screen-reader-text">%1$s</span>', 'anissa' ), esc_attr( strip_tags( get_the_title() ) ) ) . '</button></div>';
// }
// endif; // anissa_continue_reading_link


// /**
//  * Replaces "[...]" (appended to automatically generated excerpts) with anissa_continue_reading_link().
//  *
//  * To override this in a child theme, remove the filter and add your own
//  * function tied to the excerpt_more filter hook.
//  */
// function anissa_auto_excerpt_more( $more ) {
// 	return anissa_continue_reading_link();
// }
// add_filter( 'excerpt_more', 'anissa_auto_excerpt_more' );


// /**
//  * Adds a pretty "Continue Reading" link to custom post excerpts.
//  *
//  * To override this link in a child theme, remove the filter and add your own
//  * function tied to the get_the_excerpt filter hook.
//  */
// function anissa_custom_excerpt_more( $output ) {
// 	if ( has_excerpt() && ! is_attachment() ) {
// 		$output .= anissa_continue_reading_link();
// 	}
// 	return $output;
// }
// add_filter( 'get_the_excerpt', 'anissa_custom_excerpt_more' );




// Style the Tag Cloud
function anissa_tag_cloud_widget( $args )
{
	$args['largest'] = 12; //largest tag
	$args['smallest'] = 12; //smallest tag
	$args['unit'] = 'px'; //tag font unit
	$args['number'] = '18'; //number of tags
	return $args;
}

add_filter( 'widget_tag_cloud_args', 'anissa_tag_cloud_widget' );

// Declare WooCommerce Support
add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
	add_theme_support( 'woocommerce' );
}

if ( ! function_exists( 'anissa_comments' ) ) :

/*
 * Custom comments display to move Reply link,
 * used in comments.php
 */
function anissa_comments( $comment, $args, $depth ) {
	?>
	<li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
		<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
			<div class="comment-meta">
				<div class="comment-author vcard flex-hl-vc">
					<?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, '60' ); ?>
					<div class="comment-metadata flex-hb-vc flex-hw">
						<div class="flex-v">
							<!-- 评论者 -->
							<div>
							<b class="fn mr-5"><?php printf( '%s', get_comment_author_link() ); ?></b>	
							<?php if ($comment->user_id == '1') { echo '<span class="vip level_Max">博主</span>'; }else{ echo get_author_class($comment->comment_author_email,$comment->user_id); } ?>
							</div>
							<!-- 评论时间 -->
							<div>
							<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID, $args ) ); ?>">
								<time datetime="<?php comment_time( 'c' ); ?>">
									<?php printf( esc_html_x( '%1$s at %2$s', '1: date, 2: time', 'anissa' ), get_comment_date(), get_comment_time() ); ?>
								</time>
							</a>
							</div>
						</div>
						<div class="flex-hc-vc">
							<!-- 编辑评论 -->
							<?php 
								if(isAdmin()){
									edit_comment_link( _e('<span class="edit-link flex-hc-vc"><i class="lalaksks lalaksks-ic-edit"></i>', '</span>' )); 
								}
							?>							
							<!-- 回复评论 -->
							<?php
							comment_reply_link( array_merge( $args, array(
								'add_below' => 'div-comment',
								'depth'     => $depth,
								'max_depth' => $args['max_depth'],
								'before'    => '<span class="reply flex-hc-vc ml-10"><i class="lalaksks lalaksks-ic-reply"></i>',
								'after'     => '</span>'
								) ) );
							?>
						</div>
					</div><!-- .comment-metadata -->
				</div><!-- .comment-author -->



				<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'anissa' ); ?></p>
			<?php endif; ?>
		</div><!-- .comment-meta -->

		<div class="comment-content">
			<?php comment_text(); ?>
		</div><!-- .comment-content -->

	</article><!-- .comment-body -->
	<?php
}

endif;

/**
 * Implement the Custom Header feature.
 */
// require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */

require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
// require get_template_directory() . '/inc/jetpack.php';


function normal_style_script() { 
	wp_enqueue_script( 'anissa-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );
	// layui.css
	wp_enqueue_style( 'layuiCss', get_template_directory_uri() . '/frameworks/layui/css/layui.css', array(), '1.0', false );
	// 自定义样式
	wp_enqueue_style( 'direction', get_template_directory_uri() . '/css/direction.css', array(), '1.0', false );
	// 媒体查询样式
	wp_enqueue_style( 'mediaCss', get_template_directory_uri() . '/css/media.css', array(), '1.0', false );
	// 动画库样式
    wp_enqueue_style( 'animate', get_template_directory_uri() . '/css/animate.min.css', array(), '3.5.1', false ); 
    // vue.js   
	wp_enqueue_script( 'vue', get_template_directory_uri() . '/js/vue.js', array(), '2.5.17', false );
} 


function footer_script(){
	wp_enqueue_script( 'layui', get_template_directory_uri() . '/frameworks/layui/layui.js', array(), 'lastet', false );	
	wp_enqueue_script( 'common_func', get_template_directory_uri() . '/js/common.js', array(), '1.0', false );
	wp_enqueue_script( 'fixed-plugins', get_template_directory_uri() . '/js/fixed-plugins.js', array(), '1.0', false );
	wp_enqueue_script( 'snow', get_template_directory_uri() . '/js/snow.js', array(), '1.0', false );
	wp_localize_script( 'canvas', 'my_ajax_obj', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) ); 
	// 先将ajaxurl变数设定好
}

function custom_login() {
    echo '<link rel="stylesheet" type="text/css" href="' . get_bloginfo('template_directory') . '/css/login.css" />';
}


function my_styles_scripts() {
    if( ! is_admin() ) { // 前台加载的脚本与样式表
        // 去除已注册的 jquery 脚本
        wp_deregister_script( 'jquery' );
        // 注册 jquery 脚本
        wp_register_script( 'jquery', '//code.jquery.com/jquery.min.js', array(), 'lastest', false );
        // 提交加载 jquery 脚本
		wp_enqueue_script( 'jquery' );
		if( is_mobile() == true ){
			wp_enqueue_script( 'util', get_template_directory_uri() . '/js/util.js', array(), 'lastet', false );
		}

    } else { // 后台加载的脚本与样式表
        // 取消加载 jquery 脚本
        wp_dequeue_script( 'jquery' );
        // 注册并加载 jquery 脚本
        wp_enqueue_script( 'jquery', '//code.jquery.com/jquery.min.js', array(), 'lastest', false );
    }
}
// 添加回调函数到 init 动作上
add_action('init', 'my_styles_scripts');
add_action('wp_footer', 'footer_script'); 
add_action('wp_enqueue_scripts', 'normal_style_script'); 
add_action('login_head', 'custom_login');


//自定义登录页面的LOGO图片
function my_custom_login_logo() {
    echo '<style type="text/css">
        .login h1 a {
			background-image:url("'. get_template_directory_uri() . '/img/bg-test.jpg'.'") !important;
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
function list_rec_callback() {
  // 读取POST资料

 
  global $wpdb; //可以拿POST来的资料作为条件，捞DB的资料来作显示
  echo the_content();
  die(); // this is required to return a proper result
}

function load_post() { 
	// 如果 action ID 是 load_post, 并且传入的必须参数存在, 则执行响应方法 
	if($_GET['action'] == 'load_post' && $_GET['id'] != '') { 
		$id = $_GET["id"]; $output = ''; 
		// 获取文章对象 
		global $wpdb, $post; $post = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE ID = %d LIMIT 1", $id)
	); 
	// 如果指定 ID 的文章存在, 则对他进行格式化 
	if($post) { $content = $post->post_content; $output = balanceTags($content); $output = wpautop($output); } 
		// 打印文章内容并中断后面的处理 
		echo $output;
		die(); 
	} 
} 

// 清除无用资源
remove_action( 'wp_head', 'feed_links_extra', 3 ); //去除评论feed
remove_action( 'wp_head', 'feed_links', 2 ); //去除文章feed
remove_action( 'wp_head', 'rsd_link' ); //针对Blog的远程离线编辑器接口
remove_action( 'wp_head', 'wlwmanifest_link' ); //Windows Live Writer接口
remove_action( 'wp_head', 'index_rel_link' ); //移除当前页面的索引
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 ); //移除后面文章的url
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 ); //移除最开始文章的url
remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );//自动生成的短链接
remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 ); ///移除相邻文章的url
remove_action( 'wp_head', 'wp_generator' ); // 移除版本号
unregister_widget('WP_Widget_RSS');


// Remove Open Sans that WP adds from frontend   
if (!function_exists('remove_wp_open_sans')) :   
	function remove_wp_open_sans() {   
		wp_deregister_style( 'open-sans' );   
		wp_register_style( 'open-sans', false );   
	}
// 前台删除Google字体CSS   
	add_action('wp_enqueue_scripts', 'remove_wp_open_sans');
// 后台删除Google字体CSS   
	add_action('admin_enqueue_scripts', 'remove_wp_open_sans'); 
	endif;


// 评论添加@ 
add_filter( 'get_comment_text' , 'comment_add_at', 20, 2); // 添加过滤器，加入以下值
function comment_add_at( $get_comment_text, $comment = '') {
  if( $comment->comment_parent > 0) {
    $get_comment_text = '<a class="col-gray at-reply mr-5" href="#comment-' . $comment->comment_parent . '">@'.get_comment_author( $comment->comment_parent ) . '</a>' . $get_comment_text;
  }
  return $get_comment_text; // 返回添加@的函数,名称不能自定义
}

// 判断当前用户是否管理员
function isAdmin() {
  // wp_get_current_user函数仅限在主题的functions.php中使用
  $currentUser = wp_get_current_user();

  if(!empty($currentUser->roles) && in_array('administrator', $currentUser->roles)) 
    return 1;  // 是管理员
  else
    return 0;  // 非管理员
}

/// 函数名称：getPostViews & setPostViews
/// 函数作用：获取和反映文章点击数
function getPostViews($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count=='' ){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0 View";
    }
    return $count;
}
function setPostViews($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
		if(isAdmin() !=1){
 			$count++;
		}       
        update_post_meta($postID, $count_key, $count);
    }
}


/// 函数名称：wpb_new_gravatar
/// 函数作用：设置默认头像
add_filter( 'avatar_defaults', 'wpb_new_gravatar' );
function wpb_new_gravatar ($avatar_defaults) {
	$myavatar = '//en.gravatar.com/userimage/125992477/fcde332c16644204fc0be461a5b36857?size=80';
	$avatar_defaults[$myavatar] = "默认头像";
	return $avatar_defaults;
}

function getGravatar( $email, $s = 96, $d = 'mp', $r = 'g', $img = false, $atts = array() ) {
    $url = '//www.gravatar.com/avatar/';
    $url .= md5( strtolower( trim( $email ) ) );
    $url .= "?s=$s&d=$d&r=$r";
    if ( $img ) {
        $url = '<img src="' . $url . '"';
        foreach ( $atts as $key => $val )
            $url .= ' ' . $key . '="' . $val . '"';
        $url .= ' />';
    }
    return $url;
}


// 判断是否移动端
function is_mobile() {
	$user_agent = $_SERVER['HTTP_USER_AGENT'];
	$mobile_browser = Array(
		"mqqbrowser", //手机QQ浏览器
		"opera mobi", //手机opera
		"juc","iuc",//uc浏览器
		"fennec","ios","applewebKit/420","applewebkit/525","applewebkit/532","ipad","iphone","ipaq","ipod",
		"iemobile", "windows ce",//windows phone
		"240x320","480x640","acer","android","anywhereyougo.com","asus","audio","blackberry","blazer","coolpad" ,"dopod", "etouch", "hitachi","htc","huawei", "jbrowser", "lenovo","lg","lg-","lge-","lge", "mobi","moto","nokia","phone","samsung","sony","symbian","tablet","tianyu","wap","xda","xde","zte"
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

function is_icon($id,$name) { 
	switch ($name) {
		case "date":
		$dom = '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark"><i class="lalaksks lalaksks-ic-'. $name .'"></i>' .get_the_time( get_option( 'date_format' ) ). '</a>';
		break;
		case "category":
		$dom = '<span><i class="lalaksks lalaksks-ic-'. $name .'"></i>' . get_the_category_list(' ') . ' </span>' ;
		break;
		case "tag":
		$dom = '<span><i class="lalaksks lalaksks-ic-'. $name .'"></i>' . get_the_tag_list(' '). ' </span>' ;
		break;
		case "view":
		$dom = '<span><i class="lalaksks lalaksks-ic-'. $name .'"></i>' . getPostViews(get_the_ID()) . ' </span>' ;
		break;
		case "reply":
		$dom = '<a href="'. esc_url( get_permalink() ) .'#comments" rel="bookmark"><i class="lalaksks lalaksks-ic-'. $name .'"></i>'. get_comments_number() .'</a>';
		break;
		case "author":
		$dom = '<a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '"><i class="lalaksks lalaksks-ic-'. $name .'"></i>' . esc_html( get_the_author() ) . '</a></span>';		
		break;
		default:
		echo "No Icon";
	}
	if( $dom != ""){
		echo $dom;
	} 
}

// 前台隐藏工具条
if ( !is_admin() ) {
    add_filter('show_admin_bar', '__return_false');
}


// 开启特色图并设置默认大小
add_theme_support ( 'post-thumbnails' );
set_post_thumbnail_size ( 160 );

function autoset_featured() {
    global $post;
    $already_has_thumb = has_post_thumbnail($post->ID);
        if (!$already_has_thumb)  {
        $attached_image = get_children( "post_parent=$post->ID&post_type=attachment&post_mime_type=image&numberposts=1" );
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
function get_author_class($comment_author_email, $user_id){
    global $wpdb;
    $author_count = count($wpdb->get_results(
    "SELECT comment_ID as author_count FROM $wpdb->comments WHERE comment_author_email = '$comment_author_email' "));
    if($author_count>=1 && $author_count<= 10 )//数字可自行修改，代表评论次数。
        echo '<span class="vip level_1">LV.1</span>';
    else if($author_count>=11 && $author_count<= 20)
        echo '<span class="vip level_2">LV.2</span>';
    else if($author_count>=21 && $author_count<= 40)
        echo '<span class="vip level_3">LV.3</span>';
    else if($author_count>=41 && $author_count<= 80)
        echo '<span class="vip level_4">LV.4</span>';
    else if($author_count>=81 && $author_count<= 160)
        echo '<span class="vip level_5">LV.5</span>';
    else if($author_count>=161 && $author_count<= 320)
        echo '<span class="vip level_6">LV.6</span>';
    else if($author_count>=321)
        echo '<span class="vip level_7">LV.7</span>';
}

// 根据设备类型自定义文章摘要长度
function custom_excerpt_length( $length ){
	if(!is_mobile()){
		return 120;
	} else if(is_mobile()){
		return 30;
	}
}
add_filter( 'excerpt_length', 'custom_excerpt_length');


// 邮件发送模块
function mail_smtp( $phpmailer ){
	$phpmailer->From = "xing930629@163.com"; //发件人
	$phpmailer->FromName = "测试";   //发件人昵称
	$phpmailer->Host = "smtp.163.com"; //SMTP服务器地址(比如QQ是smtp.qq.com,腾讯企业邮箱是smtp.exmail.qq.com,阿里云是smtp.域名,其他自行咨询邮件服务商)
	$phpmailer->Port = 465;    //SMTP端口，常用的有25、465、587，SSL加密连接端口：465或587,qq是25,qq企业邮箱是465
	$phpmailer->SMTPSecure = "SSL"; //SMTP加密方式，常用的有ssl/tls,一般25端口不填，端口465天ssl
	$phpmailer->Username = "xing930629@qq.com";  //邮箱帐号，一般和发件人相同
	$phpmailer->Password = 'xurvgirfzblvcbbi';  //邮箱授权码
	$phpmailer->IsSMTP(); //使用SMTP发送
	$phpmailer->SMTPAuth = true; //启用SMTPAuth服务
}
add_action('phpmailer_init','mail_smtp');


/* 删除文章时删除图片附件
/* ------------------------ */
function delete_post_and_attachments($post_ID) {
	global $wpdb;
	//删除特色图片
	$thumbnails = $wpdb->get_results( "SELECT * FROM $wpdb->postmeta WHERE meta_key = '_thumbnail_id' AND post_id = $post_ID" );  
	foreach ( $thumbnails as $thumbnail ) {
    	wp_delete_attachment( $thumbnail->meta_value, true );  
	}
	//删除图片附件
	$attachments = $wpdb->get_results( "SELECT * FROM $wpdb->posts WHERE post_parent = $post_ID AND post_type = 'attachment'" );
	foreach ( $attachments as $attachment ) {
    	wp_delete_attachment( $attachment->ID, true );  
	}  
	$wpdb->query( "DELETE FROM $wpdb->postmeta WHERE meta_key = '_thumbnail_id' AND post_id = $post_ID" ); 
}
add_action('before_delete_post', 'delete_post_and_attachments');


//预览全文功能
function preview_post(){
    global $wpdb,$post;
    $id = $_POST["um_id"];
	$action = $_POST["um_action"];
  
	// 获取文章对象
	global $wpdb, $post;
	$post = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE ID = %d LIMIT 1", $id));
	
	// 如果指定 ID 的文章存在, 则对他进行格式化
	if($post) {
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
function svg_upload_mimes($mimes = array()) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}


//点赞功能
function inlo_like(){
    global $wpdb,$post;
    $id = $_POST["um_id"];
    $action = $_POST["um_action"];
    if ( $action == 'ding'){
    $inlo_raters = get_post_meta($id,'inlo_ding',true);
    $expire = time() + 99999999;
    $domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false; // make cookies work with localhost
    setcookie('inlo_ding_'.$id,$id,$expire,'/',$domain,false);
    if (!$inlo_raters || !is_numeric($inlo_raters)) {
        update_post_meta($id, 'inlo_ding', 1);
    } 
    else {
            update_post_meta($id, 'inlo_ding', ($inlo_raters + 1));
        }   
    echo get_post_meta($id,'inlo_ding',true);    
    }     
    die;
}

add_action('wp_ajax_nopriv_inlo_like', 'inlo_like');
add_action('wp_ajax_inlo_like', 'inlo_like');

//点赞最多文章
function get_like_most($mode = '', $limit = 10, $days = 7, $display = true) {
	global $wpdb, $post;
	$limit_date = current_time('timestamp') - ($days*86400);
	$limit_date = date("Y-m-d H:i:s",$limit_date);	
	$where = '';
	$temp = '';
	if(!empty($mode) && $mode != 'both') {
		$where = "post_type = '$mode'";
	} else {
		$where = '1=1';
	}
	$most_viewed = $wpdb->get_results("SELECT $wpdb->posts.*, (meta_value+0) AS md_like FROM $wpdb->posts LEFT JOIN $wpdb->postmeta ON $wpdb->postmeta.post_id = $wpdb->posts.ID WHERE post_date < '".current_time('mysql')."' AND post_date > '".$limit_date."' AND $where AND post_status = 'publish' AND meta_key = 'md_like' AND post_password = '' ORDER  BY md_like DESC LIMIT $limit");
	if($most_viewed) {
		$i = 1;
		foreach ($most_viewed as $post) {
			$post_title = get_the_title();
			$post_like = intval($post->like);
			$post_like = number_format($post_like);
			$temp .= "<li><span class='li-icon li-icon-$i'>$i</span><a href=\"".get_permalink()."\">$post_title</a></li>";
			$i++;
		}
	} else {
		$temp = '<li>暂无文章</li>';
	}
	if($display) {
		echo $temp;
	} else {
		return $temp;
	}
}



// 七牛CDN
if ( !is_admin() ) {
    add_action('wp_loaded','cdn_ob_start');
 
    function cdn_ob_start() {
        ob_start('qiniu_cdn_replace');
    }
 
    // 修改自七牛镜像存储 WordPress 插件
    function qiniu_cdn_replace($html){
        $local_host = 'https://www.klauslaura.com'; //博客域名
        $qiniu_host = 'https://cdn.klauslaura.com'; //七牛域名
        $cdn_exts   = 'png|jpg|jpeg|gif|ico|webp'; //扩展名（使用|分隔）
        $cdn_dirs   = 'wp-content|wp-includes'; //目录（使用|分隔）
 
        $cdn_dirs   = str_replace('-', '\-', $cdn_dirs);
 
        if ($cdn_dirs) {
            $regex  =  '/' . str_replace('/', '\/', $local_host) . '\/((' . $cdn_dirs . ')\/[^\s\?\\\'\"\;\>\<]{1,}.(' . $cdn_exts . '))([\"\\\'\s\?]{1})/';
            $html =  preg_replace($regex, $qiniu_host . '/$1$4', $html);
        } else {
            $regex  = '/' . str_replace('/', '\/', $local_host) . '\/([^\s\?\\\'\"\;\>\<]{1,}.(' . $cdn_exts . '))([\"\\\'\s\?]{1})/';
            $html =  preg_replace($regex, $qiniu_host . '/$1$3', $html);
        }
        return $html;
    }
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











