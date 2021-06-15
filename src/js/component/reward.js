Vue.component('kl-reward', {
    data() {
        return {
            ifShowPayImage: true,
            wechat_img: '',
            alipay_img: '',
            theme_url: '',
        }
    },
    methods: {
        changeChoose() {
            this.ifShowPayImage = !this.ifShowPayImage
        }
    },
    mounted() {
        if(window.localStorage.getItem('baseInfo')){
            let info = JSON.parse(window.localStorage.getItem('baseInfo'))
            this.wechat_img = info.wechat_attachment[0]
            this.alipay_img = info.alipay_attachment[0]
            this.theme_url = info.theme_url
        }
    },
    template: `
    <el-popover placement="top" title="请作者喝杯咖啡☕" width="280" trigger="click">
        <div class="pay-body">       
                <template v-if="alipay_img && wechat_img">    
                    <h4 class="flex-hc-vc m-tb-10">扫一扫支付</h4>
                    <div class="flex-hc-vc">
                        <img class="alipay" :src="alipay_img" v-show="ifShowPayImage" />
                        <img class="wechatpay" :src="wechat_img" v-show="!ifShowPayImage" />
                    </div>
                    <div class="pay-chose flex-hb-vc mt-15">
                        <button class="alibutton" :class="{'chosen':ifShowPayImage}" :disabled="ifShowPayImage" ref="alibutton" @click="changeChoose"><img :src="theme_url + '/img/alipay.png'" /></button>
                        <button class="wechatbutton" :class="{'chosen':!ifShowPayImage}" :disabled="!ifShowPayImage" ref="wechatbutton" @click="changeChoose"><img :src="theme_url + '/img/wechat.png'" /></button>
                    </div>
                </template>
                <template v-if="alipay_img && !wechat_img">
                    <h4 class="flex-hc-vc m-tb-10">扫一扫支付</h4>
                    <div class="flex-hc-vc">
                        <img class="alipay" :src="alipay_img" />
                    </div>
                </template>
                <template v-if="wechat_img && !alipay_img">
                    <h4 class="flex-hc-vc m-tb-10">扫一扫支付</h4>
                    <div class="flex-hc-vc">
                        <img class="wechatpay" :src="wechat_img" />
                    </div>
                </template>
                <template v-if="!wechat_img && !alipay_img">
                    <h4 class="flex-hc-vc m-tb-10">作者尚未添加打赏二维码！</h4>
                </template>
        </div>
        <el-button slot="reference" circle><i class="el-icon-coffee fs-20"></i></el-button>
    </el-popover>
    `,
})