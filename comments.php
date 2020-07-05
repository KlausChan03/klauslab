<?php

/**
 * The template for displaying comments.
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package KlausLab
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if (post_password_required()) {
  return;
}
?>

<section id="comments" class="comments-area">
  <?php // You can start editing here -- including this comment! 
  ?>
  <?php if (have_comments()) : ?>
    <h3 class="comments-title">
      <?php
      printf( // WPCS: XSS OK.
        esc_html(_nx('%1$s &nbsp;条回应', '%1$s &nbsp;条回应', get_comments_number(), 'comments title', 'KlausLab')),
        number_format_i18n(get_comments_number()),
        '<span>' . get_the_title() . '</span>'
      );
      ?>
    </h3>
    <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : // Are there comments to navigate through? 
    ?>
      <nav id="comment-nav-above" class="navigation comment-navigation" role="navigation">
        <h2 class="screen-reader-text">
          <?php esc_html_e('Comment navigation', 'KlausLab'); ?>
        </h2>
        <div class="nav-links">
          <div class="nav-previous">
            <?php previous_comments_link(esc_html__('Older Comments', 'KlausLab')); ?>
          </div>
          <div class="nav-next">
            <?php next_comments_link(esc_html__('Newer Comments', 'KlausLab')); ?>
          </div>
        </div>
        <!-- .nav-links -->
      </nav>
      <!-- #comment-nav-above -->
    <?php endif; // Check for comment navigation. 
    ?>

    <!-- .comment-list -->

    <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : // Are there comments to navigate through? 
    ?>
      <nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
        <div class="nav-links">
          <div class="nav-previous">
            <?php previous_comments_link(esc_html__('Older Comments', 'KlausLab')); ?>
          </div>
          <div class="nav-next">
            <?php next_comments_link(esc_html__('Newer Comments', 'KlausLab')); ?>
          </div>
        </div>
      </nav>

      <!-- #comment-nav-below -->
    <?php endif; // Check for comment navigation. 
    ?>
  <?php endif; // Check for have_comments(). 
  ?>
  <?php
  // If comments are closed and there are comments, let's leave a little note, shall we?
  if (!comments_open() && '0' != get_comments_number() && post_type_supports(get_post_type(), 'comments')) :
  ?>
    <p class="no-comments">
      <?php esc_html_e('Comments are closed.', 'KlausLab'); ?>
    </p>
  <?php endif; ?>
  <div class="comment-respond" id="respond">
    <?php if (!comments_open()) : elseif (get_option('comment_registration') && !is_user_logged_in()) : ?>
      <p class="login-must">你必须 <a href="<?php echo wp_login_url(get_permalink()); ?>">登录</a> 才能发表评论！</p>
    <?php else : ?>
      <form name="comment-form" class="comment-form" id="comment-form" method="post" action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php">
        <div class="comment-text">
          <?php if (!is_user_logged_in()) : ?>
            <div class="commentator mb-5">
              <?php if (isset($_COOKIE['comment_author_email_' . COOKIEHASH])) {
                $comment_author_email = $_COOKIE['comment_author_email_' . COOKIEHASH];
                echo get_avatar($comment_author_email, 60);
              }
              ?>
            </div>
            <div class="comment-input p-tb-10 flex-hb-vc flex-hw">
              <input type="text" name="author" value="<?php if (isset($_COOKIE['comment_author_' . COOKIEHASH])) { $comment_author = $_COOKIE['comment_author_' . COOKIEHASH]; echo $comment_author; } ?>" class="text-input text-top" id="comment-author" placeholder="昵称 *">
              <input type="text" name="email" value="<?php if (isset($_COOKIE['comment_author_email_' . COOKIEHASH])) { $comment_author_email = $_COOKIE['comment_author_email_' . COOKIEHASH]; echo $comment_author_email; } ?>" class="text-input text-top" id="comment-email" placeholder="邮箱 *">
              <input type="text" name="url" value="<?php if (isset($_COOKIE['comment_author_url_' . COOKIEHASH])) { $comment_author_url = $_COOKIE['comment_author_url_' . COOKIEHASH]; echo $comment_author_url; } ?>" class="text-input" id="comment-url" placeholder="网址">
              <?php Memory_protection_math(); ?>
            </div>
          <?php else : ?>
            <div class="commentator">
              <p> <?php global $current_user;
                  wp_get_current_user();
                  echo get_avatar($current_user->user_email, 48); ?> </p>
            </div>
            <div class="comment-login">
              <p>您已登录: <a class="have-login-name" href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a> <a class="log-out-now no-pjax" href="<?php echo wp_logout_url(get_permalink()); ?>" title="退出登录">退出</a></p>
            </div>
          <?php endif; ?>
          <div class="comment-s">
            <textarea class="text-input error" id="comment" name="comment" rows="8" cols="45" aria-required="true" placeholder="一言：<?php hitokoto(); ?>"></textarea>
            <div class="flex-hb-vc p-tb-10">
              <button type="button" class="OwO no-touch kl-btn kl-btn-sm"></button>
              <div class="comment-action flex-hr-vc">
                <span class="comment-cancel"><?php cancel_comment_reply_link('取消评论') ?></span>
                <button type="submit" name="submit" class="comment-submit push-status kl-btn kl-btn-sm kl-btn-normal">发表评论</button>
              </div>
            </div>

          </div>
        </div>
        <?php comment_id_fields(); ?>
        <?php do_action('comment_form', $post->ID); ?>
      </form>
    <?php endif; ?>
  </div>
  <div id="comments-list">
    <?php
    if (!comments_open()) {
    ?>
      <ol class="memory-comments-area">
        <p class="center"><i class="memory memory-error"></i> 评论功能已经关闭!</p>
      </ol>
    <?php
    } else if (!have_comments()) {
    ?>
      <ol class="memory-comments-area">
        <p class="center no-comment p-tb-10"><i class="memory memory-sofa"></i> 还没有任何评论，你来说两句吧!</p>
      </ol>
    <?php } else { ?>
      <ol class="memory-comments-area">
        <?php wp_list_comments('type=comment&callback=memory_comment'); ?>
      </ol>
    <?php } ?>

    <?php if (get_option('page_comments')) { ?>
      <div id="pagination">
        <div class="memory-comments-page">
          <?php $comment_pages = paginate_comments_links('prev_text=上一页&next_text=下一页&echo=8'); ?>
        </div>
      </div>
    <?php } ?>
  </div>
</section>


<!-- #comments -->