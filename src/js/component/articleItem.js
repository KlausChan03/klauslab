Vue.component('article-item', {
  props: ['postData'],
  template: `
  <div>
    <div class="entry-header" :class="{'sticky': postData.sticky }">
      <h5 class="entry-title">
        <a :href="postData.link"> {{postData.title.rendered}} </a>
      </h5>
    </div>
    <div class="entry-main flex-hl-vl flex-hw" :class="{'has-image' : postData._embedded['wp:featuredmedia']}">
      <div class="featured-image" v-if="postData._embedded['wp:featuredmedia']">
        <img :src="postData._embedded['wp:featuredmedia']['0'].source_url" alt="">
      </div>
      <span class="entry-summary" v-html="postData.ifShowAll ? postData.content.rendered : postData.excerpt.rendered" :id="postData.id"></span>
    </div>
    <div class="entry-footer flex-hb-vc flex-hw">
      <div class="entry-action flex-hb-vc flex-hw w-1">
        <div class="entry-author fs-16 flex-hl-vc">
          <img :src="postData._embedded.author[0].avatar_urls[48]" alt="" class="mr-10" style="width:32px;height:32px;">
          <div class="flex-v flex-hc-vt">
            <span class="fs-12">{{postData._embedded.author[0].name}}</span>
            <span class="fs-12">{{postData.date | formateDate}}</span>
          </div>
        </div>
        <div class="entry-action-main flex-hb-vc" style="flex:1 0 auto">
          <div class="entry-view flex-hc-vc flex-1-3">
            <i class="lalaksks lalaksks-ic-view " ></i>
            <span :style='{"font-size": Number(postData.post_metas.views) >= 1000 ? 12 + "px" : 14 + "px" }'>{{postData.post_metas.views}}</span>
          </div>
          <div class="entry-comment flex-hc-vc flex-1-3" @click="showComment(postData.id)">
            <i class="lalaksks lalaksks-ic-reply " :style='{color:postData.post_metas.comments_num > 0 ? "#4488EE":"inhert"}'></i>
            <span :style='{color:postData.post_metas.comments_num > 0 ? "#4488EE":"inhert"}'>{{postData.post_metas.comments_num > 0 ? postData.post_metas.comments_num : 0}}</span>
          </div>
          <el-tooltip content="开发中" effect="dark" placement="top">
            <div class="entry-zan flex-hc-vc flex-1-3" style="cursor:not-allowed">
                <i class="lalaksks lalaksks-ic-zan fs-16 " :style='{color:postData.post_metas.zan_num > 0 ? "#DD4422":"inhert"}'></i>
                <span :style='{color:postData.post_metas.zan_num > 0 ? "#DD4422":"inhert"}'>{{postData.post_metas.zan_num > 0 ? postData.post_metas.zan_num : 0}}</span>
            </div>
          </el-tooltip>
        </div> 
        <div class="entry-extra" style="min-width:100px;text-align:right">
          <button v-if="!postData.ifShowAll" @click="changeIfShowAllToParent(postData.id)" class="kl-btn kl-btn-sm gradient-blue-red border-n">预览全文</button>
          <button v-if="postData.ifShowAll" @click="changeIfShowAllToParent(postData.id)" class="kl-btn kl-btn-sm gradient-red-blue border-n">收起全文</button> 
        </div>        
      </div>
      </div>
    </div>
    `,
  methods: {
    showComment(){
      console.log("hhh")
    },
    changeIfShowAllToParent(id){
      // console.log(id)
      this.$emit('change-type',id)
    },
    showComment(id){
      this.$emit('show-comment',id)

    }
  },
  filters: {
    formateDate: (value) => {
      return dayjs(value).fromNow()
    }
  }
})