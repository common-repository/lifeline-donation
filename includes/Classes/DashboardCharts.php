<?php
/**
 * Dashboard charts.
 *
 * @package WordPress
 */

namespace LifelineDonation\Classes;

use Illuminate\Support\Carbon;
use WeDevs\ORM\WP\Post;
use WebinaneCommerce\Models\Order;
use WebinaneCommerce\Models\OrderItems;

/**
 * Dashboard Charts.
 */
class DashboardCharts {

	/**
	 * $months
	 *
	 * @var array
	 */
	private static $months = array();
	/**
	 * $project_ids
	 *
	 * @var array
	 */
	private static $project_ids = array();
	/**
	 * $cause_ids
	 *
	 * @var array
	 */
	private static $cause_ids = array();

	/**
	 * $cause_ids
	 *
	 * @var array
	 */
	private static $groupby = 'day';

	private static $start_date = '';

	private static $end_date = '';
	
	/**
	 * Init
	 *
	 * @return void
	 */
	public static function init() {
		add_filter( 'webinane_commerce/dashboard/charts', array( __CLASS__, 'charts' ), 100, 3 );
		self::$months = self::getMonths();
	}

	/**
	 * Charts.
	 *
	 * @param  array $charts The charts.
	 * @return array
	 */
	public static function charts( $charts, $start_date, $end_date ) {

		$ids = self::getIds( 'project' );
		self::$groupby = sanitize_text_field( array_get($_GET, 'groupby') );

		self::$start_date = Carbon::parse($start_date);
		self::$end_date = Carbon::parse($end_date);

		$myprojects = self::getProjects();
		$charts[] = array(
			'series'    => $myprojects['data'],
			'xAxis' => array(array('categories' => $myprojects['axis'])),
			'title' => esc_html__( 'Projects Gross Revenue', 'lifeline-donation' ),
			'id'    => 'projects-gross-revenue',
		);

		$mycauses = self::getCauses();
		$charts[] = array(
			'series'    => $mycauses['data'],
			'xAxis' => array(array('categories' => $mycauses['axis'])),
			'title' => esc_html__( 'Charities Gross Revenue', 'lifeline-donation' ),
			'id'    => 'causes-gross-revenue',
		);

		$mygeneral = self::getGeneral();
		$charts[] = array(
			'series'    => $mygeneral['data'],
			'xAxis' => array(array('categories' => $mygeneral['axis'])),
			'title' => esc_html__( 'General Gross Revenue', 'lifeline-donation' ),
			'id'    => 'general-gross-revenue',
		);

		$myothers = self::otherDonations();

		$charts[] = array(
			'series'    => $myothers['data'],
			'xAxis' => array(array('categories' => $myothers['axis'])),
			'title' => esc_html__( 'Others Gross Revenue', 'lifeline-donation' ),
			'id'    => 'others-gross-revenue',
		);

		$mytotalcharts = self::getTotalChart();
		$charts[] = array(
			'series'    => $mytotalcharts['data'],
			'xAxis' => array(array('categories' => $mytotalcharts['axis'])),
			'title' => esc_html__( 'Total Revenue to Date', 'lifeline-donation' ),
			'id'    => 'others-gross-revenue',
		);
		$mytotalcharts = self::recurringDonations();
		$charts[] = array(
			'series'    => $mytotalcharts['data'],
			'xAxis' => array(array('categories' => $mytotalcharts['axis'])),
			'title' => esc_html__( 'Recurring Donations to Date', 'lifeline-donation' ),
			'id'    => 'others-gross-revenue',
		);

		$charts = apply_filters( 'lifeline_donations/charts/data', $charts );
		return $charts;
	}

	/**
	 * xAxis.
	 *
	 * @return array
	 */
	private static function xAxis() {

		return array(
			array(
				'categories' => self::getFormattedMonths(),
			),
		);
	}

	/**
	 * Series.
	 *
	 * @param  array $data Array of data.
	 * @return array
	 */
	private static function series( $data, $label = '' ) {

		$start = date( get_option( 'date_format' ), strtotime( self::$months[0] ) );
		$end = date( get_option( 'date_format' ), strtotime( end( self::$months ) ) );
		$total = webinane_cm_price_with_symbol( array_sum( $data ) );
		if( ! $label ) {
			$label = $total . ' <span>Last 12 Months (' . $start . ' - ' . $end . ')</span>';
		}
		return array(
			array(
				'name' => $label,
				'data'  => array_values( $data ),
			),
		);
	}

	/**
	 * Get months array.
	 *
	 * @return array
	 */
	private static function getMonths() {
		$months[] = date( 'Y-m-d h:i:s' );

		for ( $i = 1; $i < 12; $i++ ) {
			$months[] = date( 'Y-m-d h:i:s', strtotime( "-$i month" ) );
		}
		sort( $months );

		return $months;
	}

	/**
	 * [getFormattedMonths description]
	 *
	 * @return [type] [description]
	 */
	private static function getFormattedMonths() {
		$months = array();

		foreach ( self::$months as $month ) {
			$months[] = date( 'M', strtotime( $month ) );
		}

		return $months;
	}

	/**
	 * Group the data.
	 *
	 * @param  Collection $data Collection of data.
	 * @return array
	 */
	private static function getTheData($data) {

		$format1 = 'Y-m-d';
		$format2 = 'd M Y';
		if(self::$groupby == 'month') {
			$format1 = 'Y-m';
			$format2 = 'M Y';
		} elseif( self::$groupby == 'week') {
			$format1 = 'Y-m-W';
			$format2 = 'W Y';
		}

		$group = $data->groupBy(function($val) use ($format1) {
			return Carbon::parse($val->date)->format($format1);
		});

		$price = [];
		$number = [];
		foreach($group as $key => $gr) {
			$price[Carbon::parse($key)->format($format2)] = $gr->sum('price');
			$number[Carbon::parse($key)->format($format2)] = $gr->sum('qty');
		}

		return compact('price', 'number');
	}
	/**
	 * Get Projects data.
	 *
	 * @return array
	 */
	private static function getProjects() {
		$ids = self::getIds( 'project' );
		self::$project_ids = $ids;

		$orders = OrderItems::whereHas(
			'order',
			function( $query ) use ( $ids ) {
				return $query->where( 'post_date', '>=', self::$start_date )->where( 'post_date', '<=', self::$end_date );
			}
		)->whereIn( 'post_id', $ids );

		$orders = apply_filters( 'lifeline_donations/chart/orders_query/projects', $orders );

		$orders = $orders->get();

		$groupedData = self::getTheData($orders);

		$price = $groupedData['price'];
		$number = $groupedData['number'];

		$label = esc_html__('Total Amount collected for Projects', 'lifeline-donation');
		$label1 = esc_html__('Total number of donations made', 'lifeline-donation');

		return ['axis' => array_keys($price), 'data' => array_merge(self::series($price, $label), self::series($number, $label1))];
	}

	/**
	 * Get Projects data.
	 *
	 * @return array
	 */
	private static function getCauses() {
		$ids = self::getIds( 'cause' );
		self::$cause_ids = $ids;
		
		$orders = OrderItems::whereHas(
			'order',
			function( $query ) use ( $ids ) {
				return $query->where( 'post_date', '>=', self::$start_date )->where( 'post_date', '<=', self::$end_date );
			}
		)->whereIn( 'post_id', $ids );

		$orders = apply_filters( 'lifeline_donations/chart/orders_query/causes', $orders );

		$orders = $orders->get();

		$groupedData = self::getTheData($orders);

		$price = $groupedData['price'];
		$number = $groupedData['number'];

		$label = esc_html__('Total Amount collected for Charities', 'lifeline-donation');
		$label1 = esc_html__('Total number of donations made', 'lifeline-donation');

		return ['axis' => array_keys($price), 'data' => array_merge(self::series($price, $label), self::series($number, $label1))];
	}
	/**
	 * Get Projects data.
	 *
	 * @return array
	 */
	private static function getGeneral() {

		$page_id = wpcm_get_settings()->get( 'donation_dummy_page_select' );
		
		$orders = OrderItems::whereHas(
			'order',
			function( $query ) {
				return $query->where( 'post_date', '>=', self::$start_date )->where( 'post_date', '<=', self::$end_date );
			}
		)->where( 'post_id', $page_id );

		$orders = apply_filters( 'lifeline_donations/chart/orders_query/general', $orders );

		$orders = $orders->get();

		$groupedData = self::getTheData($orders);

		$price = $groupedData['price'];
		$number = $groupedData['number'];

		$label = esc_html__('Total Amount collected for General', 'lifeline-donation');
		$label1 = esc_html__('Total number of donations made', 'lifeline-donation');

		return ['axis' => array_keys($price), 'data' => array_merge(self::series($price, $label), self::series($number, $label1))];
	}

	/**
	 * [otherDonations description]
	 *
	 * @return [type] [description]
	 */
	private static function otherDonations() {

		$page_id = wpcm_get_settings()->get( 'donation_dummy_page_select' );
		
		$orders = OrderItems::whereHas(
			'order',
			function( $query ) {
				return $query->where( 'post_date', '>=', self::$start_date )->where( 'post_date', '<=', self::$end_date );
			}
		)->where( 'post_id', $page_id )->whereNotIn('post_id', self::$project_ids)->whereNotIn('post_id', self::$cause_ids);

		$orders = apply_filters( 'lifeline_donations/chart/orders_query/others', $orders );

		$orders = $orders->get();

		$groupedData = self::getTheData($orders);

		$price = $groupedData['price'];
		$number = $groupedData['number'];

		$label = esc_html__('Total Amount collected for Others', 'lifeline-donation');
		$label1 = esc_html__('Total number of donations made', 'lifeline-donation');

		return ['axis' => array_keys($price), 'data' => array_merge(self::series($price, $label), self::series($number, $label1))];
	}


	/**
	 * Get post ids.
	 *
	 * @param  string $post_type Array of post types.
	 * @return Collection
	 */
	static function getIds( $post_type = 'project' ) {
		$post_type = is_array( $post_type ) ? $post_type : array( $post_type );
		return Post::whereIn( 'post_type', $post_type )->pluck( 'ID' );
	}

	/**
	 * Get total chart.
	 *
	 * @return array.
	 */
	static function getTotalChart() {

		$orders = OrderItems::get();

		$groupedData = self::getTheData($orders);

		$price = $groupedData['price'];
		$number = $groupedData['number'];

		$label = esc_html__('Total Amount collected for Others', 'lifeline-donation');
		$label1 = esc_html__('Total number of donations made', 'lifeline-donation');

		return ['axis' => array_keys($price), 'data' => array_merge(self::series($price, $label), self::series($number, $label1))];
	}

	/**
	 * Get total chart.
	 *
	 * @return array.
	 */
	static function recurringDonations() {

		$orders = OrderItems::whereHas(
			'order',
			function( $query ) {
				return $query->whereHas('meta', function($query) {
					$query->where('meta_key', '_wpcm_is_recurring')->where('meta_value', true);
				});
			}
		);

		$orders = apply_filters( 'lifeline_donations/chart/orders_query/recurring', $orders );

		$orders = $orders->get();

		$groupedData = self::getTheData($orders);

		$price = $groupedData['price'];
		$number = $groupedData['number'];

		$label = esc_html__('Total Amount recurring Donations', 'lifeline-donation');
		$label1 = esc_html__('Total number of donations made', 'lifeline-donation');

		return ['axis' => array_keys($price), 'data' => array_merge(self::series($price, $label), self::series($number, $label1))];
	}
	
}
