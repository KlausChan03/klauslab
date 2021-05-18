<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package KlausLab
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('page-main'); ?>>

	<div class="entry-header flex-hc-vc">
		<?php the_title( '<h3 class="entry-title">', '</h3>' ); ?>     
		<?php if ( is_single() || is_page() && has_post_thumbnail() ) : ?>
			<div id="banner-bg" class="featured-header-image">
					<?php the_post_thumbnail( 'KlausLab-home' ); ?>
			</div><!-- .featured-header-image -->
		<?php endif; ?> 
	</div><!-- .entry-header --> 

	<div class="entry-content page-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'KlausLab' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->


	<?php edit_post_link( esc_html__( 'Edit', 'KlausLab' ), '<footer class="entry-footer clear"><span class="edit-link">', '</span></footer><!-- .entry-footer -->' ); ?>

</article><!-- #post-## -->

