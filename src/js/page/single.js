dayjs.locale('zh-cn')
dayjs.extend(window.dayjs_plugin_relativeTime)

const index_module = new Vue({
    el: ".main-content",
    data() {
        return {
            ifShowSingle: false,
            ifMobileDevice: window.ifMobileDevice,
            post_id: window.post_id,
            posts: {
                post_metas:{
                    zan_num: 0,
                    comments_num: 0,
                }
            },
            ifShowPayImage: true,
        }
    },
    created() {
        this.getAllArticles()
    },
    mounted() {
        setTimeout(() => {
            this.owoEmoji();
            this.commentsSubmit();
            
        }, 3000);
    },
    methods: {

        getAllArticles() {
            this.ifShowSingle = false
            let params = {};
            return axios.get(`${GLOBAL.homeUrl}/wp-json/wp/v2/posts/${this.post_id}`, {
                params: params
            }).then(res => {
                console.error(this.posts)
                this.$nextTick(() => {
                    this.ifShowSingle = true
                    this.posts = res.data;
                })
            })
        },

        goAnchor(selector) {
            var anchor = this.$el.querySelector(selector) // 参数为要跳转到的元素id
            this.$nextTick(() => {
                console.log(anchor.offsetTop)
                // document.body.scrollTop = anchor.offsetTop // chrome
                document.documentElement.scrollTop = anchor.offsetTop // firefox
                document.querySelectorAll("#page")[0].scrollTop = anchor.offsetTop
            })

        },

        owoEmoji() {
            var $body = (window.opera) ? (document.compatMode == "CSS1Compat" ? $('html') : $('body')) : $('html,body');
            $('.OwO').each(function (i, block) {
                var s = new OwO({
                    logo: '<i class="lalaksks lalaksks-ic-emoji"></i> Emoji',
                    container: document.getElementsByClassName('OwO')[0],
                    target: document.getElementsByClassName('error')[0],
                    position: 'down',
                    width: '400px',
                    maxHeight: '200px',
                    api: GLOBAL.homeSourceUrl + "/emoji/OwO.min.json"
                });
            });
        },

        commentsSubmit() {
            let _this = this
            var edit_again = KlausLabConfig.commentEditAgain,
                edt1 = '提交成功，在刷新页面之前你可以<a rel="nofollow" class="comment-reply-link" href="#edit" onclick=\'return addComment.moveForm("',
                edt2 = ')\'>重新编辑</a>',
                cancel_edit = '放弃治疗',
                edit, re_edit, num = 1,
                comm_array = [],
                $body, wait = 10,
                $comments = $('.post-comment-num a'), // 评论数的 ID
                $cancel = $('#cancel-comment-reply-link'),
                cancel_text = $cancel.text(),
                $submit = $('#comment-form .comment-submit'),
                push_status = $('#comment-form .comment-submit.push-status');
            $submit.attr('disabled', false);
            comm_array.push(''); //重新编辑不显示内容
            // submit
            $('#comment-form').submit(function () {
                push_status.html('提交中...');
                $submit.attr('disabled', true).fadeTo('slow', 0.5);
                if (edit) $('#comment').after('<input type="text" name="edit_id" id="edit_id" value="' + edit + '" style="display:none;" />');
                // Ajax
                console.log($(this).serialize())
                $.ajax({
                    url: KlausLabConfig.ajaxUrl,
                    data: $(this).serialize() + "&action=ajax_comment",
                    type: $(this).attr('method'),
                    error: function (XmlHttpRequest, textStatus, errorThrown) {
                        push_status.html('重新提交');
                        // _this.createMessage(XmlHttpRequest.responseText, 3000);
                        _this.$message({
                            dangerouslyUseHTMLString: true,
                            message: XmlHttpRequest.responseText
                        })
                        setTimeout(function () {
                            $submit.attr('disabled', false).fadeTo('slow', 1);
                        }, 3000);
                    },
                    success: function (data) {
                        comm_array.push($('#comment').val());
                        $('textarea').each(function () {
                            this.value = ''
                        });
                        var t = addComment,
                            cancel = t.I('cancel-comment-reply-link'),
                            temp = t.I('wp-temp-form-div'),
                            respond = t.I(t.respondId),
                            post = t.I('comment_post_ID').value,
                            parent = t.I('comment_parent').value;
                        // comments
                        if (!edit && $comments.length) {
                            n = parseInt($comments.text().match(/\d+/));
                            $comments.text($comments.text().replace(n, n + 1));
                        }
                        // show comment
                        new_item = '"id="new-comment-' + num + '"></';
                        new_item = (parent == '0') ? ('\n<div class="new-comment' + new_item + 'div>') : ('\n<ol class="children' + new_item + 'ol>');
                        cue = '\n <div class="ajax-edit"><span class="edit-info" id="success-' + num + '">';
                        if (edit_again == 1) {
                            div_ = (document.body.innerHTML.indexOf('div-comment-') == -1) ? '' : ((document.body.innerHTML.indexOf('li-comment-') == -1) ? 'div-' : '');
                            cue = cue.concat(edt1, div_, 'comment-', parent, '", "', parent, '", "respond", "', post, '", ', num, edt2);
                        }
                        cue += '</span></div>\n';
                        if ((parent == '0')) {
                            if ($('.no-comment')[0]) {
                                $('.no-comment')[0].remove();
                            }
                            $('ol.memory-comments-area').prepend(new_item);
                        } else {
                            $('#respond').before(new_item);
                        }
                        $('#new-comment-' + num).hide().append(data).fadeIn(400); //插入新提交评论
                        $('#new-comment-' + num + ' li .comment-comment').prepend(cue);
                        CountDown();
                        num++;
                        edit = '';
                        $('*').remove('#edit_id');
                        cancel.style.display = 'none'; //“取消回复”消失
                        cancel.onclick = null;
                        t.I('comment_parent').value = '0';
                        if (temp && respond) {
                            temp.parentNode.insertBefore(respond, temp);
                            temp.parentNode.removeChild(temp)
                        }
                        $('#comment-validate').each(function () {
                            this.value = ''
                        });
                    }
                }); // end Ajax
                return false;
            }); // end submit
            // comment-reply.dev.js
            addComment = {
                moveForm: function (commId, parentId, respondId, postId, num) {
                    var t = this,
                        div, comm = t.I(commId),
                        respond = t.I(respondId),
                        cancel = t.I('cancel-comment-reply-link'),
                        parent = t.I('comment_parent'),
                        post = t.I('comment_post_ID');
                    console.log(respond, parent)
                    if (edit) PrevEdit();
                    num ? (
                        t.I('comment').value = comm_array[num],
                        edit = t.I('new-comment-' + num).innerHTML.match(/(comment-)(\d+)/)[2],
                        $new_sucs = $('#success-' + num), $new_sucs.hide(),
                        $new_comm = $('#new-comment-' + num), $new_comm.hide(),
                        $cancel.text(cancel_edit)
                    ) : $cancel.text(cancel_text);
                    t.respondId = respondId;
                    postId = postId || false;
                    if (!t.I('wp-temp-form-div')) {
                        div = document.createElement('div');
                        div.id = 'wp-temp-form-div';
                        div.style.display = 'none';
                        respond.parentNode.insertBefore(div, respond);
                    }!comm ? (
                        temp = t.I('wp-temp-form-div'),
                        t.I('comment_parent').value = '0',
                        temp.parentNode.insertBefore(respond, temp),
                        temp.parentNode.removeChild(temp)
                    ) : comm.parentNode.insertBefore(respond, comm.nextSibling);
                    if (post && postId) post.value = postId;
                    parent.value = parentId;
                    cancel.style.display = '';
                    cancel.onclick = function () {
                        if (edit) PrevEdit();
                        var t = addComment,
                            temp = t.I('wp-temp-form-div'),
                            respond = t.I(t.respondId);

                        t.I('comment_parent').value = '0';
                        if (temp && respond) {
                            temp.parentNode.insertBefore(respond, temp);
                            temp.parentNode.removeChild(temp);
                            $('#comment').val('');
                        }
                        this.style.display = 'none';
                        this.onclick = null;
                        return false;
                    };
                    try {
                        t.I('comment').focus();
                    } catch (e) {}
                    return false;
                },
                I: function (e) {
                    return document.getElementById(e);
                }
            }; // end addComment
            function PrevEdit() {
                $new_comm.show();
                $new_sucs.show();
                $('textarea').each(function () {
                    this.value = ''
                });
                edit = '';
                $('#comment-validate').each(function () {
                    this.value = ''
                });
            } // End PrevEdit
            function CountDown() {
                if (wait > 0) {
                    push_status.html(wait + 's');
                    wait--;
                    setTimeout(CountDown, 1000);
                } else {
                    push_status.html('发表评论');
                    $submit.attr('disabled', false).fadeTo('slow', 1);
                    wait = 10;
                }
            } // End CountDown
        },
        changeChoose(){
            this.ifShowPayImage = !this.ifShowPayImage
        }
    }
})