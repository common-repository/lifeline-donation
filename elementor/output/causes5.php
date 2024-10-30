<?php 
	global $post; 
	$html = wp_kses_allowed_html( 'post' );
?>
<div <?php echo wp_kses( $this->get_render_attribute_string( 'wrapper' ), $html ) ?>>
	<div class="wpcm-causes-style5">
		<div class="wpcm-row">
			<?php while ( $query->have_posts() ) : $query->the_post(); ?>
				<?php
				$meta     = get_post_meta( get_the_id(), get_post_type() . 's_settings', true );
				$location = webinane_set( $meta, 'location' );
				
				$total = \WebinaneCommerce\Classes\Orders::get_items_total( $post );
				?>
				<div class="wpcm-col-lg-6 wpcm-col-md-6">
					<div class="wpcm-cause-style5">
						<div class="wpcm-cause-style5-img">
							<figure>
								<?php the_post_thumbnail( 'wi_donation_540x380' ) ?>
							</figure>
						</div>
						<div class="wpcm-cause-style5-contnt">
							<div class="wpcm-cause-style5-info">
								<a href="#" title="">Water</a>
								<?php the_title( '<h2><a href="' . get_the_permalink( get_the_ID() ) . '">', '</a></h2>' ) ?>
								<span><?php esc_html_e( 'Raise', 'lifeline-donation' ); ?>:<strong>  <?php echo wp_kses( webinane_cm_price_with_symbol( $total ), $html ) ?></strong></span>
							</div>
							<div class="wpcm-cause-style5-meta">
								<span class="wpcm-cause-meta"><i class="flaticon-calendar"></i><?php echo get_the_date(); ?></span>
								<span class="wpcm-cause-meta"><i class="flaticon-place"></i><?php echo esc_html( $location ); ?></span>
							</div>
						</div>
					</div>
				</div>
			<?php endwhile; ?>
		</div>
	</div>
</div>