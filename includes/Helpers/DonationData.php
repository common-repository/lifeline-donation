<?php

namespace LifelineDonation\Helpers;

use WebinaneCommerce\Models\OrderItems;
use WP_User;
use WP_Error;

trait DonationData
{

	function getCurrencies() {
		$settings = wpcm_get_settings();
		$is_multi_cr = $settings->get( 'donation_multicurrency' );

		if ( 'false' === $is_multi_cr ) {
			$is_multi_cr = false;
		}

		if ( $is_multi_cr && $settings->get( 'selective_currency' ) == '' ) {
			$currencies = wpcm_currency_assos_data();
		} elseif ( $is_multi_cr && $settings->get( 'selective_currency' ) != '' ) {

			$currencies_selected = $settings->get( 'selective_currency' );
			$currencies_selected = array_filter( $currencies_selected );
			$all_currencies = wpcm_currency_assos_data();
			$currencies  = array();
			foreach ( $currencies_selected  as $selected_c ) {
				$currencies[ $selected_c ] = webinane_set( $all_currencies, $selected_c );
			}

		} else {
			$currencies = array('USD' => esc_html__( 'US Dollar', 'lifeline-donation' ));
		}

		return $currencies;
	}

	/**
	 * Get dropdown.
	 * 
	 * @return array
	 */
	function getDropdown() {

		$settings = wpcm_get_settings();
		if ( $settings->get( 'enable_custom_dropdown' ) && $settings->get( 'donation_custom_dropdown' ) != '' ) {
			$dropdown = $settings->get( 'donation_custom_dropdown' );
		} else {
			$dropdown = array();
		}

	}

	/**
	 * Get Predefined amounts.
	 * 
	 * @return array
	 */
	function getPredefinedAmount() {

		$settings = wpcm_get_settings();
		if ( $settings->get( 'donation_predefined_amounts' ) ) {
			$amount = $settings->get( 'donation_predefined_amounts_list' );
		} else {
			$amount = array();
		}

		return $amount;

	}

	/**
	 * Get collected amount of a sepecific post type.
	 *
	 * @param  array|string  $post_types
	 * @param  boolean $formatted
	 * @return mix
	 */
	function getCollectedAmount($post_types, $ids = [], $formatted = false) {

		if(! $ids) {
			$posts = (array) get_posts(['post_type' => $post_types]);
			$post_ids = wp_list_pluck( $posts, 'ID' );
		} else {
			$post_ids = is_array($ids) ? $ids : [$ids];
		}

		$total = OrderItems::whereHas('order', function($query){
			$query->where('post_status', 'completed');
		})->whereIn('post_id', $post_ids)->sum('price');

		if($formatted) {
			return webinane_cm_price_with_symbol($total);
		}

		return $total;

	}

	/**
	 * Get needed amount.
	 * 
	 * @param  object $post
	 * @return Number
	 */
	function getNeededAmount($post) {

		$post_id = $post->ID;

		$settings = wpcm_get_settings();

		$needed_amt = 0;
		if ( webinane_set( $post, 'post_type' ) == 'lif_story' ) {
			$needed_amt = get_post_meta( $post_id, 'project_cost', true );
		} elseif ( webinane_set( $post, 'post_type' ) == 'page' ) {
			$needed_amt = $settings->get( 'donation_general_amount' );

		} else {
			$meta_key = ( webinane_set( $post, 'post_type' ) == 'cause' ) ? 'causes_settings' : 'project_settings';

			$meta = get_post_meta( $post_id, $meta_key, true );

			$needed_amt = webinane_set( $meta, 'donation' );
			$needed_amt = ( $needed_amt ) ? $needed_amt : 100;
		}

		return $needed_amt;

	}

	/**
	 * Create new user if not exists.
	 * 
	 * @param  [type] $user_info [description]
	 * @return [type]            [description]
	 */
	function createUser($user_info) {

		$email = sanitize_email( webinane_set( $user_info, 'email' ) );

		if ( ! $email ) {
			wp_send_json_error( esc_html__( 'Please provide a valid email', 'lifeline-donation' ) );
		}

		$user_id = username_exists( $email );
		$user_id = ( $user_id ) ? $user_id : email_exists( $email );

		if ( ! $user_id && false == email_exists( $email ) ) {
			$random_password = wp_generate_password();
			$user_id = wp_create_user( $email, $random_password, $email );
			if ( is_wp_error( $user_id ) ) {
				wp_send_json_error( $user_id->get_error_message() );
			}
			wp_send_new_user_notifications( $user_id, 'both' );
			$user = new WP_User( $user_id );
		} else {

			$user = new WP_User( $user_id );
		}

		return $user;

	}

	/**
	 * Array filter deep
	 *
	 * @param  [type] $array    [description].
	 * @param  [type] $callback [description].
	 *
	 * @return [type]           [description]
	 */
	public function array_filter_deep( $array, $callback ) {

		if ( is_array( $array ) ) {
			foreach ( $array as $key => $arr ) {
				if ( is_array( $arr ) ) {
					$array[ $key ] = $this->array_filter_deep( $arr, $callback );
				} else {
					$array[ $key ] = call_user_func_array( $callback, array( $arr ) );
				}
			}
		} else {
			$array = call_user_func_array( $callback, array( $array ) );
		}

		return $array;
	}
}