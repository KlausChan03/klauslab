<?php

/**
 * The template for displaying all single posts.
 *
 * @package KlausLab
 */

get_header(); ?>
<link rel="stylesheet" href="<?php echo KL_THEME_URI; ?>/css/single.css">

<script>
	window.post_id = <?php echo get_the_ID(); ?>;
</script>

<div id="primary" class="main-area <?php $is_show_sidebar = boolval(cs_get_option('klausLab_sideBar_switcher'));
                                    echo ($is_show_sidebar == 1 ? '' : 'w-1'); ?>">
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

<script type="text/javascript" src="<?php echo KL_THEME_URI; ?>/js/component/skeleton.js"></script>
<script type="text/javascript" src="<?php echo KL_THEME_URI; ?>/js/component/reward.js"></script>

<script type="text/javascript" src="<?php echo KL_THEME_URI; ?>/js/page/single.js"></script>
<script type="text/javascript" src="<?php echo KL_THEME_URI; ?>/js/component/quickCommentItem.js" defer></script>
<script type="text/javascript" src="<?php echo KL_THEME_URI; ?>/js/component/quickComment.js" defer></script>
<?php setPostViews(get_the_ID()); ?>
<?php
$is_show_sidebar == 1 ?  get_sidebar() : ''
?>
<?php get_footer(); ?>