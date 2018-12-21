layui.define(function (exports) {
    layui.use(['jquery', 'layer'], function () {
        let [$, layer, Animation] = [layui.$, layui.layer, {}];

        Animation.canvas_bg = function () {
            function get_attribute(node, attr, default_value) {
                return node.getAttribute(attr) || default_value;
            }

            function get_by_tagname(name) {
                return document.getElementsByTagName(name);
            }

            function get_config_option() {
                var scripts = get_by_tagname("script"),
                    script_len = scripts.length,
                    script = scripts[script_len - 1];
                return {
                    l: script_len,
                    z: get_attribute(script, "zIndex", -1), //z-index
                    o: get_attribute(script, "opacity", 0.5), //opacity
                    c: get_attribute(script, "color", "0,0,0"), //color
                    n: get_attribute(script, "count", 99) //count
                };
            }

            function set_canvas_size() {
                canvas_width = the_canvas.width = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth,
                    canvas_height = the_canvas.height = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
            }

            function draw_canvas() {
                context.clearRect(0, 0, canvas_width, canvas_height);
                var e, i, d, x_dist, y_dist, dist;
                random_lines.forEach(function (r, idx) {
                    r.x += r.xa,
                        r.y += r.ya,
                        r.xa *= r.x > canvas_width || r.x < 0 ? -1 : 1,
                        r.ya *= r.y > canvas_height || r.y < 0 ? -1 : 1,
                        context.fillRect(r.x - 0.5, r.y - 0.5, 1.2, 1.2);
                    for (i = idx + 1; i < all_array.length; i++) {
                        e = all_array[i];
                        if (null !== e.x && null !== e.y) {
                            x_dist = r.x - e.x,
                                y_dist = r.y - e.y,
                                dist = x_dist * x_dist + y_dist * y_dist;
                            dist < e.max && (e === current_point && dist >= e.max / 2 && (r.x -= 0.03 * x_dist, r.y -= 0.03 * y_dist), //闈犺繎鐨勬椂鍊欏姞閫�
                                d = (e.max - dist) / e.max,
                                context.beginPath(),
                                context.lineWidth = d / 1,
                                context.strokeStyle = "rgba(" + config.c + "," + (d + 0.2) + ")",
                                context.moveTo(r.x, r.y),
                                context.lineTo(e.x, e.y),
                                context.stroke());
                        }
                    }
                }), frame_func(draw_canvas);
            }
            var the_canvas = document.createElement("canvas"),
                config = get_config_option(),
                canvas_id = "c_n" + config.l, //canvas id
                context = the_canvas.getContext("2d"),
                canvas_width, canvas_height,
                frame_func = window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame || window.oRequestAnimationFrame || window.msRequestAnimationFrame || function (func) {
                    window.setTimeout(func, 1000 / 45);
                },
                random = Math.random,
                current_point = {
                    x: null,
                    y: null,
                    max: 20000
                },
                all_array;
            the_canvas.id = canvas_id;
            the_canvas.style.cssText = "position:fixed;top:0;left:0;z-index:" + config.z + ";opacity:" + config.o;
            get_by_tagname("body")[0].appendChild(the_canvas);

            set_canvas_size(), window.onresize = set_canvas_size;
            window.onmousemove = function (e) {
                e = e || window.event, current_point.x = e.clientX, current_point.y = e.clientY;
            }, window.onmouseout = function () {
                current_point.x = null, current_point.y = null;
            };
            for (var random_lines = [], i = 0; config.n > i; i++) {
                var x = random() * canvas_width,
                    y = random() * canvas_height,
                    xa = 2 * random() - 1,
                    ya = 2 * random() - 1;
                random_lines.push({
                    x: x,
                    y: y,
                    xa: xa,
                    ya: ya,
                    max: 6000
                });
            }
            all_array = random_lines.concat([current_point]);
            setTimeout(function () {
                draw_canvas();
            }, 100);
        }

        // $("#categories-2 ul ul").addClass("animated zoomOut outsight").hide(200);
        // $("#categories-2 ul li").hover(function () {
        //     $(this).find("ul").removeClass("zoomOut outsight").addClass("zoomIn onsight").show(500)
        // }, function () {
        //     $(this).find("ul").removeClass("zoomIn onsight").addClass("zoomOut outsight").hide(500)
        // })

        $(document).on("click", ".collapse-btn", function () {
            var this_ = $(this),
                this_dom = $(this).parent().parent().siblings(".entry-main").find(".entry-main-excerpt");

            this_dom.removeClass("hide");
            this_dom.siblings().addClass("hide");

            this_.siblings().removeClass("hide").addClass("show");
            this_.removeClass("show").addClass("hide");
        })

        $(document).on("click", "#menu-avatar",function(e) {
            var theEvent = window.event || e;
            theEvent.stopPropagation();
            $('#personal-menu').fadeToggle(250);
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
            $.post("/wp-admin/admin-ajax.php", req, function (res) {
                var content = res;
                this_dom.removeClass("hide").html(content);
                this_dom.siblings().addClass("hide");

                this_.siblings().removeClass("hide").addClass("show");
                this_.removeClass("show").addClass("hide");

            });
        })

        $(document).on("click", "#Addlike", function () {
            if ($(this).hasClass("actived")) {
                layer.msg("您已经赞过啦~");
            } else {
                $(this).addClass("actived");
                var z = $(this).data("id"),
                    y = $(this).data("action"),
                    x = $(this).children(".count");
                var w = {
                    action: "inlo_like",
                    um_id: z,
                    um_action: y
                };
                $.post("/wp-admin/admin-ajax.php", w, function (res) {
                    $(x).html(res);
                    console.log(res)

                });
                return false;
            }
        });

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

        // 滚动触发事件
        $(window).scroll(function () {
            var doc = document,
                win = window,
                $scrollBottom = $(doc).height() - $(win).height() - $(win).scrollTop(),
                $scrollTop = $(win).scrollTop();

            var direction, header = $(".site-header");

            if ($(window).width() > 1000 && $(document).height() > 1500) {
                $(".widget-area .widget-content > aside").addClass("animated");
                $(window).resize(function() { $(".widget-area .widget-content").width($(".widget-area").width()); });

                if ($(this).scrollTop() > 800) {
                    $(".widget-area .widget-content").addClass("is-fixed");
                    $(".widget-area .widget-content").width($(".widget-area").width());             
                    $(".widget_custom_html").removeClass("fadeInRight onsight").addClass("fadeOutRight outsight h-0")
                    $(".widget_wp_statistics_widget").removeClass("fadeInRight onsight").addClass("fadeOutRight outsight h-0")
                    $(".widget_categories").removeClass("fadeOutRight outsight h-0").addClass("fadeInRight onsight")
                    $(".widget_recent_comments").removeClass("fadeOutRight outsight h-0").addClass("fadeInRight onsight")
                    $(".widget_tag_cloud").removeClass("fadeOutRight outsight h-0").addClass("fadeInRight onsight")
                } else {
                    $(".widget-area .widget-content").removeClass("is-fixed");
                    $(".widget_custom_html").removeClass("fadeOutRight outsight h-0").addClass("fadeInRight onsight")
                    $(".widget_wp_statistics_widget").removeClass("fadeOutRight outsight h-0").addClass("fadeInRight onsight")
                    $(".widget_tag_cloud").removeClass("fadeOutRight outsight h-0").addClass("fadeInRight onsight")
                    $(".widget_categories").removeClass("fadeOutRight outsight h-0").addClass("fadeInRight onsight")
                    $(".widget_recent_comments").removeClass("fadeOutRight outsight h-0").addClass("fadeInRight onsight")
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
                        header.removeClass("slideOutUp outsight").addClass("slideInDown onsight");
                    } else {
                        header.removeClass("slideInDown onsight").addClass("slideOutUp outsight");
                    }
                };

            } else {
                $(".widget-area .widget-content").removeClass("is-fixed animated");
            }

        })
        exports('canvas', Animation)

    })

})
