<?php

namespace LifelineDonation\Widgets;

use WebinaneCommerce\Classes\Orders;
use WP_Query;

class UrgentCampaignsWidget extends \WP_Widget
{

    public function __construct()
    {

        parent::__construct(/* Base ID */'wi_urgent_campaigns', /* Name */ esc_html__('Lifeline Recent Campaigns', 'lifeline-donation'), array( 'description' => esc_html__('This widget is used to show lifeline recent campaigns.', 'lifeline-donation') ));
    }



    public function widget($args, $instance)
    {

        extract($args);

        wp_enqueue_style('webinane-shortcodes');
        $title = apply_filters(
            'widget_title',
            (webinane_set($instance, 'title') == '') ? '' : webinane_set($instance, 'title'),
            array( 'subtitle' => webinane_set($instance, 'subtitle') ),
            $this->id_base
        );
        $post = webinane_set($instance, 'posttype') ? webinane_set($instance, 'posttype') : 'cause';
        $args = array(

            'posts_per_page'   => webinane_set($instance, 'number'),

            'post_status' => 'published',

            'post_type'   =>  $post,

        );
        $query = new WP_Query($args);
        echo wp_kses($before_widget, true);
        
        $html = wp_kses_allowed_html('post');
        ?>
         <div class="wpcm-wrapper">
        <div class="wpcm-widget wpcm-urgnt-causes-widget">
            <h4 class="wpcm-widget-title"><?php echo wp_kses($title, $html); ?></h4>
            <?php if ($query->have_posts()) :  ?>
                <ul>
                    <?php while ($query->have_posts()) :
                        $query->the_post(); ?>
                        <?php
                        $meta_key = ($post == 'cause' ) ? 'causes_settings' : 'project_settings';

                        $meta = get_post_meta(get_the_ID(), $meta_key, true);
                        $donation_needed = (webinane_set($meta, 'donation')) ? webinane_set($meta, 'donation') : 0;

                        $collect_amt = Orders::get_items_total(get_post(get_the_ID()));
                        ?>
                        
                        <li>
                            <div class="wpcm-tp-info wpcm-d-flex align-items-center">
                                
                                <?php the_post_thumbnail([73, 73]); ?>
                                
                                <div class="wpcm-cause-nam">
                                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                    <?php if (webinane_set($meta, 'location')) : ?>
                                        <span><?php echo esc_html(webinane_set($meta, 'location')); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="wpcm-dontn-info">
                                <span><strong><?php esc_html_e('Raised:', 'lifeline-donation'); ?></strong>   <?php echo webinane_cm_price_with_symbol($collect_amt); ?></span>
                                <a href="<?php the_permalink(); ?>" title=""><?php esc_html_e('Donate', 'lifeline-donation'); ?></a>
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
        $instance['posttype']         = webinane_set($new_instance, 'posttype');
        return $instance;
    }



    public function form($instance)
    {

        $title         = ($instance) ? webinane_set($instance, 'title') : '';
        $number         = ($instance) ? webinane_set($instance, 'number') : '';
        $posttype         = ($instance) ? webinane_set($instance, 'posttype') : '';
        
        ?>

        <p>

            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'lifeline-donation'); ?></label>

            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />

        </p>

        <p>

            <label for="<?php echo esc_attr($this->get_field_id('number')); ?>"><?php esc_html_e('Number Of Posts:', 'lifeline-donation'); ?></label>

            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('number')); ?>" name="<?php echo esc_attr($this->get_field_name('number')); ?>" type="text" value="<?php echo esc_attr($number); ?>" />

        </p>
        
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('posttype')); ?>"><?php esc_html_e('Choose post type to show data in this widget:', 'lifeline-donation'); ?></label>

            <select id="<?php echo esc_attr($this->get_field_id('posttype')); ?>" name="<?php echo esc_attr($this->get_field_name('posttype')); ?>" class="widefat" style="width:100%;">
                <option <?php selected($posttype, 'Cause'); ?> value="Cause">Causes</option>
                <option <?php selected($posttype, 'Project'); ?> value="Project">Project</option> 

            </select>

        </p>

        <?php
    }
}

add_action('widgets_init', function () {
    register_widget('LifelineDonation\Widgets\UrgentCampaignsWidget');
});
