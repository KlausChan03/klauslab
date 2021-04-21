
// let quickCommentItem = require('./qickCommentItem.js');
Vue.component('quick-comment', {
  props: ['commentData','postData','tinyKey'],
  data() {
    return {
      commentContent: '',
      hasCommitFinish: false,
      ifShowCommentAll: false,
      ifMobileDevice: window.ifMobileDevice,
      per_page: 10,
      page: 1,
      commentInfo: {
        replyTo: '',
        parentId: '',
      }

    }
  },
  provide() {
    return {
      commentInfo: this.commentInfo
    };
  },
  components: {
    'editor': Editor, // <- Important part
    // 'quick-comment-item' : quickCommentItem
},
  template: `
  <div id="comments" v-loading="!ifShowCommentAll" class="comment-container" style="margin: 0; padding: 1.0rem 1.6rem; position: relative; border-top: 1px solid #eee;">
      <quick-comment-item :comment-data="commentData"></quick-comment-item>    
      <div class="flex-hc-vc m-tb-10" v-if="postData.totalOfComment > 10">
        <el-pagination layout="prev, pager, next, jumper" background :total="postData.totalOfComment" :pager-count="getPaperSize" :page-size="per_page" :current-page.sync="page" @current-change="handleCommentCurrentChange"> </el-pagination>
      </div>
    <div class="comment-input">
      <editor :api-key="tinyKey" cloud-channel="5" :disabled=false id="uuid" :setting="{inline: false}" :init="{  
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
          bullist numlist  | help'}" initial-value="" :inline=false model-events="" plugins="" tag-name="div" toolbar="" v-model="commentContent"  />
        <div class="flex-hb-vc mt-10">
          <span>{{commentInfo.replyTo ? '@' + commentInfo.replyTo : ''}}</span>
          <span>
            <el-button size="mini" type="default" @click="cancelReply()" v-show="commentInfo.parentId">取消回复</el-button>
            <el-button size="mini" type="primary" @click="commitComment()" :loading="hasCommitFinish">提交</el-button>
          </span>        
      </div>
    </div>
  </div>
    `,
  mounted() {
    setTimeout(() => {
      this.ifShowCommentAll = true      
    }, 1500);
  },
  computed: {
    getPaperSize() {
        return this.ifMobileDevice === true ? 3 : 8
    }
  },
  methods: {
    commitComment(){
      this.hasCommitFinish = true
      axios.post(`${GLOBAL.homeUrl}/wp-json/wp/v2/comments`, {
        post:this.postData.id,
        content: this.commentContent,
        parent: this.commentInfo.parentId ? this.commentInfo.parentId : "0",
        
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
          this.$parent.$parent.$parent.getListOfComment(this.postData.id, 1);
          this.commentContent = ''
          this.hasCommitFinish = false
          this.cancelReply()
          this.$forceUpdate()
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
    },
    handleCommentCurrentChange(val){
      this.$emit('change', val)
    },
    cancelReply(){
      this.commentInfo.parentId = ''
      this.commentInfo.replyTo = ''
    }
  }
})