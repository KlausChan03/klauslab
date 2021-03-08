Vue.component('chat-item', {
  props: ['postData'],
  template: `
  <div>
    <div class="entry-main" >
      <p class="col-">#{{postData.title.rendered}}#</p>
      <p class="entry-summary" v-html="postData.content.rendered" :id="postData.id"> </p>
    </div>
    <div class="entry-footer flex-hb-vc flex-hw">
      <div class="entry-action flex-hb-vc flex-hw">
        <div class="entry-author  fs-16 flex-hl-vc">
          <img :src="postData._embedded.author[0].avatar_urls[48]" alt="" class="mr-5" style="width:32px;height:32px;">
          <div class="flex-v flex-hc-vt">
            <span class="fs-12">{{postData._embedded.author[0].name}}</span>
            <span class="fs-12">{{postData.date | formateDate}}</span>
          </div>
        </div>
        <div class="entry-view flex-hl-vc">
          <i class="lalaksks lalaksks-ic-view mr-5"></i><span>{{postData.post_metas.views}}</span>
        </div>
        <div class="entry-comment flex-hl-vc">
          <i class="lalaksks lalaksks-ic-reply mr-5 pt-5" :style='{color:postData.post_metas.comments_num > 0 ? "#4488EE":"inhert"}'></i>
          <span :style='{color:postData.post_metas.comments_num > 0 ? "#4488EE":"inhert"}'>{{postData.post_metas.comments_num > 0 ? postData.post_metas.comments_num : ''}}</span>
        </div>
        <div class="entry-zan flex-hl-vc" style="cursor:not-allowed">
          <el-tooltip content="开发中" effect="dark" placement="top">
            <div>
              <i class="lalaksks lalaksks-ic-zan fs-16 mr-5" :style='{color:postData.post_metas.zan_num > 0 ? "#FFB11B":"inhert"}'></i>
              <span :style='{color:postData.post_metas.zan_num > 0 ? "#FFB11B":"inhert"}'>{{postData.post_metas.zan_num}}</span>
            </div>
          </el-tooltip>
        </div>
      </div>
    </div>
    </div>
    `,
  filters: {
    formateDate: (value) => {
      return dayjs(value).fromNow()
    }
  }
})