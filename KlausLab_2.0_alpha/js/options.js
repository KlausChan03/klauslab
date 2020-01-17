let option = {};
option.pageLoadingMask = (function () {
    var maskDivId = "cdfd5f6428794b309256805748abe2b2";
    var closeCallbacks = [];
    var pageLoader = {
        show: function (doc, closeCallback) {
            if (doc === undefined) doc = window.document;
            if (doc.getElementById(maskDivId)) return;
            doc.body.innerHTML += `
            <div class="my-loading-shade" id="${maskDivId}">
                <div class="loader-wrapper ☯-bg fadeOut animated">
                    <div class='☯'></div>
                </div>
            </div>
            `;

            // doc.body.innerHTML += `
            // <div class="my-loading-shade" id="${maskDivId}">
            //     <div class="loader-wrapper">
            //         <div class="loader">
            //             <div class="roller"></div>
            //             <div class="roller"></div>
            //         </div>                    
            //         <div id="loader2" class="loader">
            //             <div class="roller"></div>
            //             <div class="roller"></div>
            //         </div>                    
            //         <div id="loader3" class="loader">
            //             <div class="roller"></div>
            //             <div class="roller"></div>
            //         </div>
            //     </div>
            // </div>
            // `;

            if (typeof closeCallback === "function") {
                if (typeof doc.docId !== "string") {
                    doc.docId = util.string.getUUID();
                }
                closeCallbacks[doc.docId] = closeCallback;
            }
        },
        remove: function (doc) {
            if (doc === undefined) doc = window.document;
            if (typeof doc.docId === "string") {
                var closeCallback = closeCallbacks[doc.docId];
                if (typeof closeCallback === "function") closeCallback();
                delete closeCallbacks[doc.docId];
            }
            var mask = doc.getElementById(maskDivId);
            if (mask) mask.parentNode.removeChild(mask);
            pageLoader = null;
        }
    };
    return pageLoader;
})();

// 消息推送
function createMessage(message,time=1000) {
	if ($(".message").length > 0) {
		$(".message").remove();
	}
	$("body").append('<div class="message"><p class="message-info">' + message + '</p></div>');
	setTimeout("$('.message').remove()", time);
}

var $body = (window.opera) ? (document.compatMode == "CSS1Compat" ? $('html') : $('body')) : $('html,body');  

let App = {};
App.owoEmoji = () => {
    $('.OwO').each(function (i, block) {
        var s = new OwO({
            logo: '<i class="lalaksks lalaksks-ic-background"></i> Emoji',
            container: document.getElementsByClassName('OwO')[0],
            target: document.getElementsByClassName('error')[0],
            position: 'down',
            width: '400px',
            maxHeight: '200px',
            api: KlausLabConfig.siteUrl + "/emoji/OwO.min.json"
        });
    });
};

App.commentsSubmit = () => {
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
        $.ajax({
            url: KlausLabConfig.ajaxUrl,
            data: $(this).serialize() + "&action=ajax_comment",
            type: $(this).attr('method'),
            error: function (XmlHttpRequest, textStatus, errorThrown) {
                push_status.html('重新提交');
                createMessage(XmlHttpRequest.responseText, 3000);
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
            console.log(respond,parent)
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
};


App.owoEmoji();
App.commentsSubmit();


