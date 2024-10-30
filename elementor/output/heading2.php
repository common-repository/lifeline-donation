<?php 
	$html = wp_kses_allowed_html( 'post' );
?>
<div <?php echo wp_kses( $this->get_render_attribute_string( 'wrapper' ), $html ) ?>>
	<div class="wpcm-row">
		<div class="wpcm-col-lg-12">
			<div class="wpcm-heading-style5">
				<h2><?php echo sanitize_text_field( $settings->get( 'text' ) ); ?></h2>
				<span><?php echo sanitize_text_field( $settings->get( 'subtext' ) ); ?></span>
			</div>
		</div>
	</div>
</div>