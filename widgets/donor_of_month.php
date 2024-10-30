<?php

namespace LifelineDonation\Widgets;

use WP_Query;
use WebinaneCommerce\Classes\Customers;
use WebinaneCommerce\Classes\Orders;
use WebinaneCommerce\Models\Customer;

class DonorOfMonthWidget extends \WP_Widget
{

    public function __construct()
    {

        parent::__construct(/* Base ID */'wi_donor_of_month', /* Name */ esc_html__('Lifeline Donor Of Month', 'lifeline-donation'), array( 'description' => esc_html__('This widget is used to show lifeline donor of month.', 'lifeline-donation') ));
    }


    public function widget($args, $instance)
    {
        extract($args);
        wp_enqueue_style('webinane-shortcodes');
        $html = wp_kses_allowed_html('post');
        $meta_query_args = array(
            'relation' => 'AND', // Optional, defaults to "AND"

            array(
                'key'     => '_wpcm_order_customer_id',
                'value'   => webinane_set($instance, 'block'),
                'compare' => '='
            )
        );
        $args = array(
            'post_type'   =>  'orders',
            'post_status' => 'completed',
            'meta_query'    => $meta_query_args
        );

        $query = new WP_Query($args);


        if ($query->have_posts()) :
            $donation = array();
            $counter = 1;
            while ($query->have_posts()) :
                $query->the_post();
                $donation[$counter] = get_post_meta(get_the_ID(), '_wpcm_order_total', true);
                $counter++;
            endwhile;
            wp_reset_postdata();
            

            echo wp_kses($before_widget, true);
            
            $post_object = new Customers(webinane_set($instance, 'block'));
            $post = $post_object->userdata;
            ?>
            <div class="wpcm-wrapper">
                <div class="wpcm-widget wpcm-mnth-donor-widget">
                <h4 class="wpcm-widget-title"><?php echo wp_kses(webinane_set($instance, 'title'), $html); ?></h4>
                
                <div class="text-center">
                    <div class="mnth-donor-img">
                        <?php echo get_avatar(webinane_set($post, 'email'), 234); ?>
                        <span><img src="<?php echo LIFELINE_DONATION_URL. 'assets/images/badge-icon.png'; ?>" alt=""></span>
                    </div>
                    <div class="mnth-donor-content">
                        <span><?php echo wp_kses(webinane_set($instance, 'subtitle'), $html); ?></span>
                        <h3><?php echo webinane_set($post, 'name'); ?></h3>
                        <p><?php echo wp_kses(webinane_set($instance, 'description'), $html); ?></p>
                        <div class="donation-det">
                            <span><?php esc_html_e('Amount:', 'lifeline-donation'); ?>  <strong><?php echo webinane_cm_price_with_symbol(array_sum($donation)); ?> </strong></span>
                            <span><?php esc_html_e('Donation:', 'lifeline-donation'); ?> <strong><?php echo esc_attr(count($donation)); ?><?php esc_html_e(' Times', 'lifeline-donation'); ?></strong></span>
                        </div>
                        <?php if (webinane_set($instance, 'btn_label')) : ?>
                            <a href="<?php echo esc_url(webinane_set($instance, 'btn_link')); ?>" class="wpcm-btn wpcm-btn-radius wpcm-btn-green"><?php echo wp_kses(webinane_set($instance, 'btn_label'), $html); ?></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            </div>
            <?php
            echo wp_kses($after_widget, true);
        endif;
    }

    public function update($new_instance, $old_instance)
    {

        $instance           = $old_instance;
        $instance['title']  = webinane_set($new_instance, 'title');
        $instance['subtitle']  = webinane_set($new_instance, 'subtitle');
        $instance['description']  = webinane_set($new_instance, 'description');
        $instance['btn_label']  = webinane_set($new_instance, 'btn_label');
        $instance['btn_link']  = webinane_set($new_instance, 'btn_link');
        $instance['block'] = webinane_set($new_instance, 'block');
        return $instance;
    }


    public function form($instance)
    {

        $title     = ($instance) ? webinane_set($instance, 'title') : '';
        $subtitle  = ($instance) ? webinane_set($instance, 'subtitle') : '';
        $description     = ($instance) ? webinane_set($instance, 'description') : '';
        $btn_label     = ($instance) ? webinane_set($instance, 'btn_label') : '';
        $btn_link     = ($instance) ? webinane_set($instance, 'btn_link') : '';
        $block     = ($instance) ? webinane_set($instance, 'block') : '';
        $html = wp_kses_allowed_html('post');
        ?>
        <p>

            <label for="<?php echo esc_attr($this->get_field_id('subtitle')); ?>"><?php esc_html_e('Tagline:', 'lifeline-donation'); ?></label>

            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('subtitle')); ?>" name="<?php echo esc_attr($this->get_field_name('subtitle')); ?>" type="text" value="<?php echo esc_attr($subtitle); ?>" />

        </p>
        <p>

            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'lifeline-donation'); ?></label>

            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />

        </p>
        
        <p>

            <label for="<?php echo esc_attr($this->get_field_id('description')); ?>"><?php esc_html_e('Description:', 'lifeline-donation'); ?></label>

            <textarea class="widefat" id="<?php echo esc_attr($this->get_field_id('description')); ?>" name="<?php echo esc_attr($this->get_field_name('description')); ?>"><?php echo esc_html($description); ?></textarea>

        </p>
        
        <p>

            <label for="<?php echo esc_attr($this->get_field_id('btn_label')); ?>"><?php esc_html_e('Button Label:', 'lifeline-donation'); ?></label>

            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('btn_label')); ?>" name="<?php echo esc_attr($this->get_field_name('btn_label')); ?>" type="text" value="<?php echo esc_attr($btn_label); ?>" />

        </p>

        <p>

            <label for="<?php echo esc_attr($this->get_field_id('btn_link')); ?>"><?php esc_html_e('Button Link:', 'lifeline-donation'); ?></label>

            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('btn_link')); ?>" name="<?php echo esc_attr($this->get_field_name('btn_link')); ?>" type="text" value="<?php echo esc_attr($btn_link); ?>" />

        </p>

        
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('block')); ?>"><?php esc_html_e('Choose donor to show in this widget.', 'lifeline-donation'); ?></label>
            <?php global $wpdb;
            $name = $wpdb->prefix.'wpcommerce_customers';

            $result = Customer::all(); //$wpdb->get_results("SELECT * FROM $name"); ?>
            <select class="widefat" name="<?php echo esc_attr($this->get_field_name('block')); ?>" id="<?php echo esc_attr($this->get_field_id('block')); ?>">

                <?php foreach ($result as $res) : ?>
                    <option value="<?php echo esc_attr($res->id); ?>" <?php selected($res->id, $block) ?>><?php echo wp_kses($res->name, $html) ?></option>
                <?php endforeach; ?>
            </select>

        </p>

        <?php
    }
}

add_action('widgets_init', function () {
    register_widget(DonorOfMonthWidget::class);
});
