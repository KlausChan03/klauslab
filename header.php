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
</head>

<body id="page" <?php body_class(); ?>>
	<?php global $current_user; ?>
	<script>
		// 全局参数
		window.is_login = "<?php echo is_user_logged_in(); ?>";
		window.is_single = "<?php echo is_single(); ?>";
		window.the_custom_logo = `<?php echo the_custom_logo(); ?>`;
		window.the_avatar = `<?php echo get_avatar($current_user->user_email, 38); ?>`;
		window.the_bloginfo_name = `<?php echo get_bloginfo('name'); ?>`;
		window.home_url = `<?php echo get_option('home') ?>`;
		window._nonce = "<?php echo wp_create_nonce('wp_rest'); ?>";
		window.if_mobile_device = document.body.clientWidth <= 1000 ? true : false
		window.site_url = '<?php echo site_url(); ?>';
		window.ajaxSourceUrl = "<?php echo KL_URI; ?>"
		window.homeSourceUrl = "<?php echo KL_THEME_URI; ?>"
		window.start_time = '<?php echo cs_get_option('klausLab_start_time'); ?>';
		window.start_full_year = start_time ? new Date(start_time).getFullYear() : new Date().getFullYear();
		window.now_full_year = new Date().getFullYear();
		window.icp_num = '<?php echo get_option('zh_cn_l10n_icp_num') ?>';
		window.tinyKey = "7b4pdrcfzcszmsf2gjor1x94mha4srj4jalmdpq94fgpaa6j";
		window.user_full_name = `<?php echo $current_user->user_firstname; ?>`;
		window.wp_count_posts = "<?php $publish_posts = wp_count_posts()->publish;
															echo $publish_posts; ?>";

		// 首屏Loading
		const max_timer = 2
    document.querySelector("#page").style.overflowY = 'hidden'
		setTimeout(() => {
			fadeout(document.getElementById('kl-loader'), 0, 1500);
			document.getElementById("kl-loader-container") && document.getElementById("kl-loader-container").remove();
      document.querySelector("#page").style.overflowY = 'auto'
		}, max_timer * 1000);
		window.onload = function() {
			fadeout(document.getElementById('kl-loader'), 0, 1500);
			document.getElementById("kl-loader-container") && document.getElementById("kl-loader-container").remove();
      document.querySelector("#page").style.overflowY = 'auto'
		}
	</script>

	<!-- loading 动画  -->
	<div id="kl-loader-container" class="kl-loader-container">
		<div class="loader-wrapper ☯-bg fadeOut animated">
			<div class='☯'></div>
		</div>
	</div>

	<header id="header" class="site-header" role="banner" v-cloak>
		<div v-if="ifMobileDevice" id="site-touch-header" class="menu-touch">
			<div class="menu-toggle flex-hc-vc" @click="changeMenu">
				<i class="lalaksks lalaksks-ic-menu"></i>
			</div>
			<div class="flex-hc-vc">
				<h2 class="m-0" v-html="bloginfoName"></h2>
			</div>
			<div class="flex-hc-vc">
				<i class="lalaksks lalaksks-ic-search" @click="showSearch"></i>
			</div>
			<el-menu v-show="ifShowMenu" class="el-menu-vertical" :default-active="activeIndex">
				<div class="flex-hb-vc p-10">
					<el-button v-if="isLogin" class="flex-1-2" @click="goToPage('page-post-simple', true, {type:'new'})" type="primary" size="medium">发布</el-button>
					<el-button v-if="!isLogin" class="flex-1-2" @click="goToPage('wp-login.php?action=login',true)" type="primary" size="medium">登录</el-button>
					<el-button v-if="isLogin" class="flex-1-2" @click="goToPage('wp-login.php?action=logout',true)" type="primary" size="medium">登出</el-button>
					<el-button v-if="isLogin" class="flex-1-2" @click="goToPage('wp-admin',true)" type="primary" size="medium">后台</el-button>
					<el-button class="flex-1-2" @click="goToPage('feed',true)" type="primary" size="medium">订阅</el-button>
				</div>
				<template v-for="(item,index) in menuList">
					<el-menu-item v-if="!item.children || item.children.length === 0" :index="item.db_id.toString()" @click="goToPage(item.url)"><i v-if="item.iconName" :class="item.iconName"></i><span>{{item.title}}</span></el-menu-item>
					<template v-if="item.children && item.children.length > 0">
						<el-submenu :index="item.db_id.toString()">
							<template slot="title"> <i v-if="item.iconName" :class="item.iconName"></i><span @click="goToPage(item.url)">{{item.title}} </span></template>
							<template v-for="(sonItem,sonIndex) in item.children">
								<el-menu-item v-if="!sonItem.children || sonItem.children.length === 0" :index="sonItem.db_id.toString()" @click="goToPage(sonItem.url)"><span>{{sonItem.title}}</span></el-menu-item>
								<template v-if="sonItem.children && sonItem.children.length > 0">
									<template v-for="(grandsonItem,grandsonIndex) in sonItem.children">
										<el-submenu :index="grandsonItem.db_id.toString()">
											<template slot="title"> <span @click="goToPage(sonItem.url)">{{sonItem.title}} </span></template>
											<el-menu-item :index="grandsonItem.db_id.toString()" @click="goToPage(grandsonItem.url)">{{grandsonItem.title}}</el-menu-item>
										</el-submenu>
									</template>
								</template>
							</template>
						</el-submenu>
					</template>
				</template>
			</el-menu>
		</div>
		<nav v-if="!ifMobileDevice" id="site-navigation" class="menu-pc main-navigation flex-hb-vc" role="navigation">
			<div class="menu-left" :class="{'flex-hl-vc':!ifMobileDevice}">
				<div class="menu-logo m-lr-15">
					<div v-html="customLogo"> </div>
				</div>
				<div class="ml-15">
					<el-menu class="el-menu-horizontal" mode="horizontal" :default-active="activeIndex">
						<template v-for="(item,index) in menuList">
							<el-menu-item v-if="!item.children || item.children.length === 0" :index="item.db_id.toString()" @click="goToPage(item.url)"><i v-if="item.iconName" :class="item.iconName"></i><span>{{item.title}}</span></el-menu-item>
							<template v-if="item.children && item.children.length > 0">
								<el-submenu :index="item.db_id.toString()">
									<template slot="title"><i v-if="item.iconName" :class="item.iconName"></i> <span @click="goToPage(item.url)">{{item.title}} </span></template>
									<template v-for="(sonItem,sonIndex) in item.children">
										<el-menu-item v-if="!sonItem.children || sonItem.children.length === 0" :index="sonItem.db_id.toString()" @click="goToPage(sonItem.url)"><span>{{sonItem.title}}</span></el-menu-item>
										<template v-if="sonItem.children && sonItem.children.length > 0">
											<template v-for="(grandsonItem,grandsonIndex) in sonItem.children">
												<el-submenu :index="grandsonItem.db_id.toString()">
													<template slot="title"> <span @click="goToPage(sonItem.url)">{{sonItem.title}} </span></template>
													<el-menu-item :index="grandsonItem.db_id.toString()" @click="goToPage(grandsonItem.url)">{{grandsonItem.title}}</el-menu-item>
												</el-submenu>
											</template>
										</template>
									</template>
								</el-submenu>
							</template>
						</template>
					</el-menu>
				</div>
			</div>
			<div class="menu-right" :class="{'flex-hr-vc':!ifMobileDevice}">
				<div class="menu-publish mr-30">
					<el-button icon="el-icon-position" type="text" @click="goToPage('feed',true)" size="medium">订阅</el-button>
				</div>
				<div class="menu-search mr-30">
					<el-button icon="el-icon-search" type="text" @click="showSearch" size="medium">搜索</el-button>
				</div>
				<div class="menu-publish mr-30" v-if="isLogin">
					<el-button icon="el-icon-magic-stick" type="text" @click="goToPage('page-post-simple', true, {type:'new'})" size="medium">发布</el-button>
				</div>
				<div id="menu-avatar" :class="{'flex-hc-vc':ifMobileDevice,'has-login':isLogin}" class="menu-avatar pos-r m-lr-15">
					<el-dropdown @command="handleCommand">
						<span class="el-dropdown-link">
							<el-button class="header-user-avatar" :icon="userFullName || 'el-icon-user-solid'">{{userFullName || ''}}</el-button>
						</span>
						<el-dropdown-menu slot="dropdown">
							<template v-if="isLogin">
								<el-dropdown-item><a :href="homeUrl + '/wp-admin'"><i class="lalaksks lalaksks-ic-dashboard m-lr-5"></i>后台</a></el-dropdown-item>
								<el-dropdown-item command="/wp-login.php?action=logout" divided><i class="lalaksks lalaksks-ic-logout m-lr-5"></i>登出</el-dropdown-item>
							</template>
							<template v-else>
								<el-dropdown-item command="/wp-login.php?action=login" divided><i class="lalaksks lalaksks-ic-login m-lr-5"></i>登录</el-dropdown-item>
							</template>
							<el-dropdown-item command="/wp-login.php?action=register" divided><i class="lalaksks lalaksks-ic-register m-lr-5"></i>注册</el-dropdown-item>
						</el-dropdown-menu>
					</el-dropdown>
				</div>
			</div>
		</nav>
		<kl-search ref="searchMain" v-show="ifShowSearch" @close-search="closeSearch"></kl-search>
	</header>
	<main id="main" class="site-content wrap flex-hb-vt flex-hw">