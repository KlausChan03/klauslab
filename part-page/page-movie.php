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
      <span class="secondary-color ml-10">{{tip}}</span>
    </div>
    <div class="tips mt-15 flex-hb-vc flex-hw" v-if="count">
      <div class="flex-hl-vc">
        <span class="mr-15">记录阅片数量：{{count}}</span>
        <span class="mr-15">筛选后：{{listCommon.length}}</span>
      </div>
      <div class="flex-hl-vc flex-hw" style="flex-wrap: wrap; gap: 10px;">
        <el-select v-model="filterYear" placeholder="年份" clearable style="width: 120px;" size="small" @change="handleFilterChange">
          <el-option v-for="year in yearOptions" :key="year" :label="year" :value="year"></el-option>
        </el-select>
        <el-select v-model="filterRating" placeholder="豆瓣评分" clearable style="width: 140px;" size="small" @change="handleFilterChange">
          <el-option label="9.0分以上" value="9.0"></el-option>
          <el-option label="8.0-9.0分" value="8.0"></el-option>
          <el-option label="7.0-8.0分" value="7.0"></el-option>
          <el-option label="6.0-7.0分" value="6.0"></el-option>
          <el-option label="6.0分以下" value="0"></el-option>
        </el-select>
        <el-select v-model="sortBy" placeholder="排序方式" style="width: 140px;" size="small" @change="handleSortChange">
          <el-option label="观看时间（最新）" value="date_desc"></el-option>
          <el-option label="观看时间（最早）" value="date_asc"></el-option>
          <el-option label="豆瓣评分（高→低）" value="rating_desc"></el-option>
          <el-option label="豆瓣评分（低→高）" value="rating_asc"></el-option>
          <el-option label="我的评分（高→低）" value="my_rating_desc"></el-option>
          <el-option label="我的评分（低→高）" value="my_rating_asc"></el-option>
          <el-option label="年份（新→旧）" value="year_desc"></el-option>
          <el-option label="年份（旧→新）" value="year_asc"></el-option>
        </el-select>
        <el-autocomplete v-model="state" :fetch-suggestions="querySearchAsync" placeholder="搜索电影名称" style="width: 200px;" size="small" @select="handleSelect" clearable>
          <el-button slot="append" icon="el-icon-search" @click="handleSearch"></el-button>
        </el-autocomplete>
      </div>
    </div>
    <div id="douban-movie-list" class="entry-content doubanboard-list" v-loading="loadingAll">
      <template v-if="count">
        <el-row v-bind:gutter="20">
          <el-col :span="6" :xs="24" :sm="12" :md="6" :lg="4" v-for="(item,index) in listCommon" :key="item.url" v-bind:class="'doubanboard-item'" v-if="item.url">
            <rotate-card trigger="hover" direction="row">
              <div slot="cz" v-if="item.url" v-bind:class="'doubanboard-thumb'" v-bind:style="{backgroundImage : 'url(' + item.img +')'}">
                <div class="doubanboard-title flex-hb-vc">
                  <a class="movie-title " v-bind:href="item.url" v-bind:title="item.name" target="_blank">{{ item.name }}</a>
                </div>
              </div>
              <div slot="cf" class="inner">
                <h3>{{item.name}}</h3>
                <p class="item-content mt-10" v-bind:title=item.remark>{{ item.remark || '暂无评价' }}</p>
                <p class="item-extra flex-hr-vc mt-5" style="flex-wrap: wrap; gap: 5px;">
                  <el-tag class="flex-hr-vc mr-5 fs-12" size="mini" effect="dark" v-if="item.mark_myself" type="warning">我的评分: {{ Number(item.mark_myself).toFixed(1) }}</el-tag>
                  <el-tag class="flex-hr-vc mr-5 fs-12" size="mini" effect="dark" type="success" v-if="item.mark_douban">豆瓣: {{ Number(item.mark_douban).toFixed(1) }}</el-tag>
                  <el-tag class="flex-hr-vc mr-5 fs-12" size="mini" v-if="item.year" type="info">{{ item.year }}年</el-tag>
                  <span class="fs-12 secondary-color">{{item.date}}</span>
                </p>
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
      title: window.the_titile,
      pageID: window.the_ID,
      tip: "单击卡片可以翻转查看详情",
      curBooks_read: 0,
      curBooks_reading: 0,
      curBooks_wish: 0,
      curMovies: 0,
      list: [],
      listFilter: [],
      count: 0,
      pageSize: 24,
      loadingAll: true,
      ifShowMore: false,
      queryData: [],
      state: '',
      timeout: null,
      filterYear: '',
      filterRating: '',
      sortBy: 'date_desc',
      yearOptions: []
    },
    mounted() {
      this.loadMovies();
      this.query()

    },
    computed: {
      listCommon() {
        let result = this.listFilter.length > 0 ? this.listFilter : this.list
        
        // 应用年份筛选
        if (this.filterYear) {
          result = result.filter(item => item.year === this.filterYear)
        }
        
        // 应用评分筛选
        if (this.filterRating) {
          const rating = parseFloat(this.filterRating)
          if (rating >= 9.0) {
            result = result.filter(item => item.mark_douban && parseFloat(item.mark_douban) >= 9.0)
          } else if (rating >= 8.0) {
            result = result.filter(item => item.mark_douban && parseFloat(item.mark_douban) >= 8.0 && parseFloat(item.mark_douban) < 9.0)
          } else if (rating >= 7.0) {
            result = result.filter(item => item.mark_douban && parseFloat(item.mark_douban) >= 7.0 && parseFloat(item.mark_douban) < 8.0)
          } else if (rating >= 6.0) {
            result = result.filter(item => item.mark_douban && parseFloat(item.mark_douban) >= 6.0 && parseFloat(item.mark_douban) < 7.0)
          } else if (rating === 0) {
            result = result.filter(item => item.mark_douban && parseFloat(item.mark_douban) < 6.0)
          }
        }
        
        // 应用排序
        result = this.applySort(result)
        
        return result
      }
    },
    methods: {
      loadMovies() {
        this.loadingAll = true;
        const params = {}
        params.db_id = window.db_id;
        params.pageSize = this.pageSize;
        params.type = 'movie';
        params.from = String(this.curMovies);
        const data = params ? `?${convertObj(params)}` : ''
        axios.post(window.ajaxSourceUrl + "/douban/douban.php" + data).then(res => {
          this.loadingAll = false;
          const result = res.data
          const code = Number(result.code)
          if (code === 1) {
            if (result.data && (result.data.length < this.pageSize)) {
              this.ifShowMore = false
            } else {
              this.ifShowMore = true
            }
            this.list = this.list.concat(result.data);
            // 移动端替换为大图
            if (window.if_mobile_device === true) {
              this.list.forEach(item => {
                item.img = item.img.replace(/s_ratio_poster/g, 'm_ratio_poster')
              });
            }
            this.count = result.total;
            if (this.list.length > 0 && this.list[0].name === '') {
              this.count = 0
            }
            // 提取年份选项
            this.extractYearOptions()
            this.curMovies += this.pageSize;
          } else if (code === 0) {
            this.$message({
              type: 'error',
              message: result.msg,
            })
          }
        });
      },
      query() {
        this.loadingAll = true
        axios.get(`${window.ajaxSourceUrl}/douban/cache/movie.json`).then(res => {
          this.queryData = res.data.data
          this.queryData.forEach((item) => {
            item.value = item.name
          })
          this.loadingAll = false
        }).catch((err) => {
          this.loadingAll = false
        })
      },
      querySearchAsync(queryString, cb) {
        var queryData = this.queryData;
        var results = queryString ? queryData.filter(this.createStateFilter(queryString)) : [];
        clearTimeout(this.timeout);
        this.timeout = setTimeout(() => {
          this.listFilter = results
          cb(results);
        }, 3000 * Math.random());
      },
      createStateFilter(queryString) {
        return (state) => {
          return (state.value.toLowerCase().indexOf(queryString.toLowerCase()) === 0);
        };
      },
      handleSelect(item) {
        // 搜索选中后，筛选列表
        this.listFilter = this.list.filter(movie => 
          movie.name.toLowerCase().includes(item.value.toLowerCase())
        )
      },
      handleSearch() {
        // 手动搜索
        if (this.state) {
          this.listFilter = this.list.filter(movie => 
            movie.name.toLowerCase().includes(this.state.toLowerCase())
          )
        } else {
          this.listFilter = []
        }
      },
      handleFilterChange() {
        // 筛选改变时，清空搜索
        this.listFilter = []
        this.state = ''
      },
      handleSortChange() {
        // 排序改变时，触发computed重新计算
        this.$forceUpdate()
      },
      applySort(list) {
        const sorted = [...list]
        switch (this.sortBy) {
          case 'date_desc':
            return sorted.sort((a, b) => {
              if (!a.date || !b.date) return 0
              return new Date(b.date) - new Date(a.date)
            })
          case 'date_asc':
            return sorted.sort((a, b) => {
              if (!a.date || !b.date) return 0
              return new Date(a.date) - new Date(b.date)
            })
          case 'rating_desc':
            return sorted.sort((a, b) => {
              const ratingA = parseFloat(a.mark_douban) || 0
              const ratingB = parseFloat(b.mark_douban) || 0
              return ratingB - ratingA
            })
          case 'rating_asc':
            return sorted.sort((a, b) => {
              const ratingA = parseFloat(a.mark_douban) || 0
              const ratingB = parseFloat(b.mark_douban) || 0
              return ratingA - ratingB
            })
          case 'my_rating_desc':
            return sorted.sort((a, b) => {
              const ratingA = parseFloat(a.mark_myself) || 0
              const ratingB = parseFloat(b.mark_myself) || 0
              return ratingB - ratingA
            })
          case 'my_rating_asc':
            return sorted.sort((a, b) => {
              const ratingA = parseFloat(a.mark_myself) || 0
              const ratingB = parseFloat(b.mark_myself) || 0
              return ratingA - ratingB
            })
          case 'year_desc':
            return sorted.sort((a, b) => {
              const yearA = parseInt(a.year) || 0
              const yearB = parseInt(b.year) || 0
              return yearB - yearA
            })
          case 'year_asc':
            return sorted.sort((a, b) => {
              const yearA = parseInt(a.year) || 0
              const yearB = parseInt(b.year) || 0
              return yearA - yearB
            })
          default:
            return sorted
        }
      },
      extractYearOptions() {
        // 从列表中提取所有年份
        const years = new Set()
        this.list.forEach(item => {
          if (item.year) {
            years.add(item.year)
          }
        })
        this.yearOptions = Array.from(years).sort((a, b) => parseInt(b) - parseInt(a))
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
        this.fn_reserve_action(this.surface)
        this.surface = !this.surface
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