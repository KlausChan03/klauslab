const header = new Vue({
	el: '#header',
	components:{
		klSkeleton: klSkeleton,
		klSearch: klSearch,
	},
	data() {
		return {
			originMenuList: [],
			menuList: [],
			ifShowSearch: false,
			ifShowMenu: false,
			ifMobileDevice: window.if_mobile_device,
			menuIcon: [
				{ className: 'home', iconName: 'el-icon-house' },
				{ className: 'memory', iconName: 'el-icon-film' },
				{ className: 'link', iconName: 'el-icon-link' },
				{ className: 'archive', iconName: 'el-icon-date' },
				{ className: 'about', iconName: 'el-icon-user' },
			],
			bloginfoName: window.the_bloginfo_name,
			isLogin: window.is_login,
			customLogo: window.the_custom_logo,
			userFullName: window.user_full_name,
			homeUrl: window.home_url
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
		window.is_single && document.querySelector("#page").addEventListener('scroll', this.scrollHandler)
	},
	destroyed() {
		window.onresize = null
	},
	computed: {
		activeIndex() {
			for (let index = 0; index < this.originMenuList.length; index++) {
				const element = this.originMenuList[index]
				if (window.location.href === element.url) {
					return Number(element.ID)
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

const footer= new Vue({
	el: '#footer',
	data() {
		return {
			ifMobileDevice: window.if_mobile_device,
			icpNum: window.icp_num,
			startFullYear: window.start_full_year,
			nowFullYear: window.now_full_year
		}
	},
})

const fixedPart = new Vue({
	el: "#fixed-plugins",
	data() {
			return {
					isLogin: window.is_login,
					searchValue:'',
					ifShowChangeMode: false,
					ifShowSearchFormDialog: false,
					season: "spring",
					mascot: {
							"spring": "sakura",
							"winter": "snow",
					}
			}
	},
	mounted() {
			const self = this
			window.onload = () => {
				this.init()
			}
			// 登录和登出
			var plugins_ = document.querySelector(".fixed-plugins");
			var login_ = document.querySelector(".fp-login");
			var logout_ = document.querySelector(".fp-logout");
			var register_ = document.getElementsByClassName("fp-register")[0];
			if (login_ || logout_) {
					hover(plugins_, function () {
							toggleClass(register_, "show")
					}, function () {
							toggleClass(register_, "hide")
					})
			}

			// 切换背景功能
			let [background_, background_in, background_out] = [document.querySelector(".fp-background"), document.querySelector('.fp-background-in'), document.querySelector('.fp-background-out')];
			background_ && background_.addEventListener('mouseover', function (e) {
					removeClass(background_out, 'hide');
					addClass(background_out, 'show');
					background_out.querySelectorAll('li')[0].onclick = function (event) {
							Animation.closeGravity();
							Animation.closeSnow();
							Animation.snow(self.mascot[self.season], 88);
					}
					background_out.querySelectorAll('li')[0].ondblclick = function (event) {
							Animation.closeSnow();
					}
					background_out.querySelectorAll('li')[1].onclick = function (event) {
							Animation.closeSnow();
							Animation.closeGravity();
							Animation.gravity();
					}
					background_out.querySelectorAll('li')[1].ondblclick = function (event) {
							Animation.closeGravity();
					}
			})

	},
	methods: {
			init() {
					let myDate = new Date();
					let mymonth = myDate.getMonth() + 1;
					let today = dayjs(myDate).format('MM-DD');
					let todayWithYear = dayjs(myDate).format('YYYY-MM-DD')
					let MourningDate = ['04-04', '05-12', '12-13'];
					let ChristmasDate = ['12-24', '12-25'];
					let NewYearDate = ['2021-01-01']
					let _html = document.querySelectorAll('html')[0];
					let _body = document.querySelectorAll('body')[0];
					if (document.getElementsByClassName('widget').length > 0) {
							let _widget_userinfo = document.getElementsByClassName('widget')[0].querySelectorAll('.user-bg')[0];
							for (let index = 0; index < MourningDate.length; index++) {
									if (today === MourningDate[index]) {
											_html.classList.add('mourning')
									}
							}
							for (let index = 0; index < ChristmasDate.length; index++) {
									if (today === ChristmasDate[index]) {
											_widget_userinfo.classList.add('christmas-bg')
									}
							}
							for (let index = 0; index < NewYearDate.length; index++) {
									if (todayWithYear === NewYearDate[index]) {
											_widget_userinfo.classList.add('newYear-bg')
									}
							}
					}

					if (1 < mymonth && mymonth <= 4) {
							this.season = "spring"
					} else if (10 < mymonth || mymonth <= 1) {
							this.season = "winter"
					}
					Animation.snow(this.mascot[this.season], 88);

			},

			showSearchDialog() {
					this.ifShowSearchFormDialog = true
			},


			// 消息推送
			createMessage(message, time = 1000) {
					if ($(".message").length > 0) {
							$(".message").remove();
					}
					$("body").append('<div class="message"><p class="message-info">' + message + '</p></div>');
					setTimeout("$('.message').remove()", time);
			},

	}
})


// 返回顶部
// var backTop = document.getElementsByClassName("fp-gototop")[0];
// if (window.attachEvent) {
//     window.attachEvent("onload", __checkDisplay)
// } else {
//     window.addEventListener("load", __checkDisplay, false)
// }
// backTop.onclick = function () {
//     __backToTop(520);
// }

// /**
//  * 返回顶部效果
//  * @param time 时间单位ms
//  * */
// function __backToTop(time) {
//     time = time || 300;
//     var speed = Math.round(__getPageScrollY() / (time / 10));
//     clearInterval(scrollTopTimer);
//     var scrollTopTimer = setInterval(function () {
//         var beforeTop = __getPageScrollY();

//         if (beforeTop > 0) {
//             if (beforeTop <= speed) {
//                 __getPageScrollY(0);
//             } else {
//                 var resultTop = beforeTop - speed;
//                 __getPageScrollY(resultTop);
//             }
//         } else {
//             clearInterval(scrollTopTimer);
//         }
//     }, 10)
// }

// /**
//  * 获取&&设置-页面垂直滚动值
//  * */
// function __getPageScrollY(top) {
//     if (top || Number(top) == 0) { //设置垂直滚动值
//         if (self.pageYOffset) {
//             self.pageYOffset = Number(top);
//         }
//         if (document.documentElement && document.documentElement.scrollTop) { // Explorer 6 Strict
//             document.documentElement.scrollTop = Number(top);
//         }
//         if (document.body) { // all other Explorers
//             document.body.scrollTop = Number(top);
//         }
//         return true;
//     } else { //获取垂直滚动值
//         var yScroll;
//         if (self.pageYOffset) {
//             yScroll = self.pageYOffset;
//         } else if (document.documentElement && document.documentElement.scrollTop) { // Explorer 6 Strict
//             yScroll = document.documentElement.scrollTop;
//         } else if (document.body) { // all other Explorers
//             yScroll = document.body.scrollTop;
//         }
//         return yScroll;
//     }
// };

// /**
//  * 监听-按钮显示与否
//  * */
// function __checkDisplay() {
//     function __pageScrollY() {
//         var S = document.documentElement.scrollTop || window.pageYOffset || document.body.scrollTop;
//         if (S > 0) {
//             backTop.style.display = "block"
//         } else {
//             backTop.style.display = "none"
//         }
//     }
//     window.onscroll = __pageScrollY;
//     __pageScrollY()
// }




// 搜索功能
// let [search_, search_in, search_out, search_form] = [document.querySelector('.fp-search'), document.querySelector('.fp-search-in'), document.querySelector('.fp-search-out'), document.querySelector('.fp-search-out .search-form')];
// addClass(search_form, 'flex-hc-vc');
// search_.addEventListener('mouseover', function (event) {
//     removeClass(search_out, 'hide');
//     addClass(search_out, 'show');
// })
// search_.addEventListener('mouseout', function (event) {
//     removeClass(search_out, 'show');
//     addClass(search_out, 'hide');
// })

// let [background_, background_in, background_out] = [document.querySelector('.fp-background'), document.querySelector('.fp-background-in'), document.querySelector('.fp-background-out')];
// let [body_dom, body_bg, random_] = [document.getElementsByTagName("body")[0]];
// background_.addEventListener('mouseover', function (event) {
//     removeClass(background_out, 'hide');
//     addClass(background_out, 'show');
//     background_out.querySelectorAll('li')[0].onclick = function (event) {
//         random_ = Math.floor(Math.random() * 6 + 1);
//         setCookie("body_class", `color color-${random_}`);
//         addClass(body_dom, getCookie("body_class"));
//     }
//     background_out.querySelectorAll('li')[1].onclick = function (event) {
//         setCookie("body_class", "");
//         removeClass(body_dom, "color");
//     }
// })
// background_.addEventListener('mouseout', function (event) {
//     removeClass(background_out, 'show');
//     addClass(background_out, 'hide');
// })
// addClass(body_dom, getCookie("body_class"))

// var img = document.getElementsByTagName("img")
// for(let i=0;i++;i<img.length){
//     var imgSrc = img[i].getAttribute("src");
//     console.log(imgSrc)
//     imgSrc = img[i].getAttribute("src").replace(/https:/g, "");
// }


// 繁体简体切换
// var Default_isFT = 0 // 默认是否繁体，0-简体，1-繁体，如果修改默认为繁体下面的所有“繁”、“简”互换
// var StranIt_Delay = 1000 // 翻译延时毫秒（设这个的目的是让网页先流畅的显现出来）
// //转换文本
// function StranText(txt, toFT, chgTxt) {
//     if (txt == "" || txt == null) return ""
//     toFT = toFT == null ? BodyIsFt : toFT
//     if (chgTxt) txt = txt.replace((toFT ? "简" : "繁"), (toFT ? "繁" : "简"))
//     if (toFT) {
//         return Traditionalized(txt)
//     } else {
//         return Simplized(txt)
//     }
// }

// function StranBody(fobj) {
//     if (typeof (fobj) == "object") {
//         var obj = fobj.childNodes
//     } else {
//         var tmptxt = lang_Obj.innerHTML.toString()
//         if (tmptxt.indexOf("简") < 0) {
//             BodyIsFt = 1
//             lang_Obj.innerHTML = StranText(tmptxt, 0, 1)
//             lang_Obj.title = StranText(lang_Obj.title, 0, 1)
//         } else {
//             BodyIsFt = 0
//             lang_Obj.innerHTML = StranText(tmptxt, 1, 1)
//             lang_Obj.title = StranText(lang_Obj.title, 1, 1)
//         }
//         setCookie(JF_cn, BodyIsFt, 7)
//         var obj = document.body.childNodes
//     }
//     for (var i = 0; i < obj.length; i++) {
//         var OO = obj.item(i)
//         if ("||BR|HR|TEXTAREA|".indexOf("|" + OO.tagName + "|") > 0 || OO == lang_Obj) continue;
//         if (OO.title != "" && OO.title != null) OO.title = StranText(OO.title);
//         if (OO.alt != "" && OO.alt != null) OO.alt = StranText(OO.alt);
//         if (OO.tagName == "INPUT" && OO.value != "" && OO.type != "text" && OO.type != "hidden") OO.value = StranText(OO.value);
//         if (OO.nodeType == 3) {
//             OO.data = StranText(OO.data)
//         } else StranBody(OO)
//     }
// }


// function Traditionalized(cc) {
//     var str = '',
//         ss = JTPYStr(),
//         tt = FTPYStr();
//     for (var i = 0; i < cc.length; i++) {
//         if (cc.charCodeAt(i) > 10000 && ss.indexOf(cc.charAt(i)) != -1) str += tt.charAt(ss.indexOf(cc.charAt(i)));
//         else str += cc.charAt(i);
//     }
//     return str;
// }

// function Simplized(cc) {
//     var str = '',
//         ss = JTPYStr(),
//         tt = FTPYStr();
//     for (var i = 0; i < cc.length; i++) {
//         if (cc.charCodeAt(i) > 10000 && tt.indexOf(cc.charAt(i)) != -1) str += ss.charAt(tt.indexOf(cc.charAt(i)));
//         else str += cc.charAt(i);
//     }
//     return str;
// }


// var lang_Obj = document.getElementById("fp-change-lang")
// if (lang_Obj) {
//     var JF_cn = "ft" + self.location.hostname.toString().replace(/\./g, "")
//     var BodyIsFt = getCookie(JF_cn)
//     if (BodyIsFt != "1") BodyIsFt = Default_isFT
//     with(lang_Obj) {
//         if (typeof (document.all) != "object") {
//             href = "javascript:StranBody()"
//         } else {
//             href = "#";
//             onclick = new Function("StranBody();return false")
//         }
//         title = StranText("繁体", 1, 1)
//         innerHTML = StranText(innerHTML, 1, 1)
//     }
//     if (BodyIsFt == "1") {
//         setTimeout("StranBody()", StranIt_Delay)
//     }
// }


// function JTPYStr() {
//     return '皑蔼碍爱翱袄奥坝罢摆败颁办绊帮绑镑谤剥饱宝报鲍辈贝钡狈备惫绷笔毕毙闭边编贬变辩辫鳖瘪濒滨宾摈饼拨钵铂驳卜补参蚕残惭惨灿苍舱仓沧厕侧册测层诧搀掺蝉馋谗缠铲产阐颤场尝长偿肠厂畅钞车彻尘陈衬撑称惩诚骋痴迟驰耻齿炽冲虫宠畴踌筹绸丑橱厨锄雏础储触处传疮闯创锤纯绰辞词赐聪葱囱从丛凑窜错达带贷担单郸掸胆惮诞弹当挡党荡档捣岛祷导盗灯邓敌涤递缔点垫电淀钓调迭谍叠钉顶锭订东动栋冻斗犊独读赌镀锻断缎兑队对吨顿钝夺鹅额讹恶饿儿尔饵贰发罚阀珐矾钒烦范贩饭访纺飞废费纷坟奋愤粪丰枫锋风疯冯缝讽凤肤辐抚辅赋复负讣妇缚该钙盖干赶秆赣冈刚钢纲岗皋镐搁鸽阁铬个给龚宫巩贡钩沟构购够蛊顾剐关观馆惯贯广规硅归龟闺轨诡柜贵刽辊滚锅国过骇韩汉阂鹤贺横轰鸿红后壶护沪户哗华画划话怀坏欢环还缓换唤痪焕涣黄谎挥辉毁贿秽会烩汇讳诲绘荤浑伙获货祸击机积饥讥鸡绩缉极辑级挤几蓟剂济计记际继纪夹荚颊贾钾价驾歼监坚笺间艰缄茧检碱硷拣捡简俭减荐槛鉴践贱见键舰剑饯渐溅涧浆蒋桨奖讲酱胶浇骄娇搅铰矫侥脚饺缴绞轿较秸阶节茎惊经颈静镜径痉竞净纠厩旧驹举据锯惧剧鹃绢杰洁结诫届紧锦仅谨进晋烬尽劲荆觉决诀绝钧军骏开凯颗壳课垦恳抠库裤夸块侩宽矿旷况亏岿窥馈溃扩阔蜡腊莱来赖蓝栏拦篮阑兰澜谰揽览懒缆烂滥捞劳涝乐镭垒类泪篱离里鲤礼丽厉励砾历沥隶俩联莲连镰怜涟帘敛脸链恋炼练粮凉两辆谅疗辽镣猎临邻鳞凛赁龄铃凌灵岭领馏刘龙聋咙笼垄拢陇楼娄搂篓芦卢颅庐炉掳卤虏鲁赂禄录陆驴吕铝侣屡缕虑滤绿峦挛孪滦乱抡轮伦仑沦纶论萝罗逻锣箩骡骆络妈玛码蚂马骂吗买麦卖迈脉瞒馒蛮满谩猫锚铆贸么霉没镁门闷们锰梦谜弥觅绵缅庙灭悯闽鸣铭谬谋亩钠纳难挠脑恼闹馁腻撵捻酿鸟聂啮镊镍柠狞宁拧泞钮纽脓浓农疟诺欧鸥殴呕沤盘庞国爱赔喷鹏骗飘频贫苹凭评泼颇扑铺朴谱脐齐骑岂启气弃讫牵扦钎铅迁签谦钱钳潜浅谴堑枪呛墙蔷强抢锹桥乔侨翘窍窃钦亲轻氢倾顷请庆琼穷趋区躯驱龋颧权劝却鹊让饶扰绕热韧认纫荣绒软锐闰润洒萨鳃赛伞丧骚扫涩杀纱筛晒闪陕赡缮伤赏烧绍赊摄慑设绅审婶肾渗声绳胜圣师狮湿诗尸时蚀实识驶势释饰视试寿兽枢输书赎属术树竖数帅双谁税顺说硕烁丝饲耸怂颂讼诵擞苏诉肃虽绥岁孙损笋缩琐锁獭挞抬摊贪瘫滩坛谭谈叹汤烫涛绦腾誊锑题体屉条贴铁厅听烃铜统头图涂团颓蜕脱鸵驮驼椭洼袜弯湾顽万网韦违围为潍维苇伟伪纬谓卫温闻纹稳问瓮挝蜗涡窝呜钨乌诬无芜吴坞雾务误锡牺袭习铣戏细虾辖峡侠狭厦锨鲜纤咸贤衔闲显险现献县馅羡宪线厢镶乡详响项萧销晓啸蝎协挟携胁谐写泻谢锌衅兴汹锈绣虚嘘须许绪续轩悬选癣绚学勋询寻驯训讯逊压鸦鸭哑亚讶阉烟盐严颜阎艳厌砚彦谚验鸯杨扬疡阳痒养样瑶摇尧遥窑谣药爷页业叶医铱颐遗仪彝蚁艺亿忆义诣议谊译异绎荫阴银饮樱婴鹰应缨莹萤营荧蝇颖哟拥佣痈踊咏涌优忧邮铀犹游诱舆鱼渔娱与屿语吁御狱誉预驭鸳渊辕园员圆缘远愿约跃钥岳粤悦阅云郧匀陨运蕴酝晕韵杂灾载攒暂赞赃脏凿枣灶责择则泽贼赠扎札轧铡闸诈斋债毡盏斩辗崭栈战绽张涨帐账胀赵蛰辙锗这贞针侦诊镇阵挣睁狰帧郑证织职执纸挚掷帜质钟终种肿众诌轴皱昼骤猪诸诛烛瞩嘱贮铸筑驻专砖转赚桩庄装妆壮状锥赘坠缀谆浊兹资渍踪综总纵邹诅组钻致钟么为只凶准启板里雳余链泄';
// }

// function FTPYStr() {
//     return '皚藹礙愛翺襖奧壩罷擺敗頒辦絆幫綁鎊謗剝飽寶報鮑輩貝鋇狽備憊繃筆畢斃閉邊編貶變辯辮鼈癟瀕濱賓擯餅撥缽鉑駁蔔補參蠶殘慚慘燦蒼艙倉滄廁側冊測層詫攙摻蟬饞讒纏鏟産闡顫場嘗長償腸廠暢鈔車徹塵陳襯撐稱懲誠騁癡遲馳恥齒熾沖蟲寵疇躊籌綢醜櫥廚鋤雛礎儲觸處傳瘡闖創錘純綽辭詞賜聰蔥囪從叢湊竄錯達帶貸擔單鄲撣膽憚誕彈當擋黨蕩檔搗島禱導盜燈鄧敵滌遞締點墊電澱釣調叠諜疊釘頂錠訂東動棟凍鬥犢獨讀賭鍍鍛斷緞兌隊對噸頓鈍奪鵝額訛惡餓兒爾餌貳發罰閥琺礬釩煩範販飯訪紡飛廢費紛墳奮憤糞豐楓鋒風瘋馮縫諷鳳膚輻撫輔賦複負訃婦縛該鈣蓋幹趕稈贛岡剛鋼綱崗臯鎬擱鴿閣鉻個給龔宮鞏貢鈎溝構購夠蠱顧剮關觀館慣貫廣規矽歸龜閨軌詭櫃貴劊輥滾鍋國過駭韓漢閡鶴賀橫轟鴻紅後壺護滬戶嘩華畫劃話懷壞歡環還緩換喚瘓煥渙黃謊揮輝毀賄穢會燴彙諱誨繪葷渾夥獲貨禍擊機積饑譏雞績緝極輯級擠幾薊劑濟計記際繼紀夾莢頰賈鉀價駕殲監堅箋間艱緘繭檢堿鹼揀撿簡儉減薦檻鑒踐賤見鍵艦劍餞漸濺澗漿蔣槳獎講醬膠澆驕嬌攪鉸矯僥腳餃繳絞轎較稭階節莖驚經頸靜鏡徑痙競淨糾廄舊駒舉據鋸懼劇鵑絹傑潔結誡屆緊錦僅謹進晉燼盡勁荊覺決訣絕鈞軍駿開凱顆殼課墾懇摳庫褲誇塊儈寬礦曠況虧巋窺饋潰擴闊蠟臘萊來賴藍欄攔籃闌蘭瀾讕攬覽懶纜爛濫撈勞澇樂鐳壘類淚籬離裏鯉禮麗厲勵礫曆瀝隸倆聯蓮連鐮憐漣簾斂臉鏈戀煉練糧涼兩輛諒療遼鐐獵臨鄰鱗凜賃齡鈴淩靈嶺領餾劉龍聾嚨籠壟攏隴樓婁摟簍蘆盧顱廬爐擄鹵虜魯賂祿錄陸驢呂鋁侶屢縷慮濾綠巒攣孿灤亂掄輪倫侖淪綸論蘿羅邏鑼籮騾駱絡媽瑪碼螞馬罵嗎買麥賣邁脈瞞饅蠻滿謾貓錨鉚貿麽黴沒鎂門悶們錳夢謎彌覓綿緬廟滅憫閩鳴銘謬謀畝鈉納難撓腦惱鬧餒膩攆撚釀鳥聶齧鑷鎳檸獰甯擰濘鈕紐膿濃農瘧諾歐鷗毆嘔漚盤龐國愛賠噴鵬騙飄頻貧蘋憑評潑頗撲鋪樸譜臍齊騎豈啓氣棄訖牽扡釺鉛遷簽謙錢鉗潛淺譴塹槍嗆牆薔強搶鍬橋喬僑翹竅竊欽親輕氫傾頃請慶瓊窮趨區軀驅齲顴權勸卻鵲讓饒擾繞熱韌認紉榮絨軟銳閏潤灑薩鰓賽傘喪騷掃澀殺紗篩曬閃陝贍繕傷賞燒紹賒攝懾設紳審嬸腎滲聲繩勝聖師獅濕詩屍時蝕實識駛勢釋飾視試壽獸樞輸書贖屬術樹豎數帥雙誰稅順說碩爍絲飼聳慫頌訟誦擻蘇訴肅雖綏歲孫損筍縮瑣鎖獺撻擡攤貪癱灘壇譚談歎湯燙濤縧騰謄銻題體屜條貼鐵廳聽烴銅統頭圖塗團頹蛻脫鴕馱駝橢窪襪彎灣頑萬網韋違圍爲濰維葦偉僞緯謂衛溫聞紋穩問甕撾蝸渦窩嗚鎢烏誣無蕪吳塢霧務誤錫犧襲習銑戲細蝦轄峽俠狹廈鍁鮮纖鹹賢銜閑顯險現獻縣餡羨憲線廂鑲鄉詳響項蕭銷曉嘯蠍協挾攜脅諧寫瀉謝鋅釁興洶鏽繡虛噓須許緒續軒懸選癬絢學勳詢尋馴訓訊遜壓鴉鴨啞亞訝閹煙鹽嚴顔閻豔厭硯彥諺驗鴦楊揚瘍陽癢養樣瑤搖堯遙窯謠藥爺頁業葉醫銥頤遺儀彜蟻藝億憶義詣議誼譯異繹蔭陰銀飲櫻嬰鷹應纓瑩螢營熒蠅穎喲擁傭癰踴詠湧優憂郵鈾猶遊誘輿魚漁娛與嶼語籲禦獄譽預馭鴛淵轅園員圓緣遠願約躍鑰嶽粵悅閱雲鄖勻隕運蘊醞暈韻雜災載攢暫贊贓髒鑿棗竈責擇則澤賊贈紮劄軋鍘閘詐齋債氈盞斬輾嶄棧戰綻張漲帳賬脹趙蟄轍鍺這貞針偵診鎮陣掙睜猙幀鄭證織職執紙摯擲幟質鍾終種腫衆謅軸皺晝驟豬諸誅燭矚囑貯鑄築駐專磚轉賺樁莊裝妝壯狀錐贅墜綴諄濁茲資漬蹤綜總縱鄒詛組鑽緻鐘麼為隻兇準啟闆裡靂餘鍊洩';
// }

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
