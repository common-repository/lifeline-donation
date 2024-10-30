<?php

use WebinaneCommerce\Fields\Media;
use WebinaneCommerce\Fields\Number;
use WebinaneCommerce\Fields\Radio;
use WebinaneCommerce\Fields\Select;
use WebinaneCommerce\Fields\Switcher;
use WebinaneCommerce\Fields\Text;
use WebinaneCommerce\Fields\Textarea;
$style1 = 'https://plugins.webinane.com/lifeline-donation/donation-page/';
$style2 = 'https://plugins.webinane.com/lifeline-donation/donation-page-style-2/';
$style3 = 'https://plugins.webinane.com/lifeline-donation/donation-page-style-3-2/';
return

	array(
		'title'			=> esc_html__( 'General Popup', 'lifeline-donation' ),
		'icon'			=> 'fa fa-gift',
		'id'			=> 'donation_genera_button',
		// 'heading'		=> esc_html__('Donation Button Settings', 'lifeline-donation'),
		'fields'		=> apply_filters( 'webinane_settings_donation_general_popup', array(
			Select::make(
				esc_html__( 'Select General Donation Type', 'lifeline-donation' ),
				'donation_general_type'
			)->setOptions(array(
				'donation_popup_box'     => esc_html__( 'Popup Box', 'lifeline-donation' ),
				'donation_page_template' => esc_html__( 'Page Template', 'lifeline-donation' ),
				'external_link'          => esc_html__( 'External Link', 'lifeline-donation' ),
			))
			->default('donation_popup_box')
			->setHelp(esc_html__( 'Donation type for general donation button like "button in menu" or button you place using shortcode', 'lifeline-donation' )),
			
			Select::make(
				esc_html__( 'Donation Page', 'lifeline-donation' ),
				'donation_shortcode_page'
			)->setOptions(wpcm_posts_data( array( 'post_type' => ['page'], 'posts_per_page' => 100 ) ))
			->setHelp(esc_html__( 'Page where you have placed donation shortcode. So when user visits the page, it shows the donation form instead of popup', 'lifeline-donation' ))
			->setDependency(
				array('key' => 'donation_general_type', 'value' => 'donation_page_template', 'compare' => '=')
			),

			Text::make(
				esc_html__( 'External Link', 'lifeline-donation' ),
				'donation_button_linkGeneral'
			)->setHelp(esc_html__( 'Enter a valid external link including http or https, only works if donation type is external link', 'lifeline-donation' ))
			->setDependency(
				array('key' => 'donation_general_type', 'value' => 'external_link', 'compare' => '=')
			),

			Radio::make(
				esc_html__( 'Select Donation Popup Style', 'lifeline-donation' ),
				'donation_popup_style'
			)->setOptions(array(
					'style1'    => esc_html__( 'Style 1', 'lifeline-donation' ),
					'style2'    => esc_html__( 'Style 2', 'lifeline-donation' ),
					'style3'    => esc_html__( 'Style 3', 'lifeline-donation' ),
			))
			->setHelp(sprintf(__('View in action <a href="%s" target="_blank">Style 1</a>, <a href="%s" target="_blank">Style 2</a>, <a href="%s" target="_blank">Style 3</a>', 'lifeline-donation'), $style1, $style2, $style3))
			->setDependency(
				array('key' => 'donation_general_type', 'value' => 'donation_popup_box', 'compare' => '=')
				
			),

			Select::make(
				esc_html__( 'Post or Page for General Donation', 'lifeline-donation' ),
				'donation_dummy_page_select'
			)->setOptions(wpcm_posts_data( array( 'post_type' => ['page', 'cause', 'project'], 'posts_per_page' => 100 ) ))
			->setHelp(esc_html__( 'It is reuqired. Select the project, cause or page you want to store the collected donation in. General donations are being stored in specified page or custom post type', 'lifeline-donation' ))
			->setDependency(
				array('key' => 'donation_general_type', 'value' => 'external_link', 'compare' => '!=')
				
			)->withMeta(['filterable' => true]),

			Number::make(
				esc_html__( 'General Needed Amount', 'lifeline-donation' ),
				'donation_general_amount'
			)->setHelp(esc_html__( 'Enter the amount for donation box', 'lifeline-donation' ))
			->setMax(100000000)
			->setDependency(
				array('key' => 'donation_general_type', 'value' => 'donation_popup_box', 'compare' => '=')
				
			),

			Media::make(
				esc_html__( 'Background Image', 'lifeline-donation' ),
				'donation_general_bg'
			)->setHelp(esc_html__( 'Choose the background image to show in general donation form', 'lifeline-donation' ))
			->setAddText(esc_html__( 'Add Background', 'lifeline-donation' ))
			->setUpdateText(esc_html__( 'Change Background', 'lifeline-donation' ))
			->setDependency(
				array('key' => 'donation_general_type', 'value' => 'donation_popup_box', 'compare' => '=')
			),

			Text::make(
				esc_html__( 'Donation Popup Title', 'lifeline-donation' ),
				'donation_genral_title'
			)->setHelp(esc_html__( 'Enter the title to show on General donation form', 'lifeline-donation' ))
			->setDependency(
				array('key' => 'donation_general_type', 'value' => 'donation_popup_box', 'compare' => '=')
			),
			Text::make(
				esc_html__( 'Donation Popup Sub Title', 'lifeline-donation' ),
				'donation_genral_subtitle'
			)->setHelp(esc_html__( 'Enter the sub title to show on General donation form', 'lifeline-donation' ))
			->setDependency(
				array('key' => 'donation_general_type', 'value' => 'donation_popup_box', 'compare' => '=')
			),
			Textarea::make(
				esc_html__( 'Donation Popup Description', 'lifeline-donation' ),
				'donation_popup_text'
			)->setHelp(esc_html__( 'Enter the description to show on General donation form', 'lifeline-donation' ))
			->setDependency(
				array('key' => 'donation_general_type', 'value' => 'donation_popup_box', 'compare' => '=')
			)->withMeta(array( 'rows' => 5)),
			

			Switcher::make(
				esc_html__( 'Show Donation progress bar in Popup', 'lifeline-donation' ),
				'donation_calculation_bar'
			)->setHelp(esc_html__( 'Whether to show donation calculation bar in popup', 'lifeline-donation' ))
			->setDependency(
				array('key' => 'donation_general_type', 'value' => 'external_link', 'compare' => '!=')
			)->withMeta(array(
				'active-text' => esc_html__( 'YES', 'lifeline-donation' ),
				'inactive-text' => esc_html__( 'NO', 'lifeline-donation' ),
			))->default(true),
			
		)
	)

);