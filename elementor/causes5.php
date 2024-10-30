<?php

namespace LifelineDonation\Elementor;

use Elementor\Controls_Manager;
use Elementor\Controls_Stack;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Border;

/**
 * Elementor button widget.
 *
 * Elementor widget that displays a button with the ability to control every
 * aspect of the button design.
 *
 * @since 1.0.0
 */
class Causes5 extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve button widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'wi_donation_cuases5';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve button widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Donation Causes 5', 'lifeline-donation' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve button widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-hand';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the button widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'donations' ];
	}


	/**
	 * Register button widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _register_controls() {
		$this->start_controls_section(
			'query',
			[
				'label' => esc_html__( 'Query', 'lifeline-donation' ),
			]
		);


		$this->add_control(
			'query_source',
			[
				'label'   => esc_html__( 'Source', 'lifeline-donation' ),
				'type'    => Controls_Manager::SELECT2,
				'default' => '',
				'options' => wp_list_pluck( get_post_types( array( 'publicly_queryable' => true ), 'object' ), 'label', 'name' ),
			]
		);

		$this->add_control(
			'query_number',
			[
				'label'   => esc_html__( 'Number', 'lifeline-donation' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 2,
				'min'     => 1,
				'max'     => 100,
				'step'    => 1
			]
		);
		$this->add_control(
			'query_orderby',
			[
				'label'   => esc_html__( 'Order By', 'lifeline-donation' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'date',
				'options' => array(
					'date'       => esc_html__( 'Date', 'lifeline-donation' ),
					'title'      => esc_html__( 'Title', 'lifeline-donation' ),
					'menu_order' => esc_html__( 'Menu Order', 'lifeline-donation' ),
					'rand'       => esc_html__( 'Random', 'lifeline-donation' ),
				)
			]
		);
		$this->add_control(
			'query_order',
			[
				'label'   => esc_html__( 'Order', 'lifeline-donation' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'DESC',
				'options' => array(
					'DESc' => esc_html__( 'DESC', 'lifeline-donation' ),
					'ASC'  => esc_html__( 'ASC', 'lifeline-donation' ),
				)
			]
		);
		$this->add_control(
			'query_ignore_sticky',
			[
				'label'   => esc_html__( 'Igonore Stikcy posts', 'lifeline-donation' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => '',
			]
		);


		$this->end_controls_section();
	}

	/**
	 * Render button widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		$settings = webinane_array( $settings );

		$this->add_render_attribute( 'wrapper', 'class', 'wpcm-wrapper urgent-popup-list' );

		$query = new \WP_Query( array(
			'post_type'      => $settings->get( 'query_source' ),
			'posts_per_page' => $settings->get( 'query_number' ),
			'orderby'        => $settings->get( 'query_orderby' ),
			'order'          => $settings->get( 'query_order' ),
		) );

		if ( $query->have_posts() ) {
			wp_enqueue_style( array( 'webinane-shortcodes' ) );
			$file = get_theme_file_path( 'templates/elementor/causes5.php' );

			if ( file_exists( $file ) ) {
				include $file;
			} else {
				include LIFELINE_DONATION_PATH . 'elementor/output/causes5.php';
			}
		}
		wp_reset_postdata();
	}

}
