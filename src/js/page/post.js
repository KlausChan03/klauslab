new Vue({
	el: '#post-page',
	components: {
		editor: Editor, // <- Important part
	},
	computed: {
		tagNameList() {
			let tagNameList = []
			for (let i = 0; i < this.tagList.length; i++) {
				for (let j = 0; j < this.posts.tags.length; j++) {
					if (this.posts.tags[j] === this.tagList[i].id) {
						tagNameList.push(this.tagList[i].name)
					}
				}
			}
			return tagNameList
		},
		categoryNameList() {
			let categoryNameList = []
			for (let i = 0; i < this.categoryListOrigin.length; i++) {
				for (let j = 0; j < this.posts.categories.length; j++) {
					if (this.posts.categories[j] === this.categoryListOrigin[i].id) {
						categoryNameList.push(this.categoryListOrigin[i].name)
					}
				}
			}
			return categoryNameList
		},
	},
	data() {
		const ide = Date.now()
		return {
			// tinyKey: '7b4pdrcfzcszmsf2gjor1x94mha4srj4jalmdpq94fgpaa6j',
			post_id: '',
			editorLoading: false,
			status: true,
			type: 'create',
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
				},
			},
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
						{start: '*', end: '*', format: 'italic'},
						{start: '**', end: '**', format: 'bold'},
						{start: '#', format: 'h1'},
						{start: '##', format: 'h2'},
						{start: '###', format: 'h3'},
						{start: '####', format: 'h4'},
						{start: '#####', format: 'h5'},
						{start: '######', format: 'h6'},
						{start: '1. ', cmd: 'InsertOrderedList'},
						{start: '* ', cmd: 'InsertUnorderedList'},
						{start: '- ', cmd: 'InsertUnorderedList'}
				 ]
			},
		}
	},
	mounted() {
		let urlParams = this.urlToObj(window.location.href)
		if (urlParams.id) {
			this.post_id = urlParams.id
			this.getArticleContent()
			this.type = 'update'
		}
		this.getTags()
		this.getCategories()
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
						.post(`${window.site_url}/wp-json/wp/v2/media`, formData, {
							headers: {
								'X-WP-Nonce': window._nonce,
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
				per_page: 50
			}
			axios.get(`${window.site_url}/wp-json/wp/v2/tags`, {
				params: params
			}).then((res) => {
				this.tagList = res.data
			})
		},
		getCategories() {
			const params = {
				page: 1,
				per_page: 50
			}
			axios.get(`${window.site_url}/wp-json/wp/v2/categories`, {
				params: params
			}).then((res) => {
				this.categoryListOrigin = res.data
				this.categoryList = transData(res.data, 'id', 'parent', 'children')
			})
		},

		getArticleContent() {
			let params = {}
			return axios
				.get(`${window.site_url}/wp-json/wp/v2/posts/${this.post_id}`, {
					params: params,
				})
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
						this.format = !!(this.posts.type === 'moments' ? false : true)
						this.changePostType()
						this.posts = posts
						this.posts.categories = posts.categories
						this.$refs.categoryTree.setCheckedKeys(this.posts.categories)
						this.posts.tags = posts.tags
						window.tinymce.get('editor').setContent(this.posts.content)
					})
				})
		},

		doTagsChange(value) {
			const { tagList } = this
			value.forEach((element) => {
				const tagListLen = tagList.filter((item) => {
					return item.id === element
				}).length
				if (tagListLen === 0) {
          const params = new FormData;
          params.append('name', element);
					axios
						.post(`${window.site_url}/wp-json/wp/v2/tags`, params, {
							headers: {
								'X-WP-Nonce': window._nonce,
							},
						})
						.then((res) => {
							if (res.data) {
                const data = res.data
                const len = this.posts.tags.length
                this.posts.tags[len - 1] = data.id
                this.$set(tagList, tagList.length ,data)
                this.$forceUpdate()
                this.$notify.success({
                  message: '新增标签(Tag)成功',
                  showClose: false
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
			this.posts.post_metas = []
			for (const key in this.posts.post_metas) {
				if (this.posts.post_metas.hasOwnProperty(key)) {
					const element = this.posts.post_metas[key]
					this.posts.post_metas.push({
						key: key,
						value: element === true ? '1' : '0',
					})
				}
			}
			if (this.posts.type === 'moments') {
				let imgDom = ''
				for (let index = 0; index < this.pictureList.length; index++) {
					const element = this.pictureList[index]
					imgDom += element.dom
				}
				this.posts.content += `<div class="moment-gallery flex-hb-vc flex-hw">${imgDom}</div>`
			}
			const params = this.posts
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
			// if() {
			//     this.tagList
			// }
			console.log(this.tagList, this.posts.tags)
			debugger
			axios
				.post(
					`${window.site_url}/wp-json/wp/v2/${format}${
						type === 'update' ? '/' + this.post_id : ''
					}`,
					params,
					{
						headers: {
							'X-WP-Nonce': window._nonce,
						},
					}
				)
				.then((res) => {
					if (res.data) {
						this.$message({
							message: '发布成功',
							type: 'success',
						})
						setTimeout(() => {
							this.hasCommitFinish = false
							window.location.href = window.site_url
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
