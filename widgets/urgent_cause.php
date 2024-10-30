<?php

namespace LifelineDonation\Widgets;

use WebinaneCommerce\Classes\Orders;
use WP_Query;

class UrgentCause extends \WP_Widget
{

    public function __construct()
    {

        parent::__construct(/* Base ID */'wi_urgent_cause', /* Name */ esc_html__('Lifeline Urgent Cause', 'lifeline-donation'), array( 'description' => esc_html__('This widget is used to show lifeline urgent cause.', 'lifeline-donation') ));
    }


    /**
     * [widget description]
     *
     * @param  [type] $args     [description]
     * @param  [type] $instance [description]
     * @return [type]           [description]
     */
    public function widget($args, $instance)
    {


        extract($args);
        wp_enqueue_style('webinane-shortcodes');
        $post_object = get_page_by_path(webinane_set($instance, 'block'), '', 'cause');
        $args = array(
            'post_type'   =>  'cause',
            'post_status' => 'published',
            'p'           =>  webinane_set($post_object, 'ID'),

        );
        $html = wp_kses_allowed_html('post');
        $btn_text = webinane_set($instance, 'text', esc_html__('Donate Now', 'lifeline-donation'));

        $popup = array_get($instance, 'popup');

        $query = new WP_Query($args);
        if ($query->have_posts()) :
            echo wp_kses($before_widget, true);
            
            $limit = webinane_set($instance, 'number') ? webinane_set($instance, 'number') : 20;

            ?>
            <div class="wpcm-wrapper">
                <div class="wpcm-widget wpcm-urgnt-causes2-widget">
                <h4 class="wpcm-widget-title"><?php echo wp_kses(webinane_set($instance, 'title'), $html); ?></h4>
                <?php while ($query->have_posts()) :
                    $query->the_post();
                    $meta = get_post_meta(get_the_ID(), 'causes_settings', true);
                    $link = webinane_set($instance, 'link', get_permalink());
                    $donation_needed = (webinane_set($meta, 'donation')) ? webinane_set($meta, 'donation') : 0;
                    $collect_amt = Orders::get_items_total(get_post(get_the_ID()));
                    if ($collect_amt != 0 && $donation_needed != 0) {
                        $donation_percentage = ($collect_amt/$donation_needed)*100;
                    } else {
                        $donation_percentage = 0;
                    }
                    ?>
                <div class="urgnt-causes-iner">
                    <figure>
                        <?php the_post_thumbnail([264, 200]); ?>

                        <?php $category = get_the_terms(get_the_ID(), 'cause_cat'); ?>

                        <?php if ($category) :
                            foreach ($category as $cat) :  ?>
                            <a href="<?php echo get_term_link(webinane_set($cat, 'term_id'), 'cause_cat'); ?>"><?php echo esc_html(webinane_set($cat, 'name')); ?></a>

                            <?php endforeach;
                        endif; ?>
                    </figure>
                <h3><?php the_title(); ?></h3>
                <p><?php  echo wp_trim_words(get_the_excerpt(), $limit, '...'); ?></p>
                <div class="progress">
                    <div class="progress-bar" style="width:<?php echo esc_attr((int)$donation_percentage); ?>%">
                        <span><?php echo sanitize_text_field((int)$donation_percentage); ?>%</span>
                    </div>
                </div> 
                <div class="dontn-amnt-info">
                    <span><strong><?php esc_html_e('Goal:', 'lifeline-donation'); ?> </strong>  <?php echo webinane_cm_price_with_symbol($donation_needed); ?></span>
                    <span><strong><?php esc_html_e('Raise:', 'lifeline-donation'); ?>  </strong>  <?php echo webinane_cm_price_with_symbol($collect_amt); ?></span>
                </div>
                <?php if ( $popup ) : ?>
                    <div class="urgent-popup-list">
                        <donation-button :id="<?php the_ID() ?>">
                            <a href="#" class="wpcm-btn wpcm-btn-border"><?php echo esc_attr($btn_text) ?></a>
                        </donation-button>
                    </div>
                <?php else : ?>
                    <a href="<?php echo esc_url($link) ?>" class="wpcm-btn wpcm-btn-border"><?php echo esc_attr($btn_text) ?></a>
                <?php endif; ?>
            </div>
        </div>
            </div>
                <?php endwhile;
                wp_reset_postdata(); ?>
            <?php
            echo wp_kses($after_widget, true);
        endif;
    }


    /**
     * [update description]
     * 
     * @param  [type] $new_instance [description]
     * @param  [type] $old_instance [description]
     * @return [type]               [description]
     */
    public function update($new_instance, $old_instance)
    {

        $instance           = $old_instance;
        $instance['title']  = webinane_set($new_instance, 'title');
        $instance['number'] = webinane_set($new_instance, 'number');
        $instance['block']  = webinane_set($new_instance, 'block');
        $instance['popup']  = webinane_set($new_instance, 'popup');
        $instance['link']  = webinane_set($new_instance, 'link');
        $instance['text']  = webinane_set($new_instance, 'text');
        return $instance;
    }


    /**
     * [form description]
     *
     * @param  [type] $instance [description]
     * @return [type]           [description]
     */
    public function form($instance)
    {

        $title     = ($instance) ? webinane_set($instance, 'title') : esc_html__('Our Urgent Cause', 'lifeline-donation');
        $number    = ($instance) ? webinane_set($instance, 'number') : 20;
        $block  = ($instance) ? webinane_set($instance, 'block') : '';
        $popup  = ($instance) ? webinane_set($instance, 'popup') : '';
        $link  = ($instance) ? webinane_set($instance, 'link') : '';
        $btn_text  = ($instance) ? webinane_set($instance, 'text') : esc_html__('Donate Now', 'lifeline-donation');

        $html = wp_kses_allowed_html('post');
        ?>

        <p>

            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'lifeline-donation'); ?></label>

            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />

        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('number')); ?>"><?php esc_html_e('Text Words Limit:', 'lifeline-donation'); ?></label>

            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('number')); ?>" name="<?php echo esc_attr($this->get_field_name('number')); ?>" type="text" value="<?php echo esc_attr($number); ?>" />
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('block')); ?>"><?php esc_html_e('Choose cause post to show in this widget.', 'lifeline-donation'); ?></label>

            <select class="widefat" name="<?php echo esc_attr($this->get_field_name('block')); ?>" id="<?php echo esc_attr($this->get_field_id('block')); ?>">

                <?php foreach ((array)webinane_donation_get_posts_blocks('cause') as $key => $value) : ?>
                    <option value="<?php echo esc_attr($key); ?>" <?php selected($key, $block) ?>><?php echo wp_kses($value, $html) ?></option>
                <?php endforeach; ?>
            </select>

        </p>
        
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('popup')); ?>"><?php esc_html_e('Open Popup', 'lifeline-donation'); ?></label>

            <input type="checkbox" name="<?php echo esc_attr($this->get_field_name('popup')) ?>" id="<?php echo esc_attr($this->get_field_id('popup')) ?>" value="1" <?php checked( 1, $popup ) ?> /><br>
            <small><?php esc_html_e('Whether to open popup on Donate Now button click', 'lifeline-donation') ?></small>

        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('link')); ?>"><?php esc_html_e('Donation Page Link', 'lifeline-donation'); ?></label>

            <input type="text" class="widefat" name="<?php echo esc_attr($this->get_field_name('link')) ?>" id="<?php echo esc_attr($this->get_field_id('link')) ?>" value="<?php echo esc_attr($link) ?>" /><br>
            <small><?php esc_html_e('Enter the donation page link if you don\'t want to show donation popup on button click', 'lifeline-donation') ?></small>

        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('text')); ?>"><?php esc_html_e('Button Text', 'lifeline-donation'); ?></label>

            <input type="text" class="widefat" name="<?php echo esc_attr($this->get_field_name('text')) ?>" id="<?php echo esc_attr($this->get_field_id('text')) ?>" value="<?php echo esc_attr($btn_text) ?>" /><br>
            <small><?php esc_html_e('Leave it empty if you want to show the default text', 'lifeline-donation') ?></small>

        </p>

        <?php
    }
}
add_action('widgets_init', function () {
    register_widget(UrgentCause::class);
});
