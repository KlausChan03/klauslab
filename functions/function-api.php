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
            'update_callback' => function ($meta, $post) {
                $postId = $post->ID;
                foreach ($meta as $data) {
                    update_post_meta($postId, $data['key'], $data['value']);
                }
                return true;
            },
            'schema' => null,
        )
    );

    // register_rest_field('post', 'metadata', array(
    //     // 显示数据时候的回调，我们可以在这个函数里面，把自定义字段数据附加到 Rest API 文章接口返回的 Json 数据里
    //     'get_callback' => function ($object) {
    //         return get_post_meta($object->ID); //自行修改需要返回的数据，此处是使用获取内容方法返回的内容
    //     },
    //     // 保存数据的回调，这里是保存postmeta信息的地方
    //     'update_callback' => function ($meta, $post) {
    //         $postId = $post->ID;
    //         foreach ($meta as $data) {
    //             update_post_meta($postId, $data['key'], $data['value']);
    //         }
    //         return true;
    //     },
    // ));

    register_rest_field(
        'moments',
        'post_metas',
        array(
            'get_callback' => 'get_post_meta_for_api',
            'update_callback' => null,
            'schema' => null,
        )
    );
    register_rest_field(
        'search',
        'search_metas',
        array(
            'get_callback' => 'get_search_meta_for_api',
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

    register_rest_field(
        'post',
        'post_count',
        array(
            'get_callback' => 'count_words_read_time_for_api',
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
    register_rest_route(
        'wp/v2/',
        'info',
        array(
            'methods' => 'GET',
            'callback' => 'get_base_info',
        )
    );
    register_rest_route(
        'wp/v2/',
        'likePost',
        array(
            'methods' => 'POST',
            'callback' => 'add_like',
        )
    );
    register_rest_field(
        'comment',
        'comment_metas',
        array(
            'get_callback' => 'get_comment_meta_for_api',
            'update_callback' => null,
            'schema' => null,
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
    $post_meta['avatar'] = get_avatar(get_user_by('ID', $post['author'])->user_email, '36');
    $post_meta['title'] = get_the_title($post['id']);
    $post_meta['comments_num'] = get_comments_number($post['id']);
    $post_meta['zan_num'] = get_post_meta($post['id'], 'like', true);
    $post_meta['has_zan'] = isset($_COOKIE['like_' . $post['id']]);
    $post_meta['cai_num'] = get_post_meta($post['id'], 'dislike', true);
    $post_meta['has_cai'] = isset($_COOKIE['dislike_' . $post['id']]);
    $post_meta['thumbnail'] = get_the_post_thumbnail($post['id'], 'Full');
    $tagList = get_the_tags($post['id']);
    $post_meta['tag_name'] = array_column($tagList, 'name');
    $post_meta['tag_test'] = $tagList;
    $catList = get_the_category($post['id']);
    $post_meta['cat_name'] = array_column($catList, 'name');
    $post_meta['reward'] = get_post_meta($post['id'], 'reward', true);
    return $post_meta;
}

function get_search_meta_for_api($search)
{
    $search_meta = array();
    $search_meta['author'] = get_user_by('ID', $search['author'])->display_name;

    return $search_meta;
}

function get_comment_meta_for_api($comment)
{
    $commentData = get_comment($comment['id']);
    $comment_meta = array();
    if ($comment->author == '1') {
        $comment_meta['level'] = '<span class="vip level_Max">博主</span>';
    } else {
        $comment_meta['level'] =  get_author_class_for_api($commentData->comment_author_email);
    }

    return $comment_meta;
}



// 开启用户等级-评论模块
function get_author_class_for_api($comment_author_email)
{
    global $wpdb;
    $author_count = count($wpdb->get_results(
        "SELECT comment_ID as author_count FROM $wpdb->comments WHERE comment_author_email = '$comment_author_email' "
    ));
    // if(is_user_logged_in()){
    if ($author_count >= 1 && $author_count <= 10) //数字可自行修改，代表评论次数。
        return '<span class="vip level_1">LV.1</span>';
    else if ($author_count >= 11 && $author_count <= 20)
        return '<span class="vip level_2">LV.2</span>';
    else if ($author_count >= 21 && $author_count <= 40)
        return '<span class="vip level_3">LV.3</span>';
    else if ($author_count >= 41 && $author_count <= 80)
        return '<span class="vip level_4">LV.4</span>';
    else if ($author_count >= 81 && $author_count <= 160)
        return '<span class="vip level_5">LV.5</span>';
    else if ($author_count >= 161 && $author_count <= 320)
        return '<span class="vip level_6">LV.6</span>';
    else if ($author_count >= 321)
        return '<span class="vip level_Max">LV.7</span>';
    // } else {
    //     return '<span class="vip">LV.0</span>';

    // }

}

// 统计预估阅读时间
function count_words_read_time_for_api($post)
{
    // global $post; 

    $text_num = mb_strlen(preg_replace('/\s/', '', html_entity_decode(strip_tags($post['content']['rendered']))), 'UTF-8');
    $read_time = ceil($text_num / 300); // 修改数字300调整时间 
    // $ = '本文共计' . $text_num . '个字，预计阅读时长' . $read_time  . '分钟。'; 
    $post_count['text_num'] = $text_num;
    $post_count['read_time'] = $read_time;
    return $post_count;
}

// 获取缩略图
function get_post_img_for_api($post)
{
    $post_img = array();
    $post_img['url'] = get_the_post_thumbnail_url($post['id']);
    return $post_img;
}

// 新增接口 - 获取菜单
function get_menu()
{
    # Change 'menu' to your own navigation slug.
    return wp_get_nav_menu_items('klaus');
}

// 新增接口 - 获取基本信息
function get_base_info(){
    $base_info = array();
    $base_info['hitokoto'] = html_entity_decode(hitokoto());
    $base_info['isLogin'] = is_user_logged_in();
    $base_info['icp_num'] = get_option('zh_cn_l10n_icp_num');
    $base_info['the_bloginfo_name'] = get_bloginfo('name');
    $base_info['home_url'] = get_option('home');
    $base_info['theme_url'] = get_template_directory_uri() . '/src';

    // 打赏图片信息
    $base_info['alipay_image_id'] = cs_get_option('alipay_image');
    $base_info['alipay_attachment'] = wp_get_attachment_image_src($base_info['alipay_image_id'], 'full');
    $base_info['wechat_image_id'] = cs_get_option('wechat_image');
    $base_info['wechat_attachment'] = wp_get_attachment_image_src($base_info['wechat_image_id'], 'full');
    return $base_info;
}

// 新增接口 - 点赞
function add_like($request)
{
    $id = $request['id'];
    $action = $request["action"];
    if ($action) {
        $inlo_raters = get_post_meta($id, $action, true);
        $expire = time() + 99999999;
        $domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false; // make cookies work with localhost
        setcookie($action . '_' . $id, $id, $expire, '/', $domain, false);
        if (!$inlo_raters || !is_numeric($inlo_raters)) {
            update_post_meta($id, $action, 1);
        } else {
            update_post_meta($id, $action, ($inlo_raters + 1));
        }
        echo get_post_meta($id, $action, true);
    }
    die;
}

function reproduced_shortcode($atts)
{
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
            . "</a> ，原标题：<a href='" . $atts['post_link'] . "'> " . $atts['title'] . "</a>。" . $more . "</pre>";
    } elseif (!$atts['post_link'] && !$atts['title']) {
        return "<pre class='wp-block-preformatted'>转载自<a href='" . $atts['link'] . "'> " . $atts['site']
            . "</a>，作者：<a href='" . $atts['author_link'] . "'>" . $atts['author'] . "</a>。" . $more . "</pre>";
    } else {
        return "<pre class='wp-block-preformatted'>转载自<a href='" . $atts['link'] . "'> " . $atts['site']
            . "</a>，原标题：<a href='" . $atts['post_link'] . "'> " . $atts['title']
            . "</a>，作者：<a href='" . $atts['author_link'] . "'>" . $atts['author'] . "</a>。" . $more . "</pre>";
    }
}
add_shortcode('reproduced', 'reproduced_shortcode');

function gitchat_git_shortcode($atts)
{
    $atts = shortcode_atts(
        array(
            'id' => '1',
            'title' => 'hahaha',
        ),
        $atts,
        'git'
    );
    return  $atts['id'] . "__" . $atts['title'];
}

add_shortcode('git', 'gitchat_git_shortcode');


/**
 * array_column() // 不支持低版本;
 * 以下方法兼容PHP低版本
 */
function _array_column(array $array, $column_key, $index_key=null){
    $result = [];
    foreach($array as $arr) {
        if(!is_array($arr)) continue;

        if(is_null($column_key)){
            $value = $arr;
        }else{
            $value = $arr[$column_key];
        }

        if(!is_null($index_key)){
            $key = $arr[$index_key];
            $result[$key] = $value;
        }else{
            $result[] = $value;
        }
    }
    return $result; 
}