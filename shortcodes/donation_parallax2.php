<?php
namespace LifelineDonation\Shortcodes;

use LifelineDonation\Shortcodes\Shortcodes;

class Parallax2 extends Shortcodes
{
	static function init() {
		self::$shortcode = 'wi_donation_parallax2';
		self::$vc_map = self::vc_map();
		parent::init();
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
    				'type'        => 'colorpicker',
    				'heading'     => esc_html__( 'Background Color', 'lifeline-donation' ),
    				'param_name'  => 'bg_color',
    				'description' => esc_html__( 'Select background color.', 'lifeline-donation' ),
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
                "type" => "dropdown",
                "class" => "",
                "heading" => esc_html__('Action', 'lifeline-donation'),
                "param_name" => "action",
                'group'             => esc_html__( 'Button', 'lifeline-donation' ),
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
                'group'             => esc_html__( 'Button', 'lifeline-donation' ),
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
                'group'             => esc_html__( 'Button', 'lifeline-donation' ),
                "description" => esc_html__('Choose the post to collect donation', 'lifeline-donation'),
                'group'		=> esc_html__('Link', 'lifeline-donation'),
                'settings'	=> array(
                	'multiple'		=> false,
                	'sortable'		=> true,
                	'grouop'		=> true,
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
				'value'       => '#cf2329',
				'dependency'  => array(
					'element' => 'button',
					'value'   => 'true',
				),
			),
			array(
				'type'        => 'colorpicker',
				'heading'     => esc_html__( 'Button Color', 'lifeline-donation' ),
				'param_name'  => 'button_color',
				'group'       => esc_html__( 'Button', 'lifeline-donation' ),
				'description' => esc_html__( 'Select button color.', 'lifeline-donation' ),
				'value'       => '#fff',
				'dependency'  => array(
					'element' => 'button',
					'value'   => 'true',
				),
			),
	
            )
			
		];
	}
}

Parallax_Simple::init();