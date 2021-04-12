
Vue.component('comment-item', {
  props: ['commentData','postData','tinyKey'],
  data() {
    return {
      commentContent: '',
      hasCommitFinish: false,
      ifShowCommentAll: false,
    }
  },
  components: {
    'editor': Editor // <- Important part
},
  template: `
  <div id="comments" v-loading="!ifShowCommentAll" class="comment-container" style="margin: 0; padding: 1.0rem 1.6rem; position: relative; border-top: 1px solid #eee;">
    <ul class="comment-list">
      <li v-for="(item,index) in commentData" :id="'comment-' + item.id" :key="item.id" class="comment-item flex-hl-vl">
        <div class="commentator-avatar">
          <img alt="avatar" :src="item.author_avatar_urls[48]"  height="32" width="32" class="avatar avatar-32 photo">
        </div>
        <div class="commentator-content">
          <span class="commentator-name">
            <a :href="item.author_url" rel="external nofollow ugc" class="url">
              {{item.author_name}}
            </a>
          </span>
          <span class="commentator-extra" v-html="item.comment_metas.level"></span>
          <div class="comment-chat">
            <div class="comment-comment">
              <p v-html="item.content.rendered"></p> 
              <div class="comment-info">
                <span class="comment-time">{{item.date | formateDate}}</span> 
                <span class="reply flex-hr-vc">
                  <a rel="nofollow" href="http://localhost/dashboard/klausLab/3373.html?replytocom=367#respond" data-commentid="367" data-postid="3373" data-belowelement="comment-367" data-respondelement="respond" aria-label="回复给Klaus" class="comment-reply-link"><i class="lalaksks lalaksks-ic-reply"></i></a>
                </span>
              </div>
            </div>
          </div>
        </div>
        
      </li>
    </ul>
    <div class="comment-input">
      <editor :api-key="tinyKey" cloud-channel="5" :disabled=false id="uuid" :init="{  
        height: 180,
        menubar: false,
        plugins: [
          'advlist autolink lists link image charmap print preview anchor',
          'searchreplace visualblocks code fullscreen',
          'insertdatetime media table paste code help wordcount',
          'lists code emoticons'
        ],
        emoticons_append: {
          custom_mind_explode: {
            keywords: ['brain', 'mind', 'explode', 'blown'],
            char: '🤯'
          }
        },
        toolbar:
          'undo redo | formatselect | emoticons | \
          bullist numlist  | help'}" initial-value="" :inline=false model-events="" plugins="" tag-name="div" toolbar="" v-model="commentContent" />
      <div class="flex-hr-vc">
        <el-button size="mini" type="primary" class="mt-5" @click="commitComment()" :loading="hasCommitFinish">提交</el-button>
      </div>
    </div>
  </div>
    `,
  mounted() {
    console.log(this.postData)
    console.log(this.commentData)
    setTimeout(() => {
      this.ifShowCommentAll = true      
    }, 1500);
  },
  methods: {
    commitComment(){
      this.hasCommitFinish = true
      axios.post(`${GLOBAL.homeUrl}/wp-json/wp/v2/comments`, {
        post:this.postData.id,
        content: this.commentContent
      }, {
        headers: {
            'X-WP-Nonce': window._nonce
        }
      }).then(res => {
        if(res.data){
          this.$message({
            message: "评论成功",
            type: "success"
          })
          this.postData.ifShowComment = false
          this.$parent.$parent.$parent.showItemComment(this.postData.id);
          this.$forceUpdate()    
          this.commentContent = ''
          this.hasCommitFinish = false

        }          
         
      }).catch(err => {
        if(err && err.response){
          let error = err.response.data
          this.hasCommitFinish = false
          this.$message({
            message: error.message,
            type: "error"
          })
        }
      })
    }
  },
  filters: {
    formateDate: (value) => {
      return dayjs(value).fromNow()
    }
  }
})