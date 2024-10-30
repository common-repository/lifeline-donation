<?php 
	global $post; 
	$html = wp_kses_allowed_html( 'post' );
?>
<div <?php echo wp_kses( $this->get_render_attribute_string( 'wrapper' ), $html ) ?>>
	<div class="wpcm-row">
		<?php while ( $query->have_posts() ) : $query->the_post(); ?>
			<?php
			$meta     = get_post_meta( get_the_id(), get_post_type() . 's_settings', true );
			$location = webinane_set( $meta, 'location' );
			
			$total = \WebinaneCommerce\Classes\Orders::get_items_total( $post );
			?>
			<div class="wpcm-col-lg-4 wpcm-col-md-6">
				<div class="wpcm-cause-style4">
					<div class="wpcm-cause-style4-img">
						<figure>
							<?php the_post_thumbnail( array( 350, 246 ) ) ?>
						</figure>

						<?php if( $settings->get('button_type') == 'donate' ) : // If donation button is endabled then print component. ?>
							<donation-button :id="<?php the_ID(); ?>">
						<?php endif; ?>

						<a <?php echo wp_kses( $this->get_render_attribute_string( 'button' ), $html ) ?> class="wpcm-btn wpcm-btn-green">
							<?php echo sanitize_text_field($settings->get( 'button_text' )) ?>
						</a>

						<?php if( $settings->get('button_type') == 'donate' ) : // If donation button is endabled then print component. ?>
							</donation-button>
						<?php endif; ?>

					</div>
					<div class="wpcm-cause-style4-contnt">
						<?php the_title( '<h2><a href="' . get_the_permalink( get_the_ID() ) . '">', '</a></h2>' ) ?>
						<span class="wpcm-cause-meta"><i class="flaticon-calendar"></i><?php echo get_the_date(); ?></span>
						<span class="wpcm-cause-meta"><i class="flaticon-place"></i><?php echo esc_html( $location ); ?></span>
						<p><?php echo wp_kses( wp_trim_words( get_the_excerpt(), 10 ), $html ) ?></p>
						<span><?php esc_html_e( 'Raise', 'lifeline-donation' ); ?>:<strong>  <?php echo wp_kses( webinane_cm_price_with_symbol( $total ), $html ) ?></strong></span>
					</div>
				</div>
			</div>
		<?php endwhile; ?>
	</div>
</div>