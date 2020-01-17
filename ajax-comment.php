<?php
/**
 * Handles Comment Post to WordPress and prevents duplicate comment posting.
 *
 * @package WordPress
 */
if ('POST' != $_SERVER ['REQUEST_METHOD']) {
    header ( 'Allow: POST' );
    header ( 'HTTP/1.1 405 Method Not Allowed' );
    header ( 'Content-Type: text/plain' );
    exit ();
}

function inlojv_msg($msg = '', $status = false) {
    $status = $status === true ? '1' : '0';
    $json ['status'] = $status;
    if (is_array ( $msg )) {
        foreach ( $msg as $k => $m ) {
            $json [$k] = $m;
        }
    } else {
        $json ['info'] = $msg;
    }
    die ( json_encode ( $json ) );
}
$return = '';
/**
 * Sets up the WordPress Environment.
 */
require (dirname ( __FILE__ ) . '../../../../wp-load.php');

nocache_headers ();

$comment_post_ID = isset($_POST ['comment_post_ID']) ? (int) $_POST ['comment_post_ID'] : 0;

$post = get_post ( $comment_post_ID );

if (empty ( $post->comment_status )) {
    do_action ( 'comment_id_not_found', $comment_post_ID );
    inlojv_msg ( __ ( 'Invalid comment status.' ) );
}

// get_post_status() will get the parent status for attachments.
$status = get_post_status ( $post );

$status_obj = get_post_status_object ( $status );

if (! comments_open ( $comment_post_ID )) {
    do_action ( 'comment_closed', $comment_post_ID );
    inlojv_msg ( __ ( 'Sorry, comments are closed for this item.' ) );
} elseif ('trash' == $status) {
    do_action ( 'comment_on_trash', $comment_post_ID );
    inlojv_msg ( __ ( 'Invalid comment status.' ) );
} elseif (! $status_obj->public && ! $status_obj->private) {
    do_action ( 'comment_on_draft', $comment_post_ID );
    inlojv_msg ( __ ( 'Invalid comment status.' ) );
} elseif (post_password_required ( $comment_post_ID )) {
    do_action ( 'comment_on_password_protected', $comment_post_ID );
    inlojv_msg ( __ ( 'Password Protected' ) );
} else {
    do_action ( 'pre_comment_on_post', $comment_post_ID );
}

$comment_author = (isset ( $_POST ['author'] )) ? trim ( strip_tags ( $_POST ['author'] ) ) : null;
$comment_author_email = (isset ( $_POST ['email'] )) ? trim ( $_POST ['email'] ) : null;
$comment_author_url = (isset ( $_POST ['url'] )) ? trim ( $_POST ['url'] ) : null;
$comment_content = (isset ( $_POST ['comment'] )) ? trim ( $_POST ['comment'] ) : null;

// If the user is logged in
$user = wp_get_current_user ();
if ($user->exists ()) {
    if (empty ( $user->display_name )) {
        $user->display_name = $user->user_login;
    }
    $comment_author = wp_slash ( $user->display_name );
    $comment_author_email = wp_slash ( $user->user_email );
    $comment_author_url = wp_slash ( $user->user_url );
    if (current_user_can ( 'unfiltered_html' )) {
        if (wp_create_nonce ( 'unfiltered-html-comment_' . $comment_post_ID ) != $_POST ['_wp_unfiltered_html_comment']) {
            kses_remove_filters (); // start with a clean slate
            kses_init_filters (); // set up the filters
        }
    }
} else {
    if (get_option ( 'comment_registration' ) || 'private' == $status) {
        inlojv_msg ( '必须登录后才能发言' );
    }
}

$comment_type = '';

if (get_option ( 'require_name_email' ) && ! $user->exists ()) {
    if (6 > strlen ( $comment_author_email ) || '' == $comment_author) {
        inlojv_msg ( '大虾，昵称有木有？邮箱有木有？' );
    } elseif (! is_email ( $comment_author_email )) {
        inlojv_msg ( '留下邮箱，我才能联系你啊' );
    }
}
if ('' == $comment_content) {
    inlojv_msg ( '不要走，把评论留下' );
}

$comment_parent = isset ( $_POST ['comment_parent'] ) ? absint ( $_POST ['comment_parent'] ) : 0;
$commentdata = compact ( 'comment_post_ID', 'comment_author', 'comment_author_email', 'comment_author_url', 'comment_content', 'comment_type', 'comment_parent', 'user_ID' );
$comment_id = wp_new_comment ( $commentdata );

$comment = get_comment ( $comment_id );
do_action ( 'set_comment_cookies', $comment, $user );


if ($comment) {
    $comment_depth = 1;
    $tmp_c = $comment;
    while ( $tmp_c->comment_parent != 0 ) {
        $comment_depth ++;
        $tmp_c = get_comment ( $tmp_c->comment_parent );
    }
    $avatar = get_avatar ( $comment, 50 );
    $author = $comment->comment_author;
    $author_link = empty ( $comment->comment_author_url ) ? null : ' href="' . $comment->comment_author_url . '"';
    $admin_class = $comment->user_id == 1 ? 'author-admin' : '';
    $comm_class = comment_class ( $admin_class, null, null, false );
    $comm_class = comment_class ( 'author-admin', null, null, false );
    $comment_id = $comment->comment_ID;
    $comment_approved = $comment->comment_approved == 0 ? '<div class="comment-moderation">你的评论需要审核通过后才会生效</div>' : null;
    $content_text = apply_filters ( 'comment_text', $comment->comment_content );
    $time = get_comment_time ( 'n月j日 H:i' );
    $is_admin = $comment->user_id == 1 ? ' admin' : null;
    $admin_avatar = $comment->user_id == 1 ? ' admin-avatar' : null;
    $reply = get_comment_reply_link ( array (
            'reply_text' => '回复',
            'depth' => $comment_depth,
            'max_depth' => get_option ( 'thread_comments_depth' ) 
    ) );
    
    $return = '<li ' . $comm_class . ' id="comment-' . $comment_id . '">
        <div class="comment-avatar' . $admin_avatar . '">
            ' . $avatar . '
            <a title="' . $author . '" rel="nofollow" target="_blank" class="comment-author-url"' . $author_link . '>' . $author . '</a>
        </div>
        <div class="comment-container' . $is_admin . '">
            <div class="comment-connent">' . $content_text . $comment_approved . '</div>
            <div class="comment-info"><span>' . $time . ' </span>' . $reply . '<div class="clr"></div></div>
            <div class="comment-tr"></div>
        </div>
    </li>';
}

$return = $comment_depth > 1 ? '<ul class="children">' . $return . '</ul>' : $return;
$msg ['info'] = $return;

if ($is_reply && $is_replied) {
    $msg ['is_refresh'] = '1';
}
inlojv_msg ( $msg, true );
die ();