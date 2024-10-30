<?php
return array(
	array(
		'name'       => esc_html__( 'Show Donation Publicly', 'lifeline-donation' ),
		'id'         => 'show_donation_publicaly',
		'type'       => 'toggle',
		'is'		 => 'wpcm-toggle',
		'main_heading' => esc_html__( 'Others', 'lifeline-donation' ),
		'value_key'		=> 'user.data.meta.show_donation_publicaly'
	)
);
