const index_module = new Vue({
    el: ".main-container",
    data() {
        return {
            listOfArticle: [],
            listOfChat: [],
            ifShowPost: true,
            ifShowChat: true
        }
    },
    created() {
        this.getAllArticles()
    },
    methods: {
        getAllArticles() {
            this.ifShowPost = true
            let params = {};
            params.page = 1
            params.per_page = 20
            // params.sticky = true
            axios.get(`${GLOBAL.homeUrl}/wp-json/wp/v2/posts?_embed`, {
                params: params
            }).then(res => {
                // console.log(res)
                this.listOfArticle = res.data
                this.ifShowPost = false
            })
        },

        getAllChat() {
            this.ifShowChat = true
            let params = {};
            params.page = 1
            params.per_page = 20
            // params.type="shuoshuo"
            // params.sticky = true
            axios.get(`${GLOBAL.homeUrl}/wp-json/wp/v2/shuoshuo?_embed`, {
                params: params
            }).then(res => {
                console.log(res)
                this.listOfChat = res.data
                this.ifShowChat = false
            })
        },

        changeType(tab, event) {
            console.log(tab, event)
            if (tab.label === "article") {
                this.getAllArticles()
            } else if (tab.label === "chat") {
                this.getAllChat()
            }
        }
    },
})