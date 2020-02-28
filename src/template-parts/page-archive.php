<?php 
/**
*  @package KlausLab
*  Template Name: 归档
*  author: Klaus
*/
  get_header();
?>
<div id="primary" class="main-area w-1">
    <main id="main" class="main-content" role="main">
        <?php if (have_posts()) : the_post(); update_post_caches($posts); ?>
        <article id="archive-main" class="post-<?php the_ID(); ?> page-main style-18">
            <div class="entry-header flex-hc-vc">
                <?php the_title( '<h3 class="entry-title">', '</h3>' ); ?>
                <?php if ( is_single() || is_page() && has_post_thumbnail() ) : ?>
                <div id="banner-bg" class="featured-header-image">
                    <?php the_post_thumbnail( 'KlausLab-home' ); ?>
                </div><!-- .featured-header-image -->
                <?php endif; ?>
            </div><!-- .entry-header -->
            <div class="entry-content page-content">
                <div id="archive-filter" class="archive-filter p-lr-01">
                    <div class="filter-author kl-btn-container flex-hl-vc p-tb-5">
                        <label>作者：</label>
                        <div>
                            <button class="kl-btn kl-btn-sm" data-author="Klaus" @click="choose($event)">Klaus</button>
                            <button class="kl-btn kl-btn-sm" data-author="Laura" @click="choose($event)">Laura</button>
                        </div>
                    </div>
                    <div class="filter-type kl-btn-container flex-hl-vc p-tb-5">
                        <label>类型：</label>
                        <div>
                            <button class="kl-btn kl-btn-sm" data-type="post" @click="choose($event)">文章</button>
                            <button class="kl-btn kl-btn-sm" data-type="shuoshuo" @click="choose($event)">说说</button>
                        </div>
                    </div>
                    <div class="filter-chosed mt-30 flex-hl-vc">
                        <label>当前选择：</label>
                        <div v-html="filterContent"></div>
                    </div>
                </div>
                <div class="entry-content-list p-lr-01" v-html="archiveContent">
                </div>
            </div>
            <?php edit_post_link( esc_html__( 'Edit', 'KlausLab' ), '<footer class="entry-footer clear"><span class="edit-link">', '</span></footer><!-- .entry-footer -->' ); ?>
        </article>
        <?php endif; ?>
    </main>
</div>
<script>
    // $(document).on("click", ".filter-type button", function() {
    //     var this_ = $(this),
    //         that_author,
    //         this_type = $(this).data("type"),
    //         content_dom = $(".entry-content-list");
    //     this_.attr("data-active", true);
    //     this_.siblings().removeAttr("data-active");
    //     if (this_type == "post") {
    //         content_dom.html(`<?php archives_list("post",null); the_content(); ?>`)
    //     } else if (this_type == "shuoshuo") {
    //         content_dom.html(`<?php archives_list("shuoshuo",null); the_content(); ?>`)
    //     }
    // })
    // $(document).on("click", ".filter-author button", function() {
    //     var this_ = $(this),
    //         that_type,
    //         this_author = $(this).data("author"),
    //         content_dom = $(".entry-content-list");

    //     this_.attr("data-active", true);
    //     this_.siblings().removeAttr("data-active");
    //     console.log(this_author)
    //     if (this_author == "Klaus") {
    //         content_dom.html(`<?php archives_list(null,"Klaus"); the_content(); ?>`)
    //     } else if (this_author == "Laura") {
    //         content_dom.html(`<?php archives_list(null,"Laura"); the_content(); ?>`)
    //     }
    // })
    // $(document).on("click", ".entry-content-filter button", function() {
    //     var this_ = $(this),
    //         this_type =  $(this).data("type"),
    //         this_author = $(this).data("author"),
    //         content_dom = $(".entry-content-list");
    // })

    let archiveFilter = new Vue({
        el: '#archive-main',
        data: {
            archiveContent: '',
            filterContent:'',
            filterArr: [],
        },
        methods: {
            choose: function ($event) {
                let params = new FormData;
                params.append('action', 'filter_archive');
                if ($event.target.attributes['data-type']) {
                    this.filterArr[0] = $event.target.attributes['data-type'].value;
                }
                if ($event.target.attributes['data-author']) {
                    this.filterArr[1] = $event.target.attributes['data-author'].value;
                }
                this.filterContent = this.filterArr.join(',');
                params.append('filter', this.filterArr);
                axios.post(`${GLOBAL.homeUrl}/wp-admin/admin-ajax.php`, params).then((res) => {
                    this.archiveContent = res.data;
                })

            }
        }
    })



</script>
<?php get_footer();