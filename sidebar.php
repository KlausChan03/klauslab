<?php

/**
 * The sidebar containing the main widget areas.
 *
 * @package KlausLab
 */
?>


<style>
	.widget-area .widget .widget-user-container .user-info-main {
		padding: 1.0rem 1.6rem;
		/* margin-top: 50px; */
	}

	.widget-area .widget .widget-user-container .user-bg,
	.widget-area .widget .widget-user-container .user-bg {
		height: 120px;
	}

	.col-b2bbbe {
		color: #b2bbbe;
	}

	<?php
	$memorybg = cs_get_option('memory_background');
	if ($memorybg != null) {
		if (isset($memorybg["image"]) && $memorybg["image"] != '') { ?>#secondary .user-bg {
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

<div id="secondary" class="widget-area sidebar" role="complementary">
	<div class="widget-content">
		<?php dynamic_sidebar('sidebar-1'); ?>
	</div>
</div>
<!-- #secondary -->

<script>
	let secondaryPart = new Vue({
		el: '#secondary',
		mounted: function() {
			let blog_create_time, our_love_time, our_info, photo_container = document.querySelector('.photo-container');
			let _this = this
			// const h = this.$createElement;
			let params = new FormData;
			params.append('action', 'love_time');
			axios.post(`${window.site_url}/wp-admin/admin-ajax.php`, params).then((res) => {
				blog_create_time = res.data[0].user_registered; // 博客建立时间（根据第一个用户诞生时间）
				our_love_time = `2015-05-23 20:00:00`; // 恋爱时间
				our_info = [res.data[1].nickname, res.data[1].img, res.data[2].nickname, res.data[2].img];
				if (photo_container) {
					photo_container.innerHTML = ` <span class="m-lr-10">${res.data[1].img}</span> <i class="lalaksks lalaksks-ic-heart-2 throb"></i> <span class="m-lr-10">${res.data[2].img}</span> `;
				}
				if (document.getElementById("createtime")) {
					window.showCreateTime = setInterval(() => {
						_this.kl_count(blog_create_time, '#createtime', '它已经运作了')
					}, 1000);
				}
				if (document.getElementById("lovetime")) {
					window.showLoveTime = setInterval(() => {
						_this.kl_count(our_love_time, '#lovetime', '他与她相恋了')
					}, 1000);
				}

			})
		},
		methods: {
			kl_count(_time, _dom, _content) {
				if (_time) {
					_time = _time.replace(/-/g, "/");
					// 计算出相差毫秒
					var create_time = new Date(_time);
					var now_time = new Date();
					var count_time = now_time.getTime() - create_time.getTime()

					//计算出相差天数
					var days = Math.floor(count_time / (24 * 3600 * 1000))

					//计算出相差小时数
					var leave = count_time % (24 * 3600 * 1000)
					var hours = Math.floor(leave / (3600 * 1000))
					hours = hours >= 10 ? hours : "0" + hours

					//计算相差分钟数
					var leave = leave % (3600 * 1000)
					var minutes = Math.floor(leave / (60 * 1000))
					minutes = minutes >= 10 ? minutes : "0" + minutes


					//计算相差秒数
					var leave = leave % (60 * 1000)
					var seconds = Math.round(leave / 1000)
					seconds = seconds >= 10 ? seconds : "0" + seconds

					var _time = days + " 天 " + hours + " 时 " + minutes + " 分 " + seconds + " 秒 ";
					var _final = _content + _time;
					document.querySelector(_dom).innerHTML = _final;
				}
			}
		},
	})
</script>