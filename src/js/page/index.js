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
            per_page: 10,
            page: 1,
            postType: 'article',
        }
    },
    created() {
        this.getAllArticles()
        // let params = {}
        // axios.get(`${GLOBAL.homeUrl}/wp-json/wp/v2/user_bind`, {
        //     params: params
        // }).then(res => {
        //     console.log(res)
        // })
        console.log(dayjs())
    },
    computed: {
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
                    console.log('所有请求完成')
                    console.log('请求1结果', _this.listOfArticle)
                    console.log('请求2结果', _this.listOfChat)
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
            // let _this = this
            this.ifShowAll = true
            let params = {};
            // params.page = this.page
            params.per_page = window.post_count
            params.sticky = true
            return axios.get(`${GLOBAL.homeUrl}/wp-json/wp/v2/posts?_embed`, {
                params: params
            }).then(res => {
                // let headerData = Object.values(res.headers)
                // this.totalOfArticle = parseInt(headerData[16])
                this.listOfRecommend = res.data
                this.ifShowAll = false
            })
        },

        getAllArticles() {
            this.ifShowPost = true
            let params = {};
            params.page = this.page
            params.per_page = this.per_page
            // params.sticky = true
            return axios.get(`${GLOBAL.homeUrl}/wp-json/wp/v2/posts?_embed`, {
                params: params
            }).then(res => {
                this.totalOfArticle = parseInt(res.headers['x-wp-total'])
                this.listOfArticle = res.data
                this.ifShowPost = false
            })
        },

        getAllChat() {
            this.ifShowChat = true
            let params = {};
            params.page = this.page
            params.per_page = this.per_page
            // params.type="shuoshuo"
            // params.sticky = true
            return axios.get(`${GLOBAL.homeUrl}/wp-json/wp/v2/shuoshuo?_embed`, {
                params: params
            }).then(res => {
                // let headerData = Object.values(res.headers)
                this.totalOfChat = parseInt(res.headers['x-wp-total'])
                this.listOfChat = res.data
                this.ifShowChat = false

            })
        },

        handleCurrentChange(val) {
            this.page = val
            this.getListByType(this.postType)
        },

        changeType(tab, event) {
            console.log(tab, event)
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
    }
})