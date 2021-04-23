Vue.component('kl-search', {
    template: `
    <div id="search_form" class="search_form_dis">
        <div class="search-bg-b"></div>
        <div class="search-bg" id="search-div">
            <div class="search-div1">
                <div class="flex-hb-vc">
                    <h3>搜索内容</h3>
                    <i class="lalaksks lalaksks-close-circle fs-20" @click="closeSearch"></i>  
                </div>                                 
                <p>从本站全部内容中搜索所需</p>
                <input ref="searchInput" class="uk-input" type="text" placeholder="请输入搜索内容后回车Enter" v-on:keyup.enter="search_query" v-model.trim="search_key">
            </div>
            <div class="search-div2">
                <ul v-if="search_loading">
                    <template v-if="search_content.length !== 0">
                        <li v-for="search in search_content">
                            <a :href="search.url">
                                <h4 v-html="search.title"></h4>
                            </a>
                        </li>
                    </template>
                    <template v-else>
                        <li>
                            <h4 style="color:#777">无匹配文章</h4>
                            <p>请尝试更换搜索词再试试</p>
                        </li>
                    </template>
                </ul>
                <ul v-if="loading_ph">
                    <li><kl-skeleton :randomList="[1]"></kl-skeleton></li>
                </ul>
            </div>
        </div>
    </div>
    `,
    data() {
        return {
            search_content: null,
            search_key: null,
            search_loading: false,
            loading_ph: true,
            search_open: false
        }
    },
    methods: {
        search_query() {
            this.search_loading = false;
            this.loading_ph = true;

            var s = this.search_key;
            axios.get(`${GLOBAL.homeUrl}/wp-json/wp/v2/search?search=${s}`)
                .then(response => {
                    this.search_content = response.data;
                    this.loading_ph = false;
                    this.search_loading = true;
                })
        },
        closeSearch(){
            this.search_content = ''
            this.search_key = ''
            this.$emit('close-search')
            
        },
    },
})