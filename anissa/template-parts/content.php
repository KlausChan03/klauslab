<?php
/**
 * Template part for displaying posts.
 *
 * @package anissa
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('style-18'); ?>>	
	<div class="entry-header flex-hl-vc">
		<?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>	
	</div>
	<div class="entry-main">
		<div class="entry-main-excerpt flex-hl-vl">
			<?php if ( has_post_thumbnail() ) : ?>
				<div class="featured-image">
					<?php the_post_thumbnail( 'anissa-home' ); ?> 
				</div>
			<?php endif; ?>
			<div class="entry-summary <?php if ( has_post_thumbnail() ) : ?> ml-10 <?php endif; ?>">
				<?php the_excerpt(); ?>
			</div>
		</div>
		<div class="entry-main-detail hide pos-r">
			<?php the_content(); ?>			
		</div>
	</div>
	<div class="entry-footer flex-hb-vc flex-hw">				
			<?php if ( !is_mobile() ) : ?>
				<div class="entry-action flex-hl-vc">
					<div class="entry-date m-0 mr-10">
						<i class="lalaksks lalaksks-ic-date"></i>
						<?php the_time( get_option( 'date_format' ) ); ?>
					</div>
					<div class="entry-cat m-0 mr-10">
						<i class="lalaksks lalaksks-ic-category"></i>
						<?php the_category( ', ' ) ?>
					</div>
					<div class="entry-view m-0 mr-10">
						<i class="lalaksks lalaksks-ic-view"></i>
						<?php echo getPostViews(get_the_ID()) . "阅读"; ?>
					</div>
					<div class="entry-view m-0 mr-10">
						<i class="lalaksks lalaksks-ic-reply"></i>
						<?php echo get_comments_number() . "评论"; ?>
					</div>
				</div>
			<?php else: ?>
				<div class="entry-action flex-v flex-hc-vl">
					<div class="entry-date m-0 mr-10 flex-hl-vc">
						<i class="lalaksks lalaksks-ic-date"></i>
						<?php the_time( get_option( 'date_format' ) ); ?>
					</div>
					<div class="entry-cat m-0 mr-10 flex-hl-vc">
						<i class="lalaksks lalaksks-ic-category"></i>
						<?php the_category( ', ' ) ?>
					</div>
				</div>
			<?php endif ?>		
		<div class="entry-extra">
			<button class="expand-btn klaus-btn sm-btn gradient-blue-red show">展开全文</button>
			<button class="collapse-btn klaus-btn sm-btn gradient-red-blue hide">收起全文</button>
		</div>
	</div>
</article><!-- #post-## -->
