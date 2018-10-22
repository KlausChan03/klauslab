<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package anissa
 */



if ( ! function_exists( 'anissa_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function anissa_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>';

	$byline = '<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>';

	echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( esc_html__( 'Leave a comment', 'anissa' ), esc_html__( '1 Comment', 'anissa' ), esc_html__( '% Comments', 'anissa' ) );
		echo '</span>';
	}

	edit_post_link( esc_html__( 'Edit', 'anissa' ), '<span class="edit-link">', '</span>' );

}
endif;

if ( ! function_exists( 'anissa_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function anissa_entry_footer() {

	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>';
	$byline = '<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>';

	echo '<div class="entry-footer-wrapper flex-hc-vc flex-hw">';
	echo '<span class="posted-on mr-10"><i class="lalaksks lalaksks-ic-date mr-5"></i>' . $posted_on . '</span><span class="byline mr-10"><i class="lalaksks lalaksks-ic-author mr-5"></i>' . $byline . '</span>'; // WPCS: XSS OK.

	// Hide category and tag text for pages.
	if ( 'post' == get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'anissa' ) );
		if ( $categories_list && anissa_categorized_blog() ) {
			printf( '<span class="cat-links mr-10"><i class="lalaksks lalaksks-ic-category mr-5"></i>%1$s</span>', $categories_list ); // WPCS: XSS OK.
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'anissa' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links mr-10"><i class="lalaksks lalaksks-ic-tag mr-5"></i>%1$s</span>', $tags_list ); // WPCS: XSS OK.
		}
	}
	// $test = post_views('当前阅读次数：&nbsp;', '&nbsp;');
	$view_num = getPostViews(get_the_ID());
	echo '<span class="watch-times mr-10"><i class="lalaksks lalaksks-ic-view mr-5"></i>' . $view_num . '</span>'; // WPCS: XSS OK.
	

	echo '</div><!--.entry-footer-wrapper-->';
	if(isAdmin()){
		edit_post_link(_e('<span class="edit-link mr-10"><i class="lalaksks lalaksks-ic-edit mr-5"></i>', '</span>' ) );
	}
}
endif;


/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function anissa_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'anissa_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'anissa_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so anissa_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so anissa_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in anissa_categorized_blog.
 */
function anissa_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'anissa_categories' );
}
add_action( 'edit_category', 'anissa_category_transient_flusher' );
add_action( 'save_post',     'anissa_category_transient_flusher' );