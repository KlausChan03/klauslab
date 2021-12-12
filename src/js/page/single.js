dayjs.locale('zh-cn')
dayjs.extend(window.dayjs_plugin_relativeTime)

const index_module = new Vue({
	el: '.main-content',
	mixins: [filterMixin],
	data() {
		return {
			ifShowSingle: false,
			ifMobileDevice: window.ifMobileDevice,
      ifShowLocationPopup: false,
			post_id: window.post_id,
			posts: {
				post_metas: {
					zan_num: 0,
					comments_num: 0,
				},
			},
			listOfComment: '',
			commentPage: 1,
		}
	},
	created() {
		this.getAllArticles()
	},
	mounted() {
		const self = this
		window.onload = function () {

			const copyButtons = document.querySelectorAll('.copy-code-btn')
			for (let index = 0; index < copyButtons.length; index++) {
				const element = copyButtons[index]
				element.addEventListener('click', function(){
					const content = element.parentElement.outerText.replace('复制代码','')
					const textarea = document.createElement('textarea');
					textarea.textContent = content
					document.body.appendChild(textarea);
					if (document.execCommand('copy')) {
						textarea.select();
						document.execCommand('copy');
					} else {
						const selection = document.getSelection();
						const range = document.createRange();
						range.selectNode(textarea);
						selection.removeAllRanges();
						selection.addRange(range);                  
						selection.removeAllRanges(); 
					}				

					document.body.removeChild(textarea);
					self.$message({
							type: 'success',
							message: "复制成功",
					})
				})
			}
		}
	},
	updated() {
		let self = this
		let imgList = document.querySelectorAll('.entry-content img')
		for (let index = 0; index < imgList.length; index++) {
			const element = imgList[index]
			element.addEventListener('click', function (e) {
				e.preventDefault()
				self.$alert(`<div class="p-10 flex-hc-vc">${element.outerHTML}</div>`, {
					dangerouslyUseHTMLString: true,
					closeOnClickModal: true,
					closeOnPressEscape: true,
					showConfirmButton: false,
				})
			})
		}
	},
	methods: {

		showLocation (position) {
      const positionArr = position.split(',')
      this.ifShowLocationPopup = true
      this.$nextTick(() => {
				const map = new AMap.Map('location-container', {
					resizeEnable: true,
          zoom: 16,
          center: positionArr,
				})
				const marker = new AMap.Marker();
        map.add(marker);
        marker.setPosition(positionArr);				
			})
    },
		
		getAllArticles() {
			this.ifShowSingle = false
			let params = {}
			return axios
				.get(`${window.site_url}/wp-json/wp/v2/posts/${this.post_id}`, {
					params: params,
				})
				.then((res) => {
					this.$nextTick(() => {
						this.ifShowSingle = true
						this.posts = res.data
					})
				})
		},

		goAnchor(selector) {
			const anchor = this.$el.querySelector(selector) // 参数为要跳转到的元素id
			this.$nextTick(() => {
				document.documentElement.scrollTop = anchor.offsetTop // firefox
				document.querySelectorAll('#page')[0].scrollTop = anchor.offsetTop
			})
		},

		updatePost() {
			this.goToPage('page-post-simple', true, {
				type: 'modified',
				id: this.post_id,
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

		likeOrDislikePost(item, action) {
			let params = {}
			params.id = item.id
			params.action = action
			if (item.post_metas.has_zan || item.post_metas.has_cai) {
				this.$message({
					message: '你已经评价过！',
					type: 'warning',
				})
				return false
			}
			if (action === 'dislike') {
				this.$confirm('点踩会打击作者的创作积极性, 是否继续?', '提示', {
					confirmButtonText: '确定',
					cancelButtonText: '取消',
					type: 'warning',
				})
					.then(() => {
						axios
							.post(`${window.site_url}/wp-json/wp/v2/likePost`, params, {
								headers: {
									'X-WP-Nonce': _nonce,
								},
							})
							.then((res) => {
								this.$nextTick(() => {
									console.log(this.posts.post_metas)
									this.$set(
										this.posts.post_metas,
										action === 'like' ? 'zan_num' : 'cai_num',
										res.data
									)
									this.$set(
										this.posts.post_metas,
										action === 'like' ? 'has_zan' : 'has_cai',
										true
									)
									this.$message({
										message: action === 'like' ? '点赞成功！' : '点踩成功！',
										type: 'success',
									})
								})
							})
					})
					.catch(() => {
						return false
					})
			} else {
				axios
					.post(`${window.site_url}/wp-json/wp/v2/likePost`, params, {
						headers: {
							'X-WP-Nonce': _nonce,
						},
					})
					.then((res) => {
						this.$nextTick(() => {
							console.log(this.posts.post_metas)
							this.$set(
								this.posts.post_metas,
								action === 'like' ? 'zan_num' : 'cai_num',
								res.data
							)
							this.$set(
								this.posts.post_metas,
								action === 'like' ? 'has_zan' : 'has_cai',
								true
							)
							this.$message({
								message: action === 'like' ? '点赞成功！' : '点踩成功！',
								type: 'success',
							})
						})
					})
			}
		},
	},
})
