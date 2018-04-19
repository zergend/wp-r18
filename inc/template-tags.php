<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package _s
 */
if ( ! function_exists( 'rekord18_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function rekord18_posted_on() {
	$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);
	/*
	$posted_on = sprintf(
		esc_html_x( 'Опубликовано: %s', 'post date', 'rekord18' ),
		$time_string
	);
	*/
	$byline = sprintf(
		esc_html_x( 'by %s', 'post author', 'rekord18' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);
	echo '<span class="posted-on">' . $time_string . '</span>'; // WPCS: XSS OK.
}
endif;
if ( ! function_exists( 'rekord18_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function rekord18_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'rekord18' ) );
		if ( $categories_list && rekord18_categorized_blog() ) {
			printf( '<span class="cat-links">' . esc_html__( 'Рубрика: %1$s', 'rekord18' ) . '</span> ', $categories_list ); // WPCS: XSS OK.
		}
		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'rekord18' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links">' . esc_html__( 'Метки: %1$s', 'rekord18' ) . '</span> ', $tags_list ); // WPCS: XSS OK.
		}
	}
	edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			esc_html__( 'Редактировать', 'rekord18' ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		),
		'<span class="edit-link">',
		'</span>'
	);
}
endif;
/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function rekord18_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'rekord18_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );
		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );
		set_transient( 'rekord18_categories', $all_the_cool_cats );
	}
	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so rekord18_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so rekord18_categorized_blog should return false.
		return false;
	}
}
/**
 * Flush out the transients used in rekord18_categorized_blog.
 */
function rekord18_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'rekord18_categories' );
}
add_action( 'edit_category', 'rekord18_category_transient_flusher' );
add_action( 'save_post',     'rekord18_category_transient_flusher' );
