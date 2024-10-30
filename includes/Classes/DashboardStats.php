<?php
/**
 * Dashboard stats.
 *
 * @package WordPress
 */

namespace LifelineDonation\Classes;

use Illuminate\Support\Carbon;
use WeDevs\ORM\WP\Post;
use WebinaneCommerce\Models\Order;
use WebinaneCommerce\Models\OrderItems;

/**
 * Dashboard Stats.
 */
class DashboardStats {

	/**
	 * $project_ids;
	 *
	 * @var array
	 */
	private static $project_ids;

	/**
	 * $cause_ids
	 *
	 * @var array
	 */
	private static $cause_ids;

	private static $start_date = '';

	private static $end_date = '';

	/**
	 * Init
	 *
	 * @return void
	 */
	public static function init() {
		add_filter( 'webinane_commerce/dashboard/stats', array( __CLASS__, 'stats' ), 100, 3 );
	}

	/**
	 * Stats
	 *
	 * @param  array $stats Array of stats.
	 *
	 * @return array
	 */
	public static function stats( $stats, $start_date, $end_date ) {

		$projects = self::projectsData();
		$causes = self::causesData();
		$general = self::generalDonations();

		self::$start_date = Carbon::parse( $start_date );
		self::$end_date = Carbon::parse( $end_date );


		$stats[] = array(
			'id' => 'show-projects-revenue',
			'earnings' => number_format( $projects['now'], 2 ),
			'title' => esc_html__( 'Projects Revenue', 'lifeline-donation' ),
			'percentage' => $projects['percent'] . '%',
			'prevearnings' => webinane_cm_price_with_symbol( $projects['old'] ),
			'prevtitle' => esc_html__( 'Previous Year', 'lifeline-donation' ),
			'color'  => 'clr1',
		);

		$stats[] = array(
			'id' => 'show-causes-revenue',
			'earnings' => number_format( $causes['now'], 2 ),
			'title' => esc_html__( 'Causes Revenue', 'lifeline-donation' ),
			'percentage' => $causes['percent'] . '%',
			'prevearnings' => webinane_cm_price_with_symbol( $causes['old'] ),
			'prevtitle' => esc_html__( 'Previous Year', 'lifeline-donation' ),
			'color'  => 'clr2',
		);

		$stats[] = array(
			'id' => 'show-general-revenue-stats',
			'earnings' => number_format( $general['now'], 2 ),
			'title' => esc_html__( 'General Donation Revenue', 'lifeline-donation' ),
			'percentage' => number_format( $general['percent'] ) . '%',
			'prevearnings' => webinane_cm_price_with_symbol( $general['old'] ),
			'prevtitle' => esc_html__( 'Previous Year', 'lifeline-donation' ),
			'color'  => 'clr3',
		);

		$stats[] = array(
			'id' => 'show-total-revenue-stats',
			'earnings' => number_format( self::getAllDonations(), 2 ),
			'title' => esc_html__( 'Donations all the time', 'lifeline-donation' ),
			'percentage' => '100%',
			'prevearnings' => null,
			'prevtitle' => null,
			'color'  => 'clr4',
		);
		$stats[] = array(
			'id' => 'show-pending-revenue-stats',
			'earnings' => number_format( self::getAllDonations( 'pending_payment' ), 2 ),
			'title' => esc_html__( 'Pending Donations', 'lifeline-donation' ),
			'percentage' => '100%',
			'prevearnings' => null,
			'prevtitle' => null,
			'color'  => 'clr5',
		);
		$stats[] = array(
			'id' => 'show-cancelled-revenue-stats',
			'earnings' => number_format( self::getAllDonations( 'cancelled' ), 2 ),
			'title' => esc_html__( 'Cancelled Donations', 'lifeline-donation' ),
			'percentage' => '100%',
			'prevearnings' => null,
			'prevtitle' => null,
			'color'  => 'clr6',
		);

		$stats = apply_filters( 'lifeline_donations/stats/data', $stats );

		return $stats;
	}

	/**
	 * Get Data.
	 *
	 * @param  array  $ids     Array of ids.
	 * @param  string $status Order status.
	 * @return array
	 */
	private static function getData( $ids, $status ) {
		$now = OrderItems::whereHas(
			'order',
			function( $query ) use ( $status ) {
				return $query->where( 'post_date', '>=', self::currentFirst() )->where( 'post_date', '<=', self::currentLast() )->status( $status );
			}
		)->whereIn( 'post_id', $ids )->sum( 'price' );

		$old = OrderItems::whereHas(
			'order',
			function( $query ) use ( $status ) {
				return $query->where( 'post_date', '>=', self::prevFirst() )->where( 'post_date', '<=', self::prevLast() )->status( $status );
			}
		)->whereIn( 'post_id', $ids )->sum( 'price' );

		return array(
			'now'       => $now,
			'old'       => $old,
			'percent'   => ( ! $old ) ? 100 : ( $now / ( $old ?: 1 ) ) * 100,
		);
	}

	/**
	 * Projects data.
	 *
	 * @param  string $status Order status.
	 * @return array
	 */
	private static function projectsData( $status = 'completed' ) {

		$ids = self::getIds();
		self::$project_ids = $ids;

		return self::getData( $ids, $status );
	}

	/**
	 * Get causes data.
	 *
	 * @param  string $status Order status.
	 * @return array
	 */
	private static function causesData( $status = 'completed' ) {

		$ids = self::getIds( 'cause' );
		self::$cause_ids = $ids;

		return self::getData( $ids, $status );
	}



	/**
	 * Get total of order items.
	 *
	 * @param Order $orders Object of orders.
	 * @param array $ids    Array of ids.
	 *
	 * @return Integer
	 */
	private static function sum( $orders, $ids ) {
		$sum = 0;

		foreach ( $orders as $order ) {

			$sum += $order->items()->where( 'post_id', $ids )->sum( 'price' );
		}

		return $sum;
	}

	/**
	 * Get post ids.
	 *
	 * @param  string $post_type array or string of post type.
	 * @return Collection
	 */
	private static function getIds( $post_type = 'project' ) {
		$post_type = is_array( $post_type ) ? $post_type : array( $post_type );
		
		$query = Post::whereIn( 'post_type', $post_type );

		foreach($post_type as $p_type) {
			$query = apply_filters( "lifeline_donations/stats/{$p_type}/get_ids", $query );
		}

		$ids = $query->pluck('ID');

		return $ids;
	}


	/**
	 * Get first day of current year.
	 *
	 * @return string
	 */
	private static function currentFirst() {
		return date( 'Y-m-d h:i:s', strtotime( 'first day of january this year' ) );
	}

	/**
	 * Get last day of current year.
	 *
	 * @return string
	 */
	private static function currentLast() {
		return date( 'Y-m-d h:i:s', strtotime( 'last day of december this year' ) );
	}

	/**
	 * Get first day of previous year.
	 *
	 * @return string
	 */
	private static function prevFirst() {
		return date( 'Y-m-d h:i:s', strtotime( 'first day of january last year' ) );
	}

	/**
	 * Get last day of previous year.
	 *
	 * @return string
	 */
	private static function prevLast() {
		return date( 'Y-m-d h:i:s', strtotime( 'last day of december last year' ) );
	}

	/**
	 * General Donation
	 *
	 * @return [type] [description]
	 */
	private static function generalDonations() {

		$page_id = wpcm_get_settings()->get( 'donation_dummy_page_select' );

		$ids = array_merge( self::$project_ids->toArray(), self::$cause_ids->toArray() );

		$now = OrderItems::whereHas(
			'order',
			function( $query ) {
				$query->where( 'post_date', '>', self::currentFirst() )->where( 'post_date', '<', self::currentLast() );
			}
		)->whereNotIn( 'post_id', $ids );

		$now = apply_filters( 'lifeline_donations/stats/general/now', $now );
		$now = $now->sum( 'price' );

		$old = OrderItems::whereHas(
			'order',
			function( $query ) {
				$query->where( 'post_date', '>', self::prevFirst() )->where( 'post_date', '<', self::prevLast() );
			}
		)->whereNotIn( 'post_id', $ids );

		$old = apply_filters( 'lifeline_donations/stats/general/old', $old );
		$old = $old->sum( 'price' );

		return array(
			'now'       => $now,
			'old'       => $old,
			'percent'   => ( ! $old ) ? 100 : ( $now / ( $old ?: 1 ) ) * 100,
		);

	}

	/**
	 * Get all donations.
	 *
	 * @param  string $status Order status.
	 * @return number
	 */
	private static function getAllDonations( $status = null ) {

		$orders = OrderItems::whereHas(
			'order',
			function( $query ) use ( $status ) {
				if ( $status ) {
					$query->status( $status );
				}
			}
		)->sum( 'price' );

		return $orders;
	}

}
