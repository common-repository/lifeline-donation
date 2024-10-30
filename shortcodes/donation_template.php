<?php
namespace LifelineDonation\Shortcodes;

use LifelineDonation\Shortcodes\Shortcodes;

class Donation_Template extends Shortcodes {

	static function init() {
		self::$shortcode = 'wi_donation_template';
		self::$vc_map = self::vc_map();
		parent::init();

		add_filter( 'vc_autocomplete_wi_donation_template_id_callback', array( __CLASS__, 'field_search' ), 10, 3 );
		add_filter( 'vc_autocomplete_wi_donation_template_id_render', array( __CLASS__, 'field_render' ), 10, 3 );
	}

	static function vc_map() {
		return array(
			'name' => esc_html__( 'Donation Template', 'lifeline-donation' ),
			'base' => self::$shortcode,
			'icon' => LIFELINE_DONATION_URL . 'assets/images/icon.png',
			'category' => self::$category,
			'html_template' => self::get_template_path(),
			'params' => array(
				array(
					'type' => 'autocomplete',
					'class' => '',
					'heading' => esc_html__( 'Post to collect Donation', 'lifeline-donation' ),
					'param_name' => 'id',
					'description' => esc_html__( 'Choose the post to collect donation', 'lifeline-donation' ),
					'query_args'    => array(
						'post_type'     => apply_filters( 'wpcommerce_product_post_type', array( 'cause', 'project' ) ),
						'posts_per_page'    => 200,
					),
				),
				array(
					'type'              => 'dropdown',
					'class'             => '',
					'heading'           => esc_html__( 'Select Layout Style', 'lifeline-donation' ),
					'param_name'        => 'style',
					'value'             => array(
						esc_html__( 'Style 1', 'lifeline-donation' )  => 'style1',
						esc_html__( 'Style 2', 'lifeline-donation' ) => 'style2',
						esc_html__( 'Style 3', 'lifeline-donation' ) => 'style3',
					),
					'description'       => esc_html__( 'Select layout style that you wants to use.', 'lifeline-donation' ),
				),
				array(
					'type'        => 'textfield',
					'class'       => '',
					'heading'     => esc_html__( 'Title', 'lifeline-donation' ),
					'param_name'  => 'title',
					'description' => esc_html__( 'Enter title to show', 'lifeline-donation' ),
				),

				array(
					'type' => 'textarea_html',
					'holder' => 'div',
					'class' => '',
					'heading' => esc_html__( 'Content', 'lifeline-donation' ),
					'param_name' => 'content', // Important: Only one textarea_html param per content element allowed and it should have "content" as a "param_name"
					'value' => __( '<p>I am test text block. Click edit button to change this text.</p>', 'lifeline-donation' ),
					'description' => __( 'Enter your content.', 'lifeline-donation' ),
					'content' => true,
					/*'dependency'  => array(
						'element'  => 'style',
						'value'    => 'style2',
					),*/
				),

			),

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

Donation_Template::init();
