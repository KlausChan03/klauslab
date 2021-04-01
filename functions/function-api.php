<?php
add_action('rest_api_init', function () {
    register_rest_route('wp/v2', '/user_bind', array( //这里的user_bind是定义请求连接的后缀，也可以写成其他的，比如myrest_api
        'methods' => 'GET', //根据您的情况选择POST或GET
        'callback' => 'user_bind', //这里面的user_bind跟下面的自定义函数的名字保持一致
    ));
});
function user_bind()
{
    //自定义数据获取部分，根据您的需要自己写
    echo get_like_most();
}


/* WordPress REST API 接口添加 */
add_action('rest_api_init', 'wp_rest_insert_tag_links');

function wp_rest_insert_tag_links()
{

    // register_rest_field(
    //     'post',
    //     'post_categories',
    //     array(
    //         'get_callback' => 'wp_rest_get_categories_links',
    //         'update_callback' => null,
    //         'schema' => null,
    //     )
    // );
    // register_rest_field(
    //     'post',
    //     'post_excerpt',
    //     array(
    //         'get_callback' => 'wp_rest_get_plain_excerpt',
    //         'update_callback' => null,
    //         'schema' => null,
    //     )
    // );
    // register_rest_field(
    //     'post',
    //     'post_date',
    //     array(
    //         'get_callback' => 'wp_rest_get_normal_date',
    //         'update_callback' => null,
    //         'schema' => null,
    //     )
    // );
    // register_rest_field(
    //     'page',
    //     'post_date',
    //     array(
    //         'get_callback' => 'wp_rest_get_normal_date',
    //         'update_callback' => null,
    //         'schema' => null,
    //     )
    // );
    register_rest_field(
        'post',
        'post_metas',
        array(
            'get_callback' => 'get_post_meta_for_api',
            'update_callback' => null,
            'schema' => null,
        )
    );
    register_rest_field(
        'shuoshuo',
        'post_metas',
        array(
            'get_callback' => 'get_post_meta_for_api',
            'update_callback' => null,
            'schema' => null,
        )
    );
    register_rest_field(
        'page',
        'post_metas',
        array(
            'get_callback' => 'get_post_meta_for_api',
            'update_callback' => null,
            'schema' => null,
        )
    );
    register_rest_field(
        'post',
        'post_img',
        array(
            'get_callback' => 'get_post_img_for_api',
            'update_callback' => null,
            'schema' => null,
        )
    );
    register_rest_route(
        'wp/v2/',
        'menu',
        array(
            'methods' => 'GET',
            'callback' => 'get_menu',
        )
    );

    // register_rest_field(
    //     'post',
    //     'post_tags',
    //     array(
    //         'get_callback' => 'get_post_tags_for_api',
    //         'update_callback' => null,
    //         'schema' => null,
    //     )
    // );
    // register_rest_field(
    //     'post',
    //     'post_prenext',
    //     array(
    //         'get_callback' => 'get_post_prenext_for_api',
    //         'update_callback' => null,
    //         'schema' => null,
    //     )
    // );
    // register_rest_field('post',
    //     'md_content',
    //     array(
    //         'get_callback' => 'get_post_content_for_api',
    //         'update_callback' => null,
    //         'schema' => null,
    //     )
    // );
}


function get_post_meta_for_api($post)
{
    $post_meta = array();
    $post_meta['views'] = get_post_meta($post['id'], 'post_views_count', true);
    $post_meta['author'] = get_user_by('ID', $post['author'])->display_name;
    $post_meta['link'] = get_post_meta($post['id'], 'link', true);
    $post_meta['img'] = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');
    $post_meta['title'] = get_the_title($post['id']);
    $post_meta['comments_num'] = get_comments_number($post['id']);
    $post_meta['zan_num'] = get_post_meta($post['id'], 'inlo_ding', true);
    $post_meta['thumbnail'] = get_the_post_thumbnail($post['id'], 'Full');
    $tagsss = get_the_tags($post['id']);
    $post_meta['tag_name'] = $tagsss[0]->name;
    return $post_meta;
}

function get_post_img_for_api($post)
{
    $post_img = array();
    $post_img['url'] = get_the_post_thumbnail_url($post['id']);
    return $post_img;
}

function get_menu()
{
    # Change 'menu' to your own navigation slug.
    return wp_get_nav_menu_items('klaus');
}

function reproduced_shortcode( $atts) {
    $atts = shortcode_atts(
        array(
            'link' => '',
            'site' => '',
            'title' => '',
            'post_link' => '',
            'author' => '',
            'author_link' => '',
        ),
        $atts
    );
    $more = '已获得转载授权，如需二次转载，请联系原作者。';

    if (!$atts['link'] && !$atts['site']) {
        return "<pre class='wp-block-preformatted'>转载自作者：<a href='" . $atts['author_link'] . "'>" . $atts['author'] 
        . "</a> ，原标题：<a href='". $atts['post_link'] . "'> " . $atts['title'] . "</a>。". $more ."</pre>";
    } elseif (!$atts['post_link'] && !$atts['title']) {
        return "<pre class='wp-block-preformatted'>转载自<a href='" . $atts['link'] . "'> ". $atts['site'] 
        . "</a>，作者：<a href='" . $atts['author_link'] . "'>" . $atts['author'] . "</a>。". $more ."</pre>";
    } else {
        return "<pre class='wp-block-preformatted'>转载自<a href='" . $atts['link'] . "'> ". $atts['site'] 
        . "</a>，原标题：<a href='". $atts['post_link'] . "'> " . $atts['title'] 
        . "</a>，作者：<a href='" . $atts['author_link'] . "'>" . $atts['author'] . "</a>。". $more ."</pre>";
    }
}
add_shortcode('reproduced', 'reproduced_shortcode');

function gitchat_git_shortcode( $atts ) {
    $atts = shortcode_atts(
        array(
            'id' => '1',
            'title' => 'hahaha',
        ),
        $atts,
        'git'
    );
    return  $atts['id']."__".$atts['title'];
}

add_shortcode('git', 'gitchat_git_shortcode');