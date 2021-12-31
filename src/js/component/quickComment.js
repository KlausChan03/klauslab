const quickComment = Vue.component('quick-comment', {
  components: { quickCommentItem: quickCommentItem},
  props: ['commentData', 'postData', 'callback'],
  data() {
    return {
			tinyKey: window.tinyKey,
      listOfComment: '',
      commentPage: 1,
      commentContent: '',
      hasCommitFinish: false,
      ifShowCommentAll: false,
      ifShowEditor: false,
      page: 1,
      commentInfo: {
        replyTo: '',
        parentId: '',
      },
      totalOfComment: '',
      commentAuthor: '',
      commentEmail: '',
      commentUrl: '',
      isLogin: window.is_login,
    }
  },
  provide() {
    return {
      commentInfo: this.commentInfo
    };
  },
  components: {
    'editor': Editor, // <- Important part
  },
  template: `
  <div id="comments" style="margin: 0; padding: 1.5rem; position: relative; border-top: 1px solid #eee;">
    <template v-if="!isLogin">
      <div  class="flex-hb-vc flex-hw mb-10">
        <el-input type="text" name="author" v-model="commentAuthor" class="text-input" id="comment-author" placeholder="昵称 *"></el-input>
        <el-input type="text" name="email" v-model="commentEmail" class="text-input" id="comment-email" placeholder="邮箱 *"></el-input>
        <el-input type="text" name="url" v-model="commentUrl" class="text-input" id="comment-url" placeholder="网址"></el-input>
      </div>
    </template> 
    <div class="comment-input mb-10" id="comment-input" v-loading="!ifShowEditor">
      <editor  @onInit="changeShowStatus" :api-key="tinyKey" cloud-channel="5" :placeholder="hitokoto" :disabled=false :id="'uuid' + postData.id" :setting="{inline: false}" :init="{  
        height: 180,
        menubar: false,        
        plugins: [
          'advlist autolink lists link image charmap print preview anchor',
          'searchreplace visualblocks code fullscreen',
          'insertdatetime media table paste code help wordcount',
          'lists code emoticons',
        ],
        
        toolbar:
          'undo redo | formatselect | emoticons | \
          bullist numlist  | help'}" initial-value="" :inline=false model-events="" plugins="" tag-name="div" toolbar="" v-model="commentContent"  />
        <div class="flex-hb-vc mt-10">
          <span class="col-aaa">{{commentInfo.replyTo ? '@' + commentInfo.replyTo : ''}}</span>
          <span>
            <el-button size="mini" type="default" @click="cancelReply()" v-show="commentInfo.parentId">取消回复</el-button>
            <el-button size="mini" type="primary" @click="commitComment()" :loading="hasCommitFinish">提交</el-button>
          </span>        
      </div>
    </div>
    <template v-if="listOfComment" >     
      <quick-comment-item  class="comment-item" :comment-data="commentData ? commentData : listOfComment"></quick-comment-item>    
      <div class="flex-hc-vc m-tb-10" v-if="(postData.totalOfComment ? postData.totalOfComment : totalOfComment) > 10">
        <el-pagination layout="prev, pager, next, jumper" background :total="postData.totalOfComment ? postData.totalOfComment : totalOfComment"   :current-page.sync="page" @current-change="handleCommentCurrentChange"> </el-pagination>
      </div>
    </template>
    <template v-else>
      <kl-skeleton class="mt-10" type="comment"></kl-skeleton>    
    </template>
  </div>
    `,
  mounted() {
    if (!this.callback) {
      this.getListOfComment()
    }
  },
  computed: {
    hitokoto() {
      return window.localStorage.getItem('baseInfo') ? JSON.parse(window.localStorage.getItem('baseInfo')).hitokoto : ''
    }
  },
  methods: {
    changeShowStatus() {
      this.ifShowEditor = true
    },
    getListOfComment(id = window.post_id, page = this.commentPage) {
      let params = {}
      params.post = id
      params.page = page
      axios.get(`${window.site_url}/wp-json/wp/v2/comments`, {
        params: params
      }, {
        headers: {
          'X-WP-Nonce': window._nonce
        }
      }).then(res => {
        this.totalOfComment = parseInt(res.headers['x-wp-total'])
        this.listOfComment = transData(res.data, 'id', 'parent', 'children')
      })
    },

    commitComment: _.throttle(function (item, action) {
      this.hasCommitFinish = true
      let params = {}
      params.post = this.postData.id
      params.content = this.commentContent
      params.parent = this.commentInfo.parentId ? this.commentInfo.parentId : "0"
      if (!this.isLogin) {
        params.author_name = this.commentAuthor
        params.author_email = this.commentEmail
        params.author_url = this.commentUrl
      }

      axios.post(`${window.site_url}/wp-json/wp/v2/comments`, {
        post: this.postData.id,
        content: this.commentContent,
        parent: this.commentInfo.parentId ? this.commentInfo.parentId : "0",
        author_name: this.commentAuthor,
        author_email: this.commentEmail,
        author_url: this.commentUrl,
      }, {
        headers: {
          'X-WP-Nonce': window._nonce
        }
      }).then(res => {
        if (res.data) {
          this.$message({
            message: "评论成功",
            type: "success"
          })
          // this.postData.ifShowComment = false
          // this.$parent && this.$parent.$parent && this.$parent.$parent.$parent && this.$parent.$parent.$parent.getListOfComment && this.$parent.$parent.$parent.getListOfComment(this.postData.id, 1);
          // this.getListOfComment(this.postData.id, 1)
          // this.$emit('get-comment-list', this.postData.id, 1)
          this.getListOfComment(this.postData.id, 1)
          this.commentContent = ''
          this.hasCommitFinish = false
          this.cancelReply()
          this.$forceUpdate()
        }

      }).catch(err => {
        if (err && err.response) {
          let error = err.response.data
          this.hasCommitFinish = false
          this.$message({
            message: error.message,
            type: "error"
          })
        }
      })
    }, 3000),
    handleCommentCurrentChange(val) {
      // this.$emit('change-page', val)
      // this.changeCommentCurrent(val)
      this.commentPage = val
      this.getListOfComment(this.postData.id, this.currentCommentId)
    },
    cancelReply() {
      this.commentInfo.parentId = ''
      this.commentInfo.replyTo = ''
    }
  }
})