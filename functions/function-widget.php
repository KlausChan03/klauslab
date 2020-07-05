<?php

// Style the Tag Cloud
function KlausLab_tag_cloud_widget($args)
{
	$args['largest'] = 12; //largest tag
	$args['smallest'] = 12; //smallest tag
	$args['unit'] = 'px'; //tag font unit
	$args['number'] = '18'; //number of tags
	return $args;
}

add_filter('widget_tag_cloud_args', 'KlausLab_tag_cloud_widget');

add_action('widgets_init', create_function('', 'return register_widget("UserInfo");'));
class UserInfo extends WP_Widget
{

	function UserInfo()
	{
		$widget_ops = array('description' => '显示当前用户信息');
		$this->WP_Widget('UserInfo', '本站用户', $widget_ops);
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
	<div class="author-info">		
		<div class="author-avatar flex-hc-vc mb-10">
			<?php if (function_exists('get_avatar')) {
				echo get_avatar( $current_user->user_email, 48);
			} ?>
		</div>
		<div class="author-name flex-hc-vc mb-5 ">
			<span>
			<?php global $user_ID; if (!$current_user->display_name && $user_ID === 0) : ?>
					游客，欢迎到此一游。
				<?php else : ?>
				<?php echo($current_user->display_name); echo ('，你在本站留下了' . get_comments('count=true&user_id=' . $user_ID) . '条评论。'); ?>
				<?php endif; ?>
				<!-- <?php echo($current_user->display_name); ?>，</span><span>你在本站留下了<?php global $user_ID; echo get_comments('count=true&user_id=' . $user_ID); ?>条评论。 -->
			</span>
		</div>
	</div>
<?php
}




add_action('widgets_init', create_function('', 'return register_widget("AuthorInfo");'));
class AuthorInfo extends WP_Widget
{

	function AuthorInfo()
	{
		$widget_ops = array('description' => '显示站长信息');
		$this->WP_Widget('AuthorInfo', '本站站长', $widget_ops);
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
			<p id="lovetime" class="flex-hc-vc"></p>
			<p id="createtime" class="flex-hc-vc"></p>
        </div>
		<div class="author-des mb-10">
			<!-- <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')) ?>" target="_blank">(<?php the_author_posts(); ?>篇文章)</a> -->
			<p><?php the_author_meta('description'); ?></p>
		</div>
		<div class="author-social flex-hb-vc flex-hw">
			<span class="kl-btn kl-btn-primary kl-btn-sm">
				<a href="<?php the_author_meta('user_url'); ?>" rel="nofollow" target="_blank"><i class="lalaksks lalaksks-ic-menu"></i>博客</a>
			</span>
			<span class="kl-btn kl-btn-primary kl-btn-sm">				
				<a href="<?php the_author_meta('weibo'); ?>" rel="nofollow" target="_blank"><i class="lalaksks lalaksks-ic-weibo"></i>微博</a>
			</span>
			<span class="kl-btn kl-btn-primary kl-btn-sm">				
				<a href="<?php the_author_meta('zhihu'); ?>" rel="nofollow" target="_blank"><i class="lalaksks lalaksks-ic-zhihu"></i>知乎</a>
			</span>
			<span class="kl-btn kl-btn-primary kl-btn-sm">				
				<a href="<?php the_author_meta('douban'); ?>" rel="nofollow" target="_blank"><i class="lalaksks lalaksks-ic-douban"></i>豆瓣</a>
			</span>
			<span class="kl-btn kl-btn-primary kl-btn-sm">				
				<a href="<?php the_author_meta('github'); ?>" rel="nofollow" target="_blank"><i class="lalaksks lalaksks-ic-github"></i>Github</a>
			</span>
		</div>
	</div>
<?php
}



?>