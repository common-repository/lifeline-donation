<?php
/**
 * Single Donation file.
 *
 * @package WordPress
 */
namespace LifelineDoantion\Classes;

use LifelineDonation\Helpers\DonationData;
use WebinaneCommerce\Classes\Customers;

/**
 * Single Donation class.
 */
class SingleDonation {


	use DonationData;

	/**
	 * Instance.
	 *
	 * @var string
	 */
	public static $instance = '';

	/**
	 * Instance.
	 *
	 * @return object
	 */
	public static function instance() {
		if ( self::$instance == null ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
	/**
	 * Get data.
	 *
	 * @param  array $_post Array of posted data.
	 * @return void
	 */
	public function getData( $_post ) {
		$settings = wpcm_get_settings();

		$currencies = $this->getCurrencies( $settings );

		$dropdown = $this->getDropdown();

		$amount = $this->getPredefinedAmount();

		$gateways = wpcm_get_active_gateways( true );
		$post_id = sanitize_text_field( webinane_set( $_POST, 'post_id' ) );

		$donations = array();
		$needed_amt = array();
		$collect_amt = 0;

		$title = '';
		$text = '';

		if ( $post_id ) {
			$post = get_post( $post_id );
			$post_type = get_post_type( $post );

			$collect_amt = $this->getCollectedAmount( 'any', array( $post_id ) );
			$needed_amt = $this->getNeededAmount( $post );

			if ( webinane_set( $post, 'post_type' ) == 'page' ) {
				$title = $settings->get( 'donation_genral_title' );
				$text = $settings->get( 'donation_popup_text' );

			} else {
				$title = get_the_title( $post_id );
				$text = get_the_title( $post_id );

			}
		}

		$donations = array(
			'amt' => $collect_amt,
			'formated' => webinane_cm_price_with_symbol( $collect_amt ),
		);

		$needed_amount = array(
			'amt' => $needed_amt,
			'formated' => webinane_cm_price_with_symbol( $needed_amt ),
		);

		$currency = $settings->get( 'base_currency' );
		$symbol = webinane_currency_symbol();

		$response_data = compact( 'currencies', 'amount', 'gateways', 'donations', 'needed_amount', 'title', 'text', 'currency', 'symbol', 'dropdown' );

		$response_data = apply_filters( 'lifeline_donation/single_donation/ajax_data', $response_data );

		wp_send_json_success( $response_data );
	}

	/**
	 * Donate Single project or cause.
	 *
	 * @param  array $_post Array of posted data.
	 * @return void
	 */
	public function donateNow( $_post ) {
		$post_id = sanitize_text_field( webinane_set( $_POST, 'post_id' ) );
		$user_info = array_map( 'sanitize_text_field', webinane_set( $_POST, 'info' ) );
		$cc = sanitize_text_field( webinane_set( $_POST, 'cc' ) );
		$currency = sanitize_text_field( webinane_set( $_POST, 'currency' ) );
		$amount = sanitize_text_field( webinane_set( $_POST, 'amount' ) );
		$gateway = sanitize_text_field( webinane_set( $_POST, 'gateway' ) );
		$recurring = sanitize_text_field( webinane_set( $_POST, 'recurring' ) );

		wpcm_empty_cart();

		$res = wpcm_add_to_cart(
			array(
				'item_id'       => $post_id,
				'quantity'      => 1,
				'price'         => $amount,
			)
		);

		$user = '';

		if ( ! is_user_logged_in() ) {
			$user = $this->createUser( $user_info );
		}

		if ( ! isset( $user->ID ) ) {

			$user = wp_get_current_user();
		}

		if ( ! isset( $user->ID ) ) {
			wp_send_json_error( esc_html__( 'Please refresh the page and try again', 'lifeline-donation' ) );
		}

		// Set the user email from database so it must not be duplicate.
		$user_info['email'] = $user->data->user_email;

		if ( $res && is_email( webinane_set( $user_info, 'email' ) ) ) {
			// Update a customer record if they have added/updated information.
			$user_info['billing'] = array_filter( webinane_set( $_POST, 'info' ), 'sanitize_text_field' );
			if ( array_get( $user_info, 'billing.address' ) ) {
				$user_info['billing']['address_line_1'] = array_get( $user_info, 'billing.address' );
				unset( $user_info['billing']['address'] );
			}
			$customer = new Customers( $user_info['email'], $user_info );
			$customer->insert_meta($customer->customer, $user_info);

			if ( $customer ) {

				$auth_key = defined( 'AUTH_KEY' ) ? AUTH_KEY : '';
				// Set up the unique purchase key. If we are resuming a payment, we'll overwrite this with the existing key.
				$purchase_key     = strtolower( md5( $user_info['email'] . date( 'Y-m-d H:i:s' ) . $auth_key . uniqid( 'wpcommerce', true ) ) );

				// Setup purchase information.
				$purchase_data = array(
					'items'        => wpcm_get_cart_content(),

					'subtotal'     => wpcm_get_cart_subtotal(),    // Amount before taxes and discounts.
					'currency'     => $currency,
					'price'        => wpcm_get_cart_total(),    // Amount after taxes.
					'purchase_key' => $purchase_key,
					'user_email'   => $user_info['email'],
					'date'         => date( 'Y-m-d H:i:s', current_time( 'timestamp' ) ),
					'user_info'    => stripslashes_deep( $user_info ),
					'post_data'    => $this->array_filter_deep( $_POST, 'sanitize_text_field' ),
					'gateway'      => $gateway,
					'recurring'     => sanitize_text_field( webinane_set( $_POST, 'recurring' ) ),
				);

				// If the total amount in the cart is 0, send to the manual gateway. This emulates a free download purchase.
				if ( ! $purchase_data['price'] ) {
					// Revert to manual.
					$purchase_data['gateway'] = 'offline';
					$_POST['payment-gateway'] = 'offline';
				}

				wpcm_send_to_gateway( $purchase_data['gateway'], $purchase_data );

			}
		} else {
			wp_send_json_error( array( 'message' => esc_html__( 'There is something went wrong', 'lifeline-donation' ) ) );
		}
	}
}
