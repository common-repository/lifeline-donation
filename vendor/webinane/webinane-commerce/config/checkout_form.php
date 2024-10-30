<?php

return array(

	array(
		'title'			=> esc_html__( 'WP Commerce', 'lifeline-donation' ),
		'id'			=> 'wpcommerce_frontend_checkout_form_customer_info',
		'object_types'	=> array('none'),
		'hookup'		=> false,
		'save_fields'	=> false,
		'fields'		=> apply_filters( 'wpcm_frotend_checkout_form_cutomer_info', array(
			array(
				'name'       => esc_html__( 'First Name', 'lifeline-donation' ),
				'desc'       => esc_html__( 'Enter the first name', 'lifeline-donation' ),
				'id'         => 'first_name',
				'type'       => 'text',
			),
			array(
				'name'       => esc_html__( 'Last Name', 'lifeline-donation' ),
				'desc'       => esc_html__( 'Please enter your last name', 'lifeline-donation' ),
				'id'         => 'last_name',
				'type'       => 'text',
			),
			array(
				'name'       => esc_html__( 'Address Line 1', 'lifeline-donation' ),
				'desc'       => esc_html__( 'Enter the store address', 'lifeline-donation' ),
				'id'         => 'address_line_1',
				'type'       => 'text',
			),
			array(
				'name'       => esc_html__( 'Address Line 2', 'lifeline-donation' ),
				'desc'       => esc_html__( 'Enter the store address', 'lifeline-donation' ),
				'id'         => 'address_line_2',
				'type'       => 'text',
			),
			array(
				'name'       => esc_html__( 'City', 'lifeline-donation' ),
				'desc'       => esc_html__( 'Enter the store city', 'lifeline-donation' ),
				'id'         => 'city',
				'type'       => 'text',
			),
			array(
				'name'       => esc_html__( 'Base Country', 'lifeline-donation' ),
				'desc'       => esc_html__( 'Choose the base country', 'lifeline-donation' ),
				'id'         => 'base_country',
				'type'       => 'select',
				'options'	 => wpcm_countries()->toArray()
			),
			array(
				'name'       => esc_html__( 'Postcode / ZIP', 'lifeline-donation' ),
				'desc'       => esc_html__( 'Enter the postcode or ZIP', 'lifeline-donation' ),
				'id'         => 'zip',
				'type'       => 'text',
			),

		))
	),
);
