window.filterMixin = {
    filters: {
        formatDate: (value) => {
            return dayjs(value).fromNow()
        },
        formatDateToSecond: (value) => {
            return dayjs(value).format('YYYY-MM-DD HH:mm:ss')
        },
        formatDateToSecond: (value) => {
          return dayjs(value).format('YYYY-MM-DD')
        }
    }
}