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
                post_metas:{
                    zan_num: 0,
                    comments_num: 0,
                }
            },
            listOfComment: "",
            ifShowPayImage: true,
            commentPage: 1,
        }
    },
    created() {
        this.getAllArticles()
    },
    mounted() {
        // setTimeout(() => {
        //     this.owoEmoji();
        //     this.commentsSubmit();
            
        // }, 3000);
    },
    methods: {

        getAllArticles() {
            this.ifShowSingle = false
            let params = {};
            return axios.get(`${window.site_url}/wp-json/wp/v2/posts/${this.post_id}`, {
                params: params
            }).then(res => {
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

        },

        changeChoose(){
            this.ifShowPayImage = !this.ifShowPayImage
        }
    }
})