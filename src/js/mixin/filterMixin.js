window.filterMixin = {
    filters: {
        formatDate: (value) => {
            return dayjs(value).fromNow()
        },
        formatDateToSecond: (value) => {
            return dayjs(value).format('YYYY-MM-DD HH:mm:ss')
        },
        formatDateToDay: (value) => {
          return dayjs(value).format('YYYY-MM-DD')
        },
        formatUserName: (value) => {
          return value.split('')[0].toUpperCase()
        }
    }
}