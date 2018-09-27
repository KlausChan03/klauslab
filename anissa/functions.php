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
	
	wp_enqueue_script( 'anissa-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

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
// 	return '&hellip; <div class="flex-hr-vc"><button class="expand-btn klaus-btn sm-btn gradient-blue-red" data-link ='. esc_url( get_permalink() ) . '">' . sprintf( __( '展开更多 <span class="screen-reader-text">%1$s</span>', 'anissa' ), esc_attr( strip_tags( get_the_title() ) ) ) . '</button></div>';
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
require get_template_directory() . '/inc/jetpack.php';


//引入付款二维码
function orwei_ds_alipay_wechat(){ //注意更换为你的支付宝或微信收款二维码，二维码获取请自行百度
	echo 
	'<section class="to-tip">
		<div class="inner">
			<div class="top-tip-shap" >
				<a>赏
					<span class="code">
						<div class="flex-hb-vc">
							<div class="flex-v flex-hc-vc">
								<img alt="" src="'. get_template_directory_uri() .'/img/pay_for_me_wechat.png">
								<b>微信 扫一扫</b>
							</div>
							<div class="flex-v flex-hc-vc">
								<img alt="" src="'. get_template_directory_uri() .'/img/pay_for_me_alipay.png">
								<b>支付宝 扫一扫</b>
							</div>
						</div>
					</span>
				</a>
			</div>
		</div>
	</section>';
}


function normal_style_script() { 
	// layui框架样式
	wp_enqueue_style( 'layuiCss', get_template_directory_uri() . '/frameworks/layui/css/layui.css', array(), '1.0', false );
	// 自定义样式
	wp_enqueue_style( 'direction', get_template_directory_uri() . '/css/direction.css', array(), '1.0', false );
	// 媒体查询样式
	wp_enqueue_style( 'mediaCss', get_template_directory_uri() . '/css/media.css', array(), '1.0', false );
	// 弹性布局样式
	wp_enqueue_style( 'flex', get_template_directory_uri() . '/css/flex.css', array(), '1.0', false );
	// 动画库样式
	wp_enqueue_style( 'animate', get_template_directory_uri() . '/css/animate.min.css', array(), '3.5.1', false );
	wp_enqueue_script( 'vue', get_template_directory_uri() . '/js/vue.js', array(), '2.5.17', false );
} 


function footer_script(){
	wp_enqueue_script( 'layui', get_template_directory_uri() . '/frameworks/layui/layui.js', array(), 'lastet', false );	
	wp_enqueue_script( 'common', get_template_directory_uri() . '/js/common.js', array(), '1.0', false );
	wp_enqueue_script( 'canvas', get_template_directory_uri() . '/js/canvas.js', array(), '1.0', false );
	wp_enqueue_script( 'fixed-plugins', get_template_directory_uri() . '/js/fixed-plugins.js', array(), '1.0', false );
	wp_localize_script( 'canvas', 'my_ajax_obj', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) ); // 先将ajaxurl变数设定好
}


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


//说说
add_action('init', 'my_custom_init');
function my_custom_init() { 
	$labels = array( 
		'name' => '说说',
		'singular_name' => '说说',
		'add_new' => '发表说说', 
		'add_new_item' => '发表说说', 
		'edit_item' => '编辑说说', 
		'new_item' => '新说说', 
		'view_item' => '查看说说', 
		'search_items' => '搜索说说', 
		'not_found' => '暂无说说', 
		'not_found_in_trash' => '没有已遗弃的说说', 
		'parent_item_colon' => '', 'menu_name' => '说说' 
	); 
	$args = array( 
		'labels' => $labels, 
		'public' => true, 
		'publicly_queryable' => true, 
		'show_ui' => true, 
		'show_in_menu' => true, 
		'query_var' => true, 'rewrite' => true, 
		'capability_type' => 'post', 
		'has_archive' => true, 
		'hierarchical' => false, 
		'menu_position' => null, 
		'supports' => array('title','editor','author') 
	); 
	register_post_type('shuoshuo',$args); 
}

//友情链接
function get_the_link_items($id = null){
    $bookmarks = get_bookmarks('orderby=date&category=' .$id );
    $output = '';
    if ( !empty($bookmarks) ) {
		
        $output .= '<ul class="link-items klaus-links">';
        foreach ($bookmarks as $bookmark) {

			$arr_col = array("qs","lvs","ls","zs","lh","hs","cs","hos");
			shuffle($arr_col);
			$arr_num = array("1","2");
			shuffle($arr_num);			
			
			$email = $bookmark->link_notes;
			// $imgUrl = '';
			if( $email != ''){
				$imgUrl = '<img src="'.getGravatar($email).'"></img>';
			}else{
				$imgUrl = get_avatar($email,64);
			}
			
            $output .=  '<li class="col-md-4 mt-15 mb-15 p-10"> <div class="p-0 borderr-main-4"> <div class="link-1 p-20 bgc-' . $arr_col[0] . $arr_num[0] . '"> <div class="col-md-12 p-0"> <strong><a title="'. $bookmark->link_name . '" href="' . $bookmark->link_url . '" target="_blank" class="w-100 f14 col-fff link-name">'. $bookmark->link_name .'</a></strong> <p class="f12 col-fff text-overflow">' . $bookmark->link_url . '</p> </div> </div> <div class="p-20 pt-10 pb-10 col-primary clearfix link-2"> <p class="col-aaa text-overflow">' . $bookmark->link_description . '</p> </div> <div class="link-3 p-20 pt-10 pb-20 col-primary flex-hb-vc"><span class=" col-aaa"><i class="yuaoicon icon-category"></i>&nbsp;友人链接</span> <span><a title="'. $bookmark->link_name .'" href="' . $bookmark->link_url . '" target="_blank" class="link-avatar f14 col-aaa"> '. $imgUrl . '</a> </span> </div> </div> </li>';
        }
        $output .= '</ul>';
    }
    return $output;
}

// 友链判断-二维数组经过判断赋值给另一二维数组
function bookmarks($rel){
    $bms = array();
    $bookmarks = get_bookmarks('hide_invisible=0'); // 这个也是二维数组
    if( $rel == 'nonhome'){ //若非首页
        foreach( $bookmarks as $bs ){
            if ( $bs->link_rel ==  'contact' ||  $bs->link_rel == 'acquaintance' ) { continue;} // 若是contact或acquaintance则终止循环输出，意思是排除这两类关系输出
                $bms[] = array( 'link_rel'=>$bs->link_rel,'link_visible'=>$bs->link_visible,'link_url'=>$bs->link_url,'link_description'=>$bs->link_description,'link_target'=>'','link_name'=>$bs->link_name);
        }
    }
    if( $rel == 'home'){ //若是首页
        foreach( $bookmarks as $bs ){
            if ( $bs->link_rel ==  'contact' )  { continue;} // 若是contact则终止循环输出，意思是排除这类关系输出
                $bms[] = array( 'link_rel'=>$bs->link_rel,'link_visible'=>$bs->link_visible,'link_url'=>$bs->link_url,'link_description'=>$bs->link_description,'link_target'=>'','link_name'=>$bs->link_name);
        }
    }
    return $bms; // 返回二维数组
}

function get_link_items(){
    $linkcats = get_terms( 'link_category' );
    if ( !empty($linkcats) ) {
        foreach( $linkcats as $linkcat){            
            $result .=  '<blockquote class="link-title">'.$linkcat->name.'</blockquote>';
            if( $linkcat->description ) $result .= '<div class="link-description">' . $linkcat->description . '</div>';
            $result .=  get_the_link_items($linkcat->term_id);
        }
    } else {
        $result = get_the_link_items();
    }
    return $result;
}

function shortcode_link(){
    return get_link_items();
}
add_shortcode('bigfalink', 'shortcode_link');

add_filter('pre_option_link_manager_enabled','__return_true');

// 2018-7-23 引入

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


// function hide_adminbar() {  
//     $hide_adminbar = '<script type="text/javascript">  
//         $(document).ready( function() {  
//             $("#wpadminbar").fadeTo( "slow", 0 );  
//             $("#wpadminbar").hover(function() {  
//                 $("#wpadminbar").fadeTo( "slow", 1 );  
//             }, function() {  
//                 $("#wpadminbar").fadeTo( "slow", 0 );  
//             });  
//         });  
//     </script>  
//     <style type="text/css">  
//         html { margin-top: -28px !important; }  
//         * html body { margin-top: -28px !important; }  
//         #wpadminbar {  
//             -ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";  
//             filter: alpha(opacity=0);  
//             -moz-opacity:0;  
//             -khtml-opacity:0;  
//             opacity:0;  
//         }  
//         #wpadminbar:hover, #wpadminbar:focus {  
//             -ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";  
//             filter: alpha(opacity=100);  
//             -moz-opacity:1;  
//             -khtml-opacity:1;  
//             opacity:1;  
//         }  
//     </style>';  
//     echo $hide_adminbar;  
// }  
// /* wp-admin area */  
// if ( is_admin() ) {  
//     add_action( 'admin_head', 'hide_adminbar' );  
// }  
// /* websites */  
// if ( !is_admin() ) {  
//     add_action( 'wp_head', 'hide_adminbar' );  
// }


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











