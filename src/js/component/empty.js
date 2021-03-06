Vue.component('kl-empty', {
    template: `
        <div class="kl-empty">
            <div class="kl-empty__image">
                <img :src="getEmptyImgUrl(image)">
            </div>
            <div class="kl-empty__description">
                {{ description }}
            </div>            
            <div class="kl-empty__bottom">
                <slot></slot>
            </div>
        </div>
    `,
    data() {
        return {

        }
    },
    props: {
        description: {
            type: String,
            default: '暂无数据',
        },
        image: {
            type: String,
            default: 'default',
        },
    },
    methods: {
        getEmptyImgUrl(image) {
            var PRESETS = ['error', 'search', 'default', 'network'];
            if (PRESETS.indexOf(image) !== -1) {
                return 'https://img.yzcdn.cn/vant/empty-image-' + image + '.png';
            }
            return image;
        },
    },
})