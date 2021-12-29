
const typeMap = {
  article: "post",
  chat: "moments",
};
const index_module = new Vue({
  el: "#post-container",
  mixins: [filterMixin],
  data() {
    return {
      isSidebar: window.is_sidebar,
      ifMobileDevice: window.if_mobile_device,
      listOfAll: [],
      listOfArticle: [],
      listOfChat: [],
      total: 0,
      totalOfArticle: 0,
      totalOfChat: 0,
      ifShowPost: false,
      ifShowChat: false,
      ifShowAll: true,
      postType: "article",
      posts_id_sticky: "",
      orderby: "date",
      currentCommentId: "",
      imgList: [],
      imageUrl: "",
      imageUrls: [],
      page: 1,
      per_page: {
        article: 6,
        chat: 10,
      },
      orderbyList: [
        {
          type: "date",
          name: "创建时间",
        },
        {
          type: "modified",
          name: "更新时间",
        },
      ],
    };
  },
  mounted() {
    window.addEventListener("resize", this.resizeHandler);
    this.init();
  },
  computed: {
    getOrderby() {
      return this.orderbyList.find((item) => {
        return item.type === this.orderby;
      }).name;
    },
    getCurrent() {
      return this.per_page[this.postType];
    },
    getTotal() {
      if (this.postType === "article") {
        return this.totalOfArticle;
      } else if (this.postType === "chat") {
        return this.totalOfChat;
      }
    },
    judgeCount() {
      if (this.postType === "article") {
        return this.listOfArticle.length > this.per_page;
      } else if (this.postType === "chat") {
        return this.listOfChat.length > this.per_page;
      }
    },
  },

  methods: {
    async init() {
      const { postType } = this;
      const postCount = await this.getPostCount(this.postType);
      this.per_page[postType] = postCount;
      if (postCount !== 0) {
        postType === "article"
          ? await this.getAllArticles()
          : await this.getAllChat();
      } else {
        this[postType === "article" ? "ifShowPost" : "ifShowChat"] = true;
      }
    },
    getListByType(type) {
      if (type === "article") {
        this.getAllArticles();
      } else if (type === "chat") {
        this.getAllChat();
      }
    },

    getPostCount(type) {
      return axios
        .get(`${window.site_url}/wp-json/wp/v2/getPostCount`, {
          params: { type: typeMap[type] },
        })
        .then((res) => {
          return Math.min(res.data.count, this.per_page[this.postType]);
        });
    },

    getStickyArticles(params) {
      return axios
        .get(`${window.site_url}/wp-json/wp/v2/posts?sticky=true`, {
          params: params,
        })
        .then((res) => {
          const data = res.data;
          // 获取顶置文章 IDs 以在获取其余文章时排除
          for (var i = 0; i < data.length; i++) {
            this.posts_id_sticky += "," + data[i].id;
          }
          this.listOfArticle = data;
          this.ifShowPost = true;
          return data;
        });
    },
    getCommonArticles(params) {
      params.exclude = this.posts_id_sticky;
      return axios
        .get(`${window.site_url}/wp-json/wp/v2/posts`, {
          params: params,
        })
        .then((res) => {
          const data = res.data;
          this.totalOfArticle = parseInt(res.headers["x-wp-total"]);
          return data;
        });
    },
    renderAllArticles(stickyArticles, commonArticles) {
      const listOfArticle = stickyArticles.concat(commonArticles);
      listOfArticle.forEach((element) => {
        element.ifShowAll = false;
        element.ifShowComment = false;
        if (
          element.date &&
          Number(dayjs(new Date()).diff(dayjs(element.date), "week")) === 0
        ) {
          element.newest = true;
        }
        if (
          element.post_metas.comments_num >= 10 ||
          element.post_metas.zan_num >= 10
        ) {
          element.hotest = true;
        }
      });
      this.listOfArticle = listOfArticle;
      this.ifShowPost = true;
      this.$nextTick(() => {
        this.bindImagesLayer();
      });
    },
    async getAllArticles() {
      this.ifShowPost = false;
      this.listOfArticle = [];
      const params = {
        page: this.page,
        per_page: this.per_page[this.postType],
        orderby: this.orderby,
      };
      let [stickyArticles, commonArticles] = [[], []];
      if (this.page === 1) {
        stickyArticles = await this.getStickyArticles(params);
        commonArticles = await this.getCommonArticles(params);
      } else {
        commonArticles = await this.getCommonArticles(params);
      }
      await this.renderAllArticles(stickyArticles, commonArticles);
    },

    getAllChat() {
      this.ifShowChat = false;
      let params = {};
      params.page = this.page;
      params.per_page = this.per_page[this.postType];
      params.orderby = this.orderby;
      axios
        .get(`${window.site_url}/wp-json/wp/v2/moments`, {
          params: params,
        })
        .then((res) => {
          this.totalOfChat = parseInt(res.headers["x-wp-total"]);
          this.listOfChat = res.data;
          this.ifShowChat = true;
          this.listOfChat.forEach((element) => {
            element.ifShowComment = false;
            if (
              element.date &&
              Number(dayjs(new Date()).diff(dayjs(element.date), "week")) === 0
            ) {
              element.newest = true;
            }
            if (
              element.post_metas.comments_num >= 10 ||
              element.post_metas.zan_num >= 10
            ) {
              element.hotest = true;
            }
            if (element.content.rendered.indexOf("img") > 0) {
              element.content.rendered = element.content.rendered.replace(
                /(flex-hb-vc)/g,
                "flex"
              );
            }
          });
          this.$nextTick(() => {
            this.bindImagesLayer();
          });
        });
    },

    handleCurrentChange(val) {
      this.page = val;
      this.getListByType(this.postType);
      this.$nextTick(() => {
        document.querySelectorAll("#page")[0].scrollTop = 0;
      });
    },

    changeType(tab, event) {
      this.page = 1;
      this.postType = tab.label;
      this[this.postType === "article" ? "ifShowPost" : "ifShowChat"] = false;
      this.init();
    },

    changeItemType(id) {
      this.listOfArticle.forEach((item) => {
        if (item.id === id) {
          item.ifShowAll = !item.ifShowAll;
        }
      });
      this.listOfArticle.splice(0, 0);
    },

    showItemComment(id) {
      this[
        this.postType === "article" ? "listOfArticle" : "listOfChat"
      ].forEach((element, index) => {
        if (element.id === id) {
          // this.currentCommentId = id
          if (element.ifShowComment === false) {
            element.ifShowComment = true;
            this.$nextTick(() => {
              setTimeout(() => {
                this.$refs["quickComment-" + id][0].getListOfComment(id);
              }, 20);
            });
          } else {
            element.ifShowComment = false;
          }
        } else {
          element.ifShowComment = false;
        }
        this.$forceUpdate();
      });
    },

    handleCommand(type) {
      this.orderby = type;
      this.getListByType(this.postType);
    },

    resizeHandler() {
      this.ifMobileDevice = document.body.clientWidth <= 1000 ? true : false;
    },

    bindImagesLayer() {
      let self = this;
      let imgList = document.querySelectorAll(".entry-summary img");
      for (let index = 0; index < imgList.length; index++) {
        const element = imgList[index];
        element &&
          element.addEventListener("click", function (event) {
            event.preventDefault();
            self.imageUrls = [];
            let url = element.getAttribute("src");
            debugger;
            if (!self.imageUrls.includes(url)) {
              self.imageUrls.push(url);
            }
            self.$nextTick(() => {
              self.imageUrl = url;
            });
            setTimeout(() => {
              document.querySelectorAll(".image-part img")[0].click();
            }, 100);
          });
      }
    },
  },
});
