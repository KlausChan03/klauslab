<?php

/**
 *  @package KlausLab
 *  Template Name: 说说
 *  author: Klaus
 */
get_header();
?>
<div id="primary" class="main-area w-1">
    <main id="main" class="main-content" role="main">
        <section class="kl_shuoshuo">
            <ul class="timeline-ul">
                <?php
                $limit = get_option('posts_per_page');
                $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                query_posts('post_type=shuoshuo&post_status=publish&showposts=' . $limit = 10 . '&paged=' . $paged);
                if (have_posts()) {
                    while (have_posts()) {
                        the_post();
                ?>
                        <li class="timeline-li flex-hb-vt <?php $author = get_the_author_meta('user_nicename');
                                                            if ($author == "klaus") {
                                                                echo 'author-by-klaus';
                                                            } else if ($author == "laura") {
                                                                echo 'author-by-laura';
                                                            } ?>">
                            <div class="icon">
                                <?php echo get_avatar(get_the_author_meta('user_email')); ?>
                            </div>
                            <div class="label">
                                <div class="label_content">
                                    <p><?php the_content(); ?></p>
                                    <p class="flex-hr-vc">From <?php the_author_meta('user_nicename'); ?>, At <?php the_time('Y年n月j日 G:i'); ?></p>
                                </div>
                                <div class="label_others flex-hb-vc">
                                    <div class="flex-hb-vc flex-hw w-1">
                                        <span class="label_title"><?php the_title(); ?></span>
                                        <div class="flex-hc-vc">
                                            <div class="entry-comment m-0 mr-10">
                                                <?php is_icon(get_the_ID(), "reply"); ?>
                                            </div>
                                            <div class="zan m-0 mr-10">
                                                <a href="#" data-action="ding" data-id="<?php the_ID(); ?>" id="Addlike" class="action  <?php if (isset($_COOKIE['inlo_ding_' . $post->ID])) echo 'actived'; ?> <?php $category = get_the_category();                                                                                                                                                             echo $category[0]->category_nicename; ?>">
                                                    <i class="lalaksks lalaksks-ic-zan"></i>
                                                    <span class="count"><?php if (get_post_meta($post->ID, 'inlo_ding', true)) {
                                                                            echo get_post_meta($post->ID, 'inlo_ding', true);
                                                                        } else {
                                                                            echo '0';
                                                                        } ?></span>
                                                </a>
                                            </div>
                                            <?php if (isAdmin()) {
                                                edit_post_link(_e('<div> <span class="edit-link"><i class="lalaksks lalaksks-ic-edit"></i>', '</span></div>'));
                                            } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                <?php }
                    comments_template();
                } ?>
            </ul>
        <div class="page-navi m-tb-10 flex-hc-vc"><?php wp_pagenavi(); ?></div>
        </section>
    </main>
    <!-- .main-content -->
</div>
<?php get_footer(); ?>