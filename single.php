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


</style>
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
						<el-button circle @click="likeOrDislikePost(posts,'like')" :style='{background: posts.post_metas.has_cai ? "#856D72" : "inhert"}'><i class="lalaksks lalaksks-ic-zan fs-16 flex-hc-vc" style="transform: rotateX(180deg);" :style='{color:posts.post_metas.cai_num > 0 ? "#36292F":"inhert"}'></i></el-button>
					</el-badge>
				</div>
				
			</div>
			<div class="article-main" v-if="ifShowSingle">
				<div class="entry-header flex-hc-vc">
					<h3 class="entry-title">{{posts.title.rendered}}</h3>
					<!-- <div id="banner-bg" class="featured-header-image bgc-primary" v-html="posts.post_metas.thumbnail"> </div> -->
				</div>
				<div class="entry-content" v-html="posts.content.rendered"></div>
				<div class="entry-footer flex-hc-vc">

					<el-popover placement="top" title="请作者喝杯咖啡☕" width="280" trigger="click">
						<div class="pay-body">
							<?php
							$alipay_image_id = cs_get_option('alipay_image');
							$alipay_attachment = wp_get_attachment_image_src($alipay_image_id, 'full');
							$wechat_image_id = cs_get_option('wechat_image');
							$wechat_attachment = wp_get_attachment_image_src($wechat_image_id, 'full');

							if (cs_get_option('alipay_image') && cs_get_option('wechat_image')) { ?>
								<h4 class="flex-hc-vc m-tb-10">扫一扫支付</h4>
								<div class="flex-hc-vc">
									<img class="alipay" src="<?php echo $alipay_attachment[0]; ?>" v-show="ifShowPayImage" />
									<img class="wechatpay" src="<?php echo $wechat_attachment[0]; ?>" v-show="!ifShowPayImage" />
								</div>
								<div class="pay-chose flex-hb-vc mt-15">
									<button class="alibutton" :class="{'chosen':ifShowPayImage}" :disabled="ifShowPayImage" ref="alibutton" @click="changeChoose"><img src="<?php echo KL_THEME_URI; ?>/img/alipay.png" /></button>
									<button class="wechatbutton" :class="{'chosen':!ifShowPayImage}" :disabled="!ifShowPayImage" ref="wechatbutton" @click="changeChoose"><img src="<?php echo KL_THEME_URI; ?>/img/wechat.png" /></button>
								</div>
							<?php } else if (cs_get_option('alipay_image') && !cs_get_option('wechat_image')) { ?>
								<h4 class="flex-hc-vc m-tb-10">扫一扫支付</h4>
								<img class="alipay" src="<?php echo $alipay_attachment[0]; ?>" />
							<?php } else if (!cs_get_option('alipay_image') && cs_get_option('wechat_image')) { ?>
								<h4 class="flex-hc-vc m-tb-10">扫一扫支付</h4>
								<img class="wechatpay" src="<?php echo $wechat_attachment[0]; ?>" />
							<?php } else { ?>
								<h4 class="flex-hc-vc m-tb-10">作者尚未添加打赏二维码！</h4>
							<?php } ?>
						</div>
						<el-button slot="reference" circle><i class="el-icon-coffee fs-20"></i></el-button>
					</el-popover>
				</div>
			</div>
		</article>
		<aside class="comment-container mt-10" >
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

<script type="text/javascript" src="<?php echo KL_THEME_URI; ?>/js/component/skeleton.js"></script>
<script type="text/javascript" src="<?php echo KL_THEME_URI; ?>/js/page/single.js"></script>
<script type="text/javascript" src="<?php echo KL_THEME_URI; ?>/js/component/quickCommentItem.js" defer></script>
<script type="text/javascript" src="<?php echo KL_THEME_URI; ?>/js/component/quickComment.js" defer></script>
<?php setPostViews(get_the_ID()); ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>