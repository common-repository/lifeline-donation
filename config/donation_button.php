<?php
return

	array(
		'title'			=> esc_html__( 'Donation Button', 'lifeline-donation' ),
		'icon'			=> 'fa fa-gift',
		'id'			=> 'donation_button',
		// 'heading'		=> esc_html__('Donation Button Settings', 'lifeline-donation'),
		'fields'		=> apply_filters( 'webinane_settings_donation_button', array(
			array(
				'type'	=> 'el-heading',
				'props'	=> ['content' => esc_html__( 'General Donation Settings', 'lifeline-donation' )]
			),
			array(
				'label'          => esc_html__( 'Select General Donation Type', 'lifeline-donation' ),
				'id'            => 'donation_general_type',
				'type'          => 'el-select',
				// 'main_heading'	=> esc_html__( 'General Button Type', 'lifeline-donation' ),
				'options'       => array(
					'donation_popup_box'     => esc_html__( 'Popup Box', 'lifeline-donation' ),
					'donation_page_template' => esc_html__( 'Page Template', 'lifeline-donation' ),
					'external_link'          => esc_html__( 'External Link', 'lifeline-donation' ),
				),
				'default'       => 'donation_popup_box',
				// 'main_heading' => esc_html__( 'Lifeline Donation Options', 'lifeline-donation' ),
			),
			
			array(
				'label'       => esc_html__( 'Donation Page', 'lifeline-donation' ),
				'help'       => esc_html__( 'Page where you have placed donation shortcode. So when user visits the page, it shows the donation form instead of popup', 'lifeline-donation' ),
				'id'         => 'donation_shortcode_page',
				'type'       => 'el-select',
				'options'    => wpcm_posts_data( array( 'post_type' => 'page' ) ),
				'col'		=> 12,
				'vshow' => array(
					array('key' => 'donation_general_type', 'value' => 'donation_page_template', 'compare' => '=')
				)
			),
			array(
				'label'       => esc_html__( 'External Link', 'lifeline-donation' ),
				'help'       => esc_html__( 'Enter the external Link to redirect the user to. Must be starts with https:// or http://', 'lifeline-donation' ),
				'id'         => 'donation_external_link',
				'type'       => 'el-input',
				'col'		=> 12,
				'vshow' => array(
					array('key' => 'donation_general_type', 'value' => 'external_link', 'compare' => '=')
				)
			),
		)
	)

);