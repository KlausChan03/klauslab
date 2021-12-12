let filterMixin = {
    filters: {
        formateDate: (value) => {
            return dayjs(value).fromNow()
        },
        formateDateMain: (value) => {
            return dayjs(value).format('YYYY-MM-DD HH:mm:ss')
        }
    }
}