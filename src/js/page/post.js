new Vue({
	el: '#post-page',
	components: {
		editor: Editor, // <- Important part
	},
	computed: {
		tagNameList() {
			let tagNameList = []
			if (Array.isArray(this.posts.tags) && this.posts.tags.length > 0) {
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
			if (Array.isArray(this.posts.categories) && this.posts.categories.length > 0) {
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
		// 获取预览图片列表（用于瞬间模式的多图预览）
		previewImageList() {
			if (this.posts.type === 'moments' && this.pictureList.length > 0) {
				return this.pictureList.map(item => item.url).filter(url => url)
			}
			return []
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
			uploadProgress: {},
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
					const formData = new FormData()
					formData.append('file', blobInfo.blob())
					axios
						.post(`${self.siteUrl}/wp-json/wp/v2/media`, formData, {
							headers: {
								'X-WP-Nonce': self.nonce,
							},
						})
						.then((response) => {
							if (response.status === 201) {
								success(response.data['source_url'])
							} else {
								failure('上传失败！')
							}
						})
						.catch((error) => {
							const errorMsg = error?.response?.data?.message || error?.message || '上传失败'
							failure(errorMsg)
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
			const limit = this.format ? 9 : 1
			const type = this.format ? '图片' : '特色图像'
			this.$message.warning(
				`当前限制选择 ${limit} 个${type}，本次选择了 ${files.length} 个文件，已超出限制`
			)
		},
		handleUploadBegin(event, file, fileList) {
			// 上传开始，显示进度
			this.hasCommitFinish = true
			// 记录上传进度
			this.$set(this.uploadProgress, file.uid, {
				percent: 0,
				status: 'uploading'
			})
		},
		handleUploadProgress(event, file, fileList) {
			// 上传开始，显示进度
			if (!this.uploadProgress[file.uid]) {
				this.hasCommitFinish = true
				this.$set(this.uploadProgress, file.uid, {
					percent: 0,
					status: 'uploading'
				})
			}
			// 更新上传进度
			if (this.uploadProgress[file.uid]) {
				this.uploadProgress[file.uid].percent = Math.round(event.percent)
			}
		},
		handleUploadSuccess(res, file, fileList) {
			// 更新上传状态为成功
			if (this.uploadProgress[file.uid]) {
				this.uploadProgress[file.uid].status = 'success'
				this.uploadProgress[file.uid].percent = 100
			}
			
			if (this.posts.type === 'moments') {
				this.pictureList.push({
					id: res.id,
					dom: res.description.rendered,
					url: res.source_url || res.url,
				})
				const total = this.format ? 9 : 1
				if (this.pictureList.length < total) {
					this.$message.success(`图片上传成功 (${this.pictureList.length}/${total})`)
				}
			} else {
				this.posts.featured_media = res.id
				this.$message.success('背景图片上传成功')
			}
			this.hasCommitFinish = false
		},
		handleUploadError(err, file, fileList) {
			this.hasCommitFinish = false
			// 更新上传状态为失败
			if (this.uploadProgress[file.uid]) {
				this.uploadProgress[file.uid].status = 'error'
			}
			const errorMsg = err?.response?.data?.message || err?.message || '上传失败'
			this.$message.error(`图片上传失败: ${errorMsg}`)
		},
		handleCheckChange(data, checked, indeterminate) {
			this.posts.categories = this.$refs.categoryTree.getCheckedKeys()
		},
		handleRemove(file, fileList) {
			// 确认删除
			this.$confirm('确定要删除这张图片吗？', '提示', {
				confirmButtonText: '确定',
				cancelButtonText: '取消',
				type: 'warning'
			}).then(() => {
				this.$refs.upload.handleRemove(file)
				if (this.posts.type === 'moments') {
					// 瞬间模式：从pictureList中移除
					const fileId = file.response?.id || file.uid
					this.pictureList = this.pictureList.filter(item => {
						return Number(item.id) !== Number(fileId)
					})
				} else {
					// 文章模式：清除特色图片
					this.posts.featured_media = ''
				}
				this.$message.success('删除成功')
			}).catch(() => {
				// 取消删除，不做任何操作
			})
		},
		handlePictureCardPreview(file) {
			// 如果是瞬间模式且有多个图片，使用Element UI内置的预览功能
			// Element UI的upload组件会自动处理多图预览
			// 单图或文章模式使用自定义对话框
			if (this.posts.type === 'moments' && this.pictureList.length > 1) {
				// Element UI会自动处理多图预览，这里不需要额外操作
				return
			} else {
				// 单图预览使用自定义对话框
				this.dialogImageUrl = file.url || file.response?.source_url || file.response?.url
				this.dialogVisible = true
			}
		},
		handleBeforeUpload(file) {
			// 检查文件类型
			const isImage = file.type.startsWith('image/')
			if (!isImage) {
				this.$message.error('只能上传图片文件！')
				return false
			}
			
			// 检查文件大小（限制10MB）
			const isLt10M = file.size / 1024 / 1024 < 10
			if (!isLt10M) {
				this.$message.error('图片大小不能超过 10MB！')
				return false
			}
			
			return new Promise((resolve, reject) => {
				getOrientation(file).then((orient) => {
					// 如果orientation为1（正常）或undefined，直接上传
					if (!orient || orient === 1) {
						resolve(file)
						return
					}
					
					// 需要修正方向的图片
					const reader = new FileReader()
					const img = new Image()
					
					reader.onload = (e) => {
						img.src = e.target.result
						img.onload = () => {
							try {
								// 使用新的fixImageOrientation函数处理所有orientation值
								const data = fixImageOrientation(img, orient)
								const newFile = dataURLtoFile(data, file.name)
								resolve(newFile)
							} catch (error) {
								console.error('图片处理失败:', error)
								this.$message.warning('图片处理失败，将使用原图上传')
								resolve(file)
							}
						}
						img.onerror = () => {
							this.$message.error('图片加载失败')
							reject(new Error('图片加载失败'))
						}
					}
					reader.onerror = () => {
						this.$message.error('文件读取失败')
						reject(new Error('文件读取失败'))
					}
					reader.readAsDataURL(file)
				}).catch((error) => {
					console.error('获取EXIF信息失败:', error)
					// EXIF读取失败时，直接上传原图
					resolve(file)
				})
			})
		},

		urlToObj(str) {
			const obj = {}
			try {
				// 尝试使用URL API（适用于绝对路径）
				const url = new URL(str)
				url.searchParams.forEach((value, key) => {
					obj[key] = value
				})
			} catch (e) {
				// 回退到手动解析（适用于相对路径）
				const arr1 = str.split('?')
				if (arr1.length > 1) {
					const arr2 = arr1[1].split('&')
					for (let i = 0; i < arr2.length; i++) {
						const res = arr2[i].split('=')
						if (res.length === 2) {
							obj[decodeURIComponent(res[0])] = decodeURIComponent(res[1])
						}
					}
				}
			}
			return obj
		},

		commitPost() {
			const { type } = this
			
			// 检查是否有正在上传的图片
			const uploadingFiles = Object.values(this.uploadProgress).filter(item => item.status === 'uploading')
			if (uploadingFiles.length > 0) {
				this.$message.warning('请等待图片上传完成后再发布')
				return false
			}
			
			this.hasCommitFinish = true
			this.posts.status = this.status === true ? 'publish' : 'draft'
			this.posts.content = window.tinymce.get('editor').getContent()
			
			if (this.posts.type === 'moments') {
				// 清理旧的moment-gallery DOM
				const tempDiv = document.createElement('div')
				tempDiv.innerHTML = this.posts.content
				const oldGalleries = tempDiv.querySelectorAll('.moment-gallery')
				oldGalleries.forEach(gallery => gallery.remove())
				this.posts.content = tempDiv.innerHTML
				
				// 构建新的图片DOM
				let imgDom = ''
				for (let index = 0; index < this.pictureList.length; index++) {
					const element = this.pictureList[index]
					imgDom += element.dom
				}
				
				// 插入新的图片gallery
				if (imgDom) {
					this.posts.content += `<div class="moment-gallery flex-hb-vc flex-hw">${imgDom}</div>`
				}
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
			
			// 验证标题（文章模式必填）
			if (!params.title && format === 'posts') {
				this.$message({
					message: '标题不能为空！',
					type: 'warning',
				})
				this.hasCommitFinish = false
				return false
			}
			
			// 验证内容
			const contentText = params.content.replace(/<[^>]*>/g, '').trim()
			if (!contentText && this.pictureList.length === 0) {
				this.$message({
					message: '内容不能为空！',
					type: 'warning',
				})
				this.hasCommitFinish = false
				return false
			}
			
			// 验证瞬间模式是否有图片
			if (format === 'moments' && this.pictureList.length === 0) {
				this.$message({
					message: '瞬间至少需要一张图片！',
					type: 'warning',
				})
				this.hasCommitFinish = false
				return false
			}

			axios
				.post(
					`${this.siteUrl}/wp-json/wp/v2/${format}${type === 'update' ? '/' + this.post_id : ''
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
							duration: 2000
						})
						// 清理上传进度
						this.uploadProgress = {}
						setTimeout(() => {
							this.hasCommitFinish = false
							window.location.href = this.siteUrl
						}, 2000)
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
