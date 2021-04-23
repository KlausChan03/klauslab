<?php
/**
 * The template part for displaying a message that posts cannot be found.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package KlausLab
 */

?>

<section id="empty-main" class="no-results not-found">
	<!-- .page-header -->
	<!-- <div class="page-header">
		<h2 class="page-title"><?php esc_html_e( '从什么都没有的地方，到什么都没有的地方', 'KlausLab' ); ?></h2>
	</div> -->

	<el-card class="page-content">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<!-- <p><?php printf( wp_kses( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'KlausLab' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p> -->
			<kl-empty description="开始新的篇章"></kl-empty>

		<?php elseif ( is_search() ) : ?>

			<!-- <p class="mb-10"><?php esc_html_e( '[ 搜索小哥生气了，你换个关键词再试试 ]', 'KlausLab' ); ?></p> -->
			<kl-empty description="搜索小哥生气了，你换个关键词再试试"></kl-empty>

			<?php get_search_form(); ?>

		<?php else : ?>

			<!-- <p class="mb-10"><?php esc_html_e( '[ 主人，请给该分类填充内容 ]', 'KlausLab' ); ?></p> -->
			<kl-empty description="请给该分类填充内容"></kl-empty>

			<!-- <?php get_search_form(); ?> -->

		<?php endif; ?>
	</el-card><!-- .page-content -->
</section><!-- .no-results -->
<script>
	new Vue({
        el: "#empty-main",
		
	})
</script>