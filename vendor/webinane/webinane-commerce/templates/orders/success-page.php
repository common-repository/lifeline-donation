<?php 
$order_label = apply_filters( 'wpcm_order_admin_menu_label', esc_html__( 'Order', 'lifeline-donation' ) )
 ?>
<div class="wpcm-order-success">
	
	<h3><?php printf( esc_html__( '%s Successful', 'lifeline-donation'), $order_label); ?></h3>
	<?php do_action('wpcm_before_order_success_content'); ?>

	<p><?php printf( esc_html__( 'Your %s has been placed successfully, please review the %s below.', 'lifeline-donation' ), $order_label, $order_label ); ?></p>

	<?php //do_action('wpcm_after_order_success_content', $order); ?>
</div>