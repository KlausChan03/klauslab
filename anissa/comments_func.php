<?php

// 获取文章评论数
function inlojv_get_comment_count($post_id, $type = null) {
    global $wpdb;
    $sql = "SELECT count(comment_ID) FROM {$wpdb->comments}
                WHERE comment_type = '{$type}'
                AND comment_approved = 1
                AND comment_post_ID = {$post_id}";
    $res = $wpdb->get_var ( $sql );
    return empty ( $res ) ? 0 : $res;
}

// 获取当前用户
function inlojv_get_current_user() {
    global $current_user;
    if (! is_user_logged_in ()) {
        $user = wp_get_current_commenter ();
        if (! empty ( $user ['comment_author'] )) {
            // PHP5.4以上因为对象还没创建会报错，所以声明个数组再强制转为对象
            $current_user = array ();
            $current_user = ( object ) $current_user;
            $current_user->display_name = $user ['comment_author'];
            $current_user->user_email = $user ['comment_author_email'];
            $current_user->user_url = $user ['comment_author_url'];
        } else {
            return false;
        }
    }
    return $current_user;
}

//评论表情列表
function inlojv_smilies() {
    smilies_init ();
    global $wpsmiliestrans;
    $smilies = array_unique ( $wpsmiliestrans );
    $link = '';
    foreach ( $smilies as $key => $smile ) {
        $file = inlojv_costom_smilies ( '', $smile );
        $img .= '<img src="' . $file . '" data-key="' . $key . '" class="face" />&nbsp;';
    }
    echo $img;
}

// 评论模块
function inlojv_get_comment_list($comment, $args, $depth) {
    $GLOBALS ['comment'] = $comment;
    if ($comment->comment_type == '') {
        $avatar = get_avatar ( $comment->comment_author_email, 50 );
        $author = $comment->comment_author;
        $author_link = empty ( $comment->comment_author_url ) ? null : ' href="' . $comment->comment_author_url . '"';
        $admin_avatar = $comment->user_id == 1 ? ' admin-avatar' : null;
        $admin_class = $comment->user_id == 1 ? 'author-admin' : '';
        $comm_class = comment_class ( $admin_class, null, null, false );
        $comment_id = $comment->comment_ID;
        $comment_approved = $comment->comment_approved == 0 ? '<div class="comment-moderation">你的评论需要审核通过后才会生效</div>' : null;
        $content_text = apply_filters ( 'comment_text', $comment->comment_content );
        $time = get_comment_time ( 'n月j日 H:i' );
        $is_admin = $comment->user_id == 1 ? ' admin' : null;
        $reply = get_comment_reply_link ( array_merge ( $args, array (
                'reply_text' => '回复',
                'depth' => $depth,
                'max_depth' => $args ['max_depth'] 
        ) ) );
        
        echo <<<EOF
<li $comm_class id="comment-{$comment_id}">
    <div class="comment-avatar{$admin_avatar}">
        {$avatar}
        <a title="{$author}" rel="nofollow" target="_blank" class="comment-author-url"{$author_link}>{$author}</a>
    </div>
    <div class="comment-container{$is_admin}">
        <div class="comment-connent">{$content_text}{$comment_approved}</div>
        <div class="comment-info"><span>{$time}</span>{$reply}<div class="clr"></div></div>
        <div class="comment-tr"></div>
    </div>
EOF;
    }
}

// pingback模块
function inlojv_get_pings_list($comment, $args, $depth) {
    $GLOBALS ['comment'] = $comment;
    if ($comment->comment_type == 'pingback') {
        global $post;
        $comm_class = comment_class ( '', null, null, false );
        $comment_id = get_comment_ID ();
        $time = get_comment_time ( 'Y-n-j' );
        $content_text = get_comment_text ();
        $comment_autohr = $comment->comment_author;
        $author_url = $comment->comment_author_url;
        echo <<<EOF
<li $comm_class id="comment-{$comment_id}">
    <div class="comment-avatar">{$time}</div>
    <div class="comment-container">
        <div class="comment-connent"><a href="{$author_url}" target="_blank">{$comment_autohr}</a></div>
        <div class="comment-info">{$content_text}</div>
        <div class="comment-tr"></div>
    </div>
</li>
EOF;
    }
}

// 退出登录跳转
    add_filter ( 'logout_url', 'inlojv_logout_to_home' );
    
// 退出当前用户
    add_filter ( 'wp_logout', 'inlojv_logout' );

// 退出时清理当前用户cookie
function inlojv_logout() {
    setcookie ( 'comment_author_' . COOKIEHASH, '', - 1 );
    setcookie ( 'comment_author_email_' . COOKIEHASH, '', - 1 );
    setcookie ( 'comment_author_url_' . COOKIEHASH, '', - 1 );
}    

// 退出跳转
function inlojv_logout_to_home($logout_url) {
    return $logout_url . '&amp;redirect_to=' . $_SERVER ['REQUEST_URI'];
}

// 评论回复邮件通知
add_action ( 'comment_post', 'inlo_reply_mail_notify' );
function inlo_reply_mail_notify($comment_id) {
    $comment = get_comment ( $comment_id );
    $parent_id = $comment->comment_parent;
    if (! empty ( $_POST ['reply_mail_notify'] ) && $_POST ['reply_mail_notify'] == 'Y') {
        add_comment_meta ( $comment_id, 'reply_mail_notify', 'Y' );
    }
    $post_title = get_the_title ( $comment->comment_post_ID );
    $post_link = get_permalink ( $comment->comment_post_ID );
    $comment_link = get_comment_link ( $comment->comment_parent );
    $blog_name = get_option ( 'blogname' );
    $charset = get_option ( 'blog_charset' );
    $from_email = 'no-reply@' . preg_replace ( '/(.*\.)(.*\.\w+)/', '${2}', $_SERVER ['HTTP_HOST'] );
    $from = "From: \"" . $blog_name . "\" <{$from_email}>";
    $headers = "{$from}\nContent-Type: text/html; charset=" . $charset . "\n";
    set_time_limit ( 0 );
    if (! empty ( $parent_id )) {
        $parent_comment = get_comment ( $parent_id );
        $is_mail_notify = get_comment_meta ( $parent_comment->comment_ID, 'reply_mail_notify', true );
        if ($is_mail_notify ['reply_mail_notify'] == 'Y' && $comment->comment_approved == '1') {
            $to_email = trim ( $parent_comment->comment_author_email );
            $subject = '你在[' . $blog_name . ']上的留言有了新的回复';
            $message = '<div style="width:800px;padding:10px 20px;font-family: 微软雅黑;color: #777;background-color: #fafafa;border: 1px solid #e3e3e3;border-top: 4px solid #1e8cbe;">';
            $message .= '<p style="padding-bottom: 10px;border-bottom: 1px solid #E3E3E3;font-style: oblique;">嗨，' . $parent_comment->comment_author . '，你在<a href="' . $post_link . '" style="text-decoration: underline;color: #278DBC;">《' . $post_title . '》</a>中的评论有了回复</p>';
            $message .= '<p style="padding: 10px;color:#444;"><span style="display: block;padding-bottom: 15px;color: #aaa;">' . $comment->comment_author . '给你的回复：</span>“' . $comment->comment_content . '”</p>';
            $message .= '<p style="border-top: 2px solid #20A3CC;padding: 10px;"><span style="color: #aaa;padding-bottom: 15px;display: block;">你的评论：</span>“' . $parent_comment->comment_content . '”</p>';
            $message .= '<p><a href="' . $comment_link . '" style="font-style: oblique;color: #278DBC;text-decoration: underline;">查看详细</a></p><p style="color: #f00;font-size: 12px;">PS：此邮件由系统自动发送,请勿回复!</p>';
            $message .= '<p><a style="font-size: 12px;" title="前往首页" href="' . home_url () . '">' . $blog_name . '</a></p></div>';
            @wp_mail ( $to_email, $subject, $message, $headers );
        }
    }
    if (inlo_options ( 'is_email_msg' ) == 'Y') {
        $to_email = get_bloginfo ( 'admin_email' );
        $subject = $blog_name . '上有了新的评论';
        $message = '<div style="width:800px;padding:10px 20px;font-family: 微软雅黑;color: #777;background-color: #fafafa;border: 1px solid #e3e3e3;border-top: 4px solid #1e8cbe;">';
        $message .= '<p style="padding-bottom: 10px;border-bottom: 1px solid #E3E3E3;font-style: oblique;"><a href="' . $post_link . '" style="text-decoration: none;color: #278DBC;">《' . $post_title . '》</a>有新的评论</p>';
        $message .= '<p style="padding: 10px;color:#444;"><span style="display: block;padding-bottom: 15px;color: #aaa;">' . $comment->comment_author . '的评论：</span>“' . $comment->comment_content . '”</p>';
        $message .= '<p><a href="' . $comment_link . '" style="font-style: oblique;color: #278DBC;text-decoration: underline;">查看详细</a></p>';
        $message .= '</div>';
        @wp_mail ( $to_email, $subject, $message, $headers );
    }
    return $comment_id;
}

// 过滤垃圾评论
add_filter ( 'preprocess_comment', 'inlojv_nospam' );
function inlojv_nospam($comments) {
    if (empty ( $comments ['comment_type'] )) { //虚拟验证码填写
        // 下面用$_POST变量收集表单中名为no_spam的值，所以下面加入form表单内的input标签内的name=no_spam，而且input不能放在form之外
        if (! is_admin () && (empty ( $_POST ['no_spam'] ) || $_POST ['no_spam'] != 'inlojv')) {                                         //判断填入值是否为空或不为inlojv，下面ajax用val方法填入inlojv，因为垃圾评论不会真正打开页面，所以下面用val方法填入inlojv.
        wp_die ( 'No Spam !!' );
        }
    } else {
        if ($comments ['comment_type'] == 'trackback') {
            // 防traceback垃圾评论
            $url_count = array ();
            preg_match_all ( '/<a|\[url\]*/', $comments ['comment_content'], $url_count );// 正则匹配后将值放入数组变量$url_count中
            $pos = strpos ( $comments ['comment_content'], '<strong>' );
            if (($pos !== false && $pos == '0') || (isset ( $url_count [0] ) && count ( $url_count [0] ) > 3)) {
                wp_die ( 'No Spam !!' );
            }
        }
    }
    return $comments;
}
?>