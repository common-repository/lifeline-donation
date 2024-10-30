<?php
namespace LifelineDonation\Shortcodes;

use LifelineDonation\Shortcodes\Shortcodes;

class DonorList extends Shortcodes
{

	static function init() {
		self::$shortcode = 'wi_donor_list';
		self::$vc_map = self::vc_map();
		parent::init();

	}

	static function vc_map() {
		$params = array();
		
		/**
		 * @class WPBakeryShortCode_Vc_Btn
		 */
		return array(
			'name' => esc_html__( 'Donor\'s Donations List', 'lifeline-donation' ),
			'base' => self::$shortcode,
			'icon' => LIFELINE_DONATION_URL . 'assets/images/icon.png',
			'category' => array(
				self::$category
			),
			'description' => esc_html__( 'Show the list of donation from all donors or from a specific donor by appending ?user_id=USER_ID in URL', 'lifeline-donation' ),
			'params' => $params,
			'html_template' => self::get_template_path(),
		);

	}

}

DonorList::init();
