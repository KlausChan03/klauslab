dayjs.locale('zh-cn')
dayjs.extend(window.dayjs_plugin_relativeTime)

const index_module = new Vue({
    el: ".main-content",
    // mixins:[reward_mixin],
    data() {
        return {
            ifShowSingle: false,
            ifMobileDevice: window.ifMobileDevice,
            post_id: window.post_id,
            posts: {
                post_metas: {
                    zan_num: 0,
                    comments_num: 0,
                }
            },
            listOfComment: "",
            // ifShowPayImage: true,
            commentPage: 1,
        }
    },
    created() {
        this.getAllArticles()
    },
    
    updated() {
        let self = this
        let imgList = document.querySelectorAll(".entry-content img");
        for (let index = 0; index < imgList.length; index++) {
            const element = imgList[index];
            element.addEventListener("click", function (e) {
                e.preventDefault()
                self.$alert(`<div class="p-10 flex-hc-vc">${element.outerHTML}</div>`, {
                    dangerouslyUseHTMLString: true,
                    closeOnClickModal: true,
                    closeOnPressEscape: true,
                    showConfirmButton: false,
                  });
            })
        }
       
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

        likeOrDislikePost(item, action) {
            debugger
            let params = {}
            params.id = item.id
            params.action = action
            if (item.post_metas.has_zan || item.post_metas.has_cai) {
                this.$message({
                    message: "你已经评价过！",
                    type: 'warning'
                })
                return false
            }
            if (action === "dislike") {
                this.$confirm('点踩会打击作者的创作积极性, 是否继续?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    axios.post(`${window.site_url}/wp-json/wp/v2/likePost`, params, {
                        headers: {
                            'X-WP-Nonce': _nonce
                        }
                    }).then(res => {
                        this.$nextTick(() => {
                            console.log(this.posts.post_metas)
                            this.$set(this.posts.post_metas, action === 'like' ? 'zan_num' : 'cai_num', res.data)
                            this.$set(this.posts.post_metas, action === 'like' ? 'has_zan' : 'has_cai', true)
                            this.$message({
                                message: action === 'like' ? "点赞成功！" : "点踩成功！",
                                type: 'success'
                            })

                        })
                    })
                }).catch(() => {
                    return false
                });
            } else {
                axios.post(`${window.site_url}/wp-json/wp/v2/likePost`, params, {
                    headers: {
                        'X-WP-Nonce': _nonce
                    }
                }).then(res => {
                    this.$nextTick(() => {
                        console.log(this.posts.post_metas)
                        this.$set(this.posts.post_metas, action === 'like' ? 'zan_num' : 'cai_num', res.data)
                        this.$set(this.posts.post_metas, action === 'like' ? 'has_zan' : 'has_cai', true)
                        this.$message({
                            message: action === 'like' ? "点赞成功！" : "点踩成功！",
                            type: 'success'
                        })

                    })
                })
            }
        },

        
    }
})