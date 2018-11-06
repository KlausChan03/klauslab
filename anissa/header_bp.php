<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package anissa
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">

<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1.0, user-scalable=no" />
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">


<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>


<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'anissa' ); ?></a>

	<header id="masthead" class="site-header animated" role="banner">
		<div id="menu-touch" class="menu-touch flex-hb-vc">
			<div class="menu-toggle flex-hc-vc" aria-controls="primary-menu" aria-expanded="">
			<i class="lalaksks lalaksks-ic-menu"></i>
			</div>
			<div class="flex-hc-vc">
				<?php echo get_bloginfo('name'); ?>
			</div>
			<div class="flex-hc-vc">
				<i class="lalaksks lalaksks-ic-search"></i>
			</div>
		</div>
		<nav id="site-navigation" class="main-navigation" role="navigation">		   
			<?php wp_nav_menu( array( 
				'theme_location' => 'primary', 
				'menu_id' => 'primary-menu' ,
				'after'  => '<span class="nm-menu-toggle"><i class="lalaksks lalaksks-ic-add add"></i><i class="lalaksks lalaksks-ic-minus minus hide"></i></span>',
				) ); 
			?>		
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->

	<div id="content" class="site-content">
	<div class="wrap clear">


