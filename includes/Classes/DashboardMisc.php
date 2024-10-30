<?php
/**
 * Webinane Commerce misc class.
 *
 * @package WordPress
 */

namespace LifelineDonation\Classes;

use WebinaneCommerce\Models\Post;

/**
 * Misc hander class for webinane commerce
 */
class DashboardMisc {

	/**
	 * Init
	 *
	 * @return void
	 */
	public static function init() {
		add_filter( 'webinane_commerce/dashboard/menus', array( __CLASS__, 'menus' ) );

		add_filter( 'webinane_commerce/dashboard/tables', array( __CLASS__, 'tables' ), 50, 3 );
	}

	/**
	 * Dashboard Menus
	 *
	 * @param  array $menus Menus.
	 * @return array
	 */
	public static function menus( $menus ) {
		$menus[] = array(
			'label'     => esc_html__( 'Donations', 'lifeline-donation' ),
			'link'      => admin_url( 'edit.php?post_type=orders' ),
			'icon'      => '<img src="' . WNCM_URL . 'assets/images/icons/menu-icon2.png" />',
		);

		return $menus;
	}

	/**
	 * Dashboard tables.
	 *
	 * @param  array $tables Table.
	 * @return array
	 */
	public static function tables( $tables, $query, $id ) {

		$data[] = array(
			'title' => esc_html__( 'Top Donating Projects', 'lifeline-donation' ),
			'placeholder' => esc_html__( 'Or search for specific Project', 'lifeline-donation' ),
			'id'	=> 'lifeline-donation-top-donating-project',
			'cols'  => array(
				array(
					'label' => esc_html__( 'Title', 'lifeline-donation' ),
					'prop' => 'title',
					'width'	=> '170px'
				),
				array(
					'label' => esc_html__( 'Number', 'lifeline-donation' ),
					'prop' => 'number',
				),
				array(
					'label' => esc_html__( 'Donors', 'lifeline-donation' ),
					'prop' => 'customers',
				),
				array(
					'label' => esc_html__( 'Total', 'lifeline-donation' ),
					'prop' => 'sum',
				),
				array(
					'label' => esc_html__( 'Average', 'lifeline-donation' ),
					'prop' => 'average',
				),
				
			),
			'data' => self::topProjects( 'project', $query, $id ),
		);
		$data[] = array(
			'title' => esc_html__( 'Top Donating Charities', 'lifeline-donation' ),
			'placeholder' => esc_html__( 'Or search for specific Charity', 'lifeline-donation' ),
			'id'	=> 'lifeline-donation-top-donating-cause',
			'cols'  => array(
				array(
					'label' => esc_html__( 'Title', 'lifeline-donation' ),
					'prop' => 'title',
					'width'	=> '170px'
				),
				array(
					'label' => esc_html__( 'Number', 'lifeline-donation' ),
					'prop' => 'number',
				),
				array(
					'label' => esc_html__( 'Donors', 'lifeline-donation' ),
					'prop' => 'customers',
				),
				array(
					'label' => esc_html__( 'Total', 'lifeline-donation' ),
					'prop' => 'sum',
				),
				array(
					'label' => esc_html__( 'Average', 'lifeline-donation' ),
					'prop' => 'average',
				),
				
			),
			'data' => self::topProjects( 'cause', $query, $id ),
		);

		return $data;
	}

	/**
	 * Top projects.
	 *
	 * @return void
	 */
	private static function topProjects( $post_type, $query = '', $id = '' ) {

		$projects = Post::whereHas(
			'orders.order',
			function( $query ) {
				$query->status( 'completed' );
			}
		)->type( $post_type )->status( 'publish' );

		if($query) {
			if($id === 'lifeline-donation-top-donating-' . $post_type) {
				$projects->where('post_title', 'like', '%'.$query.'%');
			}
		}

		$projects = $projects->get();

		$new_data = array();

		if ( $projects ) {
			foreach ( $projects as $proj ) {

				$customers = $proj->orders->groupBy(function($value){
					return ($value->customer) ? $value->customer->id : 1;
				});
				$customers = $customers->count();
				$sum = $proj->orders->sum( 'price' );

				$new_data[] = array(
					'title' => '<a href="'.get_permalink( $proj->ID ).'">'.$proj->post_title.'</a>',
					'link'  => get_permalink( $proj->ID ),
					'sum'   => webinane_cm_price_with_symbol($sum),
					'number'    => $proj->orders->sum( 'qty' ),
					'customers'	=> $customers,
					'average' => ($customers) ? number_format($sum / $customers, 2) : 1
				);
			}
		}
		return $new_data;
	}
}
