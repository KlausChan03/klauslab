<?php

/**
 * The template for displaying all single posts.
 *
 * @package KlausLab
 */

get_header(); ?>
<script>
	window.post_id = <?php echo get_the_ID(); ?>;
</script>

<div id="primary" class="main-area">
	<main id="main" class="main-content" role="main" v-block>
		<kl-skeleton v-if="!ifShowSingle" class="article-skeleton" type="single"></kl-skeleton>
		<article class="article-container">
			<div class="article-panel flex-v flex-hc-vc">
				<div class="article-panel-item" @click="goAnchor('#comments')">
					<el-badge :value="posts.post_metas.comments_num > 0 ?  posts.post_metas.comments_num : 0" class="badge-item">
						<el-button circle><i class="lalaksks lalaksks-ic-reply fs-16"></i></el-button>
					</el-badge>
				</div>
				<div class="article-panel-item">
					<el-badge :value="posts.post_metas.zan_num > 0 ? posts.post_metas.zan_num : 0 " class="badge-item">
						<el-button circle @click="likeOrDislikePost(posts,'like')" :style='{background: posts.post_metas.has_zan ? "#F5B4A7" : "inhert"}'><i class="lalaksks lalaksks-ic-zan fs-16 flex-hc-vc" :style='{color:posts.post_metas.zan_num > 0 ? "#DD4422":"inhert"}'></i></el-button>
					</el-badge>
				</div>
				<div class="article-panel-item">
					<el-badge :value="posts.post_metas.cai_num > 0 ? posts.post_metas.cai_num : 0 " class="badge-item">
						<el-button circle @click="likeOrDislikePost(posts,'dislike')" :style='{background: posts.post_metas.has_cai ? "#856D72" : "inhert"}'><i class="lalaksks lalaksks-ic-zan fs-16 flex-hc-vc" style="transform: rotateX(180deg);" :style='{color:posts.post_metas.cai_num > 0 ? "#36292F":"inhert"}'></i></el-button>
					</el-badge>
				</div>
			</div>
			<div class="article-main" v-if="ifShowSingle">
				<div class="entry-header flex-hc-vc">
					<h3 class="entry-title">{{posts.title.rendered}}</h3>
					<div id="banner-bg" class="featured-header-image bgc-primary" v-html="posts.post_metas.thumbnail"> </div>
				</div>
				<div class="entry-main">
					<div class="entry-extra flex-hr-vc p-10 ">
						<span class="flex-hc-vc fs-12 secondary-color"><i class="el-icon-notebook-2 fs-14"></i>字数统计 {{posts.post_count.text_num}} 字</span>
						<span class="flex-hc-vc ml-10 fs-12 secondary-color"><i class="el-icon-timer fs-14"></i>预计阅读时长 {{posts.post_count.read_time}} 分钟</span>
					</div>
					<div class="entry-content" v-html="posts.content.rendered"> </div>
				</div>
				<div class="entry-footer flex-hc-vc">
					<template v-if="posts.post_metas.reward === '0' ? false : true">
						<kl-reward></kl-reward>
					</template>
					<template v-if="true">
						<el-button circle @click="updatePost()"><i class="el-icon-toilet-paper fs-20"></i></el-button>
					</template>
				</div>
			</div>
		</article>
		<aside class="comment-container mt-10">
			<h3 class="tips-header"><i class="lalaksks lalaksks-pinglun fs-20 mr-10"></i>评论区</h3>
			<template v-if="posts.comment_status === 'open'">
				<quick-comment :post-data="posts" v-if=""></quick-comment>
			</template>
			<template v-else>
				<kl-empty description="暂不开放"></kl-empty>
			</template>

		</aside>
	</main>
	<!-- #main -->
</div>
<!-- #primary -->
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

		.article-container {
			overflow: hidden;
		}

		.article-panel {
			position: fixed;
			margin-left: -5rem;
			top: 100px;
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

	.article-panel-item:not(:first-child) {
		margin-top: 30px;

	}

	.pay-chose button {
		width: 120px;
		height: 45px;
		text-align: center;
		border: 1px solid #e6e6e6;
		border-radius: 2px;
		display: inline-block;
		line-height: 40px;
		cursor: pointer;
	}

	.pay-chose button img {
		height: 25px;
		vertical-align: sub;
	}

	.pay-chose button.chosen {
		border-color: #0092ee;
	}

	.pay-body .alipay,
	.pay-body .wechatpay {
		width: 220px;
		height: 220px;
	}

	.entry-footer button:not(:first-child){
		margin-left: 20px;
	}
</style>
<script type="text/javascript" src="<?php echo KL_THEME_URI; ?>/js/component/skeleton.js"></script>
<script type="text/javascript" src="<?php echo KL_THEME_URI; ?>/js/component/reward.js" ></script>

<script type="text/javascript" src="<?php echo KL_THEME_URI; ?>/js/page/single.js"></script>
<script type="text/javascript" src="<?php echo KL_THEME_URI; ?>/js/component/quickCommentItem.js" defer></script>
<script type="text/javascript" src="<?php echo KL_THEME_URI; ?>/js/component/quickComment.js" defer></script>
<?php setPostViews(get_the_ID()); ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>