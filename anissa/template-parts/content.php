<?php
/**
 * Template part for displaying posts.
 *
 * @package anissa
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('article-list style-18'); ?>>	
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
					<div class="entry-date m-0 mr-15">
						<?php is_icon( get_the_ID() ,"date"); ?>
					</div>					
					<div class="entry-view m-0 mr-15">
						<?php is_icon( get_the_ID() , "view"); ?>
					</div>
					<div class="entry-comment m-0 mr-15">
						<?php is_icon( get_the_ID() , "reply"); ?>
					</div>
					<div class="entry-zan m-0 mr-15">
						<span class="zan">
							<a href="#" data-action="ding" data-id="<?php the_ID(); ?>" id="Addlike" class="action flex-hb-vc <?php if(isset($_COOKIE['inlo_ding_'.$post->ID])) echo 'actived';?> <?php $category = get_the_category();  echo $category[0]->category_nicename;?>">
								<i class="lalaksks lalaksks-ic-zan"></i>
								<span class="count"><?php if( get_post_meta($post->ID,'inlo_ding',true) ){ echo get_post_meta($post->ID,'inlo_ding',true); } else {echo '0';}?></span>
							</a>
						</span>
					</div>
				</div>
			<?php else: ?>
				<div class="entry-action flex-v flex-hc-vl">
					<div class="entry-date m-0 mr-15">
						<?php is_icon( get_the_ID() ,"date"); ?>
					</div>
					<div class="entry-author m-0 mr-15">
						<?php is_icon( get_the_ID() ,"author"); ?>
					</div>
					<div class="entry-zan m-0 mr-15">
						<span class="zan">
							<a href="#" data-action="ding" data-id="<?php the_ID(); ?>" id="Addlike" class="action flex-hb-vc <?php if(isset($_COOKIE['inlo_ding_'.$post->ID])) echo 'actived';?> <?php $category = get_the_category();  echo $category[0]->category_nicename;?>">
								<i class="lalaksks lalaksks-ic-zan"></i>
								<span class="count"><?php if( get_post_meta($post->ID,'inlo_ding',true) ){ echo get_post_meta($post->ID,'inlo_ding',true); } else {echo '0';}?></span>
							</a>
						</span>
					</div>
				</div>
			<?php endif ?>		
		<div class="entry-extra">
			<button class="expand-btn klaus-btn sm-btn gradient-blue-red show">展开全文</button>
			<button class="collapse-btn klaus-btn sm-btn gradient-red-blue hide">收起全文</button>
		</div>
	</div>
</article><!-- #post-## -->
