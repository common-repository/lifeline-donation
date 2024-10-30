<?php
use WebinaneCommerce\Fields\Country;
use WebinaneCommerce\Fields\Media;
use WebinaneCommerce\Fields\Text;


return array(

	array(
		'title'			=> esc_html__( 'Personal Profile', 'lifeline-donation' ),
		'icon'			=> 'fa fa-user-alt',
		'id'			=> 'profile_settings',
		'component'		=> 'myaccount-profile',
		'fields'		=> apply_filters( 'webinane_frontend_my_account_profile', array(
			Media::make(esc_html__('Profile Image', 'lifeline-donation'), 'avatar')
				->setAddText(esc_html__( 'Add Avatar', 'lifeline-donation' ))
				->setUpdateText(esc_html__( 'Change Avatar', 'lifeline-donation' ))
				->setHelp(esc_html__( 'Choose the avatar you want to show', 'lifeline-donation' )),
			Text::make(esc_html__('Account Name', 'lifeline-donation'), 'user_login')
				->withMeta(['disabled' => true])
				->setHelp(esc_html__('Enter your name', 'lifeline-donation')),
			Text::make(esc_html__('Email Address', 'lifeline-donation'), 'user_email')
				->setHelp(esc_html__('Enter acount email address', 'lifeline-donation')),
			Text::make(esc_html__('Password', 'lifeline-donation'), 'user_password')
				->setHelp(esc_html__('Enter acount password, leave empty if you do not want to change', 'lifeline-donation'))
				->withMeta(['type' => 'password']),
			Text::make(esc_html__('Website', 'lifeline-donation'), 'user_url')
				->setHelp(esc_html__('Enter acount website address', 'lifeline-donation')),
			Text::make(esc_html__('Author Bio', 'lifeline-donation'), 'description')
				->withMeta(['type' => 'textarea', 'rows' => 4])
				->setHelp(esc_html__('Enter something about you.', 'lifeline-donation')),

			// Billing Fields.
			Text::make(esc_html__('First Name', 'lifeline-donation'), 'billing_first_name')
				->withMeta(['heading' => __('Billing Information', 'lifeline-donation')])
				->setHelp(esc_html__('Enter your first name.', 'lifeline-donation')),
			
			Text::make(esc_html__('Last Name', 'lifeline-donation'), 'billing_last_name')
				->setHelp(esc_html__('Enter your last name.', 'lifeline-donation')),
			Text::make(esc_html__('Company Name', 'lifeline-donation'), 'billing_company')
				->setHelp(esc_html__('Enter your company name.', 'lifeline-donation')),
			Country::make(esc_html__('Country', 'lifeline-donation'), 'billing_base_country')
				->default(['country' => 'USA', 'state' => ''])
				->setHelp(esc_html__('Choose the country.', 'lifeline-donation')),
			Text::make(esc_html__('Address', 'lifeline-donation'), 'billing_address_line_1')
				->setHelp(esc_html__('Enter the street address.', 'lifeline-donation')),
			Text::make(esc_html__('Address 2', 'lifeline-donation'), 'billing_address_line_2')
				->setHelp(esc_html__('Enter the street address.', 'lifeline-donation')),
			Text::make(esc_html__('Town / City', 'lifeline-donation'), 'billing_city')
				->setHelp(esc_html__('Enter the city', 'lifeline-donation')),
			Text::make(esc_html__('Zip / Postcode', 'lifeline-donation'), 'billing_zip')
				->setHelp(esc_html__('Enter the zip or post code', 'lifeline-donation')),
			Text::make(esc_html__('Phone', 'lifeline-donation'), 'billing_phone')
				->setHelp(esc_html__('Enter the phone', 'lifeline-donation')),
			
			// Social Profiles
			Text::make(esc_html__('Facebook', 'lifeline-donation'), 'facebook')
				->withMeta(['heading' => __('Social Profiles', 'lifeline-donation')])
				->setHelp(esc_html__('Enter the facebook profile URL', 'lifeline-donation')),
			Text::make(esc_html__('Twitter', 'lifeline-donation'), 'twitter')
				->setHelp(esc_html__('Enter the twitter profile URL', 'lifeline-donation')),
			Text::make(esc_html__('Linkedin', 'lifeline-donation'), 'linkedin')
				->setHelp(esc_html__('Enter the linkedin profile URL', 'lifeline-donation')),
			Text::make(esc_html__('Pinterest', 'lifeline-donation'), 'pinterest')
				->setHelp(esc_html__('Enter the pinterest profile URL', 'lifeline-donation')),
			
		))
	),
	array(
		'title'			=> apply_filters( 'wpcm_orders_admin_menu_label', esc_html__( 'My Orders', 'lifeline-donation' ) ),
		'icon'			=> 'fa fa-user-alt',
		'id'			=> 'profile_settings',
		'component'		=> 'myaccount-orders',
		'fields'		=> apply_filters( 'webinane_frontend_my_account_orders', array(
			array()
		))
	),

	array(
		'title'			=> esc_html__( 'Payment Methods', 'lifeline-donation' ),
		'icon'			=> 'fa fa-dollar-sign',
		'id'			=> 'payment_methods_settings',
		'component'		=> 'myaccount-payment-methods',
		'fields'		=> apply_filters( 'webinane_frontend_may_account_payment_methods', array(
			array()
		))
	)
);
