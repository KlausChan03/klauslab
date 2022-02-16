// 全局变量
window._ = window.lodash;
window.if_mobile_device = document.body.clientWidth <= 1000 ? true : false;
window.now_full_year = new Date().getFullYear();
window.tinyKey = "7b4pdrcfzcszmsf2gjor1x94mha4srj4jalmdpq94fgpaa6j";
window._AMapSecurityConfig = {
  securityJsCode: "63ff502b168849801ec542fe31304563",
};

// 插件初始化
dayjs.locale("zh-cn");
dayjs.extend(window.dayjs_plugin_relativeTime);
dayjs.extend(window.dayjs_plugin_localizedFormat);


// 事件总线EventBus
const EventBus = new Vue();
Object.defineProperties(Vue.prototype, {
  $bus: {
    get: function () {
      return EventBus;
    },
  },
});

// 首屏加载Loading
if (window.is_home || window.is_single) {
  const max_timer = 2;
  const pageDom = document.querySelector("#page");
  const headerDom = document.querySelector("#header");
  const loadingDom = document.createElement("div");
  loadingDom.setAttribute("id", "loader-container");
  loadingDom.setAttribute("class", "loader-container");
  loadingDom.innerHTML =
    "<div class='loader-wrapper ☯-bg fadeOut animated'> <div class='☯'></div> </div>";
    pageDom.insertBefore(loadingDom, headerDom);
  setTimeout(() => {
    loadingDom && loadingDom.remove();
  }, max_timer * 1000);
  window.onload = function() {
    loadingDom && loadingDom.remove();
  };
}

const header = new Vue({
  el: "#header",
  components: {
    klSkeleton: klSkeleton,
    klSearch: klSearch,
  },
  data() {
    return {
      isLogin: window.is_login,
      isHome: window.is_home,
      isSingle: window.is_single,
      ifShowSearch: false,
      ifShowMenu: false,
      ifMobileDevice: window.if_mobile_device,
      bloginfoName: window.the_bloginfo_name,
      customLogo: window.the_custom_logo,
      userFullName: window.user_full_name,
      homeUrl: window.home_url,
      originMenuList: [],
      menuList: [],
      menuIcon: [
        { className: "home", iconName: "el-icon-house" },
        { className: "memory", iconName: "el-icon-film" },
        { className: "link", iconName: "el-icon-link" },
        { className: "archive", iconName: "el-icon-date" },
        { className: "about", iconName: "el-icon-user" },
      ],
    };
  },
  mounted() {
    const sessionFlag =
      _.isEmpty(JSON.parse(window.localStorage.getItem("menuList"))) ||
      _.isEmpty(JSON.parse(window.localStorage.getItem("baseInfo")))
        ? true
        : false;
    if (sessionFlag) {
      this.getMenuList();
      this.getBaseInfo();
    } else {
      this.originMenuList = this.menuList = JSON.parse(
        window.localStorage.getItem("menuList")
      );
    }
    // 动态图标
    var titleTime;
    var OriginTitile = document.title;
    document.addEventListener("visibilitychange", function () {
      if (document.hidden) {
        // var link =
        //   document.querySelector("link[rel*='icon']") ||
        //   document.createElement("link");
        // link.type = "image/x-icon";
        // link.rel = "shortcut icon";
        // link.href = "/favicon2.ico";
        // document.getElementsByTagName("head")[0].appendChild(link);
        document.title = "|ω･) 哎呦~页面不见了~";
        clearTimeout(titleTime);
      } else {
        // var link =
        //   document.querySelector("link[rel*='icon']") ||
        //   document.createElement("link");
        // link.type = "image/x-icon";
        // link.rel = "shortcut icon";
        // link.href = "/favicon.ico";
        // document.getElementsByTagName("head")[0].appendChild(link);
        document.title = "(/≧▽≦)/ 呦吼~肥来啦！";
        titleTime = setTimeout(function () {
          document.title = OriginTitile;
        }, 1000);
      }
    });
    window.addEventListener("resize", this.resizeHandler);
    window.addEventListener("scroll", this.scrollHandler);
  },
  destroyed() {
    window.onresize = null;
  },
  computed: {
    activeIndex() {
      for (let index = 0; index < this.originMenuList.length; index++) {
        const element = this.originMenuList[index];
        if (window.location.href === element.url) {
          return element.db_id.toString();
        }
      }
    },
  },
  methods: {
    changeMenu() {
      this.ifShowMenu = !this.ifShowMenu;
    },
    getBaseInfo() {
      axios
        .get(`${window.site_url}/wp-json/wp/v2/info`)
        .then((res) => {
          let data = res.data;
          window.localStorage.setItem("baseInfo", JSON.stringify(data));
        })
        .catch({});
    },
    getMenuList() {
      axios
        .get(`${window.site_url}/wp-json/wp/v2/menu`)
        .then((res) => {
          this.originMenuList = res.data;
          this.menuList = transData(
            res.data,
            "ID",
            "menu_item_parent",
            "children"
          );
          for (let i = 0; i < this.menuList.length; i++) {
            const element = this.menuList[i];
            for (let j = 0; j < this.menuIcon.length; j++) {
              const item = this.menuIcon[j];
              if (item.className === element.classes[0]) {
                element.iconName = item.iconName;
              }
            }
          }
          window.localStorage.setItem(
            "menuList",
            JSON.stringify(this.menuList)
          );
        })
        .catch();
    },
    showSearch() {
      this.ifShowSearch = true;
      this.$nextTick(() => {
        this.$refs.searchMain.$refs.searchInput.focus();
      });
    },
    handleChangeMenu(route, index) {
      window.localStorage.setItem("current-menu-item", index);
      this.goToPage(route);
    },
    goToPage(route, domain = false, params = "") {
      let url = "";
      url += domain ? `${window.home_url}/${route}` : route;
      url += params ? `?${convertObj(params)}` : "";
      window.location.href = url;
    },

    handleCommand(command) {
      if (!command) return;
      this.goToPage(command, true);
    },
    closeSearch() {
      this.ifShowSearch = false;
    },
    resizeHandler() {
      this.ifMobileDevice = document.body.clientWidth <= 1000 ? true : false;
    },
    scrollHandler() {
      // singgle页监听滚动设置目录插件的状态
      if (window.is_single) {
        const $content = $("#main"),
          $window = $(window),
          $catalog = $("#catalog-widget");
        const catalogHeight = window.sessionStorage.getItem("catalogHeight");
        if ($catalog.offset() && $catalog.offset().top && !catalogHeight) {
          window.sessionStorage.setItem("catalogHeight", $catalog.offset().top);
        }
        if ($window.width() > 1000 && $content.height() > 2000) {
          if ($window.scrollTop() >= catalogHeight) {
            $(".widget-area .widget-content").addClass("is-fixed");
            $(".widget-area .widget-content").width($(".widget-area").width());
            $(".widget-content .widget")
              .not(":last")
              .addClass("f_o_r ds-none h-0")
              .removeClass("ds-block");
            if (
              $content.height() - $catalog.height() - $window.scrollTop() <
              100
            ) {
              $(".widget-content .widget:last").css({
                "margin-top": "0",
                "margin-bottom": "95px",
              });
            } else {
              $(".widget-content .widget:last").css({
                "margin-top": "60px",
                "margin-bottom": "0",
              });
            }
          } else {
            $(".widget-area .widget-content").removeClass("is-fixed");
            $(".widget-content .widget")
              .not(":last")
              .removeClass("f_o_r ds-none h-0")
              .addClass("ds-block");
            $(".widget-content .widget:last").css("margin-top", "0");
          }
        } else {
          $(".widget-area .widget-content").removeClass("is-fixed animated");
        }
      }
      // 监听滚动设置header的状态
      const scrollY = window.pageYOffset;
      const header = document.querySelector("header");
      scrollY <= window.lastScroll
        ? (header.style.top = "0")
        : (header.style.top = "-60px");
      scrollY > 0
        ? (header.style.position = "fixed")
        : (header.style.position = "relative");
      window.lastScroll = scrollY;
    },
  },
});

const footer = new Vue({
  el: "#footer",
  data() {
    return {
      ifMobileDevice: window.if_mobile_device,
      icpNum: window.icp_num,
      startFullYear: window.start_full_year,
      nowFullYear: window.now_full_year,
    };
  },
});

const fixedPart = new Vue({
  el: "#fixed-plugins",
  data() {
    return {
      isLogin: window.is_login,
      searchValue: "",
      ifShowChangeMode: false,
      ifShowSearchFormDialog: false,
      season: "spring",
      mascot: {
        spring: "sakura",
        winter: "snow",
      },
    };
  },
  mounted() {
    window.onload = () => {
      this.init();
    };
    // 切换背景功能
    let [background_, background_in, background_out] = [
      document.querySelector(".fp-background"),
      document.querySelector(".fp-background-in"),
      document.querySelector(".fp-background-out"),
    ];
    background_ &&
      background_.addEventListener("mouseover", () => {
        removeClass(background_out, "hide");
        addClass(background_out, "show");
        background_out.querySelectorAll("li")[0].onclick = () => {
          Animation.closeGravity();
          Animation.closeSnow();
          Animation.snow(this.mascot[self.season], 60);
        };
        background_out.querySelectorAll("li")[0].ondblclick = () => {
          Animation.closeSnow();
        };
        background_out.querySelectorAll("li")[1].onclick = () => {
          Animation.closeSnow();
          Animation.closeGravity();
          Animation.gravity();
        };
        background_out.querySelectorAll("li")[1].ondblclick = () => {
          Animation.closeGravity();
        };
        background_out.querySelectorAll("li")[2].onclick = () => {
          Animation.closeGravity();
          Animation.closeSnow();
        };
      });

    background_ &&
      background_.addEventListener("mouseout", () => {
        removeClass(background_out, "show");
        addClass(background_out, "hide");
      });
  },
  methods: {
    init() {
      let myDate = new Date();
      let mymonth = myDate.getMonth() + 1;
      let today = dayjs(myDate).format("MM-DD");
      let todayWithYear = dayjs(myDate).format("YYYY-MM-DD");
      let MourningDate = ["04-04", "05-12", "12-13"];
      let ChristmasDate = ["12-24", "12-25"];
      let NewYearDate = ["2021-01-01"];
      let _html = document.querySelectorAll("html")[0];
      if (document.getElementsByClassName("widget").length > 0) {
        let _widget_userinfo = document
          .getElementsByClassName("widget")[0]
          .querySelectorAll(".user-bg")[0];
        for (let index = 0; index < MourningDate.length; index++) {
          if (today === MourningDate[index]) {
            _html.classList.add("mourning");
          }
        }
        for (let index = 0; index < ChristmasDate.length; index++) {
          if (today === ChristmasDate[index]) {
            _widget_userinfo.classList.add("christmas-bg");
          }
        }
        for (let index = 0; index < NewYearDate.length; index++) {
          if (todayWithYear === NewYearDate[index]) {
            _widget_userinfo.classList.add("newYear-bg");
          }
        }
      }
      if (1 < mymonth && mymonth <= 4) {
        this.season = "spring";
      } else if (10 < mymonth || mymonth <= 1) {
        this.season = "winter";
      }
    },
  },
});
