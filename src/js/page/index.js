dayjs.locale('zh-cn')
dayjs.extend(window.dayjs_plugin_relativeTime)

const index_module = new Vue({
    el: ".main-container",
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
            per_page: 10,
            page: 1,
            postType: 'article',
            posts_id_sticky: '',
            orderby: 'date',
            orderbyList: [{
                    'type': 'date',
                    'name': '创建时间'
                },
                {
                    'type': 'modified',
                    'name': '更新时间'
                }
            ]
        }
    },
    created() {
        this.getAllArticles()

    },
    computed: {
        getOrderby() {
            let _this = this
            let _item =  this.orderbyList.filter(item => {
                return item.type === _this.orderby
            })
            return _item[0].name
        },
        getTotal() {
            if (this.postType === "article") {
                return this.totalOfArticle
            } else if (this.postType === "chat") {
                return this.totalOfChat
            } else if (this.postType === "all") {
                return this.total
            } else if (this.postType === "recommend") {
                return this.listOfRecommend.length
            }
        },
        judgeCount() {
            if (this.postType === "article") {
                return this.listOfArticle.length > this.per_page
            } else if (this.postType === "chat") {
                return this.listOfChat.length > this.per_page
            } else if (this.postType === "all") {
                return this.listOfAll.length > this.per_page
            } else if (this.postType === "recommend") {
                return true
            }
            return true
        },
        getPaperSize() {
            return this.ifMobileDevice === true ? 3 : 8
        }
    },

    methods: {
        getAllTypePost() {
            let _this = this
            _this.per_page = _this.per_page / 2
            _this.ifShowAll = true
            _this.total = 0
            axios.all([this.getAllArticles(), this.getAllChat()])
                .then(axios.spread(function () {
                    _this.listOfAll = _this.listOfArticle.concat(_this.listOfChat)
                    _this.listOfAll = _this.listOfAll.sort((a, b) => {
                        return new Date(b.date).getTime() - new Date(a.date).getTime()
                    })
                    _this.ifShowAll = false
                    _this.per_page = _this.per_page * 2
                    _this.total = _this.totalOfArticle + _this.totalOfChat
                }))
        },

        getTypeOfRecommend() {
            this.ifShowAll = true
            let params = {};
            params.per_page = window.post_count
            params.sticky = true
            return axios.get(`${GLOBAL.homeUrl}/wp-json/wp/v2/posts?_embed`, {
                params: params
            }).then(res => {
                this.listOfRecommend = res.data
                this.ifShowAll = false
            })
        },

        getAllArticles() {
            this.ifShowPost = true
            let params = {};
            params.page = this.page
            params.per_page = this.per_page
            params.orderby = this.orderby
            if (this.page === 1) {
                axios.get(`${GLOBAL.homeUrl}/wp-json/wp/v2/posts?_embed&sticky=1`)
                    .then(res_sticky => {
                        this.listOfArticle = res_sticky.data;
                        //获取顶置文章 IDs 以在获取其余文章时排除
                        for (var s = 0; s < this.listOfArticle.length; ++s) {
                            this.posts_id_sticky += (',' + this.listOfArticle[s].id);
                        }
                        params.per_page = this.per_page - this.listOfArticle.length
                        params.exclude = this.posts_id_sticky
                        axios.get(`${GLOBAL.homeUrl}/wp-json/wp/v2/posts?_embed`, {
                            params: params
                        }).then(res => {
                            this.totalOfArticle = parseInt(res.headers['x-wp-total'])
                            this.listOfArticle = this.listOfArticle.concat(res.data)
                            this.listOfArticle.forEach(element => {
                                element.ifShowAll = false
                                element.ifShowComment = false
                            });
                            this.ifShowPost = false
                        })
                    })
            } else {
                axios.get(`${GLOBAL.homeUrl}/wp-json/wp/v2/posts?_embed`, {
                    params: params
                }).then(res => {
                    this.totalOfArticle = parseInt(res.headers['x-wp-total'])
                    this.listOfArticle = res.data
                    this.ifShowPost = false
                })
            }



        },

        getAllChat() {
            this.ifShowChat = true
            let params = {};
            params.page = this.page
            params.per_page = this.per_page
            params.orderby = this.orderby
            axios.get(`${GLOBAL.homeUrl}/wp-json/wp/v2/shuoshuo?_embed`, {
                params: params
            }).then(res => {
                this.totalOfChat = parseInt(res.headers['x-wp-total'])
                this.listOfChat = res.data
                this.ifShowChat = false

            })
        },

        handleCurrentChange(val) {
            this.page = val
            this.getListByType(this.postType)
            this.$nextTick(() => {
                document.querySelectorAll("#page")[0].scrollTop = 0
            })
        },

        changeType(tab, event) {
            this.page = 1
            this.postType = tab.label
            this.getListByType(this.postType)
        },

        getListByType(type) {
            if (type === "article") {
                this.getAllArticles()
            } else if (type === "chat") {
                this.getAllChat()
            } else if (type === "all") {
                this.getAllTypePost()
            } else if (type === "recommend") {
                this.getTypeOfRecommend()
            }
        },
        changeItemType(id) {
            this.listOfArticle.forEach(item => {
                if (item.id === id) {
                    item.ifShowAll = !item.ifShowAll
                }
            })
            this.listOfArticle.splice(0, 0)
        },
        showItemComment(id) {
            this.listOfArticle.forEach(element => {
                if(element.id === id){
                    if(element.ifShowComment === false){
                        var _nonce = "<?php echo wp_create_nonce( 'wp_rest' ); ?>";
                        let params = {}
                        params.post = id
                        axios.get(`${GLOBAL.homeUrl}/wp-json/wp/v2/comments`, {
                            params: params
                        }, {
                            headers: {
                                'X-WP-Nonce': _nonce
                            }
                        }).then(res => {
                            this.$nextTick(()=>{
                                element.ifShowComment = true
                                element.listOfComment = res.data
                            })
                            this.$forceUpdate()
                        })
                    } else {
                        element.ifShowComment = false
                        this.$forceUpdate()

                    }
                }              

            })
            
        },
        handleCommand(type) {
            this.orderby = type
            let _this = this
            let getList = () => {
                _this.getListByType(_this.postType)
            }
            let showNotify = () =>{
                this.$notify({
                    message: '切换成功',
                    duration: 3000,
                    type: 'success',
                    showClose: false,
                    // offset: 70
                });
            }            
            (async ()=>{
                 await getList();
                 await showNotify();               
            })();
            
            
        },
    }
})