<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Shortcode attributes
 * @var $atts
 * @var WPBakeryShortCode_Vc_Btn $this
 */

wp_enqueue_style( 'webinane-shortcodes');
wp_enqueue_script(array('lifeline-donation-modal'));

$atts = wi_donation_shortcode_atts( 'wi_donation_template', $atts );

extract( $atts );

if( isset($id)  && $id) {
	$pst_id = $id;
} else {
	$pst_id = '';// get_the_id();
}
echo do_shortcode('[webinane_donation_page id="'.$pst_id.'" title="'.$title.'" style="'.$style.'"]'.$content.'[/webinane_donation_page]');

?>