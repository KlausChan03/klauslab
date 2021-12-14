dayjs.locale('zh-cn')
dayjs.extend(window.dayjs_plugin_relativeTime)
dayjs.extend(window.dayjs_plugin_localizedFormat)
const orderbyList = [
    {
        type: 'date',
        name: '创建时间',
    },
    {
        type: 'modified',
        name: '更新时间',
    },
];
const per_page = Math.min(window.ifMobileDevice === true ? 6 : 10, window.wp_count_posts)
const typeMap = {
	'article': 'post',
	'chat': 'chat'
}
const index_module = new Vue({
	el: '.main-content',
	mixins: [filterMixin],
	data() {
		return {
			listOfAll: [],
			listOfArticle: [],
			listOfChat: [],
			listOfRecommend: [],
			total: 0,
			totalOfArticle: 0,
			totalOfChat: 0,
			ifShowPost: false,
			ifShowChat: false,
			ifShowAll: true,
			ifMobileDevice: window.ifMobileDevice,
			page: 1,
			per_page: {
				'article': window.ifMobileDevice === true ? 6 : 10,
				'chat': window.ifMobileDevice === true ? 6 : 10
			},
			postType: 'article',
			posts_id_sticky: '',
			orderby: 'date',
			currentCommentId: '',
			imgList: [],
			imageUrl: '',
			imageUrls: [],
		}
	},

	async created() {
		await this.getPostCount(this.postType)
		
		
	},
	mounted() {
		window.addEventListener('resize', this.resizeHandler)
	},
	computed: {
		getOrderby() {
			let self = this
			let _item = orderbyList.filter((item) => {
				return item.type === self.orderby
			})
			return _item[0].name
		},
		getTotal() {
			if (this.postType === 'article') {
				return this.totalOfArticle
			} else if (this.postType === 'chat') {
				return this.totalOfChat
			} else if (this.postType === 'all') {
				return this.total
			} else if (this.postType === 'recommend') {
				return this.listOfRecommend.length
			}
		},
		judgeCount() {
			if (this.postType === 'article') {
				return this.listOfArticle.length > this.per_page
			} else if (this.postType === 'chat') {
				return this.listOfChat.length > this.per_page
			} else if (this.postType === 'all') {
				return this.listOfAll.length > this.per_page
			} else if (this.postType === 'recommend') {
				return true
			}
			return true
		},
		getPaperSize() {
			return this.ifMobileDevice === true ? 3 : 8
		},
	},

	methods: {
		getPostCount (type) {
			axios
			.get(`${window.site_url}/wp-json/wp/v2/getPostCount`, {
				params: {type: typeMap[type]},
			})
			.then((res) => {
				this.per_page[this.postType] = Math.min(res.data.count, this.per_page[this.postType])
				if (this.per_page[this.postType]!== 0) {
					this.postType === 'article'
					?  this.getAllArticles()
					:  this.getAllChat()
				} else {
					
				}
			})
		},
		getAllTypePost() {
			let self = this
			self.per_page = self.per_page / 2
			self.ifShowAll = true
			self.total = 0
			axios.all([this.getAllArticles(), this.getAllChat()]).then(
				axios.spread(function () {
					self.listOfAll = self.listOfArticle.concat(self.listOfChat)
					self.listOfAll = self.listOfAll.sort((a, b) => {
						return new Date(b.date).getTime() - new Date(a.date).getTime()
					})
					self.ifShowAll = false
					self.per_page = self.per_page * 2
					self.total = self.totalOfArticle + self.totalOfChat
				})
			)
		},

		getTypeOfRecommend() {
			let self = this
			this.ifShowAll = true
			let params = {}
			params.per_page = self.per_paget
			params.sticky = true
			return axios
				.get(`${window.site_url}/wp-json/wp/v2/posts`, {
					params: params,
				})
				.then((res) => {
					this.listOfRecommend = res.data
					this.ifShowAll = false
				})
		},

		getAllArticles() {
			this.ifShowPost = true
			let params = {}
			params.page = this.page
			params.per_page = this.per_page[this.postType]
			params.orderby = this.orderby
			if (this.page === 1) {
				axios
					.get(`${window.site_url}/wp-json/wp/v2/posts?sticky=true`, {
						params: params,
					})
					.then((res_sticky) => {
						this.listOfArticle = res_sticky.data
						//获取顶置文章 IDs 以在获取其余文章时排除
						for (var s = 0; s < this.listOfArticle.length; ++s) {
							this.posts_id_sticky += ',' + this.listOfArticle[s].id
						}
						this.ifShowPost = false
						params.per_page = this.per_page[this.postType] - this.listOfArticle.length
						params.exclude = this.posts_id_sticky
						axios
							.get(`${window.site_url}/wp-json/wp/v2/posts`, {
								params: params,
							})
							.then((res) => {
								this.totalOfArticle = parseInt(res.headers['x-wp-total'])
								this.listOfArticle = this.listOfArticle.concat(res.data)
								this.listOfArticle.forEach((element) => {
									element.ifShowAll = false
									element.ifShowComment = false
									if (
										element.date &&
										Number(
											dayjs(new Date()).diff(dayjs(element.date), 'week')
										) === 0
									) {
										element.newest = true
									}
									if (
										element.post_metas.comments_num >= 10 ||
										element.post_metas.zan_num >= 10
									) {
										element.hotest = true
									}
								})
								this.$nextTick(() => {
									this.bindImagesLayer()
								})
							})
					})
			} else {
				axios
					.get(
						`${window.site_url}/wp-json/wp/v2/posts?sticky=false&exclude=${this.posts_id_sticky}`,
						{
							params: params,
						}
					)
					.then((res) => {
						this.totalOfArticle = parseInt(res.headers['x-wp-total'])
						this.listOfArticle = res.data
						this.ifShowPost = false
						this.listOfArticle.forEach((element) => {
							element.ifShowAll = false
							element.ifShowComment = false
							if (
								element.date &&
								Number(dayjs(new Date()).diff(dayjs(element.date), 'week')) ===
									0
							) {
								element.newest = true
							}
							if (
								element.post_metas.comments_num >= 10 ||
								element.post_metas.zan_num >= 10
							) {
								element.hotest = true
							}
						})
					})
			}
		},

		getAllChat() {
			this.ifShowChat = true
			let params = {}
			params.page = this.page
			params.per_page = this.per_page[this.postType]
			params.orderby = this.orderby
			axios
				.get(`${window.site_url}/wp-json/wp/v2/moments`, {
					params: params,
				})
				.then((res) => {
					this.totalOfChat = parseInt(res.headers['x-wp-total'])
					this.listOfChat = res.data
					this.ifShowChat = false
					this.listOfChat.forEach((element) => {
						element.ifShowComment = false
						if (
							element.date &&
							Number(dayjs(new Date()).diff(dayjs(element.date), 'week')) === 0
						) {
							element.newest = true
						}
						if (
							element.post_metas.comments_num >= 10 ||
							element.post_metas.zan_num >= 10
						) {
							element.hotest = true
						}
						if (element.content.rendered.indexOf('img') > 0) {
							element.content.rendered = element.content.rendered.replace(
								/(flex-hb-vc)/g,
								'flex'
							)
						}
					})
					this.$nextTick(() => {
						this.bindImagesLayer()
					})
				})
		},

		handleCurrentChange(val) {
			this.page = val
			this.getListByType(this.postType)
			this.$nextTick(() => {
				document.querySelectorAll('#page')[0].scrollTop = 0
			})
		},

		changeType(tab, event) {
			this.page = 1
			this.postType = tab.label
            this.totalOfArticle = 0
			this.getListByType(this.postType)
		},

		getListByType(type) {
			if (type === 'article') {
				this.getAllArticles()
			} else if (type === 'chat') {
				this.getAllChat()
			} else if (type === 'all') {
				this.getAllTypePost()
			} else if (type === 'recommend') {
				this.getTypeOfRecommend()
			}
		},

		changeItemType(id) {
			this.listOfArticle.forEach((item) => {
				if (item.id === id) {
					item.ifShowAll = !item.ifShowAll
				}
			})
			this.listOfArticle.splice(0, 0)
		},

		showItemComment(id) {
			let self = this
			this[
				this.postType === 'article' ? 'listOfArticle' : 'listOfChat'
			].forEach((element, index) => {
				if (element.id === id) {
					// this.currentCommentId = id
					if (element.ifShowComment === false) {
						element.ifShowComment = true
						this.$nextTick(() => {
							setTimeout(() => {
								this.$refs['quickComment-' + id][0].getListOfComment(id)
							}, 20)
						})
					} else {
						element.ifShowComment = false
					}
				} else {
					element.ifShowComment = false
				}

				this.$forceUpdate()
			})
		},

		handleCommand(type) {
			this.orderby = type
			let self = this
			let getList = () => {
				self.getListByType(self.postType)
			}
			getList()
		},

		resizeHandler() {
			this.ifMobileDevice = document.body.clientWidth <= 1000 ? true : false
		},

		bindImagesLayer() {
			let self = this
			let imgList = document.querySelectorAll('.entry-summary img')
			for (let index = 0; index < imgList.length; index++) {
				const element = imgList[index]
				element &&
					element.addEventListener('click', function () {
						event.preventDefault()
						self.imageUrls = []
						let url = element.getAttribute('src')
						debugger
						if (!self.imageUrls.includes(url)) {
							self.imageUrls.push(url)
						}
						self.$nextTick(() => {
							self.imageUrl = url
						})
						setTimeout(() => {
							document.querySelectorAll('.image-part img')[0].click()
						}, 100)
					})
			}
		},
	},
})
