<?php 
	global $post; 
	$html = wp_kses_allowed_html( 'post' );
?>
<div <?php echo wp_kses( $this->get_render_attribute_string( 'wrapper' ), $html ) ?>>
	<div class="wpcm-row">
		<div class="wpcm-col-lg-12">
			<div class="wpcm-heading-style4">
				<h2><?php echo esc_html( $settings->get( 'text' ) ); ?></h2>
			</div>
		</div>
	</div>
</div>