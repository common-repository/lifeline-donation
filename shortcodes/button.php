<?php
namespace LifelineDonation\Shortcodes;

use LifelineDonation\Shortcodes\Shortcodes;

class Button extends Shortcodes
{

	static function init() {
		self::$shortcode = 'wi_donation_button';
		self::$vc_map = self::vc_map();
		parent::init();
		add_filter('vc_autocomplete_wi_donation_button_post_id_callback', array(__CLASS__, 'field_search'), 10, 3);
		add_filter('vc_autocomplete_wi_donation_button_post_id_render', array(__CLASS__, 'field_render'), 10, 3);
		
	}

	static function vc_map() {
		$pixel_icons = function_exists('vc_pixel_icons') ? vc_pixel_icons() : array();
		if(function_exists('vc_path_dir') ) {
			require_once vc_path_dir( 'CONFIG_DIR', 'content/vc-icon-element.php' );
		}
		if( function_exists('vc_map_integrate_shortcode')) {
			$icons_params = vc_map_integrate_shortcode( vc_icon_element_params(), 'i_', '', array(
				'include_only_regex' => '/^(type|icon_\w*)/',
				// we need only type, icon_fontawesome, icon_blabla..., NOT color and etc
			), array(
				'element' => 'add_icon',
				'value' => 'true',
			) );
		} else {
			$icons_params = array();
		}
		// populate integrated vc_icons params.
		if ( is_array( $icons_params ) && ! empty( $icons_params ) ) {
			foreach ( $icons_params as $key => $param ) {
				if ( is_array( $param ) && ! empty( $param ) ) {
					if ( 'i_type' === $param['param_name'] ) {
						// append pixelicons to dropdown
						$icons_params[ $key ]['value'][ esc_html__( 'Pixel', 'lifeline-donation' ) ] = 'pixelicons';
					}
					if ( isset( $param['admin_label'] ) ) {
						// remove admin label
						unset( $icons_params[ $key ]['admin_label'] );
					}
				}
			}
		}
		$color_dashed = array(
			// Btn1 Colors
			esc_html__( 'Classic Grey', 'lifeline-donation' ) => 'default',
			esc_html__( 'Classic Blue', 'lifeline-donation' ) => 'primary',
			esc_html__( 'Classic Turquoise', 'lifeline-donation' ) => 'info',
			esc_html__( 'Classic Green', 'lifeline-donation' ) => 'success',
			esc_html__( 'Classic Orange', 'lifeline-donation' ) => 'warning',
			esc_html__( 'Classic Red', 'lifeline-donation' ) => 'danger',
			esc_html__( 'Classic Black', 'lifeline-donation' ) => 'inverse',
			// + Btn2 Colors (default color set)
		);
		if( function_exists('vc_get_shared') ) {
			$color_value = array_merge( $color_dashed, vc_get_shared( 'colors-dashed' ) );
		} else {
			$color_value = $color_dashed;
		}
		$params = array_merge( array(
		    array(
				'type'          => 'attach_image',
				'class'         => '',
				'heading'       => esc_html__( 'parallax Image', 'lifeline-donation' ),
				'param_name'    => 'bg_image',
				'description'   => esc_html__( 'Upload parallax image to show.', 'lifeline-donation' ),
			),
			array(
				'type'        => 'colorpicker',
				'heading'     => esc_html__( 'Parallax Layer Color', 'lifeline-donation' ),
				'param_name'  => 'parallax_layer_color',
				'description' => esc_html__( 'Select parallax image layer color.', 'lifeline-donation' ),
				'value'       => '#00204e',
			),
		    array(
				'type'              => 'dropdown',
				'class'             => '',
				'heading'           => esc_html__( 'Select Icon Type', 'lifeline-donation' ),
				'param_name'        => 'icon_type',
				'value'             => array(
					esc_html__( 'Font Icon', 'lifeline-donation' )  => 'fontawesome', 
					esc_html__( 'Image icon', 'lifeline-donation' ) => 'image',          
				),
				'description'       => esc_html__( 'Select icon type that you wants to use.', 'lifeline-donation' )
			),
			array(
				'type'              => 'iconpicker',
				'class'             => '',
				'heading'           => esc_html__( 'Font Awesome Icon', 'lifeline-donation' ),
				'param_name'        => 'campaign_icon',
				'description'       => esc_html__( 'Select font awesome icon that you wants to show.', 'lifeline-donation' ),
				'dependency'        => array(
					'element' => 'icon_type',
					'value'   => array( 'fontawesome' ),
				),
			),
			array(
				'type'          => 'attach_image',
				'class'         => '',
				'heading'       => esc_html__( 'Image Icon', 'lifeline-donation' ),
				'param_name'    => 'icon_image',
				'description'   => esc_html__( 'Upload image. icon to show.', 'lifeline-donation' ),
				'dependency'    => array(
					'element' => 'icon_type',
					'value'   => array( 'image' ),
				),
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
                "type" => "dropdown",
                "class" => "",
                "heading" => esc_html__('Action', 'lifeline-donation'),
                "param_name" => "action",
                'group'             => esc_html__( 'Button 1', 'lifeline-donation' ),
                "description" => esc_html__('Choose whether to show donation popup or link to a page', 'lifeline-donation'),
                'value'		=> array(
                	esc_html__( 'Show Donation Popup', 'lifeline-donation' ) => 'donate',
                	esc_html__( 'Redirect to a Link', 'lifeline-donation' ) => 'link_add',
                ),
                'dependency'  => array(
					'element' => 'button',
					'value'   => 'true',
				),
            ),
            array(
                "type" => "vc_link",
                "class" => "",
                "heading" => esc_html__('URL', 'lifeline-donation'),
                "param_name" => "link",
                'group'             => esc_html__( 'Button 1', 'lifeline-donation' ),
                "description" => esc_html__('Enter the link', 'lifeline-donation'),
                'group'		=> esc_html__('Link', 'lifeline-donation'),
                'dependency' => array(
                    "element" => "action",
                    "value" => array("link")
                ),
            ),
            array(
                "type" => "autocomplete",
                "class" => "",
                "heading" => esc_html__('Post to collect Donation', 'lifeline-donation'),
                "param_name" => "post_id",
                'group'             => esc_html__( 'Button 1', 'lifeline-donation' ),
                "description" => esc_html__('Choose the post to collect donation', 'lifeline-donation'),
                'group'		=> esc_html__('Link', 'lifeline-donation'),
                'settings'	=> array(
                	'multiple'		=> false,
                	'sortable'		=> true,
                	'group'		=> true,
                	'min_length'	=> 1,
                	'display_inline'	=> true,
                ),
                'query_args'	=> array(
                	'post_type'		=> apply_filters( 'wpcommerce_product_post_type', array() ),
                	'posts_per_page'	=> 100,
                ),
                'dependency' => array(
                    "element" => "action",
                    "value" => array("donate")
                ),
            ),	
			array(
				'type'        => 'colorpicker',
				'heading'     => esc_html__( 'Button Background Color', 'lifeline-donation' ),
				'param_name'  => 'button1_bg_color',
				'group'             => esc_html__( 'Button 1', 'lifeline-donation' ),
				'description' => esc_html__( 'Select button background color.', 'lifeline-donation' ),
				'value'       => '#e5951b',
				'dependency'  => array(
					'element' => 'button',
					'value'   => 'true',
				),
			),
			array(
				'type'        => 'colorpicker',
				'heading'     => esc_html__( 'Button Hover Background Color', 'lifeline-donation' ),
				'param_name'  => 'button1_bg_hover',
				'group'             => esc_html__( 'Button 1', 'lifeline-donation' ),
				'description' => esc_html__( 'Select button background color on hover.', 'lifeline-donation' ),
				'value'       => '#000000',
				'dependency'  => array(
					'element' => 'button',
					'value'   => 'true',
				),
			),
			array(
				'type'        => 'colorpicker',
				'heading'     => esc_html__( 'Button Color', 'lifeline-donation' ),
				'param_name'  => 'button1_color',
				'group'       => esc_html__( 'Button 1', 'lifeline-donation' ),
				'description' => esc_html__( 'Select button color.', 'lifeline-donation' ),
				'value'       => '#ffffff',
				'dependency'  => array(
					'element' => 'button',
					'value'   => 'true',
				),
			),
			array(
				'type'        => 'colorpicker',
				'heading'     => esc_html__( 'Button Color on Hover', 'lifeline-donation' ),
				'param_name'  => 'button1_bg_hover',
				'group'       => esc_html__( 'Button 1', 'lifeline-donation' ),
				'description' => esc_html__( 'Select button color on hover.', 'lifeline-donation' ),
				'value'       => '#fff',
				'dependency'  => array(
					'element' => 'button',
					'value'   => 'true',
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
                	esc_html__( 'Default', 'lifeline-donation' ) => '',
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
		
			array(
				'type'        => 'colorpicker',
				'heading'     => esc_html__( 'Button Color', 'lifeline-donation' ),
				'param_name'  => 'button2_color',
				'group'         => esc_html__( 'Button 2', 'lifeline-donation' ),
				'description' => esc_html__( 'Select button 2 color.', 'lifeline-donation' ),
				'value'       => '#ffffff',
				'dependency'  => array(
					'element' => 'button2',
					'value'   => 'true',
				),
			),
		
		));

		/**
		 * @class WPBakeryShortCode_Vc_Btn
		 */
		return array(
			'name' => esc_html__( 'Parallax Donation', 'lifeline-donation' ),
			'base' => self::$shortcode,
			'icon' => 'icon-wpb-ui-button',
			'category' => array(
				self::$category
			),
			'description' => esc_html__( 'Parallax donation', 'lifeline-donation' ),
			'params' => $params,
			'html_template' => self::get_template_path(),
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

Button::init();