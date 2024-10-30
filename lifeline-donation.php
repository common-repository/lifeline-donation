<?php
/**
 * Plugin Name:     Lifeline Donation
 * Plugin URI:      https://webinane.com/plugins/donation
 * Description:     WordPress plugin for donations system, integrated with <a href="https://wordpress.org/plugins/webinane-commerce/" target="_blank">WP Commerce</a> plugin. If you need Stripe Gateway then <a href="https://codecanyon.net/item/stripe-payment-gateway-for-lifeline-donations/24447315" target="_blank">visit here</a> and if you looking for more gateways then <a href="https://www.webinane.com/plugins" target="_blank">visit Webinane</a>
 * Author:          Webinane
 * Author URI:      https://webinane.com
 * Text Domain:     lifeline-donation
 * Domain Path:     /languages
 * Version:         1.2.6
 *
 * @package         Lifeline_Donation
 */

defined( 'LIFELINE_DONATION_PATH' ) || define( 'LIFELINE_DONATION_PATH', plugin_dir_path( __FILE__ ) );
defined( 'LIFELINE_DONATION_URL' ) || define( 'LIFELINE_DONATION_URL', plugin_dir_url( __FILE__ ) );

require_once LIFELINE_DONATION_PATH . 'vendor/autoload.php';

add_action('plugins_loaded', function() {

	load_plugin_textdomain( 'lifeline-donation', false, basename( dirname( __FILE__ ) ) . '/languages' );
}, 2);

add_action( 'webinane_commerce_loaded', 'lifeline_donation_init' );

/**
 * Webinane donation main init hooked up with commerce loading.
 *
 * @return void
 */
function lifeline_donation_init() {
	require_once LIFELINE_DONATION_PATH . 'includes/load.php';

	Lifeline_Donation_Loader::init();
}

/**
 * REgister plugin activation hook.
 */
register_activation_hook(
	__FILE__,
	function () {
		flush_rewrite_rules( true );
		delete_transient( 'webinane_commerce_db_upgrade_status' );

		if ( class_exists('WebinaneCommerce\\Loader') ) {
			// require_once LIFELINE_DONATION_PATH . 'webinane-commerce/webinane-commerce.php';
			\WebinaneCommerce\Admin\Install::init();
			\WebinaneCommerce\Classes\Webinane::update_database();
		}
	}
);

add_action( 'upgrader_process_complete', function( $upgrader_object, $options ) {
	$current_plugin_path_name = plugin_basename( __FILE__ );

    if ($options['action'] == 'update' && $options['type'] == 'plugin' ){
       if( isset($options['plugins'])) {
	       foreach($options['plugins'] as $each_plugin){
	          if ( $each_plugin == $current_plugin_path_name){
	          	\WebinaneCommerce\Classes\Webinane::update_database();
	          }
	       }
       } elseif( isset($options['plugin']) ) {
       		if ( $options['plugin'] == $current_plugin_path_name ) {
	          	\WebinaneCommerce\Classes\Webinane::update_database();
       		}
       }
    }
},10, 2);