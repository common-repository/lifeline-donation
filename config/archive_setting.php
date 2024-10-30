<?php

use WebinaneCommerce\Fields\Radio;
use WebinaneCommerce\Fields\Select;
return 

	array(
		'title'			=> esc_html__( 'Archives', 'lifeline-donation' ),
		'icon'			=> 'fa fa-gift',
		'id'			=> 'archive_setting',
		'fields'		=> apply_filters( 'webinane_settings_archive_setting', 
			array(

				// Project or causes layout
				Radio::make(
					esc_html__( 'Project / Cause Layout', 'lifeline-donation' ),
					'archive_sidebar_layout'
				)->setOptions(array(
					'left' 		=> esc_html__('Left Sidebar', 'lifeline-donation'),
					'full' 		=> esc_html__('Full', 'lifeline-donation'),
					'right' 	=> esc_html__('Right Sidebar', 'lifeline-donation'),
					
				))
				->setHelp(esc_html__( 'Choose the archive pages layout for projects and causes.', 'lifeline-donation' )),

				//	Sidebar
				Select::make(
					esc_html__( 'Select sidebar', 'lifeline-donation' ),
					'cause_archive_sidebar'
				)->setOptions(wpcm_sidebar_data([]))
				->setHelp(esc_html__( 'Select sidebar to show on cause detail page', 'lifeline-donation' ))
				
			)
		)
);