<?php
/**
 * General donation file.
 *
 * @package WordPress
 */

namespace LifelineDoantion\Classes;

use LifelineDonation\Helpers\DonationData;
use WeDevs\ORM\WP\PostMeta;
use WebinaneCommerce\Classes\Customers;

/**
 * General donation class.
 */
class GeneralDonation {


	use DonationData;

	/**
	 * Instance.
	 *
	 * @var string
	 */
	public static $instance = '';

	/**
	 * Class instance.
	 *
	 * @return object
	 */
	public static function instance() {
		if ( null == self::$instance ) {
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

		$purpose = array_get( $_post, 'purpose' );
		$settings = wpcm_get_settings();

		$currencies = $this->getCurrencies( $settings );

		$dropdown = $this->getDropdown();

		$amount = $this->getPredefinedAmount();

		$gateways = wpcm_get_active_gateways( true );
		$post_id = sanitize_text_field( webinane_set( $_POST, 'post_id' ) );

		$donations = array();
		$needed_amt = array();
		$collect_amt = 0;

		$title = wpcm_get_settings()->get('donation_genral_title');
		$text = wpcm_get_settings()->get('donation_popup_text');;

		switch ( $purpose ) {
			case 'all_projects_causes':
				$collect_amt = $this->getCollectedAmount( array( 'project', 'cause' ) );
				$needed_amt = $this->getNeededAmount( array( 'project', 'cause' ) );
				$title = ($title) ? $title : esc_html__( 'Donation for all Projects & Charities', 'lifeline-donation' );
				break;
			case 'all_projects':
				$collect_amt = $this->getCollectedAmount( array( 'project' ) );
				$needed_amt = $this->getNeededAmount( array( 'project' ) );
				$title = ($title) ? $title : esc_html__( 'Donation for all Projects', 'lifeline-donation' );
				break;
			case 'all_causes':
				$collect_amt = $this->getCollectedAmount( array( 'cause' ) );
				$needed_amt = $this->getNeededAmount( array( 'cause' ) );
				$title = ($title) ? $title : esc_html__( 'Donation for all Charities', 'lifeline-donation' );
				break;
			case 'custom':
				$ids = array_get( $_post, 'custom_purpose' );

				$collect_amt = $this->getCollectedAmount( array( 'cause', 'project' ), $ids );
				$needed_amt = $this->getNeededAmount( array( 'cause', 'project' ), $ids );
				$title = ($title) ? $title : esc_html__( 'Donation for all Charities', 'lifeline-donation' );
				break;

			default:
				$collect_amt = apply_filters("lifeline_donation/general/{$purpose}/collected_amt", 0, $_post);
				$needed_amt = apply_filters("lifeline_donation/general/{$purpose}/needed_amt", 0, $_post);
				
				$title = apply_filters("lifeline_donation/general/{$purpose}/title", $title, $_post);
				break;
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

		$response_data = apply_filters( 'lifeline_donation/general_donation/ajax_data', $response_data );

		wp_send_json_success( $response_data );
	}

	/**
	 * Get needed amount.
	 *
	 * @param  object $post List of post types.
	 * @param  array $ids Array of ids.
	 * @return number
	 */
	private function getNeededAmount( $post_types, $ids = array() ) {

		$settings = wpcm_get_settings();

		if ( ! $ids ) {
			$posts = get_posts( array( 'post_type' => $post_types ) );
			$ids = wp_list_pluck( $posts, 'ID' );
		}

		$meta = PostMeta::whereIn( 'post_id', $ids )->whereIn( 'meta_key', array( 'causes_settings', 'project_settings' ) )->get();

		$needed_amt = 0;
		if ( $meta ) {
			foreach ( $meta as $value ) {
				$amt = (float) array_get( $value->new_value, 'donation' );
				$needed_amt = $needed_amt + $amt;
			};
		}

		$needed_amt = ( $needed_amt ) ? $needed_amt : 1;

		return $needed_amt;
	}

	/**
	 * Donate Single project or cause.
	 *
	 * @param  array $_post Array of posted data.
	 * @return void
	 */
	public function donateNow( $_post ) {

		$purpose = array_get( $_post, 'extras.donation_purpose' );
		$custom_purpose = array_get( $_post, 'extras.custom_donation_purpose' );

		$user_info = array_map( 'sanitize_text_field', webinane_set( $_POST, 'info' ) );
		$cc = sanitize_text_field( webinane_set( $_POST, 'cc' ) );
		$currency = sanitize_text_field( webinane_set( $_POST, 'currency' ) );
		$amount = sanitize_text_field( webinane_set( $_POST, 'amount' ) );
		$gateway = sanitize_text_field( webinane_set( $_POST, 'gateway' ) );
		$recurring = sanitize_text_field( webinane_set( $_POST, 'recurring' ) );

		wpcm_empty_cart();

		switch ( $purpose ) {
			case 'all_projects_causes':
				$this->addBothToCart( $amount );
				break;
			case 'all_projects':
				$this->addProjectsToCart( $amount );
				break;
			case 'all_causes':
				$this->addCausesToCart( $amount );
				break;
			case 'custom':
				$this->addCustomToCart( $amount, $custom_purpose );
				break;
			default:
				do_action("lifeline_donation/general/{$purpose}/donate_now", $_post);
				break;

		}

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

		if ( is_email( webinane_set( $user_info, 'email' ) ) ) {
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

	/**
	 * Add projects to cart.
	 *
	 * @param float $amount Amount.
	 */
	private function addProjectsToCart( $amount ) {

		$projects = get_posts( array( 'post_type' => 'project', 'posts_per_page' => -1 ) );

		$this->addToCart( $projects, $amount );

		return true;
	}

	/**
	 * Add causes to cart.
	 *
	 * @param float $amount Amount.
	 */
	private function addCausesToCart( $amount ) {

		$causes = get_posts( array( 'post_type' => 'cause', 'posts_per_page' => -1 ) );

		$this->addToCart( $causes, $amount );

		return true;
	}

	/**
	 * Add both, projects and causes to cart.
	 *
	 * @param float $amount Amount.
	 */
	private function addBothToCart( $amount ) {

		$items = get_posts( array( 'post_type' => array( 'cause', 'project' ), 'posts_per_page' => -1 ) );

		$this->addToCart( $items, $amount );

		return true;
	}

	/**
	 * Add custom types to cart.
	 *
	 * @param float $amount Amount.
	 * @param array $ids    List of ids.
	 */
	private function addCustomToCart( $amount, $ids ) {

		$items = get_posts(
			array(
				'post_type' => 'any',
				'post__in' => $ids,
				'posts_per_page' => -1
			)
		);

		$this->addToCart( $items, $amount );

		return true;
	}

	/**
	 * Add to cart.
	 *
	 * @param array   $items  Items list.
	 * @param integer $amount Amount.
	 */
	private function addToCart( $items, $amount ) {

		if ( $items ) {
			$split_amount = (float) ( $amount / count( $items ) );
			foreach ( $items as $item ) {
				$split_amount = apply_filters( 'lifeline_donation/donate_now/donation_split_amount', $split_amount, $item, $_POST );
				wpcm_add_to_cart(
					array(
						'item_id'       => $item->ID,
						'quantity'      => 1,
						'price'         => $split_amount,
					)
				);
			}
		}
		return true;
	}

}
