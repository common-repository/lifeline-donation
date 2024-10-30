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
function webinane_donation_giving_hand_block_init() {
	// Skip block registration if Gutenberg is not enabled/merged.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}
	$dir = dirname( __FILE__ );

	$index_js = 'giving-hand/index.js';
	wp_register_script(
		'giving-hand-block-editor',
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

	$editor_css = 'giving-hand/editor.css';
	wp_register_style(
		'giving-hand-block-editor',
		plugins_url( $editor_css, __FILE__ ),
		array(),
		filemtime( "$dir/$editor_css" )
	);

	$style_css = 'giving-hand/style.css';
	wp_register_style(
		'giving-hand-block',
		plugins_url( $style_css, __FILE__ ),
		array(),
		filemtime( "$dir/$style_css" )
	);

	register_block_type( 'lifeline-donation/giving-hand', array(
		'editor_script' => 'giving-hand-block-editor',
		'editor_style'  => 'giving-hand-block-editor',
		// 'style'         => 'giving-hand-block',
		'render_callback'	=> 'webinane_donation_render_callback_giving_hand',
	) );
}
add_action( 'init', 'webinane_donation_giving_hand_block_init' );

function webinane_donation_render_callback_giving_hand($atts, $output) {
	wp_enqueue_style(array('webinane-shortcodes'));
	return $output;
}