<?php
namespace LifelineDonation\Widgets;

use WebinaneCommerce\Classes\Orders;
use WebinaneCommerce\Classes\Customers;
use WP_Query;

class TopDonorsWidget extends \WP_Widget
{

    public function __construct()
    {

        parent::__construct(/* Base ID */'wi_top_donors', /* Name */ esc_html__('Lifeline Top Donors', 'lifeline-donation'), array( 'description' => esc_html__('This widget is used to show lifeline top donors.', 'lifeline-donation') ));
    }



    public function widget($args, $instance)
    {
        global $wpdb;
        $items_table = $wpdb->prefix . 'wpcommerce_order_items';
        $customers_table = $wpdb->prefix . 'wpcommmerce_customers';
        $posts_table = $wpdb->prefix . 'posts';

        $query = "SELECT SUM(price) as total, order_id FROM {$items_table} as t1 INNER JOIN {$posts_table} as t2 ON t1.order_id = t2.ID WHERE t2.post_status = %s GROUP BY order_id ORDER BY total DESC";
        $query = $wpdb->get_results($wpdb->prepare($query, 'completed'));

        $res = array();

        foreach ($query as $q) {
            $cus_id = get_post_meta($q->order_id, '_wpcm_order_customer_id', true);
        
            if ($cus_id) {
                $res[$cus_id][] = $q->total;
            }
        }
        $counter = array_map('count', $res);

        $res = array_map('array_sum', $res);

        extract($args);
        $number = webinane_set($instance, 'number') ? webinane_set($instance, 'number') : 5;
        if ($res) :
            $res = array_slice($res, 0, $number, true);

            
            echo wp_kses($before_widget, true);
            
            wp_enqueue_style('webinane-shortcodes');
            $html = wp_kses_allowed_html('post');
            ?>
             <div class="wpcm-wrapper">
                <div class="wpcm-widget wpcm-top-donors-widget">
                    <h4 class="wpcm-widget-title"><?php echo wp_kses(webinane_set($instance, 'title'), $html); ?></h4>
                    <ul>
                        <?php
                            $count = 1;
                        foreach ($res as $customer_id => $total) :
                            $customer = new Customers($customer_id);
                            $post = $customer->userdata;  ?>
                                
                                <li class="wpcm-d-flex align-items-center">
                                    <div class="wpcm-donor-avatar">
                                        <?php echo get_avatar(webinane_set($post, 'email'), 84); ?>
                                        <span><?php echo sanitize_text_field($count); ?></span>
                                    </div>
                                    <div class="wpcm-donr-donation">
                                        <h5><?php echo webinane_set($post, 'name'); ?></h5>
                                        <span><?php esc_html_e('Amount:', 'lifeline-donation'); ?>  <strong><?php echo webinane_cm_price_with_symbol($total); ?></strong></span>
                                        <span><?php esc_html_e('Donation:', 'lifeline-donation'); ?>  <strong><?php echo sanitize_text_field($counter[$customer_id]); ?><?php esc_html_e(' Times', 'lifeline-donation'); ?></strong></span>
                                    </div>
                                </li>
                            <?php
                            $count++;
                        endforeach;
                        ?>
                    </ul>
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
        $instance['number'] = webinane_set($new_instance, 'number');
        return $instance;
    }


    public function form($instance)
    {

        $title     = ($instance) ? webinane_set($instance, 'title') : '';
        $number    = ($instance) ? webinane_set($instance, 'number') : '';

        ?>

        <p>

            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'lifeline-donation'); ?></label>

            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />

        </p>

        <p>

            <label for="<?php echo esc_attr($this->get_field_id('number')); ?>"><?php esc_html_e('Number of Donors:', 'lifeline-donation'); ?></label>

            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('number')); ?>" name="<?php echo esc_attr($this->get_field_name('number')); ?>" type="text" value="<?php echo esc_attr($number); ?>" />

        </p>




        <?php
    }
}

add_action('widgets_init', function () {
    register_widget('LifelineDonation\Widgets\TopDonorsWidget');
});
