<?php 
	global $post;
	$html = wp_kses_allowed_html( 'post' );
?>
<div <?php echo wp_kses($this->get_render_attribute_string('wrapper'), $html) ?>>
	
	<?php
		$this->add_render_attribute( 'button', 'class', 'wpcm-hover-btn' );
		if($settings->get('button_icon_class')) {

		}

	?>

	<?php while($query->have_posts() ) : $query->the_post(); ?>

		<?php
			$meta = get_post_meta(get_the_id(), get_post_type().'s_settings', true);
			$total = \WebinaneCommerce\Classes\Orders::get_items_total($post);
			$needed = webinane_set($meta, 'donation');
			$percent = ($needed) ? ((int)$total/(int)$needed)*100 : 0;
			// $this->add_render_attribute( 'button', 'data-post', get_the_id(), true );
		?>
		<div class="wpcm-cause-listng">
			<div class="wpcm-row align-items-center">
				<div class="wpcm-col-lg-6">
					<div class="wpcm-cause-lstng-img">
						<figure>
							<?php the_post_thumbnail( 'wi_donation_460x490' ) ?>
						</figure>
						
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
				<div class="wpcm-col-lg-6">
					<div class="wpcm-cause-lsting-contnt">
						<?php the_terms( get_the_id(), 'cause_cat', '', ', ' ) ?>
						<h2><a href="<?php the_permalink() ?>" title="<?php the_title_attribute() ?>"><?php the_title() ?></a></h2>
						<p><?php echo wp_trim_words( get_the_excerpt(), 20 ) ?></p>
						<span>
							<?php esc_html_e('Raised', 'lifeline-donation'); ?>:  
							<strong><?php echo wp_kses(webinane_cm_price_with_symbol($total), $html) ?></strong>
						</span>
						<div class="progress">
						 	<div class="progress-bar" style="width:<?php echo esc_attr($percent) ?>%">
						 		<span><?php echo sanitize_text_field($percent) ?>%</span>
						 	</div>
						</div> 
					</div>
				</div>
			</div>
		</div>
	<?php endwhile; ?>
</div>