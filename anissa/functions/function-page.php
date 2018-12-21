

<?php

// 文章归档
function archives_list() {
	if( !$output = get_option('archives_list') ){
		$output = '<div id="archives">';
		$the_query = new WP_Query( 'posts_per_page=-1&ignore_sticky_posts=1&post_type=post' ); 
		$year=0; $mon=0; $i=0; $j=0;
		while ( $the_query->have_posts() ) : $the_query->the_post();
			$year_tmp = get_the_time('Y');
			$mon_tmp = get_the_time('M');
            $y=$year; $m=$mon;
            if ($mon != $mon_tmp && $mon > 0) $output .= '</ul></li>';
            if ($year != $year_tmp && $year > 0) $output .= '</ul>';
            if ($year != $year_tmp) {
                $year = $year_tmp;
                $output .= '<h3 class="al_year">'. $year .' 年</h3><ul class="al_mon_list">'; //输出年份
            }
            if ($mon != $mon_tmp) {
                $mon = $mon_tmp;
                $output .= '<li><span class="al_mon">'.$mon.'</span><ul class="al_post_list">'; //输出月份
            }
            $output .= '<li>'.'<a class="no-des" href="'. get_permalink() .'">'.get_the_time('j日: ') . get_the_title() .'('. get_comments_number('0', '1', '%') .'条评论)</a></li>'; //输出文章日期和标题
        endwhile;
        wp_reset_postdata();
        $output .= '</ul></li></ul></div>';
        update_option('archives_list', $output);
	}
    echo $output;
}
function clear_cache() {
    update_option('archives_list', ''); // 清空 archives_list
}
add_action('save_post', 'clear_cache'); // 新发表文章/修改文章时

//说说
function my_custom_init() { 
	$labels = array( 
		'name' => '说说',
		'singular_name' => '说说',
		'add_new' => '发表说说', 
		'add_new_item' => '发表说说', 
		'edit_item' => '编辑说说', 
		'new_item' => '新说说', 
		'view_item' => '查看说说', 
		'search_items' => '搜索说说', 
		'not_found' => '暂无说说', 
		'not_found_in_trash' => '没有已遗弃的说说', 
		'parent_item_colon' => '', 'menu_name' => '说说' 
	); 
	$args = array( 
		'labels' => $labels, 
		'public' => true, 
		'publicly_queryable' => true, 
		'show_ui' => true, 
		'show_in_menu' => true, 
		'query_var' => true, 'rewrite' => true, 
		'capability_type' => 'post', 
		'has_archive' => true, 
		'hierarchical' => false, 
		'menu_position' => null, 
		'supports' => array('title','editor','author','comments') 
	); 
	register_post_type('shuoshuo',$args); 
}
add_action('init', 'my_custom_init');


//友情链接

//友链判断-二维数组经过判断赋值给另一二维数组
function bookmarks($rel){
    $bms = array();
    $bookmarks = get_bookmarks('hide_invisible=0'); // 这个也是二维数组
    if( $rel == 'nonhome'){ //若非首页
        foreach( $bookmarks as $bs ){
            if ( $bs->link_rel ==  'contact' ||  $bs->link_rel == 'acquaintance' ) { continue;} // 若是contact或acquaintance则终止循环输出，意思是排除这两类关系输出
                $bms[] = array( 'link_rel'=>$bs->link_rel,'link_visible'=>$bs->link_visible,'link_url'=>$bs->link_url,'link_description'=>$bs->link_description,'link_target'=>'','link_name'=>$bs->link_name);
        }
    }
    if( $rel == 'home'){ //若是首页
        foreach( $bookmarks as $bs ){
            if ( $bs->link_rel ==  'contact' )  { continue;} // 若是contact则终止循环输出，意思是排除这类关系输出
                $bms[] = array( 'link_rel'=>$bs->link_rel,'link_visible'=>$bs->link_visible,'link_url'=>$bs->link_url,'link_description'=>$bs->link_description,'link_target'=>'','link_name'=>$bs->link_name);
        }
    }
    return $bms; // 返回二维数组
}

function get_the_link_items($id = null){
    $bookmarks = get_bookmarks('orderby=date&category=' .$id );
    $output = '';
    if ( !empty($bookmarks) ) {		
        $output .= '<ul class="link-items klaus-links flex-hl-vl flex-hw">';
        foreach ($bookmarks as $bookmark) {
			$arr_col = array("qs","lvs","ls","zs","lh","hs","cs","hos");
			shuffle($arr_col);
			$arr_num = array("1","2");
			shuffle($arr_num);					
			$link_notes = $bookmark->link_notes;
			$link_rss = $bookmark->link_rss;
			$link_image = $bookmark->link_image;
			if( $link_rss == '' and  $link_notes == '' and  $link_image != ''){
				$imgUrl = '<img src="'. $link_image .'"></img>';				
			}elseif( $link_image == '' and  $link_rss == '' and  $link_notes != ''){
				// $imgUrl = '<img src="'.getGravatar($link_notes).'"></img>';
				$imgUrl = '<img src="//statics.dnspod.cn/proxy_favicon/_/favicon?domain=' . $link_notes . '"/>' ;
			}elseif( $link_image == '' and  $link_notes == '' and  $link_rss != '' ){
				$imgUrl  = '<img src="'.getGravatar(str_replace("http://","",$link_rss)).'"/>';
			}else{
				$imgUrl = '';
			}			
			
			$output .=  '<li class="col-md-4 mt-15 mb-15 p-10"> <div class="p-0 borderr-main-4"> <div class="flex-hb-vc link-1 p-20 bgc-' 
			. $arr_col[0] . $arr_num[0] . '"> <div class="w-85 p-0"> <strong><a title="'
			. $bookmark->link_name . '" href="' 
			. $bookmark->link_url . '" target="_blank" class="col-fff link-name">'
			. $bookmark->link_name .'</a></strong> <p class="f12 col-fff text-overflow">' 
			. $bookmark->link_url . '</p> </div> <div class="w-15 flex-hr-vc"><a title="'
			. $bookmark->link_name .'" href="' 
			. $bookmark->link_url . '" target="_blank" class="link-avatar col-aaa"> '
			. $imgUrl . '</a> </div></div> <div class="p-20 pt-10 pb-10 col-primary clearfix link-2"> <p class="col-aaa text-overflow">' 
			. $bookmark->link_description . '</p> </div>  </div> </li>';
        }
        $output .= '</ul>';
    }
    return $output;
}



function get_link_items(){
    $linkcats = get_terms( 'link_category' );
    if ( !empty($linkcats) ) {
        foreach( $linkcats as $linkcat){            
            $result .=  '<blockquote class="link-title">'.$linkcat->name.'</blockquote>';
            if( $linkcat->description ) $result .= '<div class="link-description">' . $linkcat->description . '</div>';
            $result .=  get_the_link_items($linkcat->term_id);
        }
    } else {
        $result = get_the_link_items();
    }
    return $result;
}

// function shortcode_link(){
//     return get_link_items();
// }
// add_shortcode('bigfalink', 'shortcode_link');
add_action('init', 'get_link_items');

add_filter('pre_option_link_manager_enabled','__return_true');


?>
