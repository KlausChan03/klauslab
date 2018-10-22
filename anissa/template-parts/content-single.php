<?php
/**
 * Template part for displaying single posts.
 *
 * @package anissa
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="entry-header">
		<?php the_title( '<h1 class="entry-title flex-hc-vc">', '</h1>' ); ?>        
	</div><!-- .entry-header -->
    
    <?php if ( is_single() || is_page() && has_post_thumbnail() ) : ?>
		<div class="featured-header-image">
				<?php the_post_thumbnail( 'anissa-home' ); ?>
		</div><!-- .featured-header-image -->
	<?php endif; ?>

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'anissa' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<div class="entry-footer clear">
		<div class="entry-action flex-hl-vc flex-hw">
			<div class="entry-date m-0 mr-10">
				<?php is_icon( get_the_ID() ,"date"); ?>
			</div>
			<div class="entry-cat m-0 mr-10">
				<?php is_icon( get_the_ID() , "category"); ?>
			</div>
			<div class="entry-cat m-0 mr-10">
				<?php is_icon( get_the_ID() , "tag"); ?>
			</div>
			<div class="entry-view m-0 mr-10">
				<?php is_icon( get_the_ID() , "view"); ?>
			</div>
			<div class="entry-comment m-0 mr-10">
				<?php is_icon( get_the_ID() , "reply"); ?>
			</div>
			<?php 	
				if(isAdmin()){
					edit_post_link(_e('<span class="edit-link mr-10"><i class="lalaksks lalaksks-ic-edit mr-5"></i>', '</span>' ) );
				}
			?>
		</div>

	</div><!-- .entry-footer -->
</article><!-- #post-## -->

