new Vue({
	el: '#post-page',
	components: {
		editor: Editor, // <- Important part
	},
	computed: {
		tagNameList() {
			let tagNameList = []
			if(Array.isArray(this.posts.tags) && this.posts.tags.length > 0) {
				for (let i = 0; i < this.tagList.length; i++) {
					for (let j = 0; j < this.posts.tags.length; j++) {
						if (this.posts.tags[j] === this.tagList[i].id) {
							tagNameList.push(this.tagList[i].name)
						}
					}
				}
			}

			return tagNameList
		},
		categoryNameList() {
			let categoryNameList = []
			if(Array.isArray(this.posts.categories) && this.posts.categories.length > 0) {
				for (let i = 0; i < this.categoryListOrigin.length; i++) {
					for (let j = 0; j < this.posts.categories.length; j++) {
						if (this.posts.categories[j] === this.categoryListOrigin[i].id) {
							categoryNameList.push(this.categoryListOrigin[i].name)
						}
					}
				}
			}
			return categoryNameList
		},
	},
	data() {
		const ide = Date.now()
		return {
			siteUrl: window.site_url,
			nonce: window._nonce,
			post_id: '',
			editorLoading: false,
			status: true,
			type: 'create',
			post_type: '',
			format: true,
			posts: {
				type: 'moments',
				title: '',
				content: '',
				status: 'publish',
				tags: [],
				categories: [],
				post_metas: {
					reward: true,
					location: false,
					address: '',
					position: '',
				},
			},
			ifShowLocationPopup: false,
			location: {},
			pictureList: [],
			tagList: [],
			categoryList: [],
			categoryListOrigin: [],
			defaultProps: {
				children: 'children',
				label: 'name',
			},
			hasCommitFinish: false,
			dialogImageUrl: '',
			dialogVisible: false,
			disabled: false,
			toolbar_simple: ['undo redo | emoticons'],
			toolbar_default: [
				'bold italic underline strikethrough blockquote|forecolor backcolor|formatselect | fontsizeselect  | alignleft aligncenter alignright alignjustify | outdent indent |codeformat blockformats| removeformat undo redo bullist numlist toc pastetext | codesample charmap  hr insertdatetime | lists image media table link unlink anchor | emoticons |code searchreplace fullscreen help ',
			],
			defaultInit: {
				language: 'zh_CN', //语言设置
				height: 360, //高度
				menubar: false, // 隐藏最上方menu菜单
				toolbar: true, //false禁用工具栏（隐藏工具栏）
				browser_spellcheck: true, // 拼写检查
				branding: false, // 去水印
				statusbar: false, // 隐藏编辑器底部的状态栏
				elementpath: false, //禁用下角的当前标签路径
				paste_data_images: true, // 允许粘贴图像
				toolbar: ['undo redo | emoticons'],
				// toolbar:  ['bold italic underline strikethrough blockquote|forecolor backcolor|formatselect | fontsizeselect  | alignleft aligncenter alignright alignjustify | outdent indent |codeformat blockformats| removeformat undo redo bullist numlist toc pastetext | codesample charmap  hr insertdatetime | lists image media table link unlink | emoticons |code searchreplace fullscreen help ' ],
				plugins:
					'emoticons lists image media table wordcount code fullscreen help codesample toc insertdatetime  searchreplace  link charmap paste hr anchor textpattern',
				textpattern_patterns: [
					{ start: '*', end: '*', format: 'italic' },
					{ start: '**', end: '**', format: 'bold' },
					{ start: '#', format: 'h1' },
					{ start: '##', format: 'h2' },
					{ start: '###', format: 'h3' },
					{ start: '####', format: 'h4' },
					{ start: '#####', format: 'h5' },
					{ start: '######', format: 'h6' },
					{ start: '1. ', cmd: 'InsertOrderedList' },
					{ start: '* ', cmd: 'InsertUnorderedList' },
					{ start: '- ', cmd: 'InsertUnorderedList' },
				],
			},
		}
	},
	mounted() {
		let urlParams = this.urlToObj(window.location.href)
		if (urlParams.id) {
			this.post_id = urlParams.id
			this.post_type = urlParams.type
			this.getArticleContent()
			this.type = 'update'
		}

		this.init()
	},
	methods: {
		init() {
			const self = this
			self.editorLoading = true
			window.tinymce.init({
				// 默认配置
				...this.defaultInit,
				// 初始化完成
				init_instance_callback: function (editor) {
					self.editorLoading = false
				},
				// 图片上传
				images_upload_handler: function (blobInfo, success, failure) {
					let formData = new FormData()
					formData.append('file', blobInfo.blob())
					axios
						.post(`${this.siteUrl}/wp-json/wp/v2/media`, formData, {
							headers: {
								'X-WP-Nonce': this.nonce,
							},
						})
						.then((response) => {
							if (response.status == 201) {
								success(response.data['source_url'])
							} else {
								failure('上传失败！')
							}
						})
				},
				// 挂载的DOM对象
				selector: `#editor`,
			})
		},
		getTags() {
			const params = {
				page: 1,
				per_page: 50,
			}
			axios
				.get(`${this.siteUrl}/wp-json/wp/v2/tags`, {
					params: params,
				})
				.then((res) => {
					this.tagList = res.data
          console.log(this.tagList)

				})
		},
		getCategories() {
			const params = {
				page: 1,
				per_page: 50,
			}
			axios
				.get(`${this.siteUrl}/wp-json/wp/v2/categories`, {
					params: params,
				})
				.then((res) => {
					this.categoryListOrigin = res.data
					this.categoryList = transData(res.data, 'id', 'parent', 'children')
          console.log(this.categoryList)
				})
		},

		getArticleContent() {
			let params = {}
			return axios
				.get(
					`${this.siteUrl}/wp-json/wp/v2/${this.post_type}/${this.post_id}`,
					{
						params: params,
					}
				)
				.then((res) => {
					this.$nextTick(() => {
						let posts = JSON.parse(JSON.stringify(res.data))
						for (const key in posts) {
							if (posts.hasOwnProperty(key)) {
								const element = posts[key]
								for (const self in element) {
									if (self === 'rendered') {
										posts[key] = element[self]
									}
								}
							}
						}
						posts.type = posts.type.indexOf('moment') > -1 ? 'moments' : 'posts'
						this.format = !!(posts.type === 'moments' ? true : false)
						this.changePostType()
            if (posts.categories) {
							this.posts.categories = posts.categories || []
							this.$refs.categoryTree.setCheckedKeys(this.posts.categories)
						}
						if (posts.tags) {
							this.posts.tags = posts.tags || []
						}
            posts.post_metas.location = Boolean(posts.post_metas.location)
						this.posts = posts

						this.$nextTick(() => {
							window.tinymce.get('editor').setContent(this.posts.content)
						})
					})
				})
		},

		saveLocation() {
			this.posts.post_metas.address = this.location.address
			this.posts.post_metas.position = this.location.simplePosition
			this.ifShowLocationPopup = false
		},

		showLocationMap() {
			const self = this
			this.ifShowLocationPopup = this.posts.post_metas.location
			if (this.ifShowLocationPopup === false) {
				return false
			}
			this.$nextTick(() => {
				const map = new AMap.Map('location-container', {
					resizeEnable: true,
				})

				const geocoder = new AMap.Geocoder({
					radius: 1000, //范围，默认：500
				})

				const marker = new AMap.Marker()

				AMap.plugin('AMap.Geolocation', function () {
					const geolocation = new AMap.Geolocation({
						enableHighAccuracy: true, //是否使用高精度定位，默认:true
						timeout: 10000, //超过10秒后停止定位，默认：5s
						buttonPosition: 'RB', //定位按钮的停靠位置
						buttonOffset: new AMap.Pixel(10, 20), //定位按钮与设置的停靠位置的偏移量，默认：Pixel(10, 20)
						zoomToAccuracy: true, //定位成功后是否自动调整地图视野到定位点
						extensions: 'all',
					})
					map.addControl(geolocation)
					geolocation.getCurrentPosition(function (status, result) {
						if (status == 'complete') {
							onComplete(result)
						} else {
							onError(result)
						}
					})
				})

				map.on('click', function (e) {
					self.$set(
						self.location,
						'simplePosition',
						e.lnglat.lng + ',' + e.lnglat.lat
					)
					regeoCode()
				})

				document.getElementById('lnglat').onkeydown = function (e) {
					if (e.keyCode === 13) {
						regeoCode()
						return false
					}
					return true
				}

				//解析定位结果
				function onComplete(data) {
					self.location = data
					self.$set(
						self.location,
						'simplePosition',
						data.position.lng + ',' + data.position.lat
					)
					regeoCode()
				}

				//解析定位错误信息
				function onError(data) {
					self.$message.error(data.message)
				}

				function regeoCode() {
					const lnglat = self.location.simplePosition.split(',')
					map.add(marker)
					marker.setPosition(lnglat)
					geocoder.getAddress(lnglat, function (status, result) {
						if (status === 'complete' && result.regeocode) {
							const address = result.regeocode.formattedAddress
							self.$set(self.location, 'address', address)
						} else {
							self.$message.error('根据经纬度查询地址失败')
						}
					})
				}
			})
		},

		doTagsChange(value) {
			const { tagList } = this
			value.forEach((element) => {
				const tagListLen = tagList.filter((item) => {
					return item.id === element
				}).length
				if (tagListLen === 0) {
					const params = new FormData()
					params.append('name', element)
					axios
						.post(`${this.siteUrl}/wp-json/wp/v2/tags`, params, {
							headers: {
								'X-WP-Nonce': this.nonce,
							},
						})
						.then((res) => {
							if (res.data) {
								const data = res.data
								const len = this.posts.tags.length
								this.posts.tags[len - 1] = data.id
								this.$set(tagList, tagList.length, data)
								this.$forceUpdate()
								this.$notify.success({
									message: '新增标签(Tag)成功',
									showClose: false,
								})
							}
						})
				}
			})
		},
		changePostType() {
			window.tinymce.remove()
			this.posts.type = this.format === true ? 'moments' : 'posts'
			this.defaultInit.toolbar = this.format
				? this.toolbar_simple
				: this.toolbar_default
      if (this.posts.type === 'posts') {
        this.getTags()
        this.getCategories()
      }
			this.init()
		},

		handleExceed(files, fileList) {
			this.$message.warning(
				`当前限制选择 1 个特色图像，本次选择了 ${files.length} 个文件`
			)
		},
		handleUploadBegin() {
			this.hasCommitFinish = true
		},
		handleUploadSuccess(res, file) {
			if (this.posts.type === 'moments') {
				this.pictureList.push({
					id: res.id,
					dom: res.description.rendered,
				})
			} else {
				this.posts.featured_media = res.id
			}
			this.hasCommitFinish = false
		},
		handleCheckChange(data, checked, indeterminate) {
			this.posts.categories = this.$refs.categoryTree.getCheckedKeys()
		},
		handleRemove(file, fileList) {
			this.$refs.upload.handleRemove(file)
			if (this.posts.type === 'posts') {
				for (let index = 0; index < this.pictureList.length; index++) {
					const element = array[index]
					if (Number(element.id) === Number(file.response.id)) {
						this.pictureList = this.pictureList.splice(index, 1)
					}
				}
			} else {
				this.posts.featured_media = ''
			}
		},
		handlePictureCardPreview(file) {
			this.dialogImageUrl = file.url
			this.dialogVisible = true
		},
		handleDownload(file) {},

		urlToObj(str) {
			var obj = {}
			var arr1 = str.split('?')
			var arr2 = arr1[1].split('&')
			for (var i = 0; i < arr2.length; i++) {
				var res = arr2[i].split('=')
				obj[res[0]] = res[1]
			}
			return obj
		},

		commitPost() {
			const { type } = this
			this.hasCommitFinish = true
			this.posts.status = this.status === true ? 'publish' : 'draft'
			this.posts.content = window.tinymce.get('editor').getContent()
			if (this.posts.type === 'moments') {
				let imgDom = ''
				for (let index = 0; index < this.pictureList.length; index++) {
					const element = this.pictureList[index]
					imgDom += element.dom
				}
        // TODO: 需要清理旧的dom，再插入新的dom
				this.posts.content += `<div class="moment-gallery flex-hb-vc flex-hw">${imgDom}</div>`
			}
			const params = JSON.parse(JSON.stringify(this.posts))
			params.post_metas = []
			const extra = this.posts.post_metas
			for (const key in extra) {
				if (Object.hasOwnProperty.call(extra, key)) {
					const element = extra[key]
					params.post_metas.push({
						key: key,
						value: element,
					})
				}
			}
			const format = this.posts.type
			if (!params.title && format === 'posts') {
				this.$message({
					message: '标题不能为空！',
					type: 'warning',
				})
				this.hasCommitFinish = false
				return false
			}
			if (!params.content) {
				this.$message({
					message: '内容不能为空！',
					type: 'warning',
				})
				this.hasCommitFinish = false
				return false
			}

			axios
				.post(
					`${this.siteUrl}/wp-json/wp/v2/${format}${
						type === 'update' ? '/' + this.post_id : ''
					}`,
					params,
					{
						headers: {
							'X-WP-Nonce': this.nonce,
						},
					}
				)
				.then((res) => {
					if (res.data) {
						this.$message({
							message: type === 'update' ? '更新成功' : '发布成功',
							type: 'success',
						})
						setTimeout(() => {
							this.hasCommitFinish = false
							window.location.href = this.siteUrl
						}, 1500)
					}
				})
				.catch((err) => {
					if (err && err.response) {
						let error = err.response.data
						this.hasCommitFinish = false
						this.$message({
							message: error.message,
							type: 'error',
						})
					}
				})
		},
	},
})
