<?php

use WebinaneCommerce\Fields\Media;
use WebinaneCommerce\Fields\Select;
use WebinaneCommerce\Fields\Text;
use WebinaneCommerce\Fields\Textarea;

return

	array(
		'title'			=> esc_html__( 'Post Type Popup', 'lifeline-donation' ),
		'icon'			=> 'fa fa-gift',
		'id'			=> 'donation_post_type_popup',
		'fields'		=> apply_filters( 'webinane_settings_donation_post_type_popup', array(
			
			Select::make(
				esc_html__( 'Select Donation Type', 'lifeline-donation' ),
				'donation_Cpost_type'
			)->setOptions(array(
				'donation_popup_box'     => esc_html__( 'Popup Box', 'lifeline-donation' ),
				'donation_page_template' => esc_html__( 'Page Template', 'lifeline-donation' ),
				'external_link'          => esc_html__( 'External Link', 'lifeline-donation' ),
			))
			->default('donation_popup_box')
			->setHelp(esc_html__( 'Donation type for custom posts donation button like project, cuases or any custom post that supports donation', 'lifeline-donation' )),
			
			// Donation page for page template.
			Select::make(
				esc_html__( 'Donation Page', 'lifeline-donation' ),
				'donation_Cpost_select'
			)->setOptions(wpcm_posts_data( array( 'post_type' => ['page'], 'posts_per_page' => 100 ) ))
			->setHelp(esc_html__( 'Page where you have placed donation shortcode. So when user visits the page, it shows the donation form instead of popup. Only works if you have select "Page Template" in "Donation Type"', 'lifeline-donation' ))
			->setDependency(
				array('key' => 'donation_Cpost_type', 'value' => 'donation_page_template', 'compare' => '=')
			),

			// Donation button URL if external link is selected.
			Text::make(
				esc_html__( 'Donation Button URL', 'lifeline-donation' ),
				'donation_Cpost_linkGeneral'
			)
			->setHelp(esc_html__( 'Enter the donation button URL for external link', 'lifeline-donation' ))
			->setDependency(
				array('key' => 'donation_Cpost_type', 'value' => 'external_link', 'compare' => '=')
			),

			// Background image to show on the donation form.
			Media::make(
				esc_html__( 'Background Image', 'lifeline-donation' ),
				'donation_Cpost_bg'
			)->setHelp(esc_html__( 'Choose the background image to show in donation form', 'lifeline-donation' ))
			->setAddText(esc_html__( 'Add Background', 'lifeline-donation' ))
			->setUpdateText(esc_html__( 'Change Background', 'lifeline-donation' ))
			->setDependency(
				array('key' => 'donation_Cpost_type', 'value' => 'external_link', 'compare' => '!=')
			),

			// Donation form title.
			Text::make(
				esc_html__( 'Donation Form Title', 'lifeline-donation' ),
				'donation_Cpost_title'
			)->setHelp(esc_html__( 'Enter the title for donation popup box', 'lifeline-donation' ))
			->setDependency(
				array('key' => 'donation_Cpost_type', 'value' => 'donation_popup_box', 'compare' => '=')
			),

			// Donation form sub title
			Text::make(
				esc_html__( 'Donation Form Sub Title', 'lifeline-donation' ),
				'donation_Cpost_subtitle'
			)->setHelp(esc_html__( 'Enter the sub title for donation popup box', 'lifeline-donation' ))
			->setDependency(
				array('key' => 'donation_Cpost_type', 'value' => 'donation_popup_box', 'compare' => '=')
			),

			// Donation form sub title
			Textarea::make(
				esc_html__( 'Donation Form Description', 'lifeline-donation' ),
				'donation_Cpost_text'
			)
			->withMeta(['rows' => 5])
			->setHelp(esc_html__( 'Enter the description to show on donation form', 'lifeline-donation' ))
			->setDependency(
				array('key' => 'donation_Cpost_type', 'value' => 'donation_popup_box', 'compare' => '=')
			),
		)
	)

);