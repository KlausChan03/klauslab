<?php

/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package KlausLab
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<?php
	$description = cs_get_option('klausLab_description');
	$keywords = cs_get_option('klausLab_keywords');
	// 去除不必要的空格和HTML标签
	$description = trim(strip_tags($description));
	$keywords = trim(strip_tags($keywords));
	?>

	<meta name="description" content="<?php echo $description; ?>" />
	<meta name="keywords" content="<?php echo $keywords; ?>" />
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1.0, user-scalable=no" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
	<?php wp_head(); ?>
	<script type="text/javascript" src="<?php echo KL_THEME_URI; ?>/js/component/empty.js"></script>
	<script type="text/javascript" src="<?php echo KL_THEME_URI; ?>/js/component/search.js"></script>

	<script src="https://unpkg.com/vue-router/dist/vue-router.js"></script>
</head>

<body <?php body_class(); ?>>
	<script>
		window._nonce = "<?php echo wp_create_nonce('wp_rest'); ?>";
		window.ifMobileDevice = document.body.clientWidth <= 1000 ? true : false
		window.site_url = '<?php echo site_url() ?>';
		window.ajaxSourceUrl = window.site_url + '/wp-content/themes/KlausLab/inc'
		window.homeSourceUrl = window.site_url + '/wp-content/themes/KlausLab/dist'
		window.start_time = new Date("<?php echo cs_get_option('klausLab_start_time'); ?>").getFullYear();
	</script>
	<div id="page" class="hfeed site">
		<header id="header" class="site-header" role="banner" v-block>
			<div id="site-touch-header" class="menu-touch">
				<div class="menu-toggle flex-hc-vc" aria-controls="primary-menu" aria-expanded="">
					<i class="lalaksks lalaksks-ic-menu"></i>
				</div>
				<div class="flex-hc-vc">
					<h2 class="m-0"><?php echo get_bloginfo('name'); ?></h2>
				</div>
				<div class="flex-hc-vc">
					<i class="lalaksks lalaksks-ic-search" @click="showSearch"></i>
				</div>
			</div>
			<nav id="site-navigation" class="menu-pc main-navigation flex-hb-vc" role="navigation">
				<div class="menu-logo m-lr-15">
					<?php echo the_custom_logo(); ?>
				</div>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'menu_id' => 'primary-menu',
					)
				);
				?>
				<div class="menu-right" :class="{'flex-hr-vc':!ifMobileDevice}">
					<div class="menu-search flex-hl-vc" v-if="!ifMobileDevice">
						<svg class="icon icon-title mr-10 fs-20" aria-hidden="true">
							<use xlink:href="#lalaksks21-search-1"></use>
						</svg>
						<el-input size="small" placeholder="请输入搜索内容" @focus="showSearch"></el-input>
					</div>
					<div id="menu-avatar" :class="{'flex-hc-vc':ifMobileDevice}" class="menu-avatar pos-r m-lr-15 <?php if (is_user_logged_in()) {
																							echo 'have-login';
																						} ?>">
						<?php global $current_user;
						echo get_avatar($current_user->user_email, 48);
						?>
						<div id="personal-menu">
							<ul>
								<?php if (is_user_logged_in()) { ?>
									<li><a href="<?php echo get_option('home'); ?>/wp-admin"><i class="lalaksks lalaksks-ic-dashboard m-lr-5"></i>后台</a></li>
									<li><a href="<?php echo get_option('home'); ?>/page-post-simple"><i class="lalaksks lalaksks-rocket m-lr-5"></i>快捷发布</a></li>
									<li><a href="<?php echo get_option('home'); ?>/wp-admin/post-new.php"><i class="lalaksks lalaksks-ic-create m-lr-5"></i>发布文章</a></li>
									<li><a href="<?php echo get_option('home'); ?>/wp-admin/post-new.php?post_type=shuoshuo"><i class="lalaksks lalaksks-ic-create m-lr-5"></i>发布说说</a></li>
									<li><a href="<?php echo get_option('home'); ?>/wp-login.php?action=logout"><i class="lalaksks lalaksks-ic-logout m-lr-5"></i>登出</a></li>
								<?php } else { ?>
									<li><a href="<?php echo get_option('home'); ?>/wp-login.php?action=login"><i class="lalaksks lalaksks-ic-login m-lr-5"></i>登录</a></li>
								<?php } ?>
							</ul>
						</div>
					</div>
				</div>
			</nav><!-- #site-navigation -->
			<kl-search ref="searchMain" v-show="ifShowSearch" @close-search="closeSearch"></kl-search>
		</header><!-- #header -->
		<div id="content" class="site-content">
			<div class="wrap clear">