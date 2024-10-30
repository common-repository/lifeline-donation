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
				$total    = \WebinaneCommerce\Classes\Orders::get_items_total( $post );
			?>
			<div class="wpcm-col-lg-4 wpcm-col-md-6">
				<div class="wpcm-cause-style3">
					<div class="wpcm-cause-style3-img">
						<figure>
							<?php the_post_thumbnail( array( 370, 475 ) ) ?>
						</figure>
						<div class="wpcm-cause-style3-contnt">
							<span class="wpcm-cause-loc"><?php echo esc_html( $location ); ?></span>
							<h2>
								<a href="<?php the_permalink() ?>" title="<?php the_title_attribute() ?>">
									<?php echo wp_trim_words(get_the_title(), 3) ?>
								</a>
							</h2>

							<span><strong><?php esc_html_e( 'Raise', 'lifeline-donation' ); ?>:  </strong>  <?php echo wp_kses( webinane_cm_price_with_symbol( $total ), $html ) ?></span>

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
					</div>
				</div>
			</div>
		<?php endwhile; ?>
	</div>
</div>