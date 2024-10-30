<?php

use WebinaneCommerce\Fields\Color;
use WebinaneCommerce\Fields\Select;
use WebinaneCommerce\Fields\Switcher;
use WebinaneCommerce\Fields\Text;
return

	array(
		'title'			=> esc_html__( 'Menu Button', 'lifeline-donation' ),
		'icon'			=> 'fa fa-gift',
		'id'			=> 'donation_button',
		// 'heading'		=> esc_html__('Donation Button Settings', 'lifeline-donation'),
		'fields'		=> apply_filters( 'webinane_settings_donation_button', array(

			Switcher::make(
				esc_html__( 'Show Donation button in Menu', 'lifeline-donation' ),
				'menu_donation_button'
			)->withMeta(array(
				'active-text' => esc_html__( 'YES', 'lifeline-donation' ),
				'inactive-text' => esc_html__( 'NO', 'lifeline-donation' ),
			))
			->default(true)
			->setHelp(esc_html__( 'Whether to show donation button in menus', 'lifeline-donation' )),

			// Menu location
			Select::make(
				esc_html__( 'Menu Location', 'lifeline-donation' ),
				'menu_donation_button_theme_location'
			)->setOptions(get_registered_nav_menus())
			->default('primary_menu')
			->setHelp(esc_html__( 'Choose menu location where you want to show this button.', 'lifeline-donation' ))
			->setDependency(array('key' => 'menu_donation_button', 'value' => true, 'compare' => '=')),

			// Donation button title
			Text::make(
				esc_html__( 'Donation Button Title', 'lifeline-donation' ),
				'menu_donation_button_title'
			)
			->setHelp(esc_html__( 'Enter the title for donation button', 'lifeline-donation' ))
			->setDependency(array('key' => 'menu_donation_button', 'value' => true, 'compare' => '=')),

			// Button background color
			Color::make(
				esc_html__( 'Button background color', 'lifeline-donation' ),
				'menu_donation_button_color'
			)
			->setHelp(esc_html__( 'Choose the color for donation button', 'lifeline-donation' ))
			->setDependency(array('key' => 'menu_donation_button', 'value' => true, 'compare' => '=')),

			// Background mouse over color
			Color::make(
				esc_html__( 'Background mouseover color', 'lifeline-donation' ),
				'menu_donation_button_hover_color'
			)
			->setHelp(esc_html__( 'Choose the color for donation button', 'lifeline-donation' ))
			->setDependency(array('key' => 'menu_donation_button', 'value' => true, 'compare' => '=')),

			// Text mouse over color
			Color::make(
				esc_html__( 'Text mouseover color', 'lifeline-donation' ),
				'menu_donation_button_text_hover_color'
			)
			->setHelp(esc_html__( 'Choose the color for donation button', 'lifeline-donation' ))
			->setDependency(array('key' => 'menu_donation_button', 'value' => true, 'compare' => '=')),

			// Button text color
			Color::make(
				esc_html__( 'Button Text color', 'lifeline-donation' ),
				'menu_donation_button_font_color'
			)
			->setHelp(esc_html__( 'Choose the color for donation button', 'lifeline-donation' ))
			->setDependency(array('key' => 'menu_donation_button', 'value' => true, 'compare' => '=')),

		))

);