<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package KlausLab
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1.0, user-scalable=no" />
	<!-- <link rel="profile" href="http://gmpg.org/xfn/11"> -->
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?> >

<script>
	if(Number(getCookie('logo-gg')) !== Number(1)){
		setCookie('logo-gg','1');
		option.pageLoadingMask.show(document);
	}
</script>

<div id="page" class="hfeed site">
	<header id="masthead" class="site-header" role="banner">
		<div id="site-touch-header" class="menu-touch">
			<div class="menu-toggle flex-hc-vc" aria-controls="primary-menu" aria-expanded="">
				<i class="lalaksks lalaksks-ic-menu"></i>
			</div>
			<div class="flex-hc-vc">
				<h2 class="m-0"><?php echo get_bloginfo('name'); ?></h2>
			</div>
			<div class="flex-hc-vc">
				<i class="lalaksks lalaksks-ic-search"></i>
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
					'menu_id' => 'primary-menu' ,
					'after'  => '<span class="nm-menu-toggle hide"><i class="lalaksks lalaksks-ic-add add"></i><i class="lalaksks lalaksks-ic-minus minus"></i></span>',
					) 
				); 
			?>	
			<div id="menu-avatar"  class="menu-avatar pos-r m-lr-15 <?php if ( is_user_logged_in() ) { echo 'have-login'; } ?>">
				<?php global $current_user;get_currentuserinfo();
					echo get_avatar( $current_user->user_email, 48);
				?>	
				<div id="personal-menu">
					<ul>
						<?php if ( is_user_logged_in() ) { ?>							
							<li><a href="<?php echo get_option('home'); ?>/wp-admin"><i class="lalaksks lalaksks-ic-dashboard m-lr-5"></i>后台</a></li>
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
	</header><!-- #masthead -->

	<div id="content" class="site-content">
	<div class="wrap clear">


