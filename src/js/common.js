let headerPart = new Vue({
	el: '#header',
	data() {
		return {
			originMenuList: [],
			menuList: [],
			ifShowSearch: false,
			ifShowMenu: false,
			ifMobileDevice: window.ifMobileDevice,
			menuIcon: [
				{ className: 'home', iconName: 'el-icon-house' },
				{ className: 'memory', iconName: 'el-icon-film' },
				{ className: 'link', iconName: 'el-icon-link' },
				{ className: 'archive', iconName: 'el-icon-date' },
				{ className: 'about', iconName: 'el-icon-user' },
			],
		}
	},
	mounted() {
		let sessionFlag =
			window.localStorage.getItem('menuList') &&
			window.localStorage.getItem('baseInfo')
				? true
				: false
		if (!sessionFlag) {
			this.getMenuList()
			this.getBaseInfo()
		} else {
			this.originMenuList = this.menuList = JSON.parse(
				window.localStorage.getItem('menuList')
			)
		}
		window.addEventListener('resize', this.resizeHandler)
		window.isSingle && document.querySelector("#page").addEventListener('scroll', this.scrollHandler)
	},
	destroyed() {
		window.onresize = null
	},
	computed: {
		activeIndex() {
			for (let index = 0; index < this.originMenuList.length; index++) {
				const element = this.originMenuList[index]
				if (window.location.href === element.url) {
					return element.ID
				}
			}
		},
	},
	methods: {
		changeMenu() {
			this.ifShowMenu = !this.ifShowMenu
		},

		getBaseInfo() {
			axios
				.get(`${window.site_url}/wp-json/wp/v2/info`)
				.then((res) => {
					let data = res.data
					window.localStorage.setItem('baseInfo', JSON.stringify(data))
				})
				.catch({})
		},
		getMenuList() {
			axios
				.get(`${window.site_url}/wp-json/wp/v2/menu`)
				.then((res) => {
					this.originMenuList = res.data
					this.menuList = transData(
						res.data,
						'ID',
						'menu_item_parent',
						'children'
					)
					for (let i = 0; i < this.menuList.length; i++) {
						const element = this.menuList[i]
						for (let j = 0; j < this.menuIcon.length; j++) {
							const item = this.menuIcon[j]
							if (item.className === element.classes[0]) {
								element.iconName = item.iconName
							}
						}
					}
					window.localStorage.setItem('menuList', JSON.stringify(this.menuList))
				})
				.catch()
		},
		showSearch() {
			this.ifShowSearch = true
			this.$nextTick(() => {
				this.$refs.searchMain.$refs.searchInput.focus()
			})
		},
		goToPage(route, domain = false, params = '') {
			let url = ''
			url += domain ? `${window.home_url}/${route}` : route
			url += params ? `?${this.convertObj(params)}` : ''
			window.location.href = url
		},
		convertObj(data) {
			var _result = []
			for (var key in data) {
				var value = data[key]
				if (value.constructor == Array) {
					value.forEach(function (_value) {
						_result.push(key + '=' + _value)
					})
				} else {
					_result.push(key + '=' + value)
				}
			}
			return _result.join('&')
		},
		handleCommand(command) {
			if (!command) return
			this.goToPage(command, true)
		},
		closeSearch() {
			this.ifShowSearch = false
		},
		resizeHandler() {
			this.ifMobileDevice = document.body.clientWidth <= 1000 ? true : false
		},
		scrollHandler() {
			const $content = $('#content'),
				$page = $('#page'),
				$window = $(window),
				$catalog = $('#catalog-widget')
			if ($window.width() > 1000 && $content.height() > 2000) {
				if ($page.scrollTop() >= $catalog.offset().top) {
					$('.widget-area .widget-content').addClass('is-fixed')
					$('.widget-area .widget-content').width($('.widget-area').width())
					$('.widget-content .widget')
						.not(':last')
						.addClass('f_o_r ds-none h-0')
						.removeClass('ds-block')
					$('.widget-content .widget:last').css('margin-top', '60px')
				} else if (
					$page.scrollTop() >= 0 &&
					$page.scrollTop() < $catalog.offset().top
				) {
					$('.widget-area .widget-content').removeClass('is-fixed')
					$('.widget-content .widget')
						.not(':last')
						.removeClass('f_o_r ds-none h-0')
						.addClass('ds-block')
					$('.widget-content .widget:last').css('margin-top', '0')
				}
			} else {
				$('.widget-area .widget-content').removeClass('is-fixed animated')
			}

			const scrollY = window.pageYOffset || $page.scrollTop()
			const header = document.querySelector('header')

			scrollY <= window.lastScroll
				? (header.style.top = '0')
				: (header.style.top = '-60px')
			scrollY > 60
				? (header.style.position = 'fixed')
				: (header.style.position = 'relative')
			window.lastScroll = scrollY
		},
	},
})

let footPart = new Vue({
	el: '#footer',
})

// $(document).on("click", ".collapse-btn", function () {
//     var this_ = $(this),
//         this_dom = $(this).parent().parent().siblings(".entry-main").find(".entry-main-excerpt");

//     this_dom.removeClass("hide");
//     this_dom.siblings().addClass("hide");

//     this_.siblings().removeClass("hide").addClass("show");
//     this_.removeClass("show").addClass("hide");
// });

// $(document).on("click", ".expand-btn", function () {
//     var this_ = $(this),
//         this_id = $(this).data("id"),
//         this_action = $(this).data("action"),
//         this_dom = $(this).parent().parent().siblings(".entry-main").find(".entry-main-detail");

//     var req = {
//         action: "preview_post",
//         um_id: this_id,
//         um_action: this_action
//     };
//     $.post(`${window.site_url}/wp-admin/admin-ajax.php`, req, function (res) {
//         var content = res;
//         this_dom.removeClass("hide").html(content);
//         this_dom.siblings().addClass("hide");
//         this_.siblings().removeClass("hide").addClass("show");
//         this_.removeClass("show").addClass("hide");
//     });
// });

// $(document).on("click", "#Addlike", function () {
//     if ($(this).hasClass("actived")) {
//         alert("您已经赞过啦~");
//     } else {
//         $(this).addClass("actived");
//         var z = $(this).data("id"),
//             y = $(this).data("action"),
//             x = $(this).children(".count");
//         var w = {
//             action: "like_post",
//             um_id: z,
//             um_action: y
//         };
//         $.post(`${window.site_url}/wp-admin/admin-ajax.php`, w, function (res) {
//             console.log(res)

//         });
//         return false;
//     }
// });

// 滚动触发事件 (Sidebar固定、Header动画)
// $(".widget-area .widget-content > aside").addClass("animated");
// $(window).scroll(function () {
//     var doc = document,
//         win = window,
//         $scrollBottom = $(doc).height() - $(win).height() - $(win).scrollTop(),
//         $scrollTop = $(win).scrollTop();
//     var direction, header = $(".site-header");

//     // if ($(window).width() > 1000 && $(document).height() > 1500) {
//     //     $(window).resize(function () { $(".widget-area .widget-content").width($(".widget-area").width()); });

//     //     if ($(this).scrollTop() >= 2000) {
//     //         $(".widget-area .widget-content").addClass("is-fixed");
//     //         $(".widget-area .widget-content").width($(".widget-area").width());
//     //         $(".widget_custom_html").removeClass("f_i_r ds-block").addClass("f_o_r ds-none h-0")
//     //         $(".widget_recent_entries").removeClass("f_i_r ds-block").addClass("f_o_r ds-none h-0")
//     //         $(".widget_recent_comments").removeClass("f_i_r ds-block").addClass("f_o_r ds-none h-0")

//     //         $(".widget_categories").removeClass("f_o_r ds-none h-0").addClass("f_i_r ds-block")
//     //         $(".widget_tag_cloud").removeClass("f_o_r ds-none h-0").addClass("f_i_r ds-block")
//     //     } else if ($(this).scrollTop() < 2000 && $(this).scrollTop() > 800) {
//     //         $(".widget-area .widget-content").addClass("is-fixed");
//     //         $(".widget-area .widget-content").width($(".widget-area").width());
//     //         $(".widget_custom_html").removeClass("f_o_r ds-none h-0").addClass("f_i_r ds-block")
//     //         $(".widget_recent_entries").removeClass("f_o_r ds-none h-0").addClass("f_i_r ds-block")
//     //         $(".widget_recent_comments").removeClass("f_o_r ds-none h-0").addClass("f_i_r ds-block")

//     //         $(".widget_categories").removeClass("f_i_r ds-block").addClass("f_o_r ds-none h-0")
//     //         $(".widget_tag_cloud").removeClass("f_i_r ds-block").addClass("f_o_r ds-none h-0")
//     //     } else if ($(this).scrollTop() >= 0 && $(this).scrollTop() < 800) {
//     //         $(".widget-area .widget-content").removeClass("is-fixed");
//     //         $(".widget_custom_html").removeClass("f_o_r ds-none h-0").addClass("ds-block")
//     //         $(".widget_recent_entries").removeClass("f_o_r ds-none h-0").addClass("ds-block")
//     //         $(".widget_recent_comments").removeClass("f_o_r ds-none h-0").addClass("ds-block")

//     //         $(".widget_categories").removeClass("f_o_r ds-none h-0").addClass("ds-block")
//     //         $(".widget_tag_cloud").removeClass("f_o_r ds-none h-0").addClass("ds-block")
//     //     }

//     //     if ($scrollBottom < 80) {
//     //         $(".widget-area .widget-content").addClass("is-bottom")
//     //     } else {
//     //         $(".widget-area .widget-content").removeClass("is-bottom");
//     //     }

//     //     /*滚轮事件只有firefox比较特殊，使用DOMMouseScroll; 其他浏览器使用mousewheel;*/
//     //     document.body.addEventListener("DOMMouseScroll", function (event) {
//     //         direction = event.detail && (event.detail > 0 ? "mousedown" : "mouseup");
//     //     });

//     //     document.body.onmousewheel = function (event) {
//     //         event = event || window.event;
//     //         direction = event.wheelDelta && (event.wheelDelta > 0 ? "mouseup" : "mousedown");
//     //         if (direction == "mouseup" || $scrollTop == 0) {
//     //             header.removeClass("slideOutUp ds-none").addClass("slideInDown ds-block");
//     //         } else {
//     //             header.removeClass("slideInDown ds-block").addClass("slideOutUp ds-none");
//     //         }
//     //     };
//     // } else {
//     //     $(".widget-area .widget-content").removeClass("is-fixed animated");
//     // }
// })

// $(document).on("mouseover mouseout", "img", function (event) {
//     var self = $(this);
//     console.log(self.css("width"), $(this).css("width"))
//     var self_parent = $(this).parent();
//     if (event.type == "mouseover") {
//         self_parent.css({"width":self.css("width"),"height":self.css("height"),"overflow":"hidden","display":"inline-block"})
//         self.addClass("extend-img");
//     } else {
//         self_parent.css({"width":"auto","height":"auto","overflow":"visible"})
//         self.removeClass("extend-img");
//     }
// })
