<?php

/**
 * The sidebar containing the main widget areas.
 *
 * @package KlausLab
 */
?>
<style>
		<?php
		$memorybg = cs_get_option('memory_background');
		if ($memorybg != null) {
			if (isset($memorybg["image"]) && $memorybg["image"] != '') { ?>
			#secondary .user-bg {
			background-image: url(<?php echo $memorybg["image"]; ?>);
			background-position: <?php echo $memorybg["position"]; ?>;
			background-repeat: <?php echo $memorybg["repeat"]; ?>;
			background-attachment: <?php if ($memorybg["attachment"] == '') echo 'scroll';
									else echo $memorybg["attachment"]; ?>;
			background-size: <?php echo $memorybg["size"]; ?>;
		}

		<?php } else { ?>.user-bg {
			background: <?php echo $memorybg["color"]; ?>;
		}

		<?php }
		}
		?>
	</style>
<style>
	.widget-area .widget .widget-user-container .user-info-main {
		padding: 1.0rem 1.6rem;
		/* margin-top: 50px; */
	}

	.widget-area .widget .widget-user-container .user-bg,
	.widget-area .widget .widget-user-container .user-bg {
		height: 120px;
	}
</style>

<div id="secondary" class="widget-area sidebar" role="complementary" v-block>
	<kl-skeleton v-show="!ifShowSidebar" type="post"></kl-skeleton>
	<div v-show="ifShowSidebar" class="widget-content">
		<?php dynamic_sidebar('sidebar-1'); ?>
	</div>
</div>
<!-- #secondary -->
<script type="text/javascript" src="<?php echo KL_THEME_URI; ?>/js/component/skeleton.js" defer></script>
<script type="text/javascript" src="<?php echo KL_THEME_URI; ?>/js/page/sideBar.js" defer></script>
