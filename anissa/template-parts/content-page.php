<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package anissa
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('page-main style-18'); ?>>

	<div class="entry-header">
		<?php the_title( '<h1 class="entry-title flex-hc-vc col-fff">', '</h1>' ); ?>     
		<?php if ( is_single() || is_page() && has_post_thumbnail() ) : ?>
			<div id="banner-bg" class="featured-header-image">
					<?php the_post_thumbnail( 'anissa-home' ); ?>
			</div><!-- .featured-header-image -->
		<?php endif; ?> 
	</div><!-- .entry-header --> 

	<div class="entry-content page-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'anissa' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->


	<?php edit_post_link( esc_html__( 'Edit', 'anissa' ), '<footer class="entry-footer clear"><span class="edit-link">', '</span></footer><!-- .entry-footer -->' ); ?>

</article><!-- #post-## -->

