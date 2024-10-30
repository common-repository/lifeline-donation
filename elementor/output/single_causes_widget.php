<?php 
	global $post; 
	$html = wp_kses_allowed_html( 'post' );
?>
<div <?php echo wp_kses( $this->get_render_attribute_string( 'wrapper' ), $html ) ?>>

	<h4 class="wpcm-widget-title"><?php echo esc_html( $settings->get( 'widget_title' ) ); ?></h4>

	<?php while ( $query->have_posts() ) : $query->the_post(); ?>

		<?php
			$meta     = get_post_meta( get_the_id(), get_post_type() . 's_settings', true );
			$location = webinane_set( $meta, 'location' );
			$total    = WebinaneCommerce\Classes\Orders::get_items_total( $post );
			$needed   = webinane_set( $meta, 'donation' );
			$percent  = ( $needed ) ? ( (int) $total / (int) $needed ) * 100 : 0;
		?>

		<div class="urgnt-causes-iner">
			<figure>
				<?php the_post_thumbnail( array( 264, 200 ) ) ?>
				<a href="#" title="">Water</a>
			</figure>
			<?php the_title( '<h3><a href="' . get_the_permalink( get_the_ID() ) . '">', '</a></h3>' ) ?>
			<p><?php echo wp_kses( wp_trim_words( get_the_excerpt(), 10 ), $html ) ?></p>
			<div class="progress">
				<div class="progress-bar" style="width:<?php echo esc_attr( $percent ) ?>%">
					<span><?php echo sanitize_text_field( $percent ) ?>%</span>
				</div>
			</div>
			<div class="dontn-amnt-info">
				<span><strong><?php esc_html_e( 'GOAL', 'lifeline-donation' ); ?>:</strong>  <?php echo wp_kses( webinane_cm_price_with_symbol( $needed ), $html ) ?></span>
				<span><strong><?php esc_html_e( 'Raise', 'lifeline-donation' ); ?>:  </strong>  <?php echo wp_kses( webinane_cm_price_with_symbol( $total ), $html ) ?></span>
			</div>

			<?php if( $settings->get('button_type') == 'donate' ) : // If donation button is endabled then print component. ?>
				<donation-button :id="<?php the_ID(); ?>">
			<?php endif; ?>

			<a <?php echo wp_kses( $this->get_render_attribute_string( 'button' ), $html ) ?>>
				<?php if ( $settings->get( 'button_icon' ) ) : ?>
					<span><i class="<?php echo esc_attr( $settings->get( 'button_icon_class' ) ) ?>"></i></span>
				<?php endif; ?>
				<?php echo sanitize_text_field($settings->get( 'button_text' )) ?>
			</a>

			<?php if( $settings->get('button_type') == 'donate' ) : // If donation button is endabled then print component. ?>
				</donation-button>
			<?php endif; ?>

		</div>
	<?php endwhile; ?>
</div>
