dayjs.locale('zh-cn')
dayjs.extend(window.dayjs_plugin_relativeTime)

// let quickCommentItem = require('./qickCommentItem.js');
Vue.component('quick-comment', {
  props: ['commentData', 'postData', 'callback'],
  data() {
    return {
      listOfComment: '',
      commentPage: 1,
      commentContent: '',
      hasCommitFinish: false,
      ifShowCommentAll: false,
      ifShowEditor: false,
      per_page: 10,
      page: 1,
      commentInfo: {
        replyTo: '',
        parentId: '',
      },
      totalOfComment: '',

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
    <template v-if="listOfComment" >
      <div class="comment-input mb-10" id="comment-input" v-loading="!ifShowEditor">
        <editor  @onInit="changeShowStatus" :api-key="tinyKey" cloud-channel="5" :disabled=false :id="'uuid' + postData.id" :setting="{inline: false}" :init="{  
          height: 180,
          menubar: false,        
          plugins: [
            'advlist autolink lists link image charmap print preview anchor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table paste code help wordcount',
            'lists code emoticons'
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
      <quick-comment-item  :comment-data="commentData ? commentData : listOfComment"></quick-comment-item>    
      <div class="flex-hc-vc m-tb-10" v-if="(postData.totalOfComment ? postData.totalOfComment : totalOfComment) > 10">
        <el-pagination layout="prev, pager, next, jumper" background :total="postData.totalOfComment ? postData.totalOfComment : totalOfComment" :pager-count="getPaperSize" :page-size="per_page" :current-page.sync="page" @current-change="handleCommentCurrentChange"> </el-pagination>
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
    // console.log("kkk")
  },
  computed: {
    getPaperSize() {
      return window.ifMobileDevice === true ? 3 : 8
    }
  },
  methods: {
    changeShowStatus(){
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
        if (this.callback) {
          // debugger
        }
      })
    },

    // changeCommentCurrent(val) {
    //   this.commentPage = val
    //   this.getListOfComment(this.currentCommentId)
    // },

    commitComment() {
      this.hasCommitFinish = true
      axios.post(`${window.site_url}/wp-json/wp/v2/comments`, {
        post: this.postData.id,
        content: this.commentContent,
        parent: this.commentInfo.parentId ? this.commentInfo.parentId : "0",

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
    },
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