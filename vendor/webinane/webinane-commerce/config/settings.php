<?php
use WebinaneCommerce\Fields\Checkbox;
use WebinaneCommerce\Fields\Country;
use WebinaneCommerce\Fields\Media;
use WebinaneCommerce\Fields\Select;
use WebinaneCommerce\Fields\Switcher;
use WebinaneCommerce\Fields\Text;
use WebinaneCommerce\Fields\Textarea;
use WebinaneCommerce\Fields\Repeater;

return array(

	array(
		'title'			=> esc_html__( 'General', 'lifeline-donation' ),
		'icon'			=> 'el-icon-setting',
		'id'			=> 'general_settings',
		'children'		=> array(
			apply_filters( 'webinane_commerce/settings/address_fields', array(
				'id'	=> 'address-info',
				'title'	=> esc_html__('Address Info', 'lifeline-donation'),
				'heading'	=> esc_html__('Address Information', 'lifeline-donation'),
				'fields'	=> array(
					
					/*Repeater::make(__('Select Country and State', 'lifeline-donation'), 'base_repeater')
						->fields([
							Text::make('City'),
							Text::make('Address')
						])
						->default(['country' => 'USA', 'state' => ''])
						->setHelp(esc_html__( 'Choose the base country and state', 'lifeline-donation' )),*/
					Country::make(__('Select Country and State', 'lifeline-donation'), 'base_country')
						->default(['country' => 'USA', 'state' => ''])
						->setHelp(esc_html__( 'Choose the base country and state', 'lifeline-donation' )),
					
					Text::make(esc_html__('City', 'lifeline-donation'), 'base_city')
						->default('New York')
						->setHelp(esc_html__( 'Enter the base city', 'lifeline-donation' )),
					Text::make(esc_html__('Add Address', 'lifeline-donation'), 'address_line_1')
						->default('Webinane Plaza, 3rd Floor NY')
						->setHelp(esc_html__( 'Enter the business address', 'lifeline-donation' )),
					Text::make(esc_html__('Address Line 2', 'lifeline-donation'), 'address_line_2')
						->setHelp(esc_html__( 'Enter the business address', 'lifeline-donation' )),
					Text::make(esc_html__('ZIP Code', 'lifeline-donation'), 'zip_code')
						->default('10200')
						->setHelp(esc_html__( 'Enter the ZIP / Postal Code', 'lifeline-donation' )),
					
				)
			)),
			apply_filters( 'webinane_commerce/settings/currency_info_fields', array(
				'id'	=> 'currency-info',
				'title'	=> esc_html__('Currency Info', 'lifeline-donation'),
				'heading'	=> esc_html__('Currency Information', 'lifeline-donation'),
				'fields'	=> array(
					
					Select::make(esc_html__('Select Currency', 'lifeline-donation'), 'base_currency')
						->default('USD')
						->setOptions(wpcm_currency_assos_data())
						->setHelp(esc_html__( 'Choose the base currency', 'lifeline-donation' )),
					Select::make(esc_html__('Currency Symbol Position', 'lifeline-donation'), 'currency_position')
						->default('left')
						->setOptions([
							'left'		=> esc_html__( 'Left (eg: $2,000.00)', 'lifeline-donation' ),
							'right'		=> esc_html__( 'Right (eg: 2,000.00$)', 'lifeline-donation' ),
							'left_s'	=> esc_html__( 'Left with Space (eg: $ 2,000.00)', 'lifeline-donation' ),
							'right_s'	=> esc_html__( 'Right with Space (eg: 2,000.00 $)', 'lifeline-donation' ),
						])
						->setHelp(esc_html__( 'Choose the currency symbol position', 'lifeline-donation' )),
					
					Text::make(esc_html__('Thousand Saparate', 'lifeline-donation'), 'thousand_saparator')
						->default(',')
						->setHelp(esc_html__( 'Enter the thousand amount saparator', 'lifeline-donation' )),
					Text::make(esc_html__('Decimal Separator', 'lifeline-donation'), 'decimal_saparator')
						->default('.')
						->setHelp(esc_html__( 'Enter the decimal saparator', 'lifeline-donation' )),
					Text::make(esc_html__('Number of decimals', 'lifeline-donation'), 'number_decimals')
						->default('.')
						->setHelp(esc_html__( 'Enter the number of decimals', 'lifeline-donation' )),
					
				)
			))
		),
		
	),
	array(
		'title'			=> esc_html__( 'Payments', 'lifeline-donation' ),
		'icon'			=> 'el-icon-bank-card',
		'id'			=> 'payment_settings',
		'children'		=> apply_filters( 'wpcommerce_payment_gateways_setting_tabs', array(array(
			'title'			=> esc_html__( 'General', 'lifeline-donation' ),
			'icon'			=> 'fa fa-th',
			'id'			=> 'general_gateways_settings',
			'heading'	=> esc_html__('Gateway Settings', 'lifeline-donation'),
			'fields'		=> array(
				Switcher::make(esc_html__('Test Mode', 'lifeline-donation'), 'gateways_test_mode')
				->setHelp(esc_html__( 'While in the test mode no live payments are processed. To fully use test mode, you must have a sandbox(test) account for payment gateway', 'lifeline-donation' )),
				Checkbox::make(esc_html__('Gateways', 'lifeline-donation'), 'active_gateways')
				->setOptions(function() {
					$gateways = apply_filters( 'wpcommerce_payment_gateways', array() );
					$return = [];
					foreach($gateways as $gateway) {
						$return[$gateway->id] = $gateway->name;
					}
					return $return;
				})->withMeta(['class' => 'display-block'])
				->setHelp(sprintf(__( 'Enable your payment gateway. Want to get more payment gateways? <a href="%s" target="_blank">Click Here</a>', 'lifeline-donation' ), 'https://www.webinane.com/plugins')),

				//Default gateway
				Select::make(esc_html__('Default Gateway', 'lifeline-donation'), 'default_gateway')
				->setOptions(function() {
					$gateways = apply_filters( 'wpcommerce_payment_gateways', array() );
					$return = [];
					foreach($gateways as $gateway) {
						$return[$gateway->id] = $gateway->name;
					}
					return $return;
				})
				->setHelp(esc_html__( 'Choose the default gateway. The gateway will be select by default.', 'lifeline-donation' )),
				
			)
		) ) )
	),
	array(
		'title'			=> esc_html__( 'Display', 'lifeline-donation' ),
		'icon'			=> 'el-icon-monitor',
		'id'			=> 'display_settings',
		'fields'		=> apply_filters( 'webinane_commerce/settings/display_settings', array(
			
			Select::make(esc_html__('Checkout Page', 'lifeline-donation'), 'checkout_page')
				->setOptions(wpcm_posts_data( array( 'post_type' => 'page', 'posts_per_page' => 100 ) ))
				->setHelp(esc_html__( 'Choose the checkout page', 'lifeline-donation' )),

			Select::make(esc_html__('Order Success Page', 'lifeline-donation'), 'success_page')
				->setOptions(wpcm_posts_data( array( 'post_type' => 'page', 'posts_per_page' => 100 ) ))
				->setHelp(esc_html__( 'Choose the to show when an order is successfull', 'lifeline-donation' )),

			Select::make(esc_html__('My Account Page', 'lifeline-donation'), 'my_account_page')
				->setOptions(wpcm_posts_data( array( 'post_type' => 'page', 'posts_per_page' => 100 ) ))
				->setHelp(esc_html__( 'Choose the my account page', 'lifeline-donation' )),

			Switcher::make(esc_html__('Redirect to Checkout', 'lifeline-donation'), 'redirect_to_checkout')
				->setHelp(esc_html__( 'Redirect user to checkout page after add to cart', 'lifeline-donation' )),
		) )
	),
	array(
		'title'			=> esc_html__( 'Emails', 'lifeline-donation' ),
		'icon'			=> 'el-icon-message',
		'id'			=> 'emails_settings',
		'children'		=> array(
			apply_filters( 'webinane_commerce/settings/customer_email_settings', array(
				'id'	=> 'customer_email_settings',
				'title'	=> esc_html__('Customer Email', 'lifeline-donation'),
				'heading'	=> esc_html__('Email Setting for Customers', 'lifeline-donation'),
				'fields'	=> array(
					
					Text::make(__('Subject', 'lifeline-donation'), 'customer_email_subject')
						->setHelp(__( 'Enter the subject for customer\'s email. You can use placeholders <pre>{{customer_name}} {{customer_email}} {{site_name}} {{site_url}}</pre>  <pre>{{admin_email}} {{customer_account_url}} {{admin_order_url}}</pre> <pre>{{total_amount}}</pre>' , 'lifeline-donation' )),
					Media::make(esc_html__('Header Logo', 'lifeline-donation'), 'customer_email_header_logo')
						->setAddText(esc_html__( 'Add Logo', 'lifeline-donation' ))
						->setUpdateText(esc_html__( 'Change Logo', 'lifeline-donation' ))
						->setHelp(esc_html__( 'Choose the logo you want to show in the email header', 'lifeline-donation' )),
					Media::make(esc_html__('Footer Logo', 'lifeline-donation'), 'customer_email_footer_logo')
						->setAddText(esc_html__( 'Add Logo', 'lifeline-donation' ))
						->setUpdateText(esc_html__( 'Change Logo', 'lifeline-donation' ))
						->setHelp(esc_html__( 'Choose the logo you want to show in the email footer', 'lifeline-donation' )),
					Text::make(esc_html__('Greeting Text', 'lifeline-donation'), 'customer_email_greeting_text')
						->default('Thanks for your Donation!')
						->setHelp(esc_html__( 'Enter the greeting text of the email', 'lifeline-donation' )),
					Textarea::make(esc_html__('Email Body', 'lifeline-donation'), 'customer_email_body')
						->setHelp(esc_html__( 'You can use HTML Tags.', 'lifeline-donation' )),
					Textarea::make(esc_html__('Footer Text', 'lifeline-donation'), 'customer_email_footer_text')
						->default(sprintf('<p>%s</p>', get_bloginfo('name')))
						->setHelp(esc_html__( 'Enter the text you want to show in footer', 'lifeline-donation' )),
					Switcher::make(esc_html__('Show Quantity', 'lifeline-donation'), 'customer_email_show_qty')
						->default(true)
						->setHelp(esc_html__( 'Whether to show the total quantity in email', 'lifeline-donation' )),
					Switcher::make(esc_html__('Show Customer Address', 'lifeline-donation'), 'customer_email_show_address')
						->default(true)
						->setHelp(esc_html__( 'Whether to show the customer address detail in email', 'lifeline-donation' )),
					Switcher::make(esc_html__('Show Item Detail', 'lifeline-donation'), 'customer_email_show_item_info')
						->default(true)
						->setHelp(esc_html__( 'Whether to show the item or donation detail in email', 'lifeline-donation' )),
					
				)
			)),
			apply_filters( 'webinane_commerce/settings/owner_email_settings', array(
				'id'	=> 'owner_email_settings',
				'title'	=> esc_html__('Admin Email', 'lifeline-donation'),
				'heading'	=> esc_html__('Email Setting for Admin', 'lifeline-donation'),
				'fields'	=> array(
					
					Text::make(__('Subject', 'lifeline-donation'), 'admin_email_subject')
						->setHelp(__( 'Enter the subject for admin\'s email. You can use placeholders <pre>{{customer_name}} {{customer_email}} {{site_name}} {{site_url}}</pre>  <pre>{{admin_email}} {{customer_account_url}} {{admin_order_url}}</pre> <pre>{{total_amount}}</pre>' , 'lifeline-donation' )),
					Text::make(esc_html__('Greeting Text', 'lifeline-donation'), 'admin_email_greeting_text')
						->default('Thanks for your Donation!')
						->setHelp(esc_html__( 'Enter the greeting text of the email', 'lifeline-donation' )),
					Textarea::make(esc_html__('Email Body', 'lifeline-donation'), 'admin_email_body')
						->setHelp(esc_html__( 'You can use HTML Tags.', 'lifeline-donation' )),
					Textarea::make(esc_html__('Footer Text', 'lifeline-donation'), 'admin_email_footer_text')
						->default(sprintf('<p>%s</p>', get_bloginfo('name')))
						->setHelp(esc_html__( 'Enter the text you want to show in footer', 'lifeline-donation' )),					
				)
			)),
		)
	),
	
);
