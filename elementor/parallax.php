<?php
namespace LifelineDonation\Elementor;

use Elementor\Controls_Manager;
use Elementor\Controls_Stack;

class Parallax extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'parallax';
    }

    public function get_title()
    {
        return esc_html__('Parallax', 'lifeline-donation');
    }

    public function get_icon()
    {
        return 'fa fa-code';
    }

    public function get_categories()
    {
        return ['donations'];
    }

    /**
     * Register oEmbed widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function _register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Content', 'lifeline-donation' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'image',
            [
                'label' => esc_html__('Image', 'lifeline-donation'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'description' => esc_html__('Choose the image you want to display', 'lifeline-donation'),
            ]
        );
        $repeater->add_control(
            'dimension',
            [
                'label' => esc_html__('Image Dimension', 'lifeline-donation'),
                'type' => \Elementor\Controls_Manager::IMAGE_DIMENSIONS,
                'description' => esc_html__('Crop the original image size to any custom size. Set custom width or height to keep the original size ratio.', 'lifeline-donation'),
                'default' => [
                    'width' => 350,
                    'height' => 390,
                ],
            ]
        );

        $repeater->add_control(
            'title',
            [
                'label' => esc_html__('Title', 'lifeline-donation'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'description' => esc_html__('Leave it if you don\'t want to show', 'lifeline-donation'),
            ]
        );
        $repeater->add_control(
            'text',
            [
                'label' => esc_html__('Text', 'lifeline-donation'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'description' => esc_html__('Leave it if you don\'t want to show', 'lifeline-donation'),
            ]
        );
        $repeater->add_control(
            'link',
            [
                'label' => esc_html__('Link', 'lifeline-donation'),
                'type' => \Elementor\Controls_Manager::URL,
                'description' => esc_html__('Leave it if you don\'t want to show', 'lifeline-donation'),
            ]
        );

        $this->add_control(
            'list',
            [
                'label' => esc_html__('List', 'lifeline-donation'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ title }}}',
            ]
        );

        $this->add_control(
            'carousel',
            [
                'label'         => esc_html__('Enable Carousel', 'lifeline-donation'),
                'type'          => \Elementor\Controls_Manager::SWITCHER,
                'description'   => esc_html__('Choose whether to enable owl carousel', 'lifeline-donation'),
            ]
        );
        $this->end_controls_section();
        
        /**
         * Start settings tabs with image seciont.
         */
        $this->start_controls_section(
            'image_style',
            [
                'label' => esc_html__('Image', 'lifeline-donation'),
                'tab' => \Elementor\Controls_Manager::TAB_SETTINGS,
            ]
        );
        
        $this->end_controls_section();
        
        /**
         * Started Carousel settings section.
         */
        $this->start_controls_section(
            'carousel_settings',
            [
                'label' => esc_html__('Carousel Settings', 'lifeline-donation'),
                'tab' => \Elementor\Controls_Manager::TAB_SETTINGS,
                'condition' => [
                    'carousel' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'carousel_show_arrows',
            [
                'label' => esc_html__('Show Arrows', 'lifeline-donation'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'description' => esc_html__('Show arrows on carousel', 'lifeline-donation'),
                'default'   => 'yes'
            ]
        );
        $this->add_control(
            'carousel_show_dots',
            [
                'label' => esc_html__('Show Dots', 'lifeline-donation'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'description' => esc_html__('Show dots on carousel', 'lifeline-donation'),
                'default'   => ''
            ]
        );
        $this->add_control(
            'carousel_autoplay',
            [
                'label' => esc_html__('Autoplay', 'lifeline-donation'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'description' => esc_html__('Auto play carousel', 'lifeline-donation'),
                'default'   => 'yes'
            ]
        );
        $this->add_control(
            'carousel_speed',
            [
                'label' => esc_html__('Speed (miliseconds)', 'lifeline-donation'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'description' => esc_html__('Enter the carousel speed in mili seconds', 'lifeline-donation'),
                'default'   => '500'
            ]
        );

        $this->end_controls_section();

        /**
         * Started Title Styling.
         */
        $this->start_controls_section(
            'title_styling',
            [
                'label' => esc_html__('Title', 'lifeline-donation'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs(
            'style_tabs'
        );

        $this->start_controls_tab(
            'title_style_normal_tab',
            [
                'label' => esc_html__('Normal', 'lifeline-donation'),
            ]
        );
        
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .title',
            ]
        );
        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Color', 'lifeline-donation'),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'scheme' => [
                    'type' => \Elementor\Scheme_Color::get_type(),
                    'value' => \Elementor\Scheme_Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .title' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'title_visibility',
            [
                'label' => esc_html__('Visibility', 'lifeline-donation'),
                'type'  => \Elementor\Controls_Manager::SELECT,
                'options'   => [
                    '1'      => esc_html__('Visible', 'lifeline-donation'),
                    '0'      => esc_html__('Hiddent', 'lifeline-donation'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .title' => 'transform: scale({{VALUE}})',
                ],
            ]
        );

        $this->end_controls_tab();
        
        $this->start_controls_tab(
            'title_style_hover_tab',
            [
                'label' => esc_html__('Hover', 'lifeline-donation'),
            ]
        );
        $this->add_control(
            'title_hover_color',
            [
                'label' => esc_html__('Color', 'lifeline-donation'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'scheme' => [
                    'type' => \Elementor\Scheme_Color::get_type(),
                    'value' => \Elementor\Scheme_Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .title' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'title_hover_visibility',
            [
                'label' => esc_html__('Visibility', 'lifeline-donation'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    '1' => esc_html__('Visible', 'lifeline-donation'),
                    '0' => esc_html__('Hiddent', 'lifeline-donation'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .item:hover .title' => 'transform: scale({{VALUE}})',
                ],
            ]
        );


        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography_hover',
                'selector' => '{{WRAPPER}}:hover .title',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();
        return;

        $this->add_control(
            'popover-toggle',
            [
                'label' => esc_html__('Box', 'lifeline-donation'),
                'type' => \Elementor\Controls_Manager::POPOVER_TOGGLE,
                'label_off' => esc_html__('Default', 'lifeline-donation'),
                'label_on' => esc_html__('Custom', 'lifeline-donation'),
                'return_value' => 'yes',
            ]
        );

        $this->start_popover();

        $this->add_control(
            'url',
            [
                'label' => esc_html__( 'URL to embed', 'lifeline-donation' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'input_type' => 'url',
                'placeholder' => esc_html__( 'https://your-link.com', 'lifeline-donation' ),
            ]
        );
        
        $this->end_popover();

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .title',
            ]
        );


        $this->start_controls_tabs(
            'style_tabs'
        );

        $this->start_controls_tab(
            'style_normal_tab',
            [
                'label' => esc_html__('Normal', 'lifeline-donation'),
            ]
        );

        $this->add_control(
            'url',
            [
                'label' => esc_html__('URL to embed', 'lifeline-donation'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'input_type' => 'url',
                'placeholder' => esc_html__('https://your-link.com', 'lifeline-donation'),
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'style_hover_tab',
            [
                'label' => esc_html__('Hover', 'lifeline-donation'),
            ]
        );
        $this->add_control(
            'url',
            [
                'label' => esc_html__('URL to embed', 'lifeline-donation'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'input_type' => 'url',
                'placeholder' => esc_html__('https://your-link.com', 'lifeline-donation'),
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();

    }
    /**
     * Render oEmbed widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render() {

        $settings = $this->get_settings_for_display();
        $settings = sumba_array($settings);


        $file = get_theme_file_path('template-parts/elementor/advanced-image-box.php');
        if( file_exists($file)) {
            include $file;
        }

    }

}
