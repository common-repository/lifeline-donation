<?php 
	$mb = webinane_array($config);
	$fields = $mb->get('fields' );
	$meta_id = $mb->get( 'id' );

	$options = (array) get_post_meta(get_the_id(), $meta_id, true);
	$options = array_filter($options) ? $options : ['' => ''];
	$screen = get_current_screen();
?>
<div class="wpcm-metabox-wrapper wpcm-wrapper" meta_id="<?php echo esc_attr( $meta_id) ?>" options='<?php echo wp_json_encode( $options) ?>'>

	<metaboxes
	  screen="<?php echo esc_attr($screen->id) ?>"
	  :id="<?php echo get_the_id() ?>"
	  meta_id="<?php echo esc_attr($meta_id) ?>"
	></metaboxes>
</div>
