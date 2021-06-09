Vue.component('chat-item', {
  props: ['postData'],
  template: `
  <div>  
    <div class="entry-main" >
      <div class="flex-hb-vc flex-hw mb-10">
        <h5 v-if="postData.title.rendered" >#{{postData.title.rendered}}#</h5>
        <div  class="entry-tag" :class="{'w-1': !postData.title.rendered, 'flex-hr-vc': !postData.title.rendered}">
          <el-tag class="ml-10" size="small" type="danger" v-if="postData.sticky">TOP</el-tag>
          <el-tag class="ml-10" size="small" type="danger" v-if="postData.newest">NEW</el-tag>
          <el-tag class="ml-10" size="small" type="danger" v-if="postData.hotest">HOT</el-tag>
        </div>       
      </div>       
      <p ref="entrysummary" class="entry-summary" v-html="postData.content.rendered" :id="postData.id"> </p>
    </div>    
    <div class="entry-footer flex-hb-vc flex-hw">
      <div class="entry-action flex-hb-vc w-1">
        <div class="entry-author fs-16 flex-hl-vc w-04">
          <div v-html="postData.post_metas.avatar" class="mr-10"></div>
          <div class="flex-v flex-hc-vt">
            <span class="fs-12">{{postData._embedded.author[0].name}}</span>
            <span class="fs-12">{{postData.date | formateDate}}</span>
          </div>
        </div>
        <div class="entry-action-main flex-hb-vc w-06">
          <div class="entry-view flex-hc-vc flex-1-3">
            <i class="lalaksks lalaksks-ic-view " ></i>
            <span :style='{"font-size": Number(postData.post_metas.views) >= 1000 ? 12 + "px" : 14 + "px" }'>{{postData.post_metas.views}}</span>
          </div>
          <div class="entry-comment flex-hc-vc flex-1-3" @click="showComment(postData.id)">
            <i class="lalaksks lalaksks-ic-reply  cur-p" :style='{color:postData.post_metas.comments_num > 0 ? "#4488EE":"inhert"}'></i>
            <span :style='{color:postData.post_metas.comments_num > 0 ? "#4488EE":"inhert"}'>{{postData.post_metas.comments_num > 0 ? postData.post_metas.comments_num : 0}}</span>
          </div>
          <div class="entry-zan flex-hc-vc flex-1-3" @click="likeOrDislikePost(postData,'like')">
              <i class="lalaksks lalaksks-ic-zan fs-16 cur-p" :style='{color:postData.post_metas.zan_num > 0 ? "#DD4422":"inhert", background: postData.post_metas.has_zan ? "#F5B4A7" : "inhert"}'></i>
              <span :style='{color:postData.post_metas.zan_num > 0 ? "#DD4422":"inhert"}'>{{postData.post_metas.zan_num > 0 ? postData.post_metas.zan_num : 0}}</span>
          </div>
        </div>    
        
      </div>
    </div>
    </div>
    `,
  mounted() {
    

  },
  methods: {
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
  filters: {
    formateDate: (value) => {
      return dayjs(value).fromNow()
    }
  }
})