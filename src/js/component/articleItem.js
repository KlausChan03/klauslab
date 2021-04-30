Vue.component('article-item', {
  props: ['postData'],
  data() {
    return {
      ifMobileDevice: window.ifMobileDevice
    }
  },
  // template: ` 
  // <el-tooltip content="开发中" effect="dark" placement="top">
  //   <div class="entry-zan flex-hc-vc flex-1-3" style="cursor:not-allowed">
  //       <i class="lalaksks lalaksks-ic-zan fs-16 " :style='{color:postData.post_metas.zan_num > 0 ? "#DD4422":"inhert"}'></i>
  //       <span :style='{color:postData.post_metas.zan_num > 0 ? "#DD4422":"inhert"}'>{{postData.post_metas.zan_num > 0 ? postData.post_metas.zan_num : 0}}</span>
  //   </div>
  // </el-tooltip>`,
  template: `
  <div>
    <div class="entry-header flex-hl-vc flex-hw" :class="{'sticky': postData.sticky }">
      <h5 class="entry-title mr-10">
        <a :href="postData.link"> {{postData.title.rendered}} </a>       
      </h5>
      <el-tag class="mr-10" size="small" v-for="(item,index) in postData.post_metas.tag_name">
        {{item}}
      </el-tag>
      <el-tag type="warning" class="mr-10" size="small" v-for="(item,index) in postData.post_metas.cat_name">
        {{item}}
      </el-tag>
    </div>
    <div class="entry-main flex-hl-vl flex-hw" :class="{'has-image' : postData._embedded['wp:featuredmedia']}" v-if="postData.content.rendered || postData.excerpt.rendered">
      <div class="featured-image" v-if="postData._embedded['wp:featuredmedia']">
        <img :src="postData._embedded['wp:featuredmedia']['0'].source_url" alt="">
      </div>
      <span class="entry-summary" v-html="postData.ifShowAll ? postData.content.rendered : postData.excerpt.rendered" :id="postData.id"></span>
    </div>
    <div class="entry-footer flex-hb-vc flex-hw">
      <div class="entry-action flex-hb-vc flex-hw w-1" v-if="!ifMobileDevice">
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
          <div class="entry-zan flex-hc-vc flex-1-3" @click="likeOrDislikePost(postData,'like')">
              <i class="lalaksks lalaksks-ic-zan fs-16 cur-p" :style='{color:postData.post_metas.zan_num > 0 ? "#DD4422":"inhert", background: postData.post_metas.has_zan ? "#F5B4A7" : "inhert"}'></i>
              <span :style='{color:postData.post_metas.zan_num > 0 ? "#DD4422":"inhert"}'>{{postData.post_metas.zan_num > 0 ? postData.post_metas.zan_num : 0}}</span>
          </div>
          <div class="entry-cai flex-hc-vc flex-1-3" @click="likeOrDislikePost(postData,'dislike')">
              <i class="lalaksks lalaksks-ic-zan fs-16 cur-p" style="transform: rotateX(180deg)" :style='{color:postData.post_metas.cai_num > 0 ? "#36292F":"inhert", background: postData.post_metas.has_cai ? "#856D72" : "inhert"}'></i>
              <span :style='{color:postData.post_metas.cai_num > 0 ? "#36292F":"inhert"}'>{{postData.post_metas.cai_num > 0 ? postData.post_metas.cai_num : 0}}</span>
          </div>
        </div> 
        <div class="entry-extra" style="min-width:100px;text-align:right" v-if="!ifMobileDevice">
          <button v-if="!postData.ifShowAll" @click="changeIfShowAllToParent(postData.id)" class="kl-btn kl-btn-sm gradient-blue-red border-n">预览全文</button>
          <button v-if="postData.ifShowAll" @click="changeIfShowAllToParent(postData.id)" class="kl-btn kl-btn-sm gradient-red-blue border-n">收起全文</button> 
        </div>        
      </div>
      <div class="entry-action w-1" v-if="ifMobileDevice">
        <div class="flex-hb-vc mb-10">
          <div class="entry-author fs-16 flex-hl-vc">
            <img :src="postData._embedded.author[0].avatar_urls[48]" alt="" class="mr-10" style="width:32px;height:32px;">
            <div class="flex-v flex-hc-vt">
              <span class="fs-12">{{postData._embedded.author[0].name}}</span>
              <span class="fs-12">{{postData.date | formateDate}}</span>
            </div>
          </div>
          <div class="entry-extra" style="min-width:100px;text-align:right">
            <button v-if="!postData.ifShowAll" @click="changeIfShowAllToParent(postData.id)" class="kl-btn kl-btn-sm gradient-blue-red border-n">预览全文</button>
            <button v-if="postData.ifShowAll" @click="changeIfShowAllToParent(postData.id)" class="kl-btn kl-btn-sm gradient-red-blue border-n">收起全文</button> 
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
          <div class="entry-zan flex-hc-vc flex-1-3" @click="likeOrDislikePost(postData,'like')">
              <i class="lalaksks lalaksks-ic-zan fs-16 cur-p" :style='{color:postData.post_metas.zan_num > 0 ? "#DD4422":"inhert", background: postData.post_metas.has_zan ? "#F5B4A7" : "inhert"}'></i>
              <span :style='{color:postData.post_metas.zan_num > 0 ? "#DD4422":"inhert"}'>{{postData.post_metas.zan_num > 0 ? postData.post_metas.zan_num : 0}}</span>
          </div>
          <div class="entry-cai flex-hc-vc flex-1-3" @click="likeOrDislikePost(postData,'dislike')">
              <i class="lalaksks lalaksks-ic-zan fs-16 cur-p" style="transform: rotateX(180deg)" :style='{color:postData.post_metas.cai_num > 0 ? "#36292F":"inhert", background: postData.post_metas.has_cai ? "#856D72" : "inhert"}'></i>
              <span :style='{color:postData.post_metas.cai_num > 0 ? "#36292F":"inhert"}'>{{postData.post_metas.cai_num > 0 ? postData.post_metas.cai_num : 0}}</span>
          </div>
        </div> 
             
      </div>
      </div>
    </div>
    `,
  methods: {
    changeIfShowAllToParent(id) {
      this.$emit('change-type', id)
    },
    showComment(id) {
      this.$emit('show-comment', id)
    },
    likeOrDislikePost(item, action) {
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
              console.log(this.postData.post_metas)
              this.$set(this.postData.post_metas, action === 'like' ? 'zan_num' : 'cai_num', res.data)
              this.$set(this.postData.post_metas, action === 'like' ? 'has_zan' : 'has_cai', true)
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
            console.log(this.postData.post_metas)
            this.$set(this.postData.post_metas, action === 'like' ? 'zan_num' : 'cai_num', res.data)
            this.$set(this.postData.post_metas, action === 'like' ? 'has_zan' : 'has_cai', true)
            this.$message({
              message: action === 'like' ? "点赞成功！" : "点踩成功！",
              type: 'success'
            })

          })
        })
      }

    },
  },
  mounted() {},
  filters: {
    formateDate: (value) => {
      return dayjs(value).fromNow()
    }
  }
})