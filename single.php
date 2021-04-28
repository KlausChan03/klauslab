<?php

/**
 * The template for displaying all single posts.
 *
 * @package KlausLab
 */

get_header(); ?>
<style>
	@media screen and (min-width: 720px) and (max-width: 1000px) {
		.widget-content {
			overflow: hidden;
			width: 92%;
			margin-left: 8%;
		}
	}

	@media screen and (min-width: 720px) {

		.article-container,
		.comment-container,
		.article-skeleton {
			width: 92%;
			margin-left: 8%;
		}

		.article-container{
			overflow: hidden;
		}

		.article-panel {
			position: fixed;
			margin-left: -5rem;
			top: 15vh;
		}
	}

	@media screen and (max-width: 720px) {
		.article-panel {
			display: none;
		}
	}

	.article-panel .lalaksks {
		color: #BBBBBB;
	}

	.article-panel .badge-item .el-badge__content {
		background-color: #BBBBBB;
	}

	.article-panel-item .el-button.is-circle {
		padding: 10px;
	}

	.article-panel-item:not(first-child) {
		margin-top: 30px;

	}
</style>
<div id="primary" class="main-area">
	<main id="main" class="main-content" role="main" v-block>
		<kl-skeleton v-if="!ifShowSingle" class="article-skeleton" type="single"></kl-skeleton>
		<article class="article-container">
			<div class="article-panel flex-v flex-hc-vc">
				<div class="article-panel-item">
					<el-badge :value="posts.post_metas.zan_num > 0 ? posts.post_metas.zan_num : 0 " class="badge-item">
						<el-button circle><i class="lalaksks lalaksks-ic-zan fs-16"></i></el-button>
					</el-badge>
				</div>
				<div class="article-panel-item" @click="goAnchor('#comments')">
					<el-badge :value="posts.post_metas.comments_num > 0 ?  posts.post_metas.comments_num : 0" class="badge-item">
						<el-button circle><i class="lalaksks lalaksks-ic-reply fs-16"></i></el-button>
					</el-badge>
				</div>
			</div>
			<div class="article-main" v-if="ifShowSingle">
				<div class="entry-header flex-hc-vc">
					<h3 class="entry-title">{{posts.title.rendered}}</h3>
					<!-- <div id="banner-bg" class="featured-header-image bgc-primary" v-html="posts.post_metas.thumbnail"> </div> -->
				</div>
				<div class="entry-content" v-html="posts.content.rendered"></div>
			</div>			
		</article>
		<div class="comment-container">
			<?php
			// If comments are open or we have at least one comment, load up the comment template.
			if (comments_open() || get_comments_number()) :
				comments_template();
			endif;
			?>
		</div>
	</main>
	

	<!-- #main -->
</div>
<!-- #primary -->
<!-- 全局配置 -->
<script>
	window.post_id = <?php echo get_the_ID(); ?>;
</script>
<!-- 全局配置 -->
<script type="text/javascript" src="<?php echo KL_THEME_URI; ?>/js/component/skeleton.js"></script>
<script type="text/javascript" src="<?php echo KL_THEME_URI; ?>/js/page/single.js"></script>
<?php setPostViews(get_the_ID()); ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>