<?php
/**
 * The template part for displaying a message that posts cannot be found.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package anissa
 */

?>

<section class="no-results not-found">
	<div class="page-header">
		<h1 class="page-title"><?php esc_html_e( '从什么都没有的地方，到什么都没有的地方', 'anissa' ); ?></h1>
	</div><!-- .page-header -->

	<div class="page-content">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p><?php printf( wp_kses( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'anissa' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

		<?php elseif ( is_search() ) : ?>

			<p class="mb-10"><?php esc_html_e( '[ 搜索小哥生气了，你换个关键词再试试 ]', 'anissa' ); ?></p>
			<?php get_search_form(); ?>

		<?php else : ?>

			<p class="mb-10"><?php esc_html_e( '[ 主人，请给该分类填充内容 ]', 'anissa' ); ?></p>
			<?php get_search_form(); ?>

		<?php endif; ?>
	</div><!-- .page-content -->
</section><!-- .no-results -->
