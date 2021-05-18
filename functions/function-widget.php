<?php

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

add_action('widgets_init', function(){register_widget("UserInfo");});
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
?>

	<div class="widget-user-container">
		<div class="user-bg"></div>
		<div class="user-main">
			<div class="user-avatar flex-hc-vc">
				<?php if (function_exists('get_avatar')) {
					echo get_avatar($current_user->user_email, 64);
				} ?>
			</div>
			<div class="user-default flex-v" style="padding-left: 90px; line-height: 1.5"> 
				<span class="fs-16"><?php echo($current_user->display_name); ?></span>
				<span><?php echo get_author_class_for_api($current_user->user_email); ?></span>
			</div>
			<div class="user-info-main flex-hb-vc">
					<?php global $user_ID;
					if (!$current_user->display_name && $user_ID === 0) : ?>
						<span> <?php echo ('游客，欢迎到此一游。'); ?> </span>
					<?php else : ?>
						<p class="flex-hc-vc flex-v"> <span><?php echo(count_user_posts($user_ID, 'post')); ?> 篇</span><span>文章</span></p>
						<span class="flex-hc-vc col-b2bbbe">/</span>
						<p class="flex-hc-vc flex-v"><span> <?php echo(count_user_posts($user_ID, 'shuoshuo')); ?> 篇</span><span>说说</span></p>
						<span class="flex-hc-vc col-b2bbbe">/</span>
						<p class="flex-hc-vc flex-v"><span> <?php echo(get_comments('count=true&user_id=' . $user_ID)); ?> 条</span><span>评论</span></p>
					<?php endif; ?>


			</div>
		</div>
	</div>

	<?php
}

add_action('widgets_init', function(){register_widget("NewVersionTips");});
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
		echo '<h1 class="widget-title">'.$instance['title'].'</h1>';
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



add_action('widgets_init', function(){register_widget("AuthorInfo");});
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
				<p id="lovetime" class="flex-hc-vc mb-5"></p>
				<p id="createtime" class="flex-hc-vc"></p>
			</div>
			<div class="author-des m-tb-10">
				<!-- <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')) ?>" target="_blank">(<?php the_author_posts(); ?>篇文章)</a> -->
				<p><?php the_author_meta('description'); ?></p>
			</div>
			<div class="author-social flex-hb-vc flex-hw mt-15">
				<span class="kl-btn kl-btn-primary kl-btn-fill kl-btn-sm">
					<a href="<?php the_author_meta('user_url'); ?>" title="我的站点" rel="nofollow" target="_blank"><i class="col-fff lalaksks lalaksks-ic-menu"></i></a>
				</span>
				<span class="kl-btn kl-btn-primary kl-btn-fill kl-btn-sm">
					<a href="<?php the_author_meta('weibo'); ?>" title="微博" rel="nofollow" target="_blank"><i class="col-fff lalaksks lalaksks-ic-weibo"></i></a>
				</span>
				<span class="kl-btn kl-btn-primary kl-btn-fill kl-btn-sm">
					<a href="<?php the_author_meta('zhihu'); ?>" title="知乎" rel="nofollow" target="_blank"><i class="col-fff lalaksks lalaksks-ic-zhihu fs-16"></i></a>
				</span>
				<span class="kl-btn kl-btn-primary kl-btn-fill kl-btn-sm">
					<a href="<?php the_author_meta('douban'); ?>" title="豆瓣" rel="nofollow" target="_blank"><i class="col-fff lalaksks lalaksks-ic-douban"></i></a>
				</span>
				<span class="kl-btn kl-btn-primary kl-btn-fill kl-btn-sm">
					<a href="<?php the_author_meta('github'); ?>" title="github" rel="nofollow" target="_blank"><i class="col-fff lalaksks lalaksks-ic-github"></i></a>
				</span>
				<!-- <span class="kl-btn kl-btn-primary kl-btn-fill kl-btn-sm">				
				<a href="<?php the_author_meta('juejin'); ?>" title="掘金" rel="nofollow" target="_blank"><i class="col-fff lalaksks lalaksks-ic-github"></i></a>
			</span>
			<span class="kl-btn kl-btn-primary kl-btn-fill kl-btn-sm">				
				<a href="<?php the_author_meta('facebook'); ?>" title="facebook" rel="nofollow" target="_blank"><i class="col-fff lalaksks lalaksks-ic-github"></i></a>
			</span>
			<span class="kl-btn kl-btn-primary kl-btn-fill kl-btn-sm">				
				<a href="<?php the_author_meta('bilibili'); ?>" title="bilibili" rel="nofollow" target="_blank"><i class="col-fff lalaksks lalaksks-ic-github"></i></a>
			</span> -->
			</div>
		</div>
	<?php
}



	?>