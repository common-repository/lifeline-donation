<?php
/**
 * Functions to register client-side assets (scripts and stylesheets) for the
 * Gutenberg block.
 *
 * @package lifeline-donation
 */

/**
 * Registers all block assets so that they can be enqueued through Gutenberg in
 * the corresponding context.
 *
 * @see https://wordpress.org/gutenberg/handbook/designers-developers/developers/tutorials/block-tutorial/applying-styles-with-stylesheets/
 */
function webinane_donation_parallax_block_init() {
	// Skip block registration if Gutenberg is not enabled/merged.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}
	$dir = dirname( __FILE__ );

	$index_js = 'parallax/index.js';
	wp_register_script(
		'donation-parallax-block-editor',
		plugins_url( $index_js, __FILE__ ),
		array(
			'wp-blocks',
			'wp-i18n',
			'wp-element',
			'wp-editor',
			'wp-plugins',
            'wp-edit-post',
            'wp-data',
		),
		filemtime( "$dir/$index_js" )
	);

	$editor_css = 'parallax/editor.css';
	wp_register_style(
		'donation-parallax-block-editor',
		plugins_url( $editor_css, __FILE__ ),
		array(),
		filemtime( "$dir/$editor_css" )
	);

	$style_css = 'parallax/style.css';
	wp_register_style(
		'donation-parallax-block',
		plugins_url( $style_css, __FILE__ ),
		array(),
		filemtime( "$dir/$style_css" )
	);

	register_block_type( 'lifeline-donation/parallax', array(
		'editor_script' => 'donation-parallax-block-editor',
		'editor_style'  => 'donation-parallax-block-editor',
		// 'style'         => 'donation-parallax-block',
		'render_callback'	=> 'webinane_donation_parallax_render_callback'
	) );
}
add_action( 'init', 'webinane_donation_parallax_block_init' );

function webinane_donation_parallax_render_callback($atts, $output) {
	wp_enqueue_script(array('lifeline-donation-modal'));
	wp_enqueue_style( 'dashicons' );

	return $output;
}
