<?php

namespace LifelineDonation\Widgets;

use WebinaneCommerce\Classes\Orders;
use WP_Query;

class RecentDonationsWidget extends \WP_Widget
{

    public function __construct()
    {

        parent::__construct(/* Base ID */'wi_recent_donations', /* Name */ esc_html__('Lifeline Recent Donations', 'lifeline-donation'), array( 'description' => esc_html__('This widget is used to show lifeline recent donations.', 'lifeline-donation') ));
    }



    public function widget($args, $instance)
    {

        extract($args);
        wp_enqueue_style(array( 'webinane-flat-icon', 'webinane-shortcodes' ));
        $title = apply_filters(
            'widget_title',
            (webinane_set($instance, 'title') == '') ? '' : webinane_set($instance, 'title'),
            array( 'subtitle' => webinane_set($instance, 'subtitle') ),
            $this->id_base
        );
         $args = array(

            'showposts' => webinane_set($instance, 'number'),

            'post_status' => 'completed',

            'post_type' => 'orders',

         );
         $query = new WP_Query($args);
         echo wp_kses($before_widget, true);

         $html = wp_kses_allowed_html('post');

            ?>

        <div class="wpcm-wrapper">
        <div class="wpcm-widget wpcm-recnt-donation-widget">
            <h4 class="wpcm-widget-title"><?php  echo wp_kses($title, $html); ?></h4>
            <?php if ($query->have_posts()) :  ?>
                <ul>

                    <?php while ($query->have_posts()) :
                        $query->the_post(); ?>
                    <li>
                        <i class="flaticon-honest"></i>
                        <div class="wpcm-rcnt-donation-info">
                            <h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                            <span class="date"><?php echo get_the_date('m/d/Y'); ?></span>
                            <span><?php echo get_the_date('g:i a'); ?></span>
                            <span class="amnt"><?php echo webinane_cm_price_with_symbol(get_post_meta(get_the_ID(), '_wpcm_order_total', true)); ?></span>
                        </div>
                    </li>
                    <?php endwhile;
                    wp_reset_postdata(); ?>
                </ul>
            <?php endif; ?>
        </div>
        </div>

        <?php

        echo wp_kses($after_widget, true);
    }



    public function update($new_instance, $old_instance)
    {

        $instance                  = $old_instance;
        $instance['title']         = webinane_set($new_instance, 'title');
        $instance['number']         = webinane_set($new_instance, 'number');
        return $instance;
    }



    public function form($instance)
    {

        $title         = ($instance) ? webinane_set($instance, 'title') : '';
        $number         = ($instance) ? webinane_set($instance, 'number') : '';
        ?>

        <p>

            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'lifeline-donation'); ?></label>

            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />

        </p>

        <p>

            <label for="<?php echo esc_attr($this->get_field_id('number')); ?>"><?php esc_html_e('Number Of Donations:', 'lifeline-donation'); ?></label>

            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('number')); ?>" name="<?php echo esc_attr($this->get_field_name('number')); ?>" type="text" value="<?php echo esc_attr($number); ?>" />

        </p>

        <?php
    }
}

add_action('widgets_init', function () {
    register_widget('LifelineDonation\Widgets\RecentDonationsWidget');
});

