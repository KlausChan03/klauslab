let pageMixin = {
    data() {
        return {
            id: window.post_id,
            pageInfo: {
                comment_status: '',
                title: {
                    rendered: ""

                },
                post_metas: {
                    reward: ""
                }
            },
        }
    },
    created() {
        this.getPage()
    },
    methods: {
        getPage() {
            axios.get(`${window.site_url}/wp-json/wp/v2/pages/${this.id}`).then(res => {
                if (true) {
                    this.pageInfo = res.data

                }
            }).catch(res => {
                // 失败返回（测试）
                this.$message({
                    message: '请求失败',
                    type: 'warning'
                })
            })
        },
    },
}