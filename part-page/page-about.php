<?php

/**
 *  @package KlausLab
 *  Template Name: 关于
 *  author: Klaus
 */
get_header();
?>
<link rel="stylesheet" href="<?php echo KL_THEME_URI; ?>/css/page/about.css" rel="preload">
<script>
  window.post_id = '<?php echo get_the_ID(); ?>';
  window.the_titile = "<?php echo the_title() ?>";
  window.the_ID = "<?php echo the_ID() ?>";
</script>


<div id="container" class="page-main main-area w-1 style-18" :class="'post-'+pageID" v-cloak>
  <el-card shadow="hover">
    <div class="entry-title flex-hl-vc bor-b-1">
      <svg class="icon icon-title mr-10" aria-hidden="true">
        <use xlink:href="#lalaksks21-stats"></use>
      </svg>
      <h2>{{pageInfo.title.rendered}}</h2>
    </div>
    <div class="entry-content page-content" v-loading="!ifShowAll" style="min-height: 300px">
      <template v-if="Array.isArray(info) && info.length > 0">
        <el-collapse v-model="activeNames" class="info-main" v-for="(item,index) in info" :key="item.name">
          <el-collapse-item :name="index">
            <template slot="title">
              <h3>{{item.name}}</h3>
            </template>
            <template v-if="item.value && item.value.length > 0">
              <template v-if="item.type === 'simple'">
                <template v-for="(sonItem,sonIndex) in item.value">
                  <span :key="item.type + sonIndex" v-html="sonItem"> </span>
                  <span class="m-lr-5" style="font-weight: bold" v-if="(sonIndex < item.value.length - 1) && (sonItem.indexOf('br') < 0)">|</span>
                </template>
              </template>

              <template v-else-if="item.type === 'complexList'">
                <ul>
                  <li v-for="(sonItem,sonIndex) in item.value" class="flex-hl-vc flex-hw" :key="item.type + sonIndex">
                    <span :title="sonItem.tips">{{sonItem.item}}<label class="ml-10">{{sonItem.params}}</label></span>
                    <el-rate v-model="sonItem.rate" disabled show-score text-color="#ff9900" score-template="{value}"></el-rate>
                  </li>
                </ul>
              </template>
              <template v-else-if="item.type === 'list'">
                <ul>
                  <li v-for="(sonItem,sonIndex) in item.value" v-html="sonItem" :key="item.type + sonIndex"></li>
                </ul>
              </template>
              <template v-else-if="item.type === 'introduction'">
                <p v-for="(sonItem,sonIndex) in item.value" :key="item.type + sonIndex" v-html="sonItem"></p>
              </template>
              <template v-else-if="item.type === 'version-timeline'">
                <el-timeline>
                  <template v-for="(sonItem,sonIndex) in item.value">
                    <el-timeline-item :key="sonIndex" :timestamp="sonItem.date | formatDateToSecond" placement="top">
                      <el-card shadow="hover">
                        <h4>{{sonItem.version}}{{sonItem.versionName}}</h4>
                        <p>{{sonItem.description}}</p>
                        <p v-if="sonItem.author && sonItem.date">{{sonItem.author}} 提交于 {{ sonItem.date | formatDateToSecond }}</p>
                      </el-card>
                    </el-timeline-item>
                  </template>
                </el-timeline>
              </template>
              <template v-else-if="item.type === 'project'">
                <div class="flex-hl-vc block" v-for="(sonItem,sonIndex) in item.value" :key="sonItem.item">
                  <div class="flex-hc-vc flex-v">
                    <el-image style="width: 100px; height: 100px" :src="sonItem.url" fit="cover"></el-image>
                    <span class="mt-5">{{ sonItem.item }}</span>
                  </div>
                </div>
              </template>
              <template v-else-if="item.type === 'resume'">
                <template v-if="Array.isArray(item.value) && item.value.length > 0">
                  <ul>
                    <li v-for="(sonItem,sonIndex) in item.value" v-html="sonItem" :key="sonItem"></li>
                  </ul>
                </template>
                <template v-else>
                  <p>{{item.value}}</p>
                </template>
              </template>
            </template>
            <template v-else>
              <el-empty description="暂无数据"></el-empty>
            </template>
          </el-collapse-item>
        </el-collapse>
      </template>
      <template v-else>
        <el-empty description="暂无数据"></el-empty>
      </template>
    </div>
    <div class="entry-footer flex-hc-vc">
      <template v-if="pageInfo.post_metas.reward === '0' ? false : true">
        <kl-reward></kl-reward>
      </template>
    </div>
  </el-card>
  <aside id="comment-part" class="comment-container mt-10">
    <template v-if="pageInfo.comment_status === 'open'">
      <h3 class="tips-header flex-hl-vc"><i class="el-icon-chat-line-round fs-24 mr-10"></i>评论区</h3>
      <quick-comment :post-data="pageInfo"></quick-comment>
    </template>
  </aside>
</div>

<script type="text/javascript" src="<?php echo KL_THEME_URI; ?>/js/mixin/pageMixin.js"></script>
<script type="text/javascript" src="<?php echo KL_THEME_URI; ?>/js/mixin/filterMixin.js"></script>
<script type="text/javascript" src="<?php echo KL_THEME_URI; ?>/js/component/reward.js"></script>
<script type="text/javascript" src="<?php echo KL_THEME_URI; ?>/js/component/quickCommentItem.js" defer></script>
<script type="text/javascript" src="<?php echo KL_THEME_URI; ?>/js/component/quickComment.js" defer></script>

<script defer>
  const app = new Vue({
    el: '#container',
    mixins: [pageMixin, filterMixin],
    components: {
      klReward: klReward
    },
    data() {
      return {
        title: window.the_titile,
        pageID: window.the_ID,
        postID: window.post_id,
        listContent: '',
        ifGetList: false,
        info: [],
        ifShowAll: false,
        ifShowPayImage: true,
        commentPage: 1,
        activeNames: [0, 1, 2, 3],
        fits: ['fill', 'contain', 'cover', 'none', 'scale-down'],
      }
    },
    mounted() {
      this.getInfo()
    },
    methods: {
      goToPage(route, params = false) {
        if (params) {
          window.location.href = `${window.home_url}/${route}`
        } else {
          window.location.href = route
        }
      },
      getInfo() {
        this.ifShowAll = false
        axios.get(`${window.ajaxSourceUrl}/about/aboutme.json`).then(res => {
          this.info = res.data ? res.data : ''
          this.ifShowAll = true
        }).catch((err)=>{
          this.ifShowAll = true
          this.info = []
        })
      },
      changeChoose() {
        this.ifShowPayImage = !this.ifShowPayImage
      }
    }
  })
</script>
<?php get_footer();
