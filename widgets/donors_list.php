<?php
namespace LifelineDonation\Widgets;

use WebinaneCommerce\Classes\Orders;
use WebinaneCommerce\Models\Customer;
use WebinaneCommerce\Models\OrderItems;

class DonorsListWidget extends \WP_Widget
{

    public function __construct()
    {
        parent::__construct(/* Base ID */'wi_donors_list', /* Name */ esc_html__('Lifeline Donor\'s List', 'lifeline-donation'), array( 'description' => esc_html__('This widget is used to show lifeline donors list.', 'lifeline-donation') ));
    }

    public function widget($args, $instance)
    {
        extract($args);
        extract($instance);
		echo wp_kses($before_widget, true);
		wp_enqueue_style('webinane-shortcodes');
		?>
		<div class="wpcm-wrapper">
			<div class="wpcm-widget wpcm-top-donors-widget">
				<ul>
					<?php
					$customers = Customer::paginate($post)->toArray();
					$customers = webinane_set($customers, 'data');
					$settings = wpcm_get_settings(true)->get('donors_donation_listing_page');
					if(!empty($customers)){
						foreach ($customers as $customer) :
							?>
								<li class="wpcm-d-flex align-items-center">
									<div class="wpcm-donor-avatar">
										<?php echo get_avatar(webinane_set($customer, 'email'), 84); ?>
									</div>
									<div class="wpcm-donr-donation">
										<h5><a href="<?php echo esc_url(get_the_permalink($settings).'?wpcm_u='. webinane_set($customer, 'id')); ?>"><?php echo webinane_set($customer, 'name'); ?></a></h5>
									</div>
								</li>
							<?php
						endforeach;
					}
					?>
				</ul>
			</div>
		</div>
		<?php

		echo wp_kses($after_widget, true);
    }


    public function update($new_instance, $old_instance)
    {
        $instance           = $old_instance;
        $instance['title']  = webinane_set($new_instance, 'title');
        $instance['post']  = webinane_set($new_instance, 'post');
        return $instance;
    }

    public function form($instance)
    {
        $title     = ($instance) ? webinane_set($instance, 'title') : '';
        $post     = ($instance) ? webinane_set($instance, 'post') : 5;
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'lifeline-donation'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>
		<p>
            <label for="<?php echo esc_attr($this->get_field_id('post')); ?>"><?php esc_html_e('Post Qty:', 'lifeline-donation'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('post')); ?>" name="<?php echo esc_attr($this->get_field_name('post')); ?>" type="text" value="<?php echo esc_attr($post); ?>" />
        </p>
        <?php
    }
}

add_action('widgets_init', function () {
    register_widget('LifelineDonation\Widgets\DonorsListWidget');
});
