<?php
/**
 * The template for displaying search results pages.
 *
 * @package anissa
 */

get_header(); ?>

<div id="primary" class="main-area">
  <main id="main" class="main-content" role="main">
    <?php if ( have_posts() ) : ?>
    <header class="page-header">
      <h1 class="page-title"><?php printf( esc_html__( '搜索结果如下 (包含%s)', 'anissa' ), get_search_query() ); ?></h1>
    </header>
    <!-- .page-header -->
    
    <?php /* Start the Loop */ ?>
    <?php while ( have_posts() ) : the_post(); ?>
    <?php
				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				get_template_part( 'template-parts/content', 'search' );
				?>
    <?php endwhile; ?>
    <?php the_posts_navigation(); ?>
    <?php else : ?>
    <?php get_template_part( 'template-parts/content', 'none' ); ?>
    <?php endif; ?>
  </main>
  <!-- #main --> 
</div>
<!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
