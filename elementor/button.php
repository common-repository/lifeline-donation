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
class Button extends \Elementor\Widget_Base {

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
        return 'donation_button';
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
        return esc_html__( 'Donation Button', 'lifeline-donation' );
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
        return 'eicon-button';
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
     * Get button sizes.
     *
     * Retrieve an array of button sizes for the button widget.
     *
     * @since 1.0.0
     * @access public
     * @static
     *
     * @return array An array containing button sizes.
     */
    public static function get_button_sizes() {
        return [
            'xs' => esc_html__( 'Extra Small', 'lifeline-donation' ),
            'sm' => esc_html__( 'Small', 'lifeline-donation' ),
            'md' => esc_html__( 'Medium', 'lifeline-donation' ),
            'lg' => esc_html__( 'Large', 'lifeline-donation' ),
            'xl' => esc_html__( 'Extra Large', 'lifeline-donation' ),
        ];
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
            'section_button',
            [
                'label' => esc_html__( 'Button', 'lifeline-donation' ),
            ]
        );

        $this->add_control(
            'button_type',
            [
                'label' => esc_html__( 'Type', 'lifeline-donation' ),
                'type' => Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    '' => esc_html__( 'Default', 'lifeline-donation' ),
                    'info' => esc_html__( 'Info', 'lifeline-donation' ),
                    'success' => esc_html__( 'Success', 'lifeline-donation' ),
                    'warning' => esc_html__( 'Warning', 'lifeline-donation' ),
                    'danger' => esc_html__( 'Danger', 'lifeline-donation' ),
                ],
                'prefix_class' => 'elementor-button-',
            ]
        );

        $this->add_control(
            'text',
            [
                'label' => esc_html__( 'Text', 'lifeline-donation' ),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => esc_html__( 'Click here', 'lifeline-donation' ),
                'placeholder' => esc_html__( 'Click here', 'lifeline-donation' ),
            ]
        );

        $this->add_control(
            'button_action',
            [
                'label' => esc_html__( 'Action', 'lifeline-donation' ),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'link' => [
                        'title' => esc_html__( 'Link', 'lifeline-donation' ),
                        'icon' => 'fa fa-link',
                    ],
                    'donate' => [
                        'title' => esc_html__( 'Donation Popup', 'lifeline-donation' ),
                        'icon' => 'fa fa-hand-peace-o',
                    ],
                ],
                'default' => 'donate',
                'toggle' => true,
            ]
        );

        $this->add_control(
            'link',
            [
                'label' => esc_html__( 'Link', 'lifeline-donation' ),
                'type' => Controls_Manager::URL,
                'dynamic' => [
                    'active' => true,
                ],
                'placeholder' => esc_html__( 'https://your-link.com', 'lifeline-donation' ),
                'default' => [
                    'url' => '#',
                ],
                'condition' => [
                    'button_action' => 'link',
                ],
            ]
        );

        $this->add_control(
            'post_id',
            [
                'label' => esc_html__( 'Post', 'lifeline-donation' ),
                'type' => Controls_Manager::SELECT2,
                'options' => wp_list_pluck( get_posts(array('post_type' => 'any', 'posts_per_page' => 100)), 'post_title', 'ID' ),
                'default' => 1,
                'condition' => [
                    'button_action' => 'donate',
                ],
            ]
        );

        $this->add_responsive_control(
            'align',
            [
                'label' => esc_html__( 'Alignment', 'lifeline-donation' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left'    => [
                        'title' => esc_html__( 'Left', 'lifeline-donation' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'lifeline-donation' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'lifeline-donation' ),
                        'icon' => 'fa fa-align-right',
                    ],
                    'justify' => [
                        'title' => esc_html__( 'Justified', 'lifeline-donation' ),
                        'icon' => 'fa fa-align-justify',
                    ],
                ],
                'prefix_class' => 'elementor%s-align-',
                'default' => '',
            ]
        );

        $this->add_control(
            'size',
            [
                'label' => esc_html__( 'Size', 'lifeline-donation' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'sm',
                'options' => self::get_button_sizes(),
                'style_transfer' => true,
            ]
        );

        $this->add_control(
            'icon',
            [
                'label' => esc_html__( 'Icon', 'lifeline-donation' ),
                'type' => Controls_Manager::ICON,
                'label_block' => true,
                'default' => '',
            ]
        );

        $this->add_control(
            'icon_align',
            [
                'label' => esc_html__( 'Icon Position', 'lifeline-donation' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'left',
                'options' => [
                    'left' => esc_html__( 'Before', 'lifeline-donation' ),
                    'right' => esc_html__( 'After', 'lifeline-donation' ),
                ],
                'condition' => [
                    'icon!' => '',
                ],
            ]
        );

        $this->add_control(
            'icon_indent',
            [
                'label' => esc_html__( 'Icon Spacing', 'lifeline-donation' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 50,
                    ],
                ],
                'condition' => [
                    'icon!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-button .elementor-align-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .elementor-button .elementor-align-icon-left' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'view',
            [
                'label' => esc_html__( 'View', 'lifeline-donation' ),
                'type' => Controls_Manager::HIDDEN,
                'default' => 'traditional',
            ]
        );

        $this->add_control(
            'button_css_id',
            [
                'label' => esc_html__( 'Button ID', 'lifeline-donation' ),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => '',
                'title' => esc_html__( 'Add your custom id WITHOUT the Pound key. e.g: my-id', 'lifeline-donation' ),
                'label_block' => false,
                'description' => esc_html__( 'Please make sure the ID is unique and not used elsewhere on the page this form is displayed. This field allows <code>A-z 0-9</code> & underscore chars without spaces.', 'lifeline-donation' ),
                'separator' => 'before',

            ]
        );

        $this->end_controls_section();

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
                    '{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button' => 'background-color: {{VALUE}};',
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
                    '{{WRAPPER}} a.elementor-button:hover, {{WRAPPER}} .elementor-button:hover, {{WRAPPER}} a.elementor-button:focus, {{WRAPPER}} .elementor-button:focus' => 'background-color: {{VALUE}};',
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

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'border',
                'selector' => '{{WRAPPER}} .elementor-button',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'lifeline-donation' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_box_shadow',
                'selector' => '{{WRAPPER}} .elementor-button',
            ]
        );

        $this->add_responsive_control(
            'text_padding',
            [
                'label' => esc_html__( 'Padding', 'lifeline-donation' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
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
        $html = wp_kses_allowed_html( 'post' );

        $this->add_render_attribute( 'wrapper', 'class', 'elementor-button-wrapper urgent-popup-list' );

        if ( ! empty( $settings['link']['url'] ) && $settings['button_action'] == 'link' ) {
            $this->add_render_attribute( 'button', 'href', $settings['link']['url'] );
            $this->add_render_attribute( 'button', 'class', 'elementor-button-link' );

            if ( $settings['link']['is_external'] ) {
                $this->add_render_attribute( 'button', 'target', '_blank' );
            }

            if ( $settings['link']['nofollow'] ) {
                $this->add_render_attribute( 'button', 'rel', 'nofollow' );
            }
        } else {
            wp_enqueue_script(array('lifeline-donation-modal'));
            $this->add_render_attribute( 'button', 'class', 'elementor-button-link' );
            $this->add_render_attribute( 'button', 'href', '#' );
            $this->add_render_attribute( 'button', '@click.prevent', 'showModal('.$settings['post_id'].',$event)' );
            $this->add_render_attribute( 'button', 'data-post', $settings['post_id'] );
        }

        $this->add_render_attribute( 'button', 'class', 'elementor-button' );
        $this->add_render_attribute( 'button', 'role', 'button' );

        if ( ! empty( $settings['button_css_id'] ) ) {
            $this->add_render_attribute( 'button', 'id', $settings['button_css_id'] );
        }

        if ( ! empty( $settings['size'] ) ) {
            $this->add_render_attribute( 'button', 'class', 'elementor-size-' . $settings['size'] );
        }

        if ( $settings['hover_animation'] ) {
            $this->add_render_attribute( 'button', 'class', 'elementor-animation-' . $settings['hover_animation'] );
        }

        ?>
        <div <?php echo wp_kses($this->get_render_attribute_string( 'wrapper' ), $html); ?>>
            <?php if($settings['button_action'] !== 'link' && $settings['post_id']) : ?>
                <donation-button :id="<?php echo esc_attr($settings['post_id']) ?>">
                    <a <?php echo wp_kses($this->get_render_attribute_string( 'button' ), $html); ?>>
                        <?php $this->render_text(); ?>
                    </a>
                </donation-button>
            <?php else : ?>
                <a <?php echo wp_kses($this->get_render_attribute_string( 'button' ), $html); ?>>
                    <?php $this->render_text(); ?>
                </a>
            <?php endif; ?>
        </div>
        <?php
    }

    /**
     * Render button widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function _content_template() {
        ?>
        <#
        view.addRenderAttribute( 'text', 'class', 'elementor-button-text' );

        view.addInlineEditingAttributes( 'text', 'none' );
        #>
        <div class="elementor-button-wrapper">
            <a id="{{ settings.button_css_id }}" class="elementor-button elementor-size-{{ settings.size }} elementor-animation-{{ settings.hover_animation }}" href="{{ settings.link.url }}" role="button">
                <span class="elementor-button-content-wrapper">
                    <# if ( settings.icon ) { #>
                    <span class="elementor-button-icon elementor-align-icon-{{ settings.icon_align }}">
                        <i class="{{ settings.icon }}" aria-hidden="true"></i>
                    </span>
                    <# } #>
                    <span {{{ view.getRenderAttributeString( 'text' ) }}}>{{{ settings.text }}}</span>
                </span>
            </a>
        </div>
        <?php
    }

    /**
     * Render button text.
     *
     * Render button widget text.
     *
     * @since 1.5.0
     * @access protected
     */
    protected function render_text() {
        $html = wp_kses_allowed_html( 'post' );
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute( [
            'content-wrapper' => [
                'class' => 'elementor-button-content-wrapper',
            ],
            'icon-align' => [
                'class' => [
                    'elementor-button-icon',
                    'elementor-align-icon-' . $settings['icon_align'],
                ],
            ],
            'text' => [
                'class' => 'elementor-button-text',
            ],
        ] );

        $this->add_inline_editing_attributes( 'text', 'none' );
        ?>
        <span <?php echo wp_kses($this->get_render_attribute_string( 'content-wrapper' ), $html); ?>>
            <?php if ( ! empty( $settings['icon'] ) ) : ?>
            <span <?php echo wp_kses($this->get_render_attribute_string( 'icon-align' ), $html); ?>>
                <i class="<?php echo sanitize_text_field( $settings['icon'] ); ?>" aria-hidden="true"></i>
            </span>
            <?php endif; ?>
            <span <?php echo wp_kses($this->get_render_attribute_string( 'text' ), $html); ?>><?php echo wp_kses($settings['text'], $html); ?></span>
        </span>
        <?php
    }
}
