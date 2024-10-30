<?php 
	global $post; 
	$html = wp_kses_allowed_html( 'post' );
?>
<div <?php echo wp_kses( $this->get_render_attribute_string( 'wrapper' ), $html ) ?>>
	<h4 class="wpcm-widget-title"><?php echo esc_html( $settings->get( 'widget_title' ) ); ?></h4>
	<ul>
		<?php while ( $query->have_posts() ) : $query->the_post(); ?>
			<?php
			$this->add_render_attribute( 'button', 'data-post', get_the_id() );
			$meta     = get_post_meta( get_the_id(), get_post_type() . 's_settings', true );
			$location = webinane_set( $meta, 'location' );
			$total    = WebinaneCommerce\Classes\Orders::get_items_total( $post );
			?>
			<li>
				<div class="wpcm-tp-info">
					<?php the_post_thumbnail( array( 73, 73 ) ) ?>
					<div class="wpcm-cause-nam">
						<?php the_title( '<h3><a href="' . get_the_permalink( get_the_ID() ) . '">', '</a></h3>' ) ?>
						<span><?php echo esc_html( $location ); ?></span>
					</div>
				</div>
				<div class="wpcm-dontn-info">
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
			</li>
		<?php endwhile; ?>
	</ul>
</div>