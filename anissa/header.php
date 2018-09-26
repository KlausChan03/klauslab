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

	<header id="masthead" class="site-header" role="banner">
		<button class="menu-toggle" aria-controls="primary-menu" aria-expanded=""><?php esc_html_e( 'Menu', 'anissa' ); ?>
		   <span class="line-1"></span><span class="line-2"></span><span class="line-3"></span>
		</button>
		<nav id="site-navigation" class="main-navigation" role="navigation">
		   
				<?php wp_nav_menu( array( 
					'theme_location' => 'primary', 
					'menu_id' => 'primary-menu' ,
					// 'container' => false,
					// 'fallback_cb' => false,
					'after'  => '<span class="nm-menu-toggle hide"><i class="lalaksks lalaksks-ic-add add"></i><i class="lalaksks lalaksks-ic-minus minus"></i></span>',
					// 'items_wrap' => '%3$s'
					) ); 
					?>

			<?php if ( has_nav_menu( 'social' ) ) : ?>
				<?php wp_nav_menu( array(
					'theme_location'  => 'social',
					'depth'           => 1,
					'link_before'     => '<span class="screen-reader-text">',
					'link_after'      => '</span>',
					'container_class' => 'social-links', 
					) ); 
				?>
			<?php endif; ?>
			
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->

	<div id="content" class="site-content">
	<div class="wrap clear">


