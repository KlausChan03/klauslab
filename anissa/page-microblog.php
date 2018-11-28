<?php 
/*
    Template Name: 说说
    author: Klaus
*/
get_header(); 
?>
<style type="text/css">
    /** 垂直时间线CSS样式 */
    .kl_shuoshuo{
        padding:15px;
    }
    .timeline {
        margin: 30px 0 0 0;
        padding: 0;
        list-style: none;
        position: relative;
    } 
    /* The line */
    .timeline:before {
        content: '';
        position: absolute;
        top: 0;
        bottom: 0;
        width: 10px;
        background: #afdcf8;
        left: 20%;
        margin-left: -6px;
    }
    /* The date/time */
    .timeline .time {
        display: block;
        width: 35%;
        padding-right: 100px;
        position: absolute;
        color: #AAA;
        margin-top:60px;
    }
    .timeline .time span {
        display: block;
        text-align: right;
    }
    .timeline .time span:first-child {
        font-size: 0.9em;
        color: #bdd0db;
    }
    .timeline .time span:last-child {
        font-size: 2.9em;
        color: #24a0f0;
    }
    .timeline:nth-child(odd) .time span:last-child {
        color: #7878f0;
    }
    /* Right content */
    .timeline li .label {
        margin: 0 0 40px 25%;
        padding: 0 1em;
        font-size: 1.2em;
        font-weight: 300;
        line-height: 1.4;
        position: relative;
        border-radius: 5px;
        background:#0bf;
    }
    .timeline li.author-by-klaus .label{
        background:#b0c4de;
    }

    .timeline li.author-by-laura .label{
        background:#e6e6fa;
    }

    .timeline .label * {
        color: #fff;
    }

    .timeline .label > div{
        padding: 0.5em 0;
    }

    .timeline .label .label_content p{
        font-size:15px;
        margin-bottom:5px;
    }

    .timeline .label .label_content img{
        object-fit: cover;
        border-radius: 4px;
    }

    .timeline .label .label_others { 
        border-bottom: 0px;
        border-top:1px dashed #FFF; 
        font-size:16px; 
        margin:0px;
    }
    .timeline .label .label_others > span { 
        font-size: 14px; 
        text-align: center; 
        line-height: 24px; 
        overflow: hidden; 
        text-overflow: ellipsis; 
        white-space: nowrap;
    }
    /* The triangle */
    .timeline li .label:after {
        right: 100%;
        border: solid transparent;
        content: " ";
        height: 0;
        width: 0;
        position: absolute;
        pointer-events: none;
        border-right-color: #0bf;
        border-width: 10px;
        top: 10px;
    }
    .timeline li.author-by-klaus .label:after {
        border-right-color: #b0c4de;
    }
    .timeline li.author-by-laura .label:after {
        border-right-color: #e6e6fa;
    }
    /* The icons */
    .timeline .icon {
        width: 48px;
        height: 48px;
        speak: none;
        font-style: normal;
        font-weight: normal;
        font-variant: normal;
        text-transform: none;
        font-size: 48px;
        line-height: 48px;
        -webkit-font-smoothing: antialiased;
        position: relative;
        color: #fff;
        background: #46a4da;
        border-radius: 5%;
        box-shadow: 0 0 0 8px #afdcf8;
        text-align: center;
        left: 20%;
        top: 0;
        margin: 0 0 0 -25px;
    }
    .timeline .icon >img {
        border-radius: 5%; 
        position: absolute; 
        top: 0px; 
        left: 0px;
    }

    .author_img img{
        vertical-align: initial;
        border-radius: 5%;
    }
    /* Example Media Queries */
    @media screen and (max-width: 65.375em) {
        .timeline .time span:last-child {
            font-size: 1.5em;
        }
    }
    @media screen and (max-width: 47.2em) {
        .timeline:before {
            display: none;
        }
        .timeline .time {
            width: 100%;
            position: relative;
            padding: 0 0 20px 0;
        }
        .timeline .time span {
            text-align: left;
        }
        .timeline li .label {
            margin: 0 0 30px 0;
            padding: 1em;
            font-weight: 400;
            font-size: 95%;
        }

        .timeline li .label:after{
            right: auto;
            left: 20px;
            border-right-color: transparent!important;
            border-bottom-color: #0bf;
            top: -20px;
        }
        .timeline li.author-by-klaus .label:after {
            border-bottom-color: #b0c4de;
        }
        .timeline li.author-by-laura .label:after {
            border-bottom-color:#e6e6fa;
        }
        .timeline .icon {
            position: relative;
            float: right;
            left: auto;
            margin: -60px 5px 0 0px;
        }
    }
</style>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
        <section class="kl_shuoshuo">
            <ul class="timeline">
            <?php 
                query_posts("post_type=shuoshuo & post_status=publish & posts_per_page=-1");
                if ( have_posts() ) { 
                    while ( have_posts() ) { 
                        the_post(); 
            ?>
                <li class="<?php $author = get_the_author_meta('user_nicename'); if($author == "klaus") { echo 'author-by-klaus'; } else if($author == "laura") { echo 'author-by-laura'; } ?>">
                    <time class="time"><?php the_time('Y年n月j日 G:i'); ?></time>
                    <div class="icon">
                        <span class="author_img"> <?php echo get_avatar( get_the_author_meta( 'user_email' ) ); ?>
                    </div>
                    <div class="label" >
                        <div class="label_content">
                            <p><?php the_content(); ?></p>
                            <p class="flex-hr-vc">From <?php the_author_meta('user_nicename'); ?></p>
                        </div>
                        <div class="label_others flex-hb-vc">
                            <div class="flex-hl-vc">
                                <span><?php the_title(); ?></span>
                            </div>
                            <div class="flex-hl-vc">
                                <div class="entry-comment m-0 mr-15">
                                    <?php is_icon( get_the_ID() , "reply"); ?>
                                </div>
                                <div class="zan">
                                    <a href="#" data-action="ding" data-id="<?php the_ID(); ?>" id="Addlike" class="action flex-hb-vc <?php if(isset($_COOKIE['inlo_ding_'.$post->ID])) echo 'actived';?> <?php $category = get_the_category();  echo $category[0]->category_nicename;?>">
                                        <i class="lalaksks lalaksks-ic-zan"></i>
                                        <span class="count"><?php if( get_post_meta($post->ID,'inlo_ding',true) ){ echo get_post_meta($post->ID,'inlo_ding',true); } else {echo '0';}?></span>
                                    </a>
                                </div>
                            </div>                           
                        </div>
                    </div>
                </li>
            <?php }
            comments_template();

            } ?>
            </ul>
        </section>
    </main>
    <!-- .site-main -->
</div>
<?php get_footer();?>