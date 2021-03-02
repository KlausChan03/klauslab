const index_module = new Vue({
    el: ".main-container",
    data() {
        return {
            listOfAll: [],
            listOfArticle: [],
            listOfChat: [],
            total: 0,
            totalOfArticle: 0,
            totalOfChat: 0,
            ifShowPost: false,
            ifShowChat: false,
            ifShowAll: true,
            per_page: 10,
            page: 1,            
            postType: 'all',
        }
    },
    created() {
        this.getAllTypePost()
    },
    computed:{
        getTotal(){
            if (this.postType === "article") {
                return this.totalOfArticle
            } else if(this.postType === "chat"){
                return this.totalOfChat
            } else if(this.postType === "all"){
                return this.total
            }            
        },
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

        getAllArticles() {
            this.ifShowPost = true
            let params = {};
            params.page = this.page
            params.per_page = this.per_page
            // params.sticky = true
            return axios.get(`${GLOBAL.homeUrl}/wp-json/wp/v2/posts?_embed`, {
                params: params
            }).then(res => {
                let headerData = Object.values(res.headers)
                this.totalOfArticle = parseInt(headerData[16])
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
                let headerData = Object.values(res.headers)
                this.totalOfChat = parseInt(headerData[16])
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

        getListByType(type){
            if (type === "article") {
                this.getAllArticles()
            } else if (type === "chat") {
                this.getAllChat()
            } else if (type === "all") {
                this.getAllTypePost()
            }
        },


    },
})