let filterMixin = {
    filters: {
        formateDate: (value) => {
            return dayjs(value).fromNow()
        },
        formateDateMain: (value) => {
            return dayjs(value).format('llll')
        }
    }
}