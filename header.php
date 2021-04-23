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
	<style>
		.search-bg-b {
			position: fixed;
			width: 100%;
			height: calc(100vh + 80px);
			z-index: 9;
			margin-top: -80px;
			background: rgba(51, 51, 51, 0.73);
			/* display: none; */
		}


		.search-bg {
			position: fixed;
			width: 600px;
			left: calc((100% - 600px)/2);
			z-index: 999;
			background: #fff;
			border-radius: 3px;
			box-shadow: rgba(0, 0, 0, 0.04) 0px 4px 8px;
			padding: 40px;
			padding-bottom: 50px;
			max-height: calc(100% - 150px);
			overflow-y: auto;
			transition: all .2s;
			/* display: none; */
		}

		.search-div1 h3 {
			margin: 0px;
			font-weight: 600;
			color: #333;
		}

		.search-div1 p {
			margin: 0px;
			color: #999;
			margin-bottom: 20px;
		}

		.search-div1 input {
			width: 100%;
			border-radius: 3px;
			padding: 12px 15px;
			height: auto;
			color: #888;
			border: 2px solid #eee !important;
			font-weight: 500;
			border-color: #eee;
		}

		.search-div2 ul {
			list-style: none;
			padding: 0px;
			margin: 20px 0 0 0;
		}

		.search-div2 li {
			padding: 15px;
			margin: 10px 0;
			border-radius: 3px;
			border: 1px solid #eee;
		}

		.search-div2 a {
			text-decoration: none !important;
		}

		.search-div2 li h4 {
			margin: 0px;
			text-overflow: ellipsis;
			white-space: nowrap;
			overflow: hidden;
			font-weight: 600;
		}

		.search-div2 li p {
			text-overflow: ellipsis;
			white-space: nowrap;
			overflow: hidden;
			margin: 0px;
			font-size: .9rem;
			color: #999;
		}

		.search_form_play {
			opacity: 1;
			z-index: 999;
		}

		@media screen and (max-width: 720px) {
			.search-bg {
				width: 95vw;
				left: 50%;
				margin-left: -47.5vw;
				padding: 20px;

			}
		}
	</style>
</head>

<body <?php body_class(); ?>>
	<div id="page" class="hfeed site">
		<header id="masthead" class="site-header" role="banner" v-block>
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
				<div class="flex-hl-vc">
					<svg class="icon icon-title mr-10" aria-hidden="true">
						<use xlink:href="#lalaksks21-search-1"></use>
					</svg>
					<el-input size="small" placeholder="请输入搜索内容" @focus="showSearch"></el-input>
				</div>
				<div id="menu-avatar" class="menu-avatar pos-r m-lr-15 <?php if (is_user_logged_in()) {
																			echo 'have-login';
																		} ?>">
					<?php global $current_user;
					echo get_avatar($current_user->user_email, 48);
					?>
					<div id="personal-menu">
						<ul>
							<?php if (is_user_logged_in()) { ?>
								<li><a href="<?php echo get_option('home'); ?>/wp-admin"><i class="lalaksks lalaksks-ic-dashboard m-lr-5"></i>后台</a></li>
								<li><a href="<?php echo get_option('home'); ?>/post-simple"><i class="lalaksks lalaksks-ic-create m-lr-5"></i>快捷发布</a></li>
								<li><a href="<?php echo get_option('home'); ?>/wp-admin/post-new.php"><i class="lalaksks lalaksks-ic-addArticle m-lr-5"></i>发布文章</a></li>
								<li><a href="<?php echo get_option('home'); ?>/wp-admin/post-new.php?post_type=shuoshuo"><i class="lalaksks lalaksks-ic-addTalk m-lr-5"></i>发布说说</a></li>
								<li><a href="<?php echo get_option('home'); ?>/wp-login.php?action=logout"><i class="lalaksks lalaksks-ic-logout m-lr-5"></i>登出</a></li>
							<?php } else { ?>
								<li><a href="<?php echo get_option('home'); ?>/wp-login.php?action=login"><i class="lalaksks lalaksks-ic-login m-lr-5"></i>登录</a></li>
							<?php } ?>
						</ul>
					</div>
				</div>
			</nav><!-- #site-navigation -->

			<kl-search ref="searchMain" v-show="ifShowSearch" @close-search="closeSearch"></kl-search>
		</header><!-- #masthead -->

		<script>
			new Vue({
				el: '#masthead',
				data() {
					return {
						ifShowSearch: false
					}
				},
				methods: {
					showSearch() {
						this.ifShowSearch = true
						this.$nextTick(()=>{
							console.log(this.$refs.searchMain.$refs.searchInput)
							this.$refs.searchMain.$refs.searchInput.focus()
						})
					},
					closeSearch() {
						this.ifShowSearch = false

					}
				},

			})
		</script>

		<div id="content" class="site-content">
			<div class="wrap clear">