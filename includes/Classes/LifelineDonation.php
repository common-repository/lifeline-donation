<?php
/**
 * Lifeline Donation file.
 *
 * @package WordPress
 */

namespace LifelineDonation\Classes;

/**
 * Lifeline Donation class.
 */
class LifelineDonation {

	public static $version = '1.1.2.2';
	/**
	 * Init methods.
	 *
	 * @return void
	 */
	public static function init() {
		/**
		 * Hooked up to print custom markup in donation popup.
		 */
		add_action( 'webinane_commerce/popup/before_currencies', array( __CLASS__, 'dropdown' ) );

		add_filter('webinane_commerce/settings/menu_label', function($label) {
			return esc_html__('Lifeline Donation', 'lifeline-donation');
		});
		add_filter('webinane_commerce/settings/page_heading', function($label) {
			return esc_html__('Lifeline Donation Settings', 'lifeline-donation');
		});
		add_filter('webinane_commerce/settings/menu_icon', function($label) {
			return 'dashicons-smiley';
		});
		
	}

	/**
	 * General donation dropdowns.
	 *
	 * @return void.
	 */
	public static function dropdown() {
		include webinane_donation_template( 'donation-modal/general-donation-dropdowns.php' );
	}
}
