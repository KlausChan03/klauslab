<?php

/**
 *  @package KlausLab
 *  Template Name: 观影记录
 *  author: Klaus
 */
get_header();
?>

<link rel="stylesheet" href="<?php echo KL_THEME_URI; ?>/css/page/movie.css">
<script>
  window.db_id = "<?php echo cs_get_option('klausLab_db_id') ?>";
  window.the_titile = "<?php echo the_title() ?>";
  window.the_ID = "<?php echo the_ID() ?>";
</script>

<div id="container" class="page-main main-area w-1 style-18" :class="'post-'+pageID" v-cloak>
  <el-card shadow="hover">
    <div class="entry-title flex-hl-vc bor-b-1">
      <svg class="icon icon-title mr-10" aria-hidden="true">
        <use xlink:href="#lalaksks21-views"></use>
      </svg>
      <h2>{{title}}</h2>
    </div>
    <div class="tips mt-15" v-if="count">
      <span>记录阅片数量：{{count}}</span>
    </div>
    <div id="douban-movie-list" class="entry-content doubanboard-list" v-loading="loadingAll">
      <template v-if="count">
        <el-row v-bind:gutter="20">
          <el-col :span="6" :xs="24" :sm="12" :md="6" :lg="4" v-for="(item,index) in list" :key="item.url" v-bind:class="'doubanboard-item'" v-if="item.url">
            <rotate-card trigger="hover" direction="row">
              <div slot="cz" v-if="item.url" v-bind:class="'doubanboard-thumb'" v-bind:style="{backgroundImage : 'url(' + item.img +')'}">
                <div class="doubanboard-title flex-hb-vc">
                  <a class="movie-title w-06" v-bind:href="item.url" v-bind:title="item.name" target="_blank">{{item.name}}</a>
                  <div class="movie-mark flex-hr-vc w-04">
                    <span class="flex-hr-vc mr-5" v-if="item.mark_myself"><i class="lalaksks lalaksks-ic-tag"></i> {{item.mark_myself}}</span>
                    <span class="flex-hr-vc" v-if="item.mark_douban"><i class="lalaksks lalaksks-ic-douban"></i> {{item.mark_douban}}</span>
                  </div>
                </div>
              </div>
              <div slot="cf" v-bind:class="'inner'">
                <h3>{{item.name}}</h3>
                <p class="mt-10 item-content" v-bind:title=item.remark>{{item.remark}}</p>
                <p>{{item.date}}</p>
              </div>
            </rotate-card>
          </el-col>
        </el-row>
        <div class="flex-hc-vc mt-15">
          <el-button ref="getMoreButton" v-if="ifShowMore" id="loadMoreMovies" @click="loadMovies();">加载更多</el-button>
        </div>
      </template>
      <template v-else>
        <el-empty></el-empty>
      </template>
    </div>
  </el-card>
</div>

<script defer>
  const app = new Vue({
    el: "#container",
    data: {
      ifMobileDevice: window.if_mobile_device,
      title: window.the_titile,
      pageID: window.the_ID,
      curBooks_read: 0,
      curBooks_reading: 0,
      curBooks_wish: 0,
      curMovies: 0,
      list: [],
      count: 0,
      pageSize: 24,
      loadingAll: true,
      ifShowMore: false
    },
    mounted() {
      setTimeout(() => {
        this.loadMovies();
        
      }, 1000);
    },
    methods: {
      loadMovies: function() {
        this.loadingAll = true;
        const params = {}
        params.db_id = window.db_id;
        params.pageSize = this.pageSize;
        params.type = 'movie';
        params.from = String(this.curMovies);
        const data = params ? `?${convertObj(params)}` : ''
        axios.post(window.ajaxSourceUrl + "/douban/douban.php" + data).then(res => {
          const result = res.data
          const code = Number(result.code)
          if (code === 1) {
            if (result.data && (result.data.length < this.pageSize)) {
              this.ifShowMore = false
            } else {
              this.ifShowMore = true
            }
            this.list = this.list.concat(result.data);
            if (this.ifMobileDevice === true) {
              this.list.forEach(item => {
                item.img = item.img.replace(/s_ratio_poster/g, 'm_ratio_poster')
              });
            }
            this.count = result.total;
            if (this.list[0].name === '') {
              this.count = 0
            }
            this.curMovies += this.pageSize;
          } else if (code === 0) {
            this.$message({
              type: 'error',
              message: result.msg,
            })
          }
          this.loadingAll = false;

        });
      }
    },
  })
  Vue.component('rotate-card', {
    template: `
        <div class="card-3d" @click="eve_cardres_click">
            <div class="card card-z" ref="cardz">
                <slot name="cz"></slot>
            </div>
            <div :class="['card card-f',direction=='row'?'card-f-y':'card-f-x']" ref="cardf">
                <slot name="cf"></slot>
            </div>
        </div>
        `,
    props: {
      trigger: { //触发方式 hover click custom
        type: String,
        default: 'click' //默认点击触发
      },
      value: { //正反面
        type: Boolean,
        default: true
      },
      direction: { //方向 row col
        type: String,
        default: 'row'
      }
    },
    data() {
      return {
        surface: true
      }
    },
    watch: {
      value(bool) { //自定义触发方式
        if (this.trigger == 'custom') this.fn_reserve_action(bool)
      }
    },
    methods: {
      fn_reserve_action(bool) {
        var arr = this.direction == 'row' ? ['rotateY(180deg)', 'rotateY(0deg)'] : ['rotateX(-180deg)', 'rotateX(0deg)']
        this.$refs.cardz.style.transform = bool ? arr[0] : arr[1]
        this.$refs.cardf.style.transform = !bool ? arr[0] : arr[1]
      },
      eve_cardres_click() {
        // if (this.trigger == 'click') {
        this.fn_reserve_action(this.surface)
        this.surface = !this.surface
        // }
      },
      eve_cardres_msover() {
        if (this.trigger == 'hover') this.fn_reserve_action(true)
      },
      eve_cardres_msout() {
        if (this.trigger == 'hover') this.fn_reserve_action(false)
      }
    }
  })
</script>

<?php get_footer(); ?>