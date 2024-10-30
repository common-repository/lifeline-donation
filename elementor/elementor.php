<?php
namespace LifelineDonation\Elementor;


class Elementor
{
	static $widgets = array(
		'button',
		'causes',
		'causes2',
		'causes3',
		'causes4',
		'causes5',
		'heading',
		'heading2',
		'single_causes_widget',
		'causes_listing_widget',
	);

	static function init() {
		add_action('elementor/init', array(__CLASS__, 'loader') );
		add_action( 'elementor/elements/categories_registered', array(__CLASS__, 'register_cats') );
	}

	static function loader() {

		foreach( self::$widgets as $widget ) {

		    $file = LIFELINE_DONATION_PATH . 'elementor/'.$widget.'.php';
		    if( file_exists($file)) {
		    	require_once $file;
		    }
		    
		    add_action('elementor/widgets/widgets_registered', array(__CLASS__, 'register'));
		}
	}

	static function register($elemntor) {
		foreach( self::$widgets as $widget ) {
			$class = '\\LifelineDonation\\Elementor\\'.ucwords($widget);

			if( class_exists($class) ) {
        		$elemntor->register_widget_type(new $class);
			}
		}
    }

    static function register_cats( $elements_manager ) {

		$elements_manager->add_category(
			'donations',
			[
				'title' => esc_html__( 'Webinane Donations', 'lifeline-donation' ),
				'icon' => 'fa fa-plug',
			]
		);

	}
}

Elementor::init();