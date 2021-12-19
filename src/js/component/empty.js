Vue.component('el-empty', {
    template: `
        <div class="el-empty">
            <div class="el-empty__image">
                <img :src="getEmptyImgUrl(image)">
            </div>
            <div class="el-empty__description">
                {{ description }}
            </div>            
            <div class="el-empty__bottom">
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