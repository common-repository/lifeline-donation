<?php
namespace WebinaneCommerce\Gateways;

use WebinaneCommerce\Classes\Gateways;
use WebinaneCommerce\Classes\Orders;
use WebinaneCommerce\Fields\Text;
use WebinaneCommerce\Fields\Textarea;

class GatewayOffline extends Gateways
{
	static $_instance;

	var $name = '';
	var $id = 'offline';
	var $desc = '';

	static function init() {
		self::setup();

		add_filter('wpcommerce_payment_gateways', array(__CLASS__, 'gateway'));
		add_filter('wpcommerce_payment_gateways_setting_tabs', array(__CLASS__, 'settings'));
		add_action('wpcm_send_to_gateway_offline', array(__CLASS__, 'run') );
		add_action('wpcm_order_successful_offline', array(__CLASS__, 'show_detail'), 20, 2 );

		add_filter('webinane_commerce/admin/offline/meta', array(__CLASS__, 'admin_meta'), 20, 2);
	}

	/**
	 * [instance description]
	 *
	 * @return [type] [description]
	 */
	static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	static function setup() {
		$gateways = wpcm_get_settings()->get('gateways');
		$gateways = ($gateways) ? $gateways : wpcm_get_settings();

		self::instance()->name = esc_html__( 'Offline Payment', 'lifeline-donation' );
		self::instance()->desc = esc_html__( 'Pay offline via check or cash', 'lifeline-donation' );

		self::instance()->title = array_get($gateways, 'offline_payment_title');
		self::instance()->description = array_get($gateways, 'offline_payment_description');
		self::instance()->icon = WNCM_URL . 'assets/images/offline-icon.png';
	}

	/**
	 * The gateway
	 *
	 * @param  array  $gateways [description]
	 * @return [type]           [description]
	 */
	static function gateway($gateways = array()) {

		$gateways['offline'] = self::instance();

		return $gateways;
	}

	/**
	 * Settings API.
	 *
	 * @param  array  $settings [description]
	 * @return [type]           [description]
	 */
	static function settings($settings = array()) {
		$offline_gateway = array_get(wpcm_get_settings(), 'gateways.offline_gateway');
		$settings[] = array(
			'title'			=> esc_html__( 'Offline Gateway', 'lifeline-donation' ),
			'icon'			=> 'fa fa-th',
			'heading'	=> esc_html__('Offline Gateway', 'lifeline-donation'),
			'id'			=> 'offline_gateway',
			// "sandbox_help" => "This is sandbox help",
			'fields'		=> array(
				Text::make(esc_html__( 'Title', 'lifeline-donation' ), 'offline_payment_title', function() use ($offline_gateway) {
					if($value = array_get(wpcm_get_settings(), 'offline_payment_title')) {
						return $value;
					}
					return array_get($offline_gateway, 'offline_payment_title');
				})->setHelp(esc_html__( 'Title to show on the payment page', 'lifeline-donation' )),
				Text::make(esc_html__( 'Description', 'lifeline-donation' ), 'offline_payment_description', function() use ($offline_gateway) {
					if($value = array_get(wpcm_get_settings(), 'offline_payment_description')) {
						return $value;
					}
					return array_get($offline_gateway, 'offline_payment_description');
				})->setHelp(esc_html__( 'Description to show on the success page', 'lifeline-donation' )),
				Textarea::make(esc_html__( 'Payment Instructions', 'lifeline-donation' ), 'offline_payment_instruction', function() use ($offline_gateway) {
					if($value = array_get(wpcm_get_settings(), 'offline_payment_instruction')) {
						return $value;
					}
					return array_get($offline_gateway, 'offline_payment_instruction');
				})->setHelp(esc_html__( 'Enter the instructions like bank account detail to show on success page', 'lifeline-donation' )),
				
			)
		);
					
		return $settings;
	}

	/**
	 * [is_active description]
	 *
	 * @return boolean [description]
	 */
	function is_active() {
		$settings = wpcm_get_settings();

		if ( isset($settings['active_gateways'] ) ) {
			$status = in_array('offline', $settings['active_gateways']);
		} else {
			$status = wpcm_get_settings()->get('offline_gateway');
		}

		if( ! $status ) {
			return false;
		}

		return ($status === 'false') ? false : true;
	}

	/**
	 * Finally hookup the payment.
	 * 
	 * @param  array $payment_data  User submitted data array.
	 * @return mix 	              	Json response.
	 */
	static function run($payment_data) {

		$active = self::instance()->is_active();

		if( ! $active ) {
			wp_send_json_error( array('message' => esc_html__( 'The gateway is not active, please try another gateway', 'lifeline-donation' )) );
		}
		

		$order_id = Orders::create($payment_data);

		wpcm_empty_cart();
		
		$url = wpcm_get_success_page_url(array('key' => $payment_data['purchase_key'], 'type' => 'success'));
		wp_send_json( array('type' => 'redirect', 'url' => $url) );
	}

	/**
	 * Hooked up to show the offline payment instruction.
	 * 
	 * @param  [type] $order [description]
	 * @param  [type] $key   [description]
	 * @return [type]        [description]
	 */
	static function show_detail($order, $key) {
		webinane_template('orders/offline-order-detail.php', compact('order', 'key'));
	}

	/**
	 * [admin_meta description]
	 * 
	 * @param  [type] $meta_data [description]
	 * @param  [type] $order     [description]
	 * @return [type]            [description]
	 */
	static function admin_meta($meta_data, $order) {

		$is_recurring = get_post_meta($order->ID, '_wpcm_is_recurring', true);

		$meta_data[] = [
			'label'	=>  esc_html__('Recurring', 'lifeline-donation'),
			'value'	=> ($is_recurring) ? esc_html__('YES', 'lifeline-donation') : esc_html__('NO', 'lifeline-donation')
		];

		if($is_recurring) {
			$cycle = get_post_meta($order->ID, '_wpcm_recurring_cycle', true);
			$frequency = get_post_meta($order->ID, '_wpcm_recurring_frequency', true);
			$period = get_post_meta($order->ID, '_wpcm_order_recurring_period', true);
			
			$meta_data[] = [
				'label'	=>  esc_html__('Recurring Cycle', 'lifeline-donation'),
				'value'	=> $period
			];
			$meta_data[] = [
				'label'	=>  esc_html__('Recurring Frequency', 'lifeline-donation'),
				'value'	=> $frequency
			];
			
		}
		
		return $meta_data;
	}
}
