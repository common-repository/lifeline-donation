<?php 
	global $post; 
	$html = wp_kses_allowed_html( 'post' );
?>
<div <?php echo wp_kses($this->get_render_attribute_string('wrapper'), $html) ?>>
	
	<div class="wpcm-row">
		<?php while($query->have_posts() ) : $query->the_post(); ?>

			<?php
				
				$meta = get_post_meta(get_the_id(), get_post_type().'s_settings', true);
				$total = WebinaneCommerce\Classes\Orders::get_items_total($post);
				$needed = webinane_set($meta, 'donation');
				$percent = ($needed) ? ((int)$total/(int)$needed)*100 : 0;
			?>
			<div class="wpcm-col-lg-4 wpcm-col-md-4">
				<div class="wpcm-cause-style2">
					<div class="cause-style2-iner">
						<figure>
							<?php the_post_thumbnail( array(350, 270) ) ?>
							<a href="#" title="">Water</a>
						</figure>
						<h3><?php the_title() ?></h3>
						<p><?php echo wp_kses(wp_trim_words( get_the_excerpt(), 8 ), $html) ?></p>
						<div class="progress">
						 	<div class="progress-bar" style="width:<?php echo esc_attr($percent) ?>%">
						 		<span><?php echo sanitize_text_field($percent) ?>%</span>
						 	</div>
						</div> 
						<div class="dontn-amnt-info">
							<span><strong><?php esc_html_e('GOAL', 'lifeline-donation'); ?>:</strong>  <?php echo wp_kses(webinane_cm_price_with_symbol($needed), $html) ?></span>
							<span><strong><?php esc_html_e('Raise', 'lifeline-donation'); ?>:  </strong>  <?php echo wp_kses(webinane_cm_price_with_symbol($total), $html) ?></span>
						</div>

						<?php if( $settings->get('button_type') == 'donate' ) : // If donation button is endabled then print component. ?>
							<donation-button :id="<?php the_ID(); ?>">
						<?php endif; ?>

						<a <?php echo wp_kses($this->get_render_attribute_string('button'), $html) ?>>
							<?php if( $settings->get('button_icon')) : ?>
								<span><i class="<?php echo esc_attr($settings->get('button_icon_class')) ?>"></i></span>
							<?php endif; ?>
							<?php echo sanitize_text_field($settings->get('button_text')) ?>
						</a>

						<?php if( $settings->get('button_type') == 'donate' ) : // If donation button is endabled then print component. ?>
							</donation-button>
						<?php endif; ?>

					</div>
				</div>
			</div>
		<?php endwhile; ?>
	</div>
</div>