<?php
namespace LifelineDonation\Shortcodes;

use LifelineDonation\Shortcodes\Shortcodes;

class Button2 extends Shortcodes
{

	static function init() {
		self::$shortcode = 'wi_donation_button2';
		self::$vc_map = self::vc_map();
		parent::init();
		add_filter('vc_autocomplete_wi_donation_button2_post_id_callback', array(__CLASS__, 'field_search'), 10, 3);
		add_filter('vc_autocomplete_wi_donation_button2_post_id_render', array(__CLASS__, 'field_render'), 10, 3);
		
		
	}

	static function vc_map() {
		if(! function_exists('vc_map')) {
			return [
				'name' => esc_html__( 'Donation Button', 'lifeline-donation' ),
				'base' => self::$shortcode,
				"icon" => LIFELINE_DONATION_URL . 'assets/images/icon.png',
				'category' => array(
					self::$category
				),
				'html_template' => self::get_template_path(),
				'description' => esc_html__( 'Donation button', 'lifeline-donation' ),
				'params' => [],
				'js_view' => 'VcButton3View',
				'custom_markup' => '{{title}}<div class="vc_btn3-container"><button class="vc_general vc_btn3 vc_btn3-size-sm vc_btn3-shape-{{ params.shape }} vc_btn3-style-{{ params.style }} vc_btn3-color-{{ params.color }}">{{{ params.title }}}</button></div>',
			];
		}

		if(function_exists('vc_pixel_icons')) {
			$vc_button = require vc_path_dir( 'CONFIG_DIR', 'buttons/shortcode-vc-btn.php' );
			$params = array_get($vc_button, 'params');
		} else {
			$params = [];
		}

		if( ! $params ) {
			return;
		}

		$params[] = array(
                "type"        => "autocomplete",
                "class"       => "",
                "heading"     => esc_html__('Post to collect Donation', 'lifeline-donation'),
                "param_name"  => "post_id",
                "description" => esc_html__('Choose the post to collect donation', 'lifeline-donation'),
                 'group'      => esc_html__( 'Donation Settings', 'lifeline-donation' ),
                'settings'	  => array(
                	'multiple'		 => false,
                	'sortable'		 => true,
                	'grouop'		 => true,
                	'min_length'	 => 1,
                	'display_inline' => true,
                ),
                'query_args'	        => array(
                	'post_type'		    => apply_filters( 'wpcommerce_product_post_type', array() ),
                	'posts_per_page'	=> 100,
                ),
                'dependency' => array(
                    "element" => "action2",
                    "value" => array("donate")
                ),
            );
		
		return array(
			'name' => esc_html__( 'Donation Button', 'lifeline-donation' ),
			'base' => self::$shortcode,
			"icon" => LIFELINE_DONATION_URL . 'assets/images/icon.png',
			'category' => array(
				self::$category
			),
			'html_template'	=> LIFELINE_DONATION_PATH . 'shortcodes/output/wi_donation_button2.php',
			'description' => esc_html__( 'Donation button', 'lifeline-donation' ),
			'params' => $params,
			'js_view' => 'VcButton3View',
			'custom_markup' => '{{title}}<div class="vc_btn3-container"><button class="vc_general vc_btn3 vc_btn3-size-sm vc_btn3-shape-{{ params.shape }} vc_btn3-style-{{ params.style }} vc_btn3-color-{{ params.color }}">{{{ params.title }}}</button></div>',
		);
	}
	

	/**
	 * @param $search_string
	 *
	 * @return array
	 */
	function field_search( $search_string, $field, $args ) {
		$query = $search_string;
		$data = array();
		$args = array(
			's' => $query,
			'post_type' => apply_filters( 'wpcommerce_product_post_type', array('cause', 'project') ),
		);
		$args['vc_search_by_title_only'] = true;
		$args['numberposts'] = - 1;
		if ( 0 === strlen( $args['s'] ) ) {
			unset( $args['s'] );
		}
		add_filter( 'posts_search', 'vc_search_by_title_only', 500, 2 );
		$posts = get_posts( $args );
		if ( is_array( $posts ) && ! empty( $posts ) ) {
			foreach ( $posts as $post ) {
				$data[] = array(
					'value' => $post->ID,
					'label' => $post->post_title,
					'group' => $post->post_type,
				);
			}
		}

		return $data;
	}

	/**
	 * @param $value
	 *
	 * @return array|bool
	 */
	function field_render( $value, $field, $args ) {
		$post = get_post( $value['value'] );

		return is_null( $post ) ? false : array(
			'label' => $post->post_title,
			'value' => $post->ID,
			'group' => $post->post_type,
		);
	}

}

Button2::init();