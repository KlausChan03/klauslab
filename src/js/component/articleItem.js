Vue.component('article-item', {
	props: ['postData'],
	mixins: [filterMixin],
	data() {
		return {
			ifMobileDevice: window.ifMobileDevice,
			ifShowLocationPopup: false,

		}
	},
	// template: `
	// <el-tooltip content="开发中" effect="dark" placement="top">
	//   <div class="entry-zan flex-hc-vc flex-1-3" style="cursor:not-allowed">
	//       <i class="lalaksks lalaksks-ic-zan fs-16 " :style='{color:postData.post_metas.zan_num > 0 ? "#DD4422":"inhert"}'></i>
	//       <span :style='{color:postData.post_metas.zan_num > 0 ? "#DD4422":"inhert"}'>{{postData.post_metas.zan_num > 0 ? postData.post_metas.zan_num : 0}}</span>
	//   </div>
	// </el-tooltip>`,
	template: `
  <div>
    <div class="entry-header flex-hb-vc flex-hw">
      <h5 class="entry-title">
        <a :href="postData.link"> {{postData.title.rendered}} </a>       
      </h5>
      <div class="entry-tag">
        <el-tag class="ml-10" size="small" type="danger" v-if="postData.sticky">TOP</el-tag>
        <el-tag class="ml-10" size="small" type="danger" v-if="postData.newest">NEW</el-tag>
        <el-tag class="ml-10" size="small" type="danger" v-if="postData.hotest">HOT</el-tag>
        <el-tag class="ml-10" size="small" v-for="(item,index) in postData.post_metas.tag_name">
          {{item}}
        </el-tag>
        <el-tag type="warning" class="ml-10" size="small" v-for="(item,index) in postData.post_metas.cat_name">
          {{item}}
        </el-tag>
      </div>     
    </div>
    <div class="entry-main flex-hl-vl flex-hw" :class="{'has-image' : postData?.post_img?.url}" v-if="postData.content.rendered || postData.excerpt.rendered">
			<el-image class="featured-image" :src="postData.post_img.url" lazy v-if="postData?.post_img?.url">
				<div slot="error" class="image-slot">
					<i class="el-icon-picture-outline fs-24"></i>
				</div>
			</el-image>
			<div>
      	<p class="entry-summary" v-html="postData.ifShowAll ? postData.content.rendered : postData.excerpt.rendered" :id="postData.id"></p>
				<p @click="showLocation(postData.post_metas.position)" v-if="postData.post_metas.address" class="fs-12 col-aaa cur-p"> <i class="el-icon-map-location mr-5" ></i> {{ postData.post_metas.address }} </p>
			</div>
    </div>
    <div class="entry-footer flex-hb-vc flex-hw">
      <div class="entry-action flex-hb-vc flex-hw w-1" v-if="!ifMobileDevice">
        <div class="entry-author fs-16 flex-hl-vc">
          <div v-html="postData.post_metas.avatar" class="mr-10"></div>
          <div class="flex-v flex-hc-vt">
            <span class="fs-12">{{postData.post_metas.author}}</span>
            <el-tooltip class="item" effect="dark" :content="postData.date | formateDateMain" placement="bottom">
              <span class="fs-12" >{{postData.date | formateDate}}</span>
            </el-tooltip>
          </div>
        </div>
        <div class="entry-action-main flex-hb-vc" style="flex:1 0 auto">
          <div class="entry-view flex-hc-vc flex-1-3">
            <i class="lalaksks lalaksks-ic-view " ></i>
            <span :style='{"font-size": Number(postData.post_metas.views) >= 1000 ? 12 + "px" : 14 + "px" }'>{{postData.post_metas.views}}</span>
          </div>
          <div class="entry-comment flex-hc-vc flex-1-3" @click="showComment(postData.id)">
            <i class="lalaksks lalaksks-ic-reply cur-p " :style='{color:postData.post_metas.comments_num > 0 ? "#4488EE":"inhert"}'></i>
            <span :style='{color:postData.post_metas.comments_num > 0 ? "#4488EE":"inhert"}'>{{postData.post_metas.comments_num > 0 ? postData.post_metas.comments_num : 0}}</span>
          </div>         
          <div class="entry-zan flex-hc-vc flex-1-3" @click="likeOrDislikePost(postData,'like')">
              <i class="lalaksks lalaksks-ic-zan fs-16 cur-p" :style='{color:postData.post_metas.zan_num > 0 ? "#DD4422":"inhert", background: postData.post_metas.has_zan ? "#F5B4A7" : "inhert"}'></i>
              <span :style='{color:postData.post_metas.zan_num > 0 ? "#DD4422":"inhert"}'>{{postData.post_metas.zan_num > 0 ? postData.post_metas.zan_num : 0}}</span>
          </div>
          <div class="entry-cai flex-hc-vc flex-1-3" @click="likeOrDislikePost(postData,'dislike')">
              <i class="lalaksks lalaksks-ic-zan fs-16 cur-p" style="transform: rotateX(180deg)" :style='{color:postData.post_metas.cai_num > 0 ? "#36292F":"inhert", background: postData.post_metas.has_cai ? "#856D72" : "inhert"}'></i>
              <span :style='{color:postData.post_metas.cai_num > 0 ? "#36292F":"inhert"}'>{{postData.post_metas.cai_num > 0 ? postData.post_metas.cai_num : 0}}</span>
          </div>
        </div> 
        <div class="entry-extra" style="min-width:100px;text-align:right" v-if="!ifMobileDevice">
          <button v-if="!postData.ifShowAll" @click="changeIfShowAllToParent(postData.id)" class="kl-btn kl-btn-sm gradient-blue-red border-n">预览全文</button>
          <button v-if="postData.ifShowAll" @click="changeIfShowAllToParent(postData.id)" class="kl-btn kl-btn-sm gradient-red-blue border-n">收起全文</button> 
        </div>        
      </div>
      <div class="entry-action w-1" v-if="ifMobileDevice">
        <div class="flex-hb-vc mb-10">
          <div class="entry-author fs-16 flex-hl-vc">
						<div v-html="postData.post_metas.avatar" class="mr-10"></div>
							<div class="flex-v flex-hc-vt">
								<span class="fs-12">{{postData.post_metas.author}}</span>
								<el-tooltip class="item" effect="dark" :content="postData.date | formateDateMain" placement="bottom">
									<span class="fs-12" >{{postData.date | formateDate}}</span>
								</el-tooltip>
							</div>
						</div>
						<div class="entry-extra" style="min-width:100px;text-align:right">
							<button v-if="!postData.ifShowAll" @click="changeIfShowAllToParent(postData.id)" class="kl-btn kl-btn-sm gradient-blue-red border-n">预览全文</button>
							<button v-if="postData.ifShowAll" @click="changeIfShowAllToParent(postData.id)" class="kl-btn kl-btn-sm gradient-red-blue border-n">收起全文</button> 
						</div>
					</div>  
					<div class="entry-action-main flex-hb-vc" style="flex:1 0 auto">
						<div class="entry-view flex-hc-vc flex-1-3">
							<i class="lalaksks lalaksks-ic-view " ></i>
							<span :style='{"font-size": Number(postData.post_metas.views) >= 1000 ? 12 + "px" : 14 + "px" }'>{{postData.post_metas.views}}</span>
						</div>
						<div class="entry-comment flex-hc-vc flex-1-3" @click="showComment(postData.id)">
							<i class="lalaksks lalaksks-ic-reply " :style='{color:postData.post_metas.comments_num > 0 ? "#4488EE":"inhert"}'></i>
							<span :style='{color:postData.post_metas.comments_num > 0 ? "#4488EE":"inhert"}'>{{postData.post_metas.comments_num > 0 ? postData.post_metas.comments_num : 0}}</span>
						</div>         
						<div class="entry-zan flex-hc-vc flex-1-3" @click="likeOrDislikePost(postData,'like')">
								<i class="lalaksks lalaksks-ic-zan fs-16 cur-p" :style='{color:postData.post_metas.zan_num > 0 ? "#DD4422":"inhert", background: postData.post_metas.has_zan ? "#F5B4A7" : "inhert"}'></i>
								<span :style='{color:postData.post_metas.zan_num > 0 ? "#DD4422":"inhert"}'>{{postData.post_metas.zan_num > 0 ? postData.post_metas.zan_num : 0}}</span>
						</div>
						<div class="entry-cai flex-hc-vc flex-1-3" @click="likeOrDislikePost(postData,'dislike')">
								<i class="lalaksks lalaksks-ic-zan fs-16 cur-p" style="transform: rotateX(180deg)" :style='{color:postData.post_metas.cai_num > 0 ? "#36292F":"inhert", background: postData.post_metas.has_cai ? "#856D72" : "inhert"}'></i>
								<span :style='{color:postData.post_metas.cai_num > 0 ? "#36292F":"inhert"}'>{{postData.post_metas.cai_num > 0 ? postData.post_metas.cai_num : 0}}</span>
						</div>
					</div>							
				</div>
      </div>
			<el-dialog :visible.sync="ifShowLocationPopup" fullscreen show-close>
				<div id="location-container" class="location-container"> </div>
				<div class="location-info flex-hc-vc flex-v">           
				</div>
			</el-dialog>
    </div>
    `,
	methods: {
		showLocation (position) {
      const positionArr = position.split(',')
      this.ifShowLocationPopup = true
      this.$nextTick(() => {
				const map = new AMap.Map('location-container', {
					resizeEnable: true,
          zoom: 16,
          center: positionArr,
				})
				const marker = new AMap.Marker();
        map.add(marker);
        marker.setPosition(positionArr);				
			})
    },
		changeIfShowAllToParent(id) {
			this.$emit('change-type', id)
		},
		showComment(id) {
			this.$emit('show-comment', id)
		},
		likeOrDislikePost(item, action) {
			let params = {}
			params.id = item.id
			params.action = action
			if (item.post_metas.has_zan || item.post_metas.has_cai) {
				this.$message({
					message: '你已经评价过！',
					type: 'warning',
				})
				return false
			}
			if (action === 'dislike') {
				this.$confirm('点踩会打击作者的创作积极性, 是否继续?', '提示', {
					confirmButtonText: '确定',
					cancelButtonText: '取消',
					type: 'warning',
				})
					.then(() => {
						axios
							.post(`${window.site_url}/wp-json/wp/v2/likePost`, params, {
								headers: {
									'X-WP-Nonce': _nonce,
								},
							})
							.then((res) => {
								this.$nextTick(() => {
									console.log(this.postData.post_metas)
									this.$set(
										this.postData.post_metas,
										action === 'like' ? 'zan_num' : 'cai_num',
										res.data
									)
									this.$set(
										this.postData.post_metas,
										action === 'like' ? 'has_zan' : 'has_cai',
										true
									)
									this.$message({
										message: action === 'like' ? '点赞成功！' : '点踩成功！',
										type: 'success',
									})
								})
							})
					})
					.catch(() => {
						return false
					})
			} else {
				axios
					.post(`${window.site_url}/wp-json/wp/v2/likePost`, params, {
						headers: {
							'X-WP-Nonce': _nonce,
						},
					})
					.then((res) => {
						this.$nextTick(() => {
							console.log(this.postData.post_metas)
							this.$set(
								this.postData.post_metas,
								action === 'like' ? 'zan_num' : 'cai_num',
								res.data
							)
							this.$set(
								this.postData.post_metas,
								action === 'like' ? 'has_zan' : 'has_cai',
								true
							)
							this.$message({
								message: action === 'like' ? '点赞成功！' : '点踩成功！',
								type: 'success',
							})
						})
					})
			}
		},

		resizeHandler() {
			this.ifMobileDevice = document.body.clientWidth <= 1000 ? true : false
		},
	},
	mounted() {
		window.addEventListener('resize', this.resizeHandler)
	},
})
