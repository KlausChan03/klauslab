<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package anissa
 */

get_header(); ?>

<div id="primary" class="main-area">
  <main id="main" class="main-content" role="main">
    <section class="error-404 not-found">
      <header class="page-header">
        <h1 class="page-title">
          <?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'anissa' ); ?>
        </h1>
      </header>
      <!-- .page-header -->
      
      <div class="page-content">
        <p>
          <?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'anissa' ); ?>
        </p>
        <?php get_search_form(); ?>
      </div>
      <!-- .page-content --> 
    </section>
    <!-- .error-404 --> 
    
  </main>
  <!-- #main --> 
</div>
<!-- #primary -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>
