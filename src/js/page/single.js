dayjs.locale('zh-cn')
dayjs.extend(window.dayjs_plugin_relativeTime)

const index_module = new Vue({
    el: ".main-content",
    data() {
        return {
            ifShowSingle: false,
            ifMobileDevice: window.ifMobileDevice,
            post_id: window.post_id,
            posts: {

            },
        }
    },
    created() {
        this.getAllArticles()
    },
    computed: {

    },

    methods: {

        getAllArticles() {
            this.ifShowSingle = false
            let params = {};
            return axios.get(`${GLOBAL.homeUrl}/wp-json/wp/v2/posts/${this.post_id}`, {
                params: params
            }).then(res => {
                console.error(this.posts)
                this.$nextTick(() => {
                    this.ifShowSingle = true
                    this.posts = res.data;
                })
            })
        },

        goAnchor(selector) {
            var anchor = this.$el.querySelector(selector) // 参数为要跳转到的元素id
            this.$nextTick(() => {
                console.log(anchor.offsetTop)
                // document.body.scrollTop = anchor.offsetTop // chrome
                document.documentElement.scrollTop = anchor.offsetTop // firefox
                document.querySelectorAll("#page")[0].scrollTop = anchor.offsetTop
            })

        }
    }
})