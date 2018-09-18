<?php
/**
 * The template part for displaying results in search pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package anissa
 */

?>



<article id="post-<?php the_ID(); ?>" <?php post_class('style-18'); ?>>	
	<div class="entry-header flex-hl-vc">
		<?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>	
	</div>
	<div class="entry-main flex-hl-vl">
		<?php if ( has_post_thumbnail() ) : ?>
			<div class="featured-image">
				<?php the_post_thumbnail( 'anissa-home' ); ?> 
			</div>
		<?php endif; ?>
		<div class="entry-summary <?php if ( has_post_thumbnail() ) : ?> ml-10 <?php endif; ?>">
			<?php the_excerpt(); ?>
		</div>
	</div>
	<div class="entry-footer flex-hl-vc flex-hw">		
		<div class="entry-date m-0 mr-5">
			<i class="lalaksks lalaksks-ic-date"></i>
			<?php the_time( get_option( 'date_format' ) ); ?>
		</div>
		<div class="entry-cat m-0 mr-5">
			<i class="lalaksks lalaksks-ic-category"></i>
			<?php the_category( ', ' ) ?>
		</div>
		<div class="entry-view m-0 mr-5">
			<i class="lalaksks lalaksks-ic-view"></i>
			<?php echo getPostViews(get_the_ID()); ?>
		</div>
	</div>
</article><!-- #post-## -->

