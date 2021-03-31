Vue.component('comment-item', {
  // props: ['postData'],
  template: `
  <p>hello</p>
    `,
    
  filters: {
    formateDate: (value) => {
      return dayjs(value).fromNow()
    }
  }
})