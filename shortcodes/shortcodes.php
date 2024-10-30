<?php
namespace LifelineDonation\Shortcodes;


abstract class Shortcodes
{
	static $instance = '';
	static $shortcode = '';
	static $shortcodes = [];
	static $category = 'WI Donations';
	static $vc_map = '';
	static $fields = [];

	static function init() {

		if( self::$shortcode ) {
			self::$fields[self::$shortcode] = self::$vc_map;
			if( ! function_exists('vc_map') ) {
				add_shortcode(self::$shortcode, array(__CLASS__, 'output'));
			}
		}

		if( function_exists('vc_map') ) {
			vc_map(self::$vc_map);
		}
	}

	
	/**
	 * Shortcode output.
	 * 
	 * @param  [type] $atts    [description]
	 * @param  [type] $content [description]
	 * @param  [type] $tag     [description]
	 * @return [type]          [description]
	 */
	static function output($atts, $content = null, $tag) {
		$atts = (array)$atts;
		$atts['content'] = $content;
		$atts['atts'] = $atts;
		
		$fields = webinane_set(self::$fields, $tag);
		$default = array_flip(wp_list_pluck($fields['params'], 'param_name'));
		$atts = wp_parse_args( $atts, $default );

		ob_start();
		if(file_exists(self::load_template($tag, $atts))) {
			include self::load_template($tag, $atts);
		}
		return ob_get_clean();
	}

	/**
	 * Load template if vc is not active.
	 * 
	 * @param  [type] $tag  [description]
	 * @param  [type] $atts [description]
	 * @return [type]       [description]
	 */
	private static function load_template($tag, $atts) {
		include self::get_path($tag);
	}

	static function map_vc_fields() {

	}

	/**
	 * Theme and chld theme overriding.
	 * 
	 * @param  [type] $path [description]
	 * @return [type]       [description]
	 */
	static function get_template_path() {
		return self::get_path(self::$shortcode);
	}

	/**
	 * [get_path description]
	 * @param  [type] $shortcode [description]
	 * @return [type]            [description]
	 */
	private static function get_path($shortcode) {

		$file = get_theme_file_path( 'lifeline-donation/shortcodes/' . $shortcode . '.php' );
		if(file_exists($file)) {
			return $file;
		}

		return LIFELINE_DONATION_PATH . 'shortcodes/output/' . $shortcode . '.php';
	}
}
