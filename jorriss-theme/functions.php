<?php
/**
 * Jorriss theme setup, assets, and block bindings.
 *
 * @package Jorriss
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Theme supports.
 */
function jorriss_setup() {
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption', 'style', 'script' ) );

	// Load the theme stylesheet inside the block editor's iframe too.
	add_editor_style( 'assets/main.css' );
}
add_action( 'after_setup_theme', 'jorriss_setup' );

/**
 * Enqueue Google Fonts + the theme stylesheet on the front end AND in the editor.
 * enqueue_block_assets fires in both contexts, so the design matches while editing.
 */
function jorriss_assets() {
	wp_enqueue_style(
		'jorriss-fonts',
		'https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=IBM+Plex+Sans:wght@400;500;600&family=IBM+Plex+Mono:wght@400;500;600&display=swap',
		array(),
		null
	);
	wp_enqueue_style(
		'jorriss-theme',
		get_theme_file_uri( 'assets/main.css' ),
		array( 'jorriss-fonts' ),
		wp_get_theme()->get( 'Version' )
	);
}
add_action( 'enqueue_block_assets', 'jorriss_assets' );

/**
 * Register a "jorriss" pattern category so the hero/about patterns group together.
 */
function jorriss_pattern_category() {
	if ( function_exists( 'register_block_pattern_category' ) ) {
		register_block_pattern_category(
			'jorriss',
			array( 'label' => __( 'Jorriss', 'jorriss' ) )
		);
	}
}
add_action( 'init', 'jorriss_pattern_category' );

/**
 * ---------------------------------------------------------------------------
 * Block Bindings — let block-editor text pull dynamic post data (WP 6.5+).
 * Used in the single-post meta line: reading time + primary category/tag.
 * ---------------------------------------------------------------------------
 */

/**
 * Resolve the current post ID from binding context.
 *
 * @param WP_Block $block Block instance passed to the binding callback.
 * @return int
 */
function jorriss_binding_post_id( $block ) {
	if ( isset( $block->context['postId'] ) ) {
		return (int) $block->context['postId'];
	}
	return (int) get_the_ID();
}

/**
 * Estimate reading time in whole minutes.
 */
function jorriss_reading_time( $post_id ) {
	$content = get_post_field( 'post_content', $post_id );
	$words   = str_word_count( wp_strip_all_tags( strip_shortcodes( (string) $content ) ) );
	$minutes = max( 1, (int) ceil( $words / 200 ) );
	return $minutes . ' min read';
}

/**
 * First category (or tag) of a post as "#slug".
 */
function jorriss_primary_term( $post_id ) {
	$cats = get_the_category( $post_id );
	if ( ! empty( $cats ) ) {
		return '#' . $cats[0]->slug;
	}
	$tags = get_the_tags( $post_id );
	if ( ! empty( $tags ) ) {
		return '#' . $tags[0]->slug;
	}
	return '';
}

/**
 * Register the binding sources.
 */
function jorriss_register_bindings() {
	if ( ! function_exists( 'register_block_bindings_source' ) ) {
		return;
	}

	register_block_bindings_source(
		'jorriss/reading-time',
		array(
			'label'              => __( 'Reading time', 'jorriss' ),
			'get_value_callback' => function ( $source_args, $block ) {
				return jorriss_reading_time( jorriss_binding_post_id( $block ) );
			},
			'uses_context'       => array( 'postId' ),
		)
	);

	register_block_bindings_source(
		'jorriss/primary-term',
		array(
			'label'              => __( 'Primary term', 'jorriss' ),
			'get_value_callback' => function ( $source_args, $block ) {
				$term = jorriss_primary_term( jorriss_binding_post_id( $block ) );
				return $term ? $term : '// writing';
			},
			'uses_context'       => array( 'postId' ),
		)
	);
}
add_action( 'init', 'jorriss_register_bindings' );
