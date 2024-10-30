<?php

use WebinaneCommerce\Fields\MultiText;
use WebinaneCommerce\Fields\Select;
use WebinaneCommerce\Fields\Switcher;
return array(
	'id'	=> 'general_donation_settings',
	'title'	=> esc_html__('General', 'lifeline-donation'),
	'heading'	=> esc_html__('Donation General Settings', 'lifeline-donation'),
	'fields'		=> apply_filters( 'webinane_settings_donation_settings', array(
		
		Switcher::make(
			esc_html__( 'Enable Plugin Style', 'lifeline-donation' ),
			'donation_enable_plugin_css'
		)->setHelp(esc_html__( 'Enable to apply plugin styles', 'lifeline-donation' ))
		->withMeta(array(
			'active-text' => esc_html__( 'YES', 'lifeline-donation' ),
			'inactive-text' => esc_html__( 'NO', 'lifeline-donation' ),
		))->default(true),
		
		// Enable causes.
		Switcher::make(
			esc_html__( 'Enable Causes', 'lifeline-donation' ),
			'donation_causes_status'
		)->setHelp(esc_html__( 'Enable to collect donation on causes (custom post type)', 'lifeline-donation' ))
		->withMeta(array(
			'active-text' => esc_html__( 'YES', 'lifeline-donation' ),
			'inactive-text' => esc_html__( 'NO', 'lifeline-donation' ),
		))->default(true),
		
		// Enable projects.
		Switcher::make(
			esc_html__( 'Enable Projects', 'lifeline-donation' ),
			'donation_projects_status'
		)->setHelp(esc_html__( 'Enable to collect donation on projects (custom post type)', 'lifeline-donation' ))
		->withMeta(array(
			'active-text' => esc_html__( 'YES', 'lifeline-donation' ),
			'inactive-text' => esc_html__( 'NO', 'lifeline-donation' ),
		))->default(true),
		

		// Enable projects.
		Switcher::make(
			esc_html__( 'Show Currency Selector', 'lifeline-donation' ),
			'donation_multicurrency'
		)->setHelp(esc_html__( 'Allow donors to select currency on donation form', 'lifeline-donation' ))
		->withMeta(array(
			'active-text' => esc_html__( 'YES', 'lifeline-donation' ),
			'inactive-text' => esc_html__( 'NO', 'lifeline-donation' ),
		)),
		
		// Enable multi currency.
		Select::make(
			esc_html__( 'Choose Currencies to show in Donation Popup', 'lifeline-donation' ),
			'selective_currency'
		)->setOptions(wpcm_currency_assos_data())
		->setHelp(esc_html__( 'Choose currency to show as selective on donation popup', 'lifeline-donation' ))
		->multiple()
		->setDependency(array('key' => 'donation_multicurrency', 'value' => true, 'compare' => '='))
		->withMeta(['filterable' => true]),


		// Pre Defined Donation Amount
		Switcher::make(
			esc_html__( 'Pre Defined Donation Amount', 'lifeline-donation' ),
			'donation_predefined_amounts'
		)->setHelp(esc_html__( 'Enable pre defined donations amounts', 'lifeline-donation' ))
		->withMeta(array(
			'active-text' => esc_html__( 'YES', 'lifeline-donation' ),
			'inactive-text' => esc_html__( 'NO', 'lifeline-donation' ),
		)),

		// Donation Amounts
		MultiText::make(
			esc_html__( 'Donation Amounts', 'lifeline-donation' ),
			'donation_predefined_amounts_list'
		)->setHelp(esc_html__( 'Enter the donation amounts', 'lifeline-donation' ))
		->setDependency(array('key' => 'donation_predefined_amounts', 'value' => true, 'compare' => '='))
		->withMeta(array(
			'active-text' => esc_html__( 'YES', 'lifeline-donation' ),
			'inactive-text' => esc_html__( 'NO', 'lifeline-donation' ),
		)),

		// Custom Donation Amount
		Switcher::make(
			esc_html__( 'Custom Donation Amount', 'lifeline-donation' ),
			'donation_custom_amount'
		)->setHelp(esc_html__( 'Enable custom donations amount', 'lifeline-donation' ))
		->withMeta(array(
			'active-text' => esc_html__( 'YES', 'lifeline-donation' ),
			'inactive-text' => esc_html__( 'NO', 'lifeline-donation' ),
		)),

		// Enable recurring payments
		Switcher::make(
			esc_html__( 'Enable recurring payments', 'lifeline-donation' ),
			'donation_recurring_payments'
		)->setHelp(esc_html__( 'Enable recurring payments', 'lifeline-donation' ))
		->withMeta(array(
			'active-text' => esc_html__( 'YES', 'lifeline-donation' ),
			'inactive-text' => esc_html__( 'NO', 'lifeline-donation' ),
		)),
		
		
		// Enable custom dropdowns
		Switcher::make(
			esc_html__( 'Enable Custom Dropdown', 'lifeline-donation' ),
			'enable_custom_dropdown'
		)->setHelp(esc_html__( 'Enable to show custom dropdown in donation form.', 'lifeline-donation' ))
		->withMeta(array(
			'active-text' => esc_html__( 'YES', 'lifeline-donation' ),
			'inactive-text' => esc_html__( 'NO', 'lifeline-donation' ),
		)),
		
		
		// Dropdown Options
		MultiText::make(
			esc_html__( 'Dropdown Options', 'lifeline-donation' ),
			'donation_custom_dropdown'
		)->setHelp(esc_html__( 'Enable custom donations dropdown options', 'lifeline-donation' ))
		->setDependency(array('key' => 'enable_custom_dropdown', 'value' => true, 'compare' => '=')),
		
	))
);