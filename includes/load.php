<?php

use LifelineDonation\Classes\LifelineDonation;
use LifelineDonation\Classes\DashboardCharts;
use LifelineDonation\Classes\DashboardMisc;
use LifelineDonation\Classes\DashboardStats;

Class Lifeline_Donation_Loader {

	static function init() {

		self::post_types();
		self::taxonomies();
		self::load_files();
		self::metaboxes();

		add_filter('webinane_frontend_my_account_profile', array(__CLASS__, 'my_account'));

		self::setup();

		add_filter('wpcm_post_type_orders_args', array(__CLASS__, 'post_type_orders_args'));
	}

	static function load_files() {

		require_once LIFELINE_DONATION_PATH . 'includes/functions.php';
		require_once LIFELINE_DONATION_PATH . 'includes/class-lifeline-donation.php';
		require_once LIFELINE_DONATION_PATH . 'includes/Classes/LifelineDonation.php';
		require_once LIFELINE_DONATION_PATH . 'includes/Classes/DashboardStats.php';
		require_once LIFELINE_DONATION_PATH . 'includes/Classes/DashboardCharts.php';
		require_once LIFELINE_DONATION_PATH . 'includes/Classes/DashboardMisc.php';
		require_once LIFELINE_DONATION_PATH . 'includes/Classes/DbUpgradeFromThree.php';

		require_once LIFELINE_DONATION_PATH . 'includes/Helpers/DonationData.php';

		require_once LIFELINE_DONATION_PATH . 'includes/Classes/SingleDonation.php';
		require_once LIFELINE_DONATION_PATH . 'includes/Classes/GeneralDonation.php';

		require_once LIFELINE_DONATION_PATH . 'shortcodes/shortcodes.php';

		$hook = function_exists('vc_map') ? 'vc_after_init' : 'init';
		add_action($hook, function(){
			require_once LIFELINE_DONATION_PATH . 'shortcodes/button.php';
			require_once LIFELINE_DONATION_PATH . 'shortcodes/button2.php';
			require_once LIFELINE_DONATION_PATH . 'shortcodes/parallax.php';
			require_once LIFELINE_DONATION_PATH . 'shortcodes/parallax2.php';
			require_once LIFELINE_DONATION_PATH . 'shortcodes/parallax3.php';
			require_once LIFELINE_DONATION_PATH . 'shortcodes/parallax4.php';
			require_once LIFELINE_DONATION_PATH . 'shortcodes/parallax5.php';
			require_once LIFELINE_DONATION_PATH . 'shortcodes/campaigns1.php';
			require_once LIFELINE_DONATION_PATH . 'shortcodes/campaigns2.php';
			require_once LIFELINE_DONATION_PATH . 'shortcodes/campaigns3.php';
			require_once LIFELINE_DONATION_PATH . 'shortcodes/campaigns4.php';
			require_once LIFELINE_DONATION_PATH . 'shortcodes/campaigns5.php';
			require_once LIFELINE_DONATION_PATH . 'shortcodes/donation_template.php';
			require_once LIFELINE_DONATION_PATH . 'shortcodes/donor_list.php';
		});
		//Widgets
		require_once LIFELINE_DONATION_PATH . 'widgets/recent_donations.php';
		require_once LIFELINE_DONATION_PATH . 'widgets/urgent_campaigns.php';
		require_once LIFELINE_DONATION_PATH . 'widgets/urgent_cause.php';
		require_once LIFELINE_DONATION_PATH . 'widgets/urgent_project.php';
		require_once LIFELINE_DONATION_PATH . 'widgets/top_donors.php';
		require_once LIFELINE_DONATION_PATH . 'widgets/donor_of_month.php';
		require_once LIFELINE_DONATION_PATH . 'widgets/donors_list.php';

		require_once LIFELINE_DONATION_PATH . 'elementor/elementor.php';


		//Gutenburg Blocks
		require_once LIFELINE_DONATION_PATH . 'blocks/parallax.php';
		require_once LIFELINE_DONATION_PATH . 'blocks/parallax-donation-campaign.php';
		require_once LIFELINE_DONATION_PATH . 'blocks/parallax-donation-campaign.php';
		require_once LIFELINE_DONATION_PATH . 'blocks/giving-hand.php';
		require_once LIFELINE_DONATION_PATH . 'blocks/giving-hand2.php';
		require_once LIFELINE_DONATION_PATH . 'blocks/campaigns.php';
		require_once LIFELINE_DONATION_PATH . 'blocks/campaigns2.php';
		require_once LIFELINE_DONATION_PATH . 'blocks/campaigns3.php';
		require_once LIFELINE_DONATION_PATH . 'blocks/campaigns4.php';
		require_once LIFELINE_DONATION_PATH . 'blocks/campaigns5.php';
		require_once LIFELINE_DONATION_PATH . 'blocks/button.php';

	}
	static function post_types() {
		require_once LIFELINE_DONATION_PATH . 'post-types/cause.php';
		require_once LIFELINE_DONATION_PATH . 'post-types/project.php';
	}

	static function taxonomies() {
		require_once LIFELINE_DONATION_PATH . 'taxonomies/cause_cat.php';
		require_once LIFELINE_DONATION_PATH . 'taxonomies/project_cat.php';
	}
	static function metaboxes() {

		$settings = wpcm_get_settings();

		$causes = include LIFELINE_DONATION_PATH . 'config/causes.php';
		$projects = include LIFELINE_DONATION_PATH . 'config/projects.php';

		if( function_exists('webinane_commerce_set_metabox') ) {
			webinane_commerce_set_metabox($causes);
			webinane_commerce_set_metabox($projects);
		}
	}
	static function my_account($opt) {
		$_opt = include LIFELINE_DONATION_PATH . 'config/my_account.php';
		$opt = array_merge($opt,$_opt);
		return $opt;
	}



	static function post_type_orders_args($args) {

		$labels = array(
			'name'               => esc_html__( 'Donations', 'lifeline-donation' ),
			'singular_name'      => esc_html__( 'Donation', 'lifeline-donation' ),
			'add_new'            => _x( 'Add New Donation', 'lifeline-donation', 'lifeline-donation' ),
			'add_new_item'       => esc_html__( 'Add New Donation', 'lifeline-donation' ),
			'edit_item'          => esc_html__( 'Edit Donation', 'lifeline-donation' ),
			'new_item'           => esc_html__( 'New Donation', 'lifeline-donation' ),
			'view_item'          => esc_html__( 'View Donation', 'lifeline-donation' ),
			'search_items'       => esc_html__( 'Search Donations', 'lifeline-donation' ),
			'not_found'          => esc_html__( 'No Donations found', 'lifeline-donation' ),
			'not_found_in_trash' => esc_html__( 'No Donations found in Trash', 'lifeline-donation' ),
			'parent_item_colon'  => esc_html__( 'Parent Donation:', 'lifeline-donation' ),
			'menu_name'          => esc_html__( 'Donations', 'lifeline-donation' ),
		);

		$args['labels'] = $labels;
		$args['menu_icon']	= 'dashicons-money';

		return $args;
	}

	/**
	 * Setup
	 *
	 * @return [type] [description]
	 */
	static function setup() {
		LifelineDonation::init();
		DashboardStats::init();
		DashboardCharts::init();
		DashboardMisc::init();
	}
}
