
Vue.component('comment-item', {
  props: ['postData'],
  template: `
  <div id="comments" class="comment-container" style="margin: 0; padding: 1.0rem 1.6rem; position: relative; border-top: 1px solid #eee;">
    <ul class="comment-list">
      <li v-for="(item,index) in postData" :id="'comment-' + item.id" :key="item.id" class="comment-item flex-hl-vl">
        <div class="commentator-avatar">
          <img alt="avatar" :src="item.author_avatar_urls[48]"  height="32" width="32" class="avatar avatar-32 photo">
        </div>
        <div class="commentator-content">
          <span class="commentator-name">
            <a :href="item.author_url" rel="external nofollow ugc" class="url">
              {{item.author_name}}
            </a>
          </span>
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
  </div>
    `,
    mounted() {
      console.log(this.postData)
    },
  filters: {
    formateDate: (value) => {
      return dayjs(value).fromNow()
    }
  }
})