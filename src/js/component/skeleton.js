Vue.component('kl-skeleton', {
  props:["type"],
  data() {
    return {
      randomList: Math.round(Math.random() * 2) + 1,
    }
  },
  template: `
  <template>
    <div v-if="type === 'post'" class="kl-skeleton kl-skeleton-animated" id="kl-skeleton" >
      <div class="kl-skeleton-item" :style="{marginTop: Number(index) === 0 ? '0' : '0.8rem'}" v-for="(item,index) in randomList" >
        <div class="kl-skeleton-content">        
          <div class="kl-skeleton-line"></div>
          <div class="kl-skeleton-line"></div>
          <div class="kl-skeleton-line"></div>
          <div class="kl-skeleton-line"></div>
        </div>
      </div>
    </div>
    <div  v-else-if="type === 'single'" class="kl-skeleton kl-skeleton-animated" id="kl-skeleton" >
      <div class="kl-skeleton-title-container flex-hc-vc">
        <div class="kl-skeleton-title-line">Loading</div>
      </div>
      <div class="kl-skeleton-item">
        <div class="kl-skeleton-content">        
          <div class="kl-skeleton-line"></div>
          <div class="kl-skeleton-line"></div>
          <div class="kl-skeleton-line"></div>
          <div class="kl-skeleton-line"></div>
        </div>
      </div>
    </div>
  </template>
  `
})