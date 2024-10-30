<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

wp_enqueue_style( 'webinane-shortcodes');
wp_enqueue_script(array('lifeline-donation-modal'));

/**
 * Shortcode attributes
 * @var $atts
 * @var $color
 * @var $size
 * @var $icon
 * @var $target
 * @var $href
 * @var $el_class
 * @var $title
 * Shortcode class
 * @var WPBakeryShortCode_Vc_Button $this
 */
$color = $size = $icon = $target = $href = $el_class = $title = '';
$output = '';
$atts = wi_donation_shortcode_atts( 'wi_donation_button2', $atts );
extract( $atts );

$a_class = '';

if ( '' !== $el_class ) {
	$tmp_class = explode( ' ', strtolower( $el_class ) );
	$tmp_class = str_replace( '.', '', $tmp_class );
	if ( in_array( 'prettyphoto', $tmp_class, true ) ) {
		wp_enqueue_script( 'prettyphoto' );
		wp_enqueue_style( 'prettyphoto' );
		$a_class .= ' prettyphoto';
		$el_class = str_ireplace( 'prettyphoto', '', $el_class );
	}
	if ( in_array( 'pull-right', $tmp_class, true ) && '' !== $href ) {
		$a_class .= ' pull-right';
		$el_class = str_ireplace( 'pull-right', '', $el_class );
	}
	if ( in_array( 'pull-left', $tmp_class, true ) && '' !== $href ) {
		$a_class .= ' pull-left';
		$el_class = str_ireplace( 'pull-left', '', $el_class );
	}
}

if ( 'same' === $target || '_self' === $target ) {
	$target = '';
}
$target = ( '' !== $target ) ? ' target="' . esc_attr( $target ) . '"' : '';

$color = ( '' !== $color ) ? ' wpb_' . $color : '';
$size = ( '' !== $size && 'wpb_regularsize' !== $size ) ? ' wpb_' . $size : ' ' . $size;
$icon = ( '' !== $icon && 'none' !== $icon ) ? ' ' . $icon : '';
$i_icon = ( '' !== $icon ) ? ' <i class="icon"> </i>' : '';
$el_class = wi_donation_getExtraClass( $el_class );

$css_class = apply_filters( 'vc_shortcodes_css_class', 'wpb_button ' . $color . $size . $icon . $el_class, 'wi_donation_button2', $atts );

$output .= '<div class="urgent-popup-list">';
if ( '' !== $href ) {
	$output_new = '<span class="' . sanitize_html_class( $css_class ) . '">' . $title . $i_icon . '</span>';
	$output .= '<a class="wpb_button_a' . sanitize_html_class( $a_class ) . '" title="' . esc_attr( $title ) . '" href="' . esc_attr( $href ) . '"' . $target . '>' . $output_new . '</a>';
} else {
	$output_new = '<span class="' . sanitize_html_class( $css_class ) . '">' . $title . $i_icon . '</span>';
	$output .= '<donation-button :id="'.esc_attr($post_id).'"><a class="wpb_button_a' . sanitize_html_class( $a_class ) . '" title="' . esc_attr( $title ) . '" href="' . esc_attr( $href ) . '"' . $target . '>' . $output_new . '</a></donation-button>';
}
$output .= '</div>';

echo $output;
