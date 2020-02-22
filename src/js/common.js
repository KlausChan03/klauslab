

$(document).on("click", ".collapse-btn", function () {
    var this_ = $(this),
        this_dom = $(this).parent().parent().siblings(".entry-main").find(".entry-main-excerpt");

    this_dom.removeClass("hide");
    this_dom.siblings().addClass("hide");

    this_.siblings().removeClass("hide").addClass("show");
    this_.removeClass("show").addClass("hide");
});

$(document).on("click", ".expand-btn", function () {
    var this_ = $(this),
        this_id = $(this).data("id"),
        this_action = $(this).data("action"),
        this_dom = $(this).parent().parent().siblings(".entry-main").find(".entry-main-detail");

    var req = {
        action: "preview_post",
        um_id: this_id,
        um_action: this_action
    };
    $.post(`${GLOBAL.homeUrl}/wp-admin/admin-ajax.php`, req, function (res) {
        var content = res;
        this_dom.removeClass("hide").html(content);
        this_dom.siblings().addClass("hide");
        this_.siblings().removeClass("hide").addClass("show");
        this_.removeClass("show").addClass("hide");
    });
});

$(document).on("click", "#menu-avatar", function (e) {
    var theEvent = window.event || e;
    theEvent.stopPropagation();
    $('#personal-menu').fadeToggle(250);
});

$(document).on("click", "#Addlike", function () {
    if ($(this).hasClass("actived")) {
        alert("您已经赞过啦~");
    } else {
        $(this).addClass("actived");
        var z = $(this).data("id"),
            y = $(this).data("action"),
            x = $(this).children(".count");
        var w = {
            action: "like_post",
            um_id: z,
            um_action: y
        };
        $.post(`${GLOBAL.homeUrl}/wp-admin/admin-ajax.php`, w, function (res) {
            console.log(res)

        });
        return false;
    }
});

function kl_count(_time, _dom, _content) {

    _time = _time.replace(/-/g, "/");

    // 计算出相差毫秒
    var create_time = new Date(_time);
    var now_time = new Date();
    var count_time = now_time.getTime() - create_time.getTime()

    //计算出相差天数
    var days = Math.floor(count_time / (24 * 3600 * 1000))

    //计算出相差小时数
    var leave = count_time % (24 * 3600 * 1000)
    var hours = Math.floor(leave / (3600 * 1000))

    //计算相差分钟数
    var leave = leave % (3600 * 1000)
    var minutes = Math.floor(leave / (60 * 1000))

    //计算相差秒数
    var leave = leave % (60 * 1000)
    var seconds = Math.round(leave / 1000)

    var _time = days + " 天 " + hours + " 时 " + minutes + " 分 " + seconds + " 秒 ";
    var _final = _content + _time;
    document.querySelector(_dom).innerHTML = _final;
}

let blog_create_time, our_love_time, our_info, photo_container = document.querySelector('.photo-container');
let timer = new Vue({
    el: '#created-time',
    data: { content: null },
    mounted: function () {
        const h = this.$createElement;
        let params = new FormData;
        params.append('action', 'love_time');
        axios.post(`${GLOBAL.homeUrl}/wp-admin/admin-ajax.php`, params).then((res) => {
            blog_create_time = res.data[0].user_registered; // 博客建立时间（根据第一个用户诞生时间）
            our_love_time = `2015-05-23 20:00:00`; // 恋爱时间
            our_info = [res.data[1].nickname, res.data[1].img, res.data[2].nickname, res.data[1].img];
            if (photo_container) {
                photo_container.innerHTML = ` <span class="m-lr-10"><img src="https://${our_info[1]}"></span> <i class="lalaksks lalaksks-ic-heart-2 throb"></i> <span class="m-lr-10"><img src="https://${our_info[3]}"></span> `;
            }
            return our_love_time, blog_create_time;
        })
    },
})

let archiveFilter = new Vue({
    el: '#archive-main',
    data: {
        archiveContent: '',
        filterContent:'',
        filterArr: [],
    },
    methods: {
        choose: function ($event) {
            let params = new FormData;
            params.append('action', 'filter_archive');
            if ($event.target.attributes['data-type']) {
                this.filterArr[0] = $event.target.attributes['data-type'].value;
            }
            if ($event.target.attributes['data-author']) {
                this.filterArr[1] = $event.target.attributes['data-author'].value;
            }
            this.filterContent = this.filterArr.join(',');
            params.append('filter', this.filterArr);
            axios.post(`${GLOBAL.homeUrl}/wp-admin/admin-ajax.php`, params).then((res) => {
                this.archiveContent = res.data;
            })

        }
    }

})



// 滚动触发事件 (Sidebar固定、Header动画)
$(".widget-area .widget-content > aside").addClass("animated");
$(window).scroll(function () {
    var doc = document,
        win = window,
        $scrollBottom = $(doc).height() - $(win).height() - $(win).scrollTop(),
        $scrollTop = $(win).scrollTop();
    var direction, header = $(".site-header");

    if ($(window).width() > 1000 && $(document).height() > 1500) {
        $(window).resize(function () { $(".widget-area .widget-content").width($(".widget-area").width()); });

        if ($(this).scrollTop() >= 2000) {
            $(".widget-area .widget-content").addClass("is-fixed");
            $(".widget-area .widget-content").width($(".widget-area").width());
            $(".widget_custom_html").removeClass("f_i_r ds-block").addClass("f_o_r ds-none h-0")
            $(".widget_wp_statistics_widget").removeClass("f_i_r ds-block").addClass("f_o_r ds-none h-0")
            $(".widget_categories").removeClass("f_o_r ds-none h-0").addClass("f_i_r ds-block")
            $(".widget_recent_comments").removeClass("f_o_r ds-none h-0").addClass("f_i_r ds-block")
            $(".widget_tag_cloud").removeClass("f_o_r ds-none h-0").addClass("f_i_r ds-block")
        } else if ($(this).scrollTop() < 2000 && $(this).scrollTop() > 800) {
            $(".widget-area .widget-content").addClass("is-fixed");
            $(".widget-area .widget-content").width($(".widget-area").width());
            $(".widget_custom_html").removeClass("f_o_r ds-none h-0").addClass("f_i_r ds-block")
            $(".widget_wp_statistics_widget").removeClass("f_o_r ds-none h-0").addClass("f_i_r ds-block")
            $(".widget_categories").removeClass("f_i_r ds-block").addClass("f_o_r ds-none h-0")
            $(".widget_recent_comments").removeClass("f_i_r ds-block").addClass("f_o_r ds-none h-0")
            $(".widget_tag_cloud").removeClass("f_i_r ds-block").addClass("f_o_r ds-none h-0")
        } else if ($(this).scrollTop() >= 0 && $(this).scrollTop() < 800) {
            $(".widget-area .widget-content").removeClass("is-fixed");
            $(".widget_custom_html").removeClass("f_o_r ds-none h-0").addClass("ds-block")
            $(".widget_wp_statistics_widget").removeClass("f_o_r ds-none h-0").addClass("ds-block")
            $(".widget_tag_cloud").removeClass("f_o_r ds-none h-0").addClass("ds-block")
            $(".widget_categories").removeClass("f_o_r ds-none h-0").addClass("ds-block")
            $(".widget_recent_comments").removeClass("f_o_r ds-none h-0").addClass("ds-block")
        }

        if ($scrollBottom < 80) {
            $(".widget-area .widget-content").addClass("is-bottom")
        } else {
            $(".widget-area .widget-content").removeClass("is-bottom");
        }

        /*滚轮事件只有firefox比较特殊，使用DOMMouseScroll; 其他浏览器使用mousewheel;*/
        document.body.addEventListener("DOMMouseScroll", function (event) {
            direction = event.detail && (event.detail > 0 ? "mousedown" : "mouseup");
        });

        document.body.onmousewheel = function (event) {
            event = event || window.event;
            direction = event.wheelDelta && (event.wheelDelta > 0 ? "mouseup" : "mousedown");
            if (direction == "mouseup" || $scrollTop == 0) {
                header.removeClass("slideOutUp ds-none").addClass("slideInDown ds-block");
            } else {
                header.removeClass("slideInDown ds-block").addClass("slideOutUp ds-none");
            }
        };
    } else {
        $(".widget-area .widget-content").removeClass("is-fixed animated");
    }
})

// $(document).on("mouseover mouseout", "img", function (event) {
//     var _this = $(this);
//     console.log(_this.css("width"), $(this).css("width"))
//     var _this_parent = $(this).parent();
//     if (event.type == "mouseover") {
//         _this_parent.css({"width":_this.css("width"),"height":_this.css("height"),"overflow":"hidden","display":"inline-block"})
//         _this.addClass("extend-img");
//     } else {
//         _this_parent.css({"width":"auto","height":"auto","overflow":"visible"})
//         _this.removeClass("extend-img");
//     }
// })

function kl_count(_time, _dom, _content) {
    if(_time){
        _time = _time.replace(/-/g, "/");
    }

    // 计算出相差毫秒
    var create_time = new Date(_time);
    var now_time = new Date();
    var count_time = now_time.getTime() - create_time.getTime()

    //计算出相差天数
    var days = Math.floor(count_time / (24 * 3600 * 1000))

    //计算出相差小时数
    var leave = count_time % (24 * 3600 * 1000)
    var hours = Math.floor(leave / (3600 * 1000))

    //计算相差分钟数
    var leave = leave % (3600 * 1000)
    var minutes = Math.floor(leave / (60 * 1000))

    //计算相差秒数
    var leave = leave % (60 * 1000)
    var seconds = Math.round(leave / 1000)

    var _time = days + " 天 " + hours + " 时 " + minutes + " 分 " + seconds + " 秒 ";
    var _final = _content + _time;
    document.querySelector(_dom).innerHTML = _final;
}


// 滚动触发事件 (Sidebar固定、Header动画) 
// 功能尚有瑕疵
$(".widget-area .widget-content > aside").addClass("animated");
$("#custom_html-4").removeClass("f_i_r ds-block").addClass("f_o_r ds-none h-0");
$(window).scroll(function () {
    var doc = document,
        win = window,
        $scrollBottom = $(doc).height() - $(win).height() - $(win).scrollTop(),
        $scrollTop = $(win).scrollTop();
    var direction, header = $(".site-header");

    if ($(window).width() > 1000 && $(document).height() > 1500) {
        $(window).resize(function () { $(".widget-area .widget-content").width($(".widget-area").width()); });


            if ($(this).scrollTop() >= 2000) {
                $(".widget-area .widget-content").addClass("is-fixed");
                $(".widget-area .widget-content").width($(".widget-area").width());
                $(".widget_custom_html").removeClass("f_i_r ds-block").addClass("f_o_r ds-none h-0")
                $(".widget_wp_statistics_widget").removeClass("f_i_r ds-block").addClass("f_o_r ds-none h-0")
                $(".widget_categories").removeClass("f_o_r ds-none h-0").addClass("f_i_r ds-block")
                $(".widget_recent_comments").removeClass("f_o_r ds-none h-0").addClass("f_i_r ds-block")
                $(".widget_tag_cloud").removeClass("f_o_r ds-none h-0").addClass("f_i_r ds-block")
            } else if ($(this).scrollTop() < 2000 && $(this).scrollTop() > 800) {
                $(".widget-area .widget-content").addClass("is-fixed");
                $(".widget-area .widget-content").width($(".widget-area").width());
                $(".widget_custom_html").removeClass("f_o_r ds-none h-0").addClass("f_i_r ds-block")
                $(".widget_wp_statistics_widget").removeClass("f_o_r ds-none h-0").addClass("f_i_r ds-block")
                $(".widget_categories").removeClass("f_i_r ds-block").addClass("f_o_r ds-none h-0")
                $(".widget_recent_comments").removeClass("f_i_r ds-block").addClass("f_o_r ds-none h-0")
                $(".widget_tag_cloud").removeClass("f_i_r ds-block").addClass("f_o_r ds-none h-0")
            } else if ($(this).scrollTop() >= 0 && $(this).scrollTop() < 800) {
                $(".widget-area .widget-content").removeClass("is-fixed");
                $(".widget_custom_html").removeClass("f_o_r ds-none h-0").addClass("ds-block")
                $(".widget_wp_statistics_widget").removeClass("f_o_r ds-none h-0").addClass("ds-block")
                $(".widget_tag_cloud").removeClass("f_o_r ds-none h-0").addClass("ds-block")
                $(".widget_categories").removeClass("f_o_r ds-none h-0").addClass("ds-block")
                $(".widget_recent_comments").removeClass("f_o_r ds-none h-0").addClass("ds-block")
            }

   

        if ($scrollBottom < 80) {
            $(".widget-area .widget-content").addClass("is-bottom")
        } else {
            $(".widget-area .widget-content").removeClass("is-bottom");
        }

        /*滚轮事件只有firefox比较特殊，使用DOMMouseScroll; 其他浏览器使用mousewheel;*/
        document.body.addEventListener("DOMMouseScroll", function (event) {
            direction = event.detail && (event.detail > 0 ? "mousedown" : "mouseup");
        });

        document.body.onmousewheel = function (event) {
            event = event || window.event;
            direction = event.wheelDelta && (event.wheelDelta > 0 ? "mouseup" : "mousedown");
            if (direction == "mouseup" || $scrollTop == 0) {
                header.removeClass("slideOutUp ds-none").addClass("slideInDown ds-block");
            } else {
                header.removeClass("slideInDown ds-block").addClass("slideOutUp ds-none");
            }
        };
    } else {
        $(".widget-area .widget-content").removeClass("is-fixed animated");
    }
})

if (document.getElementById("createtime")) {
    setInterval(`kl_count(blog_create_time,'#createtime','运作了')`, 1000);
}
if (document.getElementById("lovetime")) {
    setInterval(`kl_count(our_love_time,'#lovetime','相恋了')`, 1000);
}
if (document.querySelector("#thisYear")) {
    const thisYear = document.querySelector("#thisYear");
    thisYear.innerHTML = new Date().getFullYear();
}
