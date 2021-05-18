let headerPart = new Vue({
    el: '#header',
    data() {
        return {
            ifShowSearch: false,
            ifMobileDevice: window.ifMobileDevice
        }
    },
    mounted() {
        window.onresize = () => {
            this.ifMobileDevice = document.body.clientWidth <= 1000 ? true : false
        }
        $(document).on("click", "#menu-avatar", function (e) {
            var theEvent = window.event || e;
            theEvent.stopPropagation();
            $('#personal-menu').fadeToggle(250);
        });

        (function () {
            var header, container, button, menu, links, subMenus, socialMenu;

            container = document.getElementById('site-navigation');
            if (!container) {
                return;
            }

            header = document.getElementsByClassName('menu-touch')[0];
            if (!header) {
                return;
            }

            button = document.getElementsByClassName('menu-toggle')[0];
            if ('undefined' === typeof button) {
                return;
            }

            menu = container.getElementsByClassName('menu')[0];
            socialMenu = container.getElementsByTagName('ul')[1];
            // Hide menu toggle button if both menus are empty and return early.
            if ('undefined' === typeof menu && 'undefined' === typeof socialMenu) {
                button.style.display = 'none';
                return;
            }

            menu.setAttribute('aria-expanded', 'false');
            if (-1 === menu.className.indexOf('nav-menu')) {
                menu.className += ' nav-menu';
            }
            button.onclick = function () {
                if (-1 !== container.className.indexOf('toggled')) {
                    container.className = container.className.replace('toggled', '');
                    header.className = header.className.replace('toggled', '');
                    button.setAttribute('aria-expanded', 'false');
                    menu.setAttribute('aria-expanded', 'false');
                    socialMenu.setAttribute('aria-expanded', 'false');
                } else {
                    container.className += ' toggled';
                    header.className += ' toggled';
                    button.setAttribute('aria-expanded', 'true');
                    menu.setAttribute('aria-expanded', 'true');
                    socialMenu.setAttribute('aria-expanded', 'true');
                }
            };

            // Get all the link elements within the menu.
            links = menu.getElementsByTagName('a');
            subMenus = menu.getElementsByTagName('ul');

            // Set menu items with submenus to aria-haspopup="true".
            for (var i = 0, len = subMenus.length; i < len; i++) {
                subMenus[i].parentNode.setAttribute('aria-haspopup', 'true');
            }

            // Each time a menu link is focused or blurred, toggle focus.
            for (i = 0, len = links.length; i < len; i++) {
                links[i].addEventListener('focus', toggleFocus, true);
                links[i].addEventListener('blur', toggleFocus, true);
            }

            /**
             * Sets or removes .focus class on an element.
             */
            function toggleFocus() {
                var self = this;

                // Move up through the ancestors of the current link until we hit .nav-menu.
                while (-1 === self.className.indexOf('nav-menu')) {

                    // On li elements toggle the class .focus.
                    if ('li' === self.tagName.toLowerCase()) {
                        if (-1 !== self.className.indexOf('focus')) {
                            self.className = self.className.replace(' focus', '');
                        } else {
                            self.className += ' focus';
                        }
                    }

                    self = self.parentElement;
                }
            }

            // Fix child menus for touch devices.
            function fixMenuTouchTaps(container) {
                var touchStartFn,
                    parentLink = container.querySelectorAll('.menu-item-has-children > a, .page_item_has_children > a');

                if ('ontouchstart' in window) {
                    touchStartFn = function (e) {
                        var menuItem = this.parentNode;

                        if (!menuItem.classList.contains('focus')) {
                            e.preventDefault();
                            for (var i = 0; i < menuItem.parentNode.children.length; ++i) {
                                if (menuItem === menuItem.parentNode.children[i]) {
                                    continue;
                                }
                                menuItem.parentNode.children[i].classList.remove('focus');
                            }
                            menuItem.classList.add('focus');
                        } else {
                            menuItem.classList.remove('focus');
                        }
                    };

                    for (var i = 0; i < parentLink.length; ++i) {
                        parentLink[i].addEventListener('touchstart', touchStartFn, false)
                    }
                }
            }

            fixMenuTouchTaps(container);
        })();

    },
    methods: {
        showSearch() {
            this.ifShowSearch = true
            this.$nextTick(() => {
                this.$refs.searchMain.$refs.searchInput.focus()
            })
        },
        closeSearch() {
            this.ifShowSearch = false
        }
    },
})


let footPart = new Vue({
    el:'#footer',
    
})



// $(document).on("click", ".collapse-btn", function () {
//     var this_ = $(this),
//         this_dom = $(this).parent().parent().siblings(".entry-main").find(".entry-main-excerpt");

//     this_dom.removeClass("hide");
//     this_dom.siblings().addClass("hide");

//     this_.siblings().removeClass("hide").addClass("show");
//     this_.removeClass("show").addClass("hide");
// });

// $(document).on("click", ".expand-btn", function () {
//     var this_ = $(this),
//         this_id = $(this).data("id"),
//         this_action = $(this).data("action"),
//         this_dom = $(this).parent().parent().siblings(".entry-main").find(".entry-main-detail");

//     var req = {
//         action: "preview_post",
//         um_id: this_id,
//         um_action: this_action
//     };
//     $.post(`${window.site_url}/wp-admin/admin-ajax.php`, req, function (res) {
//         var content = res;
//         this_dom.removeClass("hide").html(content);
//         this_dom.siblings().addClass("hide");
//         this_.siblings().removeClass("hide").addClass("show");
//         this_.removeClass("show").addClass("hide");
//     });
// });

// $(document).on("click", "#Addlike", function () {
//     if ($(this).hasClass("actived")) {
//         alert("您已经赞过啦~");
//     } else {
//         $(this).addClass("actived");
//         var z = $(this).data("id"),
//             y = $(this).data("action"),
//             x = $(this).children(".count");
//         var w = {
//             action: "like_post",
//             um_id: z,
//             um_action: y
//         };
//         $.post(`${window.site_url}/wp-admin/admin-ajax.php`, w, function (res) {
//             console.log(res)

//         });
//         return false;
//     }
// });



// 滚动触发事件 (Sidebar固定、Header动画)
// $(".widget-area .widget-content > aside").addClass("animated");
// $(window).scroll(function () {
//     var doc = document,
//         win = window,
//         $scrollBottom = $(doc).height() - $(win).height() - $(win).scrollTop(),
//         $scrollTop = $(win).scrollTop();
//     var direction, header = $(".site-header");

//     // if ($(window).width() > 1000 && $(document).height() > 1500) {
//     //     $(window).resize(function () { $(".widget-area .widget-content").width($(".widget-area").width()); });

//     //     if ($(this).scrollTop() >= 2000) {
//     //         $(".widget-area .widget-content").addClass("is-fixed");
//     //         $(".widget-area .widget-content").width($(".widget-area").width());
//     //         $(".widget_custom_html").removeClass("f_i_r ds-block").addClass("f_o_r ds-none h-0")
//     //         $(".widget_recent_entries").removeClass("f_i_r ds-block").addClass("f_o_r ds-none h-0")
//     //         $(".widget_recent_comments").removeClass("f_i_r ds-block").addClass("f_o_r ds-none h-0")

//     //         $(".widget_categories").removeClass("f_o_r ds-none h-0").addClass("f_i_r ds-block")
//     //         $(".widget_tag_cloud").removeClass("f_o_r ds-none h-0").addClass("f_i_r ds-block")
//     //     } else if ($(this).scrollTop() < 2000 && $(this).scrollTop() > 800) {
//     //         $(".widget-area .widget-content").addClass("is-fixed");
//     //         $(".widget-area .widget-content").width($(".widget-area").width());
//     //         $(".widget_custom_html").removeClass("f_o_r ds-none h-0").addClass("f_i_r ds-block")
//     //         $(".widget_recent_entries").removeClass("f_o_r ds-none h-0").addClass("f_i_r ds-block")
//     //         $(".widget_recent_comments").removeClass("f_o_r ds-none h-0").addClass("f_i_r ds-block")

//     //         $(".widget_categories").removeClass("f_i_r ds-block").addClass("f_o_r ds-none h-0")
//     //         $(".widget_tag_cloud").removeClass("f_i_r ds-block").addClass("f_o_r ds-none h-0")
//     //     } else if ($(this).scrollTop() >= 0 && $(this).scrollTop() < 800) {
//     //         $(".widget-area .widget-content").removeClass("is-fixed");
//     //         $(".widget_custom_html").removeClass("f_o_r ds-none h-0").addClass("ds-block")
//     //         $(".widget_recent_entries").removeClass("f_o_r ds-none h-0").addClass("ds-block")
//     //         $(".widget_recent_comments").removeClass("f_o_r ds-none h-0").addClass("ds-block")

//     //         $(".widget_categories").removeClass("f_o_r ds-none h-0").addClass("ds-block")
//     //         $(".widget_tag_cloud").removeClass("f_o_r ds-none h-0").addClass("ds-block")
//     //     }

//     //     if ($scrollBottom < 80) {
//     //         $(".widget-area .widget-content").addClass("is-bottom")
//     //     } else {
//     //         $(".widget-area .widget-content").removeClass("is-bottom");
//     //     }

//     //     /*滚轮事件只有firefox比较特殊，使用DOMMouseScroll; 其他浏览器使用mousewheel;*/
//     //     document.body.addEventListener("DOMMouseScroll", function (event) {
//     //         direction = event.detail && (event.detail > 0 ? "mousedown" : "mouseup");
//     //     });

//     //     document.body.onmousewheel = function (event) {
//     //         event = event || window.event;
//     //         direction = event.wheelDelta && (event.wheelDelta > 0 ? "mouseup" : "mousedown");
//     //         if (direction == "mouseup" || $scrollTop == 0) {
//     //             header.removeClass("slideOutUp ds-none").addClass("slideInDown ds-block");
//     //         } else {
//     //             header.removeClass("slideInDown ds-block").addClass("slideOutUp ds-none");
//     //         }
//     //     };
//     // } else {
//     //     $(".widget-area .widget-content").removeClass("is-fixed animated");
//     // }
// })

// $(document).on("mouseover mouseout", "img", function (event) {
//     var self = $(this);
//     console.log(self.css("width"), $(this).css("width"))
//     var self_parent = $(this).parent();
//     if (event.type == "mouseover") {
//         self_parent.css({"width":self.css("width"),"height":self.css("height"),"overflow":"hidden","display":"inline-block"})
//         self.addClass("extend-img");
//     } else {
//         self_parent.css({"width":"auto","height":"auto","overflow":"visible"})
//         self.removeClass("extend-img");
//     }
// })