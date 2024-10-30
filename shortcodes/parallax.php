<?php
namespace LifelineDonation\Shortcodes;

use LifelineDonation\Shortcodes\Shortcodes;

class Parallax extends Shortcodes
{
	static function init() {
		self::$shortcode = 'wi_donation_parallax';
		self::$vc_map = self::vc_map();
		parent::init();
		add_filter('vc_autocomplete_wi_donation_parallax_post_id_callback', array(__CLASS__, 'field_search'), 10, 3);
		add_filter('vc_autocomplete_wi_donation_parallax_post_id_callback', array(__CLASS__, 'field_search'), 10, 3);
		add_filter('vc_autocomplete_wi_donation_parallax_post_id2_callback', array(__CLASS__, 'field_search'), 10, 3);
		add_filter('vc_autocomplete_wi_donation_parallax_post_id2_callback', array(__CLASS__, 'field_search'), 10, 3);
	}

	static function vc_map() {
		return [
			"name" => esc_html__("Parallax Style 1", 'lifeline-donation'),
            "base" => self::$shortcode,
            "icon" => LIFELINE_DONATION_URL . 'assets/images/icon.png',
            "category" => self::$category,
            'html_template' => self::get_template_path(),
            "params" => array(
                array(
				    'type'          => 'attach_image',
    				'class'         => '',
    				'heading'       => esc_html__( 'Parallax Image', 'lifeline-donation' ),
    				'param_name'    => 'bg_image',
    				'description'   => esc_html__( 'Upload parallax image to show.', 'lifeline-donation' ),
    			),
    			array(
    				'type'       => 'textfield',
    				'heading'    => esc_html__( 'Title', 'lifeline-donation' ),
    				'param_name' => 'title',
    				'value'      => esc_html__( 'Enter main title to show.', 'lifeline-donation' ),
    				'value'      => esc_html__( 'How Volunteers of America helps assist homeless people.', 'lifeline-donation' ),
    			),
    			array(
    				'type'       => 'textarea',
    				'heading'    => esc_html__( 'Text', 'lifeline-donation' ),
    				'param_name' => 'text',
    				'value'      => esc_html__( 'Enter text to show.', 'lifeline-donation' ),
    			),
    			array( 
        			'type'              => 'checkbox',
        			'class'             => '',
        			'group'             => esc_html__( 'Button 1', 'lifeline-donation' ),
        			'param_name'        => 'button',
        			'value'             => array( 'Enable Button 1' => 'true' ),
        			'description'       => esc_html__( 'Enable to show button 1.', 'lifeline-donation' ),
        		),
                array(
    				'type'       => 'textfield',
    				'heading'    => esc_html__( 'Button Label', 'lifeline-donation' ),
    				'param_name' => 'btn_label',
    				'group'      => esc_html__( 'Button 1', 'lifeline-donation' ),
    				'value'      => esc_html__( 'start a campaign', 'lifeline-donation' ),
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
                    'group'       => esc_html__( 'Button 1', 'lifeline-donation' ),
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
                "type"              => "vc_link",
                "class"             => "",
                "heading"           => esc_html__('URL', 'lifeline-donation'),
                "param_name"        => "link",
                'group'             => esc_html__( 'Button 1', 'lifeline-donation' ),
                "description"       => esc_html__('Enter the link', 'lifeline-donation'),
                'dependency'        => array(
                    "element"       => "action",
                    "value"         => array("link_add")
                ),
            ),
            array(
                "type"        => "autocomplete",
                "class"       => "",
                "heading"     => esc_html__('Post to collect Donation', 'lifeline-donation'),
                "param_name"  => "post_id",
                'group'       => esc_html__( 'Button 1', 'lifeline-donation' ),
                "description" => esc_html__('Choose the post to collect donation', 'lifeline-donation'),
                'settings'	  => array(
                	'multiple'	    => false,
                	'sortable'		=> true,
                	'grouop'		=> true,
                	'min_length'	=> 1,
                	'display_inline'=> true,
                ),
                'query_args'	        => array(
                	'post_type'		    => apply_filters( 'wpcommerce_product_post_type', array() ),
                	'posts_per_page'	=> 100,
                ),
                'dependency'  => array(
                    "element" => "action",
                    "value"   => array("donate")
                ),
            ),	
		
			
			array( 
    			'type'              => 'checkbox',
    			'class'             => '',
    			'group'             => esc_html__( 'Button 2', 'lifeline-donation' ),
    			'param_name'        => 'button2',
    			'value'             => array( 'Enable Button 2' => 'true' ),
    			'description'       => esc_html__( 'Enable to show button 2.', 'lifeline-donation' ),
    		),
            array(
				'type'       => 'textfield',
				'heading'    => esc_html__( 'Button Label', 'lifeline-donation' ),
				'param_name' => 'btn2_label',
				'group'      => esc_html__( 'Button 2', 'lifeline-donation' ),
				'value'      => esc_html__( 'Enter button label to show.', 'lifeline-donation' ),
				'value'      => esc_html__( 'or donate instead!', 'lifeline-donation' ),
				 'dependency'  => array(
					'element'  => 'button2',
					'value'    => 'true',
				),
			),
			array(
                "type"        => "dropdown",
                "class"       => "",
                "heading"     => esc_html__('Action', 'lifeline-donation'),
                "param_name"  => "action2",
                'group'       => esc_html__( 'Button 2', 'lifeline-donation' ),
                "description" => esc_html__('Choose whether to show donation popup or link to a page', 'lifeline-donation'),
                'value'		=> array(
                	esc_html__( 'Show Donation Popup', 'lifeline-donation' ) => 'donate',
                	esc_html__( 'Redirect to a Link', 'lifeline-donation' )  => 'link',
                ),
                'dependency'  => array(
					'element' => 'button2',
					'value'   => 'true',
				),
            ),
            array(
                "type"          => "vc_link",
                "class"         => "",
                "heading"       => esc_html__('URL', 'lifeline-donation'),
                "param_name"    => "link2",
                "description"   => esc_html__('Enter the link', 'lifeline-donation'),
                'group'         => esc_html__( 'Button 2', 'lifeline-donation' ),
                'dependency'    => array(
                    "element"  => "action2",
                    "value"    => array("link")
                ),
            ),
            array(
                "type"        => "autocomplete",
                "class"       => "",
                "heading"     => esc_html__('Post to collect Donation', 'lifeline-donation'),
                "param_name"  => "post_id2",
                "description" => esc_html__('Choose the post to collect donation', 'lifeline-donation'),
                 'group'      => esc_html__( 'Button 2', 'lifeline-donation' ),
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

Parallax::init();