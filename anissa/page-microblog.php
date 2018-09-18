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
.kl_tmtimeline > li .kl_tmtime {
    display: block;
    width: 30%;
    padding-right: 100px;
    position: absolute;
    color: #AAA;
    margin-top:50px;
}
.kl_tmtimeline > li .kl_tmtime span {
    display: block;
    text-align: right;
}
.kl_tmtimeline > li .kl_tmtime span:first-child {
    font-size: 0.9em;
    color: #bdd0db;
}
.kl_tmtimeline > li .kl_tmtime span:last-child {
    font-size: 2.9em;
    color: #24a0f0;
}
.kl_tmtimeline > li:nth-child(odd) .kl_tmtime span:last-child {
    color: #7878f0;
}
/* Right content */
.kl_tmtimeline > li .kl_tmlabel {
    margin: 0 0 15px 25%;
    background: #24a0f0;
    color: #fff;
    padding: 0.8em;
    font-size: 1.2em;
    font-weight: 300;
    line-height: 1.4;
    position: relative;
    border-radius: 5px;
}
.kl_tmtimeline > li:nth-child(odd) .kl_tmlabel {
    background: #7878f0;
}
.kl_tmtimeline > li .kl_tmlabel h2 { 
    border-bottom: 0px;
    border-top:1px dashed #FFF; 
    font-size:16px; 
    height: 24px; 
    padding: 5px 3px 12px; 
    margin:0px;
}
.kl_tmtimeline > li .kl_tmlabel h2 > span { 
    font-size: 12px; 
    float: right; 
    text-align: center; 
    line-height: 24px; 
    overflow: hidden; 
    text-overflow: ellipsis; 
    white-space: nowrap;
}
/* The triangle */
.kl_tmtimeline > li .kl_tmlabel:after {
    right: 100%;
    border: solid transparent;
    content: " ";
    height: 0;
    width: 0;
    position: absolute;
    pointer-events: none;
    border-right-color: #24a0f0;
    border-width: 10px;
    top: 10px;
}
.kl_tmtimeline > li:nth-child(odd) .kl_tmlabel:after {
    border-right-color: #7878f0;
}
/* The icons */
.kl_tmtimeline > li .kl_tmicon {
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
    border-radius: 50%;
    box-shadow: 0 0 0 8px #afdcf8;
    text-align: center;
    left: 20%;
    top: 0;
    margin: 0 0 0 -25px;
}
.kl_tmtimeline > li .kl_tmicon >img {
    border-radius: 50%; 
    position: absolute; 
    top: 0px; 
    left: 0px;
}

.kl_author_img img{
    vertical-align: initial;
    border-radius: 50%;
}
/* Example Media Queries */
@media screen and (max-width: 65.375em) {
    .kl_tmtimeline > li .kl_tmtime span:last-child {
        font-size: 1.5em;
    }
}
@media screen and (max-width: 47.2em) {
    .kl_tmtimeline:before {
        display: none;
    }
    .kl_tmtimeline > li .kl_tmtime {
        width: 100%;
        position: relative;
        padding: 0 0 20px 0;
    }
    .kl_tmtimeline > li .kl_tmtime span {
        text-align: left;
    }
    .kl_tmtimeline > li .kl_tmlabel {
        margin: 0 0 30px 0;
        padding: 1em;
        font-weight: 400;
        font-size: 95%;
    }
    .kl_tmtimeline > li .kl_tmlabel:after {
        right: auto;
        left: 20px;
        border-right-color: transparent;
        border-bottom-color: #24a0f0;
        top: -20px;
    }
    .kl_tmtimeline > li:nth-child(odd) .kl_tmlabel:after {
        border-right-color: transparent;
        border-bottom-color: #7878f0;
    }
    .kl_tmtimeline > li .kl_tmicon {
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
                    <time class="kl_tmtime"><i class="fa fa-clock-o"></i> <?php the_time('Y年n月j日G:i'); ?></time>
                    <div class="kl_tmicon">
                    <span class="kl_author_img"> <?php echo get_avatar( get_the_author_meta( 'user_email' ) ); ?>
                    </div>
                    <div class="kl_tmlabel" >
                        <span><?php the_content(); ?></span>
                        <h2><?php the_title(); ?><span><?php echo get_bloginfo('name'); ?></span></h2>
                    </div>
                </li>
            <?php }
            } ?>
            </ul>
        </section>
    </main>
    <!-- .site-main -->
</div>
<?php get_sidebar();?>
<?php get_footer();?>