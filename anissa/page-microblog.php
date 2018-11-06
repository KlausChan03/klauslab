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
.kl_tmtimeline {
    margin: 30px 0 0 0;
    padding: 0;
    list-style: none;
    position: relative;
} 
/* The line */
.kl_tmtimeline:before {
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
.kl_tmtimeline .kl_tmtime {
    display: block;
    width: 35%;
    padding-right: 100px;
    position: absolute;
    color: #AAA;
    margin-top:60px;
}
.kl_tmtimeline .kl_tmtime span {
    display: block;
    text-align: right;
}
.kl_tmtimeline .kl_tmtime span:first-child {
    font-size: 0.9em;
    color: #bdd0db;
}
.kl_tmtimeline .kl_tmtime span:last-child {
    font-size: 2.9em;
    color: #24a0f0;
}
.kl_tmtimeline:nth-child(odd) .kl_tmtime span:last-child {
    color: #7878f0;
}
/* Right content */
li .kl_tmlabel {
    margin: 0 0 40px 25%;
    padding: 0 1em;
    font-size: 1.2em;
    font-weight: 300;
    line-height: 1.4;
    position: relative;
    border-radius: 5px;
    background:#0bf;
}
li:nth-child(odd) .kl_tmlabel{
    background:#d42;
}

.kl_tmtimeline .kl_tmlabel * {
    color: #fff;
}

.kl_tmtimeline .kl_tmlabel > div{
    padding: 0.5em 0;
}

.kl_tmtimeline .kl_tmlabel .kl_tmlabel_content p{
    margin-bottom:8px;
}

.kl_tmtimeline .kl_tmlabel .kl_tmlabel_content img{
    object-fit: cover;
    border-radius: 4px;
}

.kl_tmtimeline .kl_tmlabel .kl_tmlabel_others { 
    border-bottom: 0px;
    border-top:1px dashed #FFF; 
    font-size:16px; 
    margin:0px;
}
.kl_tmtimeline .kl_tmlabel .kl_tmlabel_others > span { 
    font-size: 14px; 
    text-align: center; 
    line-height: 24px; 
    overflow: hidden; 
    text-overflow: ellipsis; 
    white-space: nowrap;
}
/* The triangle */
li .kl_tmlabel:after {
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
li:nth-child(odd) .kl_tmlabel:after {
    border-right-color: #d42;
}
/* The icons */
.kl_tmtimeline .kl_tmicon {
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
.kl_tmtimeline .kl_tmicon >img {
    border-radius: 5%; 
    position: absolute; 
    top: 0px; 
    left: 0px;
}

.kl_author_img img{
    vertical-align: initial;
    border-radius: 5%;
}
/* Example Media Queries */
@media screen and (max-width: 65.375em) {
    .kl_tmtimeline .kl_tmtime span:last-child {
        font-size: 1.5em;
    }
}
@media screen and (max-width: 47.2em) {
    .kl_tmtimeline:before {
        display: none;
    }
    .kl_tmtimeline .kl_tmtime {
        width: 100%;
        position: relative;
        padding: 0 0 20px 0;
    }
    .kl_tmtimeline .kl_tmtime span {
        text-align: left;
    }
    .kl_tmtimeline .kl_tmlabel {
        margin: 0 0 30px 0;
        padding: 1em;
        font-weight: 400;
        font-size: 95%;
    }
    .kl_tmtimeline .kl_tmlabel:after {
        right: auto;
        left: 20px;
        border-right-color: transparent;
        border-bottom-color: #0bf;
        top: -20px;
    }
    .kl_tmtimeline:nth-child(odd) .kl_tmlabel:after {
        border-right-color: transparent;
        border-bottom-color: #d42;
    }
    .kl_tmtimeline .kl_tmicon {
        position: relative;
        float: right;
        left: auto;
        margin: -60px 5px 0 0px;
    }
}
</style>

<div id="primary" class="content-area" style="">
    <main id="main" class="site-main" role="main">

        <section class="kl_shuoshuo">
            <ul class="kl_tmtimeline">
            <?php 
            query_posts("post_type=shuoshuo & post_status=publish & posts_per_page=-1");
            if ( have_posts() ) { 
            while ( have_posts() ) { 
            the_post(); ?>
                <li>
                    <time class="kl_tmtime"><?php the_time('Y年n月j日 G:i'); ?></time>
                    <div class="kl_tmicon">
                    <span class="kl_author_img"> <?php echo get_avatar( get_the_author_meta( 'user_email' ) ); ?>
                    </div>
                    <div class="kl_tmlabel" >
                        <div class="kl_tmlabel_content">
                            <p><?php the_content(); ?></p>
                        </div>
                        <div  class="kl_tmlabel_others flex-hb-vc">
                            <span><?php the_title(); ?></span>
                            <span class="zan">
                                <a href="#" data-action="ding" data-id="<?php the_ID(); ?>" id="Addlike" class="action flex-hb-vc <?php if(isset($_COOKIE['inlo_ding_'.$post->ID])) echo 'actived';?> <?php $category = get_the_category();  echo $category[0]->category_nicename;?>">
                                    <i class="lalaksks lalaksks-ic-zan"></i>
                                    <span class="count"><?php if( get_post_meta($post->ID,'inlo_ding',true) ){ echo get_post_meta($post->ID,'inlo_ding',true); } else {echo '0';}?></span>
                                </a>
                            </span>
                        </div>
                    </div>
                </li>
            <?php }
            global $withcomments; $withcomments = true;

            } ?>
            </ul>
        </section>
    </main>
    <!-- .site-main -->
</div>
<script>

</script>
<?php get_sidebar();?>
<?php get_footer();?>