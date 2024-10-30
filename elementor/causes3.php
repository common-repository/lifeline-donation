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
class Causes3 extends \Elementor\Widget_Base {

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
        return 'wi_donation_cuases3';
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
        return esc_html__( 'Donation Causes 3', 'lifeline-donation' );
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
                'label' => esc_html__( 'Source', 'lifeline-donation' ),
                'type' => Controls_Manager::SELECT2,
                'default' => '',
                'options' => wp_list_pluck( get_post_types(array('publicly_queryable' => true), 'object'), 'label', 'name' ),
            ]
        );

        $this->add_control(
            'query_number',
            [
                'label' => esc_html__( 'Number', 'lifeline-donation' ),
                'type' => Controls_Manager::NUMBER,
                'default' => 2,
                'min'       => 1,
                'max'   => 100,
                'step'  => 1
            ]
        );
        $this->add_control(
            'query_orderby',
            [
                'label' => esc_html__( 'Order By', 'lifeline-donation' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'date',
                'options'   => array(
                    'date'      => esc_html__( 'Date', 'lifeline-donation' ),
                    'title'      => esc_html__( 'Title', 'lifeline-donation' ),
                    'menu_order'      => esc_html__( 'Menu Order', 'lifeline-donation' ),
                    'rand'      => esc_html__( 'Random', 'lifeline-donation' ),
                )
            ]
        );
        $this->add_control(
            'query_order',
            [
                'label' => esc_html__( 'Order', 'lifeline-donation' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'DESC',
                'options'   => array(
                    'DESc'      => esc_html__( 'DESC', 'lifeline-donation' ),
                    'ASC'      => esc_html__( 'ASC', 'lifeline-donation' ),
                )
            ]
        );
        $this->add_control(
            'query_ignore_sticky',
            [
                'label' => esc_html__( 'Igonore Stikcy posts', 'lifeline-donation' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => '',
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'donation_button',
            [
                'label' => esc_html__( 'Donation Button', 'lifeline-donation' ),
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label' => esc_html__( 'Button Text', 'lifeline-donation' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Doation Now', 'lifeline-donation'),
            ]
        );
        $this->add_control(
            'button_type',
            [
                'label' => esc_html__( 'Button Type', 'lifeline-donation' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'link',
                'options'   => array(
                    'link'      => esc_html__('Link', 'lifeline-donation'),
                    'donate'      => esc_html__('Donation Popup', 'lifeline-donation'),
                )
            ]
        );
        $this->add_control(
            'button_link',
            [
                'label' => esc_html__( 'Link', 'lifeline-donation' ),
                'type' => Controls_Manager::URL,
                'condition' => [
                    'button_type' => 'link',
                ],
            ]
        );

        
        $this->end_controls_section();

        /**
         * Starting section for buttoin styling
         */
        $this->start_controls_section(
            'section_style',
            [
                'label' => esc_html__( 'Button', 'lifeline-donation' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'typography',
                'scheme' => Scheme_Typography::TYPOGRAPHY_4,
                'selector' => '{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button',
            ]
        );

        $this->start_controls_tabs( 'tabs_button_style' );

        $this->start_controls_tab(
            'tab_button_normal',
            [
                'label' => esc_html__( 'Normal', 'lifeline-donation' ),
            ]
        );

        $this->add_control(
            'button_text_color',
            [
                'label' => esc_html__( 'Text Color', 'lifeline-donation' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'background_color',
            [
                'label' => esc_html__( 'Background Color', 'lifeline-donation' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_4,
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-button, {{WRAPPER}} .elementor-button > span' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_hover',
            [
                'label' => esc_html__( 'Hover', 'lifeline-donation' ),
            ]
        );

        $this->add_control(
            'hover_color',
            [
                'label' => esc_html__( 'Text Color', 'lifeline-donation' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} a.elementor-button:hover, {{WRAPPER}} .elementor-button:hover, {{WRAPPER}} a.elementor-button:focus, {{WRAPPER}} .elementor-button:focus' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_background_hover_color',
            [
                'label' => esc_html__( 'Background Color', 'lifeline-donation' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-button:hover, {{WRAPPER}} .elementor-button:hover > span, {{WRAPPER}} .elementor-button:focus, {{WRAPPER}} .elementor-button:focus > span' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_hover_border_color',
            [
                'label' => esc_html__( 'Border Color', 'lifeline-donation' ),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} a.elementor-button:hover, {{WRAPPER}} .elementor-button:hover, {{WRAPPER}} a.elementor-button:focus, {{WRAPPER}} .elementor-button:focus' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'hover_animation',
            [
                'label' => esc_html__( 'Hover Animation', 'lifeline-donation' ),
                'type' => Controls_Manager::HOVER_ANIMATION,
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();
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
        $settings = webinane_array($settings);

        $this->add_render_attribute( 'wrapper', 'class', 'wpcm-wrapper urgent-popup-list' );
        $this->add_render_attribute('button', 'class', 'wpcm-btn elementor-button wpcm-btn-green');

        if( $settings->get('button_type') == 'donate' ) {
            $this->add_render_attribute( 'button', 'href', '#' );
        } else {
            $this->add_render_attribute( 'button', 'href', $settings->get('button_link') );
        }

        $query = new \WP_Query(array(
            'post_type'         => $settings->get('query_source'),
            'posts_per_page'    => $settings->get('query_number'),
            'orderby'           => $settings->get('query_orderby'),
            'order'             => $settings->get('query_order'),
        ));

        if( $query->have_posts() ) {
            wp_enqueue_style(array('webinane-shortcodes'));
            $file = get_theme_file_path( 'templates/elementor/causes3.php' );

            if( file_exists($file)) {
                include $file;
            } else {
                include LIFELINE_DONATION_PATH . 'elementor/output/causes3.php';
            }
        }
        wp_reset_postdata();
    }

}
