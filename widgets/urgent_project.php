<?php

namespace LifelineDonation\Widgets;

use WebinaneCommerce\Classes\Orders;
use WP_Query;

class UrgentProjectWidget extends \WP_Widget
{

    public function __construct()
    {

        parent::__construct(/* Base ID */'wi_urgent_project', /* Name */ esc_html__('Lifeline Urgent Project', 'lifeline-donation'), array( 'description' => esc_html__('This widget is used to show lifeline Urgent Project.', 'lifeline-donation') ));
    }

    public function widget($args, $instance)
    {

        extract($args);

        
        $post_object = get_page_by_path(webinane_set($instance, 'block'), '', 'project');
        $args = array(
            'post_type'   =>  'project',
            'post_status' => 'published',
            'p'           =>  webinane_set($post_object, 'ID'),

        );
        wp_enqueue_style('webinane-shortcodes');
        $query = new WP_Query($args);
        if ($query->have_posts()) :
            echo wp_kses($before_widget, true);
            
            $limit = webinane_set($instance, 'number') ? webinane_set($instance, 'number') : 20;
            $html = wp_kses_allowed_html('post');
            ?>
            <div class="wpcm-wrapper">
                <div class="wpcm-widget wpcm-urgnt-causes2-widget">
                <h4 class="wpcm-widget-title"><?php echo wp_kses(webinane_set($instance, 'title'), $html); ?></h4>
                <?php while ($query->have_posts()) :
                    $query->the_post();
                    $meta = get_post_meta(get_the_ID(), 'project_settings', true);
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
                    
                        <?php $category = get_the_terms(get_the_ID(), 'project_cat'); ?>

                        <?php if ($category) :
                            foreach ($category as $cat) :  ?>
                            <a href="<?php echo get_term_link(webinane_set($cat, 'term_id'), 'project_cat'); ?>"><?php echo esc_html(webinane_set($cat, 'name')); ?></a>

                            <?php endforeach;
                        endif; ?>
                    </figure>
                <h3><?php the_title(); ?></h3>
                <p><?php echo wp_trim_words(get_the_excerpt(), $limit, '...'); ?></p>
                <div class="progress">
                    <div class="progress-bar" style="width:<?php echo esc_attr((int)$donation_percentage); ?>%">
                        <span><?php echo sanitize_text_field((int)$donation_percentage); ?>%</span>
                    </div>
                </div> 
                <div class="dontn-amnt-info">
                    <span><strong><?php esc_html_e('Goal:', 'lifeline-donation'); ?> </strong>  <?php echo webinane_cm_price_with_symbol($donation_needed); ?></span>
                    <span><strong><?php esc_html_e('Raise:', 'lifeline-donation'); ?>  </strong>  <?php echo webinane_cm_price_with_symbol($collect_amt); ?></span>
                </div>
                <a href="<?php the_permalink(); ?>" class="wpcm-btn wpcm-btn-border"><?php esc_html_e('Donate Now', 'lifeline-donation'); ?></a>
            </div>
        </div>
            </div>
                <?php endwhile;
                wp_reset_postdata(); ?>
            <?php
            echo wp_kses($after_widget, true);
        endif;
    }



    public function update($new_instance, $old_instance)
    {

        $instance           = $old_instance;
        $instance['title']  = webinane_set($new_instance, 'title');
        $instance['number'] = webinane_set($new_instance, 'number');
        $instance['block']  = webinane_set($new_instance, 'block');
        return $instance;
    }



    public function form($instance)
    {

        $title     = ($instance) ? webinane_set($instance, 'title') : '';
        $number    = ($instance) ? webinane_set($instance, 'number') : '';
        $block  = ($instance) ? webinane_set($instance, 'block') : '';
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
        <label for="<?php echo esc_attr($this->get_field_id('block')); ?>"><?php esc_html_e('Choose project to show in this widget.', 'lifeline-donation'); ?></label>

        <select class="widefat" name="<?php echo esc_attr($this->get_field_name('block')); ?>" id="<?php echo esc_attr($this->get_field_id('block')); ?>">

            <?php foreach ((array)webinane_donation_get_posts_blocks('project') as $key => $value) : ?>
                <option value="<?php echo esc_attr($key); ?>" <?php selected($key, $block) ?>><?php echo wp_kses($value, $html) ?></option>
            <?php endforeach; ?>
        </select>

    </p>

        <?php
    }
}

add_action('widgets_init', function () {
    register_widget('LifelineDonation\Widgets\UrgentProjectWidget');
});
