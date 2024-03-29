<?php

/**
 * The template for displaying all single posts.
 *
 * @package KlausLab
 */

get_header(); ?>
<?php setPostViews(get_the_ID()); ?>

<link rel="stylesheet" href="<?php echo KL_THEME_URI; ?>/css/page/single.css"  rel="preload">
<link rel="stylesheet" href="<?php echo KL_THEME_URI; ?>/css/catalog.css"  rel="preload">
<link rel="stylesheet" href="<?php echo KL_THEME_URI; ?>/css/page/loading.css"  rel="preload">

<script>
	window.post_id = '<?php echo get_the_ID(); ?>' || ''
	window.post_type = '<?php echo get_post_type($post); ?>' || ''
	if (window.post_type === 'post') {
		window.post_type = 'posts'
	}
</script>
<main id="main" class="main-area main-content pos-r" :class="!isSidebar ? 'w-1': ''" role="main" v-cloak>
	<kl-skeleton v-if="!ifShowSingle" class="article-skeleton" type="single"></kl-skeleton>
	<div id="catalog-content-wrapper"></div>
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
        <div class="entry-tag">
          <el-tag class="ml-10" size="small" type="danger" v-if="posts.sticky">TOP</el-tag>
          <el-tag class="ml-10" size="small" type="danger" v-if="posts.newest">NEW</el-tag>
          <el-tag class="ml-10" size="small" type="danger" v-if="posts.hotest">HOT</el-tag>
          <el-tag class="ml-10" size="small" v-for="(item,index) in posts.post_metas.tag_name" :key="item + index">
            {{item}}
          </el-tag>
          <el-tag type="warning" class="ml-10" size="small" v-for="(item,index) in posts.post_metas.cat_name"
            :key="item + index">
            {{item}}
          </el-tag>
        </div>
				<div id="banner-bg" class="featured-header-image bgc-primary" v-html="posts.post_metas.thumbnail"> </div>
			</div>
			<div class="entry-main">
				<div class="entry-extra flex-hb-vc p-10 ">
					<div class="entry-extra-left flex-hc-vl flex-v">
						<span class="flex-hc-vc fs-12 secondary-color" v-if="posts?.post_count?.text_num"><i class="el-icon-notebook-2 fs-14 mr-5"></i>字数统计 {{posts?.post_count?.text_num}} 字</span>
						<span class="flex-hc-vc fs-12 secondary-color mt-5" v-if="posts?.post_count?.read_time"><i class="el-icon-timer fs-14 mr-5"></i>预计阅读时长 {{posts?.post_count?.read_time}} 分钟</span>
						<span class="flex-hc-vc fs-12 secondary-color cur-p mt-5" @click="showLocation(posts.post_metas.position)" v-if="posts.post_metas.address"> <i class="el-icon-map-location mr-5"></i> {{ posts.post_metas.address }} </p>
					</div>
					<div class="entry-extra-right flex-hr-vc ml-10" style="flex: 1 0 auto;">
						<div class="flex-v flex-hc-vr">
							<span class="fs-12 secondary-color">{{posts.post_metas.author}}</span>
							<el-tooltip class="item" effect="dark" :content="posts.date | formatDateToSecond" placement="bottom">
								<span class="fs-12 secondary-color">{{posts.date | formatDate}}</span>
							</el-tooltip>
						</div>
            <el-avatar shape="square" :size="36"  class="ml-10">{{posts.post_metas.author | formatUserName}}</el-avatar>
					</div>
				</div>
				<div id="entry-content" class="entry-content" v-html="posts.content.rendered"> </div>
			</div>
			<div class="entry-footer flex-hc-vc">
				<template v-if="posts.post_metas.reward === '0' ? false : true">
					<kl-reward title="打赏"></kl-reward>
				</template>
				<template v-if="Number(userID) === Number(posts.author)">
					<el-button circle @click="updatePost()"><i class="el-icon-toilet-paper fs-20" title="更新"></i></el-button>
				</template>
			</div>
		</div>
		<el-dialog :visible.sync="ifShowLocationPopup" fullscreen show-close>
			<div id="location-container" class="location-container"> </div>
			<div class="location-info flex-hc-vc flex-v">
			</div>
		</el-dialog>
	</article>
	<aside class="comment-container mt-10">
		<h3 class="tips-header"><i class="lalaksks lalaksks-pinglun fs-20 mr-10"></i>评论区</h3>
		<template v-if="posts.comment_status === 'open'">
			<quick-comment :post-data="posts"></quick-comment>
		</template>
		<template v-else>
			<el-empty description="暂不开放"></el-empty>
		</template>
	</aside>
</main>

<script type="text/javascript" src="https://webapi.amap.com/maps?v=1.4.15&key=7c7a39e2e07d4245fa9c21dece87bf93&plugin=AMap.Geocoder" defer></script>
<script type="text/javascript" src="<?php echo KL_THEME_URI; ?>/js/component/reward.js" defer></script>
<script type="text/javascript" src="<?php echo KL_THEME_URI; ?>/js/plugin/catalog.js" defer></script>
<script type="text/javascript" src="<?php echo KL_THEME_URI; ?>/js/component/quickCommentItem.js" defer></script>
<script type="text/javascript" src="<?php echo KL_THEME_URI; ?>/js/component/quickComment.js" defer></script>
<script type="text/javascript" src="<?php echo KL_THEME_URI; ?>/js/page/single.js" defer></script>


<?php
// $is_sidebar = boolval(cs_get_option('klausLab_sideBar_switcher'));
// $is_mobile = boolval(is_mobile());
// $is_sidebar && !$is_mobile ? get_sidebar() : ''; 
get_sidebar();
?>

<?php get_footer(); ?>