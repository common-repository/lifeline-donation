<?php
namespace LifelineDonation\Shortcodes;

use LifelineDonation\Shortcodes\Shortcodes;

class Parallax2 extends Shortcodes
{
	static function init() {
		self::$shortcode = 'wi_donation_parallax2';
		self::$vc_map = self::vc_map();
		parent::init();
		add_filter('vc_autocomplete_wi_donation_parallax2_post_id_callback', array(__CLASS__, 'field_search'), 10, 3);
		add_filter('vc_autocomplete_wi_donation_parallax2_post_id_callback', array(__CLASS__, 'field_search'), 10, 3);
	}

	static function vc_map() {
		return [
			"name" => esc_html__("Parallax Style 2", 'lifeline-donation'),
            "base" => self::$shortcode,
            "icon" => LIFELINE_DONATION_URL . 'assets/images/icon.png',
            "category" => self::$category,
            'html_template' => self::get_template_path(),
            "params" => array(
        

                array(
                    "type" => "textfield",
                    "class" => "",
                    "heading" => esc_html__("Title", 'lifeline-donation'),
                    "param_name" => "title",
                    "description" => esc_html__("Enter the title to show in about us section", 'lifeline-donation')
                ),
                array(
                    "type" => "textfield",
                    "class" => "",
                    "heading" => esc_html__("Sub Title", 'lifeline-donation'),
                    "param_name" => "sub_title",
                    "description" => esc_html__("Enter the sub title to show in about us section", 'lifeline-donation')
                ),
                	array( 
    			'type'              => 'checkbox',
    			'class'             => '',
    			'group'             => esc_html__( 'Button', 'lifeline-donation' ),
    			'param_name'        => 'button',
    			'value'             => array( 'Enable Button' => 'true' ),
    			'description'       => esc_html__( 'Enable to show button.', 'lifeline-donation' ),
    		),
            array(
				'type'       => 'textfield',
				'heading'    => esc_html__( 'Button Label', 'lifeline-donation' ),
				'param_name' => 'btn_label',
				'group'      => esc_html__( 'Button', 'lifeline-donation' ),
				'value'      => esc_html__( 'Donate Us', 'lifeline-donation' ),
				 'dependency'  => array(
					'element'  => 'button',
					'value'    => 'true',
				),
			),
			array(
                "type"        => "dropdown",
                "class"       => "",
                "heading"     => esc_html__('Action', 'lifeline-donation'),
                "param_name"  => "action",
                'group'       => esc_html__( 'Button', 'lifeline-donation' ),
                "description" => esc_html__('Choose whether to show donation popup or link to a page', 'lifeline-donation'),
                'value'		  => array(
                	esc_html__( 'Show Donation Popup', 'lifeline-donation' ) => 'donate',
                	esc_html__( 'Redirect to a Link', 'lifeline-donation' ) => 'link_add',
                ),
                'dependency'  => array(
					'element' => 'button',
					'value'   => 'true',
				),
            ),
            array(
                "type"        => "vc_link",
                "class"       => "",
                "heading"     => esc_html__('URL', 'lifeline-donation'),
                "param_name"  => "link",
                'group'       => esc_html__( 'Button', 'lifeline-donation' ),
                "description" => esc_html__('Enter the link', 'lifeline-donation'),
                'dependency'  => array(
                    "element" => "action",
                    "value"   => array("link_add")
                ),
            ),
            array(
                "type"        => "autocomplete",
                "class"       => "",
                "heading"     => esc_html__('Post to collect Donation', 'lifeline-donation'),
                "param_name"  => "post_id",
                'group'       => esc_html__( 'Button', 'lifeline-donation' ),
                "description" => esc_html__('Choose the post to collect donation', 'lifeline-donation'),
                'settings'	  => array(
                	'multiple'		 => false,
                	'sortable'		 => true,
                	'grouop'		 => true,
                	'min_length'	 => 1,
                	'display_inline' => true,
                ),
                'query_args'	     => array(
                	'post_type'		 => apply_filters( 'wpcommerce_product_post_type', array() ),
                	'posts_per_page' => 100,
                ),
                'dependency'  => array(
                    "element" => "action",
                    "value"   => array("donate")
                ),
            ),	
	

	
            )
			
		];
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
			'post_type' => apply_filters( 'wpcommerce_product_post_type', array() ),
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
}

Parallax2::init();