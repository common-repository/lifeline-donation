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
function webinane_parallax_donation_campaign_block_init() {
	// Skip block registration if Gutenberg is not enabled/merged.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}
	$dir = dirname( __FILE__ );

	$child_dir = 'parallax_donation_campaign';
	$index_js  = "$child_dir/index.js";
	wp_register_script(
		'parallax-donation-campaign-block-editor',
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

	$editor_css = "$child_dir/editor.css";
	wp_register_style(
		'parallax-donation-campaign-block-editor',
		plugins_url( $editor_css, __FILE__ ),
		array(),
		filemtime( "$dir/$editor_css" )
	);

	$style_css = "$child_dir/style.css";
	wp_register_style(
		'parallax-donation-campaign-block',
		plugins_url( $style_css, __FILE__ ),
		array(),
		filemtime( "$dir/$style_css" )
	);

	register_block_type( "lifeline-donation/parallax-donation-campaign", array(
		'editor_script' => 'parallax-donation-campaign-block-editor',
		'editor_style'  => 'parallax-donation-campaign-block-editor',
		// 'style'         => 'parallax-donation-campaign-block',
		'render_callback'	=> 'webinane_donation_render_callback_campaign_parallax',
	) );
}

add_action( 'init', 'webinane_parallax_donation_campaign_block_init' );


function webinane_donation_render_callback_campaign_parallax($atts, $output) {
	wp_enqueue_script(array('lifeline-donation-modal'));
	wp_enqueue_style(array('webinane-shortcodes', 'dashicons'));
	// return '<section class="wpcm-wrapper"></section>';
	return $output;
}