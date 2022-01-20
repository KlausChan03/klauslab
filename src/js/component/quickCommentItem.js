
const quickCommentItem =  Vue.component('quick-comment-item', {
  props: ['commentData'],
  mixins:[filterMixin],
  data() {
    return {
      commentContent: '',
    }
  },
  inject: ["commentInfo"],
  template: `
  <div>
    <ul class="comment-list" v-if="commentData && commentData.length > 0">
        <li v-for="(item,index) in commentData" :id="'comment-' + item.id" :key="item.id" class="comment-item" >
          <div class="comment-item-main flex-hl-vl">
            <div class="commentator-avatar">              
              <el-image class="avatar featured-image" v-if="item.author_avatar_urls?.[24]" :src="item.author_avatar_urls[24]" lazy alt="avatar">
                <div slot="error" class="image-slot">
                  <i class="el-icon-user-solid fs-24"></i>
                </div>
              </el-image>
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
                  <div class="comment-info flex-hb-vc">
                    <span class="comment-time">{{item.date | formatDate}}</span> 
                    <span class="reply flex-hr-vc">
                      <a @click="replyToThis(item)" rel="nofollow"  data-respondelement="respond" aria-label="" class="comment-reply-link">
                        <i class="lalaksks lalaksks-ic-reply"></i>
                      </a>
                    </span>
                  </div>
                </div>
              </div>
            </div>  
          </div>          
          <template v-if="item.children && item.children.length > 0">
            <quick-comment-item :comment-data="item.children" :style="{'padding-left': 50 + 'px' }"></quick-comment-item>
          </template>
        </li>
      </ul>
    </div>
    `,
  methods: {
    replyToThis(item){
      this.$nextTick(()=>{
        this.commentInfo.parentId = item.id      
        this.commentInfo.replyTo = item.author_name
      })
      
    }
  }
})